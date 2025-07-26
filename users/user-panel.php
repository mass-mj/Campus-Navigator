<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

// Include database connection
require_once '../config/db_connect.php';

// Create uploads directory if it doesn't exist
$uploadsDir = '../uploads';
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0777, true);
}

// Get logged in user's ID from session
$user_id = $_SESSION['user_id'];  // Use session user_id instead of hardcoding to 1

// Get user information
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Get college applications for the logged-in user
$collegeQuery = "SELECT ca.*, c.name as college_name, c.location 
                FROM college_applications ca 
                JOIN colleges c ON ca.college_id = c.id 
                WHERE ca.user_id = $user_id 
                ORDER BY ca.applied_at DESC";
$collegeResult = $conn->query($collegeQuery);
$collegeApplications = [];

if ($collegeResult && $collegeResult->num_rows > 0) {
    while ($row = $collegeResult->fetch_assoc()) {
        $collegeApplications[] = $row;
    }
}

// Get scholarship applications for the logged-in user
// First, check if the user_id column exists in the scholarship_applications table
$checkColumnQuery = "SELECT COUNT(*) as column_exists 
                    FROM information_schema.columns 
                    WHERE table_schema = DATABASE()
                    AND table_name = 'scholarship_applications' 
                    AND column_name = 'user_id'";
$columnCheckResult = $conn->query($checkColumnQuery);
$columnExists = ($columnCheckResult && $columnCheckResult->fetch_assoc()['column_exists'] > 0);

// Get scholarship applications based on whether the user_id column exists
$scholarshipApplications = [];
if ($columnExists) {
    $scholarshipQuery = "SELECT sa.*, s.name as scholarship_name, s.organization 
                        FROM scholarship_applications sa 
                        JOIN scholarships s ON sa.scholarship_id = s.id 
                        WHERE sa.user_id = $user_id 
                        ORDER BY sa.applied_at DESC";
    $scholarshipResult = $conn->query($scholarshipQuery);
    
    if ($scholarshipResult && $scholarshipResult->num_rows > 0) {
        while ($row = $scholarshipResult->fetch_assoc()) {
            $scholarshipApplications[] = $row;
        }
    }
}

