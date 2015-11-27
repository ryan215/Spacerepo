<div class="col-lg-12">
	<section class="panel">
    	<header class="panel-heading panel-heading1" style="padding-bottom:15px;">
        	Edit Inventory
			<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/edit_inventory/'.id_encrypt($organizationProductId); ?>" class="btn btn-info pull-right" style="">
            	<i class="fa fa-pencil"></i> Edit Sell Price
            </a>
		</header>
		
		<div class="panel-body">
        	<div class="col-lg-12" style="padding:0;">
            	<section class="panel">
                	<div class="panel-body" style="padding:0;">
						<?php echo form_open(); ?>
						<div class="summary-list">
							<div class="col-lg-4">
								<div style="float:left; width:60px; font-size:14px; padding-top:11px;">Increase</div>
								<div class="switch" style="float:left; width:120px;">
<input type="radio" class="switch-input" name="editinventory" value="add" id="add" <?php if($result['editinventory']=='add'){?> checked="checked" <?php } ?>>
	<label for="add" class="switch-label switch-label-off">+</label>
<input type="radio" class="switch-input" name="editinventory" value="sub" id="sub" <?php if($result['editinventory']=='sub'){?> checked="checked" <?php } ?>>
	<label for="sub" class="switch-label switch-label-on">-</label>
    <span class="switch-selection"></span>
								</div>
								<div style="float:left; width:60px; padding-left:7px; font-size:14px; padding-top:11px;">Decrease</div>
									<?php echo form_error('editinventory'); ?>
								</div>
								<div class="col-lg-8 pull-left">
									<?php
									if(isset($result['productcolorlist']) && !empty($result['productcolorlist']))
									{
									?>
										<div class="col-lg-12 pull-left">
											<div style="font-size:14px; padding-top:11px;" class="pull-left">Color</div>
											<div class="pull-left" style="padding-top:11px;">
												<div class="form-group clearfix color-filter" id="color" style="margin-bottom:0px;">
												<?php 
												foreach($result['productcolorlist'] as $product_color)
												{
												?>
												<div class="block-element">
													<label>
														<input type="checkbox" name="availablecolor[]" value="<?php echo $product_color->colorId; ?>">
														<small style="background-color:<?php echo $product_color->colorCode; ?>"></small>
													</label> 
												</div>
												<div class="clearfix"></div>
												<?php
												} 
												echo form_error('availablecolor[]');
												?>
											</div>
										</div>
									</div>
									<?php 	
									}
									
									if(isset($result['product_size']) && !empty($result['product_size']))
									{
									?>
										<div class="col-lg-12 pull-left">
											<div style="font-size:14px; padding-top:11px;" class="pull-left">Size</div>
											<div class="pull-left" style="padding-top:11px;  padding-left: 10px;">
											<?php 
											foreach($result['product_size'] as $size)
											{
												$explodSize = explode(',',$size->sizes);
												if(!empty($explodSize))
												{
													foreach($explodSize as $expSize)
													{
												?>
												<input type="checkbox" name="selectsize[]" value="<?php echo $size->productSizeId; ?>" id="add" >
												<label class="sizes_label"><?php echo $expSize; ?></label>
												<?php
													}
												}
												else
												{
											?>
												<input type="checkbox" name="selectsize[]" value="<?php echo $size->productSizeId; ?>" id="add" >
												<label class="sizes_label"><?php echo $size->sizes; ?></label>
											<?php
												}
											}
											echo form_error('selectsize[]');  
											?>	
											</div>
           								</div>
									<?php
									}
									?>
								</div>
							</div>
		
		
				<div class="col-sm-4">
                    <input class="form-control" type="text" placeholder="Enter Inventory" name="inventory" value="<?php echo $result['inventory']; ?>">
						<?php echo form_error('inventory'); ?>
                    </div>                                     
                                                                       
					<div class="col-sm-1" style="padding-top:0px;">
                        <button type="submit" class="btn btn-space btn-primary">
							Save
						</button>
                	</div>
            	</div>
			</form>
    	</div>
	</section> 
