-- ============================================
--  Student Records Database Setup
--  Run this in phpMyAdmin or MySQL CLI:
--    mysql -u root -p < database.sql
-- ============================================

CREATE DATABASE IF NOT EXISTS student_db;
USE student_db;

CREATE TABLE IF NOT EXISTS students (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    student_id  VARCHAR(20)  NOT NULL UNIQUE,
    first_name  VARCHAR(50)  NOT NULL,
    last_name   VARCHAR(50)  NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    course      VARCHAR(100) NOT NULL,
    year_level  TINYINT      NOT NULL CHECK (year_level BETWEEN 1 AND 5),
    gpa         DECIMAL(3,2) DEFAULT 0.00,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample Data
INSERT INTO students (student_id, first_name, last_name, email, course, year_level, gpa) VALUES
('2024-0001', 'Maria',  'Santos',    'maria.santos@school.edu',    'BS Computer Science',       3, 1.75),
('2024-0002', 'Jose',   'Reyes',     'jose.reyes@school.edu',      'BS Information Technology', 2, 2.00),
('2024-0003', 'Ana',    'Cruz',      'ana.cruz@school.edu',        'BS Computer Engineering',   4, 1.50),
('2024-0004', 'Miguel', 'Dela Cruz', 'miguel.delacruz@school.edu', 'BS Computer Science',       1, 2.25);
