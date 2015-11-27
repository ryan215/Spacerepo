<section class="main-container col1-layout">
	<div class="main container">
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
							  
							  <div class="table-responsive">
							  		 <table class="data-table product_details" id="my-orders-table">
											 <thead>
														  		<th>PRODUCT DETAILS</th>
																<th style="text-align:center;">STATUS</th>
                                                                <?php
																if(!$result['isPickup'])
																{
																?>																
																<th style="width:14%;">DELIVERY</th>
                                                                <?php
																}
																else
																{
																?>
                                                                <th style="width:14%;">Pickup</th>
                                                                <?php
																}
																?>
																<th style="width:16%;">SUBTOTAL</th>
														  </thead>
											 <tbody>
															<tr class="first odd">								  
															  <td class="image" width="22%">
															  <table>
															  <tr>
															  <td>
<a class="product-image" title="<?php echo $result['productName']; ?>" style="cursor:inherit;">
	<?php 
					if((!empty($result['productImageName']))&&(file_exists('uploads/product/thumb500_500/'.$result['productImageName'])))
					{
					?>
						<img width="75" height="75" src="<?php echo base_url().'uploads/product/thumb500_500/'.$result['productImageName']; ?>">
					<?php
					}
					elseif((!empty($result['productImageName']))&&(file_exists('uploads/product/'.$result['productImageName'])))
					{
					?>
						<img width="75" height="75" src="<?php echo base_url().'uploads/product/'.$result['productImageName']; ?>">
					<?php
					}
					else
					{
					?>
						<img src="<?php echo base_url().'img/no_image.jpg'; ?>" height="70" width="70"/>
					<?php
					}
					?>	
</a></td>
	<td style="padding:0px;">
		<h4 class="product-name">
			<?php echo $result['productName']; ?>
		</h4>
	<?php
	if(!empty($result['color']))
	{
	?>
	<span>
		Color : <a class="btn  btn-xs color_box active_color color_static" style="cursor:inherit;margin-left:0px; margin-right:0px;background-color: <?php echo $result['color']; ?>"></a>
    </span>
                      
	<?php
	}
	if(!empty($result['size']))
	{
	?>
	<p style="margin-bottom:0px;">
					  Size : <?php echo $result['size']; ?>
    </p>                 
	<?php
	}
	?>
<span>Qty: <?php echo $result['quantity']; ?></span></td>
															  </tr>
															  <tr>
															  	  <td></td>	
	</tr>
