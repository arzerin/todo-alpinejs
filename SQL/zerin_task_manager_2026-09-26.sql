# ************************************************************
# Sequel Ace SQL dump
# Version 20067
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.7.34)
# Database: zerin_task_manager
# Generation Time: 2026-09-26 08:17:14 +0000
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

DROP TABLE IF EXISTS `activity_logs`;

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

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;

INSERT INTO `activity_logs` (`id`, `project_id`, `actor_id`, `subject_type`, `subject_id`, `action`, `description`, `metadata`, `created_at`)
VALUES
	(1,6,NULL,'task',124,'task.created','created a task','{\"task\":\"hello3\",\"priority\":\"normal\",\"category_id\":null,\"due_date\":null}','2026-09-26 01:14:31'),
	(2,6,NULL,'task',124,'task.updated','updated a task','{\"task\":\"hello3\",\"changes\":{\"category_id\":{\"from\":null,\"to\":\"13\"},\"priority\":{\"from\":\"normal\",\"to\":\"high\"},\"due_date\":{\"from\":null,\"to\":\"2026-09-29\"}}}','2026-09-26 01:14:49'),
	(3,NULL,NULL,'person',1,'person.updated','updated a person','{\"person\":\"ZERIN\",\"changes\":{\"photo\":{\"from\":\"uploads\\/team\\/1790402633_29d39bc37b376ff5b458.jpeg\",\"to\":\"uploads\\/team\\/1790403542_5caaf2c5c8a162031bdd.jpg\"}}}','2026-09-26 01:19:02'),
	(4,4,NULL,'person',1,'person.added','added a person to the project','{\"person\":\"ZERIN\"}','2026-09-26 01:42:10'),
	(5,3,NULL,'person',1,'person.added','added a person to the project','{\"person\":\"ZERIN\"}','2026-09-26 01:42:10'),
	(6,1,NULL,'person',1,'person.added','added a person to the project','{\"person\":\"ZERIN\"}','2026-09-26 01:42:10'),
	(7,6,NULL,'person',1,'person.added','added a person to the project','{\"person\":\"ZERIN\"}','2026-09-26 01:44:10'),
	(8,6,NULL,'task',124,'task.assignees_changed','changed task assignees','{\"task\":\"hello3\",\"people\":[{\"id\":1,\"name\":\"ZERIN\"}]}','2026-09-26 01:44:28'),
	(9,6,NULL,'task',124,'task.assignment_delta','updated task assignment','{\"task\":\"hello3\",\"added\":[{\"id\":1,\"name\":\"ZERIN\"}],\"removed\":[]}','2026-09-26 01:44:28'),
	(10,6,NULL,'task',125,'task.created','created a task','{\"task\":\"hello4\",\"priority\":\"normal\",\"category_id\":null,\"due_date\":null}','2026-09-26 01:45:57'),
	(11,6,NULL,'task',125,'task.assignees_changed','changed task assignees','{\"task\":\"hello4\",\"people\":[{\"id\":1,\"name\":\"ZERIN\"}]}','2026-09-26 01:46:09'),
	(12,6,NULL,'task',125,'task.assignment_delta','updated task assignment','{\"task\":\"hello4\",\"added\":[{\"id\":1,\"name\":\"ZERIN\"}],\"removed\":[]}','2026-09-26 01:46:09'),
	(13,6,NULL,'task',126,'task.created','created a task','{\"task\":\"hello5\",\"priority\":\"normal\",\"category_id\":null,\"due_date\":null}','2026-09-26 01:54:47'),
	(14,6,NULL,'task',126,'task.updated','updated a task','{\"task\":\"hello5\",\"changes\":{\"category_id\":{\"from\":null,\"to\":\"13\"}}}','2026-09-26 01:54:52'),
	(15,6,NULL,'task',126,'task.updated','updated a task','{\"task\":\"hello5\",\"changes\":{\"priority\":{\"from\":\"normal\",\"to\":\"urgent\"}}}','2026-09-26 01:56:16'),
	(16,6,NULL,'task',126,'task.completed','completed a task','{\"task\":\"hello5\"}','2026-09-26 01:56:49'),
	(17,6,NULL,'task',125,'task.completed','completed a task','{\"task\":\"hello4\"}','2026-09-26 01:56:50'),
	(18,6,NULL,'task',124,'task.completed','completed a task','{\"task\":\"hello3\"}','2026-09-26 01:56:51'),
	(19,6,NULL,'task',123,'task.completed','completed a task','{\"task\":\"hello2\"}','2026-09-26 01:56:52'),
	(20,6,NULL,'task',122,'task.completed','completed a task','{\"task\":\"hello1\"}','2026-09-26 01:56:53'),
	(21,2,NULL,'task',121,'task.completed','completed a task','{\"task\":\"Hello1\"}','2026-09-26 01:56:53'),
	(22,5,NULL,'task',119,'task.completed','completed a task','{\"task\":\"Hello1\"}','2026-09-26 01:56:54'),
	(23,5,NULL,'task',116,'task.completed','completed a task','{\"task\":\"Test1\"}','2026-09-26 01:56:55'),
	(24,6,NULL,'task',127,'task.created','created a task','{\"task\":\"hello\",\"priority\":\"normal\",\"category_id\":null,\"due_date\":null}','2026-09-26 02:25:26'),
	(25,6,NULL,'task',127,'task.updated','updated a task','{\"task\":\"hello\",\"changes\":{\"priority\":{\"from\":\"normal\",\"to\":\"high\"}}}','2026-09-26 02:25:34'),
	(26,6,NULL,'task',127,'task.assignees_changed','changed task assignees','{\"task\":\"hello\",\"people\":[{\"id\":1,\"name\":\"ZERIN\"}]}','2026-09-26 02:25:35'),
	(27,6,NULL,'task',127,'task.assignment_delta','updated task assignment','{\"task\":\"hello\",\"added\":[{\"id\":1,\"name\":\"ZERIN\"}],\"removed\":[]}','2026-09-26 02:25:35'),
	(28,6,NULL,'person',1,'person.removed','removed a person from the project','{\"person\":\"ZERIN\"}','2026-09-26 02:31:40'),
	(29,NULL,NULL,'person',1,'person.updated','updated a person','{\"person\":\"ZERIN\",\"changes\":{\"skills\":{\"from\":null,\"to\":\"[]\"},\"responsibilities\":{\"from\":null,\"to\":\"[]\"}}}','2026-09-26 02:34:05'),
	(30,6,NULL,'person',1,'person.added','added a person to the project','{\"person\":\"ZERIN\"}','2026-09-26 03:05:14'),
	(31,6,NULL,'task',129,'task.assignees_changed','changed task assignees','{\"task\":\"Prepare the complete booking-flow QA test plan.\",\"people\":[{\"id\":1,\"name\":\"ZERIN\"}]}','2026-09-26 03:16:15'),
	(32,6,NULL,'task',129,'task.assignment_delta','updated task assignment','{\"task\":\"Prepare the complete booking-flow QA test plan.\",\"added\":[{\"id\":1,\"name\":\"ZERIN\"}],\"removed\":[{\"id\":2,\"name\":\"Zaara\"}]}','2026-09-26 03:16:15');

