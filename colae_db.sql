-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 06:40 AM
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
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int(11) NOT NULL,
  `sport` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `sport`, `created_at`) VALUES
(17, 'asda', '2025-08-14 22:26:34'),
(18, 'Teste', '2025-08-14 22:26:44'),
(19, 'Teste', '2025-08-14 22:31:02');

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
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `birthdate`, `password_hash`, `role`, `status`, `created_at`) VALUES
(1, 'Joao Pedro', 'jpcslengman@gmail.com', '2005-12-20', '$2y$10$URnNnhIbKCoq7B31To1fLuuG5T7yo0y7BfkEEiyIhz00YjL.qX9py', 'admin', 'active', '2025-08-13 20:56:29'),
(6, 'Rafael ', 'rafael@emai.com', '2025-08-12', '$2y$10$atigyrcglIieI9f.sqf/0eRIqh3Hfromp7/d/UynYA9hGpUZmCd2.', 'admin', 'active', '2025-08-13 20:56:29'),
(9, 'TesteFoda', 'testefoda@email.com', '2025-07-29', '$2y$10$hBdDOAt4YRYCjFg9ml.5.uEadf2wG2U59pgdHL.3jOSdamp07zHW6', 'user', 'active', '2025-08-13 21:10:32'),
(10, 'Rafael 123', 'jpcslengman@gmail.com', '2025-08-01', '$2y$10$/8m7R.TpkgXQiD4BuEfGheGcmXCV4.w7aL2o/3CFX5dgPfqRGZUVG', 'user', 'active', '2025-08-20 19:42:40'),
(11, 'Rafael ', 'jpcslengman@gmail.com', '2025-07-29', '$2y$10$vHMiRNKNEobS3/z.RHs1weSEHJne/45iQnEjNmyQfpBqCdCZSObxe', 'user', 'inactive', '2025-08-20 22:41:07'),
(12, 'João Pedro Chagas Slengman', 'jpcslengman@gmail.com', '2025-08-18', '$2y$10$HprVqfr60BxygnsTfLMmn.46C4OlpQ14PYkgKGPIQuo2TFiZrF50u', 'user', 'inactive', '2025-08-20 22:41:05'),
(13, 'João Pedro Chagas Slengman', 'jpcslengman@gmail.com', '2025-08-12', '$2y$10$rXAwKXLN2BMHngJMgeJwguUUlkpVrlG/KpUm8onyAyFVdhRck8.ce', 'user', 'active', '2025-08-21 04:19:24'),
(14, 'Futebol', 'teste@email.com', '2025-08-11', '$2y$10$8uWHpZY3Yq.8BAMXihysDeaikcVg2HXBNYSggcyxFvK70UHMUejWG', 'user', 'active', '2025-08-21 04:28:37'),
(15, 'TesteFoda', 'teste@email.com', '2025-08-21', '$2y$10$sB20G.kpg0H7aXnicJ74kOjIjxhNU6zr3cutFhsNpsxTmU7k4L9ZO', 'user', 'active', '2025-08-21 04:35:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
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
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
