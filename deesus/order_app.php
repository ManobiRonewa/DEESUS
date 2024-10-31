<?php
include "conn.php";

// Set the content type to application/json
header('Content-Type: application/json');

// Enable CORS if necessary
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Retrieve the raw POST data
$inputJSON = file_get_contents('php://input');

// Log the raw JSON input for debugging
error_log("Received JSON: " . $inputJSON);

// Decode the JSON payload into a PHP associative array
$input = json_decode($inputJSON, true);

// Check if the necessary fields are present in the request
if (isset($input['email']) && isset($input['products'])) {
    $email = $input['email'];
    $products = $input['products'];

    // Log the email and number of products
    error_log("Email: $email");
    error_log("Number of products: " . count($products));

    // Initialize a response array
    $response = [];

    // Loop through each product in the products array
    foreach ($products as $product) {
        // Extract product details
        $product_name = $product['title'];
        $product_image = "images/prod2.png"; // Modify this as necessary
        $product_size = $product['size'];
        $price = $product['price'];
        $quantity = $product['quantity'];
        $total = $price * $quantity; // Calculate total

        // Log product details before insertion
        error_log("Inserting product: $product_name, Size: $product_size, Price: $price, Quantity: $quantity, Total: $total");

        // SQL query to insert product details into the orders table
        $query = "INSERT INTO orders (email, product_name, product_image, product_size, price, quantity, total) 
                  VALUES ('$email', '$product_name', '$product_image', '$product_size', $price, $quantity, $total)";

        // Execute the query (assuming you have a database connection established)
        if (mysqli_query($conn, $query)) {
            // If successful, add success message to the response array
            $response[] = ["product_name" => $product_name, "status" => "success"];
            // Add product to session
            session_start(); // Start session if not already started
            $_SESSION['testing'][] = [
                'email' => $email,
                'product_name' => $product_name,
                'product_image' => $product_image,
                'product_size' => $product_size,
                'price' => $price,
                'quantity' => $quantity,
                'total' => $total
            ];
            error_log("Product successfully inserted: $product_name");
        } else {
            // If error, add error message to the response array
            $response[] = ["product_name" => $product_name, "status" => "error", "error" => mysqli_error($conn)];
            // Log MySQL error
            error_log("MySQL Error: " . mysqli_error($conn));
        }
    }

    // Send back the response as JSON
    echo json_encode($response);

} else {
    // If the expected fields are not found in the request
    error_log("Invalid input data: " . json_encode($input));
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}
?>
