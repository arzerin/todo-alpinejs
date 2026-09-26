<?php
/*
 * Merge these fields into your existing models.
 *
 * TaskModel::$allowedFields add:
 * 'parent_task_id','source_type','source_id','ai_generated','ai_reason'
 *
 * TeamMemberModel::$allowedFields add:
 * 'role_description','skills','responsibilities','ai_assignment_enabled'
 *
 * ProjectMemberModel::$allowedFields add:
 * 'role_description','responsibilities'
 *
 * IMPORTANT: ProjectMemberModel should keep:
 * protected $useTimestamps = false;
 * because your current project_members table has no updated_at column.
 */
