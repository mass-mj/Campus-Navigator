<?php
// Basic error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Campus Navigator</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <!-- Particles.js for background effects -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- Tilt.js for 3D tilt effect -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
</head>
<body>
    <!-- Navigation - Basic version -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php">
                    <h1>Campus<span>Navigator</span></h1>
                </a>
            </div>
            <div class="nav-links" id="navLinks">
                <i class="fas fa-times close-menu" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../navpages/about.php">About</a></li>
                    <li><a href="../navpages/college-search.php">Find Colleges</a></li>
                    <li><a href="../navpages/scholarships.php">Scholarships</a></li>
                    <li><a href="../navpages/resources.php">Resources</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="menu-btn">
                <i class="fas fa-bars" onclick="showMenu()"></i>
            </div>
            <div class="cta-buttons">
                <a href="login.php" class="login-btn magnetic-button">Log In</a>
                <a href="register.php" class="signup-btn magnetic-button">Sign Up</a>
            </div>
        </nav>
    </header>

    <!-- Login Section -->
    <div class="neo-login-container">
        <div class="animated-background">
            <div class="shape shape1"></div>
            <div class="shape shape2"></div>
            <div class="shape shape3"></div>
            <div class="shape shape4"></div>
            <div id="particles-js"></div>
        </div>
        
        <div class="glass-effect-container">
            <div class="glass-card" data-tilt data-tilt-max="5" data-tilt-glare data-tilt-max-glare="0.1">
                <div class="glass-card-content">
                    <div class="login-header">
                        <div class="login-logo">
                            <div class="logo-animation">
                                <div class="logo-circle"></div>
                                <div class="logo-cap">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                            </div>
                        </div>
                        <h2>Welcome Back</h2>
                        <p>Continue your educational journey</p>
                    </div>
                    
                    <form class="login-form" action="login_process.php" method="POST">
                        <div class="form-group glass-input">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required>
                            <div class="focus-effect"></div>
                        </div>
                        
                        <div class="form-group glass-input">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="focus-effect"></div>
                        </div>
                        
                        <div class="form-options">
                            <div class="remember-me">
                                <label class="custom-checkbox">
                                    <input type="checkbox" id="remember" name="remember">
                                    <span class="checkmark"></span>
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="forgot-password">Forgot password?</a>
                        </div>
                        
                        <button type="submit" class="neo-button">
                            <span class="button-text">Sign In</span>
                            <span class="button-icon"><i class="fas fa-arrow-right"></i></span>
                        </button>
                        
                        <div class="social-login-divider">
                            <span>Or continue with</span>
                        </div>
                        
                        <div class="social-login-buttons">
                            <button type="button" class="social-btn google" data-tilt data-tilt-scale="1.05">
                                <i class="fab fa-google"></i>
                            </button>
                            <button type="button" class="social-btn facebook" data-tilt data-tilt-scale="1.05">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="social-btn apple" data-tilt data-tilt-scale="1.05">
                                <i class="fab fa-apple"></i>
                            </button>
                        </div>
                    </form>
                    
                    <div class="register-prompt">
                        <p>Don't have an account? <a href="register.php" class="register-link">Sign Up <i class="fas fa-user-plus"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="education-floating-elements">
            <div class="edu-icon book" data-tilt data-tilt-max="25">
                <i class="fas fa-book"></i>
            </div>
            <div class="edu-icon pencil" data-tilt data-tilt-max="25">
                <i class="fas fa-pencil-alt"></i>
            </div>
            <div class="edu-icon lightbulb" data-tilt data-tilt-max="25">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="edu-icon university" data-tilt data-tilt-max="25">
                <i class="fas fa-university"></i>
            </div>
            <div class="edu-icon atom" data-tilt data-tilt-max="25">
                <i class="fas fa-atom"></i>
            </div>
        </div>
    </div>

    <!-- Dynamic Education Stats -->
    <div class="floating-stats">
        <div class="stat-card" data-tilt data-tilt-max="10">
            <div class="stat-number"><span class="counter" data-target="4000">0</span>+</div>
            <div class="stat-label">Colleges</div>
        </div>
        <div class="stat-card" data-tilt data-tilt-max="10">
            <div class="stat-number">$<span class="counter" data-target="400">0</span>B+</div>
            <div class="stat-label">Scholarships</div>
        </div>
        <div class="stat-card" data-tilt data-tilt-max="10">
            <div class="stat-number"><span class="counter" data-target="96">0</span>%</div>
            <div class="stat-label">Success Rate</div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu
        function showMenu() {
            document.getElementById('navLinks').classList.add('active');
        }

        function hideMenu() {
            document.getElementById('navLinks').classList.remove('active');
        }
        
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Initialize VanillaTilt for 3D effects
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tilt effect if the library is loaded
            if (typeof VanillaTilt !== 'undefined') {
                VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
                    max: 5,
                    speed: 400,
                    glare: true,
                    "max-glare": 0.2,
                });
            }
            
            // Initialize particles.js if the library is loaded
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    particles: {
                        number: { value: 80 },
                        color: { value: ["#ff3b3b", "#c62828", "#ff6b6b"] },
                        shape: { type: ["circle", "triangle"] },
                        opacity: { value: 0.2, random: true },
                        size: { value: 5, random: true },
                        line_linked: { enable: true, distance: 150, color: "#ff3b3b" },
                        move: { enable: true, speed: 1 }
                    }
                });
            }

            // Initialize GSAP animations if the library is loaded
            if (typeof gsap !== 'undefined') {
                // Form animations
                const formControls = document.querySelectorAll('.form-control');
                formControls.forEach(control => {
                    control.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });
                    
                    control.addEventListener('blur', function() {
                        if (this.value === '') {
                            this.parentElement.classList.remove('focused');
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
