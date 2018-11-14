-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2018 at 12:27 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andyware_rsvp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(8) NOT NULL,
  `username` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `fullname`, `timestamp`, `status`) VALUES
(1, 'administrator', '$2y$10$rvXqnSEqpWO5KUsC2s0ALuK6a6qnAX0X5Y4o5cLfcPB44mNkjYYgG', 'Ian Andrew Macalisang', '2017-10-07 21:22:10', 0),
(61, 'rangeipi', '$2y$10$/Wn9Ow.ve8KbEVslhAIdtut4e8fvKakMyuZ0Xyj98x6QVzqX35x/O', 'rangeipi', '2018-01-25 05:10:22', 1),
(60, 'werwerwer', '$2y$10$77f62mbY5n0zpAOGzY59LubAFoDHPUWjNmnQm5AGW.x7GKs1W5YDG', 'werwer', '2018-01-09 07:10:21', 1),
(56, 'vheycelestino', '$2y$10$1IOKE0.3U/71nUwX0Hs7CuPpF6AzX3RlZydQTgUiqvz9H3izfpL82', 'Vera Celestino Ilagan', '2017-10-11 03:15:40', 1),
(57, 'andyware012', '$2y$10$CID8NvF.IPb0ZQLFluMKL.s3ioZ01O.PE4fwWLRU5ZMvpFNYXtyqm', 'Genwarp Web Development', '2017-10-12 04:35:34', 1),
(58, 'luisazcona', '$2y$10$k5hdq746AJ3wuvx0RKUnxuZOy5Vd4sYs3tdVhL4.a.3W2vQctzjGq', 'Luis Azcona', '2017-10-13 08:46:20', 1),
(59, 'lunysworld', '$2y$10$JgkLSZYrF058LBNfuvUFVuRNnJ4T1Rfpps.44/H3vHgCRIVT7PSvm', 'www.lunysworld.com', '2017-10-16 01:24:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `id` int(8) NOT NULL,
  `apiKey` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `fromUser` int(8) NOT NULL,
  `fromEvent` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`id`, `apiKey`, `fromUser`, `fromEvent`) VALUES
(5, '48cd909670682f38b2ae1c01', 57, 56),
(4, 'a4f56eee49de6f164c39c377', 56, 55),
(6, '3c9ec81028896c59ec1d7044', 58, 57),
(7, 'c6557f6d33170e29bebbd9a4', 59, 58),
(8, '0c9a505b257bf292ddf5904e', 60, 59),
(9, '7df1ac0382f301f35fc1b993', 61, 60);

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(8) NOT NULL,
  `fullname` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(240) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accessCode` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `qrCode` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(240) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `connectTo` int(8) NOT NULL,
  `referredFrom` int(8) NOT NULL,
  `timstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `fullname`, `email`, `accessCode`, `qrCode`, `status`, `connectTo`, `referredFrom`, `timstamp`) VALUES
(207, 'ali tamur', 'eml@email.com', 'Mx0eGbYN', 'Mx0eGbYN.png', 'Not Going', 56, 57, '2018-01-25 05:46:31'),
(208, 'ian andrew', 'andyware@live.com', 'x2TXTWs8', 'x2TXTWs8.png', 'Not Going', 56, 57, '2018-06-11 06:16:10'),
(206, 'dasdasdasdasd', 'dasdas@dadas.com', 'jjwi7lBt', 'jjwi7lBt.png', 'Attending', 60, 61, '2018-01-25 05:40:11'),
(205, 'ali tamur', 'andyware@live.com', 'BazPgLwi', 'BazPgLwi.png', 'Not Going', 60, 61, '2018-01-25 05:38:23'),
(204, 'ian dfsdf', 'asdn@live.com', 'xKhnfYSD', 'xKhnfYSD.png', 'Attending', 60, 61, '2018-01-25 05:36:16'),
(203, 'Harold', 'ilm1098@gmail.com', 'jibiFgCe', 'jibiFgCe.png', 'Attending', 60, 61, '2018-01-25 05:11:12'),
(202, 'rfghfghfgh', 'lol@you.com', 'S2j2Vi3I', 'S2j2Vi3I.png', 'Pending', 58, 59, '2017-10-16 01:28:25'),
(201, 'Lunysworld', '', 'GXDxDqE6', 'GXDxDqE6.png', 'Pending', 56, 57, '2017-10-16 01:19:37'),
(209, 'ian andrew macalisang', 'andyware@live.com', 'ZbBZDKqV', 'ZbBZDKqV.png', 'Pending', 55, 56, '2018-08-22 22:32:35');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(8) NOT NULL,
  `eventname` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(240) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Not Available',
  `description` varchar(420) COLLATE utf8_unicode_ci DEFAULT 'No information added',
  `referredFrom` int(8) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eventdate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `eventname`, `website`, `description`, `referredFrom`, `timestamp`, `eventdate`) VALUES
(3, 'Administrator Account', '', NULL, 1, '2017-10-11 01:30:29', '0000-00-00'),
(55, 'Vhey and Ralph Wedding', 'www.alwaysbettertogether.info', 'Venue: To be edited.. We are happy to have you on our special day.', 56, '2017-10-11 03:15:40', '2017-12-24'),
(56, 'Test Event Handler', 'rsvp.genwarp.com', 'This is a test for QR verification.', 57, '2017-10-12 04:35:34', '2017-10-10'),
(57, 'Terno Inferno', 'Not Available', 'No information added', 58, '2017-10-13 08:46:20', '0000-00-00'),
(58, 'www.lunysworld.com', 'Not Available', 'No information added', 59, '2017-10-16 01:24:43', '0000-00-00'),
(59, 'rewrewr', 'Not Available', 'No information added', 60, '2018-01-09 07:10:21', '0000-00-00'),
(60, 'RANGE PARTY', 'Not Available', 'No information added', 61, '2018-01-25 05:10:22', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
