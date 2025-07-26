<?php
// Set page-specific variables
$page_title = "Contact Us";
$root_path = "../";
$additional_css = ["navpages/resources.css"]; // Temporarily using resources.css, will create contact.css in future
$additional_scripts = ["navpages/contact.js"];
$additional_head = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lottie-web@5.10.2/build/player/lottie.min.js"></script>
<style>
    /* Page-specific styles */
    .contact-hero {
        position: relative;
        min-height: 50vh;
        background: linear-gradient(45deg, #c62828 , #ff3b3b);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        padding: 2rem;
    }
    
    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        background: linear-gradient(to right, #fff, #ffeaea);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 5px 25px rgba(198,40,40,0.1);
    }
    
    .hero-content p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .contact-content {
        display: flex;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 2rem;
        gap: 50px;
    }
    
    .contact-info {
        flex: 1 1 350px;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .contact-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(255,59,59,0.05);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(255,59,59,0.1);
    }
    
    .contact-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #fff0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ff3b3b;
    }
    
    .contact-card:nth-child(1) .contact-icon {
        background: linear-gradient(135deg, #ff9966, #ff5e62);
        color: white;
    }
    
    .contact-card:nth-child(2) .contact-icon {
        background: linear-gradient(135deg, #ff3b3b, #c62828);
        color: white;
    }
    
    .contact-card:nth-child(3) .contact-icon {
        background: linear-gradient(135deg, #ff6b6b, #ff3b3b);
        color: white;
    }
    
    .contact-details h3 {
        margin-bottom: 5px;
        font-size: 1.2rem;
    }
    
    .contact-details p, .contact-details a {
        color: #c62828;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .contact-details a:hover {
        color: #ff3b3b;
    }
    
    .contact-form-container {
        flex: 1 1 450px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(255,59,59,0.08);
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .contact-form-container::before {
        content: "";
        position: absolute;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(255,59,59,0.1), rgba(198,40,40,0.1));
        border-radius: 50%;
        top: -100px;
        right: -100px;
        z-index: 0;
    }
    
    .contact-form-container::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, rgba(198,40,40,0.1), rgba(255,59,59,0.1));
        border-radius: 50%;
        bottom: -75px;
        left: -75px;
        z-index: 0;
    }
    
    .contact-form {
        position: relative;
        z-index: 1;
    }
    
    .contact-form h2 {
        margin-bottom: 20px;
        font-size: 1.8rem;
        text-align: center;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #c62828;
    }
    
    .form-control {
        width: 100%;
        padding: 15px;
        border: 1px solid #ffd6d6;
        border-radius: 10px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        font-family: "Poppins", sans-serif;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #ff3b3b;
        box-shadow: 0 0 0 3px rgba(255,59,59,0.2);
    }
    
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }
    
    .form-group-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .submit-btn {
        display: block;
        width: 100%;
        padding: 15px;
        background: linear-gradient(45deg, #ff3b3b, #c62828);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 5px 15px rgba(255,59,59,0.3);
    }
    
    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255,59,59,0.4);
    }
    
    .submit-btn:active {
        transform: translateY(0);
        box-shadow: 0 3px 10px rgba(255,59,59,0.3);
    }
    
    .form-success, .form-error {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
    }
    
    .form-success {
        background: rgba(46, 204, 113, 0.1);
        border: 1px solid rgba(46, 204, 113, 0.3);
        color: #27ae60;
    }
    
    .form-error {
        background: rgba(231, 76, 60, 0.1);
        border: 1px solid rgba(231, 76, 60, 0.3);
        color: #e74c3c;
    }
    
    .map-section {
        padding: 5rem 0;
        background: #fff0f0;
    }
    
    .map-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 3rem;
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
        background: linear-gradient(90deg, #ff3b3b, #c62828);
        bottom: -10px;
        left: 20%;
    }
    
    .map-wrapper {
        height: 450px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(255,59,59,0.08);
    }
    
    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    .faq-section {
        padding: 5rem 0;
        background: white;
    }
    
    .faq-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .faq-item {
        margin-bottom: 15px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(255,59,59,0.05);
    }
    
    .faq-question {
        padding: 20px;
        background: #fff0f0;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .faq-answer {
        padding: 0 20px;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-item.active .faq-answer {
        padding: 20px;
        max-height: 300px;
    }
    
    .faq-item.active .faq-question {
        background: #ff3b3b;
        color: white;
    }
    
    .scene-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    .success-animation {
        display: none;
        width: 100%;
        height: 200px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .form-group-grid {
            grid-template-columns: 1fr;
        }
        
        .contact-card {
            flex-direction: column;
            text-align: center;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
    }
</style>
';

// Include header
include_once "../includes/header.php";

// Process form submission if POST request
$formSubmitted = false;
$formError = false;
$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $phone = $_POST['phone'] ?? '';
    
    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $formError = true;
        $errorMessage = 'Please fill in all required fields (name, email, message).';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formError = true;
        $errorMessage = 'Please enter a valid email address.';
    } else {
        // Form is valid, process submission
        
        // Connect to database
        require_once '../config/db_connect.php';
        
        // Prepare and execute the SQL query
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        if ($stmt) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $ip);
            
            if ($stmt->execute()) {
                $formSubmitted = true;
                $successMessage = 'Thank you for your message! We will get back to you as soon as possible.';
                
                // Clear form data after successful submission
                $name = $email = $subject = $message = $phone = '';
            } else {
                $formError = true;
                $errorMessage = 'Sorry, there was an error sending your message. Please try again later.';
            }
            
            $stmt->close();
        } else {
            $formError = true;
            $errorMessage = 'Database connection error. Please try again later.';
        }
    }
}
?>

