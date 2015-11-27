<!DOCTYPE html>
<html lang="en">
  
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/new_images/faviconmart.png" type="image/x-icon" />
	
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/owl.carousel.css" type="text/css">

    <!--right slidebar-->
    <link href="<?php echo base_url(); ?>css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />
    
	<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-select.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-select.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/pagination.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
	base_url = '<?php echo base_url(); ?>';
	function ajax_function(urlLink,div,postData)
	{
		$.ajax({
			type: "POST",
			url:urlLink,
			data:postData+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			beforeSend: function() {
				$(div).html('<?php echo $this->loader; ?>');
			},
			success:function(result){
				$(div).html(result); 				
			}
		});
	}	
	</script>
	<link href="<?php echo base_url(); ?>css/shipping/shipping_admin_css.css" rel="stylesheet">
</head>

<body>
<section id="container" >
	<!--header start-->
    <header class="header white-bg">
    	<div class="sidebar-toggle-box">
        	<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="javascript:void(0);" class="logo">
			<img width="138px" alt="avatar" src="<?php echo base_url(); ?>img/slogo.png">
		</a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
        	<!--  notification start -->
        </div>
        
		<div class="top-nav ">
        	<!--search & user info start-->
            <ul class="nav pull-right top-menu">
            	<!-- user login dropdown start-->
                <li class="dropdown">
            	    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);" style="background:0 !important;">
						<?php 
						$image = $this->session->userdata('userimage');
						if((!empty($image))&&(file_exists('uploads/cse/thumb50/'.$image)))
						{
						?>
							<img alt="" style="height:30px;width:30px;" src="<?php echo base_url(); ?>uploads/cse/thumb50/<?php echo $image; ?>">
						<?php
						}
						else
						{
						?>
	                    	<img class="sayuimg" alt="" src="<?php echo base_url(); ?>images/default_user_image.jpg">
						<?php
						}
						?>	                	
		                <span class="username">
							<?php echo $this->session->userdata('userName'); ?>
						</span>
	        	        <b class="caret"></b>
	                </a>
                    <ul class="dropdown-menu extended logout">
                    	<div class="log-arrow-up"></div>
                        <!--<li>
							<a href="#">
								<i class=" fa fa-suitcase"></i>Profile
							</a>
						</li>
                        <li>
							<a href="#">
								<i class="fa fa-cog"></i> Settings
							</a>
						</li>-->
                        <li>
							<a href="<?php echo base_url(); ?>auth/logout">
								<i class="fa fa-key"></i> Log Out
							</a>
						</li>
					</ul>
				</li>
                <!-- user login dropdown end -->
			</ul>
            <!--search & user info end-->
		</div>
	</header>
    <!--header end-->