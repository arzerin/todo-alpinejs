<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeamMemberModel;
use App\Models\ProjectMemberModel;
use App\Models\TaskAssignmentModel;
use App\Models\TaskModel;
use App\Models\ProjectModel;
use App\Services\ActivityService;

class Team extends BaseController
{
    protected $members;
    protected $projectMembers;
    protected $assignments;
    protected $tasks;
    protected $projects;
    protected $activity;

    public function __construct()
    {
        $this->members=new TeamMemberModel();
        $this->projectMembers=new ProjectMemberModel();
        $this->assignments=new TaskAssignmentModel();
        $this->tasks=new TaskModel();
        $this->projects=new ProjectModel();
        $this->activity=new ActivityService();
    }

    private function json(array $d,int $s=200){$d['csrfHash']=csrf_hash();return $this->response->setStatusCode($s)->setJSON($d);}
    private function input(){return $this->request->getJSON(true)??[];}

    /** Phase 6: decode a JSON-array or comma/newline separated form value. */
    private function stringList($value): array
    {
        if (is_array($value)) {
            $items = $value;
        } else {
            $raw = trim((string)$value);
            if ($raw === '') return [];
            $decoded = json_decode($raw, true);
            $items = is_array($decoded) ? $decoded : preg_split('/[,\\r\\n]+/', $raw);
        }

        $items = array_map(static fn($v) => trim((string)$v), $items ?: []);
        return array_values(array_unique(array_filter($items, static fn($v) => $v !== '')));
    }

