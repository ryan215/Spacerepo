<section class="main-container col1-layout">
  <div class="main container shadow-main-div">
    <div class="col-main"> 
      <!--breadcrumb-->
	  <div class="yt-breadcrumbs">
        		
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url().'frontend/dashboard'; ?>" title="Go to Dashboard"><span itemprop="title">Dashboard</span></a></li><li class="category4" itemscope="" itemtype=""><strong>My Profile</strong></li></ul>
					</div>
        			</div>
        		</div>
      <!--breadcrumb-->
      <div class="col-sm-9" style="padding-left:0px;">
        <div class="my-account">
          <div class="page-title">
            <h2>My Profile</h2>
          </div>
          <div class="dashboard">
            <div class="account-login personal-infodiv">
              <div class="col2-set">
                <div class="col-sm-12 new-users" style="  max-width: 100% !important;">
                 <?php 
echo form_open();
?>                                                                                           
                    <div class="form-group form-grp-custom">
                      <div class="col-sm-4">
                        <label for="firstname">First Name</label>
                      </div>
                      <div class="col-sm-8 padding-bottom">
                        <input type="text" class="form-control account-input" id="firstname" placeholder="First Name" value="<?php echo $result['firstName']; ?>" name="firstName">
                        <?php echo form_error('firstName'); ?> </div>
                    </div>
                    <div class="form-group form-grp-custom">
                      <div class="col-sm-4">
                        <label for="lastname">Last Name</label>
                      </div>
                      <div class="col-sm-8 padding-bottom">
                        <input type="text" class="form-control account-input " id="lastname" placeholder="Enter Last Name" value="<?php echo $result['lastName']; ?>" name="lastName">
                        <?php echo form_error('lastName'); ?> </div>
                    </div>
                    <div class="form-group form-grp-custom">
                      <div class="col-sm-4">
                        <label for="mobilenumber">Phone Number </label>
                      </div>
                      <div class="col-sm-8 padding-bottom">
                        <div class="input-group" style="padding-top:5px;"> <span class="input-group-addon" style="background-color:#fff !important; border-radius:0; border-left:1px solid #ccc; border-top:1px solid #ccc; border-bottom:1px solid #ccc; border-right:0; color:#aaa;">+234</span>
                          <input type="text" title="Mobile No." id="mobileno" class="form-control account-input" name="phoneNo" placeholder="Mobile No." value="<?php echo $result['phoneNo']; ?>" style="margin-top:0;">
                        </div>
                        <?php echo form_error('phoneNo'); ?> </div>
                    </div>
                   
					<input type="hidden" name="stateId">	
					<input type="hidden" name="areaId">
                    <input type="hidden" name="cityId"> 
					<input type="hidden" name="street">
					
                  
               
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                      <button type="submit" class="btn btn-primary btn-savchange"> Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('right_bar'); ?>
    </div>
  </div>
</section>
<?php /*
<script type="text/javascript" language="javascript">
function state_list(countryId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo $result['stateId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result);
			area_list($('#stateId').val());			
			//console.log(result);
		}
	});
}

function area_list(stateId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/areaStateList'; ?>',
		data:'stateId='+ stateId +'&areaId=<?php echo trim($result['areaId']); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#areaList').html(result);
			city_list($('#areaId').val());		
		}
	});
}

function city_list(areaId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/cityAreaList'; ?>',
		data:'areaId='+areaId+'&cityId=<?php echo trim($result['cityId']); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
		}
	});
}
<?php
if($result['countryId'])
{
?>
state_list('<?php echo trim($result['countryId']); ?>');
<?php
}
if($result['stateId'])
{
?>
area_list('<?php echo trim($result['stateId']); ?>');
<?php
}
if($result['areaId'])
{
?>
city_list('<?php echo trim($result['areaId']); ?>');
<?php
}
?>
</script>
*/?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/level-1.css">
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
.btn_adc { padding-top:5px;}
#shopping-cart-table .product-name{     font-family: 'Open Sans',sans-serif !important;}
#shopping-cart-table{ border:none !important;}
.data-table thead{ border:none}
.data-table tbody tr{ border:none;}.seller-name {
    font-size: 15px;
}.button_carts:hover {
    border: 1px solid #A3CE62;
    background: #A3CE62;
    color: #FFF;
}.btn{ font-family: 'Open Sans',sans-serif;
    border: 1px solid #ddd;
    background: #fff;
    padding: 5px 12px;    color: #333;
    transition: color 300ms ease-in-out 0s,background-color 300ms ease-in-out 0s,background-position 300ms ease-in-out 0s;
}
.cart-collateral h3 {
    font-size: 15px;
    color: #000;
    margin-bottom: 15px;
    border-bottom: 1px #ddd solid;
    padding: 10px 0;
    font-family: 'Open Sans',sans-serif;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 20px;
}
a.button.btn-proceed-checkout {
    background: #A3CE62;
    padding: 24px 15px;
    color: #fff;
    width: 100%;
    text-decoration: none;
    border-radius: 2px;    font-size: 16px;
}
a.button.btn-proceed-checkout:hover {
    background: #333;
    color: #fff;
    border: 1px solid #000;
}.button:hover {
    border: inherit;
}
.color_static {
    padding: 8px;
    margin-left: 5px;
}.color_box {
    margin-right: 5px;
    border: 2px solid #eee;
}
.size_static {
    padding: 0 5px;
    font-size: 11px;
    margin-left: 5px;
}.size_box {
    margin-right: 5px;
    border: 2px solid #eee;
}label {
    font-weight: bold;
}
.dashboard {
    display: inline-block;
    width: 100%;
}
.personal-infodiv {
    margin-top: 0;
}
account-login {
    margin-bottom: 15px;
    background-color: #FFF;
    padding: 0;
    margin-top: 15px;
}
.new-users {
    padding: 35px 45px 45px;
}
.new-users {
	display:inline-block;
    text-align: left;
    margin: 0 auto;
    background: #fff;
    border: 1px solid #eaeaea;
    -webkit-box-shadow: 1px 1px 13px -1px rgba(221,221,221,1);
    -moz-box-shadow: 1px 1px 13px -1px rgba(221,221,221,1);
    box-shadow: 1px 1px 13px -1px rgba(221,221,221,1);
    max-width: 50%;
}
.form-grp-custom {
    display: inline-block;
    width: 100%;
}.account-input {
    border-radius: 0;
}
.btn-savchange {
    background-color: #666;
    border: 1px solid #666;
    border-radius: 0; color:#fff;
}
.btn-savchange:hover{     background-color: #fe5621;    border: 1px solid #fe5621;}
input[type="text"]{ height:42px;background: #f7f7f7;}
input[type="text"]:focus{  background: #fff ;    border: 1px solid #78ce7b !important;}
select {
    border-radius: 0!important;
    height: 42px!important;    background: #f7f7f7!important;
}
select:focus {
     background: #fff !important;    border: 1px solid #78ce7b !important;
}

</style>