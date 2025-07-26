-- Use the existing database
USE collegefinder;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    profile_picture VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add user_id column to existing tables if not exists
ALTER TABLE college_applications 
ADD COLUMN IF NOT EXISTS user_id INT,
ADD CONSTRAINT fk_college_app_user 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

ALTER TABLE scholarship_applications 
ADD COLUMN IF NOT EXISTS user_id INT,
ADD CONSTRAINT fk_scholarship_app_user 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Insert a sample user
INSERT INTO users (username, email, password, full_name) 
VALUES ('testuser', 'test@example.com', 'password123', 'Test User')
ON DUPLICATE KEY UPDATE username=username; 