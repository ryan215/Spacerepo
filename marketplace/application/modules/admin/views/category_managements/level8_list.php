<?php
	if(!empty($catList))
	{
	?>
	
<select class="form-control" name="level8ID" id="level8ID" onchange="level9_list(this.value);">
	<option value="">Select Level-8</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level8ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>