<div class="col-sm-12 pd main-shipsignin-div">
        	<?php $this->load->view('success_error_message'); ?>
        	<div class="col-lg-4 col-sm-5 pd">
            	<div class="col-sm-12 log-in-box  main-shi-div">
                	
					<?php 
					$attr=array('class'=>'form-horizontal shipping-form');
					echo form_open('',$attr);?>
						<input type="hidden" name="confirm_code" value="<?php echo $reset_password_code; ?>">
                    	<h2>Forgot Password</h2>
                        <div class="form-group">
                        	<div class="icon-addon addon-md">
								New Password<span style="color:#c00000;">*</span>
								<input type="password" class="form-control ship-input" placeholder="Password" name="newPassword" value="<?php echo set_value('newPassword'); ?>">
								<?php echo form_error('newPassword'); ?>
							</div>
                        </div>
                        
                        <div class="form-group">
                        	<div class="icon-addon addon-md">
								Confirm Password<span style="color:#c00000;">*</span>
                                <input type="password" class="form-control ship-input" placeholder="Password" name="confirmPassword" value="<?php echo set_value('confirmPassword'); ?>">
								<?php echo form_error('confirmPassword'); ?>
                            </div>
                            <div class="form-group sign-inbtn-div">
                                <button type="submit" class="btn btn-block ship-sign-btn">Submit</button>
                            </div>
                        </div>
					</form>  
                </div>
            </div>
            <div class="col-lg-8 col-sm-7 right-div-signin pd">
            	<img src="<?php echo base_url(); ?>images/right-img-signin.jpg" alt="" />
            </div>
        </div>