    private function jsonList($value): string
    {
        return json_encode($this->stringList($value), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function index()
    {
        $members=$this->members->orderBy('name','ASC')->findAll();
        foreach($members as &$m){
            $m['projects']=$this->projectMembers->select('projects.id,projects.name,project_members.role,project_members.role_description,project_members.responsibilities')
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

        $data=[
            'name'=>$name,
            'email'=>$email?:null,
            'job_title'=>trim((string)$this->request->getPost('job_title'))?:null,
            'phone'=>trim((string)$this->request->getPost('phone'))?:null,
            'status'=>$this->request->getPost('status')?:'active',
            // Phase 6 — global person intelligence profile.
            'role_description'=>trim((string)$this->request->getPost('role_description'))?:null,
            'skills'=>$this->jsonList($this->request->getPost('skills')),
            'responsibilities'=>$this->jsonList($this->request->getPost('responsibilities')),
            'ai_assignment_enabled'=>$this->request->getPost('ai_assignment_enabled') ? 1 : 0,
        ];

        try{$photo=$this->savePhoto();}catch(\Throwable $e){return $this->json(['success'=>false,'message'=>$e->getMessage()],422);}
        if($photo){if($old)$this->deletePhoto($old['photo']??null);$data['photo']=$photo;}

        if($id){
            $this->members->update($id,$data);
        }else{
            $id=$this->members->insert($data,true);
        }

        $member=$this->members->find($id);

        /*
         * A team member can belong to several projects, so person CRUD itself
         * is logged without a project_id. Project membership changes below are
         * logged against the relevant project.
         */
        if($old){
            $changes=[];
            foreach(['name','email','job_title','phone','status','photo','role_description','skills','responsibilities','ai_assignment_enabled'] as $field){
                if(($old[$field]??null)!=($member[$field]??null)){
                    $changes[$field]=[
                        'from'=>$old[$field]??null,
                        'to'=>$member[$field]??null,
                    ];
                }
            }

            if($changes){
                $this->activity->log(
                    null,
                    'person.updated',
                    'updated a person',
                    'person',
                    (int)$id,
                    [
                        'person'=>$member['name']??$name,
                        'changes'=>$changes,
                    ]
                );
            }
        }else{
            $this->activity->log(
                null,
                'person.created',
                'created a person',
                'person',
                (int)$id,
                ['person'=>$member['name']??$name]
            );
        }

        return $this->json(['success'=>true,'member'=>$member],$old?200:201);
    }

    public function delete($id)
    {
        $m=$this->members->find($id);if(!$m)return $this->json(['success'=>false,'message'=>'Person not found.'],404);

        // Capture memberships before FK cascade/delete removes them.
        $memberships=$this->projectMembers
            ->where('team_member_id',$id)
            ->findAll();

        foreach($memberships as $membership){
            $this->activity->projectMembershipChanged(
                (int)$membership['project_id'],
                'removed',
                (int)$id,
                $m['name']
            );
        }

        $this->activity->log(
            null,
            'person.deleted',
            'deleted a person',
            'person',
            (int)$id,
            ['person'=>$m['name']]
        );

        $this->deletePhoto($m['photo']??null);
        $this->members->delete($id);

        return $this->json(['success'=>true]);
    }

    public function projectMembers($projectId)
    {
        $rows=$this->projectMembers->select('team_members.id,team_members.name,team_members.email,team_members.job_title,team_members.photo,team_members.status,team_members.role_description,team_members.skills,team_members.responsibilities,team_members.ai_assignment_enabled,project_members.role,project_members.role_description AS project_role_description,project_members.responsibilities AS project_responsibilities')
            ->join('team_members','team_members.id=project_members.team_member_id')
            ->where('project_id',$projectId)->orderBy('team_members.name','ASC')->findAll();
        return $this->json(['success'=>true,'members'=>$rows]);
    }

    public function addProjectMember($projectId)
    {
        $d=$this->input();$mid=(int)($d['team_member_id']??0);
        $project=$this->projects->find($projectId);
        $member=$this->members->find($mid);

        if(!$project||!$member)return $this->json(['success'=>false,'message'=>'Invalid project/person.'],422);

        $row=$this->projectMembers->where(['project_id'=>$projectId,'team_member_id'=>$mid])->first();

        if(!$row){
            $this->projectMembers->insert([
                'project_id'=>$projectId,
                'team_member_id'=>$mid,
                'role'=>trim((string)($d['role']??''))?:null,
                'role_description'=>trim((string)($d['role_description']??''))?:null,
                'responsibilities'=>$this->jsonList($d['responsibilities']??[])
            ]);

            $this->activity->projectMembershipChanged(
                (int)$projectId,
                'added',
                $mid,
                $member['name']
            );
        }

        return $this->json(['success'=>true]);
    }

    public function removeProjectMember($projectId,$memberId)
    {
        $row=$this->projectMembers->where(['project_id'=>$projectId,'team_member_id'=>$memberId])->first();
        $member=$this->members->find($memberId);

        if($row){
            $this->projectMembers->delete($row['id']);

            if($member){
                $this->activity->projectMembershipChanged(
                    (int)$projectId,
                    'removed',
                    (int)$memberId,
                    $member['name']
                );
            }
        }

        $ids=array_column($this->tasks->select('id')->where('project_id',$projectId)->findAll(),'id');
        if($ids)$this->assignments->where('team_member_id',$memberId)->whereIn('task_id',$ids)->delete();

        return $this->json(['success'=>true]);
    }

    /**
     * Synchronize all project memberships for one person.
     *
     * Payload:
     * {
     *   "projects": [
     *      {"project_id": 1, "role": "Developer"},
     *      {"project_id": 3, "role": "Consultant"}
     *   ]
     * }
     */
    public function syncMemberProjects($memberId)
    {
        $member=$this->members->find($memberId);
        if(!$member){
            return $this->json(['success'=>false,'message'=>'Person not found.'],404);
        }

        $input=$this->input();
        $requested=$input['projects']??[];
        if(!is_array($requested))$requested=[];

        $wanted=[];

        foreach($requested as $item){
            $projectId=(int)($item['project_id']??0);
            if(!$projectId)continue;

            if(!$this->projects->find($projectId)){
                return $this->json([
                    'success'=>false,
                    'message'=>'One or more selected projects are invalid.'
                ],422);
            }

            $wanted[$projectId]=[
                'role'=>trim((string)($item['role']??''))?:null,
                'role_description'=>trim((string)($item['role_description']??''))?:null,
                'responsibilities'=>$this->jsonList($item['responsibilities']??[]),
            ];
        }

        $existing=$this->projectMembers
            ->where('team_member_id',$memberId)
            ->findAll();

        $existingByProject=[];
        foreach($existing as $row){
            $existingByProject[(int)$row['project_id']]=$row;
        }

        $db=db_connect();
        $db->transStart();

        // Add new memberships and update roles on retained memberships.
        foreach($wanted as $projectId=>$profile){
            if(isset($existingByProject[$projectId])){
                $row=$existingByProject[$projectId];
                $update=[
                    'role'=>$profile['role'],
                    'role_description'=>$profile['role_description'],
                    'responsibilities'=>$profile['responsibilities'],
                ];

                if(($row['role']??null)!=$update['role']
                    || ($row['role_description']??null)!=$update['role_description']
                    || ($row['responsibilities']??'[]')!=$update['responsibilities']){
                    $this->projectMembers->update($row['id'],$update);
                }
            }else{
                $this->projectMembers->insert([
                    'project_id'=>$projectId,
                    'team_member_id'=>$memberId,
                    'role'=>$profile['role'],
                    'role_description'=>$profile['role_description'],
                    'responsibilities'=>$profile['responsibilities']
                ]);

                $this->activity->projectMembershipChanged(
                    $projectId,
                    'added',
                    (int)$memberId,
                    $member['name']
                );
            }
        }

        // Remove memberships that were unchecked. Remove their task assignments
        // inside those projects too, preventing stale invalid assignees.
        foreach($existingByProject as $projectId=>$row){
            if(array_key_exists($projectId,$wanted))continue;

            $taskIds=array_column(
                $this->tasks
                    ->select('id')
                    ->where('project_id',$projectId)
                    ->findAll(),
                'id'
            );

            if($taskIds){
                $this->assignments
                    ->where('team_member_id',$memberId)
                    ->whereIn('task_id',$taskIds)
                    ->delete();
            }

            $this->projectMembers->delete($row['id']);

            $this->activity->projectMembershipChanged(
                $projectId,
                'removed',
                (int)$memberId,
                $member['name']
            );
        }

        $db->transComplete();

        if($db->transStatus()===false){
            return $this->json([
                'success'=>false,
                'message'=>'Unable to update project memberships.'
            ],500);
        }

        $projects=$this->projectMembers
            ->select('projects.id,projects.name,project_members.role,project_members.role_description,project_members.responsibilities')
            ->join('projects','projects.id=project_members.project_id')
            ->where('team_member_id',$memberId)
            ->orderBy('projects.name','ASC')
            ->findAll();

        return $this->json([
            'success'=>true,
            'projects'=>$projects
        ]);
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

        $valid=array_map(
            'intval',
            array_column(
                $this->projectMembers
                    ->select('team_member_id')
                    ->where('project_id',$task['project_id'])
                    ->findAll(),
                'team_member_id'
            )
        );

        foreach($ids as $id){
            if(!in_array($id,$valid,true)){
                return $this->json(['success'=>false,'message'=>'Assignee must belong to project.'],422);
            }
        }

        $beforeMembers=$this->assignments->getTaskMembers($taskId);
        $beforeIds=array_map('intval',array_column($beforeMembers,'id'));
        sort($beforeIds);

        $compareIds=$ids;
        sort($compareIds);

        $db=db_connect();
        $db->transStart();

        $this->assignments->where('task_id',$taskId)->delete();

        foreach($ids as $id){
            $this->assignments->insert([
                'task_id'=>$taskId,
                'team_member_id'=>$id,
                'assigned_at'=>date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if($db->transStatus()===false){
            return $this->json([
                'success'=>false,
                'message'=>'Unable to update task assignees.'
            ],500);
        }

        $members=$this->assignments->getTaskMembers($taskId);

        // Avoid noisy audit records when the same assignee list is saved again.
        if($beforeIds!==$compareIds){
            $this->activity->assignmentChanged(
                (int)$task['project_id'],
                (int)$taskId,
                $task['body'],
                array_map(
                    static fn(array $person)=>[
                        'id'=>(int)$person['id'],
                        'name'=>$person['name'],
                    ],
                    $members
                )
            );

            // Store explicit added/removed people as structured metadata as well.
            $afterIds=array_map('intval',array_column($members,'id'));
            $addedIds=array_values(array_diff($afterIds,$beforeIds));
            $removedIds=array_values(array_diff($beforeIds,$afterIds));

            if($addedIds||$removedIds){
                $beforeById=[];
                foreach($beforeMembers as $person)$beforeById[(int)$person['id']]=$person['name'];

                $afterById=[];
                foreach($members as $person)$afterById[(int)$person['id']]=$person['name'];

                $this->activity->log(
                    (int)$task['project_id'],
                    'task.assignment_delta',
                    'updated task assignment',
                    'task',
                    (int)$taskId,
                    [
                        'task'=>$task['body'],
                        'added'=>array_map(
                            static fn(int $id)=>['id'=>$id,'name'=>$afterById[$id]??''],
                            $addedIds
                        ),
                        'removed'=>array_map(
                            static fn(int $id)=>['id'=>$id,'name'=>$beforeById[$id]??''],
                            $removedIds
                        ),
                    ]
                );
            }
        }

        return $this->json(['success'=>true,'members'=>$members]);
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
