-- run this after v1.sql, adds the developer, publisher and game tables

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

CREATE TABLE `developer` (
  `developer_id` int NOT NULL,
  `name` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisher_id` int NOT NULL,
  `name` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` int NOT NULL,
  `name` text NOT NULL,
  `developer_id` int NOT NULL,
  `publisher_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

ALTER TABLE `developer`
  ADD PRIMARY KEY (`developer_id`);

ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisher_id`);

ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `developer_id` (`developer_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `developer`
  MODIFY `developer_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `publisher`
  MODIFY `publisher_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `game`
  MODIFY `game_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`developer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `game_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`publisher_id`) ON DELETE CASCADE ON UPDATE CASCADE;