/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ai_runs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ai_runs`;

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

LOCK TABLES `ai_runs` WRITE;
/*!40000 ALTER TABLE `ai_runs` DISABLE KEYS */;

INSERT INTO `ai_runs` (`id`, `project_id`, `actor_id`, `feature`, `model`, `status`, `input_summary`, `response_id`, `usage_input_tokens`, `usage_output_tokens`, `error_message`, `created_at`, `completed_at`)
VALUES
	(1,6,NULL,'meeting.analysis','gpt-5.6-terra','completed','Analyze this meeting and propose reviewable decisions, risks and action items. Do not create tasks.','resp_0b1c87cb1d0793f6006ab77ef8ca6887d1bd1c048c47b3e217',1539,1071,NULL,'2026-09-26 03:14:46','2026-09-26 03:15:01'),
	(2,6,NULL,'task_breakdown','gpt-5.6-terra','completed','Break down this task: Prepare the pilot hotel list with the operations team.','resp_0e99ed4cc76d46eb006ab77f5a529487d1b93f35ca3cb8ec1c',1659,354,NULL,'2026-09-26 03:16:25','2026-09-26 03:16:31');

/*!40000 ALTER TABLE `ai_runs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ai_suggestions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ai_suggestions`;

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

LOCK TABLES `ai_suggestions` WRITE;
/*!40000 ALTER TABLE `ai_suggestions` DISABLE KEYS */;

INSERT INTO `ai_suggestions` (`id`, `ai_run_id`, `project_id`, `suggestion_type`, `subject_type`, `subject_id`, `title`, `payload`, `confidence`, `status`, `reviewed_by`, `reviewed_at`, `created_at`)
VALUES
	(1,2,6,'subtask','task',130,'Define pilot hotel selection criteria with the operations team','{\"title\":\"Define pilot hotel selection criteria with the operations team\",\"priority\":\"high\",\"due_date\":null,\"suggested_person_id\":null,\"assignment_reason\":\"\",\"confidence\":0.88}',0.8800,'accepted',NULL,'2026-09-26 03:16:37','2026-09-26 03:16:31'),
	(2,2,6,'subtask','task',130,'Gather candidate hotel data from available operational and partner sources','{\"title\":\"Gather candidate hotel data from available operational and partner sources\",\"priority\":\"normal\",\"due_date\":null,\"suggested_person_id\":null,\"assignment_reason\":\"\",\"confidence\":0.84}',0.8400,'accepted',NULL,'2026-09-26 03:16:37','2026-09-26 03:16:31'),
	(3,2,6,'subtask','task',130,'Verify each candidate hotel’s location, room inventory, contact details, and operational readiness','{\"title\":\"Verify each candidate hotel’s location, room inventory, contact details, and operational readiness\",\"priority\":\"high\",\"due_date\":null,\"suggested_person_id\":null,\"assignment_reason\":\"\",\"confidence\":0.87}',0.8700,'accepted',NULL,'2026-09-26 03:16:37','2026-09-26 03:16:31'),
	(4,2,6,'subtask','task',130,'Assess candidates against the agreed pilot criteria and identify risks or dependencies','{\"title\":\"Assess candidates against the agreed pilot criteria and identify risks or dependencies\",\"priority\":\"high\",\"due_date\":null,\"suggested_person_id\":null,\"assignment_reason\":\"\",\"confidence\":0.85}',0.8500,'accepted',NULL,'2026-09-26 03:16:37','2026-09-26 03:16:31'),
	(5,2,6,'subtask','task',130,'Review the shortlisted hotels with the operations team and collect approval or changes','{\"title\":\"Review the shortlisted hotels with the operations team and collect approval or changes\",\"priority\":\"high\",\"due_date\":null,\"suggested_person_id\":null,\"assignment_reason\":\"\",\"confidence\":0.9}',0.9000,'accepted',NULL,'2026-09-26 03:16:37','2026-09-26 03:16:31'),
	(6,2,6,'subtask','task',130,'Publish the finalized pilot hotel list with key contacts, status, and next steps','{\"title\":\"Publish the finalized pilot hotel list with key contacts, status, and next steps\",\"priority\":\"normal\",\"due_date\":null,\"suggested_person_id\":null,\"assignment_reason\":\"\",\"confidence\":0.89}',0.8900,'accepted',NULL,'2026-09-26 03:16:37','2026-09-26 03:16:31');

/*!40000 ALTER TABLE `ai_suggestions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table meeting_action_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meeting_action_items`;

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

LOCK TABLES `meeting_action_items` WRITE;
/*!40000 ALTER TABLE `meeting_action_items` DISABLE KEYS */;

INSERT INTO `meeting_action_items` (`id`, `meeting_id`, `body`, `details`, `suggested_assignee_id`, `explicit_owner_id`, `due_date`, `priority`, `confidence`, `assignment_reason`, `status`, `ai_run_id`, `created_task_id`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`)
VALUES
	(1,3,'Optimize the room availability API and reduce unnecessary database queries.','This is required before final WhatsApp booking-flow integration.',1,1,'2026-09-30','high',0.9800,'ZERIN is explicitly assigned in the meeting action items and is the project\'s Technical Lead responsible for API architecture and delivery.','accepted',1,128,NULL,'2026-09-26 03:15:24','2026-09-26 03:15:01','2026-09-26 03:15:24'),
	(2,3,'Implement room selection and tentative booking creation.','Preserve the selected hotel ID, room ID, customer WhatsApp number, check-in date, check-out date, adults, children, and calculated room price.',1,1,'2026-10-02','high',0.9800,'ZERIN is explicitly assigned in the meeting action items and owns backend architecture and API delivery.','proposed',1,NULL,NULL,NULL,'2026-09-26 03:15:01','2026-09-26 03:15:01'),
	(3,3,'Prepare the complete booking-flow QA test plan.','Cover hotel selection, invalid dates, unavailable rooms, adult and child counts, room selection, tentative booking creation, duplicate WhatsApp requests, and the booking confirmation message.',2,2,'2026-10-03','high',0.9100,'Zaara is explicitly assigned in the meeting action items and is an eligible project participant.','accepted',1,129,NULL,'2026-09-26 03:15:59','2026-09-26 03:15:01','2026-09-26 03:15:59'),
	(4,3,'Prepare the pilot hotel list with the operations team.','The list supports the allow-listed pilot-property production rollout.',2,2,NULL,'normal',0.9300,'Zaara is explicitly assigned in the meeting action items and is an eligible project participant.','accepted',1,130,NULL,'2026-09-26 03:16:00','2026-09-26 03:15:01','2026-09-26 03:16:00'),
	(5,3,'Investigate a caching strategy for Near Me hotel searches and report a recommendation at the next meeting.','The strategy should address repeated location and database requests; no exact deadline was agreed.',2,2,NULL,'normal',0.8600,'Zaara is explicitly assigned in the meeting action items and is an eligible project participant.','proposed',1,NULL,NULL,NULL,'2026-09-26 03:15:01','2026-09-26 03:15:01'),
	(6,3,'Add the WhatsApp tentative-booking confirmation after booking creation is working.','The message should include hotel name, room name, check-in date, check-out date, guest count, estimated total, and tentative booking reference, and clearly state that the reservation is pending confirmation.',1,1,NULL,'normal',0.9400,'ZERIN is explicitly assigned in the meeting action items and is the project\'s Technical Lead.','proposed',1,NULL,NULL,NULL,'2026-09-26 03:15:01','2026-09-26 03:15:01');

