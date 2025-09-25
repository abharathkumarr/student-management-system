<?php
// Database Setup Script with Authentication
require_once 'includes/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup with Auth - Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .setup-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .status {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f1aeb5;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1><a href="index.php">Student Management System</a></h1>
        </div>
    </nav>

    <div class="setup-container">
        <h2>Database Setup with Authentication</h2>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // SQL script to create all tables
                $sql = "
                -- Create users table for authentication
                CREATE TABLE IF NOT EXISTS users (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    username VARCHAR(50) UNIQUE NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    full_name VARCHAR(100) NOT NULL,
                    role ENUM('admin', 'user') DEFAULT 'user',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );

                -- Create students table
                CREATE TABLE IF NOT EXISTS students (
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
                );

                -- Create courses table
                CREATE TABLE IF NOT EXISTS courses (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    course_code VARCHAR(10) NOT NULL,
                    course_name VARCHAR(100) NOT NULL,
                    credits INT NOT NULL,
                    instructor VARCHAR(100),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );

                -- Create enrollments table
                CREATE TABLE IF NOT EXISTS enrollments (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    student_id INT NOT NULL,
                    course_id INT NOT NULL,
                    semester VARCHAR(20),
                    year INT,
                    grade CHAR(2),
                    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
                    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
                );

                -- Insert default admin user (password: admin123)
                INSERT IGNORE INTO users (username, password, email, full_name, role) VALUES
                ('admin', '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'System Administrator', 'admin');

                -- Insert sample students
                INSERT IGNORE INTO students (first_name, last_name, email, phone, date_of_birth, address, major, gpa) VALUES
                ('John', 'Doe', 'john.doe@email.com', '555-0101', '2000-01-15', '123 Main St, City, State', 'Computer Science', 3.75),
                ('Jane', 'Smith', 'jane.smith@email.com', '555-0102', '1999-05-20', '456 Oak Ave, City, State', 'Business Administration', 3.92),
                ('Mike', 'Johnson', 'mike.johnson@email.com', '555-0103', '2001-03-10', '789 Pine Rd, City, State', 'Engineering', 3.45),
                ('Sarah', 'Wilson', 'sarah.wilson@email.com', '555-0104', '2000-11-08', '321 Elm St, City, State', 'Psychology', 3.88),
                ('David', 'Brown', 'david.brown@email.com', '555-0105', '1998-07-25', '654 Maple Dr, City, State', 'Mathematics', 3.67);

                -- Insert sample courses
                INSERT IGNORE INTO courses (course_code, course_name, credits, instructor) VALUES
                ('CS101', 'Introduction to Programming', 3, 'Dr. Smith'),
                ('CS201', 'Data Structures', 4, 'Dr. Johnson'),
                ('MATH101', 'College Algebra', 3, 'Dr. Wilson'),
                ('ENG101', 'English Composition', 3, 'Dr. Davis'),
                ('BUS101', 'Introduction to Business', 3, 'Dr. Miller');
                ";

                // Execute the SQL script
                $pdo->exec($sql);
                
                echo '<div class="status success">
                        <h3>✅ Database Setup Successful!</h3>
                        <p>All tables have been created and sample data has been inserted.</p>
                      </div>';
                
                // Check what was created
                $stmt = $pdo->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                echo '<div class="status info">
                        <h4>Tables Created:</h4>
                        <ul>';
                foreach ($tables as $table) {
                    echo '<li>' . htmlspecialchars($table) . '</li>';
                }
                echo '</ul></div>';
                
                // Count records
                try {
                    $stmt = $pdo->query("SELECT COUNT(*) FROM students");
                    $studentCount = $stmt->fetchColumn();
                    
                    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                    $userCount = $stmt->fetchColumn();
                    
                    echo '<div class="status info">
                            <p><strong>Students in database:</strong> ' . $studentCount . '</p>
                            <p><strong>Users in database:</strong> ' . $userCount . '</p>
                          </div>';
                } catch (Exception $e) {
                    // Tables might not exist yet
                }
                
                echo '<div class="status success">
                        <h4>🔐 Authentication System Ready!</h4>
                        <p><strong>Default Admin Account:</strong></p>
                        <ul>
                            <li>Username: <code>admin</code></li>
                            <li>Password: <code>admin123</code></li>
                        </ul>
                        <h4>Next Steps:</h4>
                        <ul>
                            <li><a href="login.php">Login to the system</a></li>
                            <li><a href="signup.php">Create a new account</a></li>
                            <li><a href="students.php">View all students</a></li>
                            <li><a href="index.php">Go to homepage</a></li>
                        </ul>
                      </div>';
                
            } catch (PDOException $e) {
                echo '<div class="status error">
                        <h3>❌ Database Setup Failed</h3>
                        <p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
                      </div>';
            }
        } else {
            // Show the setup form
            ?>
            <div class="status info">
                <h3>Database Setup with Authentication</h3>
                <p>This will create all necessary tables including user authentication:</p>
                <ul>
                    <li>Create the <code>users</code> table for login/signup</li>
                    <li>Create the <code>students</code> table</li>
                    <li>Create the <code>courses</code> table</li>
                    <li>Create the <code>enrollments</code> table</li>
                    <li>Insert sample data and default admin account</li>
                </ul>
            </div>

            <?php
            // Test database connection first
            try {
                $pdo->query("SELECT 1");
                echo '<div class="status success">
                        <h4>✅ Database Connection: OK</h4>
                      </div>';
            } catch (PDOException $e) {
                echo '<div class="status error">
                        <h4>❌ Database Connection: FAILED</h4>
                        <p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>
                      </div>';
                exit;
            }
            ?>

            <form method="POST">
                <button type="submit" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">
                    🚀 Setup Database with Authentication
                </button>
            </form>
            <?php
        }
        ?>
    </div>
</body>
</html>