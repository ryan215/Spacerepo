<script src="<?php echo base_url(); ?>js/frontend/jquery.nicescroll.min.js" type="text/javascript"></script>

<section class="main-container col2-left-layout">
	<div class="container main-contant-wrapper shadow-main-div">
  		<div class="row">
			<div class="yt-breadcrumbs">
        		<div class="container">
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="category4" itemscope="" itemtype=""><strong><?php echo $organizationName;?> Products</strong></li></ul>
					</div>
        			</div>
        		</div>
        	</div>
				
			<div class="col-main col-sm-9 col-sm-push-3">
				<article class="col-main col-sm-12 product-listmain-container">
					
					<div class="toolbar col-sm-12" style="padding-top:0px;">
						<div class="sorter">
							<div class="view-mode">
								<a href="<?php echo base_url();?>frontend/seller/seller_product/<?php echo $sellerId;?>" title="Grid" class="button-list active" style="background-color:#fe5621; color:white;" id="grid">
									Grid
								</a> &nbsp;&nbsp;
								<a href="<?php echo base_url();?>frontend/seller/seller_product_list/<?php echo $sellerId;?>" title="List" class="button-list">
									List
								</a> 
							</div>
						</div>
						
						<div class="col-sm-3 pull-right" style="padding-right:0px;padding-top: 5px;">
						<span style="  top: 5px;  position: relative;">Sort By </span>
						<select onchange="searchfun();" id="pSorting" class="pull-right form-control" style="width:130px;">
							<option value="3">Popularity</option>
							<option value="1">Low Price</option>
							<option value="2">High Price</option>							
						</select>
						</div>
					 </div>  
                     
					 <div  class="col-sm-12 pd" style="padding:0;"> 
						<div class="category-products col-sm-12" style="padding-right:0px;">
							
                            	
									<ul  id="results" class="pdt-list products-grid zoomOut play">
									
																		<?php
if(!empty($list))
{
	foreach($list as $row)
	{
		
		$imageNm = $row['imageName'];
?>
<li class="item item-animate last">
	<div class="item-inner" style="padding-bottom:40px;">  
    	<div class="product-wrapper">
        	<div class="thumb-wrapper">
            	<a href="<?php echo product_url($row['productId'],$row['productName']); ?>" class="thumb">
					<span class="face">
						<?php
						if((!empty($imageNm))&&(file_exists('uploads/product/thumb500_500/'.$imageNm)))
						{
						?>
							<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$imageNm; ?>" alt="" width="250">
						<?php
						}
						elseif((!empty($imageNm))&&(file_exists('uploads/product/'.$imageNm)))
						{
						?>
							<img src="<?php echo base_url().'uploads/product/'.$imageNm; ?>" alt="" width="250">
						<?php
						}
						else
						{
						?>
							<img src="<?php echo base_url(); ?>img/no_image.jpg" alt=""  width="250">
						<?php
						}
						?>	
								</span>
							
							</a>
						</div>
                   <!-- <div class="actions">
						<span class="add-to-links">
							<a href="#" class="link-wishlist" title="Add to Wishlist"><span>Add to Wishlist</span></a>
							<a href="#" class="link-compare" title="Add to Compare"><span>Add to Compare</span></a>
						</span> 
					</div>-->
                </div> 
                <div class="item-info">
                	<div class="info-inner">
                    	<div class="item-title">
							<a href="<?php echo product_url($row['productId'],$row['productName']); ?>">
								<?php echo $row['productName']; ?>
							</a> 
						</div>
						
						<div class="item-content">
							<div class="col-sm-12 col-xs-12 padding_left_zero" >
								<div class="rating_icon">
									<?php
									for($i=1;$i<=5;$i++)
									{
										if($i<=$row['avgRating'])
										{
											echo '<span class="fa fa-star active"></span>';
										}
										else
										{
											echo '<span class="fa fa-star inactive"></span>';
										}
									}
									?>									
								</div>
				  			</div>
							<div class="clearfix"></div>
                        	<div class="item-price">
                          		<div class="price-box">
									<span class="regular-price">
                                    <?php
							if($row['adminPrice'])
							{
							?>
								<span class="price" style="font-size:12px !important; color:red; "><strike>&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></strike></span> 
                              <?php
							}
							else
							{
							?>
                            <span class="price">&#x20A6;<?php echo number_format($row['currentPrice'],2); ?></span> 
                            <?php
							}
							?>
							</span>
								</div>
                        	</div>
                            <?php
							if($row['adminPrice'])
							{
							?>
                            <div class="item-price vip-price">
                          		<div class="price-box">
									<span class="regular-price">
                                       <span class="sale-price" style="  color: #A3CE62;  font-size: 14px;"><strong>VIP Sale &#x20A6;<?php echo number_format($row['adminPrice'],2); ?></strong></span> 
									</span> 
								</div>
                        	</div>
                            <?php
							}
							
							if(((!empty($row['cashAdminFee']))&&($row['cashAdminFee']))||((!empty($row['freeShipPrdId']))&&($row['freeShipPrdId']))||((!empty($row['freeShipCatId']))&&($row['freeShipCatId'])))
							{
							?>
								<span class="free-shipping-label">+ FREE DELIVERY</span>
							<?php
							}
							?>
                      	</div>
					</div>
				</div>
			</div>
        </li>
		<?php
			}
		}
		else
		{
			if($page_number==0)
			{
		?>
		<li class="item item-animate last">
        	<div class="item-inner">
            	No Product Available
			</div>
        </li>
		<?php
			}
		}
		?>
		
									</ul>
									<div align="center" style="width:97.2%;">
										<div id="thank" class="col-sm-12" style="display:none;padding-left:0px;">
										</div>
										<div class="clearfix"></div>
										<div id="loadMore" class="load_more col-sm-12" style="display: inline-block !important; cursor:pointer; padding-left:0px;">
										</div>
										<div class="animation_image" style="display:none;">
											<?php echo $this->loader; ?>
											
										</div>
									</div>								
								
                            
						</div>
					</div>
				</article>
			</div>
			<div class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">
				<aside class="col-left sidebar">
					<div class="side-nav-categories">
						<div id="" class="super-category-block first-load sn-category-block">
                                        <div class="block-title-defaults ">
                                            <div class="tab-category-title block-title">
                                                <strong><span style="font-size:14px !Important">Categories </span></strong>
                                                
                                             </div>
                                        </div>
                           </div>
					<?php 
