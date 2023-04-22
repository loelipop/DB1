-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2023 at 01:55 PM
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
(1200, '程式設計（一）', 2, '必修', '劉明機', 10, 7, '0800~1200', 3, '資訊工程系', 1),
(1260, '系統程式', 3, '必修', '劉宗杰', 10, 7, '1000~1200', 1, '資訊工程系', 2),
(1261, '資料庫系統', 3, '必修', '許懷中', 10, 7, '1000~1200', 2, '資訊工程系', 2),
(1262, '機率與統計', 3, '必修', '劉怡芬', 10, 7, '1400~1600', 4, '資訊工程系', 2),
(1263, '互連網路', 3, '選修', '劉宗杰', 10, 7, '1300~1600', 3, '資訊工程系', 2),
(1264, '多媒躰系統', 3, '選修', '葉春秀', 10, 7, '1300~1600', 2, '資訊工程系', 2),
(1265, '組合數學', 3, '選修', '游景盛', 10, 7, '1600~1800', 2, '資訊工程系', 2),
(1269, 'UNIX應用與實務', 3, '選修', '竇其仁', 10, 7, '1600~1800', 3, '資訊工程系', 2),
(1334, '計算機概論', 3, '必修', '林峰正', 10, 7, '1600~1800', 4, '資訊工程系', 1);

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
('D0860618', 1200),
('D0860618', 1260),
('D0860618', 1262),
('D0860618', 1263),
('D0860618', 1264),
('D0860618', 1269),
('D0860618', 1334),
('D0945297', 1260),
('D0945297', 1261),
('D0945297', 1262),
('D0945297', 1263),
('D0945297', 1265),
('D0945297', 1269),
('D0945297', 1334),
('D1031125', 1260),
('D1031125', 1261),
('D1031125', 1262),
('D1031125', 1263),
('D1031125', 1264),
('D1031125', 1265),
('D1031125', 1269),
('D1061139', 1260),
('D1061139', 1261),
('D1061139', 1262),
('D1061139', 1263),
('D1061139', 1264),
('D1061139', 1265),
('D1061139', 1269),
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
('D0860618', '孫嘉謙', '資訊工程系', 4),
('D0945297', '林若安', '資訊工程系', 3),
('D1031125', '羅駿祥', '資訊工程系', 2),
('D1061139', '秦靜祥', '資訊工程系', 2),
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
