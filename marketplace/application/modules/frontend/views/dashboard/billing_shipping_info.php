<section class="main-container col1-layout">
  <div class="main container shadow-main-div">
    <div class="col-main"> 
      <!--breadcrumb-->
	  <div class="yt-breadcrumbs">
        		
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="category4" itemscope="" itemtype=""><strong><?php
						$uriSeg3 = $this->uri->segment(3); 
						if($uriSeg3=='billing_info')
						{
							echo 'Billing Information';
						}
						else
						{
							echo 'Shipping Information';
						}
						?></strong></li></ul>
					</div>
        			</div>
        		</div>
      
      <!--breadcrumb--> 
      
      <!--Checkout Page-->
      <div class="" style="">
        <div class="row">
          <aside class="col-sm-9" style="padding-right:0px;">
            <div class="page-title">
              	<h2>
			  		<?php
					if($uriSeg3=='billing_info')
					{
						echo 'Billing Address';
					}
					else
					{
						echo 'Shipping Address';
					}
					?>
				</h2>
            </div>
            <div class="account-login" style="">
              <fieldset class="col2-set">
                <div class="col-sm-12 new-users"  style="max-width:100% !important; width:100%; padding-top:25px;">
                 <?php 
echo form_open();
?>                                                                                           
                   
                      <div class="col-sm-6" style="padding-left:0px;">
                        <ul class="form-list">
                          <li>
                            <label for="first_name">First Name<span class="required">*</span></label>
                            <br>
                            <input type="text" title="First Name" class="input-text account-input" id="first_name"  placeholder="First Name" value="<?php echo $result['firstName']; ?>" name="firstName">
                            <?php echo form_error('firstName'); ?> </li>
                          <li>
                            <label for="first_name">Last Name<span class="required">*</span></label>
                            <br>
                            <input type="text" title="Last Name" class="input-text account-input" id="last_name"  placeholder="Last Name" value="<?php echo $result['lastName']; ?>" name="lastName">
                            <?php echo form_error('lastName'); ?> </li>
                          <li>
                            <label for="mobileno">Phone Number<span class="required">*</span></label>
                            <br>
                            <input type="text" title="Mobile No." id="mobileno" class="input-text account-input" name="phoneNo" value="<?php echo $result['phoneNo']; ?>">
                            <?php echo form_error('phoneNo'); ?> </li>
                          <?php /*?><li>
                            <label for="zipcode">Zipcode<span class="required">*</span></label>
                            <br>
                            <input type="text" title="zipcode" id="zipcode" class="input-text account-input" name="zipcode" value="<?php echo $result['zipcode']; ?>">
                            <?php echo form_error('zipcode'); ?> </li><?php */?>
                        </ul>
                      </div>
                      <div class="col-sm-6" style="padding-left:0px; padding-right:0px; padding-bottom:20px;">
                        <ul class="form-list">
                          <li>
                            <label for="State">State <span class="required">*</span></label>
                            <br>
                            <select name="stateId" onchange="area_list(this.value);" class="account-input form-control">
                              <option value="">Select State</option>
                              <?php
										if(!empty($result['stateList']))
										{
											foreach($result['stateList'] as $row)
											{
										?>
                              <option value="<?php echo $row->stateId; ?>" <?php if($result['stateId']==$row->stateId){?> selected="selected" <?php } ?>> <?php echo $row->stateName; ?></option>
                              <?php
											}
										}
										?>
                            </select>
                            <?php echo form_error('stateId'); ?> </li>
                          <li>
                            <label for="Zone">Area <span class="required">*</span></label>
                            <br>
                            <div id="areaList">
                              <select name="areaId" class="form-control account-input">
                                <option value="">Select Area</option>
                              </select>
                            </div>
                            <?php echo form_error('areaId'); ?> </li>
                          <li>
                            <label for="Zone">City <span class="required">*</span></label>
                            <br>
                            <div id="cityList">
                              <select name="cityId" class="form-control account-input">
                                <option value="">Select City</option>
                              </select>
                            </div>
                            <?php echo form_error('cityId'); ?> </li>
                          <li>
                            <label for="first_name">Address Line1 <span class="required">*</span></label>
                            <br>
                            <input type="text" title="Address Line 1" class="input-text account-input" id="first_name"  placeholder="Address1" value="<?php echo $result['address1']; ?>" name="address1">
                            <?php echo form_error('address1'); ?> </li>
                          <li>
                            <label for="last_name">Address Line2</label>
                            <br>
                            <input type="text" title="Last Name" id="last_name" class="input-text account-input" placeholder="Address Line 2" value="<?php echo $result['address2']; ?>" name="address2">
                            <?php echo form_error('address2'); ?> </li>
                        </ul>
                      </div>
                      <button id="send2" name="send" type="submit" class="btn-cart pull-right billing-save-btn"> <span>Save</span> <i class=""></i></button>
                    
                  </form>
                </div>
              </fieldset>
            </div>
          </aside>
          <?php $this->load->view('right_bar'); ?>
        </div>
      </div>
      <!--Checkout Page--> 
    </div>
  </div>
</section>
<?php
//echo "<pre>"; print_r($result); exit;
//echo $result['areaId']; exit;
?>
<script type="text/javascript" language="javascript">

function area_list(stateId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/areaStateList'; ?>',
		data:'stateId='+ stateId +'&areaId=<?php echo trim(htmlentities($result['areaId'])); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<img src="<?php echo base_url(); ?>images/frontend/sml-loader.gif">');
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
		data:'areaId='+areaId+'&cityId=<?php echo trim(htmlentities($result['cityId'])); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<img src="<?php echo base_url(); ?>images/frontend/sml-loader.gif">');
		},
		success:function(result){ 
			$('#cityList').html(result);	
		}
	});
}
<?php
if($result['stateId'])
{
?>
area_list('<?php echo trim(htmlentities($result['stateId'])); ?>');
<?php
}
if($result['areaId'])
{
?>
city_list('<?php echo trim(htmlentities($result['areaId'])); ?>');
<?php
}
?>
</script>
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
.account-login {
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
    background-color: #666
    border: 1px solid #666;
    border-radius: 0; color:#fff;
}
.btn-savchange:hover{     background-color: #fe5621;    border: 1px solid #fe5621;}
input[type="text"],input[type="password"]{ height:42px;}
.account-login .form-list input.input-text, .form-list select {
    background: #f7f7f7!important;
}
.form-list select {
    border: none!important;
    border-radius: 0!important;
    height: 42px;
}
.account-login .form-list input.input-text:focus {
    background: #fff!important;
    border: 1px solid #78ce7b;
}
.btn-cart {
    background: #666;
    color: #fff;
    font-size: 16px;
    text-shadow: none;
    margin-top: 0;
    font-weight: 400;
    transition: color 300ms ease-in-out 0s,background-color 300ms ease-in-out 0s,background-position 300ms ease-in-out 0s;
    margin-left: 10px;
    border: none;
    text-transform: uppercase;
}
.btn-cart:hover{ background:#fe5621;}
.billing-save-btn {
    height: 34px;
}
</style>