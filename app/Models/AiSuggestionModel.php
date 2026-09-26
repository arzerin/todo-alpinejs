<?php

namespace App\Models;

use CodeIgniter\Model;

class AiSuggestionModel extends Model
{
    protected $table = 'ai_suggestions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'ai_run_id','project_id','suggestion_type','subject_type','subject_id',
        'title','payload','confidence','status','reviewed_by','reviewed_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
