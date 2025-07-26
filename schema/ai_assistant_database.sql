-- AI Assistant Database Schema
-- Table for storing predefined questions and answers for the AI assistant

CREATE TABLE IF NOT EXISTS `ai_assistant_faq` (
  `faq_id` INT AUTO_INCREMENT PRIMARY KEY,
  `question` VARCHAR(255) NOT NULL,
  `answer` TEXT NOT NULL,
  `category` VARCHAR(100) DEFAULT 'general',
  `display_order` INT DEFAULT 0,
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some initial predefined questions and answers
INSERT INTO `ai_assistant_faq` (`question`, `answer`, `category`, `display_order`) VALUES
('How do I find scholarships?', 'You can find scholarships by navigating to the Scholarships page from the main menu. There you can search and filter scholarships based on your qualifications and interests.', 'scholarships', 1),
('What is the application deadline?', 'Application deadlines vary by college and program. You can find specific deadline information on each college\'s details page.', 'application', 2),
('How do I create an account?', 'Click the "Sign Up" button in the top right corner of the page and fill out the registration form with your information.', 'account', 3),
('How can I compare colleges?', 'You can compare colleges using our Comparison Tool on the Find Colleges page. Select two or more institutions to see a side-by-side comparison of key metrics.', 'search', 4),
('What SAT/ACT scores do I need?', 'Required test scores vary by institution. You can find the average test scores for admitted students on each college\'s profile page.', 'admissions', 5),
('How do I contact a college directly?', 'Contact information for each college can be found on their details page, including admissions office phone numbers and email addresses.', 'contact', 6),
('What majors are available?', 'You can explore available majors by using the advanced search feature on the Find Colleges page, which allows you to filter by major or program.', 'academics', 7),
('How do I reset my password?', 'Click on "Log In", then select "Forgot Password" and follow the instructions sent to your email to reset your password.', 'account', 8),
('Where can I find financial aid information?', 'Financial aid information is available in the Resources section under "Financial Aid Guide" as well as on individual college profile pages.', 'financial', 9),
('How accurate is your college data?', 'Our data is sourced from official educational databases and is updated regularly. However, for the most current information, we recommend visiting the official college websites.', 'general', 10);

-- Table for storing user chat interactions with the AI assistant
CREATE TABLE IF NOT EXISTS `ai_assistant_chat_logs` (
  `log_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `session_id` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `is_user_message` BOOLEAN NOT NULL,
  `response_time` FLOAT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 