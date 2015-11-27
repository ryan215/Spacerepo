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
$productWeight = $inventorydetail->productId+$inventorydetail->shippingWeight;
$priceArr  	   = $this->product_lib->show_product_price_array($inventorydetail->organizationProductId);
$displayPrice  = $priceArr['displayPrice'];
?>
<script>
function set_discount(value)
{
	if(value>=0)
	{
		var actualprice =<?php echo $displayPrice; ?>;
		var discount = actualprice-value;
		$('.discount').val(discount);
		$('#spacepointediscount').val('');
		$('#retailerdiscount').val('');
	}
	else
	{
		$('.discount').val('');
	}
}
function set_spacepointe_amount(value)
{
	var discount=$('.discount').val();
	var spacepointeprice=discount-value;
	$('.spacepointediscount').val(spacepointeprice)
}
function set_retailer_amount(value)
{
	var discount=$('.discount').val();
	var retailerprice=discount-value;
	$('.retailerdiscount').val(retailerprice)
}
</script>

<section id="main-content">
    <section class="wrapper">
        <!--contant start-->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumbs-alt animated fadeInLeft">

                    <li>
                        <a href="<?php echo base_url().'admin/product_management'; ?>">Product Management</a>
                    </li>
					<li>
                        <a href="javascript:void(0);" class="current">Add Detail</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading panel-heading1">
                        Add Marketing Product Detail
                    </header>
                  <?php echo form_open();?>
                        <section class="panel custom-panel">
                            <div class="panel-body">
                               
                                <div class="col-sm-12">
                                    <button class="btn btn-success pull-right" type="submit">Save & Continue</button>
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
																	  <label>Business Name</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <?php echo $inventorydetail->organizationName; ?>
																		  </div>
																		 <div class="error" >  <?php //echo form_error('cost');?></div>
																	  </div>
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Business Owner Name</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <?php echo $inventorydetail->firstName.' '.$inventorydetail->lastName; ?>
																		  </div>
																		 <div class="error" >  <?php //echo form_error('cost');?></div>
																	  </div>
																	  <?php if(empty($colorsize)){ ?>
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Inventory Details</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			 
																			  <input type="text" readonly class="form-control" name="currentqty" value="<?php echo $inventorydetail->currentQty;?>" placeholder="">
																		  </div>
																		 <div class="error" >  </div>
																	  </div>
																	  
																	    <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Flash sale Inventory</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <i class="fa fa"></i> 
																			  <input type="number" max="<?php echo $inventorydetail->currentQty;?>" class="form-control" name="inventory" min="0" value="<?php echo set_value('inventory');?>" placeholder="">
																		
																		 <div class="error" >  <?php echo form_error('inventory');?></div>
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
			<tr><td><strong>Sizes</strong></td><td><strong>Stock</strong></td><td><strong>FLASH SALE INVENTORY</strong><span class="error">*</span></td></tr>
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
			<input type="number" max="<?php echo $currentStock; ?>"class="form-control" name="<?php echo 'inventoryarr_'.$key.preg_replace('/[^A-Za-z0-9\-]/','',$size['size']); ?>" value="<?php echo set_value('inventoryarr_'.$key.$size['size']); ?>" placeholder="" min="0" >
			<div class="error" >  <?php echo form_error('inventoryarr_'.$key.preg_replace('/[^A-Za-z0-9\-]/','',$size['size']));?></div>
		</div></td>
			</tr>
			<?php
					$i++;
				}
			}
			?>			
			</tbody>
		</table>
		<div class="iconic-input ">
			
		 	
			
		</div>
		<div class="error" >  </div>
	</div>
	
	<?php
		}
	}
	
	
}
?>
																	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Actual Price</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <i class="fa fa">₦</i> 
																			  <input type="text" readonly class="form-control" name="cost" value="<?php echo $displayPrice; ?>" placeholder="">
																		  </div>
																		 <div class="error" >  <?php //echo form_error('cost');?></div>
																	  </div>
																	  	  <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Effective sales price</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <i class="fa fa">₦</i> 
																			  <input type="text" class="form-control" onkeyup="set_discount(this.value)" onblur="set_discount(this.value)" name="sale" value="<?php echo set_value('sale');?>" placeholder="">
																		  </div>
																		 <div class="error" >  <?php echo form_error('sale')//echo form_error('sale');?></div>
																	  </div>
																	   <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Discount</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <i class="fa fa">₦</i> 
																			 <input type="text" readonly class="form-control discount" name="discount" value="<?php echo set_value('discount');?>" placeholder="">
																		  </div>
																		 <div class="error" >  <?php echo form_error('discount');?></div>
																	  </div>
																	  <div class="col-lg-12">
																	   <div class="col-lg-6" style="padding-bottom:10px; padding-left:0px;">
																	  <label>Discount pay by spacepointe</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <i class="fa fa">₦</i> 
																			 <input type="text"  min="0" class="form-control spacepointediscount" name="spacepointediscount" id="spacepointediscount" onkeyup="set_retailer_amount(this.value);" onblur="set_retailer_amount(this.value);" value="<?php echo set_value('spacepointediscount');?>" placeholder="">
																		  </div>
																		 <div class="error" >  <?php echo form_error('spacepointediscount');?></div>
																	  </div>
																	  <div class="col-lg-6" style="padding-bottom:10px; padding-right:0px;">
																	  <label>Discount pay by retailer</label><span class="error">*</span>
																		  <div class="iconic-input ">
																			  <i class="fa fa">₦</i> 
																			 <input type="text" min="0"  class="form-control retailerdiscount" onkeyup="set_spacepointe_amount(this.value);" onblur="set_spacepointe_amount(this.value);" name="retailerdiscount" id="retailerdiscount" value="<?php echo set_value('retailerdiscount');?>" placeholder="">
																		  </div>
																		 <div class="error" >  <?php echo form_error('retailerdiscount');?></div>
																	  </div>
																	  </div>
																	    <div class="col-lg-6" style="padding-bottom:10px;">
																	  		<label>Effective Date From</label><span class="error">*</span>
                                                                      
																		 
																			
																			  <input type="text" class="form-control default-date-picker" name="datefrom" value="<?php echo set_value('datefrom');?>" placeholder="">
																		  
                                                                          
																		 <div class="error" >  <?php echo form_error('datefrom');?></div>
																	  </div>
																	    <div class="col-lg-6" style="padding-bottom:10px;">
																	  <label>Effective Date To</label><span class="error">*</span>
																		
																			  <input type="text" class="form-control default-date-picker" name="dateto" value="<?php echo set_value('dateto');?>" placeholder="">
																			  <div class="error" >  <?php echo form_error('dateto');?></div>
																		  </div>
																		 
																	  </div>
																	

                                                </div>


                                                <div class="col-lg-12" style="padding:0px;">
                                                    <div class="panel-body" style="line-height:30px;padding:0px;">
                                                        <div class="form-group">
                                                            <label for="">select Category</label><span
                                                                class="error">*</span>
                                                            <select class="chosen-select form-control"
                                                                    data-live-search="true" name="level1"
                                                                    onchange="cat_list(this.value,1);">
                                                                <option value="">select category</option>
                                                                <?php
                                                                if (!empty($catlist)) {
                                                                    foreach ($catlist as $row) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $row->categoryId; ?>" <?php if ((!empty($result['level1'])) && ($result['level1'] == $row->categoryId)) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $row->categoryCode; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>

                                                            <div class="error"><?php echo form_error('level1'); ?></div>
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


    function cat_list(segmntID, level) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->session->userdata('userType'); ?>/category_management/marketing_category_list/' + segmntID + '/' + level,
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
            beforeSend: function () {
                $('#level' + level).html('<?php echo $this->loader; ?>');
            },
            success: function (result) {
                $('#level' + level).html(result);
            }
        });
    }
