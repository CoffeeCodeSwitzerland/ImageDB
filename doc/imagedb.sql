-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 28. Apr 2018 um 09:47
-- Server-Version: 10.1.26-MariaDB
-- PHP-Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `imagedb`
--
CREATE DATABASE IF NOT EXISTS `imagedb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `imagedb`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `authority`
--

DROP TABLE IF EXISTS `authority`;
CREATE TABLE `authority` (
  `AuthorityId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `GalleryId` int(11) NOT NULL,
  `RightId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery`
--

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `GalleryId` int(11) NOT NULL,
  `OwnerId` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Description` text,
  `DirectoryPath` text NOT NULL,
  `ShowTitle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `ImageId` int(11) NOT NULL,
  `GalleryId` int(11) NOT NULL,
  `Name` text NOT NULL,
  `RelativePath` text NOT NULL,
  `ThumbnailPath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `imagetag`
--

DROP TABLE IF EXISTS `imagetag`;
CREATE TABLE `imagetag` (
  `ImageTagId` int(11) NOT NULL,
  `TagId` int(11) NOT NULL,
  `ImageId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `right`
--

DROP TABLE IF EXISTS `right`;
CREATE TABLE `right` (
  `RightId` int(11) NOT NULL,
  `Role` text NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `TagId` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `UserId` int(11) NOT NULL,
  `Emailaddress` text NOT NULL,
  `Password` text NOT NULL,
  `Nickname` text NOT NULL,
  `IsAdmin` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `authority`
--
ALTER TABLE `authority`
  ADD PRIMARY KEY (`AuthorityId`),
  ADD KEY `RightId` (`RightId`),
  ADD KEY `GalleryId` (`GalleryId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indizes für die Tabelle `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`GalleryId`),
  ADD KEY `OwnerId` (`OwnerId`);

--
-- Indizes für die Tabelle `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`ImageId`),
  ADD KEY `GalleryId` (`GalleryId`);

--
-- Indizes für die Tabelle `imagetag`
--
ALTER TABLE `imagetag`
  ADD PRIMARY KEY (`ImageTagId`),
  ADD KEY `ImageId` (`ImageId`),
  ADD KEY `TagId` (`TagId`);

--
-- Indizes für die Tabelle `right`
--
ALTER TABLE `right`
  ADD PRIMARY KEY (`RightId`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`TagId`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `authority`
--
ALTER TABLE `authority`
  MODIFY `AuthorityId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `gallery`
--
ALTER TABLE `gallery`
  MODIFY `GalleryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT für Tabelle `image`
--
ALTER TABLE `image`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `imagetag`
--
ALTER TABLE `imagetag`
  MODIFY `ImageTagId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `right`
--
ALTER TABLE `right`
  MODIFY `RightId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tag`
--
ALTER TABLE `tag`
  MODIFY `TagId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `authority`
--
ALTER TABLE `authority`
  ADD CONSTRAINT `authority_ibfk_1` FOREIGN KEY (`RightId`) REFERENCES `right` (`RightId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authority_ibfk_2` FOREIGN KEY (`GalleryId`) REFERENCES `gallery` (`GalleryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authority_ibfk_3` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`OwnerId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_2` FOREIGN KEY (`GalleryId`) REFERENCES `gallery` (`GalleryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `imagetag`
--
ALTER TABLE `imagetag`
  ADD CONSTRAINT `imagetag_ibfk_1` FOREIGN KEY (`ImageId`) REFERENCES `image` (`ImageId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imagetag_ibfk_2` FOREIGN KEY (`TagId`) REFERENCES `tag` (`TagId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