// Handle profile updates
$updateSuccess = false;
$updateError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $fullName = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    
    // Handle profile picture upload
    $profilePicture = $user['profile_picture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
        $fileName = $_FILES['profile_picture']['name'];
        $fileTmpName = $_FILES['profile_picture']['tmp_name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileError = $_FILES['profile_picture']['error'];
        $fileType = $_FILES['profile_picture']['type'];
        
        // Get file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExt, $allowedExtensions)) {
            if ($fileError === 0) {
                $newFileName = uniqid('profile_') . '.' . $fileExt;
                $uploadPath = $uploadsDir . '/' . $newFileName;
                
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    $profilePicture = $newFileName;
                } else {
                    $updateError = "Failed to upload profile picture. Please try again.";
                }
            } else {
                $updateError = "There was an error uploading your file.";
            }
        } else {
            $updateError = "Only JPG, JPEG and PNG files are allowed.";
        }
    }
    
    // Update profile
    $updateQuery = "UPDATE users SET 
                    full_name = '$fullName', 
                    email = '$email', 
                    phone = '$phone', 
                    address = '$address', 
                    profile_picture = '$profilePicture' 
                    WHERE id = $user_id";
    
    if ($conn->query($updateQuery) === TRUE) {
        $updateSuccess = true;
        // Refresh user data
        $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
        $user = $result->fetch_assoc();
    } else {
        $updateError = "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Campus Navigator</title>
    <link rel="stylesheet" href="user-panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            <div class="logo">
                <a href="../index.html">
                    <h1>Campus<span>Navigator</span></h1>
                </a>
            </div>
            <div class="nav-links" id="navLinks">
                <i class="fas fa-times close-menu" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../navpages/about.html">About</a></li>
                    <li><a href="../navpages/college-search.php">Find Colleges</a></li>
                    <li><a href="../navpages/scholarships.php">Scholarships</a></li>
                    <li><a href="../navpages/resources.html">Resources</a></li>
                    <li><a href="../contact/contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="menu-btn">
                <i class="fas fa-bars" onclick="showMenu()"></i>
            </div>
            <div class="user-menu">
                <div class="user-profile" id="userProfileBtn">
                    <img src="<?php echo file_exists('../uploads/' . $user['profile_picture']) ? '../uploads/' . $user['profile_picture'] : '../uploads/default.jpg'; ?>" alt="Profile">
                    <span><?php echo $user['username']; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <a href="#" id="profileLink"><i class="fas fa-user"></i> Profile</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="user-info">
                <div class="user-avatar">
                    <img src="<?php echo file_exists('../uploads/' . $user['profile_picture']) ? '../uploads/' . $user['profile_picture'] : '../uploads/default.jpg'; ?>" alt="Profile Picture">
                </div>
                <h3><?php echo $user['full_name']; ?></h3>
                <p><?php echo $user['email']; ?></p>
            </div>
            <ul class="sidebar-menu">
                <li data-section="dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
                <li data-section="college-applications"><i class="fas fa-graduation-cap"></i> College Applications</li>
                <li data-section="scholarship-applications"><i class="fas fa-award"></i> Scholarship Applications</li>
                <li data-section="profile"><i class="fas fa-user"></i> Profile Settings</li>
            </ul>
        </div>
        
        <div class="dashboard-content">
            <!-- Dashboard Tab -->
            <div class="content-section active" id="dashboard">
                <h2 class="section-title">Dashboard</h2>
                <div class="dashboard-overview">
                    <div class="stats-card">
                        <div class="stats-icon college-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stats-info">
                            <h3>College Applications</h3>
                            <p class="stats-number"><?php echo count($collegeApplications); ?></p>
                        </div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-icon scholarship-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="stats-info">
                            <h3>Scholarship Applications</h3>
                            <p class="stats-number"><?php echo count($scholarshipApplications); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="recent-activity">
                    <h3>Recent Applications</h3>
                    <?php if (count($collegeApplications) > 0 || count($scholarshipApplications) > 0): ?>
                        <div class="activity-list">
                            <?php 
                            // Combine and sort all applications by date
                            $allApplications = [];
                            foreach ($collegeApplications as $app) {
                                $app['type'] = 'college';
                                $allApplications[] = $app;
                            }
                            foreach ($scholarshipApplications as $app) {
                                $app['type'] = 'scholarship';
                                $allApplications[] = $app;
                            }
                            
                            // Sort by applied_at descending
                            usort($allApplications, function($a, $b) {
                                return strtotime($b['applied_at']) - strtotime($a['applied_at']);
                            });
                            
                            // Show 5 most recent
                            $recentApps = array_slice($allApplications, 0, 5);
                            
                            foreach ($recentApps as $app):
                                $icon = $app['type'] === 'college' ? 'fa-graduation-cap' : 'fa-award';
                                $name = $app['type'] === 'college' ? $app['college_name'] : $app['scholarship_name'];
                                $status = $app['status'];
                                $date = date('M d, Y', strtotime($app['applied_at']));
                            ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas <?php echo $icon; ?>"></i>
                                    </div>
                                    <div class="activity-details">
                                        <p>
                                            Applied to <strong><?php echo htmlspecialchars($name); ?></strong>
                                            <span class="activity-date"><?php echo $date; ?></span>
                                        </p>
                                        <div class="application-status <?php echo strtolower($status); ?>">
                                            <?php echo $status; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-applications">
                            <p>You haven't applied to any colleges or scholarships yet.</p>
                            <div class="action-buttons">
                                <a href="../navpages/college-search.php" class="btn-primary">Find Colleges</a>
                                <a href="../navpages/scholarships.php" class="btn-secondary">Find Scholarships</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- College Applications Tab -->
            <div class="content-section" id="college-applications">
                <h2 class="section-title">College Applications</h2>
                <?php if (count($collegeApplications) > 0): ?>
                    <div class="applications-list">
                        <?php foreach ($collegeApplications as $app): ?>
                            <div class="application-card">
                                <div class="application-header">
                                    <h3><?php echo htmlspecialchars($app['college_name']); ?></h3>
                                    <span class="application-status <?php echo strtolower($app['status']); ?>">
                                        <?php echo $app['status']; ?>
                                    </span>
                                </div>
                                <div class="application-details">
                                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($app['location']); ?></p>
                                    <p><i class="fas fa-book"></i> <?php echo htmlspecialchars($app['program_of_interest']); ?></p>
                                    <p><i class="fas fa-calendar-alt"></i> Applied on: <?php echo date('M d, Y', strtotime($app['applied_at'])); ?></p>
                                </div>
                                <div class="application-actions">
                                    <a href="../navpages/college-details.php?id=<?php echo $app['college_id']; ?>" class="btn-secondary">View College</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-applications">
                        <p>You haven't applied to any colleges yet.</p>
                        <a href="../navpages/college-search.php" class="btn-primary">Find Colleges</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Scholarship Applications Tab -->
            <div class="content-section" id="scholarship-applications">
                <h2 class="section-title">Scholarship Applications</h2>
                <?php if (count($scholarshipApplications) > 0): ?>
                    <div class="applications-list">
                        <?php foreach ($scholarshipApplications as $app): ?>
                            <div class="application-card">
                                <div class="application-header">
                                    <h3><?php echo htmlspecialchars($app['scholarship_name']); ?></h3>
                                    <span class="application-status <?php echo strtolower($app['status']); ?>">
                                        <?php echo $app['status']; ?>
                                    </span>
                                </div>
                                <div class="application-details">
                                    <p><i class="fas fa-building"></i> <?php echo htmlspecialchars($app['organization']); ?></p>
                                    <p><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($app['field_of_study']); ?></p>
                                    <p><i class="fas fa-calendar-alt"></i> Applied on: <?php echo date('M d, Y', strtotime($app['applied_at'])); ?></p>
                                </div>
                                <div class="application-actions">
                                    <a href="../navpages/scholarships.php" class="btn-secondary">View Scholarships</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-applications">
                        <p>You haven't applied to any scholarships yet.</p>
                        <a href="../navpages/scholarships.php" class="btn-primary">Find Scholarships</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Profile Settings Tab -->
            <div class="content-section" id="profile">
                <h2 class="section-title">Profile Settings</h2>
                
                <?php if ($updateSuccess): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <p>Profile updated successfully!</p>
                    </div>
                <?php endif; ?>
                
                <?php if ($updateError): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <p><?php echo $updateError; ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="profile-settings">
                    <form method="POST" action="" enctype="multipart/form-data" class="profile-form" id="profile-form">
                        <div class="form-section">
                            <div class="profile-picture-upload">
                                <div class="current-picture">
                                    <img src="<?php echo file_exists('../uploads/' . $user['profile_picture']) ? '../uploads/' . $user['profile_picture'] : '../uploads/default.jpg'; ?>" alt="Profile Picture" id="profilePreview">
                                </div>
                                <div class="upload-controls">
                                    <label for="profile_picture" class="upload-btn">
                                        <i class="fas fa-camera"></i> Change Picture
                                    </label>
                                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
                                    <p class="upload-info">JPG, JPEG or PNG. Max size 2MB.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Personal Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                                <div class="form-group full-width">
                                    <label for="address">Address</label>
                                    <textarea id="address" name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_profile" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="user-panel.js"></script>
</body>
</html>