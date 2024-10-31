<?php

include "menu.php";
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "deesus";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add item to the cart
function addToCart($productTitle, $productPrice, $productImage, $productSize) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $productExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['title'] === $productTitle && $item['size'] === $productSize) {
            $item['quantity'] += 1;
            $productExists = true;
            break;
        }
    }

    if (!$productExists) {
        $_SESSION['cart'][] = [
            'title' => $productTitle,
            'price' => $productPrice,
            'quantity' => 1,
            'image' => $productImage,
            'size' => $productSize // Add size here
        ];
    }
}

// Handle AJAX request to add an item to the cart
if (isset($_POST['action']) && $_POST['action'] == 'add_to_cart') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image = $_POST['image']; // Get image URL from POST data
    $size = $_POST['size']; // Get size from POST data
    
    addToCart($title, $price, $image, $size);
    echo json_encode(['success' => true]);

    exit;
}

// Handle AJAX request to update cart item quantity
if (isset($_POST['action']) && $_POST['action'] == 'update_cart') {
    $title = $_POST['title'];
    $size = $_POST['size'];
    $quantityChange = intval($_POST['quantity']);

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['title'] === $title && $item['size'] === $size) { 
                $item['quantity'] += $quantityChange;
                if ($item['quantity'] <= 0) {
                    $key = array_search($item, $_SESSION['cart']);
                    if ($key !== false) {
                        unset($_SESSION['cart'][$key]);
                    }
                }
                break;
            }
        }
    }
    echo json_encode(['success' => true]);
    exit;
}

// Handle AJAX request to clear cart
if (isset($_POST['action']) && $_POST['action'] == 'clear_cart') {
    unset($_SESSION['cart']);
    
    echo json_encode(['success' => true]);

    exit;
}
$count = 0;

