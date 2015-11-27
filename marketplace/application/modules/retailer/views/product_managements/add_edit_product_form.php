<?php 
echo form_open();
?>                                                                                           
<input type="hidden" name="productId" value="<?php echo $product_id; ?>" />
<div class="row">
	<div class="col-md-6" style="padding:0;">
    	<div class="col-lg-12">
        	<section class="panel" style="">
            	<header class="panel-heading panel-heading1">
                	Brand Name
                </header>
                <div class="panel-body" style="line-height:21px;">
                	<div class="form-group">
                    	<select class="form-control selectpicker" data-live-search="true" name="brand_id">
							<option value="">Select Brand</option>
							<?php 
							if(!empty($result['brand_list']))
							{
								foreach($result['brand_list'] as $row)
								{
							?>
								<option value="<?php echo $row->brandId; ?>" <?php if((!empty($result['brand_id']))&&($result['brand_id']==$row->brandId)){ ?> selected="selected" <?php } ?>>
									<?php echo $row->brandName; ?>
								</option>
								<?php										
								}
							}
							?>
						</select>
						<?php echo form_error('brand_id'); ?>
                    </div>
				</div>
            </section>  
		</div>
        
		<div class="col-lg-12" style="display: inline-block;">
        	<section class="panel">
            	<header class="panel-heading panel-heading1">
                	Product Details
                </header>
                <div class="panel-body">
                	<div class="form-group">
                    	<label for="">Item Weight (in Kg)</label>
                        <input type="text" placeholder="Item Weigh (in Kg)" name="item_weight" class="form-control kg-input" value="<?php echo $result['item_weight']; ?>" id="wghtItem" onblur="ttl_weight();">
						<?php echo form_error('item_weight'); ?>
                    </div>
					
					<div class="form-group">
                		<label for="">Packaging Material Weight (in Kg)</label>
                    	<input type="text" placeholder="Packaging Material Weight (in Kg)"  class="form-control kg-input" name="weight_shipping" value="<?php echo $result['packaging_weight']; ?>" id="wghtShip" onblur="ttl_weight();">
						<?php echo form_error('weight_shipping'); ?>
	                </div>
					
					<div class="form-group">
            	    	<label for="">Total Weight For Shipping (in Kg)</label>
                	    <input type="text" placeholder="Total Weight (in Kg)" class="form-control kg-input" name="total_weight" value="<?php echo $result['total_weight']; ?>" id="wgthTotal" readonly="">
						<?php echo form_error('total_weight'); ?>
    	            </div>
				</div>
			</section>
		</div> 
	</div>
	
	<div class="col-md-6" style="padding:0;">
    	<div class="col-lg-12">
        	<section class="panel" style="">
            	<header class="panel-heading panel-heading1">
                	Category
                </header>
                
				<div class="panel-body" style="line-height:30px;">
                	<div class="form-group">
                    	<label for="">Level-1</label>
						<select class="chosen-select form-control" data-live-search="true" name="level1ID" onchange="level2_list(this.value);">
							<option value="">Select Level-1</option>
							<?php 
							if(!empty($result['catList']))
							{
								foreach($result['catList'] as $row)
								{
							?>
							<option value="<?php echo $row->categoryId; ?>" <?php if($result['level1ID']==$row->categoryId){ ?> selected="selected" <?php } ?>>
								<?php echo $row->categoryCode; ?>
							</option>
							<?php										
								}
							}
							?>
						</select>
						<?php echo form_error('level1ID'); ?>
                    </div>
                    
					<div class="form-group" id="catdiv" style="display:none;">
                    	<label for="">Level-2</label>
                        <div id="catAjaxId">
                        	<select class="chosen-select form-control" data-live-search="true" name="level2">
								<option value="">Select Level-2</option>	
							</select>
                        </div>
						<?php echo form_error('level2'); ?>
                    </div>
                    
					<div class="form-group" id="subcat1div" style="display:none;">
                    	<label for="">Sub Level-3</label>
                        <div id="subCatAjaxId">
                        </div>
                        <?php echo form_error('sub_category1_id'); ?>
					</div>
                    
					<div class="form-group" id="subcat2div" style="display:none;">
                    	<label for="">Sub Level-4</label>
                        <div id="subCat2AjaxId">
						</div>
						<?php echo form_error('sub_category2_id'); ?>
					</div>
                    
					<div class="form-group" id="subcat3div" style="display:none;">
                    	<label for="">Sub Level-5</label>
                        <div id="subCat3AjaxId">
                        </div>
                        <?php echo form_error('sub_category3_id'); ?>
					</div>
                    
					<div class="form-group" id="subcat4div" style="display:none;">
                    	<label for="">Sub Level-6</label>
                        <div id="subCat4AjaxId">
                        </div>
                        <?php echo form_error('sub_category4_id'); ?>
					</div>
                    
					<div class="form-group" id="subcat5div" style="display:none;">
                    	<label for="">Sub Level-7</label>
                        <div id="subCat5AjaxId">
                        </div>
                        <?php echo form_error('sub_category5_id'); ?>
					</div>
                    
					<div class="form-group" id="subcat6div" style="display:none;">
                    	<label for="">Sub Level-8</label>
                        <div id="subCat6AjaxId">
                        </div> 
                        <?php echo form_error('sub_category6_id'); ?>
					</div>
				</div>
			</section>  
		</div>
		
		<div class="col-lg-12">
			<?php
			$userType = $this->session->userdata('userType');
			if((!empty($userType))&&(($userType=='superadmin')||($userType=='admin')||($userType=='cse')))
			{
			?>
			<section class="panel">
            	<header class="panel-heading panel-heading1">
                	Product Type
                </header>
				<div class="panel-body">
					<?php $produtType = $result['product_type']; ?>
					<div class="form-group">
						<div class="radios col-lg-12 padding_left_zero" style="padding-top:0px !important;">																		
							<label class="label_radio" for="radio-03" style="display:inline-block;  margin-right: 20px;">
								<input type="radio"  id="radio-03" name="product_type" value="1" <?php if(($produtType==1)||($produtType==2)){ echo 'checked="checked"';} ?> style="display:inline-block;">General Product
							</label>
							<label class="label_radio" for="radio-04" style="display:inline-block;">
								<input type="radio"  id="radio-04" name="product_type"  value="3" <?php if($produtType	==	3){ echo 'checked="checked"';} ?>style="display:inline-block;">Pre-Order Product
							</label>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</section>
			<?php 
			}
			?>
            <section class="panel">
            	<header class="panel-heading panel-heading1">
                	General Attributes
                </header>
                <div class="panel-body">
                	<div class="form-group">
                    	<label for="">Product Name</label>
                        <input type="text" placeholder="Product Name" name="product_name" class="form-control" value="<?php echo $result['product_name']; ?>">
						<?php echo form_error('product_name'); ?>
					</div>
				</div>
			</section>
			
			<section class="panel">
            	<header class="panel-heading panel-heading1">
                	Colors
                </header>
				<div class="panel-body">
                	<div class="form-group">
						<div class="col-lg-6">
						</div>
					</div>
					<div class="col-lg-12 padding_left_zero">
						<div class="form-group">
							<?php  $selectcolor	= set_value('selectcolor');
							if(empty($selectcolor))
							{
								if(isset($result['productcolorlist']) && empty($result['productcolorlist']) )
								{ 
									$selectcolor = 1;
								}
								else
								{
									$selectcolor = 2;
								}
							}
							?>
							<div class="radios " style="padding-top:0px !important;">																		 								<label class="label_radio" for="radio-01" style="display:inline-block;  margin-right: 20px;">
									<input type="radio"  id="radio-01" name="selectcolor" value="1" onclick="hide_color()" placeholder="" <?php if($selectcolor == 1){ echo 'checked="checked"';} ?>>NO
								</label>
								<label class="label_radio" for="radio-02" style="display:inline-block;">
									<input type="radio"  id="radio-02" name="selectcolor" onclick="show_color();" value="2" placeholder=""<?php if($selectcolor == 2){ echo 'checked="checked"';} ?>>Yes
								</label>
							</div>
						</div>
						
						<?php 
						if(isset($result['productcolorlist']) && !empty($result['productcolorlist']))
						{
							foreach($result['productcolorlist'] as $colordetail)
							{
								$product_color_array[] = $colordetail->colorId;
							}
						}
						else
						{
							$product_color_array = array();
						}
						?>
						<div class="form-group clearfix color-filter" id="color" style="<?php if($selectcolor==1) { echo 'display:none';}?>">
							<div class="col-sm-12 padding_left_zero" style="padding-bottom:5px;">
                            	<label>Add a New Color</label>
								<button title="Select Color" class="btn btn-success btn-xs" type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
							</div>
							<?php 
							if(isset($result['colorlist']) && !empty($result['colorlist']))
							{
								foreach($result['colorlist'] as $color)
								{
									if(in_array($color->colorId,$product_color_array))
									{
										$selected='checked="checked"';
									}
									else
									{
										$selected='';
									}
									?>
									<div class="block-element">
										<label>
											<input type="checkbox" name="color[]" value="<?php echo $color->colorId; ?>" <?php echo $selected; ?>>
											<small style="background-color:<?php echo $color->colorCode; ?>"></small>
										</label> 
									</div>
								 <?php
								 }
							 }
							 ?>			
						</div>
						
						<div class="error" ><?php echo form_error('color[]'); ?></div>
					</div>
				</div>
			</section>
			
			<section class="panel">
            	<header class="panel-heading panel-heading1">
                	Size
                </header>
				<div class="panel-body">
					<?php 
					$selectsize = set_value('selectsize');
					if(empty($selectsize))
					{
						if( empty($result['product_sizes']) )
						{ 
							$selectsize=1; 
						}
						else
						{
							$selectsize=2;
						}
					}
					else
					{
						$selectsize=$selectsize;
					}
					?>
					<div class="form-group">
						<div class="radios col-lg-12 padding_left_zero" style="padding-top:0px !important;">
							<label class="label_radio" for="radio-03" style="display:inline-block;  margin-right: 20px;">
								<input type="radio"  id="radio-03" name="selectsize" value="1" onclick="hide_size()" placeholder=""  <?php if($selectsize	==	1){ echo 'checked="checked"';} ?> style="display:inline-block;">NO
							</label>
							<label class="label_radio" for="radio-04" style="display:inline-block;">
								<input type="radio"  id="radio-04" name="selectsize" onclick="show_size();" value="2" placeholder=""<?php if($selectsize	==	2){ echo 'checked="checked"';} ?>style="display:inline-block;">Yes
							</label>                                             
						</div>
						<?php 
						$product_sizes= set_value('size');
						if(isset($result['product_sizes']) && empty($product_sizes))
						{
							$product_sizes=$result['product_sizes'];
						}
						?>																	  
						<div class="col-lg-12 padding_left_zero"  id="size" style="padding-bottom:10px; <?php if($selectsize == 1){ echo 'display:none'; }?>" >
							<div class="iconic-input right">
								<i class="fa fa"></i>
								<input type="text" class="form-control" name="size" placeholder="Enter Sizes (comma separated values)" value="<?php echo $product_sizes;?>" placeholder="">
							</div>
						</div>
						<div class="error"><?php echo form_error('size');?></div>
						<div class="clearfix"></div>
					</div>
				</div>
			</section>
		</div>
              
        <div class="col-sm-12 save-div">
        	<button class="btn btn-success btn-save">
				Save & Continue
			</button>
        </div>
		</form>
	<!--contant end-->
	</section>
	
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header" style="  border-radius: 0px;">
            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Select Color</h4>
			</div>
         <div class="modal-body" style="display:inline-block;">
            <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="col-sm-12 input-append colorpicker-default color" >
				<input type="text" readonly=""id="color_value" value="" class="form-control">
				<span class=" input-group-btn add-on">
					<button class="btn btn-default" type="button" style="padding: 8px; background:#fff !Important;">
						<i style="background-color: rgb(124, 66, 84);"></i>
					</button>
				</span>
			</div>
        </div>
        <div class="modal-footer">
        	<button type="button" class="btn btn-success"onclick="save_color()">
               Submit
            </button>
        </div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script>