$attributes = array('id' => 'srchFrm');
echo form_open('',$attributes);
?>

						<div class="box-content box-category" style="padding:15px;" >
							 <div class="ctg-checkbox-div boxscrollbar" id="scrollboxes">
								<?php
								if(!empty($catArr))
								{
									foreach($catArr as $key=>$value)
									{
								?>
								<div class="block-element">
								<label class="ctg-label-left">
									<input type="checkbox" name="catArr[]" value="<?php echo $value['categoryId']; ?>" onchange="cat_searchfun();" class="chkbx">
									<span class="lbl padding-8">
										<?php echo $value['categoryCode'].'('.$value['totalProducts'].')'; ?>
									</span>
							  </label>
							</div>
									<?php
									}
								}
								?>
							</div>
						</div>
					
					
					<div class="block block-layered-nav" style="margin:0px;">
						<div id="" class="super-category-block first-load sn-category-block">
                                        <div class="block-title-defaults ">
                                            <div class="tab-category-title block-title">
                                                <strong><span style="font-size:14px !Important">Price</span></strong>
                                                
                                             </div>
                                        </div>
                           </div>
						<div class="block-content" style="padding-top:0px; padding-bottom:0px;">
						
								<div class="panel-body priceFilterBody"> 
									<div class="col-sm-12 price-input-div">
                                    	<div class="ctg-checkbox-div">
										<div class="form-group">
                                        	<label class="price-rangelabel">From</label>
											<input type="text" class="form-control" id="exampleInputEmail2" placeholder="&#x20A6;<?php echo $minPrice; ?>" name="from_price" id="from_price" onKeyUp="searchfun();">
										</div>
										<div class="form-group">
                                        	<label class="price-rangelabel">To</label>
											<input type="text" class="form-control" id="exampleInputPassword2" placeholder="&#x20A6;<?php echo $maxPrice; ?>" name="to_price" id="to_price" onKeyUp="searchfun();">
										</div>
                                        </div>
									</div>
								</div>
							  
						</div>
					  </div> 
			
						<div class="block block-layered-nav" style="margin:0px;">
						<div id="" class="super-category-block first-load sn-category-block">
                                        <div class="block-title-defaults ">
                                            <div class="tab-category-title block-title">
                                                <strong><span style="font-size:14px !Important">Brand</span></strong>
                                                
                                             </div>
                                        </div>
                           </div>
						<div class="block-content" style="padding-top:10px;">
							
						<div class="panel-body smoothscroll maxheight300 brand-filterdiv-left">
						   <div class="brand-searchinput-div">
								<input type="text" class="form-control brand-srch-input" placeholder="Search" onKeyUp="brandSearchFun(this.value);">
						   </div>
                           <div class="ctg-checkbox-div boxscrollbar" id="scrollboxes1">
							<?php
							if(!empty($brandList))
							{
								foreach($brandList as $brandId=>$brandName)
								{
							?>
							<div class="block-element">
								<label class="ctg-label-left">
									<input type="checkbox" name="brandArr[]" value="<?php echo $brandId; ?>" onclick="searchfun();">
									<span class="lbl padding-8"><?php echo $brandName; ?></span>
							  </label>
							</div>	
							<?php
								}
							}
							?>
                            </div>
						</div>
						</div>
					  </div>
					</form>
					</aside>
				  </div>
    	</div>
	</div>
