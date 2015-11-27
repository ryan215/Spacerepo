<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Checkout_cash extends MY_Controller {

	public function __construct() {
			
		parent::__construct(); 	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
		$this->load->model(array('cart_m','customer_m','pointe_force_m'));
		$this->load->library(array('cart','curl'));
		$this->load->helper(array('order_encrypt','captcha'));		
	}
	
	public function cash_on_delivery_buy_now($cartId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'cash_on_delivery_buy_now',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Cash On Delivery';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
            redirect(base_url());
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
            redirect(base_url());
		}
		
		if($_POST)
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
				
				$atATimeProduct = $cartDetails->cartId;
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
		
		$shippCusDet    			= $this->customer_m->address_details($shippCusAddId);
		$this->data['purchaseFrom'] = 2;
		$this->data['shippCusDet']  = $shippCusDet;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['cartId']       = $cartId;		
		$this->data['isPickUp']     = 0;
		$this->data['payOnPickUp']  = 0;
		$this->frontendCustomView('checkout/cash_on_delivery_buy_now',$this->data);
	}
	
	public function pay_on_pickup_buy_now($cartId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pay_on_pickup_buy_now',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Order Details';
		$pickUpStateId       = 0;
		$pickupProccessPrice = 0;
		$cartId   			 = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
            redirect(base_url());
		}
		
		$cartDetails = $this->cart_m->buy_now_cart_page_detail_pickup($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
            redirect(base_url());
		}
		
		if(!empty($cartDetails))
		{
			if($cartDetails->genuineShippFee)
			{
				$pickupProccessPrice = ($cartDetails->productAmt*8)/100;
			}
			else
			{
				$pickupProccessPrice = 0;
			}
			$this->custom_log->write_log('custom_log','pickup processing fee is '.$pickupProccessPrice.' for this cart id is '.$cartDetails->cartId);
			if($this->cart_m->update_pickup_processing_price($cartDetails->cartId,$pickupProccessPrice))
			{
				$this->custom_log->write_log('custom_log','Pick up processing fee updated');
			}						
			$cartDetails = $this->cart_m->buy_now_cart_page_detail_pickup($cartId);
		}
			
		//echo "<pre>"; print_r($cartDetails); exit;
		$this->custom_log->write_log('custom_log','Buy now details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
            redirect(base_url());
		}	
		
		if($_POST)
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
				
				$atATimeProduct = $cartDetails->cartId;
				$this->custom_log->write_log('custom_log','at a time purchas product id is '.$atATimeProduct);
				
				$retailerPrice = $cartDetails->retailerPrice;
				$productWeight = $cartDetails->productWeight;  
				$pickupId      = $cartDetails->pickupId;
				$displayPrice  = $cartDetails->productAmt;
				$amount        = ($cartDetails->productAmt*$cartDetails->quantity)+($cartDetails->pickupProccessPrice*$cartDetails->quantity);
				
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
								'isPickup'				=> 1,
								'pickupId'				=> $cartDetails->pickupId,
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
								'pickupProccessPrice'   => $cartDetails->pickupProccessPrice,
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
				
				$orderID = $this->order_m->add_order($orderArr);
				$this->custom_log->write_log('custom_log','last inserted query is '.$this->db->last_query());
				$this->custom_log->write_log('custom_log','Created order id is '.$orderID);
				
				if($orderID)
				{
					$orderaddressId = $this->order_m->add_order_address($orderID,0);
					$this->custom_log->write_log('custom_log','shipping order address id is '.$orderaddressId);
					
					$orderBillingId = $this->order_m->add_billing_order_address($orderID,0);							
					$this->custom_log->write_log('custom_log','Billing order address id is '.$orderBillingId);
					
					$payOrderID = $this->order_m->add_order_payment($orderID,$orderArr);
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
						}
						$this->session->set_flashdata('success',$this->lang->line('success_add_order'));
						$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_add_order'));
					}
					
					/***order History****************/
					$orderHistoryId = $this->order_m->add_order_history($orderID,1);
					$this->custom_log->write_log('custom_log','order history id is '.$orderHistoryId);
					/***Order History****************/
					
					$shippingVendor   = '';
					$estimateDay      = $this->config->item('estimated_time_increase');
					$shippingAddName  = '';
					$shippingAddress  = '';
					
					if((!empty($cartDetails->shippingRateId))&&($cartDetails->shippingRateId))
					{
						$rateDetails      = $this->shipping_m->shipping_vendor_details($cartDetails->shippingRateId);
						$this->custom_log->write_log('custom_log','Rate details is '.print_r($rateDetails,true));
						if(!empty($rateDetails))
						{
							$estimateDay = $rateDetails->ETA+$this->config->item('estimated_time_increase');
						}
					}
					
					$customerShippDet = $this->customer_m->user_profile_details($userId);
					$retailerDet      = $this->order_m->order_retailer_with_product_details($cartDetails->organizationProductId);
					$this->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDet,true));
						
					$imagePath = base_url().'img/no_image.jpg';
					if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
					{
						$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
					}
					$color = '';
					$size = '';
					
					/******Mail for Customer**********/
					$mailData = array(
									'email'           => $this->session->userdata('userEmail'),
									'cc'			  => '',
									'bcc'			  => 'neworders@spacepointe.com',
									'slug'            => 'pickup_order_placed_for_customer',
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
                                    'pickupCenter'    =>  $cartDetails->pickupName,
									'pickup_centre_address' => $cartDetails->addressLine1.','.$cartDetails->cityName.','.$cartDetails->areaName.','.$cartDetails->stateName,
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
									'slug'            => 'pickup_order_placed_for_customer',
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
                                    'pickupCenter'    =>  $cartDetails->pickupName,
									'pickup_centre_address' => $cartDetails->addressLine1.','.$cartDetails->cityName.','.$cartDetails->areaName.','.$cartDetails->stateName,
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
					/****Mail for Retailer**************/
					$mailData = array(
									'email'           => $retailerDet->email,
									'cc'	          => '',
									'slug'            => 'pickup_order_placed_for_retailer',
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
                                    'pickupCenter'    =>  $cartDetails->pickupName,
									'pickup_centre_address' => $cartDetails->addressLine1.','.$cartDetails->cityName.','.$cartDetails->areaName.','.$cartDetails->stateName,
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
					
					$customer_order_message = substr($retailerDet->code,0,20).', order # '.$customOrderId.',  has been received & will be at '.$cartDetails->pickupName.' in '.$estimateDay.' days. ';
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
				
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_add_order'));
					$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_add_order'));
				}
				
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
		
		$pickupAddress = $this->retailer_m->pickup_address_details($cartDetails->pickupId);
		$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
			
		$this->data['purchaseFrom'] = 2;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['cartId']       = $cartId;
		$this->data['pickupAddress'] = $pickupAddress;		
		$this->data['isPickUp']     = 1;
		$this->frontendCustomView('checkout/pay_on_pickup_buy_now',$this->data);
	}
	
	public function cash_on_delivered_add_to_cart()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cash_on_delivered_add_to_cart',
				'log_MID'    => '' 
		) );
				
		$userId     = $this->session->userdata('userId');
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			redirect(base_url());
        }
		
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart list not found');
			$this->custom_log->write_log('custom_log','cart list not found');
			redirect(base_url());
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
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
				$where    = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}
		}			
		$this->custom_log->write_log('custom_log','result is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		if($_POST)
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
					$atATimeProduct = 1;
					if(!empty($cartDetails))
					{
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
							$atATimeProduct = $row->cartId;
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
		
		$shippCusDet    			= $this->customer_m->address_details($shippCusAddId);
		$this->data['shippCusDet'] = $shippCusDet;
		$this->data['cartDetails'] = $cartDetails;
		$this->data['title']   	   = 'Cash On Delivered';
		$this->frontendCustomView('checkout/cash_on_delivered_add_to_cart',$this->data);
	}
	
	public function pay_on_pickup_add_to_cart()
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'pay_on_pickup_add_to_cart',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Pay On Pickup';
		
		$userId  = $this->session->userdata('userId');
		$customerDetails = $this->customer_m->get_customer_user_detail($userId);
				
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		$amount     = $this->cart->total();
		$showColumn = 0;
		if(!$total_cart)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
			$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_user_login'));
			redirect(base_url());
		}
		else
		{
			$pickupProccessPrice = 0;
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list_for_pickup($where);
				if(!empty($cartDetails))
				{
					foreach($cartDetails as $row)
					{
						if($row->genuineShippFee)
						{
							$pickupProccessPrice = ($row->productAmt*8)/100;
							$showColumn = 1;
						}
						else
						{
							$pickupProccessPrice = 0;
						}
						$this->custom_log->write_log('custom_log','pickup processing fee is '.$pickupProccessPrice.' for this cart id is '.$row->cartId);
						if($this->cart_m->update_pickup_processing_price($row->cartId,$pickupProccessPrice))
						{
							$this->custom_log->write_log('custom_log','Pick up processing fee updated');
						}						
					}
				}
			}
		}
		
		$pickupProccessPrice = 0;
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
				$cartDetails = $this->cart_m->cart_list_for_pickup($where);
			}
			
			if($_POST)
			{
				$this->custom_log->write_log('custom_log','after submit form is '.print_r($_POST,true));
				$rules = check_captcha_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					//echo "form is submit"; exit;
					$this->custom_log->write_log('custom_log','result is '.print_r($cartDetails,true));
					$customOrderIdCart = array();
					$customOrderIdRet = array();
					$totalSumPrice = 0;
					$atATimeProduct = 1;	
					if(!empty($cartDetails))
					{
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
								$customOrderIdCart[$row->cartId] = $customOrderIdRet[$retailerDet->organizationId];
								$totalSumPrice = $totalSumPrice+($row->productAmt*$row->quantity)+($row->pickupProccessPrice*$row->quantity);
							}
							$atATimeProduct = $row->cartId;
						}
					}
					$this->custom_log->write_log('custom_log','at a time purchase order id is '.$atATimeProduct);
					
					
					$amount = $totalSumPrice;
					$this->custom_log->write_log('custom_log','Total AMount is '.$amount);
					
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
					
					if(!empty($cartDetails))
					{
						foreach($cartDetails as $row)
						{
							$displayPrice = $row->productAmt;
							
							$orderArr = array(
											'orderTypeId'           => 2,										
											'totalAmount'           => $amount,
											'customerId'            => $this->session->userdata('userId'),
											'quantity'				=> $row->quantity,
											'chargedAmount'			=> $row->productAmt,
											'organizationProductId' => $row->organizationProductId,
											'orderStatusId'         => 1,										
											'orderEmail'       		=> $this->session->userdata('userEmail'),
											'shippingOrgId'			=> $row->shippingOrgId,
											'shippingRateId'		=> $row->shippingRateId,
											'customOrderId'			=> $customOrderIdCart[$row->cartId],
											'atATimeProduct'		=> $atATimeProduct,
											'colorId'				=> $row->colorId,
											'size'					=> $row->size,
											'isPickup'				=> 1,
											'pickupId'				=> $row->pickupId,
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
											'pickupProccessPrice'   => $row->pickupProccessPrice,
											'productWeight'      	=> $row->productWeight,	
											'retailerDiscount'		=> $row->retailerDiscount,	
											'freeShipCatId'			=> $row->freeShipCatId,	
											'freeShipPrdId'			=> $row->freeShipPrdId,	
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
								$orderaddressId = $this->order_m->add_order_address($orderID,0);
								$this->custom_log->write_log('custom_log','order shipping id is '.$orderaddressId);
								
								$orderBillingId = $this->order_m->add_billing_order_address($orderID,0);
								$this->custom_log->write_log('custom_log','order billing id is '.$orderBillingId);
								
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
										{/*
											$this->order_m->reduce_product_color_quantity($row->organizationProductId,$row->colorId,$row->quantity);
											$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
											$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId.' and color id is '.$row->colorId);
										*/}
												
										if($row->size)
										{/*
											$this->order_m->reduce_product_size_quantity($row->organizationProductId,$row->size,$row->quantity);
											$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
											$this->custom_log->write_log('custom_log',$row->quantity.' quantity is reduce from '.$row->organizationProductId.' and size is '.$row->size);	
										*/}
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
									
									$shippingVendor = '';
									$estimateDay    = $this->config->item('estimated_time_increase');
									
									if((!empty($row->shippingRateId))&&($row->shippingRateId))
									{
										$rateDetails = $this->shipping_m->shipping_vendor_details($row->shippingRateId);
										$this->custom_log->write_log('custom_log','Rate details is '.print_r($rateDetails,true));
										if(!empty($rateDetails))
										{
											$estimateDay = $rateDetails->ETA+$this->config->item('estimated_time_increase');
										}
									}
									
									$color = '';
									$size  = '';
										
									$customerShippDet = $this->customer_m->user_profile_details($userId);
									$shippingAddName  = '';
									$shippingAddress  = '';
									$retailerDet = $this->order_m->order_retailer_with_product_details($row->organizationProductId);
									$imagePath = base_url().'img/no_image.jpg';
									if((!empty($retailerDet->productImageName))&&(file_exists('uploads/product/'.$retailerDet->productImageName)))
									{
										$imagePath = base_url().'uploads/product/'.$retailerDet->productImageName;	
									}
									
									$pickupDetails = $this->cart_m->pickup_details($row->pickupId);
									
									$mailData = array(
													'email'           => $this->session->userdata('userEmail'),
													'cc'			  => '',
													'bcc'			  => 'neworders@spacepointe.com',
													'slug'            => 'pickup_order_placed_for_customer',
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
													'pickupCenter'		=> $pickupDetails->pickupName,
													'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName
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
													'slug'            => 'pickup_order_placed_for_customer',
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
													'pickupCenter'		=> $pickupDetails->pickupName,
													'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName
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
			}
		}
		
		$pickupAddress = $this->retailer_m->pickup_address_details($cartDetails[0]->pickupId);
		$this->custom_log->write_log('custom_log','Pickup address details is '.print_r($pickupAddress,true));
		
		$this->data['title']         = 'Pay On Pickup';
		$this->data['cartDetails']   = $cartDetails;
		$this->data['pickupAddress'] = $pickupAddress;		
		$this->data['isPickUp']      = 1;		
		$this->frontendCustomView('checkout/pay_on_pickup_add_to_cart',$this->data);
	}
	
	public function cash_on_economic_delivered()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cash_on_economic_delivered',
				'log_MID'    => '' 
		) );
				
		$userId     = $this->session->userdata('userId');
		$contents   = $this->cart->contents();
		$total_cart = count($contents);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			redirect(base_url());
        }
		
		if(!$total_cart)
		{
			$this->session->set_flashdata('error','cart list not found');
			$this->custom_log->write_log('custom_log','cart list not found');
			redirect(base_url());
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
						
		$cartDetails = '';
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where    = '('.implode(' OR ',$whereArr).')';
				$cartDetails = $this->cart_m->cart_list($where);
			}
		}			
		$this->custom_log->write_log('custom_log','result is '.print_r($cartDetails,true));
		
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Cart details not found');
			$this->custom_log->write_log('custom_log','Cart details not found');
            redirect(base_url().'frontend/product_cart/shipping_address');
		}
		
		if($_POST)
		{	//echo "<pre>"; print_r($cartDetails); exit;
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
					$atATimeProduct    = 1;
					$retailerArr       = array();
					$retailerPrdArr    = array();
					$this->custom_log->write_log('custom_log','result array is '.print_r($cartDetails,true));
					
					if(!empty($cartDetails))
					{
						foreach($cartDetails as $row)
						{							
							$cusOrderId    = $this->config->item('add_orderId');
							$cusOrderId	   = $cusOrderId+$row->cartId;
							$customOrderId = $this->config->item('pre_orderId').$cusOrderId;
							$customOrderIdRet[$row->organizationId] = $customOrderId;
							$this->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
							$atATimeProduct = $row->cartId;	
							
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
										$retailerPrdArr[$row->organizationId]['retailerName'] = $row->organizationName;
										$retailerPrdArr[$row->organizationId]['retailerEmail'] = $row->email;
										$retailerPrdArr[$row->organizationId]['retailerBsPhoneCode'] = $row->businessPhoneCode;
										$retailerPrdArr[$row->organizationId]['retailerBsPhone'] = $row->businessPhone;	
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
		
		$shippCusDet    		   = $this->customer_m->address_details($shippCusAddId);
		$this->data['shippCusDet'] = $shippCusDet;
		$this->data['cartDetails'] = $cartDetails;
		$this->data['title']   	   = 'Cash On Economical Delivered';
		$this->frontendCustomView('checkout/cash_on_economical_delivered',$this->data);
	}
	
	public function cash_on_economic_delivered_buy_now($cartId=0)
	{
		$this->session->set_userdata(array(
                'log_MODULE' => 'cash_on_economic_delivered_buy_now',
                'log_MID'    => ''
		) );
		
		$this->data['title'] = 'Cash On Delivery';
		$cartId   = id_decrypt($cartId);
		$this->custom_log->write_log('custom_log','Buy now Cart id is '.$cartId);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','login user id is '.$userId);
		
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
            $this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			redirect(base_url());
        }
		
		if(!$cartId)
		{
			$this->session->set_flashdata('error','Buy now cart id not found');
			$this->custom_log->write_log('custom_log','Buy now cart id not found');
            redirect(base_url());
		}
		
		$shippCusAddId = $this->session->userdata('shippingAddressId');
		$this->custom_log->write_log('custom_log','Customer shipping address id is '.$shippCusAddId);
		if(empty($shippCusAddId))
		{
			$this->session->set_flashdata('error','Shipping Address not found');
			$this->custom_log->write_log('custom_log','Shipping Address not found');
            redirect(base_url().'frontend/product_buy_now/shipping_address/'.id_encrypt($cartId));
		}
		
		$cartDetails = $this->cart_m->buy_now_delivery_detail($cartId);
		$this->custom_log->write_log('custom_log','Buy Now page details is '.print_r($cartDetails,true));
		if(empty($cartDetails))
		{
			$this->session->set_flashdata('error','Buy now details not found');
			$this->custom_log->write_log('custom_log','Buy now details not found');
            redirect(base_url());
		}
		
		if($_POST)
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
				
				$atATimeProduct = $cartDetails->cartId;
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
		
		$shippCusDet    			= $this->customer_m->address_details($shippCusAddId);
		$this->data['purchaseFrom'] = 2;
		$this->data['shippCusDet']  = $shippCusDet;
		$this->data['cartDetails']  = $cartDetails;
		$this->data['cartId']       = $cartId;		
		$this->data['isPickUp']     = 0;
		$this->data['payOnPickUp']  = 0;
		$this->frontendCustomView('checkout/cash_on_economic_delivered_buy_now',$this->data);
	}
}