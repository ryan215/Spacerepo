<div class="clearfix"></div><br />
<?php
if(!empty($catList))
{
?>
	<div class="col-sm-5 col-lg-5 pd">
		<label for="level<?php echo $nextLevel; ?>" style="float:left; line-height:33px;">
			Select Category Level<?php echo $nextLevel; ?>
		</label>
	</div>	
	<div class="col-sm-7 col-sm-7 padding_left_zero pd">
		<select class="form-control" name="level<?php echo $nextLevel; ?>" onchange="cat_list(this.value,'<?php echo $nextToNextLevel; ?>');" id="catLevel<?php echo $nextLevel; ?>">
			<option value="">Select Category</option>
			<?php
			foreach($catList as $row)
			{
			?>
			<option value="<?php echo $row->categoryId; ?>">
				<?php echo $row->categoryCode; ?>
			</option>
			<?php													
			}
		?>
		</select>
	</div>
	<div id="level<?php echo $nextToNextLevel; ?>"></div>
<?php
}
?>