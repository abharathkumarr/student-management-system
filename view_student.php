<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';
require_once 'includes/auth.php';

// Require login to access this page
requireLogin();

$message = '';
$messageType = '';
$student = null;

// Get student ID
$studentId = $_GET['id'] ?? 0;

if (!$studentId) {
    header('Location: students.php');
    exit;
}

// Fetch student data
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$studentId]);
    $student = $stmt->fetch();
    
    if (!$student) {
        $message = "Student not found!";
        $messageType = "error";
    }
} catch (Exception $e) {
    $message = "Error fetching student: " . $e->getMessage();
    $messageType = "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student - Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <h1 class="nav-logo">Student Management System</h1>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="students.php" class="nav-link">View Students</a></li>
                    <li class="nav-item"><a href="add_student.php" class="nav-link">Add Student</a></li>
                    <li class="nav-item"><a href="setup.php" class="nav-link">Setup</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="form-container">
                <div class="page-header">
                    <h2>Student Details</h2>
                    <div class="header-actions">
                        <a href="edit_student.php?id=<?php echo $studentId; ?>" class="btn btn-warning">Edit Student</a>
                        <a href="students.php" class="btn btn-secondary">← Back to Students</a>
                    </div>
                </div>

                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <?php if ($student): ?>
                    <div class="student-profile">
                        <div class="profile-header">
                            <div class="profile-info">
                                <h3><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h3>
                                <p class="student-id">Student ID: #<?php echo $student['id']; ?></p>
                                <span class="status status-<?php echo $student['status']; ?>">
                                    <?php echo ucfirst($student['status']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="profile-details">
                            <div class="detail-section">
                                <h4>Contact Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label>Email:</label>
                                        <span>
                                            <a href="mailto:<?php echo htmlspecialchars($student['email']); ?>">
                                                <?php echo htmlspecialchars($student['email']); ?>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <label>Phone:</label>
                                        <span>
                                            <?php if ($student['phone']): ?>
                                                <a href="tel:<?php echo htmlspecialchars($student['phone']); ?>">
                                                    <?php echo htmlspecialchars($student['phone']); ?>
                                                </a>
                                            <?php else: ?>
                                                <em>Not provided</em>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                                <?php if ($student['address']): ?>
                                    <div class="detail-item full-width">
                                        <label>Address:</label>
                                        <span><?php echo nl2br(htmlspecialchars($student['address'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="detail-section">
                                <h4>Academic Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label>Major:</label>
                                        <span><?php echo $student['major'] ? htmlspecialchars($student['major']) : '<em>Not specified</em>'; ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <label>GPA:</label>
                                        <span>
                                            <?php if ($student['gpa']): ?>
                                                <span class="gpa <?php echo $student['gpa'] >= 3.5 ? 'high' : ($student['gpa'] >= 2.5 ? 'medium' : 'low'); ?>">
                                                    <?php echo number_format($student['gpa'], 2); ?>
                                                </span>
                                            <?php else: ?>
                                                <em>Not recorded</em>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <label>Date of Birth:</label>
                                        <span>
                                            <?php 
                                            if ($student['date_of_birth']) {
                                                $dob = new DateTime($student['date_of_birth']);
                                                $age = $dob->diff(new DateTime())->y;
                                                echo $dob->format('M j, Y') . ' (Age: ' . $age . ')';
                                            } else {
                                                echo '<em>Not provided</em>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <label>Status:</label>
                                        <span class="status status-<?php echo $student['status']; ?>">
                                            <?php echo ucfirst($student['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-section">
                                <h4>System Information</h4>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label>Enrollment Date:</label>
                                        <span><?php echo date('M j, Y', strtotime($student['enrollment_date'])); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <label>Record Created:</label>
                                        <span><?php echo date('M j, Y g:i A', strtotime($student['created_at'])); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <label>Last Updated:</label>
                                        <span><?php echo date('M j, Y g:i A', strtotime($student['updated_at'])); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">
                                ✏️ Edit Student
                            </a>
                            <a href="students.php?action=delete&id=<?php echo $student['id']; ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete this student? This action cannot be undone.')">
                                🗑️ Delete Student
                            </a>
                            <a href="students.php" class="btn btn-outline">
                                📋 Back to List
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <h3>Student Not Found</h3>
                        <p>The requested student could not be found.</p>
                        <a href="students.php" class="btn btn-primary">Back to Students</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System - Developed by <strong>Bharath Kumar A</strong></p>
        </div>
    </footer>
</body>
</html>