<?php
/**
 * Footer Include File
 */
?>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Student Management System</h4>
                <p>A comprehensive PHP CRUD application for managing student records.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/index.php">Home</a></li>
                    <li><a href="/about.php">About</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="/dashboard.php">Dashboard</a></li>
                        <li><a href="/students/list.php">Students</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Project Info</h4>
                <ul>
                    <li>Course: CSC 337</li>
                    <li>Assignment 4</li>
                    <li>Web Programming</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Student Management System. All rights reserved.</p>
            <p>Developed for educational purposes - CSC 337 Assignment</p>
        </div>
    </div>
</footer>
