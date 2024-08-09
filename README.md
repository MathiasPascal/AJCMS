# Ashesi Judicial Case Management System (AJCMS)

## Table of Contents
1. [Project Overview](#project-overview)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Access Control](#access-control)
6. [Features](#features)
7. [Known Issues](#known-issues)
8. [Contributing](#contributing)
9. [License](#license)

## Project Overview
The **Ashesi Judicial Case Management System (AJCMS)** is a web-based application designed to manage judicial cases at Ashesi University. The system allows students and faculty to file complaints, view cases, and track case progress. It also features a voting system for faculty to determine case outcomes, a document management system for managing evidence, and an AI assistant to predict case verdicts based on historical data.

## Installation

### Prerequisites
- PHP 7.4 or later
- MySQL 5.7 or later
- Composer
- A web server (e.g., Apache, Nginx)

### Steps to Install
1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/ajcms.git
   cd ajcms


2. Install dependencies: composer install

**Set up the database:

Import the ajcms.sql file into your MySQL database.
Update the database credentials in settings/config.php.
Set up mailing:

Configure the SMTP settings in the sendEmailNotification function within schedules.php.
Run the application:

Start your web server and navigate to the project folder.
Configuration
All configuration settings, including database credentials and SMTP settings, are stored in settings/config.php.
Ensure that the vendor directory is present after running composer install.

Usage
Access Control

Students:

Access to view their specific cases on the Cases page.
Can file complaints through the Complaints page.
Can view evidence related to their cases on the Evidence page.
Limited access to other dashboard functionalities.

Faculty:

Access to Case Management, Schedules, Voting, and Reports.
Can vote on cases and track overall case statistics.
Can schedule new case hearings and manage existing cases.
Admins:

Full access to all system functionalities, including user management, document management, and AI assistant integration.
Access to view and manage all cases, regardless of the user involved.

Logging In
Users can log in using their university email credentials via the Login page.
After logging in, the user will be redirected to their respective dashboards based on their role (student, faculty, or admin).

Registering
New users can register through the Register page, where they will need to provide their university email and a unique ID number. Upon successful registration, they will be assigned a role (student or faculty) based on their provided details.

Features
Case Management: Faculty can schedule hearings, manage cases, and view case statistics.

Complaint Filing: Students can file complaints which are then reviewed by the faculty.

Voting System: Faculty can vote on the outcomes of cases. A verdict is reached when a minimum of 5 votes are cast in favor of either "guilty" or "not guilty."

Document Management: Faculty and admins can manage evidence related to cases, ensuring proper documentation and retrieval.

AI Assistant: An AI assistant helps predict case outcomes based on historical data, aiding the faculty in decision-making.

Email Notifications: Automatic email notifications are sent to students when a hearing is scheduled, ensuring they are informed in advance.

Known Issues
SMTP Configuration: Ensure the SMTP settings are correct in schedules.php to avoid issues with email notifications. See the installation section for details on configuring SMTP with PHPMailer.

Role-Based Access: Ensure that users are assigned the correct role during registration to avoid access issues.


Contributing
Contributions are welcome! If you would like to contribute to this project, please fork the 
repository and create a pull request. You can also report issues and suggest features by opening a
new issue.
