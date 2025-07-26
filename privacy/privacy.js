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
    initParticles();
    initScrollTrigger();
    initPrivacyNav();
    initScrollToTop();
    initCookieControls();
    initPrintControls();
    initRightsAnimation();
});

// Create particles background
function initParticles() {
    const particlesContainer = document.querySelector('.privacy-particles');
    
    if (particlesContainer) {
        // Create particles
        for (let i = 0; i < 50; i++) {
            createParticle(particlesContainer);
        }
    }
}

// Create individual particle
function createParticle(container) {
    const particle = document.createElement('div');
    particle.classList.add('particle');
    
    // Random size between 3px and 8px
    const size = Math.random() * 5 + 3;
    particle.style.width = `${size}px`;
    particle.style.height = `${size}px`;
    
    // Random position
    const posX = Math.random() * 100;
    const posY = Math.random() * 100;
    particle.style.left = `${posX}%`;
    particle.style.top = `${posY}%`;
    
    // Random opacity
    particle.style.opacity = Math.random() * 0.5 + 0.1;
    
    // Random color
    const colors = [
        'rgba(74, 108, 247, 0.6)', // primary
        'rgba(108, 99, 255, 0.6)', // secondary
        'rgba(0, 200, 255, 0.6)'   // accent
    ];
    const colorIndex = Math.floor(Math.random() * colors.length);
    particle.style.backgroundColor = colors[colorIndex];
    
    // Random float animation
    const floatDuration = Math.random() * 20 + 10;
    const floatDelay = Math.random() * 5;
    particle.style.animation = `float ${floatDuration}s ease-in-out ${floatDelay}s infinite`;
    
    // Add particle to container
    container.appendChild(particle);
    
    // Add subtle movement on mousemove
    document.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        const moveX = (mouseX - 0.5) * 20;
        const moveY = (mouseY - 0.5) * 20;
        
        particle.style.transform = `translate(${moveX * (Math.random() + 0.5)}px, ${moveY * (Math.random() + 0.5)}px)`;
    });
}

// Animate elements on scroll
function initScrollTrigger() {
    // Get all privacy sections
    const sections = document.querySelectorAll('.privacy-section');
    
    // Create intersection observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                // Animate icon to spin
                const icon = entry.target.querySelector('.section-icon');
                if (icon) {
                    icon.style.animation = 'spin 1s ease';
                }
                
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
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(section);
    });
}

