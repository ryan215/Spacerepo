<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td>&#x20A6;<?php echo number_format($row->fromPrice,2);?></td>
        <td><?php 
			if($row->toPrice==100000000000000)
			{
				echo 'Above';
			}
			else
			{
				echo '&#x20A6;'.number_format($row->toPrice,2);
			}
			?>
        </td>
		<td>
			<?php 
			if($row->spacePointeCommission)
			{
				echo '<center><i class="fa fa-check text-success" data-toggle="tooltip" title="Active"></i></center>';
			}
			else
			{
				echo '<center><i class="fa fa-times text-danger" data-toggle="tooltip" title="Inactive"></i></center>';
			}
			?>
        </td>
		<td>
			<?php 
			if($row->adminFee)
			{
				echo '<center><i class="fa fa-check text-success" data-toggle="tooltip" title="Active"></i></center>';
			}
			else
			{
				echo '<center><i class="fa fa-times text-danger" data-toggle="tooltip" title="Inactive"></i></center>';
			}
			?>
        </td>
    	<td>
			<?php 
			if($row->genuineShippingFee)
			{
				echo '<center><i class="fa fa-check text-success" data-toggle="tooltip" title="Active"></i></center>';
			}
			else
			{
				echo '<center><i class="fa fa-times text-danger" data-toggle="tooltip" title="Inactive"></i></center>';
			}
			?>
        </td>
        <td>
        	
            	<a href="<?php echo base_url().$this->session->userdata('userType').'/price_management/addEditPrice/'.id_encrypt($row->priceMngtId); ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit">
                	<i class="fa fa-pencil"></i>
                </a>
                &nbsp;&nbsp;
                <a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return delete_price_range('<?php echo id_encrypt($row->priceMngtId); ?>');">
                	<i class="fa fa-trash-o"></i>
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
		<td colspan="7" align="center">Data No Found</td>
	</tr>
<?php
}
?>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>