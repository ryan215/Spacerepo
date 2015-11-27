<section class="main-container col1-layout">
	<div class="main container" id="mainContainer">
    	<div class="col-main"> 
      		<!--breadcrumb-->
			<div class="yt-breadcrumbs">
        		
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="category4" itemscope="" itemtype=""><strong>Order Information</strong></li></ul>
					</div>
        			</div>
        		</div>
			
			<!--breadcrumb--> 

			<!--Checkout Page-->
			<div class="row"><div class="col-sm-12"><center><img src="<?php echo base_url(); ?>images/new_images/chk_step2.png" style="padding-bottom:20px;" /></center></div>
			<div class="checkout_left col-sm-8">
			<div class="chk_main_div">
						<div class="super-category-block first-load sn-category-block">
                        	<div class="block-title-defaults ">
                            	<div class="tab-category-title block-title">
                                	<strong>
										<span>
											My Orders (<?php echo count($cartDetails); ?>)
										</span>
									</strong>
                                    <div class="sn-img icon-bacsic item12"></div>
								</div>
                            </div>
						</div> 
          <div class="table-responsive">
            <fieldset>
              <table class="data-table cart-table" id="shopping-cart-table">
                <colgroup>
                <col width="1">
                <col>
                <col width="1">
                <col width="1">
                <col width="1">
                <col width="1">
                <col width="1">
                </colgroup>
                <thead>
                  <tr class="first last">
                    <th rowspan="1">&nbsp;</th>
                    <th rowspan="1"><span class="nobr">Product Name</span></th>
                    <th colspan="1" class="a-center"><span class="nobr">Unit Price</span></th>
                    <th class="a-center" rowspan="1">Qty</th>
                    <th class="a-center">Total</th>
                  </tr>
                </thead>
                <tbody>
<?php 
$totalProduct  = 0;
$shipping_rate = 0;
if(!empty($cartDetails))
{
	$totalAmt = 0;
	$displayPrice  = $cartDetails->productAmt;
	$productWeight = $cartDetails->productWeight;
	
	if($cartDetails->freeShipPrdId)
	{
	}
	elseif($cartDetails->freeShipCatId)
	{
	}
	elseif($cartDetails->genuineShippFee)
	{	
		$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity;
		if($productWeight>10)
		{
			$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity*$productWeight;
		}
	}	

	$totalAmt = $totalAmt+($cartDetails->quantity*$displayPrice)+$shipping_rate;
?>
	<tr class="first odd">
    	<td class="image"><a class="product-image" title="<?php echo $cartDetails->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($cartDetails->productId); ?>">
        	<?php
			$imageUrl = base_url().'img/no_image.jpg';
			if((!empty($cartDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$cartDetails->imageName)))
			{
				$imageUrl = base_url().'uploads/product/thumb500_500/'.$cartDetails->imageName;
			}
			elseif((!empty($cartDetails->imageName))&&(file_exists('uploads/product/'.$cartDetails->imageName)))
			{
				$imageUrl = base_url().'uploads/product/'.$cartDetails->imageName;
			}				
			?>
        	<img src="<?php echo $imageUrl; ?>" width="75" height="75"> </a>
        </td>
        <td>
        	<h2 class="product-name" style="margin-bottom:5px;"> 
            	<a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($cartDetails->productId); ?>"><?php echo $cartDetails->code; ?></a> 
            </h2>
            <?php
			if(!empty($cartDetails->colorCode))
			{
			?>
            <span style="margin-bottom:5px;">
                      <label class="">Color : </label>
                      <a class="btn  btn-xs color_box active_color color_static" style="background-color:<?php echo $cartDetails->colorCode; ?>" href="javascript:void(0);"></a> </span>
                      <?php
						}
						?>
                      <?php
						if(!empty($cartDetails->size))
						{
						?>
                      <span style="margin-bottom:5px;">
                      <label class="">Size :</label>
                      <a class="btn btn-xs size_box  active_color size_static" href="javascript:void(0);"><?php echo $cartDetails->size; ?></a> </span>
                      <?php
						}
						?>
                      <span class="item-info">&nbsp;</span><br>
                      <span class="seller-name"> Seller: <span> <a href="javascript:void(0);"><strong> <?php echo $cartDetails->organizationName; ?> </strong></a> </span> </span></td>
                    <td class="a-center"><span class="cart-price"> <span class="price">₦<?php echo number_format($displayPrice,2); ?></span> </span></td>
                    <td class="a-center movewishlist"><?php echo $cartDetails->quantity; ?></td>
                    <td class="a-center movewishlist"><span class="cart-price"> <span class="price">₦<?php echo number_format($displayPrice*$cartDetails->quantity,2); ?></span> </span></td>
                  </tr>
                  <?php		
									
								}
								$handlingPrice = ($totalAmt*$this->config->item('space_point_comission'))/100; 
								$totalProduct  = $totalAmt+$handlingPrice;
								?>
                </tbody>
              </table>
            </fieldset>
          </div>
		  </div>
          <div class="col-sm-12 captcha-maindiv">
          <div class="col-sm-6 captcha-leftdiv">
            <h3>Verify Order</h3>
            <p>Type the characters you see in the image on the right. Letters shown are  case-sensitive.</p>
          </div>
          <div class="col-sm-6 capchta-rittdiv">
          <div class="captcha-ingdiv">
            <?php 
			 $original_string = array_merge(range(0,9),range('a','z'),range('A','Z'));
			 $original_string = implode("",$original_string);
			 $captcha         = substr(str_shuffle($original_string),0,5);
			 $values = array(
							'word'        => $captcha,
							'word_length' => 5,
							'img_path'    => './uploads/captch/',
							'img_url'     => base_url().'uploads/captch/',
							'font_path'   => base_url().'system/fonts/texb.ttf',
							'img_width'   => '200',
							'img_height'  => 50,
							'expiration'  => 3600
					   );
			$data = create_captcha($values);
			echo $data['image'];
			echo form_error('captchaVal'); 
			?>
          </div>
		  <?php 