</section>
<script>
var track_click = 0; //track user click on "load more" button, righ now it is 0 click
var total_pages = '<?php echo ceil($total/48); ?>';

$(document).ready(function() {
	pSorting = $('#pSorting').val();
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/seller/ajaxFunGrid'; ?>',
		data:'page='+track_click+'&sellerId=<?php echo $sellerId; ?>&pSorting='+pSorting+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		dataType: 'json',
			beforeSend: function() {
			$('#results').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			console.log(result);
			$('#results').html(result.view);
			if(total_pages>1)			
			{
				$("#loadMore").css('display','block');
				$("#loadMore").html('<div class="text-center view_more_load">View More<p style="margin-bottom:0px;"><i class="fa fa-chevron-down"/></p></div>'); 
				 track_click++;
			}
			else
			{
				$("#loadMore").css('display','none');
			}
		}
	});
	
	$(".load_more").click(function (e) { //user clicks on button
    	$(this).hide(); //hide load more button on click
        $('.animation_image').show(); //show loading image
		
		//alert(track_click+' < '+total_pages);
		if(track_click < total_pages) //user click number is still less than total pages
        {	//alert(track_click+' < '+total_pages);
			pSorting = $('#pSorting').val();
			var posdata = $("form#srchFrm").serialize()+'&page='+track_click+'&sellerId=<?php echo $sellerId; ?>&pSorting='+pSorting;
			$.ajax({
				type: "POST",
				url:'<?php echo base_url().'frontend/seller/ajaxFunGrid'; ?>',
				data:posdata+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
				dataType: 'json',
				beforeSend: function() {
			$('.load_more').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
					$(".load_more").show();
					$("#results").append(result.view);	
					$('.animation_image').hide();			
					$("#loadMore").html('<div class="text-center view_more_load">View More<p style="margin-bottom:0px;"><i class="fa fa-chevron-down"/></p></div>'); 
					 track_click++;
					
					if(track_click >= total_pages) //compare user click with page number
					{
						$("#loadMore").html('');
						$("#loadMore").css('display','none');
						//$('.animation_image').hide();
						$("#thank").css('display','inline-block');
						$("#thank").html("<div class='text-center view_more_load thats-all'>THAT'S ALL FOLKS!</div>");
					}
				}
			});
            
            //alert(track_click+' >= '+total_pages);
            if(track_click >= total_pages) //compare user click with page number
            {
				$("#loadMore").html('');
				$("#loadMore").css('display','none');
				$('.animation_image').hide();
				$("#thank").css('display','inline-block');
				$("#thank").html("<div class='text-center view_more_load thats-all'>THAT'S ALL FOLKS!</div>");
            }
         }
	});
});

function cat_searchfun()
{	
	pSorting = $('#pSorting').val();
	$("#thank").css('display','none');
	track_click = 0;
	posdata = jQuery("form#srchFrm").serialize()+'&sellerId=<?php echo $sellerId;?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&page='+track_click+'&seller=<?php echo $sellerId; ?>&pSorting='+pSorting;
	jQuery.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/seller/ajaxFunGrid'; ?>',
		data:posdata,
		dataType:'json',
			beforeSend: function() {
			$('#results').html('<?php echo $this->loader; ?>');
		},
		success:function(result){	//alert(result);
		//console.log(result);
			total_pages = result.totalPage;
			$('#results').html(result.view);	
			if(total_pages>1)			
			{
				$("#loadMore").css('display','block');
				$("#loadMore").html('<div class="text-center view_more_load">View More<p style="margin-bottom:0px;"><i class="fa fa-chevron-down"/></p></div>'); 
				 track_click++;
			}
			else
			{
				$("#loadMore").css('display','none');
			}
		}
	});
}

