<?php 
include "menu.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            max-width: 600px;
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

        .btn-submit {
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

        .btn-submit:hover {
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

        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="login-container" style="margin-left:30%;margin-right:30%;">
    <div class="login-form">
        <h1>
            Register to Deesus
        </h1>

        <!-- Signup Form -->
        <form action="signup.php" method="post" style="text-align: start;">
            <div class="row">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Enter Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="calls">Phone Number</label>
                    <input type="text" name="calls" placeholder="Enter Phone Number" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Sign Up</button>
            </div>
        </form>

        <!-- Signup Link -->
        <div class="signup-link">
            <p>Have an account? <a href="login">Login</a></p>
        </div>
    </div>
</div>

</body>
</html>
<?php 
include "footer.php";
?>