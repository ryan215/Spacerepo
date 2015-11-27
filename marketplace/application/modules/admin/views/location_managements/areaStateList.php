<select name="areaId" id="areaId" class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true" onchange="city_list(this.value);">

	<option value="">Area</option>
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