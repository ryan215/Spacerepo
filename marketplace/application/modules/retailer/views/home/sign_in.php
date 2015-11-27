<div class="col-sm-12 pd main-shipsignin-div">
        	<?php $this->load->view('success_error_message'); ?>
        	<div class="col-lg-4 col-sm-5 pd">
            	<div class="col-sm-12 log-in-box  main-shi-div">
					<?php 
$attributes = array('class' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

                    	<h2>Sign in to your account</h2>
                        <div class="form-group">
                        	<div class="icon-addon addon-md">
                                <input type="text"class="form-control ship-input" placeholder="User name" name="email" value="<?php echo set_value('email'); ?>">
                                <label title="username"  class="fa fa-user input-label" for="email"></label>
								<?php echo form_error('email'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        	<div class="icon-addon addon-md">
                                <input type="password" class="form-control ship-input" placeholder="Password" name="password">
                                <label title="password"  class="fa fa-lock input-label" for="email"></label>
								<?php echo form_error('password'); ?>
                            </div>
                            <div class="form-group sign-inbtn-div">
                                <button type="submit" class="btn btn-block ship-sign-btn">Sign In</button>
                            </div>
                            <div class="forgot-link">
								<a href="<?php echo base_url().'auth/retailer_reset_password'; ?>">
									Forgot Password ?
								</a>
							</div>
                            <div class="not-alrdy">
                            	Not already selling on Pointemart?<br>
								<a href="<?php echo base_url().'retailer/home/sign_up'; ?>">
									Register now
								</a>
								to sell your products
                            </div>
                        </div>

                        
                    </form>  
                </div>
            </div>
            <div class="col-lg-8 col-sm-7 right-div-signin pd">
            	<img src="<?php echo base_url(); ?>images/right-img-signin.jpg" alt="" />
            </div>
        </div>