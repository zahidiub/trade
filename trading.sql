-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2020 at 12:53 PM
-- Server version: 8.0.21-0ubuntu0.20.04.4
-- PHP Version: 7.4.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trading`
--

-- --------------------------------------------------------

--
-- Table structure for table `EURUSD`
--

CREATE TABLE `EURUSD` (
  `id` int NOT NULL,
  `name` varchar(10) NOT NULL,
  `trade_datetime` timestamp NOT NULL,
  `day_open` float NOT NULL,
  `open` float NOT NULL,
  `high` float NOT NULL,
  `low` float NOT NULL,
  `close` float NOT NULL,
  `change` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `GBPUSD`
--

CREATE TABLE `GBPUSD` (
  `id` int NOT NULL,
  `name` varchar(10) NOT NULL,
  `trade_datetime` timestamp NOT NULL,
  `day_open` float NOT NULL,
  `open` float NOT NULL,
  `high` float NOT NULL,
  `low` float NOT NULL,
  `close` float NOT NULL,
  `change` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `NZDJPY`
--

CREATE TABLE `NZDJPY` (
  `id` int NOT NULL,
  `name` varchar(10) NOT NULL,
  `trade_datetime` timestamp NOT NULL,
  `day_open` float NOT NULL,
  `open` float NOT NULL,
  `high` float NOT NULL,
  `low` float NOT NULL,
  `close` float NOT NULL,
  `change` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `NZDUSD`
--

CREATE TABLE `NZDUSD` (
  `id` int NOT NULL,
  `name` varchar(10) NOT NULL,
  `trade_datetime` timestamp NOT NULL,
  `day_open` float NOT NULL,
  `open` float NOT NULL,
  `high` float NOT NULL,
  `low` float NOT NULL,
  `close` float NOT NULL,
  `change` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pairs`
--

CREATE TABLE `pairs` (
  `p_id` int NOT NULL,
  `p_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pairs`
--

INSERT INTO `pairs` (`p_id`, `p_name`) VALUES
(1, 'EURUSD'),
(2, 'EURGBP'),
(3, 'EURAUD'),
(4, 'EURCHF'),
(5, 'EURHUF'),
(6, 'EURJPY'),
(7, 'EURNZD'),
(8, 'EURCAD'),
(9, 'USDCAD'),
(10, 'USDCHF'),
(11, 'USDJPY'),
(12, 'NZDUSD'),
(13, 'GBPUSD'),
(14, 'NZDJPY');

-- --------------------------------------------------------

--
-- Table structure for table `pairs_watchlist`
--

CREATE TABLE `pairs_watchlist` (
  `pw_id` int NOT NULL,
  `p_id_fk` int NOT NULL,
  `w_id_fk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pairs_watchlist`
--

INSERT INTO `pairs_watchlist` (`pw_id`, `p_id_fk`, `w_id_fk`) VALUES
(1, 1, 1),
(2, 12, 1),
(3, 13, 1),
(5, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `id` int NOT NULL,
  `aa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Zahid Nadeem', 'zahidiubb@yahoo.com', NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, '2020-09-29 01:57:32', '2020-09-29 01:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `w_id` int NOT NULL,
  `w_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`w_id`, `w_name`) VALUES
(1, 'My Wishlist');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `EURUSD`
--
ALTER TABLE `EURUSD`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `GBPUSD`
--
ALTER TABLE `GBPUSD`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `NZDJPY`
--
ALTER TABLE `NZDJPY`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `NZDUSD`
--
ALTER TABLE `NZDUSD`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pairs`
--
ALTER TABLE `pairs`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `pairs_watchlist`
--
ALTER TABLE `pairs_watchlist`
  ADD PRIMARY KEY (`pw_id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`w_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `EURUSD`
--
ALTER TABLE `EURUSD`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `GBPUSD`
--
ALTER TABLE `GBPUSD`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `NZDJPY`
--
ALTER TABLE `NZDJPY`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `NZDUSD`
--
ALTER TABLE `NZDUSD`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pairs`
--
ALTER TABLE `pairs`
  MODIFY `p_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pairs_watchlist`
--
ALTER TABLE `pairs_watchlist`
  MODIFY `pw_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `temp`
--
ALTER TABLE `temp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `w_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