/*!40000 ALTER TABLE `meeting_action_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table meeting_decisions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meeting_decisions`;

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

LOCK TABLES `meeting_decisions` WRITE;
/*!40000 ALTER TABLE `meeting_decisions` DISABLE KEYS */;

INSERT INTO `meeting_decisions` (`id`, `meeting_id`, `decision_text`, `source`, `ai_run_id`, `created_by`, `created_at`)
VALUES
	(1,3,'The WhatsApp booking sequence will be: hotel selection, check-in/check-out, adults and children, room availability, room selection, guest details, tentative booking, and confirmation.','ai',1,NULL,NULL),
	(2,3,'The room availability API must be optimized before final integration with the WhatsApp booking flow.','ai',1,NULL,NULL),
	(3,3,'Tentative bookings must not become confirmed immediately; they require confirmation by a BD Booking team member or hotel.','ai',1,NULL,NULL),
	(4,3,'Booking creation will use an idempotency key based on the WhatsApp message ID.','ai',1,NULL,NULL),
	(5,3,'Near Me search will use caching and rate limiting.','ai',1,NULL,NULL),
	(6,3,'WhatsApp tentative-booking confirmations must state that the reservation is pending confirmation.','ai',1,NULL,NULL),
	(7,3,'Production rollout will begin with allow-listed pilot hotels and expand gradually after successful testing.','ai',1,NULL,NULL),
	(8,3,'AI-generated meeting action items must be reviewed before becoming project tasks.','ai',1,NULL,NULL);

/*!40000 ALTER TABLE `meeting_decisions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table meeting_files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meeting_files`;

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

DROP TABLE IF EXISTS `meeting_participants`;

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

LOCK TABLES `meeting_participants` WRITE;
/*!40000 ALTER TABLE `meeting_participants` DISABLE KEYS */;

INSERT INTO `meeting_participants` (`id`, `meeting_id`, `team_member_id`, `participant_role`, `attendance_status`, `created_at`)
VALUES
	(1,1,2,'attendee','invited',NULL),
	(2,1,1,'attendee','invited',NULL),
	(3,2,2,'attendee','invited',NULL),
	(4,2,1,'attendee','invited',NULL),
	(7,3,1,'attendee','invited',NULL),
	(8,3,2,'attendee','invited',NULL);

