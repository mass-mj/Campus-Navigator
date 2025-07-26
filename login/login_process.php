<?php
// Include database connection
require_once '../config/db_connect.php';

// Initialize session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Prepare SQL statement with proper escaping
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();
        
        // Verify password (in a real application, use password_verify())
        if ($password == $user['password']) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: ../users/admin-panel.php");
            } else {
                header("Location: ../users/user-panel.php");
            }
            exit();
        } else {
            // Invalid password
            header("Location: login.html?error=invalid_password");
            exit();
        }
    } else {
        // User not found
        header("Location: login.html?error=user_not_found");
        exit();
    }
}

// Close connection
$conn->close();
?> 