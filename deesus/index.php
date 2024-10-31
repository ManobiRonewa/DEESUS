<?php 
 include "menu.php";

?>
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop All New Arrivals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
    </style>
</head>
<body>

<section id="hero" style="background-image: url(images/background.jpg);">
            <h4>Trade-In-Offer</h4>
            <h2>Super value deals</h2>
            <h1>On all products</h1>
            <p>same more with coupons & up to 70% off!</p>
            <button onclick="opens()" style="background-image: url(images/button.png);">shop now</button>
        </section>
        <script>
            function opens(){
                window.location.href="shop.php";
            }
            </script>

      <div style="width: 100%;text-align:center;margin-top:2rem"><h3>our services below</h3></div>
        <section id="feature" class="section-p1 " style="background-color: white;">
            <div class="fe-box">
                <img src="images/features/f1.png">
                <h6>Free Shipping</h6>
            </div>

            <div class="fe-box">
                <img src="images/features/f2.png">
                <h6>Online Order</h6>
            </div>

            <div class="fe-box">
                <img src="images/features/f3.png">
                <h6>Save Money</h6>
            </div>

            <div class="fe-box">
                <img src="images/features/f4.png">
                <h6>Promotions</h6>
            </div>

            <div class="fe-box">
                <img src="images/features/f5.png">
                <h6>Happy Sell</h6>
            </div>

            <div class="fe-box">
                <img src="images/features/f6.png">
                <h6>F24/7 Support</h6>
            </div>
        </section>
        <div style="width: 100%;text-align:center;margin-top:2rem"><h3></h3></div>


        <section id="product1">
            <h2>Featured Product</h2>
            
            <div class="pro-container"  style="display: flex;flex-wrap:wrap;">
                <div class="pro"  style="margin-left:2%">
                    <img src="images/products/jeans/baggy4.webp" alt="">
                    <div class="des">
                        <span>Obey</span>
                        <h5>OBEY BIG WIG CARGO DENIM JEANS (LIGHT INDIGO)</h5>
                            <h4>R 698.64</h4>                                           
                        <a href="shop.php" class="add-to-cart" data-product-name="Accountin ALL-IN-ONE">
                        <i class="fa-solid ">more</i>
                        </a>
                    </div>
                </div>
                <div class="pro" style="margin-left:2%">
                    <img src="images/products/jeans/2.jfif" alt="">
                    <div class="des">
                        <span>Blank Nyc Jeans</span>
                        <h5>Nyc The Baxter Womens Ribcage Straight Leg Jeans</h5>
                        <div class="star">                         
                            <h4>R 654.78</h4>                                          
                        <a href="shop.php" class="add-to-cart" data-product-name="Accountin ALL-IN-ONE">
                        <i class="fa-solid ">more</i>
                        </a>
                    </div>
                </div>
                <div class="pro" style="margin-right:2%">
                    <img src="images/products/jeans/3.webp" alt="">
                    <div class="des">
                        <span>Wrangler Texas</span>
                        <h5>Wrangler Texas Jeans New Favorite K</h5>                        
                            <h4>R 550</h4>                       
                        <a href="shop.php" class="add-to-cart" data-product-name="Accountin ALL-IN-ONE">
                        <i class="fa-solid ">more</i>
                        </a>
                    </div>
                </div>
                <div class="pro">
                    <img src="images/products/t-shirt/t8.webp" alt="">
                    <div class="des">
                        <span>The Scarab</span>
                        <h5>The Scarab T-Shirt</h5>                       
                            <h4>R 250</h4>                       
                        <a href="shop.php" class="add-to-cart" data-product-name="Accountin ALL-IN-ONE">
                        <i class="fa-solid ">more</i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="sm-banner" class="section-p1">
            <div class="banner-box" style="background-image: url(images/deals/d1.avif);">
                <h4>crazy deals</h4>
                <h2>buy 1 get 1 free</h2>
                <span>The best classic book is on sale at boookit</span>
                <button class="white">Learn More</button>
            </div>

            <div class="banner-box banner-box2" style="background-image: url(images/deals/d3.avif);">
                <h4>crazy deals</h4>
                <h2>buy 1 get 1 free</h2>
                <span>The best classic book is on sale at boookit</span>
                <button class="white">Collection</button>
            </div>
        </section>

        <section id="banner3">
            <div class="banner-box" style="background-image: url(images/banner/b17.jpg);">
                <h2>Season Sales</h2>
                <h3>winter collection -50% OFF</h3>
            </div>
            <div class="banner-box banner-box2" style="background-image: url(images/banner/b16.jpg);">
                <h2>New Fashion Sales</h2>
                <h3>Recent 50% New</h3>
            </div>
            <div class="banner-box banner-box3" style="background-image: url(images/banner/b18.jpg);">
                <h2>Other Fashion</h2>
                <h3>New Trendy Prints</h3>
            </div>
        </section>

        <section id="newsletter"  class="section-p1 section-m1" style="background-image: url(images/about/banner.png);">
            <div class="newstext">
                <h4>Sign Up For Newsletter</h4>
                <p>get E-mail updates about our latest shop and <span>special offer</span>.</p>
            </div>
            <div class="form">
                <input type="text" placeholder="your email address">
                <button class="normal">Sign Up</button>
            </div>
        </section>


  <?php 
include "footer.php";

?>

</body>
</html>
