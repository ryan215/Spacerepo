<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
      <div class="col-lg-12">
        <ul class="breadcrumbs-alt">
          <li> <a href="javascript:void(0);" class="current">Invoice List</a> </li>
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
           

          <div class="panel-body">
            
            <section class="table-responsive" id="unseen">
              <table class="table table-invoice table-custom table-search-head" style="100%">
                <thead>
                  <tr>
                    <th width="1%">S.No.</th>
					 <th width="10%"> Reference No.
                      <input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Reference No.">
                    </th>
                    <th width="10%"> Bussiness Name
                      <input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Business Name">
                    </th>
                    <th width="12%"> Business Owner Name
                      <input type="text" class="form-control search table-head-search" id="businessOwnerName" onkeyup="ajax_search();" placeholder="Business Owner Name">
                    </th>
                    <th width="10%"> Bussiness Phone
                      <input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="+234">
                    </th>
					 <th width="25%"> Product Name
                      <input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="Product Name">
                    </th>
					 <th width="8%">Total Price
                      <input type="text" class="form-control search table-head-search" id="businessPhone" onkeyup="ajax_search();" placeholder="Total Price">
                    </th>
                   
					<th width="1%">Action</th>
                  </tr>
                </thead>
                <tbody id="ajaxData">
				<tr>
					<td>1</td>
					<td>687984321321</td>
					<td>Rohit Ambeldkar</td>
					<td>Rohit</td>
					<td>+2347033928838</td>	
					<td>Bluetooth Reader , Standard Printer , M5025 Samsung S5</td>	
					<td>?39,150</td>
					<td><center><a class="btn btn-warning btn-xs tooltips" title="" type="button" href="invoice_view.html" data-original-title="View Detail"><i class="fa fa-eye"></i></a></center>
					</td>
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

<script type="text/javascript">
$('.selectpicker').selectpicker('show');

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&businessName='+$('#businessName').val()+'&businessPhone='+$('#businessPhone').val()+'&businessOwnerName='+$('#businessOwnerName').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';
	
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
	
	
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType');?>/pointepay_management/ajaxInvoiceListing');	
}
ajax_search();

</script>