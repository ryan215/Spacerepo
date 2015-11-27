<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}
.r-activity{margin-top:0;
	font-size:10px;
}

.r-activity1{
	display:inline-block;
	height: 32px;
	font-size: 14px;
	padding: 5px;
	margin-top:1px;
	float:right;
}

.ftrBoxID{
	margin: 12px 0 0 0px;
	display:flex;
}

.ftrBoxID input{width:100%;
}

.ftrAjaxID
{
	text-align:right !important;
	
}
.edit-btns{float:right;
	  float: right;
	  height: 32px;
	  padding: 5px;
	  font-size: 14px;
	  margin: 1px 2px;
}

.block-element label{float:left;
	margin-right:18px;
}

</style>
<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<section id="main-content">
	<section class="wrapper">
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li><a href="javascript:void(0);" class="current">Free Shipping Product Management</a></li>
				</ul>
			</div>
        </div>
		<div class="row">
			<div class="col-md-12" style="padding:0;">
            	<div class="col-lg-12">
                	<section class="panel" style="">
						<?php $this->load->view('success_error_message'); ?> 
                    	<header class="panel-heading panel-heading1">Free Shipping Product</header>
						<div class="panel-body" style="line-height:21px;">
							<section class="panel custom-panel" style="margin-bottom:0;">
									<a href="<?php echo base_url().'superadmin/free_shipping_product/add_free_shipping_product'; ?>" class="btn btn-sm btn-shadow btn-success hvr-push" style="position:relative; top:-5px;">
										<i class="fa fa-plus"></i>&nbsp;Add
									</a>&nbsp;&nbsp;
									<select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
										<option value="10">10</option>
										<option value="50">50</option>
										<option value="100">100</option>
									  </select>
									  <span class="records_per_page" style="position:relative; top:-4px;"> Records Per Page</span>
               			 
            				</section>
                        	
							
                        </div>
						<section id="unseen" class="col-sm-12">
					 		 <table class="table table-invoice  table-hover table-custom table-search-head">
								<thead>
								  <tr>
									<th width="3%">S.No.</th>
									 <th width="5%">Image</th>
									<th width="30%">Product Name
									<input type="text" class="form-control search table-head-search" id="productName" onkeyup="ajax_search();" placeholder="Product Name ">
									</th>					
									<th width="20%">Category Name
									<input type="text" class="form-control search table-head-search" id="categoryName" onkeyup="ajax_search();" placeholder="Category Name ">
									</th>
									<th width="20%">Brand Name
									<input type="text" class="form-control search table-head-search" id="brandName" onkeyup="ajax_search();" placeholder="Brand Name ">
									</th>
									<th width="10%">Action</th>
								  </tr>
								</thead>
							<tbody id="ajaxData">
								
							</tbody>
					  </table>
           				</section>
						<div class="clearfix"></div>
						
						</div>
                                
                </section>
				</div>
			</div>
		</div>
       </section>
</section>	   
<script type="text/javascript">
function ajax_search()
{
	ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/free_shipping_product/ajaxFun/'; ?>');
}

function ajaxPage(urlLink)
{	
	postData = 'sel_no_entry='+$('#sel_no_entry').val()+'&productName='+$('#productName').val()+'&categoryName='+$('#categoryName').val()+'&brandName='+$('#brandName').val();
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/free_shipping_product/ajaxFun/'; ?>');

function delete_free_product(freeShipPrdId)
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
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/free_shipping_product/delete_free_shipping_product/'; ?>"+freeShipPrdId; 
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>
			
