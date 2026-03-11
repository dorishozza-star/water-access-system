-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table wabms.boreholes
CREATE TABLE IF NOT EXISTS `boreholes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borehole_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('Working','Faulty') DEFAULT 'Working',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table wabms.boreholes: ~4 rows (approximately)
INSERT INTO `boreholes` (`id`, `borehole_name`, `location`, `status`, `created_at`) VALUES
	(1, 'Borehole 101', 'Kwemishuza', 'Working', '2026-03-11 08:12:08'),
	(2, 'Borehole A', 'ifakara', 'Working', '2026-03-11 08:12:19'),
	(3, 'Borehole 203', 'MKURANGA', 'Working', '2026-03-11 08:12:37'),
	(4, 'Borehole C', 'mwanga', 'Working', '2026-03-11 08:12:52');

-- Dumping structure for table wabms.maintenance_tasks
CREATE TABLE IF NOT EXISTS `maintenance_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borehole_id` int NOT NULL,
  `reported_issue` text NOT NULL,
  `assigned_to` int DEFAULT NULL,
  `status` enum('Pending','Assigned','In Progress','Completed') DEFAULT 'Pending',
  `date_reported` date DEFAULT (curdate()),
  `date_completed` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borehole_id` (`borehole_id`),
  KEY `assigned_to` (`assigned_to`),
  CONSTRAINT `maintenance_tasks_ibfk_1` FOREIGN KEY (`borehole_id`) REFERENCES `boreholes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_tasks_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table wabms.maintenance_tasks: ~1 rows (approximately)
INSERT INTO `maintenance_tasks` (`id`, `borehole_id`, `reported_issue`, `assigned_to`, `status`, `date_reported`, `date_completed`) VALUES
	(1, 3, 'pump broken ', 3, 'In Progress', '2026-03-11', NULL);

-- Dumping structure for table wabms.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borehole_id` int NOT NULL,
  `reported_by` int NOT NULL,
  `report_text` text NOT NULL,
  `date_reported` date DEFAULT (curdate()),
  PRIMARY KEY (`id`),
  KEY `borehole_id` (`borehole_id`),
  KEY `reported_by` (`reported_by`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`borehole_id`) REFERENCES `boreholes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table wabms.reports: ~0 rows (approximately)

-- Dumping structure for table wabms.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','technician','community') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table wabms.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
	(1, 'admin', 'admin123', 'admin'),
	(2, 'Fred', '12345', 'admin'),
	(3, 'Ally', '5678', 'technician'),
	(4, 'Carina', '202020', 'community');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
