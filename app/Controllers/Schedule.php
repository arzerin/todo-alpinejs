<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleEventModel;
use App\Models\TaskModel;

class Schedule extends BaseController
{
    protected $events;
    protected $tasks;

    public function __construct()
    {
        $this->events=new ScheduleEventModel();
        $this->tasks=new TaskModel();
    }

    private function json(array $d,int $s=200){$d['csrfHash']=csrf_hash();return $this->response->setStatusCode($s)->setJSON($d);}
    private function input(){return $this->request->getJSON(true)??[];}

    public function index()
    {
        $from=$this->request->getGet('from')?:date('Y-m-01');
        $to=$this->request->getGet('to')?:date('Y-m-t');
        $projectId=(int)$this->request->getGet('project_id');

        $eq=$this->events->select('schedule_events.*,projects.name AS project_name')
            ->join('projects','projects.id=schedule_events.project_id','left')
            ->where('start_at >=',$from.' 00:00:00')->where('start_at <=',$to.' 23:59:59');
        if($projectId)$eq->where('schedule_events.project_id',$projectId);

        $tq=$this->tasks->select('tasks.*,projects.name AS project_name')
            ->join('projects','projects.id=tasks.project_id')
            ->where('due_date >=',$from)->where('due_date <=',$to);
        if($projectId)$tq->where('tasks.project_id',$projectId);

        return $this->json(['success'=>true,'events'=>$eq->orderBy('start_at','ASC')->findAll(),'tasks'=>$tq->orderBy('due_date','ASC')->findAll()]);
    }

    public function create()
    {
        $d=$this->clean($this->input());
        if(!$d['title']||!$d['start_at'])return $this->json(['success'=>false,'message'=>'Title and start date/time are required.'],422);
        $id=$this->events->insert($d,true);
        return $this->json(['success'=>true,'event'=>$this->events->find($id)],201);
    }

    public function update($id)
    {
        if(!$this->events->find($id))return $this->json(['success'=>false,'message'=>'Event not found.'],404);
        $d=$this->clean($this->input());
        if(!$d['title']||!$d['start_at'])return $this->json(['success'=>false,'message'=>'Title and start date/time are required.'],422);
        $this->events->update($id,$d);
        return $this->json(['success'=>true,'event'=>$this->events->find($id)]);
    }

    public function delete($id)
    {
        if(!$this->events->find($id))return $this->json(['success'=>false,'message'=>'Event not found.'],404);
        $this->events->delete($id);return $this->json(['success'=>true]);
    }

    private function clean(array $d)
    {
        $dt=function($v){if(!$v)return null;return str_replace('T',' ',substr($v,0,16)).':00';};
        return [
            'project_id'=>!empty($d['project_id'])?(int)$d['project_id']:null,
            'title'=>trim((string)($d['title']??'')),
            'description'=>trim((string)($d['description']??''))?:null,
            'event_type'=>$d['event_type']??'event',
            'start_at'=>$dt($d['start_at']??null),
            'end_at'=>$dt($d['end_at']??null),
            'all_day'=>!empty($d['all_day'])?1:0,
            'location'=>trim((string)($d['location']??''))?:null,
            'created_by'=>null,
        ];
    }
}
