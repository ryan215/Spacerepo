<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/new_images/faviconmart.png" type="image/x-icon" />
	<title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/retailer/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/shipping/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/retailer/hover-min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/retailer/shipping_pp_pm_login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		body{background-color:#ffffff;
		}
	</style>
	<script src="<?php echo base_url(); ?>js/retailer/jquery-1.11.1.js"></script>
	<script src="<?php echo base_url(); ?>js/retailer/bootstrap.min.js"></script>
	<script type="text/javascript">
		base_url = '<?php echo base_url(); ?>';
	</script>
	<link href="<?php echo base_url(); ?>css/success_error_message_style.css" rel="stylesheet">	
  </head>
<body style="">
	<!--main-container open-->
	<div class="main-container">
	
		<!--Header Open-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12" style="padding:20px 0 0 0;">
					<div class="col-sm-6  col-lg-5 col-md-5  col-xs-12 logo">
	                	<a href="<?php echo base_url().'retailer/home'; ?>" title="Logo">
							<img class="pm-logo" src="<?php echo base_url(); ?>images/pointemart_logo_pm_pp.png" alt="Logo" />
						</a>
	                    <span class="logo-divider"><img src="<?php echo base_url(); ?>images/logo-divider.png"/></span>
	                    <a href="javascript:void(0);" title="Logo">
							<img class="pp-logo" src="<?php echo base_url(); ?>images/pointpay_logo_pm_pp.png" alt="Logo"/>
						</a>
	                </div>
					<div class="col-sm-6 col-lg-7 col-xs-12 top-btn-div">
						<?php
						$uriSeg3 = $this->uri->segment(3);
						if($uriSeg3=='sign_up')
						{
						?>
	                	<a class="btn btn-shiping-sign" href="<?php echo base_url().'retailer/home'; ?>">
							Sign In
						</a>
						<?php
						}
						else
						{
						?>
	                	<a class="btn btn-shiping-sign" href="<?php echo base_url().'retailer/home/sign_up'; ?>">
							Sign Up
						</a>
						<?php
						}
						?>
	                </div>
				</div>
			</div>
		</div>	
		<!--Header CLose-->
		
		<!--start main contant-->
		<div class="container">	