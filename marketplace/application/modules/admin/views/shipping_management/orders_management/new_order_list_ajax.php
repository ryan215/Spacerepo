<?php //echo "<pre>"; print_r($result['list']); exit;
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['createDt']; ?></td>
	<td><?php echo $row['customOrderId']; ?></td>
	<td>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($row['productId']); ?>" target="_blank">
			<?php echo $row['code']; ?>
		</a>
	</td>
    <td><?php echo $row['organizationName']; ?>
	</td>
	<td>&#x20A6;<?php echo number_format($row['ttlChargedAmount'],2); ?></td>
	<td>
	<table width="100%" class="table table-striped   stock_table cus_table">
    	<?php
		if(!empty($row['customerDet']))
		{
		?>
			<tr>
            	<td style="border-top:none;">
                	<strong>Name</strong>
                </td>
                <td style="border-top:none;">
                	<?php echo $row['customerDet']['name']; ?>
                </td>
			</tr>
			<tr>
            	<td>
                	<strong>Phone No.</strong>
                </td>
                <td>
                	+234-<?php echo $row['customerDet']['phone']; ?>
                </td>
            </tr>
			<tr>
            	<td><strong>State</strong></td>
                <td><?php echo $row['customerDet']['stateName']; ?></td>
            </tr>
			<tr>
            	<td>
                	<strong>Area </strong>
                </td>
                <td><?php echo $row['customerDet']['areaName']; ?></td>
            </tr>
			<tr>
            <td><strong>City </strong></td>
            <td><?php echo $row['customerDet']['cityName']; ?></td></tr>
        <?php
		}
		?>
	</table>
	</td>
	<td>
    	<?php echo $row['dropCenterName']; ?>
    </td>
    <td>
		<?php
		if($this->session->userdata('userType')=='retailer')
		{
			if($row['orderStatusId']==6)
			{
				echo 'Declined';
			}
			else
			{
		?>
		<a class="btn btn-success btn-sm" href="javascript:void(0);" onclick="return accept_decline('<?php echo id_encrypt($row['orderId']); ?>',2);">
			Accept
		</a> 
		<a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="return accept_decline('<?php echo id_encrypt($row['orderId']); ?>',6);">
			Decline
		</a>
		<?php	
			}
		}
		else
		{
		?>
		<center>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/new_order/new_order_view/'.id_encrypt($row['orderId']); ?>" class="btn btn-warning btn-xs" type="button" title="View Detail">
			<i class="fa fa-eye"></i>
		</a></center>
		<?php
		}
		?>
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
	<td colspan="10" align="center">Data Not Found</td>
</tr>	
<?php
}
?>
<style>
.cus_table tbody tr td{ padding:5px; border-radius:0px;}
</style>
