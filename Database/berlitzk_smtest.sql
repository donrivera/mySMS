-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 26, 2013 at 06:37 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `berlitzk_smtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alert_id` bigint(100) NOT NULL,
  `imp` bigint(10) NOT NULL,
  `imp_info` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `infor` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `dt` date NOT NULL,
  `audience` bigint(10) NOT NULL,
  `cen_dr` bigint(10) NOT NULL,
  `stu_ad` bigint(100) NOT NULL,
  `rep` int(100) NOT NULL,
  `student` int(100) NOT NULL,
  `teacher` int(100) NOT NULL,
  `ac` int(11) NOT NULL,
  `lis` int(11) NOT NULL,
  `lism` int(11) NOT NULL,
  `tm` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `status` bigint(50) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alerts_read`
--

CREATE TABLE IF NOT EXISTS `alerts_read` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `alert_id` bigint(100) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `dated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alerts_reply`
--

CREATE TABLE IF NOT EXISTS `alerts_reply` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `alert_id` bigint(100) NOT NULL,
  `msg` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arf`
--

CREATE TABLE IF NOT EXISTS `arf` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `dated` varchar(100) NOT NULL,
  `nr` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `action_owner` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `report_by` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `report_to` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `arf_function` varchar(100) NOT NULL,
  `arf_function1` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `other1` varchar(100) NOT NULL,
  `other2` varchar(100) NOT NULL,
  `other3` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `action_report` text NOT NULL,
  `action_report_date` date NOT NULL,
  `action_taken` text NOT NULL,
  `action_taken_date` date NOT NULL,
  `result_check` text NOT NULL,
  `result_check_date` date NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  `sa_status` int(1) NOT NULL,
  `cd_status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `arf`
--

INSERT INTO `arf` (`id`, `teacher_id`, `student_id`, `centre_id`, `group_id`, `dated`, `nr`, `action_owner`, `report_by`, `report_to`, `arf_function`, `arf_function1`, `subject`, `other1`, `other2`, `other3`, `action_report`, `action_report_date`, `action_taken`, `action_taken_date`, `result_check`, `result_check_date`, `created_datetime`, `created_by`, `last_updated`, `updated_by`, `sa_status`, `cd_status`) VALUES
(1, 130, 1, 1, 1, '2013-11-05', '1', '', '', '', 'teacher', 'customer service', 'instruction', '', '', '', 'dadada', '2013-11-05', 'This is a test action....', '0000-00-00', 'This is a result checked...', '0000-00-00', '2013-11-05 16:30:34', 0, '0000-00-00 00:00:00', 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cd_makeup_class`
--

CREATE TABLE IF NOT EXISTS `cd_makeup_class` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `schedule_date` date NOT NULL,
  `dated` date NOT NULL,
  `room_id` int(11) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cd_makeup_class`
--

INSERT INTO `cd_makeup_class` (`id`, `group_id`, `centre_id`, `course_id`, `schedule_date`, `dated`, `room_id`, `status`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 11, 1, 2, '2013-09-12', '2013-09-19', 1, '', '2013-09-12 10:59:37', 125, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cd_makeup_class_dtls`
--

CREATE TABLE IF NOT EXISTS `cd_makeup_class_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cd_makeup_class_dtls`
--

