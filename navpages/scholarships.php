<?php
// Include database connection
require_once '../config/db_connect.php';

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
                <li><a href="../index.php" ' . ($currentPage == 'home' ? 'class="active"' : '') . '>Home</a></li>
                <li><a href="college-search.php" ' . ($currentPage == 'college-search' ? 'class="active"' : '') . '>College Search</a></li>
                <li><a href="scholarships.php" ' . ($currentPage == 'scholarships' ? 'class="active"' : '') . '>Scholarships</a></li>
                <li><a href="../navpages/about.php">About</a></li>
                <li><a href="../navpages/contact.php">Contact</a></li>
            </ul>
        </div>
    </div>';
}

// Get all scholarships
$query = "SELECT * FROM scholarships ORDER BY deadline ASC";
$result = $conn->query($query);
$scholarships = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scholarships[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarships | Campus Navigator</title>
    <link rel="stylesheet" href="scholarships.css">
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
            <?php echo getNavigationHTML('scholarships'); ?>
        </nav>
    </header>

    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Find Your Perfect <span class="highlight">Scholarship</span></h1>
                <p>Discover financial support opportunities to help fund your education journey</p>
            </div>
        </section>

        <!-- Scholarships Section -->
        <section class="scholarships-section">
            <div class="container">
                <div class="section-header">
                    <h2>Available Scholarships</h2>
                    <div class="filter-options">
                        <label for="filterBy">Filter by Category:</label>
                        <select id="filterBy">
                            <option value="all">All Categories</option>
                            <option value="Academic">Academic</option>
                            <option value="STEM">STEM</option>
                            <option value="Arts">Arts</option>
                            <option value="Need-based">Need-based</option>
                        </select>
                    </div>
                </div>
                
                <div class="scholarships-container" id="scholarshipsGrid">
                    <!-- No scholarships message -->
                    <?php if (empty($scholarships)): ?>
                        <div class="no-scholarships">
                            <i class="fas fa-info-circle"></i>
                            <h3>No scholarships available</h3>
                            <p>There are currently no scholarships in our database. Please check back later.</p>
                        </div>
                    <?php else: ?>
                        <!-- Scholarships cards -->
                        <?php foreach ($scholarships as $scholarship): ?>
                            <div class="scholarship-card" data-category="<?php echo $scholarship['category']; ?>" data-min-gpa="<?php echo $scholarship['min_gpa']; ?>">
                                <div class="scholarship-header">
                                    <h3><?php echo htmlspecialchars($scholarship['name']); ?></h3>
                                    <span class="scholarship-category"><?php echo $scholarship['category']; ?></span>
                                </div>
                                
                                <div class="scholarship-details">
                                    <div class="organization">
                                        <i class="fas fa-building"></i>
                                        <span><?php echo htmlspecialchars($scholarship['organization']); ?></span>
                                    </div>
                                    
                                    <div class="amount">
                                        <i class="fas fa-coins"></i>
                                        <span><?php echo htmlspecialchars($scholarship['amount']); ?></span>
                                    </div>
                                    
                                    <div class="deadline">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Deadline: <?php echo date('M d, Y', strtotime($scholarship['deadline'])); ?></span>
                                    </div>
                                </div>
                                
                                <div class="scholarship-description">
                                    <p><?php echo htmlspecialchars($scholarship['description']); ?></p>
                                </div>
                                
                                <div class="eligibility-info">
                                    <h4>Eligibility</h4>
                                    <p><?php echo htmlspecialchars($scholarship['eligibility']); ?></p>
                                    <div class="min-requirements">
                                        <span class="min-gpa">Min GPA: <?php echo $scholarship['min_gpa']; ?></span>
                                    </div>
                                </div>
                                
                                <div class="scholarship-actions">
                                    <a href="scholarship-apply.php?id=<?php echo $scholarship['id']; ?>" class="apply-btn">Apply Now</a>
                                    <button class="details-toggle" onclick="toggleDetails(this)">
                                        <i class="fas fa-chevron-down"></i>
                                        <span>View Details</span>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

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

    <script src="scholarships.js"></script>
</body>
</html>