<?php
session_start();
include "conn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $calls = mysqli_real_escape_string($conn, $_POST['calls']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the users table
    $sql = "INSERT INTO users (name, email, calls, password,role) VALUES ('$name', '$email', '$calls', '$hashed_password','user')";

    if ($conn->query($sql) === TRUE) {


        $_SESSION['login_'] =$name;
        $_SESSION['email'] =$email;
        $_SESSION['role'] ="user";
        echo "<script>	window.location.href='index';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>