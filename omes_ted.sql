-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2024 at 05:14 AM
-- Server version: 8.0.36
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omes_ted`
--

-- --------------------------------------------------------

--
-- Table structure for table `apportionment`
--

CREATE TABLE `apportionment` (
  `id` int NOT NULL,
  `school` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_no` int NOT NULL DEFAULT '0',
  `group_apportion_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `belt_no` int NOT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_apportioned` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apportionment`
--

INSERT INTO `apportionment` (`id`, `school`, `script_no`, `group_apportion_id`, `group_code`, `course`, `subject`, `belt_no`, `marking_centre`, `username`, `date_apportioned`, `session`) VALUES
(1, '3004', 9, 'MC-01_SC01_1', 'SC01', 'ISE', '3309', 1, 'MC-01', 'teddeo - JOSHUA MARTIN', '24/10/2024 11:10:38', 2024),
(2, '3002', 84, 'MC-01_SC01_1', 'SC01', 'EAE', '3306', 1, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 14:15:13', 2024),
(3, '3007', 1, 'MC-01_SC01_3', 'SC01', 'TSE', '3308', 3, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 14:19:53', 2024),
(4, '3010', 34, 'MC-01_SC01_2', 'SC01', 'EAE', '3306', 2, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:35', 2024),
(5, '3010', 37, 'MC-01_SC01_3', 'SC01', 'TSE', '3308', 3, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:22', 2024),
(6, '4038', 17, 'MC-01_SC01_4', 'SC01', 'CSE', '43131', 4, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:19', 2024),
(7, '4036', 1, 'MC-01_SC01_2', 'SC01', 'RED', '43201', 2, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 14:59:43', 2024),
(8, '3010', 44, 'MC-01_SC01_5', 'SC01', 'ISE', '3309', 5, 'MC-01', 'teddeo - JOSHUA MARTIN', '23/10/2024 15:49:03', 2024);

--
-- Triggers `apportionment`
--
DELIMITER $$
CREATE TRIGGER `update_apportionment_after_delete` AFTER DELETE ON `apportionment` FOR EACH ROW BEGIN
    UPDATE group_apportion
    SET no_of_centres = (SELECT COUNT(*) FROM apportionment WHERE group_apportion_id = OLD.group_apportion_id),
        no_of_scripts = no_of_scripts - OLD.script_no
    WHERE id = OLD.group_apportion_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_apportionment_after_update` AFTER UPDATE ON `apportionment` FOR EACH ROW BEGIN
 UPDATE group_apportion 
    SET no_of_scripts = no_of_scripts - OLD.script_no + NEW.script_no
    WHERE id = NEW.group_apportion_id;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_apportionment_after_insert` AFTER INSERT ON `apportionment` FOR EACH ROW BEGIN
  UPDATE group_apportion 
    SET no_of_centres = (SELECT COUNT(*) FROM apportionment WHERE group_apportion_id = NEW.group_apportion_id),
        no_of_scripts = no_of_scripts + NEW.script_no 
    WHERE id = NEW.group_apportion_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `apportionment_temp`
--

CREATE TABLE `apportionment_temp` (
  `id` int NOT NULL,
  `school` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_no` int NOT NULL DEFAULT '0',
  `group_apportion_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `belt_no` int NOT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_apportioned` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centre`
--

CREATE TABLE `centre` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centre`
--

