<?php
include "menu.php"; 
include "conn.php"; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['login_'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch saved billing address for the user
$stmt = $conn->prepare("SELECT * FROM checkoutinfo WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$billing_info = [];
if ($result->num_rows > 0) {
    $billing_info = $result->fetch_assoc();
}

// Example: Fetching cart items from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate the total amount from the cart
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity']; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 20px;
        }
        .Checkout {
            text-align: center;
            margin-bottom: 30px;
        }
        h1 {
            color: #4CAF50;
            font-size: 28px;
            margin: 0;
        }
        h4 {
            font-size: 16px;
            color: #999;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col-75, .col-25 {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .col-75 {
            flex: 3;
        }
        .col-25 {
            flex: 1;
        }
        .container {
            padding: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .price {
            color: #4CAF50;
            font-weight: bold;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .cart-summary {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            padding-top: 10px;
        }
        .cart-summary p {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-summary .price {
            color: #4CAF50;
        }
        .show-confirm {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="Checkout" style="border:none;box-shadow:none"><br>
        <h1>Checkout</h1>
        <h4>billing info</h4>
    </div>

    <div class="row"  style="border:none;box-shadow:none">
        <div class="col-75"  style="border:none;box-shadow:none;background-color:white">
            <div class="container" style="border:none;box-shadow:none;background-color:white">
                <form method="post" action="action_page.php">
                    <h3>Billing Address</h3>
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="firstname" placeholder="Percy Karabo" 
                           value="<?php echo isset($billing_info['first_name']) ? htmlspecialchars($billing_info['first_name']) : ''; ?>" required>
                    
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lastname" placeholder="Percy" 
                           value="<?php echo isset($billing_info['last_name']) ? htmlspecialchars($billing_info['last_name']) : ''; ?>" required>
                    
                    <label for="adr">Address</label>
                    <input type="text" id="adr" name="address" placeholder="9 Nombhela Cres Vosloorus" 
                           value="<?php echo isset($billing_info['address']) ? htmlspecialchars($billing_info['address']) : ''; ?>" required>
                    
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Johannesburg" 
                           value="<?php echo isset($billing_info['city']) ? htmlspecialchars($billing_info['city']) : ''; ?>" required>
                    
                    <div class="row">
                        <div class="col-50">
                            <label for="id_number">ID Number</label>
                            <input type="text" id="id_number" name="id_number" placeholder="1234567890" 
                                   value="<?php echo isset($billing_info['id_number']) ? htmlspecialchars($billing_info['id_number']) : ''; ?>" required>
                        </div>
                        <div class="col-50">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" 
                                   value="<?php echo isset($billing_info['expiry_date']) ? htmlspecialchars($billing_info['expiry_date']) : ''; ?>" required>
                        </div>
                    </div>

                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9123 4567" 
                           value="<?php echo isset($billing_info['card_number']) ? htmlspecialchars($billing_info['card_number']) : ''; ?>" required>

                </form>
            </div>
        </div>

        <div class="col-25" style="border:none;box-shadow:none;background-color:white">
            <div class="container"  style="border:none;box-shadow:none;background-color:white">
                <h4>Cart
                    <span class="price">
                        <i class="fa fa-shopping-cart"></i>
                        <b><?php echo count($cart); ?></b>
                    </span>
                </h4>
                <?php foreach ($cart as $item): ?>
                    <p><a><?php echo htmlspecialchars($item['title']); ?></a> <span class="price">R<?php echo htmlspecialchars($item['price']); ?></span></p>
                <?php endforeach; ?>
                <hr>
                <div class="cart-summary">
                    <p>Total <span class="price">R<?php echo $total; ?></span></p>
                </div>                <form method="post" action="action_page.php">

                <button class="show-confirm" onclick="openCForm()">Place Order</button>
            </form>
            </div>
        </div>
    </div>

  
</body>
</html>
<?php 
include "footer.php";
?>