<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}
 small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 100%;
}

</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Inventory</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
        	<div class="col-lg-12">
				<?php $this->load->view('success_error_message'); ?>
            	<section class="panel">
					<div class="col-sm-12 panel-heading panel-heading1">
						<a href="<?php echo base_url().'admin/check_stock_management/add_check_stock_list/'.id_encrypt($organizationId); ?>" class="btn btn-sm btn-shadow btn-success hvr-push"><i class="fa fa-plus"></i>
							Add Product
						</a>
						<select class="form-control pull-left"  name='sel_no_entry' onchange="ajaxPage('<?php echo base_url().'admin/check_stock_management/ajaxFun'; ?>');"  id='sel_no_entry' style="width:75px !important;display: inline-block;">
							<option value="10">10</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
					</div>
					<div class="panel-body">							
						<section id="unseen">
							<table class="table table-invoice table-hover table-striped table-customm table-search-head">
								<thead>
									<tr>
										<th width="1%">S.No.</th>
										<th width="20%">Product Image</th>
										<th width="20%">
											Product Name
											<input type="text" class="form-control search table-head-search" id="productName" onkeyup="ajaxPage('<?php echo base_url().'admin/check_stock_management/ajaxFun'; ?>');" placeholder="Product Name">
										</th>
										<th width="20%">Product Price</th>
										<th width="15%">Current Stock</th>
										<th width="5%">Details</th>
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
function ajaxPage(urlLink)
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
	
	$.ajax({
		type: "POST",
		url:urlLink,
		data:'organizationId=<?php echo $organizationId; ?>&sel_no_entry='+$('#sel_no_entry').val()+'&productName='+$("#productName").val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#ajaxData').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#ajaxData').html(result);				
		}
	});
}
ajaxPage('<?php echo base_url().'admin/check_stock_management/ajaxFun'; ?>');
</script>