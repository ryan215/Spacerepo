<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}
/*end of user detail page*/

.ajax-upload-dragdrop
{
	padding:10px 13px 0px 26px !important; 
	border:none !important; 
}

.fileupload-exists
{
	padding:10px 13px 0px 26px !important;
}

</style>



<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/uploadfilemulti.css" />
<script src="<?php echo base_url(); ?>js/file_upload/jquery.fileuploadmulti.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	if($("#hideretailerimage").val()!='')
	{
		$("#retailerimgname").html('<img class="img-circle" src="<?php echo base_url(); ?>uploads/retailer/thumb50/'+$("#hideretailerimage").val()+'" height="100" width="100" />');
	}
	
	var settings = {
    url: "<?php echo base_url(); ?>retailer/upload_retailer_image/",
    method: "POST",
    allowedTypes:"jpg,png,gif,jpeg",
    fileName: "myfile",
    multiple: false,
	dragDropStr:'',
	uploadButtonClass:'',
	showFileCounter:false,
	progressbar:true,
	showAbort:false,
    onSuccess:function(files,data,xhr)
    {	
		$("#hideretailerimage").val(data);
		$("span#retailerimgname").html($("div.upload-statusbar:first > div.upload-filename").html());
		$("div.upload-statusbar").hide();
        $("#status").html("<font color='green'>Upload is success</font>");
        $("#retailerimgname").html('<img class="img-circle" src="<?php echo base_url(); ?>uploads/retailer/thumb50/'+data+'" height="100" width="100" />');
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
	$("#upload_retailer_image").uploadFile(settings);
});

$(document).ready(function(){
	$('.selectpicker').selectpicker({
	});
});
</script>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
        	<div class="col-lg-12">
			
            	<section class="panel">
					
                	<div class="col-sm-12 page-header">Profile Detail</div>
