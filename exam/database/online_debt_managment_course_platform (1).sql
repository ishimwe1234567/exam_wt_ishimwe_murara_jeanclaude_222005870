-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 12:49 AM
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
-- Database: `online_debt_managment_course_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `coursemodules`
--

CREATE TABLE `coursemodules` (
  `module_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_description` text DEFAULT NULL,
  `module_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coursemodules`
--

INSERT INTO `coursemodules` (`module_id`, `course_id`, `module_name`, `module_description`, `module_order`) VALUES
(1, 4, 'Overview of Debt Collection Laws', ' Introduction to Debt Collection Laws', 2),
(2, 4, 'Recent Developments and Case Studies', 'Overview of Debt Collection Laws', 1),
(3, 5, 'Overview of Debt Collection Laws', 'Legal Remedies and Enforcement', 4),
(4, 5, 'State-Specific Debt Collection Laws Laws', 'Overview of Debt Collection Laws', 3);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `instructor_id`, `description`, `start_date`, `end_date`, `price`, `status`) VALUES
(4, 'Bankruptcy and Its Alternatives', 1, 'bankruptcy and debt management', '2024-06-01', '2024-07-01', 99.99, 'upcoming'),
(5, 'Introduction to Debt Management', 2, 'introduction to debt managements ', '2024-06-01', '2024-07-01', 79.99, 'upcoming'),
(6, 'Advanced Debt Consolidation Techniques', 3, 'advanced ddebt consolidation techniques', '2024-06-01', '2024-07-01', 149.99, 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `debtmanagementresources`
--

CREATE TABLE `debtmanagementresources` (
  `resource_id` int(11) NOT NULL,
  `resource_type` varchar(255) NOT NULL,
  `resource_title` varchar(255) NOT NULL,
  `resource_description` text DEFAULT NULL,
  `resource_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `debtmanagementresources`
--