<!-- Hero Section -->
<section class="contact-hero">
    <div class="scene-container" id="scene-container"></div>
    <div class="hero-content">
        <h1>Get in Touch</h1>
        <p>Have questions about finding your perfect college or using our platform? We're here to help you navigate your educational journey.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-content">
    <div class="contact-info">
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="contact-details">
                <h3>Our Location</h3>
                <p>123 Education Avenue, Bangalore <br>Karnataka, India - 560001</p>
            </div>
        </div>
        
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="contact-details">
                <h3>Email Us</h3>
                <p><a href="mailto:support@campusnavigator.com">support@campusnavigator.com</a></p>
                <p><a href="mailto:info@campusnavigator.com">info@campusnavigator.com</a></p>
            </div>
        </div>
        
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div class="contact-details">
                <h3>Call Us</h3>
                <p><a href="tel:+919876543210">+91 9876 543 210</a></p>
                <p><a href="tel:+918765432109">+91 8765 432 109</a></p>
            </div>
        </div>
        
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="contact-details">
                <h3>Working Hours</h3>
                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                <p>Saturday: 10:00 AM - 2:00 PM</p>
            </div>
        </div>
    </div>
    
    <div class="contact-form-container">
        <form class="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2>Send Us a Message</h2>
            
            <?php if ($formSubmitted): ?>
                <div class="form-success" style="display: block;">
                    <?php echo $successMessage; ?>
                </div>
                <div class="success-animation" id="successAnimation"></div>
            <?php endif; ?>
            
            <?php if ($formError): ?>
                <div class="form-error" style="display: block;">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group-grid">
                <div class="form-group">
                    <label for="name">Your Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Your Email *</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
            </div>
            
            <div class="form-group-grid">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="message">Your Message *</label>
                <textarea id="message" name="message" class="form-control" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
            </div>
            
            <button type="submit" class="submit-btn">
                <span>Send Message</span>
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="section-header">
        <h2>Find Us</h2>
        <p>Visit our office or attend one of our information sessions</p>
    </div>
    <div class="map-container">
        <div class="map-wrapper">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d248849.84916296526!2d77.6309395!3d12.9539974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670c9b44e6d%3A0xf8dfc3e8517e4fe0!2sBengaluru%2C%20Karnataka!5e0!3m2!1sen!2sin!4v1648717687024!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="section-header">
        <h2>Frequently Asked Questions</h2>
        <p>Quick answers to questions we often receive</p>
    </div>
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                How quickly will I receive a response to my inquiry?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>We typically respond to all inquiries within 24-48 business hours. For urgent matters, we recommend calling our support line directly.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Can I schedule a one-on-one consultation about my college options?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes! We offer personalized consultations with our education advisors. You can request a meeting through this contact form or by calling our office directly. Virtual and in-person options are available.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                I found incorrect information about a college. How can I report it?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>We appreciate your help in maintaining accurate information. Please use this contact form and select "Report Inaccurate Information" as the subject. Include the college name, the specific information that needs correction, and a source for verification if possible.</p>
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Does CampusNavigator offer affiliate programs for educational consultants?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes, we have partnership programs for educational consultants, schools, and organizations. Please contact our partnerships team at partners@campusnavigator.com for more information about our collaboration opportunities.</p>
            </div>
        </div>
    </div>
</section>

<!-- Include footer -->
<?php include_once "../includes/footer.php"; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Three.js background
        const container = document.getElementById('scene-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);
        
        // Create particles
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 1000;
        const posArray = new Float32Array(particlesCount * 3);
        
        for(let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 10;
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.02,
            color: 0xffffff,
            transparent: true,
            opacity: 0.8
        });
        
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        
        camera.position.z = 5;
        
        // Animation
        function animate() {
            requestAnimationFrame(animate);
            particlesMesh.rotation.x += 0.0005;
            particlesMesh.rotation.y += 0.0005;
            renderer.render(scene, camera);
        }
        
        animate();
        
        // Handle window resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        // Form submission success animation
        const successAnimation = document.getElementById('successAnimation');
        if (successAnimation && <?php echo $formSubmitted ? 'true' : 'false'; ?>) {
            successAnimation.style.display = 'block';
            
            const animation = lottie.loadAnimation({
                container: successAnimation,
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: 'https://assets5.lottiefiles.com/packages/lf20_s2lryxtd.json'
            });
        }
        
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
        
        // Form validation visual feedback
        const formInputs = document.querySelectorAll('.form-control');
        
        formInputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (input.value.trim() !== '') {
                    input.style.borderColor = '#ff3b3b';
                } else if (input.hasAttribute('required')) {
                    input.style.borderColor = '#e74c3c';
                }
            });
            
            input.addEventListener('focus', () => {
                input.style.borderColor = '#ff3b3b';
            });
        });
    });
</script>
