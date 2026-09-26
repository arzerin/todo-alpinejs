<?php
namespace App\Models;
use CodeIgniter\Model;
class MeetingFileModel extends Model
{
    protected $table='meeting_files';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['meeting_id','file_name','stored_name','mime_type','file_size','file_kind','uploaded_by'];
    protected $useTimestamps=false;
    protected $createdField='created_at';
    protected $updatedField='';
}
