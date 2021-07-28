<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['admin']))
{
if(!empty($_GET['food_id']))
{
	$food_id=$_GET['food_id'];
	$query=mysqli_query($con,"select * from tbfood where food_id='$food_id'");
if(mysqli_num_rows($query))
{   
	 $row=mysqli_fetch_array($query);
     $rfoodname=$row['foodname'];
     $rcost=$row['cost'];
     $rcuisines=$row['cuisines'];
     $rpaymentmode=$row['paymentmode'];
     $rfldimageold=$row['fldimage'];
	 $em= 22;
	
}
else
{
	header("location:food.php");
}
    


	
}
else
{
	
	header("location:food.php");
	
	
}
}
else
{
	header("location:admin.php");
}
if(isset($update))
{
   if(!empty($_SESSION['admin']))	
   {
    $paymentmode=implode(",",$chk);
    $img_name=$_FILES['food_pic']['name'];
    
    
    if(!empty($chk)) 
	{
		if(empty($img_name))
			
	       {
		          $paymentmode=implode(",",$chk);
	              if(mysqli_query($con,"update  tbfood  set foodname='$food_name',cost='$cost',cuisines='$cuisines',paymentmode='$paymentmode' where food_id='$food_id'"))
	   
	                {
						header("location:dashboard.php");
		              //echo "update with old pic";
		              //move_uploaded_file($_FILES['food_pic']['tmp_name'],"../image/restaurant/$em/foodimages/".$_FILES['food_pic']['name']);
	                 }
	              else{
		               echo "failed";
	                  }
	     }
	     else
		 {
			     $paymentmode=implode(",",$chk);
			     echo $food_name."<br>";
			     echo $cost."<br>";
			     echo $cuisines."<br>";
			     echo $paymentmode."<br>";
			     echo $img_name."<br>";
	             if(mysqli_query($con,"update  tbfood  set foodname='$food_name',cost='$cost',cuisines='$cuisines',paymentmode='$paymentmode', fldimage='$img_name' where food_id='$food_id'"))
	
	                {
		             echo "update with new pic";
		             move_uploaded_file($_FILES['food_pic']['tmp_name'],"image/restaurant/$em/foodimages/".$_FILES['food_pic']['name']);
	                 unlink("image/restaurant/$em/foodimages/$rfldimageold");
					 header("location:update_food.php?food_id=$food_id");
					}
				 else
				 {
					 echo "failed to upload new pic";
				}					 
		 }	
	}	
	else
	{  
	  $paymessage="please select a payment mode";
  
    }
   }
   else
   {
	   header("location:admin.php");
   }
}
if(isset($logout))
{
	session_destroy();
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Food - Dolla Foods</title>
	   <?php include('external_files.php'); ?>   
     <style>
		ul li{}
		ul li a {color:white;padding:40px; }
		ul li a:hover {color:white;}
	 </style>

</head>
<body>
	 <?php include('navbar2.php'); ?>	 

<!--navbar ends-->


<br><br>
<div class="middle" style=" position:fixed; padding:40px; border:1px solid #ED2553;  width:100%;">
       <!--tab heading-->
	   <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" id="home-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="home" aria-selected="true">Update Products</a>
          </li>
         
              <a class="nav-link" style="color:white;" id="profile-tab"  aria-selected="false">Product Details</a>
         
		  
       </ul>
	   <br><br>
	<!--tab 1 starts-->   
	   <div class="tab-content" id="myTabContent">
	   
            <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
                  <!--add Product-->
                        <form action="" method="post" enctype="multipart/form-data">
                                     <div class="form-group"><!--food_name-->
                                     <label for="food_name">Food Name:</label>
                                            <input type="text" class="form-control" id="food_name" value="<?php if(isset($rfoodname)) { echo $rfoodname;}?>" placeholder="Enter Food Name" name="food_name" required>
                                     </div>
									 
									 
                                     <div class="form-group"><!--cost-->
                                            <label for="cost">Cost :</label>
                                            <input type="number" class="form-control" id="cost"  value="<?php if(isset($rcost)) { echo $rcost;}?>" placeholder="10000" name="cost" required>
                                     </div>
									 
									 
	                                 <div class="form-group"><!--cuisines-->
                                            <label for="cuisines">Cuisines :</label>
                                            <input type="text" class="form-control" id="cuisines" value="<?php if(isset($rcuisines)) { echo $rcuisines;}?>" placeholder="Enter Cuisines" name="cuisines" required>
                                    </div>
							        
							        <div class="form-group"><!--payment_mode-->
									<?php
			                         
			                          $pay=explode(",",$rpaymentmode);
			
			                           ?>
                                         <input type="checkbox" <?php if(in_array("COD",$pay)) { echo "checked"; } ?> name="chk[]" value="COD"/>Cash On Delivery
			                             <input type="checkbox" <?php if(in_array("Online Payment",$pay)) { echo "checked"; } ?> name="chk[]" value="Online Payment"/>Online Payment
								         <br>
								        <span style="color:red;"><?php if(isset($paymessage)){ echo $paymessage;}?></span>
			      			        </div>
							   
	                                <div class="form-group">
									
                                         <input type="file" accept="image/*" name="food_pic"/>Food Snaps 
                                    </div>
   
                                    <button type="submit" name="update" class="btn btn-primary">Update Item</button>
									<br>
									
                               </form>      	 
	        </div>
<!--tab 1 ends-->	   
			
			
			
			 
      
	  </div>
	</div>  
	
</body>
</html>