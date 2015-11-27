<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Seller extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
	}	
	
	public function seller_detail($seller_id)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'seller_detail',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Seller Detail';
		$seller_id           = id_decrypt($seller_id);
		$this->custom_log->write_log('custom_log','Seller id is '.$seller_id);
		
		if(!empty($seller_id))
		{
			$retailer_detail = $this->user_m->user_details($seller_id);
			$this->custom_log->write_log('custom_log','Retialer details is '.print_r($retailer_detail,true));
			
			if((empty($retailer_detail))||(count($retailer_detail)<1))
			{
				$this->session->set_flashdata('error',$this->lang->line('error_invalid_seller'));
				redirect(base_url());
			}
			
			$retailer_rating_count = $this->retailer_m->retailer_rating_count($seller_id);
			$this->custom_log->write_log('custom_log','Retialer reting count details is '.print_r($retailer_rating_count,true));
			$total = $this->retailer_m->total_retailer_rating_review($seller_id);
			$this->custom_log->write_log('custom_log','total Retialer reting review is '.$total);
			
			$this->data['user_id']         		 = $this->session->userdata('userId');
			$this->data['retailer_detail'] 		 = $retailer_detail;
			$this->data['seller_id']       		 = $seller_id;
			$this->data['total']           		 = $total;
			$this->data['check']           		 = $this->retailer_m->total_customer_add_retailer_review($seller_id);
			$this->data['retailer_rating_count'] = $retailer_rating_count;
			$this->frontendCustomView('seller/retailer_detail',$this->data);
		}
	}
	
	public function seller_review_ajax($seller_id,$total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'seller_review_ajax',
				'log_MID'    => '' 
		) );
				
		$pagConfig = array(
		   				'base_url'    => base_url().'frontend/seller/seller_review_ajax/'.$seller_id.'/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 6,
		                'num_links'   => 4,
						'num_tag_open'   => '<li>',
					  	'num_tag_close'  => '</li>',
						'cur_tag_open'   => '<li class="active"><a >',
					    'cur_tag_close'  => '</a></li>',
					    'next_tag_open'  => '<li>',
					    'next_tag_close' => '</li>',
					    'prev_tag_open'  => '<li>',
					    'prev_tag_close' => '</li>',
						'next_link'		 => '&raquo;',
						'prev_link'      => '&laquo;'
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		
		$this->data["links"]         = $this->ajax_pagination->create_links();
		$this->data['page']          = $page;
		$this->data['rating_review'] = $this->retailer_m->retailer_rating_review($seller_id,$page,$pagConfig['per_page']);
		$this->load->view('seller/seller_review_ajax',$this->data);
	}
	
	public function seller_rating($seller_id)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'seller_rating',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Seller Rating';
		$seller_id           = id_decrypt($seller_id);
		$this->custom_log->write_log('custom_log','Seller id is '.$seller_id);
		
		$checkOrder = $this->order_m->purchase_product_with_retailer($seller_id);
		if((empty($checkOrder))||($checkOrder==0))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_please_purchase_product_from_retailer'));
			$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('error_please_purchase_product_from_retailer'));
			redirect(base_url().'frontend/seller/seller_detail/'.id_encrypt($seller_id));
		}
		
		$check = $this->retailer_m->total_customer_add_retailer_review($seller_id);
		if($check>0)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_already_add_rating_review'));
			$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('error_already_add_rating_review'));
			redirect(base_url().'frontend/seller/seller_detail/'.id_encrypt($seller_id));
		}
		
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','form submit is '.print_r($_POST,true));
			
			$rules = rating_review_feedback();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$rating  = $this->input->post('rating');	
				$comment = $this->input->post('comment');	
				$retailerRatingID = $this->retailer_m->add_rating_and_review($seller_id,$rating,$comment);
				$this->custom_log->write_log('custom_log','retailer and rating review id is '.$retailerRatingID);
				
				if($retailerRatingID)
				{
					$rating1 = 0;
					$rating2 = 0;
					$rating3 = 0;
					$rating4 = 0;
					$rating5 = 0;
					if($rating==1)
					{
						$rating1 = 1;
					}
					elseif($rating==2)
					{
						$rating2 = 1;
					}
					elseif($rating==3)
					{
						$rating3 = 1;
					}
					elseif($rating==4)
					{
						$rating4 = 1;
					}
					elseif($rating==5)
					{
						$rating5 = 1;
					}
					
					$check = $this->retailer_m->check_rating_review_retailer($seller_id);
					$this->custom_log->write_log('custom_log','check rating review retailer is '.print_r($check,true));
					
					if(!empty($check))
					{
						$rating1 = $check->ratailer_rating_1+$rating1;
						$rating2 = $check->ratailer_rating_2+$rating2;
						$rating3 = $check->ratailer_rating_3+$rating3;
						$rating4 = $check->ratailer_rating_4+$rating4;
						$rating5 = $check->ratailer_rating_5+$rating5;
						$this->retailer_m->update_rating_review_retailer($seller_id,$rating1,$rating2,$rating3,$rating4,$rating5);
						$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
					}
					else
					{
						$new_id = $this->retailer_m->add_rating_review_retailer($seller_id,$rating1,$rating2,$rating3,$rating4,$rating5);
						$this->custom_log->write_log('custom_log','new genrated id is '.$new_id);
					}
					$this->session->set_flashdata('success',$this->lang->line('success_add_rating_review'));
					$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('success_add_rating_review'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_add_rating_review'));
					$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('error_add_rating_review'));
				}
				redirect(base_url().'frontend/seller/seller_detail/'.id_encrypt($seller_id));
			}
		}
		$this->frontendCustomView('seller/seller_rating',$this->data);	
	}
	public function seller_product($sellerId)
	{	
	
	$this->session->set_userdata(array(
				'log_MODULE' => 'seller_review_ajax',
				'log_MID'    => '' 
		) );
			$productList  = array();
		$catArr		  = array();
		$brandListArr    = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$brandArr =array();
		$sellerId=id_decrypt($sellerId);
		$this->data['organizationName']='';
		$where ="organization_product.organizationId = ".$sellerId;
		$details=$this->product_m->product_listing_according_categry('','',$where);
		$total=0;
		$i = 0;
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
					$productList[$row->productId]['productId']    = $row->productId;
					
					$productList[$row->productId]['productName']  = $productName;
					
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->adminPrice;
					$productList[$row->productId]['imageName']    = $row->mainImage;
					$productList[$row->productId]['organizationName'] = $row->organizationName;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					$productList[$row->productId]['freeShipPrdId'] = 0;
					$productList[$row->productId]['freeShipCatId'] = 0;
					$this->data['organizationName']= $row->organizationName;
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
						//$total++;
					
				}
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
					
					
					$brandListArr[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
			}
			
		}
		$this->data['sellerId']=id_encrypt($sellerId);
		$this->data['catArr']=$catArr;
		$this->data['brandList']=$brandListArr;
		$this->data['minPrice']=$minPrice;
		$this->data['maxPrice']=$maxPrice;
		$this->data['title']='Seller Product Detail';
		$this->data['total']=count($productList);
		$this->data['totalProducts']=count($productList);
		
			$this->data['page_number']  = count($productList);
		$this->data['brandListArr'] = $brandListArr;
		$this->data['list']	=$productList;
		$this->frontendCustomView('seller/product_list_grid',$this->data);
		
	}
	public function seller_product_list($sellerId)
	{	
	
	$this->session->set_userdata(array(
				'log_MODULE' => 'seller_review_ajax',
				'log_MID'    => '' 
		) );
			$productList  = array();
		$catArr		  = array();
		$brandListArr    = array();
		$total		  = 0;
		$minPrice     = 0;
		$maxPrice     = 0;
		$brandArr =array();
		$sellerId=id_decrypt($sellerId);
		$this->data['organizationName']='';
		$where ="organization_product.organizationId = ".$sellerId;
		$details=$this->product_m->product_listing_according_categry('','',$where);
		$total=0;
		$i = 0;
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
					$productList[$row->productId]['productId']    = $row->productId;
					
					$productList[$row->productId]['productName']  = $productName;
					
					$productList[$row->productId]['currentPrice'] = $displayPrice;
					$productList[$row->productId]['adminPrice']   = $row->adminPrice;
					$productList[$row->productId]['imageName']    = $row->mainImage;
					$productList[$row->productId]['organizationName'] = $row->organizationName;
					$productList[$row->productId]['cashAdminFee'] = $priceArr['cashAdminFee'];
					$productList[$row->productId]['freeShipPrdId'] = 0;
					$productList[$row->productId]['freeShipCatId'] = 0;
					$this->data['organizationName']= $row->organizationName;
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
						//$total++;
					
				}
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
					
					
					$brandListArr[$row->brandId] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($row->brandName,ENT_QUOTES));
			}
			
		}
		$this->data['sellerId']=id_encrypt($sellerId);
		$this->data['catArr']=$catArr;
		$this->data['brandList']=$brandListArr;
		$this->data['minPrice']=$minPrice;
		$this->data['maxPrice']=$maxPrice;
		$this->data['title']='Seller Product Detail';
		$this->data['total']=count($productList);
		$this->data['totalProducts']=count($productList);
		
			$this->data['page_number']  = count($productList);
		$this->data['brandListArr'] = $brandListArr;
		$this->data['list']	=$productList;
		$this->frontendCustomView('seller/product_list_list',$this->data);
		
	}
	public function ajaxFunGrid()
	{
		$from_price   = $this->input->post('from_price');
		$to_price     = $this->input->post('to_price');
		$brandArr     = $this->input->post('brandArr');
		$catArr       = $this->input->post('catArr');
		$page_number  = $this->input->post('page');
		$pSorting     = $this->input->post('pSorting');
		$sellerId	  = $this->input->post('sellerId');
		$sellerId=id_decrypt($sellerId);
		$productList='';
		$brandListArr='';
		$totalData=array();
		$where[]="organization_product.organizationId = ".$sellerId;
		if(!empty($catArr)){
			$catImplo=implode($catArr,',');
			$where[]= 'product_category.categoryId IN ('.$catImplo.')';
		}
		if(!empty($where))
		{
			$where =implode($where ,' and ');
		}
	
		$details=$this->product_m->product_listing_according_categry('','',$where);
		
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
					'view'      => $this->load->view('seller/ajax_page_grid',$this->data,true),
				);
		echo json_encode($result);		
		
		
	}
	
	public function ajaxFunList()
	{
			$from_price   = $this->input->post('from_price');
		$to_price     = $this->input->post('to_price');
		$brandArr     = $this->input->post('brandArr');
		$catArr       = $this->input->post('catArr');
		$page_number  = $this->input->post('page');
		$pSorting     = $this->input->post('pSorting');
		$sellerId	  = $this->input->post('sellerId');
		$sellerId=id_decrypt($sellerId);
		$productList='';
		$brandListArr='';
		$totalData=array();
		$where[]="organization_product.organizationId = ".$sellerId;
		if(!empty($catArr)){
			$catImplo=implode($catArr,',');
			$where[]= 'product_category.categoryId IN ('.$catImplo.')';
		}
		if(!empty($where))
		{
			$where =implode($where ,' and ');
		}
	
		$details=$this->product_m->product_listing_according_categry('','',$where);
		
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
		
		$this->data['list']         = $productList;
		$this->data['page_number']  = $page_number;
		$this->data['brandListArr'] = $brandListArr;
					$result = array(
					'total'     => count($totalData),
					'totalPage' => ceil(count($totalData)/48),
					'view'      => $this->load->view('seller/ajax_page_list',$this->data,true)
				  );
		echo json_encode($result);	
	}
	
}
