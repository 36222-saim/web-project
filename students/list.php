<?php
/**
 * READ Operation - View All Students
 * Displays list of all students with search and filter functionality
 */

require_once '../config/database.php';
require_once '../config/session.php';

// Require authentication
requireAuth();

$conn = getConnection();

// Get filter parameters
$search = trim($_GET['search'] ?? '');
$department = $_GET['department'] ?? '';
$status = $_GET['status'] ?? '';

// Build query with filters
$query = "SELECT * FROM students WHERE 1=1";
$params = [];
$types = '';

if (!empty($search)) {
    $query .= " AND (student_id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
    $searchParam = "%{$search}%";
    $params = array_merge($params, [$searchParam, $searchParam, $searchParam, $searchParam]);
    $types .= 'ssss';
}

if (!empty($department)) {
    $query .= " AND department = ?";
    $params[] = $department;
    $types .= 's';
}

if (!empty($status)) {
    $query .= " AND status = ?";
    $params[] = $status;
    $types .= 's';
}

$query .= " ORDER BY created_at DESC";

// Prepare and execute query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>All Students</h1>
            <a href="create.php" class="btn btn-primary">Add New Student</a>
        </div>

        <!-- Search and Filter Form -->
        <div class="filter-card">
            <form method="GET" action="" class="filter-form">
                <div class="filter-row">
                    <div class="form-group">
                        <input type="text" name="search" placeholder="Search by ID, name, or email..."
                               value="<?php echo htmlspecialchars($search); ?>">
                    </div>

                    <div class="form-group">
                        <select name="department">
                            <option value="">All Departments</option>
                            <option value="Computer Science" <?php echo $department === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Software Engineering" <?php echo $department === 'Software Engineering' ? 'selected' : ''; ?>>Software Engineering</option>
                            <option value="Information Technology" <?php echo $department === 'Information Technology' ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="Data Science" <?php echo $department === 'Data Science' ? 'selected' : ''; ?>>Data Science</option>
                            <option value="Cyber Security" <?php echo $department === 'Cyber Security' ? 'selected' : ''; ?>>Cyber Security</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="Active" <?php echo $status === 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo $status === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Graduated" <?php echo $status === 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="list.php" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>

        <!-- Students Table -->
        <div class="table-card">
            <div class="table-header">
                <h3>Student Records (<?php echo count($students); ?> found)</h3>
            </div>

            <?php if (empty($students)): ?>
                <div class="empty-state">
                    <p>No students found.</p>
                    <a href="create.php" class="btn btn-primary">Add Your First Student</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Semester</th>
                                <th>CGPA</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['department']); ?></td>
                                    <td><?php echo htmlspecialchars($student['semester']); ?></td>
                                    <td><?php echo number_format($student['cgpa'], 2); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo strtolower($student['status']); ?>">
                                            <?php echo htmlspecialchars($student['status']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="view.php?id=<?php echo $student['id']; ?>"
                                           class="btn btn-sm btn-info" title="View Details">View</a>
                                        <a href="edit.php?id=<?php echo $student['id']; ?>"
                                           class="btn btn-sm btn-warning" title="Edit">Edit</a>
                                        <a href="delete.php?id=<?php echo $student['id']; ?>"
                                           class="btn btn-sm btn-danger" title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
