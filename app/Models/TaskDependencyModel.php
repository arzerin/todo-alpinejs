<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskDependencyModel extends Model
{
    protected $table = 'task_dependencies';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['task_id','depends_on_task_id','dependency_type'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
