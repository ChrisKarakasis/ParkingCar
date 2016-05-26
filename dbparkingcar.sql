-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2016 at 01:13 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbparkingcar`
--

-- --------------------------------------------------------

--
-- Table structure for table `parktimes`
--

CREATE TABLE IF NOT EXISTS `parktimes` (
  `DriverID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MSISDN` varchar(12) NOT NULL DEFAULT ' ',
  `CarNumber` varchar(10) NOT NULL DEFAULT ' ',
  `TimeIn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TimeOut` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`DriverID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `parktimes`
--

INSERT INTO `parktimes` (`DriverID`, `MSISDN`, `CarNumber`, `TimeIn`, `TimeOut`) VALUES
(32, '359899866747', 'CA5151PC', '2016-05-22 12:39:26', '2016-05-22 12:46:51'),
(33, '359899866747', 'CA5151PC', '2016-05-22 12:55:29', '2016-05-22 13:06:23'),
(34, '359899866747', 'CA5152PC', '2016-05-22 13:07:26', '0000-00-00 00:00:00'),
(35, '359899866747', 'CA5153PC', '2016-05-22 13:07:45', '0000-00-00 00:00:00');
