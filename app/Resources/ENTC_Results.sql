-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2016 at 02:36 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `code`, `title`, `credits`, `gpa`, `sem_id`) VALUES
(1, 'CS-2022', 'OOSD', 3.0, 1, 3),
(2, 'EN-2012', 'Digital Electronics', 2.5, 1, 2);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `index_no`, `CGPA`, `rank`) VALUES
(1, 'Shanika Ediriweera', '130147J', 0.0000, 0),
(2, 'Module Class', 'Make th', 0.0000, 0),
(3, 'way to enter module results', 'Make a', 0.0000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_module_grade`
--

CREATE TABLE IF NOT EXISTS `student_module_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `m_code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student_module_grade`
--

INSERT INTO `student_module_grade` (`id`, `s_id`, `m_code`, `grade`) VALUES
(1, '130147', 'CS-2022', 'A+'),
(2, '130147', 'EN-2012', 'B-');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
