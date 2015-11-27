<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Single extends MY_Controller {

        public function __construct() {

            parent::__construct ();
            // logger
            $this->session->set_userdata ( array (
                'log_FILE' => ''
            ) );
            $this->load->library('cart');
            $this->load->model('cart_m');
            $this->load->model('single_product_m');
            $this->load->model('product_m');
			$this->load->model('rating_review_m');
        }

        public function product_detail($productId='',$colorId=0,$sizeId=0,$organizationColorSizeId=0)
        {
            $this->session->set_userdata(array(
                'log_MODULE' => 'product_detail',
                'log_MID'    => ''
            ));

            $productId           	  = id_decrypt($productId);
            $colorId             	  = id_decrypt($colorId);
            $sizeId				 	  = id_decrypt($sizeId);
			$organizationColorSizeId  = id_decrypt($organizationColorSizeId);
            $product_color      	  = '';
            $colors              	  = '';
            $sizes		         	  = array();
            $organizationName    	  = '';
            $productPrice        	  = 0;
            $marketingPrice      	  = 0;
			$marketingProductId    	  = 0;
			$organizationProductId 	  = 0;
            $organizationProductIdArr = array();
            $this->custom_log->write_log('custom_log','Product id is '.$productId);
			
			
			$product_detail  = $this->product_m->single_product_with_retailer_detail($productId);
            //echo "<pre>"; print_r($product_detail); exit;
			$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());

            if(!empty($product_detail))
            {
                $this->data['product_images'] = $this->product_m->product_images($productId);
                $this->data['attributes']     = $this->product_m->product_attributes_details($productId);

                $this->data['attrbuteSINGLE'] = '';
                if(!empty($this->data['attributes']))
                {
                    if($this->data['attributes'][0]->productTypeId==2)
                    {
                        $this->data['attributes']     = '';
                        $this->data['attrbuteSINGLE'] = $this->product_m->admin_product_attributes_details($productId);
                    }
                }

                //$productColorSize = $this->product_m->get_product_all_color_and_size($productId);
                //$productColorSize = $this->product_m->product_seller_list_with_color_or_size($productId);
				$productColorSize = $this->product_m->product_seller_list_with_color_or_size_change($productId);
                $this->organization_product_view_count($product_detail->organizationProductId);
				//echo "<pre>"; print_r($productColorSize); exit;
				$freeShipPrdId = 0;
				$freeShipCatId = 0;
				$cashAdminFee  = 0;
				
				$freeShipPrdDet = $this->product_m->free_shipping_prd_details($productId);
				$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));
				if(!empty($freeShipPrdDet))
				{
					$freeShipPrdId = $freeShipPrdDet->freeShipPrdId;
				}
				else
				{
					$prdCatLst = $this->segment_cat_m->category_parent_list($productColorSize[0]->categoryId);
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
				
                //echo "<pre>"; print_r($productColorSize); exit;
                if(isset($productColorSize)&& !empty($productColorSize))
                {
                    $flag = true;
                    foreach($productColorSize as $colorsize)
                    {
						$organizationColorsSizes = $this->product_m->organization_color_size_details($colorsize->organizationProductId);
						//echo "<pre>"; print_r($organizationColorsSizes); exit;
						if(!empty($organizationColorsSizes))
						{
							foreach($organizationColorsSizes as $row)
							{
								if((!empty($row->colorId))&&($row->colorId))
								{
									$organizationProductIdArr[$colorsize->organizationProductId]['colors'][$row->colorId]['size'][$row->productSizeId] = $row->sizes;
									
									$product_color[$row->colorId][$row->productSizeId] = $row->sizes;
									$colors[$row->colorId]['colorCode'] 			   = $row->colorCode;
									$colors[$row->colorId]['organizationColorSizeId']  = $row->organizationColorSizeId;
									$organizationProductIdArr[$colorsize->organizationProductId]['colors'][$row->colorId]['colorCode'] = $row->colorCode;
									$organizationProductIdArr[$colorsize->organizationProductId]['productColor'][$row->colorId] = $row->colorId;
								}
								
								if((!empty($row->productSizeId))&&($row->productSizeId)&&(!empty($row->sizes)))
								{
									$sizes[$row->productSizeId]['size']					   = $row->sizes;
									$sizes[$row->productSizeId]['organizationColorSizeId'] = $row->organizationColorSizeId;
									
									$organizationProductIdArr[$colorsize->organizationProductId]['productSize'][$row->productSizeId] = $row->sizes;
								}
								
							}
						}
						
                        $productWeight    = $colorsize->weight+$colorsize->shippingWeight;
						$displayPriceArr  = $this->product_lib->show_product_price_array($colorsize->organizationProductId);
						$displayPrice	  = $displayPriceArr['displayPrice'];
                        $marketingColorId = trim($colorsize->marketingColorId);
                        $marketingSize    = trim($colorsize->marketingSize);
						if($marketingSize)
						{
							$marketingSize = strtolower($marketingSize);
						}
                        $marketingStock   = $colorsize->marketingStock;
                        $productSize      = trim($colorsize->sizes);
						$colorSizeIndex   = $colorsize->productSizeId;
                        if($flag)
                        {
                            if(($marketingColorId==$colorId) && ($marketingSize==strtolower($productSize)) && !empty($marketingColorId) && !empty($marketingSize) )
                            {
                                $organizationName = $colorsize->organizationName;
                                $productPrice     = $displayPrice;
								$cashAdminFee     = $displayPriceArr['cashAdminFee'];
								$marketingProductId = $colorsize->marketingProductId;
								$organizationProductId = $colorsize->organizationProductId;										
                                if(!empty($marketingStock) ){
                                    $marketingPrice   = $colorsize->adminPrice;
                                }
                                //  echo 1;
                                $flag = false;
                            }
                            elseif($marketingColorId==$colorId  && !empty($marketingColorId) && empty($sizeId) )
                            {
                                $organizationName = $colorsize->organizationName;
                                $productPrice     = $displayPrice;
								$cashAdminFee     = $displayPriceArr['cashAdminFee'];
								$marketingProductId = $colorsize->marketingProductId;
								$organizationProductId = $colorsize->organizationProductId;										
                                if(!empty($marketingStock)){
                                    $marketingPrice   = $colorsize->adminPrice;
                                }
                                $flag = false;
                                //echo 2;
                            }
                            elseif($marketingSize==strtolower($productSize)  && !empty($marketingSize) && empty($colorId))
                            {
                                $organizationName = $colorsize->organizationName;
                                $productPrice     = $displayPrice;
								$cashAdminFee     = $displayPriceArr['cashAdminFee'];
                                $marketingProductId = $colorsize->marketingProductId;
								$organizationProductId = $colorsize->organizationProductId;										
								if(!empty($marketingStock) )
								{
                                    $marketingPrice   = $colorsize->adminPrice;
                                }
                                $flag = false;
                                //	echo 3;

                            }
                            elseif((!empty($colorId))&&(!empty($sizeId)))
                            {
                                if(($colorsize->colorId==$colorId)&&(!empty($colorSizeIndex))&&($colorSizeIndex==$sizeId))
                                {
                                    $organizationName = $colorsize->organizationName;
                                    $productPrice     = $displayPrice;
									$cashAdminFee     = $displayPriceArr['cashAdminFee'];
									$marketingProductId = $colorsize->marketingProductId;
									$organizationProductId = $colorsize->organizationProductId;
								}
                                //	echo 4;
                            }
                            elseif(!empty($colorId))
                            {
                                if($colorsize->colorId==$colorId)
                                {
                                    $organizationName = $colorsize->organizationName;
                                    $productPrice     = $displayPrice;
                                    $marketingPrice   = $colorsize->adminPrice;
									$cashAdminFee     = $displayPriceArr['cashAdminFee'];
									$marketingProductId = $colorsize->marketingProductId;
									$organizationProductId = $colorsize->organizationProductId;
                                }
                                //echo 5;
                            }
                            elseif(!empty($sizeId))
                            {
                                if($colorSizeIndex==$sizeId)
                                {
                                    $organizationName = $colorsize->organizationName;
                                    $productPrice     = $displayPrice;
									$cashAdminFee     = $displayPriceArr['cashAdminFee'];
									$marketingProductId = $colorsize->marketingProductId;
									$organizationProductId = $colorsize->organizationProductId;										
                                    //	echo 6;
                                }
                            }
                            else
                            {
                                if( (!empty($marketingColorId)) OR (!empty($marketingSize)) ){
                                    $organizationName = $colorsize->organizationName;
                                    $productPrice     = $displayPrice;
                                    $marketingPrice   = $colorsize->adminPrice;
									$cashAdminFee     = $displayPriceArr['cashAdminFee'];
									$marketingProductId = $colorsize->marketingProductId;
									$organizationProductId = $colorsize->organizationProductId;
										
								}
                                else
                                {
                                    if(($marketingPrice > $displayPrice) OR empty($marketingPrice))
									{
                                        $organizationName = $colorsize->organizationName;
										$productPrice     = $displayPrice;
										$marketingPrice   = $colorsize->adminPrice;
										$cashAdminFee     = $displayPriceArr['cashAdminFee'];
										$marketingProductId = $colorsize->marketingProductId;
										$organizationProductId = $colorsize->organizationProductId;
                                    }
								}
							}
                        }
                        $organizationProductIdArr[$colorsize->organizationProductId]['organizationId']   = $colorsize->organizationId;
                        $organizationProductIdArr[$colorsize->organizationProductId]['productId']        = $colorsize->productId;
                        $organizationProductIdArr[$colorsize->organizationProductId]['currentPrice']     = $displayPrice;
                        $organizationProductIdArr[$colorsize->organizationProductId]['currentQty']       = $colorsize->currentQty;
                        $organizationProductIdArr[$colorsize->organizationProductId]['organizationName'] = $colorsize->organizationName;
                        $organizationProductIdArr[$colorsize->organizationProductId]['marketingPrice']   = $colorsize->adminPrice;
						$organizationProductIdArr[$colorsize->organizationProductId]['marketingProductId'] = $colorsize->marketingProductId;		
                    }
                }
                
                if(!empty($colorId))
                {
                    //$sizes = array();
                    if(!empty($product_color[$colorId]))
                    {
                      //  $sizes = $product_color[$colorId];
                    }
                }
				//echo "<pre>"; print_r($product_color); exit;
				//echo "<pre>"; print_r($organizationProductIdArr); exit;
                $this->data['productColorSize'] 		= $productColorSize;
                $this->data['product_color']    		= $product_color;
                $this->data['colors']           		= $colors;
                $this->data['sizes']            		= $sizes;
                $this->data['colorId']          		= $colorId;
                $this->data['sizeId']           		= $sizeId;
                $this->data['organizationProductIdArr'] = $organizationProductIdArr;
                $this->data['productId']         		= $productId;
                $this->data['product_detail']    		= $product_detail;
                $this->data['organizationName']  		= $organizationName;
                $this->data['productPrice']     		= $productPrice;
                $this->data['marketingPrice']    = $marketingPrice;
				$this->data['cashAdminFee']      = $cashAdminFee;
				$this->data['freeShipPrdId']     = $freeShipPrdId;
				$this->data['freeShipCatId']     = $freeShipCatId;
				$this->data['discountPer']		 = 0;
				if($marketingPrice)
				{
	                $this->data['discountPer'] = 100-(($marketingPrice/$productPrice)*100);
				}
				
				$this->data['productRating'] 		  = $this->rating_review_m->check_rating_product($productId);
				$this->data['productRatingReviewLst'] = $this->rating_review_m->top10_rating_review_list($productId);
				//echo "<pre>"; print_r($this->data['productRatingReviewLst']); exit;
				
				$this->data['marketingProductId']    = $marketingProductId;
				$this->data['organizationProductId'] = $organizationProductId;
				
				$this->data['organizationColorSizeId'] = $organizationColorSizeId;
				
				$this->data['title'] = $product_detail->code;
                $this->frontendCustomView('single/single',$this->data);
            }
            else
            {
                $this->session->set_flashdata('error','Organization proudct details not found');
                redirect(base_url());
            }
        }

        public function add_wish_list($product_id)
        {
            $this->session->set_userdata(array(
                'log_MODULE' => 'add_wish_list',
                'log_MID'    => ''
            ) );

            $product_id = id_decrypt($product_id);
            $user_id	= $this->session->userdata('userId');
            $this->custom_log->write_log('custom_log','product id is '.$product_id.' and user id is '.$user_id);
            if((!empty($user_id))&&($product_id))
            {
                $total = $this->product_m->total_wish_list_user($product_id,$user_id);
                if(!empty($total))
                {
                    $this->session->set_flashdata('error',$this->lang->line('error_already_add_wish_list'));
                    $this->custom_log->write_log('custom_log',$this->lang->line('error_already_add_wish_list'));
                }
                else
                {
                    $wishlistId = $this->product_m->add_wish_list($product_id);
                    if($wishlistId)
                    {
                        $this->session->set_flashdata('success',$this->lang->line('success_add_wish_list'));
                        $this->custom_log->write_log('custom_log',$this->lang->line('success_add_wish_list'));
                    }
                    else
                    {
                        $this->session->set_flashdata('error',$this->lang->line('error_add_wish_list'));
                        $this->custom_log->write_log('custom_log',$this->lang->line('error_add_wish_list'));
                    }
                }
                redirect(base_url().'frontend/single/product_detail/'.id_encrypt($product_id));
            }
            else
            {
                $this->session->set_flashdata('error',$this->lang->line('error_invalid_product_id_user_id'));
                $this->custom_log->write_log('custom_log',$this->lang->line('error_invalid_product_id_user_id'));
            }
            redirect(base_url());
        }
		
		public function test()
		{
			$this->frontendCustomView('single/test',$this->data);
		}
}