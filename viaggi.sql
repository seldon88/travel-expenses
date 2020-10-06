-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Nov 24, 2019 alle 17:46
-- Versione del server: 5.7.26
-- Versione PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `viaggi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `trasferte`
--

DROP TABLE IF EXISTS `trasferte`;
CREATE TABLE IF NOT EXISTS `trasferte` (
  `trasferte_id` int(11) NOT NULL AUTO_INCREMENT,
  `destinazione` varchar(45) DEFAULT NULL,
  `distanzaInKm` int(10) UNSIGNED DEFAULT NULL,
  `dataTrasferta` date DEFAULT NULL,
  `dipendente_id` int(11) DEFAULT NULL,
  `motivazione` varchar(255) DEFAULT NULL,
  `partenza` varchar(255) DEFAULT NULL,
  `autostrada` int(11) DEFAULT NULL,
  `trasportoPubblico` int(11) DEFAULT NULL,
  `altreSpese` int(11) DEFAULT NULL,
  `rimborsato` varchar(2) DEFAULT NULL,
  `rimborsoTotale` int(11) DEFAULT NULL,
  PRIMARY KEY (`trasferte_id`),
  KEY `dipendente_id` (`dipendente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `trasferte`
--

INSERT INTO `trasferte` (`trasferte_id`, `destinazione`, `distanzaInKm`, `dataTrasferta`, `dipendente_id`, `motivazione`, `partenza`, `autostrada`, `trasportoPubblico`, `altreSpese`, `rimborsato`, `rimborsoTotale`) VALUES
(1, 'Udine', 50, '2019-09-22', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Padova', 100, '2019-09-24', 2, NULL, NULL, NULL, NULL, NULL, 'si', NULL),
(3, 'Trieste', 100, '2019-09-30', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Pordenone', 54, '2019-10-08', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Pola', 250, '2019-10-09', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Treviso', 50, '2019-10-27', 2, NULL, NULL, NULL, NULL, NULL, 'si', NULL),
(7, 'San fior', 30, '2014-10-10', 2, NULL, NULL, NULL, NULL, NULL, 'si', NULL),
(8, 'Udine', 100, '2019-04-10', 2, 'Conferenza', 'Pordenone', 10, 10, 10, NULL, NULL),
(9, 'Mestre', 110, '2019-11-06', 2, 'Gita', 'Pordenone', 50, 0, 0, 'si', 270),
(10, 'Padova', 250, '2019-11-17', 4, 'Conferenza', 'Pordenone', 10, 0, 0, NULL, 221),
(11, 'Milano', 500, '2019-11-17', 4, 'Conferenza', 'Pordenone', 10, 0, 0, NULL, 432),
(12, 'Padova', 100, '2019-11-24', 2, 'Conferenza', 'Mestre', 10, 0, 15, NULL, 94),
(13, 'Belluno', 100, '2018-01-01', 2, 'Conferenza', 'Mestre', 10, 0, 15, 'si', 109);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE IF NOT EXISTS `utenti` (
  `dipendente_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `cognome` varchar(45) DEFAULT NULL,
  `dataDiNascita` date DEFAULT NULL,
  `sesso` enum('M','F') DEFAULT NULL,
  `tipo_utente` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`dipendente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`dipendente_id`, `username`, `password`, `nome`, `cognome`, `dataDiNascita`, `sesso`, `tipo_utente`) VALUES
(1, 'admin', '$2y$10$MwzUpXDxnsElimUVi.Z.p.PjamSuThy7GM22Mi5fRSoqE7c0KYOPW', 'admin', 'admin', '1988-04-06', 'M', 'admin'),
(2, 'rossi', '$2y$10$MwzUpXDxnsElimUVi.Z.p.PjamSuThy7GM22Mi5fRSoqE7c0KYOPW', 'Mario', 'Rossi', '1950-01-02', 'M', 'dipendente'),
(3, 'bianchi', '$2y$10$MwzUpXDxnsElimUVi.Z.p.PjamSuThy7GM22Mi5fRSoqE7c0KYOPW', 'Giuseppe', 'Bianchi', '1992-06-30', 'M', 'dipendente'),
(4, 'topolino', '$2y$10$taxgzZ6/il8z7UFyRIUHHueidEi3dsrC87esSDyprspEXBSYyKAYm', 'Topolino', 'Mickey', '1986-06-08', 'M', 'dipendente'),
(5, 'pippo', '$2y$10$ST/DRRRHrHtQgx2p0mIC1.DOhEJkikhEcGQ8HdFerGJYBnDAs.ORe', 'Pippo', 'Nonso', '1980-02-03', 'M', 'dipendente');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
