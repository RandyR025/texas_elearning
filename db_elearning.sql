-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2023 at 02:05 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailhasil`
--

CREATE TABLE `detailhasil` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `totals` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detailhasil`
--

INSERT INTO `detailhasil` (`id`, `user_id`, `quiz_id`, `jadwal_id`, `totals`, `created_at`, `updated_at`) VALUES
(18, 10, 4, 3, 0, '2023-12-21 09:45:46', '2023-12-21 09:45:46');

-- --------------------------------------------------------

--
-- Table structure for table `detail_waktu`
--

CREATE TABLE `detail_waktu` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `waktu_end` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_waktu`
--

INSERT INTO `detail_waktu` (`id`, `user_id`, `quiz_id`, `jadwal_id`, `waktu_end`, `created_at`, `updated_at`) VALUES
(18, 10, 4, 3, '2023-12-21 09:45:46', '2023-12-21 09:44:46', '2023-12-21 09:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasilpilihan`
--

CREATE TABLE `hasilpilihan` (
  `id` int(11) NOT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `pertanyaan_id` int(11) DEFAULT NULL,
  `jawaban_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasilpilihan`
--

INSERT INTO `hasilpilihan` (`id`, `jadwal_id`, `pertanyaan_id`, `jawaban_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 3, 58, 45, 10, '2023-12-19 21:12:30', '2023-12-21 09:28:18'),
(3, 3, 59, 48, 10, '2023-12-19 21:12:59', '2023-12-21 09:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `jadwalquiz`
--

CREATE TABLE `jadwalquiz` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `waktu_quiz` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwalquiz`
--

INSERT INTO `jadwalquiz` (`id`, `quiz_id`, `tanggal_mulai`, `tanggal_berakhir`, `waktu_quiz`, `created_at`, `updated_at`) VALUES
(3, 4, '2023-12-19', '2023-12-25', 1, '2023-12-19 02:14:03', '2023-12-21 15:40:41'),
(4, 4, '2023-12-21', '2023-12-23', 30, '2023-12-19 02:49:03', '2023-12-21 12:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `jawabanpertanyaan`
--

CREATE TABLE `jawabanpertanyaan` (
  `id` int(11) NOT NULL,
  `jawaban` varchar(255) DEFAULT NULL,
  `pertanyaan_id` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawabanpertanyaan`
--

INSERT INTO `jawabanpertanyaan` (`id`, `jawaban`, `pertanyaan_id`, `point`, `created_at`, `updated_at`) VALUES
(44, 'what would eliminate unnecessary writing in government.', 58, 0, '2023-12-17 01:28:48', '2023-12-18 00:06:39'),
(45, 'who wants to cut down on the amount of writing in government.', 58, 0, '2023-12-17 01:28:48', '2023-12-18 00:06:39'),
(46, 'that would eliminate unnecessary paperwork in government.', 58, 1, '2023-12-17 01:28:48', '2023-12-18 00:06:39'),
(47, 'to cause that the amount of papers written in government offices will be reduced.', 58, 0, '2023-12-17 01:41:06', '2023-12-18 00:06:39'),
(48, 'kerucut', 59, 0, '2023-12-18 21:39:28', '2023-12-18 21:39:28'),
(49, 'Kubus', 59, 1, '2023-12-18 21:39:28', '2023-12-18 21:39:28'),
(50, 'Balok', 59, 0, '2023-12-18 21:39:28', '2023-12-18 21:39:28'),
(51, 'Prisma', 59, 0, '2023-12-18 21:39:28', '2023-12-18 21:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas`, `created_at`, `updated_at`) VALUES
(1, 'Syedney', NULL, NULL),
(2, 'Mongolia', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kursus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`id`, `kursus`, `created_at`, `updated_at`) VALUES
(1, 'English', NULL, NULL),
(2, 'Chinesse', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Tentor', NULL, NULL),
(3, 'Siswa', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2023_12_11_085939_create_level_table', 1),
(5, '2023_12_12_000000_create_users_table', 1),
(6, '2023_12_12_053356_create_kelas_table', 1),
(7, '2023_12_12_063840_create_kursus_table', 1),
(8, '2023_12_13_053301_create_tentor_table', 1),
(9, '2023_12_13_053335_create_siswa_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `tipe_pertanyaan` varchar(255) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pertanyaan`
--

INSERT INTO `pertanyaan` (`id`, `pertanyaan`, `tipe_pertanyaan`, `quiz_id`, `created_at`, `updated_at`) VALUES
(58, '<p><strong>PART A</strong></p><p>1. I understand that the governor is considering a new proposal_____________</p>', NULL, 4, '2023-12-18 08:23:18', '2023-12-18 00:06:39'),
(59, '<p><img src=\"data:image/jpeg;base64,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\" data-filename=\"31f1ff4d9d90907f1bbbf3b18afe5e6c.jpg\" style=\"width: 203.7px; height: 207.449px;\"></p><p>Bangun ruang apakah itu ?</p>', NULL, 4, '2023-12-18 21:39:28', '2023-12-18 21:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `judul_quiz` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `gambar_quiz` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `judul_quiz`, `kategori_id`, `gambar_quiz`, `created_at`, `updated_at`) VALUES
(4, 'SWE TOEFL 1', 5, '1702902904.jpg', '2023-12-18 01:22:26', '2023-12-18 17:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_kategori`
--

CREATE TABLE `quiz_kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_kategori`
--

INSERT INTO `quiz_kategori` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Listening', 'Listening adalah ujian mendengarkan bahasa inggris', NULL, '2023-12-17 23:56:45'),
(2, 'Reading', 'Listening adalah ujian membaca bahasa inggris', '2023-12-15 02:39:28', '2023-12-17 23:57:05'),
(5, 'Structure and Written Expression', 'Writing adalah ujian menulis bahasa inggris', '2023-12-17 23:57:44', '2023-12-18 00:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` char(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kursus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `tanggal_lahir`, `alamat`, `no_telp`, `kursus_id`, `kelas_id`, `user_id`, `created_at`, `updated_at`) VALUES
(49, 'Randy Rahmawan', '2023-12-18', 'Oke', '0896-2187-8375', 1, 1, 3, '2023-12-17 11:45:32', '2023-12-17 11:45:32'),
(50, 'Rany Rahmawati', '2023-12-18', 'oke', '0896-2187-8375', 2, 1, 10, '2023-12-17 17:52:13', '2023-12-17 18:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `tentor`
--

CREATE TABLE `tentor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` char(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kursus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tentor`
--

INSERT INTO `tentor` (`id`, `nama`, `tanggal_lahir`, `alamat`, `no_telp`, `kursus_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Randy Rahmawan', NULL, NULL, NULL, 1, 1, NULL, NULL),
(3, 'Randy Rahmawan', '2023-12-21', 'adwadawd', '+62 852 3631 5981', 1, 13, '2023-12-21 10:59:09', '2023-12-21 11:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MrRandy', '$2y$10$/GvFbgCmT86Y63wwCfWQ8.lOH7s9LNB6ohGfXM2tNeVlpz32NrjdW', 1, NULL, NULL, NULL),
(3, 'randyrahmawan', '$2y$10$tydP0IXLHLnNU104Jc7EjOw9zfIiAvyuKj48hBJGAxTiZkZ4a092K', 3, NULL, '2023-12-17 05:17:22', '2023-12-17 05:17:22'),
(10, 'ranyrahmawati', '$2y$10$KdceFZNSsjRPINX8nifOzuPHUVAaiDPRl7326cFVuZLLHjfu25OBq', 3, NULL, '2023-12-17 17:52:13', '2023-12-20 15:20:59'),
(13, 'tentorrandy', '$2y$10$DL.mqdUOpqteJ1hbgFIh6OcHCZPEQctXQ2JNlTLdRHsw4Tvi6nb2K', 2, NULL, '2023-12-21 10:59:09', '2023-12-21 10:59:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailhasil`
--
ALTER TABLE `detailhasil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `detail_waktu`
--
ALTER TABLE `detail_waktu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hasilpilihan`
--
ALTER TABLE `hasilpilihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawaban_id` (`jawaban_id`),
  ADD KEY `pertanyaan_id` (`pertanyaan_id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jadwalquiz`
--
ALTER TABLE `jadwalquiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `jawabanpertanyaan`
--
ALTER TABLE `jawabanpertanyaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pertanyaan_id` (`pertanyaan_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `quiz_kategori`
--
ALTER TABLE `quiz_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_kursus_id_foreign` (`kursus_id`),
  ADD KEY `siswa_user_id_foreign` (`user_id`),
  ADD KEY `siswa_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `tentor`
--
ALTER TABLE `tentor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tentor_kursus_id_foreign` (`kursus_id`),
  ADD KEY `tentor_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_level_id_foreign` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailhasil`
--
ALTER TABLE `detailhasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `detail_waktu`
--
ALTER TABLE `detail_waktu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasilpilihan`
--
ALTER TABLE `hasilpilihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jadwalquiz`
--
ALTER TABLE `jadwalquiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jawabanpertanyaan`
--
ALTER TABLE `jawabanpertanyaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quiz_kategori`
--
ALTER TABLE `quiz_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tentor`
--
ALTER TABLE `tentor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailhasil`
--
ALTER TABLE `detailhasil`
  ADD CONSTRAINT `detailhasil_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detailhasil_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detailhasil_ibfk_4` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwalquiz` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_waktu`
--
ALTER TABLE `detail_waktu`
  ADD CONSTRAINT `detail_waktu_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasilpilihan`
--
ALTER TABLE `hasilpilihan`
  ADD CONSTRAINT `hasilpilihan_ibfk_1` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwalquiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasilpilihan_ibfk_2` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasilpilihan_ibfk_3` FOREIGN KEY (`jawaban_id`) REFERENCES `jawabanpertanyaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasilpilihan_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwalquiz`
--
ALTER TABLE `jadwalquiz`
  ADD CONSTRAINT `jadwalquiz_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jawabanpertanyaan`
--
ALTER TABLE `jawabanpertanyaan`
  ADD CONSTRAINT `jawabanpertanyaan_ibfk_1` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `pertanyaan_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `quiz_kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_kursus_id_foreign` FOREIGN KEY (`kursus_id`) REFERENCES `kursus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tentor`
--
ALTER TABLE `tentor`
  ADD CONSTRAINT `tentor_kursus_id_foreign` FOREIGN KEY (`kursus_id`) REFERENCES `kursus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tentor_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
