<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
<tr>
	<td><?php echo $i; ?></td>
	<?php
	
	?>
	<td>
		<?php echo ucwords($row->organizationName); ?>
	</td>
	
    
	<td><?php echo ucwords($row->firstName.' '.$row->middle.' '.$row->lastName); ?></td>
	<td><?php echo $row->businessPhoneCode.$row->businessPhone; ?></td>		
	
	<td>
	<?php if($row->phoneVerificationStatus==1){
		echo '<span class="label label-success tooltips" title="" data-original-title="Refercence No. 78729513131" aria-describedby="tooltip403443">Paid</span>';
	}
	else
	{
		echo '<a href="#myModal" data-toggle="modal" class="tooltips" title="" data-original-title="Add Refercence No."><span class="label label-danger ">Unpaid</span></a>';
	}
	?>
	
	
	</td>
	<td>
	<center><a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/pointepay_management/user_detail/'.id_encrypt($row->organizationId); ?>">
			<i class="fa fa-eye"></i>
	</a></center>
	</td>
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