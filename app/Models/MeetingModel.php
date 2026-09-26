<?php
namespace App\Models;
use CodeIgniter\Model;
class MeetingModel extends Model
{
    protected $table='meetings';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['project_id','title','agenda','notes','meeting_type','status','start_at','end_at','location','created_by','ai_summary','ai_risks','ai_last_run_id'];
    protected $useTimestamps=true;
    protected $createdField='created_at';
    protected $updatedField='updated_at';
}
