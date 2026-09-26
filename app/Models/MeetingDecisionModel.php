<?php
namespace App\Models;
use CodeIgniter\Model;
class MeetingDecisionModel extends Model
{
    protected $table='meeting_decisions';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['meeting_id','decision_text','source','ai_run_id','created_by'];
    protected $useTimestamps=false;
    protected $createdField='created_at';
    protected $updatedField='';
}
