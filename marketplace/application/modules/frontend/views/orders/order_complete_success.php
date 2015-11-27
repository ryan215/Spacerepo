<section class="main-container col1-layout">
	<div class="main container">
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
								<strong>Order Complete</strong>
							</li>
						</ul>
					</div>
        		</div>
        	</div>
			
			<!--breadcrumb-->
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="data-table order_details" style="margin-bottom:10px;">																												
						<tr>
							<td  width="50%" style="border-right:2px dotted #E3E3E3;">
								<table class="left_details">
                                	<tr>
										<td><h2>Thank you for your order!</h2></td>
									</tr>
                                    <tr>
										<td>
											<h5 style="font-family:latoregular !important;">
												<?php 
												if($result['isPickup'])
												{													
													echo "Your order has been placed and is being processed. When the item(s) are at ".$result['pickupName']." , you will receive an email with the details. You can track this order through My orders page.";										 
												 
												}
												else
												{
													echo "Your order has been placed and is being processed. When the item(s) are shipped, you will receive an email with the details. You can track this order through";
												}
												?>
												<a href="<?php echo base_url().'frontend/order'; ?>">My orders</a> page.
											</h5>
										</td>
									</tr>
                                    <tr>
										<td>
											<h5>
												<span style="color:#48C7AC; font-size:18px;"><i class="fa fa-check"></i></span>
												<span style="font-size:18px;">
													<?php echo '&#x20A6;'.number_format($result['totalAmount'],2); ?>
												</span>
											</h5>
										</td>
									</tr>
                                </table>
							</td>
							<td>
								<table class="right_details">
									<tr>
										<td colspan="2">
											<h2>Customer Details</h2>
										</td>
									</tr>
									<tr>
										<td>
											<h5><i class="fa fa-user"></i>&nbsp;<?php echo $result['customerFirstName'].' '.$result['customerLastName']; ?></h5>
										</td>
									</tr>
									<tr>
										<td style="padding-bottom:10px !important;">
											<h5><i class="fa fa-phone"></i>&nbsp;<?php echo $result['customerPhoneNo']; ?></h5>
										</td>
									</tr>
									<?php 
									if($result['isPickup'])
									{ 		
									?>
									<tr>
										<td colspan="2"><h2>Pickup Details</h2></td>
									</tr>
									<?php
									}
									?>
									<tr>	
										<td>
											<h5><i class="fa fa-map-marker"></i>&nbsp; 
												<?php 
												if(!$result['isPickup'])
												{
													echo ucfirst($result['customerAddress1']).',<br>'.ucfirst($result['customerCityName']).', '.ucfirst($result['customerAreaName']).', '.ucfirst($result['customerStateName']).', '.ucfirst($result['customerCountryName']);
												}
												else
												{
													echo $result['pickupAddress1'];
													if($result['pickupCity'])
													{
														echo ', '.$result['pickupCity'];
													}
													if($result['pickupArea'])
													{
														echo ', '.$result['pickupArea'];
													}
													if($result['pickupState'])
													{
														echo ', '.$result['pickupState'];
													}
												}
												?>
											</h5>
										</td>
									</tr>
									<?php 
									if($result['isPickup'])
									{
									?>
									<tr>
										<td>
											<h5><i class="fa fa-clock-o"></i>&nbsp;<?php echo $result['pickupBusnsDay'].','.$result['pickupBusnsHrs']; ?></h5>
										</td>
									</tr>
									<tr>
										<td>
											<h5><i class="fa fa-phone"></i>&nbsp;<?php echo $result['pickupPhone'].','.$result['pickupSecPhone']; ?></h5>
										</td>
									</tr>
									<?php	
									}
									?>
									<tr>
										<td>
											<div class="complete_order_sec">
												<h5>
													<span><i class="fa fa-truck"></i></span>
													Your order will be processed shortly
												</h5>
											</div>
										</td>
									</tr>
								</table>
							</td>	
						</tr>
                    </table>
				</div>
				
				<?php
				if(!empty($result['orderList']))
				{
					foreach($result['orderList'] as $customID=>$customOrder)
					{
					?>
					<div class="table-responsive">
						<table class="data-table">
							<thead>
								<th colspan="7">
									<a class="btn btn-medium btn-orderid" style="cursor:inherit;">
										<?php echo $customOrder['customOrderId']; ?>
									</a>
								</th>
							</thead>
							<tbody>
							<?php
							if(!empty($customOrder['productList']))
							{
								foreach($customOrder['productList'] as $row)
								{
							?>
						<tr class="first odd">								  
							<td class="image" width="10%">
								<a class="product-image" title="<?php echo $row['productName']; ?>">
									<?php 
									if((!empty($row['productImageName']))&&(file_exists('uploads/product/thumb500_500/'.$row['productImageName'])))
									{
									?>
										<img width="75" height="75" src="<?php echo base_url().'uploads/product/thumb500_500/'.$row['productImageName']; ?>">
									<?php
									}
									elseif((!empty($row['productImageName']))&&(file_exists('uploads/product/'.$row['productImageName'])))
									{
									?>
										<img width="75" height="75" src="<?php echo base_url().'uploads/product/'.$row['productImageName']; ?>">
									<?php
									}
									else
									{
									?>
										<img src="<?php echo base_url().'img/no_image.jpg'; ?>" height="70" width="70"/>
									<?php
									}
									?>	
								</a>
							</td>
							<td width="40%">
								<h4 class="product-name" style="margin-top:0px;">
										<?php echo $row['productName']; ?>
								</h4>
								<?php
								if(!empty($row['colorCode']))
								{
								?>
								<span>
									  Color :
									   <a class="btn  btn-xs color_box active_color color_static" style="cursor:inherit;margin-left:0px; margin-top:0px;margin-right:0px;background-color:<?php echo $row['colorCode']; ?>" href="javascript:void(0);"></a>
								</span>&nbsp;
								<?php
								}
								?>
								<?php
								if(!empty($row['size']))
								{
								?>
								<span>
									 Size :
									   <?php echo strtoupper($row['size']); ?>
								</span> &nbsp;      
								<?php
								}
								?>
								<span>Qty: <?php echo $row['quantity']; ?></span>
							</td>
							<td>
								<span>
									&#x20A6;<?php echo number_format(($row['totalProductAmount']),2); ?>
								</span>
							</td>
							<?php
							if($result['isPickup'])
							{
							?>
							 <td>Proccessing Fee
								<span>
									&#x20A6;<?php echo number_format($row['pickupProcessingAmount'],2); ?>
								</span>
							</td>
							<?php
							}
							?>  
							<td>
								<h5 style="margin-top:0px;">
									Your Order Will Be Processed Shortly
								</h5>
							</td>
							<td class="a-center last">
								<span class="nobr">
									<a href="<?php echo base_url().'frontend/order/track_order/'.id_encrypt($row['orderDetailId']); ?>" class="btn btn-track pull-right">
										<i class="fa fa-map-marker"></i> 
										Track
									</a>&nbsp;
								</span>
							</td>
						</tr>
						<?php	
							}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="3"><span style="font-size:10px;">Seller:</span> <strong>
									<?php echo $customOrder['organizationName']; ?>
									</strong>
								</td>
							<td colspan="2"><span style="font-size:10px;">
							<?php
							if($result['isPickup'])
							{
							}
							else
							{
							?>
								Shipping Fee: </span> 
									<strong>
									<?php
									if($customOrder['totalCustomShippingAmount'])
									{
										echo '&#x20A6;'.number_format($customOrder['totalCustomShippingAmount'],2);
									}
									else
									{
										echo 'Free';
									}
									?>
									
									</strong>
								<?php
								if($customOrder['totalCustomCashHandlingAmount'])
								{
								?>
									Cash Handling Fee: </span> <strong>
									<?php echo '&#x20A6;'.number_format($customOrder['totalCustomCashHandlingAmount'],2); ?></strong>
								<?php
								}
							}
							?>
							</td>
							<td style="  text-align: right;"><Span style="font-size:10px;">Order Total:</Span> 
							<strong><?php echo '&#x20A6;'.number_format($customOrder['totalCustomAmount'],2); ?></strong></td>
						</tr>
					</tfoot>
				</table>
				
							
						<br>
					</div>
				<?php
					}
				}
				?>						 
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
</style>