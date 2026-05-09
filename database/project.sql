-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2026 at 06:05 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `batch` varchar(100) DEFAULT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `element_text` varchar(255) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `full_name`, `batch`, `page_url`, `action_type`, `element_text`, `timestamp`, `ip_address`) VALUES
(1, 1, 'admin', 'abhishek', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-12 19:39:27', '::1'),
(2, 1, 'admin', 'abhishek', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-12 19:39:48', '::1'),
(3, 1, 'admin', 'abhishek', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-12 19:39:48', '::1'),
(4, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-12 19:40:51', '::1'),
(5, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-12 19:42:48', '::1'),
(6, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 15:35:40', '::1'),
(7, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 15:36:49', '::1'),
(8, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 15:36:55', '::1'),
(9, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:03:08', '::1'),
(10, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:06:15', '::1'),
(11, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:06:38', '::1'),
(12, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:07:04', '::1'),
(13, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:07:35', '::1'),
(14, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:10:23', '::1'),
(15, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:10:58', '::1'),
(16, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:11:24', '::1'),
(17, 0, '', '', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-13 16:11:40', '::1'),
(18, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:11:55', '::1'),
(19, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:12:26', '::1'),
(20, 1, 'admin', 'abhishek', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-13 16:12:45', '::1'),
(21, 28, 'student', 'Aaditya Borkar', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-13 16:13:05', '::1'),
(22, 28, 'student', 'Aaditya Borkar', '', 'forms/mark_attendance_page', 'click', '', '2026-02-13 16:14:04', '::1'),
(23, 28, 'student', 'Aaditya Borkar', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-13 16:14:07', '::1'),
(24, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:14:23', '::1'),
(25, 1, 'admin', 'abhishek', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-13 16:14:48', '::1'),
(26, 3, 'student', 'Anuradha Borkar ', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-13 16:15:44', '::1'),
(27, 0, '', '', '', 'show-details/show-study-mat', 'navigation', 'Logout', '2026-02-13 16:15:57', '::1'),
(28, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:16:14', '::1'),
(29, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:16:32', '::1'),
(30, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:18:06', '::1'),
(31, 1, 'admin', 'abhishek', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:18:20', '::1'),
(32, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:30:33', '::1'),
(33, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:30:34', '::1'),
(34, 1, 'admin', '(Unknown)', '', 'forms/teacher-add', 'page_view', '', '2026-02-13 16:30:36', '::1'),
(35, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:30:39', '::1'),
(36, 1, 'admin', '(Unknown)', '', 'forms/student-fee-det', 'page_view', '', '2026-02-13 16:30:57', '::1'),
(37, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:31:00', '::1'),
(38, 1, 'admin', '(Unknown)', '', 'forms/class-add', 'page_view', '', '2026-02-13 16:31:06', '::1'),
(39, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:31:09', '::1'),
(40, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:31:11', '::1'),
(41, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:31:13', '::1'),
(42, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:31:16', '::1'),
(43, 1, 'admin', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-13 16:31:25', '::1'),
(44, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:31:29', '::1'),
(45, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:31:33', '::1'),
(46, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:31:35', '::1'),
(47, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:31:37', '::1'),
(48, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:31:41', '::1'),
(49, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:31:43', '::1'),
(50, 1, 'admin', '(Unknown)', '', 'show-details/show-class', 'page_view', '', '2026-02-13 16:31:45', '::1'),
(51, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:31:52', '::1'),
(52, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:31:55', '::1'),
(53, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:31:57', '::1'),
(54, 1, 'admin', '(Unknown)', '', 'forms/basic-info', 'page_view', '', '2026-02-13 16:31:58', '::1'),
(55, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:32:00', '::1'),
(56, 1, 'admin', '(Unknown)', '', 'forms/examinationform', 'page_view', '', '2026-02-13 16:32:13', '::1'),
(57, 1, 'admin', '(Unknown)', '', 'forms/teacher-add', 'page_view', '', '2026-02-13 16:32:20', '::1'),
(58, 1, 'admin', '(Unknown)', '', 'show-details/show-teacher', 'page_view', '', '2026-02-13 16:32:23', '::1'),
(59, 1, 'admin', '(Unknown)', '', 'forms/basic-info', 'page_view', '', '2026-02-13 16:32:29', '::1'),
(60, 1, 'admin', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-13 16:32:32', '::1'),
(61, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:32:35', '::1'),
(62, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:32:40', '::1'),
(63, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:32:43', '::1'),
(64, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:32:45', '::1'),
(65, 1, 'admin', '(Unknown)', '', 'forms/student-fee-det', 'page_view', '', '2026-02-13 16:32:51', '::1'),
(66, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:32:54', '::1'),
(67, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:32:57', '::1'),
(68, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:32:59', '::1'),
(69, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:33:01', '::1'),
(70, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:34:01', '::1'),
(71, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:34:03', '::1'),
(72, 1, 'admin', '(Unknown)', '', 'forms/time-table', 'page_view', '', '2026-02-13 16:34:05', '::1'),
(73, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:34:08', '::1'),
(74, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:34:18', '::1'),
(75, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:34:19', '::1'),
(76, 1, 'admin', '(Unknown)', '', 'forms/parent-add', 'page_view', '', '2026-02-13 16:34:23', '::1'),
(77, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:34:27', '::1'),
(78, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:34:31', '::1'),
(79, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:34:32', '::1'),
(80, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:34:34', '::1'),
(81, 1, 'admin', '(Unknown)', '', 'forms/basic-info', 'page_view', '', '2026-02-13 16:35:06', '::1'),
(82, 1, 'admin', '(Unknown)', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-13 16:35:12', '::1'),
(83, 1, 'admin', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-13 16:35:13', '::1'),
(84, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:35:16', '::1'),
(85, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:35:20', '::1'),
(86, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:35:22', '::1'),
(87, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:35:24', '::1'),
(88, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:38:33', '::1'),
(89, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:38:35', '::1'),
(90, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:38:37', '::1'),
(91, 1, 'admin', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-13 16:38:46', '::1'),
(92, 1, 'admin', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-13 16:38:49', '::1'),
(93, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:38:51', '::1'),
(94, 1, 'admin', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-13 16:38:56', '::1'),
(95, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:38:58', '::1'),
(96, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:39:02', '::1'),
(97, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:39:04', '::1'),
(98, 1, 'admin', '(Unknown)', '', 'forms/teacher-add', 'page_view', '', '2026-02-13 16:39:07', '::1'),
(99, 1, 'admin', '(Unknown)', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-13 16:39:13', '::1'),
(100, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:39:15', '::1'),
(101, 1, 'admin', '(Unknown)', '', 'show-details/show-course', 'page_view', '', '2026-02-13 16:39:29', '::1'),
(102, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:39:33', '::1'),
(103, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:39:35', '::1'),
(104, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:39:37', '::1'),
(105, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:39:41', '::1'),
(106, 1, 'admin', '(Unknown)', '', 'forms/student-fee-det', 'page_view', '', '2026-02-13 16:41:33', '::1'),
(107, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:41:35', '::1'),
(108, 1, 'admin', '(Unknown)', '', 'forms/class-add', 'page_view', '', '2026-02-13 16:42:23', '::1'),
(109, 1, 'admin', '(Unknown)', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-13 16:42:56', '::1'),
(110, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:43:01', '::1'),
(111, 1, 'admin', '(Unknown)', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-13 16:43:14', '::1'),
(112, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:43:18', '::1'),
(113, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:43:22', '::1'),
(114, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:43:24', '::1'),
(115, 1, 'admin', '(Unknown)', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-13 16:43:29', '::1'),
(116, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:43:34', '::1'),
(117, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:43:42', '::1'),
(118, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:43:52', '::1'),
(119, 1, 'admin', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-13 16:43:59', '::1'),
(120, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:44:03', '::1'),
(121, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 16:44:07', '::1'),
(122, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 16:44:09', '::1'),
(123, 1, 'admin', '(Unknown)', '', 'show-details/show-parent', 'page_view', '', '2026-02-13 16:44:12', '::1'),
(124, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:44:15', '::1'),
(125, 1, 'admin', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-13 16:45:05', '::1'),
(126, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 16:48:01', '::1'),
(127, 1, 'admin', '(Unknown)', '', 'forms/student-add', 'page_view', '', '2026-02-13 16:54:01', '::1'),
(128, 1, 'admin', '(Unknown)', '', 'show-details/show-student', 'page_view', '', '2026-02-13 16:54:05', '::1'),
(129, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 17:01:16', '::1'),
(130, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 17:01:18', '::1'),
(131, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 17:01:20', '::1'),
(132, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 17:05:42', '::1'),
(133, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 17:05:43', '::1'),
(134, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 17:05:46', '::1'),
(135, 1, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 17:10:52', '::1'),
(136, 1, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 17:10:54', '::1'),
(137, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 17:10:57', '::1'),
(138, 1, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-13 18:33:14', '::1'),
(139, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 18:35:19', '::1'),
(140, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 18:35:21', '::1'),
(141, 2, 'admin', '(Unknown)', '', 'forms/class-events-add', 'page_view', '', '2026-02-13 18:35:23', '::1'),
(142, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 18:35:26', '::1'),
(143, 2, 'admin', '(Unknown)', '', 'forms/class-events-add', 'page_view', '', '2026-02-13 18:35:49', '::1'),
(144, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 18:35:56', '::1'),
(145, 2, 'admin', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-13 18:37:40', '::1'),
(146, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 18:37:48', '::1'),
(147, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 18:38:00', '::1'),
(148, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 18:38:03', '::1'),
(149, 2, 'admin', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-13 18:38:05', '::1'),
(150, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 18:38:11', '::1'),
(151, 2, 'admin', '(Unknown)', '', 'forms/teacher-add', 'page_view', '', '2026-02-13 18:44:09', '::1'),
(152, 2, 'admin', '(Unknown)', '', 'show-details/show-teacher', 'page_view', '', '2026-02-13 18:46:29', '::1'),
(153, 2, 'admin', '(Unknown)', '', 'forms/student-add', 'page_view', '', '2026-02-13 18:46:31', '::1'),
(154, 2, 'admin', '(Unknown)', '', 'show-details/show-parent', 'page_view', '', '2026-02-13 18:49:06', '::1'),
(155, 2, 'admin', '(Unknown)', '', 'forms/parent-add', 'page_view', '', '2026-02-13 18:49:07', '::1'),
(156, 2, 'admin', '(Unknown)', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-13 18:51:44', '::1'),
(157, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:03:00', '::1'),
(158, 2, 'admin', '(Unknown)', '', 'forms/teacher-add', 'page_view', '', '2026-02-13 19:06:39', '::1'),
(159, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:13:30', '::1'),
(160, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:13:31', '::1'),
(161, 2, 'admin', '(Unknown)', '', 'forms/teacher-add', 'page_view', '', '2026-02-13 19:13:44', '::1'),
(162, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:28:06', '::1'),
(163, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:28:08', '::1'),
(164, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:28:11', '::1'),
(165, 2, 'admin', '(Unknown)', '', 'forms/student-fee-det', 'page_view', '', '2026-02-13 19:29:00', '::1'),
(166, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:29:04', '::1'),
(167, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:43:09', '::1'),
(168, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:43:11', '::1'),
(169, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:43:13', '::1'),
(170, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:44:35', '::1'),
(171, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:44:37', '::1'),
(172, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:44:39', '::1'),
(173, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:44:47', '::1'),
(174, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:44:48', '::1'),
(175, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:44:51', '::1'),
(176, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:45:19', '::1'),
(177, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:45:20', '::1'),
(178, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:45:22', '::1'),
(179, 2, 'admin', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-13 19:45:42', '::1'),
(180, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:45:45', '::1'),
(181, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:56:02', '::1'),
(182, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:56:05', '::1'),
(183, 2, 'admin', '(Unknown)', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-13 19:56:07', '::1'),
(184, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:56:10', '::1'),
(185, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-13 19:56:38', '::1'),
(186, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-13 19:56:40', '::1'),
(187, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-13 19:56:42', '::1'),
(188, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:13:38', '::1'),
(189, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:13:43', '::1'),
(190, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:13:45', '::1'),
(191, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-14 17:25:26', '::1'),
(192, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:26:02', '::1'),
(193, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:26:05', '::1'),
(194, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:26:07', '::1'),
(195, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:26:19', '::1'),
(196, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:26:21', '::1'),
(197, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:26:23', '::1'),
(198, 2, 'admin', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-14 17:26:51', '::1'),
(199, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:27:15', '::1'),
(200, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-14 17:27:31', '::1'),
(201, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:28:36', '::1'),
(202, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:28:38', '::1'),
(203, 2, 'admin', '(Unknown)', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 17:28:43', '::1'),
(204, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:28:45', '::1'),
(205, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:38:00', '::1'),
(206, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:38:01', '::1'),
(207, 2, 'admin', '(Unknown)', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-14 17:38:04', '::1'),
(208, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:38:07', '::1'),
(209, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:52:04', '::1'),
(210, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:52:06', '::1'),
(211, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:52:08', '::1'),
(212, NULL, 'admin', '', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-14 17:52:45', NULL),
(213, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:55:26', '::1'),
(214, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:55:27', '::1'),
(215, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:55:29', '::1'),
(216, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 17:56:32', '::1'),
(217, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 17:56:33', '::1'),
(218, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 17:56:35', '::1'),
(219, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:02:29', '::1'),
(220, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:02:30', '::1'),
(221, 2, 'admin', '(Unknown)', '', 'show-details/show-class', 'page_view', '', '2026-02-14 18:02:31', '::1'),
(222, 2, 'admin', '(Unknown)', '', 'show-details/show-class', 'click', '', '2026-02-14 18:02:33', '::1'),
(223, 2, 'admin', '(Unknown)', '', 'show-details/show-class', 'click', '', '2026-02-14 18:02:35', '::1'),
(224, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:02:38', '::1'),
(225, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:05:42', '::1'),
(226, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:05:43', '::1'),
(227, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:05:49', '::1'),
(228, NULL, 'admin', '', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-14 18:05:54', NULL),
(229, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:06:48', '::1'),
(230, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:06:51', '::1'),
(231, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:06:54', '::1'),
(232, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:07:24', '::1'),
(233, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:10:04', '::1'),
(234, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:10:07', '::1'),
(235, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:10:58', '::1'),
(236, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:10:58', '::1'),
(237, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:11:04', '::1'),
(238, 0, 'admin', 'shreye', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-14 18:11:06', NULL),
(239, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:05', '::1'),
(240, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:07', '::1'),
(241, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:08', '::1'),
(242, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:09', '::1'),
(243, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:09', '::1'),
(244, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:09', '::1'),
(245, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Settings', '2026-02-14 18:12:10', '::1'),
(246, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Settings', '2026-02-14 18:12:11', '::1'),
(247, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Settings', '2026-02-14 18:12:11', '::1'),
(248, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:11', '::1'),
(249, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:12', '::1'),
(250, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'navigation', 'Profile', '2026-02-14 18:12:12', '::1'),
(251, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:15:12', '::1'),
(252, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:15:15', '::1'),
(253, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:15:18', '::1'),
(254, 0, 'admin', 'shreye', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-14 18:15:20', NULL),
(255, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:20:30', '::1'),
(256, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:20:31', '::1'),
(257, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:20:34', '::1'),
(258, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:22:59', '::1'),
(259, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:23:01', '::1'),
(260, 2, 'admin', '(Unknown)', '', 'forms/basic-info', 'page_view', '', '2026-02-14 18:23:03', '::1'),
(261, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:23:06', '::1'),
(262, 0, 'admin', 'shreye', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-14 18:23:10', NULL),
(263, 2, 'admin', '(Unknown)', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:45:17', '::1'),
(264, 2, 'admin', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-14 18:45:17', '::1'),
(265, 2, 'admin', '(Unknown)', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-14 18:45:20', '::1'),
(266, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:45:23', '::1'),
(267, 2, 'admin', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-14 18:45:57', '::1'),
(268, 2, 'admin', '(Unknown)', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:46:01', '::1'),
(269, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 18:56:45', '::1'),
(270, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Profile', '2026-02-14 18:56:49', '::1'),
(271, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'navigation', 'Profile', '2026-02-14 18:56:49', '::1'),
(272, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 18:58:07', '::1'),
(273, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-14 18:58:10', '::1'),
(274, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 18:58:13', '::1'),
(275, 0, 'admin', 'shreye', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-14 19:01:22', NULL),
(276, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-14 19:09:19', '::1'),
(277, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-14 19:09:22', '::1'),
(278, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:10:37', '::1'),
(279, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:10:39', '::1'),
(280, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 19:10:43', '::1'),
(281, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:13:49', '::1'),
(282, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:13:51', '::1'),
(283, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 19:13:53', '::1'),
(284, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:15:01', '::1'),
(285, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:15:03', '::1'),
(286, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 19:15:07', '::1'),
(287, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:18:49', '::1'),
(288, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:18:52', '::1'),
(289, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 19:18:55', '::1'),
(290, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:24:22', '::1'),
(291, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'navigation', 'Mark all read', '2026-02-14 19:24:26', '::1'),
(292, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'navigation', 'View all notifications', '2026-02-14 19:24:27', '::1'),
(293, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:24:30', '::1'),
(294, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:24:31', '::1'),
(295, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-14 19:24:35', '::1'),
(296, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:27:39', '::1'),
(297, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-14 19:27:40', '::1'),
(298, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-14 19:27:41', '::1'),
(299, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-14 19:27:43', '::1'),
(300, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-14 19:27:44', '::1'),
(301, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-14 19:27:45', '::1'),
(302, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-14 19:27:46', '::1'),
(303, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-14 19:27:50', '::1'),
(304, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-14 19:27:51', '::1'),
(305, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-14 19:27:54', '::1'),
(306, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-14 19:27:57', '::1'),
(307, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-14 19:28:01', '::1'),
(308, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-14 19:28:04', '::1'),
(309, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 19:28:07', '::1'),
(310, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-14 19:28:12', '::1'),
(311, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:28:14', '::1'),
(312, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-14 19:28:17', '::1'),
(313, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-14 19:28:20', '::1'),
(314, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-14 19:28:28', '::1'),
(315, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 19:29:11', '::1'),
(316, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:29:14', '::1'),
(317, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-14 19:29:16', '::1'),
(318, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-14 19:29:23', '::1'),
(319, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-14 19:29:44', '::1'),
(320, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-14 19:29:51', '::1'),
(321, 2, 'admin', 'shreye', '', 'forms/result-add', 'page_view', '', '2026-02-14 19:29:53', '::1'),
(322, 2, 'admin', 'shreye', '', 'show-details/show-result', 'page_view', '', '2026-02-14 19:29:58', '::1'),
(323, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-14 19:30:01', '::1'),
(324, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-14 19:30:03', '::1'),
(325, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-14 19:30:06', '::1'),
(326, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-14 19:30:09', '::1'),
(327, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-14 19:30:13', '::1'),
(328, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-14 19:30:21', '::1'),
(329, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 19:30:49', '::1'),
(330, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:31:10', '::1'),
(331, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-14 19:31:25', '::1'),
(332, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-14 19:31:25', '::1'),
(333, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-14 19:31:28', '::1'),
(334, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-14 19:31:29', '::1'),
(335, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-14 19:31:32', '::1'),
(336, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-14 19:31:33', '::1'),
(337, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-14 19:31:46', '::1'),
(338, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-14 19:31:47', '::1'),
(339, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-14 19:31:48', '::1'),
(340, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-14 19:31:52', '::1'),
(341, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-14 19:32:09', '::1'),
(342, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 19:32:13', '::1'),
(343, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-14 19:33:21', '::1'),
(344, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:43:36', '::1'),
(345, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:43:38', '::1'),
(346, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 19:43:42', '::1'),
(347, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 19:43:52', '::1'),
(348, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 19:43:59', '::1'),
(349, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:47:16', '::1'),
(350, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-14 19:47:27', '::1'),
(351, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:47:28', '::1'),
(352, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-14 19:47:30', '::1'),
(353, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-14 19:47:31', '::1'),
(354, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-14 19:47:31', '::1'),
(355, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-14 19:47:32', '::1'),
(356, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:47:32', '::1'),
(357, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 19:48:50', '::1'),
(358, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 19:48:52', '::1'),
(359, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:49:03', '::1'),
(360, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:49:04', '::1'),
(361, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 19:49:07', '::1'),
(362, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 19:49:08', '::1'),
(363, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-14 19:49:14', '::1'),
(364, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 19:49:20', '::1'),
(365, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-14 19:49:38', '::1'),
(366, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-14 19:49:39', '::1'),
(367, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-14 19:49:41', '::1'),
(368, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 19:49:42', '::1'),
(369, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-14 19:50:10', '::1'),
(370, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 20:01:26', '::1'),
(371, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 20:01:28', '::1'),
(372, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 20:01:31', '::1'),
(373, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 20:01:35', '::1'),
(374, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-14 20:01:36', '::1'),
(375, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 20:01:40', '::1'),
(376, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 20:01:40', '::1'),
(377, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-14 20:01:41', '::1'),
(378, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-14 20:01:42', '::1'),
(379, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 20:01:53', '::1'),
(380, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:01:54', '::1'),
(381, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 20:02:11', '::1'),
(382, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 20:04:47', '::1'),
(383, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 20:04:49', '::1'),
(384, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:04:51', '::1'),
(385, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 20:05:22', '::1'),
(386, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-14 20:07:00', '::1'),
(387, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:07:09', '::1'),
(388, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 20:07:44', '::1'),
(389, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:07:49', '::1'),
(390, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-14 20:08:06', '::1'),
(391, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:10:51', '::1'),
(392, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 20:10:54', '::1'),
(393, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 20:10:55', '::1'),
(394, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:10:58', '::1'),
(395, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-14 20:12:49', '::1'),
(396, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-14 20:12:51', '::1'),
(397, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-14 20:12:54', '::1'),
(398, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-14 20:12:58', '::1'),
(399, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:13:05', '::1'),
(400, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 20:13:08', '::1'),
(401, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:13:17', '::1'),
(402, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 20:13:26', '::1'),
(403, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-14 20:13:29', '::1'),
(404, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-14 20:13:33', '::1'),
(405, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-14 20:13:34', '::1'),
(406, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-14 20:13:38', '::1'),
(407, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-14 20:13:39', '::1'),
(408, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-14 20:14:48', '::1'),
(409, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-14 20:14:55', '::1'),
(410, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:14:58', '::1'),
(411, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-15 11:15:10', '::1'),
(412, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:15:13', '::1'),
(413, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php#', 'click', '', '2026-02-15 11:15:15', '::1'),
(414, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 11:15:18', '::1'),
(415, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:15:34', '::1'),
(416, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 11:15:37', '::1'),
(417, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 11:15:41', '::1'),
(418, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:22:42', '::1'),
(419, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 11:22:43', '::1'),
(420, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 11:22:46', '::1'),
(421, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 11:23:02', '::1'),
(422, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 11:23:04', '::1'),
(423, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 11:23:45', '::1'),
(424, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:27:29', '::1'),
(425, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 11:27:29', '::1'),
(426, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 11:27:32', '::1'),
(427, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:28:02', '::1'),
(428, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 11:28:09', '::1'),
(429, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:42:04', '::1'),
(430, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:42:07', '::1'),
(431, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 11:42:09', '::1');
INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `full_name`, `batch`, `page_url`, `action_type`, `element_text`, `timestamp`, `ip_address`) VALUES
(432, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:42:14', '::1'),
(433, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:42:27', '::1'),
(434, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-15 11:42:32', '::1'),
(435, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 11:42:49', '::1'),
(436, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 11:42:51', '::1'),
(437, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:42:56', '::1'),
(438, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 11:43:15', '::1'),
(439, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 11:43:44', '::1'),
(440, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-15 11:44:12', '::1'),
(441, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:44:18', '::1'),
(442, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 11:44:29', '::1'),
(443, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-15 11:44:30', '::1'),
(444, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 11:44:31', '::1'),
(445, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 11:44:59', '::1'),
(446, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 11:45:00', '::1'),
(447, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 11:45:26', '::1'),
(448, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:45:47', '::1'),
(449, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 11:46:02', '::1'),
(450, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 11:46:37', '::1'),
(451, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-15 11:46:38', '::1'),
(452, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 11:46:40', '::1'),
(453, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 11:47:24', '::1'),
(454, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 11:47:25', '::1'),
(455, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 11:47:27', '::1'),
(456, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 11:48:41', '::1'),
(457, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:50:12', '::1'),
(458, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 11:50:17', '::1'),
(459, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 11:50:45', '::1'),
(460, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 11:51:29', '::1'),
(461, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:02:42', '::1'),
(462, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:02:44', '::1'),
(463, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 12:02:52', '::1'),
(464, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:03:44', '::1'),
(465, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:03:49', '::1'),
(466, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 12:03:52', '::1'),
(467, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 12:04:10', '::1'),
(468, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:06:20', '::1'),
(469, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:06:22', '::1'),
(470, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 12:06:24', '::1'),
(471, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:06:55', '::1'),
(472, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:06:58', '::1'),
(473, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 12:07:02', '::1'),
(474, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:11:11', '::1'),
(475, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:11:14', '::1'),
(476, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 12:11:17', '::1'),
(477, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 12:11:32', '::1'),
(478, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 12:11:49', '::1'),
(479, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:41:41', '::1'),
(480, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:41:43', '::1'),
(481, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 12:41:48', '::1'),
(482, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:46:28', '::1'),
(483, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:46:29', '::1'),
(484, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 12:46:36', '::1'),
(485, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 12:47:13', '::1'),
(486, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 12:47:19', '::1'),
(487, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:50:05', '::1'),
(488, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:50:06', '::1'),
(489, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 12:50:09', '::1'),
(490, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 12:50:27', '::1'),
(491, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 12:50:36', '::1'),
(492, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:53:43', '::1'),
(493, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 12:53:46', '::1'),
(494, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 12:53:53', '::1'),
(495, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-15 12:54:03', '::1'),
(496, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-15 12:54:04', '::1'),
(497, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-15 12:54:06', '::1'),
(498, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-15 12:54:07', '::1'),
(499, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-15 12:54:11', '::1'),
(500, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 12:54:14', '::1'),
(501, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 12:54:17', '::1'),
(502, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-15 12:54:18', '::1'),
(503, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 12:54:19', '::1'),
(504, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 12:54:20', '::1'),
(505, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 12:54:22', '::1'),
(506, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 12:54:23', '::1'),
(507, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 12:54:34', '::1'),
(508, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-15 12:54:44', '::1'),
(509, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 12:54:53', '::1'),
(510, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 12:54:58', '::1'),
(511, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 12:56:07', '::1'),
(512, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 12:56:12', '::1'),
(513, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 12:59:26', '::1'),
(514, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 12:59:59', '::1'),
(515, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:00:00', '::1'),
(516, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:00:06', '::1'),
(517, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 13:02:11', '::1'),
(518, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 13:03:36', '::1'),
(519, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 13:04:09', '::1'),
(520, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 13:04:25', '::1'),
(521, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 13:05:03', '::1'),
(522, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 13:05:15', '::1'),
(523, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 13:05:37', '::1'),
(524, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-15 13:06:10', '::1'),
(525, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-15 13:06:14', '::1'),
(526, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-15 13:06:15', '::1'),
(527, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 13:06:16', '::1'),
(528, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-15 13:06:18', '::1'),
(529, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-15 13:06:22', '::1'),
(530, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-15 13:06:23', '::1'),
(531, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-15 13:06:23', '::1'),
(532, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-15 13:06:24', '::1'),
(533, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-15 13:06:27', '::1'),
(534, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 13:06:28', '::1'),
(535, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-15 13:06:31', '::1'),
(536, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 13:06:32', '::1'),
(537, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 13:06:33', '::1'),
(538, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 13:06:35', '::1'),
(539, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 13:06:36', '::1'),
(540, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:06:37', '::1'),
(541, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-15 13:06:40', '::1'),
(542, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-15 13:06:42', '::1'),
(543, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-15 13:06:43', '::1'),
(544, 2, 'admin', 'shreye', '', 'forms/result-add', 'page_view', '', '2026-02-15 13:06:44', '::1'),
(545, 2, 'admin', 'shreye', '', 'show-details/show-result', 'page_view', '', '2026-02-15 13:06:46', '::1'),
(546, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 13:06:49', '::1'),
(547, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 13:06:50', '::1'),
(548, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 13:06:53', '::1'),
(549, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-15 13:06:54', '::1'),
(550, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 13:07:00', '::1'),
(551, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-15 13:07:09', '::1'),
(552, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-15 13:07:53', '::1'),
(553, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-15 13:07:55', '::1'),
(554, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 13:08:01', '::1'),
(555, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:11:34', '::1'),
(556, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:11:36', '::1'),
(557, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:11:36', '::1'),
(558, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:11:38', '::1'),
(559, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:11:53', '::1'),
(560, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'click', '', '2026-02-15 13:12:16', '::1'),
(561, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:13:21', '::1'),
(562, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:13:23', '::1'),
(563, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:13:27', '::1'),
(564, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:17:09', '::1'),
(565, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:17:11', '::1'),
(566, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:17:14', '::1'),
(567, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:17:24', '::1'),
(568, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:17:25', '::1'),
(569, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:17:28', '::1'),
(570, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:17:59', '::1'),
(571, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:18:00', '::1'),
(572, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:18:03', '::1'),
(573, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:19:17', '::1'),
(574, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:19:20', '::1'),
(575, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:19:23', '::1'),
(576, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:19:30', '::1'),
(577, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:19:32', '::1'),
(578, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:19:46', '::1'),
(579, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:20:37', '::1'),
(580, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:20:38', '::1'),
(581, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:20:41', '::1'),
(582, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:21:18', '::1'),
(583, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:21:19', '::1'),
(584, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:21:23', '::1'),
(585, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:27:31', '::1'),
(586, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:27:34', '::1'),
(587, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:27:37', '::1'),
(588, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'click', '', '2026-02-15 13:28:37', '::1'),
(589, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:29:09', '::1'),
(590, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:29:10', '::1'),
(591, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:29:14', '::1'),
(592, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:29:23', '::1'),
(593, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:29:24', '::1'),
(594, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:29:27', '::1'),
(595, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:30:18', '::1'),
(596, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:30:19', '::1'),
(597, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:30:22', '::1'),
(598, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:31:20', '::1'),
(599, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:31:21', '::1'),
(600, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:31:24', '::1'),
(601, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:32:20', '::1'),
(602, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:32:22', '::1'),
(603, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:32:25', '::1'),
(604, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:32:45', '::1'),
(605, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:32:47', '::1'),
(606, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:32:50', '::1'),
(607, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:33:00', '::1'),
(608, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:33:02', '::1'),
(609, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:33:04', '::1'),
(610, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'click', '', '2026-02-15 13:33:13', '::1'),
(611, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:33:55', '::1'),
(612, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:33:56', '::1'),
(613, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:33:59', '::1'),
(614, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:34:39', '::1'),
(615, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:34:42', '::1'),
(616, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:34:45', '::1'),
(617, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 13:35:06', '::1'),
(618, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 13:35:08', '::1'),
(619, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:35:10', '::1'),
(620, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:35:32', '::1'),
(621, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:35:35', '::1'),
(622, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:35:37', '::1'),
(623, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:39:12', '::1'),
(624, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:39:14', '::1'),
(625, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:39:17', '::1'),
(626, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:43:09', '::1'),
(627, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:43:10', '::1'),
(628, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:43:14', '::1'),
(629, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:43:46', '::1'),
(630, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:43:48', '::1'),
(631, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:43:51', '::1'),
(632, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:44:20', '::1'),
(633, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:44:23', '::1'),
(634, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:44:28', '::1'),
(635, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:46:08', '::1'),
(636, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:46:09', '::1'),
(637, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:46:12', '::1'),
(638, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:47:03', '::1'),
(639, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:47:05', '::1'),
(640, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:47:09', '::1'),
(641, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:49:49', '::1'),
(642, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:49:51', '::1'),
(643, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:49:54', '::1'),
(644, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:51:44', '::1'),
(645, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:51:45', '::1'),
(646, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:51:48', '::1'),
(647, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:52:15', '::1'),
(648, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:52:17', '::1'),
(649, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 13:52:19', '::1'),
(650, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 13:52:30', '::1'),
(651, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 13:53:21', '::1'),
(652, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:20:33', '::1'),
(653, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:20:41', '::1'),
(654, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 14:20:51', '::1'),
(655, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 14:20:52', '::1'),
(656, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-15 14:20:54', '::1'),
(657, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 14:21:00', '::1'),
(658, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 14:25:51', '::1'),
(659, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 14:25:52', '::1'),
(660, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 14:25:54', '::1'),
(661, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:39:38', '::1'),
(662, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 14:39:59', '::1'),
(663, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 14:40:03', '::1'),
(664, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-15 14:40:06', '::1'),
(665, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:40:08', '::1'),
(666, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:40:10', '::1'),
(667, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 14:40:16', '::1'),
(668, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:40:31', '::1'),
(669, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 14:41:00', '::1'),
(670, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 14:41:19', '::1'),
(671, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-15 14:41:29', '::1'),
(672, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-15 14:41:31', '::1'),
(673, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-15 14:41:33', '::1'),
(674, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-15 14:41:49', '::1'),
(675, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 14:41:53', '::1'),
(676, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-15 14:41:55', '::1'),
(677, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-15 14:41:58', '::1'),
(678, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-15 14:41:59', '::1'),
(679, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-15 14:42:02', '::1'),
(680, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-15 14:42:04', '::1'),
(681, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-15 14:42:07', '::1'),
(682, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 14:42:10', '::1'),
(683, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-15 14:42:13', '::1'),
(684, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-15 14:42:16', '::1'),
(685, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 14:42:18', '::1'),
(686, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 14:42:20', '::1'),
(687, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-15 14:42:21', '::1'),
(688, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-15 14:42:24', '::1'),
(689, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:42:26', '::1'),
(690, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:42:28', '::1'),
(691, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-15 14:42:32', '::1'),
(692, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-15 14:43:10', '::1'),
(693, 2, 'admin', 'shreye', '', 'forms/result-add', 'page_view', '', '2026-02-15 14:43:11', '::1'),
(694, 2, 'admin', 'shreye', '', 'show-details/show-result', 'page_view', '', '2026-02-15 14:43:13', '::1'),
(695, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 14:43:15', '::1'),
(696, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 14:43:17', '::1'),
(697, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 14:43:19', '::1'),
(698, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-15 14:43:21', '::1'),
(699, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-15 14:43:24', '::1'),
(700, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-15 14:43:26', '::1'),
(701, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-15 14:43:29', '::1'),
(702, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-15 14:43:48', '::1'),
(703, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-15 14:43:51', '::1'),
(704, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-15 14:44:01', '::1'),
(705, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 14:44:15', '::1'),
(706, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 14:44:26', '::1'),
(707, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 14:44:29', '::1'),
(708, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 14:44:38', '::1'),
(709, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 14:44:46', '::1'),
(710, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 14:44:48', '::1'),
(711, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-15 14:45:04', '::1'),
(712, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-15 14:45:05', '::1'),
(713, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 14:45:08', '::1'),
(714, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'navigation', 'Logout', '2026-02-15 14:45:55', '::1'),
(715, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 14:48:28', '::1'),
(716, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 14:48:55', '::1'),
(717, 1, 'teacher', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 14:48:57', '::1'),
(718, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:49:01', '::1'),
(719, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:49:27', '::1'),
(720, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 14:49:30', '::1'),
(721, 1, 'teacher', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-15 14:50:20', '::1'),
(722, 1, 'teacher', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 14:51:00', '::1'),
(723, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 14:51:00', '::1'),
(724, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-15 14:51:03', '::1'),
(725, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 14:51:03', '::1'),
(726, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-15 14:51:16', '::1'),
(727, 1, 'teacher', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 14:51:46', '::1'),
(728, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:51:49', '::1'),
(729, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 14:51:50', '::1'),
(730, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:51:50', '::1'),
(731, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 14:51:55', '::1'),
(732, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 14:57:39', '::1'),
(733, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 14:57:49', '::1'),
(734, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 14:57:51', '::1'),
(735, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 14:57:51', '::1'),
(736, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 14:57:54', '::1'),
(737, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 14:57:54', '::1'),
(738, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 14:57:58', '::1'),
(739, 1, 'teacher', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 14:58:00', '::1'),
(740, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 14:58:02', '::1'),
(741, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:00:52', '::1'),
(742, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:00:57', '::1'),
(743, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:00:59', '::1'),
(744, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:03', '::1'),
(745, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:03', '::1'),
(746, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:03', '::1'),
(747, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:03', '::1'),
(748, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:04', '::1'),
(749, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:04', '::1'),
(750, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:04', '::1'),
(751, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:01:04', '::1'),
(752, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:01:06', '::1'),
(753, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:01:08', '::1'),
(754, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:02:11', '::1'),
(755, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:02:15', '::1'),
(756, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:02:17', '::1'),
(757, 1, 'teacher', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 15:02:31', '::1'),
(758, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:02:36', '::1'),
(759, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:02:39', '::1'),
(760, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:02:43', '::1'),
(761, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:08:32', '::1'),
(762, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:08:34', '::1'),
(763, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:08:36', '::1'),
(764, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:08:36', '::1'),
(765, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:08:55', '::1'),
(766, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:08:55', '::1'),
(767, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:08:56', '::1'),
(768, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:08:58', '::1'),
(769, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:09:02', '::1'),
(770, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:13:11', '::1'),
(771, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:13:11', '::1'),
(772, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:13:12', '::1'),
(773, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:13:13', '::1'),
(774, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:13:18', '::1'),
(775, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:13:19', '::1'),
(776, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:15:03', '::1'),
(777, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:15:05', '::1'),
(778, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:15:08', '::1'),
(779, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:15:33', '::1'),
(780, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:15:34', '::1'),
(781, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:15:34', '::1'),
(782, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:16:00', '::1'),
(783, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:16:04', '::1'),
(784, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:16:23', '::1'),
(785, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:16:24', '::1'),
(786, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:16:26', '::1'),
(787, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:17:12', '::1'),
(788, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:17:13', '::1'),
(789, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:17:17', '::1'),
(790, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:17:41', '::1'),
(791, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:17:41', '::1'),
(792, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:17:41', '::1'),
(793, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:17:44', '::1'),
(794, 1, 'teacher', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-15 15:17:47', '::1'),
(795, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 15:18:23', '::1'),
(796, 1, 'teacher', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 15:18:32', '::1'),
(797, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:18:35', '::1'),
(798, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 15:18:37', '::1'),
(799, 1, 'teacher', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 15:20:45', '::1'),
(800, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:21:06', '::1'),
(801, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:21:09', '::1'),
(802, 1, 'teacher', '(Unknown)', '', 'show-details/show-result', 'page_view', '', '2026-02-15 15:21:10', '::1'),
(803, 1, 'teacher', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 15:21:17', '::1'),
(804, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:22:11', '::1'),
(805, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-15 15:23:44', '::1'),
(806, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'navigation', 'Logout', '2026-02-15 15:24:07', '::1'),
(807, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 15:24:18', '::1'),
(808, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 15:24:23', '::1'),
(809, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-15 15:24:27', '::1'),
(810, 2, 'admin', 'shreye', '', 'forms/show_exams', 'navigation', 'Logout', '2026-02-15 15:24:48', '::1'),
(811, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:25:03', '::1'),
(812, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:25:09', '::1'),
(813, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 15:25:11', '::1'),
(814, 1, 'teacher', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-15 15:25:12', '::1'),
(815, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 15:25:13', '::1'),
(816, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:25:15', '::1'),
(817, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:27:56', '::1'),
(818, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:27:58', '::1'),
(819, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:28:01', '::1'),
(820, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 15:28:14', '::1'),
(821, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:28:23', '::1'),
(822, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:30:54', '::1'),
(823, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:31:02', '::1'),
(824, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:31:04', '::1'),
(825, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:31:13', '::1'),
(826, 1, 'teacher', '(Unknown)', '', 'show-details/show-result', 'page_view', '', '2026-02-15 15:31:20', '::1'),
(827, 1, 'teacher', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-15 15:31:23', '::1'),
(828, 1, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-15 15:31:37', '::1'),
(829, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:31:39', '::1'),
(830, 1, 'teacher', '(Unknown)', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-15 15:31:57', '::1'),
(831, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-15 15:31:59', '::1'),
(832, 1, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-15 15:32:02', '::1'),
(833, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-15 15:32:18', '::1'),
(834, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:34:10', '::1'),
(835, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:34:11', '::1'),
(836, 1, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-15 15:34:13', '::1'),
(837, 1, 'teacher', '(Unknown)', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-15 15:34:17', '::1'),
(838, 1, 'teacher', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 15:34:19', '::1'),
(839, 1, 'teacher', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 15:34:21', '::1'),
(840, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:34:23', '::1'),
(841, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:34:26', '::1'),
(842, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:34:27', '::1'),
(843, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:35:31', '::1'),
(844, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:35:33', '::1'),
(845, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:35:36', '::1'),
(846, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:35:45', '::1'),
(847, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:35:46', '::1'),
(848, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 15:38:38', '::1'),
(849, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-15 15:38:44', '::1'),
(850, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:38:48', '::1'),
(851, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:38:49', '::1'),
(852, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:38:59', '::1'),
(853, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:39:57', '::1'),
(854, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:40:16', '::1'),
(855, 1, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:40:53', '::1'),
(856, 1, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-15 15:40:59', '::1'),
(857, 1, 'teacher', '(Unknown)', '', 'forms/paper-time-table', 'page_view', '', '2026-02-15 15:41:08', '::1'),
(858, 0, 'unknown', '(Unknown)', '', 'forms/paper-time-table', 'navigation', 'Logout', '2026-02-15 15:41:23', '::1'),
(859, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 15:41:38', '::1'),
(860, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'View all notifications', '2026-02-15 15:41:42', '::1'),
(861, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 15:41:49', '::1');
INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `full_name`, `batch`, `page_url`, `action_type`, `element_text`, `timestamp`, `ip_address`) VALUES
(862, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-15 15:41:53', '::1'),
(863, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-15 15:46:21', '::1'),
(864, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-15 15:46:32', '::1'),
(865, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:46:45', '::1'),
(866, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'navigation', 'Logout', '2026-02-15 15:46:51', '::1'),
(867, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 15:47:34', '::1'),
(868, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 15:47:36', '::1'),
(869, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 15:47:43', '::1'),
(870, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 15:48:27', '::1'),
(871, 2, 'admin', 'shreye', '', 'forms/parent-add', 'navigation', 'Logout', '2026-02-15 15:50:18', '::1'),
(872, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 15:50:43', '::1'),
(873, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 15:50:49', '::1'),
(874, 19, 'parent', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-15 15:50:56', '::1'),
(875, 19, 'parent', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:50:58', '::1'),
(876, 19, 'parent', '(Unknown)', '', 'show-details/show-result', 'page_view', '', '2026-02-15 15:51:00', '::1'),
(877, 19, 'parent', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-15 15:51:01', '::1'),
(878, 19, 'parent', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-15 15:51:03', '::1'),
(879, 19, 'parent', '(Unknown)', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-15 15:51:06', '::1'),
(880, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 15:51:07', '::1'),
(881, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'navigation', 'Logout', '2026-02-15 15:51:11', '::1'),
(882, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 15:51:18', '::1'),
(883, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 15:51:19', '::1'),
(884, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 15:51:22', '::1'),
(885, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 15:51:51', '::1'),
(886, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 15:52:23', '::1'),
(887, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 15:52:29', '::1'),
(888, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 15:52:31', '::1'),
(889, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 15:52:57', '::1'),
(890, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 15:55:11', '::1'),
(891, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 15:55:31', '::1'),
(892, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 15:59:28', '::1'),
(893, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 15:59:30', '::1'),
(894, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 15:59:32', '::1'),
(895, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 15:59:53', '::1'),
(896, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:07', '::1'),
(897, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 16:00:20', '::1'),
(898, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 16:00:22', '::1'),
(899, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'click', '', '2026-02-15 16:00:28', '::1'),
(900, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'navigation', 'Logout', '2026-02-15 16:00:29', '::1'),
(901, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:40', '::1'),
(902, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:43', '::1'),
(903, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:43', '::1'),
(904, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:43', '::1'),
(905, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:44', '::1'),
(906, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:44', '::1'),
(907, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:44', '::1'),
(908, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:44', '::1'),
(909, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:44', '::1'),
(910, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:44', '::1'),
(911, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:45', '::1'),
(912, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:45', '::1'),
(913, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:45', '::1'),
(914, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:45', '::1'),
(915, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:45', '::1'),
(916, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:45', '::1'),
(917, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(918, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(919, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(920, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(921, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(922, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(923, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:00:46', '::1'),
(924, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:00:49', '::1'),
(925, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:00:57', '::1'),
(926, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Mark all read', '2026-02-15 16:19:29', '::1'),
(927, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:19:32', '::1'),
(928, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:19:36', '::1'),
(929, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-15 16:19:38', '::1'),
(930, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:19:47', '::1'),
(931, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 16:19:49', '::1'),
(932, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 16:19:52', '::1'),
(933, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'navigation', 'Logout', '2026-02-15 16:20:01', '::1'),
(934, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:20:09', '::1'),
(935, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 16:20:10', '::1'),
(936, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:20:14', '::1'),
(937, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 16:20:57', '::1'),
(938, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:21:12', '::1'),
(939, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Mark all read', '2026-02-15 16:21:15', '::1'),
(940, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:21:16', '::1'),
(941, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:21:43', '::1'),
(942, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:22:50', '::1'),
(943, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:22:59', '::1'),
(944, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 16:23:02', '::1'),
(945, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:23:11', '::1'),
(946, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 16:23:35', '::1'),
(947, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:23:43', '::1'),
(948, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Mark all read', '2026-02-15 16:23:46', '::1'),
(949, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:23:47', '::1'),
(950, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:29:30', '::1'),
(951, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:29:33', '::1'),
(952, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:29:48', '::1'),
(953, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 16:29:50', '::1'),
(954, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:29:57', '::1'),
(955, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 16:30:18', '::1'),
(956, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:30:27', '::1'),
(957, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Mark all read', '2026-02-15 16:30:30', '::1'),
(958, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:30:32', '::1'),
(959, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:30:37', '::1'),
(960, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 16:30:40', '::1'),
(961, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '×', '2026-02-15 16:31:08', '::1'),
(962, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:35:23', '::1'),
(963, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:35:26', '::1'),
(964, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:35:37', '::1'),
(965, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 16:36:02', '::1'),
(966, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:36:05', '::1'),
(967, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-15 16:36:08', '::1'),
(968, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:36:19', '::1'),
(969, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 16:36:37', '::1'),
(970, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:36:55', '::1'),
(971, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 16:37:01', '::1'),
(972, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-15 16:37:03', '::1'),
(973, 19, 'parent', '(Unknown)', '', 'show-details/show-meets', 'navigation', 'Logout', '2026-02-15 16:37:11', '::1'),
(974, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 16:37:18', '::1'),
(975, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:37:22', '::1'),
(976, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 16:37:25', '::1'),
(977, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 16:42:38', '::1'),
(978, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:42:48', '::1'),
(979, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-15 16:42:51', '::1'),
(980, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:42:57', '::1'),
(981, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:43:08', '::1'),
(982, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 16:43:16', '::1'),
(983, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:43:18', '::1'),
(984, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 16:43:41', '::1'),
(985, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:43:50', '::1'),
(986, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 16:43:54', '::1'),
(987, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:44:05', '::1'),
(988, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:50:10', '::1'),
(989, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:50:14', '::1'),
(990, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:50:32', '::1'),
(991, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 16:50:38', '::1'),
(992, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 16:50:43', '::1'),
(993, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 16:52:41', '::1'),
(994, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:52:52', '::1'),
(995, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:53:24', '::1'),
(996, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:53:28', '::1'),
(997, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 16:53:47', '::1'),
(998, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 16:53:52', '::1'),
(999, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 16:54:10', '::1'),
(1000, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 17:04:51', '::1'),
(1001, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-15 17:04:58', '::1'),
(1002, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 17:05:06', '::1'),
(1003, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 17:05:08', '::1'),
(1004, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 17:05:11', '::1'),
(1005, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 17:05:30', '::1'),
(1006, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 17:05:41', '::1'),
(1007, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 17:11:50', '::1'),
(1008, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 17:12:34', '::1'),
(1009, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 17:12:43', '::1'),
(1010, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 17:12:45', '::1'),
(1011, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 17:12:53', '::1'),
(1012, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'navigation', 'Logout', '2026-02-15 17:13:13', '::1'),
(1013, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 17:13:33', '::1'),
(1014, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 17:13:38', '::1'),
(1015, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 17:13:43', '::1'),
(1016, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 17:13:45', '::1'),
(1017, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'click', '', '2026-02-15 17:13:53', '::1'),
(1018, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 17:47:10', '::1'),
(1019, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'View all notifications', '2026-02-15 17:47:19', '::1'),
(1020, 19, 'parent', '(Unknown)', '', '/final-year-pro/dashboard/parent-dashboard.php', 'page_view', '', '2026-02-15 17:47:22', '::1'),
(1021, 19, 'parent', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/parent-dashboard.php', 'navigation', 'Logout', '2026-02-15 17:47:25', '::1'),
(1022, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 18:02:36', '::1'),
(1023, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 18:02:41', '::1'),
(1024, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 18:02:50', '::1'),
(1025, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 18:04:41', '::1'),
(1026, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-15 18:51:08', '::1'),
(1027, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-15 18:51:11', '::1'),
(1028, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-15 18:51:26', '::1'),
(1029, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-15 18:51:31', '::1'),
(1030, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-15 18:52:20', '::1'),
(1031, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 15:55:29', '::1'),
(1032, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-17 15:55:35', '::1'),
(1033, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:00:31', '::1'),
(1034, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', 'Register Face', '2026-02-17 16:00:44', '::1'),
(1035, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', 'Register Face', '2026-02-17 16:02:07', '::1'),
(1036, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', 'Register Face', '2026-02-17 16:02:07', '::1'),
(1037, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:02:07', '::1'),
(1038, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:02:54', '::1'),
(1039, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:02:57', '::1'),
(1040, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-17 16:03:46', '::1'),
(1041, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 16:03:54', '::1'),
(1042, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 16:04:02', '::1'),
(1043, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 16:04:08', '::1'),
(1044, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 16:10:38', '::1'),
(1045, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 16:10:40', '::1'),
(1046, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 16:10:42', '::1'),
(1047, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 16:10:43', '::1'),
(1048, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-17 16:11:31', '::1'),
(1049, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 16:12:34', '::1'),
(1050, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 16:12:41', '::1'),
(1051, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 16:12:43', '::1'),
(1052, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 16:12:45', '::1'),
(1053, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-17 16:12:50', '::1'),
(1054, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 16:13:41', '::1'),
(1055, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-17 16:15:49', '::1'),
(1056, 2, 'admin', 'shreye', '', 'forms/student-add', 'navigation', 'Logout', '2026-02-17 16:16:08', '::1'),
(1057, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:16:20', '::1'),
(1058, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:16:24', '::1'),
(1059, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:16:27', '::1'),
(1060, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:17:28', '::1'),
(1061, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:17:30', '::1'),
(1062, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:17:32', '::1'),
(1063, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-17 16:17:40', '::1'),
(1064, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:18:15', '::1'),
(1065, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:18:18', '::1'),
(1066, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:18:19', '::1'),
(1067, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-17 16:18:39', '::1'),
(1068, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 16:18:43', '::1'),
(1069, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 16:18:45', '::1'),
(1070, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 16:18:49', '::1'),
(1071, 2, 'admin', 'shreye', '', 'show-details/show-student', 'navigation', 'Logout', '2026-02-17 16:19:09', '::1'),
(1072, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:19:22', '::1'),
(1073, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:19:26', '::1'),
(1074, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:19:29', '::1'),
(1075, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:20:50', '::1'),
(1076, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'navigation', 'Logout', '2026-02-17 16:22:06', '::1'),
(1077, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 16:28:48', '::1'),
(1078, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 16:28:50', '::1'),
(1079, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-17 16:28:52', '::1'),
(1080, 0, 'unknown', '(Unknown)', '', 'show-details/show-attendance', 'navigation', 'Logout', '2026-02-17 16:29:05', '::1'),
(1081, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:29:31', '::1'),
(1082, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:29:33', '::1'),
(1083, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:29:35', '::1'),
(1084, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-17 16:30:39', '::1'),
(1085, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 16:30:52', '::1'),
(1086, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 16:30:54', '::1'),
(1087, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-17 16:30:56', '::1'),
(1088, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'navigation', 'Logout', '2026-02-17 16:31:12', '::1'),
(1089, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:31:23', '::1'),
(1090, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:31:25', '::1'),
(1091, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:32:09', '::1'),
(1092, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-17 16:41:45', '::1'),
(1093, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 16:42:14', '::1'),
(1094, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 16:42:17', '::1'),
(1095, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:42:19', '::1'),
(1096, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 16:52:59', '::1'),
(1097, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'click', '', '2026-02-17 16:53:03', '::1'),
(1098, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/view_attendance', 'page_view', '', '2026-02-17 16:53:04', '::1'),
(1099, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/view_attendance', 'click', '', '2026-02-17 16:53:48', '::1'),
(1100, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-17 16:53:50', '::1'),
(1101, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-std-fee', 'click', '', '2026-02-17 16:53:57', '::1'),
(1102, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-17 16:53:59', '::1'),
(1103, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-study-mat', 'click', '', '2026-02-17 16:54:24', '::1'),
(1104, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-timetd', 'page_view', '', '2026-02-17 17:00:23', '::1'),
(1105, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-17 17:00:29', '::1'),
(1106, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-17 17:00:31', '::1'),
(1107, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-result', 'page_view', '', '2026-02-17 17:00:32', '::1'),
(1108, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/view_attendance', 'page_view', '', '2026-02-17 17:00:38', '::1'),
(1109, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-17 17:00:44', '::1'),
(1110, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-17 17:00:47', '::1'),
(1111, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/student_take_exam', 'page_view', '', '2026-02-17 17:00:50', '::1'),
(1112, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/show_exams', 'page_view', '', '2026-02-17 17:00:52', '::1'),
(1113, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-17 17:00:56', '::1'),
(1114, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-meets', 'page_view', '', '2026-02-17 17:00:58', '::1'),
(1115, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 17:02:03', '::1'),
(1116, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 17:02:03', '::1'),
(1117, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 17:02:05', '::1'),
(1118, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-17 17:02:07', '::1'),
(1119, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-study-mat', 'navigation', 'Logout', '2026-02-17 17:02:11', '::1'),
(1120, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 17:02:18', '::1'),
(1121, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 17:02:21', '::1'),
(1122, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-17 17:02:23', '::1'),
(1123, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'navigation', 'Logout', '2026-02-17 17:02:31', '::1'),
(1124, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 17:02:45', '::1'),
(1125, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 17:02:46', '::1'),
(1126, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 17:02:48', '::1'),
(1127, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/view_attendance', 'page_view', '', '2026-02-17 17:03:32', '::1'),
(1128, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-timetd', 'page_view', '', '2026-02-17 17:03:41', '::1'),
(1129, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-17 17:03:42', '::1'),
(1130, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-17 17:03:43', '::1'),
(1131, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-result', 'page_view', '', '2026-02-17 17:03:44', '::1'),
(1132, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-result', 'page_view', '', '2026-02-17 17:03:44', '::1'),
(1133, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-17 17:03:46', '::1'),
(1134, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/view_attendance', 'page_view', '', '2026-02-17 17:03:46', '::1'),
(1135, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-17 17:03:48', '::1'),
(1136, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/student_take_exam', 'page_view', '', '2026-02-17 17:03:50', '::1'),
(1137, 4, 'student', 'Abhishek Suhas Pathak', '', 'forms/show_exams', 'page_view', '', '2026-02-17 17:03:52', '::1'),
(1138, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-17 17:03:54', '::1'),
(1139, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-17 17:03:57', '::1'),
(1140, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 17:11:40', '::1'),
(1141, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 17:11:43', '::1'),
(1142, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-17 17:11:46', '::1'),
(1143, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-17 17:12:34', '::1'),
(1144, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-result', 'page_view', '', '2026-02-17 17:12:35', '::1'),
(1145, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-17 17:12:35', '::1'),
(1146, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-17 17:12:45', '::1'),
(1147, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-result', 'page_view', '', '2026-02-17 17:12:47', '::1'),
(1148, 4, 'student', 'Abhishek Suhas Pathak', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-17 17:18:03', '::1'),
(1149, 4, 'student', 'Abhishek Suhas Pathak', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-17 17:18:04', '::1'),
(1150, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-17 17:18:07', '::1'),
(1151, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-17 17:18:15', '::1'),
(1152, 4, 'student', 'Abhishek Suhas Pathak', '', 'show-details/show-result', 'page_view', '', '2026-02-17 17:18:16', '::1'),
(1153, 0, 'unknown', '(Unknown)', '', 'show-details/show-result', 'navigation', 'Logout', '2026-02-17 17:18:25', '::1'),
(1154, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 17:18:37', '::1'),
(1155, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 17:18:39', '::1'),
(1156, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 17:18:41', '::1'),
(1157, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 17:18:45', '::1'),
(1158, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-17 17:18:46', '::1'),
(1159, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-17 17:19:04', '::1'),
(1160, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 17:19:07', '::1'),
(1161, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 17:20:30', '::1'),
(1162, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'navigation', 'Logout', '2026-02-17 17:53:30', '::1'),
(1163, 1, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-17 18:16:51', '::1'),
(1164, 1, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-17 18:17:01', '::1'),
(1165, 0, 'unknown', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'Logout', '2026-02-17 18:17:39', '::1'),
(1166, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:18:18', '::1'),
(1167, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:18:20', '::1'),
(1168, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 18:18:24', '::1'),
(1169, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 18:19:56', '::1'),
(1170, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:25:21', '::1'),
(1171, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:25:21', '::1'),
(1172, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:25:24', '::1'),
(1173, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 18:25:27', '::1'),
(1174, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 18:25:57', '::1'),
(1175, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:34:19', '::1'),
(1176, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:34:21', '::1'),
(1177, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-17 18:34:27', '::1'),
(1178, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:34:30', '::1'),
(1179, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 18:37:20', '::1'),
(1180, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:37:29', '::1'),
(1181, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:37:32', '::1'),
(1182, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:37:37', '::1'),
(1183, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:37:39', '::1'),
(1184, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 18:38:16', '::1'),
(1185, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:38:39', '::1'),
(1186, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:39:14', '::1'),
(1187, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 18:39:18', '::1'),
(1188, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:39:35', '::1'),
(1189, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:39:36', '::1'),
(1190, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:39:43', '::1'),
(1191, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:39:46', '::1'),
(1192, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 18:40:31', '::1'),
(1193, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:44:26', '::1'),
(1194, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:44:26', '::1'),
(1195, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:44:27', '::1'),
(1196, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:44:27', '::1'),
(1197, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:44:29', '::1'),
(1198, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:44:31', '::1'),
(1199, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 18:44:55', '::1'),
(1200, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:45:32', '::1'),
(1201, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:45:33', '::1'),
(1202, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:45:33', '::1'),
(1203, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:45:33', '::1'),
(1204, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:45:47', '::1'),
(1205, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:45:50', '::1'),
(1206, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 18:47:03', '::1'),
(1207, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:50:39', '::1'),
(1208, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:50:41', '::1'),
(1209, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 18:50:44', '::1'),
(1210, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 18:50:45', '::1'),
(1211, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 18:51:14', '::1'),
(1212, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 18:51:18', '::1'),
(1213, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 18:51:20', '::1'),
(1214, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 18:51:24', '::1'),
(1215, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 18:51:56', '::1'),
(1216, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:52:01', '::1'),
(1217, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 18:52:01', '::1'),
(1218, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 18:52:03', '::1'),
(1219, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 18:52:06', '::1'),
(1220, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 18:52:35', '::1'),
(1221, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-17 18:55:40', '::1'),
(1222, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:13:30', '::1'),
(1223, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 19:13:32', '::1'),
(1224, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-17 19:13:36', '::1'),
(1225, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:13:43', '::1'),
(1226, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:13:43', '::1'),
(1227, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:13:43', '::1'),
(1228, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:13:43', '::1'),
(1229, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 19:13:59', '::1'),
(1230, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-17 19:14:02', '::1'),
(1231, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 19:14:40', '::1'),
(1232, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 19:14:43', '::1'),
(1233, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 19:14:52', '::1'),
(1234, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:32:50', '::1'),
(1235, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:32:52', '::1'),
(1236, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-17 19:33:07', '::1'),
(1237, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-17 19:34:24', '::1'),
(1238, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-17 19:34:28', '::1'),
(1239, 2, 'admin', 'shreye', '', 'dashboard/admin_logs', 'page_view', '', '2026-02-17 19:34:31', '::1'),
(1240, 0, 'admin', 'shreye', NULL, NULL, 'Exported CSV Logs', NULL, '2026-02-17 19:35:33', NULL),
(1241, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-17 19:36:43', '::1'),
(1242, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-17 19:36:44', '::1'),
(1243, 30, 'student', 'Riya Patil', '', '/Final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-19 20:16:14', '192.168.1.101'),
(1244, 30, 'student', 'Riya Patil', '', 'http://192.168.1.118:8080/Final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-19 20:16:28', '192.168.1.101'),
(1245, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-19 20:16:32', '192.168.1.101'),
(1246, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-19 20:16:40', '192.168.1.101'),
(1247, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-19 20:16:49', '192.168.1.101'),
(1248, 30, 'student', 'Riya Patil', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-19 20:17:30', '192.168.1.101'),
(1249, 30, 'student', 'Riya Patil', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-19 20:17:31', '192.168.1.101'),
(1250, 30, 'student', 'Riya Patil', '', 'show-details/show-result', 'page_view', '', '2026-02-19 20:17:32', '192.168.1.101'),
(1251, 30, 'student', 'Riya Patil', '', 'show-details/show-result', 'click', '', '2026-02-19 20:17:36', '192.168.1.101');
INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `full_name`, `batch`, `page_url`, `action_type`, `element_text`, `timestamp`, `ip_address`) VALUES
(1252, 30, 'student', 'Riya Patil', '', 'show-details/show-result', 'click', '', '2026-02-19 20:17:37', '192.168.1.101'),
(1253, 30, 'student', 'Riya Patil', '', 'show-details/show-result', 'navigation', 'Logout', '2026-02-19 20:17:41', '192.168.1.101'),
(1254, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 15:33:19', '::1'),
(1255, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 15:33:22', '::1'),
(1256, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-21 15:33:24', '::1'),
(1257, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-21 15:33:27', '::1'),
(1258, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 15:39:56', '::1'),
(1259, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 15:39:58', '::1'),
(1260, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-21 15:40:00', '::1'),
(1261, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 15:55:42', '::1'),
(1262, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 15:55:44', '::1'),
(1263, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-21 15:56:12', '::1'),
(1264, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'navigation', 'Logout', '2026-02-21 15:57:06', '::1'),
(1265, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:14:31', '::1'),
(1266, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:14:36', '::1'),
(1267, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-21 16:16:28', '::1'),
(1268, 0, 'unknown', '(Unknown)', '', 'show-details/show-attendance', 'navigation', 'Logout', '2026-02-21 16:22:14', '::1'),
(1269, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:26:20', '::1'),
(1270, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:26:21', '::1'),
(1271, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:32:20', '::1'),
(1272, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:32:23', '::1'),
(1273, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:32:26', '::1'),
(1274, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:35:42', '::1'),
(1275, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:35:44', '::1'),
(1276, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:35:46', '::1'),
(1277, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:37:38', '::1'),
(1278, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:37:40', '::1'),
(1279, 2, 'admin', 'shreye', '', 'forms/demo_kiosk', 'page_view', '', '2026-02-21 16:37:47', '::1'),
(1280, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:37:50', '::1'),
(1281, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:38:48', '::1'),
(1282, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:38:51', '::1'),
(1283, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:38:55', '::1'),
(1284, 2, 'admin', 'shreye', '', 'forms/demo_kiosk', 'page_view', '', '2026-02-21 16:39:25', '::1'),
(1285, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:39:30', '::1'),
(1286, 2, 'admin', 'shreye', '', 'forms/demo_kiosk', 'page_view', '', '2026-02-21 16:39:33', '::1'),
(1287, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:39:50', '::1'),
(1288, 2, 'admin', 'shreye', '', 'forms/demo_kiosk', 'page_view', '', '2026-02-21 16:45:18', '::1'),
(1289, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:45:19', '::1'),
(1290, 2, 'admin', 'shreye', '', 'forms/demo_kiosk', 'page_view', '', '2026-02-21 16:45:36', '::1'),
(1291, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:45:37', '::1'),
(1292, 2, 'admin', 'shreye', '', 'forms/demo_kiosk', 'page_view', '', '2026-02-21 16:45:38', '::1'),
(1293, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:51:11', '::1'),
(1294, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:51:17', '::1'),
(1295, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 16:51:20', '::1'),
(1296, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'navigation', 'Logout', '2026-02-21 16:55:21', '::1'),
(1297, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-21 16:56:40', '::1'),
(1298, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-21 16:56:43', '::1'),
(1299, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 16:56:46', '::1'),
(1300, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-21 16:56:55', '::1'),
(1301, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'navigation', 'Logout', '2026-02-21 16:57:12', '::1'),
(1302, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 16:57:19', '::1'),
(1303, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 16:57:20', '::1'),
(1304, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 16:57:23', '::1'),
(1305, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 17:05:14', '::1'),
(1306, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 17:06:03', '::1'),
(1307, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 17:06:06', '::1'),
(1308, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 17:06:23', '::1'),
(1309, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 17:11:37', '::1'),
(1310, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 17:11:39', '::1'),
(1311, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 17:11:43', '::1'),
(1312, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 17:11:53', '::1'),
(1313, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 17:13:33', '::1'),
(1314, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 17:14:00', '::1'),
(1315, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 17:15:47', '::1'),
(1316, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 17:15:50', '::1'),
(1317, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 17:15:54', '::1'),
(1318, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 17:15:58', '::1'),
(1319, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 17:19:14', '::1'),
(1320, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 17:19:16', '::1'),
(1321, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 17:19:20', '::1'),
(1322, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 17:19:22', '::1'),
(1323, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 17:20:01', '::1'),
(1324, 30, 'student', 'Riya Patil', '', '/Final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-21 17:21:33', '192.168.1.101'),
(1325, 30, 'student', 'Riya Patil', '', 'http://192.168.1.106:8080/Final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-21 17:21:37', '192.168.1.101'),
(1326, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 17:21:38', '192.168.1.101'),
(1327, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'View all notifications', '2026-02-21 17:29:35', '192.168.1.101'),
(1328, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Mark all read', '2026-02-21 17:29:36', '192.168.1.101'),
(1329, 30, 'student', 'Riya Patil', '', '/Final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-21 17:29:46', '192.168.1.101'),
(1330, 30, 'student', 'Riya Patil', '', 'http://192.168.1.106:8080/Final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-21 17:29:47', '192.168.1.101'),
(1331, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 17:29:49', '192.168.1.101'),
(1332, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-21 17:29:51', '192.168.1.101'),
(1333, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 17:31:00', '192.168.1.101'),
(1334, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 17:36:43', '::1'),
(1335, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 17:36:46', '::1'),
(1336, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 17:36:49', '::1'),
(1337, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 20:24:00', '::1'),
(1338, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 20:24:09', '::1'),
(1339, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-21 20:24:11', '::1'),
(1340, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-21 22:14:34', '::1'),
(1341, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-21 22:14:39', '::1'),
(1342, 30, 'student', 'Riya Patil', '', 'show-details/show-timetd', 'page_view', '', '2026-02-21 22:14:41', '::1'),
(1343, 30, 'student', 'Riya Patil', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-21 22:14:42', '::1'),
(1344, 30, 'student', 'Riya Patil', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-21 22:14:43', '::1'),
(1345, 30, 'student', 'Riya Patil', '', 'show-details/show-result', 'page_view', '', '2026-02-21 22:14:43', '::1'),
(1346, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 22:14:45', '::1'),
(1347, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-21 22:14:47', '::1'),
(1348, 30, 'student', 'Riya Patil', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-21 22:14:49', '::1'),
(1349, 30, 'student', 'Riya Patil', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-21 22:14:50', '::1'),
(1350, 30, 'student', 'Riya Patil', '', 'forms/student_take_exam', 'page_view', '', '2026-02-21 22:14:52', '::1'),
(1351, 30, 'student', 'Riya Patil', '', 'forms/show_exams', 'page_view', '', '2026-02-21 22:14:53', '::1'),
(1352, 30, 'student', 'Riya Patil', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-21 22:14:55', '::1'),
(1353, 30, 'student', 'Riya Patil', '', 'show-details/show-meets', 'page_view', '', '2026-02-21 22:14:58', '::1'),
(1354, 30, 'student', 'Riya Patil', '', 'show-details/show-meets', 'navigation', 'Logout', '2026-02-21 22:15:00', '::1'),
(1355, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 22:15:09', '::1'),
(1356, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 22:15:11', '::1'),
(1357, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-21 22:15:12', '::1'),
(1358, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-21 22:15:12', '::1'),
(1359, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-21 22:15:13', '::1'),
(1360, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-21 22:15:14', '::1'),
(1361, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-21 22:15:15', '::1'),
(1362, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-21 22:15:16', '::1'),
(1363, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-21 22:15:18', '::1'),
(1364, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-21 22:15:18', '::1'),
(1365, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-21 22:15:18', '::1'),
(1366, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-21 22:15:23', '::1'),
(1367, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-21 22:15:25', '::1'),
(1368, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-21 22:15:25', '::1'),
(1369, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-21 22:15:27', '::1'),
(1370, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-21 22:15:28', '::1'),
(1371, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-21 22:15:33', '::1'),
(1372, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-21 22:15:34', '::1'),
(1373, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-21 22:15:39', '::1'),
(1374, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 22:15:39', '::1'),
(1375, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'navigation', 'Logout', '2026-02-21 22:17:56', '::1'),
(1376, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 23:01:47', '::1'),
(1377, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 23:01:50', '::1'),
(1378, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 23:36:22', '::1'),
(1379, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 23:36:24', '::1'),
(1380, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-21 23:36:27', '::1'),
(1381, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-21 23:36:34', '::1'),
(1382, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-21 23:36:36', '::1'),
(1383, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 23:36:38', '::1'),
(1384, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-21 23:36:43', '::1'),
(1385, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 23:36:49', '::1'),
(1386, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 23:36:50', '::1'),
(1387, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 23:36:54', '::1'),
(1388, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 23:37:10', '::1'),
(1389, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-21 23:37:12', '::1'),
(1390, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-21 23:37:19', '::1'),
(1391, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-21 23:37:20', '::1'),
(1392, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-21 23:37:23', '::1'),
(1393, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'navigation', 'Logout', '2026-02-21 23:37:26', '::1'),
(1394, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-21 23:37:33', '::1'),
(1395, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-21 23:37:35', '::1'),
(1396, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-21 23:37:39', '::1'),
(1397, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:12:12', '::1'),
(1398, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:12:16', '::1'),
(1399, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:12:18', '::1'),
(1400, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 11:12:21', '::1'),
(1401, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 11:12:22', '::1'),
(1402, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 11:12:25', '::1'),
(1403, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 11:12:25', '::1'),
(1404, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-22 11:12:27', '::1'),
(1405, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 11:12:38', '::1'),
(1406, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 11:12:40', '::1'),
(1407, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-22 11:12:42', '::1'),
(1408, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:12:45', '::1'),
(1409, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:12:47', '::1'),
(1410, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-22 11:12:52', '::1'),
(1411, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 11:13:19', '::1'),
(1412, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 11:13:20', '::1'),
(1413, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:15:40', '::1'),
(1414, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:15:43', '::1'),
(1415, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 11:15:47', '::1'),
(1416, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 11:15:48', '::1'),
(1417, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:16:10', '::1'),
(1418, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:16:25', '::1'),
(1419, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:16:27', '::1'),
(1420, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 11:16:29', '::1'),
(1421, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 11:16:30', '::1'),
(1422, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-22 11:16:34', '::1'),
(1423, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-22 11:16:34', '::1'),
(1424, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-22 11:16:35', '::1'),
(1425, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-22 11:16:39', '::1'),
(1426, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 11:16:43', '::1'),
(1427, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 11:16:43', '::1'),
(1428, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 11:16:44', '::1'),
(1429, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 11:16:45', '::1'),
(1430, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-22 11:16:46', '::1'),
(1431, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-22 11:16:47', '::1'),
(1432, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-22 11:16:48', '::1'),
(1433, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:17:57', '::1'),
(1434, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:17:59', '::1'),
(1435, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 11:18:01', '::1'),
(1436, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 11:18:08', '::1'),
(1437, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-22 11:18:08', '::1'),
(1438, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-22 11:18:09', '::1'),
(1439, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-22 11:18:15', '::1'),
(1440, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-22 11:18:16', '::1'),
(1441, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-22 11:18:19', '::1'),
(1442, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-22 11:18:20', '::1'),
(1443, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-22 11:18:21', '::1'),
(1444, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-22 11:18:22', '::1'),
(1445, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-22 11:18:22', '::1'),
(1446, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-22 11:18:26', '::1'),
(1447, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 11:18:26', '::1'),
(1448, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 11:18:29', '::1'),
(1449, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 11:18:30', '::1'),
(1450, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 11:18:31', '::1'),
(1451, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 11:18:34', '::1'),
(1452, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-22 11:18:35', '::1'),
(1453, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 11:18:35', '::1'),
(1454, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-22 11:18:36', '::1'),
(1455, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 11:18:37', '::1'),
(1456, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:21:05', '::1'),
(1457, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:21:07', '::1'),
(1458, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 11:21:09', '::1'),
(1459, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-22 11:21:13', '::1'),
(1460, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-22 11:21:23', '::1'),
(1461, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-22 11:21:24', '::1'),
(1462, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-22 11:21:27', '::1'),
(1463, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-22 11:21:27', '::1'),
(1464, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-22 11:21:32', '::1'),
(1465, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-22 11:21:34', '::1'),
(1466, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-22 11:21:36', '::1'),
(1467, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 11:21:37', '::1'),
(1468, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 11:21:39', '::1'),
(1469, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 11:21:39', '::1'),
(1470, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 11:21:42', '::1'),
(1471, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 11:21:45', '::1'),
(1472, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-22 11:21:46', '::1'),
(1473, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 11:21:55', '::1'),
(1474, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-22 11:21:56', '::1'),
(1475, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 11:21:58', '::1'),
(1476, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 11:22:01', '::1'),
(1477, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-22 11:22:06', '::1'),
(1478, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-22 11:22:09', '::1'),
(1479, 2, 'admin', 'shreye', '', 'forms/result-add', 'page_view', '', '2026-02-22 11:22:12', '::1'),
(1480, 2, 'admin', 'shreye', '', 'show-details/show-result', 'page_view', '', '2026-02-22 11:22:14', '::1'),
(1481, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-22 11:22:18', '::1'),
(1482, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-22 11:22:19', '::1'),
(1483, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-22 11:22:21', '::1'),
(1484, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-22 11:22:22', '::1'),
(1485, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-22 11:22:23', '::1'),
(1486, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-22 11:22:24', '::1'),
(1487, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-22 11:22:26', '::1'),
(1488, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-22 11:22:27', '::1'),
(1489, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-22 11:22:29', '::1'),
(1490, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-22 11:22:30', '::1'),
(1491, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-22 11:22:30', '::1'),
(1492, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 11:22:33', '::1'),
(1493, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 11:22:33', '::1'),
(1494, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 11:22:35', '::1'),
(1495, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 11:22:36', '::1'),
(1496, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 11:22:39', '::1'),
(1497, 2, 'admin', 'shreye', '', 'forms/share_kiosk', 'page_view', '', '2026-02-22 11:22:40', '::1'),
(1498, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:24:49', '::1'),
(1499, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:24:51', '::1'),
(1500, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-22 11:24:52', '::1'),
(1501, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-22 11:24:54', '::1'),
(1502, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-22 11:24:54', '::1'),
(1503, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 11:24:56', '::1'),
(1504, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 11:24:57', '::1'),
(1505, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 11:24:59', '::1'),
(1506, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 11:24:59', '::1'),
(1507, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 11:25:00', '::1'),
(1508, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 11:25:02', '::1'),
(1509, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'page_view', '', '2026-02-22 11:25:03', '::1'),
(1510, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 11:29:34', '::1'),
(1511, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 11:29:37', '::1'),
(1512, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-22 11:29:38', '::1'),
(1513, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-22 11:29:39', '::1'),
(1514, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-22 11:29:41', '::1'),
(1515, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-22 11:29:43', '::1'),
(1516, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-22 11:29:44', '::1'),
(1517, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-22 11:29:44', '::1'),
(1518, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 11:29:46', '::1'),
(1519, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 11:29:47', '::1'),
(1520, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 11:29:49', '::1'),
(1521, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 11:29:49', '::1'),
(1522, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 11:29:54', '::1'),
(1523, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'page_view', '', '2026-02-22 11:29:55', '::1'),
(1524, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-22 11:29:58', '::1'),
(1525, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'page_view', '', '2026-02-22 12:23:10', '::1'),
(1526, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 12:23:10', '::1'),
(1527, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'navigation', 'Logout', '2026-02-22 12:23:15', '::1'),
(1528, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-22 12:23:22', '::1'),
(1529, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-22 12:23:24', '::1'),
(1530, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-22 12:23:26', '::1'),
(1531, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-22 12:28:13', '::1'),
(1532, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'navigation', 'Logout', '2026-02-22 12:29:08', '::1'),
(1533, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:29:13', '::1'),
(1534, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 12:29:16', '::1'),
(1535, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 12:29:18', '::1'),
(1536, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:29:43', '::1'),
(1537, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:32:13', '::1'),
(1538, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 12:32:13', '::1'),
(1539, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 12:32:39', '::1'),
(1540, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:47:33', '::1'),
(1541, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 12:47:35', '::1'),
(1542, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 12:47:36', '::1'),
(1543, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 12:47:37', '::1'),
(1544, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 12:47:38', '::1'),
(1545, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 12:47:42', '::1'),
(1546, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-22 12:47:43', '::1'),
(1547, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-22 12:47:46', '::1'),
(1548, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-22 12:47:47', '::1'),
(1549, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-22 12:47:48', '::1'),
(1550, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-22 12:47:50', '::1'),
(1551, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-22 12:47:50', '::1'),
(1552, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-22 12:47:51', '::1'),
(1553, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-22 12:47:52', '::1'),
(1554, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-22 12:47:54', '::1'),
(1555, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 12:47:55', '::1'),
(1556, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 12:47:57', '::1'),
(1557, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 12:47:58', '::1'),
(1558, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-22 12:47:59', '::1'),
(1559, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 12:48:00', '::1'),
(1560, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-22 12:48:01', '::1'),
(1561, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 12:48:02', '::1'),
(1562, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 12:48:03', '::1'),
(1563, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 12:48:07', '::1'),
(1564, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-22 12:48:08', '::1'),
(1565, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:49:03', '::1'),
(1566, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:49:03', '::1'),
(1567, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 12:49:07', '::1'),
(1568, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 12:49:08', '::1'),
(1569, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 12:49:10', '::1'),
(1570, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-22 12:49:11', '::1'),
(1571, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-22 12:49:15', '::1'),
(1572, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-22 12:49:17', '::1'),
(1573, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-22 12:49:19', '::1'),
(1574, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-22 12:49:21', '::1'),
(1575, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-22 12:49:22', '::1'),
(1576, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-22 12:49:23', '::1'),
(1577, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-22 12:49:24', '::1'),
(1578, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-22 12:49:26', '::1'),
(1579, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 12:49:28', '::1'),
(1580, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 12:49:30', '::1'),
(1581, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 12:49:32', '::1'),
(1582, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-22 12:49:35', '::1'),
(1583, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 12:49:36', '::1'),
(1584, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-22 12:49:37', '::1'),
(1585, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 12:49:40', '::1'),
(1586, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-22 12:49:41', '::1'),
(1587, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 12:49:43', '::1'),
(1588, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 12:49:48', '::1'),
(1589, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-22 12:49:52', '::1'),
(1590, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-22 12:50:07', '::1'),
(1591, 2, 'admin', 'shreye', '', 'forms/result-add', 'page_view', '', '2026-02-22 12:50:08', '::1'),
(1592, 2, 'admin', 'shreye', '', 'show-details/show-result', 'page_view', '', '2026-02-22 12:50:10', '::1'),
(1593, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-22 12:50:12', '::1'),
(1594, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-22 12:50:12', '::1'),
(1595, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-22 12:50:14', '::1'),
(1596, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-22 12:50:15', '::1'),
(1597, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-22 12:50:18', '::1'),
(1598, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-22 12:50:20', '::1'),
(1599, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-22 12:50:23', '::1'),
(1600, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-22 12:50:23', '::1'),
(1601, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-22 12:50:25', '::1'),
(1602, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-22 12:50:26', '::1'),
(1603, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-22 12:50:26', '::1'),
(1604, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 12:50:29', '::1'),
(1605, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 12:50:29', '::1'),
(1606, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 12:50:39', '::1'),
(1607, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 12:50:41', '::1'),
(1608, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 12:50:46', '::1'),
(1609, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 12:54:01', '::1'),
(1610, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 12:54:05', '::1'),
(1611, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 12:54:10', '::1'),
(1612, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 12:54:38', '::1'),
(1613, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'click', '', '2026-02-22 12:54:41', '::1'),
(1614, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 12:54:44', '::1'),
(1615, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'click', '', '2026-02-22 12:54:45', '::1'),
(1616, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 12:54:47', '::1'),
(1617, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'click', '', '2026-02-22 12:54:50', '::1'),
(1618, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-22 12:54:51', '::1'),
(1619, 2, 'admin', 'shreye', '', 'forms/student-add', 'click', '', '2026-02-22 12:54:56', '::1'),
(1620, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-22 12:54:57', '::1'),
(1621, 2, 'admin', 'shreye', '', 'show-details/show-student', 'click', '', '2026-02-22 12:55:00', '::1'),
(1622, 2, 'admin', 'shreye', '', 'forms/parent-add', 'page_view', '', '2026-02-22 12:55:01', '::1'),
(1623, 2, 'admin', 'shreye', '', 'forms/parent-add', 'click', '', '2026-02-22 12:55:03', '::1'),
(1624, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'page_view', '', '2026-02-22 12:55:04', '::1'),
(1625, 2, 'admin', 'shreye', '', 'show-details/show-parent', 'click', '', '2026-02-22 12:55:10', '::1'),
(1626, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-22 12:55:12', '::1'),
(1627, 2, 'admin', 'shreye', '', 'forms/class-add', 'click', '', '2026-02-22 12:55:13', '::1'),
(1628, 2, 'admin', 'shreye', '', 'show-details/show-class', 'page_view', '', '2026-02-22 12:55:14', '::1'),
(1629, 2, 'admin', 'shreye', '', 'show-details/show-class', 'click', '', '2026-02-22 12:55:19', '::1'),
(1630, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-22 12:55:20', '::1'),
(1631, 2, 'admin', 'shreye', '', 'forms/course-add', 'click', '', '2026-02-22 12:55:23', '::1'),
(1632, 2, 'admin', 'shreye', '', 'show-details/show-course', 'page_view', '', '2026-02-22 12:55:24', '::1'),
(1633, 2, 'admin', 'shreye', '', 'show-details/show-course', 'click', '', '2026-02-22 12:55:27', '::1'),
(1634, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-22 12:55:28', '::1'),
(1635, 2, 'admin', 'shreye', '', 'forms/time-table', 'click', '', '2026-02-22 12:55:32', '::1'),
(1636, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 12:55:33', '::1'),
(1637, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'click', '', '2026-02-22 12:55:35', '::1'),
(1638, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-22 12:55:37', '::1'),
(1639, 2, 'admin', 'shreye', '', 'forms/examinationform', 'click', '', '2026-02-22 12:55:40', '::1'),
(1640, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-22 12:55:42', '::1'),
(1641, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'click', '', '2026-02-22 12:55:46', '::1'),
(1642, 2, 'admin', 'shreye', '', 'forms/admin-card', 'page_view', '', '2026-02-22 12:55:47', '::1'),
(1643, 2, 'admin', 'shreye', '', 'forms/admin-card', 'click', '', '2026-02-22 12:55:50', '::1'),
(1644, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 12:55:51', '::1'),
(1645, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'click', '', '2026-02-22 12:55:52', '::1'),
(1646, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 12:55:54', '::1'),
(1647, 2, 'admin', 'shreye', '', 'show-details/show-admin-card', 'click', '', '2026-02-22 12:56:00', '::1'),
(1648, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'page_view', '', '2026-02-22 12:56:01', '::1'),
(1649, 2, 'admin', 'shreye', '', 'forms/paper-time-table', 'click', '', '2026-02-22 12:56:08', '::1'),
(1650, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 12:56:09', '::1'),
(1651, 2, 'admin', 'shreye', '', 'show-details/show-paper-sch', 'click', '', '2026-02-22 12:56:12', '::1'),
(1652, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 12:56:15', '::1'),
(1653, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:00:48', '::1'),
(1654, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 13:00:50', '::1'),
(1655, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 13:00:54', '::1'),
(1656, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'click', '', '2026-02-22 13:01:12', '::1'),
(1657, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'page_view', '', '2026-02-22 13:01:14', '::1'),
(1658, 2, 'admin', 'shreye', '', 'forms/student-fee-det', 'click', '', '2026-02-22 13:01:17', '::1'),
(1659, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-22 13:01:20', '::1'),
(1660, 2, 'admin', 'shreye', '', 'show-details/show-std-fee', 'click', '', '2026-02-22 13:01:25', '::1'),
(1661, 2, 'admin', 'shreye', '', 'forms/result-add', 'page_view', '', '2026-02-22 13:01:26', '::1'),
(1662, 2, 'admin', 'shreye', '', 'forms/result-add', 'click', '', '2026-02-22 13:01:29', '::1'),
(1663, 2, 'admin', 'shreye', '', 'show-details/show-result', 'page_view', '', '2026-02-22 13:01:30', '::1'),
(1664, 2, 'admin', 'shreye', '', 'show-details/show-result', 'click', '', '2026-02-22 13:01:33', '::1'),
(1665, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-22 13:01:35', '::1'),
(1666, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'click', '', '2026-02-22 13:01:37', '::1'),
(1667, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-22 13:01:38', '::1'),
(1668, 2, 'admin', 'shreye', '', 'show-details/show-study-mat', 'click', '', '2026-02-22 13:01:42', '::1'),
(1669, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-22 13:01:43', '::1'),
(1670, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'click', '', '2026-02-22 13:01:46', '::1'),
(1671, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-22 13:01:47', '::1'),
(1672, 2, 'admin', 'shreye', '', 'forms/show_exams', 'click', '', '2026-02-22 13:01:50', '::1'),
(1673, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-22 13:01:52', '::1'),
(1674, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'click', '', '2026-02-22 13:01:54', '::1'),
(1675, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-22 13:01:55', '::1'),
(1676, 2, 'admin', 'shreye', '', 'show-details/show-cls-fun', 'click', '', '2026-02-22 13:01:59', '::1'),
(1677, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'page_view', '', '2026-02-22 13:02:01', '::1'),
(1678, 2, 'admin', 'shreye', '', 'show-details/show-online-student-details', 'click', '', '2026-02-22 13:02:04', '::1'),
(1679, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'page_view', '', '2026-02-22 13:02:05', '::1'),
(1680, 2, 'admin', 'shreye', '', 'show-details/show-demo-register-std-details', 'click', '', '2026-02-22 13:02:07', '::1'),
(1681, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'page_view', '', '2026-02-22 13:02:08', '::1'),
(1682, 2, 'admin', 'shreye', '', 'show-details/show-contact-student-details', 'click', '', '2026-02-22 13:02:11', '::1'),
(1683, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 13:02:13', '::1'),
(1684, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'click', '', '2026-02-22 13:02:16', '::1'),
(1685, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 13:02:17', '::1'),
(1686, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'click', '', '2026-02-22 13:02:19', '::1'),
(1687, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 13:02:20', '::1'),
(1688, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'click', '', '2026-02-22 13:02:23', '::1'),
(1689, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 13:02:24', '::1'),
(1690, 2, 'admin', 'shreye', '', 'forms/basic-info', 'click', '', '2026-02-22 13:02:31', '::1'),
(1691, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 13:02:57', '::1'),
(1692, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:04:06', '::1'),
(1693, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 13:04:09', '::1'),
(1694, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-22 13:04:16', '::1'),
(1695, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'click', '', '2026-02-22 13:04:18', '::1');
INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `full_name`, `batch`, `page_url`, `action_type`, `element_text`, `timestamp`, `ip_address`) VALUES
(1696, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 13:04:20', '::1'),
(1697, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:04:23', '::1'),
(1698, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:04:24', '::1'),
(1699, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:04:24', '::1'),
(1700, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:04:25', '::1'),
(1701, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 13:04:26', '::1'),
(1702, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 13:04:29', '::1'),
(1703, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:05:48', '::1'),
(1704, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 13:05:50', '::1'),
(1705, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-22 13:05:53', '::1'),
(1706, 2, 'admin', 'shreye', '', 'forms/basic-info', 'click', '', '2026-02-22 13:05:57', '::1'),
(1707, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'page_view', '', '2026-02-22 13:05:58', '::1'),
(1708, 2, 'admin', 'shreye', '', 'forms/view-basic-info', 'click', '', '2026-02-22 13:06:00', '::1'),
(1709, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 13:06:02', '::1'),
(1710, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'click', '', '2026-02-22 13:06:09', '::1'),
(1711, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'page_view', '', '2026-02-22 13:06:10', '::1'),
(1712, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'click', '', '2026-02-22 13:06:13', '::1'),
(1713, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-22 13:06:15', '::1'),
(1714, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 13:07:27', '::1'),
(1715, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 13:07:28', '::1'),
(1716, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-22 13:07:33', '::1'),
(1717, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'click', '', '2026-02-22 13:07:37', '::1'),
(1718, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'navigation', 'Logout', '2026-02-22 13:07:41', '::1'),
(1719, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-22 13:42:48', '::1'),
(1720, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'click', '', '2026-02-22 13:42:54', '::1'),
(1721, 30, 'student', 'Riya Patil', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 13:42:55', '::1'),
(1722, 30, 'student', 'Riya Patil', '', 'show-details/show-admin-card', 'page_view', '', '2026-02-22 13:42:57', '::1'),
(1723, 30, 'student', 'Riya Patil', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 13:42:57', '::1'),
(1724, 30, 'student', 'Riya Patil', '', 'show-details/show-result', 'page_view', '', '2026-02-22 13:42:58', '::1'),
(1725, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-22 13:43:00', '::1'),
(1726, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-22 13:43:00', '::1'),
(1727, 30, 'student', 'Riya Patil', '', 'forms/mark_attendance_page', 'page_view', '', '2026-02-22 13:43:02', '::1'),
(1728, 30, 'student', 'Riya Patil', '', 'forms/view_attendance', 'page_view', '', '2026-02-22 13:43:03', '::1'),
(1729, 30, 'student', 'Riya Patil', '', 'show-details/show-std-fee', 'page_view', '', '2026-02-22 13:43:08', '::1'),
(1730, 30, 'student', 'Riya Patil', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-22 13:43:09', '::1'),
(1731, 30, 'student', 'Riya Patil', '', 'forms/show_exams', 'page_view', '', '2026-02-22 13:43:10', '::1'),
(1732, 30, 'student', 'Riya Patil', '', 'forms/student_take_exam', 'page_view', '', '2026-02-22 13:43:11', '::1'),
(1733, 30, 'student', 'Riya Patil', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-22 13:43:12', '::1'),
(1734, 30, 'student', 'Riya Patil', '', 'show-details/show-cls-fun', 'navigation', 'Logout', '2026-02-22 13:43:16', '::1'),
(1735, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 14:08:44', '::1'),
(1736, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 14:27:14', '::1'),
(1737, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:06:13', '::1'),
(1738, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:37:35', '::1'),
(1739, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:37:38', '::1'),
(1740, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:37:38', '::1'),
(1741, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:37:39', '::1'),
(1742, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:41:07', '::1'),
(1743, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 15:41:30', '::1'),
(1744, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-22 15:41:34', '::1'),
(1745, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'page_view', '', '2026-02-22 15:41:36', '::1'),
(1746, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 15:41:51', '::1'),
(1747, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'navigation', 'Logout', '2026-02-22 15:42:13', '::1'),
(1748, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:42:31', '::1'),
(1749, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 15:42:40', '::1'),
(1750, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 15:42:43', '::1'),
(1751, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 15:42:44', '::1'),
(1752, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 15:42:47', '::1'),
(1753, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 15:42:54', '::1'),
(1754, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:42:56', '::1'),
(1755, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 15:42:58', '::1'),
(1756, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 15:43:01', '::1'),
(1757, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 15:43:37', '::1'),
(1758, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 15:47:47', '::1'),
(1759, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:47:51', '::1'),
(1760, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-22 15:47:52', '::1'),
(1761, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-22 15:47:56', '::1'),
(1762, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-22 15:48:15', '::1'),
(1763, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'navigation', 'Logout', '2026-02-22 15:48:32', '::1'),
(1764, 12, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-22 15:49:17', '::1'),
(1765, 12, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'click', '', '2026-02-22 15:49:26', '::1'),
(1766, 12, 'teacher', '(Unknown)', '', 'show-details/show-timetd', 'page_view', '', '2026-02-22 15:49:35', '::1'),
(1767, 12, 'teacher', '(Unknown)', '', 'show-details/show-paper-sch', 'page_view', '', '2026-02-22 15:49:40', '::1'),
(1768, 12, 'teacher', '(Unknown)', '', 'forms/result-add', 'page_view', '', '2026-02-22 15:49:40', '::1'),
(1769, 12, 'teacher', '(Unknown)', '', 'show-details/show-result', 'page_view', '', '2026-02-22 15:49:42', '::1'),
(1770, 12, 'teacher', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 15:49:45', '::1'),
(1771, 12, 'teacher', '(Unknown)', '', 'forms/study-mat-add', 'page_view', '', '2026-02-22 15:49:49', '::1'),
(1772, 12, 'teacher', '(Unknown)', '', 'show-details/show-study-mat', 'page_view', '', '2026-02-22 15:49:50', '::1'),
(1773, 12, 'teacher', '(Unknown)', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-22 15:49:52', '::1'),
(1774, 12, 'teacher', '(Unknown)', '', 'forms/show_exams', 'page_view', '', '2026-02-22 15:49:53', '::1'),
(1775, 12, 'teacher', '(Unknown)', '', 'show-details/show-cls-fun', 'page_view', '', '2026-02-22 15:49:56', '::1'),
(1776, 12, 'teacher', '(Unknown)', '', 'show-details/show-meets', 'page_view', '', '2026-02-22 15:49:59', '::1'),
(1777, 12, 'teacher', '(Unknown)', '', 'show-details/show-attendance', 'page_view', '', '2026-02-22 15:50:02', '::1'),
(1778, 12, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-22 15:50:20', '::1'),
(1779, 12, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'Mark all read', '2026-02-22 15:50:39', '::1'),
(1780, 12, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'View all notifications', '2026-02-22 15:50:41', '::1'),
(1781, 12, 'teacher', '(Unknown)', '', '/final-year-pro/dashboard/teacher-dashboard.php', 'page_view', '', '2026-02-22 15:50:46', '::1'),
(1782, 12, 'teacher', '(Unknown)', '', 'http://localhost:8080/final-year-pro/dashboard/teacher-dashboard.php', 'navigation', 'Logout', '2026-02-22 15:50:49', '::1'),
(1783, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-22 15:51:03', '::1'),
(1784, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'navigation', 'View all notifications', '2026-02-22 15:51:16', '::1'),
(1785, 30, 'student', 'Riya Patil', '', '/final-year-pro/dashboard/student-dashboard.php', 'page_view', '', '2026-02-22 15:51:19', '::1'),
(1786, 30, 'student', 'Riya Patil', '', 'http://localhost:8080/final-year-pro/dashboard/student-dashboard.php', 'navigation', 'Logout', '2026-02-22 15:51:42', '::1'),
(1787, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-22 15:51:52', '::1'),
(1788, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'View all notifications', '2026-02-22 15:51:58', '::1'),
(1789, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-23 18:05:39', '::1'),
(1790, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-23 18:05:44', '::1'),
(1791, 2, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-23 18:05:52', '::1'),
(1792, 2, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-23 18:05:57', '::1'),
(1793, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-23 18:06:00', '::1'),
(1794, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-23 18:06:02', '::1'),
(1795, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-23 18:06:04', '::1'),
(1796, 2, 'admin', 'shreye', '', 'show-details/show-student', 'page_view', '', '2026-02-23 18:08:38', '::1'),
(1797, 2, 'admin', 'shreye', '', 'forms/class-add', 'page_view', '', '2026-02-23 18:08:42', '::1'),
(1798, 2, 'admin', 'shreye', '', 'forms/course-add', 'page_view', '', '2026-02-23 18:08:49', '::1'),
(1799, 2, 'admin', 'shreye', '', 'forms/time-table', 'page_view', '', '2026-02-23 18:08:58', '::1'),
(1800, 2, 'admin', 'shreye', '', 'show-details/show-timetd', 'page_view', '', '2026-02-23 18:09:05', '::1'),
(1801, 2, 'admin', 'shreye', '', 'forms/examinationform', 'page_view', '', '2026-02-23 18:09:12', '::1'),
(1802, 2, 'admin', 'shreye', '', 'show-details/show-examinforms', 'page_view', '', '2026-02-23 18:09:17', '::1'),
(1803, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-23 18:10:24', '::1'),
(1804, 2, 'admin', 'shreye', '', 'forms/show_exams', 'page_view', '', '2026-02-23 18:10:47', '::1'),
(1805, 2, 'admin', 'shreye', '', 'show-details/show-attendance', 'page_view', '', '2026-02-23 18:11:24', '::1'),
(1806, 2, 'admin', 'shreye', '', 'forms/study-mat-add', 'page_view', '', '2026-02-23 18:17:32', '::1'),
(1807, 2, 'admin', 'shreye', '', 'forms/teacher_create_exam', 'page_view', '', '2026-02-23 18:17:39', '::1'),
(1808, 2, 'admin', 'shreye', '', 'forms/class-events-add', 'page_view', '', '2026-02-23 18:17:43', '::1'),
(1809, 2, 'admin', 'shreye', '', 'forms/parent-meeting-form', 'page_view', '', '2026-02-23 18:18:51', '::1'),
(1810, 2, 'admin', 'shreye', '', 'show-details/show-meets', 'page_view', '', '2026-02-23 18:19:01', '::1'),
(1811, 2, 'admin', 'shreye', '', 'forms/basic-info', 'page_view', '', '2026-02-23 18:19:12', '::1'),
(1812, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-23 18:19:23', '::1'),
(1813, 2, 'admin', 'shreye', '', 'forms/kiosk_share', 'page_view', '', '2026-02-23 18:19:35', '::1'),
(1814, 2, 'admin', 'shreye', '', 'forms/admin_devices', 'page_view', '', '2026-02-23 18:19:44', '::1'),
(1815, 2, 'admin', 'shreye', '', 'logs/admin_logs', 'page_view', '', '2026-02-23 18:20:24', '::1'),
(1816, 2, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-23 18:54:48', '::1'),
(1817, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-24 16:09:44', '::1'),
(1818, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-24 16:09:45', '::1'),
(1819, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-24 16:10:12', '::1'),
(1820, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-24 16:10:13', '::1'),
(1821, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-24 16:11:48', '::1'),
(1822, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-24 16:14:28', '::1'),
(1823, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-24 16:14:29', '::1'),
(1824, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-24 16:25:44', '::1'),
(1825, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-24 16:25:45', '::1'),
(1826, 1, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-26 12:11:32', '::1'),
(1827, 1, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-26 12:18:41', '::1'),
(1828, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-26 12:18:43', '::1'),
(1829, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-26 12:18:44', '::1'),
(1830, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-26 12:18:45', '::1'),
(1831, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'navigation', 'Mark all read', '2026-02-26 12:19:00', '::1'),
(1832, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-26 12:19:05', '::1'),
(1833, 1, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-26 18:23:44', '::1'),
(1834, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-26 18:23:48', '::1'),
(1835, 1, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-26 18:23:54', '::1'),
(1836, 1, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-26 18:23:55', '::1'),
(1837, 1, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-26 18:23:57', '::1'),
(1838, 1, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'click', '', '2026-02-26 18:23:59', '::1'),
(1839, 1, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'click', '', '2026-02-26 18:24:00', '::1'),
(1840, 1, 'admin', 'shreye', '', 'forms/teacher-add', 'page_view', '', '2026-02-26 18:24:03', '::1'),
(1841, 1, 'admin', 'shreye', '', 'show-details/show-teacher', 'page_view', '', '2026-02-26 18:24:04', '::1'),
(1842, 1, 'admin', 'shreye', '', 'forms/student-add', 'page_view', '', '2026-02-26 18:24:06', '::1'),
(1843, 1, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-27 16:44:12', '::1'),
(1844, 2, 'admin', 'shreye', '', '/final-year-pro/dashboard/dashboard.php', 'page_view', '', '2026-02-28 12:22:24', '::1'),
(1845, 2, 'admin', 'shreye', '', 'http://localhost:8080/final-year-pro/dashboard/dashboard.php', 'click', '', '2026-02-28 12:22:28', '::1'),
(1846, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'page_view', '', '2026-02-28 12:22:35', '::1'),
(1847, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'navigation', 'Mark all read', '2026-02-28 12:22:46', '::1'),
(1848, 2, 'admin', 'shreye', '', 'dashboard/dashboard.php', 'navigation', 'Logout', '2026-02-28 12:22:50', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `add_class`
--

CREATE TABLE `add_class` (
  `class_id` int(11) NOT NULL,
  `Class_Name` varchar(30) NOT NULL,
  `Section` varchar(20) NOT NULL,
  `Teacher_Name` varchar(30) NOT NULL,
  `Max_Student` int(5) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_class`
--

INSERT INTO `add_class` (`class_id`, `Class_Name`, `Section`, `Teacher_Name`, `Max_Student`, `upload_date`) VALUES
(2, 'MSCIT ', '10 to 11', 'rahul sir', 30, '2025-10-29 16:10:53'),
(3, 'MSCIT ', '11 to 1', 'rahul sir', 52, '2025-10-29 18:02:05'),
(4, 'php', '1 to 2', 'rahul sir', 20, '2025-10-29 18:13:20'),
(5, 'MSCIT ', '11 to 3', 'rahul sir', 20, '2025-10-29 19:36:40'),
(6, 'MSCIT ', '11 to 3', 'rahul sir', 30, '2025-10-30 20:20:33'),
(7, 'MSCIT ', '11 to 3', 'rahul sir', 40, '2025-11-01 06:34:24'),
(8, 'java', '11 to 3', 'rahul sir', 40, '2025-11-01 06:34:58'),
(9, 'MSCIT ', '10 to 11', 'rahul sir', 33, '2025-11-01 08:03:50'),
(10, 'MSCIT ', '11 to 3', 'ashif sir', 55, '2025-11-26 17:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `add_demo_students`
--

CREATE TABLE `add_demo_students` (
  `Student_Id` int(11) NOT NULL,
  `student_name` varchar(40) NOT NULL,
  `student_num` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_demo_students`
--

INSERT INTO `add_demo_students` (`Student_Id`, `student_name`, `student_num`, `created_at`) VALUES
(2, 'virat', '8954584903', '2025-11-01 17:33:52'),
(3, 'pranav', '8788974254', '2025-12-05 07:37:15'),
(4, 'rahul shrama', '1245345454', '2025-12-05 07:45:44'),
(6, 'Abhishek Suhas Pathak', '9898724843', '2026-01-07 15:50:16'),
(7, 'chinmay', '5464454312', '2026-01-10 07:00:31'),
(8, 'vijay', '5466454312', '2026-01-10 07:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `add_event`
--

CREATE TABLE `add_event` (
  `Event_id` int(11) NOT NULL,
  `Event_Name` varchar(30) NOT NULL,
  `Event_Desc` varchar(400) NOT NULL,
  `Event_Date` date NOT NULL,
  `Event_Time` time NOT NULL,
  `Total_Expense` int(7) NOT NULL,
  `event_file` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_event`
--

INSERT INTO `add_event` (`Event_id`, `Event_Name`, `Event_Desc`, `Event_Date`, `Event_Time`, `Total_Expense`, `event_file`, `upload_date`) VALUES
(4, 'Dewali Festival', 'sdlkfnsd.fnmsd.a,fm', '2025-09-16', '20:13:00', 5000, 'Dewali_Festival_134015531162034071.jpg', '2025-12-08 11:42:08'),
(5, 'christmas', 'fsdfsd', '2025-12-25', '17:30:00', 9000, 'christmas_134007894206809137.jpg', '2025-12-12 10:40:29'),
(11, 'Dewali Festival', 'fbxcb', '2026-02-27', '17:00:00', 6000, '', '2026-02-07 16:59:37'),
(12, 'christmas', 'fsasf', '2026-02-18', '18:00:00', 8000, '', '2026-02-08 11:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `add_online_students`
--

CREATE TABLE `add_online_students` (
  `Student_Id` int(11) NOT NULL,
  `student_name` varchar(40) NOT NULL,
  `student_email` varchar(40) NOT NULL,
  `student_num` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_online_students`
--

INSERT INTO `add_online_students` (`Student_Id`, `student_name`, `student_email`, `student_num`, `created_at`) VALUES
(1, 'Abhishek Suhas Pathak', 'abhishek123@gmail.com', '9930056891', '2025-11-01 17:34:21'),
(3, 'karunya pathak', 'karunya12@gmail.com', '9833542083', '2025-11-01 17:34:21'),
(4, 'rahul', 'rahul123@gmail.com', '5897625934', '2025-11-01 17:34:21'),
(5, 'ajay', 'ajay@gmail.com', '4584759875', '2025-11-01 17:34:21'),
(7, 'vikas', 'vikas23@gmail.com', '6554604695', '2025-11-01 17:34:21'),
(8, 'rahul', 'rahul12@gmail.com', '5456416489', '2025-12-03 13:41:08'),
(9, 'bhim ', 'bhim23@gmail.com', '1564894321', '2025-12-03 13:46:58'),
(11, 'bhim', 'bhim253@gmail.com', '5648646513', '2025-12-03 13:50:32'),
(12, 'Rohit Sharma', 'rohit264@gmail.com', '4566464321', '2025-12-03 13:52:24'),
(13, 'Abhishek Suhas Pathak', 'abhishek17423@gmail.com', '5958948972', '2025-12-03 13:53:50'),
(14, 'Abhishek Suhas Pathak', 'abhishek1423@gmail.com', '5958454654', '2025-12-03 13:54:39'),
(15, 'Archana', 'archana@gmail.com', '6456489723', '2025-12-05 07:36:51'),
(16, 'kiran ', 'kiran@gmail.com', '5643241874', '2025-12-05 07:46:49'),
(17, 'karunya pathak', 'karunya3@gmail.com', '9867956598', '2026-01-06 07:18:07'),
(18, 'suhas pathak', 'suhas2@gmail.com', '6798458422', '2026-01-09 09:24:38'),
(19, 'Rahul', 'rahul@gmail.com', '8753321891', '2026-02-03 10:47:27'),
(20, 'Abhishek Pathak', 'abhihack1420@gmail.com', '6579821157', '2026-02-08 10:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `add_parents`
--

CREATE TABLE `add_parents` (
  `parent_id` int(11) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_email` varchar(255) NOT NULL,
  `parent_num` varchar(15) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_parents`
--

INSERT INTO `add_parents` (`parent_id`, `parent_name`, `parent_email`, `parent_num`, `password_hash`, `photo`, `created_at`) VALUES
(17, 'shreye', 'daveshreye@gmail.com', '1212121212', '$2y$10$hRJ2EyMKlOJK0ee0X94kfOoQzDlwBdc31Q.QRZerTxxyAnOGaN0Oa', 'parent_1771150679_best-air-fryer_2_1.png', '2026-02-15 10:17:59'),
(19, 'shreye dave', 'daveshreye245@gmail.com', '1212125656', '$2y$10$YGofXQniDyb2AoWS.j1HVewjszB5t.x2raLi.lUPxBwLKxZsCMYMK', 'parent_1771150767_best-air-fryer_1.png', '2026-02-15 10:19:27'),
(20, 'aditya', 'aadityaborkar364@gmail.com', '1225698745', '$2y$10$PSeGXJ2TdRb5xTo7YmznoO/phe8IyBbsCmiejjfp4xnEwtAjOVnJG', 'parent_1771158834_best-air-fryer_1.png', '2026-02-15 12:33:54'),
(26, 'puja ', 'vaishnavu0710@gmail.com', '9935743454', '$2y$10$fK1trz2EcGw1RSgG8WDm7.fRS/h5ylMasibcOarZGpBIC1gayoL7i', 'parent_1771335852_best-air-fryer_2.jpg', '2026-02-17 13:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `add_result`
--

CREATE TABLE `add_result` (
  `result_id` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Student_Name` varchar(40) NOT NULL,
  `student_email` varchar(100) DEFAULT NULL,
  `parent_email` varchar(150) DEFAULT NULL,
  `Examination_name` varchar(40) NOT NULL,
  `Module` varchar(50) NOT NULL,
  `Marks_obtained` int(11) NOT NULL,
  `Total_Marks` int(11) NOT NULL,
  `result_status` text NOT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `attendance_percentage` decimal(5,2) DEFAULT NULL,
  `performance_rating` varchar(50) DEFAULT NULL,
  `instructor_comments` text DEFAULT NULL,
  `result_sheet_file` varchar(250) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_result`
--

INSERT INTO `add_result` (`result_id`, `Student_ID`, `Student_Name`, `student_email`, `parent_email`, `Examination_name`, `Module`, `Marks_obtained`, `Total_Marks`, `result_status`, `percentage`, `grade`, `attendance_percentage`, `performance_rating`, `instructor_comments`, `result_sheet_file`, `upload_date`) VALUES
(1, 1, 'virat', NULL, NULL, 'python', 'python', 90, 100, 'Pass', NULL, NULL, NULL, NULL, NULL, '45_abhishek_UltimateJavaCheatSheet.pdf', '2025-10-28 17:47:13'),
(2, 2, 'abhishek pathak', NULL, NULL, 'javascript Exam', 'events/DOM', 88, 100, 'Pass', NULL, NULL, NULL, NULL, NULL, '2_abhishek_134007894206809137.jpg', '2025-10-28 19:33:24'),
(3, 1, 'virat kohli', NULL, NULL, 'python', 'python', 90, 100, 'Pass', NULL, NULL, NULL, NULL, NULL, '18_virat_Form15 A.pdf', '2025-10-29 19:46:55'),
(4, 16, 'Aaditya', 'aadi213@gmail.com', NULL, 'javaScript', 'events/DOM', 40, 50, 'Pass', NULL, NULL, NULL, NULL, NULL, '16_Aaditya_sample certifitate.pdf', '2025-12-12 06:29:52'),
(6, 11, 'Abhishek Suhas Pathak', 'abhi145@gmail.com', 'archana15@gmail.com', 'javaScript', 'events/DOM', 90, 100, 'Pass', NULL, NULL, NULL, NULL, NULL, '11_Abhishek_Suhas_Pathak_Form15 A.pdf', '2025-12-14 07:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `add_students`
--

CREATE TABLE `add_students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `student_num` varchar(15) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blood_group` varchar(5) DEFAULT NULL,
  `aadhar_number` varchar(20) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `computer_knowledge` varchar(50) DEFAULT NULL,
  `programming_interest` varchar(5) DEFAULT NULL,
  `parent_occupation` varchar(100) DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_students`
--

INSERT INTO `add_students` (`student_id`, `student_name`, `student_email`, `student_num`, `start_time`, `end_time`, `password_hash`, `photo`, `created_at`, `blood_group`, `aadhar_number`, `emergency_contact_name`, `emergency_contact_phone`, `computer_knowledge`, `programming_interest`, `parent_occupation`, `parent_email`) VALUES
(3, 'Anuradha Borkar ', 'Anu13@gmail.com', '9877548123', '17:00:00', '19:59:00', '$2y$10$fbvrLUeBhRAh0HtwOKkXoOdkACW8qQabvYEuUCMNCiyBnf64F7o/.', '3_Anuradha_Borkar__1767109807.jpg', '2025-12-30 15:50:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Abhishek Suhas Pathak', 'abhishek@gmail.com', '9833579102', '05:00:00', '19:00:00', '$2y$10$KRzAwwm6XoEChLTPCHX3VOV.WocEUNvTO5jSXtn5Q1wlHyvlWWpGK', '4_Abhishek_Suhas_Pathak_1767366344.jpeg', '2026-01-02 15:05:44', '', '', '', '', '', '', '', ''),
(7, 'karunya pathak', 'karunya123@gmail.com', '6897858923', '15:30:00', '16:30:00', 'karu@123', '7_karunya_pathak_1770112394.jpg', '2026-02-03 09:53:14', 'B+', '324151218541', 'Archana Pathak', '6666666675', 'Beginner', 'Yes', 'housewife', 'archana15@gmail.com'),
(28, 'Aaditya Borkar', 'abhihack1420@gmail.com', '', '13:00:00', '15:00:00', '$2y$10$maVvdxZZawP3lekFcPxFR.3/7OV5LqanKBZLrqJpfk9M3BXomEbx.', '28_Aaditya_Borkar_1770390713.jpg', '2026-02-06 15:11:53', 'B+', '656878797899', 'Archana Pathak', '9011600870', 'Beginner', 'Yes', 'housewife', 'archana145@gmail.com'),
(29, 'Aman Verma', 'aman.verma2027@example.com', '9876566621', '09:00:00', '11:00:00', 's%Sp#4rgci', '', '2026-02-06 15:30:50', 'B+', '123456789012', 'Anil Verma', '9876501235', 'Beginner', 'Yes', 'Teacher', 'anil.verma@example.com'),
(30, 'Riya Patil', 'riya.patil2027@example.com', '9876566622', '10:00:00', '19:00:00', '$2y$10$CvfllqfqZUL5SvEnbFDpD..CKea2UToyOUSUtFcMlyB0dMFRxtgqi', '', '2026-02-06 15:30:54', 'A+', '123456789013', 'Suresh Patil', '9876501236', 'Intermediate', 'Maybe', 'Accountant', 'suresh.patil@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `add_teachers`
--

CREATE TABLE `add_teachers` (
  `teacher_id` int(15) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `teacher_email` varchar(255) NOT NULL,
  `teacher_num` varchar(15) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_teachers`
--

INSERT INTO `add_teachers` (`teacher_id`, `teacher_name`, `teacher_email`, `teacher_num`, `password_hash`, `photo`, `created_at`) VALUES
(1, 'shre', 'daveshreye@gmail.com', '1212324544', '$2y$10$BlQYMpjzjRyy.xeX5hYWde8mgrU1hHc/4DQE4atY2FatN7bbdMHd.', 'teacher_1770989811_best-air-fryer_2.jpg', '2026-02-13 13:36:51'),
(10, 'vashnavi c', 'p43753339@gmail.com', '4547215566', '$2y$10$5kivQDvzFEFRodal/X7Jjum.as263wM6EMKzRipqurrguIk41nwY.', 'teacher_1771335999_best-air-fryer1.jpg', '2026-02-17 13:46:39'),
(12, 'rohit sharma ', 'ss19if049@gmail.com', '6895751825', '$2y$10$ODaMNgNkIm1J.T7h2BIFhuKVZwzMwB9jtKRrhBTB2j8cGUjXDgL2a', 'teacher_1771755486_HD-wallpaper-my-hero-academia.jpg', '2026-02-22 10:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `password_hash`, `created_at`, `admin_email`) VALUES
(1, 'abhishek', '$2y$10$7rtJ/2UQT/q8Uwz6obQhkOLI.tVRr09Ke.MzRQSNhdcMYBV09728W', '2025-11-27 12:21:57', 'abhihack1420@gmail.com'),
(2, 'shreye', '$2y$10$MM.ZvRGc8/yCO/U6PY5zjuEenl.AWeGL9f7uyROTuMwJLLkU789Ne', '2026-02-13 13:01:55', 'daveshreye@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `admin_card`
--

CREATE TABLE `admin_card` (
  `admin_card_id` int(11) NOT NULL,
  `Student_Id` int(15) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `Student_Name` varchar(40) NOT NULL,
  `student_email` varchar(100) DEFAULT NULL,
  `Course_Name` varchar(40) NOT NULL,
  `Examination_Name` varchar(40) NOT NULL,
  `Exam_Date` date NOT NULL,
  `Reporting_Time` time(5) NOT NULL,
  `Exam_Center` varchar(20) NOT NULL,
  `Registration_Number` varchar(50) DEFAULT NULL,
  `Seat_Number` varchar(50) DEFAULT NULL,
  `Card_Validity_Date` date DEFAULT NULL,
  `Exam_Instructions` text DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_card`
--

INSERT INTO `admin_card` (`admin_card_id`, `Student_Id`, `photo`, `Student_Name`, `student_email`, `Course_Name`, `Examination_Name`, `Exam_Date`, `Reporting_Time`, `Exam_Center`, `Registration_Number`, `Seat_Number`, `Card_Validity_Date`, `Exam_Instructions`, `upload_date`) VALUES
(1, 1, NULL, 'abhishek pathak', NULL, 'python,java', 'python programing', '2025-09-06', '14:59:00.00000', 'lab-2', NULL, NULL, NULL, NULL, '2025-10-27 18:26:09'),
(2, 2, NULL, 'Abhishek Suhas Pathak', 'abhi145@gmail.com', 'python', 'python programing', '2025-09-06', '17:53:00.00000', 'lap3', NULL, NULL, NULL, NULL, '2025-10-27 18:26:09'),
(3, 3, NULL, 'ajay', NULL, 'javascript html css', 'javascript Exam', '2026-03-01', '10:20:00.00000', 'gorai', NULL, NULL, NULL, NULL, '2025-10-27 18:26:09'),
(4, 4, NULL, 'rahul', NULL, 'Programing-C', 'C programing', '2025-09-06', '10:00:00.00000', 'gorai', NULL, NULL, NULL, NULL, '2025-10-27 18:26:09'),
(5, 5, NULL, 'karunya', NULL, 'Programing-C', 'C programing', '2025-09-06', '12:35:00.00000', 'gorai', NULL, NULL, NULL, NULL, '2025-10-29 16:03:11'),
(7, 19, NULL, 'ajay', NULL, 'mscit', 'mscit', '2025-09-06', '21:53:00.00000', 'gorai', NULL, NULL, NULL, NULL, '2025-10-31 09:23:19'),
(9, 46, '_1765458026_134007894206809137.jpg', 'Abhishek', NULL, 'python', 'python programing', '2025-09-06', '21:30:00.00000', 'lab-2', NULL, NULL, NULL, NULL, '2025-12-11 13:00:26'),
(10, 16, '_1765459875_134015531162034071.jpg', 'Aaditya', 'aadi213@gmail.com', 'python', 'python programing', '2025-09-06', '12:07:00.00000', 'lab-1', NULL, NULL, NULL, NULL, '2025-12-11 13:31:15');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `check_in_time` datetime NOT NULL DEFAULT current_timestamp(),
  `check_out_time` datetime DEFAULT NULL,
  `attendance_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `student_id`, `check_in_time`, `check_out_time`, `attendance_date`) VALUES
(4, '4', '2026-02-01 18:04:27', NULL, '2026-02-01'),
(5, '4', '2026-02-08 18:21:53', NULL, '2026-02-08'),
(8, '4', '2026-02-10 17:20:45', NULL, '2026-02-10'),
(9, '3', '2026-02-10 17:57:30', NULL, '2026-02-10'),
(11, '28', '2026-02-12 13:40:12', NULL, '2026-02-12'),
(14, '30', '2026-02-17 16:32:49', NULL, '2026-02-17'),
(16, '4', '2026-02-17 17:03:13', NULL, '2026-02-17');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `duration_months` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`batch_id`, `batch_name`, `course_name`, `duration_months`, `created_at`) VALUES
(2, 'batch 2 ', 'Programing-C', '2 month', '2025-12-11 07:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `batch_schedule`
--

CREATE TABLE `batch_schedule` (
  `schedule_id` int(11) NOT NULL,
  `new_batch_id` int(11) NOT NULL,
  `day_safe` varchar(20) NOT NULL,
  `time_safe` varchar(50) NOT NULL,
  `topic_safe` varchar(255) DEFAULT NULL,
  `instructor_safe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_schedule`
--

INSERT INTO `batch_schedule` (`schedule_id`, `new_batch_id`, `day_safe`, `time_safe`, `topic_safe`, `instructor_safe`) VALUES
(7, 2, 'monday', '09:00 - 11:00', 'introduction', 'ashif sir'),
(8, 2, 'monday', '11:00 - 01:00', 'introduction', 'ashif sir'),
(9, 2, 'tuesday', '09:00 - 11:00', 'python introduction', 'amol sir'),
(10, 2, 'tuesday', '11:00 - 01:00', 'c pro introduction', 'ashif sir'),
(11, 2, 'wednesday', '01:00 - 03:00', 'introduction', 'amol sir'),
(12, 2, 'thursday', '03:00 - 05:00', 'introduction', 'ashif sir'),
(13, 2, 'friday', '01:00 - 03:00', 'basic', 'ashif sir'),
(14, 2, 'saturday', '05:00 - 07:00', 'basic', 'ashif sir');

-- --------------------------------------------------------

--
-- Table structure for table `contact_demo_student`
--

CREATE TABLE `contact_demo_student` (
  `Student_Id` int(11) NOT NULL,
  `student_name` varchar(40) NOT NULL,
  `student_email` varchar(40) NOT NULL,
  `student_num` varchar(10) NOT NULL,
  `subject_name` text NOT NULL,
  `enq_message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_demo_student`
--

INSERT INTO `contact_demo_student` (`Student_Id`, `student_name`, `student_email`, `student_num`, `subject_name`, `enq_message`, `created_at`) VALUES
(1, 'Abhishek Suhas Pathak.', 'abhishek13@gmail.com', '9833579015', 'java python', 'cnvmkdvm,cv,sd', '2025-11-01 17:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `course_add`
--

CREATE TABLE `course_add` (
  `Course_id` int(11) NOT NULL,
  `Course_Name` varchar(30) NOT NULL,
  `Course_Code` varchar(15) NOT NULL,
  `Section` varchar(10) NOT NULL,
  `Teacher` varchar(20) NOT NULL,
  `Duration` varchar(10) NOT NULL,
  `Category` varchar(15) NOT NULL,
  `starting_date` date NOT NULL,
  `course_description` varchar(400) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `course_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_add`
--

INSERT INTO `course_add` (`Course_id`, `Course_Name`, `Course_Code`, `Section`, `Teacher`, `Duration`, `Category`, `starting_date`, `course_description`, `upload_date`, `course_fees`, `course_photo`) VALUES
(2, 'python', 'py45434', '11 to 1', 'rahul sir', '9', 'programing ', '2025-10-30', 'sfsdsafa', '2025-10-29 16:38:52', 0.00, NULL),
(3, 'python', 'py45455', '11 to 3', 'rahul sir', '9', 'programing ', '2025-10-30', 'sfsdsafa', '2025-10-29 16:58:03', 0.00, NULL),
(4, 'python', 'py4545255', '11 to 1', 'karunya ', '5', 'programing ', '2025-11-20', 'fdghfdgd', '2025-11-26 17:04:37', 0.00, NULL),
(5, 'javascript', 'js457884', '11 to 1', 'amol sir', '2', 'programing ', '0000-00-00', 'join it!', '2025-12-11 09:28:52', 15000.00, '1765445332_134007894206809137.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `device_permissions`
--

CREATE TABLE `device_permissions` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `device_token` varchar(100) DEFAULT NULL,
  `custom_name` varchar(100) DEFAULT NULL,
  `device_name` varchar(100) DEFAULT 'Unknown Device',
  `status` enum('pending','allowed','blocked') DEFAULT 'pending',
  `request_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_accessed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_permissions`
--

INSERT INTO `device_permissions` (`id`, `ip_address`, `device_token`, `custom_name`, `device_name`, `status`, `request_time`, `last_accessed`) VALUES
(9, '127.0.0.1', '04264905467d6eb2d6bd3a73c5adc71f', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Sa', 'allowed', '2026-02-21 18:07:23', '2026-02-22 08:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `exam_answers_log`
--

CREATE TABLE `exam_answers_log` (
  `log_id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `student_answer` varchar(10) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_answers_log`
--

INSERT INTO `exam_answers_log` (`log_id`, `exam_id`, `question_id`, `student_answer`, `is_correct`) VALUES
(1, 1, 1, 'D', 0),
(2, 1, 2, 'C', 0),
(3, 1, 3, 'A', 0),
(4, 1, 4, 'C', 1),
(5, 1, 5, 'B', 1),
(6, 1, 6, 'B', 1),
(7, 1, 7, 'C', 1),
(8, 1, 8, 'A', 0),
(9, 1, 9, 'B', 0),
(10, 1, 10, 'N/A', 0),
(11, 1, 11, 'B', 1),
(12, 1, 12, 'B', 0),
(13, 1, 13, 'B', 1),
(14, 1, 14, 'A', 0),
(15, 1, 15, 'D', 0),
(16, 1, 16, 'B', 1),
(17, 1, 17, 'B', 0),
(18, 1, 18, 'B', 1),
(19, 1, 19, 'B', 0),
(20, 1, 20, 'B', 1),
(21, 2, 21, 'A', 0),
(22, 2, 22, 'B', 0),
(23, 2, 23, 'B', 1),
(24, 2, 24, 'B', 1),
(25, 2, 25, 'C', 1),
(26, 2, 26, 'C', 0),
(27, 2, 27, 'B', 0),
(28, 2, 28, 'B', 1),
(29, 2, 29, 'B', 0),
(30, 2, 30, 'B', 0),
(31, 2, 31, 'B', 0),
(32, 2, 32, 'B', 0),
(33, 2, 33, 'B', 0),
(34, 2, 34, 'C', 0),
(35, 2, 35, 'B', 1),
(36, 2, 36, 'B', 0),
(37, 2, 37, 'C', 1),
(38, 2, 38, 'B', 0),
(39, 2, 39, 'B', 1),
(40, 2, 40, 'B', 0),
(41, 3, 41, 'N/A', 0),
(42, 3, 42, 'N/A', 0),
(43, 3, 43, 'N/A', 0),
(44, 3, 44, 'N/A', 0),
(45, 3, 45, 'N/A', 0),
(46, 3, 46, 'N/A', 0),
(47, 3, 47, 'N/A', 0),
(48, 3, 48, 'N/A', 0),
(49, 3, 49, 'N/A', 0),
(50, 3, 50, 'N/A', 0),
(51, 3, 51, 'N/A', 0),
(52, 3, 52, 'N/A', 0),
(53, 3, 53, 'N/A', 0),
(54, 3, 54, 'N/A', 0),
(55, 3, 55, 'N/A', 0),
(56, 3, 56, 'N/A', 0),
(57, 3, 57, 'N/A', 0),
(58, 3, 58, 'N/A', 0),
(59, 3, 59, 'N/A', 0),
(60, 3, 60, 'N/A', 0),
(61, 4, 61, 'Not Attemp', 0),
(62, 4, 62, 'Not Attemp', 0),
(63, 4, 63, 'Not Attemp', 0),
(64, 4, 64, 'Not Attemp', 0),
(65, 4, 65, 'Not Attemp', 0),
(66, 4, 66, 'Not Attemp', 0),
(67, 4, 67, 'Not Attemp', 0),
(68, 4, 68, 'Not Attemp', 0),
(69, 4, 69, 'Not Attemp', 0),
(70, 4, 70, 'Not Attemp', 0),
(71, 4, 71, 'Not Attemp', 0),
(72, 4, 72, 'Not Attemp', 0),
(73, 4, 73, 'Not Attemp', 0),
(74, 4, 74, 'Not Attemp', 0),
(75, 4, 75, 'Not Attemp', 0),
(76, 4, 76, 'Not Attemp', 0),
(77, 4, 77, 'Not Attemp', 0),
(78, 4, 78, 'Not Attemp', 0),
(79, 4, 79, 'Not Attemp', 0),
(80, 4, 80, 'Not Attemp', 0),
(81, 5, 81, 'Not Attemp', 0),
(82, 5, 82, 'Not Attemp', 0),
(83, 5, 83, 'Not Attemp', 0),
(84, 5, 84, 'Not Attemp', 0),
(85, 5, 85, 'Not Attemp', 0),
(86, 5, 86, 'Not Attemp', 0),
(87, 5, 87, 'Not Attemp', 0),
(88, 5, 88, 'Not Attemp', 0),
(89, 5, 89, 'Not Attemp', 0),
(90, 5, 90, 'Not Attemp', 0),
(91, 5, 91, 'Not Attemp', 0),
(92, 5, 92, 'Not Attemp', 0),
(93, 5, 93, 'Not Attemp', 0),
(94, 5, 94, 'Not Attemp', 0),
(95, 5, 95, 'Not Attemp', 0),
(96, 5, 96, 'Not Attemp', 0),
(97, 5, 97, 'Not Attemp', 0),
(98, 5, 98, 'Not Attemp', 0),
(99, 5, 99, 'Not Attemp', 0),
(100, 5, 100, 'Not Attemp', 0),
(101, 7, 121, 'D', 0),
(102, 7, 122, 'Not Attemp', 0),
(103, 7, 123, 'Not Attemp', 0),
(104, 7, 124, 'Not Attemp', 0),
(105, 7, 125, 'Not Attemp', 0),
(106, 7, 126, 'Not Attemp', 0),
(107, 7, 127, 'Not Attemp', 0),
(108, 7, 128, 'Not Attemp', 0),
(109, 7, 129, 'Not Attemp', 0),
(110, 7, 130, 'Not Attemp', 0),
(111, 7, 131, 'Not Attemp', 0),
(112, 7, 132, 'Not Attemp', 0),
(113, 7, 133, 'Not Attemp', 0),
(114, 7, 134, 'Not Attemp', 0),
(115, 7, 135, 'Not Attemp', 0),
(116, 7, 136, 'Not Attemp', 0),
(117, 7, 137, 'Not Attemp', 0),
(118, 7, 138, 'Not Attemp', 0),
(119, 7, 139, 'Not Attemp', 0),
(120, 7, 140, 'Not Attemp', 0),
(121, 8, 141, 'Not Attemp', 0),
(122, 8, 142, 'Not Attemp', 0),
(123, 8, 143, 'Not Attemp', 0),
(124, 8, 144, 'Not Attemp', 0),
(125, 8, 145, 'Not Attemp', 0),
(126, 8, 146, 'Not Attemp', 0),
(127, 8, 147, 'Not Attemp', 0),
(128, 8, 148, 'Not Attemp', 0),
(129, 8, 149, 'Not Attemp', 0),
(130, 8, 150, 'Not Attemp', 0),
(131, 8, 151, 'Not Attemp', 0),
(132, 8, 152, 'Not Attemp', 0),
(133, 8, 153, 'Not Attemp', 0),
(134, 8, 154, 'Not Attemp', 0),
(135, 8, 155, 'Not Attemp', 0),
(136, 8, 156, 'Not Attemp', 0),
(137, 8, 157, 'Not Attemp', 0),
(138, 8, 158, 'Not Attemp', 0),
(139, 8, 159, 'Not Attemp', 0),
(140, 8, 160, 'Not Attemp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_form`
--

CREATE TABLE `exam_form` (
  `exam_id` int(11) NOT NULL,
  `Exam_Name` varchar(30) NOT NULL,
  `Course_Name` varchar(30) NOT NULL,
  `Module` varchar(40) NOT NULL,
  `Exam_Type` varchar(30) NOT NULL,
  `Comp_Lab` varchar(10) NOT NULL,
  `Exam_Date` date NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  `Total_Marks` int(5) NOT NULL,
  `Passing_Marks` int(5) DEFAULT NULL,
  `No_Of_Questions` int(5) DEFAULT NULL,
  `Difficulty_Level` varchar(30) DEFAULT NULL,
  `Invigilator_Name` varchar(100) DEFAULT NULL,
  `Invigilator_Email` varchar(255) DEFAULT NULL,
  `Exam_Instructions` text DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_form`
--

INSERT INTO `exam_form` (`exam_id`, `Exam_Name`, `Course_Name`, `Module`, `Exam_Type`, `Comp_Lab`, `Exam_Date`, `Start_time`, `End_time`, `Total_Marks`, `Passing_Marks`, `No_Of_Questions`, `Difficulty_Level`, `Invigilator_Name`, `Invigilator_Email`, `Exam_Instructions`, `upload_date`) VALUES
(2, 'C programing', 'Programing-C', 'css', 'MCQ', 'lab-2', '2025-09-05', '13:33:00', '14:33:00', 50, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-29 17:00:08'),
(3, 'python', 'python', 'Array', 'MCQ', 'lab-2', '2025-09-05', '21:25:00', '22:25:00', 50, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-31 10:51:04'),
(4, '', '', '', '', '', '0000-00-00', '00:00:00', '00:00:00', 0, 0, 0, '', '', '', '', '2026-02-15 06:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `code_snippet` text DEFAULT NULL,
  `opt_a` varchar(255) DEFAULT NULL,
  `opt_b` varchar(255) DEFAULT NULL,
  `opt_c` varchar(255) DEFAULT NULL,
  `opt_d` varchar(255) DEFAULT NULL,
  `correct_ans` varchar(255) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_text`, `code_snippet`, `opt_a`, `opt_b`, `opt_c`, `opt_d`, `correct_ans`, `explanation`, `video_link`) VALUES
(1, 1, 'What will be the output of the following C code snippet?', 'int i = 5;\nwhile (i-- > 0) {\n    printf(\"%d\", i);\n}', '43210', '54321', '543210', '4321', 'A', 'The condition checks if i > 0 BEFORE decrementing (post-decrement). The printf then prints the new, decremented value. Iteration 1: i=5 (condition true), prints 4. Iteration 5: i=1 (condition true), prints 0. Next iteration: i becomes -1, condition fails.', 'https://www.youtube.com/results?search_query=C+post-decrement+in+while+loop'),
(2, 1, 'Which of the following is NOT a fundamental rule for variable naming in C?', '', 'Variable names must start with a letter or an underscore.', 'Variable names are case-sensitive.', 'Variable names cannot be C keywords (e.g., int, while).', 'Variable names can contain spaces but not special characters.', 'D', 'Variable names cannot contain spaces in C. They must be continuous sequences of letters, digits, or underscores.', 'https://www.youtube.com/results?search_query=C+variable+naming+rules'),
(3, 1, 'How many times will the body of the following \'for\' loop execute?', 'for (int i = 1; i <= 10; i += 3) {\n    // loop body\n}', '3', '4', '10', '5', 'B', 'The loop iterations are i=1, i=4, i=7, i=10. The next value would be i=13, which fails the condition i <= 10. Total 4 executions.', 'https://www.youtube.com/results?search_query=C+for+loop+iteration+count'),
(4, 1, 'In C, what is the scope of a variable declared inside a specific block (enclosed in curly braces {}) within a function?', '', 'Global scope, accessible everywhere.', 'File scope, accessible only within that source file.', 'Local scope, accessible only within the block where it is defined.', 'Function scope, accessible throughout the entire function.', 'C', 'Variables declared within a block have local, block scope and cease to exist once the program execution leaves that block.', 'https://www.youtube.com/results?search_query=C+variable+scope+block+local'),
(5, 1, 'What is the primary characteristic that distinguishes the \'do-while\' loop from the \'while\' loop in C?', '', 'The \'do-while\' loop must use a semicolon after the condition.', 'The \'do-while\' loop is always guaranteed to execute its body at least once.', 'The \'do-while\' loop is used for definite iteration counts.', 'The \'do-while\' loop cannot use the \'break\' statement.', 'B', 'In a \'do-while\' loop, the condition is checked only after the loop body has executed, guaranteeing at least one run.', 'https://www.youtube.com/results?search_query=do-while+vs+while+loop+C'),
(6, 1, 'What happens if the \'break\' statement is encountered inside a nested loop structure?', '', 'It terminates all enclosing loops immediately.', 'It terminates only the innermost loop in which the \'break\' is located.', 'It causes a compilation error.', 'It skips the current iteration and moves to the next one.', 'B', 'The \'break\' statement only affects the immediate loop structure it is contained within.', 'https://www.youtube.com/results?search_query=C+break+statement+in+nested+loops'),
(7, 1, 'Which data type in C is typically used to store a single character?', '', 'string', 'int', 'char', 'float', 'C', '`char` is the standard data type for storing single characters (usually 1 byte).', 'https://www.youtube.com/results?search_query=C+fundamental+data+types+char'),
(8, 1, 'What is the output of the following code snippet?', 'int k = 0;\nfor (k = 0; k < 5; k++) {\n    if (k == 3) continue;\n    printf(\"%d\", k);\n}', '01234', '0124', '012', '4', 'B', 'The \'continue\' statement skips the rest of the loop body when k equals 3. The values printed are 0, 1, 2, and 4.', 'https://www.youtube.com/results?search_query=C+continue+statement+example'),
(9, 1, 'If you declare a variable as `const int MAX_SIZE = 100;`, what restriction does the `const` keyword impose?', '', 'The variable must be initialized later in the code.', 'The variable can only be used inside the main function.', 'The variable\'s value cannot be changed after initialization.', 'The variable is stored in a special memory segment (register).', 'C', 'The `const` qualifier makes the variable read-only, preventing modification after its initial assignment.', 'https://www.youtube.com/results?search_query=C+const+variable+definition'),
(10, 1, 'Consider the following nested loop structure. How many times will \'Hello\' be printed?', 'for (int i = 0; i < 2; i++) {\n    for (int j = 0; j < 3; j++) {\n        printf(\"Hello\");\n    }\n}', '2', '3', '5', '6', 'D', 'The outer loop runs 2 times (i=0, 1). The inner loop runs 3 times for every outer loop iteration (j=0, 1, 2). Total executions: 2 * 3 = 6.', 'https://www.youtube.com/results?search_query=C+nested+loop+execution+counting'),
(11, 1, 'What is the crucial difference between `i++` and `++i` when used as an increment expression within a loop condition check (assuming no other operation is performed on the value)?', '', 'There is no difference in the outcome or loop performance.', '`i++` is post-increment (uses current value, then increments); `++i` is pre-increment (increments, then uses new value).', '`i++` can cause an infinite loop, while `++i` cannot.', '`++i` works only for integers, while `i++` works for all numeric types.', 'B', 'Pre-increment (`++i`) updates the variable before the value is used in the expression; post-increment (`i++`) uses the original value, then updates the variable.', 'https://www.youtube.com/results?search_query=C+pre+vs+post+increment+difference'),
(12, 1, 'Which part of the standard \'for\' loop structure is optional in C?', 'for (initialization; condition; increment) { ... }', 'All three parts (initialization, condition, increment) are mandatory.', 'Only the initialization part.', 'Only the condition part.', 'All three parts are optional, though omitting the condition results in an infinite loop (if no internal break).', 'D', 'All three sections of the `for` loop (initialization, condition, increment) are optional. If the condition is omitted, it defaults to true (1).', 'https://www.youtube.com/results?search_query=C+for+loop+optional+parts'),
(13, 1, 'What will the output be? Assume `int` is 4 bytes.', 'int x = 200;\nwhile (x < 300) {\n    printf(\"*\");\n    x -= 50;\n}', '****', 'The loop runs 3 times.', 'The loop runs indefinitely (infinite loop).', '***', 'B', 'Iteration 1: x=200, prints *, x=150. Iteration 2: x=150, prints *, x=100. Iteration 3: x=100, prints *, x=50. Iteration 4: x=50, condition (50 < 300) is true, but x continues to decrease and remains less than 300. ERROR in reasoning, let\'s re-evaluate. x starts at 200. It decreases. It will eventually hit INT_MIN, wrap around to INT_MAX, and continue decreasing. Since x < 300 is always true (unless it somehow overflows past 300, which it won\'t since it decreases), this is an infinite loop.', 'https://www.youtube.com/results?search_query=C+infinite+loop+logic+decreasing+value'),
(14, 1, 'In C programming, a local variable declared with the `static` storage class specifier inside a function retains its value across multiple function calls. What is the technical term for this behavior?', '', 'Dynamic memory allocation.', 'Global persistence.', 'Lifetime extension.', 'Type casting.', 'C', 'Static variables have their lifetime extended to the duration of the entire program, even though their scope remains local.', 'https://www.youtube.com/results?search_query=C+static+variable+lifetime+scope'),
(15, 1, 'What is the final value of \'sum\'?', 'int sum = 0;\nfor (int i = 0; i < 5; i++) {\n    if (i % 2 == 0) {\n        sum += i;\n    }\n}', '6', '10', '4', '5', 'A', 'The loop runs for i=0, 1, 2, 3, 4. The condition (i % 2 == 0) is true for i=0, i=2, and i=4. Sum = 0 + 2 + 4 = 6.', 'https://www.youtube.com/results?search_query=C+loop+summation+conditional'),
(16, 1, 'When should a programmer typically choose a \'for\' loop over a \'while\' loop?', '', 'When the loop condition is complex and depends on external factors.', 'When the number of iterations is known or easily determinable at the start.', 'When the loop must execute at least once, regardless of the condition.', 'The \'while\' loop is always preferred for better performance.', 'B', 'The `for` loop is ideal for definite iteration (counter-controlled loops) because it cleanly groups initialization, condition, and increment.', 'https://www.youtube.com/results?search_query=when+to+use+for+loop+vs+while+loop+C'),
(17, 1, 'In the C standard, if you attempt to assign a value to an integer variable that exceeds its maximum capacity (e.g., assigning 300 to a variable only supporting up to 255), what behavior typically occurs?', '', 'The program halts with a runtime error.', 'The compiler issues a warning, but the program continues with the maximum possible value.', 'Integer overflow occurs, causing the value to wrap around to the minimum possible negative number or zero (implementation defined for signed, guaranteed wrap for unsigned).', 'The variable automatically upgrades its data type to a larger size.', 'C', 'Integer overflow in C often results in wrapping around (modulo arithmetic), especially with signed integers, leading to unexpected behavior.', 'https://www.youtube.com/results?search_query=C+integer+overflow+signed+unsigned'),
(18, 1, 'What is the primary purpose of initializing a variable in C?', '', 'To reduce compilation time.', 'To ensure the variable starts with a known, valid value, preventing the use of garbage values.', 'To permanently define its scope as global.', 'To convert its data type.', 'B', 'Uninitialized local variables contain garbage values (whatever was previously in that memory location). Initialization ensures a known starting state.', 'https://www.youtube.com/results?search_query=C+variable+initialization+purpose'),
(19, 1, 'What is the final value of `count`?', 'int count = 10;\nwhile (count > 0) {\n    count /= 2;\n    if (count == 1) break;\n}', '5', '2', '1', '0', 'C', 'Iteration 1: count=10, count becomes 5. Iteration 2: count=5, count becomes 2. Iteration 3: count=2, count becomes 1. Condition (count == 1) is true, loop breaks. Final value of count is 1.', 'https://www.youtube.com/results?search_query=C+while+loop+division+break'),
(20, 1, 'In a `for` loop statement, what is the role of the comma operator (`,`) when placed in the initialization or increment section?', 'for (i=0, j=10; i<j; i++, j--)', 'It indicates the end of the `for` statement, requiring a semicolon (`;`) immediately after.', 'It allows multiple statements (declarations or expressions) to be executed sequentially within that single section.', 'It is used for chaining multiple conditions together.', 'It is invalid syntax in the `for` loop context.', 'B', 'The comma operator is a sequence point that allows multiple independent expressions to be evaluated where the syntax usually expects only one (like the initialization or increment field).', 'https://www.youtube.com/results?search_query=C+comma+operator+in+for+loop'),
(21, 2, 'Which keyword is used to declare a variable that holds whole numbers in C?', '', 'float', 'char', 'int', 'double', 'C', 'The \'int\' data type is used in C to store integer (whole number) values.', 'https://www.youtube.com/results?search_query=C+programming+int+data+type'),
(22, 2, 'What is the initial value of a local variable that is not explicitly initialized in C?', '', '0', '1', 'Garbage value', 'NULL', 'C', 'Local variables (automatic variables) that are not initialized are assigned a garbage (unpredictable) value.', 'https://www.youtube.com/results?search_query=uninitialized+local+variable+c+programming'),
(23, 2, 'Which data type would you use to store the single character \'Z\'?', '', 'string', 'char', 'integer', 'void', 'B', 'The \'char\' data type is used to store a single character.', 'https://www.youtube.com/results?search_query=C+programming+char+data+type'),
(24, 2, 'What is the purpose of the \'for\' loop in C programming?', '', 'To define functions', 'To execute a block of code a specified number of times', 'To declare variables globally', 'To handle input/output operations', 'B', 'The \'for\' loop is an entry-controlled loop used when the number of iterations is known beforehand.', 'https://www.youtube.com/results?search_query=C+programming+for+loop+explained'),
(25, 2, 'Which of the following is a valid variable name in C?', '', '1_count', 'my-variable', 'total_sum', 'for', 'C', 'Variable names cannot start with a digit, cannot contain hyphens, and cannot be reserved keywords (\'for\' is a keyword).', 'https://www.youtube.com/results?search_query=C+programming+variable+naming+rules'),
(26, 2, 'How many times will the following loop execute?', 'for(int i = 0; i < 5; i++) { // body }', '4', '5', '6', '0', 'B', 'The loop starts at i=0 and continues as long as i is less than 5. It executes for i=0, 1, 2, 3, and 4, totaling 5 executions.', 'https://www.youtube.com/results?search_query=C+programming+basic+for+loop+iteration+count'),
(27, 2, 'Which operator is commonly used to increment a loop counter by one?', '', '++', '+=', '--', '=+1', 'A', 'The \'++\' (increment) operator increases the value of a variable by 1.', 'https://www.youtube.com/results?search_query=C+programming+increment+operator'),
(28, 2, 'What is the maximum number of times a \'do-while\' loop\'s body will execute?', '', 'Zero', 'At least one', 'Only once', 'Exactly ten', 'B', 'The \'do-while\' loop is an exit-controlled loop, meaning the condition is checked after the body executes. Therefore, it will always execute at least once.', 'https://www.youtube.com/results?search_query=C+programming+do+while+loop+explanation'),
(29, 2, 'If a variable is declared as \'const int X = 10;\', what does the \'const\' keyword signify?', '', 'The variable must be initialized to 0.', 'The variable can only be used in loops.', 'The value of X cannot be changed after initialization.', 'X is stored in global memory.', 'C', 'The \'const\' keyword defines a constant, meaning its value cannot be modified during program execution.', 'https://www.youtube.com/results?search_query=C+programming+const+keyword+usage'),
(30, 2, 'Which loop structure is best suited when the condition needs to be tested only at the beginning of the loop?', '', 'do-while', 'goto', 'for and while', 'if-else', 'C', 'Both \'for\' and \'while\' loops are entry-controlled loops, testing the condition before the first iteration.', 'https://www.youtube.com/results?search_query=Entry+controlled+loops+C+programming'),
(31, 2, 'What will be the output of the following C code snippet?', 'int i = 5;\nwhile (i < 5) {\n    printf(\"Hello\");\n    i++;\n}', 'HelloHelloHelloHelloHello', 'Hello', 'Error', 'Nothing (empty output)', 'D', 'The condition (i < 5) is false from the start (5 is not less than 5), so the loop body never executes.', 'https://www.youtube.com/results?search_query=C+while+loop+initial+condition+false'),
(32, 2, 'In C, which loop control statement is used to skip the rest of the current iteration and jump to the next iteration?', '', 'break', 'exit', 'continue', 'return', 'C', 'The \'continue\' statement stops the current loop iteration and proceeds to the next iteration (re-evaluating the loop condition).', 'https://www.youtube.com/results?search_query=C+programming+continue+statement'),
(33, 2, 'What is the standard format specifier used in printf() and scanf() for an integer variable?', '', '%f', '%s', '%d', '%c', 'C', 'The \'%d\' format specifier is used for signed decimal integers.', 'https://www.youtube.com/results?search_query=C+programming+format+specifiers+for+integers'),
(34, 2, 'Which data type should be used to store a number with a decimal point, like 3.14159?', '', 'int', 'char', 'void', 'float', 'D', 'The \'float\' data type (or \'double\' for higher precision) is used to store floating-point numbers (numbers with decimal parts).', 'https://www.youtube.com/results?search_query=C+programming+float+data+type'),
(35, 2, 'What will be the value of \'x\' after the following code snippet executes?', 'int x = 10;\n{\n    int x = 20;\n}\n// x is accessed here', '20', '10', 'Error', 'Undefined', 'B', 'The \'x = 20\' is declared in an inner block scope. The original \'x = 10\' remains outside this block and is the value accessible after the block terminates.', 'https://www.youtube.com/results?search_query=C+programming+variable+scope+rules'),
(36, 2, 'In a \'while\' loop, where is the condition checked?', '', 'After the loop body executes', 'Inside the loop body only', 'Before the loop body executes', 'Only when the loop terminates', 'C', 'The \'while\' loop is entry-controlled. The condition is checked at the beginning of each iteration.', 'https://www.youtube.com/results?search_query=C+programming+while+loop+working'),
(37, 2, 'If a variable is declared globally (outside any function), what is its default initial value?', '', 'Garbage value', '1', '0 (or NULL for pointers)', 'It must be explicitly initialized', 'C', 'Global variables (static storage duration) are automatically initialized to zero if not explicitly initialized by the programmer.', 'https://www.youtube.com/results?search_query=C+programming+default+initialization+of+global+variables'),
(38, 2, 'Which C keyword is used to permanently exit a loop (for, while, or do-while) or switch statement?', '', 'goto', 'continue', 'stop', 'break', 'D', 'The \'break\' statement immediately terminates the innermost enclosing loop or switch statement.', 'https://www.youtube.com/results?search_query=C+programming+break+statement+in+loops'),
(39, 2, 'What is the term for a variable defined inside a function or a block, making it only accessible within that scope?', '', 'Global variable', 'Automatic variable', 'External variable', 'Constant variable', 'B', 'Variables declared inside a function or block are typically automatic (local) variables, accessible only within their defined scope.', 'https://www.youtube.com/results?search_query=C+programming+automatic+variable+scope'),
(40, 2, 'Considering the precedence and associativity, what is the final value of \'count\'?', 'int count = 1;\ncount = count + 2 * 3;', '7', '9', '6', '10', 'A', 'Multiplication (2 * 3 = 6) is executed before addition. So, count = 1 + 6, resulting in 7.', 'https://www.youtube.com/results?search_query=C+programming+operator+precedence+multiplication+addition'),
(41, 3, 'Which keyword, introduced in ES6, is preferred for declaring variables that are block-scoped and can be reassigned later in the code?', '', 'var', 'const', 'let', 'scope', 'C', '`let` provides block scoping and allows reassignment, unlike `const` (which prevents reassignment) and `var` (which is function-scoped).', 'https://www.youtube.com/results?search_query=javascript+let+vs+var+vs+const'),
(42, 3, 'What happens if you try to declare a constant using the `const` keyword and then attempt to assign it a new value later?', 'const PI = 3.14; PI = 3.14159;', 'It throws a TypeError.', 'The value is updated silently.', 'The variable is re-declared using `var` automatically.', 'It issues a warning but allows the change.', 'A', '`const` variables must be initialized upon declaration and cannot be reassigned; doing so results in a TypeError.', 'https://www.youtube.com/results?search_query=javascript+const+reassignment+error'),
(43, 3, 'Variables declared using the `var` keyword in JavaScript are primarily scoped to which level?', '', 'Block scope (within { } brackets)', 'Function scope or global scope', 'File scope', 'Loop scope only', 'B', '`var` is function-scoped, meaning it is visible throughout the entire function, or globally if declared outside any function.', 'https://www.youtube.com/results?search_query=javascript+var+scope'),
(44, 3, 'What is the output of the following code snippet?', 'let x = 10; { let x = 20; } console.log(x);', '10', '20', 'undefined', 'Error', 'A', 'The `let` variable inside the block `{}` is block-scoped and does not affect the value of the `x` declared outside the block.', 'https://www.youtube.com/results?search_query=javascript+let+block+scope+example'),
(45, 3, 'In JavaScript, what is the term for the mechanism where variable and function declarations are processed before any code is executed?', '', 'Interpretation', 'Compilation', 'Hoisting', 'Scoping', 'C', 'Hoisting is the conceptual mechanism where declarations are moved to the top of their scope before execution.', 'https://www.youtube.com/results?search_query=what+is+javascript+hoisting'),
(46, 3, 'Which operator is used in JavaScript to determine the data type of a variable or an expression?', '', 'typeof', 'typeOf', 'datatype', 'checkType', 'A', 'The `typeof` operator returns a string indicating the data type of its unevaluated operand.', 'https://www.youtube.com/results?search_query=javascript+typeof+operator+usage'),
(47, 3, 'JavaScript is an example of a dynamically typed language. What does \'dynamically typed\' primarily mean?', '', 'Variable types must be declared explicitly before assignment.', 'Variable types are checked and enforced during compilation.', 'Variable types are checked during runtime and can change during execution.', 'The language only supports numeric types.', 'C', 'Dynamic typing means that the type checking occurs during runtime, and a single variable can hold values of different types over time.', 'https://www.youtube.com/results?search_query=dynamic+vs+static+typing+javascript'),
(48, 3, 'What will the console output for the following code?', 'let myVar; console.log(myVar);', 'null', 'undefined', 'Error', '0', 'B', 'If a variable is declared but not initialized, it defaults to the value `undefined`.', 'https://www.youtube.com/results?search_query=javascript+undefined+variable'),
(49, 3, 'Which of the following data types is NOT considered a primitive type in JavaScript?', '', 'string', 'number', 'object', 'boolean', 'C', 'Primitives include string, number, boolean, null, undefined, symbol, and BigInt. Objects and Arrays are reference types.', 'https://www.youtube.com/results?search_query=javascript+primitive+data+types'),
(50, 3, 'Which of the following is an invalid JavaScript variable name?', '', 'myVariable_1', '$count', '1stName', '_temp', 'C', 'Variable names cannot start with a digit. They must start with a letter, underscore (_), or dollar sign ($).', 'https://www.youtube.com/results?search_query=javascript+variable+naming+rules'),
(51, 3, 'A standard JavaScript `for` loop contains three required expressions inside its parentheses: Initialization, Condition, and what else?', 'for (initialization; condition; ???)', 'Scope Definition', 'Exit Statement', 'Increment/Decrement (Final Expression)', 'Return Value', 'C', 'The three parts are: Initialization (runs once), Condition (checked before each iteration), and Final Expression (runs after each iteration, usually for increment/decrement).', 'https://www.youtube.com/results?search_query=javascript+for+loop+structure'),
(52, 3, 'How many times will the `console.log` statement execute in the following loop?', 'for (let i = 0; i < 4; i++) { console.log(i); }', '3', '4', '5', 'Infinite times', 'B', 'The loop runs when i=0, i=1, i=2, and i=3. It stops when i becomes 4. Total 4 executions.', 'https://www.youtube.com/results?search_query=javascript+for+loop+counting+examples'),
(53, 3, 'What is the final output of the variable `count`?', 'let count = 0; for (let i = 0; i < 3; i++) { count++; } console.log(count);', '0', '2', '3', '4', 'C', 'The loop runs for i=0, i=1, and i=2. The counter increments 3 times (0 -> 1 -> 2 -> 3).', 'https://www.youtube.com/results?search_query=javascript+loop+iteration+output'),
(54, 3, 'A `while` loop continues to execute its block of code as long as its specified condition remains:', '', 'Falsy', 'True', 'Undefined', 'Null', 'B', 'Both `for` and `while` loops execute their bodies as long as the condition evaluates to `true`.', 'https://www.youtube.com/results?search_query=javascript+while+loop+condition'),
(55, 3, 'What is the primary difference between a `while` loop and a `do...while` loop?', '', 'A `while` loop checks the condition after the first iteration.', 'A `do...while` loop checks the condition after the first iteration, guaranteeing at least one execution.', 'A `do...while` loop is used only for arrays.', 'A `while` loop is always faster.', 'B', 'The `do...while` loop always executes the code block once before checking the condition.', 'https://www.youtube.com/results?search_query=javascript+do+while+loop+vs+while+loop'),
(56, 3, 'What is the final value of `x` after the following loop executes?', 'let x = 5; while (x < 10) { x += 3; } console.log(x);', '8', '10', '11', 'Error', 'C', 'x starts at 5. Iteration 1: x becomes 8 (8 < 10 is true). Iteration 2: x becomes 11 (11 < 10 is false). The loop terminates, and 11 is logged.', 'https://www.youtube.com/results?search_query=javascript+while+loop+output+calculation'),
(57, 3, 'What is the output of the variable `x`? (Focus on the `break` statement)', 'let x = 0; for (let i = 1; i < 5; i++) { if (i == 3) { break; } x += i; } console.log(x);', '10', '3', '6', '4', 'B', 'The loop runs for i=1 (x=1). It runs for i=2 (x=1+2=3). When i=3, the `break` statement exits the loop immediately. Final x is 3.', 'https://www.youtube.com/results?search_query=javascript+loop+break+statement+example'),
(58, 3, 'What does the `continue` keyword do when used inside a loop in JavaScript?', '', 'Stops the entire loop execution permanently.', 'Stops the entire program execution.', 'Skips the current iteration and moves to the next iteration of the loop.', 'Restarts the loop from the beginning.', 'C', 'The `continue` statement skips the rest of the code in the current iteration and proceeds immediately to the next loop iteration (or the update step in a `for` loop).', 'https://www.youtube.com/results?search_query=javascript+continue+keyword'),
(59, 3, 'What is the final value of `result`? (Focus on the `continue` statement)', 'let result = 0; for (let j = 1; j <= 3; j++) { if (j === 2) { continue; } result += j; } console.log(result);', '6', '5', '4', '3', 'C', 'j=1: result = 1. j=2: skips addition due to `continue`. j=3: result = 1 + 3 = 4. Final result is 4.', 'https://www.youtube.com/results?search_query=javascript+loop+continue+output'),
(60, 3, 'Which loop is best suited for iterating directly over the values of an iterable object, such as an Array or String?', '', 'for...in', 'while', 'do...while', 'for...of', 'D', 'The `for...of` loop is specifically designed to iterate over iterable values (data contained within the structure). `for...in` iterates over object properties/keys.', 'https://www.youtube.com/results?search_query=javascript+for+of+loop+purpose'),
(61, 4, 'Which of the following is the correct syntax to declare and initialize an integer variable \'count\' with the value 10 in C?', '', 'int count = 10;', 'count int = 10;', 'integer count(10);', 'var count: 10;', 'A', 'In C, variable declaration requires the data type followed by the variable name, optionally followed by initialization using the assignment operator (=).', 'https://www.youtube.com/results?search_query=C+variable+declaration+and+initialization+syntax'),
(62, 4, 'What is the primary difference between a \'while\' loop and a \'do-while\' loop in C?', '', 'The \'while\' loop executes the body at least once, while \'do-while\' checks the condition first.', 'The \'do-while\' loop always executes the body at least once, while \'while\' may not.', 'The \'while\' loop is used for definite iterations, and \'do-while\' for indefinite ones.', 'There is no functional difference; they are interchangeable.', 'B', 'The \'do-while\' loop checks the condition after executing the body, ensuring the body runs at least once. The \'while\' loop checks the condition before the first execution.', 'https://www.youtube.com/results?search_query=while+vs+do-while+loop+C'),
(63, 4, 'What is the scope of a variable declared inside the initialization part of a \'for\' loop (e.g., for(int i=0; ...)) in standard C?', 'for(int i=0; i<5; i++) {\\n  // i is visible here\\n}', 'Global scope', 'Function scope', 'Block scope (visible only within the loop body and the loop control structure)', 'File scope', 'C', 'Variables declared within the initialization expression of a \'for\' loop have block scope, meaning they are only valid within the loop structure itself.', 'https://www.youtube.com/results?search_query=scope+of+variable+in+C+for+loop'),
(64, 4, 'Consider the following C code snippet. What will be the final value of the variable \'x\'?', 'int x = 5;\\nfloat y = 2.5;\\nx = x + (int)y;\\n', '5', '7.5', '7', '8', 'C', 'The float \'y\' (2.5) is explicitly cast to an integer (2). Then, x (5) + 2 equals 7. The result is stored back in the integer variable \'x\'.', 'https://www.youtube.com/results?search_query=C+type+casting+in+arithmetic+operations'),
(65, 4, 'How many times will the following \'for\' loop execute its body?', 'for (int i = 1; i <= 5; i++);\\n{\\n  printf(\"Hello\");\\n}', '5 times', 'Infinite times', '1 time', '0 times', 'C', 'The semicolon immediately after the loop header (i.e., \'for (...) ;\') makes the loop body an empty statement. The printf statement is outside the loop and executes exactly once after the loop finishes (i becomes 6).', 'https://www.youtube.com/results?search_query=semicolon+after+for+loop+header+C'),
(66, 4, 'Which data type should be generally used in C to store large whole numbers that might exceed the range of a standard \'int\' (e.g., population count)?', '', 'char', 'float', 'long long int', 'short int', 'C', '\'long long int\' provides the largest guaranteed range for integer storage in standard C (at least 64 bits), suitable for very large whole numbers.', 'https://www.youtube.com/results?search_query=C+data+types+for+large+integers'),
(67, 4, 'What is the purpose of the \'continue\' statement inside a loop in C?', '', 'To terminate the loop entirely.', 'To skip the rest of the current iteration and proceed to the next iteration.', 'To exit the function where the loop is located.', 'To restart the loop from the beginning (resetting loop variables).', 'B', 'The \'continue\' statement immediately stops the execution of the current loop iteration and moves control to the loop control mechanism (condition check/update) for the next iteration.', 'https://www.youtube.com/results?search_query=C+continue+statement+in+loops'),
(68, 4, 'What is the output of the following nested loop structure?', 'for (int i = 0; i < 2; i++) {\\n  for (int j = 0; j < 3; j++) {\\n    printf(\"%d%d \", i, j);\\n  }\\n}', '00 01 02 10 11 12 ', '00 11 22 ', '00 01 10 11 20 21 ', '12 11 10 02 01 00 ', 'A', 'The outer loop runs for i=0 and i=1. For each outer iteration, the inner loop runs for j=0, 1, 2. Output sequence: (0,0), (0,1), (0,2), (1,0), (1,1), (1,2).', 'https://www.youtube.com/results?search_query=C+nested+loop+execution+trace'),
(69, 4, 'If a variable is declared using the \'static\' keyword within a function, what characteristic does it gain?', '', 'It can only be accessed by other functions.', 'Its value persists between function calls.', 'It is stored in the stack memory.', 'It is initialized every time the function is called.', 'B', 'A static local variable retains its value between multiple calls to the function where it is declared, as it is stored in the data segment, not the stack.', 'https://www.youtube.com/results?search_query=C+static+variable+scope+and+lifetime'),
(70, 4, 'Which operator is used in C to find the remainder of an integer division?', '', '/', '*', '%', '//', 'C', 'The modulus operator (%) calculates the remainder when one integer is divided by another.', 'https://www.youtube.com/results?search_query=C+modulus+operator'),
(71, 4, 'What is the output of the following code snippet?', 'int k = 0;\\nwhile (k < 5) {\\n  if (k == 3) { break; }\\n  k++;\\n  printf(\"%d\", k);\\n}', '12345', '123', '12', '0123', 'C', 'k starts at 0. Iteration 1: k becomes 1, print 1. Iteration 2: k becomes 2, print 2. Iteration 3: k=2. k becomes 3. Check k==3, break. Output is 12.', 'https://www.youtube.com/results?search_query=C+while+loop+with+break+statement'),
(72, 4, 'Which type of loop is best suited when the number of iterations is known before the loop starts?', '', 'while loop', 'do-while loop', 'for loop', 'goto loop', 'C', 'The \'for\' loop is conventionally used for counter-controlled or definite iteration where the number of repetitions is predetermined.', 'https://www.youtube.com/results?search_query=choosing+the+right+loop+C+programming'),
(73, 4, 'In C programming, what typically happens when an integer variable overflows (e.g., trying to store a value larger than INT_MAX)?', '', 'The program crashes.', 'The compiler issues an error.', 'The variable wraps around to the minimum negative value (or 0, depending on implementation/signedness).', 'It is automatically promoted to a \'long\' integer.', 'C', 'Signed integer overflow results in undefined behavior, but typically, on most architectures, the value \'wraps around\' (modular arithmetic). Unsigned integer overflow is guaranteed to wrap around.', 'https://www.youtube.com/results?search_query=C+integer+overflow+behavior'),
(74, 4, 'What is the result of the following assignment operation, given standard C integer promotion rules?', 'int a = 10;\\nint b = 3;\\nfloat result = a / b;', '3.333333', '3.0', '4.0', '3', 'B', 'The division \'a / b\' is performed as integer division (10 / 3 = 3) before being assigned to the float \'result\'. The integer 3 is then implicitly promoted to 3.0f.', 'https://www.youtube.com/results?search_query=C+integer+division+assignment+to+float'),
(75, 4, 'Which keyword is used to conditionally execute a block of code based on an expression, offering an alternative to long \'if-else if\' chains for integer values?', '', 'while', 'case', 'switch', 'goto', 'C', 'The \'switch\' statement is designed for multi-way branching based on the value of a single variable, typically an integer or character.', 'https://www.youtube.com/results?search_query=C+switch+statement+usage'),
(76, 4, 'If a variable \'x\' is declared globally (outside all functions), what is its default initial value if not explicitly assigned?', 'int x;\\nint main() { ... }', 'Undefined/Garbage value', '1', '0', '-1', 'C', 'Global variables (static storage duration) are automatically initialized to zero by the compiler if no explicit initializer is provided.', 'https://www.youtube.com/results?search_query=C+global+variable+default+initialization'),
(77, 4, 'Consider the following loop structure. What is the value of \'i\' immediately after the loop terminates?', 'int i = 0;\\ndo {\\n  i++;\\n} while (i < 0);', '0', '1', 'Undefined', '-1', 'B', 'The \'do-while\' loop executes the body once before checking the condition. \'i\' becomes 1. Then the condition (1 < 0) is false, and the loop terminates.', 'https://www.youtube.com/results?search_query=C+do-while+loop+termination+condition'),
(78, 4, 'Which data type in C is typically 1 byte in size and used to store ASCII characters?', '', 'short', 'int', 'char', 'float', 'C', 'The \'char\' data type is typically 1 byte (8 bits) and is used to store characters, though it can also be used for small integer values.', 'https://www.youtube.com/results?search_query=C+char+data+type+size+and+usage'),
(79, 4, 'What is the primary function of a loop control variable?', '', 'To store the final result of the loop calculation.', 'To determine when the loop should terminate or continue.', 'To define the data type used inside the loop body.', 'To ensure that floating-point arithmetic is used.', 'B', 'The loop control variable (e.g., \'i\' in a \'for\' loop) is essential for managing the iteration count and evaluating the loop\'s termination condition.', 'https://www.youtube.com/results?search_query=purpose+of+loop+control+variable'),
(80, 4, 'If you define a variable \'pi\' as \'const float pi = 3.14;\' in C, what does the \'const\' keyword signify?', '', 'The variable must be initialized to 3.14 later in the code.', 'The variable\'s value cannot be modified after initialization.', 'The variable is stored in read-only memory (ROM).', 'The variable is only visible within the current function.', 'B', 'The \'const\' keyword creates a variable whose value is read-only; attempts to change it after initialization will result in a compiler error or warning.', 'https://www.youtube.com/results?search_query=C+const+keyword+meaning+and+use'),
(81, 5, 'What is the primary difference in scoping behavior between `var` and `let` declarations in JavaScript?', '', '`var` is block-scoped, while `let` is function-scoped.', '`var` is function-scoped (or global), while `let` is block-scoped.', 'Both `var` and `let` are block-scoped, but `let` does not hoist.', '`let` is hoisted to the top of the file, while `var` is not hoisted.', 'B', '`var` has function scope or global scope. `let` (and `const`) introduced block scoping (limited to the nearest curly braces).', 'https://www.youtube.com/results?search_query=JavaScript+var+vs+let+scoping'),
(82, 5, 'Consider the hoisting behavior in JavaScript. What will be the output of the following code snippet?', 'console.log(x);\nvar x = 10;', 'ReferenceError: x is not defined', '10', 'undefined', 'null', 'C', 'Due to hoisting, the declaration `var x` is moved to the top of its scope, but the initialization (`= 10`) stays put. The variable exists but is initialized to `undefined` before the `console.log` executes.', 'https://www.youtube.com/results?search_query=JavaScript+var+hoisting+output+example'),
(83, 5, 'Which of the following JavaScript loop structures guarantees that the body of the loop executes at least once, regardless of the initial condition?', '', 'for loop', 'while loop', 'for...in loop', 'do...while loop', 'D', 'The `do...while` loop checks the condition *after* executing the loop body. Thus, it always runs a minimum of one time.', 'https://www.youtube.com/results?search_query=JavaScript+loop+structure+executes+at+least+once'),
(84, 5, 'In JavaScript, if you declare a variable using `const` and it holds an object, what does `const` prevent?', '', 'Modification of any property within the object.', 'The variable from being reassigned to a different object or primitive value.', 'The object\'s properties from being deleted.', 'The object from being passed by reference.', 'B', '`const` ensures that the variable\'s binding (the reference) cannot be changed. However, if the variable holds an object, the contents (properties) of that object can still be mutated.', 'https://www.youtube.com/results?search_query=JavaScript+const+object+immutability'),
(85, 5, 'What is the primary purpose of the `for...in` loop in JavaScript?', '', 'To iterate over the values of an iterable object (like an Array).', 'To iterate over the property names (keys) of an object.', 'To provide a standard counting loop structure.', 'To iterate over the key-value pairs of a Map.', 'B', 'The `for...in` loop is designed to enumerate the string keys (property names) of an object. For iterating over values of arrays, `for...of` or standard `for` loops are preferred.', 'https://www.youtube.com/results?search_query=JavaScript+difference+between+for+in+and+for+of'),
(86, 5, 'What will be the value of `result` after the following code executes?', 'let result = 10;\n{\n  let result = 20;\n  result = result + 5;\n}\nresult = result + 1;', '26', '21', '30', '11', 'D', 'The `result` inside the block `{}` is block-scoped (`let`), shadowing the outer `result`. The outer `result` remains 10 and is then incremented by 1.', 'https://www.youtube.com/results?search_query=JavaScript+let+variable+shadowing+example'),
(87, 5, 'How many times will the console log execute?', 'let i = 0;\nwhile (i < 5) {\n  if (i === 3) {\n    break;\n  }\n  console.log(i);\n  i++;\n}', '5 times', '4 times', '3 times', 'Infinite times', 'C', 'The loop executes for i=0, i=1, and i=2. When i becomes 3, the `break` statement executes, terminating the loop immediately. (0, 1, 2 logged).', 'https://www.youtube.com/results?search_query=JavaScript+break+keyword+in+while+loop'),
(88, 5, 'What is the key reason that using `var` inside a `for` loop combined with an asynchronous function (like `setTimeout`) is considered a common JavaScript pitfall?', 'for (var i = 0; i < 5; i++) {\n  setTimeout(() => console.log(i), 10);\n}', 'The loop executes too quickly for `setTimeout` to register the correct values.', 'The `var` declaration creates a new block scope for each iteration.', '`var` is function-scoped, meaning the variable `i` is shared across all loop iterations, and the asynchronous callbacks only see the final value of `i`.', '`setTimeout` requires `let` or `const` to function correctly inside loops.', 'C', 'Since `var` is function-scoped, all five instances of the `setTimeout` callback reference the *same* variable `i`. By the time the timeouts execute, the loop has finished and `i` has reached its final value (5).', 'https://www.youtube.com/results?search_query=JavaScript+closure+pitfall+var+in+loop'),
(89, 5, 'Which statement about `const` is FALSE?', '', '`const` variables must be assigned a value when declared.', '`const` variables are block-scoped.', 'Reassignment of a primitive `const` variable throws a TypeError.', '`const` variables are subject to temporal dead zone but are fully hoisted.', 'D', '`const` (like `let`) is subject to the Temporal Dead Zone (TDZ) and is partially hoisted (the declaration is known, but accessing it before initialization results in a ReferenceError), unlike `var` which is fully hoisted.', 'https://www.youtube.com/results?search_query=JavaScript+const+hoisting+and+TDZ'),
(90, 5, 'What value will `sum` hold after the following loop completes?', 'let sum = 0;\nfor (let i = 0; i < 4; i++) {\n  if (i === 1) {\n    continue;\n  }\n  sum = sum + i;\n}', '3', '5', '6', '7', 'B', 'The loop iterates for i=0, 1, 2, 3. When i=1, the `continue` statement skips the addition. Sum = 0 (i=0) + 2 (i=2) + 3 (i=3) = 5.', 'https://www.youtube.com/results?search_query=JavaScript+continue+keyword+sum+calculation'),
(91, 5, 'If you are iterating over an Array named `data` and need access to the elements themselves, which loop is the most modern and semantically appropriate choice in ES6+?', '', 'for (let i in data) { ... }', 'for (let element of data) { ... }', 'while (data.length > 0) { ... }', 'data.forEach((element) => { ... })', 'B', 'The `for...of` loop is specifically designed to iterate directly over the values of iterable collections (like Arrays, Maps, Sets, and Strings). While `forEach` is also common, `for...of` works well with `break` and `continue`.', 'https://www.youtube.com/results?search_query=JavaScript+best+loop+for+array+elements'),
(92, 5, 'Consider the condition for a standard `for` loop: `for (initialization; condition; increment)`. When is the `condition` expression evaluated?', '', 'Only once, before the loop starts.', 'After the `increment` step in every iteration, and before the loop body.', 'Before the loop body in every iteration.', 'After the loop body in every iteration.', 'C', 'The condition is checked at the beginning of every iteration. If it evaluates to false, the loop terminates immediately, otherwise the body executes.', 'https://www.youtube.com/results?search_query=JavaScript+for+loop+condition+evaluation+timing'),
(93, 5, 'What will the following code snippet output?', 'let count = 5;\nwhile (--count) {\n  console.log(count);\n}', '5, 4, 3, 2, 1', '4, 3, 2, 1, 0', '4, 3, 2, 1', '5, 4, 3, 2', 'C', 'The pre-decrement `--count` happens before the value is checked by `while`. Iteration 1: count becomes 4 (True). Iteration 4: count becomes 1 (True). Iteration 5: count becomes 0 (False - loop terminates). Output: 4, 3, 2, 1.', 'https://www.youtube.com/results?search_query=JavaScript+while+loop+pre-decrement+condition'),
(94, 5, 'In strict mode, which variable declaration type, when used outside of any function scope, does NOT attach the variable as a property of the global object (`window` or `global`)?', '', '`var` only', '`let` and `const` only', 'All three (`var`, `let`, `const`)', 'Only variables declared implicitly (without `var`, `let`, or `const`)', 'B', 'In modern JS and strict mode, `let` and `const` variables are block-scoped and do not pollute the global object. `var`, even in global scope, historically added properties to the global object (though this behavior is less reliable/consistent in modern module systems).', 'https://www.youtube.com/results?search_query=JavaScript+global+scope+pollution+var+let+const'),
(95, 5, 'What is the result of the variable `j` after the loop completes?', 'let j = 0;\nfor (let i = 0; i < 3; i++) {\n  j = i;\n}\nconsole.log(j);', '0', '2', '3', 'ReferenceError', 'B', 'The loop runs for i=0, 1, and 2. In the final iteration (i=2), `j` is set to 2. The loop then stops because i=3 fails the condition. `j` is declared outside the loop using `let`, so it retains its last assigned value.', 'https://www.youtube.com/results?search_query=JavaScript+for+loop+variable+assignment+tracking'),
(96, 5, 'Which of the following is NOT a valid JavaScript variable identifier name?', '', '$count', '_status', 'user_name_99', '1stAttempt', 'D', 'Variable names in JavaScript cannot start with a digit. They must begin with a letter, an underscore (_), or a dollar sign ($).', 'https://www.youtube.com/results?search_query=JavaScript+variable+naming+rules'),
(97, 5, 'If an array `arr` is declared using `const`, which operation will cause an error?', 'const arr = [1, 2, 3];', 'arr[0] = 5;', 'arr.push(4);', 'arr = [4, 5, 6];', 'arr.pop();', 'C', 'The `const` declaration prevents reassignment of the array variable itself (changing the pointer/reference). Modifying the contents of the array (A, B, D) is permissible.', 'https://www.youtube.com/results?search_query=JavaScript+const+array+reassignment'),
(98, 5, 'What mechanism does JavaScript use to protect `let` and `const` variables from access before they are fully initialized?', '', 'Strict Mode Restriction', 'Global Execution Context Lock', 'Lexical Scope Control', 'Temporal Dead Zone (TDZ)', 'D', 'The Temporal Dead Zone (TDZ) is the period between the start of the block scope and when `let`/`const` variables are initialized. Accessing them during this time results in a ReferenceError.', 'https://www.youtube.com/results?search_query=JavaScript+Temporal+Dead+Zone+explanation'),
(99, 5, 'Identify the primary reason why the following loop structure results in an infinite loop.', 'let counter = 0;\nwhile (counter < 5) {\n  console.log(counter);\n}', 'The loop condition is complex.', 'The condition uses a loose inequality operator.', 'The variable `counter` is never updated (incremented or decremented) within the loop body.', 'The use of `let` causes hoisting issues.', 'C', 'Since `counter` remains 0, the condition `counter < 5` always evaluates to true, causing the loop to run indefinitely.', 'https://www.youtube.com/results?search_query=Identify+infinite+loop+JavaScript+while'),
(100, 5, 'Which method of iteration is typically used to iterate over the items of an iterable object (like a String or an Array) and returns the index/key as a string?', '', 'for...of', 'for (traditional)', 'for...in', 'Array.prototype.map()', 'C', '`for...in` returns the indices (which are strings) when used on arrays, or keys when used on objects. This is generally discouraged for arrays but is the defined behavior for returning keys/indices as strings.', 'https://www.youtube.com/results?search_query=JavaScript+loop+returns+index+as+string'),
(121, 7, 'In C programming, what is the scope of a variable declared within the initialization part of a standard `for` loop (e.g., `for (int i = 0; ...)`)?', '', 'It is local only to the body of the loop.', 'It is local to the function where the loop resides.', 'It is a global variable.', 'Its scope extends until the end of the program file.', 'A', 'In modern C standards (C99 and later), variables declared in the `for` loop initialization are typically block-scoped, meaning they are only accessible within the loop structure itself.', 'https://www.youtube.com/results?search_query=C+variable+scope+in+for+loop'),
(122, 7, 'What is the primary effect when an integer variable is assigned a floating-point value (e.g., `int x = 5.99;`) in C?', 'int x = 5.99;', 'Rounding up (x becomes 6).', 'Truncation (the fractional part is discarded, x becomes 5).', 'A compilation error occurs due to type mismatch.', 'Automatic conversion to the nearest float type.', 'B', 'When assigning a float to an int, C performs truncation, discarding the digits after the decimal point without rounding.', 'https://www.youtube.com/results?search_query=C+implicit+type+conversion+float+to+int'),
(123, 7, 'Which of the following parts of the standard C `for` loop statement can be entirely omitted without causing a syntax error (assuming the semicolons are retained)?', 'for (expr1; expr2; expr3) {}', 'Only the initialization expression (expr1).', 'Only the increment/decrement expression (expr3).', 'Only the condition expression (expr2).', 'All three expressions (expr1, expr2, and expr3).', 'D', 'While omitting the condition (expr2) results in an infinite loop, syntactically, all three expressions in the `for` loop header are optional, provided the two separating semicolons remain.', 'https://www.youtube.com/results?search_query=C+for+loop+optional+parts'),
(124, 7, 'What will be the output of the following C code snippet?', 'int i; for (i = 0; i < 5; i++) { if (i == 2) continue; printf(\"%d\", i); }', '01234', '01', '1234', '0134', 'D', 'When i = 2, the `continue` statement skips the `printf` and proceeds immediately to the increment step (i++). Thus, 2 is skipped in the output.', 'https://www.youtube.com/results?search_query=C+for+loop+continue+output+tracing');
INSERT INTO `exam_questions` (`id`, `exam_id`, `question_text`, `code_snippet`, `opt_a`, `opt_b`, `opt_c`, `opt_d`, `correct_ans`, `explanation`, `video_link`) VALUES
(125, 7, 'What will be printed by the following `while` loop?', 'int x = 3; while (x--) { printf(\"%d\", x); }', '321', '3210', '210', '10', 'C', 'The condition `x--` uses the current value of x (3, 2, 1) for the condition check, but decrements x *before* the loop body executes completely (or right after the check). Inside the loop, the already decremented value (2, 1, 0) is printed. The loop terminates when x-- evaluates to 0 (after printing 0).', 'https://www.youtube.com/results?search_query=C+while+loop+post+decrement+condition+output'),
(126, 7, 'The `break` statement inside a nested loop structure causes control to transfer to which location?', '', 'The beginning of the outermost loop.', 'The beginning of the current loop\'s next iteration.', 'The statement immediately following the current loop\'s body.', 'The statement immediately following the outermost loop\'s body.', 'C', 'The `break` statement only terminates the innermost loop it is contained within. Control passes to the statement immediately following that specific loop.', 'https://www.youtube.com/results?search_query=C+break+statement+in+nested+loops'),
(127, 7, 'Which type of loop in C guarantees that the loop body will execute at least once, regardless of the loop condition?', '', 'The `for` loop.', 'The `if-else` statement.', 'The `while` loop.', 'The `do-while` loop.', 'D', 'In a `do-while` loop, the body executes first, and the condition is checked at the end of the iteration, guaranteeing at least one execution.', 'https://www.youtube.com/results?search_query=C+do-while+loop+characteristics'),
(128, 7, 'Consider the following assignments. If `x = 10;` and then `y = x++;`, what are the final values of `x` and `y`?', 'int x = 10; int y = x++;', 'x = 11, y = 10', 'x = 11, y = 11', 'x = 10, y = 11', 'x = 10, y = 10', 'A', 'The post-increment operator (x++) means the original value of x (10) is assigned to y first. Then, x is incremented to 11.', 'https://www.youtube.com/results?search_query=C+post+increment+operator+assignment'),
(129, 7, 'What is the output of the following nested loop structure?', 'int i, j; for (i = 1; i <= 2; i++) { for (j = 1; j <= 2; j++) { printf(\"%d\", i); } }', '1212', '1122', '1111', '2211', 'B', 'The outer loop runs for i=1 and i=2. In the inner loop, we print the value of the outer loop variable \'i\'. When i=1, 11 is printed. When i=2, 22 is printed. Total output: 1122.', 'https://www.youtube.com/results?search_query=C+nested+loop+output+tracing'),
(130, 7, 'Which expression for a `for` loop initialization and iteration would typically lead to an infinite loop if the condition is `i <= 10`?', 'int i; for (i = 1; i <= 10; <iteration>) {}', 'i++', 'i += 2', 'i--', 'i = 10', 'C', 'If i starts at 1 and consistently decreases (i--), it will never reach a state where i > 10 (assuming standard integer limits, which are far below 10), causing the condition `i <= 10` to always be true.', 'https://www.youtube.com/results?search_query=C+infinite+loop+conditions'),
(131, 7, 'Which of the following is NOT a valid identifier (variable name) in C?', '', 'my_variable_1', 'whileLoop', '1st_value', '_temp', 'C', 'C identifiers must begin with a letter (A-Z, a-z) or an underscore (_). They cannot start with a digit.', 'https://www.youtube.com/results?search_query=C+valid+variable+naming+rules'),
(132, 7, 'In C, variables of which storage class maintain their value across different function calls and have a lifetime equal to the duration of the entire program?', '', 'auto', 'register', 'static', 'extern', 'C', 'Static variables (whether local or global) are allocated memory for the entire duration of the program, preserving their value between scope exits.', 'https://www.youtube.com/results?search_query=C+storage+class+lifetime+static'),
(133, 7, 'What will be the final output of the following code snippet?', 'int k = 0; while (k < 10) { k++; if (k == 5) break; printf(\"%d\", k); }', '01234', '1234', '12345', '5', 'B', 'The loop runs. When k reaches 5, the `break` statement immediately exits the loop. The values 1, 2, 3, and 4 are printed before k hits 5.', 'https://www.youtube.com/results?search_query=C+while+loop+break+condition+output'),
(134, 7, 'If `int a = 10; float b = 3.0; float result = a / b;`, what is the value stored in `result`?', 'int a = 10; float b = 3.0; float result = a / b;', '3.333333 (approx)', '3.0 (integer division applied first)', '3.5', 'Compilation error.', 'A', 'Since one operand (`b`) is a float, C promotes the integer (`a`) to a float before division, resulting in floating-point division (10.0 / 3.0).', 'https://www.youtube.com/results?search_query=C+type+promotion+in+division'),
(135, 7, 'Which situation makes a `while` loop generally more appropriate than a `for` loop?', '', 'When the loop needs to execute a fixed number of times.', 'When a specific initial value and increment step are required.', 'When the loop condition depends on user input or external factors, making the number of iterations unpredictable.', 'When implementing infinite loops.', 'C', '`while` loops are better suited for conditional iteration where the termination condition is not based on a simple counter (e.g., reading until EOF or until a sentinel value is entered).', 'https://www.youtube.com/results?search_query=when+to+use+C+while+loop+versus+for+loop'),
(136, 7, 'What is the final value of the variable `count` after the execution of the following code?', 'int count = 0; for (int i = 0; i < 3; i++) { int count = 10; count++; }', '13', '0', '11', '10', 'B', 'The inner declaration `int count = 10;` creates a new variable local to the loop body, which shadows the outer `count`. The outer `count` remains 0.', 'https://www.youtube.com/results?search_query=C+variable+shadowing+loop+scope'),
(137, 7, 'When using the comma operator within a `for` loop\'s update expression (e.g., `i++, j--`), how are the expressions evaluated?', 'for (i=0; i<10; i++, j--)', 'They are evaluated simultaneously.', 'They are evaluated from right to left.', 'They are evaluated from left to right, and the result of the entire expression is the result of the rightmost operand.', 'Only the first expression is evaluated; the others are ignored.', 'C', 'The comma operator guarantees left-to-right evaluation. The result of the entire sequence is the value of the rightmost expression.', 'https://www.youtube.com/results?search_query=C+comma+operator+in+for+loop'),
(138, 7, 'How many times will the statement `printf(\"Hello\");` be executed in the following loop?', 'int i = 1; while (i <= 5) { printf(\"Hello\"); i += 2; }', '2 times', '3 times', '4 times', '5 times', 'B', 'i starts at 1. Iterations: 1 (prints, i=3), 2 (prints, i=5), 3 (prints, i=7). The loop terminates when i=7 because 7 <= 5 is false.', 'https://www.youtube.com/results?search_query=C+while+loop+tracing+with+step+increment'),
(139, 7, 'If the expression in the condition section of a `for` loop is entirely omitted (e.g., `for (i=0; ; i++)`), what happens during execution?', 'for (i=0; ; i++) { printf(\"%d\", i); }', 'The loop terminates immediately.', 'The condition defaults to true, creating an infinite loop.', 'A runtime error occurs.', 'It causes a compilation error.', 'B', 'In C, if the conditional expression is omitted in a `for` loop, it is treated as a non-zero constant (true), resulting in an infinite loop.', 'https://www.youtube.com/results?search_query=C+for+loop+missing+condition+behavior'),
(140, 7, 'Which data type is generally used in C to store large whole numbers, offering a guaranteed minimum range usually larger than a standard `int`?', '', 'short int', 'float', 'long long int', 'char', 'C', '`long long int` (standardized in C99) is guaranteed to be at least 64 bits wide, making it suitable for storing very large integer values.', 'https://www.youtube.com/results?search_query=C+data+types+for+large+integers'),
(141, 8, 'What will be the output of the following C code?', '#include <stdio.h>\\nint main() {\\n    int i = 0;\\n    for (; i < 5; i++);\\n    printf(\\\"%d\\\", i);\\n    return 0;\\n}', '4', '5', '0', 'Error', 'B', 'The for loop has a semicolon at the end, making it an empty loop. The loop increments i until the condition i < 5 is false. When i becomes 5, the condition fails and the loop exits. The printf then prints 5.', 'https://www.youtube.com/results?search_query=for+loop+with+semicolon+in+C'),
(142, 8, 'In C, what is the default value of an uninitialized local variable?', '', '0', '1', 'Garbage value', 'Null', 'C', 'Local variables (automatic variables) declared inside a function without initialization contain indeterminate \\\'garbage\\\' values until assigned a value.', 'https://www.youtube.com/results?search_query=C+programming+uninitialized+local+variables'),
(143, 8, 'How many times will the following loop execute?', 'int i = 0;\\nwhile (i = 0) {\\n    printf(\\\"Hello\\\");\\n    i++;\\n}', '0', '1', 'Infinite', 'Error', 'A', 'The condition \\\'i = 0\\\' is an assignment, not a comparison. The result of this expression is 0, which is treated as False in C. Therefore, the loop body never executes.', 'https://www.youtube.com/results?search_query=assignment+vs+equality+in+while+loop+C'),
(144, 8, 'What will be the output of the following code snippet?', 'int a = 10;\\n{\\n    int a = 20;\\n    printf(\\\"%d \\\", a);\\n}\\nprintf(\\\"%d\\\", a);', '10 10', '20 20', '20 10', '10 20', 'C', 'C supports block scope. The variable \\\'a\\\' defined inside the braces shadows the outer \\\'a\\\'. Once the block ends, the outer \\\'a\\\' is back in scope.', 'https://www.youtube.com/results?search_query=Variable+shadowing+and+scope+in+C'),
(145, 8, 'What is the result of the following loop?', 'int x = 5;\\nwhile (x > 0) {\\n    x--;\\n    if (x == 3) continue;\\n    printf(\\\"%d \\\", x);\\n}', '4 2 1 0', '4 3 2 1 0', '5 4 2 1', '4 2 1', 'A', 'When x is 4, it prints. When x becomes 3, \\\'continue\\\' skips the printf and moves to the next iteration. Then 2, 1, and 0 are printed.', 'https://www.youtube.com/results?search_query=continue+statement+in+C+loop'),
(146, 8, 'Which data type is best suited for a loop counter that must handle values up to 1,000,000?', '', 'char', 'short', 'long int', 'unsigned char', 'C', 'A standard \\\'int\\\' usually handles this, but \\\'long int\\\' is guaranteed to hold values up to at least 2,147,483,647. \\\'char\\\' and \\\'short\\\' have smaller ranges.', 'https://www.youtube.com/results?search_query=C+data+types+ranges'),
(147, 8, 'What will be printed by the following code?', 'int i = 1;\\ndo {\\n    printf(\\\"%d \\\", i++);\\n} while (i <= 3);', '1 2 3', '2 3 4', '1 2', '0 1 2', 'A', 'The do-while loop executes at least once. It prints \\\'i\\\' and then increments it. Output: 1 (i becomes 2), 2 (i becomes 3), 3 (i becomes 4). Condition 4 <= 3 is false.', 'https://www.youtube.com/results?search_query=do+while+loop+in+C'),
(148, 8, 'What is the output of this code?', 'int x = 1, y = 1;\\nfor (; x < 3; x++, y++) {\\n    printf(\\\"%d %d \\\", x, y);\\n}', '1 1 2 2', '1 1 2 2 3 3', '2 2 3 3', '1 1', 'A', 'The loop starts with x=1, y=1. Prints \\\'1 1\\\'. Increments both to 2. Condition 2 < 3 is true. Prints \\\'2 2\\\'. Increments both to 3. Condition 3 < 3 is false. Loop ends.', 'https://www.youtube.com/results?search_query=comma+operator+in+for+loop+C'),
(149, 8, 'Which of the following is true about a \\\'static\\\' variable declared inside a loop?', '', 'It is re-initialized in every iteration.', 'It retains its value between iterations and function calls.', 'It results in a compilation error.', 'It is stored in the stack memory.', 'B', 'Static variables are initialized only once and persist for the duration of the program. However, they are usually declared at the function level, not inside loop blocks for clarity, but they still retain value.', 'https://www.youtube.com/results?search_query=static+variables+in+C+programming'),
(150, 8, 'What will happen if the condition in a for loop is omitted, like for(;;)?', '', 'Syntax error', 'The loop will not execute', 'The loop will execute once', 'The loop will run infinitely', 'D', 'In C, if the condition part of the for loop is empty, it is treated as always true, creating an infinite loop.', 'https://www.youtube.com/results?search_query=infinite+for+loop+in+C'),
(151, 8, 'What is the output of the following code?', 'int i = 0;\\nwhile (i++ < 2) {\\n    printf(\\\"%d \\\", i);\\n}', '0 1', '1 2', '0 1 2', '1 2 3', 'B', 'Post-increment \\\'i++\\\' uses the current value for comparison and then increments. Iteration 1: uses 0 (0<2), increments i to 1, prints 1. Iteration 2: uses 1 (1<2), increments i to 2, prints 2. Iteration 3: uses 2 (2<2 is false).', 'https://www.youtube.com/results?search_query=post+increment+in+while+loop+condition+C'),
(152, 8, 'Which keyword is used to transfer control out of a loop immediately?', '', 'exit', 'default', 'break', 'return', 'C', 'The \\\'break\\\' keyword is used to terminate the nearest enclosing loop or switch statement immediately.', 'https://www.youtube.com/results?search_query=break+vs+continue+in+C'),
(153, 8, 'What will be the output of this code?', 'int i = 10;\\nwhile (i > 0) {\\n    i -= 3;\\n}\\nprintf(\\\"%d\\\", i);', '1', '0', '-1', '-2', 'D', 'i starts at 10. Steps: 10-3=7, 7-3=4, 4-3=1, 1-3=-2. Since -2 is not > 0, the loop stops and prints -2.', 'https://www.youtube.com/results?search_query=while+loop+iteration+tracing'),
(154, 8, 'In a for loop, which expression is executed only once?', 'for(expr1; expr2; expr3)', 'expr1', 'expr2', 'expr3', 'None', 'A', 'expr1 is the initialization expression, which is executed only once at the start of the loop.', 'https://www.youtube.com/results?search_query=for+loop+execution+flow+C'),
(155, 8, 'What is the output of the following?', 'int k = 0;\\nfor (k = 0; k < 3; k++);\\n{\\n    printf(\\\"%d\\\", k);\\n}', '012', '3', '2', '0', 'B', 'Because of the semicolon after the for loop, the printf block is NOT part of the loop. The loop finishes with k=3, then the block executes once.', 'https://www.youtube.com/results?search_query=C+for+loop+with+trailing+semicolon'),
(156, 8, 'What is the scope of a variable declared inside the initialization part of a for loop (C99 and later)?', 'for (int z = 0; z < 5; z++) { ... }', 'Global scope', 'Function scope', 'Block scope (only inside the loop)', 'File scope', 'C', 'Variables declared in the for-loop initialization are restricted to the scope of that loop only.', 'https://www.youtube.com/results?search_query=C99+for+loop+variable+scope'),
(157, 8, 'What will be printed?', 'unsigned char i = 250;\\nwhile (i < 255) {\\n    i++;\\n}\\nprintf(\\\"%d\\\", i);', '250', '255', '0', 'Infinite loop', 'B', 'The loop increments i from 250 to 255. When i is 255, the condition 255 < 255 is false, so it prints 255.', 'https://www.youtube.com/results?search_query=unsigned+char+range+C'),
(158, 8, 'Which loop is guaranteed to execute at least once?', '', 'for', 'while', 'do-while', 'None of the above', 'C', 'A do-while loop evaluates its condition at the end of the loop body, ensuring at least one execution.', 'https://www.youtube.com/results?search_query=exit+controlled+loop+in+C'),
(159, 8, 'What will be the output of this code?', 'int i = 5;\\nwhile (i == 5) {\\n    if (i > 0) break;\\n    i++;\\n}\\nprintf(\\\"%d\\\", i);', '6', '5', '0', 'Infinite loop', 'B', 'The loop starts because i is 5. Inside, it immediately hits \\\'break\\\' because 5 > 0. The value of i remains 5.', 'https://www.youtube.com/results?search_query=break+statement+logic+C'),
(160, 8, 'What happens if you use a float as a loop counter in C?', 'for (float f = 0.1; f <= 0.3; f += 0.1)', 'Compilation error', 'It works but may have precision issues', 'Runtime error', 'It is converted to int automatically', 'B', 'Floating point numbers often cannot be represented exactly in binary, leading to precision errors that might make loop counts unpredictable.', 'https://www.youtube.com/results?search_query=floating+point+loop+counters+C');

-- --------------------------------------------------------

--
-- Table structure for table `institute_basic_info`
--

CREATE TABLE `institute_basic_info` (
  `id` int(11) NOT NULL,
  `institute_name` varchar(255) NOT NULL,
  `institute_code` varchar(50) NOT NULL,
  `director_name` varchar(255) NOT NULL,
  `institute_email` varchar(255) NOT NULL,
  `institute_phone` varchar(20) NOT NULL,
  `institute_address` text NOT NULL,
  `institute_city` varchar(100) NOT NULL,
  `institute_state` varchar(100) NOT NULL,
  `institute_pincode` varchar(10) NOT NULL,
  `institute_website` varchar(255) DEFAULT NULL,
  `established_year` year(4) NOT NULL,
  `registration_authority` varchar(100) NOT NULL,
  `registration_number` varchar(100) NOT NULL,
  `courses_offered` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_form`
--

CREATE TABLE `meeting_form` (
  `meeting_id` int(11) NOT NULL,
  `Meeting_title` text NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` time NOT NULL,
  `meeting_mode` varchar(50) NOT NULL,
  `meeting_link` varchar(200) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting_form`
--

INSERT INTO `meeting_form` (`meeting_id`, `Meeting_title`, `meeting_date`, `meeting_time`, `meeting_mode`, `meeting_link`, `upload_date`) VALUES
(1, 'exam topic', '2025-10-29', '13:03:00', 'Online', 'https://zoom.us/j/1234567890', '2025-10-27 18:28:15'),
(2, 'exam topic', '2025-10-25', '14:22:00', 'Offline', NULL, '2025-10-27 18:28:15'),
(3, 'student detail show', '2025-12-17', '19:10:00', 'Offline', '', '2025-12-14 07:36:31'),
(4, 'due fess', '2026-02-16', '16:05:00', 'Offline', NULL, '2026-02-15 10:21:45'),
(5, 'due fess', '2026-02-16', '21:07:00', 'Offline', NULL, '2026-02-15 10:29:49'),
(6, 'due fess', '2026-02-17', '19:11:00', 'Offline', NULL, '2026-02-15 10:50:52'),
(7, 'due fess', '2026-02-19', '21:10:00', 'Offline', NULL, '2026-02-15 10:53:24'),
(8, 'new topic', '2026-02-19', '16:05:00', 'Offline', NULL, '2026-02-15 11:00:14'),
(9, 'new topic', '2026-02-20', '21:08:00', 'Offline', NULL, '2026-02-15 11:06:34'),
(10, 'new subject', '2026-02-18', '19:10:00', 'Offline', NULL, '2026-02-15 11:13:33'),
(11, 'new member', '2026-02-18', '22:05:00', 'Online', 'https://messagespedia.com/virtual-meeting-invitation-email-samples/', '2026-02-15 11:22:11'),
(12, 'new member', '2026-02-20', '08:08:00', 'Offline', NULL, '2026-02-15 11:35:24'),
(13, 'new member', '2026-02-21', '05:06:00', 'Offline', NULL, '2026-02-15 11:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_role` enum('admin','teacher','student','parent') NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_role`, `user_id`, `title`, `message`, `link`, `is_read`, `created_at`) VALUES
(1, 'admin', 1, 'New Online Student Enquiry', 'A new student enquiry has been received from the website.', 'show-online-student-details.php', 1, '2026-01-06 07:18:07'),
(2, 'admin', 1, 'New Demo Class Request', 'A new demo class request has been received from the website.', 'show-demo-register-Std-details.php', 1, '2026-01-07 15:50:16'),
(3, 'admin', 1, 'New Online Student Enquiry', 'A new student enquiry has been received from the website.', 'show-online-student-details.php', 1, '2026-01-09 09:24:38'),
(4, 'admin', 1, 'New Demo Class Request', 'A new demo class request has been received from the website.', 'show-demo-register-Std-details.php', 1, '2026-01-10 07:00:31'),
(5, 'admin', 1, 'New Demo Class Request', 'A new demo class request has been received from the website.', 'show-demo-register-Std-details.php', 1, '2026-01-10 07:00:43'),
(6, 'student', 7, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-03 09:53:14'),
(7, 'admin', 1, 'New Online Student Enquiry', 'A new student enquiry has been received from the website.', 'show-online-student-details.php', 1, '2026-02-03 10:47:27'),
(8, 'student', 4, 'New Exam Assigned', 'New exam assigned: c programing (variables and loop)', 'exam-section/show_exams.php', 1, '2026-02-03 11:08:43'),
(9, 'student', 15, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-06 14:31:27'),
(10, 'student', 16, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-06 14:36:14'),
(11, 'student', 18, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-06 14:38:26'),
(12, 'student', 20, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-06 14:40:17'),
(13, 'student', 27, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-06 15:05:00'),
(14, 'student', 28, 'Welcome', 'Your student account has been created successfully.', 'student-dashboard.php', 0, '2026-02-06 15:11:54'),
(15, 'student', 7, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:50:28'),
(16, 'student', 4, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:50:31'),
(17, 'student', 29, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:50:35'),
(18, 'student', 30, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:50:38'),
(19, 'student', 3, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:50:42'),
(20, 'student', 28, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:50:46'),
(21, 'admin', 1, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:50:49'),
(22, 'student', 7, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:50:53'),
(23, 'student', 4, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:50:57'),
(24, 'student', 29, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:00'),
(25, 'student', 30, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:51:04'),
(26, 'student', 3, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:07'),
(27, 'student', 28, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:11'),
(28, 'admin', 1, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:51:14'),
(29, 'student', 7, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:18'),
(30, 'student', 4, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:51:22'),
(31, 'student', 29, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:25'),
(32, 'student', 30, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:51:29'),
(33, 'student', 3, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:32'),
(34, 'student', 28, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:51:36'),
(35, 'admin', 1, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-28 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:51:39'),
(36, 'student', 7, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:52:39'),
(37, 'student', 4, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:52:42'),
(38, 'student', 29, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:52:46'),
(39, 'student', 30, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:52:49'),
(40, 'student', 3, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:52:53'),
(41, 'student', 28, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:52:57'),
(42, 'admin', 1, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:53:00'),
(43, 'student', 7, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:53:05'),
(44, 'student', 4, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:53:09'),
(45, 'student', 29, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:53:13'),
(46, 'student', 30, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:53:17'),
(47, 'student', 3, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:53:22'),
(48, 'student', 28, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:53:26'),
(49, 'admin', 1, 'New Class Event', 'Event: holi-Event | Date: 2026-02-27 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:53:29'),
(50, 'student', 7, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:59:37'),
(51, 'student', 4, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:59:37'),
(52, 'student', 29, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:59:37'),
(53, 'student', 30, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:59:37'),
(54, 'student', 3, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:59:37'),
(55, 'student', 28, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 0, '2026-02-07 16:59:38'),
(56, 'admin', 1, 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'show-details/show-cls-fun.php', 1, '2026-02-07 16:59:38'),
(57, 'admin', 1, 'New Online Student Enquiry', 'A new student enquiry has been received from the website.', 'show-details/show-online-student-details.php', 1, '2026-02-08 10:51:10'),
(58, 'student', 7, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-08 11:01:06'),
(59, 'student', 4, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-08 11:01:06'),
(60, 'student', 29, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-08 11:01:06'),
(61, 'student', 30, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-08 11:01:06'),
(62, 'student', 3, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-08 11:01:06'),
(63, 'student', 28, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 0, '2026-02-08 11:01:06'),
(64, 'admin', 1, 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'show-details/show-cls-fun.php', 1, '2026-02-08 11:01:07'),
(65, 'student', 3, 'New Exam Assigned', 'New exam assigned: c programing (variables and loop)', 'exam-section/show_exams.php', 0, '2026-02-10 17:50:11'),
(66, 'student', 3, 'MCQ Exam Reminder', 'c programing - variables and loop is now live. Please start your exam.', 'exam-section/student_take_exam.php?exam_id=8', 0, '2026-02-12 08:23:36'),
(67, 'teacher', 1, 'Welcome', 'Your teacher account has been created successfully.', 'dashboard/teacher-dashboard.php', 0, '2026-02-13 13:37:00'),
(68, 'admin', 1, 'New Teacher Added', 'Teacher: shre (daveshreye@gmail.com)', 'show-details/show-teacher.php', 1, '2026-02-13 13:37:07'),
(69, 'admin', 1, 'Exam Created', 'Exam:  | Course:', 'show-details/show-examinforms.php', 1, '2026-02-15 06:36:28'),
(70, 'admin', 1, 'Study Material Added', 'Course: programing | Subject: java basic', 'show-details/show-study-mat.php', 1, '2026-02-15 09:49:54'),
(71, 'admin', 1, 'Study Material Added', 'Course: programing | Subject: java basic', 'show-details/show-study-mat.php', 1, '2026-02-15 09:50:01'),
(72, 'admin', 1, 'Study Material Added', 'Course: programing | Subject: java basic', 'show-details/show-study-mat.php', 1, '2026-02-15 09:50:05'),
(73, 'admin', 1, 'Study Material Added', 'Course: programing | Subject: java basic', 'show-details/show-study-mat.php', 1, '2026-02-15 09:50:09'),
(74, 'admin', 1, 'Study Material Added', 'Course: programing | Subject: java basic', 'show-details/show-study-mat.php', 1, '2026-02-15 09:50:13'),
(75, 'teacher', 1, 'New Paper Schedule', 'Course: 6546 | Week: 2026-02-23', 'show-details/show-paper-sch.php', 0, '2026-02-15 10:09:52'),
(76, 'admin', 1, 'New Paper Schedule', 'Course: 6546 | Week: 2026-02-23', 'show-details/show-paper-sch.php', 1, '2026-02-15 10:09:52'),
(77, 'admin', 2, 'New Paper Schedule', 'Course: 6546 | Week: 2026-02-23', 'show-details/show-paper-sch.php', 1, '2026-02-15 10:09:52'),
(78, 'parent', 17, 'Welcome', 'Your parent account has been created successfully.', 'dashboard/parent-dashboard.php', 0, '2026-02-15 10:18:04'),
(79, 'admin', 1, 'New Parent Added', 'Parent: shreye (daveshreye@gmail.com)', 'show-details/show-parent.php', 1, '2026-02-15 10:18:08'),
(80, 'parent', 19, 'Welcome', 'Your parent account has been created successfully.', 'dashboard/parent-dashboard.php', 1, '2026-02-15 10:19:31'),
(81, 'admin', 1, 'New Parent Added', 'Parent: shreye dave (daveshreye245@gmail.com)', 'show-details/show-parent.php', 1, '2026-02-15 10:19:35'),
(82, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(83, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(84, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(85, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(86, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:21:45'),
(87, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(88, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(89, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:21:45'),
(90, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:21:45'),
(91, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:21:45'),
(92, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:21:45'),
(93, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(94, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(95, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(96, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(97, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:29:49'),
(98, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(99, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(100, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:29:49'),
(101, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:29:49'),
(102, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:29:49'),
(103, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:29:49'),
(104, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(105, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(106, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(107, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(108, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:50:52'),
(109, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(110, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(111, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:50:52'),
(112, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:50:52'),
(113, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:50:52'),
(114, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:50:52'),
(115, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:24'),
(116, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:24'),
(117, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:24'),
(118, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:24'),
(119, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:53:24'),
(120, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:24'),
(121, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:24'),
(122, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:53:24'),
(123, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 10:53:25'),
(124, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:53:25'),
(125, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 10:53:25'),
(126, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(127, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(128, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(129, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(130, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:00:14'),
(131, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(132, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(133, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:00:14'),
(134, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:00:14'),
(135, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:00:14'),
(136, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:00:14'),
(137, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(138, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(139, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(140, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(141, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:06:34'),
(142, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(143, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(144, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(145, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:06:34'),
(146, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:06:34'),
(147, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:06:34'),
(148, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(149, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(150, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(151, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(152, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:13:33'),
(153, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(154, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(155, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(156, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:13:33'),
(157, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:13:34'),
(158, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:13:34'),
(159, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(160, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(161, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(162, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(163, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 1, '2026-02-15 11:22:11'),
(164, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(165, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(166, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(167, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 0, '2026-02-15 11:22:11'),
(168, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 1, '2026-02-15 11:22:11'),
(169, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'show-details/show-meets.php', 1, '2026-02-15 11:22:11'),
(170, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(171, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(172, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(173, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(174, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:35:24'),
(175, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(176, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(177, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(178, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:35:24'),
(179, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:35:24'),
(180, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:35:24'),
(181, 'student', 28, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:08'),
(182, 'student', 7, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:08'),
(183, 'student', 4, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:08'),
(184, 'student', 29, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:08'),
(185, 'student', 30, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:43:08'),
(186, 'student', 3, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:08'),
(187, 'parent', 17, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:09'),
(188, 'parent', 19, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:09'),
(189, 'teacher', 1, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 0, '2026-02-15 11:43:09'),
(190, 'admin', 1, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:43:09'),
(191, 'admin', 2, 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'show-details/show-meets.php', 1, '2026-02-15 11:43:09'),
(192, 'parent', 20, 'Welcome', 'Your parent account has been created successfully.', 'dashboard/parent-dashboard.php', 0, '2026-02-15 12:33:59'),
(193, 'admin', 1, 'New Parent Added', 'Parent: aditya (aadityaborkar364@gmail.com)', 'show-details/show-parent.php', 1, '2026-02-15 12:34:03'),
(194, 'student', 30, 'Attendance Reminder', 'Attendance window: 10:00 AM - 12:00 PM', 'AI_Attendance/mark_attendance_page.php', 1, '2026-02-17 10:30:31'),
(195, 'student', 4, 'Attendance Reminder', 'Attendance window: 5:00 AM - 7:00 PM', 'AI_Attendance/mark_attendance_page.php', 0, '2026-02-17 10:49:22'),
(214, 'parent', 26, 'Welcome', 'Your parent account has been created successfully.', 'dashboard/parent-dashboard.php', 0, '2026-02-17 13:44:16'),
(215, 'admin', 1, 'New Parent Added', 'Parent: puja  (vaishnavu0710@gmail.com)', 'show-details/show-parent.php', 1, '2026-02-17 13:44:16'),
(216, 'teacher', 10, 'Welcome', 'Your teacher account has been created successfully.', 'dashboard/teacher-dashboard.php', 0, '2026-02-17 13:46:43'),
(217, 'admin', 1, 'New Teacher Added', 'Teacher: vashnavi c (p43753339@gmail.com)', 'show-details/show-teacher.php', 1, '2026-02-17 13:46:43'),
(218, 'student', 30, 'Attendance Reminder', 'Attendance window: 10:00 AM - 7:00 PM', 'AI_Attendance/mark_attendance_page.php', 1, '2026-02-19 14:46:15'),
(219, 'student', 30, 'Attendance Reminder', 'Attendance window: 10:00 AM - 7:00 PM', 'AI_Attendance/mark_attendance_page.php', 1, '2026-02-21 11:26:40'),
(222, 'teacher', 12, 'Welcome', 'Your teacher account has been created successfully.', 'dashboard/teacher-dashboard.php', 1, '2026-02-22 10:18:11'),
(223, 'admin', 1, 'New Teacher Added', 'Teacher: rohit sharma  (ss19if049@gmail.com)', 'show-details/show-teacher.php', 1, '2026-02-22 10:18:11'),
(224, 'student', 30, 'Attendance Reminder', 'Attendance window: 10:00 AM - 7:00 PM', 'AI_Attendance/mark_attendance_page.php', 0, '2026-02-22 10:21:03');

-- --------------------------------------------------------

--
-- Table structure for table `notification_email_queue`
--

CREATE TABLE `notification_email_queue` (
  `id` int(11) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `link` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_error` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sent_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_email_queue`
--

INSERT INTO `notification_email_queue` (`id`, `to_email`, `subject`, `body`, `link`, `status`, `attempts`, `last_error`, `created_at`, `sent_at`) VALUES
(1, 'karunya123@gmail.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:37', '2026-02-17 13:22:19'),
(2, 'abhishek@gmail.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:37', '2026-02-17 13:22:23'),
(3, 'aman.verma2027@example.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:37', '2026-02-17 13:22:27'),
(4, 'riya.patil2027@example.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:37', '2026-02-17 13:22:31'),
(5, 'Anu13@gmail.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:38', '2026-02-17 13:22:34'),
(6, 'abhihack1420@gmail.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:38', '2026-02-17 13:22:38'),
(7, 'abhihack1420@gmail.com', 'New Class Event', 'Event: Dewali Festival | Date: 2026-02-27 17:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-07 16:59:38', '2026-02-17 13:22:42'),
(8, 'karunya123@gmail.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:06', '2026-02-17 13:22:45'),
(9, 'abhishek@gmail.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:06', '2026-02-17 13:22:49'),
(10, 'aman.verma2027@example.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:06', '2026-02-17 13:22:53'),
(11, 'riya.patil2027@example.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:06', '2026-02-17 13:22:57'),
(12, 'Anu13@gmail.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:06', '2026-02-17 13:23:01'),
(13, 'abhihack1420@gmail.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:06', '2026-02-17 13:23:05'),
(14, 'abhihack1420@gmail.com', 'New Class Event', 'Event: christmas | Date: 2026-02-18 18:00', 'http://localhost/Final-year-pro/show-details/show-cls-fun.php', 'sent', 0, NULL, '2026-02-08 11:01:07', '2026-02-17 13:23:09'),
(15, 'daveshreye@gmail.com', 'New Paper Schedule', 'Course: 6546 | Week: 2026-02-23', 'http://localhost/Final-year-pro/show-details/show-paper-sch.php', 'sent', 0, NULL, '2026-02-15 10:09:52', '2026-02-17 13:23:12'),
(16, 'abhihack1420@gmail.com', 'New Paper Schedule', 'Course: 6546 | Week: 2026-02-23', 'http://localhost/Final-year-pro/show-details/show-paper-sch.php', 'sent', 0, NULL, '2026-02-15 10:09:52', '2026-02-17 13:23:16'),
(17, 'daveshreye@gmail.com', 'New Paper Schedule', 'Course: 6546 | Week: 2026-02-23', 'http://localhost/Final-year-pro/show-details/show-paper-sch.php', 'sent', 0, NULL, '2026-02-15 10:09:52', '2026-02-17 13:23:20'),
(18, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:24'),
(19, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:27'),
(20, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:31'),
(21, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:35'),
(22, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:38'),
(23, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:42'),
(24, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:46'),
(25, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'sent', 0, NULL, '2026-02-15 10:21:45', '2026-02-17 13:23:50'),
(26, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:21:45', NULL),
(27, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:21:45', NULL),
(28, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:21:45', NULL),
(29, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(30, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(31, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(32, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(33, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(34, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(35, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(36, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(37, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(38, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(39, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-16 21:07:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:29:49', NULL),
(40, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(41, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(42, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(43, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(44, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(45, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(46, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(47, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(48, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(49, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(50, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-17 19:11:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:50:52', NULL),
(51, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(52, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(53, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(54, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(55, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(56, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(57, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(58, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:24', NULL),
(59, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:25', NULL),
(60, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:25', NULL),
(61, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: due fess | 2026-02-19 21:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 10:53:25', NULL),
(62, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(63, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(64, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(65, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(66, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(67, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(68, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(69, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(70, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(71, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(72, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-19 16:05:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:00:14', NULL),
(73, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(74, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(75, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(76, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(77, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(78, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(79, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(80, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(81, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(82, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(83, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new topic | 2026-02-20 21:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:06:34', NULL),
(84, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(85, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(86, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(87, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(88, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(89, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(90, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(91, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(92, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:33', NULL),
(93, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:34', NULL),
(94, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new subject | 2026-02-18 19:10:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:13:34', NULL),
(95, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(96, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(97, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(98, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(99, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(100, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(101, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(102, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(103, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(104, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(105, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-18 22:05:00 (Online)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:22:11', NULL),
(106, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(107, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(108, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(109, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(110, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(111, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(112, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(113, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(114, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(115, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(116, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-20 08:08:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:35:24', NULL),
(117, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:08', NULL),
(118, 'karunya123@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:08', NULL),
(119, 'abhishek@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:08', NULL),
(120, 'aman.verma2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:08', NULL),
(121, 'riya.patil2027@example.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:08', NULL),
(122, 'Anu13@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:08', NULL),
(123, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:09', NULL),
(124, 'daveshreye245@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:09', NULL),
(125, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:09', NULL),
(126, 'abhihack1420@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:09', NULL),
(127, 'daveshreye@gmail.com', 'Parent Meeting Scheduled', 'Meeting: new member | 2026-02-21 05:06:00 (Offline)', 'http://localhost/Final-year-pro/show-details/show-meets.php', 'pending', 0, NULL, '2026-02-15 11:43:09', NULL),
(128, 'vaishnavu0710@gmail.com', 'Parent Account Details', 'Hello rahul dravid,\n\nYour Parent account has been created successfully.\n\nLogin Email: vaishnavu0710@gmail.com\nMobile: 9935743454\nPassword: uwLAo$29BN\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 12:49:41', NULL),
(129, 'shreyedave465@gmail.com', 'Teacher Account Details', 'Hello vashnavi c,\n\nYour Teacher account has been created successfully.\n\nLogin Email: shreyedave465@gmail.com\nMobile: 4547215566\nPassword: UxEBtMCurt\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 13:06:30', NULL),
(130, 'shreyedave465@gmail.com', 'Teacher Account Details', 'Hello vashnavi c,\n\nYour Teacher account has been created successfully.\n\nLogin Email: shreyedave465@gmail.com\nMobile: 4547215566\nPassword: 7VCrKKPppe\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 13:07:49', NULL),
(131, 'shreyedave465@gmail.com', 'Teacher Account Details', 'Hello vashnavi c,\n\nYour Teacher account has been created successfully.\n\nLogin Email: shreyedave465@gmail.com\nMobile: 4547215566\nPassword: #KgUzB6byt\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 13:10:13', NULL),
(132, 'shreyedave465@gmail.com', 'Teacher Account Details', 'Hello vashnavi c,\n\nYour Teacher account has been created successfully.\n\nLogin Email: shreyedave465@gmail.com\nMobile: 4547215566\nPassword: a7pA9rq5MS\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 13:14:46', NULL),
(133, 'p43753339@gmail.com', 'Teacher Account Details', 'Hello vashnavi c,\n\nYour Teacher account has been created successfully.\n\nLogin Email: p43753339@gmail.com\nMobile: 4547215566\nPassword: Hq2%DT!TZq\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 13:16:54', NULL),
(134, 'vaishnavu0710@gmail.com', 'Parent Account Details', 'Hello puja ,\n\nYour Parent account has been created successfully.\n\nLogin Email: vaishnavu0710@gmail.com\nMobile: 9935743454\nPassword: 8x$hMVSogX\n\nLogin here: http://localhost/Final-year-pro/admin_login.php\n\nNote: You can change your password later if needed.\nPlease keep this information safe.\n\nThanks.', '', 'pending', 0, NULL, '2026-02-17 13:22:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paper_schedule`
--

CREATE TABLE `paper_schedule` (
  `paper_sch_id` int(11) NOT NULL,
  `schedule_name` varchar(30) NOT NULL,
  `course_name` varchar(30) NOT NULL,
  `week_of` date NOT NULL,
  `monday_module` varchar(20) NOT NULL,
  `monday_time` time NOT NULL,
  `monday_end_time` time DEFAULT NULL,
  `monday_lab` varchar(15) NOT NULL,
  `tuesday_module` varchar(20) NOT NULL,
  `tuesday_time` time NOT NULL,
  `tuesday_end_time` time DEFAULT NULL,
  `tuesday_lab` varchar(15) NOT NULL,
  `wednesday_module` varchar(20) NOT NULL,
  `wednesday_time` time NOT NULL,
  `wednesday_end_time` time DEFAULT NULL,
  `wednesday_lab` varchar(15) NOT NULL,
  `thursday_module` varchar(20) NOT NULL,
  `thursday_time` time NOT NULL,
  `thursday_end_time` time DEFAULT NULL,
  `thursday_lab` varchar(15) NOT NULL,
  `friday_module` varchar(20) NOT NULL,
  `friday_time` time NOT NULL,
  `friday_end_time` time DEFAULT NULL,
  `friday_lab` varchar(15) NOT NULL,
  `saturday_module` varchar(20) NOT NULL,
  `saturday_time` time NOT NULL,
  `saturday_end_time` time DEFAULT NULL,
  `saturday_lab` varchar(15) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paper_schedule`
--

INSERT INTO `paper_schedule` (`paper_sch_id`, `schedule_name`, `course_name`, `week_of`, `monday_module`, `monday_time`, `monday_end_time`, `monday_lab`, `tuesday_module`, `tuesday_time`, `tuesday_end_time`, `tuesday_lab`, `wednesday_module`, `wednesday_time`, `wednesday_end_time`, `wednesday_lab`, `thursday_module`, `thursday_time`, `thursday_end_time`, `thursday_lab`, `friday_module`, `friday_time`, `friday_end_time`, `friday_lab`, `saturday_module`, `saturday_time`, `saturday_end_time`, `saturday_lab`, `upload_date`) VALUES
(3, 'practice Exam', 'Programing-C', '2026-01-19', 'basic', '14:22:00', '00:00:00', '2', 'function', '14:00:00', '00:00:00', '1', 'functions', '15:30:00', '00:00:00', '2', 'arrays', '10:00:00', '00:00:00', '2', 'conditions', '00:00:00', '00:00:00', '1', 'project', '00:00:00', '00:00:00', '1', '2025-10-27 18:29:00'),
(4, 'practice Exam', 'java', '2025-12-22', 'basic', '12:35:00', '19:14:00', '2', 'loops', '23:34:00', '17:14:00', '1', 'functions', '23:34:00', '20:18:00', '2', 'arrays', '12:35:00', '17:17:00', '1', 'conditions', '00:00:17', '17:17:00', '1', 'project', '00:00:18', '00:00:00', '1', '2025-10-29 17:04:08'),
(5, 'practice Exam', 'Programing-C', '2025-12-22', 'basic', '17:13:00', '18:14:00', '2', 'loops', '17:14:00', '18:14:00', '1', 'functions', '17:15:00', '18:15:00', '2', 'arrays', '17:15:00', '18:15:00', '2', 'conditions', '00:00:17', '18:14:00', '1', 'project', '00:00:17', '18:15:00', '1', '2025-12-12 10:44:59'),
(6, 'practical exam', '6546', '2026-02-23', 'abc', '15:40:00', '17:41:00', '2', 'bcs', '17:41:00', '19:41:00', '2', 'dsfsd', '15:39:00', '18:42:00', '2', 'vsdf', '17:41:00', '18:42:00', '2', 'dsf', '18:42:00', '19:43:00', '2', 'dfa', '18:42:00', '23:47:00', '2', '2026-02-15 10:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `parent_extra_fields`
--

CREATE TABLE `parent_extra_fields` (
  `field_id` int(11) NOT NULL,
  `field_key` varchar(100) NOT NULL,
  `field_label` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parent_extra_values`
--

CREATE TABLE `parent_extra_values` (
  `parent_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `field_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_basic_info`
--

CREATE TABLE `school_basic_info` (
  `id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_code` varchar(100) NOT NULL,
  `principal_name` varchar(255) NOT NULL,
  `school_email` varchar(255) NOT NULL,
  `school_phone` varchar(20) NOT NULL,
  `school_address` text NOT NULL,
  `school_city` varchar(100) NOT NULL,
  `school_state` varchar(100) NOT NULL,
  `school_pincode` varchar(10) NOT NULL,
  `school_website` varchar(255) DEFAULT NULL,
  `established_year` year(4) NOT NULL,
  `affiliation_board` varchar(100) NOT NULL,
  `affiliation_number` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_basic_info`
--

INSERT INTO `school_basic_info` (`id`, `school_name`, `school_code`, `principal_name`, `school_email`, `school_phone`, `school_address`, `school_city`, `school_state`, `school_pincode`, `school_website`, `established_year`, `affiliation_board`, `affiliation_number`, `created_at`, `updated_at`) VALUES
(1, 'Demo High School', 'DHS001', 'Dr. John Smith', 'info@demohighschool.edu', '+91 9876543210', '123 Education Street, Knowledge Park', 'Mumbai', 'Maharashtra', '400001', 'https://www.demohighschool.edu', '1995', 'CBSE', 'CBSE/AFF/123456', '2026-02-14 14:34:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_exams`
--

CREATE TABLE `student_exams` (
  `exam_id` int(11) NOT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `topic_name` varchar(255) DEFAULT NULL,
  `difficulty` varchar(50) DEFAULT 'Medium',
  `total_questions` int(11) DEFAULT 20,
  `status` varchar(20) DEFAULT 'Pending',
  `exam_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `marks_obtained` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(255) DEFAULT 'Good'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_exams`
--

INSERT INTO `student_exams` (`exam_id`, `student_id`, `student_name`, `student_email`, `course_name`, `subject`, `topic_name`, `difficulty`, `total_questions`, `status`, `exam_date`, `marks_obtained`, `created_at`, `remarks`) VALUES
(1, '3', '', NULL, 'c programing', 'variables and loop', 'variables and loop', 'Medium', 20, 'Completed', '2025-12-15 13:51:57', 9, '2025-12-15 11:56:18', 'Good'),
(2, '20', 'virat', NULL, 'c programing', 'variables and loop', 'variables and loop', 'Easy', 20, 'Completed', '2025-12-15 13:51:57', 7, '2025-12-15 12:36:26', 'Good'),
(3, '16', 'Aaditya', 'aadi213@gmail.com', 'javascript', 'variables and loop', 'variables and loop', 'Easy', 20, 'Completed', '2025-12-15 13:53:52', 0, '2025-12-15 13:53:52', 'Good'),
(4, '16', 'Aaditya', 'aadi213@gmail.com', 'c programing', 'variables and loop', 'variables and loop', 'Medium', 20, 'Completed', '2025-12-16 08:19:26', 0, '2025-12-16 08:19:26', 'Terminated: Tab Switching Limit (3) Exceeded'),
(5, '4', 'Abhishek Suhas Pathak', 'abhishek@gmail.com', 'javascript', 'variables and loop', 'variables and loop', 'Medium', 20, 'Completed', '2026-02-01 15:44:14', 0, '2026-02-01 15:44:14', 'Terminated: Multiple Security Violations: Tab Switch Detected'),
(7, '4', 'Abhishek Suhas Pathak', 'abhishek@gmail.com', 'c programing', 'variables and loop', 'variables and loop', 'Medium', 20, 'Completed', '2026-02-03 11:08:43', 0, '2026-02-03 11:08:43', 'Terminated: Multiple Security Violations: Tab Switch Detected'),
(8, '3', 'Anuradha Borkar', 'Anu13@gmail.com', 'c programing', 'variables and loop', 'variables and loop', 'Medium', 20, 'Completed', '2026-02-11 08:29:00', 0, '2026-02-10 17:50:10', 'Terminated: Multiple Security Violations: Tab Switch Detected');

-- --------------------------------------------------------

--
-- Table structure for table `student_extra_fields`
--

CREATE TABLE `student_extra_fields` (
  `field_id` int(11) NOT NULL,
  `field_key` varchar(100) NOT NULL,
  `field_label` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_extra_fields`
--

INSERT INTO `student_extra_fields` (`field_id`, `field_key`, `field_label`, `created_at`) VALUES
(2, 'father_occupation', 'father_occupation', '2026-02-06 13:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `student_extra_values`
--

CREATE TABLE `student_extra_values` (
  `student_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `field_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_extra_values`
--

INSERT INTO `student_extra_values` (`student_id`, `field_id`, `field_value`) VALUES
(4, 2, '-'),
(28, 2, 'xzy'),
(29, 2, 'Shopkeeper'),
(30, 2, 'Driver');

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `fee_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(150) DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `course_price` decimal(10,2) NOT NULL,
  `paid_price` decimal(10,2) NOT NULL,
  `remaining_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `receipt_number` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_time` time DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `payment_notes` text DEFAULT NULL,
  `receipt_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`fee_id`, `student_id`, `student_name`, `student_email`, `parent_email`, `course_name`, `course_price`, `paid_price`, `remaining_price`, `payment_method`, `transaction_id`, `receipt_number`, `payment_date`, `payment_time`, `discount_amount`, `payment_notes`, `receipt_file`, `created_at`) VALUES
(1, '2', 'Abhishek Suhas Pathak', 'abhi145@gmail.com', 'archana15@gmail.com', 'python', 80000.00, 60000.00, 20000.00, NULL, NULL, NULL, '2025-10-28', '13:16:00', 0.00, NULL, '45_1761669779_1.png', '2025-10-28 16:42:59'),
(2, '3', 'rahul shrama', NULL, '', 'python', 80000.00, 60000.00, 20000.00, NULL, NULL, NULL, '2025-10-29', '14:25:00', 0.00, NULL, '3rahul shrama_1761670245_1.png', '2025-10-28 16:50:45'),
(3, '9', 'rohit', NULL, '', 'mscit', 10000.00, 6000.00, 4000.00, NULL, NULL, NULL, '2025-11-07', '13:05:00', 0.00, NULL, '9rohit_1761762886_134015531162034071.jpg', '2025-10-29 18:34:46'),
(4, '18', 'virat', NULL, '', 'python', 6600.00, 2221.00, 4379.00, NULL, NULL, NULL, '2025-10-31', '13:24:00', 0.00, NULL, '18virat_1761767343_m2.jpg', '2025-10-29 19:49:03'),
(5, '1', 'virat', NULL, '', 'python', 90000.00, 80000.00, 10000.00, NULL, NULL, NULL, '2025-11-07', '22:37:00', 0.00, NULL, '1virat_1761908512_WhatsApp Image 2025-10-05 at 20.43.25_b4303d82.jpg', '2025-10-31 11:01:52'),
(6, '2', 'virat', NULL, '', 'mscit', 10000.00, 5000.00, 5000.00, NULL, NULL, NULL, '2025-11-07', '22:41:00', 0.00, NULL, '2virat_1761908793_sample certifitate.pdf', '2025-10-31 11:06:33'),
(8, '16', 'Aaditya', 'aadi213@gmail.com', '', 'python', 60000.00, 20000.00, 40000.00, NULL, NULL, NULL, '2025-12-13', '17:30:00', 0.00, NULL, '16_1765529925_sample certifitate.pdf', '2025-12-12 08:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `study_material`
--

CREATE TABLE `study_material` (
  `material_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `course` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `material_type` varchar(50) NOT NULL,
  `file_path_or_link` varchar(500) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `study_material`
--

INSERT INTO `study_material` (`material_id`, `title`, `description`, `course`, `subject`, `material_type`, `file_path_or_link`, `upload_date`) VALUES
(1, 'java', 'introduction', 'java', 'module 1', 'pdf', '../material_upload/1761588562_IntroToJava.pdf', '2025-10-27 18:09:22'),
(3, 'java', 'basic', 'java', 'module 1', 'pdf', '../material_upload/material/1761672316_JavaChapter1.pdf', '2025-10-28 17:25:16'),
(4, 'python', 'chap3', 'python', 'module 3', 'pdf', '../material_upload/material/1761908298_UltimateJavaCheatSheet.pdf', '2025-10-31 10:58:18'),
(5, 'html and css', 'zxvcv', 'web', 'module 1', 'pdf', '../material_upload/material/1765383773_134007894206809137.jpg', '2025-11-01 06:45:02'),
(6, 'sql basic', 'sql basic', 'SQL', 'module 1', 'zip', '../material_upload/material/1765453792_Final-year-pro (V-4).zip', '2025-12-11 11:49:52'),
(7, 'java ', 'ckshff', 'programing', 'java basic', 'zip', '../material_upload/material/material_1771148994_best-air-fryer_2_1.zip', '2026-02-15 09:49:54'),
(8, 'java ', 'ckshff', 'programing', 'java basic', 'zip', '../material_upload/material/material_1771149001_best-air-fryer_2_1.zip', '2026-02-15 09:50:01'),
(9, 'java ', 'ckshff', 'programing', 'java basic', 'zip', '../material_upload/material/material_1771149005_best-air-fryer_2_1.zip', '2026-02-15 09:50:05'),
(10, 'java ', 'ckshff', 'programing', 'java basic', 'zip', '../material_upload/material/material_1771149009_best-air-fryer_2_1.zip', '2026-02-15 09:50:09'),
(11, 'java ', 'ckshff', 'programing', 'java basic', 'zip', '../material_upload/material/material_1771149013_best-air-fryer_2_1.zip', '2026-02-15 09:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_extra_fields`
--

CREATE TABLE `teacher_extra_fields` (
  `field_id` int(11) NOT NULL,
  `field_key` varchar(100) NOT NULL,
  `field_label` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_extra_values`
--

CREATE TABLE `teacher_extra_values` (
  `teacher_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `field_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activity_timestamp` (`timestamp`),
  ADD KEY `idx_role_user` (`role`,`user_id`),
  ADD KEY `idx_page_url` (`page_url`(100));

--
-- Indexes for table `add_class`
--
ALTER TABLE `add_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `add_demo_students`
--
ALTER TABLE `add_demo_students`
  ADD PRIMARY KEY (`Student_Id`),
  ADD UNIQUE KEY `student_num` (`student_num`);

--
-- Indexes for table `add_event`
--
ALTER TABLE `add_event`
  ADD PRIMARY KEY (`Event_id`);

--
-- Indexes for table `add_online_students`
--
ALTER TABLE `add_online_students`
  ADD PRIMARY KEY (`Student_Id`),
  ADD UNIQUE KEY `student_email` (`student_email`),
  ADD UNIQUE KEY `student_num` (`student_num`);

--
-- Indexes for table `add_parents`
--
ALTER TABLE `add_parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD UNIQUE KEY `parent_email` (`parent_email`),
  ADD UNIQUE KEY `parent_num` (`parent_num`);

--
-- Indexes for table `add_result`
--
ALTER TABLE `add_result`
  ADD PRIMARY KEY (`result_id`);

--
-- Indexes for table `add_students`
--
ALTER TABLE `add_students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_email` (`student_email`),
  ADD UNIQUE KEY `student_num` (`student_num`);

--
-- Indexes for table `add_teachers`
--
ALTER TABLE `add_teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `teacher_email` (`teacher_email`),
  ADD UNIQUE KEY `teacher_num` (`teacher_num`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_card`
--
ALTER TABLE `admin_card`
  ADD PRIMARY KEY (`admin_card_id`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_student_date` (`student_id`,`attendance_date`),
  ADD KEY `idx_attendance_student_date` (`student_id`,`check_in_time`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `batch_schedule`
--
ALTER TABLE `batch_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `new_batch_id` (`new_batch_id`);

--
-- Indexes for table `contact_demo_student`
--
ALTER TABLE `contact_demo_student`
  ADD PRIMARY KEY (`Student_Id`),
  ADD UNIQUE KEY `student_num` (`student_num`),
  ADD UNIQUE KEY `student_email` (`student_email`);

--
-- Indexes for table `course_add`
--
ALTER TABLE `course_add`
  ADD PRIMARY KEY (`Course_id`);

--
-- Indexes for table `device_permissions`
--
ALTER TABLE `device_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip_address` (`ip_address`);

--
-- Indexes for table `exam_answers_log`
--
ALTER TABLE `exam_answers_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_form`
--
ALTER TABLE `exam_form`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `institute_basic_info`
--
ALTER TABLE `institute_basic_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_form`
--
ALTER TABLE `meeting_form`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_email_queue`
--
ALTER TABLE `notification_email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper_schedule`
--
ALTER TABLE `paper_schedule`
  ADD PRIMARY KEY (`paper_sch_id`);

--
-- Indexes for table `parent_extra_fields`
--
ALTER TABLE `parent_extra_fields`
  ADD PRIMARY KEY (`field_id`),
  ADD UNIQUE KEY `uniq_parent_extra_fields_key` (`field_key`);

--
-- Indexes for table `parent_extra_values`
--
ALTER TABLE `parent_extra_values`
  ADD PRIMARY KEY (`parent_id`,`field_id`),
  ADD KEY `idx_parent_extra_values_field` (`field_id`);

--
-- Indexes for table `school_basic_info`
--
ALTER TABLE `school_basic_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_code` (`school_code`);

--
-- Indexes for table `student_exams`
--
ALTER TABLE `student_exams`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `student_extra_fields`
--
ALTER TABLE `student_extra_fields`
  ADD PRIMARY KEY (`field_id`),
  ADD UNIQUE KEY `uniq_student_extra_fields_key` (`field_key`);

--
-- Indexes for table `student_extra_values`
--
ALTER TABLE `student_extra_values`
  ADD PRIMARY KEY (`student_id`,`field_id`),
  ADD KEY `idx_student_extra_values_field` (`field_id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`fee_id`);

--
-- Indexes for table `study_material`
--
ALTER TABLE `study_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `teacher_extra_fields`
--
ALTER TABLE `teacher_extra_fields`
  ADD PRIMARY KEY (`field_id`),
  ADD UNIQUE KEY `uniq_teacher_extra_fields_key` (`field_key`);

--
-- Indexes for table `teacher_extra_values`
--
ALTER TABLE `teacher_extra_values`
  ADD PRIMARY KEY (`teacher_id`,`field_id`),
  ADD KEY `idx_teacher_extra_values_field` (`field_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1849;

--
-- AUTO_INCREMENT for table `add_class`
--
ALTER TABLE `add_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `add_demo_students`
--
ALTER TABLE `add_demo_students`
  MODIFY `Student_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `add_event`
--
ALTER TABLE `add_event`
  MODIFY `Event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `add_online_students`
--
ALTER TABLE `add_online_students`
  MODIFY `Student_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `add_parents`
--
ALTER TABLE `add_parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `add_result`
--
ALTER TABLE `add_result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `add_students`
--
ALTER TABLE `add_students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `add_teachers`
--
ALTER TABLE `add_teachers`
  MODIFY `teacher_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_card`
--
ALTER TABLE `admin_card`
  MODIFY `admin_card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batch_schedule`
--
ALTER TABLE `batch_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_demo_student`
--
ALTER TABLE `contact_demo_student`
  MODIFY `Student_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_add`
--
ALTER TABLE `course_add`
  MODIFY `Course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `device_permissions`
--
ALTER TABLE `device_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exam_answers_log`
--
ALTER TABLE `exam_answers_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `exam_form`
--
ALTER TABLE `exam_form`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `institute_basic_info`
--
ALTER TABLE `institute_basic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_form`
--
ALTER TABLE `meeting_form`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `notification_email_queue`
--
ALTER TABLE `notification_email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `paper_schedule`
--
ALTER TABLE `paper_schedule`
  MODIFY `paper_sch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parent_extra_fields`
--
ALTER TABLE `parent_extra_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_basic_info`
--
ALTER TABLE `school_basic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_exams`
--
ALTER TABLE `student_exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_extra_fields`
--
ALTER TABLE `student_extra_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `study_material`
--
ALTER TABLE `study_material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teacher_extra_fields`
--
ALTER TABLE `teacher_extra_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batch_schedule`
--
ALTER TABLE `batch_schedule`
  ADD CONSTRAINT `batch_schedule_ibfk_1` FOREIGN KEY (`new_batch_id`) REFERENCES `batches` (`batch_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_answers_log`
--
ALTER TABLE `exam_answers_log`
  ADD CONSTRAINT `exam_answers_log_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `student_exams` (`exam_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `student_exams` (`exam_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
