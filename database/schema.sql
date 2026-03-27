-- ============================================================
-- Project Vault & Collaboration Hub
-- Regional Maritime University
-- Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS `vault_collab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `vault_collab`;

-- ============================================================
-- DEPARTMENTS & PROGRAMS
-- ============================================================

CREATE TABLE `departments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `code` VARCHAR(20) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `hod_id` INT UNSIGNED NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `programs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL,
    `code` VARCHAR(20) NOT NULL UNIQUE,
    `department_id` INT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- USERS
-- ============================================================

CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `index_number` VARCHAR(50) NULL UNIQUE,
    `phone` VARCHAR(20) NULL,
    `password_hash` VARCHAR(255) NULL,
    `role` ENUM('admin','hod','supervisor','student') NOT NULL DEFAULT 'student',
    `department_id` INT UNSIGNED NULL,
    `program_id` INT UNSIGNED NULL,
    `profile_photo` VARCHAR(255) NULL,
    `is_verified` TINYINT(1) DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `email_verified_at` TIMESTAMP NULL,
    `verification_token` VARCHAR(255) NULL,
    `reset_token` VARCHAR(255) NULL,
    `reset_token_expires` TIMESTAMP NULL,
    `remember_token` VARCHAR(255) NULL,
    `last_login` TIMESTAMP NULL,
    `is_uploaded` TINYINT(1) DEFAULT 0 COMMENT 'Whether the student was uploaded via CSV',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`program_id`) REFERENCES `programs`(`id`) ON DELETE SET NULL,
    INDEX `idx_role` (`role`),
    INDEX `idx_department` (`department_id`),
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB;

-- Add HOD foreign key to departments
ALTER TABLE `departments` ADD FOREIGN KEY (`hod_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;

-- ============================================================
-- GROUPS
-- ============================================================

CREATE TABLE `groups` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL,
    `department_id` INT UNSIGNED NOT NULL,
    `created_by` INT UNSIGNED NOT NULL,
    `created_by_role` ENUM('student','hod') NOT NULL DEFAULT 'student',
    `status` ENUM('active','inactive','completed') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_department` (`department_id`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB;

CREATE TABLE `group_members` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `role` ENUM('leader','member') DEFAULT 'member',
    `joined_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_group_member` (`group_id`, `user_id`)
) ENGINE=InnoDB;

-- ============================================================
-- REPOSITORY REQUESTS
-- ============================================================

CREATE TABLE `repo_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `objectives` TEXT NULL,
    `expected_deliverables` TEXT NULL,
    `status` ENUM('pending','approved','declined') DEFAULT 'pending',
    `hod_comment` TEXT NULL,
    `reviewed_by` INT UNSIGNED NULL,
    `reviewed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`reviewed_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB;

-- ============================================================
-- REPOSITORIES
-- ============================================================

CREATE TABLE `repositories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group_id` INT UNSIGNED NOT NULL,
    `request_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `supervisor_id` INT UNSIGNED NULL,
    `status` ENUM('active','submitted','under_review','completed','archived') DEFAULT 'active',
    `is_archived` TINYINT(1) DEFAULT 0,
    `archived_at` TIMESTAMP NULL,
    `archived_by` INT UNSIGNED NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`request_id`) REFERENCES `repo_requests`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`supervisor_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`archived_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_status` (`status`),
    INDEX `idx_supervisor` (`supervisor_id`)
) ENGINE=InnoDB;

-- ============================================================
-- REPOSITORY FILES
-- ============================================================

CREATE TABLE `repo_files` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `repo_id` INT UNSIGNED NOT NULL,
    `parent_id` INT UNSIGNED NULL,
    `name` VARCHAR(255) NOT NULL,
    `type` ENUM('file','folder') NOT NULL,
    `content` LONGTEXT NULL COMMENT 'File content for text files',
    `file_path` VARCHAR(500) NULL COMMENT 'Path for binary/uploaded files',
    `mime_type` VARCHAR(100) NULL,
    `file_size` BIGINT UNSIGNED DEFAULT 0,
    `language` VARCHAR(50) NULL COMMENT 'Programming language detected',
    `created_by` INT UNSIGNED NOT NULL,
    `last_modified_by` INT UNSIGNED NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`parent_id`) REFERENCES `repo_files`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`last_modified_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_repo` (`repo_id`),
    INDEX `idx_parent` (`parent_id`)
) ENGINE=InnoDB;

-- ============================================================
-- FILE VERSION HISTORY
-- ============================================================

CREATE TABLE `file_versions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `file_id` INT UNSIGNED NOT NULL,
    `content` LONGTEXT NULL,
    `version_number` INT UNSIGNED NOT NULL,
    `change_summary` VARCHAR(500) NULL,
    `changed_by` INT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`file_id`) REFERENCES `repo_files`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`changed_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_file` (`file_id`)
) ENGINE=InnoDB;

-- ============================================================
-- FILE COMMENTS
-- ============================================================

CREATE TABLE `file_comments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `file_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `line_number` INT UNSIGNED NULL COMMENT 'Specific line number, NULL for general comment',
    `comment` TEXT NOT NULL,
    `is_resolved` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`file_id`) REFERENCES `repo_files`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_file` (`file_id`)
) ENGINE=InnoDB;

-- ============================================================
-- LOGBOOK
-- ============================================================

CREATE TABLE `logbook_entries` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `repo_id` INT UNSIGNED NOT NULL,
    `serial_no` INT UNSIGNED NOT NULL,
    `activity` TEXT NOT NULL,
    `student_id` INT UNSIGNED NOT NULL,
    `date_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_repo` (`repo_id`)
) ENGINE=InnoDB;

