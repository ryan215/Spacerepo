<section class="main-container col1-layout">
	<div class="main container" id="mainContainer">
  		<div class="col-main">
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
							<strong>Order Information</strong>
						</li>
					</ul>
				</div>
        	</div>
        </div>
		<!--breadcrumb-->
<?php
$isBlackList = 0;
$customerDet = $this->customer_m->black_list_customer_detail($this->session->userdata('userId'));
$this->custom_log->write_log('custom_log','customer details is '.print_r($customerDet,true));

if(!empty($customerDet))
{
	$isBlackList = $customerDet->isBlackList;
}
$this->custom_log->write_log('custom_log','customer is in black list '.$isBlackList);
?>	
		<!--Checkout Page-->
			<div class="row">
			<div class="col-sm-12"><center><img src="<?php echo base_url(); ?>images/new_images/chk_step2.png" style="padding-bottom:20px;" /></center></div>     
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
                                    <?php
									if($isPickUp)
									{
									?>
									<th class="a-center" rowspan="1" width="10%">Processing Fee</th>
									<?php	
									}
									?>
					 				<th class="a-center">Total</th>
                   				</tr>
                			</thead>
							<tbody>
<?php 
$totalProduct  = 0;
$shipping_rate = 0;
$pickupProccessPrice = 0;
$retailerArr = array();

