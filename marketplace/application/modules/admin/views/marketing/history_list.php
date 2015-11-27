<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />
<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}

.panel-heading .nav > li > a{
	font-size:15px;
	font-weight:600;
}

.nav-justified {background:#bcc1c5;
}

.table-invoice > thead > tr > th{color:#FFF;
}

.btn-reqt{border:1px solid #ccc;
}

.notifi{position:absolute !important;
	top:-8px !important;
}

#header_notification_bar {
list-style-type: none !important;
float: left;
padding-left: 20px;
}
</style>

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<?php $this->load->view('success_error_message'); ?>  
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">Products Management</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_marketing_management'; ?>">Campaign Management Products</a>
					</li>
                    <li>
						<a href="javascript:void(0);" class="current">Campaign Management Products History</a>
					</li>
                    
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
                	<div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0;">
							<div style="padding:0;" class="col-lg-12">
                				<div class="col-sm-5 " style="padding: 5px;">
									<div class="col-sm-4 col-lg-3" style="padding-left:0px;">
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
              				</div>	
                        </section>
                              <section id="unseen">
                              	<table class="table table-invoice table-hover table-striped table-customm table-search-head">
									<thead>
								   		<tr>
								        	<th width="5%">S.N.</th>
								            <th width="20%">Product Image</th>
											<th width="30%">
												Product Name
												<input type="text" class="form-control search table-head-search" id="productName" onkeyup="ajax_search();" placeholder="Product Name">
											</th>
								            <th width="30%">
												Product Category
												<input type="text" class="form-control search table-head-search" id="productCategory" onkeyup="ajax_search();" placeholder="Product Category">
											</th>
											<th width="20%">
												Sale Price
												</th>
											<th width="20%">Inventory</th>
											<th width="10%">Action</th>											
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
//$('.selectpicker').selectpicker('show');

function ajax_search()
{
	if($("#productName").val())
	{
		$("#productName").css('width','98%');
		$("#productName").css('background','white');
		$("#productName").css('padding-left','12px');
		$("#productName").css('font-weight','normal');
	}
	else
	{
		$("#productName").css('width','');
		$("#productName").css('background','');
	}
	
	if($("#productCategory").val())
	{
		$("#productCategory").css('width','98%');
		$("#productCategory").css('background','white');
		$("#productCategory").css('padding-left','12px');
		$("#productCategory").css('font-weight','normal');
	}
	else
	{
		$("#productCategory").css('width','');
		$("#productCategory").css('background','');
	}
	
	
	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&productName='+$("#productName").val()+'&productCategory='+$("#productCategory").val();
	ajax_function('<?php echo base_url().$this->session->userdata('userType'); ?>/product_marketing_management/historyAjaxFun','#ajaxData',postData);
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&productName='+$("#productName").val()+'&productCategory='+$("#productCategory").val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType'); ?>/product_marketing_management/historyAjaxFun');
</script>
