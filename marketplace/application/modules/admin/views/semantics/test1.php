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

.edit-samentics-label i{color:#39B2A9;
	padding-left:4px;
}
</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog segment-model">
           <div class="modal-content">
              <div class="modal-header modal-header1 segment-header">
              	 <button type="button" class="close close-btn" data-dismiss="modal"><span aria-hidden="true"><img src="<?php echo base_url();?>img/close.png"></span><span class="sr-only">Close</span></button>
            
         	 </div>
             <div class="modal-body modal-body-custom">
             	<section class="panel" style="margin-bottom:0;">
                  <header class="panel-heading rform-header">
                         Edit Attibute
                      </header>
                          <div class="panel-body">
                              <div class="tab-content">
                                  <div class="tab-pane active" id="home">
									<!--<form action="" id="change_Attribute_name">-->
									<?php 
									$attr=array('id'=>'change_Attribute_name');
									echo form_open('',$attr);?>
									 <div class="row">
                                          <div class="col-sm-12  form-div">
                                           		<div class="col-sm-12" style="margin-top:15px;">
                                                	<input type="text" id="attribute_value" class="form-control model-input" placeholder="Enter Attibute Name">
                                                </div>
                                          </div>
                                          <div class="col-sm-12 form-div">
                                          	  <div class="col-sm-12 text-right">
                                              	<button class="btn btn-success" onclick="return save_attribute()">Save</button>
                                              	<button class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                              </div>
                                          </div>
                                      </div>
									  </form>
                                  </div>
                              </div>
                          </div>
                 </section>
          </div>
        </div>
      </div>
    </div>

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
							 Add Product
					</header>
				<?php echo form_open();?>
					<section class="panel custom-panel">	<br />
					<center><img src="<?php echo base_url(); ?>images/step1.png" class="img-responsive"  width="40%"/></center>
							 <div class="panel-body">
								
									<div class="col-sm-12"><button class="btn btn-success pull-right" type="submit" style="  MARGIN-LEFT: 10PX;">Next</button></div>
										<div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																		<aside class="profile-nav col-lg-3 padding_left_zero">
																		  <section class="panel">
																			  <div class="user-heading round">
																				  <a href="#">
<?php 
if(isset($product_data->imageName))
{
?>
<img src="<?php echo base_url();?>uploads/product/<?php echo$product_data->imageName;?>" alt="">
<?php	 
} 
?></a>
																				</br>
																				<h1>Product Name</h1>
																						<textarea name="name" class="form-control"><?php echo $product_data->code;?></textarea>
																						<?php echo form_error('name');?>
																			  </div>
																		  </section>
																		</aside>
																		<aside class="profile-info col-lg-9" style="padding-right:0px;">
																								  
																	   <section class="panel">															  
																	   <div class="panel-body bio-graph-info">																  
																	   <div class="row">
																	    <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label>Brand  </label>
																			  <div class="iconic-input right">																	  
																				 <select name="brand" class="form-control selectpicker" data-live-search="true">
																				 <?php foreach($brand_list as $branddetail)
																				 {
																					 if($product_data->brandId==$branddetail->brandId)
																					 {
																						 $selected='selected="selected"';
																					 }
																					 else
																					 {
																						 $selected='';
																						 
																					 }
																					 echo ' <option value="'.$branddetail->brandId.'" '.$selected.'>'.$branddetail->brandName .'</option>';
																				 }
																				?>
																				 </select>
																			  </div>
																		  </div>
																	  </div>
																	  <?php foreach($product_detail as $product_value)
																	  {
																	   ?>
																	   <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label id="attribute_text<?php echo id_encrypt($product_value->attributeNameId);?>"><?php echo $product_value->productAttributeName;?></label>
																		   <a onclick="update_attribute(<?php echo id_encrypt($product_value->attributeNameId);?>);" class="edit-samentics-label" style="cursor:pointer;"><i class="fa fa-pencil" title="Edit"></i></a>
																		    <a onclick="delete_attribute(<?php echo id_encrypt($product_value->attributeNameId);?>,<?php echo $product_value->orgProductAttributeId;?>);" class="danger edit-samentics-label" style="cursor:pointer;color:#E21D1D"><i class="fa fa-times danger" style="color:#E21D1D" title="delete"></i></a>
																			  <div class="iconic-input right">																	  
																				 <textarea name="feature[<?php echo $product_value->orgProductAttributeId;?>]"class="form-control" ><?php echo $product_value->attributeValue;?></textarea
>																			  </div>
																		  </div>
																	  </div>
																	  <?php 
																	  }
																	  ?>
																	  
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
	  
<script type="text/javascript">
$('.selectpicker').selectpicker('show');

function update_attribute(attribute_id)
{
	var name=$('#attribute_text'+attribute_id).text();
	$('#attribute_value').val(name);
	
	$('#attribute_value').attr("name", attribute_id);
	
	$('#myModal').modal('show');
	
	}
	function delete_attribute(attribute_id,attrvalu_id)
{
	swal({   
	title: '',   
	text: 'Are you sure You want to delete Attribute.',   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){  
	//var form_value=$('#change_Attribute_name').serialize();
		if (isConfirm) 
		{     
			$.ajax({
			type: "POST",
			url:'<?php echo base_url().$this->session->userdata('userType'); ?>/semantics/delete_attribute',
			data:'attribute_id='+attribute_id+'&attribute_value='+attrvalu_id,
			beforeSend: function() {
				
			},
			success:function(result){
					console.log(result);
								swal("success fully deleted the attribute","", "success");  
location.reload();								
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
function save_attribute(e)
{

	swal({   
	title: '',   
	text: 'Are you sure You want to Change Attribute.',   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){  
	var form_value=$('#change_Attribute_name').serialize();
		if (isConfirm) 
		{     
			$.ajax({
			type: "POST",
			url:'<?php echo base_url().$this->session->userdata('userType'); ?>/semantics/update_attribute',
			data:form_value,
			beforeSend: function() {
				
			},
			success:function(result){
					$('#myModal').modal('hide');
					var data=$.parseJSON(result);
					$.each(data, function(key, value){
						$('#attribute_text'+key).text(value);
						});
								swal("success fully changed the attribute","", "success");   
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
<style>
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

.form-group {
  vertical-align:top;
  display: initial;
}
.padding-bottom { padding-bottom:10px;}
</style>