/*!40000 ALTER TABLE `meeting_participants` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table meeting_transcripts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meeting_transcripts`;

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

DROP TABLE IF EXISTS `meetings`;

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

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;

INSERT INTO `meetings` (`id`, `project_id`, `title`, `agenda`, `notes`, `meeting_type`, `status`, `start_at`, `end_at`, `location`, `created_by`, `ai_summary`, `ai_risks`, `ai_last_run_id`, `created_at`, `updated_at`)
VALUES
	(1,6,'Regular Meeting','api integratoin to be done','api must done by tomorrow','planning','scheduled','2026-09-26 14:06:00','2026-09-26 16:06:00','',NULL,NULL,NULL,NULL,'2026-09-26 03:07:33','2026-09-26 03:07:33'),
	(2,4,'BD Booking – Hotel Availability & WhatsApp Booking Integration','1. Review hotel room availability API\n2. Discuss WhatsApp booking flow\n3. Fix Near Me performance problem\n4. Decide how tentative bookings should work\n5. Assign development tasks\n6. Review production deployment risks','Project Meeting – BD Booking Booking Automation\n\nParticipants:\nAR Zerin – Senior Software Engineer\nSarah Khan – Project Manager\nJohn Ahmed – Backend Developer\nNadia Rahman – QA Engineer\n\nSarah opened the meeting by reviewing the current BD Booking WhatsApp\nautomation project.\n\nThe team agreed that the next release must allow a WhatsApp customer to\nselect a hotel, provide check-in and check-out dates, specify adults and\nchildren, view available rooms, select a room, and create a tentative\nbooking.\n\nROOM AVAILABILITY\n\nAR Zerin explained that the existing hotel availability API is too slow\nbecause several database queries are executed separately for every room.\n\nThe team decided to optimize the availability API before connecting it\nto the final WhatsApp booking flow.\n\nJohn Ahmed will optimize the room availability API and reduce unnecessary\ndatabase queries.\n\nJohn should complete this work by 30 September 2026.\n\nThis task is high priority because the WhatsApp booking flow depends on it.\n\nWHATSAPP BOOKING FLOW\n\nThe team agreed on the following booking sequence:\n\nHotel selection\n→ Check-in/check-out\n→ Adults and children\n→ Room availability\n→ Room selection\n→ Guest details\n→ Tentative booking\n→ Confirmation\n\nAR Zerin will implement the room-selection and tentative-booking integration.\n\nThe implementation should preserve the selected hotel ID, room ID,\ncustomer WhatsApp number, check-in date, check-out date, adults,\nchildren and calculated room price.\n\nThis work should be completed by 2 October 2026.\n\nSarah asked that tentative bookings must NOT immediately become confirmed\nbookings. A member of the BD Booking team or the hotel must confirm them.\n\nThe team accepted this as a project decision.\n\nNEAR ME PERFORMANCE\n\nThe Near Me hotel search is currently making repeated location/database\nrequests.\n\nAR suggested caching nearby hotel search results for a short period.\n\nThe team agreed to introduce caching and rate limiting.\n\nJohn will investigate an appropriate caching strategy and report his\nrecommendation at the next meeting.\n\nNo exact deadline was assigned for this investigation.\n\nCUSTOMER NOTIFICATION\n\nAfter a tentative booking is created, the customer should receive a\nWhatsApp confirmation message containing:\n\n- hotel name\n- room name\n- check-in date\n- check-out date\n- guest count\n- estimated total\n- tentative booking reference\n\nSarah requested that the message clearly state that the reservation is\npending confirmation.\n\nAR Zerin will implement this notification after tentative booking\ncreation is working.\n\nQUALITY ASSURANCE\n\nNadia Rahman will prepare test cases covering:\n\n- hotel selection\n- invalid dates\n- unavailable rooms\n- adult and child counts\n- room selection\n- tentative booking creation\n- duplicate WhatsApp requests\n- booking confirmation message\n\nThe QA test plan should be ready by 3 October 2026.\n\nNadia mentioned that duplicate webhook requests could potentially create\nduplicate bookings.\n\nThe team identified this as a significant risk.\n\nAR proposed using an idempotency key based on the WhatsApp message ID\nwhen processing booking creation.\n\nThe team agreed with this approach.\n\nPRODUCTION DEPLOYMENT\n\nThe new booking flow should not be deployed directly to all hotels.\n\nThe team decided to enable it first for allow-listed test properties.\n\nAfter successful testing, it can gradually be enabled for additional\nproperties.\n\nSarah will coordinate the pilot property list with the operations team.\n\nBLOCKERS AND RISKS\n\n1. Availability API performance may delay the WhatsApp booking flow.\n2. Duplicate webhook delivery could create duplicate bookings.\n3. Hotel inventory may change between room selection and confirmation.\n4. WhatsApp messages may fail because of Meta messaging-window restrictions.\n5. The production rollout depends on successful testing with pilot hotels.\n\nFINAL DECISIONS\n\nThe team agreed:\n\n1. Tentative bookings require human/property confirmation.\n2. Room availability API optimization must happen before final integration.\n3. Booking creation must be idempotent.\n4. Initial production deployment will use allow-listed pilot hotels.\n5. WhatsApp confirmation must clearly show that the booking is pending.\n6. AI-generated meeting action items must be reviewed before becoming project tasks.\n\nACTION ITEMS\n\nJohn Ahmed:\nOptimize the room availability API by 30 September 2026.\nPriority: High.\n\nAR Zerin:\nImplement room selection and tentative booking creation by 2 October 2026.\nPriority: High.\n\nNadia Rahman:\nPrepare the complete booking-flow QA test plan by 3 October 2026.\nPriority: High.\n\nSarah Khan:\nPrepare the pilot hotel list with the operations team.\nPriority: Normal.\n\nJohn Ahmed:\nInvestigate caching for Near Me hotel searches.\nNo deadline was agreed.\n\nAR Zerin:\nAdd WhatsApp tentative-booking confirmation after booking creation is complete.','project','completed',NULL,NULL,'',NULL,NULL,NULL,NULL,'2026-09-26 03:09:28','2026-09-26 03:09:28'),
	(3,6,'BD Booking – Hotel Availability & WhatsApp Booking Integration','1. Review hotel room availability API\n2. Discuss WhatsApp booking flow\n3. Fix Near Me performance problem\n4. Decide how tentative bookings should work\n5. Assign development tasks\n6. Review production deployment risks','Project Meeting – BD Booking Booking Automation\n\nParticipants:\nAR Zerin – Senior Software Engineer\nSarah Khan – Project Manager\nJohn Ahmed – Backend Developer\nNadia Rahman – QA Engineer\n\nSarah opened the meeting by reviewing the current BD Booking WhatsApp\nautomation project.\n\nThe team agreed that the next release must allow a WhatsApp customer to\nselect a hotel, provide check-in and check-out dates, specify adults and\nchildren, view available rooms, select a room, and create a tentative\nbooking.\n\nROOM AVAILABILITY\n\nAR Zerin explained that the existing hotel availability API is too slow\nbecause several database queries are executed separately for every room.\n\nThe team decided to optimize the availability API before connecting it\nto the final WhatsApp booking flow.\n\nJohn Ahmed will optimize the room availability API and reduce unnecessary\ndatabase queries.\n\nJohn should complete this work by 30 September 2026.\n\nThis task is high priority because the WhatsApp booking flow depends on it.\n\nWHATSAPP BOOKING FLOW\n\nThe team agreed on the following booking sequence:\n\nHotel selection\n→ Check-in/check-out\n→ Adults and children\n→ Room availability\n→ Room selection\n→ Guest details\n→ Tentative booking\n→ Confirmation\n\nAR Zerin will implement the room-selection and tentative-booking integration.\n\nThe implementation should preserve the selected hotel ID, room ID,\ncustomer WhatsApp number, check-in date, check-out date, adults,\nchildren and calculated room price.\n\nThis work should be completed by 2 October 2026.\n\nSarah asked that tentative bookings must NOT immediately become confirmed\nbookings. A member of the BD Booking team or the hotel must confirm them.\n\nThe team accepted this as a project decision.\n\nNEAR ME PERFORMANCE\n\nThe Near Me hotel search is currently making repeated location/database\nrequests.\n\nAR suggested caching nearby hotel search results for a short period.\n\nThe team agreed to introduce caching and rate limiting.\n\nJohn will investigate an appropriate caching strategy and report his\nrecommendation at the next meeting.\n\nNo exact deadline was assigned for this investigation.\n\nCUSTOMER NOTIFICATION\n\nAfter a tentative booking is created, the customer should receive a\nWhatsApp confirmation message containing:\n\n- hotel name\n- room name\n- check-in date\n- check-out date\n- guest count\n- estimated total\n- tentative booking reference\n\nSarah requested that the message clearly state that the reservation is\npending confirmation.\n\nAR Zerin will implement this notification after tentative booking\ncreation is working.\n\nQUALITY ASSURANCE\n\nNadia Rahman will prepare test cases covering:\n\n- hotel selection\n- invalid dates\n- unavailable rooms\n- adult and child counts\n- room selection\n- tentative booking creation\n- duplicate WhatsApp requests\n- booking confirmation message\n\nThe QA test plan should be ready by 3 October 2026.\n\nNadia mentioned that duplicate webhook requests could potentially create\nduplicate bookings.\n\nThe team identified this as a significant risk.\n\nAR proposed using an idempotency key based on the WhatsApp message ID\nwhen processing booking creation.\n\nThe team agreed with this approach.\n\nPRODUCTION DEPLOYMENT\n\nThe new booking flow should not be deployed directly to all hotels.\n\nThe team decided to enable it first for allow-listed test properties.\n\nAfter successful testing, it can gradually be enabled for additional\nproperties.\n\nSarah will coordinate the pilot property list with the operations team.\n\nBLOCKERS AND RISKS\n\n1. Availability API performance may delay the WhatsApp booking flow.\n2. Duplicate webhook delivery could create duplicate bookings.\n3. Hotel inventory may change between room selection and confirmation.\n4. WhatsApp messages may fail because of Meta messaging-window restrictions.\n5. The production rollout depends on successful testing with pilot hotels.\n\nFINAL DECISIONS\n\nThe team agreed:\n\n1. Tentative bookings require human/property confirmation.\n2. Room availability API optimization must happen before final integration.\n3. Booking creation must be idempotent.\n4. Initial production deployment will use allow-listed pilot hotels.\n5. WhatsApp confirmation must clearly show that the booking is pending.\n6. AI-generated meeting action items must be reviewed before becoming project tasks.\n\nACTION ITEMS\n\nZERIN:\nOptimize the room availability API by 30 September 2026.\nPriority: High.\n\nZERIN:\nImplement room selection and tentative booking creation by 2 October 2026.\nPriority: High.\n\nZaara:\nPrepare the complete booking-flow QA test plan by 3 October 2026.\nPriority: High.\n\nZaara:\nPrepare the pilot hotel list with the operations team.\nPriority: Normal.\n\nZaara:\nInvestigate caching for Near Me hotel searches.\nNo deadline was agreed.\n\nZERIN:\nAdd WhatsApp tentative-booking confirmation after booking creation is complete.','project','completed','2026-09-26 14:10:00','2026-09-26 17:10:00','',NULL,'The team defined the WhatsApp booking flow from hotel selection through tentative booking and confirmation. Availability API optimization is required before final WhatsApp integration. Tentative bookings remain pending until confirmed by a BD Booking team member or hotel. Initial production rollout will be limited to allow-listed pilot properties.','[\"Availability API performance may delay the WhatsApp booking flow.\",\"Duplicate WhatsApp webhook deliveries could create duplicate bookings.\",\"Hotel inventory may change between room selection and confirmation.\",\"WhatsApp messages may fail because of Meta messaging-window restrictions.\",\"Production rollout depends on successful testing with pilot hotels.\"]',1,'2026-09-26 03:10:54','2026-09-26 03:15:01');

/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

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

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`)
VALUES
	(1,'2026-09-26-000001','App\\Database\\Migrations\\CreateProjectManagementSystem','default','App',1790399880,1),
	(2,'2026-09-26-120000','App\\Database\\Migrations\\UpgradeTasksTable','default','App',1790401133,2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project_members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_members`;

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

LOCK TABLES `project_members` WRITE;
/*!40000 ALTER TABLE `project_members` DISABLE KEYS */;

