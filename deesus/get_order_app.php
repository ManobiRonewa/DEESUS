<?php
header("Content-Type: application/json; charset=UTF-8");

include "conn.php";
// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get the email from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($data['email']);

// SQL query to get user orders by email
$sql = "SELECT order_id, email, product_name, product_image, product_size, price, quantity, total, order_date 
        FROM orders 
        WHERE email = '$email'";

$result = $conn->query($sql);

// Check if any orders were found
if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row; 
    }
    echo json_encode($orders); 
} else {
    echo json_encode([]); 
}

// Close the connection
$conn->close();
?>