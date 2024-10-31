<?php 
include "menu.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            padding: 40px;
            text-align: center;
        }

        .login-form h1 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form h1 img {
            margin-right: 10px;
        }

        .login-form label {
            font-weight: bold;
            color: #333;
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .login-form input {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }

        .forgot-password {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
            display: block;
            text-align: right;
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .signup-link {
            text-align: center;
            font-size: 14px;
            color: #333;
            margin-top: 20px;
        }

        .signup-link a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-container" style="margin-left:30%;margin-right:30%;">

    <!-- Login Form Section -->
    <div class="login-form">
        <h1>
            Login to Deesus
        </h1>
        <form action="check.php" method="post" style="text-align: start;">
            <!-- Email Input -->
            <label for="email">Email</label>
            <input type="text" <?php if(!empty($_SESSION['email_'])){ echo "value='". $_SESSION['email_'] ."'"; } ?> placeholder="Enter Email" name="email" required>

            <!-- Password Input -->
            <label for="psw">Password</label>
            <input type="password" placeholder="Enter Password" name="password" required>

        
            <!-- Error Message for Incorrect Login -->
            <?php if(!empty($_SESSION['email_'])) { echo "<p style='color:red'>Incorrect username or password</p>"; } $_SESSION['email_'] = ""; ?>

            <!-- Submit Button -->
            <button type="submit" class="btn">Login</button>

            <!-- Signup Link -->
            <div class="signup-link">
                <p>Don't have an account? <a href="register">Sign up here</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>
<?php 
include "footer.php";
?>