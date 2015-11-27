	<!--footer start-->
    <footer class="site-footer">
		<div class="text-center">
        	<?php echo date('Y'); ?> &copy;  Marketplace.
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
<!--<script src="<?php //echo base_url(); ?>js/jquery.scrollTo.min.js"></script>
<script src="<?php //echo base_url(); ?>js/jquery.nicescroll.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>js/jquery.sparkline.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>js/owl.carousel.js" ></script>
<script src="<?php echo base_url(); ?>js/jquery.customSelect.min.js" ></script>
<script src="<?php echo base_url(); ?>js/respond.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>

<!--right slidebar-->
<script src="<?php echo base_url(); ?>js/slidebars.min.js"></script>

<!--common script for all pages-->
<script src="<?php echo base_url(); ?>js/common-scripts.js"></script>


<!--script for this page-->

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">

<script src="<?php echo base_url(); ?>js/count.js"></script>
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
			window.location.href = redirect;
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>
</body>
</html>