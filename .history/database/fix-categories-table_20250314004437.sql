-- Run this SQL directly in your database management tool if migrations don't work
ALTER TABLE categories ADD COLUMN slug VARCHAR(255) UNIQUE AFTER name;
ALTER TABLE categories ADD COLUMN parent_id BIGINT UNSIGNED NULL AFTER is_active;
ALTER TABLE categories ADD CONSTRAINT categories_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL;
