	<!--footer start-->
    <footer class="site-footer">
		<div class="text-center">
             <?php echo date('Y'); ?> &copy;  Spacepointe
            <a href="#" class="go-top">
            	<i class="fa fa-angle-up"></i>
        	</a>
    	</div>
    </footer>
	<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>js/chosen.jquery.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.scrollTo.min.js"></script>
<?php /*?><script src="<?php echo base_url(); ?>js/jquery.nicescroll.js" type="text/javascript"></script><?php */?>
<script src="<?php echo base_url(); ?>js/jquery.sparkline.js" type="text/javascript"></script>
<!--<script src="<?php //echo base_url(); ?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>-->
<?php /*?><script src="<?php echo base_url(); ?>js/owl.carousel.js" ></script><?php */?>
<script src="<?php echo base_url(); ?>js/jquery.customSelect.min.js" ></script>
<script src="<?php echo base_url(); ?>js/respond.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>

<!--right slidebar-->
<?php /*?><script src="<?php echo base_url(); ?>js/slidebars.min.js"></script><?php */?>

<!--common script for all pages-->
<script src="<?php echo base_url(); ?>js/common-scripts.js"></script>




<!--script for this page-->
<?php /*?><script src="<?php echo base_url(); ?>js/sparkline-chart.js"></script>
<script src="<?php echo base_url(); ?>js/easy-pie-chart.js"></script><?php */?>
<?php /*?><script src="<?php echo base_url(); ?>js/count.js"></script><?php */?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
<script type="text/javascript">
function confirm_box(redirect,msg)
{
	swal({   
	title: '',   
	text: msg,   
	//type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			if(redirect!='')
			{
				window.location.href = redirect;				
			}
			else
			{
				swal("Success","", "success");
			
			}
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>

<script>
  <?php /*?>$("#sidebar").niceScroll({styler:"fb",cursorcolor:"#404040", cursorwidth: '1px', cursorborderradius: '2px', spacebarenabled:false, cursorborder: ''});<?php */?>

</script>

<style>
.nicescroll-rails div{background:#35404d !important; width:2px !important; }
</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/lightbox/lightbox.css">
<script src="<?php echo base_url(); ?>js/lightbox/lightbox.js"></script>
</body>
</html>