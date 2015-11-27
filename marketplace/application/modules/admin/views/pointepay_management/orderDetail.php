<section id="main-content">
 <section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					 <li> <a href="card_reader_list.html" class="">Card Reader &amp; Accessories</a> </li>
		   			 <li> <a href="card_reader_order_list.html" class="">Order list</a> </li>
					 <li> <a href="javascript:void(0);" class="current">View</a> </li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel" style="width:100%;  display: inline-block;">
                	<div class="col-sm-12 panel-heading panel-heading1" style="height:48px;">Order Detail
					</div>
					<div class="row">							
                            <aside class="profile-info col-lg-12" style="  display: inline-flex;  padding-top: 20px;"><br>
								<aside class="profile-nav col-lg-3 col-md-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<img class="tag-img-pp-pm" src="<?php echo base_url();?>images/pointepay-tag.png"><a class="example-image-link" data-lightbox="example-1" href="images/default_user_image.jpg"><img src="images/default_user_image.jpg" class="example-image"></a>
										<h1></h1>
                                      </div><br>
									  <div class="clearfix"></div>
									  <div class="col-sm-12"><p class="text-center"><!--<strong>Reference No.</strong> : 87266531313<br>-->
									  <strong>Subscription Plan</strong> : Lite
									  </p></div>
                                  </section>
                              </aside>
								<aside class="profile-info col-lg-9">
								
                            	<!--<section class="panel">
                                	<div class="col-sm-12">
										<div class="col-sm-12 " style="padding:0 5px;">
											<div class="pull-right"><span style="top: 12px; position: relative;">Status: </span> <span class="label label-success tooltips" title="" data-original-title="Refercence No. 78729513131" style="top: 12px; position: relative;">Verified</span></div>
											<a href="add_reatiler_form.html" class="btn btn-primary pull-right" type="button" style="margin-left:20px;"><i class="fa fa-pencil"></i> Edit</a>										  
								             <a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onClick="dropship();">Blocked</a>
										</div>
                                    </div>
								</section>-->
								
								<section class="panel">
                                	<!--<div class="col-sm-12" style="padding:0 20px 0 0;">
                                    	
                                    </div>-->
						        	<div class="panel-body bio-graph-info">
                                    	
										<table class="table table-invoice table-custom" style="margin-top:0px;">
						                	<thead>
						                    	<tr><th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Personal Information
												</th>
						                    </tr></thead>                    
											<tbody>
 							                   	<tr>
						                        	<td width="35%">First Name : </td>
						                            <td><?php echo $orderDetail->firstName;?> </td>
                        						</tr>
												<tr>
						                        	<td width="35%">last Name : </td>
						                            <td><?php echo $orderDetail->lastName;?></td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Phone Number : </td>
						                            <td><?php echo $orderDetail->phone;?></td>
                         						</tr> 
                        						<tr>
                        							<td width="35%">Email : </td>
						                            <td><?php echo $orderDetail->email;?></td>
                         						</tr> 
                      					</tbody>
                    				</table>
                            	</div>
                        	</section>
								
							 </aside>
                        </aside>
							
                	</div>
					
            	</section>
				<section class="panel">
				<div class="col-sm-12 panel-heading panel-heading1" style="height:48px;">Product Details
					</div>
				<div class="panel-body">
					<div class="col-sm-12 pd">
							<section class="table-responsive" id="unseen">
							  <table class="table table-invoice table-custom table-search-head" style="100%">
								<thead>
								  <tr>
									<th width="1%">S.No.</th>
									<th width="5%">Image</th>
									<th width="17%">Product Name
									  <input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Business Name">
									</th>
									<th width="17%">Product Type</th>
									<th width="17%"> Category
									  <input type="text" class="form-control search table-head-search" id="businessOwnerName" onkeyup="ajax_search();" placeholder="Business Owner Name">
									</th>
									<th width="14%"> Price
									  <input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="+234">
									</th>
									
									
								  </tr>
								</thead>
								<tbody>
								<?php
								$i=1;
								//echo $this->db->last_query();
								//print_r($productaccessoriesList);
								foreach($productList as $productdetail)
								{
									?>
									<tr>
									<td><?php echo $i;?></td>
									<td><img src="<?php echo base_url();?>images/product/s5.png" width="100%"></td>
									<td><?php echo $productdetail->subscriptionProductCode;?></td>
									<td>Products</td>
									<td>card And Pin Reader</td>
									<td>&#x20A6;<?php echo $productdetail->productPrice;?></td>	
									
								</tr>
								
									<?php
									$i++;
								}
								
								foreach($accessoriesList as $accessoriesdetail)
								{
									?>
									<tr>
									<td><?php echo $i;?></td>
									<td><img src="<?php echo base_url();?>images/product/s5.png" width="100%"></td>
									<td><?php echo $accessoriesdetail->accessoriesCode;?></td>
									<td>Accessories</td>
									<td>Android phone</td>
									<td>&#x20A6;<?php echo $accessoriesdetail->accessoriesPrice;?></td>	
									
								</tr>
								
									<?php
									$i++;
								}
								?>
								
								</tbody>
							  </table>
           					</section>
							</div>
				</div>			
				</section>			
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>