<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Ready To Be Shipped</a>
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
									
												<select class=" chosen-select form-control"  size="1" name="sel_no_entry" id="sel_no_entry" style="width:75px;display: inline-block;" onChange="ajax_search();">
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
									<img src="<?php echo base_url().'img/3.png'; ?>" class="img-responsive" style="display: inline-block;">
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
											<option value="4">Shipped / In Transit</option>
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
                        
						<section id="unseen" class="table-responsive">
							<table class="table table-invoice table-customm" style="margin-top:5px;">
								<thead>
									<tr>
										<!--<th width="1%"><input type="checkbox" id="selectall"></th>-->
										<th width="3%">S. No</th>
										<th width="5%">Date Of Order</th>
										<th width="5%">Order Id</th>
                                        <th width="7%">Product Name</th>
										<?php
									//	if($this->session->userdata('userType')=='admin')
										{
										?>
										<th width="8%">Tracking No.</th>
										<?php
										}
										?>
										<th width="8%">Retailer Name</th>																				
										<th width="2%">Select For Manifesto</th>
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
$('.selectpicker').selectpicker('show');
function generate_manifesto()
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/manifestolist'; ?>',
		data:'manifesto='+$('.manifesto_selection').serialize()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			var printWindow = window.open('', '','height=400,width=800');
				printWindow.document.write(result);
				printWindow.document.close();
				setTimeout(function () {
					printWindow.print();
				}, 500);
			return false;
		}
	});
	console.log();
}
function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/readyShippedAjaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData); 
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/readyShippedAjaxFun/'.$result['total']; ?>');

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
	text: 'Are You sure want to change ready to shipped order to Shipped/In Transit',   
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
				url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/change_status_bulk/'; ?>',
				data:$('.chkbx').serialize()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
				dataType:'json',
				success:function(result){
					if(result.success==1)
					{
						window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/shipped_in_transit'; ?>';
					}
					else
					{
						window.location.href = '<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped'; ?>';
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


function save_track_no(orderID,trackNo)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/save_track_no'; ?>',
		data:'order_id='+orderID+'&track_no='+trackNo+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/readyShippedAjaxFun/'.$result['total']; ?>');
		}
	});
}

function print_page(orderID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/print_page'; ?>',
		data:'order_id='+orderID+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			var printWindow = window.open('', '','height=400,width=800');
				printWindow.document.write(result);
				printWindow.document.close();
				setTimeout(function () {
					printWindow.print();
				}, 500);
			return false;
		}
	});
}

function auto_genrate(orderID)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/ready_to_shipped/auto_genrate'; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		success:function(result){
			$('#txtTrack'+orderID).val(result);
			save_track_no(orderID,result);
		}
	});
}
</script>