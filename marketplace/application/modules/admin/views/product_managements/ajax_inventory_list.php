<?php //echo "<pre>";print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		
		?>
		<tr>
		<td><?php echo $i; ?></td>
		
		<td><?php echo $row['organizationName']; ?></td>
		<td><?php echo $row['firstLastName']; ?></td>
		<td><?php echo $row['businessPhone']; ?></td>
		<td><?php echo $row['stateName']; ?></td>
		<td><?php echo $row['areaName']; ?></td>
		<td>&#x20A6;<?php echo $row['currentPrice']; ?></td>
		<td><?php echo $row['currentQty']; ?></td>
	</tr>
	<?php
		$i++;
	}
	if(!empty($result['links']))
	{
	?>
	<tr>
		<td colspan="10" align="right">
			<div class="pagination">
				<?php echo $result['links']; ?>
			</div>
		</td>
	</tr>
	<?php
	}
}else
{
	if($this->session->userdata('userType')=='cse')
	{
?>
	<tr>
		<td colspan="10" align="center">There is no retailer assigned for you of this product</td>
	</tr>
<?php
	
	}
	else
	{
?>
	<tr>
		<td colspan="10" align="center">No retailer Available</td>
	</tr>
<?php
	}
}
?>
