

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


CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark` decimal(2,1) NOT NULL,
  `grade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_595AAE34595AAE34` (`grade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

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

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `credits` decimal(2,1) NOT NULL,
  `gpa` tinyint(1) NOT NULL,
  `sem_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C24262877153098` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `module` (`id`, `code`, `title`, `credits`, `gpa`, `sem_id`) VALUES
(1, 'CS-2022', 'OOSD', 3.0, 1, 3),
(2, 'EN-2012', 'Digital Electronics', 2.5, 1, 2),
(3, 'MA2073', 'Calculus', 2.0, 1, 2),
(4, 'ME1802', 'Thermo', 3.0, 0, 2),
(5, 'CS-3042', 'Database Systems', 3.0, 1, 2);


CREATE TABLE IF NOT EXISTS `semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F7388EED5E237E06` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;


INSERT INTO `semester` (`id`, `name`) VALUES
(1, 'Semester1'),
(2, 'Semester2'),
(3, 'Semester3'),
(4, 'Semester4'),
(5, 'Semester5'),
(6, 'Semester6'),
(7, 'Semester7'),
(8, 'Semester8');


CREATE TABLE IF NOT EXISTS `semester_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sem_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `GPA` decimal(5,4) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;


INSERT INTO `semester_results` (`id`, `sem_id`, `stu_id`, `GPA`, `rank`) VALUES
(14, 2, 1, 3.9533, 2),
(15, 2, 4, 4.0000, 1),
(16, 2, 5, 3.6133, 3),
(17, 3, 1, 3.3000, 3),
(18, 3, 4, 4.2000, 1),
(19, 3, 5, 3.7000, 2);



CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `index_no` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `CGPA` decimal(5,4) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B723AF335CA03D2E` (`index_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `student` (`id`, `name`, `index_no`, `CGPA`, `rank`) VALUES
(1, 'Shanika Ediriweera', '130147J', 0.0000, 0),
(4, 'Ashen Ekanayake', '130150L', 0.0000, 0),
(5, 'Ravindu Hasantha', '130197K', 0.0000, 0);


CREATE TABLE IF NOT EXISTS `student_module_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `m_code` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `sem_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;


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
(34, '130197K', 'CS-3042', 'A-', 0);
