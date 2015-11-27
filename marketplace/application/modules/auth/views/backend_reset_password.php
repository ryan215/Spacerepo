<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  	
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo.png">
	<title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
   	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <style>
	.error{text-align:left;
		margin-top:5px;
	}
	.isa_error{background:none;
		text-align:left;
	}
	.isa_error span{padding-left:0 !important;
	}
	</style>
</head>

<body class="lock-screen">

    <div class="lock-wrapper">
         
        <div class="lock-box text-center">
            <img src="<?php echo base_url(); ?>img/login-logo.png" alt="logo"/>
            
            <!--<form role="form" class="form-inline" method="post">-->
			<?php
			$attr=array('class'=>'form-inline');
			echo form_open('',$attr);
			?>
                <div class="form-group col-lg-12" style="left:3%;">
                	<h1>Forget Password</h1>
                    <div style="margin-left:6%">
                   <div class="col-sm-3 forget-pass-label">
                   		Email address
                   </div>
                   <div class="col-sm-9	">
                   		 <input type="text" placeholder="" class="form-control lock-input" name="email" value="<?php echo set_value('email'); ?>">
						
                            <button class="btn btn-lock" type="submit">
                                Submit
                            </button>
							<?php echo form_error('email'); ?>
							<?php $this->load->view('success_error_message'); ?> 
                   </div>
                   </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
