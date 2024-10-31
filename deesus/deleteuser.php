<?php
header("Content-Type: application/json; charset=UTF-8");
include "conn.php"; 


// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? '';

if ($id) {
    // SQL statement to delete the user by ID
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo json_encode(array("success" => "User deleted successfully."));
    } else {
        echo json_encode(array("error" => "Failed to delete user."));
    }

    $stmt->close();
} else {
    echo json_encode(array("error" => "User ID not provided."));
}

$conn->close();
?>
