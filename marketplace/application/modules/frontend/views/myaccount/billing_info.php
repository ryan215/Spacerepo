<div class="col-lg-9 col-md-9 col-sm-12 my_account_right_section ">
	<h3 style="display:inline-block; margin:0px !important; padding-bottom:10px;">Billing Information</h3>	
    <div class="divider"></div>
    <div class="col-sm-10 no-padding" style="padding-top:20px !important;" >
<?php 
echo form_open();
?>                                                                                           			<div class="form-group">
            	<div class="col-sm-4"><label for="billing_first_name">First Name</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="billing_first_name" placeholder="First Name" value="<?php echo $billing_first_name; ?>" name="billing_first_name">
					<?php echo form_error('billing_first_name'); ?>
				</div>
			</div>
			
            <div class="form-group">
            	<div class="col-sm-4"><label for="billing_last_name">Last Name</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="billing_last_name" placeholder="Last Name" name="billing_last_name" value="<?php echo $billing_last_name; ?>">
					<?php echo form_error('billing_last_name'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="billing_email">Email</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="billing_email" placeholder="Email" name="billing_email" value="<?php echo $billing_email; ?>">
					<?php echo form_error('billing_email'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="mobilenumber">Phone Number</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="mobilenumber" placeholder="Mobile Number" name="phone" value="<?php echo $billing_phone; ?>">
					<?php echo form_error('phone'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="billing_company">Company</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="billing_company" placeholder="Company" name="billing_company" value="<?php echo $billing_company; ?>">
					<?php echo form_error('billing_company'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="billing_address">Address</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="billing_address" placeholder="Address" name="billing_address" value="<?php echo $billing_address; ?>">
					<?php echo form_error('billing_address'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="address2">Address2</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="address2" placeholder="Address2" name="address2" value="<?php echo $billing_address2; ?>">
					<?php echo form_error('address2'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="zipcode">Zipcode</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="zipcode" placeholder="Zipcode" name="zipcode" value="<?php echo $billing_zipcode; ?>">
					<?php echo form_error('zipcode'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="additional_info">Additional Information</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="additional_info" placeholder="Additional Information" name="additional_info" value="<?php echo $additional_info; ?>">
					<?php echo form_error('additional_info'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="country_id">Country</label></div>
                <div class="col-sm-8 padding-bottom">
					<?php
					echo $this->location_m->country_list_dropdown($country_id);
					echo form_error('country_id');
					?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="state_id">State</label></div>
                <div class="col-sm-8 padding-bottom">
					<div id="stateAjaxID">
						<select class="form-control" name="state_id" id="state_id">
							<option value="">Select State</option>
						</select>
					</div>
					<?php echo form_error('state_id'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="city_id">Zone</label></div>
                <div class="col-sm-8 padding-bottom">
					<div id="cityAjaxID">
						<select class="form-control" name="city_id" id="city_id">
							<option value="">Select Zone</option>
						</select>
					</div>
					<?php echo form_error('city_id'); ?>
				</div>
			</div>
            
			<div class="form-group">
            	<div class="col-sm-4"><label for="city_id">Area</label></div>
                <div class="col-sm-8 padding-bottom">
					<div id="zoneAjaxID">
						<select class="form-control" name="zone_id" id="zone_id">
							<option value="">Select Area</option>
						</select>
					</div>
					<?php echo form_error('zone_id'); ?>
				</div>
			</div> 
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="city_id">City</label></div>
                <div class="col-sm-8 padding-bottom">
					<div id="areaAjaxID">
						<select class="form-control" name="area_id" id="area_id">
							<option value="">Select City</option>
						</select>
					</div>
					<?php echo form_error('area_id'); ?>
				</div>
			</div> 
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="street">Street</label></div>
                <div class="col-sm-8 padding-bottom" id="areaAjaxID">
					<input type="text" class="form-control" id="street" placeholder="Street" name="street" value="<?php echo $billing_street; ?>">
					<?php echo form_error('street'); ?>	
				</div>
			</div>
                
            <div class="col-sm-4"></div>
        	<div class="col-sm-8">
				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
			</div>
        </form>
	</div>
</div> 

</div>
</div>

<script type="text/javascript">
<?php
if($state_id)
{
?>
state_list('<?php echo $country_id; ?>');
<?php
}
if($city_id)
{
?>
city_list('<?php echo $state_id; ?>');
<?php
}
if($zone_id)
{
?>
zone_list('<?php echo $city_id; ?>');
<?php
}
if($area_id)
{
?>
area_list('<?php echo $zone_id; ?>');
<?php
}
?>
</script>