-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 03, 2025 at 08:23 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u812089401_mt_user_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `mob_no` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `name`, `password`, `mob_no`) VALUES
(1, 'surajsingh24hrs@gmail.com', 'admin', 'Master Tech Education', 'password', 9818038056),
(2, 'sahilpayal81@gmail.com', 'sahil', 'Sahil Payal', 'password', 7818978836);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `category`, `name`, `short_name`, `price`) VALUES
(1, 'Computer Science', 'Data Analytics', 'DA', 35000),
(3, 'Computer Science', 'Adv MIS', 'AMIS', 25000),
(4, 'Computer Science', 'Digital Marketing', 'DM', 55000),
(7, 'Business & Management', 'Adv Excel', 'AEXL', 6000),
(8, 'Business & Management', 'MS OFFICE', 'MSO', 6000),
(9, 'Computer Science', 'Excel With AI', 'XLAI', 7500),
(10, 'Computer Science', 'MIS', 'MIS', 18000),
(11, 'Computer Science', 'Tally Prime', 'TLY', 6000),
(12, 'Business & Management', 'Social Media With Meta Ads', 'SMM', 25000),
(13, 'Business & Management', 'Social Media With AI', 'SMM', 25000),
(14, 'Business & Management', 'PowerBI', 'PBI', 10000),
(15, 'Languages', 'Python Programming', 'PY', 10000),
(16, 'Languages', 'Python For Data Analytics', 'PDA', 15000),
(17, 'Languages', 'Visual Basic For Application', 'VBA', 14000),
(18, 'Computer Science', 'Prompt Engineering', 'PE', 7000),
(19, 'Business & Management', 'MS OFFICE EXCEL', 'MSOE', 12000),
(22, 'Computer Science', 'Adv Data Analytics', 'ADA', 45000),
(23, 'Art & Design', 'Graphic Design And Video Editing', 'GDVD', 55000);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `stu_id` varchar(100) NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `remaining` int(11) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `method` varchar(100) NOT NULL,
  `ref_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`stu_id`, `payment_id`, `payment_date`, `amount`, `remaining`, `update_date`, `method`, `ref_no`) VALUES
('MT-AMIS-25-1006', 'PAY-20240628042605', '2024-06-28', 2500, 12500, '2025-07-02 09:40:36', 'Online', '865387658734857347688'),
('MT-AMIS-25-1005', 'PAY-20240689042604', '2024-06-28', 2500, 12500, '2025-07-02 09:40:36', 'Online', '83475634876834734534'),
('MT-DM-25-1002', 'PAY-20250616173016', '2025-06-09', 500, 34500, '2025-06-16 17:30:16', 'Online', 'NA'),
('MT-SMM-25-1007', 'PAY-20250625031212', '2025-06-25', 14000, 6000, '2025-08-06 11:47:57', 'Online', '101066907112'),
('MT-DA-25-1009', 'PAY-20250630163417', '2025-06-30', 1000, 24000, '2025-06-30 16:34:17', 'Online', '324'),
('MT-DA-25-1010', 'PAY-20250701170702', '2025-07-01', 1000, 24000, '2025-07-01 17:07:02', 'Online', '325'),
('MT-AMIS-25-1011', 'PAY-20250702132202', '2025-07-02', 2000, 13000, '2025-07-02 13:22:02', 'Online', '326'),
('MT-AMIS-25-1012', 'PAY-20250703133636', '2025-07-03', 1500, 13500, '2025-07-03 13:36:36', 'Online', '327'),
('MT-DA-25-1011', 'PAY-20250704161856', '2025-07-04', 1000, 24000, '2025-07-04 16:18:56', 'Online', '328'),
('MT-AMIS-25-1013', 'PAY-20250706070235', '2025-07-06', 1000, 14000, '2025-07-06 07:02:35', 'Online', '331'),
('MT-DA-25-1012', 'PAY-20250706124919', '2025-07-06', 1000, 24000, '2025-07-06 12:49:19', 'Online', '332'),
('MT-MSOE-25-1007', 'PAY-20250721143649', '2025-07-21', 1000, 9000, '2025-07-21 14:36:49', 'Online', '355'),
('MT-PY-25-1008', 'PAY-20250723072838', '2025-07-23', 2000, 5000, '2025-07-23 07:28:38', 'Online', '-'),
('MT-PY-25-1008', 'PAY-20250723073114', '2025-02-06', 2000, 3000, '2025-07-23 07:31:14', 'Online', '-'),
('MT-PY-25-1008', 'PAY-20250723073134', '0000-00-00', 2000, 1000, '2025-07-23 07:31:34', 'Online', '-'),
('MT-PY-25-1008', 'PAY-20250723073157', '2025-03-12', 1000, 0, '2025-07-23 07:31:57', 'Online', '-'),
('MT-AMIS-25-1008', 'PAY-20250723142747', '2025-07-23', 1000, 17000, '2025-07-23 14:27:47', 'Online', '356'),
('MT-AMIS-25-1009', 'PAY-20250724132937', '2025-07-24', 2500, 12500, '2025-07-24 13:29:37', 'Offline', '354'),
('MT-SMM-25-1007', 'PAY-20250728102137', '2025-07-28', 6000, 0, '2025-08-06 11:48:41', 'Online', '101066907113'),
('MT-AMIS-25-1014', 'PAY-20250802141052', '2025-08-02', 2000, 16000, '2025-08-02 14:10:52', 'Offline', '359'),
('MT-TLY-25-1001', 'PAY-20250806150546', '2025-08-06', 1000, 4000, '2025-08-06 15:05:46', 'Online', '361'),
('MT-AMIS-25-1015', 'PAY-20250807145201', '2025-08-07', 1000, 14000, '2025-08-07 14:52:01', 'Online', '363'),
('MT-TLY-25-1001', 'PAY-20250807152033', '2025-08-07', 2000, 2000, '2025-08-07 15:20:33', 'Online', '364'),
('MT-GDVD-25-1015', 'PAY-20250808152506', '2025-08-08', 2500, 32500, '2025-08-08 15:25:06', 'Offline', '366'),
('MT-AMIS-25-1017', 'PAY-20250813160612', '2025-08-13', 1000, 15000, '2025-08-13 16:06:12', 'Offline', '378'),
('MT-ADA-25-1011', 'PAY-20250823133634', '2025-08-23', 1000, 24000, '2025-08-23 13:36:34', 'Online', '393'),
('MT-ADA-25-1012', 'PAY-20250823134309', '2025-08-23', 1000, 24000, '2025-08-23 13:43:09', 'Online', '394'),
('MT-ADA-25-1013', 'PAY-20250902145035', '2025-09-02', 1000, 29000, '2025-09-02 14:50:35', 'Offline', '397');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `stu_id` varchar(100) NOT NULL,
  `cert_id` varchar(100) NOT NULL,
  `compl_dt` date NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`stu_id`, `cert_id`, `compl_dt`, `filename`, `file_path`, `upload_date`) VALUES
('MT-AMIS-25-1005', 'MT-AMIS-25-1005', '2025-06-14', 'MT-AMIS-25-1005.pdf', '../../certificate/MT-AMIS-25-1005.pdf', '2025-07-09 14:16:42'),
('MT-AMIS-25-1006', 'MT-AMIS-25-1006', '2025-06-14', 'MT-AMIS-25-1006.pdf', '../../certificate/MT-AMIS-25-1006.pdf', '2025-07-09 14:17:44'),
('MT-AMIS-25-202415', 'MT-AMIS-25-202415', '2024-02-15', 'MT-AMIS-25-202415.pdf', '../../certificate/MT-AMIS-25-202415.pdf', '2025-06-09 03:02:50'),
('MT-AMIS-25-202416', 'MT-AMIS-25-202416', '2024-03-03', 'MT-AMIS-25-202416.pdf', '../../certificate/MT-AMIS-25-202416.pdf', '2025-06-09 03:12:24'),
('MT-AMIS-25-202520', 'MT-AMIS-25-202520', '2024-02-15', 'MT-AMIS-25-202520.pdf', '../../certificate/MT-AMIS-25-202520.pdf', '2025-06-09 02:53:27'),
('MT-MISA-202517', 'MT-MISA-202517-1', '2025-01-05', 'MT-MISA-202517-1.pdf', '../../certificate/MT-MISA-202517-1.pdf', '2025-05-30 20:56:18'),
('MT-PY-25-1008', 'MT-PY-25-1008-01', '2025-05-30', 'MT-PY-25-1008-01.pdf', '../../certificate/MT-PY-25-1008-01.pdf', '2025-07-25 19:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `student_id`, `status`, `update_time`) VALUES
(4, 'MT-AMIS-25-1001', 'Joined', '2025-05-27 10:40:27'),
(5, 'MT-DM-25-1002', 'Registered', '2025-06-07 08:41:36'),
(7, 'MT-AMIS-25-202520', 'Joined', '2025-06-09 02:47:15'),
(8, 'MT-AMIS-25-202415', 'Joined', '2025-06-09 03:00:03'),
(9, 'MT-AMIS-25-202416', 'Joined', '2025-06-09 03:06:18'),
(10, 'MT-AMIS-25-1002', 'Joined', '2025-06-09 08:44:47'),
(11, 'MT-AMIS-25-1003', 'Joined', '2025-06-11 09:43:05'),
(12, 'MT-AEXL-25-1004', 'Registered', '2025-06-12 08:50:47'),
(14, 'MT-DA-25-1007', 'Registered', '2025-06-21 14:07:08'),
(15, 'MT-DA-25-1008', 'Registered', '2025-06-21 14:08:51'),
(16, 'MT-AMIS-25-1010', 'Joined', '2025-06-21 16:06:53'),
(17, 'MT-SMM-25-1007', 'Joined', '2025-06-25 17:41:06'),
(25, 'MT-DA-25-1009', 'Registered', '2025-06-30 16:34:17'),
(26, 'MT-DA-25-1010', 'Registered', '2025-07-01 17:07:02'),
(27, 'MT-AMIS-25-1011', 'Registered', '2025-07-02 13:22:03'),
(28, 'MT-AMIS-25-1012', 'Registered', '2025-07-03 13:36:36'),
(29, 'MT-DA-25-1011', 'Registered', '2025-07-04 16:18:56'),
(30, 'MT-AMIS-25-1013', 'Registered', '2025-07-06 07:02:35'),
(31, 'MT-DA-25-1012', 'Registered', '2025-07-06 12:49:19'),
(32, 'MT-MSOE-25-1007', 'Registered', '2025-07-21 14:36:50'),
(33, 'MT-PY-25-1008', 'Registered', '2025-07-23 07:28:38'),
(34, 'MT-AMIS-25-1008', 'Registered', '2025-07-23 14:27:47'),
(35, 'MT-AMIS-25-1009', 'Joined', '2025-07-24 13:29:37'),
(38, 'MT-AMIS-25-1014', 'Registered', '2025-08-02 14:10:52'),
(40, 'MT-TLY-25-1001', 'Registered', '2025-08-06 15:05:46'),
(41, 'MT-AMIS-25-1015', 'Registered', '2025-08-07 14:52:01'),
(42, 'MT-GDVD-25-1015', 'Registered', '2025-08-08 15:25:06'),
(43, 'MT-AMIS-25-1017', 'Registered', '2025-08-13 16:06:12'),
(44, 'MT-ADA-25-1011', 'Registered', '2025-08-23 13:36:34'),
(45, 'MT-ADA-25-1012', 'Registered', '2025-08-23 13:43:09'),
(46, 'MT-ADA-25-1013', 'Registered', '2025-09-02 14:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `doj` date NOT NULL,
  `mob_no` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aadhar_no` bigint(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `fees` int(11) NOT NULL,
  `reg_amt` int(11) NOT NULL,
  `pnd_amt` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `profile_filename` varchar(500) NOT NULL DEFAULT 'default-profile-for-any-student-without-profile-picture-1234567890.png',
  `profile_file_path` varchar(500) NOT NULL DEFAULT '../../profile-photo/',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `full_name`, `father_name`, `dob`, `doj`, `mob_no`, `email`, `aadhar_no`, `course`, `fees`, `reg_amt`, `pnd_amt`, `status`, `profile_filename`, `profile_file_path`, `last_update`) VALUES
