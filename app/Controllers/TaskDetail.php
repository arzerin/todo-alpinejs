<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TaskModel;
use App\Models\ProjectModel;
use App\Models\TaskCategoryModel;
use App\Models\TaskAssignmentModel;
use App\Models\TaskCommentModel;
use App\Models\TaskFileModel;
use App\Models\TeamMemberModel;
use App\Services\ActivityService;
use CodeIgniter\Exceptions\PageNotFoundException;

class TaskDetail extends BaseController
{
    protected $tasks;
    protected $projects;
    protected $categories;
    protected $assignments;
    protected $comments;
    protected $files;
    protected $members;
    protected $activity;

    public function __construct()
    {
        $this->tasks=new TaskModel();
        $this->projects=new ProjectModel();
        $this->categories=new TaskCategoryModel();
        $this->assignments=new TaskAssignmentModel();
        $this->comments=new TaskCommentModel();
        $this->files=new TaskFileModel();
        $this->members=new TeamMemberModel();
        $this->activity=new ActivityService();
    }

    private function json(array $data,int $status=200)
    {
        $data['csrfHash']=csrf_hash();
        return $this->response->setStatusCode($status)->setJSON($data);
    }

    /**
     * Replace this with your authenticated team-member mapping when login is wired.
     * We accept a session team_member_id first so comments/uploads can identify people.
     */
    private function actorId(): ?int
    {
        $id=(int)(session()->get('team_member_id') ?? 0);
        return $id>0 ? $id : null;
    }

    private function taskOr404(int $id): array
    {
        $task=$this->tasks->find($id);
        if(!$task) throw PageNotFoundException::forPageNotFound('Task not found.');
        return $task;
    }

    public function show(int $id)
    {
        $task=$this->taskOr404($id);
        return view('task_manager/task_detail',[
            'task'=>$task,
            'project'=>$this->projects->find($task['project_id']),
            'category'=>$this->categories->find($task['category_id']),
        ]);
    }

    public function data(int $id)
    {
        $task=$this->taskOr404($id);

        $assignees=$this->assignments
            ->select('team_members.id,team_members.name,team_members.email,team_members.job_title,team_members.photo')
            ->join('team_members','team_members.id=task_assignments.team_member_id')
            ->where('task_assignments.task_id',$id)
            ->orderBy('team_members.name','ASC')->findAll();

        $comments=$this->comments
            ->select('task_comments.*,team_members.name AS person_name,team_members.photo AS person_photo,team_members.job_title AS person_job_title')
            ->join('team_members','team_members.id=task_comments.team_member_id','left')
            ->where('task_comments.task_id',$id)
            ->orderBy('task_comments.id','ASC')->findAll();

        $files=$this->files
            ->select('task_files.*,team_members.name AS uploader_name,team_members.photo AS uploader_photo')
            ->join('team_members','team_members.id=task_files.uploaded_by','left')
            ->where('task_files.task_id',$id)
            ->orderBy('task_files.id','DESC')->findAll();

        foreach($comments as &$comment){
            $comment['files']=array_values(array_filter(
                $files,
                static fn($file)=>isset($file['comment_id']) && (int)$file['comment_id']===(int)$comment['id']
            ));

            // Keep commenter identity together so the view always has the
            // same name/photo pair used by the dashboard People UI.
            $comment['person']=[
                'id'=>(int)($comment['team_member_id'] ?? 0),
                'name'=>$comment['person_name'] ?? 'User',
                'photo'=>$comment['person_photo'] ?? null,
                'job_title'=>$comment['person_job_title'] ?? null,
            ];
        }
        unset($comment);

        return $this->json([
            'success'=>true,
            'task'=>$task,
            'project'=>$this->projects->find($task['project_id']),
            'category'=>$this->categories->find($task['category_id']),
            'assignees'=>$assignees,
            'comments'=>$comments,
            'files'=>$files,
            'current_person'=>$this->actorId() ? $this->members->find($this->actorId()) : null,
        ]);
    }

