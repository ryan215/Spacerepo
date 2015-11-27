<?php
if($this->session->userdata('userId'))
{
}
else
{									
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/strongpassword/strength.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#myPassword').strength({
    	strengthClass: 'strength',
        strengthMeterClass: 'strength_meter',
        strengthButtonClass: 'button_strength',
        strengthButtonText: 'Show Password',
        strengthButtonTextToggle: 'Hide Password'
	});
});
</script>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

<style>
/*SITE STYLING*/
html{
    background:#4EC094;
    font-family: 'Lato', sans-serif;
    color:white;
}
#myform input[type="password"],#myform input[type="text"]{
        background:transparent;
    border: 2px solid #46AC84;
color: #777;
font-family: "Lato", sans-serif;
font-size: 14px;
padding: 9px 5px;
height: 21px;
text-indent: 6px;
-webkit-appearance: none;
-webkit-border-radius: 6px;
-moz-border-radius: 6px;
border-radius: 6px;
-webkit-box-shadow: none;
-moz-box-shadow: none;
box-shadow: none;
-webkit-transition: border .25s linear, color .25s linear;
-moz-transition: border .25s linear, color .25s linear;
-o-transition: border .25s linear, color .25s linear;
transition: border .25s linear, color .25s linear;
-webkit-backface-visibility: hidden;
width:100%;
}
#myform input[type="password"]:focus,#myform input[type="text"]:focus{
outline:0;
}
#myform{
width: 500px;
margin: 0 auto;
position: relative;
margin-bottom:60px;
}
.strength_meter{
position: absolute;
left: 0px;
top: 47px;
width: 50%;
height: 5px;
z-index:-1;
border-radius:5px;
padding-right:13px;
}
.button_strength {
text-decoration: none;
color: #FFF;
font-size: 13px;
display:none;
}
.strength_meter div{
    width:0%;
height: 5px;
text-align: right;
color: #000;
line-height: 43px;
-webkit-transition: all .3s ease-in-out;
-moz-transition: all .3s ease-in-out;
-o-transition: all .3s ease-in-out;
-ms-transition: all .3s ease-in-out;
transition: all .3s ease-in-out;
padding-right: 12px;
border-radius:5px;
}
.strength_meter div p{
position: absolute;
top: 22px;
right: 0px;
color: #FFF;
font-size:13px;
}

.veryweak{
    background-color: #FFA0A0;
border-color: #F04040!important;
width:25%!important;
}
.weak{
background-color: #FFB78C;
border-color: #FF853C!important;
width:50%!important;
}
.medium{
background-color: #FFEC8B;
border-color: #FC0!important;
width:75%!important;
}
.strong{
background-color: #C3FF88;
border-color: #8DFF1C!important;
width:100%!important;
}
/*h1{
    color:white;
    font-size:50px;
    text-align:center;
    padding-top:30px;
    margin-bottom:20px;
}*/
h1 span{
    font-weight:bold;
    color:white;
    opacity:.3;
}

</style>
<?php
}
?>

	</div>    
	<!--Profuct right close-->
