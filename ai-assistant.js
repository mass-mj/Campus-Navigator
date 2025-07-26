/**
 * AI Assistant - Interactive floating chat interface
 * For Campus Navigator College Finder
 */
document.addEventListener('DOMContentLoaded', function() {
    // Create and append AI Assistant elements to the page
    createAIAssistant();
    
    // Initialize the AI Assistant functionality
    initAIAssistant();
    
    console.log("AI Assistant initialized!");
});

// Also initialize when the window has fully loaded, as a fallback
window.addEventListener('load', function() {
    // Check if assistant already exists
    if (!document.querySelector('.ai-assistant-icon')) {
        console.log("AI Assistant initializing on window load");
        createAIAssistant();
        initAIAssistant();
    }
});

/**
 * Creates and appends all necessary AI Assistant HTML elements
 */
function createAIAssistant() {
    // Main AI icon button
    const aiIcon = document.createElement('div');
    aiIcon.className = 'ai-assistant-icon';
    aiIcon.innerHTML = '<i class="fas fa-robot"></i>';
    aiIcon.setAttribute('aria-label', 'Open AI Assistant');
    aiIcon.setAttribute('title', 'Ask Campus Navigator AI');
    
    // AI Assistant chat container
    const aiContainer = document.createElement('div');
    aiContainer.className = 'ai-assistant-container';
    aiContainer.innerHTML = `
        <div class="ai-assistant-header">
            <div class="ai-assistant-title">
                <div class="ai-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>Campus Navigator AI</h3>
            </div>
            <div class="ai-assistant-controls">
                <button class="ai-minimize" aria-label="Minimize chat">
                    <i class="fas fa-minus"></i>
                </button>
                <button class="ai-close" aria-label="Close chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="ai-assistant-categories">
            <!-- Categories will be dynamically added here -->
            <div class="ai-category active" data-category="all">All</div>
        </div>
        
        <div class="ai-assistant-messages"></div>
        
        <div class="ai-assistant-suggestions">
            <!-- Suggested questions will be dynamically added here -->
        </div>
        
        <div class="ai-assistant-input">
            <input type="text" placeholder="Ask a question..." aria-label="Type your question here">
            <button type="button" aria-label="Send question">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    `;
    
    // Append elements to the body
    document.body.appendChild(aiIcon);
    document.body.appendChild(aiContainer);
}

/**
 * Initializes AI Assistant functionality
 */
