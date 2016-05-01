-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Creato il: Apr 27, 2016 alle 22:05
-- Versione del server: 5.6.26
-- Versione PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s3940125`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `librocondiviso`
--

CREATE TABLE IF NOT EXISTS `librocondiviso` (
  `isbn` varchar(13) NOT NULL,
  `proprietario` varchar(100) NOT NULL,
  `latitudine` double NOT NULL,
  `longitudine` double NOT NULL,
  `datacondivisione` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `datames` datetime NOT NULL,
  `mittente` varchar(100) NOT NULL,
  `destinatario` varchar(100) NOT NULL,
  `testo` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE IF NOT EXISTS `prenotazione` (
  `richiedente` varchar(100) NOT NULL,
  `data` datetime NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `proprietario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prestiti`
--

CREATE TABLE IF NOT EXISTS `prestiti` (
  `richiedente` varchar(100) NOT NULL,
  `dataprestito` datetime NOT NULL,
  `proprietario` varchar(100) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `stato` enum('incorso','storico','nonconfermato','inrestituzione') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `cognome` varchar(40) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `genere` varchar(20) DEFAULT NULL,
  `sesso` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `user_prova`
--

CREATE TABLE IF NOT EXISTS `user_prova` (
  `email` varchar(50) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `password` int(30) NOT NULL,
  `genere` varchar(20) DEFAULT NULL,
  `sesso` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `user_prova`
--

INSERT INTO `user_prova` (`email`, `nome`, `cognome`, `password`, `genere`, `sesso`) VALUES
('a@a.it', 'Jonni', 'Merlo', 123, NULL, NULL),
('dsfsdf@h.te', 'asdasd', 'asdasd', 40, NULL, NULL),
('simonemerello@hotmail.it', 'asdr', 'asd', 40, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `valutazione`
--

CREATE TABLE IF NOT EXISTS `valutazione` (
  `valutatore` varchar(100) NOT NULL,
  `valutato` varchar(100) NOT NULL,
  `voto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `librocondiviso`
--
ALTER TABLE `librocondiviso`
  ADD PRIMARY KEY (`isbn`,`proprietario`),
  ADD KEY `isbn` (`isbn`),
  ADD KEY `isbn_2` (`isbn`),
  ADD KEY `proprietario` (`proprietario`);

--
-- Indici per le tabelle `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`datames`,`mittente`,`destinatario`),
  ADD KEY `mittente` (`mittente`),
  ADD KEY `destinatario` (`destinatario`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`richiedente`,`isbn`,`proprietario`),
  ADD KEY `proprietario` (`proprietario`),
  ADD KEY `isbn` (`isbn`);

--
-- Indici per le tabelle `prestiti`
--
ALTER TABLE `prestiti`
  ADD PRIMARY KEY (`richiedente`,`dataprestito`,`proprietario`,`isbn`),
  ADD KEY `proprietario` (`proprietario`),
  ADD KEY `isbn` (`isbn`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `user_prova`
--
ALTER TABLE `user_prova`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `valutazione`
--
ALTER TABLE `valutazione`
  ADD PRIMARY KEY (`valutatore`,`valutato`),
  ADD KEY `valutato` (`valutato`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `librocondiviso`
--
ALTER TABLE `librocondiviso`
  ADD CONSTRAINT `librocondiviso_ibfk_1` FOREIGN KEY (`proprietario`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`mittente`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`destinatario`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`richiedente`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazione_ibfk_2` FOREIGN KEY (`proprietario`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazione_ibfk_3` FOREIGN KEY (`isbn`) REFERENCES `librocondiviso` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prestiti`
--
ALTER TABLE `prestiti`
  ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`richiedente`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prestiti_ibfk_2` FOREIGN KEY (`proprietario`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prestiti_ibfk_3` FOREIGN KEY (`isbn`) REFERENCES `librocondiviso` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `valutazione`
--
ALTER TABLE `valutazione`
  ADD CONSTRAINT `valutazione_ibfk_1` FOREIGN KEY (`valutatore`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valutazione_ibfk_2` FOREIGN KEY (`valutato`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
