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
.table-choosen .bootstrap-select.btn-group:not(.input-group-btn), .bootstrap-select.btn-group[class*="span"]{margin-bottom:0 !important;
	height:28px !important;
}

.table-choosen .dropdown-toggle{height: 28px !important;
    line-height: 15px !important;
}
</style>

<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
      <div class="col-md-12">
        <ul class="breadcrumbs-alt">
           <li> <a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">Retailer List</a> </li>
		    <li> <a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/request_list'; ?>">Request List</a> </li>
		  <li> <a href="javascript:void(0);" class="current">History Request List</a> </li>
		  
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
          <?php $this->load->view('success_error_message'); ?>
          <div class="panel-body">
            <section class="panel custom-panel" style="margin-bottom:0;">
              <div class="col-lg-12" style="padding:0;">
                <div class="col-sm-5 " style="padding: 5px;">
                 	
					<div class="col-sm-10" style="padding-left:0px;">
                    <div class="col-sm-4" style="padding-left:0;">
                      <div class="form-group" >
                        <select class="selectpicker chosen-select form-control"  size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry">
                          <option value="10">10</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-5"  style="padding:0px;"><span class="records_per_page">Records Per Page</span></div>
                  </div>
                </div>
                <div class="col-sm-7 " style="padding: 5px;"> </div>
              </div>
            </section>
            <section class="table-responsive" id="unseen">
<table class="table table-invoice table-custom table-search-head" style="100%">
	<thead>
    	<tr>
        	<th width="2%">S.no.</th>
			<th width="17%"> Bussiness Name
            	<input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Business Name">
            </th>
			<th width="17%"> Business Owner Name
                      <input type="text" class="form-control search table-head-search" id="businessOwnerName" onkeyup="ajax_search();" placeholder="Business Owner Name">
                    </th>
			<th width="14%"> Bussiness Phone
            	<input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="Business Phone">
            </th>
           	<th width="14%"> Status
				<?php /*?> <input type="text" class="form-control search table-head-search" id="accountOwner" onkeyup="ajax_search();" placeholder="Account Owner Name"><?php */?>
			</th>
            <th width="14%">Date & Time</th>
           	<th width="3%">Action</th>
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
	<?php
	//if($this->session->userdata('userType')=='admin')
	{
	?>
	//postData+='&associationType='+$('#associationType').val()+'&userName='+$('#userName').val()+'&accountOwner='+$('#accountOwner').val();
	postData+='&userName='+$('#userName').val()+'&accountOwner='+$('#accountOwner').val();
	<?php
	}
	?>
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
	
	if($("#userName").val())
	{
		$("#userName").css('width','98%');
		$("#userName").css('background','white');
	}
	else
	{
		$("#userName").css('width','');
		$("#userName").css('background','');
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
	if($("#accountOwner").val())
	{
		$("#accountOwner").css('width','98%');
		$("#accountOwner").css('background','white');
	}
	else
	{
		$("#accountOwner").css('width','');
		$("#accountOwner").css('background','');
	}
	
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/retailer_management/requestHistoryAjaxFun/'.$result['total']; ?>');	
}
ajax_search()

</script>

<style>

</style>