$('.colorpicker-default').colorpicker({
	format: 'hex'
});
$('.colorpicker-rgba').colorpicker();

function save_color(e)
{
	swal({   
	title: '',   
	text: 'Are you sure You want to add This Color.',   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){  
	var color_value=$('#color_value').val();
		if (isConfirm) 
		{     
			$.ajax({
			type: "POST",
			url:'<?php echo base_url().$this->session->userdata('userType'); ?>/semantics/add_Color',
			data:'color_value='+color_value+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			success:function(result){
					$('#color').append(result);
								$('#myModal').modal('hide');
								swal("success fully Added the color","", "success");   
		
								}
		});
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
		return false;
}

$(document).ready(function() {
	$('.selectpicker').selectpicker();
});
function show_size()
{
	$('#size').css('display','block');
}
function hide_size()
{
	$('#size').css('display','none');
	
}

function show_color()
{
	$('#color').css('display','block');
}
function hide_color()
{
	$('#color').css('display','none');
	
}

function ttl_weight()
{	
	itemw = parseFloat($('#wghtItem').val());
	shipw = parseFloat($('#wghtShip').val());
	if((itemw=='')||(isNaN(itemw)))
	{
		itemw = 0;
	}
	if((shipw=='')||(isNaN(shipw)))
	{
		shipw = 0;
	}
	total = itemw+shipw;
	$('#wgthTotal').val(total);
}

function level2_list(level1ID)
{		
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level2_list/'+level1ID+'/<?php  echo $result['level2ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() { 
			$('#catAjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#catdiv').css('display','block');	
			$('#catAjaxId').html(result);
			level3_list($('#level2ID').val());
		}
	});	
}

function level3_list(level2ID)
{	
	if(level2ID)
	{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level3_list/'+level2ID+'/<?php  echo $result['level3ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#subCatAjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			if(result)
			{
				$('#subcat1div').css('display','block');
				$('#subCatAjaxId').html(result); 
				level4_list($('#level3ID').val());
			}
		}
	});	
	}
	else
	{
		$('#subcat1div').css('display','none');
		$('#subCatAjaxId').html(''); 
		$('#subcat2div').css('display','none');
		$('#subCat2AjaxId').html(''); 
		$('#subcat3div').css('display','none');
		$('#subCat3AjaxId').html(''); 
		$('#subcat4div').css('display','none');
		$('#subCat4AjaxId').html(''); 
		$('#subcat5div').css('display','none');
		$('#subCat5AjaxId').html(''); 
		$('#subcat6div').css('display','none');
		$('#subCat6AjaxId').html(''); 
	}
}

