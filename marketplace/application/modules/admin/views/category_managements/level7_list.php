<?php
	if(!empty($catList))
	{
	?>
<select class="form-control" name="level7ID" id="level7ID" onchange="level8_list(this.value);">
	<option value="">Select Level-7</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level7ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>