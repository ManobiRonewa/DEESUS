<?php  
include "menu.php"; 
include "conn.php"; 

// Delete order if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    echo "<script>window.location.href='history';</script>";
}

// Retrieve orders from the database
$query = "SELECT * FROM orders WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']); // Get orders for logged in user based on email
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS for consistency -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green background for header */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey background for even rows */
        }

        tr:hover {
            background-color: #ddd; /* Highlight row on hover */
        }

        .delete-btn {
            background-color: #ff4d4d; /* Red background for delete button */
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: darkred; /* Darker red on hover */
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #888;
        }
    </style>
</head>
<body>

    <h1>My Orders</h1>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Product Size</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>

        <?php 
        // Check if any orders exist
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' width='50' height='50' alt='Product Image'></td>";
                echo "<td>" . htmlspecialchars($row['product_size']) . "</td>";
                echo "<td>R" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                echo "<td>R" . htmlspecialchars($row['total']) . "</td>";
                echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
                echo "<td><a class='delete-btn' href='history?delete_id=" . $row['order_id'] . "' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='no-orders'>No orders found.</td></tr>";
        }
        ?>
    </table>

</body><br><br>
</html>
<?php 
include "footer.php";
?>
