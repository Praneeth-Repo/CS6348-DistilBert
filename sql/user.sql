-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 03:52 AM
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
-- Database: `cs6348`
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
(1, 'admin1', '$2y$10$7zk14AxT3S1Ov9hD7oMiaeGzo10UzAW4i5y/15/eUxua3zDAbNGnu', 'admin', 'active', 'Admin', 'Name1', 'admin1@utdallas.edu', '2025-04-13 22:23:00', '2025-04-13 22:23:00'),
(2, 'user2', '$2y$10$JQoGQe3FvtOOkpORUppUk.gMg8N.KKL15J.L4IOG/KahkIS08V4Ym', 'user', 'active', 'User', 'Name2', 'user2@utdallas.edu', '2025-04-13 22:23:00', '2025-04-13 22:23:00'),
(3, 'user3', '$2y$10$R2/o7Pe7Yyh672fBvvEQ3.uT7sWOOal8yhJmrwELsQdzCnj/ejWiO', 'user', 'active', 'User', 'Name3', 'user3@utdallas.edu', '2025-04-21 15:25:25', '2025-04-21 15:25:25'),
(4, 'user4', 'user4', 'user', 'active', 'User', 'Name4', 'user4@utdallas.edu', '2025-04-21 17:50:15', '2025-04-21 17:50:15'),
(5, 'praneeth', 'praneeth', 'user', 'active', 'Praneeth', 'Reddy', 'praneethpenamalli@gmail.com', '2025-04-25 12:12:44', '2025-04-25 12:12:44');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
