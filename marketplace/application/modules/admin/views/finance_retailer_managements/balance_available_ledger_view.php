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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_retailer_management'; ?>">
							Retailer
						</a> 
					</li>
		  			<li> 
						<a href="javascript:void(0);" class="current">Retailer View</a> 
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 page-header  panel-heading1" style="margin-bottom:5px;">Retailer Detail</div>
					<div class="row state-overview">
                          <aside class="col-lg-3">
                            	<center>
								<section class="panel">
										<div style="border: 1px solid #E5E5E5; border-radius:5px;display: inline-block; margin-top:5%; width:90%;">	
											  <div class="symbol red" style="width:100%; border-radius:5px 5px 0 0;padding: 5px;">
												 <h2 style="font-size:2em; color:#fff;margin: 15px;">
												  	<?php echo '&#x20A6;'.number_format($result['totalAvailableRetailerAmount'],2); ?>
												  </h2>
											  </div>
											  <div class="value" style="width:100%;">
												  <h1 class="count" style="font-size:1.2em; padding:10px; color:#666;">
													  Available balance
												  </h1>
												 
											  </div>
										 </div>
								<br /><br />
                      			</section>
								<section class="panel">
										 <div style="border: 1px solid #E5E5E5; border-radius:5px;display: inline-block; margin-top:5%; width:90%;">	
											  <div class="symbol red" style="width:100%; border-radius:5px 5px 0 0;padding: 5px;">
												  <h2 style="font-size:2em; color:#fff;margin: 15px;">
												  	<?php echo '&#x20A6;'.number_format($result['totalLedgerRetailerAmount'],2); ?>
												  </h2>
											  </div>
											  <div class="value" style="width:100%;">
												    <h1 class="count" style="font-size:1.2em; padding:10px; color:#666;">
													  Ledger balance
												  </h1>
												 
											  </div>
										 </div>
                      			</section>
								</center>
                              </aside>
<aside class="col-lg-3 padding_left_zero padding_right_zero">
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
						<td width="35%">Business Name : </td>
						<td>
							<?php echo $result['organizationName']; ?>
						</td>
					</tr>
                    <tr>
                    	<td width="35%">Phone Number : </td>
						<td>
							<?php echo '+234'.$result['phone']; ?>
						</td>
                    </tr>
					<tr>
                    	<td width="35%">Dropship Centre : </td>
						<td>
							<?php echo $result['dropCenterName']; ?>
						</td>
                    </tr>                         						
				</tbody>
			</table>
		</div>
	</section>
</aside>

<aside class="col-lg-3  padding_left_zero padding_right_zero">
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
						<td width="35%">User Name : </td>
						<td>
							<?php echo $result['userName']; ?>
						</td>
                    </tr>
					<tr>
						<td width="35%">First Name : </td>
						<td>
							<?php echo $result['firstName']; ?>
						</td>
					</tr>
					<tr>
						<td width="35%">Middle Name: </td>
						<td>
							<?php echo $result['middle']; ?>
						</td>
					</tr>
					<tr>
						<td width="35%">Last Name: </td>
						<td>
							<?php echo $result['lastName']; ?>
						</td>
					</tr>
					<tr>
                    	<td width="35%">Email : </td>
						<td>
							<?php echo $result['email']; ?>
						</td>
                    </tr> 
				</tbody>
			</table>
		</div>
	</section>
</aside>

<aside class="col-lg-3 padding_left_zero ">
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
						<td width="35%">State  : </td>
						<td>
							<?php echo $result['stateName']; ?>
						</td>
					</tr>
					<tr>
						<td width="35%">Area  : </td>
						<td>
							<?php echo $result['areaName']; ?>
						</td>
					</tr>
					<tr>
						<td width="35%">City  : </td>
						<td>
							<?php echo $result['cityName']; ?>
						</td>
					</tr>
					<tr>
						<td width="35%">Street : </td>
						<td>
							<?php echo $result['addressLine1']; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
</aside>

</div>
					
</section>

<section class="panel">
	<div class="panel-body">							
		<div class="col-lg-12 pd">
        	<ul class="wallet_tab">
				<li>
					<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_retailer_management/balance_available_view/'.id_encrypt($organizationId); ?>" title="Available balance">
						Available balance
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" title="Ledger balance" class="activetab" >
						Ledger balance
					</a>
				</li>
			</ul>
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
														<?php echo $row['lastModifiedDt']; ?>
													(WAT)</strong>
										</span>
										<h5 class="pull-right" style="margin-right:15px; margin-top: 14px;">
											Total Ledger balance : 
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
										<h5>Status : <strong>
											<?php
											if($productRow['isPickup'])
											{												
												if($productRow['orderStatusId']==1)
												{
													echo 'New Pickup Order';
												}
												elseif($productRow['orderStatusId']==2)
												{
													echo 'Confirm Pickup Order';
												}
												elseif($productRow['orderStatusId']==3)
												{
													echo 'Pickup to ready order';
												}
												elseif($productRow['orderStatusId']==5)
												{
													echo 'Pickuped Order';
												}
											}
											else
											{
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
													echo 'Ready To Be Shipped Order';
												}
												elseif($productRow['orderStatusId']==4)
												{
													echo 'Shipped in transit Order';
												}
												elseif($productRow['orderStatusId']==5)
												{
													echo 'Delivered Order';
												}
											}
											?>
										</strong></h5>
									</td>
									<td>
									</td>
									<td class="a-center last" style="vertical-align:top;">
										<h5 class="pull-right">Retailer Payback Price : 
											<span style="top: 1px;position: relative;"><strong>+
												<?php echo '&#x20A6;'.number_format($productRow['totalRetailAmount'],2); ?>
											</strong>
											</span>
										</h5><div class="clearfix"></div>
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
</style>