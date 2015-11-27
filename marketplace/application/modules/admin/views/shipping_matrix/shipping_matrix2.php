<style>
.btn-reqt{border:1px solid #ccc;
}

.notifi{position:absolute !important;
	top:-8px !important;
}

#header_notification_bar {
list-style-type: none !important;
float: left;
padding-left: 20px;
}
</style>


<!-- Modal -->

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url(); ?>admin/shipping_matrix/index1" class="current">Shipping Matrix</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
                	      
                    <div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0px;">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="col-sm-5 " style="padding: 5px;">
									
										
										<div class="col-sm-2 " style="padding-left:0px;">
										<a  style="float:left;" class="btn btn-round btn-success" href="<?php echo base_url(); ?>admin/shipping_matrix/index2">
											<i class="fa fa-plus"></i>&nbsp;Add
										</a>
										</div>
										
									<div class="col-sm-10" style="padding-left:0px;">
									<div class="col-sm-3">
										<div class="form-group" >    
                                            <select class="selectpicker chosen-select form-control"  size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry" style="width:75px;display: inline-block;">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
											 
                                      </div>
									  </div>
									  <div class="col-sm-5"  style="padding:0px;"><span class="records_per_page">Records Per Page</span></div>
									  </div>
									
                                </div>
                                							                      
                        	</div>
                        </section>
						<section class="panel custom-panel">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="col-sm-3 " style="padding: 5px;">
								<div class="input-group-btn">	
								<label style="background-image:none;">From (Select Warehouse)	</label>										
											<div style="">
											  <select class="selectpicker chosen-select" data-live-search="true" multiple data-style="btn-defalut" name="sorting"  id="sorting" onchange="ajax_search();">
													<option value="">Select Warehouse</option>
												  	<option value="">Demo</option>
												  	<option value="">Demo1</option>
													<option value="">Demo2</option>
													<option value="">Demo3</option>													
													<option value="">Demo4</option>
												</select>
											</div>                                                 
                                        </div>		                      
                        	</div>
								<div class="col-sm-3 " style="padding: 5px;">
								<div class="input-group-btn">
								<label style="background-image:none;">To (Select State)	</label>											
											<div style="">
											  <select class="selectpicker chosen-select" data-live-search="true" multiple show-menu-arrow data-style="btn-defalut" name="sorting"  id="sorting" onchange="ajax_search();">
													<option value="">Select State</option>
												  	<option value="">Demo</option>
												  	<option value="">Demo1</option>
													<option value="">Demo2</option>
													<option value="">Demo3</option>													
													<option value="">Demo4</option>
												</select>
											</div>                                                 
                                        </div>		                      
                        	</div>
								<div class="col-sm-3 " style="padding: 5px;">
								<div class="input-group-btn">	
								<label style="background-image:none;">Select City	</label>										
											<div style="">
											  <select class="selectpicker chosen-select" data-live-search="true" multiple data-style="btn-defalut" name="sorting"  id="sorting" onchange="ajax_search();">
													<option value="">Select City</option>
												  	<option value="">Demo</option>
												  	<option value="">Demo1</option>
													<option value="">Demo2</option>
													<option value="">Demo3</option>													
													<option value="">Demo4</option>
												</select>
											</div>                                                 
                                        </div>		                      
                        	</div>
								
							</div>
                        </section>
						<section class="table-responsive" id="unseen">
							<table class="table table-invoice table-custom " style="100%">
								<thead>
									<tr>
										<th width="8%">S.no.</th>
										<th>From</th>
										<th>State</th>
										<th>To</th>																				
										<th width="10%">Action</th>										 
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Demo</td>
										<td>Demo</td>
										<td>Demo</td>
										<td><a class="btn btn-round btn-success" type="button" href="<?php echo base_url(); ?>admin/shipping_matrix/index">View</a></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Demo</td>
										<td>Demo</td>
										<td>Demo</td>
										<td><a class="btn btn-round btn-success" type="button" href="<?php echo base_url(); ?>admin/shipping_matrix/index">View</a></td>
									</tr>
									<tr>
										<td>3</td>
										<td>Demo</td>
										<td>Demo</td>
										<td>Demo</td>
										<td><a class="btn btn-round btn-success" type="button" href="<?php echo base_url(); ?>admin/shipping_matrix/index">View</a></td>
									</tr>
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


</script>
<style>
.table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    overflow-x: scroll;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #DDD;
    -webkit-overflow-scrolling: touch;
}

</style>