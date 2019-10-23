-- Adminer 4.7.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `SM_table` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `SM_table`;

DROP TABLE IF EXISTS `scans`;
CREATE TABLE `scans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `titulo` text NOT NULL,
  `uid` text NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0 no 1 si  2 borrado',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `scans` (`id`, `nombre`, `titulo`, `uid`, `estado`) VALUES
(10,	'German Alejandro',	'Foto de la aplicacion , tomada de iconarchive',	'181632cb-9517-47a5-a0b3-0ab64ce59c30',	0),
(11,	'Juan Manuel',	'Foto grande de ubuntu, fondo de pantalla',	'bd7380bd-b148-4969-8854-86324428f694',	0),
(12,	'test1',	'123',	'af81bffd-d288-46cf-bb0f-3f20561cf2c5',	0);

-- 2019-10-23 14:56:48