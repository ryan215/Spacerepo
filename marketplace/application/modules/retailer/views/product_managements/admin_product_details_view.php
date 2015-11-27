<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/admin/custom_admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/admin/owl.carousel.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/frontend/modernizr.custom.63321.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>js/frontend/lightbox/glasscase.minf195.css?v=2.1" rel="stylesheet" />

<style>
label {
	background-image: none;
}
.chosen-container-single .chosen-single {
	background: none !important;
	border: 1px solid #CCC !important;
	border-radius: 4px !important;
}
.r-activity {
	margin-top: 0;
	font-size: 10px;
}
 small {
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
.r-activity1 {
	display: inline-block;
	margin: 5px 0;
}
#ftrAjaxID {
	text-align: right !important;
}
#ftrAjaxID input {
	width: 94%;
}
.feature-pre {
	font-size: 16px;
}
.form-border {
	border-bottom: 1px solid #e5e5e5;
	padding: 0;
}
.form-border label {
	padding: 0;
}
.acdc-btn {
	width: 100px;
	font-size: 17px;
}
.header-title-main {
	font-size: 17px !important;
}
.colors-labels .block-element {
	float: left;
	margin-right: 30px;
}
.carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right, .carousel-control .icon-prev, .carousel-control .icon-next {
	font-size: 20px;
	color: #2a3542;
}
.carousel-control.left, .carousel-control.right {
	font-size: 20px;
	color: #2a3542;
}
.carousel-inner .item .thumb {
	width: 85px;
	height: 85px;
}
.carousel-inner .item .thumb img {
	width: 100%;
	height: 100%;
}

.owl-carousel .owl-item {border:1px solid #d6d6d6 !important;
}

.owl-prev{text-transform:uppercase;
	font-size:33px;
	left:-20px;
}

.owl-next{text-transform:uppercase;
	font-size:33px;
	right:-20px;
}

.owl-controls{ position: absolute;
    top: 17%;
    width: 100%;
}

.product-view-mainimage{
	color:#fff;
	padding:2px 10px;
	text-align:center;
	font-size:14px;
	position:absolute;
	top: -20px;
	left:-27px;
	z-index:999;
	transform:rotate(-6deg);
}

.product-view-mainimage img{width:160px;
}

.product-view-main-image{align-content: center;
    align-items: center;
    display: flex !important;
	-webkit-display: flex !important;
	-moz-display: flex !important;
    flex: 1 1 0;
    text-align: center;
	max-width:100%;
}

.carousel-inner{align-content: stretch;
    align-items: stretch;
	display: flex !important;
    height: 400px;
    margin: 0;
    position: relative;
    width: 100%;
	border:1px solid #ebebeb;
	margin-bottom:8px;
	-ms-flex-item-align:stretch;
	-webkit-align-self:stretch;
	align-self:stretch; 
}

.main-image-wrapper .carousel-inner img{display:inline-block;
	max-height:80% !important;
	margin:0 auto;
	width:auto !important;
	max-width:80% !important;
}

</style>

<div class="row">
	<div class="col-md-4" style="padding:0;">
    	<div class="col-lg-12 col-md-12">
      		<section class="panel" style="">
        		<header class="panel-heading head_text"> <i class="fa fa-instagram"></i>&nbsp;&nbsp; Product Image </header>
        		<div class="panel-body" style="line-height:21px; padding-bottom:40px;">
          			<div class="col-sm-12">
            			<div id="carousel" class="carousel slide" data-ride="carousel">
				            <div class="carousel-inner">
								<?php  
								if(!empty($result['product_images']))
								{
									foreach($result['product_images'] as $value)
									{
										if((!empty($value['imageName']))&&(file_exists('uploads/product/'.$value['imageName'])))
										{
											$imageUrl = base_url().'uploads/product/'.$value['imageName'];
										}
										else
										{
											$imageUrl = base_url().'img/no_image.jpg';
										}
										?>
								<div class="item <?php if($value['displayOrder']==1){ echo 'active'; } ?>" data-thumb="0">
				                    <img src="<?php echo $imageUrl; ?>">
				                </div>	
									<?php
									}
								}
								?>				                
               				</div>
						</div> 
    					<div class="clearfix">
				        	<div id="thumbcarousel" class="carousel slide" data-interval="false">
					            <div class="carousel-inner">
									<?php  
									if(!empty($result['product_images']))
									{
										$i = 0;
										foreach($result['product_images'] as $value)
										{
											if((!empty($value['imageName']))&&(file_exists('uploads/product/'.$value['imageName'])))
											{
												$imageUrl = base_url().'uploads/product/'.$value['imageName'];
											}
											else
											{
												$imageUrl = base_url().'img/no_image.jpg';
											}
										?>
									<div class="item active">
										<div data-target="#carousel" data-slide-to="<?php echo $i; ?>" class="thumb">
											<img src="<?php echo $imageUrl; ?>">
										</div>
					                </div>
									<?php
											$i++;
										}
									}
									?>
								</div><!-- /carousel-inner -->
							<a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left"></span>
				            </a>
				            <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
				                <span class="glyphicon glyphicon-chevron-right"></span>
				            </a>
				        </div> <!-- /thumbcarousel -->
				    </div><!-- /clearfix -->
		 
          </div>
        </div>
      </section>
    </div>
  </div>
  
