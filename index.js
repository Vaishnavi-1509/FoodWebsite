document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    const mobileMenu = document.querySelector('.mobilemenu');
    const mobileNav = document.querySelector('.mobilenav');

    mobileMenu.addEventListener('click', () => {
        mobileNav.classList.toggle('active');
    });

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('nav a, .mobilenav a');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const href = e.target.getAttribute('href');
            
            if (href.startsWith('#')) {
                const targetId = href.slice(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth' });

                    // Close mobile navigation after clicking a link
                    if (mobileNav.classList.contains('active')) {
                        mobileNav.classList.remove('active');
                    }
                }
            } else {
                // If the link is for an external page (like 'order.html'), navigate to that page
                window.location.href = href;
            }
        });
    });

    const orderForm = document.getElementById('orderForm');

    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Retrieve form data
            const formData = new FormData(orderForm);
            const items = [];

            // Build a list of selected items
            formData.forEach(function(value, key) {
                items.push(`${key}: ${value}`);
            });

            // Example: Display order confirmation (you can customize this part)
            alert(`Order placed successfully!\nItems:\n${items.join('\n')}`);

            // Reset the form after submission
            orderForm.reset();
        });
    }

    const seeMenuBtn = document.getElementById('menubtn');
    
    if (seeMenuBtn) {
        seeMenuBtn.addEventListener('click', () => {
            window.location.href = 'menu.html';
        });
    }

    const seeorderBtn = document.getElementById('speciality');
    
    if (seeorderBtn) {
        seeorderBtn.addEventListener('click', () => {
            window.location.href = 'order.html';
        });
    }
});
