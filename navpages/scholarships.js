/**
 * CampusNavigator Scholarships Page Script
 * Handles navigation, filtering, and card animations
 */

// Navigation Controls
function showMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.add('active');
    // Prevent body scrolling when menu is open
    document.body.style.overflow = 'hidden';
}

function hideMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.remove('active');
    // Re-enable body scrolling
    document.body.style.overflow = '';
}

// Document Ready Events
document.addEventListener('DOMContentLoaded', function() {
    const scholarshipCards = document.querySelectorAll('.scholarship-card');
    
    // Add animation delays to cards
    scholarshipCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Initialize scholarship filters
    initScholarshipFilters();

    // Add this to handle form submission
    const scholarshipForm = document.getElementById('scholarshipForm');
    if (scholarshipForm) {
        scholarshipForm.addEventListener('submit', function() {
            // Show preloader immediately on form submission
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.display = 'flex';
                preloader.classList.remove('preloader-finish');
            }
        });
    }

    // Check for success parameter in URL to ensure preloader is hidden
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        hidePreloader();
    }
});

// Window Load Event
window.addEventListener('load', function() {
    hidePreloader();
});

// Function to hide preloader
function hidePreloader() {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.classList.add('preloader-finish');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
    
    // Force hide preloader after 2 seconds as a fallback
    setTimeout(() => {
        const preloader = document.querySelector('.preloader');
        if (preloader && preloader.style.display !== 'none') {
            preloader.style.display = 'none';
        }
    }, 2000);
}

// Toggle Scholarship Details
function toggleDetails(button) {
    const card = button.closest('.scholarship-card');
    const icon = button.querySelector('i');
    const text = button.querySelector('span');
    
    card.classList.toggle('expanded');
    
    if (card.classList.contains('expanded')) {
        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
        text.textContent = 'Hide Details';
    } else {
        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
        text.textContent = 'View Details';
    }
}

// Initialize Category Filter
function initScholarshipFilters() {
    const filterSelect = document.getElementById('filterBy');
    const scholarshipCards = document.querySelectorAll('.scholarship-card');
    const noResultsElement = document.querySelector('.no-results');
    
    if (!filterSelect) return;
    
    filterSelect.addEventListener('change', function() {
        const selectedCategory = this.value;
        let visibleCount = 0;
        
        // Filter scholarships
        scholarshipCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            
            if (selectedCategory === 'all' || selectedCategory === cardCategory) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide "no results" message if it exists
        if (noResultsElement) {
            if (visibleCount === 0) {
                noResultsElement.style.display = 'block';
            } else {
                noResultsElement.style.display = 'none';
            }
        }
    });
}
