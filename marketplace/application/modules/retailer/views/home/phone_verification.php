<style>
body {
	background-color: #ffffff;
	background: url('../../../images/verify_bg.jpg');
	background-size: contain;
	background-repeat: no-repeat;
}
.verify-input {
	width: 45px;
	height: 55px;
	float: left;
	margin-right: 6px;
	box-shadow: 0px 0px 2px rgba(0,0,0,0.2);
	font-size: 17px;
}
.veify-p {
	text-align: center;
}
.verify-maindiv {
	width: 420px;
	margin: 0 auto;
	background-color: #fff;
}
.fivedigit-inputs {
	padding-left: 53px;
}
.verify-text {
	font-size: 15px;
	text-align: left;
}
.main-verfy-div {
	padding-bottom: 90px;
}
.isa_success {
	line-height: 0;
	padding-bottom: 21px;
	padding-right: 20px;
	text-align: center;
	width: 62%;
	margin: 4px auto 10px;
}
.isa_error {
	margin: 0 auto 20px;
	text-align: center;
	width: 45%;
}
</style>
<div class="col-sm-12 pd main-shipsignin-div main-verfy-div">
  <div style="position:relative; left:22px;"><?php $this->load->view('success_error_message'); ?></div>
  <div class="col-sm-12 pd">
    <div class="col-lg-4 col-sm-3"></div>
    <div class="col-sm-5 log-in-box  main-shi-div  verify-maindiv">
	  <?php 
$attributes = array('class' => 'form-horizontal shipping-form','autocomplete' => 'off');
echo form_open('',$attributes);
?>

        <h2 class="text-left" style="text-align:left; margin-bottom:0;">Verify Phone Number</h2>
        <a href="<?php echo base_url().'retailer/home/skip/'.id_encrypt($organizationId); ?>" class="pull-right" style="color:#00a0e4;"><!--Skip--></a>
        <p class="not-alrdy verify-text">We have sent a temporary verification<br>
          code on your phone.</p>
        <div class="form-group">
          <div class="col-sm-12 addon-md" style="text-align:center;">
            <p class="veify-p">Enter Verification Code:</p>
            <div class="col-sm-12 fivedigit-inputs">
              <input type="text" id="first" class="form-control ship-input verify-input" name="otp[]" value="<?php echo set_value('otp[]'); ?>" onkeyup="movetoNext(this, 'second')" maxlength="1">
              <input type="text" id="second" class="form-control ship-input verify-input" name="otp[]" value="<?php echo set_value('otp[]'); ?>" onkeyup="movetoNext(this, 'third')" maxlength="1" >
              <input type="text" id="third" class="form-control ship-input verify-input" name="otp[]" value="<?php echo set_value('otp[]'); ?>" onkeyup="movetoNext(this, 'four')" maxlength="1" >
              <input type="text" id="four" class="form-control ship-input verify-input" name="otp[]" value="<?php echo set_value('otp[]'); ?>" onkeyup="movetoNext(this, 'five')" maxlength="1" >
              <input type="text" id="five" class="form-control ship-input verify-input" name="otp[]" value="<?php echo set_value('otp[]'); ?>" maxlength="1">
            </div>
            <?php echo form_error('otp[]'); ?> </div>
        </div>
        <div class="form-group">
          <div class="not-alrdy" style="text-align:left;"> <a href="<?php echo base_url();?>retailer/home/resend_verification_code/<?php echo id_encrypt($organizationId);?>" style="text-transform:inherit;"> <i class="fa fa-refresh"></i>&nbsp;Send a new code </a><br>
            <p class="pull-left" style="margin-top:7px;"> <?php echo $result['businessPhone']; ?>&nbsp; <a href="<?php echo base_url().'retailer/home/editVerificationPhone/'.id_encrypt($organizationId); ?>" class="label label-danger" style="font-size:11px; border-radius:2px !important; padding:2px 5px; color:#fff;"> Edit </a> </p>
            <button class="btn btn-success pull-right" style="border-radius:5px !important;  margin-left:8px !important;">Verify</button>
            <a class="btn btn-default pull-right" style="border-radius:5px !important;" href="<?php echo base_url().'retailer/home/index'; ?>"> Cancel </a> </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
function movetoNext(current, nextFieldID) {
if (current.value.length >= current.maxLength) {
document.getElementById(nextFieldID).focus();
}
}
</script>
