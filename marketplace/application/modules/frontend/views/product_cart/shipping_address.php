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
							<li class="category4" itemscope="" itemtype=""> <strong>Shipping Address</strong> </li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<center>
					<img src="<?php echo base_url(); ?>images/new_images/chk_step2.png" style="padding-bottom:20px;" />
				</center>
			</div>

			<div class="checkout_left col-sm-8">
				<div class="chk_main_div" style="margin-bottom:20px; border:0;">
					<div class="row" id="shippingList">
						<div class="super-category-block first-load sn-category-block" style="margin-bottom:0;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title"> <strong><span>How would you like to receive your package?</span></strong>
									<div class="sn-img icon-bacsic item11"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 pd">
							<div class="panel-group" id="accordion">
								<div class="panel panel-default"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										<div class="panel-heading">
											<h4 class="panel-title" style="margin:6px 0 !important;"> Shipping </h4>
										</div>
									</a>

									<div id="collapseOne" class="panel-collapse collapse in" style="overflow:visible; margin-top:0px; padding:0px;">
										<div class="panel-body shipping_sec" style="width:100%;  height: 65px;  margin-top: 0px !Important;  padding-top: 20px;">
											<div class="col-sm-6 padding_left_zero">
												<h3>Your Delivery Address</h3>
											</div>
											<div class="col-sm-6 padding_right_zero">

												<a data-toggle="modal" data-target="#modal-delivery" class="account-toplink pull-right button btn-addnew" title="Add New Delivery Address"  id="addDelAdd"> <i class="fa fa-plus"></i> &nbsp;Add New Delivery Address </a>
												<div class="modal fade" id="modal-delivery" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog block-popup-login" > <a href="javascript:void(0)" title="Close" class="close close-login" data-dismiss="modal">Close</a>
														<div class="tt_popup_login"><strong>Add New Delivery Address</strong> </div>
														<?php
														echo form_open();
														?>
														<div class="block-content">
															<div class="col-reg registered-account" style="padding-right:0px; width:100%; border-right:none;">
																<div class="email-input">
																	<input type="text" title="First Name" class="input-text" name="firstName" placeholder="First Name" value="<?php echo set_value('firstName'); ?>">
																	<?php echo form_error('firstName'); ?> </div>
																<div class="email-input">
																	<input type="text" title="Last Name" class="input-text" name="lastName" placeholder="Last Name" value="<?php echo set_value('lastName'); ?>">
																	<?php echo form_error('lastName'); ?> </div>
																<div class="mobile-input">
																	<input type="text" title="Mobile No." class="input-text" name="phoneNo" placeholder="Mobile No." value="<?php echo set_value('phoneNo'); ?>">
																	<?php echo form_error('phoneNo'); ?> </div>
																<div class="">
																	<select style="width: 100%; height: 36px; margin-bottom:15px;" name="stateId" onchange="area_list(this.value);">
																		<option value="">Select State</option>
																		<?php
																		if(!empty($stateList))
																		{
																			foreach($stateList as $row)
																			{
																				?>
																				<option value="<?php echo $row->stateId; ?>" <?php echo set_select('stateId',$row->stateId); ?>> <?php echo $row->stateName; ?> </option>
																				<?php
																			}
																		}
																		?>
																	</select>
																	<?php echo form_error('stateId'); ?> </div>
																<div class="">
																	<div id="areaList">
																		<select name="areaId" style="width: 100%; height: 36px;margin-bottom:15px;">
																			<option value="">Select Area</option>
																		</select>
																	</div>
																	<?php echo form_error('areaId'); ?> </div>
																<div class="">
																	<div id="cityList">
																		<select name="cityId" class="" style="width: 100%; height: 36px;margin-bottom:15px;">
																			<option value="">Select City</option>
																		</select>
																	</div>
																	<?php echo form_error('cityId'); ?> </div>
																<div class="address-input">
																	<input type="text" class="input-text" title="Address Line 1" placeholder="Address1" value="<?php echo set_value('address1'); ?>" name="address1">
																	<?php echo form_error('address1'); ?> </div>
																<div class="address-input">
																	<input type="text"  class="input-text" title="Address Line 2" placeholder="Address2" value="<?php echo set_value('address2'); ?>" name="address2">
																	<?php echo form_error('address2'); ?> </div>
																<div class="actions">
																	<div class="submit-save">
																		<center>
																			<input title="SAVE" type="submit" class="button btn-chk-save" name="SHIPPING_ADD" value="Save" />
																		</center>
																	</div>
																</div>
															</div>
															<div style="clear:both;"></div>
														</div>
														</form>
													</div>
												</div>
											</div>
											<div class="clearfix"></div>
											<br />
											<?php
											if(!empty($allShippCusAdd))
											{
												foreach($allShippCusAdd as $row)
												{
													?>
													<div class="shipping_add_box <?php if($row->addressId==$shippCusAddId){ echo 'even'; }else{ echo 'odd'; } ?>" style="width:48%;float:left;">
														<?php
														if($row->addressId==$shippCusAddId)
														{
															?>
															<img src="<?php echo base_url(); ?>images/new_images/checkship.PNG" class="checkship" />
															<?php
														}
														?>
														<div class="address">
															<p> <span class="address-name"> <?php echo ucwords($row->firstName.' '.$row->lastName); ?> </span><br>
																<span class="address-address1"> <?php echo $row->addressLine1; ?>, </span><br>
																<span class="address-city"> <?php echo $row->cityName.' - '.$row->areaName.' - '.$row->stateName; ?> </span><br>
															</p>
															<p class=""> <span class="address-phone"> <?php echo $row->phone; ?> </span> <span class="address-additional-phone"></span><br>
															</p>
														</div>
														<div class="link_edit_del">
															<?php
															if($row->addressId==$shippCusAddId)
															{
																?>
																<a href="<?php echo base_url().'frontend/product_cart/check_shipping_delivery_here/'.id_encrypt($row->addressId); ?>" class="button btn-delivery btn-disable"> Deliver Here </a>
																<?php
															}
															else
															{
																?>
																<a href="<?php echo base_url().'frontend/product_cart/check_shipping_delivery_here/'.id_encrypt($row->addressId); ?>" class="button btn-delivery btn-disable"> Deliver Here </a>
																<?php
															}
															?>
														</div>
													</div>
													<?php
												}
											}
											?>


										</div>
									</div>

								</div>
								<div class="panel panel-default"> <a href="<?php echo base_url().'frontend/product_cart/pickup_address'; ?>">
										<div class="panel-heading">
											<h4 class="panel-title" style="margin:6px 0 !important;"> Pickup </h4>
										</div>
									</a>
									<div id="collapseTwo" class="panel-collapse collapse">
										<div class="panel-body"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="productList" style="display:none; ">
						<div class="super-category-block first-load sn-category-block" style="margin-bottom:0;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>
										My Orders (<?php echo count($cartDetails); ?>)									
									</span></strong>
									<div class="sn-img icon-bacsic item12"></div>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<fieldset>
								<table class="data-table cart-table" id="shopping-cart-table" style="margin-top:0;">
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
									$pickupProccessPrice = 0;
									$retailerArr = array();
									$totalAmt = 0;
									$retailerCart     = array();
									$economicalShippAmt = 0;
									$standardShippAmt   = 0;
									$sameDayDeliveryoption = 2;

									foreach($cartDetails as $results)
									{
										$productId    = $results->productId;
										$displayPrice = $results->productAmt;
										$productWeight = $results->productWeight;

										$retailerCart[$results->organizationId]['retailerId']   = $results->organizationId;
										$retailerCart[$results->organizationId]['toDropshipId'] = $results->toDropshipId;


										if($results->freeShipPrdId)
										{
										}
										elseif($results->freeShipCatId)
										{
										}
										elseif($results->genuineShippFee)
										{
											if((!empty($retailerCart[$results->organizationId]['totalProductWeight']))&&($retailerCart[$results->organizationId]['totalProductWeight']))
											{
												$retailerCart[$results->organizationId]['totalProductWeight'] = $retailerCart[$results->organizationId]['totalProductWeight']+($results->productWeight*$results->quantity);
											}
											else
											{
												$retailerCart[$results->organizationId]['totalProductWeight'] = $results->productWeight*$results->quantity;
											}

											$shippingRate = $results->shippingRate;
											if($productWeight>10)
											{
												$shippingRate = $results->shippingRate*$productWeight;
											}
											$shipping_rate = $shipping_rate+($results->quantity*$shippingRate);
											$standardShippAmt = $shipping_rate;
										}
										$totalAmt = $totalAmt+($results->quantity*$displayPrice);
										?>
										<tr class="">
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
	<?php
	$totalproductWeight=$results->productWeight*$results->quantity;
	
	if((!empty($shippCusDet))&&($shippCusDet->state)&&(!empty($results->dropshipStateId))&&($results->dropshipStateId==$shippCusDet->state)&&(!empty($totalproductWeight))&&($totalproductWeight)&&($totalproductWeight<$this->config->item('flate_weight')))
	{
		if($sameDayDeliveryoption)
		{
			$sameDayDeliveryoption = 1;
		}
		else
		{
			$sameDayDeliveryoption = 0;
		}
		
		if((!empty($sameDayDelivery[$results->organizationId]['totalProductWeight']))&&($sameDayDelivery[$results->organizationId]['totalProductWeight']))
		{
			$sameDayDelivery[$results->organizationId]['totalProductWeight'] = $sameDayDelivery[$results->organizationId]['totalProductWeight']+($results->productWeight*$results->quantity);
		}
		else
		{
			$sameDayDelivery[$results->organizationId]['totalProductWeight'] = $results->productWeight*$results->quantity;
		}
	}
	else
	{
		$sameDayDeliveryoption = 0;
	}
	?>
											</td>
											<td class="a-center">
												<span class="cart-price"> <span class="price">&#x20A6;<?php echo number_format($displayPrice,2); ?></span> </span>
											</td>
											<td class="a-center movewishlist"><?php echo $results->quantity; ?></td>
											<?php
											?>
											<td class="a-center movewishlist"><span class="cart-price"> <span class="price">&#x20A6;<?php echo number_format($displayPrice*$results->quantity,2); ?></span> </span>
											</td>

										</tr>
										<?php
									}
									$totalProduct = $totalAmt+$shipping_rate+$pickupProccessPrice;


									//$totalProduct = $totalAmt;
									?>
									</tbody>
								</table>
							</fieldset>
						</div>
					</div>

					<div id="capthImg" style="display:none; border:1px solid #ccc; border-top:0 !important;">
						<div class="col-sm-12 captcha-maindiv">
							<div class="col-sm-6 captcha-leftdiv">
								<h3>Verify Order</h3>
								<p style="margin-top:8px;">Type the characters you see in the image on the right. Letters shown are  case-sensitive.</p>
							</div>
							<div class="col-sm-6 capchta-rittdiv">
								<?php
								$attributes = array('id' => 'catpchaForm');
								echo form_open('',$attributes);
								?>
								<div class="col-xs-12">
									<div class="captcha-ingdiv" id="ajaxCaptcha" style="width:200px; float:left;">
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
										?>
										<input type="hidden" name="captchaVal" value="<?php echo $data['word']; ?>" />								 							</div>
									<div onclick="refresh_capthca();" style="width: 30px; display: inline-block; float: left; height:80px; font-size:24px; margin-left:8px; line-height:80px; padding-top:7px;"><a href="javascript:void(0);"><i class="fa fa-refresh"></i></a></div>
								</div>
								<div class="clearfix"></div>
								<div class="col-sm-12 col-lg-12">
									<input type="text" name="imageCaptcha" value="<?php echo set_value('imageCaptcha'); ?>" class="form-control captch-input">
								</div>
								<?php echo form_error('imageCaptcha');  ?>
								<input type="hidden" name="economicCapcha" id="captchaHidden" value="1" />
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="checkout_right col-sm-4">
				<div id="rightProductList">
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
							<table class="data-table cart-table cart-table-customnew" id="shopping-cart-table">
								<thead>
								<tr class="first last">
									<th rowspan="1">&nbsp;</th>
									<th rowspan="1"  width="45%"><span class="nobr">Product Name</span></th>
									<th colspan="1" class="a-center" width="20%"><span class="nobr">Price</span></th>
									<th class="a-center" rowspan="1" width="15%">Qty</th>
								</tr>
								</thead>
								<tbody>
								<?php
								$totalAmt     = 0;
								$shippingRate = 0;
								$totalShipp   = 0;
								$showEconomicDel = 0;
								$sameRetailer = array();
								//echo "<pre>"; print_r($cartDetails); exit;
								$minEta = 0;
								$maxEta = 0;
								if(!empty($cartDetails))
								{
									foreach($cartDetails as $row)
									{
										$etaDay = $row->ETA+$this->config->item('estimated_time_increase');
										if($minEta)
										{
											if($etaDay<$minEta)
											{
												$minEta = $etaDay;
											}
										}
										else
										{
											$minEta = $etaDay;
										}

										if($maxEta)
										{
											if($etaDay>$maxEta)
											{
												$maxEta = $etaDay;
											}
										}
										else
										{
											$maxEta = $etaDay;
										}

										if(!empty($sameRetailer[$row->organizationId]['totalPrd']))
										{
											$sameRetailer[$row->organizationId]['totalPrd'] = $sameRetailer[$row->organizationId]['totalPrd']+1;
										}
										else
										{
											$sameRetailer[$row->organizationId]['totalPrd'] = 1;
										}

										if((!empty($sameRetailer[$row->organizationId]['totalPrd']))&&($sameRetailer[$row->organizationId]['totalPrd']>1))
										{
											$showEconomicDel = 1;
										}

										if($row->quantity>1)
										{
											$showEconomicDel = 1;
										}
										?>
										<tr class="first last">
											<td class="image" style="padding:3px;">
												<a class="product-image" title="<?php echo $row->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->productId); ?>">
													<?php
													if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
													{
														?>
														<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$row->imageName; ?>" width="45" height="45"/>
														<?php
													}
													elseif((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
													{
														?>
														<img src="<?php echo base_url().'uploads/product/'.$row->imageName; ?>" width="45" height="45"/>
														<?php
													}
													else
													{
														?>
														<img src="<?php echo base_url().'img/no_image.jpg'; ?>" width="45" height="45"/>
														<?php
													}
													?>
												</a>
											</td>
											<td>
												<h2 class="product-name">
													<a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->productId); ?>">
														<?php echo $row->code; ?>
													</a>
												</h2>
											</td>
											<td class="a-right">
		<span class="cart-price"> <span class="price">
    		<?php
			echo '&#8358;'.number_format(($row->productAmt*$row->quantity),2);
			?>
         </span> </span>
											</td>
											<td class="a-center movewishlist"><div class="qty-div"><?php echo $row->quantity; ?></div></td>
										</tr>
										<?php
										$displayPrice  = $row->productAmt;
										$productWeight = $row->productWeight;
										$shippingRate  = 0;
										$totalAmt 	   = $totalAmt+($row->quantity*$displayPrice);
									}
								}
								?>
								</tbody>
							</table>
						</fieldset>
					</div>
				</div>

				<?php
				if(!empty($shippCusDet))
				{
					?>
					<div class="chk_main_div" id="rightShippingAdd" style="margin-bottom:5px;">
						<div id="" class="super-category-block first-load sn-category-block" style="margin-bottom:0px;">
							<div class="block-title-defaults ">
								<div class="tab-category-title block-title">
									<strong><span>Shipping Address</span></strong>
									<div class="sn-img icon-bacsic item13"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12" style="display:inline-block;">
							<div class="shipping_shows" style="width:100%;float:left;">
								<a href="javascript:void(0);" onclick="change_shipping();" id="editShipp" style="display:none; position:absolute; right:15px;" title="Edit Delivery Address"><i class="fa fa-pencil"></i></a>
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
					</div>
					<div class="clearfix"></div>
					<?php
				}
				?>
				<div class="clearfix"></div>
				<div style="margin:6px 0 0; padding-bottom: 5px; display:inline-block;width: 100%;">
					<div class="col-sm-6 text-left"><label><strong>Total </strong></label></div>
					<div class="col-sm-6 text-right"><span style="color:#FE5621; margin-left:30px; font-weight:bold;">
							 <?php echo '&#8358;'.number_format($totalAmt,2); ?> 
						</span></div>
				</div>
				<?php /*?><h5 class="grand_total" style="margin:0;">
						Total 
						<span class="price"> 
							<?php echo '&#8358;'.number_format($totalAmt,2); ?> 
						</span> 
					</h5><?php */?>
				<div class="" id="rightShippingRate" style="display:none;">
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
								<strong id="shippingRate"></strong>
							</div>
						</div>
					</div>
					<div class="col-sm-12" id="rightCashHandling" style="display:none;">
						<div class="shipping_method_shows" style="width:100%;float:left;">
							<div class="col-sm-6 padding_left_zero">Cash Handling Fee</div>
							<div class="col-sm-6">
								<strong id="cashHandlingRate"></strong>
							</div>
						</div>
					</div>
				</div>

				<div class="opc-review-actions" style="margin-bottom:40px; border-top:0;">

					<?php
					$sameDayDelOpt1 = 0;
					if(!empty($shippCusAddId))
					{
						if(!empty($retailerCart))
						{
							foreach($retailerCart as $retailerKey=>$retailerRow)
							{
								$dropshipId  = $retailerRow['toDropshipId'];
								//		print_r($retailerRow);

								$stateId	 = $shippCusDet->state;
								$areaId	     = $shippCusDet->area;
								$cityId		 = $shippCusDet->city;
								if(!empty($retailerRow['totalProductWeight']))
								{
									$totalWeight = $retailerRow['totalProductWeight'];
									$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);
									if(!empty($shipRateDet))
									{
										$shippingRate = $shipRateDet->amount;
										if($totalWeight>10)
										{
											$shippingRate = $shippingRate*$totalWeight;
										}
										$economicalShippAmt = $economicalShippAmt+$shippingRate;
									}
								}
							}
						}
						?>
						<div class="col-xs-12 pd">
							<?php
							if((!empty($showEconomicDel))&&($showEconomicDel))
							{
								?>
							<div>
								<input type="radio" name="selType" onclick="economical_fun();" id="economicRadio" style="margin-top:8px;" />
								<!--<label for="economicRadio" style="font-size:17px;"> Ground Delivery </label>-->
								<label for="economicRadio" style="font-size:17px;">Single Shipment</label>
								<a href="#" data-toggle="tooltip" data-original-title="Note: Your entire order will be delivered to you in one shipment. More economical choice." ><i class="fa fa-question-circle"></i></a>
								<!--<a href="#" data-toggle="tooltip" data-original-title="Note: All of the products in the cart will be collectively delivered" ><i class="fa fa-question-circle"></i></a>-->

								<div style="font-style:italic; color:#FE5621; font-size:14px;">
									<span><?php echo '&#x20A6;'.$economicalShippAmt; ?></span>
									<?php
									$eMinEta = $minEta+$this->config->item('economic_delivery_estimated_time');
									$eMaxEta = $maxEta+$this->config->item('economic_delivery_estimated_time');
									$ecoMinDt = date('Y-m-d')+strtotime('+ '.$eMinEta.' days');
									$ecoMaxDt = date('Y-m-d')+strtotime('+ '.$eMaxEta.' days');
									if($ecoMinDt==$ecoMaxDt)
									{
										echo 'Get it on '.date('l, F d, Y',$ecoMinDt);
									}
									else
									{
										echo 'Get it between '.date('l, F d, Y',$ecoMinDt).' to '.date('l, F d, Y',$ecoMaxDt);
									}
									?>
								</div>
							</div>
							<?php
							}
							?>

								<div>
									<input type="radio" name="selType" onclick="standard_fun();" id="standardRadio" style="margin-top:8px;" />
									<!--<label for="standardRadio" style="font-size:17px;"> Express Delivery </label>-->
									<label for="standardRadio" style="font-size:17px;">Quick Shipment</label>
									<a href="#" data-toggle="tooltip" data-original-title="Note: The products in your order will be shipped separately. All your orders will get to you as fast as they are received." ><i class="fa fa-question-circle"></i></a>

									<div style="font-style:italic; color:#FE5621; font-size:14px;">
										<span><?php echo '&#x20A6;'.$standardShippAmt; ?></span>
										<?php
										$sMinEta = $minEta;
										$sMaxEta = $maxEta;
										$stdMinDt = date('Y-m-d')+strtotime('+ '.$sMinEta.' days');
										$stdMaxDt = date('Y-m-d')+strtotime('+ '.$sMaxEta.' days');
										if($stdMinDt==$stdMaxDt)
										{
											echo 'Get it on '.date('l, F d, Y',$stdMaxDt);
										}
										else
										{
											echo 'Get it between '.date('l, F d, Y',$stdMinDt).' to '.date('l, F d, Y',$stdMaxDt);
										}
										?>
									</div>
								</div>
								<?php
							
							
							if((!empty($sameDayDeliveryoption))&&($sameDayDeliveryoption)&&($sameDayDeliveryoption==1))
							{
								$time = date('H');
								if($time<$this->config->item('same_day_delivery_time'))
								{
									$sameDayDelOpt1 = 1;
							?>
								<div>								
										<input type="radio" name="selType" onclick="sameday_fun();" id="sameDayRadio" style="margin-top:8px;" />
										<label for="sameDayRadio" style="font-size:17px;">SameDay Delivery</label>
										<a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Note: Your entire order will be delivered to you in Same Day Delivery."><i class="fa fa-question-circle"></i></a>
										<div style="font-style:italic; color:#FE5621; font-size:14px;">
											<span>
												<?php 
												$sameDayShippAmt = $standardShippAmt+$this->config->item('flate_rate_same_day_delivery');
												echo '&#x20A6;'.$sameDayShippAmt; 
												?>
											</span>
											<?php
											$sMinEta = $minEta;
											$sMaxEta = $maxEta;
											$stdMinDt = date('Y-m-d')+strtotime('+ '.$sMinEta.' days');
											$stdMaxDt = date('Y-m-d')+strtotime('+ '.$sMaxEta.' days');
											if($stdMinDt==$stdMaxDt)
											{
												echo 'Get it on '.date('l, F d, Y',$stdMaxDt);
											}
											else
											{
												echo 'Get it between '.date('l, F d, Y',$stdMinDt).' to '.date('l, F d, Y',$stdMaxDt);
											}
											?>
										</div>
									</div>
							<?php
								}
							}
							?>


							<div id="deleveryBtn">
							</div>
						</div>
						<?php
					}
					else
					{

						?>
						<a title="Place Order Now" class="button btn-placeorder" onclick="select_shipping_add();" style="cursor:pointer !important;"> <span><span style="font-size: 18px !important;">Place Order Now</span></span> </a>
						<?php
					}
					?>
				</div>
			</div>

		</div>
	</div>
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
<script type="text/javascript">
	<?php
    if((!empty($shippCusAddId))&&($shippCusAddId))
    {
    ?>
	$('div#productList').css('display','block');
	$('div#shippingList').css('display','none');
	$('div#rightProductList').css('display','none');
	$('a#editShipp').css('display','block');
	<?php
    }
    ?>
	function change_shipping()
	{
		$('#captchaHidden').val(0);

		$('#rightShippingAdd').css('display','none');
		$('div#productList').css('display','none');
		$('a#editShipp').css('display','none');
		$('div#capthImg').css('display','none');
		$('div#deleveryBtn').css('display','none');
		$('div#rightCashHandling').css('display','none');

		$('#addDelAdd').css('display','block');
		$('div#shippingList').css('display','block');
		$('div#rightProductList').css('display','block');

		$("#standardRadio").attr('checked',false);
		$("#economicRadio").attr('checked',false);
	}

	loadVar = 1;
	function economical_fun()
	{
		//$('#resultLoading').css('display','block');
		$('#captchaHidden').val(0);
		$('div#capthImg').css('display','none');
		$('#standardDelId').css('display','none');
		$('#economicalDelId').css('display','block');
		$('div#productList').css('display','block');
		$('div#shippingList').css('display','none');
		$('div#rightProductList').css('display','none');
		$('a#editShipp').css('display','block');
		$('div#deleveryBtn').css('display','block');
		$('div#rightCashHandling').css('display','none');
		$('#rightShippingAdd').css('display','block');

		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_cart/economical_shipping_amount'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){ 	//alert(result);
				$('#standardShippAmt').html('');
				//$('#resultLoading').css('display','none');
				if(result.success==1)
				{
					$('div#rightShippingRate').css('display','block');
					$('strong#shippingRate').html(result.totalShippingAmt);
					$('#economicShippAmt').html(result.totalShippingAmt);
					$('div#deleveryBtn').css('display','block');
					$('div#deleveryBtn').html(result.viewfile);
					<?php
                    if((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==1))
                    {
                    ?>
					if(loadVar==1)
					{
						economic_cash_on_delivery();
					}
					loadVar++;
					<?php
                    }
                    ?>
				}
				else
				{
					$('#economicShippAmt').html(result.message);
				}
			}
		});
	}

	function standard_fun()
	{
		//$('#resultLoading').css('display','block');
		$('#captchaHidden').val(0);
		$('div#capthImg').css('display','none');
		$('#economicalDelId').css('display','none');
		$('#standardDelId').css('display','block');
		$('div#productList').css('display','block');
		$('div#shippingList').css('display','none');
		$('div#rightProductList').css('display','none');
		$('a#editShipp').css('display','block');
		$('div#rightCashHandling').css('display','none');
		$('#rightShippingAdd').css('display','block');

		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_cart/standard_shipping_amount'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){
				$('#economicShippAmt').html('');
				//$('#resultLoading').css('display','none');
				if(result.success==1)
				{
					$('div#rightShippingRate').css('display','block');
					$('strong#shippingRate').html(result.totalShippingAmt);
					$('#standardShippAmt').html(result.totalShippingAmt);
					$('div#deleveryBtn').css('display','block');
					$('div#deleveryBtn').html(result.viewfile);
					<?php
                    if((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==2))
                    {
                    ?>
					if(loadVar==1)
					{
						standard_cash_on_delivery();
					}
					loadVar++;
					<?php
                    }
                    ?>
				}
				else
				{
					$('#standardShippAmt').html(result.message);
				}
			}
		});
	}
	
	function sameday_fun()
	{
		$('#captchaHidden').val(3);
		$('div#capthImg').css('display','none');
		$('div#productList').css('display','block');
		$('div#shippingList').css('display','none');
		$('div#rightProductList').css('display','none');
		$('a#editShipp').css('display','block');
		$('div#rightCashHandling').css('display','none');
		$('#rightShippingAdd').css('display','block');

		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_cart/same_day_delivery_shipping_amount'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){
				$('div#deleveryBtn').css('display','block');
				if(result.success==1)
				{	
					$('div#rightShippingRate').css('display','block');
					$('strong#shippingRate').html(result.totalShippingAmt);
					$('div#deleveryBtn').css('display','block');
					$('div#deleveryBtn').html(result.viewfile);
				}
				else
				{
					$('div#deleveryBtn').html(result.message);
				}
			}
		});
	}

	function select_shipping_add()
	{
		swal({ title:'Please Select or Add Shipping Address',});
	}

	function area_list(stateId)
	{
		areaId = 0;
		<?php
        if((!empty($_POST['SHIPPING_ADD']))&&($_POST['SHIPPING_ADD']=='Save'))
        {
        ?>
		areaId = '<?php echo htmlentities(set_value('areaId')); ?>';
		<?php
        }
        ?>
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/location_management/areaStateList'; ?>',
			data:'stateId='+ stateId +'&areaId='+areaId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			beforeSend: function() {
				$('#areaList').html('<img src="<?php echo base_url(); ?>images/frontend/sml-loader.gif">');
			},
			success:function(result){
				$('#areaList').html(result);
				$('#areaId').removeClass('form-control');
				$('#areaId').removeClass('selectpicker');
				$('#areaId').removeClass('show-menu-arrow');
				$('#areaId').css({"width":"100%","height":"36px","margin-bottom":"15px"});
				city_list($('#areaId').val());
			}
		});
	}

	function city_list(areaId)
	{
		cityId = 0;
		<?php
        if((!empty($_POST['SHIPPING_ADD']))&&($_POST['SHIPPING_ADD']=='Save'))
        {
        ?>
		cityId = '<?php echo htmlentities(set_value('cityId')); ?>';
		<?php
        }
        ?>

		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/location_management/cityAreaList'; ?>',
			data:'areaId='+areaId+'&cityId='+cityId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			beforeSend: function() {
				$('#cityList').html('<img src="<?php echo base_url(); ?>images/frontend/sml-loader.gif">');
			},
			success:function(result){
				$('#cityList').html(result);
				$('#cityId').removeClass('form-control');
				$('#cityId').removeClass('selectpicker');
				$('#cityId').removeClass('show-menu-arrow');
				$('#cityId').css({"width":"100%","height":"36px","margin-bottom":"15px"});
			}
		});
	}

	<?php
    if((!empty($_POST['SHIPPING_ADD']))&&($_POST['SHIPPING_ADD']=='Save'))
    {
    ?>
	jQuery('#modal-delivery').modal('show');
	area_list('<?php echo htmlentities(set_value('stateId')); ?>');
	city_list('<?php echo htmlentities(set_value('areaId')); ?>');
	<?php
    }
    ?>
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

	function economic_cash_on_delivery()
	{
		//$('#resultLoading').css('display','block');
		$('div#capthImg').css('display','block');
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_cart/economic_cash_handling_amount'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){
				if(result.success==1)
				{
					//$('#resultLoading').css('display','none');
					$('span#grandTotal').html(result.totalAmount);
					$('div#rightCashHandling').css('display','inline-block');
					$('strong#cashHandlingRate').html(result.cashHandlingAmt);
					$('#captchaHidden').val(1);
					$('div#payCashBtn').html('<a title="Place Order Now" class="button btn-placeorder" onclick="confirm_order();"  style="margin-top:20px; cursor:pointer;"><span><span style="font-size: 18px !important;">Confirm Order</span></span></a>');
				}
			}
		});
	}

	function standard_cash_on_delivery()
	{
		//$('#resultLoading').css('display','block');
		$('div#capthImg').css('display','block');
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_cart/standard_cash_handling_amount'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){
				if(result.success==1)
				{
					//$('#resultLoading').css('display','none');
					$('span#grandTotal').html(result.totalAmount);
					$('div#rightCashHandling').css('display','inline-block');
					$('strong#cashHandlingRate').html(result.cashHandlingAmt);
					$('#captchaHidden').val(2);
					$('div#payCashBtn').html('<a title="Place Order Now" class="button btn-placeorder" onclick="confirm_order();"  style="margin-top:20px; cursor:pointer;"><span><span style="font-size: 18px !important;">Confirm Order</span></span></a>');
				}
			}
		});
	}
	
	function same_day_cash_on_delivery()
	{
		$('div#capthImg').css('display','block');
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_cart/same_day_delivery_cash_handling_amount'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){
				if(result.success==1)
				{
					$('span#grandTotal').html(result.totalAmount);
					$('div#rightCashHandling').css('display','inline-block');
					$('strong#cashHandlingRate').html(result.cashHandlingAmt);
					$('#captchaHidden').val(3);
					$('div#payCashBtn').html('<a title="Place Order Now" class="button btn-placeorder" onclick="confirm_order();"  style="margin-top:20px; cursor:pointer;"><span><span style="font-size: 18px !important;">Confirm Order</span></span></a>');
				}
			}
		});
	}

	function confirm_order()
	{
		$("form#catpchaForm").submit();
	}

	<?php
    if((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==1))
    {
    ?>
	$("#economicRadio").attr('checked',true);
	economical_fun();
	<?php
    }
    if((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==2))
    {
    ?>
	$("#standardRadio").attr('checked',true);
	standard_fun();
	<?php
    }

    if(!empty($shippCusAddId))
    {
        if((!empty($showEconomicDel))&&($showEconomicDel))
        {
        }
		elseif((!empty($sameDayDelOpt1))&&($sameDayDelOpt1))
		{
		}
        else
        {
    ?>
	standard_fun();
	<?php
        }
    }
    ?>

	function refresh_capthca()
	{
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().'frontend/product_buy_now/refresh_capthca'; ?>',
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			success:function(result){
				$('#ajaxCaptcha').html(result);
			}
		});
	}