<!-- BEGIN: footer -->
        <div id="yt_footer" class="yt-footer wrap">
            <div class="yt-footer-wrap">
                <div class="footer-top">
                    <div class="container">
                        <div class="row">

                            <div class="col-lg-12 col-md-12">
                                <div class="block block-subscribe-footer row">
                                    <div class="col-lg-7 col-md-7">
                                        <div class="block-content">
											   <?php 
											   $attributes = array('id' => 'newsletter-validate-detail');
											   echo form_open('',$attributes);
											   ?>
                                                <div class="input-box">
                                                    <input type="text" name="email" id="newsletter" title="Sign up for our newsletter" class="input-text required-entry validate-email" value="Enter your email address" onBlur="if(this.value=='') this.value='Enter your email address';" onFocus="if(this.value=='Enter your email address') this.value='';" />
                                                </div>
                                                <div class="actions">
                                                    <button  title="Subscribe" class="button" type="submit">
                                                        <span><span>Subscribe </span> </span>
                                                    </button>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                    <div class="no-padding col-lg-5 col-md-5">
                                        <div class="title-block">
                                            <h2>Sign Up for Our Newsletter </h2>
                                            <p>Receive email-only deals, special offers & product exclusives</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-middle">
                    <div class="container">
						<?php
						if($this->session->userdata('userId'))
						{
						}
						else
						{									
						?>
                        <div class="sn-middle account-block">
                            <div class="col-footer">
                                <div class="footer-title">
                                    <h2>My Account</h2>
                                </div>
                                <div class="content-block-footer">
									
                                    	<ul>
                                    		<li>
												<a class="login-btn" data-toggle="modal" data-target="#modal-login" title="Login">
													<span class="fa fa-caret-right">&nbsp;</span>Sign In
												</a>
        	                                </li>
            	                            <li>
												<a data-toggle="modal" data-target="#modal-reg" class="account-toplink" title="Registration">
													<span class="fa fa-caret-right">&nbsp;</span>Sign Up
												</a>
                            	            </li>
                                	    </ul>
									
                                </div>
                            </div>
                        </div>
						<?php
									}
									?>
                        <div class="sn-middle infomation-block">
                            <div class="col-footer">
                                <div class="footer-title">
                                    <h2>Let Us Help You</h2>
                                </div>
                                <div class="content-block-footer">
                                    <ul>
                                        <li>
											<?php
											if($this->session->userdata('userId'))
											{
											?>
											<a href="<?php echo base_url().'frontend/dashboard';?>" title="Your Account">
												<span class="fa fa-caret-right">&nbsp;</span> My Account
											</a>
											<?php
											}
											else
											{
											?>
											<a data-toggle="modal" data-target="#modal-login" title="Your Account" style="cursor:pointer;">
												<span class="fa fa-caret-right">&nbsp;</span> Your Account
											</a>
											<?php
											}
											?>
                                        </li>
                                        <li><a href="http://helpdesk.pointemart.com/Tickets/CreateWithCustomForm/2178 " target="_blank" title="Shipping Rates & Policies"><span class="fa fa-caret-right">&nbsp;</span>Shipping Rates & Policies</a>
                                        </li>
                                        <li><a href="http://helpdesk.pointemart.com/Tickets/CreateWithCustomForm/2107 " target="_blank" title="Return & Repalcements"><span class="fa fa-caret-right">&nbsp;</span>Returns & Replacements</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>contact-us" title="Contact Us"><span class="fa fa-caret-right">&nbsp;</span>Contact Us</a>
                                        </li>
                                        <li><a href="http://helpdesk.pointemart.com" target="_blank" title="Help"><span class="fa fa-caret-right">&nbsp;</span>Help</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="sn-middle corporate-block">
                            <div class="col-footer">
                                <div class="footer-title">
                                    <h2>Get to Know Us</h2>
                                </div>
                                <div class="content-block-footer">
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>about" title="About Spacepointe"><span class="fa fa-caret-right">&nbsp;</span>About PointeMart</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>press-release" title="Press Release"><span class="fa fa-caret-right">&nbsp;</span>Press Release</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>careers" title="Careers"><span class="fa fa-caret-right">&nbsp;</span>Careers</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="sn-middle choose-block">
                            <div class="col-footer">
                                <div class="footer-title">
                                    <h2>Make Money With Us</h2>
                                </div>
                                <div class="content-block-footer">
                                    <ul>
                                        <li>
											<a href="<?php echo $this->config->item('retailer_url'); ?>" title="Sell on PointeMart"><span class="fa fa-caret-right">&nbsp;</span>Sell on PointeMart
											</a>
                                        </li>
                                        <li><a href="<?php echo $this->config->item('retailer_url'); ?>" title="Advertise your products"><span class="fa fa-caret-right">&nbsp;</span>Advertise Your Products</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>terms-of-use" title="Terms of Use"><span class="fa fa-caret-right">&nbsp;</span>Terms of Use</a>
                                        </li>
                                        <li><a href="<?php echo base_url(); ?>privacy-policy" title="Privacy Policy"><span class="fa fa-caret-right">&nbsp;</span>Privacy Policy</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="sn-middle contact-block">
                            <div class="col-footer">
                                <div class="footer-title">
                                    <h2>Contact Us</h2>
                                </div>
                                <div class="content-block-footer">
                                   
                                    <ul>
                                        <li><span class="sp-ic fa fa-home" style="font-size: 16px; position: relative; top: 1px;">&nbsp;</span>242A Alhaji Ganiyu Alimi Crescent, <span style="margin-left:21px;">Gbagada Phase II Lagos, Nigeria</span></li>
                                        <li style="margin-top: -4px;"><span class="sp-ic fa fa-phone" style="font-size: 16px; position: relative; top: 2px;">&nbsp;</span><a title="Call:(1) 631 - 1305" href="tel:+23416311305">+234-1-631-1305</a> , <a title="Call:(1) 631 - 1306" href="tel:+23416311306">+234-1-631-1306</a>
                                        </li>
										
                                        
										<strong>For Customer Inquires</strong>
                                        <li><span class="sp-ic fa fa-envelope" style="font-size: 13px; position: relative;">&nbsp;</span>E-mail: <a title="<?php echo $this->config->item('admin_email'); ?>" href="mailto:<?php echo $this->config->item('admin_email'); ?>"><?php echo $this->config->item('admin_email'); ?></a>
                                        </li>
										<strong>For Corporate Inquires</strong>
										<li><span class="sp-ic fa fa-envelope" style="font-size: 13px; position: relative;">&nbsp;</span>E-mail: <a title="Info@spacepointe.com" href="mailto:Info@spacepointe.com">Info@spacepointe.com</a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- FOOTER SEVICER -->
                <div class="footer-bottom-sevicer">
                    <div class="container">
                        <div class="box-sevicer">
                            <div class="sn-sevirce sn-put1">
                                <div class="img-sevirce img-sevirce1"></div>
                                <div class="content-service">
                                    <strong>High Quality</strong>
                                </div>
                            </div>

                            <div class="sn-sevirce sn-put2">
                                <div class="img-sevirce img-sevirce2"></div>
                                <div class="content-service">
                                    <strong>Awesome Support</strong>
                                </div>
                            </div>

                            <div class="sn-sevirce sn-put3">
                                <div class="img-sevirce img-sevirce3"></div>
                                <div class="content-service">
                                    <strong>Really Fast Delivery</strong>
                                </div>
                            </div>

                            <div class="sn-sevirce sn-put4">
                                <div class="img-sevirce img-sevirce4"></div>
                                <div class="content-service">
                                    <strong>3-Day Returns</strong>
                                </div>
                            </div>

                            <div class="sn-sevirce sn-put5">
                                <div class="img-sevirce img-sevirce5"></div>
                                <div class="content-service">
                                    <strong>Secure Checkout</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FOOTER BOTTOM -->
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                <div class="copyright-footer">
                                    &copy; 2015 PointeMart. All Rights Reserved.
                                </div>
                            </div>
                            <div class="payment col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                <ul class="payment-method">
                                    <li>
                                        <a class="payment1" href="http://www.unionbankng.com/" target="_blank" title="Union Bank"></a>
                                    </li>
                                    <li>
                                        <a class="payment2" title="Payment Method" href="#"></a>
                                    </li>
                                    <li>
                                        <a class="payment3" title="Payment Method" href="#"></a>
                                    </li>
                                    <li>
                                        <a class="payment4" title="Payment Method" href="#"></a>
                                    </li>
									  <li>
                                        <a class="payment5" title="Payment Method" href="#"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
		<div aria-hidden="false" role="dialog" tabindex="-1" id="newslater-modal" class="modal">
						<div class="modal-dialog block-popup-login">
							<a data-dismiss="modal" class="close close-login" title="Close" href="javascript:void(0)">Close</a>
					            <div class="tt_popup_login news-leterpoup"><strong>Newsletter</strong> </div>
					            <?php
								echo form_open();
								?>
								<div class="block-content">
                	<div class="col-reg registered-account" id="newslettermessage" style="width:100%; border:0; text-align:center;">
                    	<h2 style="font-size:32px; padding-top:30px; padding-bottom:10px;color:#FE5621;">Thank you!</h2>
                        <h3 style="font-size:27px;">For Subscription</h3>
					</div>
					
					
                          <div style="clear:both;"></div>
                        </div>
                      </form>
                    		</div>
	                  </div>
        <!-- END: footer -->
		
			<?php
			if(empty($userId))
			{
			?>
			
				<div class="modal fade" id="modal-reg" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog block-popup-login" >
						<a href="javascript:void(0)" title="Close" class="close close-login" data-dismiss="modal">Close</a>
            			<div class="tt_popup_login"><strong>Sign Up</strong> </div>
			            <?php
						echo form_open('',array('autocomplete' => 'off'));
						?>

							<div class="block-content">
			                	<div class="col-reg registered-account" style="padding-right:0px; width:100%; border-right:none;">
			                    	<div class="email-input">
			                        	<input type="text" title="First Name" class="input-text" name="first_name" placeholder="First Name" value="<?php echo set_value('first_name'); ?>">
            			        		<?php echo form_error('first_name'); ?>
                        			</div>
						<div class="email-input">
                        	<input type="text" title="Last Name" class="input-text" name="last_name" placeholder="Last Name" value="<?php echo set_value('last_name'); ?>">
                    		<?php echo form_error('last_name'); ?>
                        </div>
						<div class="emailid-input">
                        	<input type="text" title="Email Address" class="input-text" name="email" placeholder="Email Address" value="<?php echo htmlentities(set_value('email')); ?>">
                    		<?php echo form_error('email'); ?>
                        </div>
						<div class="mobile-input">
                        	 
							 <input type="text" title="Mobile No." class="input-text" name="phone" placeholder="Mobile No." value="<?php echo set_value('phone'); ?>">
                    		<?php echo form_error('phone'); ?>
								
                        </div>
						
                         
                        <div class="pass-input">
                        	<input type="password" title="Password" class="input-text" name="password" type="password" placeholder="Password" value="<?php echo set_value('password'); ?>" id="myPassword">
                   			<?php echo form_error('password'); ?> 
                        </div>
                        <div>
                        	<!--<strong>Password strength:</strong> Too short<br />
                        	<div class="pass-stainght" style="width:190px; background-color:#e7e7e7; display:inline-block;">
                            	<div class="red-div" style="background:#FE5621; padding:2px; width:30%; "></div>
                                <div class="blue-div" style="width:70%; background-color:#5692D0; padding:2px;"></div>
                                <div class="green-div" style="width:100%; background-color:#76c261; padding:2px;"></div>
                            </div>-->
                        	<p style="line-height:15px; margin-bottom:8px; margin-top:2px;">Note : Passwords must be a minimum of 8 characters and include at least one capital, lower case and numeric</p>
                        	
                        	
                        </div>
						<div class="pass-input">
                        	<input type="password" title="Confirm Password" class="input-text" name="cpassword" type="password" placeholder="Confirm Password" value="<?php echo set_value('cpassword'); ?>">
                   			<?php echo form_error('cpassword'); ?> 
                        </div>
						
                        <div class="actions">
                        	<div class="submit-login">
                            	<input title="Login" type="submit" class="button btn-submit-login" name="REGISTRATION" value="Sign Up" />
                            </div>
						</div>
					</div>
					
					
                          <div style="clear:both;"></div>
                        </div>
                      </form>
                    </div>
                  </div>
				
				<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog block-popup-login">
							<a href="javascript:void(0)" title="Close" class="close close-login" data-dismiss="modal">Close</a>
					            <div class="tt_popup_login"><strong>Sign in Or Register</strong> </div>
					            <?php
echo form_open('',array('autocomplete' => 'off'));
?>

								<div class="block-content">			
								<?php 
								if($this->session->flashdata('loginError'))
								{?>
								<div class="col-sm-12 isa_error" style="padding: 8px;margin-bottom: 15px;">
								<?php
									echo $this->session->flashdata('loginError');
								?>
								</div>
								<?php	
								}
								?>
								
					 <div style="clear:both;"></div>							
                	<div class="col-reg registered-account">
                    	<div class="email-input">
                        	<input type="text" title="Email Address" class="input-text" placeholder="Email Address" name="email" value="<?php echo htmlentities($emailIn); ?>">
                    		<?php echo form_error('email'); ?>
                        </div>
                        <div class="pass-input">
                        	<input type="password" title="Password" class="input-text" name="password" placeholder="Password" value="<?php echo $passwordIn; ?>">
                   			<?php echo form_error('password'); ?> 
                        </div>
						<div class="ft-link-p">
							<a title="Forgot your password?" onClick="forgotpassword_model();" style="cursor:pointer;" class="f-left">
								Forgot your password?
							</a> 
						</div>
                        <div class="actions">
                        	<div class="submit-login">
                            	<input title="Login" type="submit" class="button btn-submit-login" name="submit" value="LOGIN" />
                            </div>
						</div>
					</div>
					
					<div class="col-reg login-customer">
                    	<h2>NEW HERE?</h2>
                        <p class="note-reg">Registration is free and easy!</p>
                        <ul class="list-log">
                        	<li>Faster checkout</li>
                            <li>Save multiple shipping addresses</li>
                            <li>View and track orders and more</li>
						</ul>
						<a class="btn-reg-popup" title="Register" onClick="signup_model();" style="cursor:pointer;">
							Create an account
						</a> 
					</div>
                          <div style="clear:both;"></div>
                        </div>
                      </form>
                    		</div>
	                  </div>  
					  
				<!--forgot password-->
                <div class="modal fade" id="modal-fpass" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog block-popup-login">
							<a href="javascript:void(0)" title="Close" class="close close-login" data-dismiss="modal">Close</a>
					            <div class="tt_popup_login"><strong>Forgot Password</strong> </div>
					            <?php
echo form_open();
?>

								<div class="block-content">
                	<div class="col-reg registered-account forgot-pass-popup">
                    	<div class="email-input">
                         <input type="text" title="Email Address" class="input-text" placeholder="Email Address" name="email" value="<?php echo htmlentities(set_value('email')); ?>">
                      <?php echo form_error('email'); ?>
                        </div>                       
						<div class="actions">
                        	<div class="submit-login">
                            	<input title="Login" type="submit" class="button btn-submit-login" name="FORGOTPASSWORD" value="SUBMIT" />
                            </div>
						</div>
					</div>
					
					
                          <div style="clear:both;"></div>
                        </div>
                      </form>
                    		</div>
	                  </div>
                <!--end of forgot password-->	  
				
			<?php
			}
		if($this->session->userdata('userId'))	
		{
		}
		else
		{
			if($_POST)
			{
			if((!empty($_POST['submit']))&&($_POST['submit']=='LOGIN'))
			{
			?>
				<script type="text/javascript">
					jQuery('#modal-login').modal('show');
				</script>
			<?php
			}
			elseif((!empty($_POST['REGISTRATION']))&&($_POST['REGISTRATION']=='Sign Up'))
			{
			?>
				<script type="text/javascript">
					jQuery('#modal-reg').modal('show');
				</script>
			<?php
			}
			elseif((!empty($_POST['FORGOTPASSWORD']))&&($_POST['FORGOTPASSWORD']=='SUBMIT'))
			{
			?>
				<script type="text/javascript">
					jQuery('#modal-fpass').modal('show');
				</script>
			<?php
			}
		}
			elseif($this->session->flashdata('loginError'))
			{
			?>
			<script type="text/javascript">
				jQuery('#modal-login').modal('show');			
			</script>
			<?php
			}
		}
		?>  

<script>
    jQuery(document).ready(function($){
        $('#newsletter-validate-detail').submit(function(e){
            e.preventDefault();

        $.ajax({
            type:"post",
            url:"<?php echo base_url();?>frontend/newsletter/add_newsletter_mail",
            data:$('#newsletter-validate-detail').serialize()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            success:function(message)
            {
                $('#newsletter').val(null);
                console.log(message);
                $('#newslettermessage').html(message);
                $('#newslater-modal').modal('show');
            }
            
        })

        })
    })
</script>	
	
<a id="yt-totop" href="#" title="Go to Top"></a>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript">
var __lc = {};
__lc.license = 6369461;

(function() {
  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script>
<!-- End of LiveChat code -->
</div>
</body>
</html>