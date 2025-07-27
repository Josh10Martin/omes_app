-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2025 at 02:25 PM
-- Server version: 8.0.36
-- PHP Version: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omes_9`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_apportion_summary` (IN `apportion_id` INT, IN `province_code` VARCHAR(2), IN `session_type` VARCHAR(1))   BEGIN
INSERT IGNORE INTO apportionment_summary(apportion_id,marking_centre,marking_centre_name,subject_name,d_name,no_of_centres,province)
SELECT (SELECT DISTINCT apportion_id FROM marks_prep WHERE apportion_id = apportion_id) AS apportion_id, ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name,CASE WHEN COUNT(DISTINCT(su.subject_name)) = (SELECT COUNT(subject_code) FROM subjects) THEN "ALL SUBJECTS" ELSE GROUP_CONCAT( DISTINCT(su.subject_name) ORDER BY su.subject_code ASC SEPARATOR ", ") END AS subjects,
CASE WHEN COUNT(DISTINCT(d.d_name)) = (SELECT COUNT(d_code) FROM district WHERE p_code = province_code) THEN "ALL DISTRICTS" ELSE GROUP_CONCAT(DISTINCT(d.d_name) ORDER BY d.d_code ASC SEPARATOR ", ") END AS districts, 
 COUNT(DISTINCT(mp.centre_code)) AS no_of_centres, mp.province AS province
FROM centre ce LEFT OUTER JOIN marks_prep mp ON (ce.centre_code = mp.marking_centre)
INNER JOIN subjects su ON (mp.subject_code = su.subject_code)
INNER JOIN school sc ON (mp.centre_code = sc.centre_code)
INNER JOIN district d ON (sc.district = d.d_code)
WHERE sc.province = mp.province
AND mp.province = d.p_code
AND ce.province = mp.province
AND ce.centre_type = session_type
AND mp.province = province_code
AND mp.apportion_id = (SELECT MAX(apportion_id) FROM marks_prep WHERE province = province_code)
GROUP BY ce.centre_code,ce.name,mp.apportion_id,mp.province;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_apportion_summary_sen` (IN `apportion_id` INT, IN `province_code` VARCHAR(8), IN `session_type` VARCHAR(1))   BEGIN
REPLACE INTO apportionment_summary(apportion_id,marking_centre,marking_centre_name,subject_name,d_name,no_of_centres,province)
SELECT (SELECT DISTINCT apportion_id FROM marks_prep WHERE apportion_id = apportion_id) AS apportion_id, ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name,CASE WHEN mp.sen ="1" THEN "ALL SEN SUBJECTS"  WHEN COUNT(DISTINCT(su.subject_name)) = (SELECT COUNT(subject_code) FROM subjects) THEN "ALL SUBJECTS" ELSE GROUP_CONCAT( DISTINCT(su.subject_name) ORDER BY su.subject_code ASC SEPARATOR ", ") END AS subjects,
CASE WHEN mp.sen ="1" THEN "ALL DISTRICTS" WHEN COUNT(DISTINCT(d.d_name)) = (SELECT COUNT(d_code) FROM district WHERE p_code = province_code) THEN "ALL DISTRICTS" ELSE GROUP_CONCAT(DISTINCT(d.d_name) ORDER BY d.d_code ASC SEPARATOR ", ") END AS districts, 
 "ALL CENTRES" AS no_of_centres, mp.province AS province
FROM centre ce INNER JOIN marks_prep mp ON (ce.centre_code = mp.marking_centre)
INNER JOIN subjects su ON (mp.subject_code = su.subject_code)
INNER JOIN school sc ON (mp.province = sc.province)
INNER JOIN district d ON (sc.province = d.p_code)
WHERE sc.province = mp.province
AND mp.province = d.p_code
AND ce.province = mp.province
AND ce.centre_type = session_type
AND mp.province = province_code
AND mp.apportion_id = (SELECT MAX(apportion_id) FROM marks_prep WHERE province = province_code)
GROUP BY ce.centre_code,ce.name,mp.apportion_id,mp.sen,mp.province;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_apportion_summary_update` (IN `province_code` VARCHAR(2), IN `session_type` VARCHAR(1))   BEGIN
INSERT IGNORE INTO apportionment_summary(apportion_id,marking_centre,marking_centre_name,subject_name,d_name,no_of_centres,province, valid)
SELECT mp.apportion_id AS apportion_id, ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name,CASE WHEN COUNT(DISTINCT(su.subject_name)) = (SELECT COUNT(subject_code) FROM subjects) THEN "ALL SUBJECTS" ELSE GROUP_CONCAT( DISTINCT(su.subject_name) ORDER BY su.subject_code ASC SEPARATOR ", ") END AS subjects,
CASE WHEN COUNT(DISTINCT(d.d_name)) = (SELECT COUNT(d_code) FROM district WHERE p_code = province_code) THEN "ALL DISTRICTS" ELSE GROUP_CONCAT(DISTINCT(d.d_name) ORDER BY d.d_code ASC SEPARATOR ", ") END AS districts, 
 COUNT(DISTINCT(mp.centre_code)) AS no_of_centres, mp.province AS province, "1"
FROM centre ce LEFT OUTER JOIN marks_prep mp ON (ce.centre_code = mp.marking_centre)
INNER JOIN subjects su ON (mp.subject_code = su.subject_code)
INNER JOIN school sc ON (mp.centre_code = sc.centre_code)
INNER JOIN district d ON (sc.district = d.d_code)
WHERE sc.province = mp.province
AND mp.province = d.p_code
AND ce.province = mp.province
AND ce.centre_type = session_type
AND mp.province = province_code
GROUP BY ce.centre_code,ce.name,mp.apportion_id,mp.province;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `make_paper_1` (IN `nrc` VARCHAR(11))   BEGIN
update examiner set paper_no = 1 where nrc = nrc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `move_scripts` (IN `selected_belt` INT, IN `id` INT)   BEGIN
UPDATE apportionment_temp SET belt_no = selected_belt ,group_id = CONCAT(REVERSE(SUBSTRING(REVERSE(group_id),INSTR(REVERSE(group_id),'_'))),selected_belt) WHERE id IN(id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `paper_maintenance` (IN `nrc` VARCHAR(11), IN `tpin` VARCHAR(10), IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50), IN `phone` VARCHAR(10), IN `email` VARCHAR(50), IN `address` TEXT, IN `title` VARCHAR(10), IN `role` VARCHAR(10), IN `belt_no` INT, IN `attendance` INT, IN `no_of_days` VARCHAR(50), IN `marking_centre` VARCHAR(10), IN `province_code` VARCHAR(2), IN `subject_code` VARCHAR(5), IN `paper_no` INT, IN `branch` VARCHAR(100), IN `account_no` VARCHAR(15), IN `session` VARCHAR(10))   BEGIN
INSERT IGNORE INTO examiner (nrc,tpin,first_name,last_name,phone_number,email,address,title,role,belt_no,attendance,no_of_days,marking_centre,province,subject_code,paper_no,branch,account_no,session)
                          VALUES(nrc,tpin,first_name,last_name,phone,email,address,title,role,belt_no,attendance,no_of_days,marking_centre,province_code,subject_code,paper_no,branch,account_no,session);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `remove_row_from_examiner` (IN `nrc` VARCHAR(11))   BEGIN
delete e1 from examiner e1 inner join examiner e2 where e1.id < e2.id and e1.nrc = e2.nrc and e1.nrc = nrc;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `apportionment`
--

CREATE TABLE `apportionment` (
  `id` int NOT NULL,
  `school` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_no` int NOT NULL DEFAULT '0',
  `group_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper` int NOT NULL,
  `belt_no` int NOT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_apportioned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `apportionment`
--
DELIMITER $$
CREATE TRIGGER `update_total_apportionment_after_delete` AFTER DELETE ON `apportionment` FOR EACH ROW UPDATE group_apportion
    SET no_of_centres = (SELECT COUNT(*) FROM apportionment WHERE group_id = OLD.group_id),
        no_of_scripts = no_of_scripts - OLD.script_no
    WHERE id = OLD.group_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_apportionment_after_insert` AFTER INSERT ON `apportionment` FOR EACH ROW UPDATE group_apportion 
    SET no_of_centres = (SELECT COUNT(*) FROM apportionment WHERE group_id = NEW.group_id),
        no_of_scripts = no_of_scripts + NEW.script_no 
    WHERE id = NEW.group_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_apportionment_after_update` AFTER UPDATE ON `apportionment` FOR EACH ROW UPDATE group_apportion 
    SET no_of_scripts = no_of_scripts - OLD.script_no + NEW.script_no
    WHERE id = NEW.group_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `apportionment_summary`
--

CREATE TABLE `apportionment_summary` (
  `id` int NOT NULL,
  `apportion_id` int NOT NULL,
  `marking_centre` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `subject_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `d_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_centres` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apportionment_temp`
--

CREATE TABLE `apportionment_temp` (
  `id` int NOT NULL,
  `school` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_no` int NOT NULL DEFAULT '0',
  `group_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper` int NOT NULL,
  `belt_no` int NOT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_apportioned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `name`) VALUES
