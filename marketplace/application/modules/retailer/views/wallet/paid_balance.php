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
						<a href="javascript:void(0);" class="">Wallet</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Paid balance</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
        	<div class="col-lg-12">
				<?php $this->load->view('success_error_message'); ?>
				<div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue"  style="background-color:#78CD51;">
                              <i class="fa fa-usser">&#8358;</i>
                          </div>
                          <div class="value">
                              <h1 class="count">
                                  2,52,222
                              </h1>
                              <p>Available balance</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                             <i class="fa fa-usser">&#8358;</i>
                          </div>
                          <div class="value">
                              <h1 class=" count2">
                                  750
                              </h1>
                              <p>Current balance</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                             <i class="fa fa-usser">&#8358;</i>
                          </div>
                          <div class="value">
                              <h1 class=" count2">
                                  18,000
                              </h1>
                              <p>Paid balance</p>
                          </div>
                      </section>
                  </div>
              </div>
            	<section class="panel">
					<div class="panel-body">							
						<div class="col-lg-12 pd">
                        	<ul class="wallet_tab">
								<li><a href="<?php echo base_url(); ?>retailer/wallet/history" class="" title="All">&nbsp;&nbsp;All&nbsp;&nbsp;</a></li>
								<li><a href="<?php echo base_url(); ?>retailer/wallet"  title="Available balance">Available balance</a></li>
								<li><a href="<?php echo base_url(); ?>retailer/wallet/ledger_balance" title="Current balance">Current balance</a></li>
								<li><a href="javascript:void(0)" class="activetab" title="Paid balance">Paid balance</a></li>
								
							</ul>
							<div class="clearfix"></div><br />
								<div class="table-responsive">
									<table class="data-table order-tables-box">
										<thead>
											<tr><th colspan="5"><!--<a class="btn btn-medium btn-orderid" style="cursor:inherit;">OD1000002279</a>--><p class="pull-right" style=" padding:5px;margin-top: 5px;right: 15px; position: relative;font-weight: normal;">Date: <strong>2015-09-30 15:12:53(WAT)</strong></p></th></tr>
										</thead>
										<tbody>
												<tr class="first odd">								  
												<td class="image" width="10%"><a class="product-image" title="Joy Links Baby Diapers"><img src="<?php echo base_url(); ?>images/new_images/paid_bg.png" height="70" width="70"></a></td>
												<td width="25%"  style="vertical-align:top;">
													  
													  <h5 class="pull-left">Transaction id : <span style="font-size:16px;top: 1px;position: relative;"><strong>549284983131</strong></span></h5><div class="clearfix"></div>
													 <img src="<?php echo base_url(); ?>images/new_images/paid.png" width="15%" class="pull-left" style="margin-top:8px; margin-left:5px;"  />
													  						 
												</td>
												<td width="45%" style="vertical-align:top;">
													<h5 class="pull-left">Initiate payment Date & Time:  <span style="font-size:16px;top: 1px;position: relative;"><strong>2015-09-30 15:12:53(WAT)</strong></span></h5><div class="clearfix"></div>
													<h5 class="pull-left">Amount clear Date & Time:  <span style="font-size:16px;top: 1px;position: relative;"><strong>2015-10-03 01:12:00(WAT)</strong></span></h5>
													
												</td>
												<td>
													
												</td>
												<td class="a-center last" style="vertical-align:top;">
												     <h5 class="pull-right">Balance : <span style="color:#E96A5E; font-size:18px;top: 1px;position: relative;"><strong>&#8358;250</strong></span></h5>
													 
													
												</td>
												</tr>
										</tbody>
									</table>
									<table class="data-table order-tables-box">
										<thead>
											<tr><th colspan="5"><!--<a class="btn btn-medium btn-orderid" style="cursor:inherit;">OD1000002279</a>--><p class="pull-right" style=" padding:5px;margin-top: 5px;right: 15px; position: relative;font-weight: normal;">Date: <strong>2015-09-30 15:12:53(WAT)</strong></p></th></tr>
										</thead>
										<tbody>
												<tr class="first odd">								  
												<td class="image" width="10%"><a class="product-image" title="Joy Links Baby Diapers"><img src="<?php echo base_url(); ?>images/new_images/processing_bg.png" height="70" width="70"></a></td>
												<td width="25%"  style="vertical-align:top;">
													  <img src="<?php echo base_url(); ?>images/new_images/processing.png" width="35%" class="pull-left" style="margin-top:8px; margin-left:5px;"  />
													
												</td>
												<td width="45%" style="vertical-align:top;">
													
													<h5 class="pull-left">Initiate payment Date & Time:  <span style="font-size:16px;top: 1px;position: relative;"><strong>2015-09-30 15:12:53(WAT)</strong></span></h5><div class="clearfix"></div>
												</td>
												<td>
													
												</td>
												<td class="a-center last" style="vertical-align:top;">
												
												     <h5 class="pull-right">Balance : <span style="color:#E96A5E; font-size:18px;top: 1px;position: relative;"><strong>&#8358;250</strong></span></h5>
													 
													
												</td>
												</tr>
										</tbody>
									</table>
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