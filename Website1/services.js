// services.js
function addToCart(name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push({ name, price, image });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        cartCount.innerText = cart.length;
    }
}

function ensureCartDialogStyles() {
    if (document.getElementById('cart-modal-styles')) {
        return;
    }

    const style = document.createElement('style');
    style.id = 'cart-modal-styles';
    style.textContent = `
        #cart-modal-dialog {
            border: 4px solid #1ef03d;
            border-radius: 12px;
            padding: 0;
            width: calc(100% - 24px);
            max-width: 760px;
            overflow: hidden;
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.35);
        }

        #cart-modal-dialog::backdrop {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #cart-modal-dialog .cart-modal-shell {
            position: relative;
        }

        #cart-modal-dialog .cart-modal-close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.92);
            cursor: pointer;
            font-size: 20px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    `;

    if (document.head) {
        document.head.appendChild(style);
    } else {
        document.documentElement.appendChild(style);
    }
}

function ensureCartDialog() {
    const existing = document.getElementById('cart-modal-dialog');
    if (existing) {
        return existing;
    }

    ensureCartDialogStyles();

    const dialog = document.createElement('dialog');
    dialog.id = 'cart-modal-dialog';
    dialog.innerHTML = `
        <div class="cart-modal-shell">
            <button type="button" class="cart-modal-close" data-cart-modal-close aria-label="Close">×</button>
            <section id="cart-section" class="section1">
                <h1>Shopping Cart</h1>
                <div id="cart-container"></div>
                <div id="cart-total-container">
                    <h2>Total: R<span id="cart-total">0.00</span></h2>
                </div>
                <button id="checkout-button">Checkout</button>
            </section>
        </div>
    `;

    document.body.appendChild(dialog);

    const closeButton = dialog.querySelector('[data-cart-modal-close]');
    if (closeButton) {
        closeButton.addEventListener('click', () => dialog.close());
    }

    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    return dialog;
}

function loadScriptOnce(src) {
    if (!window.__scriptOnce) {
        window.__scriptOnce = {};
    }

    if (window.__scriptOnce[src]) {
        return window.__scriptOnce[src];
    }

    window.__scriptOnce[src] = new Promise((resolve, reject) => {
        const existing = document.querySelector(`script[src="${src}"]`);
        if (existing) {
            resolve();
            return;
        }

        const script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.onload = () => resolve();
        script.onerror = () => reject(new Error(`Failed to load ${src}`));
        document.body.appendChild(script);
    });

    return window.__scriptOnce[src];
}

function initCartModal() {
    if (window.__cartModalInitialized) {
        return;
    }
    window.__cartModalInitialized = true;

    document.addEventListener(
        'click',
        async (event) => {
            const link = event.target.closest('a[href]');
            if (!link) {
                return;
            }

            let url;
            try {
                url = new URL(link.href, window.location.href);
            } catch {
                return;
            }

            const pathname = url.pathname.toLowerCase();
            const isCartLink = pathname.endsWith('/cart.html');
            if (!isCartLink) {
                return;
            }

            const currentPath = window.location.pathname.toLowerCase();
            if (currentPath.endsWith('/cart.html')) {
                return;
            }

            event.preventDefault();

            const dialog = ensureCartDialog();
            if (typeof dialog.showModal === 'function') {
                dialog.showModal();
            } else {
                window.location.href = link.getAttribute('href') || 'cart.html';
                return;
            }

            try {
                await loadScriptOnce('cart.js');
            } catch {
                return;
            }

            if (typeof window.loadCart === 'function') {
                window.loadCart();
            }
        },
        true
    );
}

function ensureContactDialogStyles() {
    if (document.getElementById('contact-modal-styles')) {
        return;
    }

    const style = document.createElement('style');
    style.id = 'contact-modal-styles';
    style.textContent = `
        #contact-modal-dialog {
            border: 4px solid #1ef03d;
            border-radius: 12px;
            padding: 0;
            width: calc(100% - 24px);
            max-width: 640px;
            overflow: hidden;
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.35);
            background: #fff;
        }

        #contact-modal-dialog::backdrop {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #contact-modal-dialog .contact-modal-shell {
            position: relative;
            padding: 26px 26px 22px;
        }

        #contact-modal-dialog .contact-modal-close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.92);
            cursor: pointer;
            font-size: 20px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #contact-modal-dialog h1 {
            margin: 0 0 18px;
            font-family: Arial, sans-serif;
            font-size: 44px;
            text-decoration: underline;
            color: darkgreen;
            text-align: center;
        }

        #contact-modal-dialog .info {
            font-family: Arial, sans-serif;
            color: darkgreen;
            font-size: 26px;
            line-height: 1.35;
        }

        #contact-modal-dialog .info i {
            font-style: normal;
        }
    `;

    if (document.head) {
        document.head.appendChild(style);
    } else {
        document.documentElement.appendChild(style);
    }
}

