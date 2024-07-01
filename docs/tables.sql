SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `applications`, `jobs`, `categories`, `locations`, `roles`, `applicants`, `employers`, `administrators`, `job_types`;

CREATE TABLE `administrators` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(60) NOT NULL,
  `role` int NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `applicants` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `profile_picture` LONGBLOB NULL,
  `description` varchar(200) NOT NULL,
  `studentID` int NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone_number` varchar(15),
  `role` int NOT NULL,
  `resume_doc` LONGBLOB NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `employers` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `company_name` varchar(60) NOT NULL,
  `recruiter_firstname` varchar(20) NOT NULL,
  `recruiter_lastname` varchar(20) NOT NULL,
  `profile_picture` LONGBLOB NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone_number` varchar(15),
  `role` int NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `locations` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `location` varchar(25) NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `jobs` (
  `job_id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `employer_id` int NOT NULL,
  `location_id` int NOT NULL,
  `category_id` int NOT NULL,
  `details_doc` LONGBLOB NULL,
  `job_type_id` int NOT NULL,
  `created_at` timestamp DEFAULT (now())
);
CREATE TABLE `job_types` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `job_type` varchar(30) NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

CREATE TABLE `applications` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `applicant_id` int NOT NULL,
  `created_at` timestamp DEFAULT (now())
);

ALTER TABLE `administrators` ADD FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `applicants` ADD FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `employers` ADD FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `jobs` ADD FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE CASCADE;

ALTER TABLE `jobs` ADD FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

ALTER TABLE `jobs` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

ALTER TABLE `jobs` ADD FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`id`) ON DELETE CASCADE;

ALTER TABLE `applications` ADD FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

ALTER TABLE `applications` ADD FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;



-- insert to roles
INSERT INTO `roles` (`role_name`) VALUES 
('administrator'),
('employer'),
('applicant');

-- insert to categories
INSERT INTO `categories` (`category`) VALUES
('Information Technology'),
('Healthcare'),
('Engineering'),
('Finance'),
('Marketing'),
('Sales'),
('Education'),
('Hospitality'),
('Retail'),
('Arts and Entertainment'),
('Legal'),
('Human Resources'),
('Customer Service'),
('Manufacturing');

INSERT INTO `locations` (`location`) VALUES
('Belize'),
('Cayo'),
('Corozal'),
('Orange Walk'),
('Stann Creek'),
('Toledo');

-- Inserting employers
INSERT INTO employers (company_name, recruiter_firstname, recruiter_lastname, email, password, role)
VALUES
('Tech Solutions Inc.', 'John', 'Doe', 'employer1@example.com', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 2), -- Hash of "password"
('Data Management Corp.', 'Jane', 'Smith', 'employer2@example.com', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 2), -- Hash of "password"
('Innovative Solutions Ltd.', 'Mike', 'Johnson', 'employer3@example.com', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 2); -- Hash of "password"

-- Inserting applicants
INSERT INTO applicants (firstname, lastname, description, studentID, email, password, role)
VALUES
('Alice', 'Anderson', 'I am a hard worker...', 123456, 'applicant1@example.com', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 3), -- Hash of "password"
('Bob', 'Brown', 'Making progress steadily...', 789012, 'applicant2@example.com', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 3), -- Hash of "password"
('Carol', 'Clark', 'As a designer, I am motivated to ...', 345678, 'applicant3@example.com', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 3); -- Hash of "password"

-- Inserting administrators
INSERT INTO administrators (username, password, email, role)
VALUES
('admin1', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 'admin1@example.com', 1), -- Hash of "password"
('admin2', '$2y$10$DmRhZQ5j1o5XBB5ACOpx5O15NNvyTXKFff7HRrzwN47KXbY7BFLIu', 'admin2@example.com', 1); -- Hash of "password"

-- Inserting jobs
INSERT INTO jobs (title, description, employer_id, location_id, category_id, job_type_id)
VALUES
('Software Developer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...', 1, 1, 1, 1),
('Database Administrator', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...', 2, 2, 2, 2),
('Web Developer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...', 3, 3, 3, 3);

-- Inserting job types
INSERT INTO job_types (job_type)
VALUES
('Internship'),
('Full Time'),
('Part Time'),
('Contract');

-- Inserting applications
INSERT INTO applications (job_id, applicant_id)
VALUES
(1, 1),
(2, 2),
(3, 3);


