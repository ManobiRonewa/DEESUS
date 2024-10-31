<?php
// Start the session and include the database connection
session_start();
include "conn.php"; 

// Handle user deletion if the delete action is triggered
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Prepare the SQL statement to delete the user
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='admin_manage_users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
    }
}

// Handle making a user an admin if the make admin action is triggered
if (isset($_GET['make_admin_id'])) {
    $make_admin_id = intval($_GET['make_admin_id']);
    
    // Prepare the SQL statement to update the user role to admin
    $updateQuery = "UPDATE users SET role = 'admin' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $make_admin_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User role updated to admin successfully!'); window.location.href='admin_manage_users.php';</script>";
    } else {
        echo "<script>alert('Error updating user role: " . $conn->error . "');</script>";
    }
}

// Fetch only admin users from the database
$query = "SELECT * FROM users WHERE role = 'admin' ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:white;
            color: #333;
        }

        .container {
            width: 100%; /* Set width to 100% */
            padding: 0px;
            background-color: white;
        }

        h1 {
            text-align: start;
        }

        table {
            width: 100%; /* Ensure table is 100% width */
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions a {
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
        }

        .actions a.delete {
            background-color: #f44336;
        }

        /* Make the container scrollable */
        .scrollable {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 >Admin - Manage management</h1>

        <div class="scrollable">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>phone number</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $count =1;
                    // Check if users exist
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $count++. "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['calls'] . "</td>";
                            echo "<td>" . $row['role'] . "</td>";
                            echo "<td class='actions'>";

                            // Add the delete button
                            echo "<a href='admin_manage_users.php?delete_id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No admin users found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
