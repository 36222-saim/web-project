<?php
/**
 * Header Include File
 * Navigation bar for authenticated users
 */

if (!isset($_SESSION)) {
    session_start();
}
?>

<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="<?php echo isLoggedIn() ? '/dashboard.php' : '/index.php'; ?>">
                <h2>Student Management System</h2>
            </a>
        </div>
        <div class="navbar-menu">
            <a href="<?php echo isLoggedIn() ? '/dashboard.php' : '/index.php'; ?>">Home</a>
            <?php if (isLoggedIn()): ?>
                <a href="/dashboard.php">Dashboard</a>
                <a href="/students/list.php">Students</a>
                <a href="/students/create.php">Add Student</a>
            <?php endif; ?>
            <a href="/about.php">About</a>

            <?php if (isLoggedIn()): ?>
                <div class="navbar-user">
                    <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="/auth/logout.php" class="btn btn-sm btn-danger">Logout</a>
                </div>
            <?php else: ?>
                <a href="/auth/login.php" class="btn btn-sm btn-primary">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
