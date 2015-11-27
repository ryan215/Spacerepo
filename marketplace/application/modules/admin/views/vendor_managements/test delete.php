<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Search</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					?>  
                    <div class="panel-body">
                    	<section class="panel custom-panel">
							<div style="padding:0;" class="col-sm-12">
                            	<div class="col-sm-5 " style="padding: 5px;">
								 
									<div class="col-sm-4 col-lg-3" style="padding-left:0px;">
										<div class="form-group">    
                                            <select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
										</div>
									</div>
									<div class="col-lg-5 col-sm-6"  style="padding:0px;">
										   <span class="records_per_page">Records Per Page</span>
									</div>
                                </div>
								<div class="col-sm-7 " style="padding: 5px;">
								<div class="input-group m-bot15 " >
                                              <div class="input-group-btn ">
											  <div style="">
											  <select class="selectpicker chosen-select form-control" data-style="btn-success" name="sorting"  id="sorting" onchange="ajax_search();">
                                            <option value="">All</option>
											<option value="CustomerName">Customer Name</option>
                                        	<option value="OrderID">Order ID</option>
                                            <option value="TrackingID">Tracking ID</option>
                                            <option value="Customeremailid">Customer Email ID</option>
										</select></div>                                                 
                                              </div>
                                              <input class="form-control" type="search" style="width:100%; border-radius: 0px  5px 5px 0px !important; " onkeyup="ajax_search();" name="search" placeholder="Search" id="search">
                                          </div>
								</div>	
							</div>
                        </section>
                       <section id="unseen" class="table-responsive">
							<table class="table table-invoice table-customm" style="margin-top:5px;">
								<thead>
									<tr>
										<th width="2%">S. No</th>
										<th width="5%">Date Of Order</th>
										<th width="3%">Order Id</th>
                                        <th width="18%">Product Name</th>
										<th width="5%">Retailer Name</th>	
										<th width="5%">Product Price</th>
										<th width="8%">Action</th>
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
<script language="javascript" type="application/javascript">
$('.selectpicker').selectpicker('show');
</script>