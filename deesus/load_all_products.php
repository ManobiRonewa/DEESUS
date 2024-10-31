<?php
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

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output each product as a grid item
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
                <button style="background-color:green" class="add-to-cart" data-title="' . $row["product_name"] . '" data-price="' . $row["price"] . '" data-image="' . $row["image_url"] . '">Add to Cart</button>
              </div>';
    }
} else {
    echo '<p>No products found.</p>';
}

$conn->close();
?>
