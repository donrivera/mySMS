-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2013 at 06:36 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `schedule_040513`
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

--
-- Dumping data for table `alerts`
--


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

--
-- Dumping data for table `alerts_read`
--


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

--
-- Dumping data for table `alerts_reply`
--


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
  `dated` date NOT NULL,
  `nr` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `action_owner` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `report_by` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `report_to` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `customer` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `teacher` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `reception1` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cs1` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `other1` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `reception2` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `lcd` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `lis` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `cs2` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `other2` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `instruction` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `material` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `programme` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `premisses` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `administration` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `other3` varchar(70) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `created_by` bigint(3) NOT NULL,
  `last_updated` datetime NOT NULL,
  `updated_by` bigint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `arf`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cd_makeup_class`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cd_makeup_class_dtls`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `centre`
--

INSERT INTO `centre` (`id`, `name`, `cen_no`, `cen_tel_no`, `cen_email`, `cen_dir_name`, `street_name`, `area`, `province`, `country`, `unit_day`, `start_time`, `end_time`, `class_start_time`, `class_end_time`, `cen_no_clas`, `invoice_from`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Men Hofuf', 1, '0674-213456', 'blet@gmail.com', 'BLET CD', '', '', '', '189', 0, '0:', ':', '00:00:00', '00:00:00', 10, '1', '2012-09-03 01:19:38', 1, '2012-09-03 01:51:07', 2),
(2, 'Men Mubarraz', 3, '05487896767', 'a@b.com', 'Imran', 'Thurayat Street', '', 'Choose your state (if applicable)', '189', 0, '0:', ':', '08:00:00', '20:00:00', 1, '1', '2012-09-03 01:50:52', 2, '2013-05-01 10:39:16', 1),
(3, 'Ladies Mubarraz', 2, '067876578', 'b@b.com', 'Ladies Director', '', '', '', '189', 0, '0:', ':', '01:00:00', '23:00:00', 1, '1', '2012-09-03 01:51:44', 2, '2013-05-01 10:39:45', 1),
(4, 'Ladies Hofuf', 4, '05487889765', 'a@b1.com', 'Ladies Director', '', '', '', '189', 0, '0:', ':', '02:00:00', '23:00:00', 1, '1', '2012-09-03 01:52:16', 2, '2013-05-01 10:39:32', 1),
(5, 'Men Ubqaiq', 5, '987654678', 'center5@berlitz-ksa.com', 'Ahmed Varachia', 'Thurayat Street', '', 'Choose your state (if applicable)', '189', 0, '0:', ':', '16:30:00', '21:30:00', 1, '1', '2012-09-06 02:02:23', 1, '2013-05-01 10:39:55', 1),
(6, 'BLET', 44, '44545646', 'blet@bletinda.com', 'popu', '', '', '', '189', 0, '0:', ':', '12:00:00', '16:00:00', 2, '10', '2013-05-10 11:06:51', 1, '0000-00-00 00:00:00', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `centre_group_size`
--

INSERT INTO `centre_group_size` (`id`, `group_id`, `size_from`, `size_to`, `total_size`, `week_id`, `week_id1`, `units`, `effect_units`, `centre_id`) VALUES
(1, 51, 1, 1, 0, '', 1, 40, 0, 1),
(2, 52, 2, 3, 1, '', 1, 40, 0, 1),
(3, 53, 4, 6, 2, '', 2, 60, 0, 1),
(4, 54, 7, 9, 2, '', 3, 70, 0, 1),
(5, 55, 10, 12, 2, '', 4, 80, 0, 1),
(6, 56, 13, 150, 137, '', 4, 85, 0, 1),
(7, 57, 0, 0, 0, '', 0, 0, 0, 1),
(8, 51, 1, 1, 0, '', 1, 40, 2, 2),
(9, 52, 2, 3, 1, '', 1, 40, 2, 2),
(10, 53, 4, 6, 2, '', 2, 60, 68, 2),
(11, 54, 7, 9, 2, '', 3, 70, 78, 2),
(12, 55, 10, 12, 2, '', 4, 80, 79, 2),
(13, 56, 13, 150, 137, '', 4, 85, 0, 2),
(14, 57, 0, 0, 0, '', 0, 0, 0, 2),
(15, 51, 1, 1, 0, '', 1, 40, 0, 3),
(16, 52, 2, 3, 1, '', 1, 40, 0, 3),
(17, 53, 4, 6, 2, '', 2, 60, 0, 3),
(18, 54, 7, 9, 2, '', 3, 70, 0, 3),
(19, 55, 10, 12, 2, '', 4, 80, 0, 3),
(20, 56, 13, 150, 137, '', 4, 85, 0, 3),
(21, 57, 0, 0, 0, '', 0, 0, 0, 3),
(22, 51, 1, 1, 0, '', 1, 40, 0, 4),
(23, 52, 2, 3, 1, '', 1, 40, 0, 4),
(24, 53, 4, 6, 2, '', 2, 60, 0, 4),
(25, 54, 7, 9, 2, '', 3, 70, 0, 4),
(26, 55, 10, 12, 2, '', 4, 80, 0, 4),
(27, 56, 13, 150, 137, '', 4, 85, 0, 4),
(28, 57, 0, 0, 0, '', 0, 0, 0, 4),
(29, 51, 1, 1, 0, '', 1, 40, 0, 5),
(30, 52, 2, 3, 1, '', 1, 40, 0, 5),
(31, 53, 4, 6, 2, '', 2, 60, 0, 5),
(32, 54, 7, 9, 2, '', 3, 70, 0, 5),
(33, 55, 10, 12, 2, '', 4, 80, 0, 5),
(34, 56, 13, 150, 137, '', 4, 85, 0, 5),
(35, 57, 0, 0, 0, '', 0, 0, 0, 5),
(36, 51, 1, 1, 0, '', 1, 40, 0, 6),
(37, 52, 2, 3, 1, '', 1, 40, 0, 6),
(38, 53, 4, 6, 2, '', 2, 60, 0, 6),
(39, 54, 7, 9, 2, '', 3, 70, 0, 6),
(40, 55, 10, 12, 2, '', 4, 80, 0, 6),
(41, 56, 13, 150, 137, '', 4, 85, 0, 6),
(42, 57, 0, 0, 0, '', 0, 0, 0, 6);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `centre_room`
--

INSERT INTO `centre_room` (`id`, `centre_id`, `name`, `no`) VALUES
(1, 1, 'Class 1', 10),
(2, 1, 'Class 2', 10),
(3, 1, 'Class 3', 10),
(4, 1, 'Class 4', 10),
(5, 1, 'Class 5', 10),
(6, 1, 'Class 6', 10),
(7, 1, 'Class 7', 10),
(8, 1, 'Class 8', 10),
(9, 1, 'Class 9', 10),
(10, 1, 'Class 10', 10),
(11, 2, 'Classroom 1', 12),
(12, 3, 'Classroom 1', 12),
(13, 4, 'Classroom 1', 12),
(14, 5, 'Classroom 1', 15),
(15, 6, 'Classroom 1', 11),
(16, 6, 'Classroom 2', 12);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `centre_vacation`
--

INSERT INTO `centre_vacation` (`id`, `sid`, `centre_id`, `frm`, `tto`, `type`, `status`, `no_days`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 0, 1, '2013-02-04', '2013-03-31', 'Annual', 0, 56, '2013-02-04 02:51:18', 1, '0000-00-00 00:00:00', 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `class_cancel`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

--
-- Dumping data for table `common`
--

INSERT INTO `common` (`id`, `name`, `type`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Part time - ??? ?? ?????', 'user status', '0000-00-00 00:00:00', 0, '2013-04-03 08:46:25', 1),
(2, 'Full Time - ???? ????', 'user status', '0000-00-00 00:00:00', 0, '2013-04-03 08:46:05', 1),
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
(42, 'Advert', 'lead type', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(31, 'Critical Alert', 'alert type', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(43, 'Word of Mouth', 'lead type', '0000-00-00 00:00:00', 0, '2013-01-22 01:04:22', 1),
(44, 'Friend - ????', 'lead type', '0000-00-00 00:00:00', 0, '2013-04-03 08:57:59', 1),
(45, 'Website - ??????', 'lead type', '0000-00-00 00:00:00', 0, '2013-04-03 08:47:05', 1),
(51, 'P1', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(52, 'P2', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(53, 'G1', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(54, 'G2', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(55, 'G3', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(56, 'G4', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(57, 'Flexible (flex)', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(61, 'POS - ????', 'payment type', '0000-00-00 00:00:00', 0, '2013-05-04 10:59:31', 105),
(60, 'Cash - ???', 'payment type', '0000-00-00 00:00:00', 0, '2013-04-14 16:35:23', 1),
(62, 'Student Book - ???? ??????', 'material type', '0000-00-00 00:00:00', 0, '2013-05-01 10:33:33', 1),
(63, 'CD', 'material type', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(64, 'CDROM', 'material type', '0000-00-00 00:00:00', 0, '2011-12-29 14:29:32', 1),
(70, 'Magazine - ????', 'material type', '2011-12-29 14:29:45', 1, '2013-05-01 10:32:58', 1),
(75, '1', 'Unit No', '2012-01-11 16:14:26', 1, '2012-02-02 14:41:16', 1),
(76, '2', 'Unit No', '2012-01-11 16:14:30', 1, '0000-00-00 00:00:00', 0),
(92, 'Facebook - ????????', 'lead type', '2012-03-27 02:43:09', 1, '2013-04-03 08:46:45', 1),
(98, 'School Student - ???? ?????', 'Type', '2012-07-17 16:19:02', 1, '2013-04-03 10:20:32', 1),
(99, 'University Student - ???? ?????', 'Type', '2012-07-17 16:19:45', 1, '2013-04-03 10:20:00', 1),
(100, 'Housewife - ??? ?????', 'Type', '2012-07-17 16:19:57', 1, '2013-04-03 10:19:22', 1),
(101, 'Employed - ????', 'Type', '2012-07-17 16:20:04', 1, '2013-04-03 10:18:54', 1),
(102, 'Unemployed - ???? ?? ?????', 'Type', '2012-07-17 16:20:10', 1, '2013-04-03 10:18:30', 1),
(128, '3', 'Unit No', '2012-09-03 01:57:13', 2, '0000-00-00 00:00:00', 0),
(129, '4', 'Unit No', '2012-09-03 01:57:18', 2, '0000-00-00 00:00:00', 0),
(130, 'Binder - ????', 'material type', '2012-09-25 03:33:34', 1, '2013-05-01 10:32:24', 1),
(131, 'Cheque - ???', 'payment type', '2012-09-25 03:34:19', 1, '2013-04-14 16:33:27', 1),
(132, 'G6', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(133, '5', 'Unit No', '2012-10-30 03:33:51', 7, '0000-00-00 00:00:00', 0),
(134, 'Family', 'lead type', '2013-01-22 01:04:36', 1, '0000-00-00 00:00:00', 0),
(135, 'Mixed', 'group group', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(136, 'Weekends', 'teacher preference', '2013-02-04 02:26:48', 1, '0000-00-00 00:00:00', 0),
(137, 'Update', 'alert type', '2013-02-04 02:29:26', 1, '0000-00-00 00:00:00', 0),
(138, 'DVD', 'material type', '2013-02-04 02:32:54', 1, '0000-00-00 00:00:00', 0),
(139, '6', 'Unit No', '2013-02-04 02:33:49', 1, '0000-00-00 00:00:00', 0),
(141, 'Brochure - ???????', 'lead type', '2013-02-04 02:49:01', 1, '2013-03-01 22:28:42', 1);

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
(1, '????? ?????', 'Challan'),
(2, '1. Total payment date in 30 days.\r\n2. Please Iclude the Invoice Number on your check.\r\n3. This is the demo comments 34.\r\n4. This is the demo comments 55.\r\n5. This is my comments...\r\n6. This is my test\r\n\r\nkj?????????????????????????', 'Invoice'),
(3, '9000', 'Logout Time'),
(4, 'http://berlitz-ksa.com/mySMS/logo/logo.png', 'Logo path'),
(5, 'http://berlitz-ksa.com/mySMS/logo/logo_big.png', 'Logo Big'),
(6, 'http://berlitz-ksa.com/mySMS/images/left-img.jpg', 'Logo Big Left'),
(7, '003', 'Bed Debt'),
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `slno`, `code`, `descr`, `fees`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Berlitz English Level 2', 1, 'BE1', 'the is the best course of the BLET.', 3300, '2012-09-03 01:35:54', 1, '2012-09-03 01:53:26', 2),
(2, 'Berlitz English Level 1', 2, 'BE2', '', 3300, '2012-09-03 01:53:07', 2, '2013-05-01 10:55:13', 1),
(3, 'Berlitz English Level 3', 3, 'BE3', '', 3300, '2012-09-03 01:53:42', 2, '0000-00-00 00:00:00', 0),
(4, 'Berlitz English Level 4', 4, 'BE4', '', 3300, '2012-09-03 01:53:56', 2, '0000-00-00 00:00:00', 0),
(5, 'Berlitz English Level 5 - ?????? ?????????? ??????? 1', 5, 'BE5', '', 3300, '2012-09-03 01:54:06', 2, '2013-04-03 09:03:56', 1),
(6, 'Time Zone 1', 6, 'BE6', '', 3300, '2012-09-03 01:54:20', 2, '0000-00-00 00:00:00', 0),
(7, 'Time Zone 2 - ????? ????? 2', 7, 'BE7', '', 3300, '2012-09-03 01:54:29', 2, '2013-04-03 09:03:22', 1),
(8, 'Beat Starter', 8, 'BE8', '', 2800, '2012-09-03 01:54:44', 2, '0000-00-00 00:00:00', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `course_fee`
--

INSERT INTO `course_fee` (`id`, `course_id`, `fees`, `status`) VALUES
(2, 8, '2800', 1),
(4, 7, '3300', 1),
(5, 6, '6000', 1),
(6, 5, '3300', 1),
(7, 4, '3300', 1),
(8, 3, '3300', 1),
(9, 2, '3300', 1),
(10, 1, '3300', 1);

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
(1, 'KSA', 'SR - &#65020;', 0),
(2, 'USD', '$', 1),
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `email_history`
--


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
(1, 'Alerts for Certificate printing !!!', 'Dear %cd%,\r\n\r\n%teacher% ??? ?? ???????? ????? ??? 3 ????. ????? ???? ?? ???? ??????? ??????.\r\n\r\nThanks1\r\nAdministrator'),
(2, 'Alerts for Filled up the Certificate grade !!!', 'Dear %cd%,\r\n\r\n%teacher% has been completed his course before 3 days. So you have to printing the certificate for the students.'),
(3, 'e-PEDCARD Alert Message !!!', 'Dear Mr/Ms, %teacher%\r\n\r\nYou have not Filled up your Attendance on %att_dt% for the Group %groupname%.\r\nPlease fill the Attendance As soon As Possible.\r\n\r\nThanks'),
(4, 'Alerts for complete the Progress reports', 'Dear %teacher%,\r\n\r\nYour course has been 50% completed and Progress report fields are not completed. Please complete your Progress reports as soon as possible.\r\n\r\nThanks'),
(5, 'Cancellation request from %username%', 'Dear %cd%,\r\n\r\nThis student is requesting to me for "CANCELLATION". See the details below.'),
(6, 'Group size has been changed Notification !!!', 'Dear %teacher%,\r\n\r\nNow, the ePed card needs to adjust the total remaining units for this course from a remaining of %pending_units% units for the previously %groupname% group to a remaining of %dec_right_value_is% units for the newly formed %g3_name% group.\r\n\r\nAdd %unit% units to this group due to adding %no_student_remove% students to a %student% %groupname% group that has completed %no_unit_finined% units at the time of adding these %no_student_remove% students.'),
(7, 'Payment has been changed by Accountant', 'Dear Center Director And Student Advisor,\r\n\r\nPayment has been changed by the Accountant of the below student.'),
(8, 'Sick leave has been %status%', 'Dear %teacher%,\r\n\r\nYour sick leave has %status% from dated %leavefrom% to %leaveto%.\r\n\r\nThanks\r\n%cd_name%'),
(9, 'Request for transfer from %username%', 'Dear %cd%,\r\n\r\nSome students want to transfer from my centre to another. Please see the Transfer Menu on your profile in the Application.\r\n\r\nThanks\r\n%teacher%'),
(10, 'Student on-hold request from %username%', 'The following student would like to hold their courses. ????? ?????? ??????? ???? ?? ??? ???????.'),
(11, 'Alerts for number students in All centre !!!', 'Alerts for creating a group has been scheduled within a school/university date\r\n\r\n\r\nDear All Students,\r\n         Are you aware that there is a school or university exam during this course.\r\n\r\n\r\nThanks\r\nBerlitz'),
(12, 'On Hold request has been %status% By %from_name%', 'Dear %cd%\r\n\r\nThis student is requesting to me for "CANCALLATION". See the details below.'),
(13, 'On Hold request has been %status% By %from_name%', 'Dear %cd%,\r\n\r\nI have filled the ARF form of the %studentname%. Please capture the Information.\r\n\r\nThanks'),
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exam_vacation`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `frm`, `tto`, `name`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 90, 100, 'Excellent', '2012-09-03 02:13:53', 5, '0000-00-00 00:00:00', 0),
(2, 80, 89, 'Very Good', '2012-09-03 02:14:11', 5, '0000-00-00 00:00:00', 0),
(3, 60, 79, 'Good', '2012-09-03 02:14:25', 5, '0000-00-00 00:00:00', 0),
(4, 50, 69, 'Satisfactory', '2012-09-03 02:14:41', 5, '0000-00-00 00:00:00', 0),
(5, 0, 50, 'Fair', '2012-09-03 02:14:56', 5, '0000-00-00 00:00:00', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `group_list`
--

INSERT INTO `group_list` (`id`, `commonid`, `course_id`, `created_datetime`, `created_by`) VALUES
(4, 132, 6, '2012-10-30 03:21:17', 1),
(3, 53, 3, '2012-10-02 05:18:11', 1),
(5, 135, 8, '2013-02-04 02:25:31', 1),
(6, 135, 2, '2013-02-04 02:25:31', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `group_size`
--

INSERT INTO `group_size` (`id`, `group_id`, `size_from`, `size_to`, `total_size`, `week_id`, `week_id1`, `units`, `effect_units`) VALUES
(1, 51, 1, 1, 0, '4 weeks', 1, 40, 2),
(2, 52, 2, 3, 1, '4 weeks', 1, 40, 2),
(3, 53, 4, 6, 2, '6 weeks', 2, 60, 0),
(4, 54, 7, 9, 2, '7 weeks', 3, 70, 4),
(5, 55, 10, 12, 2, '8 weeks', 4, 80, 4),
(6, 56, 13, 150, 137, '8 weeks', 4, 85, 4),
(7, 57, 0, 0, 0, 'Flex', 0, 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id`, `title`, `descr`, `cen_dr`, `stu_ad`, `rep`, `student`, `teacher`, `ac`, `lis`, `lism`) VALUES
(1, 'Navigation', '<p>\r\n	Navigation -&nbsp;&#1605;&#1604;&#1575;&#1581;&#1577;</p>\r\n', 1, 0, 0, 0, 1, 1, 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`, `links`, `cen_dr`, `stu_ad`, `rep`, `student`, `teacher`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 'Facebook', 'www.fb.com/berlitzalahsa', 1, 1, 0, 0, 0, '2013-02-04 07:17:33', 1, '0000-00-00 00:00:00', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `alert_id`, `imp`, `imp_info`, `infor`, `dt`, `audience`, `cen_dr`, `stu_ad`, `rep`, `student`, `teacher`, `tm`, `status`, `centre_id`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(1, 31, 1, 'Update on prices', 'Update on prices for customers', '2013-02-04', 1, 1, 1, 1, 1, 1, '07:17 AM', 0, 0, '2013-02-04 07:17:11', 1, '0000-00-00 00:00:00', 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ped`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ped_attendance`
--


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

--
-- Dumping data for table `ped_comment`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ped_daily_status_dtls`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ped_units`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `quick_links`
--

INSERT INTO `quick_links` (`id`, `img_name`, `link_name`, `prec`, `links`, `module_name`, `user_id`, `centre_id`) VALUES
(17, '', 'Frequent Customer Report', 41, 'report_freq_customer_report.php', 'Administrator', 0, 0),
(15, '', 'Accounts Type', 16, 'payment_manage.php', 'Administrator', 0, 0),
(16, '', 'E-Mail', 29, 'email_manage.php', 'Administrator', 0, 0),
(14, '', 'Manage User Status', 6, 'user_status_manage.php', 'Administrator', 0, 0),
(13, '', 'Manage Week List', 3, '#', 'Administrator', 0, 0),
(12, '', 'Manage Week', 2, 'week_manage.php', 'Administrator', 0, 0),
(11, '', 'Home', 1, 'home.php', 'Administrator', 0, 0),
(18, '', 'Statistic Report', 45, 'report_statistic.php', 'Administrator', 0, 0),
(19, '', 'Quick Add', 2, 'student_manage.php', 'Student Advisor', 104, 2),
(20, '', 'Centre Schedule', 37, 'centre_schedule.php', 'Student Advisor', 104, 2),
(24, '', 'Wizard Interaction Based Student', 3, 's_age.php', 'Center Director', 103, 2),
(23, '', 'Quick Add', 2, 'student_manage.php', 'Center Director', 103, 2);

-- --------------------------------------------------------

--
-- Table structure for table `quick_menu`
--

CREATE TABLE IF NOT EXISTS `quick_menu` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `links` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `module_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=293 ;

--
-- Dumping data for table `quick_menu`
--

INSERT INTO `quick_menu` (`id`, `link_name`, `links`, `module_name`) VALUES
(1, 'Manage Week', 'week_manage.php', 'Administrator'),
(2, 'Manage Group Type', 'group_manage.php', 'Administrator'),
(3, 'Manage Group Size', 'group_size_manage.php', 'Administrator'),
(4, 'Manage User Status', 'user_status_manage.php', 'Administrator'),
(5, 'Manage Teacher Preference', 'teacher_manage.php', 'Administrator'),
(6, 'Manage Student Status', 'student_manage.php', 'Administrator'),
(7, 'New Alerts Type', 'alert_manage.php', 'Administrator'),
(8, 'Manage Teacher', 'teacher1_manage.php', 'Administrator'),
(9, 'Manage Material', 'material_manage.php', 'Administrator'),
(10, 'Manage Unit', 'unit_manage.php', 'Administrator'),
(11, 'Manage Comments', 'comments_manage.php', 'Administrator'),
(12, 'Set Logout Time', 'timeout_manage.php', 'Administrator'),
(13, 'SMS Gateway Configuration', 'sms_gateway_manage.php', 'Administrator'),
(14, 'Group Sizes', 'view_group_size.php', 'Administrator'),
(15, 'View Group History', 'view_group_history.php', 'Administrator'),
(16, 'Student Comments History', 'view_student_comments_history.php', 'Administrator'),
(17, 'Currency Setup', 'currency_setup.php', 'Administrator'),
(18, 'Manage help Document', 'help_manage.php', 'Administrator'),
(19, 'Type of Students', 'type_manage.php', 'Administrator'),
(20, 'Leads', 'lead_manage.php', 'Administrator'),
(21, 'Grades', 'grade_manage.php', 'Administrator'),
(22, 'Type of Payment', 'payment_manage.php', 'Administrator'),
(23, 'Recepts Terms And Condition', 'challan_cond.php', 'Administrator'),
(24, 'Invoice Terms And Condition', 'invoice_cond.php', 'Administrator'),
(25, 'Bed Debt Configure', 'bed_debt_config.php', 'Administrator'),
(26, 'Centre', 'center_manage.php', 'Administrator'),
(27, 'Student To Student Transfer', 'student_to_student_manage.php', 'Administrator'),
(28, 'Center to Center Transfer', 'center_to_center_manage.php', 'Administrator'),
(29, 'Centre Vacation', 'vacation_center_manage.php', 'Administrator'),
(30, 'Teacher Vacation', 'vacation_teacher_manage.php', 'Administrator'),
(31, 'Exam Vacation', 'vacation_exam_manage.php', 'Administrator'),
(32, 'Student Request Vacation', 'vacation_student_manage.php', 'Administrator'),
(33, 'Manage Sick Leave', 'sick_leave_manage.php', 'Administrator'),
(34, 'Course', 'course_manage.php', 'Administrator'),
(35, 'Users', 'user_manage.php', 'Administrator'),
(36, 'News', 'news_manage.php', 'Administrator'),
(37, 'Links', 'link_manage.php', 'Administrator'),
(38, 'Alerts', 'alert1_manage.php', 'Administrator'),
(39, 'Manage SMS Template', 'sms_template_manage.php', 'Administrator'),
(40, 'SMS Parameter Template', 'sms_parameter_templete.php', 'Administrator'),
(41, 'Manage SMS History', 'sms_history.php', 'Administrator'),
(42, 'Manage Email Template', 'email_manage.php', 'Administrator'),
(43, 'manage Email Parameter', 'email_parameter_templete.php', 'Administrator'),
(44, 'Student Details', 's_manage.php', 'Administrator'),
(45, 'Cancellation Request', 'cancel_manage.php', 'Administrator'),
(46, 'By-Teacher Groups', 'report_teacher_board.php', 'Administrator'),
(47, 'Teacher(s) Schedule', 'report_teacher_schedule.php', 'Administrator'),
(48, 'Students awaiting a course', 'report_student_awaiting.php', 'Administrator'),
(49, 'Groups to Finish', 'report_group_to_finish.php', 'Administrator'),
(50, 'Certificates not collected', 'report_certificate_not_collect.php', 'Administrator'),
(51, 'Student Absence Report', 'report_absent_report.php', 'Administrator'),
(52, 'Teacher Leave Report', 'report_teacher_leave_report.php', 'Administrator'),
(53, 'Teacher Overtime Report', 'report_teacher_overtime_report.php', 'Administrator'),
(54, 'Teacher Capacity', 'report_teacher_capacity.php', 'Administrator'),
(55, 'Students Results', 'report_certificate_report.php', 'Administrator'),
(56, 'VIP Students', 'report_freq_customer_report.php', 'Administrator'),
(57, 'Detailed Students Results', 'report_student_group_grade.php', 'Administrator'),
(58, 'Students Statuses', 'report_student_not_enrolled.php', 'Administrator'),
(59, 'Student on Hold', 'report_student_on_hold.php', 'Administrator'),
(60, 'Statistic Report', 'report_statistic.php', 'Administrator'),
(61, 'Student Life Cycle', 'report_student_cycle.php', 'Administrator'),
(62, 'Management Report', 'report_management.php', 'Administrator'),
(63, 'Single Report', 'certificate.php', 'Administrator'),
(64, 'Multiple Report', 'certificate_multi.php', 'Administrator'),
(65, 'My Account', 'my_account.php', 'Administrator'),
(66, 'Change Password', 'password.php', 'Administrator'),
(67, 'Quick Links', 'quicklink_manage.php', 'Administrator'),
(68, 'Home', 'home.php', 'Center Director'),
(69, 'Enquiry', 'student_manage.php', 'Center Director'),
(70, 'Step-By-Step New Student', 's_age.php', 'Center Director'),
(71, 'Quick Enrollment', 's_classic.php', 'Center Director'),
(72, 'Action ARF Reports', 'arf_manage.php', 'Center Director'),
(73, 'Cancellation Request', 'cancel_manage.php', 'Center Director'),
(74, 'Manage On-Hold Request', 'hold_manage.php', 'Center Director'),
(75, 'Student Information', 'single-student.php', 'Center Director'),
(76, 'Student Services', 'search.php', 'Center Director'),
(77, 'Step-By-Step New Group', 'group_course.php', 'Center Director'),
(78, 'Quick Add new Group', 'group_quick.php', 'Center Director'),
(79, 'Manage Grouping', 'group_manage.php', 'Center Director'),
(80, 'Group Sizes', 'view_group_size.php', 'Center Director'),
(81, 'View Group History', 'view_group_history.php', 'Center Director'),
(82, 'Student To Student Transfer', 'student_to_student_manage.php', 'Center Director'),
(83, 'Student To Center Transer', 'student_to_different_center_manage.php', 'Center Director'),
(84, 'Student from Another Center', 'student_from_another_center_manage.php', 'Center Director'),
(85, 'Center to Center Transfer', 'center_to_center_manage.php', 'Center Director'),
(86, 'Date Converter', 'calc_converter.php', 'Center Director'),
(87, 'Language Converter', 'translate.php', 'Center Director'),
(88, 'Alerts', 'alert.php', 'Center Director'),
(89, 'SMS', 'sms.php', 'Center Director'),
(90, 'E-Mail', 'email.php', 'Center Director'),
(91, 'View in Gantt Chart', 'centre_schedule.php', 'Center Director'),
(92, 'View Table by Teacher', 'centre_schedule_teacher.php', 'Center Director'),
(93, 'View Table by Level', 'centre_schedule_table.php', 'Center Director'),
(94, 'View By Start Date', 'centre_schedule_startdate.php', 'Center Director'),
(95, 'View By End Date', 'centre_schedule_enddate.php', 'Center Director'),
(96, 'View By Date Range', 'centre_schedule_rangedate.php', 'Center Director'),
(97, 'Certificate Report', 'report_centre_director_main.php', 'Center Director'),
(98, 'Group Progress Report', 'report_group_progress.php', 'Center Director'),
(99, 'Personal Progress Report', 'report_teacher_progress.php', 'Center Director'),
(100, 'Epedcard', 'ped.php', 'Center Director'),
(101, 'By-Teacher Groups', 'report_teacher_board.php', 'Center Director'),
(102, 'Teacher(s) Schedule', 'report_teacher_schedule.php', 'Center Director'),
(103, 'Students awaiting a Course', 'report_student_awaiting.php', 'Center Director'),
(104, 'Group to finish', 'report_group_to_finish.php', 'Center Director'),
(105, 'Certificates not Collected', 'report_certificate_not_collect.php', 'Center Director'),
(106, 'Student Absense Report', 'report_absent_report.php', 'Center Director'),
(107, 'Teacher Leave Report', 'report_teacher_leave_report.php', 'Center Director'),
(108, 'Teacher overtime Report', 'report_teacher_overtime_report.php', 'Center Director'),
(109, 'Teacher Capacity', 'report_teacher_capacity.php', 'Center Director'),
(110, 'Students Results', 'report_certificate_report.php', 'Center Director'),
(111, 'VIP Students', 'report_freq_customer_report.php', 'Center Director'),
(112, 'Detailed Students Results', 'report_student_group_grade.php', 'Center Director'),
(113, 'Students Statuses', 'report_student_not_enrolled.php', 'Center Director'),
(114, 'Student on Hold', 'report_student_on_hold.php', 'Center Director'),
(115, 'Statistic Report', 'report_statistic.php', 'Center Director'),
(116, 'Students Comments History', 'view_student_comments_history.php', 'Center Director'),
(117, 'Manage SMS History', 'manage_sms_history.php', 'Center Director'),
(118, 'Managegement Report', 'report_management.php', 'Center Director'),
(119, 'Student Lie Cycle', 'report_student_cycle.php', 'Center Director'),
(120, 'Removing student from group', 'ep_removing_student.php', 'Center Director'),
(121, 'Scheduling of a make up class', 'ep_scheduling_manage.php', 'Center Director'),
(122, 'Change a classroom', 'ep_change_classroom.php', 'Center Director'),
(123, 'Addition of student to a group', 'ep_adding_student.php', 'Center Director'),
(124, 'Cancellation of Class', 'ep_class_cancel_manage.php', 'Center Director'),
(125, 'Centre Vacation', 'vacation_center_manage.php', 'Center Director'),
(126, 'Exam Vacation', 'vacation_exam_manage.php', 'Center Director'),
(127, 'Teacher Vacation', 'vacation_teacher_manage.php', 'Center Director'),
(128, 'Manage Sick Leave', 'sick_leave_manage.php', 'Center Director'),
(129, 'Single Certificate', 'certificate.php', 'Center Director'),
(130, 'Multiple Certificate', 'certificate_multi.php', 'Center Director'),
(131, 'Change Password', 'password.php', 'Center Director'),
(132, 'Quick Links', 'quicklink_manage.php', 'Center Director'),
(133, 'Students Credentials', 'user_manage.php', 'Center Director'),
(134, 'Home', 'home.php', 'Student Advisor'),
(135, 'Enquiry', 'student_manage.php', 'Student Advisor'),
(136, 'Step-By-Step New Student', 's_age.php', 'Student Advisor'),
(137, 'Quick Enrollment', 's_classic.php', 'Student Advisor'),
(138, 'Edit Student Appointment', 'student_appoint_manage.php', 'Student Advisor'),
(139, 'Action ARF Reports', 'arf_manage.php', 'Student Advisor'),
(140, 'Cancellation Request', 'cancel_manage.php', 'Student Advisor'),
(141, 'Manage On-Hold Request', 'hold_manage.php', 'Student Advisor'),
(142, 'Student Information', 'single-student.php', 'Student Advisor'),
(143, 'Student Services', 'search.php', 'Student Advisor'),
(144, 'Step-By-Step New Group', 'group_course.php', 'Student Advisor'),
(145, 'Quick Add New Group', 'group_quick.php', 'Student Advisor'),
(146, 'Manage Grouping', 'group_manage.php', 'Student Advisor'),
(147, 'Group Sizes', 'view_group_size.php', 'Student Advisor'),
(148, 'Student To Student Transfer', 'student_to_student_manage.php', 'Student Advisor'),
(149, 'Student To Center Transfer', 's-to-s-different-center-manage.php', 'Student Advisor'),
(150, 'Center To Center Transfer', 'center_to_center_manage.php', 'Student Advisor'),
(151, 'By-Teacher Groups', 'report_teacher_board.php', 'Student Advisor'),
(152, 'Teacher(s) Schedule', 'report_teacher_schedule.php', 'Student Advisor'),
(153, 'Students awaiting a course', 'report_student_awaiting.php', 'Student Advisor'),
(154, 'Groups to Finish', 'report_group_to_finish.php', 'Student Advisor'),
(155, 'Certficates not collected', 'report_certificate_not_collect.php', 'Student Advisor'),
(156, 'Student Absense Report', 'report_absent_report.php', 'Student Advisor'),
(157, 'Teacher Leave Report', 'report_teacher_leave_report.php', 'Student Advisor'),
(158, 'Teacher Capacity', 'report_teacher_capacity.php', 'Student Advisor'),
(159, 'Students Results', 'report_certificate_report.php', 'Student Advisor'),
(160, 'VIP Students', 'report_freq_customer_report.php', 'Student Advisor'),
(161, 'Detailed Students Results', 'report_student_group_grade.php', 'Student Advisor'),
(162, 'Students Statuses', 'report_student_not_enrolled.php', 'Student Advisor'),
(163, 'Students on Hold', 'report_student_on_hold.php', 'Student Advisor'),
(164, 'Students Comments History', 'view_student_comments_history.php', 'Student Advisor'),
(165, 'Student Life Cycle', 'report_student_cycle.php', 'Student Advisor'),
(166, 'Date Converter', 'calc_converter.php', 'Student Advisor'),
(167, 'Language Converter', 'translate.php', 'Student Advisor'),
(168, 'Alerts', 'alert.php', 'Student Advisor'),
(169, 'SMS', 'sms.php', 'Student Advisor'),
(170, 'E-Mail', 'email.php', 'Student Advisor'),
(171, 'Centre Schedule', 'centre_schedule.php', 'Student Advisor'),
(172, 'Epedcard', 'ped.php', 'Student Advisor'),
(173, 'Progress Reports [Multi]', 'report_group_progress.php', 'Student Advisor'),
(174, 'Progress Reports [Student]', 'report_teacher_progress.php', 'Student Advisor'),
(175, 'Single Certificate', 'certificate.php', 'Student Advisor'),
(176, 'Multiple Certificate', 'certificate_multi.php', 'Student Advisor'),
(177, 'Change Password', 'password.php', 'Student Advisor'),
(178, 'Quick Links', 'quicklink_manage.php', 'Student Advisor'),
(179, 'Students Credentials', 'user_manage.php', 'Student Advisor'),
(180, 'Home', 'home.php', 'Teacher'),
(181, 'My Groups', 'my_groups.php', 'Teacher'),
(182, 'My Schedules', 'my_schedules.php', 'Teacher'),
(183, 'ePEDCARD', 'ped.php', 'Teacher'),
(184, 'Progress Reports', 'report_teacher_progress.php', 'Teacher'),
(185, 'Certificate Reports', 'report_center_director.php', 'Teacher'),
(186, 'ARF', 'arf_manage.php', 'Teacher'),
(187, 'Sick Leave', 'manage_sick_leave.php', 'Teacher'),
(188, 'Date Converter', 'calc_converter.php', 'Teacher'),
(189, 'Language Converter', 'translate.php', 'Teacher'),
(190, 'Alerts', 'alert.php', 'Teacher'),
(191, 'Student Absence Report', 'report_absent_report.php', 'Teacher'),
(192, 'Change Password', 'password.php', 'Teacher'),
(193, 'Quick Links', 'quicklink_manage.php', 'Teacher'),
(194, 'Home', 'home.php', 'Receptionist'),
(195, 'Students Appointment', 'student_appoint_manage.php', 'Receptionist'),
(196, 'Student Services', 'search.php', 'Receptionist'),
(197, 'Groups', 'group_manage.php', 'Receptionist'),
(198, 'By-Teacher Groups', 'report_teacher_board.php', 'Receptionist'),
(199, 'Teacher(s) Schedule', 'report_teacher_schedule.php', 'Receptionist'),
(200, 'Students awaiting a course', 'report_student_awaiting.php', 'Receptionist'),
(201, 'Groups to finish', 'report_group_to_finish.php', 'Receptionist'),
(202, 'Certificate not collected', 'report_certificate_not_collect.php', 'Receptionist'),
(203, 'Student Absence Report', 'report_absent_report.php', 'Receptionist'),
(204, 'Date Converter', 'calc_converter.php', 'Receptionist'),
(205, 'Alerts', 'alert.php', 'Receptionist'),
(206, 'SMS', 'sms.php', 'Receptionist'),
(207, 'E-Mail', 'email.php', 'Receptionist'),
(208, 'Centre Schedule', 'centre_schedule.php', 'Receptionist'),
(209, 'Change Password', 'password.php', 'Receptionist'),
(210, 'Quick Links', 'quicklink_manage.php', 'Receptionist'),
(211, 'Home', 'home.php', 'Accountant'),
(212, 'Type of Payment', 'payment_manage.php', 'Accountant'),
(213, 'Receipts Terms And Condition', 'challan_cond.php', 'Accountant'),
(214, 'Invoice Terms And Condition', 'invoice_cond.php', 'Accountant'),
(215, 'Move to Bed Debt', 'move_to_beddebt.php', 'Accountant'),
(216, 'Audit Data', 'audit_history.php', 'Accountant'),
(217, 'Payment History', 'payment_history.php', 'Accountant'),
(218, 'Teacher Vacation', 'vacation_teacher_manage.php', 'Accountant'),
(219, 'Manage Sick Leave', 'sick_leave_manage.php', 'Accountant'),
(220, 'Student Details', 'search.php', 'Accountant'),
(221, 'Cancellation Request', 'cancel_manage.php', 'Accountant'),
(222, 'Course', 'course_manage.php', 'Accountant'),
(223, 'Student To Student Transfer', 'student_to_student_manage.php', 'Accountant'),
(224, 'Center To Center Transfer', 'center_to_center_manage.php', 'Accountant'),
(225, 'Single Certificate', 'certificate.php', 'Accountant'),
(226, 'Multiple Certificate', 'certificate_multi.php', 'Accountant'),
(227, 'Date Converter', 'calc_converter.php', 'Accountant'),
(228, 'Alerts', 'alert.php', 'Accountant'),
(229, 'News', 'news_manage.php', 'Accountant'),
(230, 'SMS', 'sms.php', 'Accountant'),
(231, 'E-Mail', 'email.php', 'Accountant'),
(232, 'Change Password', 'password.php', 'Accountant'),
(233, 'Quick Links', 'quicklink_manage.php', 'Accountant'),
(234, 'Students Transactions', 'report_transaction.php', 'Accountant'),
(235, 'Students Ledger', 'report_student_ledger_search.php', 'Accountant'),
(236, 'Group Ledger', 'report_group_ledger.php', 'Accountant'),
(237, 'Discounts Reports', 'report_discount.php', 'Accountant'),
(238, 'Transfer (Center To Center)', 'report_center_to_center.php', 'Accountant'),
(239, 'Transfer (Student To Student)', 'student_to_different_center_manage.php', 'Accountant'),
(240, 'Transfer (Same Center)', 'report_student_to_center.php', 'Accountant'),
(241, 'Enrollment and Re-enrollment', 'report_enrolled.php', 'Accountant'),
(242, 'Sales Summary', 'report_sales_summary.php', 'Accountant'),
(243, 'Student Overdue', 'report_overdue.php', 'Accountant'),
(244, 'Bad Debt Report', 'report_baddebt.php', 'Accountant'),
(245, 'Students on credit balance', 'report_credit_balance.php', 'Accountant'),
(246, 'Home', 'home.php', 'LIS'),
(247, 'Student Services', 'search.php', 'LIS'),
(248, 'Single Certificate', 'certificate.php', 'LIS'),
(249, 'Multiple Certificate', 'certificate_multi.php', 'LIS'),
(250, 'ePEDCARD', 'ped.php', 'LIS'),
(251, 'Progress Reports', 'report_teacher_progress.php', 'LIS'),
(252, 'Teacher Vacation', 'vacation_teacher_manage.php', 'LIS'),
(253, 'Manage Sick Leave', 'sick_leave_manage.php', 'LIS'),
(254, 'Date Converter', 'calc_converter.php', 'LIS'),
(255, 'Alerts', 'alert1_manage.php', 'LIS'),
(256, 'News', 'news_manage.php', 'LIS'),
(257, 'Change Password', 'password.php', 'LIS'),
(258, 'Quick Links', 'quicklink_manage.php', 'LIS'),
(259, 'Units taught', 'report_unit_taught.php', 'LIS'),
(260, 'ePedCard Student Statuses', 'report_eped_status.php', 'LIS'),
(261, 'Home', 'home.php', 'LIS Manager'),
(262, 'Student Services', 'search.php', 'LIS Manager'),
(263, 'Single Certificate', 'certificate.php', 'LIS Manager'),
(264, 'Multiple Certificate', 'certificate_multi.php', 'LIS Manager'),
(265, 'ePEDCARD', 'ped.php', 'LIS Manager'),
(266, 'Progress Reports', 'report_teacher_progress.php', 'LIS Manager'),
(267, 'Teacher Vacation', 'vacation_teacher_manage.php', 'LIS Manager'),
(268, 'Users', 'user_manage.php', 'LIS Manager'),
(269, 'Date Converter', 'calc_converter.php', 'LIS Manager'),
(270, 'Alerts', 'alert1_manage.php', 'LIS Manager'),
(271, 'News', 'news_manage.php', 'LIS Manager'),
(272, 'Change Password', 'password.php', 'LIS Manager'),
(273, 'Quick Links', 'quicklink_manage.php', 'LIS Manager'),
(274, 'Sick/Leave Days', 'report_sick_leave.php', 'LIS Manager'),
(275, 'Outstanding Approval', 'report_outstanding.php', 'LIS Manager'),
(276, 'Missed ePedcard Alert', 'report_missed_eped.php', 'LIS Manager'),
(277, 'Missed Progress Report', 'report_missed_progress.php', 'LIS Manager'),
(278, 'Missed Certificate Alert', 'report_missed_certificate.php', 'LIS Manager'),
(279, 'Management Report', 'report_management.php', 'LIS Manager'),
(280, 'Home', 'home.php', 'Student'),
(281, 'My Schedules', 'myschedule.php', 'Student'),
(282, 'My Account', 'myaccount.php', 'Student'),
(283, 'Audit Data', 'audit.php', 'Student'),
(284, 'My Progress Report', 'progress_report.php', 'Student'),
(285, 'Certificate Grade', 'certificate_report.php', 'Student'),
(286, 'Date Converter', 'calc_converter.php', 'Student'),
(287, 'Alerts', 'alert.php', 'Student'),
(288, 'Leave', 'leave_manage.php', 'Student'),
(289, 'Change Password', 'password.php', 'Student'),
(290, 'Quick Links', 'quicklink_manage.php', 'Student'),
(291, 'SMS Gateway Configuration', 'sms_allowed.php', 'Student'),
(292, '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sick_leave`
--

INSERT INTO `sick_leave` (`id`, `teacher_id`, `from_date`, `to_date`, `sick_reason`, `sick_attachment`, `sick_notes`, `sick_status`, `centre_id`) VALUES
(1, 8, '2013-02-10', '2013-02-18', 'Really not well', '', 'Really not well', 0, 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sick_leave_centre`
--


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
('Berlitz', 'Wm1GcGMyRnNNVE09', '966547378399', 'Berlitz', 'Enable');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sms_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `sms_history_dtls`
--

CREATE TABLE IF NOT EXISTS `sms_history_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sms_history_dtls`
--


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
(39, '???????', '???????', '2012-10-30 06:50:59', ''),
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
  `student_mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_appointment`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_cancel`
--


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

--
-- Dumping data for table `student_certificate`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_course`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_enroll`
--


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
  `invoice_sl` bigint(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_fees`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_fee_edit_history`
--


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
  `group_start_time` time NOT NULL,
  `group_end_time` time NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_group`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_group_dtls`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_group_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_group_history_dtls`
--

CREATE TABLE IF NOT EXISTS `student_group_history_dtls` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(100) NOT NULL,
  `student_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_group_history_dtls`
--


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

--
-- Dumping data for table `student_hold`
--


-- --------------------------------------------------------

--
-- Table structure for table `student_lead`
--

CREATE TABLE IF NOT EXISTS `student_lead` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(100) NOT NULL,
  `lead_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_lead`
--


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

--
-- Dumping data for table `student_material`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_moving`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_moving_history`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `student_type`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `student_vacation`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `mobile`, `country_id`, `teacher_status`, `unit`, `overtime`, `prefer_time`, `email`, `created_datetime`, `created_by`, `last_updated`, `updated_by`) VALUES
(8, 'Ahmed Varachia', '009666547378399', 199, 2, 0, 1, 3, 'ahmedv@gmail.com', '2013-02-04 02:32:24', 1, '0000-00-00 00:00:00', 0),
(3, 'Patrick Anderton', '00966547378394', 189, 1, 0, 1, 3, 'ahmed.varachia@berlitz-ksa.com', '2012-09-03 01:58:26', 2, '2012-09-09 05:47:53', 1),
(5, 'Fehmida', '00966547378398', 189, 1, 0, 1, 3, 'fehmida@berlitz-ksa.com', '2012-09-03 01:59:32', 4, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_centre`
--

CREATE TABLE IF NOT EXISTS `teacher_centre` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint(100) NOT NULL,
  `centre_id` bigint(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `teacher_centre`
--

INSERT INTO `teacher_centre` (`id`, `teacher_id`, `centre_id`) VALUES
(19, 8, 2),
(17, 3, 2),
(16, 3, 1),
(13, 5, 3),
(14, 5, 4);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `teacher_progress`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `teacher_progress_certificate`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `teacher_progress_course`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `teacher_vacation`
--


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

--
-- Dumping data for table `teacher_vacation_dtls`
--


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

--
-- Dumping data for table `transfer_centre_to_centre`
--


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

--
-- Dumping data for table `transfer_centre_to_centre_dtls`
--


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

--
-- Dumping data for table `transfer_different_centre`
--


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

--
-- Dumping data for table `transfer_different_centre_dtls`
--


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

--
-- Dumping data for table `transfer_student_to_student`
--


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

--
-- Dumping data for table `transfer_student_to_student_dtls`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `email`, `user_id`, `password`, `user_name`, `mobile`, `commonid`, `user_status`, `uid`, `is_online`, `photo`, `center_id`, `created_datetime`, `created_by`) VALUES
(1, 'Administrator', 'ahmedv@gmail.com', 'admin', 'WVdSdGFXND0=', 'Administrator', '00966547378399', 1, 0, 0, 1, '', 0, '0000-00-00 00:00:00', 0),
(112, 'Receptionist', 're@berlitz-ksa.com', 're', 'Y21VPQ==', 're', '98765478', 2, 0, 0, 1, '', 2, '2012-10-02 08:59:47', 1),
(107, 'LIS Manager', 'ahmed.varachia@berlitz-ksa.com', 'lism', 'YkdsemJRPT0=', 'lism', '009665473788976', 1, 0, 0, 1, '', 0, '2012-09-03 02:02:27', 5),
(106, 'LIS', 'ahmedv@gmail.com', 'lis', 'Ykdseg==', 'lis', '00966547378399', 2, 0, 0, 1, '', 2, '2012-09-03 02:01:58', 5),
(105, 'Accountant', 'franklin@berlitz-ksa.com', 'ac', 'WVdNPQ==', 'Imteyaz Alam', '00966547378390', 2, 0, 0, 1, '', 0, '2012-09-03 02:01:32', 5),
(104, 'Student Advisor', 'support@berlitz-ksa.com', 'sa', 'YzJFPQ==', 'Mohammed Ali', '00966547378398', 2, 0, 0, 1, '', 2, '2013-04-03 09:04:50', 1),
(103, 'Center Director', 'ahmedv@gmail.com', 'cd', 'WTJRPQ==', 'Imran', '00966547378399', 2, 0, 0, 1, '', 2, '2012-09-03 02:00:14', 5),
(102, 'Teacher', 'fehmida@berlitz-ksa.com', 'fe', 'Wm1VPQ==', 'Fehmida', '00966547378398', 0, 0, 5, 0, '', 0, '2012-09-03 01:59:32', 5),
(100, 'Teacher', 'ahmed.varachia@berlitz-ksa.com', 'pat', 'Y0dGME1RPT0=', 'Patrick Anderton', '00966547378394', 0, 0, 3, 1, '', 0, '2012-09-09 05:48:55', 1),
(109, 'Student Advisor', 'sa1@google.com', 'sa1', 'YzJFeA==', 'sa1', '98765436', 2, 0, 0, 1, '', 5, '2012-09-06 02:03:43', 1),
(97, 'Student Advisor', 'sa@gmail.com', 'bletsa', 'WW14bGRITmg=', 'BLET SA', '01234567891', 2, 0, 0, 1, '', 1, '2012-09-03 01:22:02', 1),
(96, 'Center Director', 'blet@gmail.com', 'bletcd', 'WW14bGRHTms=', 'BLET CD', '0123456789', 2, 0, 0, 1, '', 1, '2012-09-03 01:21:08', 1),
(114, 'LIS Manager', 'faisal@berlitz-ksa.com', 'hr', 'YUhJPQ==', 'hr', '009665965365', 2, 0, 0, 1, '', 0, '2012-12-02 01:33:06', 1),
(115, 'Teacher', 'ahmedv@gmail.com', 'ahmedv', 'WVdodFpXUjI=', 'Ahmed Varachia', '009666547378399', 0, 0, 8, 1, '', 0, '2013-04-29 09:45:44', 1);

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

--
-- Dumping data for table `vacation_dtls`
--


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
(1, 'Saturday - ?????', 'Saturday', 0),
(2, 'Sunday - ?????', 'Sunday', 0),
(3, 'Monday - ???????', 'Monday', 0),
(4, 'Tuesday - ????????', 'Tuesday', 0),
(5, 'Wednesday - ????????', 'Wednesday', 0),
(6, 'Thursday - ??????', 'Thursday', 1),
(7, 'Friday - ??????', 'Friday', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
