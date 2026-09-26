<?php
namespace App\Models;
use CodeIgniter\Model;
class MeetingTranscriptModel extends Model
{
    protected $table='meeting_transcripts';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['meeting_id','source_file_id','transcript_text','language','source_type','created_by'];
    protected $useTimestamps=true;
    protected $createdField='created_at';
    protected $updatedField='updated_at';
}
