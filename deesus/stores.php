<?php
header("Content-Type: application/json; charset=UTF-8");
include "conn.php"; 

// Define image directory path and allowed file types
$imageDir = "images/";
$allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];

// Check if all required POST fields are received
if (isset($_POST['title'], $_POST['price'], $_POST['total_added']) && !empty($_FILES['image_url']['tmp_name'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $totalAdded = filter_var($_POST['total_added'], FILTER_VALIDATE_INT);

    // Validate the uploaded image file
    $imageTmpName = $_FILES['image_url']['tmp_name'];
    $imageName = basename($_FILES['image_url']['name']);
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if (!in_array($imageExt, $allowedFileTypes)) {
        echo json_encode(["success" => false, "message" => "Invalid file type. Allowed types: jpg, jpeg, png, gif."]);
        exit;
    }

    $imagePath = $imageDir . time() . "_" . $imageName;

    if (move_uploaded_file($imageTmpName, $imagePath)) {
        // Image upload successful; insert record into database
        $imageURL = $conn->real_escape_string($imagePath);
        
        $sql = "INSERT INTO products (product_name, image_url, price) VALUES ('$title', '$imageURL', $price)";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Product added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error adding product: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload image."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Incomplete data received."]);
}

// Close database connection
$conn->close();
?>
