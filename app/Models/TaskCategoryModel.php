<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * TaskCategoryModel
 *
 * Categories belong to a project and are used as Basecamp-style
 * task-list sections/headings.
 */
class TaskCategoryModel extends Model
{
    protected $table         = 'task_categories';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';

    protected $allowedFields = [
        'project_id',
        'name',
        'sort_order',
    ];

    // Database currently manages created_at with DEFAULT CURRENT_TIMESTAMP.
    protected $useTimestamps = false;

    /**
     * Return categories for one project in display order.
     */
    public function getProjectCategories(int $projectId): array
    {
        return $this
            ->where('project_id', $projectId)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }
}
