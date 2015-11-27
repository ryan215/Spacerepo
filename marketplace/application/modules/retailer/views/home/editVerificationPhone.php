<style>
		body{background-color:#ffffff;
		background:url('../../../images/verify_bg.jpg');
		background-size:contain;
		background-repeat:no-repeat;
		}
		.verify-input{width:45px;
			height:55px;
			float:left;
			margin-right:6px;
			box-shadow:0px 0px 2px rgba(0,0,0,0.2);
			font-size:17px;
		
		}
		.veify-p{text-align:center;
		}
		.verify-maindiv{width:420px;
			margin:0 auto;
			background-color:#fff;
		}
		.fivedigit-inputs{padding-left:53px;
		}
		.verify-text{font-size:15px;
			text-align:left;
		}
		
		.main-verfy-div{padding-bottom:90px;
		}
		
		.intl-tel-input input{padding-left:40px;
			padding-right:1px;
			font-size:13px;
			height:45px;
		}
		.isa_error{max-width:50%;
			margin:15px auto;
		}
		
	</style>
<link href="<?php echo base_url(); ?>css/retailer/intlTelInput.css" / rel="stylesheet">

<div class="col-sm-12 pd main-shipsignin-div main-verfy-div">
        	<?php $this->load->view('success_error_message'); ?>
        	<div class="col-sm-12 pd">
            	<div class="col-lg-4 col-sm-3"></div>
            	<div class="col-sm-5 log-in-box  main-shi-div  verify-maindiv">
					<?php 
$attributes = array('class' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

                    	<h2 class="text-left" style="text-align:left; margin-bottom:0;">Change Phone Number</h2>
                        
                        <div class="form-group">
                        	<div class="col-sm-12 addon-md" style="text-align:center; margin-top:30px;">
                            	<p class="veify-p">Enter New Phone Number:</p>
                                <div class="col-sm-12 fivedigit-inputs" style="padding:0 50px;">
                                   <input type="tel" name="countryCode" id="mobile-number" placeholder="Enter Phone Number" class="ship-input ship-input2 form-control" data-live-search="true" value="<?php echo $result['countryCode']; ?>" style="width:85px; float:left;">
									<div class="" style="width:68%;">
                                    <input type="text" class="form-control ship-input" placeholder="Business Phone Number" name="businessPhone" value="<?php echo $result['businessPhone']; ?>"  style="margin-left:-3px;" / >
                                    </div>
                					<?php echo form_error('businessPhone'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            
                            <div class="not-alrdy" style="text-align:left;">
                                <button class="btn btn-success pull-right" style="border-radius:5px !important;  margin-left:8px !important;">Save</button>
                                <a class="btn btn-default pull-right" style="border-radius:5px !important; color:#666;" href="<?php echo base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId); ?>">Cancel</a>
                                
                            </div>
                        </div>

                        
                    </form>  
                </div>
            </div>
            
        </div>
<script src="<?php echo base_url(); ?>js/retailer/intlTelInput.js"></script>
<script>
$(document).ready(function(){
	$("#mobile-number").intlTelInput();
});      
</script>
