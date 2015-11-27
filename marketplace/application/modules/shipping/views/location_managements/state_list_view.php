<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					
					<li>
						<a href="javascript:void(0);" class="current">State List</a>
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
							<div style="padding:0;" class="col-lg-12">
							<div class="col-sm-5 " style="padding: 5px;">
								 <div class="col-sm-2 col-lg-2" style="padding-left:0px;"><a href="<?php echo base_url().$this->session->userdata('userType').'/location_management/addEditState'; ?>" class="btn btn-sm btn-shadow btn-success hvr-push" onclick="add_edit_brand_form(0);"> <i class="fa fa-plus"></i> Add
									</a></div>
									<div class="col-lg-3 col-sm-4">
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
                    	
                        
						<section id="unseen" class="table-responsive">
                        	<table class="table table-invoice table-hover table-striped table-custom table-search-head">
	<thead>
    	<tr>
        	<th width="5%">S.no.</th>
            <th>
				Country Name
				<input type="text" class="form-control search table-head-search" id="countryName" onkeyup="ajax_search();"  placeholder="Country Name">
			</th>
			<th>
				State Name
				<input type="text" class="form-control search table-head-search" id="stateName" onkeyup="ajax_search();"  placeholder="State Name">
			</th>
			
			<!--<th>Zone Name</th>-->
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

<script type="text/javascript">
$('.selectpicker').selectpicker('show');
function ajax_search()
{
	if($("#countryName").val())
	{
		$("#countryName").css('width','98%');
		$("#countryName").css('background','white');
	}
	else
	{
		$("#countryName").css('width','');
		$("#countryName").css('background','');
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
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/location_management/state_ajaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&countryName='+$("#countryName").val()+'&stateName='+$("#stateName").val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/location_management/state_ajaxFun/'.$result['total']; ?>');
</script>