<?php	
$ids = array();
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		$delivered_date = $row->deliveredDate;
		$ids[] = '#datepicker'.$row->orderId;
	?>
	<tr>
		
		<td><?php echo $i; ?></td>
		<td><?php echo $row->createDt; ?></td>
		<td><?php echo $row->customOrderId; ?></td>
		<td>
		<?php
										if($this->session->userdata('userType')=='admin')
										{
										?>
		<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($row->productId); ?>" target="_blank">
		
			<?php echo $row->code; ?>
			</a>
			<?php
			}
			else
			{
				echo $row->code; 
			}			
			?>
		</td>
		<td><?php echo $row->trackingNbr; ?></td>
		<td>
			<input type="text" class="form-control" value="<?php echo $row->deliveredDate; ?>" id="datepicker<?php echo $row->orderId; ?>" onchange="save_delivered_date('<?php echo id_encrypt($row->orderId); ?>',this.value);"/>
		</td>
		<td><?php 
		if($row->organizationName)
		{
			echo $row->organizationName; 
		}
		else
		{
			echo $row->firstName.' '.$row->lastName;
		}
		?></td>	
		<td>&#x20A6;<?php echo number_format(($row->quantity*$row->chargedAmount),2); ?></td>	
		<td>
			<center><a href="<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit/shipped_in_transit_order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs">
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
		<td colspan="14" align="right">
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
		<td colspan="14" align="center">
			No Data Found
		</td>
	</tr>	
	<?php
}
?>

<?php
$year = date('Y');
$from = $year;
$to   = $year+10;
?>
<script type="text/javascript">
<?php /*?>$(function(){
	$("<?php echo implode(',',$ids); ?>").datetimepicker({ 
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		
		yearRange: "<?php echo $from; ?>:<?php echo $to; ?>",
	});
});<?php */?>
$("<?php echo implode(',',$ids); ?>").datetimepicker({
dayOfWeekStart : 1,
lang:'en',
formatDate:'Y-m-d',
minDate:'-1970/01/02',
startDate:	'<?php echo date('Y-m-d'); ?>'
});
$('#datetimepicker').datetimepicker({value:'<?php echo date('Y-m-d H:i'); ?>',step:10});
</script>
<style>
.ui-datepicker td span, .ui-datepicker td a {
  display: block;
  padding: 0.2em;
  text-align: center !important;
  text-decoration: none;
}
</style>