INSERT INTO `project_members` (`id`, `project_id`, `team_member_id`, `role`, `role_description`, `responsibilities`, `created_at`)
VALUES
	(1,2,1,'Technical Lead','Owns backend architecture and API delivery.','[\"API architecture\",\"Database design\",\"Deployment\"]',NULL),
	(2,6,2,NULL,NULL,NULL,NULL),
	(3,4,1,'Responsible for backend architecture, CodeIgniter 4, REST APIs, database design, integrations and de',NULL,NULL,NULL),
	(4,3,1,'Responsible for backend architecture, CodeIgniter 4, REST APIs, database design, integrations and de',NULL,NULL,NULL),
	(5,1,1,'Responsible for backend architecture, CodeIgniter 4, REST APIs, database design, integrations and de',NULL,NULL,NULL),
	(7,6,1,'Technical Lead','Owns backend architecture and API delivery.','[\"API architecture\",\"Database design\",\"Deployment\"]',NULL);

/*!40000 ALTER TABLE `project_members` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;

INSERT INTO `projects` (`id`, `name`, `color`, `created_at`)
VALUES
	(1,'Website Redesign',NULL,'2026-09-25 23:23:17'),
	(2,'CRM Development','blue','2026-09-25 23:23:17'),
	(3,'Mobile App','orange','2026-09-25 23:23:17'),
	(4,'BDBooking','purple','2026-09-25 23:23:17'),
	(5,'A',NULL,'2026-09-26 10:56:34'),
	(6,'B',NULL,'2026-09-26 10:58:52');

/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table schedule_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `schedule_events`;

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

DROP TABLE IF EXISTS `task_assignments`;

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

LOCK TABLES `task_assignments` WRITE;
/*!40000 ALTER TABLE `task_assignments` DISABLE KEYS */;

