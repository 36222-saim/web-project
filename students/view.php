<?php
/**
 * READ Operation - View Student Details
 * Displays detailed information of a specific student
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

// Fetch student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: list.php");
    exit();
}

$student = $result->fetch_assoc();

$stmt->close();
closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details - <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Student Details</h1>
            <div>
                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit</a>
                <a href="list.php" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <h2><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h2>
                <span class="badge badge-<?php echo strtolower($student['status']); ?>">
                    <?php echo htmlspecialchars($student['status']); ?>
                </span>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <label>Student ID:</label>
                    <span><?php echo htmlspecialchars($student['student_id']); ?></span>
                </div>

                <div class="detail-item">
                    <label>Email:</label>
                    <span><?php echo htmlspecialchars($student['email']); ?></span>
                </div>

                <div class="detail-item">
                    <label>Phone:</label>
                    <span><?php echo htmlspecialchars($student['phone'] ?: 'N/A'); ?></span>
                </div>

                <div class="detail-item">
                    <label>Date of Birth:</label>
                    <span><?php echo $student['date_of_birth'] ? date('F j, Y', strtotime($student['date_of_birth'])) : 'N/A'; ?></span>
                </div>

                <div class="detail-item">
                    <label>Gender:</label>
                    <span><?php echo htmlspecialchars($student['gender']); ?></span>
                </div>

                <div class="detail-item">
                    <label>Department:</label>
                    <span><?php echo htmlspecialchars($student['department']); ?></span>
                </div>

                <div class="detail-item">
                    <label>Semester:</label>
                    <span><?php echo htmlspecialchars($student['semester']); ?></span>
                </div>

                <div class="detail-item">
                    <label>CGPA:</label>
                    <span><?php echo number_format($student['cgpa'], 2); ?></span>
                </div>

                <div class="detail-item">
                    <label>Enrollment Date:</label>
                    <span><?php echo date('F j, Y', strtotime($student['enrollment_date'])); ?></span>
                </div>

                <div class="detail-item">
                    <label>Status:</label>
                    <span><?php echo htmlspecialchars($student['status']); ?></span>
                </div>

                <div class="detail-item full-width">
                    <label>Address:</label>
                    <span><?php echo htmlspecialchars($student['address'] ?: 'N/A'); ?></span>
                </div>

                <div class="detail-item">
                    <label>Created At:</label>
                    <span><?php echo date('F j, Y g:i A', strtotime($student['created_at'])); ?></span>
                </div>

                <div class="detail-item">
                    <label>Last Updated:</label>
                    <span><?php echo date('F j, Y g:i A', strtotime($student['updated_at'])); ?></span>
                </div>
            </div>

            <div class="detail-actions">
                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit Student</a>
                <a href="delete.php?id=<?php echo $student['id']; ?>"
                   class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to delete this student?')">Delete Student</a>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
