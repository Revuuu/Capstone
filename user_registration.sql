-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 04:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `mname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `age` int(11) NOT NULL,
  `contactno` varchar(50) NOT NULL,
  `gamegenre` varchar(50) NOT NULL,
  `profile_picture` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mname`, `lname`, `email`, `password`, `age`, `contactno`, `gamegenre`, `profile_picture`) VALUES
(50, 'angelo', 'curameng', 'dela vega', 'angelodelavega@gmail.com', '$2y$10$2RzfJLkOa2ISA4ocGBnMHezITgDvbkrpioMnxwkY.ecJ4d8ZekjCa', 25, '09175021803', 'Action', ''),
(53, 'maody', 'glino', 'lee', 'maodylee@gmail.com', '$2y$10$vo9iVsG8xXonLExqfB/B3ud16bAHDvaYF3x03.KWNkONconXG0qYC', 16, '09175021803', 'Mystery', ''),
(56, 'juan', 'dela', 'cruz', 'juandelacruz123@gmail.com', '$2y$10$XdVPn3Ey/NancQITsR2bYuhtaO7E1RL2nwtesNV.jI/uoy4lWXW3.', 25, '09175021803', 'RPG', ''),
(57, 'joy', 'alcafaras', 'lee', 'maodyjoylee@yahoo.com', '$2y$10$2RCLIU/ITInUDSyTfS1JGek8cVJhZDsSArgB5X.PlCF2d.SZIj/o2', 25, '09175021803', 'action', ''),
(79, 'patricia', 'alcafaras', 'lee', 'patricialee@gmail.com', '$2y$10$qsT4kf.aMK120FPTviAV..hme1TJcyio/eXK0q8nKC01H9HYpG9P6', 25, '09175021803', 'horror', '66495042b6bac.jpg'),
(80, 'carlos', 'rodriguez', 'tabangay', 'carlostabangay@gmail.com', '$2y$10$/y2qcmdycVfBEz5bqmGeWeEIxHhckXONNe6A98Kp3sPYJZyCEfxQ.', 25, '09175021803', 'Action', '664951bea5b4a.png'),
(81, 'jermaine', 'alcafaras', 'lee', 'makarovdreyar28@gmail.com', '$2y$10$9cFOaAwzcT1wienExen8eemJ5RUgCQsPO2npN1zEhzfQyL2m3UJMa', 25, '09175021803', 'action', '664964d9ef18f.jpg'),
(82, 'miah', 'alcafaras', 'lee', 'miahlee@gmail.com', '$2y$10$o4utNxndu4poCiLVj3cKDOeBzXBrOh86MSGD91FV.AmgSr6ON7Zpq', 25, '09175021803', 'action', '664965a267ec1.gif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
