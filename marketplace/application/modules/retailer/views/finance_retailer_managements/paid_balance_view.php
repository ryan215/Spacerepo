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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_retailer_management'; ?>">Wallet</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Paid balance</a>
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
									<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_retailer_management'; ?>" title="Available balance">
										Available balance
									</a>
								</li>
								<li>
									<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_retailer_management/ledger_balance_view'; ?>" title="Current balance">
										Current balance
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" class="activetab" title="Paid balance">Paid balance</a>
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
										<tr>
											<th colspan="5">
												<a class="btn btn-medium btn-orderid pull-left" style="cursor:inherit;">
													<?php echo $row['customOrderId']; ?>
												</a>				
												<span class="pull-left" style="margin-top: 15px;right: 0px; position: relative;font-weight: normal;">
													Date: <strong>
													
														<?php echo $row['lastModifiedDt']; ?>
													(WAT)</strong>
												</span>
												<h5 class="pull-right" style="margin-right:15px; margin-top: 14px;">
													Total Paid balance : 
													<span style="color:#E96A5E;top: 1px;position: relative; font-size:18px;">
														<strong>+
															<?php echo '&#x20A6;'.number_format($row['totalRetailerAmount'],2); ?>
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
												elseif((!empty($productRow['imageName']))&&(file_exists('uploads/product/'.$productRow['imageName'])))
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
											<td width="25%"  style="vertical-align:top;">
												<h5 class="pull-left">
													Transaction id : 
													<span style="font-size:16px;top: 1px;position: relative;">
														<strong>
															<?php echo '********'.substr($productRow['referenceNumber'],-4); ?>
														</strong>
													</span>
												</h5>
												<div class="clearfix"></div>
												<img src="<?php echo base_url(); ?>images/new_images/paid.png" width="15%" class="pull-left" style="margin-top:8px; margin-left:5px;"  />
													  						 
											</td>
											<td width="45%" style="vertical-align:top;">
												<h5 class="pull-left">Initiate payment Date & Time:  
													<span style="font-size:16px;top: 1px;position: relative;">
														<strong>
															<?php echo $productRow['initiateAmtDt']; ?>(WAT)
														</strong>
													</span>
												</h5>
												<div class="clearfix"></div>
												<h5 class="pull-left">Amount clear Date & Time:  
													<span style="font-size:16px;top: 1px;position: relative;">
														<strong>
															<?php echo $productRow['clearAmtDt']; ?>(WAT)
														</strong>
													</span>
												</h5>
											</td>
											<td>
											</td>
											<td class="a-center last" style="vertical-align:top;">
												<h5 class="pull-right">Balance : 
													<span style="color:#E96A5E; font-size:18px;top: 1px;position: relative;">
														<strong>
															<?php echo '&#x20A6;'.number_format($productRow['totalRetailAmount'],2); ?>
														</strong>
													</span>
												</h5>
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