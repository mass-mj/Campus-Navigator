// Admin Panel JavaScript

// DOM Elements
const body = document.querySelector('body');
const adminSidebar = document.querySelector('.admin-sidebar');
const sidebarToggle = document.querySelector('.sidebar-toggle');
const navLinks = document.querySelectorAll('.admin-nav ul li');
const sections = document.querySelectorAll('.admin-section');
const themeToggle = document.getElementById('theme-toggle');
const notificationBtn = document.querySelector('.notification-btn');
const messageBtn = document.querySelector('.message-btn');
const helpBtn = document.querySelector('.help-btn');
const particlesElement = document.getElementById('particles-js');
const logoContainer = document.getElementById('logo-container');

// Initialize the admin panel
document.addEventListener('DOMContentLoaded', function() {
    // Initialize functions
    initializeTheme();
    initializeNavigation();
    initializeSidebar();
    initializeParticles();
    setup3DElements();
    
    // Initialize charts and data
    initCharts();
    animateCounters();
    
    // Initialize interactive elements
    initializeRadialMenu();
    initialize3DCards();
});

// Theme management
function initializeTheme() {
    // Check if user has a theme preference stored
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme === 'dark') {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
    
    // Theme toggle click handler
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            if (body.classList.contains('dark-mode')) {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });
    }
}

// Enable dark mode
function enableDarkMode() {
    body.classList.add('dark-mode');
    body.classList.add('dark-mode-transition');
    
    if (themeToggle) {
        themeToggle.innerHTML = '<i class="fas fa-sun"></i><span>Light Mode</span>';
    }
    
    // Save preference to localStorage
    localStorage.setItem('theme', 'dark');
    
    // Update charts
    updateChartsForDarkMode(true);
}

// Disable dark mode
function disableDarkMode() {
    body.classList.remove('dark-mode');
    
    // Add transition class
    body.classList.add('dark-mode-transition');
    
    // Remove transition class after animation completes
    setTimeout(() => {
        body.classList.remove('dark-mode-transition');
    }, 500);
    
    if (themeToggle) {
        themeToggle.innerHTML = '<i class="fas fa-moon"></i><span>Dark Mode</span>';
    }
    
    // Save preference to localStorage
    localStorage.setItem('theme', 'light');
    
    // Update charts
    updateChartsForDarkMode(false);
}

// Update charts for dark mode
function updateChartsForDarkMode(isDark) {
    const chartElements = document.querySelectorAll('.stat-chart canvas');
    
    if (chartElements.length === 0) return;
    
    chartElements.forEach(canvas => {
        const chart = Chart.getChart(canvas);
        if (chart) {
            chart.options.scales.x.grid.color = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            chart.options.scales.y.grid.color = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            chart.options.scales.x.ticks.color = isDark ? '#a0a0a0' : '#666666';
            chart.options.scales.y.ticks.color = isDark ? '#a0a0a0' : '#666666';
            chart.update();
        }
    });
}

// Navigation between sections
function initializeNavigation() {
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Get the section to show based on data attribute
            const targetSection = this.getAttribute('data-section');
            
            // Update active link
            navLinks.forEach(navLink => navLink.classList.remove('active'));
            this.classList.add('active');
            
            // Show target section, hide others
            sections.forEach(section => {
                if (section.id === `${targetSection}-section`) {
                    section.classList.add('active');
                } else {
                    section.classList.remove('active');
                }
            });
            
            // On mobile, close sidebar after navigation
            if (window.innerWidth < 992) {
                toggleSidebar();
            }
            
            // Update URL hash
            window.location.hash = targetSection;
        });
    });
    
    // Check if URL has a hash and navigate to that section
    if (window.location.hash) {
        const targetSection = window.location.hash.substring(1);
        const targetLink = document.querySelector(`.admin-nav ul li[data-section="${targetSection}"]`);
        
        if (targetLink) {
            targetLink.click();
        }
    }
}

// Sidebar toggle functionality
function initializeSidebar() {
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Close sidebar when clicking outside (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && 
            !adminSidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target) &&
            body.classList.contains('sidebar-open')) {
            toggleSidebar();
        }
    });
    
    // Initialize based on screen size
    if (window.innerWidth < 992) {
        body.classList.remove('sidebar-open');
        body.classList.add('sidebar-collapsed');
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            body.classList.add('sidebar-open');
            body.classList.remove('sidebar-collapsed');
        } else {
            body.classList.remove('sidebar-open');
            body.classList.add('sidebar-collapsed');
        }
    });
}

// Toggle sidebar visibility
function toggleSidebar() {
    body.classList.toggle('sidebar-open');
    body.classList.toggle('sidebar-collapsed');
}

// Initialize particles background
function initializeParticles() {
    if (particlesElement && window.particlesJS) {
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 50,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#4a6cf7'
                },
                shape: {
                    type: 'circle',
                    stroke: {
                        width: 0,
                        color: '#000000'
                    }
                },
                opacity: {
                    value: 0.3,
                    random: true,
                    animation: {
                        enable: true,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    animation: {
                        enable: true,
                        speed: 2,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#4a6cf7',
                    opacity: 0.2,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 1,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'grab'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 140,
                        line_linked: {
                            opacity: 0.5
                        }
                    },
                    push: {
                        particles_nb: 4
                    }
                }
            },
            retina_detect: true
        });
    }
}

