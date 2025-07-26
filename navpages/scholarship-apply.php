<?php
// Start output buffering to allow for header redirects
ob_start();

// Include database connection
require_once '../config/db_connect.php';

// Start session to access user ID
session_start();

// Get scholarship ID from URL
$scholarship_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize scholarship data
$scholarship = null;

// Check for success parameter in URL to display success message
$success_message = "";
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success_message = "Your application has been submitted successfully! We will review your application and contact you soon.";
}

// If we have a valid ID, fetch the scholarship details
if ($scholarship_id > 0) {
    $query = "SELECT * FROM scholarships WHERE id = $scholarship_id";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $scholarship = $result->fetch_assoc();
    }
}

// Handle AJAX form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax_submit']) && $_POST['ajax_submit'] == '1') {
    // Get form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $institution = $conn->real_escape_string($_POST['institution']);
    $current_gpa = floatval($_POST['current_gpa']);
    $current_year = $conn->real_escape_string($_POST['current_year']);
    $field_of_study = $conn->real_escape_string($_POST['field_of_study']);
    $annual_income = $conn->real_escape_string($_POST['annual_income']);
    $documents_link = $conn->real_escape_string($_POST['documents_link']);
    
    // Get the current user's ID from session (if logged in)
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;
    
    // Insert into database with user_id
    $insert_query = "INSERT INTO scholarship_applications (scholarship_id, user_id, full_name, email, phone, address, institution, current_gpa, current_year, field_of_study, annual_income, documents_link) 
                     VALUES ('$scholarship_id', " . ($user_id ? $user_id : "NULL") . ", '$full_name', '$email', '$phone', '$address', '$institution', '$current_gpa', '$current_year', '$field_of_study', '$annual_income', '$documents_link')";
    
    $response = array();
    
    if ($conn->query($insert_query) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = "Your application has been submitted successfully! We will review your application and contact you soon.";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error: " . $conn->error;
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Regular form submission - fallback
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_application'])) {
    // Get form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $institution = $conn->real_escape_string($_POST['institution']);
    $current_gpa = floatval($_POST['current_gpa']);
    $current_year = $conn->real_escape_string($_POST['current_year']);
    $field_of_study = $conn->real_escape_string($_POST['field_of_study']);
    $annual_income = $conn->real_escape_string($_POST['annual_income']);
    $documents_link = $conn->real_escape_string($_POST['documents_link']);
    
    // Get the current user's ID from session (if logged in)
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;
    
    // Insert into database with user_id
    $insert_query = "INSERT INTO scholarship_applications (scholarship_id, user_id, full_name, email, phone, address, institution, current_gpa, current_year, field_of_study, annual_income, documents_link) 
                     VALUES ('$scholarship_id', " . ($user_id ? $user_id : "NULL") . ", '$full_name', '$email', '$phone', '$address', '$institution', '$current_gpa', '$current_year', '$field_of_study', '$annual_income', '$documents_link')";
    
    if ($conn->query($insert_query) === TRUE) {
        // Save success message for display in case JS is disabled
        $success_message = "Your application has been submitted successfully! We will review your application and contact you soon.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Define the getNavigationHTML function
function getNavigationHTML($currentPage) {
    return '
    <div class="container">
        <div class="logo">
            <a href="../index.php">Campus<span>Navigator</span></a>
        </div>
        <div class="menu-icon" onclick="showMenu()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="nav-links" id="navLinks">
            <div class="close-icon" onclick="hideMenu()">
                <i class="fas fa-times"></i>
            </div>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="college-search.php">College Search</a></li>
                <li><a href="scholarships.php" class="active">Scholarships</a></li>
                <li><a href="../navpages/about.html">About</a></li>
                <li><a href="../contact/contact.html">Contact</a></li>
            </ul>
        </div>
    </div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $scholarship ? "Apply for " . htmlspecialchars($scholarship['name']) : "Scholarship Application"; ?> | CampusNavigator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Base Styles */
        :root {
            --primary-color: #4a6bdd;
            --primary-hover: #3a59c2;
            --secondary-color: #ff6b6b;
            --text-color: #333;
            --text-light: #777;
            --border-color: #eaeaea;
            --background-light: #f9fafc;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --header-height: 70px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            background-color: var(--background-light);
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        ul {
            list-style: none;
        }
        
        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .preloader.preloader-finish {
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
        }
        
        .circular {
            animation: rotate 2s linear infinite;
            height: 50px;
            width: 50px;
        }
        
        .path {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
            stroke: var(--primary-color);
            animation: dash 1.5s ease-in-out infinite;
        }
        
        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }
        
        @keyframes dash {
            0% {
                stroke-dasharray: 1, 200;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -35;
            }
            100% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -124;
            }
        }
        
        .loading-text {
            margin-top: 20px;
            color: var(--text-color);
            font-weight: 600;
        }
        
        .loading-text span {
            color: var(--primary-color);
        }
        
        /* Header & Navigation */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 100;
            height: var(--header-height);
        }
        
        .navbar {
            height: 100%;
        }
        
        .navbar .container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo a {
            font-size: 24px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            color: var(--text-color);
        }
        
        .logo span {
            color: var(--primary-color);
        }
        
        .nav-links ul {
            display: flex;
            gap: 30px;
        }
        
        .nav-links ul li a {
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-links ul li a:hover, 
        .nav-links ul li a.active {
            color: var(--primary-color);
        }
        
        .nav-links ul li a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        .menu-icon, .close-icon {
            display: none;
            cursor: pointer;
            font-size: 24px;
            color: var(--text-color);
        }
        
        /* Main Content */
        .main-content {
            margin-top: var(--header-height);
            padding: 60px 0;
        }
        
        /* Application Section */
        .application-section {
            max-width: 900px;
            margin: 80px auto 60px;
            padding: 0 20px;
        }
        
        .application-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 40px;
        }
        
        .application-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .application-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-family: 'Outfit', sans-serif;
            color: var(--text-color);
        }
        
        .application-header p {
            color: var(--text-light);
            font-size: 16px;
        }
        
        .error-message {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            padding: 15px;
            margin-top: 20px;
            border-radius: 0 4px 4px 0;
        }
        
        .error-message i {
            color: #f44336;
        }
        
        .scholarship-summary {
            background-color: var(--background-light);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .summary-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-item .label {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
        }
        
        .detail-item .value {
            font-weight: 600;
            color: var(--text-color);
        }
        
        .form-section {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .form-section h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--primary-color);
            font-family: 'Outfit', sans-serif;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-group {
            flex: 1;
            min-width: 250px;
            padding: 0 10px;
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 107, 221, 0.1);
        }
        
        .form-group small {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--text-light);
        }
        
        .full-width {
            width: 100%;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .required-documents {
            background-color: var(--background-light);
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .required-documents h3 {
            font-size: 18px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
        }
        
        .required-documents p {
            margin-bottom: 15px;
            color: var(--text-light);
        }
        
        .required-documents ul {
            padding-left: 20px;
            list-style-type: disc;
        }
        
        .required-documents li {
            margin-bottom: 8px;
            color: var(--text-color);
        }
        
        .declaration {
            margin-bottom: 30px;
        }
        
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 15px;
            color: var(--text-color);
        }
        
        .checkbox-container input {
            margin-top: 4px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
        }
        
        .cancel-btn, .submit-btn {
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            text-align: center;
        }
        
        .cancel-btn {
            background-color: var(--background-light);
            color: var(--text-light);
            border: none;
        }
        
        .cancel-btn:hover {
            background-color: #e9ecef;
        }
        
        .submit-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            flex: 1;
        }
        
        .submit-btn:hover {
            background-color: var(--primary-hover);
        }
        
        /* Success message */
        .success-message {
            text-align: center;
            padding: 50px;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }
        
        .success-message i {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .success-message h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
        }
        
        .success-message p {
            color: var(--text-light);
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .back-btn:hover {
            background-color: var(--primary-hover);
        }
        
        /* Error container */
        .error-container {
            text-align: center;
            padding: 50px;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }
        
        .error-container i {
            font-size: 60px;
            color: #f44336;
            margin-bottom: 20px;
        }
        
        .error-container h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
        }
        
        .error-container p {
            color: var (--text-light);
            margin-bottom: 30px;
        }
        
        /* Footer */
        footer {
            background-color: white;
            border-top: 1px solid var(--border-color);
            margin-top: 40px;
        }
        
        .footer-top {
            padding: 60px 0;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
        }
        
        .footer-logo h2 {
            font-size: 24px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
        }
        
        .footer-logo span {
            color: var(--primary-color);
        }
        
        .footer-logo p {
            color: var(--text-light);
            max-width: 300px;
        }
        
        .footer-links {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .footer-column h3:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        .footer-column ul li {
            margin-bottom: 12px;
        }
        
        .footer-column ul li a {
            color: var(--text-light);
            transition: color 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: var(--primary-color);
        }
        
        .social-links {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: var(--background-light);
            border-radius: 50%;
            transition: background-color 0.3s, color 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .newsletter h4 {
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .newsletter-form {
            display: flex;
            height: 44px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 0 15px;
            border: 1px solid var(--border-color);
            border-right: none;
            border-radius: 6px 0 0 6px;
        }
        
        .newsletter-form button {
            width: 44px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .newsletter-form button:hover {
            background-color: var(--primary-hover);
        }
        
        .footer-bottom {
            padding: 20px 0;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }
        
        .footer-bottom p {
            color: var(--text-light);
            font-size: 14px;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .application-container {
                padding: 30px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .footer-logo {
                text-align: center;
            }
            
            .footer-logo p {
                max-width: 600px;
                margin: 0 auto;
            }
        }
        
        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
            }
            
            .footer-links {
                grid-template-columns: 1fr 1fr;
            }
            
            .menu-icon {
                display: block;
            }
            
            .nav-links {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                background-color: white;
                padding: 80px 30px 30px;
                transition: right 0.3s ease;
                box-shadow: -10px 0 30px rgba(0,0,0,0.1);
                z-index: 101;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .nav-links ul {
                flex-direction: column;
                gap: 20px;
            }
            
            .close-icon {
                display: block;
                position: absolute;
                top: 20px;
                right: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .application-container {
                padding: 20px;
            }
            
            .application-header h1 {
                font-size: 24px;
            }
            
            .required-documents, .form-section {
                padding: 15px;
            }
            
            .footer-links {
                grid-template-columns: 1fr;
            }
        }
        
        /* Success Modal Styles */
        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .success-modal.show {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            animation: modalPop 0.3s ease-out;
        }
        
        @keyframes modalPop {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .modal-icon {
            font-size: 70px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .modal-content h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
        }
        
        .modal-content p {
            color: var(--text-light);
            margin-bottom: 30px;
        }
        
        .modal-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .modal-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        
        .modal-btn:hover {
            background-color: var(--primary-hover);
        }
        
        .modal-link {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .modal-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
            <h2 class="loading-text">Campus<span>Navigator</span></h2>
        </div>
    </div>

    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <?php echo getNavigationHTML('scholarships'); ?>
        </nav>
    </header>

    <main class="main-content">
        <!-- Application Form Section -->
        <section class="application-section">
            <?php if ($scholarship): ?>
                <?php if ($success_message): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <h2>Application Submitted!</h2>
                        <p><?php echo $success_message; ?></p>
                        <a href="scholarships.php" class="back-btn">
                            <i class="fas fa-arrow-left"></i> Return to Scholarships
                        </a>
                    </div>
                <?php else: ?>
                    <div class="application-container">
                        <div class="application-header">
                            <h1>Apply for <?php echo htmlspecialchars($scholarship['name']); ?></h1>
                            <p>Complete the form below to submit your application for this scholarship</p>
                            
                            <?php if ($error_message): ?>
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p><?php echo $error_message; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="scholarship-summary">
                            <div class="summary-details">
                                <div class="detail-item">
                                    <span class="label">Offered by:</span>
                                    <span class="value"><?php echo htmlspecialchars($scholarship['organization']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Amount:</span>
                                    <span class="value"><?php echo htmlspecialchars($scholarship['amount']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Deadline:</span>
                                    <span class="value"><?php echo date('M d, Y', strtotime($scholarship['deadline'])); ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Min GPA Required:</span>
                                    <span class="value"><?php echo $scholarship['min_gpa']; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <form class="application-form" method="POST" action="" id="scholarshipForm">
                            <div class="form-section">
                                <h3>Personal Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" id="full_name" name="full_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" required>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="address">Address</label>
                                        <textarea id="address" name="address" required></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3>Academic Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="institution">Current Institution</label>
                                        <input type="text" id="institution" name="institution" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="current_gpa">Current GPA (out of 4.0)</label>
                                        <input type="number" id="current_gpa" name="current_gpa" step="0.01" min="0" max="4.0" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="current_year">Current Year of Study</label>
                                        <select id="current_year" name="current_year" required>
                                            <option value="" disabled selected>Select Year</option>
                                            <option value="High School">High School</option>
                                            <option value="First Year">First Year</option>
                                            <option value="Second Year">Second Year</option>
                                            <option value="Third Year">Third Year</option>
                                            <option value="Fourth Year">Fourth Year</option>
                                            <option value="Graduate">Graduate</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="field_of_study">Field of Study</label>
                                        <input type="text" id="field_of_study" name="field_of_study" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3>Financial Information</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="annual_income">Annual Family Income</label>
                                        <select id="annual_income" name="annual_income" required>
                                            <option value="" disabled selected>Select Range</option>
                                            <option value="Below ₹2,50,000">Below ₹2,50,000</option>
                                            <option value="₹2,50,000 - ₹5,00,000">₹2,50,000 - ₹5,00,000</option>
                                            <option value="₹5,00,000 - ₹10,00,000">₹5,00,000 - ₹10,00,000</option>
                                            <option value="Above ₹10,00,000">Above ₹10,00,000</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="documents_link">Documents Link (Google Drive/Dropbox)</label>
                                        <input type="url" id="documents_link" name="documents_link" placeholder="https://">
                                        <small>Upload required documents to a cloud storage and share the link here</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="required-documents">
                                <h3>Required Documents</h3>
                                <p>Please prepare the following documents and upload them to Google Drive or Dropbox:</p>
                                <ul>
                                    <?php 
                                        $documents = isset($scholarship['required_documents']) ? explode(',', $scholarship['required_documents']) : ['Resume/CV', 'Academic Transcripts', 'Personal Statement/Essay']; 
                                        foreach($documents as $document):
                                    ?>
                                        <li><?php echo trim(htmlspecialchars($document)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="declaration">
                                <label class="checkbox-container">
                                    <input type="checkbox" required>
                                    I declare that the information provided is true to the best of my knowledge.
                                </label>
                            </div>
                            
                            <div class="form-actions">
                                <a href="scholarships.php" class="cancel-btn">Cancel</a>
                                <button type="submit" name="submit_application" class="submit-btn">Submit Application</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="error-container">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h2>Scholarship Not Found</h2>
                    <p>The scholarship you're looking for doesn't exist or has been removed.</p>
                    <a href="scholarships.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Return to Scholarships
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Application Submitted!</h2>
            <p id="successMessage">Your application has been submitted successfully! We will review your application and contact you soon.</p>
            <div class="modal-actions">
                <button class="modal-btn" onclick="closeSuccessModal()">OK</button>
                <a href="scholarships.php" class="modal-link">Return to Scholarships</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-top">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-logo">
                        <h2>Campus<span>Navigator</span></h2>
                        <p>Your ultimate guide to finding the perfect college match</p>
                    </div>
                    <div class="footer-links">
                        <div class="footer-column">
                            <h3>Resources</h3>
                            <ul>
                                <li><a href="../navpages/college-search.php">College Search</a></li>
                                <li><a href="../navpages/scholarships.php">Scholarships</a></li>
                                <li><a href="#">Career Paths</a></li>
                                <li><a href="#">Admission Tips</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3>Company</h3>
                            <ul>
                                <li><a href="../navpages/about.html">About Us</a></li>
                                <li><a href="../contact/contact.html">Contact</a></li>
                                <li><a href="../privacy/privacy.html">Privacy Policy</a></li>
                                <li><a href="../terms/terms.html">Terms of Service</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3>Connect</h3>
                            <div class="social-links">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                            <div class="newsletter">
                                <h4>Subscribe to our newsletter</h4>
                                <form class="newsletter-form">
                                    <input type="email" placeholder="Your email address">
                                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 CampusNavigator. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Form validation for GPA
        document.getElementById('current_gpa').addEventListener('input', function() {
            let value = parseFloat(this.value);
            if (value > 4.0) this.value = "4.0";
            if (value < 0) this.value = "0";
        });
        
        // Navigation Menu Toggle
        function showMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Success Modal Functions
        function showSuccessModal(message) {
            if (message) {
                document.getElementById('successMessage').textContent = message;
            }
            document.getElementById('successModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('show');
            document.body.style.overflow = '';
            
            // Reset form after closing modal
            if (document.getElementById('scholarshipForm')) {
                document.getElementById('scholarshipForm').reset();
            }
        }

        // AJAX Form Submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('scholarshipForm');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show loading state
                    const submitBtn = document.querySelector('.submit-btn');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                    }
                    
                    // Create FormData object
                    const formData = new FormData(form);
                    formData.append('ajax_submit', '1');
                    
                    // Send AJAX request
                    fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success modal
                            showSuccessModal(data.message);
                            // Reset form
                            form.reset();
                        } else {
                            // Show error
                            alert(data.message || 'An error occurred during submission.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred during submission. Please try again.');
                    })
                    .finally(() => {
                        // Reset button state
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Submit Application';
                        }
                    });
                });
            }
            
            // Check for success message from non-AJAX submission
            <?php if (isset($success_message)): ?>
                showSuccessModal('<?php echo addslashes($success_message); ?>');
            <?php endif; ?>
        });

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            setTimeout(() => {
                preloader.classList.add('preloader-finish');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 800);
        });
    </script>
</body>
</html>
<?php 
// Flush the output buffer and turn off output buffering
ob_end_flush();
?>