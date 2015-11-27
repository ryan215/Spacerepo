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
		<td class="text-center">
			<a href="<?php echo base_url().$this->session->userdata('userType').'/marketing/deleteCenterImage/'.id_encrypt($row->homePagePromotionId); ?>" class="label label-danger" onclick="return delete_slider();" title="Delete"><i class="fa fa-trash-o"></i></a>
		 	<a href="<?php echo base_url().$this->session->userdata('userType').'/marketing/addEditSliderList/'.id_encrypt($row->homePagePromotionId); ?>" class="label label-warning " title="View detail">
				<i class="fa fa-pencil"></i>
		 	</a>
		</td>
	</tr>
	<?php
		$i++;
	}
}
?>