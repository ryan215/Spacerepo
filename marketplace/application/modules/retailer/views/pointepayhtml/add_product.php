<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<li><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/product_list">Product Management</a></li>
				<li><a href="javascript:void(0);" class="current">Add Product</a></li>
			</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
					
						<div class="panel-body">
							<section class="panel custom-panel" style="margin-bottom:0;">
									<div style="padding:0;" class="col-lg-12">
										<div class="col-sm-5 " style="padding: 0px;">									
											<div class="col-sm-3" style="padding-left:5px;">
											<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/add_masterproduct" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left;">
											<i class="fa fa-plus"></i> Add
										</a>
											</div>
																				
										</div>
										<div class="col-sm-7" style="padding-right:0px;">
											<div class="input-group m-bot15">
													<input type="text" placeholder="Enter Product Name" id="search" class="form-control">
													<span class="input-group-btn">
															<button class="btn btn-danger" type="button" onclick="ajaxPage();"><i class="fa fa-search"></i> Search</button>
														  </span>
											 </div>
										</div>
									</div>	
							</section>
							<section class="panel custom-panel" id="ajaxData">
							<div class="bs-example">
								<div class="panel-group" id="accordion">
							
								</div>
							</div>
							</section>
						</div>
                </section>
            </div>
              </div>
              <!--contant end-->
          </section>
      </section>