(0, 'NOT PRESENT'),
(1, 'PRESENT');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`) VALUES
(1, 'BANK OF ZAMBIA'),
(2, 'ZANACO'),
(3, 'ABSA'),
(4, 'CITIBANK ZAMBIA LTD'),
(5, 'STANBIC BANK ZAMBIA LTD'),
(6, 'STANDARD CHARTERED BANK'),
(7, 'INDO ZAMBIA BANK LTD'),
(13, 'BANK OF CHINA (ZAMBIA) LTD'),
(14, 'BANCABC ZAMBIA LTD'),
(15, 'AB BANK ZAMBIA LIMITED'),
(16, 'FIRST NATIONAL BANK ZAMBIA LIMITED'),
(17, 'FIRST CAPITALBANK  ZAMBIA LIMITED'),
(18, 'FIRST ALLIANCE BANK ZAMBIA LTD'),
(19, 'ACCESS BANK ZAMBIA LIMITED'),
(20, 'ECOBANK ZAMBIA LIMITED'),
(23, 'UNITED BANK FOR AFRICA'),
(24, 'ZAMBIA NATIONAL BUILDING SOCIETY'),
(25, 'BAYPORT FINANCIAL'),
(26, 'NATSAVE BANK'),
(27, 'ATLAS MARA ZAMBIA'),
(28, 'ZICB');

-- --------------------------------------------------------

--
-- Table structure for table `bankbranch`
--

CREATE TABLE `bankbranch` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bankbranch`
--

