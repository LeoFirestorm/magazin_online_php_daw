-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 01:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magazin_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorii`
--

CREATE TABLE `categorii` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorii`
--

INSERT INTO `categorii` (`id`, `nume`) VALUES
(1, 'Electronice & Gadgets'),
(2, 'Fashion & Îmbrăcăminte'),
(3, 'Casa & Grădină'),
(4, 'Sport & Activități');

-- --------------------------------------------------------

--
-- Table structure for table `comenzi`
--

CREATE TABLE `comenzi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nume_client` varchar(100) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `data_comenzii` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comenzi`
--

INSERT INTO `comenzi` (`id`, `user_id`, `nume_client`, `total`, `data_comenzii`) VALUES
(1, 4, 'Vanzator Simplu', 123.00, '2026-01-21 03:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `detalii_comanda`
--

CREATE TABLE `detalii_comanda` (
  `id` int(11) NOT NULL,
  `comanda_id` int(11) DEFAULT NULL,
  `produs_id` int(11) DEFAULT NULL,
  `nume_produs` varchar(200) DEFAULT NULL,
  `pret` decimal(10,2) DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produse`
--

CREATE TABLE `produse` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `nume` varchar(200) NOT NULL,
  `descriere` text DEFAULT NULL,
  `pret` decimal(10,2) NOT NULL,
  `imagine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produse`
--

INSERT INTO `produse` (`id`, `categorie_id`, `nume`, `descriere`, `pret`, `imagine`) VALUES
(1, 1, 'Smartphone Galaxy S23', 'Telefon performant, camera 50MP, 128GB stocare.', 3800.00, 'phone_s23.jpg'),
(2, 1, 'Laptop UltraBook Pro', 'Procesor i7, 16GB RAM, SSD 512GB, ușor și portabil.', 4500.00, 'laptop_pro.jpg'),
(3, 1, 'Căști Wireless Noise', 'Anulare activă a zgomotului, baterie 30h.', 850.00, 'casti.jpg'),
(4, 1, 'Smartwatch Fitness', 'Monitorizare puls, pași, rezistent la apă.', 450.00, 'ceas.jpg'),
(5, 1, 'Tabletă Grafică', 'Ideală pentru desen digital și editare foto.', 1200.00, 'tableta.jpg'),
(6, 2, 'Tricou Bumbac Premium', '100% Bumbac organic, culoare albă, mărimea L.', 85.00, 'tricou_alb.jpg'),
(7, 2, 'Blugi Slim Fit', 'Material rezistent, culoare albastru închis.', 220.00, 'blugi.jpg'),
(8, 2, 'Hanorac Urban', 'Hanorac cu glugă, foarte călduros.', 180.00, 'hanorac.jpg'),
(9, 2, 'Adidași Alergare', 'Talpă spumă, foarte ușori, ideali pentru maraton.', 350.00, 'adidasi.jpg'),
(10, 2, 'Geacă Iarnă Impermeabilă', 'Rezistă la vânt și ploaie, căptușeală groasă.', 550.00, 'geaca.jpg'),
(11, 3, 'Espressor Automat', 'Cafea proaspătă la o apăsare de buton.', 1600.00, 'espressor.jpg'),
(12, 3, 'Lampă Birou LED', 'Lumină ajustabilă, protecție pentru ochi.', 120.00, 'lampa.jpg'),
(13, 3, 'Set Mobilier Grădină', 'Masă și 4 scaune din ratan sintetic.', 2500.00, 'mobilier.jpg'),
(14, 3, 'Bormașină Acumulator', 'Trusă completă cu biți și 2 baterii incluse.', 450.00, 'bormasina.jpg'),
(15, 4, 'Bicicletă MTB 29\"', 'Cadru aluminiu, suspensie față, frâne disc.', 2100.00, 'bicicleta.jpg'),
(16, 4, 'Minge Fotbal Pro', 'Minge oficială mărimea 5.', 150.00, 'minge.jpg'),
(17, 4, 'Set Gantere Reglabile', 'Greutăți de la 2kg la 20kg.', 300.00, 'gantere.jpg'),
(18, 4, 'Rachetă Tenis', 'Material grafit, ușoară și rezistentă.', 600.00, 'racheta.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `recenzii`
--

CREATE TABLE `recenzii` (
  `id` int(11) NOT NULL,
  `produs_id` int(11) DEFAULT NULL,
  `nume_utilizator` varchar(100) DEFAULT NULL,
  `comentariu` text DEFAULT NULL,
  `nota` int(11) DEFAULT NULL CHECK (`nota` >= 1 and `nota` <= 5),
  `data_adaugarii` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recenzii`
--

INSERT INTO `recenzii` (`id`, `produs_id`, `nume_utilizator`, `comentariu`, `nota`, `data_adaugarii`) VALUES
(1, 1, 'Ionut P.', 'Cel mai bun telefon pe care l-am avut!', 5, '2026-01-21 03:05:39'),
(2, 2, 'Maria T.', 'Laptopul e bun, dar se încălzește puțin în jocuri.', 4, '2026-01-21 03:05:39'),
(3, 6, 'Andrei M.', 'Material de calitate, recomand.', 5, '2026-01-21 03:05:39'),
(4, 11, 'Elena D.', 'Cafeaua iese exact ca la cafenea.', 5, '2026-01-21 03:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `rol` enum('client','admin') DEFAULT 'client',
  `data_inregistrarii` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `email`, `parola`, `rol`, `data_inregistrarii`) VALUES
(1, 'Vanzator Sef', 'admin@magazin.ro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-01-21 01:28:54'),
(2, 'sdasd', '123@gmail.com', '$2y$10$KrPSxGHJBAdSRyW9V2ner.WqztLOpMO8ANH/S9dxerzNnLkF2VcDi', 'client', '2026-01-21 01:43:52'),
(3, 'Vanzator Test', 'admin@test.ro', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'admin', '2026-01-21 01:57:34'),
(4, 'Vanzator Simplu', 'vanzator@test.ro', '123456', 'admin', '2026-01-21 02:06:48'),
(5, 'Client Simplu', 'client@test.ro', '123456', 'client', '2026-01-21 02:06:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorii`
--
ALTER TABLE `categorii`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalii_comanda`
--
ALTER TABLE `detalii_comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comanda_id` (`comanda_id`);

--
-- Indexes for table `produse`
--
ALTER TABLE `produse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `recenzii`
--
ALTER TABLE `recenzii`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produs_id` (`produs_id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorii`
--
ALTER TABLE `categorii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comenzi`
--
ALTER TABLE `comenzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detalii_comanda`
--
ALTER TABLE `detalii_comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produse`
--
ALTER TABLE `produse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `recenzii`
--
ALTER TABLE `recenzii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalii_comanda`
--
ALTER TABLE `detalii_comanda`
  ADD CONSTRAINT `detalii_comanda_ibfk_1` FOREIGN KEY (`comanda_id`) REFERENCES `comenzi` (`id`);

--
-- Constraints for table `produse`
--
ALTER TABLE `produse`
  ADD CONSTRAINT `produse_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorii` (`id`);

--
-- Constraints for table `recenzii`
--
ALTER TABLE `recenzii`
  ADD CONSTRAINT `recenzii_ibfk_1` FOREIGN KEY (`produs_id`) REFERENCES `produse` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
