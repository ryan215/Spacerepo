<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/login.css">

<div id="login-top">
	<img src="<?php echo base_url(); ?>img/login-logo.png" alt="Marketplace" title="Marketplace" />			
</div>

<?php $this->load->view('success_error_message'); ?>  
<div id="login-content">
	<?php form_open();?>
		<input type="hidden" name="confirm_code" value="<?php echo $reset_password_code; ?>">					
		<p>
			<label>New Password<span style="color:#c00000;">*</span></label>
			<input type="password" name="newPassword" value="<?php echo set_value('newPassword'); ?>" class="text-input">
		</p>
		<br style="clear: both;" />
		<?php echo form_error('newPassword'); ?>
		
		<p>
			<label>Confirm New Password<span style="color:#c00000;">*</span></label>							
			<input type="password" name="confirmPassword" value="<?php echo set_value('confirmPassword'); ?>" class="text-input">
		</p>
		<br style="clear: both;" />
		<?php echo form_error('confirmPassword'); ?>	
		
		<div style="text-align:center; display:inline-block;">
			<input class="button" type="submit" value="Submit" />
		</div>
	</form>
</div>