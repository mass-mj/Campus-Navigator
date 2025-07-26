-- Add user_id column to scholarship_applications table
USE collegefinder;

-- Check if column exists before attempting to add it
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'scholarship_applications' 
                     AND column_name = 'user_id');
                     
-- Only add the column if it doesn't exist
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE scholarship_applications 
               ADD COLUMN user_id INT DEFAULT NULL AFTER id, 
               ADD INDEX idx_user_id (user_id), 
               ADD CONSTRAINT fk_user_scholarship_app 
               FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL',
              'SELECT "Column user_id already exists"');

PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- DO NOT update existing scholarship applications with user_id = 1
-- Instead, let them remain NULL until properly associated with users
-- We'll handle this in the application code