    public function comment(int $id)
    {
        $task=$this->taskOr404($id);

        /*
         * A multipart request that exceeds PHP post_max_size arrives with
         * BOTH $_POST and $_FILES empty. Detect that first so a large group
         * of attachments does not incorrectly report "Comment is required".
         */
        $contentLength=(int)($_SERVER['CONTENT_LENGTH'] ?? 0);
        $postMaxBytes=$this->iniBytes((string)ini_get('post_max_size'));

        if($contentLength>0 && $postMaxBytes>0 && $contentLength>$postMaxBytes){
            return $this->json([
                'success'=>false,
                'message'=>'The comment and attachments are larger than the server post_max_size ('.ini_get('post_max_size').'). Increase post_max_size/upload_max_filesize or select smaller files.'
            ],413);
        }

        // Normal multipart/FormData field.
        $body=$this->request->getPost('body');

        // Defensive fallback for environments/filters where getPost() does not
        // expose the multipart scalar as expected.
        if($body===null){
            $body=$this->request->getVar('body');
        }

        $body=trim((string)$body);

        if($body===''){
            return $this->json([
                'success'=>false,
                'message'=>'Comment is required.'
            ],422);
        }

        $commentId=$this->comments->insert([
            'task_id'=>$id,
            'team_member_id'=>$this->actorId(),
            'body'=>$body,
        ],true);

        $this->saveUploadedFiles($task,$commentId);

        $this->activity->log(
            (int)$task['project_id'],'task.comment_created','commented on a task',
            'task',(int)$id,['task'=>$task['body'],'comment_id'=>(int)$commentId]
        );

        return $this->json(['success'=>true,'comment_id'=>(int)$commentId],201);
    }

    public function upload(int $id)
    {
        $task=$this->taskOr404($id);
        $saved=$this->saveUploadedFiles($task,null);
        if(!$saved) return $this->json(['success'=>false,'message'=>'Choose at least one file.'],422);
        return $this->json(['success'=>true,'files'=>$saved],201);
    }

    /**
     * Convert PHP shorthand sizes such as 8M, 64M and 1G to bytes.
     */
    private function iniBytes(string $value): int
    {
        $value=trim($value);
        if($value==='') return 0;

        $last=strtolower(substr($value,-1));
        $number=(float)$value;

        switch($last){
            case 'g': $number*=1024;
            case 'm': $number*=1024;
            case 'k': $number*=1024;
        }

        return (int)$number;
    }

    private function saveUploadedFiles(array $task,?int $commentId): array
    {
        $uploads=$this->request->getFiles();
        $incoming=$uploads['files'] ?? [];
        if(!is_array($incoming)) $incoming=[$incoming];

        $allowed=[
            'application/pdf','image/jpeg','image/png','image/webp','text/plain','text/csv',
            'application/zip','application/json',
            'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        $dir=WRITEPATH.'uploads/task_manager/tasks/'.(int)$task['id'];
        if(!is_dir($dir)) mkdir($dir,0775,true);

        $saved=[];
        foreach($incoming as $file){
            if(!$file || $file->getError()===UPLOAD_ERR_NO_FILE) continue;
            if(!$file->isValid()) throw new \RuntimeException($file->getErrorString());
            if($file->getSize()>20*1024*1024) throw new \RuntimeException('Maximum file size is 20 MB.');
            $mime=$file->getMimeType();
            if(!in_array($mime,$allowed,true)) throw new \RuntimeException('This file type is not allowed.');

            $original=basename($file->getClientName());
            $stored=$file->getRandomName();
            $size=$file->getSize();
            $file->move($dir,$stored);

            $fileId=$this->files->insert([
                'task_id'=>(int)$task['id'],
                'comment_id'=>$commentId,
                'file_name'=>$original,
                'stored_name'=>$stored,
                'mime_type'=>$mime,
                'file_size'=>$size,
                'uploaded_by'=>$this->actorId(),
                'created_at'=>date('Y-m-d H:i:s'),
            ],true);

            $saved[]=['id'=>(int)$fileId,'file_name'=>$original];

            $this->activity->log(
                (int)$task['project_id'],'task.file_uploaded','uploaded a file to a task',
                'task',(int)$task['id'],[
                    'task'=>$task['body'],'file'=>$original,'comment_id'=>$commentId
                ]
            );
        }
        return $saved;
    }

    public function download(int $fileId)
    {
        $row=$this->files->find($fileId);
        if(!$row) throw PageNotFoundException::forPageNotFound('File not found.');

        $path=WRITEPATH.'uploads/task_manager/tasks/'.(int)$row['task_id'].'/'.$row['stored_name'];
        if(!is_file($path)) throw PageNotFoundException::forPageNotFound('Stored file not found.');

        return $this->response->download($path,null)->setFileName($row['file_name']);
    }

    public function deleteFile(int $fileId)
    {
        $row=$this->files->find($fileId);
        if(!$row) return $this->json(['success'=>false,'message'=>'File not found.'],404);

        $task=$this->taskOr404((int)$row['task_id']);
        $path=WRITEPATH.'uploads/task_manager/tasks/'.(int)$row['task_id'].'/'.$row['stored_name'];
        if(is_file($path)) @unlink($path);
        $this->files->delete($fileId);

        $this->activity->log(
            (int)$task['project_id'],'task.file_deleted','deleted a task file',
            'task',(int)$task['id'],['task'=>$task['body'],'file'=>$row['file_name']]
        );

        return $this->json(['success'=>true]);
    }
}
