<div class="col-sm-12 pd main-shipsignin-div">
	<div class="pd" style="width:380px; margin:0 auto;">
		<?php $this->load->view('success_error_message'); ?>
    	<div class="col-sm-12 log-in-box  main-shi-div">
			<?php 
$attributes = array('class' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

				<h2>Change your user name or password</h2>
				<div class="form-group">
                	<div class="icon-addon addon-md">
                    	<input type="text" class="form-control ship-input" placeholder="Username" value="<?php echo $result['userName']; ?>" name="userName">
                    	<label title="username"  class="fa fa-user input-label" for="email"></label>
						 <?php echo form_error('userName'); ?>
                    </div>
				</div>
                        
                        <div class="form-group">
                        	<div class="icon-addon addon-md">
                                <input type="password" id="" class="form-control ship-input" placeholder="Password" value="<?php echo $result['password']; ?>" name="password">
                                <label title="password"  class="fa fa-lock input-label" for="email"></label>
								 <?php echo form_error('password'); ?>
                            </div>
                          </div>
                         <div class="form-group">  
                         	<div class="icon-addon addon-md">
                                <input type="password" id="" class="form-control ship-input" placeholder="Confirm Password" value="<?php echo $result['confPassword']; ?>" name="confPassword">
                                <label title="password"  class="fa fa-lock input-label" for="email"></label>
								 <?php echo form_error('confPassword'); ?>
                            </div>
                            <div class="form-group sign-inbtn-div">
                                <button type="submit" class="btn btn-block ship-sign-btn">Submit</button>
                            </div>
                            
                        </div>

                        
                    </form>  
                </div>
            </div>
            
        </div>
        
<style>
.top-btn-div{display:none;
</style>