-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 14, 2025 at 05:29 PM
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
-- Database: `omes_12_gce`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `submit_examiner_claim` (IN `in_subject_code` VARCHAR(10), IN `in_subject_name` VARCHAR(255), IN `in_paper_no` VARCHAR(10), IN `in_rate_value` VARCHAR(30), IN `in_tax` DECIMAL(5,4), IN `in_session_year` VARCHAR(4), IN `in_session_name` VARCHAR(100), IN `in_marking_centre_code` VARCHAR(100), IN `in_marking_centre_name` VARCHAR(255))   BEGIN

    -- First part: CHIEF EXAMINER and DEPUTY
    REPLACE INTO examiner_claim (
        marking_centre_code, marking_centre_name, nrc, examiner_number, tpin, full_name,
        address, province, district, position, no_of_scripts, sortcode, account_no,
        net_rate, grossed_up_rate, gross_pay, 15_wht, net_pay, bank, branch,
        subject_code, subject_name, paper_no, belt_no, session,session_name
    )
    SELECT 
        in_marking_centre_code,
        in_marking_centre_name,
        ex.nrc,
        ex.examiner_number,
        ex.tpin,
        CONCAT(ex.first_name, ' ', ex.last_name),
        ex.address,
        ex.province,
        ex.district,
        ex.role,
        IF(h.no_of_scripts < 100, 100, h.no_of_scripts) / h.no_of_examiners,
        ex.sortcode,
        ex.account_no,
        CASE
            WHEN ex.role = 'CHIEF EXAMINER' THEN mr.chief_examiner
            ELSE mr.deputy_c_examiner
        END,
        CASE
            WHEN ex.role = 'CHIEF EXAMINER' THEN mr.chief_examiner * in_rate_value
            ELSE mr.deputy_c_examiner * in_rate_value
        END,
        (IF(h.no_of_scripts < 100, 100, h.no_of_scripts) / h.no_of_examiners) *
            (CASE
                WHEN ex.role = 'CHIEF EXAMINER' THEN mr.chief_examiner * in_rate_value
                ELSE mr.deputy_c_examiner * in_rate_value
            END),
        ((IF(h.no_of_scripts < 100, 100, h.no_of_scripts) / h.no_of_examiners) *
            (CASE
                WHEN ex.role = 'CHIEF EXAMINER' THEN mr.chief_examiner * in_rate_value
                ELSE mr.deputy_c_examiner * in_rate_value
            END)) * in_tax,
        ((IF(h.no_of_scripts < 100, 100, h.no_of_scripts) / h.no_of_examiners) *
            (CASE
                WHEN ex.role = 'CHIEF EXAMINER' THEN mr.chief_examiner * in_rate_value
                ELSE mr.deputy_c_examiner * in_rate_value
            END)) -
        (((IF(h.no_of_scripts < 100, 100, h.no_of_scripts) / h.no_of_examiners) *
            (CASE
                WHEN ex.role = 'CHIEF EXAMINER' THEN mr.chief_examiner * in_rate_value
                ELSE mr.deputy_c_examiner * in_rate_value
            END)) * in_tax),
        ex.bank,
        ex.branch,
        in_subject_code,
        in_subject_name,
        in_paper_no,
        ex.belt_no,
        in_session_year,
        CONCAT(in_session_year, ' ', in_session_name)
    FROM examiner ex
    JOIN marking_rates mr ON ex.subject_code = mr.subject_code AND ex.paper_no = mr.paper_no
    JOIN group_apportion ga ON ex.subject_code = ga.subject AND ex.paper_no = ga.paper AND ex.marking_centre = ga.marking_centre
    JOIN (
        SELECT COUNT(examiner_number) AS no_of_examiners, ga.no_of_scripts, ga.belt_no
        FROM group_apportion ga
        JOIN examiner ex ON ga.subject = ex.subject_code
        WHERE ga.paper = ex.paper_no
            AND ex.belt_no = ga.belt_no
            AND ex.attendance = 1
            AND ga.marking_centre = ex.marking_centre
            AND ga.subject = in_subject_code
            AND ga.paper = in_paper_no
            AND ga.marking_centre = in_marking_centre_code
            AND ex.role IN ('EXAMINER', 'TEAM LEADER')
        GROUP BY ga.no_of_scripts, ga.belt_no
        LIMIT 1
    ) AS h ON h.belt_no = ex.belt_no
    WHERE ex.subject_code = in_subject_code
        AND ex.paper_no = in_paper_no
        AND ex.marking_centre = in_marking_centre_code
        AND ex.attendance = 1
        AND ex.role IN ('CHIEF EXAMINER', 'DEPUTY CHIEF EXAMINER')
     GROUP BY ex.nrc, ex.examiner_number,h.no_of_scripts,h.no_of_examiners;

    -- Second part: EXAMINER, TEAM LEADER, CHECKER
    REPLACE INTO examiner_claim (
        marking_centre_code, marking_centre_name, nrc, examiner_number, tpin, full_name,
        address, province, district, position, no_of_scripts, sortcode, account_no,
        net_rate, grossed_up_rate, gross_pay, 15_wht, net_pay, bank, branch,
        subject_code, subject_name, paper_no, belt_no,session, session_name
    )
    SELECT 
        in_marking_centre_code,
        in_marking_centre_name,
        ex.nrc,
        ex.examiner_number,
        ex.tpin,
        CONCAT(ex.first_name, ' ', ex.last_name),
        ex.address,
        ex.province,
        ex.district,
        ex.role,
        ga.no_of_scripts,
        ex.sortcode,
        ex.account_no,
        CASE
            WHEN ex.role = 'TEAM LEADER' THEN mr.t_leader
            WHEN ex.role = 'CHECKER' THEN mr.checker
            ELSE mr.examiner
        END,
        CASE
            WHEN ex.role = 'TEAM LEADER' THEN mr.t_leader * in_rate_value
            WHEN ex.role = 'CHECKER' THEN mr.checker * in_rate_value
            ELSE mr.examiner * in_rate_value
        END,
        (
            (CASE
                WHEN ga.no_of_scripts = 0 THEN 0
                WHEN ga.no_of_scripts < 100 THEN 100
                ELSE ga.no_of_scripts
            END)
            * 
            CASE
                WHEN ex.role = 'TEAM LEADER' THEN mr.t_leader * in_rate_value
                WHEN ex.role = 'CHECKER' THEN mr.checker * in_rate_value
                ELSE mr.examiner * in_rate_value
            END
        )
        / (
            SELECT COUNT(*) 
            FROM examiner 
            WHERE subject_code = in_subject_code 
                AND paper_no = in_paper_no 
                AND belt_no = ex.belt_no 
                AND marking_centre = in_marking_centre_code 
                AND attendance = 1 
                AND role IN ('EXAMINER','TEAM LEADER')
        ),
        (
            (
                (CASE
                    WHEN ga.no_of_scripts = 0 THEN 0
                    WHEN ga.no_of_scripts < 100 THEN 100
                    ELSE ga.no_of_scripts
                END)
                * 
                CASE
                    WHEN ex.role = 'TEAM LEADER' THEN mr.t_leader * in_rate_value
                    WHEN ex.role = 'CHECKER' THEN mr.checker * in_rate_value
                    ELSE mr.examiner * in_rate_value
                END
            ) / (
                SELECT COUNT(*) 
                FROM examiner 
                WHERE subject_code = in_subject_code 
                    AND paper_no = in_paper_no 
                    AND belt_no = ex.belt_no 
                    AND marking_centre = in_marking_centre_code 
                    AND attendance = 1 
                    AND role IN ('EXAMINER','TEAM LEADER')
            )
        ) * in_tax,
        (
            (
                (CASE
                    WHEN ga.no_of_scripts = 0 THEN 0
                    WHEN ga.no_of_scripts < 100 THEN 100
                    ELSE ga.no_of_scripts
                END)
                * 
                CASE
                    WHEN ex.role = 'TEAM LEADER' THEN mr.t_leader * in_rate_value
                    WHEN ex.role = 'CHECKER' THEN mr.checker * in_rate_value
                    ELSE mr.examiner * in_rate_value
                END
            ) / (
                SELECT COUNT(*) 
                FROM examiner 
                WHERE subject_code = in_subject_code 
                    AND paper_no = in_paper_no 
                    AND belt_no = ex.belt_no 
                    AND marking_centre = in_marking_centre_code 
                    AND attendance = 1 
                    AND role IN ('EXAMINER','TEAM LEADER')
            )
        ) - (
            (
                (CASE
                    WHEN ga.no_of_scripts = 0 THEN 0
                    WHEN ga.no_of_scripts < 100 THEN 100
                    ELSE ga.no_of_scripts
                END)
                * 
                CASE
                    WHEN ex.role = 'TEAM LEADER' THEN mr.t_leader * in_rate_value
                    WHEN ex.role = 'CHECKER' THEN mr.checker * in_rate_value
                    ELSE mr.examiner * in_rate_value
                END
            ) / (
                SELECT COUNT(*) 
                FROM examiner 
                WHERE subject_code = in_subject_code 
                    AND paper_no = in_paper_no 
                    AND belt_no = ex.belt_no 
                    AND marking_centre = in_marking_centre_code 
                    AND attendance = 1 
                    AND role IN ('EXAMINER','TEAM LEADER')
            )
        ) * in_tax,
        ex.bank,
        ex.branch,
        in_subject_code,
        in_subject_name,
        in_paper_no,
        ex.belt_no,
        in_session_year,
        CONCAT(in_session_year, ' ', in_session_name)
    FROM examiner ex
    JOIN group_apportion ga ON ex.subject_code = ga.subject AND ex.paper_no = ga.paper AND ex.belt_no = ga.belt_no
    JOIN marking_rates mr ON ex.subject_code = mr.subject_code AND ex.paper_no = mr.paper_no
    WHERE ex.marking_centre = in_marking_centre_code
        AND ex.subject_code = in_subject_code
        AND ex.paper_no = in_paper_no
        AND ex.attendance = 1
        AND ex.role IN ('EXAMINER','TEAM LEADER','CHECKER')
   GROUP BY ex.nrc, ex.examiner_number,ga.no_of_scripts;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `apportionment`
