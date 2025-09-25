<?php
require_once 'includes/config.php';

$message = '';
$messageType = '';

if ($_POST['action'] ?? '' === 'setup') {
    try {
        $pdo = getDBConnection();
        
        // Read SQL file
        $sqlFile = file_get_contents('sql/setup.sql');
        
        // Split by semicolon and execute each statement
        $statements = array_filter(array_map('trim', explode(';', $sqlFile)));
        
        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^--/', $statement)) {
                $pdo->exec($statement);
            }
        }
        
        $message = "Database setup completed successfully! Tables created and sample data inserted.";
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
                        <li><strong>courses</strong> - Course information (optional)</li>
                        <li><strong>enrollments</strong> - Student-course relationships (optional)</li>
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
                    <p>If the automatic setup doesn't work, you can manually run the SQL script:</p>
                    <ol>
                        <li>Go to your InfinityFree control panel</li>
                        <li>Open phpMyAdmin</li>
                        <li>Select your database</li>
                        <li>Go to the "SQL" tab</li>
                        <li>Copy and paste the contents of <code>sql/setup.sql</code></li>
                        <li>Click "Go" to execute</li>
                    </ol>
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