-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2026 at 03:37 PM
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
-- Database: `solar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `simulation_history`
--

CREATE TABLE `simulation_history` (
  `id` int(11) NOT NULL,
  `rows_count` int(11) DEFAULT NULL,
  `cols_count` int(11) DEFAULT NULL,
  `land_area` float DEFAULT NULL,
  `sun_mode` varchar(20) DEFAULT NULL,
  `sun_direction` varchar(20) DEFAULT NULL,
  `efficiency` float DEFAULT NULL,
  `energy` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `simulation_history`
--

INSERT INTO `simulation_history` (`id`, `rows_count`, `cols_count`, `land_area`, `sun_mode`, `sun_direction`, `efficiency`, `energy`, `created_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-15 01:53:30'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-15 01:53:57'),
(3, 15, 17, 1000, '0', 'top', 6.67, 34, '2026-04-15 01:57:10'),
(4, 15, 17, 1000, '0', 'top', 6.67, 34, '2026-04-15 02:50:55'),
(5, 22, 23, 2000, '0', 'left', 100, 264, '2026-04-15 05:08:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Deepanraj T', 'deepanraj007t@gmail.com', '$2y$10$gFbZwSvQxMiAi2SgtrVMR.OYvuegp6nSsDWoS0AO6CgIXyJzK0LOO', '2026-04-14 19:23:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `simulation_history`
--
ALTER TABLE `simulation_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `simulation_history`
--
ALTER TABLE `simulation_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
