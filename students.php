<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';
require_once 'includes/auth.php';

// Require login to access this page
requireLogin();

// Handle delete action
if ($_GET['action'] ?? '' === 'delete' && isset($_GET['id'])) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message = "Student deleted successfully!";
        $messageType = "success";
    } catch (Exception $e) {
        $message = "Error deleting student: " . $e->getMessage();
        $messageType = "error";
    }
}

// Get search term
$search = $_GET['search'] ?? '';

try {
    $pdo = getDBConnection();
    
    // Build query with search
    $query = "SELECT * FROM students";
    $params = [];
    
    if ($search) {
        $query .= " WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR major LIKE ?";
        $searchTerm = "%$search%";
        $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
    }
    
    $query .= " ORDER BY last_name, first_name";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $students = $stmt->fetchAll();
    
} catch (Exception $e) {
    $error = "Error fetching students: " . $e->getMessage();
    $students = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <h1 class="nav-logo">Student Management System</h1>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="students.php" class="nav-link active">View Students</a></li>
                    <li class="nav-item"><a href="add_student.php" class="nav-link">Add Student</a></li>
                    <li class="nav-item"><a href="setup.php" class="nav-link">Setup</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h2>All Students</h2>
                <a href="add_student.php" class="btn btn-primary">+ Add New Student</a>
            </div>

            <?php if (isset($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="message error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Search Form -->
            <div class="search-container">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search by name, email, or major..." 
                           value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                    <button type="submit" class="btn btn-secondary">Search</button>
                    <?php if ($search): ?>
                        <a href="students.php" class="btn btn-outline">Clear</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Students Table -->
            <?php if (empty($students)): ?>
                <div class="no-data">
                    <h3>No students found</h3>
                    <p><?php echo $search ? 'No students match your search criteria.' : 'No students in the database yet.'; ?></p>
                    <a href="add_student.php" class="btn btn-primary">Add First Student</a>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Major</th>
                                <th>GPA</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['id']); ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></strong>
                                    </td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($student['major'] ?? 'N/A'); ?></td>
                                    <td>
                                        <?php if (isset($student['gpa']) && $student['gpa']): ?>
                                            <span class="gpa <?php echo $student['gpa'] >= 3.5 ? 'high' : ($student['gpa'] >= 2.5 ? 'medium' : 'low'); ?>">
                                                <?php echo number_format($student['gpa'], 2); ?>
                                            </span>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status status-<?php echo htmlspecialchars($student['status'] ?? 'active'); ?>">
                                            <?php echo ucfirst($student['status'] ?? 'active'); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="view_student.php?id=<?php echo $student['id']; ?>" 
                                           class="btn btn-small btn-info">View</a>
                                        <a href="edit_student.php?id=<?php echo $student['id']; ?>" 
                                           class="btn btn-small btn-warning">Edit</a>
                                        <a href="students.php?action=delete&id=<?php echo $student['id']; ?>" 
                                           class="btn btn-small btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="stats">
                    <p><strong>Total Students:</strong> <?php echo count($students); ?></p>
                    <?php if ($search): ?>
                        <p><strong>Search Results for:</strong> "<?php echo htmlspecialchars($search); ?>"</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System - Developed by <strong>Bharath Kumar A</strong></p>
        </div>
    </footer>
</body>
</html>