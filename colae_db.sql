-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 03:49 AM
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
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `neighborhood` varchar(50) DEFAULT NULL,
  `complement` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `cep`, `street`, `number`, `neighborhood`, `complement`, `city`, `state`, `latitude`, `longitude`) VALUES
(1, '08675460', 'Rua Regina Cabalau Mendonça', '1020', 'Jardim São Luís', 'Perto do corpo de bombeiro', 'Suzano', 'SP', NULL, NULL),
(2, '08674-010', 'Rua Benjamin Constant', '1713', 'Centro', 'Próximo ao Comercial Esperança', 'Suzano', 'SP', NULL, NULL),
(3, '08675460', 'Rua Regina Cabalau Mendonça', '71', 'Jardim São Luís', 'Perto do corpo de bombeiro', 'Suzano', 'SP', -23.55294590, -46.31342990),
(4, '08460520', 'Rua Raposo da Fonseca', '350', 'Cidade Popular', 'bosta', 'São Paulo', 'SP', -23.55777730, -46.40152630),
(5, '08675460', 'Rua Regina Cabalau Mendonça', '71', 'Jardim São Luís', 'Perto do corpo de bombeiro', 'Suzano', 'SP', -23.55294590, -46.31342990),
(6, '08675460', 'Rua Regina Cabalau Mendonça', '123123', 'Jardim São Luís', 'Century II casa51', 'Suzano', 'SP', -23.55266210, -46.31375970),
(7, '01001-000', 'Praça da Sé', '01', 'Sé', 'Praça da sé', 'São Paulo', 'SP', -23.54892770, -46.63357600),
(8, '08673170', 'Alameda Meyer Joseph Nigri', '61', 'Cidade Cruzeiro do Sul', '', 'Suzano', 'SP', -23.53228810, -46.31625310),
(9, '08551320', 'Rua Visconde de Ouro Preto', '51', 'Vila Julia', 'casa com porta de aluminio', 'Poá', 'SP', NULL, NULL),
(10, '08551320', 'Rua Visconde de Ouro Preto', '51', 'Vila Júlia', 'casa portao de chapa', 'Poá', 'SP', NULL, NULL),
(11, '08674-010', 'Rua Benjamin Constant', '1713', 'Centro', NULL, 'Suzano', 'SP', -23.54891580, -46.31498650);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
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
(10, 'jpcslengman@gmail.com', '993aaac28b547909ea233c6281eca761cef4bec45e70ee16e09981990c19ee48', '2025-08-25 14:07:53', '2025-08-25 11:07:53'),
(14, 'jpcslengman@gmail.com', '28f53da2026cd32f20705c2171a4bef6f958183742c8a4ab2e4fce9d74d76039', '2025-08-31 18:52:28', '2025-08-31 15:52:28'),
(15, 'jpcslengman@gmail.com', 'c3007abfed887cf455c7fd086cd972c685ba7d505bda72dd35e3860a23e40788', '2025-08-31 18:52:29', '2025-08-31 15:52:29'),
(16, 'jpcslengman@gmail.com', '9fd5831e5847c8570777a0f195cab457f2517c13d952bd3291ffd7fa41636df5', '2025-09-13 12:42:13', '2025-09-13 14:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') NOT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `name`, `created_at`, `status`, `icon`) VALUES
(26, 'Futebol', '2025-09-13 17:19:20', 'inactive', 'fa-futbol'),
(27, 'Futebol', '2025-09-13 17:19:31', 'active', 'fa-futbol'),
(28, 'Vôlei', '2025-09-13 18:25:58', 'active', 'fa-volleyball-ball');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cpf` varchar(255) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `birthdate`, `password_hash`, `role`, `status`, `created_at`, `cpf`, `avatar_path`) VALUES
(1, 'Joao Pedro Bundão', 'jpcslengman@gmail.com', '2005-12-20', '$2y$10$CvXzwxV3vzNIvHomxHfXouqgpokveLhtlIJeuTmA0SFZcO5s6gLuy', 'admin', 'inactive', '2025-09-13 16:37:38', NULL, NULL),
(6, 'Rafael ', 'rafael@emai.com', '2025-08-12', '$2y$10$atigyrcglIieI9f.sqf/0eRIqh3Hfromp7/d/UynYA9hGpUZmCd2.', 'admin', 'inactive', '2025-08-21 14:15:18', NULL, NULL),
(9, 'TesteFoda', 'testefoda@email.com', '2025-07-29', '$2y$10$hBdDOAt4YRYCjFg9ml.5.uEadf2wG2U59pgdHL.3jOSdamp07zHW6', 'user', 'inactive', '2025-08-21 14:14:28', NULL, NULL),
(10, 'Rafael 123', 'jpcslengman@gmail.com', '2025-08-01', '$2y$10$CvXzwxV3vzNIvHomxHfXouqgpokveLhtlIJeuTmA0SFZcO5s6gLuy', 'user', 'inactive', '2025-08-26 15:05:08', NULL, NULL),
(11, 'Lil Raff 123', 'lilraff@email.com', '2025-07-29', '$2y$10$vHMiRNKNEobS3/z.RHs1weSEHJne/45iQnEjNmyQfpBqCdCZSObxe', 'user', 'inactive', '2025-09-13 15:16:39', NULL, NULL),
(12, 'João Pedro Chagas Slengman', 'jpcslengman@gmail.com', '2025-08-18', '$2y$10$CvXzwxV3vzNIvHomxHfXouqgpokveLhtlIJeuTmA0SFZcO5s6gLuy', 'user', 'inactive', '2025-08-26 15:05:08', NULL, NULL),
(13, 'João Pedro Chagas Slengman', 'jpcslengman@gmail.com', '2025-08-12', '$2y$10$CvXzwxV3vzNIvHomxHfXouqgpokveLhtlIJeuTmA0SFZcO5s6gLuy', 'user', 'inactive', '2025-08-26 15:05:08', NULL, NULL),
(14, 'Futebol', 'teste@email.com', '2025-08-11', '$2y$10$8uWHpZY3Yq.8BAMXihysDeaikcVg2HXBNYSggcyxFvK70UHMUejWG', 'user', 'inactive', '2025-08-21 14:23:19', NULL, NULL),
(15, 'TesteFoda', 'teste@email.com', '2025-08-21', '$2y$10$sB20G.kpg0H7aXnicJ74kOjIjxhNU6zr3cutFhsNpsxTmU7k4L9ZO', 'user', 'inactive', '2025-08-21 14:23:07', NULL, NULL),
(16, 'Paulo', 'paulo@email.com', '2025-07-30', '$2y$10$gKqhARSz2unrd.EfIb13hO7z.bzR9GodWmFFkH5PrhhRdSjemNLRq', 'user', 'inactive', '2025-08-21 14:14:09', NULL, NULL),
(17, 'testemvc', 'testemvc@email.com', '3200-12-20', '$2y$10$6pj6.tSdiacWdA6BL/5zte1zmyn4xWRG0ouIytdBdaYVpoSpirGeG', 'user', 'inactive', '2025-09-13 15:16:42', NULL, NULL),
(18, 'João Pedro Chagas Slengman', 'jp.chagasslengman@gmail.com', '2005-12-20', '$2y$10$MSL/mY2d15RLvFUIBz3ZLuXLj3mCuzMT597gjXUPKnEsIQ4aE8L5i', 'user', 'active', '2025-08-25 11:19:59', NULL, NULL),
(19, 'João Pedro Tester', 'tester@email.com', '2005-12-20', '$2y$10$midWdskc/MdUnaxkff9zmu8QYuwVlbxciTxECsJSjKjHJzQODKqyi', 'admin', 'active', '2025-09-13 18:10:49', 'V5e0Xg4IF1UXEzCCBDsFZA==', NULL),
(20, 'João Pedro Chagas Slengman', 'julia@gmail.com', '2010-12-20', '$2y$10$AOdiqM6SQWopAE3fTxiiZe5Kvc6zG3eZJCftNo94UUsXXGpjyf7Ey', 'user', 'inactive', '2025-08-31 16:06:25', NULL, NULL),
(21, 'testeidade', 'testeidade@email', '2020-12-20', '$2y$10$yLoMRlYnip3E62xJ4RTjCepF1w4nFQi/6rkQUBdYX71RqpGfjjvWG', 'user', 'inactive', '2025-08-31 15:54:56', NULL, NULL),
(22, 'teste123', 'teste1234@gmail.com', '2020-12-20', '$2y$10$bVz/fImatLTJC8FbgumnfOaxquKeTBgS8O8KclCUyiByQB/G8tOKC', 'user', 'inactive', '2025-08-31 15:54:15', NULL, NULL),
(23, 'teste1234', 'teste12345@email.com', '2010-01-01', '$2y$10$JJ50URZpg40zil4FPbYokenZzAc3wVX0asIOF7mhzwnahXYoSWgui', 'user', 'inactive', '2025-08-26 22:09:39', NULL, NULL),
(24, 'AAAAAA', 'aaa@email.com', '2005-12-20', '$2y$10$ioIIc0G4VSlLK.LFbV3MM.JGlCJHUZxumyZwxPNttlLzAR6/AF1Ge', 'user', 'inactive', '2025-09-13 15:22:26', NULL, NULL),
(25, 'Joao Teste 123', 'joaoteste123@email.com', '2005-12-20', '$2y$10$qtV5M6SGtYW6VuXkd7qf/.i6WJSvedFQ4VIWW8c15OFq8OpvF1SwW', 'user', 'active', '2025-08-31 17:24:05', '7Ecd8KsfWGoDp2J5t/0OSw==', NULL),
(26, 'Teste tela nova', 'telanova@email.com', '2005-12-20', '$2y$10$2bjchsi56YOHHUGdnMNNoOrTnefSKS847FF0bRmMCXqk2pOAhzUGK', 'user', 'active', '2025-09-13 16:10:47', NULL, NULL),
(27, 'Teste tela nova', 'telanova@email.com1', '2005-12-20', '$2y$10$Rs.Qj2bJCjj6mMMEg0DnXOoHXwIZ.ckJ4sbmqZiQWpwEsE2HKsjM6', 'user', 'active', '2025-09-16 00:59:29', 'qzIIvVFC3YQNzr5Or7XeoQ==', NULL),
(28, 'teste tela nova ', 'telanova@email.com', '2005-12-20', '$2y$10$zmVAu9PX8Ya6owRNrpzL2OpSbfXZ7mABRlgmVi7.lxpB4zQdwb4pq', 'user', 'active', '2025-09-13 16:12:17', NULL, NULL),
(29, 'teste tela nova ', 'telanova@email.com', '2005-12-20', '$2y$10$jcE8cfiKAz0dUWziGi6W4uy0vYtzxwQSll4X22t0K2OHL.1lajQbK', 'user', 'inactive', '2025-09-13 16:21:32', NULL, NULL),
(30, 'Teste tela Nova', 'testetela@email.com', '2055-12-20', '$2y$10$d/w7kWyL1nySL87LUndLqOokiXQQzqMvx6Idj9nHnDwgo6kq3HqlW', 'user', 'inactive', '2025-09-13 16:21:30', NULL, NULL),
(31, 'Teste tela Nova', 'testetela@email.com', '2055-12-20', '$2y$10$MIRWnUr/mz.qYc84MopmK.TSbE9x7Ae8rF7l9hgNAOXItPvUyT30u', 'user', 'inactive', '2025-09-13 16:37:35', NULL, NULL),
(32, 'Ola', 'ola@email.com', '2005-03-12', '$2y$10$O9I6Qxm9FBAGowyD5zzjQ..jhXxY3JAfe3a2SWXXEUdmaLyUhUbn2', 'user', 'inactive', '2025-09-13 16:33:34', NULL, NULL),
(33, 'Ola', 'ola@email.com', '2005-03-12', '$2y$10$HKu6qgjQw4HYaC1nRB9rPewcv5PUI.GoUHrEZ2hk9fe3ekqise7Hq', 'user', 'inactive', '2025-09-13 16:33:32', NULL, NULL),
(34, 'Ola', 'ola@email.com', '2005-03-12', '$2y$10$ebHWIXnnMiX1196nGtLL4OB8jpTp/gjhoQPcUKFrTR/EwSFKdG2RW', 'user', 'inactive', '2025-09-13 16:33:31', NULL, NULL),
(35, 'Ola', 'ola@email.com', '2005-03-12', '$2y$10$8Xw0q10P2dM9F8pzJvyKmuAh5xHiwFR5r46mSGZn6CxGQ2XqRj2py', 'user', 'inactive', '2025-09-13 16:33:29', NULL, NULL),
(36, 'Ola', 'ola@email.com', '2005-03-12', '$2y$10$B5GG8Gr1OCI.9Ck3McpPkOYDb90RTGgnLu0TfsF0OXopLGzEFByJK', 'user', 'inactive', '2025-09-13 16:33:27', NULL, NULL),
(37, 'Ola', 'ola@email.com', '2005-03-12', '$2y$10$3MqEWqbJgG50lhBYhVcIv.PqEd9tvtyrJen0.Dx7xBuzrc5uSj6RG', 'user', 'inactive', '2025-09-13 16:33:26', NULL, NULL),
(38, 'Jose Bernadino Silva', 'jose_ativa@yahoo.com', '1944-09-19', '$2y$10$fsfiloK7MspRlJMWRurFyOUHiSBEwO9utxj7cbzxfRxbmr3PjyajS', 'user', 'inactive', '2025-09-13 16:33:24', NULL, NULL),
(39, 'Jose Bernadino Silva', 'jose_ativa@yahoo.com', '1944-09-19', '$2y$10$PV5ABF0nkW3eWpq22d8Xnub0.d2VQX/9eaqTmFKmYeDmW24A4Oiom', 'user', 'inactive', '2025-09-13 16:33:23', NULL, NULL),
(40, 'Jose Bernadino Silva', 'jose_ativa@yahoo.com', '1944-09-19', '$2y$10$qpTTG45B8LVrSVevm0kM8e9Bz2n/tvszf6AH.HGplQLEtSYbHxm.2', 'user', 'inactive', '2025-09-13 16:33:21', NULL, NULL),
(41, 'testepop', 'testepop@email.com', '2005-12-20', '$2y$10$.aMrDLD3b46.f149ScPUx.ynoLuV5JE71yCtJxIwWFKidrGR7GbDq', 'user', 'active', '2025-09-13 17:47:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `average_price_per_hour` decimal(10,2) DEFAULT NULL,
  `court_capacity` int(11) DEFAULT NULL,
  `has_leisure_area` tinyint(1) NOT NULL,
  `leisure_area_capacity` int(11) DEFAULT NULL,
  `floor_type` enum('grama natural','grama sintética','cimento','bosta') DEFAULT NULL,
  `has_lighting` tinyint(1) NOT NULL,
  `is_covered` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('available','unavailable','in_maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `user_id`, `address_id`, `name`, `average_price_per_hour`, `court_capacity`, `has_leisure_area`, `leisure_area_capacity`, `floor_type`, `has_lighting`, `is_covered`, `status`, `created_at`, `updated_at`) VALUES
(1, 17, 1, 'Leões', 120.00, 15, 1, 50, 'grama natural', 1, 1, 'unavailable', '2025-08-26 13:47:02', '2025-08-30 00:35:33'),
(2, 17, 2, 'Quadra do Xuxa', 90.00, 10, 1, 50, 'grama sintética', 1, 1, 'unavailable', '2025-08-26 14:50:04', '2025-08-31 14:35:43'),
(3, 17, 3, 'teste', 123.00, 123, 1, 12, 'grama natural', 1, 1, 'unavailable', '2025-08-26 15:07:28', '2025-09-13 03:37:18'),
(4, 17, 4, 'Quadra foda do rafael', 101.00, 15, 1, 14, 'grama natural', 0, 1, 'available', '2025-08-26 15:13:11', '2025-08-26 15:13:11'),
(5, 17, 5, 'Teste', 123.00, 12, 1, 123, 'grama natural', 1, 1, 'available', '2025-08-26 15:34:49', '2025-08-26 15:34:49'),
(6, 19, 6, 'João Pedro Chagas Slengman', 123.00, 123, 1, 123, 'grama natural', 1, 1, 'available', '2025-08-26 17:14:00', '2025-08-26 17:14:00'),
(7, 19, 7, 'Teste sé', 120.00, 50, 1, 50, 'grama natural', 1, 1, 'available', '2025-08-26 21:00:54', '2025-08-26 21:00:54'),
(8, 19, 8, 'Jose Bernadino Silva', 0.00, 0, 0, 0, 'grama natural', 0, 0, 'available', '2025-08-27 19:28:46', '2025-08-27 19:28:46'),
(9, 25, 9, 'Casa da vó', 120.00, 15, 1, 30, 'grama sintética', 1, 0, 'unavailable', '2025-08-31 15:51:23', '2025-08-31 17:24:38'),
(10, 25, 10, 'casa da vo', 120.00, 10, 1, 15, 'grama natural', 1, 1, 'available', '2025-08-31 17:25:30', '2025-08-31 17:25:30'),
(11, 19, 11, 'Quadra do Xuxa - Suzano', 120.00, 15, 1, 45, 'grama sintética', 1, 0, 'available', '2025-09-13 03:45:22', '2025-09-13 03:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `venue_images`
--

CREATE TABLE `venue_images` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_images`
--

INSERT INTO `venue_images` (`id`, `venue_id`, `file_path`, `created_at`) VALUES
(1, 11, 'venue_68c4e8d2ac2aa0.67455018.jpg', '2025-09-13 03:45:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `venue_images`
--
ALTER TABLE `venue_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `venue_images`
--
ALTER TABLE `venue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `venues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venues_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `venue_images`
--
ALTER TABLE `venue_images`
  ADD CONSTRAINT `venue_images_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
