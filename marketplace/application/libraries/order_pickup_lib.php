<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_pickup_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	
	public function new_order_index()
	{
		$return = array();
		$where  = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$return['total'] = $this->CI->order_pickup_m->total_new_order_in_shipping_admin($where);	
		return $return;
	}
	
	public function new_order_ajax($total)
	{
		$return = array();
		$perPage = $this->CI->input->post('sel_no_entry');
		$where = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/new_pickup_order/new_order_ajax/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_pickup_m->new_pickup_order_list_in_shipping_admin($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function pickup_order_view($orderID,$status)
	{
		$returnArr 					       		= array();
		$returnArr['customerFirstName']	   		= '';
		$returnArr['customerMiddle']	   		= '';
		$returnArr['customerLastName']	   		= '';
		$returnArr['customerPhone']	   	   		= '';
		$returnArr['customerEmail']	   	   		= '';
		$returnArr['billingCountry']       		= '';
		$returnArr['billingState']    	   		= '';
		$returnArr['billingCity']     	   		= '';
		$returnArr['billingAddressLine1']  	   = '';
		$returnArr['billingAddressLine2']  	   = '';
		$returnArr['billingLandMark'] 	   	   = '';
		$returnArr['billingCompany']       	   = '';
		$returnArr['shippingCountry']      	   = '';
		$returnArr['shippingState']    	       = '';
		$returnArr['shippingCity']     	   	   = '';
		$returnArr['shippingAddressLine1']     = '';
		$returnArr['shippingAddressLine2']     = '';
		$returnArr['shippingLandMark'] 	       = '';
		$returnArr['shippingCompany']      	   = '';
		$returnArr['retailerOrganizationName'] = '';
		$returnArr['retailerEmail'] 		   = '';
		$returnArr['retailerFirstName'] 	   = '';
		$returnArr['retailerMiddle'] 		   = '';
		$returnArr['retailerLastName'] 		   = '';
		$returnArr['retailerBussPhCode'] 	   = '';
		$returnArr['retailerBusinessPhone']    = '';
		$returnArr['retailerUserName'] 		   = '';
		$returnArr['retailerAddressLine1'] 	   = '';
		$returnArr['retailerAddressLine2'] 	   = '';

		$returnArr['retailerCountryName'] 	   = '';
		$returnArr['retailerStateName'] 	   = '';
		$returnArr['retailerCityName'] 		   = '';
		$returnArr['retailerAreaName'] 		   = '';		
		$returnArr['customerOrderId']      	   = '';
		$returnArr['orderDate'] 		   	   = '';
		$returnArr['productName'] 	   		   = '';
		$returnArr['productPrice'] 	   		   = 0;
		$returnArr['productImageName'] 		   = '';
		$returnArr['productQuantity']  		   = 0;
		$returnArr['trackingNbr']     		   = 0;
		$returnArr['deliveredDate']    		   = '';
		$returnArr['vendorBusinessName']       = '';
		$returnArr['vendorFirstName']          = '';
		$returnArr['vendorLastName']           = '';
		$returnArr['vendorEmail']              = '';
		$returnArr['vendorBusinessPhoneCode']  = '';
		$returnArr['vendorBusinessPhone']      = '';
		$returnArr['vendorAddressLine1']       = '';
		$returnArr['vendorCountryName']        = '';
		$returnArr['vendorStateName']          = '';
		$returnArr['vendorCityName']           = '';
		$returnArr['vendorAreaName']		   = '';
		$returnArr['lastModifiedDate']         = '';	
		$returnArr['shippingRate']             = 0;
		$returnArr['billingZip']               = '';
		$returnArr['shippingZip']              = '';
		$returnArr['shippingArea']             = '';
		$returnArr['totalAmount']              = 0;
        $returnArr['chargedAmount']              = '';
        $returnArr['paymentStatus']              = '';
		
		$returnArr['newOrderTime']             = '';
		$returnArr['confirmOrderTime']         = '';
		$returnArr['readyToShippedOrderTime']  = '';
		$returnArr['inTransitOrderTime']       = '';
		$returnArr['deliveredOrderTime']       = '';	
		
		$returnArr['customerShippFirstName']   = '';
		$returnArr['customerShippLastName']	   = '';
		$returnArr['customerShippPhone']	   = '';	
		$returnArr['phoneCode']				   = '+234';
	    $returnArr['retailerPrice']            = 0;
		$returnArr['pickupName']        	   = '';
		$returnArr['pickupBusDays']            = '';
		$returnArr['pickupBusHours']           = '';
		$returnArr['pickupAddressLine']        = '';
		$returnArr['pickupPhone']              = '';
		$returnArr['pickupStateName']          = '';
		$returnArr['pickupProccessPrice']      = 0;
					
		$billingDetails 					   = '';
		$shippingDetails 					   = '';
		
		
			if($status==7)
			{
				$orderDetails = $this->CI->order_pickup_m->delivered_order_details_pickup($orderID);
			}
			elseif($status==6)
			{
				$orderDetails = $this->CI->order_pickup_m->history_order_details($orderID);
			}
			else
			{
				$orderDetails = $this->CI->order_pickup_m->delivered_order_details_pickup_for_other($orderID,$status);
			}
				
		
		//echo "<pre>"; print_r($orderDetails); exit;
		if(!empty($orderDetails))
		{
			if(!empty($orderDetails->pickupId))
			{
				$pickupDet = $this->CI->cart_m->pickup_details($orderDetails->pickupId);
				//echo "<pre>"; print_r($pickupDet); exit;
				if(!empty($pickupDet))
				{
					$returnArr['pickupName']        = $pickupDet->pickupName;
					$returnArr['pickupBusDays']     = $pickupDet->businessDays;
					$returnArr['pickupBusHours']    = $pickupDet->businessHours;
					$returnArr['pickupAddressLine'] = $pickupDet->addressLine1;
					$returnArr['pickupPhone']       = $pickupDet->phone;
					$returnArr['pickupStateName']   = $pickupDet->stateName;            
				}
			}
            $returnArr['chargedAmount'] = $orderDetails->chargedAmount;
            $returnArr['paymentStatus'] = $orderDetails->paymentStatus;
			$returnArr['retailerPrice'] = $orderDetails->retailerPrice;
			$returnArr['pickupProccessPrice'] = $orderDetails->pickupProccessPrice;
			
			if((!empty($orderDetails->marketingProductId))&&($orderDetails->marketingProductId))
			{
				//$marketProductDet = $this->CI->order_m->marketing_product_details($orderDetails->marketingProductId);
				//if(!empty($marketProductDet))
				//{
					$returnArr['retailerPrice'] = $returnArr['retailerPrice']-$orderDetails->retailerDiscount;	
				//}
				
			}
			
            $billingDetails  = $this->CI->customer_m->user_shipping_details($orderDetails->customerId);
			$shippingDetails = $this->CI->order_m->order_shipping_address_details($orderDetails->customerId,$orderDetails->orderId);
		//	print_r($shippingDetails);
			if(!empty($shippingDetails))
			{
				$returnArr['customerShippFirstName'] = $shippingDetails->firstName;
				$returnArr['customerShippLastName']	 = $shippingDetails->lastName;
				$returnArr['customerShippPhone']	 = $shippingDetails->phone;	
			}
			//echo "<pre>"; print_r($shippingDetails); exit;
			$trackOrderTime = $this->CI->order_m->track_order_time_details($orderID);
			if(!empty($trackOrderTime))
			{
				foreach($trackOrderTime as $timeRow)
				{
					if($timeRow->orderStatusId==1)
					{
						$returnArr['newOrderTime'] = $timeRow->createTime;
					}
					elseif($timeRow->orderStatusId==2)
					{
						$returnArr['confirmOrderTime'] = $timeRow->createTime;
					}
					elseif($timeRow->orderStatusId==3)
					{
						$returnArr['readyToShippedOrderTime'] = $timeRow->createTime;
					}
					elseif($timeRow->orderStatusId==4)
					{
						$returnArr['inTransitOrderTime'] = $timeRow->createTime;
					}
					elseif($timeRow->orderStatusId==5)
					{
						$returnArr['deliveredOrderTime'] = $timeRow->createTime;
					}
				}
			}
			
		}
		//echo "<pre>"; print_r($shippingDetails); exit;
		if(!empty($orderDetails))
		{
			$returnArr['customerOrderId'] = $orderDetails->customOrderId;
			$returnArr['orderDate']       = $orderDetails->createDt;
			$returnArr['trackingNbr']     = $orderDetails->trackingNbr;
			$returnArr['deliveredDate']   = $orderDetails->deliveredDate;
			$returnArr['productQuantity'] = $orderDetails->quantity;
			$returnArr['lastModifiedDate'] = $orderDetails->orderLastModfiedDt;
			$returnArr['color'] = $orderDetails->colorCode;
			$returnArr['size'] = $orderDetails->size;
			$returnArr['totalAmount']              = $orderDetails->totalAmount; 
			$returnArr['productPrice'] 	   = $orderDetails->chargedAmount;
			
			$customerDetails = $this->CI->customer_m->user_profile_details($orderDetails->customerId);
			if(!empty($customerDetails))
			{
				$returnArr['customerFirstName']	   = $customerDetails->firstName;
				$returnArr['customerLastName']	   = $customerDetails->lastName;
				$returnArr['customerPhone']	   	   = $customerDetails->phone;	
				$returnArr['customerEmail']	   	   = $customerDetails->email;
			}
			
			$retailerDetails = $this->CI->order_m->order_retailer_details($orderDetails->organizationProductId);
		//echo "<pre>";	print_r($retailerDetails); exit;
			if(!empty($retailerDetails))
			{
				$returnArr['retailerOrganizationName'] = $retailerDetails->organizationName;
				$returnArr['retailerEmail'] 		   = $retailerDetails->email;
				$returnArr['retailerFirstName'] 	   = $retailerDetails->firstName;
				$returnArr['retailerMiddle'] 		   = $retailerDetails->middle;
				$returnArr['retailerLastName'] 		   = $retailerDetails->lastName;
				$returnArr['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
				$returnArr['retailerBusinessPhone']    = $retailerDetails->businessPhone;
				$returnArr['retailerUserName'] 		   = $retailerDetails->userName;
				$returnArr['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
				$returnArr['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
				$returnArr['retailerCountryName'] 	   = $retailerDetails->countryName;
				$returnArr['retailerStateName'] 	   = $retailerDetails->stateName;
				$returnArr['retailerCityName'] 		   = $retailerDetails->cityName;
				$returnArr['retailerAreaName']		   = $retailerDetails->areaName;
			}
			
			$productDetails = $this->CI->order_m->order_product_details($orderDetails->organizationProductId);
			if(!empty($productDetails))
			{
				$returnArr['productName'] 	   = $productDetails->code;
				
				$returnArr['productImageName'] = $productDetails->imageName;				
			}
			
			$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($orderDetails->shippingOrgId);
			//echo "<pre>";	print_r($shipperDetails); exit;
			
		}
		
		return $returnArr;
		
	}
	
	public function confirmation_order_index()
	{
		$return = array();
		$where  = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
			
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		$return['total'] = $this->CI->order_pickup_m->total_confirmation_pickup_order();	
		return $return;
	}
	
	public function confirmation_order_ajax($total)
	{
		$return = array();
		$perPage = $this->CI->input->post('sel_no_entry');
		$where = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/confirm_pickup_order/confirmationOrderAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_pickup_m->confirmation_order_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function ready_to_shipped_order_ajax($total)
	{
		$return = array();
		$perPage = $this->CI->input->post('sel_no_entry');
		$where = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/ready_to_shipped/readyShippedAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_pickup_m->ready_shipped_order_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function ready_to_shipped_order_index()
	{
		$return = array();
		$where  = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$return['total'] = $this->CI->order_pickup_m->total_ready_to_be_shipped_order($where);	
		//echo $this->CI->db->last_query(); exit;
		return $return;
	}
	
	public function cancel_order($orderID)
	{
		$getDetails = $this->CI->order_m->order_details($orderID);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{	
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$this->CI->order_m->cancel_order_details($customOrderDet->orderDetailId);
				}
			}
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
			$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
			
			$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
			$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
			
			/******Mail for Custmer*******/
			if(!empty($customerDetails))
			{				
				$mailData = array(
								'email'           => $customerDetails->email,
								'cc'	          => '',
								'slug'            => 'order_false_for_customer',
								'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
								'subject'  		  => 'Order has been deleted',
							);
				if($this->CI->email_m->send_mail($mailData))
				{
					$this->CI->custom_log->write_log('custom_log','Mail send successfully');
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log','Mail not send');
				}
			}
			
			/******Mail for Retailer*******/
			if(!empty($retailerDetails))
			{
				$mailData = array(
								'email'           => $retailerDetails->email,
								'cc'	          => '',
								'slug'            => 'order_false_for_retailer',
								'sellerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
								'orderId'		  => $getDetails->customOrderId,
								'subject'  		  => 'Order has been deleted',
							);
				if($this->CI->email_m->send_mail($mailData))
				{
					$this->CI->custom_log->write_log('custom_log','Mail Send Successfully');
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log','Mail not send');
				}	
			}
			
			if($this->CI->order_m->cancel_order($orderID))
			{
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');	
			}
			else
			{
				$this->CI->session->set_flashdata('success','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
			$this->CI->custom_log->write_log('custom_log','last querty is '.$this->CI->db->last_query());
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/new_pickup_order');
	}
	
	public function history_order_index()
	{
		$return = array();
		$where  = '';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$return['total'] = $this->CI->order_pickup_m->total_history_order($where);			
		return $return;
	}	
	
	public function history_order_ajax($total)
	{
		$return = array();
		$where = '';
		$perPage = $this->CI->input->post('sel_no_entry');
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		elseif((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}		
	//echo "<pre>"; print_r($dropship_center); exit;
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		//echo $where; exit;
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/history_order_pickup/historyAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_pickup_m->history_order_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function delivered_order_index()
	{
		$return = array();
		$where='';
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$return['total'] = $this->CI->order_pickup_m->total_delivered_order($where);	
		return $return;
	}	
	
	public function delivered_order_ajax($total)
	{
		$return = array();
		$where = '';
		$perPage = $this->CI->input->post('sel_no_entry');
		$userRole   = $this->CI->session->userdata('userRole');
		$userType   = $this->CI->session->userdata('userType');
		$employeeId = $this->CI->session->userdata('userId');
		$drincr     = 1;
		$in         = '';
		$dropship_center = '';
		
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->user_m->get_shipping_employee_dropship($employeeId);
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		
		if(!empty($dropship_center))
		{
			foreach($dropship_center as $centerdetail)
			{
				if($drincr==1)
				{
					$in = $centerdetail->dropCenterId;
				}
				else
				{
					$in .=','.$centerdetail->dropCenterId;
				}
				$drincr++;
			}
			if(!empty($in))
			{
				$where = 'order_dropship_center.toDropshipId in ('.$in.')';
			}
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/order_picked_up/deliveredAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_pickup_m->delivered_order_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}

}