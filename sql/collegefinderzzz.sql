-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 08:42 AM
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
-- Database: `collegefinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_assistant_chat_logs`
--

CREATE TABLE `ai_assistant_chat_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_user_message` tinyint(1) NOT NULL,
  `response_time` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ai_assistant_chat_logs`
--

INSERT INTO `ai_assistant_chat_logs` (`log_id`, `user_id`, `session_id`, `message`, `is_user_message`, `response_time`, `created_at`, `ip_address`) VALUES
(1, 1, '0190f2e1edd2561c87e1b9d955d5b027', 'What majors are available?', 1, NULL, '2025-04-02 06:40:16', '::1'),
(2, 1, '0190f2e1edd2561c87e1b9d955d5b027', 'You can explore available majors by using the advanced search feature on the Find Colleges page, which allows you to filter by major or program.', 0, 0.000751972, '2025-04-02 06:40:16', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `ai_assistant_faq`
--

CREATE TABLE `ai_assistant_faq` (
  `faq_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT 'general',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ai_assistant_faq`
--

INSERT INTO `ai_assistant_faq` (`faq_id`, `question`, `answer`, `category`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'How do I find scholarships?', 'You can find scholarships by navigating to the Scholarships page from the main menu. There you can search and filter scholarships based on your qualifications and interests.', 'scholarships', 1, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(2, 'What is the application deadline?', 'Application deadlines vary by college and program. You can find specific deadline information on each college\'s details page.', 'application', 2, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(3, 'How do I create an account?', 'Click the \"Sign Up\" button in the top right corner of the page and fill out the registration form with your information.', 'account', 3, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(4, 'How can I compare colleges?', 'You can compare colleges using our Comparison Tool on the Find Colleges page. Select two or more institutions to see a side-by-side comparison of key metrics.', 'search', 4, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(5, 'What SAT/ACT scores do I need?', 'Required test scores vary by institution. You can find the average test scores for admitted students on each college\'s profile page.', 'admissions', 5, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(6, 'How do I contact a college directly?', 'Contact information for each college can be found on their details page, including admissions office phone numbers and email addresses.', 'contact', 6, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(7, 'What majors are available?', 'You can explore available majors by using the advanced search feature on the Find Colleges page, which allows you to filter by major or program.', 'academics', 7, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(8, 'How do I reset my password?', 'Click on \"Log In\", then select \"Forgot Password\" and follow the instructions sent to your email to reset your password.', 'account', 8, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(9, 'Where can I find financial aid information?', 'Financial aid information is available in the Resources section under \"Financial Aid Guide\" as well as on individual college profile pages.', 'financial', 9, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06'),
(10, 'How accurate is your college data?', 'Our data is sourced from official educational databases and is updated regularly. However, for the most current information, we recommend visiting the official college websites.', 'general', 10, 1, '2025-04-02 06:28:06', '2025-04-02 06:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL DEFAULT 'India',
  `category` varchar(100) NOT NULL,
  `ranking` int(11) NOT NULL,
  `tuition` int(11) NOT NULL,
  `acceptance_rate` decimal(5,2) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `google_maps_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `name`, `location`, `city`, `state`, `country`, `category`, `ranking`, `tuition`, `acceptance_rate`, `grade`, `description`, `logo_url`, `tags`, `google_maps_url`) VALUES
