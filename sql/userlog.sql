-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 04:14 AM
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
(1, 'admin1', '2025-04-17 19:07:52', NULL, 'di9in88u7otp7tfu58pitt08v8'),
(2, 'user2', '2025-04-17 19:08:02', NULL, 'di9in88u7otp7tfu58pitt08v8'),
(3, 'user2', '2025-04-17 19:17:47', NULL, 'di9in88u7otp7tfu58pitt08v8'),
(4, 'user2', '2025-04-21 15:14:58', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(5, 'admin1', '2025-04-21 15:25:02', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(6, 'user4', '2025-04-21 17:52:14', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(7, 'user4', '2025-04-22 17:38:23', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(8, 'admin1', '2025-04-22 17:39:14', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(9, 'admin1', '2025-04-22 17:39:40', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(10, 'admin1', '2025-04-22 17:39:49', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(11, 'admin1', '2025-04-22 17:39:58', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(12, 'user4', '2025-04-22 17:40:23', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(13, 'user4', '2025-04-22 17:40:59', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(14, 'admin1', '2025-04-22 17:41:07', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(15, 'admin1', '2025-04-22 17:57:56', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(16, 'user4', '2025-04-22 17:58:05', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(17, 'user4', '2025-04-22 18:06:17', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(18, 'admin1', '2025-04-22 18:20:36', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(19, 'admin1', '2025-04-22 18:20:47', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(20, 'admin1', '2025-04-22 18:23:16', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(21, 'admin1', '2025-04-22 18:25:50', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(22, 'admin1', '2025-04-22 18:27:47', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(23, 'admin1', '2025-04-23 14:46:32', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(24, 'user4', '2025-04-23 14:54:39', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(25, 'admin1', '2025-04-23 14:55:01', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(26, 'admin1', '2025-04-24 17:37:24', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(27, 'admin1', '2025-04-24 19:23:10', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(28, 'admin1', '2025-04-24 22:25:15', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(29, 'admin1', '2025-04-25 01:11:20', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(30, 'admin1', '2025-04-25 01:11:25', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(31, 'admin1', '2025-04-25 01:32:01', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(32, 'admin1', '2025-04-25 01:41:53', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(33, 'admin1', '2025-04-25 11:25:56', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(34, 'admin1', '2025-04-25 12:12:16', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(35, 'praneeth', '2025-04-25 12:13:10', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(36, 'praneeth', '2025-04-25 12:14:16', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(37, 'praneeth', '2025-04-25 17:30:39', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(38, 'admin1', '2025-04-25 17:35:55', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(39, 'praneeth', '2025-04-25 18:56:47', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(40, 'praneeth', '2025-04-25 20:09:32', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(41, 'praneeth', '2025-04-25 20:19:33', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(42, 'admin1', '2025-04-25 20:20:27', NULL, 'hhl88p1e81qcm4q5blbqh9vela'),
(43, 'praneeth', '2025-04-25 20:21:09', NULL, 'hhl88p1e81qcm4q5blbqh9vela');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
