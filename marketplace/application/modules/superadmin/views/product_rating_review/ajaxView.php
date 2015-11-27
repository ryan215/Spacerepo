<?php //echo "<pre>";print_r($result['list']); exit;
if(!empty($list))
{
	$i = $page+1;
	foreach($list as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row->reviewTitle; ?></td>
        <td><?php echo $row->reviewDescription; ?></td>
		<td>
			
			
			<center><a href="<?php echo base_url().$this->session->userdata('userType').'/product_rating_review/rating_review_detail/'.id_encrypt($row->productRatingId); ?>" class="btn btn-warning btn-xs tooltips" title="View details">
				<i class="fa fa-eye"></i>
			</a>
			<a href="javascript:void(0);" class="btn btn-danger btn-xs tooltips" title="Delete" onclick="return delete_rating_review(<?php echo id_encrypt($row->productRatingId); ?>);">
				<i class="fa fa-trash-o"></i>
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
		<td colspan="7" align="right">
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
		<td colspan="7" align="center">Data Not Found</td>
	</tr>
<?php
}
?>