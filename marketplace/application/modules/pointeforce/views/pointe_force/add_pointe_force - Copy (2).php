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
				<a href="#joinus" class="btn btn-danger btn-forcesignup pull-right" style="background:#F7941E; color:#fff; border:1px solid #F7941E; font-size:15px; text-transform:uppercase;   margin-top: 5px; display:inline-block;">Join Us</a>
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
        
        <div class="row main-rows"  id="joinus">
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
        <?php
		if($this->session->userdata('userId'))
		{
			if($this->session->userdata('isPointeForce'))
			{
			}
			else
			{
			?>
			<div class="row main-rows" >
        		<div class="col-sm-12 force-form">
            		<div class="cirlce-img-force">
						<img src="<?php echo base_url(); ?>images/new_images/pointeforce/form_img.png" />
					</div>
	            	<div class="clearfix"></div>
					<div class="col-sm-12">
						<center>
							<ul class="listp">
								<li><a href="<?php echo base_url().'pointeforce/login_customer_request_for_pointe_force'; ?>" class="activep">Join With Us</a></li>
							</ul>
						</center>
					</div>
					<div class="clearfix"></div>
				</div>
       		</div>
			<?php
			}
		}
		else
		{
		?>
        <div class="row main-rows" >
        	<div class="col-sm-12 force-form">
            	<div class="cirlce-img-force"><img src="<?php echo base_url(); ?>images/new_images/pointeforce/form_img.png" /></div>
            	<div class="clearfix"></div>
				<div class="col-sm-12">
				<center><ul class="listp">
					<li><a href="<?php echo base_url().'pointeforce'; ?>" class="activep">Join With Us</a></li>
					<li><a href="<?php echo base_url().'pointeforce/customer_request'; ?>#Alreadyacustomer">Already a customer</a></li>
				</ul></center>
				</div>
				<div class="clearfix"></div>
				<div class="forceform-head">
				
                	<h1>Join With Us</h1>
                	<p>
                    	To be part of The PointeForce, Fill and submit the below form <br />
& a PointeForce Consultant will be in touch. All fields are mandatory.
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
                	<div class="col-sm-12 form-group">
                    	<div class="col-sm-6">
                        	<input class="form-control force-input" placeholder="First name" name="firstName" value="<?php echo set_value('firstName'); ?>"/>
							<?php echo form_error('firstName'); ?>
                        </div>
                        <div class="col-sm-6">
                        	<input class="form-control force-input" placeholder="Last name" name="lastName" value="<?php echo set_value('lastName'); ?>"/>
							<?php echo form_error('lastName'); ?>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group" style="padding-top:0;">
                    	<div class="col-sm-6">
                        	<input class="form-control force-input" placeholder="Email Address" name="email" value="<?php echo htmlentities(set_value('email')); ?>" />
							<?php echo form_error('email'); ?>
                        </div>
                        
                        <div class="col-sm-6">
                        	<input class="form-control force-input" placeholder="Phone number" name="phoneNo" value="<?php echo set_value('phoneNo'); ?>"  />
							<?php echo form_error('phoneNo'); ?>
                        </div>
                        
                        
					</div>
                    
                    <div class="col-sm-12">
                    	<div class="col-sm-6">
                        	<input class="form-control force-input" placeholder="Password" name="password" type="password" id="myPassword" style="height:46px;"  data-placement="top" data-toggle="tooltip" data-original-title="Note : Passwords must be a minimum of 8 characters and include at least one capital, lower case and numeric" />
							<?php echo form_error('password'); ?>
							<p style="line-height:15px; margin-bottom:8px; margin-top:2px;"></p>
                        </div>
                        <div class="col-sm-6">
                        	<input class="form-control force-input" placeholder="Confirm Password" name="confirmPassword" value="<?php echo set_value('confirmPassword'); ?>" type="password"  style="height:46px;"/>
							<?php echo form_error('confirmPassword'); ?>
                        </div>
					</div>
					
					<div class="col-sm-12" style="display:INLINE-BLOCK;">
                    	<div class="col-sm-6" style="padding-top:0;">
                        	<div class="row">
                            	<div class="col-sm-4 form-group">
                                	<select class="form-control c-selectpicker c-slct-small force-input" name="date" data-placement="top" data-toggle="tooltip" data-original-title="Select Birth Date">
                                    	<option value="">Date</option>
										<?php
										for($i=1;$i<=31;$i++)
										{
										?>
										<option value="<?php echo $i; ?>" <?php echo set_select('date',$i); ?>>
											<?php echo $i; ?>
										</option>
										<?php
										}
										?>
                                    </select>
									<?php echo form_error('date'); ?>
                                </div>
                                <div class="col-sm-4  form-group">
                                	<select class="form-control c-selectpicker c-slct-small force-input" name="month" data-placement="top" data-toggle="tooltip" data-original-title="Select Birth Month">
                                    	<option value="">Month</option>
										<?php
										for($i=1;$i<=12;$i++)
										{
										?>
										<option value="<?php echo $i; ?>" <?php echo set_select('month',$i); ?>>
											<?php echo $i; ?>
										</option>
										<?php
										}
										?>
                                    </select>
									<?php echo form_error('month'); ?>
                                </div>
                                <div class="col-sm-4 form-group">
                                	<select class="form-control c-selectpicker c-slct-small force-input" name="year" data-placement="top" data-toggle="tooltip" data-original-title="Select Birth Year">
										<option value="">Year</option>
										<?php
										for($i=1900;$i<=2015;$i++)
										{
										?>
										<option value="<?php echo $i; ?>" <?php echo set_select('year',$i); ?>>
											<?php echo $i; ?>
										</option>
										<?php
										}
										?>
                                    </select>
									<?php echo form_error('year'); ?>
                                </div>
                            </div>
                        </div>
                        
						<div class="col-sm-6 form-group" >
                        	<select class="form-control force-input c-selectpicker" name="stateId" onchange="area_list(this.value);">
								<option value="">Select State</option>
								<?php
								if(!empty($stateList))
								{
									foreach($stateList as $row)
									{
								?>
							<option value="<?php echo $row->stateId; ?>" <?php echo set_select('stateId',$row->stateId); ?>>
								<?php echo $row->stateName; ?>
							</option>
							<?php
									}
								}
							?>
						</select>
						<?php echo form_error('stateId'); ?>
                        </div>
					</div>
					
                    <div class="col-sm-12 form-group" style="padding-top:0;">
                    	
						
                        <div class="col-sm-6">
                        	<div id="areaList">
							<select name="areaId" class="form-control force-input c-selectpicker">
								<option value="">Select Area</option>
							</select>
						</div>
						<?php echo form_error('areaId'); ?>
                        </div>
						<div class="col-sm-6">
                        	<div id="cityList">
								<select name="cityId" class="form-control force-input c-selectpicker">
									<option value="">Select City</option>
								</select>
							</div>
							<?php echo form_error('cityId'); ?>
                        </div>
					</div>
                    <div class="col-sm-12 form-group" style="padding-top:0;">
						
						<div class="col-sm-12">
                        <input class="form-control force-input" placeholder="Street" name="address1" value="<?php echo set_value('address1'); ?>" />
						<?php echo form_error('address1'); ?>
                        </div>
                    	
					</div>
					
					
                    <div class="col-sm-12 form-group text-center">
                    	<button class="btn btn-success submit-force" name="pointeForceReq" value="POINTEFORCEREQUEST">Submit</button>
                    </div>
                </div>
				</form>
            </div>
        </div>
        <?php
		}
		?>
    </div>
    <div class="col-sm-1"></div>
