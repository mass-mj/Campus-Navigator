/**
 * Contact Page JavaScript
 * Handles form validation and interactive elements
 */

document.addEventListener('DOMContentLoaded', () => {
    // Initialize Three.js background
    initializeParticleBackground();
    
    // Set up FAQ accordion
    setupFaqAccordion();
    
    // Form validation
    setupFormValidation();
    
    // Success animation if needed
    setupSuccessAnimation();
});

/**
 * Initialize the 3D particle background using Three.js
 */
function initializeParticleBackground() {
    const container = document.getElementById('scene-container');
    if (!container) return;
    
    try {
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
    } catch (error) {
        console.error("Error initializing Three.js background:", error);
    }
}

/**
 * Set up the FAQ accordion functionality
 */
function setupFaqAccordion() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        if (!question) return;
        
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
}

/**
 * Set up form validation
 */
function setupFormValidation() {
    const form = document.querySelector('.contact-form');
    if (!form) return;
    
    const formInputs = form.querySelectorAll('.form-control');
    
    // Visual feedback on input fields
    formInputs.forEach(input => {
        input.addEventListener('blur', () => {
            if (input.value.trim() !== '') {
                input.style.borderColor = '#4a6cf7';
            } else if (input.hasAttribute('required')) {
                input.style.borderColor = '#e74c3c';
            }
        });
        
        input.addEventListener('focus', () => {
            input.style.borderColor = '#4a6cf7';
        });
    });
    
    // Add form submission handling if needed
    form.addEventListener('submit', (e) => {
        // Client-side validation can be added here if needed
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = '#e74c3c';
            }
        });
        
        // If using AJAX submission instead of regular form submission, uncomment below
        /*
        if (isValid) {
            e.preventDefault();
            submitFormViaAjax(form);
        }
        */
    });
}

/**
 * Set up success animation using Lottie
 */
function setupSuccessAnimation() {
    const successElement = document.getElementById('successAnimation');
    if (!successElement || successElement.style.display !== 'block') return;
    
    try {
        lottie.loadAnimation({
            container: successElement,
            renderer: 'svg',
            loop: false,
            autoplay: true,
            path: 'https://assets5.lottiefiles.com/packages/lf20_s2lryxtd.json'
        });
    } catch (error) {
        console.error("Error loading success animation:", error);
    }
}

/**
 * Example function for AJAX form submission (not used by default)
 */
function submitFormViaAjax(form) {
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const successMessage = document.querySelector('.form-success');
            if (successMessage) {
                successMessage.style.display = 'block';
                setupSuccessAnimation();
            }
            
            // Clear form
            form.reset();
        } else {
            // Show error message
            const errorMessage = document.querySelector('.form-error');
            if (errorMessage) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = data.message || 'Something went wrong. Please try again.';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error message
        const errorMessage = document.querySelector('.form-error');
        if (errorMessage) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Connection error. Please try again later.';
        }
    });
} 