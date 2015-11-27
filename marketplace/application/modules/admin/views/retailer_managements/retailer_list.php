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
          <li> <a href="javascript:void(0);" class="current">Retailer List</a> </li>
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
				  	
				  		
					<?php
					if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
					{
					?>
					<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/addRetailer'; ?>" class="btn btn-sm btn-shadow btn-success hvr-push" style="float:left;"><i class="fa fa-plus"></i> 
							Add
						</a>
                    	<div class="dropdown" id="header_notification_bar"> 
							<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/request_list'; ?>" class="btn btn-white btn-reqt"> Request <span class="badge bg-warning notifi"> <?php echo $result['totalReq']; ?> </span> 
						</a> 
						</div>
					<?php
					}																			
					?>
					<?php
					if($this->session->userdata('userType')=='cse')
					{/*
					?>
                    	<div class="dropdown" id="header_notification_bar"> 
							<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/my_request_list'; ?>" class="btn btn-white btn-reqt">
								My Request								
							</a> 
						</div>
					<?php
					*/}																			
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
                    <th width="1%">S.no.</th>
                    <?php
			if($this->session->userdata('userType')=='admin')
			{/*
			?>
            <th width="12%" colspan="2" class="table-choosen" style="padding:1px 5px !important;">
				<select class="form-control" style="background: #94c359; color:#fff !important; border:none;" id="associationType" onchange="ajax_search();">
					<option value="">Platform</option>
					<option value="1">Pointemart</option>
					<option value="2">PointePay</option>
					<option value="3">Both</option>
				</select>
				
				
			</th>
			<?php
			*/}
			?>
                    <th width="17%"> Bussiness Name
                      <input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Business Name">
                    </th>
                   
                    <th width="17%"> Business Owner Name
                      <input type="text" class="form-control search table-head-search" id="businessOwnerName" onkeyup="ajax_search();" placeholder="Business Owner Name">
                    </th>
                    <?php
			
			
			if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
			{
			?>
                    <th width="14%"> Account Owner
                       <input type="text" class="form-control search table-head-search" id="accountOwner" onkeyup="ajax_search();" placeholder="Account Owner Name">
                    </th>
                    <?php /*?> <th>
            	User Name
                <input type="text" class="form-control search table-head-search" id="userName" onkeyup="ajax_search();" placeholder="User Name">
            </th><?php */?>
                    <?php
			}
			?>
                    <th width="14%"> Bussiness Phone
                      <input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="+234">
                    </th>
                    <?php						
					if($this->session->userdata('userType')=='cse')
					{
					?>
                    <th width="17%">Area
                      <input type="text" class="form-control search table-head-search" id="cityName" onkeyup="ajax_search();" placeholder="Area Name">
                    </th>
                    <?php
					}
					?>
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
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&businessName='+$('#businessName').val()+'&businessPhone='+$('#businessPhone').val()+'&businessOwnerName='+$('#businessOwnerName').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
	<?php
	if(($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='superadmin'))
	{
	?>
	postData+='&userName='+$('#userName').val()+'&accountOwner='+$('#accountOwner').val();
	<?php
	}
	if($this->session->userdata('userType')=='cse')
	{
	?>
	postData+='&cityName='+$('#cityName').val();
	<?php
	}
	?>
	$.ajax({
		type: "POST",
		url:urlLink,
		data:postData,
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});
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
	
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/retailer_management/ajaxFun/'.$result['total']; ?>');	
}
ajax_search()

</script>