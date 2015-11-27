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
					<form action="" method="post">
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
																		  <?php echo form_error('weight');?>
																	  </div>
																  </div>
																   <div class="form-group">
                                     
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Packaging Material Weight (in Kg)</label><span class="error">*</span>
																		  <div class="iconic-input right">
																			  <i class="fa fa">Kg</i>
																			  <input type="text" class="form-control" name="pakaging_material" value="<?php echo set_value('pakaging_material');?>" placeholder="">
																		  </div>
																		  <?php echo form_error('pakaging_material');?>
																	  </div>
																  </div>
																																	  
																   <div class="col-lg-12" style="padding:0px;">
																<div class="panel-body" style="line-height:30px;">
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
										<?php echo form_error('level1'); ?>
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
	  
<script type="text/javascript">
$('.selectpicker').selectpicker('show');


function cat_list(segmntID,level)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/sementics_category_list/'+segmntID+'/'+level,
		beforeSend: function() {
			$('#level'+level).html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			$('#level'+level).html(result);
		}
	});	
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
</style>