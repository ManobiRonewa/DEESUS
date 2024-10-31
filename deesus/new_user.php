<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the database connection
include "conn.php"; 

// Set the content type to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $raw_data = file_get_contents('php://input');
    parse_str($raw_data, $data); // Parse the URL-encoded data

    // Extract variables
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insert into the database
    $query = "INSERT INTO `users` (`id`, `name`, `email`, `calls`, `password`, `role`) VALUES (NULL, '$name', '$email', '$phone', '$password', 'user')";
    $result = mysqli_query($conn, $query);

    // Prepare the response
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to register user']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
