<?php
namespace App\Models;
use CodeIgniter\Model;
class ProjectMemberModel extends Model{
protected $table='project_members';protected $primaryKey='id';protected $returnType='array';
protected $allowedFields=['project_id','team_member_id','role'];protected $useTimestamps=false;
}