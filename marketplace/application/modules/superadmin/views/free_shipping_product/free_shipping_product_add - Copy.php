<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}
.r-activity{margin-top:0;
	font-size:10px;
}

.r-activity1{
	display:inline-block;
	height: 32px;
	font-size: 14px;
	padding: 5px;
	margin-top:1px;
	float:right;
}

.ftrBoxID{
	margin: 12px 0 0 0px;
	display:flex;
}

.ftrBoxID input{width:100%;
}

.ftrAjaxID
{
	text-align:right !important;
	
}
.edit-btns{float:right;
	  float: right;
	  height: 32px;
	  padding: 5px;
	  font-size: 14px;
	  margin: 1px 2px;
}

.block-element label{float:left;
	margin-right:18px;
}

</style>
<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<section id="main-content">
	<section class="wrapper">
    	<div class="row">
        	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					<li>
						<a href="<?php echo base_url().'superadmin/free_shipping_product'; ?>">
							Free Shipping Product Management
						</a>
					</li>
                    <li><a href="javascript:void(0);" class="current">Add</a></li>
				</ul>
			</div>
        </div>
		<form method="post">
		<div class="row">
			<div class="col-md-12" style="padding:0;">
            	<div class="col-lg-12">
                	<section class="panel" style="">
						<?php $this->load->view('success_error_message'); ?> 
                    	<header class="panel-heading panel-heading1">Add Free Shipping Product</header>
						<div class="panel-body" style="line-height:21px;">							
                        	<div class="all-form-with">
								<div class="form-group">
                            		<div class="col-sm-5 col-lg-5 pd">
										<label for="countryName" style="float:left; line-height:33px;">
											Select Category Level1
										</label>
									</div>	
                                	<div class="col-sm-7 col-sm-7 padding_left_zero pd">
										<div id="level1">
										<?php
										if(!empty($result['catList']))
										{
										?>
											<select class="form-control" name="level1" onchange="cat_list(this.value,2);">
												<option value="">Select Category</option>
												<?php
												foreach($result['catList'] as $row)
												{
												?>
												<option value="<?php echo $row->categoryId; ?>" <?php echo set_select('level1',$row->categoryId); ?>>
													<?php echo $row->categoryCode; ?>
												</option>
												<?php													
												}
											?>
											</select>
										<?php										
										}
										else
										{
										?>
											<select class="form-control" name="level1">
												<option value="">Select Category</option>
												<option value="">No Data Found</option>	
											</select>
										<?php
										}
										echo form_error('level1'); 
										?>
										</div>
                                     </div>
									<div id="level2">
									
									</div>
								</div>
							</div>
							
                        </div>
<section id="unseen" class="col-sm-12">
	<?php echo form_error('productList[]'); ?>
	<table class="table table-invoice  table-hover table-custom table-search-head">
		<thead>
			<tr>
				<th width="3%">&nbsp;</th>
				<th width="5%">Image</th>
				<th width="30%">
					Product Name
					<!--<input type="text" class="form-control search table-head-search" id="productName" onkeyup="ajax_search();" placeholder="Product Name">-->
				</th>					
				<th width="20%">Category Name</th>
				<th width="20%">Brand Name</th>
			</tr>
		</thead>
		<tbody id="ajaxData">
		</tbody>
	</table>
</section>
<div class="clearfix"></div>
<div class="col-sm-12 form-div padding_right_zero">
	<div class="col-sm-12 text-right padding_right_zero">
		<a class="btn btn-danger btn-save" href="<?php echo base_url().'superadmin/free_shipping_product'; ?>">
			Cancel
		</a>
		<button class="btn btn-success btn-save">Save</button>
    </div>
</div>
</div>
</section>
</div>
</div>
</div>
</form>
</section>
</section>
<script type="text/javascript">
function cat_list(catId,nextLevel) 
{
	if(catId!='')
	{
		$.ajax({
    		type: "POST",
	        url: '<?php echo base_url().$this->session->userdata('userType'); ?>/free_shipping_product/level_category_list/'+catId+'/'+nextLevel,
			data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
			dataType:'json',		
	        beforeSend: function () {
	        	$('#level'+nextLevel).html('<?php echo $this->loader; ?>');
	        },
	        success: function(result) {
				//console.log(result);
	        	$('#level'+nextLevel).html(result.catList);
				$('#ajaxData').html(result.productList);
	        }
		});
	}
	else
	{
		$('#level'+nextLevel).html('');
		$('#ajaxData').html('');
		if(nextLevel>1)
		{
			backLvl = nextLevel-2;
			if(backLvl>0)
			{
				catBkId = $('#level'+backLvl).find('option:selected').val();
				if(catBkId)
				{
					nextBkLevel = backLvl+1;
					cat_list(catBkId,nextBkLevel);
				}
				//console.log($('#level'+backLvl).html());
				//alert($('#level'+backLvl).find('option:selected').val());
			}
		}
	}
}

function ajaxPage(urlLink)
{	
	$.ajax({
    	type: "POST",
        url: urlLink,
		data:'<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		dataType:'json',		
        beforeSend: function () {
        	$('#ajaxData').html('<?php echo $this->loader; ?>');
        },
        success: function(result) {
			$('#ajaxData').html(result.productList);
        }
	});
}

<?php
if($_POST)
{
	$i = 2;
	foreach($_POST as $key=>$value)
	{
		if($key!='productList')
		{
?>
cat_list('<?php echo $value; ?>','<?php echo $i; ?>');
<?php
			$i++;
		}
	}
}
?>
</script>