('MT-ADA-25-1011', 'Deeksha', 'Girish Pal', '2001-06-30', '2025-08-23', 9625614250, 'deekshapal78638@gmail.com', 477931498008, 'Adv Data Analytics', 25000, 1000, 24000, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-08-23 13:36:34'),
('MT-ADA-25-1012', 'Vandana', 'Ram Baran Singh', '2003-06-09', '2025-08-23', 8178731255, 'vk7802789@gmail.com', 539333164228, 'Adv Data Analytics', 25000, 1000, 24000, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-08-23 13:43:09'),
('MT-ADA-25-1013', 'Saawan Shah', 'Bhaglu Shah', '1990-01-01', '2025-09-02', 7982131329, 'sahsaawan7@gmail.com', 7982131329, 'Adv Data Analytics', 30000, 1000, 29000, 'Registered', 'profile-photo-for-MT-ADA-25-1013-68b706e85f8930.48057572.jpg', '../../profile-photo/profile-photo-for-MT-ADA-25-1013-68b706e85f8930.48057572.jpg', '2025-09-02 14:50:35'),
('MT-AEXL-25-1004', 'Nikhil Singh', 'Rajwant Singh', '1999-10-16', '2025-06-12', 9026507946, 'nikhil9797singh@gmail.com', 872463343018, 'Adv Excel', 4000, 1000, 0, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-AMIS-25-1001', 'Neha', 'Rajendra Singh', '2000-06-28', '2025-05-27', 8447430578, 'its.rohityadav321@gmail.com', 579204072820, 'Adv MIS', 14000, 1000, 0, 'Joined', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-AMIS-25-1002', 'Rohit', 'Ram Vishal', '2007-07-10', '2025-06-09', 8130565127, 'rr3982707@gmail.com', 676424687171, 'Adv MIS', 15000, 1000, 0, 'Joined', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-AMIS-25-1003', 'Raju Kumar', 'Arvind Prasad', '2003-02-04', '2025-06-11', 8651823765, 'rajukumardariyapur2020@gmail.com', 697483286346, 'Adv MIS', 15000, 1000, 0, 'Joined', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-AMIS-25-1005', 'Kajal', 'Sunder Lal', '2003-02-02', '2024-06-28', 9354258880, 'mehrakajal54167@gmail.com ', 791630327997, 'Adv MIS', 15000, 2500, 12500, 'Completed', 'profile-photo-for-MT-AMIS-25-1005-6864f86b744599.34617785.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1005-6864f86b744599.34617785.jpg', '2025-07-02 09:12:24'),
('MT-AMIS-25-1006', 'Sachin', 'Sunder Lal', '2004-09-26', '2024-06-28', 7827259172, 'lalsunder3427@gmail.com', 406753552853, 'Adv MIS', 15000, 2500, 12500, 'Completed', 'profile-photo-for-MT-AMIS-25-1006-6864f8822b6733.17566931.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1006-6864f8822b6733.17566931.jpg', '2025-07-02 09:12:33'),
('MT-AMIS-25-1008', 'Aanchal', 'Vijay Kumar', '2025-04-13', '2025-07-23', 7388938877, 'yorajkumar67@gmail.com', 427340636946, 'Adv MIS', 18000, 1000, 17000, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-23 14:27:47'),
('MT-AMIS-25-1009', 'Dipanshu', 'Vishan Singh', '1999-03-18', '2025-07-21', 9311447270, 'devrana9712@gmail.com', 324484022389, 'Adv MIS', 15000, 2500, 12500, 'Joined', 'profile-photo-for-MT-AMIS-25-1009-688235a9dffc81.23569731.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1009-688235a9dffc81.23569731.jpg', '2025-07-24 13:29:37'),
('MT-AMIS-25-1010', 'Suraj Kumar', 'Indan Singh', '2004-04-12', '2025-06-21', 8920339575, 'surajsinghsaini7838@gmail.com', 497416287344, 'Adv MIS', 15000, 1000, 14000, 'Joined', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-AMIS-25-1011', 'Vipin', 'Harendra Prajapati', '2007-06-02', '2025-07-02', 8877932164, 'bipinprajapati353@gmail.com', 624045815616, 'Adv MIS', 15000, 2000, 13000, 'Registered', 'profile-photo-for-MT-AMIS-25-1011-686532cb4ae818.73614386.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1011-686532cb4ae818.73614386.jpg', '2025-07-02 13:22:02'),
('MT-AMIS-25-1012', 'Uttam Kumar', 'Vinod Kumar', '2006-02-03', '2025-07-03', 9523819309, 'kumaruttamlodipur2006@gmail.com', 817190729854, 'Adv MIS', 15000, 1500, 13500, 'Registered', 'profile-photo-for-MT-AMIS-25-1012-686687e09bdeb8.44971811.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1012-686687e09bdeb8.44971811.jpg', '2025-07-03 13:36:36'),
('MT-AMIS-25-1013', 'Sadhana', 'Ram Sajeevan Yadav', '2005-02-05', '2025-07-06', 916656892, 'sadhnay0502@gmail.com', 729250699081, 'Adv MIS', 15000, 1000, 14000, 'Registered', 'profile-photo-for-MT-AMIS-25-1013-686a1fe4d7b2e6.32426016.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1013-686a1fe4d7b2e6.32426016.jpg', '2025-07-06 07:02:35'),
('MT-AMIS-25-1014', 'Satyendra Kumar', 'Ramparsan Ram', '2004-03-03', '2025-08-02', 8448158891, 'satyendrakumar85430@gmail.com', 2244374177, 'Adv MIS', 18000, 2000, 16000, 'Registered', 'profile-photo-for-MT-AMIS-25-1014-688e1da2b5f5e7.42807450.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1014-688e1da2b5f5e7.42807450.jpg', '2025-08-02 14:10:52'),
('MT-AMIS-25-1015', 'Vaibhav Rao', 'Vinod Rao', '1998-07-11', '2025-08-07', 6352513407, 'raovaibhav98@gmail.com', 713364476844, 'Adv MIS', 15000, 1000, 14000, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-08-07 14:52:01'),
('MT-AMIS-25-1017', 'Md Sarfaraj', 'Md Jamshed Alam', '2005-12-31', '2025-08-13', 7544817315, 'mdsarfaraj96201@gmail.com', 777181377791, 'Adv MIS', 16000, 1000, 15000, 'Registered', 'profile-photo-for-MT-AMIS-25-1017-689cb85c3bd400.54977914.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-1017-689cb85c3bd400.54977914.jpg', '2025-08-13 16:06:12'),
('MT-AMIS-25-202415', 'Abhishek Kumar', 'Arvind Rai', '2002-06-14', '2023-07-14', 8527956537, 'royabhishek9090@gmail.com', 232693037047, 'Adv MIS', 10000, 1000, 0, 'Completed', 'profile-photo-for-MT-AMIS-25-202415-68469bc58fb3f0.02528674.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-202415-68469bc58fb3f0.02528674.jpg', '2025-07-02 06:34:41'),
('MT-AMIS-25-202416', 'Anuj Kumar', 'Akhilesh Kumar', '2005-08-28', '2023-08-01', 8797516130, 'anujkumarthakur@gmail.com', 577712828036, 'Adv MIS', 10800, 1000, 0, 'Completed', 'profile-photo-for-MT-AMIS-25-202416-68469d255a36f5.00805095.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-202416-68469d255a36f5.00805095.jpg', '2025-07-02 06:34:41'),
('MT-AMIS-25-202520', 'Rupi Kumari', 'Jagdish', '2005-04-05', '2023-07-14', 9811902768, 'rupiy7146@gmail.com', 703949613557, 'Adv MIS', 0, 1000, 0, 'Completed', 'profile-photo-for-MT-AMIS-25-202520-68469aa9bfd372.40315422.jpg', '../../profile-photo/profile-photo-for-MT-AMIS-25-202520-68469aa9bfd372.40315422.jpg', '2025-07-02 06:34:41'),
('MT-DA-25-1007', 'Ankit Jha', 'Madan Jha', '2006-05-17', '2025-06-21', 8882611787, 'ankitjha8882611@gmail.com', 525174106884, 'Data Analytics', 25000, 1000, 24000, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-DA-25-1008', 'Kishan Kumar', 'Madan Jha', '2003-08-21', '2025-06-21', 8292004836, 'kishanmja@gmail.com', 720112947322, 'Data Analytics', 25000, 1000, 24000, 'Registered', 'default-profile-for-any-student-without-profile-picture-1234567890.png', '../../profile-photo/', '2025-07-02 06:34:41'),
('MT-DA-25-1009', 'Sudhanshu Singh', 'Manoj Singh', '2005-12-15', '2025-06-30', 9711772132, 'sudhanshurajput557@gmail.com', 346652754814, 'Data Analytics', 25000, 1000, 24000, 'Registered', 'profile-photo-for-MT-DA-25-1009-6862bda388cd11.70558942.jpg', '../../profile-photo/profile-photo-for-MT-DA-25-1009-6862bda388cd11.70558942.jpg', '2025-07-02 06:34:41'),
('MT-DA-25-1010', 'RITESH KUMAR', 'RAM SUDHAR SINGH', '2005-03-10', '2025-07-01', 9319832563, 'riteshkumar73228@gmail.com', 332785992467, 'Data Analytics', 25000, 1000, 24000, 'Registered', 'profile-photo-for-MT-DA-25-1010-6864160a8386c8.53884100.jpg', '../../profile-photo/profile-photo-for-MT-DA-25-1010-6864160a8386c8.53884100.jpg', '2025-07-02 06:34:41'),
('MT-DA-25-1011', 'Nitin', 'Deep Narayan', '2005-03-11', '2025-07-04', 9911451889, 'neilkumar090@gmail.com', 633978025073, 'Data Analytics', 25000, 1000, 24000, 'Registered', 'profile-photo-for-MT-DA-25-1011-6867ff55631f96.48066032.jpg', '../../profile-photo/profile-photo-for-MT-DA-25-1011-6867ff55631f96.48066032.jpg', '2025-07-04 16:18:56'),
('MT-DA-25-1012', 'Yogesh Kumar', 'Gireesh Kumar', '2004-08-25', '2025-07-06', 9548173914, 'yogeshsharmaojha@gmail.com', 907423906103, 'Data Analytics', 25000, 1000, 24000, 'Registered', 'profile-photo-for-MT-DA-25-1012-686a7153d609d5.10184459.jpg', '../../profile-photo/profile-photo-for-MT-DA-25-1012-686a7153d609d5.10184459.jpg', '2025-07-06 12:49:19'),
('MT-DM-25-1002', 'Abhay Kumar', 'Jai Prakash', '2003-08-19', '2025-06-09', 9971045539, 'abhaybajpai373@gmail.com', 685095273493, 'Digital Marketing', 35000, 500, 34500, 'Registered', 'profile-photo-for-MT-DM-25-1002-68444a43243260.50509625.jpg', '../../profile-photo/profile-photo-for-MT-DM-25-1002-68444a43243260.50509625.jpg', '2025-07-02 06:34:41'),
('MT-GDVD-25-1015', 'Rahul Kumar', 'Upendra Prasad', '2006-01-01', '2025-08-08', 7781918190, 'rahulkhuswaha65@gmail.com', 813175895916, 'Graphic Design And Video Editing', 35000, 2500, 32500, 'Registered', 'profile-photo-for-MT-GDVD-25-1015-6896171b124134.37894146.jpg', '../../profile-photo/profile-photo-for-MT-GDVD-25-1015-6896171b124134.37894146.jpg', '2025-08-08 15:25:06'),
('MT-MISA-202517', 'Rayal Kumar', 'Ranjit Saw', '2006-04-30', '2024-06-05', 8744943038, 'rayalsaw@gmail.com', 946289732209, 'Adv MIS', 12000, 1000, 0, 'Completed', 'profile-photo-for-MT-MISA-202517-68469f76a76cd6.21388095.jpg', '../../profile-photo/profile-photo-for-MT-MISA-202517-68469f76a76cd6.21388095.jpg', '2025-07-02 06:34:41'),
('MT-MSOE-25-1007', 'Upendra Kumar', 'Jay Shankar Prasad', '1994-12-08', '2025-07-21', 9155358722, 'upendrakumar915535@gmail.com', 364545971199, 'MS OFFICE EXCEL', 10000, 1000, 9000, 'Registered', 'profile-photo-for-MT-MSOE-25-1007-687e5109464893.95871103.jpg', '../../profile-photo/profile-photo-for-MT-MSOE-25-1007-687e5109464893.95871103.jpg', '2025-07-21 14:36:49'),
('MT-PY-25-1008', 'Khushi Saini', 'Dharamveer Saini', '2001-08-03', '2025-01-18', 9319942881, 'sainikhushi214@gmail.com', 653039908881, 'Python Programming', 7000, 2000, 0, 'Completed', 'profile-photo-for-MT-PY-25-1008-68808f897828b8.42741864.jpg', '../../profile-photo/profile-photo-for-MT-PY-25-1008-68808f897828b8.42741864.jpg', '2025-07-23 07:28:38'),
('MT-SMM-25-1007', 'Mohini Gupta', 'Amar Singh', '1989-07-15', '2025-06-25', 9760510302, 'mohiniguptaofficial@gmail.com', 269013581565, 'Social Media With AI', 20000, 14000, 0, 'Joined', 'profile-photo-for-MT-SMM-25-1007-685c3589c8d462.05887617.jpg', '../../profile-photo/profile-photo-for-MT-SMM-25-1007-685c3589c8d462.05887617.jpg', '2025-07-02 06:34:41'),
('MT-TLY-25-1001', 'Priyank', 'Om Parkash', '1998-11-24', '2025-08-06', 9870220140, 'rewariapriyank@gmail.com', 541845997564, 'Tally Prime', 5000, 1000, 2000, 'Registered', 'profile-photo-for-MT-TLY-25-1001-68936fcfb46ee3.61794229.jpg', '../../profile-photo/profile-photo-for-MT-TLY-25-1001-68936fcfb46ee3.61794229.jpg', '2025-08-06 15:05:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `stu_id` (`stu_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`cert_id`),
  ADD KEY `stu_id` (`stu_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
