-- run this after v1.sql and v2.sql, adds the user accounts and what each user owns
-- the database name is Gconsole

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_console`
-- one row for every console a user owns (a user can own the same console twice, e.g. two regions)
--

CREATE TABLE `user_console` (
  `user_console_id` int NOT NULL,
  `user_id` int NOT NULL,
  `console_id` int NOT NULL,
  `region` varchar(50) NOT NULL,
  `purchase_date` date NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_game`
-- one row for every game a user owns, linked to the console copy it is for
--

CREATE TABLE `user_game` (
  `user_game_id` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL,
  `user_console_id` int NOT NULL,
  `purchase_date` date NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `format` varchar(10) NOT NULL DEFAULT 'Disc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `user_console`
  ADD PRIMARY KEY (`user_console_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `console_id` (`console_id`);

ALTER TABLE `user_game`
  ADD PRIMARY KEY (`user_game_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `user_console_id` (`user_console_id`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_console`
  MODIFY `user_console_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_game`
  MODIFY `user_game_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
-- removing a console from a collection also removes the games that were on it
--

ALTER TABLE `user_console`
  ADD CONSTRAINT `user_console_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_console_ibfk_2` FOREIGN KEY (`console_id`) REFERENCES `console` (`console_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_game`
  ADD CONSTRAINT `user_game_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_game_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_game_ibfk_3` FOREIGN KEY (`user_console_id`) REFERENCES `user_console` (`user_console_id`) ON DELETE CASCADE ON UPDATE CASCADE;
