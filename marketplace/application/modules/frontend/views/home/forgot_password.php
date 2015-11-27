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
					<li class="active">Forgot Password</li>
				</ul>
			</div>
			<!--breadcrumb-->
			<div class="account-login">
				<fieldset class="col2-set">
					<legend>Login or Create an Account</legend>        
        			<div class="registered-users" style="">
						<center><h2>+ Forgot Password</h2></center>
						<img src="<?php echo base_url() ?>images/frontend/user_icon.png" style="width:100%;" /><br><br>
<?php 
echo form_open();
?>                                                                                           							<div class="content">
								
								<ul class="form-list">
									<li>
										<label for="email">Email Address <span class="required">*</span></label>
										<br>
										<input type="text" title="Email Address" class="input-text" placeholder="Email Address" name="email" value="<?php echo set_value('email'); ?>">
										<?php echo form_error('email'); ?>
									</li>
								</ul>
								<p class="required">* Required Fields</p><br>
								<div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
								<div class="buttons-set">
									<button id="send2" name="send" type="submit" class="button login" style="width:100%;background: #78ce7b; color:#fff;padding: 12px 12px;">
										<span>Submit</span>
									</button>
								</div>
								</div><br>
							</div>
		  				</form>
        			</div>
      			</fieldset>
			</div>
		</div>
	</div>
</section>
