
<div class="col-sm-6 pull-left check-avl-city" style="padding-top:0; padding-left:0;">
<select name="cityId" class="form-control selectpicker show-menu-arrow"  data-live-search="true" id="cityId" onchange="show_btn();">
	<option value="">City</option>
	<?php
	if(!empty($cityList))
	{
		foreach($cityList as $row)
		{
	?>
	<option value="<?php echo $row->zipId; ?>" <?php if($cityId==$row->zipId){ ?> selected="selected" <?php } ?>>
		<?php echo ucfirst($row->city); ?>
	</option>
	<?php
		}
	}
	?>
</select>
<?php
if(!empty($cityList))
{
?>
</div>
<div class="col-sm-6 check pull-left available-btndiv" id="checkAvlBtn" style="display:none; padding-top:0; padding-left:0;">
	<a onclick="check_avaibility();"  class="button btn check-aval_btn" title="Check" type="button" href="javascript:void(0);">
		<span>
			Check Avaibility
		</span>
	</a>
</div>
<?php
}
?>