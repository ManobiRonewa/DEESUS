    
<!---start session--->
<?php 
//include the link 
include "links.php";
include "conn.php";
$id =0;
if(!empty($_GET['dd'])){


    $id =$_GET['dd'];

}else{

$id =$_GET['dds'];

}
$_SESSION['id_']=$id;
$query = "select * from products where id=$id;";
$done = mysqli_query($conn,$query);
$row  = mysqli_fetch_assoc($done);
?>
<div class="log-form">

<img src="<?php echo $row['image_url'];?>" class="btn" style="background-color: transparent;height:70%">

<form method="post"  action="action.php?updatese=yes"  enctype='multipart/form-data'>
   
     <div class="group log-input">
                  <input  required style="width: 100%;height:2rem"  onchange="load(event)" name="paths" style="width:50%;margin-left:5%;" type="file"   accept=".jpg,.png" placeholder="choose the book photo"  value=""/>
                  </div> 


                  <div class="group">
    <button type="submit" class="btn">     Update image</button>

  
  
  </div>
           </form>       
</div>
<!----put the form in--->

<div style="width: 100%;">
<form method="post" class="log-form" action="action.php?update=yes"  enctype='multipart/form-data'>
    
        
        <div class="group log-input">
        <h3 class="book_tags">Item name:</h3>
                 
        
        <input value="<?php echo $row['product_name'];?>" style="width: 100%;height:2rem"  id="names"  class="upload_fields"  type="text" name="name" placeholder="Enter book name" required/>
        </div>
        
        <div class="group log-input">
                  <h3 class="book_tags">Item price:</h3>
                  <input value="<?php echo $row['price'];?>" style="width: 100%;height:2rem"  id="prices" class="upload_fields" type="number" name="price" placeholder="Enter book price" required/>
        </div>
             <div class="group log-input">
                
                 
        <?php 

//then check the session after  adding the task
//do research on sessions
if(!empty( $_SESSION['user_found'])){
   
   //clear the session
    $_SESSION['user_found']="";
?>
<div style="color:red;font-size:12px;width:100%"> Item is updated</div>
<br><br>
<?php }?> 

        <div class="group">
    <button type="submit" class="btn">     update info</button>

  
  
  </div>
      </form>
 
    </div>

     <div class="group" style="text-align:center" >
  <a href="items.php" >  <button type="submit" class="btn" style="width: 50%;">    Back</button></a>

  
  
  </div>
<br><br>
