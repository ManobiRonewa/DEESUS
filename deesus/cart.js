// Function to update the cart badge number
function updateCartBadge(quantity) {
    const cartBadge = document.getElementById('cart-badge');
    // Update the badge text content with the new quantity
    cartBadge.textContent = quantity;
}

// Example usage: Update the cart badge when an item is added
function addToCart(item) {
    // Get the current quantity of items in the cart
    let currentQuantity = getCartQuantity();
    currentQuantity += 1; // Increment the quantity
    updateCartBadge(currentQuantity);
    
    // Additional logic for adding the item to the cart can go here
}

// Function to get the current quantity of items from the cart badge
function getCartQuantity() {
    const cartBadge = document.getElementById('cart-badge');
    // Parse the current quantity from the badge's text content
    let currentQuantity = parseInt(cartBadge.textContent, 10);
    // If the badge's text content is not a number, set the quantity to 0
    return isNaN(currentQuantity) ? 0 : currentQuantity;
}

// Example call to add an item to the cart
addToCart();
