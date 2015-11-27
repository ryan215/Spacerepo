<?php /*?><select name="stateId" id="stateId" class="form-control selectpicker show-menu-arrow" data-live-search="true" onchange="city_list(this.value);"><?php */?>
<select name="stateId" id="stateId" class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true" onchange="area_list(this.value);">
	<option value="">Select State</option>
	<?php
	if(!empty($stateList))
	{
		foreach($stateList as $row)
		{
	?>
	<option value="<?php echo $row->stateId; ?>" <?php if($stateId==$row->stateId){ ?> selected="selected" <?php } ?>>
		<?php echo ucwords($row->stateName); ?>
	</option>
	<?php
		}
	}
	?>
</select>