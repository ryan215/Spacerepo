<style>
.btn-reqt {
	border: 1px solid #ccc;
}
.notifi {
	position: absolute !important;
	top: -8px !important;
}
#header_notification_bar {
	list-style-type: none !important;
	float: left;
	padding-left: 20px;
}
.table-choosen .bootstrap-select.btn-group:not(.input-group-btn), .bootstrap-select.btn-group[class*="span"] {
	margin-bottom: 0 !important;
	height: 28px !important;
}
.table-choosen .dropdown-toggle {
	height: 28px !important;
	line-height: 15px !important;
}
</style>

<section id="main-content">
	<section class="wrapper"> 
    	<!--contant start-->
    	<div class="row">
      		<div class="col-lg-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management'; ?>">
							Shipping Vendor List
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($shippingOrgId); ?>">
							View
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId); ?>">
							Shipping Rates List
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/add_shipping_rate/'.id_encrypt($shippingOrgId); ?>">
							Add Rate List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Add
						</a>
					</li>
				</ul>
      		</div>
			
      		<div class="col-lg-12">
        		<section class="panel">
					<?php $this->load->view('success_error_message'); ?>
					<div class="panel-body" style="padding:0px;">
		  		 		<header class="panel-heading panel-heading1" style="padding-bottom: 15px;">
							Add Shipping Rate
							<a class="btn btn-warning btn-save pull-right" href="" style="margin-left: 10px;">
								Save
							</a>
							<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/add_shipping_rate/'.id_encrypt($shippingOrgId); ?>" class="btn btn-danger btn-save pull-right">
								Cancel
							</a>
						</header>
					</div>
					
					<div class="panel-body">
            			<div class="alert alert-info fade in">
                        	You need to enter the weight range, price and estimated time of delivery for each area you have selected, kindly cross check the same as you enter the values.
						</div>
						<section class="table-responsive" id="unseen">
							<table class="table table-invoice table-custom table-search-head" style="100%">
                <thead>
                 <tr>
			<th width="1%">S.No.</th>
			<th width="8%">
            	Dropship Center<br />
            </th>
			<th width="8%">
            	State<br />
            </th>
			<th width="8%">
            	Area<br />
            </th>
			<th width="11%">
            	Wgt From <span data-toggle="tooltip" data-original-title="Weight From kg" class="pull-right"><i class="fa fa-question-circle"></i></span><br />
            </th>
			<th width="11%">
            	Wgt To <span data-toggle="tooltip" data-original-title="Weight To kg" class="pull-right"><i class="fa fa-question-circle"></i></span><br />
            </th>
			<th width="11%">
            	Price 
            </th>
			<th width="11%">
            	ETA<br />
            </th>
			<!--<th width="1%">Edit</th>-->
			<th width="5%"></th>
		</tr>
                </thead>
                <tbody id="ajaxData">
				<tr>
					<td>1</td>
					<td>NEW BENIN1</td>
					<td>Abia</td>
					<td>Demo</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left ">kg</span></div>
					</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right">&#x20A6;</span><input type="text" class="form-control"></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right"><i class="fa fa-clock-o"></i></span><input type="text" class="form-control"></div></td>
					<td><a class="btn btn-success btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Add" type="button" href="#"><i class="fa fa-check"></i></a>
					<a class="btn btn-danger btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Delete" type="button" href="#"><i class="fa fa-trash-o"></i></a></td>
				</tr>
				<tr>
					<td>2</td>
					<td>NEW BENIN1</td>
					<td>Abia</td>
					<td>Demo1</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div>
					</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right">&#x20A6;</span><input type="text" class="form-control"></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right"><i class="fa fa-clock-o"></i></span><input type="text" class="form-control"></div></td>
					<td><a class="btn btn-success btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Add" type="button" href="#"><i class="fa fa-check"></i></a>
					<a class="btn btn-danger btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Delete" type="button" href="#"><i class="fa fa-trash-o"></i></a></td>
				</tr>
                </tbody>
              </table>
           				</section>
						<section class="table-responsive" id="unseen">
							<table class="table table-invoice table-custom table-search-head" style="100%">
                <thead>
                 <tr>
			<th width="1%">S.No.</th>
			<th width="8%">
            	Dropship Center<br />
            </th>
			<th width="8%">
            	State<br />
            </th>
			<th width="8%">
            	Area<br />
            </th>
			<th width="11%">
            	Wgt From <span data-toggle="tooltip" data-original-title="Weight From kg" class="pull-right"><i class="fa fa-question-circle"></i></span><br />
            </th>
			<th width="11%">
            	Wgt To <span data-toggle="tooltip" data-original-title="Weight To kg" class="pull-right"><i class="fa fa-question-circle"></i></span><br />
            </th>
			<th width="11%">
            	Price
            </th>
			<th width="11%">
            	ETA<br />
            </th>
			<!--<th width="1%">Edit</th>-->
			<th width="5%"></th>
		</tr>
                </thead>
                <tbody id="ajaxData">
				<tr>
					<td>1</td>
					<td>IKOTA1</td>
					<td>Abia</td>
					<td>Demo</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div>
					</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right">&#x20A6;</span><input type="text" class="form-control"></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right"><i class="fa fa-clock-o"></i></span><input type="text" class="form-control"></div></td>
					<td><a class="btn btn-success btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Add" type="button" href="#"><i class="fa fa-check"></i></a>
					<a class="btn btn-danger btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Delete" type="button" href="#"><i class="fa fa-trash-o"></i></a></td>
				</tr>
				<tr>
					<td>2</td>
					<td>IKOTA1</td>
					<td>Abia</td>
					<td>Demo1</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div>
					</td>
					<td><div class="input-group m-bot15"><input type="text" class="form-control"><span class="input-group-addon left">kg</span></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right">&#x20A6;</span><input type="text" class="form-control"></div></td>
					<td><div class="input-group m-bot15"><span class="input-group-addon right"><i class="fa fa-clock-o"></i></span><input type="text" class="form-control"></div></td>
					<td><a class="btn btn-success btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Add" type="button" href="#"><i class="fa fa-check"></i></a>
					<a class="btn btn-danger btn-xs tooltips" data-toggle="tooltip" data-placement="top" data-original-title="Delete" type="button" href="#"><i class="fa fa-trash-o"></i></a></td>
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
<!--main content end--> 

<script type="text/javascript">
$('.selectpicker').selectpicker('show');

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'bottom'
    });
});
</script>
<style>
.table-invoice thead tr th{ vertical-align:top !important;}
.left{ 
	left: -6px;
    position: relative;
}
.right{ 
	left: 5px;
    position: relative;
}
</style>