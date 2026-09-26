<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * TaskModel
 *
 * IMPORTANT:
 * category_id MUST be in $allowedFields.
 *
 * CodeIgniter 4 protects model fields. If category_id is not allowed,
 * CI4 removes it from insert/update data. That causes imported tasks to
 * be stored with category_id = NULL and displayed as "Uncategorized".
 */
class TaskModel extends Model
{
    protected $table      = 'tasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'project_id',
        'category_id',
        'body',
        'assignee',
        'due_date',
        'completed',
    ];

    // created_at is currently handled by MySQL DEFAULT CURRENT_TIMESTAMP.
    protected $useTimestamps = false;

    /**
     * Return tasks belonging to a project.
     */
    public function getProjectTasks(int $projectId): array
    {
        return $this
            ->where('project_id', $projectId)
            ->orderBy('completed', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    /**
     * Return tasks belonging to a specific category.
     */
    public function getCategoryTasks(int $projectId, int $categoryId): array
    {
        return $this
            ->where('project_id', $projectId)
            ->where('category_id', $categoryId)
            ->orderBy('completed', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    /**
     * Return project tasks which do not currently belong to a category.
     */
    public function getUncategorizedTasks(int $projectId): array
    {
        return $this
            ->where('project_id', $projectId)
            ->where('category_id', null)
            ->orderBy('completed', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}
