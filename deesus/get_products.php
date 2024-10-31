<?php
header("Content-Type: application/json; charset=UTF-8");

include "conn.php";

// SQL query to fetch products
$sql = "SELECT id, product_name, image_url, price FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $products[] = array(
            "id" => $row["id"],
            "title" => $row["product_name"],
            "image_url" => $row["image_url"],
            "price" => $row["price"],
            "total_added" =>100
        );
    }
}

// Close connection
$conn->close();

// Return JSON response
echo json_encode($products);
?>