INSERT INTO `bankbranch` (`id`, `name`, `sortcode`, `bank_id`) VALUES
(1, 'Lusaka', '000001', 1),
(2, 'Ndola', '000102', 1),
(3, 'Acacia Park Branch', '010086', 2),
(4, 'Cairo Business Centre', '010040', 2),
(6, 'Chingola', '010349', 2),
(8, 'Chinsali Branch', '011707', 2),
(10, 'Chipata', '011160', 2),
(12, 'Chirundu', '013582', 2),
(13, 'Chisamba', '014508', 2),
(15, 'Choma', '011259', 2),
(17, 'Debt Recovery', '010055', 2),
(19, 'Digital', '010093', 2),
(21, 'Government Business Centre', '010050', 2),
(23, 'Government Complex', '010084', 2),
(25, 'Head Office', '010001', 2),
(27, 'Head Office Processing Centre', '010016', 2),
(29, 'Human Resources', '010007', 2),
(31, 'International Banking', '010002', 2),
(35, 'Kabwe', '010946', 2),
(38, 'Itezhi-Tezhi', '014779', 2),
(39, 'Kapiri Mposhi', '012461', 2),
(41, 'Kasama', '010862', 2),
(42, 'Kafue', '013458', 2),
(43, 'Kawambwa', '012104', 2),
(45, 'Kitwe Clearing Centre', '010217', 2),
(47, 'Kitwe Industrial', '010256', 2),
(49, 'Kitwe Obote', '010245', 2),
(51, 'Livingstone', '011044', 2),
(53, 'Luanshya', '010763', 2),
(55, 'Lundazi', '012571', 2),
(57, 'Lusaka Business Centre', '010003', 2),
(59, 'Lusaka Centre', '010052', 2),
(61, 'Lusaka City Market', '010074', 2),
(63, 'Lusaka Civic Centre', '010067', 2),
(65, 'Lusaka Kwacha', '010053', 2),
(67, 'Lusaka North end', '010041', 2),
(69, 'Lusaka Premium House', '010066', 2),
(73, 'Manda Hill', '010078', 2),
(75, 'Mansa', '011948', 2),
(76, 'Maamba', '014070', 2),
(77, 'Mazabuka', '013647', 2),
(81, 'Mkushi', '012309', 2),
(84, 'Mfuwe', '012606', 2),
(86, 'Monze', '013757', 2),
(87, 'Mongu', '013151', 2),
(88, 'Mpika', '011865', 2),
(90, 'Mufulira', '010543', 2),
(92, 'Mukuba branch', '010298', 2),
(94, 'Nakonde', '011596', 2),
(98, 'Ndola Business Centre', '010142', 2),
(99, 'Namwala', '013372', 2),
(100, 'Ndola Industrial', '010164', 2),
(102, 'Ndola West', '010154', 2),
(104, 'North mead', '010075', 2),
(108, 'Senanga', '015181', 2),
(109, 'Petauke', '014305', 2),
(110, 'Siavonga', '013869', 2),
(112, 'Solwezi', '012868', 2),
(114, 'Treasury', '010018', 2),
(116, 'Twin Palms Mall', '010073', 2),
(118, 'Waterfalls', '010099', 2),
(120, 'Woodlands', '010085', 2),
(122, 'Xapit', '010083', 2),
(125, 'Chambishi', '025247', 3),
(126, 'Chilenje', '020018', 3),
(127, 'Chililabombwe', '020453', 3),
(128, 'Chingola & Chingola Prestige', '020303', 3),
(129, 'Chipata', '021104', 3),
(130, 'Chirundu', '023542', 3),
(131, 'Choma', '021205', 3),
(132, 'Chongwe', '024637', 3),
(133, 'Elunda Premium Banking Centre', '020055', 3),
(134, 'Head Office', '020001', 3),
(135, 'Head Office -Elunda', '020002', 3),
(136, 'Kabwata', '020043', 3),
(137, 'Kabwe', '020906', 3),
(138, 'Kafue', '023407', 3),
(139, 'Kalomo', '024127', 3),
(140, 'Kalulushi', '020648', 3),
(141, 'Kapiri Mposhi', '022411', 3),
(142, 'Kasama', '020832', 3),
(143, 'Katete', '024928', 3),
(144, 'Kitwe Business Centre', '020209', 3),
(145, 'Kitwe Chimwemwe', '020210', 3),
(146, 'Kitwe Operations Processing Centre', '020252', 3),
(147, 'Kitwe Parklands Center', '020241', 3),
(148, 'Livingstone & Livingstone Prestige', '021012', 3),
(149, 'Luanshya', '020713', 3),
(150, 'Lundazi', '022531', 3),
(151, 'Lusaka - Chawama', '020044', 3),
(152, 'Lusaka - Industrial', '020019', 3),
(153, 'Lusaka - Kamwala', '020008', 3),
(154, 'Lusaka - Matero', '020015', 3),
(155, 'Lusaka - Soweto', '020033', 3),
(156, 'Lusaka Business Centre', '020016', 3),
(157, 'Lusaka Chelston &  Airport Agency', '020036', 3),
(158, 'Lusaka Kabelenga', '020054', 3),
(159, 'Lusaka Longacres & Prestige', '020017', 3),
(160, 'Lusaka Northend', '020014', 3),
(161, 'Lusaka Operations Processing Centre', '020050', 3),
(162, 'Manda Hill', '020049', 3),
(163, 'Mansa', '021920', 3),
(164, 'Mazabuka', '023621', 3),
(165, 'Mbala', '021451', 3),
(166, 'Mfuwe', '022622', 3),
(167, 'Mkushi', '022338', 3),
(168, 'Mongu', '023135', 3),
(169, 'Monze', '023724', 3),
(170, 'Mpika', '021845', 3),
(171, 'Mufulira', '020523', 3),
(172, 'Mumbwa', '025334', 3),
(173, 'Nakonde', '021540', 3),
(174, 'Ndola - Masala', '020146', 3),
(175, 'Ndola Business Centre', '020125', 3),
(176, 'Ndola Operations Processing Centre', '020139', 3),
(177, 'Petauke', '024330', 3),
(178, 'Solwezi', '022829', 3),
(179, 'University of Zambia Lusaka', '020026', 3),
(180, 'Chililabobwe', '030469', 4),
(181, 'Chingola', '030366', 4),
(182, 'Chingola', '030965', 4),
(183, 'Chipata', '031149', 4),
(184, 'Choma', '031264', 4),
(185, 'Kapiri Mposhi', '032487', 4),
(186, 'Kasama', '030846', 4),
(187, 'Kitwe', '030238', 4),
(188, 'Livingstone', '031050', 4),
(189, 'Luanshya', '030767', 4),
(190, 'Lusaka', '030001', 4),
(191, 'Mansa', '031970', 4),
(192, 'Mazabuka', '033673', 4),
(193, 'MCommerce', '030003', 4),
(194, 'Mongu', '033172', 4),
(195, 'Mpika', '031874', 4),
(196, 'Mufulira', '030568', 4),
(197, 'Natsave', '030007', 4),
(198, 'Ndola', '030102', 4),
(199, 'Ndola Branch', '030137', 4),
(200, 'Nyimba', '035434', 4),
(201, 'Permanent House', '030031', 4),
(202, 'Society House', '030032', 4),
(203, 'Solwezi', '032871', 4),
(204, 'Soweto Agency', '030033', 4),
(205, 'ZNBS Branch', '030008', 4),
(206, 'Arcades', '040010', 5),
(208, 'Chingola', '040309', 5),
(209, 'Chipata', '041116', 5),
(210, 'Chisokone', '040224', 5),
(211, 'Choma', '041218', 5),
(212, 'Cosmopolitan Mall', '040093', 5),
(213, 'East Park Mall', '040094', 5),
(214, 'Head Office', '040000', 5),
(215, 'Kabulonga', '040029', 5),
(216, 'Kabwata', '040026', 5),
(217, 'Kabwe', '040922', 5),
(218, 'Kafubu Mall', '040195', 5),
(219, 'Kafue Branch', '043419', 5),
(220, 'Kitwe', '040206', 5),
(221, 'Livingstone', '041017', 5),
(222, 'Lumwana', '044821', 5),
(223, 'Lusaka', '040002', 5),
(224, 'Lusaka Industrial', '040007', 5),
(225, 'Matero', '040011', 5),
(226, 'Mazabuka', '043613', 5),
(227, 'Mkushi', '042308', 5),
(228, 'Mufulira', '040514', 5),
(229, 'Mukuba Mall', '040296', 5),
(230, 'Mulungushi', '040015', 5),
(231, 'Ndola Main', '040103', 5),
(232, 'Ndola South', '040105', 5),
(233, 'Operations Shared Services', '040104', 5),
(234, 'Private Banking', '040027', 5),
(235, 'Solwezi', '042812', 5),
(236, 'Soweto', '040023', 5),
(237, 'Waterfall', '040039', 5),
(238, 'Woodlands', '040030', 5),
(239, 'Chandwe Musonda', '090016', 7),
(240, 'Chawama', '090013', 7),
(241, 'Chilanga', '090003', 7),
(242, 'Chilenje Branch', '090028', 7),
(243, 'Chingola', '090309', 7),
(244, 'Chinsali', '091721', 7),
(245, 'Chipata', '091112', 7),
(246, 'Choma Branch', '091218', 7),
(247, 'Copperhill', '090225', 7),
(248, 'Crossroads', '090023', 7),
(249, 'Head Office', '090000', 7),
(250, 'Jacaranda Mall', '090122', 7),
(251, 'Kabwe', '090906', 7),
(252, 'Kafue Branch', '093427', 7),
(253, 'Kamwala', '090004', 7),
(254, 'Kasama', '090820', 7),
(255, 'Kasumbalesa Branch', '090417', 7),
(256, 'Kitwe', '090208', 7),
(257, 'Livingstone', '091010', 7),
(258, 'Lundazi Agency', '092531', 7),
(259, 'Lusaka Industrial', '090011', 7),
(260, 'Lusaka Main', '090001', 7),
(261, 'Manda Hill Branch', '090014', 7),
(262, 'Mansa', '091924', 7),
(263, 'Mongu', '093126', 7),
(264, 'Mungwi Agency', '095632', 7),
(265, 'Ndola', '090107', 7),
(266, 'North end', '090005', 7),
(267, 'Nyimba Branch', '095415', 7),
(268, 'Serenje Branch', '092230', 7),
(269, 'Solwezi', '092819', 7),
(270, 'Zimba Branch', '094229', 7),
(271, 'Buteko', '060171', 6),
(272, 'Chililabombwe', '060444', 6),
(273, 'Chingola', '060336', 6),
(274, 'Choma', '061237', 6),
(275, 'Cross Roads', '060015', 6),
(276, 'Customer Services Centre', '060002', 6),
(277, 'Financial Control', '060011', 6),
(278, 'Jacaranda Mall Branch', '060120', 6),
(279, 'Kabulonga', '060014', 6),
(280, 'Kasama', '060813', 6),
(281, 'Levy Park Branch', '060021', 6),
(282, 'Livingstone', '061018', 6),
(283, 'Luanshya', '060732', 6),
(284, 'Lusaka Main', '060017', 6),
(285, 'Manda Hill', '060030', 6),
(286, 'Mazabuka', '063619', 6),
(287, 'Mongu', '063148', 6),
(288, 'North end', '060043', 6),
(289, 'Solwezi', '062816', 6),
(290, 'Zambia Way', '060228', 6),
(334, 'Kitwe', '190202', 13),
(335, 'Lusaka', '190001', 13),
(336, 'Arcades', '200009', 14),
(337, 'Arcades', '200046', 14),
(338, 'Chililabombwe', '200443', 14),
(339, 'Chingola', '200315', 14),
(340, 'Chinsali', '201728', 14),
(341, 'Chipata', '201108', 14),
(342, 'Chirundu', '203514', 14),
(343, 'Choma', '201205', 14),
(344, 'Chongwe', '204638', 14),
(345, 'Down Town', '200032', 14),
(346, 'East Park Mall', '200050', 14),
(347, 'Head Office', '200000', 14),
(348, 'Industrial', '200033', 14),
(349, 'Isoka', '201627', 14),
(350, 'Kabompo', '202919', 14),
(351, 'Kabwe', '200925', 14),
(352, 'Kafubu Mall', '200149', 14),
(353, 'Kalomo', '204110', 14),
(354, 'Kamwala', '200007', 14),
(355, 'Kaoma', '204430', 14),
(356, 'Kasama', '200804', 14),
(357, 'Kasumbalesa', '200434', 14),
(358, 'Katete', '201116', 14),
(359, 'Kitwe', '200203', 14),
(360, 'Livingstone', '201023', 14),
(361, 'Livonia', '200054', 14),
(362, 'Longacres', '200006', 14),
(363, 'Luanshya', '200731', 14),
(364, 'Lundazi', '202541', 14),
(365, 'Lusaka Main', '200001', 14),
(366, 'Mansa', '201942', 14),
(367, 'Mbala', '201421', 14),
(368, 'Mongu', '203145', 14),
(369, 'Monze', '203724', 14),
(370, 'Mpika', '201826', 14),
(371, 'Mpulungu', '201329', 14),
(372, 'Mufulira', '200513', 14),
(373, 'Mukuba Mall', '200251', 14),
(374, 'Mumbwa', '205339', 14),
(375, 'Mwinilunga', '202718', 14),
(376, 'Nakonde', '201520', 14),
(377, 'Ndola', '200102', 14),
(378, 'Nyumba Yanga', '200036', 14),
(379, 'Pyramid Plaza', '200044', 14),
(380, 'Samfya', '202012', 14),
(381, 'Serenje', '202211', 14),
(382, 'Sesheke', '203217', 14),
(383, 'Sinazeze', '201247', 14),
(384, 'Solwezi', '202822', 14),
(385, 'Tenga', '200053', 14),
(386, 'UTH', '200052', 14),
(387, 'Zambezi', '203056', 14),
(388, 'Cairo Road Branch', '210001', 15),
(389, 'Chelston Branch', '210005', 15),
(390, 'Chilenje Branch', '210002', 15),
(391, 'Garden Branch', '210006', 15),
(392, 'Head Office', '210000', 15),
(393, 'Kalingalinga Branch', '210004', 15),
(394, 'Kitwe', '210207', 15),
(395, 'Matero', '210003', 15),
(396, 'Ndola', '210108', 15),
(397, 'Agriculture Center', '260040', 16),
(398, 'Branchless Banking', '260025', 16),
(399, 'Cairo Road Branch', '260050', 16),
(400, 'Cash centre', '260048', 16),
(401, 'Chilenje Branch', '260046', 16),
(402, 'Chingola', '260322', 16),
(403, 'Chipata', '261121', 16),
(404, 'Choma Branch', '261238', 16),
(405, 'CIB (Corporate)', '260029', 16),
(406, 'Commercial Suite Lusaka', '260001', 16),
(407, 'Corporate Investment Banking', '260042', 16),
(408, 'Electronic Banking Branch', '260006', 16),
(409, 'Electronic Wallet', '260027', 16),
(410, 'FNB Operations', '260004', 16),
(411, 'Government and Public Sector', '260036', 16),
(412, 'Head Office Lusaka', '260005', 16),
(413, 'Homes Loans', '260020', 16),
(414, 'Industrial  Branch', '260002', 16),
(415, 'Jacaranda Mall', '260118', 16),
(416, 'Kabulonga Branch', '260072', 16),
(417, 'Kabwe Branch', '260937', 16),
(418, 'Kalumbila Branch', '262827', 16),
(419, 'Kitwe', '260212', 16),
(420, 'Kitwe Industrial', '260247', 16),
(421, 'Kitwe Private Suite', '260261', 16),
(422, 'Livingstone Branch', '261061', 16),
(423, 'Luanshya', '260741', 16),
(424, 'Lusaka Private Suite', '260061', 16),
(425, 'Makeni Mall', '260016', 16),
(426, 'Manda Hill', '260014', 16),
(427, 'Mazabuka', '263613', 16),
(428, 'Mkushi', '262319', 16),
(429, 'Mufulira Branch', '260544', 16),
(430, 'Mukuba Mall Branch', '260243', 16),
(431, 'Ndola Branch', '260103', 16),
(432, 'PHI Branch', '260049', 16),
(433, 'POS - FNB', '260033', 16),
(434, 'POS - MasterCard', '260032', 16),
(435, 'POS-Visa', '260031', 16),
(436, 'Premier Banking', '260039', 16),
(437, 'Solwezi', '262823', 16),
(438, 'Treasury Branch', '260011', 16),
(439, 'Vehicle and Asset Finance', '260015', 16),
(440, 'Cairo Branch', '280002', 17),
(441, 'Head Office', '280000', 17),
(442, 'Industrial Branch', '280001', 17),
(443, 'Kamwala Branch', '280006', 17),
(444, 'Kitwe Branch', '280207', 17),
(445, 'Lusaka Main', '280003', 17),
(446, 'Makeni Branch', '280004', 17),
(447, 'Ndola Branch', '280105', 17),
(448, 'East Park Branch', '340007', 18),
(449, 'Industrial Branch', '340006', 18),
(450, 'Kitwe', '340204', 18),
(451, 'Lusaka Head Office', '340005', 18),
(452, 'Lusaka Main', '340001', 18),
(453, 'Ndola', '340103', 18),
(454, 'Acacia', '350003', 19),
(455, 'Cairo Road', '350001', 19),
(456, 'Chililabombwe', '350409', 19),
(457, 'Chingola', '350310', 19),
(458, 'Chipata', '351611', 19),
(459, 'Garden', '350012', 19),
(460, 'Head Office', '350000', 19),
(461, 'Kalingalinga', '350013', 19),
(462, 'Kasama', '350814', 19),
(463, 'Kitwe', '350205', 19),
(464, 'Longacres', '350002', 19),
(465, 'Lusaka Square', '350008', 19),
(466, 'Makeni', '350006', 19),
(467, 'Mansa', '351915', 19),
(468, 'Mbala', '351416', 19),
(469, 'Mufumbwe', '352817', 19),
(470, 'Ndola', '350104', 19),
(471, 'Solwezi', '352807', 19),
(472, 'Tazara', '350018', 19),
(473, 'Cairo Road', '360003', 20),
(474, 'Chibombo', '365506', 20),
(475, 'Copperbelt University', '360208', 20),
(476, 'Head Office', '360001', 20),
(477, 'Industrial Branch', '360007', 20),
(478, 'Kitwe', '360205', 20),
(479, 'Lumumba Branch', '360010', 20),
(480, 'Mazabuka Branch', '363611', 20),
(481, 'Ndola Branch', '360109', 20),
(482, 'Thabo Mbeki', '360002', 20),
(483, 'Woodlands', '360004', 20),
(484, 'Cairo', '370003', 23),
(485, 'Head Office', '370099', 23),
(486, 'Head Office  Branch', '370001', 23),
(487, 'Kamwala', '370002', 23),
(488, 'Kitwe', '370204', 23),
(489, 'Lewanika Branch', '370006', 23),
(490, 'Ndola', '370105', 23),
(491, 'Banking Society Business Park', '510019', 24),
(492, 'Chililabombwe', '510468', 24),
(493, 'Chingola', '510366', 24),
(494, 'Chipata', '511136', 24),
(495, 'Choma', '511235', 24),
(496, 'Cosmopolitan', '510042', 24),
(497, 'Kabwe', '510963', 24),
(498, 'Kapiri Mposhi', '512439', 24),
(499, 'Kasama', '510869', 24),
(500, 'Kitwe', '510264', 24),
(501, 'Livingstone', '511037', 24),
(502, 'Luanshya', '510767', 24),
(503, 'Mansa', '511970', 24),
(504, 'Mazabuka', '513638', 24),
(505, 'Mongu', '513134', 24),
(506, 'Mpika', '511872', 24),
(507, 'Mufulira', '510565', 24),
(508, 'Ndola', '510162', 24),
(509, 'Nyimba', '515441', 24),
(510, 'Permanent House', '510032', 24),
(511, 'Society House', '510031', 24),
(512, 'Solwezi', '512871', 24),
(513, 'Soweto', '510040', 24),
(514, 'Chingola', '550307', 25),
(515, 'Chipata', '551112', 25),
(516, 'Head Office', '550099', 25),
(517, 'Heroes', '550003', 25),
(518, 'Kabwe', '550911', 25),
(519, 'Kafue', '553416', 25),
(520, 'Kasama', '550817', 25),
(521, 'Kitwe Branch', '550202', 25),
(522, 'Konkola', '550309', 25),
(523, 'Livingstone', '551019', 25),
(524, 'Luanshya', '550706', 25),
(525, 'Lusaka Business Centre', '550001', 25),
(526, 'Mansa', '551913', 25),
(527, 'Mazabuka', '553618', 25),
(528, 'Mongu', '553114', 25),
(529, 'Mpika', '551815', 25),
(530, 'Mufulira', '550508', 25),
(531, 'Ndola', '550105', 25),
(532, 'Solwezi', '552810', 25),
(533, 'UTH', '550004', 25),
(534, 'Chama', '585903', 26),
(535, 'Chavuma', '587740', 26),
(536, 'Chilenje', '580009', 26),
(537, 'Chilubi', '587033', 26),
(538, 'Chimwemwe', '580220', 26),
(539, 'Chinsali', '581739', 26),
(540, 'Chipata', '581104', 26),
(541, 'Choma', '581219', 26),
(542, 'Chongwe', '584605', 26),
(543, 'Cosmopolitan', '580008', 26),
(544, 'Credit Centre', '580002', 26),
(545, 'Head Office', '580001', 26),
(546, 'Kabwe', '580906', 26),
(547, 'Kalabo', '584817', 26),
(548, 'Kaputa', '586721', 26),
(549, 'Kasama', '580822', 26),
(550, 'Kasempa', '587223', 26),
(551, 'Kazungula', '587518', 26),
(552, 'Kitwe', '580224', 26),
(553, 'Livingstone', '581007', 26),
(554, 'Luanshya', '580725', 26),
(555, 'Lufwanyama', '585435', 26),
(556, 'Lukulu', '585116', 26),
(557, 'Lumwana', '582836', 26),
(558, 'Lusaka Main', '580010', 26),
(559, 'Luwingu', '586926', 26),
(560, 'Mansa', '581927', 26),
(561, 'Matero', '580011', 26),
(562, 'Mongu', '583113', 26),
(563, 'Mpika', '581837', 26),
(564, 'Mpongwe', '585634', 26),
(565, 'Mporokoso', '587128', 26),
(566, 'Mumbwa', '585214', 26),
(567, 'Mwense', '586338', 26),
(568, 'Nchelenge', '586529', 26),
(569, 'Ndola', '580130', 26),
(570, 'Northernd', '580012', 26),
(571, 'Petauke', '584315', 26),
(572, 'Solwezi', '582831', 26),
(573, 'Zambezi', '583032', 26),
(574, 'Head Office', '200000', 27),
(575, 'Lusaka Main', '200001', 27),
(576, 'Ndola', '200102', 27),
(577, 'Kitwe', '200203', 27),
(578, 'Kasama', '200804', 27),
(579, 'Choma', '201205', 27),
(580, 'Longacres', '200006', 27),
(581, 'Kamwala', '200007', 27),
(582, 'Chipata', '201108', 27),
(583, 'Arcades', '200009', 27),
(584, 'Kalomo', '204110', 27),
(585, 'Serenje', '202211', 27),
(586, 'Samfya', '202012', 27),
(587, 'Mufulira', '200513', 27),
(588, 'Chirundu', '203514', 27),
(589, 'Chingola', '200315', 27),
(590, 'Katete', '201116', 27),
(591, 'Sesheke', '203217', 27),
(592, 'Mwinilunga', '202718', 27),
(593, 'Kabompo', '202919', 27),
(594, 'Nakonde', '201520', 27),
(595, 'Mbala', '201421', 27),
(596, 'Solwezi', '202822', 27),
(597, 'Livingstone', '201023', 27),
(598, 'Monze', '203724', 27),
(599, 'Kabwe', '200925', 27),
(600, 'Mpika', '201826', 27),
(601, 'Isoka', '201627', 27),
(602, 'Chinsali', '201728', 27),
(603, 'Mpulungu', '201329', 27),
(604, 'Kaoma', '204430', 27),
(605, 'Luanshya', '200731', 27),
(606, 'Down Town', '200032', 27),
(607, 'Industrial', '200033', 27),
(608, 'Kasumbalesa', '200434', 27),
(609, 'Nyumba Yanga', '200036', 27),
(610, 'Chongwe', '204638', 27),
(611, 'Mumbwa', '205339', 27),
(612, 'Lundazi', '202541', 27),
(613, 'Mansa Branch', '201942', 27),
(614, 'Chililabombwe', '200443', 27),
(615, 'Pyramid Plaza', '200044', 27),
(616, 'Mongu', '203145', 27),
(617, 'Sinazeze', '201247', 27),
(618, 'Kafubu Mall', '200149', 27),
(619, 'East Park Mall', '200050', 27),
(620, 'Mukuba Mall', '200251', 27),
(621, 'UTH', '200052', 27),
(650, 'Longacres', '010010', 2),
(651, 'Mutaba', '020016', 3),
(652, 'Digital Banking', '140099', 28),
(653, 'Head Office', '140000', 28),
(654, 'Kitwe', '140202', 28),
(655, 'Livingstone Agency', '141005', 28),
(656, 'Lusaka Business Centre', '140001', 28),
(657, 'Ndola Branch', '140106', 28),
(658, 'PSPF Mall Branch', '140004', 28),
(659, 'Solwezi', '370001', 23);

