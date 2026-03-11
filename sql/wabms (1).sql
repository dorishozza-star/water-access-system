-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 07:54 AM
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
-- Database: `wabms`
--

-- --------------------------------------------------------

--
-- Table structure for table `boreholes`
--

CREATE TABLE `boreholes` (
  `id` int(11) NOT NULL,
  `borehole_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('working','faulty') DEFAULT 'working',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boreholes`
--

INSERT INTO `boreholes` (`id`, `borehole_name`, `location`, `status`, `created_at`) VALUES
(1, 'Borehole A', 'MKURANGA', 'working', '2026-02-19 20:40:38'),
(2, 'Borehole C', 'ifakara', 'working', '2026-02-22 10:26:44'),
(3, 'Borehole B', 'Magomeni', 'working', '2026-02-22 11:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_tasks`
--

CREATE TABLE `maintenance_tasks` (
  `id` int(11) NOT NULL,
  `borehole_id` int(11) NOT NULL,
  `reported_issue` text NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `status` enum('Pending','In progress','Completed') NOT NULL DEFAULT 'Pending',
  `date_reported` date DEFAULT curdate(),
  `date_completed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_tasks`
--

INSERT INTO `maintenance_tasks` (`id`, `borehole_id`, `reported_issue`, `assigned_to`, `status`, `date_reported`, `date_completed`) VALUES
(1, 1, 'pump broken', 2, 'Completed', '2026-02-22', '2026-02-22'),
(2, 2, 'low water flow', NULL, 'Pending', '2026-02-22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `borehole_id` int(11) NOT NULL,
  `reported_by` int(11) NOT NULL,
  `report_text` text NOT NULL,
  `date_reported` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','technician','community') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Mubarak', '1234', 'admin'),
(2, 'silas', 'tech1', 'technician'),
(3, 'chairman', '5678', 'community');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boreholes`
--
ALTER TABLE `boreholes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_tasks`
--
ALTER TABLE `maintenance_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borehole_id` (`borehole_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borehole_id` (`borehole_id`),
  ADD KEY `reported_by` (`reported_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boreholes`
--
ALTER TABLE `boreholes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance_tasks`
--
ALTER TABLE `maintenance_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maintenance_tasks`
--
ALTER TABLE `maintenance_tasks`
  ADD CONSTRAINT `maintenance_tasks_ibfk_1` FOREIGN KEY (`borehole_id`) REFERENCES `boreholes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_tasks_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`borehole_id`) REFERENCES `boreholes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
