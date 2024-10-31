<!-- Start session -->
<?php 
// Include the necessary links or scripts
?>

<?php 
if ($_GET['on'] == "yes") {
    include "links.php";
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Item</title>
        <style>
            body {
                background-color: white;
                font-family: Arial, sans-serif;
            }
            .form-container {
                width: 100%;
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                border-radius: 8px;
                box-shadow: none; /* Removed shadow */
            }
            .group {
                margin-bottom: 15px;
            }
            .log-input {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .upload_fields {
                width: 100%;
                height: 2rem;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-shadow: none; /* Removed shadow */
            }
            .btn {
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
            }
            .btn:hover {
                background-color: #45a049;
            }
            .message {
                color: red;
                font-size: 12px;
                width: 100%;
                text-align: center;
            }
            .view-button {
                width: 20%;
                margin: 20px auto;
                display: block;
                text-align: center;
            }
            .log-form{
              background-color: white;
              border:none;
              box-shadow:none;
            }
        </style>
    </head>
    <body>
        <div class="form-container">
            <form method="post" class="log-form" action="action.php?add=yes" enctype='multipart/form-data'>
                <div class="group log-input">
                    <h3 class="book_tags">product name:</h3>
                    <input id="names" class="upload_fields" type="text" name="name" placeholder="Enter item name" required />
                </div>
                
                <div class="group log-input">
                    <h3 class="book_tags">product price:</h3>
                    <input id="prices" class="upload_fields" type="number" name="price" placeholder="Enter item price" required />
                </div>
                
                <div class="group log-input">
                    <h3 class="book_tags">product image:</h3>
                    <input onchange="load(event)" name="paths" class="upload_fields" type="file" accept=".jpg,.png" required />
                </div>

                <?php 
                // Check the session after adding the item
                if (!empty($_SESSION['user_found'])) {
                    // Clear the session
                    $_SESSION['user_found'] = "";
                    ?>
                    <div class="message">Item is added</div>
                    <?php 
                }
                ?>

                <div class="group">
                    <button type="submit" class="btn">ADD</button>
                </div>
            </form>
        </div>

       
    </body>
    </html>
<?php 
} 
?>
