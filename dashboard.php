<?php
/**
 * Dashboard - Main admin panel with statistics and quick actions
 */

require_once 'config/database.php';
require_once 'config/session.php';

// Require authentication
requireAuth();

$conn = getConnection();

// Get statistics
$stats = [
    'total_students' => 0,
    'active_students' => 0,
    'inactive_students' => 0,
    'graduated_students' => 0,
    'departments' => []
];

// Total students
$result = $conn->query("SELECT COUNT(*) as count FROM students");
$stats['total_students'] = $result->fetch_assoc()['count'];

// Active students
$result = $conn->query("SELECT COUNT(*) as count FROM students WHERE status = 'Active'");
$stats['active_students'] = $result->fetch_assoc()['count'];

// Inactive students
$result = $conn->query("SELECT COUNT(*) as count FROM students WHERE status = 'Inactive'");
$stats['inactive_students'] = $result->fetch_assoc()['count'];

// Graduated students
$result = $conn->query("SELECT COUNT(*) as count FROM students WHERE status = 'Graduated'");
$stats['graduated_students'] = $result->fetch_assoc()['count'];

// Students by department
$result = $conn->query("SELECT department, COUNT(*) as count FROM students GROUP BY department ORDER BY count DESC");
while ($row = $result->fetch_assoc()) {
    $stats['departments'][] = $row;
}

// Recent students
$recentStudents = [];
$result = $conn->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    $recentStudents[] = $row;
}

closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1>Dashboard</h1>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-primary">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3><?php echo $stats['total_students']; ?></h3>
                    <p>Total Students</p>
                </div>
            </div>

            <div class="stat-card stat-success">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3><?php echo $stats['active_students']; ?></h3>
                    <p>Active Students</p>
                </div>
            </div>

            <div class="stat-card stat-warning">
                <div class="stat-icon">⏸️</div>
                <div class="stat-content">
                    <h3><?php echo $stats['inactive_students']; ?></h3>
                    <p>Inactive Students</p>
                </div>
            </div>

            <div class="stat-card stat-info">
                <div class="stat-icon">🎓</div>
                <div class="stat-content">
                    <h3><?php echo $stats['graduated_students']; ?></h3>
                    <p>Graduated Students</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                <a href="students/create.php" class="action-card">
                    <div class="action-icon">➕</div>
                    <h3>Add Student</h3>
                    <p>Create new student record</p>
                </a>

                <a href="students/list.php" class="action-card">
                    <div class="action-icon">📋</div>
                    <h3>View All Students</h3>
                    <p>Browse student records</p>
                </a>

                <a href="students/list.php?status=Active" class="action-card">
                    <div class="action-icon">🔍</div>
                    <h3>Active Students</h3>
                    <p>View active enrollments</p>
                </a>

                <a href="about.php" class="action-card">
                    <div class="action-icon">ℹ️</div>
                    <h3>About System</h3>
                    <p>Project information</p>
                </a>
            </div>
        </div>

        <!-- Students by Department -->
        <?php if (!empty($stats['departments'])): ?>
        <div class="dashboard-section">
            <h2>Students by Department</h2>
            <div class="department-stats">
                <?php foreach ($stats['departments'] as $dept): ?>
                    <div class="dept-stat">
                        <span class="dept-name"><?php echo htmlspecialchars($dept['department']); ?></span>
                        <span class="dept-count"><?php echo $dept['count']; ?> students</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recent Students -->
        <?php if (!empty($recentStudents)): ?>
        <div class="dashboard-section">
            <h2>Recently Added Students</h2>
            <div class="recent-students">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Added On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentStudents as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['department']); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo strtolower($student['status']); ?>">
                                        <?php echo htmlspecialchars($student['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($student['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="students/view.php?id=<?php echo $student['id']; ?>"
                                       class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
