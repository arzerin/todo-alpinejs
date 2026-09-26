<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class Phase7Meetings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'project_id'=>['type'=>'INT','constraint'=>10,'unsigned'=>true],
            'title'=>['type'=>'VARCHAR','constraint'=>255],
            'agenda'=>['type'=>'LONGTEXT','null'=>true],
            'notes'=>['type'=>'LONGTEXT','null'=>true],
            'meeting_type'=>['type'=>'VARCHAR','constraint'=>40,'default'=>'project'],
            'status'=>['type'=>'VARCHAR','constraint'=>30,'default'=>'scheduled'],
            'start_at'=>['type'=>'DATETIME','null'=>true],
            'end_at'=>['type'=>'DATETIME','null'=>true],
            'location'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'created_by'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'ai_summary'=>['type'=>'LONGTEXT','null'=>true],
            'ai_risks'=>['type'=>'LONGTEXT','null'=>true,'comment'=>'JSON array'],
            'ai_last_run_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true); $this->forge->addKey('project_id'); $this->forge->addKey('start_at');
        $this->forge->addForeignKey('project_id','projects','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('created_by','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('meetings',true);

        $this->forge->addField([
            'id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'meeting_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true],
            'team_member_id'=>['type'=>'INT','constraint'=>10,'unsigned'=>true],
            'participant_role'=>['type'=>'VARCHAR','constraint'=>60,'default'=>'attendee'],
            'attendance_status'=>['type'=>'VARCHAR','constraint'=>30,'default'=>'invited'],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true); $this->forge->addUniqueKey(['meeting_id','team_member_id']);
        $this->forge->addForeignKey('meeting_id','meetings','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('team_member_id','team_members','id','CASCADE','CASCADE');
        $this->forge->createTable('meeting_participants',true);

        $this->forge->addField([
            'id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'meeting_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true],
            'file_name'=>['type'=>'VARCHAR','constraint'=>255],
            'stored_name'=>['type'=>'VARCHAR','constraint'=>255],
            'mime_type'=>['type'=>'VARCHAR','constraint'=>120,'null'=>true],
            'file_size'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'file_kind'=>['type'=>'VARCHAR','constraint'=>30,'default'=>'attachment'],
            'uploaded_by'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true); $this->forge->addKey('meeting_id');
        $this->forge->addForeignKey('meeting_id','meetings','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('uploaded_by','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('meeting_files',true);

        $this->forge->addField([
            'id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'meeting_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true],
            'source_file_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'transcript_text'=>['type'=>'LONGTEXT'],
            'language'=>['type'=>'VARCHAR','constraint'=>20,'null'=>true],
            'source_type'=>['type'=>'VARCHAR','constraint'=>30,'default'=>'manual'],
            'created_by'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true); $this->forge->addKey('meeting_id');
        $this->forge->addForeignKey('meeting_id','meetings','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('source_file_id','meeting_files','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('created_by','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('meeting_transcripts',true);

        $this->forge->addField([
            'id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'meeting_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true],
            'decision_text'=>['type'=>'LONGTEXT'],
            'source'=>['type'=>'VARCHAR','constraint'=>20,'default'=>'manual'],
            'ai_run_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'created_by'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true); $this->forge->addKey('meeting_id');
        $this->forge->addForeignKey('meeting_id','meetings','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('ai_run_id','ai_runs','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('created_by','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('meeting_decisions',true);

        $this->forge->addField([
            'id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'auto_increment'=>true],
            'meeting_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true],
            'body'=>['type'=>'VARCHAR','constraint'=>500],
            'details'=>['type'=>'LONGTEXT','null'=>true],
            'suggested_assignee_id'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'explicit_owner_id'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'due_date'=>['type'=>'DATE','null'=>true],
            'priority'=>['type'=>'VARCHAR','constraint'=>20,'default'=>'normal'],
            'confidence'=>['type'=>'DECIMAL','constraint'=>'5,4','null'=>true],
            'assignment_reason'=>['type'=>'TEXT','null'=>true],
            'status'=>['type'=>'VARCHAR','constraint'=>30,'default'=>'proposed'],
            'ai_run_id'=>['type'=>'BIGINT','constraint'=>20,'unsigned'=>true,'null'=>true],
            'created_task_id'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'reviewed_by'=>['type'=>'INT','constraint'=>10,'unsigned'=>true,'null'=>true],
            'reviewed_at'=>['type'=>'DATETIME','null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true); $this->forge->addKey('meeting_id'); $this->forge->addKey('status');
        $this->forge->addForeignKey('meeting_id','meetings','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('suggested_assignee_id','team_members','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('explicit_owner_id','team_members','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('ai_run_id','ai_runs','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('created_task_id','tasks','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('reviewed_by','team_members','id','SET NULL','CASCADE');
        $this->forge->createTable('meeting_action_items',true);
    }

    public function down()
    {
        $this->forge->dropTable('meeting_action_items',true);
        $this->forge->dropTable('meeting_decisions',true);
        $this->forge->dropTable('meeting_transcripts',true);
        $this->forge->dropTable('meeting_files',true);
        $this->forge->dropTable('meeting_participants',true);
        $this->forge->dropTable('meetings',true);
    }
}
