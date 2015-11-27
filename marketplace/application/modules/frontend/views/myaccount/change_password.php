<div class="col-lg-9 col-md-9 col-sm-12 my_account_right_section ">
	<h3 style="display:inline-block; margin:0px !important; padding-bottom:10px;">Change Password</h3>	
    <div class="divider"></div>
    <div class="col-sm-10 no-padding" style="padding-top:20px !important;" >
<?php 
echo form_open();
?>                                                                                           			<div class="form-group">
            	<div class="col-sm-4">
					<label for="oldpassword">
						Old Password <span class="star">*</span>
					</label>
				</div>
                <div class="col-sm-8 padding-bottom">
					<input type="password" class="form-control" id="opassword" name="opassword" value="<?php echo set_value('opassword'); ?>">
					<?php echo form_error('opassword'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4">
					<label for="npassword">
						New Password <span class="star">*</span>
					</label>
				</div>
                <div class="col-sm-8 padding-bottom">
					<input type="password" class="form-control" id="npassword" name="npassword" value="<?php echo set_value('npassword'); ?>">
					<?php echo form_error('npassword'); ?>
				</div>
			</div>
			
			<div class="form-group">
            	<div class="col-sm-4">
					<label for="cpassword">
						Confirm New Password <span class="star">*</span>
					</label>
				</div>
                <div class="col-sm-8 padding-bottom">
					<input type="password" class="form-control" id="cpassword" name="cpassword" value="<?php echo set_value('cpassword'); ?>">
					<?php echo form_error('cpassword'); ?>
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