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
	if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
	{/*
	?>
    <td width="5%">
		<?php
		if($row->isPointeMart)
		{
		?>
			<img src="<?php echo base_url();?>img/platform_pm_icon.png" / alt="logo">
		<?php
		}
		?>
	</td>
	<td width="5%">
		<?php
		if($row->isPointePay)
		{
		?>
			<img src="<?php echo base_url();?>img/platform_pp_icon.png" / alt="logo">
		<?php
		}
		?>    	
    </td>
	<?php
	*/}
	?>
	<td>
		<?php echo ucwords($row->organizationName); ?>
	</td>
	
    
	<td><?php echo ucwords($row->firstName.' '.$row->middle.' '.$row->lastName); ?></td>
	<?php
	if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
	{
	?>
	<td>
		<?php
		if(($row->isPointeMart)&&($row->isPointePay))
		{
			echo $row->cseName;
		}
		elseif($row->isPointeMart)
		{
			echo $row->cseName;
		}
		elseif($row->isPointePay)
		{
			echo 'NA';
		}
		?>
	</td>
	<?php /*?><td><?php echo $row->userName; ?></td><?php */?>
	<td><?php echo $row->businessPhoneCode.$row->businessPhone; ?></td>		
	<?php
	}
	if($this->session->userdata('userType')=='cse')
	{
	?>
	<td>
		<?php echo $row->businessPhoneCode.$row->businessPhone; ?>
	</td>
	<?php
	}
	if($this->session->userdata('userType')=='cse')
	{
	?>
	<td><?php echo $row->cityName; ?></td>
	<td><?php 
		if($row->requestStatus==2)
		{
			echo 'Request';
		}
		elseif($row->requestStatus==3)
		{
			echo 'Accepted';
		}
		elseif($row->requestStatus==4)
		{
			echo 'Declined';
		}
	 ?></td>
	<?php
	}
	?>
	
	<td>
	<a class="btn btn-warning btn-xs tooltips" title="View Detail" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/user_detail/'.id_encrypt($row->organizationId); ?>">
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