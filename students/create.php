<?php
/**
 * CREATE Operation - Add New Student
 * Allows admin to add new students to the database
 */

require_once '../config/database.php';
require_once '../config/session.php';

// Require authentication
requireAuth();

$error = '';
$success = '';

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
        $conn = getConnection();

        // Check if student ID or email already exists
        $stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ? OR email = ?");
        $stmt->bind_param("ss", $student_id, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Student ID or email already exists.';
        } else {
            // Insert new student
            $stmt = $conn->prepare("INSERT INTO students (student_id, first_name, last_name, email, phone, date_of_birth, gender, address, department, semester, cgpa, enrollment_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssidss", $student_id, $first_name, $last_name, $email, $phone, $date_of_birth, $gender, $address, $department, $semester, $cgpa, $enrollment_date, $status);

            if ($stmt->execute()) {
                $success = 'Student added successfully!';
                // Clear form fields
                $student_id = $first_name = $last_name = $email = $phone = $address = $department = '';
                $date_of_birth = $enrollment_date = '';
            } else {
                $error = 'Failed to add student. Please try again.';
            }
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
    <title>Add Student - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Add New Student</h1>
            <a href="list.php" class="btn btn-secondary">View All Students</a>
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
                               value="<?php echo htmlspecialchars($student_id ?? ''); ?>"
                               placeholder="e.g., STD001">
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" required
                               value="<?php echo htmlspecialchars($first_name ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required
                               value="<?php echo htmlspecialchars($last_name ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo htmlspecialchars($email ?? ''); ?>"
                               placeholder="student@university.edu">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone"
                               value="<?php echo htmlspecialchars($phone ?? ''); ?>"
                               placeholder="+92-300-1234567">
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                               value="<?php echo htmlspecialchars($date_of_birth ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="Male" <?php echo ($gender ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($gender ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($gender ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Software Engineering">Software Engineering</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Cyber Security">Cyber Security</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="number" id="semester" name="semester" min="1" max="8"
                               value="<?php echo htmlspecialchars($semester ?? 1); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cgpa">CGPA</label>
                        <input type="number" id="cgpa" name="cgpa" min="0" max="4" step="0.01"
                               value="<?php echo htmlspecialchars($cgpa ?? 0); ?>">
                    </div>

                    <div class="form-group">
                        <label for="enrollment_date">Enrollment Date</label>
                        <input type="date" id="enrollment_date" name="enrollment_date"
                               value="<?php echo htmlspecialchars($enrollment_date ?? date('Y-m-d')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="Active" <?php echo ($status ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($status ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Graduated" <?php echo ($status ?? '') === 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                    <a href="list.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
