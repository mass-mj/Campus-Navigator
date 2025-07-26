<?php
// Set page-specific variables
$page_title = "About Us";
$root_path = "../";
$additional_css = ["navpages/resources.css"]; // Temporarily using resources.css, consider creating about.css later
$additional_scripts = ["navpages/about.js"]; // For custom scripts if needed
$additional_head = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<style>
    /* Page-specific styles */
    .about-hero {
        position: relative;
        min-height: 70vh;
        background: linear-gradient(135deg, #c62828 0%, #ff3b3b 100%);
        overflow: hidden;
    }
    
    .about-hero::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: url("../assets/images/pattern-dots.svg");
        opacity: 0.1;
    }
    
    .about-hero .hero-content {
        position: relative;
        z-index: 2;
        max-width: 1000px;
        margin: 0 auto;
        padding: 8rem 2rem;
        text-align: center;
        color: white;
    }
    
    .mission-vision {
        background: #f9f9ff;
        padding: 6rem 0;
    }
    
    .mission-vision-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .mission-card, .vision-card {
        flex: 1 1 500px;
        min-height: 300px;
        padding: 40px;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform 0.4s ease;
    }
    
    .mission-card {
        background: linear-gradient(135deg, #ff5e62, #ff9966);
        color: white;
    }
    
    .vision-card {
        background: linear-gradient(135deg, #3a7bd5, #00d2ff);
        color: white;
    }
    
    .mission-card:hover, .vision-card:hover {
        transform: translateY(-10px);
    }
    
    .mission-card::before, .vision-card::before {
        content: "";
        position: absolute;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        right: -100px;
        bottom: -100px;
    }
    
    .team-section {
        padding: 6rem 0;
        background: white;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 4rem auto 0;
        padding: 0 2rem;
    }
    
    .team-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
    }
    
    .team-image {
        height: 300px;
        overflow: hidden;
        position: relative;
    }
    
    .team-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .team-card:hover .team-image img {
        transform: scale(1.1);
    }
    
    .team-info {
        padding: 25px;
        background: white;
        text-align: center;
    }
    
    .team-social {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.4s ease;
    }
    
    .team-card:hover .team-social {
        opacity: 1;
        transform: translateX(0);
    }
    
    .team-social a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .team-social a:hover {
        background: #4a6cf7;
        color: white;
    }
    
    .journey-section {
        padding: 6rem 0;
        background: #f9f9ff;
    }
    
    .timeline {
        position: relative;
        max-width: 1000px;
        margin: 4rem auto 0;
        padding: 0 2rem;
    }
    
    .timeline::before {
        content: "";
        position: absolute;
        width: 2px;
        background: #4a6cf7;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -1px;
    }
    
    .timeline-item {
        padding: 10px 40px;
        position: relative;
        width: 50%;
        box-sizing: border-box;
    }
    
    .timeline-item:nth-child(odd) {
        left: 0;
    }
    
    .timeline-item:nth-child(even) {
        left: 50%;
    }
    
    .timeline-content {
        padding: 30px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        position: relative;
    }
    
    .timeline-year {
        position: absolute;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #4a6cf7;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        z-index: 1;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .timeline-item:nth-child(odd) .timeline-year {
        right: -30px;
    }
    
    .timeline-item:nth-child(even) .timeline-year {
        left: -30px;
    }
    
    .faq-section {
        padding: 6rem 0;
        background: white;
    }
    
    .faq-container {
        max-width: 1000px;
        margin: 4rem auto 0;
        padding: 0 2rem;
    }
    
    .faq-item {
        margin-bottom: 20px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .faq-question {
        padding: 20px 30px;
        background: #f7f9fc;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .faq-question:hover {
        background: #f0f3fa;
    }
    
    .faq-answer {
        background: white;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-answer-content {
        padding: 0 30px 30px;
    }
    
    .faq-item.active .faq-answer {
        max-height: 300px;
        padding: 20px 0 0;
    }
    
    .faq-item.active .faq-question {
        background: #4a6cf7;
        color: white;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .section-header h2 {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
        font-size: 2.5rem;
    }
    
    .section-header h2::after {
        content: "";
        position: absolute;
        width: 60%;
        height: 3px;
        background: linear-gradient(90deg, #4a6cf7, #6a11cb);
        bottom: -10px;
        left: 20%;
    }
    
    .section-header p {
        max-width: 800px;
        margin: 0 auto;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .timeline::before {
            left: 40px;
        }
        
        .timeline-item {
            width: 100%;
            padding-left: 80px;
            padding-right: 0;
        }
        
        .timeline-item:nth-child(even) {
            left: 0;
        }
        
        .timeline-item:nth-child(odd) .timeline-year,
        .timeline-item:nth-child(even) .timeline-year {
            left: 10px;
        }
    }
</style>
';

// Include header
include_once "../includes/header.php";
?>

<!-- Hero Section -->
<section class="about-hero">
    <div class="hero-content">
        <h1 class="animate-text">About Campus<span>Navigator</span></h1>
        <p class="animate-text-delay">Navigating the path to your academic future with precision and ease</p>
    </div>
    <div class="floating-particles">
        <div class="particle p1"></div>
        <div class="particle p2"></div>
        <div class="particle p3"></div>
        <div class="particle p4"></div>
        <div class="particle p5"></div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission-vision">
    <div class="section-header">
        <h2>Our Purpose</h2>
        <p>Discover what drives us to help students find their perfect educational path</p>
    </div>
    <div class="mission-vision-container">
        <div class="mission-card">
            <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
            <p>To democratize access to quality higher education information, empowering students to make informed decisions about their academic journey regardless of their background or resources.</p>
            <p>We strive to simplify the complex college search process by providing comprehensive, accurate, and personalized guidance to students navigating one of life's most important decisions.</p>
        </div>
        <div class="vision-card">
            <h3><i class="fas fa-eye"></i> Our Vision</h3>
            <p>To become the most trusted global platform for educational guidance, where every student can discover their ideal path to higher education with confidence and clarity.</p>
            <p>We envision a world where geographic, economic, and information barriers no longer limit students' access to transformative educational opportunities.</p>
        </div>
    </div>
</section>

<!-- Our Journey Section -->
<section class="journey-section">
    <div class="section-header">
        <h2>Our Journey</h2>
        <p>The evolution of CampusNavigator from concept to comprehensive college search platform</p>
    </div>
    <div class="timeline">
        <div class="timeline-item">
            <div class="timeline-year">2020</div>
            <div class="timeline-content">
                <h3>The Beginning</h3>
                <p>CampusNavigator began as a simple idea to help local students navigate college admissions, born out of the founder's personal struggles with finding the right college information.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-year">2021</div>
            <div class="timeline-content">
                <h3>National Expansion</h3>
                <p>After successful beta testing with local schools, we expanded our database to include comprehensive information on colleges nationwide.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-year">2022</div>
            <div class="timeline-content">
                <h3>Scholarship Integration</h3>
                <p>We introduced our scholarship search feature, connecting students with financial opportunities to make their education dreams more accessible.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-year">2023</div>
            <div class="timeline-content">
                <h3>International Reach</h3>
                <p>CampusNavigator went global, adding international university options and creating specialized resources for students seeking education abroad.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-year">2024</div>
            <div class="timeline-content">
                <h3>Today & Beyond</h3>
                <p>Today, we continue to innovate with personalized recommendation algorithms and virtual campus tours, helping thousands of students find their perfect educational match.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="section-header">
        <h2>Meet Our Team</h2>
        <p>The passionate experts behind CampusNavigator who are dedicated to transforming educational guidance</p>
    </div>
    <div class="team-grid">
        <div class="team-card">
            <div class="team-image">
                <img src="../assets/images/team-1.jpg" alt="Team Member">
                <div class="team-social">
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            <div class="team-info">
                <h3>Ananya Sharma</h3>
                <p>Founder & CEO</p>
                <p>Former admissions officer with a passion for educational equity</p>
            </div>
        </div>
        
        <div class="team-card">
            <div class="team-image">
                <img src="../assets/images/team-2.jpg" alt="Team Member">
                <div class="team-social">
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            <div class="team-info">
                <h3>Rahul Patel</h3>
                <p>CTO</p>
                <p>Tech innovator developing our advanced matching algorithms</p>
            </div>
        </div>
        
        <div class="team-card">
            <div class="team-image">
                <img src="../assets/images/team-3.jpg" alt="Team Member">
                <div class="team-social">
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            <div class="team-info">
                <h3>Sophie Chen</h3>
                <p>Head of Global Relations</p>
                <p>Expert in international education systems and cross-cultural academics</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="section-header">
        <h2>Frequently Asked Questions</h2>
        <p>Get answers to the most common questions about using CampusNavigator</p>
    </div>
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                How does CampusNavigator help in the college search process?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <p>CampusNavigator simplifies college searching by providing comprehensive information on thousands of colleges, personalized recommendations based on your preferences, advanced filtering tools, scholarship matching, and insights on admission requirements and campus culture—all in one platform.</p>
                </div>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Is CampusNavigator completely free to use?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <p>Yes, CampusNavigator offers its core college search and scholarship matching features completely free of charge. We believe in making educational information accessible to all students regardless of their financial background. We may offer premium features in the future, but our essential tools will always remain free.</p>
                </div>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                How accurate is the information about colleges on your platform?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <p>We maintain the highest standards of accuracy by sourcing information directly from educational institutions, government databases, and verified educational resources. Our dedicated data team updates information regularly and verifies changes to ensure you have access to the most current and reliable college data available.</p>
                </div>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Can international students use CampusNavigator?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <p>Absolutely! CampusNavigator is designed for students worldwide. We provide specialized resources for international students, including visa requirements, English proficiency expectations, international scholarship opportunities, and country-specific admission processes. Our global database includes institutions from across India and around the world.</p>
                </div>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                How do you determine college rankings and recommendations?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-content">
                    <p>Our rankings incorporate multiple factors including academic reputation, faculty credentials, research output, graduation rates, employment outcomes, and student satisfaction. Personalized recommendations are generated using an algorithm that matches your preferences, academic profile, and career goals with institutional strengths and characteristics.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="cta-content">
        <h2>Ready to Find Your Perfect College?</h2>
        <p>Join thousands of students who have found their ideal educational path with CampusNavigator</p>
        <div class="cta-buttons">
            <a href="../navpages/college-search.php" class="btn-primary">Start Searching</a>
            <a href="../login/register.php" class="btn-secondary">Create Account</a>
        </div>
    </div>
</section>

<!-- Include footer -->
<?php include_once "../includes/footer.php"; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation for hero section
        gsap.from('.animate-text', {
            y: 50,
            opacity: 0,
            duration: 1,
            ease: 'power3.out'
        });
        
        gsap.from('.animate-text-delay', {
            y: 50,
            opacity: 0,
            duration: 1,
            delay: 0.3,
            ease: 'power3.out'
        });
        
        // Floating particles animation
        gsap.to('.particle', {
            y: 'random(-100, 100)',
            x: 'random(-100, 100)',
            rotation: 'random(-360, 360)',
            duration: 'random(10, 20)',
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            stagger: 0.5
        });
        
        // Mission & Vision cards animation
        gsap.from('.mission-card, .vision-card', {
            scrollTrigger: {
                trigger: '.mission-vision',
                start: 'top 80%'
            },
            y: 50,
            opacity: 0,
            duration: 1,
            stagger: 0.3,
            ease: 'power3.out'
        });
        
        // Timeline animation
        gsap.from('.timeline-item', {
            scrollTrigger: {
                trigger: '.timeline',
                start: 'top 80%'
            },
            opacity: 0,
            x: index => index % 2 === 0 ? -50 : 50,
            stagger: 0.3,
            duration: 1,
            ease: 'power3.out'
        });
        
        // Team cards animation
        gsap.from('.team-card', {
            scrollTrigger: {
                trigger: '.team-grid',
                start: 'top 80%'
            },
            y: 50,
            opacity: 0,
            stagger: 0.2,
            duration: 1,
            ease: 'power3.out'
        });
        
        // FAQ accordion functionality
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                const isOpen = item.classList.contains('active');
                
                // Close all FAQs
                faqItems.forEach(faq => {
                    faq.classList.remove('active');
                });
                
                // If it wasn't open before, open it
                if (!isOpen) {
                    item.classList.add('active');
                }
            });
        });
    });
</script>
