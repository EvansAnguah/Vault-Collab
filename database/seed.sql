-- ============================================================
-- Seed Data for Project Vault & Collaboration Hub
-- Regional Maritime University
-- ============================================================

USE `vault_collab`;

-- ============================================================
-- DEFAULT ADMIN ACCOUNT
-- Password: Admin@2025 (bcrypt hashed)
-- ============================================================
INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `password_hash`, `role`, `is_verified`, `is_active`, `email_verified_at`) VALUES
('System', 'Administrator', 'admin@rmu.edu.gh', '0200000000', '$2y$12$LJ3m4yK8g5Z7xB0N9vR3aeW8QwX1nF6hD2cR4tP5oY7iU1kM3jS5e', 'admin', 1, 1, NOW());

-- ============================================================
-- DEPARTMENTS
-- ============================================================
INSERT INTO `departments` (`name`, `code`, `description`) VALUES
('Department of Computer Science & IT', 'CSIT', 'Computer Science & Information Technology programs'),
('Department of Electrical & Electronic Engineering', 'EEE', 'Electrical, Electronic and Communication Engineering'),
('Department of Marine Engineering', 'ME', 'Marine Engineering and Naval Architecture'),
('Department of Nautical Science', 'NS', 'Nautical Science and Maritime Operations'),
('Department of Port & Shipping Management', 'PSM', 'Port, Shipping and Logistics Management'),
('Department of Mathematics & Statistics', 'MATH', 'Applied Mathematics and Statistics'),
('Department of Liberal Studies', 'LS', 'Communication, Social Studies and Humanities');

-- ============================================================
-- PROGRAMS (Mapped to departments)
-- ============================================================

-- Computer Science & IT (dept_id=1)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BSc. Computer Science', 'BSC-CS', 1),
('BSc. Information Technology', 'BSC-IT', 1),
('BSc. Cyber Security', 'BSC-CYBER', 1),
('Diploma in Computer Science', 'DIP-CS', 1);

-- Electrical & Electronic Engineering (dept_id=2)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BSc. Electrical & Electronic Engineering', 'BSC-EEE', 2),
('BSc. Telecommunication Engineering', 'BSC-TELCOM', 2),
('Diploma in Electrical Engineering', 'DIP-EE', 2);

-- Marine Engineering (dept_id=3)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BSc. Marine Engineering', 'BSC-ME', 3),
('BSc. Mechanical Engineering', 'BSC-MECH', 3),
('Diploma in Marine Engineering', 'DIP-ME', 3);

-- Nautical Science (dept_id=4)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BSc. Nautical Science', 'BSC-NS', 4),
('Diploma in Nautical Science', 'DIP-NS', 4);

-- Port & Shipping Management (dept_id=5)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BSc. Port & Shipping Administration', 'BSC-PSA', 5),
('BSc. Logistics & Supply Chain Management', 'BSC-LSCM', 5),
('Diploma in Port Operations', 'DIP-PO', 5);

-- Mathematics & Statistics (dept_id=6)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BSc. Mathematics', 'BSC-MATH', 6),
('BSc. Statistics', 'BSC-STAT', 6);

-- Liberal Studies (dept_id=7)
INSERT INTO `programs` (`name`, `code`, `department_id`) VALUES
('BA. Communication Studies', 'BA-COMM', 7),
('BA. Social Studies', 'BA-SS', 7);
