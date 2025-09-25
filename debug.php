<?php
// Debug script to check what's wrong
echo "<h1>Debug Information</h1>";

// Check PHP version
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

// Check if includes/config.php exists
if (file_exists('includes/config.php')) {
    echo "<p style='color: green;'>✅ includes/config.php exists</p>";
    
    // Try to include it
    try {
        require_once 'includes/config.php';
        echo "<p style='color: green;'>✅ config.php loaded successfully</p>";
        
        // Test database connection
        echo "<p><strong>Testing database connection...</strong></p>";
        echo testConnection();
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error loading config.php: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ includes/config.php NOT FOUND</p>";
    echo "<p>Current directory contents:</p><ul>";
    foreach (scandir('.') as $item) {
        if ($item != '.' && $item != '..') {
            echo "<li>" . $item . "</li>";
        }
    }
    echo "</ul>";
}

// Check if other files exist
$files = ['index.php', 'students.php', 'add_student.php', 'css/style.css'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $file exists</p>";
    } else {
        echo "<p style='color: red;'>❌ $file missing</p>";
    }
}
?>