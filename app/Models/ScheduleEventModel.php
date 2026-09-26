<?php
namespace App\Models;
use CodeIgniter\Model;
class ScheduleEventModel extends Model{
protected $table='schedule_events';protected $primaryKey='id';protected $returnType='array';
protected $allowedFields=['project_id','title','description','event_type','start_at','end_at','all_day','location','created_by'];
protected $useTimestamps=true;protected $createdField='created_at';protected $updatedField='updated_at';
}