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

// Function to add item to the cart with size
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
            'size' => $productSize,
            'image' => $productImage
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
    $quantityChange = intval($_POST['quantity']);
    $size = $_POST['size'];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Black & White Products</title>
    <style>
        /* Classic styling for the product grid and cart */
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-around;
            padding: 20px;
            background-color: white;
            color: grey;
        }
        .product-item {
            padding: 15px;
            border-radius: 6px;
            width: 23%;
            background-color: #fff;
            text-align: center;
            border: none;
        }
        .product-thumbnail {
            border-radius: 6px;
            width: 100%;
            height: 350px;
        }
        .product-title {
            font-size: 1.1em;
            margin: 15px 0 10px;
            color: #333;
        }
        .product-price {
            font-size: 1em;
            margin-bottom: 15px;
            color: #666;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .cart {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .cart h2 {
            margin-top: 0;
            font-size: 1.3em;
            color: #333;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th, .cart-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .cart-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .cart-item-thumbnail {
            width: 50px;
            height: auto;
        }
        .cart-action {
            text-align: center;
        }
        .total-amount {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }
        .checkout-button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            display: block;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .checkout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<?php 

// Get the full URL path
$urlPath = $_SERVER['REQUEST_URI'];

// Break the path into segments
$pathSegments = explode('/', $urlPath);

// The page title might be the last segment, for example
$pageTitle = end($pathSegments);

// Remove any query parameters from the last segment (if present)
$pageTitle = strtok($pageTitle, '?');

//echo $pageTitle; // Output the title


?>
  <div class="search-container" style="width: 100%; margin-top: 0px; background-color: black; border-radius: 8px; margin-bottom: 200px; position: fixed; text-align: center;">
        <input type="text" id="search" placeholder="Search for products..." style="padding: 12px 20px; width: 50%; border: none; font-size: 16px; outline: none; transition: border-color 0.3s ease;">
    </div>
    <br><br>
    <div class="container" style="background-color: white; border: none;">
        <!-- Product Grid -->
        <div class="product-grid">
            <?php
            // Fetch products from the database
            $sql = "SELECT brand, product_name, image_url, price FROM products ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">
                            <img src="' . $row["image_url"] . '" class="product-thumbnail">
                            <h3 class="product-title">' . $row["product_name"] . '</h3>
                          <h3 style="display: inline-flex; justify-content: center; gap: 15px; align-items: center; width: 100%; margin: 20px 0;">
    <label style="cursor: pointer;">
        <input name="size" type="radio" value="S" style="margin-right: 5px;"> S
    </label>  
    <label style="cursor: pointer;">
        <input name="size" type="radio" value="M" style="margin-right: 5px;"> M
    </label>  
    <label style="cursor: pointer;">
        <input name="size" type="radio" value="X" style="margin-right: 5px;"> X
    </label>  
    <label style="cursor: pointer;">
        <input name="size" type="radio" value="XX" style="margin-right: 5px;"> XX
    </label>
</h3>
   <strong class="product-price">R' . $row["price"] . '</strong><br>
    <br>                     
                            <button class="add-to-cart" data-title="' . $row["product_name"] . '" data-price="' . $row["price"] . '" data-image="' . $row["image_url"] . '" style="background-color:green">Add to Cart</button>
                          </div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>

        <!-- Notification container -->
        <div id="notification" style="position: fixed; top: 10px; right: 10px; background-color: #333; color: #fff; padding: 10px; border-radius: 5px; display: none; z-index: 1000;"></div>

        <!-- JavaScript for AJAX -->
        <script>

const searchInput = document.getElementById('search');

// Event listener for search input
searchInput.addEventListener('keyup', function() {
    const query = searchInput.value.trim(); // Trim to avoid unnecessary white spaces

    if (query.length > 0) { // Start searching after 2 characters
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_products.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText.trim() === '') {
                    document.querySelector('.product-grid').innerHTML = '<p>No products found.</p>';
                } else {
                    document.querySelector('.product-grid').innerHTML = xhr.responseText;
                }
            }
        };
        xhr.send(`query=${encodeURIComponent(query)}`);
    } else {
        // If the search field is empty, load all products
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'load_all_products.php', true); // Assuming you have a PHP file to load all products
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.querySelector('.product-grid').innerHTML = xhr.responseText;
            }
        };
        xhr.send(); // No query is sent since we are loading all products
    }
});

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.add-to-cart');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    const price = this.getAttribute('data-price');
                    const image = this.getAttribute('data-image');
                    const selectedSize = this.parentNode.querySelector('input[name="size"]:checked');

                    if (!selectedSize) {
                       // showNotification('Please select a size.');
                       alert("Please select a size for "+title );
                        return;
                    }

                    const size = selectedSize.value;

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                showNotification('Added to cart: ' + title);
                            }
                        }
                    };
                    xhr.send('action=add_to_cart&title=' + encodeURIComponent(title) + '&price=' + encodeURIComponent(price) + '&image=' + encodeURIComponent(image) + '&size=' + encodeURIComponent(size));
                });
            });
        });

        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.display = 'block';

            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
        }
        </script>
    </div>
</body>
</html>

<?php
include "footer.php";
$conn->close();


?>
