-- Use the collegefinder database
USE collegefinder;

-- Add role column to users table if it doesn't exist
SET @columnExists = (SELECT COUNT(*) 
                     FROM information_schema.columns 
                     WHERE table_schema = 'collegefinder' 
                     AND table_name = 'users' 
                     AND column_name = 'role');
                     
SET @stmt = IF(@columnExists = 0, 
              'ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT "user" AFTER password',
              'SELECT "Column role already exists"');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Set the first user as admin
UPDATE users SET role = 'admin' WHERE id = 1;

-- Show the update was successful
SELECT 'Role column added to users table and first user set as admin' AS result; 