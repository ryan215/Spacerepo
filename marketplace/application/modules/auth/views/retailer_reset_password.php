<link href="<?php echo base_url(); ?>css/retailer/intlTelInput.css" / rel="stylesheet">
<script src="<?php echo base_url(); ?>js/retailer/intlTelInput.js"></script>
<script>
$(document).ready(function(){
	$("#mobile-number").intlTelInput();
}); 
     
</script>
<style>
.intl-tel-input input{padding-left:40px;
	padding-right:1px;
	font-size:13px;
}
	
.intl-tel-input{float:left !important;
}

.rtlr-signup-select{height:38px;
}
</style>
<div class="col-sm-12 pd main-shipsignin-div">
        	<?php $this->load->view('success_error_message'); ?>
        	<div class="col-lg-4 col-sm-5 pd">
            	<div class="col-sm-12 log-in-box  main-shi-div">
          		<?php 
					$attr=array('class'=>'form-horizontal shipping-form');
					echo form_open('',$attr);?>
                     <h2>Forget Password</h2>
                     
                        <div class="form-group">
                        <div class="icon-addon addon-md col-sm-12 pd-left pd-right form-group-signup">
                            	<label class="signup-labels">Enter Your Phone No.</label> <span class="error">*</span><br>
                              	<div class="col-sm-12 pd" style=" padding-left:0px;display:inline-flex; width:100%;">
                                	
                                	<div class="" style="width:112px; float:left;">
                                    	<input type="tel" name="" id="mobile-number" placeholder="Phone No." class="ship-input ship-input2 form-control" data-live-search="true" value="<?php echo $businessPhoneCode; ?>" style="width:85px; float:left;">
                                    </div>
									<div class="pull-right" style="width:100%;">
                                    <input type="text" class="form-control ship-input ship-input2" placeholder="Business Phone Number" name="businessPhone" value=""  style="margin-left:-2px; font-size:13px;" / ><?php echo form_error('businessPhone'); ?>
                                    </div>
                					
                                </div>
                            
                      	</div>
                         <!--<div class="icon-addon addon-md">
                             <label class="" style="margin-bottom:12px;">Enter Your Phone No.</label> <span style="color:red;">*</span>
                                <input type="text" class="form-control ship-input" placeholder="Phone No." name="email" value="<?php echo set_value('email'); ?>" />
								<?php echo form_error('email'); ?>
                            </div>-->
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