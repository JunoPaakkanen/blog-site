-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 10:44 AM
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
-- Database: `blogi`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogi_table`
--

CREATE TABLE `blogi_table` (
  `ID` int(11) NOT NULL,
  `sahkoposti` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `time_edited` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogi_table`
--

INSERT INTO `blogi_table` (`ID`, `sahkoposti`, `title`, `content`, `time`, `time_edited`) VALUES
(25, 'admin@admin.com', 'asddsa', 'asd', '2024-02-07 06:11:03.727601', '2024-02-13 06:32:32'),
(26, 'admin@admin.com', 'boem', 'boemasdasd', '2024-02-09 07:02:33.058881', '2024-02-13 06:37:09'),
(27, 'badmin@badmin.com', 'beom', 'beom', '2024-02-09 07:02:52.067824', '2024-02-13 06:53:32'),
(31, 'admin@admin.com', 'asdf', 'asdf', '2024-02-13 09:05:17.744939', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT -1,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `submit_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `page_id`, `parent_id`, `name`, `content`, `submit_date`) VALUES
(11, 27, -1, 'asd', 'asd', '2024-02-13 09:18:25'),
(12, 25, -1, 'asd', 'asd', '2024-02-13 10:11:46'),
(13, 27, -1, 'asd', 'asd', '2024-02-13 10:30:49'),
(14, 26, -1, 'test', 'test', '2024-02-13 10:31:03'),
(15, 27, -1, 'asd', 'asd', '2024-02-13 10:38:01'),
(16, 27, 15, 'asd', 'asd', '2024-02-13 10:55:57'),
(17, 27, 13, 'asd', 'asd', '2024-02-13 10:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `kayttajat`
--

CREATE TABLE `kayttajat` (
  `kayttaja_id` int(11) NOT NULL,
  `sahkoposti` varchar(100) NOT NULL,
  `kayttajanimi` varchar(30) NOT NULL,
  `salasana` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kayttajat`
--

INSERT INTO `kayttajat` (`kayttaja_id`, `sahkoposti`, `kayttajanimi`, `salasana`, `bio`) VALUES
(1, 'admin@admin.com', 'admin', '$2y$10$x3CEHe4CgAkTMjjn9pY0zetxR2p9h7IlM5kPmp0ZYUfet4SXnNofO', 'I\'m admin'),
(2, 'badmin@badmin.com', 'badmin', '$2y$10$OUwtfWETNekp5ALYSFSrxeoDfTlLEVIR/RSz7NpPTevkw0bD7dm.K', NULL),
(3, 'sadmin@sadmin.com', 'sadmin', '$2y$10$xxP8vSPhILI2yP7vaXg5VeENaj3gfZHqFJQ0QONz3qX75JbPLg70y', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogi_table`
--
ALTER TABLE `blogi_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`kayttaja_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogi_table`
--
ALTER TABLE `blogi_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kayttajat`
--
ALTER TABLE `kayttajat`
  MODIFY `kayttaja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
