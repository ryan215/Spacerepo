<?php
if(!empty($list))
{
	foreach($list as $row)
	{
		$imageNm = $row['imageName'];
?>
<li class="item item-animate last">
	<div class="item-inner" style="padding-bottom:40px;">  
    	<div class="product-wrapper">
        	<div class="thumb-wrapper">
            	<a href="<?php echo product_url($row['productId'],$row['productName']); ?>" class="thumb">
					<span class="face">
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
								</span>
							
							</a>
						</div>
                   <!-- <div class="actions">
						<span class="add-to-links">
							<a href="#" class="link-wishlist" title="Add to Wishlist"><span>Add to Wishlist</span></a>
							<a href="#" class="link-compare" title="Add to Compare"><span>Add to Compare</span></a>
						</span> 
					</div>-->
                </div> 
                <div class="item-info">
                	<div class="info-inner">
                    	<div class="item-title">
							<a href="<?php echo product_url($row['productId'],$row['productName']); ?>">
								<?php echo $row['productName']; ?>
							</a> 
						</div>
						
						<div class="item-content">
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
                        	<div class="item-price">
                          		<div class="price-box">
									<span class="regular-price">
                                    <?php
							if($row['adminPrice'])
							{
							?>
								<span class="price" style="font-size:12px !important; color:red; "><strike>&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></strike></span> 
                              <?php
							}
							else
							{
							?>
                            <span class="price">&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></span> 
                            <?php
							}
							?>
							</span>
								</div>
                        	</div>
                            <?php
							if($row['adminPrice'])
							{
							?>
                            <div class="item-price vip-price">
                          		<div class="price-box">
									<span class="regular-price">
                                       <span class="sale-price" style="  color: #A3CE62;  font-size: 14px;"><strong>VIP Sale &#x20A6;<?php echo number_format($row['adminPrice'],2); ?></strong></span> 
									</span> 
								</div>
                        	</div>
                            <?php
							}
							
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
		