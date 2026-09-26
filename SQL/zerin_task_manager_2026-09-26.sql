# ************************************************************
# Sequel Ace SQL dump
# Version 20067
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.7.34)
# Database: zerin_task_manager
# Generation Time: 2026-09-26 20:03:31 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activity_logs
# ------------------------------------------------------------

CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `actor_id` int(10) unsigned DEFAULT NULL,
  `subject_type` varchar(50) NOT NULL,
  `subject_id` int(10) unsigned DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `metadata` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `actor_id` (`actor_id`),
  KEY `subject_type_subject_id` (`subject_type`,`subject_id`),
  KEY `project_id_created_at` (`project_id`,`created_at`),
  CONSTRAINT `activity_logs_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `activity_logs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ai_runs
# ------------------------------------------------------------

CREATE TABLE `ai_runs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `actor_id` int(10) unsigned DEFAULT NULL,
  `feature` varchar(60) NOT NULL,
  `model` varchar(80) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `input_summary` text,
  `response_id` varchar(120) DEFAULT NULL,
  `usage_input_tokens` int(11) DEFAULT NULL,
  `usage_output_tokens` int(11) DEFAULT NULL,
  `error_message` text,
  `created_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_air_project` (`project_id`),
  KEY `idx_air_feature` (`feature`),
  KEY `idx_air_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ai_suggestions
# ------------------------------------------------------------

CREATE TABLE `ai_suggestions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ai_run_id` bigint(20) unsigned NOT NULL,
  `project_id` int(10) unsigned DEFAULT NULL,
  `suggestion_type` varchar(60) NOT NULL,
  `subject_type` varchar(60) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `payload` longtext,
  `confidence` decimal(5,4) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'proposed',
  `reviewed_by` int(10) unsigned DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ais_run` (`ai_run_id`),
  KEY `idx_ais_project` (`project_id`),
  KEY `idx_ais_type` (`suggestion_type`),
  KEY `idx_ais_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table meeting_action_items
# ------------------------------------------------------------

CREATE TABLE `meeting_action_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) unsigned NOT NULL,
  `body` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `suggested_assignee_id` int(10) unsigned DEFAULT NULL,
  `explicit_owner_id` int(10) unsigned DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `confidence` decimal(5,4) DEFAULT NULL,
  `assignment_reason` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'proposed',
  `ai_run_id` bigint(20) unsigned DEFAULT NULL,
  `created_task_id` int(10) unsigned DEFAULT NULL,
  `reviewed_by` int(10) unsigned DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_meeting_action_items_meeting` (`meeting_id`),
  KEY `idx_meeting_action_items_status` (`status`),
  KEY `idx_meeting_action_items_suggested_assignee` (`suggested_assignee_id`),
  KEY `idx_meeting_action_items_explicit_owner` (`explicit_owner_id`),
  KEY `idx_meeting_action_items_ai_run` (`ai_run_id`),
  KEY `idx_meeting_action_items_created_task` (`created_task_id`),
  KEY `idx_meeting_action_items_reviewed_by` (`reviewed_by`),
  CONSTRAINT `fk_meeting_action_items_ai_run` FOREIGN KEY (`ai_run_id`) REFERENCES `ai_runs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_action_items_created_task` FOREIGN KEY (`created_task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_action_items_explicit_owner` FOREIGN KEY (`explicit_owner_id`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_action_items_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_action_items_reviewed_by` FOREIGN KEY (`reviewed_by`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_action_items_suggested_assignee` FOREIGN KEY (`suggested_assignee_id`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table meeting_decisions
# ------------------------------------------------------------

CREATE TABLE `meeting_decisions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) unsigned NOT NULL,
  `decision_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `ai_run_id` bigint(20) unsigned DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_meeting_decisions_meeting` (`meeting_id`),
  KEY `idx_meeting_decisions_ai_run` (`ai_run_id`),
  KEY `idx_meeting_decisions_created_by` (`created_by`),
  CONSTRAINT `fk_meeting_decisions_ai_run` FOREIGN KEY (`ai_run_id`) REFERENCES `ai_runs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_decisions_created_by` FOREIGN KEY (`created_by`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_decisions_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table meeting_files
# ------------------------------------------------------------

CREATE TABLE `meeting_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) unsigned NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stored_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) unsigned DEFAULT NULL,
  `file_kind` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'attachment',
  `uploaded_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_meeting_files_meeting` (`meeting_id`),
  KEY `idx_meeting_files_uploaded_by` (`uploaded_by`),
  CONSTRAINT `fk_meeting_files_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_files_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table meeting_participants
# ------------------------------------------------------------

CREATE TABLE `meeting_participants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) unsigned NOT NULL,
  `team_member_id` int(10) unsigned NOT NULL,
  `participant_role` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'attendee',
  `attendance_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invited',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_meeting_participant` (`meeting_id`,`team_member_id`),
  KEY `idx_meeting_participants_member` (`team_member_id`),
  CONSTRAINT `fk_meeting_participants_meeting` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_meeting_participants_member` FOREIGN KEY (`team_member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table meeting_transcripts
# ------------------------------------------------------------

