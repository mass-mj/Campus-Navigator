-- Add Google Maps URL column to colleges table
USE collegefinder;

-- Add the Google Maps URL column
ALTER TABLE colleges ADD COLUMN google_maps_url VARCHAR(255) DEFAULT NULL;

-- Update existing records with sample Google Maps URLs
UPDATE colleges SET google_maps_url = CASE
    WHEN city = 'Mumbai' THEN 'https://www.google.com/maps?q=IIT+Bombay'
    WHEN city = 'New Delhi' THEN 'https://www.google.com/maps?q=IIT+Delhi'
    WHEN city = 'Bangalore' THEN 'https://www.google.com/maps?q=IISc+Bangalore'
    WHEN city = 'Cambridge' AND country = 'USA' THEN 'https://www.google.com/maps?q=MIT+Cambridge+MA'
    ELSE CONCAT('https://www.google.com/maps?q=', REPLACE(name, ' ', '+'))
END;

-- Note for execution:
-- Run this SQL to add the Google Maps URL column to the colleges table.
-- Administrators can then update each college with a specific Google Maps URL
-- through the admin panel. 