<?php 
// Start the session and include the database connection
session_start();
include "conn.php"; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the file is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        // Set the target directory
        $target_dir = "images/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dates =Date('y-m-d');
           
           $query ="insert into blog_posts values(null,'$target_file',' $title', '$description','$dates')";
            mysqli_query($conn,$query);
          
                echo "<script>alert('Blog post added successfully!'); window.location.href='add_blog.php';</script>";
        }
    } else {
        echo "<script>alert('Please upload an image.');</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group textarea {
            height: 100px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add Blog Post</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept=".jpg,.png,.jpeg" required>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter blog title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter blog description" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Add Blog Post</button>
        </div>
    </form>
</div>

</body>
</html>
