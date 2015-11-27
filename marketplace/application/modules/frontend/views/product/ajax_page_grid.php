<div class="category-products">
	<ul class="pdt-list products-grid zoomOut play">
    	<?php
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$imageNm = $row['imageName'];
		?>
		<li class="item item-animate last" id="<?php echo id_encrypt($row['productId']); ?>">
			<div class="item-inner">
				<?php
				if(($row['productTypeId'])&&($row['productTypeId']==3))
				{
				?>
			 		<div class="sale-label sale-top-left" style="font-weight: bold !important; width: 90px !important;  font-size: 10px !important;top: 11px;  left: -22px; z-index: 1 !important; letter-spacing:0 !important;" onclick="pre_sale_alert();">
						Pre-Order
					</div>
				<?php
				}
				?>
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
                </div>
				
                <div class="item-info">
                	<div class="info-inner">
                    	<div class="item-title">
							<a href="<?php echo product_url($row['productId'],$row['productName']); ?>" title="<?php echo $row['productName']; ?>">
								<?php echo $row['productName']; ?>
							</a> 
						</div>
						<div class="clearfix"></div>
						
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
										<?php
										if($row['adminPrice'])
										{
										?>
										<span class="price" style="color:red !Important;">
											<strike>
												<?php echo '&#x20A6;'.number_format($row['currentPrice'],2); ?>
											</strike>
										</span>
										<?php
										}
										?> 
									</span> 
								</div>
                        	</div>
                            
							<div class="item-price">
                          		<div class="price-box">
									<span class="regular-price">
										<span class="price">
									   		<?php
											if($row['adminPrice'])
											{
												echo '&#x20A6;'.number_format($row['adminPrice'],2); 
											}
											else
											{
												echo '&#x20A6;'.number_format($row['currentPrice'],2);
											}
											?>
									   	</span> 
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
.item-content{min-height:68px;}
.sale-label{     -webkit-transform: rotate(-45deg);  transform: rotate(-45deg);}
</style>