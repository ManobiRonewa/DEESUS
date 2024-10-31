<?php
// Set the Content-Type to application/json
header('Content-Type: application/json');
include "conn.php";
// Get the JSON input
$jsonInput = file_get_contents('php://input');
$data = json_decode($jsonInput, true);

if (isset($data['email'])) {
    $email = $conn->real_escape_string($data['email']);

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT full_name, email, card_number, city, expiry_year, id_number 
            FROM checkoutinfo 
            WHERE email = '$email' LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the associated row as an associative array
        $billingInfo = $result->fetch_assoc();

        // Return the billing information as JSON
        echo json_encode($billingInfo);
    } else {
        // No billing information found for the provided email
        echo json_encode(["error" => "No billing information found."]);
    }
} else {
    // Invalid request: email not provided
    echo json_encode(["error" => "Email is required."]);
}

// Close the connection
$conn->close();
?>