function searchfun()
{
	pSorting = $('#pSorting').val();
	//alert(pSorting);
	$("#thank").css('display','none');
	track_click = 0;
	posdata = $("form#srchFrm").serialize()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&page='+track_click+'&sellerId=<?php echo $sellerId; ?>&pSorting='+pSorting;
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/seller/ajaxFunGrid'; ?>',
		data:posdata,
		dataType:'json',
			beforeSend: function() {
			$('#results').html('<?php echo $this->loader; ?>');
		},
		success:function(result){
			total_pages = parseInt(result.totalPage);
			$('#results').html(result.view);	
			if(total_pages>1)			
			{
				$("#loadMore").css('display','block');
				$("#loadMore").html('<div class="text-center view_more_load">View More<p style="margin-bottom:0px;"><i class="fa fa-chevron-down"/></p></div>'); 
				 track_click++;
			}
			else
			{
				$("#loadMore").css('display','none');
			}
		}
	});
}


function brandSearchFun(brndNm)
{
	if(brndNm=='')
	{
		searchfun();
	}
	
	posdata = 'brandName='+brndNm+'&brandList=<?php echo json_encode($brandList); ?>';
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/product/search_brand_list'; ?>',
		data:posdata+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#scrollboxes1').html('<?php echo $this->loader; ?>');
		},
		success:function(result){	//console.log(result);
			$('#scrollboxes1').html(result);				
		}
	});
}

 jQuery(document).ready(function () {
    jQuery("#scrollboxes").niceScroll({ autohidemode: true })
    });
	
	 jQuery(document).ready(function () {
    jQuery("#scrollboxes1").niceScroll({ autohidemode: true })
    });
</script>
</script>
<style>
.free-shipping-label {
  border: 1px dashed #999;
  border-radius: 3px;
  font-size: 10px;
  padding: 1px 7px;
  color: #F38C46;
  font-weight: 600;
  display: inline-block;
  position: relative;
  top: 2px;
  height: 19px;
  box-sizing: border-box;
  font-family: latomedium!important;
}

.view_more_load{  
	background-color: #f5f5f5;
  padding: 8px;
  color: #777;
  line-height: 14px;
  font-size: 12px;
  text-transform: uppercase; }
</style>
<style>
.header-v0 .ver-megamenu-header .sm_megamenu_wrapper_vertical_menu{ display:none !important;}
.sorting_price{
  color: #999;
  border: 1px #f3f3f3 solid !important;
  border-right: 2px #f3f3f3 solid !important;
  text-decoration: none;
  border-radius:0px !important;
  height:30px;
}

.boxscrollbar > div{ 
-webkit-transition: width 0.2s ease; 
-moz-transition: width 0.2s ease; 
-o-transition: width 0.2s ease; 
-ms-transition: width 0.2s ease;    
transition: width 0.2s ease; 
}
.boxscrollbar > div:hover{
cursor:pointer;
}

.boxscrollbar { 
 min-height: 30px;
    margin-top: 10px;
    max-height: 170px;}
.loading_gif{ position:absolute; top:200px;}
input[type=checkbox]{ display:none;}
section {
    padding-top: 3px;
}
.yt-breadcrumbs {
  margin-top: 0px;
}
.category-products ul.products-grid li.item.last  {   border: 1px solid #ddd;
    padding-bottom: 0px !important;}
.category-products ul.products-grid li.item{     width: 185px;}
.sorter .view-mode {
    margin-top: 11px;
    margin-right: 20px;
}
.block-layered-nav{ border-top:0px !important;}
.rating_icon{  margin-top: 2px; }
.rating_icon .active{ color:#e9ce18; }
.rating_icon .inactive{ color:#d3d3d3; }

.thats-all{background:none !important;
  	margin-top:8px;
  }
.sn-category-block{ margin-bottom:0px !important;}  
.sn-category-block .block-title{ height:47px !important;border-left: 4px solid #fe5621;}
.sn-category-block .block-title strong{ padding-left:0px !important;}
  
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/level-1.css">

<style>
.price_list_view{
  color: #fe5621;
  font-family: museo700;
  margin: 0;

  font-weight: normal;
  line-height: 20px;
  letter-spacing: 1px;
}
.price{ font-size:20px !important;}
.sale-price{ 
	font-weight: 900;
  font-size: 12px;
  color:red;
}

.price-box {
  margin: 0px !important;
}
.products-grid .item .item-inner .item-info .info-inner .item-content .item-price {
  margin: 0px !important;
}
.vip-price{height:18px;
}
.info-inner .item-content{height:50px;  
}
.mr_bottom{ margin-bottom:10px !important;}
</style>
