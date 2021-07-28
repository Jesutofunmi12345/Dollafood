<?php
include("connection.php");
session_start();
extract($_REQUEST);
if(isset($updstatus))
{
	if(!empty($_SESSION['admin']))
{
	  if(mysqli_query($con,"update tblorder set fldstatus='$status' where fld_order_id='$order_id'"))
	  {
		  header("location:dashboard.php");
	  }
}
else
{
	header("location:admin.php?msg=You Must Login First");
}
}

?>
<html>
<head>
<title>Change Status - Dolla Foods</title>
	   <?php include('external_files.php'); ?>   

	  <!--bootstrap files-->
	  <style>
	  ul li{}
		ul li a {color:black;}
		ul li a:hover {color:black; font-weight:bold;}
		ul li {list-style:none;}
		</style>
</head>
<body>
	 <?php include('navbar2.php'); ?>	 

<br><br><br><br><br><br>
   <div class="container">
    <form method="post">
      <div class="row">
	 
	  <div class="col-sm-4">Update Order Status</div>
	  <div class="col-sm-4">Delivered<input type="radio"  name="status" value="Delivered">&nbsp;&nbsp;&nbsp;Out Of Stock<input type="radio"  name="status" value="Out Of Stock"><br>
	  <br>
	  
	  <button type="submit" class="btn btn-outline-success" name="updstatus">Update Status</button>
	  </div>
	  <div class="col-sm-4"></div>
	  
	  </div>
	  </form>
   </div>
   <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   include("footer.php");
   ?>
</body>
</html>