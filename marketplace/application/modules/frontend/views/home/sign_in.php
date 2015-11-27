<section class="main-container col1-layout">
  <div class="main container">
    <div class="col-main"> 
      <!--breadcrumb-->
      <div class="breadcrumbDiv">
        <ul class="breadcrumb">
          <li> <a href="<?php echo base_url(); ?>"> Home </a> </li>
          <li class="active">Login</li>
        </ul>
      </div>
      <!--breadcrumb-->
      <div class="account-login">
        <fieldset class="col2-set">
          <legend>Login or Create an Account</legend>
          <div class="registered-users">
            <center>
              <h2>+ Login</h2>
            </center>
            <img src="<?php echo base_url() ?>images/frontend/user_icon.png" style="width:100%;" /><br>
            <br>
            <strong> Registered Customers </strong> <span class="button btn-cart pull-right" style="background: #EB5467;"><a href="<?php echo base_url().'frontend/home/sign_up'; ?>" style="color:#fff;" title="Registered With Us"><i class="icon-basket"></i> Register With Us</a></span>
<?php 
echo form_open();
?>                                                                                           
              <div class="content">
                <p>If you have an account with us, please log in.</p>
                <ul class="form-list">
                  <li>
                    <label for="email">Email Address <span class="required">*</span></label>
                    <br>
                    <input type="text" title="Email Address" class="input-text" placeholder="Email Address" name="email" id="email" value="<?php echo $emailIn; ?>">
                    <?php echo form_error('email'); ?> </li>
                  <li>
                    <label for="pass">Password <span class="required">*</span></label>
                    <br>
                    <input type="password" title="Password" class="input-text" name="password"  id="pass" placeholder="Password" value="<?php echo $passwordIn; ?>">
                    <?php echo form_error('password'); ?> </li>
                  <li>
                    <input type="checkbox" name="remember" id="checkbox12" class="check2" checked="checked"/ style="opacity:1; margin-left:0;">
                    &nbsp;&nbsp;
                    <label for="checkbox12" style="padding-left:12px;">Remember Me</label>
                  </li>
                </ul>
                <br>
                <div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
                  <div class="buttons-set">
                    <button id="send2" name="send" type="submit" class="button login" style="width:100%;background: #78ce7b; color:#fff;padding: 12px 12px;"><span>Login</span></button>
                  </div>
                  <br>
                  <a class="forgot-word pull-right" href="<?php echo base_url().'frontend/home/forgot_password'; ?>"> Forgot Your Password? </a> </div>
                <br>
                <br>
                <br>
              </div>
            </form>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</section>
<style>
section {
    padding-top: 3px;
}
.yt-breadcrumbs {
  margin-top: 0px;
}
.header-v0 .ver-megamenu-header .sm_megamenu_wrapper_vertical_menu{ display:none !important;}
.btn-default:hover{ background-color:inherit;}
.pd {
    padding: 0;
}h4, .h4, h5, .h5, h6, .h6 {
    margin-top: 10px;
    margin-bottom: 10px;
}
h4{     font-size: 18px;}
.button{ height:inherit;    text-transform: inherit;    line-height: 23px;}
.data-table th { text-align:left; border:none;
    text-transform: uppercase;
}
.data-table tr td{ border:none; vertical-align:top !important;}
</style>