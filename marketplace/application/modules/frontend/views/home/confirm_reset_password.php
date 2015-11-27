<section class="main-container col1-layout">
	<div class="main container">
  		<div class="col-main">
			<!--breadcrumb-->
 			<div class="breadcrumbDiv">
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url(); ?>">
							Home
						</a>
					</li>
					<li class="active">Confirm Reset Password</li>
				</ul>
			</div>
			<!--breadcrumb-->
			<div class="account-login">
				<fieldset class="col2-set">
					<div class="registered-users" style="max-width:60% !important;">
						
<?php 
echo form_open();
?>                                                                                           							<input type="hidden" name="confirm_code" value="<?php echo $reset_password_code; ?>">	
							<div class="content">								
								<ul class="form-list">
									<li>
										<label for="email">New Password<span class="required">*</span></label>
										<br>
										<input class="input-text" type="password" name="newPassword" value="<?php echo set_value('newPassword'); ?>">
										<?php echo form_error('newPassword'); ?>
									</li>
									<li>
										<label for="email">Confirm New Password<span class="required">*</span></label>
										<br>
										<input class="input-text" type="password" name="confirmPassword" value="<?php echo set_value('confirmPassword'); ?>">
										<?php echo form_error('confirmPassword'); ?>
									</li>
								</ul>
								<p class="required">* Required Fields</p>
								<div class="buttons-set">
									<button id="send2" name="send" type="submit" class="button login">
										<span>Submit</span>
									</button>
								</div>
							</div>
		  				</form>
        			</div>
      			</fieldset>
			</div>
		</div>
	</div>
</section>
