-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2018 at 07:44 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `restapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'santoor@123', 0, 0, 0, NULL, '2018-03-02 19:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `mcq`
--

CREATE TABLE IF NOT EXISTS `mcq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ques` text COLLATE utf8_unicode_ci NOT NULL,
  `opts` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ans` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mcq`
--

INSERT INTO `mcq` (`id`, `ques`, `opts`, `ans`) VALUES
(1, 'What is latest version of PHP', '{"a":"5.5","b":"7","c":"5.6","d":"8"}', 'b'),
(2, 'PHP files have a default file extension of', '{"a":".html","b":".xml","c":".php","d":".ph"}', 'c'),
(3, '$num  = 1;$num1 = 2;print $num . "+". $num1;', '{"a":"3","b":"1+2","c":"1.+.2","d":"Error"}', 'b'),
(4, 'PHP’s numerically indexed array begin with position', '{"a":"1","b":"2","c":"0","d":"1"}', 'c'),
(5, ' Which one of the following is the right way of defining a function in PHP?', '{"a":"function { function body }","b":"data type functionName(parameters) { function body }","c":"functionName(parameters) { function body }","d":"function fumctionName(parameters) { function body }"}', 'd'),
(6, 'A function in PHP which starts with __ (double underscore) is know as.', '{"a":"Magic Function","b":"Inbuilt Function","c":" Default Function","d":"User Defined Function"}', 'a'),
(7, 'Which statement is used for updating existing information in the table?', '{"a":"UPDATE","b":"WHERE","c":"MODIFY","d":"ALTER"}', 'a'),
(8, 'Which clause is used to rename the existing table?', '{"a":"RENAME","b":"MODIFY","c":"ALTER","d":"None of the mentioned"}', 'a'),
(9, 'In a LIKE clause, you can could ask for any value ending in "qpt" by writing', '{"a":"LIKE %qpt","b":"LIKE *ton","c":"LIKE ton$","d":"LIKE ^.*ton$"}', 'a'),
(10, 'Which function used to get the current time in mysql?', '{"a":"getTime()","b":"Time()","c":"NOW()"}', 'c');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`) VALUES
(19, 'test user', 'test1@gmail.com'),
(21, 'weew', 'test21@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_score`
--

CREATE TABLE IF NOT EXISTS `user_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `ans` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(4) NOT NULL,
  `time_taken` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79 ;

--
-- Dumping data for table `user_score`
--

INSERT INTO `user_score` (`id`, `uid`, `qid`, `ans`, `points`, `time_taken`) VALUES
(53, 19, 4, 'b', 0, '2'),
(54, 19, 2, 'c', 1, '2'),
(55, 19, 8, 'b', 0, '2'),
(56, 19, 3, 'a', 0, '2'),
(57, 19, 1, 'c', 0, '2'),
(58, 19, 5, 'd', 1, '2'),
(59, 19, 7, 'a', 1, '1'),
(60, 19, 6, 'a', 1, '2'),
(69, 21, 8, 'a', 1, '4'),
(70, 21, 4, 'c', 1, '4'),
(71, 21, 6, 'a', 1, '3'),
(72, 21, 2, 'c', 1, '3'),
(73, 21, 7, 'c', 0, '4'),
(74, 21, 3, 'a', 0, '4'),
(75, 21, 1, 'b', 1, '2'),
(76, 21, 5, 'd', 1, '4'),
(77, 21, 10, 'c', 1, '4'),
(78, 21, 9, 'a', 1, '2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
