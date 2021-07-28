<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  
    <a class="navbar-brand" href="index.php"><span style="color:green;font-family: 'Permanent Marker', cursive;">Dolla Foods</span></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav ml-auto">
        
		<li class="nav-item">
		  <form method="post">
			<button class="btn btn-outline-success my-2 my-sm-0" name="logout" type="submit">
		    <?php
			if(!empty($admin_username))
			{
			?>
			<a class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user">Admin</i></a>
			<?php
			}
			?>
			Log Out
			</button>&nbsp;&nbsp;&nbsp;
			</form>
        </li>
		
      </ul>
	  
    </div>
	
</nav>