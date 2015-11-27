<?php /*?><link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/datetimepicker/jquery.datetimepicker.css"/>
<style type="text/css">

.custom-date-style {
	background-color: red !important;
}

</style>
<script src="<?php echo base_url(); ?>js/datetimepicker/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/datetimepicker/jquery.datetimepicker.js"></script>
<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Shipped/In Tranist</a>
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
							<div style="max-width:700px; margin:0 auto; padding-bottom:25px;">
								<Center>
									<img src="<?php echo base_url().'img/4.png'; ?>" class="img-responsive" style="display: inline-block;">
								</center>
							</div>
							<?php
							}
							?>
								
							<div class="col-lg-12" style="padding:0;">
								<!--<div class="col-sm-6 " style="padding: 5px; ">
									<div class="col-sm-3" style="padding:0;">
										<h5 style="line-height: 10px;  font-size: 1em;text-transform: uppercase;">
											Change Status
										</h5>
									</div>
									<div class="col-sm-5"  style="padding-left:0px;">
										<select class="selectpicker chosen-select form-control" name=""  style="display: inline-block;">	
											<option value="5">Delivered</option>
										</select>		 
									</div>
									<div class="col-sm-3"  style="padding:0px;">
										<button class="btn btn-success" onclick="ready_to_shipped();">
											Submit
										</button>
									</div>			 
								</div>-->
							</div>
						</section>
                        
						<section id="unseen">
							<div class="table-responsive">	
							<table class="table table-invoice table-customm " style="margin-top:5px;">
								<thead>
									<tr>
										<!--<th width="1%"><input type="checkbox" id="selectall"></th>-->
										<th width="4%">S. No</th>
										<th width="5%">Date Of Order</th>
										<th width="5%">Order Id</th>
                                        <th width="10%">Product Name</th>
										<th width="8%">Tracking No.</th>
										<th width="10%">Delivered Date</th>
										<th width="10%">Retailer Name</th>
										<th width="10%">Product Price</th>
										<th width="3%">Action</th>
									</tr>
								</thead>
								<tbody id="ajaxData">
									
								</tbody>
							</table>
							</div>
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
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit/transitAjaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData); 
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit/transitAjaxFun/'.$result['total']; ?>');

$("#selectall").click(function(){	
	var checkAll = $("#selectall").prop('checked');
    if(checkAll){
        $(".chkbx").prop("checked",true);
    }else{
		$(".chkbx").prop("checked",false);
    }
});

function ready_to_shipped()
{
	swal({   
	title: '',   
	text: 'Are You sure want to change Shipped/In Transit To Deliver Order',   
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
				url:'<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit/change_status_bulk/'; ?>',
				data:$('.chkbx').serialize()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
				dataType:'json',
				success:function(result){
					if(result.success==1)
					{
						window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/delivered_order'; ?>';
					}
					else
					{
						window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit'; ?>';
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

function save_delivered_date(orderID,delivrdDate)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit/save_delivered_date'; ?>',
		data:'order_id='+orderID+'&delivered_date='+delivrdDate+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit/transitAjaxFun/'.$result['total']; ?>');
		}
	});
} 
</script>