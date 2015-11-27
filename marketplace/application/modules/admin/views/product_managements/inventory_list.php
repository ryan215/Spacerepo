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
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">Product Management</a>
					</li>
                    <li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($productId); ?>">Product View</a>
					</li>
                    <li>
						<a href="javascript:void(0);" class="current">Inventory List</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
                	<div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0;">
							<div style="padding:0;" class="col-lg-12">
                				<div class="col-sm-5 " style="padding: 5px;">
									
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
								
              				</div>	
                        </section>
                              <section id="unseen">
                              	<table class="table table-invoice table-hover table-striped table-customm table-search-head">
									<thead>
								   		<tr>
								        	<th width="5%">S.No.</th>
								       
											<th width="15%">
												Busines Name 
												<input type="text" class="form-control search table-head-search" id="businessName" onkeyup="ajax_search();" placeholder="Business Name">
											</th>
								            <th width="15%">
												Owner Name
												<input type="text" class="form-control search table-head-search" id="ownerName" onkeyup="ajax_search();" placeholder="Owner Name">
											</th> 
											<th width="10%">
												Ph no
												<input type="text" class="form-control search table-head-search" id="phone" onkeyup="ajax_search();" placeholder="Phone Number">
											</th>	
											<th width="10%">
												State
												<input type="text" class="form-control search table-head-search" id="state" onkeyup="ajax_search();" placeholder="State">
											</th>
											<th width="10%">
												Area
												<input type="text" class="form-control search table-head-search" id="area" onkeyup="ajax_search();" placeholder="Area">
											</th>
											<th width="8%">
												Sale Price
                                               <!-- <input type="text" class="form-control search table-head-search" id="salePrice" onkeyup="ajax_search();" placeholder="Sale Price">-->
											</th>
											<th width="10%">
                                            	Inventory
                                                <input type="text" class="form-control search table-head-search" id="inventory" onkeyup="ajax_search();" placeholder="Inventory">
                                            </th>
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
	if($("#businessName").val())
	{
		$("#businessName").css('width','98%');
		$("#businessName").css('background','white');
		$("#businessName").css('padding-left','12px');
		$("#businessName").css('font-weight','normal');
	}
	else
	{
		$("#businessName").css('width','');
		$("#businessName").css('background','');
	}
	
	if($("#ownerName").val())
	{
		$("#ownerName").css('width','98%');
		$("#ownerName").css('background','white');
		$("#ownerName").css('padding-left','12px');
		$("#ownerName").css('font-weight','normal');
	}
	else
	{
		$("#ownerName").css('width','');
		$("#ownerName").css('background','');
	}if($("#phone").val())
	{
		$("#phone").css('width','98%');
		$("#phone").css('background','white');
		$("#phone").css('padding-left','12px');
		$("#phone").css('font-weight','normal');
	}
	else
	{
		$("#phone").css('width','');
		$("#phone").css('background','');
	}
	if($("#state").val())
	{
		$("#state").css('width','98%');
		$("#state").css('background','white');
		$("#state").css('padding-left','12px');
		$("#state").css('font-weight','normal');
	}
	else
	{
		$("#state").css('width','');
		$("#state").css('background','');
	}
	if($("#area").val())
	{
		$("#area").css('width','98%');
		$("#area").css('background','white');
		$("#area").css('padding-left','12px');
		$("#area").css('font-weight','normal');
	}
	else
	{
		$("#area").css('width','');
		$("#area").css('background','');
	}
	
	if($("#salePrice").val())
	{
		$("#salePrice").css('width','98%');
		$("#salePrice").css('background','white');
		$("#salePrice").css('padding-left','12px');
		$("#salePrice").css('font-weight','normal');
	}
	else
	{
		$("#salePrice").css('width','');
		$("#salePrice").css('background','');
	}
	
	if($("#inventory").val())
	{
		$("#inventory").css('width','98%');
		$("#inventory").css('background','white');
		$("#inventory").css('padding-left','12px');
		$("#inventory").css('font-weight','normal');
	}
	else
	{
		$("#inventory").css('width','');
		$("#inventory").css('background','');
	}
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/product_management/ajax_inventory_list/'.id_encrypt($productId);?>');
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&businessName='+$("#businessName").val()+'&state='+$("#state").val()+'&area='+$("#area").val()+'&ownerName='+$("#ownerName").val()+'&phone='+$("#phone").val()+'&phone='+$("#phone").val()+'&inventory='+$("#inventory").val(); //+'&salePrice='+$("#salePrice").val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/product_management/ajax_inventory_list/'.id_encrypt($productId);?>');
</script>
