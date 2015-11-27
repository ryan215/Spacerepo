<div class="category-products">
	<ol class="products-list col-sm-12" id="products-list">
		<?php
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$imageNm = $row['imageName'];
		?>
		<li class="item even">
        	<div class="product-image">
				<a href="<?php echo product_url($row['productId'],$row['productName']); ?>">
					<?php
									if((!empty($imageNm))&&(file_exists('uploads/product/thumb500_500/'.$imageNm)))
									{
									?>
										<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$imageNm; ?>" alt="" width="250">
									<?php
									}
									elseif((!empty($imageNm))&&(file_exists('uploads/product/'.$imageNm)))
									{
									?>
										<img src="<?php echo base_url().'uploads/product/'.$imageNm; ?>" alt="" width="250">
									<?php
									}
									else
									{
									?>
										<img src="<?php echo base_url(); ?>img/no_image.jpg" alt=""  width="250">
										
									<?php
									}
									?>	
								</a>
			</div>
            <div class="product-shop">
            	<h2 class="product-name">
					<a href="<?php echo product_url($row['productId'],$row['productName']); ?>" title="<?php echo $row['productName']; ?>">
								<?php echo $row['productName']; ?>
							</a>
				</h2><div class="clearfix"></div>
				<div class="col-sm-12 col-xs-12 padding_left_zero" >
					<div class="rating_icon">
						<?php
						for($i=1;$i<=5;$i++)
						{
							if($i<=$row['avgRating'])
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
				</div>
				<div class="clearfix"></div>
                  <div class="price-box mr_bottom">
				  	<span class="regular-price" id="product-price-152"> 
					  <h2 class="price_list_view">&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></h2> 
					  </span> 
						 <?php
							if(((!empty($row['cashAdminFee']))&&($row['cashAdminFee']))||((!empty($row['freeShipPrdId']))&&($row['freeShipPrdId']))||((!empty($row['freeShipCatId']))&&($row['freeShipCatId'])))

							{
							?>
								<span class="free-shipping-label">+ FREE DELIVERY</span>
							<?php
							}
							?>
					 </div>
					 <div class="clearfix"></div>
                  <div class="sc_sec mr_bottom" style="display:inline-block;">
				  <?php
				  if(!empty($row['size']))
				  {
				  ?>
	                 <!-- <div class="col-sm-1 padding_left_zero"> <label>Size</label></div>-->
	                  <div class="col-sm-12 padding_left_zero">
					  	<?php
						foreach($row['size'] as $size)
						{
						?>
                  			<div class="btn btn-small size_box" style="cursor:default;">
								<?php echo $size; ?>
							</div>
						<?php
						}
						?>
                        </div>
				  <?php
				  }
				  ?>
	              <div class="clearfix"></div>
                  <?php
				  if(!empty($row['colors']))
				  {
				  ?>
				  	<!--<div class="col-sm-1 padding_left_zero"><label>Color</label></div>-->
					<div class="col-sm-12 padding_left_zero">
						<?php
						foreach($row['colors'] as $color)
						{
						?>
                       	<div class="btn btn-small color_box" style="cursor:default;background-color:<?php echo $color; ?>"></div>	
                       	<?php
					   	}
					   	?>
					</div>	
				  <?php
				  }
				  ?>
                  </div>
                  <div class="clearfix"></div>
                  <div class="soldby-div-list col-sm-8 padding_left_zero">
                  	<label>Sold By</label>
                    <p class="solder-name-list">
					<?php
					echo $row['organizationName'];
					?>
					</p>
                  </div>
                  <div class="actions col-sm-4 ">
                    <!--<button class="button btn-cart ajx-cart" title="Add to Cart" type="button"><span>Add to Cart</span></button>-->
                    <a class="btn button btn-show-more ajx-cart pull-right" href="<?php echo product_url($row['productId'],$row['productName']); ?>" title="<?php echo $row['productName']; ?>" type="button"><span>See More</span></a>
                     </div>
                </div>
              </li>
		<?php
			}
		}
		else
		{
			if($page_number==0)
			{
		?>
		<li class="item item-animate last">
        	<div class="item-inner">
            	No Product Available
			</div>
        </li>
		<?php
			}
		}
		?>
	</ol>
</div>	
<style>
.price_list_view{
  color: #fe5621;
  font-family: museo700;
  margin: 0;

  font-weight: normal;
  line-height: 20px;
  letter-spacing: 1px;
}
.price{ font-size:20px !important;}
.sale-price{ 
	font-weight: normal;
  font-size: 10px;
  color:red;
}
.price-box {
  margin: 0px !important;
}
.products-grid .item .item-inner .item-info .info-inner .item-content .item-price {
  margin: 0px !important;
}
.vip-price{height:18px;
}
.info-inner .item-content{height:50px;  
}
.mr_bottom{ margin-bottom:10px !important;}
</style>