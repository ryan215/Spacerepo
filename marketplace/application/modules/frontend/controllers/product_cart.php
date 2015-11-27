<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Product_cart extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();
        // logger
        $this->session->set_userdata ( array (
        	'log_FILE' => ''
        ) );
		
		$this->load->library(array('cart','curl','checkout_lib'));
		$this->load->model(array('cart_m','single_product_m','product_m','rating_review_m','customer_m','pointe_force_m','checkout_m'));
		$this->load->helper(array('order_encrypt','captcha'));		
	}
	
	public function add_to_cart()
    {
    	$this->session->set_userdata(array(
                'log_MODULE' => 'add_to_cart',
                'log_MID'    => ''
        ) );
        $this->session->unset_userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','add to cart from ajax function '.print_r($_POST,true));
		$organizationProductId = id_decrypt($this->input->post('organizationProductId'));
		$marketingProductId    = id_decrypt($this->input->post('marketingProductId'));
		$quantity      		   = 1;
		$result				   = array();	
		$result['success']	   = 0;
		$result['message']     = '';
		$result['quantity']    = $quantity;
		$result['organizationProductId'] = $organizationProductId;
		$result['marketingProductId']    = $marketingProductId;
		$result['totalPrd']     = count($this->cart->contents());
		$result['colorId']      = $this->input->post('colorId');
		$result['sizeId']       = $this->input->post('sizeId');
		$result['organizationColorSizeId'] = $this->input->post('organizationColorSizeId');
		$result['topCartLst']	= '';	
		
		if((!empty($organizationProductId))&&(!empty($quantity)))
		{
			$productDet = $this->product_m->organization_product_details($organizationProductId);
			$this->custom_log->write_log('custom_log','product orgainzation details is '.print_r($productDet,true));
			
			if(!empty($productDet))
			{
				if($productDet->currentQty<$quantity)
				{
					$result['success'] = 0;
					$result['message'] = $this->lang->line('error_qty_greater_then_stock');
				}
				else
				{
					$inventoryHistoryId = 0;
					$inventoryDetails   = $this->product_m->organization_inventory_history($organizationProductId);
					if(!empty($inventoryDetails))
					{
						$inventoryHistoryId = $inventoryDetails->inventoryHistoryId;
					}
					
					$freeShipPrdId  = 0;
					$freeShipCatId  = 0;
					$organizationId = $productDet->organizationId;
					$productId      = $productDet->productId;
					$productWeight  = $productDet->weight+$productDet->shippingWeight;
					$priceArr       = $this->product_lib->show_product_price_array($organizationProductId);
					$this->custom_log->write_log('custom_log','product price array is '.print_r($priceArr,true));
						
					if((!empty($productDet->marketingProductId))&&($productDet->marketingProductId)&&(!empty($result['marketingProductId']))&&($result['marketingProductId'])&&($productDet->marketingProductId==$result['marketingProductId']))
					{
						$displayPrice = $productDet->adminPrice;
					}
					else
					{
						$displayPrice = $priceArr['displayPrice'];
					}	
					
					$freeShipPrdDet = $this->product_m->free_shipping_prd_details($productId);
					$this->custom_log->write_log('custom_log','Free shipping product details is '.print_r($freeShipPrdDet,true));
					if(!empty($freeShipPrdDet))
					{
						$freeShipPrdId = $freeShipPrdDet->freeShipPrdId;
					}
					else
					{							
						$prdCatLst = $this->segment_cat_m->category_parent_list($productDet->categoryId);
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
				
					$result['retailerPrice']              = $priceArr['retailerPrice'];				
					$result['spacePointeCommissionPrice'] = $priceArr['spacePointeCommissionPrice'];
					$result['adminPrice']                 = $priceArr['adminPrice'];
					$result['categoryCommission']         = $priceArr['categoryCommission'];
					$result['cashAdminFee']               = $priceArr['cashAdminFee'];
					$result['genuineShippFee']            = $priceArr['genuineShippFee'];
					$result['toDropshipId']			      = $productDet->dropCenterId;
					$result['productImageId']		      = $productDet->productImageId;
					$result['organizationId']		      = $organizationId;
					$result['productId']			      = $productId;
					$result['pickupProccessPrice']        = 0;
					$result['productAmt']                 = $displayPrice;
					$result['productWeight']              = $productWeight;
					$result['retailerDiscount']           = 0;
					$result['freeShipPrdId']              = $freeShipPrdId;
					$result['freeShipCatId']              = $freeShipCatId;
					
					$result['inventoryHistoryId']         = $inventoryHistoryId;
					$result['spacePointeCommissionPrice2'] = $priceArr['spacePointeCommissionPrice2'];
					$result['retailerQuotedPrice']		  = $priceArr['retailerQuotedPrice'];
					$result['categoryCommission2']		  = $priceArr['categoryCommission2'];
					
					if(!empty($productDet->retailerDiscount))
					{
						$result['retailerDiscount'] = $productDet->retailerDiscount;
					}
					
					$productName = preg_replace("/[^a-zA-Z0-9 ]+/", "", html_entity_decode($productDet->code,ENT_QUOTES)); 
										
					$result['shippingRateId'] = 0;
					$result['shippingOrgId']  = 0;
					$cartDetails 		= '';
					$contents 			= $this->cart->contents();
					$this->custom_log->write_log('custom_log','cart contents is '.print_r($contents,true));
					//echo "<pre>"; print_r($contents); exit;
					if(!empty($contents))
					{
						$whereArr = array();
						foreach($contents as $items)
						{
							$whereArr[] = '(userIdentifier = "'.$items['rowid'].'" AND organizationProductId = '.$organizationProductId.')';
						}
						if(!empty($whereArr))
						{
							$where = '('.implode(' OR ',$whereArr).')';
							$cartDetails = $this->cart_m->cart_row_list($where);							
						}
						//$result['cartDetails'] = $cartDetails;
						if(!empty($cartDetails))
						{
							$result['success'] = 0;
							$result['message'] = 'This product already added';	
						}
						else
						{
							$cartId = $this->cart_m->add_to_cart($result);
							/****Add details of cart*****/
							if($cartId)
							{
								$cartCommissionId = $this->cart_m->add_commission_price($cartId,$result);
								$this->custom_log->write_log('custom_log','Cart commission id is '.$cartCommissionId);
						
								$cartDeliveryId = $this->cart_m->add_to_delivery($cartId,$result);
								$this->custom_log->write_log('custom_log','Cart delivery id is '.$cartDeliveryId);
							}
							/****Add details of cart*****/
								 
							$this->custom_log->write_log('custom_log','data inser in cart and cart id is '.$cartId);
								
							if($cartId)
							{
								$data = array(
											'id'      => $cartId,
											'qty'     => $quantity,
											'price'   => $displayPrice,
											'name'    => $productName,
										);
								$this->custom_log->write_log('custom_log','add to cart inserted data is'.print_r($data,true));
								$rowID = $this->cart->insert($data);
								$this->custom_log->write_log('custom_log','Genrated row id is'.$rowID);
									
								if($this->cart_m->add_rowId_to_cart($cartId,$rowID))
								{
									/*******ADD CART FROM BUY NOW***********/
									$userId = $this->session->userdata('userId');
									if($userId)
									{
										$cartDet = $this->cart_m->get_user_cart($userId);
										$this->custom_log->write_log('custom_log','Buy now data '.print_r($cartDet,true));
										if(!empty($cartDet))
										{
											$this->cart_m->change_buy_now_to_cart($cartDet->cartId);
											if(empty($cartDet->userIdentifier))
											{
												$addData = array(
														'id'      => $cartDet->cartId,
														'qty'     => $cartDet->quantity,
														'price'   => $cartDet->productAmt,
														'name'    => 'abc'.$cartDet->cartId,
													);
												$rowID = $this->cart->insert($addData);
												$this->cart_m->change_from_buy_now_session($cartDet->cartId,$rowID);
											}
										}
									}
									/*******ADD CART FROM BUY NOW***********/
					
									$result['success'] = 1;
									$result['message'] = 'Product Added Successfully';
									$result['totalPrd'] = count($this->cart->contents());
								}
								else
								{
									$result['success'] = 0;
									$result['message'] = 'Row not add in cart';
								}
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = $this->lang->line('error_add_to_cart');			
							}
						}
					}
					else
					{
						$cartId = $this->cart_m->add_to_cart($result);						
						/****Add details of cart*****/
						if($cartId)
						{
							$cartCommissionId = $this->cart_m->add_commission_price($cartId,$result);
							$this->custom_log->write_log('custom_log','Cart commission id is '.$cartCommissionId);
								
							$cartDeliveryId = $this->cart_m->add_to_delivery($cartId,$result);
							$this->custom_log->write_log('custom_log','Cart delivery id is '.$cartDeliveryId);
						}
						/****Add details of cart*****/
							
						$this->custom_log->write_log('custom_log','data insert in cart and cart id is '.$cartId);
							
						if($cartId)
						{
							$data = array(
										'id'      => $cartId,
										'qty'     => $quantity,
										'price'   => $displayPrice,
										'name'    => $productName,
									);
							$this->custom_log->write_log('custom_log','add to cart inserted data is'.print_r($data,true));
							$rowID = $this->cart->insert($data);
							$this->custom_log->write_log('custom_log','Genrated row id is'.$rowID);
								
							if($this->cart_m->add_rowId_to_cart($cartId,$rowID))
							{
								/*******ADD CART FROM BUY NOW***********/
								$userId = $this->session->userdata('userId');
								if($userId)
								{
									$cartDet = $this->cart_m->get_user_cart($userId);
									$this->custom_log->write_log('custom_log','Buy now data '.print_r($cartDet,true));
									if(!empty($cartDet))
									{
										$this->cart_m->change_buy_now_to_cart($cartDet->cartId);
										if(empty($cartDet->userIdentifier))
										{
											$addData = array(
														'id'      => $cartDet->cartId,
														'qty'     => $cartDet->quantity,
														'price'   => $cartDet->productAmt,
														'name'    => 'abc'.$cartDet->cartId,
												);
											$rowID = $this->cart->insert($addData);
											$this->cart_m->change_from_buy_now_session($cartDet->cartId,$rowID);
										}
									}
								}
								/*******ADD CART FROM BUY NOW***********/
								$result['success'] = 1;
								$result['message'] = 'Product Added Successfully';
								$result['totalPrd'] = count($this->cart->contents());
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = 'Row not add in cart';
							}
							//echo $this->db->last_query(); exit;
						}
						else
						{
							$result['success'] = 0;
							$result['message'] = $this->lang->line('error_add_to_cart');			
						}
					}
					
					$userId = $this->session->userdata('userId');
					$checkoutUrl = '<a class="button btn-gotocart checkout-btn-box" type="button" title="Checkout" data-toggle="modal" data-target="#modal-login"><span><span>Checkout</span></span></a>';
					if($userId)
					{
						$checkoutUrl = '<a class="button btn-gotocart checkout-btn-box" type="button" title="Checkout" href="'.base_url().'frontend/product_cart/shipping_address'.'"><span><span>Checkout</span></span></a>';
					}
					
					$result['topCartLst'] = '<div class="arrow-up"></div><div class="top-cart-content arrow_box " id="testCart" style="display: block;"><span onclick="close_cart();" class="pull-right close_btn close-btn-span"><i class="fa fa-times-circle cart-box-close"></i></span><ul id="cart-sidebar" class="mini-products-list"><li class="item even"><div class="col-sm-4 pd_left" style="padding-left:0px;"><a class="product-image" href="javascript:void(0);"><img alt="Downloadable Product" src="'.base_url().'uploads/product/'.$productDet->imageName.'" width="70" height="70"></a></div><div class="col-sm-8" style="padding-left:0px;"><div class="detail-item"><div class="product-details"><p class="product-name"><a href="javascript:void(0);">'.$productName.'</a></p><p><span class="sale-price">&#x20A6;'.number_format($displayPrice,2).'</span></p><p style="color:#aaa;line-height: 14px;text-transform: lowercase;">has been added to your cart </p></div></div></div></li></ul><div class="button-total" style="padding: 0px 5px 15px 15px;"><a class="button btn-gotocart active viewcart-btn-box" type="button" title="Go to cart" href="'.base_url().'frontend/product_cart/cart_page'.'" style="background-color: #fe5621 !important;"><span><span>View cart</span></span></a>&nbsp;'.$checkoutUrl.'</div></div>';
				}				
			}
			else
			{
				$result['success'] = 0;
				$result['message'] = $this->lang->line('error_product_not_details');
			}			
		}
		else
		{
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_invalid_data');
		}
		
		$this->custom_log->write_log('custom_log','Result is '.print_r($result,true));
        echo json_encode($result);
	}
	
	public function cart_page()
    {
    	$this->session->set_userdata(array(
        	'log_MODULE' => 'cart_page',
            'log_MID'    => ''
        ) );
		
		$this->data['title'] = 'Cart Detail';
        /*******ADD CART FROM BUY NOW***********/
		$userId = $this->session->userdata('userId');
		if($userId)
		{
			$cartDet = $this->cart_m->get_user_cart($userId);
			$this->custom_log->write_log('custom_log','Buy now data '.print_r($cartDet,true));
			if(!empty($cartDet))
			{
				$this->cart_m->change_buy_now_to_cart($cartDet->cartId);
				if(empty($cartDet->userIdentifier))
				{
					$addData = array(
									'id'      => $cartDet->cartId,
									'qty'     => $cartDet->quantity,
									'price'   => $cartDet->productAmt,
									'name'    => 'abc'.$cartDet->cartId,
								);
					$rowID = $this->cart->insert($addData);
					$this->cart_m->change_from_buy_now_session($cartDet->cartId,$rowID);
				}
			}
        }
		/*******ADD CART FROM BUY NOW***********/
		
		$contents = $this->cart->contents();
        $this->custom_log->write_log('custom_log','Cart contents is '.print_r($contents,true));
        
		$result = '';
        if(!empty($contents))
        {
			$whereArr = array();
            foreach($contents as $items)
            {
            	$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
            }
            
			if(!empty($whereArr))
            {
            	$where  = '('.implode(' OR ',$whereArr).')';
                $result = $this->cart_m->cart_page_detail_list($where);
            }
		}
       // echo "<pre>"; print_r($result); exit;
		$this->custom_log->write_log('custom_log','Restult is '.print_r($result,true));
        $this->data['result'] = $result;
		$this->frontendCustomView('product_cart/cart_page',$this->data);
    }	
	
	public function qty_increment()
    {
    	$this->session->set_userdata(array(
                'log_MODULE' => 'qty_increment',
                'log_MID'    => ''
		) );
        $this->custom_log->write_log('custom_log','quantity increament form data '.print_r($_POST,true));
		
		$cartId   = $this->input->post('cartId');
		$return   = array('success' => 0,'message' => '','subtotal' => 0,'total' => 0);
		
		if(!empty($cartId))
        {
			$result = $this->cart_m->cart_page_details_row($cartId);
            $this->custom_log->write_log('custom_log','cart details is '.print_r($result,true));
            if(!empty($result))
            {
            	$qty 			= $result->quantity;
                $qty 			= $qty+1;
                $totalInventory = $result->currentQty;
                if($totalInventory<$qty)
                {
                	$return['success'] = 0;
                    $return['message'] = 'Quantity is greater then to stock';
				}
                else
                {
					$productWeight = $result->productWeight;
					$subtotal      = $result->productAmt*$qty;
					$totalAmt      = $this->cart->total();
					if($this->cart_m->update_to_cart($cartId,$qty))
                    {
                    	$this->custom_log->write_log('custom_log','Quantity increment successfully');
						
						$data = array(
                                	'rowid' => $result->userIdentifier,
	                                'qty'   => $qty,
	                            );
                        $this->cart->update($data);
						
						$totalAmt = $this->cart->total();
                        $return['success']  = 1;
                        $return['message']  = $qty;
                        $return['subtotal'] = number_format($subtotal,2);
                        $return['total']    = number_format($totalAmt,2);
                     }
                     else
                     {
                     	$return['success']  = 0;
                        $return['message']  = 'Quantity not increment';
                        $return['subtotal'] = $subtotal;
						$return['total']    = number_format($totalAmt,2);
                     }
				}
			}
            else
            {
            	$return['success']  = 0;
                $return['message']  = 'Cart details not found';
			}
		}
		else
        {
        	$return['success']  = 0;
            $return['message']  = 'user cart id is empty';
		}
		$this->custom_log->write_log('custom_log','retun array for qty_increment_add_to_cart function '.print_r($return,true));
        echo json_encode($return);
	}
	
	public function qty_decryment()
    {
    	$this->session->set_userdata(array(
                'log_MODULE' => 'qty_decryment',
                'log_MID'    => ''
		) );
        $this->custom_log->write_log('custom_log','quantity decrement form data '.print_r($_POST,true));
		
		$cartId   = $this->input->post('cartId');
		$return   = array('success' => 0,'message' => '','subtotal' => 0,'total' => 0);
		
		if(!empty($cartId))
        {
			$result = $this->cart_m->cart_page_details_row($cartId);
            $this->custom_log->write_log('custom_log','cart details is '.print_r($result,true));
            if(!empty($result))
            {
            	$qty = $result->quantity;
                $qty = $qty-1;
                if($qty<1)
                {
                	$return['success'] = 0;
                    $return['message'] = 'Quantity is not less then to Zero';
				}
                else
                {
					$productWeight = $result->productWeight;
					$subtotal      = $result->productAmt*$qty;
					$totalAmt      = $this->cart->total();
					if($this->cart_m->update_to_cart($cartId,$qty))
                    {
                    	$this->custom_log->write_log('custom_log','Quantity increment successfully');
						
						$data = array(
                                	'rowid' => $result->userIdentifier,
	                                'qty'   => $qty,
	                            );
                        $this->cart->update($data);
						
						$totalAmt = $this->cart->total();
                        $return['success']  = 1;
                        $return['message']  = $qty;
                        $return['subtotal'] = number_format($subtotal,2);
                        $return['total']    = number_format($totalAmt,2);
                     }
                     else
                     {
                     	$return['success']  = 0;
                        $return['message']  = 'Quantity not increment';
                        $return['subtotal'] = $subtotal;
						$return['total']    = number_format($totalAmt,2);
                     }
				}
			}
            else
            {
            	$return['success']  = 0;
                $return['message']  = 'Cart details not found';
			}
		}
		else
        {
        	$return['success']  = 0;
            $return['message']  = 'user cart id is empty';
		}
		$this->custom_log->write_log('custom_log','retun array for qty_decrement_add_to_cart function '.print_r($return,true));
        echo json_encode($return);
	}
	
	public function remove_to_cart($cartId=0)
    {
    	$this->session->set_userdata(array(
        	'log_MODULE' => 'remove_to_cart',
            'log_MID'    => ''
		) );

		$cartId = id_decrypt($cartId);
		if($cartId)
		{
	    	$this->custom_log->write_log('custom_log','user cart id is '.$cartId);
			
			$result = $this->cart_m->cart_page_details_row($cartId);
            $this->custom_log->write_log('custom_log','cart details is '.print_r($result,true));
            
    	    if($this->cart_m->remove_from_cart($cartId))
        	{
				$data = array(
                	    'rowid' => $result->userIdentifier,
                    	'qty'   => 0,
                );
                $this->cart->update($data);
				
				$this->session->set_flashdata('success','Product removed from your shopping cart');
				$this->custom_log->write_log('custom_log','Cart details remove from buy now page');
				echo 1;
			}
			else
			{
				$this->session->set_flashdata('error','not remove from page');
				$this->custom_log->write_log('custom_log','not remove from page');
				echo 0;
			}
		}
		else
		{
			$this->session->set_flashdata('error','Buy not details not found');
			$this->custom_log->write_log('custom_log','Buy not details not found');
			echo 0;
		}
	}
	
	public function clear_cart()
	{
    	$this->session->set_userdata(array(
        	'log_MODULE' => 'clear_cart',
            'log_MID'    => ''
		) );

        $contents = $this->cart->contents();
        $this->custom_log->write_log('custom_log','Cart contents is '.print_r($contents,true));
        if(!empty($contents))
        {
        	$whereArr = array();
            foreach($contents as $items)
            {
            	$whereArr[] = 'cart.cartId = '.$items['id'];
            }
            if(!empty($whereArr))
            {
            	$where = '('.implode(' OR ',$whereArr).')';
                if($this->cart_m->remove_to_cart($where))
                {
                	$this->session->set_flashdata('success',$this->lang->line('success_clear_cart'));
                    $this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_clear_cart'));
				}
                else
                {
                	$this->session->set_flashdata('error','Cart not clear');
                    $this->custom_log->write_log('custom_log','Cart not clear');
				}
			}
		}
        //echo $where; exit;
        $this->cart->destroy();
		$this->session->unset_userdata('isChkAvl');
		$this->session->unset_userdata('pickupId');
		$this->session->unset_userdata('isPickUp');
		$this->session->unset_userdata('shippingAddressId');
        redirect(base_url());
	}
	
	public function shipping_address()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'shipping_address',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Shipping Address';
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if($total_cart<1)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}		
		
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->session->userdata('isPointeForce');
		$this->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
				
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->pointe_force_m->pointe_force_verification_details($userId);
			$this->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
						
		if($_POST)
		{
			if((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==1))
			{
				$this->custom_log->write_log('custom_log','after submit form is '.print_r($_POST,true));
				$rules = check_captcha_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{						
					//	Customer Information
					$customerDetails = $this->customer_m->get_customer_user_detail($userId);
					$shippCusAddId   = $this->session->userdata('shippingAddressId');
					$contents   = $this->cart->contents();
					$total_cart = count($contents);
					if(!$total_cart)
					{
						$this->session->set_flashdata('error','cart list not found');
						$this->custom_log->write_log('custom_log','cart list not found');
						redirect(base_url());
					}
				
					if(!empty($contents))
					{					
						$customOrderIdCart = array();
						$customOrderIdRet  = array();
						$amount            = 0;
						$atATimeProduct    = 0;
						$retailerArr       = array();
						$retailerPrdArr    = array();
						$this->custom_log->write_log('custom_log','result array is '.print_r($cartDetails,true));
						
						if(!empty($cartDetails))
						{
							$atATimeProduct = $this->checkout_lib->cash_on_delivery_add_to_cart_single_shippment($cartDetails);
							$this->custom_log->write_log('custom_log','at a time product id is '.$atATimeProduct);
							foreach($cartDetails as $row)
							{							
								$cusOrderId    = $this->config->item('add_orderId');
								$cusOrderId	   = $cusOrderId+$row->cartId;
								$customOrderId = $this->config->item('pre_orderId').$cusOrderId;
								$customOrderIdRet[$row->organizationId] = $customOrderId;
								$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
								
								$retailerPrdArr[$row->organizationId]['productDet'][$row->productId]['productAmt'] = $row->productAmt;
								$retailerPrdArr[$row->organizationId]['productDet'][$row->productId]['productQty'] = $row->quantity;	
								$retailerPrdArr[$row->organizationId]['productDet'][$row->productId]['productName'] = $row->code;
								$retailerPrdArr[$row->organizationId]['productDet'][$row->productId]['imageName'] = $row->imageName;					
							}						
							$this->custom_log->write_log('custom_log','custom order id array is '.print_r($customOrderIdRet,true));
							$economicOrderArr = array();
							foreach($cartDetails as $row)
							{
								$customOrderIdCart[$row->cartId] = $customOrderIdRet[$row->organizationId];
								$displayPrice   = $row->productAmt;
								$shipping_rate  = 0;
								$handlingPrice  = 0;
								$retailerPrdAmt = 0;
								if(!empty($retailerArr[$row->organizationId]))
								{
								}
								else
								{									
									if(!empty($retailerPrdArr[$row->organizationId]['productDet']))
									{	
										foreach($retailerPrdArr[$row->organizationId]['productDet'] as $retailerPrdKey=>$retailerPrdVal)
										{
											$retailerPrdAmt = $retailerPrdAmt+($retailerPrdVal['productAmt']*$retailerPrdVal['productQty']);
										}
										
										$standardDet = $this->cart_m->standard_delivery_details($row->organizationId,$userId);
										$this->custom_log->write_log('custom_log','standard delivery details is '.print_r($standardDet,true));				
										if(!empty($standardDet))
										{
											if($standardDet->isCalculateShipp)
											{
												$shippingRate = $standardDet->shippingRate;
												if($standardDet->totalProductWeight>10)
												{
													$shippingRate = $standardDet->shippingRate*$standardDet->totalProductWeight;
												}
												$retailerPrdAmt = $retailerPrdAmt+$shippingRate;
											}
											$this->custom_log->write_log('custom_log','after calculate retailer product amount is '.$retailerPrdAmt);
											$retailerPrdArr[$row->organizationId]['shippingOrgId'] = $standardDet->finalShippingOrgId;
											$retailerPrdArr[$row->organizationId]['shippingRateId'] = $standardDet->finalShippingRateId;
											$retailerPrdArr[$row->organizationId]['shippingRate']    = $standardDet->shippingRate;	
											$retailerPrdArr[$row->organizationId]['shippingEta']     = $standardDet->ETA+$this->config->item('estimated_time_increase');	
											$retailerPrdArr[$row->organizationId]['shippingOrgName'] = $standardDet->organizationName;	
											$retailerPrdArr[$row->organizationId]['shippingOrgEmail'] = $standardDet->email;	
											$retailerPrdArr[$row->organizationId]['shippingBsPhone'] = $standardDet->businessPhone;	
											$retailerPrdArr[$row->organizationId]['isCalculateShipp']  = $standardDet->isCalculateShipp;
											$retailerPrdArr[$row->organizationId]['totalProductWeight'] = $standardDet->totalProductWeight;
											$retailerPrdArr[$row->organizationId]['retailerName'] = $row->organizationName;
											$retailerPrdArr[$row->organizationId]['retailerEmail'] = $row->email;
											$retailerPrdArr[$row->organizationId]['retailerBsPhoneCode'] = $row->businessPhoneCode;
											$retailerPrdArr[$row->organizationId]['retailerBsPhone'] = $row->businessPhone;	
											$retailerPrdArr[$row->organizationId]['retailerStateId'] = $row->dropshipStateId;
											$this->custom_log->write_log('custom_log','retailer product amount is '.$retailerPrdAmt);
											$handlingPrice = ($retailerPrdAmt*$this->config->item('space_point_comission'))/100;
											$this->custom_log->write_log('custom_log','Cash Handling Price is '.$handlingPrice);
										
											/********Add Standard Delivery Order***********/
											$economicOrderArr['organizationId']     = $standardDet->organizationId;
											$economicOrderArr['fromDropshipId']     = $standardDet->fromDropshipId;
											$economicOrderArr['totalProductWeight'] = $standardDet->totalProductWeight;
											$economicOrderArr['shippingOrgId']      = $standardDet->finalShippingOrgId;										
											$economicOrderArr['shippingRateId']     = $standardDet->finalShippingRateId;
											$economicOrderArr['customOrderId']      = $customOrderIdCart[$row->cartId];
											$economicOrderArr['cashHandlingPrice']  = $handlingPrice;		
											$economicOrderArr['isCalculateShipp']   = $standardDet->isCalculateShipp;
											$this->order_m->unactive_economical_repeate_order_delivery($economicOrderArr);
											$orderEconomicalId = $this->order_m->add_economical_order_delivery($economicOrderArr);
											$this->custom_log->write_log('custom_log','economical delivery id is '.$orderEconomicalId);
											/********Add Standard Delivery Order**********/
										}
										$amount = $amount+$retailerPrdAmt+$handlingPrice;									
										$retailerPrdArr[$row->organizationId]['cashHandlingPrice'] = $handlingPrice;
									}								
								}
								$retailerArr[$row->organizationId] = $row->organizationId;							
							}
							
							$this->custom_log->write_log('custom_log','at a time purchase id is '.$atATimeProduct);
							$this->custom_log->write_log('custom_log','Total AMount is '.$amount);
							//echo "<pre>"; print_r($retailerPrdArr); exit;
							
							$customerAddDetails = $this->customer_m->customer_with_address_details($userId,$shippCusAddId);
							$this->custom_log->write_log('custom_log','customer address details is '.print_r($customerAddDetails,true));
							$customerName  = $customerAddDetails->addressFirstName.' '.$customerAddDetails->addressLastName;
							$customerPhone = $customerAddDetails->addressPhoneNo;
							$customerShippAdd = $customerAddDetails->addressLine1.' '.$customerAddDetails->cityName.','.$customerAddDetails->areaName.' '.$customerAddDetails->stateName;
							
							foreach($cartDetails as $row)
							{
								$orderArr = array(
											'orderTypeId'           => 2,										
											'totalAmount'           => $amount,
											'customerId'            => $this->session->userdata('userId'),
											'quantity'				=> $row->quantity,
											'chargedAmount'			=> $row->productAmt,
											'organizationProductId' => $row->organizationProductId,
											'orderStatusId'         => 1,										
											'orderEmail'       		=> $this->session->userdata('userEmail'),
											'shippingOrgId'			=> $retailerPrdArr[$row->organizationId]['shippingOrgId'],										
											'shippingRateId'		=> $retailerPrdArr[$row->organizationId]['shippingRateId'],
											'customOrderId'			=> $customOrderIdCart[$row->cartId],
											'atATimeProduct'		=> $atATimeProduct,
											'colorId'				=> $row->colorId,
											'size'					=> $row->size,
											'isPickup'				=> 0,
											'pickupId'				=> 0,
											'payment_reference'     => '',
											'retrieval_reference'   => '',
											'transaction_reference' => '',
											'merchant_reference'	=> '',
											'transaction_date'	    => '',
											'paymentStatus'			=> 0,	
											'toDropshipId'			=> $row->toDropshipId,
											'retailerPrice'			=> $row->retailerPrice,
											'spacePointePrice'	    => $row->spacePointePrice,
											'cashAdminPrice'		=> $row->cashAdminPrice, 
											'cashAdminFee'			=> $row->cashAdminFee,
											'genuineShippFee'		=> $row->genuineShippFee,
											'categoryCommission'    => $row->categoryCommission,
											'marketingProductId'	=> $row->marketingProductId,
											'cashHandlingPrice'     => 0,
											'pickupProccessPrice'   => 0,
											'productWeight'      	=> $row->productWeight,
											'retailerDiscount'		=> $row->retailerDiscount,
											'freeShipCatId'		    => $row->freeShipCatId,
											'freeShipPrdId'	    	=> $row->freeShipPrdId,
											'productId'				=> $row->productId,
											'productImageId'		=> $row->productImageId,
											'isEconomicDelivery'    => 1,
											'inventoryHistoryId'	=> $row->inventoryHistoryId,
											'pointeForceVerifiedStatus'	=> $pointeForceVerifiedStatus,
											'spacepointeCommission2'	=> $row->spacePointePrice2,
											'totalCommissionPrice'      => $row->quantity*$row->spacePointePrice2,				
										);
								//echo "<pre>"; print_r($orderArr); exit;
								$orderID  = $this->order_m->add_order($orderArr);
								$this->custom_log->write_log('custom_log','order inserted array is '.print_r($orderArr,true));
								$this->custom_log->write_log('custom_log','Created order id is '.$orderID);
								if($orderID)
								{
									/**********shipping address for customer*************/
									$shippCusAddId  = $this->session->userdata('shippingAddressId');
									$this->custom_log->write_log('custom_log','customer address id is '.$shippCusAddId);
									$orderaddressId = $this->order_m->add_order_address($orderID,$shippCusAddId);
									/********shipping address for customer***************/
									
									/**********billing address for customer*************/
									$billCusDet = $this->customer_m->user_billing_details($this->session->userdata('userId'));
									$this->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
									$billCusAddId = 0;
									if(!empty($billCusDet))
									{
										$billCusAddId = $billCusDet->addressId;
									}
									else
									{
										$billCusAddId = $shippCusAddId;	
									}
									$this->order_m->add_billing_order_address($orderID,$billCusAddId);
									/********billing address for customer***************/
									
									$payOrderID  = $this->order_m->add_order_payment($orderID,$orderArr);
									$this->custom_log->write_log('custom_log','Payment order id is '.$payOrderID);
									if($payOrderID)
									{
										$orderTrackId = $this->order_m->add_order_track_details($orderID,1);
										$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
										
										$orderDropshipCenterId = $this->order_m->add_order_dropship_center($orderID,$orderArr);
										$this->custom_log->write_log('custom_log','order dropship center id is '.$orderDropshipCenterId);
										$freeShipOrderId = $this->order_m->add_order_free_shipping($orderID,$orderArr);
										$this->custom_log->write_log('custom_log','free shipping order id is '.$freeShipOrderId);
										if($this->order_m->reduce_product_quantity($row->organizationProductId,$row->quantity))
										{
											$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
											$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId);	
											if($row->colorId)
											{
												if($row->marketingProductId)
												{
													$this->order_m->reduce_product_color_quantity_from_marketing($row->marketingProductId,$row->colorId,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->marketingProductId.' and color id is '.$row->colorId);
												}
												else
												{/*
													$this->order_m->reduce_product_color_quantity($row->organizationProductId,$row->colorId,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId.' and color id is '.$row->colorId);
												*/}
											}
											
											if($row->size)
											{
												if($row->marketingProductId)
												{
													$this->order_m->reduce_product_size_quantity_from_marketing($row->marketingProductId,$row->size,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from marketing product id is '.$row->organizationProductId.' and size is '.$row->size);	
												}
												else
												{/*
													$this->order_m->reduce_product_size_quantity($row->organizationProductId,$row->size,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId.' and size is '.$row->size);	
												*/}
											}
											if((!empty($row->marketingProductId))&&($row->marketingProductId))
							{
							}
							elseif((!empty($row->organizationColorSizeId))&&($row->organizationColorSizeId))							
							{
								$this->order_m->reduce_orgnization_product_color_size_quantity($row->organizationColorSizeId,$row->quantity);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationColorSizeId);
							}
										}
							
										$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
										$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
										/***order History****************/
										$orderHistoryId = $this->order_m->add_order_history($orderID,1);
										$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
										/***Order History****************/
										
										/*********add order pointeforce commission***********/
										if((!empty($isPointeForce))&&($isPointeForce))
										{
											$orderPointeForceId = $this->order_m->add_order_pointe_force_commission($orderID,$orderArr);
											$this->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
										}
										/*********add order pointeforce commission***********/
										
									}
									else
									{
										$this->session->set_flashdata('error',$this->lang->line('error_add_order'));
										$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_add_order'));
									}
								}
							}
							
							foreach($retailerPrdArr as $retailerKey=>$retailerRow)
							{		
								$mailContent = '<table width="100%" class="order-table" style="border-bottom:2px solid #6d6d6d; padding-bottom:5px;"><tbody>';
								if(!empty($retailerRow['productDet']))
								{
									$mailContent.= '<tr><th colspan="2">Item </th><th style="text-align:center;"> Item price </th><th style="text-align:center;"> Qty </th><th style="text-align:right;"> Subtotal </th></tr>';
									foreach($retailerRow['productDet'] as $prodctRow)
									{
										$imagePath = base_url().'img/no_image.jpg';
										if((!empty($prodctRow['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$prodctRow['imageName'])))
										{
											$imagePath = base_url().'uploads/product/thumb500_500/'.$prodctRow['imageName'];
										}
										elseif((!empty($prodctRow['imageName']))&&(file_exists('uploads/product/'.$prodctRow['imageName'])))
										{
											$imagePath = base_url().'uploads/product/'.$prodctRow['imageName'];
										}
										$mailContent.= '<tr><td  style="text-align:center;"><img src="'.$imagePath.'" width="45px"></td><td style="text-align:center;">'.$prodctRow['productName'].'</td><td style="text-align:center;">&#x20A6;'.$prodctRow['productAmt'].'</td><td style="text-align:center;">'.$prodctRow['productQty'].'</td><td style="text-align:right;">&#x20A6;'.($prodctRow['productAmt']*$prodctRow['productQty']).'</td></tr>';
										
										$message = 'An Order for '.$prodctRow['productQty'].substr($prodctRow['productName'],0,20).' has been placed. Please confirm in the panel.';
										$response = $this->twillo_m->send_mobile_message($retailerRow['retailerBsPhoneCode'].$retailerRow['retailerBsPhone'],$message);
										$this->custom_log->write_log('custom_log','Message send response is '.print_r($response,true));
										$customer_order_message = substr($prodctRow['productAmt'],0,20).', order #  '.$customOrderIdRet[$retailerKey].' has been accepted & will be delivered in '.$retailerRow['shippingEta'].' days.';
										$response = $this->twillo_m->send_mobile_message('+234'.$customerPhone,$customer_order_message);				
										$this->custom_log->write_log('custom_log','send message response is '.print_r($response,true));
									}
									
								}
								$mailContent.= '</tbody></table>';
								/*******Customer mail*****************/
								$mailData = array(
												'email'           => $this->session->userdata('userEmail'),
												'cc'			  => '',
												'bcc'			  => 'neworders@spacepointe.com',
												'slug'            => 'economic_order_placed_for_customer',
												'customerName'    => $customerName,
												'customerPhone'	  => $customerPhone,
												'orderId'		  => $customOrderIdRet[$retailerKey],
												'eta'			  => $retailerRow['shippingEta'],
												'shippingVendor'  => $retailerRow['shippingOrgName'],
												'shippingAddName' => $customerName,
												'shippingAddress' => $customerShippAdd,
												'sellerName'      => $retailerRow['retailerName'],
												'mailContent'	  => $mailContent,
												'totalAmount'	  => number_format($amount,2),
												'subject'  		  => 'Your Order Has Been Placed',
											);								
								if($this->email_m->send_mail($mailData))
								{
									$customer_order_message = 'Your order has been recieved for '.$customOrderIdRet[$retailerKey].', will be delivered in '.$retailerRow['shippingEta'].' days';
			
									$response = $this->twillo_m->send_mobile_message('+234'.$customerPhone,$customer_order_message);
			
									$this->custom_log->write_log('custom_log','send message response is '.print_r($response,true));								$this->custom_log->write_log('custom_log','Mail send successfully');
								}
								else
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
								}
								/*******Customer mail ******/
								
								/*******Mail send to neworders@spacepointe.com***********/
								$mailData = array(
												'email'           => 'neworders@spacepointe.com',
												'cc'			  => '',
												'bcc'			  => 'neworders@spacepointe.com',
												'slug'            => 'economic_order_placed_for_customer',
												'customerName'    => $customerName,
												'customerPhone'	  => $customerPhone,
												'orderId'		  => $customOrderIdRet[$retailerKey],
												'eta'			  => $retailerRow['shippingEta'],
												'shippingVendor'  => $retailerRow['shippingOrgName'],
												'shippingAddName' => $customerName,
												'shippingAddress' => $customerShippAdd,
												'sellerName'      => $retailerRow['retailerName'],
												'mailContent'	  => $mailContent,
												'totalAmount'	  => number_format($amount,2),
												'subject'  		  => 'Your Order Has Been Placed',
											);
								if($this->email_m->send_mail($mailData))
								{
									$this->custom_log->write_log('custom_log','Mail send successfully');
								}
								else
								{										
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
								}		
								/*******Mail send to neworders@spacepointe.com***********/
								
								/******mail for retailer*******/
								if(!empty($retailerRow['retailerEmail']))
								{											
									$mailData = array(
													'email'           => $retailerRow['retailerEmail'],
													'cc'			  => '',
													'bcc'			  => 'neworders@spacepointe.com',
													'slug'            => 'economic_order_placed_for_customer',
													'customerName'    => $customerName,
													'customerPhone'	  => $customerPhone,
													'orderId'		  => $customOrderIdRet[$retailerKey],
													'eta'			  => $retailerRow['shippingEta'],
													'shippingVendor'  => $retailerRow['shippingOrgName'],
													'shippingAddName' => $customerName,
													'shippingAddress' => $customerShippAdd,
													'sellerName'      => $retailerRow['retailerName'],
													'mailContent'	  => $mailContent,
													'totalAmount'	  => number_format($amount,2),
													'subject'  		  => 'An order has been placed',
												);
									if($this->email_m->send_mail($mailData))
									{
										$this->custom_log->write_log('custom_log','Mail send successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
									}
								}
								/******mail for retailer*******/
							}
							
							if(!empty($where))
							{
								$this->cart_m->remove_to_cart($where);
								$this->cart_m->remove_economical_delivery_from_cart();							
							}
							$this->cart->destroy();
							$this->session->unset_userdata('isPickUp');
							$this->session->unset_userdata('isChkAvl');
							$this->session->unset_userdata('shippingAddressId');
							$this->session->set_flashdata('success','Order created successfully');
							$this->custom_log->write_log('custom_log','Order created successfully');
							redirect(base_url().'frontend/order/order_complete_success/'.id_encrypt($atATimeProduct));
						}
					}
					else
					{
						$this->session->set_flashdata('error','Cart Details not found');
						$this->custom_log->write_log('custom_log','Cart Details not found');	
						redirect(base_url());
					}
				}
			}
			elseif((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==2))
			{
				$this->custom_log->write_log('custom_log','after submit form is '.print_r($_POST,true));
				$rules = check_captcha_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					//	Customer Information
					$customerDetails = $this->customer_m->get_customer_user_detail($userId);
					$contents   = $this->cart->contents();
					$total_cart = count($contents);
					if(!$total_cart)
					{
						$this->session->set_flashdata('error','cart list not found');
						$this->custom_log->write_log('custom_log','cart list not found');
						redirect(base_url());
					}
				
					if(!empty($contents))
					{
						$customOrderIdCart = array();
						$customOrderIdRet = array();
						$mailContaint = '';
						$amount = 0;
						$atATimeProduct = 0;
						if(!empty($cartDetails))
						{
							$atATimeProduct = $this->checkout_lib->cash_on_delivery_add_to_cart_quick_shippment($cartDetails);
							$this->custom_log->write_log('custom_log','at a time product id is '.$atATimeProduct);
						
							foreach($cartDetails as $row)
							{							
								$retailerDet = $this->order_m->order_retailer_details($row->organizationProductId);
								if(!empty($retailerDet))
								{
									$cusOrderId    = $this->config->item('add_orderId');
									$cusOrderId	   = $cusOrderId+$row->cartId;
									$customOrderId = $this->config->item('pre_orderId').$cusOrderId;
									$customOrderIdRet[$retailerDet->organizationId] = $customOrderId;
									$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
								}
								
							}
							$this->custom_log->write_log('custom_log','custom order id array is '.print_r($customOrderIdRet,true));
							foreach($cartDetails as $row)
							{
								$retailerDet = $this->order_m->order_retailer_details($row->organizationProductId);
								if(!empty($retailerDet))
								{
									$productWeight      = $row->productWeight;
									$displayPrice       = $row->productAmt;
									$spacePointePrice   = $row->spacePointePrice;
									$cashAdminPrice     = $row->cashAdminPrice;
									$cashAdminFee       = $row->cashAdminFee;
									$categoryCommission = $row->categoryCommission;
									$genuineShippFee    = $row->genuineShippFee;
									$shipping_rate      = 0;
									
									if($row->freeShipPrdId)
									{
									}
									elseif($row->freeShipCatId)
									{
									}
									elseif($genuineShippFee)
									{	
										$shippingRate = $row->shippingRate;
										if($productWeight>10)
										{
											$shippingRate = $row->shippingRate*$productWeight;
										}
										$shipping_rate = $shipping_rate+($row->quantity*$shippingRate);
									}
									$customOrderIdCart[$row->cartId] = $customOrderIdRet[$retailerDet->organizationId];
									$amount = $amount+($displayPrice*$row->quantity)+$shipping_rate;
								}
							}
						}
						$this->custom_log->write_log('custom_log','at a time purchase id is '.$atATimeProduct);
						
						$handlingPrice = ($amount*$this->config->item('space_point_comission'))/100;
						$this->custom_log->write_log('custom_log','Cash Handling Price is '.$handlingPrice);
						
						$amount = $amount+$handlingPrice;
						$this->custom_log->write_log('custom_log','Total AMount is '.$amount);
						
						$this->custom_log->write_log('custom_log','result array is '.print_r($cartDetails,true));
						if(!empty($cartDetails))
						{
							foreach($cartDetails as $row)
							{
								$productId     		= $row->productId;
								$retailerPrice 		= $row->retailerPrice;
								$productWeight 		= $row->weight+$row->shippingWeight;		                    	
								$spacePointePrice   = $row->spacePointePrice;
								$cashAdminPrice     = $row->cashAdminPrice;
								$cashAdminFee       = $row->cashAdminFee;
								$categoryCommission = $row->categoryCommission;
								$genuineShippFee    = $row->genuineShippFee;
								$displayPrice 		= $row->productAmt;							
								$shipping_rate		= 0;
								$cashHandlingPrice  = 0;
								
								if($row->freeShipPrdId)
								{
								}
								elseif($row->freeShipCatId)
								{
								}
								elseif($row->genuineShippFee)
								{	
									$shipping_rate = $row->shippingRate*$row->quantity;
									if($productWeight>10)
									{
										$shipping_rate = $row->shippingRate*$row->quantity*$productWeight;
									}
								}	
								$this->custom_log->write_log('custom_log','Shipping Rate is '.$shipping_rate);
								$ttlAmt = ($row->quantity*$displayPrice)+$shipping_rate;
								$this->custom_log->write_log('custom_log','total amount after calculate shipping rate = '.$ttlAmt);
								
								$cashHandlingPrice = ($ttlAmt*$this->config->item('space_point_comission'))/100; 
								$this->custom_log->write_log('custom_log','cash Handling amount of total amout is '.$cashHandlingPrice);
	
								$orderArr = array(
											'orderTypeId'           => 2,										
											'totalAmount'           => $amount,
											'customerId'            => $this->session->userdata('userId'),
											'quantity'				=> $row->quantity,
											'chargedAmount'			=> $displayPrice,
											'organizationProductId' => $row->organizationProductId,
											'orderStatusId'         => 1,										
											'orderEmail'       		=> $this->session->userdata('userEmail'),
											'shippingOrgId'			=> $row->shippingOrgId,
											'shippingRateId'		=> $row->shippingRateId,
											'customOrderId'			=> $customOrderIdCart[$row->cartId],
											'atATimeProduct'		=> $atATimeProduct,
											'colorId'				=> $row->colorId,
											'size'					=> $row->size,
											'isPickup'				=> 0,
											'pickupId'				=> 0,
											'payment_reference'     => '',
											'retrieval_reference'   => '',
											'transaction_reference' => '',
											'merchant_reference'	=> '',
											'transaction_date'	    => '',
											'paymentStatus'			=> 0,	
											'toDropshipId'			=> $row->toDropshipId,
											'retailerPrice'			=> $retailerPrice,
											'spacePointePrice'	    => $spacePointePrice,
											'cashAdminPrice'		=> $cashAdminPrice, 
											'cashAdminFee'			=> $cashAdminFee,
											'genuineShippFee'		=> $genuineShippFee,
											'categoryCommission'    => $categoryCommission,
											'marketingProductId'	=> $row->marketingProductId,
											'cashHandlingPrice'     => $cashHandlingPrice,
											'pickupProccessPrice'   => 0,
											'productWeight'      	=> $row->productWeight,
											'retailerDiscount'		=> $row->retailerDiscount,
											'freeShipCatId'		    => $row->freeShipCatId,
											'freeShipPrdId'	    	=> $row->freeShipPrdId,
											'productId'				=> $row->productId,
											'productImageId'		=> $row->productImageId,
											'isEconomicDelivery'    => 0,
											'inventoryHistoryId'	=> $row->inventoryHistoryId,
											'pointeForceVerifiedStatus'	=> $pointeForceVerifiedStatus,
											'spacepointeCommission2'	=> $row->spacePointePrice2,
											'totalCommissionPrice'      => $row->quantity*$row->spacePointePrice2,
										);
								//echo "<pre>"; print_r($orderArr); exit;
								$orderID  = $this->order_m->add_order($orderArr);
								$this->custom_log->write_log('custom_log','order inserted array is '.print_r($orderArr,true));
								$this->custom_log->write_log('custom_log','Created order id is '.$orderID);
								if($orderID)
								{
									/**********shipping address for customer*************/
									$shippCusAddId  = $this->session->userdata('shippingAddressId');
									$orderaddressId = $this->order_m->add_order_address($orderID,$shippCusAddId);
									/********shipping address for customer***************/
									
									/**********billing address for customer*************/
									$billCusDet = $this->customer_m->user_billing_details($this->session->userdata('userId'));
									$this->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
									$billCusAddId = 0;
									if(!empty($billCusDet))
									{
										$billCusAddId = $billCusDet->addressId;
									}
									else
									{
										$billCusAddId = $shippCusAddId;	
									}
									$this->order_m->add_billing_order_address($orderID,$billCusAddId);
									/********billing address for customer***************/
									
									$payOrderID  = $this->order_m->add_order_payment($orderID,$orderArr);
									$this->custom_log->write_log('custom_log','Payment order id is '.$payOrderID);
									if($payOrderID)
									{
										$orderTrackId = $this->order_m->add_order_track_details($orderID,1);
										$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
										
										$orderDropshipCenterId = $this->order_m->add_order_dropship_center($orderID,$orderArr);
										$this->custom_log->write_log('custom_log','order dropship center id is '.$orderDropshipCenterId);
										$freeShipOrderId = $this->order_m->add_order_free_shipping($orderID,$orderArr);
										$this->custom_log->write_log('custom_log','free shipping order id is '.$freeShipOrderId);
										
										if($this->order_m->reduce_product_quantity($row->organizationProductId,$row->quantity))
										{
											$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
											$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId);	
											if($row->colorId)
											{
												if($row->marketingProductId)
												{
													$this->order_m->reduce_product_color_quantity_from_marketing($row->marketingProductId,$row->colorId,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->marketingProductId.' and color id is '.$row->colorId);
												}
											}
											
											if($row->size)
											{
												if($row->marketingProductId)
												{
													$this->order_m->reduce_product_size_quantity_from_marketing($row->marketingProductId,$row->size,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from marketing product id is '.$row->organizationProductId.' and size is '.$row->size);	
												}
											}
											if((!empty($row->marketingProductId))&&($row->marketingProductId))
							{
							}
							elseif((!empty($row->organizationColorSizeId))&&($row->organizationColorSizeId))							
							{
								$this->order_m->reduce_orgnization_product_color_size_quantity($row->organizationColorSizeId,$row->quantity);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationColorSizeId);
							}
										}
							
										$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
										$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
										/***order History****************/
										$orderHistoryId = $this->order_m->add_order_history($orderID,1);
										$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
										/***Order History****************/
										
										$shippingVendor   = '';
										$estimateDay      = 0;
										
										$rateDetails      = $this->shipping_m->shipping_vendor_details($row->shippingRateId);
										$estimateDay      = $rateDetails->ETA+$this->config->item('estimated_time_increase');									
										$shippingVendor   = $rateDetails->organizationName;
										
										$customerShippDet = $this->customer_m->address_details($shippCusAddId);
										$shippingAddName  = $customerShippDet->firstName.' '.$customerShippDet->lastName;
										$shippingAddress  = $customerShippDet->addressLine1.' '.$customerShippDet->address_Line2.' '.$customerShippDet->cityName.','.$customerShippDet->areaName.' '.$customerShippDet->stateName.' - '.$customerShippDet->zip;
										$retailerDet = $this->order_m->order_retailer_with_product_details($row->organizationProductId);
										$imagePath = base_url().'img/no_image.jpg';
										if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
										{
											$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
										}
										$color = '';
										$size = '';
										
										$mailData = array(
														'email'           => $this->session->userdata('userEmail'),
														'cc'			  => '',
														'bcc'			  => 'neworders@spacepointe.com',
														'slug'            => 'order_placed_for_customer',
														'customerName'    => $this->session->userdata('userName'),
														'customerPhone'	  => $customerDetails->phone,
														'orderId'		  => $customOrderIdCart[$row->cartId],
														'eta'			  => $estimateDay,
														'shippingVendor'  => $shippingVendor,
														'shippingAddName' => $shippingAddName,
														'shippingAddress' => $shippingAddress,
														'sellerName'      => $retailerDet->organizationName,
														'imagePath'		  => $imagePath,
														'productName'	  => $retailerDet->code,
														'currentPrice'	  => number_format($displayPrice,2),
														'quantity'		  => $row->quantity,
														'subTotal'		  => number_format(($displayPrice*$row->quantity),2),
														'color'			  => $color,
														'size'			  => $size,
														'totalAmount'	  => number_format($displayPrice*$row->quantity,2),
														'subject'  		  => 'Your Order Has Been Placed',
													);
										if($this->email_m->send_mail($mailData))
										{
											$customer_order_message='Your order has been recieved for '.substr($retailerDet->code,0,15).', will be delivered in '.$estimateDay.' days';
	
											$response = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone,$customer_order_message);
	
											$this->custom_log->write_log('custom_log','send mail data is '.print_r($mailData,true));
											$this->custom_log->write_log('custom_log','Mail send successfully');
										}
										else
										{
											$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
										}
																				
										$mailData = array(														
														'email'           => 'neworders@spacepointe.com',
														'cc'			  => '',
														'bcc'			  => '',
														'slug'            => 'order_placed_for_customer',
														'customerName'    => $this->session->userdata('userName'),
														'customerPhone'	  => $customerDetails->phone,
														'orderId'		  => $customOrderIdCart[$row->cartId],
														'eta'			  => $estimateDay,
														'shippingVendor'  => $shippingVendor,
														'shippingAddName' => $shippingAddName,
														'shippingAddress' => $shippingAddress,
														'sellerName'      => $retailerDet->organizationName,
														'imagePath'		  => $imagePath,
														'productName'	  => $retailerDet->code,
														'currentPrice'	  => number_format($displayPrice,2),
														'quantity'		  => $row->quantity,
														'subTotal'		  => number_format(($displayPrice*$row->quantity),2),
														'color'			  => $color,
														'size'			  => $size,
														'totalAmount'	  => number_format($displayPrice*$row->quantity,2),
														'subject'  		  => 'Your Order Has Been Placed',
													);
										if($this->email_m->send_mail($mailData))
										{
											$this->custom_log->write_log('custom_log','send mail data is '.print_r($mailData,true));
											$this->custom_log->write_log('custom_log','Mail send successfully');
										}
										else
										{
											$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
										}
										
										/*********add order pointeforce commission***********/
										if((!empty($isPointeForce))&&($isPointeForce))
										{
											$orderPointeForceId = $this->order_m->add_order_pointe_force_commission($orderID,$orderArr);
											$this->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
										}
										/*********add order pointeforce commission***********/	
									}
									else
									{
										$this->session->set_flashdata('error',$this->lang->line('error_add_order'));
										$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_add_order'));
									}
								}
							}
	
							if(!empty($where))
							{
								$this->cart_m->remove_to_cart($where);							
							}
							$this->cart->destroy();
							$this->session->unset_userdata('isPickUp');
							$this->session->unset_userdata('isChkAvl');
							$this->session->unset_userdata('shippingAddressId');
							$this->session->set_flashdata('success','Order created successfully');
							$this->custom_log->write_log('custom_log','Order created successfully');
							redirect(base_url().'frontend/order/order_complete_success/'.id_encrypt($atATimeProduct));
						}
						else
						{
							$this->session->set_flashdata('error','Cart Details not found');
							$this->custom_log->write_log('custom_log','Cart Details not found');	
						}
					}
					else
					{
						redirect(base_url());
					}
				
				}
			}
			elseif((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==3))
			{
				$this->custom_log->write_log('custom_log','after submit form is '.print_r($_POST,true));
				$rules = check_captcha_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					//	Customer Information
					$customerDetails = $this->customer_m->get_customer_user_detail($userId);
					$contents   = $this->cart->contents();
					$total_cart = count($contents);
					if(!$total_cart)
					{
						$this->session->set_flashdata('error','cart list not found');
						$this->custom_log->write_log('custom_log','cart list not found');
						redirect(base_url());
					}
				
					if(!empty($contents))
					{
						$customOrderIdCart = array();
						$customOrderIdRet = array();
						$mailContaint = '';
						$amount = 0;
						$atATimeProduct = 0;
						if(!empty($cartDetails))
						{
							$atATimeProduct = $this->checkout_lib->cash_on_delivery_add_to_cart_same_day_delivery($cartDetails);
							$this->custom_log->write_log('custom_log','at a time product id is '.$atATimeProduct);
						
							foreach($cartDetails as $row)
							{							
								$retailerDet = $this->order_m->order_retailer_details($row->organizationProductId);
								if(!empty($retailerDet))
								{
									$cusOrderId    = $this->config->item('add_orderId');
									$cusOrderId	   = $cusOrderId+$row->cartId;
									$customOrderId = $this->config->item('pre_orderId').$cusOrderId;
									$customOrderIdRet[$retailerDet->organizationId] = $customOrderId;
									$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
								}
								
							}
							$this->custom_log->write_log('custom_log','custom order id array is '.print_r($customOrderIdRet,true));
							foreach($cartDetails as $row)
							{
								$retailerDet = $this->order_m->order_retailer_details($row->organizationProductId);
								if(!empty($retailerDet))
								{
									$productWeight      = $row->productWeight;
									$displayPrice       = $row->productAmt;
									$spacePointePrice   = $row->spacePointePrice;
									$cashAdminPrice     = $row->cashAdminPrice;
									$cashAdminFee       = $row->cashAdminFee;
									$categoryCommission = $row->categoryCommission;
									$genuineShippFee    = $row->genuineShippFee;
									$shipping_rate      = 0;
									
									if($row->freeShipPrdId)
									{
									}
									elseif($row->freeShipCatId)
									{
									}
									elseif($genuineShippFee)
									{	
										$shippingRate = $row->shippingRate;
										if($productWeight>10)
										{
											$shippingRate = $row->shippingRate*$productWeight;
										}
										$shipping_rate = $shipping_rate+($row->quantity*$shippingRate);
									}
									$customOrderIdCart[$row->cartId] = $customOrderIdRet[$retailerDet->organizationId];
									$amount = $amount+($displayPrice*$row->quantity)+$shipping_rate;
								}
							}
						}
						$this->custom_log->write_log('custom_log','at a time purchase id is '.$atATimeProduct);
						
						$handlingPrice = ($amount*$this->config->item('space_point_comission'))/100;
						$this->custom_log->write_log('custom_log','Cash Handling Price is '.$handlingPrice);
						
						$amount = $amount+$handlingPrice;
						$this->custom_log->write_log('custom_log','Total AMount is '.$amount);
						
						$this->custom_log->write_log('custom_log','result array is '.print_r($cartDetails,true));
						if(!empty($cartDetails))
						{
							foreach($cartDetails as $row)
							{
								$productId     		= $row->productId;
								$retailerPrice 		= $row->retailerPrice;
								$productWeight 		= $row->weight+$row->shippingWeight;		                    	
								$spacePointePrice   = $row->spacePointePrice;
								$cashAdminPrice     = $row->cashAdminPrice;
								$cashAdminFee       = $row->cashAdminFee;
								$categoryCommission = $row->categoryCommission;
								$genuineShippFee    = $row->genuineShippFee;
								$displayPrice 		= $row->productAmt;							
								$shipping_rate		= 0;
								$cashHandlingPrice  = 0;
								
								if($row->freeShipPrdId)
								{
								}
								elseif($row->freeShipCatId)
								{
								}
								elseif($row->genuineShippFee)
								{	
									$shipping_rate = $row->shippingRate*$row->quantity;
									if($productWeight>10)
									{
										$shipping_rate = $row->shippingRate*$row->quantity*$productWeight;
									}
								}	
								$this->custom_log->write_log('custom_log','Shipping Rate is '.$shipping_rate);
								$ttlAmt = ($row->quantity*$displayPrice)+$shipping_rate;
								$this->custom_log->write_log('custom_log','total amount after calculate shipping rate = '.$ttlAmt);
								
								$cashHandlingPrice = ($ttlAmt*$this->config->item('space_point_comission'))/100; 
								$this->custom_log->write_log('custom_log','cash Handling amount of total amout is '.$cashHandlingPrice);
	
								$orderArr = array(
											'orderTypeId'           => 2,										
											'totalAmount'           => $amount,
											'customerId'            => $this->session->userdata('userId'),
											'quantity'				=> $row->quantity,
											'chargedAmount'			=> $displayPrice,
											'organizationProductId' => $row->organizationProductId,
											'orderStatusId'         => 1,										
											'orderEmail'       		=> $this->session->userdata('userEmail'),
											'shippingOrgId'			=> $row->shippingOrgId,
											'shippingRateId'		=> $row->shippingRateId,
											'customOrderId'			=> $customOrderIdCart[$row->cartId],
											'atATimeProduct'		=> $atATimeProduct,
											'colorId'				=> $row->colorId,
											'size'					=> $row->size,
											'isPickup'				=> 0,
											'pickupId'				=> 0,
											'payment_reference'     => '',
											'retrieval_reference'   => '',
											'transaction_reference' => '',
											'merchant_reference'	=> '',
											'transaction_date'	    => '',
											'paymentStatus'			=> 0,	
											'toDropshipId'			=> $row->toDropshipId,
											'retailerPrice'			=> $retailerPrice,
											'spacePointePrice'	    => $spacePointePrice,
											'cashAdminPrice'		=> $cashAdminPrice, 
											'cashAdminFee'			=> $cashAdminFee,
											'genuineShippFee'		=> $genuineShippFee,
											'categoryCommission'    => $categoryCommission,
											'marketingProductId'	=> $row->marketingProductId,
											'cashHandlingPrice'     => $cashHandlingPrice,
											'pickupProccessPrice'   => 0,
											'productWeight'      	=> $row->productWeight,
											'retailerDiscount'		=> $row->retailerDiscount,
											'freeShipCatId'		    => $row->freeShipCatId,
											'freeShipPrdId'	    	=> $row->freeShipPrdId,
											'productId'				=> $row->productId,
											'productImageId'		=> $row->productImageId,
											'isEconomicDelivery'    => 0,
											'inventoryHistoryId'	=> $row->inventoryHistoryId,
											'pointeForceVerifiedStatus'	=> $pointeForceVerifiedStatus,
											'spacepointeCommission2'	=> $row->spacePointePrice2,
											'totalCommissionPrice'      => $row->quantity*$row->spacePointePrice2,
										);
								//echo "<pre>"; print_r($orderArr); exit;
								$orderID  = $this->order_m->add_order($orderArr);
								$this->custom_log->write_log('custom_log','order inserted array is '.print_r($orderArr,true));
								$this->custom_log->write_log('custom_log','Created order id is '.$orderID);
								if($orderID)
								{
									/**********shipping address for customer*************/
									$shippCusAddId  = $this->session->userdata('shippingAddressId');
									$orderaddressId = $this->order_m->add_order_address($orderID,$shippCusAddId);
									/********shipping address for customer***************/
									
									/**********billing address for customer*************/
									$billCusDet = $this->customer_m->user_billing_details($this->session->userdata('userId'));
									$this->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
									$billCusAddId = 0;
									if(!empty($billCusDet))
									{
										$billCusAddId = $billCusDet->addressId;
									}
									else
									{
										$billCusAddId = $shippCusAddId;	
									}
									$this->order_m->add_billing_order_address($orderID,$billCusAddId);
									/********billing address for customer***************/
									
									$payOrderID  = $this->order_m->add_order_payment($orderID,$orderArr);
									$this->custom_log->write_log('custom_log','Payment order id is '.$payOrderID);
									if($payOrderID)
									{
										$orderTrackId = $this->order_m->add_order_track_details($orderID,1);
										$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
										
										$orderDropshipCenterId = $this->order_m->add_order_dropship_center($orderID,$orderArr);
										$this->custom_log->write_log('custom_log','order dropship center id is '.$orderDropshipCenterId);
										$freeShipOrderId = $this->order_m->add_order_free_shipping($orderID,$orderArr);
										$this->custom_log->write_log('custom_log','free shipping order id is '.$freeShipOrderId);
										
										if($this->order_m->reduce_product_quantity($row->organizationProductId,$row->quantity))
										{
											$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
											$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId);	
											if($row->colorId)
											{
												if($row->marketingProductId)
												{
													$this->order_m->reduce_product_color_quantity_from_marketing($row->marketingProductId,$row->colorId,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->marketingProductId.' and color id is '.$row->colorId);
												}
											}
											
											if($row->size)
											{
												if($row->marketingProductId)
												{
													$this->order_m->reduce_product_size_quantity_from_marketing($row->marketingProductId,$row->size,$row->quantity);
													$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
													$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from marketing product id is '.$row->organizationProductId.' and size is '.$row->size);	
												}
											}
											if((!empty($row->marketingProductId))&&($row->marketingProductId))
							{
							}
							elseif((!empty($row->organizationColorSizeId))&&($row->organizationColorSizeId))							
							{
								$this->order_m->reduce_orgnization_product_color_size_quantity($row->organizationColorSizeId,$row->quantity);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationColorSizeId);
							}
										}
							
										$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
										$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
										/***order History****************/
										$orderHistoryId = $this->order_m->add_order_history($orderID,1);
										$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
										/***Order History****************/
										
										$shippingVendor   = '';
										$estimateDay      = 0;
										
										$rateDetails      = $this->shipping_m->shipping_vendor_details($row->shippingRateId);
										$estimateDay      = $rateDetails->ETA+$this->config->item('estimated_time_increase');									
										$shippingVendor   = $rateDetails->organizationName;
										
										$customerShippDet = $this->customer_m->address_details($shippCusAddId);
										$shippingAddName  = $customerShippDet->firstName.' '.$customerShippDet->lastName;
										$shippingAddress  = $customerShippDet->addressLine1.' '.$customerShippDet->address_Line2.' '.$customerShippDet->cityName.','.$customerShippDet->areaName.' '.$customerShippDet->stateName.' - '.$customerShippDet->zip;
										$retailerDet = $this->order_m->order_retailer_with_product_details($row->organizationProductId);
										$imagePath = base_url().'img/no_image.jpg';
										if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
										{
											$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
										}
										$color = '';
										$size = '';
										
										$mailData = array(
														'email'           => $this->session->userdata('userEmail'),
														'cc'			  => '',
														'bcc'			  => 'neworders@spacepointe.com',
														'slug'            => 'order_placed_for_customer',
														'customerName'    => $this->session->userdata('userName'),
														'customerPhone'	  => $customerDetails->phone,
														'orderId'		  => $customOrderIdCart[$row->cartId],
														'eta'			  => $estimateDay,
														'shippingVendor'  => $shippingVendor,
														'shippingAddName' => $shippingAddName,
														'shippingAddress' => $shippingAddress,
														'sellerName'      => $retailerDet->organizationName,
														'imagePath'		  => $imagePath,
														'productName'	  => $retailerDet->code,
														'currentPrice'	  => number_format($displayPrice,2),
														'quantity'		  => $row->quantity,
														'subTotal'		  => number_format(($displayPrice*$row->quantity),2),
														'color'			  => $color,
														'size'			  => $size,
														'totalAmount'	  => number_format($displayPrice*$row->quantity,2),
														'subject'  		  => 'Your Order Has Been Placed',
													);
										if($this->email_m->send_mail($mailData))
										{
											$customer_order_message='Your order has been recieved for '.substr($retailerDet->code,0,15).', will be delivered in '.$estimateDay.' days';
	
											$response = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone,$customer_order_message);
	
											$this->custom_log->write_log('custom_log','send mail data is '.print_r($mailData,true));
											$this->custom_log->write_log('custom_log','Mail send successfully');
										}
										else
										{
											$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
										}
																				
										$mailData = array(														
														'email'           => 'neworders@spacepointe.com',
														'cc'			  => '',
														'bcc'			  => '',
														'slug'            => 'order_placed_for_customer',
														'customerName'    => $this->session->userdata('userName'),
														'customerPhone'	  => $customerDetails->phone,
														'orderId'		  => $customOrderIdCart[$row->cartId],
														'eta'			  => $estimateDay,
														'shippingVendor'  => $shippingVendor,
														'shippingAddName' => $shippingAddName,
														'shippingAddress' => $shippingAddress,
														'sellerName'      => $retailerDet->organizationName,
														'imagePath'		  => $imagePath,
														'productName'	  => $retailerDet->code,
														'currentPrice'	  => number_format($displayPrice,2),
														'quantity'		  => $row->quantity,
														'subTotal'		  => number_format(($displayPrice*$row->quantity),2),
														'color'			  => $color,
														'size'			  => $size,
														'totalAmount'	  => number_format($displayPrice*$row->quantity,2),
														'subject'  		  => 'Your Order Has Been Placed',
													);
										if($this->email_m->send_mail($mailData))
										{
											$this->custom_log->write_log('custom_log','send mail data is '.print_r($mailData,true));
											$this->custom_log->write_log('custom_log','Mail send successfully');
										}
										else
										{
											$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
										}
										
										/*********add order pointeforce commission***********/
										if((!empty($isPointeForce))&&($isPointeForce))
										{
											$orderPointeForceId = $this->order_m->add_order_pointe_force_commission($orderID,$orderArr);
											$this->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
										}
										/*********add order pointeforce commission***********/	
									}
									else
									{
										$this->session->set_flashdata('error',$this->lang->line('error_add_order'));
										$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_add_order'));
									}
								}
							}
	
							if(!empty($where))
							{
								$this->cart_m->remove_to_cart($where);							
							}
							$this->cart->destroy();
							$this->session->unset_userdata('isPickUp');
							$this->session->unset_userdata('isChkAvl');
							$this->session->unset_userdata('shippingAddressId');
							$this->session->set_flashdata('success','Order created successfully');
							$this->custom_log->write_log('custom_log','Order created successfully');
							redirect(base_url().'frontend/order/order_complete_success/'.id_encrypt($atATimeProduct));
						}
						else
						{
							$this->session->set_flashdata('error','Cart Details not found');
							$this->custom_log->write_log('custom_log','Cart Details not found');	
						}
					}
					else
					{
						redirect(base_url());
					}
				
				}
			}
			else
			{
				$this->custom_log->write_log('custom_log','shipping address After Form Submit '.print_r($_POST,true));
				$rules = shipping_rules();
				
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$result['firstName'] = $this->input->post('firstName');
					$result['lastName']  = $this->input->post('lastName');
					$result['address1']  = $this->input->post('address1');
					$result['address2']  = $this->input->post('address2');
					$result['phoneNo']   = $this->input->post('phoneNo');
					$result['zipcode']   = 0;
					$result['stateId']   = $this->input->post('stateId');
					$result['areaId']    = $this->input->post('areaId');
					$result['cityId']    = $this->input->post('cityId');
					$result['countryId'] = 154;
					$showEconomicDel     = 0;
					$sameRetailer        = array();
					foreach($cartDetails as $row)
					{
						if(!empty($sameRetailer[$row->organizationId]['totalPrd']))
						{
							$sameRetailer[$row->organizationId]['totalPrd'] = $sameRetailer[$row->organizationId]['totalPrd']+1;
						}
						else
						{
							$sameRetailer[$row->organizationId]['totalPrd'] = 1;
						}
											
						if((!empty($sameRetailer[$row->organizationId]['totalPrd']))&&($sameRetailer[$row->organizationId]['totalPrd']>1))
						{
							$showEconomicDel = 1;
						}
						if($row->quantity>1)
						{
							$showEconomicDel = 1;
						}
											
						$dropshipId  = $row->toDropshipId;
						$totalWeight = $row->productWeight;
						$stateId	 = $result['stateId'];
						$areaId	     = $result['areaId'];
						$cityId		 = $result['cityId'];
						$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);
						$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
						
						if(!empty($shipRateDet))
						{
							if($this->cart_m->update_shipping_address_buy_now_delivery($row->cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId))
							{
								$this->cart_m->update_buy_now_delivery($row->cartId);
								$this->custom_log->write_log('custom_log','updated cart as buy now delivery');
							}
							else
							{
								$this->session->set_flashdata('error','Shipping details not update in buy now cart');
								$this->custom_log->write_log('custom_log','Shipping details not update in buy now cart');
								redirect(base_url().'frontend/product_cart/shipping_address');
							}
						}
						else
						{
							$this->session->set_flashdata('error','Shipping vendor not available in your city');
							$this->custom_log->write_log('custom_log','Shipping vendor not available in your city');
							redirect(base_url().'frontend/product_cart/shipping_address');
						}
					}
					
					$this->customer_m->delete_old_shipping_address($userId);
					$addressId = $this->customer_m->add_shippBill_address($result);
					$this->custom_log->write_log('custom_log','address id is '.$addressId);
					
					$this->session->set_userdata('shippingAddressId',$addressId); 
					$this->custom_log->write_log('custom_log','set session shipping address id is '.$addressId);
					if($addressId)
					{
						$this->customer_m->add_shipping_address_type($userId,$addressId);
						$this->session->set_flashdata('success','Shipping infomation added successfully');
						$this->custom_log->write_log('custom_log','Shipping infomation added successfully');
					}
					else
					{
						$this->session->set_flashdata('error','Shipping information not add');
						$this->custom_log->write_log('custom_log','Shipping information not add');
					}											
					redirect(base_url().'frontend/product_cart/shipping_address');
				}
			}
		}
		
		$shippCusAddId  = $this->session->userdata('shippingAddressId');
		$shippCusDet    = $this->customer_m->address_details($shippCusAddId);
		$allShippCusAdd = $this->customer_m->all_shipping_details($userId);
		
		$this->data['stateList']      = $this->location_m->nigeria_state_list();
		$this->data['cartDetails']    = $cartDetails;
		$this->data['shippCusDet']    = $shippCusDet;
		$this->data['allShippCusAdd'] = $allShippCusAdd;
		$this->data['shippCusAddId']  = $shippCusAddId;
		$this->frontendCustomView('product_cart/shipping_address',$this->data);
	}
	
	public function alpha_numeric_space_val()
	{
		$str = $this->input->post('address1');
		if(is_numeric($str))
		{
		 	$this->form_validation->set_message('alpha_numeric_space_val', 'The %s field cannot have only numeric values.');
			return FALSE;
		}
		else
		{
			return TRUE;			
		}
	}
	
	public function check_shipping_delivery_here($addressId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'check_shipping_delivery_here',
                'log_MID'    => ''
		) );
		
		$addressId = id_decrypt($addressId);
		$this->custom_log->write_log('custom_log','Shipping address id is '.$addressId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$addressId)
		{
			$this->session->set_flashdata('error','address id not found');
			$this->custom_log->write_log('custom_log','address id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$shippCusDet = $this->customer_m->address_details($addressId);
		$this->custom_log->write_log('custom_log','shipping address details is '.print_r($shippCusDet,true));
		if(empty($shippCusDet))
		{
			$this->session->set_flashdata('error','shipping address not found');
			$this->custom_log->write_log('custom_log','shipping address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$showEconomicDel = 0;
		$sameRetailer    = array();
				
		foreach($cartDetails as $row)
		{
			if(!empty($sameRetailer[$row->organizationId]['totalPrd']))
			{
				$sameRetailer[$row->organizationId]['totalPrd'] = $sameRetailer[$row->organizationId]['totalPrd']+1;
			}
			else
			{
				$sameRetailer[$row->organizationId]['totalPrd'] = 1;
			}
										
			if((!empty($sameRetailer[$row->organizationId]['totalPrd']))&&($sameRetailer[$row->organizationId]['totalPrd']>1))
			{
				$showEconomicDel = 1;
			}
			if($row->quantity>1)
			{
				$showEconomicDel = 1;
			}
					
			$dropshipId  = $row->toDropshipId;
			$totalWeight = $row->productWeight;
			$stateId	 = $shippCusDet->state;
			$areaId	     = $shippCusDet->area;
			$cityId		 = $shippCusDet->city;
			$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);
			$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
		
			if(!empty($shipRateDet))
			{
				if($this->cart_m->update_shipping_address_buy_now_delivery($row->cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId))
				{
					$this->cart_m->update_buy_now_delivery($row->cartId);
					$this->custom_log->write_log('custom_log','updated cart as buy now delivery');
				}
				else
				{
					$this->session->set_flashdata('error','Shipping details not update in buy now cart');
					$this->custom_log->write_log('custom_log','Shipping details not update in buy now cart');
				}
			}
			else
			{
				$this->session->set_flashdata('error','Shipping vendor not available in your city');
				$this->custom_log->write_log('custom_log','Shipping vendor not available in your city');
				redirect(base_url().'frontend/product_cart/shipping_address');
			}
		}	
		
		if($this->customer_m->delete_old_shipping_address($userId))
		{
			if($this->customer_m->activate_shipping_address($userId,$addressId))
			{
				$this->session->set_userdata('shippingAddressId',$addressId); 
				$this->custom_log->write_log('custom_log','set session shipping address id is '.$addressId);
			}
			else
			{
				$this->session->set_flashdata('error','Shipping address activate');
				$this->custom_log->write_log('custom_log','Shipping address activate');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Shipping old address not update');
			$this->custom_log->write_log('custom_log','Shipping old address not update');
		}
		redirect(base_url().'frontend/product_cart/shipping_address');
	}
	
	public function order_add_to_cart_delivery()
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_add_to_cart_delivery',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);

		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');			
			redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$cartDetails = '';
		
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$shippCusDet    			= $this->customer_m->address_details($shippCusAddId);
		$this->data['shippCusDet']  = $shippCusDet;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['purchaseFrom'] = 1;
		$this->data['isPickUp']     = 0;
		$this->data['payOnPickUp']  = 0;
		$this->data['isEconomicDelivery'] = 0;
		$this->data['productTypeId'] = 0;
		$this->frontendCustomView('checkout/order',$this->data);	
	}
	
	public function pickup_address()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'pickup_address',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Pickup Address';
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$this->data['stateList']   = $this->location_m->pickup_state_list();
		$this->data['cartDetails'] = $cartDetails;
		$this->data['pickUpStateId'] = 12;
		$pickupId = 0;
		if(!empty($cartDetails))
		{
			$pickupId = $cartDetails[0]->pickupId;		
		}
		
		$pickupAddress = '';
		if($pickupId)
		{			
			$pickupAddress = $this->retailer_m->pickup_address_details($pickupId);
			$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
			$this->data['pickUpStateId'] = $pickupAddress->state;
		}
		
		$this->data['pickupAddress'] = $pickupAddress;
		$this->data['pickupId']	     = $pickupId;
		//echo "<pre>"; print_r($pickupAddress); exit;
		$this->frontendCustomView('product_cart/pickup_address',$this->data);
	}
	
	public function pickup_list()
	{
    	$stateId  = $this->input->post('stateId');
		$pickupId = $this->input->post('pickupId');
        $this->data['pickUpList'] = $this->retailer_m->pickup_with_address_list_states($stateId);
		$this->data['pickupId']   = $pickupId;
        echo $this->load->view('product_cart/pickup_list',$this->data);
	}
	
	public function check_pickup_here($pickupId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'check_pickup_here',
                'log_MID'    => ''
		) );
		
		$pickupId = id_decrypt($pickupId);
		$this->custom_log->write_log('custom_log','pickup id is '.$pickupId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$pickupId)
		{
			$this->session->set_flashdata('error','Pick address id not found');
			$this->custom_log->write_log('custom_log','Pick address id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/pickup_address');
		}
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url().'frontend/product_cart/pickup_address');
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/pickup_address');
		}
		
		$pickupAddress = $this->retailer_m->pickup_address_details($pickupId);
		$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
		if(empty($pickupAddress))		
		{		
			$this->session->set_flashdata('error','Pickup address details not found');
			$this->custom_log->write_log('custom_log','Pickup address details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/pickup_address');		
		}
		$pickupAddressLine1 = $pickupAddress->addressLine1;
		$pickUpStateId	    = $pickupAddress->state;
		$pickUpAreaId	    = $pickupAddress->area;
		$pickUpCityId	    = $pickupAddress->city;		
		$payOnPickUp 		= 1;
		
		foreach($cartDetails as $row)
		{
			if($this->cart_m->change_pickup_address($row->cartId,$pickupId))
			{
				$this->custom_log->write_log('custom_log','Pickup address id add in cart id '.$row->cartId);
				if(!empty($pickupAddressLine1))
				{
					$checkDropshipAress = $this->cart_m->dropshipDetails($row->toDropshipId);
					$this->custom_log->write_log('custom_log','dropship details is '.print_r($checkDropshipAress,true));
						
					if(!empty($checkDropshipAress))
					{
						$dropShipAdd1 = $checkDropshipAress->addressLine1;
						$this->custom_log->write_log('custom_log','Condition is (!empty('.$dropShipAdd1.'))&&(!empty('.$pickupAddressLine1.'))&&('.$pickupAddressLine1.'=='.$dropShipAdd1.')');
						
						if((!empty($dropShipAdd1))&&(!empty($pickupAddressLine1))&&($pickupAddressLine1==$dropShipAdd1))
						{
							if($payOnPickUp==0)
							{
								$payOnPickUp = 0;
							}
							else
							{
								$payOnPickUp = 2;
							}
						}
						else
						{
							$payOnPickUp = 0;
						}
						
						if((!empty($pickUpCityId))&&($pickUpCityId))
						{
							$shipRateDet = $this->shipping_m->check_avaibility($row->toDropshipId,$pickUpStateId,$pickUpAreaId,$pickUpCityId,$row->productWeight);
							$this->custom_log->write_log('custom_log','according pickup city id Shipping rate details is '.print_r($shipRateDet,true));
						}
						elseif((!empty($pickUpAreaId))&&($pickUpAreaId))
						{
							$shipRateDet = $this->shipping_m->check_avaibility_area($row->toDropshipId,$pickUpStateId,$pickUpAreaId,$row->productWeight);
							$this->custom_log->write_log('custom_log','according pickup area id Shipping rate details is '.print_r($shipRateDet,true));
						}
						elseif((!empty($pickUpStateId))&&($pickUpStateId))
						{
							$shipRateDet = $this->shipping_m->check_avaibility_state($row->toDropshipId,$pickUpStateId,$row->productWeight);
							$this->custom_log->write_log('custom_log','according pickup state id Shipping rate details is '.print_r($shipRateDet,true));
						}
						
						if((!empty($shipRateDet))&&($shipRateDet))
						{
							$this->cart_m->update_shipping_address_buy_now_delivery($row->cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId);
							$this->custom_log->write_log('custom_log','shipping vendor and shipping rate updated in cart id is '.$cartId.' and shipping organization id is '.$shipRateDet->shippingOrgId.' and shipping rate id is '.$shipRateDet->shippingRateId);
						}
						
					}
					$this->custom_log->write_log('custom_log','Pay on pickup is '.$payOnPickUp);
				}
			}		
			else
			{
				$this->session->set_flashdata('error','Pick address not add in cart');
				$this->custom_log->write_log('custom_log','Pick address not add in cart');
				redirect(base_url().'frontend/product_cart/pickup_address');
			}	
		}		
	
		$this->session->set_userdata('isPickUp',1);							
		$this->session->set_flashdata('success','Pick address added in cart successfully');
		$this->custom_log->write_log('custom_log','Pick address added in cart successfully');
		
		/*if($payOnPickUp==2)
		{
			redirect(base_url().'frontend/product_cart/pay_on_pickup_pay_online');
		}
		else
		{*/
			redirect(base_url().'frontend/product_cart/order_add_to_cart_pickup');
		//}
		redirect(base_url().'frontend/product_cart/pickup_address');
	}
	
	public function order_add_to_cart_pickup()
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_add_to_cart_pickup',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		$pickUpStateId       = 0;
		$pickupProccessPrice = 0;
		$payOnPickUp		 = 0;
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url().'frontend/product_cart/pickup_address');
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_page_detail_list_for_pickup($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/pickup_address');
		}
		
		
		$pickUpId  = $cartDetails[0]->pickupId;
		$pickUpDet = $this->cart_m->pickupDetails($pickUpId);
		$this->custom_log->write_log('custom_log','Pickup details is '.print_r($pickUpDet,true));
		
		$pickUpAddress1 = '';
		$pickUpStateId  = 0;
		
		if(!empty($pickUpDet))
		{
			$pickUpAddress1 = $pickUpDet->addressLine1;
			$pickUpStateId  = $pickUpDet->state;
		}
		
		$productTypeId    = 0;
		foreach($cartDetails as $row)
		{
			if((!empty($row->productTypeId))&&($row->productTypeId==3))
			{
				$productTypeId = 3;
			}

			$productWeight = $row->productWeight;
			$pickupProccessPrice = 0;		
			if($row->genuineShippFee)
			{
				$checkDropshipAress = $this->cart_m->dropshipDetails($row->toDropshipId);	
				$this->custom_log->write_log('custom_log','dropship address details is '.print_r($checkDropshipAress,true));
				$dropShipAdd1 = '';
				if(!empty($checkDropshipAress))
				{
					$dropShipAdd1 = $checkDropshipAress->addressLine1;
				}
			
				if((!empty($dropShipAdd1))&&(!empty($pickUpAddress1))&&($pickUpAddress1==$dropShipAdd1))
				{
					$pickupProccessPrice = ($row->productAmt*3)/100;
				}
				elseif((!empty($checkDropshipAress->state))&&(!empty($pickUpStateId))&&($checkDropshipAress->state==$pickUpStateId))
				{
					$maxDet = $this->shipping_m->max_rate_from_dropship_to_pickup_state($row->toDropshipId,$pickUpStateId,$productWeight);
					$this->custom_log->write_log('custom_log','Maximum amount is '.print_r($maxDet,true));
					if(!empty($maxDet))
					{
						if($productWeight>10)
						{
							$pickupProccessPrice = $maxDet->amount*$productWeight;												
						}
						else
						{
							$pickupProccessPrice = $maxDet->amount;
						}
					}
				}
				elseif((!empty($checkDropshipAress->state))&&(!empty($pickUpStateId))&&($checkDropshipAress->state!=$pickUpStateId))
				{
					$maxDet = $this->shipping_m->max_rate_from_dropship_to_pickup_state($row->toDropshipId,$pickUpStateId,$productWeight);
					$this->custom_log->write_log('custom_log','Maximum amount is '.print_r($maxDet,true));
					if(!empty($maxDet))
					{
						if($productWeight>10)
						{
							$pickupProccessPrice = $maxDet->amount*$productWeight;										
						}
						else
						{
							$pickupProccessPrice = $maxDet->amount;
						}										
					}
				}	
			}
			elseif($row->cashAdminFee)
			{								
				if((!empty($checkDropshipAress->state))&&(!empty($pickUpStateId))&&($checkDropshipAress->state!=$pickUpStateId))
				{
					$maxDet = $this->shipping_m->max_rate_from_dropship_to_pickup_state($row->toDropshipId,$pickUpStateId,$productWeight);
					$this->custom_log->write_log('custom_log','Maximum amount is '.print_r($maxDet,true));
					if(!empty($maxDet))
					{
						if($productWeight>10)
						{
							$pickupProccessPrice = $maxDet->amount*$productWeight;										
						}
						else
						{
							$pickupProccessPrice = $maxDet->amount;
						}
						$cashAdminPrice = $row->cashAdminPrice;
						$calculateAmt = $pickupProccessPrice-$cashAdminPrice;
						$this->custom_log->write_log('custom_log','calculate amount is '.$calculateAmt.' pickup processing price is '.$pickupProccessPrice.'- cash admin prices is '.$cashAdminPrice);
						if($calculateAmt>0)
						{
							$pickupProccessPrice = $calculateAmt;
						}
						else
						{
							$pickupProccessPrice = 0;
						}
						$pickupProccessPrice = $pickupProccessPrice;
					}
				}
			}
		
			$this->custom_log->write_log('custom_log','Pick up processing fee is '.$pickupProccessPrice);
			if($this->cart_m->update_pickup_processing_price($row->cartId,$pickupProccessPrice))
			{
				$this->custom_log->write_log('custom_log','Pick up processing fee updated');
			}			
		}
		
		$cartDetails = $this->cart_m->cart_page_detail_list_for_pickup($where);
		$this->custom_log->write_log('custom_log','Cart details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
            redirect(base_url().'frontend/product_cart/pickup_address');
		}
		
		$pickupId = 0;
		if(!empty($cartDetails))
		{
			$pickupId = $cartDetails[0]->pickupId;		
		}
		
		$pickupAddress = '';
		if($pickupId)
		{
			$pickupAddress = $this->retailer_m->pickup_address_details($pickupId);	
		}
		
		$this->data['payOnPickUp']   	  = $payOnPickUp;		
		$this->data['purchaseFrom']  	  = 1;
		$this->data['pickUpStateId'] 	  = $pickUpStateId;
		$this->data['isPickUp']      	  = 1;
		$this->data['cartDetails']   	  = $cartDetails;
		$this->data['pickupAddress'] 	  = $pickupAddress;
		$this->data['isEconomicDelivery'] = 0;
		$this->data['productTypeId']	  = $productTypeId;
		$this->frontendCustomView('checkout/order',$this->data);	
	}
	
	public function pay_on_pickup_pay_online()
	{		
		$this->session->set_userdata(array(
                'log_MODULE' => 'pay_on_pickup_pay_online',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Pickup Address';
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$this->data['stateList']   = $this->location_m->pickup_state_list();
		$this->data['cartDetails'] = $cartDetails;
		$this->data['pickUpStateId'] = 12;
		$pickupId = 0;
		if(!empty($cartDetails))
		{
			$pickupId = $cartDetails[0]->pickupId;		
		}
		
		$pickupAddress = '';
		if($pickupId)
		{			
			$pickupAddress = $this->retailer_m->pickup_address_details($pickupId);
			$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
			$this->data['pickUpStateId'] = $pickupAddress->state;
		}
		
		$this->data['pickupAddress'] = $pickupAddress;
		$this->data['pickupId']      = $pickupId;
		//echo "<pre>"; print_r($pickupAddress); exit;
		$this->frontendCustomView('product_cart/pay_on_pickup_pay_online',$this->data);
	}
	
	public function order_add_to_cart_economic_delivery()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_add_to_cart_economic_delivery',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);

		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');			
			redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		$shippCusDet = $this->customer_m->address_details($shippCusAddId);
		$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		else
		{
			$retailerCart = array();
			$retailerPrdWtArr = array();
			foreach($cartDetails as $cartRow)
			{
				$retailerCart[$cartRow->organizationId]['retailerId']   = $cartRow->organizationId;
				$retailerCart[$cartRow->organizationId]['toDropshipId'] = $cartRow->toDropshipId;
				
				if((!empty($retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight']))&&($retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight']))
				{
					$retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight'] = $retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight']+($cartRow->productWeight*$cartRow->quantity);
				}
				else
				{
					$retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight'] = $cartRow->productWeight*$cartRow->quantity;
				}
				
				if($cartRow->freeShipPrdId)
				{
				}
				elseif($cartRow->freeShipCatId)
				{
				}
				elseif($cartRow->genuineShippFee)
				{
					if((!empty($retailerCart[$cartRow->organizationId]['totalProductWeight']))&&($retailerCart[$cartRow->organizationId]['totalProductWeight']))
					{
						$retailerCart[$cartRow->organizationId]['totalProductWeight'] = $retailerCart[$cartRow->organizationId]['totalProductWeight']+($cartRow->productWeight*$cartRow->quantity);
					}
					else
					{
						$retailerCart[$cartRow->organizationId]['totalProductWeight'] = $cartRow->productWeight*$cartRow->quantity;
					}
				}
			}
			//echo "<pre>"; print_r($retailerCart);
			//echo "<pre>"; print_r($retailerPrdWtArr); exit;
			$this->custom_log->write_log('custom_log','retailer array is '.print_r($retailerCart,true));
						
			if(!empty($retailerCart))
			{
				$flag = 0;
				foreach($retailerCart as $retailerKey=>$retailerRow)
				{
					$dropshipId  = $retailerRow['toDropshipId'];
					$stateId	 = $shippCusDet->state;
					$areaId	     = $shippCusDet->area;
					$cityId		 = $shippCusDet->city;					
					
					if(!empty($retailerRow['totalProductWeight']))
					{
						$totalWeight = $retailerRow['totalProductWeight'];
						$stateId	 = $shippCusDet->state;
						$areaId	     = $shippCusDet->area;
						$cityId		 = $shippCusDet->city;
						$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
						$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
						
						if(!empty($shipRateDet))
						{
							$retailerCart[$retailerKey]['finalShippingOrgId']  = $shipRateDet->shippingOrgId;
							$retailerCart[$retailerKey]['finalShippingRateId'] = $shipRateDet->shippingRateId;
							$retailerCart[$retailerKey]['isCalculateShipp']    = 1;
						}
						else
						{
							$this->session->set_flashdata('error','Shipping vendor not available in your city');
							$this->custom_log->write_log('custom_log','Shipping vendor not available in your city');
							redirect(base_url().'frontend/product_cart/shipping_address');
						}
					}					
					elseif(!empty($retailerPrdWtArr[$retailerKey]['totalProductWeight']))
					{
						$totalWeight = $retailerPrdWtArr[$retailerKey]['totalProductWeight'];						
						$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
						$retailerCart[$retailerKey]['totalProductWeight']  = $totalWeight;
						$this->custom_log->write_log('custom_log','free Shipping rate details is '.print_r($shipRateDet,true));
						if(!empty($shipRateDet))
						{
							$retailerCart[$retailerKey]['finalShippingOrgId']  = $shipRateDet->shippingOrgId;
							$retailerCart[$retailerKey]['finalShippingRateId'] = $shipRateDet->shippingRateId;
							$retailerCart[$retailerKey]['isCalculateShipp']    = 0;
						}
						else
						{
							$this->session->set_flashdata('error','Shipping vendor not available in your city');
							$this->custom_log->write_log('custom_log','Shipping vendor not available in your city');
							redirect(base_url().'frontend/product_cart/shipping_address');
						}
					
					}
				}
				//echo "<pre>"; print_r($retailerCart); exit;
				foreach($retailerCart as $retailerRow)
				{
					$flag = 0;
					$this->cart_m->unactive_old_retailer_standard_delivery($retailerRow);
					
					if(!empty($retailerRow['finalShippingOrgId']))
					{
						$cartStandardId = $this->cart_m->add_standard_delivery($retailerRow);
						$this->custom_log->write_log('custom_log','card economical id is '.$cartStandardId);
						if($cartStandardId)
						{
							$flag = 1;
						}
						else
						{
							$this->session->set_flashdata('error','Shipping details not update in cart');
							$this->custom_log->write_log('custom_log','Shipping details not update in cart');
							redirect(base_url().'frontend/product_cart/shipping_address');
						}										
					}
				}
				
				if($flag)
				{
					redirect(base_url().'frontend/product_cart/order_economic_delivery');		
				}
				else
				{
					$this->session->set_flashdata('error','Economical details not add in cart');
					$this->custom_log->write_log('custom_log','Economical details not add in cart');
					$this->session->unset_userdata('shippingAddressId');
        	    	redirect(base_url().'frontend/product_cart/shipping_address');	
				}
			}
			else
			{
				$this->session->set_flashdata('error','Retailer group details not found');
				$this->custom_log->write_log('custom_log','Retailer group details not found');
				$this->session->unset_userdata('shippingAddressId');
            	redirect(base_url().'frontend/product_cart/shipping_address');
			}
		}
	}
	
	public function order_economic_delivery()
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_standard_delivery',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);

		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart is empty');
			$this->custom_log->write_log('custom_log','cart is empty');
			$this->session->unset_userdata('shippingAddressId');			
			redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}														
		}
		$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
		
		$shippCusDet = $this->customer_m->address_details($shippCusAddId);
		$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		$this->data['shippCusDet']  = $shippCusDet;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['purchaseFrom'] = 1;
		$this->data['isPickUp']     = 0;
		$this->data['payOnPickUp']  = 0;
		$this->data['isEconomicDelivery'] = 1;
		$this->frontendCustomView('checkout/order',$this->data);		
	}
	
	public function economical_shipping_amount()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'economical_shipping_amount',
                'log_MID'    => ''
		) );
		
		$result = array('success' => 0,'message' => '','shippingAmt' => 0,'totalShippingAmt' => 0,'viewfile' => '');
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			$contents   = $this->cart->contents();
			$total_cart = count($contents);
			
			if((!empty($total_cart))&&($total_cart))
			{
				$cartDetails = '';
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
						$cartDetails = $this->cart_m->cart_list($where);
					}														
				}
				$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
				
				if((!empty($cartDetails))&&($cartDetails))
				{
					$shippCusAddId = $this->session->userdata('shippingAddressId');
					$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
					if((!empty($shippCusAddId))&&($shippCusAddId))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$retailerCart     = array();
							$retailerPrdWtArr = array();
							$totalAmount      = 0;
							$productTypeId    = 0;
							foreach($cartDetails as $cartRow)
							{
								if((!empty($cartRow->productTypeId))&&($cartRow->productTypeId==3))
								{
									$productTypeId = 3;
								}
								
								$totalAmount = $totalAmount+($cartRow->quantity*$cartRow->productAmt);
				
								$retailerCart[$cartRow->organizationId]['retailerId']   = $cartRow->organizationId;
								$retailerCart[$cartRow->organizationId]['toDropshipId'] = $cartRow->toDropshipId;
				
								if((!empty($retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight']))&&($retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight']))
								{
									$retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight'] = $retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight']+($cartRow->productWeight*$cartRow->quantity);
								}
								else
								{
									$retailerPrdWtArr[$cartRow->organizationId]['totalProductWeight'] = $cartRow->productWeight*$cartRow->quantity;
								}
				
								if($cartRow->freeShipPrdId)
								{
								}
								elseif($cartRow->freeShipCatId)
								{
								}
								elseif($cartRow->genuineShippFee)
								{
									if((!empty($retailerCart[$cartRow->organizationId]['totalProductWeight']))&&($retailerCart[$cartRow->organizationId]['totalProductWeight']))
									{
										$retailerCart[$cartRow->organizationId]['totalProductWeight'] = $retailerCart[$cartRow->organizationId]['totalProductWeight']+($cartRow->productWeight*$cartRow->quantity);
									}
									else
									{
										$retailerCart[$cartRow->organizationId]['totalProductWeight'] = $cartRow->productWeight*$cartRow->quantity;
									}
								}
							}
							$this->custom_log->write_log('custom_log','retailer array is '.print_r($retailerCart,true));
						
							if(!empty($retailerCart))
							{
								foreach($retailerCart as $retailerKey=>$retailerRow)
								{
									$dropshipId  = $retailerRow['toDropshipId'];
									$stateId	 = $shippCusDet->state;
									$areaId	     = $shippCusDet->area;
									$cityId		 = $shippCusDet->city;					
					
									if(!empty($retailerRow['totalProductWeight']))
									{
										$totalWeight = $retailerRow['totalProductWeight'];
										$stateId	 = $shippCusDet->state;
										$areaId	     = $shippCusDet->area;
										$cityId		 = $shippCusDet->city;
										$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
										$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
										
										if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
										{
											$retailerCart[$retailerKey]['finalShippingOrgId']  = $shipRateDet->shippingOrgId;
											$retailerCart[$retailerKey]['finalShippingRateId'] = $shipRateDet->shippingRateId;
											$retailerCart[$retailerKey]['isCalculateShipp']    = 1;
											
											$shippingRate = $shipRateDet->amount;
											if($totalWeight>10)
											{
												$shippingRate = $shippingRate*$totalWeight;
											}
											$result['success']     = 1;
											$result['shippingAmt'] = $result['shippingAmt']+$shippingRate;
										}
										else
										{
											$result['success'] = 0;
											$result['message'] = 'Shipping vendor not available in your city';
										}
									}
									elseif(!empty($retailerPrdWtArr[$retailerKey]['totalProductWeight']))
									{
										$totalWeight = $retailerPrdWtArr[$retailerKey]['totalProductWeight'];						
										$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
										$retailerCart[$retailerKey]['totalProductWeight']  = $totalWeight;
										$this->custom_log->write_log('custom_log','free Shipping rate details is '.print_r($shipRateDet,true));
										if(!empty($shipRateDet))
										{
											$retailerCart[$retailerKey]['finalShippingOrgId']  = $shipRateDet->shippingOrgId;
											$retailerCart[$retailerKey]['finalShippingRateId'] = $shipRateDet->shippingRateId;
											$retailerCart[$retailerKey]['isCalculateShipp']    = 0;
											$result['success']     = 1;
										}
										else
										{
											$result['success'] = 0;
											$result['message'] = 'Shipping vendor not available in your city';
										}					
									}					
								}
				
								foreach($retailerCart as $retailerRow)
								{
									$this->cart_m->unactive_old_retailer_standard_delivery($retailerRow);
					
									if((!empty($retailerRow['finalShippingOrgId']))&&($retailerRow['finalShippingOrgId']))
									{
										$cartStandardId = $this->cart_m->add_standard_delivery($retailerRow);
										$this->custom_log->write_log('custom_log','card economical id is '.$cartStandardId);
										if($cartStandardId)
										{
											if($result['shippingAmt'])
											{
												$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
											}
											else
											{
												$result['totalShippingAmt'] = 'Free';
											}
											$this->data['totalAmount'] = $totalAmount+$result['shippingAmt'];
											$this->data['productTypeId'] = $productTypeId;
											$result['viewfile'] = $this->load->view('checkout/order_economical_add_to_cart',$this->data,true);
										}
										else
										{			
											$result['success'] = 0;
											$result['message'] = 'Shipping rate not update in cart';
				            			}										
									}
									else
									{
										$result['success'] = 0;
										$result['message'] = 'Shipping vendor not available in your city';
									}
								}
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = 'Retailer group details not found';
							}
		
						}
						else
						{						
							$result['success'] = 0;
							$result['message'] = 'Shipping address details not found';
							$this->session->unset_userdata('shippingAddressId');						
						}
					}
					else
					{
						$result['success'] = 0;
						$result['message'] = 'Shipping Address not found';
						$this->session->unset_userdata('shippingAddressId');				
					}
				}
				else
				{
					$result['success'] = 0;
					$result['message'] = 'Cart details not found';
					$this->session->unset_userdata('shippingAddressId');		
				}
			}
			else
			{
				$result['success'] = 0;
				$result['message'] = 'cart is empty';
				$this->session->unset_userdata('shippingAddressId');			
			}
		}
		else
		{		
			$this->session->unset_userdata('shippingAddressId');
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');		
		}
		echo json_encode($result);
	}
	
	public function economic_cash_handling_amount()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'economic_cash_handling_amount',
                'log_MID'    => ''
		) );
		
		$result = array('success' => 0,'message' => '','cashHandlingAmt' => 0,'totalAmount' => 0);
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		if((!empty($userId))&&($userId))
		{
			$contents   = $this->cart->contents();
			$total_cart = count($contents);
			
			if((!empty($total_cart))&&($total_cart))
			{
				$cartDetails = '';
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
						$cartDetails = $this->cart_m->cart_list($where);
					}														
				}
				$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
				
				if((!empty($cartDetails))&&($cartDetails))
				{
					$shippCusAddId = $this->session->userdata('shippingAddressId');
					$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
					if((!empty($shippCusAddId))&&($shippCusAddId))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$retailerArr = array();
							$totalAmount = 0;
							$shipping_rate = 0;
							foreach($cartDetails as $cartRow)
							{
								$totalAmount = $totalAmount+($cartRow->quantity*$cartRow->productAmt);
								
								if($cartRow->freeShipPrdId)
								{
								}
								elseif($cartRow->freeShipCatId)
								{
								}
								elseif($cartRow->genuineShippFee)
								{
									if(!empty($retailerArr[$cartRow->organizationId]))
									{
									}
									else
									{
										$standardDet = $this->cart_m->standard_delivery_details($cartRow->organizationId,$this->session->userdata('userId'));
										if(!empty($standardDet))
										{									
											$shippingRate = $standardDet->shippingRate;
											if($standardDet->totalProductWeight>10)
											{
												$shippingRate = $standardDet->shippingRate*$standardDet->totalProductWeight;
											}
											$shipping_rate = $shipping_rate+$shippingRate;				
										}
									}
									$retailerArr[$cartRow->organizationId] = $cartRow->organizationId;
								}
							}
							$totalAmount     = $totalAmount+$shipping_rate;
							$cashHandlingAmt = ($totalAmount*$this->config->item('space_point_comission'))/100; 
							$totalAmount     = $totalAmount+$cashHandlingAmt;
				
							$result['success'] = 1;
							$result['cashHandlingAmt'] = '&#x20A6;'.number_format($cashHandlingAmt,2);
							$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);
							$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);			
						}
						else
						{
							$result['success'] = 0;
							$result['message'] = 'Shipping address details not found';
						}
					}
					else
					{					
						$result['success'] = 0;
						$result['message'] = 'Shipping Address not found';
					}
				}
				else
				{
					$result['success'] = 0;
					$result['message'] = 'Cart details not found';
				}
			}
			else
			{
				$result['success'] = 0;
				$result['message'] = 'cart is empty';
			}
		}
		else
		{		
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');		
		}
		echo json_encode($result);
	
	}
	
	public function standard_shipping_amount()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'standard_shipping_amount',
                'log_MID'    => ''
		) );
		
		$result = array('success' => 0,'message' => '','shippingAmt' => 0,'totalShippingAmt' => 0,'viewfile' => '');
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		if((!empty($userId))&&($userId))
		{
			$contents   = $this->cart->contents();
			$total_cart = count($contents);
			
			if((!empty($total_cart))&&($total_cart))
			{
				$cartDetails = '';
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
						$cartDetails = $this->cart_m->cart_list($where);
					}														
				}
				$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
				
				if((!empty($cartDetails))&&($cartDetails))
				{
					$shippCusAddId = $this->session->userdata('shippingAddressId');
					$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
					if((!empty($shippCusAddId))&&($shippCusAddId))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{		
							$totalAmount   = 0;
							$productTypeId = 0;
							foreach($cartDetails as $cartRow)
							{
								if((!empty($cartRow->productTypeId))&&($cartRow->productTypeId==3))
								{
									$productTypeId = 3;
								}

								if((!empty($cartRow->shippingOrgId))&&($cartRow->shippingOrgId))
								{
									$totalAmount = $totalAmount+($cartRow->quantity*$cartRow->productAmt);
									if($cartRow->freeShipPrdId)
									{
									}
									elseif($cartRow->freeShipCatId)
									{
									}
									elseif($cartRow->genuineShippFee)
									{
										$productWeight = $cartRow->productWeight;					
										$shipping_rate = $cartRow->shippingRate;
										if($productWeight>10)
										{
											$shipping_rate = $cartRow->shippingRate*$productWeight;
										}
										$shipping_rate 		   = $cartRow->quantity*$shipping_rate;				
										$result['success']     = 1;
										$result['shippingAmt'] = $result['shippingAmt']+$shipping_rate;
									}
								}
								else
								{
									$result['success'] = 0;
									$result['message'] = 'Shipping vendor not available in your city';										
								}
							}
							
							if($result['success'])
							{
								if($result['shippingAmt'])
								{
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
								
								$this->data['totalAmount']   = $totalAmount+$result['shippingAmt'];
								$this->data['productTypeId'] = $productTypeId;
								$result['viewfile'] = $this->load->view('checkout/order_standard_add_to_card',$this->data,true);
							}
							else
							{
								$result['message'] = 'Free Shipping';						
							}
		
						}
						else
						{												
							$result['success'] = 0;
							$result['message'] = 'Shipping address details not found';
							$this->session->unset_userdata('shippingAddressId');												
						}
					}
					else
					{					
						$result['success'] = 0;
						$result['message'] = 'Shipping Address not found';
						$this->session->unset_userdata('shippingAddressId');									
					}
				}
				else
				{				
					$result['success'] = 0;
					$result['message'] = 'Cart details not found';
					$this->session->unset_userdata('shippingAddressId');						
				}
			}
			else
			{			
				$result['success'] = 0;
				$result['message'] = 'cart is empty';
				$this->session->unset_userdata('shippingAddressId');						
			}
		}
		else
		{		
			$this->session->unset_userdata('shippingAddressId');
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');		
		}
		echo json_encode($result);
	}
	
	public function standard_cash_handling_amount()
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'standard_cash_handling_amount',
                'log_MID'    => ''
		) );
		
		$result = array('success' => 0,'message' => '','cashHandlingAmt' => 0,'totalAmount' => 0,'shippingAmt' => 0);
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			$contents   = $this->cart->contents();
			$total_cart = count($contents);
			
			if((!empty($total_cart))&&($total_cart))
			{
				$cartDetails = '';
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
						$cartDetails = $this->cart_m->cart_list($where);
					}														
				}
				$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
				
				if((!empty($cartDetails))&&($cartDetails))
				{
					$shippCusAddId = $this->session->userdata('shippingAddressId');
					$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
					if((!empty($shippCusAddId))&&($shippCusAddId))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = 0;
							foreach($cartDetails as $cartRow)
							{
								if((!empty($cartRow->shippingOrgId))&&($cartRow->shippingOrgId))
								{
									$totalAmount = $totalAmount+($cartRow->quantity*$cartRow->productAmt);
									if($cartRow->freeShipPrdId)
									{
									}
									elseif($cartRow->freeShipCatId)
									{
									}
									elseif($cartRow->genuineShippFee)
									{
										$productWeight = $cartRow->productWeight;					
										$shipping_rate = $cartRow->shippingRate;
										if($productWeight>10)
										{
											$shipping_rate = $cartRow->shippingRate*$productWeight;
										}
										$shipping_rate 		   = $cartRow->quantity*$shipping_rate;				
										$result['success']     = 1;
										$result['shippingAmt'] = $result['shippingAmt']+$shipping_rate;
									}
								}
								else
								{
									$result['success'] = 0;
									$result['message'] = 'Shipping vendor not available in your city';								
								}
							}
							
							if($result['success'])
							{
								if($result['shippingAmt'])
								{
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
								
								$totalAmount     = $totalAmount+$result['shippingAmt'];
								$cashHandlingAmt = ($totalAmount*$this->config->item('space_point_comission'))/100; 
								$totalAmount     = $totalAmount+$cashHandlingAmt;
							
								$result['success'] = 1;
								$result['cashHandlingAmt'] = '&#x20A6;'.number_format($cashHandlingAmt,2);
								$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = 'Free Shipping';						
							}
						}
						else
						{												
							$result['success'] = 0;
							$result['message'] = 'Shipping address details not found';
						}
					}
					else
					{					
						$result['success'] = 0;
						$result['message'] = 'Shipping Address not found';
					}
				}
				else
				{				
					$result['success'] = 0;
					$result['message'] = 'Cart details not found';
				}
			}
			else
			{
				$result['success'] = 0;
				$result['message'] = 'cart is empty';
			}
		}
		else
		{
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');				
		}
		echo json_encode($result);
	}
	
	public function same_day_delivery_shipping_amount()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'same_day_delivery_shipping_amount',
                'log_MID'    => ''
		) );
		
		$result = array('success' => 0,'message' => '','shippingAmt' => 0,'totalShippingAmt' => 0,'viewfile' => '');
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		if((!empty($userId))&&($userId))
		{
			$contents   = $this->cart->contents();
			$total_cart = count($contents);
			
			if((!empty($total_cart))&&($total_cart))
			{
				$cartDetails = '';
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
						$cartDetails = $this->cart_m->cart_list($where);
					}														
				}
				$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
				
				if((!empty($cartDetails))&&($cartDetails))
				{
					$shippCusAddId = $this->session->userdata('shippingAddressId');
					$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
					if((!empty($shippCusAddId))&&($shippCusAddId))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{		
							$totalAmount   = 0;
							$productTypeId = 0;
							foreach($cartDetails as $cartRow)
							{
								if((!empty($cartRow->productTypeId))&&($cartRow->productTypeId==3))
								{
									$productTypeId = 3;
								}

								if((!empty($cartRow->shippingOrgId))&&($cartRow->shippingOrgId))
								{
									$totalAmount = $totalAmount+($cartRow->quantity*$cartRow->productAmt);
									if($cartRow->freeShipPrdId)
									{
									}
									elseif($cartRow->freeShipCatId)
									{
									}
									elseif($cartRow->genuineShippFee)
									{
										$productWeight = $cartRow->productWeight;					
										$shipping_rate = $cartRow->shippingRate;
										if($productWeight>10)
										{
											$shipping_rate = $cartRow->shippingRate*$productWeight;
										}
										$shipping_rate = $cartRow->quantity*$shipping_rate;				
										$result['success']     = 1;
										$result['shippingAmt'] = $result['shippingAmt']+$shipping_rate;
									}
								}
								else
								{
									$result['success'] = 0;
									$result['message'] = 'Shipping vendor not available in your city';										
								}
							}
							
							if($result['success'])
							{
								if($result['shippingAmt'])
								{
									$result['shippingAmt'] = $result['shippingAmt']+$this->config->item('flate_rate_same_day_delivery');
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
								
								$this->data['totalAmount']   = $totalAmount+$result['shippingAmt'];
								$this->data['productTypeId'] = $productTypeId;
								$result['viewfile'] = $this->load->view('checkout/order_same_day_shipping_amount_add_to_card',$this->data,true);
							}
							else
							{
								$result['message'] = 'Free Shipping';						
							}
		
						}
						else
						{												
							$result['success'] = 0;
							$result['message'] = 'Shipping address details not found';
							$this->session->unset_userdata('shippingAddressId');												
						}
					}
					else
					{					
						$result['success'] = 0;
						$result['message'] = 'Shipping Address not found';
						$this->session->unset_userdata('shippingAddressId');									
					}
				}
				else
				{				
					$result['success'] = 0;
					$result['message'] = 'Cart details not found';
					$this->session->unset_userdata('shippingAddressId');						
				}
			}
			else
			{			
				$result['success'] = 0;
				$result['message'] = 'cart is empty';
				$this->session->unset_userdata('shippingAddressId');						
			}
		}
		else
		{		
			$this->session->unset_userdata('shippingAddressId');
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');		
		}
		echo json_encode($result);
	}
	
	public function same_day_delivery_cash_handling_amount()
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'same_day_delivery_cash_handling_amount',
                'log_MID'    => ''
		) );
		
		$result = array('success' => 0,'message' => '','cashHandlingAmt' => 0,'totalAmount' => 0,'shippingAmt' => 0);
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			$contents   = $this->cart->contents();
			$total_cart = count($contents);
			
			if((!empty($total_cart))&&($total_cart))
			{
				$cartDetails = '';
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
						$cartDetails = $this->cart_m->cart_list($where);
					}														
				}
				$this->custom_log->write_log('custom_log','cart details is '.print_r($cartDetails,true));
				
				if((!empty($cartDetails))&&($cartDetails))
				{
					$shippCusAddId = $this->session->userdata('shippingAddressId');
					$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
					if((!empty($shippCusAddId))&&($shippCusAddId))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = 0;
							foreach($cartDetails as $cartRow)
							{
								if((!empty($cartRow->shippingOrgId))&&($cartRow->shippingOrgId))
								{
									$totalAmount = $totalAmount+($cartRow->quantity*$cartRow->productAmt);
									if($cartRow->freeShipPrdId)
									{
									}
									elseif($cartRow->freeShipCatId)
									{
									}
									elseif($cartRow->genuineShippFee)
									{
										$productWeight = $cartRow->productWeight;					
										$shipping_rate = $cartRow->shippingRate;
										if($productWeight>10)
										{
											$shipping_rate = $cartRow->shippingRate*$productWeight;
										}
										$shipping_rate 		   = $cartRow->quantity*$shipping_rate;				
										$result['success']     = 1;
										$result['shippingAmt'] = $result['shippingAmt']+$shipping_rate;
									}
								}
								else
								{
									$result['success'] = 0;
									$result['message'] = 'Shipping vendor not available in your city';								
								}
							}
							
							if($result['success'])
							{
								if($result['shippingAmt'])
								{
									$result['shippingAmt']		= $result['shippingAmt']+$this->config->item('flate_rate_same_day_delivery');
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
								
								$totalAmount     = $totalAmount+$result['shippingAmt'];
								$cashHandlingAmt = ($totalAmount*$this->config->item('space_point_comission'))/100; 
								$totalAmount     = $totalAmount+$cashHandlingAmt;
							
								$result['success'] = 1;
								$result['cashHandlingAmt'] = '&#x20A6;'.number_format($cashHandlingAmt,2);
								$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = 'Free Shipping';						
							}
						}
						else
						{												
							$result['success'] = 0;
							$result['message'] = 'Shipping address details not found';
						}
					}
					else
					{					
						$result['success'] = 0;
						$result['message'] = 'Shipping Address not found';
					}
				}
				else
				{				
					$result['success'] = 0;
					$result['message'] = 'Cart details not found';
				}
			}
			else
			{
				$result['success'] = 0;
				$result['message'] = 'cart is empty';
			}
		}
		else
		{
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');				
		}
		echo json_encode($result);
	}

}