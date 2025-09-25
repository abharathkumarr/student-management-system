<?php
// Database configuration for InfinityFree hosting
// Connected to InfinityFree MySQL database

// InfinityFree database settings (for production deployment)
define('DB_HOST', 'sql204.infinityfree.com');
define('DB_NAME', 'if0_40021214_bharath1');
define('DB_USER', 'if0_40021214');
define('DB_PASS', 'Bahubali1236');

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        // For local testing, show user-friendly message
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            throw new Exception("Local testing: InfinityFree database not accessible from localhost. Deploy to InfinityFree to test database functionality.");
        }
        throw $e;
    }
}

// Test database connection function
function testConnection() {
    try {
        $pdo = getDBConnection();
        return "Database connection successful!";
    } catch (Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
}
?>