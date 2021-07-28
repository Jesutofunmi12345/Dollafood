<?php
session_start();


include("connection.php");
extract($_REQUEST);
$arr=array();
if(isset($_GET['msg']))
{
	$loginmsg=$_GET['msg'];
}
else
{
	$loginmsg="";
}
if(isset($_SESSION['cust_id']))
{
	 $cust_id=$_SESSION['cust_id'];
	 $cquery=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $cresult=mysqli_fetch_array($cquery);
}
else
{
	$cust_id="";
}
 

$query=mysqli_query($con,"select  tblvendor.fld_name,tblvendor.fldvendor_id,tblvendor.fld_email,
tblvendor.fld_mob,tblvendor.fld_address,tblvendor.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
tbfood.cuisines,tbfood.paymentmode 
from tblvendor inner join tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['food_id'];
	shuffle($arr);
}

//print_r($arr);

 if(isset($addtocart))
 {
	 
	if(!empty($_SESSION['cust_id']))
	{
		 
		header("location:form/cart.php?product=$addtocart");
	}
	else
	{
		header("location:form/?product=$addtocart");
	}
 }
 
 if(isset($login))
 {
	 header("location:form/index.php");
 }
 if(isset($logout))
 {
	 session_destroy();
	 header("location:index.php");
 }
 $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
if(isset($message))
 {
	 
	 if(mysqli_query($con,"insert into tblmessage(fld_name,fld_email,fld_phone,fld_msg) values ('$nm','$em','$ph','$txt')"))
     {
		 echo "<script> alert('We will be Connecting You shortly')</script>";
	 }
	 else
	 {
		 echo "failed";
	 }
 }

?>
<html>
  <head>
     <title>Home</title>
	 <!--bootstrap files-->
	 <?php include('external_files.php'); ?>	 
	 
	 
	 <script>
	 //search product function
            $(document).ready(function(){
	
	             $("#search_text").keypress(function()
	                      {
	                       load_data();
	                       function load_data(query)
	                           {
		                        $.ajax({
			                    url:"fetch2.php",
			                    method:"post",
			                    data:{query:query},
			                    success:function(data)
			                                 {
				                               $('#result').html(data);
			                                  }
		                                });
	                             }
	
	                           $('#search_text').keyup(function(){
		                       var search = $(this).val();
		                           if(search != '')
		                               {
			                             load_data(search);
		                                }
		                            else
		                             {
			                         $('#result').html(data);			
		                              }
	                                });
	                              });
	                            });
								
								//hotel search
								$(document).ready(function(){
	
	                            $("#search_hotel").keypress(function()
	                         {
	                         load_data();
	                       function load_data(query)
	                           {
		                        $.ajax({
			                    url:"fetch.php",
			                    method:"post",
			                    data:{query:query},
			                    success:function(data)
			                                 {
				                               $('#resulthotel').html(data);
			                                  }
		                                });
	                             }
	
	                           $('#search_hotel').keyup(function(){
		                       var search = $(this).val();
		                           if(search != '')
		                               {
			                             load_data(search);
		                                }
		                            else
		                             {
			                         load_data();			
		                              }
	                                });
	                              });
	                            });
</script>
<style>
//body{
     background-image:url("img/main_spice2.jpg");
	 background-repeat: no-repeat;
	 background-attachment: fixed;
	  background-position: center;
}
ul li {list-style:none;}
ul li a{color:black; font-weight:bold;}
ul li a:hover{text-decoration:none;}

.wrapper {
  display: table;
  height: 100%;
  width: 100%;
}

.container-fostrap {
  display: table-cell;
  padding: 1em;
  text-align: center;
  vertical-align: middle;
}
.fostrap-logo {
  width: 100px;
  margin-bottom:15px
}
h1.heading {
  color: #fff;
  font-size: 1.15em;
  font-weight: 900;
  margin: 0 0 0.5em;
  color: #505050;
}
@media (min-width: 450px) {
  h1.heading {
    font-size: 3.55em;
  }
}
@media (min-width: 760px) {
  h1.heading {
    font-size: 3.05em;
  }
}
@media (min-width: 900px) {
  h1.heading {
    font-size: 3.25em;
    margin: 0 0 0.3em;
  }
} 
.card {
  display: block; 
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12); 
    transition: box-shadow .25s; 
}
.card:hover {
  box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
}
.img-card {
  width: 100%;
  height:200px;
  border-top-left-radius:2px;
  border-top-right-radius:2px;
  display:block;
    overflow: hidden;
}
.img-card img{
  width: 100%;
  height: 200px;
  object-fit:cover; 
  transition: all .25s ease;
} 
.card-content {
  padding:15px;
  text-align:left;
}
.card-title {
  margin-top:0px;
  font-weight: 700;
  font-size: 1.65em;
}
.card-title a {
  color: #000;
  text-decoration: none !important;
}
.card-read-more {
  border-top: 1px solid #D4D4D4;
}
.card-read-more a {
  text-decoration: none !important;
  padding:10px;
  font-weight:600;
  text-transform: uppercase
}


