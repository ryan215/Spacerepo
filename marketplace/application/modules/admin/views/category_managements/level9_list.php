<?php
	if(!empty($catList))
	{
	?>
<select class="form-control" name="level9ID" id="level9ID" onchange="level10_list(this.value);">
	<option value="">Select Level-9</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level9ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>