// Update active nav item based on visible section
function updateActiveNavItem(sectionId) {
    // Get all nav links
    const navLinks = document.querySelectorAll('.privacy-nav ul li a');
    
    // Remove active class from all links
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    // Add active class to current section link
    const activeLink = document.querySelector(`.privacy-nav ul li a[href="#${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

// Initialize privacy navigation
function initPrivacyNav() {
    const navLinks = document.querySelectorAll('.privacy-nav ul li a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get target section
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            
            if (targetSection) {
                // Get position of the target section
                const privacyNav = document.querySelector('.privacy-nav');
                const privacyNavHeight = privacyNav ? privacyNav.offsetHeight : 0;
                const navbarHeight = 70; // Fixed navbar height
                
                const targetPosition = targetSection.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = targetPosition - navbarHeight - privacyNavHeight;
                
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
                const privacyNav = document.querySelector('.privacy-nav');
                const privacyNavHeight = privacyNav ? privacyNav.offsetHeight : 0;
                const navbarHeight = 70; // Fixed navbar height
                
                const targetPosition = initialSection.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = targetPosition - navbarHeight - privacyNavHeight;
                
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
        // Get all privacy sections
        const sections = document.querySelectorAll('.privacy-section');
        
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

// Initialize cookie control buttons
function initCookieControls() {
    const acceptAllBtn = document.querySelector('.accept-all');
    const essentialOnlyBtn = document.querySelector('.essential-only');
    const customizeBtn = document.querySelector('.customize');
    
    if (acceptAllBtn && essentialOnlyBtn && customizeBtn) {
        // Accept all cookies
        acceptAllBtn.addEventListener('click', function() {
            // Simulate saving cookie preferences
            simulateSaving('all');
            showToast('All cookies accepted');
        });
        
        // Accept essential cookies only
        essentialOnlyBtn.addEventListener('click', function() {
            // Simulate saving cookie preferences
            simulateSaving('essential');
            showToast('Essential cookies only accepted');
        });
        
        // Open customize modal
        customizeBtn.addEventListener('click', function() {
            // Create modal for customizing cookies if it doesn't exist
            if (!document.querySelector('.cookie-modal')) {
                createCookieModal();
            }
        });
    }
}

// Simulate saving cookie preferences
function simulateSaving(type) {
    // Create a visual indicator that preferences are saved
    const cookieControl = document.querySelector('.cookie-control');
    if (cookieControl) {
        const savedIndicator = document.createElement('div');
        savedIndicator.classList.add('saved-indicator');
        savedIndicator.innerHTML = '<i class="fas fa-check-circle"></i> Preferences saved';
        savedIndicator.style.color = 'var(--success-color)';
        savedIndicator.style.marginTop = '10px';
        savedIndicator.style.fontWeight = '500';
        
        // Remove any existing indicator
        const existingIndicator = cookieControl.querySelector('.saved-indicator');
        if (existingIndicator) {
            existingIndicator.remove();
        }
        
        // Add new indicator
        cookieControl.appendChild(savedIndicator);
    }
}

// Show toast notification
function showToast(message) {
    // Remove existing toast if present
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create toast
    const toast = document.createElement('div');
    toast.classList.add('toast-notification');
    toast.innerHTML = `<i class="fas fa-cookie-bite"></i> ${message}`;
    
    // Style toast
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.background = 'white';
    toast.style.color = 'var(--dark-color)';
    toast.style.padding = '10px 20px';
    toast.style.borderRadius = '30px';
    toast.style.boxShadow = 'var(--shadow-2)';
    toast.style.zIndex = '999';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.gap = '8px';
    toast.style.fontSize = '0.9rem';
    toast.style.fontWeight = '500';
    toast.style.transition = 'all 0.3s ease';
    toast.style.opacity = '0';
    toast.style.transform = 'translate(-50%, 20px)';
    
    // Add to body
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translate(-50%, 0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translate(-50%, 20px)';
        
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Create cookie customization modal
function createCookieModal() {
    // Create modal container
    const modal = document.createElement('div');
    modal.classList.add('cookie-modal');
    
    // Style modal
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.background = 'rgba(0, 0, 0, 0.5)';
    modal.style.display = 'flex';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';
    modal.style.zIndex = '1000';
    modal.style.opacity = '0';
    modal.style.transition = 'opacity 0.3s ease';
    
    // Create modal content
    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');
    
    // Style modal content
    modalContent.style.background = 'white';
    modalContent.style.borderRadius = 'var(--border-radius)';
    modalContent.style.width = '90%';
    modalContent.style.maxWidth = '600px';
    modalContent.style.maxHeight = '80vh';
    modalContent.style.overflowY = 'auto';
    modalContent.style.padding = '2rem';
    modalContent.style.boxShadow = 'var(--shadow-2)';
    modalContent.style.transform = 'translateY(20px)';
    modalContent.style.transition = 'transform 0.3s ease';
    
    // Modal header
    modalContent.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.5rem;">Customize Cookie Preferences</h3>
            <button class="close-modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p>Select which cookies you want to accept. Essential cookies cannot be disabled as they are required for the website to function.</p>
        
        <div style="margin: 1.5rem 0;">
            <!-- Cookie options will go here -->
            <div class="cookie-option" data-type="essential">
                <div class="cookie-info">
                    <h4>Essential Cookies</h4>
                    <p>Required for the website to function properly</p>
                </div>
                <div class="cookie-status">
                    <span>Always active</span>
                    <div class="switch disabled">
                        <div class="switch-knob active"></div>
                    </div>
                </div>
            </div>
            
            <div class="cookie-option" data-type="functionality">
                <div class="cookie-info">
                    <h4>Functionality Cookies</h4>
                    <p>Remember your preferences and settings</p>
                </div>
                <div class="cookie-status">
                    <div class="switch">
                        <div class="switch-knob active"></div>
                    </div>
                </div>
            </div>
            
            <div class="cookie-option" data-type="analytics">
                <div class="cookie-info">
                    <h4>Analytics Cookies</h4>
                    <p>Help us understand how visitors interact with our website</p>
                </div>
                <div class="cookie-status">
                    <div class="switch">
                        <div class="switch-knob active"></div>
                    </div>
                </div>
            </div>
            
            <div class="cookie-option" data-type="advertising">
                <div class="cookie-info">
                    <h4>Advertising Cookies</h4>
                    <p>Used to deliver relevant advertisements</p>
                </div>
                <div class="cookie-status">
                    <div class="switch">
                        <div class="switch-knob"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal-actions">
            <button class="cancel-btn">Cancel</button>
            <button class="save-btn">Save Preferences</button>
        </div>
    `;
    
    // Append modal content to modal
    modal.appendChild(modalContent);
    
    // Append modal to body
    document.body.appendChild(modal);
    
    // Add necessary styles
    const style = document.createElement('style');
    style.textContent = `
        .cookie-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }
        .cookie-info h4 {
            margin: 0;
            font-size: 1.1rem;
        }
        .cookie-info p {
            margin: 0.5rem 0 0;
            font-size: 0.9rem;
            color: #666;
        }
        .cookie-status {
            display: flex;
            align-items: center;
        }
        .cookie-status span {
            margin-right: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        .switch {
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .switch.disabled {
            background-color: var(--success-color);
            cursor: default;
        }
        .switch-knob {
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease;
        }
        .switch-knob.active {
            transform: translateX(20px);
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 1.5rem;
        }
        .cancel-btn, .save-btn {
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            border: none;
        }
        .cancel-btn {
            background: white;
            color: var(--dark-color);
            border: 1px solid #ddd;
        }
        .save-btn {
            background: var(--primary-color);
            color: white;
        }
    `;
    document.head.appendChild(style);
    
    // Show modal with animation
    setTimeout(() => {
        modal.style.opacity = '1';
        modalContent.style.transform = 'translateY(0)';
    }, 100);
    
    // Add switch toggle functionality
    const switches = document.querySelectorAll('.switch:not(.disabled)');
    switches.forEach(switchElem => {
        switchElem.addEventListener('click', function() {
            const knob = this.querySelector('.switch-knob');
            knob.classList.toggle('active');
            
            if (knob.classList.contains('active')) {
                this.style.backgroundColor = 'var(--primary-color)';
            } else {
                this.style.backgroundColor = '#ccc';
            }
        });
    });
    
    // Set initial switch colors
    document.querySelectorAll('.switch-knob.active').forEach(knob => {
        knob.parentElement.style.backgroundColor = 'var(--primary-color)';
    });
    
    // Close modal on close button click
    const closeModalBtn = document.querySelector('.close-modal');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    // Close modal on cancel button click
    const cancelBtn = document.querySelector('.cancel-btn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }
    
    // Save preferences on save button click
    const saveBtn = document.querySelector('.save-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            // Get cookie preferences
            const preferences = {};
            document.querySelectorAll('.cookie-option').forEach(option => {
                const type = option.getAttribute('data-type');
                const isActive = option.querySelector('.switch-knob').classList.contains('active');
                preferences[type] = isActive;
            });
            
            // Ensure essential cookies are always enabled
            preferences.essential = true;
            
            // Show toast
            showToast('Your cookie preferences have been saved');
            
            // Close modal
            closeModal();
            
            // Update saved indicator
            simulateSaving('custom');
        });
    }
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Close modal function
    function closeModal() {
        modal.style.opacity = '0';
        modalContent.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            modal.remove();
            document.head.removeChild(style);
        }, 300);
    }
}

// Initialize print controls
function initPrintControls() {
    const printBtn = document.querySelector('.print-privacy');
    
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
    }
    
    // Download PDF (in a real app, this would generate a real PDF)
    const downloadBtn = document.querySelector('.download-btn');
    
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show toast
            showToast('PDF download started');
            
            // Simulate download
            setTimeout(() => {
                showToast('PDF downloaded successfully');
            }, 2000);
        });
    }
}

// Add hover animations to right items
function initRightsAnimation() {
    const rightItems = document.querySelectorAll('.right-item');
    
    rightItems.forEach(item => {
        const icon = item.querySelector('i');
        
        item.addEventListener('mouseenter', function() {
            icon.style.transform = 'scale(1.2) rotate(5deg)';
            icon.style.transition = 'transform 0.3s ease';
        });
        
        item.addEventListener('mouseleave', function() {
            icon.style.transform = 'scale(1) rotate(0deg)';
        });
    });
} 