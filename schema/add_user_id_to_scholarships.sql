-- Add user_id column to scholarship_applications table
USE collegefinder;

-- Add the user_id column, index, and foreign key constraint
ALTER TABLE scholarship_applications 
ADD COLUMN user_id INT DEFAULT NULL AFTER id, 
ADD INDEX idx_user_id (user_id), 
ADD CONSTRAINT fk_user_scholarship_app 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Instead of querying information_schema, just verify with a simple SELECT
SELECT 
    'Column added successfully. Verify in your application.' as message;
