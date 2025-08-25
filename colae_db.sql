-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/08/2025 às 15:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `colae_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `amenities`
--

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(1, 'jpcslengman@gmail.com', '7c311cff55755ea0f69038a1e36edee39751255114056ede7dbaf9d762e1eb18', '2025-08-25 13:51:39', '2025-08-25 10:51:39'),
(2, 'jpcslengman@gmail.com', 'b2c8b66371e737f8e26834a4ecb5e6b5ed8950a9d14606fe8855ffaad98356f3', '2025-08-25 13:55:15', '2025-08-25 10:55:15'),
(3, 'jpcslengman@gmail.com', '41ec302ea70c897329437e87cf6bffa6af2e8db387250bd57a3189d28d113eeb', '2025-08-25 14:00:08', '2025-08-25 11:00:08'),
(4, 'jpcslengman@gmail.com', '539a2e92ea2da973c3cd010e3c89626a4414a36c99ff66bb603b3a0b925e6495', '2025-08-25 14:04:04', '2025-08-25 11:04:04'),
(5, 'jpcslengman@gmail.com', '9c59b55bba5dc850ca66131c5bf50b98ec5192ccabbe1fc92a9079f40494107e', '2025-08-25 14:06:16', '2025-08-25 11:06:16'),
(6, 'jpcslengman@gmail.com', '686e968699801e7071dc77d2364d529ecc5cb21cba1fcbb4220d19e500bb7f55', '2025-08-25 14:06:52', '2025-08-25 11:06:52'),
(7, 'jpcslengman@gmail.com', '2c3f4c730c497a62b2f1428471726b962046c2844c259d0836ebe78960168304', '2025-08-25 14:06:59', '2025-08-25 11:06:59'),
(8, 'jpcslengman@gmail.com', 'a559a24afc6b660c9ecec81721591dd18bfb68ab8d002e4285588b3221c070bd', '2025-08-25 14:07:47', '2025-08-25 11:07:47'),
(9, 'jpcslengman@gmail.com', '7ab99dfaaceb2ac548b191ada9898d86c33f7fe358b9f67ae15267f2b6fb252c', '2025-08-25 14:07:51', '2025-08-25 11:07:51'),
(10, 'jpcslengman@gmail.com', '993aaac28b547909ea233c6281eca761cef4bec45e70ee16e09981990c19ee48', '2025-08-25 14:07:53', '2025-08-25 11:07:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sports`
--

CREATE TABLE `sports` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `sports`
--

