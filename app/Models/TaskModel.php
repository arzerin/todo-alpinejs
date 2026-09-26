<?php
namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table         = 'tasks';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'project_id', 'category_id', 'body', 'assignee',
        'due_date', 'completed', 'priority', 'completed_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getProjectTasks(int $projectId): array
    {
        return $this->where('project_id', $projectId)
            ->orderBy('completed', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}
