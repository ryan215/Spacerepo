<?php 
echo form_open();
?>                                                                                           
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
							if(!empty($result['productcolorlist']))
							{
							?>
                            <div class="col-sm-12 inventory-form-group">
                            	<div class="col-sm-4">
                                	<label for="">select color</label> <span class="error">*</span>
                                </div>
								<div class="col-sm-6">
									<div class="form-group clearfix color-filter" id="color">
									<?php 
									foreach($result['productcolorlist'] as $product_color)
									{
										echo '<div class="block-element"><label><input type="checkbox" name="availablecolor[]" value="'.$product_color->colorId.'"><small style="background-color:'.$product_color->colorCode.'"></small></label></div>';
									}
									?>
									</div>
									<?php echo form_error('availablecolor[]');?>
								</div>
							</div>
							<?php  
							}
							if(!empty($result['product_size']))
							{ 
							?>
							<div class="col-sm-12 inventory-form-group">
                            	<div class="col-sm-4">
                                	<label for="">Select Size</label> <span class="error">*</span>
                                </div>
                                <div class="col-sm-6">
                                	<div class="input-group">
                                    <?php 
									foreach($result['product_size'] as $size)
									{
										echo '<input type="checkbox" name="availablesize[]" value="'.$size->productSizeId.'"><label class="sizes_label">'.$size->sizes.'</label>';
									}
									?>
									</div>
									<?php echo form_error('availablesize[]'); ?>
								</div>
							</div>
							<?php 
							}
							?>
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
                                	<label for="">Retailer Quoted Price</label> <span class="error">*</span>
                                </div>
                                <div class="col-sm-6">
                                	<input type="text" class="form-control" placeholder="Retailer Quoted Price" value="<?php echo $result['retailerQuotePrice']; ?>" name="retailerQuotePrice" onblur="calculate_price(this.value);">
                                    <div id="selErr" class="error"><?php echo form_error('retailerQuotePrice'); ?></div>
                                </div>
							</div>
								
							<div class="col-sm-12 inventory-form-group">
                            	<div class="col-sm-4">
                                	<label for="">Retailer Pay Back Price</label> <span class="error">*</span>
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
                                	<label for="">
										<?php 
										if($this->session->userdata('userType')=='retailer')
										{
											echo 'Commission';
										}
										else
										{
											echo 'Customer Commission';
										}
										?>
										<span class="error" style="font-weight:normal;">*</span>
										<a href="#" data-toggle="popover"  data-content="A <b><?php echo $result['catCommission1']; ?>%</b> spacepointe comission is calculated on the selling price"><i class="fa fa-question-circle" style="color:#F7AD79;"></i></a>
									</label>
                                </div>
                                <div class="col-sm-6">
                                	<div class="input-group">
                                    	<span class="input-group-addon">&#x20A6;</span>
                                        <input type="text" class="form-control" value="<?php echo $result['spacePointeCommission1']; ?>" name="spacePointeCommission1" id="spacePointeCommission1" readonly>
									</div>
									<?php echo form_error('spacePointeCommission1'); ?>
								</div>
							</div>
							
							<div class="col-sm-12 inventory-form-group" <?php if($this->session->userdata('userType')=='retailer'){ ?> style="display:none;" <?php } ?>>
                            	<div class="col-sm-4">
                                	<label for="">
										Retailer Commission
										<span class="error" style="font-weight:normal;">*</span>
										<a href="#" data-toggle="popover"  data-content="A <b><?php echo $result['catCommission2']; ?>%</b> spacepointe comission is calculated on the selling price"><i class="fa fa-question-circle" style="color:#F7AD79;"></i></a>
									</label>
                                </div>
                                <div class="col-sm-6">
                                	<div class="input-group">
                                    	<span class="input-group-addon">&#x20A6;</span>
                                        <input type="text" class="form-control" value="<?php echo $result['spacePointeCommission2']; ?>" name="spacePointeCommission2" id="spacePointeCommission2" readonly>
									</div>
									<?php echo form_error('spacePointeCommission2'); ?>
								</div>
							</div>
							
							<div class="col-sm-12 inventory-form-group" <?php if($this->session->userdata('userType')=='retailer'){ ?> style="display:none;" <?php } ?>>
                            	<div class="col-sm-4">
                                	<label for="">
										Cash admin Fee<span class="error" style="font-weight:normal;">*</span>
									</label>
                                </div>
                                <div class="col-sm-6">
                                	<div class="input-group">
                                    	<span class="input-group-addon">&#x20A6;</span>
                                        <input type="text" class="form-control" value="<?php echo $result['cashAdminPrice']; ?>" name="cashAdminPrice" id="cashAdminPrice" readonly>
									</div>
									<?php echo form_error('cashAdminPrice'); ?>
								</div>
							</div>
							<div class="col-sm-12 inventory-form-group">
                            	<div class="col-sm-4">
                                	<label for="">Display Price</label> <span class="error">*</span>
                                </div>
                                <div class="col-sm-6">
                                	<div class="input-group">
                                    	<span class="input-group-addon">&#x20A6;</span>
                                        <input type="text" class="form-control" value="<?php echo $result['displayPrice']; ?>" name="displayPrice" id="displayPrice" readonly>
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
                    	<button class="btn btn-success btn-save">Save</button>
                    </div>
				</div>
			</section>
		</div>
	</div>
</div>
</form>
<style>
	label{ background-image:none;} .form-group { margin:0px;} .padding-bottom { padding-bottom:10px;}
</style>
<script type="text/javascript">
function calculate_price(retailerQuotedPrice)
{
	$('#selErr').html('');
	$('#retailerPrice').val('');
	$('#spacePointeCommission1').val('');
	$('#spacePointeCommission1').val('');	
	$('#displayPrice').val('');
	
	if(retailerQuotedPrice!='')
	{	
		$.ajax({
			type: "POST",
			url:'<?php echo base_url().$this->session->userdata('userType').'/product_management/product_price_calculate/'; ?>',
			data:'retailerQuotedPrice='+retailerQuotedPrice+'&catCommission1=<?php echo $result['catCommission1']; ?>&catCommission2=<?php echo $result['catCommission2']; ?>&cashAdminPrice=<?php echo $result['cashAdminPrice']; ?>&productWeight=<?php echo $result['productWeight']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',
			success:function(result){	
				if(result.status==1)
				{
					$('#retailerPrice').val(result.retailerPrice);
					$('#spacePointeCommission1').val(result.spacePointeCommission1);
					$('#spacePointeCommission2').val(result.spacePointeCommission2);
					$('#cashAdminPrice').val(result.cashAdminPrice);
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

$(document).ready(function(){
    $('[data-toggle="popover"]').popover({  html : true, trigger: "hover" });
	
});
</script>