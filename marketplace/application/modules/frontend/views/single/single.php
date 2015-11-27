<?php
$inventory = 0;
if((!empty($result['retailerArr'][0]['inventory'])) && ($result['retailerArr'][0]['inventory'])) 
{
    $inventory = $result['retailerArr'][0]['inventory'];
}
?>
<link href="<?php echo base_url(); ?>js/frontend/lightbox/glasscase.minf195.css?v=2.1" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>css/frontend/style_drop.css" rel="stylesheet"/>
<link href="http://fonts.googleapis.com/css?family=Ubuntu|Roboto|Roboto+Slab" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/frontend/lightslider.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>css/frontend/zoom.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/level-1.css">
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
								<strong><?php echo $product_detail->code; ?></strong>
							</li>
						</ul>
					</div>
        		</div>
        	</div>
        	<!--breadcrumb-->
			
      <div class="row">
        <div class="product-view">
          <div class="product-essential">

<div class="col-sm-12 padding_zero product-single-maindiv">
	<div class="product-img-box col-sm-4 col-xs-12">
    	<div class="productImages" data-ctrl="ProductImagesController">
        	<div class="innerPanel">
				<?php
				if((!empty($product_detail->productTypeId))&&($product_detail->productTypeId==3))
				{
				?>
            	<div style="position:absolute; background:none; z-index: 1 !important; left:15px;" class=" sale-top-left" onclick="pre_sale_alert();">
					<a href="javascript:void(0);">
						<img src="<?php echo base_url(); ?>images/new_images/pretag.png">
					</a>
				</div>
            	<?php
				}
				?>
				
				<div class="mainImage">
                	<div class="imgWrapper">
						<?php 
						if(!empty($product_images))
						{
							$i = 1;
							foreach($product_images as $image)
							{ 
							
								$imageUrl = base_url().'img/no_image.jpg';
								if((!empty($image->imageName))&&(file_exists('uploads/product/thumb500_500/'.$image->imageName)))
								{
									$imageUrl = base_url().'uploads/product/thumb500_500/'.$image->imageName;
								}
								elseif((!empty($image->imageName))&&(file_exists('uploads/product/'.$image->imageName)))
								{
									$imageUrl = base_url().'uploads/product/'.$image->imageName;
								}
								?>
								<img src="<?php echo $imageUrl ;?>" class="productImage <?php if($image->displayOrder==1){ echo 'current'; } ?>" data-imageId="demo<?php echo $i; ?>" data-src="<?php echo $imageUrl ;?>" data-zoomImage="<?php echo $imageUrl ;?>" > 
								<?php								
								$i++;
							}
						}
						?>
					</div> 
                </div>
                <div class="carouselContainer leftDisabled">
					<?php 
					if(!empty($product_images))
					{
						if(count($product_images)>4)
						{
					?>
						<span class="leftArrow arrow"></span> 
						<span class="rightArrow arrow"></span>
					<?php
						}
					}
					?>
                    <ul class="carousel leftDisabled">
						<?php 
						if(!empty($product_images))
						{
							$i = 1;
							foreach($product_images as $image)
							{ 
								$imageUrl = base_url().'img/no_image.jpg';
								if((!empty($image->imageName))&&(file_exists('uploads/product/thumb500_500/'.$image->imageName)))
								{
									$imageUrl = base_url().'uploads/product/thumb500_500/'.$image->imageName;
								}
								elseif((!empty($image->imageName))&&(file_exists('uploads/product/'.$image->imageName)))
								{
									$imageUrl = base_url().'uploads/product/'.$image->imageName;
								}
								?>
								<li>
									<div class="thumbContainer">
										<div class="thumb" style="background-image:url('<?php echo $imageUrl; ?>')" data-imageId="demo<?php echo $i; ?>"> </div>
                                	</div>
								</li>
                                <?php 
								$i++;																
							}
						}
						?>
                    	</ul>
                    </div>
                  </div>
                  <div class="productImageZoom"></div>
                </div>
                
                <!-- end: more-images -->
                
                <div class="clear"></div>
              </div>
              <div class="product-shop col-sm-8 col-xs-12">
                <div class="product-name">
                  <h1><?php echo $product_detail->code; ?></h1>
                </div>
                <div class="col-sm-12 stock_section  padding_zero" style="padding:10px 10px 5px 0; display:inline-block;  border-bottom: 1px solid #ddd;">
					<div class="col-sm-2 col-xs-2 padding_left_zero" >
                    	<?php
						if((!empty($product_detail->currentQty))&&($product_detail->currentQty))
						{
						?>
                   		<div class="">
                      		<label class="btn-stock">In Stock</label>
	                    </div>
	                  <?php
					  	}
					  else
					  {
					  ?>
                    <label class="btn-out-stock">Out Of Stock</label>
                    <?php
					  }
					  ?>
                    
                   
                  </div>
                 <div class="col-sm-4 col-xs-4 padding_left_zero" >
				  	 	<div class="rating_icon">
							<?php
							$totalRating = 0;
							$avgRating   = 0;
							if(!empty($productRating))
							{
								$totalRating = $productRating->totalProductRating;
								$avgRating   = $productRating->avgProductRating;
							}
							for($i=1;$i<=5;$i++)
							{
								if($i<=$avgRating)
								{
									echo '<span class="fa fa-star active"></span>';
								}
								else
								{
									echo '<span class="fa fa-star inactive"></span>';
								}
							}
							?>							
							<span class="total_review">
								<a href="<?php echo product_rating_review_url($productId,$product_detail->code); ?>" title="Reviews">
									(<?php echo $totalRating; ?> Reviews)
								</a>
							</span>
						</div>
				  </div>
				  <div class="col-sm-3 col-xs-3">
					  <p class="write_review">
					  	<?php
						if($this->session->userdata('userId'))
						{
						?>
							<a href="<?php echo product_write_review_url($productId,$product_detail->code); ?>">
								<i class="fa fa-pencil"></i> Write a Review 
							</a>
						<?php
						}
						else
						{
						?>
						<a class="add_to_wishlist" data-toggle="modal" data-target="#modal-login" title="Write A Review" style="cursor:pointer;">
							<i class="fa fa-pencil"></i> Write a Review  
						</a>
						<?php
						}
						?>
					  </p>
				  </div>
                  <div class="col-sm-3 col-xs-3 pd">
                    <p class="rating-links">
                    <?php
					if($this->session->userdata('userId'))
					{
						if(empty($product_detail->wishListId))
						{
						?>
                      		<a href="<?php echo base_url().'frontend/single/add_wish_list/'.id_encrypt($productId); ?>" class="add_to_wishlist" style="cursor:pointer;"><i class="fa fa-heart"></i> Add to Wishllist</a>
                      <?php
						}
					}
					else
					{
					?>
						<a class="add_to_wishlist" data-toggle="modal" data-target="#modal-login" title="Add To Wishlist" style="cursor:pointer;">
							<i class="fa fa-heart"></i> Add to WishList 
						</a>
                      <?php
					}
					?>
                    </p>
                  </div>
                </div>
				<div class="col-sm-12 padding_left_zero">
				<?php
							if($product_detail->currentQty<=5)
							{
						?>
					
                      		<span class="" style="color:#fe5621;">Only <?php echo $product_detail->currentQty; ?> left in stock - Order Now!</span>
	                    
						<?php
							}?>
				</div>
