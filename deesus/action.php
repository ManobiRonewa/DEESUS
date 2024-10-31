<?php
//get the database connion
include "conn.php";
session_start();



















//get values when they add task
if (!empty($_GET['add'])) {


    /*declare and assign variables*/
    $prices = $_POST['price'];
    $name = $_POST['name'];

    /*get image size , name and tmp name*/
    $image_name = $_FILES["paths"]["name"];
    $image_size = $_FILES["paths"]["size"];
    $image_tmp = $_FILES["paths"]["tmp_name"];

    /*explode image and size*/
    $images = explode('.', $image_name);
    $images = strtolower(end($images));

    $both = uniqid();
    $both .= '.' . $images;
    /*save the image into cloth folder in images*/
    move_uploaded_file($image_tmp, 'images/' . $both);

    /*save to database*/
    $save = "INSERT INTO `products` (`id`, `product_name`, `image_url`, `price`) VALUES (NULL, '$name', 'images/$both', '$prices');";
        /*run query*/
    mysqli_query($conn, $save);
    $_SESSION['user_found']="d";
    echo "<script> window.location.href='tables_item.php?on=yes';</script>";
}

//get values when they delete task
if (!empty($_GET['delete'])) {

    //task id from the url
    $id = (int) $_GET['delete'];


    //delete from  the table
    $querys = "delete from  users where id =$id;";
    $dones = mysqli_query($conn, $querys);



    //then return to the home page
    echo "<script> window.location.href='home.php';</script>";
}

//get values when they delete task
if (!empty($_GET['app1'])) {

    //task id from the url
    $id = (int) $_GET['app1'];


    //delete from  the table
    $querys = "update users set status='approved' where id =$id;";
    $dones = mysqli_query($conn, $querys);



    //then return to the home page
    echo "<script> window.location.href='home.php';</script>";
}




//get values when they delete task
if (!empty($_GET['dd'])) {

    //task id from the url
    $id = (int) $_GET['dd'];


    //delete from  the table
    $querys = "delete from  products where id =$id;";
    $dones = mysqli_query($conn, $querys);



    //then return to the home page
    echo "<script> window.location.href='items.php';</script>";
}





//get values when they add task
if (!empty($_GET['update'])) {


    /*declare and assign variables*/
    $prices = $_POST['price'];
    $name = $_POST['name'];
    $id = $_SESSION['id_'];


    /*save to database*/
    $save = "
    update  `products` set product_name='$name', price='$prices' where id=$id";
    /*run query*/
    mysqli_query($conn, $save);

    //then return to the home page
    $_SESSION['user_found'] = "no";
    echo "<script> window.location.href='edit.php?dd=$id';</script>";
}

if (!empty($_GET['updatese'])) {


    /*declare and assign variables*/

    /*get image size , name and tmp name*/
    $image_name = $_FILES["paths"]["name"];
    $image_size = $_FILES["paths"]["size"];
    $image_tmp = $_FILES["paths"]["tmp_name"];

    /*explode image and size*/
    $images = explode('.', $image_name);
    $images = strtolower(end($images));

    $both = uniqid();
    $both .= '.' . $images;
    /*save the image into cloth folder in images*/
    move_uploaded_file($image_tmp, 'images/' . $both);
    //get values when they add task
    $id = $_SESSION['id_'];


    /*save to database*/
    $save = "
    update  `products` set image_url='images/$both' where id=$id";
    /*run query*/
    mysqli_query($conn, $save);

    //then return to the home page
    $_SESSION['user_found'] = "no";
    echo "<script> window.location.href='edit.php?dd=$id';</script>";
}



//check out method
if (!empty($_GET['check_out'])) {

    //variables
    $session = $_POST['sessionId'];
    $orders = $_POST['orderNum'];
    $owner = $_SESSION['email'];
   


    foreach ($_SESSION['cart']  as $index_item  => $row) {

        //change the row to array
        if (is_array($row)) {

            //then check if the item is added before
            if ($row['name'] != "nots_1") {

                //increase the quantity
                $quantity =  $_SESSION['cart'][$index_item]['quantity'];
                $image =  $_SESSION['cart'][$index_item]['image'];
                $name =  $_SESSION['cart'][$index_item]['name'];
                $price =  $_SESSION['cart'][$index_item]['price'];
                $query = "INSERT INTO `orderline` (`id`, `image`, `name`, `price`, `quantity`, `session`, `orders`, `owner`, `track`) VALUES (NULL, '$image', '$name', $price, $quantity, '$session', '$orders', '$owner','your order is on the way will arrive in less than 24 hours');";

               mysqli_query($conn, $query);
            }
        }
    }


    session_destroy();
    echo "<script> window.location.href='index.php';</script>";
}

//get values when they add task
if (!empty($_GET['added'])) {


    /*declare and assign variables*/
    $prices = $_POST['price'];
    $description = $_POST['description'];
    $name = $_POST['name'];

    $owner = $_SESSION['email'];
    /*get image size , name and tmp name*/
    $image_name = $_FILES["paths"]["name"];
    $image_size = $_FILES["paths"]["size"];
    $image_tmp = $_FILES["paths"]["tmp_name"];

    /*explode image and size*/
    $images = explode('.', $image_name);
    $images = strtolower(end($images));

    $both = uniqid();
    $both .= '.' . $images;
    /*save the image into cloth folder in images*/
    move_uploaded_file($image_tmp, 'images/cloth/' . $both);

    /*save to database*/
    $save = "
  INSERT INTO `tblcloths` (`id`, `cloth_name`, `price`, `cloth_description`, `cloth_image`, `requested`, `uploader`) VALUES (NULL, '$name', '$prices', '$description', 'images/cloth/$both', 'yes', '$owner');";
    /*run query*/
    mysqli_query($conn, $save);

    //then return to the home page
    $_SESSION['user_found'] = "no";
    echo "<script> window.location.href='to_sell.php';</script>";
}


if (!empty($_GET['id_req'])) {

    //task id from the url
    $id = (int) $_GET['id_req'];


    //delete from  the table
    //$querys = ";
    mysqli_query($conn, "UPDATE `tblcloths` SET `requested` = 'no' WHERE `tblcloths`.`id`=$id;");



    //then return to the home page
    echo "<script> window.location.href='manage.php';</script>";
}

if (!empty($_GET['id_buy'])) {

    //task id from the url
    $id = (int) $_GET['id_buy'];


    //delete from  the table
    //$querys = ";
    mysqli_query($conn, "UPDATE `orderline` SET `track` = 'delivered' WHERE `orderline`.`id`=$id;");



    //then return to the home page
    echo "<script> window.location.href='reply.php';</script>";
}