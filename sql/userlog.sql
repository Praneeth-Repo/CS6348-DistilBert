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
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `login_time` datetime DEFAULT current_timestamp(),
  `logout_time` datetime DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userid`, `login_time`, `logout_time`, `session_id`) VALUES
(1, 'admin1', '2025-04-13 20:57:30', NULL, 'dv6potnkch6u4uobs33f85j1r5'),
(2, 'user2', '2025-04-13 20:58:46', '2025-04-13 20:58:57', 'dv6potnkch6u4uobs33f85j1r5'),
(3, 'user2', '2025-04-13 21:19:34', NULL, 'dv6potnkch6u4uobs33f85j1r5'),
(4, 'admin1', '2025-04-13 21:24:53', NULL, 'dv6potnkch6u4uobs33f85j1r5'),
(5, 'user2', '2025-04-13 21:25:21', NULL, 'dv6potnkch6u4uobs33f85j1r5'),
(6, 'admin1', '2025-04-13 21:29:50', NULL, 'dv6potnkch6u4uobs33f85j1r5'),
(7, 'admin1', '2025-04-13 21:56:14', '2025-04-13 21:56:33', 'dv6potnkch6u4uobs33f85j1r5'),
(8, 'admin1', '2025-04-13 21:56:40', NULL, 'dv6potnkch6u4uobs33f85j1r5'),
(9, 'user2', '2025-04-13 21:57:52', '2025-04-13 21:58:22', 'dv6potnkch6u4uobs33f85j1r5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
