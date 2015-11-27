<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Test extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
	}	
	
	public function index()
	{/*
		$this->db->select('order.orderId,order.atATimeProduct,order.customOrderId,order.orderTypeId,order.totalAmount,order.isEconomicDelivery,order.isMobileDevice,order.isPickup,order.createDt,order.createBy,order.lastModifiedDt,order.last_Modified_By,order.customerId,order.shippingOrgId,order.shippingRateId,order_payment.cashHandlingPrice,order_payment.paymentTypeId,order_payment.pickupProccessPrice,order_payment.paymentStatus,order_payment.paymentRef,order_payment.retrievalRef,order_payment.transactionRef,order_payment.merchantRef,order_payment.transactionDate,order_payment.genuineShippFee,order_free_shipping.freeShipPrdId,order_free_shipping.freeShipCatId,order_payment.productWeight,shipping_rate.amount AS shippingRate,order.quantity,organization_product.organizationId,order.retailerPrice,order.productId,order.chargedAmount,order.organizationProductId,order.marketingProductId,order.trackingNbr,order.orderStatusId,order.retailerDiscount,order.colorId,order.size,order_payment.productImageId,order.deliveredDate,order_payment.productWeight,order.inventoryHistoryId,order.active,shipping_rate.eta,order_payment.spacePointePrice,order_payment.categoryCommission,order_payment.cashAdminPrice,order_payment.cashAdminFee,order_dropship_center.toDropshipId,organization.dropshipCentre,order_pointe_force_commission.verifiedStatus,order_pointe_force_commission.commissionPrice,order_pointe_force_commission.totalCommissionPrice,order.pickupId,order_pointe_force_commission.orderPointeForceId');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('shipping_rate','order.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId','left');
		$this->db->join('order_pointe_force_commission','order.orderId = order_pointe_force_commission.orderId','left');
		$result = $this->db->get()->result();
		$atAtimeOrder = array();
		//echo "<pre> "; print_r($result); exit;
		if(!empty($result))
		{
			foreach($result as $row) 
			{
				$atAtimeOrder[$row->atATimeProduct]['orderTypeId'] = $row->orderTypeId;
				$atAtimeOrder[$row->atATimeProduct]['customerId'] = $row->customerId;
				$atAtimeOrder[$row->atATimeProduct]['totalAmount'] = $row->totalAmount;
				$atAtimeOrder[$row->atATimeProduct]['isEconomicDelivery'] = $row->isEconomicDelivery;
				$atAtimeOrder[$row->atATimeProduct]['isMobileDevice'] = $row->isMobileDevice;
				$atAtimeOrder[$row->atATimeProduct]['isPickup'] = $row->isPickup;
				$atAtimeOrder[$row->atATimeProduct]['payment_reference']     = $row->paymentRef;
				$atAtimeOrder[$row->atATimeProduct]['retrieval_reference']   = $row->retrievalRef;
				$atAtimeOrder[$row->atATimeProduct]['transaction_reference'] = $row->transactionRef;
				$atAtimeOrder[$row->atATimeProduct]['merchant_reference']	   = $row->merchantRef;
				$atAtimeOrder[$row->atATimeProduct]['transaction_date']	   = $row->transactionDate;
				$atAtimeOrder[$row->atATimeProduct]['paymentTypeId']	   = $row->paymentTypeId;
				$atAtimeOrder[$row->atATimeProduct]['paymentStatus']	   = $row->paymentStatus;
				$atAtimeOrder[$row->atATimeProduct]['active']	   = 1;
				$atAtimeOrder[$row->atATimeProduct]['createDt'] = $row->createDt;
				$atAtimeOrder[$row->atATimeProduct]['createBy'] = $row->customerId;
				$atAtimeOrder[$row->atATimeProduct]['lastModifiedDt'] = $row->lastModifiedDt;
				$atAtimeOrder[$row->atATimeProduct]['last_Modified_By'] = $row->last_Modified_By;
				
				$shipping_rate  = 0;
				$shippingOrgId  = $row->shippingOrgId;
				$shippingRateId = $row->shippingRateId;
				if($row->orderPointeForceId)
				{
					$atAtimeOrder[$row->atATimeProduct]['isPointeForce'] = 1;
				}
				else
				{
					$atAtimeOrder[$row->atATimeProduct]['isPointeForce'] = 0;
				}
				
				if((!empty($row->isPickup))&&($row->isPickup))
				{
					$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']     = 0;
					$atAtimeOrder[$row->atATimeProduct]['totalCashHandlingAmount'] = 0;
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = 0;
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomCashHandlingAmount'] = 0;
					if(!empty($atAtimeOrder[$row->atATimeProduct]['totalPickupProccessAmount']))
					{
						$atAtimeOrder[$row->atATimeProduct]['totalPickupProccessAmount'] = $atAtimeOrder[$row->atATimeProduct]['totalPickupProccessAmount']+($row->pickupProccessPrice*$row->quantity);
					}
					else
					{
						$atAtimeOrder[$row->atATimeProduct]['totalPickupProccessAmount'] = $row->pickupProccessPrice*$row->quantity;
					}
					
					if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity)+($row->pickupProccessPrice*$row->quantity);
					}
					else
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity)+($row->pickupProccessPrice*$row->quantity);
					}
					
					if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPickupProccessAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPickupProccessAmount']))
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPickupProccessAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPickupProccessAmount']+($row->pickupProccessPrice*$row->quantity);
					}
					else
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPickupProccessAmount'] = $row->pickupProccessPrice*$row->quantity;
					}
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = 2;
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = 0;				
				}
				else
				{
					$atAtimeOrder[$row->atATimeProduct]['totalPickupProccessAmount'] = 0;					
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPickupProccessAmount'] = 0;
					if($row->freeShipPrdId)
					{
						if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity);
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity);
						}
						
						if((!empty($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']+0;
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = 0;
						}
						
						if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']+0;
							}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = 0;
							}
					}
					elseif($row->freeShipCatId)
					{
						if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity);
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity);
						}
						if((!empty($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']+0;
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = 0;
						}
						
						if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']+0;
							}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = 0;
							}
					}
					elseif($row->genuineShippFee)
					{
						if((!empty($row->isEconomicDelivery))&&($row->isEconomicDelivery))
						{
							$this->db->select('order_economical_delivery_details.totalProductWeight,order_economical_delivery_details.finalShippingOrgId,order_economical_delivery_details.finalShippingRateId,order_economical_delivery_details.isCalculateShipp,shipping_rate.amount AS shippingRate');
							$this->db->from('order_economical_delivery_details');
							$this->db->join('shipping_rate','order_economical_delivery_details.finalShippingRateId = shipping_rate.shippingRateId');
							$this->db->where('order_economical_delivery_details.customOrderId',$row->customOrderId);
							$econRes = $this->db->get()->row();
							if(!empty($econRes))
							{
								$shippingOrgId  = $econRes->finalShippingOrgId;
								$shippingRateId = $econRes->finalShippingRateId;
								if((!empty($econRes->isCalculateShipp))&&($econRes->isCalculateShipp))
								{
									if((!empty($econRes->totalProductWeight))&&(($econRes->totalProductWeight)>10))
									{
										$shipping_rate  = $econRes->shippingRate*$econRes->totalProductWeight;
									}
									else
									{
										$shipping_rate  = $econRes->shippingRate;
									}
								}
							}
							
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $shipping_rate;
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = $shipping_rate;
							if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))
							{
								if((!empty($chckEcoFirShip))&&(in_array($row->atATimeProduct,$chckEcoFirShip)))
								{
									$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity);
								}
								else
								{
									$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity)+$shipping_rate;
								}
								$chckEcoFirShip[$row->atATimeProduct] = $row->atATimeProduct;
							}
							else
							{
								if((!empty($chckEcoFirShip))&&(in_array($row->atATimeProduct,$chckEcoFirShip)))
								{
									$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity);
								}
								else
								{
									$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity)+$shipping_rate;
								}
								$chckEcoFirShip[$row->atATimeProduct] = $row->atATimeProduct;
							}
							
							if((!empty($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))
							{}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $shipping_rate;
							}
						}
						else
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
							if(!empty($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))
							{
								$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']+$shipping_rate;
							}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $shipping_rate;
							}
							
							if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']+$shipping_rate;
							}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = $shipping_rate;
							}
							
							if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity)+$shipping_rate;
							}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity)+$shipping_rate;
							}
						}
					}
					else
					{
						if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount']+($row->chargedAmount*$row->quantity);
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomAmount'] = ($row->chargedAmount*$row->quantity);
						}
						if((!empty($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['totalShippingAmount']+0;
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['totalShippingAmount'] = 0;
						}
						
						if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']))
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount']+0;
							}
							else
							{
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomShippingAmount'] = 0;
							}
					}
					
					if($row->paymentStatus)
					{
						$atAtimeOrder[$row->atATimeProduct]['totalCashHandlingAmount'] = 0;
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomCashHandlingAmount'] = 0;
					}
					else
					{
						if(!empty($atAtimeOrder[$row->atATimeProduct]['totalCashHandlingAmount']))
						{
							$atAtimeOrder[$row->atATimeProduct]['totalCashHandlingAmount'] = $atAtimeOrder[$row->atATimeProduct]['totalCashHandlingAmount']+$row->cashHandlingPrice;
						}
						else
						{
							$atAtimeOrder[$row->atATimeProduct]['totalCashHandlingAmount'] = $row->cashHandlingPrice;
						}
					}
					
					
					
					
					
					
				}
				
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['customOrderId'] = $row->customOrderId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['organizationId'] = $row->organizationId;
				if($row->toDropshipId)
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['dropShipCenterId'] = $row->toDropshipId;
				}
				else
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['dropShipCenterId'] = $row->dropshipCentre;
					
				}
				
				if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount']))
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount']+($row->retailerPrice*$row->quantity);
					}
				}
				else
				{
					if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
					}
					else
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalRetailerAmount'] = ($row->retailerPrice*$row->quantity);
					}
				}
			
				
				if((!empty($row->orderPointeForceId))&&($row->orderPointeForceId))
				{
					if((!empty($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPointeForceAmount']))&&($atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPointeForceAmount']))
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPointeForceAmount'] = $atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPointeForceAmount']+$row->totalCommissionPrice;
					}
					else
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPointeForceAmount'] = $row->totalCommissionPrice;
					}
				}
				else
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['totalCustomPointeForceAmount'] = 0;
				}
				
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['quantity'] = $row->quantity;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['retailerAmount'] = $row->retailerPrice;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['productAmount'] = $row->chargedAmount;
				if((!empty($row->retailerDiscount))&&($row->retailerDiscount))	
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = ($row->retailerPrice*$row->quantity)-($row->retailerDiscount*$row->quantity);
				}
				else
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['totalRetailAmount'] = $row->retailerPrice*$row->quantity;
				}
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['totalProductAmount'] = $row->chargedAmount*$row->quantity;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['organizationProductId'] = $row->organizationProductId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['productId'] = $row->productId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['marketingProductId'] = $row->marketingProductId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['trackingNbr'] = $row->trackingNbr;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['orderStatusId'] = $row->orderStatusId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['retailerDiscount'] = $row->retailerDiscount;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['colorId'] = $row->colorId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['productSizeId'] = $row->size;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['productImageId'] = $row->productImageId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['deliveredDate'] = $row->deliveredDate;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['productWeight'] = $row->productWeight;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['inventoryHistoryId'] = $row->inventoryHistoryId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['active'] = $row->active;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['createDt'] = $row->createDt;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['createBy'] = $row->createBy;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['lastModifiedDt'] = $row->lastModifiedDt;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['lastModifiedBy'] = $row->last_Modified_By;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['pickupId'] = $row->pickupId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['pickupProcessingAmount'] = $row->pickupProccessPrice;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['shippingOrgId'] = $shippingOrgId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['shippingRateId'] = $shippingRateId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['shippingAmount'] = $shipping_rate;
				
				if((!empty($row->isEconomicDelivery))&&($row->isEconomicDelivery))
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $row->eta+7;
				}
				else
				{
					$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['estimateDayDelivery'] = $row->eta+2;
				}

				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['verifiedStatus'] = $row->verifiedStatus;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['commissionPrice'] = $row->commissionPrice;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['totalCommissionPrice'] = $row->totalCommissionPrice;
				
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['freeShipCatId'] = $row->freeShipCatId;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['freeShipPrdId'] = $row->freeShipPrdId;
								$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['spacePointePrice'] = $row->spacePointePrice;

				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['categoryCommission'] = $row->categoryCommission;

				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['cashAdminPrice'] = $row->cashAdminPrice;

				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['isCashAdmin'] = $row->cashAdminFee;
				$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['isGenuineShipp'] = $row->genuineShippFee;


				
				$this->db->where('orderId',$row->orderId);
				$addressDet = $this->db->get('order_address')->result();
				if(!empty($addressDet))
				{
					foreach($addressDet as $addressRow)
					{
						$atAtimeOrder[$row->atATimeProduct]['addressDet'][$addressRow->addressTypeId] = $addressRow->addressId;
					}
				}	
				
				$this->db->where('orderId',$row->orderId);
				$trackDet = $this->db->get('order_track_details')->result();
				//echo "<pre>"; print_r($trackDet); exit;
				if(!empty($trackDet))
				{
					foreach($trackDet as $trackRow)
					{
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['trackDetails'][$trackRow->orderTrackId]['orderStatusId'] = $trackRow->orderStatusId;
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['trackDetails'][$trackRow->orderTrackId]['lastModifiedBy'] = $trackRow->lastModifiedBy;
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['trackDetails'][$trackRow->orderTrackId]['createBy'] = $trackRow->lastModifiedBy;
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['trackDetails'][$trackRow->orderTrackId]['createDt'] = date('Y-m-d H:i:s',$trackRow->createTime);
						$atAtimeOrder[$row->atATimeProduct]['customOrderId'][$row->customOrderId]['productDet'][$row->organizationProductId]['trackDetails'][$trackRow->orderTrackId]['lastModifiedDt'] = date('Y-m-d H:i:s',$trackRow->lastModifiedTime);
					}
				}			
			}
		}
		
		//echo "<pre> "; print_r($atAtimeOrder); exit;
		if(!empty($atAtimeOrder))
		{
			foreach($atAtimeOrder as $atATimeKey=>$orderTotal)
			{
				$atAtimeOrder[$atATimeKey]['totalCashHandlingAmount'] = 0;
				if($orderTotal['isPickup'])
				{
				}
				else
				{
					if($orderTotal['paymentStatus'])
					{
					}
					else
					{
						foreach($orderTotal['customOrderId'] as $custIdKey=>$customRow)
						{
							$atAtimeOrder[$atATimeKey]['customOrderId'][$custIdKey]['totalCustomAmount'] = $customRow['totalCustomAmount']+($customRow['totalCustomAmount']*$this->config->item('space_point_comission'))/100;
							
							$atAtimeOrder[$atATimeKey]['customOrderId'][$custIdKey]['totalCustomCashHandlingAmount'] = $customRow['totalCustomAmount']*$this->config->item('space_point_comission')/100;			
							
							if((!empty($atAtimeOrder[$atATimeKey]['totalCashHandlingAmount']))&&($atAtimeOrder[$atATimeKey]['totalCashHandlingAmount']))
							{
								$atAtimeOrder[$atATimeKey]['totalCashHandlingAmount'] = $atAtimeOrder[$atATimeKey]['totalCashHandlingAmount']+$atAtimeOrder[$atATimeKey]['customOrderId'][$custIdKey]['totalCustomCashHandlingAmount'];
							}
							else
							{
								$atAtimeOrder[$atATimeKey]['totalCashHandlingAmount'] = $atAtimeOrder[$atATimeKey]['customOrderId'][$custIdKey]['totalCustomCashHandlingAmount'];
							}
						}
					}
				}
			}
			
			foreach($atAtimeOrder as $orderTotal)
			{
				$insertOpt1 = array(
								'orderTypeId'           	=> $orderTotal['orderTypeId'],										
								'customerId'            	=> $orderTotal['customerId'],
								'totalAmount'               => $orderTotal['totalAmount'],
								'totalShippingAmount'       => $orderTotal['totalShippingAmount'],
								'totalCashHandlingAmount'	=> $orderTotal['totalCashHandlingAmount'],
								'totalPickupProccessAmount' => $orderTotal['totalPickupProccessAmount'],
								'isPointeForce'				=> $orderTotal['isPointeForce'],
								'isEconomicDelivery' 		=> $orderTotal['isEconomicDelivery'],
								'isMobileDevice'			=> $orderTotal['isMobileDevice'],
								'isPickup'         			=> $orderTotal['isPickup'],
								'paymentTypeId'        		=> $orderTotal['paymentTypeId'],
								'paymentStatus'         	=>  $orderTotal['paymentStatus'],
								'paymentRef'     			=> $orderTotal['payment_reference'],
								'retrievalRef'   	=> $orderTotal['retrieval_reference'],
								'transactionRef' 	=> $orderTotal['transaction_reference'],
								'merchantRef'		=> $orderTotal['merchant_reference'],
								'transactionDate'	    	=> $orderTotal['transaction_date'],
								'active'       	    		=> 1,
								'createDt'		        	=> $orderTotal['createDt'],
								'createBy'			    	=> $orderTotal['createBy'],
								'lastModifiedBy'      		=> $orderTotal['last_Modified_By'],
								'lastModifiedDt' 	    	=> $orderTotal['lastModifiedDt'],	
							 );	
				$this->db->insert('order_total',$insertOpt1);
				$orderTotalId =  $this->db->insert_id();
				
				if(!empty($orderTotalId))
				{
					foreach($orderTotal['customOrderId'] as $customRow)
					{
						$insertOpt2 = array(
								'orderTotalId'           		  => $orderTotalId,	
								'customOrderId'            		  => $customRow['customOrderId'],
								'organizationId'                  => $customRow['organizationId'],
								'dropShipCenterId'       		  => $customRow['dropShipCenterId'],
								'totalCustomAmount'				  => $customRow['totalCustomAmount'],
								'totalCustomShippingAmount' 	  => $customRow['totalCustomShippingAmount'],
								'totalCustomCashHandlingAmount'   => $customRow['totalCustomCashHandlingAmount'],
								'totalCustomPickupProccessAmount' => $customRow['totalCustomPickupProccessAmount'],
								'totalRetailerAmount'         	  => $customRow['totalRetailerAmount'],
								'totalCustomPointeForceAmount'    => $customRow['totalCustomPointeForceAmount'],
								'active'       	    			  => 1,
								'createDt'		        	=> $orderTotal['createDt'],
								'createBy'			    	=> $orderTotal['createBy'],
								'lastModifiedBy'      		=> $orderTotal['last_Modified_By'],
								'lastModifiedDt' 	    	=> $orderTotal['lastModifiedDt'],	
							 );	
						$this->db->insert('order_custom_payment',$insertOpt2);
						$orderCustomPaymentId = $this->db->insert_id();
						
						if($orderCustomPaymentId)
						{
							foreach($customRow['productDet'] as $productRow)
							{
								$insertOpt3 = array(
											'orderCustomPaymentId'  => $orderCustomPaymentId,	
											'quantity'              => $productRow['quantity'],
											'retailerAmount'        => $productRow['retailerAmount'],
											'productAmount'       	=> $productRow['productAmount'],
											'totalRetailAmount'     => $productRow['totalRetailAmount'],
											'totalProductAmount'    => $productRow['totalProductAmount'],
											'organizationProductId' => $productRow['organizationProductId'],
											'productId' 	  		=> $productRow['productId'],
											'marketingProductId'    => $productRow['marketingProductId'],
											'trackingNbr'			=> $productRow['trackingNbr'],
											'orderStatusId' 		=> $productRow['orderStatusId'],
											'retailerDiscount'      => $productRow['retailerDiscount'],
											'colorId'    			=> $productRow['colorId'],
											'productSizeId'    		=> $productRow['productSizeId'],
											'productImageId'    	=> $productRow['productImageId'],
											'productWeight'    		=> $productRow['productWeight'],
											'deliveredDate'			=> $productRow['deliveredDate'],
											'inventoryHistoryId'    => $productRow['inventoryHistoryId'],
											'active'       	    	=> $productRow['active'],
											'createDt'		        => $productRow['createDt'],
											'createBy'			    => $productRow['createBy'],
											'lastModifiedBy'      	=> $productRow['lastModifiedBy'],
											'lastModifiedDt' 	    => $productRow['lastModifiedDt'],	
									);	
								$this->db->insert('order_details',$insertOpt3);
								$orderDetailId =  $this->db->insert_id();
								
								if($orderTotal['isPickup'])									
								{
									if($orderDetailId)
									{
										$insertOpt4 = array(
														'orderDetailId'           		  => $orderDetailId,	
														'pickupId'						  => $productRow['pickupId'],
														'shippingOrgId'            		  => $productRow['shippingOrgId'],
														'shippingRateId'                  => $productRow['shippingRateId'],
														'pickupProcessingAmount'		  => $productRow['pickupProcessingAmount'],
														'estimateDayDelivery'			  => $productRow['estimateDayDelivery'],
														'active'       	    			  => 1,
														'createDt'		        	=> $productRow['createDt'],
														'createBy'			    	=> $productRow['createBy'],
														'lastModifiedBy'      		=> $productRow['lastModifiedBy'],
														'lastModifiedDt' 	    	=> $productRow['lastModifiedDt'],														
													 );	
										$this->db->insert('order_pickup',$insertOpt4);
										$orderShippingVendorId = $this->db->insert_id();
									}
								}
								else
								{
									if($orderDetailId)
									{
										$active = 1;
										if((!empty($orderTotal['isEconomicDelivery']))&&($orderTotal['isEconomicDelivery']))
										{
											if((!empty($checkcA))&&(in_array($customRow['customOrderId'],$checkcA)))
											{
												$active = 0;
											}
											$checkcA[] = $customRow['customOrderId'];
										}
										$insertOpt4 = array(
												'orderDetailId'					 	  => $orderDetailId,
												'shippingOrgId'					  => $productRow['shippingOrgId'],
												'shippingRateId'		 		  => $productRow['shippingRateId'],
												'shippingAmount'		 		  => $productRow['shippingAmount'],
												'estimateDayDelivery'			  => $productRow['estimateDayDelivery'],
												'active'						  => $active,	
												'createBy'						  => $productRow['createBy'],
												'createDt'						  => $productRow['createDt'],
												'lastModifiedBy'				  => $productRow['lastModifiedBy'],
												'lastModifiedDt'				  => $productRow['lastModifiedDt'],
											);
										$this->db->insert('order_shipping_vendor',$insertOpt4);
									}
								}
								
								if((!empty($orderTotal['isPointeForce']))&&($orderTotal['isPointeForce']))
								{
									$verifiedStatus = 0;
									if($productRow['verifiedStatus'])
									{
										$verifiedStatus = 1;
									}
									$commissionPrice = 0;
									if($productRow['commissionPrice'])
									{
										$commissionPrice = $productRow['commissionPrice'];
									}
									$totalCommissionPrice = 0;
									if($productRow['totalCommissionPrice'])
									{
										$totalCommissionPrice = $productRow['totalCommissionPrice'];
									}
									
									$insertOpt6 = array(
												'orderDetailId'					 	  => $orderDetailId,
												'verifiedStatus'				  => $verifiedStatus,
												'customerId'		 			  => $orderTotal['customerId'],
												'commissionPrice'		 		  => $commissionPrice,
												'totalCommissionPrice'			  => $totalCommissionPrice,
												'active'						  => $productRow['active'],	
												'createBy'						  => $productRow['createBy'],
												'createDt'						  => $productRow['createDt'],
												'lastModifiedBy'				  => $productRow['lastModifiedBy'],
												'lastModifiedDt'				  => $productRow['lastModifiedDt'],
											);
										$this->db->insert('order_pointe_force',$insertOpt6);
									//echo $this->db->last_query(); exit;	
								}
								
								$freeShipCatId = 0;
								if($productRow['freeShipCatId'])
								{
									$freeShipCatId = $productRow['freeShipCatId'];
								}
								$freeShipPrdId = 0;
								if($productRow['freeShipPrdId'])
								{
									$freeShipPrdId = $productRow['freeShipPrdId'];
								}
								$insertOpt7 = array(
												'orderDetailId'      => $orderDetailId,	
												'freeShipCatId'      => $freeShipCatId,
												'freeShipPrdId'      => $freeShipPrdId,
												'spacePointePrice'   => $productRow['spacePointePrice'],
												'categoryCommission' => $productRow['categoryCommission'],
												'cashAdminPrice'	 => $productRow['cashAdminPrice'],
												'isCashAdmin'		 => $productRow['isCashAdmin'],
												'isGenuineShipp'	 => $productRow['isGenuineShipp'],
												'active'       	     => 1,
												'createBy'						  => $productRow['createBy'],
												'createDt'						  => $productRow['createDt'],
												'lastModifiedBy'				  => $productRow['lastModifiedBy'],
												'lastModifiedDt'				  => $productRow['lastModifiedDt'],	
											 );	
								$this->db->insert('order_free_shipping_details',$insertOpt7);
								
								if(!empty($productRow['trackDetails']))
								{
									foreach($productRow['trackDetails'] as $trackRow)
									{
										$insertOpt8 = array(
														'orderDetailId'  => $orderDetailId,
														'orderStatusId'  => $trackRow['orderStatusId'],
														'active' 		 => 1,
														'createBy'	     => $trackRow['createBy'],
														'createDt'		 => $trackRow['createDt'],
														'lastModifiedDt' => $trackRow['lastModifiedDt'],
														'lastModifiedBy' => $trackRow['lastModifiedBy'],
													);
										$this->db->insert('order_track',$insertOpt8);
									}
								}	
							}		
						}
					}
					
					
					if((!empty($orderTotal['addressDet']))&&($orderTotal['addressDet']))
					{
						if($orderTotal['isPickup'])
						{
							if((!empty($orderTotal['addressDet'][3]))&&($orderTotal['addressDet'][3]))
							{
										$insertOpt8 = array(
														'orderTotalId'   => $orderTotalId,
														'addressId'      => $orderTotal['addressDet'][3],
														'addressTypeId'  => 1,
														'active' 		 => 1,
														'createDt'		        	=> $orderTotal['createDt'],
														'createBy'			    	=> $orderTotal['createBy'],
														'lastModifiedBy'      		=> $orderTotal['last_Modified_By'],
														'lastModifiedDt' 	    	=> $orderTotal['lastModifiedDt'],						
													 );
										$this->db->insert('order_address_detail',$insertOpt8);
										$this->db->insert_id();	
		
							}
						}
						else
						{
							if((!empty($orderTotal['addressDet'][3]))&&($orderTotal['addressDet'][3]))
							{
										$insertOpt8 = array(
														'orderTotalId'   => $orderTotalId,
														'addressId'      => $orderTotal['addressDet'][3],
														'addressTypeId'  => 3,
														'active' 		 => 1,
														'createDt'		        	=> $orderTotal['createDt'],
														'createBy'			    	=> $orderTotal['createBy'],
														'lastModifiedBy'      		=> $orderTotal['last_Modified_By'],
														'lastModifiedDt' 	    	=> $orderTotal['lastModifiedDt'],						
													 );
										$this->db->insert('order_address_detail',$insertOpt8);
										$this->db->insert_id();	
		
									}
							if((!empty($orderTotal['addressDet'][4]))&&($orderTotal['addressDet'][4]))
							{
										$insertOpt9 = array(
														'orderTotalId'   => $orderTotalId,
														'addressId'      => $orderTotal['addressDet'][4],
														'addressTypeId'  => 4,
														'active' 		 => 1,
														'createDt'		        	=> $orderTotal['createDt'],
														'createBy'			    	=> $orderTotal['createBy'],
														'lastModifiedBy'      		=> $orderTotal['last_Modified_By'],
														'lastModifiedDt' 	    	=> $orderTotal['lastModifiedDt'],						
													 );
										$this->db->insert('order_address_detail',$insertOpt9);
										$this->db->insert_id();	
									}
						}
					}
					else
					{
						if($orderTotal['isPickup'])
						{
							$this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
							$this->db->from('address');
							$this->db->join('customer_address','address.addressId = customer_address.addressId');
							$this->db->join('customer', 'customer_address.customerId = customer.customerId');
							$this->db->join('country', 'address.country = country.countryId', 'left');
							$this->db->join('state', 'address.state = state.stateId', 'left');
							$this->db->join('area', 'address.area = area.areaId', 'left');
							$this->db->join('zip', 'address.city = zip.zipId', 'left');
							$this->db->where(array('customer_address.active' => 1, 'customer_address.addressTypeId' => 1, 'customer_address.customerId' => $customerId));
							$addDet = $this->db->get()->row();
							$shippCusAddId = 0;
							if(!empty($addDet))
							{
								$shippCusAddId = $addDet->addressId;
								
										$insertOpt10 = array(
														'orderTotalId'   => $orderTotalId,
														'addressId'      => $shippCusAddId,
														'addressTypeId'  => 1,
														'active' 		 => 1,
														'createDt'		        	=> $orderTotal['createDt'],
														'createBy'			    	=> $orderTotal['createBy'],
														'lastModifiedBy'      		=> $orderTotal['last_Modified_By'],
														'lastModifiedDt' 	    	=> $orderTotal['lastModifiedDt'],						
													 );
										$this->db->insert('order_address_detail',$insertOpt10);
										$this->db->insert_id();	
		
							
							}
						}
					}
				}			
			}
		}
		echo "<pre> "; print_r($atAtimeOrder); exit;
	*/}
	
	public function addTest()
	{
		$viewData['categoryList'] = $this->category_lib->category_level_list();
		echo "<pre>"; print_r($viewData['categoryList']); exit;
	}
}