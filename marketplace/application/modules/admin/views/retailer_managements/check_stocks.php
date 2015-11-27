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

</style>


<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">
							Retailer Managment
						</a>
					</li>
                    <li>
						<a href="javascript:void(0);" class="current">Inventory</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
				<?php $this->load->view('success_error_message'); ?>
            	<section class="panel">
                	<div class="col-sm-12 panel-heading panel-heading1">
						<div class="col-sm-2 " style="padding-left:0px;">
							<?php
							if($this->session->userdata('userType')=='cse')
							{
							?>
							<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/index/'.id_encrypt($employeeId); ?>" class="btn btn-sm btn-shadow btn-success hvr-push"><i class="fa fa-plus"></i>
								Add Product
							</a> 
							<?php
							}
							?>
						</div>
					
					</div>
					<div class="panel-body">							
	<section id="unseen">
    	<table class="table table-custom table-invoice">
        	<thead>
            	<tr>
                	<th width="1%">S.No.</th>
					<?php
					if($this->session->userdata('userType')=='cse')
					{
					?>
						<th width="20%">Product Image</th>
					<?php	
					}					
					?>
					<th width="20%">Product Name</th>
					<?php
					if($this->session->userdata('userType')=='cse')
					{
					?>
						<th width="20%">Product Price</th>
					<?php	
					}					
					?>
                    <th width="15%">Current Stock</th>
					<th width="15%">Details</th>
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
	postData = 'organizationId=<?php echo $organizationId; ?>';
	ajax_function(urlLink,'#ajaxData',postData);
}
ajaxPage('<?php echo base_url().$this->session->userdata('userType').'/retailer_management/check_stocksAjaxFun/'.$result['total']; ?>');
</script>