<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration for initial setup
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP usually has empty password

echo "Attempting to connect to MySQL server at $servername...<br>";

// Create connection without selecting a database
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . " (Error code: " . mysqli_connect_errno() . ")<br>");
}

echo "Connected successfully to MySQL server.<br>";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS collegefinder";
if (mysqli_query($conn, $sql)) {
    echo "Database 'collegefinder' created successfully.<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Close connection
mysqli_close($conn);

echo "MySQL connection closed.<br>";
echo "<a href='create_scholarships_table.php'>Click here to create the scholarships table</a>";
?> 