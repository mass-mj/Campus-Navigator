<!-- Footer Section -->
<style>
    /* Footer Styles */
    footer {
        position: relative;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #0a3d62, #1e3799);
        color: #fff;
        margin-top: 50px;
    }
    
    .footer-waves {
        position: absolute;
        top: -70px;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        z-index: -1;
    }
    
    .footer-top {
        padding: 70px 0 50px;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .footer-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
    }
    
    .footer-logo {
        flex: 1 1 300px;
    }
    
    .footer-logo h2 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #fff;
    }
    
    .footer-logo span {
        color: #74b9ff;
        font-weight: 700;
    }
    
    .footer-logo p {
        margin-bottom: 20px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .social-icons {
        display: flex;
        gap: 12px;
    }
    
    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        background-color: #74b9ff;
        transform: translateY(-3px);
    }
    
    .footer-links {
        flex: 1 1 500px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .footer-column {
        flex: 1 1 200px;
    }
    
    .footer-column h3 {
        position: relative;
        font-size: 20px;
        margin-bottom: 25px;
        color: #fff;
        padding-bottom: 10px;
    }
    
    .footer-column h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: #74b9ff;
    }
    
    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-column ul li {
        margin-bottom: 12px;
    }
    
    .footer-column ul li a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        position: relative;
        padding-left: 15px;
    }
    
    .footer-column ul li a:before {
        content: "›";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        color: #74b9ff;
        transition: transform 0.3s ease;
    }
    
    .footer-column ul li a:hover {
        color: #74b9ff;
        transform: translateX(5px);
    }
    
    .footer-column ul li a:hover:before {
        transform: translateY(-50%) translateX(3px);
    }
    
    .footer-bottom {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 20px 0;
        text-align: center;
        font-size: 14px;
    }
    
    .footer-bottom p {
        margin: 0;
        color: rgba(255, 255, 255, 0.7);
    }
    
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #1e3799;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 99;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .back-to-top.visible {
        opacity: 1;
    }
    
    .back-to-top:hover {
        background: #74b9ff;
    }
    
    /* Responsive styles */
    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
        }
        
        .footer-links {
            flex-direction: column;
        }
        
        .footer-top {
            padding: 50px 0 30px;
        }
    }
</style>

<footer>
    <div class="footer-waves">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0a3d62" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,266.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
    <div class="footer-top">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>Campus<span>Navigator</span></h2>
                    <p>Your ultimate guide to finding the perfect college match. We help students navigate the complex world of higher education with personalized guidance and comprehensive resources.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h3>Resources</h3>
                        <ul>
                            <li><a href="<?php echo $root_path ?? ''; ?>navpages/college-search.php">College Search</a></li>
                            <li><a href="<?php echo $root_path ?? ''; ?>navpages/scholarships.php">Scholarships</a></li>
                            <li><a href="<?php echo $root_path ?? ''; ?>navpages/resources.html">Resources</a></li>
                            <li><a href="#">Admission Tips</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="<?php echo $root_path ?? ''; ?>navpages/about.php">About Us</a></li>
                            <li><a href="<?php echo $root_path ?? ''; ?>navpages/contact.php">Contact</a></li>
                            <li><a href="<?php echo $root_path ?? ''; ?>privacy/privacy.html">Privacy Policy</a></li>
                            <li><a href="<?php echo $root_path ?? ''; ?>terms/terms.html">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> CampusNavigator. All rights reserved.</p>
    </div>
</footer>

<!-- Back to top button -->
<div class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</div>

<!-- Page Scripts -->
<?php if (isset($additional_scripts) && is_array($additional_scripts)): ?>
    <?php foreach ($additional_scripts as $script): ?>
        <script src="<?php echo $root_path ?? ''; ?><?php echo $script; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Menu Toggle and Footer Scripts -->
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
        if (preloader) {
            preloader.classList.add('loaded');
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 500);
        }
    });
    
    // Back to top button functionality
    const backToTopButton = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });
    
    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Smooth scroll for footer links
    document.querySelectorAll('.footer-column a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Only apply smooth scroll for same-page links
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
</script>
</body>
</html>