INSERT INTO `debtmanagementresources` (`resource_id`, `resource_type`, `resource_title`, `resource_description`, `resource_url`) VALUES
(1, 'article', 'Debt Management 101', 'Introduction to debt management.', 'https://risk mangemente.com/article'),
(2, 'video', 'Debt Management Strategies', 'Video explaining debt management strategies.', 'https://estate plann.com/video1'),
(4, 'article', 'Debt Consolidation Explained', 'Article explaining debt consolidation.', 'https://example.com/article2'),
(5, 'video', 'Tips for Getting Out of Debt', 'Video with tips for getting out of debt.', 'https://courses.com/video'),
(6, 'video', 'management', 'calculate', 'www.igit net');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `user_id`, `course_id`, `enrollment_date`) VALUES
(6, 1, 4, '2024-05-14'),
(7, 2, 4, '2024-05-11'),
(8, 3, 5, '2024-05-12'),
(10, 2, 6, '2024-05-22'),
(11, 3, 6, '2024-05-22'),
(12, 2, 5, '2024-05-28'),
(13, 1, 4, '2024-05-17'),
(142, 2, 5, '2024-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `expertise_area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `user_id`, `bio`, `expertise_area`) VALUES
(1, 1, 'John Smith  with 20+ years in banking and financial services', '1'),
(2, 2, 'Jane Doe  Certified financial advisor with 15+ years in debt management and personal finance', '2'),
(3, 3, 'Emily Johnson  Licensed bankruptcy attorney with 10+ years of experience. Graduated from Harvard Law School', '4'),
(4, 4, 'Michael Lee  Financial coach with expertise in student loan management and credit repair. Holds a Bachelor&#039;s in Economics and a CFP designation. Works with nonprofits on financial counseling.', '7');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moduleresources`
--

CREATE TABLE `moduleresources` (
  `resource_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `resource_type` enum('PDF','Video','Link','Text') NOT NULL,
  `resource_title` varchar(255) NOT NULL,
  `resource_description` text DEFAULT NULL,
  `resource_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moduleresources`
--

INSERT INTO `moduleresources` (`resource_id`, `module_id`, `resource_type`, `resource_title`, `resource_description`, `resource_url`) VALUES
(6, 1, 'PDF', 'Understand Your Debt Situation', 'The Psychology of Debt', 'https://www.debtmanagementplatform.com/resources/top-5-debt-management-tips.'),
(7, 1, 'Video', '&amp;amp;quot;Budget Planning Spreadsheet&amp;amp;quot;', 'Guide to Creating a Debt Management Plan', 'https://www.debtmanagementplatform.com/resources/the-psychology-of-debt'),
(8, 2, 'PDF', '10 Tips for Negotiating with Creditors', 'Debt Consolidation Explained', 'https://www.debtmanagementplatform.com/resources/10-tips-for-negotiating-with-creditors'),
(9, 2, 'Video', 'How to Improve Your Credit Score', 'Tips for Negotiating with Creditors', 'https://coursese.com/module2.mp4'),
(10, 3, 'PDF', 'Guide to Creating a Debt Management Plan', 'Financial Wellness Interviews', 'https:riske.com/module3.pdf'),
(12, 4, 'Video', 'Guide to Creating a Debt Management Plan', 'Are You Ready for Retirement', 'https://www.debtmanagementplatform.com/resources/quiz-are-you-ready-for-retirement');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','refunded') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_id`, `course_id`, `payment_date`, `amount`, `payment_status`) VALUES
(1, 1, 4, '2024-05-10', 99.99, 'completed'),
(2, 2, 5, '2024-05-11', 79.99, 'completed'),
(3, 3, 5, '2024-05-12', 149.99, 'completed'),
(4, 1, 6, '2024-05-13', 199.99, 'completed'),
(5, 2, 6, '2024-05-14', 199.99, 'completed'),
(7, 2, 6, '2024-05-15', 30.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `quizattempts`
--

CREATE TABLE `quizattempts` (
  `attempt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempt_date` date NOT NULL,
  `score` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizattempts`
--

INSERT INTO `quizattempts` (`attempt_id`, `user_id`, `quiz_id`, `attempt_date`, `score`) VALUES
(12, 2, 6, '2024-05-11', 78.00),
(13, 3, 7, '2024-05-12', 100.00),
(14, 1, 7, '2024-05-13', 75.00),
(15, 2, 7, '2024-05-14', 80.00),
(16, 4, 8, '2024-05-14', 85.00),
(17, 5, 8, '2024-05-14', 85.00);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `quiz_description` text DEFAULT NULL,
  `passing_score` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `module_id`, `quiz_name`, `quiz_description`, `passing_score`) VALUES
(6, 1, 'Quiz 2', 'Description for Quiz 1', 80.00),
(7, 1, 'Quiz 2', 'Description for Quiz 2', 75.00),
(8, 2, 'Quiz 1', 'Description for Quiz 1', 80.00),
(9, 2, 'Quiz 2', 'Description for Quiz 2', 75.00),
(10, 3, 'Quiz 1', 'Description for Quiz 1', 80.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','instructor','admin') NOT NULL,
  `registration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `registration_date`) VALUES
(1, 'kivumbi king', 'kivumbi@gmai.com', 'password123', 'student', '2024-05-01'),
(2, 'meddy smith', 'meddy@gmail.com', 'password456', 'student', '2024-05-02'),
(3, 'kevin kade', 'kevin@gmail.com', 'password789', 'admin', '2024-05-03'),
(4, 'murara ishimwe', 'murara@gmail.com', 'passwordabc', 'student', '2024-05-04'),
(5, 'emmy gizzo', 'emmy@gmail.com', 'passworddef', 'student', '2024-05-05'),
(234567, 'murarajeanclaudeishimwe@gmail.com', 'murarajeanclaudeishimwe@gmail.com', '222005870', 'instructor', '2024-05-14'),
(234568, 'sibo jean', 'sibojean@gmail.com', 'abcr', 'student', '0000-00-00'),
(234571, 'ishimwe', 'murara@gmail.com', '$2y$10$YcLqthHpFVzivN1jgWApiuBT1FyMc75WbdNiUAynXcoICvRC49p.2', '', '2024-05-07'),
(234572, 'gat', 'gat@gmail.com', '$2y$10$RostJHIrhvEepY3dhVZK9eCJOgDCdJkw1PknHGHfgq.XMGN0XI4tW', '', '2024-05-07'),
(234573, 'janvier', 'janvier@gmail.com', '$2y$10$Aoy4WgaKkMSd07R8SRnv6OC6.6.LZJn940vCB4Wkr7oq956ZxKiei', '', '2024-05-08'),
(234574, 'steven@gmail.com', 'srti@gmail.com', '$2y$10$Q4qVS956/xfnIUwez9oUje68vG.FV7Cnurwu9.bXf21HLT6fJVJxy', '', '2024-05-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coursemodules`
--
ALTER TABLE `coursemodules`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `debtmanagementresources`
--
ALTER TABLE `debtmanagementresources`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moduleresources`
--
ALTER TABLE `moduleresources`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quizattempts`
--
ALTER TABLE `quizattempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coursemodules`
--
ALTER TABLE `coursemodules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `debtmanagementresources`
--
ALTER TABLE `debtmanagementresources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moduleresources`
--
ALTER TABLE `moduleresources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quizattempts`
--
ALTER TABLE `quizattempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234575;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coursemodules`
--
ALTER TABLE `coursemodules`
  ADD CONSTRAINT `coursemodules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `moduleresources`
--
ALTER TABLE `moduleresources`
  ADD CONSTRAINT `moduleresources_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `coursemodules` (`module_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `quizattempts`
--
ALTER TABLE `quizattempts`
  ADD CONSTRAINT `quizattempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `quizattempts_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `coursemodules` (`module_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
