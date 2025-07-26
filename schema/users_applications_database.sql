-- Use the collegefinder database
USE collegefinder;

-- Add full_name column if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'users' 
                     AND column_name = 'full_name');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE users ADD COLUMN full_name VARCHAR(100) DEFAULT NULL AFTER email',
              'SELECT "Column full_name already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add phone column if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'users' 
                     AND column_name = 'phone');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER full_name',
              'SELECT "Column phone already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add address column if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'users' 
                     AND column_name = 'address');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE users ADD COLUMN address TEXT DEFAULT NULL AFTER phone',
              'SELECT "Column address already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add profile_picture column if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'users' 
                     AND column_name = 'profile_picture');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) DEFAULT "default.jpg" AFTER address',
              'SELECT "Column profile_picture already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add updated_at column if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'users' 
                     AND column_name = 'updated_at');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at',
              'SELECT "Column updated_at already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Update existing users with default values for profile_picture if NULL
UPDATE users 
SET profile_picture = 'default.jpg'
WHERE profile_picture IS NULL;

-- For full_name, set it to username where it's NULL
UPDATE users 
SET full_name = username
WHERE full_name IS NULL;

-- Add user_id column to college_applications table if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'college_applications' 
                     AND column_name = 'user_id');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE college_applications ADD COLUMN user_id INT DEFAULT NULL AFTER id, ADD INDEX idx_user_id (user_id), ADD CONSTRAINT fk_user_college_app FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL',
              'SELECT "Column user_id in college_applications already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Try to add user_id column to scholarship_applications table if it exists
-- This is wrapped in a procedure to handle the case where the table doesn't exist
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS add_user_id_to_scholarship_applications()
BEGIN
    -- Check if scholarship_applications table exists
    IF EXISTS (SELECT * FROM information_schema.tables 
               WHERE table_schema = 'collegefinder' 
               AND table_name = 'scholarship_applications') THEN
        
        -- Check if user_id column doesn't already exist
        IF NOT EXISTS (SELECT * FROM information_schema.columns 
                      WHERE table_schema = 'collegefinder'
                      AND table_name = 'scholarship_applications'
                      AND column_name = 'user_id') THEN
            
            -- Add the column
            ALTER TABLE scholarship_applications
            ADD COLUMN user_id INT DEFAULT NULL AFTER id,
            ADD INDEX idx_user_id (user_id),
            ADD CONSTRAINT fk_user_scholarship_app FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;
        END IF;
    END IF;
END //
DELIMITER ;

-- Call the procedure
CALL add_user_id_to_scholarship_applications();

-- Drop the procedure
DROP PROCEDURE IF EXISTS add_user_id_to_scholarship_applications;

-- Update any existing college applications to link to the first user as a default
UPDATE college_applications SET user_id = 1 WHERE user_id IS NULL;

-- Update any existing scholarship applications to link to the first user as a default (if table exists)
SET @scholarship_table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                                WHERE table_schema = 'collegefinder' 
                                AND table_name = 'scholarship_applications');

SET @update_query = IF(@scholarship_table_exists > 0, 
                     'UPDATE scholarship_applications SET user_id = 1 WHERE user_id IS NULL', 
                     'SELECT 1');

PREPARE stmt FROM @update_query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt; 