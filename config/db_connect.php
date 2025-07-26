<?php
// Database configuration that works on both local XAMPP and Hostinger
$is_production = (strpos($_SERVER['DOCUMENT_ROOT'], 'u792860190') !== false);

if ($is_production) {
    // Hostinger production database settings
    $servername = "localhost"; 
    $username = "u792860190_campus"; // Replace with your Hostinger database username
    $password = "YourHostingerPassword123"; // Replace with your Hostinger database password
    $dbname = "u792860190_campusdb"; // Replace with your Hostinger database name
} else {
    // Local XAMPP database settings
    $servername = "localhost";
    $username = "root";
    $password = ""; // XAMPP usually has empty password
    $dbname = "collegefinder";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>