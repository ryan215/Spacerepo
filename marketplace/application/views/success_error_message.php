<?php
if($this->session->flashdata('success'))
{
?>
	<div class="isa_success text-center">
		<i class="fa fa-check" style="padding: 10px;line-height: 16px; margin:0; font-size:15px;"></i>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
<?php
}
elseif($this->session->flashdata('error'))
{
?>
	<div class="isa_error text-center">
		 <i class="fa fa-times-circle" style="padding: 10px;line-height: 16px; margin:0; font-size:15px;"></i>
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php
}
if($this->session->flashdata('successNews'))
{
?>
	<div class="isa_success text-center">
		<i class="fa fa-check" style="padding: 10px;line-height: 16px; margin:0; font-size:15px;"></i>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
<?php
}
?> 

