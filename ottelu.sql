-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2017 at 03:16 PM
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
-- Table structure for table `adlinks`
--

CREATE TABLE `adlinks` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `link1` varchar(128) NOT NULL,
  `link2` varchar(128) NOT NULL,
  `link3` varchar(128) NOT NULL,
  `link4` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adlinks`
--

INSERT INTO `adlinks` (`id`, `owner_id`, `team_id`, `link1`, `link2`, `link3`, `link4`) VALUES
(1, 1, 8, 'k-kauppa.fi', 'wikipedia.fi', '', ''),
(2, 1, 13, 'k-kauppa.fi', 'wikipedia.fi', '', '');

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
(16, 1, 1, 8, 'Spelaus', '2017-01-30'),
(17, 1, 1, 8, 'Game', '2017-02-24');

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
(1, 1, 8, 'Janne', 'Karppinen', 56),
(2, 1, 8, 'Hannu', 'Karpo', 76);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Joukkueen luoja',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `user_id`, `name`) VALUES
(8, 1, 'VihreÃ¤t Liskot'),
(12, 27, 'Peltsit'),
(13, 1, 'TampaBay'),
(14, 29, 'Pelle'),
(15, 1, 'Pellet');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'Tilintyyppi',
  `owner_id` int(11) NOT NULL COMMENT 'Joukkuetilin omistaja',
  `team_id` int(11) NOT NULL COMMENT 'Joukkuetileille',
  `uid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `hash` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `activated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `type`, `owner_id`, `team_id`, `uid`, `email`, `pwd`, `hash`, `activated`) VALUES
(1, 0, 1, 0, 'admin', 'janne.karppinen@appstudios.fi', '$2a$08$fqz3EkuUnunA/a7MWorU9.xEIZtM20rQpv8xFF/TYENPHbYH.5PSq', '6ecbdd6ec859d284dc13885a37ce8d81', 1),
(11, 1, 1, 8, 'Sammakot', 'hypetremethewanderer@gmail.com', '$2a$08$Cr1nnhuln.0c5AMkJUMZyO1KnEwdjG70crG/7x15fVavjFlcbC.Em', 'd82c8d1619ad8176d665453cfb2e55f0', 1),
(28, 1, 1, 13, 'TampaBay', 'hypetremethewanderer@gmail.com', '$2a$08$GvexTPDZtVQp5EczfiIuKuwpThPf3z6EphUyM.pOKYa/gkQsmdgC.', 'c74d97b01eae257e44aa9d5bade97baf', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adlinks`
--
ALTER TABLE `adlinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`owner_id`,`team_id`);

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
  ADD PRIMARY KEY (`id`,`owner_id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`,`owner_id`,`team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adlinks`
--
ALTER TABLE `adlinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
