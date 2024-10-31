<?php
// Start the session and include the database connection
include "menu.php";
include "conn.php"; 

// Check if the user is logged in
if (!isset($_SESSION['login_'])) {
    header("Location: login.php"); 
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user information from the database
$stmt = $conn->prepare("SELECT name, email, calls, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="style.css" rel="stylesheet"> 
    
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; 
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px; 
            margin: auto;
            background: white; 
            border-radius: 8px; 
            padding: 20px;
            border:none;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-info {
            display: flex;
            align-items: center; 
            margin-bottom: 20px; 
        }
        .profile-info img {
            border-radius: 50%; 
            width: 80px; 
            height: 80px; 
            margin-right: 20px; 
        }
        .profile-table {
            width: 100%; 
            border-collapse: collapse; 
            border:none;
        }
        .profile-table td {
            padding: 10px; 
            vertical-align: top; 
            border: none; 
            font-size: 16px; 
        }
    </style>
</head>
<body>
    <br><br>
    <br><br><br><br>
    <div class="container">
        <h1><?php echo htmlspecialchars($user['name']); ?>'s  Profile information</h1>
        <div class="profile-info">
            <img src="https://www.w3schools.com/w3images/avatar1.png" alt="User Icon"> <!-- User Icon -->
            <table class="profile-table">
                <tr>
                    <td><strong>Name</strong></td>
                    <td>: <?php echo htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>:<?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <td><strong>Phone Number</strong></td>
                    <td>:<?php echo htmlspecialchars($user['calls']); ?></td>
                </tr>
                <tr>
                    <td><strong>Role</strong></td>
                    <td>:<?php echo htmlspecialchars($user['role']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body><?php 
include "footer.php";
?>
</html>
