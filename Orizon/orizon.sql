-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ott 27, 2025 alle 20:42
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orizon`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `paesi`
--

DROP TABLE IF EXISTS `paesi`;
CREATE TABLE `paesi` (
  `id_paese` int(255) UNSIGNED NOT NULL COMMENT 'id del paese',
  `nome_paese` varchar(255) NOT NULL COMMENT 'nome del paese'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='tabella paesi ';

--
-- Dump dei dati per la tabella `paesi`
--

INSERT INTO `paesi` (`id_paese`, `nome_paese`) VALUES
(261, 'Argentina'),
(260, 'Brasile'),
(266, 'Indonesia'),
(262, 'Porto Rico'),
(258, 'Repubblica Dominicana'),
(257, 'Stati Uniti D\'America'),
(263, 'Thailandia\r\n'),
(264, 'Vietnam');

-- --------------------------------------------------------

--
-- Struttura della tabella `viaggi`
--

DROP TABLE IF EXISTS `viaggi`;
CREATE TABLE `viaggi` (
  `id_viaggio` int(100) UNSIGNED NOT NULL COMMENT 'id del viaggio',
  `numero_posti_disponibili` int(100) NOT NULL DEFAULT 0 COMMENT 'numero di posti disponibili per viaggio',
  `nome_del_viaggio` varchar(255) NOT NULL COMMENT 'nome del viaggio per distinguerlo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `viaggi`
--

INSERT INTO `viaggi` (`id_viaggio`, `numero_posti_disponibili`, `nome_del_viaggio`) VALUES
(190, 12, 'Tra Grattacieli e Palme'),
(191, 18, 'Tango e Samba: Il Ritmo del Sud America'),
(192, 24, 'Dragon Trail');

-- --------------------------------------------------------

--
-- Struttura della tabella `viaggi_paesi`
--

DROP TABLE IF EXISTS `viaggi_paesi`;
CREATE TABLE `viaggi_paesi` (
  `viaggio_id` int(10) UNSIGNED NOT NULL COMMENT 'ID del viaggio, chiave esterna verso la tabella `viaggi`',
  `paese_id` int(10) UNSIGNED NOT NULL COMMENT 'ID del paese, chiave esterna verso la tabella `paesi`'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `viaggi_paesi`
--

INSERT INTO `viaggi_paesi` (`viaggio_id`, `paese_id`) VALUES
(190, 257),
(190, 258),
(190, 262),
(191, 260),
(191, 261),
(192, 263),
(192, 264),
(192, 266);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `paesi`
--
ALTER TABLE `paesi`
  ADD PRIMARY KEY (`id_paese`),
  ADD UNIQUE KEY `nome_paese` (`nome_paese`);

--
-- Indici per le tabelle `viaggi`
--
ALTER TABLE `viaggi`
  ADD PRIMARY KEY (`id_viaggio`);

--
-- Indici per le tabelle `viaggi_paesi`
--
ALTER TABLE `viaggi_paesi`
  ADD PRIMARY KEY (`viaggio_id`,`paese_id`),
  ADD KEY `fk_viaggi_paesi_paesi_id` (`paese_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `paesi`
--
ALTER TABLE `paesi`
  MODIFY `id_paese` int(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id del paese', AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT per la tabella `viaggi`
--
ALTER TABLE `viaggi`
  MODIFY `id_viaggio` int(100) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id del viaggio', AUTO_INCREMENT=193;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `viaggi_paesi`
--
ALTER TABLE `viaggi_paesi`
  ADD CONSTRAINT `fk_viaggi_paesi_paesi_id` FOREIGN KEY (`paese_id`) REFERENCES `paesi` (`id_paese`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggi_paesi_viaggio_id` FOREIGN KEY (`viaggio_id`) REFERENCES `viaggi` (`id_viaggio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
