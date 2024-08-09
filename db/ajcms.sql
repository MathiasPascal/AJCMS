-- Create the database
CREATE DATABASE if not exists AJCsystem;
USE AJCsystem;

-- Create the roles table to store different roles
CREATE TABLE `roles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL UNIQUE
);

-- Create the users table to store all users of the system
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(100) NOT NULL,
  `role_id` INT NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);

-- Create the case_types table to store different types of cases
CREATE TABLE `case_types` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_type` ENUM('Social Misconduct', 'Sexual Misconduct', 'Academic Misconduct') NOT NULL
);

-- Create the case_stage table to define the different stages of a case
CREATE TABLE `case_stage` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `status` ENUM('Pending', 'Completed') DEFAULT 'Pending'
);

-- Create the legal_acts table to list legal acts associated with cases
CREATE TABLE `legal_acts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `act_name` VARCHAR(100) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active'
);

-- Create the punishments table to contain possible punishments for cases
CREATE TABLE `punishments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `punishment_type` ENUM('1-year suspension', 'expulsion', '1-semester suspension', 'failing grade in quiz', 'failing grade in course') NOT NULL,
  `severity` INT NOT NULL
);

-- Create the case_register table to store information about registered cases
CREATE TABLE `case_register` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL,
  `case_no` VARCHAR(20) NOT NULL UNIQUE,
  `student_id` INT NOT NULL,
  `case_type_id` INT NOT NULL,
  `case_stage_id` INT NOT NULL,
  `legal_act_id` INT NOT NULL,
  `evidence_found` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `filling_date` DATE NOT NULL,
  `hearing_date` DATE NOT NULL,
  `punishment_id` INT,
  `verdict` ENUM('Guilty', 'Not Guilty', 'Pending') DEFAULT 'Pending',
  FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`case_type_id`) REFERENCES `case_types` (`id`),
  FOREIGN KEY (`case_stage_id`) REFERENCES `case_stage` (`id`),
  FOREIGN KEY (`legal_act_id`) REFERENCES `legal_acts` (`id`),
  FOREIGN KEY (`punishment_id`) REFERENCES `punishments` (`id`)
);

-- Create the evidence table to store evidence associated with each case
CREATE TABLE `evidence` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` INT NOT NULL,
  `evidence_type` ENUM('witness account', 'voice recording', 'text', 'contract') NOT NULL,
  `evidence_details` TEXT NOT NULL,
  `is_valid` BOOLEAN DEFAULT 0,
  FOREIGN KEY (`case_id`) REFERENCES `case_register` (`id`) ON DELETE CASCADE
);

-- Create the case_votes table to store votes for cases
CREATE TABLE `case_votes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `vote` ENUM('Guilty', 'Not Guilty') NOT NULL,
  `vote_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`case_id`) REFERENCES `case_register` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);


-- Insert data into the roles table
INSERT INTO `roles` (`role_name`) VALUES 
  ('dean'),
  ('academic_chair'),
  ('jec'),
  ('hod'),
  ('faculty'),
  ('student');

-- Insert data into the case_types table
INSERT INTO `case_types` (`case_type`) VALUES 
  ('Social Misconduct'),
  ('Sexual Misconduct'),
  ('Academic Misconduct');

-- Insert data into the case_stage table
INSERT INTO `case_stage` (`name`, `status`) VALUES 
  ('Investigation', 'Pending'),
  ('Hearing', 'Pending'),
  ('Deliberation', 'Pending'),
  ('Judgment', 'Pending'),
  ('Closed', 'Completed');

-- Insert data into the legal_acts table
INSERT INTO `legal_acts` (`act_name`, `status`) VALUES 
  ('Code of Conduct Violation', 'active'),
  ('Academic Integrity Policy Breach', 'active'),
  ('Harassment and Discrimination Policy', 'active');

-- Insert data into the punishments table
INSERT INTO `punishments` (`punishment_type`, `severity`) VALUES 
  ('1-year suspension', 3),
  ('expulsion', 3),
  ('1-semester suspension', 2),
  ('failing grade in quiz', 1),
  ('failing grade in course', 1);

-- Sample insertion of users
INSERT INTO `users` (`name`, `email`, `password`, `role_id`, `status`) VALUES 
  ('Alice Dean', 'alice.dean@ajc.edu', 'password123', 1, 'active'),
  ('Bob Chair', 'bob.chair@ajc.edu', 'password123', 2, 'active'),
  ('Charlie JEC', 'charlie.jec@ajc.edu', 'password123', 3, 'active'),
  ('David HOD', 'david.hod@ajc.edu', 'password123', 4, 'active'),
  ('Eve Faculty', 'eve.faculty@ajc.edu', 'password123', 5, 'active'),
  ('Frank Student', 'frank.student@ajc.edu', 'password123', 6, 'active');

-- Sample insertion of cases
INSERT INTO `case_register` (`title`, `case_no`, `student_id`, `case_type_id`, `case_stage_id`, `legal_act_id`, `evidence_found`, `description`, `filling_date`, `hearing_date`, `punishment_id`, `verdict`) VALUES 
  ('Academic Misconduct Case', 'CASE001', 6, 3, 1, 2, 'Plagiarism detected in assignment', 'Student submitted plagiarized content in the final assignment.', '2024-06-15', '2024-07-15', 4, 'Pending'),
  ('Social Misconduct Case', 'CASE002', 6, 1, 2, 1, 'Inappropriate behavior reported', 'Student exhibited inappropriate behavior during campus event.', '2024-06-20', '2024-07-20', 3, 'Pending');

-- Sample insertion of evidence
INSERT INTO `evidence` (`case_id`, `evidence_type`, `evidence_details`, `is_valid`) VALUES 
  (1, 'text', 'Turnitin report showing 90% similarity', 1),
  (2, 'witness account', 'Witness account from event organizer', 1);