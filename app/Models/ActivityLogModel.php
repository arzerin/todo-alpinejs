<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * ActivityLogModel
 *
 * Stores the append-only activity/audit stream used by the project manager.
 *
 * Expected table (created in Phase 1):
 * activity_logs:
 * id, project_id, actor_id, subject_type, subject_id,
 * action, description, metadata, created_at
 */
class ActivityLogModel extends Model
{
    protected $table      = 'activity_logs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'project_id',
        'actor_id',
        'subject_type',
        'subject_id',
        'action',
        'description',
        'metadata',
        'created_at',
    ];

    protected $useTimestamps = false;

    /**
     * Return an activity feed with optional project/type filters.
     */
    public function feed(
        ?int $projectId = null,
        ?string $type = null,
        int $limit = 30,
        int $offset = 0
    ): array {
        $builder = $this->select(
                'activity_logs.*, projects.name AS project_name, ' .
                'team_members.name AS actor_name, team_members.photo AS actor_photo'
            )
            ->join('projects', 'projects.id = activity_logs.project_id', 'left')
            ->join('team_members', 'team_members.id = activity_logs.actor_id', 'left');

        if ($projectId) {
            $builder->where('activity_logs.project_id', $projectId);
        }

        if ($type) {
            $builder->where('activity_logs.subject_type', $type);
        }

        $rows = $builder
            ->orderBy('activity_logs.id', 'DESC')
            ->findAll($limit, $offset);

        foreach ($rows as &$row) {
            $decoded = [];

            if (! empty($row['metadata'])) {
                $decoded = json_decode($row['metadata'], true) ?: [];
            }

            $row['metadata'] = $decoded;
        }

        return $rows;
    }
}
