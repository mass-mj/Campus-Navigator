/**
 * About Page JavaScript
 * Handles animations and interactive elements
 */

document.addEventListener('DOMContentLoaded', () => {
    // Hero animations
    animateHeroElements();
    
    // Animate sections on scroll
    initScrollAnimations();
    
    // Set up FAQ accordion
    setupFaqAccordion();
    
    // Animate floating particles
    animateFloatingParticles();
});

/**
 * Animate hero section elements
 */
function animateHeroElements() {
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
}

/**
 * Initialize scroll-triggered animations
 */
function initScrollAnimations() {
    // Register ScrollTrigger plugin if not registered
    if (gsap.registerPlugin) {
        gsap.registerPlugin(ScrollTrigger);
    }
    
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
        x: (index, target) => {
            // Get the item's index to determine if it's odd or even
            const element = target;
            const isEven = Array.from(document.querySelectorAll('.timeline-item')).indexOf(element) % 2 === 0;
            return isEven ? -50 : 50;
        },
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
    
    // CTA section animation
    gsap.from('.cta-content', {
        scrollTrigger: {
            trigger: '.cta-section',
            start: 'top 80%'
        },
        y: 30,
        opacity: 0,
        duration: 1.2,
        ease: 'power2.out'
    });
    
    // Section headers animation
    gsap.from('.section-header', {
        scrollTrigger: {
            trigger: '.section-header',
            start: 'top 85%',
            toggleActions: 'play none none none'
        },
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: 'power2.out'
    });
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
                
                // Optional: Scroll into view if needed
                /*
                item.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                */
            }
        });
    });
}

/**
 * Animate floating particles in the hero section
 */
function animateFloatingParticles() {
    const particles = document.querySelectorAll('.particle');
    if (!particles.length) return;
    
    // Create a random movement animation for each particle
    particles.forEach((particle, index) => {
        // Set initial random position
        gsap.set(particle, {
            x: Math.random() * 100 - 50,
            y: Math.random() * 100 - 50,
            opacity: Math.random() * 0.5 + 0.3,
            scale: Math.random() * 0.5 + 0.5
        });
        
        // Create continuous random movement
        gsap.to(particle, {
            x: 'random(-100, 100)',
            y: 'random(-100, 100)',
            rotation: 'random(-360, 360)',
            opacity: 'random(0.2, 0.8)',
            duration: 'random(10, 20)',
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: index * 0.2
        });
    });
}

/**
 * Helper function to add parallax effect to elements (optional)
 */
function setupParallaxEffect() {
    const parallaxElements = document.querySelectorAll('.parallax');
    
    if (parallaxElements.length) {
        window.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            
            parallaxElements.forEach(element => {
                const speed = element.getAttribute('data-speed') || 0.1;
                const x = (window.innerWidth - mouseX * speed) / 100;
                const y = (window.innerHeight - mouseY * speed) / 100;
                
                element.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });
    }
} 