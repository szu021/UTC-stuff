-- only needed if farm_shop is already imported from the old farm_shop.sql
-- (a fresh import of the new farm_shop.sql already has these changes)

-- the design sign up page has no date of birth box
ALTER TABLE `users` DROP COLUMN `dob`;

-- prices need pence, e.g. 2.50
ALTER TABLE `products` MODIFY `product_price` decimal(8,2) NOT NULL;
