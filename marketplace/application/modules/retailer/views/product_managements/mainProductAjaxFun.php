<?php //echo "<pre>";print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td>
			<?php 
			if((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/'.$row->imageName.'" height="70" width="70" />';
			}
			else
			{
				echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
			}
			?>			
		</td>
        <td><?php echo $row->code; ?></td>
		<td><?php echo $row->categoryCode; ?></td>
			<td><?php echo $row->brandName; ?></td>							
		
		<?php
		if($organizationId)
		{/*			
		?>
		<td>
			<?php //echo $organizationId;
			$orgPrdIDS = $row->orgPrdIDS;
			if(!empty($orgPrdIDS))
			{
				$organizationPrdId = 0;
				$expIDS = explode(",",$orgPrdIDS);
				$organizationIdArr = array();
				$organizationIdPrdArr = array();
				if(!empty($expIDS))
				{
					$flag = 0;
					foreach($expIDS as $val)
					{
						$expARR = explode('|',$val);
						if(count($expARR)>1)
						{
							$organizationIdArr    = $expARR[0];
							$organizationIdPrdArr = $expARR[1];
							if($organizationId==$expARR[0])
							{
								$flag = 1;
								$organizationPrdId = $expARR[1];
							}
						}
					}
					
				}
				
				if((!empty($organizationIdArr))&&(!empty($organizationIdPrdArr)))
				{
					if($flag)
					{
					?>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/inventory_details/'.id_encrypt($organizationPrdId).'/'.id_encrypt($organizationId); ?>" class="btn btn-danger btn-xs" title="View details">
							Already Added
						</a>
						<?php
					}
					else
					{
					?>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/add_inventory/'.id_encrypt($organizationId).'/'.id_encrypt($row->productId); ?>" class="btn btn-success btn-xs" title="View details">
							Add Inventory
						</a>
					<?php
					}
				}				
			}
			else
			{
			?>
				<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/add_inventory/'.id_encrypt($organizationId).'/'.id_encrypt($row->productId); ?>" class="btn btn-success btn-xs" title="View details">
					Add Inventory
				</a>
			<?php
			}
		?>			
		</td>	
		<?php
		*/}
		?>
		<td>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_product_management/addRetailerProduct/'.id_encrypt($row->productId).'/'.id_encrypt($organizationId); ?>" class="btn btn-warning btn-xs tooltips" title="View details">
				Add Product
			</a>
		</td>
		<td>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($row->productId).'/'.id_encrypt($organizationId); ?>" class="btn btn-warning btn-xs tooltips" title="View details">
				<i class="fa fa-eye"></i>
			</a>
		</td>		
	</tr>
	<?php
		$i++;
	}
	if(!empty($result['links']))
	{
	?>
	<tr>
		<td colspan="6" align="right">
			<div class="pagination">
				<?php echo $result['links']; ?>
			</div>
		</td>
	</tr>
	<?php
	}
}
else
{
?>
	<tr>
		<td colspan="6" align="center">No Product Available</td>
	</tr>
<?php
}
?>