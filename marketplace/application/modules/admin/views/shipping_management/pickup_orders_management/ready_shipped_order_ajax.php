<?php
if(!empty($result['list']))
{
	$i = $result['page']+1;
	foreach($result['list'] as $row)
	{
		$trackNo = $row->trackingNbr;
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
		<?php
			//if($this->session->userdata('userType')=='admin')
			{/*
			?>
		<td>
			
			<input type="text" class="form-control" id="txtTrack<?php echo id_encrypt($row->orderId); ?>" onblur="save_track_no('<?php echo id_encrypt($row->orderId); ?>',this.value);" value="<?php echo $trackNo; ?>">
			<br />
			<button onclick="auto_genrate('<?php echo id_encrypt($row->orderId); ?>');">Auto Genrate</button>
			
		</td>
		<?php
			*/}
			?>
		<?php /*?><td><?php echo ucwords($row->firstName.' '.$row->lastName); ?></td>	<?php */?>	
		
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
		
		<!--<td><input type="checkbox" name="manifesto[]" class="manifesto_selection" value="<?php //$row->orderId;?>"></td>	-->	
		
		<?php /*?><td>
			<?php
			if(!empty($trackNo))
			{
			?>
				<button class="btn btn-danger btn-sm" onclick="print_page('<?php echo id_encrypt($row->orderId); ?>');">
					Print
				</button>
			<?php
			}
			?>
		</td><?php */?>
		<td>
			<center><a href="<?php echo base_url().$this->session->userdata('userType').'/ready_to_pickup/ready_to_pickup_order_view/'.id_encrypt($row->orderId); ?>" class="btn btn-warning btn-xs">
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