</div>
</div>





<script type="text/javascript">
function area_list(stateId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/areaStateList'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo htmlentities($result['areaId']); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#areaList').html(result);
			city_list($('#areaId').val());
			$('#areaId').removeClass('selectpicker');
			$('#areaId').removeClass('show-menu-arrow');
			$('#areaId').addClass('form-control');
			$('#areaId').addClass('force-input');
			
		}
	});
}

function city_list(areaId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/cityAreaList'; ?>',
		data:'areaId='+areaId+'&cityId=<?php echo htmlentities($result['cityId']); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);
			$('#cityId').removeClass('selectpicker');
			$('#cityId').removeClass('show-menu-arrow');
			$('#cityId').addClass('form-control');
			$('#cityId').addClass('force-input');
			$('#cityId').addClass('c-selectpicker');			
		}
	});
}
<?php
if($result['stateId'])
{
?>
area_list('<?php echo htmlentities($result['stateId']); ?>');
<?php
}
if($result['areaId'])
{
?>
city_list('<?php echo htmlentities($result['areaId']); ?>');
<?php
}
?>
</script>
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
.strength_meter{
position: absolute;
left: 15px !important;
top: 47px !important;
width: 50%;
height: 5px;
z-index:1 !important;
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
top: -6px !important;
left: 0 !important;
color: #666 !important;
font-size:13px;
right:auto !important;
}

.veryweak{
    background-color: #CD0000;
border-color: #F04040!important;
width:25%!important;
}
.weak{
background-color: #f8e685;
border-color: #FF853C!important;
width:50%!important;
}
.medium{
background-color: #FFEC8B;
border-color: #FC0!important;
width:75%!important;
}
.strong{
background-color: #ABD86B !important;
border-color: #8DFF1C!important;
width:100%!important;
}
.listp{ padding-top:20px;}
.listp li{ list-style-type:none;  text-align:center; display:inline-block; margin:10px;}
.listp li a{ color:#979797; font-size:1em;font-weight:bold;}
.activep{ color: #1c1c1c !important; text-decoration:underline;}
</style>


<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'right'
    });
});
</script>
