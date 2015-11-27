<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">New Orders</a>
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
									
												<select class="form-control"  size="1" name="sel_no_entry" id="sel_no_entry" style=" width:75px;display: inline-block;" onChange="ajax_search();">
													<option value="10">10</option>
													<option value="50">50</option>
													<option value="100">100</option>
												</select>									 
										  
										
											<span class="records_per_page" style="position:relative; top:-3px;"> Records Per Page</span>
										
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
									<img src="<?php echo base_url().'img/1.png'; ?>" class="img-responsive" style="display: inline-block;">
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
										<th width="5%">S. No</th>
										<th width="10%">Date Of Order</th>
										<th width="3%">Order Id</th>
                                        <th width="18%">Product Name</th>
										<th width="5%">Retailer Name</th>	
										<th width="5%">Product Price</th>
										<th width="20%">Customer Details</th>
										<th width="5%">Dropship centre </th>
										<th width="1%">Action</th>
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

function accept_decline(order_id,acpt_decl)
{
	if(confirm('Are you sure want to change status?'))
	{
		window.location.href = '<?php echo base_url().'retailer/new_order/accept_decline/';?>'+order_id+'/'+acpt_decl;
	}
	return false;
}
/*function send_to_other(order_id)
{
	if(confirm('Are your sure want to send to other retailer'))
	{
		window.location.href = '<?php //echo base_url().'admin/new_order/send_to_other_retailers/'; ?>'+order_id;
	}
	return false;
}*/

function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/new_order/new_order_ajax/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{		
	postData = 'sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData); 
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/new_order/new_order_ajax/'.$result['total']; ?>');
</script>