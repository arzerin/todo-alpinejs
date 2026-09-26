<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MeetingModel;
use App\Models\MeetingFileModel;
use App\Services\ActivityService;
use CodeIgniter\Exceptions\PageNotFoundException;

class MeetingFiles extends BaseController
{
    protected $meetings;
    protected $files;
    protected $activity;

    public function __construct()
    {
        $this->meetings=new MeetingModel();
        $this->files=new MeetingFileModel();
        $this->activity=new ActivityService();
    }

    private function json(array $data,int $status=200)
    {
        $data['csrfHash']=csrf_hash();
        return $this->response->setStatusCode($status)->setJSON($data);
    }

    private function actorId(): ?int
    {
        $id=(int)(session()->get('team_member_id') ?? 0);
        return $id>0 ? $id : null;
    }

    public function index(int $meetingId)
    {
        if(!$this->meetings->find($meetingId)) return $this->json(['success'=>false,'message'=>'Meeting not found.'],404);
        $rows=$this->files
            ->select('meeting_files.*,team_members.name AS uploader_name,team_members.photo AS uploader_photo')
            ->join('team_members','team_members.id=meeting_files.uploaded_by','left')
            ->where('meeting_id',$meetingId)->orderBy('meeting_files.id','DESC')->findAll();
        return $this->json(['success'=>true,'files'=>$rows]);
    }

    public function upload(int $meetingId)
    {
        $meeting=$this->meetings->find($meetingId);
        if(!$meeting) return $this->json(['success'=>false,'message'=>'Meeting not found.'],404);

        $uploads=$this->request->getFiles();
        $incoming=$uploads['files'] ?? [];
        if(!is_array($incoming)) $incoming=[$incoming];

        $allowed=[
            'application/pdf','image/jpeg','image/png','image/webp','text/plain','text/csv',
            'application/zip','application/json',
            'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'audio/mpeg','audio/mp4','audio/x-m4a','audio/wav','video/mp4'
        ];

        $dir=WRITEPATH.'uploads/task_manager/meetings/'.$meetingId;
        if(!is_dir($dir)) mkdir($dir,0775,true);

        $saved=[];
        foreach($incoming as $file){
            if(!$file || $file->getError()===UPLOAD_ERR_NO_FILE) continue;
            if(!$file->isValid()) throw new \RuntimeException($file->getErrorString());
            if($file->getSize()>50*1024*1024) throw new \RuntimeException('Maximum meeting file size is 50 MB.');
            $mime=$file->getMimeType();
            if(!in_array($mime,$allowed,true)) throw new \RuntimeException('This file type is not allowed.');

            $original=basename($file->getClientName());
            $stored=$file->getRandomName();
            $size=$file->getSize();
            $file->move($dir,$stored);

            $id=$this->files->insert([
                'meeting_id'=>$meetingId,'file_name'=>$original,'stored_name'=>$stored,
                'mime_type'=>$mime,'file_size'=>$size,'file_kind'=>'attachment',
                'uploaded_by'=>$this->actorId(),'created_at'=>date('Y-m-d H:i:s')
            ],true);

            $saved[]=['id'=>(int)$id,'file_name'=>$original];
            $this->activity->log(
                (int)$meeting['project_id'],'meeting.file_uploaded','uploaded a meeting file',
                'meeting',$meetingId,['title'=>$meeting['title'],'file'=>$original]
            );
        }

        if(!$saved) return $this->json(['success'=>false,'message'=>'Choose at least one file.'],422);
        return $this->json(['success'=>true,'files'=>$saved],201);
    }

    public function download(int $fileId)
    {
        $row=$this->files->find($fileId);
        if(!$row) throw PageNotFoundException::forPageNotFound('File not found.');
        $path=WRITEPATH.'uploads/task_manager/meetings/'.(int)$row['meeting_id'].'/'.$row['stored_name'];
        if(!is_file($path)) throw PageNotFoundException::forPageNotFound('Stored file not found.');
        return $this->response->download($path,null)->setFileName($row['file_name']);
    }

    public function delete(int $fileId)
    {
        $row=$this->files->find($fileId);
        if(!$row) return $this->json(['success'=>false,'message'=>'File not found.'],404);
        $meeting=$this->meetings->find($row['meeting_id']);
        $path=WRITEPATH.'uploads/task_manager/meetings/'.(int)$row['meeting_id'].'/'.$row['stored_name'];
        if(is_file($path)) @unlink($path);
        $this->files->delete($fileId);
        if($meeting){
            $this->activity->log(
                (int)$meeting['project_id'],'meeting.file_deleted','deleted a meeting file',
                'meeting',(int)$meeting['id'],['title'=>$meeting['title'],'file'=>$row['file_name']]
            );
        }
        return $this->json(['success'=>true]);
    }
}
