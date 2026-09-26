<?php
namespace App\Services;
use App\Models\MeetingModel;
use App\Models\MeetingDecisionModel;
use App\Models\MeetingActionItemModel;

class MeetingIntelligenceService
{
    private OpenAIService $ai; private MeetingContextService $context;
    public function __construct(){ $this->ai=new OpenAIService(); $this->context=new MeetingContextService(); }

    public function analyze(int $meetingId, ?int $actorId=null): array
    {
        $ctx=$this->context->build($meetingId);
        $instruction='You analyze project meetings. Extract only facts supported by agenda, notes and transcript. '
          .'Return JSON keys summary (string), decisions (array of strings), risks (array of strings), action_items (array). '
          .'Each action item: body, details, explicit_owner_id, suggested_assignee_id, due_date YYYY-MM-DD or null, '
          .'priority normal|high|urgent, confidence 0..1, assignment_reason. Explicitly named owners take precedence. '
          .'Otherwise match only eligible project participants using project role, responsibilities, skills, membership, workload/context when available. '
          .'Do not invent decisions, owners or dates. Use null when unsupported.';
        $result=$this->ai->json('meeting.analysis',(int)$ctx['meeting']['project_id'],$instruction,$ctx,
          'Analyze this meeting and propose reviewable decisions, risks and action items. Do not create tasks.', $actorId);
        $data=$result['data']; $runId=(int)$result['run_id'];
        $meetingModel=new MeetingModel();
        $meetingModel->update($meetingId,[
            'ai_summary'=>(string)($data['summary']??''),
            'ai_risks'=>json_encode(array_values($data['risks']??[]),JSON_UNESCAPED_UNICODE),
            'ai_last_run_id'=>$runId
        ]);
        $decisions=new MeetingDecisionModel();
        foreach(($data['decisions']??[]) as $text){ if(trim((string)$text)!=='') $decisions->insert(['meeting_id'=>$meetingId,'decision_text'=>trim((string)$text),'source'=>'ai','ai_run_id'=>$runId,'created_at'=>date('Y-m-d H:i:s')]); }
        $actions=new MeetingActionItemModel(); $created=[];
        foreach(($data['action_items']??[]) as $a){
            $body=trim((string)($a['body']??'')); if($body==='') continue;
            $id=$actions->insert([
                'meeting_id'=>$meetingId,'body'=>$body,'details'=>$a['details']??null,
                'suggested_assignee_id'=>$this->nullableId($a['suggested_assignee_id']??null),
                'explicit_owner_id'=>$this->nullableId($a['explicit_owner_id']??null),
                'due_date'=>$this->dateOrNull($a['due_date']??null),'priority'=>$this->priority($a['priority']??'normal'),
                'confidence'=>$this->confidence($a['confidence']??null),'assignment_reason'=>$a['assignment_reason']??null,
                'status'=>'proposed','ai_run_id'=>$runId
            ],true); $created[]=$actions->find($id);
        }
        return ['run_id'=>$runId,'summary'=>$data['summary']??'','risks'=>$data['risks']??[],'decisions'=>$data['decisions']??[],'action_items'=>$created];
    }
    private function nullableId($v): ?int { $v=(int)$v; return $v>0?$v:null; }
    private function dateOrNull($v): ?string { if(!$v)return null; $d=\DateTime::createFromFormat('Y-m-d',(string)$v); return $d&&$d->format('Y-m-d')===$v?$v:null; }
    private function priority($v): string { return in_array($v,['normal','high','urgent'],true)?$v:'normal'; }
    private function confidence($v): ?float { if(!is_numeric($v))return null; return max(0,min(1,(float)$v)); }
}
