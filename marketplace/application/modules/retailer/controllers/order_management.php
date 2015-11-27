<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Order_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		));
		$this->load->model('customer_m');
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'order_management',
				'log_MID'    => '' 
		) );
					
		$this->data['title'] = 'Orders Management';
		$this->retailerCustomView('superadmin/order_managements/orders_list',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->order_ajax();
		$this->load->view('superadmin/order_managements/order_ajax',$this->data);
	}	
	
	public function order_view($orderId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'order_view',
				'log_MID'    => '' 
		));
		
		$this->data['title']   = 'Order Details View';		
		$orderId 			   = id_decrypt($orderId);
		$result				   = $this->order_lib->orders_view($orderId);
		$this->data['result']  = $result;
		$this->data['orderId'] = $orderId;
		$this->retailerCustomView('order_managements/order_view',$this->data);
	}
	
	//	order delcined by reatiler 1 => 6
	public function declined_order($orderId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'declined_order',
				'log_MID'    => '' 
		));		
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order Id is '.$orderId);
		
		if($orderId)
		{
			if($this->order_m->change_accept_declined($orderId,6))
            {
				$getDetails = $this->order_m->order_details($orderId);
				if(!empty($getDetails))
				{
					$customOrderDet = $this->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
					if(!empty($customOrderDet))
					{	
						if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
						{
							$this->order_m->custom_order_declined($customOrderDet->orderDetailId);
							
							if($this->order_m->increase_product_quantity($customOrderDet->organizationProductId,$customOrderDet->quantity))
							{
								$this->custom_log->write_log('custom_log','prdouct quantity increase successfully');
								
								if((!empty($customOrderDet->colorId))&&($customOrderDet->colorId)&&(!empty($customOrderDet->productSizeId))&&($customOrderDet->productSizeId))
								{
									if($this->order_m->increase_product_color_size_quantity($customOrderDet->organizationProductId,$customOrderDet->colorId,$customOrderDet->productSizeId,$customOrderDet->quantity))
									{
										$this->custom_log->write_log('custom_log','prdouct color size quantity increase successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log','product color size quantity not increase last query is '.$this->db->last_query());
									}
								}
								elseif((!empty($customOrderDet->colorId))&&($customOrderDet->colorId))
								{
									if($this->order_m->increase_product_color_quantity($customOrderDet->organizationProductId,$customOrderDet->colorId,$customOrderDet->quantity))
									{
										$this->custom_log->write_log('custom_log','prdouct color quantity increase successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log','product color quantity not increase last query is '.$this->db->last_query());
									}
								}
								elseif((!empty($customOrderDet->productSizeId))&&($customOrderDet->productSizeId))
								{
									if($this->order_m->increase_product_size_quantity($customOrderDet->organizationProductId,$customOrderDet->productSizeId,$customOrderDet->quantity))
									{
										$this->custom_log->write_log('custom_log','prdouct size quantity increase successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log','product size quantity not increase last query is '.$this->db->last_query());
									}
								}
							}
							else
							{
								$this->custom_log->write_log('custom_log','product quantity not increase last query is '.$this->db->last_query());
							}
						}
					}
				}
                $this->session->set_flashdata('success','Order declined Successfully');
			}
            else
            {
            	$this->session->set_flashdata('error','Order not declined');
            }
		}
		redirect(base_url().'retailer/order_management');
	}
	
	//	order accept by reatiler for delivery or pickup 1 => 2
	public function change_new_order_to_confirm_order($orderId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_new_order_to_confirm_order',
				'log_MID'    => '' 
		));		
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order Id is '.$orderId);
		$dropShipAddress = '';					
		$getDetails = $this->order_m->new_order_details($orderId);
        $this->custom_log->write_log('custom_log','order details is '.print_r($getDetails,true));
		
		if(!empty($getDetails))
        {
			$customOrderDet = $this->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{	
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$orderTrackId = $this->order_m->add_order_custom_track($customOrderDet->orderDetailId,2);
					$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					$this->order_m->custom_change_new_to_confirm($customOrderDet->orderDetailId);
				}
			}
        	$customerDetails = $this->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
            $this->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));
			
			if(!empty($customerDetails))
            {
				
            	if($getDetails->shippingRateId)
                {
                	$rateDetails = $this->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
                    $this->custom_log->write_log('custom_log','shipping rate details is '.print_r($rateDetails,true));
                    if(!empty($rateDetails))
                    {
                    	$retailerDetails = $this->order_m->order_retailer_details($getDetails->organizationProductId);
                        $estimateDay     = $rateDetails->ETA+$this->config->item('estimated_time_increase');
                        $shippingVendor  = $rateDetails->organizationName;
						$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                        $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
		
						$imagePath = base_url().'img/no_image.jpg';	
                        if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
                        {
                        	$imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
                        }
						$color = '';
                        $size = '';
					}
                    else
                    {
						$this->custom_log->write_log('custom_log','Shipping vendor rate details not found');
                    }
					$dropshipAddDet = $this->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}
				}
				else
                {
                	$retailerDetails = $this->order_m->order_retailer_details($getDetails->organizationProductId);
                    $this->custom_log->write_log('custom_log','retailer details is '.print_r($retailerDetails,true));
                    $estimateDay     = $this->config->item('estimated_time_increase');
                    $shippingVendor  = '';

                    $shippingDetails = $this->order_m->order_shipping_address_details($getDetails->customerId,$getDetails->orderId);
                    $this->custom_log->write_log('custom_log','shipping details is '.print_r($shippingDetails,true));
                    $shippingAddName = $shippingDetails->firstName.' '.$shippingDetails->lastName;
                    $shippingAddress = ucwords($shippingDetails->firstName.' '.$shippingDetails->lastName).' ,'.$shippingDetails->phone.', '.$shippingDetails->addressLine1.' '.$shippingDetails->address_Line2.' ,'.$shippingDetails->cityName.' '.$shippingDetails->areaName.' '.$shippingDetails->stateName.' '.$customerDetails->countryName;

                    $imagePath = base_url().'img/no_image.jpg';
                    $color = '';
                    $size  = '';
                    if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
                    {
                    	$imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
                    }
					
					$dropshipAddDet = $this->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}

				}
				
				if($getDetails->isPickup)
                {
                	$pickupDetails = $this->cart_m->pickup_details($getDetails->pickupId);
                    $this->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
                    if($pickupDetails)
                    {
						/********Mail for Customer*****/
                        $mailData = array(
                        				'email'           => $customerDetails->email,
                                        'cc'	          => '',
                                        'slug'            => 'pickup_confirm_order_for_customer',
                                        'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                        'customerPhone'	  => $customerDetails->phone,
                                        'orderId'		  => $getDetails->customOrderId,
                                        'eta'			  => $estimateDay,
                                        'shippingVendor'  => $shippingVendor,
                                        'shippingAddName' => $shippingAddName,
                                        'shippingAddress' => $shippingAddress,
                                        'sellerName'      => $retailerDetails->organizationName,
                                        'imagePath'		  => $imagePath,
                                        'productName'	  => $retailerDetails->code,
                                        'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                        'quantity'		  => $getDetails->quantity,
                                        'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                        'color'			  => $color,
                                        'size'			  => $size,
                                        'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                        'subject'  		  => 'Your Order Has Been Confirmed',
                                        'pickupCenter'		=> $pickupDetails->pickupName,
                                        'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName
									);
						
						if($this->email_m->send_mail($mailData))
                        {
                        	$message = 'Thank you for your confirmation; please drop the '.substr($retailerDetails->code,0,20).' off at the '.$retailerDetails->dropCenterName.' Dropship centre';
							$response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone ,$message);
							$customer_message='order # '.$getDetails->customOrderId.' , has been confirmed by the seller & will be at '.$pickupDetails->pickupName.' in '.$estimateDay.' days.';
							$customerresponsed = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
							$this->custom_log->write_log('custom_log',$customerresponsed);
                            $this->custom_log->write_log('custom_log',$response);
                            $this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
                        else
                        {
                        	$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                        }
						
						/*****Mail for retailer********/
                        $mailData = array(
                                            'email'           => $retailerDetails->email,
                                            'cc'	          => '',
                                            'slug'            => 'pickup_confirm_order_for_retailer',
                                            'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                            'customerPhone'	  => $customerDetails->phone,
                                            'orderId'		  => $getDetails->customOrderId,
                                            'eta'			  => $estimateDay,
                                            'shippingVendor'  => $shippingVendor,
                                            'shippingAddName' => $shippingAddName,
                                            'shippingAddress' => $shippingAddress,
                                            'sellerName'      => $retailerDetails->organizationName,
                                            'imagePath'		  => $imagePath,
                                            'productName'	  => $retailerDetails->code,
                                            'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                            'quantity'		  => $getDetails->quantity,
                                            'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'color'			  => $color,
                                            'size'			  => $size,
                                            'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'subject'  		  => 'Thank You for Confirming The Order',
                                            'pickupCenter'		=> $pickupDetails->pickupName,
                                            'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
                                            'dropshipCenter'  => $retailerDetails->dropCenterName,
											'dropShipCenterAddress' => $dropShipAddress,
                                        );
                        if($this->email_m->send_mail($mailData))
                        {
                        	$this->custom_log->write_log('custom_log','Mail send to retailer');
                        }
                        else
                        {
                        	$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                        }
					}
                }
                else
                {
                	/********Mail for customer********************/
                    $mailData = array(
                    				'email'           => $customerDetails->email,
                                    'cc'			  => '',
                                    'slug'            => 'confirm_order_for_customer',
                                    'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                    'customerPhone'	  => $customerDetails->phone,
                                    'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
                                    'shippingVendor'  => $shippingVendor,
                                    'shippingAddName' => $shippingAddName,
                                    'shippingAddress' => $shippingAddress,
                                    'sellerName'      => $retailerDetails->organizationName,
                                    'imagePath'		  => $imagePath,
                                    'productName'	  => $retailerDetails->code,
                                    'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                    'quantity'		  => $getDetails->quantity,
                                    'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                    'color'			  => $color,
                                    'size'			  => $size,
                                    'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                    'subject'  		  => 'Your Order Has Been Confirmed',
								);
					
					if($this->email_m->send_mail($mailData))
                    {
						$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                    }
                    else
                    {
                    	$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                    }
                    
					/********Mail for retailer********************/
                    $mailData = array(
                    				'email'           => $retailerDetails->email,
                                    'cc'			  => '',
                                    'slug'            => 'confirm_order_for_retailer',
                                    'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                    'customerPhone'	  => $customerDetails->phone,
                                    'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
                                    'shippingVendor'  => $shippingVendor,
                                    'shippingAddName' => $shippingAddName,
                                    'shippingAddress' => $shippingAddress,
                                    'sellerName'      => $retailerDetails->organizationName,
                                    'imagePath'		  => $imagePath,
                                    'productName'	  => $retailerDetails->code,
                                    'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                    'quantity'		  => $getDetails->quantity,
                                    'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                    'color'			  => $color,
                                    'size'			  => $size,
                                    'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                    'subject'  		  => 'Thank You for Confirming The Order',
                                    'dropshipCenter'  => $retailerDetails->dropCenterName,
									'dropShipCenterAddress' => $dropShipAddress,
								);
					if($this->email_m->send_mail($mailData))
                    {
						$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                    }
                    else
                    {
                    	$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                    }

                    /********Mail for shipping vendor********************/
                    $mailData = array(
                    				'email'           => $rateDetails->email,
                                    'cc'			  => '',
                                    'slug'            => 'confirm_order_for_shipper',
                                    'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                    'customerPhone'	  => $customerDetails->phone,
                                    'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
                                    'shippingVendor'  => $shippingVendor,
                                    'shippingAddName' => $shippingAddName,
                                    'shippingAddress' => $shippingAddress,
                                    'sellerName'      => $retailerDetails->organizationName,
                                    'imagePath'		  => $imagePath,
                                    'productName'	  => $retailerDetails->code,
                                    'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                    'quantity'		  => $getDetails->quantity,
                                    'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                    'color'			  => $color,
                                    'size'			  => $size,
                                    'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                    'subject'  		  => 'An order Has Been Confirmed',
								);
					if($this->email_m->send_mail($mailData))
                    {
						$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                    }
                    else
                    {
                    	$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                    }
                    $message = 'Thank you for your confirmation; please drop the '.substr($retailerDetails->code,0,20).' off at the '.$retailerDetails->dropCenterName.' Dropship centre';
					$response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone ,$message);
					$customer_message = 'order # '.$getDetails->customOrderId.' , have been confirmed by the seller & will be  delivered in  '.$estimateDay.' days.';
					$customerresponsed = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
					$shipper_message = 'An order # '.$getDetails->customOrderId.' ,has been processed and is Confirmed.  Check for shipping manifest.';
					$shipper_message = $this->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone  ,$shipper_message);
					
					$this->custom_log->write_log('custom_log',$customerresponsed);
                    $this->custom_log->write_log('custom_log',$response);
				}				
			}
            else
            {
            	$this->session->set_flashdata('error','Customer details not found');
			}
			
			if($this->order_m->change_accept_declined($orderId,2))
			{
				$orderTrackId = $this->order_m->add_order_track_details($orderId,2);
				$this->custom_log->write_log('custom_log','order tack id is '.$orderTrackId);
				$this->session->set_flashdata('success','Order accepted Successfully');
				$this->custom_log->write_log('custom_log','Order accepted Successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Order not accept');
				$this->custom_log->write_log('custom_log','Order not accept');
			}
		}
		redirect(base_url().'retailer/order_management');
	}
	
	public function economic_order_view($orderId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_order_view',
				'log_MID'    => '' 
		));
		
		$this->data['title']   = 'Order Details View';		
		$result				   = $this->order_lib->economic_order_view($orderId);
		//echo "<pre>"; print_r($result); exit;
		$this->data['result']  = $result;
		$this->data['orderId'] = $orderId;
		$this->retailerCustomView('order_managements/economic_order_view',$this->data);
	}
	
	public function declined_economic_order($orderId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'declined_economic_order',
				'log_MID'    => '' 
		));		
		
		$this->custom_log->write_log('custom_log','Order Id is '.$orderId);
		
		if($orderId)
		{
			if($this->order_m->change_accept_declined_economic_order($orderId,6))
            {
				$customOrderDet = $this->order_m->order_custom_payment_details($orderId);
				if(!empty($customOrderDet))
				{
					$this->order_m->cancel_single_shippment_order($customOrderDet[0]->orderCustomPaymentId);
					foreach($customOrderDet as $customRow)
					{
						if($this->order_m->cancel_order_details($customRow->orderDetailId))
						{
							if($this->order_m->increase_product_quantity($customRow->organizationProductId,$customRow->quantity))
							{
								$this->custom_log->write_log('custom_log','prdouct quantity increase successfully');
								
								if((!empty($customRow->colorId))&&($customRow->colorId)&&(!empty($customRow->productSizeId))&&($customRow->productSizeId))
								{
									if($this->order_m->increase_product_color_size_quantity($customRow->organizationProductId,$customRow->colorId,$customRow->productSizeId,$customRow->quantity))
									{
										$this->custom_log->write_log('custom_log','prdouct color size quantity increase successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log','product color size quantity not increase last query is '.$this->db->last_query());
									}
								}
								elseif((!empty($customRow->colorId))&&($customRow->colorId))
								{
									if($this->order_m->increase_product_color_quantity($customRow->organizationProductId,$customRow->colorId,$customRow->quantity))
									{
										$this->custom_log->write_log('custom_log','prdouct color quantity increase successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log','product color quantity not increase last query is '.$this->db->last_query());
									}
								}
								elseif((!empty($customRow->productSizeId))&&($customRow->productSizeId))
								{
									if($this->order_m->increase_product_size_quantity($customRow->organizationProductId,$customRow->productSizeId,$customRow->quantity))
									{
										$this->custom_log->write_log('custom_log','prdouct size quantity increase successfully');
									}
									else
									{
										$this->custom_log->write_log('custom_log','product size quantity not increase last query is '.$this->db->last_query());
									}
								}
							}
							else
							{
								$this->custom_log->write_log('custom_log','product quantity not increase last query is '.$this->db->last_query());
							}

						}
					}
				}
                $this->session->set_flashdata('success','Order declined Successfully');
			}
            else
            {
            	$this->session->set_flashdata('error','Order not declined');
            }
		}
		redirect(base_url().'retailer/order_management');
	}	
	
	public function change_new_order_to_confirm_order_economic($orderId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_new_order_to_confirm_order_economic',
				'log_MID'    => '' 
		));		
		
		$customOrderDet = $this->order_m->order_custom_payment_details($orderId);
		if(!empty($customOrderDet))
		{
			foreach($customOrderDet as $customRow)
			{
				$orderTrackId = $this->order_m->add_order_custom_track($customRow->orderDetailId,2);
				$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->order_m->custom_change_new_to_confirm($customRow->orderDetailId))
				{
	            }
			}
		}
		
		$this->custom_log->write_log('custom_log','Order Id is '.$orderId);
		
		$getDetails = $this->order_m->economic_new_order_details($orderId);
        $this->custom_log->write_log('custom_log','order details is '.print_r($getDetails,true));
		//echo "<pre>"; print_r($getDetails); exit;
		if(!empty($getDetails))
        {
			
        	$customerDetails = $this->customer_m->get_customer_with_shipping_detail($getDetails[0]->customerId);
            $this->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));
			
			if(!empty($customerDetails))
            {
            	if($getDetails[0]->finalShippingRateId)
                {
                	$rateDetails = $this->shipping_m->shipping_vendor_details($getDetails[0]->finalShippingRateId);
                    $this->custom_log->write_log('custom_log','shipping rate details is '.print_r($rateDetails,true));
                    if(!empty($rateDetails))
                    {
                    	//$retailerDetails = $this->order_m->order_retailer_details($getDetails[0]->organizationProductId);
						$estimateDay     = $rateDetails->ETA+$this->config->item('estimated_time_increase')+$this->config->item('economic_delivery_estimated_time');
                        $shippingVendor  = $rateDetails->organizationName;
						$shippingVendorEmail  = $rateDetails->email;
						$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                        $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
						
						$retailerPrdArr = array();
						foreach($getDetails as $row)
						{
							$retailerPrdArr['productDet'][$row->productId]['productAmt']  = $row->chargedAmount;
							$retailerPrdArr['productDet'][$row->productId]['productQty']  = $row->quantity;	
							$retailerPrdArr['productDet'][$row->productId]['productName'] = $row->code;
							$retailerPrdArr['productDet'][$row->productId]['imageName']   = $row->imageName;
							$retailerPrdArr['retailerName']        = $row->organizationName;
							$retailerPrdArr['retailerEmail']       = $row->email;
							$retailerPrdArr['retailerBsPhoneCode'] = $row->businessPhoneCode;
							$retailerPrdArr['retailerBsPhone']     = $row->businessPhone;
							$retailerPrdArr['dropCenterName']	   = $row->dropCenterName;							
						}
						//echo "<pre>"; print_r($retailerPrdArr); exit;
						foreach($retailerPrdArr as $retailerKey=>$retailerRow)
						{
							$mailContent = '<table width="100%" class="order-table" style="border-bottom:2px solid #6d6d6d; padding-bottom:5px;"><tbody>';
							$mailContent.= '<tr><th colspan="2">Item </th><th style="text-align:center;"> Item price </th><th style="text-align:center;"> Qty </th><th style="text-align:right;"> Subtotal </th></tr>';								
							$amount = 0;
							if(!empty($retailerPrdArr['productDet']))
							{
								foreach($retailerPrdArr['productDet'] as $prodctRow)
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
									$amount = $amount+($prodctRow['productAmt']*$prodctRow['productQty']);
									
									$message = 'Thank you for your confirmation; please drop the '.substr($prodctRow['productName'],0,20).' off at the '.$retailerPrdArr['dropCenterName'].' Dropship centre';
									$response = $this->twillo_m->send_mobile_message($retailerPrdArr['retailerBsPhoneCode'].$retailerPrdArr['retailerBsPhone'],$message);
									$customer_message = 'order # '.$orderId.' , have been confirmed by the seller & will be  delivered in  '.$estimateDay.' days.';
									$customerresponsed = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
									$shipper_message = 'An order # '.$orderId.' ,has been processed and is Confirmed.  Check for shipping manifest.';
									$shipper_message = $this->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone,$shipper_message);
										
									$this->custom_log->write_log('custom_log',$customerresponsed);
									$this->custom_log->write_log('custom_log',$response);
								}
							}
							$mailContent.= '</tbody></table>';
							/********Mail for customer********************/
                    		$mailData = array(
											'email'           => $customerDetails->email,
											'cc'			  => '',
											'slug'            => 'economic_confirm_order_for_customer',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $orderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'sellerName'      => $retailerPrdArr['retailerName'],
											'mailContent'	  => $mailContent,
											'totalAmount'	  => number_format($amount,2),
											'subject'  		  => 'Your Order Has Been Confirmed',
										);					
							if($this->email_m->send_mail($mailData))
							{
								$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
							}
							else
							{
								$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
							}
							
							/********Mail for retailer********************/
							if(!empty($retailerPrdArr['retailerEmail']))
							{
								$mailData = array(
											'email'           => $retailerPrdArr['retailerEmail'],
											'cc'			  => '',
											'slug'            => 'economic_confirm_order_for_retailer',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $orderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'sellerName'      => $retailerPrdArr['retailerName'],
											'mailContent'	  => $mailContent,
											'totalAmount'	  => number_format($amount,2),
											'subject'  		  => 'Thank You for Confirming The Order',
										);
								if($this->email_m->send_mail($mailData))
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
								}
								else
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
								}
							}
							/********Mail for retailer********************/
							
							/********Mail for shipping vendor********************/
							$mailData = array(											
											'email'           => $shippingVendorEmail,
											'cc'			  => '',
											'slug'            => 'economic_confirm_order_for_shipper',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $orderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'sellerName'      => $retailerPrdArr['retailerName'],
											'mailContent'	  => $mailContent,
											'totalAmount'	  => number_format($amount,2),
											'subject'  		  => 'An order Has Been Confirmed',
										);
							if($this->email_m->send_mail($mailData))
							{
								$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
							}
							else
							{
								$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
							}
							/********Mail for shipping vendor********************/
						}
					}
                    else
                    {
						$this->custom_log->write_log('custom_log','Shipping vendor rate details not found');
                    }
				}
			}
            else
            {
            	$this->session->set_flashdata('error','Customer details not found');
			}
			
			if($this->order_m->change_accept_declined_economic_order($orderId,2))
			{
				foreach($getDetails as $row)
				{
					$orderTrackId = $this->order_m->add_order_track_details($row->orderId,2);
					$this->custom_log->write_log('custom_log','order tack id is '.$orderTrackId);
				}
				$this->session->set_flashdata('success','Order accepted Successfully');
				$this->custom_log->write_log('custom_log','Order accepted Successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Order not accept');
				$this->custom_log->write_log('custom_log','Order not accept');
			}
		}
		redirect(base_url().'retailer/order_management');
	}
}