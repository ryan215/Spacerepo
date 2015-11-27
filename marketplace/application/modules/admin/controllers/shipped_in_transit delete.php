<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Shipped_in_transit extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Shipped In Transit';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'Shipped_in_transit',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Shipped In Transit';	
		$this->data['result'] = $this->order_lib->shipped_in_transit_order_index();
		$this->adminCustomView('shipping_management/orders_management/shipped_in_transit_order_list',$this->data);
	}
	
	public function transitAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'transitAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->shipped_in_transit_order_ajax($total);
		$this->load->view('shipping_management/orders_management/shipped_in_transit_order_ajax',$this->data);
	}
	
	public function shipped_in_transit_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipped_in_transit_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title']   = 'Shipped/In Transit Orders View';
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->order_view($orderID,4);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->adminCustomView('shipping_management/orders_management/shipped_in_transit_order_view',$this->data);
	}
	
	public function change_status($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_status',
				'log_MID'    => '' 
		) );
		$this->load->model('customer_m');
		$orderID  = id_decrypt($orderID);
		
		$getDetails = $this->order_m->transit_order_details($orderID); 
	//echo "<pre>";	print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			
				$customerDetails = $this->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
				$rateDetails     = $this->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
				if(!empty($customerDetails))
				{
					if(!empty($rateDetails))
					{
						$retailerDetails = $this->order_m->order_retailer_details($getDetails->organizationProductId);
						$estimateDay     = $rateDetails->ETA+$this->config->item('estimated_time_increase');
						$shippingVendor  = $rateDetails->organizationName;
							
						$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
						$shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
							
						$imagePath = base_url().'img/no_image.jpg';
						if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$retailerDetails->imageName)))
						{
							$imageUrl = base_url().'uploads/product/thumb500_500/'.$retailerDetails->imageName;
						}
						elseif((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
						{
							$imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
						}						
						
						$color = '';
						if($getDetails->colorId)
						{/*
							$this->db->where('colorId',$getDetails->colorId);
							$result = $this->db->get('colors')->row();
							$color  = '<a class="btn btn-xs color_box active_color color_static" style="margin-left: 0px; margin-right: 0px;background-color:'.$result->colorCode.'" href="javascript:void(0);"/>';
						*/}
								
						$size = '';
						if($getDetails->size)
						{
							//$size = 'Size : '.$getDetails->size;
						}
						
						/****Mail for customer*******/
						$mailData = array(
											'email'           => $customerDetails->email,
											'cc'	          => '',
											//'cc'	          => $rateDetails->email.','.$retailerDetails->email,
											'slug'            => 'delivered_order_for_customer',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'sellerName'      => $retailerDetails->organizationName,
											'imagePath'		  => $imagePath,
											'productName'	  => $retailerDetails->productCodeOveride,
											'currentPrice'	  => number_format($getDetails->chargedAmount,2),
											'quantity'		  => $getDetails->quantity,
											'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'color'			  => $color,
											'size'			  => $size,
											'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'subject'  		  => 'Your Order Has Been Delivered',
										);
						if($this->email_m->send_mail($mailData))
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						/****Mail for retailer*******/
						$mailData = array(
											'email'           => $rateDetails->email,
											'cc'	          => '',
											'slug'            => 'delivered_order_for_retailer',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'sellerName'      => $retailerDetails->organizationName,
											'imagePath'		  => $imagePath,
											'productName'	  => $retailerDetails->productCodeOveride,
											'currentPrice'	  => number_format($getDetails->chargedAmount,2),
											'quantity'		  => $getDetails->quantity,
											'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'color'			  => $color,
											'size'			  => $size,
											'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'subject'  		  => 'Your Order Has Been Delivered',
										);
						if($this->email_m->send_mail($mailData))
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						/****Mail for Shipping Vendor*******/
						$mailData = array(
											'email'           => $rateDetails->email,
											'cc'	          => '',
											'slug'            => 'delivered_order_for_shipper',
											'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
											'customerPhone'	  => $customerDetails->phone,
											'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
											'eta'			  => $estimateDay,
											'shippingVendor'  => $shippingVendor,
											'shippingAddName' => $shippingAddName,
											'shippingAddress' => $shippingAddress,
											'sellerName'      => $retailerDetails->organizationName,
											'imagePath'		  => $imagePath,
											'productName'	  => $retailerDetails->productCodeOveride,
											'currentPrice'	  => number_format($getDetails->chargedAmount,2),
											'quantity'		  => $getDetails->quantity,
											'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'color'			  => $color,
											'size'			  => $size,
											'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
											'subject'  		  => 'Your Order Has Been Delivered',
											'custoemerCity'    => $customerDetails->cityName,
										);
						if($this->email_m->send_mail($mailData))
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						$orderTrackId = $this->order_m->add_order_track_details($orderID,5);
						$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
						if($this->order_m->change_transit_to_delivered($orderID))
						{
                            $message='Thank you for your delivery confirmation of order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.' to '.$customerDetails->cityName.'.';
                            $response = $this->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
                            $retailer_message=substr($retailerDetails->code,0,20).' has been delivered to Customer.';
                            $response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
                             $customer_message=substr($retailerDetails->code,0,20).', order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.' has been delivered. Thank you for shopping at PointeMart.';
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
						$this->session->set_flashdata('error','Shipping vendor rate details not found');							
					}
				}
				else
				{
					$this->session->set_flashdata('error','Customer details not found');
				}	
			
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_transit_to_delivered'));
			$this->custom_log->write_log('custom_log',$this->lang->line('error_transit_to_delivered'));
		}	
		redirect(base_url().$this->session->userdata('userType').'/delivered_order');	
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
	
}