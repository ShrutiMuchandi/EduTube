-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 11:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edutube`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`) VALUES
(1, 'Computer Science (CS)'),
(2, 'Electronics & Communication (EC)'),
(3, 'Mechanical Engineering (ME)'),
(4, 'Civil Engineering (CE)'),
(5, 'Electrical & Electronics  (EE)');

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE `curriculum` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`id`, `name`) VALUES
(1, '2024 Scheme'),
(2, '2025 Scheme'),
(3, '2026 Scheme');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `name`) VALUES
(1, 'Shri Girish N. Parwathmath'),
(2, 'Mrs. Sumalata Hiremath');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `name`) VALUES
(1, '1st Sem'),
(2, '2nd Sem'),
(3, '3rd Sem'),
(4, '4th Sem'),
(5, '5th Sem'),
(6, '6th Sem');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `video_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `curriculum` varchar(100) DEFAULT NULL,
  `subject_name` varchar(150) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `lecturer` varchar(150) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `views_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `video_title`, `description`, `branch`, `semester`, `curriculum`, `subject_name`, `keywords`, `lecturer`, `youtube_url`, `created_at`, `views_count`) VALUES
(1, 'Python Loops Explained | For Loop & While Loop Tutorial for Beginners', 'Want to learn loops in Python quickly and easily? In this beginner-friendly tutorial, I explain Python loops step by step, including for loops, while loops, and practical examples to help you understand how repetition works in programming.\n\nThis video is perfect for Python beginners, students, and anyone starting programming. By the end of the video, you\'ll know how to use loops to automate tasks and write cleaner code.\n\n📌 In this video you will learn:\n• What loops are in Python\n• How for loops work\n• How while loops work\n• Simple examples for beginners\n• When to use each loop\n\nIf you\'re learning Python programming, this video will help you master one of the most important concepts.', 'Computer Science (CS)', '1st Sem', '2026 Scheme', 'Pyhton', 'Python, loops, while loops,  loops work, Python programming, beginners', 'Shri Girish N. Parwathmath', 'https://youtu.be/GuaFCmFAMhs?si=sjApPH1YgMlUnccF', '2026-04-16 20:46:40', 2),
(2, 'Python Functions Explained | Functions in Python for Beginners', 'In this video, you\'ll learn Functions in Python in a simple and beginner-friendly way. Functions are one of the most important concepts in programming because they help you reuse code, organize programs, and make coding easier.\n\nThis tutorial covers the basics of creating and using functions in Python, along with simple examples to help you understand how they work.\n\n📌 In this video you will learn:\n• What a function is in Python\n• How to create a function using def\n• How to call a function\n• Functions with parameters and arguments\n• Return values in functions\n• Simple examples for beginners\n\nThis video is perfect for students, beginners, and anyone starting Python programming.', 'Computer Science (CS)', '1st Sem', '2026 Scheme', 'Python', 'python loops, for loop,  while loop, loops in python explained', 'Shri Girish N. Parwathmath', 'https://youtu.be/sGpG3S4pRZ4?si=OWPFSj7SRcpWw3nC', '2026-04-16 20:51:10', 0),
(3, 'Python Operators Explained for Beginners (2026) 🔥 | All Types with Examples', 'n this video, you’ll understand all types of Python operators with clear explanations and real coding examples.\n\nThis tutorial is perfect for students, beginners, and anyone preparing for coding interviews or exams.\n\n✅ What you’ll learn:\n\nArithmetic Operators in Python\nComparison (Relational) Operators\nLogical Operators (and, or, not)\nAssignment Operators\nBitwise Operators Explained Simply\nIdentity & Membership Operators\n', 'Computer Science (CS)', '1st Sem', '2026 Scheme', 'Python', 'Arithmetic Operators , Comparison Operators, Logical Operators,  Assignment Operators, Bitwise Operators ', 'Shri Girish N. Parwathmath', 'https://youtu.be/2Y8B0JeG0k0?si=tMav6H64i0nWUXZb', '2026-04-16 20:55:42', 3),
(4, 'Computer Networks Explained Easily | PAN, LAN, MAN, WAN Basics for Beginners', 'Are you trying to understand Computer Networks in the easiest way possible? In this video, we explain the fundamental networking concepts including PAN, LAN, MAN, and WAN with clear examples and simple explanations.\n\nThis beginner-friendly tutorial is perfect for students, diploma learners, engineering aspirants, and anyone starting with networking.', 'Computer Science (CS)', '1st Sem', '2026 Scheme', ' Computer Networks', 'Computer Network, PAN  ,LAN,MAN  , WAN ', 'Mrs. Sumalata Hiremath', 'https://youtu.be/BKg7XyxhR48?si=Drj6B1jrCmbqUTRm', '2026-04-16 20:58:03', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
