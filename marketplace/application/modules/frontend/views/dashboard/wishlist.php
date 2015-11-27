<section class="main-container col1-layout">
	<div class="main container shadow-main-div">
  		<div class="col-main">
			<!--breadcrumb-->
 			<div class="yt-breadcrumbs">
        		
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="category4" itemscope="" itemtype=""><strong>Wishlist</strong></li></ul>
					</div>
        			</div>
        		</div>
			
			<!--breadcrumb-->
			
			<div class="col-sm-9" style="padding-left:0px;">
    		    <div class="my-account">
        			<div class="page-title">
            			<h2>My Wishlist</h2>
				  	</div>
          			
					<div class="dashboard">
			            <div class="recent-orders">
              				<div class="table-responsive">
                				<table class="data-table wishlst-table" id="my-orders-table" style="border:0 !important;">
                 					<thead>
										<tr class="first last">
											<th>#</th>
										  	<th>Image</th>
										  	<th>Product Name</th>
											<th>Product Price</th>
											<th>In/Out Stock</th>
										  	<th>Remove</th>
										</tr>
                  					</thead>
                  					<tbody>
										<?php 
										if(!empty($result))
										{
											$i = 1;
											foreach($result as $row)
											{
												$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
												//echo "<pre>";	print_r($priceArr); exit;
												$displayPrice  = $priceArr['displayPrice'];
											?>
											<tr class="first odd">
												<td class="paddin-top15"><?php echo $i; ?></td>
												<td class="image">
													<?php 
													if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
													{
													?>
													<a class="product-image" href="javascript:void(0);">
														<img width="75" height="75" src="<?php echo base_url().'uploads/product/thumb500_500/'.$row->imageName; ?>">
													</a>
													<?php
													}
													elseif((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
													{
													?>
													<a class="product-image" href="javascript:void(0);">
														<img width="75" height="75" src="<?php echo base_url().'uploads/product/'.$row->imageName; ?>">
													</a>
													<?php
													}
													else
													{
													?>
													<a class="product-image" href="javascript:void(0);">
														<img src="<?php echo base_url().'img/no_image.jpg'; ?>" height="70" width="70"/>
													</a>
													<?php
													}
													?>	
					  							</td>
												<td class="paddin-top15">
													<a href="<?php echo product_url($row->productId,$row->code); ?>">
														<?php echo $row->code; ?>
													</a>
												</td>
												<td class="paddin-top15">&#x20A6;<?php echo number_format($displayPrice,2); ?></td>
												<td class="paddin-top15">
													<?php
													if($row->currentQty)
													{
														echo 'In Stock';
													}
													else
													{
														echo 'Out Of Stock';
													}
													?>
												</td>
												<td class="paddin-top15">
													<a href="<?php echo base_url().'frontend/dashboard/remove_from_wishlist/'.id_encrypt($row->wishListId); ?>" onclick="return remove_list();">
														<center><i class="fa fa-trash"></i></center>
													</a>
												</td>
											</tr>
										<?php
											$i++;
											}
										}
										else
										{
										?>
											<tr>
												<td colspan="5" align="center">
													No Wishlist Available
												</td>
											</tr>
										<?php
										}
										?>
									</tbody>	
                				</table>
              				</div>
            			</div>
					</div>
				</div>
			</div>

	  	<?php $this->load->view('right_bar'); ?>
  		</div>
	</div>
</section>
<script type="text/javascript">
function remove_list()
{
	if(confirm('Are you sure want to delete this ?'))
	{
		return true;
	}
	return false;
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/level-1.css">
<style>
.paddin-top15{padding-top:15px !important;
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
</style>