</table>
</td>
<td colspan="1">
	<ul class="timeul">
	<?php
	if(($result['orderStatusId']==6)||($result['orderActiveStatus']==0))
	{
	?>
	<li class="active" id="element1" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your order has been Declined By Retailer.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['paymentStatus']){ echo 'Payment Approved'; }else{ echo 'Payment Due'; } ?></div>">
	</li>
	<?php
	}
	elseif(!$result['isPickup'])
	{
	?>	
		<li class="active <?php if($result['orderStatusId']==1){ echo 'current'; } ?>" id="element1" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your order has been Placed.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=1){ echo date('D, dS M',$result['newOrderTime']); } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=1){ echo date("H:i A",$result['newOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['paymentStatus']){ echo 'Payment Approved'; }else{ echo 'Payment Due'; } ?></div>">
		</li>
		
		<li class="active <?php if($result['orderStatusId']==2){ echo 'current'; } ?>" id="element2" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been confirmed.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if(($result['orderStatusId']>=2)&&(!empty($result['confirmOrderTime']))){ echo date('D, dS M',$result['confirmOrderTime']); } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if(($result['orderStatusId']>=2)&&(!empty($result['confirmOrderTime']))){ echo date("H:i A",$result['confirmOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=2){ ?>Item has been confirmed by the seller<?php } ?></div>"></li>
		
		<li class="active <?php if($result['orderStatusId']==3){ echo 'current'; } ?>" id="element3" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been packed.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=3){ echo date('D, dS M',$result['readyToShippedOrderTime']); } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=3){ echo date("H:i A",$result['readyToShippedOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=3){ ?>Item has been packed<?php } ?></div>"></li>
		
		<li class="active <?php if($result['orderStatusId']==4){ echo 'current'; } ?>" id="element4" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been dispatched.<br>Item shipped. <?php echo $result['shippingBusinessName']; ?> : <?php echo $result['trackingNbr']; ?></p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=4){ echo date('D, dS M',$result['inTransitOrderTime']).'<br>'.date("H:i A",$result['inTransitOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=4){ echo 'Dropship Center : '.$result['dropCenterName']; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=4){ ?>Item has been dispatched from the seller warehouse.<?php } ?></div>"></li>
		
		<li class="active <?php if($result['orderStatusId']==5){ echo 'current'; } ?>" id="element5" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been delivered.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=5){ echo date('D, dS M',$result['deliveredOrderTime']).'<br>'.date("H:i A",$result['deliveredOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=5){ echo $result['customerCityName']; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=5){ ?>Your item has been delivered.<?php } ?></div>">
		</li>
	<?php
	}
	else
	{
	?>
		<li class="active <?php if($result['orderStatusId']==1){ echo 'current'; } ?>" id="element1" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your order has been Placed.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=1){ echo date('D, dS M',$result['newOrderTime']); } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=1){ echo date("H:i A",$result['newOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['paymentStatus']){ echo 'Payment Approved'; }else{ echo 'Payment Due on Pickup'; } ?></div>">
		</li>
		
		<li class="active <?php if($result['orderStatusId']==2){ echo 'current'; } ?>" id="element2" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been confirmed.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if(($result['orderStatusId']>=2)&&(!empty($result['confirmOrderTime']))){ echo date('D, dS M',$result['confirmOrderTime']); } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if(($result['orderStatusId']>=2)&&(!empty($result['confirmOrderTime']))){ echo date("H:i A",$result['confirmOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=2){ ?>Item has been confirmed by the seller<?php } ?></div>"></li>
		
		<li class="active <?php if($result['orderStatusId']==3){ echo 'current'; } ?>" id="element3" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been packed.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=3){ echo date('D, dS M',$result['readyToShippedOrderTime']); } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=3){ echo date("H:i A",$result['readyToShippedOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=3){ echo 'Your order  is ready for pickup at '.$result['pickupName']; } ?></div>"></li>
		
		<li class="active <?php if($result['orderStatusId']==5){ echo 'current'; } ?>" id="element5" data-placement="bottom" data-html="true" data-content="<p style='color:#6bad50; font-size:11px;'>Your item has been collected.</p><div class='col-sm-4 padding_left_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=5){ echo date('D, dS M',$result['deliveredOrderTime']).'<br>'.date("H:i A",$result['deliveredOrderTime']).'(WAT)'; } ?></div><div class='col-sm-4' style='font-size:10px; border-left:1px solid #ddd; border-right:1px solid #ddd;'><?php if($result['orderStatusId']>=5){ echo $result['customerCityName']; } ?></div><div class='col-sm-4 padding_right_zero' style='font-size:10px;'><?php if($result['orderStatusId']>=5){ echo 'order has been collected'; } ?></div>">
		</li>
    <?php
	}
	?>
	</ul>
</td>
<td>
	<h5>
		<?php
		$orderDate = date('Y-m-d',$result['orderDate']+strtotime('+ '.$result['eta'].' days'));
		$message   = '';
		if(($result['orderStatusId']==6)||($result['orderActiveStatus']==0))
		{
			echo 'Your order has been Declined By Retailer.';
		}
		else
		{
		if(!$result['isPickup'])
		{
			if($result['orderStatusId']<2)
			{
				echo 'Your order will be processed shortly';
			}
			elseif($result['orderStatusId']<5)
			{
				echo 'ETA Delivery date is '.date('d F Y',strtotime($orderDate));
				$message   = 'Item will be shipped by '.date('D, dS M',strtotime($result['orderDate'])).'. Will be delivered by '.date('D, dS M',strtotime($orderDate));
			}
			else
			{
			if(strtotime($result['deliveredDate'])<time())
			{
				echo ' By ';
			}
			else
			{
				echo ' On ';
			}
			echo date('d F Y',strtotime($result['deliveredDate']));
			if(date('d-m-Y',strtotime($result['deliveredDate']))!=date('d-m-Y',strtotime($orderDate)))
			{
			?><br />
			<strike>By <?php echo date('d F Y',strtotime($orderDate)); ?></strike>
			<?php
			}
			$message   = 'Your Item has been Delivered';
		}
		}
		else
		{
			if($result['orderStatusId']<2)
			{
				echo 'Your order will be processed shortly';
			}
			elseif($result['orderStatusId']<5)
			{
				echo 'ETA Pickup date is '.date('d F Y',strtotime($orderDate));
			}
			else
			{
				if(strtotime($result['deliveredDate'])<time())
				{
					echo ' By ';
				}
				else
				{
					echo ' On ';
				}
				echo date('d F Y',strtotime($result['deliveredDate']));
				if(date('d-m-Y',strtotime($result['deliveredDate']))!=date('d-m-Y',strtotime($orderDate)))
				{
				?><br />
				<strike>By <?php echo date('d F Y',strtotime($orderDate)); ?></strike>
				<?php
				}
				$message = 'Your Item has been Pickuped';
			}
		}
		if(!$result['isPickup'])
		{
			if($result['orderStatusId']<2)
			{
			}
			else
			{
		?><span class="active1" id="deliverDate" data-toggle="popover6" data-placement="bottom" data-html="true" data-content="<?php echo $message; ?>" style=""> <i class="fa fa-question-circle"></i>
		</span>
        <?php
			}
		}
		}
		?>
	</h5>
</td>
	<td>
		<h5>&#8358;<?php echo number_format($result['totalFullSum'],2); ?></h5>
	</td>
															</tr>
															
															</tbody>
									 </table>
							   </div>
                              <div class="table-responsive">
							  		 <table class="data-table order_details">																												
															<tr>
																 <td  width="50%" style="border-right:2px dotted #E3E3E3;">
																 	  <table class="left_details"><tr><td colspan="2"><h2>Order Details</h2></td></tr><tr><td><label>Order Id :</label>	</td>
<td><h5><?php echo $result['customOrderId']; ?></h5> </td></tr><tr><td><label>Seller :</label></td><td> <h5>
<?php echo $result['retailerBusinessName']; ?>
</h5></td></tr><tr><td><label>Order Date :</label></td><td><h5><?php echo $result['orderDate'].'(WAT)'; ?></h5></td></tr><tr><td>
<?php if($result['paymentStatus']){ echo '<label>Amount Paid :</label>'; }else{ echo '<label>Amount Due :</label>'; } ?>
</td><td><h5><span style="color:#48C7AC; font-size:18px;"><i class="fa fa-check"></i></span> <span style="font-size:18px;">&#x20A6;<?php echo number_format($result['totalFullSum'],2); ?></span></h5></td></tr></table>
																 </td>
																 <td>
<table class="right_details"><tr><td colspan="2"><h2>Customer Details</h2></td></tr><tr><td><h5><i class="fa fa-user"></i> &nbsp; <span><?php echo $result['customerFirstName'].' '.$result['customerLastName']; ?></span></h5></tr><tr><td><h5><i class="fa fa-phone"></i>&nbsp;<span> <?php echo $result['customerPhoneNo']; ?></span></h5></td></tr>
<?php 
	if(!$result['isPickup'])
			{ 
			
			}
	else{		
	?>
	<tr>
    	<td colspan="2">
        	<h2>Pickup Details</h2>
        </td>
	</tr>
	<?php
	}
	?>
<tr><td>
<h5><i class="fa fa-map-marker"></i> &nbsp;<span> 
<?php 
			if(!$result['isPickup'])
			{
				echo ucfirst($result['customerAddress1']).',<br>'.ucfirst($result['customerCityName']).','.ucfirst($result['customerAreaName']).','.ucfirst($result['customerStateName']).','.ucfirst($result['customerCountryName']);
			}
			else
			{
				echo $result['pickupAddress1'];
				if($result['pickupCity'])
				{
					echo ','.$result['pickupCity'];
				}
				if($result['pickupArea'])
				{
					echo ','.$result['pickupArea'];
				}
				if($result['pickupState'])
				{
					echo ','.$result['pickupState'];
				}
			}
			?>
            </span></h5></td></tr>
            <?php 
	if(!$result['isPickup'])
			{ 
			
			}
	else{		
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
            <tr><td>
<?php
if($result['orderStatusId']<2)
{
?>
<div class="complete_order_sec"><h5><span><i class="fa fa-truck"></i></span>Your order will be processed shortly</h5></div>
<?php
}
elseif($result['orderStatusId']<5)
{
?>
<div class="complete_order_sec"><h5><span><i class="fa fa-truck"></i></span>
<?php
	$orderDate = date('Y-m-d',$result['orderDate']+strtotime('+ '.$result['eta'].' days'));
	echo 'Your complete order will be delivered by '.date('d F Y',strtotime($orderDate)).'(WAT)';
?>
</h5></div>
<?php
}
?>
	</td></tr></table>																 </td>	
															</tr>
									</table>
							   </div>
							   
							   		
					    </div>
				  </div>
		    </div>
	  </div>
</section>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.active').popover();
	jQuery('.active').mouseenter(function(){
    	jQuery(this).popover('show');
		jQuery('.active').not(this).popover('hide');
    });
	
	jQuery(function(){ jQuery("#element<?php echo $result['orderStatusId']; ?>").popover('show');});

	jQuery('.active1').popover();
	jQuery('.active1').mouseenter(function(){
    	jQuery(this).popover('show');
		jQuery('.active1').not(this).popover('hide');
    });
});
</script>
<style>
.current {
  border: 8px double #7CC472;
  border-radius: 20px !Important;
  background: #fff !Important;
  position: relative !important;
  top: -9px !important;
}
.popover { max-width:310px !important;}
</style>
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
</style>