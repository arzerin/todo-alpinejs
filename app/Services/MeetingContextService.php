<?php
namespace App\Services;
use App\Models\MeetingModel;
use App\Models\MeetingParticipantModel;
use App\Models\MeetingTranscriptModel;
use App\Models\TeamMemberModel;
use App\Models\ProjectMemberModel;

class MeetingContextService
{
    public function build(int $meetingId): array
    {
        $meetings=new MeetingModel(); $participants=new MeetingParticipantModel();
        $transcripts=new MeetingTranscriptModel(); $people=new TeamMemberModel(); $pm=new ProjectMemberModel();
        $meeting=$meetings->find($meetingId);
        if(!$meeting) throw new \RuntimeException('Meeting not found.');
        $participantRows=$participants->where('meeting_id',$meetingId)->findAll();
        $memberIds=array_map(fn($r)=>(int)$r['team_member_id'],$participantRows);
        $personRows=$memberIds ? $people->whereIn('id',$memberIds)->findAll() : [];
        $byId=[]; foreach($personRows as $p){$byId[(int)$p['id']]=$p;}
        $memberships=$pm->where('project_id',$meeting['project_id'])->findAll();
        $projectRole=[]; foreach($memberships as $r){$projectRole[(int)$r['team_member_id']]=$r;}
        $out=[];
        foreach($participantRows as $r){
            $id=(int)$r['team_member_id']; $p=$byId[$id]??['id'=>$id]; $pr=$projectRole[$id]??[];
            $out[]=[
                'id'=>$id,'name'=>$p['name']??null,'job_title'=>$p['job_title']??null,
                'skills'=>$this->decode($p['skills']??null),'responsibilities'=>$this->decode($p['responsibilities']??null),
                'role_description'=>$p['role_description']??null,'ai_assignment_enabled'=>(int)($p['ai_assignment_enabled']??1),
                'project_role'=>$pr['role']??null,'project_role_description'=>$pr['role_description']??null,
                'project_responsibilities'=>$this->decode($pr['responsibilities']??null),
                'participant_role'=>$r['participant_role']??'attendee'
            ];
        }
        $trs=$transcripts->where('meeting_id',$meetingId)->orderBy('id','ASC')->findAll();
        return ['meeting'=>$meeting,'participants'=>$out,'transcripts'=>array_map(fn($t)=>$t['transcript_text'],$trs)];
    }
    private function decode($v): array
    { if(is_array($v)) return $v; if(!$v) return []; $d=json_decode((string)$v,true); return is_array($d)?$d:array_values(array_filter(array_map('trim',explode(',',(string)$v)))); }
}