<div class="col-sm-12  padding_zero" style=" display:inline-block;  padding: 0 0 10px 0;">
<?php
if(!empty($colors))
{
?>
	<div class="col-sm-6 col-xs-6 padding_left_zero">
    	<h4 class="cs_head">Select Color</h4> 
		<div id="selectColor">
			<?php
			if(!empty($colors))
			{
				foreach($colors as $key=>$row)
				{	
					$productColorUrl = product_url($productId,$product_detail->code,$key,$sizeId,$row['organizationColorSizeId']);			
			?>
			<a class="btn btn-default col-sm-1 color_box  <?php if(($colorId!=$key)&&($colorId!='')){?> fadde_color <?php }elseif($colorId==$key){ echo 'active_color'; } ?>" style="background-color:<?php echo $row['colorCode']; ?>" href="<?php echo $productColorUrl; ?>"></a>
			<?php
				}
			}
			?>
		</div>
    </div>
<?php
} 
//echo "<pre>"; print_r($sizes); exit;

$checkSameSize = array();
if(!empty($sizes))
{
?>
	<div class="col-sm-6 col-xs-6 padding_left_zero">
    	<h4 class="cs_head">Select Size</h4>
		<div id="size_list">
			<?php
			foreach($sizes as $sizeKeyId=>$row)
			{
				if($row)
				{
					if((!empty($checkSameSize))&&(in_array($row['size'],$checkSameSize)))
					{
					}
					else
					{
						$productClrSizeUrl = product_url($productId,$product_detail->code,$colorId,$sizeKeyId,$row['organizationColorSizeId']);
						$checkSameSize[$row['size']] = $row['size'];			

			?>
            <a class="btn btn-small size_box <?php if(!empty($sizeId)){ if($sizeId!=$sizeKeyId){?> fadde_color <?php }if($sizeId==$sizeKeyId){ echo 'active_color'; } } ?>" href="<?php echo $productClrSizeUrl; ?>">
				<?php echo $row['size']; ?>
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
?>
</div>
               
			  
    
    <div class="col-sm-3 check_aval" id="shipMSG" style="display:none;"></div>
                <div class="price_section">
                  <div class="col-sm-5 price_sec_1 pull-left">
                    	<?php
						if(!empty($marketingPrice))
						{
						?>
                    	<p class="actual-price" id="actualPrice">
                            <span style="  font-family: museo300;">Actual Price:</span> <span style="color:red;"><strike>&#8358;<?php echo number_format($productPrice,2); ?></strike></span>
                        </p>
                        <?php
						}
						?>
                        <p class="special-price">
                            &#8358;<span id="currentPrice"><?php if(!empty($marketingPrice)){ echo number_format($marketingPrice,2); }else{ echo number_format($productPrice,2); } ?></span><?php
						if(!empty($marketingPrice))
						{
						?>
                        <span id="discountPer">
	                        <span class="pri-percent">&nbsp;<?php echo round($discountPer);?>%<br />OFF</span>
                        </span>
                        <?php
						}
						?>
                        </p>
						<div class="clearfix"></div>
						
						<span id="">
					  	<?php
						if(((!empty($cashAdminFee))&&($cashAdminFee))||((!empty($freeShipPrdId))&&($freeShipPrdId))||((!empty($freeShipCatId))&&($freeShipCatId)))
						{
						?>
							<span class="free-shipping-label">+ FREE DELIVERY</span>   
						<?php
						}
						?>
						</span>
                    <div class="clearfix"></div>
                    <button class="btn-add_to_cart" title="Add to Cart" type="button" id="addToCart"
						<?php
						if((!empty($colors))&&(!empty($sizes)))
						{ 
							if((empty($colorId))&&(empty($sizeId)))
							{ 
							?> 
								onclick="select_with_color_size();"
							<?php 
							}
							elseif(empty($colorId))
							{
							?>
								onclick="select_with_color();"
							<?php 
							}
							elseif(empty($sizeId))
							{ 
							?>
								onclick="select_with_size();" 
							<?php 
							}
							else
							{ 
							?>
								onclick="single_add_to_cart('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');"
							<?php 
							} 
						}
						elseif(!empty($colors))
						{ 
							if(empty($colorId))
							{ 
							?>
								onclick="select_with_color();" 
							<?php 
							}
							else
							{
							?> 
								onclick="single_add_to_cart('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');" 
							<?php 
							}						 
						}
						elseif(!empty($sizes))
						{ 
							if(empty($sizeId))
							{ 
							?> 
								onclick="select_with_size();" 
							<?php 
							} 
							else
							{
							?> 
								onclick="single_add_to_cart('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');" 
							<?php 
							}
						}
						else
						{
						?> 
							onclick="single_add_to_cart('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');" 
						<?php 
						} 
						?>>
						<span><i class="icon-basket"></i> Add to Cart</span> 
                    </button>                    
                    <button class="btn_buynow_sec" title="Buy Now" type="button" id="buyNow"
						<?php 
						if((!empty($colors))&&(!empty($sizes)))
						{ 
							if((empty($colorId))&&(empty($sizeId)))
							{ 
							?> 
								onclick="select_with_color_size();"
							<?php 
							}
							elseif(empty($colorId))
							{
							?>
								onclick="select_with_color();"
							<?php 
							}
							elseif(empty($sizeId))
							{ 
							?>
								onclick="select_with_size();" 
							<?php 
							}
							else
							{ 
							?>
								onclick="single_buy_now('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');"
							<?php 
							} 
						}
						elseif(!empty($colors))
						{ 
							if(empty($colorId))
							{ 
							?>
								onclick="select_with_color();" 
							<?php 
							}
							else
							{
							?> 
								onclick="single_buy_now('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');" 
							<?php 
							}						 
						}
						elseif(!empty($sizes))
						{ 
							if(empty($sizeId))
							{ 
							?> 
								onclick="select_with_size();" 
							<?php 
							} 
							else
							{
							?> 
								onclick="single_buy_now('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');" 
							<?php 
							}
						}
						else
						{
						?> 
							onclick="single_buy_now('<?php echo id_encrypt($organizationProductId); ?>','<?php echo id_encrypt($marketingProductId); ?>');" 
						<?php 
						} 
						?>>
                    	<span><i class="icon-basket"></i>Buy Now</span>
                    </button>                    
                    <div class="clearfix"></div>
                    
                  </div>
<div class="col-sm-7 price_sec_2 pull-left">
	<h4>Sold By</h4>
    <div class="pull-left"> 
		<span class="pull-left sold_buy_name">
	    	<h4 style="padding:3px 0 3px 0; margin-bottom:4px;" id="soldBy"><?php echo $organizationName; ?></h4>
		</span>  
	</div>
	
	<div class="clearfix"></div>
					
	<div class="pull-left">
		<div class="shipping_fee_sec">
			<p id="shippBox" style="display:none;">
				<i class="fa fa-truck" style="color:#7BC371 !important;"></i> 
				<span> Shipping Fee</span>: &nbsp;
				<span class="head_price">
					<span id="shippFee">&#8358;0.0</span>
				</span>
			</p>
		</div>
    
		<div class="payment_mode_sec">
    		<p>
				<h4 style="font-family: museo700; padding-bottom:10px;"> Payment Type</h4>
				<img src="<?php echo base_url(); ?>images/frontend/payment-icons.png" width="15%" />
				<span class="head">Payment with card </span>
				<?php
				if((!empty($product_detail->productTypeId))&&($product_detail->productTypeId==3))
				{
				}
				else
				{
				?>
				<img src="<?php echo base_url(); ?>images/frontend/cash.png" width="15%" /> 
				<span class="head">Cash on delivery  </span>
				<img src="<?php echo base_url(); ?>images/frontend/payment-icons3.png" width="15%" /> 
				<span class="head">Payment on pickup </span>
				<?php
				}
				?>
			</p>
		</div>
	</div>
</div>
<div class="clearfix"></div>

                </div>
              </div>
            </div>
            <!--Seller Section-->
            <div class="clear"></div>
            <br>
            <br>
            
            <!--Seller Section-->
            </div>
<?php
if(!empty($organizationProductIdArr))
{
	unset($organizationProductIdArr[$organizationProductId]);
	if(!empty($organizationProductIdArr))
	{
?>
<div class="col-sm-12 product-disc-maindiv">
	<div class="col-sm-12 pd">
    	<div class="new_title center">
        	<h2>Sold By (<?php echo count($organizationProductIdArr); ?>)</h2>
        </div>
	</div>
    <div class="table-responsive seller-table-div col-sm-12">
    	<table class="data-table seller-table" id="my-orders-table" style="">
        	<colgroup>
            	<col>
                <col>
                <col>
                <col width="1">
                <col width="1">
                <col width="1">
			</colgroup>
            <thead>
            	<tr class="first last sold_buy" style="background:#F2F2F2 !important;">
                	<th width="45%">Sellers</th>
                    <th width="34%">Price</th>
					<th width="20%">&nbsp;</th>
				</tr>
			</thead>
            <tbody>
				<?php
				foreach($organizationProductIdArr as $key=>$row)
				{
				?>
            	<tr class="first odd sold_buy_inner">
                	<td>
						<span class="sold_buy_head"> <?php echo $row['organizationName']; ?> </span> 
					</td>
                    <td>
                    	<?php
						if(!empty($row['marketingPrice']))
						{
						?>
                    	<p class="actual-price">
                            <strike>&#8358;<?php echo number_format($row['currentPrice'],2); ?></strike>
                        </p>
                        <?php
						}
						?>
                        <p class="special-price">
                            <span class="price" style="font-size:14px;">
								<?php 
								if(!empty($row['marketingPrice']))
								{ 
									echo '&#8358;'.number_format($row['marketingPrice'],2); 
								}
								else
								{ 
									echo '&#8358;'.number_format($row['currentPrice'],2); 
								}
								?>
							</span>
                        </p>  
                      </td>
                    <td>
						<?php  
						if((!empty($colors))&&(!empty($sizes)))
						{ 
							if((empty($colorId))&&(empty($sizeId)))
							{ 
						?>
						<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="select_with_color_size();"> Buy Now</button>
						<?php 
							}
							elseif(empty($colorId))
							{
							?>
							<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="select_with_color();"> <span><i class="icon-basket"></i>Buy Now</span></button>
							<?php 
							}
							elseif(empty($sizeId))
							{ 
							?>
							<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="select_with_size();"> <span><i class="icon-basket"></i>Buy Now</span></button>
							<?php 
							}
							else
							{ 
								if((array_key_exists($colorId,$row['productColor']))&&(array_key_exists($sizeId,$row['productSize'])))
								{
								?>
								<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="single_buy_now('<?php echo id_encrypt($key); ?>','<?php echo id_encrypt($row['marketingProductId']); ?>');"><span><i class="icon-basket"></i>Buy Now</span></button>
								<?php
								}									
							} 
						}
						elseif(!empty($colors))
						{ 
							if(empty($colorId))
							{ 
							?>
							<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="select_with_color();" <span><i class="icon-basket"></i>Buy Now</span></button>
							<?php 
							}
							else
							{
								if(!empty($row['productColor']))
								{
								if(array_key_exists($colorId,$row['productColor']))
								{
								?>
								<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="single_buy_now('<?php echo id_encrypt($key); ?>','<?php echo id_encrypt($row['marketingProductId']); ?>');"><span><i class="icon-basket"></i>Buy Now</span></button>
								<?php
								}
								}
							}						 
						}
						elseif(!empty($sizes))
						{ 
							if(empty($sizeId))
							{ 
							?>
							<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="select_with_size();"> <span><i class="icon-basket"></i>Buy Now</span></button> 
							<?php 
							} 
							else
							{
								if(array_key_exists($sizeId,$row['productSize']))
								{
								?>
								<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="single_buy_now('<?php echo id_encrypt($key); ?>','<?php echo id_encrypt($row['marketingProductId']); ?>');"><span><i class="icon-basket"></i>Buy Now</span></button>
								<?php
								}
							}
						}
						else
						{
						?>
							<button class="btn_buynow_sec" title="Buy Now" type="button" onclick="single_buy_now('<?php echo id_encrypt($key); ?>','<?php echo id_encrypt($row['marketingProductId']); ?>');"><span><i class="icon-basket"></i>Buy Now</span></button> 
						<?php 
						}
						?>       	            	
					</td>
				</tr>
                <?php
				}
				?>
			</tbody>                  			
		</table>
    </div>
</div>
<div class="clearfix"></div>
<?php
	}
}
?>
            <div class="col-sm-12">
              <div class="new_title center" style="margin:0px !important;">
                <h2>Specification</h2>
              </div>
              <div class="table-responsive specification-table" style="padding-bottom:20px;padding-top:30px;">
                <div class="col-sm-12" style="background-color:#F2F2F2; padding:10px; border:1px solid #F2F2F2; font-weight:600;"> SPECIFICATION & DETAILS </div>
                <table class="data-table" id="my-orders-table" style="border-top:0 !important; border-bottom:0 !important;">
                  <colgroup>
                  <col>
                  <col>
                  <col>
                  <col width="1">
                  <col width="1">
                  <col width="1">
                  </colgroup>
                  <tbody>
                    <tr class="first odd specifiaction_data">
                      <th  width="20%">Brand</th>
                      <td  width="80%"><?php echo $product_detail->brandName; ?></td>
                    </tr>
                    <?php 
 					  if(!empty($attributes))
					  {
					  	foreach($attributes as $product_attribute)
						{
					?>
                    <tr class="first odd specifiaction_data">
                      <th width="20%"><?php echo $product_attribute->productAttributeName;?></th>
                      <td width="80%"><?php echo $product_attribute->attributeValue;?></td>
                    </tr>
                    <?php 
	                   }
                   }
				   elseif(!empty($attrbuteSINGLE))
					{
					
					  	foreach($attrbuteSINGLE as $product_attribute)
						{
					?>
                    <tr class="first odd specifiaction_data">
                      <th width="20%"><?php echo $product_attribute->attributeName;?></th>
                      <td width="80%"><?php echo $product_attribute->attributeValue;?></td>
                    </tr>
                    <?php 
	                   }
                   
					}
                   ?>
                  </tbody>
                </table>
              </div>
            </div>
         	<div class="clearfix"></div>
<div class="col-sm-12">
	<div class="new_title center" style="margin:0px !important;">
		<h2>Reviews of <?php echo $product_detail->code; ?></h2>
	</div>
	<div class="col-sm-2 rating_avg_sec">
		<span class="fa fa-star star_big"></span><span class="count">
			<?php
			if($avgRating)
			{
				echo round($avgRating,1,PHP_ROUND_HALF_UP); 
			}
			else
			{
				echo '0.0';
			}
			?></span>
		<p class="subText">Average Rating</p>
		<p class="subText">Based on <?php echo $totalRating; ?>&nbsp;ratings</p>
	</div>
	<?php
	$productRating1 = 0;
	$productRating2 = 0;
	$productRating3 = 0;
	$productRating4 = 0;
	$productRating5 = 0;
	
	if(!empty($productRating))
	{
		$productRating1 = $productRating->productRating1;
		$productRating2 = $productRating->productRating2;
		$productRating3 = $productRating->productRating3;
		$productRating4 = $productRating->productRating4;
		$productRating5 = $productRating->productRating5;
	}
	?>
	<div class="col-sm-6 rating_stars_bar">
		<ul class="ratingsDistribution">
			<li>
				<a href="<?php echo product_rating_review_url($productId,$product_detail->code,5); ?>" title="Read 5 star reviews">
					<span>5 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $productRating5+2.041; ?>%"><?php echo $productRating5; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$product_detail->code,4); ?>" title="Read 4 star reviews">
					<span>4 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $productRating4+2.041; ?>%"><?php echo $productRating4; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$product_detail->code,3); ?>" title="Read 3 star reviews">
					<span>3 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $productRating3+2.041; ?>%"><?php echo $productRating3; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$product_detail->code,2); ?>" title="Read 2 star reviews">
					<span>2 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $productRating2+2.041; ?>%"><?php echo $productRating2; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$product_detail->code,1); ?>" title="Read 1 star reviews">
					<span>1 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo ($productRating1+2.041); ?>%"><?php echo $productRating1; ?></div>
					</div>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-sm-3 write_review_sec">
		<p style="margin-bottom:8px;">Have you used this product?</p>
		<?php
		if($this->session->userdata('userId'))
		{
		?>
		<a href="<?php echo product_write_review_url($productId,$product_detail->code); ?>">
			<button class="btn btn_write" title="write a review" type="button">
				<span>write a review</span>
			</button>
		</a>		
		<?php
		}
		else
		{
		?>
		<a class="add_to_wishlist" data-toggle="modal" data-target="#modal-login" title="Write A Review" style="cursor:pointer;">
			<button class="btn btn_write" title="write a review" type="button">
				<span>write a review</span>
			</button>  
		</a>
		<?php
		}
		?>		
	</div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
	<?php
	if(!empty($productRatingReviewLst))
	{
	?>
		<div class="new_title center" style="margin:0px !important;">
			<h2>TOP REVIEWS</h2>
		</div>	
	<?php
		foreach($productRatingReviewLst as $row)
		{
	?>
			<div class="main_reviewnrating_sec">
				<div class="col-sm-2 padding_left_zero rating_description">
					<div class="rating_icon">
						<?php
						$total = 0;
						if($row->productRating1)
						{
							$total = 1;
						}
						elseif($row->productRating2)
						{				
							$total = 2;		
						}
						elseif($row->productRating3)
						{
							$total = 3;
						}
						elseif($row->productRating4)
						{
							$total = 4;
						}
						elseif($row->productRating5)
						{
							$total = 5;
						}
						
						for($i=1;$i<=5;$i++)
						{
							if($i<=$total)
							{
								echo '<span class="fa fa-star active"></span>';
							}
							else
							{
								echo '<span class="fa fa-star inactive"></span>';	
							}
						}
						?>
					</div>
					<span><?php echo ucwords($row->firstName.' '.$row->lastName); ?></span><br />
					<span class="rating_date">
						<?php echo $row->lastModifiedDt; ?>
					</span>
					<?php
					if($row->orderId==0)
					{
					?>
					
					<img src="<?php echo base_url(); ?>images/frontend/first_to_review.png" class="img-responsive certified_img" />
					<?php
					}					
					if((!empty($row->ordersId))||(!empty($row->orderId)))
					{
					?>					
					<img src="<?php echo base_url(); ?>images/frontend/certified_buyer.png" class="img-responsive certified_img" />
					<?php
					}
					?>
				</div>
				<div class="col-sm-10 review_description">
					<p class="review_title">
						<strong>
							<?php echo $row->reviewTitle; ?>
						</strong>
					</p>
					<p>
						<?php echo nl2br($row->reviewDescription); ?>
					</p>	
				</div>
			</div>	
			<div class="clearfix"></div>
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
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">


<style>
    .gc-overlay-area {
        display: none !important;
    }
	.rating_icon{  margin-top: 2px; }
.rating_icon .active{ color:#e9ce18; }
.rating_icon .inactive{ color:#d3d3d3; }
.count{ font-size:12px;}
.total_review a{ text-transform:uppercase;  margin-left: 10px;  font-family: latoregular!important;font-size:12px;}
.write_review{   padding-top: 4px; }
.write_review_sec{ padding:20px 20px;}
.btn_write{   background-color: #F3863D;   width: 180px; padding-top: 15px;  border: none;  padding-bottom: 15px;  color: #fff!important;  margin-bottom: 20px;  border-radius: 5px;  font-size: 16px;  font-family: latoregular;  text-transform: uppercase;  font-weight: 400; }
.btn_write:hover{ background-color: #F5A168;}
.rating_avg_sec{ padding:20px 20px;}
.rating_avg_sec .star_big{   font-size: 7em; color: #e9ce18; }
.rating_avg_sec .count{     font-size: 18px;  position: absolute;      top: 53px;  left: 53px; color: #fff; }
.rating_avg_sec .subText{   margin-bottom: 0px;   color: #888;  font-size: 12px;  line-height: 18px;}
.rating_stars_bar{   margin: 20px 20px;  border-right: 1px dashed #ccc;}
.rating_stars_bar .ratingsDistribution {
  list-style-type: none;
  padding-left: 10px;
}
.rating_stars_bar .ratingsDistribution li {
  font-size: 11px;
  margin-top: 3px;
  margin-bottom: 5px;
  color: #666;
}
.rating_stars_bar .ratingsDistribution li .bar {
  background-color: #f2f2f2;
  width: 80%;
  display: inline-block;
  height: 12px;
  vertical-align: bottom;
  position: relative;
}
.rating_stars_bar .ratingsDistribution li .bar .progress {
  line-height: 11px;
  height: 11px;
  font-size: 9px;
  border-radius: 0px;
  box-shadow: none;
  background-color: #eed44b;
  border: 1px solid #eed44b;
}

.main_reviewnrating_sec{ padding-bottom:20px;}
.rating_description{ padding:20px 0 20px 0; }
.rating_description .rating_date{ font-size:12px; color:#999; }
.rating_description .certified_img{ padding-top:10px; }
.review_description{ padding:20px 0 20px 0;}
.review_description .review_title{   font-family: museo700;}
</style>
<script type="text/javascript">
function select_with_color_size()
{
	<?php
	if((!empty($colorId))&&(!empty($sizeId)))
	{
	}
	else
	{
	?>
	swal({ title:'Please Select the Color or Size',});
	<?php
	}
	?>
}

function select_with_color()
{
	<?php
	if(!empty($colorId))
	{
	}
	else
	{
	?>
	swal({ title:'Please Select the Color',});
	<?php
	}
	?>
}

function select_with_size()
{
	<?php
	if(!empty($sizeId))
	{
	}
	else
	{
	?>
	swal({ title:'Please Select the Size',});
	<?php
	}
	?>
}

function single_add_to_cart(organizationProductId,marketingProductId)
{
	postData = 'organizationProductId='+organizationProductId+'&organizationColorSizeId=<?php echo $organizationColorSizeId; ?>&colorId=<?php echo $colorId; ?>&sizeId=<?php echo $sizeId; ?>&marketingProductId='+marketingProductId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url()."frontend/product_cart/add_to_cart"; ?>',
		data:postData,
		dataType: 'json',
		success:function(result){
			if(result.success==1)
			{	
				$('span#totalProduct').html(result.totalPrd);
				$('div#topCartCnt').html(result.topCartLst);
				$("a#cartAnchor").attr('href','<?php echo base_url().'frontend/product_cart/cart_page'; ?>');
				/*swal({
					title: result.message,
				});*/								
			}
			else
			{
				swal({
					title: result.message,
				});	
			}
		}
	});
}

function single_buy_now(organizationProductId,marketingProductId)
{	
	postData = 'organizationProductId='+organizationProductId+'&organizationColorSizeId=<?php echo $organizationColorSizeId; ?>&colorId=<?php echo $colorId; ?>&sizeId=<?php echo $sizeId; ?>&marketingProductId='+marketingProductId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
	$.ajax({
		type: "POST",
		url:'<?php echo base_url()."frontend/product_buy_now/add_to_buy_now"; ?>',
		data:postData,
		dataType: 'json',
		success:function(result){	//alert(result);
			if(result.success==1)
			{	
				window.location.href = '<?php echo base_url().'frontend/product_buy_now/buy_now_page/'; ?>'+result.cartId;								
			}
			else
			{
				swal({
					title: result.message,
				});	
			}
		}
	});
}

jQuery('#myCarousel').carousel({
  interval: 40000
});

jQuery('.carousel .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  if (next.next().length>0) {
 
      next.next().children(':first-child').clone().appendTo($(this)).addClass('rightest');
      
  }
  else {
      jQuery(this).siblings(':first').children(':first-child').clone().appendTo($(this));
     
  }
});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/zoomeffect/main-e7c024d.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/zoomeffect/lib-83762ba.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/zoomeffect/legoProductPage-9ec0620.js"></script> 
<script type="text/javascript">
addOnload(function(){
	POINTMART.utils.runOnload();
});
    
addWindowOnload(function(){
	POINTMART.utils.runWindowOnload();
});

init_controllers();

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
.btn-add_to_cart{ 
	padding-top: 15px;
    border: none;
    padding-bottom: 15px;
    background-color: #666 !important;
    color: #fff!important;
    margin-bottom: 20px;
    border-radius: 5px;
	    text-transform: uppercase;
}

.btn_buynow_sec
{ 	    background-color: #F3863D;
	padding-top: 15px;
    border: none;
    padding-bottom: 15px;
    color: #fff!important;
    margin-bottom: 20px;
    border-radius: 5px;
	 text-transform: uppercase;
	     padding: 16px 52px 16px 52px;
}
.btn_buynow_sec:hover{     background-color: #F5A168;}

.sweet-alert{border-radius:0 !important;
}

.sweet-alert p{font-weight:inherit !important;
	font-size:18px !important;
}

.sweet-alert .confirm{margin-top:10px;
	background:#FE5621 !important;
	padding:8px 28px;
}

</style>

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
<script>
function pre_sale_alert()
{
 sweetAlert('','Limited time offer. Delivery time is 3 weeks. Item must be paid in full');
}
</script>


<link type="text/css" href="<?php echo  base_url(); ?>css/frontend/review.css" media="all" />

