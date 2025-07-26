// Navigation Menu Toggle
function showMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.add('active');
}

function hideMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.remove('active');
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get search elements
    const searchInput = document.getElementById('collegeSearch');
    const searchButton = document.getElementById('searchButton');
    
    // Initialize search functionality
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', function() {
            performSearch(searchInput.value);
        });
        
        // Also trigger search on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(searchInput.value);
            }
        });
    }
});

// Global search function that can be called from other scripts
function performSearch(query) {
    if (!query || query.trim() === '') return;
    
    query = query.toLowerCase().trim();
    
    // Get all college cards
    const collegeCards = document.querySelectorAll('.college-card');
    const resultsGrid = document.getElementById('collegeGrid');
    const noResults = document.querySelector('.no-results');
    let resultsFound = false;
    
    // Filter colleges based on search term
    collegeCards.forEach(card => {
        const collegeName = card.querySelector('h3').textContent.toLowerCase();
        const collegeLocation = card.querySelector('.college-location').textContent.toLowerCase();
        const collegeDesc = card.querySelector('.college-desc').textContent.toLowerCase();
        const collegeTags = card.querySelectorAll('.tag');
        
        let tagsMatch = false;
        collegeTags.forEach(tag => {
            if (tag.textContent.toLowerCase().includes(query)) {
                tagsMatch = true;
            }
        });
        
        // Show card if it matches search
        if (collegeName.includes(query) || 
            collegeLocation.includes(query) || 
            collegeDesc.includes(query) || 
            tagsMatch) {
            card.style.display = 'block';
            resultsFound = true;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Update UI based on search results
    if (resultsFound) {
        if (noResults) noResults.style.display = 'none';
        
        // Count visible cards
        const visibleCards = document.querySelectorAll('.college-card[style="display: block;"]');
        const resultsCount = document.getElementById('resultsCount');
        if (resultsCount) {
            resultsCount.textContent = visibleCards.length;
        }
    } else {
        if (noResults) noResults.style.display = 'block';
        if (resultsGrid) resultsGrid.style.display = 'none';
    }
    
    // Scroll to results
    document.querySelector('.college-results').scrollIntoView({
        behavior: 'smooth'
    });
}

// Preloader
window.addEventListener('load', function() {
    const preloader = document.querySelector('.preloader');
    setTimeout(() => {
        preloader.classList.add('preloader-finish');
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
        
        // Initial animations when page loads
        animateContent();
    }, 1000);
    
    // Check for URL parameters to see if we need to populate the search
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('q');
    if (searchQuery) {
        document.getElementById('collegeSearch').value = searchQuery;
        // Auto-trigger search
        searchColleges();
    }
});

// Animate content on load
function animateContent() {
    const heroContent = document.querySelector('.hero-content');
    heroContent.classList.add('animate');
    
    // Animate college cards with staggered delay
    const collegeCards = document.querySelectorAll('.college-card');
    collegeCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate');
        }, 100 * index);
    });
}

// Advanced Filter Toggle
const advFilterToggle = document.getElementById('advancedFilterToggle');
const advFilters = document.getElementById('advancedFilters');

if (advFilterToggle) {
    advFilterToggle.addEventListener('click', function() {
        advFilters.classList.toggle('active');
        this.classList.toggle('active');
    });
}

// Filter buttons functionality
const filterBtns = document.querySelectorAll('.filter-btn');
filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        filterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.getAttribute('data-filter');
        searchColleges();
    });
});

// Search button event listener
const searchBtn = document.getElementById('searchButton');
searchBtn.addEventListener('click', function() {
    searchColleges();
});

// Enter key for search
const searchInput = document.getElementById('collegeSearch');
searchInput.addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        searchColleges();
    }
});

// Function to get active filter
function getActiveFilter() {
    const activeFilter = document.querySelector('.filter-btn.active');
    return activeFilter ? activeFilter.getAttribute('data-filter') : 'all';
}

// College search function
function searchColleges() {
    const searchInput = document.getElementById('collegeSearch').value;
    const filter = getActiveFilter();
    const sort = document.getElementById('sortBy').value;
    
    // Show loading state
    document.getElementById('collegeGrid').innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Loading colleges...</div>';
    
    // Fetch colleges from server
    fetch(`search_colleges.php?search=${encodeURIComponent(searchInput)}&category=${filter}&sort=${sort}`)
        .then(response => response.json())
        .then(data => {
            displayColleges(data);
        })
        .catch(error => {
            console.error('Error fetching colleges:', error);
            document.getElementById('collegeGrid').innerHTML = '<div class="error">Error loading colleges. Please try again.</div>';
        });
}

// Sort select event listener
const sortSelect = document.getElementById('sortBy');
sortSelect.addEventListener('change', function() {
    searchColleges();
});

