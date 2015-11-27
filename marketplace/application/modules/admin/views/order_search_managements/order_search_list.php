<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Search</a>
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
									<select class="form-control"  size="1" name="sel_no_entry" id="sel_no_entry" style="width:75px;display: inline-block;" onChange="ajax_search();">
										<option value="10">10</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>									 
									&nbsp;
									<span class="records_per_page" style="position:relative; top:-3px;">
										Records Per Page
									</span>
								</div>
								<div class="col-sm-7 " style="padding: 5px;"></div>
							</div>
						</section>
                        
						<section id="unseen" class="table-responsive">
							<table class="table table-invoice table-hover table-striped table-customm table-search-head">
								<thead>
									<tr>
										<th width="2%">S. No</th>
										<th width="10%">
											Order Details
											<select id="ordrDetDrp" class="form-control" onchange="ajax_search();" style="color:#333; margin-top:12px;">
												<option value="">All</option>
												<option value="dateTime">Date & Time</option>
												<option value="customOrderId">Order Id</option>
												<option value="orderType">Order Type</option>
												<option value="paymentMode">Payment Mode</option>		
											</select>
											<input type="text" class="form-control search table-head-search" id="ordrDetTxt" onkeyup="ajax_search();" placeholder="Order Details">
										</th>
										<th width="20%">
											Product Details
											<select id="prdDetDrp" onchange="ajax_search();" style="color:#333; margin-top:12px;" class="form-control">
												<option value="">All</option>
												<option value="name">Name</option>
												<!--<option value="price">Price</option>-->												
											</select>
											<input type="text" class="form-control search table-head-search" id="prdDetTxt" onkeyup="ajax_search();" placeholder="Product Details">
										</th>
                                        <th width="16%">
											Retailer Details
											<select id="retDetDrp" onchange="ajax_search();" style="color:#333; margin-top:12px;" class="form-control">
												<option value="">All</option>
												<option value="name">Name</option>
												<option value="phone">Phone</option>												
											</select>
											<input type="text" class="form-control search table-head-search" id="retDetTxt" onkeyup="ajax_search();" placeholder="Retailer Details">
                                            
										</th>
										
										<th width="20%" style="padding:4 !important">
											Customer Details
											<select id="cusDetDrp" class="form-control" onchange="ajax_search();" style="color:#333; margin-top:12px;">
												<option value="">All</option>
												<option value="name">Name</option>
												<option value="phone">Phone</option>
												<option value="state">State</option>
												<option value="area">Area</option>
												<option value="city">City</option>
											</select>
											<input type="text" class="form-control search table-head-search" id="cusDetTxt" onkeyup="ajax_search();" placeholder="Customer Details">
										</th>
										<th width="16%" style="padding:4 !important">
											Order Status
											<select id="orderStatus" class="form-control" onchange="ajax_search();"  style="margin-top:12px;">
												<option value="">All</option>
												<option value="1">New Order</option>
												<option value="2">New Pickup Order</option>
												<option value="3">Confirm Order</option>
												<option value="4">Confirm Pickup Order</option>
												<option value="5">Ready To Be Shipped Order</option>
												<option value="6">Ready To Be Pickup Order</option>
												<option value="7">Shipped In Transit Order</option>
												<option value="8">Delivered Order</option>
												<option value="9">Picked Up Order</option>
												<option value="10">Cancel Order</option>
											</select>
										</th>
										<th width="10%">
											Dropship Centre
											<input type="text" class="form-control search table-head-search" id="dropship" onkeyup="ajax_search();" placeholder="Dropship Center">
										</th>
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
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/order_search_management/ajax_order_search_list'; ?>');
}

function ajaxPage(urlLink)
{	
	if($("#dropship").val())
	{
		$("#dropship").css('width','98%');
		$("#dropship").css('background','white');
	}
	else
	{
		$("#dropship").css('width','');
		$("#dropship").css('background','');
	}
	
	if($("#cusDetTxt").val())
	{
		$("#cusDetTxt").css('width','98%');
		$("#cusDetTxt").css('background','white');
	}
	else
	{
		$("#cusDetTxt").css('width','');
		$("#cusDetTxt").css('background','');
	}
	
	if($("#retDetTxt").val())
	{
		$("#retDetTxt").css('width','98%');
		$("#retDetTxt").css('background','white');
	}
	else
	{
		$("#retDetTxt").css('width','');
		$("#retDetTxt").css('background','');
	}
	
	if($("#prdDetTxt").val())
	{
		$("#prdDetTxt").css('width','98%');
		$("#prdDetTxt").css('background','white');
	}
	else
	{
		$("#prdDetTxt").css('width','');
		$("#prdDetTxt").css('background','');
	}
	
	if($("#ordrDetTxt").val())
	{
		$("#ordrDetTxt").css('width','98%');
		$("#ordrDetTxt").css('background','white');
	}
	else
	{
		$("#ordrDetTxt").css('width','');
		$("#ordrDetTxt").css('background','');
	}
		
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&dropship='+$("#dropship").val()+'&orderStatus='+$("#orderStatus").val()+'&cusDetDrp='+$("#cusDetDrp").val()+'&cusDetTxt='+$("#cusDetTxt").val()+'&retDetDrp='+$("#retDetDrp").val()+'&retDetTxt='+$("#retDetTxt").val()+'&prdDetDrp='+$("#prdDetDrp").val()+'&prdDetTxt='+$("#prdDetTxt").val()+'&ordrDetDrp='+$("#ordrDetDrp").val()+'&ordrDetTxt='+$("#ordrDetTxt").val();
	$.ajax({
		type: "POST",
		url:urlLink,
		data:postData,
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/order_search_management/ajax_order_search_list'; ?>');
</script>



<style>
.table-invoice thead tr th{padding-right:4px;
	padding-bottom:6px;
}
</style>