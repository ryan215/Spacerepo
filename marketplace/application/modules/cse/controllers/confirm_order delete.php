<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Confirm_order extends MY_Controller {

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
				'log_MODULE' => 'confirm_order',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Confirm Orders';			
		$this->data['result'] = $this->order_lib->confirmation_order_index();
		$this->cseCustomView('admin/shipping_management/orders_management/confirm_order_list',$this->data);
	}
	
	public function confirmationOrderAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirmationOrderAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->confirmation_order_ajax($total);
		$this->load->view('admin/shipping_management/orders_management/confirmation_order_ajax',$this->data);	
	}
	
	public function confirm_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirm_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title']   = 'Confirmation Orders View';
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->order_view($orderID,2);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->cseCustomView('admin/shipping_management/orders_management/confirm_order_view',$this->data);
	}
	
	public function change_new_order_to_ready($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_new_order_to_ready',
				'log_MID'    => '' 
		) );
		$this->load->model('customer_m');
		$orderID = id_decrypt($orderID);
		if($orderID)
		{
			$getDetails = $this->order_m->order_details($orderID); 
			//echo "<pre>"; print_r($getDetails); exit;
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
							$imageUrl = base_url().'uploads/product/'.$retailerDetails->imageName;
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
						
						$dropShipAddress = '';
						$dropshipAddDet = $this->retailer_m->dropship_details($retailerDetails->dropshipCentre);
						if(!empty($dropshipAddDet))
						{
							$dropShipAddress = $dropshipAddDet->addressLine1;
						}
						/*******Mail for Customer*****************/
						$mailData = array(
											'email'           => $customerDetails->email,
											//'cc'	          => $rateDetails->email.','.$retailerDetails->email,
											'cc'	          => '',
											'slug'            => 'reay_to_shipp_order_for_customer',
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
											'subject'  		  => 'Your Order Is Ready To Be Shipped',
										);
						if($this->email_m->send_mail($mailData))
						{

                            $this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
						
						/*******Mail for Shipping Vendor*****************/
						$mailData = array(
											'email'           => $rateDetails->email,
											'cc'	          => '',
											'slug'            => 'ready_to_transit_for_shipper',
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
											'subject'  		  => 'An order is ready to be shipped',
											'tracking_no'	  => $getDetails->trackingNbr,
											'custoemerAdd'    => $customerDetails->areaName.','.$customerDetails->cityName,
											'dp_center_name'  => $retailerDetails->dropCenterName,
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
						
						$orderTrackId = $this->order_m->add_order_track_details($orderID,3);
						$this->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
						if($this->order_m->change_new_order_to_ready($orderID))
						{
                            $message=' ('. $this->config->item('pre_orderId').$getDetails->customOrderId.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
                            $response = $this->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
                            /*$retailer_message='Your product is duely recieved and packed for delivery';
                            $response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
                            $customer_message=' Your order has been processed and will be delivered in ('.$estimateDay.') days';
                            $response = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);*/

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
		}	
		redirect(base_url().$this->session->userdata('userType').'/ready_to_shipped');		
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
			$this->order_lib->cancel_order($orderID);
		}
	}
}