// Setup 3D elements
function setup3DElements() {
    if (logoContainer && window.THREE) {
        setupLogo3D();
    }
}

// Setup 3D Logo
function setupLogo3D() {
    // Create a scene
    const scene = new THREE.Scene();
    
    // Create a camera
    const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
    camera.position.z = 2;
    
    // Create a renderer
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setSize(50, 50);
    logoContainer.appendChild(renderer.domElement);
    
    // Create the logo geometry (a simple cube for demo)
    const geometry = new THREE.BoxGeometry(1, 1, 1);
    const material = new THREE.MeshBasicMaterial({ 
        color: 0x4a6cf7,
        wireframe: true
    });
    const cube = new THREE.Mesh(geometry, material);
    scene.add(cube);
    
    // Animation loop
    function animate() {
        requestAnimationFrame(animate);
        
        // Rotate the cube
        cube.rotation.x += 0.01;
        cube.rotation.y += 0.01;
        
        // Render the scene
        renderer.render(scene, camera);
    }
    
    animate();
}

// Animate counter numbers
function animateCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-counter'));
        const duration = 1500; // Animation duration in milliseconds
        const step = Math.ceil(target / (duration / 30)); // Update every 30ms
        let current = 0;
        
        const updateCount = () => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = current.toLocaleString();
        };
        
        const timer = setInterval(updateCount, 30);
    });
}

// Initialize charts
function initCharts() {
    if (!window.Chart) return;
    
    // Chart.js global defaults
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.plugins.legend.display = false;
    
    // Users Chart
    const usersChart = document.getElementById('users-chart');
    if (usersChart) {
        new Chart(usersChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    data: [800, 950, 1100, 1250, 1400, 1543],
                    backgroundColor: 'rgba(74, 108, 247, 0.2)',
                    borderColor: '#4a6cf7',
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    }
                },
                maintainAspectRatio: false,
                responsive: true
            }
        });
    }
    
    // Colleges Chart
    const collegesChart = document.getElementById('colleges-chart');
    if (collegesChart) {
        new Chart(collegesChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    data: [320, 350, 380, 400, 410, 428],
                    backgroundColor: 'rgba(108, 99, 255, 0.2)',
                    borderColor: '#6c63ff',
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    }
                },
                maintainAspectRatio: false,
                responsive: true
            }
        });
    }
    
    // Scholarships Chart
    const scholarshipsChart = document.getElementById('scholarships-chart');
    if (scholarshipsChart) {
        new Chart(scholarshipsChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    data: [150, 180, 200, 220, 240, 257],
                    backgroundColor: 'rgba(46, 204, 113, 0.2)',
                    borderColor: '#2ecc71',
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    }
                },
                maintainAspectRatio: false,
                responsive: true
            }
        });
    }
    
    // Resources Chart
    const resourcesChart = document.getElementById('resources-chart');
    if (resourcesChart) {
        new Chart(resourcesChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    data: [5000, 6000, 6500, 7200, 8000, 8759],
                    backgroundColor: 'rgba(243, 156, 18, 0.2)',
                    borderColor: '#f39c12',
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0
                }]
            },
            options: {
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    }
                },
                maintainAspectRatio: false,
                responsive: true
            }
        });
    }
}

// Initialize Radial Menu
function initializeRadialMenu() {
    const radialMenu = document.getElementById('quick-actions');
    if (!radialMenu) return;
    
    const toggle = radialMenu.querySelector('.radial-menu-toggle');
    
    toggle.addEventListener('click', function() {
        radialMenu.classList.toggle('active');
    });
    
    // Close the menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!radialMenu.contains(event.target)) {
            radialMenu.classList.remove('active');
        }
    });
    
    // Add tooltip functionality
    const radialItems = radialMenu.querySelectorAll('.radial-menu-item');
    
    radialItems.forEach(item => {
        const tooltip = document.createElement('div');
        tooltip.className = 'radial-tooltip';
        tooltip.textContent = item.dataset.tooltip;
        item.appendChild(tooltip);
        
        item.addEventListener('mouseenter', function() {
            tooltip.style.opacity = '1';
        });
        
        item.addEventListener('mouseleave', function() {
            tooltip.style.opacity = '0';
        });
    });
}

// Initialize 3D card effects
function initialize3DCards() {
    const cards = document.querySelectorAll('.card-3d');
    
    cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            // Get position of the mouse inside the card
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Calculate the rotation values based on mouse position
            const rotateX = (y / rect.height - 0.5) * -10; // Rotate around X axis
            const rotateY = (x / rect.width - 0.5) * 10; // Rotate around Y axis
            
            // Apply the rotation
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            
            // Add light effect (highlight)
            const shine = card.querySelector('.card-shine') || document.createElement('div');
            
            if (!card.querySelector('.card-shine')) {
                shine.classList.add('card-shine');
                card.appendChild(shine);
            }
            
            // Position the highlight based on mouse position
            shine.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 80%)`;
        });
        
        // Reset the card when mouse leaves
        card.addEventListener('mouseleave', function() {
            card.style.transform = '';
            
            const shine = card.querySelector('.card-shine');
            if (shine) {
                shine.style.background = '';
            }
        });
    });
}

// Add CSS class for radial menu tooltip
const style = document.createElement('style');
style.textContent = `
    .radial-tooltip {
        position: absolute;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .card-shine {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 100;
    }
`;
document.head.appendChild(style); 