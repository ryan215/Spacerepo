<div class="modal-dialog modal-lg" style="width:700px;">
	<div class="modal-content">
    	<div class="modal-header" style="border-radius:0px;">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Product Detail</h4>
		</div>
        <div class="modal-body"  style="display: inline-block;">
			<div class="col-sm-3">
				<?php
				if((!empty($orderDetails->product_image))&&(file_exists('uploads/product/thumb50/'.$orderDetails->product_image)))
				{
				?>
					<img src="<?php echo base_url().'uploads/product/thumb50/'.$orderDetails->product_image; ?>" class="img-responsive">
				<?php
				}
				else
				{
				?>
					<img src="<?php echo base_url().'img/no_image.jpg'; ?>" class="img-responsive">
				<?php
				}
				?>
			</div>
			<div class="col-sm-9">
				<table>
					<tr>
						<th>Product Name</th>
						<td>
							<?php
							if(!empty($orderDetails->product_name))
							{
								echo $orderDetails->product_name;
							}
							?>
						</td>								
					</tr>
					<tr>
						<th>Price</th>
						<td>
							<?php
							if(!empty($orderDetails->product_price))
							{
								echo '&#x20A6;'.$orderDetails->product_price;
							}
							else
							{
								echo '&#x20A6;0';
							}
							?>
						</td>								
					</tr>
					<tr>
						<th>Tax</th>
						<td>
							<?php
							if(!empty($orderDetails->product_tax))
							{
								echo '&#x20A6;'.$orderDetails->product_tax;
							}
							else
							{
								echo '&#x20A6;0';
							}
							?>
						</td>								
					</tr>	
					<tr>
						<th>Item Weight (in Kg)</th>
						<td>
							<?php
							if(!empty($orderDetails->total_weight))
							{
								echo '&#x20A6;'.$orderDetails->total_weight;
							}
							else
							{
								echo 0;
							}
							?>
						</td>								
					</tr>
					<tr>
						<th>segment</th>
						<td>
							<?php
							if(!empty($orderDetails->segment_name))
							{
								echo $orderDetails->segment_name;
							}
							else
							{
								echo '';
							}
							?>
						</td>								
					</tr>
					<tr>
						<th>Category</th>
						<td>
							<?php
							if(!empty($orderDetails->category_name))
							{
								echo $orderDetails->category_name;
							}
							else
							{
								echo '';
							}
							?>
						</td>								
					</tr>
					<tr>
						<th>Brand</th>
						<td>
							<?php
							if(!empty($orderDetails->brand_name))
							{
								echo $orderDetails->brand_name;
							}
							else
							{
								echo '';
							}
							?>
						</td>								
					</tr>
					<tr>
						<th>Description</th>
						<td>
							<?php
							if(!empty($orderDetails->description))
							{
								echo nl2br($orderDetails->description);
							}
							else
							{
								echo '';
							}
							?>
						</td>								
					</tr>
				</table>
			</div>		
		</div>
	</div>
</div>