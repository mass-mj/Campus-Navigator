<?php
// Set page-specific variables
$page_title = "Sign Up";
$root_path = "../";
$additional_css = ["login/login-style.css"];
$additional_head = '
<!-- GSAP for animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<!-- Particles.js for background effects -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<!-- Tilt.js for 3D tilt effect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
';

// Debug - add error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if header exists and include it
$header_path = "../includes/header.php";
if (file_exists($header_path)) {
    include_once $header_path;
} else {
    // Log error to a file instead of showing to users in production
    error_log("Header file not found at path: " . $header_path);
    
    // Fallback HTML structure if header is missing
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$page_title.' | Campus Navigator</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="login-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        '.$additional_head.'
    </head>
    <body>';
}
?>

    <!-- Register Section -->
    <div class="neo-register-container">
        <div class="animated-background">
            <div class="shape shape1"></div>
            <div class="shape shape2"></div>
            <div class="shape shape3"></div>
            <div class="shape shape4"></div>
            <div id="particles-js"></div>
        </div>
        
        <div class="glass-effect-container">
            <div class="glass-register-card" data-tilt data-tilt-max="5" data-tilt-glare data-tilt-max-glare="0.1">
                <div class="glass-card-content">
                    <div class="register-header">
                        <div class="register-logo">
                            <div class="orbit-rings">
                                <div class="ring ring1"></div>
                                <div class="ring ring2"></div>
                                <div class="ring ring3"></div>
                                <div class="planet">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                        </div>
                        <h2>Start Your Journey</h2>
                        <p>Create an account to unlock personalized education tools</p>
                    </div>
                    
                    <form class="register-form" action="register_process.php" method="POST">
                        <div class="form-group glass-input">
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                            <div class="focus-effect"></div>
                        </div>
                        
                        <div class="form-group glass-input">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
                            <div class="focus-effect"></div>
                        </div>
                        
                        <div class="form-group glass-input">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Create Password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="focus-effect"></div>
                        </div>
                        
                        <div class="form-group glass-input">
                            <div class="input-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="focus-effect"></div>
                        </div>
                        
                        <div class="education-interest">
                            <h4>I'm interested in</h4>
                            <div class="neo-interest-options">
                                <div class="interest-option">
                                    <input type="radio" id="highschool" name="education-level" value="highschool">
                                    <label for="highschool" data-tilt data-tilt-scale="1.05">
                                        <span class="interest-icon"><i class="fas fa-school"></i></span>
                                        <span class="interest-text">High School</span>
                                    </label>
                                </div>
                                <div class="interest-option">
                                    <input type="radio" id="undergraduate" name="education-level" value="undergraduate" checked>
                                    <label for="undergraduate" data-tilt data-tilt-scale="1.05">
                                        <span class="interest-icon"><i class="fas fa-university"></i></span>
                                        <span class="interest-text">Undergraduate</span>
                                    </label>
                                </div>
                                <div class="interest-option">
                                    <input type="radio" id="graduate" name="education-level" value="graduate">
                                    <label for="graduate" data-tilt data-tilt-scale="1.05">
                                        <span class="interest-icon"><i class="fas fa-user-graduate"></i></span>
                                        <span class="interest-text">Graduate</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-agreement">
                            <label class="custom-checkbox">
                                <input type="checkbox" id="terms" name="terms" required>
                                <span class="checkmark"></span>
                                I agree to the <a href="../terms/terms.html">Terms of Service</a> and <a href="../privacy/privacy.html">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="neo-button register-button">
                            <span class="button-text">Create Account</span>
                            <span class="button-icon"><i class="fas fa-arrow-right"></i></span>
                        </button>
                        
                        <div class="social-login-divider">
                            <span>Or sign up with</span>
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
                    
                    <div class="login-prompt">
                        <p>Already have an account? <a href="login.php" class="login-link">Sign In <i class="fas fa-sign-in-alt"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="register-journey">
            <div class="journey-step" data-tilt data-tilt-max="10">
                <div class="step-number">1</div>
                <div class="step-icon"><i class="fas fa-user-plus"></i></div>
                <h3>Create Profile</h3>
                <p>Sign up and build your unique academic profile</p>
            </div>
            <div class="journey-line"></div>
            <div class="journey-step" data-tilt data-tilt-max="10">
                <div class="step-number">2</div>
                <div class="step-icon"><i class="fas fa-search"></i></div>
                <h3>Discover Colleges</h3>
                <p>Find institutions that match your preferences</p>
            </div>
            <div class="journey-line"></div>
            <div class="journey-step" data-tilt data-tilt-max="10">
                <div class="step-number">3</div>
                <div class="step-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Begin Your Future</h3>
                <p>Apply with confidence and track your progress</p>
            </div>
        </div>
    </div>

    <!-- Floating Education Items -->
    <div class="floating-edu-items">
        <div class="edu-item certificate" data-tilt data-tilt-max="15">
            <i class="fas fa-certificate"></i>
        </div>
        <div class="edu-item compass" data-tilt data-tilt-max="15">
            <i class="fas fa-compass"></i>
        </div>
        <div class="edu-item globe" data-tilt data-tilt-max="15">
            <i class="fas fa-globe-americas"></i>
        </div>
        <div class="edu-item calculator" data-tilt data-tilt-max="15">
            <i class="fas fa-calculator"></i>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = passwordInput.nextElementSibling.querySelector('i');
            
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
            // Initialize tilt effect
            VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
                max: 5,
                speed: 400,
                glare: true,
                "max-glare": 0.2,
            });
            
            // Initialize particles.js
            particlesJS('particles-js', {
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: ["#FF6B6B", "#6941c6", "#4a6cf7"]
                    },
                    shape: {
                        type: ["circle", "triangle", "polygon"],
                        stroke: {
                            width: 0,
                            color: "#000000"
                        },
                        polygon: {
                            nb_sides: 6
                        }
                    },
                    opacity: {
                        value: 0.2,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 0.5,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 5,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 1,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#FF6B6B",
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: "none",
                        random: true,
                        straight: false,
                        out_mode: "out",
                        bounce: false,
                        attract: {
                            enable: true,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "repulse"
                        },
                        onclick: {
                            enable: true,
                            mode: "push"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 140,
                            line_linked: {
                                opacity: 1
                            }
                        },
                        repulse: {
                            distance: 100,
                            duration: 0.4
                        },
                        push: {
                            particles_nb: 4
                        }
                    }
                },
                retina_detect: true
            });
            
            // Animations for orbit rings
            gsap.to('.ring1', {
                rotation: 360,
                duration: 30,
                repeat: -1,
                ease: "none"
            });
            
            gsap.to('.ring2', {
                rotation: -360,
                duration: 20,
                repeat: -1,
                ease: "none"
            });
            
            gsap.to('.ring3', {
                rotation: 360,
                duration: 40,
                repeat: -1,
                ease: "none"
            });
            
            gsap.to('.planet', {
                y: -5,
                duration: 2,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
            
            // Floating education items animation
            const eduItems = document.querySelectorAll('.edu-item');
            eduItems.forEach((item, index) => {
                gsap.to(item, {
                    y: `random(-30, 30)`,
                    x: `random(-20, 20)`,
                    rotation: `random(-15, 15)`,
                    duration: 3 + index * 0.3,
                    repeat: -1,
                    yoyo: true,
                    ease: "sine.inOut",
                    delay: index * 0.2
                });
            });
            
            // Journey line animation
            const journeyLines = document.querySelectorAll('.journey-line');
            journeyLines.forEach((line) => {
                gsap.from(line, {
                    width: 0,
                    duration: 1.5,
                    ease: "power2.inOut",
                    scrollTrigger: {
                        trigger: line,
                        start: "top 80%",
                        end: "bottom 20%",
                        toggleActions: "play none none none"
                    }
                });
            });
            
            // Journey steps animation
            const journeySteps = document.querySelectorAll('.journey-step');
            journeySteps.forEach((step, index) => {
                gsap.from(step, {
                    opacity: 0,
                    y: 30,
                    duration: 0.8,
                    delay: 0.3 + index * 0.4,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: step,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            });
            
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
            
            // Background shapes animation
            gsap.to('.shape1', {
                x: 'random(-100, 100)',
                y: 'random(-100, 100)',
                rotation: 'random(-180, 180)',
                duration: 20,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
            
            gsap.to('.shape2', {
                x: 'random(-150, 150)',
                y: 'random(-150, 150)',
                rotation: 'random(-180, 180)',
                duration: 25,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
            
            gsap.to('.shape3', {
                x: 'random(-120, 120)',
                y: 'random(-120, 120)',
                rotation: 'random(-180, 180)',
                duration: 22,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
            
            gsap.to('.shape4', {
                x: 'random(-80, 80)',
                y: 'random(-80, 80)',
                rotation: 'random(-180, 180)',
                duration: 18,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
            
            // Mouse follower effect
            const glassBg = document.querySelector('.animated-background');
            document.addEventListener('mousemove', (e) => {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                
                glassBg.style.background = `radial-gradient(circle at ${x * 100}% ${y * 100}%, rgba(255, 107, 107, 0.3), rgba(105, 65, 198, 0.2), rgba(74, 108, 247, 0.1), transparent)`;
            });
        });
    </script>
<?php
// Make sure to properly close the PHP file
if (!file_exists($header_path)) {
    echo '</body></html>';
}

// If the header file exists, it may already include the closing body and html tags
// Include footer if needed
$footer_path = "../includes/footer.php";
if (file_exists($footer_path)) {
    include_once $footer_path;
}
?>
