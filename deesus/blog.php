<?php 

include "menu.php";
?>


<html>
    <head>
        <meta>
        <meta>
        <title>deesus main</title>
        <link rel="stylesheet" href="css/style.css"/>
        <script src="https://kit.fontawesome.com/d388045308.js" crossorigin="anonymous"></script>

    </head>
    <body>
   

        <section id="page-header" style="background-image: url(images/blog/b5.jpg);" class="blog-header">
            <h2>#readmore</h2>
            <p>Read all case studies about our product</p>
        </section>

        <section id="blog">
        <?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'deesus');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blog posts
$sql = "SELECT id, image_url, title, description, post_date FROM blog_posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $description = substr($row['description'], 0, 100); // Show 100 characters initially
        $fullDescription = $row['description']; // Full description for expanding
        ?>
        
        <div class="blog-box">
            <div class="blog-img">
                <img src="<?php echo $row['image_url']; ?>" alt="">
            </div>
            <div class="blog-details">
                <h4><?php echo $row['title']; ?></h4>
                <p id="short-desc-<?php echo $row['id']; ?>"><?php echo $description; ?>...</p>
                <p id="full-desc-<?php echo $row['id']; ?>" style="display: none;"><?php echo $fullDescription; ?></p>
                <a href="javascript:void(0);" onclick="toggleDescription(<?php echo $row['id']; ?>)" id="read-more-<?php echo $row['id']; ?>">CONTINUE READING</a>
                <h1><?php echo date('d/m', strtotime($row['post_date'])); ?></h1>
            </div>
        </div>
        
        <?php
    }
} else {
    echo "No blog posts available.";
}
$conn->close();
?>

<script>
    function toggleDescription(id) {
        var shortDesc = document.getElementById('short-desc-' + id);
        var fullDesc = document.getElementById('full-desc-' + id);
        var readMoreLink = document.getElementById('read-more-' + id);
        
        if (fullDesc.style.display === 'none') {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'block';
            readMoreLink.innerText = 'SHOW LESS';
        } else {
            shortDesc.style.display = 'block';
            fullDesc.style.display = 'none';
            readMoreLink.innerText = 'CONTINUE READING';
        }
    }
</script>

        </section>

    </body>
</html>



<?php 

include "footer.php";
?>