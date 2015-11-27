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
						<a href="javascript:void(0);" class="current">
							Pointe Force
						</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
        	<div class="col-lg-12">
				<?php $this->load->view('success_error_message'); ?>
				<?php $this->load->view('admin/finance_pointe_force_managements/finance_management_header'); ?>
				<section class="panel">
					<div class="panel-body">							
						<div class="col-lg-12 pd">
							<ul class="wallet_tab">
								<li>
									<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_pointe_force_management'; ?>" title="Available">
										Available Balance
									</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="activetab" title="Processing">
										Processing Balance
									</a>
								</li>
								<li>
									<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_pointe_force_management/paid_balance'; ?>" title="Paid">
										Paid Balance
									</a>
								</li>
							</ul>
							<div class="clearfix"></div><br />
							
							<div class="table-responsive">
								<?php
								if(!empty($result))
								{
									foreach($result as $row)
									{
								?>
								<table class="data-table order-tables-box">
									<thead>
										<tr>
											<th colspan="5">											
												<h5 class="pull-right" style="margin:0px;">
													<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_pointe_force_management/balance_processing_view/'.id_encrypt($row['customerId']); ?>" class="btn btn-medium btn-success  pull-left">
														View
													</a>
													<a href="<?php echo base_url().$this->session->userdata('userType').'/finance_pointe_force_management/reference_number/'.id_encrypt($row['customerId']).'/'.id_encrypt($row['financePointefIniPayId']); ?>" class="btn btn-medium btn-warning pull-left">
														Confirm Payment
													</a>
												</h5>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr class="first odd">								  
											<td class="image" width="5%">
												<a class="product-image padding_right_zero" title="Joy Links Baby Diapers">
													<img src="<?php echo base_url(); ?>images/new_images/vendor_icon.png" style="" title="Pointe Force">
												</a>
											</td>
											<td width="25%" class="padding_right_zero product_list_sec">
												<h4 class="product-name" style="margin-top:0px;">
													<?php echo ucwords($row['name']); ?>
												</h4>
												<p>
													<strong>Email</strong> : <?php echo $row['email']; ?>
												</p>
												<p>
													<strong>Phone No.</strong> : +234-<?php echo $row['phone']; ?>
												</p>
												</td>
												<td width="42%" class="padding_right_zero product_user_sec">
												<table>
													<tr>
													<td class="pd"  style="padding-right:10px; vertical-align:top;">
															<h5><strong>Address : </strong></h5>
														</td> 
													<td class="pd" ><h5 style="line-height:20px;">
															<?php
															if(!empty($row['addressLine1']))
															{
																echo ucwords($row['addressLine1']);
															}
															if(!empty($row['cityName']))
															{
																echo ','.ucwords($row['cityName']);
															}
															if(!empty($row['areaName']))
															{
																echo ','.ucwords($row['areaName']);
															}
															if(!empty($row['stateName']))
															{
																echo ','.ucwords($row['stateName']);
															}
															if(!empty($row['countryName']))
															{
																echo ','.ucwords($row['countryName']);
															}
															?>
														
													</h5>
													</td>
													</tr>
												</table>
												</td>
												<td width="28%" class="a-center last product_user_sec" style="vertical-align:top;">
													<h5 class="pull-right text-right">
														Processing Price : 
														<span  class="ava_price" >
															<strong>
																<?php echo '&#x20A6;'.number_format($row['totalCustomPointeForceAmount'],2); ?>
															</strong>
														</span>
													</h5>
													<div class="clearfix"></div>
												</td>
											</tr>
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
.btn{ margin:10px;}
.padding_right_zero{ padding-right:0px;}
.padding_left_zero{ padding-left:0px;}
.product_list_sec p{ font-size:12px; }
.product_user_sec h5{ font-size:12px; }
.ava_price{color:#E96A5E; font-size:18px;top: 3px;position: relative; } 

</style>