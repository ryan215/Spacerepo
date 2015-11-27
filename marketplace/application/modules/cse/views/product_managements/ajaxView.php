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
			if((!empty($row->imageName))&&(file_exists('uploads/product/thumb500_500/'.$row->imageName)))
			{
				echo '<img src="'.base_url().'uploads/product/thumb500_500/'.$row->imageName.'" height="70" width="70" />';
			}
			elseif((!empty($row->imageName))&&(file_exists('uploads/product/'.$row->imageName)))
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
		<?php
		if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
		{
		?>
		<td><?php echo ucwords($row->firstName.' '.$row->middle.' '.$row->lastName); ?></td>
		<?php
		}
		?>
		<td><?php
			if($row->verificationResultId==3)
			{
				echo 'Pending';
			}
			elseif($row->verificationResultId==4)
			{
				echo 'Pending';
			}
			elseif($row->verificationResultId==5)
			{
				echo 'Accepted';
			}
			elseif($row->verificationResultId==6)
			{
				echo 'Declined';
			}			
			?></td>							
		<td>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/product_request_management/view/'.id_encrypt($row->productId); ?>" class="btn btn-warning btn-xs tooltips" title="View details">
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
		<td colspan="8" align="right">
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
		<td colspan="8" align="center">No Product Available</td>
	</tr>
<?php
}
?>