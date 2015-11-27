<select name="cityId" class="form-control selectpicker show-menu-arrow"  data-live-search="true" >
	<option value="">Select Area</option>
	<?php
	if(!empty($cityList))
	{
		foreach($cityList as $row)
		{
	?>
	<option value="<?php echo $row->zipId; ?>" <?php if($cityId==$row->zipId){ ?> selected="selected" <?php } ?>>
		<?php echo ucfirst($row->city); ?>
	</option>
	<?php
		}
	}
	?>
</select>