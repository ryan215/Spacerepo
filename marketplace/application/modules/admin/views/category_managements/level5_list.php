<?php
	if(!empty($catList))
	{
	?>
<select class="form-control" name="level5ID" id="level5ID" onchange="level6_list(this.value);">
	<option value="">Select Level-5</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level5ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>