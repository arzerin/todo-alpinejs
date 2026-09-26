<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

/**
 * Activity API controller.
 *
 * GET /task-manager/activity
 *
 * Query parameters:
 * - project_id : optional project filter
 * - type       : task|category|person|schedule|project|import
 * - limit      : default 30, maximum 100
 * - offset     : pagination offset
 */
class Activity extends BaseController
{
    protected ActivityLogModel $activity;

    public function __construct()
    {
        $this->activity = new ActivityLogModel();
    }

    public function index()
    {
        $projectId = (int) ($this->request->getGet('project_id') ?? 0);
        $type      = trim((string) ($this->request->getGet('type') ?? ''));
        $limit     = min(max((int) ($this->request->getGet('limit') ?? 30), 1), 100);
        $offset    = max((int) ($this->request->getGet('offset') ?? 0), 0);

        $allowedTypes = [
            'task',
            'category',
            'person',
            'schedule',
            'project',
            'import',
        ];

        if ($type !== '' && ! in_array($type, $allowedTypes, true)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success'  => false,
                'message'  => 'Invalid activity type.',
                'csrfHash' => csrf_hash(),
            ]);
        }

        $rows = $this->activity->feed(
            $projectId ?: null,
            $type ?: null,
            $limit + 1,
            $offset
        );

        $hasMore = count($rows) > $limit;

        if ($hasMore) {
            array_pop($rows);
        }

        return $this->response->setJSON([
            'success'    => true,
            'activities' => $rows,
            'has_more'   => $hasMore,
            'next_offset'=> $offset + count($rows),
            'csrfHash'   => csrf_hash(),
        ]);
    }
}
