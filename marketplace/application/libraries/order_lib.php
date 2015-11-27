<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function order_complete_success($orderTotalId)
	{
		$result 	  				   = array();
		$result['isPickup']			   = 0;
		$result['pickupName']     	   = '';
		$result['pickupName']     	   = '';
		$result['pickupAddress1'] 	   = '';
		$result['pickupCity']     	   = '';
		$result['pickupArea']     	   = '';
		$result['pickupState']    	   = '';
		$result['pickupPhone']    	   = '';
		$result['pickupSecPhone']      = '';
		$result['pickupBusnsDay']      = '';
		$result['pickupBusnsHrs']      = '';
					
		$result['totalAmount']     	   = '';
		
		$result['customerFirstName']   = '';
		$result['customerLastName']    = '';
		$result['customerPhoneNo']     = '';
		$result['customerAddress1']    = '';
		$result['customerCityName']    = '';
		$result['customerAreaName']    = '';
		$result['customerStateName']   = '';
		$result['customerCountryName'] = '';
		
		$result['orderList']		   = '';
		$customerId    = $this->CI->session->userdata('userId');
		$orderTotalDet = $this->CI->order_m->order_total_detail($orderTotalId);
		if(!empty($orderTotalDet))
		{
			$result['isPickup']    = $orderTotalDet->isPickup;
			$result['totalAmount'] = $orderTotalDet->totalAmount;
			
			$orderList = $this->CI->order_m->order_custom_payment_list($orderTotalId);
			if(!empty($orderList))
			{
				foreach($orderList as $row)
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalProductAmount'] = $row->totalProductAmount;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderDetailId'] = $row->orderDetailId;
					$result['orderList'][$row->orderCustomPaymentId]['totalCustomAmount'] = $row->totalCustomAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalCustomShippingAmount'] = $row->totalCustomShippingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalCustomCashHandlingAmount'] = $row->totalCustomCashHandlingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalCustomPickupProccessAmount'] = $row->totalCustomPickupProccessAmount;
					$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
					$result['orderList'][$row->orderCustomPaymentId]['organizationName'] = $row->organizationName;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['pickupProcessingAmount'] = $row->pickupProcessingAmount;
					$result['pickupId'] = $row->pickupId;					
				}
			}
			
			if($result['isPickup'])
			{
				$pickupDet = $this->CI->cart_m->pickup_details($result['pickupId']);
				if(!empty($pickupDet))
				{
					$result['pickupName']     = $pickupDet->pickupName;
					$result['pickupAddress1'] = $pickupDet->addressLine1;
					$result['pickupCity']     = $pickupDet->cityName;
					$result['pickupArea']     = $pickupDet->areaName;
					$result['pickupState']    = $pickupDet->stateName;
					$result['pickupPhone']    = $pickupDet->phone;
					$result['pickupSecPhone'] = $pickupDet->secondary_phone;
					$result['pickupBusnsDay'] = $pickupDet->businessDays;
					$result['pickupBusnsHrs'] = $pickupDet->businessHours;				
				}
				
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);				
				if(!empty($customerDetails))
				{
					$return['customerFirstName']   = $customerDetails->firstName;
					$return['customerLastName']    = $customerDetails->lastName;
					$return['customerPhoneNo']     = $customerDetails->phone;
				}
			}
			else
			{
				$shippingDetails = $this->CI->order_m->order_shipping_address_detail($orderTotalId);			
				if(!empty($shippingDetails))
				{
					$result['customerFirstName']   = $shippingDetails->firstName;
					$result['customerLastName']    = $shippingDetails->lastName;
					$result['customerPhoneNo']     = $shippingDetails->phone;
					$result['customerAddress1']    = $shippingDetails->addressLine1;
					$result['customerCityName']    = $shippingDetails->cityName;
					$result['customerAreaName']    = $shippingDetails->areaName;
					$result['customerStateName']   = $shippingDetails->stateName;
					$result['customerCountryName'] = $shippingDetails->countryName;
				}
			}
		}
		return $result;
	}
	
	public function custom_order_list()
	{
		$result 	  				   = array();
		$result['orderList']		   = '';
		$customerId = $this->CI->session->userdata('userId');
		$orderList  = $this->CI->order_m->customer_custom_order_list();
		//echo "<pre>"; print_r($orderList); exit;
		if(!empty($orderList))
		{
			foreach($orderList as $row)
			{
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId'] = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName'] = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity'] = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalProductAmount'] = $row->totalProductAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderDetailId'] = $row->orderDetailId;
				$result['orderList'][$row->orderCustomPaymentId]['totalCustomAmount'] = $row->totalCustomAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalCustomShippingAmount'] = $row->totalCustomShippingAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalCustomCashHandlingAmount'] = $row->totalCustomCashHandlingAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalCustomPickupProccessAmount'] = $row->totalCustomPickupProccessAmount;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['organizationName'] = $row->organizationName;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['pickupProcessingAmount'] = $row->pickupProcessingAmount;
				$result['orderList'][$row->orderCustomPaymentId]['pickupId'] = $row->pickupId;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup'] = $row->isPickup;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['trackingNbr'] = $row->trackingNbr;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderDate'] = $row->createDt;
				$result['orderList'][$row->orderCustomPaymentId]['createDt'] = $row->createDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['deliveredDate'] = $row->deliveredDate;
				if($row->isPickup)
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['eta'] = $row->estimateDayPickUp;
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['eta'] = $row->estimateDayShipp;
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['pointeForcePaidStatus'] = $row->pointeForcePaidStatus;
				if((!empty($result['orderList'][$row->orderCustomPaymentId]['totalCommissionPrice']))&&($result['orderList'][$row->orderCustomPaymentId]['totalCommissionPrice']))
				{
					$result['orderList'][$row->orderCustomPaymentId]['totalCommissionPrice'] = $result['orderList'][$row->orderCustomPaymentId]['totalCommissionPrice']+$row->totalCommissionPrice;
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['totalCommissionPrice'] = $row->totalCommissionPrice;
				}
			}
		}
			
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function track_orders_detail($orderDetailId)
	{
		$return                            = array();
		$return['totalShipping']           = '';
		$return['productPrice']            = '';
		$return['newOrderTime']            = '';
		$return['confirmOrderTime']        = '';
		$return['readyToShippedOrderTime'] = '';
		$return['inTransitOrderTime']      = '';
		$return['deliveredOrderTime']      = '';
		$return['dropCenterName']          = '';
		$return['customerFirstName']       = '';
		$return['customerLastName']    	   = '';
		$return['customerPhoneNo']         = '';
		$return['customerAddress1']        = '';
		$return['customerAddress2']        = '';
		$return['customerAreaName']		   = '';
		$return['customerCityName']        = '';
		$return['customerStateName']       = '';
		$return['customerCountryName']     = '';
		$return['customerZip']		       = '';
		$return['isPickup']  		       = '';
		$return['paymentStatus']	       = 0;
		$return['pickupName']     		   = '';
		$return['pickupAddress1'] = '';
		$return['pickupCity']     = '';
		$return['pickupArea']     = '';
		$return['pickupState']    = '';
		$return['pickupPhone']    = '';
		$return['pickupSecPhone'] = '';
		$return['pickupBusnsDay'] = '';
		$return['pickupBusnsHrs'] = '';
		$return['totalFullSum']   = 0;
		$return['orderActiveStatus'] = 1;
		$return['orderTotalId'] = 0;
		
		$return['productName'] = '';
		$return['quantity'] = 0;
		$return['orderStatusId'] = 0;
		$return['shippingBusinessName'] = '';
		$return['orderDate'] = '';
		$return['trackingNbr'] = '';
		$return['eta'] = 0;
		$return['customOrderId'] = '';
		$return['retailerBusinessName'] = '';
		
		
		
		$customerId   = $this->CI->session->userdata('userId');
		$orderDetails = $this->CI->order_m->custom_order_details($orderDetailId);
		if(!empty($orderDetails))
		{
			$return['paymentStatus']	 = $orderDetails->paymentStatus;
			$return['orderTotalId'] 	 = $orderDetails->orderTotalId;
			$return['isPickup']     	 = $orderDetails->isPickup;
			$return['productName']       = $orderDetails->code;
			$return['quantity']     	 = $orderDetails->quantity;
			$return['productImageName']  = $orderDetails->imageName;
			$return['color']     		 = $orderDetails->colorCode;
			$return['size']     		 = $orderDetails->sizes;
			$return['orderActiveStatus'] = $orderDetails->active;
			$return['orderStatusId']     = $orderDetails->orderStatusId;
			
			$return['customOrderId'] 		= $orderDetails->customOrderId;
			$return['retailerBusinessName'] = $orderDetails->organizationName;
			$return['dropCenterName'] 		= $orderDetails->dropCenterName;
			
			$return['totalFullSum'] = $orderDetails->totalProductAmount+$orderDetails->shippingAmount+$orderDetails->pickupProcessingAmount+$orderDetails->pickupProcessingAmount;
			
			
			$trackOrderTime = $this->CI->order_m->custom_track_order_time($orderDetailId);
			if(!empty($trackOrderTime))
			{
				foreach($trackOrderTime as $timeRow)
				{
					if($timeRow->orderStatusId==1)
					{
						$return['newOrderTime'] = strtotime($timeRow->createDt);
						$return['orderDate']    = $timeRow->createDt;
						
					}
					elseif($timeRow->orderStatusId==2)
					{
						$return['confirmOrderTime'] = strtotime($timeRow->createDt);
					}
					elseif($timeRow->orderStatusId==3)
					{
						$return['readyToShippedOrderTime'] = strtotime($timeRow->createDt);
					}
					elseif($timeRow->orderStatusId==4)
					{
						$return['inTransitOrderTime'] = strtotime($timeRow->createDt);
					}
					elseif($timeRow->orderStatusId==5)
					{
						$return['deliveredOrderTime'] = strtotime($timeRow->createDt);
					}
				}
			}
		}
		
		if($return['isPickup'])
		{
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);				
			if(!empty($customerDetails))
			{
				$return['customerFirstName']   = $customerDetails->firstName;
				$return['customerLastName']    = $customerDetails->lastName;
				$return['customerPhoneNo']     = $customerDetails->phone;
			}
			$return['eta'] = $orderDetails->estimateDayPickup;
		}
		else
		{
			$return['eta'] = $orderDetails->estimateDayShipp;
			$shippingDetails = $this->CI->order_m->order_shipping_address_detail($return['orderTotalId']);			
			if(!empty($shippingDetails))
			{
				$return['customerFirstName']   = $shippingDetails->firstName;
				$return['customerLastName']    = $shippingDetails->lastName;
				$return['customerPhoneNo']     = $shippingDetails->phone;
				$return['customerAddress1']    = $shippingDetails->addressLine1;
				$return['customerCityName']    = $shippingDetails->cityName;
				$return['customerAreaName']    = $shippingDetails->areaName;
				$return['customerStateName']   = $shippingDetails->stateName;
				$return['customerCountryName'] = $shippingDetails->countryName;
			}
		}	
		//echo "<pre>"; print_r($return); exit;
		return $return;
	}
	
	public function orders_ajax_list()
	{
		$return 	     = array();
		$perPage    	 = $this->CI->input->post('sel_no_entry');
		$where 		     = '';		
		$userRole        = $this->CI->session->userdata('userRole');
		$userType        = $this->CI->session->userdata('userType');
		$employeeId      = $this->CI->session->userdata('userId');
		$drincr          = 1;
		$in              = '';
		$dropship_center = '';
		$searchDropship  = $this->CI->input->post('dropship');
		$searchOrderSts  = $this->CI->input->post('orderStatus');
		$cusDetDrp       = $this->CI->input->post('cusDetDrp');
		$cusDetTxt       = $this->CI->input->post('cusDetTxt');
		$retDetDrp       = $this->CI->input->post('retDetDrp');
		$retDetTxt       = $this->CI->input->post('retDetTxt');
		$prdDetDrp       = $this->CI->input->post('prdDetDrp');
		$prdDetTxt       = $this->CI->input->post('prdDetTxt');
		$ordrDetDrp      = $this->CI->input->post('ordrDetDrp');
		$ordrDetTxt      = $this->CI->input->post('ordrDetTxt');
		
		//print_r($_POST);	 exit;
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->shipping_m->shipping_employee_dropship_center_list($employeeId);
			$where = '(order_custom_payment.dropShipCenterId IS NULL)';
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
			$where = '(order_custom_payment.dropShipCenterId IS NULL)';
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
				$where = 'order_custom_payment.dropShipCenterId in ('.$in.')';
			}
		}
		
		if(!empty($searchDropship))
		{
			if(!empty($where))
			{
				$where.= ' AND dropship_center.dropCenterName Like "'.$searchDropship.'%"';
			}
			else
			{
				$where = 'dropship_center.dropCenterName Like "'.$searchDropship.'%"';
			}
		}
			
		if(!empty($searchOrderSts))
		{
			$ordrSts = '';
			if($searchOrderSts==1)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 1)';
			}
			elseif($searchOrderSts==2)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 1)';
			}
			elseif($searchOrderSts==3)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 2)';
			}
			elseif($searchOrderSts==4)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 2)';
			}
			elseif($searchOrderSts==5)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 3)';
			}
			elseif($searchOrderSts==6)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 3)';
			}
			elseif($searchOrderSts==7)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 4)';
			}
			elseif($searchOrderSts==8)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 5)';
			}
			elseif($searchOrderSts==9)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 5)';
			}
			elseif($searchOrderSts==10)
			{
				$ordrSts = '(order_details.active = 0 AND order_details.orderStatusId = 6)';
			}
			
			if(!empty($ordrSts))
			{
				if(!empty($where))
				{
					$where.= ' AND '.$ordrSts;
				}
				else
				{
					$where = $ordrSts;
				}	
			}
		}
		
		if(!empty($cusDetDrp))		
		{
			if(!empty($cusDetTxt))
			{
				if(!empty($where))
				{
					if($cusDetDrp=='name')
					{
						$where.= ' AND CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='phone')
					{
						$where.= ' AND customer.phone Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='state')
					{
						$where.= ' AND state.stateName Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='area')
					{
						$where.= ' AND area.area Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='city')
					{
						$where.= ' AND zip.city Like "'.$cusDetTxt.'%"';
					}
				}
				else
				{					
					if($cusDetDrp=='name')
					{
						$where= 'CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='phone')
					{
						$where= 'customer.phone Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='state')
					{
						$where= 'state.stateName Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='area')
					{
						$where= 'area.area Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='city')
					{
						$where= 'zip.city Like "'.$cusDetTxt.'%"';
					}				
				}
			}
		}
		elseif(!empty($cusDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%" OR customer.phone Like "'.$cusDetTxt.'%" OR state.stateName Like "'.$cusDetTxt.'%" OR area.area Like "'.$cusDetTxt.'%" OR zip.city Like "'.$cusDetTxt.'%" )';
			}
			else
			{
				$where.= '( CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%" OR customer.phone Like "'.$cusDetTxt.'%" OR state.stateName Like "'.$cusDetTxt.'%" OR area.area Like "'.$cusDetTxt.'%" OR zip.city Like "'.$cusDetTxt.'%" )';
			}
		}
		
		if(!empty($retDetDrp))		
		{
			if(!empty($retDetTxt))
			{
				if(!empty($where))
				{
					if($retDetDrp=='name')
					{
						$where.= ' AND organization.organizationName Like "'.$retDetTxt.'%"';
					}
					elseif($retDetDrp=='phone')
					{
						$where.= ' AND employee.businessPhone Like "'.$retDetTxt.'%"';
					}
				}
				else
				{					
					if($retDetDrp=='name')
					{
						$where = 'organization.organizationName Like "'.$retDetTxt.'%"';
					}
					elseif($retDetDrp=='phone')
					{
						$where = 'employee.businessPhone Like "'.$retDetTxt.'%"';
					}
				}
			}
		}
		elseif(!empty($retDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( employee.businessPhone Like "'.$retDetTxt.'%" OR organization.organizationName Like "'.$retDetTxt.'%")';
			}
			else
			{
				$where.= '( employee.businessPhone Like "'.$retDetTxt.'%" OR organization.organizationName Like "'.$retDetTxt.'%")';
			}
		}
		
		if(!empty($prdDetDrp))		
		{
			if(!empty($prdDetTxt))
			{
				if(!empty($where))
				{
					if($prdDetDrp=='name')
					{
						$where.= ' AND product.code Like "'.$prdDetTxt.'%"';
					}
					elseif($prdDetDrp=='price')
					{
						$where.= ' AND order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%"';
					}
				}
				else
				{					
					if($prdDetDrp=='name')
					{
						$where = 'product.code Like "'.$prdDetTxt.'%"';
					}
					elseif($prdDetDrp=='price')
					{
						$where = 'order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%"';
					}
				}
			}
		}
		elseif(!empty($prdDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( product.code Like "'.$prdDetTxt.'%" OR order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%")';
			}
			else
			{
				$where.= '( product.code Like "'.$prdDetTxt.'%" OR order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%")';
			}
		}
		
		if(!empty($ordrDetDrp))		
		{
			if(!empty($ordrDetTxt))
			{
				if(!empty($where))
				{
					if($ordrDetDrp=='customOrderId')
					{
						$where.= ' AND order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='dateTime')
					{
						$where.= ' AND order_custom_payment.createDt Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='orderType')
					{
						$strDel = stripos('Quick Shipment',$ordrDetTxt);
						if($strDel===false)
						{
							$strDel = stripos('Single Shipment',$ordrDetTxt);
							if($strDel===false)
							{
								$strDel = stripos('Pick Up',$ordrDetTxt);						
								if($strDel===false)
								{
									$where.= ' AND order_total.isPickup = 2';
								}
								else
								{
									$where.= ' AND order_total.isPickup = 1';
								}
							}
							else
							{
								$where.= ' AND order_total.isPickup = 0 AND order_total.isEconomicDelivery = 1';
							}
						}
						else
						{
							$where.= ' AND order_total.isPickup = 0 AND order_total.isEconomicDelivery = 0';
						}
					}
					elseif($ordrDetDrp=='paymentMode')
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$where.= ' AND order_total.paymentStatus = 2';
								}
								else
								{
									$where.= ' AND (order_total.isPickup = 1 AND order_total.paymentStatus = 0)';
								}							
							}
							else
							{
								$where.= ' AND (order_total.isPickup = 0 AND order_total.paymentStatus = 0)';
							}
						}
						else
						{
							$where.= ' AND order_total.paymentStatus = 1';
						}						
					}
				}
				else
				{					
					if($ordrDetDrp=='customOrderId')
					{
						$where = 'order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='dateTime')
					{
						$where = 'order_custom_payment.createDt Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='orderType')
					{						
						$strDel = stripos('Quick Shipment',$ordrDetTxt);
						if($strDel===false)
						{
							$strDel = stripos('Single Shipment',$ordrDetTxt);
							if($strDel===false)
							{
								$strDel = stripos('Pick Up',$ordrDetTxt);						
								if($strDel===false)
								{
									$where.= 'order_total.isPickup = 2';
								}
								else
								{
									$where.= 'order_total.isPickup = 1';
								}
							}
							else
							{
								$where.= 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 1';
							}
						}
						else
						{
							$where.= 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 0';
						}
					}
					elseif($ordrDetDrp=='paymentMode')
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$where = 'order_total.paymentStatus = 2';
								}
								else
								{
									$where = '(order_total.isPickup = 1 AND order_total.paymentStatus = 0)';
								}							
							}
							else
							{
								$where = '(order_total.isPickup = 0 AND order_total.paymentStatus = 0)';
							}
						}
						else
						{
							$where = 'order_total.paymentStatus = 1';
						}						
					}					
				}
			}
		}
		elseif(!empty($ordrDetTxt))
		{
			$strWhere = '';
			$strDel = stripos('Quick Shipment',$ordrDetTxt);
			if($strDel===false)
			{
				$strDel = stripos('Single Shipment',$ordrDetTxt);
				if($strDel===false)
				{
					$strPick = stripos('Pick Up',$ordrDetTxt);						
					if($strPick===false)
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$strWhere = 'order_total.paymentStatus = 2';
								}
								else
								{
									$strWhere = '(order_total.isPickup = 1 AND order_total.paymentStatus = 0)';
								}							
							}
							else
							{
								$strWhere = '(order_total.isPickup = 0 AND order_total.paymentStatus = 0)';
							}
						}
						else
						{
							$strWhere = 'order_total.paymentStatus = 1';
						}						
					}
					else
					{
						$strWhere = 'order_total.isPickup = 1';
					}
				}
				else
				{
					$strWhere = 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 1';
				}
			}
			else
			{
				$strWhere = 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 0';
			}			
					
			if(!empty($where))
			{
				if(!empty($strWhere))
				{
					$where.= ' AND ( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" OR '.$strWhere.' )';
				}
				else
				{
					$where.= ' AND ( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" )';				
				}
			}
			else
			{
				if(!empty($strWhere))
				{
					$where = '( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" OR '.$strWhere.' )';
				}
				else
				{
					$where = '( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" )';				
				}
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$ttl 	   = $this->CI->order_m->custom_orders_list('','',$where);
		$total     = count($ttl);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/orders_management/orders_ajax_list/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_m->custom_orders_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	
	}
		
	public function single_shippment_order_view($orderCustomPaymentId)
	{
		$result 					       	= array();
		$result['customerOrderId']      	= '';
		
		$result['newOrderTime']             = '';
		$result['confirmOrderTime']         = '';
		$result['readyToShippedOrderTime']  = '';
		$result['inTransitOrderTime']       = '';
		$result['deliveredOrderTime']       = '';
		
		$result['trackingNbr']     		    = '';
		
		$result['productList']   		    = '';
		$orderDetailId 						= 0;
		$dropShipCenterId 					= 0; 
		$organizationProductId				= 0;
		$customerId							= 0;
		$shippingOrgId						= 0;
		$orderTotalId						= 0;	
		$result['orderActiveStatus']		= 0;
		
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
					
		$productList = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->CI->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->CI->form_validation->run())
	    	{
				if(!empty($productList))
				{
					foreach($productList as $row)
					{
						if($this->CI->order_m->quick_shippment_save_tracking_number($row->orderDetailId,$result['trackingNbr']))
						{
							$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_save_track_no'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_save_track_no'));
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_save_track_no'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_save_track_no'));
						}
					}
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/orders_management/single_shippment_order_view/'.id_encrypt($orderCustomPaymentId));	
			}
		}
		
		if(!empty($productList))
		{
			foreach($productList as $row)
			{
				$orderStatusId = $row->orderStatusId;
				$result['productList'][$row->productId]['productId'] 	 = $row->productId;
				$result['productList'][$row->productId]['productName'] 	 = $row->code;
				$result['productList'][$row->productId]['quantity'] 	 = $row->quantity;
				$result['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['productList'][$row->productId]['colorCode'] 	 = $row->colorCode;
				$result['productList'][$row->productId]['size'] 		 = $row->sizes;
				$result['productList'][$row->productId]['imageName'] 	 = $row->imageName;
				$result['productList'][$row->productId]['totalProductAmount'] = $row->totalProductAmount;
				$result['productList'][$row->productId]['totalRetailerAmount'] = $row->totalRetailerAmount;
				$result['productList'][$row->productId]['orderDetailId'] 	  = $row->orderDetailId;
				$result['totalCustomAmount'] 			   = $row->totalCustomAmount;
				$result['totalCustomShippingAmount'] 	   = $row->totalCustomShippingAmount;
				$result['totalCustomCashHandlingAmount']   = $row->totalCustomCashHandlingAmount;
				$result['customOrderId'] 				   = $row->customOrderId;
				$result['organizationName'] 			   = $row->organizationName;
				$result['trackingNbr'] 					   = $row->trackingNbr;
				$result['orderActiveStatus']				= $row->active;
				$result['orderStatusId']					= $row->orderStatusId;
				$result['paymentStatus']					= $row->paymentStatus;
				$orderDetailId = $row->orderDetailId;
				$dropShipCenterId = $row->dropShipCenterId;
				$organizationProductId = $row->organizationProductId;
				$customerId			= $row->customerId;
				$shippingOrgId		= $row->shippingOrgId;
				$orderTotalId		= $row->orderTotalId;
			}
			
			if($orderDetailId)
			{
				$trackDetails = $this->CI->order_m->custom_track_order_time($orderDetailId);
				
				if(!empty($trackDetails))
				{
					foreach($trackDetails as $row)
					{
						if($row->orderStatusId==1)
						{
							$result['newOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==2)
						{
							$result['confirmOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==3)
						{
							$result['readyToShippedOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==4)
						{
							$result['inTransitOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==5)
						{
							$result['deliveredOrderTime'] = $row->createDt;
						}
					}
				}
			}
			
			if($dropShipCenterId)
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($dropShipCenterId);
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			if($organizationProductId)
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				if(!empty($retailerDetails))
				{
					$result['retailerOrganizationName'] = $retailerDetails->organizationName;
					$result['retailerEmail'] 		   = $retailerDetails->email;
					$result['retailerFirstName'] 	   = $retailerDetails->firstName;
					$result['retailerMiddle'] 		   = $retailerDetails->middle;
					$result['retailerLastName'] 		   = $retailerDetails->lastName;
					$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
					$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
					$result['retailerUserName'] 		   = $retailerDetails->userName;
					$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
					$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
					$result['retailerCountryName'] 	   = $retailerDetails->countryName;
					$result['retailerStateName'] 	   = $retailerDetails->stateName;
					$result['retailerCityName'] 		   = $retailerDetails->cityName;
					$result['retailerAreaName']		   = $retailerDetails->areaName;
				}
			}
			
			if($customerId)
			{
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
				if(!empty($customerDetails))
				{
					$result['customerFirstName'] = $customerDetails->firstName;
					$result['customerLastName']	 = $customerDetails->lastName;
					$result['customerPhone']	 = $customerDetails->phone;	
					$result['customerEmail']	 = $customerDetails->email;
				}
			}
			
			if($shippingOrgId)
			{
				$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($shippingOrgId);
				if(!empty($shipperDetails))
				{
					$result['vendorBusinessName'] 	  = $shipperDetails->organizationName;
					$result['vendorFirstName'] 		  = $shipperDetails->firstName;
					$result['vendorLastName'] 		  = $shipperDetails->lastName;
					$result['vendorEmail'] 			  = $shipperDetails->email;
					$result['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
					$result['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
					$result['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
					$result['vendorCountryName'] 	  = $shipperDetails->countryName;
					$result['vendorStateName'] 		  = $shipperDetails->stateName;
					$result['vendorCityName'] 		  = $shipperDetails->cityName;
					$result['vendorAreaName'] 		  = $shipperDetails->areaName;
				}
			}
			
			if($orderTotalId)
			{
				$billingDetails  = $this->CI->order_m->order_billing_address_detail($orderTotalId);
				if(!empty($billingDetails))
				{
					$result['customerBillFirstName'] = $billingDetails->firstName;
					$result['customerBillLastName']  = $billingDetails->lastName;
					$result['customerBillPhone']     = $billingDetails->phone;
					
					if(empty($billingDetails->firstName))
					{				
						$result['customerBillFirstName'] = $result['customerFirstName'];
					}
					if(empty($billingDetails->lastName))
					{
						$result['customerBillLastName'] = $result['customerLastName'];
					}
					if(empty($billingDetails->phone))
					{
						$result['customerBillPhone'] = $result['customerPhone'];
					}
					
					$result['billingCountry']        = $billingDetails->countryName;
					$result['billingState']    	    = $billingDetails->stateName;
					$result['billingArea']   	    = $billingDetails->areaName;
					$result['billingCity']     	    = $billingDetails->cityName;
					$result['billingAddressLine1']   = $billingDetails->addressLine1;
					$result['billingAddressLine2']   = $billingDetails->address_Line2;
				}
				
				$shippingDetails = $this->CI->order_m->order_shipping_address_detail($orderTotalId);
				if(!empty($shippingDetails))
				{
					$result['customerShippFirstName'] = $shippingDetails->firstName;
					$result['customerShippLastName']	 = $shippingDetails->lastName;
					$result['customerShippPhone']	 = $shippingDetails->phone;	
					$result['shippingCountry']      = $shippingDetails->countryName;
					$result['shippingState']    	   = $shippingDetails->stateName;
					$result['shippingArea'] 	       = $shippingDetails->areaName;
					$result['shippingCity']     	   = $shippingDetails->cityName;
					$result['shippingAddressLine1'] = $shippingDetails->addressLine1;
					$result['shippingAddressLine2'] = $shippingDetails->address_Line2;
				}
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}	
	
	public function single_shippment_cancel_order($orderCustomPaymentId)
	{
		$getDetails = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		
		if(!empty($getDetails))
		{
			$customerId = 0;
			$organizationProductId = 0;
			if($this->CI->order_m->cancel_single_shippment_order($orderCustomPaymentId))
			{
				foreach($getDetails as $row)
				{
					$customerId = $row->customerId;
					$organizationProductId = $row->organizationProductId;
					$this->CI->order_m->cancel_order_details($row->orderDetailId);				
				}
				
				$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($customerId);
				$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
				
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
				
				/******Mail for Custmer*******/
				if(!empty($customerDetails))
				{				
					$mailData = array(
									'email'        => $customerDetails->email,
									'cc'	       => '',
									'slug'         => 'order_false_for_customer',
									'customerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
									'subject'  	   => 'Order has been deleted',
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
									'email'      => $retailerDetails->email,
									'cc'	     => '',
									'slug'       => 'order_false_for_retailer',
									'sellerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
									'orderId'	 => $organizationProductId,
									'subject'  	 => 'Order has been deleted',
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
				
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function single_shippment_declined_order($orderCustomPaymentId)
	{
		$getDetails = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		
		if(!empty($getDetails))
		{
			$customerId = 0;
			$organizationProductId = 0;
			if($this->CI->order_m->cancel_single_shippment_order($orderCustomPaymentId))
			{
				foreach($getDetails as $row)
				{
					$customerId = $row->customerId;
					$organizationProductId = $row->organizationProductId;
					$this->CI->order_m->declined_order_details($row->orderDetailId);
					
					if($this->CI->order_m->increase_product_quantity($organizationProductId,$row->quantity))
					{
						$this->CI->custom_log->write_log('custom_log','prdouct quantity increase successfully');
						
						if((!empty($row->colorId))&&($row->colorId)&&(!empty($row->productSizeId))&&($row->productSizeId))
						{
							if($this->CI->order_m->increase_product_color_size_quantity($organizationProductId,$row->colorId,$row->productSizeId,$row->quantity))
							{
								$this->CI->custom_log->write_log('custom_log','prdouct color size quantity increase successfully');
							}
							else
							{
								$this->CI->custom_log->write_log('custom_log','product color size quantity not increase last query is '.$this->CI->db->last_query());
							}
						}
						elseif((!empty($row->colorId))&&($row->colorId))
						{
							if($this->CI->order_m->increase_product_color_quantity($organizationProductId,$row->colorId,$row->quantity))
							{
								$this->CI->custom_log->write_log('custom_log','prdouct color quantity increase successfully');
							}
							else
							{
								$this->CI->custom_log->write_log('custom_log','product color quantity not increase last query is '.$this->CI->db->last_query());
							}
						}
						elseif((!empty($row->productSizeId))&&($row->productSizeId))
						{
							if($this->CI->order_m->increase_product_size_quantity($organizationProductId,$row->productSizeId,$row->quantity))
							{
								$this->CI->custom_log->write_log('custom_log','prdouct size quantity increase successfully');
							}
							else
							{
								$this->CI->custom_log->write_log('custom_log','product size quantity not increase last query is '.$this->CI->db->last_query());
							}
						}
						
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log','product quantity not increase last query is '.$this->CI->db->last_query());
					}	
				}
				
				$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($customerId);
				$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
				
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
				
				/******Mail for Custmer*******/
				if(!empty($customerDetails))
				{				
					$mailData = array(
									'email'        => $customerDetails->email,
									'cc'	       => '',
									'slug'         => 'order_false_for_customer',
									'customerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
									'subject'  	   => 'Order has been deleted',
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
									'email'      => $retailerDetails->email,
									'cc'	     => '',
									'slug'       => 'order_false_for_retailer',
									'sellerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
									'orderId'	 => $organizationProductId,
									'subject'  	 => 'Order has been deleted',
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
				
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function single_shippment_change_new_to_confirm_order($orderCustomPaymentId)
	{
		$getDetails = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		//print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			$customerId = 0;
			$organizationProductId = 0;
			$shippingRateId = 0;
			foreach($getDetails as $row)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($row->orderDetailId,2);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_confirm_to_ready($row->orderDetailId))
				{
	            }
				$shippingRateId = $row->shippingRateId;
			}
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($shippingRateId);
			
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
                    $shippingVendor  = $rateDetails->organizationName;
					$shippingVendorEmail  = $rateDetails->email;
					$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                    $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
					
					$dropShipAddress = '';
					$dropshipAddDet = $this->CI->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}


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
						$retailerPrdArr['tracking_no']	       = $row->trackingNbr;
						
					}
					
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
							}
						}
						$mailContent.= '</tbody></table>';
						/********Mail for customer********************/
						$mailData = array(
										'email'           => $customerDetails->email,
										'cc'			  => '',
										'slug'            => 'economic_reay_to_shipp_order_for_customer',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'subject'  		  => 'Your Order Is Ready To Be Shipped',
									);					
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
						/********Mail for shipping vendor********************/
						$mailData = array(											
										'email'           => $shippingVendorEmail,
										'cc'			  => '',
										'slug'            => 'economic_ready_to_transit_for_shipper',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'tracking_no'     => $retailerPrdArr['tracking_no'],
										'dp_center_name'  => $retailerPrdArr['dropCenterName'],
										'dropShipCenterAddress' => $dropShipAddress,										
										'subject'  		  => 'Your Order Has Been Confirmed',
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						/********Mail for shipping vendor********************/
					}
					//echo "<pre>"; print_r($retailerPrdArr); exit;	
					foreach($getDetails AS $row)	
					{
						
							$message = '('.$orderID.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
							$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
							$this->CI->session->set_flashdata('success','Order status changed successfully');
							$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
											}
				
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
					$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
				$this->CI->custom_log->write_log('custom_log','Customer details not found');
			}
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');		
	}
	
	public function single_shippment_change_confirm_to_ready_order($orderCustomPaymentId)
	{
		$getDetails = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		//print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			$customerId = 0;
			$organizationProductId = 0;
			$shippingRateId = 0;
			foreach($getDetails as $row)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($row->orderDetailId,3);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_confirm_to_ready($row->orderDetailId))
				{
	            }
				$shippingRateId = $row->shippingRateId;
			}
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($shippingRateId);
			
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
                    $shippingVendor  = $rateDetails->organizationName;
					$shippingVendorEmail  = $rateDetails->email;
					$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                    $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
					
					$dropShipAddress = '';
					$dropshipAddDet = $this->CI->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}


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
						$retailerPrdArr['tracking_no']	       = $row->trackingNbr;
						
					}
					
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
							}
						}
						$mailContent.= '</tbody></table>';
						/********Mail for customer********************/
						$mailData = array(
										'email'           => $customerDetails->email,
										'cc'			  => '',
										'slug'            => 'economic_reay_to_shipp_order_for_customer',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'subject'  		  => 'Your Order Is Ready To Be Shipped',
									);					
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
						/********Mail for shipping vendor********************/
						$mailData = array(											
										'email'           => $shippingVendorEmail,
										'cc'			  => '',
										'slug'            => 'economic_ready_to_transit_for_shipper',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'tracking_no'     => $retailerPrdArr['tracking_no'],
										'dp_center_name'  => $retailerPrdArr['dropCenterName'],
										'dropShipCenterAddress' => $dropShipAddress,										
										'subject'  		  => 'Your Order Has Been Confirmed',
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						/********Mail for shipping vendor********************/
					}
					//echo "<pre>"; print_r($retailerPrdArr); exit;	
					foreach($getDetails AS $row)	
					{
						
							$message = '('.$orderID.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
							$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
							$this->CI->session->set_flashdata('success','Order status changed successfully');
							$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
											}
				
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
					$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
				$this->CI->custom_log->write_log('custom_log','Customer details not found');
			}
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');		
	}
	
	public function single_shippment_change_ready_to_shipped_order($orderCustomPaymentId)
	{
		$getDetails = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		//print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			$customerId = 0;
			$organizationProductId = 0;
			$shippingRateId = 0;
			foreach($getDetails as $row)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($row->orderDetailId,4);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_ready_to_shipped_in($row->orderDetailId))
				{
	            }
				$shippingRateId = $row->shippingRateId;
			}
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($shippingRateId);
			
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
                    $shippingVendor  = $rateDetails->organizationName;
					$shippingVendorEmail  = $rateDetails->email;
					$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                    $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
					
					$dropShipAddress = '';
					$dropshipAddDet = $this->CI->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}


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
						$retailerPrdArr['tracking_no']	       = $row->trackingNbr;
						
					}
					
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
							}
						}
						$mailContent.= '</tbody></table>';
						/********Mail for customer********************/
						$mailData = array(
										'email'           => $customerDetails->email,
										'cc'			  => '',
										'slug'            => 'economic_reay_to_shipp_order_for_customer',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'subject'  		  => 'Your Order Is Ready To Be Shipped',
									);					
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
						/********Mail for shipping vendor********************/
						$mailData = array(											
										'email'           => $shippingVendorEmail,
										'cc'			  => '',
										'slug'            => 'economic_ready_to_transit_for_shipper',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'tracking_no'     => $retailerPrdArr['tracking_no'],
										'dp_center_name'  => $retailerPrdArr['dropCenterName'],
										'dropShipCenterAddress' => $dropShipAddress,										
										'subject'  		  => 'Your Order Has Been Confirmed',
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						/********Mail for shipping vendor********************/
					}
					//echo "<pre>"; print_r($retailerPrdArr); exit;	
					foreach($getDetails AS $row)	
					{
						
							$message = '('.$orderID.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
							$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
							$this->CI->session->set_flashdata('success','Order status changed successfully');
							$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
											}
				
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
					$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
				$this->CI->custom_log->write_log('custom_log','Customer details not found');
			}
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');		
	}
	
	public function single_shippment_change_shipped_to_delivered_order($orderCustomPaymentId)
	{
		$getDetails = $this->CI->order_m->single_shippment_order_list($orderCustomPaymentId);
		//print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			$customerId = 0;
			$organizationProductId = 0;
			$shippingRateId = 0;
			foreach($getDetails as $row)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($row->orderDetailId,5);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_shipped_to_delivered($row->orderDetailId))
				{
	            }
				$shippingRateId = $row->shippingRateId;
			}
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($shippingRateId);
			
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
                    $shippingVendor  = $rateDetails->organizationName;
					$shippingVendorEmail  = $rateDetails->email;
					$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                    $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
					
					$dropShipAddress = '';
					$dropshipAddDet = $this->CI->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}


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
						$retailerPrdArr['tracking_no']	       = $row->trackingNbr;
						
					}
					
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
							}
						}
						$mailContent.= '</tbody></table>';
						/********Mail for customer********************/
						$mailData = array(
										'email'           => $customerDetails->email,
										'cc'			  => '',
										'slug'            => 'economic_reay_to_shipp_order_for_customer',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'subject'  		  => 'Your Order Is Ready To Be Shipped',
									);					
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
						/********Mail for shipping vendor********************/
						$mailData = array(											
										'email'           => $shippingVendorEmail,
										'cc'			  => '',
										'slug'            => 'economic_ready_to_transit_for_shipper',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'tracking_no'     => $retailerPrdArr['tracking_no'],
										'dp_center_name'  => $retailerPrdArr['dropCenterName'],
										'dropShipCenterAddress' => $dropShipAddress,										
										'subject'  		  => 'Your Order Has Been Confirmed',
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						/********Mail for shipping vendor********************/
					}
					//echo "<pre>"; print_r($retailerPrdArr); exit;	
					foreach($getDetails AS $row)	
					{
						
							$message = '('.$orderID.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
							$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
							$this->CI->session->set_flashdata('success','Order status changed successfully');
							$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
											}
				
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
					$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
				$this->CI->custom_log->write_log('custom_log','Customer details not found');
			}
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');		
	
	}
	
	public function quick_shippment_order_view($orderDetailId)
	{
		$result 					       	= array();
		$result['customerOrderId']      	= '';
		
		$result['newOrderTime']             = '';
		$result['confirmOrderTime']         = '';
		$result['readyToShippedOrderTime']  = '';
		$result['inTransitOrderTime']       = '';
		$result['deliveredOrderTime']       = '';
		
		$result['trackingNbr']     		    = '';
		
		$result['productList']   		    = '';
		$dropShipCenterId 					= 0; 
		$organizationProductId				= 0;
		$customerId							= 0;
		$shippingOrgId						= 0;
		$orderTotalId						= 0;	
		$result['orderActiveStatus']		= 0;
		
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
			
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->CI->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->CI->form_validation->run())
	    	{
				if($this->CI->order_m->quick_shippment_save_tracking_number($orderDetailId,$result['trackingNbr']))
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_save_track_no'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_save_track_no'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_save_track_no'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_save_track_no'));
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/orders_management/quick_shippment_order_view/'.id_encrypt($orderDetailId));	
			}
		}
				
		$productList = $this->CI->order_m->quick_shippment_order_list($orderDetailId);
		
		if(!empty($productList))
		{
			$orderStatusId = $productList->orderStatusId;
			$result['productId'] 	 = $productList->productId;
			$result['productName'] 	 = $productList->code;
			$result['quantity'] 	 = $productList->quantity;
			$result['orderStatusId'] = $productList->orderStatusId;
			$result['colorCode'] 	 = $productList->colorCode;
			$result['size'] 		 = $productList->sizes;
			$result['imageName'] 	 = $productList->imageName;
			$result['totalProductAmount'] = $productList->totalProductAmount;
			$result['totalRetailerAmount'] = $productList->totalRetailerAmount;
			$result['orderDetailId'] 	  = $productList->orderDetailId;
			$result['totalCustomAmount'] 			   = $productList->totalCustomAmount;
			$result['totalCustomShippingAmount'] 	   = $productList->totalCustomShippingAmount;
			$result['totalCustomCashHandlingAmount']   = $productList->totalCustomCashHandlingAmount;
			$result['customOrderId'] 				   = $productList->customOrderId;
			$result['organizationName'] 			   = $productList->organizationName;
			$result['trackingNbr'] 					   = $productList->trackingNbr;
			$result['orderActiveStatus']				= $productList->active;
			$result['orderStatusId']					= $productList->orderStatusId;
			$result['paymentStatus']					= $productList->paymentStatus;
			$orderDetailId = $productList->orderDetailId;
			$dropShipCenterId = $productList->dropShipCenterId;
			$organizationProductId = $productList->organizationProductId;
			$customerId			= $productList->customerId;
			$shippingOrgId		= $productList->shippingOrgId;
			$orderTotalId		= $productList->orderTotalId;
			
			if($orderDetailId)
			{
				$trackDetails = $this->CI->order_m->custom_track_order_time($orderDetailId);
				
				if(!empty($trackDetails))
				{
					foreach($trackDetails as $row)
					{
						if($row->orderStatusId==1)
						{
							$result['newOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==2)
						{
							$result['confirmOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==3)
						{
							$result['readyToShippedOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==4)
						{
							$result['inTransitOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==5)
						{
							$result['deliveredOrderTime'] = $row->createDt;
						}
					}
				}
			}
			
			if($dropShipCenterId)
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($dropShipCenterId);
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			if($organizationProductId)
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				if(!empty($retailerDetails))
				{
					$result['retailerOrganizationName'] = $retailerDetails->organizationName;
					$result['retailerEmail'] 		   = $retailerDetails->email;
					$result['retailerFirstName'] 	   = $retailerDetails->firstName;
					$result['retailerMiddle'] 		   = $retailerDetails->middle;
					$result['retailerLastName'] 		   = $retailerDetails->lastName;
					$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
					$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
					$result['retailerUserName'] 		   = $retailerDetails->userName;
					$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
					$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
					$result['retailerCountryName'] 	   = $retailerDetails->countryName;
					$result['retailerStateName'] 	   = $retailerDetails->stateName;
					$result['retailerCityName'] 		   = $retailerDetails->cityName;
					$result['retailerAreaName']		   = $retailerDetails->areaName;
				}
			}
			
			if($customerId)
			{
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
				if(!empty($customerDetails))
				{
					$result['customerFirstName'] = $customerDetails->firstName;
					$result['customerLastName']	 = $customerDetails->lastName;
					$result['customerPhone']	 = $customerDetails->phone;	
					$result['customerEmail']	 = $customerDetails->email;
				}
			}
			
			if($shippingOrgId)
			{
				$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($shippingOrgId);
				if(!empty($shipperDetails))
				{
					$result['vendorBusinessName'] 	  = $shipperDetails->organizationName;
					$result['vendorFirstName'] 		  = $shipperDetails->firstName;
					$result['vendorLastName'] 		  = $shipperDetails->lastName;
					$result['vendorEmail'] 			  = $shipperDetails->email;
					$result['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
					$result['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
					$result['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
					$result['vendorCountryName'] 	  = $shipperDetails->countryName;
					$result['vendorStateName'] 		  = $shipperDetails->stateName;
					$result['vendorCityName'] 		  = $shipperDetails->cityName;
					$result['vendorAreaName'] 		  = $shipperDetails->areaName;
				}
			}
			
			if($orderTotalId)
			{
				$billingDetails  = $this->CI->order_m->order_billing_address_detail($orderTotalId);
				if(!empty($billingDetails))
				{
					$result['customerBillFirstName'] = $billingDetails->firstName;
					$result['customerBillLastName']  = $billingDetails->lastName;
					$result['customerBillPhone']     = $billingDetails->phone;
					
					if(empty($billingDetails->firstName))
					{				
						$result['customerBillFirstName'] = $result['customerFirstName'];
					}
					if(empty($billingDetails->lastName))
					{
						$result['customerBillLastName'] = $result['customerLastName'];
					}
					if(empty($billingDetails->phone))
					{
						$result['customerBillPhone'] = $result['customerPhone'];
					}
					
					$result['billingCountry']        = $billingDetails->countryName;
					$result['billingState']    	    = $billingDetails->stateName;
					$result['billingArea']   	    = $billingDetails->areaName;
					$result['billingCity']     	    = $billingDetails->cityName;
					$result['billingAddressLine1']   = $billingDetails->addressLine1;
					$result['billingAddressLine2']   = $billingDetails->address_Line2;
				}
				
				$shippingDetails = $this->CI->order_m->order_shipping_address_detail($orderTotalId);
				if(!empty($shippingDetails))
				{
					$result['customerShippFirstName'] = $shippingDetails->firstName;
					$result['customerShippLastName']	 = $shippingDetails->lastName;
					$result['customerShippPhone']	 = $shippingDetails->phone;	
					$result['shippingCountry']      = $shippingDetails->countryName;
					$result['shippingState']    	   = $shippingDetails->stateName;
					$result['shippingArea'] 	       = $shippingDetails->areaName;
					$result['shippingCity']     	   = $shippingDetails->cityName;
					$result['shippingAddressLine1'] = $shippingDetails->addressLine1;
					$result['shippingAddressLine2'] = $shippingDetails->address_Line2;
				}
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function quick_shippment_cancel_order($orderDetailId)
	{
		$getDetails = $this->CI->order_m->quick_shippment_order_list($orderDetailId);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		//echo "<pre>"; print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			if($this->CI->order_m->cancel_order_details($orderDetailId))
			{
				$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
				$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
				
				$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
				$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
				
				/******Mail for Custmer*******/
				if(!empty($customerDetails))
				{				
					$mailData = array(
									'email'        => $customerDetails->email,
									'cc'	       => '',
									'slug'         => 'order_false_for_customer',
									'customerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
									'subject'  	   => 'Order has been deleted',
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
									'email'      => $retailerDetails->email,
									'cc'	     => '',
									'slug'       => 'order_false_for_retailer',
									'sellerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
									'orderId'	 => $getDetails->customOrderId,
									'subject'  	 => 'Order has been deleted',
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
			
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');	
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function quick_shippment_change_confirm_to_ready_order($orderDetailId)
	{
		$getDetails = $this->CI->order_m->quick_shippment_order_list($orderDetailId);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		//echo "<pre>"; print_r($getDetails); exit;
		
		if(!empty($getDetails))
		{
			$orderTrackId = $this->CI->order_m->add_order_custom_track($orderDetailId,3);
			$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
			if($this->CI->order_m->custom_change_confirm_to_ready($orderDetailId))
			{
				$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
				$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
				
				if(!empty($customerDetails))
				{				
					if(!empty($rateDetails))
					{
						$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
						$estimateDay     = $getDetails->estimateDayDelivery;
						$shippingVendor  = $rateDetails->organizationName;
												
						$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
						$shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
							
						$imagePath = base_url().'img/no_image.jpg';
						if((!empty($getDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$getDetails->imageName)))
						{
							$imageUrl = base_url().'uploads/product/thumb500_500/'.$getDetails->imageName;
						}
						elseif((!empty($getDetails->imageName))&&(file_exists('uploads/product/'.$getDetails->imageName)))
						{
							$imageUrl = base_url().'uploads/product/'.$getDetails->imageName;
						}
						
						$color = '';
						$size  = '';
						
						$dropShipAddress = '';
						$dropshipAddDet = $this->CI->retailer_m->dropship_details($getDetails->dropShipCenterId);
						if(!empty($dropshipAddDet))
						{
							$dropShipAddress = $dropshipAddDet->addressLine1;
						}

						/*******Mail for Customer*****************/
						$mailData = array(
									'email'           => $customerDetails->email,
									'cc'	          => '',
									'slug'            => 'reay_to_shipp_order_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $getDetails->organizationName,
									'imagePath'		  => $imagePath,
									'productName'	  => $getDetails->code,
									'currentPrice'	  => number_format($getDetails->totalProductAmount,2),
									'quantity'		  => $getDetails->quantity,
									'subTotal'		  => number_format(($getDetails->totalProductAmount),2),
									'color'			  => $color,
									'size'			  => $size,
									'totalAmount'	  => number_format(($getDetails->totalProductAmount),2),
									'subject'  		  => 'Your Order Is Ready To Be Shipped',
								);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log','Mail Send Successfully');
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log','Mail Not Send');
						}
					
						/*******Mail for Shipping Vendor*****************/
						$mailData = array(
									'email'           => $rateDetails->email,
									'cc'	          => '',
									'slug'            => 'ready_to_transit_for_shipper',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $getDetails->organizationName,
									'imagePath'		  => $imagePath,
									'productName'	  => $getDetails->code,
									'currentPrice'	  => number_format($getDetails->totalProductAmount,2),
									'quantity'		  => $getDetails->quantity,
									'subTotal'		  => number_format(($getDetails->totalProductAmount),2),
									'color'			  => $color,
									'size'			  => $size,
									'totalAmount'	  => number_format(($getDetails->totalProductAmount),2),
									'subject'  		  => 'An order is ready to be shipped',
									'tracking_no'	  => $getDetails->trackingNbr,
									'custoemerAdd'    => $customerDetails->areaName.','.$customerDetails->cityName,
									'dp_center_name'  => $retailerDetails->dropCenterName,
									'dropShipCenterAddress' => $dropShipAddress,
								);
					
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log','Mail Send Successfully');
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log','Mail Not Send');
						}
						
					
                    	$message = '('.$getDetails->customOrderId.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
                        $response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
						$this->CI->session->set_flashdata('success','Order status changed successfully');
						$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
						$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Customer details not found');
					$this->CI->custom_log->write_log('custom_log','Customer details not found');
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
			}		
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function quick_shippment_change_ready_to_shipped_order($orderDetailId)
	{
		$getDetails = $this->CI->order_m->quick_shippment_order_list($orderDetailId);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		//echo "<pre>"; print_r($getDetails); exit;

		if(!empty($getDetails))
		{
			$orderTrackId = $this->CI->order_m->add_order_custom_track($orderDetailId,4);
			$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
			if($this->CI->order_m->custom_change_ready_to_shipped_in($orderDetailId))
			{
				//	Customer Information
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($getDetails->customerId);

				//	Retailer Infromation
				$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
				
				//	Shipping Vendor Infromation
				$vendorDetails = $this->CI->user_m->shipping_vendor_user_details($getDetails->shippingOrgId);
				$shippRateDet  = $this->CI->user_m->shipping_rate_details($getDetails->shippingRateId,$getDetails->shippingOrgId);
				$deliveredDate =  '';
				$estimateDay     = $getDetails->estimateDayDelivery;
						
				if((!empty($customerDetails))&&(!empty($retailerDetails))&&(!empty($vendorDetails)))
				{
					$customerOrderId = $getDetails->customOrderId;
					if((!empty($getDetails->imageName))&&(file_exists('uploads/product/'.$getDetails->imageName)))
					{
						$imageUrl = base_url().'uploads/product/'.$row->imageName;
					}
					else
					{
						$imageUrl = base_url().'img/no_image.jpg';
					}
								
					$shippingAddress = '';
					$shippingDetails = $this->CI->user_m->user_shipping_details($getDetails->customerId);
					//	echo "<pre>";	print_r($shippingDetails); exit;
					if(!empty($shippingDetails))
					{
						$shippingAddress = ucwords($shippingDetails->firstName.' '.$shippingDetails->lastName).' ,'.$shippingDetails->phone.', '.$shippingDetails->addressLine1.' '.$shippingDetails->address_Line2.' ,'.$shippingDetails->cityName.' '.$shippingDetails->stateName.' '.$shippingDetails->countryName;
					}
						
					$shippRateDetails = $this->CI->user_m->shipping_vendor_rateDetails($getDetails->shippingRateId);
					$totalAmt = ($shippRateDetails->amount*$getDetails->quantity)+($retailerDetails->currentPrice*$getDetails->quantity);
					$mailData = array(
									'email'           => $customerDetails->email,
									'cc'	          => '',
									'slug'            => 'shipped_in_transit_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => '',
									'shippingAddName' => $shippingAddress,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerDetails->organizationName,
									'productImage'	  => $imageUrl,
									'productName'	  => $retailerDetails->code,
									'productPrice'	  => number_format($retailerDetails->currentPrice,2),
									'currentPrice'    => number_format($retailerDetails->currentPrice,2),
									'quantity'		  => $getDetails->quantity,
									'totalAmount'	  => number_format($retailerDetails->currentPrice*$getDetails->quantity,2),
									'subTotal'	  => number_format($retailerDetails->currentPrice*$getDetails->quantity,2),
									'subject'  		  => 'Your Order has been Shipped in transit',
									'size' => '',
									'color' => '',
									);	
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
						
					$message = $retailerDetails->code.' was shipped at '.date('d F Y , H:i A',strtotime($getDetails->lastModifiedDt)).' and will be delivered by '.$deliveredDate.'. Tracking no for this shipment is '.$getDetails->trackingNbr.'. For any queries kindly feel free to call us at '.$this->CI->config->item('admin_phone_no').' or email us at '.$this->CI->config->item('admin_email');
					$response = $this->CI->twillo_m->send_mobile_message($customerDetails->phone,$message);
					$this->CI->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
				
				}
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_ready_to_shipped_to_transit'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_ready_to_shipped_to_transit'));
			
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order status not change');
				$this->CI->custom_log->write_log('custom_log','Order status not change');
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function quick_shippment_change_shipped_to_delivered_order($orderDetailId)
	{
		$getDetails = $this->CI->order_m->quick_shippment_order_list($orderDetailId);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		//echo "<pre>"; print_r($getDetails); exit;

		if(!empty($getDetails))
		{
			$orderTrackId = $this->CI->order_m->add_order_custom_track($orderDetailId,5);
			$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
			if($this->CI->order_m->custom_change_shipped_to_delivered($orderDetailId))
			{
				$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
				$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
				
				if(!empty($customerDetails))
				{
					if(!empty($rateDetails))
					{
						$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
						$estimateDay     = $getDetails->ETA+$this->CI->config->item('estimated_time_increase');
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
						$size = '';
						/****Mail for customer*******/
						$mailData = array(
									'email'           => $customerDetails->email,
									'cc'	          => '',
									'slug'            => 'delivered_order_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerDetails->organizationName,
									'imagePath'		  => $imagePath,
									'productName'	  => $retailerDetails->productCodeOveride,
									'currentPrice'	  => number_format($getDetails->totalCustomAmount,2),
									'quantity'		  => $getDetails->quantity,
									'subTotal'		  => number_format(($getDetails->totalCustomAmount),2),
									'color'			  => $color,
									'size'			  => $size,
									'totalAmount'	  => number_format(($getDetails->totalCustomAmount),2),
									'subject'  		  => 'Your Order Has Been Delivered',
								);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
						/****Mail for retailer*******/
						$mailData = array(
									'email'           => $rateDetails->email,
									'cc'	          => '',
									'slug'            => 'delivered_order_for_retailer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerDetails->organizationName,
									'imagePath'		  => $imagePath,
									'productName'	  => $retailerDetails->productCodeOveride,
									'currentPrice'	  => number_format($getDetails->totalCustomAmount,2),
									'quantity'		  => $getDetails->quantity,
									'subTotal'		  => number_format(($getDetails->totalCustomAmount),2),
									'color'			  => $color,
									'size'			  => $size,
									'totalAmount'	  => number_format(($getDetails->totalCustomAmount),2),
									'subject'  		  => 'Your Order Has Been Delivered',
								);
								
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
					/****Mail for Shipping Vendor*******/
					$mailData = array(
									'email'           => $rateDetails->email,
									'cc'	          => '',
									'slug'            => 'delivered_order_for_shipper',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerDetails->organizationName,
									'imagePath'		  => $imagePath,
									'productName'	  => $retailerDetails->productCodeOveride,
									'currentPrice'	  => number_format($getDetails->totalCustomAmount,2),
									'quantity'		  => $getDetails->quantity,
									'subTotal'		  => number_format(($getDetails->totalCustomAmount),2),
									'color'			  => $color,
									'size'			  => $size,
									'totalAmount'	  => number_format(($getDetails->totalCustomAmount),2),
									'subject'  		  => 'Your Order Has Been Delivered',
									'custoemerCity'    => $customerDetails->cityName,
								);
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
					
					
                   	$message = 'Thank you for your delivery confirmation of order # '.$getDetails->customOrderId.' to '.$customerDetails->cityName.'.';
					$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
					$retailer_message = substr($retailerDetails->code,0,20).' has been delivered to Customer.';
					$response = $this->CI->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
                       $customer_message = substr($retailerDetails->code,0,20).', order # '.$getDetails->customOrderId.' has been delivered. Thank you for shopping at PointeMart.';
					$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);

                    $this->CI->session->set_flashdata('success','Order status changed successfully');
					$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
						
				}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Customer details not found');
				}
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_transit_to_delivered'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_transit_to_delivered'));
		}	
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');	
	}
	
	public function quick_shippment_print_invoice($orderDetailId)
	{
		$result 					       	= array();
		$result['customerOrderId']      	= '';
		
		$result['newOrderTime']             = '';
		$result['confirmOrderTime']         = '';
		$result['readyToShippedOrderTime']  = '';
		$result['inTransitOrderTime']       = '';
		$result['deliveredOrderTime']       = '';
		
		$result['trackingNbr']     		    = '';
		
		$result['productList']   		    = '';
		$dropShipCenterId 					= 0; 
		$organizationProductId				= 0;
		$customerId							= 0;
		$shippingOrgId						= 0;
		$orderTotalId						= 0;	
		$result['orderActiveStatus']		= 0;
		
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
			
		$productList = $this->CI->order_m->quick_shippment_order_list($orderDetailId);
		
		if(!empty($productList))
		{
			$orderStatusId = $productList->orderStatusId;
			$result['productId'] 	 = $productList->productId;
			$result['productName'] 	 = $productList->code;
			$result['quantity'] 	 = $productList->quantity;
			$result['orderStatusId'] = $productList->orderStatusId;
			$result['colorCode'] 	 = $productList->colorCode;
			$result['size'] 		 = $productList->sizes;
			$result['imageName'] 	 = $productList->imageName;
			$result['totalProductAmount'] = $productList->totalProductAmount;
			$result['totalRetailerAmount'] = $productList->totalRetailerAmount;
			$result['orderDetailId'] 	  = $productList->orderDetailId;
			$result['totalCustomAmount'] 			   = $productList->totalCustomAmount;
			$result['totalCustomShippingAmount'] 	   = $productList->totalCustomShippingAmount;
			$result['totalCustomCashHandlingAmount']   = $productList->totalCustomCashHandlingAmount;
			$result['customOrderId'] 				   = $productList->customOrderId;
			$result['organizationName'] 			   = $productList->organizationName;
			$result['trackingNbr'] 					   = $productList->trackingNbr;
			$result['orderActiveStatus']				= $productList->active;
			$result['orderStatusId']					= $productList->orderStatusId;
			$result['paymentStatus']					= $productList->paymentStatus;
			$orderDetailId = $productList->orderDetailId;
			$dropShipCenterId = $productList->dropShipCenterId;
			$organizationProductId = $productList->organizationProductId;
			$customerId			= $productList->customerId;
			$shippingOrgId		= $productList->shippingOrgId;
			$orderTotalId		= $productList->orderTotalId;
			
			if($orderDetailId)
			{
				$trackDetails = $this->CI->order_m->custom_track_order_time($orderDetailId);
				
				if(!empty($trackDetails))
				{
					foreach($trackDetails as $row)
					{
						if($row->orderStatusId==1)
						{
							$result['newOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==2)
						{
							$result['confirmOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==3)
						{
							$result['readyToShippedOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==4)
						{
							$result['inTransitOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==5)
						{
							$result['deliveredOrderTime'] = $row->createDt;
						}
					}
				}
			}
			
			if($dropShipCenterId)
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($dropShipCenterId);
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			if($organizationProductId)
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				if(!empty($retailerDetails))
				{
					$result['retailerOrganizationName'] = $retailerDetails->organizationName;
					$result['retailerEmail'] 		   = $retailerDetails->email;
					$result['retailerFirstName'] 	   = $retailerDetails->firstName;
					$result['retailerMiddle'] 		   = $retailerDetails->middle;
					$result['retailerLastName'] 		   = $retailerDetails->lastName;
					$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
					$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
					$result['retailerUserName'] 		   = $retailerDetails->userName;
					$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
					$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
					$result['retailerCountryName'] 	   = $retailerDetails->countryName;
					$result['retailerStateName'] 	   = $retailerDetails->stateName;
					$result['retailerCityName'] 		   = $retailerDetails->cityName;
					$result['retailerAreaName']		   = $retailerDetails->areaName;
				}
			}
			
			if($customerId)
			{
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
				if(!empty($customerDetails))
				{
					$result['customerFirstName'] = $customerDetails->firstName;
					$result['customerLastName']	 = $customerDetails->lastName;
					$result['customerPhone']	 = $customerDetails->phone;	
					$result['customerEmail']	 = $customerDetails->email;
				}
			}
			
			if($shippingOrgId)
			{
				$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($shippingOrgId);
				if(!empty($shipperDetails))
				{
					$result['vendorBusinessName'] 	  = $shipperDetails->organizationName;
					$result['vendorFirstName'] 		  = $shipperDetails->firstName;
					$result['vendorLastName'] 		  = $shipperDetails->lastName;
					$result['vendorEmail'] 			  = $shipperDetails->email;
					$result['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
					$result['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
					$result['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
					$result['vendorCountryName'] 	  = $shipperDetails->countryName;
					$result['vendorStateName'] 		  = $shipperDetails->stateName;
					$result['vendorCityName'] 		  = $shipperDetails->cityName;
					$result['vendorAreaName'] 		  = $shipperDetails->areaName;
				}
			}
			
			if($orderTotalId)
			{
				$billingDetails  = $this->CI->order_m->order_billing_address_detail($orderTotalId);
				if(!empty($billingDetails))
				{
					$result['customerBillFirstName'] = $billingDetails->firstName;
					$result['customerBillLastName']  = $billingDetails->lastName;
					$result['customerBillPhone']     = $billingDetails->phone;
					
					if(empty($billingDetails->firstName))
					{				
						$result['customerBillFirstName'] = $result['customerFirstName'];
					}
					if(empty($billingDetails->lastName))
					{
						$result['customerBillLastName'] = $result['customerLastName'];
					}
					if(empty($billingDetails->phone))
					{
						$result['customerBillPhone'] = $result['customerPhone'];
					}
					
					$result['billingCountry']        = $billingDetails->countryName;
					$result['billingState']    	    = $billingDetails->stateName;
					$result['billingArea']   	    = $billingDetails->areaName;
					$result['billingCity']     	    = $billingDetails->cityName;
					$result['billingAddressLine1']   = $billingDetails->addressLine1;
					$result['billingAddressLine2']   = $billingDetails->address_Line2;
				}
				
				$shippingDetails = $this->CI->order_m->order_shipping_address_detail($orderTotalId);
				if(!empty($shippingDetails))
				{
					$result['customerShippFirstName'] = $shippingDetails->firstName;
					$result['customerShippLastName']	 = $shippingDetails->lastName;
					$result['customerShippPhone']	 = $shippingDetails->phone;	
					$result['shippingCountry']      = $shippingDetails->countryName;
					$result['shippingState']    	   = $shippingDetails->stateName;
					$result['shippingArea'] 	       = $shippingDetails->areaName;
					$result['shippingCity']     	   = $shippingDetails->cityName;
					$result['shippingAddressLine1'] = $shippingDetails->addressLine1;
					$result['shippingAddressLine2'] = $shippingDetails->address_Line2;
				}
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function pickup_order_view($orderDetailId)
	{
		$result 					       	= array();
		$result['customerOrderId']      	= '';
		
		$result['newOrderTime']             = '';
		$result['confirmOrderTime']         = '';
		$result['readyToShippedOrderTime']  = '';
		$result['inTransitOrderTime']       = '';
		$result['deliveredOrderTime']       = '';
		
		$result['trackingNbr']     		    = '';
		
		$result['productList']   		    = '';
		
		$dropShipCenterId 					= 0; 
		$organizationProductId				= 0;
		$customerId							= 0;
		$shippingOrgId						= 0;
		$orderTotalId						= 0;	
		$result['orderActiveStatus']		= 0;
		
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
		
		$result['pickupName']        	   = '';
		$result['pickupBusDays']            = '';
		$result['pickupBusHours']           = '';
		$result['pickupAddressLine']        = '';
		$result['pickupPhone']              = '';
		$result['pickupStateName']          = '';
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->CI->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->CI->form_validation->run())
	    	{
				if($this->CI->order_m->quick_shippment_save_tracking_number($orderDetailId,$result['trackingNbr']))
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_save_track_no'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_save_track_no'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_save_track_no'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_save_track_no'));
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/orders_management/pickup_order_view/'.id_encrypt($orderDetailId));	
			}
		}
		
		$productList = $this->CI->order_m->pickup_order_list($orderDetailId);
		//echo "<pre>"; print_r($productList); exit;
		if(!empty($productList))
		{
			$orderStatusId 			 = $productList->orderStatusId;
			$result['productId'] 	 = $productList->productId;
			$result['productName'] 	 = $productList->code;
			$result['quantity'] 	 = $productList->quantity;
			$result['orderStatusId'] = $productList->orderStatusId;
			$result['colorCode'] 	 = $productList->colorCode;
			$result['size'] 		 = $productList->sizes;
			$result['imageName'] 	 = $productList->imageName;
			$result['totalProductAmount'] = $productList->totalProductAmount;
			$result['totalRetailerAmount'] = $productList->totalRetailerAmount;
			$result['orderDetailId'] 	  = $productList->orderDetailId;
			$result['totalCustomAmount'] 			   = $productList->totalCustomAmount;
			$result['totalCustomShippingAmount'] 	   = $productList->totalCustomShippingAmount;
			$result['totalCustomCashHandlingAmount']   = $productList->totalCustomCashHandlingAmount;
			$result['customOrderId'] 				   = $productList->customOrderId;
			$result['organizationName'] 			   = $productList->organizationName;
			$result['trackingNbr'] 					   = $productList->trackingNbr;
			$result['orderActiveStatus']			   = $productList->active;
			$result['orderStatusId']				   = $productList->orderStatusId;
			$result['paymentStatus']				   = $productList->paymentStatus;
			$orderDetailId = $productList->orderDetailId;
			$dropShipCenterId = $productList->dropShipCenterId;
			$organizationProductId = $productList->organizationProductId;
			$customerId			= $productList->customerId;
			$shippingOrgId		= $productList->shippingOrgId;
			$orderTotalId		= $productList->orderTotalId;
			$pickupId			= $productList->pickupId;
			
			if($orderDetailId)
			{
				$trackDetails = $this->CI->order_m->custom_track_order_time($orderDetailId);
				
				if(!empty($trackDetails))
				{
					foreach($trackDetails as $row)
					{
						if($row->orderStatusId==1)
						{
							$result['newOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==2)
						{
							$result['confirmOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==3)
						{
							$result['readyToShippedOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==4)
						{
							$result['inTransitOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==5)
						{
							$result['deliveredOrderTime'] = $row->createDt;
						}
					}
				}
			}
			
			if($dropShipCenterId)
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($dropShipCenterId);
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			if($organizationProductId)
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				if(!empty($retailerDetails))
				{
					$result['retailerOrganizationName'] = $retailerDetails->organizationName;
					$result['retailerEmail'] 		   = $retailerDetails->email;
					$result['retailerFirstName'] 	   = $retailerDetails->firstName;
					$result['retailerMiddle'] 		   = $retailerDetails->middle;
					$result['retailerLastName'] 		   = $retailerDetails->lastName;
					$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
					$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
					$result['retailerUserName'] 		   = $retailerDetails->userName;
					$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
					$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
					$result['retailerCountryName'] 	   = $retailerDetails->countryName;
					$result['retailerStateName'] 	   = $retailerDetails->stateName;
					$result['retailerCityName'] 		   = $retailerDetails->cityName;
					$result['retailerAreaName']		   = $retailerDetails->areaName;
				}
			}
			
			if($customerId)
			{
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
				if(!empty($customerDetails))
				{
					$result['customerFirstName'] = $customerDetails->firstName;
					$result['customerLastName']	 = $customerDetails->lastName;
					$result['customerPhone']	 = $customerDetails->phone;	
					$result['customerEmail']	 = $customerDetails->email;
				}
			}
			
			if($pickupId)
			{
				$pickupDet = $this->CI->cart_m->pickup_details($pickupId);
				if(!empty($pickupDet))
				{
					$result['pickupName']        = $pickupDet->pickupName;
					$result['pickupBusDays']     = $pickupDet->businessDays;
					$result['pickupBusHours']    = $pickupDet->businessHours;
					$result['pickupAddressLine'] = $pickupDet->addressLine1;
					$result['pickupPhone']       = $pickupDet->phone;
					$result['pickupStateName']   = $pickupDet->stateName;            
				}
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function pickup_cancel_order($orderDetailId)
	{
		$getDetails = $this->CI->order_m->pickup_order_list($orderDetailId);
		//echo "<pre>"; print_r($getDetails); exit;
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		
		if(!empty($getDetails))
		{
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
			$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
			
			$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
			$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
			
			/******Mail for Custmer*******/
			if(!empty($customerDetails))
			{				
				$mailData = array(
								'email'        => $customerDetails->email,
								'cc'	       => '',
								'slug'         => 'order_false_for_customer',
								'customerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
								'subject'  	   => 'Order has been deleted',
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
			if((!empty($retailerDetails))&&(!empty($retailerDetails->email)))
			{
				$mailData = array(
								'email'      => $retailerDetails->email,
								'cc'	     => '',
								'slug'       => 'order_false_for_retailer',
								'sellerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
								'orderId'	 => $getDetails->customOrderId,
								'subject'  	 => 'Order has been deleted',
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
			
			if($this->CI->order_m->cancel_order_details($orderDetailId))
			{
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');	
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
			$this->CI->custom_log->write_log('custom_log','last querty is '.$this->CI->db->last_query());
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function pickup_change_confirm_to_ready_order($orderDetailId)
	{
		$getDetails = $this->CI->order_m->pickup_order_list($orderDetailId);
		//echo "<pre>"; print_r($getDetails); exit;
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 
		
		if(!empty($getDetails))
		{
			$orderTrackId = $this->CI->order_m->add_order_custom_track($orderDetailId,3);
			$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
			if($this->CI->order_m->custom_change_confirm_to_ready($orderDetailId))
			{
				$customerDetails = $this->CI->customer_m->customer_details($getDetails->customerId);
				$this->CI->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));
				if(!empty($customerDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
					$this->CI->custom_log->write_log('custom_log','retailer details is '.print_r($retailerDetails,true));
					
					$imagePath = base_url().'img/no_image.jpg';
					$color = '';
					$size  = '';
					if((!empty($getDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$getDetails->imageName)))
					{
						$imageUrl = base_url().'uploads/product/thumb500_500/'.$getDetails->imageName;
					}
					elseif((!empty($getDetails->imageName))&&(file_exists('uploads/product/'.$getDetails->imageName)))
					{
						$imagePath = base_url().'uploads/product/'.$getDetails->imageName;
					}
					$pickupDetails = $this->CI->cart_m->pickup_details($getDetails->pickupId);
					$this->CI->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
					
					$mailData = array(
								'email'           => $customerDetails->email,
								'cc'	          => '',
								'slug'            => 'ready_to_pickup_order_for_customer',
								'name'            => $customerDetails->firstName.' '.$customerDetails->lastName,
								'customerPhone'	  => $customerDetails->phone,
								'orderId'		  => $getDetails->customOrderId,
								'eta'			  => $getDetails->estimateDayDelivery,
								'shippingVendor'  => '',
								'shippingAddName' => '',
								'shippingAddress' => '',
								'retailerName'    => $getDetails->organizationName,
								'imagePath'		  => $imagePath,
								'productName'	  => $getDetails->code,
								'productPrice'	  => number_format($getDetails->totalProductAmount,2),
								'quantity'		  => $getDetails->quantity,
								'totalPrice'	  => number_format(($getDetails->totalProductAmount),2),
								'color'			  => $color,
								'size'			  => $size,
								'totalSumPrice'	  => number_format(($getDetails->totalProductAmount),2),
								'subject'  		  => 'Your Order Is Ready To Be Pickup',
								'pickupCenter'		=> $pickupDetails->pickupName,
								'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
								'pickupPhoneno' => $pickupDetails->phone,
							);
					$this->CI->custom_log->write_log('custom_log','mail data is '.print_r($mailData,true));
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
					
					$customer_message = substr($getDetails->code,0,20).', order # '.$getDetails->customOrderId.',  has been packed, Please collect it from '.$pickupDetails->pickupName;
					$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
					$this->CI->session->set_flashdata('success','Order status changed successfully');
					$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
				}
				else
				{
					$this->CI->session->set_flashdata('error','Customer details not found');
				}
			}	
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
			}	
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function pickup_change_ready_pickup_to_pickup_customer($orderDetailId)
	{
		$getDetails = $this->CI->order_m->pickup_order_list($orderDetailId);
		//echo "<pre>"; print_r($getDetails); exit;
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true));
		
		if(!empty($getDetails))
		{
			$orderTrackId = $this->CI->order_m->add_order_custom_track($orderDetailId,5);
			$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
			if($this->CI->order_m->custom_change_shipped_to_delivered($orderDetailId))
			{
				$customerDetails = $this->CI->customer_m->customer_details($getDetails->customerId);
				$this->CI->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));
				if(!empty($customerDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
					$this->CI->custom_log->write_log('custom_log','retailer details is '.print_r($retailerDetails,true));
					
					$imagePath = base_url().'img/no_image.jpg';
					$color = '';
					$size  = '';
					if((!empty($getDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$getDetails->imageName)))
					{
						$imageUrl = base_url().'uploads/product/thumb500_500/'.$getDetails->imageName;
					}
					elseif((!empty($getDetails->imageName))&&(file_exists('uploads/product/'.$getDetails->imageName)))
					{
						$imagePath = base_url().'uploads/product/'.$getDetails->imageName;
					}
					$pickupDetails = $this->CI->cart_m->pickup_details($getDetails->pickupId);
					$this->CI->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
					
					$mailData = array(
								'email'           => $customerDetails->email,
								'cc'	          => '',
								'slug'            => 'pickup_ready_to_complete_order_for_customer',
								'name'            => $customerDetails->firstName.' '.$customerDetails->lastName,
								'customerPhone'	  => $customerDetails->phone,
								'orderId'		  => $getDetails->customOrderId,
								'eta'			  => $getDetails->estimateDayDelivery,
								'shippingVendor'  => '',
								'shippingAddName' => '',
								'shippingAddress' => '',
								'retailerName'    => $getDetails->organizationName,
								'imagePath'		  => $imagePath,
								'productName'	  => $getDetails->code,
								'productPrice'	  => number_format($getDetails->totalProductAmount,2),
								'quantity'		  => $getDetails->quantity,
								'totalPrice'	  => number_format(($getDetails->totalProductAmount),2),
								'color'			  => $color,
								'size'			  => $size,
								'totalSumPrice'	  => number_format(($getDetails->totalProductAmount),2),
								'subject'  		  => 'Your Order Is In Transit',
								'pickupCenter'		=> $pickupDetails->pickupName,
								'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
								'pickupPhoneno' => $pickupDetails->phone,
								'pickupDate'	=> date('Y-m-d',strtotime('+ '.$getDetails->estimateDayDelivery.' days')),
							);
					$this->CI->custom_log->write_log('custom_log','mail data is '.print_r($mailData,true));
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
					
					$mailData = array(
								'email'           => $retailerDetails->email,
								'cc'	          => '',
								'slug'            => 'pickup_ready_to_complete_order_for_retailer',
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
								'subject'  		  => 'Your Order Is In Transit',
								'pickupCenter'		=> $pickupDetails->pickupName,
								'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
								'pickupDate'	=> date('Y-m-d',strtotime('+ '.$estimateDay.' days')),
							);
				
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log','mail send to retailer');
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
					$retailer_message = 'Your product '.substr($getDetails->code,0,20).' has been delivered to Customer.';
					$response = $this->CI->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
					$customer_message = 'Thank you for collecting your order;  tracking #'.$getDetails->trackingNbr.'  from '.$pickupDetails->pickupName.' Center. Thank you for shopping at PointeMart';
					$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
					$this->CI->session->set_flashdata('success','Order status changed successfully');
					$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
					
				}
				else
				{
					$this->CI->session->set_flashdata('error','Customer details not found');
				}
			}	
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
				$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_ready_to_shipped_to_transit'));
			}	
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/orders_management');
	}
	
	public function pickup_print_lable($orderDetailId)
	{
		$result 					       	= array();
		$result['customerOrderId']      	= '';
		
		$result['newOrderTime']             = '';
		$result['confirmOrderTime']         = '';
		$result['readyToShippedOrderTime']  = '';
		$result['inTransitOrderTime']       = '';
		$result['deliveredOrderTime']       = '';
		
		$result['trackingNbr']     		    = '';
		
		$result['productList']   		    = '';
		
		$dropShipCenterId 					= 0; 
		$organizationProductId				= 0;
		$customerId							= 0;
		$shippingOrgId						= 0;
		$orderTotalId						= 0;	
		$result['orderActiveStatus']		= 0;
		
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
		
		$result['pickupName']        	   = '';
		$result['pickupBusDays']            = '';
		$result['pickupBusHours']           = '';
		$result['pickupAddressLine']        = '';
		$result['pickupPhone']              = '';
		$result['pickupStateName']          = '';
		
		$productList = $this->CI->order_m->pickup_order_list($orderDetailId);
		//echo "<pre>"; print_r($productList); exit;
		if(!empty($productList))
		{
			$orderStatusId 			 = $productList->orderStatusId;
			$result['productId'] 	 = $productList->productId;
			$result['productName'] 	 = $productList->code;
			$result['quantity'] 	 = $productList->quantity;
			$result['orderStatusId'] = $productList->orderStatusId;
			$result['colorCode'] 	 = $productList->colorCode;
			$result['size'] 		 = $productList->sizes;
			$result['imageName'] 	 = $productList->imageName;
			$result['totalProductAmount'] = $productList->totalProductAmount;
			$result['totalRetailerAmount'] = $productList->totalRetailerAmount;
			$result['orderDetailId'] 	  = $productList->orderDetailId;
			$result['totalCustomAmount'] 			   = $productList->totalCustomAmount;
			$result['totalCustomShippingAmount'] 	   = $productList->totalCustomShippingAmount;
			$result['totalCustomCashHandlingAmount']   = $productList->totalCustomCashHandlingAmount;
			$result['customOrderId'] 				   = $productList->customOrderId;
			$result['organizationName'] 			   = $productList->organizationName;
			$result['trackingNbr'] 					   = $productList->trackingNbr;
			$result['orderActiveStatus']			   = $productList->active;
			$result['orderStatusId']				   = $productList->orderStatusId;
			$result['paymentStatus']				   = $productList->paymentStatus;
			$orderDetailId = $productList->orderDetailId;
			$dropShipCenterId = $productList->dropShipCenterId;
			$organizationProductId = $productList->organizationProductId;
			$customerId			= $productList->customerId;
			$shippingOrgId		= $productList->shippingOrgId;
			$orderTotalId		= $productList->orderTotalId;
			$pickupId			= $productList->pickupId;
			
			if($orderDetailId)
			{
				$trackDetails = $this->CI->order_m->custom_track_order_time($orderDetailId);
				
				if(!empty($trackDetails))
				{
					foreach($trackDetails as $row)
					{
						if($row->orderStatusId==1)
						{
							$result['newOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==2)
						{
							$result['confirmOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==3)
						{
							$result['readyToShippedOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==4)
						{
							$result['inTransitOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==5)
						{
							$result['deliveredOrderTime'] = $row->createDt;
						}
					}
				}
			}
			
			if($dropShipCenterId)
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($dropShipCenterId);
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			if($organizationProductId)
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				if(!empty($retailerDetails))
				{
					$result['retailerOrganizationName'] = $retailerDetails->organizationName;
					$result['retailerEmail'] 		   = $retailerDetails->email;
					$result['retailerFirstName'] 	   = $retailerDetails->firstName;
					$result['retailerMiddle'] 		   = $retailerDetails->middle;
					$result['retailerLastName'] 		   = $retailerDetails->lastName;
					$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
					$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
					$result['retailerUserName'] 		   = $retailerDetails->userName;
					$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
					$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
					$result['retailerCountryName'] 	   = $retailerDetails->countryName;
					$result['retailerStateName'] 	   = $retailerDetails->stateName;
					$result['retailerCityName'] 		   = $retailerDetails->cityName;
					$result['retailerAreaName']		   = $retailerDetails->areaName;
				}
			}
			
			if($customerId)
			{
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
				if(!empty($customerDetails))
				{
					$result['customerFirstName'] = $customerDetails->firstName;
					$result['customerLastName']	 = $customerDetails->lastName;
					$result['customerPhone']	 = $customerDetails->phone;	
					$result['customerEmail']	 = $customerDetails->email;
				}
			}
			
			if($pickupId)
			{
				$pickupDet = $this->CI->cart_m->pickup_details($pickupId);
				if(!empty($pickupDet))
				{
					$result['pickupName']        = $pickupDet->pickupName;
					$result['pickupBusDays']     = $pickupDet->businessDays;
					$result['pickupBusHours']    = $pickupDet->businessHours;
					$result['pickupAddressLine'] = $pickupDet->addressLine1;
					$result['pickupPhone']       = $pickupDet->phone;
					$result['pickupStateName']   = $pickupDet->stateName;            
				}
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function pickup_print_invoice($orderDetailId)
	{
		$result 					       	= array();
		$result['customerOrderId']      	= '';
		
		$result['newOrderTime']             = '';
		$result['confirmOrderTime']         = '';
		$result['readyToShippedOrderTime']  = '';
		$result['inTransitOrderTime']       = '';
		$result['deliveredOrderTime']       = '';
		
		$result['trackingNbr']     		    = '';
		
		$result['productList']   		    = '';
		
		$dropShipCenterId 					= 0; 
		$organizationProductId				= 0;
		$customerId							= 0;
		$shippingOrgId						= 0;
		$orderTotalId						= 0;	
		$result['orderActiveStatus']		= 0;
		
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
		
		$result['pickupName']        	   = '';
		$result['pickupBusDays']            = '';
		$result['pickupBusHours']           = '';
		$result['pickupAddressLine']        = '';
		$result['pickupPhone']              = '';
		$result['pickupStateName']          = '';
		
		$productList = $this->CI->order_m->pickup_order_list($orderDetailId);
		//echo "<pre>"; print_r($productList); exit;
		if(!empty($productList))
		{
			$orderStatusId 			 = $productList->orderStatusId;
			$result['productId'] 	 = $productList->productId;
			$result['productName'] 	 = $productList->code;
			$result['quantity'] 	 = $productList->quantity;
			$result['orderStatusId'] = $productList->orderStatusId;
			$result['colorCode'] 	 = $productList->colorCode;
			$result['size'] 		 = $productList->sizes;
			$result['imageName'] 	 = $productList->imageName;
			$result['totalProductAmount'] = $productList->totalProductAmount;
			$result['totalRetailerAmount'] = $productList->totalRetailerAmount;
			$result['orderDetailId'] 	  = $productList->orderDetailId;
			$result['totalCustomAmount'] 			   = $productList->totalCustomAmount;
			$result['totalCustomShippingAmount'] 	   = $productList->totalCustomShippingAmount;
			$result['totalCustomCashHandlingAmount']   = $productList->totalCustomCashHandlingAmount;
			$result['customOrderId'] 				   = $productList->customOrderId;
			$result['organizationName'] 			   = $productList->organizationName;
			$result['trackingNbr'] 					   = $productList->trackingNbr;
			$result['orderActiveStatus']			   = $productList->active;
			$result['orderStatusId']				   = $productList->orderStatusId;
			$result['paymentStatus']				   = $productList->paymentStatus;
			$orderDetailId = $productList->orderDetailId;
			$dropShipCenterId = $productList->dropShipCenterId;
			$organizationProductId = $productList->organizationProductId;
			$customerId			= $productList->customerId;
			$shippingOrgId		= $productList->shippingOrgId;
			$orderTotalId		= $productList->orderTotalId;
			$pickupId			= $productList->pickupId;
			
			if($orderDetailId)
			{
				$trackDetails = $this->CI->order_m->custom_track_order_time($orderDetailId);
				
				if(!empty($trackDetails))
				{
					foreach($trackDetails as $row)
					{
						if($row->orderStatusId==1)
						{
							$result['newOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==2)
						{
							$result['confirmOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==3)
						{
							$result['readyToShippedOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==4)
						{
							$result['inTransitOrderTime'] = $row->createDt;
						}
						elseif($row->orderStatusId==5)
						{
							$result['deliveredOrderTime'] = $row->createDt;
						}
					}
				}
			}
			
			if($dropShipCenterId)
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($dropShipCenterId);
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			if($organizationProductId)
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($organizationProductId);
				if(!empty($retailerDetails))
				{
					$result['retailerOrganizationName'] = $retailerDetails->organizationName;
					$result['retailerEmail'] 		   = $retailerDetails->email;
					$result['retailerFirstName'] 	   = $retailerDetails->firstName;
					$result['retailerMiddle'] 		   = $retailerDetails->middle;
					$result['retailerLastName'] 		   = $retailerDetails->lastName;
					$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
					$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
					$result['retailerUserName'] 		   = $retailerDetails->userName;
					$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
					$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
					$result['retailerCountryName'] 	   = $retailerDetails->countryName;
					$result['retailerStateName'] 	   = $retailerDetails->stateName;
					$result['retailerCityName'] 		   = $retailerDetails->cityName;
					$result['retailerAreaName']		   = $retailerDetails->areaName;
				}
			}
			
			if($customerId)
			{
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
				if(!empty($customerDetails))
				{
					$result['customerFirstName'] = $customerDetails->firstName;
					$result['customerLastName']	 = $customerDetails->lastName;
					$result['customerPhone']	 = $customerDetails->phone;	
					$result['customerEmail']	 = $customerDetails->email;
				}
			}
			
			if($pickupId)
			{
				$pickupDet = $this->CI->cart_m->pickup_details($pickupId);
				if(!empty($pickupDet))
				{
					$result['pickupName']        = $pickupDet->pickupName;
					$result['pickupBusDays']     = $pickupDet->businessDays;
					$result['pickupBusHours']    = $pickupDet->businessHours;
					$result['pickupAddressLine'] = $pickupDet->addressLine1;
					$result['pickupPhone']       = $pickupDet->phone;
					$result['pickupStateName']   = $pickupDet->stateName;            
				}
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function new_order_index()
	{
		$return     = array();
		$where      = '';
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
		
		$return['total'] = $this->CI->order_m->total_new_order_in_shipping_admin($where);	
		return $return;
	}
	
	public function new_order_ajax($total)
	{
		$return 	= array();
		$perPage 	= $this->CI->input->post('sel_no_entry');
		$where 		= '';		
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
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/new_order/new_order_ajax/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = '';		
		$list = $this->CI->order_m->new_order_list_in_shipping_admin($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		//echo "<pre>"; print_r($list); exit;
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$return['list'][$row->orderId]['createDt']         = $row->createDt;
				$return['list'][$row->orderId]['productId']        = $row->productId;
				$return['list'][$row->orderId]['code']             = $row->code;
				$return['list'][$row->orderId]['organizationName'] = $row->organizationName;
				$return['list'][$row->orderId]['ttlChargedAmount'] = $row->quantity*$row->chargedAmount;
				$return['list'][$row->orderId]['orderStatusId']    = $row->orderStatusId;
				$return['list'][$row->orderId]['orderId']          = $row->orderId;
				$return['list'][$row->orderId]['customOrderId']    = $row->customOrderId;
				$return['list'][$row->orderId]['dropCenterName']   = $row->dropCenterName;
				$customerDet = $this->CI->order_m->order_shipping_address_details($row->customerId,$row->orderId);
				if(!empty($customerDet))
				{
					$return['list'][$row->orderId]['customerDet']['name']  = $customerDet->firstName.' '.$customerDet->lastName;
					$return['list'][$row->orderId]['customerDet']['phone']     = $customerDet->phone;
					$return['list'][$row->orderId]['customerDet']['stateName'] = $customerDet->stateName;
					$return['list'][$row->orderId]['customerDet']['areaName']  = $customerDet->areaName;
					$return['list'][$row->orderId]['customerDet']['cityName']  = $customerDet->cityName;
				}
				
				
			}
		}
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
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
		
		$return['total'] = $this->CI->order_m->total_confirmation_order($where);	
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
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/confirm_order/confirmationOrderAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_m->confirmation_order_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
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
		$return['total'] = $this->CI->order_m->total_ready_to_be_shipped_order($where);	
		return $return;
	}
	
	public function ready_to_shipped_order_ajax($total)
	{
		$return  = array();
		$perPage = $this->CI->input->post('sel_no_entry');
		$where   = '';
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
		
		$return['list']  = $this->CI->order_m->ready_shipped_order_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function shipped_in_transit_order_index()
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
		
		$return['total'] = $this->CI->order_m->total_shipped_in_transit_order($where);	
		return $return;
	}
	
	public function shipped_in_transit_order_ajax($total)
	{
		$return  = array();
		$perPage = $this->CI->input->post('sel_no_entry');
		$where   = '';
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
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/shipped_in_transit/transitAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_m->shipped_in_transit_order_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
		
	public function delivered_order_index()
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
		
		$return['total'] = $this->CI->order_m->total_delivered_order($where);	
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
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/delivered_order/deliveredAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_m->delivered_order_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
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
		
		$return['total'] = $this->CI->order_m->total_history_order($where);	
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
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/history_order/historyAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_m->history_order_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function order_view($orderID,$status)
	{
		$returnArr 					       	   = array();
		$returnArr['orderID']				   = $orderID;
		$returnArr['customerFirstName']	   	   = '';
		$returnArr['customerMiddle']	   	   = '';
		$returnArr['customerLastName']	   	   = '';
		$returnArr['customerPhone']	   	   	   = '';
		$returnArr['customerEmail']	   	   	   = '';
		$returnArr['billingCountry']       	   = '';
		$returnArr['billingState']    	   	   = '';
		$returnArr['billingCity']     	   	   = '';
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
		
		$returnArr['newOrderTime']             = '';
		$returnArr['confirmOrderTime']         = '';
		$returnArr['readyToShippedOrderTime']  = '';
		$returnArr['inTransitOrderTime']       = '';
		$returnArr['deliveredOrderTime']       = '';	
		
		$returnArr['customerShippFirstName']   = '';
		$returnArr['customerShippLastName']	   = '';
		$returnArr['customerShippPhone']	   = '';	
		$returnArr['customerBillFirstName']    = '';
		$returnArr['customerBillLastName']	   = '';
		$returnArr['customerBillPhone'] 	   = '';	
		$returnArr['phoneCode']				   = '+234';
		$returnArr['chargedAmount']			   = '';
		$returnArr['paymentStatus']			   = '';	
		$returnArr['retailerPrice']			   = 0;
		$returnArr['cashHandlingPrice']		   = 0;		
		$returnArr['freeShipCatId']			   = 0;
		$returnArr['freeShipPrdId']			   = 0;
		$returnArr['cashAdminFee']			   = 0;
		$returnArr['genuineShippFee']		   = 0;
		
		$billingDetails 					   = '';
		$shippingDetails 					   = '';
		
		//	New order
		if($status==1)
		{
			$orderDetails = $this->CI->order_m->new_order_details($orderID);
		}	//	Confirmation order
		elseif($status==2)
		{
			$orderDetails = $this->CI->order_m->confirmation_order_details($orderID);
			
		}	//	Ready to be shipped
		elseif($status==3)
		{
			$orderDetails = $this->CI->order_m->ready_shipped_order_details($orderID);
		}	//	Shipped in transit
		elseif($status==4)
		{
			$orderDetails = $this->CI->order_m->transit_order_details($orderID);
		}	//	Deliverd
		elseif($status==5)
		{
			$orderDetails = $this->CI->order_m->delivered_order_details($orderID);
		}	// History
		elseif($status==6)
		{
			$orderDetails = $this->CI->order_m->history_order_details($orderID);
		}	
		elseif($status==7)
		{
			$orderDetails = $this->CI->order_m->delivered_order_details($orderID);
		}			
		
		//echo "<pre>"; print_r($orderDetails); exit;
		if(!empty($orderDetails))
		{
			$billingDetails  = $this->CI->order_m->order_billing_address_details($orderDetails->customerId,$orderDetails->orderId);
			$shippingDetails = $this->CI->order_m->order_shipping_address_details($orderDetails->customerId,$orderDetails->orderId);
			if(empty($billingDetails))
			{
				$billingDetails = $this->CI->customer_m->user_profile_details($orderDetails->customerId);				
			}
			
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
			$returnArr['customerOrderId']   = $orderDetails->customOrderId;
			$returnArr['orderDate']         = $orderDetails->createDt;
			$returnArr['trackingNbr']       = $orderDetails->trackingNbr;
			$returnArr['deliveredDate']     = $orderDetails->deliveredDate;
			$returnArr['productQuantity']   = $orderDetails->quantity;
			$returnArr['lastModifiedDate']  = $orderDetails->orderLastModfiedDt;
			$returnArr['color']			    = $orderDetails->colorCode;
			$returnArr['size'] 			    = $orderDetails->size;
			$returnArr['totalAmount']       = $orderDetails->totalAmount;
			$returnArr['chargedAmount']	    = $orderDetails->chargedAmount;
			$returnArr['paymentStatus']	    = $orderDetails->paymentStatus;
			$returnArr['retailerPrice']     = $orderDetails->retailerPrice;
			$returnArr['cashHandlingPrice'] = $orderDetails->cashHandlingPrice;
			$returnArr['freeShipCatId']		= $orderDetails->freeShipCatId;
			$returnArr['freeShipPrdId']		= $orderDetails->freeShipPrdId;
			$returnArr['cashAdminFee']		= $orderDetails->cashAdminFee;
			$returnArr['genuineShippFee']	= $orderDetails->genuineShippFee;
			
			if((!empty($orderDetails->marketingProductId))&&($orderDetails->marketingProductId))
			{
				$returnArr['retailerPrice'] = $returnArr['retailerPrice']-$orderDetails->retailerDiscount;	
			}
			
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($orderDetails->customerId);
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
				$returnArr['productPrice'] 	   = $productDetails->currentPrice;
				$returnArr['productImageName'] = $productDetails->imageName;				
			}
			
			$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($orderDetails->shippingOrgId);
			//echo "<pre>";	print_r($shipperDetails); exit;
			if(!empty($shipperDetails))
			{
				$returnArr['vendorBusinessName'] = $shipperDetails->organizationName;
				$returnArr['vendorFirstName'] = $shipperDetails->firstName;
				$returnArr['vendorLastName'] = $shipperDetails->lastName;
				$returnArr['vendorEmail'] = $shipperDetails->email;
				$returnArr['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
				$returnArr['vendorBusinessPhone'] = $shipperDetails->businessPhone;
				$returnArr['vendorAddressLine1'] = $shipperDetails->addressLine1;
				$returnArr['vendorCountryName'] = $shipperDetails->countryName;
				$returnArr['vendorStateName'] = $shipperDetails->stateName;
				$returnArr['vendorCityName'] = $shipperDetails->cityName;
				$returnArr['vendorAreaName'] = $shipperDetails->areaName;
				
				$shippRateDet = $this->CI->order_m->shipping_rate_details($orderDetails->shippingOrgId,$orderDetails->shippingRateId);
				if(!empty($shippRateDet))
				{
					$returnArr['shippingRate'] = $shippRateDet->amount;
					if((!empty($orderDetails->productWeight))&&($orderDetails->productWeight>10))
					{
						$returnArr['shippingRate'] = $shippRateDet->amount*$orderDetails->productWeight;
					}					
				}
			}
		}
		
		if(!empty($billingDetails))
		{
			$returnArr['customerBillFirstName'] = $billingDetails->firstName;
			$returnArr['customerBillLastName']  = $billingDetails->lastName;
			$returnArr['customerBillPhone']     = $billingDetails->phone;
			
			if(empty($billingDetails->firstName))
			{				
				$returnArr['customerBillFirstName'] = $returnArr['customerFirstName'];
			}
			if(empty($billingDetails->lastName))
			{
				$returnArr['customerBillLastName'] = $returnArr['customerLastName'];
			}
			if(empty($billingDetails->phone))
			{
				$returnArr['customerBillPhone'] = $returnArr['customerPhone'];
			}
			
			$returnArr['billingCountry']        = $billingDetails->countryName;
			$returnArr['billingState']    	    = $billingDetails->stateName;
			$returnArr['billingCity']     	    = $billingDetails->cityName;
			$returnArr['billingAddressLine1']   = $billingDetails->addressLine1;
			$returnArr['billingAddressLine2']   = $billingDetails->address_Line2;
			$returnArr['billingZip']            = $billingDetails->zip;
		}
		
		if(!empty($shippingDetails))
		{
			$returnArr['shippingCountry']      = $shippingDetails->countryName;
			$returnArr['shippingState']    	   = $shippingDetails->stateName;
			$returnArr['shippingArea'] 	       = $shippingDetails->areaName;
			$returnArr['shippingCity']     	   = $shippingDetails->cityName;
			$returnArr['shippingAddressLine1'] = $shippingDetails->addressLine1;
			$returnArr['shippingAddressLine2'] = $shippingDetails->address_Line2;
			$returnArr['shippingZip']          = $shippingDetails->zip;
		}
		//echo "<pre>"; print_r($returnArr); exit;
		return $returnArr;
	}
	
	public function order_tracking_list()
	{
		$customerId = $this->CI->session->userdata('userId');
		$orderDet   = $this->CI->order_m->user_order_list($customerId);	
		//echo "<pre>"; print_r($orderDet); exit;
		$totalFullSum = 0;
		$totalCommiArr = array();
		if(!empty($orderDet))
		{
			$i = 0;
			foreach($orderDet as $row)
			{
				$shippingBusinessName = '';
				$retailerBusinessName = '';
				$eta				  = 0;
				$shipperDetails = $this->CI->user_m->shipping_vendor_user_details($row->shippingOrgId);
				if(!empty($shipperDetails))
				{
					$shippingBusinessName = $shipperDetails->organizationName;
				}
				$retailerDetails = $this->CI->order_m->order_retailer_details($row->organizationProductId);
				if(!empty($retailerDetails))
				{
					if($retailerDetails->organizationName)
					{
						$retailerBusinessName = $retailerDetails->organizationName;
					}
					else
					{
						$retailerBusinessName = $retailerDetails->firstName.' '.$retailerDetails->lastName;
					}
				}
				
				$shippRateAmt = 0;
				$shipRateDetails = $this->CI->user_m->shipping_rate_details($row->shippingRateId,$row->shippingOrgId);
				//echo "<pre>"; print_r($shipRateDetails); exit;
				$return['customOrderId'][$row->customOrderId][$i]['shippingRate'] = 0;
				if(!empty($shipRateDetails))
				{
					$eta = $shipRateDetails->ETA;
					$return['customOrderId'][$row->customOrderId][$i]['shippingRate'] = $shipRateDetails->amount;
				}

				$return['customOrderId'][$row->customOrderId][$i]['orderId'] 		 	 = $row->orderId;
				$return['customOrderId'][$row->customOrderId][$i]['chargedAmount'] 		 	 = $row->chargedAmount;
				$return['customOrderId'][$row->customOrderId][$i]['productImageName'] 	 = $row->mainImage;
				$return['customOrderId'][$row->customOrderId][$i]['productId'] 	 		= $row->productId;
				$return['customOrderId'][$row->customOrderId][$i]['productName'] 	 	 = $row->code;
				$return['customOrderId'][$row->customOrderId][$i]['quantity'] 		 	 = $row->quantity;
				$return['customOrderId'][$row->customOrderId][$i]['totalAmount']		 = $row->totalAmount;
				$return['customOrderId'][$row->customOrderId][$i]['trackingNbr']		 = $row->trackingNbr;
				$return['customOrderId'][$row->customOrderId][$i]['shippingBusinessName'] = $shippingBusinessName;
				$return['customOrderId'][$row->customOrderId][$i]['orderDate']		     = $row->orderDate;
				$return['customOrderId'][$row->customOrderId][$i]['deliveredDate']		 = $row->deliveredDate;
				$return['customOrderId'][$row->customOrderId][$i]['orderStatusId']		 = $row->orderStatusId;
				$return['customOrderId'][$row->customOrderId][$i]['retailerBusinessName'] = $retailerBusinessName;
				$return['customOrderId'][$row->customOrderId][$i]['eta'] = $eta+$this->CI->config->item('estimated_time_increase');
				
				$return['customOrderId'][$row->customOrderId][$i]['color'] 				 = $row->colorCode;
				$return['customOrderId'][$row->customOrderId][$i]['size'] 				 = $row->size;
				$return['customOrderId'][$row->customOrderId][$i]['isPickup'] 			 = $row->isPickup;
				$return['customOrderId'][$row->customOrderId][$i]['pickupProccessPrice'] = $row->pickupProccessPrice;				
				$return['customOrderId'][$row->customOrderId][$i]['paymentStatus'] 		 = $row->paymentStatus;
				$return['customOrderId'][$row->customOrderId][$i]['cashHandlingPrice']   = $row->cashHandlingPrice;
				$return['customOrderId'][$row->customOrderId][$i]['genuineShippFee'] 	 = $row->genuineShippFee;
				$return['customOrderId'][$row->customOrderId][$i]['cashAdminFee'] 		 = $row->cashAdminFee;
				$return['customOrderId'][$row->customOrderId][$i]['productWeight'] 		 = $row->productWeight;
				$return['customOrderId'][$row->customOrderId][$i]['freeShipCatId'] 		 = $row->freeShipCatId;
				$return['customOrderId'][$row->customOrderId][$i]['freeShipPrdId'] 		 = $row->freeShipPrdId;				
				$return['customOrderId'][$row->customOrderId][$i]['isEconomicDelivery']  = $row->isEconomicDelivery;
				
				if($row->isEconomicDelivery)
				{
					$economicShipRateDetails = $this->CI->order_m->economic_shipping_rate($row->customOrderId);
					if(!empty($economicShipRateDetails))
					{
						$eta = $economicShipRateDetails->ETA;
						$return['customOrderId'][$row->customOrderId][$i]['shippingRate'] = $economicShipRateDetails->amount;
					}
					
					$conomicDelDet = $this->CI->order_m->economic_delivery_details($row->customerId,$row->customOrderId,$row->organizationId);
					if(!empty($conomicDelDet))
					{
						$return['customOrderId'][$row->customOrderId][$i]['isCalculateShipp']  = $conomicDelDet->isCalculateShipp;
						$return['customOrderId'][$row->customOrderId][$i]['cashHandlingPrice'] = $conomicDelDet->cashHandlingPrice;
						$return['customOrderId'][$row->customOrderId][$i]['productWeight']     = $conomicDelDet->totalProductWeight;
					}
				}
				
				if($this->CI->session->userdata('isPointeForce'))
				{
					$totalCommiArr[$row->customOrderId]['verifiedStatus'] = $row->verifiedStatus;
					$totalCommiArr[$row->customOrderId]['paidStatus']     = $row->paidStatus;
				
					if((!empty($totalCommiArr[$row->customOrderId]['totalCommissionPrice']))&&($totalCommiArr[$row->customOrderId]['totalCommissionPrice']))
					{
						$totalCommiArr[$row->customOrderId]['totalCommissionPrice'] = $totalCommiArr[$row->customOrderId]['totalCommissionPrice']+$row->totalCommissionPrice;
					}
					else
					{
						$totalCommiArr[$row->customOrderId]['totalCommissionPrice'] = $row->totalCommissionPrice;
					}
				}
				
				$i++;
				$totalFullSum = ($row->quantity*$retailerDetails->currentPrice)+($row->quantity*$shippRateAmt)+$totalFullSum;				
			}
		}
		
		if(!empty($return['customOrderId']))
		{
			krsort($return['customOrderId']);
		}
		$return['totalFullSum'] = $totalFullSum;
		$return['totalCommiArr'] = $totalCommiArr;
		//echo "<pre>";	print_r($return); exit;
		return $return;		
	}	
	
	public function track_order_details($orderId)
	{
		$return                            = array();
		$return['totalShipping']           = '';
		$return['productPrice']            = '';
		$return['newOrderTime']            = '';
		$return['confirmOrderTime']        = '';
		$return['readyToShippedOrderTime'] = '';
		$return['inTransitOrderTime']      = '';
		$return['deliveredOrderTime']      = '';
		$return['dropCenterName']          = '';
		$return['customerFirstName']       = '';
		$return['customerLastName']    = '';
		$return['customerPhoneNo']     = '';
		$return['customerAddress1']    = '';
		$return['customerAddress2']    = '';
		$return['customerAreaName']	   = '';
		$return['customerCityName']    = '';
		$return['customerStateName']   = '';
		$return['customerCountryName'] = '';
		$return['customerZip']		   = '';
		$return['isPickup']  		   = '';
		$return['paymentStatus']	   = 0;
		$return['pickupName']     = '';
		$return['pickupAddress1'] = '';
		$return['pickupCity']     = '';
		$return['pickupArea']     = '';
		$return['pickupState']    = '';
		$return['pickupPhone']    = '';
		$return['pickupSecPhone'] = '';
		$return['pickupBusnsDay'] = '';
		$return['pickupBusnsHrs'] = '';
		$return['totalFullSum']   = 0;
		
		$userId       = $this->CI->session->userdata('userId');		
		$shippingDetails = $this->CI->order_m->order_shipping_address_details($userId,$orderId);			
		if(!empty($shippingDetails))
		{
			$return['customerFirstName']   = $shippingDetails->firstName;
			$return['customerLastName']    = $shippingDetails->lastName;
			$return['customerPhoneNo']     = $shippingDetails->phone;
			$return['customerAddress1']    = $shippingDetails->addressLine1;
			$return['customerAddress2']    = $shippingDetails->address_Line2;
			$return['customerCityName']    = $shippingDetails->cityName;
			$return['customerAreaName']    = $shippingDetails->areaName;
			$return['customerStateName']   = $shippingDetails->stateName;
			$return['customerCountryName'] = $shippingDetails->countryName;
		}
		
		
		$orderDet = $this->CI->order_m->track_order_details($orderId);	
		$trackOrderTime = $this->CI->order_m->track_order_time_details($orderId);
		if(!empty($trackOrderTime))
		{
			foreach($trackOrderTime as $timeRow)
			{
				if($timeRow->orderStatusId==1)
				{
					$return['newOrderTime'] = $timeRow->createTime;
				}
				elseif($timeRow->orderStatusId==2)
				{
					$return['confirmOrderTime'] = $timeRow->createTime;
				}
				elseif($timeRow->orderStatusId==3)
				{
					$return['readyToShippedOrderTime'] = $timeRow->createTime;
				}
				elseif($timeRow->orderStatusId==4)
				{
					$return['inTransitOrderTime'] = $timeRow->createTime;
				}
				elseif($timeRow->orderStatusId==5)
				{
					$return['deliveredOrderTime'] = $timeRow->createTime;
				}
				elseif($timeRow->orderStatusId==9)
				{
					$return['deliveredOrderTime'] = $timeRow->createTime;
				}
			}
		}
				
		$totalFullSum = 0;
		if(!empty($orderDet))
		{
			$shippingBusinessName = '';
			$retailerBusinessName = '';
			$eta				  = 0;
			$shipperDetails = $this->CI->user_m->shipping_vendor_user_details($orderDet->shippingOrgId);
			if(!empty($shipperDetails))
			{
				$shippingBusinessName = $shipperDetails->organizationName;
			}
			$retailerDetails = $this->CI->order_m->order_retailer_details($orderDet->organizationProductId);
			//echo "<pre>"; print_r($retailerDetails); exit;
			if(!empty($retailerDetails))
			{
				if($retailerDetails->organizationName)
				{
					$retailerBusinessName = $retailerDetails->organizationName;
				}
				else
				{
					$retailerBusinessName = $retailerDetails->firstName.' '.$retailerDetails->lastName;
				}
				$return['dropCenterName'] = $retailerDetails->dropCenterName;
			}
		//	echo "<pre>"; print_r($retailerDetails); exit;
			$shippRateAmt = 0;
			$shipRateDetails = $this->CI->user_m->shipping_rate_details($orderDet->shippingRateId,$orderDet->shippingOrgId);
			if(!empty($shipRateDetails))
			{
				$eta = $shipRateDetails->ETA;
				$shippRateAmt = $shipRateDetails->amount;
			}
			if($this->CI->session->userdata('isMarketingUser')==1)
			{
				$shippRateAmt = 0;
			}
			
			$return['customOrderId'] 		= $orderDet->customOrderId;
			$return['orderId'] 		 	 = $orderDet->orderId;
			$return['productImageName'] 	 = $orderDet->mainImage;
			$return['productName'] 	 	 = $orderDet->code;
			$return['quantity'] 		 	 = $orderDet->quantity;
			$return['totalAmount']		 	 = ($orderDet->chargedAmount*$orderDet->quantity);
			$return['trackingNbr']		 	 = $orderDet->trackingNbr;
			$return['shippingBusinessName'] = $shippingBusinessName;
			$return['orderDate']		     = $orderDet->orderDate;
			$return['deliveredDate']		 = $orderDet->deliveredDate;
			$return['orderStatusId']		 = $orderDet->orderStatusId;
			$return['retailerBusinessName'] = $retailerBusinessName;
			$return['eta'] 				    = $eta+$this->CI->config->item('estimated_time_increase');
			$return['lastModifiedDt']       = $orderDet->lastModifiedDt;
			$return['color']		        = $orderDet->colorCode;
			$return['size']       		    = $orderDet->size;
			$return['totalShipping'] = $orderDet->quantity*$shippRateAmt;
			$totalFullSum = ($orderDet->quantity*$retailerDetails->currentPrice)+($orderDet->quantity*$shippRateAmt)+$totalFullSum;
			$return['currentPrice'] = $orderDet->currentPrice;
			$return['quantity']     = $orderDet->quantity;
			$return['isPickup']     = $orderDet->isPickup;
			$return['paymentStatus'] = $orderDet->paymentStatus;
			$return['pickupProccessPrice'] = $orderDet->pickupProccessPrice;
			if($orderDet->isPickup)
			{
				$return['totalAmount'] = $return['totalAmount']+($orderDet->pickupProccessPrice*$orderDet->quantity);	
			}
			
			$return['totalFullSum'] = $orderDet->totalAmount;
			if($return['isPickup'])
			{
				$pickupDet = $this->CI->cart_m->pickup_details($orderDet->pickupId);
				if(!empty($pickupDet))
				{
					$return['pickupName']     = $pickupDet->pickupName;
					$return['pickupAddress1'] = $pickupDet->addressLine1;
					$return['pickupCity']     = $pickupDet->cityName;
					$return['pickupArea']     = $pickupDet->areaName;
					$return['pickupState']    = $pickupDet->stateName;
					$return['pickupPhone']    = $pickupDet->phone;
					$return['pickupSecPhone'] = $pickupDet->secondary_phone;
					$return['pickupBusnsDay'] = $pickupDet->businessDays;
					$return['pickupBusnsHrs'] = $pickupDet->businessHours;
					
					$cusDet = $this->CI->customer_m->customer_details($orderDet->customerId);	
					if(!empty($cusDet))
					{
						$return['customerFirstName']   = $cusDet->firstName;
						$return['customerLastName']    = $cusDet->lastName;
						$return['customerPhoneNo']     = $cusDet->phone;
					}
				}
			}
		}
		
		//echo "<pre>";	print_r($return); exit;
		return $return;
	}
	
	

	public function search_order_index()
	{
		$return     = array();
		$where      = '';
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
		
		$return['total'] = $this->CI->order_m->total_search_order($where);	
		return $return;
	}
	
	public function search_order_ajax($total)
	{
		$return  = array();
		$perPage = $this->CI->input->post('sel_no_entry');
		$sorting = $this->CI->input->post('sorting');
		$search  = trim($this->CI->input->post('search'));
		$where   = '';
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
		
		if((!empty($sorting))&&($sorting=='customerName')&&(!empty($search)))
		{
			$where = 'CONCAT(customer.firstName," ",customer.lastName) Like "'.$search.'%"';	
		}
		elseif((!empty($sorting))&&($sorting=='orderId')&&(!empty($search)))
		{
			$where = 'order.customOrderId Like "'.$search.'%"';		
		}
		elseif((!empty($sorting))&&($sorting=='trackingId')&&(!empty($search)))
		{
			$where = 'order.trackingNbr Like "'.$search.'%"';	
		}
		elseif((!empty($sorting))&&($sorting=='customerEmail')&&(!empty($search)))
		{
			$where = 'customer.email Like "'.$search.'%"';	
		}
		else
		{
			$where = '(CONCAT(customer.firstName," ",customer.lastName) Like "'.$search.'%" OR order.trackingNbr Like "'.$search.'%" OR customer.email Like "'.$search.'%" OR order.customOrderId Like "'.$search.'%")';
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
				if(!empty($where))
				{
					$where.= ' AND (order_dropship_center.toDropshipId in ('.$in.'))';
				}
				else
				{
					$where = 'order_dropship_center.toDropshipId in ('.$in.')';
				}
			}
		}
		
		if(!empty($where))
		{
			$total = $this->CI->order_m->total_search_order($where);	
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/search_order/search_order_ajax/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_m->search_order_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function search_order_view($orderID)
	{
		$returnArr 					       	   = array();
		$returnArr['orderID']				   = $orderID;
		$returnArr['customerFirstName']	   	   = '';
		$returnArr['customerMiddle']	   	   = '';
		$returnArr['customerLastName']	   	   = '';
		$returnArr['customerPhone']	   	   	   = '';
		$returnArr['customerEmail']	   	   	   = '';
		$returnArr['billingCountry']       	   = '';
		$returnArr['billingState']    	   	   = '';
		$returnArr['billingCity']     	   	   = '';
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
		$returnArr['lastModifiedDate']         = '';	
		$returnArr['shippingRate']             = 0;
		$returnArr['billingZip']               = '';
		$returnArr['shippingZip']              = '';
		$returnArr['shippingArea']             = '';
		
		$returnArr['newOrderTime']             = '';
		$returnArr['confirmOrderTime']         = '';
		$returnArr['readyToShippedOrderTime']  = '';
		$returnArr['inTransitOrderTime']       = '';
		$returnArr['deliveredOrderTime']       = '';
		
		$returnArr['customerShippFirstName']   = '';
		$returnArr['customerShippLastName']	   = '';
		$returnArr['customerShippPhone']	   = '';
		$returnArr['customerBillFirstName']    = '';
		$returnArr['customerBillLastName']	   = '';
		$returnArr['customerBillPhone'] 	   = '';					
		$returnArr['vendorAreaName']           = '';
		$returnArr['retailerAreaName']		   = '';
		$returnArr['chargedAmount']	           = '';
		$returnArr['paymentStatus']			   = '';
		$returnArr['retailerPrice']			   = 0;	
		$returnArr['totalAmount']              = 0;	
		$returnArr['cashHandlingPrice']		   = 0;	
		$billingDetails 					   = '';
		$shippingDetails 					   = '';
		
		$orderDetails   = $this->CI->order_m->search_order_details($orderID);
		
		if(!empty($orderDetails))
		{
			//$billingDetails  = $this->CI->user_m->user_shipping_details($orderDetails->customerId);
			$billingDetails  = $this->CI->order_m->order_billing_address_details($orderDetails->customerId,$orderDetails->orderId);
			if(empty($billingDetails))
			{
				$billingDetails = $this->CI->customer_m->user_profile_details($orderDetails->customerId);				
			}

			//$shippingDetails = $this->CI->user_m->user_shipping_details($orderDetails->customerId);
			$shippingDetails = $this->CI->order_m->order_shipping_address_details($orderDetails->customerId,$orderDetails->orderId);
			if(!empty($shippingDetails))
			{
				$returnArr['customerShippFirstName'] = $shippingDetails->firstName;
				$returnArr['customerShippLastName']	 = $shippingDetails->lastName;
				$returnArr['customerShippPhone']	 = $shippingDetails->phone;	
			}

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
			$returnArr['customerOrderId']  = $orderDetails->customOrderId;
			$returnArr['orderDate']        = $orderDetails->createDt;
			$returnArr['trackingNbr']      = $orderDetails->trackingNbr;
			$returnArr['deliveredDate']    = $orderDetails->deliveredDate;
			$returnArr['productQuantity']  = $orderDetails->quantity;
			$returnArr['lastModifiedDate'] = $orderDetails->orderLastModfiedDt;
			$returnArr['color']            = $orderDetails->colorCode;
			$returnArr['size']             = $orderDetails->size; 
			$returnArr['chargedAmount']	   = $orderDetails->chargedAmount;
			$returnArr['paymentStatus']	   = $orderDetails->paymentStatus;
			$returnArr['retailerPrice']    = $orderDetails->retailerPrice;
			$returnArr['totalAmount']      = $orderDetails->totalAmount;
			$returnArr['cashHandlingPrice'] = $orderDetails->cashHandlingPrice;
			
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($orderDetails->customerId);
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
				$returnArr['productPrice'] 	   = $productDetails->currentPrice;
				$returnArr['productImageName'] = $productDetails->imageName;				
			}
			
			$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($orderDetails->shippingOrgId);
			//echo "<pre>";	print_r($retailerDetails); exit;
			if(!empty($shipperDetails))
			{
				$returnArr['vendorBusinessName'] = $shipperDetails->organizationName;
				$returnArr['vendorFirstName'] = $shipperDetails->firstName;
				$returnArr['vendorLastName'] = $shipperDetails->lastName;
				$returnArr['vendorEmail'] = $shipperDetails->email;
				$returnArr['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
				$returnArr['vendorBusinessPhone'] = $shipperDetails->businessPhone;
				$returnArr['vendorAddressLine1'] = $shipperDetails->addressLine1;
				$returnArr['vendorCountryName'] = $shipperDetails->countryName;
				$returnArr['vendorStateName'] = $shipperDetails->stateName;
				$returnArr['vendorCityName'] = $shipperDetails->cityName;
				$returnArr['vendorAreaName'] = $shipperDetails->areaName;
				
				$shippRateDet = $this->CI->order_m->shipping_rate_details($orderDetails->shippingOrgId,$orderDetails->shippingRateId);
				if(!empty($shippRateDet))
				{
					$returnArr['shippingRate'] = $shippRateDet->amount;
				}
			}
		}
		
		if(!empty($billingDetails))
		{
			$returnArr['customerBillFirstName'] = $billingDetails->firstName;
			$returnArr['customerBillLastName']  = $billingDetails->lastName;
			$returnArr['customerBillPhone']     = $billingDetails->phone;
			
			if(empty($billingDetails->firstName))
			{				
				$returnArr['customerBillFirstName'] = $returnArr['customerFirstName'];
			}
			if(empty($billingDetails->lastName))
			{
				$returnArr['customerBillLastName'] = $returnArr['customerLastName'];
			}
			if(empty($billingDetails->phone))
			{
				$returnArr['customerBillPhone'] = $returnArr['customerPhone'];
			}
			
			$returnArr['billingCountry']      = $billingDetails->countryName;
			$returnArr['billingState']    	  = $billingDetails->stateName;
			$returnArr['billingCity']     	  = $billingDetails->cityName;
			$returnArr['billingAddressLine1'] = $billingDetails->addressLine1;
			$returnArr['billingAddressLine2'] = $billingDetails->address_Line2;
			$returnArr['billingZip']          = $billingDetails->zip;
		}
		
		if(!empty($shippingDetails))
		{
			$returnArr['shippingCountry']      = $shippingDetails->countryName;
			$returnArr['shippingState']    	   = $shippingDetails->stateName;
			$returnArr['shippingArea'] 	       = $shippingDetails->areaName;
			$returnArr['shippingCity']     	   = $shippingDetails->cityName;
			$returnArr['shippingAddressLine1'] = $shippingDetails->addressLine1;
			$returnArr['shippingAddressLine2'] = $shippingDetails->address_Line2;
			$returnArr['shippingZip']          = $shippingDetails->zip;
		}
		return $returnArr;
	}
	
	public function shipping_bounce_list()
	{
		$return = array();
		$return['total'] = $this->CI->shipping_m->total_shipping_bounce();	
		return $return;
	}
	
	public function shipping_bounce_list_ajaxFun($total)
	{
		$return    = array();
		$perPage   = $this->CI->input->post('sel_no_entry');
		$dropship  = $this->CI->input->post('dropship');
		$stateName = $this->CI->input->post('stateName');
		$areaName  = $this->CI->input->post('areaName');
		$cityName  = $this->CI->input->post('cityName');
		$totalHit  = $this->CI->input->post('totalHit');
		$where     = '';
		if(!empty($dropship))
		{
			$where = 'dropship_center.dropCenterName LIKE "'.$dropship.'%"';	
		}
		if(!empty($stateName))
		{
			if($where)
			{
				$where.= ' AND state.stateName LIKE "'.$stateName.'%"';
			}
			else
			{
				$where = 'state.stateName LIKE "'.$stateName.'%"';	
			}
		}
		if(!empty($cityName))
		{
			if($where)
			{
				$where.= ' AND zip.city LIKE "'.$cityName.'%"';
			}
			else
			{
				$where = 'zip.city LIKE "'.$cityName.'%"';	
			}
		}
		if(!empty($areaName))
		{
			if($where)
			{
				$where.= ' AND area.area LIKE "'.$areaName.'%"';
			}
			else
			{
				$where = 'area.area LIKE "'.$areaName.'%"';	
			}
		}
		if(!empty($totalHit))
		{
			if($where)
			{
				$where.= ' AND shipping_bounce.totalHit LIKE "'.$totalHit.'%"';
			}
			else
			{
				$where = 'shipping_bounce.totalHit LIKE "'.$totalHit.'%"';	
			}
		}
		if(!empty($where))
		{
			$where = '('.$where.')';
			$total = $this->CI->shipping_m->total_shipping_bounce($where);	
		}
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/shipping_bounce/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->shipping_m->shipping_bounce_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
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
		redirect(base_url().$this->CI->session->userdata('userType').'/new_order');
	}
	
	public function customer_order_ajax($customerId)
	{
		$return 	  = array();
		$perPage 	  = $this->CI->input->post('sel_no_entry');
		$orderId 	  = $this->CI->input->post('orderId');
		$productName  = $this->CI->input->post('productName');
		$retailerName = $this->CI->input->post('retailerName');
		$where 		  = '';		
		
		if(!empty($orderId))
		{
			$where = 'order.customOrderId LIKE "'.$orderId.'%"';
		}
		
		if(!empty($productName))
		{
			if(!empty($where))
			{
				$where.= ' AND product.code LIKE "'.$productName.'%"';
			}
			else
			{
				$where = 'product.code LIKE "'.$productName.'%"';
			}
		}
		
		if(!empty($retailerName))
		{
			if(!empty($where))
			{
				$where.= ' AND organization.organizationName LIKE "'.$retailerName.'%"';
			}
			else
			{
				$where = 'organization.organizationName LIKE "'.$retailerName.'%"';
			}
		}
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total	   = $this->CI->order_m->total_customer_order($customerId,$where);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/customer_management/orderAjaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_m->customer_order_list($customerId,$page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function customer_order_view($orderID)
	{
		$returnArr 					       	   = array();
		$returnArr['orderID']				   = $orderID;
		$returnArr['customerOrderId']      	   = '';
		
		$returnArr['orderDate'] 		   	   = '';
		$returnArr['newOrderTime']             = '';
		$returnArr['confirmOrderTime']         = '';
		$returnArr['readyToShippedOrderTime']  = '';
		$returnArr['inTransitOrderTime']       = '';
		$returnArr['deliveredOrderTime']       = '';
		
		$returnArr['productImageName'] 		   = '';
		$returnArr['productName'] 	   		   = '';
		$returnArr['productQuantity']  		   = 0;
		$returnArr['color']					   = '';
		$returnArr['size']					   = '';
		
		$returnArr['totalAmount']              = 0;
		$returnArr['chargedAmount']			   = '';
		$returnArr['retailerPrice']			   = 0;
		$returnArr['cashHandlingPrice']		   = 0;		
		$returnArr['cashAdminFee']			   = 0;
		$returnArr['genuineShippFee']		   = 0;
		$returnArr['paymentStatus']			   = '';
		$returnArr['isPickup']		      	   = 0;
		$returnArr['orderStatusId']	      	   = 0;		
		
		$returnArr['freeShipPrdId']			   = 0;
		$returnArr['freeShipCatId']			   = 0;
		
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
		
		$returnArr['customerFirstName']	   	   = '';
		$returnArr['customerMiddle']	   	   = '';
		$returnArr['customerLastName']	   	   = '';
		$returnArr['customerPhone']	   	   	   = '';
		$returnArr['customerEmail']	   	   	   = '';
		
		$returnArr['billingCountry']       	   = '';
		$returnArr['billingState']    	   	   = '';
		$returnArr['billingCity']     	   	   = '';
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
				
		$returnArr['productPrice'] 	   		   = 0;
		
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
		
		$returnArr['customerShippFirstName']   = '';
		$returnArr['customerShippLastName']	   = '';
		$returnArr['customerShippPhone']	   = '';	
		$returnArr['customerBillFirstName']    = '';
		$returnArr['customerBillLastName']	   = '';
		$returnArr['customerBillPhone'] 	   = '';	
		$returnArr['phoneCode']				   = '+234';
		
		$billingDetails 					   = '';
		$shippingDetails 					   = '';
		
		$orderDetails = $this->CI->order_m->customer_order_details($orderID);
		//echo "<pre>"; print_r($orderDetails); exit;
		if(!empty($orderDetails))
		{
			$returnArr['productImageName']  = $orderDetails->imageName;
			$returnArr['productName'] 	    = $orderDetails->code;
			$returnArr['productQuantity']   = $orderDetails->quantity;
			
			$returnArr['totalAmount']       = $orderDetails->totalAmount;
			$returnArr['chargedAmount']	    = $orderDetails->chargedAmount;
			$returnArr['retailerPrice']     = $orderDetails->retailerPrice;
			$returnArr['cashHandlingPrice'] = $orderDetails->cashHandlingPrice;
			$returnArr['cashAdminFee']		= $orderDetails->cashAdminFee;
			$returnArr['genuineShippFee']	= $orderDetails->genuineShippFee;
			
			$returnArr['paymentStatus']	    = $orderDetails->paymentStatus;
			$returnArr['isPickup']		    = $orderDetails->isPickup;
			$returnArr['orderStatusId']	    = $orderDetails->orderStatusId;	
			$returnArr['color']			    = $orderDetails->colorCode;
			$returnArr['size'] 			    = $orderDetails->size;
			$returnArr['freeShipPrdId']		= $orderDetails->freeShipPrdId;
			$returnArr['freeShipCatId']		= $orderDetails->freeShipCatId;
			
			$returnArr['customerOrderId']   = $orderDetails->customOrderId;
			$returnArr['orderDate']         = $orderDetails->createDt;
			$returnArr['trackingNbr']       = $orderDetails->trackingNbr;
			$returnArr['deliveredDate']     = $orderDetails->deliveredDate;
			
			$returnArr['lastModifiedDate']  = $orderDetails->orderLastModfiedDt;
			
			if((!empty($orderDetails->marketingProductId))&&($orderDetails->marketingProductId))
			{
				$returnArr['retailerPrice'] = $returnArr['retailerPrice']-$orderDetails->retailerDiscount;	
			}
			
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
			
			$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($orderDetails->shippingOrgId);
			if(!empty($shipperDetails))
			{
				$returnArr['vendorBusinessName'] 	  = $shipperDetails->organizationName;
				$returnArr['vendorFirstName'] 		  = $shipperDetails->firstName;
				$returnArr['vendorLastName'] 		  = $shipperDetails->lastName;
				$returnArr['vendorEmail'] 			  = $shipperDetails->email;
				$returnArr['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
				$returnArr['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
				$returnArr['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
				$returnArr['vendorCountryName'] 	  = $shipperDetails->countryName;
				$returnArr['vendorStateName'] 		  = $shipperDetails->stateName;
				$returnArr['vendorCityName'] 		  = $shipperDetails->cityName;
				$returnArr['vendorAreaName'] 		  = $shipperDetails->areaName;
				
				$shippRateDet = $this->CI->order_m->shipping_rate_details($orderDetails->shippingOrgId,$orderDetails->shippingRateId);
				if(!empty($shippRateDet))
				{
					$returnArr['shippingRate'] = $shippRateDet->amount;
					if((!empty($orderDetails->productWeight))&&($orderDetails->productWeight>10))
					{
						$returnArr['shippingRate'] = $shippRateDet->amount*$orderDetails->productWeight;
					}					
				}
			}
		
			$retailerDetails = $this->CI->order_m->order_retailer_details($orderDetails->organizationProductId);
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
			
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($orderDetails->customerId);
			if(!empty($customerDetails))
			{
				$returnArr['customerFirstName'] = $customerDetails->firstName;
				$returnArr['customerLastName']	= $customerDetails->lastName;
				$returnArr['customerPhone']	   	= $customerDetails->phone;	
				$returnArr['customerEmail']	   	= $customerDetails->email;
			}
			
			$billingDetails  = $this->CI->order_m->order_billing_address_details($orderDetails->customerId,$orderDetails->orderId);
			$shippingDetails = $this->CI->order_m->order_shipping_address_details($orderDetails->customerId,$orderDetails->orderId);
			if(empty($billingDetails))
			{
				$billingDetails = $this->CI->customer_m->user_profile_details($orderDetails->customerId);				
			}
			
			if(!empty($shippingDetails))
			{
				$returnArr['customerShippFirstName'] = $shippingDetails->firstName;
				$returnArr['customerShippLastName']	 = $shippingDetails->lastName;
				$returnArr['customerShippPhone']	 = $shippingDetails->phone;	
			}
			
			if(!empty($billingDetails))
			{
				$returnArr['customerBillFirstName'] = $billingDetails->firstName;
				$returnArr['customerBillLastName']  = $billingDetails->lastName;
				$returnArr['customerBillPhone']     = $billingDetails->phone;
				
				if(empty($billingDetails->firstName))
				{				
					$returnArr['customerBillFirstName'] = $returnArr['customerFirstName'];
				}
				if(empty($billingDetails->lastName))
				{
					$returnArr['customerBillLastName'] = $returnArr['customerLastName'];
				}
				if(empty($billingDetails->phone))
				{
					$returnArr['customerBillPhone'] = $returnArr['customerPhone'];
				}
				
				$returnArr['billingCountry']        = $billingDetails->countryName;
				$returnArr['billingState']    	    = $billingDetails->stateName;
				$returnArr['billingCity']     	    = $billingDetails->cityName;
				$returnArr['billingAddressLine1']   = $billingDetails->addressLine1;
				$returnArr['billingAddressLine2']   = $billingDetails->address_Line2;
				$returnArr['billingZip']            = $billingDetails->zip;
			}
			
			if(!empty($shippingDetails))
			{
				$returnArr['shippingCountry']      = $shippingDetails->countryName;
				$returnArr['shippingState']    	   = $shippingDetails->stateName;
				$returnArr['shippingArea'] 	       = $shippingDetails->areaName;
				$returnArr['shippingCity']     	   = $shippingDetails->cityName;
				$returnArr['shippingAddressLine1'] = $shippingDetails->addressLine1;
				$returnArr['shippingAddressLine2'] = $shippingDetails->address_Line2;
				$returnArr['shippingZip']          = $shippingDetails->zip;
			}
		}
		return $returnArr;
	}
	
	public function order_ajax()
	{
		$return 	     = array();
		$perPage    	 = $this->CI->input->post('sel_no_entry');
		$where 		     = '';		
		$userRole        = $this->CI->session->userdata('userRole');
		$userType        = $this->CI->session->userdata('userType');
		$employeeId      = $this->CI->session->userdata('userId');
		$drincr          = 1;
		$in              = '';
		$dropship_center = '';
		$searchDropship  = $this->CI->input->post('dropship');
		$searchOrderSts  = $this->CI->input->post('orderStatus');
		$cusDetDrp       = $this->CI->input->post('cusDetDrp');
		$cusDetTxt       = $this->CI->input->post('cusDetTxt');
		$retDetDrp       = $this->CI->input->post('retDetDrp');
		$retDetTxt       = $this->CI->input->post('retDetTxt');
		$prdDetDrp       = $this->CI->input->post('prdDetDrp');
		$prdDetTxt       = $this->CI->input->post('prdDetTxt');
		$ordrDetDrp      = $this->CI->input->post('ordrDetDrp');
		$ordrDetTxt      = $this->CI->input->post('ordrDetTxt');
		
		//print_r($_POST);	 exit;
		if((!empty($userRole))&&($userRole=='SVE'))
		{
			$dropship_center = $this->CI->shipping_m->shipping_employee_dropship_center_list($employeeId);
			$where = '(order_dropship_center.toDropshipId IS NULL)';
		}
		elseif((!empty($userType))&&($userType=='cse'))
		{
			$dropship_center = $this->CI->cse_m->cse_dropship_center_list($employeeId);
			$where = '(order_dropship_center.toDropshipId IS NULL)';
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
		
		if(!empty($searchDropship))
		{
			if(!empty($where))
			{
				$where.= ' AND dropship_center.dropCenterName Like "'.$searchDropship.'%"';
			}
			else
			{
				$where = 'dropship_center.dropCenterName Like "'.$searchDropship.'%"';
			}
		}
			
		if(!empty($searchOrderSts))
		{
			$ordrSts = '';
			if($searchOrderSts==1)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 0 AND order.orderStatusId = 1)';
			}
			elseif($searchOrderSts==2)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 1 AND order.orderStatusId = 1)';
			}
			elseif($searchOrderSts==3)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 0 AND order.orderStatusId = 2)';
			}
			elseif($searchOrderSts==4)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 1 AND order.orderStatusId = 2)';
			}
			elseif($searchOrderSts==5)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 0 AND order.orderStatusId = 3)';
			}
			elseif($searchOrderSts==6)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 1 AND order.orderStatusId = 3)';
			}
			elseif($searchOrderSts==7)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 0 AND order.orderStatusId = 4)';
			}
			elseif($searchOrderSts==8)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 0 AND order.orderStatusId = 5)';
			}
			elseif($searchOrderSts==9)
			{
				$ordrSts = '(order.active = 1 AND order.isPickup = 1 AND order.orderStatusId = 5)';
			}
			elseif($searchOrderSts==10)
			{
				$ordrSts = '(order.active = 0 OR order.orderStatusId = 6)';
			}
			
			if(!empty($ordrSts))
			{
				if(!empty($where))
				{
					$where.= ' AND '.$ordrSts;
				}
				else
				{
					$where = $ordrSts;
				}	
			}
		}
		
		if(!empty($cusDetDrp))		
		{
			if(!empty($cusDetTxt))
			{
				if(!empty($where))
				{
					if($cusDetDrp=='name')
					{
						$where.= ' AND CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='phone')
					{
						$where.= ' AND customer.phone Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='state')
					{
						$where.= ' AND state.stateName Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='area')
					{
						$where.= ' AND area.area Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='city')
					{
						$where.= ' AND zip.city Like "'.$cusDetTxt.'%"';
					}
				}
				else
				{					
					if($cusDetDrp=='name')
					{
						$where= 'CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='phone')
					{
						$where= 'customer.phone Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='state')
					{
						$where= 'state.stateName Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='area')
					{
						$where= 'area.area Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='city')
					{
						$where= 'zip.city Like "'.$cusDetTxt.'%"';
					}				
				}
			}
		}
		elseif(!empty($cusDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%" OR customer.phone Like "'.$cusDetTxt.'%" OR state.stateName Like "'.$cusDetTxt.'%" OR area.area Like "'.$cusDetTxt.'%" OR zip.city Like "'.$cusDetTxt.'%" )';
			}
			else
			{
				$where.= '( CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%" OR customer.phone Like "'.$cusDetTxt.'%" OR state.stateName Like "'.$cusDetTxt.'%" OR area.area Like "'.$cusDetTxt.'%" OR zip.city Like "'.$cusDetTxt.'%" )';
			}
		}
		
		if(!empty($retDetDrp))		
		{
			if(!empty($retDetTxt))
			{
				if(!empty($where))
				{
					if($retDetDrp=='name')
					{
						$where.= ' AND organization.organizationName Like "'.$retDetTxt.'%"';
					}
					elseif($retDetDrp=='phone')
					{
						$where.= ' AND employee.businessPhone Like "'.$retDetTxt.'%"';
					}
				}
				else
				{					
					if($retDetDrp=='name')
					{
						$where = 'organization.organizationName Like "'.$retDetTxt.'%"';
					}
					elseif($retDetDrp=='phone')
					{
						$where = 'employee.businessPhone Like "'.$retDetTxt.'%"';
					}
				}
			}
		}
		elseif(!empty($retDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( employee.businessPhone Like "'.$retDetTxt.'%" OR organization.organizationName Like "'.$retDetTxt.'%")';
			}
			else
			{
				$where.= '( employee.businessPhone Like "'.$retDetTxt.'%" OR organization.organizationName Like "'.$retDetTxt.'%")';
			}
		}
		
		if(!empty($prdDetDrp))		
		{
			if(!empty($prdDetTxt))
			{
				if(!empty($where))
				{
					if($prdDetDrp=='name')
					{
						$where.= ' AND product.code Like "'.$prdDetTxt.'%"';
					}
					elseif($prdDetDrp=='price')
					{
						$where.= ' AND order.chargedAmount Like "'.$prdDetTxt.'%"';
					}
				}
				else
				{					
					if($prdDetDrp=='name')
					{
						$where = 'product.code Like "'.$prdDetTxt.'%"';
					}
					elseif($prdDetDrp=='price')
					{
						$where = 'order.chargedAmount Like "'.$prdDetTxt.'%"';
					}
				}
			}
		}
		elseif(!empty($prdDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( product.code Like "'.$prdDetTxt.'%" OR order.chargedAmount Like "'.$prdDetTxt.'%")';
			}
			else
			{
				$where.= '( product.code Like "'.$prdDetTxt.'%" OR order.chargedAmount Like "'.$prdDetTxt.'%")';
			}
		}
		
		if(!empty($ordrDetDrp))		
		{
			if(!empty($ordrDetTxt))
			{
				if(!empty($where))
				{
					if($ordrDetDrp=='customOrderId')
					{
						$where.= ' AND order.customOrderId Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='dateTime')
					{
						$where.= ' AND order.createDt Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='orderType')
					{
						$strDel = stripos('Quick Shipment',$ordrDetTxt);
						if($strDel===false)
						{
							$strDel = stripos('Single Shipment',$ordrDetTxt);
							if($strDel===false)
							{
								$strDel = stripos('Pick Up',$ordrDetTxt);						
								if($strDel===false)
								{
									$where.= ' AND order.isPickup = 2';
								}
								else
								{
									$where.= ' AND order.isPickup = 1';
								}
							}
							else
							{
								$where.= ' AND order.isPickup = 0 AND order.isEconomicDelivery = 1';
							}
						}
						else
						{
							$where.= ' AND order.isPickup = 0 AND order.isEconomicDelivery = 0';
						}
					}
					elseif($ordrDetDrp=='paymentMode')
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$where.= ' AND order_payment.paymentStatus = 2';
								}
								else
								{
									$where.= ' AND (order.isPickup = 1 AND order_payment.paymentStatus = 0)';
								}							
							}
							else
							{
								$where.= ' AND (order.isPickup = 0 AND order_payment.paymentStatus = 0)';
							}
						}
						else
						{
							$where.= ' AND order_payment.paymentStatus = 1';
						}						
					}
				}
				else
				{					
					if($ordrDetDrp=='customOrderId')
					{
						$where = 'order.customOrderId Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='dateTime')
					{
						$where = 'order.createDt Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='orderType')
					{						
						$strDel = stripos('Quick Shipment',$ordrDetTxt);
						if($strDel===false)
						{
							$strDel = stripos('Single Shipment',$ordrDetTxt);
							if($strDel===false)
							{
								$strDel = stripos('Pick Up',$ordrDetTxt);						
								if($strDel===false)
								{
									$where.= 'order.isPickup = 2';
								}
								else
								{
									$where.= 'order.isPickup = 1';
								}
							}
							else
							{
								$where.= 'order.isPickup = 0 AND order.isEconomicDelivery = 1';
							}
						}
						else
						{
							$where.= 'order.isPickup = 0 AND order.isEconomicDelivery = 0';
						}
					}
					elseif($ordrDetDrp=='paymentMode')
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$where = 'order_payment.paymentStatus = 2';
								}
								else
								{
									$where = '(order.isPickup = 1 AND order_payment.paymentStatus = 0)';
								}							
							}
							else
							{
								$where = '(order.isPickup = 0 AND order_payment.paymentStatus = 0)';
							}
						}
						else
						{
							$where = 'order_payment.paymentStatus = 1';
						}						
					}					
				}
			}
		}
		elseif(!empty($ordrDetTxt))
		{
			$strWhere = '';
			$strDel = stripos('Quick Shipment',$ordrDetTxt);
			if($strDel===false)
			{
				$strDel = stripos('Single Shipment',$ordrDetTxt);
				if($strDel===false)
				{
					$strPick = stripos('Pick Up',$ordrDetTxt);						
					if($strPick===false)
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$strWhere = 'order_payment.paymentStatus = 2';
								}
								else
								{
									$strWhere = '(order.isPickup = 1 AND order_payment.paymentStatus = 0)';
								}							
							}
							else
							{
								$strWhere = '(order.isPickup = 0 AND order_payment.paymentStatus = 0)';
							}
						}
						else
						{
							$strWhere = 'order_payment.paymentStatus = 1';
						}						
					}
					else
					{
						$strWhere = 'order.isPickup = 1';
					}
				}
				else
				{
					$strWhere = 'order.isPickup = 0 AND order.isEconomicDelivery = 1';
				}
			}
			else
			{
				$strWhere = 'order.isPickup = 0 AND order.isEconomicDelivery = 0';
			}			
					
			if(!empty($where))
			{
				if(!empty($strWhere))
				{
					$where.= ' AND ( order.customOrderId Like "'.$ordrDetTxt.'%" OR order.createDt Like "'.$ordrDetTxt.'%" OR '.$strWhere.' )';
				}
				else
				{
					$where.= ' AND ( order.customOrderId Like "'.$ordrDetTxt.'%" OR order.createDt Like "'.$ordrDetTxt.'%" )';				
				}
			}
			else
			{
				if(!empty($strWhere))
				{
					$where = '( order.customOrderId Like "'.$ordrDetTxt.'%" OR order.createDt Like "'.$ordrDetTxt.'%" OR '.$strWhere.' )';
				}
				else
				{
					$where = '( order.customOrderId Like "'.$ordrDetTxt.'%" OR order.createDt Like "'.$ordrDetTxt.'%" )';				
				}
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$ttl   = $this->CI->order_m->orders_list('','',$where);
		$total = count($ttl);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/order_management/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->order_m->orders_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function orders_view($orderId)
	{
		$returnArr 					       	   = array();
		$returnArr['orderId']				   = $orderId;
		$returnArr['customerOrderId']      	   = '';
		
		$returnArr['orderActiveStatus']        = 0;
		$returnArr['orderDate'] 		   	   = '';
		$returnArr['newOrderTime']             = '';
		$returnArr['confirmOrderTime']         = '';
		$returnArr['readyToShippedOrderTime']  = '';
		$returnArr['inTransitOrderTime']       = '';
		$returnArr['deliveredOrderTime']       = '';
		
		$returnArr['productImageName'] 		   = '';
		$returnArr['productName'] 	   		   = '';
		$returnArr['productQuantity']  		   = 0;
		$returnArr['color']					   = '';
		$returnArr['size']					   = '';
		
		$returnArr['totalAmount']              = 0;
		$returnArr['chargedAmount']			   = '';
		$returnArr['retailerPrice']			   = 0;
		$returnArr['cashHandlingPrice']		   = 0;		
		$returnArr['cashAdminFee']			   = 0;
		$returnArr['genuineShippFee']		   = 0;
		$returnArr['paymentStatus']			   = '';
		$returnArr['isPickup']		      	   = 0;
		$returnArr['orderStatusId']	      	   = 0;		
		
		$returnArr['freeShipPrdId']			   = 0;
		$returnArr['freeShipCatId']			   = 0;
		
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
		$returnArr['retailerAreaName'] 		   = '';
		$returnArr['retailerCityName'] 		   = '';		
		
		$returnArr['customerFirstName']	   	   = '';
		$returnArr['customerMiddle']	   	   = '';
		$returnArr['customerLastName']	   	   = '';
		$returnArr['customerPhone']	   	   	   = '';
		$returnArr['customerEmail']	   	   	   = '';
		
		$returnArr['customerBillFirstName']    = '';
		$returnArr['customerBillLastName']     = '';
		$returnArr['customerBillPhone']        = '';
		$returnArr['billingCountry']       	   = '';
		$returnArr['billingState']    	   	   = '';
		$returnArr['billingArea']    	   	   = '';
		$returnArr['billingCity']     	   	   = '';
		$returnArr['billingAddressLine1']  	   = '';
		$returnArr['billingAddressLine2']  	   = '';
		
		$returnArr['customerShippFirstName']   = '';
		$returnArr['customerShippLastName']	   = '';
		$returnArr['customerShippPhone']       = '';
		$returnArr['shippingCountry']      	   = '';
		$returnArr['shippingState']    	       = '';
		$returnArr['shippingArea']             = '';
		$returnArr['shippingCity']     	   	   = '';
		$returnArr['shippingAddressLine1']     = '';
		$returnArr['shippingAddressLine2']     = '';
		
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
		$returnArr['vendorAreaName']		   = '';
		$returnArr['vendorCityName']           = '';
		
		$returnArr['shippingRate']             = 0;
		$returnArr['phoneCode']				   = '+234';
		$returnArr['isEconomicDelivery']       = 0;
		
		$returnArr['pickupName']        	   = '';
		$returnArr['pickupBusDays']            = '';
		$returnArr['pickupBusHours']           = '';
		$returnArr['pickupAddressLine']        = '';
		$returnArr['pickupPhone']              = '';
		$returnArr['pickupStateName']          = '';
		
		$returnArr['toDropshipId']			   = 0;
		$returnArr['dropShipCenterName']       = '';
		$returnArr['dropShipCenterAddress']    = '';
		
		$orderDetails = $this->CI->order_m->orders_details($orderId);
		if(!empty($orderDetails))
		{
			$returnArr['productImageName']  = $orderDetails->imageName;
			$returnArr['productName'] 	    = $orderDetails->code;
			$returnArr['productQuantity']   = $orderDetails->quantity;
			
			$returnArr['totalAmount']       = $orderDetails->totalAmount;
			$returnArr['chargedAmount']	    = $orderDetails->chargedAmount;
			$returnArr['retailerPrice']     = $orderDetails->retailerPrice;
			$returnArr['cashHandlingPrice'] = $orderDetails->cashHandlingPrice;
			$returnArr['cashAdminFee']		= $orderDetails->cashAdminFee;
			$returnArr['genuineShippFee']	= $orderDetails->genuineShippFee;
			
			$returnArr['paymentStatus']	    = $orderDetails->paymentStatus;
			$returnArr['isPickup']		    = $orderDetails->isPickup;
			$returnArr['orderStatusId']	    = $orderDetails->orderStatusId;	
			$returnArr['orderActiveStatus'] = $orderDetails->active;	
			$returnArr['color']			    = $orderDetails->colorCode;
			$returnArr['size'] 			    = $orderDetails->size;
			$returnArr['freeShipPrdId']		= $orderDetails->freeShipPrdId;
			$returnArr['freeShipCatId']		= $orderDetails->freeShipCatId;
			
			$returnArr['customerOrderId']   = $orderDetails->customOrderId;
			$returnArr['orderDate']         = $orderDetails->createDt;
			$returnArr['trackingNbr']       = $orderDetails->trackingNbr;
			$returnArr['deliveredDate']     = $orderDetails->deliveredDate;
			$returnArr['isEconomicDelivery'] = $orderDetails->isEconomicDelivery;
			$returnArr['toDropshipId']		 = $orderDetails->toDropshipId;
			
			if($orderDetails->isEconomicDelivery)
			{
				$conomicDelDet = $this->CI->order_m->economic_delivery_details($orderDetails->customerId,$orderDetails->customOrderId);
				if(!empty($conomicDelDet))
				{
					$returnArr['isCalculateShipp']  = $conomicDelDet->isCalculateShipp;
					$returnArr['cashHandlingPrice'] = $conomicDelDet->cashHandlingPrice;
					$returnArr['productWeight']     = $conomicDelDet->totalProductWeight;
				}
			}
			
			if((!empty($orderDetails->marketingProductId))&&($orderDetails->marketingProductId))
			{
				$returnArr['retailerPrice'] = $returnArr['retailerPrice']-$orderDetails->retailerDiscount;	
			}
			
			$trackOrderTime = $this->CI->order_m->track_order_time_details($orderId);
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
			
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($orderDetails->customerId);
			if(!empty($customerDetails))
			{
				$returnArr['customerFirstName'] = $customerDetails->firstName;
				$returnArr['customerLastName']	= $customerDetails->lastName;
				$returnArr['customerPhone']	   	= $customerDetails->phone;	
				$returnArr['customerEmail']	   	= $customerDetails->email;
			}
			
			if((!empty($orderDetails->shippingOrgId))&&($orderDetails->shippingOrgId))
			{
				$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($orderDetails->shippingOrgId);
				if(!empty($shipperDetails))
				{
					$returnArr['vendorBusinessName'] 	  = $shipperDetails->organizationName;
					$returnArr['vendorFirstName'] 		  = $shipperDetails->firstName;
					$returnArr['vendorLastName'] 		  = $shipperDetails->lastName;
					$returnArr['vendorEmail'] 			  = $shipperDetails->email;
					$returnArr['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
					$returnArr['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
					$returnArr['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
					$returnArr['vendorCountryName'] 	  = $shipperDetails->countryName;
					$returnArr['vendorStateName'] 		  = $shipperDetails->stateName;
					$returnArr['vendorCityName'] 		  = $shipperDetails->cityName;
					$returnArr['vendorAreaName'] 		  = $shipperDetails->areaName;
					
					$shippRateDet = $this->CI->order_m->shipping_rate_details($orderDetails->shippingOrgId,$orderDetails->shippingRateId);
					if(!empty($shippRateDet))
					{
						$returnArr['shippingRate'] = $shippRateDet->amount;
						if((!empty($orderDetails->productWeight))&&($orderDetails->productWeight>10))
						{
							$returnArr['shippingRate'] = $shippRateDet->amount*$orderDetails->productWeight;
						}					
					}
				}
			}
			
			if((!empty($orderDetails->organizationProductId))&&($orderDetails->organizationProductId))
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($orderDetails->organizationProductId);
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
			}
			
			$billingDetails  = $this->CI->order_m->order_billing_address_details($orderDetails->customerId,$orderDetails->orderId);
			$shippingDetails = $this->CI->order_m->order_shipping_address_details($orderDetails->customerId,$orderDetails->orderId);
			if(empty($billingDetails))
			{
				$billingDetails = $this->CI->customer_m->user_profile_details($orderDetails->customerId);				
			}
			
			if(!empty($billingDetails))
			{
				$returnArr['customerBillFirstName'] = $billingDetails->firstName;
				$returnArr['customerBillLastName']  = $billingDetails->lastName;
				$returnArr['customerBillPhone']     = $billingDetails->phone;
				
				if(empty($billingDetails->firstName))
				{				
					$returnArr['customerBillFirstName'] = $returnArr['customerFirstName'];
				}
				if(empty($billingDetails->lastName))
				{
					$returnArr['customerBillLastName'] = $returnArr['customerLastName'];
				}
				if(empty($billingDetails->phone))
				{
					$returnArr['customerBillPhone'] = $returnArr['customerPhone'];
				}
				
				$returnArr['billingCountry']        = $billingDetails->countryName;
				$returnArr['billingState']    	    = $billingDetails->stateName;
				$returnArr['billingArea']   	    = $billingDetails->areaName;
				$returnArr['billingCity']     	    = $billingDetails->cityName;
				$returnArr['billingAddressLine1']   = $billingDetails->addressLine1;
				$returnArr['billingAddressLine2']   = $billingDetails->address_Line2;
			}
			
			if(!empty($shippingDetails))
			{
				$returnArr['customerShippFirstName'] = $shippingDetails->firstName;
				$returnArr['customerShippLastName']	 = $shippingDetails->lastName;
				$returnArr['customerShippPhone']	 = $shippingDetails->phone;	
			}
			
			if(!empty($shippingDetails))
			{
				$returnArr['shippingCountry']      = $shippingDetails->countryName;
				$returnArr['shippingState']    	   = $shippingDetails->stateName;
				$returnArr['shippingArea'] 	       = $shippingDetails->areaName;
				$returnArr['shippingCity']     	   = $shippingDetails->cityName;
				$returnArr['shippingAddressLine1'] = $shippingDetails->addressLine1;
				$returnArr['shippingAddressLine2'] = $shippingDetails->address_Line2;
			}
			
			if((!empty($returnArr['isPickup']))&&($returnArr['isPickup']))
			{
				if(!empty($orderDetails->pickupId))
				{
					$pickupDet = $this->CI->cart_m->pickup_details($orderDetails->pickupId);
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
			}

			if((!empty($returnArr['toDropshipId']))&&($returnArr['toDropshipId']))
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($returnArr['toDropshipId']);
				if(!empty($dropshipDetails))
				{
					$returnArr['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$returnArr['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
		}
		//echo "<pre>"; print_r($returnArr); exit;
		return $returnArr;
	}
	
	public function economic_order_view($orderId)
	{
		$returnArr 					       	   = array();
		$returnArr['customerOrderId']      	   = $orderId;
				
		$returnArr['orderActiveStatus']        = 0;
		$returnArr['orderDate'] 		   	   = '';
		$returnArr['newOrderTime']             = '';
		$returnArr['confirmOrderTime']         = '';
		$returnArr['readyToShippedOrderTime']  = '';
		$returnArr['inTransitOrderTime']       = '';
		$returnArr['deliveredOrderTime']       = '';
		
		$returnArr['productList']   		   = '';
		
		$returnArr['totalAmount']              = 0;
		$returnArr['chargedAmount']			   = '';
		$returnArr['retailerPrice']			   = 0;
		$returnArr['cashHandlingPrice']		   = 0;		
		$returnArr['cashAdminFee']			   = 0;
		$returnArr['genuineShippFee']		   = 0;
		$returnArr['paymentStatus']			   = '';
		$returnArr['isPickup']		      	   = 0;
		$returnArr['orderStatusId']	      	   = 0;		
		
		$returnArr['freeShipPrdId']			   = 0;
		$returnArr['freeShipCatId']			   = 0;
		
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
		$returnArr['retailerAreaName'] 		   = '';
		$returnArr['retailerCityName'] 		   = '';		
		
		$returnArr['customerFirstName']	   	   = '';
		$returnArr['customerMiddle']	   	   = '';
		$returnArr['customerLastName']	   	   = '';
		$returnArr['customerPhone']	   	   	   = '';
		$returnArr['customerEmail']	   	   	   = '';
		
		$returnArr['customerBillFirstName']    = '';
		$returnArr['customerBillLastName']     = '';
		$returnArr['customerBillPhone']        = '';
		$returnArr['billingCountry']       	   = '';
		$returnArr['billingState']    	   	   = '';
		$returnArr['billingArea']    	   	   = '';
		$returnArr['billingCity']     	   	   = '';
		$returnArr['billingAddressLine1']  	   = '';
		$returnArr['billingAddressLine2']  	   = '';
		
		$returnArr['customerShippFirstName']   = '';
		$returnArr['customerShippLastName']	   = '';
		$returnArr['customerShippPhone']       = '';
		$returnArr['shippingCountry']      	   = '';
		$returnArr['shippingState']    	       = '';
		$returnArr['shippingArea']             = '';
		$returnArr['shippingCity']     	   	   = '';
		$returnArr['shippingAddressLine1']     = '';
		$returnArr['shippingAddressLine2']     = '';
		
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
		$returnArr['vendorAreaName']		   = '';
		$returnArr['vendorCityName']           = '';
		
		$returnArr['shippingRate']             = 0;
		$returnArr['phoneCode']				   = '+234';
		$returnArr['isEconomicDelivery']       = 0;
		
		$returnArr['toDropshipId']			   = 0;
		$returnArr['dropShipCenterName']       = '';
		$returnArr['dropShipCenterAddress']    = '';

		
		$orderDetails = $this->CI->order_m->economic_orders_details($orderId);
		//echo "<pre>"; print_r($orderDetails); exit;
		if(!empty($orderDetails))
		{
			foreach($orderDetails as $row)
			{
				$returnArr['productList'][$row->productId]['name']            = $row->code;
				$returnArr['productList'][$row->productId]['imageName']       = $row->imageName;
				$returnArr['productList'][$row->productId]['quantity']        = $row->quantity;
				$returnArr['productList'][$row->productId]['chargedAmount']   = $row->chargedAmount;
				$returnArr['productList'][$row->productId]['retailerPrice']   = $row->retailerPrice;
				$returnArr['productList'][$row->productId]['cashAdminFee']    = $row->cashAdminFee;
				$returnArr['productList'][$row->productId]['genuineShippFee'] = $row->genuineShippFee;
				$returnArr['productList'][$row->productId]['colorCode'] 	  = $row->colorCode;
				$returnArr['productList'][$row->productId]['size']			  = $row->size;
				$returnArr['productList'][$row->productId]['freeShipPrdId']   = $row->freeShipPrdId;				
				$returnArr['productList'][$row->productId]['freeShipCatId']   = $row->freeShipCatId;
				
				if((!empty($row->marketingProductId))&&($row->marketingProductId))
				{
					$returnArr['productList'][$row->productId]['retailerPrice'] = $returnArr['productList'][$row->productId]['retailerPrice']-$row->retailerDiscount;	
				}
				
				$returnArr['totalAmount']        = $row->totalAmount;
				$returnArr['cashHandlingPrice']  = $row->cashHandlingPrice;
				$returnArr['paymentStatus']	     = $row->paymentStatus;
				$returnArr['isPickup']		     = $row->isPickup;
				$returnArr['orderStatusId']	     = $row->orderStatusId;	
				$returnArr['orderActiveStatus']  = $row->active;			
				$returnArr['customerOrderId']    = $row->customOrderId;
				$returnArr['orderDate']          = $row->createDt;
				$returnArr['trackingNbr']        = $row->trackingNbr;
				$returnArr['deliveredDate']      = $row->deliveredDate;
				$returnArr['isEconomicDelivery'] = $row->isEconomicDelivery;
				$returnArr['isCalculateShipp']   = $row->isCalculateShipp;
				$returnArr['productWeight']      = $row->totalProductWeight;
				$returnArr['toDropshipId']       = $row->toDropshipId;
			}
			
			$trackOrderTime = $this->CI->order_m->track_order_time_details($orderDetails[0]->orderId);
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
			
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($orderDetails[0]->customerId);
			if(!empty($customerDetails))
			{
				$returnArr['customerFirstName'] = $customerDetails->firstName;
				$returnArr['customerLastName']	= $customerDetails->lastName;
				$returnArr['customerPhone']	   	= $customerDetails->phone;	
				$returnArr['customerEmail']	   	= $customerDetails->email;
			}
			
			if((!empty($orderDetails[0]->finalShippingOrgId))&&($orderDetails[0]->finalShippingOrgId))
			{
				$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($orderDetails[0]->finalShippingOrgId);
				if(!empty($shipperDetails))
				{
					$returnArr['vendorBusinessName'] 	  = $shipperDetails->organizationName;
					$returnArr['vendorFirstName'] 		  = $shipperDetails->firstName;
					$returnArr['vendorLastName'] 		  = $shipperDetails->lastName;
					$returnArr['vendorEmail'] 			  = $shipperDetails->email;
					$returnArr['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
					$returnArr['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
					$returnArr['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
					$returnArr['vendorCountryName'] 	  = $shipperDetails->countryName;
					$returnArr['vendorStateName'] 		  = $shipperDetails->stateName;
					$returnArr['vendorCityName'] 		  = $shipperDetails->cityName;
					$returnArr['vendorAreaName'] 		  = $shipperDetails->areaName;
					
					$shippRateDet = $this->CI->order_m->shipping_rate_details($orderDetails[0]->finalShippingOrgId,$orderDetails[0]->finalShippingRateId);
					if(!empty($shippRateDet))
					{
						$returnArr['shippingRate'] = $shippRateDet->amount;
						if((!empty($returnArr['productWeight']))&&($returnArr['productWeight']>10))
						{
							$returnArr['shippingRate'] = $shippRateDet->amount*$returnArr['productWeight'];
						}					
					}
				}
			}
			
			if((!empty($orderDetails[0]->organizationProductId))&&($orderDetails[0]->organizationProductId))
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($orderDetails[0]->organizationProductId);
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
			}
			
			$billingDetails  = $this->CI->order_m->order_billing_address_details($orderDetails[0]->customerId,$orderDetails[0]->orderId);
			$shippingDetails = $this->CI->order_m->order_shipping_address_details($orderDetails[0]->customerId,$orderDetails[0]->orderId);
			if(empty($billingDetails))
			{
				$billingDetails = $this->CI->customer_m->user_profile_details($orderDetails[0]->customerId);				
			}
			
			if(!empty($billingDetails))
			{
				$returnArr['customerBillFirstName'] = $billingDetails->firstName;
				$returnArr['customerBillLastName']  = $billingDetails->lastName;
				$returnArr['customerBillPhone']     = $billingDetails->phone;
				
				if(empty($billingDetails->firstName))
				{				
					$returnArr['customerBillFirstName'] = $returnArr['customerFirstName'];
				}
				if(empty($billingDetails->lastName))
				{
					$returnArr['customerBillLastName'] = $returnArr['customerLastName'];
				}
				if(empty($billingDetails->phone))
				{
					$returnArr['customerBillPhone'] = $returnArr['customerPhone'];
				}
				
				$returnArr['billingCountry']        = $billingDetails->countryName;
				$returnArr['billingState']    	    = $billingDetails->stateName;
				$returnArr['billingArea']   	    = $billingDetails->areaName;
				$returnArr['billingCity']     	    = $billingDetails->cityName;
				$returnArr['billingAddressLine1']   = $billingDetails->addressLine1;
				$returnArr['billingAddressLine2']   = $billingDetails->address_Line2;
			}
			
			if(!empty($shippingDetails))
			{
				$returnArr['customerShippFirstName'] = $shippingDetails->firstName;
				$returnArr['customerShippLastName']	 = $shippingDetails->lastName;
				$returnArr['customerShippPhone']	 = $shippingDetails->phone;	
			}
			
			if(!empty($shippingDetails))
			{
				$returnArr['shippingCountry']      = $shippingDetails->countryName;
				$returnArr['shippingState']    	   = $shippingDetails->stateName;
				$returnArr['shippingArea'] 	       = $shippingDetails->areaName;
				$returnArr['shippingCity']     	   = $shippingDetails->cityName;
				$returnArr['shippingAddressLine1'] = $shippingDetails->addressLine1;
				$returnArr['shippingAddressLine2'] = $shippingDetails->address_Line2;
			}
			//echo "<pre>"; print_r($returnArr); exit;
			if((!empty($returnArr['toDropshipId']))&&($returnArr['toDropshipId']))
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($returnArr['toDropshipId']);
				if(!empty($dropshipDetails))
				{
					$returnArr['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$returnArr['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
		}
		return $returnArr;
	}
	
	public function delete_order($orderId)
	{
		$getDetails = $this->CI->order_m->order_details($orderId);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{	
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$this->CI->order_m->cancel_order_details($customOrderDet->orderDetailId);
					
					if($this->CI->order_m->increase_product_quantity($customOrderDet->organizationProductId,$customOrderDet->quantity))
							{
								$this->CI->custom_log->write_log('custom_log','prdouct quantity increase successfully');
								
								if((!empty($customOrderDet->colorId))&&($customOrderDet->colorId)&&(!empty($customOrderDet->productSizeId))&&($customOrderDet->productSizeId))
								{
									if($this->CI->order_m->increase_product_color_size_quantity($customOrderDet->organizationProductId,$customOrderDet->colorId,$customOrderDet->productSizeId,$customOrderDet->quantity))
									{
										$this->CI->custom_log->write_log('custom_log','prdouct color size quantity increase successfully');
									}
									else
									{
										$this->CI->custom_log->write_log('custom_log','product color size quantity not increase last query is '.$this->CI->db->last_query());
									}
								}
								elseif((!empty($customOrderDet->colorId))&&($customOrderDet->colorId))
								{
									if($this->CI->order_m->increase_product_color_quantity($customOrderDet->organizationProductId,$customOrderDet->colorId,$customOrderDet->quantity))
									{
										$this->CI->custom_log->write_log('custom_log','prdouct color quantity increase successfully');
									}
									else
									{
										$this->CI->custom_log->write_log('custom_log','product color quantity not increase last query is '.$this->CI->db->last_query());
									}
								}
								elseif((!empty($customOrderDet->productSizeId))&&($customOrderDet->productSizeId))
								{
									if($this->CI->order_m->increase_product_size_quantity($customOrderDet->organizationProductId,$customOrderDet->productSizeId,$customOrderDet->quantity))
									{
										$this->CI->custom_log->write_log('custom_log','prdouct size quantity increase successfully');
									}
									else
									{
										$this->CI->custom_log->write_log('custom_log','product size quantity not increase last query is '.$this->CI->db->last_query());
									}
								}
							}
							else
							{
								$this->CI->custom_log->write_log('custom_log','product quantity not increase last query is '.$this->CI->db->last_query());
							}
				}
			}
			
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
			$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
			
			$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
			$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
			
			if((!empty($getDetails->organizationProductId))&&($getDetails->organizationProductId))
			{
				
			}
			
			/******Mail for Custmer*******/
			if(!empty($customerDetails))
			{				
				$mailData = array(
								'email'        => $customerDetails->email,
								'cc'	       => '',
								'slug'         => 'order_false_for_customer',
								'customerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
								'subject'  	   => 'Order has been deleted',
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
								'email'      => $retailerDetails->email,
								'cc'	     => '',
								'slug'       => 'order_false_for_retailer',
								'sellerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
								'orderId'	 => $getDetails->customOrderId,
								'subject'  	 => 'Order has been deleted',
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
			
			if($this->CI->order_m->cancel_order($orderId))
			{
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');	
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
			$this->CI->custom_log->write_log('custom_log','last querty is '.$this->CI->db->last_query());
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/order_management');
	}
	
	public function delete_economic_order($orderId)
	{
		$getDetails = $this->CI->order_m->economic_order_details($orderId);
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true)); 	
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_custom_payment_details($orderId);
			if(!empty($customOrderDet))
			{
				$this->CI->order_m->cancel_single_shippment_order($customOrderDet[0]->orderCustomPaymentId);
				foreach($customOrderDet as $customRow)
				{
					if($this->CI->order_m->cancel_order_details($customRow->orderDetailId))
					{
						if($this->CI->order_m->increase_product_quantity($customRow->organizationProductId,$customRow->quantity))
						{
							$this->CI->custom_log->write_log('custom_log','prdouct quantity increase successfully');
							
							if((!empty($customRow->colorId))&&($customRow->colorId)&&(!empty($customRow->productSizeId))&&($customRow->productSizeId))
							{
								if($this->CI->order_m->increase_product_color_size_quantity($customRow->organizationProductId,$customRow->colorId,$customRow->productSizeId,$customRow->quantity))
								{
									$this->CI->custom_log->write_log('custom_log','prdouct color size quantity increase successfully');
								}
								else
								{
									$this->CI->custom_log->write_log('custom_log','product color size quantity not increase last query is '.$this->CI->db->last_query());
								}
							}
							elseif((!empty($customRow->colorId))&&($customRow->colorId))
							{
								if($this->CI->order_m->increase_product_color_quantity($customRow->organizationProductId,$customRow->colorId,$customRow->quantity))
								{
									$this->CI->custom_log->write_log('custom_log','prdouct color quantity increase successfully');
								}
								else
								{
									$this->CI->custom_log->write_log('custom_log','product color quantity not increase last query is '.$this->CI->db->last_query());
								}
							}
							elseif((!empty($customRow->productSizeId))&&($customRow->productSizeId))
							{
								if($this->CI->order_m->increase_product_size_quantity($customRow->organizationProductId,$customRow->productSizeId,$customRow->quantity))
								{
									$this->CI->custom_log->write_log('custom_log','prdouct size quantity increase successfully');
								}
								else
								{
									$this->CI->custom_log->write_log('custom_log','product size quantity not increase last query is '.$this->CI->db->last_query());
								}
							}
							
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log','product quantity not increase last query is '.$this->CI->db->last_query());
						}
					}
				}
			}
			
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails[0]->customerId);
			$this->CI->custom_log->write_log('custom_log','Customer details is '.print_r($customerDetails,true));
			
			$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
			$this->CI->custom_log->write_log('custom_log','Retailer details is '.print_r($retailerDetails,true));
			
			/******Mail for Custmer*******/
			if(!empty($customerDetails))
			{				
				$mailData = array(
								'email'        => $customerDetails->email,
								'cc'	       => '',
								'slug'         => 'order_false_for_customer',
								'customerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
								'subject'  	   => 'Order has been deleted',
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
								'email'      => $retailerDetails->email,
								'cc'	     => '',
								'slug'       => 'order_false_for_retailer',
								'sellerName' => $customerDetails->firstName.' '.$customerDetails->lastName,
								'orderId'	 => $orderId,
								'subject'  	 => 'Order has been deleted',
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
			
			if($this->CI->order_m->cancel_economic_order($orderId))
			{
				$this->CI->session->set_flashdata('success','Order deleted successfully');
				$this->CI->custom_log->write_log('custom_log','Order deleted successfully');	
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order not deleted');
				$this->CI->custom_log->write_log('custom_log','Order not deleted');	
			}
			$this->CI->custom_log->write_log('custom_log','last querty is '.$this->CI->db->last_query());
		}
		else
		{
			$this->CI->session->set_flashdata('error','Order details not found');
		}
		redirect(base_url().$this->CI->session->userdata('userType').'/order_management');
	}
	
	public function change_confirm_order_to_ready_order($orderID)
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
					$orderTrackId = $this->CI->order_m->add_order_custom_track($customOrderDet->orderDetailId,3);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					if($this->CI->order_m->custom_change_confirm_to_ready($customOrderDet->orderDetailId))
					{
					}
				}
				
			}
			
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
			
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase');
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
					$size  = '';
					
					$dropShipAddress = '';
					$dropshipAddDet = $this->CI->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}

					/*******Mail for Customer*****************/
					$mailData = array(
									'email'           => $customerDetails->email,
									'cc'	          => '',
									'slug'            => 'reay_to_shipp_order_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $this->CI->config->item('pre_orderId').$getDetails->customOrderId,
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
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log','Mail Send Successfully');
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log','Mail Not Send');
					}
					
					/*******Mail for Shipping Vendor*****************/
					$mailData = array(
									'email'           => $rateDetails->email,
									'cc'	          => '',
									'slug'            => 'ready_to_transit_for_shipper',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $this->CI->config->item('pre_orderId').$getDetails->customOrderId,
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
					
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log','Mail Send Successfully');
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log','Mail Not Send');
					}
						
					$orderTrackId = $this->CI->order_m->add_order_track_details($orderID,3);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					
					if($this->CI->order_m->change_confirm_to_ready($orderID))
					{
                    	$message = '('. $this->CI->config->item('pre_orderId').$getDetails->customOrderId.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
                        $response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
						$this->CI->session->set_flashdata('success','Order status changed successfully');
						$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
					$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
				$this->CI->custom_log->write_log('custom_log','Customer details not found');
			}	
		}
	}
	
	public function change_confirm_pickup_order_to_ready_pickup_order($orderID)
	{
		$getDetails = $this->CI->order_m->order_details($orderID); 
		$this->CI->custom_log->write_log('custom_log','order details is '.print_r($getDetails,true));
		
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{	
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$orderTrackId = $this->CI->order_m->add_order_custom_track($customOrderDet->orderDetailId,3);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					if($this->CI->order_m->custom_change_confirm_to_ready($customOrderDet->orderDetailId))
					{
					}
				}
				
			}
			
			$customerDetails = $this->CI->customer_m->customer_details($getDetails->customerId);
			$this->CI->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));
				
			if(!empty($customerDetails))
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
				$this->CI->custom_log->write_log('custom_log','retailer details is '.print_r($retailerDetails,true));
				$estimateDay     = $this->CI->config->item('estimated_time_increase');
				$shippingVendor  = '';
				$shippingDetails = $this->CI->order_m->order_shipping_address_details($getDetails->customerId,$getDetails->orderId);
				$this->CI->custom_log->write_log('custom_log','shipping details is '.print_r($shippingDetails,true));
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
				$pickupDetails = $this->CI->cart_m->pickup_details($getDetails->pickupId);
				$this->CI->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
				$mailData = array(
								'email'           => $customerDetails->email,
								'cc'	          => '',
								'slug'            => 'ready_to_pickup_order_for_customer',
								'name'            => $customerDetails->firstName.' '.$customerDetails->lastName,
								'customerPhone'	  => $customerDetails->phone,
								'orderId'		  => $getDetails->customOrderId,
								'eta'			  => $estimateDay,
								'shippingVendor'  => $shippingVendor,
								'shippingAddName' => $shippingAddName,
								'shippingAddress' => $shippingAddress,
								'retailerName'    => $retailerDetails->organizationName,
								'imagePath'		  => $imagePath,
								'productName'	  => $retailerDetails->code,
								'productPrice'	  => number_format($getDetails->chargedAmount,2),
								'quantity'		  => $getDetails->quantity,
								'totalPrice'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
								'color'			  => $color,
								'size'			  => $size,
								'totalSumPrice'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
								'subject'  		  => 'Your Order Is Ready To Be Pickup',
								'pickupCenter'		=> $pickupDetails->pickupName,
								'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
								'pickupPhoneno' => $pickupDetails->phone,
							);
				$this->CI->custom_log->write_log('custom_log','mail data is '.print_r($mailData,true));
				if($this->CI->email_m->send_mail($mailData))
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
				}
				
				$orderTrackId = $this->CI->order_m->add_order_track_details($orderID,3);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->change_confirm_to_ready($orderID))
				{
                	$customer_message = substr($retailerDetails->code,0,20).', order # '.$getDetails->customOrderId.',  has been packed, Please collect it from '.$pickupDetails->pickupName;
					$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
					$this->CI->session->set_flashdata('success','Order status changed successfully');
					$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
			}	
		}
	}
	
	public function change_ready_order_to_shipped_order($orderID)
	{
		$getDetails = $this->CI->order_m->ready_shipped_order_details($orderID); 
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true));
		
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{	
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$orderTrackId = $this->CI->order_m->add_order_custom_track($customOrderDet->orderDetailId,4);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					if($this->CI->order_m->custom_change_ready_to_shipped_in($customOrderDet->orderDetailId))
					{
					}
				}
				
			}
			
			if($this->CI->order_m->change_ready_to_shipped_in($orderID))
			{
				$orderTrackId = $this->CI->order_m->add_order_track_details($orderID,4);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					
				//	Customer Information
				$customerDetails = $this->CI->customer_m->get_customer_user_detail($getDetails->customerId);

				//	Retailer Infromation
				$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
				//echo "<pre>";	print_r($retailerDetails); exit;	
				//	Shipping Vendor Infromation
				$vendorDetails = $this->CI->user_m->shipping_vendor_user_details($getDetails->shippingOrgId);
				$shippRateDet  = $this->CI->user_m->shipping_rate_details($getDetails->shippingRateId,$getDetails->shippingOrgId);
				$deliveredDate =  '';
				$estimateDay   = 0;
				if(!empty($shippRateDet))
				{
					$orderDate = date('Y-m-d',$getDetails->createDt+strtotime('+ '.$shippRateDet->ETA.' days'));
					$deliveredDate = date('d F Y',strtotime($orderDate));
					$estimateDay   = $shippRateDet->ETA;
				}				

				if((!empty($customerDetails))&&(!empty($retailerDetails))&&(!empty($vendorDetails)))
				{
					$customerOrderId = $this->CI->config->item('pre_orderId').$getDetails->customOrderId;
					if((!empty($getDetails->productImageName))&&(file_exists('uploads/product/'.$getDetails->productImageName)))
					{
						$imageUrl = base_url().'uploads/product/'.$row->productImageName;
					}
					else
					{
						$imageUrl = base_url().'img/no_image.jpg';
					}
								
					$shippingAddress = '';
					$shippingDetails = $this->CI->user_m->user_shipping_details($getDetails->customerId);
					//	echo "<pre>";	print_r($shippingDetails); exit;
					if(!empty($shippingDetails))
					{
						$shippingAddress = ucwords($shippingDetails->firstName.' '.$shippingDetails->lastName).' ,'.$shippingDetails->phone.', '.$shippingDetails->addressLine1.' '.$shippingDetails->address_Line2.' ,'.$shippingDetails->cityName.' '.$shippingDetails->stateName.' '.$shippingDetails->countryName;
					}
						
					$shippRateDetails = $this->CI->user_m->shipping_vendor_rateDetails($getDetails->shippingRateId);
					$totalAmt = ($shippRateDetails->amount*$getDetails->quantity)+($retailerDetails->currentPrice*$getDetails->quantity);
					$mailData = array(
									'email'           => $customerDetails->email,
									'cc'	          => '',
									'slug'            => 'shipped_in_transit_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
									'eta'			  => $estimateDay,
									'shippingVendor'  => '',
									'shippingAddName' => $shippingAddress,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerDetails->organizationName,
									'productImage'	  => $imageUrl,
									'productName'	  => $retailerDetails->code,
									'productPrice'	  => number_format($retailerDetails->currentPrice,2),
									'currentPrice'    => number_format($retailerDetails->currentPrice,2),
									'quantity'		  => $getDetails->quantity,
									'totalAmount'	  => number_format($retailerDetails->currentPrice*$getDetails->quantity,2),
									'subTotal'	  => number_format($retailerDetails->currentPrice*$getDetails->quantity,2),
									'subject'  		  => 'Your Order has been Shipped in transit',
									'size' => '',
									'color' => '',
									);	
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
						
					$message = $retailerDetails->code.' was shipped at '.date('d F Y , H:i A',strtotime($getDetails->lastModifiedDt)).' and will be delivered by '.$deliveredDate.'. Tracking no for this shipment is '.$getDetails->trackingNbr.'. For any queries kindly feel free to call us at '.$this->CI->config->item('admin_phone_no').' or email us at '.$this->CI->config->item('admin_email');
					$response = $this->CI->twillo_m->send_mobile_message($customerDetails->phone,$message);
					$this->CI->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
				
				}
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_ready_to_shipped_to_transit'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_ready_to_shipped_to_transit'));
			}
			else
			{
				$this->CI->session->set_flashdata('error','Order status not change');
				$this->CI->custom_log->write_log('custom_log','Order status not change');
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
		}
	}
	
	public function change_ready_pickup_to_order_pickup($orderID)
	{
		$getDetails = $this->CI->order_m->ready_shipped_order_details($orderID); 
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$orderTrackId = $this->CI->order_m->add_order_custom_track($customOrderDet->orderDetailId,5);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					if($this->CI->order_m->custom_change_shipped_to_delivered($customOrderDet->orderDetailId))
					{
					}
				}
			}
			
			$customerDetails = $this->CI->customer_m->customer_details($getDetails->customerId);
			if(!empty($customerDetails))
			{
				$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
				$estimateDay     = $this->CI->config->item('estimated_time_increase');
				$shippingVendor  = '';
				$shippingDetails = $this->CI->order_m->order_shipping_address_details($getDetails->customerId,$getDetails->orderId);
				$this->CI->custom_log->write_log('custom_log','shipping details is '.print_r($shippingDetails,true));
				$shippingAddName = $shippingDetails->firstName.' '.$shippingDetails->lastName;
				$shippingAddress = ucwords($shippingDetails->firstName.' '.$shippingDetails->lastName).' ,'.$shippingDetails->phone.', '.$shippingDetails->addressLine1.' '.$shippingDetails->address_Line2.' ,'.$shippingDetails->cityName.' '.$shippingDetails->areaName.' '.$shippingDetails->stateName.' '.$customerDetails->countryName;
				$imagePath = base_url().'img/no_image.jpg';
				$color = '';
				$size  = '';
				if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/thumb500_500/'.$retailerDetails->imageName)))
				{
					$imagePath = base_url().'uploads/product/thumb500_500/'.$retailerDetails->imageName;
				}
				elseif((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
				{
					$imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
				}
				$pickupDetails = $this->CI->cart_m->pickup_details($getDetails->pickupId);
				$this->CI->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
				
				/*****Mail for customer******/
				$mailData = array(
								'email'           => $customerDetails->email,
								'cc'	          => '',
								'slug'            => 'pickup_ready_to_complete_order_for_customer',
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
								'subject'  		  => 'Your Order Is In Transit',
								'pickupCenter'		=> $pickupDetails->pickupName,
								'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
								'pickupDate'	=> date('Y-m-d',strtotime('+ '.$estimateDay.' days')),
							);
				
				if($this->CI->email_m->send_mail($mailData))
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
				}
				/*****Mail for retailer******/
				$mailData = array(
								'email'           => $rateDetails->email,
								'cc'	          => '',
								'slug'            => 'pickup_ready_to_complete_order_for_retailer',
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
								'subject'  		  => 'Your Order Is In Transit',
								'pickupCenter'		=> $pickupDetails->pickupName,
								'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
								'pickupDate'	=> date('Y-m-d',strtotime('+ '.$estimateDay.' days')),
							);
				
				if($this->CI->email_m->send_mail($mailData))
				{
					$this->CI->custom_log->write_log('custom_log','mail send to retailer');
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
				}
				$orderTrackId = $this->CI->order_m->add_order_track_details($orderID,5);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->change_to_pickup($orderID))
				{
                	$retailer_message = 'Your product '.substr($retailerDetails->code,0,20).' has been delivered to Customer.';
					$response = $this->CI->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
					$customer_message = 'Thank you for collecting your order;  tracking #'.$getDetails->trackingNbr.'  from '.$pickupDetails->pickupName.' Center. Thank you for shopping at PointeMart';
					$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
					$this->CI->session->set_flashdata('success','Order status changed successfully');
					$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
			}	
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
			$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_ready_to_shipped_to_transit'));
		}
	}
	
	public function change_shipped_order_to_delivered_order($orderID)
	{	
		$getDetails = $this->CI->order_m->transit_order_details($orderID); 
		
		if(!empty($getDetails))
		{
			$customOrderDet = $this->CI->order_m->order_organization_custom_payment_details($getDetails->customOrderId,$getDetails->organizationProductId);
			if(!empty($customOrderDet))
			{	
				if((!empty($customOrderDet->orderDetailId))&&($customOrderDet->orderDetailId))
				{
					$orderTrackId = $this->CI->order_m->add_order_custom_track($customOrderDet->orderDetailId,5);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					if($this->CI->order_m->custom_change_shipped_to_delivered($customOrderDet->orderDetailId))
					{
					}
				}
				
			}
			
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails->organizationProductId);
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase');
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
					$size = '';
					/****Mail for customer*******/
					$mailData = array(
									'email'           => $customerDetails->email,
									'cc'	          => '',
									'slug'            => 'delivered_order_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
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
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
						
					/****Mail for retailer*******/
					$mailData = array(
									'email'           => $rateDetails->email,
									'cc'	          => '',
									'slug'            => 'delivered_order_for_retailer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
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
								
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
						
					/****Mail for Shipping Vendor*******/
					$mailData = array(
									'email'           => $rateDetails->email,
									'cc'	          => '',
									'slug'            => 'delivered_order_for_shipper',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $getDetails->customOrderId,
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
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
						
					$orderTrackId = $this->CI->order_m->add_order_track_details($orderID,5);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					if($this->CI->order_m->change_shipped_to_delivered($orderID))
					{
                    	$message = 'Thank you for your delivery confirmation of order # '.$getDetails->customOrderId.' to '.$customerDetails->cityName.'.';
						$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
						$retailer_message = substr($retailerDetails->code,0,20).' has been delivered to Customer.';
						$response = $this->CI->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
                        $customer_message = substr($retailerDetails->code,0,20).', order # '.$getDetails->customOrderId.' has been delivered. Thank you for shopping at PointeMart.';
						$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);

                        $this->CI->session->set_flashdata('success','Order status changed successfully');
						$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
			}	
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_transit_to_delivered'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_transit_to_delivered'));
		}	
		redirect(base_url().$this->CI->session->userdata('userType').'/order_management');	
	}
	
	public function economic_change_confirm_order_to_ready_order($orderID)
	{
		$customOrderDet = $this->CI->order_m->order_custom_payment_details($orderID);
		if(!empty($customOrderDet))
		{
			foreach($customOrderDet as $customRow)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($customRow->orderDetailId,3);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_confirm_to_ready($customRow->orderDetailId))
				{
	            }
			}
		}
		
		$getDetails = $this->CI->order_m->economic_order_details($orderID); 
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true));
		//echo "<pre>"; print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails[0]->customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($getDetails[0]->shippingRateId);
			
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
					
					$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
                    $shippingVendor  = $rateDetails->organizationName;
					$shippingVendorEmail  = $rateDetails->email;
					$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                    $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
					
					$dropShipAddress = '';
					$dropshipAddDet = $this->CI->retailer_m->dropship_details($retailerDetails->dropshipCentre);
					if(!empty($dropshipAddDet))
					{
						$dropShipAddress = $dropshipAddDet->addressLine1;
					}


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
						$retailerPrdArr['tracking_no']	       = $row->trackingNbr;
						
					}
					
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
							}
						}
						$mailContent.= '</tbody></table>';
						/********Mail for customer********************/
						$mailData = array(
										'email'           => $customerDetails->email,
										'cc'			  => '',
										'slug'            => 'economic_reay_to_shipp_order_for_customer',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'subject'  		  => 'Your Order Is Ready To Be Shipped',
									);					
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						
						/********Mail for shipping vendor********************/
						$mailData = array(											
										'email'           => $shippingVendorEmail,
										'cc'			  => '',
										'slug'            => 'economic_ready_to_transit_for_shipper',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'tracking_no'     => $retailerPrdArr['tracking_no'],
										'dp_center_name'  => $retailerPrdArr['dropCenterName'],
										'dropShipCenterAddress' => $dropShipAddress,										
										'subject'  		  => 'Your Order Has Been Confirmed',
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						/********Mail for shipping vendor********************/
					}
					//echo "<pre>"; print_r($retailerPrdArr); exit;	
					foreach($getDetails AS $row)	
					{
						$orderTrackId = $this->CI->order_m->add_order_track_details($row->orderId,3);
						$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
						
						if($this->CI->order_m->change_confirm_to_ready($row->orderId))
						{
							$message = '('.$orderID.')  is ready to be shipped to '.$customerDetails->areaName.','.$customerDetails->cityName.' Collect it from '.$retailerDetails->dropCenterName ;
							$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
							$this->CI->session->set_flashdata('success','Order status changed successfully');
							$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
						}
						
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');
					$this->CI->custom_log->write_log('custom_log','Shipping vendor rate details not found');							
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
				$this->CI->custom_log->write_log('custom_log','Customer details not found');
			}	
		}
	}
	
	public function economic_change_ready_order_to_shipped_order($orderID)
	{
		$customOrderDet = $this->CI->order_m->order_custom_payment_details($orderID);
		if(!empty($customOrderDet))
		{
			foreach($customOrderDet as $customRow)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($customRow->orderDetailId,4);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_ready_to_shipped_in($customRow->orderDetailId))
				{
	            }
			}
		}
		
		$getDetails = $this->CI->order_m->economic_order_details($orderID); 
		$this->CI->custom_log->write_log('custom_log','Order details is '.print_r($getDetails,true));
		//echo "<pre>"; print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			//	Customer Information
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($getDetails[0]->customerId);
			
			//	Retailer Infromation
			$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
			
			//	Shipping Vendor Infromation
			$vendorDetails = $this->CI->user_m->shipping_vendor_user_details($getDetails[0]->shippingOrgId);
			$shippRateDet  = $this->CI->user_m->shipping_rate_details($getDetails[0]->shippingRateId,$getDetails[0]->shippingOrgId);
			
			$shippingAddress = '';
			$shippingDetails = $this->CI->user_m->user_shipping_details($getDetails[0]->customerId);
			
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
						
				if($this->CI->order_m->change_ready_to_shipped_in($row->orderId))
				{
					$orderTrackId = $this->CI->order_m->add_order_track_details($row->orderId,4);
					$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
					
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_ready_to_shipped_to_transit'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_ready_to_shipped_to_transit'));
				}
				else
				{
					$this->CI->session->set_flashdata('error','Order status not change');
					$this->CI->custom_log->write_log('custom_log','Order status not change');
				}
			}
			
			$estimateDay     = $shippRateDet->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
			$shippingVendor  = $vendorDetails->organizationName;
			$shippingVendorEmail  = $vendorDetails->email;
			$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
            $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
						
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
						
						$deliveredDate =  '';
						if(!empty($shippRateDet))
						{
							$orderDate = date('Y-m-d',$getDetails[0]->createDt+strtotime('+ '.$shippRateDet->ETA.' days'));
							$deliveredDate = date('d F Y',strtotime($orderDate));
						}
						$message = $prodctRow['productName'].' was shipped at '.date('d F Y , H:i A',strtotime($getDetails[0]->lastModifiedDt)).' and will be delivered by '.$deliveredDate.'. Tracking no for this shipment is '.$getDetails[0]->trackingNbr.'. For any queries kindly feel free to call us at '.$this->CI->config->item('admin_phone_no').' or email us at '.$this->CI->config->item('admin_email');
						$response = $this->CI->twillo_m->send_mobile_message($customerDetails->phone,$message);
						$this->CI->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
					}
				}
				$mailContent.= '</tbody></table>';
				/********Mail for customer********************/
				$mailData = array(								
								'email'           => $customerDetails->email,
								'cc'			  => '',
								'slug'            => 'economic_shipped_in_transit_for_customer',
								'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
								'customerPhone'	  => $customerDetails->phone,
								'orderId'		  => $orderID,
								'eta'			  => $estimateDay,
								'shippingVendor'  => $shippingVendor,
								'shippingAddName' => $shippingAddName,
								'shippingAddress' => $shippingAddress,
								'sellerName'      => $retailerPrdArr['retailerName'],
								'mailContent'	  => $mailContent,
								'totalAmount'	  => number_format($amount,2),
								'subject'  		  => 'Your Order has been Shipped in transit',
							);	
				if($this->CI->email_m->send_mail($mailData))
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
				}
				/********Mail for customer********************/
			}
			//echo "<pre>"; print_r($retailerPrdArr); exit;
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_ready_to_shipped_to_transit'));
		}
	}
	
	public function economic_change_shipped_order_to_delivered_order($orderID)
	{	
		$customOrderDet = $this->CI->order_m->order_custom_payment_details($orderID);
		if(!empty($customOrderDet))
		{
			foreach($customOrderDet as $customRow)
			{
				$orderTrackId = $this->CI->order_m->add_order_custom_track($customRow->orderDetailId,5);
				$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
				if($this->CI->order_m->custom_change_shipped_to_delivered($customRow->orderDetailId))
				{
	            }
			}
		}
		
		$getDetails = $this->CI->order_m->economic_order_details($orderID); 
		$retailerPrdArr = array();
		//echo "<pre>"; print_r($getDetails); exit;
		if(!empty($getDetails))
		{
			$customerDetails = $this->CI->customer_m->get_customer_with_shipping_detail($getDetails[0]->customerId);
			$rateDetails     = $this->CI->shipping_m->shipping_vendor_details($getDetails[0]->shippingRateId);
			
			$estimateDay     = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
            $shippingVendor  = $rateDetails->organizationName;
			$shippingVendorEmail  = $rateDetails->email;
			$shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
            $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;
						
			if(!empty($customerDetails))
			{
				if(!empty($rateDetails))
				{
					$retailerDetails = $this->CI->order_m->order_retailer_details($getDetails[0]->organizationProductId);
					foreach($getDetails as $row)
					{
						$orderTrackId = $this->CI->order_m->add_order_track_details($row->orderId,5);
						$this->CI->custom_log->write_log('custom_log','order track id is '.$orderTrackId);
						if($this->CI->order_m->change_shipped_to_delivered($row->orderId))
						{
	                    }
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_new_order_to_ready_to_shipped'));
						}
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping vendor rate details not found');							
				}
				
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
						}
					}
					$mailContent.= '</tbody></table>';
					
					/********Mail for customer********************/
                    $mailData = array(
									'email'           => $customerDetails->email,
									'cc'			  => '',
									'slug'            => 'economic_delivered_order_for_customer',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $orderID,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerPrdArr['retailerName'],
									'mailContent'	  => $mailContent,
									'totalAmount'	  => number_format($amount,2),
									'subject'  		  => 'Your Order Has Been Delivered',
								);	
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}				
					/********Mail for customer********************/
					
					/********Mail for retailer********************/
					if(!empty($retailerPrdArr['retailerEmail']))
					{
						$mailData = array(
										'email'           => $retailerPrdArr['retailerEmail'],
										'cc'			  => '',
										'slug'            => 'economic_delivered_order_for_retailer',
										'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
										'customerPhone'	  => $customerDetails->phone,
										'orderId'		  => $orderID,
										'eta'			  => $estimateDay,
										'shippingVendor'  => $shippingVendor,
										'shippingAddName' => $shippingAddName,
										'shippingAddress' => $shippingAddress,
										'sellerName'      => $retailerPrdArr['retailerName'],
										'mailContent'	  => $mailContent,
										'totalAmount'	  => number_format($amount,2),
										'subject'  		  => 'Your Order Has Been Confirmed',
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
					}
					/********Mail for retailer********************/
					
					/****Mail for Shipping Vendor*******/
					$mailData = array(
									'email'           => $shippingVendorEmail,
									'cc'			  => '',
									'slug'            => 'economic_delivered_order_for_shipper',
									'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
									'customerPhone'	  => $customerDetails->phone,
									'orderId'		  => $orderID,
									'eta'			  => $estimateDay,
									'shippingVendor'  => $shippingVendor,
									'shippingAddName' => $shippingAddName,
									'shippingAddress' => $shippingAddress,
									'sellerName'      => $retailerPrdArr['retailerName'],
									'mailContent'	  => $mailContent,
									'totalAmount'	  => number_format($amount,2),
									'subject'  		  => 'Your Order Has Been Confirmed',
									'custoemerCity'   => $customerDetails->cityName,
								);
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}
					
					$message = 'Thank you for your delivery confirmation of order # '.$orderID.' to '.$customerDetails->cityName.'.';
					$response = $this->CI->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone ,$message);
					$retailer_message = $orderID.' has been delivered to Customer.';
					$response = $this->CI->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone,$retailer_message);
            	    $customer_message = 'order # '.$orderID.' has been delivered. Thank you for shopping at PointeMart.';
					$response = $this->CI->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
					$this->CI->session->set_flashdata('success','Order status changed successfully');
					$this->CI->custom_log->write_log('custom_log','Order status changed successfully');
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Customer details not found');
			}	
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_transit_to_delivered'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_transit_to_delivered'));
		}	
		redirect(base_url().$this->CI->session->userdata('userType').'/order_management');	
	}
	
	public function ajax_order_search_list()
	{
		$return    = array();
		$perPage   = $this->CI->input->post('sel_no_entry');
		$sorting   = $this->CI->input->post('sorting');
		$search    = trim($this->CI->input->post('search'));
		$where 	   = '';		
		
		$searchDropship  = $this->CI->input->post('dropship');
		$searchOrderSts  = $this->CI->input->post('orderStatus');
		$cusDetDrp       = $this->CI->input->post('cusDetDrp');
		$cusDetTxt       = $this->CI->input->post('cusDetTxt');
		$retDetDrp       = $this->CI->input->post('retDetDrp');
		$retDetTxt       = $this->CI->input->post('retDetTxt');
		$prdDetDrp       = $this->CI->input->post('prdDetDrp');
		$prdDetTxt       = $this->CI->input->post('prdDetTxt');
		$ordrDetDrp      = $this->CI->input->post('ordrDetDrp');
		$ordrDetTxt      = $this->CI->input->post('ordrDetTxt');
		
		if(!empty($searchDropship))
		{
			if(!empty($where))
			{
				$where.= ' AND dropship_center.dropCenterName Like "'.$searchDropship.'%"';
			}
			else
			{
				$where = 'dropship_center.dropCenterName Like "'.$searchDropship.'%"';
			}
		}
		
		if(!empty($searchOrderSts))
		{
			$ordrSts = '';
			if($searchOrderSts==1)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 1)';
			}
			elseif($searchOrderSts==2)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 1)';
			}
			elseif($searchOrderSts==3)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 2)';
			}
			elseif($searchOrderSts==4)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 2)';
			}
			elseif($searchOrderSts==5)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 3)';
			}
			elseif($searchOrderSts==6)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 3)';
			}
			elseif($searchOrderSts==7)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 4)';
			}
			elseif($searchOrderSts==8)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 0 AND order_details.orderStatusId = 5)';
			}
			elseif($searchOrderSts==9)
			{
				$ordrSts = '(order_details.active = 1 AND order_total.isPickup = 1 AND order_details.orderStatusId = 5)';
			}
			elseif($searchOrderSts==10)
			{
				$ordrSts = '(order_details.active = 0 AND order_details.orderStatusId = 6)';
			}
			
			if(!empty($ordrSts))
			{
				if(!empty($where))
				{
					$where.= ' AND '.$ordrSts;
				}
				else
				{
					$where = $ordrSts;
				}	
			}
		}
		
		if(!empty($cusDetDrp))		
		{
			if(!empty($cusDetTxt))
			{
				if(!empty($where))
				{
					if($cusDetDrp=='name')
					{
						$where.= ' AND CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='phone')
					{
						$where.= ' AND customer.phone Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='state')
					{
						$where.= ' AND state.stateName Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='area')
					{
						$where.= ' AND area.area Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='city')
					{
						$where.= ' AND zip.city Like "'.$cusDetTxt.'%"';
					}
				}
				else
				{					
					if($cusDetDrp=='name')
					{
						$where= 'CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='phone')
					{
						$where= 'customer.phone Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='state')
					{
						$where= 'state.stateName Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='area')
					{
						$where= 'area.area Like "'.$cusDetTxt.'%"';
					}
					elseif($cusDetDrp=='city')
					{
						$where= 'zip.city Like "'.$cusDetTxt.'%"';
					}				
				}
			}
		}
		elseif(!empty($cusDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%" OR customer.phone Like "'.$cusDetTxt.'%" OR state.stateName Like "'.$cusDetTxt.'%" OR area.area Like "'.$cusDetTxt.'%" OR zip.city Like "'.$cusDetTxt.'%" )';
			}
			else
			{
				$where.= '( CONCAT(customer.firstName," ",customer.lastName) Like "'.$cusDetTxt.'%" OR customer.phone Like "'.$cusDetTxt.'%" OR state.stateName Like "'.$cusDetTxt.'%" OR area.area Like "'.$cusDetTxt.'%" OR zip.city Like "'.$cusDetTxt.'%" )';
			}
		}
		
		if(!empty($retDetDrp))		
		{
			if(!empty($retDetTxt))
			{
				if(!empty($where))
				{
					if($retDetDrp=='name')
					{
						$where.= ' AND organization.organizationName Like "'.$retDetTxt.'%"';
					}
					elseif($retDetDrp=='phone')
					{
						$where.= ' AND employee.businessPhone Like "'.$retDetTxt.'%"';
					}
				}
				else
				{					
					if($retDetDrp=='name')
					{
						$where = 'organization.organizationName Like "'.$retDetTxt.'%"';
					}
					elseif($retDetDrp=='phone')
					{
						$where = 'employee.businessPhone Like "'.$retDetTxt.'%"';
					}
				}
			}
		}
		elseif(!empty($retDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( employee.businessPhone Like "'.$retDetTxt.'%" OR organization.organizationName Like "'.$retDetTxt.'%")';
			}
			else
			{
				$where.= '( employee.businessPhone Like "'.$retDetTxt.'%" OR organization.organizationName Like "'.$retDetTxt.'%")';
			}
		}
		
		if(!empty($prdDetDrp))		
		{
			if(!empty($prdDetTxt))
			{
				if(!empty($where))
				{
					if($prdDetDrp=='name')
					{
						$where.= ' AND product.code Like "'.$prdDetTxt.'%"';
					}
					elseif($prdDetDrp=='price')
					{
						$where.= ' AND order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%"';
					}
				}
				else
				{					
					if($prdDetDrp=='name')
					{
						$where = 'product.code Like "'.$prdDetTxt.'%"';
					}
					elseif($prdDetDrp=='price')
					{
						$where = 'order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%"';
					}
				}
			}
		}
		elseif(!empty($prdDetTxt))
		{
			if(!empty($where))
			{
				$where.= ' AND ( product.code Like "'.$prdDetTxt.'%" OR order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%")';
			}
			else
			{
				$where.= '( product.code Like "'.$prdDetTxt.'%" OR order_custom_payment.totalCustomAmount Like "'.$prdDetTxt.'%")';
			}
		}
		
		if(!empty($ordrDetDrp))		
		{
			if(!empty($ordrDetTxt))
			{
				if(!empty($where))
				{
					if($ordrDetDrp=='customOrderId')
					{
						$where.= ' AND order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='dateTime')
					{
						$where.= ' AND order_custom_payment.createDt Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='orderType')
					{
						$strDel = stripos('Quick Shipment',$ordrDetTxt);
						if($strDel===false)
						{
							$strDel = stripos('Single Shipment',$ordrDetTxt);
							if($strDel===false)
							{
								$strDel = stripos('Pick Up',$ordrDetTxt);						
								if($strDel===false)
								{
									$where.= ' AND order_total.isPickup = 2';
								}
								else
								{
									$where.= ' AND order_total.isPickup = 1';
								}
							}
							else
							{
								$where.= ' AND order_total.isPickup = 0 AND order_total.isEconomicDelivery = 1';
							}
						}
						else
						{
							$where.= ' AND order_total.isPickup = 0 AND order_total.isEconomicDelivery = 0';
						}
					}
					elseif($ordrDetDrp=='paymentMode')
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$where.= ' AND order_total.paymentStatus = 2';
								}
								else
								{
									$where.= ' AND (order_total.isPickup = 1 AND order_total.paymentStatus = 0)';
								}							
							}
							else
							{
								$where.= ' AND (order_total.isPickup = 0 AND order_total.paymentStatus = 0)';
							}
						}
						else
						{
							$where.= ' AND order_total.paymentStatus = 1';
						}						
					}
				}
				else
				{					
					if($ordrDetDrp=='customOrderId')
					{
						$where = 'order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='dateTime')
					{
						$where = 'order_custom_payment.createDt Like "'.$ordrDetTxt.'%"';
					}
					elseif($ordrDetDrp=='orderType')
					{						
						$strDel = stripos('Quick Shipment',$ordrDetTxt);
						if($strDel===false)
						{
							$strDel = stripos('Single Shipment',$ordrDetTxt);
							if($strDel===false)
							{
								$strDel = stripos('Pick Up',$ordrDetTxt);						
								if($strDel===false)
								{
									$where.= 'order_total.isPickup = 2';
								}
								else
								{
									$where.= 'order_total.isPickup = 1';
								}
							}
							else
							{
								$where.= 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 1';
							}
						}
						else
						{
							$where.= 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 0';
						}
					}
					elseif($ordrDetDrp=='paymentMode')
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$where = 'order_total.paymentStatus = 2';
								}
								else
								{
									$where = '(order_total.isPickup = 1 AND order_total.paymentStatus = 0)';
								}							
							}
							else
							{
								$where = '(order_total.isPickup = 0 AND order_total.paymentStatus = 0)';
							}
						}
						else
						{
							$where = 'order_total.paymentStatus = 1';
						}						
					}					
				}
			}
		}
		elseif(!empty($ordrDetTxt))
		{
			$strWhere = '';
			$strDel = stripos('Quick Shipment',$ordrDetTxt);
			if($strDel===false)
			{
				$strDel = stripos('Single Shipment',$ordrDetTxt);
				if($strDel===false)
				{
					$strPick = stripos('Pick Up',$ordrDetTxt);						
					if($strPick===false)
					{
						$strPay = stripos('Pay Online',$ordrDetTxt);
						if($strPay===false)
						{							
							$strPay = stripos('Cash On Delivery',$ordrDetTxt);
							if($strPay===false)
							{								
								$strPay = stripos('Pay On Pickup',$ordrDetTxt);
								if($strPay===false)
								{
									$strWhere = 'order_total.paymentStatus = 2';
								}
								else
								{
									$strWhere = '(order_total.isPickup = 1 AND order_total.paymentStatus = 0)';
								}							
							}
							else
							{
								$strWhere = '(order_total.isPickup = 0 AND order_total.paymentStatus = 0)';
							}
						}
						else
						{
							$strWhere = 'order_total.paymentStatus = 1';
						}						
					}
					else
					{
						$strWhere = 'order_total.isPickup = 1';
					}
				}
				else
				{
					$strWhere = 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 1';
				}
			}
			else
			{
				$strWhere = 'order_total.isPickup = 0 AND order_total.isEconomicDelivery = 0';
			}			
					
			if(!empty($where))
			{
				if(!empty($strWhere))
				{
					$where.= ' AND ( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" OR '.$strWhere.' )';
				}
				else
				{
					$where.= ' AND ( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" )';				
				}
			}
			else
			{
				if(!empty($strWhere))
				{
					$where = '( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" OR '.$strWhere.' )';
				}
				else
				{
					$where = '( order_custom_payment.customOrderId Like "'.$ordrDetTxt.'%" OR order_custom_payment.createDt Like "'.$ordrDetTxt.'%" )';				
				}
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}		
		
		$total 	   = $this->CI->order_m->total_custom_order_search($where);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/order_search_management/ajax_order_search_list/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$return['list']  = $this->CI->order_m->custom_order_search_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	
	}
	
	public function order_search_view($orderCustomPaymentId)
	{
		$result 	  		 			 = array();
		$result['orderList'] 			 = '';
		$result['dropShipCenterId'] 	 = 0;
		$result['dropShipCenterName']    = '';
		$result['dropShipCenterAddress'] = '';
		
		$result['customerBillFirstName'] = '';
		$result['customerBillLastName']  = '';
		$result['customerBillPhone']     = '';
		$result['billingCountry']        = '';
		$result['billingState']    	     = '';
		$result['billingArea']   	     = '';
		$result['billingCity']     	     = '';
		$result['billingAddressLine1']   = '';
		$result['billingAddressLine2']   = '';
		
		$result['customerShippFirstName']   = '';
		$result['customerShippLastName']	= '';
		$result['customerShippPhone']       = '';
		$result['shippingCountry']      	= '';
		$result['shippingState']    	    = '';
		$result['shippingArea']             = '';
		$result['shippingCity']     	   	= '';
		$result['shippingAddressLine1']     = '';
		$result['shippingAddressLine2']     = '';
		
		$result['vendorBusinessName']       = '';
		$result['vendorFirstName']          = '';
		$result['vendorLastName']           = '';
		$result['vendorEmail']              = '';
		$result['vendorBusinessPhoneCode']  = '';
		$result['vendorBusinessPhone']      = '';
		$result['vendorAddressLine1']       = '';
		$result['vendorCountryName']        = '';
		$result['vendorStateName']          = '';
		$result['vendorAreaName']		    = '';
		$result['vendorCityName']           = '';
				
		$orderList = $this->CI->order_m->custom_order_detail_list($orderCustomPaymentId);
		//echo "<pre>"; print_r($orderList); exit;
		if(!empty($orderList))
		{
			foreach($orderList as $row)
			{
				$result['productList'][$row->productId]['productId'] = $row->productId;
				$result['productList'][$row->productId]['productName'] = $row->code;
				$result['productList'][$row->productId]['quantity'] = $row->quantity;
				$result['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['productList'][$row->productId]['size'] = $row->sizes;
				$result['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['productList'][$row->productId]['totalProductAmount'] = $row->totalProductAmount;
				$result['productList'][$row->productId]['orderDetailId'] = $row->orderDetailId;
				$result['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['totalCustomAmount'] 			   = $row->totalCustomAmount;
				$result['totalCustomShippingAmount'] 	   = $row->totalCustomShippingAmount;
				$result['totalCustomCashHandlingAmount']   = $row->totalCustomCashHandlingAmount;
				$result['totalCustomPickupProccessAmount'] = $row->totalCustomPickupProccessAmount;
				$result['customOrderId'] 				   = $row->customOrderId;
				$result['organizationName'] 			   = $row->organizationName;
				$result['pickupId'] 					   = $row->pickupId;
				$result['isPickup'] 					   = $row->isPickup;
				$result['dropShipCenterId'] 			   = $row->dropShipCenterId;
				$result['paymentStatus']	 			   = $row->paymentStatus;
				$result['orderStatusId']	 			   = $row->orderStatusId;
				$result['organizationProductId']		   = $row->organizationProductId;
				$result['isEconomicDelivery']		       = $row->isEconomicDelivery;	
				$result['productList'][$row->productId]['pickupProcessingAmount'] = $row->pickupProcessingAmount;
				$result['productList'][$row->productId]['trackingNbr'] = $row->trackingNbr;
				$customerId = $row->customerId;
				$shippingOrgId = $row->shippingOrgId;
			}
			
			if($result['dropShipCenterId'])
			{
				$dropshipDetails = $this->CI->retailer_m->dropship_details($result['dropShipCenterId']);
				//echo "<pre>"; print_r($dropshipDetails); exit;
				if(!empty($dropshipDetails))
				{
					$result['dropShipCenterName']    = $dropshipDetails->dropCenterName;
					$result['dropShipCenterAddress'] = $dropshipDetails->addressLine1;
				}
			}
			
			$retailerDetails = $this->CI->order_m->order_retailer_details($result['organizationProductId']);
			if(!empty($retailerDetails))
			{
				$result['retailerOrganizationName'] = $retailerDetails->organizationName;
				$result['retailerEmail'] 		   = $retailerDetails->email;
				$result['retailerFirstName'] 	   = $retailerDetails->firstName;
				$result['retailerMiddle'] 		   = $retailerDetails->middle;
				$result['retailerLastName'] 		   = $retailerDetails->lastName;
				$result['retailerBussPhCode'] 	   = $retailerDetails->businessPhoneCode;
				$result['retailerBusinessPhone']    = $retailerDetails->businessPhone;
				$result['retailerUserName'] 		   = $retailerDetails->userName;
				$result['retailerAddressLine1'] 	   = $retailerDetails->addressLine1;
				$result['retailerAddressLine2'] 	   = $retailerDetails->address_Line2;
				$result['retailerCountryName'] 	   = $retailerDetails->countryName;
				$result['retailerStateName'] 	   = $retailerDetails->stateName;
				$result['retailerCityName'] 		   = $retailerDetails->cityName;
				$result['retailerAreaName']		   = $retailerDetails->areaName;
			}	
			
			$customerDetails = $this->CI->customer_m->get_customer_user_detail($customerId);
			if(!empty($customerDetails))
			{
				$result['customerFirstName'] = $customerDetails->firstName;
				$result['customerLastName']	 = $customerDetails->lastName;
				$result['customerPhone']	 = $customerDetails->phone;	
				$result['customerEmail']	 = $customerDetails->email;
			}
			
			$shipperDetails = $this->CI->order_m->order_shipping_vendor_details($shippingOrgId);
			//echo "<pre>"; print_r($shipperDetails); exit;
			if(!empty($shipperDetails))
			{
				$result['vendorBusinessName'] 	  = $shipperDetails->organizationName;
				$result['vendorFirstName'] 		  = $shipperDetails->firstName;
				$result['vendorLastName'] 		  = $shipperDetails->lastName;
				$result['vendorEmail'] 			  = $shipperDetails->email;
				$result['vendorBusinessPhoneCode'] = $shipperDetails->businessPhoneCode;
				$result['vendorBusinessPhone'] 	  = $shipperDetails->businessPhone;
				$result['vendorAddressLine1'] 	  = $shipperDetails->addressLine1;
				$result['vendorCountryName'] 	  = $shipperDetails->countryName;
				$result['vendorStateName'] 		  = $shipperDetails->stateName;
				$result['vendorCityName'] 		  = $shipperDetails->cityName;
				$result['vendorAreaName'] 		  = $shipperDetails->areaName;
			}	
		}
			
		//echo "<pre>"; print_r($result); exit;
		return $result;
			
	}
}