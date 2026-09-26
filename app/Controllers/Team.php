<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeamMemberModel;
use App\Models\ProjectMemberModel;
use App\Models\TaskAssignmentModel;
use App\Models\TaskModel;
use App\Models\ProjectModel;

class Team extends BaseController
{
    protected $members;
    protected $projectMembers;
    protected $assignments;
    protected $tasks;
    protected $projects;

    public function __construct()
    {
        $this->members=new TeamMemberModel();
        $this->projectMembers=new ProjectMemberModel();
        $this->assignments=new TaskAssignmentModel();
        $this->tasks=new TaskModel();
        $this->projects=new ProjectModel();
    }

    private function json(array $d,int $s=200){$d['csrfHash']=csrf_hash();return $this->response->setStatusCode($s)->setJSON($d);}
    private function input(){return $this->request->getJSON(true)??[];}

    public function index()
    {
        $members=$this->members->orderBy('name','ASC')->findAll();
        foreach($members as &$m){
            $m['projects']=$this->projectMembers->select('projects.id,projects.name,project_members.role')
                ->join('projects','projects.id=project_members.project_id')
                ->where('team_member_id',$m['id'])->findAll();
            $m['active_task_count']=$this->assignments->join('tasks','tasks.id=task_assignments.task_id')
                ->where('team_member_id',$m['id'])->where('tasks.completed',0)->countAllResults();
        }
        return $this->json(['success'=>true,'members'=>$members]);
    }

    public function create(){return $this->save(null);}
    public function update($id){return $this->save((int)$id);}

    private function save(?int $id)
    {
        $old=$id?$this->members->find($id):null;
        if($id&&!$old)return $this->json(['success'=>false,'message'=>'Person not found.'],404);
        $name=trim((string)$this->request->getPost('name'));
        if(!$name)return $this->json(['success'=>false,'message'=>'Name is required.'],422);

        $email=trim((string)$this->request->getPost('email'));
        if($email){
            $q=$this->members->where('email',$email);
            if($id)$q->where('id !=',$id);
            if($q->first())return $this->json(['success'=>false,'message'=>'Email already exists.'],409);
        }

        $data=['name'=>$name,'email'=>$email?:null,'job_title'=>trim((string)$this->request->getPost('job_title'))?:null,
            'phone'=>trim((string)$this->request->getPost('phone'))?:null,'status'=>$this->request->getPost('status')?:'active'];

        try{$photo=$this->savePhoto();}catch(\Throwable $e){return $this->json(['success'=>false,'message'=>$e->getMessage()],422);}
        if($photo){if($old)$this->deletePhoto($old['photo']??null);$data['photo']=$photo;}

        if($id)$this->members->update($id,$data);else $id=$this->members->insert($data,true);
        return $this->json(['success'=>true,'member'=>$this->members->find($id)],$old?200:201);
    }

    public function delete($id)
    {
        $m=$this->members->find($id);if(!$m)return $this->json(['success'=>false,'message'=>'Person not found.'],404);
        $this->deletePhoto($m['photo']??null);$this->members->delete($id);
        return $this->json(['success'=>true]);
    }

    public function projectMembers($projectId)
    {
        $rows=$this->projectMembers->select('team_members.id,team_members.name,team_members.email,team_members.job_title,team_members.photo,team_members.status,project_members.role')
            ->join('team_members','team_members.id=project_members.team_member_id')
            ->where('project_id',$projectId)->orderBy('team_members.name','ASC')->findAll();
        return $this->json(['success'=>true,'members'=>$rows]);
    }

    public function addProjectMember($projectId)
    {
        $d=$this->input();$mid=(int)($d['team_member_id']??0);
        if(!$this->projects->find($projectId)||!$this->members->find($mid))return $this->json(['success'=>false,'message'=>'Invalid project/person.'],422);
        $row=$this->projectMembers->where(['project_id'=>$projectId,'team_member_id'=>$mid])->first();
        if(!$row)$this->projectMembers->insert(['project_id'=>$projectId,'team_member_id'=>$mid,'role'=>trim((string)($d['role']??''))?:null]);
        return $this->json(['success'=>true]);
    }

    public function removeProjectMember($projectId,$memberId)
    {
        $row=$this->projectMembers->where(['project_id'=>$projectId,'team_member_id'=>$memberId])->first();
        if($row)$this->projectMembers->delete($row['id']);
        $ids=array_column($this->tasks->select('id')->where('project_id',$projectId)->findAll(),'id');
        if($ids)$this->assignments->where('team_member_id',$memberId)->whereIn('task_id',$ids)->delete();
        return $this->json(['success'=>true]);
    }

    public function projectAssignments($projectId)
    {
        $rows=$this->assignments->select('task_assignments.task_id,team_members.id,team_members.name,team_members.email,team_members.job_title,team_members.photo')
            ->join('tasks','tasks.id=task_assignments.task_id')->join('team_members','team_members.id=task_assignments.team_member_id')
            ->where('tasks.project_id',$projectId)->orderBy('team_members.name','ASC')->findAll();
        $out=[];foreach($rows as $r){$tid=$r['task_id'];unset($r['task_id']);$out[$tid][]=$r;}
        return $this->json(['success'=>true,'assignments'=>$out]);
    }

    public function assignTask($taskId)
    {
        $task=$this->tasks->find($taskId);if(!$task)return $this->json(['success'=>false,'message'=>'Task not found.'],404);
        $ids=array_values(array_unique(array_map('intval',$this->input()['team_member_ids']??[])));
        $valid=array_map('intval',array_column($this->projectMembers->select('team_member_id')->where('project_id',$task['project_id'])->findAll(),'team_member_id'));
        foreach($ids as $id)if(!in_array($id,$valid,true))return $this->json(['success'=>false,'message'=>'Assignee must belong to project.'],422);
        $db=db_connect();$db->transStart();$this->assignments->where('task_id',$taskId)->delete();
        foreach($ids as $id)$this->assignments->insert(['task_id'=>$taskId,'team_member_id'=>$id,'assigned_at'=>date('Y-m-d H:i:s')]);
        $db->transComplete();
        return $this->json(['success'=>true,'members'=>$this->assignments->getTaskMembers($taskId)]);
    }

    private function savePhoto()
    {
        $f=$this->request->getFile('photo');if(!$f||$f->getError()===UPLOAD_ERR_NO_FILE)return null;
        if(!$f->isValid())throw new \RuntimeException($f->getErrorString());
        if(!in_array($f->getMimeType(),['image/jpeg','image/png','image/webp'],true))throw new \RuntimeException('Use JPG, PNG or WebP.');
        if($f->getSize()>3145728)throw new \RuntimeException('Maximum photo size is 3 MB.');
        $dir=FCPATH.'uploads/team';if(!is_dir($dir))mkdir($dir,0775,true);
        $name=$f->getRandomName();$f->move($dir,$name);return 'uploads/team/'.$name;
    }
    private function deletePhoto($p){if($p&&is_file(FCPATH.ltrim($p,'/')))@unlink(FCPATH.ltrim($p,'/'));}
}
