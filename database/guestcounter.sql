DROP DATABASE IF EXISTS `guestcounter`;
CREATE DATABASE `guestcounter`;
USE `guestcounter`;

DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sid`)
);

INSERT INTO `servers` (`sid`, `server`) VALUES
(1, 'mcjim-server.com');

DROP TABLE IF EXISTS `codes`;
CREATE TABLE IF NOT EXISTS `codes` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL,
  `event` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ctype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cid`)
);

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venue` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_fr` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `events` (`id`, `event`, `venue`, `date_fr`, `date_to`, `service`) VALUES
(15, 'Oscar Na Gud Ni Bay!!!', 'Pavilion Hall, Dao, Pagadian City', '2025-10-02', '2025-10-02', 'Guests'),
(16, 'Olivio Rodriga Live Concert', 'Mega Gym, Dao, Pagadian City, Philippines', '2025-10-02', '2025-10-02', 'Guests');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usertype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `usertype`) VALUES
(1, 'Admin Account', 'admin', 'admin', '');

DROP TABLE IF EXISTS `validity`;
CREATE TABLE IF NOT EXISTS `validity` (
  `validity` date DEFAULT NULL
);

INSERT INTO `validity` (`validity`) VALUES
('2030-06-20');
