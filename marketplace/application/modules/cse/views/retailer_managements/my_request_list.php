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
		  	<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">
		  		Retailer List
		  	</a> 
		  </li>
		  <li>
		  	<a href="javascript:void(0);" class="current">My Request List</a> 
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
				  	
				  		<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/addRetailer'; ?>" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left;"><i class="fa fa-plus"></i> 
							Add
						</a>
					
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
                    <th width="1%">S.no.</th>
                    <th width="17%"> Bussiness Name
                      <input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Business Name">
                    </th>
                   
                    <th width="17%"> Business Owner Name
                      <input type="text" class="form-control search table-head-search" id="businessOwnerName" onkeyup="ajax_search();" placeholder="Business Owner Name">
                    </th>
                    <th width="14%"> Bussiness Phone
                      <input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="Business Phone">
                    </th>
                    <th>
						Status
					</th>
                    <th width="1%">Action</th>
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
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&businessName='+$('#businessName').val()+'&businessPhone='+$('#businessPhone').val()+'&businessOwnerName='+$('#businessOwnerName').val();
	ajax_function(urlLink,'#ajaxData',postData); 
}

function ajax_search()
{
	if($("#businessName").val())
	{
		$("#businessName").css('width','98%');
		$("#businessName").css('background','white');
	}
	else
	{
		$("#businessName").css('width','');
		$("#businessName").css('background','');
	}
	
	if($("#businessPhone").val())
	{
		$("#businessPhone").css('width','98%');
		$("#businessPhone").css('background','white');
	}
	else
	{
		$("#businessPhone").css('width','');
		$("#businessPhone").css('background','');
	}
	
	if($("#businessOwnerName").val())
	{
		$("#businessOwnerName").css('width','98%');
		$("#businessOwnerName").css('background','white');
	}
	else
	{
		$("#businessOwnerName").css('width','');
		$("#businessOwnerName").css('background','');
	}
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/my_request_list/my_request_ajaxFun/'.$result['total']; ?>');	
}
ajax_search()

</script>
<style>

</style>
