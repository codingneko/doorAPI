SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `doors` (
  `id` int(11) NOT NULL,
  `doorName` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `registry` (
  `id` int(11) NOT NULL,
  `status` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `doorId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `doors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `registry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doorId` (`doorId`);

ALTER TABLE `doors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `registry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `registry`
  ADD CONSTRAINT `registry_ibfk_1` FOREIGN KEY (`doorId`) REFERENCES `doors` (`id`) ON DELETE CASCADE;