function level4_list(level3ID)
{
	if(level3ID)	
	{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level4_list/'+level3ID+'/<?php  echo $result['level4ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#subCat2AjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			if(result)
			{
				$('#subcat2div').css('display','block');
				$('#subCat2AjaxId').html(result);
				level5_list($('#level4ID').val());
			}
		}
	});	
	}
	else
	{
		$('#subcat2div').css('display','none');
		$('#subCat2AjaxId').html(''); 
		$('#subcat3div').css('display','none');
		$('#subCat3AjaxId').html(''); 
		$('#subcat4div').css('display','none');
		$('#subCat4AjaxId').html(''); 
		$('#subcat5div').css('display','none');
		$('#subCat5AjaxId').html(''); 
		$('#subcat6div').css('display','none');
		$('#subCat6AjaxId').html(''); 
	}
}

function level5_list(level4ID)
{	
	if(level4ID)	
	{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level5_list/'+level4ID+'/<?php  echo $result['level5ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#subCat3AjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			if(result)
			{
				$('#subcat3div').css('display','block');
				$('#subCat3AjaxId').html(result);
				//level6_list($('#level5ID').val());
			}
		}
	});	
	}
	else
	{
		$('#subcat3div').css('display','none');
			$('#subCat3AjaxId').html(''); 
			
		$('#subcat4div').css('display','none');
		$('#subCat4AjaxId').html(''); 
		$('#subcat5div').css('display','none');
		$('#subCat5AjaxId').html(''); 
		$('#subcat6div').css('display','none');
		$('#subCat6AjaxId').html(''); 
	}
}

