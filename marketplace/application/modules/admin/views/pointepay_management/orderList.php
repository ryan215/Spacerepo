<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
      <div class="col-lg-12">
        <ul class="breadcrumbs-alt">
          <li> <a href="javascript:void(0);" class="">Card Reader &amp; Accessories</a> </li>
		   <li> <a href="javascript:void(0);" class="current">Order list</a> </li>
        </ul>
      </div>
      <div class="col-lg-12">
            <section class="panel">
           

          <div class="panel-body">
            <section class="panel custom-panel" style="margin-bottom:0;">
              <div class="col-lg-12" style="padding:0;">
                <div class="col-sm-12 " style="padding: 5px;">
                  
                  <div class="col-sm-12" style="padding-left:0px;"> 
						
						<div class="form-group" style="width:100px; float:left;  margin-right:5px;">
						  <select class="selectpicker chosen-select form-control" size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry" style="width: 100px; display: none;">
							<option value="10">10</option>
							<option value="50">50</option>
							<option value="100">100</option>
						  </select><div class="btn-group bootstrap-select chosen-select form-control"><button type="button" class="btn dropdown-toggle selectpicker btn-default" data-toggle="dropdown" data-id="sel_no_entry" title="10"><span class="filter-option pull-left">10</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open"><ul class="dropdown-menu inner selectpicker" role="menu"><li rel="0" class="selected"><a tabindex="0" class="" style=""><span class="text">10</span><i class="fa fa-check icon-ok check-mark"></i></a></li><li rel="1"><a tabindex="0" class="" style=""><span class="text">50</span><i class="fa fa-check icon-ok check-mark"></i></a></li><li rel="2"><a tabindex="0" class="" style=""><span class="text">100</span><i class="fa fa-check icon-ok check-mark"></i></a></li></ul></div></div>
                      </div>
                  	  <div class="" style="padding-left:10px;"><span class="records_per_page">Records Per Page</span></div>
                  </div>
                  
                </div>
                
              </div>
            </section>
            <section class="table-responsive" id="unseen">
              <table class="table table-invoice table-custom table-search-head" style="100%">
                <thead>
                  <tr>
                    <th width="1%">S.No.</th>
                    <th width="15%"> Subscription Plan
                      <input type="text" class="form-control search table-head-search" id="SubscriptionPlan" onkeyup="ajax_search();" placeholder="Subscription Plan">
                    </th>
					<th width="15%"> First Name
                      <input type="text" class="form-control search table-head-search" id="firstName" onkeyup="ajax_search();" placeholder="First Name">
                    </th>
                    <th width="15%"> Last Name
                      <input type="text" class="form-control search table-head-search" id="lastName" onkeyup="ajax_search();" placeholder="Last Name">
                    </th>
                    <th width="15%"> Phone No.
                      <input type="text" class="form-control search table-head-search" id="phone" onkeyup="ajax_search();" placeholder="+234">
                    </th>
					<th width="20%"> Email id
                      <input type="text" class="form-control search table-head-search" id="email" onkeyup="ajax_search();" placeholder="Email id">
                    </th>
                    <th width="5%">Action</th>
					
                  </tr>
                </thead>
				  <tbody id="ajaxData">
                </tbody>
                </table>
            </section>
          </div>
        </section>
      </div>
    <!--contant end--> 
  </div></section>
</section>
<script type="text/javascript">


function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&subscriptionPlan='+$('#subscriptionPlan').val()+'&firstName='+$('#firstName').val()+'&lastName='+$('#lastName').val()+'&phone='+$('#phone').val()+'&email='+$('#email').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
	
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
	if($("#firstName").val())
	{
		$("#firstName").css('width','98%');
		$("#firstName").css('background','white');
	}
	else
	{
		$("#firstName").css('width','');
		$("#firstName").css('background','');
	}
	
	if($("#lastName").val())
	{
		$("#lastName").css('width','98%');
		$("#lastName").css('background','white');
	}
	else
	{
		$("#lastName").css('width','');
		$("#lastName").css('background','');
	}
	
	if($("#email").val())
	{
		$("#email").css('width','98%');
		$("#email").css('background','white');
	}
	else
	{
		$("#email").css('width','');
		$("#email").css('background','');
	}
	
	if($("#phone").val())
	{
		$("#phone").css('width','98%');
		$("#phone").css('background','white');
	}
	else
	{
		$("#phone").css('width','');
		$("#phone").css('background','');
	}
	
	
	
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType');?>/pointepay_management/ajaxOrderList');	
}
ajax_search();

</script>