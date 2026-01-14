<?php
/**
 * UPDATE Operation - Edit Student Information
 * Allows admin to update existing student records
 */

require_once '../config/database.php';
require_once '../config/session.php';

// Require authentication
requireAuth();

$id = intval($_GET['id'] ?? 0);
$error = '';
$success = '';

if ($id === 0) {
    header("Location: list.php");
    exit();
}

$conn = getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $student_id = trim($_POST['student_id'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $gender = $_POST['gender'] ?? 'Male';
    $address = trim($_POST['address'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $semester = intval($_POST['semester'] ?? 1);
    $cgpa = floatval($_POST['cgpa'] ?? 0);
    $enrollment_date = $_POST['enrollment_date'] ?? date('Y-m-d');
    $status = $_POST['status'] ?? 'Active';

    // Validation
    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($email) || empty($department)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif ($cgpa < 0 || $cgpa > 4) {
        $error = 'CGPA must be between 0 and 4.';
    } else {
        // Check if student ID or email already exists (excluding current student)
        $stmt = $conn->prepare("SELECT id FROM students WHERE (student_id = ? OR email = ?) AND id != ?");
        $stmt->bind_param("ssi", $student_id, $email, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Student ID or email already exists.';
        } else {
            // Update student
            $stmt = $conn->prepare("UPDATE students SET student_id = ?, first_name = ?, last_name = ?, email = ?, phone = ?, date_of_birth = ?, gender = ?, address = ?, department = ?, semester = ?, cgpa = ?, enrollment_date = ?, status = ? WHERE id = ?");
            $stmt->bind_param("ssssssssidsssi", $student_id, $first_name, $last_name, $email, $phone, $date_of_birth, $gender, $address, $department, $semester, $cgpa, $enrollment_date, $status, $id);

            if ($stmt->execute()) {
                $success = 'Student updated successfully!';
            } else {
                $error = 'Failed to update student. Please try again.';
            }
        }
        $stmt->close();
    }
}

// Fetch current student data
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
    <title>Edit Student - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Edit Student Information</h1>
            <a href="list.php" class="btn btn-secondary">Back to List</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="" class="student-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="student_id">Student ID *</label>
                        <input type="text" id="student_id" name="student_id" required
                               value="<?php echo htmlspecialchars($student['student_id']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" required
                               value="<?php echo htmlspecialchars($student['first_name']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required
                               value="<?php echo htmlspecialchars($student['last_name']); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo htmlspecialchars($student['email']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone"
                               value="<?php echo htmlspecialchars($student['phone']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                               value="<?php echo htmlspecialchars($student['date_of_birth']); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="Male" <?php echo $student['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $student['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo $student['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science" <?php echo $student['department'] === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Software Engineering" <?php echo $student['department'] === 'Software Engineering' ? 'selected' : ''; ?>>Software Engineering</option>
                            <option value="Information Technology" <?php echo $student['department'] === 'Information Technology' ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="Data Science" <?php echo $student['department'] === 'Data Science' ? 'selected' : ''; ?>>Data Science</option>
                            <option value="Cyber Security" <?php echo $student['department'] === 'Cyber Security' ? 'selected' : ''; ?>>Cyber Security</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="number" id="semester" name="semester" min="1" max="8"
                               value="<?php echo htmlspecialchars($student['semester']); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cgpa">CGPA</label>
                        <input type="number" id="cgpa" name="cgpa" min="0" max="4" step="0.01"
                               value="<?php echo htmlspecialchars($student['cgpa']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="enrollment_date">Enrollment Date</label>
                        <input type="date" id="enrollment_date" name="enrollment_date"
                               value="<?php echo htmlspecialchars($student['enrollment_date']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="Active" <?php echo $student['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo $student['status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Graduated" <?php echo $student['status'] === 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Student</button>
                    <a href="view.php?id=<?php echo $student['id']; ?>" class="btn btn-info">View Details</a>
                    <a href="list.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
