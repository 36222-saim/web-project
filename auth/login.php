<?php
/**
 * Login Page
 * Handles user authentication
 */

require_once '../config/database.php';
require_once '../config/session.php';

// Redirect if already logged in
redirectIfLoggedIn();

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $conn = getConnection();

        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, password, full_name FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];

                // Redirect to dashboard
                header("Location: ../dashboard.php");
                exit();
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }

        $stmt->close();
        closeConnection($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Student Management System</h1>
                <p>CSC 337 - Web Programming Assignment</p>
            </div>

            <form method="POST" action="" class="auth-form">
                <h2>Login</h2>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required
                           value="<?php echo htmlspecialchars($username ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>

                <div class="auth-links">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>

                <div class="default-credentials">
                    <p><strong>Default Admin Credentials:</strong></p>
                    <p>Username: admin</p>
                    <p>Password: admin123</p>
                </div>
            </form>

            <div class="auth-footer">
                <a href="../index.php">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
