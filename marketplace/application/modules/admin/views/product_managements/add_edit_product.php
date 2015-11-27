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
	margin: 0 3px;
	float:right;
}

.ftrBoxID{margin:12px;
	display:flex;
}

.ftrBoxID input{width:85%;
}
input[type=radio] {
	 display:inline-block !important;
}


.ftrAjaxID
{
	text-align:right !important;
	
}
.edit-btns{float:right;
	height:32px;
	padding:5px;
	font-size:14px;
	margin:0 6px;
}
.color-filter small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 14px;
}
.block-element label {
  float: left;
  margin-right: 18px;
}
.colorpicker{ z-index:10000;}
.padding_left_zero{ padding-left:0px;}
.padding_right_zero{ padding-right:0px;}
</style>
<section id="main-content">
	<section class="wrapper">
		<div style="padding-left:0px;">
			<ul class="breadcrumbs-alt animated fadeInLeft">
				<li>
					<a href="<?php echo base_url().'admin/product_management'; ?>">
						Product Managment
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="current">
						<?php
						if($result['product_id'])
						{
							echo 'Edit Product';
						}
						else
						{
							echo 'Add Product';
						} 
						?>
					</a>
				</li>
			</ul>
		</div>
    	<?php $this->load->view('success_error_message'); ?>  
		<div class="row panel" style="margin:5px 0 20px;">
			<div class="col-sm-12">
	    		<div class="progress progress-striped progress-sm" style="margin:5px 0; height:14px;">
	        		<div style = "width:10%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
		            	<span class="sr-only">40% Complete (success)</span>
		            </div>
				</div>
				<div class="col-sm-3 pd">Product Description</div>
	        	<div class="col-sm-3 pd text-center">Images</div>
		        <div class="col-sm-3 pd text-center">Attributes</div>
		        <div class="col-sm-3 pd text-right">Review Product</div>
			</div>
		</div>
	
		<div class="alert alert-warning fade in">
    		<strong>Note :</strong> Changes not saved until you click the save button
	    </div>
		
		<?php $this->load->view('retailer/product_managements/add_edit_product_form'); ?> 
	</section>
</section>