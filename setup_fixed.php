<?php
require_once 'includes/config.php';

$message = '';
$messageType = '';

if ($_POST['action'] ?? '' === 'setup') {
    try {
        $pdo = getDBConnection();
        
        // Create students table directly in PHP
        $sql = "CREATE TABLE IF NOT EXISTS students (
            id INT PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            phone VARCHAR(20),
            date_of_birth DATE,
            address TEXT,
            major VARCHAR(100),
            gpa DECIMAL(3,2),
            enrollment_date DATE DEFAULT CURRENT_DATE,
            status ENUM('active', 'inactive', 'graduated') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);
        
        // Insert sample data
        $insertSQL = "INSERT INTO students (first_name, last_name, email, phone, date_of_birth, address, major, gpa) VALUES
        ('John', 'Doe', 'john.doe@email.com', '555-0101', '2000-01-15', '123 Main St, City, State', 'Computer Science', 3.75),
        ('Jane', 'Smith', 'jane.smith@email.com', '555-0102', '1999-05-20', '456 Oak Ave, City, State', 'Business Administration', 3.92),
        ('Mike', 'Johnson', 'mike.johnson@email.com', '555-0103', '2001-03-10', '789 Pine Rd, City, State', 'Engineering', 3.45),
        ('Sarah', 'Wilson', 'sarah.wilson@email.com', '555-0104', '2000-11-08', '321 Elm St, City, State', 'Psychology', 3.88),
        ('David', 'Brown', 'david.brown@email.com', '555-0105', '1998-07-25', '654 Maple Dr, City, State', 'Mathematics', 3.67)";
        
        $pdo->exec($insertSQL);
        
        $message = "Database setup completed successfully! Tables created and 5 sample students inserted.";
        $messageType = "success";
        
    } catch (Exception $e) {
        $message = "Error setting up database: " . $e->getMessage();
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Student Management System</title>
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
                    <li class="nav-item"><a href="setup.php" class="nav-link active">Setup</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="form-container">
                <h2>Database Setup</h2>
                
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="setup-info">
                    <h3>Setup Instructions</h3>
                    <p>This will create the necessary database tables and insert sample data.</p>
                    
                    <h4>Tables to be created:</h4>
                    <ul>
                        <li><strong>students</strong> - Main student records table</li>
                    </ul>
                    
                    <h4>Sample Data:</h4>
                    <p>5 sample students with realistic data will be inserted for testing.</p>
                </div>

                <form method="POST" class="setup-form">
                    <input type="hidden" name="action" value="setup">
                    <button type="submit" class="btn btn-primary btn-large" 
                            onclick="return confirm('Are you sure you want to setup the database? This will create tables and insert sample data.')">
                        🔧 Setup Database
                    </button>
                </form>

                <div class="manual-setup">
                    <h3>Manual Setup Alternative</h3>
                    <p>If the automatic setup doesn't work, you can manually run the SQL in phpMyAdmin:</p>
                    <pre style="background: #f5f5f5; padding: 1rem; border-radius: 5px; overflow-x: auto;">CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE,
    address TEXT,
    major VARCHAR(100),
    gpa DECIMAL(3,2),
    enrollment_date DATE DEFAULT CURRENT_DATE,
    status ENUM('active', 'inactive', 'graduated') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);</pre>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System</p>
        </div>
    </footer>
</body>
</html>