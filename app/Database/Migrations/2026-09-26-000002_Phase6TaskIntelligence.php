<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Phase6TaskIntelligence extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tasks', [
            'parent_task_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
                'after' => 'category_id',
            ],
            'source_type' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => 'manual',
                'after' => 'completed_at',
                'comment' => 'manual|import|ai|meeting|api',
            ],
            'source_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
                'after' => 'source_type',
            ],
            'ai_generated' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'source_id',
            ],
            'ai_reason' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'ai_generated',
            ],
        ]);

        $this->db->query(
            'ALTER TABLE tasks ADD INDEX idx_tasks_parent_task_id (parent_task_id)'
        );

        // Self-reference is useful but intentionally SET NULL so deleting a parent
        // does not destroy its historical subtasks.
        $this->db->query(
            'ALTER TABLE tasks
             ADD CONSTRAINT fk_tasks_parent_task
             FOREIGN KEY (parent_task_id) REFERENCES tasks(id)
             ON DELETE SET NULL'
        );

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'task_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'depends_on_task_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'dependency_type' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => 'blocks',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('task_id');
        $this->forge->addKey('depends_on_task_id');
        $this->forge->addUniqueKey(['task_id', 'depends_on_task_id']);
        $this->forge->addForeignKey('task_id', 'tasks', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('depends_on_task_id', 'tasks', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('task_dependencies', true);
    }

    public function down()
    {
        $this->forge->dropTable('task_dependencies', true);
        $this->db->query('ALTER TABLE tasks DROP FOREIGN KEY fk_tasks_parent_task');
        $this->forge->dropColumn('tasks', [
            'parent_task_id', 'source_type', 'source_id', 'ai_generated', 'ai_reason'
        ]);
    }
}
