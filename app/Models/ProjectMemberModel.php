<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectMemberModel extends Model
{
    protected $table = 'project_members';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    /*
     * IMPORTANT:
     * Project role description and project responsibilities belong to
     * project_members, not team_members.
     *
     * CodeIgniter silently filters fields that are not in $allowedFields.
     */
    protected $allowedFields = [
        'project_id',
        'team_member_id',
        'role',

        // Phase 6 — project-specific person intelligence
        'role_description',
        'responsibilities',
    ];

    /*
     * Keep this false for the schema used by the project so CI4 does not
     * try to write an updated_at column that project_members does not have.
     */
    protected $useTimestamps = false;
}
