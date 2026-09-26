<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    /**
     * Database table used by this model.
     */
    protected $table = 'projects';

    /**
     * Primary key of the projects table.
     */
    protected $primaryKey = 'id';

    /**
     * Return rows as associative arrays.
     */
    protected $returnType = 'array';

    /**
     * Fields that may be inserted/updated through the model.
     */
    protected $allowedFields = [
        'name',
        'color',
    ];

    /**
     * Your table currently only contains created_at,
     * so automatic CI4 timestamps are disabled.
     */
    protected $useTimestamps = false;


    /**
     * Return all projects.
     *
     * Also returns the number of total, open and completed
     * tasks for each project.
     *
     * @return array
     */
    public function getProjectsWithTaskCounts(): array
    {
        return $this
            ->select("
                projects.id,
                projects.name,
                projects.color,
                projects.created_at,

                COUNT(tasks.id) AS total_tasks,

                SUM(
                    CASE
                        WHEN tasks.completed = 0 THEN 1
                        ELSE 0
                    END
                ) AS open_tasks,

                SUM(
                    CASE
                        WHEN tasks.completed = 1 THEN 1
                        ELSE 0
                    END
                ) AS completed_tasks
            ")
            ->join(
                'tasks',
                'tasks.project_id = projects.id',
                'left'
            )
            ->groupBy([
                'projects.id',
                'projects.name',
                'projects.color',
                'projects.created_at',
            ])
            ->orderBy('projects.name', 'ASC')
            ->findAll();
    }
}