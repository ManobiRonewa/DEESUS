<!DOCTYPE html>
<html lang="en">
<head>

<?php
// Start the session (if needed) and include your database connection
session_start();
include "conn.php"; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $calls = htmlspecialchars(trim($_POST['calls']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert the new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, calls, password, role) VALUES (?, ?, ?, ?, 'admin')");
    $stmt->bind_param("ssss", $name, $email, $calls, $hashed_password);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Admin registered successfully!'); window.location.href='admin_manage_users.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        .login-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-left: 15%;
            margin-right: 15%;
        }
        .login-form {
            width: 100%;
            padding: 40px;
            display: flex;
            flex-direction: column;
        }
        .login-form h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }
        .login-form label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .login-form input {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }
        .login-form .btn-submit {
            padding: 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container" style="border:none; box-shadow:none;">
        <div class="login-form">
            <h1>
                Add admin
            </h1>
            <!-- Signup Form -->
            <form action="admins.php" method="post" style="text-align: start;">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Enter Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>

                <div class="form-group">
                    <label for="calls">Phone Number</label>
                    <input type="tel" name="calls" placeholder="Enter Phone Number" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Font Awesome Icons (for social buttons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
