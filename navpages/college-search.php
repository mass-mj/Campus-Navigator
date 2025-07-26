<?php
// Include database connection
require_once '../config/db_connect.php';

// Get initial colleges for the page load
$query = "SELECT * FROM colleges ORDER BY ranking ASC LIMIT 3";
$result = $conn->query($query);
$colleges = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $colleges[] = $row;
    }
}

$totalColleges = count($colleges);
?>

<?php
// Set page-specific variables
$page_title = "College Search";
$root_path = "../";
$additional_css = ["navpages/college-search.css"];
$additional_head = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
';

// Include header
include_once "../includes/header.php";

// Your existing PHP code for fetching colleges can go here
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="floating-elements">
            <div class="floating-element" data-speed="1.5"></div>
            <div class="floating-element" data-speed="2"></div>
            <div class="floating-element" data-speed="1"></div>
            <div class="floating-element" data-speed="2.5"></div>
            <div class="floating-element" data-speed="1.8"></div>
        </div>
        <div class="hero-content">
            <h1>Find Your <span class="highlight">Perfect</span> College</h1>
            <p>Discover the best educational institutions tailored to your preferences and goals</p>
            <div class="search-container">
                    <div class="search-box">
                        <input type="text" id="collegeSearch" placeholder="Search by college name, location or program...">
                        <button class="search-btn" id="searchButton"><i class="fas fa-search"></i></button>
                    </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="india">India</button>
                    <button class="filter-btn" data-filter="international">International</button>
                </div>
            </div>
            <div class="scroll-indicator">
                <span>Explore Top Colleges</span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Advanced Filter Panel
    <div class="advanced-filters" id="advancedFilters">
        <div class="filter-grid">
            <div class="filter-group">
                <h3>Location</h3>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="location" value="north-india"> North India</label>
                    <label><input type="checkbox" name="location" value="south-india"> South India</label>
                    <label><input type="checkbox" name="location" value="east-india"> East India</label>
                    <label><input type="checkbox" name="location" value="west-india"> West India</label>
                    <label><input type="checkbox" name="location" value="central-india"> Central India</label>
                    <label><input type="checkbox" name="location" value="usa"> USA</label>
                    <label><input type="checkbox" name="location" value="uk"> UK</label>
                    <label><input type="checkbox" name="location" value="australia"> Australia</label>
                    <label><input type="checkbox" name="location" value="canada"> Canada</label>
                    <label><input type="checkbox" name="location" value="europe"> Europe</label>
                </div>
            </div>
            <div class="filter-group">
                <h3>Programs</h3>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="program" value="engineering"> Engineering</label>
                    <label><input type="checkbox" name="program" value="medicine"> Medicine</label>
                    <label><input type="checkbox" name="program" value="business"> Business</label>
                    <label><input type="checkbox" name="program" value="arts"> Arts & Humanities</label>
                    <label><input type="checkbox" name="program" value="science"> Science</label>
                    <label><input type="checkbox" name="program" value="law"> Law</label>
                    <label><input type="checkbox" name="program" value="computer-science"> Computer Science</label>
                    <label><input type="checkbox" name="program" value="design"> Design</label>
                </div>
            </div>
            <div class="filter-group">
                <h3>Tuition Range</h3>
                <div class="range-slider">
                    <div class="range-values">
                        <span id="tuitionMin">₹0</span>
                        <span id="tuitionMax">₹25,00,000+</span>
                    </div>
                    <input type="range" id="tuitionRange" min="0" max="2500000" step="50000" value="2500000">
                </div>
            </div>
            <div class="filter-group">
                <h3>College Type</h3>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="type" value="public"> Public</label>
                    <label><input type="checkbox" name="type" value="private"> Private</label>
                    <label><input type="checkbox" name="type" value="deemed"> Deemed University</label>
                    <label><input type="checkbox" name="type" value="technical"> Technical Institute</label>
                </div>
            </div>
        </div>
        <div class="filter-actions">
            <button class="reset-btn">Reset Filters</button>
            <button class="apply-btn">Apply Filters</button>
        </div>
    </div> -->

    <!-- College Results Section -->
    <section class="college-results">
        <div class="results-header">
            <h2>Top Colleges</h2>
            <div class="results-count">Showing <span id="resultsCount"><?php echo $totalColleges; ?></span> colleges</div>
            <div class="sort-options">
                <label for="sortBy">Sort by:</label>
                <select id="sortBy">
                    <option value="ranking">Ranking</option>
                    <option value="tuition-low">Tuition (Low to High)</option>
                    <option value="tuition-high">Tuition (High to Low)</option>
                    <option value="acceptance">Acceptance Rate</option>
                </select>
            </div>
        </div>
        
        <div class="results-grid" id="collegeGrid">
            <!-- College results will be loaded dynamically here -->
            <?php if (empty($colleges)): ?>
                <div class="no-results">
                    <p>No colleges found. Try a different search or filter.</p>
                </div>
            <?php else: ?>
                <?php foreach ($colleges as $college): 
                    $tags = explode(',', $college['tags']);
                ?>
                    <div class="college-card <?php echo $college['country'] == 'India' ? 'india' : 'international'; ?>" 
                         data-category="<?php echo htmlspecialchars($college['category']); ?>" 
                         data-ranking="<?php echo $college['ranking']; ?>" 
                         data-tuition="<?php echo $college['tuition']; ?>" 
                         data-acceptance="<?php echo $college['acceptance_rate']; ?>">
                        <div class="college-header">
                            <div class="college-logo">
                                <img src="<?php echo htmlspecialchars($college['logo_url']); ?>" alt="<?php echo htmlspecialchars($college['name']); ?> Logo">
                            </div>
                            <div class="college-badge">
                                <span class="rank">#<?php echo $college['ranking']; ?></span>
                                <span><?php echo $college['country'] == 'India' ? 'in India' : 'Global'; ?></span>
                            </div>
                        </div>
                        <div class="college-content">
                            <h3><?php echo htmlspecialchars($college['name']); ?></h3>
                            <div class="college-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($college['location']); ?></div>
                            <div class="college-stats">
                                <div class="stat">
                                    <span class="stat-value"><?php echo $college['acceptance_rate']; ?>%</span>
                                    <span class="stat-label">Acceptance Rate</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-value"><?php echo $college['country'] == 'India' ? '₹' . ($college['tuition'] / 100000) . 'L' : '$' . ($college['tuition'] / 75000) . 'K'; ?></span>
                                    <span class="stat-label">Annual Tuition</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-value"><?php echo $college['grade']; ?></span>
                                    <span class="stat-label"><?php echo strpos($college['grade'], 'QS') !== false ? 'World Rank' : 'NAAC Grade'; ?></span>
                                </div>
                            </div>
                            <p class="college-desc"><?php echo htmlspecialchars($college['description']); ?></p>
                            <div class="college-tags">
                                <?php foreach ($tags as $tag): ?>
                                    <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="college-actions">
                            <a href="college-details.php?id=<?php echo $college['id']; ?>" class="btn-details">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- No Results Message -->
        <div class="no-results" style="display: none;">
            <p>No colleges match your search criteria. Try adjusting your filters or search term.</p>
        </div>
        
        <!-- Load More Button -->
        <div class="load-more-container">
            <button id="loadMoreBtn" class="load-more-btn">Load More Results</button>
        </div>
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

    <script src="college-search-dynamic.js"></script>
    
    <!-- Script to handle incoming search queries -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get query parameters from URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('q');
            
            // If there's a search query in the URL
            if (searchQuery) {
                // Fill the search input
                const searchInput = document.getElementById('collegeSearch');
                if (searchInput) {
                    searchInput.value = searchQuery;
                    
                    // Trigger search after a short delay to ensure page is fully loaded
                    setTimeout(() => {
                        // Trigger search button click
                        const searchButton = document.getElementById('searchButton');
                        if (searchButton) {
                            searchButton.click();
                        } else {
                            // Fallback: manually trigger search function if it exists
                            if (typeof performSearch === 'function') {
                                performSearch(searchQuery);
                            }
                        }
                    }, 500);
                }
            }

            // Animate hero content
            const heroContent = document.querySelector('.hero-content');
            if (heroContent) {
                heroContent.classList.add('animate');
            }

            // Initialize GSAP animations for floating elements
            if (typeof gsap !== 'undefined') {
                // Initialize staggered animations for floating elements
                gsap.from('.floating-element', {
                    scale: 0,
                    opacity: 0,
                    duration: 1.5,
                    stagger: 0.2,
                    ease: "power3.out"
                });
                
                // Add more complex movement to floating elements
                document.querySelectorAll('.floating-element').forEach(element => {
                    const speed = element.getAttribute('data-speed') || 1;
                    
                    gsap.to(element, {
                        x: `random(-50, 50)`,
                        y: `random(-50, 50)`,
                        duration: 10 * speed,
                        repeat: -1,
                        yoyo: true,
                        ease: "sine.inOut"
                    });
                });
            }

            // Make scroll indicator functional
            const scrollIndicator = document.querySelector('.scroll-indicator');
            if (scrollIndicator) {
                scrollIndicator.addEventListener('click', function() {
                    const resultsSection = document.querySelector('.college-results');
                    if (resultsSection) {
                        resultsSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }
        });
    </script>
</body>
</html>