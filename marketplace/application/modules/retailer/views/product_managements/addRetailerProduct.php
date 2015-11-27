<style>
.inventory-form-group{margin-bottom:14px !important;
}
.popover-content{font-size:11px;
	font-weight:normal;
	text-transform:inherit !important;
}
.popover .arrow{top:100 !important;
}

.input-group-addon{background-color:#F0F0F0;
}
</style>

<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>  
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().'retailer/retailer_product_management'; ?>">
							Spacepointe List
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'retailer/retailer_product_management/main_product_list'; ?>">
							Main Product List
						</a>
					</li>
					<li>
						<a class="current" href="javascript:void(0);">
							Add Product
						</a>
					</li>
				</ul>
			</div>
        </div>
		<?php 
echo form_open();
?>                                                                                           
		<div class="row">
			<div style="padding:0;" class="col-md-12">
            	<div class="col-lg-12">
                	<section style="" class="panel">
                    	<header class="panel-heading panel-heading1">Add  Product</header>
						
                        <div class="panel-body">
                        	<div class="col-sm-12" style="padding-top:20px;">
                            	<div class="col-sm-2"></div>
                                <div class="col-sm-8">
                                	<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Product Category</label>
                                        </div>
                                        <div class="col-sm-6">
                                        	<select name="categoryId" class="form-control">
												<?php
												if($result['categoryList'])
												{
													foreach($result['categoryList'] as $row)
													{
												?>
												<option value="<?php echo $row->categoryId; ?>" <?php if($row->categoryId==$result['categoryId']){ ?> selected="selected" <?php } ?>>
													<?php echo $row->categoryCode; ?>
												</option>
												<?php
													}
												}
												?>
											</select>
											<?php echo form_error('categoryId'); ?>
                                        </div>
                                    </div>
									<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">UPC</label>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<input type="text" class="form-control" value="<?php echo $result['upc']; ?>" name="upc">
                                            </div>
											<?php echo form_error('upc'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Cost Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<input type="text" class="form-control" value="<?php echo $result['costPrice']; ?>" name="costPrice">
                                            </div>
											<?php echo form_error('costPrice'); ?>
                                        </div>
                                    </div>
									<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Sell Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<input type="text" class="form-control" value="<?php echo $result['sellPrice']; ?>" name="sellPrice">
                                            </div>
											<?php echo form_error('sellPrice'); ?>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 form-div" style="padding:15px 0;">
                            <div class="col-sm-12 text-right pd">
                                <a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_product_management/main_product_list'; ?>" class="btn btn-danger btn-save">Cancel</a>
                                <button class="btn btn-success btn-save">Save</button>
                            </div>
                        </div>
                    </section>
                    </div>
                                
                </div></div></form></section>
				
			
		
		
       </section>
	   <style>
	   label{ background-image:none;} .form-group { margin:0px;} .padding-bottom { padding-bottom:10px;}
	   </style>
<script type="text/javascript">
function calculate_price(sellPrice)
{
	$('#selErr').html('');
	$('#spacePoint').val('');
	$('#retailerPrice').val('');	
	$('#displayPrice').val('');
	if(sellPrice!='')
	{
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().$this->session->userdata('userType').'/product_management/calculate_price/'; ?>',
			data:'sellPrice='+sellPrice+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){
				if(result.status==1)
				{
					$('#spacePoint').val(result.spacePoint);
					$('#retailerPrice').val(result.retailerPrice);	
					$('#displayPrice').val(result.displayPrice);								
				}
				else
				{
					$('#selErr').html(result.message);
				}
			}
		});
	}
}
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({ trigger: "hover" });
	
});


</script>

