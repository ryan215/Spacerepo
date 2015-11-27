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
input[type=checkbox] {
  margin: 4px 8px 0px !important;
  line-height: normal;
}
.sizes_label{   top: -2px;
  position: relative}
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
</style>

<section id="main-content">
	<section class="wrapper">
		<?php $this->load->view('success_error_message'); ?>  
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>">Flash sales Product</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management/user_detail/'.id_encrypt($organizationId); ?>">View</a>
					</li>
					
					<li>
						<a class="current" href="javascript:void(0);">
							Add Inventory
						</a>
					</li>
				</ul>
			</div>
        </div>
	<?php echo form_open();?>
		<div class="row">
			<div style="padding:0;" class="col-md-12">
            	<div class="col-lg-12">
                	<section style="" class="panel">
                    	<header class="panel-heading panel-heading1">Add  Inventory</header>
						
                        <div class="panel-body">
                        	<div class="col-sm-12" style="padding-top:20px;">
                            	<div class="col-sm-2"></div>
                                <div class="col-sm-8">
								<?php 
									//print_r($result);
								if(isset($result['productcolorlist']) && !empty($result['productcolorlist'])){
									?><div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">select color</label> <span class="error">*</span>
                                        </div>
										 <div class="col-sm-6">
										 <div class="form-group clearfix color-filter" id="color">
										<?php 
								
									foreach($result['productcolorlist'] as $product_color){
											
								
                                       
                                        	echo '  <div class="block-element">
																			<label>
																			 <input type="checkbox" name="availablecolor[]" value="'.$product_color->colorId.'">
																			 <small style="background-color:'.$product_color->colorCode.'"></small>
																			  
																			</label> 
																		   </div> ';
											
									} ?>
									</div>
                                        </div>
                                    </div>
								<?php  }
									if(!empty($resultProductDetail['sizes'])){ 
									$sizeArr=explode(',',$resultProductDetail['sizes']);
									?>
									<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Select Size</label> <span class="error">*</span>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	
                                        	<?php foreach($sizeArr as $size)
											{
												echo '<input type="checkbox" name="availablesize[]" value="'.$size.'"><label class="sizes_label">'.$size.'</label>';
											}
											?>
                                            </div>
											<?php echo form_error('size'); ?>
                                        </div>
                                    </div>
									<?php } ?>
									
                                	<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Add Stock</label> <span class="error">*</span>
                                        </div>
                                        <div class="col-sm-6">
                                        	<input type="text" class="form-control" placeholder="Add Stock" value="<?php echo $result['stock']; ?>" name="stock">
											<?php echo form_error('stock'); ?>
                                        </div>
                                    </div>
									<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Sell Price</label> <span class="error">*</span>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<span class="input-group-addon">&#x20A6;</span>
                                        	<input type="text" class="form-control" placeholder="" value="<?php echo $result['sellPrice']; ?>" name="sellPrice" id="sellPrice" onblur="calculate_price(this.value);">
                                            </div>
											<div id="selErr" class="error"><?php echo form_error('sellPrice'); ?></div>
                                        </div>
                                    </div>
									<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Spacepointe Comission Price  <span class="error" style="font-weight:normal;">*</span> <a href="#"  data-toggle="popover"  data-content="A 5% spacepointe comission is calculated on the selling price"><i class="fa fa-question-circle" style="color:#F7AD79;"></i></a></label>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<span class="input-group-addon">&#x20A6;</span>
                                        		<input type="text" class="form-control" value="<?php echo $result['spacePointComisson']; ?>" name="spacePointComisson" id="spacePoint" readonly="">
                                            </div>
											<?php echo form_error('spacePointComisson'); ?>
                                        </div>
                                    </div>
									<div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Retailer Will Be Getting<span class="error" style="font-weight:normal;">*</span></label>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<span class="input-group-addon">&#x20A6;</span>
                                        		<input type="text" class="form-control" value="<?php echo $result['retailerPrice']; ?>" name="retailerPrice" id="retailerPrice" readonly="">
                                            </div>
											<?php echo form_error('retailerPrice'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 inventory-form-group">
                                    	<div class="col-sm-4">
                                        	<label for="">Display Price</label> <span class="error">*</span>
                                        </div>
                                        <div class="col-sm-6">
                                        	<div class="input-group">
                                            	<span class="input-group-addon">&#x20A6;</span>
                                        	<input type="text" class="form-control" placeholder="" value="<?php echo $result['displayPrice']; ?>" name="displayPrice" id="displayPrice" readonly="">
                                            </div>
											<?php echo form_error('displayPrice'); ?>
                                        </div>
                                    </div> 
									
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 form-div" style="padding:15px 0;">
                            <div class="col-sm-12 text-right pd">
                                <?php /*?><a href="http://192.168.1.5/marketplace/admin/category_management/view_list" class="btn btn-danger btn-save">Cancel</a><?php */?>
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

