-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 11:22 AM
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
-- Database: `team_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_emails`
--

CREATE TABLE `admin_emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_report` int(11) DEFAULT 1,
  `email_leave` int(11) DEFAULT 1,
  `email_summary` int(11) DEFAULT 1,
  `creator` int(11) DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_emails`
--

INSERT INTO `admin_emails` (`id`, `email`, `email_report`, `email_leave`, `email_summary`, `creator`, `editor`, `created_at`, `updated_at`) VALUES
(1, 'juyel@supreoxmail.com', 1, 1, NULL, 1, 20, '2025-01-11 06:29:57', '2025-02-23 08:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `bank_branches`
--

CREATE TABLE `bank_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_branch_name` varchar(255) DEFAULT NULL,
  `bank_branch_creator` int(11) NOT NULL,
  `bank_branch_editor` int(11) DEFAULT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_branches`
--

INSERT INTO `bank_branches` (`id`, `bank_branch_name`, `bank_branch_creator`, `bank_branch_editor`, `bank_id`, `created_at`, `updated_at`) VALUES
(1, 'Mirpur 12 (DOHS)', 1, NULL, 1, '2025-01-16 11:06:09', NULL),
(2, 'Cold', 1, NULL, 1, '2025-01-16 11:06:17', NULL),
(3, 'Farmgate', 1, NULL, 2, '2025-01-19 03:48:47', NULL),
(4, 'Shewrapara', 1, NULL, 2, '2025-01-19 03:49:02', NULL),
(5, 'Mirpur 10', 1, NULL, 2, '2025-01-19 03:49:18', NULL),
(6, 'Mirpu', 1, NULL, 3, '2025-01-19 03:50:10', NULL),
(7, 'Banani', 1, NULL, 4, '2025-01-19 03:50:22', NULL),
(8, 'kawran bazar', 1, NULL, 2, '2025-01-19 04:26:50', NULL),
(9, 'Bangla motor', 1, NULL, 2, '2025-01-19 04:27:03', NULL),
(10, 'Shahbag', 1, NULL, 2, '2025-01-19 04:27:10', NULL),
(11, 'Panthpath', 1, NULL, 2, '2025-01-19 04:27:23', NULL),
(12, 'Lalbag', 1, NULL, 2, '2025-01-19 04:27:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_names`
--

CREATE TABLE `bank_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_creator` int(11) DEFAULT NULL,
  `bank_editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_names`
--

INSERT INTO `bank_names` (`id`, `bank_name`, `bank_creator`, `bank_editor`, `created_at`, `updated_at`) VALUES
(1, 'pubali', 1, NULL, '2025-01-16 11:06:00', NULL),
(2, 'Rupali', 1, NULL, '2025-01-19 03:48:23', NULL),
(3, 'UCB', 1, NULL, '2025-01-19 03:49:39', NULL),
(4, 'Estern', 1, NULL, '2025-01-19 03:49:52', NULL),
(5, 'Jamuna', 1, NULL, '2025-01-19 00:48:21', NULL),
(9, 'Juyelss', 1, 1, '2025-01-19 03:47:36', '2025-01-19 03:55:13'),
(10, 'Carbon', 1, NULL, '2025-01-19 07:34:09', NULL),
(11, 'Mirpur 12 (DOHS)', 1, NULL, '2025-01-23 01:27:25', NULL),
(12, 'Mirpu', 1, NULL, '2025-01-23 01:27:42', NULL),
(13, 'sdfsdf', 1, NULL, '2025-01-23 01:28:55', NULL),
(15, 'sdfvrtre', 1, NULL, '2025-01-23 01:29:52', NULL),
(16, 'edcwer', 1, NULL, '2025-01-23 01:32:42', NULL),
(17, 'dfgbrgfhbrfh', 1, NULL, '2025-01-23 01:33:24', NULL),
(19, 'retbrtbnrt', 1, NULL, '2025-01-23 01:36:22', NULL),
(20, 'sdffewbertb', 1, NULL, '2025-01-23 02:38:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `basics`
--

CREATE TABLE `basics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Mlogo` varchar(100) DEFAULT NULL,
  `Flogo` varchar(100) DEFAULT NULL,
  `favlogo` varchar(100) DEFAULT NULL,
  `copyright` varchar(200) DEFAULT NULL,
  `creator` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basics`
--

INSERT INTO `basics` (`id`, `Mlogo`, `Flogo`, `favlogo`, `copyright`, `creator`, `created_at`, `updated_at`) VALUES
(1, 'mlogo.png', NULL, NULL, 'ETeamifY - By SupreoX', NULL, '2025-01-04 11:51:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:80:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"Admin & Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:1;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:9:\"All Admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:2;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:9:\"Add Admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:3;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:10:\"View Admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:4;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"Edit Admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:5;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"Delete Admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:6;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:8:\"All Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:7;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:8:\"Add Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:8;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:9:\"View Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:9;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:9:\"Edit Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:10;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:11:\"Delete Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:11;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"All Permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:12;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"Add Permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:13;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"View Permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:14;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"Edit Permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:15;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:17:\"Delete Permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:16;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:5:\"Leave\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:17;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:22:\"Leave Application List\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:18;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:18:\"Leave Manually Add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:19;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"View Leave\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:20;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:10:\"Edit Leave\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:21;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"Delete Leave\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:22;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:10:\"Leave Type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:23;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"Leave Type Add\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:24;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"Leave Type View\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:25;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:15:\"Leave Type Edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:26;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:17:\"Leave Type Delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:27;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"Daily-Report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:28;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:17:\"View Daily-Report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:29;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:17:\"Edit Daily-Report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:30;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:24:\"Soft Delete Daily-Report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:31;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:20:\"Restore Daily-Report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:32;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:19:\"Delete Daily-Report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:33;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:8:\"Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:34;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:12:\"Add Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:35;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"View Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:36;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:13:\"Edit Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:37;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:22:\"Login Employee Profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:38;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:20:\"Soft Delete Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:39;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:16:\"Restore Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:40;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:15:\"Delete Employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:41;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:24:\"Department & Designation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:42;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:11:\"Departments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:43;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:14:\"Add Department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:44;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:15:\"View Department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:45;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:15:\"Edit Department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:46;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:17:\"Delete Department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:47;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:11:\"Designation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:48;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:15:\"Add Designation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:49;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:16:\"View Designation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:50;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:16:\"Edit Designation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:51;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:18:\"Delete Designation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:52;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"Office Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:53;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:17:\"Add Office Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:54;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:18:\"View Office Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:55;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:18:\"Edit Office Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:56;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:20:\"Delete Office Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:57;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:13:\"Bank & Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:58;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:11:\"Bank Detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:59;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:15:\"Add Bank Detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:60;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:16:\"View Bank Detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:61;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:16:\"Edit Bank Detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:62;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:18:\"Delete Bank Detail\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:63;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:11:\"Bank Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:64;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:15:\"Add Bank Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:65;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:16:\"View Bank Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:66;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:16:\"Edit Bank Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:67;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:18:\"Delete Bank Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:68;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:8:\"Catering\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:69;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:8:\"Add Meal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:70;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:9:\"View Meal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:71;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:9:\"Edit Meal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:72;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:11:\"Delete Meal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:73;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:11:\"Add Payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:74;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:12:\"Edit Payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:75;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:12:\"View Payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:76;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:14:\"Delete Payment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:77;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:13:\"Check Balance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:78;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:7:\"Setting\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}i:79;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:11:\"Recycle Bin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:7;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"Super Admin\";s:1:\"c\";s:3:\"web\";}}}', 1740311677);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catering_food`
--

CREATE TABLE `catering_food` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `per_cost` int(11) NOT NULL DEFAULT 0,
  `total_cost` int(11) NOT NULL DEFAULT 0,
  `creator` int(11) DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `catering_food`
--

INSERT INTO `catering_food` (`id`, `order_date`, `quantity`, `per_cost`, `total_cost`, `creator`, `editor`, `created_at`, `updated_at`) VALUES
(3, '2025-01-27', 20, 100, 2000, 1, 8, '2025-01-27 11:59:51', '2025-01-28 09:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `catering_payments`
--

CREATE TABLE `catering_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment` decimal(10,2) DEFAULT NULL,
  `total_payment` decimal(10,2) DEFAULT NULL,
  `p_creator` int(11) DEFAULT NULL,
  `p_editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `catering_payments`
--

INSERT INTO `catering_payments` (`id`, `payment_date`, `payment`, `total_payment`, `p_creator`, `p_editor`, `created_at`, `updated_at`) VALUES
(2, '2025-01-22', 9000.00, NULL, 1, NULL, '2025-01-27 11:53:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_icon` varchar(255) DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency_icon`, `editor`, `created_at`, `updated_at`) VALUES
(1, '৳', 18, '2025-02-05 06:22:37', '2025-02-08 01:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `daily_reports`
--

CREATE TABLE `daily_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submit_by` bigint(20) UNSIGNED NOT NULL,
  `submit_date` date DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `check_in` varchar(50) DEFAULT NULL,
  `check_out` varchar(50) DEFAULT NULL,
  `slug` varchar(25) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_reports`
--

INSERT INTO `daily_reports` (`id`, `submit_by`, `submit_date`, `detail`, `check_in`, `check_out`, `slug`, `status`, `editor`, `created_at`, `updated_at`) VALUES
(14, 20, '2025-02-10', '<p>This Is my TEst Work</p><p>&nbsp;</p>', NULL, NULL, 'report-67a98fb312e9f', 1, NULL, '2025-02-09 23:33:39', NULL),
(15, 20, '2026-01-10', '<p>This Is my TEst Work</p><p>&nbsp;</p>', NULL, NULL, 'report-67a98fb312e9f', 1, NULL, '2025-02-09 23:33:39', NULL),
(23, 21, '2025-02-11', '<p>rvgretgb ert</p>', '05:47', '12:47', 'report-67ab38e7532ca', 1, NULL, '2025-02-11 05:47:51', '2025-02-11 05:48:29'),
(24, 21, '2025-02-10', '<p>gverbyer</p>', '05:03', '12:38', 'report-67ab44dc92dab', 1, NULL, '2025-02-11 06:38:52', NULL),
(25, 21, '2025-02-09', '<p>tyntynj yjnr</p>', '05:00', '12:39', 'report-67ab450f2f2b8', 1, NULL, '2025-02-11 06:39:43', NULL),
(26, 21, '2025-02-22', '<p>sdvwertb w</p>', '05:00', '05:58', 'report-67b967863d90e', 1, NULL, '2025-02-21 23:58:30', NULL),
(30, 21, '2025-02-21', '<p>This Is my sss TEst rk</p><p>&nbsp;</p>', '05:30', '01:30', 'report-67b9946e422f3', 1, 21, '2025-02-22 03:10:06', '2025-02-22 05:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depart_name` varchar(255) DEFAULT NULL,
  `depart_creator` int(11) NOT NULL,
  `depart_editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `depart_name`, `depart_creator`, `depart_editor`, `created_at`, `updated_at`) VALUES
(1, 'Mirpur 12 (DOHS)s', 1, 1, '2025-01-13 05:55:39', '2025-01-13 03:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `depart_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `title`, `depart_id`, `created_at`, `updated_at`) VALUES
(1, 'Laravel Web Developer', 1, '2025-01-04 11:51:15', NULL),
(2, 'CTO', 1, '2025-01-16 11:17:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `early_leaves`
--

CREATE TABLE `early_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `leave_type` bigint(20) UNSIGNED NOT NULL,
  `other_type` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `total_hour` varchar(255) DEFAULT NULL,
  `leave_summary` varchar(255) DEFAULT NULL,
  `unpaid_request` int(11) DEFAULT NULL,
  `submit_by` varchar(50) DEFAULT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `editor` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `early_leaves`
--

INSERT INTO `early_leaves` (`id`, `start`, `end`, `leave_date`, `leave_type`, `other_type`, `detail`, `status`, `total_hour`, `leave_summary`, `unpaid_request`, `submit_by`, `emp_id`, `comments`, `editor`, `created_at`, `updated_at`) VALUES
(4, '06:37', '13:30', '2025-02-12', 1, NULL, '<p>vsrgvert</p>', 2, '413', NULL, 0, 'dypuka', 22, 'sdcsefrvfg', 20, '2025-02-12 00:37:32', '2025-02-13 00:09:29'),
(7, '09:45', '13:30', '2025-02-12', 1, NULL, '<p>fdgbsdrtbrsdybaveter</p>', 0, '225', NULL, 0, 'Lee Clements', 22, NULL, 20, '2025-02-12 05:45:30', '2025-02-12 23:25:46'),
(12, '09:16', '13:30', '2025-02-23', 1, NULL, '<p>drtbdrtynbrt</p>', 3, '254', NULL, 0, 'Lee Clements', 22, NULL, 20, '2025-02-23 03:17:01', '2025-02-23 03:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_name` varchar(100) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `email2` varchar(40) DEFAULT NULL,
  `emp_phone` varchar(20) DEFAULT NULL,
  `emp_phone2` varchar(20) DEFAULT NULL,
  `emp_address` varchar(100) DEFAULT NULL,
  `emp_present` varchar(100) DEFAULT NULL,
  `emp_emer_contact` varchar(20) DEFAULT NULL,
  `emp_emer_name` varchar(50) DEFAULT NULL,
  `emp_emer_relation` varchar(100) DEFAULT NULL,
  `emp_dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `marriage` varchar(20) DEFAULT NULL,
  `emp_image` varchar(100) DEFAULT NULL,
  `emp_status` int(11) NOT NULL DEFAULT 1,
  `emp_slug` varchar(24) DEFAULT NULL,
  `emp_report_manager` int(11) DEFAULT NULL,
  `emp_depart_id` int(11) DEFAULT NULL,
  `emp_desig_id` int(11) DEFAULT NULL,
  `emp_role_id` int(11) DEFAULT NULL,
  `emp_type` varchar(255) DEFAULT NULL,
  `emp_join` date DEFAULT NULL,
  `emp_resign` date DEFAULT NULL,
  `eva_start_date` date DEFAULT NULL,
  `eva_end_date` date DEFAULT NULL,
  `emp_id_type` varchar(255) DEFAULT NULL,
  `emp_id_number` varchar(255) DEFAULT NULL,
  `emp_rec_degree` varchar(255) DEFAULT NULL,
  `emp_rec_year` varchar(255) DEFAULT NULL,
  `emp_bank_id` int(11) DEFAULT NULL,
  `emp_bank_branch_id` int(11) DEFAULT NULL,
  `emp_bank_account_name` varchar(255) DEFAULT NULL,
  `emp_bank_account_number` varchar(50) DEFAULT NULL,
  `emp_bank_swift_code` varchar(255) DEFAULT NULL,
  `emp_bank_sort_code` varchar(255) DEFAULT NULL,
  `emp_bank_routing_number` varchar(255) DEFAULT NULL,
  `emp_bank_country` varchar(255) DEFAULT NULL,
  `emp_office_branch_id` int(11) DEFAULT NULL,
  `emp_office_id_number` varchar(255) DEFAULT NULL,
  `emp_office_card_number` varchar(255) DEFAULT NULL,
  `emp_office_IT_requirement` varchar(255) DEFAULT NULL,
  `emp_office_work_schedule` varchar(255) DEFAULT NULL,
  `emp_signature` varchar(255) DEFAULT NULL,
  `emp_creator` int(11) NOT NULL,
  `emp_editor` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `device_token` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_name`, `email`, `email2`, `emp_phone`, `emp_phone2`, `emp_address`, `emp_present`, `emp_emer_contact`, `emp_emer_name`, `emp_emer_relation`, `emp_dob`, `gender`, `marriage`, `emp_image`, `emp_status`, `emp_slug`, `emp_report_manager`, `emp_depart_id`, `emp_desig_id`, `emp_role_id`, `emp_type`, `emp_join`, `emp_resign`, `eva_start_date`, `eva_end_date`, `emp_id_type`, `emp_id_number`, `emp_rec_degree`, `emp_rec_year`, `emp_bank_id`, `emp_bank_branch_id`, `emp_bank_account_name`, `emp_bank_account_number`, `emp_bank_swift_code`, `emp_bank_sort_code`, `emp_bank_routing_number`, `emp_bank_country`, `emp_office_branch_id`, `emp_office_id_number`, `emp_office_card_number`, `emp_office_IT_requirement`, `emp_office_work_schedule`, `emp_signature`, `emp_creator`, `emp_editor`, `password`, `remember_token`, `device_token`, `created_at`, `updated_at`) VALUES
(20, 'Sylvia Bryant', 'mytaf@mailinator.com', 'sajih@mailinator.com', '+1 (801) 792-9432', '70', 'Ea porro sunt quia i', 'Recusandae Vel vita', '52', 'Justina Henderson', 'Labore enim nisi id', '2025-02-12', 'Female', 'Married', NULL, 1, 'user-67a8989c6d162', 20, 1, 1, NULL, 'Freelance', '2025-02-09', NULL, '2021-05-27', '1995-11-10', 'driver_license', '345', 'Labore ut dolorem ut', '2015', 1, 1, 'Herman Wood', '599', '47', '71', NULL, NULL, 1, '29656', '58', 'Ipsam excepteur eius', 'Voluptatibus aut vel', NULL, 1, 1, '$2y$12$6X/9jRWP5WG3EFK98OOhgOwFv2tlIndCwMaB.MqJZdPycKql4kXRm', 'YpoGAJ80y52k9p95Tg5FBkqSTkvRY3nJYEfpm7SOIVagbJDqXtuU4YsI7AGU', NULL, '2025-02-09 11:59:24', '2025-02-12 04:27:44'),
(21, 'dypuka', 'sixohu@mailinator.com', 'monysocuga', '22', '2', 'Teegan Lindsay', 'Teegan Lindsay', '76', 'Rafael Valentine', 'Accusantium nisi ill', '2025-02-02', 'Female', 'Single', NULL, 1, 'emp-67a9c66172836', 20, 1, 1, NULL, 'Hybrid', '2025-02-01', NULL, '2025-02-10', '2025-02-13', 'national_id', '416', 'Beatrice Hammond', '2000', 1, 1, 'David Kaufman', '165', '74', '64', NULL, NULL, 1, '48159', '13', 'Carl Gilliam', 'Hayley Nichols', NULL, 19, 20, '$2y$12$1H/jHh2sukb5HG.IS19op.txEmJ8tOJVoarCsuXk5oRYyXXcGZyFy', 'cGxB0zdqUnkcUCQUs4X9TyoXtJn0KuvEM7FIB2YyHOFO00kglKM65wBIGFK3', NULL, '2025-02-10 03:26:57', '2025-02-13 01:27:21'),
(22, 'Lee Clements', 'juyel@supreoxmail.com', 'povo@mailinator.com', '+1 (321) 308-2793', '64', 'Non do voluptas quia', 'Hic voluptatem volu', '84', 'Kato Dennis', 'Illo porro temporibu', '2025-02-13', 'Male', 'Married', NULL, 1, 'user-67ac781f5cae9', 20, 1, NULL, NULL, 'Internship', '2025-02-12', NULL, '1981-03-27', '1972-07-02', 'ssn', '451', 'Vel amet in dolore', '2019', 19, 1, 'Yuri Sampson', '964', '93', '40', NULL, NULL, 1, '17489', '6', 'Vitae nisi adipisici', 'Temporibus amet nih', NULL, 1, 20, '$2y$12$PxBA/pkP3sznsfxRkuL5yO..GdaPvKTvMMsjfFTlsgVx5d9BO4R/e', 'rhJAwgiRQJKjohehuRsWei4k0SwsIFMyDa8KvaYCyNsWY3lkOiRCLmNjkcEQ', NULL, '2025-02-12 10:29:51', '2025-02-23 03:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `employee_evaluations`
--

CREATE TABLE `employee_evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `eva_last_date` date DEFAULT NULL,
  `eva_next_date` date DEFAULT NULL,
  `evaluated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `renewed_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_evaluations`
--

INSERT INTO `employee_evaluations` (`id`, `emp_id`, `eva_last_date`, `eva_next_date`, `evaluated_by`, `renewed_at`, `created_at`, `updated_at`) VALUES
(1, 21, '2024-11-28', '2025-10-07', 19, NULL, '2025-02-10 03:26:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_promotions`
--

CREATE TABLE `employee_promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED DEFAULT NULL,
  `depart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desig_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pro_status` varchar(20) DEFAULT 'Unchanged',
  `emp_type` varchar(20) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `promoted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `pro_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employe_leave_settings`
--

CREATE TABLE `employe_leave_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_limit` int(11) DEFAULT NULL,
  `month_limit` int(11) DEFAULT NULL,
  `weekoffday` varchar(100) DEFAULT NULL,
  `specialoffday` text DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employe_leave_settings`
--

INSERT INTO `employe_leave_settings` (`id`, `year_limit`, `month_limit`, `weekoffday`, `specialoffday`, `editor`, `created_at`, `updated_at`) VALUES
(1, 14, 3, '5', '2024-12-16, 2024-12-20, 2024-12-25, 2024-12-26, 2024-12-27, 2025-01-08, 2025-01-15, 2025-01-23, 2025-02-14, 2025-02-13, 2025-02-11, 2025-03-13, 2025-03-18, 2025-03-21', 20, '2025-01-04 11:51:16', '2025-02-22 11:58:52');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `leave_type_id` int(11) NOT NULL,
  `other_type` varchar(50) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `slug` varchar(255) DEFAULT NULL,
  `total_paid` int(11) DEFAULT NULL,
  `total_leave_this_month` int(11) DEFAULT NULL,
  `unpaid_request` int(11) DEFAULT NULL,
  `total_unpaid` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `add_from` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `start_date`, `end_date`, `leave_type_id`, `other_type`, `reason`, `status`, `slug`, `total_paid`, `total_leave_this_month`, `unpaid_request`, `total_unpaid`, `emp_id`, `add_from`, `comments`, `editor`, `created_at`, `updated_at`) VALUES
(8, '2025-02-10', '2025-02-13', 1, NULL, '<p>February</p>', 2, 'leav-67a991e85d848', 3, 4, NULL, 1, 20, 'Juyel', NULL, NULL, '2025-02-09 18:00:00', NULL),
(9, '2025-02-20', '2025-02-22', 1, NULL, '<p>From Me</p>', 4, 'leav-67a99207ea73a', 0, 2, NULL, 2, 20, 'Employee', NULL, 19, '2025-02-09 23:43:35', '2025-02-10 05:56:11'),
(10, '2025-02-13', '2025-02-15', 1, NULL, '<p>rebtrwebwd sssssassaxassf</p>', 1, 'leav-67ac5aed75e4b', 2, 2, NULL, NULL, 21, 'dypuka', NULL, 19, '2025-02-12 02:25:17', '2025-02-11 00:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_title` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `type_title`, `created_at`, `updated_at`) VALUES
(1, 'Fever', '2025-01-04 11:51:16', NULL);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_03_111650_create_user_roles_table', 1),
(5, '2024_12_03_193256_create_basics_table', 1),
(6, '2024_12_04_163154_create_designations_table', 1),
(7, '2024_12_04_193205_create_leaves_table', 1),
(8, '2024_12_05_184348_create_employees_table', 1),
(9, '2024_12_10_121016_create_leave_types_table', 1),
(10, '2024_12_10_180519_create_daily_reports_table', 1),
(11, '2024_12_11_131348_create_employe_leave_settings_table', 1),
(12, '2024_12_21_111600_create_time_zones_table', 1),
(13, '2024_12_23_152730_create_office_branches_table', 1),
(14, '2024_12_23_164717_create_bank_names_table', 1),
(15, '2024_12_23_172423_create_bank_branches_table', 1),
(16, '2024_12_23_185842_create_departments_table', 1),
(17, '2024_12_24_152908_create_catering_food_table', 1),
(18, '2024_12_27_120315_create_notifications_table', 1),
(19, '2024_12_29_115429_create_catering_payments_table', 1),
(20, '2025_01_11_120912_create_admin_emails_table', 2),
(21, '2025_01_20_181653_create_personal_access_tokens_table', 3),
(22, '2025_01_30_062738_create_permission_tables', 4),
(23, '2025_01_30_115053_create_currencies_table', 4),
(24, '2025_02_08_144833_create_employee_evaluations_table', 5),
(25, '2025_02_08_151246_create_employee_promotions_table', 1),
(26, '2025_02_09_132522_create_employee_evaluations_table', 6),
(27, '2025_02_11_143529_create_early_leaves_table', 7),
(28, '2025_02_11_145706_create_office_times_table', 7),
(29, '2025_02_11_182101_create_early_leaves_table', 8),
(30, '2025_02_13_125913_create_personal_access_tokens_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(7, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 18),
(7, 'App\\Models\\User', 19),
(7, 'App\\Models\\User', 20);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1d8438c4-7e16-494f-8e6f-8dfe832fb861', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 21, '{\"leave_id\":10,\"emp_id\":21,\"updated_at\":\"2025-02-11T00:26:39.000000Z\"}', NULL, '2025-02-11 06:26:43', '2025-02-11 06:26:43'),
('3684fb41-fc73-4406-b9b3-867c45f01080', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 9, '{\"leave_id\":35,\"emp_id\":9,\"updated_at\":\"2025-02-05T04:10:59.000000Z\"}', NULL, '2025-02-05 10:11:03', '2025-02-05 10:11:03'),
('3b9fee01-aaff-4c62-8f0a-25a0cd76587c', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 20, '{\"leave_id\":9,\"emp_id\":20,\"updated_at\":\"2025-02-10T05:56:11.000000Z\"}', NULL, '2025-02-10 05:56:15', '2025-02-10 05:56:15'),
('3f8dbb6a-beb5-464f-9900-a9400efc2ad8', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 14, '{\"leave_id\":6,\"emp_id\":14,\"updated_at\":\"2025-02-09T05:30:33.000000Z\"}', NULL, '2025-02-09 11:30:37', '2025-02-09 11:30:37'),
('47408ccd-e989-4e04-89db-8caa14f45918', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 21, '{\"leave_id\":10,\"emp_id\":21,\"updated_at\":\"2025-02-10T23:53:43.000000Z\"}', NULL, '2025-02-11 05:53:46', '2025-02-11 05:53:46'),
('6b1c7363-98d8-4758-b595-bc2c83a1cd12', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 1, '{\"leave_id\":38,\"emp_id\":1,\"updated_at\":\"2025-02-05T02:25:45.000000Z\"}', NULL, '2025-02-05 08:25:49', '2025-02-05 08:25:49'),
('9a193b65-3bbf-4d72-b3b0-16c96502339c', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 20, '{\"leave_id\":9,\"emp_id\":20,\"updated_at\":\"2025-02-10T05:44:14.000000Z\"}', NULL, '2025-02-10 05:44:18', '2025-02-10 05:44:18'),
('a5aefc10-4221-4240-bf21-c44955ef2638', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 1, '{\"leave_id\":38,\"emp_id\":1,\"updated_at\":\"2025-02-05T08:25:21.000000Z\"}', NULL, '2025-02-05 08:25:26', '2025-02-05 08:25:26'),
('bb0753ab-edd8-429f-b189-21be3b376b50', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 21, '{\"leave_id\":10,\"emp_id\":21,\"updated_at\":\"2025-02-11T05:52:30.000000Z\"}', NULL, '2025-02-11 05:52:33', '2025-02-11 05:52:33'),
('c34458a1-d482-4da2-89c2-30254cfe10bb', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 21, '{\"leave_id\":10,\"emp_id\":21,\"updated_at\":\"2025-02-11T05:48:20.000000Z\"}', NULL, '2025-02-11 05:48:23', '2025-02-11 05:48:23'),
('c9f38af2-5a8c-488e-a658-2ad436301eaa', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 9, '{\"leave_id\":35,\"emp_id\":9,\"updated_at\":\"2025-02-05T04:09:31.000000Z\"}', NULL, '2025-02-05 10:09:35', '2025-02-05 10:09:35'),
('dd9f0d0c-9bf8-41bd-bd5f-889844820d99', 'App\\Notifications\\LeaveToEmployeNotification', 'App\\Models\\Employee', 21, '{\"leave_id\":10,\"emp_id\":21,\"updated_at\":\"2025-02-10T23:45:38.000000Z\"}', NULL, '2025-02-11 05:45:42', '2025-02-11 05:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `office_branches`
--

CREATE TABLE `office_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `branch_creator` int(11) DEFAULT NULL,
  `branch_editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_branches`
--

INSERT INTO `office_branches` (`id`, `branch_name`, `branch_creator`, `branch_editor`, `created_at`, `updated_at`) VALUES
(1, 'Shewrapara', 1, NULL, '2025-01-19 03:48:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `office_times`
--

CREATE TABLE `office_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `office_start` varchar(50) DEFAULT NULL,
  `office_end` varchar(50) DEFAULT NULL,
  `editor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_times`
--

INSERT INTO `office_times` (`id`, `office_start`, `office_end`, `editor`, `created_at`, `updated_at`) VALUES
(1, '18:00', '13:30', NULL, '2025-02-11 05:41:53', '2025-02-11 05:42:51');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin & Role', 'web', '2025-02-03 05:36:03', '2025-02-03 05:36:15'),
(12, 'All Admin', 'web', '2025-02-03 05:36:32', '2025-02-03 05:36:32'),
(13, 'Add Admin', 'web', '2025-02-03 05:36:56', '2025-02-03 05:36:56'),
(14, 'View Admin', 'web', '2025-02-03 05:37:29', '2025-02-03 05:37:29'),
(15, 'Edit Admin', 'web', '2025-02-03 05:37:37', '2025-02-03 05:37:37'),
(16, 'Delete Admin', 'web', '2025-02-03 05:37:45', '2025-02-03 05:37:45'),
(17, 'All Role', 'web', '2025-02-03 05:38:32', '2025-02-03 05:38:32'),
(18, 'Add Role', 'web', '2025-02-03 05:38:40', '2025-02-03 05:38:40'),
(19, 'View Role', 'web', '2025-02-03 05:38:48', '2025-02-03 05:38:48'),
(20, 'Edit Role', 'web', '2025-02-03 05:38:56', '2025-02-03 05:38:56'),
(21, 'Delete Role', 'web', '2025-02-03 05:39:13', '2025-02-03 05:39:13'),
(22, 'All Permission', 'web', '2025-02-03 05:39:27', '2025-02-03 05:39:27'),
(23, 'Add Permission', 'web', '2025-02-03 05:39:42', '2025-02-03 05:39:42'),
(24, 'View Permission', 'web', '2025-02-03 05:39:52', '2025-02-03 05:39:52'),
(25, 'Edit Permission', 'web', '2025-02-03 05:39:59', '2025-02-03 05:39:59'),
(26, 'Delete Permission', 'web', '2025-02-03 05:40:05', '2025-02-03 05:40:05'),
(27, 'Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
(28, 'Leave Application List', 'web', '2025-02-03 05:45:21', '2025-02-03 05:45:21'),
(29, 'Leave Manually Add', 'web', '2025-02-03 05:46:09', '2025-02-03 05:46:09'),
(30, 'View Leave', 'web', '2025-02-03 05:46:25', '2025-02-03 05:46:25'),
(31, 'Edit Leave', 'web', '2025-02-03 05:46:32', '2025-02-03 05:46:32'),
(32, 'Delete Leave', 'web', '2025-02-03 05:46:38', '2025-02-03 05:46:38'),
(33, 'Leave Type', 'web', '2025-02-03 05:46:56', '2025-02-03 05:46:56'),
(34, 'Leave Type Add', 'web', '2025-02-03 05:47:07', '2025-02-03 05:47:07'),
(35, 'Leave Type View', 'web', '2025-02-03 05:47:19', '2025-02-03 05:47:19'),
(36, 'Leave Type Edit', 'web', '2025-02-03 05:47:30', '2025-02-03 05:47:30'),
(37, 'Leave Type Delete', 'web', '2025-02-03 05:47:37', '2025-02-03 05:47:37'),
(38, 'Daily-Report', 'web', '2025-02-03 05:48:48', '2025-02-03 06:34:22'),
(39, 'View Daily-Report', 'web', '2025-02-03 05:49:00', '2025-02-03 05:49:00'),
(40, 'Edit Daily-Report', 'web', '2025-02-03 05:49:16', '2025-02-03 05:49:16'),
(41, 'Soft Delete Daily-Report', 'web', '2025-02-03 05:50:42', '2025-02-03 05:50:42'),
(42, 'Restore Daily-Report', 'web', '2025-02-03 05:51:24', '2025-02-03 05:51:24'),
(43, 'Delete Daily-Report', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
(44, 'Employee', 'web', '2025-02-03 05:52:12', '2025-02-03 05:52:12'),
(45, 'Add Employee', 'web', '2025-02-03 05:52:26', '2025-02-03 05:52:26'),
(46, 'View Employee', 'web', '2025-02-03 05:53:36', '2025-02-03 05:53:36'),
(47, 'Edit Employee', 'web', '2025-02-03 05:53:46', '2025-02-03 05:53:46'),
(48, 'Login Employee Profile', 'web', '2025-02-03 05:54:31', '2025-02-03 05:54:31'),
(49, 'Soft Delete Employee', 'web', '2025-02-03 05:55:02', '2025-02-03 05:55:02'),
(50, 'Restore Employee', 'web', '2025-02-03 05:55:21', '2025-02-03 05:55:21'),
(51, 'Delete Employee', 'web', '2025-02-03 05:55:29', '2025-02-03 05:55:29'),
(52, 'Department & Designation', 'web', '2025-02-03 06:09:55', '2025-02-03 06:11:35'),
(53, 'Departments', 'web', '2025-02-03 06:13:05', '2025-02-03 06:13:05'),
(54, 'Add Department', 'web', '2025-02-03 06:13:21', '2025-02-03 06:13:21'),
(55, 'View Department', 'web', '2025-02-03 06:13:49', '2025-02-03 06:13:49'),
(56, 'Edit Department', 'web', '2025-02-03 06:13:56', '2025-02-03 06:13:56'),
(57, 'Delete Department', 'web', '2025-02-03 06:14:01', '2025-02-03 06:14:01'),
(58, 'Designation', 'web', '2025-02-03 06:14:07', '2025-02-03 06:14:07'),
(59, 'Add Designation', 'web', '2025-02-03 06:14:14', '2025-02-03 06:14:14'),
(60, 'View Designation', 'web', '2025-02-03 06:14:26', '2025-02-03 06:14:26'),
(61, 'Edit Designation', 'web', '2025-02-03 06:14:40', '2025-02-03 06:14:40'),
(62, 'Delete Designation', 'web', '2025-02-03 06:14:52', '2025-02-03 06:14:52'),
(63, 'Office Branch', 'web', '2025-02-03 06:15:34', '2025-02-03 07:01:56'),
(64, 'Add Office Branch', 'web', '2025-02-03 06:15:52', '2025-02-03 06:15:52'),
(65, 'View Office Branch', 'web', '2025-02-03 06:16:56', '2025-02-03 06:16:56'),
(66, 'Edit Office Branch', 'web', '2025-02-03 06:17:05', '2025-02-03 06:17:05'),
(67, 'Delete Office Branch', 'web', '2025-02-03 06:17:34', '2025-02-03 06:17:34'),
(68, 'Bank & Branch', 'web', '2025-02-03 06:17:58', '2025-02-03 07:31:20'),
(69, 'Bank Detail', 'web', '2025-02-03 06:18:22', '2025-02-03 06:18:22'),
(70, 'Add Bank Detail', 'web', '2025-02-03 06:18:35', '2025-02-03 06:18:35'),
(71, 'View Bank Detail', 'web', '2025-02-03 06:18:46', '2025-02-03 06:18:46'),
(72, 'Edit Bank Detail', 'web', '2025-02-03 06:18:53', '2025-02-03 06:18:53'),
(73, 'Delete Bank Detail', 'web', '2025-02-03 06:19:09', '2025-02-03 06:19:09'),
(74, 'Bank Branch', 'web', '2025-02-03 06:19:30', '2025-02-03 08:23:46'),
(75, 'Add Bank Branch', 'web', '2025-02-03 06:19:56', '2025-02-03 06:19:56'),
(76, 'View Bank Branch', 'web', '2025-02-03 06:20:03', '2025-02-03 06:20:03'),
(77, 'Edit Bank Branch', 'web', '2025-02-03 06:20:16', '2025-02-03 06:20:16'),
(78, 'Delete Bank Branch', 'web', '2025-02-03 06:21:08', '2025-02-03 06:21:08'),
(79, 'Catering', 'web', '2025-02-03 06:21:45', '2025-02-03 06:21:45'),
(80, 'Add Meal', 'web', '2025-02-03 06:22:41', '2025-02-03 06:22:41'),
(81, 'View Meal', 'web', '2025-02-03 06:23:33', '2025-02-03 06:23:33'),
(82, 'Edit Meal', 'web', '2025-02-03 06:23:39', '2025-02-03 06:23:39'),
(83, 'Delete Meal', 'web', '2025-02-03 06:23:44', '2025-02-03 06:23:44'),
(84, 'Add Payment', 'web', '2025-02-03 06:23:58', '2025-02-03 06:23:58'),
(85, 'Edit Payment', 'web', '2025-02-03 06:24:14', '2025-02-03 06:24:14'),
(86, 'View Payment', 'web', '2025-02-03 06:24:20', '2025-02-03 06:24:20'),
(87, 'Delete Payment', 'web', '2025-02-03 06:24:32', '2025-02-03 06:24:32'),
(88, 'Check Balance', 'web', '2025-02-03 06:24:44', '2025-02-03 06:24:44'),
(89, 'Setting', 'web', '2025-02-03 06:25:07', '2025-02-03 06:25:07'),
(90, 'Recycle Bin', 'web', '2025-02-03 06:25:28', '2025-02-03 06:25:28');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(5, 'App\\Models\\Employee', 21, 'MyApp', '7319d65fc7c02440bf730f574fe5fa87586aa5d537cd76f661b4b325e1121799', '[\"*\"]', '2025-02-22 12:11:16', NULL, '2025-02-22 10:26:41', '2025-02-22 12:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(7, 'Super Admin', 'web', '2025-02-06 13:13:53', '2025-02-08 07:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 7),
(12, 7),
(13, 7),
(14, 7),
(15, 7),
(16, 7),
(17, 7),
(18, 7),
(19, 7),
(20, 7),
(21, 7),
(22, 7),
(23, 7),
(24, 7),
(25, 7),
(26, 7),
(27, 7),
(28, 7),
(29, 7),
(30, 7),
(31, 7),
(32, 7),
(33, 7),
(34, 7),
(35, 7),
(36, 7),
(37, 7),
(38, 7),
(39, 7),
(40, 7),
(41, 7),
(42, 7),
(43, 7),
(44, 7),
(45, 7),
(46, 7),
(47, 7),
(48, 7),
(49, 7),
(50, 7),
(51, 7),
(52, 7),
(53, 7),
(54, 7),
(55, 7),
(56, 7),
(57, 7),
(58, 7),
(59, 7),
(60, 7),
(61, 7),
(62, 7),
(63, 7),
(64, 7),
(65, 7),
(66, 7),
(67, 7),
(68, 7),
(69, 7),
(70, 7),
(71, 7),
(72, 7),
(73, 7),
(74, 7),
(75, 7),
(76, 7),
(77, 7),
(78, 7),
(79, 7),
(80, 7),
(81, 7),
(82, 7),
(83, 7),
(84, 7),
(85, 7),
(86, 7),
(87, 7),
(88, 7),
(89, 7),
(90, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NjqDCLGjcsKGDkFBxFjpoFZMSzuDTycsZxMpA8Ry', 20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNU9xQjNXd0E2anhLMWZFTkU3QVNJMEtIUlE0ZmNLVm9QdHFHcVNnOSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjA7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zdXBlcmFkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NToibG9naW5fZW1wbG95ZWVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMjt9', 1740305532);

-- --------------------------------------------------------

--
-- Table structure for table `time_zones`
--

CREATE TABLE `time_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_zones`
--

INSERT INTO `time_zones` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Asia/Dhaka', '2025-01-04 11:51:16', '2025-02-11 12:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `slug`, `image`, `role_id`, `designation_id`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SupreoX', NULL, 'bashar@supreoxmail.com', 'user-677920b3976ed', 'user-67860396be40a.jpg', 1, 1, 1, NULL, '$2y$12$x1abNI3uOHBOTwIqcGLQGOSZcA/zDY2zHGwHk0Pn3rr43gGMCA/t2', NULL, '2025-01-04 11:51:15', '2025-02-02 13:31:56'),
(19, 'Sylvia Bryant', 'juyel@supreoxmail.com', 'mytaf@mailinator.com', 'user-67a8989c32f29', NULL, NULL, 1, 1, NULL, '$2y$12$krSqgPrrhjHhE.G4mdOJA.2pb0m.CSrtadjP8iXqsz6ZqE7n7tz26', 'bohtNq5CHaatt93aeE139Cn71ZvcK2Z23IFvMFBESEYf5bcpKYnL1IsJz2NJ', '2025-02-09 11:59:24', '2025-02-12 04:27:44'),
(20, 'Lee Clements', 'Sed quas aut excepte', 'juyel@supreoxmail.com', 'user-67ac781f28692', NULL, NULL, 1, 1, NULL, '$2y$12$jkmz3vXdUM/F.g.CzEHD5eNz6FAxBECkJgkVxpdKizpI.PTFfrIWS', 'd0dsefBZaz4wjTuJJnGkjpAih4KxKtp5MStXmUKH7qzuab7rPwjM0TfnqDEw', '2025-02-12 10:29:51', '2025-02-23 03:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', '2025-01-04 11:51:15', NULL),
(2, 'HR', '2025-01-14 03:40:52', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_emails`
--
ALTER TABLE `admin_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_branches`
--
ALTER TABLE `bank_branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_branches_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `bank_names`
--
ALTER TABLE `bank_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basics`
--
ALTER TABLE `basics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `catering_food`
--
ALTER TABLE `catering_food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catering_payments`
--
ALTER TABLE `catering_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_reports_submit_by_foreign` (`submit_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `early_leaves`
--
ALTER TABLE `early_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `early_leaves_leave_type_foreign` (`leave_type`),
  ADD KEY `early_leaves_emp_id_foreign` (`emp_id`),
  ADD KEY `early_leaves_editor_foreign` (`editor`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_evaluations`
--
ALTER TABLE `employee_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_evaluations_emp_id_foreign` (`emp_id`),
  ADD KEY `employee_evaluations_evaluated_by_foreign` (`evaluated_by`);

--
-- Indexes for table `employee_promotions`
--
ALTER TABLE `employee_promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_promotions_emp_id_foreign` (`emp_id`),
  ADD KEY `employee_promotions_depart_id_foreign` (`depart_id`);

--
-- Indexes for table `employe_leave_settings`
--
ALTER TABLE `employe_leave_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `office_branches`
--
ALTER TABLE `office_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_times`
--
ALTER TABLE `office_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `time_zones`
--
ALTER TABLE `time_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_emails`
--
ALTER TABLE `admin_emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_branches`
--
ALTER TABLE `bank_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bank_names`
--
ALTER TABLE `bank_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `basics`
--
ALTER TABLE `basics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `catering_food`
--
ALTER TABLE `catering_food`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `catering_payments`
--
ALTER TABLE `catering_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_reports`
--
ALTER TABLE `daily_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `early_leaves`
--
ALTER TABLE `early_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `employee_evaluations`
--
ALTER TABLE `employee_evaluations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_promotions`
--
ALTER TABLE `employee_promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employe_leave_settings`
--
ALTER TABLE `employe_leave_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `office_branches`
--
ALTER TABLE `office_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `office_times`
--
ALTER TABLE `office_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `time_zones`
--
ALTER TABLE `time_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_branches`
--
ALTER TABLE `bank_branches`
  ADD CONSTRAINT `bank_branches_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `bank_names` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD CONSTRAINT `daily_reports_submit_by_foreign` FOREIGN KEY (`submit_by`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `early_leaves`
--
ALTER TABLE `early_leaves`
  ADD CONSTRAINT `early_leaves_editor_foreign` FOREIGN KEY (`editor`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `early_leaves_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `early_leaves_leave_type_foreign` FOREIGN KEY (`leave_type`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_evaluations`
--
ALTER TABLE `employee_evaluations`
  ADD CONSTRAINT `employee_evaluations_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_evaluations_evaluated_by_foreign` FOREIGN KEY (`evaluated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_promotions`
--
ALTER TABLE `employee_promotions`
  ADD CONSTRAINT `employee_promotions_depart_id_foreign` FOREIGN KEY (`depart_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_promotions_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
