<!DOCTYPE html>
<html>
<style>
	body{
		background-image: url("<?= base_url('assets/image/bg---cms.png');?>");
		background-size: cover;
	}
	.inner{
		margin-top:15%;
		
	}

	#div-box{
		background-color: rgba(229,229,229,.1);
		box-shadow:none;
		/* border:1px solid green; */
	}
	

	
</style>
<head>
	<meta charset="utf-8">
	<title><?php echo @$title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url('assets/logo/mui.png')?>" type="image/png" />
	<!-- LINEARICONS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/colorlib/fonts/linearicons/style.css">

	<!-- STYLE CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/colorlib/css/style.css">
	<!-- <style>
		#utd{
			color:grey;
			font-weight:bold;
		}
	</style> -->
</head>

<body>
	

	<div class="wrapper">
		
		<div class="inner">
        
        
		<center>
				<form id="div-box" action="<?php echo base_url('user/auth');?>" method="POST">
				<div id="alert-login">
					<?php 
						if($this->session->flashdata('status_login') == 'not ok')
							{
					?>
								<div class="info"><b>Maaf, Login gagal dilakukan</b></div><br>
					<?php
							}
					?>
				</div>
				<h3>Login</h3>
				<div class="form-holder">
					<span class="lnr lnr-envelope"></span>
					<input type="email" class="form-control" placeholder="Email" autofocus autocomplete="off" name="username">
				</div>

				<div class="form-holder">
					<span class="lnr lnr-lock"></span>
					<input name="password" type="password" class="form-control" placeholder="Password">
				</div>

				<div class="">
					<button type="submit" class="">Login</button>
				</div>

				<br>
				<center>
				<!-- <p id="utd">UTD PMI KOTA BANDUNG</p></center> -->


			</form>
		</center>
            <!-- <img src="<?php echo base_url();?>assets/colorlib/images/image-2.png" alt="" class="image-2"> -->
            <!-- <img src="<?php echo base_url();?>assets/images/stevejobs.png" alt="" class="image-2"> -->
		</div>

	</div>

	<!-- <script src="<?php echo base_url();?>assets/colorlib/js/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/colorlib/js/main.js"></script> -->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>