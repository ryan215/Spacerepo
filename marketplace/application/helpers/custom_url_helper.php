<?php
function frontend_grid_brand_url($brandId,$brandName)
{
	$brandName = str_replace(' ','-',$brandName); // Replaces all spaces with hyphens.
	$brandName = preg_replace('/[^A-Za-z0-9\-]/', '', $brandName); // Removes special chars.   
	$brandName = preg_replace('/-{2,}/','-',$brandName);
	$url = base_url().'brand/'.$brandName.'-grid-'.id_encrypt($brandId);
	return $url;
}

function frontend_list_brand_url($brandId,$brandName)
{
	$brandName = str_replace(' ','-',$brandName); // Replaces all spaces with hyphens.
	$brandName = preg_replace('/[^A-Za-z0-9\-]/', '', $brandName); // Removes special chars.   
	$brandName = preg_replace('/-{2,}/','-',$brandName);
	$url = base_url().'brand/'.$brandName.'-list-'.id_encrypt($brandId);
	return $url;
}

function product_url($productId,$productName,$colorId=0,$sizeId=0,$organizationColorSizeId=0)
{
	$productName = str_replace(' ','-',$productName); // Replaces all spaces with hyphens.
	$productName = preg_replace('/[^A-Za-z0-9\-]/','',$productName); // Removes special chars.   
	$productName = preg_replace('/-{2,}/','-',$productName);
	
	$url = base_url().'product/'.$productName.'-details-'.id_encrypt($productId);
	
	if(((!empty($colorId))&&($colorId))&&(!empty($organizationColorSizeId))&&($organizationColorSizeId))
	{
		$url = base_url().'product/'.$productName.'-details-'.id_encrypt($productId).'-color-'.id_encrypt($colorId).'-size-'.id_encrypt($sizeId).'-colorsize-'.id_encrypt($organizationColorSizeId);
	}
	
	if(((!empty($sizeId))&&($sizeId))&&(!empty($organizationColorSizeId))&&($organizationColorSizeId))
	{
		$url = base_url().'product/'.$productName.'-details-'.id_encrypt($productId).'-color-'.id_encrypt($colorId).'-size-'.id_encrypt($sizeId).'-colorsize-'.id_encrypt($organizationColorSizeId);
	}
	return $url;
}

function product_image_url($imageNm)
{
	if((!empty($imageNm))&&(file_exists('uploads/product/thumb500_500/'.$imageNm)))
	{
		return base_url().'uploads/product/thumb500_500/'.$imageNm; 					
	}
	elseif((!empty($imageNm))&&(file_exists('uploads/product/'.$imageNm)))
	{
		return base_url().'uploads/product/'.$imageNm;
	}
	else
	{
		return base_url().'img/no_image.jpg';
	}					
}

function frontend_grid_category_url($categoryId,$categoryName)
{
	$categoryName = str_replace(' ','-',$categoryName); // Replaces all spaces with hyphens.
	$categoryName = preg_replace('/[^A-Za-z0-9\-]/', '', $categoryName); // Removes special chars.   
	$categoryName = preg_replace('/-{2,}/','-',$categoryName);
	$url = base_url().'category/'.$categoryName.'-grid-'.id_encrypt($categoryId);
	return $url;
}

function frontend_list_category_url($categoryId,$categoryName)
{
	$categoryName = str_replace(' ','-',$categoryName); // Replaces all spaces with hyphens.
	$categoryName = preg_replace('/[^A-Za-z0-9\-]/', '', $categoryName); // Removes special chars.   
	$categoryName = preg_replace('/-{2,}/','-',$categoryName);
	$url = base_url().'category/'.$categoryName.'-list-'.id_encrypt($categoryId);
	return $url;
}

function product_rating_review_url($productId,$productName,$rating=0)
{
	$productName = str_replace(' ','-',$productName); // Replaces all spaces with hyphens.
	$productName = preg_replace('/[^A-Za-z0-9\-]/', '', $productName); // Removes special chars.   
	$productName = preg_replace('/-{2,}/','-',$productName);
	
	if($rating)
	{
		$url = base_url().'product/'.$productName.'-rating-review-'.id_encrypt($productId).'-rating-no-'.$rating;
	}
	else
	{
		$url = base_url().'product/'.$productName.'-rating-review-'.id_encrypt($productId);
	}
	return $url;
}

function product_write_review_url($productId,$productName)
{
	$productName = str_replace(' ','-',$productName); // Replaces all spaces with hyphens.
	$productName = preg_replace('/[^A-Za-z0-9\-]/', '', $productName); // Removes special chars.   
	$productName = preg_replace('/-{2,}/','-',$productName);
	
	$url = base_url().'product/'.$productName.'-write-rating-review-'.id_encrypt($productId);
	return $url;
}

function pointeforce_balance_url()
{
	$url = base_url().'pointe-force-balance';
	return $url;
}
?>