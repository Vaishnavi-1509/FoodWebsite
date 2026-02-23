document.addEventListener('DOMContentLoaded', () => {
    const mobileMenu = document.querySelector('.mobilemenu');
    const mobileNav = document.querySelector('.mobilenav');

    if (mobileMenu && mobileNav) {
        mobileMenu.addEventListener('click', () => {
            mobileNav.classList.toggle('active');
        });
    }

    const navLinks = document.querySelectorAll('nav a, .mobilenav a');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const url = new URL(link.href, window.location.origin);
            const isSamePage = url.pathname === window.location.pathname;
            if (isSamePage && url.hash) {
                e.preventDefault();
                const targetSection = document.getElementById(url.hash.slice(1));
                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth' });
                    if (mobileNav && mobileNav.classList.contains('active')) {
                        mobileNav.classList.remove('active');
                    }
                }
            }
        });
    });

    const setActiveLinks = () => {
        navLinks.forEach(link => {
            const url = new URL(link.href, window.location.origin);
            const isSamePath = url.pathname === window.location.pathname;
            const hasMatchingHash = !url.hash || url.hash === window.location.hash;
            if (isSamePath && hasMatchingHash) {
                link.classList.add('active');
            }
        });
    };
    setActiveLinks();

    const CART_KEY = 'fw_cart';

    const getCart = () => {
        try {
            return JSON.parse(localStorage.getItem(CART_KEY)) || [];
        } catch (e) {
            return [];
        }
    };

    const saveCart = (cart) => {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        updateCartCount();
    };

    const formatPrice = (value) => `$${value.toFixed(2)}`;

    const updateCartCount = () => {
        const cart = getCart();
        const count = cart.reduce((sum, item) => sum + item.qty, 0);
        const badge = document.getElementById('cartCount');
        const mobileBadge = document.getElementById('mobileCartCount');
        if (badge) badge.textContent = count;
        if (mobileBadge) mobileBadge.textContent = count;
    };

    const addToCart = (item) => {
        const cart = getCart();
        const existing = cart.find(cartItem => cartItem.id === item.id);
        if (existing) {
            existing.qty += item.qty;
        } else {
            cart.push(item);
        }
        saveCart(cart);
    };

    const removeFromCart = (id) => {
        const cart = getCart().filter(item => item.id !== id);
        saveCart(cart);
    };

    const updateQty = (id, qty) => {
        const cart = getCart();
        const target = cart.find(item => item.id === id);
        if (target) {
            target.qty = qty;
            saveCart(cart);
        }
    };

    const renderCart = () => {
        const cartItemsEl = document.getElementById('cartItems');
        const cartEmptyEl = document.getElementById('cartEmpty');
        const cartTotalEl = document.getElementById('cartTotal');
        if (!cartItemsEl || !cartTotalEl || !cartEmptyEl) return;

        const cart = getCart();
        cartItemsEl.innerHTML = '';

        if (cart.length === 0) {
            cartEmptyEl.classList.remove('hidden');
        } else {
            cartEmptyEl.classList.add('hidden');
        }

        let total = 0;
        cart.forEach(item => {
            total += item.price * item.qty;
            const row = document.createElement('div');
            row.className = 'cart-row';
            row.dataset.id = item.id;
            row.innerHTML = `
                <div class="cart-info">
                    <div class="cart-title">${item.title}</div>
                    <div class="cart-price">${formatPrice(item.price)}</div>
                </div>
                <div class="cart-controls">
                    <input type="number" min="1" class="cart-qty" value="${item.qty}">
                    <button type="button" class="btn btn-secondary remove-item">Remove</button>
                </div>
            `;
            cartItemsEl.appendChild(row);
        });

        cartTotalEl.textContent = formatPrice(total);
    };

    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const item = {
                id: Number(button.dataset.id),
                title: button.dataset.title,
                price: Number(button.dataset.price),
                qty: 1
            };
            addToCart(item);
            const original = button.textContent;
            button.textContent = 'Added';
            button.disabled = true;
            setTimeout(() => {
                button.textContent = original;
                button.disabled = false;
            }, 900);
        });
    });

    if (window.prefillItem) {
        addToCart({
            id: Number(window.prefillItem.id),
            title: window.prefillItem.title,
            price: Number(window.prefillItem.price),
            qty: 1
        });
        if (window.history && window.history.replaceState) {
            window.history.replaceState({}, document.title, 'order.php');
        }
    }

    renderCart();
    updateCartCount();

    const cartItemsEl = document.getElementById('cartItems');
    if (cartItemsEl) {
        cartItemsEl.addEventListener('input', (e) => {
            if (e.target.classList.contains('cart-qty')) {
                const row = e.target.closest('.cart-row');
                const id = Number(row.dataset.id);
                const qty = Math.max(1, Number(e.target.value));
                e.target.value = qty;
                updateQty(id, qty);
                renderCart();
            }
        });

        cartItemsEl.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item')) {
                const row = e.target.closest('.cart-row');
                const id = Number(row.dataset.id);
                removeFromCart(id);
                renderCart();
            }
        });
    }

    const clearCartBtn = document.getElementById('clearCart');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', () => {
            saveCart([]);
            renderCart();
        });
    }

    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        orderForm.addEventListener('submit', (e) => {
            const cart = getCart();
            if (cart.length === 0) {
                e.preventDefault();
                alert('Your cart is empty. Please add items from the menu.');
                return;
            }
            const cartInput = document.getElementById('cartJson');
            if (cartInput) {
                cartInput.value = JSON.stringify(cart);
            }
        });
    }
});
