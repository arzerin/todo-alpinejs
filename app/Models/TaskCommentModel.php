<?php
namespace App\Models;
use CodeIgniter\Model;

class TaskCommentModel extends Model
{
    protected $table='task_comments';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['task_id','team_member_id','body'];
    protected $useTimestamps=true;
    protected $createdField='created_at';
    protected $updatedField='updated_at';
}