INSERT INTO `task_assignments` (`id`, `task_id`, `team_member_id`, `assigned_at`)
VALUES
	(2,121,1,'2026-09-26 01:04:00'),
	(3,117,2,'2026-09-26 01:10:11'),
	(4,123,2,'2026-09-26 01:11:01'),
	(8,128,1,'2026-09-26 03:15:24'),
	(10,130,2,'2026-09-26 03:16:00'),
	(11,129,1,'2026-09-26 03:16:15');

/*!40000 ALTER TABLE `task_assignments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_categories`;

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

LOCK TABLES `task_categories` WRITE;
/*!40000 ALTER TABLE `task_categories` DISABLE KEYS */;

INSERT INTO `task_categories` (`id`, `project_id`, `name`, `sort_order`, `created_at`)
VALUES
	(11,3,'Tweakings',10,'2026-09-26 10:51:50'),
	(12,5,'Tweakings',10,'2026-09-26 10:56:41'),
	(13,6,'Tweakings',10,'2026-09-26 10:58:57'),
	(14,4,'Agreed Scope',10,'2026-09-26 11:00:57'),
	(15,4,'Phase 1: Core Destination Discovery',20,'2026-09-26 11:00:57'),
	(16,4,'Filter Your Stay',30,'2026-09-26 11:00:57'),
	(17,4,'Property Matching Rules',40,'2026-09-26 11:00:57'),
	(18,4,'Tabs and Map',50,'2026-09-26 11:00:57'),
	(19,4,'Destination Information',60,'2026-09-26 11:00:57'),
	(20,4,'SEO, Sharing, and Language',70,'2026-09-26 11:00:57'),
	(21,4,'Spot Data and Content Model',80,'2026-09-26 11:00:57'),
	(22,4,'Performance, Accessibility, and States',90,'2026-09-26 11:00:57'),
	(23,4,'Verification and Acceptance',100,'2026-09-26 11:00:57'),
	(24,2,'Design',10,'2026-09-26 12:02:47');

