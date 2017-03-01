-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `interventi`;
CREATE TABLE `interventi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) NOT NULL,
  `dataintervento` date NOT NULL,
  `descrizione` varchar(100) NOT NULL,
  `spesa` int(11) NOT NULL,
  `ore` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pc_id` (`pc_id`),
  CONSTRAINT `interventi_ibfk_2` FOREIGN KEY (`pc_id`) REFERENCES `pc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `interventi` (`id`, `pc_id`, `dataintervento`, `descrizione`, `spesa`, `ore`) VALUES
(1,	1,	'2017-03-01',	'bel pc',	400,	6),
(2,	4,	'0000-00-00',	'bello bello',	600,	5),
(4,	2,	'0000-00-00',	'troppa roba',	400,	5),
(5,	1,	'0000-00-00',	'na roba wow',	560,	6);

DROP VIEW IF EXISTS `intpc`;
CREATE TABLE `intpc` (`dataintervento` date, `descrizione` varchar(100), `spesa` int(11), `ore` int(11));


DROP VIEW IF EXISTS `listainterventi`;
CREATE TABLE `listainterventi` (`id` int(11), `dataintervento` date, `descrizione` varchar(100), `spesa` int(11), `ore` int(11), `marca` varchar(40), `hostname` varchar(40), `modello` varchar(40), `sn` varchar(40));


DROP TABLE IF EXISTS `marche`;
CREATE TABLE `marche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `marche` (`id`, `marca`) VALUES
(1,	'HP'),
(2,	'ASUS'),
(3,	'ACER'),
(4,	'DELL'),
(5,	'INTEL'),
(7,	'SONY');

DROP TABLE IF EXISTS `pc`;
CREATE TABLE `pc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(40) NOT NULL,
  `marche_id` int(11) NOT NULL,
  `modello` varchar(40) NOT NULL,
  `sn` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `marche_id` (`marche_id`),
  CONSTRAINT `pc_ibfk_3` FOREIGN KEY (`marche_id`) REFERENCES `marche` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pc` (`id`, `hostname`, `marche_id`, `modello`, `sn`) VALUES
(1,	'bianco',	2,	'bello',	'F56t7'),
(2,	'rosso',	3,	'bellissimo',	'898TY'),
(4,	'verde',	5,	'belinchebello',	'F443R'),
(5,	'arancio',	4,	'ehchebello',	'R455F'),
(7,	'bimbo',	3,	'Apple',	'DF665');

DROP TABLE IF EXISTS `intpc`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `intpc` AS select `interventi`.`dataintervento` AS `dataintervento`,`interventi`.`descrizione` AS `descrizione`,`interventi`.`spesa` AS `spesa`,`interventi`.`ore` AS `ore` from (`interventi` join `pc` on((`interventi`.`pc_id` = `pc`.`id`)));

DROP TABLE IF EXISTS `listainterventi`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `listainterventi` AS select `interventi`.`id` AS `id`,`interventi`.`dataintervento` AS `dataintervento`,`interventi`.`descrizione` AS `descrizione`,`interventi`.`spesa` AS `spesa`,`interventi`.`ore` AS `ore`,`marche`.`marca` AS `marca`,`pc`.`hostname` AS `hostname`,`pc`.`modello` AS `modello`,`pc`.`sn` AS `sn` from ((`interventi` join `pc` on((`pc`.`id` = `interventi`.`pc_id`))) join `marche` on((`marche`.`id` = `pc`.`marche_id`)));

-- 2017-03-01 11:32:41
