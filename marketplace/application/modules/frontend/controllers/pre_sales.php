<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Pre_sales extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		));
	}	
	
	public function product_list($gridList='grid')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list',
				'log_MID'    => '' 
		) );
		
		if($gridList!='grid')
		{
			$gridList = 'list';
		}
		
		$where        = '';
		$catArr		  = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$brandList	  = array();
		$sessionId = $this->session->userdata('session_id');
		$this->custom_log->write_log('custom_log','Session id is '.$sessionId);
		
		$productList   = $this->product_m->product_listing_pre_sales();
		//echo "<pre>"; print_r($productList); exit;
		$insertArr = array();
		if(!empty($productList))
		{
			$i = 0;
			foreach($productList as $row)
			{
				$productWeight = $row->weight+$row->shippingWeight;
				$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);	
				$displayPrice  = $priceArr['displayPrice'];
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
				$total++;
				$brandList[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
				$freeShipPrdId	= 0;
				$freeShipCatId  = 0;
				$freeShipPrdDet = $this->product_m->free_shipping_prd_details($row->productId);
				$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));				
				if(!empty($freeShipPrdDet))
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
									'organizationId'		=> $row->organizationId,
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
									'addFor'				=> 'Pre_sale',
									'lastModifiedBy'		=> $this->session->userdata('userId'),
									'lastModifiedDt'		=> date('Y-m-d H:i:s'),
								);
			}
		}
		
		$this->product_m->delete_old_pre_sale_product_list($sessionId);
		if((!empty($insertArr))&&(count($insertArr)))
		{
			$this->product_m->add_temp_product_listing($insertArr);
		}
		
		$this->data['catArr']      = $catArr;
		$this->data['minPrice']    = $minPrice;
		$this->data['maxPrice']    = $maxPrice;
		$this->data['brandList']   = $brandList;
		$this->data['total']       = $total;
		$this->data['gridList']    = $gridList;
		$this->data['title'] 	   = 'Pre-Order';
		$this->frontendCustomView('pre_sales/product_list',$this->data);
	}
	
	public function product_list_ajax()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list_ajax',
				'log_MID'    => '' 
		) );
		
		$gridList	  = $this->input->post('gridList');
		$from_price   = $this->input->post('from_price');
		$to_price     = $this->input->post('to_price');
		$brandArr     = $this->input->post('brandArr');
		$catArr       = $this->input->post('catArr');
		$page_number  = $this->input->post('page');
		$pSorting     = $this->input->post('pSorting');
		$brandListArr = array();
		$where 		  = '';
	
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
				$where.= '('.implode(' OR ',$whereCond).')';
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
				if(!empty($where))
				{
					$where.= ' AND ('.implode(' OR ',$whereBrand).')';
				}
				else
				{
					$where.= '('.implode(' OR ',$whereBrand).')';
				}
			}
		}
		
		if(((!empty($from_price))&&(is_numeric($from_price)))&&((!empty($to_price))&&(is_numeric($to_price))))
		{
			if(!empty($where))
			{
				$where.= ' AND (displayPrice >= '.$from_price.' AND displayPrice <= '.$to_price.')';
			}
			else
			{
				$where.= '(displayPrice >= '.$from_price.' AND displayPrice <= '.$to_price.')';
			}
		}
		elseif((!empty($from_price))&&(is_numeric($from_price)))
		{
			if(!empty($where))
			{
				$where.= ' AND (displayPrice >= '.$from_price.')';
			}
			else
			{
				$where.= '(displayPrice >= '.$from_price.')';
			}
		}
		elseif((!empty($to_price))&&(is_numeric($to_price)))
		{
			if(!empty($where))
			{
				$where.= ' AND (displayPrice <= '.$to_price.')';
			}
			else
			{
				$where.= '(displayPrice <= '.$to_price.')';
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$page_number			   = ($page_number*48);
		$total 		 			   = $this->product_m->total_pre_sales_product_list_temp($where);
		$this->data['list'] 	   = $this->product_m->pre_sales_product_list_temp($page_number,48,$where,$pSorting);
		$this->data['page_number'] = $page_number;
		
		$result = array(
					'total'     => $total,
					'totalPage' => ceil($total/48),
				 );
		if($gridList=='grid')
		{
			$result['view'] = $this->load->view('pre_sales/product_grid_ajax',$this->data,true);
		}
		else
		{
			$result['view'] = $this->load->view('pre_sales/product_list_ajax',$this->data,true);
		}
		echo json_encode($result);		
	}
}