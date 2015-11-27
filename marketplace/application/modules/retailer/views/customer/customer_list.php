<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Customer Management</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					?>  
                    <div class="panel-body">
                    	<section class="panel custom-panel margin-btm-zero">
							<div style="padding:0;" class="col-sm-12">
							<div class="col-sm-5 " style="padding: 5px;">
								 <div class="col-sm-2 col-lg-2" style="padding-left:0px;">
								 	<a class="btn btn-sm btn-shadow btn-success hvr-push" type="button" href="<?php echo base_url().$this->session->userdata('userType').'/customer_management/add_customer'; ?>">
										<i class="fa fa-plus"></i> Add
									</a>
								</div>
									<div class="col-sm-4 col-lg-3">
										<div class="form-group">    
                                            <select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
										</div>
									</div>
									<div class="col-sm-6 col-lg-5"  style="padding:0px;">
										   <span class="records_per_page">Records Per Page</span>
									</div>
									 
                                </div>
                            	<div class="col-sm-7 " style="padding: 5px;">
								
								</div>
							
								
								
							</div>
						</section>
                        <section id="unseen" class="table-responsive cse-pagelist">
                        	<table class="table table-invoice table-custom table-search-head">
								<thead>
									<tr>
										<th width="5%">S.no.</th>
										<th>Image</th>
										<th>
											Name
											<input type="text" class="form-control search table-head-search" id="cseName" onkeyup="ajax_search();" placeholder="Name">
										</th>
										<th>
											Email
											<input type="text" class="form-control search table-head-search" id="emailId" onkeyup="ajax_search();" placeholder="Email">
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
        </div>
        <!--contant end-->
	</section>
</section>
<!--main content end-->
<script language="javascript" type="application/javascript">
$('.selectpicker').selectpicker('show');
function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/employee_management/ajaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{
	if($("#cseName").val())
	{
		$("#cseName").css('width','98%');
		$("#cseName").css('background','white');
	}
	else
	{
		$("#cseName").css('width','');
		$("#cseName").css('background','');
	}
	
	if($("#emailId").val())
	{
		$("#emailId").css('width','98%');
		$("#emailId").css('background','white');
	}
	else
	{
		$("#emailId").css('width','');
		$("#emailId").css('background','');
	}
	
	postData = 'emailId='+$('#emailId').val()+'&cseName='+$('#cseName').val()+'&sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/employee_management/ajaxFun/'.$result['total']; ?>');
</script>