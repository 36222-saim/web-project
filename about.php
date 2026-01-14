<?php
/**
 * About Page - Project information and group member details
 * CSC 337 - Web Programming Languages - Assignment 4
 */

require_once 'config/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php if (isLoggedIn()): ?>
        <?php include 'includes/header.php'; ?>
    <?php else: ?>
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <h2>Student Management System</h2>
                </div>
                <div class="navbar-menu">
                    <a href="index.php">Home</a>
                    <a href="about.php">About</a>
                    <a href="auth/login.php" class="btn btn-sm btn-primary">Login</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <div class="container">
        <div class="about-header">
            <h1>About This Project</h1>
            <p class="subtitle">CSC 337 - Web Programming Languages - Assignment 4</p>
        </div>

        <!-- Project Overview -->
        <div class="about-section">
            <h2>Project Overview</h2>
            <p>
                The <strong>Student Management System</strong> is a comprehensive web-based application developed
                as part of the CSC 337 Web Programming Languages course assignment. This system demonstrates
                the implementation of full CRUD (Create, Read, Update, Delete) operations using PHP and MySQL database.
            </p>
            <p>
                The project aims to provide an efficient solution for educational institutions to manage student
                records, including personal information, academic performance, and enrollment details.
            </p>
        </div>

        <!-- Problem Statement -->
        <div class="about-section">
            <h2>Problem Statement</h2>
            <p>
                Educational institutions face challenges in managing student data efficiently. Manual record-keeping
                is time-consuming, prone to errors, and difficult to maintain. There is a need for a digital solution
                that allows administrators to:
            </p>
            <ul>
                <li>Add new student records quickly and accurately</li>
                <li>View and search student information efficiently</li>
                <li>Update student details as needed</li>
                <li>Remove outdated or incorrect records</li>
                <li>Track student status and academic performance</li>
            </ul>
        </div>

        <!-- Objectives -->
        <div class="about-section">
            <h2>Project Objectives</h2>
            <ul>
                <li>Develop a fully functional PHP-based web application with database integration</li>
                <li>Implement complete CRUD operations for student records</li>
                <li>Create a secure authentication system for user access control</li>
                <li>Design an intuitive and user-friendly interface</li>
                <li>Demonstrate real-world web development skills and best practices</li>
                <li>Deploy a live, operational website accessible online</li>
            </ul>
        </div>

        <!-- Technology Stack -->
        <div class="about-section">
            <h2>Technology Stack</h2>
            <div class="tech-details">
                <div class="tech-category">
                    <h3>Backend</h3>
                    <ul>
                        <li><strong>PHP 7.4+</strong> - Server-side scripting language</li>
                        <li><strong>MySQL</strong> - Relational database management system</li>
                        <li><strong>PDO/MySQLi</strong> - Database connectivity</li>
                    </ul>
                </div>
                <div class="tech-category">
                    <h3>Frontend</h3>
                    <ul>
                        <li><strong>HTML5</strong> - Markup structure</li>
                        <li><strong>CSS3</strong> - Styling and responsive design</li>
                        <li><strong>JavaScript</strong> - Client-side interactions</li>
                    </ul>
                </div>
                <div class="tech-category">
                    <h3>Development Tools</h3>
                    <ul>
                        <li><strong>Git/GitHub</strong> - Version control</li>
                        <li><strong>XAMPP/WAMP</strong> - Local development environment</li>
                        <li><strong>phpMyAdmin</strong> - Database management</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- System Features -->
        <div class="about-section">
            <h2>System Features</h2>
            <div class="features-list">
                <div class="feature-item">
                    <h3>✨ CRUD Operations</h3>
                    <ul>
                        <li><strong>Create:</strong> Add new student records with comprehensive details</li>
                        <li><strong>Read:</strong> View, search, and filter student information</li>
                        <li><strong>Update:</strong> Edit and modify existing student records</li>
                        <li><strong>Delete:</strong> Remove student records with confirmation</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3>🔐 User Authentication</h3>
                    <ul>
                        <li>Secure login and registration system</li>
                        <li>Password encryption using PHP password_hash()</li>
                        <li>Session management for authenticated users</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3>📊 Dashboard & Analytics</h3>
                    <ul>
                        <li>Statistics on student enrollment</li>
                        <li>Department-wise student distribution</li>
                        <li>Recent activity tracking</li>
                    </ul>
                </div>
                <div class="feature-item">
                    <h3>🔍 Search & Filter</h3>
                    <ul>
                        <li>Search by student ID, name, or email</li>
                        <li>Filter by department and status</li>
                        <li>Real-time query results</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Database Design -->
        <div class="about-section">
            <h2>Database Design</h2>
            <p>The system uses two main database tables:</p>
            <div class="db-tables">
                <div class="db-table">
                    <h3>Users Table</h3>
                    <p>Stores administrator/user authentication information</p>
                    <ul>
                        <li>id (Primary Key)</li>
                        <li>username (Unique)</li>
                        <li>password (Hashed)</li>
                        <li>email</li>
                        <li>full_name</li>
                        <li>created_at</li>
                    </ul>
                </div>
                <div class="db-table">
                    <h3>Students Table</h3>
                    <p>Stores all student information and records</p>
                    <ul>
                        <li>id (Primary Key)</li>
                        <li>student_id (Unique)</li>
                        <li>first_name, last_name</li>
                        <li>email (Unique)</li>
                        <li>phone, date_of_birth, gender</li>
                        <li>address, department</li>
                        <li>semester, cgpa</li>
                        <li>enrollment_date, status</li>
                        <li>created_at, updated_at</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Group Members -->
        <div class="about-section group-members">
            <h2>Group Members</h2>
            <p class="note">👥 This project was developed by a dedicated team of students</p>
            <div class="members-grid">
                <div class="member-card">
                    <div class="member-avatar">👨‍🎓</div>
                    <h3>Student Name 1</h3>
                    <p class="member-id"><strong>ID:</strong> 20XX-CS-XXX</p>
                    <p class="member-role">Team Leader & Backend Developer</p>
                    <p class="member-email">student1@university.edu</p>
                </div>

                <div class="member-card">
                    <div class="member-avatar">👩‍🎓</div>
                    <h3>Student Name 2</h3>
                    <p class="member-id"><strong>ID:</strong> 20XX-CS-XXX</p>
                    <p class="member-role">Database Designer</p>
                    <p class="member-email">student2@university.edu</p>
                </div>

                <div class="member-card">
                    <div class="member-avatar">👨‍🎓</div>
                    <h3>Student Name 3</h3>
                    <p class="member-id"><strong>ID:</strong> 20XX-CS-XXX</p>
                    <p class="member-role">Frontend Developer</p>
                    <p class="member-email">student3@university.edu</p>
                </div>

                <div class="member-card">
                    <div class="member-avatar">👩‍🎓</div>
                    <h3>Student Name 4</h3>
                    <p class="member-id"><strong>ID:</strong> 20XX-CS-XXX</p>
                    <p class="member-role">UI/UX Designer</p>
                    <p class="member-email">student4@university.edu</p>
                </div>

                <div class="member-card">
                    <div class="member-avatar">👨‍🎓</div>
                    <h3>Student Name 5</h3>
                    <p class="member-id"><strong>ID:</strong> 20XX-CS-XXX</p>
                    <p class="member-role">Testing & Documentation</p>
                    <p class="member-email">student5@university.edu</p>
                </div>
            </div>
            <div class="update-note">
                <p><strong>Note:</strong> Please update the member names and IDs in the <code>about.php</code> file with your actual group member information.</p>
            </div>
        </div>

        <!-- Course Information -->
        <div class="about-section">
            <h2>Course Information</h2>
            <div class="course-info">
                <p><strong>Course Code:</strong> CSC 337</p>
                <p><strong>Course Title:</strong> Web Programming Languages</p>
                <p><strong>Assignment:</strong> Assignment 4 - PHP CRUD-Based Dynamic Website</p>
                <p><strong>Instructor:</strong> [Instructor Name]</p>
                <p><strong>Semester:</strong> Fall 2025/Spring 2026</p>
                <p><strong>Submission Date:</strong> January 15, 2026</p>
            </div>
        </div>

        <!-- Learning Outcomes -->
        <div class="about-section">
            <h2>Learning Outcomes</h2>
            <ul>
                <li>Gained practical experience in PHP backend development</li>
                <li>Mastered MySQL database design and SQL queries</li>
                <li>Implemented secure authentication and session management</li>
                <li>Learned CRUD operations and data validation</li>
                <li>Developed responsive and user-friendly interfaces</li>
                <li>Practiced version control using Git/GitHub</li>
                <li>Deployed a live web application</li>
            </ul>
        </div>

        <!-- Challenges Faced -->
        <div class="about-section">
            <h2>Challenges Faced</h2>
            <ul>
                <li>Implementing secure password hashing and authentication</li>
                <li>Designing a normalized database schema</li>
                <li>Handling form validation on both client and server side</li>
                <li>Creating responsive layouts for different screen sizes</li>
                <li>Managing PHP sessions and preventing unauthorized access</li>
                <li>Deploying the application to a live hosting environment</li>
            </ul>
        </div>

        <!-- GitHub Repository -->
        <div class="about-section github-section">
            <h2>Source Code</h2>
            <p>The complete source code for this project is available on GitHub:</p>
            <a href="https://github.com/yourusername/student-management-system" class="btn btn-primary" target="_blank">
                View on GitHub
            </a>
            <p class="note">⚠️ Update the GitHub repository URL above with your actual repository link</p>
        </div>

        <!-- Contact -->
        <div class="about-section contact-section">
            <h2>Contact</h2>
            <p>For questions or feedback about this project, please contact the development team:</p>
            <p><strong>Email:</strong> team@studentms.com</p>
            <p><strong>GitHub:</strong> <a href="https://github.com/yourusername/student-management-system" target="_blank">Project Repository</a></p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
