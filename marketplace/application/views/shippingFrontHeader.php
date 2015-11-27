<!DOCTYPE html>
<html lang="en">
<head>
   	<meta charset="utf-8">
   	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/new_images/faviconmart.png" type="image/x-icon" />
    <title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/shipping/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/shipping/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/shipping/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/shipping/hover.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/shipping/shipping_login.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
	body
	{
		background-color:#ffffff;
	}
	</style>
	<link href="<?php echo base_url(); ?>css/pagination.css" rel="stylesheet">
	<script type="text/javascript">
	base_url = "<?php echo base_url(); ?>";
	</script>
</head>
<body style="">
	<!--main-container open-->
	<div class="main-container">
		<!--Header Open-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12" style="padding:20px 0 0 0;">
					<div class="col-sm-3  col-lg-3 col-md-3  col-xs-12 logo">
                		<a href="javascript:void(0);" title="Logo">
							<img src="<?php echo base_url(); ?>images/logo.png" alt="Logo" class="width"/>
						</a>
                	</div>
					<div class="col-sm-3 pull-left" style="padding-top: 5px; position:relative; left:-75px;"><span>In Partnership with <a href="http://www.unionbankng.com/" target="_blank"><img src="<?php echo base_url(); ?>images/frontend/logo-u.jpg" class="img-responsive" style="display:inline-block;width: 39%; "></a></div>
					<div class="col-sm-6 col-lg-6 col-xs-12 top-btn-div">						
                	</div>
				</div>
			</div>
		</div>	
		<!--Header CLose-->
		<?php $this->load->view('success_error_message'); ?> 