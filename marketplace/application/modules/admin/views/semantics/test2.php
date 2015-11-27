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

input[type=radio] {
	 display:inline-block !important;
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
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
				
					<li>
						<a href="javascript:void(0);" class="">Semantics List</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Add</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
					<header class="panel-heading panel-heading1">
							 Add Details	
					</header>
					<?php echo form_open();?>
					<section class="panel custom-panel">	
							<div class="panel-body">
							<center><img src="<?php echo base_url(); ?>images/step2.png" class="img-responsive"  width="40%"/></center>
								<div class="col-sm-12"> <button class="btn btn-success pull-right" type="submit">Save & Continue</button></div>
									<div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																	<aside class="profile-nav col-lg-3 padding_left_zero">
																	  <section class="panel">
																		  <div class="user-heading round">
																			  <a href="#">
																			  <?php 
																			  if(isset($product_data->imageName))
																						{ ?>
																						<img src="<?php echo base_url();?>uploads/product/<?php echo$product_data->imageName;?>" alt="">
																				<?php	 } ?></a>
																				<h1><?php echo $product_data->code;?></h1>
																																
																		  </div>
																	  </section>
																	</aside>
																	<aside class="profile-info col-lg-9 " style="padding-right:0px;">
																							  
																   <section class="panel">															  
															  	   <div class="panel-body bio-graph-info">																  
																   <div class="row">
																 
																 
																   <div class="form-group">
                                     
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Item Weight (in Kg)</label><span class="error">*</span>
																		  <div class="iconic-input right">
																			  <i class="fa fa">Kg</i> 
																			  <input type="text" class="form-control" name="weight" value="<?php echo set_value('weight');?>" placeholder="">
																		  </div>
																		 <div class="error" >  <?php echo form_error('weight');?></div>
																	  </div>
																  </div>
																   <div class="form-group">
                                     
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Packaging Material Weight (in Kg)</label><span class="error">*</span>
																		  <div class="iconic-input right">
																			  <i class="fa fa">Kg</i>
																			  <input type="text" class="form-control" name="pakaging_material" value="<?php echo set_value('pakaging_material');?>" placeholder="">
																		  </div>
																	 <div class="error" >  <?php echo form_error('pakaging_material');?></div>
																	  </div>
																  </div>
																  <input type="hidden"  id="radio-01" name="product_type" value="0" >
<?php 
$userType = $this->session->userdata('userType');
if((!empty($userType))&&(($userType!='retailer')))
{
?>
<div class="form-group">
	<div class="col-lg-6">
		<label>Product Type</label>
	</div>
</div>
<div class="form-group">
	<div class="radios col-lg-12" style="padding-top:0px !important;">
		<label class="label_radio" for="radio-01_genral" style="display:inline-block;  margin-right: 20px;">
			<input type="radio"  id="radio-01_genral" name="product_type" value="2"  placeholder="" <?php echo set_radio('product_type', '2',TRUE); ?>>General Product
		</label>
		<label class="label_radio" for="radio-02_pseudo" style="display:inline-block;">
			<input type="radio"  id="radio-02_pseudo" name="product_type"  value="3" placeholder=""<?php echo set_radio('product_type', '3'); ?> >Pre-Order Product
		</label>                                             
	</div>
	<div class="error" >  <?php echo form_error('product_type');?></div>
</div>
<?php 
}
?>
																  
																  <div class="form-group">
																  <div class="col-lg-6">
																   <label>Allow Size For Product</label>
																   </div>
																  </div>
																   <div class="form-group">
																	  <div class="radios col-lg-12" style="padding-top:0px !important;">																		 
																		  <label class="label_radio" for="radio-01" style="display:inline-block;  margin-right: 20px;">
																			 <input type="radio"  id="radio-01" name="selectsize" value="1" onclick="hide_size()" placeholder="" <?php echo set_radio('selectsize', '1',TRUE); ?>>NO
																		  </label>
																		  <label class="label_radio" for="radio-02" style="display:inline-block;">
																			   <input type="radio"  id="radio-02" name="selectsize" onclick="show_size();" value="2" placeholder=""<?php echo set_radio('selectsize', '2'); ?> >Yes
																		  </label>                                             
																	  </div>	 
																	  <?php $selectsize=set_value('selectsize');
																	  //print_r($selectsize);
																	  if(empty($selectsize)){
																		  $selectsize=1;
																	  }
																	  ?>
																	  <div class="col-lg-12" style="padding-bottom:10px; <?php if($selectsize==1) { echo 'display:none';}?>" id="size">
																	 
																		  <div class="iconic-input right">
																			  <i class="fa fa"></i>
																		 	  <input type="text" class="form-control" name="size" placeholder="Enter Sizes (comma separated values)" value="<?php echo set_value('size');?>" placeholder="">
																		  </div>
																		 <div class="error" > <?php echo form_error('size');?></div>
																	  </div>
																  </div><div class="clearfix"> </div>
																    <div class="form-group">
																  <div class="col-lg-6">
																   <label>Colors</label>
																   </div>
																  </div>
                                                                  <div class="col-lg-12">
																  <div class="form-group">
																	  <div class="radios " style="padding-top:0px !important;">																		 
																		  <label class="label_radio" for="radio-01" style="display:inline-block;  margin-right: 20px;">
																			 <input type="radio"  id="radio-01" name="selectcolor" value="1" onclick="hide_color()" placeholder="" <?php echo set_radio('selectcolor', '1',TRUE); ?>>NO
																		  </label>
																		  <label class="label_radio" for="radio-02" style="display:inline-block;">
																			   <input type="radio"  id="radio-02" name="selectcolor" onclick="show_color();" value="2" placeholder=""<?php echo set_radio('selectcolor', '2'); ?> >Yes
																		  </label>                                             
																	  </div>
																	  </div>
																	  	  <?php $selectcolor=set_value('selectcolor');
																		   if(empty($selectcolor)){
																		  $selectcolor=1;
																	  }?>
																  <div class="form-group clearfix color-filter" id="color"  style="<?php if($selectcolor==1) { echo 'display:none';}?>">
																  	<div class="col-sm-12" style="padding-left:0px;">
                                                                    
                                                                    <label>Add a new color</label> <button title="Select Color" class="btn btn-success btn-xs" type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
																		  
																	  </div>
																<?php 
																if(isset($colors) && !empty($colors))
																foreach($colors as $color)
																{
																	echo '  <div class="block-element">
																			<label>
																			 <input type="checkbox" name="color[]" value="'.$color->colorId.'" '.set_checkbox('color[]',$color->colorId).'>
																			 <small style="background-color:'.$color->colorCode.'"></small>
																			  
																			</label> 
																		   </div> ';
																}		
																?>			
																		
																	<div class="error" ><?php echo form_error('color[]'); ?></div>
																  </div>
															
																	 
																	  
																 																	  
<div class="col-lg-12" style="padding:0px;">
	<div class="panel-body" style="line-height:30px;padding:0px;">
    	<div class="form-group">
        	<label for="">select Category</label><span class="error">*</span>
			<select class="chosen-select form-control" data-live-search="true" name="level1" onchange="cat_list(this.value,1);">
				<option value="">select category</option>
				<?php 
				if(!empty($catlist))
				{
					foreach($catlist as $row)
					{
				?>
				<option value="<?php echo $row->categoryId; ?>" <?php if((!empty($result['level1']))&&($result['level1']==$row->categoryId)){ ?> selected="selected" <?php } ?>>
					<?php echo $row->categoryCode; ?>
				</option>
				<?php										
					}
				}
				?>
			</select>
			<div class="error" ><?php echo form_error('level1'); ?></div>
		</div>
		
		<div class="form-group">
        	<div id="level1">
            </div>
			<?php echo form_error('category_id'); ?>
		</div>
                                    
                                    <div class="form-group" id="subcat1div">
                                        
                                        <div id="level2">
                                            
                                        </div>
                                        <?php echo form_error('sub_category1_id'); ?>
                                    </div>
                                    
                                    <div class="form-group" id="subcat2div">
                                        
                                        <div id="level3">
                                            
                                        </div>
                                        <?php echo form_error('sub_category2_id'); ?>
                                    </div>
                                    
                                    <div class="form-group" id="subcat3div">
                                        
                                        <div id="level4">
                                        
                                        </div>
                                        <?php echo form_error('sub_category3_id'); ?>
                                    </div>
                                    
                                    <div class="form-group" id="subcat4div">
                                      
                                        <div id="level5">
                                        
                                        </div>
                                        <?php echo form_error('sub_category4_id'); ?>
                                    </div>
                                    
                                    <div class="form-group" id="subcat5div">
                                        
                                        <div id="level6">
                                        
                                        </div>
                                        <?php echo form_error('sub_category5_id'); ?>
                                    </div>
                                    
                                  
                            </div>
																  
																   
																   </div>
															  </div>
															 
														  </section>						   
																	 </aside>
																	</div>
							</div>						
							</section>	
</form>							
				</section>
            </div>
              </div>
              <!--contant end-->
          </section>
      </section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header" style="  border-radius: 0px;">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
              Select Color
            </h4>
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
</div><!-- /.modal -->	  
<script type="text/javascript">
$('.selectpicker').selectpicker('show');


function cat_list(segmntID,level)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/sementics_category_list/'+segmntID+'/'+level,
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#level'+level).html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#level'+level).html(result);
		}
	});	
}

<?php
if($_POST)
{
	if(!empty($_POST['level1']))
	{
		$i = 1;
		foreach($_POST as $postKey=>$postVal)
		{
			if(!empty($_POST['level'.$i]))
			{
			?>
			cat_list('<?php echo $_POST['level'.$i]; ?>','<?php echo $i; ?>');
			<?php
				$i++;
			}
		}
	}
}
?>

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
</script>
<style>
.form-group {
  display: inline;
}
.padding_left_zero{
	padding-left:0px;
}
.padding_right_zero{
	padding-right:0px;
}
.semantics_box{

}
.one_box{ bottom: 0;
  box-shadow: 0 -1px 0 #e5e5e5,0 0 2px rgba(0,0,0,.12),0 2px 4px rgba(0,0,0,.24);
  padding:5px; cursor:pointer; margin-bottom:10px;
 }
.one_box tr td{ padding:5px; font-weight:bold; } 
dl{ margin:0px;}
dd { 
    display: inline-block;
    margin-left: 14px;
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
</style>
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
			data:'color_value='+color_value,
			beforeSend: function() {
				
			},
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
</script>