<?php 
echo form_open();
?>                                                                                           						<div class="row">							
                            <aside class="profile-info col-lg-12">
							
								<section class="panel">
						        	<div class="panel-body bio-graph-info">
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Business Information
												</th>
						                    </thead>                    
											<tbody>
 							                   	<tr>
						                        	<td width="35%">Business Name : </td>
						                            <td>
													<input type="text" class="form-control model-input" name="business_name" value="<?php echo ucwords($users_details->first_name).' '.$users_details->last_name; ?>" />
													<?php echo form_error('business_name'); ?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Business Phone Number : </td>
						                            <td>
													<input type="text" class="form-control model-input" name="business_ph_no" value="<?php echo $users_details->business_ph_no; ?>" />
													<?php echo form_error('business_ph_no'); ?>
													</td>
                         						</tr>                         						
											</tbody>
                    					</table>
						            	
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Personal Information
												</th>
						                    </thead>
                    
											<tbody>
												<tr>
						                        	<td width="35%">Image : </td>
						                            <td>
														
														<div id="upload_retailer_image">
											<span id="retailerimgname">
											<?php
											$image = '<img class="img-circle" src="'.base_url().'images/default_user_image.jpg" height="100" width="100">';		
											$image_name = $users_details->image;
											if((!empty($image_name))&&(file_exists('uploads/retailer/'.$image_name)))											
											{
												$image = '<img height="100" width="100" class="img-circle" src="'.base_url().'uploads/retailer/'.$image_name.'" alt="" />';
											}									
											echo $image;
											?>
											&nbsp;&nbsp;&nbsp;&nbsp; 
											Upload your display image
											</span>
										</div>
										<input type="hidden" name="image_name" id="hideretailerimage" value="<?php if(set_value('image_name')){ echo set_value('image_name'); }else{ echo $image_name; } ?>" />
														
														<?php echo form_error('image_name'); ?>
													</td>
                        						</tr>
												
 							                   	<tr>
						                        	<td width="35%">Business Owner Name : </td>
						                            <td>
														<input type="text" class="form-control model-input" name="business_owner_name" value="<?php echo ucwords($users_details->business_owner_name); ?>" />
														<?php echo form_error('business_owner_name'); ?>
													</td>
                        						</tr>
												<tr>
						                        	<td width="35%">Phone Number : </td>
						                            <td>
														<input type="text" class="form-control model-input" name="phone_no" value="<?php echo $users_details->phone_no; ?>"/>
														<?php echo form_error('phone_no'); ?>
													</td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Email : </td>
						                            <td>
														<?php 
															echo $users_details->email; 
														?>
													</td>
                         						</tr>
												
												<tr>
						                        	<td width="35%">Bank Name : </td>
						                            <td>
														<input type="text" class="form-control model-input" name="bankName" value="<?php echo $users_details->bank_name; ?>"/>
														<?php echo form_error('bankName'); ?>
													</td>
                        						</tr>
												<tr>
						                        	<td width="35%">Account Name : </td>
						                            <td>
														<input type="text" class="form-control model-input" name="accountName" value="<?php echo $users_details->account_name; ?>"/>
														<?php echo form_error('accountName'); ?>
													</td>
                        						</tr>
												<tr>
						                        	<td width="35%">Account Number : </td>
						                            <td>
														<input type="text" class="form-control model-input" name="accountNo" value="<?php echo $users_details->account_number; ?>"/>
														<?php echo form_error('accountNo'); ?>
													</td>
                        						</tr>
												 <tr>
						                        	<td width="35%">Branch Address : </td>
						                            <td>
														<input type="text" class="form-control model-input" name="branchAdd" value="<?php echo $users_details->branch_address; ?>"/>
														<?php echo form_error('branchAdd'); ?>
													</td>
                        						</tr>                        						
											</tbody>
										</table>
									  
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Address
												</th>
						                    </thead>
                    
											<tbody>
 							                	<tr>
						                        	<td width="35%">Country Name : </td>
						                            <td>
														<?php
																echo $this->location_m->country_list_dropdown($users_details->country_id);
																echo form_error('country_id'); 
											?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">State Name : </td>
						                            <td>
														<div id="stateAjaxID">
				
														</div>
													<?php echo form_error('state_id'); ?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Zone Name : </td>
						                            <td>
														<div id="cityAjaxID">
				
														</div>
																<?php echo form_error('city_id'); ?>
													</td>
						                         </tr>
												 
												  <tr>
						                         	<td width="35%">Area Name : </td>
						                            <td>
															<div id="zoneAjaxID">
				
															</div>
														<?php echo form_error('zone_id'); ?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Area Name : </td>
						                            <td>
														<div id="areaAjaxID">
				
															</div>
													<?php echo form_error('area_id'); ?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Street : </td>
						                        <td>
														<input type="text" name="street" class="form-control model-input" value="<?php 
														echo $users_details->street; 
													?>" />
												</td>
						                	</tr>
                      					</tbody>
                    				</table>
                                       <table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													comment
												</th>
						                    </thead>
                                            <tbody>
                                            <tr>
                                            <td>
                                            <textarea name="comment" class="form-control model-input" ><?php 
														echo $users_details->comment; 
													?>
                                                    </textarea>
                                            </td>
                                            </tr>
                                            </tbody>
                                            </table>
                    				
                    				<div class="col-sm-12 text-right">
										<button class="btn btn-success ad_btn" type="submit">Update Profile</button>	
									</div>	
                            	</div>
                        	</section>
						
        	</div>
			</form>
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->
<script>
function state_list(cntryID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url(); ?>retailer/state_list/'+cntryID+'/<?php echo $users_details->state_id; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateAjaxID').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#stateAjaxID').html(result);
			city_list($('#state_id').val());				
		}
	});
}

function city_list(stateID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url(); ?>retailer/city_list/'+stateID+'/<?php echo $users_details->city_id; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityAjaxID').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#cityAjaxID').html(result);
			zone_list($('#city_id').val());				
		}
	});	
}

function zone_list(cityID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url(); ?>retailer/zone_list/'+cityID+'/<?php echo $users_details->zone; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#zoneAjaxID').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#zoneAjaxID').html(result);
			area_list($('#zone_id').val());			
		}
	});
}
function area_list(zoneID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url(); ?>retailer/area_list/'+zoneID+'/<?php echo $users_details->area; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaAjaxID').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#areaAjaxID').html(result);
		}
	});
}
state_list($('#country_id').val());

</script>