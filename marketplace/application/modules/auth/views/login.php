<link rel="stylesheet" href="<?php echo base_url(); ?>css/login/login.css">		

<div id="login-top">
	<img src="<?php echo base_url(); ?>img/login-logo.png" alt="" title="Powered By Treemo Labs" />			
</div>

<?php $this->load->view('success_error_message'); ?>  

<div id="login-content">
	<?php echo form_open();?>					
		<p>
			<label>Email</label>
			<input class="text-input" type="text" name="email" value="<?php if(!empty($email)){ echo $email; }else{ echo set_value('email'); } ?>" autofocus>
		</p>
		<br style="clear: both;" />
		<?php echo form_error('email'); ?>

		<p>
			<label>Password</label>
			<input type="password" name="password" class="text-input" value="<?php if(!empty($password)){ echo $password; } ?>">
		</p>
		<br style="clear: both;" />
		<?php echo form_error('password'); ?>
	
		<div style="text-align:center; display:inline-block;">
			<input class="button" type="submit" value="Log In" />
		</div>

		<P class="remeber-pass">
			<input type="checkbox" name="remember" id="checkbox12" class="check2" checked="checked"/>
			<label for="checkbox12" class="label2">Remember password</label><br/>
		</P>
	
		<p class="forgot-pass">
			<a href="<?php echo base_url(); ?>auth/backend_reset_password" style="text-align:right;">
				Forgot password ?
			</a>
		</p>
		
		<?php /*?><p class="forgot-pass">
			<a href="<?php echo base_url(); ?>auth/shipping_sign_up" style="text-align:right;">
				Register a shipping agent
			</a>
		</p><?php */?>
	</form>
</div>