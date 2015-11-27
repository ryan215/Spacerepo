<?php
	if(!empty($catList))
	{
	?>
<select class="form-control" name="level2ID" id="level2ID" onchange="level3_list(this.value);">
	<option value="">Select Level-2</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level2ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>