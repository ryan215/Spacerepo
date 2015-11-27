<?php if (! defined ( 'BASEPATH' )) exit ( 'No Direct Access Allowed' );

class Product_buy_now extends MY_Controller {

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
	
	public function add_to_buy_now()
    {
		$this->session->set_userdata(array(
        	'log_MODULE' => 'add_to_buy_now',
            'log_MID'    => ''
		) );		
		$this->session->unset_userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Buy NOW from ajax function '.print_r($_POST,true));
		$organizationProductId = id_decrypt($this->input->post('organizationProductId'));
		$marketingProductId    = id_decrypt($this->input->post('marketingProductId'));
		$quantity      		   = 1;
		$cartId				   = 0;
		$result				   = array();	
		$result['success']	   = 0;
		$result['message']     = '';
		$result['quantity']    			   = $quantity;
		$result['organizationProductId']   = $organizationProductId;
		$result['marketingProductId']      = $marketingProductId;
		$result['colorId']      		   = $this->input->post('colorId');
		$result['sizeId']       		   = $this->input->post('sizeId');
		$result['organizationColorSizeId'] = $this->input->post('organizationColorSizeId');

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
					$result['organizationId']		      = $productDet->organizationId;
					$result['productImageId']		      = $productDet->productImageId;					
					$result['pickupProccessPrice']        = 0;
					$result['productAmt']                 = $displayPrice;
					$result['shippingRateId'] 			  = 0;
					$result['shippingOrgId']  			  = 0;
					$result['productWeight']              = $productWeight;
					$result['productId']			      = $productId;
					$result['freeShipPrdId']              = $freeShipPrdId;
					$result['freeShipCatId']              = $freeShipCatId;
					$result['retailerDiscount']           = 0;
					$result['inventoryHistoryId']         = $inventoryHistoryId;
					$result['spacePointeCommissionPrice2'] = $priceArr['spacePointeCommissionPrice2'];
					$result['retailerQuotedPrice']		  = $priceArr['retailerQuotedPrice'];
					$result['categoryCommission2']		  = $priceArr['categoryCommission2'];
					if(!empty($productDet->retailerDiscount))
					{
						$result['retailerDiscount'] = $productDet->retailerDiscount;
					}
					
					$cartId = $this->cart_m->add_to_buy_now($result);
					
					$this->custom_log->write_log('custom_log','data insert in cart for buy now and cart id is '.$cartId);
					if($cartId)
					{
						$cartCommissionId = $this->cart_m->add_commission_price($cartId,$result);
						$this->custom_log->write_log('custom_log','Cart commission id is '.$cartCommissionId);
						
						$cartDeliveryId = $this->cart_m->add_to_delivery($cartId,$result);
						$this->custom_log->write_log('custom_log','Cart delivery id is '.$cartDeliveryId);
						
						$data = array(
									'id'      => $cartId,
									'qty'     => 1,
									'price'   => $displayPrice,
									'name'    => preg_replace("/[^a-zA-Z0-9 ]+/", "", html_entity_decode($productDet->code,ENT_QUOTES)),
								);
						$this->custom_log->write_log('custom_log','add to cart inserted data is'.print_r($data,true));
						$rowID = $this->cart->insert($data);
						$this->custom_log->write_log('custom_log','Genrated row id is'.$rowID);
						$this->cart_m->add_rowId_to_cart($cartId,$rowID);
								
						$result['success'] = 1;
						$result['message'] = 'Product Added Successfully';
						$result['cartId']  = id_encrypt($cartId);
					}
					else
					{
						$result['success'] = 0;
						$result['message'] = 'Product not add in buy now cart';			
					}
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
	
	public function buy_now_page($cartId=0)
	{
    	$this->session->set_userdata(array(
        	'log_MODULE' => 'buy_now_page',
            'log_MID'    => ''
        ) );
		
		$this->data['title'] = 'Buy Now Detail';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$result = $this->cart_m->buy_now_cart_page_detail($cartId);
		//echo "<pre>"; print_r($result); exit;
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($result,true));
		
		if(empty($result))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$this->data['result'] = $result;
		$this->data['cartId'] = $cartId;
		$this->frontendCustomView('product_buy_now/buy_now_page',$this->data);
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
			$result = $this->cart_m->buy_now_cart_page_detail($cartId);
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
					$totalAmt 	   = $subtotal;
					
					if($this->cart_m->update_to_cart($cartId,$qty))
                    {
                    	$this->custom_log->write_log('custom_log','Quantity increment successfully');
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
		$this->custom_log->write_log('custom_log','retun array for qty_increment_buy_now function '.print_r($return,true));
        echo json_encode($return);
	}
	
	public function qty_decryment()
    {
    	$this->session->set_userdata(array(
                'log_MODULE' => 'qty_decryment',
                'log_MID'    => ''
		) );
        $this->custom_log->write_log('custom_log','quantity decryment form data '.print_r($_POST,true));
		
		$cartId   = $this->input->post('cartId');
		$return   = array('success' => 0,'message' => '','subtotal' => 0,'total' => 0);
		
		if(!empty($cartId))
        {
			$result = $this->cart_m->buy_now_cart_page_detail($cartId);
            $this->custom_log->write_log('custom_log','cart details is '.print_r($result,true));
            if(!empty($result))
            {
            	$qty 			= $result->quantity;
                $qty 			= $qty-1;
                $totalInventory = $result->currentQty;
				
				if($qty<1)
                {
                	$return['success'] = 0;
                    $return['message'] = 'Quantity is not less then to Zero';
				}
                else
                {
					$productWeight = $result->productWeight;
					$subtotal      = $result->productAmt*$qty;
					$totalAmt 	   = $subtotal;
					
					if($this->cart_m->update_to_cart($cartId,$qty))
                    {
                    	$this->custom_log->write_log('custom_log','Quantity Decrement successfully');
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
		$this->custom_log->write_log('custom_log','retun array for qty_increment_buy_now function '.print_r($return,true));
        echo json_encode($return);
	}
	
	public function remove_to_cart($cartId=0)
    {
    	$this->session->set_userdata(array(
        	'log_MODULE' => 'remove_to_cart',
            'log_MID'    => ''
		) );

		$cartId = id_decrypt($cartId);
		$this->session->unset_userdata('shippingAddressId');
		if($cartId)
		{
	    	$this->custom_log->write_log('custom_log','user cart id is '.$cartId);
    	    if($this->cart_m->remove_from_cart($cartId))
        	{
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
	
	public function shipping_address($cartId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'shipping_address',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Shipping Address';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail($cartId);
		//echo "<pre>"; print_r($cartDetails); exit;
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
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
		{	//echo "<pre>"; print_r($_POST); exit;
			if((!empty($_POST['economicCapcha']))&&($_POST['economicCapcha']==1))
			{
				$this->custom_log->write_log('custom_log','after submit form is '.print_r($_POST,true));
				$rules = check_captcha_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{				
					$cusOrderId     = $this->config->item('add_orderId');
					$cusOrderId	    = $cusOrderId+$cartDetails->cartId;
					$customOrderId  = $this->config->item('pre_orderId').$cusOrderId;
					$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
					
					$atATimeProduct = $this->checkout_lib->cash_on_delivery_buy_now_single_shippment($cartDetails);
					$this->custom_log->write_log('custom_log','at a time product id is '.$atATimeProduct);
						
					$this->custom_log->write_log('custom_log','at a time purchas product id is '.$atATimeProduct);
					
					$retailerPrice = $cartDetails->retailerPrice;
					$productWeight = $cartDetails->productWeight;  
					$pickupId      = $cartDetails->pickupId;
					$displayPrice  = $cartDetails->productAmt;
					$shipping_rate = 0;
					$standardDet = $this->cart_m->standard_delivery_details($cartDetails->organizationId,$userId);
					$this->custom_log->write_log('custom_log','standard delivery details is '.print_r($standardDet,true));				
						
					if($cartDetails->freeShipPrdId)
					{
					}
					elseif($cartDetails->freeShipCatId)
					{
					}
					elseif($cartDetails->genuineShippFee)
					{	
						if(!empty($standardDet))
						{
							if($standardDet->isCalculateShipp)
							{
								$shipping_rate = $standardDet->shippingRate;
								if($standardDet->totalProductWeight>10)
								{
									$shipping_rate = $standardDet->shippingRate*$standardDet->totalProductWeight;
								}
							}
						}
					}
					
					$this->custom_log->write_log('custom_log','Shipping Rate is '.$shipping_rate);
					$totalAmt = ($cartDetails->quantity*$displayPrice)+$shipping_rate;
					$this->custom_log->write_log('custom_log','total amount after calculate shipping rate = '.$totalAmt);
					
					$handlingPrice = ($totalAmt*$this->config->item('space_point_comission'))/100; 
					$this->custom_log->write_log('custom_log','Handling amount of total amout is '.$handlingPrice);
					
					$amount = $totalAmt+$handlingPrice;
					$this->custom_log->write_log('custom_log','calculate amout is '.$amount);
					
					$economicOrderArr = array();
					/********Add Standard Delivery Order************/
					$economicOrderArr['organizationId']     = $standardDet->organizationId;
					$economicOrderArr['fromDropshipId']     = $standardDet->fromDropshipId;
					$economicOrderArr['totalProductWeight'] = $standardDet->totalProductWeight;
					$economicOrderArr['shippingOrgId']      = $standardDet->finalShippingOrgId;										
					$economicOrderArr['shippingRateId']     = $standardDet->finalShippingRateId;
					$economicOrderArr['customOrderId']      = $customOrderId;
					$economicOrderArr['cashHandlingPrice']  = $handlingPrice;		
					$economicOrderArr['isCalculateShipp']   = $standardDet->isCalculateShipp;
					$this->order_m->unactive_economical_repeate_order_delivery($economicOrderArr);
					$orderEconomicalId = $this->order_m->add_economical_order_delivery($economicOrderArr);
					$this->custom_log->write_log('custom_log','economical delivery id is '.$orderEconomicalId);
					/********Add Standard Delivery Order************/
												
					$orderArr = array(
									'orderTypeId'           => 1,										
									'totalAmount'           => $amount,
									'customerId'            => $this->session->userdata('userId'),
									'quantity'				=> $cartDetails->quantity,
									'chargedAmount'			=> $displayPrice,
									'organizationProductId' => $cartDetails->organizationProductId,
									'orderStatusId'         => 1,										
									'orderEmail'       		=> $this->session->userdata('userEmail'),
									'shippingOrgId'			=> $cartDetails->shippingOrgId,
									'shippingRateId'		=> $cartDetails->shippingRateId,
									'customOrderId'			=> $customOrderId,
									'atATimeProduct'		=> $atATimeProduct,
									'colorId'				=> $cartDetails->colorId,
									'size'					=> $cartDetails->size,
									'isPickup'				=> 0,
									'pickupId'				=> 0,
									'payment_reference'     => '',
									'retrieval_reference'   => '',
									'transaction_reference' => '',
									'merchant_reference'	=> '',
									'transaction_date'	    => '',
									'paymentStatus'			=> 0,	
									'toDropshipId'			=> $cartDetails->toDropshipId,
									'retailerPrice'			=> $cartDetails->retailerPrice,
									'spacePointePrice'	    => $cartDetails->spacePointePrice,
									'cashAdminPrice'		=> $cartDetails->cashAdminPrice, 
									'cashAdminFee'			=> $cartDetails->cashAdminFee,
									'genuineShippFee'		=> $cartDetails->genuineShippFee,
									'categoryCommission'    => $cartDetails->categoryCommission,	 
									'marketingProductId'	=> $cartDetails->marketingProductId,
									'productWeight'      	=> $cartDetails->productWeight,
									'cashHandlingPrice'     => 0,	
									'pickupProccessPrice'   => 0,
									'retailerDiscount'		=> $cartDetails->retailerDiscount,
									'freeShipCatId'			=> $cartDetails->freeShipCatId,
									'freeShipPrdId'			=> $cartDetails->freeShipPrdId,
									'productId'				=> $cartDetails->productId,
									'productImageId'		=> $cartDetails->productImageId,
									'isEconomicDelivery'    => 1,
									'inventoryHistoryId'	=> $cartDetails->inventoryHistoryId,
									'pointeForceVerifiedStatus'	=> $pointeForceVerifiedStatus,
									'spacepointeCommission2'	=> $cartDetails->spacePointePrice2,
									'totalCommissionPrice'      => $cartDetails->quantity*$cartDetails->spacePointePrice2,
								);
					$this->custom_log->write_log('custom_log','order inserted array is '.print_r($orderArr,true));
																	
					$orderID  = $this->order_m->add_order($orderArr);
					$this->custom_log->write_log('custom_log','last inserted query is '.$this->db->last_query());
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
						
						$payOrderID     = $this->order_m->add_order_payment($orderID,$orderArr);
						$this->custom_log->write_log('custom_log','Payment order id is '.$payOrderID);
						
						if($payOrderID)
						{
							$orderTrackId = $this->order_m->add_order_track_details($orderID,1);
							$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
										
							$orderDropshipCenterId = $this->order_m->add_order_dropship_center($orderID,$orderArr);
							$this->custom_log->write_log('custom_log','order dropship center id is '.$orderDropshipCenterId);
							
							$freeShipOrderId = $this->order_m->add_order_free_shipping($orderID,$orderArr);
							$this->custom_log->write_log('custom_log','free shipping order id is '.$freeShipOrderId);
										
												
							if($this->order_m->reduce_product_quantity($cartDetails->organizationProductId,$cartDetails->quantity))
							{
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId);
								
								if($cartDetails->colorId)
								{
									if($cartDetails->marketingProductId)
									{
										$this->order_m->reduce_product_color_quantity_from_marketing($cartDetails->marketingProductId,$cartDetails->colorId,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->marketingProductId.' and color id is '.$cartDetails->colorId);
	
									}
									else
									{/*
										$this->order_m->reduce_product_color_quantity($cartDetails->organizationProductId,$cartDetails->colorId,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId.' and color id is '.$cartDetails->colorId);
									*/}
								}
								
								if($cartDetails->size)
								{
									if($cartDetails->marketingProductId)
									{
										$this->order_m->reduce_product_size_quantity_from_marketing($cartDetails->marketingProductId,$cartDetails->size,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from marketing product id is '.$cartDetails->organizationProductId.' and size is '.$cartDetails->size);	
									}
									else
									{/*
										$this->order_m->reduce_product_size_quantity($cartDetails->organizationProductId,$cartDetails->size,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId.' and size is '.$cartDetails->size);	
									*/}
								}	
								
								if((!empty($cartDetails->marketingProductId))&&($cartDetails->marketingProductId))
							{
							}
							elseif((!empty($cartDetails->organizationColorSizeId))&&($cartDetails->organizationColorSizeId))							
							{
								$this->order_m->reduce_orgnization_product_color_size_quantity($cartDetails->organizationColorSizeId,$cartDetails->quantity);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationColorSizeId);
							}
								$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
								$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
							
								/***order History****************/
								$orderHistoryId = $this->order_m->add_order_history($orderID,1);
								$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
								/***Order History****************/
	
							}
							
							$shippingVendor = '';
							$estimateDay    = 0;
							$rateDetails    = $this->shipping_m->shipping_vendor_details($cartDetails->shippingRateId);
							$estimateDay    = $rateDetails->ETA+$this->config->item('estimated_time_increase');									
							$shippingVendor = $rateDetails->organizationName;
							$this->custom_log->write_log('custom_log','shipping rate details is '.print_r($rateDetails,true));
							
							$customerShippDet = $this->customer_m->address_details($shippCusAddId);
							$this->custom_log->write_log('custom_log','Customer shipping details is '.print_r($customerShippDet,true));
							
							$shippingAddName  = $customerShippDet->firstName.' '.$customerShippDet->lastName;
							$shippingAddress  = $customerShippDet->addressLine1.' '.$customerShippDet->address_Line2.' '.$customerShippDet->cityName.','.$customerShippDet->areaName.' '.$customerShippDet->stateName.' - '.$customerShippDet->zip;
							$retailerDet = $this->order_m->order_retailer_with_product_details($cartDetails->organizationProductId);
							$this->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDet,true));
							
							$imagePath = base_url().'img/no_image.jpg';
							if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
							{
								$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
							}
							
							$color = '';
							$size = '';
							
							/**********mail for customer***************/	
							$mailData = array(
												'email'           => $this->session->userdata('userEmail'),
												'cc'			  => '',
												'bcc'			  => 'neworders@spacepointe.com',
												'slug'            => 'order_placed_for_customer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'Your Order Has Been Placed',
												'pickupCenter'    =>  ''
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
							
							$mailData = array(
												'email'           => 'neworders@spacepointe.com',
												'cc'			  => '',
												'bcc'			  => '',
												'slug'            => 'order_placed_for_customer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'Your Order Has Been Placed',
												'pickupCenter'    =>  ''
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
							/******mail for retailer*******/
							$mailData = array(
												'email'           => $retailerDet->email,
												'cc'	          => '',
												'slug'            => 'order_placed_for_retailer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'An order has been placed',
												'pickupCenter'    => '',
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
							
							$message=' An Order for '.$cartDetails->quantity.substr($retailerDet->code,0,20).'  has been placed. Please confirm in the panel.';
							$response = $this->twillo_m->send_mobile_message($retailerDet->businessPhoneCode.$retailerDet->businessPhone,$message);
							
							$customer_order_message=substr($retailerDet->code,0,20).', order #  '.$customOrderId.' has been accepted & will be delivered in '.$estimateDay.' days.';
							$response = $this->twillo_m->send_mobile_message('+234'.$customerShippDet->phone,$customer_order_message);
							
							$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
							$response = $this->twillo_m->send_mobile_message($retailerDet->businessPhoneCode.$retailerDet->businessPhone ,$message);
							$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
							
							/*********add order pointeforce commission***********/
							if((!empty($isPointeForce))&&($isPointeForce))
							{
								$orderPointeForceId = $this->order_m->add_order_pointe_force_commission($orderID,$orderArr);
								$this->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
							}
							/*********add order pointeforce commission***********/
				
							$this->cart_m->remove_from_cart($cartId);
							$this->cart_m->remove_economical_delivery_from_cart();
														
							$this->cart->destroy();
							$this->session->unset_userdata('isPickUp');
							$this->session->unset_userdata('isChkAvl');
							$this->session->unset_userdata('isBuyNowPickUp');
							$this->session->unset_userdata('shippingAddressId');
							$this->session->set_flashdata('success','Order created successfully');
							$this->custom_log->write_log('custom_log','Order created successfully');
							redirect(base_url().'frontend/order/order_complete_success/'.id_encrypt($atATimeProduct));
						}
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
					$cusOrderId     = $this->config->item('add_orderId');
					$cusOrderId	    = $cusOrderId+$cartDetails->cartId;
					$customOrderId  = $this->config->item('pre_orderId').$cusOrderId;
					$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
					
					$atATimeProduct = $this->checkout_lib->cash_on_delivery_buy_now_quick_shippment($cartDetails);
					$this->custom_log->write_log('custom_log','at a time product id is '.$atATimeProduct);
					$this->custom_log->write_log('custom_log','at a time purchas product id is '.$atATimeProduct);
					
					$retailerPrice = $cartDetails->retailerPrice;
					$productWeight = $cartDetails->productWeight;  
					$pickupId      = $cartDetails->pickupId;
					$displayPrice  = $cartDetails->productAmt;
					$shipping_rate = 0;
					
					if($cartDetails->freeShipPrdId)
					{
					}
					elseif($cartDetails->freeShipCatId)
					{
					}
					elseif($cartDetails->genuineShippFee)
					{	
						$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity;
						if($productWeight>10)
						{
							$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity*$productWeight;
						}
					}	
					$this->custom_log->write_log('custom_log','Shipping Rate is '.$shipping_rate);
					$totalAmt = ($cartDetails->quantity*$displayPrice)+$shipping_rate;
					$this->custom_log->write_log('custom_log','total amount after calculate shipping rate = '.$totalAmt);
					
					$handlingPrice = ($totalAmt*$this->config->item('space_point_comission'))/100; 
					$this->custom_log->write_log('custom_log','Handling amount of total amout is '.$handlingPrice);
					
					$amount = $totalAmt+$handlingPrice;
					$this->custom_log->write_log('custom_log','calculate amout is '.$amount);
					
					$orderArr = array(
									'orderTypeId'           => 1,										
									'totalAmount'           => $amount,
									'customerId'            => $this->session->userdata('userId'),
									'quantity'				=> $cartDetails->quantity,
									'chargedAmount'			=> $displayPrice,
									'organizationProductId' => $cartDetails->organizationProductId,
									'orderStatusId'         => 1,										
									'orderEmail'       		=> $this->session->userdata('userEmail'),
									'shippingOrgId'			=> $cartDetails->shippingOrgId,
									'shippingRateId'		=> $cartDetails->shippingRateId,
									'customOrderId'			=> $customOrderId,
									'atATimeProduct'		=> $atATimeProduct,
									'colorId'				=> $cartDetails->colorId,
									'size'					=> $cartDetails->size,
									'isPickup'				=> 0,
									'pickupId'				=> 0,
									'payment_reference'     => '',
									'retrieval_reference'   => '',
									'transaction_reference' => '',
									'merchant_reference'	=> '',
									'transaction_date'	    => '',
									'paymentStatus'			=> 0,	
									'toDropshipId'			=> $cartDetails->toDropshipId,
									'retailerPrice'			=> $cartDetails->retailerPrice,
									'spacePointePrice'	    => $cartDetails->spacePointePrice,
									'cashAdminPrice'		=> $cartDetails->cashAdminPrice, 
									'cashAdminFee'			=> $cartDetails->cashAdminFee,
									'genuineShippFee'		=> $cartDetails->genuineShippFee,
									'categoryCommission'    => $cartDetails->categoryCommission,	 
									'marketingProductId'	=> $cartDetails->marketingProductId,
									'productWeight'      	=> $cartDetails->productWeight,
									'cashHandlingPrice'     => $handlingPrice,	
									'pickupProccessPrice'   => 0,
									'retailerDiscount'		=> $cartDetails->retailerDiscount,
									'freeShipCatId'			=> $cartDetails->freeShipCatId,
									'freeShipPrdId'			=> $cartDetails->freeShipPrdId,
									'productId'				=> $cartDetails->productId,
									'productImageId'		=> $cartDetails->productImageId,
									'isEconomicDelivery'    => 0,
									'inventoryHistoryId'	=> $cartDetails->inventoryHistoryId,
									'pointeForceVerifiedStatus'	=> $pointeForceVerifiedStatus,
									'spacepointeCommission2'	=> $cartDetails->spacePointePrice2,				
									'totalCommissionPrice'      => $cartDetails->quantity*$cartDetails->spacePointePrice2,
								);
					$this->custom_log->write_log('custom_log','order inserted array is '.print_r($orderArr,true));
																	
					$orderID  = $this->order_m->add_order($orderArr);
					$this->custom_log->write_log('custom_log','last inserted query is '.$this->db->last_query());
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
						
						$payOrderID     = $this->order_m->add_order_payment($orderID,$orderArr);
						$this->custom_log->write_log('custom_log','Payment order id is '.$payOrderID);
						
						if($payOrderID)
						{
							$orderTrackId = $this->order_m->add_order_track_details($orderID,1);
							$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
										
							$orderDropshipCenterId = $this->order_m->add_order_dropship_center($orderID,$orderArr);
							$this->custom_log->write_log('custom_log','order dropship center id is '.$orderDropshipCenterId);
							
							$freeShipOrderId = $this->order_m->add_order_free_shipping($orderID,$orderArr);
							$this->custom_log->write_log('custom_log','free shipping order id is '.$freeShipOrderId);
										
												
							if($this->order_m->reduce_product_quantity($cartDetails->organizationProductId,$cartDetails->quantity))
							{
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId);
								
								if($cartDetails->colorId)
								{
									if($cartDetails->marketingProductId)
									{
										$this->order_m->reduce_product_color_quantity_from_marketing($cartDetails->marketingProductId,$cartDetails->colorId,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->marketingProductId.' and color id is '.$cartDetails->colorId);
	
									}
									else
									{/*
										$this->order_m->reduce_product_color_quantity($cartDetails->organizationProductId,$cartDetails->colorId,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId.' and color id is '.$cartDetails->colorId);
									*/}
								}
								
								if($cartDetails->size)
								{
									if($cartDetails->marketingProductId)
									{
										$this->order_m->reduce_product_size_quantity_from_marketing($cartDetails->marketingProductId,$cartDetails->size,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from marketing product id is '.$cartDetails->organizationProductId.' and size is '.$cartDetails->size);	
									}
									else
									{/*
										$this->order_m->reduce_product_size_quantity($cartDetails->organizationProductId,$cartDetails->size,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId.' and size is '.$cartDetails->size);	
									*/}
								}	
								if((!empty($cartDetails->marketingProductId))&&($cartDetails->marketingProductId))
							{
							}
							elseif((!empty($cartDetails->organizationColorSizeId))&&($cartDetails->organizationColorSizeId))							
							{
								$this->order_m->reduce_orgnization_product_color_size_quantity($cartDetails->organizationColorSizeId,$cartDetails->quantity);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationColorSizeId);
							}
								$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
								$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
							
								/***order History****************/
								$orderHistoryId = $this->order_m->add_order_history($orderID,1);
								$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
								/***Order History****************/
	
							}
							
							$shippingVendor = '';
							$estimateDay    = 0;
							$rateDetails    = $this->shipping_m->shipping_vendor_details($cartDetails->shippingRateId);
							$estimateDay    = $rateDetails->ETA+$this->config->item('estimated_time_increase');									
							$shippingVendor = $rateDetails->organizationName;
							$this->custom_log->write_log('custom_log','shipping rate details is '.print_r($rateDetails,true));
							
							$customerShippDet = $this->customer_m->address_details($shippCusAddId);
							$this->custom_log->write_log('custom_log','Customer shipping details is '.print_r($customerShippDet,true));
							
							$shippingAddName  = $customerShippDet->firstName.' '.$customerShippDet->lastName;
							$shippingAddress  = $customerShippDet->addressLine1.' '.$customerShippDet->address_Line2.' '.$customerShippDet->cityName.','.$customerShippDet->areaName.' '.$customerShippDet->stateName.' - '.$customerShippDet->zip;
							$retailerDet = $this->order_m->order_retailer_with_product_details($cartDetails->organizationProductId);
							$this->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDet,true));
							
							$imagePath = base_url().'img/no_image.jpg';
							if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
							{
								$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
							}
							
							$color = '';
							$size = '';
							
							/**********mail for customer***************/	
							$mailData = array(
												'email'           => $this->session->userdata('userEmail'),
												'cc'			  => '',
												'bcc'			  => 'neworders@spacepointe.com',
												'slug'            => 'order_placed_for_customer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'Your Order Has Been Placed',
												'pickupCenter'    =>  ''
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
							
							$mailData = array(
												'email'           => 'neworders@spacepointe.com',
												'cc'			  => '',
												'bcc'			  => '',
												'slug'            => 'order_placed_for_customer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'Your Order Has Been Placed',
												'pickupCenter'    =>  ''
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
							/******mail for retailer*******/
							$mailData = array(
												'email'           => $retailerDet->email,
												'cc'	          => '',
												'slug'            => 'order_placed_for_retailer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'An order has been placed',
												'pickupCenter'    => '',
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
							
							$message=' An Order for '.$cartDetails->quantity.substr($retailerDet->code,0,20).'  has been placed. Please confirm in the panel.';
							$response = $this->twillo_m->send_mobile_message($retailerDet->businessPhoneCode.$retailerDet->businessPhone,$message);
							
							$customer_order_message=substr($retailerDet->code,0,20).', order #  '.$customOrderId.' has been accepted & will be delivered in '.$estimateDay.' days.';
							$response = $this->twillo_m->send_mobile_message('+234'.$customerShippDet->phone,$customer_order_message);
							
							$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
							$response = $this->twillo_m->send_mobile_message($retailerDet->businessPhoneCode.$retailerDet->businessPhone ,$message);
							$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
							
							/*********add order pointeforce commission***********/
							if((!empty($isPointeForce))&&($isPointeForce))
							{
								$orderPointeForceId = $this->order_m->add_order_pointe_force_commission($orderID,$orderArr);
								$this->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
							}
							/*********add order pointeforce commission***********/
							
							$this->cart_m->remove_from_cart($cartId);							
							$this->cart->destroy();
							$this->session->unset_userdata('isPickUp');
							$this->session->unset_userdata('isChkAvl');
							$this->session->unset_userdata('isBuyNowPickUp');
							$this->session->unset_userdata('shippingAddressId');
							$this->session->set_flashdata('success','Order created successfully');
							$this->custom_log->write_log('custom_log','Order created successfully');
							redirect(base_url().'frontend/order/order_complete_success/'.id_encrypt($atATimeProduct));
						}
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
					$cusOrderId     = $this->config->item('add_orderId');
					$cusOrderId	    = $cusOrderId+$cartDetails->cartId;
					$customOrderId  = $this->config->item('pre_orderId').$cusOrderId;
					$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
					
					$atATimeProduct = $this->checkout_lib->cash_on_delivery_buy_now_same_day_delivery($cartDetails);
					$this->custom_log->write_log('custom_log','at a time product id is '.$atATimeProduct);
					$this->custom_log->write_log('custom_log','at a time purchas product id is '.$atATimeProduct);
					
					$retailerPrice = $cartDetails->retailerPrice;
					$productWeight = $cartDetails->productWeight;  
					$pickupId      = $cartDetails->pickupId;
					$displayPrice  = $cartDetails->productAmt;
					$shipping_rate = 0;
					
					if($cartDetails->freeShipPrdId)
					{
					}
					elseif($cartDetails->freeShipCatId)
					{
					}
					elseif($cartDetails->genuineShippFee)
					{	
						$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity;
						if($productWeight>10)
						{
							$shipping_rate = $cartDetails->shippingRate*$cartDetails->quantity*$productWeight;
						}
					}	
					$this->custom_log->write_log('custom_log','Shipping Rate is '.$shipping_rate);
					$totalAmt = ($cartDetails->quantity*$displayPrice)+$shipping_rate;
					$this->custom_log->write_log('custom_log','total amount after calculate shipping rate = '.$totalAmt);
					
					$handlingPrice = ($totalAmt*$this->config->item('space_point_comission'))/100; 
					$this->custom_log->write_log('custom_log','Handling amount of total amout is '.$handlingPrice);
					
					$amount = $totalAmt+$handlingPrice;
					$this->custom_log->write_log('custom_log','calculate amout is '.$amount);
					
					$orderArr = array(
									'orderTypeId'           => 1,										
									'totalAmount'           => $amount,
									'customerId'            => $this->session->userdata('userId'),
									'quantity'				=> $cartDetails->quantity,
									'chargedAmount'			=> $displayPrice,
									'organizationProductId' => $cartDetails->organizationProductId,
									'orderStatusId'         => 1,										
									'orderEmail'       		=> $this->session->userdata('userEmail'),
									'shippingOrgId'			=> $cartDetails->shippingOrgId,
									'shippingRateId'		=> $cartDetails->shippingRateId,
									'customOrderId'			=> $customOrderId,
									'atATimeProduct'		=> $atATimeProduct,
									'colorId'				=> $cartDetails->colorId,
									'size'					=> $cartDetails->size,
									'isPickup'				=> 0,
									'pickupId'				=> 0,
									'payment_reference'     => '',
									'retrieval_reference'   => '',
									'transaction_reference' => '',
									'merchant_reference'	=> '',
									'transaction_date'	    => '',
									'paymentStatus'			=> 0,	
									'toDropshipId'			=> $cartDetails->toDropshipId,
									'retailerPrice'			=> $cartDetails->retailerPrice,
									'spacePointePrice'	    => $cartDetails->spacePointePrice,
									'cashAdminPrice'		=> $cartDetails->cashAdminPrice, 
									'cashAdminFee'			=> $cartDetails->cashAdminFee,
									'genuineShippFee'		=> $cartDetails->genuineShippFee,
									'categoryCommission'    => $cartDetails->categoryCommission,	 
									'marketingProductId'	=> $cartDetails->marketingProductId,
									'productWeight'      	=> $cartDetails->productWeight,
									'cashHandlingPrice'     => $handlingPrice,	
									'pickupProccessPrice'   => 0,
									'retailerDiscount'		=> $cartDetails->retailerDiscount,
									'freeShipCatId'			=> $cartDetails->freeShipCatId,
									'freeShipPrdId'			=> $cartDetails->freeShipPrdId,
									'productId'				=> $cartDetails->productId,
									'productImageId'		=> $cartDetails->productImageId,
									'isEconomicDelivery'    => 2,
									'inventoryHistoryId'	=> $cartDetails->inventoryHistoryId,
									'pointeForceVerifiedStatus'	=> $pointeForceVerifiedStatus,
									'spacepointeCommission2'	=> $cartDetails->spacePointePrice2,				
									'totalCommissionPrice'      => $cartDetails->quantity*$cartDetails->spacePointePrice2,
								);
					$this->custom_log->write_log('custom_log','order inserted array is '.print_r($orderArr,true));
																	
					$orderID  = $this->order_m->add_order($orderArr);
					$this->custom_log->write_log('custom_log','last inserted query is '.$this->db->last_query());
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
						
						$payOrderID     = $this->order_m->add_order_payment($orderID,$orderArr);
						$this->custom_log->write_log('custom_log','Payment order id is '.$payOrderID);
						
						if($payOrderID)
						{
							$orderTrackId = $this->order_m->add_order_track_details($orderID,1);
							$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
										
							$orderDropshipCenterId = $this->order_m->add_order_dropship_center($orderID,$orderArr);
							$this->custom_log->write_log('custom_log','order dropship center id is '.$orderDropshipCenterId);
							
							$freeShipOrderId = $this->order_m->add_order_free_shipping($orderID,$orderArr);
							$this->custom_log->write_log('custom_log','free shipping order id is '.$freeShipOrderId);
										
												
							if($this->order_m->reduce_product_quantity($cartDetails->organizationProductId,$cartDetails->quantity))
							{
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId);
								
								if($cartDetails->colorId)
								{
									if($cartDetails->marketingProductId)
									{
										$this->order_m->reduce_product_color_quantity_from_marketing($cartDetails->marketingProductId,$cartDetails->colorId,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->marketingProductId.' and color id is '.$cartDetails->colorId);
	
									}
									else
									{/*
										$this->order_m->reduce_product_color_quantity($cartDetails->organizationProductId,$cartDetails->colorId,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId.' and color id is '.$cartDetails->colorId);
									*/}
								}
								
								if($cartDetails->size)
								{
									if($cartDetails->marketingProductId)
									{
										$this->order_m->reduce_product_size_quantity_from_marketing($cartDetails->marketingProductId,$cartDetails->size,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from marketing product id is '.$cartDetails->organizationProductId.' and size is '.$cartDetails->size);	
									}
									else
									{/*
										$this->order_m->reduce_product_size_quantity($cartDetails->organizationProductId,$cartDetails->size,$cartDetails->quantity);
										$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationProductId.' and size is '.$cartDetails->size);	
									*/}
								}	
								if((!empty($cartDetails->marketingProductId))&&($cartDetails->marketingProductId))
							{
							}
							elseif((!empty($cartDetails->organizationColorSizeId))&&($cartDetails->organizationColorSizeId))							
							{
								$this->order_m->reduce_orgnization_product_color_size_quantity($cartDetails->organizationColorSizeId,$cartDetails->quantity);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								$this->custom_log->write_log('custom_log',$cartDetails->quantity.' quantity is reduce from '.$cartDetails->organizationColorSizeId);
							}
								$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
								$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
							
								/***order History****************/
								$orderHistoryId = $this->order_m->add_order_history($orderID,1);
								$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
								/***Order History****************/
	
							}
							
							$shippingVendor = '';
							$estimateDay    = 0;
							$rateDetails    = $this->shipping_m->shipping_vendor_details($cartDetails->shippingRateId);
							$estimateDay    = $rateDetails->ETA+$this->config->item('estimated_time_increase');									
							$shippingVendor = $rateDetails->organizationName;
							$this->custom_log->write_log('custom_log','shipping rate details is '.print_r($rateDetails,true));
							
							$customerShippDet = $this->customer_m->address_details($shippCusAddId);
							$this->custom_log->write_log('custom_log','Customer shipping details is '.print_r($customerShippDet,true));
							
							$shippingAddName  = $customerShippDet->firstName.' '.$customerShippDet->lastName;
							$shippingAddress  = $customerShippDet->addressLine1.' '.$customerShippDet->address_Line2.' '.$customerShippDet->cityName.','.$customerShippDet->areaName.' '.$customerShippDet->stateName.' - '.$customerShippDet->zip;
							$retailerDet = $this->order_m->order_retailer_with_product_details($cartDetails->organizationProductId);
							$this->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDet,true));
							
							$imagePath = base_url().'img/no_image.jpg';
							if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
							{
								$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
							}
							
							$color = '';
							$size = '';
							
							/**********mail for customer***************/	
							$mailData = array(
												'email'           => $this->session->userdata('userEmail'),
												'cc'			  => '',
												'bcc'			  => 'neworders@spacepointe.com',
												'slug'            => 'order_placed_for_customer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'Your Order Has Been Placed',
												'pickupCenter'    =>  ''
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
							
							$mailData = array(
												'email'           => 'neworders@spacepointe.com',
												'cc'			  => '',
												'bcc'			  => '',
												'slug'            => 'order_placed_for_customer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'Your Order Has Been Placed',
												'pickupCenter'    =>  ''
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
							/******mail for retailer*******/
							$mailData = array(
												'email'           => $retailerDet->email,
												'cc'	          => '',
												'slug'            => 'order_placed_for_retailer',
												'customerName'    => $this->session->userdata('userName'),
												'customerPhone'	  => $customerShippDet->phone,
												'orderId'		  => $customOrderId,
												'eta'			  => $estimateDay,
												'shippingVendor'  => $shippingVendor,
												'shippingAddName' => $shippingAddName,
												'shippingAddress' => $shippingAddress,
												'sellerName'      => $retailerDet->organizationName,
												'imagePath'		  => $imagePath,
												'productName'	  => $retailerDet->code,
												'currentPrice'	  => number_format($displayPrice,2),
												'quantity'		  => $cartDetails->quantity,
												'subTotal'		  => number_format(($displayPrice*$cartDetails->quantity),2),
												'color'			  => $color,
												'size'			  => $size,
												'totalAmount'	  => number_format($displayPrice*$cartDetails->quantity,2),
												'subject'  		  => 'An order has been placed',
												'pickupCenter'    => '',
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
							
							$message=' An Order for '.$cartDetails->quantity.substr($retailerDet->code,0,20).'  has been placed. Please confirm in the panel.';
							$response = $this->twillo_m->send_mobile_message($retailerDet->businessPhoneCode.$retailerDet->businessPhone,$message);
							
							$customer_order_message=substr($retailerDet->code,0,20).', order #  '.$customOrderId.' has been accepted & will be delivered in '.$estimateDay.' days.';
							$response = $this->twillo_m->send_mobile_message('+234'.$customerShippDet->phone,$customer_order_message);
							
							$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
							$response = $this->twillo_m->send_mobile_message($retailerDet->businessPhoneCode.$retailerDet->businessPhone ,$message);
							$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
							
							/*********add order pointeforce commission***********/
							if((!empty($isPointeForce))&&($isPointeForce))
							{
								$orderPointeForceId = $this->order_m->add_order_pointe_force_commission($orderID,$orderArr);
								$this->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
							}
							/*********add order pointeforce commission***********/
							
							$this->cart_m->remove_from_cart($cartId);							
							$this->cart->destroy();
							$this->session->unset_userdata('isPickUp');
							$this->session->unset_userdata('isChkAvl');
							$this->session->unset_userdata('isBuyNowPickUp');
							$this->session->unset_userdata('shippingAddressId');
							$this->session->set_flashdata('success','Order created successfully');
							$this->custom_log->write_log('custom_log','Order created successfully');
							redirect(base_url().'frontend/order/order_complete_success/'.id_encrypt($atATimeProduct));
						}
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
				
					$dropshipId  = $cartDetails->toDropshipId;
					$totalWeight = $cartDetails->productWeight;
					$stateId	 = $result['stateId'];
					$areaId	     = $result['areaId'];
					$cityId		 = $result['cityId'];
					$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);
					$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
					
					if(!empty($shipRateDet))
					{
						if($this->cart_m->update_shipping_address_buy_now_delivery($cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId))
						{
							$this->cart_m->update_buy_now_delivery($cartId);
							$this->custom_log->write_log('custom_log','updated cart as buy now delivery');
							
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
								//redirect(base_url().'frontend/product_buy_now/order_buy_now_delivery/'.id_encrypt($cartId));
							}
							else
							{
								$this->session->set_flashdata('error','Shipping information not add');
								$this->custom_log->write_log('custom_log','Shipping information not add');
							}						
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
					}
					redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
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
		$this->data['cartId']         = $cartId;
		$this->data['shippCusAddId']  = $shippCusAddId;
		//echo "<pre>"; print_r($shippCusDet); exit;
		$this->frontendCustomView('product_buy_now/shipping_address',$this->data);
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
	
	public function check_shipping_delivery_here($cartId=0,$addressId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'check_shipping_delivery_here',
                'log_MID'    => ''
		) );
		
		$cartId    = id_decrypt($cartId);
		$addressId = id_decrypt($addressId);
		$this->custom_log->write_log('custom_log','cart id is '.$cartId.' and shipping address id is '.$addressId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		if(!$addressId)
		{
			$this->session->set_flashdata('error','address id not found');
			$this->custom_log->write_log('custom_log','address id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}		
		
		$shippCusDet = $this->customer_m->address_details($addressId);
		$this->custom_log->write_log('custom_log','shipping address details is '.print_r($shippCusDet,true));
		if(empty($shippCusDet))
		{
			$this->session->set_flashdata('error','shipping address not found');
			$this->custom_log->write_log('custom_log','shipping address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		$dropshipId  = $cartDetails->toDropshipId;
		$totalWeight = $cartDetails->productWeight;
		$stateId	 = $shippCusDet->state;
		$areaId	     = $shippCusDet->area;
		$cityId		 = $shippCusDet->city;
		$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);
		$this->custom_log->write_log('custom_log','last  query is '.$this->db->last_query());
		$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
		
		if(!empty($shipRateDet))
		{
			if($this->cart_m->update_shipping_address_buy_now_delivery($cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId))
			{
				$this->cart_m->update_buy_now_delivery($cartId);
				$this->custom_log->write_log('custom_log','updated cart as buy now delivery');
				
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
		}
		redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
	}
	
	public function order_buy_now_delivery($cartId=0)
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_buy_now_delivery',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found,Please try again');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}		
		
		$shippCusDet    			= $this->customer_m->address_details($shippCusAddId);
		$this->data['purchaseFrom'] = 2;
		$this->data['shippCusDet']  = $shippCusDet;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['cartId']       = $cartId;		
		$this->data['isPickUp']     = 0;
		$this->data['payOnPickUp']  = 0;
		$this->data['isEconomicDelivery'] = 0;
		$this->frontendCustomView('checkout/order',$this->data);	
	}
	
	public function pickup_address($cartId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'pickup_address',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Pickup Address';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		//echo "<pre>"; print_r($cartDetails); exit;
		$this->data['stateList']     = $this->location_m->pickup_state_list();
		$this->data['cartDetails']   = $cartDetails;
		$this->data['cartId']        = $cartId;
		$this->data['pickupId']      = $cartDetails->pickupId;
		$this->data['pickUpStateId'] = 12;
		$payOnPickUp   = 0;
		$pickupAddress = '';
		
		if($cartDetails->pickupId)
		{
			$pickupAddress = $this->retailer_m->pickup_address_details($cartDetails->pickupId);
			$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
				
			$this->data['pickUpStateId'] = $pickupAddress->state;
			$pickupAddressLine1 = $pickupAddress->addressLine1;
			
			if(!empty($pickupAddressLine1))
			{
				$checkDropshipAress = $this->cart_m->dropshipDetails($cartDetails->toDropshipId);
				$this->custom_log->write_log('custom_log','dropship details is '.print_r($checkDropshipAress,true));
					
				if(!empty($checkDropshipAress))
				{
					$dropShipAdd1 = $checkDropshipAress->addressLine1;
					$this->custom_log->write_log('custom_log','Condition is (!empty('.$dropShipAdd1.'))&&(!empty('.$pickupAddressLine1.'))&&('.$pickupAddressLine1.'=='.$dropShipAdd1.')');
					
					if((!empty($dropShipAdd1))&&(!empty($pickupAddressLine1))&&($pickupAddressLine1==$dropShipAdd1))
					{
						$payOnPickUp = 1;
					}
				}
				$this->custom_log->write_log('custom_log','Pay on pickup is '.$payOnPickUp);
			}		
		}
		$this->data['pickupAddress'] = $pickupAddress;
		$this->data['payOnPickUp']   = $payOnPickUp;
		//echo "<pre>"; print_r($pickupAddress); exit;
		$this->frontendCustomView('product_buy_now/pickup_address',$this->data);
	}
	
	public function pickup_list()
	{
    	$stateId  = $this->input->post('stateId');
		$cartId   = $this->input->post('cartId');
		$pickupId = $this->input->post('pickupId');
        $this->data['pickUpList'] = $this->retailer_m->pickup_with_address_list_states($stateId);
		$this->data['cartId']     = $cartId;
		$this->data['pickupId']   = $pickupId;
        echo $this->load->view('product_buy_now/pickup_list',$this->data);
	}
	
	public function check_pickup_here($cartId=0,$pickupId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'check_pickup_here',
                'log_MID'    => ''
		) );
		
		$cartId   = id_decrypt($cartId);
		$pickupId = id_decrypt($pickupId);
		$this->custom_log->write_log('custom_log','cart id is '.$cartId.' and pickup id is '.$pickupId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
				
		if(!$pickupId)
		{
			$this->session->set_flashdata('error','Pick address id not found');
			$this->custom_log->write_log('custom_log','Pick address id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/pickup_address/'.id_encrypt($cartId));
		}
		
		$pickupAddress = $this->retailer_m->pickup_address_details($pickupId);
		$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
		if(empty($pickupAddress))		
		{		
			$this->session->set_flashdata('error','Pickup address details not found');
			$this->custom_log->write_log('custom_log','Pickup address details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/pickup_address/'.id_encrypt($cartId));		
		}
		$pickupAddressLine1 = $pickupAddress->addressLine1;
		$pickUpStateId	    = $pickupAddress->state;
		$pickUpAreaId	    = $pickupAddress->area;
		$pickUpCityId	    = $pickupAddress->city;
		$payOnPickUp 		= 0;		
		
		if($this->cart_m->change_pickup_address($cartId,$pickupId))
		{
			$this->session->set_userdata('isBuyNowPickUp',1);							
			$this->session->set_flashdata('success','Pick address added in buy now cart successfully');
			$this->custom_log->write_log('custom_log','Pick address added in buy now cart successfully');
			
			if(!empty($pickupAddressLine1))
			{
				$checkDropshipAress = $this->cart_m->dropshipDetails($cartDetails->toDropshipId);
				$this->custom_log->write_log('custom_log','dropship details is '.print_r($checkDropshipAress,true));
				if(!empty($checkDropshipAress))
				{
					$dropShipAdd1 = $checkDropshipAress->addressLine1;
					$this->custom_log->write_log('custom_log','Condition is (!empty('.$dropShipAdd1.'))&&(!empty('.$pickupAddressLine1.'))&&('.$pickupAddressLine1.'=='.$dropShipAdd1.')');
						
					if((!empty($dropShipAdd1))&&(!empty($pickupAddressLine1))&&($pickupAddressLine1==$dropShipAdd1))
					{
						$payOnPickUp = 1;
					}
					else
					{
						$payOnPickUp = 0;
					}
				}
				$this->custom_log->write_log('custom_log','Pay on pickup is '.$payOnPickUp);
			}			
		}		
		else
		{
			$this->session->set_flashdata('error','Pick address not add in buy now cart');
			$this->custom_log->write_log('custom_log','Pick address not add in buy now cart');
		}
		
		if((!empty($pickUpCityId))&&($pickUpCityId))
		{
			$shipRateDet = $this->shipping_m->check_avaibility($cartDetails->toDropshipId,$pickUpStateId,$pickUpAreaId,$pickUpCityId,$cartDetails->productWeight);
			$this->custom_log->write_log('custom_log','according pickup city id Shipping rate details is '.print_r($shipRateDet,true));
		}
		elseif((!empty($pickUpAreaId))&&($pickUpAreaId))
		{
			$shipRateDet = $this->shipping_m->check_avaibility_area($cartDetails->toDropshipId,$pickUpStateId,$pickUpAreaId,$cartDetails->productWeight);
			$this->custom_log->write_log('custom_log','according pickup area id Shipping rate details is '.print_r($shipRateDet,true));
		}
		elseif((!empty($pickUpStateId))&&($pickUpStateId))
		{
			$shipRateDet = $this->shipping_m->check_avaibility_state($cartDetails->toDropshipId,$pickUpStateId,$cartDetails->productWeight);
			$this->custom_log->write_log('custom_log','according pickup state id Shipping rate details is '.print_r($shipRateDet,true));
		}
		
		if((!empty($shipRateDet))&&($shipRateDet))
		{
			$this->cart_m->update_shipping_address_buy_now_delivery($cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId);
			$this->custom_log->write_log('custom_log','shipping vendor and shipping rate updated in cart id is '.$cartId.' and shipping organization id is '.$shipRateDet->shippingOrgId.' and shipping rate id is '.$shipRateDet->shippingRateId);
		}
		
		redirect(base_url().'frontend/product_buy_now/order_buy_now_pickup/'.id_encrypt($cartId));
	}
	
	public function order_buy_now_pickup($cartId=0)
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_buy_now_pickup',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		$cartId   			 = id_decrypt($cartId);
		$pickUpStateId       = 0;
		$pickupProccessPrice = 0;
		$payOnPickUp		 = 0;
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail_pickup($cartId);
		$this->custom_log->write_log('custom_log','Buy Now details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/pickup_address/'.id_encrypt($cartId));
		}
		
		$pickUpId  = $cartDetails->pickupId;
		$pickUpDet = $this->cart_m->pickupDetails($pickUpId);
		$this->custom_log->write_log('custom_log','Pickup details is '.print_r($pickUpDet,true));
		
		if(!empty($pickUpDet))
		{
			$pickUpAddress1 = $pickUpDet->addressLine1;
			$pickUpStateId  = $pickUpDet->state;
		}
		$productWeight = $cartDetails->productWeight;
		
		if($cartDetails->genuineShippFee)
		{
			$checkDropshipAress = $this->cart_m->dropshipDetails($cartDetails->toDropshipId);	
			$this->custom_log->write_log('custom_log','dropship address details is '.print_r($checkDropshipAress,true));
			$this->custom_log->write_log('custom_log',"second conditon is ".$cartDetails->toDropshipId.' and '.$pickUpStateId.' and '.$cartDetails->toDropshipId.'=='.$pickUpStateId);
			$this->custom_log->write_log('custom_log',"Third conditon is ".$cartDetails->toDropshipId.' and '.$pickUpStateId.' and '.$cartDetails->toDropshipId.'!='.$pickUpStateId);
			$dropShipAdd1 = '';
			if(!empty($checkDropshipAress))
			{
				$dropShipAdd1 = $checkDropshipAress->addressLine1;
			}
			
			if((!empty($dropShipAdd1))&&(!empty($pickUpAddress1))&&($pickUpAddress1==$dropShipAdd1))
			{
				$pickupProccessPrice = ($cartDetails->productAmt*3)/100;
			}
			elseif((!empty($checkDropshipAress->state))&&(!empty($pickUpStateId))&&($checkDropshipAress->state==$pickUpStateId))
			{
				$maxDet = $this->shipping_m->max_rate_from_dropship_to_pickup_state($cartDetails->toDropshipId,$pickUpStateId,$productWeight);
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
				$maxDet = $this->shipping_m->max_rate_from_dropship_to_pickup_state($cartDetails->toDropshipId,$pickUpStateId,$productWeight);
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
		elseif($cartDetails->cashAdminFee)
		{								
			$this->custom_log->write_log('custom_log',"Third conditon is ".$cartDetails->toDropshipId.' and '.$pickUpStateId.' and '.$cartDetails->toDropshipId.'!='.$pickUpStateId);
			if((!empty($checkDropshipAress->state))&&(!empty($pickUpStateId))&&($checkDropshipAress->state!=$pickUpStateId))
			{
				$maxDet = $this->shipping_m->max_rate_from_dropship_to_pickup_state($cartDetails->toDropshipId,$pickUpStateId,$productWeight);
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
					$cashAdminPrice = $cartDetails->cashAdminPrice;
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
		if($this->cart_m->update_pickup_processing_price($cartDetails->cartId,$pickupProccessPrice))
		{
			$this->custom_log->write_log('custom_log','Pick up processing fee updated');
		}			
					
		$cartDetails = $this->cart_m->buy_now_cart_page_detail_pickup($cartId);
		$this->custom_log->write_log('custom_log','Buy Now details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/pickup_address/'.id_encrypt($cartId));
		}
		
		$this->data['purchaseFrom'] = 2;
		$this->data['cartId']       = $cartId;		
		$this->data['isPickUp']     = 1;
		$this->data['payOnPickUp']  = 0;
		$this->data['cartDetails']  = $cartDetails;
		$pickupAddress = '';
		if($cartDetails->pickupId)
		{
			$pickupAddress = $this->retailer_m->pickup_address_details($cartDetails->pickupId);	
		}
		$this->data['pickupAddress'] = $pickupAddress;		
		$this->data['isEconomicDelivery'] = 0;
		$this->data['productTypeId'] = $cartDetails->productTypeId;
		$this->frontendCustomView('checkout/order',$this->data);	
	}
	
	public function pay_on_pickup_pay_online($cartId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'pickup_address',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Pickup Address';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		//echo "<pre>"; print_r($cartDetails); exit;
		$this->data['stateList']     = $this->location_m->pickup_state_list();
		$this->data['cartDetails']   = $cartDetails;
		$this->data['cartId']        = $cartId;
		$this->data['pickupId']      = $cartDetails->pickupId;
		$this->data['pickUpStateId'] = 12;
		$payOnPickUp   = 0;
		$pickupAddress = '';
		
		if($cartDetails->pickupId)
		{
			$pickupAddress = $this->retailer_m->pickup_address_details($cartDetails->pickupId);
			$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
				
			$this->data['pickUpStateId'] = $pickupAddress->state;
		}
		$this->data['pickupAddress'] = $pickupAddress;
		$this->data['payOnPickUp']   = $payOnPickUp;
		//echo "<pre>"; print_r($pickupAddress); exit;
		$this->frontendCustomView('product_buy_now/pay_on_pickup_pay_online',$this->data);
	}
	
	public function order_buy_now_economic_delivery($cartId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_buy_now_economic_delivery',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found,Please try again');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$shippCusDet = $this->customer_m->address_details($shippCusAddId);
		$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
		
		$totalWeight = $cartDetails->productWeight*$cartDetails->quantity;
		$stateId	 = $shippCusDet->state;
		$areaId	     = $shippCusDet->area;
		$cityId		 = $shippCusDet->city;
		$dropshipId  = $cartDetails->toDropshipId;
		$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);
		$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
		
		$retailerRow = array();
		$retailerRow['organizationId'] 	   = $cartDetails->organizationId;
		$retailerRow['retailerId']     	   = $cartDetails->organizationId;
		$retailerRow['toDropshipId'] 	   = $cartDetails->toDropshipId;
		$retailerRow['totalProductWeight'] = $totalWeight;
		$retailerRow['isCalculateShipp'] = 0;
		if($cartDetails->freeShipPrdId)
		{}
		elseif($cartDetails->freeShipCatId)
		{}
		elseif($cartDetails->genuineShippFee)
		{
			$retailerRow['isCalculateShipp'] = 1;
		}
		
		if(!empty($shipRateDet))
		{
			$retailerRow['finalShippingOrgId']  = $shipRateDet->shippingOrgId;
			$retailerRow['finalShippingRateId'] = $shipRateDet->shippingRateId;
			
			$this->cart_m->unactive_old_retailer_standard_delivery($retailerRow);
			if((!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
			{
				$cartEconomicalId = $this->cart_m->add_standard_delivery($retailerRow);
				$this->custom_log->write_log('custom_log','card economical id is '.$cartEconomicalId);
				if($cartEconomicalId)
				{
					redirect(base_url().'frontend/product_buy_now/order_economic_delivery/'.id_encrypt($cartId));
				}
				else
				{
					$this->session->set_flashdata('error','Economic details not add in cart');
					$this->custom_log->write_log('custom_log','Economic details not add in cart');
					redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
				}
			}
			else
			{
				$this->session->set_flashdata('error','Shipping vendor details not found');
				$this->custom_log->write_log('custom_log','Shipping vendor details not found');
				redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
			}
		}
		else
		{
			$this->session->set_flashdata('error','Shipping vendor not available in your city');
			$this->custom_log->write_log('custom_log','Shipping vendor not available in your city');
			redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
	}
	
	public function order_economic_delivery($cartId)
	{	
		$this->session->set_userdata(array(
                'log_MODULE' => 'order_standard_delivery',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Order Details';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			$this->session->unset_userdata('shippingAddressId');
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found,Please try again');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
			$this->session->unset_userdata('shippingAddressId');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$shippCusDet    			= $this->customer_m->address_details($shippCusAddId);
		$this->data['purchaseFrom'] = 2;
		$this->data['shippCusDet']  = $shippCusDet;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['cartId']       = $cartId;		
		$this->data['isPickUp']     = 0;
		$this->data['payOnPickUp']  = 0;
		$this->data['isEconomicDelivery'] = 1;
		$this->frontendCustomView('checkout/order',$this->data);		
	}
	
	public function economical_shipping_amount($cartId)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'economical_shipping_amount',
                'log_MID'    => ''
		) );
		
		$cartId = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$this->data['cartId'] = $cartId;
		$result = array('success' => 0,'message' => '','shippingAmt' => 0,'totalShippingAmt' => 0,'viewfile' => '');	
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			if((!empty($cartId))&&($cartId))
			{
				$shippCusAddId = $this->session->userdata('shippingAddressId');
				$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
				if((!empty($shippCusAddId))&&($shippCusAddId))
				{
					$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
					$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
					if(!empty($cartDetails))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
							$totalWeight = $cartDetails->productWeight*$cartDetails->quantity;
							$dropshipId  = $cartDetails->toDropshipId;
							$stateId	 = $shippCusDet->state;
							$areaId	     = $shippCusDet->area;
							$cityId		 = $shippCusDet->city;
							$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
							$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
						
							$retailerCart = array();
							$retailerCart['finalShippingOrgId']  = 0;
							$retailerCart['finalShippingRateId'] = 0;
							$retailerCart['isCalculateShipp']    = 0;
							$retailerCart['retailerId'] 		 = $cartDetails->organizationId;
							$retailerCart['toDropshipId'] 		 = $dropshipId;
							$retailerCart['totalProductWeight']  = $totalWeight;
						
							if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
							{
								$retailerCart['finalShippingOrgId']  = $shipRateDet->shippingOrgId;
								$retailerCart['finalShippingRateId'] = $shipRateDet->shippingRateId;
								
								$result['success'] = 1;
								if($cartDetails->freeShipPrdId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->freeShipCatId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->genuineShippFee)
								{
									$shippingRate = $shipRateDet->amount;
									if($totalWeight>10)
									{
										$shippingRate = $shippingRate*$totalWeight;
									}
									$result['shippingAmt'] = $shippingRate;
									$retailerCart['isCalculateShipp'] = 1;
								}
								
								if($result['shippingAmt'])
								{
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
					
								if((!empty($retailerCart['finalShippingOrgId']))&&($retailerCart['finalShippingOrgId']))
								{				
									$this->cart_m->unactive_old_retailer_standard_delivery($retailerCart);
									$cartStandardId = $this->cart_m->add_standard_delivery($retailerCart);
									$this->custom_log->write_log('custom_log','card economical id is '.$cartStandardId);
								}
								$this->data['totalAmount'] = $totalAmount+$result['shippingAmt'];
								
								$this->data['productTypeId'] = $cartDetails->productTypeId;
								$result['viewfile'] = $this->load->view('checkout/order_economical_buy_now',$this->data,true);
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = 'Shipping vendor not available in your city';
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
						$result['message'] = 'Buy now details not found,Please try again';
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
				$result['message'] = 'Buy now cart id not found';
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
	
	public function economic_cash_handling_amount($cartId)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'economic_cash_handling_amount',
                'log_MID'    => ''
		) );
		
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$this->data['cartId'] = $cartId;
		$result = array('success' => 0,'message' => '','cashHandlingAmt' => 0,'totalAmount' => 0);	
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			if((!empty($cartId))&&($cartId))
			{
				$shippCusAddId = $this->session->userdata('shippingAddressId');
				$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
				if((!empty($shippCusAddId))&&($shippCusAddId))
				{
					$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
					$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
					if(!empty($cartDetails))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
							$totalWeight = $cartDetails->productWeight*$cartDetails->quantity;
							$dropshipId  = $cartDetails->toDropshipId;
							$stateId	 = $shippCusDet->state;
							$areaId	     = $shippCusDet->area;
							$cityId		 = $shippCusDet->city;
							$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
							$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
							if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
							{
								$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
								$result['success'] = 1;
								
								if($cartDetails->freeShipPrdId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->freeShipCatId)
								{
									$result['message'] = 'Free Shipping';			
								}
								elseif($cartDetails->genuineShippFee)
								{
									$shippingRate = $shipRateDet->amount;
									if($totalWeight>10)
									{
										$shippingRate = $shippingRate*$totalWeight;
									}
									$result['shippingAmt'] = $shippingRate;
								}
								else
								{				
									$result['message'] = 'Free Shipping';			
								}
							
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
								$result['cashHandlingAmt'] = '&#x20A6;'.number_format($cashHandlingAmt,2);
								$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);
							}
							else
							{
								$result['success'] = 0;
								$result['message'] = 'Shipping vendor not available in your city';
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
						$result['message'] = 'Buy now details not found,Please try again';
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
				$result['message'] = 'Buy now cart id not found';
			}
		}
		else
		{
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');
		}
		echo json_encode($result);
	}
	
	public function standard_shipping_amount($cartId)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'standard_shipping_amount',
                'log_MID'    => ''
		) );
		
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$this->data['cartId'] = $cartId;
		$result = array('success' => 0,'message' => '','shippingAmt' => 0,'totalShippingAmt' => 0,'viewfile' => '');	
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			if((!empty($cartId))&&($cartId))
			{
				$shippCusAddId = $this->session->userdata('shippingAddressId');
				$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
				if((!empty($shippCusAddId))&&($shippCusAddId))
				{
					$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
					$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
					if(!empty($cartDetails))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
							$totalWeight = $cartDetails->productWeight;
							$dropshipId  = $cartDetails->toDropshipId;
							$stateId	 = $shippCusDet->state;
							$areaId	     = $shippCusDet->area;
							$cityId		 = $shippCusDet->city;
							$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
							$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
							if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
							{
								$this->cart_m->update_shipping_address_buy_now_delivery($cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								
								$result['success'] = 1;
								if($cartDetails->freeShipPrdId)
								{			
									$result['message'] = 'Free Shipping';			
								}
								elseif($cartDetails->freeShipCatId)
								{
									$result['message'] = 'Free Shipping';			
								}
								elseif($cartDetails->genuineShippFee)
								{
									$shippingRate = $shipRateDet->amount*$cartDetails->quantity;
									if($totalWeight>10)
									{
										$shippingRate = $shippingRate*$totalWeight;
									}
									$result['shippingAmt'] = $shippingRate;
								}
								else
								{
									$result['message'] = 'Free Shipping';			
								}
				
								if($result['shippingAmt'])
								{
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
			
								$this->data['totalAmount']   = $totalAmount+$result['shippingAmt'];								
								$this->data['productTypeId'] = $cartDetails->productTypeId;
								$result['viewfile'] = $this->load->view('checkout/order_standard_buy_now',$this->data,true);
							}
							else
							{							
								$result['success'] = 0;
								$result['message'] = 'Shipping vendor not available in your city';							
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
						$result['message'] = 'Buy now details not found,Please try again';
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
				$result['message'] = 'Buy now cart id not found';
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
	
	public function standard_cash_handling_amount($cartId)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'standard_cash_handling_amount',
                'log_MID'    => ''
		) );
		
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$this->data['cartId'] = $cartId;
		$result = array('success' => 0,'message' => '','cashHandlingAmt' => 0,'totalAmount' => 0,'shippingAmt' => 0);
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			if((!empty($cartId))&&($cartId))
			{
				$shippCusAddId = $this->session->userdata('shippingAddressId');
				$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
				if((!empty($shippCusAddId))&&($shippCusAddId))
				{
					$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
					$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
					if(!empty($cartDetails))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
							$totalWeight = $cartDetails->productWeight;
							$dropshipId  = $cartDetails->toDropshipId;
							$stateId	 = $shippCusDet->state;
							$areaId	     = $shippCusDet->area;
							$cityId		 = $shippCusDet->city;
							$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
							$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
							if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
							{
								$result['success'] = 1;
								if($cartDetails->freeShipPrdId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->freeShipCatId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->genuineShippFee)
								{
									$shippingRate = $shipRateDet->amount*$cartDetails->quantity;
									if($totalWeight>10)
									{
										$shippingRate = $shippingRate*$totalWeight;
									}
									$result['success']     = 1;
									$result['shippingAmt'] = $shippingRate;
								}
								else
								{
									$result['message'] = 'Free Shipping';			
								}
			
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
								
								$result['cashHandlingAmt'] = '&#x20A6;'.number_format($cashHandlingAmt,2);
								$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);
							}
							else
							{							
								$result['success'] = 0;
								$result['message'] = 'Shipping vendor not available in your city';
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
						$result['message'] = 'Buy now details not found,Please try again';
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
				$result['message'] = 'Buy now cart id not found';
			}
		}
		else
		{		
			$result['success'] = 0;
			$result['message'] = $this->lang->line('error_user_login');		
		}
		echo json_encode($result);
	}
	
	public function refresh_capthca()
	{
		$original_string = array_merge(range(0,9),range('a','z'),range('A','Z'));
		$original_string = implode("",$original_string);
		$captcha         = substr(str_shuffle($original_string),0,5);
		$values			 = array(
								'word'        => $captcha,
								'word_length' => 5,
								'img_path'    => './uploads/captch/',
								'img_url'     => base_url().'uploads/captch/',
								'font_path'   => base_url().'system/fonts/texb.ttf',
								'img_width'   => '200',
								'img_height'  => 50,
								'expiration'  => 3600
							);
		$data   = create_captcha($values);
		$result = $data['image'].'<input type="hidden" name="captchaVal" value="'.$data['word'].'"/>';
		echo $result;
	}
	
	public function same_day_delivery_shipping_amount($cartId)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'same_day_delivery_shipping_amount',
                'log_MID'    => ''
		) );
		
		$cartId = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$this->data['cartId'] = $cartId;
		$result = array(
					'success' 		   => 0,
					'message' 		   => '',
					'shippingAmt' 	   => 0,
					'totalShippingAmt' => 0,
					'viewfile' 		   => ''
					);	
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			if((!empty($cartId))&&($cartId))
			{
				$shippCusAddId = $this->session->userdata('shippingAddressId');
				$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
				if((!empty($shippCusAddId))&&($shippCusAddId))
				{
					$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
					$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
					if(!empty($cartDetails))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
							$totalWeight = $cartDetails->productWeight;
							$dropshipId  = $cartDetails->toDropshipId;
							$stateId	 = $shippCusDet->state;
							$areaId	     = $shippCusDet->area;
							$cityId		 = $shippCusDet->city;
							$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
							$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
							if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
							{
								
								$this->cart_m->update_shipping_address_buy_now_delivery($cartId,$shipRateDet->shippingOrgId,$shipRateDet->shippingRateId);
								$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
								
								$result['success'] = 1;
								if($cartDetails->freeShipPrdId)
								{			
									$result['message'] = 'Free Shipping';			
								}
								elseif($cartDetails->freeShipCatId)
								{
									$result['message'] = 'Free Shipping';			
								}
								elseif($cartDetails->genuineShippFee)
								{
									$shippingRate = $shipRateDet->amount*$cartDetails->quantity;
									if($totalWeight>10)
									{
										$shippingRate = $shippingRate*$totalWeight;
									}
									$result['shippingAmt'] = $shippingRate+$this->config->item('flate_rate_same_day_delivery');
								}
								else
								{
									$result['message'] = 'Free Shipping';			
								}
								
								if($result['shippingAmt'])
								{
									$result['totalShippingAmt'] = '&#x20A6;'.$result['shippingAmt'];
								}
								else
								{
									$result['totalShippingAmt'] = 'Free';
								}
								$this->data['totalAmount']   = $totalAmount+$result['shippingAmt'];								
								$this->data['productTypeId'] = $cartDetails->productTypeId;
								$result['viewfile'] 		 = $this->load->view('checkout/order_same_day_shipping_amount_buy_now',$this->data,true);
							}
							else
							{							
								$result['success'] = 0;
								$result['message'] = 'Shipping vendor not available in your city';							
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
						$result['message'] = 'Buy now details not found,Please try again';
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
				$result['message'] = 'Buy now cart id not found';
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
	
	public function same_day_delivery_cash_handling_amount($cartId)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'same_day_delivery_cash_handling_amount',
                'log_MID'    => ''
		) );
		
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$this->data['cartId'] = $cartId;
		$result = array(
						'success' => 0,
						'message' => '',
						'cashHandlingAmt' => 0,
						'totalAmount' => 0,
						'shippingAmt' => 0
					);
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if((!empty($userId))&&($userId))
		{
			if((!empty($cartId))&&($cartId))
			{
				$shippCusAddId = $this->session->userdata('shippingAddressId');
				$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
				if((!empty($shippCusAddId))&&($shippCusAddId))
				{
					$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
					$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
					if(!empty($cartDetails))
					{
						$shippCusDet = $this->customer_m->address_details($shippCusAddId);
						$this->custom_log->write_log('custom_log','Shipping details is '.print_r($shippCusDet,true));
						
						if(!empty($shippCusDet))
						{
							$totalAmount = $cartDetails->quantity*$cartDetails->productAmt;
							$totalWeight = $cartDetails->productWeight;
							$dropshipId  = $cartDetails->toDropshipId;
							$stateId	 = $shippCusDet->state;
							$areaId	     = $shippCusDet->area;
							$cityId		 = $shippCusDet->city;
							$shipRateDet = $this->shipping_m->check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight);	
							$this->custom_log->write_log('custom_log','Shipping rate details is '.print_r($shipRateDet,true));
							if((!empty($shipRateDet))&&(!empty($shipRateDet->shippingOrgId))&&($shipRateDet->shippingOrgId))
							{
								$result['success'] = 1;
								if($cartDetails->freeShipPrdId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->freeShipCatId)
								{
									$result['message'] = 'Free Shipping';
								}
								elseif($cartDetails->genuineShippFee)
								{
									$shippingRate = $shipRateDet->amount*$cartDetails->quantity;
									if($totalWeight>10)
									{
										$shippingRate = $shippingRate*$totalWeight;
									}
									$result['success']     = 1;
									$result['shippingAmt'] = $shippingRate+$this->config->item('flate_rate_same_day_delivery');
								}
								else
								{
									$result['message'] = 'Free Shipping';			
								}
			
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
								
								$result['cashHandlingAmt'] = '&#x20A6;'.number_format($cashHandlingAmt,2);
								$result['totalAmount']     = '&#x20A6;'.number_format($totalAmount,2);
							}
							else
							{							
								$result['success'] = 0;
								$result['message'] = 'Shipping vendor not available in your city';
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
						$result['message'] = 'Buy now details not found,Please try again';
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
				$result['message'] = 'Buy now cart id not found';
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