</div>
						  
<div class="col-lg-12">
	<div class="col-sm-4 state-overview pd">
    	<section class="panel">
        	<div class="symbol symbol1 red stock-red-div">Stock Left</div>
				<?php
				if(!empty($result['organizationColorsSizeArray']))
				{
					$flag = 1;
					foreach($result['organizationColorsSizeArray'] as $colorKey=>$colorRow)
					{
						if(!empty($colorRow['sizes']))
						{
							foreach($colorRow['sizes'] as $sizeKey=>$sizeRow)
							{
								$flag = 0;
							}
						}
					}
					
					if($flag)
					{
						?>
						<table width="100%" class="table table-striped   stock_table">
									<tr>
										<td><strong>Color</strong></td>
										<td><strong>Stock</strong></td>
									</tr>
									<?php 
									foreach($result['organizationColorsSizeArray'] as $colorKey=>$colorRow)
									{
									?>
									<tr>
										<td>
											<small style="background-color:<?php echo $colorRow['colorCode']; ?>"></small>
										</td>
										<td>
											<?php echo $colorRow['currentStock']; ?>
										</td>
									</tr>
									<?php 
									}
									?>
								</table>	
								
						<?php
						}
					else
					{
				?>
					<table width="100%" class="table table-striped   stock_table">
						<tr>
							<td><strong>Sizes</strong></td>
							<td><strong>Stock</strong></td>
						</tr>
						<?php
						foreach($result['organizationColorsSizeArray'] as $colorKey=>$colorRow)
						{
						?>
						<tr>
							<td colspan="2">
								<small style="background-color:<?php echo $colorRow['colorCode']; ?>"></small>
							</td>
						</tr>
						<?php
						if(!empty($colorRow['sizes']))
						{
							foreach($colorRow['sizes'] as $sizeKey=>$sizeRow)
							{
								$flag = 0;
							?>
								<tr>
									<td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow['currentStock']; ?></td>
								</tr>
							<?php	
							}
						}
						}
					}
						
					?>
					</table>
				<?php	
				}
				elseif(!empty($result['organizationSizesArray']))
				{
				?>
				<table width="100%" class="table table-striped   stock_table">
					<tr>
						<td><strong>Size</strong></td>
						<td><strong>Stock</strong></td>
					</tr>
					<?php 
					foreach($result['organizationSizesArray'] as $sizeKey=>$sizeRow)
					{
					?>
						<tr>
							<td><?php echo $sizeKey; ?>
							</td>
							<td><?php echo $sizeRow['currentStock']; ?>
							</td>
						</tr>
					<?php 
					}
					?>
				</table>	
				<?php
				}
				else
				{				
				?>
				<table width="100%" class="table table-striped   stock_table">
					<tr>
						<td><strong>Stock</strong></td>
						<td><?php echo $result['currentQty']; ?></td>
					</tr>
					
				</table>	
				<?php
				}
                ?> 
		</section>
	</div>
</div>
						  
