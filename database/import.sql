-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `kaamelot`;
CREATE DATABASE `kaamelot` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `kaamelot`;

DROP TABLE IF EXISTS `citation`;
CREATE TABLE `citation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `episode` varchar(255) NOT NULL,
  `idPersonnage` int(11) NOT NULL,
  `idLivre` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idLivre` (`idLivre`),
  KEY `idPersonnage` (`idPersonnage`),
  CONSTRAINT `citation_ibfk_1` FOREIGN KEY (`idLivre`) REFERENCES `livre` (`id`),
  CONSTRAINT `citation_ibfk_2` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `citation` (`id`, `content`, `episode`, `idPersonnage`, `idLivre`) VALUES
(12,	'C\'est vrai ce qu\'on dit',	'Les défis de Merlin',	20,	25),
(13,	'C\'est vrai ce qu\'on dit',	'Episode 5 : le dÃ©fi de merlin',	20,	26),
(16,	'bla bla bla bla bla bla bla bla',	'Le défi des connards',	21,	27),
(17,	'C\'est quoi un arabe dans un champs de blé ?',	'b899579334076f1d816d5677f0d7dd1a',	20,	25);

DROP TABLE IF EXISTS `livre`;
CREATE TABLE `livre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `livre` (`id`, `nom`) VALUES
(25,	'livre 1'),
(26,	'livre 2'),
(27,	'livre 69');

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE `personnage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `personnage` (`id`, `nom`) VALUES
(20,	'arthur'),
(21,	'karadoc');

-- 2015-03-31 14:37:47
