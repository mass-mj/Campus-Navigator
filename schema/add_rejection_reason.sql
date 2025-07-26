-- Use the collegefinder database
USE collegefinder;

-- Add rejection_reason column to college_applications table
-- This fixes the error: Unknown column 'rejection_reason' in 'field list'

-- Check if the column already exists before adding it
SET @columnExists = 0;
SELECT COUNT(*) INTO @columnExists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'collegefinder' 
AND TABLE_NAME = 'college_applications' 
AND COLUMN_NAME = 'rejection_reason';

-- Only add the column if it doesn't exist
SET @query = IF(@columnExists = 0, 
    'ALTER TABLE college_applications ADD COLUMN rejection_reason TEXT DEFAULT NULL COMMENT "Reason for application rejection"', 
    'SELECT "Column rejection_reason already exists in college_applications table."');

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Notify completion
SELECT CONCAT('Schema updated on ', NOW()) AS 'Status'; 