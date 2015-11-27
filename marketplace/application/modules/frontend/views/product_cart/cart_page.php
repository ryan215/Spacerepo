<section class="main-container col1-layout">
	<div class="main container shadow-main-div">
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
							<li class="category4" itemscope="" itemtype=""><strong>Cart</strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
					
		    <div class="cart">
		    	<div class="page-title"><h2>Shopping Cart</h2></div>
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
				                    <th colspan="1" class="a-center"><span class="nobr">Price</span></th>
				                    <th class="a-center" rowspan="1" width="15%">Qty</th>
				                    <th colspan="1" class="a-center">Subtotal</th>
				                    <th class="a-center" rowspan="1">&nbsp;</th>
				                    <th rowspan="1">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$productId = 0;
								$totalAmt  = 0;
								if(!empty($result))
								{
									foreach($result as $row)
									{
										$displayPrice  = $row->productAmt;
										$productWeight = $row->productWeight;
										$subTotal	   = $row->quantity*$displayPrice;	
										$productId 	   = $row->productId;						
										$totalAmt  	   = $totalAmt+$subTotal;
								?>
<tr class="first odd">
	<td class="image">
		<?php
		if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
		{
		?>
			<a class="product-image" title="<?php echo $row->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->productId); ?>">
				<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$row->imageName; ?>" width="75" height="75"/>
			</a>
		<?php
		}
		elseif((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
		{
		?>
			<a class="product-image" title="<?php echo $row->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->productId); ?>">
				<img src="<?php echo base_url().'uploads/product/'.$row->imageName; ?>" width="75" height="75"/>
			</a>
		<?php
		}
		else
		{
		?>
			<a class="product-image" title="<?php echo $row->code; ?>" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->productId); ?>">
				<img src="<?php echo base_url().'img/no_image.jpg'; ?>" width="75" height="75"/>
			</a>
		<?php
		}
		?>
	</td>
    <td>
		<h2 class="product-name">
			<a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->productId); ?>">
				<?php echo $row->code; ?>
			</a> 
		</h2>
		<span class="item-info">&nbsp;</span><br>
		<?php
		if(!empty($row->colorCode))
		{
		?>
		<span>
			<label class="">Color : </label> 
            <a class="btn  btn-xs color_box active_color color_static" style="background-color:<?php echo $row->colorCode; ?>"></a>
		</span>
		<?php
		}
		if(!empty($row->size))
		{
		?>
		<span class=""> 
			<label class="">Size : </label>
            <a class="btn btn-xs size_box  active_color size_static"><?php echo $row->size; ?></a>
		</span>
		<?php
		}
		?>
		<span class="item-info">&nbsp;</span><br>
		<span class="seller-name">Seller: 
			<span>
				<a href="javascript:void(0);"><strong><?php echo $row->organizationName; ?></strong></a>
			</span>
		</span>
	</td>
    <td class="a-right">
		<span class="cart-price"> <span class="price">&#x20A6;<?php echo number_format($displayPrice,2); ?></span></span>
	</td>
    <td class="a-left movewishlist">
    	<div class="qty-div">
			<a href="javascript:void(0)" onclick="qty_decryment('<?php echo $row->cartId; ?>');"><div>-</div></a>
			<div id="qty<?php echo $row->cartId; ?>"><?php echo $row->quantity; ?></div>
			<a href="javascript:void(0)" onclick="qty_increment('<?php echo $row->cartId; ?>');"><div>+</div></a>
		</div>
    </td>   
    <td class="a-right movewishlist">
		<span class="cart-price"> 
			<span class="price">
				&#x20A6;<span id="subtotal<?php echo $row->cartId; ?>">
							<?php echo number_format(($subTotal),2); ?>
						</span>
			</span>
		</span>
	</td>  
    <td class="a-center last">
		<a href="javascript:void(0);" class="button remove-item" title="Remove item" onClick="remove_to_cart('<?php echo id_encrypt($row->cartId); ?>');">
			<span><span>Remove item</span></span>
		</a>
	</td>                                       
</tr>                  
								<?php
									}
								}
								?>
							</tbody>
							<?php
							if(!empty($result))
							{
							?>
							<tfoot>
								<tr class="first last">
									<td class="a-right last" colspan="50">
									<?php
									if($productId)
									{
									?>
									<a class="button btn btn-continue button_carts" title="Continue Shopping" type="button" href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($productId); ?>">
										<span><span>Continue Shopping</span></span>
									</a>
									<?php
									}
									?>
			                        <a id="empty_cart_button" class="button btn btn-empty button_carts" title="Clear Cart" value="empty_cart" name="update_cart_action" type="submit" onclick="return clear_cart();"><span><span>Clear Cart</span></span></a>										
				                  </tr>
			                </tfoot>
							<?php
							}
							?>		
                		</table>
					</fieldset>
        		</div>
        		<!-- BEGIN CART COLLATERALS -->
				<div class="cart-collateral row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4"></div>
					<div class="totals col-sm-4">
						<h3>Shopping Cart Total</h3>
						<div class="inner">
							<table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
								<colgroup>
									<col>
									<col width="1">
								</colgroup>
								<tfoot>
									<tr>
										<td colspan="1" class="a-left"><strong>Total</strong></td>
										<td class="a-right">
											<strong>
												<span class="price">&#x20A6;<span id="totalAmt"><?php echo number_format($totalAmt,2); ?></span>
												</span>
											</strong>
										</td>
									</tr>
								</tfoot>
							</table>
							<ul class="checkout">
              					<li>
								<?php
								if($this->session->userdata('userId'))
								{
								?>
									<a class="button btn btn-proceed-checkout" title="Proceed to Checkout" type="button" href="<?php echo base_url().'frontend/product_cart/shipping_address'; ?>" style="padding: 8px 15px;">
										<i class="fa fa-check"></i> &nbsp; <span>Proceed to Checkout</span>
									</a>
								<?php
								}
								else
								{
								?>
									<a class="button btn btn-proceed-checkout" title="Proceed to Checkout" type="button" data-toggle="modal" data-target="#modal-login" style="padding: 8px 15px;">
										<i class="fa fa-check"></i> &nbsp; <span>Proceed to Checkout</span>
									</a>
								<?php
								}
								?>
								</li>              
							</ul>
						</div>
					<!--inner-->           
					</div>
				</div>
      			<!--cart-collaterals--> 
			</div>    
		</div>
	</div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">

