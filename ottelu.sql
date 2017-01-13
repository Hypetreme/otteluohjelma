-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2017 at 03:14 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ottelu`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `owner_id`, `user_id`, `team_id`, `name`, `date`) VALUES
(7, 1, 1, 7, 'LÃ¤tkÃ¤peli', '2017-01-12'),
(8, 1, 10, 7, 'Rottapeli', '2017-07-15');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `firstName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `user_id`, `team_id`, `firstName`, `lastName`, `number`) VALUES
(3, 10, 7, 'Reino', 'Rotta', 23),
(4, 1, 7, 'Hannu', 'Karpo', 54),
(5, 1, 7, 'Pe', 'Laaja', 64),
(6, 1, 7, 'Tero', 'Testaaja', 45);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `user_id`, `name`) VALUES
(7, 1, 'Rotat'),
(8, 1, 'Sammakot');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `uid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `hash` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `team_id` int(11) NOT NULL,
  `activated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `owner_id`, `type`, `uid`, `email`, `pwd`, `hash`, `team_id`, `activated`) VALUES
(1, 1, 0, 'admin', 'janne.karppinen@appstudios.fi', '$2a$08$fqz3EkuUnunA/a7MWorU9.xEIZtM20rQpv8xFF/TYENPHbYH.5PSq', '6ecbdd6ec859d284dc13885a37ce8d81', 0, 1),
(10, 1, 1, 'Rotat', 'hypetremethewanderer@gmail.com', '$2a$08$fNNN3x87qXZxMysXzfLKsOygrwkhA6.m1cVe/TARcxuoL.qaSu6QC', 'c51ce410c124a10e0db5e4b97fc2af39', 7, 1),
(11, 1, 1, 'Sammakot', 'hypetremethewanderer@gmail.com', '$2a$08$Cr1nnhuln.0c5AMkJUMZyO1KnEwdjG70crG/7x15fVavjFlcbC.Em', 'd82c8d1619ad8176d665453cfb2e55f0', 8, 0),
(17, 17, 0, 'testi', 'hypetremethewanderer@gmail.com', '$2a$08$y3qCc/1LJnUphkTdm65/h./tuWBRgJpeasJivYYzJqTEGi5jmFEbG', '149e9677a5989fd342ae44213df68868', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`owner_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