footer.main-footer {
  position: relative;
  width: 100%;
  bottom: 0;
  background: #222;
  padding: 10px 0;
}

footer.main-footer p {
  font-size: 0.7em;
  color: #777;
  margin: 0;
}

/* MAIN FOOTER MEDIAQUERIES ------------------------- */
@media (max-width: 575px) {
  footer.main-footer div[class*="col-"] {
    text-align: center !important;
  }
}

@media (min-width: 768px) {
  footer.main-footer p {
    font-size: 0.9em;
  }
}
</style>
  </head>
  
    
	<body>
	
	 <?php include('navbar.php'); ?>	 




<div id="result" style="position:fixed;top:300; right:500;z-index: 3000;width:350px;background:white;"></div>
<div id="resulthotel" style=" margin:0px auto; position:fixed; top:150px;right:750px; background:white;  z-index: 3000;"></div>


<!--menu ends-->
<div id="demo" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/basmati.jpg" alt="Los Angeles" class="d-block w-100" height="500px">
      <div class="carousel-caption">
        <h3 style="font-size:40px;">Welcome to Dolla Foods</h3>
        <p>We provide the best food menu</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="img/tomatoes.jpg" alt="Chicago" class="d-block w-100" height="500px">
      <div class="carousel-caption">
        <h3 style="font-size:40px;">Just check it out</h3>
        <p>Start Making Orders!</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="img/yellow.jpg" alt="New York" class="d-block w-100" height="500px">
      <div class="carousel-caption">
        <h3 style="font-size:40px;">We respond to you</h3>
        <p>Feel free</p>
      </div>   
    </div>
  </div>
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

<section class="wrapper">
    <div class="container-fostrap">
        <div>
<!--             <img src="https://4.bp.blogspot.com/-7OHSFmygfYQ/VtLSb1xe8kI/AAAAAAAABjI/FxaRp5xW2JQ/s320/logo.png" class="fostrap-logo"/> -->
            <h1 class="heading">
                Food Menu List 
            </h1>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                	<?php 
						  $query=mysqli_query($con,"select tblvendor.fld_email,tblvendor.fld_name,tblvendor.fld_mob,
						  tblvendor.fld_phone,tblvendor.fld_address,tblvendor.fldvendor_id,tblvendor.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
						  tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage from tblvendor inner join
						  tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id ");
						  $res=mysqli_fetch_assoc($query);
						  while($res=mysqli_fetch_assoc($query))
						  {
							   $hotel_logo= "image/restaurant/".$res['fld_email']."/".$res['fld_logo'];
							   $food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];

                	?>
                    <div class="col-xs-12 col-sm-4">
                        <div class="card">
                            <a class="img-card" href="#">
                            <img src="<?php echo $food_pic; ?>" />
                          </a>
                            <div class="card-content">
                                <p class="" align="center">
                                    <?= $res['foodname']; ?>
                                </p>
                                 <p class="" align="center">
                                    <i class="fa fa-map-marker" aria-hidden="true">Lagos</i>
                                </p>
                                	
                            </div>
                            <div class="card-read-more row">
                            	<div class="col-6">
	                                <span style="font-weight: bold;" class="btn btn-link btn-block">
	                                    ₦<?= $res['cost']; ?>
	                                </span> 
	                                <span style="font-weight: bold;" class="btn btn-link btn-block">
	                                 <i class="fa fa-balance-scale">12 bags</i>
	                                </span> 

                            	</div>
                            	<div class="col-6">
                            		<form method="post">
	                                <button class="pull-right btn btn-link btn-block" type="submit" name="addtocart" value="<?= $res['food_id']; ?>">
	                                   <i class="fa fa-shopping-cart" aria-hidden="true"></i>
	                                </button>
	                                </form>                            		
                            	</div>

                            </div>
                        </div>
                    </div>
                <?php } ?>


                </div>
            </div>
        </div>
    </div>
