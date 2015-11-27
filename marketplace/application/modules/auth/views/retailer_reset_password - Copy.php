<div class="col-sm-12 pd main-shipsignin-div">
        	<?php $this->load->view('success_error_message'); ?>
        	<div class="col-lg-4 col-sm-5 pd">
            	<div class="col-sm-12 log-in-box  main-shi-div">
                		<?php 
					$attr=array('class'=>'form-horizontal shipping-form');
					echo form_open('',$attr);?>
                     <h2>Forget Password</h2>
                        <div class="form-group">
                         <div class="icon-addon addon-md">
                             <label class="" style="margin-bottom:12px;">Enter Your Email Address</label> <span style="color:red;">*</span>
                                <input type="text" class="form-control ship-input" placeholder="Email address" name="email" value="<?php echo set_value('email'); ?>" />
								<?php echo form_error('email'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
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