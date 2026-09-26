<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;


/*
 * REPLACE IT WHY DOES THE MIGRATION SCRIPT WAS CREATED 
 * 
 * File Created on: 08/29/2022 03:44:am
 * 
 *
 */


class CustomMigration extends Migration
{
	public function up()
	{
				$db = db_connect();

$db->disableForeignKeyChecks();


$this->forge->addField([
     'activity_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'activity_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('activity_type_id');
if ($db->tableExists('activity_types')){
 /* $this->forge->renameTable('activity_types', 'activity_types_CustomMigration'); */
 $this->forge->dropTable('activity_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('activity_types', false, $attributes);




$this->forge->addField([
     'admin_activity_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'email_address' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'page_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'ip_address' => [
          'type' => 'VARCHAR',
          'constraint' => '20',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('admin_activity_id');
if ($db->tableExists('admin_activity')){
 /* $this->forge->renameTable('admin_activity', 'admin_activity_CustomMigration'); */
 $this->forge->dropTable('admin_activity', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('admin_activity', false, $attributes);

$db->query('ALTER TABLE admin_activity ADD UNIQUE KEY `admin_reporting_index` (email_address, page_url, created_at); ');



$this->forge->addField([
     'advertiser_suppression_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'suppression_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'email_address_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'criteria' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('advertiser_suppression_id');
if ($db->tableExists('advertiser_suppression')){
 /* $this->forge->renameTable('advertiser_suppression', 'advertiser_suppression_CustomMigration'); */
 $this->forge->dropTable('advertiser_suppression', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('advertiser_suppression', false, $attributes);

$db->query('ALTER TABLE advertiser_suppression ADD UNIQUE KEY `email_address_id` (email_address_id); ');
$db->query('ALTER TABLE advertiser_suppression ADD UNIQUE KEY `suppression_type_id` (suppression_type_id, criteria); ');



$this->forge->addField([
     'npa' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'state' => [
          'type' => 'CHAR',
          'constraint' => '2',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('npa');
if ($db->tableExists('area_codes')){
 /* $this->forge->renameTable('area_codes', 'area_codes_CustomMigration'); */
 $this->forge->dropTable('area_codes', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('area_codes', false, $attributes);




$this->forge->addField([
     'auth_token' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'valid_end' => [
          'type' => 'DATETIME',
     ],
     'valid_start timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('auth_token');
if ($db->tableExists('auth_tokens')){
 /* $this->forge->renameTable('auth_tokens', 'auth_tokens_CustomMigration'); */
 $this->forge->dropTable('auth_tokens', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('auth_tokens', false, $attributes);




$this->forge->addField([
     'blacklist_alliance_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'auto_increment' => true,
     ],
     'sid' => [
          'type' => 'CHAR',
          'constraint' => '36',
     ],
     'status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'message' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'code' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'offset' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'results' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'wireless' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'scrubs' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'phone_number' => [
          'type' => 'CHAR',
          'constraint' => '10',
          'default' => NULL,
          'null' => true,
     ],
     'carrier' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'state' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'ratecenter' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'country' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('blacklist_alliance_log_id');
if ($db->tableExists('blacklist_alliance_log')){
 /* $this->forge->renameTable('blacklist_alliance_log', 'blacklist_alliance_log_CustomMigration'); */
 $this->forge->dropTable('blacklist_alliance_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('blacklist_alliance_log', false, $attributes);

$db->query('ALTER TABLE blacklist_alliance_log ADD UNIQUE KEY `phone_number` (phone_number); ');
$db->query('ALTER TABLE blacklist_alliance_log ADD UNIQUE KEY `created_at` (created_at); ');



$this->forge->addField([
     'bot_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'auto_increment' => true,
     ],
     'ip_address' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'site_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'referer' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'session_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'hit_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'site_entry_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('bot_id');
if ($db->tableExists('bots')){
 /* $this->forge->renameTable('bots', 'bots_CustomMigration'); */
 $this->forge->dropTable('bots', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('bots', false, $attributes);




$this->forge->addField([
     'calendar_date' => [
          'type' => 'DATE',
     ],
     'full_year' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
          'default' => NULL,
          'null' => true,
     ],
     'quarter' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'month_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'day_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'day_of_week' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'month_name' => [
          'type' => 'VARCHAR',
          'constraint' => '9',
          'default' => NULL,
          'null' => true,
     ],
     'day_name' => [
          'type' => 'VARCHAR',
          'constraint' => '9',
          'default' => NULL,
          'null' => true,
     ],
     'week_number' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'is_weekday' => [
          'type' => 'BINARY',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'is_holiday' => [
          'type' => 'BINARY',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'description' => [
          'type' => 'VARCHAR',
          'constraint' => '32',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('calendar_date');
if ($db->tableExists('calendar_dates')){
 /* $this->forge->renameTable('calendar_dates', 'calendar_dates_CustomMigration'); */
 $this->forge->dropTable('calendar_dates', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('calendar_dates', false, $attributes);




$this->forge->addField([
     'sid' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'internal_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'approval_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'payout_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'payout' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '2',
          'default' => NULL,
          'null' => true,
     ],
     'payout_str' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'payin' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '2',
          'default' => NULL,
          'null' => true,
     ],
     'payin_str' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'unit' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'requests' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'caps' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'recently_viewed' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'contextual' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'multisales' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'click2call' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'host_and_post' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'callserver' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'payperclick' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'crosspub' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'expired' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'currency' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'last_updated timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('sid');
if ($db->tableExists('campaigns')){
 /* $this->forge->renameTable('campaigns', 'campaigns_CustomMigration'); */
 $this->forge->dropTable('campaigns', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('campaigns', false, $attributes);

$db->query('ALTER TABLE campaigns ADD UNIQUE KEY `status` (status); ');



$this->forge->addField([
     'capacity_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'capacity_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('capacity_type_id');
if ($db->tableExists('capacity_types')){
 /* $this->forge->renameTable('capacity_types', 'capacity_types_CustomMigration'); */
 $this->forge->dropTable('capacity_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('capacity_types', false, $attributes);




$this->forge->addField([
     'carrier_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'carrier_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'carrier_group_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => '1',
     ],
]);
$this->forge->addPrimaryKey('carrier_group_id');
if ($db->tableExists('carrier_groups')){
 /* $this->forge->renameTable('carrier_groups', 'carrier_groups_CustomMigration'); */
 $this->forge->dropTable('carrier_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('carrier_groups', false, $attributes);




$this->forge->addField([
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'carrier_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'carrier' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'is_suppressed' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
]);
$this->forge->addPrimaryKey('carrier_id');
if ($db->tableExists('carriers')){
 /* $this->forge->renameTable('carriers', 'carriers_CustomMigration'); */
 $this->forge->dropTable('carriers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('carriers', false, $attributes);




$this->forge->addField([
     'carriers_line_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'carriers_line_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('carriers_line_type_id');
if ($db->tableExists('carriers_line_types')){
 /* $this->forge->renameTable('carriers_line_types', 'carriers_line_types_CustomMigration'); */
 $this->forge->dropTable('carriers_line_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('carriers_line_types', false, $attributes);




$this->forge->addField([
     'id' => [
          'type' => 'VARCHAR',
          'constraint' => '40',
     ],
     'ip_address' => [
          'type' => 'VARCHAR',
          'constraint' => '45',
     ],
     'timestamp' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'data' => [
          'type' => 'BLOB',
     ],
]);
$this->forge->addPrimaryKey('id');
if ($db->tableExists('ci_sessions')){
 /* $this->forge->renameTable('ci_sessions', 'ci_sessions_CustomMigration'); */
 $this->forge->dropTable('ci_sessions', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('ci_sessions', false, $attributes);

$db->query('ALTER TABLE ci_sessions ADD UNIQUE KEY `ci_sessions_timestamp` (timestamp); ');



$this->forge->addField([
     'click_bot_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'ip_address' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'default' => NULL,
          'null' => true,
     ],
     'manager_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'default' => NULL,
          'null' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
          'default' => NULL,
          'null' => true,
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'is_opener' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'group' => [
          'type' => 'VARCHAR',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'cookie_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'referrer' => [
          'type' => 'TEXT',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('click_bot_id');
if ($db->tableExists('click_bots')){
 /* $this->forge->renameTable('click_bots', 'click_bots_CustomMigration'); */
 $this->forge->dropTable('click_bots', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('click_bots', false, $attributes);

$db->query('ALTER TABLE click_bots ADD UNIQUE KEY `ip_address` (ip_address); ');
$db->query('ALTER TABLE click_bots ADD UNIQUE KEY `manager_post_id` (manager_post_id); ');



$this->forge->addField([
     'phone_number' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'first_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'last_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'phone_number_clean' => [
          'type' => 'CHAR',
          'constraint' => '10',
          'default' => NULL,
          'null' => true,
     ],
     'npa' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'nxx' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'line' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
if ($db->tableExists('clickers')){
 /* $this->forge->renameTable('clickers', 'clickers_CustomMigration'); */
 $this->forge->dropTable('clickers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('clickers', false, $attributes);

$db->query("ALTER TABLE clickers ADD PRIMARY KEY (`npa`, `nxx`, `line`); ");
$db->query('ALTER TABLE clickers ADD UNIQUE KEY `phone_number_id` (phone_number_id); ');



$this->forge->addField([
     'clli_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'clli' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('clli_id');
if ($db->tableExists('cllis')){
 /* $this->forge->renameTable('cllis', 'cllis_CustomMigration'); */
 $this->forge->dropTable('cllis', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('cllis', false, $attributes);




$this->forge->addField([
     'variable' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'value' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('variable');
if ($db->tableExists('configuration')){
 /* $this->forge->renameTable('configuration', 'configuration_CustomMigration'); */
 $this->forge->dropTable('configuration', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('configuration', false, $attributes);




$this->forge->addField([
     'consumer_job_status_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'consumer_job_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('consumer_job_status_id');
if ($db->tableExists('consumer_job_statuses')){
 /* $this->forge->renameTable('consumer_job_statuses', 'consumer_job_statuses_CustomMigration'); */
 $this->forge->dropTable('consumer_job_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('consumer_job_statuses', false, $attributes);




$this->forge->addField([
     'consumer_job_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'consumer_job_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('consumer_job_type_id');
if ($db->tableExists('consumer_job_types')){
 /* $this->forge->renameTable('consumer_job_types', 'consumer_job_types_CustomMigration'); */
 $this->forge->dropTable('consumer_job_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('consumer_job_types', false, $attributes);




$this->forge->addField([
     'consumer_job_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'consumer_job_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'content' => [
          'type' => 'TEXT',
     ],
     'output' => [
          'type' => 'TEXT',
     ],
     'output_sent' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'server_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'processed_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('consumer_job_id');
if ($db->tableExists('consumer_jobs')){
 /* $this->forge->renameTable('consumer_jobs', 'consumer_jobs_CustomMigration'); */
 $this->forge->dropTable('consumer_jobs', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('consumer_jobs', false, $attributes);




$this->forge->addField([
     'content_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'field_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'content_length' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'leading_chars' => [
          'type' => 'CHAR',
          'constraint' => '3',
     ],
     'content' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('content_id');
if ($db->tableExists('content')){
 /* $this->forge->renameTable('content', 'content_CustomMigration'); */
 $this->forge->dropTable('content', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('content', false, $attributes);

$db->query('ALTER TABLE content ADD UNIQUE KEY `content_id` (content_id); ');
$db->query('ALTER TABLE content ADD UNIQUE KEY `content_key` (field_id, leading_chars, content_length, content); ');



$this->forge->addField([
     'country_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'auto_increment' => true,
     ],
     'country_code' => [
          'type' => 'VARCHAR',
          'constraint' => '50',
          'default' => NULL,
          'null' => true,
     ],
     'country_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('country_id');
if ($db->tableExists('countries')){
 /* $this->forge->renameTable('countries', 'countries_CustomMigration'); */
 $this->forge->dropTable('countries', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('countries', false, $attributes);




$this->forge->addField([
     'data_service_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'data_service_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
]);
$this->forge->addPrimaryKey('data_service_type_id');
if ($db->tableExists('data_service_types')){
 /* $this->forge->renameTable('data_service_types', 'data_service_types_CustomMigration'); */
 $this->forge->dropTable('data_service_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('data_service_types', false, $attributes);




$this->forge->addField([
     'data_service_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'data_service' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'data_service_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => '1',
     ],
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('data_service_id');
if ($db->tableExists('data_services')){
 /* $this->forge->renameTable('data_services', 'data_services_CustomMigration'); */
 $this->forge->dropTable('data_services', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('data_services', false, $attributes);




$this->forge->addField([
     'phone_number_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
if ($db->tableExists('dedupe_phone_numbers')){
 /* $this->forge->renameTable('dedupe_phone_numbers', 'dedupe_phone_numbers_CustomMigration'); */
 $this->forge->dropTable('dedupe_phone_numbers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('dedupe_phone_numbers', false, $attributes);

$db->query("ALTER TABLE dedupe_phone_numbers ADD PRIMARY KEY (`phone_number_id`, `owner_list_id`, `manager_list_id`); ");



$this->forge->addField([
     'deduplication_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'routing_rule_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('deduplication_group_id');
if ($db->tableExists('deduplication_groups')){
 /* $this->forge->renameTable('deduplication_groups', 'deduplication_groups_CustomMigration'); */
 $this->forge->dropTable('deduplication_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('deduplication_groups', false, $attributes);




$this->forge->addField([
     'domain_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'domain_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('domain_type_id');
if ($db->tableExists('domain_types')){
 /* $this->forge->renameTable('domain_types', 'domain_types_CustomMigration'); */
 $this->forge->dropTable('domain_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('domain_types', false, $attributes);




$this->forge->addField([
     'domain_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'domain' => [
          'type' => 'VARCHAR',
          'constraint' => '128',
          'default' => NULL,
          'null' => true,
     ],
     'domain_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => '1',
     ],
     'domain_owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => '1',
     ],
     'private' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'registar_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'has_ssl' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'check_page' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => '1',
     ],
]);
$this->forge->addPrimaryKey('domain_id');
if ($db->tableExists('domains')){
 /* $this->forge->renameTable('domains', 'domains_CustomMigration'); */
 $this->forge->dropTable('domains', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('domains', false, $attributes);

$db->query('ALTER TABLE domains ADD UNIQUE KEY `domain` (domain); ');



$this->forge->addField([
     'duplicate_email_check_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'email_address_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('duplicate_email_check_log_id');
if ($db->tableExists('duplicate_email_check_log')){
 /* $this->forge->renameTable('duplicate_email_check_log', 'duplicate_email_check_log_CustomMigration'); */
 $this->forge->dropTable('duplicate_email_check_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplicate_email_check_log', false, $attributes);




$this->forge->addField([
     'duplicate_phone_check_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('duplicate_phone_check_log_id');
if ($db->tableExists('duplicate_phone_check_log')){
 /* $this->forge->renameTable('duplicate_phone_check_log', 'duplicate_phone_check_log_CustomMigration'); */
 $this->forge->dropTable('duplicate_phone_check_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplicate_phone_check_log', false, $attributes);




$this->forge->addField([
     'duplication_control_manager_list_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'duplication_control_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('duplication_control_manager_list_group_id');
if ($db->tableExists('duplication_control_manager_list_groups')){
 /* $this->forge->renameTable('duplication_control_manager_list_groups', 'duplication_control_manager_list_groups_CustomMigration'); */
 $this->forge->dropTable('duplication_control_manager_list_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplication_control_manager_list_groups', false, $attributes);




$this->forge->addField([
     'duplication_control_owner_list_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'duplication_control_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'owner_list_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('duplication_control_owner_list_group_id');
if ($db->tableExists('duplication_control_owner_list_groups')){
 /* $this->forge->renameTable('duplication_control_owner_list_groups', 'duplication_control_owner_list_groups_CustomMigration'); */
 $this->forge->dropTable('duplication_control_owner_list_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplication_control_owner_list_groups', false, $attributes);




$this->forge->addField([
     'duplication_control_routing_rule_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'duplication_control_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'routing_rule_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('duplication_control_routing_rule_group_id');
if ($db->tableExists('duplication_control_routing_rule_groups')){
 /* $this->forge->renameTable('duplication_control_routing_rule_groups', 'duplication_control_routing_rule_groups_CustomMigration'); */
 $this->forge->dropTable('duplication_control_routing_rule_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplication_control_routing_rule_groups', false, $attributes);




$this->forge->addField([
     'duplication_control_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'duplication_control_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('duplication_control_type_id');
if ($db->tableExists('duplication_control_types')){
 /* $this->forge->renameTable('duplication_control_types', 'duplication_control_types_CustomMigration'); */
 $this->forge->dropTable('duplication_control_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplication_control_types', false, $attributes);




$this->forge->addField([
     'duplication_control_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'duplication_control' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'duplication_control_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'days' => [
          'type' => 'INT',
          'constraint' => '11',
          'more' => '',
     ],
     'duplication_control_owner_list_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplication_control_routing_rule_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplication_control_manager_list_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('duplication_control_id');
if ($db->tableExists('duplication_controls')){
 /* $this->forge->renameTable('duplication_controls', 'duplication_controls_CustomMigration'); */
 $this->forge->dropTable('duplication_controls', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('duplication_controls', false, $attributes);




$this->forge->addField([
     'email_address_suppression_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'email_address_suppression_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('email_address_suppression_type_id');
if ($db->tableExists('email_address_suppression_types')){
 /* $this->forge->renameTable('email_address_suppression_types', 'email_address_suppression_types_CustomMigration'); */
 $this->forge->dropTable('email_address_suppression_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('email_address_suppression_types', false, $attributes);




$this->forge->addField([
     'email_address_suppression_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'email_address_suppression_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'email_address_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('email_address_suppression_id');
if ($db->tableExists('email_address_suppressions')){
 /* $this->forge->renameTable('email_address_suppressions', 'email_address_suppressions_CustomMigration'); */
 $this->forge->dropTable('email_address_suppressions', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('email_address_suppressions', false, $attributes);




$this->forge->addField([
     'email_address_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'email_address_unique_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('email_address_unique_type_id');
if ($db->tableExists('email_address_unique_types')){
 /* $this->forge->renameTable('email_address_unique_types', 'email_address_unique_types_CustomMigration'); */
 $this->forge->dropTable('email_address_unique_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('email_address_unique_types', false, $attributes);




$this->forge->addField([
     'email_address_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'email_address' => [
          'type' => 'VARCHAR',
          'constraint' => '300',
     ],
     'last_scrubbed' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'scrub_status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'isp_domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'isp_domain_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'md5' => [
          'type' => 'CHAR',
          'constraint' => '32',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('email_address_id');
if ($db->tableExists('email_addresses')){
 /* $this->forge->renameTable('email_addresses', 'email_addresses_CustomMigration'); */
 $this->forge->dropTable('email_addresses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('email_addresses', false, $attributes);

$db->query('ALTER TABLE email_addresses ADD UNIQUE KEY `email_address` (email_address(255)); ');
$db->query('ALTER TABLE email_addresses ADD UNIQUE KEY `isp_domain_group_index` (isp_domain_group_id, isp_domain_id); ');
$db->query('ALTER TABLE email_addresses ADD UNIQUE KEY `md5_index` (md5); ');



$this->forge->addField([
     'dedupe_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'dedupe_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('dedupe_type_id');
if ($db->tableExists('email_dedupe_types')){
 /* $this->forge->renameTable('email_dedupe_types', 'email_dedupe_types_CustomMigration'); */
 $this->forge->dropTable('email_dedupe_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('email_dedupe_types', false, $attributes);




$this->forge->addField([
     'esp_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'esp' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('esp_id');
if ($db->tableExists('esps')){
 /* $this->forge->renameTable('esps', 'esps_CustomMigration'); */
 $this->forge->dropTable('esps', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('esps', false, $attributes);




$this->forge->addField([
     'field_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'field_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'is_common' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'data_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'data_size' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'description' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'filters' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'sample_value' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'clean_method' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'show_in_instructions' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'instruction_order_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'default_in_export' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
]);
$this->forge->addPrimaryKey('field_id');
if ($db->tableExists('fields')){
 /* $this->forge->renameTable('fields', 'fields_CustomMigration'); */
 $this->forge->dropTable('fields', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('fields', false, $attributes);

$db->query('ALTER TABLE fields ADD UNIQUE KEY `unique_field_names` (field_name); ');



$this->forge->addField([
     'log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'firewall_rule_ip' => [
          'type' => 'VARCHAR',
          'constraint' => '25',
     ],
     'firewall_rule_port' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'firewall_rule_protocol' => [
          'type' => 'VARCHAR',
          'constraint' => '10',
     ],
     'firewall_rule_command' => [
          'type' => 'VARCHAR',
          'constraint' => '20',
     ],
     'created_at' => [
          'type' => 'VARCHAR',
          'constraint' => '25',
     ],
     'server_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'action_taken' => [
          'type' => 'VARCHAR',
          'constraint' => '45',
     ],
]);
$this->forge->addPrimaryKey('log_id');
if ($db->tableExists('internal_firewall_rules_log')){
 /* $this->forge->renameTable('internal_firewall_rules_log', 'internal_firewall_rules_log_CustomMigration'); */
 $this->forge->dropTable('internal_firewall_rules_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('internal_firewall_rules_log', false, $attributes);




$this->forge->addField([
     'isp_domain_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'isp_domain_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'username_format' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('isp_domain_group_id');
if ($db->tableExists('isp_domain_groups')){
 /* $this->forge->renameTable('isp_domain_groups', 'isp_domain_groups_CustomMigration'); */
 $this->forge->dropTable('isp_domain_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('isp_domain_groups', false, $attributes);




$this->forge->addField([
     'isp_domain_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'isp_domain_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '10',
     ],
     'isp_domain' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'country_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'corrected_isp_domain' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'tld' => [
          'type' => 'VARCHAR',
          'constraint' => '20',
          'default' => NULL,
          'null' => true,
     ],
     'has_mx' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'is_suppressed' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'suppression_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('isp_domain_id');
if ($db->tableExists('isp_domains')){
 /* $this->forge->renameTable('isp_domains', 'isp_domains_CustomMigration'); */
 $this->forge->dropTable('isp_domains', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('isp_domains', false, $attributes);

$db->query('ALTER TABLE isp_domains ADD UNIQUE KEY `isp_domain_unique` (isp_domain); ');
$db->query('ALTER TABLE isp_domains ADD UNIQUE KEY `isp_domain_group_id` (isp_domain_group_id); ');



$this->forge->addField([
     'key_performance_indicator_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'key_performance_indicator' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('key_performance_indicator_id');
if ($db->tableExists('key_performance_indicators')){
 /* $this->forge->renameTable('key_performance_indicators', 'key_performance_indicators_CustomMigration'); */
 $this->forge->dropTable('key_performance_indicators', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('key_performance_indicators', false, $attributes);




$this->forge->addField([
     'lata_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'lata' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('lata_id');
if ($db->tableExists('latas')){
 /* $this->forge->renameTable('latas', 'latas_CustomMigration'); */
 $this->forge->dropTable('latas', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('latas', false, $attributes);




$this->forge->addField([
     'consumer_job_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'server_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'email_address_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'owner_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'source_domain_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'received_at' => [
          'type' => 'DATETIME',
     ],
     'is_duplicate' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'generated_at' => [
          'type' => 'DATETIME',
     ],
     'routed_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'is_filtered' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
]);
$this->forge->addPrimaryKey('owner_post_id');
if ($db->tableExists('legacy_queue')){
 /* $this->forge->renameTable('legacy_queue', 'legacy_queue_CustomMigration'); */
 $this->forge->dropTable('legacy_queue', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('legacy_queue', false, $attributes);

$db->query('ALTER TABLE legacy_queue ADD UNIQUE KEY `legacy_queue` (email_address_id, owner_list_id, carrier_id, manager_list_id); ');
$db->query('ALTER TABLE legacy_queue ADD UNIQUE KEY `owner_post_id` (owner_post_id, manager_list_id); ');
$db->query('ALTER TABLE legacy_queue ADD UNIQUE KEY `routed_at` (routed_at); ');
$db->query('ALTER TABLE legacy_queue ADD UNIQUE KEY `manager_list_id` (manager_list_id); ');
$db->query('ALTER TABLE legacy_queue ADD UNIQUE KEY `server_id` (server_id); ');
$db->query('ALTER TABLE legacy_queue ADD UNIQUE KEY `consumer_job_id` (consumer_job_id); ');



$this->forge->addField([
     'link_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'activity_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('link_id');
if ($db->tableExists('link_activity')){
 /* $this->forge->renameTable('link_activity', 'link_activity_CustomMigration'); */
 $this->forge->dropTable('link_activity', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('link_activity', false, $attributes);




$this->forge->addField([
     'link_token_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'field_a' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_bin',
          'default' => 'X',
     ],
     'field_b' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_bin',
          'default' => 'X',
     ],
     'field_c' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_bin',
          'default' => 'X',
     ],
     'field_d' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_bin',
          'default' => 'X',
     ],
     'field_e' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_bin',
          'default' => 'X',
     ],
     'field_f' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_bin',
          'default' => 'X',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('link_token_id');
if ($db->tableExists('link_tokens')){
 /* $this->forge->renameTable('link_tokens', 'link_tokens_CustomMigration'); */
 $this->forge->dropTable('link_tokens', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('link_tokens', false, $attributes);

$db->query('ALTER TABLE link_tokens ADD UNIQUE KEY `field_a` (field_a, field_b, field_c, field_d, field_e, field_f); ');



$this->forge->addField([
     'link_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'link_token_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'sms_queue_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'sid' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'manager_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'sent_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('link_id');
if ($db->tableExists('links')){
 /* $this->forge->renameTable('links', 'links_CustomMigration'); */
 $this->forge->dropTable('links', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('links', false, $attributes);




$this->forge->addField([
     'list_category_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'auto_increment' => true,
     ],
     'list_category_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'list_category' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('list_category_id');
if ($db->tableExists('list_categories')){
 /* $this->forge->renameTable('list_categories', 'list_categories_CustomMigration'); */
 $this->forge->dropTable('list_categories', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('list_categories', false, $attributes);




$this->forge->addField([
     'list_category_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'list_category_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('list_category_group_id');
if ($db->tableExists('list_category_groups')){
 /* $this->forge->renameTable('list_category_groups', 'list_category_groups_CustomMigration'); */
 $this->forge->dropTable('list_category_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('list_category_groups', false, $attributes);




$this->forge->addField([
     'lrn_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'lrn' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('lrn_id');
if ($db->tableExists('lrns')){
 /* $this->forge->renameTable('lrns', 'lrns_CustomMigration'); */
 $this->forge->dropTable('lrns', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('lrns', false, $attributes);




$this->forge->addField([
     'manager_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'manager_contact_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'first_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'last_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'phone' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'email' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'password' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'can_download' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'internal_manager' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'send_suppression' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addKey('manager_id', true);
$this->forge->addKey('manager_contact_id', true);
if ($db->tableExists('manager_contacts')){
 /* $this->forge->renameTable('manager_contacts', 'manager_contacts_CustomMigration'); */
 $this->forge->dropTable('manager_contacts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_contacts', false, $attributes);




$this->forge->addField([
     'manager_delivery_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_delivery_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('manager_delivery_type_id');
if ($db->tableExists('manager_delivery_types')){
 /* $this->forge->renameTable('manager_delivery_types', 'manager_delivery_types_CustomMigration'); */
 $this->forge->dropTable('manager_delivery_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_delivery_types', false, $attributes);




$this->forge->addField([
     'manager_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'dedupe_for_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'dedupe_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'more' => '',
     ],
     'unique_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'dedupe_day_range' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
]);
$this->forge->addKey('manager_list_dedupes_log_id', true);
$this->forge->addKey('manager_list_id', true);
if ($db->tableExists('manager_list_dedupes_log')){
 /* $this->forge->renameTable('manager_list_dedupes_log', 'manager_list_dedupes_log_CustomMigration'); */
 $this->forge->dropTable('manager_list_dedupes_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_dedupes_log', false, $attributes);




$this->forge->addField([
     'manager_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'manager_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'child_manager_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
]);
if ($db->tableExists('manager_list_deduping_group')){
 /* $this->forge->renameTable('manager_list_deduping_group', 'manager_list_deduping_group_CustomMigration'); */
 $this->forge->dropTable('manager_list_deduping_group', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_deduping_group', false, $attributes);

$db->query("ALTER TABLE manager_list_deduping_group ADD PRIMARY KEY (`manager_list_dedupes_log_id`, `manager_list_id`, `child_manager_list_id`); ");



$this->forge->addField([
     'manager_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'dedupe_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'more' => '',
     ],
     'unique_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'dedupe_day_range' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
]);
$this->forge->addKey('manager_list_dedupes_log_id', true);
$this->forge->addKey('manager_list_id', true);
if ($db->tableExists('manager_list_email_dedupes_log')){
 /* $this->forge->renameTable('manager_list_email_dedupes_log', 'manager_list_email_dedupes_log_CustomMigration'); */
 $this->forge->dropTable('manager_list_email_dedupes_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_email_dedupes_log', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'manager_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'happened_at timestamp(4) NOT NULL  DEFAULT CURRENT_TIMESTAMP ( 4 ) ON UPDATE CURRENT_TIMESTAMP ( 4 )', 
]);
$this->forge->addKey('manager_list_id', true);
$this->forge->addKey('happened_at', true);
if ($db->tableExists('manager_list_errors')){
 /* $this->forge->renameTable('manager_list_errors', 'manager_list_errors_CustomMigration'); */
 $this->forge->dropTable('manager_list_errors', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_errors', false, $attributes);

$db->query('ALTER TABLE manager_list_errors ADD UNIQUE KEY `manager_list_id` (manager_list_id, manager_post_id); ');



$this->forge->addField([
     'manager_list_export_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'full_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'email_address' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'consumer_job_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('manager_list_export_log_id');
if ($db->tableExists('manager_list_export_logs')){
 /* $this->forge->renameTable('manager_list_export_logs', 'manager_list_export_logs_CustomMigration'); */
 $this->forge->dropTable('manager_list_export_logs', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_export_logs', false, $attributes);

$db->query('ALTER TABLE manager_list_export_logs ADD UNIQUE KEY `manager_list_export_logs_manager_list_id_idx` (manager_list_id); ');



$this->forge->addField([
     'manager_list_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('manager_list_group_id');
if ($db->tableExists('manager_list_groups')){
 /* $this->forge->renameTable('manager_list_groups', 'manager_list_groups_CustomMigration'); */
 $this->forge->dropTable('manager_list_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_groups', false, $attributes);




$this->forge->addField([
     'manager_list_group_manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'day_range' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('manager_list_group_manager_list_id');
if ($db->tableExists('manager_list_groups_manager_lists')){
 /* $this->forge->renameTable('manager_list_groups_manager_lists', 'manager_list_groups_manager_lists_CustomMigration'); */
 $this->forge->dropTable('manager_list_groups_manager_lists', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_groups_manager_lists', false, $attributes);

$db->query('ALTER TABLE manager_list_groups_manager_lists ADD UNIQUE KEY `manager_list_group_id_manager_list_id` (manager_list_group_id, manager_list_id); ');



$this->forge->addField([
     'manager_list_dedupes_log_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'manager_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
]);
if ($db->tableExists('manager_list_manager_deduping_group')){
 /* $this->forge->renameTable('manager_list_manager_deduping_group', 'manager_list_manager_deduping_group_CustomMigration'); */
 $this->forge->dropTable('manager_list_manager_deduping_group', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_manager_deduping_group', false, $attributes);

$db->query("ALTER TABLE manager_list_manager_deduping_group ADD PRIMARY KEY (`manager_list_dedupes_log_id`, `manager_list_id`, `manager_id`); ");



$this->forge->addField([
     'manager_list_outbound_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_outbound_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('manager_list_outbound_type_id');
if ($db->tableExists('manager_list_outbound_types')){
 /* $this->forge->renameTable('manager_list_outbound_types', 'manager_list_outbound_types_CustomMigration'); */
 $this->forge->dropTable('manager_list_outbound_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_outbound_types', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'manager_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'response_time' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '5',
          'default' => NULL,
          'null' => true,
     ],
     'happened_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addKey('manager_list_id', true);
$this->forge->addKey('happened_at', true);
if ($db->tableExists('manager_list_performance')){
 /* $this->forge->renameTable('manager_list_performance', 'manager_list_performance_CustomMigration'); */
 $this->forge->dropTable('manager_list_performance', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_performance', false, $attributes);

$db->query('ALTER TABLE manager_list_performance ADD UNIQUE KEY `manager_list_id` (manager_list_id, manager_post_id); ');



$this->forge->addField([
     'manager_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'dedupe_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'more' => '',
     ],
     'unique_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'dedupe_day_range' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
]);
$this->forge->addKey('manager_list_dedupes_log_id', true);
$this->forge->addKey('manager_list_id', true);
if ($db->tableExists('manager_list_phone_dedupes_log')){
 /* $this->forge->renameTable('manager_list_phone_dedupes_log', 'manager_list_phone_dedupes_log_CustomMigration'); */
 $this->forge->dropTable('manager_list_phone_dedupes_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_phone_dedupes_log', false, $attributes);




$this->forge->addField([
     'manager_list_post_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_post_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('manager_list_post_type_id');
if ($db->tableExists('manager_list_post_types')){
 /* $this->forge->renameTable('manager_list_post_types', 'manager_list_post_types_CustomMigration'); */
 $this->forge->dropTable('manager_list_post_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_post_types', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'month' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'year' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'revenue' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '2',
          'unsigned' => true,
     ],
     'report_date' => [
          'type' => 'DATE',
          'default' => NULL,
          'null' => true,
     ],
]);
if ($db->tableExists('manager_list_revenue')){
 /* $this->forge->renameTable('manager_list_revenue', 'manager_list_revenue_CustomMigration'); */
 $this->forge->dropTable('manager_list_revenue', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_revenue', false, $attributes);

$db->query("ALTER TABLE manager_list_revenue ADD PRIMARY KEY (`manager_list_id`, `owner_list_id`, `month`, `year`); ");
$db->query('ALTER TABLE manager_list_revenue ADD UNIQUE KEY `manager_revenue_manager_list_id_index` (manager_list_id); ');
$db->query('ALTER TABLE manager_list_revenue ADD UNIQUE KEY `manager_revenue_month_index` (month); ');
$db->query('ALTER TABLE manager_list_revenue ADD UNIQUE KEY `manager_revenue_revenue_index` (revenue); ');
$db->query('ALTER TABLE manager_list_revenue ADD UNIQUE KEY `report_date` (report_date); ');
$db->query('ALTER TABLE manager_list_revenue ADD UNIQUE KEY `manager_list_id` (manager_list_id, report_date); ');
$db->query('ALTER TABLE manager_list_revenue ADD UNIQUE KEY `reporting_index` (report_date, revenue); ');



$this->forge->addField([
     'manager_list_status_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('manager_list_status_id');
if ($db->tableExists('manager_list_statuses')){
 /* $this->forge->renameTable('manager_list_statuses', 'manager_list_statuses_CustomMigration'); */
 $this->forge->dropTable('manager_list_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_statuses', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'transformation_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'field_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('manager_list_transformations')){
 /* $this->forge->renameTable('manager_list_transformations', 'manager_list_transformations_CustomMigration'); */
 $this->forge->dropTable('manager_list_transformations', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_list_transformations', false, $attributes);

$db->query("ALTER TABLE manager_list_transformations ADD PRIMARY KEY (`manager_list_id`, `transformation_id`, `field_id`); ");



$this->forge->addField([
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'manager_list' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'manager_list_outbound_type_idX' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'manager_delivery_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '2',
     ],
     'server_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'list_category_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'list_category_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'email_address_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'unique_days_email' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'phone_number_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'unique_days_phone' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'openers_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'esp_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'esp_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'shortcode' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'keyword' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'welcome_message' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'scrub_posts' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'last_scrubbed_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'scrub_days_relevant' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'allow_duplicates' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'allow_seeds' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'enhance_posts' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'min_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'max_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'daily_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'total_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'auto_load' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'post_delay' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'post_timeout' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '30',
     ],
     'post_type' => [
          'type' => 'VARCHAR',
          'constraint' => '24',
          'default' => NULL,
          'null' => true,
     ],
     'post_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'post_header' => [
          'type' => 'TEXT',
     ],
     'post_referer' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'ping_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'variable_data' => [
          'type' => 'VARCHAR',
          'constraint' => '2048',
          'default' => NULL,
          'null' => true,
     ],
     'ping_data' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'remote_directory' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'remote_port' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'password' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'ping_accept' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'ping_reject' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'success_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'error_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'duplicate_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'reject_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'note' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('manager_list_id');
if ($db->tableExists('manager_lists')){
 /* $this->forge->renameTable('manager_lists', 'manager_lists_CustomMigration'); */
 $this->forge->dropTable('manager_lists', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_lists', false, $attributes);




$this->forge->addField([
     'manager_list_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'change' => [
          'type' => 'TEXT',
     ],
     'notes' => [
          'type' => 'TEXT',
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('manager_list_log_id');
if ($db->tableExists('manager_lists_log')){
 /* $this->forge->renameTable('manager_lists_log', 'manager_lists_log_CustomMigration'); */
 $this->forge->dropTable('manager_lists_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_lists_log', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'manager_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'manager_list' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'server_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'list_category_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'list_category_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'openers_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'esp_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'esp_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'manager_delivery_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '2',
     ],
     'scrub_posts' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'last_scrubbed_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'scrub_days_relevant' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'allow_duplicates' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'email_address_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'more' => '',
     ],
     'phone_number_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'more' => '',
     ],
     'allow_seeds' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'enhance_posts' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'min_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'max_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'daily_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'total_capacity' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'auto_load' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'post_delay' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'post_timeout' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '30',
     ],
     'post_type' => [
          'type' => 'VARCHAR',
          'constraint' => '24',
          'default' => NULL,
          'null' => true,
     ],
     'post_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'post_header' => [
          'type' => 'TEXT',
     ],
     'post_referer' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'ping_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'variable_data' => [
          'type' => 'VARCHAR',
          'constraint' => '2048',
          'default' => NULL,
          'null' => true,
     ],
     'ping_data' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'remote_directory' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'remote_port' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'password' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'ping_accept' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'ping_reject' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'success_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'error_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'duplicate_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'reject_text' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
if ($db->tableExists('manager_lists_new')){
 /* $this->forge->renameTable('manager_lists_new', 'manager_lists_new_CustomMigration'); */
 $this->forge->dropTable('manager_lists_new', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_lists_new', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'reason' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('manager_list_id');
if ($db->tableExists('manager_lists_to_exclude')){
 /* $this->forge->renameTable('manager_lists_to_exclude', 'manager_lists_to_exclude_CustomMigration'); */
 $this->forge->dropTable('manager_lists_to_exclude', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_lists_to_exclude', false, $attributes);




$this->forge->addField([
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
]);
$this->forge->addKey('manager_list_id', true);
$this->forge->addKey('carrier_group_id', true);
if ($db->tableExists('manager_lists_x_carrier_groups')){
 /* $this->forge->renameTable('manager_lists_x_carrier_groups', 'manager_lists_x_carrier_groups_CustomMigration'); */
 $this->forge->dropTable('manager_lists_x_carrier_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_lists_x_carrier_groups', false, $attributes);




$this->forge->addField([
     'manager_post_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'curl_output' => [
          'type' => 'TEXT',
     ],
     'curl_error' => [
          'type' => 'TEXT',
     ],
     'variable_data' => [
          'type' => 'TEXT',
     ],
     'response_time' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '5',
          'default' => '0.00000',
     ],
     'line_number' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'file' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'line' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'function' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'args' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('manager_post_log_id');
if ($db->tableExists('manager_post_logs')){
 /* $this->forge->renameTable('manager_post_logs', 'manager_post_logs_CustomMigration'); */
 $this->forge->dropTable('manager_post_logs', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_post_logs', false, $attributes);

$db->query('ALTER TABLE manager_post_logs ADD UNIQUE KEY `manager_post_id` (manager_post_id); ');
$db->query('ALTER TABLE manager_post_logs ADD UNIQUE KEY `manager_list_id` (manager_list_id); ');
$db->query('ALTER TABLE manager_post_logs ADD UNIQUE KEY `created_at` (created_at); ');
$db->query('ALTER TABLE manager_post_logs ADD UNIQUE KEY `created_at_2` (created_at, manager_list_id, status_id); ');



$this->forge->addField([
     'manager_post_status_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_post_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('manager_post_status_id');
if ($db->tableExists('manager_post_statuses')){
 /* $this->forge->renameTable('manager_post_statuses', 'manager_post_statuses_CustomMigration'); */
 $this->forge->dropTable('manager_post_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_post_statuses', false, $attributes);




$this->forge->addField([
     'manager_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'owner_list_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'manager_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '9',
     ],
     'scheduled_time' => [
          'type' => 'DATETIME',
     ],
     'scrub_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'subscriber_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'email_address_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'phone_number_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'generated_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'server_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'posted_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'http_status' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'response_time' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '5',
     ],
     'manager_post_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('manager_post_id');
if ($db->tableExists('manager_posts')){
 /* $this->forge->renameTable('manager_posts', 'manager_posts_CustomMigration'); */
 $this->forge->dropTable('manager_posts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('manager_posts', false, $attributes);

$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `UPDATE_IDX` (manager_post_id, manager_post_status_id, scheduled_time); ');
$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `available_data_by_generated_at_index` (manager_post_status_id, manager_list_id, generated_at); ');
$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `duplicate_owner_post_check` (manager_list_id, owner_post_id); ');
$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `duplicate_email_index` (email_address_id, manager_list_id, created_at); ');
$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `created_at_index` (created_at); ');
$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `subscriber_status_id` (subscriber_status_id); ');
$db->query('ALTER TABLE manager_posts ADD UNIQUE KEY `duplicate_phone_number_index` (phone_number_id, manager_list_id, created_at); ');



$this->forge->addField([
     'manager_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'company' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'internal_manager' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'rate_limit' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('manager_id');
if ($db->tableExists('managers')){
 /* $this->forge->renameTable('managers', 'managers_CustomMigration'); */
 $this->forge->dropTable('managers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('managers', false, $attributes);




$this->forge->addField([
     'navigation_item_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'navigation_section_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'user_role_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'icon' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'page_title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'page_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('navigation_item_id');
if ($db->tableExists('navigation_items')){
 /* $this->forge->renameTable('navigation_items', 'navigation_items_CustomMigration'); */
 $this->forge->dropTable('navigation_items', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('navigation_items', false, $attributes);




$this->forge->addField([
     'navigation_item_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'navigation_section_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'user_role_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'page_title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'page_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('navigation_item_id');
if ($db->tableExists('navigation_items_old')){
 /* $this->forge->renameTable('navigation_items_old', 'navigation_items_old_CustomMigration'); */
 $this->forge->dropTable('navigation_items_old', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('navigation_items_old', false, $attributes);




$this->forge->addField([
     'navigation_item_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'navigation_section_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'user_role_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'icon' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'page_title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'page_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('navigation_item_id');
if ($db->tableExists('navigation_items_zerin')){
 /* $this->forge->renameTable('navigation_items_zerin', 'navigation_items_zerin_CustomMigration'); */
 $this->forge->dropTable('navigation_items_zerin', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('navigation_items_zerin', false, $attributes);




$this->forge->addField([
     'navigation_section_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'icon' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'section_title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'section_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addPrimaryKey('navigation_section_id');
if ($db->tableExists('navigation_sections')){
 /* $this->forge->renameTable('navigation_sections', 'navigation_sections_CustomMigration'); */
 $this->forge->dropTable('navigation_sections', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('navigation_sections', false, $attributes);




$this->forge->addField([
     'navigation_section_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'section_title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'section_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addPrimaryKey('navigation_section_id');
if ($db->tableExists('navigation_sections_old')){
 /* $this->forge->renameTable('navigation_sections_old', 'navigation_sections_old_CustomMigration'); */
 $this->forge->dropTable('navigation_sections_old', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('navigation_sections_old', false, $attributes);




$this->forge->addField([
     'navigation_section_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'icon' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'section_title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'section_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addPrimaryKey('navigation_section_id');
if ($db->tableExists('navigation_sections_zerin')){
 /* $this->forge->renameTable('navigation_sections_zerin', 'navigation_sections_zerin_CustomMigration'); */
 $this->forge->dropTable('navigation_sections_zerin', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('navigation_sections_zerin', false, $attributes);




$this->forge->addField([
     'notification_queue_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'link_token_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'campaign_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'notification_message' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'notification_icon_file_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'notification_image_file_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'notification_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'send_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'website' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'created_by' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('notification_queue_id');
if ($db->tableExists('notification_queue')){
 /* $this->forge->renameTable('notification_queue', 'notification_queue_CustomMigration'); */
 $this->forge->dropTable('notification_queue', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('notification_queue', false, $attributes);




$this->forge->addField([
     'area_code' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'time_zone' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'region' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('area_code');
if ($db->tableExists('npa_x_timezones')){
 /* $this->forge->renameTable('npa_x_timezones', 'npa_x_timezones_CustomMigration'); */
 $this->forge->dropTable('npa_x_timezones', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('npa_x_timezones', false, $attributes);




$this->forge->addField([
     'ocn_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'ocn' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('ocn_id');
if ($db->tableExists('ocns')){
 /* $this->forge->renameTable('ocns', 'ocns_CustomMigration'); */
 $this->forge->dropTable('ocns', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('ocns', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'manager_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'manager_post_status_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('olap_manager_post_counts')){
 /* $this->forge->renameTable('olap_manager_post_counts', 'olap_manager_post_counts_CustomMigration'); */
 $this->forge->dropTable('olap_manager_post_counts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_manager_post_counts', false, $attributes);

$db->query("ALTER TABLE olap_manager_post_counts ADD PRIMARY KEY (`report_date`, `owner_id`, `owner_list_id`, `manager_id`, `manager_list_id`, `source_domain_id`, `carrier_id`, `carrier_group_id`, `manager_post_status_id`); ");



$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_accepts')){
 /* $this->forge->renameTable('olap_owner_post_accepts', 'olap_owner_post_accepts_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_accepts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_accepts', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'email_address_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'phone_number_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'duplicate_phone_number_count_list' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplicate_phone_number_count_global' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplicate_email_address_count_list' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplicate_email_address_count_global' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'suppressed_email_address_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'suppressed_phone_number_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
if ($db->tableExists('olap_owner_post_counts')){
 /* $this->forge->renameTable('olap_owner_post_counts', 'olap_owner_post_counts_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_counts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_counts', false, $attributes);

$db->query("ALTER TABLE olap_owner_post_counts ADD PRIMARY KEY (`report_date`, `owner_id`, `owner_list_id`, `source_domain_id`, `carrier_group_id`, `carrier_id`); ");



$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_email_address_suppressed')){
 /* $this->forge->renameTable('olap_owner_post_email_address_suppressed', 'olap_owner_post_email_address_suppressed_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_email_address_suppressed', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_email_address_suppressed', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_email_addresses')){
 /* $this->forge->renameTable('olap_owner_post_email_addresses', 'olap_owner_post_email_addresses_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_email_addresses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_email_addresses', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_endpoint')){
 /* $this->forge->renameTable('olap_owner_post_endpoint', 'olap_owner_post_endpoint_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_endpoint', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_endpoint', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_over_quota')){
 /* $this->forge->renameTable('olap_owner_post_over_quota', 'olap_owner_post_over_quota_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_over_quota', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_over_quota', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'carrier_line_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplicate_count_list' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'duplicate_count_global' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'suppressed_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
if ($db->tableExists('olap_owner_post_phone_number_counts')){
 /* $this->forge->renameTable('olap_owner_post_phone_number_counts', 'olap_owner_post_phone_number_counts_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_phone_number_counts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_phone_number_counts', false, $attributes);

$db->query("ALTER TABLE olap_owner_post_phone_number_counts ADD PRIMARY KEY (`report_date`, `owner_id`, `owner_list_id`, `source_domain_id`, `carrier_id`, `carrier_line_type_id`); ");



$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_phone_number_global_duplicate')){
 /* $this->forge->renameTable('olap_owner_post_phone_number_global_duplicate', 'olap_owner_post_phone_number_global_duplicate_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_phone_number_global_duplicate', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_phone_number_global_duplicate', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_phone_number_list_duplicate')){
 /* $this->forge->renameTable('olap_owner_post_phone_number_list_duplicate', 'olap_owner_post_phone_number_list_duplicate_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_phone_number_list_duplicate', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_phone_number_list_duplicate', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_phone_number_suppressed')){
 /* $this->forge->renameTable('olap_owner_post_phone_number_suppressed', 'olap_owner_post_phone_number_suppressed_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_phone_number_suppressed', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_phone_number_suppressed', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_phone_numbers')){
 /* $this->forge->renameTable('olap_owner_post_phone_numbers', 'olap_owner_post_phone_numbers_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_phone_numbers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_phone_numbers', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_rejects')){
 /* $this->forge->renameTable('olap_owner_post_rejects', 'olap_owner_post_rejects_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_rejects', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_rejects', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_routed')){
 /* $this->forge->renameTable('olap_owner_post_routed', 'olap_owner_post_routed_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_routed', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_routed', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('olap_owner_post_scrubbed_out')){
 /* $this->forge->renameTable('olap_owner_post_scrubbed_out', 'olap_owner_post_scrubbed_out_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_scrubbed_out', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_scrubbed_out', false, $attributes);




$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'validation_error' => [
          'type' => 'VARCHAR',
          'constraint' => '190',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('olap_owner_post_scrubber_errors')){
 /* $this->forge->renameTable('olap_owner_post_scrubber_errors', 'olap_owner_post_scrubber_errors_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_scrubber_errors', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_scrubber_errors', false, $attributes);

$db->query("ALTER TABLE olap_owner_post_scrubber_errors ADD PRIMARY KEY (`report_date`, `owner_list_id`, `validation_error`); ");



$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'validation_error' => [
          'type' => 'VARCHAR',
          'constraint' => '190',
     ],
     'gross_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('olap_owner_post_validation_errors')){
 /* $this->forge->renameTable('olap_owner_post_validation_errors', 'olap_owner_post_validation_errors_CustomMigration'); */
 $this->forge->dropTable('olap_owner_post_validation_errors', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('olap_owner_post_validation_errors', false, $attributes);

$db->query("ALTER TABLE olap_owner_post_validation_errors ADD PRIMARY KEY (`report_date`, `owner_list_id`, `validation_error`); ");



$this->forge->addField([
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'owner_contact_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'first_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'last_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'phone' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'email' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'password' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'can_download' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'internal_owner' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'send_suppression' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addKey('owner_id', true);
$this->forge->addKey('owner_contact_id', true);
if ($db->tableExists('owner_contacts')){
 /* $this->forge->renameTable('owner_contacts', 'owner_contacts_CustomMigration'); */
 $this->forge->dropTable('owner_contacts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_contacts', false, $attributes);




$this->forge->addField([
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'list_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'daily_cap' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('owner_list_id');
if ($db->tableExists('owner_list_caps')){
 /* $this->forge->renameTable('owner_list_caps', 'owner_list_caps_CustomMigration'); */
 $this->forge->dropTable('owner_list_caps', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_caps', false, $attributes);




$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'recorded_at' => [
          'type' => 'DATE',
     ],
     'age' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'records' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('owner_list_data_age')){
 /* $this->forge->renameTable('owner_list_data_age', 'owner_list_data_age_CustomMigration'); */
 $this->forge->dropTable('owner_list_data_age', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_data_age', false, $attributes);

$db->query("ALTER TABLE owner_list_data_age ADD PRIMARY KEY (`owner_list_id`, `source_domain_id`, `recorded_at`, `age`); ");



$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'recorded_at' => [
          'type' => 'DATE',
     ],
     'hour' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'records' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('owner_list_data_hourly')){
 /* $this->forge->renameTable('owner_list_data_hourly', 'owner_list_data_hourly_CustomMigration'); */
 $this->forge->dropTable('owner_list_data_hourly', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_data_hourly', false, $attributes);

$db->query("ALTER TABLE owner_list_data_hourly ADD PRIMARY KEY (`owner_list_id`, `hour`, `recorded_at`); ");



$this->forge->addField([
     'owner_list_dedupe_group_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'data' => [
          'type' => 'TEXT',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_list_dedupe_group_log_id');
if ($db->tableExists('owner_list_dedupe_group_log')){
 /* $this->forge->renameTable('owner_list_dedupe_group_log', 'owner_list_dedupe_group_log_CustomMigration'); */
 $this->forge->dropTable('owner_list_dedupe_group_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_dedupe_group_log', false, $attributes);




$this->forge->addField([
     'owner_list_dedupe_group_x_owner_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_dedupe_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'dedupe_days' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_list_dedupe_group_x_owner_list_id');
if ($db->tableExists('owner_list_dedupe_group_x_owner_lists')){
 /* $this->forge->renameTable('owner_list_dedupe_group_x_owner_lists', 'owner_list_dedupe_group_x_owner_lists_CustomMigration'); */
 $this->forge->dropTable('owner_list_dedupe_group_x_owner_lists', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_dedupe_group_x_owner_lists', false, $attributes);

$db->query('ALTER TABLE owner_list_dedupe_group_x_owner_lists ADD UNIQUE KEY `owner_list_id` (owner_list_id); ');



$this->forge->addField([
     'owner_list_dedupe_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_dedupe_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_list_dedupe_group_id');
if ($db->tableExists('owner_list_dedupe_groups')){
 /* $this->forge->renameTable('owner_list_dedupe_groups', 'owner_list_dedupe_groups_CustomMigration'); */
 $this->forge->dropTable('owner_list_dedupe_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_dedupe_groups', false, $attributes);




$this->forge->addField([
     'owner_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'dedupe_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'dedupe_day_range' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('owner_list_dedupes_log_id', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('owner_list_dedupes_log')){
 /* $this->forge->renameTable('owner_list_dedupes_log', 'owner_list_dedupes_log_CustomMigration'); */
 $this->forge->dropTable('owner_list_dedupes_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_dedupes_log', false, $attributes);




$this->forge->addField([
     'owner_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'child_owner_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
]);
if ($db->tableExists('owner_list_deduping_group')){
 /* $this->forge->renameTable('owner_list_deduping_group', 'owner_list_deduping_group_CustomMigration'); */
 $this->forge->dropTable('owner_list_deduping_group', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_deduping_group', false, $attributes);

$db->query("ALTER TABLE owner_list_deduping_group ADD PRIMARY KEY (`owner_list_dedupes_log_id`, `owner_list_id`, `child_owner_list_id`); ");



$this->forge->addField([
     'owner_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'dedupe_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'more' => '',
     ],
     'unique_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'dedupe_day_range' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addKey('owner_list_dedupes_log_id', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('owner_list_email_dedupes_log')){
 /* $this->forge->renameTable('owner_list_email_dedupes_log', 'owner_list_email_dedupes_log_CustomMigration'); */
 $this->forge->dropTable('owner_list_email_dedupes_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_email_dedupes_log', false, $attributes);




$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'field_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'recorded_at' => [
          'type' => 'DATE',
     ],
     'field_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('owner_list_field_counts')){
 /* $this->forge->renameTable('owner_list_field_counts', 'owner_list_field_counts_CustomMigration'); */
 $this->forge->dropTable('owner_list_field_counts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_field_counts', false, $attributes);

$db->query("ALTER TABLE owner_list_field_counts ADD PRIMARY KEY (`owner_list_id`, `field_id`, `recorded_at`); ");



$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'field_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'is_required' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addKey('owner_list_id', true);
$this->forge->addKey('field_id', true);
if ($db->tableExists('owner_list_fields')){
 /* $this->forge->renameTable('owner_list_fields', 'owner_list_fields_CustomMigration'); */
 $this->forge->dropTable('owner_list_fields', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_fields', false, $attributes);




$this->forge->addField([
     'owner_list_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('owner_list_group_id');
if ($db->tableExists('owner_list_groups')){
 /* $this->forge->renameTable('owner_list_groups', 'owner_list_groups_CustomMigration'); */
 $this->forge->dropTable('owner_list_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_groups', false, $attributes);




$this->forge->addField([
     'owner_list_group_owner_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'day_range' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('owner_list_group_owner_list_id');
if ($db->tableExists('owner_list_groups_owner_lists')){
 /* $this->forge->renameTable('owner_list_groups_owner_lists', 'owner_list_groups_owner_lists_CustomMigration'); */
 $this->forge->dropTable('owner_list_groups_owner_lists', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_groups_owner_lists', false, $attributes);

$db->query('ALTER TABLE owner_list_groups_owner_lists ADD UNIQUE KEY `owner_list_group_id_owner_list_id` (owner_list_group_id, owner_list_id); ');



$this->forge->addField([
     'owner_list_import_file_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'default' => NULL,
          'null' => true,
     ],
     'received_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'sftp_host' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'from_ip' => [
          'type' => 'VARCHAR',
          'constraint' => '60',
          'default' => NULL,
          'null' => true,
     ],
     'list_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'filesize' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'filename' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'pid' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'processed_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'process_status' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'records_received' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'records_processed' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'accept' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'duplicate' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'reject' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'error' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'updated_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
          'more' => '',
     ],
]);
$this->forge->addPrimaryKey('owner_list_import_file_id');
if ($db->tableExists('owner_list_import_files')){
 /* $this->forge->renameTable('owner_list_import_files', 'owner_list_import_files_CustomMigration'); */
 $this->forge->dropTable('owner_list_import_files', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_import_files', false, $attributes);

$db->query('ALTER TABLE owner_list_import_files ADD UNIQUE KEY `owner_list_import_files_owner_list_id_idx` (owner_list_id); ');
$db->query('ALTER TABLE owner_list_import_files ADD UNIQUE KEY `owner_list_import_files_list_key_idx` (list_key); ');
$db->query('ALTER TABLE owner_list_import_files ADD UNIQUE KEY `owner_list_import_files_process_status_idx` (process_status); ');
$db->query('ALTER TABLE owner_list_import_files ADD UNIQUE KEY `owner_list_import_files_pid_idx` (pid); ');



$this->forge->addField([
     'owner_list_dedupes_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'dedupe_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => '1',
          'more' => '',
     ],
     'unique_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'dedupe_day_range' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addKey('owner_list_dedupes_log_id', true);
$this->forge->addKey('owner_list_id', true);
if ($db->tableExists('owner_list_phone_dedupes_log')){
 /* $this->forge->renameTable('owner_list_phone_dedupes_log', 'owner_list_phone_dedupes_log_CustomMigration'); */
 $this->forge->dropTable('owner_list_phone_dedupes_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_phone_dedupes_log', false, $attributes);




$this->forge->addField([
     'owner_list_scrub_status_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_scrub_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('owner_list_scrub_status_id');
if ($db->tableExists('owner_list_scrub_statuses')){
 /* $this->forge->renameTable('owner_list_scrub_statuses', 'owner_list_scrub_statuses_CustomMigration'); */
 $this->forge->dropTable('owner_list_scrub_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_scrub_statuses', false, $attributes);




$this->forge->addField([
     'owner_list_sftp_account_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'list_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'auto_import' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'sftp_password' => [
          'type' => 'VARCHAR',
          'constraint' => '24',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('owner_list_sftp_account_id');
if ($db->tableExists('owner_list_sftp_accounts')){
 /* $this->forge->renameTable('owner_list_sftp_accounts', 'owner_list_sftp_accounts_CustomMigration'); */
 $this->forge->dropTable('owner_list_sftp_accounts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_sftp_accounts', false, $attributes);

$db->query('ALTER TABLE owner_list_sftp_accounts ADD UNIQUE KEY `owner_list_sftp_accounts_owner_list_id_uidx` (owner_list_id); ');



$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'source_domain_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '9',
     ],
     'field_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'recorded_at' => [
          'type' => 'DATE',
     ],
     'field_count' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('owner_list_source_domain_field_counts')){
 /* $this->forge->renameTable('owner_list_source_domain_field_counts', 'owner_list_source_domain_field_counts_CustomMigration'); */
 $this->forge->dropTable('owner_list_source_domain_field_counts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_source_domain_field_counts', false, $attributes);

$db->query("ALTER TABLE owner_list_source_domain_field_counts ADD PRIMARY KEY (`owner_list_id`, `source_domain_id`, `field_id`, `recorded_at`); ");



$this->forge->addField([
     'owner_list_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('owner_list_status_id');
if ($db->tableExists('owner_list_statuses')){
 /* $this->forge->renameTable('owner_list_statuses', 'owner_list_statuses_CustomMigration'); */
 $this->forge->dropTable('owner_list_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_list_statuses', false, $attributes);




$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'owner_list' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'list_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'list_category_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'primary_source_domain_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'wildcard_authorized' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'country_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'enforce_country' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'email_address_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'phone_number_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'scrub_posts' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'revenue_share_percentage' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'max_broker_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'daily_cap' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'price_per_accept' => [
          'type' => 'DOUBLE',
          'constraint' => '10,2',
          'default' => '0.00',
     ],
     'dump_incoming' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('owner_list_id');
if ($db->tableExists('owner_lists')){
 /* $this->forge->renameTable('owner_lists', 'owner_lists_CustomMigration'); */
 $this->forge->dropTable('owner_lists', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_lists', false, $attributes);

$db->query('ALTER TABLE owner_lists ADD UNIQUE KEY `list_key` (list_key); ');



$this->forge->addField([
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'owner_list' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'list_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'list_category_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'primary_source_domain_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'wildcard_authorized' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'country_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'enforce_country' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'email_address_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'phone_number_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '1',
     ],
     'scrub_posts' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'revenue_share_percentage' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'max_broker_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'daily_cap' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'price_per_accept' => [
          'type' => 'DOUBLE',
          'constraint' => '10,2',
          'default' => '0.00',
     ],
     'dump_incoming' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('owner_list_id');
if ($db->tableExists('owner_lists_copy')){
 /* $this->forge->renameTable('owner_lists_copy', 'owner_lists_copy_CustomMigration'); */
 $this->forge->dropTable('owner_lists_copy', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_lists_copy', false, $attributes);

$db->query('ALTER TABLE owner_lists_copy ADD UNIQUE KEY `list_key` (list_key); ');



$this->forge->addField([
     'owner_list_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
          'default' => NULL,
          'null' => true,
     ],
     'change' => [
          'type' => 'TEXT',
     ],
     'notes' => [
          'type' => 'TEXT',
     ],
     'user_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_list_log_id');
if ($db->tableExists('owner_lists_log')){
 /* $this->forge->renameTable('owner_lists_log', 'owner_lists_log_CustomMigration'); */
 $this->forge->dropTable('owner_lists_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_lists_log', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'field_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'content_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
]);
$this->forge->addKey('owner_post_id', true);
$this->forge->addKey('field_id', true);
if ($db->tableExists('owner_post_data')){
 /* $this->forge->renameTable('owner_post_data', 'owner_post_data_CustomMigration'); */
 $this->forge->dropTable('owner_post_data', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_post_data', false, $attributes);




$this->forge->addField([
     'owner_post_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'message' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_post_log_id');
if ($db->tableExists('owner_post_log')){
 /* $this->forge->renameTable('owner_post_log', 'owner_post_log_CustomMigration'); */
 $this->forge->dropTable('owner_post_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_post_log', false, $attributes);

$db->query('ALTER TABLE owner_post_log ADD UNIQUE KEY `owner_post_id` (owner_post_id); ');
$db->query('ALTER TABLE owner_post_log ADD UNIQUE KEY `owner_list_id` (owner_list_id); ');



$this->forge->addField([
     'owner_post_reject_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'reject_reasons' => [
          'type' => 'TEXT',
          'character_set' => 'utf8',
     ],
     'data' => [
          'type' => 'TEXT',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_post_reject_log_id');
if ($db->tableExists('owner_post_reject_log')){
 /* $this->forge->renameTable('owner_post_reject_log', 'owner_post_reject_log_CustomMigration'); */
 $this->forge->dropTable('owner_post_reject_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_post_reject_log', false, $attributes);




$this->forge->addField([
     'owner_post_reject_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'reject_reasons' => [
          'type' => 'TEXT',
          'character_set' => 'utf8',
     ],
     'data' => [
          'type' => 'TEXT',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
if ($db->tableExists('owner_post_reject_log_blanks')){
 /* $this->forge->renameTable('owner_post_reject_log_blanks', 'owner_post_reject_log_blanks_CustomMigration'); */
 $this->forge->dropTable('owner_post_reject_log_blanks', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_post_reject_log_blanks', false, $attributes);




$this->forge->addField([
     'owner_post_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_post_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('owner_post_status_id');
if ($db->tableExists('owner_post_statuses')){
 /* $this->forge->renameTable('owner_post_statuses', 'owner_post_statuses_CustomMigration'); */
 $this->forge->dropTable('owner_post_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_post_statuses', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'email_address_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'carrier_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'scrub_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'post_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'route_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'generated_at' => [
          'type' => 'DATETIME',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_post_id');
if ($db->tableExists('owner_posts')){
 /* $this->forge->renameTable('owner_posts', 'owner_posts_CustomMigration'); */
 $this->forge->dropTable('owner_posts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_posts', false, $attributes);

$db->query('ALTER TABLE owner_posts ADD UNIQUE KEY `email_address_index` (email_address_id); ');
$db->query('ALTER TABLE owner_posts ADD UNIQUE KEY `phone_number_index` (phone_number_id); ');
$db->query('ALTER TABLE owner_posts ADD UNIQUE KEY `owner_list_id_index` (owner_list_id); ');
$db->query('ALTER TABLE owner_posts ADD UNIQUE KEY `processor` (post_status_id, route_status_id); ');



$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'gross' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
]);
if ($db->tableExists('owner_posts_carrier_group_counts')){
 /* $this->forge->renameTable('owner_posts_carrier_group_counts', 'owner_posts_carrier_group_counts_CustomMigration'); */
 $this->forge->dropTable('owner_posts_carrier_group_counts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_posts_carrier_group_counts', false, $attributes);

$db->query("ALTER TABLE owner_posts_carrier_group_counts ADD PRIMARY KEY (`report_date`, `owner_list_id`, `carrier_group_id`); ");



$this->forge->addField([
     'owner_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('owner_status_id');
if ($db->tableExists('owner_statuses')){
 /* $this->forge->renameTable('owner_statuses', 'owner_statuses_CustomMigration'); */
 $this->forge->dropTable('owner_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owner_statuses', false, $attributes);




$this->forge->addField([
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'company' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'internal_owner' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'default_cr_cost' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '2',
          'default' => NULL,
          'null' => true,
     ],
     'owner_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_id');
if ($db->tableExists('owners')){
 /* $this->forge->renameTable('owners', 'owners_CustomMigration'); */
 $this->forge->dropTable('owners', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('owners', false, $attributes);




$this->forge->addField([
     'dedupe_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'dedupe_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('dedupe_type_id');
if ($db->tableExists('phone_dedupe_types')){
 /* $this->forge->renameTable('phone_dedupe_types', 'phone_dedupe_types_CustomMigration'); */
 $this->forge->dropTable('phone_dedupe_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_dedupe_types', false, $attributes);




$this->forge->addField([
     'phone_metadata_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'state_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'rate_center_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'country_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'clli_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'lata_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'lrn_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'wireless' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'ocn_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('phone_metadata_id');
if ($db->tableExists('phone_metadata')){
 /* $this->forge->renameTable('phone_metadata', 'phone_metadata_CustomMigration'); */
 $this->forge->dropTable('phone_metadata', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_metadata', false, $attributes);




$this->forge->addField([
     'phone_number_suppression_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'phone_number_suppression_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('phone_number_suppression_type_id');
if ($db->tableExists('phone_number_suppression_types')){
 /* $this->forge->renameTable('phone_number_suppression_types', 'phone_number_suppression_types_CustomMigration'); */
 $this->forge->dropTable('phone_number_suppression_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_number_suppression_types', false, $attributes);




$this->forge->addField([
     'phone_number_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'phone_number_suppression_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'occurances' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('phone_number_id');
if ($db->tableExists('phone_number_suppressions')){
 /* $this->forge->renameTable('phone_number_suppressions', 'phone_number_suppressions_CustomMigration'); */
 $this->forge->dropTable('phone_number_suppressions', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_number_suppressions', false, $attributes);




$this->forge->addField([
     'phone_number_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('phone_number_type_id');
if ($db->tableExists('phone_number_types')){
 /* $this->forge->renameTable('phone_number_types', 'phone_number_types_CustomMigration'); */
 $this->forge->dropTable('phone_number_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_number_types', false, $attributes);




$this->forge->addField([
     'phone_number_unique_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number_unique_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('phone_number_unique_type_id');
if ($db->tableExists('phone_number_unique_types')){
 /* $this->forge->renameTable('phone_number_unique_types', 'phone_number_unique_types_CustomMigration'); */
 $this->forge->dropTable('phone_number_unique_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_number_unique_types', false, $attributes);




$this->forge->addField([
     'phone_number_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'carrier_line_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'npa' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'nxx' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'line' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'is_valid' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => '1',
     ],
     'is_suppressed' => [
          'type' => 'TINYINT',
          'constraint' => '1',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
]);
$this->forge->addPrimaryKey('phone_number_id');
if ($db->tableExists('phone_numbers')){
 /* $this->forge->renameTable('phone_numbers', 'phone_numbers_CustomMigration'); */
 $this->forge->dropTable('phone_numbers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('phone_numbers', false, $attributes);

$db->query('ALTER TABLE phone_numbers ADD UNIQUE KEY `npa` (npa, nxx, line); ');



$this->forge->addField([
     'platform_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'platform_account_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'platform_account' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'api_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'platform_phone_number' => [
          'type' => 'VARCHAR',
          'constraint' => '16',
          'default' => NULL,
          'null' => true,
     ],
]);
if ($db->tableExists('platform_accounts')){
 /* $this->forge->renameTable('platform_accounts', 'platform_accounts_CustomMigration'); */
 $this->forge->dropTable('platform_accounts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('platform_accounts', false, $attributes);




$this->forge->addField([
     'platform_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'platform' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('platform_id');
if ($db->tableExists('platforms')){
 /* $this->forge->renameTable('platforms', 'platforms_CustomMigration'); */
 $this->forge->dropTable('platforms', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('platforms', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'posted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('owner_post_id');
if ($db->tableExists('post_master')){
 /* $this->forge->renameTable('post_master', 'post_master_CustomMigration'); */
 $this->forge->dropTable('post_master', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('post_master', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
]);
if ($db->tableExists('posts_to_delete')){
 /* $this->forge->renameTable('posts_to_delete', 'posts_to_delete_CustomMigration'); */
 $this->forge->dropTable('posts_to_delete', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('posts_to_delete', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'field_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'content' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'character_set' => 'utf8mb4',
          'collation' => 'utf8mb4_unicode_ci',
     ],
]);
if ($db->tableExists('posts_to_transfer')){
 /* $this->forge->renameTable('posts_to_transfer', 'posts_to_transfer_CustomMigration'); */
 $this->forge->dropTable('posts_to_transfer', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('posts_to_transfer', false, $attributes);

$db->query('ALTER TABLE posts_to_transfer ADD UNIQUE KEY `owner_post_id` (owner_post_id); ');



$this->forge->addField([
     'query_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'sql' => [
          'type' => 'VARCHAR',
          'constraint' => '1024',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('query_id');
if ($db->tableExists('queries')){
 /* $this->forge->renameTable('queries', 'queries_CustomMigration'); */
 $this->forge->dropTable('queries', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('queries', false, $attributes);




$this->forge->addField([
     'rate_center_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'rate_center' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('rate_center_id');
if ($db->tableExists('rate_centers')){
 /* $this->forge->renameTable('rate_centers', 'rate_centers_CustomMigration'); */
 $this->forge->dropTable('rate_centers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('rate_centers', false, $attributes);




$this->forge->addField([
     'realphonevalidation_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'error' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'wireless' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'carrier' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('realphonevalidation_log_id');
if ($db->tableExists('realphonevalidation_log')){
 /* $this->forge->renameTable('realphonevalidation_log', 'realphonevalidation_log_CustomMigration'); */
 $this->forge->dropTable('realphonevalidation_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('realphonevalidation_log', false, $attributes);




$this->forge->addField([
     'record_recorder_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'data' => [
          'type' => 'TEXT',
          'character_set' => 'utf8',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('record_recorder_id');
if ($db->tableExists('record_recorder')){
 /* $this->forge->renameTable('record_recorder', 'record_recorder_CustomMigration'); */
 $this->forge->dropTable('record_recorder', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('record_recorder', false, $attributes);




$this->forge->addField([
     'registrar_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'registrar' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('registrar_id');
if ($db->tableExists('registrars')){
 /* $this->forge->renameTable('registrars', 'registrars_CustomMigration'); */
 $this->forge->dropTable('registrars', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('registrars', false, $attributes);




$this->forge->addField([
     'report_date_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'report_date' => [
          'type' => 'DATE',
     ],
     'year' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'month' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'day' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'quarter' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'week' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'day_name' => [
          'type' => 'VARCHAR',
          'constraint' => '9',
     ],
     'month_name' => [
          'type' => 'VARCHAR',
          'constraint' => '9',
     ],
     'holiday_flag' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'default' => 'f',
     ],
     'weekend_flag' => [
          'type' => 'CHAR',
          'constraint' => '1',
          'default' => 'f',
     ],
     'event' => [
          'type' => 'VARCHAR',
          'constraint' => '50',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('report_date_id');
if ($db->tableExists('report_dates')){
 /* $this->forge->renameTable('report_dates', 'report_dates_CustomMigration'); */
 $this->forge->dropTable('report_dates', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('report_dates', false, $attributes);

$db->query('ALTER TABLE report_dates ADD UNIQUE KEY `td_ymd_idx` (year, month, day); ');
$db->query('ALTER TABLE report_dates ADD UNIQUE KEY `td_dbdate_idx` (report_date); ');



$this->forge->addField([
     'report_date' => [
          'type' => 'DATE',
     ],
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'routed' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'total' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('report_date', true);
$this->forge->addKey('routing_rule_id', true);
if ($db->tableExists('report_routing_rules')){
 /* $this->forge->renameTable('report_routing_rules', 'report_routing_rules_CustomMigration'); */
 $this->forge->dropTable('report_routing_rules', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('report_routing_rules', false, $attributes);




$this->forge->addField([
     'report_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'report' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'has_date_range' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'has_owner' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'has_owner_list' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'has_multiple_owner_lists' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'has_manager' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'has_manager_list' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'has_multiple_manager_lists' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => NULL,
          'null' => true,
     ],
     'report_status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'sql' => [
          'type' => 'TEXT',
          'character_set' => 'utf8',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('report_id');
if ($db->tableExists('reports')){
 /* $this->forge->renameTable('reports', 'reports_CustomMigration'); */
 $this->forge->dropTable('reports', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('reports', false, $attributes);




$this->forge->addField([
     'route_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'route_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('route_status_id');
if ($db->tableExists('route_statuses')){
 /* $this->forge->renameTable('route_statuses', 'route_statuses_CustomMigration'); */
 $this->forge->dropTable('route_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('route_statuses', false, $attributes);




$this->forge->addField([
     'routing_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'manager_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_delivery_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'manager_post_status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'error' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('routing_log_id');
if ($db->tableExists('routing_log')){
 /* $this->forge->renameTable('routing_log', 'routing_log_CustomMigration'); */
 $this->forge->dropTable('routing_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_log', false, $attributes);

$db->query('ALTER TABLE routing_log ADD UNIQUE KEY `created_at` (created_at, routing_rule_id); ');



$this->forge->addField([
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'capacity_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'period_start' => [
          'type' => 'DATETIME',
     ],
     'total' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
]);
if ($db->tableExists('routing_rule_capacity_tracking')){
 /* $this->forge->renameTable('routing_rule_capacity_tracking', 'routing_rule_capacity_tracking_CustomMigration'); */
 $this->forge->dropTable('routing_rule_capacity_tracking', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_capacity_tracking', false, $attributes);

$db->query("ALTER TABLE routing_rule_capacity_tracking ADD PRIMARY KEY (`routing_rule_id`, `capacity_type_id`, `period_start`); ");



$this->forge->addField([
     'routing_rule_filter_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'routing_rule_filter_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'description' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'show_options' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => '1',
     ],
]);
$this->forge->addPrimaryKey('routing_rule_filter_type_id');
if ($db->tableExists('routing_rule_filter_types')){
 /* $this->forge->renameTable('routing_rule_filter_types', 'routing_rule_filter_types_CustomMigration'); */
 $this->forge->dropTable('routing_rule_filter_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_filter_types', false, $attributes);




$this->forge->addField([
     'routing_rule_filter_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'routing_rule_filter_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'filter_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'field_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'criteria' => [
          'type' => 'VARCHAR',
          'constraint' => '1024',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('routing_rule_filter_id');
if ($db->tableExists('routing_rule_filters')){
 /* $this->forge->renameTable('routing_rule_filters', 'routing_rule_filters_CustomMigration'); */
 $this->forge->dropTable('routing_rule_filters', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_filters', false, $attributes);

$db->query('ALTER TABLE routing_rule_filters ADD UNIQUE KEY `routing_rule_filter_type_id` (routing_rule_filter_type_id, filter_name, field_name); ');



$this->forge->addField([
     'routing_rule_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'routing_rule_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('routing_rule_group_id');
if ($db->tableExists('routing_rule_groups')){
 /* $this->forge->renameTable('routing_rule_groups', 'routing_rule_groups_CustomMigration'); */
 $this->forge->dropTable('routing_rule_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_groups', false, $attributes);




$this->forge->addField([
     'routing_rule_group_routing_rule_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'routing_rule_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'day_range' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP', 
     'deleted_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('routing_rule_group_routing_rule_list_id');
if ($db->tableExists('routing_rule_groups_routing_rules')){
 /* $this->forge->renameTable('routing_rule_groups_routing_rules', 'routing_rule_groups_routing_rules_CustomMigration'); */
 $this->forge->dropTable('routing_rule_groups_routing_rules', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_groups_routing_rules', false, $attributes);

$db->query('ALTER TABLE routing_rule_groups_routing_rules ADD UNIQUE KEY `routing_rule_group_id_routing_rule_id` (routing_rule_group_id, routing_rule_id); ');



$this->forge->addField([
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'capacity_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'period_start' => [
          'type' => 'DATETIME',
     ],
     'total' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
if ($db->tableExists('routing_rule_over_capacity_tracking')){
 /* $this->forge->renameTable('routing_rule_over_capacity_tracking', 'routing_rule_over_capacity_tracking_CustomMigration'); */
 $this->forge->dropTable('routing_rule_over_capacity_tracking', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_over_capacity_tracking', false, $attributes);

$db->query("ALTER TABLE routing_rule_over_capacity_tracking ADD PRIMARY KEY (`routing_rule_id`, `capacity_type_id`, `period_start`); ");



$this->forge->addField([
     'routing_rule_status_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'routing_rule_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('routing_rule_status_id');
if ($db->tableExists('routing_rule_statuses')){
 /* $this->forge->renameTable('routing_rule_statuses', 'routing_rule_statuses_CustomMigration'); */
 $this->forge->dropTable('routing_rule_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rule_statuses', false, $attributes);




$this->forge->addField([
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'is_split' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'weight' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'default' => '100',
     ],
     'capacity_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'capacity' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('routing_rule_id');
if ($db->tableExists('routing_rules')){
 /* $this->forge->renameTable('routing_rules', 'routing_rules_CustomMigration'); */
 $this->forge->dropTable('routing_rules', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rules', false, $attributes);

$db->query('ALTER TABLE routing_rules ADD UNIQUE KEY `owner_list_id` (owner_list_id, routing_rule_id, manager_list_id, carrier_group_id, carrier_id); ');



$this->forge->addField([
     'routing_rule_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'change' => [
          'type' => 'TEXT',
     ],
     'notes' => [
          'type' => 'TEXT',
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('routing_rule_log_id');
if ($db->tableExists('routing_rules_log')){
 /* $this->forge->renameTable('routing_rules_log', 'routing_rules_log_CustomMigration'); */
 $this->forge->dropTable('routing_rules_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rules_log', false, $attributes);




$this->forge->addField([
     'routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'routing_rule_filter_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addKey('routing_rule_id', true);
$this->forge->addKey('routing_rule_filter_id', true);
if ($db->tableExists('routing_rules_x_routing_rule_filters')){
 /* $this->forge->renameTable('routing_rules_x_routing_rule_filters', 'routing_rules_x_routing_rule_filters_CustomMigration'); */
 $this->forge->dropTable('routing_rules_x_routing_rule_filters', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('routing_rules_x_routing_rule_filters', false, $attributes);




$this->forge->addField([
     'scrub_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'affiliate_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'sub_account' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'phone_number_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'scrub_service_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'is_suppressed' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('scrub_log_id');
if ($db->tableExists('scrub_log')){
 /* $this->forge->renameTable('scrub_log', 'scrub_log_CustomMigration'); */
 $this->forge->dropTable('scrub_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('scrub_log', false, $attributes);




$this->forge->addField([
     'scrub_service_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'scrub_service' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('scrub_service_id');
if ($db->tableExists('scrub_services')){
 /* $this->forge->renameTable('scrub_services', 'scrub_services_CustomMigration'); */
 $this->forge->dropTable('scrub_services', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('scrub_services', false, $attributes);




$this->forge->addField([
     'scrub_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'scrub_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'status_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'is_recoverable' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
]);
$this->forge->addPrimaryKey('scrub_status_id');
if ($db->tableExists('scrub_statuses')){
 /* $this->forge->renameTable('scrub_statuses', 'scrub_statuses_CustomMigration'); */
 $this->forge->dropTable('scrub_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('scrub_statuses', false, $attributes);




$this->forge->addField([
     'secret_error_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'affiliate_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'sub_account' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'secret' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'ip_address' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('secret_error_id');
if ($db->tableExists('secret_errors')){
 /* $this->forge->renameTable('secret_errors', 'secret_errors_CustomMigration'); */
 $this->forge->dropTable('secret_errors', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('secret_errors', false, $attributes);




$this->forge->addField([
     'secret_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'affiliate_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'sub_account' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'secret' => [
          'type' => 'CHAR',
          'constraint' => '32',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('secret_id');
if ($db->tableExists('secrets')){
 /* $this->forge->renameTable('secrets', 'secrets_CustomMigration'); */
 $this->forge->dropTable('secrets', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('secrets', false, $attributes);

$db->query('ALTER TABLE secrets ADD UNIQUE KEY `affiliate_id` (affiliate_id, sub_account, secret); ');



$this->forge->addField([
     'server_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'auto_increment' => true,
     ],
     'identifier' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'alt_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'hostname' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'domain' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => 'clustervault.com',
     ],
     'ip_address' => [
          'type' => 'VARCHAR',
          'constraint' => '50',
          'default' => NULL,
          'null' => true,
     ],
     'is_webapp' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'is_scrubber' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'is_router' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'is_owner_post_dispatcher' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'is_manager_post_dispatcher' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'is_poster' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'is_manager_post_scrubber' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'post_batch_size' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '5000',
     ],
     'post_batch_query' => [
          'type' => 'VARCHAR',
          'constraint' => '1024',
          'default' => NULL,
          'null' => true,
     ],
     'scrub_batch_size' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '5000',
     ],
     'route_batch_size' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '5000',
     ],
     'owner_post_dispatch_batch_size' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '5000',
     ],
     'manager_post_dispatch_batch_size' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '5000',
     ],
     'memory' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'cpus' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'booted' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'hypervisor_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'suspended' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'xen_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'network_interface_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'monthly_bandwidth_used' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'default' => NULL,
          'null' => true,
     ],
     'total_disk_size' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'load_average' => [
          'type' => 'DECIMAL',
          'constraint' => '5',
          'decimals' => '2',
          'default' => NULL,
          'null' => true,
     ],
     'instance_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'parent_server_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'updated_at' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('server_id');
if ($db->tableExists('servers')){
 /* $this->forge->renameTable('servers', 'servers_CustomMigration'); */
 $this->forge->dropTable('servers', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('servers', false, $attributes);

$db->query('ALTER TABLE servers ADD UNIQUE KEY `identifier` (identifier); ');



$this->forge->addField([
     'server_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'manager_list_batch_size' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
]);
$this->forge->addKey('server_id', true);
$this->forge->addKey('manager_list_id', true);
if ($db->tableExists('servers_x_manager_lists')){
 /* $this->forge->renameTable('servers_x_manager_lists', 'servers_x_manager_lists_CustomMigration'); */
 $this->forge->dropTable('servers_x_manager_lists', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('servers_x_manager_lists', false, $attributes);




$this->forge->addField([
     'site_api_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'http_host' => [
          'type' => 'VARCHAR',
          'constraint' => '128',
     ],
     'application_name' => [
          'type' => 'VARCHAR',
          'constraint' => '128',
     ],
     'client_id' => [
          'type' => 'VARCHAR',
          'constraint' => '256',
     ],
     'client_secret' => [
          'type' => 'VARCHAR',
          'constraint' => '256',
     ],
     'simple_api_key' => [
          'type' => 'VARCHAR',
          'constraint' => '256',
     ],
     'api_type' => [
          'type' => 'CHAR',
          'constraint' => '64',
     ],
]);
$this->forge->addPrimaryKey('site_api_id');
if ($db->tableExists('site_api')){
 /* $this->forge->renameTable('site_api', 'site_api_CustomMigration'); */
 $this->forge->dropTable('site_api', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('site_api', false, $attributes);




$this->forge->addField([
     'sms_campaign_recipient_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'sid' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('sms_campaign_recipient_id');
if ($db->tableExists('sms_campaign_recipients')){
 /* $this->forge->renameTable('sms_campaign_recipients', 'sms_campaign_recipients_CustomMigration'); */
 $this->forge->dropTable('sms_campaign_recipients', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('sms_campaign_recipients', false, $attributes);




$this->forge->addField([
     'sms_platform_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'sms_platform' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'is_default' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addPrimaryKey('sms_platform_id');
if ($db->tableExists('sms_platforms')){
 /* $this->forge->renameTable('sms_platforms', 'sms_platforms_CustomMigration'); */
 $this->forge->dropTable('sms_platforms', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('sms_platforms', false, $attributes);




$this->forge->addField([
     'sms_queue_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'campaign_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'domain_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
          'default' => NULL,
          'null' => true,
     ],
     'exclude_recipients_by_campaign_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'manager_post_created_by' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'manager_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
          'default' => NULL,
          'null' => true,
     ],
     'subscriber_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'record_count' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'campaign_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
          'default' => NULL,
          'null' => true,
     ],
     'sms_platform_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'sms_message' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'unsubscribe_message' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'send_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'sms_queue_status_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('sms_queue_id');
if ($db->tableExists('sms_queue')){
 /* $this->forge->renameTable('sms_queue', 'sms_queue_CustomMigration'); */
 $this->forge->dropTable('sms_queue', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('sms_queue', false, $attributes);




$this->forge->addField([
     'sms_queue_status_type_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'sms_queue_status_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('sms_queue_status_type_id');
if ($db->tableExists('sms_queue_status_types')){
 /* $this->forge->renameTable('sms_queue_status_types', 'sms_queue_status_types_CustomMigration'); */
 $this->forge->dropTable('sms_queue_status_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('sms_queue_status_types', false, $attributes);




$this->forge->addField([
     'source_domain_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'source_domain_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('source_domain_status_id');
if ($db->tableExists('source_domain_statuses')){
 /* $this->forge->renameTable('source_domain_statuses', 'source_domain_statuses_CustomMigration'); */
 $this->forge->dropTable('source_domain_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('source_domain_statuses', false, $attributes);




$this->forge->addField([
     'source_domain_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'source_domain' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'override_domain' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'source_domain_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => '1',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('source_domain_id');
if ($db->tableExists('source_domains')){
 /* $this->forge->renameTable('source_domains', 'source_domains_CustomMigration'); */
 $this->forge->dropTable('source_domains', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('source_domains', false, $attributes);




$this->forge->addField([
     'state_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'state' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('state_id');
if ($db->tableExists('states')){
 /* $this->forge->renameTable('states', 'states_CustomMigration'); */
 $this->forge->dropTable('states', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('states', false, $attributes);




$this->forge->addField([
     'stats_window_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'title' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'sql' => [
          'type' => 'VARCHAR',
          'constraint' => '1024',
          'default' => NULL,
          'null' => true,
     ],
     'order_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
]);
$this->forge->addPrimaryKey('stats_window_id');
if ($db->tableExists('stats_windows')){
 /* $this->forge->renameTable('stats_windows', 'stats_windows_CustomMigration'); */
 $this->forge->dropTable('stats_windows', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('stats_windows', false, $attributes);




$this->forge->addField([
     'subscriber_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'subscriber_status' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('subscriber_status_id');
if ($db->tableExists('subscriber_statuses')){
 /* $this->forge->renameTable('subscriber_statuses', 'subscriber_statuses_CustomMigration'); */
 $this->forge->dropTable('subscriber_statuses', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('subscriber_statuses', false, $attributes);




$this->forge->addField([
     'suppression_log_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'phone_number' => [
          'type' => 'CHAR',
          'constraint' => '10',
     ],
     'response' => [
          'type' => 'VARCHAR',
          'constraint' => '1024',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('suppression_log_id');
if ($db->tableExists('suppression_log')){
 /* $this->forge->renameTable('suppression_log', 'suppression_log_CustomMigration'); */
 $this->forge->dropTable('suppression_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('suppression_log', false, $attributes);




$this->forge->addField([
     'system_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'field' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'value' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
]);
$this->forge->addPrimaryKey('system_status_id');
if ($db->tableExists('system_status')){
 /* $this->forge->renameTable('system_status', 'system_status_CustomMigration'); */
 $this->forge->dropTable('system_status', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('system_status', false, $attributes);

$db->query('ALTER TABLE system_status ADD UNIQUE KEY `system_status_status` (field); ');



$this->forge->addField([
     'manager_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addPrimaryKey('manager_post_id');
if ($db->tableExists('tofix')){
 /* $this->forge->renameTable('tofix', 'tofix_CustomMigration'); */
 $this->forge->dropTable('tofix', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('tofix', false, $attributes);




$this->forge->addField([
     'transaction_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'transaction_id' => [
          'type' => 'CHAR',
          'constraint' => '32',
     ],
     'affiliate_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'domain_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'phone_number' => [
          'type' => 'CHAR',
          'constraint' => '10',
          'default' => NULL,
          'null' => true,
     ],
     'revenue' => [
          'type' => 'SMALLINT',
          'constraint' => '6',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('transaction_log_id');
if ($db->tableExists('transactions')){
 /* $this->forge->renameTable('transactions', 'transactions_CustomMigration'); */
 $this->forge->dropTable('transactions', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('transactions', false, $attributes);




$this->forge->addField([
     'transformation_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'transformation' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('transformation_id');
if ($db->tableExists('transformations')){
 /* $this->forge->renameTable('transformations', 'transformations_CustomMigration'); */
 $this->forge->dropTable('transformations', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('transformations', false, $attributes);




$this->forge->addField([
     'trusted_form_claim_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'manager_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_post_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'was_successful' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'response' => [
          'type' => 'TEXT',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('trusted_form_claim_log_id');
if ($db->tableExists('trusted_form_claim_log')){
 /* $this->forge->renameTable('trusted_form_claim_log', 'trusted_form_claim_log_CustomMigration'); */
 $this->forge->dropTable('trusted_form_claim_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('trusted_form_claim_log', false, $attributes);

$db->query('ALTER TABLE trusted_form_claim_log ADD UNIQUE KEY `created_at` (created_at, manager_list_id, was_successful); ');



$this->forge->addField([
     'upload_file_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'file_name' => [
          'type' => 'VARCHAR',
          'constraint' => '200',
          'default' => NULL,
          'null' => true,
     ],
     'file_size' => [
          'type' => 'DECIMAL',
          'constraint' => '10',
          'decimals' => '2',
          'default' => '0.00',
     ],
     'current_stage' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'more' => '',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('upload_file_id');
if ($db->tableExists('upload_files')){
 /* $this->forge->renameTable('upload_files', 'upload_files_CustomMigration'); */
 $this->forge->dropTable('upload_files', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('upload_files', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'field_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'content_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
]);
$this->forge->addKey('owner_post_id', true);
$this->forge->addKey('field_id', true);
if ($db->tableExists('upload_post_data')){
 /* $this->forge->renameTable('upload_post_data', 'upload_post_data_CustomMigration'); */
 $this->forge->dropTable('upload_post_data', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('upload_post_data', false, $attributes);




$this->forge->addField([
     'owner_post_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'upload_file_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'owner_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'owner_list_id' => [
          'type' => 'SMALLINT',
          'constraint' => '5',
          'unsigned' => true,
     ],
     'phone_number_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'email_address_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
          'unsigned' => true,
     ],
     'carrier_id' => [
          'type' => 'MEDIUMINT',
          'constraint' => '8',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'source_domain_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'scrub_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'post_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'route_status_id' => [
          'type' => 'TINYINT',
          'constraint' => '3',
          'unsigned' => true,
     ],
     'generated_at' => [
          'type' => 'DATETIME',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('owner_post_id');
if ($db->tableExists('upload_posts')){
 /* $this->forge->renameTable('upload_posts', 'upload_posts_CustomMigration'); */
 $this->forge->dropTable('upload_posts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('upload_posts', false, $attributes);

$db->query('ALTER TABLE upload_posts ADD UNIQUE KEY `email_address_index` (email_address_id); ');
$db->query('ALTER TABLE upload_posts ADD UNIQUE KEY `phone_number_index` (phone_number_id); ');
$db->query('ALTER TABLE upload_posts ADD UNIQUE KEY `owner_list_id_index` (owner_list_id); ');
$db->query('ALTER TABLE upload_posts ADD UNIQUE KEY `processor` (post_status_id, route_status_id); ');



$this->forge->addField([
     'user_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'alert_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'alert_log_id' => [
          'type' => 'BIGINT',
          'constraint' => '20',
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
]);
$this->forge->addKey('user_id', true);
$this->forge->addKey('alert_log_id', true);
if ($db->tableExists('user_alerts')){
 /* $this->forge->renameTable('user_alerts', 'user_alerts_CustomMigration'); */
 $this->forge->dropTable('user_alerts', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_alerts', false, $attributes);




$this->forge->addField([
     'user_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'login_from' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'login_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addKey('user_id', true);
$this->forge->addKey('login_at', true);
if ($db->tableExists('user_login_history')){
 /* $this->forge->renameTable('user_login_history', 'user_login_history_CustomMigration'); */
 $this->forge->dropTable('user_login_history', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_login_history', false, $attributes);




$this->forge->addField([
     'openid_url' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addPrimaryKey('openid_url');
if ($db->tableExists('user_openids')){
 /* $this->forge->renameTable('user_openids', 'user_openids_CustomMigration'); */
 $this->forge->dropTable('user_openids', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_openids', false, $attributes);

$db->query('ALTER TABLE user_openids ADD UNIQUE KEY `user_id` (user_id); ');



$this->forge->addField([
     'user_push_notification_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'auto_increment' => true,
     ],
     'user_id' => [
          'type' => 'TINYINT',
          'constraint' => '4',
          'default' => NULL,
          'null' => true,
     ],
     'endpoint' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'public_key' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'auth_token' => [
          'type' => 'VARCHAR',
          'constraint' => '100',
     ],
     'content_encoding' => [
          'type' => 'VARCHAR',
          'constraint' => '100',
     ],
     'sval' => [
          'type' => 'TEXT',
     ],
     'browser_name' => [
          'type' => 'VARCHAR',
          'constraint' => '100',
          'default' => NULL,
          'null' => true,
     ],
     'browser_agent' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'browser_version' => [
          'type' => 'VARCHAR',
          'constraint' => '100',
          'default' => NULL,
          'null' => true,
     ],
     'browser_platform' => [
          'type' => 'VARCHAR',
          'constraint' => '100',
          'default' => NULL,
          'null' => true,
     ],
     'push_for_website' => [
          'type' => 'INT',
          'constraint' => '11',
          'more' => '',
     ],
     'send_notification' => [
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => '1',
     ],
     'user_ip' => [
          'type' => 'VARCHAR',
          'constraint' => '75',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
     'updated_at timestamp NULL  DEFAULT NULL ', 
]);
$this->forge->addPrimaryKey('user_push_notification_id');
if ($db->tableExists('user_push_notification_data')){
 /* $this->forge->renameTable('user_push_notification_data', 'user_push_notification_data_CustomMigration'); */
 $this->forge->dropTable('user_push_notification_data', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_push_notification_data', false, $attributes);




$this->forge->addField([
     'user_push_notification_log_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'auto_increment' => true,
     ],
     'user_push_notification_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'notification_queue_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'sent_at timestamp NULL  DEFAULT NULL ', 
     'is_clicked' => [
          'type' => 'TINYINT',
          'constraint' => '4',
     ],
     'clicked_at timestamp NULL  DEFAULT NULL ', 
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('user_push_notification_log_id');
if ($db->tableExists('user_push_notification_log')){
 /* $this->forge->renameTable('user_push_notification_log', 'user_push_notification_log_CustomMigration'); */
 $this->forge->dropTable('user_push_notification_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_push_notification_log', false, $attributes);




$this->forge->addField([
     'user_role_group_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'user_role_group' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'group_email_address' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('user_role_group_id');
if ($db->tableExists('user_role_groups')){
 /* $this->forge->renameTable('user_role_groups', 'user_role_groups_CustomMigration'); */
 $this->forge->dropTable('user_role_groups', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_role_groups', false, $attributes);




$this->forge->addField([
     'user_role_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('user_role_group_id', true);
$this->forge->addKey('user_id', true);
if ($db->tableExists('user_role_groups_x_users')){
 /* $this->forge->renameTable('user_role_groups_x_users', 'user_role_groups_x_users_CustomMigration'); */
 $this->forge->dropTable('user_role_groups_x_users', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_role_groups_x_users', false, $attributes);




$this->forge->addField([
     'user_type_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'user_type' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('user_type_id');
if ($db->tableExists('user_types')){
 /* $this->forge->renameTable('user_types', 'user_types_CustomMigration'); */
 $this->forge->dropTable('user_types', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('user_types', false, $attributes);




$this->forge->addField([
     'user_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'user_type_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'full_name' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'username' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
     ],
     'password' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'email_address' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'theme' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'last_login_at' => [
          'type' => 'DATETIME',
          'default' => NULL,
          'null' => true,
     ],
     'last_login_from' => [
          'type' => 'VARCHAR',
          'constraint' => '255',
          'default' => NULL,
          'null' => true,
     ],
]);
$this->forge->addPrimaryKey('user_id');
if ($db->tableExists('users')){
 /* $this->forge->renameTable('users', 'users_CustomMigration'); */
 $this->forge->dropTable('users', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('users', false, $attributes);

$db->query('ALTER TABLE users ADD UNIQUE KEY `users_username_index` (username); ');
$db->query('ALTER TABLE users ADD UNIQUE KEY `users_status_id_index` (status_id); ');



$this->forge->addField([
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'key_performance_indicator_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
]);
$this->forge->addKey('user_id', true);
$this->forge->addKey('key_performance_indicator_id', true);
if ($db->tableExists('users_x_key_performance_indicators')){
 /* $this->forge->renameTable('users_x_key_performance_indicators', 'users_x_key_performance_indicators_CustomMigration'); */
 $this->forge->dropTable('users_x_key_performance_indicators', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('users_x_key_performance_indicators', false, $attributes);




$this->forge->addField([
     'wildcard_routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'manager_list_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
     ],
     'carrier_group_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'carrier_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'country_id' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'is_fresh' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'scrub_data' => [
          'type' => 'INT',
          'constraint' => '11',
     ],
     'status_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => '1',
     ],
     'updated_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('wildcard_routing_rule_id');
if ($db->tableExists('wildcard_routing_rules')){
 /* $this->forge->renameTable('wildcard_routing_rules', 'wildcard_routing_rules_CustomMigration'); */
 $this->forge->dropTable('wildcard_routing_rules', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('wildcard_routing_rules', false, $attributes);

$db->query('ALTER TABLE wildcard_routing_rules ADD UNIQUE KEY `manager_list_id` (manager_list_id, country_id, carrier_group_id, carrier_id); ');



$this->forge->addField([
     'wildcard_routing_rule_log_id' => [
          'type' => 'INT',
          'constraint' => '10',
          'unsigned' => true,
          'auto_increment' => true,
     ],
     'wildcard_routing_rule_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'change' => [
          'type' => 'TEXT',
     ],
     'notes' => [
          'type' => 'TEXT',
     ],
     'user_id' => [
          'type' => 'INT',
          'constraint' => '11',
          'default' => NULL,
          'null' => true,
     ],
     'created_at timestamp NOT NULL  DEFAULT CURRENT_TIMESTAMP ', 
]);
$this->forge->addPrimaryKey('wildcard_routing_rule_log_id');
if ($db->tableExists('wildcard_routing_rules_log')){
 /* $this->forge->renameTable('wildcard_routing_rules_log', 'wildcard_routing_rules_log_CustomMigration'); */
 $this->forge->dropTable('wildcard_routing_rules_log', true);
 }

$attributes = array('ENGINE'=>'InnoDB');

$this->forge->createTable('wildcard_routing_rules_log', false, $attributes);



$db->enableForeignKeyChecks();


	}

	public function down()
	{
		
	}
}
						