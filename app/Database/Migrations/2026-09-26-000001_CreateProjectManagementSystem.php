<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Complete Task / Project Management Foundation
 *
 * Fresh-install migration for:
 * - Projects
 * - Task categories
 * - Tasks
 * - Team members
 * - Project membership
 * - Multi-person task assignments
 * - Schedule events
 * - Activity logs
 *
 * IMPORTANT:
 * This migration is intended for a fresh installation.
 * If the tables already exist in your current development database,
 * back up/migrate the existing data before running this migration.
 */
class CreateProjectManagementSystem extends Migration
{
    public function up()
    {
        // ---------------------------------------------------------------------
        // PROJECTS
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'active',
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('due_date');
        $this->forge->createTable('projects', true);

        // ---------------------------------------------------------------------
        // TASK CATEGORIES
        // Basecamp-style task-list headings.
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('project_id');
        $this->forge->addUniqueKey(['project_id', 'name'], 'uq_project_category');
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE', 'fk_category_project');
        $this->forge->createTable('task_categories', true);

        // ---------------------------------------------------------------------
        // TASKS
        // category_id is nullable: NULL = Uncategorized.
        //
        // The old free-text assignee column is intentionally retained for
        // compatibility with the current Basecamp-style view during Phase 2.
        // Proper assignment is handled by task_assignments.
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'body' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'assignee' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'completed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'priority' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'normal',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('project_id');
        $this->forge->addKey('category_id');
        $this->forge->addKey('completed');
        $this->forge->addKey('due_date');
        $this->forge->addKey(['project_id', 'completed']);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE', 'fk_task_project');
        $this->forge->addForeignKey('category_id', 'task_categories', 'id', 'SET NULL', 'CASCADE', 'fk_task_category');
        $this->forge->createTable('tasks', true);

        // ---------------------------------------------------------------------
        // TEAM MEMBERS
        // photo stores a relative path, e.g. uploads/team/12/avatar.jpg.
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 190,
                'null'       => true,
            ],
            'job_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email', 'uq_team_member_email');
        $this->forge->addKey('status');
        $this->forge->createTable('team_members', true);

        // ---------------------------------------------------------------------
        // PROJECT MEMBERS
        // Which people belong to which projects.
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'team_member_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['project_id', 'team_member_id'], 'uq_project_member');
        $this->forge->addKey('team_member_id');
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE', 'fk_project_member_project');
        $this->forge->addForeignKey('team_member_id', 'team_members', 'id', 'CASCADE', 'CASCADE', 'fk_project_member_person');
        $this->forge->createTable('project_members', true);

        // ---------------------------------------------------------------------
        // TASK ASSIGNMENTS
        // Pivot table allows one task to be assigned to multiple people.
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'task_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'team_member_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'assigned_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['task_id', 'team_member_id'], 'uq_task_assignment');
        $this->forge->addKey('team_member_id');
        $this->forge->addForeignKey('task_id', 'tasks', 'id', 'CASCADE', 'CASCADE', 'fk_assignment_task');
        $this->forge->addForeignKey('team_member_id', 'team_members', 'id', 'CASCADE', 'CASCADE', 'fk_assignment_person');
        $this->forge->createTable('task_assignments', true);

        // ---------------------------------------------------------------------
        // SCHEDULE EVENTS
        // Tasks already have due_date. This table is for meetings, milestones,
        // releases, reminders and other explicit calendar events.
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'event_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'event',
            ],
            'start_at' => [
                'type' => 'DATETIME',
            ],
            'end_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'all_day' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('project_id');
        $this->forge->addKey('start_at');
        $this->forge->addKey(['project_id', 'start_at']);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE', 'fk_schedule_project');
        $this->forge->addForeignKey('created_by', 'team_members', 'id', 'SET NULL', 'CASCADE', 'fk_schedule_creator');
        $this->forge->createTable('schedule_events', true);

        // ---------------------------------------------------------------------
        // ACTIVITY LOGS
        // Flexible audit/activity stream.
        //
        // subject_type examples:
        // project, category, task, team_member, schedule, import
        //
        // action examples:
        // created, updated, completed, reopened, assigned, deleted, imported
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'actor_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'subject_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'subject_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'metadata' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('project_id');
        $this->forge->addKey('actor_id');
        $this->forge->addKey(['subject_type', 'subject_id']);
        $this->forge->addKey(['project_id', 'created_at']);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'SET NULL', 'CASCADE', 'fk_activity_project');
        $this->forge->addForeignKey('actor_id', 'team_members', 'id', 'SET NULL', 'CASCADE', 'fk_activity_actor');
        $this->forge->createTable('activity_logs', true);
    }

    public function down()
    {
        // Drop children before parents because of foreign keys.
        $this->forge->dropTable('activity_logs', true);
        $this->forge->dropTable('schedule_events', true);
        $this->forge->dropTable('task_assignments', true);
        $this->forge->dropTable('project_members', true);
        $this->forge->dropTable('team_members', true);
        $this->forge->dropTable('tasks', true);
        $this->forge->dropTable('task_categories', true);
        $this->forge->dropTable('projects', true);
    }
}