-- (See below for the actual view)
--
CREATE TABLE `apportionment` (
`id` varchar(100)
,`school` varchar(6)
,`script_no` bigint
,`group_id` varchar(135)
,`subject` varchar(10)
,`paper` int
,`sen` int
,`belt_no` int
,`marking_centre` varchar(100)
,`username` varchar(100)
,`date_apportioned` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `centre`
--

CREATE TABLE `centre` (
  `centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `belt_no` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_claimed` date NOT NULL,
  `session_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int NOT NULL,
  `description` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `date_uploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examiner`
--

CREATE TABLE `examiner` (
  `id` int NOT NULL,
  `examiner_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `belt_no` int DEFAULT NULL,
  `attendance` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `no_of_days` int DEFAULT NULL,
  `marking_centre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_no` int DEFAULT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_status` int NOT NULL DEFAULT '1',
  `login_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `examiner`
--
DELIMITER $$
CREATE TRIGGER `update_entered_by` AFTER UPDATE ON `examiner` FOR EACH ROW BEGIN 
update marks set entered_by = concat(new.examiner_number,' - ',new.first_name,' ',new.last_name) where LEFT(entered_by,LOCATE(" ",entered_by) -1) = new.examiner_number and new.role = 'DATA ENTRY OFFICER';

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `examiner_claim`
--

CREATE TABLE `examiner_claim` (
  `id` int NOT NULL,
  `marking_centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrc` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `examiner_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_scripts` int NOT NULL,
  `sortcode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_rate` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grossed_up_rate` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `15_wht` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `belt_no` int NOT NULL,
  `session` int NOT NULL,
  `session_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `group_apportion`
-- (See below for the actual view)
--
CREATE TABLE `group_apportion` (
`id` varchar(135)
,`subject` varchar(10)
,`paper` int
,`belt_no` int
,`no_of_centres` bigint
,`no_of_scripts` decimal(42,0)
,`marking_centre` varchar(100)
,`min(username)` varchar(100)
,`date_created` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `marking_centre`
--

CREATE TABLE `marking_centre` (
  `id` int NOT NULL,
  `sen` int NOT NULL,
  `subject` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper` int NOT NULL DEFAULT '1',
  `centre_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marking_rates`
--

CREATE TABLE `marking_rates` (
  `id` int NOT NULL,
  `subject_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `chief_examiner` decimal(4,2) NOT NULL,
  `deputy_c_examiner` decimal(4,2) NOT NULL,
  `t_leader` decimal(4,2) NOT NULL,
  `examiner` decimal(4,2) NOT NULL,
  `checker` decimal(4,2) NOT NULL,
  `data_entry` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marking_rates`
--

INSERT INTO `marking_rates` (`id`, `subject_code`, `paper_no`, `chief_examiner`, `deputy_c_examiner`, `t_leader`, `examiner`, `checker`, `data_entry`) VALUES
(1, '1121', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(2, '1121', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(3, '2011', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(4, '2011', 2, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(5, '2030', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(6, '2044', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(7, '2046', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(8, '2167', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(9, '2167', 2, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(10, '2218', 2, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(11, '3016', 1, '12.00', '11.50', '11.00', '6.00', '9.00', '0.25'),
(12, '3147', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(13, '3147', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(14, '3148', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(15, '3148', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(16, '3149', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(17, '3149', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(18, '3153', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(19, '3153', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(20, '3154', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(21, '3154', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(22, '3156', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(23, '3156', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(24, '3160', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(25, '3160', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(26, '4024', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(27, '4024', 2, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(28, '4030', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(29, '4030', 2, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(30, '5037', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(31, '5054', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(32, '5070', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(33, '5090', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(34, '5124', 2, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(35, '6010', 1, '12.00', '11.50', '11.00', '6.00', '9.00', '0.25'),
(36, '6020', 1, '12.00', '11.50', '11.00', '6.00', '9.00', '0.25'),
(37, '6045', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(38, '6050', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(39, '6065', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(40, '6075', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(41, '6080', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(42, '7010', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25'),
(43, '7100', 1, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(44, '7110', 2, '12.00', '11.50', '11.00', '8.00', '9.00', '0.25'),
(45, '3017', 1, '12.00', '11.50', '11.00', '6.00', '9.00', '0.25'),
(46, '5124', 1, '12.00', '11.50', '11.00', '7.00', '9.00', '0.25');

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
  `sen` int NOT NULL DEFAULT '0',
  `improvised_mark` int NOT NULL DEFAULT '0',
  `belt_no` int NOT NULL DEFAULT '0',
  `id_group` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `marking_centre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'none',
  `valid` int NOT NULL DEFAULT '0',
  `disable` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `marks`
--
DELIMITER $$
CREATE TRIGGER `marks_audit_trail_delete_marks` AFTER DELETE ON `marks` FOR EACH ROW BEGIN
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
    marking_centre
  ) VALUES (
    OLD.centre_code,
    OLD.exam_no,
    OLD.subject_code,
    OLD.paper_no,
     "",
    OLD.mark,
    OLD.status,
    OLD.sen,
    OLD.improvised_mark,
    OLD.entered_by,
    'DELETE',
    NOW(),  -- You may need to adjust this based on your specific database's date/time functions
    OLD.marking_centre
  );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `marks_audit_trail_trigger` AFTER UPDATE ON `marks` FOR EACH ROW BEGIN
  IF (old.marking_centre != 'none') AND (old.disable = 0 AND new.disable = 1) AND new.status != 'L'
  THEN
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
      marking_centre
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
      NEW.marking_centre  
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
    marking_centre
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
    NEW.marking_centre
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
  `sen` int DEFAULT NULL,
  `improvised_mark` int NOT NULL DEFAULT '0',
  `entered_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entered` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marking_centre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paper`
--

CREATE TABLE `paper` (
  `1d` int NOT NULL,
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paper_no` int NOT NULL,
  `max_mark` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper`
--

INSERT INTO `paper` (`1d`, `subject_code`, `paper_no`, `max_mark`) VALUES
(1, '1121', 1, 40),
(2, '1121', 2, 60),
(3, '2011', 1, 60),
(4, '2011', 2, 60),
(5, '2030', 1, 100),
(6, '2044', 1, 100),
(7, '2046', 1, 100),
(8, '2167', 1, 100),
(9, '2167', 2, 100),
(10, '2218', 1, 50),
(11, '2218', 2, 48),
(12, '3016', 1, 60),
(13, '3017', 2, 40),
(14, '3017', 1, 60),
(15, '3147', 1, 100),
(16, '3147', 2, 100),
(17, '3148', 1, 100),
(18, '3148', 2, 100),
(19, '3149', 1, 100),
(20, '3149', 2, 100),
(21, '3153', 1, 100),
(22, '3153', 2, 100),
(23, '3154', 1, 100),
(24, '3154', 2, 100),
(25, '3156', 1, 100),
(26, '3156', 2, 100),
(27, '3160', 1, 100),
(28, '3160', 2, 100),
(29, '4024', 1, 80),
(30, '4024', 2, 100),
(31, '4030', 1, 80),
(32, '4030', 2, 100),
(33, '5037', 1, 100),
(34, '5054', 1, 40),
(35, '5054', 2, 80),
(36, '5070', 1, 40),
(37, '5070', 2, 80),
(38, '5090', 1, 40),
(39, '5090', 2, 80),
(40, '5124', 1, 85),
(41, '5124', 2, 85),
(42, '6010', 1, 50),
(43, '6020', 1, 100),
(44, '6045', 1, 110),
(45, '6050', 1, 100),
(46, '6065', 1, 100),
(47, '6075', 1, 100),
(48, '6080', 1, 70),
(49, '7010', 1, 70),
(50, '7100', 1, 100),
(51, '7110', 1, 40),
(52, '7110', 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `centre_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `centre_type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sen_exam_no`
--

CREATE TABLE `sen_exam_no` (
  `exam_no` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paper_no` int NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `year` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '9',
  `type` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `name`, `year`, `level`, `type`) VALUES
('2024', 'GENERAL CERTIFICATE', '2024', 'GCE', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_code`, `subject_name`) VALUES
('1121', 'ENGLISH LANGUAGE'),
('2011', 'LITERATURE IN ENGLISH'),
('2030', 'CIVIC EDUCATION'),
('2044', 'CHRISTIAN RELIGIOUS EDUCATION(2044)'),
('2046', 'CHRISTIAN RELIGIOUS EDUCATION(2046)'),
('2167', 'HISTORY'),
('2218', 'GEOGRAPHY'),
('3016', 'FRENCH'),
('3017', 'CHINESE LANGUAGE'),
('3147', 'LUNDA'),
('3148', 'LUVALE'),
('3149', 'KIIKAONDE'),
('3153', 'ICIBEMBA'),
('3154', 'CHITONGA'),
('3156', 'CINYANJA'),
('3160', 'SILOZI'),
('4024', 'MATHEMATICS'),
('4030', 'ADDITIONAL MATHEMATICS'),
('5037', 'AGRICULTURAL SCIENCE'),
('5054', 'PHYSICS'),
('5070', 'CHEMISTRY'),
('5090', 'BIOLOGY'),
('5124', 'SCIENCE'),
('6010', 'ART AND DESIGN'),
('6020', 'MUSIC'),
('6045', 'DESIGN AND TECHNOLOGY'),
('6050', 'FASHION AND FABRICS'),
('6065', 'FOOD AND NUTRITION'),
('6075', 'HOME MANAGEMENT'),
('6080', 'PHYSICAL EDUCATION'),
('7010', 'COMPUTER STUDIES'),
('7100', 'COMMERCE'),
('7110', 'PRINCIPLES OF ACCOUNTS'),
('9999', 'TEST SUBJECT');

-- --------------------------------------------------------

--
-- Structure for view `apportionment`
--
DROP TABLE IF EXISTS `apportionment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `apportionment`  AS SELECT `m`.`id_group` AS `id`, `m`.`centre_code` AS `school`, count(`m`.`centre_code`) AS `script_no`, concat(`m`.`marking_centre`,'_',`m`.`subject_code`,'_',`m`.`paper_no`,'_',`m`.`belt_no`) AS `group_id`, `m`.`subject_code` AS `subject`, `m`.`paper_no` AS `paper`, `m`.`sen` AS `sen`, `m`.`belt_no` AS `belt_no`, `m`.`marking_centre` AS `marking_centre`, max(`m`.`entered_by`) AS `username`, max(str_to_date(`m`.`date_entered`,'%d/%m/%Y %H:%i:%s')) AS `date_apportioned` FROM (select `marks`.`centre_code` AS `centre_code`,`marks`.`exam_no` AS `exam_no`,`marks`.`first_name` AS `first_name`,`marks`.`last_name` AS `last_name`,`marks`.`subject_code` AS `subject_code`,`marks`.`paper_no` AS `paper_no`,`marks`.`mark` AS `mark`,`marks`.`status` AS `status`,`marks`.`sen` AS `sen`,`marks`.`improvised_mark` AS `improvised_mark`,`marks`.`belt_no` AS `belt_no`,`marks`.`id_group` AS `id_group`,`marks`.`entered_by` AS `entered_by`,`marks`.`date_entered` AS `date_entered`,`marks`.`marking_centre` AS `marking_centre`,`marks`.`valid` AS `valid`,`marks`.`disable` AS `disable` from `marks`) AS `m` WHERE ((`m`.`status` = '-') AND (`m`.`marking_centre` <> 'none')) GROUP BY `m`.`id_group`, `m`.`centre_code`, `m`.`subject_code`, `m`.`paper_no`, `m`.`sen`, `m`.`belt_no`, `m`.`marking_centre``marking_centre`  ;

-- --------------------------------------------------------

--
-- Structure for view `group_apportion`
--
DROP TABLE IF EXISTS `group_apportion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `group_apportion`  AS SELECT `a`.`group_id` AS `id`, `a`.`subject` AS `subject`, `a`.`paper` AS `paper`, `a`.`belt_no` AS `belt_no`, count(`a`.`school`) AS `no_of_centres`, sum(`a`.`script_no`) AS `no_of_scripts`, `a`.`marking_centre` AS `marking_centre`, min(`a`.`username`) AS `min(username)`, min(`a`.`date_apportioned`) AS `date_created` FROM (select `apportionment`.`id` AS `id`,`apportionment`.`school` AS `school`,`apportionment`.`script_no` AS `script_no`,`apportionment`.`group_id` AS `group_id`,`apportionment`.`subject` AS `subject`,`apportionment`.`paper` AS `paper`,`apportionment`.`sen` AS `sen`,`apportionment`.`belt_no` AS `belt_no`,`apportionment`.`marking_centre` AS `marking_centre`,`apportionment`.`username` AS `username`,`apportionment`.`date_apportioned` AS `date_apportioned` from `apportionment`) AS `a` GROUP BY `a`.`group_id`, `a`.`subject`, `a`.`paper`, `a`.`belt_no`, `a`.`marking_centre``marking_centre`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `centre`
--
ALTER TABLE `centre`
  ADD PRIMARY KEY (`centre_code`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `centre_type` (`centre_type`);

--
-- Indexes for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `examiner_number` (`examiner_number`,`subject_code`,`paper_no`),
  ADD KEY `marking_centre_code` (`marking_centre_code`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `description` (`description`,`url`);

--
-- Indexes for table `examiner`
--
ALTER TABLE `examiner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `examiner_number_2` (`examiner_number`),
  ADD UNIQUE KEY `nrc` (`nrc`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `bank` (`bank`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `role` (`role`),
  ADD KEY `session` (`session`),
  ADD KEY `paper_no` (`paper_no`),
  ADD KEY `attendance` (`attendance`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `examiner_number` (`examiner_number`),
  ADD KEY `tpin` (`tpin`),
  ADD KEY `belt_no` (`belt_no`,`marking_centre`,`subject_code`,`paper_no`),
  ADD KEY `login_status` (`login_status`),
  ADD KEY `active` (`activation_status`);

--
-- Indexes for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `examiner_number` (`examiner_number`),
  ADD UNIQUE KEY `nrc` (`nrc`),
  ADD UNIQUE KEY `tpin` (`tpin`),
  ADD KEY `marking_centre_code` (`marking_centre_code`),
  ADD KEY `subject_code` (`subject_code`);

--
-- Indexes for table `marking_centre`
--
ALTER TABLE `marking_centre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sen` (`sen`,`subject`,`paper`),
  ADD KEY `subject` (`subject`,`paper`),
  ADD KEY `centre_code` (`centre_code`);

--
-- Indexes for table `marking_rates`
--
ALTER TABLE `marking_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_code_2` (`subject_code`,`paper_no`),
  ADD KEY `examiner` (`examiner`),
  ADD KEY `data_entry` (`data_entry`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `paper_no` (`paper_no`),
  ADD KEY `chief_examiner` (`chief_examiner`),
  ADD KEY `deputy_c_examiner` (`deputy_c_examiner`),
  ADD KEY `t_leader` (`t_leader`),
  ADD KEY `checker` (`checker`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD UNIQUE KEY `exam_no` (`exam_no`,`subject_code`,`paper_no`),
  ADD KEY `centre_code` (`centre_code`,`subject_code`,`paper_no`),
  ADD KEY `status` (`status`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `entered_by_2` (`entered_by`,`marking_centre`),
  ADD KEY `subject_code` (`subject_code`,`paper_no`,`marking_centre`),
  ADD KEY `sen` (`sen`),
  ADD KEY `disable` (`disable`),
  ADD KEY `belt_no` (`belt_no`),
  ADD KEY `date_entered` (`date_entered`),
  ADD KEY `id_group` (`id_group`);

--
-- Indexes for table `marks_audit_trail`
--
ALTER TABLE `marks_audit_trail`
  ADD KEY `status` (`status`),
  ADD KEY `marking_centre` (`marking_centre`),
  ADD KEY `improvised_mark` (`improvised_mark`),
  ADD KEY `entered_by` (`entered_by`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `subject_code` (`subject_code`,`paper_no`),
  ADD KEY `sen` (`sen`),
  ADD KEY `date_entered` (`date_entered`),
  ADD KEY `action` (`action`);

--
-- Indexes for table `paper`
--
ALTER TABLE `paper`
  ADD PRIMARY KEY (`1d`),
  ADD KEY `subject_code_2` (`subject_code`,`paper_no`),
  ADD KEY `paper_no` (`paper_no`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`centre_code`),
  ADD KEY `centre_code` (`centre_code`),
  ADD KEY `centre_code_2` (`centre_code`),
  ADD KEY `centre_type` (`centre_type`);

--
-- Indexes for table `sen_exam_no`
--
ALTER TABLE `sen_exam_no`
  ADD PRIMARY KEY (`exam_no`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `level` (`level`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_code`),
  ADD KEY `subject_code` (`subject_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examiner`
--
ALTER TABLE `examiner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1936;

--
-- AUTO_INCREMENT for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1991;

--
-- AUTO_INCREMENT for table `marking_centre`
--
ALTER TABLE `marking_centre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marking_rates`
--
ALTER TABLE `marking_rates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `paper`
--
ALTER TABLE `paper`
  MODIFY `1d` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_entry_claims`
--
ALTER TABLE `data_entry_claims`
  ADD CONSTRAINT `data_entry_claims_ibfk_1` FOREIGN KEY (`marking_centre_code`) REFERENCES `centre` (`centre_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examiner`
--
ALTER TABLE `examiner`
  ADD CONSTRAINT `examiner_ibfk_2` FOREIGN KEY (`session`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examiner_ibfk_3` FOREIGN KEY (`marking_centre`) REFERENCES `centre` (`centre_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examiner_claim`
--
ALTER TABLE `examiner_claim`
  ADD CONSTRAINT `examiner_claim_ibfk_1` FOREIGN KEY (`marking_centre_code`) REFERENCES `centre` (`centre_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examiner_claim_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `subjects` (`subject_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marking_centre`
--
ALTER TABLE `marking_centre`
  ADD CONSTRAINT `marking_centre_ibfk_1` FOREIGN KEY (`centre_code`) REFERENCES `centre` (`centre_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`centre_code`) REFERENCES `school` (`centre_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `subjects` (`subject_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paper`
--
ALTER TABLE `paper`
  ADD CONSTRAINT `paper_ibfk_1` FOREIGN KEY (`subject_code`) REFERENCES `subjects` (`subject_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
