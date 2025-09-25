<?php
require_once 'includes/config.php';

// Test database connection
$connectionStatus = testConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <h1 class="nav-logo">Student Management System</h1>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="students.php" class="nav-link">Students</a></li>
                    <li class="nav-item"><a href="add_student.php" class="nav-link">Add Student</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <section class="hero">
                <h2>Welcome to Student Management System</h2>
                <p>A complete PHP & MySQL web application for managing student records</p>
                
                <div class="connection-status">
                    <h3>Database Connection Status:</h3>
                    <p class="<?php echo strpos($connectionStatus, 'successful') !== false ? 'success' : 'error'; ?>">
                        <?php echo $connectionStatus; ?>
                    </p>
                </div>
            </section>

            <section class="features">
                <h3>Features</h3>
                <div class="feature-grid">
                    <?php if (isLoggedIn()): ?>
                        <div class="feature-card">
                            <h4>📝 Add Students</h4>
                            <p>Register new students with their personal information</p>
                            <a href="add_student.php" class="btn btn-primary">Add Student</a>
                        </div>
                        
                        <div class="feature-card">
                            <h4>👥 View Students</h4>
                            <p>Browse and search through all registered students</p>
                            <a href="students.php" class="btn btn-primary">View Students</a>
                        </div>
                        
                        <div class="feature-card">
                            <h4>✏️ Edit Records</h4>
                            <p>Update student information and maintain accurate records</p>
                            <a href="students.php" class="btn btn-primary">Manage Records</a>
                        </div>
                    <?php else: ?>
                        <div class="feature-card">
                            <h4>� User Authentication</h4>
                            <p>Secure login and signup system with password protection</p>
                            <a href="login.php" class="btn btn-primary">Login</a>
                        </div>
                        
                        <div class="feature-card">
                            <h4>📝 Create Account</h4>
                            <p>Sign up for a new account to access student management</p>
                            <a href="signup.php" class="btn btn-primary">Sign Up</a>
                        </div>
                        
                        <div class="feature-card">
                            <h4>ℹ️ About System</h4>
                            <p>Learn more about this Student Management System</p>
                            <a href="about.php" class="btn btn-secondary">About</a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="feature-card">
                        <h4>🗄️ Database Setup</h4>
                        <p>Initialize database tables and sample data</p>
                        <a href="setup.php" class="btn btn-secondary">Setup Database</a>
                    </div>
                </div>
            </section>

            <section class="tech-stack">
                <h3>Technology Stack</h3>
                <div class="tech-items">
                    <span class="tech-badge">PHP</span>
                    <span class="tech-badge">MySQL</span>
                    <span class="tech-badge">HTML5</span>
                    <span class="tech-badge">CSS3</span>
                    <span class="tech-badge">InfinityFree Hosting</span>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System - Developed by <strong>Bharath Kumar A</strong></p>
        </div>
    </footer>
</body>
</html>