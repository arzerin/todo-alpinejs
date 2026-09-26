<?php
namespace App\Models;
use CodeIgniter\Model;
class ProjectMilestoneModel extends Model {
    protected $table='project_milestones'; protected $primaryKey='id'; protected $returnType='array';
    protected $allowedFields=['project_id','title','description','target_date','owner_id','status','created_by'];
    protected $useTimestamps=true;
}
