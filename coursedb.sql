-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 08:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coursedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_credit` int(11) NOT NULL,
  `course_type` varchar(255) NOT NULL,
  `teachers_name` varchar(255) NOT NULL,
  `max_student` int(11) NOT NULL,
  `current_student` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `day` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_credit`, `course_type`, `teachers_name`, `max_student`, `current_student`, `time`, `day`, `department_name`, `grade`) VALUES
(879, '流體力學', 3, '必修', '黃振家', 60, 54, '0910~1200', 3, '土木工程系', 2),
(893, '工程地質', 2, '必修', '紀昭銘', 60, 54, '0910~1100', 2, '土木工程系', 3),
(895, '鋼結構設計', 3, '必修', '王起平', 60, 54, '0910~1200', 3, '土木工程系', 3),
(896, '營建管理', 3, '必修', '林保宏', 60, 31, '1410~1700', 4, '土木工程系', 3),
(901, '工程測量', 2, '選修', '林建良', 60, 54, '2025~2210', 3, '土木工程系', 3),
(906, '深開挖分析原理及程式應用', 3, '選修', '陳廣祥', 60, 44, '1830~2115', 3, '土木工程系', 3),
(908, '量測系統學', 2, '選修', '廖為忠', 60, 30, '1410~1600', 2, '土木工程系', 3),
(1200, '程式設計（一）', 2, '必修', '劉明機', 60, 55, '0810~1200', 3, '資訊工程系', 1),
(1260, '系統程式', 3, '必修', '劉宗杰', 60, 48, '1010~1200', 1, '資訊工程系', 2),
(1261, '資料庫系統', 3, '必修', '許懷中', 60, 48, '1010~1200', 2, '資訊工程系', 2),
(1262, '機率與統計', 3, '必修', '劉怡芬', 60, 48, '1410~1600', 4, '資訊工程系', 2),
(1263, '互連網路', 3, '選修', '劉宗杰', 60, 48, '1310~1600', 3, '資訊工程系', 2),
(1264, '多媒躰系統', 3, '選修', '葉春秀', 60, 48, '1310~1600', 2, '資訊工程系', 2),
(1265, '組合數學', 3, '選修', '游景盛', 60, 48, '1610~1800', 2, '資訊工程系', 2),
(1269, 'UNIX應用與實務', 3, '選修', '竇其仁', 60, 48, '1610~1800', 3, '資訊工程系', 2),
(1326, '計算機概論', 3, '必修', '劉明機\r\n', 60, 48, '1610~1800', 3, '資訊工程系', 1),
(1327, '程式設計（一）', 2, '必修', '蔡國裕', 60, 48, '0810~1200', 5, '資訊工程系', 1),
(1334, '計算機概論', 3, '必修', '林峰正', 60, 48, '1610~1800', 4, '資訊工程系', 1),
(2404, '科技人文導論', 2, '必修', '余風', 60, 61, '1010~1200', 1, '中文系', 1),
(2405, '現代文學史', 2, '必修', '鄭慧如', 70, 48, '1010~1200', 2, '中文系', 1),
(2408, '看動漫學英文', 2, '選修', '闕帝丰', 70, 59, '0810~1000', 1, '中文系', 1),
(2419, '新聞採訪與寫作', 2, '選修', '朱文光', 70, 57, '1510~1700', 1, '中文系', 2),
(2430, '影視劇本實作', 2, '選修', '劉梓潔', 60, 50, '1010~1200', 4, '中文系', 3),
(2480, '固態物理導論', 3, '選修', '蔡雅芝', 60, 47, '1510~1700', 3, '光電科學與工程學系', 2),
(2484, '光電半導體元件導論', 3, '必修', '唐謙仁', 62, 47, '1410~1700', 4, '光電科學與工程學系', 3),
(2485, '雷射與光子學導論', 3, '必修', '林泰生', 60, 47, '1010~1200', 1, '光電科學與工程學系', 3),
(2494, '數位光學造影技術', 3, '選修', '林昱志', 40, 26, '0910~1200', 4, '光電科學與工程學系', 3),
(2495, '積體光學', 3, '選修', '羅仕守', 60, 47, '1830~2115', 1, '光電科學與工程學系', 3);

-- --------------------------------------------------------

--
-- Table structure for table `courseselection`
--

CREATE TABLE `courseselection` (
  `student_id` varchar(10) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courseselection`
--

INSERT INTO `courseselection` (`student_id`, `course_id`) VALUES
('D0860618', 893),
('D0860618', 895),
('D0860618', 896),
('D0860618', 906),
('D0860618', 908),
('D0945297', 1260),
('D0945297', 1261),
('D0945297', 1262),
('D0945297', 1263),
('D0945297', 1265),
('D0945297', 1269),
('D0945297', 1334),
('D1031125', 1200),
('D1031125', 1261),
('D1031125', 1262),
('D1031125', 1263),
('D1031125', 1264),
('D1031125', 2430),
('D1061139', 2480),
('D1061139', 2484),
('D1061139', 2485),
('D1061139', 2494),
('D1061139', 2495),
('D1095589', 1260),
('D1095589', 1261),
('D1095589', 1262),
('D1095589', 1263),
('D1095589', 1264),
('D1095589', 1265),
('D1095589', 1269);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `department_name`, `grade`) VALUES
('D0860618', '孫嘉謙', '土木工程系', 3),
('D0945297', '林若安', '資訊工程系', 3),
('D1031125', '羅駿祥', '資訊工程系', 2),
('D1061139', '秦靜祥', '光電科學與工程學系\r\n', 3),
('D1095589', '盧重毓', '資訊工程系', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `courseselection`
--
ALTER TABLE `courseselection`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courseselection`
--
ALTER TABLE `courseselection`
  ADD CONSTRAINT `course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
