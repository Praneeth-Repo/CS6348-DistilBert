-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 05:14 AM
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
-- Database: `cs6314`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','user') NOT NULL,
  `user_status` enum('active','inactive','revoked','deleted') DEFAULT 'active',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userid`, `password`, `user_type`, `user_status`, `first_name`, `last_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin1', '$2y$10$KhKk3OR0pYwS9.X4bR5UteWxDSYTlaG/BrI9s/7uq3SsSuT7RyV.6', 'admin', 'active', 'Admin', 'Name1', 'admin1@utdallas.edu', '2025-04-13 20:50:40', '2025-04-13 20:50:40'),
(2, 'user2', '$2y$10$j4tJJeR.kt.i70/d3LWsg.Wy7BHyKINZPG1eKLeEhfxAxu6vcFQBa', 'user', 'active', 'User', 'Name2', 'user2@utdallas.edu', '2025-04-13 20:50:40', '2025-04-13 20:58:37'),
(3, 'user3', '$2y$10$26ghggl2rLrUNMVTD047ROEEFkn61qv2Qa1BRSP.puGsHxPaMKIOK', 'user', 'active', 'User', 'Name3', 'user3@utdallas.edu', '2025-04-13 21:38:25', '2025-04-13 21:38:25'),
(4, 'user4', '$2y$10$i5FGdkNhStyqmsh8MDmApuO8MRzGDKb3ABA8m3ZEvz4bMVMA0Hj8y', 'user', 'active', 'User', 'Name4', 'user4@utdallas.edu', '2025-04-13 21:40:08', '2025-04-13 21:40:08'),
(6, 'user5', '$2y$10$Kj4vB6WoavNY24VoY9OGm.YUGpNOI44RRXMVJEY17OvA2C1v4N.yO', 'admin', 'active', 'Admin', 'Name5', 'admin5@utdallas.edu', '2025-04-13 21:44:43', '2025-04-13 21:44:43'),
(7, 'user6', '$2y$10$DgpauJk58cFDD7V67wRQguYrTe6Qe2MM4IWCIYvExazgcjyAupiya', 'user', 'active', 'User', 'Name6', 'user6@utdallas.edu', '2025-04-13 21:57:17', '2025-04-13 21:57:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
