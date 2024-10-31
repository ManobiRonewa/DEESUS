<?php 
//then connect
include "conn.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Existing login functionality
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare statement to prevent SQL injection
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Check if the password matches
            if (password_verify($password, $row['password'])) {
                // Return user data as JSON
                echo json_encode($row);
            } else {
                // Incorrect password
                echo json_encode(["error" => "Incorrect password"]);
            }
        } else {
            // User not found
            echo json_encode(["error" => "User not found"]);
        }
    }
    
    if (isset($_POST['email']) && isset($_POST['title'])) {
        // Sanitize and get the email and product details
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $size = filter_var($_POST['size'], FILTER_SANITIZE_STRING);
        $price = floatval($_POST['price']);
        $quantity = intval($_POST['quantity']);
        $image="images/prod2.png";
        $item_total= $quantity * $price;
      // SQL query to insert order data into the 'orders' table
      $sql = "INSERT INTO orders (email, product_name, product_image, product_size, price, quantity, total) 
      VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare and bind parameters to prevent SQL injection
if ($stmt = $connect->prepare($sql)) {
  $stmt->bind_param("ssssdii", $email, $title, $image, $size, $price, $quantity, $item_total);

  // Execute the statement and check for success
  if ($stmt->execute()) {
    // Assuming success, send a response back to the Kotlin app
    echo "Product $title added successfully for $email.";
  } else {
         // Handle the case where required fields are missing
         echo "Error: network problem.";
  }
  // Close the prepared statement
  $stmt->close();
} 
        
    
    } else {
        // Handle the case where required fields are missing
        echo "Error: Missing required fields.";
    }
    
       
 
    


}



?>