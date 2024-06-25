// Function to load the cart and display its contents
function loadCart() {
    // Get the cart from local storage, or initialize an empty array if it doesn't exist
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Get the cart container element
    const cartContainer = document.getElementById('cart-container');

    // Clear the cart container
    cartContainer.innerHTML = '';

    // Iterate over the items in the cart and display each one
    cart.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('cart-item');
        itemDiv.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div class="cart-item-details">
                <h3>${item.name}</h3>
                <p>R${item.price}</p>
                <button class="remove-button" data-index="${index}">Remove</button>
            </div>
        `;
        cartContainer.appendChild(itemDiv);
    });

    // Update the cart count and total displayed on the page
    updateCartCount();
    updateCartTotal();

    // Set up event listeners for remove buttons
    setupRemoveButtons();
}

// Function to update the cart count displayed on the page
function updateCartCount() {
    // Get the cart from local storage, or initialize an empty array if it doesn't exist
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Update the cart count displayed on the page
    document.getElementById('cart-count').innerText = cart.length;
}

// Function to update the cart total displayed on the page
function updateCartTotal() {
    // Get the cart from local storage, or initialize an empty array if it doesn't exist
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Calculate the total price of all items in the cart
    const total = cart.reduce((sum, item) => sum + item.price, 0);

    // Update the cart total displayed on the page
    document.getElementById('cart-total').innerText = total.toFixed(2);
}

// Function to remove an item from the cart
function removeItemFromCart(index) {
    // Get the cart from local storage, or initialize an empty array if it doesn't exist
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Remove the item at the specified index from the cart array
    cart.splice(index, 1);

    // Update the cart in local storage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Reload the cart to reflect the changes
    loadCart();
}

// Function to set up event listeners for remove buttons
function setupRemoveButtons() {
    // Get all remove buttons
    const removeButtons = document.querySelectorAll('.remove-button');

    // Add event listener to each remove button
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the index of the item to be removed
            const index = parseInt(button.getAttribute('data-index'));
            // Removing the items from the cart
            removeItemFromCart(index);
        });
    });
}

// Function to handle the checkout process
function handleCheckout() {
    alert('Checkout functionality not yet implemented.');
}

// Load the cart when the page loads
document.addEventListener('DOMContentLoaded', loadCart);

// Set up event listener for checkout button
document.getElementById('checkout-button').addEventListener('click', handleCheckout);

