-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2023 年 11 月 09 日 02:52
-- サーバのバージョン： 5.7.39
-- PHP のバージョン: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `moneywars`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cate_num` int(11) NOT NULL,
  `cate_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `categories`
--

INSERT INTO `categories` (`id`, `cate_num`, `cate_name`) VALUES
(2, 100, '食費'),
(3, 101, 'ガジェット費'),
(4, 102, '日用品'),
(5, 103, '外食費'),
(6, 104, '医療費'),
(7, 105, '薬費'),
(8, 106, 'サービス費');

-- --------------------------------------------------------
CREATE TABLE `storetypes` (
  `id` SERIAL PRIMARY KEY NOT NULL,
  `store_num` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `storetypes` (`store_num`, `store_name`) VALUES
(10, '実店舗'),
(11, 'Amazon');

ALTER TABLE spendings ADD tgt_storetype int(11) NOT NULL DEFAULT 10;

UPDATE spendings SET tgt_storetype=10;

--
-- テーブルの構造 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2014_10_12_000000_create_users_table', 1),
(8, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(9, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(11, '2023_11_01_203049_create_spendings_table', 1),
(12, '2023_11_03_185345_create_categories_table', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `number`
--

CREATE TABLE `number` (
  `number` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `number`
--

INSERT INTO `number` (`number`) VALUES
(0),
(1),
(2),
(3),
(4),
(5),
(6);

-- --------------------------------------------------------

--
-- テーブルの構造 `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `spendings`
--

CREATE TABLE `spendings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tgt_item` int(11) NOT NULL,
  `tgt_date` date DEFAULT NULL,
  `tgt_payment` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgt_name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `spendings`
--

INSERT INTO `spendings` (`id`, `tgt_item`, `tgt_date`, `tgt_payment`, `created_at`, `updated_at`, `tgt_name`) VALUES
(44, 100, '2023-11-05', 598, '2023-11-05 10:32:44', '2023-11-05 12:24:03', '焼き鳥'),
(45, 100, '2023-11-05', 178, '2023-11-05 10:33:01', '2023-11-05 10:33:01', 'ヨーグルト'),
(46, 100, '2023-11-05', 148, '2023-11-05 10:33:20', '2023-11-05 10:33:20', 'ヨーグルト'),
(47, 100, '2023-11-05', 278, '2023-11-05 14:14:56', '2023-11-05 14:14:56', 'エビアン'),
(48, 102, '2023-10-07', 300, '2023-11-05 14:17:33', '2023-11-05 14:17:33', '便座シート'),
(49, 102, '2023-10-07', 300, '2023-11-05 14:18:05', '2023-11-05 14:18:05', 'トイレマット'),
(50, 102, '2023-10-07', 300, '2023-11-05 14:19:01', '2023-11-05 14:19:01', '消しゴム(DB試験前)'),
(51, 102, '2023-10-07', 300, '2023-11-05 14:19:41', '2023-11-05 14:19:41', '替芯(DB試験用)'),
(52, 102, '2023-10-07', 300, '2023-11-05 14:20:07', '2023-11-05 14:20:07', 'ペンケース(DB試験用)'),
(53, 102, '2023-10-07', 300, '2023-11-05 14:20:32', '2023-11-05 14:20:32', 'シャーペン(DB試験用)'),
(54, 100, '2023-11-06', 258, '2023-11-06 09:05:32', '2023-11-06 09:05:32', 'バナナ2個'),
(55, 100, '2023-11-06', 109, '2023-11-06 09:05:52', '2023-11-06 09:05:52', 'チューハイグレープ'),
(56, 100, '2023-11-06', 99, '2023-11-06 09:06:14', '2023-11-06 09:06:14', 'ゼロハイボール'),
(57, 100, '2023-10-28', 358, '2023-11-08 13:43:31', '2023-11-08 13:43:31', 'ビーフストロガノフ'),
(58, 100, '2023-10-28', 398, '2023-11-08 13:44:18', '2023-11-08 13:44:18', 'ポテトサラダ'),
(59, 100, '2023-10-28', 30, '2023-11-08 13:45:00', '2023-11-08 13:45:00', 'ビーフストロガノフソース'),
(60, 100, '2023-10-28', 598, '2023-11-08 13:45:27', '2023-11-08 13:45:27', 'コーヒー'),
(61, 100, '2023-10-29', 358, '2023-11-08 13:46:37', '2023-11-08 13:46:37', 'ビーフストロガノフ'),
(62, 100, '2023-10-29', 248, '2023-11-08 13:47:03', '2023-11-08 13:47:03', 'チキンかつ'),
(63, 100, '2023-10-29', 398, '2023-11-08 13:47:32', '2023-11-08 13:47:32', 'ポテトサラダ'),
(64, 100, '2023-10-29', 60, '2023-11-08 13:47:59', '2023-11-08 13:47:59', 'ビーフストロガノフソース'),
(65, 102, '2023-10-29', 200, '2023-11-08 13:49:12', '2023-11-08 13:49:12', '汚れスッキリ'),
(66, 100, '2023-10-29', 300, '2023-11-08 13:49:48', '2023-11-08 13:49:48', '浴室ヘアキャッチャー'),
(67, 105, '2023-10-29', 980, '2023-11-08 13:50:18', '2023-11-08 13:50:18', 'アリナミンi'),
(68, 105, '2023-10-29', 1080, '2023-11-08 13:50:41', '2023-11-08 13:50:41', 'バファリン'),
(69, 102, '2023-11-01', 3, '2023-11-08 13:51:04', '2023-11-08 13:51:04', 'レジ袋'),
(70, 100, '2023-11-01', 398, '2023-11-08 13:51:39', '2023-11-08 13:51:39', 'ビーフストロガノフ'),
(71, 100, '2023-11-01', 85, '2023-11-08 13:52:14', '2023-11-08 13:52:14', 'チューハイグレープ'),
(72, 100, '2023-11-01', 109, '2023-11-08 13:52:33', '2023-11-08 13:52:33', 'グレープチューハイ'),
(73, 100, '2023-11-02', 129, '2023-11-08 13:53:35', '2023-11-08 13:53:35', 'ヨーグルト'),
(74, 100, '2023-11-02', 109, '2023-11-08 13:54:04', '2023-11-08 13:54:04', 'チューハイグレープ'),
(75, 100, '2023-11-02', 179, '2023-11-08 13:54:32', '2023-11-08 13:54:32', 'ポタージュスープ'),
(76, 100, '2023-11-02', 129, '2023-11-08 13:54:53', '2023-11-08 13:54:53', 'ヨーグルト'),
(77, 100, '2023-11-02', 99, '2023-11-08 13:55:18', '2023-11-08 13:55:18', '辛口ゼロボール'),
(78, 100, '2023-11-02', 89, '2023-11-08 13:55:41', '2023-11-08 13:55:41', 'よわない檸檬堂'),
(79, 102, '2023-11-03', 3, '2023-11-08 13:56:03', '2023-11-08 13:56:03', 'レジ袋'),
(80, 100, '2023-11-03', 398, '2023-11-08 13:56:23', '2023-11-08 13:56:23', 'ビーフストロガノフ'),
(81, 100, '2023-11-03', 278, '2023-11-08 13:56:41', '2023-11-08 13:56:41', '肉じゃが'),
(82, 100, '2023-11-03', 306, '2023-11-08 13:57:26', '2023-11-08 13:57:26', 'ビーフストロガノフ'),
(83, 100, '2023-11-03', 60, '2023-11-08 13:57:41', '2023-11-08 13:57:41', 'ローストビーフソース'),
(84, 100, '2023-11-04', 3, '2023-11-08 13:58:19', '2023-11-08 13:58:19', 'レジ袋(小)'),
(85, 100, '2023-11-04', 298, '2023-11-08 13:58:48', '2023-11-08 13:58:48', 'ちゃんぽん風スープ'),
(86, 100, '2023-11-04', 298, '2023-11-08 13:59:20', '2023-11-08 13:59:20', '野菜と食べる豆乳スープ'),
(87, 100, '2023-11-04', 258, '2023-11-08 13:59:41', '2023-11-08 13:59:41', 'ビーフストロガノフ'),
(88, 100, '2023-11-04', 258, '2023-11-08 13:59:59', '2023-11-08 13:59:59', 'ビーフストロガノフ'),
(89, 100, '2023-11-04', 30, '2023-11-08 14:00:29', '2023-11-08 14:00:29', 'ローストビーフソース'),
(90, 100, '2023-11-04', 387, '2023-11-08 14:01:00', '2023-11-08 14:01:00', 'ヨーグルト'),
(91, 100, '2023-11-04', 258, '2023-11-08 14:01:18', '2023-11-08 14:01:18', 'バナナ'),
(92, 102, '2023-11-04', 1454, '2023-11-08 14:01:46', '2023-11-08 14:01:46', '入浴用ソルト'),
(93, 100, '2023-11-04', 500, '2023-11-08 14:02:06', '2023-11-08 14:02:06', 'ラベンダーオイル'),
(94, 102, '2023-11-04', 298, '2023-11-08 14:02:33', '2023-11-08 14:02:33', 'キレイキレイ'),
(95, 100, '2023-11-07', 378, '2023-11-08 14:03:00', '2023-11-08 14:03:00', '明太子おにぎり'),
(96, 100, '2023-11-07', 159, '2023-11-08 14:03:27', '2023-11-08 14:03:27', '忍者めし'),
(97, 102, '2023-11-07', 3, '2023-11-08 14:03:45', '2023-11-08 14:03:45', 'レジ袋'),
(98, 100, '2023-11-08', 195, '2023-11-08 14:04:18', '2023-11-08 14:04:18', 'チーズスティック'),
(99, 102, '2023-11-05', 303, '2023-11-08 14:04:53', '2023-11-08 14:04:53', 'モンダミン'),
(100, 102, '2023-11-08', 3, '2023-11-08 14:05:26', '2023-11-08 14:05:26', 'レジ袋'),
(101, 104, '2023-11-08', 680, '2023-11-08 14:05:56', '2023-11-08 14:05:56', 'コーラック'),
(102, 100, '2023-11-08', 100, '2023-11-08 14:06:12', '2023-11-08 14:06:12', '霧島水');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- テーブルのインデックス `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- テーブルのインデックス `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- テーブルのインデックス `spendings`
--
ALTER TABLE `spendings`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `spendings`
--
ALTER TABLE `spendings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
