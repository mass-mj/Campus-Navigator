// API Configuration
const API_BASE_URL = '/api';

// Authentication
let authToken = localStorage.getItem('authToken');
let currentUser = JSON.parse(localStorage.getItem('currentUser'));

// API Helper Functions
const api = {
    // Authentication
    login: async (username, password) => {
        try {
            // Simulate API call with local users database
            const user = window.users.find(u => u.username === username && u.password === password);
            
            if (user) {
                // Create a token (in a real app, this would be a proper JWT)
                const token = btoa(username + ':' + Date.now());
                authToken = token;
                currentUser = {
                    id: user.id,
                    username: user.username,
                    email: user.email,
                    role: user.role,
                    name: user.name
                };
                
                localStorage.setItem('authToken', authToken);
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                return { token, user: currentUser };
            } else {
                throw new Error('Invalid username or password');
            }
        } catch (error) {
            throw error;
        }
    },

    logout: () => {
        authToken = null;
        currentUser = null;
        localStorage.removeItem('authToken');
        localStorage.removeItem('currentUser');
    },

    // Analytics (simulated data)
    getAnalytics: async () => {
        return {
            total_users: 1500,
            total_colleges: 4000,
            total_scholarships: 250,
            total_downloads: 12000,
            user_growth: 15,
            college_growth: 8,
            scholarship_growth: 12,
            download_growth: 20
        };
    },

    // College Management (simulated data)
    getColleges: async (filters = {}) => {
        return [
            {
                id: 1,
                name: 'Harvard University',
                location: 'Cambridge, MA',
                ranking: 1,
                fees: 50000,
                courses: 'Business, Law, Medicine, Arts'
            },
            {
                id: 2,
                name: 'Stanford University',
                location: 'Stanford, CA',
                ranking: 2,
                fees: 48000,
                courses: 'Engineering, Computer Science, Business'
            }
        ];
    },

    createCollege: async (collegeData) => {
        // Simulate API call
        return { ...collegeData, id: Date.now() };
    },

    updateCollege: async (id, collegeData) => {
        // Simulate API call
        return { ...collegeData, id };
    },

    deleteCollege: async (id) => {
        // Simulate API call
        return { success: true, id };
    }
};

// College Search and Filter Functions
const collegeSearch = {
    search: async (query, filters = {}) => {
        try {
            const colleges = await api.getColleges();
            return colleges.filter(college => {
                const matchesQuery = college.name.toLowerCase().includes(query.toLowerCase()) ||
                                   college.location.toLowerCase().includes(query.toLowerCase()) ||
                                   college.courses.toLowerCase().includes(query.toLowerCase());

                const matchesFilters = Object.entries(filters).every(([key, value]) => {
                    switch (key) {
                        case 'ranking':
                            return college.ranking <= value;
                        case 'fees':
                            return college.fees <= value;
                        case 'location':
                            return college.location.toLowerCase().includes(value.toLowerCase());
                        default:
                            return true;
                    }
                });

                return matchesQuery && matchesFilters;
            });
        } catch (error) {
            throw error;
        }
    },

    sort: (colleges, sortBy, order = 'asc') => {
        return [...colleges].sort((a, b) => {
            let comparison = 0;
            switch (sortBy) {
                case 'ranking':
                    comparison = a.ranking - b.ranking;
                    break;
                case 'fees':
                    comparison = a.fees - b.fees;
                    break;
                case 'name':
                    comparison = a.name.localeCompare(b.name);
                    break;
                default:
                    comparison = 0;
            }
            return order === 'asc' ? comparison : -comparison;
        });
    }
};

// Analytics Tracking
const analytics = {
    trackPageView: async () => {
        try {
            await fetch(`${API_BASE_URL}/analytics`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    page_url: window.location.pathname,
                    ip_address: '', // Will be handled by server
                    user_agent: navigator.userAgent
                })
            });
        } catch (error) {
            console.error('Failed to track page view:', error);
        }
    }
};

// Initialize analytics tracking
document.addEventListener('DOMContentLoaded', () => {
    analytics.trackPageView();
});

// Export API functions
window.api = api;
window.collegeSearch = collegeSearch;
window.analytics = analytics; 