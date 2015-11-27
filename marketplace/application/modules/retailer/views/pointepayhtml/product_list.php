<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		 

  
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
						<li><a href="javascript:void(0);" class="current">Product Management</a></li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
                	<div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0;">
							<div style="padding:0;" class="col-lg-12">
                				<div class="col-sm-7 " style="padding: 5px;">
										<div class="col-sm-1 col-lg-1" style="padding-left:0px;"> 
										<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/add_product" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left;">
											<i class="fa fa-plus"></i> Add
										</a>
										</div>
									<div class="col-sm-2 col-lg-2">
				                    	<div class="form-group">
											<select class="selectpicker form-control" data-style="btn-success" name="" onchange="" id="" style="width:75px;display: inline-block;">
												<option value="10">10</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
										</div>
									</div>
                  					<div class="col-sm-6 col-lg-5" style="padding:0px;"> <span class="records_per_page">Records Per Page</span> </div>
                				</div>
              				</div>	
                        </section>
                              <section id="unseen">
                              	<table class="table table-invoice table-hover table-striped table-customm table-search-head">
									<thead>
								   		<tr>
								        	<th width="5%">S.No.</th>
								            <th width="10%">Product Image</th>
											<th width="30%">Product Name
											<input type="text" class="form-control search table-head-search" id="productName" onkeyup="ajax_search();" placeholder="Product Name">
											</th>
								            <th width="30%">Product Category
											<input type="text" class="form-control search table-head-search" id="productCategory" onkeyup="ajax_search();" placeholder="Product Category">
											</th>
											<th width="5%">Action</th>											
										</tr>
								    </thead>
								    <tbody id="ajaxData">
									<tr>
										<td>1</td>
										<td><img src="<?php echo  base_url();  ?>uploads/product/3450669760.jpg" height="70" width="70"></td>
										<td> Bee Honey Back Pack</td>
										<td>Bag Packs</td>														
										<td><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/product_details" class="btn btn-warning btn-xs tooltips" title="View details"><i class="fa fa-eye"></i></a></td>		
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
<link href="<?php echo base_url(); ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />	
<script>
$('.selectpicker').selectpicker();	
</script>	  