if((!empty($purchaseFrom))&&($purchaseFrom==2)&&(!empty($cartId)))
{
	if(!empty($cartDetails))
	{
		$totalAmt      = 0;
		$productId     = $cartDetails->productId;
		$displayPrice  = $cartDetails->productAmt;
		$productWeight = $cartDetails->productWeight;
		
		if($isPickUp)
		{
			$pickupProccessPrice = $pickupProccessPrice+($cartDetails->quantity*$cartDetails->pickupProccessPrice);
		}
		else
		{	
			if($cartDetails->freeShipPrdId)
			{
			}
			elseif($cartDetails->freeShipCatId)
			{
			}
			elseif($cartDetails->genuineShippFee)
			{				
				if((!empty($isEconomicDelivery))&&($isEconomicDelivery))	
				{
					$standardDet = $this->cart_m->standard_delivery_details($cartDetails->organizationId,$this->session->userdata('userId'));
					if(!empty($standardDet))
					{							
						$shippingRate = $standardDet->shippingRate;
						if($standardDet->totalProductWeight>10)
						{
							$shippingRate = $shippingRate*$standardDet->totalProductWeight;
						}
						$shipping_rate = $shipping_rate+$shippingRate;				
					}
				}
				else
				{
					$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity;
					if($productWeight>10)
					{
						$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity*$productWeight;
					}
				}				
			}	
		}
		$totalAmt = $totalAmt+($cartDetails->quantity*$displayPrice)+$shipping_rate+$pickupProccessPrice;
?>
<tr class="first odd">
	<td class="image">
		<a class="product-image" title="<?php echo $cartDetails->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($cartDetails->productId); ?>">
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
			<img src="<?php echo $imageUrl; ?>" width="75" height="75">
		</a>
	</td>
    <td>
		<h2 class="product-name" style="margin-bottom:5px;"> <a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($cartDetails->productId); ?>"><?php echo $cartDetails->code; ?></a> </h2>
       
		<?php
		if(!empty($cartDetails->colorCode))
		{
		?>
		<span style="margin-bottom:5px;">
			<label class="" style="margin-bottom:5px;">Color : </label>
            <a class="btn  btn-xs color_box active_color color_static" style="background-color:<?php echo $cartDetails->colorCode; ?>" href="javascript:void(0);"></a>
		</span>
		<?php
		}
		if(!empty($cartDetails->size))
		{
		?>
		<span style="margin-bottom:5px;">
			<label class="">Size :</label> 
            <a class="btn btn-xs size_box  active_color size_static" href="javascript:void(0);"><?php echo $cartDetails->size; ?></a>
		</span>
		<?php
		}
		?>
      
		<span class="seller-name">Seller: 
        	<span>
				<a href="javascript:void(0);"><strong><?php echo $cartDetails->organizationName; ?></strong></a>
			</span>
		</span>
	</td>
    <td class="a-center">
		<span class="cart-price"> <span class="price">₦<?php echo number_format($displayPrice,2); ?></span> </span>
	</td>
    <td class="a-center movewishlist"><?php echo $cartDetails->quantity; ?></td>
    <?php
	if($isPickUp)
	{
	?>
	<td class="a-left movewishlist">
    	<span class="">
        	<span class="">
				<?php echo '&#x20A6;'.number_format($cartDetails->pickupProccessPrice,2); ?>
			</span> 
		</span>
	</td>
	<?php 
	}
	?>                   
	<td class="a-center movewishlist">
    	<span class="cart-price"> <span class="price">₦<?php echo number_format($displayPrice*$cartDetails->quantity,2); ?></span> </span>
	</td>
</tr>
	<?php		
	$totalProduct = $totalAmt;
	}
}
elseif(!empty($cartDetails))
{
	$totalAmt = 0;
	$productTypeId    = 0;
	foreach($cartDetails as $results)
	{
		if((!empty($results->productTypeId))&&($results->productTypeId==3))
		{
			$productTypeId = 3;
		}

		$productId    = $results->productId;
		$displayPrice = $results->productAmt;
		$productWeight = $results->productWeight;
		if($isPickUp)
		{
			$pickupProccessPrice = $pickupProccessPrice+($results->quantity*$results->pickupProccessPrice);
		}
		else
		{
			if($results->freeShipPrdId)
			{
			}
			elseif($results->freeShipCatId)
			{
			}
			elseif($results->genuineShippFee)
			{
				if((!empty($isEconomicDelivery))&&($isEconomicDelivery))	
				{
					if(!empty($retailerArr[$results->organizationId]))
					{
					}
					else
					{
						$standardDet = $this->cart_m->standard_delivery_details($results->organizationId,$this->session->userdata('userId'));
						if(!empty($standardDet))
						{									
							$shippingRate = $standardDet->shippingRate;
							if($standardDet->totalProductWeight>10)
							{
								$shippingRate = $shippingRate*$standardDet->totalProductWeight;
							}
							$shipping_rate = $shipping_rate+$shippingRate;									
						}
					}
					$retailerArr[$results->organizationId] = $results->organizationId; 
				}
				else
				{
					$shippingRate = $results->shippingRate;
					if($productWeight>10)
					{
						$shippingRate = $results->shippingRate*$productWeight;
					}
					$shipping_rate = $shipping_rate+($results->quantity*$shippingRate);
				}				
			}
		}
		$totalAmt = $totalAmt+($results->quantity*$displayPrice);
?>
	<tr class="first odd">
    	<td class="image">
			<a class="product-image" title="<?php echo $results->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($results->productId); ?>">
				<?php
				$imageUrl = base_url().'img/no_image.jpg';
				if((!empty($results->imageName))&&(file_exists('uploads/product/thumb500_500/'.$results->imageName)))
				{
					$imageUrl = base_url().'uploads/product/thumb500_500/'.$results->imageName;
				}
				elseif((!empty($results->imageName))&&(file_exists('uploads/product/'.$results->imageName)))
				{
					$imageUrl = base_url().'uploads/product/'.$results->imageName;
				}
				?>
				<img src="<?php echo $imageUrl; ?>" width="75" height="75">
			</a>
		</td>
		<td>
			<h2 class="product-name" style="margin-bottom:5px;"> <a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($results->productId); ?>"><?php echo $results->code; ?></a> </h2>
           
			<?php
			if(!empty($results->colorCode))
			{
			?>
			<span style="margin-bottom:5px;">
				<label class="">Color : </label>
                <a class="btn  btn-xs color_box active_color color_static" style="background-color:<?php echo $results->colorCode; ?>" href="javascript:void(0);"></a>
			</span>
			<?php
			}
			if(!empty($results->size))
			{
			?>
				<span style="margin-bottom:5px;">
					<label class="">Size :</label> 
                    <a class="btn btn-xs size_box  active_color size_static" href="javascript:void(0);"><?php echo $results->size; ?></a>
				</span>
			<?php
			}
			?>
           
			<span class="seller-name">
				Seller: <span>
					<a href="javascript:void(0);"><strong>
					<?php echo $results->organizationName; ?>
						</strong>
                	</a>
				</span>
			</span>
		</td>
        <td class="a-center">
			<span class="cart-price"> <span class="price">₦<?php echo number_format($displayPrice,2); ?></span> </span>
		</td>
        <td class="a-center movewishlist"><?php echo $results->quantity; ?></td>                   
        <?php
					if($isPickUp)
					{
					?>
					<td class="a-left movewishlist"><span class=""> <span class="">
						<?php echo '&#x20A6;'.number_format($results->pickupProccessPrice,2); ?>
					</span> </span></td>
					<?php 
					}
					?>
		<td class="a-center movewishlist"><span class="cart-price"> <span class="price">₦<?php echo number_format($displayPrice*$results->quantity,2); ?></span> </span>
        </td>
	</tr>
	<?php		
	}
	$totalProduct = $totalAmt+$shipping_rate+$pickupProccessPrice;
	//$totalProduct = $totalAmt;
}
?>
					</tbody>
				</table>
        	</fieldset>
    	</div>
	</div>	
