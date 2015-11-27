<link href="<?php echo base_url() . 'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css"/>
<style>
    label {
        background-image: none;
    }

    .chosen-container-single .chosen-single {
        background: none !important;
        border: 1px solid #CCC !important;
        border-radius: 4px !important;
    }

    .panel-heading .nav > li > a {
        font-size: 15px;
        font-weight: 600;
    }

    .nav-justified {
        background: #bcc1c5;
    }

    .table-invoice > thead > tr > th {
        color: #FFF;
    }

    .btn-reqt {
        border: 1px solid #ccc;
    }

    .notifi {
        position: absolute !important;
        top: -8px !important;
    }

    input[type=radio] {
        display: inline-block !important;
    }

    #header_notification_bar {
        list-style-type: none !important;
        float: left;
        padding-left: 20px;
    }
</style>
<?php
$productWeight = $inventorydetail->weight+$inventorydetail->shippingWeight;
$priceArr      = $this->product_lib->show_product_price_array($inventorydetail->organizationProductId);
$displayPrice  = $priceArr['displayPrice'];
?>
<section id="main-content">
    <section class="wrapper">
        <!--contant start-->
        <div class="row">
            <div class="col-md-12">
            	<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management'; ?>">Products Management</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_marketing_management'; ?>">Campaign Management Products</a>
					</li>
                    <li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/product_marketing_management/history_list'; ?>">Campaign Management Products History</a>
					</li>
                    <li>
						<a href="javascript:void(0);" class="current">History View</a>
					</li>                    
				</ul>
                
                
            </div>

            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading panel-heading1">
                        Marketing Product Detail
                    </header>
                    	<section class="panel custom-panel">
                            <div class="panel-body">
                               
                                <div class="col-sm-12">
                                    
                                </div>
                                <div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
                                    <aside class="profile-nav col-lg-3 padding_left_zero">
                                        <section class="panel">
                                            <div class="user-heading round">
                                                <a href="javascript:void(0);">
                                                    <?php
if((!empty($product_data->imageName))&&(file_exists('uploads/product/thumb500_500/'.$product_data->imageName)))
{
	echo '<img src="'.base_url().'uploads/product/thumb500_500/'.$product_data->imageName.'" height="70" width="70" />';
}
elseif((!empty($product_data->imageName))&&(file_exists('uploads/product/'.$product_data->imageName)))
{
	echo '<img src="'.base_url().'uploads/product/'.$product_data->imageName.'" height="70" width="70" />';
}
else
{
	echo '<img src="'.base_url().'img/no_image.jpg" height="70" width="70"/>';
}
?>	
            </a>
								
                                                <h1><?php echo $product_data->code; ?></h1>
												
                                            </div>
                                        </section>
                                    </aside>
                                    <aside class="profile-info col-lg-9 " style="padding-right:0px;">

                                        <section class="panel">
                                            <div class="panel-body bio-graph-info">
                                                <div class="row">
															<div class="form-group">
															<div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Business Name</label>
																		  <div class="iconic-input ">
																			  <?php echo $inventorydetail->organizationName; ?>
																		  </div>
																		 <div class="error" >  <?php //echo form_error('cost');?></div>
																	  </div>
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Business Owner Name</label><div class="iconic-input ">
																			  <?php echo $inventorydetail->firstName.' '.$inventorydetail->lastName; ?>
																		  </div>
																		 <div class="error" >  <?php //echo form_error('cost');?></div>
																	  </div>
																	  <?php if(empty($colorsize)){ ?>
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Inventory Details</label><div class="iconic-input ">
																			<?php echo $inventorydetail->currentQty;?>
                                                                            </div>
																		 <div class="error" >  </div>
																	  </div>
																	  
																	    <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Flash sale Inventory</label><div class="iconic-input ">
																			  <i class="fa fa"></i> 
																			  <?php echo $inventory_details; ?>
																	  </div>
																  </div>
																	  <?php }
