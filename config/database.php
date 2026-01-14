<?php
/**
 * Database Configuration File
 * Contains database connection parameters
 * Now supports .env file configuration
 */

// Load environment variables
require_once __DIR__ . '/env.php';

// Database configuration constants from .env file
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'student_management'));

/**
 * Create database connection
 * @return mysqli connection object
 */
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

/**
 * Close database connection
 * @param mysqli $conn - connection object
 */
function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>
