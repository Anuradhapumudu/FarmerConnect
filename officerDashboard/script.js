/**
 * Main application script
 * Features:
 * - Real-time digital clock with precise second-by-second updates
 * - Animated number counters for statistics
 * - Responsive design considerations
 * - Enhanced error handling and performance optimization
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initClock();
    initAnimatedStats();
});

/**
 * Initialize and manage the real-time digital clock
 * Updates every second with precise timing synchronization
 */
function initClock() {
    let clockInterval;
    
    // Initial immediate update
    updateDateTime();
    
    // Calculate milliseconds until next second for precise timing
    const now = new Date();
    const msUntilNextSecond = 1000 - now.getMilliseconds();
    
    // Start with precise timing
    setTimeout(() => {
        updateDateTime();
        // Then continue with regular 1-second intervals
        clockInterval = setInterval(updateDateTime, 1000);
    }, msUntilNextSecond);
    
    function updateDateTime() {
        try {
            const now = new Date();
            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');
            
            if (dateElement) {
                const formattedDate = formatDate(now);
                if (dateElement.textContent !== formattedDate) {
                    dateElement.textContent = formattedDate;
                }
            }
            
            if (timeElement) {
                const formattedTime = formatTime(now);
                timeElement.textContent = formattedTime;
                
                // Add visual indicator for seconds update
                timeElement.style.opacity = '0.8';
                setTimeout(() => {
                    timeElement.style.opacity = '1';
                }, 50);
            }
        } catch (error) {
            console.error('Error updating clock:', error);
        }
    }
    
    function formatDate(date) {
        return date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    function formatTime(date) {
        return date.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });
    }
    
    // Optional: Alternative 24-hour format
    function formatTime24Hour(date) {
        return date.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });
    }
    
    // Clean up interval on page unload
    window.addEventListener('beforeunload', () => {
        if (clockInterval) {
            clearInterval(clockInterval);
        }
    });
    
    // Handle visibility change to maintain accuracy
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
            // Page became visible, update immediately
            updateDateTime();
        }
    });
}

//User account drop down menu functionality
function toggleMenu() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('open');
        }

        function menuAction(action) {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.remove('open');
            
            if (action === 'settings') {
                alert('Go to Settings');
            } else if (action === 'update') {
                alert('Update Account');
            } else if (action === 'signout') {
                if (confirm('Sign out?')) {
                    alert('Signed out!');
                }
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('dropdown');
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
/**
 * Initialize animated statistics counters
 */
function initAnimatedStats() {
    // Wait briefly to ensure smooth animation
    setTimeout(() => {
        animateStats();
    }, 500);
    
    function animateStats() {
        const statElements = document.querySelectorAll('.stat-value');
        const animationDuration = 2000; // 2 seconds
        const frameRate = 60; // frames per second
        const frameDuration = 1000 / frameRate;
        
        statElements.forEach(element => {
            const originalText = element.textContent.trim();
            const { prefix, value, suffix } = parseStatValue(originalText);
            
            if (isNaN(value)) return; // Skip non-numeric values
            
            animateValue({
                element,
                start: 0,
                end: value,
                duration: animationDuration,
                frameDuration,
                prefix,
                suffix,
                originalText
            });
        });
    }
    
    function parseStatValue(text) {
        // Handle currency values like "₹10L", "$1,000", "100K", etc.
        const currencyMatch = text.match(/^([^0-9]*)([\d,]+\.?\d*)([^0-9]*)$/);
        if (!currencyMatch) return { prefix: '', value: NaN, suffix: '' };
        
        const prefix = currencyMatch[1] || '';
        const suffix = currencyMatch[3] || '';
        const numericString = currencyMatch[2].replace(/,/g, '');
        let value = parseFloat(numericString);
        
        // Handle suffix multipliers (K, M, L, etc.)
        if (suffix.toUpperCase().includes('K')) value *= 1000;
        if (suffix.toUpperCase().includes('M')) value *= 1000000;
        if (suffix.toUpperCase().includes('L')) value *= 100000; // Lakh
        if (suffix.toUpperCase().includes('CR')) value *= 10000000; // Crore
        
        return { prefix, value, suffix };
    }
    
    function animateValue(config) {
        let startTimestamp = null;
        
        function step(timestamp) {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / config.duration, 1);
            
            // Ease-out function for smooth deceleration
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const currentValue = Math.floor(easedProgress * (config.end - config.start) + config.start);
            
            // Update the element with formatted number
            const formattedValue = currentValue.toLocaleString();
            config.element.textContent = config.prefix + formattedValue + config.suffix;
            
            // Continue animation if not complete
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                // Ensure final value is exactly the original text
                config.element.textContent = config.originalText;
            }
        }
        
        requestAnimationFrame(step);
    }
}

/**
 * Additional utility functions for enhanced clock functionality
 */

// Function to create a more advanced digital clock display
function createAdvancedClock(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    container.innerHTML = `
        <div class="digital-clock">
            <div class="time-display">
                <span id="hours">00</span>
                <span class="separator blink">:</span>
                <span id="minutes">00</span>
                <span class="separator blink">:</span>
                <span id="seconds">00</span>
                <span id="ampm">AM</span>
            </div>
            <div class="date-display">
                <span id="weekday">Monday</span>,
                <span id="month">January</span>
                <span id="day">1</span>,
                <span id="year">2024</span>
            </div>
        </div>
    `;
    
    function updateAdvancedClock() {
        const now = new Date();
        
        // Update time components
        let hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        
        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be 12
        
        // Update elements
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        document.getElementById('ampm').textContent = ampm;
        
        // Update date components
        const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June',
                       'July', 'August', 'September', 'October', 'November', 'December'];
        
        document.getElementById('weekday').textContent = weekdays[now.getDay()];
        document.getElementById('month').textContent = months[now.getMonth()];
        document.getElementById('day').textContent = now.getDate();
        document.getElementById('year').textContent = now.getFullYear();
    }
    
    // Initial update
    updateAdvancedClock();
    
    // Update every second
    setInterval(updateAdvancedClock, 1000);
}

/**
 * Utility function to check if element exists
 */
function elementExists(selector) {
    return document.querySelector(selector) !== null;
}

