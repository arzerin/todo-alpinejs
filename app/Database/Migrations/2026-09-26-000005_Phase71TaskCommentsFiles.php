<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Phase 7.1
 * Task comments + task/comment attachments.
 *
 * Files are stored on disk under writable/uploads/task_manager and only the
 * metadata/path is stored in MySQL.
 */
class Phase71TaskCommentsFiles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'task_id' => ['type'=>'INT','constraint'=>10,'unsigned'=>true],
            'team_member_id' => ['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'body' => ['type'=>'LONGTEXT'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('task_id');
        $this->forge->addKey('team_member_id');
        $this->forge->createTable('task_comments', true);

        $this->forge->addField([
            'id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'task_id' => ['type'=>'INT','constraint'=>10,'unsigned'=>true],
            'comment_id' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'file_name' => ['type'=>'VARCHAR','constraint'=>255],
            'stored_name' => ['type'=>'VARCHAR','constraint'=>255],
            'mime_type' => ['type'=>'VARCHAR','constraint'=>120,'null'=>true],
            'file_size' => ['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'uploaded_by' => ['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('task_id');
        $this->forge->addKey('comment_id');
        $this->forge->addKey('uploaded_by');
        $this->forge->createTable('task_files', true);
    }

    public function down()
    {
        $this->forge->dropTable('task_files', true);
        $this->forge->dropTable('task_comments', true);
    }
}