<div class="col-md-8" style="padding:0;">
	<div class="col-lg-12">
		<?php
		$uriSeg3 = $this->uri->segment(3);
		if(($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin')||($this->session->userdata('userType')=='cse'))
		{
			if((!empty($uriSeg3))&&($uriSeg3=='productReview'))
			{
				if((!empty($result['productTypeId']))&&($result['productTypeId']==3))
				{
					$formAttribute = array('id' => 'pseudo_form');
					echo form_open('',$formAttribute);
				?>
				<section class="panel">
					<header class="panel-heading head_text">
						<i class="fa fa-file-text-o"></i>&nbsp;&nbsp;
						Pseudo Product Price
					</header>
					<div class="panel-body">
						<div class="form-group">
							<table cellpadding="5" cellspacing="5" width="100%">
								<tr>
									<td width="25%"><h4 class="head_text1">Price</h4></td>
									<td>
										<input type="text" name="product_price" value="<?php echo $result['productPrice']; ?>" />
										<?php echo form_error('product_price'); ?>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</section>
					</form>
				<?php
				}
			}
		}
		?>
      <section class="panel">
      <header class="panel-heading head_text"> <i class="fa fa-file-text-o"></i> &nbsp;&nbsp; Unique Product Identifiers </header>
      <div class="panel-body">
        <div class="form-group">
          <table cellpadding="5" cellspacing="5" width="100%">
            <tr>
              <td width="25%"><h4 class="head_text1">Product Name</h4></td>
              <td>&nbsp;:&nbsp; <?php echo $result['product_name']; ?></td>
            </tr>
          </table>
        </div>
        <div class="form-group">
          <table cellpadding="5" cellspacing="5" width="100%">
            <tr>
              <td width="25%"><h4 class="head_text1">Brand Name</h4></td>
              <td>&nbsp;:&nbsp; <?php echo $result['brandName']; ?></td>
			  <?php
			  if(!$result['brandStatus'])
			  {
			  ?>
			   <td>&nbsp;:&nbsp; Blocked</td>
			  <?php
			  }
			  ?>
            </tr>
          </table>
        </div>
        <div class="form-group">
          <table cellpadding="5" cellspacing="5" width="100%">
            <tr>
              <td width="25%"><h4 class="head_text1">SPID</h4></td>
              <td>&nbsp;:&nbsp; <?php echo $result['spid'];?></td>
            </tr>
          </table>
        </div>
    </div>
    
    </section>
    
    <div class="col-sm-12 pd">
  <section class="panel">
    <header class="panel-heading head_text"> <i class="fa fa-file-text-o"></i> &nbsp;&nbsp; Product Details </header>
    <div class="panel-body">
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%">
          <tr>
            <td width="50%"><h4 class="head_text1">Item Weight (in Kg)</h4></td>
            <td>&nbsp;:&nbsp;<?php echo $result['item_weight']; ?></td>
          </tr>
        </table>
      </div>
      <?php
							//if($uriSeg!='retailer')
							{
							?>
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%">
          <tr>
            <td width="50%"><h4 class="head_text1">Packaging Material Weight (in Kg)</h4></td>
            <td>&nbsp;:&nbsp;<?php echo $result['packing_weight']; ?></td>
          </tr>
        </table>
      </div>
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%">
          <tr>
            <td width="50%"><h4 class="head_text1">Total Weight For Shipping (in Kg)</h4></td>
            <td>&nbsp;:&nbsp;<?php echo $result['total_weight']; ?></td>
          </tr>
        </table>
      </div>
      <?php
							}
							?>
    </div>
  </section>
</div>
<?php 
$checkSize = array();
if(isset($result['sizes']) && !empty($result['sizes']))
{
?>
<div class="col-sm-12 pd">
  <section class="panel">
    <header class="panel-heading head_text"> <i class="fa fa-file-text-o"></i> &nbsp;&nbsp;Size  Details </header>
    <div class="panel-body">     
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%" class="">
          <tr>
            <td width="20%"><strong>Sizes</strong></td>
            <td width="80%">
				<?php 
				foreach($result['sizes'] as $product_sizes)
				{
					if((!empty($checkSize))&&(in_array($product_sizes->sizes,$checkSize)))
					{
					}
					else
					{
						$checkSize[$product_sizes->sizes] = $product_sizes->sizes;
						echo $product_sizes->sizes.',';
					}
				}
				?>
			</td>
          </tr>
		  
        </table>
      </div>      
    </div>
  </section>
</div>
<?php }?>
<?php 
$checkColor = array();
if(isset($result['productcolorlist']) && !empty($result['productcolorlist']))
{
?>
<div class="col-sm-12 pd">
  <section class="panel">
    <header class="panel-heading head_text"> <i class="fa fa-file-text-o"></i> &nbsp;&nbsp;Product colors </header>
    <div class="panel-body">     
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%" class="">
          <tr>
            <td width="20%"><strong>Colors</strong></td>
            <td width="80%">
			<?php 
			foreach($result['productcolorlist'] as $product_color)
			{
				if((!empty($checkColor))&&(in_array($product_color->colorCode,$checkColor)))
				{
				}
				else
				{
					$checkColor[$product_color->colorCode] = $product_color->colorCode;
					echo ' <small style="background-color:'.$product_color->colorCode.'"></small>';
				}
			}
			?></td>
          </tr>
		  
        </table>
      </div>      
    </div>
  </section>
</div>
<?php }?>
    
  </div>
</div>
<div class="col-sm-12">
  <section class="panel" style="">
    <header class="panel-heading head_text"> <i class="fa fa-align-justify"></i> &nbsp;&nbsp;Category </header>
    <div class="panel-body" style="line-height:30px;">
      <div class="form-group">
        <table cellpadding="5" cellspacing="5" width="100%">
          <tr>
            <td width="15%"><h4 class="head_text1">Level-1</h4></td>
            <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['segment_name']; ?></div></td>
          </tr>
        </table>
      </div>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-2</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['category_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   if(!empty($result['sub_category1_name']))
						   {
						   ?>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-3</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['sub_category1_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   }
						   if(!empty($result['sub_category2_name']))        
						   {
						   ?>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-4</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['sub_category2_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   }
						   if(!empty($result['sub_category3_name']))
						   {
						   ?>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-5</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['sub_category3_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   }
						   if(!empty($result['sub_category4_name']))
						   {
						   ?>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-6</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['sub_category4_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   }
						   if(!empty($result['sub_category5_name']))          
						   {
						   ?>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-7</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['sub_category5_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   }
						   if(!empty($result['sub_category6_name']))          
						   {
						   ?>
      <table cellpadding="5" cellspacing="5" width="100%">
        <tr>
          <td width="15%"><h4 class="head_text1">Level-8</h4></td>
          <td><div class="head_text2">&nbsp;:&nbsp; <?php echo $result['sub_category6_name']; ?></div></td>
        </tr>
      </table>
      <?php
						   }
						   ?>
    </div>
  </section>
</div>
<div class="col-sm-12">
  <section class="panel" style="">
    <header class="panel-heading head_text"> <i class="fa fa-tags"></i> &nbsp;&nbsp;Product Attribute </header>
    <div class="panel-body  header-title-main" style="line-height:30px;">
      <?php								
								
								?>
      <div class="form-group col-sm-12 form-border " style="padding-bottom:15px;">
        <div class="col-sm-12 head_text2 bg-success att_head"></div>
        <div style="font-size:15px;" class="col-sm-12 padding_left_zero">
          <table cellpadding="5" cellspacing="5">
            <?php
									if(!empty($result['attrDetails']))
									{
										foreach($result['attrDetails'] as $value1)
										{										
									?>
            <tr>
			
              <td width="15%"><?php echo '<div class="head_text3">';
			  if(!empty($value1->attributeName)){ echo $value1->attributeName; }
			  else{
				  echo $value1->productAttributeName;
			  }
			  echo '</div>'; ?></td>
              <td width="2%">&nbsp; : &nbsp;</td>
			  <td width="78%"><span class="head_text2"><?php echo $value1->attributeValue; ?></span></td>
            </tr>
            <?php
										}
									}
									?>
          </table>
        </div>
      </div>
      <?php
								
								?>
    </div>
  </section>
</div>

</div>
</div>
<style>
/* CSS used here will be applied after bootstrap.css */
#carousel {
    margin-top: 20px;
}
.item .thumb {
	width: 25%;
	cursor: pointer;
	float: left;
}
.item .thumb img, .item img {
	width: 100%;	
}

</style>

<script type="text/javascript">
(function($){
	$('#thumbcarousel').carousel(0);
	var $thumbItems = $('#thumbcarousel .item');
    $('#carousel').on('slide.bs.carousel', function (event) {
	   var $slide = $(event.relatedTarget);
	   var thumbIndex = $slide.data('thumb');
	   var curThumbIndex = $thumbItems.index($thumbItems.filter('.active').get(0));
		if (curThumbIndex>thumbIndex) {
			$('#thumbcarousel').one('slid.bs.carousel', function (event) {
				$('#thumbcarousel').carousel(thumbIndex);
			});
			if (curThumbIndex === ($thumbItems.length-1)) {
				$('#thumbcarousel').carousel('next');
			} else {
				$('#thumbcarousel').carousel(numThumbItems-1);
			}
		} else {
			$('#thumbcarousel').carousel(thumbIndex);
		}
	});
})(jQuery);

function pseudo_form_submit()
{
	$('#pseudo_form').submit();
}
</script>