-- sample products so the shop page has something to show (the design has 8)
-- image_name is a file in assets/images/products/, a grey "image" box shows until the file is added
INSERT INTO `products` (`product_name`, `product_description`, `product_price`, `supplier`, `image_name`, `daily_stock`) VALUES
('Free range eggs', 'Box of six eggs from the farm.', 2.50, 'Diddly Squat Farm', 'eggs.jpg', 40),
('Smoked bacon', 'Dry cured smoked back bacon, 250g.', 4.20, 'Diddly Squat Farm', 'bacon.jpg', 25),
('Pork sausages', 'Pack of six outdoor reared pork sausages.', 4.50, 'Diddly Squat Farm', 'sausages.jpg', 30),
('Local honey', 'Jar of raw local honey, 340g.', 6.00, 'Diddly Squat Farm', 'honey.jpg', 20),
('Sourdough loaf', 'Baked fresh every morning.', 3.80, 'Diddly Squat Farm', 'sourdough.jpg', 15),
('Farmhouse cheddar', 'Mature cheddar, 200g wedge.', 5.50, 'Diddly Squat Farm', 'cheddar.jpg', 18),
('Seasonal veg box', 'A mix of whatever is in season this week.', 12.00, 'Diddly Squat Farm', 'vegbox.jpg', 10),
('Farm shop tote bag', 'Canvas shopping bag with the farm shop logo.', 8.00, 'Diddly Squat Farm', 'tote.jpg', 50);
