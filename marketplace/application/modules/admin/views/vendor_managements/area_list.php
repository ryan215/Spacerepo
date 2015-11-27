<div class="col-sm-4">
	<label for="countryName" style="float:left; line-height:33px;">
		Select Area
	</label>&nbsp;&nbsp;
	<span class="error">*</span>
</div>
<div class="col-sm-8 padding_left_zero">
<?php
if(!empty($areaList))
{
	$areaIdArr = explode(',',$areaId);
	foreach($areaList as $row)
	{
	?>
		<div class="col-sm-4 padding_left_zero">
			<div class="checkbox c-checkbox" style="padding-bottom: 10px;padding-top: 5px;">
				<label>
					<input type="checkbox" value="<?php echo $row->areaId; ?>"  name="areaId[]" <?php if(!empty($areaIdArr)){ if(in_array($row->areaId,$areaIdArr)){?> checked="checked"<?php }}?>>
					<span class="fa fa-check"></span>&nbsp;
					<?php echo $row->area; ?>
				</label>
			</div>
		</div>
	<?php
	}
	echo $areaErr;
}
else
{
	echo 'Data not found';
}
?>
</div>