(1, 'Indian Institute of Technology, Bombay', 'Mumbai, Maharashtra', 'Mumbai', 'Maharashtra', 'India', 'india engineering science', 1, 250000, 5.00, 'A+', 'IIT Bombay is renowned for providing world-class education in engineering and technology. The institute offers comprehensive undergraduate, postgraduate and doctoral programs.', 'https://placehold.co/80x80?text=IIT+B', 'Engineering,Technology,Research', 'https://www.google.com/maps?q=IIT+Bombay'),
(2, 'Indian Institute of Technology, Delhi', 'New Delhi, Delhi', 'New Delhi', 'Delhi', 'international', 'india', 2, 220000, 7.00, 'A+', 'IIT Delhi is one of India\'s most prestigious engineering institutions known for its cutting-edge research and innovation. The campus offers diverse programs across engineering disciplines.', 'https://placehold.co/80x80?text=IIT+D', 'Engineering,Technology,Innovation', 'https://www.google.com/maps?q=IIT+Delhi'),
(3, 'Indian Institute of Science', 'Bangalore, Karnataka', 'Bangalore', 'Karnataka', 'India', 'india science', 3, 200000, 6.00, 'A++', 'IISc Bangalore is India\'s premier research institution focusing on scientific research and higher education. It offers advanced degrees in sciences, engineering, design, and management.', 'https://placehold.co/80x80?text=IISc', 'Research,Science,Technology', 'https://www.google.com/maps?q=IISc+Bangalore'),
(4, 'All India Institute of Medical Sciences', 'New Delhi, Delhi', 'New Delhi', 'Delhi', 'India', 'india medicine', 4, 120000, 15.00, 'A++', 'AIIMS is India\'s leading public medical school and hospital complex. It offers undergraduate, postgraduate and doctoral programs in medicine and related fields.', 'https://placehold.co/80x80?text=AIIMS', 'Medicine,Healthcare,Research', 'https://www.google.com/maps?q=IIT+Delhi'),
(5, 'Massachusetts Institute of Technology', 'Cambridge, USA', 'Cambridge', 'Massachusetts', 'india', 'international engineering science', 1, 4500000, 4.00, 'QS 1', 'MIT is a world-renowned private research university focused on scientific, technological, and other areas of scholarship. Known for pioneering research and producing notable alumni.', 'https://placehold.co/80x80?text=MIT', 'Technology,Engineering,Research', 'https://www.google.com/maps?q=MIT+Cambridge+MA'),
(6, 'Harvard University', 'Cambridge, USA', 'Cambridge', 'Massachusetts', 'USA', 'international arts science', 2, 4200000, 5.00, 'QS 3', 'Harvard is one of the most prestigious universities globally, offering excellence across disciplines from humanities to sciences. The university has an unparalleled legacy in education.', 'https://placehold.co/80x80?text=Harvard', 'Arts,Research,Business', 'https://www.google.com/maps?q=MIT+Cambridge+MA'),
(7, 'Stanford University', 'Stanford, California', 'Stanford', 'California', 'USA', 'international science engineering business', 3, 5200000, 4.30, 'QS 2', 'Stanford University is a private research university in Stanford, California. It is known for its academic achievements, wealth, proximity to Silicon Valley, and selectivity. Stanford offers a wide range of academic programs from humanities to sciences and engineering.', 'https://placehold.co/80x80?text=Stanford', 'Research,Engineering,Business,Computer Science', 'https://www.google.com/maps?q=Stanford+University'),
(8, 'National Institute of Technology, Trichy', 'Tiruchirappalli, Tamil Nadu', 'Tiruchirappalli', 'Tamil Nadu', 'India', 'india engineering south-india', 5, 125000, 10.00, 'A+', 'NIT Trichy is one of the premier engineering institutions in India, known for its high-quality education in various engineering disciplines. The institute offers undergraduate, postgraduate, and doctoral programs in engineering and technology.', 'https://placehold.co/80x80?text=NIT+T', 'Engineering,Technology,Computer Science', 'https://www.google.com/maps?q=National+Institute+of+Technology,+Trichy'),
(9, 'University of Oxford', 'Oxford, United Kingdom', 'Oxford', 'Oxfordshire', 'UK', 'international arts science', 4, 4000000, 17.50, 'QS 4', 'The University of Oxford is a collegiate research university in Oxford, England. It is the oldest university in the English-speaking world and consistently ranks among the top universities globally. Oxford offers a broad range of courses across humanities, sciences, medicine, and social sciences.', 'https://placehold.co/80x80?text=Oxford', 'Research,Medicine,Liberal Arts,Science', 'https://www.google.com/maps?q=University+of+Oxford'),
(10, 'Indian School of Business', 'Hyderabad, Telangana', 'Hyderabad', 'Telangana', 'India', 'india business south-india', 6, 3500000, 25.00, 'A++', 'The Indian School of Business (ISB) is a private business school with campuses in Hyderabad and Mohali. ISB offers various management programs and is known for its rigorous curriculum, diverse student body, and strong industry connections. It consistently ranks among the top business schools in Asia.', 'https://placehold.co/80x80?text=ISB', 'Business,Management,Finance,MBA', 'https://www.google.com/maps?q=Indian+School+of+Business');

