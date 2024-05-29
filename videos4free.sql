-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 07:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videos4free`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `comment_date`, `username`, `user_id`) VALUES
(18, 'dasds', '2024-05-23 07:31:08', 'testuser', 1),
(23, 'hi', '2024-05-27 17:52:00', 'paul', 17),
(45, 'aloha', '2024-05-29 17:32:53', 'beb', 22),
(46, 'what a video', '2024-05-29 17:33:10', 'beb', 22);

-- --------------------------------------------------------

--
-- Table structure for table `featured_videos`
--

CREATE TABLE `featured_videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `featured_videos`
--

INSERT INTO `featured_videos` (`id`, `title`, `description`, `video_url`, `thumbnail_url`, `category`, `is_featured`) VALUES
(1, 'Wednesday', 'The ball scene', 'videos/Wednesday_Addams.mp4', 'images/WA1.jpg', 'eeefff', 1),
(2, 'Peaky Blinders', 'Description for Peaky Blinders video', 'videos/Peaky_Blinders.mp4', 'images/PA1.jpg', 'Drama', 1),
(3, 'Video 2', 'Description for Video 2', 'videos/video2.mp4', 'images/V2.jpg', 'Miscellaneouss', 1),
(4, 'Breaking Bad', 'Description for Breaking Bad video', 'videos/Breaking_Bad.mp4', 'images/BB1.jpg', 'Drama', 1),
(5, 'Bojack Horseman', 'bb', 'videos/Bojack_Horseman.mp4', 'images/BH1.jpg', 'testjava', 1),
(6, 'Infinity War', 'Description for Infinity War video', 'videos/Infinity_War.mp4', 'images/IW1.jpg', 'Action', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `release_year`, `director`, `genre`, `rating`, `thumbnail_url`) VALUES
(1, 'Spider-Man', 'incroyable', 2022, 'bob', 'Action', 5.0, 'images/spider.jpg'),
(2, 'Harry Potter', 'youre a lizard', 2323, 'beb', 'ef', 4.0, 'images/harry.jpg'),
(3, 'Avengers: Infinity War', 'asdads', 232131, 'dasdadsd', 'dfsdsf', 6.0, 'images/infinity.jpg'),
(4, 'Mario', NULL, NULL, NULL, NULL, NULL, 'images/mario.jpg'),
(5, 'Hunger Games', NULL, NULL, NULL, NULL, NULL, 'images/hunger.jpg'),
(6, 'Lion King', NULL, NULL, NULL, NULL, NULL, 'images/lion.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tv_series`
--

CREATE TABLE `tv_series` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tv_series`
--

INSERT INTO `tv_series` (`id`, `title`, `description`, `creator`, `genre`, `thumbnail_url`) VALUES
(1, 'Sheldon', 'young sheldoner', 'bober', 'slice of lifere', 'images/sheldon.jpg'),
(2, 'The Witcher', 'Description for The Witcher TV series', 'Creators', 'Fantasy', 'images/witcher.jpg'),
(3, 'NCIS', 'Description for NCIS TV series', 'Creators', 'Crime', 'images/ncis.jpg'),
(4, 'Rick and Morty', 'Description for Rick and Morty TV seriese', 'Creators', 'Animation', 'images/rick.jpg'),
(5, 'Brooklyn Nine-Nine', 'Description for Brooklyn Nine-Nine TV series', 'Creators', 'Comedy', 'images/b99.jpg'),
(6, 'The Boys', 'Description for The Boys TV series', 'Creators', 'Action', 'images/boys.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `registration_date`) VALUES
(1, 'testuser', 'testpassword', '2024-05-02 18:48:07'),
(16, 'test', 'test', '2024-05-27 14:51:42'),
(17, 'paul', 'parola', '2024-05-27 17:41:25'),
(22, 'beb', 'beb', '2024-05-29 17:32:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `featured_videos`
--
ALTER TABLE `featured_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tv_series`
--
ALTER TABLE `tv_series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `featured_videos`
--
ALTER TABLE `featured_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tv_series`
--
ALTER TABLE `tv_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
