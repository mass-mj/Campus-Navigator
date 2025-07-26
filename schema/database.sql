-- Database creation
CREATE DATABASE IF NOT EXISTS collegefinder;
USE collegefinder;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin user
INSERT INTO users (username, password, email, role) VALUES 
('admin', 'admin123', 'admin@collegefinder.com', 'admin');

-- Insert sample regular user
INSERT INTO users (username, password, email, role) VALUES 
('user', 'user123', 'user@example.com', 'user'); 