// Function to display colleges
function displayColleges(data) {
    const collegeGrid = document.getElementById('collegeGrid');
    const noResults = document.querySelector('.no-results');
    
    // Update count
    document.getElementById('resultsCount').textContent = data.count;
    
    // Check if we have results
    if (data.count === 0) {
        collegeGrid.innerHTML = '';
        noResults.style.display = 'block';
        return;
    }
    
    // Hide no results message
    noResults.style.display = 'none';
    
    // Generate HTML for colleges
    let html = '';
    
    data.colleges.forEach(college => {
        const countryClass = college.category.includes('india') ? 'india' : 'international';
        const countryLabel = college.category.includes('india') ? 'in India' : 'Global';
        
        let tuitionDisplay;
        if (college.category.includes('india')) {
            tuitionDisplay = '₹' + (college.tuition / 100000).toFixed(1) + 'L';
        } else {
            tuitionDisplay = '$' + (college.tuition / 75000).toFixed(0) + 'K';
        }
        
        const gradeLabel = college.grade.includes('QS') ? 'World Rank' : 'NAAC Grade';
        
        // Generate tags HTML
        let tagsHtml = '';
        college.tags.forEach(tag => {
            tagsHtml += `<span class="tag">${tag}</span>`;
        });
        
        html += `
            <div class="college-card ${countryClass}" 
                 data-category="${college.category}" 
                 data-ranking="${college.ranking}" 
                 data-tuition="${college.tuition}" 
                 data-acceptance="${college.acceptance_rate}">
                <div class="college-header">
                    <div class="college-logo">
                        <img src="${college.logo_url}" alt="${college.name} Logo">
                    </div>
                    <div class="college-badge">
                        <span class="rank">#${college.ranking}</span>
                        <span>${countryLabel}</span>
                    </div>
                </div>
                <div class="college-content">
                    <h3>${college.name}</h3>
                    <div class="college-location"><i class="fas fa-map-marker-alt"></i> ${college.location}</div>
                    <div class="college-stats">
                        <div class="stat">
                            <span class="stat-value">${college.acceptance_rate}%</span>
                            <span class="stat-label">Acceptance Rate</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">${tuitionDisplay}</span>
                            <span class="stat-label">Annual Tuition</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">${college.grade}</span>
                            <span class="stat-label">${gradeLabel}</span>
                        </div>
                    </div>
                    <p class="college-desc">${college.description}</p>
                    <div class="college-tags">${tagsHtml}</div>
                </div>
                <div class="college-actions">
                    <a href="college-details.php?id=${college.id}" class="btn-details">View Details</a>
                </div>
            </div>
        `;
    });
    
    collegeGrid.innerHTML = html;
    
    // Animate new cards
    setTimeout(() => {
        const collegeCards = document.querySelectorAll('.college-card');
        collegeCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('animate');
            }, 50 * index);
        });
    }, 100);
}

// Range slider functionality
const tuitionRange = document.getElementById('tuitionRange');
const tuitionMax = document.getElementById('tuitionMax');

if (tuitionRange) {
    tuitionRange.addEventListener('input', function() {
        const value = this.value;
        if (value >= 2500000) {
            tuitionMax.textContent = '₹25,00,000+';
        } else {
            tuitionMax.textContent = '₹' + parseInt(value).toLocaleString('en-IN');
        }
    });
}

// Apply filters button
const applyFiltersBtn = document.querySelector('.apply-btn');
if (applyFiltersBtn) {
    applyFiltersBtn.addEventListener('click', function() {
        // Get all selected filter values
        const selectedLocations = Array.from(document.querySelectorAll('input[name="location"]:checked')).map(cb => cb.value);
        const selectedPrograms = Array.from(document.querySelectorAll('input[name="program"]:checked')).map(cb => cb.value);
        const selectedTypes = Array.from(document.querySelectorAll('input[name="type"]:checked')).map(cb => cb.value);
        const tuitionValue = document.getElementById('tuitionRange').value;
        
        // Prepare form data
        const formData = new FormData();
        formData.append('maxTuition', tuitionValue);
        
        // Add arrays to form data
        selectedLocations.forEach(location => {
            formData.append('locations[]', location);
        });
        
        selectedPrograms.forEach(program => {
            formData.append('programs[]', program);
        });
        
        selectedTypes.forEach(type => {
            formData.append('types[]', type);
        });
        
        // Show loading state
        document.getElementById('collegeGrid').innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Applying filters...</div>';
        
        // Submit advanced search
        fetch('advanced_search.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            displayColleges(data);
        })
        .catch(error => {
            console.error('Error applying filters:', error);
            document.getElementById('collegeGrid').innerHTML = '<div class="error">Error applying filters. Please try again.</div>';
        });
        
        // Hide filters panel
        advFilters.classList.remove('active');
        advFilterToggle.classList.remove('active');
    });
}

// Reset filters
const resetFiltersBtn = document.querySelector('.reset-btn');
if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener('click', function() {
        // Reset all checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset range slider
        if (tuitionRange) {
            tuitionRange.value = 2500000;
            tuitionMax.textContent = '₹25,00,000+';
        }
        
        // Show all colleges again
        searchColleges();
    });
}

// Load more button
const loadMoreBtn = document.getElementById('loadMoreBtn');
if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
        // In a real implementation, you would track the offset and load more colleges
        // For now, we'll just refresh the search to keep it simple
        searchColleges();
    });
}