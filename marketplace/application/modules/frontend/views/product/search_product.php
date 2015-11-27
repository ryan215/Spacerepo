<?php
$categoryArr = array();
$productArr  = array();
$brandArr    = array();

if(!empty($result))
{
	foreach($result as $row)
	{
		$strDel = stripos($row->categoryCode,$search);
		$this->custom_log->write_log('custom_log','category search res '.$strDel);
			
		if($strDel===false)
		{
		}
		else					
		{
			$categoryArr[$row->categoryCode]['categoryId'] 	 = $row->categoryId;
			$categoryArr[$row->categoryCode]['categoryName'] = $row->categoryCode;
		}
		
		$strDel = stripos($row->code,$search);
		$this->custom_log->write_log('custom_log','product search res '.$strDel);
				
		if($strDel===false)
		{
		}
		else					
		{
			$productArr[$row->productId]['productName']  = $row->code;
			$productArr[$row->productId]['productImage'] = $row->imageName;
		}
		
		$strDel = stripos($row->brandName,$search);
		$this->custom_log->write_log('custom_log','product search res '.$strDel);
				
		if($strDel===false)
		{
		}
		else					
		{
			$brandArr[$row->brandId]['brandName']  = $row->brandName;
		}
	}
	
	if(!empty($categoryArr))
	{
	?>
		
	<?php
		foreach($categoryArr as $catId => $catVal)
		{
		?>
			<li style="padding-top:2px;padding-bottom:2px;">
				<a href="<?php echo frontend_grid_category_url($catVal['categoryId'],$catVal['categoryName']); ?>" class="search_text"></a>
				<div class="col-sm-12 search-main">
					<a href="<?php echo frontend_grid_category_url($catVal['categoryId'],$catVal['categoryName']); ?>" class="search_text">
						<div class="col-sm-12 padding_left_zero"  style="padding-left:0px; padding-top:2px;padding-bottom:2px; text-transform:capitalize;font-size: 11px;">
							<?php echo str_ireplace($search,'<strong>'.$search.'</strong>',$catVal['categoryName']); ?>
						</div>
						<div class="clearfix"></div>
					</a>
				</div>
			</li>
		<?php 
		}
		
		
	}
		
	if(!empty($brandArr))
	{
	
		?>
		<li>
			<div class="col-sm-12 search-main">
				<div class="col-sm-12 padding_left_zero" style="padding-left:0px;">
					<div class="cat_show">
						<span style="color:#666;"><strong>Popular Brand</strong></span>
					</div>
					<strong></strong>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</li>
		<?php
		
		foreach($brandArr as $brandId => $brandVal)
		{
		?>
			<li style="padding-top:2px;padding-bottom:2px;">
				<a href="<?php echo frontend_grid_brand_url($brandId,$brandVal['brandName']); ?>" class="search_text"></a>
				<div class="col-sm-12 search-main">
					<a href="<?php echo frontend_grid_brand_url($brandId,$brandVal['brandName']); ?>" class="search_text">
						<div class="col-sm-12 padding_left_zero"  style="padding-left:0px; padding-top:2px;padding-bottom:2px; text-transform:capitalize;font-size: 11px;">
							<?php echo str_ireplace($search,'<strong>'.$search.'</strong>',$brandVal['brandName']); ?>
						</div>
						<div class="clearfix"></div>
					</a>
				</div>
			</li>
		<?php 
		}
		
		
	}
	
	if(!empty($productArr))
	{
	?>
		<li>
			<div class="col-sm-12 search-main">
				<div class="col-sm-12 padding_left_zero" style="padding-left:0px;">
					<div class="cat_show">
						<span style="color:#666;"><strong>Popular Product</strong></span>
					</div>
					<strong></strong>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</li>
	<?php
		foreach($productArr as $productId => $productVal)
		{
		?>
			
			<li class="sp_grid"> 
				<a href="<?php echo product_url($productId,$productVal['productName']); ?>" class="search_text"></a>
				<div class="col-sm-12 search-main">
					<a href="<?php echo product_url($productId,$productVal['productName']); ?>" class="search_text">
						<div class="col-sm-12 padding_left_zero padding_right_zero auto-search-img" style="margin:0 auto;">
							<?php
							if((!empty($productVal['productImage']))&&(file_exists('uploads/product/thumb500_500/'.$productVal['productImage'])))
							{
							?>
								<img src="<?php echo base_url().'uploads/product/thumb500_500/'.$productVal['productImage']; ?>" width="90" style="margin: 5px; max-height:90px;">
							<?php
							}
							elseif((!empty($productVal['productImage']))&&(file_exists('uploads/product/'.$productVal['productImage'])))
							{
							?>
								<img src="<?php echo base_url().'uploads/product/'.$productVal['productImage']; ?>" width="90" style=" margin: 5px;">
							<?php
							}
							else
							{
							?>
								<img src="<?php echo base_url().'img/no_image.jpg'; ?>" width="90" style="margin: 5px;">
							<?php
							}
							?>
						</div>
						<div class="col-sm-12 padding_left_zero">
							<div style="text-transform: capitalize; font-size:10px; ">
								<?php
								if(strlen($productVal['productName'])<=70)
								{
									echo str_ireplace($search,'<strong>'.$search.'</strong>',$productVal['productName']); 
								}
								else
								{
									echo substr(str_ireplace($search,'<strong>'.$search.'</strong>',$productVal['productName']),0,70).'...'; 
								}
								?>
							</div>
							<strong></strong>
							<div class="clearfix"></div>
							<span class="search_price"></span>
						</div>
						<div class="clearfix"></div>
					</a>
				</div>
			</li>
		<?php
			}
	}
}
else
{
?>
	<li>
		<a href="javascript:void(0);" class="search_text"></a>
		<div class="col-sm-12 search-main">
			<a href="javascript:void(0);" class="search_text">
				<div class="col-sm-2 padding_left_zero padding_right_zero auto-search-img"></div>
				<div class="col-sm-10 padding_left_zero"><div>
					Data Not Found
				</div>
				<div class="clearfix"></div>
			</a>
		</div>
	</li>
<?php
}
?>
<style>
.sp_grid{ border: 1px solid #fff;
    background: #fff;
    width: 22%;
    float: left;
    height: 170px;
    margin: 10px;
    text-align: center;}
.sp_grid:hover{     box-shadow: 0px 1px 6px 2px rgba(0,0,0,0.1); color:#000;}
#autoSearchRes li:hover .search-main{background:#fff !important; color:#000; }
.cat_show{ text-transform: capitalize;border-top: 1px solid #ccc;margin-top: 12px;overflow: visible;height: 5px; }
.cat_show span{ top: -11px;left: 15px; display: inline-block;  position: relative; background: #fff; padding: 0 5px; } 
</style>