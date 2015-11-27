<!-- Bootstrap core CSS -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/bootstrap-reset.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<section id="container" class="">
	<!--main content start-->
    <section class="wrapper">
        	<!--contant start-->
		<div class="row">
            <div class="" align="center" style="max-width: 500px; margin: 100px auto 0;">
				<section class="panel" >
                  	<header class="panel-heading rform-header">
						Create New Password
					</header>
					
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="home">
								<?php echo form_open();?>
                                    <div class="row">
                                        <div class="col-sm-12  form-div">
                                           	<div class="col-sm-12" style="margin-top:0px;">
                                                <input type="password" class="form-control model-input" placeholder="Password" name="newPassword" value="<?php echo set_value('newPassword'); ?>">
												<?php echo form_error('newPassword'); ?>
                                        	</div>
                                        </div>
										
										<div class="col-sm-12  form-div">
											<div class="col-sm-12" style="margin-top:0px;">
                                               	<input type="password" class="form-control model-input" placeholder="Confirm Password" name="confirmPassword" value="<?php echo set_value('confirmPassword'); ?>">
												<?php echo form_error('confirmPassword'); ?>
                                        	</div>
                                        </div>
                                        
										<div class="col-sm-12 form-div">
                                          	<div class="col-sm-12 text-right">
                                              	<button class="btn btn-success">
													Submit
												</button>												
                                        	</div>
                                    	</div>
                                	</div>
								</form>
                        	</div>
                    	</div>
                	</div>
            	</section>
        	</div>
		</div>
		<!--contant end-->
    </section>      
	<!--main content end-->
</section>