CREATE TABLE `meeting_transcripts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint(20) unsigned NOT NULL,
  `source_file_id` bigint(20) unsigned DEFAULT NULL,
  `transcript_text` longtext NOT NULL,
  `language` varchar(20) DEFAULT NULL,
  `source_type` varchar(30) NOT NULL DEFAULT 'manual',
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_meeting_transcripts_meeting` (`meeting_id`),
  KEY `idx_meeting_transcripts_source_file` (`source_file_id`),
  KEY `idx_meeting_transcripts_created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table meetings
# ------------------------------------------------------------

CREATE TABLE `meetings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agenda` longtext COLLATE utf8mb4_unicode_ci,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `meeting_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'project',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `ai_summary` longtext COLLATE utf8mb4_unicode_ci,
  `ai_risks` longtext COLLATE utf8mb4_unicode_ci COMMENT 'JSON array',
  `ai_last_run_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_meetings_project_id` (`project_id`),
  KEY `idx_meetings_start_at` (`start_at`),
  KEY `idx_meetings_created_by` (`created_by`),
  CONSTRAINT `fk_meetings_created_by` FOREIGN KEY (`created_by`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_meetings_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table project_commitments
# ------------------------------------------------------------

CREATE TABLE `project_commitments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `meeting_id` bigint(20) unsigned DEFAULT NULL,
  `source_action_item_id` bigint(20) unsigned DEFAULT NULL,
  `task_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `owner_id` int(10) unsigned DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'open',
  `confidence` decimal(5,4) DEFAULT NULL,
  `notes` text,
  `fulfilled_at` datetime DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `meeting_id` (`meeting_id`),
  KEY `owner_id` (`owner_id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table project_decisions
# ------------------------------------------------------------

CREATE TABLE `project_decisions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `meeting_id` bigint(20) unsigned DEFAULT NULL,
  `source_type` varchar(30) NOT NULL DEFAULT 'manual',
  `source_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `decision_text` text NOT NULL,
  `rationale` text,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `decided_at` datetime DEFAULT NULL,
  `decided_by` int(10) unsigned DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `meeting_id` (`meeting_id`),
  KEY `source_type` (`source_type`,`source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table project_members
# ------------------------------------------------------------

CREATE TABLE `project_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `team_member_id` int(10) unsigned NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `role_description` text,
  `responsibilities` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id_team_member_id` (`project_id`,`team_member_id`),
  KEY `team_member_id` (`team_member_id`),
  CONSTRAINT `project_members_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_members_team_member_id_foreign` FOREIGN KEY (`team_member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table projects
# ------------------------------------------------------------

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table schedule_events
# ------------------------------------------------------------

CREATE TABLE `schedule_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `event_type` varchar(30) NOT NULL DEFAULT 'event',
  `start_at` datetime NOT NULL,
  `end_at` datetime DEFAULT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT '0',
  `location` varchar(255) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_events_created_by_foreign` (`created_by`),
  KEY `project_id` (`project_id`),
  KEY `start_at` (`start_at`),
  KEY `project_id_start_at` (`project_id`,`start_at`),
  CONSTRAINT `schedule_events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `team_members` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `schedule_events_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table task_assignments
# ------------------------------------------------------------

CREATE TABLE `task_assignments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `team_member_id` int(10) unsigned NOT NULL,
  `assigned_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `task_id_team_member_id` (`task_id`,`team_member_id`),
  KEY `team_member_id` (`team_member_id`),
  CONSTRAINT `task_assignments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_assignments_team_member_id_foreign` FOREIGN KEY (`team_member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table task_categories
# ------------------------------------------------------------

CREATE TABLE `task_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_project_id` (`project_id`),
  CONSTRAINT `fk_task_categories_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table task_comments
# ------------------------------------------------------------

CREATE TABLE `task_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `team_member_id` int(10) unsigned DEFAULT NULL,
  `body` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_task_comments_task` (`task_id`),
  KEY `idx_task_comments_member` (`team_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table task_dependencies
# ------------------------------------------------------------

CREATE TABLE `task_dependencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `depends_on_task_id` int(10) unsigned NOT NULL,
  `dependency_type` varchar(30) NOT NULL DEFAULT 'blocks',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_task_dependency` (`task_id`,`depends_on_task_id`),
  KEY `idx_td_task` (`task_id`),
  KEY `idx_td_depends` (`depends_on_task_id`),
  CONSTRAINT `fk_td_depends` FOREIGN KEY (`depends_on_task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_td_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table task_files
# ------------------------------------------------------------

CREATE TABLE `task_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `comment_id` bigint(20) unsigned DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `stored_name` varchar(255) NOT NULL,
  `mime_type` varchar(120) DEFAULT NULL,
  `file_size` bigint(20) unsigned DEFAULT NULL,
  `uploaded_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_task_files_task` (`task_id`),
  KEY `idx_task_files_comment` (`comment_id`),
  KEY `idx_task_files_uploaded_by` (`uploaded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table tasks
# ------------------------------------------------------------

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_task_id` int(10) unsigned DEFAULT NULL,
  `body` varchar(500) NOT NULL,
  `assignee` varchar(150) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `priority` varchar(20) DEFAULT 'normal',
  `status` varchar(30) NOT NULL DEFAULT 'todo',
  `blocked_reason` text,
  `status_changed_at` datetime DEFAULT NULL,
  `status_changed_by` int(10) unsigned DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `source_type` varchar(30) NOT NULL DEFAULT 'manual',
  `source_id` bigint(20) unsigned DEFAULT NULL,
  `ai_generated` tinyint(1) NOT NULL DEFAULT '0',
  `ai_reason` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_project_id` (`project_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_tasks_parent_task_id` (`parent_task_id`),
  CONSTRAINT `fk_tasks_category` FOREIGN KEY (`category_id`) REFERENCES `task_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tasks_parent_task` FOREIGN KEY (`parent_task_id`) REFERENCES `tasks` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tasks_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table team_members
# ------------------------------------------------------------

CREATE TABLE `team_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `job_title` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role_description` text,
  `skills` text,
  `responsibilities` text,
  `ai_assignment_enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
