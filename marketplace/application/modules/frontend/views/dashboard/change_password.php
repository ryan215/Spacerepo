<section class="main-container col1-layout">
	<div class="main container shadow-main-div">
		<div class="col-main">
			<!--breadcrumb-->
			<div class="yt-breadcrumbs">
        		
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url().'frontend/dashboard'; ?>" title="Go to Dashboard"><span itemprop="title">Dashboard</span></a></li><li class="category4" itemscope="" itemtype=""><strong>Change Password</strong></li></ul>
					</div>
        			</div>
        		</div>
 			
			<!--breadcrumb-->
			<div class="col-sm-9" style="padding-left:0px;">
        		<div class="my-account">
          			<div class="page-title">
            			<h2>Change Password</h2>
          			</div>
          			
					<div class="dashboard">
            			<div class="account-login" style="margin-top:0;">
              				<div class="col2-set">
                				<div class="col-sm-12 new-users" style="max-width:100% !important;">
                  					<?php 
echo form_open();
?>                                                                                           
                   						<div class="form-group form-grp-custom">
                      						<div class="col-sm-4"><label for="firstname">Old Password</label></div>
                      						<div class="col-sm-8 padding-bottom">
												<input type="password" class="form-control  account-input" id="opassword" name="opassword" value="<?php echo set_value('opassword'); ?>">
												<?php echo form_error('opassword'); ?>												
											</div>
                    					</div>
                    					
										<div class="form-group form-grp-custom">
                      						<div class="col-sm-4"><label for="lastname">New Password</label></div>
											<div class="col-sm-8 padding-bottom">
												<input type="password"class="form-control   account-input" id="npassword" name="npassword" value="<?php echo set_value('npassword'); ?>">
												<?php echo form_error('npassword'); ?>		
											</div>
                    					</div>
                    					
										<div class="form-group form-grp-custom">
                      						<div class="col-sm-4"><label for="mobilenumber">
												Confirm New Password
											</label></div>
                      						<div class="col-sm-8 padding-bottom">
												<input type="password"class="form-control  account-input" id="cpassword" name="cpassword" value="<?php echo set_value('cpassword'); ?>">
												<?php echo form_error('cpassword'); ?>	
											</div>
                    					</div>
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
input[type="text"],input[type="password"]{ height:42px;background: #f7f7f7!important;}
input[type="text"],input[type="password"]:focus{  background: #fff!important;    border: 1px solid #78ce7b;}
</style>