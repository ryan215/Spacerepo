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

    <!--right slidebar-->
    <link href="<?php echo base_url(); ?>css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/admin/admin_css.css" rel="stylesheet">
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
			data:postData+&'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			beforeSend: function() {
				$(div).html('<?php echo $this->loader; ?>');
			},
			success:function(result){
				<?php
				if($this->session->userdata('userId')!='')
				{
				?>
				$(div).html(result);				
				<?php
				}
				else
				{
				?>
				window.location.href = '<?php echo base_url(); ?>';
				<?php
				}
				?>
			}
		});
	}
	</script>
</head>
<body>
<section id="container" class="">
	<!--header start-->
    <header class="header white-bg">
    	<div class="sidebar-toggle-box">
        	<div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips">
			</div>
		</div>
        <!--logo start-->
        <a href="<?php echo base_url(); ?>admin/segment" class="logo">
			<img width="138px" src="<?php echo base_url(); ?>img/slogo.png" alt="avatar" style="width: 138px; height: 38px;">
		</a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        </div>

		<div class="top-nav ">
        	<ul class="nav pull-right top-menu">
            	
    	        <!-- user login dropdown start-->
                <li class="dropdown">
                	<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
						<?php 
						$image = $this->session->userdata('userimage');
						if((!empty($image))&&(file_exists('uploads/admin/thumb50/'.$image)))
						{
						?>
							<img alt="" style="height:30px;width:30px;" src="<?php echo base_url(); ?>uploads/admin/thumb50/<?php echo $image; ?>">
						<?php
						}
						else
						{
						?>
							<img style="height:30px;width:30px;"  src="<?php echo base_url(); ?>images/default_user_image.jpg">
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
					<!--	<li>
							<a href="<?php echo base_url('admin/profile');?>">
								<i class=" fa fa-suitcase"></i>Profile
							</a>
						</li>
                       <li>
							<a href="<?php echo base_url('admin/profile/setting');?>">
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
			</ul>
		</div>
	</header>
	<!--header end-->