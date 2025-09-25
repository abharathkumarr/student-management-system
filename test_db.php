<?php
require_once 'includes/config.php';

echo "<h1>Database Connection Test</h1>";
echo "<hr>";

// Test basic connection
echo "<h2>1. Basic Connection Test</h2>";
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✅ Connection successful!</p>";
    
    // Test database version
    $stmt = $pdo->query('SELECT VERSION() as version');
    $version = $stmt->fetch();
    echo "<p><strong>MySQL Version:</strong> " . $version['version'] . "</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Test if students table exists
echo "<h2>2. Table Existence Test</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'students'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "<p style='color: green;'>✅ Students table exists!</p>";
        
        // Count students
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM students");
        $count = $stmt->fetch();
        echo "<p><strong>Students in database:</strong> " . $count['count'] . "</p>";
        
    } else {
        echo "<p style='color: orange;'>⚠️ Students table does not exist. You need to run the setup.</p>";
        echo "<p><a href='setup.php'>Click here to setup database tables</a></p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Table check failed: " . $e->getMessage() . "</p>";
}

// Show all available tables
echo "<h2>3. Available Tables</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . array_values($table)[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tables found in database.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Could not list tables: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>← Back to Homepage</a></p>";
?>