-- --------------------------------------------------------

--
-- Table structure for table `centre`
--

CREATE TABLE `centre` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centre`
--

INSERT INTO `centre` (`centre_code`, `name`, `centre_type`, `province`) VALUES
('000000', 'NOT APPLICABLE', '0', '00'),
('MC-01', 'KASAMA GIRLS', 'E', '01'),
('MC-02', 'KASAMA GIRLS SECONDARY SCHOOL', 'I', '01'),
('MC-03', 'CHINSALI GIRLS SECONDARY SCHOOL', 'E', '10'),
('MC-04', 'CHINSALI GIRLS SECONDARY SCHOOL', 'I', '10'),
('MC-05', 'LUWINGU SECONDARY SCHOOL', 'I', '01'),
('MC-06', 'MPIKA BOYS SECONDARY SCHOOL', 'I', '10'),
('MC-07', 'MPOROKOSO SECONDARY SCHOOL', 'I', '01'),
('MC-08', 'ISOKA SECONDARY SCHOOL', 'I', '10'),
('MC-09', 'NAKONDE DAY SEC', 'I', '10'),
('MC-10', 'MBALA SECONDARY SCHOOL', 'I', '01'),
('MC-11', 'MUNGWI TECH SECONDARY SCHOOL', 'I', '01'),
('MC-12', 'KASAMA BOYS SECONDARY SCHOOL', 'I', '01'),
('MC-13', 'MPULUNGU BOARDING SECONDARY SCHOOL', 'I', '01'),
('MC-14', 'ST MARY\'S SECONDARY SCHOOL', 'I', '02'),
('MC-15', 'MANSA HIGH SCHOOL', 'E', '02'),
('MC-16', 'MANSA HIGH SCHOOL', 'I', '02'),
('MC-17', 'MABEL SHAW HIGH SCHOOL', 'I', '02'),
('MC-18', 'LUBWE HIGH SCHOOL', 'I', '02'),
('MC-19', 'ST CLEMENTS SECONDARY SCHOOL', 'I', '02'),
('MC-20', 'MWENSE HIGH SCHOOL', 'I', '02'),
('MC-21', 'SAMFYA HIGH SCHOOL', 'I', '02'),
('MC-22', 'CHOMA SECONDARY SCHOOL', 'E', '03'),
('MC-23', 'CHOMA SECONDARY SCHOOL', 'I', '03'),
('MC-24', 'MONZE SECONDARY SCHOOL', 'I', '03'),
('MC-25', 'ST EDMUNDS SECONDARY SCHOOL', 'I', '03'),
('MC-26', 'HILLCREST TECH HIGH SCHOOL', 'I', '03'),
('MC-27', 'KALOMO SECONDARY SCHOOL', 'I', '03'),
('MC-28', 'PEMBA SECONDARY SCHOOL', 'I', '03'),
('MC-29', 'CHIKANKATA SECONDARY SCHOOL', 'I', '03'),
('MC-30', 'NAMWALA SECONDARY SCHOOL', 'I', '03'),
('MC-31', 'MAAMBA SECONDARY SCHOOL', 'I', '03'),
('MC-32', 'CHASSA SEC. SCH.', 'I', '04'),
('MC-33', 'CHIPATA DAY SECONDARY SCHOOL', 'E', '04'),
('MC-34', 'CHIPATA DAY SEC.SCH.', 'I', '04'),
('MC-35', 'CHADIZA SEC. SCH.', 'I', '04'),
('MC-36', 'LUNDAZI SEC. SCH.', 'I', '04'),
('MC-37', 'PETAUKE SEC. SCH.', 'I', '04'),
('MC-38', 'CHAMA SEC. SCH.', 'I', '04'),
('MC-39', 'NYIMBA SEC. SCH.', 'I', '04'),
('MC-40', 'KATETE SEC. SCH.', 'I', '04'),
('MC-41', 'HILLSIDE SEC. SCH.', 'I', '04'),
('MC-42', 'MAMBWE SEC. SCH.', 'I', '04'),
('MC-43', 'CHINGOLA SEC. SCH', 'I', '05'),
('MC-44', 'HELLEN KAUNDA SEC ', 'I', '05'),
('MC-45', 'LUANSHYA GIRLS SECONDARY SCHOOL', 'E', '05'),
('MC-46', 'LUANSHYA GIRLS SEC.', 'I', '05'),
('MC-47', 'KANSENSHI SECONDARY SCHOOL', 'E', '05'),
('MC-48', 'KANSENSHI SECONDARY SCHOOL', 'I', '05'),
('MC-49', 'MASALA SECONDARY SCHOOL', 'I', '05'),
('MC-50', 'IBENGA GIRLS SEC. ', 'I', '05'),
('MC-51', 'MUKUBA SEC. SCH.', 'I', '05'),
('MC-52', 'MUFULIRA SEC. SCH.', 'I', '05'),
('MC-53', 'KALULUSHI SEC. SCH.', 'I', '05'),
('MC-54', 'CHILILABOMBWE SEC.', 'I', '05'),
('MC-55', 'SOLWEZI URBAN SECONDARY SCHOOL', 'E', '06'),
('MC-58', 'MUFUMBWE SECONDARY SCHOOL', 'I', '06'),
('MC-59', 'MWINILUNGA SECONDARY SCHOOL', 'I', '06'),
('MC-60', 'SOLWEZI TECHNICAL HIGH SCHOOL', 'I', '06'),
('MC-61', 'KYAWAMA SECONDARY SCHOOL', 'I', '06'),
('MC-62', 'ZAMBEZI SECONDARY SCHOOL', 'I', '06'),
('MC-63', 'MEHEBA', 'I', '06'),
('MC-64', 'MUTANDA SECONDARY SCHOOL', 'I', '06'),
('MC-65', 'IKELENGE DAY SECONDARY SCHOOL', 'I', '06'),
('MC-66', 'MANYINGA DAY SECONDARY SCHOOL', 'I', '06'),
('MC-67', 'MKUSHI SECONDARY SCHOOL', 'I', '07'),
('MC-68', 'MUMBWA SECONDARY SCHOOL', 'I', '07'),
('MC-69', 'SERENJE SECONDARY SCHOOL', 'I', '07'),
('MC-70', 'CHIBOMBO SECONDARY SCHOOL', 'I', '07'),
('MC-71', 'CHIPEMBI GIRLS SECONDARY SCHOOL', 'I', '07'),
('MC-72', 'BROADWAY BASIC SCHOOL', 'E', '07'),
('MC-73', 'BROADWAY SECONDARY SCHOOL', 'I', '07'),
('MC-74', 'LUKANDA BASIC SCHOOL', 'I', '07'),
('MC-76', 'LUKULU SECONDARY SCHOOL', 'I', '08'),
('MC-77', 'SENANGA SECONDARY SCHOOL', 'I', '08'),
('MC-78', 'KALABO SECONDARY SCHOOL', 'I', '08'),
('MC-79', 'SESHEKE SECONDARY SCHOOL', 'I', '08'),
('MC-80', 'ST JONES SECONDARY SCHOOL', 'E', '08'),
('MC-81', 'STJONES SECONDARY SCHOOL', 'I', '08'),
('MC-82', 'DAVID KAUNDA SECONDARY SCHOOL', 'I', '09'),
('MC-83', 'CHONGWE SECONDARY SCHOOL', 'I', '09'),
('MC-84', 'NABOYE SECONDARY SCHOOL', 'I', '09'),
('MC-85', 'LUSAKA BOYS SECONDARY SCHOOL', 'E', '09'),
('MC-86', 'LUANGWA SECONDARY SCHOOL', 'I', '09'),
('MC-87', 'KABULONGA SECONDARY SCHOOL', 'I', '09'),
('MC-88', 'MUNALI SECONDARY SCHOOL', 'I', '09'),
('MC-89', 'MATERO GIRLS SECONDARY SCHOOL', 'I', '09'),
('MC-90', 'KAMWALA SECONDARY SCHOOL', 'I', '09'),
('MC-91', 'LUSAKA GRZ SECONDARY SCHOOL', 'I', '09'),
('MC-92', 'PARKLANDS SECONDARY SCHOOL', 'I', '09'),
('MC-93', 'LIBALA SECONDARY SCHOOL', 'I', '09'),
('MC-94', 'KABOMPO SECONDARY SCHOOL', 'I', '06'),
('MC-95', 'KASEMPA SECONDARY SCHOOL', 'I', '06'),
('MC-96', 'ECZ HQ', 'E', '11'),
('MC-97', 'ECZ HQ', 'I', '11');

-- --------------------------------------------------------

--
-- Table structure for table `data_entry_claims`
--

CREATE TABLE `data_entry_claims` (
  `id` int NOT NULL,
  `marking_centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grossed_up_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `15_wht` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `d_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `d_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`d_code`, `d_name`, `p_code`) VALUES
