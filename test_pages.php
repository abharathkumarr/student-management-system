<?php
// Simple test for add_student.php
echo "<h1>Add Student Page Test</h1>";

try {
    require_once 'includes/config.php';
    echo "<p style='color: green;'>✅ Config loaded successfully</p>";
    
    $pdo = getDBConnection();
    echo "<p style='color: green;'>✅ Database connected</p>";
    
    // Check if students table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'students'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✅ Students table exists</p>";
        
        // Count students
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM students");
        $count = $stmt->fetch();
        echo "<p>Students in database: " . $count['count'] . "</p>";
        
        echo "<p><a href='students.php'>Try View Students page</a></p>";
        echo "<p><a href='add_student.php'>Try Add Student page</a></p>";
        
    } else {
        echo "<p style='color: red;'>❌ Students table does NOT exist</p>";
        echo "<p><strong>You need to create the students table first!</strong></p>";
        echo "<p><a href='setup_fixed.php'>Go to Setup Page</a></p>";
        
        echo "<h3>Quick Setup - Run this SQL in phpMyAdmin:</h3>";
        echo "<pre style='background: #f5f5f5; padding: 1rem; border: 1px solid #ddd;'>";
        echo "CREATE TABLE IF NOT EXISTS students (
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
);";
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>