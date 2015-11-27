<aside class="profile-nav col-lg-3" style="padding-bottom:20px;">
	<section class="panel" style="margin-bottom:0px;">
		<div class="user-heading round" style="margin-left:10px;">
			<?php
			if((!empty($result['productImageName']))&&(file_exists('uploads/product/thumb500_500/'.$result['productImageName'])))
			{
			?>
				<a class="example-image-link" data-lightbox="example-1" href="javascript:void(0);" style="border-r">
					<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$result['productImageName']; ?>" height="70" width="70" />
				</a>
			<?php
			}
			elseif((!empty($result['productImageName']))&&(file_exists('uploads/product/'.$result['productImageName'])))
			{
			?>
				<a class="example-image-link" data-lightbox="example-1" href="javascript:void(0);" style="border-r">
					<img src="<?php echo base_url().'uploads/product/'.$result['productImageName']; ?>" height="70" width="70" />
				</a>
			<?php
			}
			else
			{
			?>
				<a class="example-image-link" data-lightbox="example-1" href="javascript:void(0);" style="border-r">
					<img src="<?php echo base_url().'img/no_image.jpg'; ?>" height="70" width="70"/>
				</a>
			<?php
			}
			?>
			<h1><?php echo $result['productName']; ?></h1>
		</div>
	</section>
</aside>

<aside class="profile-nav col-lg-9">
	<div class="col-sm-12 padding_zero" style="padding-left: 5px;">
		<table class="table table-invoice table-custom" style="">
			<thead>
				<tr>
					<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
						Product Details 
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="35%">Name: </td>
					<td><?php echo $result['productName']; ?></td>
				</tr>
				<?php
				if($this->session->userdata('userType')!='retailer')
				{
				?>
				<tr>
					<td width="35%">Total Amounts: </td>
					<td>&#x20A6;<?php echo number_format($result['totalAmount'],2); ?></td>
				</tr>
				<?php
				}
				?>											 
				<tr>
					<td width="35%">Quantity: </td>
					<td><?php echo $result['productQuantity']; ?></td>
				</tr>	
				<?php
				if(!empty($result['color']))
				{
				?>
                
				<tr>
					<td width="35%">Color: </td>
					<td><a class="btn btn-xs color_box active_color color_static" style="margin-left: 0px; margin-right: 0px;background-color:<?php echo $result['color']; ?>" href="javascript:void(0);"/>
</td>
				</tr>
				<?php
				}
				if(!empty($result['size']))
				{
				?>
				<tr>
					<td width="35%">Size: </td>
					<td><?php echo $result['size']; ?></td>
				</tr>
				<?php
				}
				if($this->session->userdata('userType')!='retailer')
				{
				?>
                <tr>
					<td width="35%">Order Type: </td>
					<td>
						<?php 
						if($result['isPickup'])
						{
							echo 'Pick Up';
						}
						else
						{
							echo 'Delivery';
						}
						?>
                    </td>
				</tr>
				<tr>
					<td width="35%">Order Status: </td>
					<td>
						<?php 
						if($result['isPickup'])
						{
							if($result['orderStatusId']==1)
							{
								echo 'New Pickup Order';
							}
							elseif($result['orderStatusId']==2)
							{
								echo 'Confirm To Pickup Order';
							}
							elseif($result['orderStatusId']==3)
							{
								echo 'Ready To Be Pickup';
							}
							elseif($result['orderStatusId']==5)
							{
								echo 'Order Picked Up';
							}
						}
						else
						{
							if($result['orderStatusId']==1)
							{
								echo 'New Order';
							}
							elseif($result['orderStatusId']==2)
							{
								echo 'Confirm Order';
							}
							elseif($result['orderStatusId']==3)
							{
								echo 'Ready To Shipped Order';
							}
							elseif($result['orderStatusId']==4)
							{
								echo 'Shipped In Transit Order';
							}
							elseif($result['orderStatusId']==5)
							{
								echo 'Delivered Order';
							}
						}
						?>
                    </td>
				</tr>
				<tr>
					<td width="35%">Payment Mode: </td>
					<td>
						<?php 
						if($result['isPickup'])
						{							
							if($result['paymentStatus'])
							{
								echo 'Pay Online';
							}
							else
							{
								echo 'Pay On Pickup';
							}						
						}
						else
						{
							if($result['paymentStatus'])
							{
								echo 'Pay Online';
							}
							else
							{
								echo 'Cash On Delivery';
							}
						}
						?>
                    </td>
				</tr> 
				<?php
				}
				if($result['retailerPrice'])
				{
				?>        
				<tr>
					<td width="35%">Retailer Pay Back Price: </td>
                    <td>&#x20A6;<?php echo number_format(($result['retailerPrice']*$result['productQuantity']),2); ?></td>
				</tr>
                <?php
				}
				if($this->session->userdata('userType')!='retailer')
				{
				?>
				<tr>
					<td width="35%">Product Price: </td>
                    <td>&#x20A6;<?php echo number_format(($result['chargedAmount']*$result['productQuantity']),2); ?></td>
				</tr>                      
				<?php
					if($result['isPickup'])
					{
					}
					else
					{
					?>
					<tr>
						<td width="35%">Shipping Rate: </td>
						<td>
							<?php
							if($result['isEconomicDelivery'])
							{
								if($result['isCalculateShipp'])
								{
									if($result['shippingRate'])
									{
										if(!empty($result['productWeight']))
										{
											if($result['productWeight']>10)
											{
												echo '&#x20A6;'.number_format(($result['shippingRate']*$result['productWeight']),2);	
											}
											else
											{	
												echo '&#x20A6;'.number_format($result['shippingRate'],2); 
											}	
										}												
									}
								}
								else
								{
									echo 'Free Shipping';
								}
							}
							else
							{
								if($result['freeShipPrdId'])
								{
									echo 'Free Shipping';
								}
								elseif($result['freeShipCatId'])
								{
									echo 'Free Shipping';
								}
								elseif($result['genuineShippFee'])
								{
									echo '&#x20A6;'.number_format(($result['shippingRate']*$result['productQuantity']),2); 
								}
							}
							?>
	
						</td>
					</tr>	                               
					<?php
					}
					if($result['paymentStatus'])
					{}
					else
					{
						if($result['isPickup'])
						{
						}
						else
						{
					?>
					<tr>
						<td width="35%">Cash Handling Fee: </td>
						<td>
							<?php
							if($result['isEconomicDelivery'])
							{
								echo '&#x20A6;'.number_format($result['cashHandlingPrice'],2);
							}
							else
							{
								if($result['orderId']>114)
								{							
									echo '&#x20A6;'.number_format($result['cashHandlingPrice'],2);
								}
								else
								{
									$calTtlAmt = ($result['chargedAmount']*$result['productQuantity'])+($result['shippingRate']*$result['productQuantity']);
									$handlingPrice = ($calTtlAmt*$this->config->item('space_point_comission'))/100;
									echo '&#x20A6;'.number_format($handlingPrice,2);
								}
							}
							?>						
						</td>
					</tr>	                               
					<?php
						}
					}
				}
				?>
			</tbody>
		</table>
	</div>
