<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Exclusives extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
	}	
	
	//$categoryId  = 879;	// live 
	public function product_list_grid($categoryId=48345)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list_grid',
				'log_MID'    => '' 
		));
		
		$this->data['title'] = 'Product Listing';
			
		$catArr		   = array();
		$brandList     = array();
		$total		   = 0;
		$where 	  	   = '';
		$minPrice      = 0;
		$maxPrice      = 0;
		$productList = array();
		$categoryId  = id_decrypt($categoryId);
		$catArrList  = $this->segment_cat_m->category_level($categoryId);
		//echo "<pre>"; print_r($catArrList); exit;
		$catName = '';
		if(!empty($catArrList))
		{
			foreach($catArrList as $key=>$val)
			{
				$catName = $val->level1Name;
				if($val->level1ID==$categoryId)
				{
					$categoryName = $val->level1Name;
					$childCatIdArr[$val->level1ID] = $val->level1ID;
					$childCatIdArr[$val->level2ID] = $val->level2ID;
					$childCatIdArr[$val->level3ID] = $val->level3ID;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level2ID==$categoryId)
				{
					$categoryName = $val->level2Name;
					$childCatIdArr[$val->level2ID] = $val->level2ID;
					$childCatIdArr[$val->level3ID] = $val->level3ID;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level3ID==$categoryId)
				{
					$categoryName = $val->level3Name;
					$childCatIdArr[$val->level3ID] = $val->level3ID;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level4ID==$categoryId)
				{
					$categoryName = $val->level4Name;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level5ID==$categoryId)
				{
						$categoryName = $val->level5Name;
						$childCatIdArr[$val->level5ID] = $val->level5ID;
						$childCatIdArr[$val->level6ID] = $val->level6ID;
						$childCatIdArr[$val->level7ID] = $val->level7ID;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level6ID==$categoryId)
				{
						$categoryName = $val->leve6Name;
						$childCatIdArr[$val->level6ID] = $val->level6ID;
						$childCatIdArr[$val->level7ID] = $val->level7ID;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level7ID==$categoryId)
				{
						$categoryName = $val->level7Name;
						$childCatIdArr[$val->level7ID] = $val->level7ID;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level8ID==$categoryId)
				{
						$categoryName = $val->level8Name;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level9ID==$categoryId)
				{
						$categoryName = $val->level9Name;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level10ID==$categoryId)
				{
						$categoryName = $val->level10Name;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
			}
		}
		if(!empty($childCatIdArr))
		{
			$whereCond = array();
			foreach($childCatIdArr as $value)
			{
				if(!empty($value))
				{
					$whereCond[] = 'marketing_product_category.categoryId = '.$value;	
					$categoryIdArr[$value] = $value;
				}
			}
			if(!empty($whereCond))
			{
				$where = '('.implode(' OR ',$whereCond).')';
			}
		}
	
		if(!empty($catArrList))
		{
			$details = $this->product_marketing_m->exclusives_product_listing('','',$where);
			//echo $this->db->last_query();
			//echo "<pre>"; print_r($details); exit;
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
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $row->code;
					$productList[$row->productId]['currentPrice'] = $row->currentPrice;
					$productList[$row->productId]['costPrice']    = $row->costPrice;
					$productList[$row->productId]['imageName']    = $row->imageName;
					$total++;
					if(!empty($catArr[$row->categoryId]))
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->categoryCode,ENT_QUOTES));
						$catArr[$row->categoryId]['totalProducts'] = $catArr[$row->categoryId]['totalProducts']+1;
					}
					else
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->categoryCode,ENT_QUOTES));
						$catArr[$row->categoryId]['totalProducts'] = 1;
					}
					
					if($i==0)
					{
						$minPrice = $row->marketingPrice;
					}
					$maxPrice = $row->marketingPrice;
					$i++;
					
					$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
				}
			}
		}
		}
		$this->data['catName']       = $catName;
		$this->data['catArr']       = $catArr;
		$this->data['minPrice']     = $minPrice;
		$this->data['maxPrice']     = $maxPrice;
		$this->data['brandList']    = $brandList;
		$this->data['total']        = $total;
		$this->data['search']		= '';
		$this->data['productList']  = $productList;
		$this->data['title'] 		 = $catName;
		$this->frontendCustomView('product/excluslive_product_list_grid',$this->data);
	}
	
	public function ajaxFunGrid($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFunGrid',
				'log_MID'    => '' 
		) );
		
		$from_price  = $this->input->post('from_price');
		$to_price    = $this->input->post('to_price');
		$brandArr    = $this->input->post('brandArr');
		$catList     = json_decode($this->input->post('catList'),true);
		$catArr      = $this->input->post('catArr');
		$page_number = $this->input->post('page');
		$pSorting    = $this->input->post('pSorting');	
		$productList = '';	
		$where = '';
		$totalData = 0;
		if(!empty($catList))
		{
			$whereCond = array();
			foreach($catList as $key=>$value)
			{
				$whereCond[] = 'product_category.categoryId = '.$key;	
			}
			if(!empty($whereCond))
			{
				$where = '('.implode(' OR ',$whereCond).')';
			}
		
		
			if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
			{
				if(!empty($where))
				{
					$where.= " AND ";
				}
				$where.= "(marketing_product.currentPrice >= ".$from_price." AND marketing_product.currentPrice <= ".$to_price.")";
			}
			elseif((!empty($from_price))&&(is_numeric($from_price)))
			{
				if(!empty($where))
				{
					$where.= " AND ";
				}
				$where.= "marketing_product.currentPrice >= ".$from_price;
			}
			elseif((!empty($to_price))&&(is_numeric($to_price)))
			{
				if(!empty($where))
				{
					$where.= " AND ";
				}
				$where.= "marketing_product.currentPrice <= ".$to_price;
			}
					
			$whereBrand = array();
			if(!empty($brandArr))
			{
				foreach($brandArr as $value)
				{
					$whereBrand[] = 'brand.brandId = '.$value;	
				}
				if(!empty($where))
				{
					$where.= " AND ";
				}
				if(!empty($whereBrand))
				{
					$where.= '('.implode(' OR ',$whereBrand).')';
				}
			}
			
			if(!empty($catArr))
			{
				$whereCat = array();
				foreach($catArr as $key=>$value)
				{
					$whereCat[] = 'product_category.categoryId = '.$value;	
				}
				if(!empty($whereCond))
				{
					$where.= ' AND ('.implode(' OR ',$whereCat).')'; 
				}
			}
		
			$productList = array();
			$page_number = ($page_number*12);
			$totalData   = $this->product_marketing_m->exclusives_product_listing('','',$where);	
			$details     = $this->product_marketing_m->exclusives_product_listing($page_number,12,$where,$pSorting);	
			if(!empty($details))
			{
				foreach($details as $row)
				{
					if(!empty($productList[$row->productId]))
					{
						if(!empty($row->marketingPrice))
						{
							$productList[$row->productId]['adminPrice'] = $row->marketingPrice;
						}
					}
					else
					{
						$productWeight = $row->weight+$row->shippingWeight;
						$productId     = $row->productId;
						$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);
						$displayPrice  = $priceArr['displayPrice'];
						$productName   = $row->code;
						if(strlen($row->code)>63)
						{
							$productName = substr($row->code,0,63).'...';
						}
						
						$productList[$row->productId]['productId']    = $row->productId;
						$productList[$row->productId]['productName']  = $productName;
						$productList[$row->productId]['currentPrice'] = $displayPrice;
						$productList[$row->productId]['adminPrice']   = $row->marketingPrice;
						$productList[$row->productId]['imageName']    = $row->imageName;
						$productList[$row->productId]['organizationName'] = $row->organizationName;
						$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
						$productList[$row->productId]['freeShipPrdId'] = 0;
						$productList[$row->productId]['freeShipCatId'] = 0;
						
						$productList[$row->productId]['totalRating'] = $row->totalProductRating;
						$productList[$row->productId]['avgRating']   = $row->avgProductRating;
						
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
					}
				}
			}
		}
		
		$this->data['list'] = $productList;
		$this->data['page_number'] = $page_number;
		$result = array(
					'total' => count($totalData),
					'totalPage' => ceil(count($totalData)/12),
					'view'  => $this->load->view('product/exclusive_ajax_page_grid',$this->data,true)
				);
		echo json_encode($result);
	}
	
	public function product_list_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list_grid',
				'log_MID'    => '' 
		));
		
		$this->data['title'] = 'Product Listing';
		
		$catArr		   = array();
		$brandList     = array();
		$total		   = 0;
		$where 	  	   = '';
		$minPrice      = 0;
		$maxPrice      = 0;
		$productList = array();
		$categoryId  = 879;	// live 
		//$categoryId  = 750;  // 62
		$catArrList  = $this->segment_cat_m->category_level($categoryId);
		//echo "<pre>"; print_r($catArrList); exit;
		$catName = '';
		if(!empty($catArrList))
		{
			foreach($catArrList as $key=>$val)
			{
				$catName = $val->level1Name;
				if($val->level1ID==$categoryId)
				{
					$categoryName = $val->level1Name;
					$childCatIdArr[$val->level1ID] = $val->level1ID;
					$childCatIdArr[$val->level2ID] = $val->level2ID;
					$childCatIdArr[$val->level3ID] = $val->level3ID;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level2ID==$categoryId)
				{
					$categoryName = $val->level2Name;
					$childCatIdArr[$val->level2ID] = $val->level2ID;
					$childCatIdArr[$val->level3ID] = $val->level3ID;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level3ID==$categoryId)
				{
					$categoryName = $val->level3Name;
					$childCatIdArr[$val->level3ID] = $val->level3ID;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level4ID==$categoryId)
				{
					$categoryName = $val->level4Name;
					$childCatIdArr[$val->level4ID] = $val->level4ID;
					$childCatIdArr[$val->level5ID] = $val->level5ID;
					$childCatIdArr[$val->level6ID] = $val->level6ID;
					$childCatIdArr[$val->level7ID] = $val->level7ID;
					$childCatIdArr[$val->level8ID] = $val->level8ID;
					$childCatIdArr[$val->level9ID] = $val->level9ID;
					$childCatIdArr[$val->level10ID] = $val->level10ID;
				}
				elseif($val->level5ID==$categoryId)
				{
						$categoryName = $val->level5Name;
						$childCatIdArr[$val->level5ID] = $val->level5ID;
						$childCatIdArr[$val->level6ID] = $val->level6ID;
						$childCatIdArr[$val->level7ID] = $val->level7ID;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level6ID==$categoryId)
				{
						$categoryName = $val->leve6Name;
						$childCatIdArr[$val->level6ID] = $val->level6ID;
						$childCatIdArr[$val->level7ID] = $val->level7ID;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level7ID==$categoryId)
				{
						$categoryName = $val->level7Name;
						$childCatIdArr[$val->level7ID] = $val->level7ID;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level8ID==$categoryId)
				{
						$categoryName = $val->level8Name;
						$childCatIdArr[$val->level8ID] = $val->level8ID;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level9ID==$categoryId)
				{
						$categoryName = $val->level9Name;
						$childCatIdArr[$val->level9ID] = $val->level9ID;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
				elseif($val->level10ID==$categoryId)
				{
						$categoryName = $val->level10Name;
						$childCatIdArr[$val->level10ID] = $val->level10ID;
					}
			}
		}
		if(!empty($childCatIdArr))
		{
			$whereCond = array();
			foreach($childCatIdArr as $value)
			{
				if(!empty($value))
				{
					$whereCond[] = 'marketing_product_category.categoryId = '.$value;	
					$categoryIdArr[$value] = $value;
				}
			}
			if(!empty($whereCond))
			{
				$where = '('.implode(' OR ',$whereCond).')';
			}
		}
	
		if(!empty($catArrList))
		{
			$details = $this->product_marketing_m->exclusives_product_listing('','',$where);
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
					$productList[$row->productId]['productId']    = $row->productId;
					$productList[$row->productId]['productName']  = $row->code;
					$productList[$row->productId]['currentPrice'] = $row->currentPrice;
					$productList[$row->productId]['costPrice']    = $row->costPrice;
					$productList[$row->productId]['imageName']    = $row->imageName;
					$total++;
					if(!empty($catArr[$row->categoryId]))
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->categoryCode,ENT_QUOTES));
						$catArr[$row->categoryId]['totalProducts'] = $catArr[$row->categoryId]['totalProducts']+1;
					}
					else
					{
						$catArr[$row->categoryId]['categoryId']    = $row->categoryId;
						$catArr[$row->categoryId]['categoryCode']  = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->categoryCode,ENT_QUOTES));
						$catArr[$row->categoryId]['totalProducts'] = 1;
					}
					
					if($i==0)
					{
						$minPrice = $row->marketingPrice;
					}
					$maxPrice = $row->marketingPrice;
					$i++;
					
					$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
				}
			}
		}
		}
		$this->data['catName']       = $catName;
		$this->data['catArr']       = $catArr;
		$this->data['minPrice']     = $minPrice;
		$this->data['maxPrice']     = $maxPrice;
		$this->data['brandList']    = $brandList;
		$this->data['total']        = $total;
		$this->data['search']		= '';
		$this->data['productList']  = $productList;
		$this->data['title'] 		 = $catName;
		$this->frontendCustomView('product/excluslive_product_list_list',$this->data);
	}
	
	public function ajaxFunList($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFunGrid',
				'log_MID'    => '' 
		) );
		
		$from_price  = $this->input->post('from_price');
		$to_price    = $this->input->post('to_price');
		$brandArr    = $this->input->post('brandArr');
		$catList     = json_decode($this->input->post('catList'),true);
		$catArr      = $this->input->post('catArr');
		$page_number = $this->input->post('page');
		$pSorting    = $this->input->post('pSorting');	
		$productList = '';	
		$where = '';
		$totalData = 0;
		if(!empty($catList))
		{
			$whereCond = array();
			foreach($catList as $key=>$value)
			{
				$whereCond[] = 'product_category.categoryId = '.$key;	
			}
			if(!empty($whereCond))
			{
				$where = '('.implode(' OR ',$whereCond).')';
			}
		
		
			if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
			{
				if(!empty($where))
				{
					$where.= " AND ";
				}
				$where.= "(marketing_product.currentPrice >= ".$from_price." AND marketing_product.currentPrice <= ".$to_price.")";
			}
			elseif((!empty($from_price))&&(is_numeric($from_price)))
			{
				if(!empty($where))
				{
					$where.= " AND ";
				}
				$where.= "marketing_product.currentPrice >= ".$from_price;
			}
			elseif((!empty($to_price))&&(is_numeric($to_price)))
			{
				if(!empty($where))
				{
					$where.= " AND ";
				}
				$where.= "marketing_product.currentPrice <= ".$to_price;
			}
					
			$whereBrand = array();
			if(!empty($brandArr))
			{
				foreach($brandArr as $value)
				{
					$whereBrand[] = 'brand.brandId = '.$value;	
				}
				if(!empty($where))
				{
					$where.= " AND ";
				}
				if(!empty($whereBrand))
				{
					$where.= '('.implode(' OR ',$whereBrand).')';
				}
			}
			
			if(!empty($catArr))
			{
				$whereCat = array();
				foreach($catArr as $key=>$value)
				{
					$whereCat[] = 'product_category.categoryId = '.$value;	
				}
				if(!empty($whereCond))

				{
					$where.= ' AND ('.implode(' OR ',$whereCat).')'; 
				}
			}
		
			$productList = array();
			$page_number = ($page_number*12);
			$totalData   = $this->product_marketing_m->exclusives_product_listing('','',$where);	
			$details     = $this->product_marketing_m->exclusives_product_listing($page_number,12,$where,$pSorting);	
			if(!empty($details))
			{
				foreach($details as $row)
				{
					if(!empty($productList[$row->productId]))
					{
						if(!empty($row->marketingPrice))
						{
							$productList[$row->productId]['adminPrice'] = $row->marketingPrice;
						}
					}
					else
					{
						$productWeight = $row->weight+$row->shippingWeight;
						$productId     = $row->productId;
						$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
						$displayPrice  = $priceArr['displayPrice'];
						
						$productName   = $row->code;
						if(strlen($row->code)>63)
						{
							$productName = substr($row->code,0,63).'...';
						}
						
						$productList[$row->productId]['productId']    = $row->productId;
						$productList[$row->productId]['productName']  = $productName;
						$productList[$row->productId]['currentPrice'] = $displayPrice;
						$productList[$row->productId]['adminPrice']   = $row->marketingPrice;
						$productList[$row->productId]['imageName']    = $row->imageName;
						$productList[$row->productId]['organizationName'] = $row->organizationName;							
						$productList[$row->productId]['cashAdminFee']  = $priceArr['cashAdminFee'];
						$productList[$row->productId]['freeShipPrdId'] = 0;
						$productList[$row->productId]['freeShipCatId'] = 0;
						
						$productList[$row->productId]['totalRating'] = $row->totalProductRating;
						$productList[$row->productId]['avgRating']   = $row->avgProductRating;
						
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
					}
				}
			}
		}
		
		$this->data['list'] = $productList;
		$this->data['page_number'] = $page_number;
		$result = array(
					'total' => count($totalData),
					'totalPage' => ceil(count($totalData)/12),
					'view'  => $this->load->view('product/exclusive_ajax_page_list',$this->data,true)
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
	}	
}