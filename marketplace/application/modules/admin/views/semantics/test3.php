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
small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 14px;
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
							 Review
					</header>						
					<section class="panel custom-panel">	
							<div class="panel-body">
<?php 
echo form_open();
?>
<center>
	<img src="<?php echo base_url(); ?>images/step3.png" class="img-responsive"  width="40%"/>
</center>
<?php
if((!empty($product_data->productTypeId))&&($product_data->productTypeId==3))
{
	if(($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='cse'))
	{
?>
Product Price 
<input type="text" name="product_price" value="<?php echo set_value('product_price'); ?>" />
<?php
echo form_error('product_price');
	}
}
?>
<div class="col-sm-12"> <button class="btn btn-success pull-right" name="submit" type="submit">Save</button></div>
</form>
									<div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																	<aside class="profile-nav col-lg-3 padding_left_zero">
																	  <section class="panel">
																		  <div class="user-heading round">
																			  <a href="#"> <?php if(isset($product_data->imageName) && !empty($product_data->imageName))
																						{ ?>
																						<img src="<?php echo base_url();?>uploads/product/<?php echo$product_data->imageName;?>" alt="">
																				<?php	 } ?></a>
																				<h1>
																						<?php print_r($product_data->code);?></h1>											
																		  </div>
																	  </section>
																	</aside>
																	<aside class="profile-info col-lg-9 " style="padding-right:0px;">
																							  
																   <section class="panel">															  
															  	   <div class="panel-body bio-graph-info">																  
																   <div class="row">
																    <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label>Brand Name </label>
																			  <div class="iconic-input right">																	  
																				  <?php echo $product_data->brandName;?>
																			  </div>
																		  </div>
																	  </div>
																	  <?php if(!empty($product_data->mrp)){ ?>
																	  <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label>MRP </label>
																			  <div class="iconic-input right">																	  
																				  <?php echo '&#x20A6;'.$product_data->mrp;
																				  ?>
																			  </div>
																		  </div>
																	  </div>
																	  <?php }?>
																	    <?php if(!empty($product_data->sizes)){ ?>
																	  <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label>Size </label>
																			  <div class="iconic-input right">																	  
																				  <?php echo $product_data->sizes;
																				  ?>
																			  </div>
																		  </div>
																	  </div>
																	  <?php }?>
																	   <?php  if(isset($productcolorlist) && !empty($productcolorlist)){
	?>
<div class="col-sm-6" style="padding-left:0px;">
  <section class="panel">
    
    <div class="panel-body">     
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%" class="">
          <tr>
            <td width=""><strong>Colors</strong></td>
			</tr>
			<tr>
			
            <td width="80%">
			<?php foreach($productcolorlist as $product_color){
											
								
                                       
                                        	echo ' <small style="background-color:'.$product_color->colorCode.'"></small>
																			  ';
											
									} ?></td>
          </tr>
		  
        </table>
      </div>      
    </div>
  </section>
</div>
<?php }?>
																	  	  <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label>weight </label>
																			  <div class="iconic-input right">																	  
																				  <?php echo $product_data->weight.'Kg';
																				  ?>
																			  </div>
																		  </div>
																	  </div>
																	  	  <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label>packaging material </label>
																			  <div class="iconic-input right">																	  
																				  <?php echo $product_data->shippingWeight.'Kg';
																				  ?>
																			  </div>
																		  </div>
																	  </div>
																  
																 <div class="form-group">                                     
																	 <?php foreach($product_detail as $product_value)
																	  {
																	   ?>
																	   <div class="form-group">                                     
																		  <div class="col-lg-6 padding-bottom">
																		  <label><?php echo $product_value->productAttributeName;?> </label>
																			  <div class="iconic-input right">																	  
																				  <?php echo $product_value->attributeValue;?>
																			  </div>
																		  </div>
																	  </div>
																	  <?php 
																	  }
																	  ?>
																   
																   
																   </div>
															  </div>
															 
														  </section>						   
																	 </aside>
																	</div>
							</div>						
							</section>
                </section>
            </div>
              </div>
              <!--contant end-->
          </section>
      </section>
	  
<script type="text/javascript">
$('.selectpicker').selectpicker('show');


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