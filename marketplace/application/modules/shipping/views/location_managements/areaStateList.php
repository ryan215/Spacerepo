<select name="areaId" id="areaId" class="form-control selectpicker show-menu-arrow" data-live-search="true" onchange="city_list(this.value);">

	<option value="">Select Area</option>
	<?php
	if(!empty($areaList))
	{
		foreach($areaList as $row)
		{
	?>
	<option value="<?php echo $row->areaId; ?>" <?php if($areaId==$row->areaId){ ?> selected="selected" <?php } ?>>
		<?php echo $row->area; ?>
	</option>
	<?php
		}
	}
	?>
</select>