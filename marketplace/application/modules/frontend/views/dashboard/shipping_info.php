<section class="main-container col1-layout">
	<div class="main container">
  		<div class="col-main">
			<!--breadcrumb-->
 			<div class="breadcrumbDiv">
				<ul class="breadcrumb">
					<li> <a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active"><a href="<?php echo base_url().'frontend/dashboard'; ?>">Dashboard</a></li>
                	<li class="active">Primary Shipping Address</li>
				</ul>
			</div>
			<!--breadcrumb-->
			
			<div class="col-sm-9" style="padding-left:0px;">
        		<div class="my-account">
					<div class="page-title">
						<h2>Primary Shipping Address</h2> 
					</div>
<?php 
echo form_open();
?>                                                                                           					<div class="dashboard">
						<div class="box-account">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label for="InputName">First Name <span class="required">*</span></label>
										<input type="text" class="form-control account-input" id="InputName" placeholder="First Name" value="<?php echo $result['shipping_first_name']; ?>" name="first_name">
					<?php echo form_error('first_name'); ?>
										
								</div>
                  				<div class="form-group">
									<label for="InputLastName">Last Name <span class="required">*</span></label>
									<input type="text" class="form-control account-input" id="InputLastName" placeholder="Last Name" value="<?php echo $result['shipping_last_name']; ?>" name="last_name">
									<?php echo form_error('last_name'); ?>
								</div>
                  				<div class="form-group">
									<label for="InputEmail">Email <span class="required">*</span></label>
									<input type="text" class="form-control account-input" id="InputEmail" placeholder="Email" name="email" value="<?php echo $result['shipping_email']; ?>">
									<?php echo form_error('email'); ?>
								</div>
								<div class="form-group">
									<label for="InputCompany">Company </label>
									<input type="text" class="form-control account-input" id="InputCompany" placeholder="Company" name="company" value="<?php echo $result['shipping_company']; ?>">
									<?php echo form_error('company'); ?>
								</div>
                  				<div class="form-group ">
									<label for="InputMobile">Mobile phone <span class="required">*</span></label>
									<input  type="text"  class="form-control account-input" id="InputMobile" name="phone_no" value="<?php echo $result['shipping_phone_no']; ?>">
									<?php echo form_error('phone_no'); ?>
								</div>
                 				<div class="form-group">
									<label for="Zipcode">Zipcode / Postal Code <span class="required">*</span></label>
									<input  type="text"  class="form-control account-input" id="Zipcode" name="zipcode" value="<?php echo $result['shipping_zipcode']; ?>">
									<?php echo form_error('zipcode'); ?>
								</div>
                  			</div>
                
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label for="Country">Country <span class="required">*</span></label>
								<div>
									<?php
									echo $this->location_m->country_list_dropdown($country_id);
									echo form_error('country_id');
									?>
                    			</div>
                			</div>
                			
							<div class="form-group">
                				<label for="State">State <span class="required">*</span></label>
                    			<div id="stateAjaxID">
									<select class="form-control" name="state_id" id="state_id">
										<option value="">Select State</option>
									</select>
								</div>
								<?php echo form_error('state_id'); ?>
                			</div>
							
               		 		<div class="form-group">
								<label for="Zone">Zone <span class="required">*</span></label>
								<div id="cityAjaxID">
									<select class="form-control" name="city_id" id="city_id">
										<option value="">Select Zone</option>
									</select>
								</div>
								<?php echo form_error('city_id'); ?>
                			</div>
							
                			<div class="form-group">
                    			<label for="Area">Area <span class="required">*</span></label>
								<div id="zoneAjaxID">
									<select class="form-control" name="zone_id" id="zone_id">
										<option value="">Select Area</option>
									</select>
								</div>
								<?php echo form_error('zone_id'); ?>
                			</div>
							
                			<div class="form-group">
                    			<label for="City">City <span class="required">*</span></label>
                    			<div id="areaAjaxID">
									<select class="form-control" name="area_id" id="area_id">
										<option value="">Select City</option>
									</select>
								</div>
								<?php echo form_error('area_id'); ?>
			                </div>
			                <div class="form-group">
			                    <label for="Street">Street <span class="required">*</span></label>
			                    <input class="form-control sign-input account-input"  id="Street" placeholder="Street" name="street" value="<?php echo $result['shipping_street']; ?>">
								<?php echo form_error('street'); ?>	
			                </div> 
                       		
							<div class="form-group">
								<label for="InputAdditionalInformation">Additional information</label>
								<textarea rows="3" cols="26" class="form-control account-input" id="InputAdditionalInformation" name="additionalInfo"><?php echo $result['additionalInfo']; ?></textarea>
								<?php echo form_error('additionalInfo'); ?>
                  			</div>
                  		</div>
                		<div class="col-sm-12 text-right">
							<button class="btn btn-primary btn-savchange" type="submit"> Save Changes</button>
						</div>
					</div>
				</div>
					</form>
			</div>
		</div>
		
	  	<?php $this->load->view('right_bar'); ?>
  		</div>
	</div>
</section>
<script type="text/javascript">

function state_list(countryId,stateId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/home/stateCountryPhoneCodeList'; ?>',
		data:'countryId='+countryId+'&stateId='+stateId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		dataType:'json',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result.view);
			
			$('#countryCode').val(result.phoneCode);	
			
			city_list($('#stateId').val());		
					
		}
	});
}

function city_list(stateId,cityId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/home/cityStateList'; ?>',
		data:'stateId='+stateId+'&cityId='+cityId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
			  $('.selectpicker').selectpicker();
		}
	});
}



</script>