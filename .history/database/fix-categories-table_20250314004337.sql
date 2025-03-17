-- Run this SQL directly in your database management tool if migrations don't work
ALTER TABLE categories ADD COLUMN slug VARCHAR(255) UNIQUE AFTER name;
