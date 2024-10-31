
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
        }
        
        /* Top Bar Navigation */
        .top-bar {
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        /* Logo */
        .top-bar .logo {
            display: flex;
            align-items: center;
        }
        
        .top-bar .logo img {
            border-radius: 50%;
            height: 40px;
            margin-right: 10px;
        }

        /* Navigation Links */
        .top-bar nav {
            display: flex;
            gap: 20px;
        }
        
        .top-bar nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .top-bar nav a:hover {
            background-color: #575757;
        }

        /* Main Content Area */
        #main-content {
            padding: 0px; background-color: white;
        }

        /* Iframe Styling */
        iframe {
            border: none;
            width: 100%;
            height: 90vh;
            background-color: white;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <!-- Logo Section -->
        <div class="logo">
Deesus            <span style="margin-left: 2rem;"><?php echo $_SESSION['login_']; ?></span>
        </div>

        <!-- Navigation Links -->
        <nav>
            <a href="javascript:void(0)" onclick="navigate('landing_admin.php')">Income Report</a>
            <a href="javascript:void(0)" onclick="navigate('admin_manage_users')"> Admins</a>
            <a href="javascript:void(0)" onclick="navigate('tables_item.php?on=yes')">Add product</a>
            <a href="javascript:void(0)" onclick="navigate('items.php?on=no')">View product</a>
           
            <a href="javascript:void(0)" onclick="navigate('add_blog.php')">add blog</a>
            <a href="javascript:void(0)" onclick="navigate('view_blog.php')">View blog</a>
            <a href="javascript:void(0)" onclick="navigate('admins.php')">Add Admins</a>
            <a href="index.php">Deesus market</a>
        </nav>
    </div>

    <!-- Main Content with Iframe -->
    <div id="main-content" >
        <iframe id="iframe-content" src="landing_admin.php"></iframe>
    </div>

    <script>
        // Function to navigate iframe content
        function navigate(url) {
            document.getElementById("iframe-content").src = url;
        }
    </script>
</body>
</html>

<!-- Footer -->
<footer style="background-color: #333; color: white; padding: 20px 0; text-align: center; font-size: 14px;">
    <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
        <!-- Footer Links -->
        <a href="#" style="color: white; text-decoration: none;">Privacy Policy</a>
        <a href="#" style="color: white; text-decoration: none;">Terms of Service</a>
        <a href="#" style="color: white; text-decoration: none;">Help & Support</a>
    </div>
    
    <div style="margin-top: 10px;">
        &copy; <?php echo date("Y"); ?>Deesus All rights reserved.
    </div>
</footer>
