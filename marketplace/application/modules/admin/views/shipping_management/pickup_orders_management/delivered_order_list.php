<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Delivered Order</a>
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
									<img src="<?php echo base_url().'images/picked_up.png'; ?>" class="img-responsive" style="display: inline-block;">
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
										<th width="5%">Date Of Delivery </th>
										<th width="3%">Order Id</th>
                                        <th width="10%">Product Name</th>
										<th width="2%">Tracking No.</th>
										<th width="4%">Retailer Name</th>	
										<th width="4%">Product Price</th>																	
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
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/order_picked_up/deliveredAjaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	ajax_function(urlLink,'#ajaxData'); 
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/order_picked_up/deliveredAjaxFun/'.$result['total']; ?>');
</script>