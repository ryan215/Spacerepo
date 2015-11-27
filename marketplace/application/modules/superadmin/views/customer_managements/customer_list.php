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
    	<?php $this->load->view('success_error_message'); ?>  
    	<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">				
					<li>
						<a href="javascript:void(0);" class="current">Customer List</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
                	<div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0;">
							<div style="padding:0;" class="col-lg-12">
                				<div class="col-sm-5 " style="padding: 5px;">
									<div class="col-sm-3">
				                    	<div class="form-group">
											<select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
												<option value="10">10</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
										</div>
									</div>
                  					<div class="col-sm-5"  style="padding:0px;"> <span class="records_per_page">Records Per Page</span> </div>
                				</div>
              				</div>	
                        </section>
                              <section id="unseen">
                              	<table class="table table-invoice table-hover table-striped table-customm table-search-head">
									<thead>
								   		<tr>
								        	<th width="5%">S.No.</th>
								            <th width="25%">
												First Name
                                            	<input type="text" class="form-control search table-head-search" id="firstName" onkeyup="ajax_search();" placeholder="First Name">
                                            </th>
											<th width="25%">Last Name
												<input type="text" class="form-control search table-head-search" id="lastName" onkeyup="ajax_search();" placeholder="Last Name">
											</th>
								            <th width="35%">
												Email
												<input type="text" class="form-control search table-head-search" id="email" onkeyup="ajax_search();" placeholder="Email">
											</th>
                                            <th width="10%">
												Action
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
	
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/customer_management/ajaxFun'; ?>');
}

function ajaxPage(urlLink)
{	
	$.ajax({
		type: "POST",
		url:urlLink,
		data:'sel_no_entry='+$('#sel_no_entry').val()+'&firstName='+$("#firstName").val()+'&lastName='+$("#lastName").val()+'&email='+$("#email").val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});	
}

ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/customer_management/ajaxFun'; ?>');
</script>
