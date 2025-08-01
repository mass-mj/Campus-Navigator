<?php
// Set page-specific variables
$page_title = "Find Your Perfect College Match";
$root_path = "";
$additional_css = ["ai-assistant.css"];
$additional_head = '
<!-- GSAP for animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<!-- Three.js for 3D elements -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.150.1/three.min.js"></script>
<!-- Particles.js for background effects -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
';

// Include header
include_once "includes/header.php";
?>

    <!-- Hero Section with 3D Background -->
    <section class="hero">
        <div id="particles-js"></div>
        <div class="hero-content" data-speed="0.5">
            <h1 class="animate-text">Find Your <span class="gradient-text">Perfect</span> College Match</h1>
            <p class="animate-text-delay">Navigate your college journey with confidence using our advanced tools and resources</p>
            <form class="search-container animate-scale" action="<?php echo $root_path; ?>navpages/college-search.php" method="GET">
                <input type="text" name="q" placeholder="Search for colleges, programs, or majors...">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
            <div class="hero-cta animate-up">
                <a href="#tools" class="primary-btn magnetic-button">Explore Tools</a>
            </div>
            <div class="floating-badges">
                <div class="badge" data-speed="0.8">
                    <i class="fas fa-graduation-cap"></i>
                    <span>4,000+ Colleges</span>
                </div>
                <div class="badge" data-speed="1.2">
                    <i class="fas fa-users"></i>
                    <span>1.5M+ Students</span>
                </div>
                <div class="badge" data-speed="0.6">
                    <i class="fas fa-star"></i>
                    <span>95% Success Rate</span>
                </div>
            </div>
        </div>
        
        </div>
    </section>

    <!-- Stats Section with Counter Animation -->
    <section class="stats reveal-section">
        <div class="stats-bg"></div>
        <div class="stat-container">
            <div class="stat-item" data-aos="fade-up">
                <div class="stat-icon"><i class="fas fa-university"></i></div>
                <h2 class="counter" data-target="4000">0</h2>
                <p>Colleges in database</p>
                <div class="progress-bar"><div class="progress-fill"></div></div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <h2 class="counter" data-target="1500000">0</h2>
                <p>Students helped</p>
                <div class="progress-bar"><div class="progress-fill"></div></div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                <h2 class="counter" data-target="40000000">0</h2>
                <p>Scholarship value</p>
                <div class="progress-bar"><div class="progress-fill"></div></div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                <h2 class="counter" data-target="95">0</h2>
                <p>Success rate</p>
                <div class="progress-bar"><div class="progress-fill"></div></div>
            </div>
        </div>
    </section>

    <!-- Interactive Tools Section -->
    <section id="tools" class="features reveal-section">
        <div class="section-header split-text">
            <h2>Tools for Your College Journey</h2>
            <p>Everything you need to make informed decisions about your education</p>
        </div>
        <div class="feature-grid">
            <div class="feature-card interactive" data-tilt>
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>College Finder</h3>
                <p>Discover the perfect college match based on your preferences, interests, and academic profile</p>
                <a href="../collegefinder/navpages/college-search.php" class="feature-link">Find Colleges <i class="fas fa-arrow-right"></i></a>
                <div class="glow-effect"></div>
            </div>
            <div class="feature-card interactive" data-tilt>
                <div class="feature-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3>Cost Calculator</h3>
                <p>Estimate your college expenses and plan your financial journey with our detailed cost breakdown</p>
                <a href="navpages/cost.html" class="feature-link">Calculate Costs <i class="fas fa-arrow-right"></i></a>
                <div class="glow-effect"></div>
            </div>
            <div class="feature-card interactive" data-tilt>
                <div class="feature-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h3>Scholarship Matcher</h3>
                <p>Access thousands of scholarships tailored to your profile and increase your chances of financial aid</p>
                <a href="../collegefinder/navpages/scholarships.php" class="feature-link">Find Scholarships <i class="fas fa-arrow-right"></i></a>
                <div class="glow-effect"></div>
            </div>
        </div>
    </section>

    <!-- Interactive How It Works Section with Parallax -->
    <section class="how-it-works reveal-section">
        <div class="parallax-bg"></div>
        <div class="section-header split-text">
            <h2>How It Works</h2>
            <p>Simple steps to find your perfect college match</p>
        </div>
        <div class="steps-container">
            <div class="step interactive" data-tilt>
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Create Your Profile</h3>
                    <p>Sign up and build your academic profile with your interests, achievements, and preferences</p>
                </div>
                <div class="step-visual">
                    <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jcikwtux.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
                </div>
            </div>
            <div class="step interactive" data-tilt>
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Get Personalized Matches</h3>
                    <p>Our algorithm matches you with colleges that align with your profile and preferences</p>
                </div>
                <div class="step-visual">
                    <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_x17ybolp.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
                </div>
            </div>
            <div class="step interactive" data-tilt>
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Compare Options</h3>
                    <p>Compare colleges side by side based on academics, cost, campus life, and more</p>
                </div>
                <div class="step-visual">
                    <lottie-player src="../collegefinder/assets/Animation - 1743094040108.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
                </div>
            </div>
            <div class="step interactive" data-tilt>
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Apply With Confidence</h3>
                    <p>Use our resources and tools to submit strong applications to your chosen colleges</p>
                </div>
                <div class="step-visual">
                    <lottie-player src="../collegefinder/assets/Animation - 1743094139629.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
        <div class="progress-tracker">
            <div class="progress-line">
                <div class="progress-fill"></div>
            </div>
            <div class="progress-circles">
                <div class="progress-circle active" data-step="1"></div>
                <div class="progress-circle" data-step="2"></div>
                <div class="progress-circle" data-step="3"></div>
                <div class="progress-circle" data-step="4"></div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="section-header">
            <h2>What Our Users Say</h2>
            <p>Real experiences from students who found their perfect college match</p>
        </div>
        <div class="testimonials-carousel">
            <div class="carousel-container">
                <div class="testimonial-slide active">
                    <div class="testimonial-content">
                        <div class="testimonial-img">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah M.">
                        </div>
                        <div class="testimonial-text">
                            <p>"CollegeFinder helped me discover universities I never would have considered. The scholarship matching tool saved me thousands in tuition costs!"</p>
                            <h4>Sarah M.</h4>
                            <span>Engineering Student, Stanford University</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slide">
                <div class="testimonial-content">
                        <div class="testimonial-img">
                            <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Michael K.">
                        </div>
                        <div class="testimonial-text">
                            <p>"The virtual campus tours let me explore universities from my home. I found my dream school without spending money on travel!"</p>
                            <h4>Michael K.</h4>
                            <span>Biology Major, University of Oxford</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <div class="testimonial-img">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Jessica T.">
                        </div>
                        <div class="testimonial-text">
                            <p>"The career path finder quiz was spot on! It helped me choose a major that aligns with my strengths and interests. Highly recommend!"</p>
                            <h4>Jessica T.</h4>
                            <span>Business Student, Princeton University</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-controls">
                <button class="carousel-btn prev"><i class="fas fa-chevron-left"></i></button>
                <div class="carousel-dots">
                    <span class="dot active" data-slide="0"></span>
                    <span class="dot" data-slide="1"></span>
                    <span class="dot" data-slide="2"></span>
                </div>
                <button class="carousel-btn next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- Interactive College Comparison Tool Section -->
    <section class="comparison-tool">
        <div class="section-header">
            <h2>Compare Colleges</h2>
            <p>See how different colleges stack up against each other on key metrics</p>
        </div>
        <div class="comparison-container">
            <div class="college-selectors">
                <div class="college-selector">
                    <select class="college-select" id="college1">
                        <option value="" selected disabled>Select first college</option>
                        <option value="harvard">Harvard University</option>
                        <option value="stanford">Stanford University</option>
                        <option value="mit">Massachusetts Institute of Technology</option>
                        <option value="oxford">University of Oxford</option>
                        <option value="cambridge">University of Cambridge</option>
                        <option value="princeton">Princeton University</option>
                    </select>
                </div>
                <div class="vs-badge">VS</div>
                <div class="college-selector">
                    <select class="college-select" id="college2">
                        <option value="" selected disabled>Select second college</option>
                        <option value="harvard">Harvard University</option>
                        <option value="stanford">Stanford University</option>
                        <option value="mit">Massachusetts Institute of Technology</option>
                        <option value="oxford">University of Oxford</option>
                        <option value="cambridge">University of Cambridge</option>
                        <option value="princeton">Princeton University</option>
                    </select>
                </div>
            </div>
            <div class="comparison-results">
                <div class="comparison-chart" id="comparisonChart">
                    <p class="placeholder-message">Select two colleges to compare their metrics</p>
                </div>
                <div class="comparison-metrics">
                    <button class="metric active" data-metric="tuition">Tuition Cost</button>
                    <button class="metric" data-metric="acceptance">Acceptance Rate</button>
                    <button class="metric" data-metric="enrollment">Enrollment</button>
                    <button class="metric" data-metric="sat">SAT Scores</button>
                    <button class="metric" data-metric="ranking">World Ranking</button>
                </div>
                <div class="comparison-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Data is updated in real-time from our college database</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Campus Tour Scheduler -->
    <section class="campus-tour">
        <div class="section-header">
            <h2>Schedule a Campus Tour</h2>
            <p>Visit campuses virtually or in-person to get a feel for college life</p>
        </div>
        <div class="tour-container">
            <div class="tour-options">
                <div class="tour-option active" data-tour-type="virtual">
                    <div class="tour-icon">
                        <i class="fas fa-vr-cardboard"></i>
                    </div>
                    <h3>Virtual Tour</h3>
                    <p>Explore campuses from anywhere in the world through our 360° virtual tours</p>
                </div>
                <div class="tour-option" data-tour-type="guided">
                    <div class="tour-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>Guided Tour</h3>
                    <p>Join a guided tour led by current students with scheduled Q&A sessions</p>
                </div>
                <div class="tour-option" data-tour-type="self">
                    <div class="tour-icon">
                        <i class="fas fa-walking"></i>
                    </div>
                    <h3>Self-Guided Tour</h3>
                    <p>Visit the campus at your own pace with our interactive map</p>
                </div>
            </div>
            <div class="tour-form">
                <div class="form-header">
                    <h3>Book Your Tour</h3>
                    <p>Select your preferred university and date</p>
                </div>
                <div class="form-fields">
                    <div class="form-group">
                        <label for="tourUniversity">University</label>
                        <select class="form-control" id="tourUniversity">
                            <option value="" selected disabled>Select a university</option>
                            <option value="harvard">Harvard University</option>
                            <option value="stanford">Stanford University</option>
                            <option value="mit">Massachusetts Institute of Technology</option>
                            <option value="oxford">University of Oxford</option>
                            <option value="cambridge">University of Cambridge</option>
                            <option value="princeton">Princeton University</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tourDate">Date</label>
                        <input type="date" class="form-control" id="tourDate" min="">
                    </div>
                    <div class="form-group">
                        <label for="tourTime">Time</label>
                        <select class="form-control" id="tourTime" disabled>
                            <option value="" selected disabled>Select date first</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tourEmail">Email</label>
                        <input type="email" class="form-control" id="tourEmail" placeholder="your@email.com">
                    </div>
                    <button class="tour-btn">Schedule Tour</button>
                </div>
                <div class="tour-availability">
                    <h4>Availability Today:</h4>
                    <div class="availability-indicator">
                        <span class="availability-dot available"></span>
                        <span>Virtual Tours: Available (24/7)</span>
                    </div>
                    <div class="availability-indicator">
                        <span class="availability-dot" id="guidedAvailability"></span>
                        <span>Guided Tours: <span id="guidedStatus">Checking...</span></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Career Path Finder -->
    <section class="career-finder career-bg">
        <div class="section-header">
            <h2>Find Your Ideal Career Path</h2>
            <p>Take a quick quiz to discover careers that match your interests and strengths</p>
        </div>
        <div class="career-quiz-container">
            <div class="career-progress">
                <div class="progress-label">
                    <span>Your Progress</span>
                    <span id="progressText">0/5</span>
                </div>
                <div class="progress career-progress-bar">
                    <div class="progress-fill career-progress-fill"></div>
                </div>
            </div>
            
            <div class="career-questions">
                <div class="question active" data-question="1">
                    <h3>What field are you most interested in?</h3>
                    <div class="answer-options">
                        <div class="answer-option" data-value="tech">
                            <i class="fas fa-laptop-code"></i>
                            <span>Technology</span>
                        </div>
                        <div class="answer-option" data-value="health">
                            <i class="fas fa-heartbeat"></i>
                            <span>Healthcare</span>
                        </div>
                        <div class="answer-option" data-value="business">
                            <i class="fas fa-chart-line"></i>
                            <span>Business</span>
                        </div>
                        <div class="answer-option" data-value="art">
                            <i class="fas fa-palette"></i>
                            <span>Arts & Design</span>
                        </div>
                    </div>
                </div>
                
                <div class="question" data-question="2">
                    <h3>How important is salary in your career choice?</h3>
                    <div class="slider-options">
                        <input type="range" min="1" max="5" value="3" class="preference-slider" id="salaryImportance">
                        <div class="slider-labels">
                            <span>Not important</span>
                            <span>Very important</span>
                        </div>
                    </div>
                </div>
                
                <div class="question" data-question="3">
                    <h3>What work environment do you prefer?</h3>
                    <div class="answer-options">
                        <div class="answer-option" data-value="office">
                            <i class="fas fa-building"></i>
                            <span>Traditional Office</span>
                        </div>
                        <div class="answer-option" data-value="remote">
                            <i class="fas fa-home"></i>
                            <span>Remote Work</span>
                        </div>
                        <div class="answer-option" data-value="field">
                            <i class="fas fa-mountain"></i>
                            <span>Fieldwork</span>
                        </div>
                        <div class="answer-option" data-value="mixed">
                            <i class="fas fa-random"></i>
                            <span>Mixed Environment</span>
                        </div>
                    </div>
                </div>
                
                <div class="question" data-question="4">
                    <h3>How do you prefer to work?</h3>
                    <div class="answer-options">
                        <div class="answer-option" data-value="team">
                            <i class="fas fa-users"></i>
                            <span>In a Team</span>
                        </div>
                        <div class="answer-option" data-value="individual">
                            <i class="fas fa-user"></i>
                            <span>Independently</span>
                        </div>
                        <div class="answer-option" data-value="leadership">
                            <i class="fas fa-user-tie"></i>
                            <span>Leadership Role</span>
                        </div>
                        <div class="answer-option" data-value="consulting">
                            <i class="fas fa-comments"></i>
                            <span>Advisory Role</span>
                        </div>
                    </div>
                </div>
                
                <div class="question" data-question="5">
                    <h3>What's your ideal work-life balance?</h3>
                    <div class="slider-options">
                        <input type="range" min="1" max="5" value="3" class="preference-slider" id="workLifeBalance">
                        <div class="slider-labels">
                            <span>Work-focused</span>
                            <span>Life-focused</span>
                        </div>
                    </div>
                </div>
                
                <div class="career-results">
                    <h3>Careers That Match Your Profile</h3>
                    <div class="career-recommendations">
                        <div class="career-recommendation">
                            <div class="recommendation-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <h4>Software Developer</h4>
                            <p>Create and maintain computer software, applications, and systems.</p>
                            <span class="match-score">94% Match</span>
                        </div>
                        <div class="career-recommendation">
                            <div class="recommendation-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <h4>Project Manager</h4>
                            <p>Plan, organize, and direct the completion of projects.</p>
                            <span class="match-score">87% Match</span>
                        </div>
                        <div class="career-recommendation">
                            <div class="recommendation-icon">
                                <i class="fas fa-database"></i>
                            </div>
                            <h4>Data Scientist</h4>
                            <p>Analyze complex data to help guide business decisions.</p>
                            <span class="match-score">82% Match</span>
                        </div>
                    </div>
                    <div class="career-actions">
                        <button class="career-btn" id="retakeQuiz">
                            <i class="fas fa-redo"></i>
                            <span>Retake Quiz</span>
                        </button>
                        <button class="career-btn primary" id="exploreMore" onclick="window.location.href='../resources/career-planning.html'">
                            <i class="fas fa-search"></i>
                            <span>Explore More Careers</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="career-buttons">
                <button class="nav-btn" id="prevQuestion" disabled>
                    <i class="fas fa-chevron-left"></i>
                    <span>Previous</span>
                </button>
                <button class="nav-btn" id="nextQuestion">
                    <span>Next</span>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Interactive CTA Section -->
    <section class="cta-section reveal-section">
        <div class="cta-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        <div class="cta-content" data-speed="0.7">
            <h2 class="animate-text">Ready to Find Your Perfect College?</h2>
            <p class="animate-text-delay">Join thousands of students who have found their dream college with Campus Navigator</p>
            <a href="login/login.php" class="cta-button magnetic-button">Get Started For Free</a>
            <div class="floating-notification" data-speed="1.2">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="notification-content">
                    <p>New scholarships added today!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-waves">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#4a6cf7" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
        <div class="footer-container">
            <div class="footer-logo">
                <h2>The<span>Codex</span></h2>
                <p>Your ultimate guide to college planning and success</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <div class="link-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="../collegefinder/index.html">Home</a></li>
                        <li><a href="../collegefinder/navpages/about.html">About Us</a></li>
                        <li><a href="../collegefinder/navpages/college-search.php">Find Colleges</a></li>
                        <li><a href="../collegefinder/navpages/scholarships.php">Scholarships</a></li>
                        <li><a href="../collegefinder/navpages/resources.html">Resources</a></li>
                    </ul>
                </div>
                <div class="link-column">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="../collegefinder/resources/college-advice.html">College Advice</a></li>
                        <li><a href="../collegefinder/resources/application-tips.html">Application Tips</a></li>
                        <li><a href="../collegefinder/resources/financial-aid-guide.html">Financial Aid Guide</a></li>
                        <li><a href="../collegefinder/resources/campus-life.html">Campus Life</a></li>
                        <li><a href="../collegefinder/resources/campus-life.html">Career Planning</a></li>
                    </ul>
                </div>
                <div class="link-column">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                       
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 TheCodex. All rights reserved.</p>
        </div>
    </footer>

    <!-- LottieFiles Player for animations -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- Vanilla Tilt.js for 3D card hover effects -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.2/vanilla-tilt.min.js"></script>
    <!-- Custom Script -->
    <script src="script.js"></script>
    <script>
    // Existing script code

    // Testimonials Carousel Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.testimonial-slide');
        const dots = document.querySelectorAll('.carousel-dots .dot');
        const prevBtn = document.querySelector('.carousel-btn.prev');
        const nextBtn = document.querySelector('.carousel-btn.next');
        let currentSlide = 0;
        
        // Function to show a specific slide
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }
        
        // Event listeners for controls
        prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
        nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
        
        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });
        
        // Auto-advance slides every 5 seconds
        setInterval(() => showSlide(currentSlide + 1), 5000);
        
        // Initialize
        showSlide(0);
    });

    // College Comparison Tool Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Comparison Tool
        const college1 = document.getElementById('college1');
        const college2 = document.getElementById('college2');
        const comparisonChart = document.getElementById('comparisonChart');
        const metrics = document.querySelectorAll('.metric');
        
        // College data (simplified for demo)
        const collegeData = {
            harvard: {
                name: 'Harvard University',
                tuition: 51925,
                acceptance: 4.6,
                enrollment: 21000,
                sat: 1520,
                ranking: 3
            },
            stanford: {
                name: 'Stanford University',
                tuition: 56169,
                acceptance: 4.3,
                enrollment: 17000,
                sat: 1505,
                ranking: 4
            },
            mit: {
                name: 'MIT',
                tuition: 53790,
                acceptance: 6.7,
                enrollment: 11500,
                sat: 1535,
                ranking: 1
            },
            oxford: {
                name: 'University of Oxford',
                tuition: 39000,
                acceptance: 17.5,
                enrollment: 24000,
                sat: 1470,
                ranking: 5
            },
            cambridge: {
                name: 'University of Cambridge',
                tuition: 38000,
                acceptance: 21.0,
                enrollment: 23000,
                sat: 1460,
                ranking: 6
            },
            princeton: {
                name: 'Princeton University',
                tuition: 53890,
                acceptance: 5.8,
                enrollment: 8500,
                sat: 1510,
                ranking: 2
            }
        };
        
        let currentMetric = 'tuition';
        
        // Update comparison chart when colleges are selected
        function updateComparison() {
            const college1Value = college1.value;
            const college2Value = college2.value;
            
            if (college1Value && college2Value) {
                const college1Data = collegeData[college1Value];
                const college2Data = collegeData[college2Value];
                
                // Create comparison chart (simplified - in real app would use Canvas or Chart.js)
                let chartContent = '';
                
                if (currentMetric === 'tuition') {
                    chartContent = `
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: flex-end; height: 300px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${college1Data.tuition / 600}px; width: 100px; background: var(--gradient-1); border-radius: 8px 8px 0 0;"></div>
                                <p>${college1Data.name}</p>
                                <p>$${college1Data.tuition.toLocaleString()}</p>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${college2Data.tuition / 600}px; width: 100px; background: var(--gradient-2); border-radius: 8px 8px 0 0;"></div>
                                <p>${college2Data.name}</p>
                                <p>$${college2Data.tuition.toLocaleString()}</p>
                            </div>
                        </div>
                    `;
                } else if (currentMetric === 'acceptance') {
                    chartContent = `
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: flex-end; height: 300px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${college1Data.acceptance * 10}px; width: 100px; background: var(--gradient-1); border-radius: 8px 8px 0 0;"></div>
                                <p>${college1Data.name}</p>
                                <p>${college1Data.acceptance}%</p>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${college2Data.acceptance * 10}px; width: 100px; background: var(--gradient-2); border-radius: 8px 8px 0 0;"></div>
                                <p>${college2Data.name}</p>
                                <p>${college2Data.acceptance}%</p>
                            </div>
                        </div>
                    `;
                } else if (currentMetric === 'enrollment') {
                    chartContent = `
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: flex-end; height: 300px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${college1Data.enrollment / 100}px; width: 100px; background: var(--gradient-1); border-radius: 8px 8px 0 0;"></div>
                                <p>${college1Data.name}</p>
                                <p>${college1Data.enrollment.toLocaleString()} students</p>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${college2Data.enrollment / 100}px; width: 100px; background: var(--gradient-2); border-radius: 8px 8px 0 0;"></div>
                                <p>${college2Data.name}</p>
                                <p>${college2Data.enrollment.toLocaleString()} students</p>
                            </div>
                        </div>
                    `;
                } else if (currentMetric === 'sat') {
                    chartContent = `
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: flex-end; height: 300px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${(college1Data.sat - 1300) / 1.5}px; width: 100px; background: var(--gradient-1); border-radius: 8px 8px 0 0;"></div>
                                <p>${college1Data.name}</p>
                                <p>${college1Data.sat} avg SAT</p>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${(college2Data.sat - 1300) / 1.5}px; width: 100px; background: var(--gradient-2); border-radius: 8px 8px 0 0;"></div>
                                <p>${college2Data.name}</p>
                                <p>${college2Data.sat} avg SAT</p>
                            </div>
                        </div>
                    `;
                } else if (currentMetric === 'ranking') {
                    chartContent = `
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: flex-end; height: 300px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${(7 - college1Data.ranking) * 40}px; width: 100px; background: var(--gradient-1); border-radius: 8px 8px 0 0;"></div>
                                <p>${college1Data.name}</p>
                                <p>#${college1Data.ranking} World Rank</p>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <div style="height: ${(7 - college2Data.ranking) * 40}px; width: 100px; background: var(--gradient-2); border-radius: 8px 8px 0 0;"></div>
                                <p>${college2Data.name}</p>
                                <p>#${college2Data.ranking} World Rank</p>
                            </div>
                        </div>
                    `;
                }
                
                comparisonChart.innerHTML = chartContent;
            }
        }
        
        college1.addEventListener('change', updateComparison);
        college2.addEventListener('change', updateComparison);
        
        // Metric selection
        metrics.forEach(metric => {
            metric.addEventListener('click', function() {
                metrics.forEach(m => m.classList.remove('active'));
                this.classList.add('active');
                currentMetric = this.dataset.metric;
                updateComparison();
            });
        });
        
        // Campus Tour Scheduler
        const tourOptions = document.querySelectorAll('.tour-option');
        const tourDate = document.getElementById('tourDate');
        const tourTime = document.getElementById('tourTime');
        const guidedAvailability = document.getElementById('guidedAvailability');
        const guidedStatus = document.getElementById('guidedStatus');
        
        // Set minimum date to today
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        tourDate.min = `${yyyy}-${mm}-${dd}`;
        
        // Tour option selection
        tourOptions.forEach(option => {
            option.addEventListener('click', function() {
                tourOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Date change handler
        tourDate.addEventListener('change', function() {
            tourTime.disabled = false;
            tourTime.innerHTML = ''; // Clear existing options
            
            // Random availability simulation
            const availableTimes = [];
            const selectedDate = new Date(this.value);
            const isWeekend = selectedDate.getDay() === 0 || selectedDate.getDay() === 6;
            
            // If weekend, fewer times available
            const startHour = isWeekend ? 10 : 9;
            const endHour = isWeekend ? 15 : 17;
            
            for (let hour = startHour; hour <= endHour; hour++) {
                // Random availability - some slots are taken
                if (Math.random() > 0.3) {
                    const time = hour < 12 ? `${hour}:00 AM` : `${hour === 12 ? 12 : hour - 12}:00 PM`;
                    availableTimes.push(`<option value="${hour}">${time}</option>`);
                }
            }
            
            // Add a default option
            tourTime.innerHTML = '<option value="" selected disabled>Select a time</option>' + availableTimes.join('');
            
            // Update guided tour availability based on date
            const isAvailable = selectedDate.getDay() !== 0; // No guided tours on Sundays
            guidedAvailability.className = `availability-dot ${isAvailable ? 'available' : 'unavailable'}`;
            guidedStatus.textContent = isAvailable ? 'Available' : 'Unavailable on this date';
        });
        
        // Career Path Finder
        const questionWrap = document.querySelector('.career-questions');
        const questions = document.querySelectorAll('.question');
        const answerOptions = document.querySelectorAll('.answer-option');
        const prevBtn = document.getElementById('prevQuestion');
        const nextBtn = document.getElementById('nextQuestion');
        const progressFill = document.querySelector('.career-progress-fill');
        const progressText = document.getElementById('progressText');
        const results = document.querySelector('.career-results');
        const retakeBtn = document.getElementById('retakeQuiz');
        
        let currentQuestion = 1;
        const totalQuestions = questions.length - 1; // -1 because results isn't a question
        const answers = {};
        
        // Update progress
        function updateProgress() {
            const progress = ((currentQuestion - 1) / totalQuestions) * 100;
            progressFill.style.width = `${progress}%`;
            progressText.textContent = `${currentQuestion - 1}/${totalQuestions}`;
            
            // Update button states
            prevBtn.disabled = currentQuestion === 1;
            
            if (currentQuestion > totalQuestions) {
                nextBtn.style.display = 'none';
                results.style.display = 'block';
            } else {
                nextBtn.style.display = 'flex';
                results.style.display = 'none';
            }
        }
        
        // Navigate to question
        function goToQuestion(questionNumber) {
            questions.forEach(q => q.classList.remove('active'));
            const targetQuestion = questionWrap.querySelector(`[data-question="${questionNumber}"]`);
            
            if (targetQuestion) {
                targetQuestion.classList.add('active');
                currentQuestion = questionNumber;
            } else {
                // Show results
                questions.forEach(q => q.classList.remove('active'));
                currentQuestion = totalQuestions + 1;
            }
            
            updateProgress();
        }
        
        // Answer selection
        answerOptions.forEach(option => {
            option.addEventListener('click', function() {
                const questionEl = this.closest('.question');
                const questionNumber = parseInt(questionEl.dataset.question);
                
                questionEl.querySelectorAll('.answer-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                this.classList.add('selected');
                answers[questionNumber] = this.dataset.value;
            });
        });
        
        // Navigation buttons
        prevBtn.addEventListener('click', function() {
            if (currentQuestion > 1) {
                goToQuestion(currentQuestion - 1);
            }
        });
        
        nextBtn.addEventListener('click', function() {
            // For slider questions, we need to manually save the value
            if (currentQuestion === 2) {
                answers[2] = document.getElementById('salaryImportance').value;
            } else if (currentQuestion === 5) {
                answers[5] = document.getElementById('workLifeBalance').value;
            }
            
            // Check if question is answered or is a slider
            const currentQuestionEl = questionWrap.querySelector(`[data-question="${currentQuestion}"]`);
            const isSliderQuestion = currentQuestionEl.querySelector('.preference-slider');
            const isAnswered = answers[currentQuestion] || isSliderQuestion;
            
            if (isAnswered) {
                goToQuestion(currentQuestion + 1);
            } else {
                // Highlight that an answer is needed
                currentQuestionEl.classList.add('needs-answer');
                setTimeout(() => {
                    currentQuestionEl.classList.remove('needs-answer');
                }, 800);
            }
        });
        
        // Retake quiz button
        retakeBtn.addEventListener('click', function() {
            // Reset all selections
            answerOptions.forEach(option => option.classList.remove('selected'));
            document.getElementById('salaryImportance').value = 3;
            document.getElementById('workLifeBalance').value = 3;
            
            // Clear answers
            for (let i = 1; i <= totalQuestions; i++) {
                delete answers[i];
            }
            
            // Go to first question
            goToQuestion(1);
        });
        
        // Initialize
        updateProgress();
    });
    </script>
    
    <!-- AI Assistant Script -->
    <script src="ai-assistant.js"></script>
</body>
</html>
