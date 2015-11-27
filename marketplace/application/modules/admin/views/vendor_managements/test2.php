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
			<ul class="breadcrumbs-alt">
        		<li>
					<a href="#">
						Shipping Rates List
					</a>
				</li>
                
				<li>
					<a href="javascript:void(0);" class="current">Add</a>
				</li>
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
          <div class="panel-body" style="padding:0px;">
		  		 <header class="panel-heading panel-heading1" style="padding-bottom: 15px;">Add Shipping Rate <a class="btn btn-warning btn-save pull-right"  href="<?php echo base_url(); ?>admin/vendor_management/test1" style="    margin-left: 10px;">Save</a><a href="<?php echo base_url(); ?>admin/vendor_management/test1" class="btn btn-danger btn-save pull-right">Cancel</a></header>
				 
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

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&shippingOrgId=<?php echo id_encrypt($shippingOrgId); ?>&dropshipCenter='+$('#dropshipCenter').val()+'&stateName='+$('#stateName').val()+'&areaName='+$('#areaName').val()+'&cityName='+$('#cityName').val()+'&weightFrom='+$('#weightFrom').val()+'&weightTo='+$('#weightTo').val()+'&eta='+$('#eta').val()+'&price='+$('#price').val();
	//console.log(postData);
	ajax_function(urlLink,'#ajaxData',postData); 
}

function ajax_search()
{
	if($("#dropshipCenter").val())
	{
		$("#dropshipCenter").css('width','98%');
		$("#dropshipCenter").css('background','white');
	}
	else
	{
		$("#dropshipCenter").css('width','');
		$("#dropshipCenter").css('background','');
	}
	
	if($("#stateName").val())
	{
		$("#stateName").css('width','98%');
		$("#stateName").css('background','white');
	}
	else
	{
		$("#stateName").css('width','');
		$("#stateName").css('background','');
	}
	
	if($("#areaName").val())
	{
		$("#areaName").css('width','98%');
		$("#areaName").css('background','white');
	}
	else
	{
		$("#areaName").css('width','');
		$("#areaName").css('background','');
	}
	
	if($("#cityName").val())
	{
		$("#cityName").css('width','98%');
		$("#cityName").css('background','white');
	}
	else
	{
		$("#cityName").css('width','');
		$("#cityName").css('background','');
	}
	
	if($("#weightFrom").val())
	{
		$("#weightFrom").css('width','98%');
		$("#weightFrom").css('background','white');
	}
	else
	{
		$("#weightFrom").css('width','');
		$("#weightFrom").css('background','');
	}
	
	if($("#weightTo").val())
	{
		$("#weightTo").css('width','98%');
		$("#weightTo").css('background','white');
	}
	else
	{
		$("#weightTo").css('width','');
		$("#weightTo").css('background','');
	}
	
	if($("#eta").val())
	{
		$("#eta").css('width','98%');
		$("#eta").css('background','white');
	}
	else
	{
		$("#eta").css('width','');
		$("#eta").css('background','');
	}
	
	if($("#price").val())
	{
		$("#price").css('width','98%');
		$("#price").css('background','white');
	}
	else
	{
		$("#price").css('width','');
		$("#price").css('background','');
	}
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shippingRatesAjaxFun/'.$result['total']; ?>');	
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shippingRatesAjaxFun/'.$result['total']; ?>');

function delete_rate(shippRateId)
{
	msg = 'Are you sure that you want to delete this rate?';
	redirect = "<?php echo base_url().$this->session->userdata('userType').'/vendor_management/delete_rate/'.id_encrypt($shippingOrgId); ?>/"+shippRateId;
	confirm_box(redirect,msg);	
}
</script>
<script type="text/javascript">
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