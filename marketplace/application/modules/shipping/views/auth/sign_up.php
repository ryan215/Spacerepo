<link href="<?php echo base_url(); ?>css/shipping/skins/square/red.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/shipping/skins/minimal/red.css" rel="stylesheet">
<style>
.radio, .checkbox{
	width: auto;
	display: inline-block;
	padding-left:0px !important;
}
.checkbox-inline{
	font-size: 12px;
}
.uImg{
	width: 100% !important;
  height: 95px !Important;
}
.checkbox{
	margin-right:5px;
	padding-bottom:10px;
}
.stateIDArr{
	   top: 7px;
}
.radio label, .checkbox label {
    font-size: 12px;
}
.upload-green{
	display:none !important;
}
</style>		 

<script src="<?php echo base_url(); ?>js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
base_url = '<?php echo base_url(); ?>';
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/upsloadfilemulti.css" />
<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	if($("#hideImage").val()!='')
	{
		$("#imgname").html('<img class="img-circle" src="<?php echo base_url().'images/239389-upload_arrow_up-128.png'; ?>" height="100" width="100" style=" width: 9%;  height: 40px;"><span>'+dats.newImageName+'</span>');
	}
	$("#imgErr").html('');	
	var settings = {
    url: "<?php echo base_url().'shipping/shipping_upload_document'; ?>",
    method: "POST",
    allowedTypes:"xlsx,xls",
    fileName: "myfile",
    multiple: false,
	dragDropStr:'',
	uploadButtonClass:'',
	showFileCounter:false,
	progressbar:true,
    onSuccess:function(files,data,xhr)
    {	
		$("#imgErr").html('');
		dats = $.parseJSON(data); 
		console.log(dats);
		if(dats.error=='')
		{
			$("#hideImage").val(dats.newImageName);		
			$("span#imgname").html($("div.upload-statusbar:first > div.upload-filename").html());
			$("div.upload-statusbar").hide();
        	$("#status").html("<font color='green'>Upload is success</font>");
	        $("#imgname").html('<img class="img-circle" src="<?php echo base_url().'images/239389-upload_arrow_up-128.png'; ?>" height="100" width="100" style=" width: 9%;  height: 40px;"><span>'+dats.newImageName+'</span>');
		}
		else
		{
			$("#imgErr").html(dats.error);
		}
    },
    afterUploadAll:function()
    {
        //alert("all images uploaded!!");
    },
    onError: function(files,status,errMsg)
    {        
        $("#status").html("<font color='red'>Upload is Failed</font>");
    }
	}
	$("#uploadImage").uploadFile(settings);
});
</script>

<!--start main contant-->
<div class="container">		
	<div class="col-sm-12">
    	<div class="col-sm-12">
        	<div class="col-sm-12 log-in-box  main-shi-div">
				<?php 
				$attributes = array('class' => 'form-horizontal shipping-form');
				echo form_open('',$attributes);
				?>

                    	<h2>Sign Up</h2>
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
                        	<div class="icon-addon addon-md">
                                <input type="email" id="Email" class="form-control ship-input" placeholder="Email" name="email" value="<?php echo $result['email']; ?>">
                                <label title="Email"  class="fa fa-envelope-o input-label" for="Email"></label>
								<?php echo form_error('email'); ?>
                            </div>                        
                        </div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
                                <input type="password" id="password" class="form-control ship-input" placeholder="Password" name="password" value="<?php echo $result['password']; ?>">
                                <label title="password" class="fa fa-lock input-label" for="password"></label>
								<?php echo form_error('password'); ?>
                            </div>                      
 						</div>
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon">
                                <input type="password" id="cpassword" class="form-control ship-input" placeholder="Confirm Password" name="cpassword" value="<?php echo $result['cpassword']; ?>">
                                <label title="Confirm Password"  class="fa fa-lock input-label" for="cpassword"></label>
								<?php echo form_error('cpassword'); ?>
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
						
						
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon"> 
								<input type="hidden"  name="shipp_user_type" class="form-control ship-input" value="shipping_vendor">
							</div>                      
 						</div>
						<div class="col-sm-12 " style="padding:0px;">
						<div id="forShippVendor">
						<div class="col-sm-6 padding-bottom">                        
                        	<div class="icon-addon"> 
								<input type="hidden" name="image_name" id="hideImage" value="<?php echo $result['image_name']; ?>" />
								<div id="uploadImage">
									<span id="imgname">
										<img class="img-circle" src="<?php echo base_url().'images/239389-upload_arrow_up-128.png'; ?>" height="100" width="100" style=" width: 9%;  height: 40px;">
										&nbsp;&nbsp;&nbsp;&nbsp; 
										Upload Your Rate List
									</span>
								</div>								
                            </div>
							<div id="imgErr" class="error"></div>
							<?php echo form_error('image_name'); ?>
							<a href="<?php echo base_url().'shipping/file_download'; ?>" style="color: #7bc570; text-decoration:none; top:10px; position:relative;">
								Download Document Format
							</a>
 						</div>
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
                                <label title="Point of Contact Phone Number"   for="Point of Contact Phone Number">Area </label>
								<div class="square-red single-row" id="areaChkbx">
                                                                                  
                                 </div>
								 <?php echo form_error('area_id[]');  ?>
                            </div>                      
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
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<?php /*?><script src="<?php echo base_url(); ?>js/shipping/jquery.icheck.js"></script>
<script src="<?php echo base_url(); ?>js/shipping/icheck-init.js"></script><?php */?>
<script type="text/javascript">
function cityAjax()
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'shipping/city_list' ?>',
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
		url:'<?php echo base_url().'shipping/zone_list' ?>',
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
		url:'<?php echo base_url().'shipping/area_list' ?>',
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

function shipp_user(userType)
{	
	$('#forShippVendor').css('display','none');
	if(userType=='shipping_vendor')
	{
		$('#forShippVendor').css('display','block');
	}
}

<?php 
if((!empty($result['shipp_user_type']))&&($result['shipp_user_type']=='shipping_vendor'))
{
?>
shipp_user('shipping_vendor');
<?php 
}

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
