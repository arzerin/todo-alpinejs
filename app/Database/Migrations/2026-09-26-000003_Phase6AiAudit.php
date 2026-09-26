<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Phase6AiAudit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'project_id' => ['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'actor_id' => ['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'feature' => ['type'=>'VARCHAR','constraint'=>60],
            'model' => ['type'=>'VARCHAR','constraint'=>80],
            'status' => ['type'=>'VARCHAR','constraint'=>20,'default'=>'pending'],
            'input_summary' => ['type'=>'TEXT','null'=>true],
            'response_id' => ['type'=>'VARCHAR','constraint'=>120,'null'=>true],
            'usage_input_tokens' => ['type'=>'INT','constraint'=>11,'null'=>true],
            'usage_output_tokens' => ['type'=>'INT','constraint'=>11,'null'=>true],
            'error_message' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'completed_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('project_id');
        $this->forge->addKey('feature');
        $this->forge->addKey('created_at');
        $this->forge->addForeignKey('project_id','projects','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('actor_id','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('ai_runs', true);

        $this->forge->addField([
            'id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'ai_run_id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true],
            'project_id' => ['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'suggestion_type' => ['type'=>'VARCHAR','constraint'=>60],
            'subject_type' => ['type'=>'VARCHAR','constraint'=>60,'null'=>true],
            'subject_id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'title' => ['type'=>'VARCHAR','constraint'=>500,'null'=>true],
            'payload' => ['type'=>'LONGTEXT','null'=>true,'comment'=>'JSON suggestion payload'],
            'confidence' => ['type'=>'DECIMAL','constraint'=>'5,4','null'=>true],
            'status' => ['type'=>'VARCHAR','constraint'=>30,'default'=>'proposed'],
            'reviewed_by' => ['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'reviewed_at' => ['type'=>'DATETIME','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('ai_run_id');
        $this->forge->addKey('project_id');
        $this->forge->addKey('suggestion_type');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('ai_run_id','ai_runs','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('project_id','projects','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('reviewed_by','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('ai_suggestions', true);
    }

    public function down()
    {
        $this->forge->dropTable('ai_suggestions', true);
        $this->forge->dropTable('ai_runs', true);
    }
}
