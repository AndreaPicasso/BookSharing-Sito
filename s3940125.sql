-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 03, 2016 alle 14:05
-- Versione del server: 5.5.47-0+deb8u1
-- PHP Version: 5.6.19-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `S3940125`
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

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`email`, `nome`, `cognome`, `password`, `genere`, `sesso`) VALUES
('andrea0pica@gmail.com', 'Andrea', 'Picasso', '005e73192fec2ec2eeac1e93ae204635c5c764fe', NULL, NULL),
('ggg', 'beh', 'beh', '66fb801b995542a2148481d19b1ced71603b638b', NULL, NULL),
('guido9494@gmail.com', 'Guido', 'Frocio', 'e85169d4ce04e0db7f47b0edaa9cbb31228b18ec', NULL, NULL),
('simonemerello@hotmail.it', 'chiedi', 'chiedi', '32e0bada64b3c2c6fcc5e0df6fc07b547af7d00f', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `USER_PROVA`
--

CREATE TABLE IF NOT EXISTS `USER_PROVA` (
  `email` varchar(50) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `password` int(30) NOT NULL,
  `genere` varchar(20) DEFAULT NULL,
  `sesso` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `USER_PROVA`
--

INSERT INTO `USER_PROVA` (`email`, `nome`, `cognome`, `password`, `genere`, `sesso`) VALUES
('a@a.it', 'Jonni', 'Merlo', 123, NULL, NULL);

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
-- Indexes for dumped tables
--

--
-- Indexes for table `librocondiviso`
--
ALTER TABLE `librocondiviso`
 ADD PRIMARY KEY (`isbn`,`proprietario`), ADD KEY `isbn` (`isbn`), ADD KEY `isbn_2` (`isbn`), ADD KEY `proprietario` (`proprietario`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`datames`,`mittente`,`destinatario`), ADD KEY `mittente` (`mittente`), ADD KEY `destinatario` (`destinatario`);

--
-- Indexes for table `prenotazione`
--
ALTER TABLE `prenotazione`
 ADD PRIMARY KEY (`richiedente`,`isbn`,`proprietario`), ADD KEY `isbn` (`isbn`), ADD KEY `proprietario` (`proprietario`);

--
-- Indexes for table `prestiti`
--
ALTER TABLE `prestiti`
 ADD PRIMARY KEY (`richiedente`,`dataprestito`,`proprietario`,`isbn`), ADD KEY `isbn` (`isbn`), ADD KEY `proprietario` (`proprietario`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`email`), ADD KEY `email` (`email`);

--
-- Indexes for table `USER_PROVA`
--
ALTER TABLE `USER_PROVA`
 ADD PRIMARY KEY (`email`);

--
-- Indexes for table `valutazione`
--
ALTER TABLE `valutazione`
 ADD PRIMARY KEY (`valutatore`,`valutato`), ADD KEY `valutato` (`valutato`);

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
ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`destinatario`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`mittente`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
ADD CONSTRAINT `prenotazione_ibfk_7` FOREIGN KEY (`proprietario`) REFERENCES `librocondiviso` (`proprietario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`richiedente`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prenotazione_ibfk_3` FOREIGN KEY (`isbn`) REFERENCES `librocondiviso` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prenotazione_ibfk_4` FOREIGN KEY (`proprietario`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prenotazione_ibfk_5` FOREIGN KEY (`proprietario`) REFERENCES `librocondiviso` (`proprietario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prenotazione_ibfk_6` FOREIGN KEY (`proprietario`) REFERENCES `librocondiviso` (`proprietario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prestiti`
--
ALTER TABLE `prestiti`
ADD CONSTRAINT `prestiti_ibfk_4` FOREIGN KEY (`proprietario`) REFERENCES `librocondiviso` (`proprietario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`richiedente`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prestiti_ibfk_3` FOREIGN KEY (`isbn`) REFERENCES `librocondiviso` (`isbn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `valutazione`
--
ALTER TABLE `valutazione`
ADD CONSTRAINT `valutazione_ibfk_2` FOREIGN KEY (`valutato`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `valutazione_ibfk_1` FOREIGN KEY (`valutatore`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