INSERT INTO `centre` (`centre_code`, `name`, `session`) VALUES
('MC-01', 'ZASTI MARKING CENTRE', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_name`, `group_id`) VALUES
('ASE4', 'AGRICULTURAL SCIENCE EDUCATION', '3'),
('ELE4', 'ENGLISH LANGUAGE EDUCATION', '1'),
('ESE2', 'ENVIRONMENTAL  SCIENCE  EDUCATION   III', '3'),
('ICT0', 'INFORMATION COMMUNICATION TECHNOLOGY', '5'),
('ISE3', 'INTEGRATED SCIENCE EDUCATION III', '3'),
('ISE4', 'INTEGRATED SCIENCE EDUCATION', '3'),
('LLD2', 'LITERACY AND LANGUAGES DEVELOPMENT        III', '1'),
('LLE3', 'LITERACY AND LANGUAGES   EDUCATION   III', '1'),
('MED3', 'MATHEMATICS EDUCATION III', '4'),
('MED4', 'MATHEMATICS EDUCATION', '4'),
('PME2', 'PRE- MATHEMATICS  EDUCATION  III', '4');

-- --------------------------------------------------------

--
-- Table structure for table `course_group`
--

CREATE TABLE `course_group` (
  `group_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_group`
--

INSERT INTO `course_group` (`group_code`, `group_name`) VALUES
('1', 'GROUP 1'),
('3', 'SCIENCE'),
('4', 'MATHEMATICS'),
('5', 'TECHNOLOGY STUDIES');

-- --------------------------------------------------------

--
-- Table structure for table `data_entry_claims`
--

CREATE TABLE `data_entry_claims` (
  `id` int NOT NULL,
  `marking_centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `examiner_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_entry_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `15_wht` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `belt_no` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_claimed` date NOT NULL,
  `session` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_entry_claims`
--

INSERT INTO `data_entry_claims` (`id`, `marking_centre_code`, `marking_centre_name`, `nrc`, `examiner_number`, `tpin`, `full_name`, `phone_number`, `address`, `position`, `no_of_scripts`, `sortcode`, `account_no`, `data_entry_rate`, `gross_pay`, `15_wht`, `net_pay`, `bank`, `branch`, `belt_no`, `date_claimed`, `session`, `session_name`) VALUES
(9, 'MC-01', 'ZASTI MARKING CENTRE', '132677/20/1', 'teddeo', '1010236541', 'JOSHUA MBEWE', '0777452120', 'LUSAKA', 'DATA ENTRY OFFICER', 224, '101020', '1012365412013', '0.25', '56', '8.4', '47.6', 'ZANACO', 'CAIRO', 'D/E', '2024-11-28', '2024', '2023 2023 TEACHER EDUCATION');

-- --------------------------------------------------------

--
-- Table structure for table `examiner`
--

CREATE TABLE `examiner` (
  `id` int NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `examiner_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `belt_no` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_status` int NOT NULL,
  `login_status` int NOT NULL,
  `session` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `examiner`
--

INSERT INTO `examiner` (`id`, `nrc`, `tpin`, `examiner_number`, `first_name`, `last_name`, `phone_number`, `email`, `address`, `role`, `belt_no`, `attendance`, `marking_centre`, `course_code`, `bank`, `branch`, `sortcode`, `account_no`, `activation_status`, `login_status`, `session`) VALUES
(1, '230879/31/1', '1001455443', 'ASE4/000001', 'DOMINIC', 'MULENGA', '979924859', 'mulengad777@gmail.com', 'KITWE COLLEGE OF EDUCATION', 'EXAMINER', NULL, '1', 'MC-01', 'ASE4', 'ZANACO', 'CAIRO', '300200', '6.09307E+11', 1, 0, 2024),
(2, '168031/12/1', '1005201155', 'TSE0/000002', 'KENNY', 'MWAPE', '979315737', 'mwape.kenny@gmail.com', 'MANSA COLLEGE OF EDUCATION', 'EXAMINER', NULL, '1', 'MC-01', 'ELE4', 'ZANACO', 'CAIRO', '300200', '4.13658E+11', 1, 0, 2024),
(3, '165685/65/1', '1005510226', 'HEH4/000003', 'YVONNE', 'HINYENDENDE', '973954302', 'hinyendendeyvonne@gmail.com', 'MANSA COLLEGE OF EDUCATION', 'EXAMINER', NULL, '1', 'MC-01', 'ASE4', 'ZANACO', 'CAIRO', '300200', '5.60949E+11', 1, 0, 2024),
(4, '252882/51/1', '1005619608', 'HEH4/000004', 'CATHERINE', 'MULENJE', '978028149', 'mulenjecathy@gmail.com', 'CHIPATA COLLEGE OF EDUCATION', 'EXAMINER', NULL, '1', 'MC-01', 'ASE4', 'ZANACO', 'CAIRO', '300200', '5.6332E+12', 1, 0, 2024),
(5, '178708/23/1', '1007892936', 'TSE0/000005', 'PRECIOUS M', 'JIKUBI ', '977185616', 'jikubiprecious@gmail.com', 'SOLWEZI TEACHERS COLLEGE OF EDUCATION ', 'EXAMINER', NULL, '1', 'MC-01', 'LLD2', 'ZANACO', 'CAIRO', '300200', '5.72926E+12', 1, 0, 2024),
(6, '251066/82/1', '1008299549', 'HEH4/000006', 'SITUMBEKO', 'LISHOMWA', '979938507', 'situmbekolishomwa@gmail.com', 'MONGU COLLEGE OF EDUCATION', 'EXAMINER', NULL, '1', 'MC-01', 'LLE3', 'ZANACO', 'CAIRO', '300200', '4.23216E+11', 1, 0, 2024),
(7, '132677/20/1', '1010236541', 'teddeo', 'JOSHUA', 'MBEWE', '0777452120', 'jmbewe@exams-council.org.zm', 'LUSAKA', 'DATA ENTRY OFFICER', NULL, '1', 'MC-01', 'ISE3', 'ZANACO', 'CAIRO', '101020', '1012365412013', 1, 0, 2024);

-- --------------------------------------------------------

--
-- Table structure for table `examiner_claim`
--

CREATE TABLE `examiner_claim` (
  `id` int NOT NULL,
  `marking_centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grossed_up_rate` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `15_wht` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `belt_no` int NOT NULL,
  `session` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `examiner_claim`
--

INSERT INTO `examiner_claim` (`id`, `marking_centre_code`, `marking_centre_name`, `nrc`, `tpin`, `full_name`, `address`, `position`, `no_of_scripts`, `sortcode`, `account_no`, `net_rate`, `grossed_up_rate`, `gross_pay`, `15_wht`, `net_pay`, `bank`, `branch`, `group_code`, `group_name`, `course_code`, `course_name`, `belt_no`, `session`, `session_name`) VALUES
(6, 'MC-01', 'ZASTI MARKING CENTRE', '230879/31/1', '1001455443', 'DOMINIC MULENGA', 'KITWE COLLEGE OF EDUCATION', 'EXAMINER', 93, '300200', '6.09307E+11', '9.00', '', '900', '135', '765', 'ZANACO', 'CAIRO', 'SC01', 'SCIENCE', 'ASE', 'AGRICULTURAL SCIENCE EDUCATION', 1, '2024', '2023 2023 TEACHER EDUCATION'),
(7, 'MC-01', 'ZASTI MARKING CENTRE', '168031/12/1', '1005201155', 'KENNY MWAPE', 'MANSA COLLEGE OF EDUCATION', 'EXAMINER', 38, '300200', '4.13658E+11', '9.00', '', '900', '135', '765', 'ZANACO', 'CAIRO', 'SC01', 'SCIENCE', 'TSE', 'TECHNOLOGY STUDIES EDUCATION', 3, '2024', '2023 2023 TEACHER EDUCATION'),
(8, 'MC-01', 'ZASTI MARKING CENTRE', '165685/65/1', '1005510226', 'YVONNE HINYENDENDE', 'MANSA COLLEGE OF EDUCATION', 'EXAMINER', 93, '300200', '5.60949E+11', '9.00', '', '900', '135', '765', 'ZANACO', 'CAIRO', 'SC01', 'SCIENCE', 'HEH', 'HOME ECONOMICS AND HOSPITALITY EDUCATION', 1, '2024', '2023 2023 TEACHER EDUCATION'),
(9, 'MC-01', 'ZASTI MARKING CENTRE', '178708/23/1', '1007892936', 'PRECIOUS M JIKUBI ', 'SOLWEZI TEACHERS COLLEGE OF EDUCATION ', 'EXAMINER', 93, '300200', '5.72926E+12', '9.00', '', '900', '135', '765', 'ZANACO', 'CAIRO', 'SC01', 'SCIENCE', 'TSE', 'TECHNOLOGY STUDIES EDUCATION', 1, '2024', '2023 2023 TEACHER EDUCATION'),
(10, 'MC-01', 'ZASTI MARKING CENTRE', '251066/82/1', '1008299549', 'SITUMBEKO LISHOMWA', 'MONGU COLLEGE OF EDUCATION', 'EXAMINER', 38, '300200', '4.23216E+11', '9.00', '', '900', '135', '765', 'ZANACO', 'CAIRO', 'SC01', 'SCIENCE', 'HEH', 'HOME ECONOMICS AND HOSPITALITY EDUCATION', 3, '2024', '2023 2023 TEACHER EDUCATION');

-- --------------------------------------------------------

--
-- Table structure for table `group_apportion`
--

CREATE TABLE `group_apportion` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `belt_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_centres` int NOT NULL DEFAULT '0',
  `no_of_scripts` int NOT NULL DEFAULT '0',
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_apportion`
--

INSERT INTO `group_apportion` (`id`, `group_code`, `belt_no`, `no_of_centres`, `no_of_scripts`, `marking_centre`, `username`, `date_created`, `session`) VALUES
('MC-01_SC01_1', 'SC01', '1', 2, 93, 'MC-01', 'teddeo - JOSHUA MARTIN', '2024-10-23 14:58:35', 2024),
('MC-01_SC01_2', 'SC01', '2', 2, 35, 'MC-01', 'teddeo - JOSHUA MARTIN', '2024-10-23 15:23:01', 2024),
('MC-01_SC01_3', 'SC01', '3', 2, 38, 'MC-01', 'teddeo - JOSHUA MARTIN', '2024-10-23 15:40:33', 2024),
('MC-01_SC01_4', 'SC01', '4', 1, 17, 'MC-01', 'teddeo - JOSHUA MARTIN', '2024-10-23 15:55:30', 2024),
('MC-01_SC01_5', 'SC01', '5', 1, 44, 'MC-01', 'teddeo - JOSHUA MARTIN', '2024-10-23 15:59:47', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `marking_centre`
--

CREATE TABLE `marking_centre` (
  `id` int NOT NULL,
  `course` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marking_centre`
--

INSERT INTO `marking_centre` (`id`, `course`, `centre_code`, `session`) VALUES
(3, 'ASE', 'MC-01', 2024),
(2, 'ASE4', 'MC-01', 2024),
(4, 'BSE', 'MC-01', 2024),
(5, 'BSE42', 'MC-01', 2024),
(7, 'CSE', 'MC-01', 2024),
(8, 'DTE', 'MC-01', 2024),
(10, 'EED', 'MC-01', 2024),
(11, 'EEM', 'MC-01', 2024),
(12, 'ELE4', 'MC-01', 2024),
(13, 'ELM', 'MC-01', 2024),
(6, 'ESE2', 'MC-01', 2024),
(15, 'FFL4', 'MC-01', 2024),
(16, 'HEH', 'MC-01', 2024),
(17, 'ICT', 'MC-01', 2024),
(18, 'ISE', 'MC-01', 2024),
(19, 'LL', 'MC-01', 2024),
(9, 'LLD2', 'MC-01', 2024),
(14, 'LLE3', 'MC-01', 2024),
(20, 'MAE', 'MC-01', 2024),
(21, 'PES', 'MC-01', 2024),
(22, 'RED', 'MC-01', 2024),
(23, 'SCP', 'MC-01', 2024),
(24, 'SED', 'MC-01', 2024),
(25, 'SGC', 'MC-01', 2024),
(26, 'TPE', 'MC-01', 2024),
(27, 'TSE', 'MC-01', 2024),
(28, 'ZLE', 'MC-01', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `marking_rates`
--

CREATE TABLE `marking_rates` (
  `id` int NOT NULL,
  `t_leader` float(4,2) NOT NULL,
  `examiner` float(4,2) NOT NULL,
  `data_entry` float(4,2) NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marking_rates`
--

INSERT INTO `marking_rates` (`id`, `t_leader`, `examiner`, `data_entry`, `session`) VALUES
(1, 12.00, 9.00, 0.25, 2024);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark` int NOT NULL DEFAULT '0',
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sen` int DEFAULT '0',
  `improvised_mark` int NOT NULL DEFAULT '0',
  `belt_no` int NOT NULL DEFAULT '0',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `marking_centre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`centre_code`, `exam_no`, `first_name`, `last_name`, `subject_code`, `mark`, `status`, `sen`, `improvised_mark`, `belt_no`, `entered_by`, `date_entered`, `marking_centre`, `session`) VALUES
('3004', '1630040193', '', '', '3309', 56, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 13:57:46', 'MC-01', 2024),
('4002', '1640020520', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4003', '1640030149', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '1730020167', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '1730020191', '', '', '3306', 55, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:45', 'MC-01', 2024),
('3002', '1730020191', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '1730020191', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3007', '1730070388', '', '', '3308', 56, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:19:53', 'MC-01', 2024),
('4002', '1740020213', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4002', '1740020213', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4002', '1740020307', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4002', '1740020549', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '1740270149', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '1740290004', '', '', '43201', 89, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:59:43', 'MC-01', 2024),
('4036', '1740290004', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '1840400059', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3004', '1930220014', '', '', '3309', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 13:57:48', 'MC-01', 2024),
('3004', '1930220015', '', '', '3309', 23, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 13:57:49', 'MC-01', 2024),
('3037', '1930420013', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4017', '1940170015', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '1940380005', '', '', '43131', 55, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:46', 'MC-01', 2024),
('3010', '2030100002', '', '', '3309', 69, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:13', 'MC-01', 2024),
('3010', '2030100005', '', '', '3306', 98, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:17', 'MC-01', 2024),
('3010', '2030100005', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2030100005', '', '', '3309', 55, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:15', 'MC-01', 2024),
('3010', '2030100007', '', '', '3306', 46, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:18', 'MC-01', 2024),
('3010', '2030100007', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2030100007', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:17', 'MC-01', 2024),
('3010', '2030100016', '', '', '3309', 23, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:18', 'MC-01', 2024),
('3010', '2030100019', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:19', 'MC-01', 2024),
('3010', '2030100021', '', '', '3306', 85, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:20', 'MC-01', 2024),
('3010', '2030100021', '', '', '3308', 25, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:38:51', 'MC-01', 2024),
('3010', '2030100021', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:21', 'MC-01', 2024),
('3010', '2030100037', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:23', 'MC-01', 2024),
('3010', '2030100038', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:26', 'MC-01', 2024),
('3004', '2030220001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3004', '2030220005', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3004', '2030220005', '', '', '3309', 44, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 13:57:51', 'MC-01', 2024),
('3004', '2030220008', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3004', '2030220008', '', '', '3309', 22, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 13:57:53', 'MC-01', 2024),
('3037', '2030370002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2030370005', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2030370006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2030370008', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2030370010', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2030370010', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2030370010', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2030530006', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2030530006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2030530006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070003', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070003', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070011', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070011', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070017', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070027', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070040', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070047', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2040070053', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2040350004', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2040350008', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2040390006', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2040400036', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2030', '2120300002', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2030', '2120300003', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2030', '2120300004', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2030', '2120300006', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2030', '2120300007', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2030', '2120300008', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310001', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310002', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310003', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310004', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310005', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310006', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2031', '2120310007', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330001', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330002', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330003', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330005', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330006', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330007', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330008', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330009', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330010', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330011', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330012', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330013', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330014', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330015', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330016', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330017', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330018', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330019', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330020', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330021', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330022', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330023', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330024', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330025', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330026', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330027', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330028', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2033', '2120330029', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2041', '2120410001', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2041', '2120410002', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2041', '2120410005', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2041', '2120410006', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2041', '2120410007', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710001', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710003', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710004', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710005', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710006', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710007', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710008', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710009', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710010', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2071', '2120710011', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2072', '2120720001', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2072', '2120720002', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2072', '2120720003', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2072', '2120720004', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('2072', '2120720005', '', '', '2310', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020001', '', '', '3306', 12, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:47', 'MC-01', 2024),
('3002', '2130020001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020002', '', '', '3306', 26, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:48', 'MC-01', 2024),
('3002', '2130020002', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020003', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:50', 'MC-01', 2024),
('3002', '2130020003', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020003', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020004', '', '', '3306', 44, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:51', 'MC-01', 2024),
('3002', '2130020004', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020004', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020005', '', '', '3306', 23, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:53', 'MC-01', 2024),
('3002', '2130020005', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020005', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020006', '', '', '3306', 23, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:08:54', 'MC-01', 2024),
('3002', '2130020006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020008', '', '', '3306', 65, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:09:41', 'MC-01', 2024),
('3002', '2130020008', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020008', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020009', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:09:56', 'MC-01', 2024),
('3002', '2130020009', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020009', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020010', '', '', '3306', 65, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:09:58', 'MC-01', 2024),
('3002', '2130020010', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020010', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020011', '', '', '3306', 11, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:10:01', 'MC-01', 2024),
('3002', '2130020011', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020011', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020012', '', '', '3306', 98, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:10:02', 'MC-01', 2024),
('3002', '2130020012', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020012', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020013', '', '', '3306', 12, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:10:05', 'MC-01', 2024),
('3002', '2130020013', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020013', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020014', '', '', '3306', 58, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:10:59', 'MC-01', 2024),
('3002', '2130020014', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020014', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020015', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:03', 'MC-01', 2024),
('3002', '2130020015', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020015', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020016', '', '', '3306', 89, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:04', 'MC-01', 2024),
('3002', '2130020016', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020016', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020017', '', '', '3306', 78, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:06', 'MC-01', 2024),
('3002', '2130020017', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020017', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020018', '', '', '3306', 92, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:07', 'MC-01', 2024),
('3002', '2130020018', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020018', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020020', '', '', '3306', 82, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:09', 'MC-01', 2024),
('3002', '2130020020', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020020', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020021', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:11', 'MC-01', 2024),
('3002', '2130020021', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020021', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020022', '', '', '3306', 10, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:13', 'MC-01', 2024),
('3002', '2130020022', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020022', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020023', '', '', '3306', 66, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:14', 'MC-01', 2024),
('3002', '2130020023', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020023', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020024', '', '', '3306', 58, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:16', 'MC-01', 2024),
('3002', '2130020024', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020024', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020025', '', '', '3306', 55, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:19', 'MC-01', 2024),
('3002', '2130020025', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020025', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020026', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:22', 'MC-01', 2024),
('3002', '2130020026', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020026', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020027', '', '', '3306', 63, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:23', 'MC-01', 2024),
('3002', '2130020027', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020027', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020028', '', '', '3306', 87, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:25', 'MC-01', 2024),
('3002', '2130020028', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020028', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020029', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:28', 'MC-01', 2024),
('3002', '2130020029', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020029', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020030', '', '', '3306', 13, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:30', 'MC-01', 2024),
('3002', '2130020030', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020030', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020031', '', '', '3306', 65, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:32', 'MC-01', 2024),
('3002', '2130020031', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020031', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020032', '', '', '3306', 89, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:33', 'MC-01', 2024),
('3002', '2130020032', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020032', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020033', '', '', '3306', 74, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:35', 'MC-01', 2024),
('3002', '2130020033', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020033', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020034', '', '', '3306', 65, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:38', 'MC-01', 2024),
('3002', '2130020034', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020034', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020035', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:40', 'MC-01', 2024),
('3002', '2130020035', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020035', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020036', '', '', '3306', 23, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:43', 'MC-01', 2024),
('3002', '2130020036', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020036', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020037', '', '', '3306', 89, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:44', 'MC-01', 2024),
('3002', '2130020037', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020037', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020038', '', '', '3306', 41, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:11:46', 'MC-01', 2024),
('3002', '2130020038', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020038', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020039', '', '', '3306', 88, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:12:33', 'MC-01', 2024),
('3002', '2130020039', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020039', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020040', '', '', '3306', 33, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:12:36', 'MC-01', 2024),
('3002', '2130020040', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020040', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020041', '', '', '3306', 98, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:12:38', 'MC-01', 2024),
('3002', '2130020041', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020041', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020042', '', '', '3306', 12, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:12:39', 'MC-01', 2024),
('3002', '2130020042', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020042', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020043', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:12:42', 'MC-01', 2024),
('3002', '2130020043', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020043', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020044', '', '', '3306', 5, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:12:43', 'MC-01', 2024),
('3002', '2130020044', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020044', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020045', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020045', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020045', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020046', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020046', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020046', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020047', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020047', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020047', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020048', '', '', '3306', 98, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:09', 'MC-01', 2024),
('3002', '2130020048', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020048', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020049', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:11', 'MC-01', 2024),
('3002', '2130020049', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020049', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020050', '', '', '3306', 66, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:14', 'MC-01', 2024),
('3002', '2130020050', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020050', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020051', '', '', '3306', 25, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:17', 'MC-01', 2024),
('3002', '2130020051', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020051', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020052', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:19', 'MC-01', 2024),
('3002', '2130020052', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020052', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020053', '', '', '3306', 98, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:20', 'MC-01', 2024),
('3002', '2130020053', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020053', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020054', '', '', '3306', 77, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:23', 'MC-01', 2024),
('3002', '2130020054', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020054', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020055', '', '', '3306', 95, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:25', 'MC-01', 2024),
('3002', '2130020055', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020055', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020057', '', '', '3306', 88, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:28', 'MC-01', 2024),
('3002', '2130020057', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020057', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020058', '', '', '3306', 14, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:30', 'MC-01', 2024),
('3002', '2130020058', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020058', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020059', '', '', '3306', 56, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:32', 'MC-01', 2024),
('3002', '2130020059', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020059', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020060', '', '', '3306', 32, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:33', 'MC-01', 2024),
('3002', '2130020060', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020060', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020061', '', '', '3306', 85, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:35', 'MC-01', 2024),
('3002', '2130020061', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020061', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020062', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:38', 'MC-01', 2024),
('3002', '2130020062', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020062', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020063', '', '', '3306', 12, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:40', 'MC-01', 2024),
('3002', '2130020063', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020063', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020064', '', '', '3306', 55, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:42', 'MC-01', 2024),
('3002', '2130020064', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020064', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020065', '', '', '3306', 25, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:44', 'MC-01', 2024),
('3002', '2130020065', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020065', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020066', '', '', '3306', 36, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:47', 'MC-01', 2024),
('3002', '2130020066', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020066', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020067', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:49', 'MC-01', 2024),
('3002', '2130020067', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020067', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020068', '', '', '3306', 22, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:52', 'MC-01', 2024),
('3002', '2130020068', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020068', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020069', '', '', '3306', 66, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:13:54', 'MC-01', 2024),
('3002', '2130020069', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020069', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020070', '', '', '3306', 96, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:01', 'MC-01', 2024),
('3002', '2130020070', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020070', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020071', '', '', '3306', 78, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:04', 'MC-01', 2024),
('3002', '2130020071', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020071', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020072', '', '', '3306', 98, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:05', 'MC-01', 2024),
('3002', '2130020072', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020072', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020073', '', '', '3306', 74, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:10', 'MC-01', 2024),
('3002', '2130020073', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020073', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020074', '', '', '3306', 23, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:12', 'MC-01', 2024),
('3002', '2130020074', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020074', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020075', '', '', '3306', 48, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:14', 'MC-01', 2024),
('3002', '2130020075', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020075', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020076', '', '', '3306', 96, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:17', 'MC-01', 2024),
('3002', '2130020076', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020076', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020077', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:19', 'MC-01', 2024),
('3002', '2130020077', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020077', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020078', '', '', '3306', 22, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:21', 'MC-01', 2024),
('3002', '2130020078', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020078', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020079', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020079', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020079', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020080', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020080', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020080', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020082', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020082', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020082', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020083', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020083', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020083', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020084', '', '', '3306', 25, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:46', 'MC-01', 2024),
('3002', '2130020084', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020084', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020085', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:48', 'MC-01', 2024),
('3002', '2130020085', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020085', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020086', '', '', '3306', 99, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:49', 'MC-01', 2024),
('3002', '2130020086', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020086', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020087', '', '', '3306', 88, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:52', 'MC-01', 2024),
('3002', '2130020087', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020087', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020088', '', '', '3306', 78, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:54', 'MC-01', 2024),
('3002', '2130020088', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020088', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020089', '', '', '3306', 23, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:56', 'MC-01', 2024),
('3002', '2130020089', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020089', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020090', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:14:58', 'MC-01', 2024),
('3002', '2130020090', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020090', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020091', '', '', '3306', 25, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:15:02', 'MC-01', 2024),
('3002', '2130020091', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020091', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020092', '', '', '3306', 45, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:15:04', 'MC-01', 2024),
('3002', '2130020092', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020092', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020093', '', '', '3306', 65, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:15:07', 'MC-01', 2024),
('3002', '2130020093', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020093', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020094', '', '', '3306', 88, '-', 0, 0, 1, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:15:13', 'MC-01', 2024),
('3002', '2130020094', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3002', '2130020094', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050002', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050002', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050003', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050003', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050003', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050004', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050004', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050004', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050005', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050005', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050005', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050006', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050007', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050007', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050007', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050008', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050008', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050008', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050009', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050009', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050009', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050010', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050010', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050010', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050011', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050011', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050011', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050012', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050012', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050012', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050013', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050013', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050013', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050014', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050014', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050014', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050015', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050015', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050015', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050016', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050016', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050016', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050017', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050017', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050017', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050018', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050018', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050018', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050019', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050019', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050019', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050020', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050020', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050020', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050021', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050021', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050021', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050022', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050022', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050022', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050023', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050023', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050023', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050024', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050024', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050024', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050025', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050025', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050025', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050026', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050026', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050026', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050027', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050027', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050027', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050028', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050028', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050028', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050029', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050029', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050029', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050030', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050030', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050030', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050031', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050031', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050031', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050032', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050032', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050032', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050033', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050033', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050033', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050034', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050034', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050034', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050035', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050035', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050035', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050036', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050036', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050036', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050037', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050037', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050037', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050038', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050038', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050038', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050039', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050039', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050039', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050040', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050040', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050040', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050041', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050041', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050041', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050042', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050042', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050042', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050043', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050043', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050043', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050044', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050044', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050044', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050045', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050045', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050045', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050046', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050046', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050046', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050048', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050048', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050048', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050049', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050049', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024);
INSERT INTO `marks` (`centre_code`, `exam_no`, `first_name`, `last_name`, `subject_code`, `mark`, `status`, `sen`, `improvised_mark`, `belt_no`, `entered_by`, `date_entered`, `marking_centre`, `session`) VALUES
('3005', '2130050049', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050050', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050050', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050050', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050051', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050051', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050051', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050052', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050052', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050052', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050053', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050053', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050053', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050054', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050054', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050054', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050055', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050055', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050055', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050056', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050056', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050056', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050057', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050057', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050057', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050058', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050058', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050058', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050059', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050059', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050059', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050060', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050060', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050060', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050062', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050062', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050062', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050063', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050063', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050063', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050064', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050064', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050064', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050065', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050065', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050065', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050066', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050066', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050066', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050067', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050067', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050067', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050068', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050068', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3005', '2130050068', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2130100001', '', '', '3306', 77, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:21', 'MC-01', 2024),
('3010', '2130100001', '', '', '3308', 99, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:38:53', 'MC-01', 2024),
('3010', '2130100001', '', '', '3309', 12, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:28', 'MC-01', 2024),
('3010', '2130100002', '', '', '3306', 96, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:23', 'MC-01', 2024),
('3010', '2130100002', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:38:54', 'MC-01', 2024),
('3010', '2130100002', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:29', 'MC-01', 2024),
('3010', '2130100004', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:24', 'MC-01', 2024),
('3010', '2130100004', '', '', '3308', 25, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:38:56', 'MC-01', 2024),
('3010', '2130100004', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:32', 'MC-01', 2024),
('3010', '2130100005', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:27', 'MC-01', 2024),
('3010', '2130100005', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:38:57', 'MC-01', 2024),
('3010', '2130100005', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:33', 'MC-01', 2024),
('3010', '2130100006', '', '', '3306', 22, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:28', 'MC-01', 2024),
('3010', '2130100006', '', '', '3308', 44, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:38:58', 'MC-01', 2024),
('3010', '2130100006', '', '', '3309', 66, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:35', 'MC-01', 2024),
('3010', '2130100007', '', '', '3306', 65, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:29', 'MC-01', 2024),
('3010', '2130100007', '', '', '3308', 89, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:00', 'MC-01', 2024),
('3010', '2130100007', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:36', 'MC-01', 2024),
('3010', '2130100008', '', '', '3306', 12, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:32', 'MC-01', 2024),
('3010', '2130100008', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:01', 'MC-01', 2024),
('3010', '2130100008', '', '', '3309', 88, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:39', 'MC-01', 2024),
('3010', '2130100009', '', '', '3306', 69, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:33', 'MC-01', 2024),
('3010', '2130100009', '', '', '3308', 12, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:03', 'MC-01', 2024),
('3010', '2130100009', '', '', '3309', 23, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:41', 'MC-01', 2024),
('3010', '2130100010', '', '', '3306', 78, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:35', 'MC-01', 2024),
('3010', '2130100010', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:04', 'MC-01', 2024),
('3010', '2130100010', '', '', '3309', 14, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:43', 'MC-01', 2024),
('3010', '2130100011', '', '', '3306', 12, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:36', 'MC-01', 2024),
('3010', '2130100011', '', '', '3308', 99, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:06', 'MC-01', 2024),
('3010', '2130100011', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:44', 'MC-01', 2024),
('3010', '2130100012', '', '', '3306', 22, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:38', 'MC-01', 2024),
('3010', '2130100012', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:07', 'MC-01', 2024),
('3010', '2130100012', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:45', 'MC-01', 2024),
('3010', '2130100013', '', '', '3306', 65, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:40', 'MC-01', 2024),
('3010', '2130100013', '', '', '3308', 25, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:08', 'MC-01', 2024),
('3010', '2130100013', '', '', '3309', 78, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:47', 'MC-01', 2024),
('3010', '2130100014', '', '', '3306', 12, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:42', 'MC-01', 2024),
('3010', '2130100014', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:10', 'MC-01', 2024),
('3010', '2130100014', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:51', 'MC-01', 2024),
('3010', '2130100015', '', '', '3306', 36, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:43', 'MC-01', 2024),
('3010', '2130100015', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:11', 'MC-01', 2024),
('3010', '2130100015', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:53', 'MC-01', 2024),
('3010', '2130100016', '', '', '3306', 99, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:44', 'MC-01', 2024),
('3010', '2130100016', '', '', '3308', 12, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:17', 'MC-01', 2024),
('3010', '2130100016', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:54', 'MC-01', 2024),
('3010', '2130100018', '', '', '3306', 78, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:48', 'MC-01', 2024),
('3010', '2130100018', '', '', '3308', 11, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:20', 'MC-01', 2024),
('3010', '2130100018', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:56', 'MC-01', 2024),
('3010', '2130100019', '', '', '3306', 25, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:51', 'MC-01', 2024),
('3010', '2130100019', '', '', '3308', 25, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:21', 'MC-01', 2024),
('3010', '2130100019', '', '', '3309', 12, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:47:58', 'MC-01', 2024),
('3010', '2130100020', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:52', 'MC-01', 2024),
('3010', '2130100020', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:25', 'MC-01', 2024),
('3010', '2130100020', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:11', 'MC-01', 2024),
('3010', '2130100021', '', '', '3306', 12, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:54', 'MC-01', 2024),
('3010', '2130100021', '', '', '3308', 12, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:28', 'MC-01', 2024),
('3010', '2130100021', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:16', 'MC-01', 2024),
('3010', '2130100022', '', '', '3306', 25, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:56', 'MC-01', 2024),
('3010', '2130100022', '', '', '3308', 25, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:30', 'MC-01', 2024),
('3010', '2130100022', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:18', 'MC-01', 2024),
('3010', '2130100026', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:26:58', 'MC-01', 2024),
('3010', '2130100026', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:31', 'MC-01', 2024),
('3010', '2130100026', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:20', 'MC-01', 2024),
('3010', '2130100027', '', '', '3306', 25, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:01', 'MC-01', 2024),
('3010', '2130100027', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:33', 'MC-01', 2024),
('3010', '2130100027', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:23', 'MC-01', 2024),
('3010', '2130100028', '', '', '3306', 66, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:02', 'MC-01', 2024),
('3010', '2130100028', '', '', '3308', 12, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:35', 'MC-01', 2024),
('3010', '2130100028', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:25', 'MC-01', 2024),
('3010', '2130100029', '', '', '3306', 87, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:04', 'MC-01', 2024),
('3010', '2130100029', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:37', 'MC-01', 2024),
('3010', '2130100029', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:27', 'MC-01', 2024),
('3010', '2130100031', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:10', 'MC-01', 2024),
('3010', '2130100031', '', '', '3308', 88, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:39', 'MC-01', 2024),
('3010', '2130100031', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:28', 'MC-01', 2024),
('3010', '2130100032', '', '', '3306', 11, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:13', 'MC-01', 2024),
('3010', '2130100032', '', '', '3308', 99, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:41', 'MC-01', 2024),
('3010', '2130100032', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:38', 'MC-01', 2024),
('3010', '2130100033', '', '', '3306', 36, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:15', 'MC-01', 2024),
('3010', '2130100033', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:43', 'MC-01', 2024),
('3010', '2130100033', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:40', 'MC-01', 2024),
('3010', '2130100034', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:16', 'MC-01', 2024),
('3010', '2130100034', '', '', '3308', 0, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:39:58', 'MC-01', 2024),
('3010', '2130100034', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:43', 'MC-01', 2024),
('3010', '2130100035', '', '', '3306', 25, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:18', 'MC-01', 2024),
('3010', '2130100035', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:05', 'MC-01', 2024),
('3010', '2130100035', '', '', '3309', 12, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:46', 'MC-01', 2024),
('3010', '2130100037', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2130100037', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:08', 'MC-01', 2024),
('3010', '2130100037', '', '', '3309', 25, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:48', 'MC-01', 2024),
('3010', '2130100038', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2130100038', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:09', 'MC-01', 2024),
('3010', '2130100038', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:49', 'MC-01', 2024),
('3010', '2130100039', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2130100039', '', '', '3308', 77, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:11', 'MC-01', 2024),
('3010', '2130100039', '', '', '3309', 45, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:50', 'MC-01', 2024),
('3010', '2130100040', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2130100040', '', '', '3308', 45, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:15', 'MC-01', 2024),
('3010', '2130100040', '', '', '3309', 89, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:52', 'MC-01', 2024),
('3010', '2130100041', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3010', '2130100041', '', '', '3308', 25, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:17', 'MC-01', 2024),
('3010', '2130100041', '', '', '3309', 55, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:48:56', 'MC-01', 2024),
('3010', '2130100042', '', '', '3306', 45, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:34', 'MC-01', 2024),
('3010', '2130100042', '', '', '3308', 36, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:20', 'MC-01', 2024),
('3010', '2130100042', '', '', '3309', 31, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:49:02', 'MC-01', 2024),
('3010', '2130100043', '', '', '3306', 69, '-', 0, 0, 2, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:27:35', 'MC-01', 2024),
('3010', '2130100043', '', '', '3308', 77, '-', 0, 0, 3, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:40:22', 'MC-01', 2024),
('3010', '2130100043', '', '', '3309', 36, '-', 0, 0, 5, 'teddeo - JOSHUA MARTIN', '23/10/2024 15:49:03', 'MC-01', 2024),
('3028', '2130280001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280002', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280002', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280003', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280003', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280003', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280005', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280005', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280005', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280006', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280007', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280007', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280007', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280008', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280008', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280008', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280009', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280009', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280009', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280010', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280010', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280010', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280011', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280011', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280011', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280012', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280012', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280012', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280013', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280013', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3028', '2130280013', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370002', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370002', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370003', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370003', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370003', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370004', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370004', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370004', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370005', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370005', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3037', '2130370005', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530006', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530007', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530007', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530007', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530008', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530008', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530008', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530009', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530009', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530009', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530010', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530010', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3053', '2130530010', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540002', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540002', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540003', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540003', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540003', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540004', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540004', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540004', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540006', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3054', '2130540006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640001', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640001', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640001', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640002', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640002', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640002', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640004', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640004', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640004', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640006', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640006', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640006', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640010', '', '', '3306', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640010', '', '', '3308', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3064', '2130640010', '', '', '3309', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070001', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070001', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070002', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070002', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070003', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070003', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070003', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070003', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070004', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070004', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070004', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070004', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070005', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070005', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070005', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070005', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070006', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070006', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070008', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070008', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070008', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070008', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070009', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070009', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070009', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070009', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070010', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070010', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070010', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070010', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070011', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070011', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070015', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070015', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070017', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070017', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070018', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070018', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070019', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070019', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070020', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070020', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070021', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070021', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070022', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070022', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070022', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070022', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070023', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070023', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070023', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070023', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070025', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070025', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070025', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070025', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070026', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070026', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070026', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070026', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070027', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070027', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070028', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070028', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070029', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070029', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070029', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070029', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070030', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070030', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070031', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070031', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070032', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070032', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070034', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4007', '2140070034', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080001', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080001', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080002', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080002', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080003', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080003', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080004', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080004', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080005', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080005', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080006', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080006', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080007', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080007', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080007', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080007', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080010', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080010', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080010', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080010', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080011', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080011', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080012', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080012', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080014', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080014', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080016', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080016', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080016', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080016', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080017', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080017', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080018', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080018', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080019', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080019', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080020', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080020', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080020', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080020', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080021', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080021', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080022', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080022', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080023', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080023', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080025', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080025', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080026', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080026', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080027', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080027', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080028', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080028', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080028', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080028', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080029', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080029', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080030', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080030', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080032', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080032', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080033', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080033', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080034', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080034', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080035', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080035', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080035', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080035', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080036', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080036', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080038', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080038', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080039', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080039', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080040', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080040', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080041', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080041', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080042', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080042', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080043', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080043', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080043', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080043', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080044', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080044', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080045', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080045', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080046', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080046', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080047', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080047', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080048', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080048', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080048', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080048', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080049', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080049', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080050', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080050', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080051', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080051', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080052', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080052', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080052', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080052', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080053', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080053', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080054', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080054', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080055', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080055', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080056', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080056', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080057', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080057', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080058', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080058', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080059', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080059', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080060', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080060', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080061', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080061', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080061', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080061', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080062', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080062', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080063', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080063', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080063', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080063', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080064', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080064', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080064', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080064', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080065', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080065', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080066', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080066', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080067', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080067', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080068', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080068', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080068', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080068', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080069', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080069', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080071', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080071', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080071', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080071', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080072', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080072', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080073', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080073', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080073', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080073', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080074', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080074', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080074', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080074', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080075', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080075', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080076', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080076', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080077', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080077', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080078', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080078', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080079', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080079', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080079', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080079', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080080', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080080', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080081', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080081', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080081', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080081', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080082', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080082', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080083', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080083', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080084', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080084', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080084', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080084', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080085', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080085', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080086', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080086', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080086', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080086', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080087', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024);
INSERT INTO `marks` (`centre_code`, `exam_no`, `first_name`, `last_name`, `subject_code`, `mark`, `status`, `sen`, `improvised_mark`, `belt_no`, `entered_by`, `date_entered`, `marking_centre`, `session`) VALUES
('4008', '2140080087', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080088', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080088', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080089', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080089', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080090', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4008', '2140080090', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240009', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240009', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240010', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240010', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240011', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240011', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240012', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240012', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240013', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240013', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240013', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240013', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240014', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240014', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240014', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240014', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240015', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240015', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240015', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240015', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240016', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240016', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240016', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240016', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240017', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240017', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240017', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240017', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240018', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240018', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240018', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240018', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240019', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240019', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240019', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240019', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240020', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240020', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240020', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240020', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240021', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240021', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240021', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240021', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240023', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240023', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240023', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240023', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240024', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240024', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240024', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240024', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240025', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240025', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240025', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240025', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240031', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240031', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240032', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240032', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240033', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240033', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240034', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240034', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240035', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240035', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240036', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240036', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240037', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240037', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240038', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240038', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240039', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240039', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240040', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240040', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240041', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240041', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240042', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240042', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240043', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240043', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240044', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240044', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240045', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240045', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240046', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240046', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240047', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240047', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240048', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4024', '2140240048', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270001', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270001', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270002', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270002', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270003', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270003', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270003', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270003', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270004', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270004', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270005', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270005', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270006', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270006', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270007', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270007', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270008', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270008', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270009', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270009', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270009', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270009', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270010', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270010', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270011', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270011', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270012', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270012', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270012', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270012', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270013', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270013', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270014', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270014', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270015', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270015', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270016', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270016', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270017', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270017', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270018', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270018', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270019', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270019', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270020', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270020', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270021', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270021', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270022', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270022', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270023', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270023', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270024', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270024', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270024', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270024', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270025', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270025', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270026', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270026', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270027', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270027', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270028', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270028', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270029', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270029', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270030', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270030', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270031', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270031', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270032', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270032', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270033', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270033', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270034', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270034', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270035', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270035', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270036', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270036', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270037', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270037', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270037', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270037', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270038', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270038', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270039', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270039', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270040', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270040', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270040', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270040', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270041', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270041', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270042', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270042', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270043', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270043', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270044', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270044', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270045', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270045', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270046', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270046', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270047', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270047', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270048', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270048', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270052', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270052', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270053', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270053', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270054', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270054', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270055', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270055', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270055', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270055', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270056', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270056', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270057', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4027', '2140270057', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350001', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350001', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350002', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350002', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350003', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350003', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350004', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350004', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350005', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350005', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350006', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350006', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350007', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350007', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350008', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350008', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350009', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350009', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350010', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350010', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350011', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350011', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350012', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350012', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350013', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350013', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350014', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350014', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350015', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350015', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350016', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4035', '2140350016', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '2140360005', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '2140360005', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '2140360008', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '2140360008', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '2140360009', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4036', '2140360009', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380016', '', '', '43131', 36, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:48', 'MC-01', 2024),
('4038', '2140380016', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380017', '', '', '43131', 45, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:49', 'MC-01', 2024),
('4038', '2140380017', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380018', '', '', '43131', 22, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:50', 'MC-01', 2024),
('4038', '2140380018', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380019', '', '', '43131', 36, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:52', 'MC-01', 2024),
('4038', '2140380019', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380020', '', '', '43131', 45, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:53', 'MC-01', 2024),
('4038', '2140380020', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380021', '', '', '43131', 25, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:55', 'MC-01', 2024),
('4038', '2140380021', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380022', '', '', '43131', 78, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:54:59', 'MC-01', 2024),
('4038', '2140380022', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380023', '', '', '43131', 36, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:01', 'MC-01', 2024),
('4038', '2140380023', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380024', '', '', '43131', 45, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:04', 'MC-01', 2024),
('4038', '2140380024', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380025', '', '', '43131', 25, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:06', 'MC-01', 2024),
('4038', '2140380025', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380026', '', '', '43131', 36, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:08', 'MC-01', 2024),
('4038', '2140380026', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380027', '', '', '43131', 45, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:10', 'MC-01', 2024),
('4038', '2140380027', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380029', '', '', '43131', 36, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:14', 'MC-01', 2024),
('4038', '2140380029', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380030', '', '', '43131', 45, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:15', 'MC-01', 2024),
('4038', '2140380030', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380036', '', '', '43131', 25, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:17', 'MC-01', 2024),
('4038', '2140380036', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4038', '2140380038', '', '', '43131', 23, '-', 0, 0, 4, 'teddeo - JOSHUA MARTIN', '23/10/2024 14:55:19', 'MC-01', 2024),
('4038', '2140380038', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390004', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390004', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390005', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390005', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390007', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390007', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390010', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390010', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390015', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390015', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390016', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390016', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390017', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390017', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390018', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390018', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390019', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4039', '2140390019', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400001', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400001', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400002', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400002', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400003', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400003', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400004', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400004', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400005', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400005', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400006', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400006', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400008', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400008', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400009', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400009', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400009', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400009', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400010', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400010', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400010', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4040', '2140400010', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410002', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410002', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410003', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410003', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410003', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410003', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410005', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410005', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410006', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410006', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410006', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410006', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410008', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410008', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410008', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410008', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410012', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410012', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410015', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410015', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410016', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410016', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410018', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410018', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410020', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410020', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410021', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410021', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410023', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410023', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410024', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410024', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410026', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410026', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410027', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410027', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410028', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410028', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410029', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410029', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410029', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410029', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410030', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410030', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410030', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410030', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410032', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410032', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410033', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410033', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410033', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410033', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410034', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410034', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410035', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410035', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410036', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410036', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410037', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410037', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410038', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410038', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410040', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410040', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410040', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410040', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410041', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410041', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410042', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410042', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410043', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410043', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410043', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410043', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410044', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410044', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410045', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410045', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410046', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410046', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410047', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410047', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410048', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410048', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410048', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410048', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410049', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410049', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410049', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410049', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410051', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410051', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410052', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410052', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410053', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410053', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410053', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410053', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410054', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410054', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410055', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410055', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410056', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410056', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410057', '', '', '43171', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410057', '', '', '43172', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410057', '', '', '43173', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410058', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410058', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410058', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410058', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410063', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410063', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410063', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410063', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410067', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410067', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410067', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410067', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410068', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410068', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410068', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410068', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410073', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410073', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410075', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410075', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410078', '', '', '43171', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410078', '', '', '43172', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410078', '', '', '43173', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410079', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410079', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410082', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410082', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410082', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410082', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410083', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410083', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410083', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410083', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410084', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410084', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410084', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410084', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410085', '', '', '43171', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410085', '', '', '43172', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410085', '', '', '43173', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410087', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410087', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410089', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410089', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410089', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410089', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410090', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410090', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410092', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410092', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410092', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410092', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410093', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410093', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410093', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410093', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410095', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410095', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410096', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410096', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410096', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410096', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410097', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410097', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410098', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410098', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410098', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410098', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410099', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410099', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410099', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410099', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410102', '', '', '43171', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410102', '', '', '43172', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410102', '', '', '43173', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410102', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410102', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410104', '', '', '43111', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410104', '', '', '43115', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410104', '', '', '43116', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410104', '', '', '43117', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410105', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410105', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410105', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410105', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410106', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410106', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410107', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410107', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410108', '', '', '43121', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410108', '', '', '43126', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410109', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410109', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410110', '', '', '43131', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410110', '', '', '43135', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410111', '', '', '43165', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410111', '', '', '43166', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410111', '', '', '43167', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410111', '', '', '43168', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410112', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410112', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410113', '', '', '43191', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410113', '', '', '43195', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410115', '', '', '43201', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('4041', '2140410115', '', '', '43204', 0, 'L', 0, 0, 0, 'none', 'none', 'MC-01', 2024),
('3004', '3225456100', '', '', '3309', 12, '-', 0, 1, 1, 'teddeo - JOSHUA MARTIN', '24/10/2024 11:10:38', 'MC-01', 2024);

--
-- Triggers `marks`
--
DELIMITER $$
CREATE TRIGGER `marks_audit_trail_delete_marks` AFTER DELETE ON `marks` FOR EACH ROW BEGIN
  INSERT INTO marks_audit_trail (
    centre_code,
    exam_no,
    subject_code,
     old_mark,
    new_mark,
    status,
    sen,
    improvised_mark,
    entered_by,
    action,
    date_entered,
    marking_centre,
      session
  ) VALUES (
    OLD.centre_code,
    OLD.exam_no,
    OLD.subject_code,
     "",
    OLD.mark,
    OLD.status,
    OLD.sen,
    OLD.improvised_mark,
    OLD.entered_by,
    'DELETE',
    NOW(),  -- You may need to adjust this based on your specific database's date/time functions
    OLD.marking_centre,
      OLD.session
  );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `marks_audit_trail_trigger` AFTER UPDATE ON `marks` FOR EACH ROW BEGIN
  IF (NEW.mark != OLD.mark OR OLD.status != NEW.status) 
     AND (OLD.status != "L") 
      THEN
    INSERT INTO marks_audit_trail (
      centre_code,
      exam_no,
      subject_code,
      old_mark,
      old_status,
      new_mark,
      status,
      sen,
      improvised_mark,
      entered_by,
      action,
      date_entered,
      marking_centre,
      session
    ) VALUES (
      NEW.centre_code,
      NEW.exam_no,
      NEW.subject_code,
      CASE 
        WHEN OLD.mark = 0 AND OLD.status = "L" THEN NULL 
        ELSE OLD.mark 
      END,
      OLD.status,
      NEW.mark,
      NEW.status,
      NEW.sen,
      NEW.improvised_mark,
      NEW.entered_by,
      'UPDATE',
      NEW.date_entered,  
      NEW.marking_centre,
      NEW.session
    );
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `marks_audit_trail`
--

CREATE TABLE `marks_audit_trail` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `new_mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sen` int DEFAULT '0',
  `improvised_mark` int NOT NULL DEFAULT '0',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks_audit_trail`
--

INSERT INTO `marks_audit_trail` (`centre_code`, `exam_no`, `subject_code`, `old_mark`, `old_status`, `new_mark`, `status`, `sen`, `improvised_mark`, `entered_by`, `action`, `date_entered`, `marking_centre`, `session`) VALUES
('3004', '1630040193', '3309', '23', '-', '0', 'L', 0, 0, 'none', 'UPDATE', 'none', 'MC-01', 2023),
('3004', '1930220014', '3309', '58', '-', '0', 'L', 0, 0, 'none', 'UPDATE', 'none', 'MC-01', 2023),
('3004', '1930220015', '3309', '69', '-', '0', 'L', 0, 0, 'none', 'UPDATE', 'none', 'MC-01', 2023),
('3004', '2030220005', '3309', '74', '-', '0', 'L', 0, 0, 'none', 'UPDATE', 'none', 'MC-01', 2023),
('3004', '2030220008', '3309', '14', '-', '0', 'L', 0, 0, 'none', 'UPDATE', 'none', 'MC-01', 2023),
('3004', '3200005010', '3309', '', '0', '71', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'DELETE', '2024-10-24 12:47:33', 'MC-01', 2023),
('3004', '3200125412', '3309', '65', '-', '56', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'UPDATE', '24/10/2024 10:10:05', 'MC-01', 2023),
('3004', '3200125412', '3309', '56', '-', '66', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'UPDATE', '24/10/2024 10:10:05', 'MC-01', 2023),
('3004', '3200125412', '3309', '', '0', '66', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'DELETE', '2024-10-24 15:07:49', 'MC-01', 2023),
('3004', '3200005010', '3309', '', '0', '72', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'DELETE', '2024-10-24 15:25:15', 'MC-01', 2023),
('3004', '3255878510', '3309', '', '0', '31', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'DELETE', '2024-10-24 15:26:50', 'MC-01', 2023),
('3004', '3244785210', '3309', '', '0', '88', '-', 0, 1, 'teddeo - JOSHUA MARTIN', 'DELETE', '2024-10-24 15:37:09', 'MC-01', 2023);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`centre_code`, `centre_name`, `session`) VALUES
('2030', 'DAVID LIVINGSTONE COLLEGE OF EDUCATION', 2024),
('2031', 'KITWE COLLEGE OF EDUCATION', 2024),
('2033', 'CHIPATA COLLEGE OF EDUCATION', 2024),
('2036', 'KASAMA COLLEGE OF EDUCATION', 2024),
('2041', 'MONGU COLLEGE OF EDUCATION', 2024),
('2071', 'SOLWEZI ECE COLLEGE OF EDUCATION', 2024),
('2072', 'MANSA ECE COLLEGE OF EDUCATION', 2024),
('3002', 'CHIPATA COLLEGE OF EDUCATION', 2024),
('3004', 'KASAMA COLLEGE OF EDUCATION', 2024),
('3005', 'KITWE COLLEGE OF EDUCATION', 2024),
('3007', 'MANSA COLLEGE OF EDUCATION', 2024),
('3010', 'SOLWEZI COLLEGE OF EDUCATION', 2024),
('3013', 'MAKENI COLLEGE OF EDUCATION', 2024),
('3028', 'NKANA COLLEGE OF APPLIED SCIENCES AND  EDUCATION', 2024),
('3053', 'SAMBIZGA COLLEGE OF EDUCATION', 2024),
('3054', 'CENTRAL AFRICA BAPTIST  COLLEGE', 2024),
('3064', 'ROKANA COLLEGE OF EDUCATION', 2024),
('4002', 'DAVID LIVINGSTONE COLLEGE OF EDUCATION', 2024),
('4003', 'KASAMA COLLEGE OF EDUCATION', 2024),
('4006', 'MAKENI COLLEGE OF EDUCATION', 2024),
('4007', 'SOLWEZI COLLEGE OF EDUCATION', 2024),
('4008', 'KITWE COLLEGE OF EDUCATION', 2024),
('4017', 'EVERGREEN COLLEGE OF EDUCATION', 2024),
('4024', 'ST. MARY\'S COLLEGE OF EDUCATION', 2024),
('4027', 'GEORGE BENSON CHRISTIAN COLLEGE OF EDUCATION', 2024),
('4035', 'LIVINGSTONE INSTITUTE OF BUSINESS AND ENGINEERING STUDIES', 2024),
('4036', 'ROKANA COLLEGE OF EDUCATION', 2024),
('4038', 'LUSAKA JSTD BUSINESS AND TECHNICAL COLLEGE', 2024),
('4039', 'NKANA COLLEGE OF APPLIED SCIENCES AND EDUCATION', 2024),
('4040', 'EVELYN HONE COLLEGE OF APPLIED ARTS AND COMMERCE', 2024),
('4041', 'CHIPATA COLLEGE OF EDUCATION', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `name`, `year`, `level`) VALUES
(2024, '2024TEACHER EDUCATION', '2024', 'TED');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int NOT NULL,
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_mark` int NOT NULL,
  `course_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `subject_name`, `max_mark`, `course_id`, `session`) VALUES
(156, 'LLD_23', 'LITERACY AND LANGUAGES DEVELOPMENT        III', 100, 'LLD2', 2024),
(157, 'LLE_33', 'LITERACY AND LANGUAGES   EDUCATION   III', 100, 'LLE3', 2024),
(158, 'ELE_43', 'ENGLISH LANGUAGE TEACHING METHODS III', 100, 'ELE4', 2024),
(159, 'ELE_43', 'THE STRUCTURE OF ENGLISH LANGUAGE AND LINGUISTICS III', 100, 'ELE4', 2024),
(160, 'ELE_43', 'LITERATURE IN ENGLISH III', 100, 'ELE4', 2024),
(161, 'ESE_23', 'ENVIRONMENTAL  SCIENCE  EDUCATION   III', 100, 'ESE2', 2024),
(162, 'ISE_33', 'INTEGRATED SCIENCE EDUCATION III', 100, 'ISE3', 2024),
(163, 'ISE_43', 'INTEGRATED SCIENCE TEACHING METHODS III', 100, 'ISE4', 2024),
(164, 'ISE_43', 'BIOLOGY III GENETICS, HEALTH AND ENVIRONMENT', 100, 'ISE4', 2024),
(165, 'ISE_43', 'CHEMISTRY III ORGANIC AND ELECTRONIC CHEMISTRY', 100, 'ISE4', 2024),
(166, 'ISE_43', 'PHYSICS III ELECTRICITY, MAGNETISM  AND  RADIATION PHYSICS', 100, 'ISE4', 2024),
(167, 'ASE_43', 'AGRICULTURE SCIENCE TEACHING METHODS III', 100, 'ASE4', 2024),
(168, 'ASE_43', 'AGRICULTURAL SCIENCE III', 100, 'ASE4', 2024),
(169, 'PME_23', 'PRE- MATHEMATICS  EDUCATION  III', 100, 'PME2', 2024),
(170, 'MED_33', 'MATHEMATICS EDUCATION III', 100, 'MED3', 2024),
(171, 'MED_43', 'MATHEMATICS  III', 100, 'MED4', 2024),
(172, 'MED_43', 'MATHEMATICS TEACHING METHODS  III', 100, 'MED4', 2024),
(173, 'ICT_21', 'INFORMATION COMMUNICATION TECHNOLOGY', 100, 'ICT0', 2024),
(174, 'ICT_31', 'INFORMATION & COMMUNICATION TECHNOLOGY', 100, 'ICT0', 2024),
(175, 'ICT_41', 'INFORMATION COMMUNICATION TECHNOLOGY', 100, 'ICT0', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `user_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_status` int NOT NULL,
  `session` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `nrc`, `phone`, `bank`, `branch`, `account_no`, `province`, `marking_centre`, `user_type`, `added_by`, `activation_status`, `session`) VALUES
(1, 'eczuser', 'ecz@exams-council.org.zm', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'JOSHUA', 'MBEWE', NULL, NULL, NULL, NULL, NULL, '0', '000000', 'ECZ', '', 1, ''),
(39, 'tedseso', 'jo.mbewe@gmail.com', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'SESO', 'TED', NULL, NULL, NULL, NULL, NULL, '4', '000000', 'SESO', '', 1, ''),
(40, 'tedadmin', 'jmbewe@exams-council.org.zm', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'JOSH', 'MARTIN', NULL, NULL, NULL, NULL, NULL, NULL, 'MC-01', 'ADMIN', 'tedseso', 1, ''),
(45, 'jmbeweseso', 'jbewe@exams-council.org.zm', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'JOSHUA', 'MBEWE', NULL, NULL, NULL, NULL, NULL, '5', '000000', 'SESO', '', 1, ''),
(46, 'jmbeweadmin', 'joshua.mbewe@gmail.com', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'JOSHUA', 'MBEWE', NULL, NULL, NULL, NULL, NULL, NULL, 'MC-01', 'ADMIN', 'jmbeweseso', 1, ''),
(47, 'jmbewedeo', 'jmbewe@exams-council.org.zm', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'MARTIN', 'MBEWE', NULL, NULL, NULL, NULL, NULL, NULL, 'MC-01', 'DEO', 'jmbeweadmin', 1, ''),
(48, 'teddeo', 'jmbewe@exams-council.org.zm', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'JOSHUA', 'MARTIN', '123255/10/1', '0999854788', 'ZANACO', 'CAIRO', '07745210021475', '09', 'MC-01', 'DEO', 'tedseso', 1, '');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `update_username_apportionment` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
update apportionment set username = concat(new.username,' - ',new.first_name,' ',new.last_name) where LEFT(username,LOCATE(" ",username) -1) = new.username and LEFT(username,LOCATE(" ",username) -1) = (select username from users where user_type = 'ADMIN');
end
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apportionment`
--
ALTER TABLE `apportionment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school` (`school`,`group_code`,`subject`,`course`,`session`) USING BTREE,
  ADD KEY `group_id` (`group_apportion_id`),
  ADD KEY `group_id_2` (`group_apportion_id`,`group_code`,`marking_centre`,`username`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `subject` (`group_code`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `apportionment_temp`
--
ALTER TABLE `apportionment_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school` (`school`,`group_code`,`subject`,`course`,`session`) USING BTREE,
  ADD KEY `group_id` (`group_apportion_id`),
  ADD KEY `group_id_2` (`group_apportion_id`,`group_code`,`marking_centre`,`username`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `subject` (`group_code`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `centre`
--
ALTER TABLE `centre`
  ADD PRIMARY KEY (`centre_code`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `course_group`
--
ALTER TABLE `course_group`
  ADD PRIMARY KEY (`group_code`);

--
-- Indexes for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `examiner_number` (`examiner_number`);

--
-- Indexes for table `examiner`
--
ALTER TABLE `examiner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank` (`bank`),
  ADD KEY `subject_code` (`course_code`),
  ADD KEY `role` (`role`),
  ADD KEY `session` (`session`),
  ADD KEY `attendance` (`attendance`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `branch` (`branch`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `activation_status` (`activation_status`),
  ADD KEY `login_status` (`login_status`);

--
-- Indexes for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrc` (`nrc`,`tpin`,`group_code`,`course_code`);

--
-- Indexes for table `group_apportion`
--
ALTER TABLE `group_apportion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group` (`group_code`,`belt_no`,`marking_centre`,`session`),
  ADD KEY `id` (`id`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `marking_centre`
--
ALTER TABLE `marking_centre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course` (`course`,`centre_code`,`session`),
  ADD KEY `id` (`id`),
  ADD KEY `subject` (`course`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `marking_rates`
--
ALTER TABLE `marking_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session` (`session`),
  ADD KEY `examiner` (`examiner`),
  ADD KEY `data_entry` (`data_entry`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD UNIQUE KEY `exam_no` (`exam_no`,`subject_code`,`session`) USING BTREE,
  ADD KEY `status` (`status`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `sen` (`sen`),
  ADD KEY `date_entered` (`date_entered`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `marks_audit_trail`
--
ALTER TABLE `marks_audit_trail`
  ADD KEY `status` (`status`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `sen` (`sen`),
  ADD KEY `date_entered` (`date_entered`),
  ADD KEY `action` (`action`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`centre_code`),
  ADD UNIQUE KEY `centre_code_2` (`centre_code`,`session`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `session` (`session`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level` (`level`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `subject_code_2` (`subject_code`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `max_mark` (`max_mark`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_2` (`id`),
  ADD KEY `activation_status` (`activation_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apportionment`
--
ALTER TABLE `apportionment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `apportionment_temp`
--
ALTER TABLE `apportionment_temp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `examiner`
--
ALTER TABLE `examiner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `marking_centre`
--
ALTER TABLE `marking_centre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `marking_rates`
--
ALTER TABLE `marking_rates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apportionment`
--
ALTER TABLE `apportionment`
  ADD CONSTRAINT `apportionment_ibfk_1` FOREIGN KEY (`group_apportion_id`) REFERENCES `group_apportion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `apportionment_ibfk_2` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `centre`
--
ALTER TABLE `centre`
  ADD CONSTRAINT `centre_ibfk_1` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `course_group` (`group_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examiner`
--
ALTER TABLE `examiner`
  ADD CONSTRAINT `examiner_ibfk_3` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_apportion`
--
ALTER TABLE `group_apportion`
  ADD CONSTRAINT `group_apportion_ibfk_1` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marking_centre`
--
ALTER TABLE `marking_centre`
  ADD CONSTRAINT `marking_centre_ibfk_1` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
