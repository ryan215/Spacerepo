<!--start main contant-->
<div class="container">		
	<div class="col-sm-12">
    	<div class="col-sm-4">
        	<div class="col-sm-12 pd">
            	<div  class="col-xs-6 car-div">
                	<img src="<?php echo base_url(); ?>images/shipping/car.png">
                </div>
                <div class="col-xs-6 man-div">
                	<img src="<?php echo base_url(); ?>images/shipping/man.png">
                </div>
			</div>
            <div class="col-sm-12 log-in-box  main-shi-div">
				<?php 
$attributes = array('class' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

                	<h2>Sign In</h2>
                    <div class="form-group">
                    	<div class="icon-addon addon-md">
                        	<input type="text" class="form-control ship-input" placeholder="Email" name="email" id="email" value="<?php echo set_value('email'); ?>">
                            <label title="username" class="fa fa-user input-label" for="email"></label>
							<?php echo form_error('email'); ?>
						</div>
					</div>
                        
                    <div class="form-group">
                    	<div class="icon-addon addon-md">
                        	<input type="password" id="password" class="form-control ship-input" placeholder="Password" name="password">
                            <label title="password"  class="fa fa-lock input-label" for="password"></label>
							<?php echo form_error('password'); ?>
						</div>
                       
					</div>

                    <div class="form-group">
                    	<button type="submit" class="btn btn-block ship-sign-btn">Sign In</button>
					</div>
				</form>  
			</div>
		</div>
        <div class="col-sm-8 map-div">
        	<img src="<?php echo base_url(); ?>images/shipping/map-img.png" alt="Logo" class="width"/>
		</div>
	</div>
</div> 
<!--end of main conatnt-->