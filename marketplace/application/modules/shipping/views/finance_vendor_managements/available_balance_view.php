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
 small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 100%;
}

</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_vendor_management'; ?>">
							Wallet
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Available balance</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
        	<div class="col-lg-12">
				<?php 
				$this->load->view('success_error_message'); 
				$this->load->view('finance_header_view'); 
				?>
				<section class="panel">
					<div class="panel-body">							
						<div class="col-lg-12 pd">
							<ul class="wallet_tab">
								<li>
									<a href="javascript:void(0);" title="Available balance" class="activetab" >
										Available balance
									</a>
								</li>
								<li>
									<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_vendor_management/processing_balance_view'; ?>" title="Current balance">
										Current balance
									</a>
								</li>
								<li>
									<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_vendor_management/balance_paid_view'; ?>" title="Paid balance">Paid balance</a>
								</li>
							</ul>
                        	
							<div class="clearfix"></div><br />
								<div class="table-responsive">
									<?php
									if(!empty($result['orderList']))
									{
										foreach($result['orderList'] as $row)
										{
									?>
									<table class="data-table order-tables-box">
										<thead>
											<tr><th colspan="5"><a class="btn btn-medium btn-orderid pull-left" style="cursor:inherit;"><?php echo $row['customOrderId']; ?></a>				
											<span class="pull-left" style="margin-top: 15px;right: 0px; position: relative;font-weight: normal;">Date: <strong><?php echo $row['lastModifiedDt']; ?>(WAT)</strong></span>
											 <h5 class="pull-right" style="margin-right:15px; margin-top: 14px;">Total Available balance : <span style="color:#E96A5E;top: 1px;position: relative; font-size:18px;"><strong>+
											 <?php echo '&#x20A6;'.number_format($row['totalShippingAmount'],2); ?>
											 </strong></span></h5>
											</th></tr>
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
												<td class="image" width="10%"><a class="product-image" title="<?php echo $productRow['productName']; ?>"><img src="<?php echo $imageUrl; ?>" height="70" width="70"></a></td>
												<td width="35%">
														<h4 class="product-name" style="margin-top:0px;">
														<?php echo $productRow['productName']; ?>
														</h4>
														<?php
													if($productRow['colorCode'])
													{
													?>
													<span>
														Color : 
															<a class="btn  btn-xs color_box active_color color_static" style="cursor:inherit; margin-left:0px;margin-top:0px; margin-right:0px;background-color:<?php echo $productRow['colorCode']; ?>"></a>
													</span>&nbsp;
													<?php
													}
													if($productRow['size'])
													{
													?>
													<span>Size : <?php echo $productRow['size']; ?></span>&nbsp;
													<?php
													}
													?>
													<span>Qty: <?php echo $productRow['quantity']; ?></span>
												</td>
												<td width="25%" style="vertical-align:top;">
													<h5>Status : <strong>
													<?php
													
														if($productRow['orderStatusId']==1)
														{
															echo 'New Order';
														}
														elseif($productRow['orderStatusId']==2)
														{
															echo 'Confirm Order';
														}
														elseif($productRow['orderStatusId']==3)
														{
															echo 'Ready to shipped Order';
														}
														elseif($productRow['orderStatusId']==4)
														{
															echo 'Shipped in transit Order';
														}
														elseif($productRow['orderStatusId']==5)
														{
															echo 'Delivered Order';
														}
													
													?>
													</strong></h5>
												</td>
												<td>
													
												</td>
												<td class="a-center last" style="vertical-align:top;">
												     <h5 class="pull-right">Retailer Payback Price : <span style="top: 1px;position: relative;"><strong>+<?php echo '&#x20A6;'.number_format($productRow['shippingAmount'],2); ?></strong></span></h5><div class="clearfix"></div>
													 
													
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
										echo 'Data Not Found';
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
.activetab { color:#000 !important; border-bottom:5px solid #78CD51;}
.wallet_tab li a:hover{ color:#666;}
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
</style>