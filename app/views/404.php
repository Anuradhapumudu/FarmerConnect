<?php require_once APPROOT . '/views/inc/minimalheader.php'; ?>

<!-- Main Content -->
<main style="flex: 1; display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 160px); padding: 20px;">
    <div class="container" style="text-align: center;">
        <!-- 404 Error Content -->
        <div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border-radius: 20px; padding: 60px 40px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); margin-bottom: 30px;">
            <!-- Large 404 Number -->
            <div style="font-size: 120px; font-weight: bold; color: var(--primary); text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px; line-height: 1;">
                404
            </div>
            
            <!-- Plant/Farm Icon -->
            <div style="font-size: 60px; color: var(--accent); margin-bottom: 30px;">
                <i class="fas fa-seedling"></i>
            </div>
            
            <!-- Main Error Message -->
            <h1 style="font-size: 2.5rem; color: var(--text-primary); margin-bottom: 20px; font-weight: 600;">
                Oops! Page Not Found
            </h1>
            
            <!-- Descriptive Message -->
            <p style="font-size: 1.2rem; color: var(--text-secondary); margin-bottom: 30px; line-height: 1.6;">
                The page you're looking for seems to have been harvested or moved to a different field. 
                Don't worry, we'll help you get back on track!
            </p>
            
            <!-- Action Buttons -->
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 40px;">
                <a href="<?php echo URLROOT; ?>" 
                   style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3); display: inline-flex; align-items: center; gap: 10px;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(46, 125, 50, 0.4)';"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(46, 125, 50, 0.3)';">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
                
                <button onclick="history.back()" 
                        style="background: rgba(255, 255, 255, 0.2); border: 2px solid var(--primary); color: var(--primary); padding: 15px 30px; border-radius: 25px; font-weight: 600; font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease; backdrop-filter: blur(10px); display: inline-flex; align-items: center; gap: 10px;"
                        onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.transform='translateY(-2px)';"
                        onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.color='var(--primary)'; this.style.transform='translateY(0)';">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </button>
            </div>
        </div>
        
        <!-- Additional Help Section -->
        <div style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border: 1px solid rgba(255, 255, 255, 0.3);">
            <h3 style="color: var(--text-primary); margin-bottom: 20px; font-size: 1.3rem;">
                <i class="fas fa-question-circle" style="color: var(--accent); margin-right: 10px;"></i>
                Need Help?
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 25px;">
                <a href="<?php echo URLROOT; ?>/FertilizerCalculator" class="card" style="text-decoration: none; padding: 20px; background: rgba(255, 255, 255, 0.6); border-radius: 10px; transition: all 0.3s ease; border: 1px solid rgba(0, 0, 0, 0.05);"
                   style="text-decoration: none; padding: 20px; background: rgba(255, 255, 255, 0.6); border-radius: 10px; transition: all 0.3s ease; border: 1px solid rgba(0, 0, 0, 0.05);"
                   onmouseover="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)';"
                   onmouseout="this.style.background='rgba(255, 255, 255, 0.6)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i class="fas fa-calculator" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; display: block;"></i>
                    <h4 style="color: var(--text-primary); margin-bottom: 5px; font-size: 1rem;">Fertilizer Calculator</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Calculate optimal fertilizer amounts</p>
                </a>
                
                <a href="<?php echo URLROOT; ?>/disease/viewReports" class="card" style="text-decoration: none; padding: 20px; background: rgba(255, 255, 255, 0.6); border-radius: 10px; transition: all 0.3s ease; border: 1px solid rgba(0, 0, 0, 0.05);"
                   style="text-decoration: none; padding: 20px; background: rgba(255, 255, 255, 0.6); border-radius: 10px; transition: all 0.3s ease; border: 1px solid rgba(0, 0, 0, 0.05);"
                   onmouseover="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)';"
                   onmouseout="this.style.background='rgba(255, 255, 255, 0.6)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i class="fas fa-bug" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; display: block;"></i>
                    <h4 style="color: var(--text-primary); margin-bottom: 5px; font-size: 1rem;">Disease Detector</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Identify and treat crop diseases</p>
                </a>
                
                <a href="<?php echo URLROOT; ?>/Knowledgecenter/KnowledgecenterFarmer" class="card" style="text-decoration: none; padding: 20px; background: rgba(255, 255, 255, 0.6); border-radius: 10px; transition: all 0.3s ease; border: 1px solid rgba(0, 0, 0, 0.05);"
                   style="text-decoration: none; padding: 20px; background: rgba(255, 255, 255, 0.6); border-radius: 10px; transition: all 0.3s ease; border: 1px solid rgba(0, 0, 0, 0.05);"
                   onmouseover="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)';"
                   onmouseout="this.style.background='rgba(255, 255, 255, 0.6)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i class="fas fa-book" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; display: block;"></i>
                    <h4 style="color: var(--text-primary); margin-bottom: 5px; font-size: 1rem;">Knowledge Center</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Learn farming best practices</p>
                </a>
            </div>
        </div>
    </div>
</main>

<!-- Custom CSS for 404 page -->
<style>
    /* Ensure the page takes full height */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        main > .container > div:first-child {
            padding: 40px 20px !important;
        }
        
        main > .container > div:first-child > div:first-child {
            font-size: 80px !important;
        }
        
        main > .container > div:first-child h1 {
            font-size: 2rem !important;
        }
        
        main > .container > div:first-child p {
            font-size: 1rem !important;
        }
        
        main > .container > div:first-child > div:nth-child(5) {
            flex-direction: column !important;
        }
        
        main > .container > div:last-child > div:last-child {
            grid-template-columns: 1fr !important;
        }
    }
    
    @media (max-width: 480px) {
        main > .container > div:first-child > div:first-child {
            font-size: 60px !important;
        }
        
        main > .container > div:first-child h1 {
            font-size: 1.8rem !important;
        }
        
        main > .container > div:first-child > div:nth-child(3) {
            font-size: 40px !important;
        }
    }
    
    /* Animation for the seedling icon */
    @keyframes gentle-sway {
        0%, 100% { transform: rotate(-2deg); }
        50% { transform: rotate(2deg); }
    }
    
    .fas.fa-seedling {
        animation: gentle-sway 3s ease-in-out infinite;
    }
    
    /* Hover effects for links */
    a[href*="<?php echo URLROOT; ?>"] {
        transition: all 0.3s ease !important;
    }
</style>

<script>
// Add some interactive behavior
document.addEventListener('DOMContentLoaded', function() {
    // Add a subtle parallax effect to the main error container
    const errorContainer = document.querySelector('main > .container > div:first-child');
    
    if (errorContainer) {
        window.addEventListener('mousemove', function(e) {
            const x = (e.clientX / window.innerWidth) * 100;
            const y = (e.clientY / window.innerHeight) * 100;
            
            errorContainer.style.transform = `translate(${(x - 50) * 0.02}px, ${(y - 50) * 0.02}px)`;
        });
    }
    
    // Add click sound effect simulation (visual feedback)
    const buttons = document.querySelectorAll('a, button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });
});
</script>

<?php require_once APPROOT . '/views/inc/minimalfooter.php'; ?>
