<?php
namespace App\Models;
use CodeIgniter\Model;
class TeamMemberModel extends Model{
protected $table='team_members';protected $primaryKey='id';protected $returnType='array';
protected $allowedFields=['name','email','job_title','phone','photo','status'];
protected $useTimestamps=true;protected $createdField='created_at';protected $updatedField='updated_at';
}