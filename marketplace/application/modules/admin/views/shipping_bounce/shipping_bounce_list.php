<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />
<!--main content start-->

<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
      <div class="col-lg-12">
        <ul class="breadcrumbs-alt animated fadeInLeft">
          <li> <a href="javascript:void(0);" class="current">Shipping Bounce List</a> </li>
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
          <?php $this->load->view('success_error_message'); ?>
          <div class="panel-body">
            <section class="panel custom-panel" style="margin-bottom:0;">
              <div style="padding:0;" class="col-lg-12">
                <div class="col-sm-5 " style="padding: 5px;">
                  <div class="col-sm-2 col-lg-2" style="padding-left:0px;"> 
                   <select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                      </select>
                   </div>
                  <div class="col-sm-4 col-lg-3">
                    <div class="form-group">
                     
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-5"  style="padding:0px;"> <span class="records_per_page">Records Per Page</span> </div>
                </div>
                <div class="col-sm-7 " style="padding: 5px;">
                  
                </div>
              </div>
            </section>
            <section id="unseen">
<table class="table table-invoice  table-hover table-custom table-search-head">
	<thead>
    	<tr>
        	<th width="5%">S.No.</th>
            <th>
            	Dropship Center Name
                <input type="text" class="form-control search table-head-search" id="dropship" onkeyup="ajax_search();" placeholder="Dropship Center Name">
            </th>
			<th>
            	State
                <input type="text" class="form-control search table-head-search" id="stateName" onkeyup="ajax_search();" placeholder="State Name">
			</th>					
            <th>
            	Area
                <input type="text" class="form-control search table-head-search" id="areaName" onkeyup="ajax_search();" placeholder="Area Name">
			</th>
            <th>
            	City
                <input type="text" class="form-control search table-head-search" id="cityName" onkeyup="ajax_search();" placeholder="City Name">
			</th>
            <th>
            	Total Hit
                <input type="text" class="form-control search table-head-search" id="totalHit" onkeyup="ajax_search();" placeholder="Total">
			</th>
            <th>
            	Product Weight
			</th>
            <th>
            Date & Time
            </th>
            <th>Detete</th>
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

<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">

<script type="text/javascript">
$('.selectpicker').selectpicker('show');
function ajax_search(srchval)
{
	if($("#dropship").val())
	{
		$("#dropship").css('width','98%');
		$("#dropship").css('background','white');
	}
	else
	{
		$("#dropship").css('width','');
		$("#dropship").css('background','');
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
	
	if($("#totalHit").val())
	{
		$("#totalHit").css('width','98%');
		$("#totalHit").css('background','white');
	}
	else
	{
		$("#totalHit").css('width','');
		$("#totalHit").css('background','');
	}
	
	postData = 'dropship='+$('#dropship').val()+'&sel_no_entry='+$('#sel_no_entry').val()+'&stateName='+$('#stateName').val()+'&areaName='+$('#areaName').val()+'&cityName='+$('#cityName').val()+'&totalHit='+$('#totalHit').val();
	ajax_function('<?php echo base_url().$this->session->userdata('userType'); ?>/shipping_bounce/ajaxFun/<?php echo $result['total']; ?>/','#ajaxData',postData);
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType'); ?>/shipping_bounce/ajaxFun/<?php echo $result['total']; ?>/');

function delete_shipping_bounce(shippingBounceId)
{
	swal({   
	title: '',   
	text: 'Are you sure want to Delete?',   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/shipping_bounce/delete_shipping_bounce/'; ?>"+shippingBounceId; 
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>


