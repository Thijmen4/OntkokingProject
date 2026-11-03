-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 03 nov 2026 om 20:53
-- Serverversie: 10.6.23-MariaDB-0ubuntu0.22.04.1
-- PHP-versie: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `104301_program`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ontkoking`
--

CREATE TABLE `ontkoking` (
  `id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `afbeelding` text NOT NULL,
  `ingredienten` text NOT NULL,
  `stappen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ontkoking`
--

INSERT INTO `ontkoking` (`id`, `titel`, `afbeelding`, `ingredienten`, `stappen`) VALUES
(1, 'Gegrilde shawarma fiesta met knapperige tahini', 'shwarma.jpeg', '500 g verse kipfilet zonder bot of oesterzwammen\r\n4 teentjes knoflook, fijngeperst\r\n2 el sumak en gemalen komijn\r\n1 kop verse Griekse yoghurt of tahini\r\n1 bos radijsjes en muntblaadjes\r\n4 op houtvuur gebakken pitabroodjes\r\n2 el koudgeperste extra vierge olijfolie', 'Marineer de basis\r\nMeng de geperste knoflook, sumak, komijn, olijfolie en Griekse yoghurt in een grote kom.\r\n\r\nBereid de tahini en kruiden\r\nMeng de sesampasta met vers muntsap en koud water. Klop stevig tot de saus helder turquoise kleurt.\r\n\r\nBak krokant in de pan\r\nVerhit een zware gietijzeren pan op hoog vuur. Bak de gemarineerde stukjes 6-8 minuten tot de randen krokant zijn.\r\n\r\nVerwarm en stel samen\r\nBak de platbroden 30 seconden op de grill. Beleg ze met de vulling, knapperige radijs en munttahinisaus.'),

DELETE FROM ontkoking WHERE id = 2;
--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `ontkoking`
--
ALTER TABLE `ontkoking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `ontkoking`
--
ALTER TABLE `ontkoking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
