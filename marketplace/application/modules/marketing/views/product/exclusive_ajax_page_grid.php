<div class="category-products">
	<ul class="pdt-list products-grid zoomOut play">
    	<?php
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$imageNm = $row['imageName'];
		?>
		<li class="item item-animate last">
        	<div class="item-inner">
            	<div class="product-wrapper">
                	<div class="thumb-wrapper">
                    <div class="sale-label sale-top-left" style="font-weight: bold !important; width: 90px !important;  font-size: 11px !important;top: -2px;left: -33px; z-index: 1 !important;">VIP Sale</div>	
                      		<a href="<?php echo product_url($row['productId'],$row['productName']); ?>" class="thumb">
								<span class="face">
									<?php
									if((!empty($imageNm))&&(file_exists('uploads/product/'.$imageNm)))
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
								</span>
							
							</a>
						</div>
                </div>
                <div class="item-info">
                	<div class="info-inner">
                    	<div class="item-title">
							<a href="<?php echo product_url($row['productId'],$row['productName']); ?>" title="<?php echo $row['productName']; ?>">
								<?php echo $row['productName']; ?>
							</a> 
						</div><div class="clearfix"></div>
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
						<div class="item-content">
                        	<div class="item-price">
                          		<div class="price-box">
									<span class="regular-price">
                                        <span class="sale-price"><strike>&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></strike></span> 
									</span> 
								</div>
                        	</div>
							
                            <div class="item-price">
                          		<div class="price-box">
									<span class="regular-price">
                                       <span class="price">VIP Sale &#x20A6;<?php echo number_format($row['adminPrice'],2); ?></span> 
									</span> 
								</div>
                        	</div>
							<?php
							if(((!empty($row['cashAdminFee']))&&($row['cashAdminFee']))||((!empty($row['freeShipPrdId']))&&($row['freeShipPrdId']))||((!empty($row['freeShipCatId']))&&($row['freeShipCatId'])))
							{
							?>
								<span class="free-shipping-label">+ FREE DELIVERY</span>
							<?php
							}
							?>
                      	</div>
					</div>
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
	</ul>
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
.sale-price{ 
	font-weight: 900;
  font-size: 11px;
  color:red;
}
.price-box {
  margin: 0px !important;
}
.products-grid .item .item-inner .item-info .info-inner .item-content .item-price {
  margin: 0px !important;
}
.mr_bottom{ margin-bottom:10px !important;}

.free-shipping-label {
    border: 1px dashed #999;
    border-radius: 3px;
    box-sizing: border-box;
    color: #f38c46;
    display: inline-block;
    font-family: latomedium !important;
    font-size: 10px;
    font-weight: 600;
    height: 19px;
    padding: 1px 7px;
    position: relative;
    top: 2px;
}
.sale-label{     -webkit-transform: rotate(-45deg);  transform: rotate(-45deg);}
</style>