<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />
<!--main content start-->

<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
      <div class="col-lg-12">
        <ul class="breadcrumbs-alt animated fadeInLeft">
          <li> <a href="javascript:void(0);" class="current">Brand List</a> </li>
        </ul>
      </div>
      <div class="col-lg-12">
        <section class="panel">
          <?php $this->load->view('success_error_message'); ?>
          <div class="panel-body">
            <section class="panel custom-panel" style="margin-bottom:0;">
              <div style="padding:0;" class="col-lg-12">
                <div class="col-sm-5 " style="padding: 5px;">
                  <div class="col-sm-2 col-lg-2" style="padding-left:0px;"> <a type="button" class="btn btn-sm btn-shadow btn-success hvr-push" href="<?php echo base_url().$this->session->userdata('userType').'/brand_management/addEditBrand'; ?>"> <i class="fa fa-plus"></i> Add </a> </div>
                  <div class="col-sm-4 col-lg-3">
                    <div class="form-group">
                      <select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                      </select>
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
                     <th width="5%">Image</th>
					<th>Brand Name
					<input type="text" class="form-control search table-head-search" id="brandName" onkeyup="ajax_search();" placeholder="Brand Name ">
					</th>					
                    <th width="5%">Edit</th>
					<th width="5%">Status</th>
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
	if($("#brandName").val())
	{
		$("#brandName").css('width','98%');
		$("#brandName").css('background','white');
	}
	else
	{
		$("#brandName").css('width','');
		$("#brandName").css('background','');
	}
	postData = 'search='+$('#brandName').val()+'&sel_no_entry='+$('#sel_no_entry').val()+'&sorting='+$('#sorting').val();
	ajax_function('<?php echo base_url().$this->session->userdata('userType'); ?>/brand_management/ajaxFun/<?php echo $result['total']; ?>/','#ajaxData',postData);
}

function ajaxPage(urlLink)
{	
	ajax_function(urlLink,'#ajaxData');
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType'); ?>/brand_management/ajaxFun/<?php echo $result['total']; ?>/');

function activeDeac(brandID,status)
{
	msg = 'Blocking a brand will disable all the products that is listed under this brand. Do you want to proceed with block ?';
	if(status==1)
	{
		msg = 'Are you sure want to Unblock this brand?';
	}
	swal({   
	title: '',   
	text: msg,   
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
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/brand_management/change_status/'; ?>"+brandID+'/'+status; 
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>


