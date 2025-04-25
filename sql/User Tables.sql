-- Create database if not exists
CREATE DATABASE IF NOT EXISTS cs6314;
USE cs6314;

-- Drop existing tables for clean reset
DROP TABLE IF EXISTS userlog;
DROP TABLE IF EXISTS user;

-- User Table
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'user') NOT NULL,
    user_status ENUM('active', 'inactive', 'revoked', 'deleted') DEFAULT 'active',
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- User Log Table
CREATE TABLE userlog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid VARCHAR(50) NOT NULL,
    login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    logout_time DATETIME,
    session_id VARCHAR(255)
);