</div>
<?php
if((!empty($purchaseFrom))&&($purchaseFrom==2)&&(!empty($cartId)))
{
	if($isPickUp)
	{			
	?>
	<div class="checkout_right col-sm-4">
		<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Pickup Address</span></strong>
									<div class="sn-img icon-bacsic item13"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_shows" style="width:100%;float:left;">
								<a href="<?php echo base_url().'frontend/product_buy_now/pickup_address/'.id_encrypt($cartId); ?>" style="position:absolute; right:15px;" title="Edit Delivery Address"><i class="fa fa-pencil"></i></a>								
								<?php
								if(!empty($pickupAddress))
								{
								?>						
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
								<?php
								}
								?>
							</div>
						</div>
					</div>
		<div class="clearfix"></div>
					
		<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Pickup Method</span></strong>
									<div class="sn-img icon-bacsic item14"></div>
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
		
		<div class="opc-review-actions">
			<h5 class="grand_total">Grand Total
				<span class="price">
					<?php echo '&#8358;'.number_format($totalProduct,2); ?>			
				</span>
			</h5>
			<?php
			if($isBlackList==0)
			{
				if((!empty($cartDetails->productTypeId))&&($cartDetails->productTypeId==3))
				{
				}
				else
				{
					if((!empty($payOnPickUp))&&($payOnPickUp))
					{
					?>
		    		<a href="<?php echo base_url().'frontend/checkout_cash/pay_on_pickup'; ?>" class="button  btn-placeorder">
						Pay On Pickup
					</a>
		    	<?php
					}
				}
			}
			?>
		</div>
	</div>				 
	<?php								 
	}
	else
	{		
	?>
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
			</div>
		<div class="clearfix"></div>
		
		<div class="opc-review-actions">
			<h5 class="grand_total">Grand Total
				<span class="price">
					<?php echo '&#8358;'.number_format($totalProduct,2); ?>			
				</span>
			</h5>
			<?php
			if((!empty($isEconomicDelivery))&&($isEconomicDelivery)&&($isBlackList==0))	
			{
			?>
			<a href="<?php echo base_url().'frontend/checkout_cash/cash_on_economic_delivered_buy_now/'.id_encrypt($cartId); ?>" class="button  btn-placeorder" >
				Cash On Delivery
			</a>
			<?php
			}
			elseif($isBlackList==0)
			{
			?>
			<a href="<?php echo base_url().'frontend/checkout_cash/cash_on_economic_delivered_buy_now/'.id_encrypt($cartId); ?>" class="button  btn-placeorder" >Cash On Delivery</a>
			<?php
			}
			?>			
		</div>
	</div>				 
	<?php				
	}
}
else
{
	if($isPickUp)
	{			
	?>
	<div class="checkout_right col-sm-4">
		<div class="chk_main_div">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Pickup Address</span></strong>
									<div class="sn-img icon-bacsic item13"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_shows" style="width:100%;float:left;">
								<a href="<?php echo base_url().'frontend/product_cart/pickup_address'; ?>" style="position:absolute; right:15px;" title="Edit Delivery Address"><i class="fa fa-pencil"></i></a>								
								
								<?php
								if(!empty($pickupAddress))
								{
								?>						
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
								<?php
								}
								?>
							</div>
						</div>
					</div>
		<div class="clearfix"></div>
		
		<div class="chk_main_div">
			<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Pickup Method</span></strong>
									<div class="sn-img icon-bacsic item14"></div>
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
		<div class="opc-review-actions">
			<h5 class="grand_total">Grand Total
				<span class="price">
					<?php echo '&#8358;'.number_format($totalProduct,2); ?>			
				</span>
			</h5>
			<?php
			if((!empty($payOnPickUp))&&($payOnPickUp))
			{
			}
			?>
		</div>
	</div>				 
	<?php								 
	}
	else
	{		
	?>
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
		</div>
		<div class="clearfix"></div>
		
		<div class="opc-review-actions">
			<h5 class="grand_total">Grand Total
				<span class="price">
					<?php echo '&#8358;'.number_format($totalProduct,2); ?>			
				</span>
			</h5>
			<?php
			if((!empty($productTypeId))&&($productTypeId==3))
			{
			}
			else
			{
			if((!empty($isEconomicDelivery))&&($isEconomicDelivery)&&($isBlackList==0))	
			{
			?>
			<a href="<?php echo base_url().'frontend/checkout_cash/cash_on_economic_delivered'; ?>" class="button  btn-placeorder" >
				Cash On Delivery
			</a>
			<?php
			}
			elseif($isBlackList==0)
			{
			?>
			<a href="<?php echo base_url().'frontend/checkout_cash/cash_on_delivered_add_to_cart'; ?>" class="button  btn-placeorder" >Cash On Delivery</a>
			<?php
			}
			}
			?>
		</div>
	</div>				 
	<?php				
	}
}

