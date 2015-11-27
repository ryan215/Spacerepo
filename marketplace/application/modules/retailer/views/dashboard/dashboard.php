<script type="text/javascript">
	$(document).ready(function(){
		<?php if($this->session->flashdata('show_popup')){
			$this->session->set_userdata('show_popup',0);
			?>
	$('#myModal').modal('show');
		<?php }?>
});
</script>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="top:30%;">
    <div class="model-header">
      <button type="button" class="close-popup-icon" data-dismiss="modal" aria-label="Close" style="border:0; background:none;"><span aria-hidden="true"><img width="30px" height="30px" src="<?php echo base_url(); ?>img/close.png"></span></button>
    </div>
    <div class="modal-content newlatter-content"> <img class="conget-img" src="<?php echo base_url(); ?>img/tag-popup.png">
      <div class="modal-body newlatter-popup">
        <h2> Congratulations!</h2>
        <h5>Hi <?php echo $this->session->flashdata('show_popup');?></h5>
        <p>Thanks for completing the verification process. Your request to sell on this platform has been received. We will respond to your request shortly. 
		</p>
        <p>Thanks</p>
        <p style="margin-bottom:2px; font-size:16px;">Spacepointe Team</p>
      
        
      </div>
    </div>
  </div>
</div>

<style>
.conget-img {
	bottom: -1%;
	position: absolute;
	right: -1%;
	width: 16%;
}
.newlatter-popup h2 {
	color: #7bc470;
	font-size: 24px;
	margin-top: 10px;
	margin-bottom: 15px;
	font-weight: bold;
}
.newlatter-popup h5 { font-weight:bold; }
.newlatter-popup p{ font-weight:normal;}
.newlatter-content {
	border-bottom: 6px solid #F86072;
	border-radius: 0 !important;
}
.change-message {
	font-size: 16px;
}
.close-popup-icon {
	position: absolute;
	right: -13px;
	top: -8px;
	z-index: 9999;
}

</style>