</script>
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
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-colorpicker/css/colorpicker.css"/>
<script type="text/javascript"
        src="<?php echo base_url(); ?>css/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script>
    $('.colorpicker-default').colorpicker({
        format: 'hex'
    });
    $('.colorpicker-rgba').colorpicker();
    function save_color(e) {

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
            function (isConfirm) {
                var color_value = $('#color_value').val();
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url().$this->session->userdata('userType'); ?>/semantics/add_Color',
                        data: 'color_value=' + color_value,
                        beforeSend: function () {

                        },
                        success: function (result) {
                            $('#color').append(result);
                            $('#myModal').modal('hide');
                            swal("success fully Added the color", "", "success");

                        }
                    });
                }
                else {
                    swal("Cancelled", "", "error");
                }
            });
        return false;
    }
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap-datepicker/css/datepicker.css" />
 <script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
//date picker start

    if (top.location != location) {
        top.location.href = document.location.href ;
    }
    $(function(){
        window.prettyPrint && prettyPrint();
        $('.default-date-picker').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('.dpYears').datepicker();
        $('.dpMonths').datepicker();


        var startDate = new Date(2012,1,20);
        var endDate = new Date(2012,1,25);
        $('.dp4').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() > endDate.valueOf()){
                    $('.alert').show().find('strong').text('The start date can not be greater then the end date');
                } else {
                    $('.alert').hide();
                    startDate = new Date(ev.date);
                    $('#startDate').text($('.dp4').data('date'));
                }
                $('.dp4').datepicker('hide');
            });
        $('.dp5').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() < startDate.valueOf()){
                    $('.alert').show().find('strong').text('The end date can not be less then the start date');
                } else {
                    $('.alert').hide();
                    endDate = new Date(ev.date);
                    $('.endDate').text($('.dp5').data('date'));
                }
                $('.dp5').datepicker('hide');
            });

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('.dpd1').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
        var checkout = $('.dpd2').datepicker({
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
    });

//date picker end



//datetime picker end
</script>
<style>
small {
  border: 1px solid #DDDDDD;
  display: inline-block;
  height: 14px;
  margin: 0 3px 0 1px;
 width: 100%;
}
</style>