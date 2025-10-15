-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 08:06 AM
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
-- Database: `event-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_emp`
--

CREATE TABLE `assigned_emp` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `task_id`, `attachment`, `path`, `created_at`, `updated_at`) VALUES
(1, 4, 'thi-0-67921b98dda66.pdf', '0', '2025-01-23 05:06:08', '2025-01-23 05:06:08'),
(2, 4, 'thicsadf-0-67921ba4b1b46.pdf', '0', '2025-01-23 05:06:20', '2025-01-23 05:06:20'),
(3, 4, 'thi-0-67bd79ad858d9.pdf', '0', '2025-02-25 02:35:01', '2025-02-25 02:35:01'),
(4, 10, 'Hi Space-0-67c077c4af739.pdf', 'task_attachments/Hi Space-0-67c077c4af739.pdf', '2025-02-27 09:03:40', '2025-02-27 09:03:40'),
(5, 11, 'Hi NS De Silva-0-67c692e13e7af.pdf', 'task_attachments/Hi NS De Silva-0-67c692e13e7af.pdf', '2025-03-04 00:12:57', '2025-03-04 00:12:57'),
(7, 13, 'Hi Irushi-0-67cfc3e6add36.pdf', 'task_attachments/Hi Irushi-0-67cfc3e6add36.pdf', '2025-03-10 23:32:30', '2025-03-10 23:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_id`, `emp_name`, `created_at`, `updated_at`) VALUES
(3, '139', 'INDIKA MEDAGANGODA', '2025-01-20 04:16:56', '2025-01-20 04:16:56'),
(4, '0006', 'Employee 6', '2025-01-28 02:43:26', '2025-01-28 02:43:26'),
(6, '3', 'D.M.', '2025-02-27 09:05:05', '2025-02-27 09:05:05'),
(7, '4', 'N.S.', '2025-03-04 00:19:58', '2025-03-04 00:19:58'),
(8, '123', 'irushi', '2025-03-10 23:08:30', '2025-03-10 23:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `event_instance_tasks`
--

CREATE TABLE `event_instance_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('todo','completed') NOT NULL,
  `tasks_id` bigint(20) UNSIGNED NOT NULL,
  `new_event_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_instance_tasks`
--

INSERT INTO `event_instance_tasks` (`id`, `status`, `tasks_id`, `new_event_id`, `created_at`, `updated_at`) VALUES
(1, 'todo', 1, 1, NULL, NULL),
(2, 'todo', 2, 1, NULL, NULL),
(3, 'todo', 5, 10, '2025-01-15 00:06:55', '2025-01-15 00:06:55'),
(4, 'todo', 6, 10, '2025-01-15 00:06:56', '2025-01-15 00:06:56'),
(5, 'todo', 10, 16, '2025-02-27 09:06:08', '2025-02-27 09:06:08'),
(6, 'todo', 11, 17, '2025-03-04 00:22:21', '2025-03-04 00:22:21'),
(7, 'todo', 12, 18, '2025-03-10 23:10:08', '2025-03-10 23:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`id`, `event_type`, `img_path`, `created_at`, `updated_at`) VALUES
(1, 'Event 1', 'ini_events_images/default.jpg', '2025-01-09 23:57:35', '2025-01-09 23:57:35'),
(2, 'Event 2', 'ini_events_images/default.jpg', '2025-01-09 23:57:35', '2025-01-09 23:57:35'),
(3, 'Event 3', 'ini_events_images/default.jpg', '2025-01-09 23:57:35', '2025-01-09 23:57:35'),
(4, 'Event 4', 'ini_events_images/default.jpg', '2025-01-09 23:57:35', '2025-01-09 23:57:35'),
(5, 'Event 5', 'ini_events_images/default.jpg', '2025-01-09 23:57:35', '2025-01-09 23:57:35'),
(6, 'Workshop on Space Science & Technology for Teachers and Students', 'ini_events_images/default.jpg', '2025-01-20 04:13:41', '2025-01-20 04:13:41'),
(7, 'poster contest', 'ini_events_images/default.jpg', '2025-01-31 04:39:03', '2025-01-31 04:39:03'),
(8, 'DM De Silva', 'ini_events_images/uploads/Txj9HpzJrQod6U6H2eDHNTbX21HhVEIyBSU6rG7z.jpg', '2025-02-27 09:02:07', '2025-02-27 09:02:07'),
(9, 'NS De Silva', 'ini_events_images/uploads/sgiLYJOD4d5jn5Dco5bZjckyUsb8stRtfkut4mg9.jpg', '2025-03-04 00:12:39', '2025-03-04 00:12:39'),
(10, 'water rocket', 'ini_events_images/uploads/i6MheP3YgqqERoLs8yLeeYD0ms4OvRkatAhjPGL8.jpg', '2025-03-10 23:05:11', '2025-05-08 02:07:05'),
(11, 'water rocket 2', 'ini_events_images/uploads/g3204qtkrJguo5FYVPFlk8jTHRca5NoLygQmSeRb.jpg', '2025-03-10 23:30:52', '2025-03-10 23:30:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(37, '2014_10_12_000000_create_users_table', 1),
(38, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(39, '2019_08_19_000000_create_failed_jobs_table', 1),
(40, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(41, '2023_07_11_204752_create_event_types_table', 1),
(42, '2023_08_05_120215_create_tasks_table', 1),
(43, '2023_08_18_051912_create_employees_table', 1),
(44, '2024_02_14_062639_create_students_table', 1),
(45, '2024_03_17_181524_create_new_event_table', 1),
(46, '2024_03_17_181629_create_attachments_table', 1),
(47, '2024_12_17_053127_create_event_instance_tasks', 1),
(48, '2025_01_09_092526_create_assigned_emp_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `new_event`
--

CREATE TABLE `new_event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type_id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `coordinator` varchar(255) NOT NULL,
  `active_status` enum('running','completed') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_event`
--

INSERT INTO `new_event` (`id`, `event_type_id`, `event_name`, `start_date`, `end_date`, `coordinator`, `active_status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Event 3 2025', '2025-01-05', '2025-01-10', '01', 'running', '2025-01-09 23:58:14', '2025-01-09 23:58:14'),
(10, 1, 'Event 1', '2025-01-15', '2025-01-17', '2', 'running', '2025-01-15 00:06:54', '2025-01-15 00:06:54'),
(11, 1, 'Event 1 test', '2025-01-15', '2025-01-15', '0', 'running', '2025-01-15 02:15:26', '2025-01-15 02:15:26'),
(12, 4, 'Event 4 new', '2025-01-15', '2025-01-17', '1', 'running', '2025-01-15 03:43:38', '2025-01-15 03:43:38'),
(13, 5, 'Event 5 new', '2025-01-18', '2025-01-21', '1', 'running', '2025-01-15 03:45:28', '2025-01-15 03:45:28'),
(14, 5, 'Event 5 new 2', '2025-01-16', '2025-01-22', '1', 'running', '2025-01-15 03:48:30', '2025-01-15 03:48:30'),
(15, 5, 'Event 5 new 04', '2025-01-16', '2025-01-17', '2', 'running', '2025-01-15 03:56:59', '2025-01-15 03:56:59'),
(16, 8, 'DM De Silva', '2025-02-28', '2025-03-03', '3', 'running', '2025-02-27 09:06:08', '2025-02-27 09:06:08'),
(17, 9, 'NS De Silva', '2025-03-31', '2025-04-30', '4', 'running', '2025-03-04 00:22:21', '2025-03-04 00:22:21'),
(18, 10, 'water rocket', '2025-03-19', '2025-03-27', '123', 'running', '2025-03-10 23:10:08', '2025-03-10 23:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `annual_event_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `event_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `event_type_id`, `created_at`, `updated_at`) VALUES
(1, 'task 1', 2, '2025-01-09 23:58:37', '2025-01-09 23:58:37'),
(2, 'task 2', 2, '2025-01-09 23:58:37', '2025-01-09 23:58:37'),
(3, 'task 3', 2, '2025-01-09 23:58:37', '2025-01-09 23:58:37'),
(4, 'task 1t', 1, '2025-01-14 22:03:27', '2025-01-23 05:06:50'),
(5, 'task 2', 1, '2025-01-14 22:03:28', '2025-01-14 22:03:28'),
(6, 'task 3j', 1, '2025-01-14 22:03:28', '2025-01-23 05:06:41'),
(7, 'afaefqwf', 1, '2025-01-28 02:43:06', '2025-01-28 02:43:06'),
(8, 'task 1', 7, '2025-01-31 04:39:24', '2025-01-31 04:39:24'),
(9, 'task 2', 7, '2025-01-31 04:39:36', '2025-01-31 04:39:36'),
(10, 'DM', 8, '2025-02-27 09:03:40', '2025-02-27 09:03:40'),
(11, 'NS', 9, '2025-03-04 00:12:56', '2025-03-04 00:12:56'),
(12, 'dhsuet', 10, '2025-03-10 23:05:55', '2025-03-10 23:05:55'),
(13, 'himmmm', 11, '2025-03-10 23:32:30', '2025-03-10 23:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin2@gmail.com', '2025-01-09 23:31:59', '$2y$10$p.EJoqG5HUvLojZSCtMs8ORFKok4aZ8KhG.HEkJ73nUPmGnctc48G', 'InsQQKqiPSKBbezKnSJsswIMWRWc2V9Fndk39tgE1lE5h2A2246DR0ofByBy', '2025-01-09 23:32:00', '2025-01-28 02:44:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_emp`
--
ALTER TABLE `assigned_emp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_emp_task_id_foreign` (`task_id`),
  ADD KEY `assigned_emp_emp_id_foreign` (`emp_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_task_id_foreign` (`task_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_emp_id_unique` (`emp_id`);

--
-- Indexes for table `event_instance_tasks`
--
ALTER TABLE `event_instance_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_instance_tasks_tasks_id_foreign` (`tasks_id`),
  ADD KEY `event_instance_tasks_new_event_id_foreign` (`new_event_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_types_event_type_unique` (`event_type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_event`
--
ALTER TABLE `new_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `new_event_event_type_id_foreign` (`event_type_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_event_type_id_foreign` (`event_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_emp`
--
ALTER TABLE `assigned_emp`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_instance_tasks`
--
ALTER TABLE `event_instance_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `new_event`
--
ALTER TABLE `new_event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_emp`
--
ALTER TABLE `assigned_emp`
  ADD CONSTRAINT `assigned_emp_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assigned_emp_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `event_instance_tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

--
-- Constraints for table `event_instance_tasks`
--
ALTER TABLE `event_instance_tasks`
  ADD CONSTRAINT `event_instance_tasks_new_event_id_foreign` FOREIGN KEY (`new_event_id`) REFERENCES `new_event` (`id`),
  ADD CONSTRAINT `event_instance_tasks_tasks_id_foreign` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`);

--
-- Constraints for table `new_event`
--
ALTER TABLE `new_event`
  ADD CONSTRAINT `new_event_event_type_id_foreign` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_event_type_id_foreign` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
