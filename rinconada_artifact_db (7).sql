-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 06:02 AM
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
-- Database: `rinconada_artifact_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `artifacts`
--

CREATE TABLE `artifacts` (
  `artifact_id` int(11) NOT NULL,
  `model_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `origin` varchar(150) DEFAULT NULL,
  `municipality` varchar(150) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artifacts`
--

INSERT INTO `artifacts` (`artifact_id`, `model_id`, `title`, `description`, `origin`, `municipality`, `category_id`, `artist_id`, `user_id`, `created_at`) VALUES
(10, 9, 'sdffsd', 'dsfsdf', 'dsfsdfd', 'sdfsdfdsf', 1, 2, 2, '2025-05-18 13:58:51'),
(11, 10, 'asdas', 'dsdasd', 'sadadssa', 'sadasd', 3, 2, 2, '2025-05-18 14:13:46'),
(12, 11, 'sadas', 'dsad', 'dsad', 'dsadas', 1, 3, 1, '2025-05-19 00:44:58'),
(13, 12, 'sadfsad', 'asd', 'asaadssad', 'dasasdsda', 1, 1, 1, '2025-05-19 00:45:26'),
(15, 14, 'sada', 'dsad', 'dsda', 'SADASD', 2, 2, 1, '2025-05-19 00:51:51'),
(16, 15, 'sadasd', 'sadsadsa', 'dsad', 'ssdasasa', 2, 1, 2, '2025-05-19 00:52:30'),
(17, 16, 'sdafdfs', 'fdsdfs', 'fdsfsd', 'fdsdfs', 2, 2, 1, '2025-05-19 01:05:31'),
(18, 17, 'test 3d model viewer', 'test model', 'secret', 'secret', 3, 2, 2, '2025-05-19 02:08:22'),
(19, 18, 'dssasa', 'asdasd', 'asddsa', 'dasdsa', 1, 1, 2, '2025-05-19 02:11:29'),
(20, 19, 'etdtsgsga', 'sdaasdas', 'dsasadads', 'dsasad', 3, 3, 2, '2025-05-19 02:14:16'),
(21, 20, 'old chair', 'sadsasddsa', 'saddasdsa', 'asdsdadas', 1, 2, 1, '2025-05-19 02:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `biography` text DEFAULT NULL,
  `municipality` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `name`, `biography`, `municipality`, `created_at`) VALUES
(1, 'Juan Luna', 'Famous Filipino painter and revolutionary.', 'Manila', '2025-05-15 16:25:52'),
(2, 'Fernando Amorsolo', 'First National Artist of the Philippines.', 'Manila', '2025-05-15 16:25:52'),
(3, 'dsfsd', 'dsfdfs', 'dsffds', '2025-05-17 15:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `material` varchar(200) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `material`, `description`) VALUES
(1, 'Painting', '', 'Artworks created using paint.'),
(2, 'Sculpture', '', 'Three-dimensional artworks.'),
(3, 'Bold', '', 'gsjadgjhsagdsa'),
(4, 'test', '', 'sahjgagjhfashhsa');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `action`, `timestamp`) VALUES
(1, 1, 'created artifact', '2025-05-15 16:25:52'),
(2, 2, 'uploaded model', '2025-05-15 16:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-03-20-000001', 'App\\Database\\Migrations\\CreateInitialTables', 'default', 'App', 1747278988, 1),
(5, '2024-06-08-000003', 'App\\Database\\Migrations\\AddFilePathToArtifacts', 'default', 'App', 1747490700, 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_files`
--

CREATE TABLE `model_files` (
  `model_id` int(11) NOT NULL,
  `file_name` varchar(150) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size_kb` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `artifact_id` int(11) DEFAULT NULL,
  `model_thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model_files`
--

INSERT INTO `model_files` (`model_id`, `file_name`, `file_path`, `file_size_kb`, `uploaded_at`, `artifact_id`, `model_thumbnail`) VALUES
(7, 'rinconada_artifact_db.sql', 'uploads/models/1747492452_67f3f26362d027765459.csv', 9, '2025-05-17 14:34:12', NULL, NULL),
(9, 'samplemodel.obj', 'uploads/models/1747576731_4947af6e3dadd098e5f8.obj', 0, '2025-05-18 13:58:51', NULL, NULL),
(10, 'samplemodel2.obj', 'uploads/models/1747577626_04c462994647d440e6ba.obj', 0, '2025-05-18 14:13:46', NULL, NULL),
(11, 'models.obj', 'uploads/models/1747615498_7367932c53caddfc9e8d.obj', 0, '2025-05-19 00:44:58', 12, NULL),
(12, 'models.obj', 'uploads/models/1747615526_b5a4e2c632488617be1f.obj', 0, '2025-05-19 00:45:26', 13, NULL),
(14, 'models.obj', 'uploads/models/1747615911_0e34821b00723bb542e6.obj', 0, '2025-05-19 00:51:51', 15, NULL),
(15, 'models.obj', 'uploads/models/1747615950_cee35ad0e04abf87623b.obj', 0, '2025-05-19 00:52:30', 16, NULL),
(16, 'test.obj', 'uploads/models/1747616731_1c8a7880ac548aabf1f7.obj', 0, '2025-05-19 01:05:31', 17, NULL),
(17, 'Vase (1).glb', 'uploads/models/1747620502_59b26b526c02b4d2fa57.bin', 31, '2025-05-19 02:08:22', 18, NULL),
(18, 'Vase (1).glb', 'uploads/models/1747620689_45a92b0ddec6abd807be.bin', 31, '2025-05-19 02:11:29', 19, NULL),
(19, 'Vase (1).glb', 'uploads/models/bba3277c59b25046.glb', 31, '2025-05-19 02:14:16', 20, NULL),
(20, 'old_wooden_chair.glb', 'uploads/models/25412432c8f618ac.glb', 3058, '2025-05-19 02:16:08', 21, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Admin User', 'admin', '2025-05-15 16:25:52'),
(2, 'user1', 'user123', 'Regular User', 'user', '2025-05-15 16:25:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artifacts`
--
ALTER TABLE `artifacts`
  ADD PRIMARY KEY (`artifact_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_artifacts_model_id` (`model_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_files`
--
ALTER TABLE `model_files`
  ADD PRIMARY KEY (`model_id`),
  ADD UNIQUE KEY `model_id` (`model_id`),
  ADD KEY `fk_model_files_artifact` (`artifact_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artifacts`
--
ALTER TABLE `artifacts`
  MODIFY `artifact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `model_files`
--
ALTER TABLE `model_files`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artifacts`
--
ALTER TABLE `artifacts`
  ADD CONSTRAINT `artifacts_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`),
  ADD CONSTRAINT `artifacts_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_artifacts_model_id` FOREIGN KEY (`model_id`) REFERENCES `model_files` (`model_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `model_files`
--
ALTER TABLE `model_files`
  ADD CONSTRAINT `fk_model_files_artifact` FOREIGN KEY (`artifact_id`) REFERENCES `artifacts` (`artifact_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
