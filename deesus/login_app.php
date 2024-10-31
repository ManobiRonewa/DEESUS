<?php
// get the database connion
include "conn.php";


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handling JSON data for user registration
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        // Prepare statement to prevent SQL injection
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($row = mysqli_fetch_assoc($result)) {
            // Check if the password matches
            if (password_verify($password, $row['password'])) {
                // Return user data as JSON
                echo json_encode($row);  // You might want to exclude sensitive data like password
            } else {
                // Incorrect password
                echo json_encode(["error" => "Incorrect password"]);
            }
        } else {
            // User not found
            echo json_encode(["error" => "User not found"]);
        }
    } else {
        echo json_encode(["error" => "Email and password must be provided"]);
    }
    

}
?>