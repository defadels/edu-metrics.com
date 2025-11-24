import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements with fade-in-up class
    const animatedElements = document.querySelectorAll('.animate-fade-in-up');
    
    animatedElements.forEach((element, index) => {
        const delay = element.style.animationDelay || '0s';
        setTimeout(() => {
            element.style.opacity = '1';
        }, parseFloat(delay) * 1000 || index * 100);
    });
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn-modern');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});
