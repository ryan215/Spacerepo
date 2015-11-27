<section class="main-container col1-layout">
	<div class="main container shadow-main-div">
		<div class="col-main"> 
			<!--breadcrumb-->
			<div class="yt-breadcrumbs">
				<div class="row">
					<div class="breadcrumbs col-md-12">
						<ul>
							<li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
								<a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page">
									<span itemprop="title">Home</span>
								</a>
							</li>
							<li class="category4" itemscope="" itemtype="">
								<strong>Pickup Address</strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--breadcrumb-->
			<div class="row">
				<div class="checkout_left col-sm-8">
					<div class="chk_main_div">
						<div class="super-category-block first-load sn-category-block">
                        	<div class="block-title-defaults ">
                            	<div class="tab-category-title block-title">
                                	<strong><span>How would you like to receive your package?</span></strong>
                                    <div class="sn-img icon-bacsic item11"></div>
								</div>
                            </div>
						</div>
						<div class="col-sm-12">
						  		<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<a href="<?php echo base_url().'frontend/product_cart/shipping_address'; ?>">
											<div class="panel-heading">
												<h4 class="panel-title">												
													Shipping												
												</h4>
											</div>
										</a>
									</div>
								
									<div class="panel panel-default">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
											<div class="panel-heading">
												<h4 class="panel-title">												
													Pickup												
												</h4>
											</div>
										</a>
										<div id="collapseOne" class="panel-collapse collapse in" style="overflow:visible; margin-top:0px; padding:0px;">
											<div class="panel-body shipping_sec" style="width:100%; margin-top: 0px !Important;  padding-top: 20px;">
												<div class="col-sm-6 padding_left_zero"><h3>Your Pickup Address</h3></div>
												
												<div class="clearfix"></div><br />
													<center><i class="fa fa-map-marker"></i> Select State <select id="pickupStateId" onchange="pickup_list(this.value);">
                                    					<option value="">State</option>
                                    					<?php
                                    					if(!empty($stateList))
                                    					{
					                                        foreach($stateList as $row)
					                                        {
					                                    ?>
				                                        <option value="<?php echo $row->stateId; ?>">
															<?php echo $row->stateName; ?> 
														</option>
					                                    <?php
					                                        }
					                                    }
                                    					?>
                                					</select></center><div class="clearfix"></div><br />
													<div id="pickupList">
													
													</div>
												</div>
											</div>
										
								</div>
    						</div>
						</div>
					</div>
				</div>
					 
				<div class="checkout_right col-sm-4">
					<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
						<div class="block-title-defaults ">
							<div class="tab-category-title block-title">
								<strong><span>My Orders (<?php echo count($cartDetails); ?>)</span></strong>
								<div class="sn-img icon-bacsic item12"></div>
							</div>
						</div>
					</div>
					
					<div class="table-responsive" style="margin-bottom:20px;">
						<fieldset>
							<table class="data-table cart-table" id="shopping-cart-table">
								<thead>
									<tr class="first last">
										<th rowspan="1">&nbsp;</th>
										<th rowspan="1"><span class="nobr">Product Name</span></th>
										<th colspan="1" class="a-center"><span class="nobr">Price</span></th>
										<th class="a-center" rowspan="1" width="15%">Qty</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$totalAmt 		     = 0;
								$pickupProccessPrice = 0;
								if(!empty($cartDetails))
								{
								?>
									<tr class="first odd">
										<td class="image">
											<a class="product-image" title="<?php echo $cartDetails->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($cartDetails->productId); ?>">
												<?php
												if((!empty($cartDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$cartDetails->imageName)))
												{
												?>
													<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$cartDetails->imageName; ?>" width="75" height="75"/>
												<?php
												}
												elseif((!empty($cartDetails->imageName))&&(file_exists('uploads/product/'.$cartDetails->imageName)))
												{
												?>
													<img src="<?php echo base_url().'uploads/product/'.$cartDetails->imageName; ?>" width="75" height="75"/>
												<?php
												}
												else
												{
												?>
													<img src="<?php echo base_url().'img/no_image.jpg'; ?>" width="75" height="75"/>
												<?php
												}
												?>
											</a>
										</td>
										<td>
											<h2 class="product-name">
												<a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($cartDetails->productId); ?>">
													<?php echo $cartDetails->code; ?>
												</a> 
											</h2>
										</td>
										<td class="a-right">
											<span class="cart-price">
												<span class="price">&#8358;<?php echo number_format(($cartDetails->productAmt*$cartDetails->quantity),2); ?></span>
											</span>
										</td>
										<td class="a-center movewishlist">
											<div class="qty-div"><?php echo $cartDetails->quantity; ?></div>
										</td>
									</tr>  
									<?php
									$displayPrice 		 = $cartDetails->productAmt;
									//$pickupProccessPrice = $pickupProccessPrice+($cartDetails->quantity*$cartDetails->pickupProccessPrice);	
									$totalAmt = $totalAmt+($cartDetails->quantity*$displayPrice)+$pickupProccessPrice;
									}
								?>               
								</tbody>
							</table>
						</fieldset>
					</div>
					<div class="clearfix"></div>
					
					<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Pickup Address</span></strong>
									<div class="sn-img icon-bacsic item13"></div>
								</div>
							</div>
						</div>
						<?php
						if(!empty($pickupAddress))
						{
						?>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_shows" style="width:100%;float:left;">
								<div class="address">
									<p>
										<span class="address-name">
											<?php echo $pickupAddress->pickupName; ?>
										</span><br>
										<span class="address-address1">
											<?php echo $pickupAddress->addressLine1; ?>
										</span><br>
										<span class="address-city">
											<?php 
											if(!empty($pickupAddress->city))
											{
												echo $pickupAddress->city;
											}
											if(!empty($pickupAddress->area))
											{
												echo ' - '.$pickupAddress->area;
											}
											if(!empty($pickupAddress->stateName))
											{
												echo ' - '.$pickupAddress->stateName;
											}
											?>											
										</span><br>
									</p>
									<p class="">
										<span class="address-phone">
											<?php echo $pickupAddress->phone; ?>
										</span>
										<span class="address-additional-phone">
											<?php
											if(!empty($pickupAddress->secondary_phone))
											{
												echo $pickupAddress->secondary_phone.'<br>';
											}
											echo $pickupAddress->businessDays.'<br>'.$pickupAddress->businessHours;
											?>
										</span><br>
									</p>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
					<div class="clearfix"></div>
					<?php /*?>
					<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Pickup Method</span></strong>
									<div class="sn-img icon-bacsic item1"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_method_shows" style="width:100%;float:left;">
								<div class="col-sm-6 padding_left_zero">Pickup Method</div>
								<div class="col-sm-6"><strong>Pickup Processing</strong></div><div class="clearfix"></div>
								<div class="col-sm-6 padding_left_zero">Processing Fee</div>
								<div class="col-sm-6">
									<strong>
										<?php
										if($pickupProccessPrice)
										{
											echo '&#8358;'.number_format($pickupProccessPrice,2);
										}
										else
										{
											echo 'Free';
										}
										?>
									</strong>
								</div>			
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
<?php */?>	
					<div class="opc-review-actions">
						<h5 class="grand_total">Grand Total
							<span class="price">
								<?php echo '&#8358;'.number_format($totalAmt,2); ?>			
							</span>
						</h5>
						<?php
						if((!empty($pickupId))&&($pickupId))
						{							
							?>
							<a title="Pay on pickup" class="button btn-placeorder" href="<?php echo base_url().'frontend/checkout_cash/pay_on_pickup_buy_now/'.id_encrypt($cartId); ?>">
								<span><span style="font-size: 18px !important;">Pay on Pickup</span></span>
							</a>
							<br /><br />
							<a title="Pay Online" class="button btn-placeorder" href="<?php echo base_url().'frontend/product_buy_now/order_buy_now_pickup/'.id_encrypt($cartId); ?>" style="padding:15px 133px 15px 143px">
								<span><span style="font-size: 18px !important;">Pay Online</span></span>
							</a>
    					<?php						
						}
						else
						{
						?>
						
						<a  title="Place Order Now" class="button btn-placeorder" onclick="select_pickup_add();">
							<span><span style="font-size: 18px !important;">Place Order Now</span></span>
						</a>
						<?php
						}
						?>						
					</div>
				</div> 
			</div>
		</div>
	</div>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
				
<script type="text/javascript">
function select_pickup_add()
{
	swal({ title:'Please Select Pickup Address',});
}

function pickup_list(stateId)
{
	$.ajax({
    	type: "POST",
        url: '<?php echo base_url().'frontend/product_cart/pickup_list'; ?>',
        data: 'stateId='+stateId+'&pickupId=<?php echo $pickupId; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
        success: function (result){
			$('#pickupList').html(result);
		}
	});
}

function onloadFun()
{
	$('#pickupStateId').val('<?php echo $pickUpStateId; ?>').attr('selected',true);
	pickup_list('<?php echo $pickUpStateId; ?>');
}

onloadFun();
</script>
<style>
	
.prev{
	 position: absolute;
  left: 0;
  top: 0 !important;
  background-color: #484848 !important;
  color: #fff;
  border-radius: 1px !important;
  font-size: 21px !important;
  padding: 1px 12px !important;
  left: -16px;cursor:pointer;
}
.prev:hover{ color:#fff !important;}
.next:hover{ color:#fff !important;}
.next{
	  position: absolute;
  right: 0;
  top: 0 !important;
  background-color: #484848 !important;
  color: #fff;
  border-radius: 1px !important;
  font-size: 21px !important;
  padding: 1px 12px !important;
  right: 14px;cursor:pointer;
}
.btn.disabled{
   display:none !important;
}
.cs_head{ font-family: museo300 !important;font-size: 16px;    margin-top: 10px;    margin-bottom: 10px; }
.color_box { padding:15px; margin-right:5px;  border: 2px #eee solid;}
.color_box:hover { border:2px solid #ffd926;}
.size_box {margin-right:5px;  border: 2px #eee solid; }
.size_box:hover { border:2px solid #ffd926;}
.fadde_color{ opacity: 0.3;}
.active_color {  border:2px solid #ffd926; }
.btn-pickup{background: #EB5467; border:1px solid #EB5467; color:#fff;  padding: 4px 10px 4px 10px; font-size: 12px;}
.btn-pickup:hover{background: #EB5467; border:1px solid #EB5467; color:#fff;  padding: 4px 10px 4px 10px;  font-size: 12px;}
.tab-pane table tr td { text-align:left;}
.tab-content .one>.active { display:inline-flex;}
.tab-content .two>.active { display:block;}
.pickup_box{   background: #fff; height:210px;
  border-right: 1px solid #eee;
  /*border-bottom: 1px solid #eee;*/
padding: 5px; 
  }
.pickup_box:hover { border-bottom: 2px solid #7bc470; }  
.pickup_box h5{  margin-bottom:2px;font-family: museo700 !Important; text-transform:uppercase;} 
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus { border-bottom:1px solid #eee !important;}
.wonens-slider .owl-prev > disabled{ display:none}
.wonens-slider .owl-next > disabled{ display:none}
.customNavigation {   position: absolute;
   top: 65%;
  z-index: 1000;  width: 100%; }
  .wonens-slider .item img{width:100px !important;
	margin:0 auto 6px auto;
}

.wonens-slider .owl-item{margin:0 !important;
}

.wonens-slider .item{margin:0 !important;
	text-align:center;
	padding-bottom:0px;
}

.wonens-slider .item .product_names{font-family: 'latosemibold';
	text-transform:uppercase;
	color:#444444;
	margin-bottom:0;
}

.wonens-slider .owl-item a{cursor:pointer;
	text-decoration:none;
	display:block;
	border-right:1px solid #f1f1f1;
	transition:all ease-out 0.2s;
	border-bottom:2px solid #fff;
}

.wonens-slider .owl-item:first-child a{border-left:1px solid #ececec !important;
}

.wonens-slider .owl-item a:hover{border-bottom:2px solid #7bc470;
}

.wonens-slider .owl-controls{position:absolute;
	width:100%;
	top:38px;
}

.wonens-slider .owl-next{position: absolute;
    right: 0;
    top: 0 !important;
	background-color:#484848 !important;
	color:#fff;
	border-radius:1px !important;
	font-size: 21px !important;
    padding: 1px 12px !important;
	right: -21px;
}

.wonens-slider .owl-prev{position: absolute;
    left: 0;
    top: 0 !important;background-color:#484848 !important;
	color:#fff;
	border-radius:1px !important;
	font-size: 21px !important;
    padding: 1px 12px !important;
	left: -21px;
}
.owl-wrapper-outer {  border-top: 1px solid #eee !important;}
.owl-item {/* width:240px !important;*/}
.payment_mode_sec .head{   font-family: museo300 !important;}
.price_section .price_sec_1 { border-right:none !Important;}
.price_section .price_sec_2{ 	border-left: 1px solid #ccc;}
.new_title.center{ margin-right:0px !important;}

.singletab-div li{margin-bottom:14px;
}

.singletab-div li a{background-color:#fff;
	color:#666666;
	font-size:14px;
	border-radius:6px;
	-webkit-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
-moz-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
}

.singletab-div li.active a, .singletab-div li:hover a, .singletab-div li:focus a{background-color:#a3ce62;
	color:#fff;	
	-webkit-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
-moz-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
	border-bottom:0 !important;
	font:14px;
}

.singletab-div{border-bottom:0 !important;
}

.avlble-tab{-webkit-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
-moz-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
	border-radius:6px;
	
}

.check_aval{background: #efefef; /* Old browsers */
background: -moz-linear-gradient(top, #efefef 0%, #fdfdfd 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#efefef), color-stop(100%,#fdfdfd)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #efefef 0%,#fdfdfd 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #efefef 0%,#fdfdfd 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #efefef 0%,#fdfdfd 100%); /* IE10+ */
background: linear-gradient(to bottom, #efefef 0%,#fdfdfd 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#efefef', endColorstr='#fdfdfd',GradientType=0 ); /* IE6-9 */
border:1px solid #c8c8c8;
border-radius:6px;
padding-bottom:20px;
}

.singletab-div li:first-child{padding-right:10px;
}

.singletab-div li:last-child{padding-left:10px;
}

.singletab-div>li.active>a, .singletab-div>li.active>a:hover, .singletab-div>li.active>a:focus {background-color:#a3ce62;
	color:#fff;
	border-radius:6px;
	border-bottom:0 !important;}

.singletab-div>li.active>a::brfore, .singletab-div>li.active>a:hover::brfore, .singletab-div>li.active>a:focus::brfore{content: "";
    border-color: transparent #111; 
    border-style: solid;
    border-top:15px solid #a3ce62;
    border-left:14px solid transparent;
    border-right:14px solid transparent;
    display: block;
    height: 0;
    width: 0;
    left: 0;
	right:0;
    bottom: -16px;
    position: absolute;
	margin:0 auto;
}

.singletab-div>li.active>a:after, .singletab-div>li.active>a:hover:after, .singletab-div>li.active>a:focus:after{content: "";
    border-color: transparent #111; 
    border-style: solid;
    border-top:15px solid #a3ce62;
    border-left:14px solid transparent;
    border-right:14px solid transparent;
    display: block;
    height: 0;
    width: 0;
    left: 0;
	right:0;
    bottom: -16px;
    position: absolute;
	margin:0 auto;
}
.check_aval .dropdown-menu{box-shadow:1px 1px 6px rgba(0,0,0,.2);/*max-height:250px!important*/}
.selectpicker{   max-height: 224px !important;min-height: 20px !important;

   }
.pri-percent{display: inline-block;
  margin: 0 0 0 10px;
  border: 1px solid #c9c9c9;
  width: 45px;
  height: 43px;
  border-radius: 50%;
  text-align: center;
  padding: 8px;
  font-size: 12px;
  line-height: 12px;  color: #6fba54;}
.btn_buynow_sec{ background-color:#F3863D !important;  font-size: 16px !important;} 
.btn_buynow_sec:hover{ background-color:#F5A168 !important;}
.free-shipping-label {
  border: 1px dashed #999;
  border-radius: 3px;
  font-size: 10px;
  padding: 1px 7px;
  color: #F38C46;
  font-weight: 600;
  display: inline-block;
  position: relative;
  top: 2px;
  height: 19px;
  box-sizing: border-box;
  font-family: latomedium!important;
  margin-bottom: 15px;
}
.price_section .price_sec_1 .special-price {
  margin-bottom: 0px;
}
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
.data-table tr td{ border:none;}
.btn_adc { padding-top:5px;}
.bootstrap-select.btn-group .dropdown-menu li a{ text-align:left;}
#accordion{ padding-bottom:20px;}
.checkout_left{}
.checkout_left .chk_main_div{border: 1px solid #ddd;}
.checkout_left .chk_main_div label{    position: relative;    top: -4px;}
.shipping_sec h3{ font-weight:bold; padding-bottom:10px;}
.shipping_add_box{ border:1px solid #ddd; padding:10px 20px 20px 35px; margin-right:10px; margin-bottom:10px;    cursor: pointer; height:300px;}

.shipping_add_box:hover{ border:1px solid #fe5621;}
.odd{     position: relative;    right: -17px; background-color:#f9f9f9;}
.shipping_add_box .address .address-name{ font-weight:bold; padding-bottom:20px; font-size:20px;}
.link_edit_del{ padding-top:20px;}
.link_edit_del .edit{ cursor:pointer;}
.link_edit_del .delete{ cursor:pointer;}
.checkout_right .chk_main_div{border: 1px solid #ddd; margin-bottom:20px;}
.shipping_shows{ padding-top:10px;}
.shipping_shows .address .address-name{ font-weight:bold; font-size:18px; }
.checkship{position: absolute;top: 0px;left: 0px;}
.btn-chk-save{ padding-left:20px; padding-right:20px; height:36px;}
.btn-chk-save:hover{ border:none; }
.btn-addnew{ cursor:pointer;    line-height: 34px; }
.btn-addnew:hover{border:none; }
.btn-delivery{padding:8px 20px; margin-top:10px; background:#fe5621;  }
.btn-delivery:hover{ border:none; background:#666666;}
.btn-disable{ background:#666;}
.btn-disable:hover{ background:#999;}
.padding_left_zero{ padding-left:0px;}
.padding_right_zero{ padding-right:0px;}
#shopping-cart-table .product-name{ text-transform:lowercase;}
.opc-review-actions h5 {
    background: #fafafa;
    color: #3f3f3f;
    font-size: 133.33%;
    font-weight: bold;
    margin-bottom: 10px;
    margin-top: 15px;
    padding: 20px 10px;
}
.opc-review-actions h5 span {
    margin-left: 45px;
    font-size: 18px;
    color: #666;
    float: right; display:inline-table;
}
.opc-review-actions h5 span span {
    margin: 0;
}
.opc-review-actions {
    border-top: 1px solid #b6b6b6;
}
.grand_total > div {
    display: inline;
}
.shipping_method_shows{ padding-top:10px; }
.btn-placeorder{  margin-bottom:20px;width: 100%;  line-height: 46px !important;padding: 15px 113px 15px 133px;height: 45px !important; }
.btn-placeorder:hover{ border:none;}
.data-table .price{     color: #fe5621; font-weight:bold;} 
.panel-group .panel{ border-radius:0px !important;}
.panel-heading{     padding: 5px 15px; background-color:#f4f4f4 }
.even {
    position: relative;
    left: 16px;
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/bootstrap-select.js"></script>
