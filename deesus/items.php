<div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: center; background-color: white; padding: 0px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

<?php 
// Include the connection script
session_start();
include "conn.php";

// Your email from the session
$email = $_SESSION['email'];

// Query to fetch products
$query = "SELECT * FROM products;";
$done = mysqli_query($conn, $query);

// Initialize product count
$count = 0;

// Loop through products
while ($row = mysqli_fetch_array($done)) {
    // Count products
    $count++;
?>
    <div style="height:auto;margin: 1%; text-align: center; color: #333; background-color: #f9f9f9; border-radius: 5px;  width: 250px;">
        <img style="width: 100%; height: 350px; border-radius: 5px;" src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['product_name']; ?>"/>

        <p style="font-weight: bold; margin: 10px 0;"><?php echo $row['product_name']; ?></p>
        
        <p style="color: #28a745;">Price: R<?php echo number_format($row['price'], 2); ?></p>

        <div style="margin-top: 10px;">
            <a href="edit.php?dd=<?php echo $row['id']; ?>" style="text-decoration: none; color: #007bff; padding: 5px 10px; border: 1px solid #007bff; border-radius: 5px; margin-right: 5px;">Edit</a>
            <a href="action.php?dd=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" style="text-decoration: none; color: #fff; background-color: #dc3545; padding: 5px 10px; border-radius: 5px;">Delete</a>
        </div><br><br>
    </div>

<?php
}
?>

</div>