else
{	
	//echo "<pre>"; print_r($colorsize); exit;
	$colorSizeArr = array();
	foreach($colorsize as $key=>$colorsizedetail)
	{
		$sizeId = trim($colorsizedetail->size);
		$colorSizeArr[$colorsizedetail->colorId]['colorCode'] = $colorsizedetail->colorCode;
		$colorSizeArr[$colorsizedetail->colorId]['size'][$sizeId]['size'] = $sizeId;
		$colorSizeArr[$colorsizedetail->colorId]['size'][$sizeId]['currentStock'] = $colorsizedetail->currentStock;
	}
	
	if(!empty($colorSizeArr))	
	{
		$i = 0;
		foreach($colorSizeArr as $key=>$value)
		{
		
	?>
	<div class="col-lg-6" style="padding-bottom:10px;">
		<label>Inventory Details</label>
			<table width="100%" class="table table-custom table-invoice">
			<tbody> 
			<tr><td><strong>Sizes</strong></td><td><strong>Stock</strong></td><td><strong>FLASH SALE INVENTORY</strong></td></tr>
			<tr>
				<td colspan="3">
					<small style="  top: 2px;  position: relative;background-color:<?php echo $value['colorCode']; ?>"></small>
				</td>
			</tr>
			<?php
			$currentStock = '';
			if(!empty($value['size']))
			{
				foreach($value['size'] as $size)
				{
			?>
	  		<tr>
				<td><?php echo $size['size']; ?></td>
				<td>
					<?php 
					$currentStock = $size['currentStock'];
					echo $size['currentStock']; 
					?>
				</td>
				<td><div class="iconic-input ">
			<i class="fa fa"></i> 
			
            <?php 
			if(isset($inventory_details[$key.$size['size']]))
			{ 
				echo $inventory_details[$key.$size['size']]; 
			}
			?></div></td>
			</tr>
			<?php
					$i++;
				}
			}
			?>			
			</tbody>
		</table>
	</div>
	<?php
		}
	}
}
?>
																	  <div class="col-lg-6" style="padding-bottom:10px;">
<label>Actual Price</label>
<div class="iconic-input ">
₦<?php echo $displayPrice; ?>
</div>
</div>
																	  	  <div class="col-lg-6" style="padding-bottom:10px;">
<label>Effective sales price</label>
<div class="iconic-input ">
₦<?php echo $result['sale'];?>
</div>
</div>
																	   <div class="col-lg-6" style="padding-bottom:10px;">
<label>Discount</label>
<div class="iconic-input ">
₦<?php echo $result['discountPrice'];?>
</div>
			</div>														  
															
																	   <div class="col-lg-6" style="padding-bottom:10px;">
<label>Discount pay by spacepointe</label>
<div class="iconic-input ">
₦<?php echo $result['spacepointeDiscount'];?>
</div>
</div>
																	  <div class="col-lg-6" style="padding-bottom:10px; padding-right:0px;">
<label>Discount pay by retailer</label>
<div class="iconic-input ">
₦<?php echo $result['retailerDiscount'];?>
</div>
</div>
																	
<div class="col-lg-6" style="padding-bottom:10px;">
<label>Effective Date From</label>
<div class="iconic-input ">
<?php echo $result['datefrom']; ?>
</div>
</div>
	<div class="col-lg-6" style="padding-bottom:10px;">
		<label>Effective Date To</label>
		<div class="iconic-input ">
		<?php echo $result['dateto']; ?>
		</div>
	</div>

<div class="col-lg-6" style="padding-bottom:10px;">
		<label>Category</label>
		<div class="iconic-input ">
		  <?php
                                                                if (!empty($catlist)) 
																{
                                                                	foreach($catlist as $row) 
																	{
                                                                    	if($result['category_listing'][0]==$row->categoryId)
																		{ 
																			echo $row->categoryCode; 
																		}
                                                                     }
                                                                }
                                                                ?>
																</div>
	</div>
                                                        
                                                    </div>
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

<style>
    .form-group {
        display: inline;
    }

    .padding_left_zero {
        padding-left: 0px;
    }

    .padding_right_zero {
        padding-right: 0px;
    }

    .semantics_box {

    }

    .one_box {
        bottom: 0;
        box-shadow: 0 -1px 0 #e5e5e5, 0 0 2px rgba(0, 0, 0, .12), 0 2px 4px rgba(0, 0, 0, .24);
        padding: 5px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .one_box tr td {
        padding: 5px;
        font-weight: bold;
    }

    dl {
        margin: 0px;
    }

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

    .colorpicker {
        z-index: 10000;
    }

small {
  border: 1px solid #DDDDDD;
  display: inline-block;
  height: 14px;
  margin: 0 3px 0 1px;
 width: 100%;
}
</style>