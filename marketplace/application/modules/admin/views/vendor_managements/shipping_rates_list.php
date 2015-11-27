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
					<a href="javascript:void(0);" class="current">Shipping Rates List</a>
				</li>
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
          <?php $this->load->view('success_error_message'); ?>
          <div class="panel-body">
            <section class="panel custom-panel" style="margin-bottom:0;">
              <div class="col-lg-12" style="padding:0;">
                <div class="col-sm-12 " style="padding: 5px;">
                  
                  <div class="col-sm-12" style="padding-left:0px;"> 
                 		<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/addShippingRates/'.id_encrypt($shippingOrgId); ?>" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left;"><i class="fa fa-plus"></i> 
							Add Shipping Rates
						</a>
                        <?php
						if($result['total'])
						{
						?>
                        <a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/addShippingRatesFrom10To30/'.id_encrypt($shippingOrgId); ?>" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left; margin-left:10px;">Shipping Rates FROM 10-50 KG
						</a>
                        <?php
						}
						?>
                    	<div class="form-group" style="width:100px; float:left; margin-left:50px; margin-right:5px;">
                      		<select class="selectpicker chosen-select form-control"  size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry" style="width:100px; !important">
		                        <option value="10">10</option>
		                        <option value="50">50</option>
		                        <option value="100">100</option>
	                      </select>
	                    </div>
	                    <div class=""  style="padding-left:10px;"><span class="records_per_page">Records Per Page</span></div>
	                  </div>
                  
                </div>
                
              </div>
            </section>
            <section class="table-responsive" id="unseen">
              <table class="table table-invoice table-custom table-search-head" style="100%">
                <thead>
                 <tr>
			<th width="5%">#</th>
			<th width="15%">
            	Dropship centre
                <input type="text" class="form-control search table-head-search" id="dropshipCenter" onkeyup="ajax_search();" placeholder="Dropship Center">
            </th>
			<th width="10%">
            	States
                <input type="text" class="form-control search table-head-search" id="stateName" onkeyup="ajax_search();" placeholder="States Covered">
            </th>
			<th width="10%">
            	Areas
                 <input type="text" class="form-control search table-head-search" id="areaName" onkeyup="ajax_search();" placeholder="Areas Covered">
            </th>
			<th width="10%">
            	Cities
                <input type="text" class="form-control search table-head-search" id="cityName" onkeyup="ajax_search();" placeholder="Cities Covered">
            </th>
			<th width="11%">
            	Wgt From<br />
                <input type="text" class="form-control search table-head-search" id="weightFrom" onkeyup="ajax_search();" placeholder="Weight From(in KG)">
            </th>
			<th width="9%">
            	Wgt To<br />
                <input type="text" class="form-control search table-head-search" id="weightTo" onkeyup="ajax_search();" placeholder="Weight To(in KG)">
            </th>
			<th width="8%">
            	Price
                 <input type="text" class="form-control search table-head-search" id="price" onkeyup="ajax_search();" placeholder="Price">
            </th>
			<th width="8%">
            	ETA<br />
                <input type="text" class="form-control search table-head-search" id="eta" onkeyup="ajax_search();" placeholder="ETA">
            </th>
			<!--<th width="1%">Edit</th>-->
			<th width="8%">Action</th>
		</tr>
                </thead>
                <tbody id="ajaxData">
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
<style>
.table-invoice thead tr th{ vertical-align:top !important;}
</style>