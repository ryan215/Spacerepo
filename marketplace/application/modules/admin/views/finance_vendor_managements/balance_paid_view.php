<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}
/*end of user detail page*/
</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_vendor_management/paid_balance'; ?>" class="">
							Shipping Vendors
						</a> 
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Shipping Vendor View
						</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 page-header  panel-heading1" style="margin-bottom:5px;">
						Shipping Vendor Detail
					</div>
					
					<div class="row state-overview">
					
                    	<aside class="col-lg-3">
                        	<center>
								<section class="panel">
									<div style="border: 1px solid #E5E5E5; border-radius:5px;display: inline-block; margin-top:8%; width:90%;">
										<div class="symbol red" style="width:100%; border-radius:5px 5px 0 0;padding: 5px;">
											<h2 style="font-size:2em; color:#fff;margin: 15px;">
												<?php echo '&#x20A6;'.number_format($result['totalAmount'],2); ?>
											</h2>
										</div>
										<div class="value" style="width:100%;">
											<h1 class="count" style="font-size:1.2em; padding:10px; color:#666;">
												Total Paid Balance
											</h1>
										</div>
									</div>
									<br /><br />
									
								</section>
							</center>
						</aside>
						<?php
						if(!empty($result['clearPayDetList']))
						{
							$i = 1;
							foreach($result['clearPayDetList'] as $initRow)
							{
						?>
						<div <?php if($i==1){ ?> class="col-lg-9" <?php }else{ ?> class="col-lg-3" <?php } ?>>
							<section class="panel">
								<header class="panel-heading">
									<strong>
										<?php 
										if($i==1)
										{
											echo 'Latest';
										}
										elseif($i==2)
										{
										}
										?>
										Paid Balance : 
											<span style="color:#E96A5E;">
												<?php echo '&#x20A6;'.number_format($initRow['clearAmount'],2); ?>
											</span>
									</strong>
									<?php 
									if($i==1)
									{ 
									?>
										<span class="pull-right" style="color:#78CD51;margin-top: -7px; font-size:1.5em;">
											<i class="fa fa-check-circle"></i>
										</span> 
									<?php 
									}
									else
									{
									}
									?>
								</header>
								<div class="panel-body">
									<div <?php if($i==1){ ?> class="bio-row-latest" <?php }else{ ?> class="bio-row" <?php } ?>>
										<p><span>Payment Initiate Date </span>: <?php echo $initRow['createDt']; ?></p>
									</div> 
									<div <?php if($i==1){ ?> class="bio-row-latest" <?php }else{ ?> class="bio-row" <?php } ?>>
										<p><span>Payment Confirm Date </span>: <?php echo $initRow['lastModifiedDt']; ?></p>
									</div> 
									<div <?php if($i==1){ ?> class="bio-row-latest" <?php }else{ ?> class="bio-row" <?php } ?>>
										<p><span>Bank Name </span>: <?php echo ucwords($initRow['bankName']); ?></p>
									</div>
									<div <?php if($i==1){ ?> class="bio-row-latest" <?php }else{ ?> class="bio-row" <?php } ?>>
										<p><span>Account Holder Name </span>: <?php echo ucwords($initRow['accountHolderName']); ?></p>
									</div>
									<div <?php if($i==1){ ?> class="bio-row-latest" <?php }else{ ?> class="bio-row" <?php } ?>>
										<p><span>Account Number </span>: <?php echo '**********'.substr($initRow['accountNumber'],-4); ?></p>
									</div>
									<div <?php if($i==1){ ?> class="bio-row-latest" <?php }else{ ?> class="bio-row" <?php } ?>>
										<p>
											<span>Transaction Reference No. </span>: <?php echo '**********'.substr($initRow['referenceNumber'],-4); ?>
										</p>
									</div>
								</div>
							</section>
						</div>
						<?php
								$i++;
							}
						}
						?>
						 					</div>
				</section>
				<section class="panel" style="display:inline-block; width:100%;">
                 <div class="col-sm-12">
                          <aside class="col-lg-4 padding_left_zero padding_right_zero">
							<section class="panel">
						    	<div class="panel-body bio-graph-info pd" style="padding-top:0px;">
                                	<table class="table table-invoice table-custom" style="margin-top:15px;">
						            	<thead>
						                	<tr>
												<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Business Information
												</th>
						                    </tr>
										</thead>                    
										<tbody>
 							            	<tr>
						                    	<td width="35%">Business Name: </td>
						                    	<td><?php echo ucwords($result['organizationName']); ?></td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Phone Number: </td>
						                            <td>
														<?php echo $result['businessPhoneCode'].$result['businessPhone']; ?>
													</td>
                         						</tr> 												 
											</tbody>
                    					</table>
                            	</div>
                        	</section>
                       	  </aside>
						  <aside class="col-lg-4 padding_left_zero padding_right_zero">
						  	<section class="panel">
						    	<div class="panel-body bio-graph-info pd" style="padding-top:0px;">
                                	<table class="table table-invoice table-custom" style="margin-top:15px;">
						            	<thead>
						                	<tr>
												<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Personal Information
												</th>
						                    </tr>
										</thead>
                    					<tbody>
											<tr>
						                    	<td width="35%">Name: </td>
						                    	<td>
													<?php echo ucwords($result['name']); ?>
												</td>
                        					</tr>
											<tr>
                        						<td width="35%">Email: </td>
						                        <td>
													<?php echo $result['email']; ?></td>
                         						</tr> 
											</tbody>
										</table>
									</div>
								</section>
							</aside>
						  <aside class="col-lg-4 padding_left_zero padding_right_zero">
								<section class="panel">
						        	<div class="panel-body bio-graph-info pd" style="padding-top:0px;">
										<table class="table table-invoice table-custom" style="margin-top:15px;">
						                	<thead>
						                    	<tr>
													<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
														Address
													</th>
						                    	</tr>
											</thead>
                    						<tbody>
 							                	<tr>
						                        	<td width="35%">State: </td>
													<td>
														<?php echo ucfirst($result['stateName']); ?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">Area: </td>
						                            <td>
														<?php echo ucfirst($result['areaName']); ?>
													</td>
						                         </tr>
												 
												 <tr>
						                         	<td width="35%">City: </td>
						                       	 	<td>
														<?php echo ucfirst($result['cityName']); ?>
													</td>
							                	</tr>
												<tr>
						                         	<td width="35%">Street: </td>
						                       	 	<td>
														<?php echo ucfirst($result['addressLine1']); ?>
													</td>
							                	</tr>
                      					</tbody>
                    				</table>
									
                            	</div>
                        	</section>
                       	  </aside>
                 </div>
                </section>
                <div class="clearfix"></div>
				<section class="panel">
					<div class="col-sm-12 page-header  panel-heading1" style="margin-bottom:5px;">Paid Balance </div>
					<div class="panel-body">							
						<div class="col-lg-12 pd">
                        	<div class="clearfix"></div><br>
							<div class="table-responsive">
								<?php
								if(!empty($result['orderList']))
								{
									foreach($result['orderList'] as $row)
									{
								?>
								<table class="data-table order-tables-box">
									<thead>
										<tr>
											<th colspan="5">
												<a class="btn btn-medium btn-orderid pull-left" style="cursor:inherit;">
													<?php echo $row['customOrderId']; ?>
												</a>
												<span class="pull-left" style="margin-top: 15px;right: 0px; position: relative;font-weight: normal;">
													Date: <strong>
															<?php echo $row['lastModifiedDt']; ?>(WAT)
														  </strong>
												</span>
												<h5 class="pull-right" style="margin-right:15px; margin-top: 14px;">
													Total Paid balance : 
													<span style="color:#E96A5E;top: 1px;position: relative; font-size:18px;">
														<strong>
															+<?php echo number_format($row['totalShippingAmount'],2); ?>														
														</strong>
													</span>
												</h5>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(!empty($row['productList']))
										{
											foreach($row['productList'] as $productRow)
											{
												$imageUrl = base_url().'img/no_image.jpg';
												if((!empty($productRow['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$productRow['imageName'])))
												{
													$imageUrl = base_url().'uploads/product/thumb500_500/'.$productRow['imageName'];
												}
												elseif((!empty($image->imageName))&&(file_exists('uploads/product/'.$productRow['imageName'])))
												{
													$imageUrl = base_url().'uploads/product/'.$productRow['imageName'];
												}
										?>
										<tr class="first odd">								  
											<td class="image" width="10%">
												<a class="product-image" title="<?php echo $productRow['productName']; ?>">
													<img src="<?php echo $imageUrl; ?>" height="70" width="70">
												</a>
											</td>
											<td width="35%">
												<h4 class="product-name" style="margin-top:0px;">
													<?php echo $productRow['productName']; ?>
												</h4>
												<?php
												if(!empty($productRow['colorCode']))
												{
												?>
												<span>
													Color : <a class="btn  btn-xs color_box active_color color_static" style="cursor:inherit; margin-left:0px;margin-top:0px; margin-right:0px;background-color:<?php echo $productRow['colorCode']; ?>"></a>
												</span>&nbsp;
												<?php
												}
												if(!empty($productRow['size']))
												{
												?>
												<span>Size : <?php echo $productRow['size']; ?></span>&nbsp;
												<?php
												}
												?>
												<span>Qty: <?php echo $productRow['quantity']; ?></span>
											</td>
											<td width="25%" style="vertical-align:top;">
												<h5>
													Status : <strong>Delivered Order</strong>
												</h5>
											</td>
											<td>
											</td>
											<td class="a-center last" style="vertical-align:top;">
												<?php
													if(!empty($productRow['shippingAmount']))
													{
													?>
												     <h5 class="pull-right">Balance : 
													 	<span style="color:#ff6c60; font-size:18px;top: 1px;position: relative;">
															<strong>+<?php echo '&#x20A6;'.number_format($productRow['shippingAmount'],2); ?></strong>
														</span><div class="clearfix"></div>
														<img src="<?php echo base_url(); ?>images/new_images/paid.png" width="15%" class="pull-right">
													</h5>
													<?php
													}
													?>
												<div class="clearfix"></div>
											</td>
										</tr>
										<?php	
											}
										}
										?>										
									</tbody>
								</table>
								<?php
									}
								}
								else
									{
										?>
										<div class="alert alert-warning fade in">Data Not Found</div>
										<?php
									}
								?>
							</div>	
						</div>
					</div>
				</section>
			</div>
		</div>
		<!--contant end-->
	</section>
</section> 
<!--main content end-->
<style>
.wallet_tab li{ list-style-type:none; float:left; margin-right:30px;}
.wallet_tab li a { color:#999; padding-bottom: 3px;    font-size: 1.3em;}
.activetab { color:#333 !important; border-bottom:5px solid #78CD51;}
.data-table {
    width: 100%;
    margin-bottom: 20px;
}

.data-table {
    border: 1px solid #E5E5E5;
    border-spacing: 0;
    text-align: left;
    font-size: 13px;
}
.data-table thead tr {
    background-color: #f7f7f7!important;
}
.btn-orderid {
    background: #78CD51;
    color: #fff;    margin: 10px;
    border: 1px solid #78CD51; 
}
.btn-orderid:hover{ color:#fff;}
.data-table tfoot {
    border-top: 1px solid #e9e9e9;
}
.data-table tfoot tr, .order-listmaindiv .data-table thead tr {
    background-color: #f9f9f9!important;
}
td{     padding: 15px;}
.color_static {
    padding: 8px;
    margin-left: 5px;
}
.btn-track {
    border: 1px solid #78CD51 ; color:#000;
}
.btn-track i {
    color: #78CD51;
}
.padding_left_zero{ padding-left:0px;}
.padding_right_zero{ padding-right:0px;}
.disable_btn{ background-color: #F3DF86;  border-color: #F3DF86;}
.disable_btn:hover{ background-color: #F3DF86;  border-color: #F3DF86;}
</style>