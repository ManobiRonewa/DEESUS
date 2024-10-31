<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css"/>
  <script src="https://kit.fontawesome.com/d388045308.js" crossorigin="anonymous"></script>

  <?php session_start(); ?>
  <link href="style.css" rel="stylesheet">
  <title>Basic Couture</title>

  <style>
    body {
      background-color: white;
      margin: 0;
      font-family: Arial, sans-serif;
      padding-top: 60px; /* To prevent content hiding under the fixed navbar */
    }
    .menu_php_navbar {
      background-color: black; 
      padding: 10px 20px;
      position: fixed; 
      top: 0; 
      left: 0; 
      right: 0; 
      z-index: 1000;
      display: flex;
      align-items: center;
      height: 60px; /* Adjusted to a more compact height */
    }
    .menu_php_logo {
      font-size: 24px; 
      font-weight: bold;
      margin-right: 20px;
    }
    .menu_php_a {
      text-decoration: none;
      color: white;
      font-size: 18px; 
      transition: color 0.3s;
    }
    .menu_php_a:hover {
      color: gray;
    }
    .menu_php_ul {
      list-style: none; 
      margin: 0;
      padding: 0; 
      display: flex;
      align-items: center;
      flex: 1;
    }
    .menu_php_li {
      margin: 0 10px; /* To give more breathing room between items */
    }
    .menu_php_user-icon {
      border-radius: 50%; 
      width: 40px; 
      height: 40px;
    }
    .menu_php_buttons {
      display: flex;
      align-items: center;
    }
    .menu_php_cart {
      font-size: 32px; 
      color: green;
      margin-right: 20px;
    }
    .menu_php_button {
      padding: 10px 15px;
      background-color: black; 
      color: white; 
      border: none; 
      cursor: pointer;
      margin-left: 10px; /* Add space between buttons */
    }

    @media (max-width: 768px) {
      .menu_php_navdiv {
        flex-direction: column;
        align-items: center;
      }
      .menu_php_ul {
        flex-direction: column;
        width: 100%;
        gap: 10px;
      }
      .menu_php_li {
        text-align: center;
      }
    }
  </style>
</head>

<body>

<!-- Navbar -->
<div class="menu_php_navbar">
 
  <div class="menu_php_logo">
  <br> <br>  <a href="#" class="menu_php_a" style="font-weight: lighter; font-size: 3rem;">
      Deesus <i class="fas fa-shopping-cart" style="font-size: 1rem; color: green;position:fixed"></i>
    </a>
  </div>
  <ul class="menu_php_ul">

  ..........
    <li class="menu_php_li"><a class="menu_php_a" href="index">Home</a></li>
    <li class="menu_php_li"><a class="menu_php_a" href="shop">Shop</a></li>
    <li class="menu_php_li"><a class="menu_php_a" href="contactus">Contact Us</a></li>
    <li class="menu_php_li"><a class="menu_php_a" href="blog">Blog</a></li>

    <?php if (!empty($_SESSION['login_']) && $_SESSION['role'] == "user") { ?>
      <li class="menu_php_li"><a class="menu_php_a" href="history">Made orders</a></li>
    <?php } else if (!empty($_SESSION['login_']) && $_SESSION['role'] == "admin") { ?>
      <li class="menu_php_li"><a class="menu_php_a" href="admin">Admin</a></li>
    <?php } ?>
  </ul>
  <div class="menu_php_buttons" style="margin-top: 30px;">
    <a href="cart.php" class="menu_php_cart"><i class="fas fa-shopping-cart"></i></a>
    <?php if (empty($_SESSION['login_'])) { ?>
      <button class="menu_php_button" onclick="openForms()"> Register</button>
      <button class="menu_php_button" onclick="openForm()">Login</button>
    <?php } else { ?>
      <div style="margin-top: 30px;color:white" ><?php echo $_SESSION['login_']."<span style='color:black'>..</span>"; ?></div>
      <a href="javascript:void(0);">
        <img src="https://www.w3schools.com/w3images/avatar1.png" alt="User Icon" class="menu_php_user-icon">
    
    
      </a>
      <div class="dropdown-content" style="display: none; position: absolute; right: 0; background-color: white; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1;">
            <br><br>  
            <br><br>  
            <a href="profile.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">Profile</a>
                <a href="account-settings.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;"> Settings</a>
                <a href="logout.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">Logout</a>
            </div>
    <?php } ?>
  </div>
</div>

<script>
  function openForm() {
        window.location.href = "login";
    }
    function openForms() {
        window.location.href = "register";
    }
    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }

       // Toggle dropdown visibility
       const userIcon = document.querySelector('.menu_php_user-icon').parentElement;
    const dropdown = document.querySelector('.dropdown-content');

    userIcon.addEventListener('click', function() {
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });

    // Close dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!userIcon.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>

</body>
</html>
