<?php
include "menu.php"; 
include "conn.php"; 

// Check if the user is logged in
if (!isset($_SESSION['login_'])) {
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to hold user data
$userData = null;

// Check if the user data exists
$query = "SELECT * FROM CheckoutInfo WHERE user_id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // User data found, fetch the data
    $userData = $result->fetch_assoc();
}

// Check if the form is submitted to save data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $first_name = $conn->real_escape_string($_POST['billing_firstname']);
    $last_name = $conn->real_escape_string($_POST['billing_lastname']);
    $id_number = $conn->real_escape_string($_POST['billing_id']);
    $address = $conn->real_escape_string($_POST['billing_address']);
    $city = $conn->real_escape_string($_POST['billing_city']);
    $card_number = $conn->real_escape_string($_POST['card_number']);
    $expiry_date = $conn->real_escape_string($_POST['expiry_date']);
    $terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0;

    // Check if the user already exists
    if ($userData) {
        $stmt = $conn->prepare("UPDATE CheckoutInfo SET first_name=?, last_name=?, id_number=?, address=?, city=?, card_number=?, expiry_date=?, terms_accepted=? WHERE user_id=?");
        $stmt->bind_param("sssssissi", $first_name, $last_name, $id_number, $address, $city, $card_number, $expiry_date, $terms_accepted, $user_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO CheckoutInfo (user_id, first_name, last_name, id_number, address, city, card_number, expiry_date, email, terms_accepted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssiss", $user_id, $first_name, $last_name, $id_number, $address, $city, $card_number, $expiry_date, $email, $terms_accepted);
        
    
    }

    if ($stmt->execute()) {
        echo "<script>alert('Order billing info is saved successfully!'); window.location.href='account-settings.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            display: block;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 1000px;
            border:none;
        }

        .tables {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tables  th, td {
            padding: 12px;
            text-align: center;
        }

        .tables  th {
            background-color: #4CAF50;
            color: white;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        .overlay, .popup {
            display: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            z-index: 11;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
<br><br>
<div class="container">
    <?php if ($userData): ?>

        <div class="container" style="width: 100%;text-align:stat;">
        <h3><?php   echo $_SESSION['login_'];?>'s billing  Informations to be used when checking out</h3>
        <table class="tables" style="width: 70rem;padding-left:0;margin-left:0px;margin-right:5%">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>ID Number</th>
                <th>Address</th>
                <th>City</th>
                <th>Card Number</th>
                <th>Expiry Date</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($userData['first_name']); ?></td>
                <td><?php echo htmlspecialchars($userData['last_name']); ?></td>
                <td><?php echo htmlspecialchars($userData['id_number']); ?></td>
                <td><?php echo htmlspecialchars($userData['address']); ?></td>
                <td><?php echo htmlspecialchars($userData['city']); ?></td>
                <td><?php echo htmlspecialchars($userData['card_number']); ?></td>
                <td><?php echo htmlspecialchars($userData['expiry_date']); ?></td>
            </tr>
        </table>
        <button type="button" style="width: 30%;" onclick="openPopup()">Update Details</button>
        </div>
    <?php else: ?>

        

       

        <h3>Billing Information settings</h3>
        <form action="" method="POST" style="text-align: start;">
            <div class="form-row">
                <div class="form-group">
                    <label for="billing-firstname">First Name:</label>
                    <input type="text" id="billing-firstname" name="billing_firstname" required>
                </div>
                <div class="form-group">
                    <label for="billing-lastname">Last Name:</label>
                    <input type="text" id="billing-lastname" name="billing_lastname" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="billing-ID">ID Number:</label>
                    <input type="text" id="billing-ID" name="billing_id" required>
                </div>
                <div class="form-group">
                    <label for="billing-address">Address:</label>
                    <input type="text" id="billing-address" name="billing_address" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="billing-city">City:</label>
                    <input type="text" id="billing-city" name="billing_city" required>
                </div>
                <div class="form-group">
                    <label for="card-number">Card Number:</label>
                    <input type="text" id="card-number" name="card_number" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="expiry-date">Expiry Date:</label>
                    <input type="text" id="expiry-date" name="expiry_date" required placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="terms-accepted">Accept Terms:</label>
                    <input type="checkbox" id="terms-accepted" name="terms_accepted">
                </div>
            </div>
            <button type="submit" name="place_order" style="width:30%">Save Details</button>
        </form>
    <?php endif; ?>

    <div id="overlay" class="overlay" onclick="closePopup()"></div>
    <div id="popupForm" class="popup">
        <h3>Update Billing Information</h3>
        <form action="" method="POST">
            <input type="text" name="billing_firstname" value="<?php echo htmlspecialchars($userData['first_name']); ?>">
            <input type="text" name="billing_lastname" value="<?php echo htmlspecialchars($userData['last_name']); ?>">
            <input type="text" name="billing_id" value="<?php echo htmlspecialchars($userData['id_number']); ?>">
            <input type="text" name="billing_address" value="<?php echo htmlspecialchars($userData['address']); ?>">
            <input type="text" name="billing_city" value="<?php echo htmlspecialchars($userData['city']); ?>">
            <input type="text" name="card_number" value="<?php echo htmlspecialchars($userData['card_number']); ?>">
            <input type="text" name="expiry_date" value="<?php echo htmlspecialchars($userData['expiry_date']); ?>">
            <button type="submit" name="place_order">Update</button>
        </form>
    </div>
</div>

<script>
    function openPopup() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popupForm').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('popupForm').style.display = 'none';
    }
</script>
<div style="width: 100%;"></div>
<?php 

include "footer.php";

?>
</body>
</html>