CREATE TABLE `supervisor_remarks` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `logbook_entry_id` INT UNSIGNED NOT NULL,
    `supervisor_id` INT UNSIGNED NOT NULL,
    `remark` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`logbook_entry_id`) REFERENCES `logbook_entries`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`supervisor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- MESSAGES (Chat)
-- ============================================================

CREATE TABLE `messages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group_id` INT UNSIGNED NOT NULL,
    `sender_id` INT UNSIGNED NOT NULL,
    `message` TEXT NULL,
    `type` ENUM('text','image','voice','system') DEFAULT 'text',
    `file_path` VARCHAR(500) NULL,
    `file_name` VARCHAR(255) NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_group` (`group_id`),
    INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB;

-- ============================================================
-- NOTICES (Supervisor, 2-day expiry)
-- ============================================================

CREATE TABLE `notices` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `repo_id` INT UNSIGNED NOT NULL,
    `supervisor_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`supervisor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_expires` (`expires_at`)
) ENGINE=InnoDB;

-- ============================================================
-- MEETINGS
-- ============================================================

CREATE TABLE `meetings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `repo_id` INT UNSIGNED NOT NULL,
    `scheduled_by` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `meeting_date` DATE NOT NULL,
    `meeting_time` TIME NOT NULL,
    `duration_minutes` INT UNSIGNED DEFAULT 60,
    `jitsi_room_id` VARCHAR(255) NOT NULL,
    `status` ENUM('scheduled','in_progress','completed','cancelled') DEFAULT 'scheduled',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`scheduled_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_date` (`meeting_date`)
) ENGINE=InnoDB;

CREATE TABLE `meeting_attendees` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `meeting_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `status` ENUM('invited','accepted','declined') DEFAULT 'invited',
    FOREIGN KEY (`meeting_id`) REFERENCES `meetings`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_attendee` (`meeting_id`, `user_id`)
) ENGINE=InnoDB;

-- ============================================================
-- PROJECT SUBMISSIONS
-- ============================================================

CREATE TABLE `project_submissions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `repo_id` INT UNSIGNED NOT NULL,
    `submitted_by` INT UNSIGNED NOT NULL,
    `submission_type` ENUM('to_supervisor','to_hod') NOT NULL,
    `status` ENUM('pending','accepted','declined') DEFAULT 'pending',
    `comments` TEXT NULL,
    `reviewed_by` INT UNSIGNED NULL,
    `reviewed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`submitted_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`reviewed_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    INDEX `idx_repo` (`repo_id`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB;

-- ============================================================
-- ARCHIVED PROJECTS (Immutable snapshots)
-- ============================================================

CREATE TABLE `archived_projects` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `repo_id` INT UNSIGNED NOT NULL,
    `group_name` VARCHAR(200) NOT NULL,
    `project_title` VARCHAR(255) NOT NULL,
    `department_id` INT UNSIGNED NOT NULL,
    `supervisor_name` VARCHAR(200) NULL,
    `members` JSON NOT NULL COMMENT 'Snapshot of group members',
    `snapshot_data` JSON NOT NULL COMMENT 'Full project snapshot (files, logbook, chapters)',
    `archived_by` INT UNSIGNED NOT NULL,
    `archived_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`archived_by`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_department` (`department_id`)
) ENGINE=InnoDB;

-- ============================================================
-- NOTIFICATIONS
-- ============================================================

CREATE TABLE `notifications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `type` VARCHAR(50) NOT NULL COMMENT 'e.g. repo_approved, comment, meeting, submission',
    `reference_id` INT UNSIGNED NULL COMMENT 'ID of relevant record',
    `reference_type` VARCHAR(50) NULL COMMENT 'e.g. repository, group, file',
    `is_read` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_user_read` (`user_id`, `is_read`),
    INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB;

-- ============================================================
-- CHEAT SHEETS
-- ============================================================

CREATE TABLE `cheat_sheets` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `language` VARCHAR(50) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `code` TEXT NOT NULL,
    `category` VARCHAR(100) NOT NULL COMMENT 'e.g. Variables, Loops, Functions, OOP',
    `difficulty` ENUM('beginner','intermediate','advanced') DEFAULT 'beginner',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_language` (`language`),
    INDEX `idx_category` (`category`)
) ENGINE=InnoDB;

-- ============================================================
-- LEARNING RESOURCES
-- ============================================================

CREATE TABLE `learning_resources` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `youtube_url` VARCHAR(500) NOT NULL,
    `thumbnail_url` VARCHAR(500) NULL,
    `department_id` INT UNSIGNED NULL COMMENT 'NULL means available to all',
    `category` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL,
    INDEX `idx_department` (`department_id`),
    INDEX `idx_category` (`category`)
) ENGINE=InnoDB;

-- ============================================================
-- USER SETTINGS
-- ============================================================

CREATE TABLE `user_settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_user_setting` (`user_id`, `setting_key`)
) ENGINE=InnoDB;

-- ============================================================
-- ACTIVITY LOG (for progress tracking)
-- ============================================================

CREATE TABLE `activity_log` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `repo_id` INT UNSIGNED NULL,
    `action` VARCHAR(100) NOT NULL COMMENT 'e.g. file_created, file_edited, comment_added',
    `description` TEXT NULL,
    `metadata` JSON NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`repo_id`) REFERENCES `repositories`(`id`) ON DELETE SET NULL,
    INDEX `idx_user` (`user_id`),
    INDEX `idx_repo` (`repo_id`),
    INDEX `idx_created` (`created_at`)
) ENGINE=InnoDB;

-- ============================================================
-- CODE PLAYGROUND SNIPPETS
-- ============================================================

CREATE TABLE `playground_snippets` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `html_code` TEXT NULL,
    `css_code` TEXT NULL,
    `js_code` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    INDEX `idx_user` (`user_id`)
) ENGINE=InnoDB;
