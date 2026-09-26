<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ProjectMilestoneModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProjectPlanning extends BaseController
{
    private ProjectMilestoneModel $milestones;
    public function __construct(){ $this->milestones=new ProjectMilestoneModel(); }

    public function project(int $projectId): ResponseInterface
    {
        $db=db_connect();
        $milestones=$db->table('project_milestones m')
            ->select('m.*,tm.name AS owner_name,COUNT(t.id) AS total_tasks,SUM(CASE WHEN t.completed=1 THEN 1 ELSE 0 END) AS completed_tasks')
            ->join('team_members tm','tm.id=m.owner_id','left')
            ->join('tasks t','t.milestone_id=m.id','left')
            ->where('m.project_id',$projectId)->groupBy('m.id')->orderBy('m.target_date','ASC')->orderBy('m.id','ASC')->get()->getResultArray();

        $tasks=$db->table('tasks')->where('project_id',$projectId)->get()->getResultArray();
        $result=[];
        foreach($tasks as $task){
            $id=(int)$task['id'];
            $deps=$db->table('task_dependencies d')->select('d.depends_on_task_id,t.body,t.completed,t.status')
                ->join('tasks t','t.id=d.depends_on_task_id','inner')->where('d.task_id',$id)->get()->getResultArray();
            $depIds=[];$incomplete=[];
            foreach($deps as $d){
                $depIds[]=(int)$d['depends_on_task_id'];
                $done=((int)($d['completed']??0)===1)||(($d['status']??'')==='done');
                if(!$done)$incomplete[]=$d['body'];
            }
            $milestone=null;
            if(!empty($task['milestone_id']))$milestone=$this->milestones->find((int)$task['milestone_id']);
            $result[(string)$id]=[
                'milestone_id'=>$task['milestone_id']??null,
                'milestone_title'=>$milestone['title']??'',
                'dependency_ids'=>$depIds,
                'dependency_count'=>count($depIds),
                'dependency_waiting'=>count($incomplete)>0?1:0,
                'incomplete_dependency_names'=>$incomplete,
            ];
        }
        return $this->json(['success'=>true,'milestones'=>$milestones,'tasks'=>$result]);
    }

    public function createMilestone(int $projectId): ResponseInterface
    {
        $d=$this->input();$title=trim((string)($d['title']??''));
        if($title==='')return $this->json(['success'=>false,'message'=>'Milestone title is required.'],422);
        $id=$this->milestones->insert(['project_id'=>$projectId,'title'=>$title,'description'=>trim((string)($d['description']??''))?:null,'target_date'=>$d['target_date']??null,'owner_id'=>!empty($d['owner_id'])?(int)$d['owner_id']:null,'status'=>'active','created_by'=>$this->actorId()],true);
        return $this->json(['success'=>true,'milestone'=>$this->milestones->find($id)]);
    }


    public function updateMilestone(int $milestoneId): ResponseInterface
    {
        $m=$this->milestones->find($milestoneId);
        if(!$m)return $this->json(['success'=>false,'message'=>'Milestone not found.'],404);
        $d=$this->input(); $title=trim((string)($d['title']??''));
        if($title==='')return $this->json(['success'=>false,'message'=>'Milestone title is required.'],422);
        $this->milestones->update($milestoneId,[
            'title'=>$title,
            'description'=>trim((string)($d['description']??''))?:null,
            'target_date'=>!empty($d['target_date'])?$d['target_date']:null,
        ]);
        return $this->json(['success'=>true,'milestone'=>$this->milestones->find($milestoneId)]);
    }

    public function updateTaskPlanning(int $taskId): ResponseInterface
    {
        $db=db_connect();$task=$db->table('tasks')->where('id',$taskId)->get()->getRowArray();
        if(!$task)return $this->json(['success'=>false,'message'=>'Task not found.'],404);
        $d=$this->input();$milestoneId=!empty($d['milestone_id'])?(int)$d['milestone_id']:null;
        if($milestoneId){
            $m=$this->milestones->find($milestoneId);
            if(!$m || (int)$m['project_id']!==(int)$task['project_id'])return $this->json(['success'=>false,'message'=>'Invalid milestone for this project.'],422);
        }
        $ids=array_values(array_unique(array_map('intval',$d['dependency_ids']??[])));
        $ids=array_values(array_filter($ids,fn($x)=>$x>0 && $x!==$taskId));
        foreach($ids as $depId){
            $dep=$db->table('tasks')->where('id',$depId)->get()->getRowArray();
            if(!$dep || (int)$dep['project_id']!==(int)$task['project_id'])return $this->json(['success'=>false,'message'=>'Dependencies must belong to the same project.'],422);
            if($this->wouldCreateCycle($taskId,$depId))return $this->json(['success'=>false,'message'=>'Dependency rejected: it would create a circular dependency.'],422);
        }
        $db->transStart();
        $db->table('tasks')->where('id',$taskId)->update(['milestone_id'=>$milestoneId]);
        $db->table('task_dependencies')->where('task_id',$taskId)->delete();
        foreach($ids as $depId){
            $fields=$db->getFieldNames('task_dependencies');
            $row=['task_id'=>$taskId,'depends_on_task_id'=>$depId];
            if(in_array('created_by',$fields,true))$row['created_by']=$this->actorId();
            if(in_array('created_at',$fields,true))$row['created_at']=date('Y-m-d H:i:s');
            $db->table('task_dependencies')->insert($row);
        }
        $db->transComplete();
        if(!$db->transStatus())return $this->json(['success'=>false,'message'=>'Could not save task planning.'],500);
        return $this->json(['success'=>true]);
    }

    private function wouldCreateCycle(int $taskId,int $dependsOn): bool
    {
        if($taskId===$dependsOn)return true;
        $db=db_connect();$seen=[];$stack=[$dependsOn];
        while($stack){
            $current=array_pop($stack);
            if($current===$taskId)return true;
            if(isset($seen[$current]))continue;$seen[$current]=true;
            $rows=$db->table('task_dependencies')->select('depends_on_task_id')->where('task_id',$current)->get()->getResultArray();
            foreach($rows as $r)$stack[]=(int)$r['depends_on_task_id'];
        }
        return false;
    }

    private function actorId():?int{$id=(int)(session()->get('team_member_id')??0);return $id>0?$id:null;}
    private function input():array{return $this->request->getJSON(true)?:$this->request->getPost()?:[];}
    private function json(array $d,int $s=200):ResponseInterface{return $this->response->setStatusCode($s)->setJSON($d);}
}
