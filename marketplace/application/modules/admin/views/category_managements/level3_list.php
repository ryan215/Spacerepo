<?php
	if(!empty($catList))
	{
	?>
	
<select class="form-control" name="level3ID" id="level3ID" onchange="level4_list(this.value);">
	<option value="">Select Level-3</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level3ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>