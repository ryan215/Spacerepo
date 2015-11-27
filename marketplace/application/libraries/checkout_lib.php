<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Checkout_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function pay_online_add_to_cart_same_day_delivery($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{	
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			$orderDetails['orderTypeId']   	   = 2;
			$orderDetails['customerId']    	   = $this->CI->session->userdata('userId');
			$orderDetails['totalSamDayAmount'] = $this->CI->config->item('flate_rate_same_day_delivery');
			$orderDetails['isPointeForce']	   = 0;
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				$orderDetails['isPointeForce'] = 1;
			}
			
			foreach($cartDetails as $row)
			{
				$shipping_rate = 0;
				if($row->freeShipPrdId)
				{
				}
				elseif($row->freeShipCatId)
				{
				}
				elseif($row->genuineShippFee)
				{	
					if((!empty($row->productWeight))&&(($row->productWeight)>10))
					{
						$shippingRate  = $row->shippingRate*$row->productWeight;
						$shipping_rate = $row->quantity*$shippingRate;
					}
					else
					{
						$shippingRate  = $row->shippingRate;
						$shipping_rate = $row->quantity*$shippingRate;
					}
				}
				$totalAmount = $totalAmount+($row->productAmt*$row->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $row->shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $row->shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = 0;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			}
			
			$flatRateAmt = 0;
			if(!empty($orderDetails['customOrderId']))			
			{
				$totalArrCnt = count($orderDetails['customOrderId']);
				if($totalArrCnt)
				{
					$flatRateAmt = $this->CI->config->item('flate_rate_same_day_delivery')/$totalArrCnt;
				}
			}
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_same_day_delivery($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $flatRateAmt+$customRow['totalCustomAmount'];
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
	
	public function cash_on_delivery_add_to_cart_same_day_delivery($cartDetails)
	{	
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			$orderDetails['orderTypeId']   	   = 2;
			$orderDetails['customerId']    	   = $this->CI->session->userdata('userId');
			$orderDetails['totalSamDayAmount'] = $this->CI->config->item('flate_rate_same_day_delivery');
			$orderDetails['isPointeForce']	   = 0;
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				$orderDetails['isPointeForce'] = 1;
			}
				
			foreach($cartDetails as $row)
			{
				$shipping_rate = 0;
				if($row->freeShipPrdId)
				{
				}
				elseif($row->freeShipCatId)
				{
				}
				elseif($row->genuineShippFee)
				{	
					if((!empty($row->productWeight))&&(($row->productWeight)>10))
					{
						$shippingRate  = $row->shippingRate*$row->productWeight;
						$shipping_rate = $row->quantity*$shippingRate;
					}
					else
					{
						$shippingRate  = $row->shippingRate;
						$shipping_rate = $row->quantity*$shippingRate;
					}
				}
				$totalAmount = $totalAmount+($row->productAmt*$row->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']+($row->productAmt*$row->quantity)+$shipping_rate;

				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $row->shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $row->shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = 0;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			}
			
			$flatRateAmt = 0;
			if(!empty($orderDetails['customOrderId']))			
			{
				$totalArrCnt = count($orderDetails['customOrderId']);
				if($totalArrCnt)
				{
					$flatRateAmt = $this->CI->config->item('flate_rate_same_day_delivery')/$totalArrCnt;
				}
			}
			
			$totalCashHandlingAmount = (($this->CI->config->item('flate_rate_same_day_delivery')+$totalAmount)*$this->CI->config->item('space_point_comission'))/100;
			$this->CI->custom_log->write_log('custom_log','Cash Handling Price is '.$totalCashHandlingAmount);
			
			$totalAmount = $totalAmount+$totalCashHandlingAmount+$this->CI->config->item('flate_rate_same_day_delivery');
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = $totalCashHandlingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalAmount;
			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_cash_on_delivery_same_day_delivery($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $flatRateAmt+$customRow['totalCustomAmount']+(($flatRateAmt+$customRow['totalCustomAmount'])*$this->CI->config->item('space_point_comission'))/100;
						
						
						$orderDetails['customOrderId'][$organizationId]['totalCustomCashHandlingAmount'] = ($orderDetails['customOrderId'][$organizationId]['totalCustomCashHandlingAmount']+$flatRateAmt)*$this->CI->config->item('space_point_comission')/100;
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_cash_on_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
		
	public function cash_on_delivery_buy_now_same_day_delivery($cartDetails)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			$orderDetails['orderTypeId']   	   = 1;
			$orderDetails['customerId']    	   = $this->CI->session->userdata('userId');
			$orderDetails['totalSamDayAmount'] = $this->CI->config->item('flate_rate_same_day_delivery');
			$orderDetails['isPointeForce']	   = 0;
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				$orderDetails['isPointeForce'] = 1;
			}
			
			$shipping_rate = 0;
			if($cartDetails->freeShipPrdId)
			{
			}
			elseif($cartDetails->freeShipCatId)
			{
			}
			elseif($cartDetails->genuineShippFee)
			{	
				if((!empty($cartDetails->productWeight))&&(($cartDetails->productWeight)>10))
				{
					$shippingRate  = $cartDetails->shippingRate*$cartDetails->productWeight;
					$shipping_rate = $cartDetails->quantity*$shippingRate;
				}
				else
				{
					$shippingRate  = $cartDetails->shippingRate;
					$shipping_rate = $cartDetails->quantity*$shippingRate;
				}
			}
			$totalAmount = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery');
			$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
			$cusOrderId    = $this->CI->config->item('add_orderId');
			$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
			$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
			if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']+($cartDetails->productAmt*$row->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery');
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery');
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']+((($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery'))*$this->CI->config->item('space_point_comission'))/100;

				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount'] = ((($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery'))*$this->CI->config->item('space_point_comission'))/100;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				else
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $cartDetails->shippingOrgId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $cartDetails->shippingRateId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = 0;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
				
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			
			$totalCashHandlingAmount = ($totalAmount*$this->CI->config->item('space_point_comission'))/100;
			$this->CI->custom_log->write_log('custom_log','Cash Handling Price is '.$totalCashHandlingAmount);
			
			$totalAmount = $totalAmount+$totalCashHandlingAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = $totalCashHandlingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalAmount;
			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_cash_on_delivery_same_day_delivery($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $customRow['totalCustomAmount']+($customRow['totalCustomAmount']*$this->CI->config->item('space_point_comission'))/100;
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_cash_on_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
	
	public function pay_online_buy_now_same_day_delivery($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			$orderDetails['orderTypeId']   	   = 1;
			$orderDetails['customerId']    	   = $customerId;
			$orderDetails['totalSamDayAmount'] = $this->CI->config->item('flate_rate_same_day_delivery');
			$orderDetails['isPointeForce']	   = 0;
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				$orderDetails['isPointeForce'] = 1;
			}
			
			$shipping_rate = 0;
			if($cartDetails->freeShipPrdId)
			{
			}
			elseif($cartDetails->freeShipCatId)
			{
			}
			elseif($cartDetails->genuineShippFee)
			{	
				if((!empty($cartDetails->productWeight))&&(($cartDetails->productWeight)>10))
				{
					$shippingRate  = $cartDetails->shippingRate*$cartDetails->productWeight;
					$shipping_rate = $cartDetails->quantity*$shippingRate;
				}
				else
				{
					$shippingRate  = $cartDetails->shippingRate;
					$shipping_rate = $cartDetails->quantity*$shippingRate;
				}
			}
			$totalAmount = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery');
			$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
			$cusOrderId    = $this->CI->config->item('add_orderId');
			$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
			$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
			if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery');
			}
			else
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate+$this->CI->config->item('flate_rate_same_day_delivery');
			}
				
			if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']+$shipping_rate;
			}
			else
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
			}
				
			if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
			{
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
				}
			}
			else
			{
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
				}
			}
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
			
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $cartDetails->shippingOrgId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $cartDetails->shippingRateId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingAmount'] = $shipping_rate;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = 0;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				}
			}
			else
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
			}
				
			if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
			}
			else
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
			}
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
									
			$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_same_day_delivery($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		return  $orderTotalId;
		//echo "<pre>"; print_r($orderDetails); exit;
		//return  $orderTotalId+2670;
	
	}
	
	public function pay_online_buy_now_quick_shippment($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{	
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			
				$orderDetails['orderTypeId']  = 1;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				
				$shipping_rate = 0;
				if($cartDetails->freeShipPrdId)
				{
				}
				elseif($cartDetails->freeShipCatId)
				{
				}
				elseif($cartDetails->genuineShippFee)
				{	
					if((!empty($cartDetails->productWeight))&&(($cartDetails->productWeight)>10))
					{
						$shippingRate  = $cartDetails->shippingRate*$cartDetails->productWeight;
						$shipping_rate = $cartDetails->quantity*$shippingRate;
					}
					else
					{
						$shippingRate  = $cartDetails->shippingRate;
						$shipping_rate = $cartDetails->quantity*$shippingRate;
					}
				}
				$totalAmount = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				else
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $cartDetails->shippingOrgId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $cartDetails->shippingRateId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = $cartDetails->ETA+$this->CI->config->item('estimated_time_increase');
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
									
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_quick_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		return  $orderTotalId;
		//echo "<pre>"; print_r($orderDetails); exit;
		//return  $orderTotalId+2670;
	}
	
	public  function pay_online_buy_now_single_shippment($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		$checkSecond 		 = array();
		if(!empty($cartDetails))
		{
			$orderDetails['orderTypeId']  = 1;
			$orderDetails['customerId']   = $customerId;
			$orderDetails['isPointeForce'] = 0;
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				$orderDetails['isPointeForce'] = 1;
			}
			
			$shipping_rate = 0;
			$estimateDayDelivery = 0;
			$inAllShipping		 = 0;
			$standardDet = $this->CI->cart_m->standard_delivery_details($cartDetails->organizationId,$customerId);
			$this->CI->custom_log->write_log('custom_log','standard delivery details is '.print_r($standardDet,true));					
			
			if(!empty($standardDet))
			{
				$shippingRateId = $standardDet->finalShippingRateId;
				$shippingOrgId  = $standardDet->finalShippingOrgId;
				$estimateDayDelivery = $standardDet->ETA;
				if($standardDet->isCalculateShipp)
				{
					$shipping_rate = $standardDet->shippingRate;
					$inAllShipping = $standardDet->shippingRate;
					
					if($standardDet->totalProductWeight>10)
					{
						$inAllShipping = $standardDet->shippingRate*$standardDet->totalProductWeight;
						$shipping_rate = $standardDet->shippingRate*$standardDet->totalProductWeight;
					}
				}
			}
					
			$cusOrderId    = $this->CI->config->item('add_orderId');
			$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
			$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
			$totalAmount = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
			$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
			
			if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
			{
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
				}
			}
			else
			{
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
				}
			}
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $shippingOrgId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $shippingRateId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingAmount'] = $inAllShipping;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = $estimateDayDelivery+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
			
			if((!empty($isPointeForce))&&($isPointeForce))
			{
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				}
			}
			else
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
			}
			
			if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
			}
			else
			{
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
			}
				
			$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
				
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = 0;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_single_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									if(!empty($checkSecond[$customRow['customOrderId']]))
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor_unactive($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','unactive order shipping vendor id is '.$orderShippingVendorId);
									}
									else
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									}
									
									$checkSecond[$customRow['customOrderId']] = $customRow['customOrderId'];
									
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
							
							}
						}
					}
					
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		return  $orderTotalId;
	}
		
	public function cash_on_delivery_buy_now_quick_shippment($cartDetails)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			
				$orderDetails['orderTypeId']  = 1;
				$orderDetails['customerId']   = $this->CI->session->userdata('userId');
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$shipping_rate = 0;
				if($cartDetails->freeShipPrdId)
				{
				}
				elseif($cartDetails->freeShipCatId)
				{
				}
				elseif($cartDetails->genuineShippFee)
				{	
					if((!empty($cartDetails->productWeight))&&(($cartDetails->productWeight)>10))
					{
						$shippingRate  = $cartDetails->shippingRate*$cartDetails->productWeight;
						$shipping_rate = $cartDetails->quantity*$shippingRate;
					}
					else
					{
						$shippingRate  = $cartDetails->shippingRate;
						$shipping_rate = $cartDetails->quantity*$shippingRate;
					}
				}
				$totalAmount = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']+($cartDetails->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']+((($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;

				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount'] = ((($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				else
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $cartDetails->shippingOrgId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $cartDetails->shippingRateId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = $cartDetails->ETA+$this->CI->config->item('estimated_time_increase');
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
				
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			
			$totalCashHandlingAmount = ($totalAmount*$this->CI->config->item('space_point_comission'))/100;
			$this->CI->custom_log->write_log('custom_log','Cash Handling Price is '.$totalCashHandlingAmount);
			
			$totalAmount = $totalAmount+$totalCashHandlingAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = $totalCashHandlingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalAmount;
			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_cash_on_delivery_quick_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $customRow['totalCustomAmount']+($customRow['totalCustomAmount']*$this->CI->config->item('space_point_comission'))/100;
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_cash_on_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
	
	public function cash_on_delivery_buy_now_single_shippment($cartDetails)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		$checkSecond 		 = array();
		if(!empty($cartDetails))
		{
			
				$orderDetails['orderTypeId']  = 1;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$shipping_rate = 0;
				$estimateDayDelivery = 0;
				$inAllShipping		 = 0;
				$standardDet = $this->CI->cart_m->standard_delivery_details($cartDetails->organizationId,$customerId);
				$this->CI->custom_log->write_log('custom_log','standard delivery details is '.print_r($standardDet,true));					
				if(!empty($standardDet))
				{
					$shippingRateId = $standardDet->finalShippingRateId;
					$shippingOrgId  = $standardDet->finalShippingOrgId;
					$estimateDayDelivery = $standardDet->ETA;
					if($standardDet->isCalculateShipp)
					{
						if($standardDet->totalProductWeight>10)
						{
							$inAllShipping = $standardDet->shippingRate*$standardDet->totalProductWeight;
						}
						else
						{
							$inAllShipping = $standardDet->shippingRate;
						}
					}
				}
					
				if(!empty($orderDetails['customOrderId'][$cartDetails->organizationId]))
				{
				}
				else
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
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
				$totalAmount = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']+($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount']+((($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;

				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomCashHandlingAmount'] = ((($cartDetails->productAmt*$cartDetails->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				else
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $shippingOrgId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $shippingRateId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingAmount'] = $inAllShipping;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = $estimateDayDelivery+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
			$totalCashHandlingAmount = ($totalAmount*$this->CI->config->item('space_point_comission'))/100;
			$this->CI->custom_log->write_log('custom_log','Cash Handling Price is '.$totalCashHandlingAmount);
			
			$totalAmount = $totalAmount+$totalCashHandlingAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = $totalCashHandlingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalAmount;
			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_cash_on_delivery_single_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $customRow['totalCustomAmount']+($customRow['totalCustomAmount']*$this->CI->config->item('space_point_comission'))/100;
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_cash_on_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									if(!empty($checkSecond[$customRow['customOrderId']]))
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor_unactive($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','unactive order shipping vendor id is '.$orderShippingVendorId);
									}
									else
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									}
									
									$checkSecond[$customRow['customOrderId']] = $customRow['customOrderId'];
									
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
							
							}
						}
					}
					
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
	
	public function pay_online_add_to_cart_quick_shippment($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{	
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			foreach($cartDetails as $row)
			{
				$orderDetails['orderTypeId']  = 2;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$shipping_rate = 0;
				if($row->freeShipPrdId)
				{
				}
				elseif($row->freeShipCatId)
				{
				}
				elseif($row->genuineShippFee)
				{	
					if((!empty($row->productWeight))&&(($row->productWeight)>10))
					{
						$shippingRate  = $row->shippingRate*$row->productWeight;
						$shipping_rate = $row->quantity*$shippingRate;
					}
					else
					{
						$shippingRate  = $row->shippingRate;
						$shipping_rate = $row->quantity*$shippingRate;
					}
				}
				$totalAmount = $totalAmount+($row->productAmt*$row->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $row->shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $row->shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $row->ETA+$this->CI->config->item('estimated_time_increase');
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			}
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_quick_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
	
	public function cash_on_delivery_add_to_cart_quick_shippment($cartDetails)
	{	//echo "<pre>"; print_r($cartDetails); exit;
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			foreach($cartDetails as $row)
			{
				$orderDetails['orderTypeId']  = 2;
				$orderDetails['customerId']   = $this->CI->session->userdata('userId');
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$shipping_rate = 0;
				if($row->freeShipPrdId)
				{
				}
				elseif($row->freeShipCatId)
				{
				}
				elseif($row->genuineShippFee)
				{	
					if((!empty($row->productWeight))&&(($row->productWeight)>10))
					{
						$shippingRate  = $row->shippingRate*$row->productWeight;
						$shipping_rate = $row->quantity*$shippingRate;
					}
					else
					{
						$shippingRate  = $row->shippingRate;
						$shipping_rate = $row->quantity*$shippingRate;
					}
				}
				$totalAmount = $totalAmount+($row->productAmt*$row->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']+((($row->productAmt*$row->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;

				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount'] = ((($row->productAmt*$row->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $row->shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $row->shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingAmount'] = $shipping_rate;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $row->ETA+$this->CI->config->item('estimated_time_increase');
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			}
			
			$totalCashHandlingAmount = ($totalAmount*$this->CI->config->item('space_point_comission'))/100;
			$this->CI->custom_log->write_log('custom_log','Cash Handling Price is '.$totalCashHandlingAmount);
			
			$totalAmount = $totalAmount+$totalCashHandlingAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = $totalCashHandlingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalAmount;
			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_cash_on_delivery_quick_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $customRow['totalCustomAmount']+($customRow['totalCustomAmount']*$this->CI->config->item('space_point_comission'))/100;
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_cash_on_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}	
	
	public function pay_online_add_to_cart_single_shippment($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		$checkSecond 		 = array();
		if(!empty($cartDetails))
		{
			foreach($cartDetails as $row)
			{
				$orderDetails['orderTypeId']  = 2;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$shipping_rate = 0;
				$estimateDayDelivery = 0;
				$inAllShipping		 = 0;
				$standardDet = $this->CI->cart_m->standard_delivery_details($row->organizationId,$customerId);
				$this->CI->custom_log->write_log('custom_log','standard delivery details is '.print_r($standardDet,true));					
				if(!empty($standardDet))
				{
					$shippingRateId = $standardDet->finalShippingRateId;
					$shippingOrgId  = $standardDet->finalShippingOrgId;
					$estimateDayDelivery = $standardDet->ETA;
					if($standardDet->isCalculateShipp)
					{
						if($standardDet->totalProductWeight>10)
						{
							$inAllShipping = $standardDet->shippingRate*$standardDet->totalProductWeight;
						}
						else
						{
							$inAllShipping = $standardDet->shippingRate;
						}
					}
				}
					
				if(!empty($orderDetails['customOrderId'][$row->organizationId]))
				{
				}
				else
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
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				$totalAmount = $totalAmount+($row->productAmt*$row->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingAmount'] = $inAllShipping;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $estimateDayDelivery+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;
			}
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = 0;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_single_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									if(!empty($checkSecond[$customRow['customOrderId']]))
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor_unactive($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','unactive order shipping vendor id is '.$orderShippingVendorId);
									}
									else
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									}
									
									$checkSecond[$customRow['customOrderId']] = $customRow['customOrderId'];
									
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
							
							}
						}
					}
					
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		return  $orderTotalId;
	}
	
	public function cash_on_delivery_add_to_cart_single_shippment($cartDetails)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalShippingAmount = 0;
		$customOrderIdList   = array();
		$checkSecond 		 = array();
		if(!empty($cartDetails))
		{
			foreach($cartDetails as $row)
			{
				$orderDetails['orderTypeId']  = 2;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$shipping_rate = 0;
				$estimateDayDelivery = 0;
				$inAllShipping		 = 0;
				$standardDet = $this->CI->cart_m->standard_delivery_details($row->organizationId,$customerId);
				$this->CI->custom_log->write_log('custom_log','standard delivery details is '.print_r($standardDet,true));					
				if(!empty($standardDet))
				{
					$shippingRateId = $standardDet->finalShippingRateId;
					$shippingOrgId  = $standardDet->finalShippingOrgId;
					$estimateDayDelivery = $standardDet->ETA;
					if($standardDet->isCalculateShipp)
					{
						if($standardDet->totalProductWeight>10)
						{
							$inAllShipping = $standardDet->shippingRate*$standardDet->totalProductWeight;
						}
						else
						{
							$inAllShipping = $standardDet->shippingRate;
						}
					}
				}
					
				if(!empty($orderDetails['customOrderId'][$row->organizationId]))
				{
				}
				else
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
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				$totalAmount = $totalAmount+($row->productAmt*$row->quantity)+$shipping_rate;
				$totalShippingAmount = $totalShippingAmount+$shipping_rate;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount']+$shipping_rate;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomShippingAmount'] = $shipping_rate;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount']+((($row->productAmt*$row->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;

				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomCashHandlingAmount'] = ((($row->productAmt*$row->quantity)+$shipping_rate)*$this->CI->config->item('space_point_comission'))/100;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingAmount'] = $inAllShipping;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $estimateDayDelivery+$this->CI->config->item('estimated_time_increase')+$this->CI->config->item('economic_delivery_estimated_time');
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;

				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}	
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;			
			}
			
			$totalCashHandlingAmount = ($totalAmount*$this->CI->config->item('space_point_comission'))/100;
			$this->CI->custom_log->write_log('custom_log','Cash Handling Price is '.$totalCashHandlingAmount);
			
			$totalAmount = $totalAmount+$totalCashHandlingAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalShippingAmount'] 	 = $totalShippingAmount;
			$orderDetails['totalCashHandlingAmount'] = $totalCashHandlingAmount;
			$orderDetails['totalAmount'] 		 	 = $totalAmount;
			
			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_cash_on_delivery_single_shippment($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderDetails['customOrderId'][$organizationId]['totalCustomAmount'] = $customRow['totalCustomAmount']+($customRow['totalCustomAmount']*$this->CI->config->item('space_point_comission'))/100;
					}
					
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_cash_on_delivery($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									if(!empty($checkSecond[$customRow['customOrderId']]))
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor_unactive($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','unactive order shipping vendor id is '.$orderShippingVendorId);
									}
									else
									{
										$orderShippingVendorId = $this->CI->checkout_m->add_order_vendor($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									}
									
									$checkSecond[$customRow['customOrderId']] = $customRow['customOrderId'];
									
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
							
							}
						}
					}
					
				}
				
				$shippCusAddId  = $this->CI->session->userdata('shippingAddressId');
				$orderAddressId = $this->CI->checkout_m->add_shipping_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
				
				/**********billing address for customer*************/
				$billCusDet = $this->CI->customer_m->user_billing_details($this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','customer billing details is '.print_r($billCusDet,true));
				$billCusAddId = 0;
				if(!empty($billCusDet))
				{
					$billCusAddId = $billCusDet->addressId;
				}
				else
				{
					$billCusAddId = $shippCusAddId;	
				}
				$orderBiAddressId = $this->CI->checkout_m->add_billing_order_address($orderTotalId,$billCusAddId);
				$this->CI->custom_log->write_log('custom_log','billing order address id is '.$orderBiAddressId);
				/********billing address for customer***************/
			}
		}
		return  $orderTotalId;
	} 
	
	public function pay_online_pickup_cart($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalPickupProccessAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			foreach($cartDetails as $row)
			{
				$orderDetails['orderTypeId']  = 2;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}
				$pickupProcessingAmount    = $row->pickupProccessPrice*$row->quantity;
				$totalAmount 			   = $totalAmount+($row->productAmt*$row->quantity)+$pickupProcessingAmount;
				$totalPickupProccessAmount = $totalPickupProccessAmount+$pickupProcessingAmount;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$row->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$row->organizationId]['organizationId']   = $row->organizationId;
				$orderDetails['customOrderId'][$row->organizationId]['dropShipCenterId'] = $row->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount']+($row->productAmt*$row->quantity)+$pickupProcessingAmount;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomAmount'] = ($row->productAmt*$row->quantity)+$pickupProcessingAmount;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPickupProccessAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPickupProccessAmount']))
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPickupProccessAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPickupProccessAmount']+$pickupProcessingAmount;
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPickupProccessAmount'] = $pickupProcessingAmount;
				}
				
				if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productAmount'] = $row->productAmt;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $row->shippingOrgId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['shippingRateId'] = $row->shippingRateId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['pickupProcessingAmount'] = $pickupProcessingAmount;
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->spacePointePrice2;
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->quantity*$row->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount']+($row->quantity*$row->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = $row->quantity*$row->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['pickupId'] = $row->pickupId;
				
				$estimateDay = $this->CI->config->item('estimated_time_increase');
				if((!empty($row->shippingRateId))&&($row->shippingRateId))
				{
					$rateDetails = $this->CI->shipping_m->shipping_vendor_details($row->shippingRateId);
					$this->CI->custom_log->write_log('custom_log','Rate details is '.print_r($rateDetails,true));
					if(!empty($rateDetails))
					{
						$estimateDay = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase');
					}
				}
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $estimateDay;
				
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				
				$orderDetails['customOrderId'][$row->organizationId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->productAmt*$row->quantity;			
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			}
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalPickupProccessAmount'] 	 = $totalPickupProccessAmount;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_pickup($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_pickup($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_pickup($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId = 0;
				$addDet = $this->CI->customer_m->user_profile_details($customerId);
				if(!empty($addDet))
				{
					$shippCusAddId = $addDet->addressId;
				}
				$orderAddressId = $this->CI->checkout_m->add_profile_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
	
	public function pay_online_pickup_buy_now($cartDetails,$totalPaidAmount,$payment_reference,$retrieval_reference,$transaction_reference,$merchant_reference,$transaction_date)
	{
		/*********Check customer as pointeforce***********/
		$isPointeForce = $this->CI->session->userdata('isPointeForce');
		$this->CI->custom_log->write_log('custom_log','customer is pointe force is '.$isPointeForce);
		$customerId = $this->CI->session->userdata('userId');
		$pointeForceVerifiedStatus = 0;
		if((!empty($isPointeForce))&&($isPointeForce))
		{
			$details = $this->CI->pointe_force_m->pointe_force_verification_details($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force details is '.print_r($details,true));
					
			if(!empty($details))
			{
				$pointeForceVerifiedStatus = $details->verifiedStatus;
			}
		}
		$this->CI->custom_log->write_log('custom_log','verification status is '.$pointeForceVerifiedStatus);
		/*********Check customer as pointeforce***********/
		
		$orderTotalId		 = 0;
		$orderDetails 		 = array();
		$totalAmount  		 = 0;    
		$totalPickupProccessAmount = 0;
		$customOrderIdList   = array();
		if(!empty($cartDetails))
		{
			
				$orderDetails['orderTypeId']  = 1;
				$orderDetails['customerId']   = $customerId;
				$orderDetails['isPointeForce'] = 0;
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					$orderDetails['isPointeForce'] = 1;
				}				
				$pickupProcessingAmount    = $cartDetails->pickupProccessPrice*$cartDetails->quantity;
				$totalAmount 			   = $totalAmount+($cartDetails->productAmt*$cartDetails->quantity)+$pickupProcessingAmount;
				$totalPickupProccessAmount = $totalPickupProccessAmount+$pickupProcessingAmount;
				
				$cusOrderId    = $this->CI->config->item('add_orderId');
				$cusOrderId	   = $cusOrderId+$cartDetails->cartId;
				$customOrderId = $this->CI->config->item('pre_orderId').$cusOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['customOrderId']    = $customOrderId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['organizationId']   = $cartDetails->organizationId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['dropShipCenterId'] = $cartDetails->toDropshipId;
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount']+($cartDetails->productAmt*$cartDetails->quantity)+$pickupProcessingAmount;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomAmount'] = ($cartDetails->productAmt*$cartDetails->quantity)+$pickupProcessingAmount;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPickupProccessAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPickupProccessAmount']))
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPickupProccessAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPickupProccessAmount']+$pickupProcessingAmount;
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPickupProccessAmount'] = $pickupProcessingAmount;
				}
				
				if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']))
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount']+($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				else
				{
					if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalRetailerAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity);
					}
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['organizationProductId'] = $cartDetails->organizationProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['quantity'] = $cartDetails->quantity;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerAmount'] = $cartDetails->retailerPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productAmount'] = $cartDetails->productAmt;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productId'] = $cartDetails->productId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['marketingProductId'] = $cartDetails->marketingProductId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['retailerDiscount'] = $cartDetails->retailerDiscount;
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['colorId'] = $cartDetails->colorId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productSizeId'] = $cartDetails->size;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productImageId'] = $cartDetails->productImageId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['productWeight'] = $cartDetails->productWeight;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['inventoryHistoryId'] = $cartDetails->inventoryHistoryId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingOrgId'] = $cartDetails->shippingOrgId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['shippingRateId'] = $cartDetails->shippingRateId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['pickupProcessingAmount'] = $pickupProcessingAmount;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipCatId'] = $cartDetails->freeShipCatId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['freeShipPrdId'] = $cartDetails->freeShipPrdId;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['spacePointePrice'] = $cartDetails->spacePointePrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['categoryCommission'] = $cartDetails->categoryCommission;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['cashAdminPrice'] = $cartDetails->cashAdminPrice;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isCashAdmin'] = $cartDetails->cashAdminFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['isGenuineShipp'] = $cartDetails->genuineShippFee;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['verifiedStatus'] = $pointeForceVerifiedStatus;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['commissionPrice'] = $cartDetails->spacePointePrice2;
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalCommissionPrice'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
				
				if((!empty($isPointeForce))&&($isPointeForce))
				{
					if((!empty($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))&&($orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']))
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount']+($cartDetails->quantity*$cartDetails->spacePointePrice2);
					}
					else
					{
						$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = $cartDetails->quantity*$cartDetails->spacePointePrice2;
					}
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['totalCustomPointeForceAmount'] = 0;
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['pickupId'] = $cartDetails->pickupId;
				
				$estimateDay = $this->CI->config->item('estimated_time_increase');
				if((!empty($cartDetails->shippingRateId))&&($cartDetails->shippingRateId))
				{
					$rateDetails = $this->CI->shipping_m->shipping_vendor_details($cartDetails->shippingRateId);
					$this->CI->custom_log->write_log('custom_log','Rate details is '.print_r($rateDetails,true));
					if(!empty($rateDetails))
					{
						$estimateDay = $rateDetails->ETA+$this->CI->config->item('estimated_time_increase');
					}
				}
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['estimateDayDelivery'] = $estimateDay;
				
				if((!empty($cartDetails->retailerDiscount))&&($cartDetails->retailerDiscount))	
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = ($cartDetails->retailerPrice*$cartDetails->quantity)-($cartDetails->retailerDiscount*$cartDetails->quantity);
				}
				else
				{
					$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalRetailAmount'] = $cartDetails->retailerPrice*$cartDetails->quantity;
				}
				
				$orderDetails['customOrderId'][$cartDetails->organizationId]['productDet'][$cartDetails->organizationProductId]['totalProductAmount'] = $cartDetails->productAmt*$cartDetails->quantity;
					
				$this->CI->custom_log->write_log('custom_log','custom order id is '.$customOrderId);
			
			
			$totalAmount = $totalAmount;
			$this->CI->custom_log->write_log('custom_log','Total AMount is '.$totalAmount);
						
			$orderDetails['totalPickupProccessAmount'] 	 = $totalPickupProccessAmount;
			$orderDetails['totalAmount'] 		 	 = $totalPaidAmount;
			
			$orderDetails['payment_reference']     = $payment_reference;
			$orderDetails['retrieval_reference']   = $retrieval_reference;
			$orderDetails['transaction_reference'] = $transaction_reference;
			$orderDetails['merchant_reference']	   = $merchant_reference;
			$orderDetails['transaction_date']	   = $transaction_date;

			if(!empty($orderDetails))
			{
				$orderTotalId = $this->CI->checkout_m->add_order_total_pay_online_pickup($orderDetails);
				$this->CI->custom_log->write_log('custom_log','order Total id is '.$orderTotalId);
				
				if(($orderTotalId)&&(!empty($orderDetails['customOrderId'])))
				{
					foreach($orderDetails['customOrderId'] as $organizationId=>$customRow)
					{
						$orderCustomPaymentId = $this->CI->checkout_m->add_order_custom_payment_pay_online_pickup($orderTotalId,$customRow);
						$this->CI->custom_log->write_log('custom_log','order custom payment id is '.$orderCustomPaymentId);
						if(($orderCustomPaymentId)&&(!empty($customRow['productDet'])))
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$orderDetailId = $this->CI->checkout_m->add_order_details($orderCustomPaymentId,$productRow);
								$this->CI->custom_log->write_log('custom_log','order details id is '.$orderDetailId);
								
								if((!empty($orderDetailId))&&($orderDetailId))
								{
									$orderShippingVendorId = $this->CI->checkout_m->add_order_pickup($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','order shipping vendor id is '.$orderShippingVendorId);
									$freeShipOrderId = $this->CI->checkout_m->add_order_free_shipping($orderDetailId,$productRow);
									$this->CI->custom_log->write_log('custom_log','free shiping order id is '.$freeShipOrderId);
									$trackOrderId = $this->CI->checkout_m->add_order_track_details($orderDetailId);
									$this->CI->custom_log->write_log('custom_log','track order id is '.$trackOrderId);
									
									/*********add order pointeforce commission***********/
									if((!empty($isPointeForce))&&($isPointeForce))
									{
										$orderPointeForceId = $this->CI->checkout_m->add_order_pointe_force($orderDetailId,$productRow);
										$this->CI->custom_log->write_log('custom_log','order pointe force id is '.$orderPointeForceId);
									}
									/*********add order pointeforce commission***********/
								}
								
							}
						}
					}
				}
				
				$shippCusAddId = 0;
				$addDet = $this->CI->customer_m->user_profile_details($customerId);
				if(!empty($addDet))
				{
					$shippCusAddId = $addDet->addressId;
				}
				$orderAddressId = $this->CI->checkout_m->add_profile_order_address($orderTotalId,$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','shipping address id is '.$shippCusAddId);
				$this->CI->custom_log->write_log('custom_log','order address id is '.$orderAddressId);
			}
		}
		//echo "<pre>"; print_r($orderDetails); exit;
		return  $orderTotalId;
	}
}