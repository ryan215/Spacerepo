<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Ready_to_pickup extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Ready To Be Shipped';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'Ready_to_shipped',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Ready To Be picked';
		$this->data['result'] = $this->order_pickup_lib->ready_to_shipped_order_index();	
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/ready_to_be_shipped_order_list',$this->data);
	}
	
	public function readyShippedAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'readyShippedAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_pickup_lib->ready_to_shipped_order_ajax($total);
		$this->load->view('admin/shipping_management/pickup_orders_management/ready_shipped_order_ajax',$this->data);
	}
	
	public function ready_to_pickup_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'ready_to_pickup_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'Ready To Be Pickup Orders View';
		
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_pickup_lib->pickup_order_view($orderID,3);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		
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
				redirect(base_url().$this->session->userdata('userType').'/ready_to_pickup/ready_to_pickup_order_view/'.id_encrypt($orderID));	
			}
		}
		
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/ready_to_shipped_order_view',$this->data);
	}
	
	public function change_status($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_status',
				'log_MID'    => '' 
		) );
		$this->load->model('customer_m');
		$orderID = id_decrypt($orderID);
		
		$getDetails = $this->order_m->ready_shipped_order_details($orderID); 
		if(!empty($getDetails))
		{
			
				$customerDetails = $this->customer_m->get_customer_detail_for_pickup($getDetails->customerId);
				
				if(!empty($customerDetails))
				{
					
						$retailerDetails = $this->order_m->order_retailer_details($getDetails->organizationProductId);
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
						
						/*****Mail for customer******/
						$mailData = array(
											'email'           => $customerDetails->email,
											'cc'	          => '',
											'slug'            => 'pickup_ready_to_complete_order_for_customer',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
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
											'subject'  		  => 'Your Order Is In Transit',
											'pickupCenter'		=> $pickupDetails->pickupName,
											'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
											'pickupDate'	=> date('Y-m-d',strtotime('+ '.$estimateDay.' days')),
										);
						if($this->email_m->send_mail($mailData))
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						/*****Mail for retailer******/
						$mailData = array(
											'email'           => $rateDetails->email,
											'cc'	          => '',
											'slug'            => 'pickup_ready_to_complete_order_for_retailer',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
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
											'subject'  		  => 'Your Order Is In Transit',
											'pickupCenter'		=> $pickupDetails->pickupName,
											'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
											'pickupDate'	=> date('Y-m-d',strtotime('+ '.$estimateDay.' days')),
										);
						if($this->email_m->send_mail($mailData))
						{
							$this->custom_log->write_log('custom_log','mail send to retailer');
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						//echo "ramesh"; exit;
						$orderTrackId = $this->order_m->add_order_track_details($orderID,9);
						$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
						if($this->order_pickup_m->change_to_pickup($orderID))
						{
                            $retailer_message='Your product '.substr($retailerDetails->code,0,20).' has been delivered to Customer.';
                            $response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
                           $customer_message='Thank you for collecting your order;  tracking #'.$getDetails->trackingNbr.'  from '.$pickupDetails->pickupName.' Center. Thank you for shopping at PointeMart';

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
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_ready_to_shipped_to_transit'));
			$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('error_ready_to_shipped_to_transit'));
		}
		redirect(base_url().'cse/order_picked_up');	
			
	}
	
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
	
	public function print_page()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'print_page',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('orderID'));
		$result	 = $this->order_pickup_lib->pickup_order_view($orderID,3);
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
		$result	 = $this->order_pickup_lib->pickup_order_view($orderID,3);
		$this->data['result'] = $result;
		echo $this->load->view('admin/shipping_management/pickup_orders_management/print_invoice',$this->data,true);
	}
	
	public function manifestolist()
	{
		parse_str($_POST['manifesto'],$data);
		$manifestoorderid = implode(',',$data['manifesto']);	
	}
	
	public function auto_genrate()
	{
		echo 'PM'.rand(10000000000000,99999999999999);
	}
}