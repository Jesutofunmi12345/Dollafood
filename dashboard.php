
<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(!isset($_SESSION['admin']))
{
	header("location:admin.php");
	
}
else
{
	$admin_username=$_SESSION['admin'];
}
if(isset($logout))
{
	unset ($_SESSION['admin']);
	setcookie('logout','loggedout successfully',time() +5);
	header("location:admin.php");
}
if(isset($delete))
{
	header("location:deletefood.php?id=$delete");
}
if(isset($deleteVendor))
{
	header("location:deleteVendor.php?Vendorid=$deleteVendor");
}
if(isset($add))
{   if(isset($_SESSION['admin']))
	{
    $img_name=$_FILES['food_pic']['name'];
    if(!empty($chk)) 
	{
	$paymentmode=implode(",",$chk);
	if(mysqli_query($con,"insert into tbfood(fldvendor_id,foodname,cost,cuisines,paymentmode,fldimage) values
		('22','$food_name','$cost','$cuisines','$paymentmode','$img_name')"))
	{
		$id = 'vendor1@gmail.com';
		move_uploaded_file($_FILES['food_pic']['tmp_name'],"image/restaurant/$id/foodimages/".$_FILES['food_pic']['name']);
	}
	else{
		echo "failed";
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

$admin_info=mysqli_query($con,"select * from tbadmin where fld_username='$admin_username'");
$row_admin=mysqli_fetch_array($admin_info);
$user= $row_admin['fld_username'];
$pass= $row_admin['fld_password'];

//update
if(isset($update))
{
if(mysqli_query($con,"update tbadmin set fld_password='$password'"))
{
	//$_SESSION['pas_update_success']="Password Updated Successfully Login with New Password";
    unset ($_SESSION['admin']);
	header("location:admin_info_update.php");
}
else
{
	echo "failed";
}

}
?>
<html>
  <head>
     <title>Admin control panel</title>
	   <?php include('external_files.php'); ?>   
		 <style>
		ul li{}
		ul li a {color:black;}
		ul li a:hover {color:black; font-weight:bold;}
		ul li {list-style:none;}

ul li a:hover{text-decoration:none;}
#social-fb,#social-tw,#social-gp,#social-em{color:blue;}
#social-fb:hover{color:#4267B2;}
#social-tw:hover{color:#1DA1F2;}
#social-gp:hover{color:#D0463B;}
#social-em:hover{color:#D0463B;}
	 </style>
	 <script>
			function delRecord(id)
			{
				//alert(id);
				
				var x=confirm("You want to delete this record? All Food Items Of that Vendor Will Also Be Deleted");
				if(x== true)
				{
					
					//document.getElementById("#result").innerHTML="success";
				  window.location.href='deleteVendor.php?Vendorid=' +id;		
				}
				else
				{
					window.location.href='#';
				}
				
			}
		</script>
  
  </head>
  
    
	<body>

	 <?php include('navbar2.php'); ?>	 
	<!--navbar ends-->
<br><br><br><br>
<!--details section-->
 
<div class="container">
       <!--tab heading-->
	   <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" style="color:#BDDEFD;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true">View Food Items</a>
          </li>
          <li class="nav-item">
              <a class="nav-link"  style="color:#BDDEFD;" id="profile-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="profile" aria-selected="false">Add Products</a>
          </li>
          <li class="nav-item">
              <a class="nav-link"  style="color:#BDDEFD;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount2" role="tab" aria-controls="manageaccount" aria-selected="false">Account Settings</a>
          </li>
<!-- 		  <li class="nav-item">
              <a class="nav-link" style="color:#BDDEFD;"  id="ManageVendors-tab" data-toggle="tab" href="#ManageVendors" role="tab" aria-controls="ManageVendors" aria-selected="false">Manage Vendors</a>
          </li> -->
		  <li class="nav-item">
              <a class="nav-link" style="color:#BDDEFD;" id="orderstatus-tab" data-toggle="tab" href="#orderstatus" role="tab" aria-controls="orderstatus" aria-selected="false">Order status</a>
          </li>
		  
		  
		  
		  
       </ul>
	   <br><br>
	<!--tab 1 starts-->   
	   <div class="tab-content" id="myTabContent">
	   
            <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="viewitem-tab">
                 <div class="container">
	               <table class="table">
                 <thead>
                    <tr>
                            <th scope="col">Food View</th>
                            <th scope="col">Food Name</th>
                            <th scope="col">Food Price</th>
							<th>Food Cuisines </th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Update Food</th>                            
                            <th scope="col">Remove food</th>
                     </tr>
                 </thead>
				 <tbody>
	<?php
	$query=mysqli_query($con,"select tblvendor.fldvendor_id,tblvendor.fld_name,tblvendor.fld_email,tbfood.food_id,tbfood.foodname,tbfood.cuisines,tbfood.fldimage,tbfood.* from  tblvendor right join tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id");
	    while($row=mysqli_fetch_array($query))
		{
	
	?>			 
                
                    <tr>
                        <!-- <th scope="row"><?php echo $row['fldvendor_id'];?></th> -->
						<td><img src="image/restaurant/<?php echo $row['fld_email']."/foodimages/" .$row['fldimage'];?>" height="50px" width="100px">
						</td>
						<td><?php echo $row['foodname'];?></td>
						<td><?php echo $row['cost'];?></td>
						<td><?php echo $row['cuisines'];?></td>
						<td><?php echo $row['paymentmode'];?></td>
						<td>				
							<a href="update.php?food_id=<?php echo $row['food_id'];?>"><button type="button" class="btn btn-primary">Update </button></a>
						</td>
                        <!-- <td><?php echo $row['fld_name'];?></td> -->                        
						<form method="post">
                        <td><a href=""><button type="submit" value="<?php echo $row['food_id']; ?>" name="delete"  class="btn btn-danger">Remove </button></td>
                        </form>
                   </tr>
		<?php
		}
		?>		   
                </tbody>
           </table>
	 
	 </div>   	
		  
		   <span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>
			
		
      	    </div>	 
	  
<!--tab 1 ends-->	   
            <div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="profile-tab">
			         <!--add Product-->
                        <form action="" method="post" enctype="multipart/form-data">
                                     <div class="form-group"><!--food_name-->
                                     <label for="food_name">Food Name:</label>
                                            <input type="text" class="form-control" id="food_name" value="<?php if(isset($food_name)) { echo $food_name;}?>" placeholder="Enter Food Name" name="food_name" required>
                                     </div>
									 
									 
                                     <div class="form-group"><!--cost-->
                                            <label for="cost">Cost :</label>
                                            <input type="number" class="form-control" id="cost"  value="<?php if(isset($cost)) { echo $cost;}?>" placeholder="10000" name="cost" required>
                                     </div>
									 
									 
	                                 <div class="form-group"><!--cuisines-->
                                            <label for="cuisines">Cuisines :</label>
                                            <input type="text" class="form-control" id="cuisines" value="<?php if(isset($cuisines)) { echo $cuisines;}?>" placeholder="Enter Cuisines" name="cuisines" required>
                                    </div>
							        
							        <div class="form-group"><!--payment_mode-->
                                         <input type="checkbox" name="chk[]" value="COD"/>Cash On Delivery
			                             <input type="checkbox" name="chk[]" value="Online Payment"/>Online Payment
								         <br>
								        <span style="color:red;"><?php if(isset($paymessage)){ echo $paymessage;}?></span>
			      			        </div>
							   
	                                <div class="form-group">
                                         <input type="file" accept="image/*" name="food_pic" required/>Food Snaps 
                                    </div>
   
                                    <button type="submit" name="add" class="btn btn-primary">ADD Item</button>
									<br>
									<span style="color:red;"><?php if (isset($msg)){ echo $msg;}?></span>
                               </form>
				   
			</div>			
			
			<!--tab 2 starts-->
            <div class="tab-pane fade" id="manageaccount2" role="tabpanel" aria-labelledby="manageaccount-tab">
			    <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" id="username" value="<?php if(isset($user)){ echo $user;}?>" class="form-control" name="name" readonly="readonly"/>
                    </div>
					
					
					
                   <div class="form-group">
                      <label for="pwd">Password:</label>
                     <input type="password" name="password" class="form-control" value="<?php if(isset($pass)){ echo $pass;}?>" id="pwd" required/>
                   </div>
				   
				   
 
                  <button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
                  <div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
			 </form>
			</div>
			<!--tab 2 ends-->
			 
<!-- 			 <div class="tab-pane fade show" id="ManageVendors" role="tabpanel" aria-labelledby="ManageVendors-tab">
			    <div class="container">
	               <table class="table">
                 <thead>
                    <tr>
                        <th scope="col"></th>
                            <th scope="col">Hotel Id/vendor Id</th>
                            <th scope="col">Name</th>
                            
                            
                            <th scope="col">Address</th>
                            <th scope="col">Remove Vendor</th>
                     </tr>
                 </thead>
				 <tbody>
	<?php
	$query=mysqli_query($con,"select  * from tblvendor");
	    while($row=mysqli_fetch_array($query))
		{
	
	?>			 
                
                    <tr>
                        
						<td><img src="image/restaurant/<?php echo $row['fld_email']."/" .$row['fld_logo'];?>" height="50px" width="100px"></td>
                        <th scope="row"><?php echo $row['fldvendor_id'];?></th>
						<td><?php echo $row['fld_name'];?></td>
						<td><?php echo $row['fld_address'];?></td>
                        
                        
                        
                        
                        
						<form method="post">
                        <td><a href="#"  style="text-decoration:none; color:white;" onclick="delRecord(<?php echo $row['fldvendor_id']; ?>)"><button type="button" class="btn btn-danger">Remove Vendor</a></a></td>
                        </form>
                   </tr>
		<?php
		}
		?>		   
                </tbody>
           </table>
	 
	 </div>   	
			 </div> -->
			 
			 <!--tab 4-->
			 <div class="tab-pane fade" id="orderstatus" role="tabpanel" aria-labelledby="orderstatus-tab">
               <table class="table">
			   <th>Order Id</th>
			   <th>Customer Email Id</th>
			   <th>order Status</th>
			   <th>Update Status</th>
			   <tbody>
			   <?php			   
			   $rr=mysqli_query($con,"select * from tblorder");
			   while($rrr=mysqli_fetch_array($rr))
			   {
				   $stat=$rrr['fldstatus'];
				   $foodid=$rrr['fld_food_id'];
				   $r_f=mysqli_query($con,"select * from tbfood where food_id='$foodid'");
				   $r_ff=mysqli_fetch_array($r_f);
			   
			   ?>
			   <tr>
			   <td><?php echo $rrr['fld_order_id']; ?></td>
			   <td><?php echo $rrr['fld_email_id']; ?></td>
			   <?php
			   if($stat=="cancelled" || $stat=="Out Of Stock")
			   {
			   ?>
			   <td><i style="color:orange;" class="fas fa-exclamation-triangle"></i>&nbsp;<span style="color:red;"><?php echo $rrr['fldstatus']; ?></span></td>
			   <?php
			   }
			   else
				   
			   {
			   ?>
			   <td><span style="color:green;"><?php echo $rrr['fldstatus']; ?></span></td>
			   <?php
			   }
			   ?>
				<form method="post">
				<td><a href="changestatus.php?order_id=<?php echo $rrr['fld_order_id']; ?>"><button type="button" name="changestatus">Update Status</button></a></td>
				</form>
			   
			   </tr>
			   <?php
			   }
			   ?>
			   </tbody>
			   </table>
			</div>
			 
      
	  </div>
	</div>	 
		  

</body>
	
</html>	