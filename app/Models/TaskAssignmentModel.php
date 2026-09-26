<?php
namespace App\Models;
use CodeIgniter\Model;
class TaskAssignmentModel extends Model{
protected $table='task_assignments';protected $primaryKey='id';protected $returnType='array';
protected $allowedFields=['task_id','team_member_id','assigned_at'];protected $useTimestamps=false;
public function getTaskMembers(int $id):array{return $this->select('team_members.id,team_members.name,team_members.email,team_members.job_title,team_members.photo')->join('team_members','team_members.id=task_assignments.team_member_id')->where('task_id',$id)->orderBy('team_members.name','ASC')->findAll();}
}