<?php
/**
 * Home Page - Landing page of Student Management System
 */

require_once 'config/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="home-page">
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <h2>Student Management System</h2>
            </div>
            <div class="navbar-menu">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="auth/logout.php" class="btn btn-sm btn-danger">Logout</a>
                <?php else: ?>
                    <a href="auth/login.php" class="btn btn-sm btn-primary">Login</a>
                    <a href="auth/register.php" class="btn btn-sm btn-secondary">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Welcome to Student Management System</h1>
                <p class="hero-subtitle">A comprehensive PHP-based CRUD application for managing student records</p>
                <p class="hero-description">
                    This system allows administrators to efficiently manage student information including
                    enrollment, academic records, and personal details. Built with PHP, MySQL, and modern web technologies.
                </p>
                <div class="hero-actions">
                    <?php if (isLoggedIn()): ?>
                        <a href="dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
                        <a href="students/list.php" class="btn btn-secondary btn-lg">View Students</a>
                    <?php else: ?>
                        <a href="auth/login.php" class="btn btn-primary btn-lg">Get Started</a>
                        <a href="about.php" class="btn btn-secondary btn-lg">Learn More</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2 class="section-title">Key Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">➕</div>
                    <h3>Create Records</h3>
                    <p>Add new student records with comprehensive information including personal details, academic data, and enrollment information.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👀</div>
                    <h3>View & Search</h3>
                    <p>Browse all student records with advanced search and filtering options by department, status, and more.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✏️</div>
                    <h3>Update Information</h3>
                    <p>Edit and update student information easily with a user-friendly interface and real-time validation.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🗑️</div>
                    <h3>Delete Records</h3>
                    <p>Remove student records securely with confirmation prompts to prevent accidental deletions.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Secure Authentication</h3>
                    <p>Protected access with user authentication system ensuring data security and privacy.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Dashboard Analytics</h3>
                    <p>View statistics and insights about student enrollment, departments, and academic performance.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="technology-stack">
        <div class="container">
            <h2 class="section-title">Technology Stack</h2>
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Backend</h4>
                    <p>PHP 7.4+</p>
                </div>
                <div class="tech-item">
                    <h4>Database</h4>
                    <p>MySQL</p>
                </div>
                <div class="tech-item">
                    <h4>Frontend</h4>
                    <p>HTML5, CSS3</p>
                </div>
                <div class="tech-item">
                    <h4>Architecture</h4>
                    <p>MVC Pattern</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Student Management System - CSC 337 Web Programming Assignment</p>
            <p>Developed for educational purposes</p>
        </div>
    </footer>
</body>
</html>
