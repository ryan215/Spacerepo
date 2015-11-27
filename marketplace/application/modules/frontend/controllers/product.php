<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Product extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
	}	
	
	public function index()
	{
		$this->data['title'] = 'Test';
	}
	
	public function product_list_grid($categoryId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list_grid',
				'log_MID'    => '' 
		) );
		
		$categoryId   = id_decrypt($categoryId); 
		$categoryName = '';
		$where        = '';
		$productList  = array();
		$catArr		  = array();
		$brandList    = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$details 	  = '';
		
		$catDetails = $this->segment_cat_m->category_details($categoryId);
		if(!empty($catDetails))
		{
			$categoryName = $catDetails->categoryCode;
		}
		
		$categoryChildStr  = '';
		$categoryChildList = $this->segment_cat_m->category_all_child_list($categoryId);
		
		if(!empty($categoryChildList))
		{
			$categoryChildStr = $categoryChildList->allChild;
			if(!empty($categoryChildStr))
			{
				$catExpldArr = explode(',',$categoryChildStr);
				if(!empty($catExpldArr))
				{
					$whereCond     = array();
					$catExpldArr[] = $categoryId;
					foreach($catExpldArr as $catId) 
					{
						if((!empty($catId))&&($catId))
						{
							$whereCond[] = 'product_category.categoryId = '.$catId;
						}
					}
					if(!empty($whereCond))
					{
						$where = '('.implode(' OR ',$whereCond).')';
					}
				}
			}
			else
			{
				$where = '(product_category.categoryId = '.$categoryId.')';
			}
		}
		else
		{
			$where = '(product_category.categoryId = '.$categoryId.')';
		}
		
		if(!empty($where))
		{
			$details = $this->product_m->product_listing_according_categry('','',$where);
		}
		
		//echo "<pre>"; print_r($details); exit;
		//echo $this->db->last_query(); exit;
		if(!empty($details))
		{
			$i = 0;
			foreach($details as $row)
			{
				if(!empty($productList[$row->productId]))
				{					
				}
				else
				{
					$productWeight = $row->weight+$row->shippingWeight;
					$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
					
					$displayPrice  = $priceArr['displayPrice'];
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $row->code;
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->adminPrice;
					$productList[$row->productId]['imageName']    = $row->mainImage;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					$total++;
					if(!empty($catArr[$row->categoryId]))
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = $catArr[$row->categoryId]['totalProducts']+1;
					}
					else
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = 1;
					}
					
					if($i==0)
					{
						$minPrice = $displayPrice;
					}
					
					$maxPrice = $displayPrice;
					$i++;
					$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES)); 
				}
			}
		}
		
		$this->data['catArr']        = $catArr;
		$this->data['categoryName']  = $categoryName;
		$this->data['minPrice']      = $minPrice;
		$this->data['maxPrice']      = $maxPrice;
		$this->data['brandList']     = $brandList;
		$this->data['total']         = $total;
		$this->data['categoryId']    = $categoryId;
		$this->data['productList']   = $productList;
		$this->data['title'] 		 = $categoryName;
		$this->frontendCustomView('product/product_list_grid',$this->data);
	}
	
	public function ajaxFunGrid($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$categoryId   = $this->input->post('categoryId');
		$from_price   = $this->input->post('from_price');
		$to_price     = $this->input->post('to_price');
		$brandArr     = $this->input->post('brandArr');
		$catArr       = $this->input->post('catArr');
		$page_number  = $this->input->post('page');
		$pSorting     = $this->input->post('pSorting');
		$brandListArr = array();
		$where 		  = '';
	//	echo "<pre>"; print_r($_POST); exit;
		if(!empty($catArr))
		{
			$whereCond = array();
			foreach($catArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereCond[] = 'product_category.categoryId = '.$value;	
				}
			}
			if(!empty($whereCond))
			{
				$where = '('.implode(' OR ',$whereCond).')';
			}
		}
		elseif(!empty($categoryId))
		{	
			$catDetails = $this->segment_cat_m->category_details($categoryId);
			if(!empty($catDetails))
			{
				$categoryName = $catDetails->categoryCode;
			}
			
			$categoryChildStr  = '';
			$categoryChildList = $this->segment_cat_m->category_all_child_list($categoryId);
			if(!empty($categoryChildList))
			{
				$categoryChildStr = $categoryChildList->allChild;
				if(!empty($categoryChildStr))
				{
					$catExpldArr = explode(',',$categoryChildStr);
					if(!empty($catExpldArr))
					{
						$whereCond     = array();
						$catExpldArr[] = $categoryId;
						foreach($catExpldArr as $catId) 
						{
							if((!empty($catId))&&($catId))
							{
								$whereCond[] = 'product_category.categoryId = '.$catId;
							}
						}
			
						if(!empty($whereCond))
						{
							$where = '('.implode(' OR ',$whereCond).')';
						}
					}
				}
				else
				{
					$where = '(product_category.categoryId = '.$categoryId.')';
				}
			}
			else
			{
				$where = '(product_category.categoryId = '.$categoryId.')';
			}
		}
		
		if(!empty($brandName))
		{
			$where.= " AND brand.brandName LIKE '".$brandName."%'";
		}
		
		$whereBrand = array();
		if(!empty($brandArr))
		{
			foreach($brandArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereBrand[] = 'brand.brandId = '.$value;	
				}
			}
			if(!empty($whereBrand))
			{
				$where.= ' AND ('.implode(' OR ',$whereBrand).')';
			}
		}

		$productList = array();
		$page_number = ($page_number*48);
		
		if(($pSorting==1)||($pSorting==2))
		{
			$details = $this->product_m->product_listing_according_categry('','',$where,$pSorting);
			$totalData = $details;
		}
		else
		{
			$totalData = $this->product_m->product_listing_according_categry(0,'',$where);	
			$details   = $this->product_m->product_listing_according_categry($page_number,48,$where,$pSorting);
		}	

		$total = 0;
		if(!empty($details))
		{
			foreach($details as $row)
			{
				if(!empty($productList[$row->productId]))
				{
					if(!empty($row->adminPrice))
					{
						$productList[$row->productId]['adminPrice'] = $row->adminPrice;
					}
				}
				else
				{
					$productWeight = $row->weight+$row->shippingWeight;
					$productId     = $row->productId;
                    $priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
										
					$productName = $row->code;
					if(strlen($row->code)>63)
					{
						$productName = substr($row->code,0,63).'...';
					}
					
					$displayPrice  = $priceArr['displayPrice'];
					$productList[$row->productId]['productId']   	  = $row->productId;
					$productList[$row->productId]['productName']  	  = $productName;
					$productList[$row->productId]['currentPrice']	  = $displayPrice;
					$productList[$row->productId]['adminPrice']   	  = $row->adminPrice;
					$productList[$row->productId]['imageName']    	  = $row->mainImage;
					$productList[$row->productId]['organizationName'] = $row->organizationName;
					$productList[$row->productId]['cashAdminFee']	  = $priceArr['cashAdminFee'];
					$productList[$row->productId]['freeShipPrdId'] 	  = 0;
					$productList[$row->productId]['freeShipCatId']	  = 0;
					$productList[$row->productId]['totalRating'] 	  = $row->totalProductRating;
					$productList[$row->productId]['avgRating']   	  = $row->avgProductRating;
					$productList[$row->productId]['wishListId']   	  = $row->wishListId;
					$productList[$row->productId]['customerId']   	  = $row->customerId;
					$productList[$row->productId]['productTypeId']    = $row->productTypeId;
					
					$freeShipPrdDet = $this->product_m->free_shipping_prd_details($row->productId);
					$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));					
					if(!empty($freeShipPrdDet))
					{
						$productList[$row->productId]['freeShipPrdId'] = $freeShipPrdDet->freeShipPrdId;
					}
					else
					{
						$prdCatLst = $this->segment_cat_m->category_parent_list($row->categoryId);
						$this->custom_log->write_log('custom_log','parent category list is '.print_r($prdCatLst,true));
						if(!empty($prdCatLst))
						{
							$whereArr = array();
							foreach($prdCatLst as $catId)
							{
								$whereArr[$catId->categoryId] = 'categoryId = '.$catId->categoryId;
							}
							if(!empty($whereArr))
							{
								$catWhr = '('.implode(" OR ",$whereArr).')';
								$this->custom_log->write_log('custom_log','Where is '.$catWhr);
								
								$freeShipCatDet = $this->segment_cat_m->free_shipping_multiple_category($catWhr);
								$this->custom_log->write_log('custom_log','parent category list is '.print_r($freeShipCatDet,true));
								if(!empty($freeShipCatDet))
								{
									foreach($freeShipCatDet as $fscatId)
									{
										$productList[$row->productId]['freeShipCatId'] = $fscatId->freeShipCatId;			
									}
								}
							}
						}					
					}
									
					$productColorSize = $this->product_m->get_product_all_color_and_size($row->productId);
					if(!empty($productColorSize))
					{
						foreach($productColorSize as $colorsize)
						{
							if($colorsize->colorId)
							{
								$productList[$row->productId]['colors'][$colorsize->colorId] = $colorsize->colorCode;
							}
							if(!empty($colorsize->size))
							{
								$productList[$row->productId]['size'][$colorsize->size] = $colorsize->size;
							}
						}
					}
					$total++;
					
					$brandListArr[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
				}
			}
		}
		
		if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
		{
			if(!empty($productList))
			{
				foreach($productList as $key=>$value)
				{
					unset($productList[$key]);
					if(($value['currentPrice']>=$from_price)&&($value['currentPrice']<=$to_price))
					{
						$productList[$key] = $value;
					} 
				}
			} 
		}
		elseif((!empty($from_price))&&(is_numeric($from_price)))
		{
			if(!empty($productList))
			{
				foreach($productList as $key=>$value)
				{
					unset($productList[$key]);
					if($value['currentPrice']>=$from_price)
					{
						$productList[$key] = $value;
					} 
				}
			} 
		}
		elseif((!empty($to_price))&&(is_numeric($to_price)))
		{
			if(!empty($productList))
			{
				foreach($productList as $key=>$value)
				{
					unset($productList[$key]);
					if($value['currentPrice']<=$to_price)
					{
						$productList[$key] = $value;
					} 
				}
			} 
		}
		
		if($pSorting==1)
		{
			uasort($productList,'asc_price');
			if($productList)
			{
				$j = $page_number;
				$i = 0;
				foreach($productList as $key=>$value)
				{
					if(($i<$j)||($i>=($j+48)))
					{
						unset($productList[$key]);
					}
					$i++;
				}
			}
		}
		elseif($pSorting==2)
		{
			uasort($productList,'des_price');
			if($productList)
			{
				$j = $page_number;
				$i = 0;
				foreach($productList as $key=>$value)
				{
					if(($i<$j)||($i>=($j+48)))
					{
						unset($productList[$key]);
					}
					$i++;
				}
			}
		}
		
		$this->data['list']         = $productList;
		$this->data['page_number']  = $page_number;
		$this->data['brandListArr'] = $brandListArr;
				
		$result = array(
					'total'     => count($totalData),
					'totalPage' => ceil(count($totalData)/48),
					'view'      => $this->load->view('product/ajax_page_grid',$this->data,true),
				);
		echo json_encode($result);		
	}
	
	public function product_list_list($categoryId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list_list',
				'log_MID'    => '' 
		) );
		
		$categoryId   = id_decrypt($categoryId); 
		$categoryName = '';
		$where        = '';
		$productList  = array();
		$catArr		  = array();
		$brandList    = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$details 	  = '';
		
		$catDetails = $this->segment_cat_m->category_details($categoryId);
		if(!empty($catDetails))
		{
			$categoryName = $catDetails->categoryCode;
		}
		
		$categoryChildStr  = '';
		$categoryChildList = $this->segment_cat_m->category_all_child_list($categoryId);
		if(!empty($categoryChildList))
		{
			$categoryChildStr = $categoryChildList->allChild;
			if(!empty($categoryChildStr))
			{
				$catExpldArr = explode(',',$categoryChildStr);
				if(!empty($catExpldArr))
				{
					$whereCond     = array();
					$catExpldArr[] = $categoryId;
					foreach($catExpldArr as $catId) 
					{
						if((!empty($catId))&&($catId))
						{
							$whereCond[] = 'product_category.categoryId = '.$catId;
						}
					}
					if(!empty($whereCond))
					{
						$where = '('.implode(' OR ',$whereCond).')';
					}
				}
			}
			else
			{
				$where = '(product_category.categoryId = '.$categoryId.')';
			}
		}
		else
		{
			$where = '(product_category.categoryId = '.$categoryId.')';
		}
		
		if(!empty($where))
		{
			$details = $this->product_m->product_listing_according_categry('','',$where);
		}
		
		if(!empty($details))
		{
			$i = 0;
			foreach($details as $row)
			{
				if(!empty($productList[$row->productId]))
				{					
				}
				else
				{
					$productWeight = $row->weight+$row->shippingWeight;
					$productId     = $row->productId;
                    $priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
					$displayPrice  = $priceArr['displayPrice'];
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $row->code;
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->adminPrice;
					$productList[$row->productId]['imageName']    = $row->mainImage;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					$total++;
					if(!empty($catArr[$row->categoryId]))
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = $catArr[$row->categoryId]['totalProducts']+1;
					}
					else
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = 1;
					}
					
					if($i==0)
					{
						$minPrice = $displayPrice;
					}
					
					$maxPrice = $displayPrice;
					$i++;
					
					$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES)); 
				}
			}
		}
		
		$this->data['catArr']        = $catArr;
		$this->data['categoryName']  = $categoryName;
		$this->data['minPrice']      = $minPrice;
		$this->data['maxPrice']      = $maxPrice;
		$this->data['brandList']     = $brandList;
		$this->data['total']         = $total;
		$this->data['categoryId']    = $categoryId;
		$this->data['productList']   = $productList;
		$this->data['title'] 		 = $categoryName;
		$this->frontendCustomView('product/product_list_list',$this->data);
	}
	
	public function ajaxFunList($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$categoryId    = $this->input->post('categoryId');
		$from_price    = $this->input->post('from_price');
		$to_price      = $this->input->post('to_price');
		$brandArr      = $this->input->post('brandArr');
		$catArr        = $this->input->post('catArr');
		$page_number   = $this->input->post('page');
		$pSorting      = $this->input->post('pSorting');
		
		$where = '';
		if(!empty($catArr))
		{
			$whereCond = array();
			foreach($catArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereCond[] = 'product_category.categoryId = '.$value;	
				}
			}
			if(!empty($whereCond))
			{
				$where = '('.implode(' OR ',$whereCond).')';
			}
		}
		elseif(!empty($categoryId))
		{	
			$catDetails = $this->segment_cat_m->category_details($categoryId);
			if(!empty($catDetails))
			{
				$categoryName = $catDetails->categoryCode;
			}
			
			$categoryChildStr  = '';
			$categoryChildList = $this->segment_cat_m->category_all_child_list($categoryId);
			if(!empty($categoryChildList))
			{
				$categoryChildStr = $categoryChildList->allChild;
				if(!empty($categoryChildStr))
				{
					$catExpldArr = explode(',',$categoryChildStr);
					if(!empty($catExpldArr))
					{
						$whereCond     = array();
						$catExpldArr[] = $categoryId;
						foreach($catExpldArr as $catId) 
						{
							if((!empty($catId))&&($catId))
							{
								$whereCond[] = 'product_category.categoryId = '.$catId;
							}
						}
			
						if(!empty($whereCond))
						{
							$where = '('.implode(' OR ',$whereCond).')';
						}
			
					}
				}
				else
				{
					$where = '(product_category.categoryId = '.$categoryId.')';
				}
			}
			else
			{
				$where = '(product_category.categoryId = '.$categoryId.')';
			}
		}
		
		if(!empty($brandName))
		{
			$where.= " AND brand.brandName LIKE '".$brandName."%'";
		}
		
		$whereBrand = array();
		if(!empty($brandArr))
		{
			foreach($brandArr as $value)
			{
				$whereBrand[] = 'brand.brandId = '.$value;	
			}
			if(!empty($whereBrand))
			{
				$where.= ' AND ('.implode(' OR ',$whereBrand).')';
			}
		}
		
		$productList = array();
		$page_number = ($page_number*48);
		
		if(($pSorting==1)||($pSorting==2))
		{
			$details = $this->product_m->product_listing_according_categry('','',$where,$pSorting);
			$totalData = $details;
		}
		else
		{
			$totalData = $this->product_m->product_listing_according_categry(0,'',$where);	
			$details   = $this->product_m->product_listing_according_categry($page_number,48,$where,$pSorting);
		}
		
		$total = 0;
		
		if(!empty($details))
		{
			foreach($details as $row)
			{
				if(!empty($productList[$row->productId]))
				{
					if(!empty($row->adminPrice))
					{
						$productList[$row->productId]['adminPrice']   = $row->adminPrice;
					}
				}
				else
				{
					$productWeight = $row->weight+$row->shippingWeight;
					$productId     = $row->productId;
                    $priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);											
					$productName   = $row->code;
					if(strlen($row->code)>63)
					{
						$productName = substr($row->code,0,63).'...';
					}
					
					$displayPrice  = $priceArr['displayPrice'];
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $productName;
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->adminPrice;
					$productList[$row->productId]['imageName']    = $row->mainImage;
					$productList[$row->productId]['organizationName'] = $row->organizationName;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					
					$productList[$row->productId]['freeShipPrdId'] = 0;
					$productList[$row->productId]['freeShipCatId'] = 0;
					
					$productList[$row->productId]['totalRating'] = $row->totalProductRating;
					$productList[$row->productId]['avgRating']   = $row->avgProductRating;
					
					$productList[$row->productId]['wishListId']   = $row->wishListId;
					$productList[$row->productId]['customerId']   = $row->customerId;
					$productList[$row->productId]['productTypeId']    = $row->productTypeId;	

					
					$freeShipPrdDet = $this->product_m->free_shipping_prd_details($row->productId);
					$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));					
					if(!empty($freeShipPrdDet))
					{
						$productList[$row->productId]['freeShipPrdId'] = $freeShipPrdDet->freeShipPrdId;
					}
					else
					{
						$prdCatLst = $this->segment_cat_m->category_parent_list($row->categoryId);
						$this->custom_log->write_log('custom_log','parent category list is '.print_r($prdCatLst,true));
						if(!empty($prdCatLst))
						{
							$whereArr = array();
							foreach($prdCatLst as $catId)
							{
								$whereArr[$catId->categoryId] = 'categoryId = '.$catId->categoryId;
							}
							if(!empty($whereArr))
							{
								$catWhr = '('.implode(" OR ",$whereArr).')';
								$this->custom_log->write_log('custom_log','Where is '.$catWhr);
								
								$freeShipCatDet = $this->segment_cat_m->free_shipping_multiple_category($catWhr);
								$this->custom_log->write_log('custom_log','parent category list is '.print_r($freeShipCatDet,true));
								if(!empty($freeShipCatDet))
								{
									foreach($freeShipCatDet as $fscatId)
									{
										$productList[$row->productId]['freeShipCatId'] = $fscatId->freeShipCatId;			
									}
								}
							}
						}					
					}
						
											
					$productColorSize = $this->product_m->get_product_all_color_and_size($row->productId);
					if(!empty($productColorSize))
					{
						foreach($productColorSize as $colorsize)
						{
							if($colorsize->colorId)
							{
								$productList[$row->productId]['colors'][$colorsize->colorId] = $colorsize->colorCode;
							}
							if(!empty($colorsize->size))
							{
								$productList[$row->productId]['size'][$colorsize->size] = $colorsize->size;
							}
						}
					}
					$total++;
				}
			}
		}
		
		if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
		{
			if(!empty($productList))
			{
				foreach($productList as $key=>$value)
				{
					unset($productList[$key]);
					if(($value['currentPrice']>=$from_price)&&($value['currentPrice']<=$to_price))
					{
						$productList[$key] = $value;
					} 
				}
			} 
		}
		elseif((!empty($from_price))&&(is_numeric($from_price)))
		{
			if(!empty($productList))
			{
				foreach($productList as $key=>$value)
				{
					unset($productList[$key]);
					if($value['currentPrice']>=$from_price)
					{
						$productList[$key] = $value;
					} 
				}
			} 
		}
		elseif((!empty($to_price))&&(is_numeric($to_price)))
		{
			if(!empty($productList))
			{
				foreach($productList as $key=>$value)
				{
					unset($productList[$key]);
					if($value['currentPrice']<=$to_price)
					{
						$productList[$key] = $value;
					} 
				}
			} 
		}
		
		if($pSorting==1)
		{
			uasort($productList,'asc_price');
			if($productList)
			{
				$j = $page_number;
				$i = 0;
				foreach($productList as $key=>$value)
				{
					if(($i<$j)||($i>=($j+48)))
					{
						unset($productList[$key]);
					}
					$i++;
				}
			}
		}
		elseif($pSorting==2)
		{
			uasort($productList,'des_price');
			if($productList)
			{
				$j = $page_number;
				$i = 0;
				foreach($productList as $key=>$value)
				{
					if(($i<$j)||($i>=($j+48)))
					{
						unset($productList[$key]);
					}
					$i++;
				}
			}
		}
		
		$this->data['list'] = $productList;
		$this->data['page_number'] = $page_number;		
		$result = array(
					'total'     => count($totalData),
					'totalPage' => ceil(count($totalData)/48),
					'view'      => $this->load->view('product/ajax_page_list',$this->data,true)
				  );
		echo json_encode($result);		
	}	
	
	public function search_brand_list()
	{
		$result    = '';
		$brandName = trim($this->input->post('brandName'));
		$brandList = $this->input->post('brandList');
		if(!empty($brandList))
		{
			$brandName = strtolower($brandName);
			$brndlst = json_decode($brandList,true);
			if(!empty($brandName))
			{
				foreach($brndlst as $key=>$value)
				{
					unset($brndlst[$key]);
					$value = strtolower($value);					
					if(stripos($value,$brandName)!==false)
					{
						$brndlst[$key] = $value;
					}
				}
			}
			
			foreach($brndlst as $key=>$value)
			{
				$value = strtolower($value);
				$result.= '<div class="block-element"><label class="ctg-label-left"><input type="checkbox" name="brandArr['.$key.']" value="'.$key.'" onClick="searchfun();"><span class="lbl padding-8">'.ucfirst($value).'</span></label></div>';
			}
		}
		else
		{
			$result = 'No Brand List Available';
		}		
		echo $result;
		//echo "<pre>"; print_r($_POST);
	}
	
	public function search_product()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'search_product',
				'log_MID'    => '' 
		));
		
		$search = trim($this->input->post('term'));
		$this->custom_log->write_log('custom_log','search text is '.$search);
		
		$result = '';
		if(!empty($search))
		{
			$result = $this->product_m->auto_search($search);
			$this->custom_log->write_log('custom_log','search result is '.print_r($result,true));
		}
		$this->data['search'] = $search;
		$this->data['result'] = $result;
		echo $this->load->view('product/search_product',$this->data,true);
	}
	
	public function brand_product_list_grid($brandId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'brand_product_list_grid',
				'log_MID'    => '' 
		) );
		
		$brandId      = id_decrypt($brandId); 
		$brandName    = '';
		$where        = '';
		$productList  = array();
		$catArr		  = array();
		$brandList    = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$details 	  = '';
		
		$brandDetails = $this->brand_m->brand_details($brandId);
		$this->custom_log->write_log('custom_log','brand details is '.print_r($brandDetails,true));
		
		if(!empty($brandDetails))
		{
			$brandName = $brandDetails->brandName;
		}
		else
		{
			$this->session->set_flashdata('error','This brand details not found');
			$this->custom_log->write_log('custom_log','This brand details not found');
		    redirect(base_url());
		}
		
		$sessionId = $this->session->userdata('session_id');
		$this->custom_log->write_log('custom_log','Session id is '.$sessionId);
		
		$where     = '(product.brandId = '.$brandId.')';
		$details   = $this->product_m->product_listing_according_brand('','',$where);
		$insertArr = array();
		if(!empty($details))
		{
			$i = 0;
			foreach($details as $row)
			{
				if(!empty($productList[$row->productId]))
				{					
				}
				else
				{
					$productWeight = $row->weight+$row->shippingWeight;
					$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
					//echo "<pre>";	print_r($priceArr); exit;
					$displayPrice  = $priceArr['displayPrice'];
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $row->code;
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->marketingPrice;
					$productList[$row->productId]['imageName']    = $row->imageName;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					$total++;
					if(!empty($catArr[$row->categoryId]))
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = $catArr[$row->categoryId]['totalProducts']+1;
					}
					else
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = 1;
					}
					
					if($i==0)
					{
						$minPrice = $displayPrice;
					}
					
					$maxPrice = $displayPrice;
					$i++;
					$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
					
					$freeShipPrdId	= 0;
					$freeShipCatId  = 0;
					$freeShipPrdDet = $this->product_m->free_shipping_prd_details($row->productId);
					$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));				if(!empty($freeShipPrdDet))
					{
						$freeShipPrdId = $freeShipPrdDet->freeShipPrdId;
					}
					else
					{
						$prdCatLst = $this->segment_cat_m->category_parent_list($row->categoryId);
						$this->custom_log->write_log('custom_log','parent category list is '.print_r($prdCatLst,true));
						if(!empty($prdCatLst))
						{
							$whereArr = array();
							foreach($prdCatLst as $catId)
							{
								$whereArr[$catId->categoryId] = 'categoryId = '.$catId->categoryId;
							}
							if(!empty($whereArr))
							{
								$catWhr = '('.implode(" OR ",$whereArr).')';
								$this->custom_log->write_log('custom_log','Where is '.$catWhr);
								
								$freeShipCatDet = $this->segment_cat_m->free_shipping_multiple_category($catWhr);
								$this->custom_log->write_log('custom_log','parent category list is '.print_r($freeShipCatDet,true));
								if(!empty($freeShipCatDet))
								{
									foreach($freeShipCatDet as $fscatId)
									{
										$freeShipCatId = $fscatId->freeShipCatId;			
									}
								}
							}
						}					
					}
					
					if($row->marketingPrice)
					{
						$marketingPrice = $row->marketingPrice;
					}
					else
					{
						$marketingPrice = 0;
					}
					if($row->totalViewCount)
					{
						$totalViewCount = $row->totalViewCount;
					}
					else
					{
						$totalViewCount = 0;
					}
					 
					 if($row->wishListId)
					{
						$wishListId = $row->wishListId;
					}
					else
					{
						$wishListId = 0;
					}
					
					if($row->customerId)
					{
						$customerId = $row->customerId;
					}
					else
					{
						$customerId = 0;
					}
					
					$insertArr[] = array(
										'sessionId'    			=> $sessionId,
										'productId'    			=> $row->productId,
										'productName'  			=> $row->code,
										'categoryId'   			=> $row->categoryId,
										'displayPrice' 			=> $displayPrice,
										'organizationProductId' => $row->organizationProductId,
										'imageName'			    => $row->imageName,
										'brandId' 				=> $row->brandId,
										'marketingPrice'		=> $marketingPrice,
										'cashAdminFee'			=> $priceArr['cashAdminFee'],
										'freeShipPrdId'			=> $freeShipPrdId,
										'freeShipCatId'			=> $freeShipCatId,
										'totalViewCount'		=> $totalViewCount,
										'wishListId'			=> $wishListId,
										'customerId'			=> $customerId,
										'productTypeId'  		=> $row->productTypeId,
										'addFor'				=> 'Brand',
										'lastModifiedBy'		=> $this->session->userdata('userId'),
										'lastModifiedDt'		=> date('Y-m-d H:i:s'),
									);
				}
			}
		}
		
		$this->product_m->delete_old_brand_product_list($sessionId,$brandId);
		if((!empty($insertArr))&&(count($insertArr)))
		{
			$this->product_m->add_temp_product_listing($insertArr);
		}
		
		$this->data['catArr']      = $catArr;
		$this->data['brandName']   = $brandName;
		$this->data['minPrice']    = $minPrice;
		$this->data['maxPrice']    = $maxPrice;
		$this->data['brandList']   = $brandList;
		$this->data['total']       = $total;
		$this->data['brandId']     = $brandId;
		$this->data['productList'] = $productList;
		$this->data['title'] 	   = $brandName;
		$this->frontendCustomView('product/brand_product_list_grid',$this->data);
	}
	
	public function brandAjaxFunGrid()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'brandAjaxFunGrid',
				'log_MID'    => '' 
		) );
		
		$brandId	  = $this->input->post('brandId');
		$from_price   = $this->input->post('from_price');
		$to_price     = $this->input->post('to_price');
		$brandArr     = $this->input->post('brandArr');
		$catArr       = $this->input->post('catArr');
		$page_number  = $this->input->post('page');
		$pSorting     = $this->input->post('pSorting');
		$brandListArr = array();
		$where 		  = '(brandId = '.$brandId.')';
	
		if(!empty($catArr))
		{
			$whereCond = array();
			foreach($catArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereCond[] = 'categoryId = '.$value;	
				}
			}
			if(!empty($whereCond))
			{
				$where.= ' AND ('.implode(' OR ',$whereCond).')';
			}
		}
		
		$whereBrand = array();
		if(!empty($brandArr))
		{
			foreach($brandArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereBrand[] = 'brandId = '.$value;	
				}
			}
			if(!empty($whereBrand))
			{
				$where.= ' AND ('.implode(' OR ',$whereBrand).')';
			}
		}
		
		if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
		{
			$where.= ' AND (displayPrice >= '.$from_price.' AND displayPrice <= '.$to_price.')';
		}
		elseif((!empty($from_price))&&(is_numeric($from_price)))
		{
			$where.= ' AND (displayPrice >= '.$from_price.')';
		}
		elseif((!empty($to_price))&&(is_numeric($to_price)))
		{
			$where.= ' AND (displayPrice <= '.$to_price.')';
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$page_number			   = ($page_number*48);
		$total 		 			   = $this->product_m->total_product_temp_list($where);
		$this->data['list'] 	   = $this->product_m->product_temp_list($page_number,48,$where,$pSorting);
		$this->data['page_number'] = $page_number;
		
		$result = array(
					'total'     => $total,
					'totalPage' => ceil($total/48),
					'view'      => $this->load->view('product/brand_ajax_page_grid',$this->data,true),
				);
		echo json_encode($result);		
	}
	
	public function brand_product_list_list($brandId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'brand_product_list_grid',
				'log_MID'    => '' 
		) );
		
		$brandId      = id_decrypt($brandId); 
		$brandName    = '';
		$where        = '';
		$productList  = array();
		$catArr		  = array();
		$brandList    = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$details 	  = '';
		
		$brandDetails = $this->brand_m->brand_details($brandId);
		$this->custom_log->write_log('custom_log','brand details is '.print_r($brandDetails,true));
		
		if(!empty($brandDetails))
		{
			$brandName = $brandDetails->brandName;
		}
		else
		{
			$this->session->set_flashdata('error','This brand details not found');
			$this->custom_log->write_log('custom_log','This brand details not found');
		    redirect(base_url());
		}
		
		$sessionId = $this->session->userdata('session_id');
		$this->custom_log->write_log('custom_log','Session id is '.$sessionId);
		
		$where     = '(product.brandId = '.$brandId.')';
		$details   = $this->product_m->product_listing_according_brand('','',$where);
		$insertArr = array();
		if(!empty($details))
		{
			$i = 0;
			foreach($details as $row)
			{
				if(!empty($productList[$row->productId]))
				{					
				}
				else
				{
					$productWeight = $row->weight+$row->shippingWeight;
					$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
					//echo "<pre>";	print_r($priceArr); exit;
					$displayPrice  = $priceArr['displayPrice'];
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $row->code;
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->marketingPrice;
					$productList[$row->productId]['imageName']    = $row->imageName;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					$total++;
					if(!empty($catArr[$row->categoryId]))
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = $catArr[$row->categoryId]['totalProducts']+1;
					}
					else
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = $row->categoryCode;
						$catArr[$row->categoryId]['totalProducts'] = 1;
					}
					
					if($i==0)
					{
						$minPrice = $displayPrice;
					}
					
					$maxPrice = $displayPrice;
					$i++;
					$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
					
					$freeShipPrdId	= 0;
					$freeShipCatId  = 0;
					$freeShipPrdDet = $this->product_m->free_shipping_prd_details($row->productId);
					$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));				if(!empty($freeShipPrdDet))
					{
						$freeShipPrdId = $freeShipPrdDet->freeShipPrdId;
					}
					else
					{
						$prdCatLst = $this->segment_cat_m->category_parent_list($row->categoryId);
						$this->custom_log->write_log('custom_log','parent category list is '.print_r($prdCatLst,true));
						if(!empty($prdCatLst))
						{
							$whereArr = array();
							foreach($prdCatLst as $catId)
							{
								$whereArr[$catId->categoryId] = 'categoryId = '.$catId->categoryId;
							}
							if(!empty($whereArr))
							{
								$catWhr = '('.implode(" OR ",$whereArr).')';
								$this->custom_log->write_log('custom_log','Where is '.$catWhr);
								
								$freeShipCatDet = $this->segment_cat_m->free_shipping_multiple_category($catWhr);
								$this->custom_log->write_log('custom_log','parent category list is '.print_r($freeShipCatDet,true));
								if(!empty($freeShipCatDet))
								{
									foreach($freeShipCatDet as $fscatId)
									{
										$freeShipCatId = $fscatId->freeShipCatId;			
									}
								}
							}
						}					
					}
					 
					 if($row->marketingPrice)
					{
						$marketingPrice = $row->marketingPrice;
					}
					else
					{
						$marketingPrice = 0;
					}
					if($row->totalViewCount)
					{
						$totalViewCount = $row->totalViewCount;
					}
					else
					{
						$totalViewCount = 0;
					}
					
					if($row->wishListId)
					{
						$wishListId = $row->wishListId;
					}
					else
					{
						$wishListId = 0;
					}
					
					if($row->customerId)
					{
						$customerId = $row->customerId;
					}
					else
					{
						$customerId = 0;
					}
					
					$insertArr[] = array(
										'sessionId'    			=> $sessionId,
										'productId'    			=> $row->productId,
										'productName'  			=> $row->code,
										'categoryId'   			=> $row->categoryId,
										'displayPrice' 			=> $displayPrice,
										'organizationProductId' => $row->organizationProductId,
										'imageName'			    => $row->imageName,
										'brandId' 				=> $row->brandId,
										'marketingPrice'		=> $marketingPrice,
										'cashAdminFee'			=> $priceArr['cashAdminFee'],
										'freeShipPrdId'			=> $freeShipPrdId,
										'freeShipCatId'			=> $freeShipCatId,
										'totalViewCount'		=> $totalViewCount,
										'wishListId'			=> $wishListId,
										'customerId'			=> $customerId,
										'productTypeId'  		=> $row->productTypeId,
										'addFor'				=> 'Brand',
										'lastModifiedBy'		=> $this->session->userdata('userId'),
										'lastModifiedDt'		=> date('Y-m-d H:i:s'),
									);
				}
			}
		}
		
		$this->product_m->delete_old_brand_product_list($sessionId);
		if((!empty($insertArr))&&(count($insertArr)))
		{
			$this->product_m->add_temp_product_listing($insertArr);
		}
		
		$this->data['catArr']      = $catArr;
		$this->data['brandName']   = $brandName;
		$this->data['minPrice']    = $minPrice;
		$this->data['maxPrice']    = $maxPrice;
		$this->data['brandList']   = $brandList;
		$this->data['total']       = $total;
		$this->data['brandId']     = $brandId;
		$this->data['productList'] = $productList;
		$this->data['title'] 	   = $brandName;
		$this->frontendCustomView('product/brand_product_list_list',$this->data);
	}
	
	public function brandAjaxFunList()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'brandAjaxFunList',
				'log_MID'    => '' 
		) );
		
		$brandId	  = $this->input->post('brandId');
		$from_price   = $this->input->post('from_price');
		$to_price     = $this->input->post('to_price');
		$brandArr     = $this->input->post('brandArr');
		$catArr       = $this->input->post('catArr');
		$page_number  = $this->input->post('page');
		$pSorting     = $this->input->post('pSorting');
		$brandListArr = array();
		$where 		  = '(brandId = '.$brandId.')';
	
		if(!empty($catArr))
		{
			$whereCond = array();
			foreach($catArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereCond[] = 'categoryId = '.$value;	
				}
			}
			if(!empty($whereCond))
			{
				$where.= ' AND ('.implode(' OR ',$whereCond).')';
			}
		}
		
		$whereBrand = array();
		if(!empty($brandArr))
		{
			foreach($brandArr as $value)
			{
				if((!empty($value))&&($value))
				{
					$whereBrand[] = 'brandId = '.$value;	
				}
			}
			if(!empty($whereBrand))
			{
				$where.= ' AND ('.implode(' OR ',$whereBrand).')';
			}
		}
		
		if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
		{
			$where.= ' AND (displayPrice >= '.$from_price.' AND displayPrice <= '.$to_price.')';
		}
		elseif((!empty($from_price))&&(is_numeric($from_price)))
		{
			$where.= ' AND (displayPrice >= '.$from_price.')';
		}
		elseif((!empty($to_price))&&(is_numeric($to_price)))
		{
			$where.= ' AND (displayPrice <= '.$to_price.')';
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$page_number			   = ($page_number*48);
		$total 		 			   = $this->product_m->total_product_temp_list($where);
		$this->data['list'] 	   = $this->product_m->product_temp_list($page_number,48,$where,$pSorting);
		$this->data['page_number'] = $page_number;
		
		$result = array(
					'total'     => $total,
					'totalPage' => ceil($total/48),
					'view'      => $this->load->view('product/brand_ajax_page_list',$this->data,true),
				);
		echo json_encode($result);		
	}
	
}