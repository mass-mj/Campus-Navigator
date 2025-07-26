// Cost Calculator JavaScript

// Preloader
window.addEventListener('load', function() {
    setTimeout(function() {
        document.querySelector('.preloader').classList.add('preloader-finish');
    }, 500);
});

// Mobile menu
function showMenu() {
    document.getElementById('navLinks').classList.add('active');
}

function hideMenu() {
    document.getElementById('navLinks').classList.remove('active');
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

// Get all input values
function getInputValues() {
    return {
        tuition: parseFloat(document.getElementById('tuition').value) || 0,
        fees: parseFloat(document.getElementById('fees').value) || 0,
        housing: parseFloat(document.getElementById('housing').value) || 0,
        mealPlan: parseFloat(document.getElementById('mealPlan').value) || 0,
        books: parseFloat(document.getElementById('books').value) || 0,
        supplies: parseFloat(document.getElementById('supplies').value) || 0,
        transportation: parseFloat(document.getElementById('transportation').value) || 0,
        parking: parseFloat(document.getElementById('parking').value) || 0,
        personal: parseFloat(document.getElementById('personal').value) || 0,
        entertainment: parseFloat(document.getElementById('entertainment').value) || 0,
        scholarships: parseFloat(document.getElementById('scholarships').value) || 0,
        grants: parseFloat(document.getElementById('grants').value) || 0
    };
}

// Calculate total costs
function calculateCosts() {
    const values = getInputValues();
    
    // Calculate total expenses
    const totalExpenses = values.tuition + values.fees + values.housing + 
                         values.mealPlan + values.books + values.supplies + 
                         values.transportation + values.parking + 
                         values.personal + values.entertainment;
    
    // Calculate total financial aid
    const totalAid = values.scholarships + values.grants;
    
    // Calculate net cost
    const netCost = Math.max(0, totalExpenses - totalAid);
    
    // Calculate monthly payment (assuming 12 months)
    const monthlyPayment = netCost / 12;
    
    // Update results with animations
    updateResult('totalCost', totalExpenses);
    updateResult('netCost', netCost);
    updateResult('monthlyPayment', monthlyPayment);
    
    // Save calculation to localStorage
    saveCalculationToStorage(values, totalExpenses, netCost, monthlyPayment);
}

// Update result with animation
function updateResult(elementId, value) {
    const element = document.getElementById(elementId);
    const startValue = parseFloat(element.textContent.replace(/,/g, '')) || 0;
    const endValue = value;
    const duration = 1000; // 1 second
    const startTime = performance.now();
    
    function animate(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // Easing function for smooth animation
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        
        const currentValue = startValue + (endValue - startValue) * easeOutQuart;
        element.textContent = formatCurrency(currentValue);
        
        if (progress < 1) {
            requestAnimationFrame(animate);
        }
    }
    
    requestAnimationFrame(animate);
}

// Reset calculator
function resetCalculator() {
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.value = '';
    });
    
    // Reset results
    document.getElementById('totalCost').textContent = '0';
    document.getElementById('netCost').textContent = '0';
    document.getElementById('monthlyPayment').textContent = '0';
    
    // Clear saved calculation
    localStorage.removeItem('lastCalculation');
}

// Save calculation
function saveCalculation() {
    const values = getInputValues();
    const totalExpenses = values.tuition + values.fees + values.housing + 
                         values.mealPlan + values.books + values.supplies + 
                         values.transportation + values.parking + 
                         values.personal + values.entertainment;
    const totalAid = values.scholarships + values.grants;
    const netCost = Math.max(0, totalExpenses - totalAid);
    const monthlyPayment = netCost / 12;
    
    // Save to localStorage
    saveCalculationToStorage(values, totalExpenses, netCost, monthlyPayment);
    
    // Show success message
    showNotification('Calculation saved successfully!');
}

// Save calculation to localStorage
function saveCalculationToStorage(values, totalExpenses, netCost, monthlyPayment) {
    const calculation = {
        values,
        totalExpenses,
        netCost,
        monthlyPayment,
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem('lastCalculation', JSON.stringify(calculation));
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Add styles dynamically
    notification.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #4a6cf7;
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        animation: slideIn 0.3s ease forwards;
    `;
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add notification animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Load last saved calculation
document.addEventListener('DOMContentLoaded', function() {
    const savedCalculation = localStorage.getItem('lastCalculation');
    if (savedCalculation) {
        const calculation = JSON.parse(savedCalculation);
        
        // Fill in input values
        Object.entries(calculation.values).forEach(([key, value]) => {
            const input = document.getElementById(key);
            if (input) {
                input.value = value;
            }
        });
        
        // Update results
        document.getElementById('totalCost').textContent = formatCurrency(calculation.totalExpenses);
        document.getElementById('netCost').textContent = formatCurrency(calculation.netCost);
        document.getElementById('monthlyPayment').textContent = formatCurrency(calculation.monthlyPayment);
    }
}); 