/*!40000 ALTER TABLE `task_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_dependencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_dependencies`;

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



# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `parent_task_id` int(10) unsigned DEFAULT NULL,
  `body` varchar(500) NOT NULL,
  `assignee` varchar(150) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `priority` varchar(20) DEFAULT 'normal',
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

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `project_id`, `category_id`, `parent_task_id`, `body`, `assignee`, `due_date`, `completed`, `priority`, `completed_at`, `source_type`, `source_id`, `ai_generated`, `ai_reason`, `created_at`, `updated_at`)
VALUES
	(1,4,14,NULL,'Make the homepage **Go where Bangladesh feels unforgettable** destinations clickable.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(2,4,14,NULL,'Preserve the legacy dynamic route exactly:',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(3,4,14,NULL,'Keep `/Spot/Bangladesh/` fixed and load the final spot segment dynamically from the legacy/database slug.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(4,4,14,NULL,'Preserve existing legacy slug values instead of inventing new spellings or hyphenated URLs.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(5,4,14,NULL,'Support Cox\'s Bazar, Saint Martin, Jaflong Sylhet, and every other active legacy tourist spot.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(6,4,14,NULL,'Reuse the approved responsive city-results experience from `/hotels/{city}` rather than creating an unrelated visual system.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(7,4,14,NULL,'Keep the shared frontend header, currency and language controls, account controls, cart, mobile drawer, sticky mobile actions, and complete shared footer.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(8,4,14,NULL,'Keep English and Bengali behavior compatible with the existing application and legacy SEO requirements.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(9,4,15,NULL,'Inspect only the relevant legacy spot route, controller, model, tables, and view in `/Users/jerin/Sites/localhost-5.6/bdbooking` before implementation.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(10,4,15,NULL,'Identify the exact legacy route and controller method handling `/Spot/Bangladesh/{spot-slug}`.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(11,4,15,NULL,'Identify the respected CI4 models/tables for tourist spots and properties.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(12,4,15,NULL,'Confirm `tourist_spots.seo_name` as the legacy slug field.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(13,4,15,NULL,'Identify `tourist_spots_properties`, district, and coordinate relationships.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(14,4,15,NULL,'Add the CI4 route `/Spot/Bangladesh/(:segment)`.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(15,4,15,NULL,'Document the controller method with its purpose, router entry, HTTP method, and URL.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(16,4,15,NULL,'Resolve the spot dynamically and return 404 for an unknown or inactive slug.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(17,4,15,NULL,'Load real spot data, descriptions, coordinates, images, and matching properties through models.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(18,4,15,NULL,'Create a properly named production view under `app/Views/frontend/hotels/`; do not leave production dependent on a preview view.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(19,4,15,NULL,'Add required comments around every major view block:',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(20,4,15,NULL,'Build a responsive destination hero using available real spot and gallery images with a fallback.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(21,4,15,NULL,'Auto-rotate hero images with manual controls and reduced-motion support.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(22,4,15,NULL,'Prevent image loading and carousel transitions from causing layout shifts.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(23,4,15,NULL,'Show spot name, district, short destination appeal, location, and best visiting season when data exists.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(24,4,15,NULL,'Put destination, check-in, checkout, rooms, and guests search controls in or immediately below the hero.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(25,4,15,NULL,'Preserve existing search form element names and controller contracts.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(26,4,15,NULL,'Show a clear result heading such as **Properties near Cox\'s Bazar**.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(27,4,15,NULL,'Display the matching-property count and active search radius.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(28,4,15,NULL,'Default ordering and the displayed sort mode to **Nearest to tourist spot**.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(29,4,15,NULL,'Add nearest, recommended, lowest-price, highest-price, and star-rating sorting using real supported data.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(30,4,15,NULL,'Display distance from the selected spot on each property card.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(31,4,15,NULL,'Add approximate travel time only when reliably calculated and clearly label it as an estimate.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(32,4,15,NULL,'Keep hotel cards consistent with `/hotels/{city}`.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(33,4,15,NULL,'Link hotel cards to `/Bangladesh/{hotel-seo-name}`.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(34,4,15,NULL,'Load 10 properties initially.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(35,4,15,NULL,'Add an accessible **Load More** control that reveals the next 10.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(36,4,15,NULL,'Avoid numbered pagination for the primary browsing experience.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(37,4,15,NULL,'Preserve URL/query state while loading more results.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(38,4,15,NULL,'Lazy-load property images with stable dimensions.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(39,4,15,NULL,'Show a shimmer/skeleton placeholder while each image loads.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(40,4,15,NULL,'Use a local no-image fallback for missing or failed hotel photos.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(41,4,15,NULL,'Ensure slow images do not disappear permanently or leave malformed cards.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(42,4,16,NULL,'Add a desktop left sidebar titled **Filter your stay**, with results in the larger right column.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(43,4,16,NULL,'Reuse city-page price, star, and facility filter names with working spot-page filtering.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(44,4,16,NULL,'Provide a clear price range starting at `৳0` and supporting prices above `৳1000`.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(45,4,16,NULL,'Add working distance filters: within 2 km, 5 km, 10 km, and 20 km.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(46,4,16,NULL,'Add property type, star rating, guest rating, popular facilities, room facilities, and accessibility.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(47,4,16,NULL,'Add Pay at Property, Free Cancellation, Breakfast Included, Parking, and family-friendly options where supported.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(48,4,16,NULL,'Preserve legacy facility checkbox arrays and model contracts.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(49,4,16,NULL,'Show an active-filter count and removable chips without renaming legacy fields.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(50,4,16,NULL,'Provide working **Reset** and **Apply filters** actions.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(51,4,16,NULL,'On mobile, open filters in a fixed, safely scrollable drawer/bottom sheet.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(52,4,16,NULL,'Keep the mobile filter panel above sticky navigation and browser safe areas.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(53,4,16,NULL,'Lock background scrolling while filters are open.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(54,4,16,NULL,'Keep the price control and every field fully on-screen at narrow widths.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(55,4,17,NULL,'Prioritize properties explicitly linked to the selected spot.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(56,4,17,NULL,'Next include properties whose registered area matches the spot when that relationship is trustworthy.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(57,4,17,NULL,'Supplement results using latitude/longitude distance.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(58,4,17,NULL,'Never silently include unrelated district properties merely to increase result count.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(59,4,17,NULL,'Distinguish curated spot links from coordinate-derived nearby matches if both are shown.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(60,4,17,NULL,'Let visitors expand the radius to 10 km or 20 km.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(61,4,17,NULL,'If no properties exist initially, explain that and offer the next radius.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(62,4,17,NULL,'Use a proper geographic distance calculation and deterministic secondary ordering.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(63,4,17,NULL,'Do not call an external Maps API merely to sort straight-line distance.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(64,4,18,NULL,'Provide hotel-list, recommended, map, and destination-information tabs.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(65,4,18,NULL,'Preserve the active tab in the URL or hash.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(66,4,18,NULL,'Make tabs keyboard-accessible and usable on narrow screens.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(67,4,18,NULL,'Display every controller-provided matching property with valid coordinates on the map and report invalid map records separately.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(68,4,18,NULL,'Use a distinctive landmark marker for the selected spot.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(69,4,18,NULL,'Show hotel markers with photo, name, price, distance, **View Hotel**, and direct **Book Now**.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(70,4,18,NULL,'Show the visitor\'s current position only after explicit permission.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(71,4,18,NULL,'Add **Use my location** with clear success and error feedback.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(72,4,18,NULL,'Add **Search this area** after map pan or zoom.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(73,4,18,NULL,'Apply identical filters to map and list results and synchronize result counts.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(74,4,18,NULL,'Preserve map center, zoom, filters, spot, and dates in the URL where practical.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(75,4,18,NULL,'Remove or dismiss introductory map overlays after interaction.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(76,4,18,NULL,'Use local property-image URLs and the same missing-image fallback as the list.',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(77,4,19,NULL,'Add an attractive **About the destination** section from real content.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(78,4,19,NULL,'Add nearby attractions with image, distance, and working links where available.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(79,4,19,NULL,'Add local transportation and approximate fares.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(80,4,19,NULL,'Label fares as approximate and include a last-reviewed date where possible.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(81,4,19,NULL,'Add safety notices, permit requirements, opening times, accessibility, and family suitability where reliable.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(82,4,19,NULL,'Add district-relevant emergency contacts.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(83,4,19,NULL,'Add **Good to know before visiting** for tides, seasonal closures, weather risks, restrictions, or similar concerns.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(84,4,20,NULL,'Preserve all working legacy `/Spot/Bangladesh/{spot-slug}` URLs.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(85,4,20,NULL,'Use one canonical legacy slug per spot.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(86,4,20,NULL,'Redirect duplicate spellings or aliases to the canonical route.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(87,4,20,NULL,'Add canonical metadata and preserve shareable filtered URLs where appropriate.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(88,4,20,NULL,'Add Home → Bangladesh → Tourist spot breadcrumbs.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(89,4,20,NULL,'Add meaningful image alt text.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(90,4,20,NULL,'Add valid destination, breadcrumb, and hotel-list structured data.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(91,4,20,NULL,'Support Bengali destination content without losing spot, dates, guests, filters, or tab.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(92,4,20,NULL,'Preserve AddToAny or the approved sharing system with the canonical destination URL.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(93,4,21,NULL,'Prefer existing tables, models, and media folders over duplicate storage.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(94,4,22,NULL,'Optimize hero/listing images into responsive sizes and modern formats where supported.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(95,4,22,NULL,'Prioritize only the first meaningful image and defer below-the-fold media.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(96,4,22,NULL,'Avoid loading every hotel image or map popup during initial render.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(97,4,22,NULL,'Ensure labels, focus states, keyboard support, and suitable touch targets.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(98,4,22,NULL,'Respect `prefers-reduced-motion` for rotation, shimmer, and panels.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(99,4,22,NULL,'Prevent horizontal overflow and right-side blank space on mobile.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(100,4,22,NULL,'Prevent overlapping text, prices, controls, and map overlays.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(101,4,22,NULL,'Design useful loading, empty, error, permission-denied, and no-results states.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(102,4,23,NULL,'Verify multiple real legacy slugs, not only Cox\'s Bazar.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(103,4,23,NULL,'Verify unknown and inactive slugs.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(104,4,23,NULL,'Verify results and distance ordering against database coordinates.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(105,4,23,NULL,'Verify filters independently and in combination.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(106,4,23,NULL,'Verify all tabs use the intended filtered dataset.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(107,4,23,NULL,'Verify Load More returns each property once and preserves ordering.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(108,4,23,NULL,'Verify missing, slow, and broken images.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(109,4,23,NULL,'Verify location permission accepted, denied, and unavailable states.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(110,4,23,NULL,'Verify English/Bengali switching and canonical URLs.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(111,4,23,NULL,'Verify desktop, tablet, and narrow-mobile layouts without overflow.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(112,4,23,NULL,'Verify mobile filter height, scrolling, backdrop, closing, and sticky actions.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(113,4,23,NULL,'Verify shared header, footer, account, cart, language, currency, and navigation.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(114,4,23,NULL,'Run focused PHP syntax checks and relevant automated tests.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(115,4,23,NULL,'Perform desktop/mobile browser screenshots and interaction checks before Phase 1 is complete.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 11:00:57',NULL),
	(116,5,12,NULL,'Test1',NULL,NULL,1,'normal','2026-09-26 01:56:55','manual',NULL,0,NULL,'2026-09-26 00:39:05','2026-09-26 01:56:55'),
	(117,6,13,NULL,'Mobile Responsive',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 00:42:09','2026-09-26 01:10:25'),
	(118,6,13,NULL,'Push Notifification',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 00:42:09','2026-09-26 00:42:09'),
	(119,5,12,NULL,'Hello1',NULL,'2026-09-29',1,'normal','2026-09-26 01:56:54','manual',NULL,0,NULL,'2026-09-26 00:48:40','2026-09-26 01:56:54'),
	(120,2,NULL,NULL,'hello world',NULL,NULL,1,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 00:57:22','2026-09-26 00:57:25'),
	(121,2,24,NULL,'Hello1',NULL,'2026-09-30',1,'normal','2026-09-26 01:56:53','manual',NULL,0,NULL,'2026-09-26 00:57:50','2026-09-26 01:56:53'),
	(122,6,NULL,NULL,'hello1',NULL,NULL,1,'normal','2026-09-26 01:56:53','manual',NULL,0,NULL,'2026-09-26 01:10:40','2026-09-26 01:56:53'),
	(123,6,13,NULL,'hello2',NULL,'2026-09-28',1,'normal','2026-09-26 01:56:52','manual',NULL,0,NULL,'2026-09-26 01:10:43','2026-09-26 01:56:52'),
	(124,6,13,NULL,'hello3',NULL,'2026-09-29',1,'high','2026-09-26 01:56:51','manual',NULL,0,NULL,'2026-09-26 01:14:31','2026-09-26 01:56:51'),
	(125,6,NULL,NULL,'hello4',NULL,NULL,1,'normal','2026-09-26 01:56:50','manual',NULL,0,NULL,'2026-09-26 01:45:57','2026-09-26 01:56:50'),
	(126,6,13,NULL,'hello5',NULL,NULL,1,'urgent','2026-09-26 01:56:49','manual',NULL,0,NULL,'2026-09-26 01:54:47','2026-09-26 01:56:49'),
	(127,6,NULL,NULL,'hello',NULL,NULL,0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 02:25:26','2026-09-26 02:25:34'),
	(128,6,NULL,NULL,'Optimize the room availability API and reduce unnecessary database queries.',NULL,'2026-09-30',0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 03:15:24','2026-09-26 03:15:24'),
	(129,6,NULL,NULL,'Prepare the complete booking-flow QA test plan.',NULL,'2026-10-03',0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 03:15:59','2026-09-26 03:16:15'),
	(130,6,NULL,NULL,'Prepare the pilot hotel list with the operations team.',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:00','2026-09-26 03:16:00'),
	(131,6,NULL,NULL,'Define pilot hotel selection criteria with the operations team',NULL,NULL,0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:37','2026-09-26 03:16:37'),
	(132,6,NULL,NULL,'Gather candidate hotel data from available operational and partner sources',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:37','2026-09-26 03:16:37'),
	(133,6,NULL,NULL,'Verify each candidate hotel’s location, room inventory, contact details, and operational readiness',NULL,NULL,0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:37','2026-09-26 03:16:37'),
	(134,6,NULL,NULL,'Assess candidates against the agreed pilot criteria and identify risks or dependencies',NULL,NULL,0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:37','2026-09-26 03:16:37'),
	(135,6,NULL,NULL,'Review the shortlisted hotels with the operations team and collect approval or changes',NULL,NULL,0,'high',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:37','2026-09-26 03:16:37'),
	(136,6,NULL,NULL,'Publish the finalized pilot hotel list with key contacts, status, and next steps',NULL,NULL,0,'normal',NULL,'manual',NULL,0,NULL,'2026-09-26 03:16:37','2026-09-26 03:16:37');

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table team_members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `team_members`;

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

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;

INSERT INTO `team_members` (`id`, `name`, `email`, `job_title`, `phone`, `photo`, `status`, `created_at`, `updated_at`, `role_description`, `skills`, `responsibilities`, `ai_assignment_enabled`)
VALUES
	(1,'ZERIN','zerin@bdbooking.com','CEO','01613243553','uploads/team/1790403542_5caaf2c5c8a162031bdd.jpg','active','2026-09-26 00:55:46','2026-09-26 03:05:14',NULL,'[]','[]',1),
	(2,'Zaara','zara@bdbooking.com','UI Designer',NULL,'uploads/team/1790402323_200b8daf9181a9cdc599.jpeg','active','2026-09-26 00:58:43','2026-09-26 00:58:43',NULL,NULL,NULL,1);

/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
