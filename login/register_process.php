<?php
// Include database connection
require_once '../config/db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // In a real application, validate inputs and hash password
    
    // Check if email already exists
    $check_sql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        // User already exists
        header("Location: register.php?error=user_exists");
        exit();
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, email, password, role, full_name) VALUES ('$username', '$email', '$password', 'user', '$username')";
        
        if ($conn->query($sql) === TRUE) {
            // Registration successful
            header("Location: login.php?success=registration_complete");
            exit();
        } else {
            // Registration failed
            header("Location: register.php?error=registration_failed");
            exit();
        }
    }
}

// Close connection
$conn->close();
?>