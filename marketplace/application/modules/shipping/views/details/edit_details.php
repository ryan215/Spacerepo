<link href="<?php echo base_url(); ?>css/shipping/shipping_login.css" rel="stylesheet">

<style>
label{
background:none;
}
</style>		 


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'shipping_vendor/details'; ?>">Details</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Edit</a>
					</li>
				</ul>
			</div>
			
			<div class="col-lg-12">
				<section class="panel">
					<!------------------------>
		 



<!--start main contant-->
<div class="container">		
	<div class="col-sm-12" style="padding:0px;">
    	<div class="col-sm-12" style="padding:0px;">
        	<div class="col-sm-12 log-in-box" style="padding-top:40px;">
				<?php 
$attributes = array('class' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

                        <div class="col-sm-6 padding-bottom">	
							<div class="icon-addon addon-md">
                                <input type="text" id="first_name" class="form-control ship-input" placeholder="First Name" name="first_name" value="<?php echo $result['first_name']; ?>">
				
                                <label title="First Name"  class="fa fa-user input-label" for="first_name"></label>
								<?php echo form_error('first_name'); ?>
                            </div>                        
                        </div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
                                <input type="text" id="last_name" class="form-control ship-input" placeholder="Last Name" name="last_name" value="<?php echo $result['last_name']; ?>">
                                <label title="Last Name"  class="fa fa-user input-label" for="last_name"></label>
								<?php echo form_error('last_name'); ?>
                            </div>                      
 						</div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
                                <input type="text" id="business_name" class="form-control ship-input" placeholder="Business Name" name="business_name" value="<?php echo $result['business_name']; ?>">
                                <label title="Business Name"  class="fa fa-user input-label" for="business_name"></label>
								<?php echo form_error('business_name'); ?>
                            </div>                      
 						</div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
								<input type="text" class="form-control ship-input" placeholder="Corporate Address" name="business_address" value="<?php echo $result['business_address']; ?>">
                                <label title="Corporate Address" class="fa fa-map-marker input-label" for="Corporate Address"></label>
								<?php echo form_error('business_address'); ?>
                            </div>                      
 						</div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
                                <input type="text" id="" class="form-control ship-input" placeholder="Corporate phone Number" name="business_ph_no" value="<?php echo $result['business_ph_no']; ?>">
                                <label title="Corporate phone Number"  class="fa fa-phone-square input-label" for="Corporate phone Number"></label>
								<?php echo form_error('business_ph_no'); ?>
                            </div>                      
 						</div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
                                <input type="text" id="phone_no" class="form-control ship-input" placeholder="Point of Contact Phone Number" name="phone_no" value="<?php echo $result['phone_no']; ?>">
                                <label title="Point of Contact Phone Number"  class="fa fa-phone input-label" for="phone_no"></label>
								<?php echo form_error('phone_no'); ?>
                            </div>                      
 						</div>
						
						<div class="col-sm-12 " style="padding:0px;">
						
						<div class="col-sm-12 padding-bottom">
							<label title="Country"   for="Country"><b>Country</b> : </label>
							<span style="color:#999999;">Nigeria</span>
						</div>
						<div class="col-sm-12 padding-bottom">                        
                        	<div class="icon-addon">                               
                                <label title="Point of Contact Phone Number"   for="Point of Contact Phone Number">States</label>
								<div class="square-red single-row">
									<table style="border:1px solid #ddd;">
										<?php 
										$stateList = $this->location_m->state_list($result['country_id']);
										if(!empty($stateList))
										{
											$i=0;
											foreach($stateList as $row)
											{
												$checked = '';
												if(!empty($result['selctState_id']))
												{
													if(in_array($row->state_id,$result['selctState_id']))
													{
														$checked = ' checked="checked" ';
													}
												}
												
												if($i%5==0)
												{
												?>
												<tr>
												<?php
												}
										?>
											<td width="24%" style="padding-left:10px;padding-right:10px;" ><div class="checkbox">
												<label class="">
													<input type="checkbox" name="state_id[]" value="<?php echo $row->state_id; ?>" <?php echo $checked; ?> onclick="cityAjax();" class="stateIDArr"  />
													<?php echo $row->state_name; ?>
												</label>
											</div>
											</td> 
											<?php
												if($i%5==4)
												{
												?>
												</tr>
												<?php
												}
												$i++;
												
											}
											echo form_error('state_id[]'); 
										}
									?> 
									</table>
                               </div>
                            </div>                      
 						</div>
						<div class="col-sm-12 padding-bottom">                        
                        	<div class="icon-addon">                               
                            	<label title="Point of Contact Phone Number"   for="Point of Contact Phone Number">
									Zone
								</label>
								<div class="square-red single-row" id="cityChkbx">
                                                	                                                
                                 </div>
								 <?php echo form_error('city_id[]');  ?>
                            </div>                      
 						</div>
						<div class="col-sm-12 padding-bottom">                        
                        	<div class="icon-addon">                               
                                <label title="Point of Contact Phone Number"   for="Point of Contact Phone Number">Area</label>
								<div class="square-red single-row" id="zoneChkbx">
                                                                                 
                                 </div>
								 <?php echo form_error('zone_id[]');  ?>
                            </div>                      
 						</div>
						<div class="col-sm-12 padding-bottom">                        
                        	<div class="icon-addon">                               
                                <label title="Point of Contact Phone Number"   for="Point of Contact Phone Number">City </label>
								<div class="square-red single-row" id="areaChkbx">
                                                                                  
                                 </div>
								 <?php echo form_error('area_id[]');  ?>
                            </div>                      
 						</div>
						</div>
						
						
						<div class="clearfix"></div>
						<div style="width:200px; margin:0 auto;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block ship-sign-btn">Save</button>
                        </div>
						</div>
                    </form>  
                </div>
            </div>
           
        </div>
	</div> 
<!--end of main conatnt-->


					<!------------------------->					
				</section>
			</div>
		</div>		
	</section>
</section>		
<!--main content end-->


<script type="text/javascript">
function cityAjax()
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'shipping_vendor/city_list' ?>',
		data:{
			stateID_arr:$('input[class="stateIDArr"]:checked').serializeArray(),
			selctCity_id:'<?php echo json_encode($result['selctCity_id'],true); ?>',
			'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',
		},
		beforeSend: function() {
			$('#cityChkbx').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityChkbx').html(result);
			zoneAjax();
		}
	});
}

function zoneAjax()
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'shipping_vendor/zone_list' ?>',
		data:{
			cityID_arr:$('input[class="cityIDArr"]:checked').serializeArray(),
			selctZone_id:'<?php echo json_encode($result['selctZone_id'],true); ?>',
			selctCity_id:'<?php echo json_encode($result['selctCity_id'],true); ?>',
			'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',
		},
		beforeSend: function() {
			$('#zoneChkbx').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#zoneChkbx').html(result);
			areaAjax();
		}
	});
}

function areaAjax()
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'shipping_vendor/area_list' ?>',
		data:{
			zoneID_arr:$('input[class="zoneIDArr"]:checked').serializeArray(),
			selctArea_id:'<?php echo json_encode($result['selctArea_id'],true); ?>',
			selctZone_id:'<?php echo json_encode($result['selctZone_id'],true); ?>',
			'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',
		},
		beforeSend: function() {
			$('#areaChkbx').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#areaChkbx').html(result);
		}
	});
}

<?php 
if(!empty($result['selctState_id']))
{
?>
cityAjax();
<?php
}
if(!empty($result['selctCity_id']))
{
?>
zoneAjax();
<?php
}
if(!empty($result['selctZone_id']))
{
?>
areaAjax();
<?php
}
?>	
</script>