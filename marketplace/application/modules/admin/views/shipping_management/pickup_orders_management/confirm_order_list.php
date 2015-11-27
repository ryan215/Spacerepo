<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Confirmation Order</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="col-lg-12">
				<section class="panel">
					<div class="panel-body">
						<section class="panel custom-panel">
							<div class="col-lg-12" style="padding:0;">
								<div class="col-sm-5 " style="padding: 5px;">				
									
												<select class=" chosen-select form-control"  size="1" name="sel_no_entry" id="sel_no_entry" style=" width:75px;display: inline-block;" onChange="ajax_search();">
													<option value="10">10</option>
													<option value="50">50</option>
													<option value="100">100</option>
												</select>									 
										  
										&nbsp;
											<span class="records_per_page" style="position:relative; top:-3px;">Records Per Page</span>
										
									</div>
								
								
								<div class="col-sm-7 " style="padding: 5px;">
									
								</div>
								
							</div>
							<?php
							if($this->session->userdata('userType')=='admin')
							{
							?>
							<div style="max-width:500px; margin:0 auto; padding-bottom:25px;">
								<Center>
									<img src="<?php echo base_url().'images/pickup_confirm_order.png'; ?>" class="img-responsive" style="display: inline-block;">
								</center>
							</div>
							<?php
							}
							?>
							
                        </section>
                        
						<section id="unseen" class="table-responsive">
							<table class="table table-invoice table-customm" style="margin-top:5px;">
								<thead>
									<tr>
									<th width="2%">S. No</th>
										<th width="5%">Date Of Order</th>
										<th width="5%">Order Id</th>
                                        <th width="20%">Product Name</th>
										<th width="10%">Retailer Name</th>
										<th width="5%">Product Price</th>
										<th width="2%">Action</th>
									</tr>
								</thead>
								<tbody id="ajaxData">
									
								</tbody>
							</table>
                        </section>
					</div>
				</section>
			</div>
		</div>
		<!--contant end-->
	</section>
</section>
<!--main content end-->

<script type="text/javascript">

function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/confirmationOrderAjaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData); 
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/confirmationOrderAjaxFun/'.$result['total']; ?>');

function ready_to_shipped()
{
	swal({   
	title: '',   
	text: 'Are You sure want to change new order to ready to shipped',   
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
			$.ajax({
				type: "POST",
				url:'<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order/change_new_order_to_ready_bulk/'; ?>',
				data:$('.chkbx').serialize()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
				dataType:'json',
				success:function(result){
					if(result.success==1)
					{
						window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order'; ?>';
					}
					else
					{
						window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/confirm_pickup_order'; ?>';
					}
				}
			});
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}

</script>
<script language="javascript">
$("#selectall").click(function(){	
	var checkAll = $("#selectall").prop('checked');
    if(checkAll){
        $(".chkbx").prop("checked",true);
    }else{
		$(".chkbx").prop("checked",false);
    }
});
</script>