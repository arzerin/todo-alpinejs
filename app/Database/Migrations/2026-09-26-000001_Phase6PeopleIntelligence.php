<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Phase6PeopleIntelligence extends Migration
{
    public function up()
    {
        // Global person intelligence.
        $this->forge->addColumn('team_members', [
            'role_description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'job_title',
            ],
            'skills' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'role_description',
                'comment' => 'JSON array of skill strings',
            ],
            'responsibilities' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'skills',
                'comment' => 'JSON array of responsibility strings',
            ],
            'ai_assignment_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'after' => 'responsibilities',
            ],
        ]);

        // Project-specific responsibility context.
        $this->forge->addColumn('project_members', [
            'role_description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'role',
            ],
            'responsibilities' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'role_description',
                'comment' => 'JSON array of project-specific responsibilities',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('project_members', ['role_description', 'responsibilities']);
        $this->forge->dropColumn('team_members', [
            'role_description', 'skills', 'responsibilities', 'ai_assignment_enabled'
        ]);
    }
}
