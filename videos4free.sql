-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 09:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `user_id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `video_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `comment_date`, `username`, `user_id`, `video_id`, `video_type`) VALUES
(18, 'dasds', '2024-05-23 07:31:08', 'testuser', 1, NULL, NULL),
(23, 'hi', '2024-05-27 17:52:00', 'paul', 17, NULL, NULL),
(45, 'aloha', '2024-05-29 17:32:53', 'beb', 22, NULL, NULL),
(46, 'what a video', '2024-05-29 17:33:10', 'beb', 22, NULL, NULL),
(47, 'baz', '2024-05-29 18:12:46', 'test', 16, NULL, NULL),
(48, 'cookies', '2024-05-29 18:14:17', 'paul', 17, NULL, NULL),
(49, 'wowzers', '2025-05-20 18:24:34', 'alexa', 26, 5, 'tv_series'),
(50, 'yyyyyyy', '2025-05-20 18:24:41', 'alexa', 26, 4, 'tv_series'),
(51, 'sd', '2025-05-20 19:09:17', 'alexa', 26, 5, 'tv_series'),
(52, 'asd', '2025-05-20 19:14:09', 'alexa', 26, 6, 'tv_series');

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
(1, 'First video', 'City', 'videos/first.mp4', 'images/first.jpg', 'thesis', 1),
(2, 'Clock', 'Clock video', 'videos/second.mp4', 'images/second.jpg', 'Thesis', 1),
(3, 'third', 'video', 'videos/third.mp4', 'images/third.jpg', 'thesis', 1),
(4, 'fourth', 'desc', 'videos/fourth.mp4', 'images/fourth.jpg', 'thesis', 1),
(5, 'Fifth', 'bb', 'videos/fifth.mp4', 'images/fifth.jpg', 'thesis', 1),
(6, 'Sixth', 'Description', 'videos/sixth.mp4', 'images/sixth.jpg', 'thesis', 1);

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
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `release_year`, `director`, `genre`, `rating`, `thumbnail_url`, `video_url`) VALUES
(1, 'First Movie', 'I hate copyright', 2022, 'Bob', 'Action', 5.0, 'images/movie1.jpg', 'videos/firstmovie.mp4'),
(2, 'Movie 2', 'I hate copyright', 1999, 'Alexa', 'any', 4.0, 'images/movie2.jpg', 'videos/secondmovie.mp4'),
(3, 'Movie 3', 'I hate copyright', 2014, 'Alexa', 'any', 6.0, 'images/movie3.jpg', 'videos/thirdmovie.mp4'),
(4, 'Movie 4', 'I hate copyright', 2015, 'Bob', 'any', 9.0, 'images/movie4.jpg', 'videos/fourthmovie.mp4'),
(5, 'Movie 5', 'I hate copyright', 2016, 'Joe', 'any', 7.2, 'images/movie5.jpg', 'videos/fifthmovie.mp4'),
(6, 'Movie 6', 'I hate copyright', 2020, 'Steve', 'any', 5.6, 'images/movie6.jpg', 'videos/sixthmovie.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `remember_me`
--

CREATE TABLE `remember_me` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remember_me`
--

INSERT INTO `remember_me` (`id`, `user_id`, `token`) VALUES
(4, 17, 'd8c4f7d165bdeea09348ab25c0e345ab');

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
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tv_series`
--

INSERT INTO `tv_series` (`id`, `title`, `description`, `creator`, `genre`, `thumbnail_url`, `video_url`) VALUES
(1, 'Tv 1', 'I HATE COPYRIGHT', 'Alexa', 'any', 'images/tv1.jpg', 'videos/firsttv.mp4'),
(2, 'Tv 2', 'I HATE COPYRIGHT', 'Janet', 'any', 'images/tv2.jpg', 'videos/secondtv.mp4'),
(3, 'Tv 3', 'I HATE COPYRIGHT', 'Alexa', 'Crime', 'images/tv3.jpg', 'videos/thirdtv.mp4'),
(4, 'Tv 4', 'I HATE COPYRIGHT', 'Kayle', 'Animation', 'images/tv4.jpg', 'videos/fourthtv.mp4'),
(5, 'Tv 5', 'I HATE COPYRIGHT', 'George', 'Comedy', 'images/tv5.jpg', 'videos/fifthtv.mp4'),
(6, 'Tv 6', 'I HATE COPYRIGHT', 'Ian', 'Action', 'images/tv6.jpg', 'videos/sixthtv.mp4');

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
(22, 'beb', 'beb', '2024-05-29 17:32:47'),
(25, 'boba', '$2y$10$Hhe7naF8rjzxl0UEXVz7N.f.yfSLXegBkYECRtQ0/nGLUcczRb3Ga', '2025-05-20 16:50:22'),
(26, 'alexa', '$2y$10$0ZVlPT0aO4ZIUYdVzIopkOdMTtF7jOl9PFJfLobdgVXNfJ4ZZ7Xpy', '2025-05-20 16:56:32');

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
-- Indexes for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_token` (`token`),
  ADD KEY `fk_user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
-- AUTO_INCREMENT for table `remember_me`
--
ALTER TABLE `remember_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tv_series`
--
ALTER TABLE `tv_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD CONSTRAINT `fk_user_remember` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