// HTML and CSS for the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Black & White Products</title>
    <style>
        body {
            background-color: #f9f9f9; /* Light background */
            color: #333; /* Dark text for contrast */
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
            justify-content: space-between;
            width: 100%;
            background-color: white;
        }

        .product-item {
            padding: 20px;
            border-radius: 8px;
            width: 20%;
            background-color: white;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .product-thumbnail {
            border-radius: 8px;
            width: 100%;
            height: auto;
        }

        .product-title {
            font-size: 1.2em;
            margin: 10px 0;
        }

        .product-price {
            font-size: 1.1em;
            margin-bottom: 10px;
            color: #4CAF50; /* Green color for price */
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50; /* Green background */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        .cart {
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff; /* White background for cart */
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .cart h2 {
            margin-top: 0;
            color: #4CAF50; /* Green color for cart title */
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th {
            padding: 15px;
            text-align: left;
            background-color: #4CAF50; /* Green header */
            color: #ffffff; /* White text */
            font-size: 1.2em;
        }

        .cart-table td {
            padding: 15px;
            text-align: left;
            color: #000;
            background-color: #ffffff; /* White for table rows */
        }

        .cart-item-thumbnail {
            width: 100%;
            height: auto;
            max-height: 100px;
            border-radius: 10%;
            object-fit: cover;
        }

        .cart-action {
            text-align: center;
        }

        .total-amount {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
            color: #4CAF50; /* Green for total amount */
        }

        .checkout-button {
            padding: 10px 20px;
            background-color: #4CAF50; /* Green button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        .checkout-button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body style="background-color: white;">
<!-- Header Section -->
<section  id="page-header" style="background-image: url(images/about/banner.png);height:5rem" class="about-header">
    <h2>cart</h2>

</section>
<!-- Cart Section -->
<div class="cart">
    
    <table class="cart-table" style="border:none;background-color:white">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Title</th>
                <th>Product Size</th>
                <th>Product Price Each</th>
                <th>Product Price For All</th>
                <th>Product Quantity</th>
                <th>Edit product</th>
            </tr>
        </thead>
        <tbody id="cart-items" style="border: 1px solid transparent; ">
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $cartItem) {
                    $count++;
                    $total += $cartItem['price'] * $cartItem['quantity'];
                    echo '<tr style="border: 1px solid transparent; ">
                        <td style="text-align:center;border: 1px solid transparent;"  >
                            <img src="' . $cartItem['image'] . '" class="cart-item-thumbnail" style="width: 100%;height:8rem">
                        </td>
                        <td style="border: 1px solid transparent; ">' . $cartItem['title'] . '</td>
                        <td style="border: 1px solid transparent; ">' . $cartItem['size'] . '</td>
                        <td style="border: 1px solid transparent; ">R' . $cartItem['price'] . '</td>
                        <td style="border: 1px solid transparent; ">R' . $cartItem['price'] * $cartItem['quantity'] . '</td>
                        <td style="border: 1px solid transparent; "><span>' . $cartItem['quantity'] . '</span></td>
                        <td style="border: 1px solid transparent; ">
                            <button class="decrease-quantity" data-title="' . $cartItem['title'] . '" data-size="' . $cartItem['size'] . '">-</button>
                            <button class="increase-quantity" data-title="' . $cartItem['title'] . '" data-size="' . $cartItem['size'] . '">+</button>
                        </td>
                    </tr>';
                }
                echo '<tr style="border-left: 1px solid transparent; ">
                        <td colspan="4" class="total-amount" style="border-left: 1px solid transparent;border-right: 1px solid transparent;border-top: 1px solid grey; ">Total: R' . $total . '</td>
                      </tr>';
            } else {
                echo '<tr><td colspan="7">Your cart is empty.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <div style="width:100%;display:flex">
        <?php if ($count > 0) { ?>
            <button onclick="openss()" id="checkout" class="checkout-button">Checkout</button>
        <?php } ?>
        <button id="clear-cart" class="checkout-button">Clear Cart</button>
        <button onclick="opens()" class="checkout-button">Shop</button>
    </div>
</div>

<!-- Notification container -->
<div id="notification" style="position: fixed; top: 10px; right: 10px; background-color: #333; color: #fff; padding: 10px; border-radius: 5px; display: none; z-index: 1000;">
</div>

<!-- JavaScript for AJAX -->
<script>
    function opens() {
        window.location.href = "shop";
    }
    function openss() {
        window.location.href = "checkout";
    }

    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.add-to-cart');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const price = this.getAttribute('data-price');
                const image = this.getAttribute('data-image');
                const size = this.closest('tr').querySelector('td:nth-child(3)').textContent; // Assuming size is in the 3rd column

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            showNotification('Item added to cart successfully!');
                            updateCart();
                        }
                    }
                };
                xhr.send(`action=add_to_cart&title=${title}&price=${price}&image=${image}&size=${size}`); // Include size here
            });
        });

        const clearCartButton = document.getElementById('clear-cart');
        clearCartButton.addEventListener('click', function() {

            window.location.href = "cart.php";  
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showNotification('Cart cleared successfully!');
                      
                     updateCart();
                       
                    }
                }
            };
            xhr.send(`action=clear_cart`);
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('increase-quantity')) {
                const title = event.target.getAttribute('data-title');
                const size = event.target.closest('tr').querySelector('td:nth-child(3)').textContent; // Get size from the table
                updateItemQuantity(title, size, 1);
                window.location.href="cart.php";
            }

            if (event.target.classList.contains('decrease-quantity')) {
                const title = event.target.getAttribute('data-title');
                const size = event.target.closest('tr').querySelector('td:nth-child(3)').textContent; // Get size from the table
                updateItemQuantity(title, size, -1);

                window.location.href="cart.php";
            }
        });

        function updateItemQuantity(title, size, change) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        updateCart();
                    }
                }
            };
            xhr.send(`action=update_cart&title=${title}&size=${size}&quantity=${change}`); // Include size here
        }
    });

    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    function updateCart() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'cart.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('cart-items').innerHTML = xhr.responseText;

                window.location.href="cart.php";
            }
        };
        xhr.send();
    }
</script>

</body>
</html>
<?php 

include "footer.php";
?>