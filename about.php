<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';

// Get some basic stats
$stats = [
    'total_students' => 0,
    'active_students' => 0,
    'average_gpa' => 0
];

try {
    $pdo = getDBConnection();
    
    // Get total students
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM students");
    $stats['total_students'] = $stmt->fetchColumn();
    
    // Get active students
    $stmt = $pdo->query("SELECT COUNT(*) as active FROM students WHERE status = 'active'");
    $stats['active_students'] = $stmt->fetchColumn();
    
    // Get average GPA
    $stmt = $pdo->query("SELECT AVG(gpa) as avg_gpa FROM students WHERE gpa IS NOT NULL");
    $avgGpa = $stmt->fetchColumn();
    $stats['average_gpa'] = $avgGpa ? round($avgGpa, 2) : 0;
    
} catch (Exception $e) {
    // Stats will remain at 0 if there's an error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .developer-section {
            background: linear-gradient(135deg, #4a5eb8 0%, #5d4e75 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
        }
        .developer-section h3 {
            color: #ffffff;
            font-weight: 700;
            
            margin-bottom: 1.5rem;
        }
        .developer-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 15px;
            z-index: 1;
        }
        .developer-profile {
            display: flex;
            gap: 2rem;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }
        .developer-photo {
            flex-shrink: 0;
        }
        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.5);
           
        }
        .developer-info {
            flex: 1;
            min-width: 300px;
        }
        .developer-info h4 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #ffffff;
            font-weight: 700;
           
        }
        .developer-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
           
        }
        .developer-education {
            font-size: 1.1rem;
            color: #ffffff;
            margin-bottom: 1rem;
            line-height: 1.4;
        
        }
        .developer-contact {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .developer-contact {
            color: #ffffff;
        }
        .developer-contact a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
           
        }
        .developer-contact a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        .social-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: #ffffff !important;
            text-decoration: none !important;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        .social-link:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }
        .social-link.linkedin:hover {
            background: #0077b5;
            border-color: #0077b5;
            color: #ffffff !important;
        }
        .social-link.github:hover {
            background: #333;
            border-color: #333;
            color: #ffffff !important;
        }
        .social-icon {
            font-size: 1.2rem;
        }
        .developer-description {
            font-size: 1rem;
            line-height: 1.6;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        @media (max-width: 768px) {
            .developer-profile {
                flex-direction: column;
                text-align: center;
            }
            .profile-image {
                width: 150px;
                height: 150px;
            }
            .developer-info h4 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <h1 class="nav-logo">Student Management System</h1>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link active">About</a></li>
                    <li class="nav-item"><a href="students.php" class="nav-link">Students</a></li>
                    <li class="nav-item"><a href="add_student.php" class="nav-link">Add Student</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h2>About This Application</h2>
            </div>

            <div class="about-content">
                <section class="about-section developer-section">
                    <h3>About the Developer</h3>
                    <div class="developer-profile">
                        <div class="developer-photo">
                            <img src="src/bharath.jpeg" alt="Bharath Kumar A" class="profile-image">
                        </div>
                        <div class="developer-info">
                            <h4>Bharath Kumar A</h4>
                            <p class="developer-title">Software Engineering Graduate Student</p>
                            <p class="developer-education">Master's in Software Engineering<br>San José State University (SJSU)</p>
                            <div class="developer-contact">
                                <p><strong>Email:</strong> <a href="mailto:bharathkumar.a@sjsu.edu">bharathkumar.a@sjsu.edu</a></p>
                                <div class="social-links">
                                    <a href="https://www.linkedin.com/in/abharathkumarr/" target="_blank" class="social-link linkedin">
                                        <span class="social-icon">💼</span> LinkedIn
                                    </a>
                                    <a href="https://github.com/abharathkumarr" target="_blank" class="social-link github">
                                        <span class="social-icon">🐙</span> GitHub
                                    </a>
                                </div>
                            </div>
                            <p class="developer-description">
                                This Student Management System was developed as part of my web programming coursework at SJSU. 
                                The project demonstrates proficiency in full-stack web development using PHP, MySQL, and modern web technologies.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="about-section">
                    <h3>Project Overview</h3>
                    <p>This Student Management System is a comprehensive web application built as part of a Web Programming course assignment. It demonstrates the integration of PHP backend development with MySQL database management, creating a fully functional CRUD (Create, Read, Update, Delete) application.</p>
                </section>

                <section class="about-section">
                    <h3>Features & Functionality</h3>
                    <div class="feature-list">
                        <div class="feature-item">
                            <h4>📝 Student Registration</h4>
                            <p>Add new students with comprehensive information including personal details, academic data, and contact information.</p>
                        </div>
                        <div class="feature-item">
                            <h4>👥 Student Directory</h4>
                            <p>Browse all registered students with search and filtering capabilities. View detailed student profiles with all relevant information.</p>
                        </div>
                        <div class="feature-item">
                            <h4>✏️ Record Management</h4>
                            <p>Update student information easily with form validation and error handling. Maintain accurate and up-to-date records.</p>
                        </div>
                        <div class="feature-item">
                            <h4>🗄️ Database Operations</h4>
                            <p>Complete CRUD operations with MySQL database, including data validation, error handling, and relationship management.</p>
                        </div>
                    </div>
                </section>

                <section class="about-section">
                    <h3>Technology Stack</h3>
                    <div class="tech-details">
                        <div class="tech-item">
                            <h4>Backend</h4>
                            <ul>
                                <li><strong>PHP 7.4+</strong> - Server-side scripting</li>
                                <li><strong>PDO</strong> - Database abstraction layer</li>
                                <li><strong>MySQL</strong> - Relational database management</li>
                            </ul>
                        </div>
                        <div class="tech-item">
                            <h4>Frontend</h4>
                            <ul>
                                <li><strong>HTML5</strong> - Semantic markup</li>
                                <li><strong>CSS3</strong> - Modern styling with Grid and Flexbox</li>
                                <li><strong>Responsive Design</strong> - Mobile-friendly interface</li>
                            </ul>
                        </div>
                        <div class="tech-item">
                            <h4>Hosting</h4>
                            <ul>
                                <li><strong>InfinityFree</strong> - Free web hosting</li>
                                <li><strong>Custom Domain</strong> - Professional web presence</li>
                                <li><strong>phpMyAdmin</strong> - Database management interface</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="about-section">
                    <h3>System Statistics</h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['total_students']; ?></div>
                            <div class="stat-label">Total Students</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['active_students']; ?></div>
                            <div class="stat-label">Active Students</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $stats['average_gpa']; ?></div>
                            <div class="stat-label">Average GPA</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo date('Y'); ?></div>
                            <div class="stat-label">Current Year</div>
                        </div>
                    </div>
                </section>

                <section class="about-section">
                    <h3>Database Schema</h3>
                    <div class="schema-info">
                        <h4>Students Table</h4>
                        <p>The main table storing student information with the following key fields:</p>
                        <ul>
                            <li><strong>id</strong> - Primary key (auto-increment)</li>
                            <li><strong>first_name, last_name</strong> - Student name (required)</li>
                            <li><strong>email</strong> - Unique email address (required)</li>
                            <li><strong>phone</strong> - Contact number (optional)</li>
                            <li><strong>date_of_birth</strong> - Birth date (optional)</li>
                            <li><strong>address</strong> - Physical address (optional)</li>
                            <li><strong>major</strong> - Field of study (optional)</li>
                            <li><strong>gpa</strong> - Grade point average (0.00-4.00)</li>
                            <li><strong>status</strong> - Enrollment status (active/inactive/graduated)</li>
                            <li><strong>enrollment_date</strong> - Date of enrollment (auto-set)</li>
                            <li><strong>created_at, updated_at</strong> - Timestamp tracking</li>
                        </ul>
                    </div>
                </section>

                <section class="about-section">
                    <h3>Security Features</h3>
                    <ul>
                        <li><strong>SQL Injection Prevention</strong> - Using prepared statements with PDO</li>
                        <li><strong>XSS Protection</strong> - HTML escaping for all user outputs</li>
                        <li><strong>Input Validation</strong> - Server-side validation for all form inputs</li>
                        <li><strong>Error Handling</strong> - Proper exception handling and user-friendly error messages</li>
                        <li><strong>Data Sanitization</strong> - Input cleaning and validation</li>
                    </ul>
                </section>

                <section class="about-section">
                    <h3>Course Requirements Met</h3>
                    <div class="requirements">
                        <div class="requirement-item completed">
                            <span class="check">✅</span>
                            <span>Custom domain name</span>
                        </div>
                        <div class="requirement-item completed">
                            <span class="check">✅</span>
                            <span>PHP programming support</span>
                        </div>
                        <div class="requirement-item completed">
                            <span class="check">✅</span>
                            <span>MySQL database integration</span>
                        </div>
                        <div class="requirement-item completed">
                            <span class="check">✅</span>
                            <span>Publicly accessible on the Internet</span>
                        </div>
                        <div class="requirement-item completed">
                            <span class="check">✅</span>
                            <span>Professional web programming environment</span>
                        </div>
                    </div>
                </section>

                <section class="about-section">
                    <h3>Future Enhancements</h3>
                    <ul>
                        <li>User authentication and role-based access control</li>
                        <li>Course enrollment and grade management</li>
                        <li>Report generation and data export</li>
                        <li>Email notifications and communication</li>
                        <li>File upload for student documents</li>
                        <li>Advanced search and filtering options</li>
                        <li>API endpoints for mobile app integration</li>
                    </ul>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System - Developed by <strong>Bharath Kumar A</strong></p>
            <p>Built for Web Programming Course | SJSU Software Engineering</p>
            <p style="font-size: 0.9rem; margin-top: 0.5rem;">
                <a href="https://www.linkedin.com/in/abharathkumarr/" target="_blank" style="color: #0077b5; text-decoration: none;">LinkedIn</a> | 
                <a href="https://github.com/abharathkumarr" target="_blank" style="color: #333; text-decoration: none;">GitHub</a> | 
                <a href="mailto:bharathkumar.a@sjsu.edu" style="color: #d63384; text-decoration: none;">Email</a>
            </p>
        </div>
    </footer>
</body>
</html>