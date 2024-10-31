<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "deesus";
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form input
$email = $_POST['email'];
$password = $_POST['password']; // User-entered password

// Prepare SQL statement (we only need to fetch the hashed password and user data)
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if a user was found with that email
if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify the hashed password stored in the database
    if (password_verify($password, $user['password'])) {
        /* Password matches
        echo "ID: " . $user["id"] . "<br>";
        echo "Name: " . $user["name"] . "<br>";
        echo "Email: " . $user["email"] . "<br>";
        echo "Calls: " . $user["calls"] . "<br>";
*/ 
if($user["role"]=="admin"){
    $_SESSION['role'] = $user["role"];
    $_SESSION['login_'] = $user["name"];
    $_SESSION['email'] = $user["email"];
    $_SESSION['user_id'] =   $user["id"];

    echo "<script>	window.location.href='admin';</script>";

}else if($user["role"]=="user"){
        $_SESSION['role'] = $user["role"];
        $_SESSION['login_'] = $user["name"];
        $_SESSION['email'] = $user["email"];
        $_SESSION['user_id'] =   $user["id"];
        echo "<script>	window.location.href='history';</script>";

}
       
     
    } else {
        // No user found with that email
    $_SESSION['email_'] =$email;
    echo "<script>	window.location.href='login';</script>";
    }
} else {
    // No user found with that email
    $_SESSION['email_'] =$email;
    echo "<script>	window.location.href='login';</script>";
}

// Close the statement and connection
$stmt->close();

?>
