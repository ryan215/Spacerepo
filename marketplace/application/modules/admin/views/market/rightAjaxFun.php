<?php
$i = 1;
if(!empty($list))
{
	foreach($list as $row)
	{
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><img src="<?php echo base_url().'/uploads/advertise/thumb50/'. $row->imageName; ?>"></td>
		<td><?php echo $row->url; ?></td>
		<?php /*?><td>
			<a href="<?php echo base_url().$this->session->userdata('userType').'/marketing/deleteLeftImage/'.id_encrypt($row->homePagePromotionId); ?>" class="label label-danger" onclick="return delete_slider();" title="Delete"><i class="fa fa-trash-o"></i></a>
		 	<a href="<?php echo base_url().$this->session->userdata('userType').'/marketing/editLeftSlider/'.id_encrypt($row->homePagePromotionId); ?>" class="label label-warning " title="View detail">
				<i class="fa fa-pencil"></i>
		 	</a>
		</td><?php */?>
	</tr>
	<?php
		$i++;
	}
	if($links)
	{
	?>
	<tr>
		<td colspan="4" align="right"><?php echo $links; ?></td>
	</tr>
	<?php
	}
}

?>