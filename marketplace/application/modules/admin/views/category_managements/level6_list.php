<?php
	if(!empty($catList))
	{
	?>
<select class="form-control" name="level6ID" id="level6ID" onchange="level7_list(this.value);">
	<option value="">Select Level-6</option>
	<?php
	if(!empty($catList))
	{			
		foreach($catList as $row)
		{
	?>
			<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$level6ID){ ?> selected="selected" <?php } ?>><?php echo $row->categoryCode; ?></option>
		<?php
		}
	}
	?>
</select>
<?php
}
?>