
	<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($orderList))
{
	$i = $page+1;
	foreach($orderList as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<?php
	
	?>
	<td>
	<?php if($row->subscriptionPlanId==1)
	{
		echo 'Pointepay Delux';
	}elseif($row->subscriptionPlanId==2)
	{
		echo 'Pointepay Lite';
	}
	?>
	
	</td>
	
    
	<td><?php echo ucwords($row->firstName);?></td>
	<td><?php echo ucwords($row->lastName); ?></td>		
	
	<td>
	<?php echo $row->phone; ?>

	
	</td>
	<td>
	<?php echo $row->email; ?>

	
	</td>
	<td>
	
	<center><a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/pointepay_management/orderDetail/'.id_encrypt($row->pointepaySubscriptionId); ?>">
			<i class="fa fa-eye"></i>
	</a></center>
	</td>
</tr>
<?php
		$i++;
	}
	if(!empty($links))
	{
?>
<tr>
	<td colspan="10" align="right">
		<div class="pagination">
			<?php echo $links; ?>
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
	<td colspan="10" align="center">No Data Found</td>
</tr>	
<?php
}
?>			