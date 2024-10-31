<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clothing Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        nav {
            text-align: center;
            margin-bottom: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            background-color: #fff;
            border: 1px solid #333;
            border-radius: 5px;
            margin: 0 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #333;
            color: #fff;
        }

        .button {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .button:hover {
            background-color: #555;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product h2 {
            margin-top: 0;
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* Blog post styles */
        .blog-post {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .blog-post h2 {
            margin-top: 0;
        }

        .blog-post img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .blog-post p {
            line-height: 1.6;
        }

        .blog-post h3 {
            margin-top: 20px;
        }
        
        /* Contact form styles */
        .contact-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .contact-form label {
            display: block;
            margin-bottom: 10px;
        }

        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .contact-form textarea {
            height: 100px;
        }

        .contact-form input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-form input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1>Hey <?php 
        session_start();
echo  $_SESSION['user_email'] ;
?>
   </h1>
    </header>
    <div class="container" style="background-color: white;">
        <nav>
        <img src="images/ts.jfif" alt="Product 1">
        <img src="images/ds1.jfif" alt="Product 1">
        <img src="images/ds2.jfif" alt="Product 1">

        <p>Shopping for clothes should be a joyful experience, not a stressful one. That's why we've created a welcoming and inclusive shopping environment where everyone is free to be themselves. So go ahead, explore our gender-inclusive clothing range, and shop with confidence knowing that you're supported and celebrated every step of the way.</p>

            <a class="button" href="buy.php">Shop Now</a>

            <br><br>
            Trending Items for you below !!
        </nav>
        
        <div class="products">

<?php 


include "connect.php";
//then do the query by checking the email
$query = "select * from tblcloths where requested='no' limit 3;";
$done = mysqli_query($connect,$query);
$count=0;
while($row  = mysqli_fetch_array($done)){

  //counting
  $count++;
?>

            <div class="product" >
                <h2><?php echo $count;?> <?php echo $row['cloth_name'];?> </h2>
                <img src="<?php echo $row['cloth_image'];?>" alt="Product 1" style="height:300px">
                <p>Desc: <?php echo $row['cloth_description'];?></p>
<p>Price: R<?php echo number_format($row['price'],2);?></p>
<a class="button" href="buy.php">EShop Now</a>
            </div>
          
          <?php }
          
          //check the products 
          if($count==0){

            ?>

            <div class="product">
                <h2>Dress</h2>
                <img src="images/dr1.jfif" alt="Product 1">
                <p>Get one once they are in stock</p>
                <p>R99,99</p>
            </div>
            <div class="product">
            <h2>Dress in</h2>
                <img src="images/dr2.jfif" alt="Product 1">
                <p>Get one once they are in stock</p>
                <p>R99,99</p>
            </div>
            <div class="product">
            <h2>Shoes</h2>
                <img src="images/s1.jfif" alt="Product 1">
                <p>Get one once they are in stock</p>
                <p>R99,99</p>
            </div>

<?php
          }
          ?>
        </div>

        <!-- Blog Post 1: Step into Style -->
        <div class="blog-post product" style="text-align: center;">
            <h2>Step into Style: Discover Our Trendy Shoe Collection!</h2>
            
            <div class="products">
            <div class="product" >
               
                <img src="images/s1.jfif" alt="Product 1" style="height:300px;border:none">

            </div>
            <div class="product" >
               
               <img src="images/s2.jfif" alt="Product 1" style="height:300px;border:none">

           </div>
           <div class="product" >
               
               <img src="images/s3.jfif" alt="Product 1" style="height:300px;border:none">

           </div>
        </div>
            <p>Are you ready to take your fashion game to the next level? Look no further! Our clothing store is not just about clothes; we have an amazing collection of shoes that will make you want to strut your stuff everywhere you go.</p>
            <h3>Trendy Styles for Every Occasion</h3>
            <p>Whether you're dressing up for a night out with friends or keeping it casual for a weekend stroll in the park, we've got you covered. From sleek sneakers to elegant heels, our shoe collection features a diverse range of styles to suit every taste and occasion.</p>
            <h3>Quality and Comfort Combined</h3>
            <p>At our store, we believe that style shouldn't come at the expense of comfort. That's why each pair of shoes in our collection is crafted with the highest quality materials and designed with your comfort in mind. Say goodbye to sore feet and hello to all-day comfort!</p>
            <p>Ready to step up your style game? Head over to our website and browse through our fabulous shoe collection. With new arrivals added regularly, there's always something fresh and exciting to discover. Don't wait any longer – treat your feet to some stylish new kicks today!</p>
        </div>

        <!-- Blog Post 2: Fashion for All -->
        <div class="blog-post">


            <h2>Fashion for All: Embrace Diversity with Our Gender-Inclusive Clothing Range!</h2>
  <div class="products">
            <div class="product" >
               
                <img src="images/dr1.jfif" alt="Product 1" style="height:300px;border:none">

            </div>
            <div class="product" >
               
               <img src="images/st.jfif" alt="Product 1" style="height:300px;border:none">

           </div>
           <div class="product" >
               
               <img src="images/sb.jfif" alt="Product 1" style="height:300px;border:none">

           </div>
        </div>            <p>Fashion is a form of self-expression, and everyone deserves to feel confident and stylish in what they wear. That's why our clothing store is proud to offer a diverse range of clothing options for all genders.</p>
            <h3>Embracing Diversity in Fashion</h3>
            <p>Gone are the days of rigid gender norms dictating what we can and cannot wear. At our store, we celebrate diversity and inclusivity by offering a wide selection of clothing that transcends traditional gender boundaries. Whether you identify as male, female, non-binary, or anywhere in between, you'll find something that speaks to your unique sense of style.</p>
            <h3>Versatile Styles for Every Body</h3>
            <p>From chic dresses and tailored suits to comfy loungewear and statement accessories, our clothing range has something for everyone. We believe that fashion should be fun, accessible, and above all, empowering. No matter your size, shape, or personal style preferences, you'll find plenty of options to express yourself with confidence.</p>
            <p>Shopping for clothes should be a joyful experience, not a stressful one. That's why we've created a welcoming and inclusive shopping environment where everyone is free to be themselves. So go ahead, explore our gender-inclusive clothing range, and shop with confidence knowing that you're supported and celebrated every step of the way.</p>
        </div>   <div class="contact-form" >
            <h2>Contact Us</h2>
            <form  method="post"style="width: 95%;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <input type="submit" value="Send Message">
            </form>
        </div>
    </div>

 
</body>
</html>
