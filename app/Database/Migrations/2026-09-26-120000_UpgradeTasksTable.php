<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpgradeTasksTable extends Migration
{
    public function up()
    {
        /*
         * Add the fields required by the latest TaskModel.
         *
         * Existing fields assumed:
         * id
         * project_id
         * category_id
         * body
         * assignee
         * due_date
         * completed
         * created_at
         */

        $fields = [
            'priority' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'normal',
                'after'      => 'completed',
            ],

            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'priority',
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ],
        ];

        $this->forge->addColumn('tasks', $fields);
    }


    public function down()
    {
        /*
         * Roll back only the fields introduced
         * by this migration.
         */

        $this->forge->dropColumn('tasks', [
            'priority',
            'completed_at',
            'updated_at',
        ]);
    }
}