INSERT INTO `cd_makeup_class_dtls` (`id`, `parent_id`, `student_id`, `group_id`, `course_id`, `centre_id`) VALUES
(1, 1, 62, 11, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `centre`
--

CREATE TABLE IF NOT EXISTS `centre` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cen_no` int(100) NOT NULL,
  `cen_tel_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cen_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cen_dir_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `street_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `area` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `province` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `unit_day` int(100) NOT NULL,
  `start_time` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `end_time` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `class_start_time` time NOT NULL,
  `class_end_time` time NOT NULL,
  `cen_no_clas` int(100) NOT NULL,
  `invoice_from` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `centre`
--

INSERT INTO `centre` (`id`, `name`, `cen_no`, `cen_tel_no`, `cen_email`, `cen_dir_name`, `street_name`, `area`, `province`, `country`, `unit_day`, `start_time`, `end_time`, `class_start_time`, `class_end_time`, `cen_no_clas`, `invoice_from`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Men Mubarraz', 1, '05487889765', 'center1@berlitz-ksa.com', 'Ahmed Varachia', 'Thurayat Street', 'Hofuf', 'Choose your state (if applicable)', '189', 0, '0:', ':', '08:00:00', '23:30:00', 5, '01', '2013-08-26 13:17:02', 1, '2013-10-01 11:55:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `centre_group_size`
--

CREATE TABLE IF NOT EXISTS `centre_group_size` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(100) NOT NULL,
  `size_from` bigint(100) NOT NULL,
  `size_to` bigint(100) NOT NULL,
  `total_size` bigint(100) NOT NULL,
  `week_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `week_id1` bigint(100) NOT NULL,
  `units` bigint(100) NOT NULL,
  `effect_units` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `centre_group_size`
--

INSERT INTO `centre_group_size` (`id`, `group_id`, `size_from`, `size_to`, `total_size`, `week_id`, `week_id1`, `units`, `effect_units`, `centre_id`) VALUES
(1, 51, 1, 1, 0, '', 1, 40, 1, 1),
(2, 52, 2, 3, 1, '', 1, 50, 1, 1),
(3, 53, 4, 6, 2, '', 2, 60, 0, 1),
(4, 54, 7, 9, 2, '', 3, 70, 0, 1),
(5, 55, 10, 12, 2, '', 4, 80, 0, 1),
(6, 56, 13, 150, 137, '', 4, 90, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `centre_room`
--

CREATE TABLE IF NOT EXISTS `centre_room` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `centre_id` bigint(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `no` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `centre_room`
--

INSERT INTO `centre_room` (`id`, `centre_id`, `name`, `no`) VALUES
(1, 1, 'Classroom 1', 12),
(2, 1, 'Classroom 2', 0),
(3, 1, 'Classroom 3', 0),
(4, 1, 'Classroom 4', 0),
(5, 1, 'Classroom 5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `centre_vacation`
--

CREATE TABLE IF NOT EXISTS `centre_vacation` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `sid` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `frm` date NOT NULL,
  `tto` date NOT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `status` bigint(10) NOT NULL,
  `no_days` bigint(10) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_cancel`
--

CREATE TABLE IF NOT EXISTS `class_cancel` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `cancel_date` date NOT NULL,
  `cancel_by` bigint(100) NOT NULL,
  `comments` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `class_cancel`
--

INSERT INTO `class_cancel` (`id`, `group_id`, `centre_id`, `cancel_date`, `cancel_by`, `comments`) VALUES
(1, 10, 1, '2013-09-12', 125, 'hj'),
(2, 69, 1, '2013-09-21', 125, 'nvmnv');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) NOT NULL,
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `comment` varchar(1000) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `type`, `comment`) VALUES
(1, 'Attendance', 'Your attendance is complete - ?????? ??????'),
(2, 'Attendance', 'Your attendance is near perfect'),
(3, 'Attendance', 'Your attendance was satisfactory, however you needed to attend more classes'),
(4, 'Attendance', 'Your attendance was minimal'),
(5, 'Attendance', 'Regularly tardy which resulted in missing lessos'),
(1, 'Participation', 'Your contribution within the lesson goes well beyond that expected of someone at your level.'),
(2, 'Participation', 'Your contribution within the lesson excceds that expected of someone at your level.'),
(3, 'Participation', 'Your contribution has facilitated language development in the classroom.'),
(4, 'Participation', 'More active participation would allow you to put your knowledge into practice.'),
(5, 'Participation', 'Further progress will be extremely difficult without sgnificantly more active participation during the lesson.'),
(1, 'Homework', 'All assigned homework is comopleted, allowing for thorough review and support of material covered in class.'),
(2, 'Homework', 'Almost all assigned homework is completed, allwing for review and support of material covered in class.'),
(3, 'Homework', 'Most assigned homework is completed.'),
(4, 'Homework', 'Homework is sometimes completed. Regular homework completion is necessary to achieve your language goals.'),
(5, 'Homework', 'Further progress will be extremely difficult without more attention to self-study. Regular homework completion is necessary to achieve your language goals.'),
(1, 'Fluency', 'Your fluency demonstrates a mastery of the topics far beyond what would be expected for your level.'),
(2, 'Fluency', 'Your fluency demonstrates a solid mastery of the topics covered so far.'),
(3, 'Fluency', 'Your fluency within the topics covered so far meets expectations. More fluency practice with your supplementary materials may be advised for specific points.'),
(4, 'Fluency', 'Your fluency is somewhat limited to specific words or phrases. More fluency practice with your supplementary materials is advised for specific points.'),
(5, 'Fluency', 'Your speech lacks the luency expected for your level. Thorough review and practive of the syllabus content would be required to improve your fluency.'),
(1, 'Pronunciation', 'The clarity of your pronunciation is easily understandable to all speakers of the language.'),
(2, 'Pronunciation', 'The clarity of your pronunciation is understandble to all speakers of the language.'),
(3, 'Pronunciation', 'Your pronunciation conveys your meaning but may have distinctive elements from your native language.'),
(4, 'Pronunciation', 'Your pronunciation may at times interfere with your meaning and has distinctie elements from your native language. the audio excercises in your supplementary material would be benificail for you.'),
(5, 'Pronunciation', 'Your pronunciation activedly impedes the message you wish to communicate. Further work with the supplementary audio excercises is highly recommended.'),
(1, 'Grammer', 'Your use of the grammatical points covered so far demonstrates a mastery beyond what would be expected for your leve.'),
(2, 'Grammer', 'Your use of the grammatical points covered so far demonstrates a solid understanding for your level.'),
(3, 'Grammer', 'Your use of the grammatical points covered so far is reasonably good. Further review of specific points is advised.'),
(4, 'Grammer', 'Your awareness of the grammar structures covered so far is limited. You are strongly advised to review the majority o grammer points covered so far.'),
(5, 'Grammer', 'Your awareness of the grammar structures covered so far will restrict your further language development. In-depth reiew of grammar structures indicated are necessary for further development.'),
(1, 'Vocabulary', 'Your range of expression includes all of the material covered so far and goes beyond the expected content for your level.'),
(2, 'Vocabulary', 'Your range of expression includes all of the materail covered so far for your level.'),
(3, 'Vocabulary', 'Your range of expression includes the most significant points from the material covered so far for your level.'),
(4, 'Vocabulary', 'Your range of expression covers several of the points introduced. You could benefit greatly by reviewing the relevant phrases and vocabulary in your supplementary material and your student reader.'),
(5, 'Vocabulary', 'Your range of expression is relatively limited for your level. Thorough review of the syllabus content would be required to improve you vocabulary.'),
(1, 'Comprehension', 'You easily understand all instructions and questions. You perform communicative tasks extremely well.'),
(2, 'Comprehension', 'You have a good understanding of questions and instuctions. You perform communicative tasks well.'),
(3, 'Comprehension', 'You understand instructions and questions with limited repetition. You performance in communicative tasks is satisfactory.'),
(4, 'Comprehension', 'You understand most utterances and tend to translate on rare occasions. After a bit of repetition, you can perform the communicatie tasks.'),
(5, 'Comprehension', 'You tend to translate often and require frequent repetition of questions. Some difficulty understanding communicatie tasks. :)  ??');

-- --------------------------------------------------------

--
-- Table structure for table `common`
--

CREATE TABLE IF NOT EXISTS `common` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

--
-- Dumping data for table `common`
--

INSERT INTO `common` (`id`, `name`, `type`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Part time - ???? ????', 'user status', '0000-00-00 00:00:00', 0, '2013-05-28 17:54:56', 1),
(2, 'Full Time - ???? ????', 'user status', '0000-00-00 00:00:00', 0, '2013-05-28 17:54:26', 1),
(3, 'Morning', 'teacher preference', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 'Afternoons', 'teacher preference', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 'Evening', 'teacher preference', '0000-00-00 00:00:00', 0, '2012-03-21 10:07:05', 1),
(6, 'Enrolled', 'student status', '0000-00-00 00:00:00', 0, '2011-12-29 14:28:37', 1),
(7, 'Potential', 'student status', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(8, 'Cancelled', 'student status', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(9, 'Waiting list', 'student status', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(10, 'Student progress on stop', 'student status', '0000-00-00 00:00:00', 0, '2012-02-10 12:42:05', 1),
(11, 'Templete 11', 'work week ', '0000-00-00 00:00:00', 0, '2012-02-06 18:49:16', 1),
(12, 'Sunday', 'work week ', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(13, 'Monday', 'work week', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(14, 'Tuesday', 'work week', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(15, 'Wednesday', 'work week', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(16, 'Thusday', 'work week', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(17, 'Friday', 'work week', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(32, 'Information', 'alert type', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(33, 'Alerts', 'alert type', '0000-00-00 00:00:00', 0, '2011-12-29 15:10:58', 1),
(31, 'Critical Alert', 'alert type', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(43, 'Word of Mouth', 'lead type', '0000-00-00 00:00:00', 0, '2013-01-22 01:04:22', 1),
(44, 'Friend - ????', 'lead type', '0000-00-00 00:00:00', 0, '2013-05-28 18:04:47', 1),
(45, 'Website - ??????', 'lead type', '0000-00-00 00:00:00', 0, '2013-05-28 18:04:38', 1),
(51, 'P1', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(52, 'P2', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(53, 'G1', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(54, 'G2', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(55, 'G3', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(56, 'G4', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(57, 'Flexible (flex)', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(61, 'POS - ????', 'payment type', '0000-00-00 00:00:00', 0, '2013-05-28 18:08:07', 1),
(60, 'Cash - ???', 'payment type', '0000-00-00 00:00:00', 0, '2013-05-28 18:08:14', 1),
(62, 'Student Book - ???? ??????', 'material type', '0000-00-00 00:00:00', 0, '2013-05-28 17:56:03', 1),
(63, 'CD', 'material type', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(64, 'CDROM', 'material type', '0000-00-00 00:00:00', 0, '2011-12-29 14:29:32', 1),
(70, 'Magazine - ????', 'material type', '2011-12-29 14:29:45', 1, '2013-05-28 17:55:52', 1),
(75, '1', 'Unit No', '2012-01-11 16:14:26', 1, '2012-02-02 14:41:16', 1),
(76, '2', 'Unit No', '2012-01-11 16:14:30', 1, '0000-00-00 00:00:00', 0),
(92, 'Facebook - ????????', 'lead type', '2012-03-27 02:43:09', 1, '2013-05-28 18:04:28', 1),
(98, 'School Student - ???? ?????', 'Type', '2012-07-17 16:19:02', 1, '2013-05-28 18:00:33', 1),
(99, 'University Student - ???? ?????', 'Type', '2012-07-17 16:19:45', 1, '2013-05-28 18:00:21', 1),
(100, 'Housewife - ??? ?????', 'Type', '2012-07-17 16:19:57', 1, '2013-05-28 18:00:08', 1),
(101, 'Employed - ????', 'Type', '2012-07-17 16:20:04', 1, '2013-05-28 17:59:59', 1),
(102, 'Unemployed - ???? ?? ?????', 'Type', '2012-07-17 16:20:10', 1, '2013-05-28 17:59:51', 1),
(128, '3', 'Unit No', '2012-09-03 01:57:13', 2, '0000-00-00 00:00:00', 0),
(129, '4', 'Unit No', '2012-09-03 01:57:18', 2, '0000-00-00 00:00:00', 0),
(130, 'Binder - ???', 'material type', '2012-09-25 03:33:34', 1, '2013-05-28 17:55:35', 1),
(131, 'Cheque - ???', 'payment type', '2012-09-25 03:34:19', 1, '2013-05-28 18:07:58', 1),
(132, 'G6', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(133, '5', 'Unit No', '2012-10-30 03:33:51', 7, '0000-00-00 00:00:00', 0),
(134, 'Family - ?????', 'lead type', '2013-01-22 01:04:36', 1, '2013-05-28 18:04:15', 1),
(144, 'Government Charity', 'Type', '2013-12-18 13:26:37', 1, '0000-00-00 00:00:00', 0),
(136, 'Weekends', 'teacher preference', '2013-02-04 02:26:48', 1, '0000-00-00 00:00:00', 0),
(137, 'Update', 'alert type', '2013-02-04 02:29:26', 1, '0000-00-00 00:00:00', 0),
(138, 'DVD', 'material type', '2013-02-04 02:32:54', 1, '0000-00-00 00:00:00', 0),
(139, '6', 'Unit No', '2013-02-04 02:33:49', 1, '0000-00-00 00:00:00', 0),
(141, 'Brochure - ?????', 'lead type', '2013-02-04 02:49:01', 1, '2013-05-28 18:00:55', 1),
(142, 'Action', 'alert type', '2013-05-28 17:57:56', 1, '0000-00-00 00:00:00', 0),
(143, 'Government', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(145, 'Government Charity', 'lead type', '2013-12-18 13:31:49', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE IF NOT EXISTS `conditions` (
  `id` bigint(10) NOT NULL,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`id`, `name`, `type`) VALUES
(1, 'Receipts\r\n\r\nTerms and Condition:\r\n\r\n:???? ???????\r\n\r\nUpdate', 'Challan'),
(2, 'Invoice\r\n\r\nTerms and Condition:\r\n\r\n:???? ???????\r\n', 'Invoice'),
(3, '9000', 'Logout Time'),
(4, 'http://berlitz-ksa.com/mySMS/logo/logo.png', 'Logo path'),
(5, 'http://berlitz-ksa.com/mySMS/logo/logo_big.png', 'Logo Big'),
(6, 'http://berlitz-ksa.com/mySMS/images/left-img.jpg', 'Logo Big Left'),
(7, '90', 'Bed Debt'),
(8, 'Asia/Riyadh', 'TimeZone');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=292 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `value`, `type`) VALUES
(1, 'Afghanistan', 'C'),
(2, '&Aring;land&nbsp;Islands', 'C'),
(3, 'Albania', 'C'),
(4, 'Algeria', 'C'),
(5, 'American&nbsp;Samoa', 'C'),
(6, 'Andorra', 'C'),
(7, 'Angola', 'C'),
(8, 'Anguilla', 'C'),
(9, 'Antarctica', 'C'),
(10, 'Antigua&nbsp;and&nbsp;Barbuda', 'C'),
(11, 'Argentina', 'C'),
(12, 'Armenia', 'C'),
(13, 'Aruba', 'C'),
(14, 'Australia', 'C'),
(15, 'Austria', 'C'),
(16, 'Azerbaijan', 'C'),
(17, 'Bahamas', 'C'),
(18, 'Bahrain', 'C'),
(19, 'Bangladesh', 'C'),
(20, 'Barbados', 'C'),
(21, 'Belarus', 'C'),
(22, 'Belgium', 'C'),
(23, 'Belize', 'C'),
(24, 'Benin', 'C'),
(25, 'Bermuda', 'C'),
(26, 'Bhutan', 'C'),
(27, 'Bolivia', 'C'),
(28, 'Bosnia&nbsp;and&nbsp;Herzegovina', 'C'),
(29, 'Botswana', 'C'),
(30, 'Bouvet&nbsp;Island', 'C'),
(31, 'Brazil', 'C'),
(32, 'British&nbsp;Indian&nbsp;Ocean&nbsp;territory', 'C'),
(33, 'Brunei&nbsp;Darussalam', 'C'),
(34, 'Bulgaria', 'C'),
(35, 'Burkina&nbsp;Faso', 'C'),
(36, 'Burundi', 'C'),
(37, 'Cambodia', 'C'),
(38, 'Cameroon', 'C'),
(39, 'Canada', 'C'),
(40, 'Cape&nbsp;Verde', 'C'),
(41, 'Cayman&nbsp;Islands', 'C'),
(42, 'Central&nbsp;African&nbsp;Republic', 'C'),
(43, 'Chad', 'C'),
(44, 'Chile', 'C'),
(45, 'China', 'C'),
(46, 'Christmas&nbsp;Island', 'C'),
(47, 'Cocos&nbsp;(Keeling)&nbsp;Islands', 'C'),
(48, 'Colombia', 'C'),
(49, 'Comoros', 'C'),
(50, 'Congo', 'C'),
(51, 'Congo', 'C'),
(52, '&nbsp;Democratic&nbsp;Republic', 'C'),
(53, 'Cook&nbsp;Islands', 'C'),
(54, 'Costa&nbsp;Rica', 'C'),
(55, 'C&ocirc;te&nbsp;d&#39;Ivoire&nbsp;(Ivory&nbsp;Coast)', 'C'),
(56, 'Croatia&nbsp;(Hrvatska)', 'C'),
(57, 'Cuba', 'C'),
(58, 'Cyprus', 'C'),
(59, 'Czech&nbsp;Republic', 'C'),
(60, 'Denmark', 'C'),
(61, 'Djibouti', 'C'),
(62, 'Dominica', 'C'),
(63, 'Dominican&nbsp;Republic', 'C'),
(64, 'East&nbsp;Timor', 'C'),
(65, 'Ecuador', 'C'),
(66, 'Egypt', 'C'),
(67, 'El&nbsp;Salvador', 'C'),
(68, 'Equatorial&nbsp;Guinea', 'C'),
(69, 'Eritrea', 'C'),
(70, 'Estonia', 'C'),
(71, 'Ethiopia', 'C'),
(72, 'Falkland&nbsp;Islands', 'C'),
(73, 'Faroe&nbsp;Islands', 'C'),
(74, 'Fiji', 'C'),
(75, 'Finland', 'C'),
(76, 'France', 'C'),
(77, 'French&nbsp;Guiana', 'C'),
(78, 'French&nbsp;Polynesia', 'C'),
(79, 'French&nbsp;Southern&nbsp;Territories', 'C'),
(80, 'Gabon', 'C'),
(81, 'Gambia', 'C'),
(82, 'Georgia', 'C'),
(83, 'Germany', 'C'),
(84, 'Ghana', 'C'),
(85, 'Gibraltar', 'C'),
(86, 'Greece', 'C'),
(87, 'Greenland', 'C'),
(88, 'Grenada', 'C'),
(89, 'Guadeloupe', 'C'),
(90, 'Guam', 'C'),
(91, 'Guatemala', 'C'),
(92, 'Guinea', 'C'),
(93, 'Guinea-Bissau', 'C'),
(94, 'Guyana', 'C'),
(95, 'Haiti', 'C'),
(96, 'Heard&nbsp;and&nbsp;McDonald&nbsp;Islands', 'C'),
(97, 'Honduras', 'C'),
(98, 'Hong&nbsp;Kong', 'C'),
(99, 'Hungary', 'C'),
(100, 'Iceland', 'C'),
(101, 'India', 'C'),
(102, 'Indonesia', 'C'),
(103, 'Iran', 'C'),
(104, 'Iraq', 'C'),
(105, 'Ireland', 'C'),
(106, 'Israel', 'C'),
(107, 'Italy', 'C'),
(108, 'Jamaica', 'C'),
(109, 'Japan', 'C'),
(110, 'Jordan', 'C'),
(111, 'Kazakhstan', 'C'),
(112, 'Kenya', 'C'),
(113, 'Kiribati', 'C'),
(114, 'Korea&nbsp;(north)', 'C'),
(115, 'Korea&nbsp;(south)', 'C'),
(116, 'Kuwait', 'C'),
(117, 'Kyrgyzstan', 'C'),
(118, 'Lao&nbsp;People&#39;s&nbsp;Democratic&nbsp;Republic', 'C'),
(119, 'Latvia', 'C'),
(120, 'Lebanon', 'C'),
(121, 'Lesotho', 'C'),
(122, 'Liberia', 'C'),
(123, 'Libyan&nbsp;Arab&nbsp;Jamahiriya', 'C'),
(124, 'Liechtenstein', 'C'),
(125, 'Lithuania', 'C'),
(126, 'Luxembourg', 'C'),
(127, 'Macao', 'C'),
(128, 'Macedonia', 'C'),
(129, 'Madagascar', 'C'),
(130, 'Malawi', 'C'),
(131, 'Malaysia', 'C'),
(132, 'Maldives', 'C'),
(133, 'Mali', 'C'),
(134, 'Malta', 'C'),
(135, 'Marshall&nbsp;Islands', 'C'),
(136, 'Martinique', 'C'),
(137, 'Mauritania', 'C'),
(138, 'Mauritius', 'C'),
(139, 'Mayotte', 'C'),
(140, 'Mexico', 'C'),
(141, 'Micronesia', 'C'),
(142, 'Moldova', 'C'),
(143, 'Monaco', 'C'),
(144, 'Mongolia', 'C'),
(145, 'Montserrat', 'C'),
(146, 'Morocco', 'C'),
(147, 'Mozambique', 'C'),
(148, 'Myanmar', 'C'),
(149, 'Namibia', 'C'),
(150, 'Nauru', 'C'),
(151, 'Nepal', 'C'),
(152, 'Netherlands', 'C'),
(153, 'Netherlands&nbsp;Antilles', 'C'),
(154, 'New&nbsp;Caledonia', 'C'),
(155, 'New&nbsp;Zealand', 'C'),
(156, 'Nicaragua', 'C'),
(157, 'Niger', 'C'),
(158, 'Nigeria', 'C'),
(159, 'Niue', 'C'),
(160, 'Norfolk&nbsp;Island', 'C'),
(161, 'Northern&nbsp;Mariana&nbsp;Islands', 'C'),
(162, 'Norway', 'C'),
(163, 'Oman', 'C'),
(164, 'Pakistan', 'C'),
(165, 'Palau', 'C'),
(166, 'Palestinian&nbsp;Territories', 'C'),
(167, 'Panama', 'C'),
(168, 'Papua&nbsp;New&nbsp;Guinea', 'C'),
(169, 'Paraguay', 'C'),
(170, 'Peru', 'C'),
(171, 'Philippines', 'C'),
(172, 'Pitcairn', 'C'),
(173, 'Poland', 'C'),
(174, 'Portugal', 'C'),
(175, 'Puerto&nbsp;Rico', 'C'),
(176, 'Qatar', 'C'),
(177, 'R&eacute;union', 'C'),
(178, 'Romania', 'C'),
(179, 'Russian&nbsp;Federation', 'C'),
(180, 'Rwanda', 'C'),
(181, 'Saint&nbsp;Helena', 'C'),
(182, 'Saint&nbsp;Kitts&nbsp;and&nbsp;Nevis', 'C'),
(183, 'Saint&nbsp;Lucia', 'C'),
(184, 'Saint&nbsp;Pierre&nbsp;and&nbsp;Miquelon', 'C'),
(185, 'Saint&nbsp;Vincent', 'C'),
(186, 'Samoa', 'C'),
(187, 'San&nbsp;Marino', 'C'),
(188, 'Sao&nbsp;Tome&nbsp;and&nbsp;Principe', 'C'),
(189, 'Saudi&nbsp;Arabia', 'C'),
(190, 'Senegal', 'C'),
(191, 'Serbia&nbsp;and&nbsp;Montenegro', 'C'),
(192, 'Seychelles', 'C'),
(193, 'Sierra&nbsp;Leone', 'C'),
(194, 'Singapore', 'C'),
(195, 'Slovakia', 'C'),
(196, 'Slovenia', 'C'),
(197, 'Solomon&nbsp;Islands', 'C'),
(198, 'Somalia', 'C'),
(199, 'South&nbsp;Africa', 'C'),
(200, 'South&nbsp;Georgia&nbsp;and&nbsp;the&nbsp;South&nbsp;Sandwich&nbsp;Islands', 'C'),
(201, 'Spain', 'C'),
(202, 'Sri&nbsp;Lanka', 'C'),
(203, 'Sudan', 'C'),
(204, 'Suriname', 'C'),
(205, 'Svalbard&nbsp;and&nbsp;Jan&nbsp;Mayen&nbsp;Islands', 'C'),
(206, 'Swaziland', 'C'),
(207, 'Sweden', 'C'),
(208, 'Switzerland', 'C'),
(209, 'Syria', 'C'),
(210, 'Taiwan', 'C'),
(211, 'Tajikistan', 'C'),
(212, 'Tanzania', 'C'),
(213, 'Thailand', 'C'),
(214, 'Togo', 'C'),
(215, 'Tokelau', 'C'),
(216, 'Tonga', 'C'),
(217, 'Trinidad&nbsp;and&nbsp;Tobago', 'C'),
(218, 'Tunisia', 'C'),
(219, 'Turkey', 'C'),
(220, 'Turkmenistan', 'C'),
(221, 'Turks&nbsp;and&nbsp;Caicos&nbsp;Islands', 'C'),
(222, 'Tuvalu', 'C'),
(223, 'Uganda', 'C'),
(224, 'Ukraine', 'C'),
(225, 'United&nbsp;Arab&nbsp;Emirates', 'C'),
(226, 'United&nbsp;Kingdom', 'C'),
(227, 'United&nbsp;States&nbsp;of&nbsp;America', 'C'),
(228, 'Uruguay', 'C'),
(229, 'Uzbekistan', 'C'),
(230, 'Vanuatu', 'C'),
(231, 'Vatican&nbsp;City', 'C'),
(232, 'Venezuela', 'C'),
(233, 'Vietnam', 'C'),
(234, 'Virgin&nbsp;Islands&nbsp;(British)', 'C'),
(235, 'Virgin&nbsp;Islands&nbsp;(US)', 'C'),
(236, 'Wallis&nbsp;and&nbsp;Futuna&nbsp;Islands', 'C'),
(237, 'Western&nbsp;Sahara', 'C'),
(238, 'Yemen', 'C'),
(239, 'Zaire', 'C'),
(240, 'Zambia', 'C'),
(241, 'Zimbabwe', 'C'),
(242, 'Alaska', 'S'),
(243, 'Arizona', 'S'),
(244, 'Arkansas', 'S'),
(245, 'California', 'S'),
(246, 'Colorado', 'S'),
(247, 'Connecticut', 'S'),
(248, 'Delaware', 'S'),
(249, 'Florida', 'S'),
(250, 'Georgia', 'S'),
(251, 'Hawaii', 'S'),
(252, 'Idaho', 'S'),
(253, 'Illinois', 'S'),
(254, 'Indiana', 'S'),
(255, 'Iowa', 'S'),
(256, 'Kansas', 'S'),
(257, 'Kentucky', 'S'),
(258, 'Louisiana', 'S'),
(259, 'Maine', 'S'),
(260, 'Maryland', 'S'),
(261, 'Massachusetts', 'S'),
(262, 'Michigan', 'S'),
(263, 'Minnesota', 'S'),
(264, 'Mississippi', 'S'),
(265, 'Missouri', 'S'),
(266, 'Montana', 'S'),
(267, 'Nebraska', 'S'),
(268, 'Nevada', 'S'),
(269, 'New Hampshire', 'S'),
(270, 'New Jersey', 'S'),
(271, 'New Mexico', 'S'),
(272, 'New York', 'S'),
(273, 'North Carolina', 'S'),
(274, 'North Dakota', 'S'),
(275, 'Ohio', 'S'),
(276, 'Oklahoma', 'S'),
(277, 'Oregon', 'S'),
(278, 'Pennsylvania', 'S'),
(279, 'Rhode Island', 'S'),
(280, 'South Carolina', 'S'),
(281, 'South Dakota', 'S'),
(282, 'Tennessee', 'S'),
(283, 'Texas', 'S'),
(284, 'Utah', 'S'),
(285, 'Vermont', 'S'),
(286, 'Virginia', 'S'),
(287, 'Washington', 'S'),
(288, 'West Virginia', 'S'),
(289, 'Wisconsin', 'S'),
(290, 'Wyoming', 'S'),
(291, 'Alabama', 'S');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `slno` bigint(100) NOT NULL,
  `code` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `descr` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `fees` float NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `slno`, `code`, `descr`, `fees`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Berlitz English Level 1 - ?????? ?????????? ??????? 1', 1, 'BE1', '', 0, '2013-08-27 12:13:08', 1, '0000-00-00 00:00:00', 0),
(2, 'Berlitz English Level 2 - ?????? ?????????? ??????? 2', 2, 'BE2', '', 0, '2013-08-27 12:13:40', 1, '0000-00-00 00:00:00', 0),
(3, 'Berlitz English Level 3 - ?????? ?????????? ??????? 3', 3, 'BE3', '', 0, '2013-08-27 12:14:02', 1, '0000-00-00 00:00:00', 0),
(4, 'Berlitz English Level 4 - ?????? ?????????? ??????? 4', 4, 'BE4', '', 0, '2013-08-27 12:14:20', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_fee`
--

CREATE TABLE IF NOT EXISTS `course_fee` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `course_id` bigint(100) NOT NULL,
  `fees` decimal(10,0) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `course_fee`
--

INSERT INTO `course_fee` (`id`, `course_id`, `fees`, `status`) VALUES
(1, 1, '3300', 1),
(2, 2, '3300', 1),
(3, 3, '3300', 1),
(4, 4, '3300', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency_setup`
--

CREATE TABLE IF NOT EXISTS `currency_setup` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `currency` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `symbol` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `use_currency` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

--
-- Dumping data for table `currency_setup`
--

INSERT INTO `currency_setup` (`id`, `currency`, `symbol`, `use_currency`) VALUES
(1, 'KSA', 'SR - &#65020;', 1),
(2, 'USD', '$', 0),
(3, 'AFN', '?', 0),
(4, 'ARS', '$', 0),
(5, 'AWG', '', 0),
(6, 'AUD', '$', 0),
(7, 'AZN', '???', 0),
(8, 'BSD', '$', 0),
(9, 'BBD', '$', 0),
(10, 'BYR', 'p.', 0),
(11, 'EUR', '', 0),
(12, 'BZD', 'BZ$', 0),
(13, 'BMD', '$', 0),
(14, 'BOB', '$b', 0),
(15, 'BAM', 'KM', 0),
(16, 'BWP', 'P', 0),
(17, 'BGN', '??', 0),
(18, 'BRL', 'R$', 0),
(19, 'GBP', '', 0),
(20, 'BND', '$', 0),
(21, 'KHR', '?', 0),
(22, 'CAD', '$', 0),
(25, 'CNY', '', 0),
(27, 'CRC', '?', 0),
(28, 'HRK', 'kn', 0),
(29, 'CUP', '?', 0),
(30, 'EUR', '', 0),
(31, 'CZK', 'K?', 0),
(32, 'DKK', 'kr', 0),
(33, 'DOP', 'RD$', 0),
(35, 'EGP', '', 0),
(41, 'GHC', '', 0),
(43, 'GTQ', 'Q', 0),
(46, 'HNL', 'L', 0),
(48, 'HUF', 'Ft', 0),
(49, 'ISK', 'kr', 0),
(50, 'INR', 'Rs', 0),
(51, 'IDR', 'Rp', 0),
(52, 'IRR', '?', 0),
(54, 'ILS', '?', 0),
(55, 'JMD', 'J$', 0),
(58, 'KZT', '??', 0),
(59, 'KPW', '?', 0),
(61, 'KGS', '??', 0),
(62, 'LAK', '?', 0),
(63, 'LVL', 'Ls', 0),
(66, 'CHF', 'CHF', 0),
(67, 'LTL', 'Lt', 0),
(68, 'MKD', '???', 0),
(69, 'MYR', 'RM', 0),
(70, 'MUR', '?', 0),
(72, 'MNT', '?', 0),
(73, 'MZN', 'MT', 0),
(75, 'NPR', '?', 0),
(76, 'ANG', '', 0),
(78, 'NIO', 'C$', 0),
(79, 'NGN', '?', 0),
(80, 'KPW', '?', 0),
(81, 'NOK', 'kr', 0),
(82, 'OMR', '?', 0),
(83, 'PKR', '?', 0),
(84, 'PAB', 'B/.', 0),
(85, 'PYG', 'Gs', 0),
(86, 'PEN', 'S/.', 0),
(87, 'PHP', 'Php', 0),
(88, 'PLN', 'z?', 0),
(89, 'QAR', '?', 0),
(90, 'RON', 'lei', 0),
(91, 'RUB', '???', 0),
(94, 'RSD', '???.', 0),
(95, 'SCR', '?', 0),
(98, 'SOS', 'S', 0),
(99, 'ZAR', 'R', 0),
(100, 'KRW', '?', 0),
(101, 'TWD', 'NT$', 0),
(102, 'THB', '?', 0),
(103, 'TTD', 'TT$', 0),
(104, 'TRY', 'TL', 0),
(107, 'UAH', '?', 0),
(109, 'UYU', '$U', 0),
(110, 'UZS', '??', 0),
(111, 'VEF', 'Bs', 0),
(112, 'VND', '?', 0),
(113, 'YER', '?', 0),
(114, 'ZWD', 'Z$', 0);

-- --------------------------------------------------------

--
-- Table structure for table `email_history`
--

CREATE TABLE IF NOT EXISTS `email_history` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` datetime NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `msg` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `send_to` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `type` int(10) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `send_date` date NOT NULL,
  `msg_from` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `automatic` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `page_full_path` longtext CHARACTER SET ucs2 COLLATE ucs2_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `email_history`
--

INSERT INTO `email_history` (`id`, `dated`, `user_id`, `msg`, `send_to`, `email`, `type`, `centre_id`, `send_date`, `msg_from`, `automatic`, `page_full_path`) VALUES
(1, '2013-08-26 01:17:32', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-08-26', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(2, '2013-08-27 11:14:55', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-08-27', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(3, '2013-08-27 12:16:55', 126, 'Your login details', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-27', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/user_process.php?action=insert'),
(4, '2013-08-27 12:22:53', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-08-27', 'Your login details', 'Yes', '/mySMS/admin/teacher1_process.php?action=insert'),
(5, '2013-08-27 04:45:31', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-08-27', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(6, '2013-08-28 11:30:20', 125, 'Sick leave has been Approved', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-28', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/sick_leave_process.php'),
(7, '2013-08-28 12:49:27', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-08-28', 'Your login details', 'Yes', '/mySMS/admin/teacher1_process.php?action=insert'),
(8, '2013-08-28 02:59:56', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-08-28', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(9, '2013-08-29 09:56:07', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-08-29', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/s1_process.php?action=insert'),
(10, '2013-08-29 09:56:07', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-08-29', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/s1_process.php?action=insert'),
(11, '2013-08-29 11:04:58', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-08-29', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/s1_process.php?action=insert'),
(12, '2013-08-29 11:04:59', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-08-29', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/s1_process.php?action=insert'),
(13, '2013-08-31 06:57:53', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(14, '2013-08-31 07:01:46', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(15, '2013-08-31 07:01:46', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(16, '2013-08-31 10:51:57', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(17, '2013-08-31 10:51:57', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(18, '2013-08-31 11:48:00', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(19, '2013-08-31 11:56:47', 126, 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-08-31', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/hold_process.php?action=insert'),
(20, '2013-09-10 12:52:02', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-09-10', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(21, '2013-09-12 11:00:28', 125, 'Alerts for number students in All centre !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-09-12', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/ep_adding_process.php?action=insert'),
(22, '2013-09-18 12:17:16', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-09-18', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(23, '2013-09-18 12:17:36', 1, 'Your login details', 'Teacher', '', 0, 0, '2013-09-18', 'Your login details', 'Yes', '/mySMS/admin/user_process.php?action=insert'),
(24, '2013-09-21 03:06:36', 125, 'Sick leave has been Approved', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-09-21', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/sick_leave_process.php'),
(25, '2013-09-21 03:08:16', 126, 'Your login details', 'Student Advisor and Center Director', 'mia@yahoo.com', 0, 1, '2013-09-21', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/user_process.php?action=insert'),
(26, '2013-10-02 12:28:31', 125, 'Sick leave has been Approved', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-10-02', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/sick_leave_process.php'),
(27, '2013-10-06 10:33:02', 131, 'Payment has been changed by Accountant', 'CD and SA', ',', 0, 0, '2013-10-06', 'Payment has been changed by Accountant', 'Yes', '/mySMS/accounts/payment_history_process.php?action=edit_payment&fee_id=2&centre_id=1&student_id=96&course_id=1'),
(28, '2013-10-06 01:53:50', 131, 'Payment has been changed by Accountant', 'CD and SA', ',', 0, 0, '2013-10-06', 'Payment has been changed by Accountant', 'Yes', '/mySMS/accounts/payment_history_process.php?action=edit_payment&fee_id=2&centre_id=1&student_id=96&course_id=1'),
(29, '2013-10-10 12:19:07', 126, 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-10-10', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/hold_process.php?action=insert'),
(30, '2013-10-10 12:20:30', 125, '', 'Student Advisor and Center Director', '', 0, 1, '2013-10-10', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/hold_process.php?cancel_id=2&action=update'),
(31, '2013-10-10 03:15:18', 125, '', 'Student Advisor and Center Director', '', 0, 1, '2013-10-10', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/hold_process.php?cancel_id=2&action=update'),
(32, '2013-10-14 09:54:07', 125, '', 'Student Advisor and Center Director', '', 0, 1, '2013-10-14', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/hold_process.php?cancel_id=2&action=update'),
(33, '2013-10-22 03:22:12', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(34, '2013-10-22 03:27:03', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(35, '2013-10-22 03:42:10', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(36, '2013-10-22 03:57:50', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(37, '2013-10-22 03:58:50', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(38, '2013-10-22 04:22:34', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(39, '2013-10-22 04:24:15', 130, '', 'Student Advisor and Center Director', '', 0, 0, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(40, '2013-10-22 04:28:49', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-10-22', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(41, '2013-11-04 04:25:36', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(42, '2013-11-04 04:29:31', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(43, '2013-11-04 04:31:25', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(44, '2013-11-04 05:01:58', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(45, '2013-11-04 05:07:31', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(46, '2013-11-04 05:10:31', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(47, '2013-11-04 05:11:48', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(48, '2013-11-04 05:14:06', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(49, '2013-11-04 05:15:53', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(50, '2013-11-05 04:30:35', 130, '', 'Student Advisor and Center Director', 'ahmedv@gmail.com', 0, 1, '2013-11-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/teacher/arf_process.php?action=insert'),
(51, '2013-12-02 01:42:08', 125, 'Sick leave has been Approved', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-02', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/sick_leave_process.php'),
(52, '2013-12-02 01:44:52', 125, 'Sick leave has been Approved', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-02', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/sick_leave_process.php'),
(53, '2013-12-03 02:57:22', 126, 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-03', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/hold_process.php?action=insert'),
(54, '2013-12-03 03:04:19', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-03', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(55, '2013-12-04 01:45:13', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(56, '2013-12-04 03:51:11', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(57, '2013-12-04 03:57:49', 126, 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/hold_process.php?action=insert'),
(58, '2013-12-04 03:59:49', 125, '', 'Student Advisor and Center Director', '', 0, 1, '2013-12-04', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/hold_process.php?cancel_id=1&action=update'),
(59, '2013-12-05 01:28:22', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(60, '2013-12-05 01:28:23', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(61, '2013-12-05 01:37:53', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(62, '2013-12-05 01:37:54', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(63, '2013-12-05 01:42:42', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(64, '2013-12-05 01:42:43', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(65, '2013-12-05 01:58:44', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(66, '2013-12-05 01:58:45', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(67, '2013-12-05 01:59:39', 126, 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/hold_process.php?action=insert'),
(68, '2013-12-05 02:00:51', 125, '', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/hold_process.php?cancel_id=1&action=update'),
(69, '2013-12-05 02:16:05', 126, 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/hold_process.php?action=insert'),
(70, '2013-12-05 02:16:30', 125, '', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/cd/hold_process.php?cancel_id=2&action=update'),
(71, '2013-12-05 02:43:13', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(72, '2013-12-05 03:13:44', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(73, '2013-12-05 04:19:40', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(74, '2013-12-05 04:32:54', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(75, '2013-12-05 04:32:55', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(76, '2013-12-05 04:33:40', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert'),
(77, '2013-12-05 04:43:51', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', 'don@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(78, '2013-12-05 04:43:52', 126, 'Group size has been changed Notification !!!', 'Student Advisor and Center Director', '', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(79, '2013-12-05 04:44:30', 126, 'Cancellation request from ', 'Student Advisor and Center Director', 'tarik@berlitz-ksa.com', 0, 1, '2013-12-05', 'Admin for Approved or Rejected of the Cancellation', 'Yes', '/mySMS/sa/cancel_process.php?action=insert');

-- --------------------------------------------------------

--
-- Table structure for table `email_templete`
--

CREATE TABLE IF NOT EXISTS `email_templete` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `email_templete`
--

INSERT INTO `email_templete` (`id`, `title`, `content`) VALUES
(2, 'Email Templete', '<table border="0" cellpadding="5" cellspacing="0" style="border: 1px solid rgb(109, 146, 201);" width="662">\r\n	<tbody>\r\n		<tr>\r\n			<td bgcolor="#FF9900" colspan="2" height="80">\r\n				<img alt="" src="http://www.bletprojects.com/schedule/images/logo.png" style="width: 105px; height: 30px;" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				<span style="font-family: comic sans ms,cursive;">Demo Announcement</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				<p>\r\n					<span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">Thank you,<br />\r\n					B</span></span><span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">erliz AlAhsa, a Dar Al-Khibra Human Resourses Development Company</span></span><br />\r\n					<span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;"> email : info@berlitz-ksa.com<br />\r\n					www.facebok.com/berlitzalahsa</span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `email_templetes`
--

CREATE TABLE IF NOT EXISTS `email_templetes` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `email_templetes`
--

INSERT INTO `email_templetes` (`id`, `title`, `content`) VALUES
(1, 'Alerts for Certificate printing !!!', 'Dear %cd%,\n\n%teacher% ??? ?? ???????? ????? ??? 3 ????. ????? ???? ?? ???? ??????? ??????.\n\nThanks1\nAdministrator'),
(2, 'Alerts for Filled up the Certificate grade !!!', 'Dear %cd%,\n\n%teacher% has been completed his course before 3 days. So you have to printing the certificate for the students.'),
(3, 'e-PEDCARD Alert Message !!!', 'Dear Mr/Ms, %teacher%\r\n\r\nYou have not Filled up your Attendance on %att_dt% for the Group %groupname%.\r\nPlease fill the Attendance As soon As Possible.\r\n\r\nThanks'),
(4, 'Alerts for complete the Progress reports', 'Dear %teacher%,\r\n\r\nYour course has been 50% completed and Progress report fields are not completed. Please complete your Progress reports as soon as possible.\r\n\r\nThanks'),
(5, 'Cancellation request from %username%', 'Dear %cd%,\r\n\r\nThis student is requesting to me for "CANCELLATION". See the details below.'),
(6, 'Group size has been changed Notification !!!', 'Dear %teacher%,\n\nNow, the ePed card needs to adjust the total remaining units for this course from a remaining of %pending_units% units for the previously %groupname% group to a remaining of %dec_right_value_is% units for the newly formed %g3_name% group.\n\nAdd %unit% units to this group due to adding %no_student_remove% students to a %student% %groupname% group that has completed %no_unit_finined% units at the time of adding these %no_student_remove% students.'),
(7, 'Payment has been changed by Accountant', 'Dear Center Director And Student Advisor,\r\n\r\nPayment has been changed by the Accountant of the below student.'),
(8, 'Sick leave has been %status%', 'Dear %teacher%,\r\n\r\nYour sick leave has %status% from dated %leavefrom% to %leaveto%.\r\n\r\nThanks\r\n%cd_name%'),
(9, 'Request for transfer from %username%', 'Dear %cd%,\r\n\r\nSome students want to transfer from my centre to another. Please see the Transfer Menu on your profile in the Application.\r\n\r\nThanks\r\n%teacher%'),
(10, 'Student on-hold request from %username%', 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.'),
(11, 'Alerts for number students in All centre !!!', 'Alerts for creating a group has been scheduled within a school/university date\r\n\r\n\r\nDear All Students,\r\n         Are you aware that there is a school or university exam during this course.\r\n\r\n\r\nThanks\r\nBerlitz'),
(12, 'On Hold request has been %status% By %from_name%', 'Dear %cd%\n\nThis student is requesting to me for "CANCE\nLLATION". See the details below.'),
(13, 'On Hold request has been %status% By %from_name%', 'Dear %cd%,\n\nI have filled the ARF form of the %studentname%. Please capture the Information.\n\nThanks'),
(14, 'Your course has finished. Please filled up the Progress Reports', 'Dear %teachername%,\r\n\r\nYour course has been completed. Please Complete your certificate grade.\r\n\r\n\r\nThanks\r\nBerlitz'),
(15, '%studentname% absent for %noof_days% days', 'Dear %cd%,\r\n\r\n%studentname% has been absent in his class since last %noof_days% days with any information. You are requested to kindly take appropriate action for the same.\r\n\r\n\r\nThanks\r\nBerlitz'),
(16, 'Sick leave from %teacher%', 'Dear %cd%,\r\n\r\nI have some problem. I have to Leave from dated %from_date% to %to_date%. So I will be absent for above days.\r\n\r\n\r\nThanks\r\nTeacher');

-- --------------------------------------------------------

--
-- Table structure for table `exam_vacation`
--

CREATE TABLE IF NOT EXISTS `exam_vacation` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `frm` date NOT NULL,
  `tto` date NOT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `status` bigint(10) NOT NULL,
  `no_days` bigint(10) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `frm` bigint(100) NOT NULL,
  `tto` bigint(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `frm`, `tto`, `name`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(6, 90, 95, 'Excellent', '2013-07-31 14:14:32', 1, '0000-00-00 00:00:00', 0),
(2, 80, 89, 'Very Good', '2012-09-03 02:14:11', 5, '0000-00-00 00:00:00', 0),
(3, 70, 79, 'Good', '2012-09-03 02:14:25', 5, '0000-00-00 00:00:00', 0),
(4, 51, 69, 'Satisfactory', '2012-09-03 02:14:41', 5, '0000-00-00 00:00:00', 0),
(5, 0, 50, 'Fair', '2012-09-03 02:14:56', 5, '0000-00-00 00:00:00', 0),
(7, 96, 100, 'Brilliant', '2013-07-31 14:14:58', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `grade_sheet`
--

CREATE TABLE IF NOT EXISTS `grade_sheet` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `frm` bigint(100) NOT NULL,
  `tto` bigint(100) NOT NULL,
  `nos` bigint(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `grade_sheet`
--

INSERT INTO `grade_sheet` (`id`, `frm`, `tto`, `nos`, `name`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 1, 4, 5, 'Insufficent', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 5, 12, 4, 'Fair', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 13, 24, 3, 'Satisfactory', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 25, 36, 2, 'Good', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 37, 40, 1, 'Very Good', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `group_list`
--

CREATE TABLE IF NOT EXISTS `group_list` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `commonid` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_size`
--

CREATE TABLE IF NOT EXISTS `group_size` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(100) NOT NULL,
  `size_from` bigint(100) NOT NULL,
  `size_to` bigint(100) NOT NULL,
  `total_size` bigint(100) NOT NULL,
  `week_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `week_id1` bigint(100) NOT NULL,
  `units` bigint(100) NOT NULL,
  `effect_units` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `group_size`
--

INSERT INTO `group_size` (`id`, `group_id`, `size_from`, `size_to`, `total_size`, `week_id`, `week_id1`, `units`, `effect_units`) VALUES
(1, 51, 0, 1, 0, '4 weeks', 1, 40, 0),
(2, 52, 2, 3, 1, '4 weeks', 1, 40, 0),
(3, 53, 4, 6, 2, '6 weeks', 2, 60, 0),
(4, 54, 7, 9, 2, '7 weeks', 3, 70, 4),
(5, 55, 10, 12, 2, '8 weeks', 4, 80, 4),
(6, 56, 13, 150, 137, '8 weeks', 4, 90, 4);

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `descr` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cen_dr` int(11) NOT NULL,
  `stu_ad` int(11) NOT NULL,
  `rep` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `teacher` int(11) NOT NULL,
  `ac` int(11) NOT NULL,
  `lis` int(11) NOT NULL,
  `lism` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `links` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cen_dr` bigint(100) NOT NULL,
  `stu_ad` bigint(100) NOT NULL,
  `rep` int(100) NOT NULL,
  `student` int(100) NOT NULL,
  `teacher` int(100) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alert_id` bigint(100) NOT NULL,
  `imp` bigint(10) NOT NULL,
  `imp_info` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `infor` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `dt` date NOT NULL,
  `audience` bigint(10) NOT NULL,
  `cen_dr` bigint(10) NOT NULL,
  `stu_ad` bigint(100) NOT NULL,
  `rep` int(100) NOT NULL,
  `student` int(100) NOT NULL,
  `teacher` int(100) NOT NULL,
  `tm` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `status` bigint(50) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ped`
--

CREATE TABLE IF NOT EXISTS `ped` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `estart_date` date NOT NULL,
  `material` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `bl` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `arf_submit` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `level` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `comments` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `checklist` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `point_cover1` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `point_date1` date NOT NULL,
  `point_cover2` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `point_date2` date NOT NULL,
  `ini_feedback` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `inst1` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date1` date NOT NULL,
  `arf1` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `dby1` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `dby1_date1` date NOT NULL,
  `cby1` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cby1_date1` date NOT NULL,
  `inst2` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `inst2_date2` date NOT NULL,
  `counselling` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `inst3` varchar(100) NOT NULL,
  `inst3_date3` date NOT NULL,
  `inst4` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `inst4_date4` date NOT NULL,
  `not_apply` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `distrbute_by` varchar(110) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `distrbute_date` date NOT NULL,
  `collect_by` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `collect_date` date NOT NULL,
  `pro_report` varchar(5) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ped`
--

INSERT INTO `ped` (`id`, `teacher_id`, `group_id`, `course_id`, `estart_date`, `material`, `bl`, `arf_submit`, `level`, `comments`, `location`, `checklist`, `point_cover1`, `point_date1`, `point_cover2`, `point_date2`, `ini_feedback`, `inst1`, `date1`, `arf1`, `dby1`, `dby1_date1`, `cby1`, `cby1_date1`, `inst2`, `inst2_date2`, `counselling`, `inst3`, `inst3_date3`, `inst4`, `inst4_date4`, `not_apply`, `distrbute_by`, `distrbute_date`, `collect_by`, `collect_date`, `pro_report`) VALUES
(1, 2, 1, 1, '0000-00-00', '', '', '', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '1'),
(2, 2, 2, 1, '0000-00-00', '', '', '', '', '', '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ped_attendance`
--

CREATE TABLE IF NOT EXISTS `ped_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ped_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `shift1` char(1) NOT NULL,
  `shift2` char(1) NOT NULL,
  `shift3` char(2) NOT NULL,
  `shift4` char(2) NOT NULL,
  `shift5` char(2) NOT NULL,
  `shift6` char(2) NOT NULL,
  `shift7` char(2) NOT NULL,
  `shift8` char(2) NOT NULL,
  `shift9` char(2) NOT NULL,
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `dated` date NOT NULL,
  `attend_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `ped_attendance`
--

INSERT INTO `ped_attendance` (`id`, `ped_id`, `teacher_id`, `group_id`, `course_id`, `student_id`, `unit`, `shift1`, `shift2`, `shift3`, `shift4`, `shift5`, `shift6`, `shift7`, `shift8`, `shift9`, `status`, `dated`, `attend_date`) VALUES
(1, 1, 2, 1, 1, 2, 1, 'X', 'X', '', '', '', '', '', '', '', '', '2013-12-02', '2013-12-02'),
(2, 1, 2, 1, 1, 2, 2, 'X', 'E', '', '', '', '', '', '', '', '', '2013-12-02', '2013-12-03'),
(3, 1, 2, 1, 1, 2, 3, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(4, 1, 2, 1, 1, 2, 4, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(5, 1, 2, 1, 1, 2, 5, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(6, 1, 2, 1, 1, 2, 6, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(7, 1, 2, 1, 1, 2, 7, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(8, 1, 2, 1, 1, 2, 8, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(9, 1, 2, 1, 1, 2, 9, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(10, 1, 2, 1, 1, 2, 10, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(11, 1, 2, 1, 1, 2, 11, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(12, 1, 2, 1, 1, 2, 12, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(13, 1, 2, 1, 1, 2, 13, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(14, 1, 2, 1, 1, 2, 14, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(15, 1, 2, 1, 1, 2, 15, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(16, 1, 2, 1, 1, 2, 16, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(17, 1, 2, 1, 1, 2, 17, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(18, 1, 2, 1, 1, 2, 18, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(19, 1, 2, 1, 1, 2, 19, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(20, 1, 2, 1, 1, 2, 20, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(21, 1, 2, 1, 1, 1, 1, 'X', 'X', '', '', '', '', '', '', '', '', '2013-12-02', '2013-12-02'),
(22, 1, 2, 1, 1, 1, 2, 'L', 'A', '', '', '', '', '', '', '', '', '2013-12-02', '2013-12-03'),
(23, 1, 2, 1, 1, 1, 3, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(24, 1, 2, 1, 1, 1, 4, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(25, 1, 2, 1, 1, 1, 5, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(26, 1, 2, 1, 1, 1, 6, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(27, 1, 2, 1, 1, 1, 7, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(28, 1, 2, 1, 1, 1, 8, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(29, 1, 2, 1, 1, 1, 9, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(30, 1, 2, 1, 1, 1, 10, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(31, 1, 2, 1, 1, 1, 11, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(32, 1, 2, 1, 1, 1, 12, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(33, 1, 2, 1, 1, 1, 13, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(34, 1, 2, 1, 1, 1, 14, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(35, 1, 2, 1, 1, 1, 15, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(36, 1, 2, 1, 1, 1, 16, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(37, 1, 2, 1, 1, 1, 17, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(38, 1, 2, 1, 1, 1, 18, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(39, 1, 2, 1, 1, 1, 19, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(40, 1, 2, 1, 1, 1, 20, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(41, 1, 2, 1, 1, 3, 1, 'X', 'X', '', '', '', '', '', '', '', '', '2013-12-02', '2013-12-02'),
(42, 1, 2, 1, 1, 3, 2, 'A', 'L', '', '', '', '', '', '', '', '', '2013-12-02', '2013-12-03'),
(43, 1, 2, 1, 1, 3, 3, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(44, 1, 2, 1, 1, 3, 4, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(45, 1, 2, 1, 1, 3, 5, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(46, 1, 2, 1, 1, 3, 6, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(47, 1, 2, 1, 1, 3, 7, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(48, 1, 2, 1, 1, 3, 8, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(49, 1, 2, 1, 1, 3, 9, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(50, 1, 2, 1, 1, 3, 10, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(51, 1, 2, 1, 1, 3, 11, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(52, 1, 2, 1, 1, 3, 12, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(53, 1, 2, 1, 1, 3, 13, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(54, 1, 2, 1, 1, 3, 14, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(55, 1, 2, 1, 1, 3, 15, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(56, 1, 2, 1, 1, 3, 16, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(57, 1, 2, 1, 1, 3, 17, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(58, 1, 2, 1, 1, 3, 18, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(59, 1, 2, 1, 1, 3, 19, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00'),
(60, 1, 2, 1, 1, 3, 20, '', '', '', '', '', '', '', '', '', '', '2013-12-02', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `ped_comment`
--

CREATE TABLE IF NOT EXISTS `ped_comment` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(100) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `dated` datetime NOT NULL,
  `comments` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ped_daily_status`
--

CREATE TABLE IF NOT EXISTS `ped_daily_status` (
  `dated` date NOT NULL,
  `teacher_id` bigint(100) NOT NULL,
  `ped_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ped_daily_status`
--

INSERT INTO `ped_daily_status` (`dated`, `teacher_id`, `ped_id`, `group_id`, `course_id`) VALUES
('2013-12-02', 2, 0, 1, 1),
('2013-12-02', 2, 0, 1, 1),
('2013-12-02', 2, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ped_daily_status_dtls`
--

CREATE TABLE IF NOT EXISTS `ped_daily_status_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `teacher_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ped_daily_status_dtls`
--

INSERT INTO `ped_daily_status_dtls` (`id`, `dated`, `teacher_id`, `group_id`, `centre_id`) VALUES
(1, '2013-10-06', 2, 0, 0),
(2, '2013-10-07', 2, 1, 0),
(3, '2013-10-22', 2, 0, 0),
(4, '2013-10-26', 2, 0, 0),
(5, '2013-10-29', 2, 0, 0),
(6, '2013-11-04', 2, 0, 0),
(7, '2013-11-05', 2, 0, 0),
(8, '2013-12-02', 2, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ped_units`
--

CREATE TABLE IF NOT EXISTS `ped_units` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `ped_id` bigint(100) NOT NULL,
  `teacher_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `units` bigint(100) NOT NULL,
  `dated` date NOT NULL,
  `attd` bigint(100) NOT NULL,
  `instructor` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `material_overed` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `homework` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ped_units`
--

INSERT INTO `ped_units` (`id`, `ped_id`, `teacher_id`, `group_id`, `course_id`, `units`, `dated`, `attd`, `instructor`, `material_overed`, `homework`) VALUES
(1, 1, 2, 1, 1, 1, '2013-12-02', 0, '', 'adada', 'dadadd');

-- --------------------------------------------------------

--
-- Table structure for table `quick_links`
--

CREATE TABLE IF NOT EXISTS `quick_links` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `link_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `prec` bigint(100) NOT NULL,
  `links` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `module_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `quick_links`
--

INSERT INTO `quick_links` (`id`, `img_name`, `link_name`, `prec`, `links`, `module_name`, `user_id`, `centre_id`) VALUES
(1, '', 'ADMIN_MENU_RULE_SMS', 12, 'sms_gateway_manage.php', 'Administrator', 0, 0),
(2, '', 'ADMIN_MENU_USERS', 34, 'user_manage.php', 'Administrator', 0, 0),
(3, '', 'Edit Student Appointment', 4, 'student_appoint_manage.php', 'Student Advisor', 126, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quick_menu`
--

CREATE TABLE IF NOT EXISTS `quick_menu` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `link_constant` varchar(100) NOT NULL,
  `arabic_menu` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `links` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `module_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=293 ;

--
-- Dumping data for table `quick_menu`
--

INSERT INTO `quick_menu` (`id`, `link_name`, `link_constant`, `arabic_menu`, `links`, `module_name`) VALUES
(1, 'Manage Week', 'ADMIN_MENU_RULE_WEEK', '', 'week_manage.php', 'Administrator'),
(2, 'Manage Group Type', 'ADMIN_MENU_RULE_TYPE', '', 'group_manage.php', 'Administrator'),
(3, 'Manage Group Size', 'ADMIN_MENU_RULE_GROUP', '', 'group_size_manage.php', 'Administrator'),
(4, 'Manage User Status', 'ADMIN_MENU_RULE_USER_STATUS', '', 'user_status_manage.php', 'Administrator'),
(5, 'Manage Teacher Preference', 'ADMIN_MENU_RULE_PREFER', '', 'teacher_manage.php', 'Administrator'),
(6, 'Manage Student Status', '', '', 'student_manage.php', 'Administrator'),
(7, 'New Alerts Type', 'ADMIN_MENU_RULE_ALERTS', '', 'alert_manage.php', 'Administrator'),
(8, 'Manage Teacher', 'ADMIN_MENU_RULE_TEACHER', '', 'teacher1_manage.php', 'Administrator'),
(9, 'Manage Material', 'ADMIN_MENU_RULE_MATERIAL', '', 'material_manage.php', 'Administrator'),
(10, 'Manage Unit', 'ADMIN_MENU_RULE_UNI', '', 'unit_manage.php', 'Administrator'),
(11, 'Manage Comments', 'ADMIN_MENU_RULE_COMMENTS', '', 'comments_manage.php', 'Administrator'),
(12, 'Set Logout Time', 'ADMIN_MENU_RULE_LOGOUT_TIME', '', 'timeout_manage.php', 'Administrator'),
(13, 'SMS Gateway Configuration', 'ADMIN_MENU_RULE_SMS', '', 'sms_gateway_manage.php', 'Administrator'),
(14, 'Group Sizes', 'ADMIN_MENU_RULE_VIEW_GROUP_SIZE', '', 'view_group_size.php', 'Administrator'),
(15, 'View Group History', 'ADMIN_MENU_RULE_VIEW_GROUP_HISTORY', '', 'view_group_history.php', 'Administrator'),
(16, 'Student Comments History', 'ADMIN_MENU_RULE_VIEW_COMMENT_HISTORY', '', 'view_student_comments_history.php', 'Administrator'),
(17, 'Currency Setup', 'ADMIN_MENU_RULE_CURRENCY', '', 'currency_setup.php', 'Administrator'),
(18, 'Manage help Document', 'ADMIN_MENU_RULE_HELP', '', 'help_manage.php', 'Administrator'),
(19, 'Type of Students', 'TYPE_OF_STUDENTS', '', 'type_manage.php', 'Administrator'),
(20, 'Leads', 'ADMIN_MENU_LEADS', '', 'lead_manage.php', 'Administrator'),
(21, 'Grades', 'ADMIN_MENU_GRADES', '', 'grade_manage.php', 'Administrator'),
(22, 'Type of Payment', 'ADMIN_MENU_TYPEOFPAYMENT', '', 'payment_manage.php', 'Administrator'),
(23, 'Recepts Terms And Condition', 'ADMIN_MENU_RECEIPT', '', 'challan_cond.php', 'Administrator'),
(24, 'Invoice Terms And Condition', 'ADMIN_MENU_INVOICE', '', 'invoice_cond.php', 'Administrator'),
(25, 'Bed Debt Configure', 'ADMIN_BED_DEBT_CONFIRE', '', 'bed_debt_config.php', 'Administrator'),
(26, 'Centre', 'ADMIN_MENU_CENTRE', '', 'center_manage.php', 'Administrator'),
(27, 'Student To Student Transfer', 'SA_STUDENT_TO_STUDENT', '', 'student_to_student_manage.php', 'Administrator'),
(28, 'Center to Center Transfer', 'SA_CENTER_CENTER', '', 'center_to_center_manage.php', 'Administrator'),
(29, 'Centre Vacation', 'ADMIN_MENU_VAC_CENTRE', '', 'vacation_center_manage.php', 'Administrator'),
(30, 'Teacher Vacation', 'ADMIN_MENU_VAC_TEACHER', '', 'vacation_teacher_manage.php', 'Administrator'),
(31, 'Exam Vacation', 'ADMIN_MENU_VAC_EXAM', '', 'vacation_exam_manage.php', 'Administrator'),
(32, 'Student Request Vacation', 'ADMIN_MENU_VAC_STUDENT', '', 'vacation_student_manage.php', 'Administrator'),
(33, 'Manage Sick Leave', 'CD_MENU_MANAGE_SICK_LEAVE', '', 'sick_leave_manage.php', 'Administrator'),
(34, 'Course', 'ADMIN_MENU_COURSE', '', 'course_manage.php', 'Administrator'),
(35, 'Users', 'ADMIN_MENU_USERS', '', 'user_manage.php', 'Administrator'),
(36, 'News', 'ADMIN_MENU_NEWS', '', 'news_manage.php', 'Administrator'),
(37, 'Links', 'ADMIN_MENU_LINKS', '', 'link_manage.php', 'Administrator'),
(38, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert1_manage.php', 'Administrator'),
(39, 'Manage SMS Template', 'ADMIN_MENU_SMS_TEMP', '', 'sms_template_manage.php', 'Administrator'),
(40, 'SMS Parameter Template', 'ADMIN_SMS_PARAMETER_TEMPLETE_SMS_PARA_TEMP', '', 'sms_parameter_templete.php', 'Administrator'),
(41, 'Manage SMS History', 'ADMIN_MENU_SMS_HISTORY', '', 'sms_history.php', 'Administrator'),
(42, 'Manage Email Template', 'ADMIN_EMAIL_MANAGE_EMAIL_TEMPLETE', '', 'email_manage.php', 'Administrator'),
(43, 'manage Email Parameter', 'ADMIN_MENU_EMAIL_TEMP', '', 'email_parameter_templete.php', 'Administrator'),
(44, 'Student Details', 'ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS', '', 's_manage.php', 'Administrator'),
(45, 'Cancellation Request', 'CANCELLATION_REQUEST', '', 'cancel_manage.php', 'Administrator'),
(46, 'By-Teacher Groups', 'ADMIN_MENU_REPORTS_BOARD', '', 'report_teacher_board.php', 'Administrator'),
(47, 'Teacher(s) Schedule', 'ADMIN_MENU_REPORTS_SCHEDULE', '', 'report_teacher_schedule.php', 'Administrator'),
(48, 'Students awaiting a course', 'ADMIN_MENU_REPORTS_AWAIT', '', 'report_student_awaiting.php', 'Administrator'),
(49, 'Groups to Finish', 'ADMIN_MENU_REPORTS_FINISH', '', 'report_group_to_finish.php', 'Administrator'),
(50, 'Certificates not collected', 'ADMIN_MENU_REPORTS_COLLECT', '', 'report_certificate_not_collect.php', 'Administrator'),
(51, 'Student Absence Report', 'ADMIN_MENU_REPORTS_ABSENT', '', 'report_absent_report.php', 'Administrator'),
(52, 'Teacher Leave Report', 'ADMIN_MENU_REPORTS_TEACHER_LEAVE', '', 'report_teacher_leave_report.php', 'Administrator'),
(53, 'Teacher Overtime Report', 'ADMIN_MENU_REPORTS_TEACHER_OVER', '', 'report_teacher_overtime_report.php', 'Administrator'),
(54, 'Teacher Capacity', 'ADMIN_MENU_REPORTS_TEACHER_CAPACITY', '', 'report_teacher_capacity.php', 'Administrator'),
(55, 'Students Results', 'ADMIN_MENU_REPORTS_SUMMARY', '', 'report_certificate_report.php', 'Administrator'),
(56, 'VIP Students', 'ADMIN_MENU_REPORTS_CUSTOMER', '', 'report_freq_customer_report.php', 'Administrator'),
(57, 'Detailed Students Results', 'ADMIN_MENU_REPORTS_GROUP_GRADE', '', 'report_student_group_grade.php', 'Administrator'),
(58, 'Students Statuses', 'ADMIN_MENU_REPORTS_NOT_ENROLLED', '', 'report_student_not_enrolled.php', 'Administrator'),
(59, 'Student on Hold', 'ADMIN_MENU_REPORTS_ON_HOLD', '', 'report_student_on_hold.php', 'Administrator'),
(60, 'Statistic Report', 'ADMIN_MENU_REPORTS_STATISTIC', '', 'report_statistic.php', 'Administrator'),
(61, 'Student Life Cycle', 'REPORT_STUDENT_LIFE_CYCLE', '', 'report_student_cycle.php', 'Administrator'),
(62, 'Management Report', 'MANAGEMENT_REPORT', '', 'report_management.php', 'Administrator'),
(63, 'Single certificate', 'SINGLE_CERTIFICATE', '', 'certificate.php', 'Administrator'),
(64, 'Multiple certificate', 'MULTIPLE_CERTIFICATE', '', 'certificate_multi.php', 'Administrator'),
(65, 'My Account', 'ADMIN_MENU_MY_ACCOUNT', '', 'my_account.php', 'Administrator'),
(66, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Administrator'),
(67, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Administrator'),
(68, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'Center Director'),
(69, 'Enquiry', 'SA_MENU_QUICKADD', '', 'student_manage.php', 'Center Director'),
(70, 'Step-By-Step New Student', 'CD_MENU_WIZBASESTD', '', 's_age.php', 'Center Director'),
(71, 'Quick Enrollment', 'SA_MENU_CLASSIC', '', 's_classic.php', 'Center Director'),
(72, 'Action ARF Reports', 'ACTION_ARF_REPORT', '', 'arf_manage.php', 'Center Director'),
(73, 'Cancellation Request', 'CANCELLATION_REQUEST', '', 'cancel_manage.php', 'Center Director'),
(74, 'Manage On-Hold Request', 'MANAGE_ONHOLD', '', 'hold_manage.php', 'Center Director'),
(75, 'Student Information', 'STUDENT_INFORMATON', '', 'single-student.php', 'Center Director'),
(76, 'Student Services', 'MENU_STUDENT_SERVICES', '', 'search.php', 'Center Director'),
(77, 'Step-By-Step New Group', 'SA_MENU_WIZARD_BASED', '', 'group_course.php', 'Center Director'),
(78, 'Quick Add new Group', 'QUICK_ADD_GROUP', '', 'group_quick.php', 'Center Director'),
(79, 'Manage Grouping', 'SA_MENU_GROUP', '', 'group_manage.php', 'Center Director'),
(80, 'Group Sizes', 'SA_MENU_GROUP_SIZE', '', 'view_group_size.php', 'Center Director'),
(81, 'View Group History', 'ADMIN_MENU_RULE_VIEW_GROUP_HISTORY', '', 'view_group_history.php', 'Center Director'),
(82, 'Student To Student Transfer', 'SA_STUDENT_TO_STUDENT', '', 'student_to_student_manage.php', 'Center Director'),
(83, 'Student To Center Transer', 'SA_STUDENT_TO_CENTER', '', 'student_to_different_center_manage.php', 'Center Director'),
(84, 'Student from Another Center', 'DIFFERENT_CENTER', '', 'student_from_another_center_manage.php', 'Center Director'),
(85, 'Center to Center Transfer', 'SA_CENTER_CENTER', '', 'center_to_center_manage.php', 'Center Director'),
(86, 'Date Converter', 'RE_MENU_CONVERTER', '', 'calc_converter.php', 'Center Director'),
(87, 'Language Converter', '', '', 'translate.php', 'Center Director'),
(88, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert.php', 'Center Director'),
(89, 'SMS', 'ADMIN_MENU_SMS', '', 'sms.php', 'Center Director'),
(90, 'E-Mail', 'ADMIN_MENU_EMAIL', '', 'email.php', 'Center Director'),
(91, 'View in Gantt Chart', 'CD_MENU_V_GANTT', '', 'centre_schedule.php', 'Center Director'),
(92, 'View Table by Teacher', 'CD_MENU_V_TABLE_TEACHER', '', 'centre_schedule_teacher.php', 'Center Director'),
(93, 'View Table by Level', 'CD_MENU_V_TABLE_LEVEL', '', 'centre_schedule_table.php', 'Center Director'),
(94, 'View By Start Date', 'CD_MENU_V_START', '', 'centre_schedule_startdate.php', 'Center Director'),
(95, 'View By End Date', 'CD_MENU_V_END', '', 'centre_schedule_enddate.php', 'Center Director'),
(96, 'View By Date Range', 'CD_MENU_V_RANGE', '', 'centre_schedule_rangedate.php', 'Center Director'),
(97, 'Certificate Report', 'CD_MENU_CENTRE_REPORT', '', 'report_centre_director_main.php', 'Center Director'),
(98, 'Group Progress Report', 'CD_MENU_GROUP_PROGRESS_REPORT', '', 'report_group_progress.php', 'Center Director'),
(99, 'Personal Progress Report', 'CD_MENU_PERSONAL_PROGRESS_REPORT', '', 'report_teacher_progress.php', 'Center Director'),
(100, 'Epedcard', 'TE_MENU_EPEDCARD', '', 'ped.php', 'Center Director'),
(101, 'By-Teacher Groups', 'ADMIN_MENU_REPORTS_BOARD', '', 'report_teacher_board.php', 'Center Director'),
(102, 'Teacher(s) Schedule', 'ADMIN_MENU_REPORTS_SCHEDULE', '', 'report_teacher_schedule.php', 'Center Director'),
(103, 'Students awaiting a Course', 'ADMIN_MENU_REPORTS_AWAIT', '', 'report_student_awaiting.php', 'Center Director'),
(104, 'Group to finish', 'ADMIN_MENU_REPORTS_FINISH', '', 'report_group_to_finish.php', 'Center Director'),
(105, 'Certificates not Collected', 'ADMIN_MENU_REPORTS_COLLECT', '', 'report_certificate_not_collect.php', 'Center Director'),
(106, 'Student Absense Report', 'ADMIN_MENU_REPORTS_ABSENT', '', 'report_absent_report.php', 'Center Director'),
(107, 'Teacher Leave Report', 'ADMIN_MENU_REPORTS_TEACHER_LEAVE', '', 'report_teacher_leave_report.php', 'Center Director'),
(108, 'Teacher overtime Report', 'ADMIN_MENU_REPORTS_TEACHER_OVER', '', 'report_teacher_overtime_report.php', 'Center Director'),
(109, 'Teacher Capacity', 'ADMIN_MENU_REPORTS_TEACHER_CAPACITY', '', 'report_teacher_capacity.php', 'Center Director'),
(110, 'Students Results', 'ADMIN_MENU_REPORTS_SUMMARY', '', 'report_certificate_report.php', 'Center Director'),
(111, 'VIP Students', 'ADMIN_MENU_REPORTS_CUSTOMER', '', 'report_freq_customer_report.php', 'Center Director'),
(112, 'Detailed Students Results', 'ADMIN_MENU_REPORTS_GROUP_GRADE', '', 'report_student_group_grade.php', 'Center Director'),
(113, 'Students Statuses', 'ADMIN_MENU_REPORTS_NOT_ENROLLED', '', 'report_student_not_enrolled.php', 'Center Director'),
(114, 'Student on Hold', 'ADMIN_MENU_REPORTS_ON_HOLD', '', 'report_student_on_hold.php', 'Center Director'),
(115, 'Statistic Report', 'CD_MENU_STATISTIC_REPORT', '', 'report_statistic.php', 'Center Director'),
(116, 'Students Comments History', 'ADMIN_MENU_RULE_VIEW_COMMENT_HISTORY', '', 'view_student_comments_history.php', 'Center Director'),
(117, 'Manage SMS History', 'ADMIN_MENU_SMS_HISTORY', '', 'manage_sms_history.php', 'Center Director'),
(118, 'Managegement Report', 'MANAGEMENT_REPORT', '', 'report_management.php', 'Center Director'),
(119, 'Student Lie Cycle', 'REPORT_STUDENT_LIFE_CYCLE', '', 'report_student_cycle.php', 'Center Director'),
(120, 'Removing student from group', 'CD_MENU_REMOVE', '', 'ep_removing_student.php', 'Center Director'),
(121, 'Scheduling of a make up class', 'CD_MENU_SCHEDULING', '', 'ep_scheduling_manage.php', 'Center Director'),
(122, 'Change a classroom', 'CD_MENU_CHANGE', '', 'ep_change_classroom.php', 'Center Director'),
(123, 'Addition of student to a group', 'CD_MENU_ADDITION', '', 'ep_adding_student.php', 'Center Director'),
(124, 'Cancellation of Class', 'CD_MENU_CANCEL', '', 'ep_class_cancel_manage.php', 'Center Director'),
(125, 'Centre Vacation', 'ADMIN_MENU_VAC_CENTRE', '', 'vacation_center_manage.php', 'Center Director'),
(126, 'Exam Vacation', 'ADMIN_MENU_VAC_EXAM', '', 'vacation_exam_manage.php', 'Center Director'),
(127, 'Teacher Vacation', 'ADMIN_MENU_VAC_TEACHER', '', 'vacation_teacher_manage.php', 'Center Director'),
(128, 'Manage Sick Leave', 'CD_MENU_MANAGE_SICK_LEAVE', '', 'sick_leave_manage.php', 'Center Director'),
(129, 'Single Certificate', 'SINGLE_CERTIFICATE', '', 'certificate.php', 'Center Director'),
(130, 'Multiple Certificate', 'MULTIPLE_CERTIFICATE', '', 'certificate_multi.php', 'Center Director'),
(131, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Center Director'),
(132, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Center Director'),
(133, 'Students Credentials', 'STUDENT_CREDENT', '', 'user_manage.php', 'Center Director'),
(134, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'Student Advisor'),
(135, 'Enquiry', 'SA_MENU_QUICKADD', '', 'student_manage.php', 'Student Advisor'),
(136, 'Step-By-Step New Student', 'CD_MENU_WIZBASESTD', '', 's_age.php', 'Student Advisor'),
(137, 'Quick Enrollment', 'SA_MENU_CLASSIC', '', 's_classic.php', 'Student Advisor'),
(138, 'Manage Student Appointment', 'SA_MENU_APPOINT', '', 'student_appoint_manage.php', 'Student Advisor'),
(139, 'Action ARF Reports', 'ACTION_ARF_REPORT', '', 'arf_manage.php', 'Student Advisor'),
(140, 'Cancellation Request', 'CANCELLATION_REQUEST', '', 'cancel_manage.php', 'Student Advisor'),
(141, 'Manage On-Hold Request', 'MANAGE_ONHOLD', '', 'hold_manage.php', 'Student Advisor'),
(142, 'Student Information', 'STUDENT_INFORMATON', '', 'single-student.php', 'Student Advisor'),
(143, 'Student Services', 'MENU_STUDENT_SERVICES', '', 'search.php', 'Student Advisor'),
(144, 'Step-By-Step New Group', 'SA_MENU_WIZARD_BASED', '', 'group_course.php', 'Student Advisor'),
(145, 'Quick Add New Group', 'QUICK_ADD_GROUP', '', 'group_quick.php', 'Student Advisor'),
(146, 'Manage Grouping', 'SA_MENU_GROUP', '', 'group_manage.php', 'Student Advisor'),
(147, 'Group Sizes', 'SA_MENU_GROUP_SIZE', '', 'view_group_size.php', 'Student Advisor'),
(148, 'Student To Student Transfer', 'SA_STUDENT_TO_STUDENT', '', 'student_to_student_manage.php', 'Student Advisor'),
(149, 'Student To Center Transfer', 'SA_STUDENT_TO_CENTER', '', 's-to-s-different-center-manage.php', 'Student Advisor'),
(150, 'Center To Center Transfer', 'SA_CENTER_CENTER', '', 'center_to_center_manage.php', 'Student Advisor'),
(151, 'By-Teacher Groups', 'ADMIN_MENU_REPORTS_BOARD', '', 'report_teacher_board.php', 'Student Advisor'),
(152, 'Teacher(s) Schedule', 'ADMIN_MENU_REPORTS_SCHEDULE', '', 'report_teacher_schedule.php', 'Student Advisor'),
(153, 'Students awaiting a course', 'ADMIN_MENU_REPORTS_AWAIT', '', 'report_student_awaiting.php', 'Student Advisor'),
(154, 'Groups to Finish', 'ADMIN_MENU_REPORTS_FINISH', '', 'report_group_to_finish.php', 'Student Advisor'),
(155, 'Certficates not collected', 'ADMIN_MENU_REPORTS_COLLECT', '', 'report_certificate_not_collect.php', 'Student Advisor'),
(156, 'Student Absense Report', 'ADMIN_MENU_REPORTS_ABSENT', '', 'report_absent_report.php', 'Student Advisor'),
(157, 'Teacher Leave Report', 'ADMIN_MENU_REPORTS_TEACHER_LEAVE', '', 'report_teacher_leave_report.php', 'Student Advisor'),
(158, 'Teacher Capacity', 'ADMIN_MENU_REPORTS_TEACHER_CAPACITY', '', 'report_teacher_capacity.php', 'Student Advisor'),
(159, 'Students Results', 'ADMIN_MENU_REPORTS_SUMMARY', '', 'report_certificate_report.php', 'Student Advisor'),
(160, 'VIP Students', 'ADMIN_MENU_REPORTS_CUSTOMER', '', 'report_freq_customer_report.php', 'Student Advisor'),
(161, 'Detailed Students Results', 'ADMIN_MENU_REPORTS_GROUP_GRADE', '', 'report_student_group_grade.php', 'Student Advisor'),
(162, 'Students Statuses', 'ADMIN_MENU_REPORTS_NOT_ENROLLED', '', 'report_student_not_enrolled.php', 'Student Advisor'),
(163, 'Students on Hold', 'ADMIN_MENU_REPORTS_ON_HOLD', '', 'report_student_on_hold.php', 'Student Advisor'),
(164, 'Students Comments History', 'ADMIN_MENU_RULE_VIEW_COMMENT_HISTORY', '', 'view_student_comments_history.php', 'Student Advisor'),
(165, 'Student Life Cycle', 'REPORT_STUDENT_LIFE_CYCLE', '', 'report_student_cycle.php', 'Student Advisor'),
(166, 'Date Converter', 'STUDENT_CALC_CONVERTER_DATA_CONVERTER', '', 'calc_converter.php', 'Student Advisor'),
(167, 'Language Converter', 'ADMIN_MENU_LANGUAGE_CONVERTER', '', 'translate.php', 'Student Advisor'),
(168, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert.php', 'Student Advisor'),
(169, 'SMS', 'ADMIN_MENU_SMS', '', 'sms.php', 'Student Advisor'),
(170, 'E-Mail', 'ADMIN_MENU_EMAIL', '', 'email.php', 'Student Advisor'),
(171, 'Centre Schedule', 'RE_MENU_CS', '', 'centre_schedule.php', 'Student Advisor'),
(172, 'Epedcard', 'TE_MENU_EPEDCARD', '', 'ped.php', 'Student Advisor'),
(173, 'Progress Reports [Multi]', 'SINGLE_GROUP', '', 'report_group_progress.php', 'Student Advisor'),
(174, 'Progress Reports [Student]', 'STUDENT_WISE', '', 'report_teacher_progress.php', 'Student Advisor'),
(175, 'Single Certificate', 'SINGLE_CERTIFICATE', '', 'certificate.php', 'Student Advisor'),
(176, 'Multiple Certificate', 'MULTIPLE_CERTIFICATE', '', 'certificate_multi.php', 'Student Advisor'),
(177, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Student Advisor'),
(178, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Student Advisor'),
(179, 'Students Credentials', 'STUDENT_CREDENT', '', 'user_manage.php', 'Student Advisor'),
(180, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'Teacher'),
(181, 'My Groups', 'TE_MENU_MY_GROUP', '', 'my_groups.php', 'Teacher'),
(182, 'My Schedules', 'TE_MENU_MY_SCHEDULE', '', 'my_schedules.php', 'Teacher'),
(183, 'ePEDCARD', 'TE_MENU_EPEDCARD', '', 'ped.php', 'Teacher'),
(184, 'Progress Reports', 'TE_MENU_PR', '', 'report_teacher_progress.php', 'Teacher'),
(185, 'Certificate Reports', 'TE_MENU_CR', '', 'report_center_director.php', 'Teacher'),
(186, 'ARF', 'RE_MENU_ARF', '', 'arf_manage.php', 'Teacher'),
(187, 'Sick Leave', 'TE_MENU_SL', '', 'manage_sick_leave.php', 'Teacher'),
(188, 'Date Converter', 'STUDENT_CALC_CONVERTER_DATA_CONVERTER', '', 'calc_converter.php', 'Teacher'),
(189, 'Language Converter', 'ADMIN_MENU_LANGUAGE_CONVERTER', '', 'translate.php', 'Teacher'),
(190, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert.php', 'Teacher'),
(191, 'Student Absence Report', 'ADMIN_MENU_REPORTS_ABSENT', '', 'report_absent_report.php', 'Teacher'),
(192, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Teacher'),
(193, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Teacher'),
(194, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'Receptionist'),
(195, 'Students Appointment', 'RE_MENU_APP', '', 'student_appoint_manage.php', 'Receptionist'),
(196, 'Student Services', 'MENU_STUDENT_SERVICES', '', 'search.php', 'Receptionist'),
(197, 'Groups', 'RE_MENU_GROUPS', '', 'group_manage.php', 'Receptionist'),
(198, 'By-Teacher Groups', 'ADMIN_MENU_REPORTS_BOARD', '', 'report_teacher_board.php', 'Receptionist'),
(199, 'Teacher(s) Schedule', 'ADMIN_MENU_REPORTS_SCHEDULE', '', 'report_teacher_schedule.php', 'Receptionist'),
(200, 'Students awaiting a course', 'ADMIN_MENU_REPORTS_AWAIT', '', 'report_student_awaiting.php', 'Receptionist'),
(201, 'Groups to finish', 'ADMIN_MENU_REPORTS_FINISH', '', 'report_group_to_finish.php', 'Receptionist'),
(202, 'Certificate not collected', 'ADMIN_MENU_REPORTS_COLLECT', '', 'report_certificate_not_collect.php', 'Receptionist'),
(203, 'Student Absence Report', 'ADMIN_MENU_REPORTS_ABSENT', '', 'report_absent_report.php', 'Receptionist'),
(204, 'Date Converter', 'STUDENT_CALC_CONVERTER_DATA_CONVERTER', '', 'calc_converter.php', 'Receptionist'),
(205, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert.php', 'Receptionist'),
(206, 'SMS', 'ADMIN_MENU_SMS', '', 'sms.php', 'Receptionist'),
(207, 'E-Mail', 'ADMIN_MENU_EMAIL', '', 'email.php', 'Receptionist'),
(208, 'Centre Schedule', 'RE_MENU_CS', '', 'centre_schedule.php', 'Receptionist'),
(209, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Receptionist'),
(210, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Receptionist'),
(211, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'Accountant'),
(212, 'Type of Payment', 'ADMIN_MENU_TYPEOFPAYMENT', '', 'payment_manage.php', 'Accountant'),
(213, 'Receipts Terms And Condition', 'ADMIN_MENU_RECEIPT', '', 'challan_cond.php', 'Accountant'),
(214, 'Invoice Terms And Condition', 'ADMIN_MENU_INVOICE', '', 'invoice_cond.php', 'Accountant'),
(215, 'Move to Bed Debt', 'AC_MOVETO_BED_DEBT', '', 'move_to_beddebt.php', 'Accountant'),
(216, 'Audit Data', 'STUDENT_AUDITDATA', '', 'audit_history.php', 'Accountant'),
(217, 'Payment History', 'STUDENT_MYACCOUNT_PAYMENTHISTORY', '', 'payment_history.php', 'Accountant'),
(218, 'Teacher Vacation', 'ADMIN_MENU_VAC_TEACHER', '', 'vacation_teacher_manage.php', 'Accountant'),
(219, 'Manage Sick Leave', 'CD_MENU_MANAGE_SICK_LEAVE', '', 'sick_leave_manage.php', 'Accountant'),
(220, 'Student Details', 'ADMIN_REPORT_STUDENT_GROUP_GRADE_STUDENTDETAILS', '', 'search.php', 'Accountant'),
(221, 'Cancellation Request', 'CANCELLATION_REQUEST', '', 'cancel_manage.php', 'Accountant'),
(222, 'Course', 'ADMIN_MENU_COURSE', '', 'course_manage.php', 'Accountant'),
(223, 'Student To Student Transfer', 'SA_STUDENT_TO_STUDENT', '', 'student_to_student_manage.php', 'Accountant'),
(224, 'Center To Center Transfer', 'SA_CENTER_CENTER', '', 'center_to_center_manage.php', 'Accountant'),
(225, 'Single Certificate', 'SINGLE_CERTIFICATE', '', 'certificate.php', 'Accountant'),
(226, 'Multiple Certificate', 'MULTIPLE_CERTIFICATE', '', 'certificate_multi.php', 'Accountant'),
(227, 'Date Converter', 'RE_MENU_CONVERTER', '', 'calc_converter.php', 'Accountant'),
(228, 'Alerts', '', '', 'alert.php', 'Accountant'),
(229, 'News', '', '', 'news_manage.php', 'Accountant'),
(230, 'SMS', 'ADMIN_MENU_SMS', '', 'sms.php', 'Accountant'),
(231, 'E-Mail', 'ADMIN_MENU_EMAIL', '', 'email.php', 'Accountant'),
(232, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Accountant'),
(233, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Accountant'),
(234, 'Students Transactions', 'ACCOUNTANT_TRANS', '', 'report_transaction.php', 'Accountant'),
(235, 'Students Ledger', 'ACCOUNTANT_STUDENT_LEDGER', '', 'report_student_ledger_search.php', 'Accountant'),
(236, 'Group Ledger', 'ACCOUNTANT_GROUP_LEDGER', '', 'report_group_ledger.php', 'Accountant'),
(237, 'Discounts Reports', 'ACCOUNTANT_DISCOUNTS', '', 'report_discount.php', 'Accountant'),
(238, 'Transfer (Center To Center)', 'ACCOUNTANT_CE_CE', '', 'report_center_to_center.php', 'Accountant'),
(239, 'Transfer (Student To Student)', 'SA_STUDENT_TO_CENTER', '', 'student_to_different_center_manage.php', 'Accountant'),
(240, 'Transfer (Same Center)', 'ACCOUNTANT_ST_CE', '', 'report_student_to_center.php', 'Accountant'),
(241, 'Enrollment and Re-enrollment', 'ACCOUNTANT_EN_RE', '', 'report_enrolled.php', 'Accountant'),
(242, 'Sales Summary', 'ACCOUNTANT_SUMMERY', '', 'report_sales_summary.php', 'Accountant'),
(243, 'Student Overdue', 'ACCOUNTANT_OVERDUE', '', 'report_overdue.php', 'Accountant'),
(244, 'Bad Debt Report', 'ACCOUNTANT_BADDEBT', '', 'report_baddebt.php', 'Accountant'),
(245, 'Students on credit balance', 'ACCOUNTANT_CREDIT', '', 'report_credit_balance.php', 'Accountant'),
(246, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'LIS'),
(247, 'Student Services', 'MENU_STUDENT_SERVICES', '', 'search.php', 'LIS'),
(248, 'Single Certificate', 'SINGLE_CERTIFICATE', '', 'certificate.php', 'LIS'),
(249, 'Multiple Certificate', 'MULTIPLE_CERTIFICATE', '', 'certificate_multi.php', 'LIS'),
(250, 'ePEDCARD', 'TE_MENU_EPEDCARD', '', 'ped.php', 'LIS'),
(251, 'Progress Reports', 'TE_MENU_PR', '', 'report_teacher_progress.php', 'LIS'),
(252, 'Teacher Vacation', 'ADMIN_MENU_VAC_TEACHER', '', 'vacation_teacher_manage.php', 'LIS'),
(253, 'Manage Sick Leave', 'CD_MENU_MANAGE_SICK_LEAVE', '', 'sick_leave_manage.php', 'LIS'),
(254, 'Date Converter', 'STUDENT_CALC_CONVERTER_DATA_CONVERTER', '', 'calc_converter.php', 'LIS'),
(255, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert1_manage.php', 'LIS'),
(256, 'News', 'ADMIN_MENU_NEWS', '', 'news_manage.php', 'LIS'),
(257, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'LIS'),
(258, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'LIS'),
(259, 'Units taught', 'LIS_UNITS_TAUGHT', '', 'report_unit_taught.php', 'LIS'),
(260, 'ePedCard Student Statuses', 'LIS_EPED_STATUS', '', 'report_eped_status.php', 'LIS'),
(261, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'LIS Manager'),
(262, 'Student Services', 'MENU_STUDENT_SERVICES', '', 'search.php', 'LIS Manager'),
(263, 'Single Certificate', 'SINGLE_CERTIFICATE', '', 'certificate.php', 'LIS Manager'),
(264, 'Multiple Certificate', 'MULTIPLE_CERTIFICATE', '', 'certificate_multi.php', 'LIS Manager'),
(265, 'ePEDCARD', 'TE_MENU_EPEDCARD', '', 'ped.php', 'LIS Manager'),
(266, 'Progress Reports', 'TE_MENU_PR', '', 'report_teacher_progress.php', 'LIS Manager'),
(267, 'Teacher Vacation', 'ADMIN_MENU_VAC_TEACHER', '', 'vacation_teacher_manage.php', 'LIS Manager'),
(268, 'Users', 'ADMIN_MENU_USERS', '', 'user_manage.php', 'LIS Manager'),
(269, 'Date Converter', 'STUDENT_CALC_CONVERTER_DATA_CONVERTER', '', 'calc_converter.php', 'LIS Manager'),
(270, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert1_manage.php', 'LIS Manager'),
(271, 'News', 'ADMIN_MENU_NEWS', '', 'news_manage.php', 'LIS Manager'),
(272, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'LIS Manager'),
(273, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'LIS Manager'),
(274, 'Sick/Leave Days', 'LIS_SICK_LEAVE', '', 'report_sick_leave.php', 'LIS Manager'),
(275, 'Outstanding Approval', 'LIS_OUT_APP', '', 'report_outstanding.php', 'LIS Manager'),
(276, 'Missed ePedcard Alert', 'LISM_MISSED_EPED', '', 'report_missed_eped.php', 'LIS Manager'),
(277, 'Missed Progress Report', 'LISM_MISSED_PROGRESS', '', 'report_missed_progress.php', 'LIS Manager'),
(278, 'Missed Certificate Alert', 'LISM_MISSED_CERTIFICATE', '', 'report_missed_certificate.php', 'LIS Manager'),
(279, 'Management Report', 'MANAGEMENT_REPORT', '', 'report_management.php', 'LIS Manager'),
(280, 'Home', 'ADMIN_MENU_HOME', '', 'home.php', 'Student'),
(281, 'My Schedules', 'STUDENT_MENU_MY_SCHEDULE', '', 'myschedule.php', 'Student'),
(282, 'My Account', 'ADMIN_MENU_MY_ACCOUNT', '', 'myaccount.php', 'Student'),
(283, 'Audit Data', 'STUDENT_AUDITDATA', '', 'audit.php', 'Student'),
(284, 'My Progress Report', 'STUDENT_MENU_MY_PROGRESS', '', 'progress_report.php', 'Student'),
(285, 'Certificate Grade', 'STUDENT_MENU_CERTIFICATE_GRADES', '', 'certificate_report.php', 'Student'),
(286, 'Date Converter', 'STUDENT_MENU_DATE_CONVERTER', '', 'calc_converter.php', 'Student'),
(287, 'Alerts', 'ADMIN_MENU_ALERTS', '', 'alert.php', 'Student'),
(288, 'Leave', 'STUDENT_MENU_LEAVE', '', 'leave_manage.php', 'Student'),
(289, 'Change Password', 'ADMIN_MENU_CHANGE_PASSWORD', '', 'password.php', 'Student'),
(290, 'Quick Links', 'ADMIN_MENU_QUICK_LINKS', '', 'quicklink_manage.php', 'Student'),
(291, 'SMS Gateway Configuration', 'ADMIN_SMS_GATEWAY_MANAGE_SMSGATEWAYCONFIGURATION', '', 'sms_allowed.php', 'Student'),
(292, 'Student Type', 'REPORT_STUDENT_TYPE', '', 'report_student_type.php', 'Student Advisor');

-- --------------------------------------------------------

--
-- Table structure for table `sick_leave`
--

CREATE TABLE IF NOT EXISTS `sick_leave` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `sick_reason` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `sick_attachment` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `sick_notes` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `sick_status` tinyint(4) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sick_leave`
--

INSERT INTO `sick_leave` (`id`, `teacher_id`, `from_date`, `to_date`, `sick_reason`, `sick_attachment`, `sick_notes`, `sick_status`, `centre_id`) VALUES
(4, 2, '2013-12-02', '2013-12-03', 'adsada', '', 'dadad', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sick_leave_centre`
--

CREATE TABLE IF NOT EXISTS `sick_leave_centre` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sick_leave_centre`
--

INSERT INTO `sick_leave_centre` (`id`, `parent_id`, `centre_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_gateway`
--

CREATE TABLE IF NOT EXISTS `sms_gateway` (
  `user` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `your_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_gateway`
--

INSERT INTO `sms_gateway` (`user`, `password`, `mobile`, `your_name`, `status`) VALUES
('berl', 'fa', '966547378399', 'Berlitz', 'Disable');

-- --------------------------------------------------------

--
-- Table structure for table `sms_history`
--

CREATE TABLE IF NOT EXISTS `sms_history` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` datetime NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `msg` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `send_to` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `type` int(10) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `send_date` date NOT NULL,
  `msg_from` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `automatic` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `page_full_path` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126 ;

--
-- Dumping data for table `sms_history`
--

INSERT INTO `sms_history` (`id`, `dated`, `user_id`, `msg`, `send_to`, `mobile`, `type`, `centre_id`, `send_date`, `msg_from`, `automatic`, `page_full_path`) VALUES
(1, '2013-08-27 12:29:43', 0, 'Tarik Nebi has not been updated the e-PEDcard last 2 days.', 'Teacher', 'CRON - SMS', 0, 0, '0000-00-00', 'CRON', 'Yes', '/mySMS/login_process.php'),
(2, '2013-08-28 11:26:53', 0, 'Tarik Nebi has not been updated the e-PEDcard last 2 days.', 'Teacher', 'CRON - SMS', 0, 0, '0000-00-00', 'CRON', 'Yes', '/mySMS/login_process.php'),
(3, '2013-08-28 11:27:54', 0, 'Dear cd,\r\n\r\nI have some problem. I have to Leave from dated 2013-09-01 to 2013-09-02. So I will be absent for above days.\r\n\r\n\r\nThanks\r\nTeacher', 'Teacher', 'CRON - SMS', 0, 0, '0000-00-00', 'Sick Leave', 'Yes', '/mySMS/teacher/sick_process.php?action=save'),
(4, '2013-08-29 09:56:06', 126, 'Add -38 units to this group due to adding  student to a 1-student P1 group that has completed 2 units at the time of adding these  students.', 'Teacher', '00966523432423', 0, 1, '0000-00-00', 'New student adding Centre Director (Step by Step)', 'Yes', '/mySMS/sa/s1_process.php?action=insert'),
(5, '2013-08-29 11:04:58', 126, 'Add -38 units to this group due to adding  student to a 3-student P2 group that has completed 2 units at the time of adding these  students.', 'Teacher', '00966523432423', 0, 1, '0000-00-00', 'New student adding Centre Director (Step by Step)', 'Yes', '/mySMS/sa/s1_process.php?action=insert'),
(6, '2013-08-31 10:55:34', 126, 'Dear , your initial payment of 1300 has been received by Berlitz.', 'Teacher', '00966599996211', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/s1_process.php?action=invoice&student_id=9&course_id=1&schid=6'),
(7, '2013-09-01 10:08:48', 0, 'Ahmed Varachia has not been updated the e-PEDcard last 2 days.', 'Teacher', 'CRON - SMS', 0, 0, '0000-00-00', 'CRON', 'Yes', '/mySMS/login_process.php'),
(8, '2013-09-11 14:33:33', 0, 'Your course will be starting from 2013-09-11', 'student', '00966587687', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(9, '2013-09-11 14:33:34', 0, 'Your course will be starting from 2013-09-11', 'student', '009665676876', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(10, '2013-09-11 14:39:28', 0, 'Your course will be starting from 2013-09-11', 'student', '00966587687', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(11, '2013-09-11 14:39:29', 0, 'Your course will be starting from 2013-09-11', 'student', '009665676876', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(12, '2013-09-11 15:33:43', 0, 'Your course will be starting from 2013-09-11', 'student', '00966587687', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(13, '2013-09-11 15:33:44', 0, 'Your course will be starting from 2013-09-11', 'student', '009665676876', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(14, '2013-09-16 14:35:38', 126, 'Your course will be starting from 2013-10-28', 'Student', '009665', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(15, '2013-09-16 14:49:03', 126, 'Your course will be starting from 2013-10-28', 'Student', '009665', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(16, '2013-09-16 14:59:49', 126, 'Your course will be starting from 2013-10-28', 'Student', '009665', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(17, '2013-09-17 13:35:30', 126, 'Dear Ahmed, your initial payment of  has been received by Berlitz.', 'student', '0096658786', 0, 1, '0000-00-00', 'Initial Payment as Advance', 'Yes', '/mySMS/sa/s1_process.php?action=advance'),
(18, '2013-09-17 15:39:26', 0, 'Your course will be starting from 2014-09-03', 'student', '0096658786', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(19, '2013-09-18 11:17:39', 0, 'Ahmed Varachia has not been updated the e-PEDcard last 2 days.', 'Teacher', 'CRON - SMS', 0, 0, '0000-00-00', 'CRON', 'Yes', '/mySMS/login_process.php'),
(20, '2013-09-18 11:43:23', 126, 'Dear Keefe, your initial payment of  has been received by Berlitz.', 'student', '0096653425', 0, 1, '0000-00-00', 'Initial Payment as Advance', 'Yes', '/mySMS/sa/s1_process.php?action=advance'),
(21, '2013-09-18 11:43:34', 126, 'Dear Keefe, your initial payment of  has been received by Berlitz.', 'student', '0096653425', 0, 1, '0000-00-00', 'Initial Payment as Advance', 'Yes', '/mySMS/sa/s1_process.php?action=advance'),
(22, '2013-09-18 13:31:47', 0, 'Your course will be starting from 2012-09-02', 'student', '0096653425', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(23, '2013-09-18 13:39:14', 126, 'Dear Keefe, your initial payment of  has been received by Berlitz.', 'student', '0096653425', 0, 1, '0000-00-00', 'Initial Payment as Advance', 'Yes', '/mySMS/sa/s1_process.php?action=advance'),
(24, '2013-09-18 13:41:48', 126, 'Dear 1, your initial payment of  has been received by Berlitz.', 'student', '0096657777777', 0, 1, '0000-00-00', 'Initial Payment as Advance', 'Yes', '/mySMS/sa/s1_process.php?action=advance'),
(25, '2013-09-18 13:42:34', 0, 'Your course will be starting from 2013-09-18', 'student', '0096653425', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(26, '2013-09-18 13:42:35', 0, 'Your course will be starting from 2013-09-18', 'student', '009665', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(27, '2013-09-18 13:42:35', 0, 'Your course will be starting from 2013-09-18', 'student', '0096657777777', 0, 1, '0000-00-00', 'For Class Start', 'Yes', '/mySMS/sa/group_course_process.php?action=quick_add_group'),
(28, '2013-09-18 16:21:03', 126, 'Your course will be starting from 2013-09-18', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(29, '2013-09-18 16:35:47', 126, 'Your course will be starting from 2013-09-18', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(30, '2013-09-18 16:43:14', 126, 'Your course will be starting from 2013-09-18', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(31, '2013-09-18 16:48:14', 126, 'Your course will be starting from 2013-09-18', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(32, '2013-09-18 16:51:49', 126, 'Your course will be starting from 2013-09-18', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(33, '2013-09-18 17:12:27', 126, 'Your course will be starting from 2013-09-18', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(34, '2013-09-21 15:04:13', 0, 'Dear Tarik Nebi,\r\n\r\nI have some problem. I have to Leave from dated 2013-09-21 to 2013-09-22. So I will be absent for above days.\r\n\r\n\r\nThanks\r\nTeacher', 'Teacher', 'CRON - SMS', 0, 0, '0000-00-00', 'Sick Leave', 'Yes', '/mySMS/teacher/sick_process.php?action=save'),
(35, '2013-09-21 15:06:36', 125, 'Class is Cancelled', 'Student', '0096653425,009665,0096657777777,0096659098605', 0, 1, '0000-00-00', 'Centre Director (For Sick Leave Approved or Rejected)', 'Yes', '/mySMS/cd/sick_leave_process.php'),
(36, '2013-09-25 13:11:38', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(37, '2013-09-25 13:16:18', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(38, '2013-09-25 13:17:24', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096677', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(39, '2013-09-25 13:19:02', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096677', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(40, '2013-09-25 13:23:42', 126, 'Your course will be starting from 2013-09-25', 'Student', '009663', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(41, '2013-09-25 13:47:02', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(42, '2013-09-25 13:51:45', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096677', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(43, '2013-09-25 13:53:25', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096653425', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(44, '2013-09-25 13:57:20', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096677', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(45, '2013-09-25 13:57:41', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(46, '2013-09-25 14:00:28', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(47, '2013-09-25 14:02:47', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(48, '2013-09-25 14:05:04', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(49, '2013-09-25 14:07:06', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(50, '2013-09-25 14:11:09', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(51, '2013-09-25 14:11:45', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(52, '2013-09-25 14:12:43', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(53, '2013-09-25 14:15:01', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(54, '2013-09-25 14:23:51', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(55, '2013-09-25 14:27:19', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(56, '2013-09-25 14:29:29', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(57, '2013-09-25 14:33:14', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(58, '2013-09-25 14:43:35', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(59, '2013-09-25 14:56:52', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(60, '2013-09-25 14:58:56', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(61, '2013-09-25 15:02:11', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(62, '2013-09-25 15:11:54', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(63, '2013-09-25 15:31:31', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(64, '2013-09-25 15:32:22', 126, 'Your course will be starting from 2013-09-25', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(65, '2013-09-26 10:59:55', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(66, '2013-09-26 11:05:44', 126, 'Your course will be starting from 2013-09-26', 'Student', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(67, '2013-09-26 11:06:20', 126, 'Your course will be starting from 2013-09-26', 'Student', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(68, '2013-09-26 11:07:16', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=88'),
(69, '2013-09-26 11:54:58', 126, 'Your course will be starting from 2013-09-26', 'Student', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(70, '2013-09-26 11:55:39', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(71, '2013-09-26 11:55:58', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(72, '2013-09-26 12:08:43', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(73, '2013-09-26 12:16:24', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(74, '2013-09-26 12:26:24', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(75, '2013-09-26 12:27:30', 126, 'Your course will be starting from 2013-11-10', 'Student', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(76, '2013-09-26 12:28:03', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=88'),
(77, '2013-09-26 12:30:15', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(78, '2013-09-26 12:34:44', 126, 'Your course will be starting from 2013-12-23', 'Student', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(79, '2013-09-26 12:35:05', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=87'),
(80, '2013-09-26 12:35:36', 126, 'Your course will be starting from 2013-09-26', 'Student', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(81, '2013-09-29 12:42:03', 126, 'Your course will be starting from 2013-09-26', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(82, '2013-09-29 12:45:28', 126, 'Your course will be starting from 2013-09-26', 'Student', '00966442', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(83, '2013-09-29 12:51:23', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(84, '2013-09-29 12:51:37', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=94'),
(85, '2013-09-29 12:52:12', 126, 'Your course will be starting from 2013-09-29', 'Student', '009667889798', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(86, '2013-09-29 12:52:30', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '009667889798', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=93'),
(87, '2013-09-29 12:53:46', 126, 'Your course will be starting from 2013-09-29', 'Student', '009669867686', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(88, '2013-09-29 12:59:45', 126, 'Your course will be starting from 2013-09-29', 'Student', '00966564565', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(89, '2013-09-29 13:00:01', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '00966564565', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=91'),
(90, '2013-09-29 13:01:24', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '00966453435', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=89'),
(91, '2013-09-29 13:05:56', 126, 'Your course will be starting from 2013-09-29', 'Student', '00966879879', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(92, '2013-09-29 13:07:01', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=87'),
(93, '2013-09-29 13:26:56', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(94, '2013-09-29 13:27:10', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=94'),
(95, '2013-09-29 13:27:28', 126, 'Your course will be starting from 2013-09-29', 'Student', '009667889798', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(96, '2013-09-29 13:33:25', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '009667889798', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=93'),
(97, '2013-09-29 13:33:59', 126, 'Your course will be starting from 2013-09-29', 'Student', '009669867686', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(98, '2013-09-29 13:34:15', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '009669867686', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=92'),
(99, '2013-09-29 13:34:31', 126, 'Your course will be starting from 2013-09-29', 'Student', '00966564565', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(100, '2013-09-29 13:34:55', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '00966564565', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=91'),
(101, '2013-09-29 13:36:55', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(102, '2013-09-29 13:37:11', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096655577867', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=87'),
(103, '2013-09-29 13:37:24', 126, 'Your course will be starting from 2013-09-29', 'Student', '00966442', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(104, '2013-09-29 13:37:53', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '00966442', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=83'),
(105, '2013-09-29 13:38:28', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096654479589431', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(106, '2013-09-29 13:38:52', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096654479589431', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=80'),
(107, '2013-09-29 13:55:11', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(108, '2013-09-29 13:57:27', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(109, '2013-09-29 14:05:27', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(110, '2013-09-29 14:07:59', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(111, '2013-09-29 14:35:53', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(112, '2013-09-29 14:38:29', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(113, '2013-09-29 14:53:46', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(114, '2013-09-29 14:55:09', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(115, '2013-09-29 14:58:40', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(116, '2013-09-29 15:01:07', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(117, '2013-09-29 15:02:41', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(118, '2013-09-29 15:10:49', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(119, '2013-09-29 15:12:19', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(120, '2013-09-29 15:14:05', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(121, '2013-09-29 15:17:22', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(122, '2013-09-29 15:19:55', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(123, '2013-09-29 15:23:28', 126, 'Your course will be starting from 2013-09-29', 'Student', '0096659098605', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(124, '2013-09-30 13:03:50', 126, 'Your course will be starting from 2013-09-30', 'Student', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_adding_group_process.php'),
(125, '2013-09-30 13:04:04', 126, 'Dear , your initial payment of  has been received by Berlitz.', 'Teacher', '0096698', 0, 1, '0000-00-00', 'New student adding Student Advisor (Search)', 'Yes', '/mySMS/sa/search_manage_mail_process.php?student_id=94');

-- --------------------------------------------------------

--
-- Table structure for table `sms_history_dtls`
--

CREATE TABLE IF NOT EXISTS `sms_history_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `sms_history_dtls`
--

INSERT INTO `sms_history_dtls` (`id`, `parent_id`, `student_id`) VALUES
(1, 6, 9),
(2, 8, 62),
(3, 9, 61),
(4, 10, 62),
(5, 11, 61),
(6, 12, 62),
(7, 13, 61),
(8, 17, 69),
(9, 18, 69),
(10, 20, 79),
(11, 21, 79),
(12, 22, 79),
(13, 23, 79),
(14, 24, 68),
(15, 25, 79),
(16, 26, 67),
(17, 27, 68),
(18, 35, 79),
(19, 35, 67),
(20, 35, 68),
(21, 35, 81),
(22, 68, 88),
(23, 76, 88),
(24, 79, 87),
(25, 84, 94),
(26, 86, 93),
(27, 89, 91),
(28, 90, 89),
(29, 92, 87),
(30, 94, 94),
(31, 96, 93),
(32, 98, 92),
(33, 100, 91),
(34, 102, 87),
(35, 104, 83),
(36, 106, 80),
(37, 125, 94);

-- --------------------------------------------------------

--
-- Table structure for table `sms_templete`
--

CREATE TABLE IF NOT EXISTS `sms_templete` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `contents` varchar(160) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `sms_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `sms_templete`
--

INSERT INTO `sms_templete` (`id`, `name`, `contents`, `created_datetime`, `sms_type`) VALUES
(1, 'Templete 1', 'Call me now.', '2012-02-06 18:43:06', ''),
(2, 'Templete 2', 'How about lunch ?', '2012-02-06 18:43:29', ''),
(3, 'Templete 3', 'Be right back', '2012-02-06 18:43:58', ''),
(4, 'Templete 4', 'I am busy now.', '2012-02-06 18:44:17', ''),
(5, 'Templete 5', 'Sorry !', '2012-02-06 18:44:31', ''),
(6, 'Templete 6', 'Thank you !', '2012-02-06 18:44:47', ''),
(7, 'Templete 7', 'How was the days ?', '2012-02-06 18:45:03', ''),
(8, 'Templete 8', 'Long time no see.', '2012-02-06 18:45:31', ''),
(9, 'Templete 9', 'Lots of luv !', '2012-02-06 18:45:49', ''),
(10, 'Templete 10', 'How are you ?', '2012-02-06 18:46:01', ''),
(11, 'Templete 11', 'You Exam is held on 03-02-2012.', '2012-02-06 18:47:10', ''),
(13, ' ', '%teacher% has been completed his course before 3 days. So you have to printing the certificate for the students', '2012-07-30 14:26:23', 'Dynamic'),
(14, '', 'The Course %course_name% is 50% Completed. Please filled up the Progress Report', '2012-07-30 14:37:30', 'Dynamic'),
(15, '', '%teacher% will be available on tommorrow', '2012-07-30 14:37:28', 'Dynamic'),
(16, '', 'Your course will be starting from %date%', '2012-07-30 14:42:10', 'Dynamic'),
(17, '', 'Best of luck for your exam.', '2012-07-30 14:45:44', 'Dynamic'),
(18, '', 'Dear %first_name%, your payment of %fee_amt% for Berlitz %course_name% is due today. Please expedite payment.', '2012-07-30 14:48:48', 'Dynamic'),
(19, '', 'Dear %first_name%, your payment of %fee_amt% for Berlitz %course_name% is past due. Please expedite payment or risk of further penalties.', '2012-07-30 14:59:53', 'Dynamic'),
(20, '', 'Dear %first_name%, your payment of %fee_amt% for Berlitz %course_name% is 5 days past due. Please expedite payment.', '2012-07-30 15:03:32', 'Dynamic'),
(21, '', 'Dear %first_name%, your payment of %fee_amt% for Berlitz %course_name% is due today. Please expedite payment.', '2012-07-30 15:04:36', 'Dynamic'),
(22, '', '%teacher% has been completed the course so have to printing the certificate for the students', '2012-07-30 15:13:37', 'Dynamic'),
(23, '', '%teacher% has not been updated the e-PEDcard last 2 days.', '2012-07-30 15:15:57', 'Dynamic'),
(24, '', '%teacher% will be vacation from %startdate% to %enddate%', '2012-07-30 15:19:02', 'Dynamic'),
(25, '', 'Thanks for Re-enrollment.', '2012-07-30 15:21:19', 'Dynamic'),
(26, '', 'Add %unit% units to this group due to adding a student to a %std% %grp% group that has completed %unt_fnd% units at the time of adding this student.', '2012-07-30 15:40:42', 'Dynamic'),
(27, '', 'Add %unit% units to this group due to adding %nos% student to a %std% %grp% group that has completed %ufin% units at the time of adding these %nos% students.', '2012-07-30 15:52:40', 'Dynamic'),
(28, '', 'Dear student, Your class will be start on %date%', '2012-07-30 15:56:05', 'Dynamic'),
(29, '', 'Reduce %u% units from group due to remove %nos% students from a %std% %grp% group that has completed %uf% units at the time of withdraw of these %nos% students.', '2012-07-30 16:00:36', 'Dynamic'),
(30, '', '%no_of_students% No of students waiting for this group.', '2012-07-30 16:05:12', 'Dynamic'),
(31, '', 'Dear %first_name%, your initial payment of %ad_amt% has been received by Berlitz.', '2012-07-30 16:15:52', 'Dynamic'),
(32, '', '%first_name% have a Appointment on %date%', '2012-07-30 16:20:48', 'Dynamic'),
(33, '', '%first_name% is applying for cancellaion of class', '2012-07-30 16:47:27', 'Dynamic'),
(34, '', 'You have paid %amount% for initial payment', '2012-07-30 16:55:39', 'Dynamic'),
(35, '', 'You are absent from last %at_count% days. Please get back to us with appropriate reasons.', '2012-07-30 16:57:07', 'Dynamic'),
(36, '', 'Congratulation !!! Your result is %grade_name% And you have %final_grade% percent out of 100', '2012-07-30 16:59:30', 'Dynamic'),
(37, '', 'Request for transfer from (SA) %teacher%', '2012-08-02 11:39:40', 'Dynamic'),
(39, 'Congratulations - ?????', '?????', '2012-10-30 06:50:59', ''),
(40, '', 'Classes on hold due to %teacher% vacation', '2012-10-31 00:00:00', 'Dynamic'),
(41, '', 'Classes on hold due to students request / exams etc.', '2012-10-31 00:00:00', 'Dynamic'),
(42, '', 'Classes on hold resuming ', '2012-10-31 11:25:38', 'Dynamic'),
(43, '', 'Centre Director has been %status% your request for transfer', '2012-11-14 10:37:37', 'Dynamic');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `age` bigint(100) NOT NULL,
  `guardian_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `guardian_contact` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `guardian_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `first_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `first_name1` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `student_first_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `middle_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `last_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `arabic_name` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `father_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `grandfather_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `family_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `father_name1` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `grandfather_name1` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `family_name1` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `country_id` bigint(100) NOT NULL,
  `id_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `student_id` bigint(10) NOT NULL,
  `student_mobile` varchar(14) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `alt_contact` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `studentstatus_id` bigint(100) NOT NULL,
  `student_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `certificate_collect` bigint(10) NOT NULL,
  `photo` varchar(200) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `level_complete` bigint(10) NOT NULL,
  `ob_amt` float NOT NULL,
  `discount` float NOT NULL,
  `payment_type` bigint(10) NOT NULL,
  `payment_date` date NOT NULL,
  `web` bigint(10) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  `register_date` date NOT NULL,
  `app_date` date NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `invoice_sl` bigint(100) NOT NULL,
  `invoice_no` varchar(500) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `sms_status` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `age`, `guardian_name`, `guardian_contact`, `guardian_comment`, `first_name`, `first_name1`, `student_first_name`, `middle_name`, `last_name`, `arabic_name`, `father_name`, `grandfather_name`, `family_name`, `father_name1`, `grandfather_name1`, `family_name1`, `gender`, `country_id`, `id_type`, `student_id`, `student_mobile`, `alt_contact`, `email`, `studentstatus_id`, `student_comment`, `certificate_collect`, `photo`, `level_complete`, `ob_amt`, `discount`, `payment_type`, `payment_date`, `web`, `created_datetime`, `created_by`, `last_updated`, `updated_by`, `register_date`, `app_date`, `centre_id`, `invoice_sl`, `invoice_no`, `status_id`, `group_id`, `sms_status`) VALUES
(1, 28, '', '', '', 'Don', 'Don', '', '', '', '', 'King', 'Victor', 'Rivera', 'King', 'Victor', 'Rivera', 'male', 171, 'Passport', 10161985, '00966561367402', '009665', 'don@berlitz-ksa.com', 0, 'Test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 10:14:45', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(2, 22, '', '', '', 'Carlos', 'Carlos', '', '', '', '', 'Elmer', 'Elpidio', 'Par', 'Elmer', 'Elpidio', 'Par', 'male', 171, 'Passport', 10142001, '00966532145678', '009665', 'carlos_par@yahoo.com', 0, 'test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 01:08:29', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(3, 17, '', '', '', 'Francis', 'Francis', '', '', '', '', 'Elmer', 'Elpidio', 'Par', 'Elmer', 'Elpidio', 'Par', 'male', 171, 'Passport', 10152010, '0096615151515', '009665', 'francis_par@yahoo.com', 0, 'test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 01:11:29', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(4, 26, '', '', '', 'Donald', 'Donald', '', '', '', '', 'King', 'Victor', 'Rivera', 'King', 'Victor', 'Rivera', 'male', 171, 'Passport', 12281987, '00966282828', '009665', 'donald_rivera@yahoo.com', 0, 'test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 01:13:08', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(5, 22, '', '', '', 'Denmark', 'Denmark', '', '', '', '', 'King', 'Victor', 'Rivera', 'King', 'Victor', 'Rivera', 'male', 171, 'Passport', 9171991, '00966171717', '009665', 'denmark_rivera@yahoo.com', 0, 'test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 01:14:31', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(6, 28, '', '', '', 'Rudolf', 'Rudolf', '', '', '', '', 'Chelito', 'Pingkoy', 'Arriola', 'Chelito', 'Pingkoy', 'Arriola', 'male', 171, 'Passport', 10061985, '00966060606', '009665', 'rudolf_arriola@yahoo.com', 0, 'test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 01:17:36', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(7, 28, '', '', '', 'Ryan', 'Ryan', '', '', '', '', 'Eddie', 'Murph', 'Baylin', 'Eddie', 'Murph', 'Baylin', 'male', 171, 'Passport', 11051985, '00966050505', '009665', 'ryan_baylin@yahoo.com', 0, 'Test', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-11-28 01:18:28', 126, '0000-00-00 00:00:00', 0, '2013-11-28', '2013-11-28', 1, 0, '', 0, 0, 1),
(8, 0, '', '', '', 'A', 'd', '', '', '', '', 'B', 'C', 'D', 'c', 'b', 'a', 'male', 0, 'Passport', 0, '00966123456789', '009665', '', 0, 'dadad', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-12-12 03:33:08', 126, '0000-00-00 00:00:00', 0, '2013-12-12', '2013-12-12', 1, 0, '', 0, 0, 1),
(9, 0, '', '', '', 'D', 'D', '', '', '', '', 'C', 'B', 'A', 'C', 'B', 'A', '', 0, '', 0, '0096654545455', '', '', 0, 'dsadada', 0, '', 0, 0, 0, 0, '0000-00-00', 0, '2013-12-26 09:15:45', 126, '0000-00-00 00:00:00', 0, '2013-12-26', '2013-12-26', 1, 0, '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_appointment`
--

CREATE TABLE IF NOT EXISTS `student_appointment` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `comments` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `entry_date` datetime NOT NULL,
  `status` bigint(10) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `action_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student_appointment`
--

INSERT INTO `student_appointment` (`id`, `dated`, `student_id`, `comments`, `user_id`, `entry_date`, `status`, `centre_id`, `action_status`) VALUES
(1, '2013-11-28', 1, 'Test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(2, '2013-11-28', 2, 'test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(3, '2013-11-28', 3, 'test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(4, '2013-11-28', 4, 'test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(5, '2013-11-28', 5, 'test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(6, '2013-11-28', 6, 'test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(7, '2013-11-28', 7, 'Test', 126, '0000-00-00 00:00:00', 1, 1, 0),
(8, '2013-12-12', 8, 'dadad', 126, '0000-00-00 00:00:00', 1, 1, 0),
(9, '2013-12-26', 9, 'dsadada', 126, '0000-00-00 00:00:00', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_cancel`
--

CREATE TABLE IF NOT EXISTS `student_cancel` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(50) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_dated` date NOT NULL,
  `admin_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `admin_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `admin_dated` date NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `student_cancel`
--

INSERT INTO `student_cancel` (`id`, `dated`, `student_id`, `course_id`, `centre_id`, `comment`, `cd_status`, `cd_comment`, `cd_dated`, `admin_status`, `admin_comment`, `admin_dated`, `created_date`, `created_by`) VALUES
(1, '2013-12-05', 1, 1, 1, 'dsadas', 'Approved', 'dadasd', '2013-12-05', 'Approved', 'dsadas', '2013-12-05', '2013-12-05', 126);

-- --------------------------------------------------------

--
-- Table structure for table `student_certificate`
--

CREATE TABLE IF NOT EXISTS `student_certificate` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `date_time` datetime NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `print_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_comment`
--

CREATE TABLE IF NOT EXISTS `student_comment` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `comments` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `student_comment`
--

INSERT INTO `student_comment` (`id`, `student_id`, `user_id`, `comments`, `date_time`, `status_id`) VALUES
(1, 1, 126, 'Test', '2013-11-28 10:14:45', 1),
(2, 2, 126, 'test', '2013-11-28 01:08:29', 1),
(3, 3, 126, 'test', '2013-11-28 01:11:29', 1),
(4, 4, 126, 'test', '2013-11-28 01:13:08', 1),
(5, 5, 126, 'test', '2013-11-28 01:14:31', 1),
(6, 6, 126, 'test', '2013-11-28 01:17:36', 1),
(7, 7, 126, 'Test', '2013-11-28 01:18:28', 1),
(8, 1, 126, 'Payment', '2013-11-28 01:11:27', 0),
(9, 2, 126, 'Payment', '2013-11-28 01:11:11', 0),
(10, 1, 126, 'Payment Second', '2013-11-28 02:11:35', 0),
(11, 2, 126, 'level 2 pay 2', '2013-11-28 03:11:25', 0),
(12, 2, 126, '2nd pay', '2013-11-28 03:11:12', 0),
(13, 1, 126, '2nd pay', '2013-11-28 03:11:39', 0),
(14, 3, 126, 'dsadad', '2013-11-28 04:11:40', 0),
(15, 3, 126, 'dsada', '2013-11-28 04:11:58', 0),
(16, 3, 126, '210', '2013-11-28 04:11:25', 0),
(17, 2, 126, 'deadasd', '2013-11-28 04:11:27', 0),
(18, 1, 126, 'dsadasd', '2013-12-03 14:57:21', 0),
(19, 1, 126, 'fsfsdfds', '2013-12-03 03:04:18', 1),
(20, 1, 126, 'dsadada', '2013-12-04 01:45:12', 1),
(21, 1, 125, 'fdfdsfsf', '2013-12-04 01:47:26', 1),
(22, 1, 126, 'dsadad', '2013-12-04 03:51:10', 1),
(23, 1, 125, 'fdsffs', '2013-12-04 03:53:03', 1),
(24, 1, 1, 'dsadadada', '2013-12-04 03:54:20', 1),
(25, 2, 126, 'fffff', '2013-12-04 15:57:48', 0),
(26, 2, 125, 'dsadsdsa', '2013-12-04 03:59:49', 1),
(27, 2, 126, 'dasdadad', '2013-12-05 13:59:38', 0),
(28, 2, 125, 'dadadad', '2013-12-05 02:00:51', 1),
(29, 1, 126, 'dsadada', '2013-12-05 14:16:04', 0),
(30, 1, 125, 'dadsad', '2013-12-05 02:16:30', 1),
(31, 1, 126, 'fdsfsf', '2013-12-05 02:43:12', 1),
(32, 1, 125, 'dsada', '2013-12-05 02:43:36', 1),
(33, 1, 1, 'dadad', '2013-12-05 02:44:14', 1),
(34, 1, 126, 'dadad', '2013-12-05 03:13:43', 1),
(35, 1, 125, 'dasdada', '2013-12-05 03:14:15', 1),
(36, 1, 1, 'dadada', '2013-12-05 03:17:52', 1),
(37, 1, 126, 'dsadad', '2013-12-05 04:19:39', 1),
(38, 1, 125, 'dsadad', '2013-12-05 04:20:05', 1),
(39, 1, 1, 'dadsad', '2013-12-05 04:20:28', 1),
(40, 2, 126, 'dasad', '2013-12-05 04:33:39', 1),
(41, 2, 125, 'dsadsa', '2013-12-05 04:34:02', 1),
(42, 2, 1, 'dadad', '2013-12-05 04:34:25', 1),
(43, 2, 1, 'dadad', '2013-12-05 04:38:15', 1),
(44, 1, 126, 'dsadas', '2013-12-05 04:44:29', 1),
(45, 1, 125, 'dadasd', '2013-12-05 04:44:53', 1),
(46, 1, 1, 'dsadas', '2013-12-05 04:45:26', 1),
(47, 8, 126, 'dadad', '2013-12-12 03:33:08', 1),
(48, 9, 126, 'dsadada', '2013-12-26 09:15:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `student_id`, `course_id`) VALUES
(1, 7, 1),
(4, 6, 1),
(5, 5, 1),
(6, 4, 1),
(7, 3, 1),
(12, 2, 1),
(10, 1, 1),
(11, 1, 2),
(13, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll`
--

CREATE TABLE IF NOT EXISTS `student_enroll` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `certificate_collect` bigint(10) NOT NULL,
  `level_complete` bigint(10) NOT NULL,
  `ob_amt` float NOT NULL,
  `discount` float NOT NULL,
  `other_amt` float NOT NULL,
  `payment_type` bigint(10) NOT NULL,
  `payment_date` date NOT NULL,
  `beddebt_amt` decimal(10,0) NOT NULL,
  `beddebt_date` date NOT NULL,
  `web` bigint(10) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `invoice_sl` bigint(100) NOT NULL,
  `invoice_no` varchar(500) NOT NULL,
  `prev_invoice_no` varchar(100) NOT NULL,
  `status_id` int(11) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `fee_id` bigint(100) NOT NULL,
  `course_fee` float NOT NULL,
  `created_by` bigint(100) NOT NULL,
  `enroll_date` date NOT NULL,
  `othertext` varchar(250) NOT NULL,
  `invoice_note` longtext NOT NULL,
  `balance_status_for_sms` bigint(10) NOT NULL,
  `page_full_path` longtext NOT NULL,
  `tr_ob_amt` float NOT NULL,
  `tr_discount` float NOT NULL,
  `tr_other_amt` float NOT NULL,
  `enrolled_status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student_enroll`
--

INSERT INTO `student_enroll` (`id`, `student_id`, `certificate_collect`, `level_complete`, `ob_amt`, `discount`, `other_amt`, `payment_type`, `payment_date`, `beddebt_amt`, `beddebt_date`, `web`, `centre_id`, `invoice_sl`, `invoice_no`, `prev_invoice_no`, `status_id`, `group_id`, `course_id`, `fee_id`, `course_fee`, `created_by`, `enroll_date`, `othertext`, `invoice_note`, `balance_status_for_sms`, `page_full_path`, `tr_ob_amt`, `tr_discount`, `tr_other_amt`, `enrolled_status`) VALUES
(1, 1, 0, 0, 0, 0, 0, 60, '0000-00-00', '0', '0000-00-00', 0, 1, 0, '', '', 7, 1, 1, 1, 0, 126, '2013-12-05', '', 'dsaa', 0, '/mySMS/sa/search_adding_group_process.php', 0, 0, 0, 'New Enrollment'),
(2, 2, 0, 0, 0, 0, 0, 60, '0000-00-00', '0', '0000-00-00', 0, 1, 0, '', '', 5, 1, 1, 1, 0, 126, '2013-12-05', '', 'dsada', 0, '/mySMS/sa/search_adding_group_process.php', 0, 0, 0, 'New Enrollment');

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE IF NOT EXISTS `student_fees` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `fee_date` date NOT NULL,
  `fee_amt` float NOT NULL,
  `paid_date` date NOT NULL,
  `payment_type` bigint(100) NOT NULL,
  `paid_amt` float NOT NULL,
  `status` bigint(10) NOT NULL,
  `comments` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `invoice_sl` varchar(100) DEFAULT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`id`, `student_id`, `fee_date`, `fee_amt`, `paid_date`, `payment_type`, `paid_amt`, `status`, `comments`, `course_id`, `centre_id`, `invoice_sl`, `invoice_no`, `type`, `created_date`, `created_by`) VALUES
(1, 1, '2013-12-05', 100, '2013-12-05', 60, 100, 1, 'dsaa', 1, 1, '01BE100001', '13120100001', 'cancelled student', '2013-12-05 16:43:30', 126),
(2, 2, '2013-12-05', 200, '2013-12-05', 60, 200, 1, 'dsada', 1, 1, '02BE100002', '13120100002', 'opening', '2013-12-05 16:44:05', 126);

-- --------------------------------------------------------

--
-- Table structure for table `student_fee_edit_history`
--

CREATE TABLE IF NOT EXISTS `student_fee_edit_history` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `fld_name` varchar(250) NOT NULL,
  `chg_from` varchar(250) NOT NULL,
  `chg_to` varchar(250) NOT NULL,
  `by_user` bigint(20) NOT NULL,
  `date_time` datetime NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `student_fee_edit_history`
--

INSERT INTO `student_fee_edit_history` (`id`, `fld_name`, `chg_from`, `chg_to`, `by_user`, `date_time`, `student_id`, `centre_id`, `create_date`) VALUES
(1, 'Payment Type', '', '', 126, '2013-12-05 04:12:34', 1, 1, '0000-00-00'),
(2, 'Payment Type', '', '', 126, '2013-12-05 04:12:14', 2, 1, '0000-00-00'),
(3, 'Payment Type', '', '', 126, '2013-12-05 04:12:30', 1, 1, '0000-00-00'),
(4, 'Payment Type', '', '', 126, '2013-12-05 04:12:05', 2, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `student_group`
--

CREATE TABLE IF NOT EXISTS `student_group` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(100) NOT NULL,
  `group_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `teacher_id` bigint(100) NOT NULL,
  `units` bigint(100) NOT NULL,
  `unit_per_day` int(2) NOT NULL,
  `week_no` bigint(100) NOT NULL,
  `dated` date NOT NULL,
  `teacher_date` date NOT NULL,
  `teacher_time` time NOT NULL,
  `teacher_endtime` time NOT NULL,
  `room_id` int(11) NOT NULL,
  `status` enum('Not Started','Continue','Completed') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `group_time` varchar(100) NOT NULL,
  `group_time_end` varchar(100) NOT NULL,
  `group_start_time` varchar(100) NOT NULL,
  `group_end_time` varchar(100) NOT NULL,
  `completed_date` date NOT NULL,
  `sa_id` bigint(100) NOT NULL,
  `preport_update_date` datetime NOT NULL,
  `preport_filled` varchar(50) NOT NULL,
  `certificate_update_date` datetime NOT NULL,
  `certificate_filled` varchar(50) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  `is_sms_cron` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `student_group`
--

INSERT INTO `student_group` (`id`, `group_id`, `group_name`, `centre_id`, `course_id`, `teacher_id`, `units`, `unit_per_day`, `week_no`, `dated`, `teacher_date`, `teacher_time`, `teacher_endtime`, `room_id`, `status`, `start_date`, `end_date`, `group_time`, `group_time_end`, `group_start_time`, `group_end_time`, `completed_date`, `sa_id`, `preport_update_date`, `preport_filled`, `certificate_update_date`, `certificate_filled`, `created_datetime`, `created_by`, `last_updated`, `updated_by`, `is_sms_cron`) VALUES
(1, 52, 'test2', 1, 1, 2, 40, 2, 0, '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, 'Not Started', '2013-10-30', '2013-11-27', '1700', '1830', '05:00 PM', '06:30 PM', '0000-00-00', 126, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(2, 52, 'test1', 1, 2, 2, 50, 2, 0, '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, 'Not Started', '2013-12-12', '2014-01-16', '0800', '0930', '08:00 AM', '09:30 AM', '0000-00-00', 126, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(4, 0, 'place', 1, 1, 2, 80, 2, 0, '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, 'Not Started', '2014-01-17', '2014-03-14', '0930', '1100', '09:30 AM', '11:00 AM', '0000-00-00', 126, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(5, 0, 'place_tarik', 1, 1, 1, 60, 2, 0, '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, 'Not Started', '2013-12-28', '2014-01-09', '0800', '0930', '08:00 AM', '09:30 AM', '0000-00-00', 126, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_group_dtls`
--

CREATE TABLE IF NOT EXISTS `student_group_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `room_id` bigint(100) NOT NULL,
  `book_received` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student_group_dtls`
--

INSERT INTO `student_group_dtls` (`id`, `parent_id`, `student_id`, `group_id`, `course_id`, `centre_id`, `room_id`, `book_received`) VALUES
(2, 1, 2, 52, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_group_history`
--

CREATE TABLE IF NOT EXISTS `student_group_history` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` datetime NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `type` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `student_group_history`
--

INSERT INTO `student_group_history` (`id`, `dated`, `centre_id`, `group_id`, `user_id`, `type`) VALUES
(1, '2013-12-05 04:34:03', 1, 1, 125, 1),
(2, '2013-12-05 04:34:26', 0, 1, 1, 1),
(3, '2013-12-05 04:38:16', 0, 0, 1, 1),
(4, '2013-12-05 04:44:54', 1, 1, 125, 1),
(5, '2013-12-05 04:45:27', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_group_history_dtls`
--

CREATE TABLE IF NOT EXISTS `student_group_history_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student_group_history_dtls`
--

INSERT INTO `student_group_history_dtls` (`id`, `parent_id`, `student_id`) VALUES
(1, 4, 1),
(2, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_hold`
--

CREATE TABLE IF NOT EXISTS `student_hold` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(50) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_dated` date NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_lead`
--

CREATE TABLE IF NOT EXISTS `student_lead` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `lead_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `student_lead`
--

INSERT INTO `student_lead` (`id`, `student_id`, `lead_id`) VALUES
(16, 1, 44),
(17, 2, 44),
(12, 4, 44),
(11, 5, 44),
(10, 6, 44),
(7, 7, 44),
(13, 3, 44),
(19, 8, 44),
(20, 9, 145);

-- --------------------------------------------------------

--
-- Table structure for table `student_material`
--

CREATE TABLE IF NOT EXISTS `student_material` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `mate_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_moving`
--

CREATE TABLE IF NOT EXISTS `student_moving` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `status_id` bigint(100) NOT NULL,
  `date_time` datetime NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `grade_online` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `grade_speak` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student_moving`
--

INSERT INTO `student_moving` (`id`, `student_id`, `course_id`, `group_id`, `status_id`, `date_time`, `user_id`, `grade_online`, `grade_speak`) VALUES
(1, 1, 0, 1, 4, '2013-11-28 10:14:45', 126, '', ''),
(2, 2, 0, 1, 4, '2013-11-28 01:08:29', 126, '', ''),
(3, 3, 0, 0, 2, '2013-11-28 01:11:29', 126, '', ''),
(4, 4, 0, 0, 2, '2013-11-28 01:13:08', 126, '', ''),
(5, 5, 0, 0, 2, '2013-11-28 01:14:31', 126, '', ''),
(6, 6, 0, 0, 2, '2013-11-28 01:17:36', 126, '', ''),
(7, 7, 0, 2, 2, '2013-11-28 01:18:28', 126, '', ''),
(8, 8, 0, 0, 2, '2013-12-12 03:33:08', 126, '', ''),
(9, 9, 0, 0, 1, '2013-12-26 09:15:45', 126, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_moving_history`
--

CREATE TABLE IF NOT EXISTS `student_moving_history` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `date_time` datetime NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `status_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `student_moving_history`
--

INSERT INTO `student_moving_history` (`id`, `student_id`, `course_id`, `group_id`, `date_time`, `user_id`, `status_id`) VALUES
(1, 1, 1, 1, '2013-12-05 16:45:27', 1, 7),
(2, 2, 1, 1, '0000-00-00 00:00:00', 126, 4),
(3, 8, 0, 0, '2013-12-12 03:33:08', 126, 1),
(4, 9, 0, 0, '2013-12-26 09:15:45', 126, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_status`
--

CREATE TABLE IF NOT EXISTS `student_status` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student_status`
--

INSERT INTO `student_status` (`id`, `name`) VALUES
(1, 'Enquiry'),
(2, 'Potential'),
(3, 'Waiting'),
(4, 'Enrolled'),
(5, 'Active'),
(6, 'On Hold'),
(7, 'Cancelled'),
(8, 'Completed'),
(9, 'Legally Critical');

-- --------------------------------------------------------

--
-- Table structure for table `student_type`
--

CREATE TABLE IF NOT EXISTS `student_type` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `type_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `student_type`
--

INSERT INTO `student_type` (`id`, `student_id`, `type_id`) VALUES
(1, 7, 98),
(4, 6, 98),
(5, 5, 98),
(6, 4, 98),
(7, 3, 98),
(11, 2, 98),
(10, 1, 98),
(12, 8, 144);

-- --------------------------------------------------------

--
-- Table structure for table `student_vacation`
--

CREATE TABLE IF NOT EXISTS `student_vacation` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `frm` date NOT NULL,
  `tto` date NOT NULL,
  `reason` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `country_id` int(100) NOT NULL,
  `teacher_status` bigint(100) NOT NULL,
  `unit` bigint(100) NOT NULL,
  `overtime` bigint(100) NOT NULL,
  `prefer_time` bigint(100) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `mobile`, `country_id`, `teacher_status`, `unit`, `overtime`, `prefer_time`, `email`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Tarik Nebi', '00966523432423', 14, 2, 10, 0, 5, 'ahmedv@gmail.com', '2013-08-27 12:22:53', 1, '0000-00-00 00:00:00', 0),
(2, 'Don', '00966561367402', 189, 2, 0, 1, 4, 'don@berlitz-ksa.com', '2013-08-28 12:49:27', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_centre`
--

CREATE TABLE IF NOT EXISTS `teacher_centre` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `teacher_centre`
--

INSERT INTO `teacher_centre` (`id`, `teacher_id`, `centre_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_progress`
--

CREATE TABLE IF NOT EXISTS `teacher_progress` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `grade_submit` date NOT NULL,
  `report_print` date NOT NULL,
  `report_print_by` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `certificate_print` date NOT NULL,
  `certificate_print_by` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `progress_report_date` date NOT NULL,
  `certificate` varchar(150) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `narration` longtext CHARACTER SET ucs2 COLLATE ucs2_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teacher_progress`
--

INSERT INTO `teacher_progress` (`id`, `teacher_id`, `group_id`, `course_id`, `grade_submit`, `report_print`, `report_print_by`, `certificate_print`, `certificate_print_by`, `progress_report_date`, `certificate`, `narration`) VALUES
(1, 1, 1, 1, '0000-00-00', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_progress_certificate`
--

CREATE TABLE IF NOT EXISTS `teacher_progress_certificate` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `fluency` bigint(100) NOT NULL,
  `fluency_perc` bigint(100) NOT NULL,
  `pronunciation` bigint(100) NOT NULL,
  `pronunciation_perc` bigint(100) NOT NULL,
  `grammer` bigint(100) NOT NULL,
  `grammer_perc` bigint(100) NOT NULL,
  `vocabulary` bigint(100) NOT NULL,
  `vocabulary_perc` bigint(100) NOT NULL,
  `listening` bigint(100) NOT NULL,
  `listening_perc` bigint(100) NOT NULL,
  `comprehension` bigint(100) NOT NULL,
  `end_of_level` bigint(100) NOT NULL,
  `end_of_level_perc` bigint(100) NOT NULL,
  `attendance` bigint(100) NOT NULL,
  `attendance_perc` bigint(100) NOT NULL,
  `parent_id` bigint(100) NOT NULL,
  `print_status` int(11) NOT NULL,
  `print_date` date NOT NULL,
  `final_percent` float NOT NULL,
  `grade_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teacher_progress_certificate`
--

INSERT INTO `teacher_progress_certificate` (`id`, `teacher_id`, `group_id`, `student_id`, `course_id`, `fluency`, `fluency_perc`, `pronunciation`, `pronunciation_perc`, `grammer`, `grammer_perc`, `vocabulary`, `vocabulary_perc`, `listening`, `listening_perc`, `comprehension`, `end_of_level`, `end_of_level_perc`, `attendance`, `attendance_perc`, `parent_id`, `print_status`, `print_date`, `final_percent`, `grade_id`) VALUES
(1, 1, 1, 2, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1, 0, 2, 1, 1, 0, '0000-00-00', 79, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_progress_course`
--

CREATE TABLE IF NOT EXISTS `teacher_progress_course` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `group_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `course_partication` bigint(100) NOT NULL,
  `course_partication_perc` bigint(100) NOT NULL,
  `course_homework` bigint(100) NOT NULL,
  `course_homework_perc` bigint(100) NOT NULL,
  `course_fluency` bigint(100) NOT NULL,
  `course_fluency_perc` bigint(100) NOT NULL,
  `course_pro` bigint(100) NOT NULL,
  `course_pro_perc` bigint(100) NOT NULL,
  `course_grammer` bigint(100) NOT NULL,
  `course_grammer_perc` bigint(100) NOT NULL,
  `course_voca` bigint(100) NOT NULL,
  `course_voca_perc` bigint(100) NOT NULL,
  `course_listen` bigint(100) NOT NULL,
  `course_listen_perc` bigint(100) NOT NULL,
  `course_attendance` bigint(100) NOT NULL,
  `course_attendance_perc` bigint(100) NOT NULL,
  `course_comp` bigint(100) NOT NULL,
  `parent_id` bigint(100) NOT NULL,
  `print_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teacher_progress_course`
--

INSERT INTO `teacher_progress_course` (`id`, `teacher_id`, `group_id`, `student_id`, `course_id`, `course_partication`, `course_partication_perc`, `course_homework`, `course_homework_perc`, `course_fluency`, `course_fluency_perc`, `course_pro`, `course_pro_perc`, `course_grammer`, `course_grammer_perc`, `course_voca`, `course_voca_perc`, `course_listen`, `course_listen_perc`, `course_attendance`, `course_attendance_perc`, `course_comp`, `parent_id`, `print_status`) VALUES
(1, 1, 1, 2, 1, 1, 15, 1, 15, 1, 15, 1, 15, 1, 15, 1, 15, 1, 15, 2, 12, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_vacation`
--

CREATE TABLE IF NOT EXISTS `teacher_vacation` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `frm` date NOT NULL,
  `tto` date NOT NULL,
  `type` varchar(50) NOT NULL,
  `group_affect` int(11) NOT NULL,
  `status` bigint(10) NOT NULL,
  `no_days` bigint(10) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_vacation_dtls`
--

CREATE TABLE IF NOT EXISTS `teacher_vacation_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `vacation_id` bigint(100) NOT NULL,
  `dated` date NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `order_sl` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_centre_to_centre`
--

CREATE TABLE IF NOT EXISTS `transfer_centre_to_centre` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `centre_from` bigint(100) NOT NULL,
  `from_id` bigint(100) NOT NULL,
  `centre_to` bigint(100) NOT NULL,
  `to_id` bigint(100) NOT NULL,
  `from_status_id` bigint(100) NOT NULL,
  `to_status_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `to_student_id` bigint(100) NOT NULL,
  `from_course_id` bigint(100) NOT NULL,
  `to_course_id` bigint(100) NOT NULL,
  `tr_ob_amt` float NOT NULL,
  `tr_discount` float NOT NULL,
  `tr_other_amt` float NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(50) NOT NULL,
  `status` varchar(50) CHARACTER SET ucs2 COLLATE ucs2_czech_ci NOT NULL,
  `final_status` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `final_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_centre_to_centre_dtls`
--

CREATE TABLE IF NOT EXISTS `transfer_centre_to_centre_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_different_centre`
--

CREATE TABLE IF NOT EXISTS `transfer_different_centre` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `centre_from` bigint(100) NOT NULL,
  `from_id` bigint(100) NOT NULL,
  `centre_to` bigint(100) NOT NULL,
  `to_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(50) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `final_status` varchar(100) NOT NULL,
  `final_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_different_centre_dtls`
--

CREATE TABLE IF NOT EXISTS `transfer_different_centre_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_student_to_student`
--

CREATE TABLE IF NOT EXISTS `transfer_student_to_student` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `from_id` bigint(100) NOT NULL,
  `to_id` bigint(100) NOT NULL,
  `from_status_id` bigint(100) NOT NULL,
  `to_status_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  `to_student_id` bigint(100) NOT NULL,
  `from_course_id` bigint(100) NOT NULL,
  `to_course_id` bigint(100) NOT NULL,
  `tr_ob_amt` float NOT NULL,
  `tr_discount` float NOT NULL,
  `tr_other_amt` float NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cd_comment` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_date` date NOT NULL,
  `created_by` bigint(50) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_student_to_student_dtls`
--

CREATE TABLE IF NOT EXISTS `transfer_student_to_student_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `commonid` bigint(10) NOT NULL,
  `user_status` int(11) NOT NULL,
  `uid` bigint(100) NOT NULL,
  `is_online` bigint(10) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `center_id` bigint(100) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `email`, `user_id`, `password`, `user_name`, `mobile`, `commonid`, `user_status`, `uid`, `is_online`, `photo`, `center_id`, `created_datetime`, `created_by`) VALUES
(1, 'Administrator', 'support@berlitz-ksa.com', 'admin', 'WVdSdGFXND0=', 'Administrator', '00966547378399', 1, 0, 0, 1, '', 0, '0000-00-00 00:00:00', 0),
(125, 'Center Director', 'tarik@berlitz-ksa.com', 'tnebi', 'TVRJek5EVTI=', 'Tarik Nebi', '00966523432423', 2, 0, 0, 1, '', 1, '2013-10-29 10:36:16', 1),
(126, 'Student Advisor', 'ahmedv@gmail.com', 'miajane', 'YldsaGFtRnVaUT09', 'Mia Jane', '00966547378399', 2, 0, 0, 1, '', 1, '2013-09-01 17:36:20', 1),
(127, 'Student', 'ahmedv@gmail.com', 'st', 'YzNRPQ==', 'Ahmed Varachia', '00966547378398', 0, 0, 2, 1, '', 1, '2013-08-27 12:16:54', 126),
(128, 'Teacher', 'ahmedv@gmail.com', 'tarik', 'ZEdGeWFXcz0=', 'Tarik Nebi', '00966523432423', 0, 0, 1, 1, '', 0, '2013-08-27 15:21:57', 1),
(130, 'Teacher', 'don@berlitz-ksa.com', 'don', 'TVRJek5EVTI=', 'Don', '00966561367402', 0, 0, 2, 1, '', 1, '2013-10-06 14:08:28', 1),
(131, 'Accountant', 'don@berlitz-ksa.com', 'acc', 'TVRJek5EVTI=', 'Don Rivera', '009665', 2, 0, 0, 1, '', 0, '2013-10-06 10:13:15', 1),
(132, 'Accountant', 'ahmedv@gmail.com', 'ac', 'WVdNPQ==', 'ac', '0096652343', 2, 0, 0, 0, '', 0, '2013-09-10 12:52:01', 1),
(133, 'LIS', 'ahmedv@gmail.com', 'lis', 'Ykdseg==', 'lis', '00966523432423', 2, 0, 0, 1, '', 0, '2013-09-18 12:17:15', 1),
(134, 'LIS Manager', 'ahmedv@gmail.com', 'lism', 'YkdsemJRPT0=', 'lism', '00966523432423', 2, 0, 0, 1, '', 0, '2013-10-22 17:03:33', 1),
(135, 'Student', 'mia@yahoo.com', 'st1', 'YzNReA==', 'mia', '0096659098605', 0, 0, 81, 1, '', 1, '2013-09-29 13:33:54', 1),
(136, 'Administrator', 'moshary@berlitz-ksa.com', 'moshary', 'TVRJek5EVTI=', 'Mr Moshary', '', 1, 0, 0, 1, '', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vacation_dtls`
--

CREATE TABLE IF NOT EXISTS `vacation_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `teacher_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `working_day`
--

CREATE TABLE IF NOT EXISTS `working_day` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `dyname` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `working_day`
--

INSERT INTO `working_day` (`id`, `name`, `dyname`, `status`) VALUES
(1, 'Saturday - ??? ????????', 'Saturday', 1),
(2, 'Sunday - ??? ????? ', 'Sunday', 0),
(3, 'Monday - ??? ??????? ', 'Monday', 0),
(4, 'Tuesday - ??? ??????????? ', 'Tuesday', 0),
(5, 'Wednesday - ??? ?????????? ', 'Wednesday', 0),
(6, 'Thursday - ??? ???????? ', 'Thursday', 0),
(7, 'Friday - ??? ????????? ', 'Friday', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