INSERT INTO `sports` (`id`, `name`, `created_at`, `status`) VALUES
(17, 'asda', '2025-08-14 22:26:34', 'active'),
(18, 'Teste', '2025-08-14 22:26:44', 'active'),
(19, 'Teste', '2025-08-14 22:31:02', 'active'),
(20, 'Caça123', '2025-08-25 11:17:32', 'inactive');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
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
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `birthdate`, `password_hash`, `role`, `status`, `created_at`) VALUES
(1, 'Joao Pedro', 'jpcslengman@gmail.com', '2005-12-20', '$2y$10$4TRR4jSouilHO6FhewwxM.NJHCqPw8A30ZxA.RKIx5M9DaGvFh.Y.', 'admin', 'active', '2025-08-25 11:13:24'),
(6, 'Rafael ', 'rafael@emai.com', '2025-08-12', '$2y$10$atigyrcglIieI9f.sqf/0eRIqh3Hfromp7/d/UynYA9hGpUZmCd2.', 'admin', 'inactive', '2025-08-21 14:15:18'),
(9, 'TesteFoda', 'testefoda@email.com', '2025-07-29', '$2y$10$hBdDOAt4YRYCjFg9ml.5.uEadf2wG2U59pgdHL.3jOSdamp07zHW6', 'user', 'inactive', '2025-08-21 14:14:28'),
(10, 'Rafael 123', 'jpcslengman@gmail.com', '2025-08-01', '$2y$10$4TRR4jSouilHO6FhewwxM.NJHCqPw8A30ZxA.RKIx5M9DaGvFh.Y.', 'user', 'inactive', '2025-08-25 11:13:24'),
(11, 'Lil Raff 123', 'lilraff@email.com', '2025-07-29', '$2y$10$vHMiRNKNEobS3/z.RHs1weSEHJne/45iQnEjNmyQfpBqCdCZSObxe', 'user', 'active', '2025-08-21 14:23:41'),
(12, 'João Pedro Chagas Slengman', 'jpcslengman@gmail.com', '2025-08-18', '$2y$10$4TRR4jSouilHO6FhewwxM.NJHCqPw8A30ZxA.RKIx5M9DaGvFh.Y.', 'user', 'inactive', '2025-08-25 11:13:24'),
(13, 'João Pedro Chagas Slengman', 'jpcslengman@gmail.com', '2025-08-12', '$2y$10$4TRR4jSouilHO6FhewwxM.NJHCqPw8A30ZxA.RKIx5M9DaGvFh.Y.', 'user', 'inactive', '2025-08-25 11:13:24'),
(14, 'Futebol', 'teste@email.com', '2025-08-11', '$2y$10$8uWHpZY3Yq.8BAMXihysDeaikcVg2HXBNYSggcyxFvK70UHMUejWG', 'user', 'inactive', '2025-08-21 14:23:19'),
(15, 'TesteFoda', 'teste@email.com', '2025-08-21', '$2y$10$sB20G.kpg0H7aXnicJ74kOjIjxhNU6zr3cutFhsNpsxTmU7k4L9ZO', 'user', 'inactive', '2025-08-21 14:23:07'),
(16, 'Paulo', 'paulo@email.com', '2025-07-30', '$2y$10$gKqhARSz2unrd.EfIb13hO7z.bzR9GodWmFFkH5PrhhRdSjemNLRq', 'user', 'inactive', '2025-08-21 14:14:09'),
(17, 'testemvc', 'testemvc@email.com', '3200-12-20', '$2y$10$6pj6.tSdiacWdA6BL/5zte1zmyn4xWRG0ouIytdBdaYVpoSpirGeG', 'user', 'active', '2025-08-21 14:33:09'),
(18, 'João Pedro Chagas Slengman', 'jp.chagasslengman@gmail.com', '2005-12-20', '$2y$10$MSL/mY2d15RLvFUIBz3ZLuXLj3mCuzMT597gjXUPKnEsIQ4aE8L5i', 'user', 'active', '2025-08-25 11:19:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `price_per_hour` decimal(10,2) DEFAULT NULL,
  `court_capacity` int(11) DEFAULT NULL,
  `play_area_capacity` int(11) DEFAULT NULL,
  `floor_type` varchar(100) DEFAULT NULL,
  `is_covered` tinyint(1) DEFAULT 0,
  `status` enum('available','unavailable','in_maintenance') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venues`
--

INSERT INTO `venues` (`id`, `user_id`, `name`, `description`, `address`, `price_per_hour`, `court_capacity`, `play_area_capacity`, `floor_type`, `is_covered`, `status`, `created_at`) VALUES
(1, 12, 'Quadra Leões de Ferraz', 'Escola de futebol', 'Rua teste', 80.00, 10, 50, 'Grama', 1, 'available', '2025-08-25 13:44:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venues_amenities`
--

CREATE TABLE `venues_amenities` (
  `venue_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `venues_sports`
--

CREATE TABLE `venues_sports` (
  `venue_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `venues_amenities`
--
ALTER TABLE `venues_amenities`
  ADD PRIMARY KEY (`venue_id`,`amenity_id`),
  ADD KEY `amenity_id` (`amenity_id`);

--
-- Índices de tabela `venues_sports`
--
ALTER TABLE `venues_sports`
  ADD PRIMARY KEY (`venue_id`,`sport_id`),
  ADD KEY `sport_id` (`sport_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `venues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `venues_amenities`
--
ALTER TABLE `venues_amenities`
  ADD CONSTRAINT `venues_amenities_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venues_amenities_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `venues_sports`
--
ALTER TABLE `venues_sports`
  ADD CONSTRAINT `venues_sports_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venues_sports_ibfk_2` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
