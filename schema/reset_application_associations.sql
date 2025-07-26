-- Reset user associations for all applications
USE collegefinder;

-- Set user_id to NULL for all college applications
UPDATE college_applications SET user_id = NULL;

-- Set user_id to NULL for all scholarship applications
UPDATE scholarship_applications SET user_id = NULL WHERE user_id IS NOT NULL;

-- Confirm changes
SELECT 'College applications reset' as message, COUNT(*) as count FROM college_applications WHERE user_id IS NULL;
SELECT 'Scholarship applications reset' as message, COUNT(*) as count FROM scholarship_applications WHERE user_id IS NULL;
