<?php
/**
 * Session Configuration File
 * Handles session management and authentication checks
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return boolean
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require authentication - redirect to login if not authenticated
 */
function requireAuth() {
    if (!isLoggedIn()) {
        header("Location: ../auth/login.php");
        exit();
    }
}

/**
 * Redirect if already logged in
 */
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header("Location: ../dashboard.php");
        exit();
    }
}

/**
 * Logout user
 */
function logout() {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}
?>