-- --------------------------------------------------------

--
-- Table structure for table `college_applications`
--

CREATE TABLE `college_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `college_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `high_school` varchar(100) NOT NULL,
  `high_school_percentage` decimal(5,2) NOT NULL,
  `program_of_interest` varchar(100) NOT NULL,
  `entrance_exam` varchar(100) DEFAULT NULL,
  `entrance_score` varchar(50) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `personal_statement` text NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `parent_contact` varchar(15) NOT NULL,
  `documents_link` text DEFAULT NULL,
  `status` enum('Pending','Under Review','Accepted','Waitlisted','Rejected') DEFAULT 'Pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rejection_reason` text DEFAULT NULL COMMENT 'Reason for application rejection'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_applications`
--

INSERT INTO `college_applications` (`id`, `user_id`, `college_id`, `full_name`, `email`, `phone`, `address`, `dob`, `gender`, `high_school`, `high_school_percentage`, `program_of_interest`, `entrance_exam`, `entrance_score`, `achievements`, `personal_statement`, `parent_name`, `parent_contact`, `documents_link`, `status`, `applied_at`, `updated_at`, `rejection_reason`) VALUES
(1, NULL, 1, 'user', 'user@gmail.com', '1236547890', 'bfsbd', '2025-03-31', 'Male', 'kjsdjvn', 3.00, 'mca', '', '', 'no', 'Presidency University admissions are open. Interested candidates are requested to apply online for their desired course on the official university\'s website. A few more updates are given below:\r\n\r\nThe KCET 2025 registrations are closed now for admission to the BE/BTech and BPharm courses. The KCET 2025 exam is to be held on Apr 16 and Apr 17, 2025.\r\nThe CUET UG 2025 application correction window is open for admission to UG courses, and the last date is Mar 28, 2025. Additionally, the CUET UG 2025 exam will be conducted tentatively between May 8 and Jun 1, 2025.\r\nThe COMEDK UGET 2025 exam for admission to the BE/BTech courses will be held on May 10, 2025.Presidency University admissions are open. Interested candidates are requested to apply online for their desired course on the official university\'s website. A few more updates are given below:\r\n\r\nThe KCET 2025 registrations are closed now for admission to the BE/BTech and BPharm courses. The KCET 2025 exam is to be held on Apr 16 and Apr 17, 2025.\r\nThe CUET UG 2025 application correction window is open for admission to UG courses, and the last date is Mar 28, 2025. Additionally, the CUET UG 2025 exam will be conducted tentatively between May 8 and Jun 1, 2025.\r\nThe COMEDK UGET 2025 exam for admission to the BE/BTech courses will be held on May 10, 2025.Presidency University admissions are open. Interested candidates are requested to apply online for their desired course on the official university\'s website. A few more updates are given below:\r\n\r\nThe KCET 2025 registrations are closed now for admission to the BE/BTech and BPharm courses. The KCET 2025 exam is to be held on Apr 16 and Apr 17, 2025.\r\nThe CUET UG 2025 application correction window is open for admission to UG courses, and the last date is Mar 28, 2025. Additionally, the CUET UG 2025 exam will be conducted tentatively between May 8 and Jun 1, 2025.\r\nThe COMEDK UGET 2025 exam for admission to the BE/BTech courses will be held on May 10, 2025.', 'ahs', 'sdva', '', 'Under Review', '2025-04-01 06:44:18', '2025-04-02 10:27:05', NULL),
(2, NULL, 1, 'user', 'gawahen118@ikuromi.com', '7894561230', 'Jangamakote\r\nshidlaghatta (tq)\r\nchikkaballapur (D)', '2025-03-31', 'Male', 'kjsdjvn', 2.00, 'mca', '', '', 'aaaaaaaaaaaaa', 'I declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicatI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicat', 'ahs', 'sad', '', 'Pending', '2025-04-01 16:34:27', '2025-04-02 01:33:34', NULL),
(3, NULL, 1, '111111', 'yash@gmail.com', '1111111111', '1111111111', '2025-04-02', 'Male', 'kjsdjvn', 2.00, 'mca', '', '', '111111112das', 'Not Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new useNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userNot Found The requested URL was not found on this server.\r\n\r\nApache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80\r\n\r\nhttp://localhost/collegefinder/users/login.php?success=registration_complete\r\n\r\ni got above error while registering new userr', 'ahs', 'sdva', '', 'Waitlisted', '2025-04-01 17:04:40', '2025-04-02 05:31:16', NULL),
(4, NULL, 1, 'yashwanth babu j m', 'yashwanthbabu2022@gmail.com', '09845974515', 'Jangamakote\r\nshidlaghatta (tq)\r\nchikkaballapur (D)', '2025-03-30', 'Male', 'kjsdjvn', 0.01, 'mca', '', '', 'login\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.htmllogin\\login.html', 'Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.Please upload the following documents to Google Drive or Dropbox and share the link: Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), Letters of recommendation, and any other relevant certificates.', 'ahs', 'sdva', '', 'Rejected', '2025-04-01 17:14:27', '2025-04-02 06:56:33', 'sjdfkjadsbf'),
(5, 6, 1, 'yashwanth babu j m', 'yashwanthbabu2022@gmail.com', '09845974515', 'Jangamakote\r\nshidlaghatta (tq)\r\nchikkaballapur (D)', '2025-04-14', 'Male', 'kjsdjvn', 2.00, 'mca', 'cat', '223', 'nod', 'I declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\nI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.\r\n', 'ahs', 'sdva', '', 'Accepted', '2025-04-02 01:39:50', '2025-04-02 05:30:32', NULL),
(6, 4, 1, 'asdg', 'yash@gmail.com', 'zsgasd', 'zfgadfg', '2025-03-30', 'Male', 'skjbgksbg', 2.00, 'asdfsdgf', 'sD bfnm', '23', 'hteweryw', 'dtyer I declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my applicationI declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application', 'hgrd', 'gjfdtr', '', 'Rejected', '2025-04-08 03:00:29', '2025-04-08 08:03:20', 'ggser');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('new','read','replied','spam','archived') DEFAULT 'new',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `ip_address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'admin@hairproducts.com', '7896541230', 'XZXvc', 'zfse', '::1', 'new', '2025-04-08 13:03:32', NULL),
(2, 'Test User', 'admin@hairproducts.com', '7896541230', 'XZXvc', 'zfse', '::1', 'new', '2025-04-08 13:03:42', NULL),
(3, 'zzzzzzzzzzzz', 'admin@hairproducts.com', '7896541230', 'XZXvc', 'zfse', '::1', 'new', '2025-04-08 13:14:27', NULL),
(4, 'zzzzzzzzzzzz', 'admin@hairproducts.com', '7896541230', 'XZXvc', 'zfse', '::1', 'new', '2025-04-08 13:14:44', NULL),
(5, 'zzzzzzzzzzzz', 'admin@hairproducts.com', '7896541230', 'XZXvc', 'zfse', '::1', 'new', '2025-04-08 13:16:32', NULL),
(6, 'zzzzzzzzzzzz', 'asjfj@gmail.com', '2342342342', 'gasvdfsvd', 'mms dfb \r\n', '::1', 'new', '2025-04-08 13:27:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `deadline` date NOT NULL,
  `description` text NOT NULL,
  `eligibility` text NOT NULL,
  `min_gpa` decimal(3,2) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `country` varchar(50) DEFAULT 'India',
  `required_documents` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`id`, `name`, `organization`, `amount`, `deadline`, `description`, `eligibility`, `min_gpa`, `category`, `country`, `required_documents`, `created_at`) VALUES
(1, 'National Merit Scholarship', 'Ministry of Education', '₹50,000 - ₹1,00,000', '2025-05-30', 'The National Merit Scholarship is awarded to high-achieving students who demonstrate exceptional academic ability and potential.', 'Must be a citizen of India. Must be pursuing undergraduate studies. Must have scored at least 90% in 12th standard.', 1.00, 'Academic', 'India', 'Identity proof, Academic transcripts, Recommendation letter, Income certificate', '2025-04-01 06:25:31'),
(2, 'STEM Excellence Award', 'TechFuture Foundation', '₹75,000', '2025-05-15', 'This scholarship aims to encourage students pursuing careers in Science, Technology, Engineering and Mathematics fields.', 'Open to undergraduate and graduate students in STEM fields. Must demonstrate financial need. Must have completed at least one year of college education.', 1.00, 'STEM', 'India', 'Academic records, Research proposal or project description, Letter of recommendation from faculty', '2025-04-01 06:25:31'),
(3, 'Arts and Humanities Grant', 'Cultural Heritage Society', '₹40,000', '2025-05-20', 'Supporting students with exceptional talents in arts, literature, history, philosophy, and other humanities disciplines.', 'Open to students studying arts and humanities. Must submit a portfolio or sample work. Must demonstrate financial need.', 1.00, 'Arts', 'India', 'Portfolio of work, Academic transcripts, Statement of purpose, Financial documents', '2025-04-01 06:25:31'),
(4, 'First-Generation Student Scholarship', 'Education For All Trust', '₹60,000', '2025-05-10', 'Designed to support students who are the first in their family to attend college, helping to break the cycle of limited education opportunities.', 'Must be first in family to attend college/university. Family income should be below ₹5,00,000 per annum. Must maintain good academic standing.', 1.00, 'Need-based', 'India', 'Parent education declaration, Income certificate, Academic records, Statement of purpose', '2025-04-01 06:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_applications`
--

