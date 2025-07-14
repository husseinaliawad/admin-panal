-- MySQL Setup Script for Admin Panel
-- Run this script in your MySQL client (phpMyAdmin, MySQL Workbench, etc.)

CREATE DATABASE IF NOT EXISTS admin_panel 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Use the database
USE admin_panel;

-- Show confirmation
SELECT 'Database admin_panel created successfully!' as message;

-- Show current databases
SHOW DATABASES; 