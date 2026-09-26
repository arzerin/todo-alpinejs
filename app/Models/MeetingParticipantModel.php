<?php
namespace App\Models;
use CodeIgniter\Model;
class MeetingParticipantModel extends Model
{
    protected $table='meeting_participants';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['meeting_id','team_member_id','participant_role','attendance_status'];
    protected $useTimestamps=false;
    protected $createdField='created_at';
    protected $updatedField='';
}