('0000', 'NOT APPLICABLE', '00'),
('0101', 'CHILUBI', '01'),
('0104', 'KAPUTA', '01'),
('0105', 'KASAMA', '01'),
('0106', 'LUWINGU', '01'),
('0107', 'MBALA', '01'),
('0108', 'LUPOSOSHI', '01'),
('0109', 'MPOROKOSO', '01'),
('0111', 'MPULUNGU', '01'),
('0112', 'MUNGWI', '01'),
('0114', 'NSAMA', '01'),
('0116', 'SENGA', '01'),
('0117', 'LUNTE', '01'),
('0201', 'KAWAMBWA', '02'),
('0202', 'MANSA', '02'),
('0203', 'MWENSE', '02'),
('0204', 'NCHELENGE', '02'),
('0205', 'SAMFYA', '02'),
('0206', 'MILENGE', '02'),
('0207', 'CHIENGE', '02'),
('0208', 'CHIPILI', '02'),
('0209', 'LUNGA', '02'),
('0210', 'CHEMBE', '02'),
('0211', 'MWANSABOMBWE', '02'),
('0212', 'CHIFUNABULI', '02'),
('0301', 'CHOMA', '03'),
('0302', 'GWEMBE', '03'),
('0303', 'KALOMO', '03'),
('0304', 'LIVINGSTONE', '03'),
('0305', 'MAZABUKA', '03'),
('0306', 'MONZE', '03'),
('0307', 'NAMWALA', '03'),
('0308', 'SIAVONGA', '03'),
('0309', 'SINAZONGWE', '03'),
('0310', 'KAZUNGULA', '03'),
('0312', 'CHIKANKATA', '03'),
('0313', 'PEMBA', '03'),
('0314', 'ZIMBA', '03'),
('0401', 'CHADIZA', '04'),
('0403', 'CHIPATA', '04'),
('0404', 'KATETE', '04'),
('0405', 'LUNDAZI', '04'),
('0406', 'MAMBWE', '04'),
('0407', 'NYIMBA', '04'),
('0408', 'PETAUKE', '04'),
('0409', 'VUBWI', '04'),
('0410', 'SINDA', '04'),
('0411', 'LUSANGAZI', '04'),
('0412', 'CHASEFU', '04'),
('0413', 'LUMEZI', '04'),
('0414', 'CHIPANGALI', '04'),
('0415', 'KASENENGWA', '04'),
('0501', 'CHILILABOMBWE', '05'),
('0502', 'CHINGOLA', '05'),
('0503', 'KALULUSHI', '05'),
('0504', 'KITWE', '05'),
('0505', 'LUANSHYA', '05'),
('0506', 'MASAITI', '05'),
('0507', 'MUFULIRA', '05'),
('0508', 'NDOLA', '05'),
('0509', 'LUFWANYAMA', '05'),
('0510', 'MPONGWE', '05'),
('0601', 'CHAVUMA', '06'),
('0602', 'KABOMPO', '06'),
('0603', 'KASEMPA', '06'),
('0604', 'MUFUMBWE', '06'),
('0605', 'MWINILUNGA', '06'),
('0606', 'SOLWEZI', '06'),
('0607', 'ZAMBEZI', '06'),
('0608', 'IKELENGE', '06'),
('0609', 'MANYINGA', '06'),
('0610', 'KALUMBILA', '06'),
('0611', 'MUSHINDAMO', '06'),
('0701', 'CHIBOMBO', '07'),
('0702', 'KABWE', '07'),
('0703', 'KAPIRIMPOSHI', '07'),
('0704', 'MUMBWA', '07'),
('0705', 'MKUSHI', '07'),
('0706', 'SERENJE', '07'),
('0707', 'CHISAMBA', '07'),
('0708', 'CHITAMBO', '07'),
('0709', 'LUANO', '07'),
('0710', 'NGABWE', '07'),
('0711', 'ITEZHITEZHI', '03'),
('0712', 'SHIBUYUNJI', '07'),
('0801', 'KALABO', '08'),
('0802', 'KAOMA', '08'),
('0803', 'LUKULU', '08'),
('0804', 'MONGU', '08'),
('0805', 'SENANGA', '08'),
('0806', 'SESHEKE', '08'),
('0807', 'SHANGO\'MBO', '08'),
('0808', 'LIMULUNGA', '08'),
('0809', 'NKEYEMA', '08'),
('0810', 'LUAMPA', '08'),
('0811', 'NALOLO', '08'),
('0812', 'SIOMA', '08'),
('0813', 'MITETE', '08'),
('0814', 'MWANDI', '08'),
('0815', 'MULOBEZI', '08'),
('0816', 'SIKONGO', '08'),
('0901', 'CHONGWE', '09'),
('0902', 'KAFUE', '09'),
('0903', 'LUANGWA', '09'),
('0904', 'LUSAKA', '09'),
('0905', 'CHILANGA', '09'),
('0906', 'CHIRUNDU', '03'),
('0908', 'RUFUNSA', '09'),
('1001', 'CHAMA', '04'),
('1002', 'CHINSALI', '10'),
('1003', 'ISOKA', '10'),
('1004', 'MAFINGA', '10'),
('1005', 'MPIKA', '10'),
('1006', 'NAKONDE', '10'),
('1007', 'SHIWANG\'ANDU', '10'),
('1008', 'LAVUSHIMANDA', '10'),
('1009', 'KANCHIBIYA', '10'),
('5001', 'JOHANNESBURG', '50');

