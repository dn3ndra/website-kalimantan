document.addEventListener('DOMContentLoaded', function() {
    // Get all links that have a hash (#) in them
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the target element
            const targetId = this.getAttribute('href');
            if (targetId === '#') return; // Skip if href is just "#"
            
            const targetElement = document.querySelector(targetId);
            if (!targetElement) return; // Skip if target element doesn't exist
            
            // Get header height for offset
            const headerHeight = document.querySelector('header').offsetHeight;
            
            // Calculate scroll position
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerHeight;
            
            // Smooth scroll to target
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            // If it's a dropdown menu item, close the dropdown
            const dropdown = this.closest('.dropdown');
            if (dropdown) {
                dropdown.classList.remove('active');
            }
        });
    });
}); 