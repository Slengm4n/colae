-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 01:00 AM
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
-- Database: `colae_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `modalities`
--

CREATE TABLE `modalities` (
  `id` int(11) NOT NULL,
  `modality_name` varchar(255) NOT NULL,
  `modality_description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modalities`
--

INSERT INTO `modalities` (`id`, `modality_name`, `modality_description`, `created_at`) VALUES
(10, 'Tenis de mesa', 'Tenis de mesa', '2025-08-12 22:12:08'),
(11, 'Tenis de mesa', 'Tenis de mesa', '2025-08-12 22:16:00'),
(12, 'Tenis de mesa', 'Tenis de mesa', '2025-08-12 22:17:05'),
(13, 'Futebol', 'Muito massa', '2025-08-12 22:17:14'),
(14, 'Basquete', 'muito foda', '2025-08-12 22:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `birthdate`, `password_hash`, `role`) VALUES
(1, 'Joao Pedro', 'jpcslengman@gmail.com', '2005-12-20', '$2y$10$URnNnhIbKCoq7B31To1fLuuG5T7yo0y7BfkEEiyIhz00YjL.qX9py', 'admin'),
(5, 'Teste', 'teste@email.com', '1231-03-21', '$2y$10$DlybeLp8l8T04nS9qy.hBOo2fiOfcgbc21uJFG5VIB2SXi1U2CQK.', 'user'),
(6, 'Rafael ', 'rafael@emai.com', '2025-08-12', '$2y$10$atigyrcglIieI9f.sqf/0eRIqh3Hfromp7/d/UynYA9hGpUZmCd2.', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modalities`
--
ALTER TABLE `modalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modalities`
--
ALTER TABLE `modalities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