function initAIAssistant() {
    // Main elements
    const aiIcon = document.querySelector('.ai-assistant-icon');
    const aiContainer = document.querySelector('.ai-assistant-container');
    const aiInput = aiContainer.querySelector('input');
    const aiSendBtn = aiContainer.querySelector('button');
    const aiMessages = aiContainer.querySelector('.ai-assistant-messages');
    const aiSuggestions = aiContainer.querySelector('.ai-assistant-suggestions');
    const aiCategories = aiContainer.querySelector('.ai-assistant-categories');
    const aiMinimize = aiContainer.querySelector('.ai-minimize');
    const aiClose = aiContainer.querySelector('.ai-close');
    
    // State variables
    let isOpen = false;
    let isTyping = false;
    let currentCategory = 'all';
    
    // Toggle chat open/close
    aiIcon.addEventListener('click', toggleChat);
    aiMinimize.addEventListener('click', toggleChat);
    aiClose.addEventListener('click', toggleChat);
    
    // Open/close chat function
    function toggleChat() {
        isOpen = !isOpen;
        aiContainer.classList.toggle('active', isOpen);
        aiIcon.classList.toggle('active', isOpen);
        
        // On first open, load welcome message and categories
        if (isOpen && aiMessages.children.length === 0) {
            loadWelcomeMessage();
            fetchCategories();
            fetchSuggestions();
        }
        
        // Focus the input field when opening
        if (isOpen) {
            setTimeout(() => aiInput.focus(), 300);
        }
    }
    
    // Process user input and send message
    aiSendBtn.addEventListener('click', sendMessage);
    aiInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    function sendMessage() {
        const message = aiInput.value.trim();
        
        if (message && !isTyping) {
            // Add user message to chat
            addMessage(message, 'user');
            
            // Clear input
            aiInput.value = '';
            
            // Show typing indicator
            showTypingIndicator();
            
            // Send to API and get response
            fetchAnswer(message);
        }
    }
    
    // Add a message to the chat
    function addMessage(message, sender) {
        const messageEl = document.createElement('div');
        messageEl.className = `ai-message ${sender}`;
        messageEl.innerHTML = `<p>${message}</p>`;
        
        aiMessages.appendChild(messageEl);
        scrollToBottom();
    }
    
    // Show typing indicator
    function showTypingIndicator() {
        isTyping = true;
        
        const typingEl = document.createElement('div');
        typingEl.className = 'ai-typing';
        typingEl.innerHTML = `
            <div class="ai-typing-dot"></div>
            <div class="ai-typing-dot"></div>
            <div class="ai-typing-dot"></div>
        `;
        
        aiMessages.appendChild(typingEl);
        scrollToBottom();
        
        return typingEl;
    }
    
    // Remove typing indicator
    function hideTypingIndicator() {
        const typingEl = aiMessages.querySelector('.ai-typing');
        if (typingEl) {
            typingEl.remove();
        }
        isTyping = false;
    }
    
    // Scroll to bottom of chat
    function scrollToBottom() {
        aiMessages.scrollTop = aiMessages.scrollHeight;
    }
    
    // Load welcome message
    function loadWelcomeMessage() {
        const welcomeMessage = `Hello! 👋 I'm Campus Navigator AI assistant. How can I help you today?`;
        
        // Add a slight delay to make it feel more natural
        setTimeout(() => {
            addMessage(welcomeMessage, 'bot');
        }, 500);
    }
    
    // Fetch AI answer from API
    function fetchAnswer(question) {
        // Define the endpoint
        const apiUrl = '../api/ai_assistant.php';
        
        // Create a typing indicator
        const typingIndicator = document.querySelector('.ai-typing');
        
        // Simulate network request
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                question: question
            })
        })
        .then(response => response.json())
        .then(data => {
            // Simulate a natural response time (min 1 second)
            setTimeout(() => {
                // Remove typing indicator
                hideTypingIndicator();
                
                // Add bot response
                if (data.status === 'success') {
                    addMessage(data.message, 'bot');
                } else {
                    addMessage("I'm sorry, I encountered an error. Please try again.", 'bot');
                }
                
                // Refetch suggestions
                fetchSuggestions(currentCategory);
            }, Math.max(1000, Math.random() * 1500));
        })
        .catch(error => {
            console.error('Error:', error);
            hideTypingIndicator();
            addMessage("I'm sorry, I couldn't connect to my knowledge base. Please try again later.", 'bot');
        });
    }
    
    // Fetch categories from API
    function fetchCategories() {
        const apiUrl = '../api/ai_assistant.php?action=get_categories';
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.categories && data.categories.length > 0) {
                    // Clear all categories except "All"
                    while (aiCategories.children.length > 1) {
                        aiCategories.removeChild(aiCategories.lastChild);
                    }
                    
                    // Add categories
                    data.categories.forEach(category => {
                        const categoryEl = document.createElement('div');
                        categoryEl.className = 'ai-category';
                        categoryEl.setAttribute('data-category', category);
                        categoryEl.textContent = category;
                        
                        categoryEl.addEventListener('click', function() {
                            // Set active class
                            document.querySelectorAll('.ai-category').forEach(cat => {
                                cat.classList.remove('active');
                            });
                            this.classList.add('active');
                            
                            // Update current category
                            currentCategory = category;
                            
                            // Fetch suggestions for this category
                            fetchSuggestions(category);
                        });
                        
                        aiCategories.appendChild(categoryEl);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
            });
    }
    
    // Fetch suggested questions
    function fetchSuggestions(category = null) {
        let apiUrl = '../api/ai_assistant.php?action=get_suggestions';
        if (category && category !== 'all') {
            apiUrl += `&category=${category}`;
        }
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // Clear existing suggestions
                aiSuggestions.innerHTML = '';
                
                if (data.suggestions && data.suggestions.length > 0) {
                    // Add suggestions
                    data.suggestions.forEach(suggestion => {
                        const suggestionEl = document.createElement('div');
                        suggestionEl.className = 'ai-suggestion';
                        suggestionEl.innerHTML = `
                            <i class="fas fa-question-circle"></i>
                            <span>${suggestion}</span>
                        `;
                        
                        suggestionEl.addEventListener('click', function() {
                            aiInput.value = suggestion;
                            sendMessage();
                        });
                        
                        aiSuggestions.appendChild(suggestionEl);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
            });
    }
    
    // Create dynamic introduction animation for the chat icon
    function animateIntroduction() {
        setTimeout(() => {
            aiIcon.classList.add('animate-attention');
            setTimeout(() => {
                aiIcon.classList.remove('animate-attention');
            }, 2000);
        }, 3000);
    }
    
    // Run introduction animation
    animateIntroduction();
}

