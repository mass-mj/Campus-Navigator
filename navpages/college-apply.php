<?php
// Include database connection
require_once '../config/db_connect.php';

// Start session to access user ID
session_start();

// Get college ID from URL
$college_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize college data
$college = null;

// If we have a valid ID, fetch the college details
if ($college_id > 0) {
    $query = "SELECT * FROM colleges WHERE id = $college_id";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $college = $result->fetch_assoc();
    }
}

// Handle form submission
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_application'])) {
    // Get form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $high_school = $conn->real_escape_string($_POST['high_school']);
    $high_school_percentage = floatval($_POST['high_school_percentage']);
    $program_of_interest = $conn->real_escape_string($_POST['program_of_interest']);
    $entrance_exam = $conn->real_escape_string($_POST['entrance_exam']);
    $entrance_score = $conn->real_escape_string($_POST['entrance_score']);
    $achievements = $conn->real_escape_string($_POST['achievements']);
    $personal_statement = $conn->real_escape_string($_POST['personal_statement']);
    $parent_name = $conn->real_escape_string($_POST['parent_name']);
    $parent_contact = $conn->real_escape_string($_POST['parent_contact']);
    $documents_link = $conn->real_escape_string($_POST['documents_link']);
    
    // Get the current user's ID from session (if logged in)
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;
    
    // Insert into database with user_id
    $insert_query = "INSERT INTO college_applications (college_id, user_id, full_name, email, phone, address, dob, gender, high_school, high_school_percentage, program_of_interest, entrance_exam, entrance_score, achievements, personal_statement, parent_name, parent_contact, documents_link) 
                     VALUES ('$college_id', " . ($user_id ? $user_id : "NULL") . ", '$full_name', '$email', '$phone', '$address', '$dob', '$gender', '$high_school', '$high_school_percentage', '$program_of_interest', '$entrance_exam', '$entrance_score', '$achievements', '$personal_statement', '$parent_name', '$parent_contact', '$documents_link')";
    
    if ($conn->query($insert_query) === TRUE) {
        $success_message = "Your application has been submitted successfully! We will review your application and contact you soon.";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $college ? "Apply to " . htmlspecialchars($college['name']) : "College Application"; ?> | TheCodex</title>
    <link rel="stylesheet" href="college-search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Application Form Specific Styles */
        .application-section {
            padding: 3rem 5%;
            min-height: 70vh;
        }
        
        .application-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }
        
        .application-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .application-header h1 {
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            margin-bottom: 0.5rem;
            color: #2a2a2a;
        }
        
        .application-header p {
            color: #6e7687;
        }
        
        .college-summary {
            background-color: #f8f9fb;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #4a6bff;
        }
        
        .summary-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-item .label {
            font-size: 0.9rem;
            color: #6e7687;
        }
        
        .detail-item .value {
            font-weight: 600;
            color: #2a2a2a;
        }
        
        .application-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .form-section {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
        }
        
        .form-section h3 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: #4a6bff;
            font-weight: 600;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-row:last-child {
            margin-bottom: 0;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2a2a2a;
        }
        
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            padding: 0.8rem;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: #4a6bff;
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.1);
        }
        
        .form-group small {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #6e7687;
        }
        
        .full-width {
            grid-column: 1 / -1;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
            font-size: inherit;
        }
        
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        
        .cancel-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            color: #6e7687;
            background-color: #f8f9fb;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .cancel-btn:hover {
            background-color: #e9ecef;
        }
        
        .submit-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            background-color: #4a6bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background-color: #3b5bd9;
        }
        
        .declaration {
            margin: 1rem 0;
        }
        
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        /* Success and Error Messages */
        .success-message {
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 3rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        
        .success-message i {
            font-size: 3rem;
            color: #4CAF50;
            margin-bottom: 1rem;
        }
        
        .success-message h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #2a2a2a;
        }
        
        .success-message p {
            color: #6e7687;
            margin-bottom: 1.5rem;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background-color: #4a6bff;
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background-color: #3b5bd9;
        }
        
        .error-message {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .error-message i {
            color: #f44336;
            font-size: 1.2rem;
        }
        
        .error-container {
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 3rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        
        .error-container i {
            font-size: 3rem;
            color: #f44336;
            margin-bottom: 1rem;
        }
        
        .error-container h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #2a2a2a;
        }
        
        .error-container p {
            color: #6e7687;
            margin-bottom: 1.5rem;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .application-container, .success-message, .error-container {
            animation: fadeIn 0.5s ease;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .cancel-btn, .submit-btn {
                width: 100%;
            }
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
            <h2 class="loading-text">The<span>Codex</span></h2>
        </div>
    </div>

    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../landingpage/home.html">
                    <h1>The<span>Codex</span></h1>
                </a>
            </div>
            <div class="nav-links" id="navLinks">
                <i class="fas fa-times close-menu" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../navpages/about.html">About</a></li>
                    <li><a href="../navpages/college-search.php" class="active">Find Colleges</a></li>
                    <li><a href="../navpages/scholarships.php">Scholarships</a></li>
                    <li><a href="../navpages/resources.html">Resources</a></li>
                    <li><a href="../contact/contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="menu-btn">
                <i class="fas fa-bars" onclick="showMenu()"></i>
            </div>
            <div class="cta-buttons">
                <a href="../login/login.html" class="login-btn">Log In</a>
                <a href="../login/register.html" class="signup-btn">Sign Up</a>
            </div>
        </nav>
    </header>

    <!-- Application Form Section -->
    <section class="application-section">
        <?php if ($college): ?>
            <?php if ($success_message): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <h2>Application Submitted!</h2>
                    <p><?php echo $success_message; ?></p>
                    <a href="college-details.php?id=<?php echo $college_id; ?>" class="back-btn">Return to College Details</a>
                </div>
            <?php else: ?>
                <div class="application-container">
                    <div class="application-header">
                        <h1>Apply to <?php echo htmlspecialchars($college['name']); ?></h1>
                        <p>Complete the form below to submit your application for admission</p>
                        
                        <?php if ($error_message): ?>
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <p><?php echo $error_message; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="college-summary">
                        <div class="summary-details">
                            <div class="detail-item">
                                <span class="label">College:</span>
                                <span class="value"><?php echo htmlspecialchars($college['name']); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Location:</span>
                                <span class="value"><?php echo htmlspecialchars($college['location']); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Type:</span>
                                <span class="value"><?php echo htmlspecialchars($college['type']); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Ranking:</span>
                                <span class="value">#<?php echo $college['ranking']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <form class="application-form" method="POST" action="" id="collegeForm">
                        <div class="form-section">
                            <h3>Personal Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" required placeholder="Your full name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" required placeholder="Your email address">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="Your contact number">
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select id="gender" name="gender" required>
                                        <option value="" disabled selected>Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group full-width">
                                    <label for="address">Permanent Address</label>
                                    <textarea id="address" name="address" required placeholder="Your permanent address"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Academic Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="high_school">High School / Previous Institution</label>
                                    <input type="text" id="high_school" name="high_school" required placeholder="Name of your high school or previous institution">
                                </div>
                                <div class="form-group">
                                    <label for="high_school_percentage">High School Percentage / CGPA</label>
                                    <input type="number" id="high_school_percentage" name="high_school_percentage" step="0.01" min="0" max="100" required placeholder="Your final percentage or CGPA">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="entrance_exam">Entrance Exam (if applicable)</label>
                                    <input type="text" id="entrance_exam" name="entrance_exam" placeholder="JEE, NEET, CAT, etc.">
                                </div>
                                <div class="form-group">
                                    <label for="entrance_score">Entrance Exam Score</label>
                                    <input type="text" id="entrance_score" name="entrance_score" placeholder="Your score or percentile">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="program_of_interest">Program of Interest</label>
                                    <input type="text" id="program_of_interest" name="program_of_interest" required placeholder="Specify the program or major you're interested in">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="achievements">Achievements & Extracurricular Activities</label>
                                    <textarea id="achievements" name="achievements" placeholder="List your academic achievements, extracurricular activities, awards, etc."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Personal Statement</h3>
                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="personal_statement">Why do you want to join this college?</label>
                                    <textarea id="personal_statement" name="personal_statement" required placeholder="Explain your motivation for applying to this college and how it aligns with your academic and career goals (250-500 words)" rows="6"></textarea>
                                    <small>This is your opportunity to showcase your personality, ambitions, and how this college fits into your educational journey.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Parent/Guardian Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="parent_name">Parent/Guardian Name</label>
                                    <input type="text" id="parent_name" name="parent_name" required placeholder="Full name of parent or guardian">
                                </div>
                                <div class="form-group">
                                    <label for="parent_contact">Parent/Guardian Contact</label>
                                    <input type="tel" id="parent_contact" name="parent_contact" required placeholder="Contact number of parent or guardian">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Documents</h3>
                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="documents_link">Documents Link (Google Drive/Dropbox)</label>
                                    <input type="url" id="documents_link" name="documents_link" placeholder="https://">
                                    <small>Please upload the following documents to Google Drive or Dropbox and share the link: 
                                    Academic transcripts, ID proof, Passport-sized photograph, Entrance exam scorecard (if applicable), 
                                    Letters of recommendation, and any other relevant certificates.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="declaration">
                            <label class="checkbox-container">
                                <input type="checkbox" required>
                                <span class="checkmark"></span>
                                I declare that the information provided is true to the best of my knowledge. I understand that any false information may result in the rejection of my application.
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <a href="college-details.php?id=<?php echo $college_id; ?>" class="cancel-btn">Cancel</a>
                            <button type="submit" name="submit_application" class="submit-btn">Submit Application</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="error-container">
                <i class="fas fa-exclamation-triangle"></i>
                <h2>College Not Found</h2>
                <p>The college you're looking for doesn't exist or has been removed.</p>
                <a href="college-search.php" class="back-btn">Return to College Search</a>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-top">
            <div class="footer-logo">
                <h2>The<span>Codex</span></h2>
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
        <div class="footer-bottom">
            <p>&copy; 2023 TheCodex. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navigation Menu Toggle
        function showMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.add('active');
        }

        function hideMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.remove('active');
        }

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            setTimeout(() => {
                preloader.classList.add('preloader-finish');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 1000);
        });
        
        // Form validation for percentage
        document.getElementById('high_school_percentage').addEventListener('input', function() {
            let value = parseFloat(this.value);
            if (value > 100) this.value = "100";
            if (value < 0) this.value = "0";
        });
        
        // Character count for personal statement
        document.getElementById('personal_statement').addEventListener('input', function() {
            const minWords = 250;
            const maxWords = 500;
            const words = this.value.match(/\S+/g) || [];
            const wordCount = words.length;
            
            if (wordCount < minWords) {
                this.setCustomValidity(`Please write at least ${minWords} words. Current: ${wordCount} words`);
            } else if (wordCount > maxWords) {
                this.setCustomValidity(`Please write no more than ${maxWords} words. Current: ${wordCount} words`);
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>