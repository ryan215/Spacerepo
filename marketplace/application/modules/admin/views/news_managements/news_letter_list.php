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
          <li> <a href="javascript:void(0);" class="current">NewsLetter List</a> </li>
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
          <?php $this->load->view('success_error_message'); ?>
          <div class="panel-body">
            <section class="panel custom-panel" style="margin-bottom:0;">
              <div class="col-lg-12" style="padding:0;">
                <div class="col-sm-12 " style="padding: 5px;">
                  
                  <div class="col-sm-6" style="padding-left:0px;"> 
                    <div class="form-group" style="width:100px; float:left; margin-left:0px; margin-right:5px;">
                      <select class="selectpicker chosen-select form-control"  size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry" style="width:100px; !important">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                      </select>
                    </div>
                    <div class="col-sm-6"  style="padding-left:10px;"><span class="records_per_page">Records Per Page</span></div>
                  </div>
                  <div class="col-sm-6  text-right">
				  	<label>Total SignUp -  <?php echo $result['total']; ?>&nbsp; | &nbsp;      
					Total Verified - <?php echo $result['totalVerified']; ?>
				  </div>
                </div>
                
              </div>
            </section>
            <section class="table-responsive" id="unseen">
              <table class="table table-invoice table-custom table-search-head" style="100%">
                <thead>
                  <tr>
                    <th width="1%">S.no.</th>
                    <th width="12%">First Name</th>
                   	<th width="12%">Last Name</th>
                   	<th width="14%">Email</th>
					<th width="16%">State
					<input type="text" class="form-control search table-head-search" id="stateName" onkeyup="ajax_search();" placeholder="State">	
					</th>
					<th width="16%">Area
					<input type="text" class="form-control search table-head-search" id="areaName" onkeyup="ajax_search();" placeholder="Area">
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

function ajax_search()
{
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
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/news_management/ajaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'stateName='+$('#stateName').val()+'&areaName='+$('#areaName').val()+'&sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData); 
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/news_management/ajaxFun/'.$result['total']; ?>');
</script>
<style>
label{ background-image:none;}
</style>