-- --------------------------------------------------------

--
-- Table structure for table `examiner`
--

CREATE TABLE `examiner` (
  `id` int NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `belt_no` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_days` int DEFAULT NULL,
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_no` int DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `attendance` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examiner_claim`
--

CREATE TABLE `examiner_claim` (
  `id` int NOT NULL,
  `marking_centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grossed_up_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `15_wht` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `belt_no` int NOT NULL,
  `session_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_apportion`
--

CREATE TABLE `group_apportion` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `belt_no` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_centres` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lun_trans`
--

CREATE TABLE `lun_trans` (
  `lunch` int NOT NULL DEFAULT '0',
  `transport` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lun_trans`
--

INSERT INTO `lun_trans` (`lunch`, `transport`) VALUES
(200, 100);

-- --------------------------------------------------------

--
-- Table structure for table `marking_centre`
--

CREATE TABLE `marking_centre` (
  `id` int NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper` int DEFAULT NULL,
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marking_centre_centres`
--

CREATE TABLE `marking_centre_centres` (
  `id` int NOT NULL,
  `apportion_id` int NOT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sen` int NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '00',
  `valid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marking_rates`
--

CREATE TABLE `marking_rates` (
  `id` int NOT NULL,
  `subject_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `chief_examiner` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deputy_c_examiner` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_leader` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `examiner` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `checker` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_entry` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_admin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transcriber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marking_rates`
--

INSERT INTO `marking_rates` (`id`, `subject_code`, `paper_no`, `chief_examiner`, `deputy_c_examiner`, `t_leader`, `examiner`, `checker`, `data_entry`, `sys_admin`, `transcriber`) VALUES
(2, '101', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(3, '204', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(4, '205', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(5, '207', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(6, '208', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(7, '301', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(8, '302', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(9, '303', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(10, '304', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(11, '305', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(12, '306', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(13, '307', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(14, '308', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(15, '309', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(16, '401', 1, '6', '5', '5', '3', '4.5', '0.25', '5', '5'),
(17, '402', 1, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(18, '501', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(19, '502', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(20, '601', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(21, '608', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(22, '609', 1, '6', '5', '5', '4', '4.5', '0.25', '5', '5'),
(23, '701', 1, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(33, '101', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(34, '301', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(35, '302', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(36, '303', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(37, '304', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(38, '306', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(39, '307', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(40, '308', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5'),
(41, '401', 2, '6', '5', '5', '3.5', '4.5', '0.25', '5', '5');

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
  `paper_no` int NOT NULL,
  `mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sen` int DEFAULT '0',
  `improvised_mark` int NOT NULL DEFAULT '0',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `marks`
--
DELIMITER $$
CREATE TRIGGER `marks_audit_trail_trigger` AFTER UPDATE ON `marks` FOR EACH ROW BEGIN
  IF OLD.marking_centre != 'none' AND OLD.province != '00' THEN
    INSERT INTO marks_audit_trail (
      centre_code,
      exam_no,
      subject_code,
      paper_no,
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
        province
    ) VALUES (
      NEW.centre_code,
      NEW.exam_no,
      NEW.subject_code,
      NEW.paper_no,
      CASE WHEN OLD.mark = 0 AND OLD.status ="L" THEN "" ELSE OLD.mark END,
        OLD.status,
      NEW.mark,
      NEW.status,
      NEW.sen,
      NEW.improvised_mark,
      NEW.entered_by,
      'UPDATE',
      NEW.date_entered,  -- You may need to adjust this based on your specific database's date/time functions
      NEW.marking_centre,
       NEW.province
    );
  END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `marks_audit_trail_trigger_insert_improvised` AFTER INSERT ON `marks` FOR EACH ROW BEGIN
IF NEW.status != "L" AND NEW.improvised_mark != 0 THEN
  INSERT INTO marks_audit_trail (
    centre_code,
    exam_no,
    subject_code,
    paper_no,
    old_mark,
    new_mark,
    status,
    sen,
    improvised_mark,
    entered_by,
    action,
    date_entered,
    marking_centre,
     province
  ) VALUES (
    NEW.centre_code,
    NEW.exam_no,
    NEW.subject_code,
    NEW.paper_no,
    "",
    NEW.mark,
    NEW.status,
    NEW.sen,
    NEW.improvised_mark,
    NEW.entered_by,
    'INSERT',
    NOW(), 
    NEW.marking_centre,
      NEW.province
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
  `paper_no` int NOT NULL,
  `old_mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sen` int NOT NULL,
  `improvised_mark` int NOT NULL DEFAULT '0',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks_prep`
--

CREATE TABLE `marks_prep` (
  `id` int NOT NULL DEFAULT '0',
  `apportion_id` int NOT NULL,
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `subject_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sen` int NOT NULL DEFAULT '0',
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks_temp`
--

CREATE TABLE `marks_temp` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sen` int DEFAULT '0',
  `improvised_mark` int NOT NULL DEFAULT '0',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paper`
--

CREATE TABLE `paper` (
  `id` int NOT NULL,
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `max_mark` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper`
--

INSERT INTO `paper` (`id`, `subject_code`, `paper_no`, `max_mark`) VALUES
(1, '101', 1, '40'),
(2, '101', 2, '60'),
(3, '204', 1, '110'),
(4, '205', 1, '40'),
(5, '207', 1, '100'),
(6, '208', 1, '60'),
(7, '301', 1, '40'),
(8, '301', 2, '60'),
(9, '302', 1, '40'),
(10, '302', 2, '60'),
(11, '303', 1, '40'),
(12, '303', 2, '60'),
(13, '304', 1, '40'),
(14, '304', 2, '60'),
(15, '305', 1, '60'),
(16, '306', 1, '40'),
(17, '306', 2, '60'),
(18, '307', 1, '40'),
(19, '307', 2, '60'),
(20, '308', 1, '40'),
(21, '308', 2, '60'),
(22, '309', 1, '60'),
(23, '401', 1, '50'),
(24, '401', 2, '50'),
(25, '402', 1, '70'),
(26, '501', 1, '100'),
(27, '502', 1, '80'),
(28, '601', 1, '100'),
(29, '608', 1, '155'),
(30, '609', 1, '100'),
(31, '701', 1, '70');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`) VALUES
('1', 'EXAMINER'),
('2', 'CHECKER'),
('3', 'TEAM LEADER'),
('4', 'DEPUTY CHIEF EXAMINER'),
('5', 'CHIEF EXAMINER');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `p_code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`p_code`, `p_name`) VALUES
('00', 'NOT APPLICABLE'),
('01', 'NORTHERN'),
('02', 'LUAPULA'),
('03', 'SOUTHERN'),
('04', 'EASTERN'),
('05', 'COPPERBELT'),
('06', 'NORTH-WESTERN'),
('07', 'CENTRAL'),
('08', 'WESTERN'),
('09', 'LUSAKA '),
('10', 'MUCHINGA'),
('13', 'EXAMINATIONS COUNCIL OF ZAMBIA'),
('50', 'SOUTH AFRICA');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00',
  `district` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_subject`
--

CREATE TABLE `school_subject` (
  `id` int NOT NULL,
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '9',
  `type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `name`, `year`, `level`, `type`) VALUES
('2024', 'JUNIOR SECONDARY SCHOOL LEAVING EXAMINATION', '2024', '9', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int NOT NULL,
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `subject_name`) VALUES
(1, '101', 'ENGLISH LANGUAGE'),
(2, '204', 'RELIGIOUS EDUCATION'),
(3, '205', 'ART AND DESIGN'),
(4, '207', 'SOCIAL STUDIES'),
(5, '208', 'MUSICAL ARTS EDUCATION'),
(6, '301', 'ICIBEMBA'),
(7, '302', 'CINYANJA'),
(8, '303', 'CHITONGA'),
(9, '304', 'SILOZI'),
(10, '305', 'FRENCH'),
(11, '306', 'KIIKAONDE'),
(12, '307', 'LUNDA'),
(13, '308', 'LUVALE'),
(14, '309', 'CHINESE LANGUAGE'),
(15, '401', 'MATHEMATICS'),
(16, '402', 'COMPUTER STUDIES'),
(17, '501', 'AGRICULTURAL SCIENCE'),
(18, '502', 'INTEGRATED SCIENCE'),
(19, '601', 'HOME ECONOMICS'),
(20, '608', 'DESIGN AND TECHNOLOGY'),
(21, '609', 'BUSINESS STUDIES'),
(22, '701', 'PHYSICAL EDUCATION');

-- --------------------------------------------------------

--
-- Table structure for table `system_admin_claims`
--

CREATE TABLE `system_admin_claims` (
  `id` int NOT NULL,
  `marking_centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `subject_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `belt_no` int NOT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `15_wht` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grossed_up_rate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transcriber`
--

CREATE TABLE `transcriber` (
  `id` int NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transcriber_script_no`
--

CREATE TABLE `transcriber_script_no` (
  `id` int NOT NULL,
  `no_of_scripts` int NOT NULL DEFAULT '0',
  `marking_centre` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `branch` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `account_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `province` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00',
  `marking_centre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `user_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_status` int NOT NULL,
  `login_status` int NOT NULL DEFAULT '1',
  `first_login` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `note` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `nrc`, `tpin`, `phone`, `branch`, `account_no`, `province`, `marking_centre`, `user_type`, `activation_status`, `login_status`, `first_login`, `note`) VALUES
(1, 'eczuser', 'ecz@gmail.com', '$2y$12$SMfT6.fkyo376.hErnXY6eTY3h07Tp/zeG8XuSV6H7WTWwyCPPWXu', 'JOSHUA', 'MBEWE', 'none', 'none', 'none', 'none', 'none', '00', '000000', 'ECZ', 1, 1, 'false', NULL);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `update_admin_apportionment` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
update apportionment set username = concat(new.username,' - ',new.first_name,' ',new.last_name) where LEFT(username,LOCATE(" ",username) -1) = new.username AND new.user_type = 'ADMIN';
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_data_entry_marks` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
update marks set entered_by = concat(new.username,' - ',new.first_name,' ',new.last_name) where LEFT(entered_by,LOCATE(" ",entered_by) -1) = new.username AND new.user_type = 'DEO';
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
  ADD UNIQUE KEY `school` (`school`,`subject`,`paper`,`province`,`marking_centre`) USING BTREE,
  ADD KEY `group_id` (`group_id`),
  ADD KEY `group_id_2` (`group_id`,`subject`,`paper`,`marking_centre`,`province`,`username`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `subject` (`subject`),
  ADD KEY `paper` (`paper`),
  ADD KEY `subject_2` (`subject`,`paper`,`belt_no`,`marking_centre`,`province`,`username`);

--
-- Indexes for table `apportionment_summary`
--
ALTER TABLE `apportionment_summary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `apportion_id` (`apportion_id`,`marking_centre`,`subject_name`,`province`);

--
-- Indexes for table `apportionment_temp`
--
ALTER TABLE `apportionment_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school` (`school`,`subject`,`paper`,`province`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `group_id_2` (`group_id`,`subject`,`paper`,`marking_centre`,`province`,`username`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `subject` (`subject`),
  ADD KEY `paper` (`paper`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `bankbranch`
--
ALTER TABLE `bankbranch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `id` (`id`,`bank_id`),
  ADD KEY `id_2` (`id`,`bank_id`);

--
-- Indexes for table `centre`
--
ALTER TABLE `centre`
  ADD PRIMARY KEY (`centre_code`),
  ADD KEY `province` (`province`),
  ADD KEY `centre_code` (`centre_code`,`province`),
  ADD KEY `centre_type` (`centre_type`);

--
-- Indexes for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrc` (`nrc`,`tpin`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`d_code`),
  ADD KEY `p_code` (`p_code`),
  ADD KEY `d_code` (`d_code`);

--
-- Indexes for table `examiner`
--
ALTER TABLE `examiner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrc` (`nrc`,`tpin`,`subject_code`,`paper_no`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `role` (`role`),
  ADD KEY `session` (`session`),
  ADD KEY `paper_no` (`paper_no`),
  ADD KEY `attendance` (`attendance`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `branch` (`branch`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `province` (`province`),
  ADD KEY `role_2` (`role`,`belt_no`,`attendance`,`marking_centre`,`province`,`subject_code`,`paper_no`,`branch`);

--
-- Indexes for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrc_2` (`nrc`,`tpin`,`subject_code`,`paper_no`);

--
-- Indexes for table `group_apportion`
--
ALTER TABLE `group_apportion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject`,`paper`,`marking_centre`,`province`),
  ADD KEY `id` (`id`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `subject_2` (`subject`,`paper`,`belt_no`,`marking_centre`,`province`,`username`);

--
-- Indexes for table `lun_trans`
--
ALTER TABLE `lun_trans`
  ADD UNIQUE KEY `lunch` (`lunch`,`transport`);

--
-- Indexes for table `marking_centre`
--
ALTER TABLE `marking_centre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `province_2` (`province`,`subject`,`centre_code`,`paper`) USING BTREE,
  ADD KEY `id` (`id`),
  ADD KEY `subject` (`subject`,`paper`),
  ADD KEY `province` (`province`),
  ADD KEY `centre_code` (`centre_code`);

--
-- Indexes for table `marking_centre_centres`
--
ALTER TABLE `marking_centre_centres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `centre_code_2` (`centre_code`,`subject_code`,`province`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `province` (`province`);

--
-- Indexes for table `marking_rates`
--
ALTER TABLE `marking_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examiner` (`examiner`),
  ADD KEY `chief_examiner` (`chief_examiner`,`deputy_c_examiner`,`t_leader`),
  ADD KEY `data_entry` (`data_entry`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `paper_no` (`paper_no`),
  ADD KEY `subject_code_2` (`subject_code`,`paper_no`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD UNIQUE KEY `exam_no` (`exam_no`,`subject_code`,`paper_no`),
  ADD KEY `status` (`status`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `province` (`province`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `subject_code` (`subject_code`,`paper_no`),
  ADD KEY `sen` (`sen`),
  ADD KEY `date_entered` (`date_entered`);

--
-- Indexes for table `marks_audit_trail`
--
ALTER TABLE `marks_audit_trail`
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `province` (`province`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `subject_code` (`subject_code`,`paper_no`),
  ADD KEY `date_entered` (`date_entered`),
  ADD KEY `action` (`action`),
  ADD KEY `exam_no` (`exam_no`),
  ADD KEY `paper_no` (`paper_no`);

--
-- Indexes for table `marks_prep`
--
ALTER TABLE `marks_prep`
  ADD KEY `centre_code` (`centre_code`,`subject_code`,`sen`,`marking_centre`,`province`),
  ADD KEY `apportion_id` (`apportion_id`,`centre_code`,`subject_code`,`sen`,`marking_centre`,`province`);

--
-- Indexes for table `marks_temp`
--
ALTER TABLE `marks_temp`
  ADD KEY `status` (`status`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `province` (`province`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `subject_code` (`subject_code`,`paper_no`),
  ADD KEY `sen` (`sen`),
  ADD KEY `date_entered` (`date_entered`);

--
-- Indexes for table `paper`
--
ALTER TABLE `paper`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `id` (`id`),
  ADD KEY `paper_no` (`paper_no`),
  ADD KEY `max_mark` (`max_mark`),
  ADD KEY `subject_code_2` (`subject_code`,`paper_no`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`p_code`),
  ADD KEY `p_code` (`p_code`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`centre_code`),
  ADD KEY `centre_code` (`centre_code`,`province`),
  ADD KEY `centre_type` (`centre_type`);

--
-- Indexes for table `school_subject`
--
ALTER TABLE `school_subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `centre_code` (`centre_code`,`subject_code`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level` (`level`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_code`),
  ADD UNIQUE KEY `subj_id_unq` (`id`),
  ADD KEY `subject_code` (`subject_code`);

--
-- Indexes for table `system_admin_claims`
--
ALTER TABLE `system_admin_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrc` (`nrc`),
  ADD UNIQUE KEY `tpin` (`tpin`);

--
-- Indexes for table `transcriber`
--
ALTER TABLE `transcriber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrc` (`nrc`,`tpin`),
  ADD KEY `role` (`role`),
  ADD KEY `session` (`session`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `branch` (`branch`),
  ADD KEY `province` (`province`),
  ADD KEY `role_2` (`role`,`marking_centre`,`province`,`branch`);

--
-- Indexes for table `transcriber_script_no`
--
ALTER TABLE `transcriber_script_no`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marking_centre` (`marking_centre`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `bank` (`branch`),
  ADD KEY `username` (`username`,`activation_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apportionment`
--
ALTER TABLE `apportionment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23108;

--
-- AUTO_INCREMENT for table `apportionment_summary`
--
ALTER TABLE `apportionment_summary`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apportionment_temp`
--
ALTER TABLE `apportionment_temp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examiner`
--
ALTER TABLE `examiner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marking_centre`
--
ALTER TABLE `marking_centre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marking_centre_centres`
--
ALTER TABLE `marking_centre_centres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marking_rates`
--
ALTER TABLE `marking_rates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `school_subject`
--
ALTER TABLE `school_subject`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `system_admin_claims`
--
ALTER TABLE `system_admin_claims`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transcriber`
--
ALTER TABLE `transcriber`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transcriber_script_no`
--
ALTER TABLE `transcriber_script_no`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apportionment`
--
ALTER TABLE `apportionment`
  ADD CONSTRAINT `apportionment_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group_apportion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bankbranch`
--
ALTER TABLE `bankbranch`
  ADD CONSTRAINT `bankbranch_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paper`
--
ALTER TABLE `paper`
  ADD CONSTRAINT `paper_ibfk_1` FOREIGN KEY (`subject_code`) REFERENCES `subjects` (`subject_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
