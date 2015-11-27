<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Confirm_pickup_order extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Confirm Order';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirm_order_pickup',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Confirm Orders';			
		$this->data['result'] = $this->order_pickup_lib->confirmation_order_index();
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/confirm_order_list',$this->data);
	}
	
	public function confirmationOrderAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirmationOrderAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_pickup_lib->confirmation_order_ajax($total);
		$this->load->view('admin/shipping_management/pickup_orders_management/confirmation_order_ajax',$this->data);	
	}
	
	public function confirm_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirm_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title']   = 'Confirmation Orders View';
		$orderID 			   = id_decrypt($orderID);
		//$result				   = $this->order_lib->order_view($orderID,2);
		$result				   = $this->order_pickup_lib->pickup_order_view($orderID,2);
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->form_validation->run())
	    	{
				if($this->order_m->save_tracking_number($orderID,$result['trackingNbr']))
				{
					$this->session->set_flashdata('success',$this->lang->line('success_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_save_track_no'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_save_track_no'));
				}
				redirect(base_url().$this->session->userdata('userType').'/confirm_pickup_order/confirm_order_view/'.id_encrypt($orderID));	
			}
		}
		
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/confirm_order_view',$this->data);
	}
	
	public function change_new_order_to_ready($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_new_order_to_ready',
				'log_MID'    => '' 
		) );
		
		$this->load->model('customer_m');
		$orderID = id_decrypt($orderID);
		$this->custom_log->write_log('custom_log','order id is '.$orderID);
		
		if($orderID)
		{
			$getDetails = $this->order_m->order_details($orderID); 
			//echo "<pre>"; print_r($getDetails); exit;
			$this->custom_log->write_log('custom_log','order details is '.print_r($getDetails,true));
			
			if(!empty($getDetails))
			{
				$customerDetails = $this->customer_m->get_customer_detail_for_pickup($getDetails->customerId);
				$this->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));
				
				if(!empty($customerDetails))
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
					
					if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$retailerDetails->imageName)))
					{
						$imageUrl = base_url().'uploads/product/thumb500_500/'.$retailerDetails->imageName;
					}
					elseif((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
					{
						$imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
					}
					
					$pickupDetails = $this->cart_m->pickup_details($getDetails->pickupId);
					$this->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
					
					$mailData = array(
										'email'           => $customerDetails->email,
											//'cc'	          => $rateDetails->email.','.$retailerDetails->email,
											'cc'	          => '',
											'slug'            => 'ready_to_pickup_order_for_customer',
											'name'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'retailerName'    => $retailerDetails->organizationName,
											'imagePath'		  => $imagePath,
											'productName'	  => $retailerDetails->code,
											'productPrice'	  => number_format($getDetails->chargedAmount,2),
											'quantity'		  => $getDetails->quantity,
											'totalPrice'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'color'			  => $color,
											'size'			  => $size,
											'totalSumPrice'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'subject'  		  => 'Your Order Is Ready To Be Pickup',
											'pickupCenter'		=> $pickupDetails->pickupName,
											'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
											'pickupPhoneno' => $pickupDetails->phone,
										);
						$this->custom_log->write_log('custom_log','mail data is '.print_r($mailData,true));
										
						if($this->email_m->send_mail($mailData))
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						$orderTrackId = $this->order_m->add_order_track_details($orderID,3);
						$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
						if($this->order_m->change_new_order_to_ready($orderID))
						{
                            $customer_message=substr($retailerDetails->code,0,20).', order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.',  has been packed, Please collect it from '.$pickupDetails->pickupName;
                            $response = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);

                            $this->session->set_flashdata('success','Order status changed successfully');
							$this->custom_log->write_log('custom_log','Order status changed successfully');
						}
						else
						{
							$this->session->set_flashdata('error',$this->lang->line('error_new_order_to_ready_to_shipped'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_new_order_to_ready_to_shipped'));
						}
					
				}
				else
				{
					$this->session->set_flashdata('error','Customer details not found');
				}	
			}
		}	
		redirect(base_url().$this->session->userdata('userType').'/ready_to_pickup');		
	}
	
	public function change_false($orderID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_false',
				'log_MID'    => '' 
		) );		
		$orderID = id_decrypt($orderID);
		$this->custom_log->write_log('custom_log','Order Id is '.$orderID);
		
		if($orderID)
		{
			$this->order_pickup_lib->cancel_order($orderID);
		}
	}
	
	public function print_page()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'print_page',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_pickup_lib->pickup_order_view($orderID,2);
		$this->data['result'] = $result;
		echo $this->load->view('admin/shipping_management/pickup_orders_management/print_page',$this->data,true);
	}
	
	public function print_invoice()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'print_invoice',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_pickup_lib->pickup_order_view($orderID,2);
		$this->data['result'] = $result;
		echo $this->load->view('admin/shipping_management/pickup_orders_management/print_invoice',$this->data,true);
	}

}