</script>
<style>
	.button{ height:inherit;    text-transform: inherit;    line-height: 23px;}
	.btn-placeorder-sub {margin-bottom: 20px;font-size: 18px;height: 55px !important; float: right; width: 368px; cursor: pointer;margin-right: 15px;}

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
	.wonens-slider .owl-prev > .disabled { display:none}
	.wonens-slider .owl-next > .disabled { display:none}
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
		font-size: 14px;
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

	.singletab-div>li.active>a::before, .singletab-div>li.active>a:hover::before, .singletab-div>li.active>a:focus::before{content: "";
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
	.shipping_add_box{ border:1px solid #ddd; padding:10px 20px 20px 38px; margin-right:10px; margin-bottom:10px;    cursor: pointer; height:210px;}
	.shipping_add_box:hover{ border:1px solid #fe5621;}
	.odd{     position: relative;    right: -17px; background-color:#f9f9f9;}
	.shipping_add_box .address .address-name{ font-weight:bold; padding-bottom:20px; font-size:20px;}
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
	.btn-placeorder{  margin-bottom:20px;width: 100%;  line-height: 46px !important;padding: 15px 113px 15px 115px;height: 45px !important; }
	.btn-placeorder:hover{ border:none;}
	.data-table .price{     color: #fe5621; font-weight:bold;}
	.panel-group .panel{ border-radius:0px !important;}
	.panel-heading{padding: 5px 15px; background-color:#f4f4f4;}
	.error{ margin-bottom:10px;}
	.even{ position:relative; left:16px;}
	.cart-table-customnew tr td, {padding:0;
	}
	.cart-table-customnew tr th{padding:5px;
	}

	.captcha-maindiv{display: inline-block; border: 0px none; padding-top: 12px; border-top:1px solid #ccc;
		padding-bottom:12px;
	}
	.captcha-leftdiv{padding-top:18px;
	}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/bootstrap-select.js"></script> 