<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Lamap Bootstrap 3 App Landing Page">
	<meta name="author" content="">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo.png">
	<title><?php echo $title; ?></title>

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/nivo-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/nivo-lightbox.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/animate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/hover.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/hover-min.css">
	<!-- Main Stylsheets -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style_dark.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/responsive.css">

	<!-- Color Sheme CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/retailer/color.css">

	<!-- Google Font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

<style>
.nav-pills>li>a {
	border-radius: 45px !important;
	border: 3px solid #fff
}
.nav-pills>li.active>a, .nav-pills>li.active>a:hover, .nav-pills>li.active>a:focus {
	color: #fff !important;
	background-color: transparent;
	border:3px solid #7BC76F;
}
.nav>li>a:hover, .nav>li>a:focus {
	text-decoration: none; background-color: transparent;
	color:#fff;
}
.nav>li>a {
	position: relative;
	display: block;
	padding: 14px 27px;
	font-size: 24px;
	
}
.select_dropdown{
	color: #fff !important;
	background-color: #52BE80 !important;
	border: 1px solid #52BE80 !important;
}
#tab4 p{
	text-align: Center;
	font-size: 12px;
	color:#fff;
	line-height:12px;
}
#tab4 p a{
	color:#78BB70;
	font-weight:bold;
}

.compeleted
{
	position: relative;
	top: -76px;
	left: 20px;
	font-size: 24px;
	color: #7AC46F;
}
.error{
	font-size:10px;
	}
</style>
</head>
 
<body>
<!-- begin preloader -->
<!--<div class="preloader">
	<div class="preloader-content-wrapper">
    	<div class="preloader-content">
        	<i class="fa fa-cog fa-3x fa-spin"></i>
        </div>
    </div>
</div>-->
<!-- end preloader -->

<!-- begin nav -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span>Menu</span>
			</button>
			<!-- begin logo in navigation -->
			<a class="navbar-brand" href="#intro">
				<img src="<?php echo base_url(); ?>images/logo.png" alt="logo small" style="width: 100%;">
			</a>
			<!-- end logo in navigation -->
		</div>	
	
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav pull-right">
				<!-- begin navigation items -->
				<li class="current">
					<a href="<?php echo base_url(); ?>retailer/home">
						Home
					</a>
				</li>
				<li><a href="#services">About Us</a></li>
				<li><a href="#retailer_feeds">Retailers Feeds</a></li>
				<li><a href="#how_to_Sells">How To Sell</a></li>
				<li><a href="#start_sellings">Start Selling</a></li>
				<!-- end navigation items -->
			</ul>	
		</div>
	</div>
</nav>
<!-- end nav -->
<section class="intro" id="intro">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="intro-section">					
					<h2 class="demo" data-in-effect="rollIn" style="color:#fff;padding: 100px 0 !important;">
						Forget Password
					</h2>
				</div>

				<div class="row">
					<div class="col-sm-12 form" >
					<!--Form Section Open-->
						<div style="margin: 0 auto;max-width: 805px;">
							<div id="contact" class="newsletter" style="padding: 25px;">
							<?php $this->load->view('success_error_message'); ?> 

<div id="login-content">
<?php echo form_open();?>				
		
			<div class="col-sm-9">
            <label style="color:#fff !important;">Email address<span style="color:#c00000;">*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="email" value="<?php echo set_value('email'); ?>" class="text-input wobble-skew" style="width:72% !important;" >
            </div>
            <div class="col-sm-3">
            <input class="button wobble-skew" type="submit" value="Submit" style="width:100% !important; background-color: #7BC570 !important; border:none; color:#fff !important;" />
			</div>
        
		<br style="clear: both;" />
		<?php echo form_error('email'); ?>
		
	
	</form>
</div>
				
							</div>
							</div>
								<!--Form Section End-->				
  								</div>
							</div>
						</div>				
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="footer_last"  style="padding: 10px 0 !important; ">
	<div class="container">		
		<div class="row">
			<div class="col-md-12">	
<div class="row wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
				<div class="col-md-12 text-center">
					<p style="color:#fff;font-family: Lato Regular;">
						<small>
						<?php echo date('Y'); ?> &copy; Spacepointe.com All rights reserved.
						</small>
					</p>				
				</div>
			</div>
		</div>
	</div>
	</div>
</section>		
<!-- end footer section -->

<!-- Javascripts -->
<script src="<?php echo base_url(); ?>js/retailer/jquery-1.11.1.js"></script>
<script src="<?php echo base_url(); ?>js/retailer/smoothScroll.js"></script>
<script src="<?php echo base_url(); ?>js/retailer/jquery.scrollTo.js"></script>
<script src="<?php echo base_url(); ?>js/retailer/bootstrap.min.js"></script>

<style>
.error {
color: red;
padding: 5px 0px 5px 15px !important;
font-size:16px !important;
}
input[type="text"]:focus {
  border-color: #66afe9;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);
}  
input[type="password"]:focus {
  border-color: #66afe9;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);
}
</style>
</body>
</html>