function ensureContactDialog() {
    const existing = document.getElementById('contact-modal-dialog');
    if (existing) {
        return existing;
    }

    ensureContactDialogStyles();

    const dialog = document.createElement('dialog');
    dialog.id = 'contact-modal-dialog';
    dialog.innerHTML = `
        <div class="contact-modal-shell">
            <button type="button" class="contact-modal-close" data-contact-modal-close aria-label="Close">×</button>
            <h1>Contact Us</h1>
            <div class="info">
                <div><i class="fa-solid fa-phone"></i> 083 379 5799</div>
                <br>
                <div><i class="fa-solid fa-fax"></i> 086 605 0269</div>
                <br>
                <div><i class="fa-solid fa-envelope"></i> tskele@igugulethu.co.za</div>
                <div><i class="fa-solid fa-envelope"></i> admin@igugulethu.co.za</div>
                <br>
                <div><i class="fa-solid fa-location-dot"></i> 26 Diamond Drive,<br>Pebble Rock Estate,<br>Kameelfontein,<br>0039</div>
            </div>
        </div>
    `;

    document.body.appendChild(dialog);

    const closeButton = dialog.querySelector('[data-contact-modal-close]');
    if (closeButton) {
        closeButton.addEventListener('click', () => dialog.close());
    }

    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    return dialog;
}

function initContactModal() {
    if (window.__contactModalInitialized) {
        return;
    }
    window.__contactModalInitialized = true;

    document.addEventListener(
        'click',
        (event) => {
            const link = event.target.closest('a[href]');
            if (!link) {
                return;
            }

            let url;
            try {
                url = new URL(link.href, window.location.href);
            } catch {
                return;
            }

            const pathname = url.pathname.toLowerCase();
            const isContactLink = pathname.endsWith('/contact.html');
            if (!isContactLink) {
                return;
            }

            const currentPath = window.location.pathname.toLowerCase();
            if (currentPath.endsWith('/contact.html')) {
                return;
            }

            event.preventDefault();

            const dialog = ensureContactDialog();
            if (typeof dialog.showModal === 'function') {
                dialog.showModal();
            } else {
                window.location.href = link.getAttribute('href') || 'contact.html';
            }
        },
        true
    );
}

function ensureLogoutDialogStyles() {
    if (document.getElementById('logout-confirm-styles')) {
        return;
    }

    const style = document.createElement('style');
    style.id = 'logout-confirm-styles';
    style.textContent = `
        #logout-confirm-dialog {
            border: none;
            border-radius: 12px;
            padding: 24px;
            width: calc(100% - 32px);
            max-width: 440px;
        }

        #logout-confirm-dialog::backdrop {
            background: rgba(0, 0, 0, 0.55);
        }

        #logout-confirm-dialog h2 {
            margin: 0 0 18px;
            font-family: Arial, sans-serif;
            font-size: 22px;
        }

        #logout-confirm-dialog .logout-confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        #logout-confirm-dialog button {
            border-radius: 8px;
            padding: 10px 14px;
            border: 1px solid #cfcfcf;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        #logout-confirm-dialog button[type="submit"] {
            background: orangered;
            color: #fff;
            border-color: orangered;
        }
    `;

    if (document.head) {
        document.head.appendChild(style);
    } else {
        document.documentElement.appendChild(style);
    }
}

function ensureLogoutDialog() {
    const existing = document.getElementById('logout-confirm-dialog');
    if (existing) {
        return existing;
    }

    ensureLogoutDialogStyles();

    const dialog = document.createElement('dialog');
    dialog.id = 'logout-confirm-dialog';
    dialog.innerHTML = `
        <form method="post" id="logout-confirm-form">
            <h2>Do you want to log out?</h2>
            <div class="logout-confirm-actions">
                <button type="button" data-logout-cancel>No, stay</button>
                <button type="submit" name="Logout-button">Yes, log out</button>
            </div>
        </form>
    `;

    document.body.appendChild(dialog);

    const cancelButton = dialog.querySelector('[data-logout-cancel]');
    if (cancelButton) {
        cancelButton.addEventListener('click', () => dialog.close());
    }

    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    return dialog;
}

function initLogoutModal() {
    if (window.__logoutModalInitialized) {
        return;
    }
    window.__logoutModalInitialized = true;

    document.addEventListener(
        'click',
        (event) => {
            const link = event.target.closest('a[href]');
            if (!link) {
                return;
            }

            let url;
            try {
                url = new URL(link.href, window.location.href);
            } catch {
                return;
            }

            const pathname = url.pathname.toLowerCase();
            const isLogoutLink =
                pathname.endsWith('/logout.php') || pathname.endsWith('/admin-logout.php');

            if (!isLogoutLink) {
                return;
            }

            const hrefAttr = link.getAttribute('href');
            if (!hrefAttr) {
                return;
            }

            event.preventDefault();

            const dialog = ensureLogoutDialog();
            const form = dialog.querySelector('#logout-confirm-form');
            if (form) {
                form.action = hrefAttr;
            }

            if (typeof dialog.showModal === 'function') {
                dialog.showModal();
            } else {
                window.location.href = hrefAttr;
            }
        },
        true
    );
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    initCartModal();
    initContactModal();
    initLogoutModal();
});
