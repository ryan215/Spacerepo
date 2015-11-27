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
						<a href="javascript:void(0);" class="current">Product Rating & Review Managment</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
                	<div class="panel-body">
                    	<section class="panel custom-panel" style="margin-bottom:0;">
							<div style="padding:0;" class="col-lg-12">
                				<div class="col-sm-7 " style="padding: 5px;">
									<select class="form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px !important;display: inline-block;">
										<option value="10">10</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
									&nbsp;
                  					<span class="records_per_page" style="position:relative; top:-3px;">
										Records Per Page
									</span>
								</div>
								<div class="col-sm-5 pull-right">
								</div>
              				</div>	
                        </section>
                        
						<section id="unseen">
                        	<table class="table table-invoice table-hover table-striped table-customm table-search-head">
								<thead>
									<tr>
								    	<th width="2%">S.No.</th>
								        <th width="25%">
											Review Title
											<input type="text" class="form-control search table-head-search" id="reviewTitle" onkeyup="ajax_search();" placeholder="Review Title">
										</th>
										<th width="50%">
											Review Description
											<input type="text" class="form-control search table-head-search" id="reviewDescription" onkeyup="ajax_search();" placeholder="Review Description">
										</th>
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

function ajax_search()
{
	if($("#reviewTitle").val())
	{
		$("#reviewTitle").css('width','98%');
		$("#reviewTitle").css('background','white');
		$("#reviewTitle").css('padding-left','12px');
		$("#reviewTitle").css('font-weight','normal');
	}
	else
	{
		$("#reviewTitle").css('width','');
		$("#reviewTitle").css('background','');
	}
	
	if($("#reviewDescription").val())
	{
		$("#reviewDescription").css('width','98%');
		$("#reviewDescription").css('background','white');
		$("#reviewDescription").css('padding-left','12px');
		$("#reviewDescription").css('font-weight','normal');
	}
	else
	{
		$("#reviewDescription").css('width','');
		$("#reviewDescription").css('background','');
	}
	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&reviewTitle='+$("#reviewTitle").val()+'&reviewDescription='+$("#reviewDescription").val();
	ajax_function('<?php echo base_url().$this->session->userdata('userType').'/product_rating_review/ajaxFun/'; ?>','#ajaxData',postData);
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&reviewTitle='+$("#reviewTitle").val()+'&reviewDescription='+$("#reviewDescription").val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/product_rating_review/ajaxFun/'; ?>');

function delete_rating_review(productRatingId)
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
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/product_rating_review/delete_rating_review/'; ?>"+productRatingId; 
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>
