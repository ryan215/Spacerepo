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
		$this->adminCustomView('superadmin/order_managements/orders_list',$this->data);
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
		
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->form_validation->run())
	    	{
				if($this->order_m->save_tracking_number($orderId,$result['trackingNbr']))
				{
					$getDetails = $this->order_m->order_details($orderId);
					if(!empty($getDetails))
					{
						$customOrderDet = $this->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
						if(!empty($customOrderDet))
						{	
							if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
							{
								$this->order_m->quick_shippment_save_tracking_number($customOrderDet->orderDetailId,$result['trackingNbr']);
							}
						}
					}
					$this->session->set_flashdata('success',$this->lang->line('success_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_save_track_no'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_save_track_no'));
				}
				redirect(base_url().$this->session->userdata('userType').'/order_management/order_view/'.id_encrypt($orderId));	
			}
		}
		
		$this->data['result']  = $result;
		$this->data['orderId'] = $orderId;
		$this->adminCustomView('order_managements/order_view',$this->data);
	}
	
	public function change_false($orderId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_false',
				'log_MID'    => '' 
		));		
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order Id is '.$orderId);
		
		if($orderId)
		{
			$this->order_lib->delete_order($orderId);
		}
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
		
		$getDetails = $this->order_m->new_order_details($orderId);
        $this->custom_log->write_log('custom_log','order details is '.print_r($getDetails,true));
		
		if(!empty($getDetails))
        {
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
	
	//	order change from confirm to ready order 2 => 3
	public function change_confirm_order_to_ready_order($orderId='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_confirm_order_to_ready_order',
				'log_MID'    => '' 
		) );
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->change_confirm_order_to_ready_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');		
	}
	
	// pick	order change from confirm to ready pickup 2 => 3
	public function change_confirm_pickup_order_to_ready_pickup_order($orderId='')
	{			
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_confirm_pickup_order_to_ready_pickup_order',
				'log_MID'    => '' 
		) );
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->change_confirm_pickup_order_to_ready_pickup_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');		
	}
	
	//	order change from ready to shipped order 3 => 4
	public function change_ready_order_to_shipped_order($orderId='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_ready_order_to_shipped_order',
				'log_MID'    => '' 
		) );
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->change_ready_order_to_shipped_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');
	}
	
	// pick	order change from ready pickup to order pickuped 3 => 5
	public function change_ready_pickup_to_order_pickup($orderId='')
	{		
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_ready_pickup_to_order_pickup',
				'log_MID'    => '' 
		) );
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->change_ready_pickup_to_order_pickup($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');		
	}
	
	//	order change from shipped to delivered 4 => 5
	public function change_shipped_order_to_delivered_order($orderId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_shipped_order_to_delivered_order',
				'log_MID'    => '' 
		) );
		
		$orderId = id_decrypt($orderId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->change_shipped_order_to_delivered_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');
	}
	
	//	print invoice for pickup
	public function pickup_print_invoice()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pickup_print_invoice',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_pickup_lib->pickup_order_view($orderID,2);
		$this->data['result'] = $result;
		echo $this->load->view('superadmin/order_managements/pickup_print_invoice',$this->data,true);
	}
	
	//	print page for pickup
	public function pickup_print_page()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pickup_print_page',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_pickup_lib->pickup_order_view($orderID,2);
		$this->data['result'] = $result;
		echo $this->load->view('superadmin/order_managements/pickup_print_page',$this->data,true);
	}
	
	//	Save traking number
	public function save_track_no()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'save_track_no',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$order_id = id_decrypt($this->input->post('order_id'));
		$track_no = $this->input->post('track_no');
		
		if($order_id)
		{
			if($this->order_m->save_tracking_number($order_id,$track_no))
			{
				$getDetails = $this->order_m->order_details($order_id);
				if(!empty($getDetails))
				{
					$customOrderDet = $this->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
					if(!empty($customOrderDet))
					{	
						if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
						{
							$this->order_m->quick_shippment_save_tracking_number($customOrderDet->orderDetailId,$track_no);
						}
					}
				}
				$this->session->set_flashdata('success',$this->lang->line('success_save_track_no'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_save_track_no'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_save_track_no'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_save_track_no'));
			}	
		}
	}
	
	//	auto genrate traking number
	public function auto_genrate()
	{
		echo 'PM'.rand(10000000000000,99999999999999);
	}
	
	//	print invoice for delivery 
	public function delivery_print_invoice()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delivery_print_invoice',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_lib->order_view($orderID,3); //echo "<pre>"; print_r($result); exit;
		$this->data['result'] = $result;
		echo $this->load->view('superadmin/order_managements/delivery_print_invoice',$this->data,true);
	}
	
	public function economic_delivery_print_invoice()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_delivery_print_invoice',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = $this->input->post('orderID');
		$result	 = $this->order_lib->economic_order_view($orderID);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		echo $this->load->view('superadmin/order_managements/economic_delivery_print_invoice',$this->data,true);
	}
	
	//	print page for delivery
	public function delivery_print_page()
	{
		
		$this->session->set_userdata(array(
				'log_MODULE' => 'delivery_print_page',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_lib->order_view($orderID,3); //echo "<pre>"; print_r($result); exit;
		$this->data['result'] = $result;
		echo $this->load->view('superadmin/order_managements/delivery_print_page',$this->data,true);
	}
	
	//	print page for delivery
	public function economic_delivery_print_page()
	{		
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_delivery_print_page',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = $this->input->post('orderID');
		$result	 = $this->order_lib->economic_order_view($orderID);
		$this->data['result'] = $result;
		echo $this->load->view('superadmin/order_managements/delivery_print_page',$this->data,true);
	}
	
	public function save_delivered_date()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'save_delivered_date',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$order_id       = id_decrypt($this->input->post('order_id'));
		$delivered_date = $this->input->post('delivered_date');
		
		if($order_id)
		{
			if($this->order_m->save_delivered_date($order_id,$delivered_date))
			{
				$getDetails = $this->order_m->order_details($order_id);
				if(!empty($getDetails))
				{
					$customOrderDet = $this->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
					if(!empty($customOrderDet))
					{	
						if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
						{
							$this->order_m->custom_save_delivered_date($customOrderDet->orderDetailId,$delivered_date);
						}
					}
				}
				$this->session->set_flashdata('success',$this->lang->line('success_save_delivered_date'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_save_delivered_date'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_save_delivered_date'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_save_delivered_date'));
			}	
		}
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
		
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->form_validation->run())
	    	{
				if($this->order_m->economic_save_tracking_number($orderId,$result['trackingNbr']))
				{
					$customOrderDet = $this->order_m->order_custom_payment_details($orderId);
					if(!empty($customOrderDet))
					{
						$this->order_m->single_shippment_save_tracking_number($customRow[0]->orderCustomPaymentId,$result['trackingNbr']);
					}
		
					$this->session->set_flashdata('success',$this->lang->line('success_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_save_track_no'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_save_track_no'));
				}
				redirect(base_url().$this->session->userdata('userType').'/order_management/economic_order_view/'.$orderId);	
			}
		}
		
		$this->data['result']  = $result;
		$this->data['orderId'] = $orderId;
		$this->adminCustomView('order_managements/economic_order_view',$this->data);
	}
	
	public function economic_change_false($orderId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_change_false',
				'log_MID'    => '' 
		));		
		
		$this->custom_log->write_log('custom_log','Order Id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->delete_economic_order($orderId);
		}
	}
	
	//	order change from confirm to ready order 2 => 3
	public function economic_change_confirm_order_to_ready_order($orderId='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_change_confirm_order_to_ready_order',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->economic_change_confirm_order_to_ready_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');		
	}
	
	//	order change from ready to shipped order 3 => 4
	public function economic_change_ready_order_to_shipped_order($orderId='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_change_ready_order_to_shipped_order',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->economic_change_ready_order_to_shipped_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');
	}
	
	//	order change from shipped to delivered 4 => 5
	public function economic_change_shipped_order_to_delivered_order($orderId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'economic_change_shipped_order_to_delivered_order',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Order id is '.$orderId);
		if($orderId)
		{
			$this->order_lib->economic_change_shipped_order_to_delivered_order($orderId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/order_management');
	}
}