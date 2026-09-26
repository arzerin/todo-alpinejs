<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\MeetingParticipantModel;
use App\Models\MeetingTranscriptModel;
use App\Models\MeetingDecisionModel;
use App\Models\MeetingActionItemModel;
use App\Models\TaskModel;
use App\Models\TaskAssignmentModel;
use App\Models\ProjectMemberModel;
use App\Services\MeetingIntelligenceService;

class Meetings extends BaseController
{
    private MeetingModel $meetings; private MeetingParticipantModel $participants;
    private MeetingTranscriptModel $transcripts; private MeetingDecisionModel $decisions; private MeetingActionItemModel $actions;
    public function __construct(){ $this->meetings=new MeetingModel(); $this->participants=new MeetingParticipantModel(); $this->transcripts=new MeetingTranscriptModel(); $this->decisions=new MeetingDecisionModel(); $this->actions=new MeetingActionItemModel(); }
    private function input():array{return $this->request->getJSON(true)??[];}
    private function json(array $d,int $s=200){$d['csrfHash']=csrf_hash();return $this->response->setStatusCode($s)->setJSON($d);}
    private function actorId():?int { $id=(int)(session('team_member_id')??0); return $id?:null; }

    public function index(){ $projectId=(int)$this->request->getGet('project_id'); $q=$this->meetings->orderBy('start_at','DESC'); if($projectId)$q->where('project_id',$projectId); return $this->json(['success'=>true,'meetings'=>$q->findAll()]); }
    public function show($id){ $m=$this->meetings->find($id); if(!$m)return $this->json(['success'=>false,'message'=>'Meeting not found.'],404); return $this->json(['success'=>true,'meeting'=>$m,'participants'=>$this->participants->where('meeting_id',$id)->findAll(),'transcripts'=>$this->transcripts->where('meeting_id',$id)->findAll(),'decisions'=>$this->decisions->where('meeting_id',$id)->findAll(),'action_items'=>$this->actions->where('meeting_id',$id)->findAll()]); }
    public function create(){return $this->save(null);}
    public function update($id){return $this->save((int)$id);}
    private function save(?int $id){ $d=$this->input(); $title=trim((string)($d['title']??'')); $pid=(int)($d['project_id']??0); if(!$title||!$pid)return $this->json(['success'=>false,'message'=>'Project and title are required.'],422); $row=['project_id'=>$pid,'title'=>$title,'agenda'=>$d['agenda']??null,'notes'=>$d['notes']??null,'meeting_type'=>$d['meeting_type']??'project','status'=>$d['status']??'scheduled','start_at'=>$d['start_at']??null,'end_at'=>$d['end_at']??null,'location'=>$d['location']??null]; if(!$id)$row['created_by']=$this->actorId(); if($id){if(!$this->meetings->find($id))return $this->json(['success'=>false,'message'=>'Meeting not found.'],404);$this->meetings->update($id,$row);}else{$id=$this->meetings->insert($row,true);} if(array_key_exists('participant_ids',$d))$this->syncParticipants($id,$d['participant_ids']); return $this->json(['success'=>true,'meeting'=>$this->meetings->find($id)],$id?200:201); }
    private function syncParticipants(int $meetingId,array $ids):void { $ids=array_values(array_unique(array_filter(array_map('intval',$ids)))); $this->participants->where('meeting_id',$meetingId)->delete(); foreach($ids as $mid)$this->participants->insert(['meeting_id'=>$meetingId,'team_member_id'=>$mid,'participant_role'=>'attendee','attendance_status'=>'invited','created_at'=>date('Y-m-d H:i:s')]); }
    public function delete($id){if(!$this->meetings->find($id))return $this->json(['success'=>false,'message'=>'Meeting not found.'],404);$this->meetings->delete($id);return $this->json(['success'=>true]);}
    public function saveTranscript($id){if(!$this->meetings->find($id))return $this->json(['success'=>false,'message'=>'Meeting not found.'],404);$d=$this->input();$text=trim((string)($d['transcript_text']??''));if(!$text)return $this->json(['success'=>false,'message'=>'Transcript is required.'],422);$tid=$this->transcripts->insert(['meeting_id'=>$id,'transcript_text'=>$text,'language'=>$d['language']??null,'source_type'=>$d['source_type']??'manual','created_by'=>$this->actorId()],true);return $this->json(['success'=>true,'transcript'=>$this->transcripts->find($tid)],201);}
    public function analyze($id){try{$r=(new MeetingIntelligenceService())->analyze((int)$id,$this->actorId());return $this->json(['success'=>true]+$r);}catch(\Throwable $e){return $this->json(['success'=>false,'message'=>$e->getMessage()],422);}}

    public function reviewAction($meetingId,$actionId){ $a=$this->actions->find($actionId); if(!$a||(int)$a['meeting_id']!==(int)$meetingId)return $this->json(['success'=>false,'message'=>'Action item not found.'],404); $d=$this->input(); $status=$d['status']??''; if(!in_array($status,['accepted','rejected'],true))return $this->json(['success'=>false,'message'=>'Status must be accepted or rejected.'],422); if($status==='rejected'){ $this->actions->update($actionId,['status'=>'rejected','reviewed_by'=>$this->actorId(),'reviewed_at'=>date('Y-m-d H:i:s')]); return $this->json(['success'=>true,'action_item'=>$this->actions->find($actionId)]); }
        $meeting=$this->meetings->find($meetingId); $tasks=new TaskModel(); $assignments=new TaskAssignmentModel(); $projectMembers=new ProjectMemberModel();
        $assignee=(int)($d['assignee_id']??$a['explicit_owner_id']??$a['suggested_assignee_id']??0);
        if($assignee && !$projectMembers->where(['project_id'=>$meeting['project_id'],'team_member_id'=>$assignee])->first()) return $this->json(['success'=>false,'message'=>'Selected assignee is not a member of this project.'],422);
        $taskId=$tasks->insert(['project_id'=>$meeting['project_id'],'category_id'=>$d['category_id']??null,'parent_task_id'=>$d['parent_task_id']??null,'body'=>trim((string)($d['body']??$a['body'])),'due_date'=>$d['due_date']??$a['due_date'],'priority'=>$d['priority']??$a['priority'],'completed'=>0,'source_type'=>'meeting','source_id'=>$meetingId,'ai_generated'=>1,'ai_reason'=>$a['assignment_reason']??null],true);
        if($assignee)$assignments->insert(['task_id'=>$taskId,'team_member_id'=>$assignee,'assigned_at'=>date('Y-m-d H:i:s')]);
        $this->actions->update($actionId,['status'=>'accepted','created_task_id'=>$taskId,'reviewed_by'=>$this->actorId(),'reviewed_at'=>date('Y-m-d H:i:s')]);
        return $this->json(['success'=>true,'task'=>$tasks->find($taskId),'action_item'=>$this->actions->find($actionId)],201);
    }
}
