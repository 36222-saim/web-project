<?php
/**
 * DELETE Operation - Remove Student
 * Allows admin to delete student records from the database
 */

require_once '../config/database.php';
require_once '../config/session.php';

// Require authentication
requireAuth();

$id = intval($_GET['id'] ?? 0);

if ($id === 0) {
    header("Location: list.php");
    exit();
}

$conn = getConnection();

// Check if student exists
$stmt = $conn->prepare("SELECT student_id, first_name, last_name FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: list.php");
    exit();
}

$student = $result->fetch_assoc();
$stmt->close();

$error = '';
$success = '';

// Handle deletion confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirm = $_POST['confirm'] ?? '';

    if ($confirm === 'yes') {
        // Delete student
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            closeConnection($conn);

            // Redirect to list with success message
            header("Location: list.php?deleted=1");
            exit();
        } else {
            $error = 'Failed to delete student. Please try again.';
        }

        $stmt->close();
    } else {
        header("Location: list.php");
        exit();
    }
}

closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Delete Student</h1>
            <a href="list.php" class="btn btn-secondary">Back to List</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="delete-card">
            <div class="delete-warning">
                <h2>Warning!</h2>
                <p>Are you sure you want to delete this student?</p>
            </div>

            <div class="student-info">
                <h3>Student Information</h3>
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
            </div>

            <div class="delete-notice">
                <p><strong>Note:</strong> This action cannot be undone. All student information will be permanently deleted from the database.</p>
            </div>

            <form method="POST" action="" class="delete-form">
                <div class="form-actions">
                    <button type="submit" name="confirm" value="yes" class="btn btn-danger">
                        Yes, Delete Student
                    </button>
                    <a href="list.php" class="btn btn-secondary">No, Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
