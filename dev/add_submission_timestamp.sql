-- Add submission_timestamp column to disease_reports table
-- Run this script to update the existing table structure

ALTER TABLE `disease_reports` 
ADD COLUMN `submission_timestamp` datetime DEFAULT NULL 
AFTER `observation_date`;

-- Update existing records to have submission_timestamp equal to created_at
UPDATE `disease_reports` 
SET `submission_timestamp` = `created_at` 
WHERE `submission_timestamp` IS NULL;