$attributes = array('id' => 'catpchaForm');
echo form_open('',$attributes);
form_open_multipart()
?>

            <input type="hidden" name="captchaVal" value="<?php echo $data['word']; ?>" />
            <input type="text" name="imageCaptcha" value="<?php echo set_value('imageCaptcha'); ?>" class="form-control captch-input">
            <?php echo form_error('imageCaptcha');  ?>
		</form>
            </div>
            </div>
		  </div>		
		  
			<div class="checkout_right col-sm-4">
				<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">

								<div class="tab-category-title block-title">
									<strong><span>Shipping Address</span></strong>
									<div class="sn-img icon-bacsic item13"></div>
								</div>
							</div>
						</div>
						<?php
						if(!empty($shippCusDet))
						{
						?>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_shows" style="width:100%;float:left;">
								<div class="address">
									<p>
										<span class="address-name">
											<?php echo ucwords($shippCusDet->firstName.' '.$shippCusDet->lastName); ?>
										</span><br>
										<span class="address-address1">
											<?php echo $shippCusDet->addressLine1; ?>,
										</span><br>
										<span class="address-city">
											<?php echo $shippCusDet->cityName.' - '.$shippCusDet->areaName.' - '.$shippCusDet->stateName; ?>
										</span><br>
									</p>
									<p class="">
										<span class="address-phone">
											<?php echo $shippCusDet->phone; ?>
										</span>
										<span class="address-additional-phone"></span><br>
									</p>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
					<div class="clearfix"></div>
					<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Shipping Details</span></strong>
									<div class="sn-img icon-bacsic item14"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_method_shows" style="width:100%;float:left;">
								<div class="col-sm-6 padding_left_zero">Shipping Fee</div>
								<div class="col-sm-6">
									<strong>
										<?php
										if($shipping_rate)
										{
											echo '&#8358;'.number_format($shipping_rate,2); 
										
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
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_method_shows" style="width:100%;float:left;">
								<div class="col-sm-6 padding_left_zero">Cash Handling Fee</div>
								<div class="col-sm-6">
									<strong>
										<?php
										if($handlingPrice)
										{
											echo '&#8358;'.number_format($handlingPrice,2); 
										
										}
										else
										{
											echo '&#8358;0.00';
										}
										?>
									</strong>
								</div>			
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="opc-review-actions">
						<h5 class="grand_total">Grand Total
							<span class="price">
								<?php echo '&#8358;'.number_format($totalProduct,2); ?>			
							</span>
						</h5><br />
						<a title="Place Order Now" class="button btn-placeorder" onclick="confirm_order();" style="margin-top:20px;">
							<span><span style="font-size: 18px !important;">Confirm Order</span></span>
						</a>												
					</div>
				</div>
        </div>
		</div>
      </div>
      <!--Checkout Page--> 
    </div>
  </div>
</section>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/level-1.css">
<script type="text/javascript">
function confirm_order()
{
	 $("form#catpchaForm").submit();
}
</script>
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
}.btn_red {
    /* margin-left: 0; */
    padding-top: 6px;
    font-size: 12px;
    padding-bottom: 6px;
}
.btn-cart:hover {
    background: #fe5621;
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
	margin-top:20px;
}
.captcha-leftdiv h3{     margin-top: 20px;
    margin-bottom: 10px;}
.btn-confordr{ border-radius:0px !Important; margin-bottom:20px;}
.shipping_method_shows{ padding-top:10px; }
.btn-placeorder{  width: 100%;   font-size: 18px !important; height: 45px !important;    padding: 15px 113px 15px 133px; cursor:pointer; }
.btn-placeorder:hover{ border:none;}
.data-table .price{     color: #fe5621; font-weight:bold;} 
.panel-group .panel{ border-radius:0px !important;}
.panel-heading{padding: 5px 15px; background-color:#f4f4f4;}
.error{ margin-bottom:10px;}
.link_edit_del{ padding-top:20px;}
.link_edit_del .edit{ cursor:pointer;}
.link_edit_del .delete{ cursor:pointer;}
.checkout_right .chk_main_div{border: 1px solid #ddd; margin-bottom:20px;}
.shipping_shows{ padding-top:10px;}
.shipping_shows .address .address-name{ font-weight:bold; font-size:18px; }
.checkship{position: absolute;top: 0px;left:0px;}
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
	margin-bottom:20px;
    border-top: 1px solid #b6b6b6;
}
.grand_total > div {
    display: inline;
}
.btn-confordr{ border-radius:0px !Important; margin-bottom:20px;}
</style>