
<div class="modal fade" id="modal-success-error" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog model_right">
        <div class="modal-content">
		 <?php
				if($this->session->flashdata('success'))
				{
				?>
            <div class="modal-header isa_success" style="margin:0px;	">
            <a class="close" data-dismiss="modal" aria-hidden="true" style="    font-size: 8px;    position: relative;    top: -3px;"><i class="fa fa-times"></i></a>
          <?php
				 echo $this->session->flashdata('success');
				 ?>
				 </div>
				 <?php 
				}
				elseif($this->session->flashdata('error'))
				{
				?>
            <div class="modal-header isa_error" style="margin:0px;	">
            <a class="close" data-dismiss="modal" aria-hidden="true" style="    font-size: 8px;    position: relative;    top: -3px;"><i class="fa fa-times"></i></a>
          <?php
				echo $this->session->flashdata('error'); 
				?>	
            </div>
			<?php
			}
				?>
            
            
    </div>
  </div>
</div>


<?php
if($this->session->flashdata('success'))
{
?>
<script type="text/javascript">
	jQuery('#modal-success-error').modal('show');
</script>
<?php
}
elseif($this->session->flashdata('error'))
{
?>
<script type="text/javascript">
	jQuery('#modal-success-error').modal('show');
</script>
<?php
}
?> 