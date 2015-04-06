SET NAMES utf8;
SET time_zone = '+00:00';

CREATE DATABASE `cpasfaux` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cpasfaux`;

CREATE TABLE `livre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `personnage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `citation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `episode` varchar(255) NOT NULL,
  `idPersonnage` int(11) NOT NULL,
  `idLivre` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idLivre` (`idLivre`),
  KEY `idPersonnage` (`idPersonnage`),
  CONSTRAINT `citation_ibfk_2` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`id`),
  CONSTRAINT `citation_ibfk_1` FOREIGN KEY (`idLivre`) REFERENCES `livre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