</section>

<!--slider ends-->

<!--container 1 starts-->

<br><br>
<!-- <div class="container-fluid">
  <div class="row">
    
    <div class="col-sm-6">
	<div class="container-fluid">
	 <img src="img/istockphoto-516324258-612x612.jpg" height="300px" width="100%">
	</div>
	 <div class="container">
	 <p style="font-family: 'Lobster', cursive; font-weight:light;  font-size:25px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
	 </div>
	
	</div>
	
    <div class="col-sm-6">
	<br><br><br><br><br><br><br><br><br><br><br><br>
	<div class="container-fluid rounded" style="border:solid 1px #F0F0F0;">
	<?php
	   $food_id=$arr[0];
	  $query=mysqli_query($con,"select tblvendor.fld_email,tblvendor.fld_name,tblvendor.fld_mob,
	  tblvendor.fld_phone,tblvendor.fld_address,tblvendor.fldvendor_id,tblvendor.fld_logo,tbfood.food_id,tbfood.foodname,tbfood.cost,
	  tbfood.cuisines,tbfood.paymentmode,tbfood.fldimage from tblvendor inner join
	  tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id where tbfood.food_id='$food_id'");
	  while($res=mysqli_fetch_assoc($query))
	  {
		   $hotel_logo= "image/restaurant/".$res['fld_email']."/".$res['fld_logo'];
		   $food_pic= "image/restaurant/".$res['fld_email']."/foodimages/".$res['fldimage'];
	  ?>
	  <div class="container-fluid">
	  <div class="container-fluid">
	     <div class="row" style="padding:10px; ">
		      <div class="col-sm-2"><img src="<?php echo $hotel_logo; ?>" class="rounded-circle" height="50px" width="50px" alt="Cinque Terre"></div>
		      <div class="col-sm-5">
		                     <a href="search.php?vendor_id=<?php echo $res['fldvendor_id']; ?>"><span style="font-family: 'Miriam Libre', sans-serif; font-size:28px;color:#CB202D;">
		 <?php echo $res['fld_name']; ?></span></a>
        </div>
		 <div class="col-sm-3"><i  style="font-size:20px;" class="fas fa-rupee-sign"></i>&nbsp;<span style="color:green; font-size:25px;"><?php echo $res['cost']; ?></span></div>
		 <form method="post">
		 <div class="col-sm-2" style="text-align:left;padding:10px; font-size:25px;"><button type="submit" name="addtocart" value="<?php echo $res['food_id'];?>")" ><span style="color:green;" <i class="fa fa-shopping-cart" aria-hidden="true"></i></span></button></div>
		 <form>
		 </div>
		 
	  </div>
	  <div class="container-fluid">
	  <div class="row" style="padding:10px;padding-top:0px;padding-right:0px; padding-left:0px;">
		 <div class="col-sm-12"><img src="<?php echo $food_pic; ?>" class="rounded" height="250px" width="100%" alt="Cinque Terre"></div>
		 
		 </div>
	  </div>
	  <div class="container-fluid">
	     <div class="row" style="padding:10px; ">
		 <div class="col-sm-6">
		 <span><li><?php echo $res['cuisines']; ?></li></span>
		 <span><li><?php echo "Rs ".$res['cost']; ?>&nbsp;for 1</li></span>
		 <span><li>Up To 60 Minutes</li></span>
		 </div>
		 <div class="col-sm-6" style="padding:20px;">
		 <h3><?php echo"(" .$res['foodname'].")"?></h3>
		 </div>
		 </div>
		 
	  </div>
	
	
	<?php
	  }
	?>
	</div>
	
	</div>
	
	</div>
    
  </div>
</div> -->




<!--container 1 ends-->






<!--container 2 starts-->

<!--container 2 ends-->

<!--footer primary-->
	     
		    <?php
			include("footer.php");
			?>
			 			 
		  
		  <footer class="main-footer" >
        <br><center>
      <p style="color: white;"> Dolla Foods 2019 | &copy; All Rights Reserved </p>
      <br></center>
          </footer>
          

	</body>
</html>