<div class="col-lg-9 col-md-9 col-sm-12 my_account_right_section ">
	<h3 style="display:inline-block; margin:0px !important; padding-bottom:10px;">Personal Information</h3>	
    <div class="divider"></div>
    <div class="col-sm-10 no-padding" style="padding-top:20px !important;" >
<?php 
echo form_open();
?>                                                                                           			<div class="form-group">
            	<div class="col-sm-4"><label for="firstname">First Name</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="firstname" placeholder="First Name" value="<?php echo $first_name; ?>" name="first_name">
					<?php echo form_error('first_name'); ?>
				</div>
			</div>
			
            <div class="form-group">
            	<div class="col-sm-4"><label for="lastname">Last Name</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="lastname" placeholder="Last Name" name="last_name" value="<?php echo $last_name; ?>">
					<?php echo form_error('last_name'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4"><label for="mobilenumber">Phone Number</label></div>
                <div class="col-sm-8 padding-bottom">
					<input type="text" class="form-control" id="mobilenumber" placeholder="Mobile Number" name="phone" value="<?php echo $phone; ?>">
					<?php echo form_error('phone'); ?>
				</div>
			</div>
			
			<?php /*?><div class="form-group">
            	<div class="col-sm-4"><label for="Gender">Gender</label></div>
                <div class="col-sm-8 padding-bottom">
                	<select id="Gender" name="gender" class="form-control">
                    	<option value="1" <?php if($gender==1){ ?> selected="selected" <?php } ?>>
							Male
						</option>
                        <option value="0" <?php if($gender==0){ ?> selected="selected" <?php } ?>>
							Female
						</option>
                    </select>
					<?php echo form_error('gender'); ?>
                </div>
			</div><?php */?>
						
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
					<input type="text" class="form-control" id="street" placeholder="Street" name="street" value="<?php echo $street; ?>">
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