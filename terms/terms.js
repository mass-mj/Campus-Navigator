// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation
    const menuBtn = document.querySelector('.menu-btn');
    const navLinks = document.querySelector('.nav-links');
    const closeMenu = document.querySelector('.close-menu');
    
    if (menuBtn && navLinks && closeMenu) {
        menuBtn.addEventListener('click', function() {
            navLinks.classList.add('active');
        });
        
        closeMenu.addEventListener('click', function() {
            navLinks.classList.remove('active');
        });
    }
    
    // Initialize all functionality
    initScrollAnimation();
    initTermsNav();
    initScrollToTop();
});

// Animate on scroll
function initScrollAnimation() {
    // Get all terms sections
    const sections = document.querySelectorAll('.terms-section');
    
    // Create intersection observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                // Update active nav item
                updateActiveNavItem(entry.target.id);
            }
        });
    }, {
        root: null,
        threshold: 0.1,
        rootMargin: "-100px 0px"
    });
    
    // Apply initial styles and observe each section
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
}

// Update active nav item based on visible section
function updateActiveNavItem(sectionId) {
    // Get all nav links
    const navLinks = document.querySelectorAll('.terms-nav ul li a');
    
    // Remove active class from all links
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    // Add active class to current section link
    const activeLink = document.querySelector(`.terms-nav ul li a[href="#${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

// Initialize terms navigation
function initTermsNav() {
    const navLinks = document.querySelectorAll('.terms-nav ul li a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get target section
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            
            if (targetSection) {
                // Get position of the target section
                const termsNav = document.querySelector('.terms-nav');
                const termsNavHeight = termsNav ? termsNav.offsetHeight : 0;
                const navbarHeight = 70; // Fixed navbar height
                
                const targetPosition = targetSection.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = targetPosition - navbarHeight - termsNavHeight;
                
                // Smooth scroll to target
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Update URL hash without scrolling
                history.pushState(null, null, `#${targetId}`);
                
                // Update active nav item
                updateActiveNavItem(targetId);
            }
        });
    });
    
    // Handle initial hash in URL
    if (window.location.hash) {
        const initialId = window.location.hash.substring(1);
        const initialSection = document.getElementById(initialId);
        
        if (initialSection) {
            // Small delay to ensure page is fully loaded
            setTimeout(() => {
                // Get position of the target section
                const termsNav = document.querySelector('.terms-nav');
                const termsNavHeight = termsNav ? termsNav.offsetHeight : 0;
                const navbarHeight = 70; // Fixed navbar height
                
                const targetPosition = initialSection.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = targetPosition - navbarHeight - termsNavHeight;
                
                // Smooth scroll to target
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Update active nav item
                updateActiveNavItem(initialId);
            }, 300);
        }
    }
    
    // Handle scroll events to update active nav item
    window.addEventListener('scroll', function() {
        // Get all terms sections
        const sections = document.querySelectorAll('.terms-section');
        
        // Determine which section is in view
        let currentSection = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            
            // Adjust for sticky nav
            const scrollPosition = window.scrollY + 200;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentSection = section.getAttribute('id');
            }
        });
        
        // Update active nav item
        if (currentSection) {
            updateActiveNavItem(currentSection);
        }
    });
}

// Initialize scroll to top button
function initScrollToTop() {
    const scrollTopBtn = document.querySelector('.scroll-top');
    
    if (scrollTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('active');
            } else {
                scrollTopBtn.classList.remove('active');
            }
        });
        
        // Smooth scroll to top when clicked
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Create a typewriter effect for the hero title
function typeWriter(element, text, speed = 100) {
    let i = 0;
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    // Clear element and start typing
    element.innerHTML = '';
    type();
}

// Add dynamic paragraph numbering
function addParagraphNumbers() {
    const sections = document.querySelectorAll('.terms-section');
    
    sections.forEach((section, sectionIndex) => {
        const paragraphs = section.querySelectorAll('p:not(.no-number)');
        
        paragraphs.forEach((paragraph, paragraphIndex) => {
            // Create span for paragraph number
            const numberSpan = document.createElement('span');
            numberSpan.classList.add('paragraph-number');
            numberSpan.textContent = `${sectionIndex + 1}.${paragraphIndex + 1} `;
            
            // Insert number at beginning of paragraph
            paragraph.insertBefore(numberSpan, paragraph.firstChild);
        });
    });
}

// Print terms functionality
function printTerms() {
    const printBtn = document.querySelector('.print-terms');
    
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
    }
}

// Add floating decoration elements to terms hero
function addHeroDecorations() {
    const termsHero = document.querySelector('.terms-hero');
    
    if (termsHero) {
        // Create decorative elements
        for (let i = 0; i < 20; i++) {
            const decoration = document.createElement('div');
            decoration.classList.add('hero-decoration');
            
            // Random position
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            
            // Random size
            const size = Math.random() * 20 + 5;
            
            // Random rotation
            const rotation = Math.random() * 360;
            
            // Random opacity
            const opacity = Math.random() * 0.5 + 0.1;
            
            // Set styles
            decoration.style.left = `${posX}%`;
            decoration.style.top = `${posY}%`;
            decoration.style.width = `${size}px`;
            decoration.style.height = `${size}px`;
            decoration.style.transform = `rotate(${rotation}deg)`;
            decoration.style.opacity = opacity;
            
            // Random shape (square or circle)
            if (Math.random() > 0.5) {
                decoration.style.borderRadius = '50%';
            }
            
            // Random color
            const colors = ['#4a6cf7', '#6c63ff', '#ff6584', '#ff8f6b'];
            const colorIndex = Math.floor(Math.random() * colors.length);
            decoration.style.backgroundColor = colors[colorIndex];
            
            // Append to hero
            termsHero.appendChild(decoration);
        }
    }
} 