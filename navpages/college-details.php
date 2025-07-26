<?php
// Include database connection
require_once '../config/db_connect.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $college ? htmlspecialchars($college['name']) : 'College Details'; ?> | TheCodex</title>
    <link rel="stylesheet" href="college-search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    
    <style>
        /* College details specific styles */
        .college-detail-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 5%;
        }
        
        .college-detail-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1.5rem;
        }
        
        .college-detail-logo {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .college-detail-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .college-detail-title h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .college-detail-location {
            display: flex;
            align-items: center;
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        .college-detail-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .college-detail-info {
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 2rem;
        }
        
        .detail-section {
            margin-bottom: 2rem;
        }
        
        .detail-section h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            display: inline-block;
        }
        
        .college-stats-detailed {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .stat-card {
            background-color: var(--bg-color);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-card .label {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .college-detail-sidebar {
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            align-self: start;
        }
        
        .map-button-container {
            margin: 1.5rem 0;
            text-align: center;
            position: relative;
        }
        
        .google-maps-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 1.2rem;
            background-color: #4285F4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 0.7rem;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .google-maps-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #4285F4, #34A853, #FBBC05, #EA4335);
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }
        
        .google-maps-btn:hover {
            background-color: #3367d6;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
        }
        
        .google-maps-btn:hover:before {
            opacity: 0.2;
        }
        
        .google-maps-btn i {
            font-size: 1.4rem;
            color: #FBBC05;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .pulse-dot {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 12px;
            height: 12px;
            background-color: #FBBC05;
            border-radius: 50%;
        }
        
        .pulse-dot:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(251, 188, 5, 0.6);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(3);
                opacity: 0;
            }
        }
        
        .location-info {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }
        
        .location-info i {
            color: #4285F4;
        }
        
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .not-found {
            text-align: center;
            padding: 3rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }
        
        .not-found h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }
        
        .not-found p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            transition: var(--hover-transition);
        }
        
        .back-btn:hover {
            background-color: #3b5bd9;
        }
        
        @media (max-width: 768px) {
            .college-detail-content {
                grid-template-columns: 1fr;
            }
            
            .college-detail-header {
                flex-direction: column;
                text-align: center;
            }
            
            .college-stats-detailed {
                grid-template-columns: 1fr;
            }
        }
        
        .college-actions {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .apply-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #4a6bff;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(74, 107, 255, 0.2);
        }
        
        .apply-btn:hover {
            background-color: #3b5bd9;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(74, 107, 255, 0.25);
        }
        
        .apply-btn i {
            font-size: 1.2rem;
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
                <a href="../index.html">
                    <h1>The<span>Codex</span></h1>
                </a>
            </div>
            <div class="nav-links" id="navLinks">
                <i class="fas fa-times close-menu" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../navpages/about.html">About</a></li>
                    <li><a href="../navpages/college-search.php" class="active">Find Colleges</a></li>
                    <li><a href="../navpages/scholarships.html">Scholarships</a></li>
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

    <!-- College Detail Content -->
    <div class="college-detail-container">
        <?php if ($college): ?>
            <div class="college-header">
                <a href="college-search.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Search</a>
                <h1><?php echo htmlspecialchars($college['name']); ?></h1>
                <div class="college-actions">
                    <a href="college-apply.php?id=<?php echo $college['id']; ?>" class="apply-btn"><i class="fas fa-graduation-cap"></i> Apply Now</a>
                </div>
            </div>

            <div class="college-detail-content">
                <div class="college-detail-info">
                    <div class="detail-section">
                        <h2>Overview</h2>
                        <p><?php echo htmlspecialchars($college['description']); ?></p>
                        
                        <div class="college-stats-detailed">
                            <div class="stat-card">
                                <div class="value">#<?php echo $college['ranking']; ?></div>
                                <div class="label">Ranking <?php echo $college['country'] == 'India' ? 'in India' : 'Global'; ?></div>
                            </div>
                            <div class="stat-card">
                                <div class="value"><?php echo $college['acceptance_rate']; ?>%</div>
                                <div class="label">Acceptance Rate</div>
                            </div>
                            <div class="stat-card">
                                <div class="value"><?php echo $college['country'] == 'India' ? '₹' . ($college['tuition'] / 100000) . 'L' : '$' . ($college['tuition'] / 75000) . 'K'; ?></div>
                                <div class="label">Annual Tuition</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h2>Programs & Specializations</h2>
                        <?php 
                            $tags = explode(',', $college['tags']);
                            echo '<div class="tags-container">';
                            foreach ($tags as $tag) {
                                echo '<span class="tag">' . htmlspecialchars($tag) . '</span>';
                            }
                            echo '</div>';
                        ?>
                        <p class="mt-3">The college offers various programs across disciplines. Contact the admissions office for more details about specific courses and curriculum.</p>
                    </div>
                    
                    <div class="detail-section">
                        <h2>Campus Facilities</h2>
                        <ul>
                            <li>Modern classrooms and lecture halls</li>
                            <li>Well-equipped laboratories</li>
                            <li>Extensive library resources</li>
                            <li>Sports and recreation facilities</li>
                            <li>On-campus accommodation</li>
                            <li>Cafeteria and dining options</li>
                        </ul>
                    </div>
                </div>
                
                <div class="college-detail-sidebar">
                    <h3>Quick Information</h3>
                    
                    <?php if ($college['google_maps_url']): ?>
                    <div class="map-button-container">
                        <a href="<?php echo htmlspecialchars($college['google_maps_url']); ?>" target="_blank" class="google-maps-btn">
                            <i class="fas fa-map-marker-alt"></i> View on Google Maps
                            <span class="pulse-dot"></span>
                        </a>
                        <div class="location-info">
                            <i class="fas fa-info-circle"></i> 
                            <?php echo htmlspecialchars($college['city'] . ', ' . $college['state'] . ', ' . $college['country']); ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="map-button-container">
                        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($college['name'] . ' ' . $college['location']); ?>" target="_blank" class="google-maps-btn">
                            <i class="fas fa-map-marker-alt"></i> View on Google Maps
                            <span class="pulse-dot"></span>
                        </a>
                        <div class="location-info">
                            <i class="fas fa-info-circle"></i> 
                            <?php echo htmlspecialchars($college['city'] . ', ' . $college['state'] . ', ' . $college['country']); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="college-actions">
                        <a href="college-apply.php?id=<?php echo $college['id']; ?>" class="apply-btn">
                            <i class="fas fa-graduation-cap"></i> Apply Now
                        </a>
                    </div>
                    
                    <div class="college-details-list">
                        <h3>Contact Information</h3>
                        <p><i class="fas fa-envelope"></i> admissions@<?php echo strtolower(str_replace(' ', '', $college['name'])); ?>.edu</p>
                        <p><i class="fas fa-phone"></i> +91 XXXX XXXXXX</p>
                        <p><i class="fas fa-globe"></i> www.<?php echo strtolower(str_replace(' ', '', $college['name'])); ?>.edu</p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="../navpages/college-search.php" class="back-btn">
                            <i class="fas fa-arrow-left"></i> Back to College Search
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Not Found -->
            <div class="not-found">
                <h2>College Not Found</h2>
                <p>The college you're looking for doesn't exist or has been removed.</p>
                <a href="../navpages/college-search.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to College Search
                </a>
            </div>
        <?php endif; ?>
    </div>

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
                        <li><a href="../navpages/scholarships.html">Scholarships</a></li>
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
    </script>
</body>
</html>