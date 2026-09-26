<?php
namespace App\Models;
use CodeIgniter\Model;
class MeetingActionItemModel extends Model
{
    protected $table='meeting_action_items';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['meeting_id','body','details','suggested_assignee_id','explicit_owner_id','due_date','priority','confidence','assignment_reason','status','ai_run_id','created_task_id','reviewed_by','reviewed_at'];
    protected $useTimestamps=true;
    protected $createdField='created_at';
    protected $updatedField='updated_at';
}
