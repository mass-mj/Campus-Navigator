# SQL Changes for Google Maps Integration

## Background
We are updating the colleges table to include a link to Google Maps for each college. This will replace the previous Leaflet maps implementation with a direct link to Google Maps.

## Required SQL Changes

Please execute the following SQL through phpMyAdmin:

```sql
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
```

## Instructions

1. Open your web browser and navigate to phpMyAdmin (http://localhost/phpmyadmin)
2. Log in using your MySQL credentials
3. Select the 'collegefinder' database from the left sidebar
4. Click on the "SQL" tab at the top
5. Copy and paste the SQL code above
6. Click "Go" to execute the SQL

## Verification

After executing the SQL, you can verify the changes by:

1. Selecting the 'colleges' table in phpMyAdmin
2. Checking that a new column 'google_maps_url' has been added
3. Verifying that the URLs have been populated for existing college records

## Updates to the Website

The following changes have been made:
1. The college details page now uses a Google Maps button instead of Leaflet maps
2. The admin panel now has a field to edit the Google Maps URL for each college
3. When adding a new college, administrators can specify a custom Google Maps URL 