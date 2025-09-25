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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $student) {
    $formData = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'date_of_birth' => $_POST['date_of_birth'] ?? '',
        'address' => trim($_POST['address'] ?? ''),
        'major' => trim($_POST['major'] ?? ''),
        'gpa' => $_POST['gpa'] ?? '',
        'status' => $_POST['status'] ?? 'active'
    ];
    
    // Validate required fields
    $errors = [];
    if (empty($formData['first_name'])) $errors[] = "First name is required";
    if (empty($formData['last_name'])) $errors[] = "Last name is required";
    if (empty($formData['email'])) $errors[] = "Email is required";
    if ($formData['email'] && !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    if ($formData['gpa'] && ($formData['gpa'] < 0 || $formData['gpa'] > 4.0)) {
        $errors[] = "GPA must be between 0.00 and 4.00";
    }
    
    if (empty($errors)) {
        try {
            $sql = "UPDATE students SET 
                    first_name = ?, last_name = ?, email = ?, phone = ?, 
                    date_of_birth = ?, address = ?, major = ?, gpa = ?, status = ?
                    WHERE id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $formData['first_name'],
                $formData['last_name'],
                $formData['email'],
                $formData['phone'] ?: null,
                $formData['date_of_birth'] ?: null,
                $formData['address'] ?: null,
                $formData['major'] ?: null,
                $formData['gpa'] ?: null,
                $formData['status'],
                $studentId
            ]);
            
            // Update the student array with new data
            $student = array_merge($student, $formData);
            
            $message = "Student updated successfully!";
            $messageType = "success";
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "Error: Email address already exists!";
            } else {
                $message = "Error updating student: " . $e->getMessage();
            }
            $messageType = "error";
        }
    } else {
        $message = "Please fix the following errors:\n" . implode("\n", $errors);
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Management System</title>
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
                    <h2>Edit Student</h2>
                    <div class="header-actions">
                        <a href="view_student.php?id=<?php echo $studentId; ?>" class="btn btn-info">View Details</a>
                        <a href="students.php" class="btn btn-secondary">← Back to Students</a>
                    </div>
                </div>

                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo nl2br(htmlspecialchars($message)); ?>
                    </div>
                <?php endif; ?>

                <?php if ($student): ?>
                    <form method="POST" class="student-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="first_name">First Name *</label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="<?php echo htmlspecialchars($student['first_name']); ?>" 
                                       required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="<?php echo htmlspecialchars($student['last_name']); ?>" 
                                       required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($student['email']); ?>" 
                                       required maxlength="100">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($student['phone'] ?? ''); ?>" 
                                       maxlength="20">
                            </div>

                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" 
                                       value="<?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="major">Major</label>
                                <input type="text" id="major" name="major" 
                                       value="<?php echo htmlspecialchars($student['major'] ?? ''); ?>" 
                                       maxlength="100" placeholder="e.g., Computer Science">
                            </div>

                            <div class="form-group">
                                <label for="gpa">GPA</label>
                                <input type="number" id="gpa" name="gpa" 
                                       value="<?php echo htmlspecialchars($student['gpa'] ?? ''); ?>" 
                                       min="0" max="4" step="0.01" placeholder="0.00 - 4.00">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status">
                                    <option value="active" <?php echo $student['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $student['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="graduated" <?php echo $student['status'] === 'graduated' ? 'selected' : ''; ?>>Graduated</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3" 
                                      placeholder="Street, City, State, ZIP"><?php echo htmlspecialchars($student['address'] ?? ''); ?></textarea>
                        </div>

                        <div class="student-info">
                            <p><strong>Student ID:</strong> <?php echo $student['id']; ?></p>
                            <p><strong>Enrolled:</strong> <?php echo date('M j, Y', strtotime($student['enrollment_date'])); ?></p>
                            <p><strong>Last Updated:</strong> <?php echo date('M j, Y g:i A', strtotime($student['updated_at'])); ?></p>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-large">Update Student</button>
                            <a href="students.php" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
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