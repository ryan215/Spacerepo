<section class="main-container col1-layout">
	<div class="main container pastorder-main-div shadow-main-div">
		<div class="col-main">
			<!--breadcrumb-->
			 <div class="yt-breadcrumbs">
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
							<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="category4" itemscope="" itemtype=""><strong>Order Track</strong></li></ul>
					</div>
        			</div>
        		</div>
			
				  <!--breadcrumb-->
				  <div class="col-sm-12 padding_left_zero">
						 <div class="my-account">
							  <div class="page-title">
									<h2>My Orders</h2>
							  </div>
							  <ul class="nav nav-tabs" id="myTab">
									<li>
										<a href="<?php echo base_url().'frontend/order'; ?>">
											Recent Orders
										</a>
									</li>
									<li class="active">
										<a href="<?php echo base_url().'frontend/order/past_order'; ?>">
											Past Orders
										</a>
									</li>       
							  </ul>
							  <div class="tab-content">
									<div class="tab-pane fade in active">
										  <div class="dashboard">            
												<div class="recent-orders">
No Order Available
												</div>								
										  </div>
									</div>									
							  </div>	
					    </div>
				  </div>
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
.btn-cart {
    background: #A3CE62;
    color: #fff;
    font-size: 16px;
    text-shadow: none;
    margin-top: 0;
    font-weight: 400;
    transition: color 300ms ease-in-out 0s,background-color 300ms ease-in-out 0s,background-position 300ms ease-in-out 0s;
    margin-left: 10px;
    border: none;
    text-transform: uppercase;
}.btn_red {
    /* margin-left: 0; */
    padding-top: 6px;
    font-size: 12px;
    padding-bottom: 6px;
}
.btn-cart:hover {
    background: #A3CE62;
    color: #fff;
    font-size: 16px;
    text-shadow: none;
    margin-top: 0;
    font-weight: 400;
    transition: color 300ms ease-in-out 0s,background-color 300ms ease-in-out 0s,background-position 300ms ease-in-out 0s;
    margin-left: 10px;
    border: none;
}
.btn_red:hover {
    text-decoration: none;
    margin-left: 0;
    padding-top: 6px;
    font-size: 12px;
    padding-bottom: 6px;
}
.captcha-maindiv {
    display:inline-block;
}
.captcha-leftdiv h3{     margin-top: 20px;
    margin-bottom: 10px;}
.order_details table tr td h2{ font-size:22px;}
.order_details table tr td h5{     font-size: 14px;}
.my-account .product-name{ font-weight:normal;}
.order-tables-box{ box-shadow:none;}
</style>
