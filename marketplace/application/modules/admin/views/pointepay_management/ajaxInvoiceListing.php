
	<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($invoiceListing))
{
	$i = $page+1;
	foreach($invoiceListing as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row->refrenceNumber; ?></td>
	<td><?php echo $row->organizationName; ?></td>
	<td><?php echo ucwords($row->firstName).' '.$row->lastName ; ?></td>		
	
	<td><?php echo $row->businessPhone; ?></td>
	<td><?php echo $row->businessPhone; ?></td>
	<td>&#x20A6;<?php echo $row->totalAmount; ?></td>
	<td>
	<center><a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/pointepay_management/invoiceDetail/'.id_encrypt($row->pointepaySubscriptionId); ?>">
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