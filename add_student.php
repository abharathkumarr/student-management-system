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
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
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
            $pdo = getDBConnection();
            
            $sql = "INSERT INTO students (first_name, last_name, email, phone, date_of_birth, address, major, gpa, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
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
                $formData['status']
            ]);
            
            $message = "Student added successfully!";
            $messageType = "success";
            $formData = []; // Clear form
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                $message = "Error: Email address already exists!";
            } else {
                $message = "Error adding student: " . $e->getMessage();
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
    <title>Add Student - Student Management System</title>
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
                    <li class="nav-item"><a href="add_student.php" class="nav-link active">Add Student</a></li>
                    <li class="nav-item"><a href="setup.php" class="nav-link">Setup</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="form-container">
                <div class="page-header">
                    <h2>Add New Student</h2>
                    <a href="students.php" class="btn btn-secondary">← Back to Students</a>
                </div>

                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo nl2br(htmlspecialchars($message)); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="student-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?php echo htmlspecialchars($formData['first_name'] ?? ''); ?>" 
                                   required maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?php echo htmlspecialchars($formData['last_name'] ?? ''); ?>" 
                                   required maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" 
                                   required maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>" 
                                   maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" 
                                   value="<?php echo htmlspecialchars($formData['date_of_birth'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="major">Major</label>
                            <input type="text" id="major" name="major" 
                                   value="<?php echo htmlspecialchars($formData['major'] ?? ''); ?>" 
                                   maxlength="100" placeholder="e.g., Computer Science">
                        </div>

                        <div class="form-group">
                            <label for="gpa">GPA</label>
                            <input type="number" id="gpa" name="gpa" 
                                   value="<?php echo htmlspecialchars($formData['gpa'] ?? ''); ?>" 
                                   min="0" max="4" step="0.01" placeholder="0.00 - 4.00">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="active" <?php echo ($formData['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo ($formData['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                <option value="graduated" <?php echo ($formData['status'] ?? '') === 'graduated' ? 'selected' : ''; ?>>Graduated</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" 
                                  placeholder="Street, City, State, ZIP"><?php echo htmlspecialchars($formData['address'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">Add Student</button>
                        <button type="reset" class="btn btn-outline">Clear Form</button>
                    </div>
                </form>
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