<?php

namespace App\Models;

use CodeIgniter\Model;

class AiRunModel extends Model
{
    protected $table = 'ai_runs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'project_id','actor_id','feature','model','status','input_summary',
        'response_id','usage_input_tokens','usage_output_tokens',
        'error_message','completed_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
