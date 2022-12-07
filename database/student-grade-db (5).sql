-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2022 at 03:42 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student-grade-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `school_year` varchar(50) NOT NULL,
  `schedule` varchar(50) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `school_year`, `schedule`, `subject_id`) VALUES
(2, '2022-2023', '312312', 1),
(3, '2021-2022', 'dasd', 1),
(4, '2022-2023', '312312', 2);

-- --------------------------------------------------------

--
-- Table structure for table `class_attendance`
--

CREATE TABLE `class_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_attendance`
--

INSERT INTO `class_attendance` (`attendance_id`, `student_id`, `class_id`, `status`, `date`) VALUES
(1, 8, 2, 'present', ''),
(2, 9, 2, 'present', ''),
(3, 8, 2, 'absent', '2022-12-02'),
(4, 9, 2, 'present', '2022-12-02'),
(5, 8, 4, 'absent', '2022-12-06'),
(6, 9, 4, 'present', '2022-12-06'),
(7, 8, 4, 'present', '2022-12-07'),
(8, 9, 4, 'absent', '2022-12-07'),
(9, 9, 4, 'absent', ''),
(10, 8, 4, 'present', ''),
(11, 10, 4, 'absent', ''),
(12, 11, 4, 'present', ''),
(13, 8, 3, 'present', '2021-01-07'),
(14, 9, 3, 'present', '2021-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `class_grade`
--

CREATE TABLE `class_grade` (
  `grade_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `prerogative` float NOT NULL,
  `summative` float NOT NULL,
  `bonus` float NOT NULL,
  `exam` float NOT NULL,
  `total` float NOT NULL,
  `quarter` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_grade`
--

INSERT INTO `class_grade` (`grade_id`, `class_id`, `student_id`, `prerogative`, `summative`, `bonus`, `exam`, `total`, `quarter`) VALUES
(12, 4, 9, 25, 25, 1, 50, 100, '1st Quarter'),
(13, 2, 9, 5, 1, 1, 1, 8, '1st Quarter'),
(14, 2, 9, 20, 0, 0, 0, 20, '2nd Quarter'),
(15, 3, 9, 25, 0, 0, 50, 75, '1st Quarter');

-- --------------------------------------------------------

--
-- Table structure for table `class_member`
--

CREATE TABLE `class_member` (
  `class_member_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_member`
--

INSERT INTO `class_member` (`class_member_id`, `student_id`, `class_id`) VALUES
(13, 9, 4),
(15, 8, 4),
(20, 10, 4),
(21, 11, 4),
(22, 9, 2),
(23, 8, 3),
(24, 9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `lrn` varchar(50) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `guardian_name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `lrn`, `fullname`, `guardian_name`, `username`, `password`, `profile`, `gender`) VALUES
(8, '313', 'test', 'test', 'test', '1', 'upload/20221204041027logic.png', 'male'),
(9, '1', 'John Doe', 'John Doe', 'admin', '1', 'upload/20221204041027logic.png', 'Male'),
(10, '2', 'student1', '', 'student1', '1', 'upload/20221204041027logic.png', 'Female'),
(11, '3', 'student2', '', 'student2', '1', 'upload/20221204041027logic.png', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_title` varchar(100) NOT NULL,
  `grade_lvl` varchar(50) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_title`, `grade_lvl`, `teacher_id`) VALUES
(1, 'Math', 'Grade1', 1),
(2, 'English', 'Grade1', 1),
(3, 'Science', 'Grade1', 1),
(4, 'Filipino', 'Grade1', 1),
(5, 'Math', 'Grade 2', 2),
(6, 'English', 'Grade 2', 2),
(7, 'Science', 'Grade 2', 2),
(8, 'Filipino', 'Grade 2', 2),
(9, 'Filipino', 'Grade 3', 3),
(10, 'Math', 'Grade 3', 3),
(11, 'English', 'Grade 3', 3),
(12, 'Science', 'Grade 3', 3),
(14, 'Math', 'Grade 4', 4),
(15, 'English', 'Grade 4', 4),
(16, 'Science', 'Grade 4', 4),
(17, 'Filipino', 'Grade 4', 4),
(18, 'Math', 'Grade 5', 5),
(19, 'English', 'Grade 5', 5),
(20, 'Science', 'Grade 5', 5),
(21, 'Filipino', 'Grade 5', 5),
(22, 'Math', 'Grade 6', 6),
(23, 'English', 'Grade 6', 6),
(24, 'Science', 'Grade 6', 6),
(25, 'Filipino', 'Grade 6', 6),
(26, 'Mapeh', 'Grade 5', 7),
(27, 'Mapeh', 'Grade 6', 8),
(28, 'Hekasi', 'Grade 6', 9),
(29, 'Hekasi', 'Grade 5', 9);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `fullname`, `username`, `password`) VALUES
(1, 'teacher1', 'teacher1', '1'),
(2, 'teacher2', 'teacher2', '1'),
(3, 'teacher3', 'teacher3', '1'),
(4, 'teacher4', 'teacher4', '1'),
(5, 'teacher5', 'teacher5', '1'),
(6, 'teacher6', 'teacher6', '1'),
(7, 'teacher7', 'teacher7', '1'),
(8, 'teacher8', 'teacher8', '1'),
(9, 'teacher9', 'teacher9', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `class_attendance`
--
ALTER TABLE `class_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `class_grade`
--
ALTER TABLE `class_grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `class_member`
--
ALTER TABLE `class_member`
  ADD PRIMARY KEY (`class_member_id`),
  ADD KEY `class_member_ibfk_1` (`class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class_attendance`
--
ALTER TABLE `class_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `class_grade`
--
ALTER TABLE `class_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `class_member`
--
ALTER TABLE `class_member`
  MODIFY `class_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE;

--
-- Constraints for table `class_attendance`
--
ALTER TABLE `class_attendance`
  ADD CONSTRAINT `class_attendance_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `class_attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `class_grade`
--
ALTER TABLE `class_grade`
  ADD CONSTRAINT `class_grade_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `class_grade_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