// Detect if we need to fall back to a mock API (e.g., for local development without PHP)
function mockAPIFallback() {
    window.addEventListener('error', function(e) {
        if (e.target.tagName === 'SCRIPT' && e.target.src.includes('ai_assistant.php')) {
            console.warn('AI Assistant API not found, using mock data instead');
            initMockAPI();
        }
    }, true);
}

// Initialize mock API for testing without backend
function initMockAPI() {
    // Mock data for testing
    const mockCategories = ['general', 'application', 'scholarships', 'financial', 'admissions', 'account'];
    const mockSuggestions = {
        'general': [
            'How do I get started?',
            'What services do you offer?',
            'How can I contact support?',
            'Is my data secure?',
            'How accurate is your college data?'
        ],
        'application': [
            'What is the application deadline?',
            'How do I submit my application?',
            'Can I edit my application after submitting?',
            'What documents do I need?',
            'How long does the application process take?'
        ],
        'scholarships': [
            'How do I find scholarships?',
            'Am I eligible for scholarships?',
            'When do scholarship applications open?',
            'How competitive are the scholarships?',
            'Are there scholarships for international students?'
        ]
    };
    const mockAnswers = {
        'How do I get started?': 'To get started, create an account by clicking the "Sign Up" button in the top-right corner. Then complete your profile with your academic information and preferences.',
        'What is the application deadline?': 'Application deadlines vary by college. Most regular decision deadlines fall between January 1 and February 15, while early action/decision deadlines are typically in November.',
        'How do I find scholarships?': 'You can find scholarships by navigating to the "Scholarships" section from the main menu. There you can filter by eligibility criteria, amount, and deadline.'
    };
    
    // Override fetch for the AI assistant API
    const originalFetch = window.fetch;
    window.fetch = function(url, options) {
        if (url.includes('ai_assistant.php')) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    let response;
                    
                    if (url.includes('get_categories')) {
                        response = { categories: mockCategories };
                    } else if (url.includes('get_suggestions')) {
                        const category = new URL(url, window.location.href).searchParams.get('category');
                        const suggestions = category && mockSuggestions[category] ? 
                            mockSuggestions[category] : 
                            mockSuggestions['general'];
                        response = { suggestions };
                    } else if (options && options.body) {
                        const body = JSON.parse(options.body);
                        const question = body.question;
                        const answer = mockAnswers[question] || 
                            "I don't have specific information about that yet, but I'm learning! Please check our resources page or contact support for more help.";
                        response = { status: 'success', message: answer, response_time: 0.1 };
                    }
                    
                    resolve({
                        json: () => Promise.resolve(response),
                        ok: true
                    });
                }, 500);
            });
        }
        
        return originalFetch(url, options);
    };
}

// Call the mock API fallback function
mockAPIFallback(); 