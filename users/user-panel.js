// Preloader
document.addEventListener('DOMContentLoaded', function() {
    // Fade out preloader
    setTimeout(function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.classList.add('preloader-finish');
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 500);
        }
    }, 1000);

    // Menu Toggle - Mobile navigation
    const menuBtn = document.querySelector('.menu-btn');
    const closeMenu = document.querySelector('.close-menu');
    const navLinks = document.querySelector('.nav-links');

    if (menuBtn) {
        menuBtn.addEventListener('click', function() {
            navLinks.classList.add('active');
        });
    }

    if (closeMenu) {
        closeMenu.addEventListener('click', function() {
            navLinks.classList.remove('active');
        });
    }

    // User Dropdown Toggle
    const userProfileBtn = document.getElementById('userProfileBtn');
    const userDropdown = document.getElementById('userDropdown');

    if (userProfileBtn && userDropdown) {
        userProfileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (userDropdown.classList.contains('active') && 
                !userDropdown.contains(e.target) && 
                !userProfileBtn.contains(e.target)) {
                userDropdown.classList.remove('active');
            }
        });
    }

    // Profile link in dropdown should activate profile tab
    const profileLink = document.getElementById('profileLink');
    if (profileLink) {
        profileLink.addEventListener('click', function(e) {
            e.preventDefault();
            activateSection('profile');
            // Close dropdown after clicking
            if (userDropdown) {
                userDropdown.classList.remove('active');
            }
        });
    }

    // Function to activate a specific section
    function activateSection(sectionId) {
        // Get all sidebar menu items and content sections
        const sidebarItems = document.querySelectorAll('.sidebar-menu li');
        const contentSections = document.querySelectorAll('.content-section');
        
        // Remove active class from all items
        sidebarItems.forEach(item => item.classList.remove('active'));
        
        // Add active class to selected item
        const selectedItem = document.querySelector(`.sidebar-menu li[data-section="${sectionId}"]`);
        if (selectedItem) {
            selectedItem.classList.add('active');
        }
        
        // Hide all content sections
        contentSections.forEach(section => section.classList.remove('active'));
        
        // Show the selected section
        const selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
            selectedSection.classList.add('active');
        }
    }

    // Sidebar Menu Navigation
    const sidebarItems = document.querySelectorAll('.sidebar-menu li');
    
    if (sidebarItems.length) {
        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                const sectionToShow = this.getAttribute('data-section');
                if (sectionToShow) {
                    activateSection(sectionToShow);
                }
            });
        });
    }

    // File Upload Preview
    const profileImageInput = document.getElementById('profile_picture');
    const currentPicture = document.querySelector('.current-picture img');

    if (profileImageInput && currentPicture) {
        profileImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    currentPicture.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
                
                // Show file name
                const fileName = this.files[0].name;
                const fileInfo = document.querySelector('.upload-info');
                if (fileInfo) {
                    fileInfo.textContent = `Selected file: ${fileName}`;
                }
            }
        });
    }

    // Form Validation
    const profileForm = document.getElementById('profile-form');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const requiredFields = profileForm.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    // Add error styles
                    field.style.borderColor = 'var(--danger-color)';
                    
                    // Create error message if doesn't exist
                    let errorMsg = field.parentElement.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('small');
                        errorMsg.classList.add('error-message');
                        errorMsg.style.color = 'var(--danger-color)';
                        errorMsg.textContent = 'This field is required';
                        field.parentElement.appendChild(errorMsg);
                    }
                } else {
                    // Remove error styles
                    field.style.borderColor = 'var(--border-color)';
                    
                    // Remove error message if exists
                    const errorMsg = field.parentElement.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Add visual feedback for hover on card elements
    const cards = document.querySelectorAll('.application-card, .stats-card');
    
    if (cards.length) {
        cards.forEach((card, index) => {
            // Add slight shadow and transform effect on hover
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--card-shadow)';
            });
        });
    }

    // Check for URL hash to activate specific tab
    const hash = window.location.hash.substring(1);
    if (hash) {
        // Check if hash corresponds to a valid section
        const validSections = ['dashboard', 'college-applications', 'scholarship-applications', 'profile'];
        if (validSections.includes(hash)) {
            activateSection(hash);
        } else if (hash === 'profile-section') {
            // Handle special case for profile-section hash
            activateSection('profile');
        }
    }

    // Setup Notification Toasts
    function showNotification(message, type = 'success') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            </div>
            <div class="notification-content">
                <p>${message}</p>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add to DOM
        document.body.appendChild(notification);
        
        // Add active class after small delay for animation
        setTimeout(() => {
            notification.classList.add('active');
        }, 10);
        
        // Setup close button
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.classList.remove('active');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.classList.remove('active');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    // Check for notification in URL params (e.g., after form submission)
    const urlParams = new URLSearchParams(window.location.search);
    const notificationMessage = urlParams.get('notification');
    const notificationType = urlParams.get('type') || 'success';
    
    if (notificationMessage) {
        showNotification(decodeURIComponent(notificationMessage), notificationType);
        
        // Remove notification from URL
        const newUrl = window.location.pathname;
        history.pushState({}, document.title, newUrl);
    }

    // Add CSS for notifications that wasn't included in the main CSS
    const notificationStyles = document.createElement('style');
    notificationStyles.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: -350px;
            width: 300px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            padding: 15px;
            transition: right 0.3s ease;
            z-index: 1000;
        }
        
        .notification.active {
            right: 20px;
        }
        
        .notification.success {
            border-left: 4px solid var(--success-color);
        }
        
        .notification.error {
            border-left: 4px solid var(--danger-color);
        }
        
        .notification-icon {
            margin-right: 15px;
            font-size: 20px;
        }
        
        .notification.success .notification-icon {
            color: var(--success-color);
        }
        
        .notification.error .notification-icon {
            color: var(--danger-color);
        }
        
        .notification-content {
            flex-grow: 1;
        }
        
        .notification-close {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: var(--text-light);
            transition: color 0.2s ease;
        }
        
        .notification-close:hover {
            color: var(--text-color);
        }
    `;
    document.head.appendChild(notificationStyles);

    // Function to handle menu shows
    window.showMenu = function() {
        if (navLinks) {
            navLinks.classList.add('active');
        }
    }
    
    // Function to handle menu hiding
    window.hideMenu = function() {
        if (navLinks) {
            navLinks.classList.remove('active');
        }
    }
});