CREATE TABLE `scholarship_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `scholarship_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `institution` varchar(100) NOT NULL,
  `current_gpa` decimal(3,2) NOT NULL,
  `current_year` varchar(20) NOT NULL,
  `field_of_study` varchar(100) NOT NULL,
  `annual_income` varchar(50) NOT NULL,
  `documents_link` text DEFAULT NULL,
  `status` enum('Pending','Under Review','Approved','Rejected') DEFAULT 'Pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_applications`
--

INSERT INTO `scholarship_applications` (`id`, `user_id`, `scholarship_id`, `full_name`, `email`, `phone`, `address`, `institution`, `current_gpa`, `current_year`, `field_of_study`, `annual_income`, `documents_link`, `status`, `applied_at`) VALUES
(1, NULL, 1, 'user', 'user@gmail.com', '1236547890', 'sbfj', 'sj', 2.00, 'First Year', 'tech', 'Below ₹2,50,000', '', 'Pending', '2025-04-01 06:29:29'),
(2, 6, 1, 'yashwanth babu j m', 'yashwanthbabu2022@gmail.com', '09845974515', 'Jangamakote\r\nshidlaghatta (tq)\r\nchikkaballapur (D)', 'sj', 0.01, 'Second Year', 'tech', 'Below ₹2,50,000', '', 'Pending', '2025-04-02 01:42:26'),
(7, 4, 4, 'afdsg', 'yashwanthbabu2022@gmail.com', '2342342342', 'aehsfg', 'ame gsf', 2.00, 'First Year', 'bca', '₹2,50,000 - ₹5,00,000', '', 'Pending', '2025-04-08 05:54:16'),
(8, 4, 2, 'Ullas', 'ullas@gmail.com', '2342342342', 'a,jbfkjaegsfasdbfkjbsefasndf', 'jhbdskfkbshkbsndzcn', 2.00, 'First Year', 'mba', '₹2,50,000 - ₹5,00,000', 'https:/google.com', 'Pending', '2025-04-08 06:04:19'),
(9, 4, 2, 'jfhgd', 'ullas@gmail.com', '2342342342', 'a,jbfkjaegsfasdbfkjbsefasndf', 'jhbdskfkbshkbsndzcn', 2.00, 'First Year', 'mba', '₹2,50,000 - ₹5,00,000', 'https:/google.com', 'Pending', '2025-04-08 06:08:25'),
(10, 4, 2, 'jfhgd', '11111111@gmail.com', '2342342342', 'a,jbfkjaegsfasdbfkjbsefasndf', 'jhbdskfkbshkbsndzcn', 2.00, 'First Year', 'mba', '₹2,50,000 - ₹5,00,000', 'https:/google.com', 'Pending', '2025-04-08 06:13:00'),
(11, 4, 2, ',ansmdbfvasdbvksbdcsdx ,cmb s,dmc', 'admin@hairproducts.com', '2342342342sdfs', 'a sndfvhadsv fcbfs dfcf', 'sefsdc', 4.00, 'High School', 'mba', '₹2,50,000 - ₹5,00,000', '', 'Pending', '2025-04-08 06:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'uploads/default-profile.jpg',
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `phone`, `address`, `profile_picture`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '111', 'admin@gmail.com', 'admin', NULL, NULL, 'uploads/default-profile.jpg', 'admin', '2025-04-01 05:32:26', '2025-04-01 07:01:46'),
(2, 'user', '111', 'user@gmail.com', 'user', '', '', 'uploads/default-profile.jpg', 'user', '2025-04-01 05:32:26', '2025-04-01 16:48:24'),
(3, 'user2', '111', 'user2@gmail.com', 'user2', NULL, NULL, 'uploads/default-profile.jpg', 'user', '2025-04-01 16:49:04', '2025-04-01 16:49:04'),
(4, 'yash', '111', 'yash@gmail.com', 'yash', '', '', 'profile_67f4c1c1600f5.png', 'user', '2025-04-01 17:01:07', '2025-04-08 06:27:13'),
(5, 'puc', '111', 'gawahen118@ikuromi.com', 'puc', NULL, NULL, 'uploads/default-profile.jpg', 'user', '2025-04-01 17:02:37', '2025-04-01 17:02:37'),
(6, 'master', '111', 'master@gmail.com', 'chief', '09845974515', 'Jangamakote\r\nshidlaghatta (tq)\r\nchikkaballapur (D)', 'profile_67ec96a6018e2.jpg', 'user', '2025-04-01 17:09:09', '2025-04-02 01:45:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_assistant_chat_logs`
--
ALTER TABLE `ai_assistant_chat_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ai_assistant_faq`
--
ALTER TABLE `ai_assistant_faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `college_applications`
--
ALTER TABLE `college_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `college_id` (`college_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarship_applications`
--
ALTER TABLE `scholarship_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholarship_id` (`scholarship_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_assistant_chat_logs`
--
ALTER TABLE `ai_assistant_chat_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ai_assistant_faq`
--
ALTER TABLE `ai_assistant_faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `college_applications`
--
ALTER TABLE `college_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scholarship_applications`
--
ALTER TABLE `scholarship_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_assistant_chat_logs`
--
ALTER TABLE `ai_assistant_chat_logs`
  ADD CONSTRAINT `ai_assistant_chat_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `college_applications`
--
ALTER TABLE `college_applications`
  ADD CONSTRAINT `college_applications_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_college_app` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `scholarship_applications`
--
ALTER TABLE `scholarship_applications`
  ADD CONSTRAINT `fk_user_scholarship_app` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `scholarship_applications_ibfk_1` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
