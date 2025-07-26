// Document Ready Function
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation
    window.showMenu = function() {
        document.getElementById('navLinks').classList.add('active');
    }

    window.hideMenu = function() {
        document.getElementById('navLinks').classList.remove('active');
    }

    // Initialize resource filtering
    initResourceFiltering();
    
    // Initialize view toggle
    initViewToggle();
    
    // Initialize search functionality
    initSearch();
    
    // Initialize tag filtering
    initTagFiltering();
    
    // Initialize load more behavior
    initLoadMore();
});

// Initialize Resource Filtering
function initResourceFiltering() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const resourceItems = document.querySelectorAll('.resource-item');
    
    // Handle filter button clicks
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Get filter value
            const filterValue = this.getAttribute('data-filter');
            
            // Filter items
            if (filterValue === '*') {
                // Show all items
                resourceItems.forEach(item => {
                    item.classList.remove('hidden');
                    resetAnimation(item);
                });
            } else {
                // Filter items by class
                resourceItems.forEach(item => {
                    if (item.classList.contains(filterValue.substring(1))) {
                        item.classList.remove('hidden');
                        resetAnimation(item);
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
        });
    });
    
    // Function to reset animation
    function resetAnimation(element) {
        element.classList.add('filtering');
        
        // Remove class after animation completes
        setTimeout(() => {
            element.classList.remove('filtering');
        }, 500);
    }

    // Check if URL has a hash and filter accordingly
    if (window.location.hash) {
        const hash = window.location.hash.substring(1); // Remove the # character
        const targetButton = document.getElementById(hash);
        
        if (targetButton) {
            targetButton.click();
            
            // Smooth scroll to filter section
            const filterSection = document.querySelector('.filter-section');
            if (filterSection) {
                setTimeout(() => {
                    window.scrollTo({
                        top: filterSection.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }, 100);
            }
        }
    }
}

// Initialize View Toggle
function initViewToggle() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const gridContainer = document.querySelector('.grid-container');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Get view value
            const viewValue = this.getAttribute('data-view');
            
            // Toggle view class
            if (viewValue === 'grid') {
                gridContainer.classList.remove('list-view');
            } else {
                gridContainer.classList.add('list-view');
            }
        });
    });
}

// Initialize Search Functionality
function initSearch() {
    const searchInput = document.getElementById('resourceSearch');
    const resourceItems = document.querySelectorAll('.resource-item');
    
    searchInput.addEventListener('input', function() {
        const searchValue = this.value.toLowerCase().trim();
        
        if (searchValue === '') {
            // If search is empty, show all items
            resourceItems.forEach(item => {
                item.classList.remove('hidden');
            });
            return;
        }
        
        // Filter items based on search value
        resourceItems.forEach(item => {
            const title = item.querySelector('h3').textContent.toLowerCase();
            const content = item.querySelector('p').textContent.toLowerCase();
            const category = item.querySelector('.resource-category').textContent.toLowerCase();
            
            if (title.includes(searchValue) || content.includes(searchValue) || category.includes(searchValue)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    });
}

// Initialize Tag Filtering
function initTagFiltering() {
    const tags = document.querySelectorAll('.tag');
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    tags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get filter value
            const filterValue = this.getAttribute('data-filter');
            
            // Reset all filter buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Filter items directly
            const resourceItems = document.querySelectorAll('.resource-item');
            
            resourceItems.forEach(item => {
                if (filterValue === '*') {
                    item.classList.remove('hidden');
                } else if (item.classList.contains(filterValue.substring(1))) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
            
            // Smooth scroll to filter section
            const filterSection = document.querySelector('.filter-section');
            if (filterSection) {
                window.scrollTo({
                    top: filterSection.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
            
            // Update tags active state
            tags.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Initialize Load More Functionality (simulated)
function initLoadMore() {
    const loadMoreButton = document.querySelector('.load-more');
    
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            // Add loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            
            // Simulate loading delay
            setTimeout(() => {
                // In a real application, this would load more items from an API or backend
                // For demo purposes, we'll clone existing items
                const gridContainer = document.querySelector('.grid-container');
                const resourceItems = document.querySelectorAll('.resource-item');
                
                // Clone the first 3 items with new random data
                for (let i = 0; i < Math.min(3, resourceItems.length); i++) {
                    const clone = resourceItems[i].cloneNode(true);
                    
                    // Modify clone to make it appear different
                    const randomDate = getRandomDate();
                    clone.querySelector('.resource-date').innerHTML = '<i class="far fa-calendar-alt"></i> ' + randomDate;
                    
                    // Add to container with animation
                    clone.style.animationDelay = (i * 0.1) + 's';
                    gridContainer.appendChild(clone);
                }
                
                // Reset button
                this.innerHTML = 'Load More Articles <i class="fas fa-sync"></i>';
                
                // Hide button if we've loaded "all" articles (in a real app, this would be determined by API response)
                if (document.querySelectorAll('.resource-item').length > 15) {
                    this.style.display = 'none';
                    
                    // Add a "no more articles" message
                    const noMoreMessage = document.createElement('p');
                    noMoreMessage.textContent = 'No more articles to load.';
                    noMoreMessage.style.textAlign = 'center';
                    noMoreMessage.style.marginTop = '1rem';
                    noMoreMessage.style.color = '#666';
                    document.querySelector('.load-more-container').appendChild(noMoreMessage);
                }
            }, 1500);
        });
    }
}

// Helper function to generate random dates
function getRandomDate() {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const randomMonth = months[Math.floor(Math.random() * months.length)];
    const randomDay = Math.floor(Math.random() * 28) + 1;
    return randomMonth + ' ' + randomDay + ', 2023';
}

// Light Beam Animation Enhancement
window.addEventListener('mousemove', function(e) {
    const lightBeams = document.querySelector('.light-beams');
    
    if (lightBeams) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        const beams = document.querySelectorAll('.beam');
        beams.forEach((beam, index) => {
            const offsetX = (mouseX - 0.5) * (index + 1) * 5;
            const offsetY = (mouseY - 0.5) * (index + 1) * 5;
            
            beam.style.transform = `rotate(45deg) translateY(calc(-50% + ${offsetY}px)) translateX(${offsetX}px)`;
        });
    }
}); 