-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2017 at 10:39 
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

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
  `link1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link2` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link3` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link4` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link5` varchar(128) CHARACTER SET utf8 NOT NULL,
  `text` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link6` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link7` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link8` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link9` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link10` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link11` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link12` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link13` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link14` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link15` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link16` varchar(128) NOT NULL,
  `link17` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link18` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link19` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link20` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link21` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link22` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link23` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link24` varchar(128) CHARACTER SET utf8 NOT NULL,
  `link25` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adlinks`
--

INSERT INTO `adlinks` (`id`, `owner_id`, `team_id`, `link1`, `link2`, `link3`, `link4`, `link5`, `text`, `link6`, `link7`, `link8`, `link9`, `link10`, `link11`, `link12`, `link13`, `link14`, `link15`, `link16`, `link17`, `link18`, `link19`, `link20`, `link21`, `link22`, `link23`, `link24`, `link25`) VALUES
(1, 1, 8, 'asd.fi', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `owner_id`, `user_id`, `team_id`, `name`, `date`) VALUES
(29, 1, 1, 8, 'Iso', '2017-03-29'),
(30, 1, 1, 8, 'Kunnon RytinÃ¤', '2017-03-29'),
(31, 1, 11, 8, 'asd', '2017-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `guess`
--

CREATE TABLE `guess` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `answer` varchar(128) CHARACTER SET utf8 NOT NULL,
  `firstName` varchar(128) CHARACTER SET utf8 NOT NULL,
  `lastName` varchar(128) CHARACTER SET utf8 NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `firstName` varchar(128) CHARACTER SET utf8 NOT NULL,
  `lastName` varchar(128) CHARACTER SET utf8 NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `user_id`, `team_id`, `firstName`, `lastName`, `number`) VALUES
(5, 1, 8, 'Suuri', 'Johtaja', 88),
(6, 1, 8, 'Janne', 'Karppinen', 43),
(7, 1, 8, 'Hannu', 'Karpo', 65),
(9, 1, 8, 'Pelle', 'Peloton', 1),
(10, 1, 8, 'Esa', 'Pekka', 42),
(11, 11, 8, 'Ymir', 'JÃ¤ttilÃ¤inen', 54);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Joukkueen luoja',
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `serie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `user_id`, `name`, `serie`) VALUES
(8, 1, 'NuijapÃ¤Ã¤t', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'Tilintyyppi',
  `owner_id` int(11) NOT NULL COMMENT 'Joukkuetilin omistaja',
  `team_id` int(11) NOT NULL COMMENT 'Joukkuetileille',
  `uid` varbinary(128) NOT NULL,
  `sport` int(11) NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 NOT NULL,
  `pwd` varchar(128) CHARACTER SET utf8 NOT NULL,
  `hash` char(32) CHARACTER SET utf8 NOT NULL,
  `activated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `type`, `owner_id`, `team_id`, `uid`, `sport`, `email`, `pwd`, `hash`, `activated`) VALUES
(1, 0, 1, 0, 0x61646d696e, 1, 'janne.karppinen@appstudios.fi', '$2a$08$fqz3EkuUnunA/a7MWorU9.xEIZtM20rQpv8xFF/TYENPHbYH.5PSq', '6ecbdd6ec859d284dc13885a37ce8d81', 1),
(11, 1, 1, 8, 0x53616d6d616b6f74, 1, 'hypetremethewanderer@gmail.com', '$2a$08$Cr1nnhuln.0c5AMkJUMZyO1KnEwdjG70crG/7x15fVavjFlcbC.Em', 'd82c8d1619ad8176d665453cfb2e55f0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adlinks`
--
ALTER TABLE `adlinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `guess`
--
ALTER TABLE `guess`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adlinks`
--
ALTER TABLE `adlinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `guess`
--
ALTER TABLE `guess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `adlinks`
--
ALTER TABLE `adlinks`
  ADD CONSTRAINT `adlinks_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guess`
--
ALTER TABLE `guess`
  ADD CONSTRAINT `guess_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `player_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
