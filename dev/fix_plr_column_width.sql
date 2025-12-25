-- Fix for truncated PLR numbers
-- The PLR number requires more than 20 characters.
-- Run this script in your database management tool (e.g., PHPMyAdmin)

ALTER TABLE disease_reports MODIFY COLUMN plrNumber VARCHAR(50);
