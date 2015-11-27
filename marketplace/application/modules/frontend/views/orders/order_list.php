<section class="main-container col1-layout order-listmaindiv">
	<div class="main container shadow-main-div myorder-main-div">
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
								<strong>Order Track</strong>
							</li>
						</ul>
					</div>
        		</div>
        	</div>
			
			<div class="col-sm-12 padding_left_zero">
				<div class="my-account">
					<div class="page-title">
						<h2>My Orders</h2>
					</div>
					<ul class="nav nav-tabs" id="myTab">
						<li class="active">
							<a href="<?php echo base_url().'frontend/order'; ?>">
								Recent Orders
							</a>
						</li>
						<li>
							<a href="<?php echo base_url().'frontend/order/past_order'; ?>">
								Past Orders
							</a>
						</li>       
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade in active">
							<div class="dashboard">            
								<div class="recent-orders">
<?php
if(!empty($result['orderList']))
{
	foreach($result['orderList'] as $customID=>$customOrder)
	{
	?>
	<div class="table-responsive">
		<table class="data-table order-tables-box">
			<thead>
				<th colspan="5">
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
				<a class="product-image" title="<?php echo $row['productName']; ?>" style="cursor:inherit;">
					<?php 
					if((!empty($row['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$row['imageName'])))
					{
					?>
						<img width="75" height="75" src="<?php echo base_url().'uploads/product/thumb500_500/'.$row['imageName']; ?>">
					<?php
					}
					elseif((!empty($row['imageName']))&&(file_exists('uploads/product/'.$row['imageName'])))
					{
					?>
						<img width="75" height="75" src="<?php echo base_url().'uploads/product/'.$row['imageName']; ?>">
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
			<td width="30%">
				<h4 class="product-name" style="margin-top:0px;">
						<?php echo $row['productName']; ?>
				</h4>
				<?php
				if(!empty($row['colorCode']))
				{
				?>
					<span>Color : <a class="btn  btn-xs color_box active_color color_static" style="cursor:inherit;margin-left:0px;margin-top:0px; margin-right:0px;background-color:  <?php echo $row['colorCode']; ?>"></a></span>
					
				<?php
				}
				if(!empty($row['size']))
				{
				?>
					Size : <?php echo $row['size']; ?>
				<?php
				}
				?>
				<span>Qty: <?php echo $row['quantity']; ?></span>
			</td>
			<td  width="22%">
				<span>
					&#x20A6;<?php echo number_format($row['totalProductAmount'],2); ?>
				</span><br />
				<?php
				if($row['isPickup'])
				{
				?>
            	Processing Fee
				<span>
					&#x20A6;<?php echo number_format($row['pickupProcessingAmount'],2); ?>
				</span>
				<?php
				}
				?>
             </td>
			<td>
				<h5 style="margin-top:0px;">
					<?php
					if($row['orderStatusId']<2)
					{
						echo 'Your order will be processed shortly';
					}
					elseif($row['orderStatusId']<5)
					{
						$orderDate = date('Y-m-d',$row['orderDate']+strtotime('+ '.$row['eta'].' days'));
						echo 'Your complete order will be delivered by '.date('d F Y',strtotime($orderDate)).'(WAT)';
					}
					else
					{
						if((!empty($row['deliveredDate']))&&($row['deliveredDate']!='0000-00-00 00:00:00'))
						{
							echo 'Delivered';
							if(strtotime($row['deliveredDate'])<time())
							{
								echo ' By ';
							}
							else
							{
								echo ' On ';
							}
							echo date('d F Y',strtotime($row['deliveredDate'])).'(WAT)';					
						}
					}
					?>
					</h5>
				<?php
				if($row['trackingNbr'])
				{
					$row['shippingBusinessName'] = '';
					echo 'Item Shipped. '.$row['shippingBusinessName'].' : '.$row['trackingNbr'];
				}
				?>
			</td>
			<td class="a-center last">
				<span class="nobr">
					<a href="<?php echo base_url().'frontend/order/track_order/'.id_encrypt($row['orderDetailId']); ?>" class="btn btn-track pull-right">
						<i class="fa fa-map-marker"></i> 
						Track
					</a> &nbsp;
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
			<td colspan="2"><span style="font-size:11px;">Seller:</span> <strong>
				<?php echo $customOrder['organizationName']; ?>
			</strong></td>
            <td colspan="1"><span style="font-size:11px;">
			Date: </span> <strong><?php echo $customOrder['createDt'].'(WAT)'; ?></strong>
            </td>
            <td>
            <?php
			if($customOrder['totalCustomShippingAmount'])
			{
			?>
            Shipping Fee: </span> <strong>&#x20A6;<?php echo number_format($customOrder['totalCustomShippingAmount'],2); ?></strong>
	        <?php
			}
			
			if($customOrder['totalCustomCashHandlingAmount'])
			{
			?>
            Cash Handling Fee: </span> <strong>&#x20A6;<?php echo number_format($customOrder['totalCustomCashHandlingAmount'],2); ?></strong>
	        <?php
			}
			?>
            </td>
			<td  width="18%" style="  text-align: right;"><Span style="font-size:11px;">Order Total:</Span> 
			<strong>&#x20A6;<?php echo number_format($customOrder['totalCustomAmount'],2); ?></strong></td>
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
