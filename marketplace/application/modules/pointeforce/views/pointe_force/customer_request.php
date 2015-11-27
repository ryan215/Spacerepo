<link href="<?php echo base_url(); ?>css/new_css/pointeforce.css" type="text/css"  rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>



<div class="container pointeforce-container">
<div class="col-sm-12">
	<div class="col-sm-1"></div>
    <div class="col-sm-10">
    	
        <div class="row main-rows">
        	<div class="col-sm-8 poiteforce-intro">
            	<h1 style="display: inline-block;"><span class="poite-color" style="opacity:1;">Pointe</span> <span class="force-color" style="opacity:1;">Force</span></h1>
				<a href="#Alreadyacustomer" class="btn btn-danger btn-forcesignup pull-right" style="background:#F7941E; color:#fff; border:1px solid #F7941E; font-size:15px; text-transform:uppercase;   margin-top: 5px; display:inline-block;">Already a customer</a>
				
                <p>This is a hub focused on enabling and empowering youths into entrepreneurship by providing them with the relevant resources and environment; Setting them up for success; Migrating  them from the theoretical meaning of entrepreneurship to the practical experience of being an entrepreneur. 
				 
				<br /><br />
In other words, PointeForce is where you need to belong to if you desire to be an entrepreneurial force to be reckoned with. 
				</p>
            </div>
        	<div class="col-sm-4 pointe-img">
            	<img src="<?php echo base_url(); ?>images/new_images/pointeforce/pointeforce_img.png" />
            </div>
        </div>
        
        <div class="row main-rows">
        	<div class="col-sm-6 definesucces-leftdiv">
            	<h2>Could PointeForce Help You 
					Define Success?
				</h2>
                <ul>
                	<li><i class="fa fa-check"></i>Enjoy what you do</li>
                    <li><i class="fa fa-check"></i>Be Your Own Boss</li>
                    <li><i class="fa fa-check"></i>Grow your own team</li>
                    <li><i class="fa fa-check"></i>Make your own hours</li>
                    <li><i class="fa fa-check"></i>Use the talents and skills<br />you already have</li>
                    <li><i class="fa fa-check"></i>Expand into the talents and<br /> skills you desire to have</li>
                </ul>
            </div>
        	<div class="col-sm-6 definesucces-rightdiv">
            	<img src="<?php echo base_url(); ?>images/new_images/pointeforce/help_img.png" />
            </div>
        </div>
        
        <div class="row main-rows"  id="Alreadyacustomer">
        	<div class="col-sm-12 parts-head">
            	<p>A job may need you to become who you are not but <br />
				with PointeForce, we celebrate uniqueness, we celebrate You!
                </p>

				 <h1>What to expect as part of the PointeForce Family?</h1>
            </div>
            <div class="col-sm-12 points-maindiv">
            	<div class="col-sm-12" style="display:inline-block; width:100%;">
                	<div class="col-sm-4 five-points">
                		<img src="<?php echo base_url(); ?>images/new_images/pointeforce/selling_prdct.png" />
                        <p>Make money by selling<br /> products you love</p>
                    </div>
                    <div class="col-sm-4 five-points">
                    	<img src="<?php echo base_url(); ?>images/new_images/pointeforce/comission.png" />
                        <p>Commission on every sale<br /> you make</p>
                    </div>
                    <div class="col-sm-4 five-points">
                    	<img src="<?php echo base_url(); ?>images/new_images/pointeforce/grow_term.png" />
                        <p>Grow your team and<br /> make more money</p>
                    </div>
                </div>
                <div class="col-sm-12" style="display:inline-block; width:100%;">
                	<div class="col-sm-2"> &nbsp;</div>
                    <div class="col-sm-4 five-points">
                    	<img src="<?php echo base_url(); ?>images/new_images/pointeforce/flexible_work.png" />
                        <p>Flexible working hours</p>
                    </div>
                    <div class="col-sm-4 five-points">
                    	<img src="<?php echo base_url(); ?>images/new_images/pointeforce/own_boss.png" />
                        <p>Be your own boss</p>
                    </div>	
                    <div class="col-sm-2">&nbsp;</div>
                </div>
            </div>
        </div>
        
        <div class="row main-rows">
        	<div class="col-sm-12 force-form">
            	<div class="cirlce-img-force"><img src="<?php echo base_url(); ?>images/new_images/pointeforce/form_img.png" /></div>
				<div class="clearfix"></div>
				<div class="col-sm-12">
				<center><ul class="listp">
					<li><a href="<?php echo base_url().'pointeforce'; ?>#joinus"  class="btn btn-force-dctive">Join With Us</a></li>
					<li><a href="<?php echo base_url().'pointeforce/customer_request'; ?>"  class="activep btn btn-force-active">Already a customer</a></li>
				</ul></center>
				</div>
				<div class="clearfix"></div>
            	<div class="forceform-head">
                	<h1 style="margin-top:25px;">Already a customer?</h1>
                	<p>
                    	Login here to send us a request for joining Pointeforce Team.
                    </p>
					<?php /*?><a href="<?php echo base_url().'pointeforce/customer_request'; ?>">
						Already a customer
					</a>
					<a href="<?php echo base_url().'pointeforce'; ?>">
					</a><?php */?>
                </div>
<?php 
echo form_open();
?>
<div class="forceform-contant">
	<div class="col-sm-12 form-group" style="padding-top:0;">
    	<div class="col-sm-6">
        	<input class="form-control force-input" placeholder="Email Address" name="email" value="<?php echo htmlentities(set_value('email')); ?>" type="text" />
			<?php echo form_error('email'); ?>
        </div>
     
		<div class="col-sm-6">
        	<input class="form-control force-input" placeholder="Password" name="password" value="<?php echo set_value('password'); ?>" type="password"  />
			<?php echo form_error('password'); ?>
		</div>
		<div class="col-sm-6"></div>
		<?php /*?><div class="col-sm-6">
		   <a href="<?php echo base_url().'pointeforce/forgot_password'; ?>#ForgotPassword" class="pull-right">Forgot your password?</a>
		</div><?php */?>
	</div>
	
	<div class="col-sm-12 form-group text-center">
    	<button class="btn btn-success submit-force" name="pointeForceReq" value="POINTEFORCEREQUEST">Submit Request</button>
    </div>
</div>
</form>

            </div>
        </div>
        
    </div>
    <div class="col-sm-1"></div>
</div>
</div>

<style>
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
.listp{ padding-top:30px;}
.listp li{ list-style-type:none;  text-align:center; display:inline-block; margin:10px;}
.listp li a{ color:#979797; font-size:1em;}
.activep{ color: #1c1c1c !important; text-decoration:underline; font-weight:bold;}
.force-input { height:46px !important;}

.activep{background:#f7941e;
	color:#fff !important;
	text-decoration:none;
	width:168px;
}
.btn-force-dctive{background:#f7941e;
	opacity:0.6;
	color:#fff !important;
	width:168px;
	font-weight:bold;
}

</style>