<?php
require_once '../config/database.php';

try {
    // Create database connection
    $conn = getDBConnection();
    
    // Create tables
    createTables($conn);
    
    // Import sample data
    $sql = file_get_contents('../data/colleges.sql');
    $conn->exec($sql);
    
    echo "Database initialized successfully!\n";
    echo "Default admin credentials:\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
    
} catch(PDOException $e) {
    die("Database initialization failed: " . $e->getMessage() . "\n");
}
?> 