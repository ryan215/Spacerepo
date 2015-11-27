<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="javascript:void(0);" class="current">Product Type Listing</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					?> 
                	<div class="panel-body">
						<section class="panel custom-panel">
                        	<div class="col-lg-12" style="padding:0;">
                            	<div class="col-sm-5 " style="padding: 5px;">
																			
									<div class="col-sm-12" style="padding-left:0px;">
										
										<div class="col-sm-12" style="padding:0;">
											<div class="col-sm-3" style="padding-left:0px;">
                                            	<a type="button" class="btn btn-sm btn-shadow btn-success hvr-push" style="padding: 6px 8px !important;" href="<?php echo base_url().$this->session->userdata('userType').'/attribute_management/addAttributeList'; ?>">
                                                    <i class="fa fa-plus"></i>&nbsp;Add
                                                </a>
                                            </div>
											<div class="col-sm-3" style="padding:0;">    
                                            	<select class="selectpicker chosen-select form-control"  size="1" name="sel_no_entry" onchange="ajax_search();" id="sel_no_entry" style="width:75px;display: inline-block;">
                                                	<option value="10">10</option>
                                                	<option value="50">50</option>
                                                	<option value="100">100</option>
                                            	</select>
											 </div>
                                             <div class="col-sm-6">
                                                <span class="records_per_page">Records Per Page</span>
                                            </div>
									  		</div>
									  	
									</div>
								</div>
                                
								<div class="col-sm-7 " style="padding: 5px;">
									
								</div>								                      
                        	</div>
                        </section>
                    	
						<section id="unseen">
                        	<table class="table table-invoice table-custom table-search-head">
								<thead>
									<tr>
										<th width="2%">S.No.</th>
										<th width="20%">
										Product Type
										<input type="text" class="form-control search table-head-search" id="productType" onkeyup="ajax_search();" placeholder="Product Type">
										</th>
										<th width="2%" class="text-center">Action</th>									  
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
<script type="text/javascript">
$('.selectpicker').selectpicker('show');

function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/attribute_management/attributeListingAjaxFun/'.$result['total']; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'search='+$('#productType').val()+'&sel_no_entry='+$('#sel_no_entry').val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/attribute_management/attributeListingAjaxFun/'.$result['total']; ?>');

</script>
<style>
.modal-header{
	border-radius:0px !important;
}
label{ background-image:none;}
.modal-header .close{
  width: 33px;
  position: relative;
  top: -26px;
  right: -21px;
  float: right;
}
.modal-header h4.modal-title{ font-weight:600;}
</style>