function level6_list(level5ID)
{	
	if(level5ID)	
	{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level6_list/'+level5ID+'/<?php  echo $result['level6ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#subCat4AjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			if(result)
			{
				$('#subcat4div').css('display','block');
				$('#subCat4AjaxId').html(result);
				level7_list($('#level6ID').val());
			}
		}
	});
	}
	else
	{
		$('#subcat4div').css('display','none');
			$('#subCat4AjaxId').html(''); 
			$('#subcat5div').css('display','none');
		$('#subCat5AjaxId').html(''); 
		$('#subcat6div').css('display','none');
		$('#subCat6AjaxId').html(''); 
	}	
}

function level7_list(level6ID)
{	
	if(level6ID)
	{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level7_list/'+level6ID+'/<?php  echo $result['level7ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#subCat5AjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			if(result)
			{
				$('#subcat5div').css('display','block');
				$('#subCat5AjaxId').html(result);
				level8_list($('#level7ID').val());
			}
		}
	});	
	}
	else
	{
		$('#subcat5div').css('display','none');
			$('#subCat5AjaxId').html(''); 
		$('#subcat6div').css('display','none');
		$('#subCat6AjaxId').html(''); 
	}	
}

function level8_list(level7ID)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/level8_list/'+level7ID+'/<?php  echo $result['level8ID']; ?>',
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#subCat6AjaxId').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			if(result)
			{
				$('#subcat6div').css('display','block');
				$('#subCat6AjaxId').html(result);
			}
		}
	});	
}

<?php
if(!empty($result['level2ID']))
{
?>
	level2_list('<?php echo $result['level1ID']; ?>');
<?php
}
?>
</script>