$order_total = $totalProduct*100;
$order_total = round($order_total);
if((!empty($purchaseFrom))&&($purchaseFrom==2)&&(!empty($cartId)))
{
	if($isPickUp)
	{
		$redirect_url = payment_redirect_buy_now_pickup($order_total,$cartId);
	}
	else
	{
		if((!empty($isEconomicDelivery))&&($isEconomicDelivery))	
		{
			$redirect_url = payment_redirect_buy_now_economical_delivery($order_total,$cartId);
		}
		else
		{
			$redirect_url = payment_redirect_buy_now_delivery($order_total,$cartId);
		}
	}
}
else
{
	if($isPickUp)
	{
		$redirect_url = payment_redirect_add_to_cart_pickup($order_total);
	}
	else
	{
		if((!empty($isEconomicDelivery))&&($isEconomicDelivery))	
		{
			$redirect_url = payment_redirect_add_to_cart_economical_delivery($order_total);
		}
		else
		{
			$redirect_url = payment_redirect_add_to_cart_delivery($order_total);
		}
	}
}
$product_id   = static_product_id();
$txn_ref      = txt_reference($this->session->userdata('userId'));
$pay_item_id  = pay_item_id();
$mac_key      = mac_key();
$hash 		  = $txn_ref.$product_id.$pay_item_id.$order_total.$redirect_url.$mac_key;
$hash 		  = hash("sha512",$hash);


$attributes = array('id' => 'webpay_payment_form','target' => '_top');
echo form_open('https://stageserv.interswitchng.com/test_paydirect/pay',$attributes);	//	Sandbox 
//echo form_open('https://webpay.interswitchng.com/paydirect/pay',$attributes);	//	Live
?>
	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
	<input type="hidden" name="amount" value="<?php echo $order_total; ?>">	
	<input type="hidden" name="currency" value="<?php echo currency_value(); ?>">
	<input type="hidden" name="site_redirect_url" value="<?php echo $redirect_url; ?>">
	<input type="hidden" name="txn_ref" value="<?php echo $txn_ref; ?>">			
	<input type="hidden" name="hash" value="<?php echo $hash;?>">
	<input type="hidden" name="pay_item_id" value="<?php echo $pay_item_id; ?>">
	<input type="hidden" name="cust_name" value="<?php echo $this->session->userdata('userName'); ?>">
	<input type="hidden" name="cust_name_desc" value="Customer Name">
	<input type="hidden" name="cust_id" value="<?php echo $this->session->userdata('userId'); ?>">
	<input type="hidden" name="cust_id_desc" value="Transaction Reference">
				<!-- Button Fallback -->
	<div class="payment_buttons">
    	<input type="submit" id="submit_webpay_payment_form" class="button btn-placeorder-sub" value="Pay Online" onclick="return authentic();" style="  margin-left: 15px !important;">
    </div>	
</form>

		</div>
		<!--Checkout Page-->
	</div>
</section>

<script type="text/javascript">
function authentic()
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/checkout_payment/authentication'; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			$('#mainContainer').html(result);
			return true;
		}
	});
	return true;
}
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

.shipping_method_shows{ padding-top:10px; }
.btn-placeorder{  margin-bottom:20px;width: 100%;font-size:18px;  line-height: 46px !important;padding: 15px 113px 15px 115px;height: 45px !important; cursor:pointer; }
.btn-placeorder-sub {margin-bottom: 20px;font-size: 18px;height: 55px !important; float: right; width: 368px; cursor: pointer;margin-right: 15px;} 
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

</style>