<!--start product detail page-->
<div class="col-sm-12">
	<div class="panel">
		<div class="panel-body pd">
			<div class="col-sm-12 detail-plus panel-heading panel-heading1">
				Product Detail
			</div>
			<div class="dtl-div col-sm-12 pd" >
            	<aside class="profile-nav col-lg-3 pd" style="padding-top:12px;">
                	<section class="panel">
                    	<div class="user-heading round" style="margin-left:10px;">
                        	<?php 
							if((!empty($result['imageName']))&&(file_exists('uploads/product/'.$result['imageName'])))
							{
								echo '<img src="'.base_url().'uploads/product/'.$result['imageName'].'" height="150" width="150" />';
							}
							else
							{
								echo '<img src="'.base_url().'img/no_image.jpg" height="150" width="150"/>';
							}
							?>	
                            <h1><?php echo $result['productName']; ?></h1>
						</div>
					</section>
				</aside>
                               
				<div class="col-sm-9">
                	<table class="table table-invoice">
                    	<thead>
                        	<tr>
                            	<th colspan="2">Details</th>
                            </tr>
						</thead>
                        <tr>
                        	<td>Product Name</td>
                            <td>
								<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($result['productId']); ?>">
									<?php echo $result['productName']; ?>
								</a>
							</td>
                        </tr>
						<tr>
                        	<td>Stock Details</td>
							<td>
								<?php
								if((!empty($result['organizationColorsArray']))&&(!empty($result['organizationSizesArray'])))
								{
								?>
								<table width="100%" class="table table-striped   stock_table">
									<tr>
										<td><strong>Sizes</strong></td>
										<td><strong>Stock</strong></td>
									</tr>
									<?php
									foreach($result['organizationColorsArray'] as $colorKey=>$colorRow)
									{
									?>
									<tr>
										<td colspan="2">
											<small style="background-color:<?php echo $colorRow['colorCode']; ?>"></small>
										</td>
									</tr>
									<?php
										foreach($result['organizationSizesArray'] as $sizeKey=>$sizeRow)
										{
									?>
									<tr>
										<td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow['currentStock']; ?></td>
									</tr>
									<?php	
										}
									}
									?>
								</table>
								<?php	
								}
								elseif(!empty($result['organizationColorsArray']))
								{
								?>
								<table width="100%" class="table table-striped   stock_table">
									<tr>
										<td><strong>Color</strong></td>
										<td><strong>Stock</strong></td>
									</tr>
									<?php 
									foreach($result['organizationColorsArray'] as $colorKey=>$colorRow)
									{
									?>
									<tr>
										<td>
											<small style="background-color:<?php echo $colorRow['colorCode']; ?>"></small>
										</td>
										<td>
											<?php echo $colorRow['currentStock']; ?>
										</td>
									</tr>
									<?php 
									}
									?>
								</table>	
								<?php
								}
								elseif(!empty($result['organizationSizesArray']))
								{
									foreach($result['organizationSizesArray'] as $sizeKey=>$sizeRow)
									{
									?>
									<tr>
										<td><?php echo $sizeKey; ?></td><td><?php echo $sizeRow['currentStock']; ?></td>
									</tr>
									<?php	
									}
								}
								else
								{
									echo $result['currentQty'];
								}
								?>
							</td>
						</tr>
                                        <tr>
                                            <td>Retailer Quoted Price</td>
                                            <td>&#x20A6;<?php echo number_format($result['retailerQuotePrice'],2); ?></td>
                                        </tr>
										<tr>
                                            <td>Retailer Pay Back Price</td>
                                            <td>&#x20A6;<?php echo number_format($result['retailerPrice'],2); ?></td>
                                        </tr>                                        
                                        <tr>
                                            <td>
												<?php 
												if($this->session->userdata('userType')=='retailer')
												{
													echo 'Commission';
												}
												else
												{
													echo 'Customer Commission';
												}
												?>
											</td>
                                            <td>&#x20A6;<?php echo number_format($result['spacePointeCommission1'],2); ?></td>
                                        </tr>
										<?php 
										if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
										{
										?>		
										<tr>
                                            <td>Retailer Commission</td>
                                            <td>&#x20A6;<?php echo number_format($result['spacePointeCommission2'],2); ?></td>
                                        </tr>
										<tr>
                                            <td>Admin Fee</td>
                                            <td>&#x20A6;<?php echo number_format($result['adminPrice'],2); ?></td>
                                        </tr>
                                        <?php
										 }
										 /*?><tr>
                                            <td>Cash Handling Fee</td>
                                            <td>&#x20A6;<?php echo number_format($result['handlingPrice'],2); ?></td>
                                        </tr>
<?php */?>										<tr>
                                            <td>Display Price</td>
                                            <td>&#x20A6;<?php echo number_format($result['displayPrice'],2); ?></td>
                                        </tr>
                                    </table>
                                </div>
							</div>
							</div>
							</div>
						  </div>
						
						  <!--enf of product detail page-->
						  
                         </div>