<?php
session_start(); // Start the session

// Check if the 'testing' session contains any data
if (isset($_SESSION['testing']) && !empty($_SESSION['testing'])) {
    echo "<h2>Products Stored in Session</h2>";
    
    // Begin the HTML table
    echo "<table border='1' cellpadding='10'>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Product Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>";
    
    // Loop through each product stored in the session and display its details
    foreach ($_SESSION['testing'] as $product) {
        echo "<tr>
                <td>{$product['email']}</td>
                <td>{$product['product_name']}</td>
                <td><img src='{$product['product_image']}' alt='Product Image' width='50' height='50'></td>
                <td>{$product['product_size']}</td>
                <td>{$product['price']}</td>
                <td>{$product['quantity']}</td>
                <td>{$product['total']}</td>
              </tr>";
    }

    // End the table
    echo "</tbody></table>";
} else {
    // If no data is stored in the session
    echo "<p>No products found in session.</p>";
}
?>