</aside>
<div class="clearfix"></div>

<aside class="profile-info col-lg-12">								   
	<section class="panel">
		<div class="panel-body bio-graph-info" style="padding: 4px;">
			<div class="col-sm-12 padding_zero">
				<table class="table table-invoice table-custom" style="margin-top:15px;">
					<thead>
						<tr>
							<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Dropship Center Details
							</th>
						</tr>
					</thead>                    
					<tbody>
						<tr>
							<td width="35%">Name: </td>
							<td><?php echo $result['dropShipCenterName']; ?></td>
						</tr>											 
						<tr>
							<td width="35%">Address: </td>
							<td><?php echo $result['dropShipCenterAddress']; ?></td>
						</tr>											 
					</tbody>
				</table>
			</div>
			<?php 
			if($this->session->userdata('userType')!='retailer')
			{
			?>			
			<div class="col-sm-12 padding_zero">
				<table class="table table-invoice table-custom" style="margin-top:15px;">
					<thead>
						<tr>
							<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Retailer Details
							</th>
						</tr>
					</thead>                    
					<tbody>
						<tr>
							<td width="35%">Bussiness Name: </td>
							<td><?php echo $result['retailerOrganizationName']; ?></td>
						</tr>											 
						<tr>
							<td width="35%">Email: </td>
							<td><?php echo $result['retailerEmail']; ?></td>
						</tr>											 
						<tr>
							<td width="35%">First Name: </td>
							<td><?php echo $result['retailerFirstName']; ?></td>
						</tr>											 
						<tr>
							<td width="35%">Middle Name: </td>
							<td>
								<?php echo $result['retailerMiddle']; ?>
							</td>
						</tr> 
						<tr>
							<td width="35%">Last Name: </td>
							<td>
								<?php echo $result['retailerLastName']; ?>
							</td>
						</tr>  
						<tr>
							<td width="35%">Bussiness Phone No: </td>
							<td>
								<?php echo $result['retailerBusinessPhone']; ?>
							</td>
						</tr>
						<tr>
							<td width="35%">User Name: </td>
							<td>
								<?php echo $result['retailerUserName']; ?>
							</td>
						</tr> 
						<tr>
							<td width="35%">Address1: </td>
							<td>
								<?php echo $result['retailerAddressLine1']; ?>
							</td>
						</tr> 
						<tr>
							<td width="35%">Country Name: </td>
							<td>
								<?php echo $result['retailerCountryName']; ?>
							</td>
						</tr>  
						<tr>
							<td width="35%">State Name: </td>
							<td>
								<?php echo $result['retailerStateName']; ?>
							</td>
						</tr> 
                        <tr>
							<td width="35%">Area Name: </td>
							<td>
								<?php echo $result['retailerAreaName']; ?>
							</td>
						</tr> 
						<tr>
							<td width="35%">City Name: </td>
							<td>
								<?php echo $result['retailerCityName']; ?>
							</td>
						</tr>            						
					</tbody>
				</table>
			</div>
			<div class="col-sm-12 padding_zero">
				<table class="table table-invoice table-custom" style="margin-top:15px;">
					<thead>
						<tr>
							<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Customer details 
							</th>
						</tr>
					</thead>                    
					<tbody>
 						<tr>
							<td width="35%">First Name: </td>
						    <td><?php echo $result['customerFirstName']; ?></td>
                        </tr>
						<tr>
							<td width="35%">Last Name: </td>
						    <td><?php echo $result['customerLastName']; ?></td>
                        </tr>
                        <tr>
                        	<td width="35%">Email: </td>
						    <td><?php echo $result['customerEmail']; ?></td>
                        </tr> 
						<tr>
                        	<td width="35%">Phone Number: </td>
						    <td><?php echo $result['customerPhone']; ?></td>
                        </tr>						
					</tbody>
				</table>
			</div>
				<?php
				if($result['isPickup'])
				{
				?>
				<div class="col-sm-12 padding_zero">
					<table class="table table-invoice table-custom" style="margin-top:15px;">
						<thead>
							<tr>
								<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Pick Up details 
								</th>
							</tr>
						</thead>                    
						<tbody>
 							<tr>
								<td width="35%">Name: </td>
							    <td><?php echo $result['pickupName']; ?></td>
                    	    </tr>
						<tr>
							<td width="35%">Phone Number: </td>
						    <td><?php echo $result['pickupPhone']; ?></td>
                        </tr>
                        <tr>
                        	<td width="35%">State Name: </td>
						    <td><?php echo $result['pickupStateName']; ?></td>
                        </tr> 
						<tr>
                        	<td width="35%">Address: </td>
						    <td><?php echo $result['pickupAddressLine']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">Bussiness Hour: </td>
						    <td><?php echo $result['pickupBusHours']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">Bussiness Days: </td>
						    <td><?php echo $result['pickupBusDays']; ?></td>
                        </tr>						
					</tbody>
				</table>
				</div>
				<?php
				}
				else
				{
				?>
			<div class="col-sm-12 padding_zero">
				<table class="table table-invoice table-custom" style="margin-top:15px;">
					<thead>
						<tr>
							<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Shipping vendor details 
							</th>
						</tr>
					</thead>
                    <tbody>
 						<tr>
							<td width="35%">Business Name: </td>
						    <td><?php echo $result['vendorBusinessName']; ?></td>
						</tr>
						<tr>
							<td width="35%">First Name: </td>
						    <td><?php echo $result['vendorFirstName']; ?></td>
						</tr>
						<tr>
							<td width="35%">Last Name: </td>
							<td><?php echo $result['vendorLastName']; ?></td>
						</tr>
						<tr>
							<td width="35%">Email: </td>
							<td><?php echo $result['vendorEmail']; ?></td>
						</tr>
						<tr>
							<td width="35%">Phone No: </td>
							<td><?php echo $result['vendorBusinessPhone']; ?></td>
						</tr>
						<tr>
							<td width="35%">Street: </td>
							<td><?php echo $result['vendorAddressLine1']; ?></td>
						</tr> 
						<tr>
							<td width="35%">Country Name: </td>
							<td><?php echo $result['vendorCountryName']; ?></td>
						</tr>
						<tr>
							<td width="35%">State Name: </td>
							<td><?php echo $result['vendorStateName']; ?></td>
						</tr>
                        <tr>
							<td width="35%">Area Name: </td>
							<td><?php echo $result['vendorAreaName']; ?></td>
						</tr> 
						<tr>
							<td width="35%">City Name: </td>
							<td><?php echo $result['vendorCityName']; ?></td>
						</tr>
						 						
                    </tbody>
				</table>
			</div>
			<?php
				}
			
				if($result['isPickup'])
				{
				}
				else
				{
				?>
			<div class="col-sm-12 padding_zero">
				<table class="table table-invoice table-custom" style="margin-top:15px;">
					<thead>
						<tr>
							<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Billing details 
							</th>
						</tr>
					</thead>                    
					<tbody>
                    	<tr>
                        	<td width="35%">First Name: </td>
							<td><?php echo $result['customerBillFirstName']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">Last Name: </td>
							<td><?php echo $result['customerBillLastName']; ?></td>
                        </tr>
						<tr>
							<td width="35%">Phone No.: </td>
							<td><?php echo $result['customerBillPhone']; ?></td>
						</tr>
						<tr>
                        	<td width="35%">Country Name: </td>
							<td><?php echo $result['billingCountry']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">State Name: </td>
							<td><?php echo $result['billingState']; ?></td>
                        </tr>
                        <tr>
                        	<td width="35%">Area Name: </td>
							<td><?php echo $result['shippingArea']; ?></td>
                        </tr>
						<tr>
							<td width="35%">City Name: </td>
							<td><?php echo $result['billingCity']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">Address1: </td>
							<td><?php echo $result['billingAddressLine1']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">Address2: </td>
							<td><?php echo $result['billingAddressLine2']; ?></td>
                        </tr>						
					</tbody>
				</table>
			</div>
				<?php
				}
				if($result['isPickup'])
				{
				}
				else
				{
				?>
			<div class="col-sm-12 padding_zero">
				<table class="table table-invoice table-custom" style="margin-top:15px;">
					<thead>
						<tr>
							<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
								Shipping details 
							</th>
						</tr>
					</thead>                    
					<tbody>
						<tr>
                        	<td width="35%">First Name: </td>
							<td><?php echo $result['customerShippFirstName']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">Last Name: </td>
							<td><?php echo $result['customerShippLastName']; ?></td>
                        </tr>
						<tr>
							<td width="35%">Phone No.: </td>
							<td><?php echo $result['customerShippPhone']; ?></td>
						</tr>
                        <tr>
                        	<td width="35%">Country Name: </td>
							<td><?php echo $result['shippingCountry']; ?></td>
                        </tr>
						<tr>
                        	<td width="35%">State Name: </td>
							<td><?php echo $result['shippingState']; ?></td>
                        </tr>
                        <tr>
                        	<td width="35%">Area Name: </td>
							<td><?php echo $result['shippingArea']; ?></td>
                        </tr>                        
						<tr>
							<td width="35%">City Name: </td>
							<td><?php echo $result['shippingCity']; ?></td>
						</tr>
						<tr>
							<td width="35%">Address1: </td>
							<td><?php echo $result['shippingAddressLine1']; ?></td>
						</tr>
						<tr>
							<td width="35%">Address2: </td>
							<td><?php echo $result['shippingAddressLine2']; ?></td>
						</tr>
 					</tbody>
                </table>
			</div>
			<?php
				}
			}
			?>			
		</div>
	</section>
</aside>
<style>
.color_box {margin-right:5px;  border: 2px #eee solid; padding:15px;}
.color_static {   padding: 8px;margin-left: 5px; }
</style>