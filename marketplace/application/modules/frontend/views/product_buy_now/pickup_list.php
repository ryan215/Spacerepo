<?php
if(!empty($pickUpList))
{
	foreach($pickUpList as $row)
	{
?>
	<div class="shipping_add_box <?php 		if($pickupId==$row->pickupId){ echo 'even';} else {?>odd<?php } ?>" style="width:48%;float:left;">
		<?php
		if($pickupId==$row->pickupId)
		{
		?>
			<img src="<?php echo base_url(); ?>images/new_images/checkship.PNG" class="checkship" />
		<?php
		}
		?>
		<div class="address">
			<p>
				<span class="address-name">
					<?php echo $row->pickupName; ?>
				</span><br>
				<span class="address-address1">
					<strong>Address : </strong><?php echo $row->addressLine1; ?>,
				</span><br>
				<span class="address-city">
					<?php 
					if(!empty($row->city))
					{
						echo $row->city;
					}
					if(!empty($row->area))
					{
						echo ' - '.$row->area;
					}
					if(!empty($row->stateName))
					{
						echo ' - '.$row->stateName;
					}
					?>
				</span><br>
   			</p>
			<p class="">
				<span class="address-phone">
					<strong>Mobile No. : </strong> <?php echo $row->phone; ?>
				</span><div class="clearfix"></div>
				<span class="address-additional-phone">
					<?php
					if(!empty($row->secondary_phone))
					{
						echo $row->secondary_phone.'<br>';
					}
					?>
					<strong>business Days : </strong> <?PHP echo $row->businessDays;?><BR />
					
					<strong>business Time : </strong> <?PHP echo$row->businessHours; ?>
				</span><br>
			</p>
		</div>
		<div class="link_edit_del">
			<a href="<?php echo base_url().'frontend/product_buy_now/check_pickup_here/'.id_encrypt($cartId).'/'.id_encrypt($row->pickupId); ?>" class="button btn-delivery btn-disable">
				Pickup Here
			</a>
		</div>
	</div>												
<?php
	}
}
else
{
	echo 'No Pickup Center Available';
}
?>