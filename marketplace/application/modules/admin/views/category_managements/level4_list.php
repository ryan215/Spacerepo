<?php
	if(!empty($catList))
	{
	?>
<select class="form-control" name="level4ID" id="level4ID" onchange="level5_list(this.value);">
	<option value="">Select Level-4</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level4ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>