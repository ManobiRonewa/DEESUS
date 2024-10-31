<?php 
// Start the session and include the database connection
session_start();
include "conn.php"; 

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $delete_query = "DELETE FROM blog_posts WHERE id = $delete_id";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Blog post deleted successfully.'); window.location.href='view_blog.php';</script>";
    } else {
        echo "<script>alert('Error deleting blog post.'); window.location.href='view_blog.php';</script>";
    }
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $update_id = (int)$_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "UPDATE blog_posts SET title = '$title', description = '$description' WHERE id = $update_id";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Blog post updated successfully.'); window.location.href='view_blog.php';</script>";
    } else {
        echo "<script>alert('Error updating blog post.'); window.location.href='view_blog.php';</script>";
    }
}

// Fetch all blog posts from the database
$query = "SELECT * FROM blog_posts ORDER BY post_date DESC"; 
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            text-decoration: none;
            color: #4CAF50;
            margin-right: 10px;
        }
        .actions a.delete {
            color: #f44336;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Input styles */
        input[type="text"], textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Blog Posts</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Post Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any blog posts
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td><img src='" . $row['image_url'] . "' alt='Blog Image' style='width: 100px; height: auto;'></td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td><textarea readonly style='border:none;outline:none;overflow:auto'>" . htmlspecialchars($row['description']) . "</textarea></td>";
                    echo "<td>" . date("Y-m-d", strtotime($row['post_date'])) . "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='#' onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['description']) . "\")'>Edit</a>";
                    echo "<a href='view_blog.php?delete_id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this blog post?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No blog posts found.</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Blog Post</h2>
        <form method="post" action="">
            <input type="hidden" name="id" id="editId">
            <div>
                <label for="editTitle">Title:</label>
                <input type="text" name="title" id="editTitle" required>
            </div>
            <div>
                <label for="editDescription">Description:</label>
                <textarea name="description" id="editDescription" required></textarea>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

<script>
function openEditModal(id, title, description) {
    document.getElementById('editId').value = id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDescription').value = description;
    document.getElementById('editModal').style.display = "block";
}

function closeEditModal() {
    document.getElementById('editModal').style.display = "none";
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        closeEditModal();
    }
}
</script>

</body>
</html>
