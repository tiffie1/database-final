-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2026 at 01:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MovieData`
--
CREATE DATABASE IF NOT EXISTS `MovieData` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `MovieData`;

-- --------------------------------------------------------

--
-- Table structure for table `Actor`
--

CREATE TABLE IF NOT EXISTS `Actor` (
  `ActorID` int(11) NOT NULL,
  `ActorName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ActorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Acts_In`
--

CREATE TABLE IF NOT EXISTS `Acts_In` (
  `ActorID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`ActorID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Available_In`
--

CREATE TABLE IF NOT EXISTS `Available_In` (
  `CountryID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`CountryID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `CountryID` int(11) NOT NULL,
  `CountryName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`CountryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Director`
--

CREATE TABLE IF NOT EXISTS `Director` (
  `DirectorID` int(11) NOT NULL,
  `DirectorName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`DirectorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Directs`
--

CREATE TABLE IF NOT EXISTS `Directs` (
  `DirectorID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`DirectorID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Genre`
--

CREATE TABLE IF NOT EXISTS `Genre` (
  `GenreID` int(11) NOT NULL,
  `GenreName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`GenreID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Has_Genre`
--

CREATE TABLE IF NOT EXISTS `Has_Genre` (
  `GenreID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`GenreID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Has_Language`
--

CREATE TABLE IF NOT EXISTS `Has_Language` (
  `LanguageID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`LanguageID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Has_Link`
--

CREATE TABLE IF NOT EXISTS `Has_Link` (
  `LinkID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`LinkID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Has_Tag`
--

CREATE TABLE IF NOT EXISTS `Has_Tag` (
  `TagID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`TagID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Has_Trailer`
--

CREATE TABLE IF NOT EXISTS `Has_Trailer` (
  `TrailerID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`TrailerID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Language`
--

CREATE TABLE IF NOT EXISTS `Language` (
  `LanguageID` int(11) NOT NULL,
  `LanguageName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`LanguageID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Media`
--

CREATE TABLE IF NOT EXISTS `Media` (
  `MediaID` int(11) NOT NULL,
  `MediaType` varchar(6) DEFAULT NULL,
  `HiddenGemScore` float DEFAULT NULL,
  `MinMinutes` int(11) DEFAULT NULL,
  `MaxMinutes` int(11) DEFAULT NULL,
  `ViewRating` varchar(10) DEFAULT NULL,
  `IMDbScore` float DEFAULT NULL,
  `RottenTomatoesScore` float DEFAULT NULL,
  `MetacriticScore` float DEFAULT NULL,
  `AwardsReceived` int(11) DEFAULT NULL,
  `AwardsNominated` int(11) DEFAULT NULL,
  `BoxOffice` float DEFAULT NULL,
  `ReleaseDate` date DEFAULT NULL,
  `NetflixReleaseDate` date DEFAULT NULL,
  `Summary` varchar(500) DEFAULT NULL,
  `IMDbVotes` float DEFAULT NULL,
  PRIMARY KEY (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MediaLinks`
--

CREATE TABLE IF NOT EXISTS `MediaLinks` (
  `LinkID` int(11) NOT NULL,
  `NetflixLink` varchar(200) DEFAULT NULL,
  `IMDBLink` varchar(200) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `Poster` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`LinkID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MediaTrailer`
--

CREATE TABLE IF NOT EXISTS `MediaTrailer` (
  `TrailerID` int(11) NOT NULL,
  `IMDbTrailer` varchar(200) DEFAULT NULL,
  `TrailerSite` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`TrailerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Produces`
--

CREATE TABLE IF NOT EXISTS `Produces` (
  `ProductionHouseID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`ProductionHouseID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProductionHouse`
--

CREATE TABLE IF NOT EXISTS `ProductionHouse` (
  `ProductionHouseID` int(11) NOT NULL,
  `ProductionHouseName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ProductionHouseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

CREATE TABLE IF NOT EXISTS `Tag` (
  `TagID` int(11) NOT NULL,
  `TagName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`TagID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Writer`
--

CREATE TABLE IF NOT EXISTS `Writer` (
  `WriterID` int(11) NOT NULL,
  `WriterName` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`WriterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Writes`
--

CREATE TABLE IF NOT EXISTS `Writes` (
  `WriterID` int(11) NOT NULL,
  `MediaID` int(11) NOT NULL,
  PRIMARY KEY (`WriterID`,`MediaID`),
  KEY `MediaID` (`MediaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Acts_In`
--
ALTER TABLE `Acts_In`
  ADD CONSTRAINT `Acts_In_ibfk_1` FOREIGN KEY (`ActorID`) REFERENCES `Actor` (`ActorID`),
  ADD CONSTRAINT `Acts_In_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Available_In`
--
ALTER TABLE `Available_In`
  ADD CONSTRAINT `Available_In_ibfk_1` FOREIGN KEY (`CountryID`) REFERENCES `Country` (`CountryID`),
  ADD CONSTRAINT `Available_In_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Directs`
--
ALTER TABLE `Directs`
  ADD CONSTRAINT `Directs_ibfk_1` FOREIGN KEY (`DirectorID`) REFERENCES `Director` (`DirectorID`),
  ADD CONSTRAINT `Directs_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Has_Genre`
--
ALTER TABLE `Has_Genre`
  ADD CONSTRAINT `Has_Genre_ibfk_1` FOREIGN KEY (`GenreID`) REFERENCES `Genre` (`GenreID`),
  ADD CONSTRAINT `Has_Genre_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Has_Language`
--
ALTER TABLE `Has_Language`
  ADD CONSTRAINT `Has_Language_ibfk_1` FOREIGN KEY (`LanguageID`) REFERENCES `Language` (`LanguageID`),
  ADD CONSTRAINT `Has_Language_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Has_Link`
--
ALTER TABLE `Has_Link`
  ADD CONSTRAINT `Has_Link_ibfk_1` FOREIGN KEY (`LinkID`) REFERENCES `MediaLinks` (`LinkID`),
  ADD CONSTRAINT `Has_Link_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Has_Tag`
--
ALTER TABLE `Has_Tag`
  ADD CONSTRAINT `Has_Tag_ibfk_1` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`TagID`),
  ADD CONSTRAINT `Has_Tag_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Has_Trailer`
--
ALTER TABLE `Has_Trailer`
  ADD CONSTRAINT `Has_Trailer_ibfk_1` FOREIGN KEY (`TrailerID`) REFERENCES `MediaTrailer` (`TrailerID`),
  ADD CONSTRAINT `Has_Trailer_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Produces`
--
ALTER TABLE `Produces`
  ADD CONSTRAINT `Produces_ibfk_1` FOREIGN KEY (`ProductionHouseID`) REFERENCES `ProductionHouse` (`ProductionHouseID`),
  ADD CONSTRAINT `Produces_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);

--
-- Constraints for table `Writes`
--
ALTER TABLE `Writes`
  ADD CONSTRAINT `Writes_ibfk_1` FOREIGN KEY (`WriterID`) REFERENCES `Writer` (`WriterID`),
  ADD CONSTRAINT `Writes_ibfk_2` FOREIGN KEY (`MediaID`) REFERENCES `Media` (`MediaID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
