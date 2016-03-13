-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 03, 2016 at 08:00 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ENTC_Results`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76F85E0677` (`username`),
  UNIQUE KEY `UNIQ_880E0D76E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark` decimal(2,1) NOT NULL,
  `grade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_595AAE34595AAE34` (`grade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `mark`, `grade`) VALUES
(1, 4.2, 'A+'),
(2, 4.0, 'A'),
(3, 3.7, 'A-'),
(4, 3.3, 'B+'),
(5, 3.0, 'B'),
(6, 2.7, 'B-'),
(7, 2.3, 'C+'),
(8, 2.0, 'C'),
(9, 1.5, 'C-'),
(10, 1.0, 'D'),
(11, 0.0, 'F'),
(12, 0.0, 'I-we'),
(13, 0.0, 'I-ca'),
(14, 0.0, 'ab');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `credits` decimal(2,1) NOT NULL,
  `gpa` tinyint(1) NOT NULL,
  `sem_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C24262877153098` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `code`, `title`, `credits`, `gpa`, `sem_id`) VALUES
(1, 'CS-2022', 'OOSD', 3.0, 1, 3),
(2, 'EN-2012', 'Digital Electronics', 2.5, 1, 2),
(3, 'MA2073', 'Calculus', 2.0, 1, 2),
(4, 'ME1802', 'Thermo', 3.0, 0, 2),
(5, 'CS-3042', 'Database Systems', 3.0, 1, 2),
(6, 'cs-2032', 'PCC', 3.0, 1, 4),
(7, 'cs-2042', 'OS', 2.5, 1, 4),
(8, 'cs-2062', 'OOSD', 3.0, 1, 4),
(9, 'en-2022', 'Digital', 2.5, 1, 4),
(10, 'ce-1822', 'Civil', 2.0, 1, 4),
(11, 'me-1822', 'Thermo', 2.0, 1, 4),
(12, 'ma-2053', 'Graph', 2.0, 1, 4),
(13, 'ma-2073', 'Calculus', 2.0, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE IF NOT EXISTS `semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F7388EED5E237E06` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `name`) VALUES
(1, 'Semester1'),
(2, 'Semester2'),
(3, 'Semester3'),
(4, 'Semester4'),
(5, 'Semester5'),
(6, 'Semester6'),
(7, 'Semester7'),
(8, 'Semester8');

-- --------------------------------------------------------

--
-- Table structure for table `semester_results`
--

CREATE TABLE IF NOT EXISTS `semester_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sem_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `GPA` decimal(5,4) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `sem_credits` decimal(3,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `semester_results`
--

INSERT INTO `semester_results` (`id`, `sem_id`, `stu_id`, `GPA`, `rank`, `sem_credits`) VALUES
(20, 2, 1, 3.9533, 2, 7.5),
(21, 2, 4, 4.0000, 1, 7.5),
(22, 2, 5, 3.6133, 3, 7.5),
(23, 3, 1, 3.3000, 3, 3.0),
(24, 3, 4, 4.2000, 1, 3.0),
(25, 3, 5, 3.7000, 2, 3.0),
(26, 4, 1, 3.7368, 1, 19.0),
(27, 4, 4, 0.0000, 2, 0.0),
(28, 4, 5, 0.0000, 2, 0.0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `index_no` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `CGPA` decimal(5,4) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B723AF335CA03D2E` (`index_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `index_no`, `CGPA`, `rank`) VALUES
(1, 'Shanika Ediriweera', '130147J', 3.7666, 2),
(4, 'Ashen Ekanayake', '130150L', 4.0571, 1),
(5, 'Ravindu Hasantha', '130197K', 3.6381, 3);

-- --------------------------------------------------------

--
-- Table structure for table `student_module_grade`
--

CREATE TABLE IF NOT EXISTS `student_module_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `m_code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `sem_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

--
-- Dumping data for table `student_module_grade`
--

INSERT INTO `student_module_grade` (`id`, `s_id`, `m_code`, `grade`, `sem_id`) VALUES
(19, '130147J', 'CS-2022', 'B+', 0),
(20, '130147J', 'EN-2012', 'A-', 0),
(21, '130147J', 'MA2073', 'A+', 0),
(22, '130147J', 'ME1802', 'B-', 0),
(23, '130147J', 'CS-3042', 'A', 0),
(24, '130150L', 'CS-2022', 'A+', 0),
(26, '130150L', 'EN-2012', 'A', 0),
(27, '130150L', 'MA2073', 'A-', 0),
(28, '130150L', 'ME1802', 'B+', 0),
(29, '130150L', 'CS-3042', 'A+', 0),
(30, '130197K', 'CS-2022', 'A-', 0),
(31, '130197K', 'EN-2012', 'A', 0),
(32, '130197K', 'MA2073', 'B', 0),
(33, '130197K', 'ME1802', 'B-', 0),
(34, '130197K', 'CS-3042', 'A-', 0),
(35, '130147J', 'cs-2032', 'A+', 0),
(36, '130147J', 'cs-2042', 'A', 0),
(37, '130147J', 'cs-2062', 'A', 0),
(38, '130147J', 'en-2022', 'A', 0),
(39, '130147J', 'ce-1822', 'B-', 0),
(40, '130147J', 'me-1822', 'B', 0),
(41, '130147J', 'ma-2053', 'A+', 0),
(42, '130147J', 'ma-2073', 'B+', 0),
(52, '130000z', 'CS-2022', 'a', 0),
(53, '140000x', 'CS-2022', 'b', 0),
(54, '150000c', 'CS-2022', 'c', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
