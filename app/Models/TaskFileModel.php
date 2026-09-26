<?php
namespace App\Models;
use CodeIgniter\Model;

class TaskFileModel extends Model
{
    protected $table='task_files';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['task_id','comment_id','file_name','stored_name','mime_type','file_size','uploaded_by','created_at'];
    protected $useTimestamps=false;
}