<script type="text/javascript">
function qty_increment(cartId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url(); ?>frontend/product_cart/qty_increment',
		data:'cartId='+cartId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		dataType: 'json',
		success:function(result){	//console.log(result);
			if(result.success==1)
			{
				$('#qty'+cartId).text(result.message);
				$('#subtotal'+cartId).text(result.subtotal);
				$('#totalAmt').text(result.total);
			}
			else if(result.success==0)
			{
				swal({ title:result.message,});
			}					
		}
	});
}

function qty_decryment(cartId)
{
	qtnty = $('#qty'+cartId).text();
	if(qtnty>1)
	{
		$.ajax({
		type: "POST",
		url:'<?php echo base_url(); ?>frontend/product_cart/qty_decryment',
		data:'cartId='+cartId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		dataType: 'json',
		success:function(result){ 	
			if(result.success==1)
			{
				if(result.message==0)
				{
					window.location.href = '<?php echo base_url().'frontend/product_cart/cart_page'; ?>';
				}
				else
				{
					$('#qty'+cartId).text(result.message);
					$('#subtotal'+cartId).text(result.subtotal);
					$('#totalAmt').text(result.total);
					//$('#totalShipp').text(result.totalShipp);		
				}
			}
			else if(result.success==0)
			{
				swal({ title:result.message,});
			}					
		}
	});
	}
	else
	{
		swal({ title:'Quantity can not less then 1',});
	}
}

function remove_to_cart(cartId)
{
	swal({   
		title: '',   
		text: 'Are you sure want to remove this item ?',   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Yes",   
		cancelButtonText: "No",   
		closeOnConfirm: true,   
		closeOnCancel: false 
		}, 
	function(isConfirm){   
		if (isConfirm) 
		{   
			$.ajax({
				type: "POST",
				url:'<?php echo base_url(); ?>frontend/product_cart/remove_to_cart/'+cartId,
				data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
				success:function(result){
					window.location.href = '<?php echo base_url().'frontend/product_cart/cart_page'; ?>';
				}
			});
			
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

function clear_cart()
{
	swal({   
	title: '',   
	text: 'Are you sure want to clear cart',   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{  
			window.location.href = '<?php echo base_url().'frontend/product_cart/clear_cart'; ?>';  
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
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
    border: 1px solid #fe5621;
    background: #fe5621;
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
    background: #666;
    padding: 24px 15px;
    color: #fff;
    width: 100%;
    text-decoration: none;
    border-radius: 2px;    font-size: 16px;
}
a.button.btn-proceed-checkout:hover {
    background: #fe5621;
    color: #fff;
    border: 1px solid #fe5621;
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
</style>