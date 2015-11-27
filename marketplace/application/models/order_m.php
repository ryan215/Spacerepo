<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function pickup_order_list($orderDetailId)
	{
		$this->db->select('order_total.orderTotalId,order_total.paymentStatus,order_total.isPickup,order_total.isPointeForce, order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_details.orderDetailId,order_details.active,order_details.orderStatusId,order_details.trackingNbr,order_custom_payment.dropShipCenterId,order_details.totalRetailAmount,order_details.organizationProductId,order_total.customerId,order_total.isEconomicDelivery,order_custom_payment.totalRetailerAmount,order_details.organizationProductId,order_pickup.shippingOrgId,order_pickup.pickupId,order_pickup.estimateDayDelivery,order_pickup.pickupProcessingAmount');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active' 		  	 => 1,
							'order_custom_payment.active' 	 => 1,
							'order_details.orderDetailId'	 => $orderDetailId,
							'order_total.isPickup'			 => 1,
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function quick_shippment_order_list($orderDetailId)
	{
		$this->db->select('order_total.orderTotalId,order_total.paymentStatus,order_total.isPickup,order_total.isPointeForce, order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_details.orderDetailId,order_details.active,order_details.orderStatusId,order_details.trackingNbr,order_custom_payment.dropShipCenterId,order_details.totalRetailAmount,order_details.organizationProductId,order_total.customerId,order_total.isEconomicDelivery,order_custom_payment.totalRetailerAmount,order_details.organizationProductId,order_shipping_vendor.shippingOrgId,order_shipping_vendor.estimateDayDelivery,order_shipping_vendor.shippingRateId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active' 		  	 => 1,
							'order_custom_payment.active' 	 => 1,
							'order_details.orderDetailId'	 => $orderDetailId,
							'order_total.isEconomicDelivery' => 0,
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function order_shipping_address_detail($orderTotalId)
	{		
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('order_total');
		$this->db->join('order_address_detail','order_total.orderTotalId=order_address_detail.orderTotalId');
		$this->db->join('address','order_address_detail.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('order_total.orderTotalId' => $orderTotalId,'order_address_detail.addressTypeId' => 3));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_billing_address_detail($orderTotalId)
	{		
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('order_total');
		$this->db->join('order_address_detail','order_total.orderTotalId=order_address_detail.orderTotalId');
		$this->db->join('address','order_address_detail.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('order_total.orderTotalId' => $orderTotalId,'order_address_detail.addressTypeId' => 4));
		$result = $this->db->get();
		return $result->row();
	}
		
	public function custom_track_order_time($orderDetailId)
	{
		$this->db->select('order_track.orderTrackId,order_track.orderStatusId,order_track.createDt');
		$this->db->from('order_track');
		$this->db->where(array(
						'order_track.orderDetailId' => $orderDetailId,
						'order_track.active' 		=> 1
						));
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function single_shippment_order_list($orderCustomPaymentId)
	{		
		$this->db->select('order_total.orderTotalId,order_total.paymentStatus,order_total.isPickup,order_total.isPointeForce, order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_details.orderDetailId,order_details.active,order_details.orderStatusId,order_details.trackingNbr,order_custom_payment.dropShipCenterId,order_details.totalRetailAmount,order_details.organizationProductId,order_total.customerId,order_total.isEconomicDelivery,order_custom_payment.totalRetailerAmount,order_details.organizationProductId,order_shipping_vendor.shippingOrgId,order_shipping_vendor.estimateDayDelivery,order_shipping_vendor.shippingRateId,order_details.quantity,order_details.colorId,order_details.productSizeId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active' 		  				=> 1,
							'order_custom_payment.active' 				=> 1,
							'order_custom_payment.orderCustomPaymentId' => $orderCustomPaymentId,
							'order_total.isEconomicDelivery' 			=> 1,
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function custom_orders_list($start=0,$limit='',$where='')
	{
		$sql = 'SELECT 	
			order_custom_payment.totalCustomAmount,order_custom_payment.createDt,order_custom_payment.customOrderId,order_total.isEconomicDelivery,order_total.paymentStatus,organization.organizationName,employee.businessPhone,order_details.orderStatusId,dropship_center.dropCenterName,GROUP_CONCAT(product.code SEPARATOR " / ") AS productName,customer.firstName,customer.lastName,customer.phone,order_total.isPickup,order_details.active,order_custom_payment.orderCustomPaymentId,state.stateName,area.area AS areaName,zip.city AS cityName,employee.businessPhoneCode,order_details.orderDetailId,order_custom_payment.totalRetailerAmount
				FROM 
					`order_total` 
				INNER JOIN
					`order_custom_payment`
				ON
					order_total.orderTotalId = order_custom_payment.orderTotalId
				INNER JOIN
					`order_details`
				ON
					order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId
				INNER JOIN
					`product`
				ON
					order_details.productId = product.productId
				INNER JOIN
					`dropship_center`
				ON
					order_custom_payment.dropShipCenterId = dropship_center.dropCenterId
				INNER JOIN
					`organization`
				ON
					order_custom_payment.organizationId = organization.organizationId
				INNER JOIN
					`employee`
				ON
					organization.organizationId = employee.organizationId
				INNER JOIN
					`customer`
				ON
					order_total.customerId = customer.customerId
				LEFT JOIN
					`order_address_detail`
				ON
					order_total.orderTotalId = order_address_detail.orderTotalId AND order_address_detail.addressTypeId = 3
				LEFT JOIN
					`address`
				ON
					order_address_detail.addressId = address.addressId
				LEFT JOIN
					`country`
				ON
					address.country = country.countryId
				LEFT JOIN
					`state`
				ON
					address.state = state.stateId
				LEFT JOIN
					`area`
				ON
					address.area = area.areaId
				LEFT JOIN
					`zip`
				ON
					address.city = zip.zipId 
				WHERE
					order_total.active = 1
				AND
					order_custom_payment.active = 1
				';
			
			if($this->session->userdata('userType')=='retailer')
			{
				$sql.=' AND order_custom_payment.organizationId = '.$this->session->userdata('organizationId');
			}
			
			if($where)
			{
				$sql.=' AND ('.$where.')';
			}
			$runSql = $sql.' GROUP BY CASE WHEN order_total.isEconomicDelivery=1 THEN order_details.orderCustomPaymentId ELSE order_details.orderDetailId END ORDER BY order_custom_payment.createDt DESC ';
			if(!empty($limit))
			{
				$runSql.= ' LIMIT '.$start.','.$limit;
			}
			$result = $this->db->query($runSql)->result();
			return $result;		
	}
	
	public function order_list($start=0,$limit='',$where='')
	{
		$sql = 'SELECT 	order.orderId,(order.retailerPrice*order.quantity) AS retailerPrice,order.totalAmount,order.chargedAmount,order.quantity,order.orderStatusId,order.customOrderId,order.isPickup,order.createDt,order_payment.paymentStatus,product.code,organization.organizationName,employee.businessPhoneCode,employee.businessPhone,dropship_center.dropCenterName,customer.phone,state.stateName,area.area AS areaName,zip.city AS cityName,customer.firstName,customer.lastName,order.active,order_free_shipping.freeShipCatId,order_free_shipping.freeShipPrdId,order_payment.genuineShippFee,shipping_rate.amount AS shippingRate,order_payment.cashHandlingPrice,order.isEconomicDelivery,order_economical_delivery_details.isCalculateShipp,order_economical_delivery_details.cashHandlingPrice AS economicCashHandFee,order_economical_delivery_details.totalProductWeight,order.isEconomicDelivery,group_concat(DISTINCT product.code SEPARATOR " / ") AS code,order_payment.productWeight
				FROM 
					`order` 
				INNER JOIN
					`order_payment`
				ON
					order.orderId = order_payment.orderId
				INNER JOIN
					`product`
				ON
					order.productId = product.productId
				INNER JOIN
					`organization_product`
				ON
					order.organizationProductId = organization_product.organizationProductId
				INNER JOIN
					`organization`
				ON
					organization_product.organizationId = organization.organizationId
				INNER JOIN
					`employee`
				ON
					organization.organizationId = employee.organizationId
				INNER JOIN
					`dropship_center`
				ON
					organization.dropshipCentre = dropship_center.dropCenterId
				INNER JOIN
					`order_dropship_center`
				ON
					order.orderId = order_dropship_center.orderId
				INNER JOIN
					`customer`
				ON
					order.customerId = customer.customerId
				LEFT JOIN
					`order_free_shipping`
				ON
					order.orderId = order_free_shipping.orderId
				LEFT JOIN
					`shipping_rate`
				ON
					order.shippingRateId = shipping_rate.shippingRateId
				INNER JOIN
					`order_address`
				ON
					order.orderId = order_address.orderId
				LEFT JOIN
					`address`
				ON
					order_address.addressId = address.addressId
				LEFT JOIN
					`state`
				ON
					address.state = state.stateId
				LEFT JOIN
					`area`
				ON
					address.area = area.areaId
				LEFT JOIN
					`zip`
				ON
					address.city = zip.zipId
				LEFT JOIN
					`order_economical_delivery_details`
				ON
					order.customOrderId = order_economical_delivery_details.customOrderId ';
			$whereSql = '';		
			if($this->session->userdata('userType')=='retailer')
			{
				$whereSql ='WHERE organization_product.organizationId = '.$this->session->userdata('organizationId');
			}
			
			if($where)
			{
				if($whereSql)
				{
					$whereSql.=' AND ('.$where.')';
				}
				else
				{
					$whereSql =' WHERE ('.$where.')';
				}
			}
			$sql.= $whereSql.' GROUP BY CASE WHEN order.isEconomicDelivery=1 THEN order.customOrderId ELSE order.orderId END ORDER BY order.createDt DESC ';
			if(!empty($limit))
			{
				$sql.= ' LIMIT '.$start.','.$limit;
			}
			$result = $this->db->query($sql);
			//echo $this->db->last_query(); exit;	
			return $result->result();		
			/*
		$this->db->select('order.orderId,order.chargedAmount,order.quantity,order.orderStatusId,order.customOrderId,order.isPickup,order.createDt,order_payment.paymentStatus,product.code,organization.organizationName,employee.businessPhoneCode,employee.businessPhone,dropship_center.dropCenterName,customer.phone,state.stateName,area.area AS areaName,zip.city AS cityName,customer.firstName,customer.lastName,order.active,order_free_shipping.freeShipCatId,order_free_shipping.freeShipPrdId,order_payment.genuineShippFee,shipping_rate.amount AS shippingRate,order_payment.cashHandlingPrice,order.isEconomicDelivery,order_economical_delivery_details.isCalculateShipp,order_economical_delivery_details.cashHandlingPrice AS economicCashHandFee,order_economical_delivery_details.totalProductWeight,order.isEconomicDelivery');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		$this->db->join('customer','order.customerId = customer.customerId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('shipping_rate','order.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('order_address','order.orderId = order_address.orderId');
		$this->db->join('address','order_address.addressId = address.addressId','left');
		$this->db->join('state','address.state = state.stateId','left');
        $this->db->join('area','address.area = area.areaId','left');
        $this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('order_economical_delivery_details','order.customOrderId = order_economical_delivery_details.customOrderId AND order.customerId = order_economical_delivery_details.createdBy','left');		
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->group_by('order.orderId');
		$this->db->order_by('order.createDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	*/}
	
	public function order_total_detail($orderTotalId)
	{
		$this->db->select('order_total.totalAmount,order_total.isPickup');
		$this->db->from('order_total');
		$this->db->where(array(
							'order_total.orderTotalId' => $orderTotalId,
							'order_total.active'	   => 1,
						));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function customer_custom_order_list()
	{		
		$this->db->select('order_total.orderTotalId,order_total.paymentStatus,order_total.isPickup,order_total.isPointeForce, order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_pickup.pickupProcessingAmount,order_pickup.pickupId,order_details.orderDetailId,order_details.active,order_details.orderStatusId,order_shipping_vendor.shippingAmount,order_details.trackingNbr,order_pointe_force.paidStatus AS pointeForcePaidStatus,order_pointe_force.totalCommissionPrice,order_details.createDt,order_shipping_vendor.estimateDayDelivery AS estimateDayShipp,order_pickup.estimateDayDelivery AS estimateDayPickUp,order_details.deliveredDate');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId','left');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId','left');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId AND order_pointe_force.active = 1 AND order_pointe_force.verifiedStatus = 1','left');
		$this->db->where(array(
						'order_total.customerId' 	  => $this->session->userdata('userId'),
						'order_total.active'		  => 1,
						'order_custom_payment.active' => 1,
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function order_custom_payment_list($orderTotalId)
	{
		$this->db->select('order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_pickup.pickupProcessingAmount,order_pickup.pickupId,order_details.orderDetailId');
		$this->db->from('order_custom_payment');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId','left');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
						'order_custom_payment.orderTotalId' => $orderTotalId,
						'order_custom_payment.active' 		=> 1,
						'order_details.active' 				=> 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	
	
	public function order_customer_detail($orderTotalId)
	{		
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('order_total');
		$this->db->join('order_address_detail','order_total.orderTotalId=order_address_detail.orderTotalId');
		$this->db->join('address','order_address_detail.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('order_total.orderTotalId' => $orderTotalId,'order_address_detail.addressTypeId' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_pickup_detail($orderTotalId)
	{		
		$this->db->select('order_pickup.pickupId');
		$this->db->from('order_custom_payment');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId=order_details.orderCustomPaymentId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId');
		$this->db->where(array(
							'order_custom_payment.orderTotalId' => $orderTotalId,
							'order_details.active' 				=> 1,
							'order_pickup.active' 				=> 1
							));
		$result = $this->db->get();
		return $result->row();
	}

	public function custom_order_details($orderDetailId)
	{		
		$this->db->select('order_total.orderTotalId,order_total.paymentStatus,order_total.isPickup,order_total.isPointeForce, order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_pickup.pickupProcessingAmount,order_pickup.pickupId,order_details.orderDetailId,order_details.active,order_details.orderStatusId,order_shipping_vendor.shippingAmount,dropship_center.dropCenterName,order_pickup.estimateDayDelivery AS estimateDayPickup,order_shipping_vendor.estimateDayDelivery AS estimateDayShipp');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('dropship_center','order_custom_payment.dropShipCenterId = dropship_center.dropCenterId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId','left');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId','left');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
						'order_details.orderDetailId' => $orderDetailId,
						'order_custom_payment.active' => 1,
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	
	
	public function total_new_order_in_shipping_admin($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','order.shippingOrgId = organization.organizationId');
        $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');

        if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('(order.orderStatusId = 1 OR order.orderStatusId = 6)');
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->where(array('order.orderStatusId' => 1,'order.isPickup' => 0));
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
        }
		else
		{
			$this->db->where(array('order.orderStatusId' => 1,'order.isPickup' => 0));
			$userRole = $this->session->userdata('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
		}
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->where(array('product_image.displayOrder' => 1,'order.active' => 1));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function new_order_list_in_shipping_admin($start=0,$limit='',$where='')
	{
		$this->db->select("product_image.*,order_payment.*,order.*,organization_product.productId,organization_product.productCodeOveride,organization_product.currentPrice,organization.organizationName,employee.firstName,employee.lastName,product.code as productCodeOveride,product.code,dropship_center.dropCenterName");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
        $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
        $this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('(order.orderStatusId = 1 OR order.orderStatusId = 6)');
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{	
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');		
			$this->db->where(array('order.orderStatusId' => 1,'order.isPickup' => 0));		
        }
		else
		{
			$userRole = $this->session->userdata('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where(array('order.orderStatusId' => 1,'order.isPickup' => 0));
		}
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->where(array('product_image.displayOrder' => 1,'order.active' => 1));
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function new_order_details($orderId)
	{
		$this->db->select("order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderStatusId' => 1,'order.orderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function economic_new_order_details($orderId)
	{
		$this->db->select("order_economical_delivery_details.*,order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*,product.code,product_image.imageName,organization.organizationName,employee.email,employee.businessPhoneCode,employee.businessPhone,dropship_center.dropCenterName");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_economical_delivery_details','order.customOrderId = order_economical_delivery_details.customOrderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');		
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderStatusId' => 1,'order.customOrderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function total_confirmation_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		 $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','order.shippingOrgId = organization.organizationId');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('(order.orderStatusId = 2 OR order.orderStatusId = 3 OR order.orderStatusId = 4 OR order.orderStatusId = 5)');
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.orderStatusId' => 2,'order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where(array('order.orderStatusId' => 2,'isPickup' => 0));
		}
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->where(array('product_image.displayOrder' => 1,'order.active' => 1));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function confirmation_order_list($start=0,$limit='',$where='')
	{
		$this->db->select("organization_product.productId,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,organization_product.currentPrice,product.code ,product_image.*,product.code,order_payment.*,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		   $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('(order.orderStatusId = 2 OR order.orderStatusId = 3 OR order.orderStatusId = 4)');
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.orderStatusId' => 2,'order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where(array('order.orderStatusId' => 2,'isPickup' => 0));
		}
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->where(array('product_image.displayOrder' => 1,'order.active' => 1));
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function confirmation_order_details($orderId)
	{
		$this->db->select("order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderStatusId' => 2,'order.orderId' => $orderId,'order.active' => 1));		
		$result = $this->db->get();
	//echo "<pre>";	print_r($result->row()); exit;
		return $result->row();
	}
	
	public function total_ready_to_be_shipped_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','order.shippingOrgId = organization.organizationId');
		$this->db->where(array('order.orderStatusId' => 3,'order.active' => 1,'product_image.displayOrder' => 1));
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where('order.isPickup',0);
		}
		
		if($where)
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function ready_shipped_order_list($start=0,$limit='',$where='')
	{
		$this->db->select("organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,product.*,product_image.*,order_payment.*,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId = order.shippingRateId','left');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->where(array('order.orderStatusId' => 3,'product_image.displayOrder' => 1,'order.active' => 1));
		if($this->session->userdata('userType')=='retailer')
		{			
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where('order.isPickup',0);
		}
				
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		
		return $result->result();
	}
	
	public function ready_shipped_order_details($orderId)
	{
		$this->db->select("order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderStatusId' => 3,'order.orderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function total_shipped_in_transit_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','order.shippingOrgId = organization.organizationId');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where('order.isPickup',0);
		}
		$this->db->where(array('order.orderStatusId' => 4,'product_image.displayOrder' => 1,'order.active' => 1));
		
		if($where)
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function shipped_in_transit_order_list($start=0,$limit='',$where='')
	{
		$this->db->select("organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,product.*,product_image.*,order_payment.*,order.*");
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where('order.isPickup',0);
		}
		$this->db->where(array('order.orderStatusId' => 4,'product_image.displayOrder' => 1,'order.active' => 1));
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function transit_order_details($orderId)
	{
		$this->db->select("order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderStatusId' => 4,'order.orderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function total_delivered_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','order.shippingOrgId = organization.organizationId');
		
		$this->db->where(array('order.orderStatusId' => 5,'product_image.displayOrder' => 1,'order.active' => 1));
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.isPickup' => 0));
		}
		else
		{
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where('order.isPickup',0);		
		}
		
		if($where)
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function delivered_order_list($start=0,$limit='',$where='')
	{
		$this->db->select("organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,product.*,product_image.*,order_payment.*,order.*");
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->where(array('order.orderStatusId' => 5,'product_image.displayOrder' => 1,'order.active' => 1));
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		elseif($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			$this->db->where(array('order.isPickup' => 0));
		}
		else
		{			
			$userRole = $this->session->userdata ('userRole');
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			$this->db->where('order.isPickup',0);				
		}
		
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	
		/*$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where("orders.status = 4 AND From_UnixTime(orders.order_time,'%Y') >= ".date("Y")." AND From_UnixTime(orders.order_time,'%m') >= ".date("m")." ".$where);
		$this->db->order_by('orders.last_modified_time','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();*/
	}
	
	public function delivered_order_details($orderId)
	{
		$this->db->select("order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');		
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderStatusId' => 5,'order.orderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function total_history_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$userRole = $this->session->userdata ('userRole');
		if($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		}
        elseif(!empty($userRole)) 
		{
			if($userRole == 'SVE') 
			{
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
            }
        }			
		$this->db->where('(order.orderStatusId = 5 OR order.active = 0)');
		$this->db->where('order.isPickup',0);		
		if($where)
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function history_order_list($start=0,$limit='',$where='')
	{
		$this->db->select("order_payment.*,organization_product.productId,organization_product.currentPrice,organization.organizationName,organization_product.productCodeOveride,employee.firstName,employee.lastName,product.*,product_image.*,order.*");//,CONCAT(address.firstName,' ',address.lastName) AS customerName");
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$userRole = $this->session->userdata ('userRole');
		if($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		}
        elseif(!empty($userRole)) 
		{
			if($userRole == 'SVE') 
			{
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
            }
        }
		$this->db->where(array('product_image.displayOrder' => 1,'order.isPickup' => 0)); //,'order_address.addressTypeId' => 3));
		$this->db->where('(order.orderStatusId = 5 OR order.active = 0)');
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	
		/*$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where("orders.status = 4 AND From_UnixTime(orders.order_time,'%Y') >= ".date("Y")." AND From_UnixTime(orders.order_time,'%m') >= ".date("m")." ".$where);
		$this->db->order_by('orders.last_modified_time','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();*/
	
		/*$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where("orders.status = 4 AND From_UnixTime(orders.order_time,'%Y') <= ".date("Y")." AND From_UnixTime(orders.order_time,'%m') < ".date("m")." ".$where);
		$this->db->order_by('orders.last_modified_time','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();*/
	}
	
	public function history_order_details($orderId)
	{
		$this->db->select("order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');		
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderId' => $orderId,'order.isPickup' => 0));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function add_order_address($orderId,$addressId)
	{
		$insertOpt = array(
					 	'orderId'     => $orderId,
						'addressId'      => $addressId,
						'addressTypeId'  => 3,
						'active' 		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('order_address',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_billing_order_address($orderId,$addressId)
	{
		$insertOpt = array(
					 	'orderId'        => $orderId,
						'addressId'      => $addressId,
						'addressTypeId'  => 4,
						'active' 		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('order_address',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function order_billing_details($customerId)
	{
		$this->db->select('customer.*,address.*,country.name AS countryName,state.stateName,zip.city AS cityName');
		$this->db->from('customer');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('zip','address.city = zip.zipId');
		$this->db->where(array('customer.customerId' => $customerId,'customer_address.addressTypeId' => 4));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_shipping_details($customerId)
	{
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName');
		$this->db->from('customer');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('zip','address.city = zip.zipId');
		$this->db->where(array('customer.customerId' => $customerId,'customer_address.addressTypeId' => 3));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_billing_address_details($customerId,$orderId)
	{
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('order');
		$this->db->join('customer','customer.customerId=order.customerId');
		$this->db->join('order_address','order.orderId=order_address.orderId');
		$this->db->join('address','order_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('customer.customerId' => $customerId,'order.orderId' => $orderId,'order_address.addressTypeId' => 4,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_shipping_address_details($customerId,$orderId)
	{		
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('order');
		$this->db->join('order_address','order.orderId=order_address.orderId');
		$this->db->join('address','order_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('order.orderId' => $orderId,'order_address.addressTypeId' => 3));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_shipping_address_details_new($customerId,$orderId)
	{
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('order');
		$this->db->join('customer','customer.customerId=order.customerId');
		$this->db->join('order_address','order.orderId=order_address.orderId');
		$this->db->join('address','order_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('customer.customerId' => $customerId,'order.orderId'=>$orderId));
		$result = $this->db->get();
		return $result->row();
	}

	public function order_retailer_details($organizationProductId)
	{
		$this->db->select('organization.organizationId,organization.organizationName,organization.dropshipCentre,address.*,employee.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName,organization_product.productCodeOveride,organization_product.imageName AS productImageName,organization_product.currentPrice,dropship_center.dropCenterName,product.code,product_image.imageName');
		$this->db->from('organization_product');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');	
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId','left');
		$this->db->join('address','organization_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId','left');
		$this->db->where(array('organization_product.organizationProductId' => $organizationProductId,'product_image.displayOrder' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function order_retailer_with_product_details($organizationProductId)
	{
		$this->db->select('organization.organizationId,organization.organizationName,organization.dropshipCentre,address.*,employee.*,country.name AS countryName,state.stateName,zip.city AS cityName,organization_product.productCodeOveride,organization_product.currentPrice,product_image.imageName AS productImageName,product.code');
		$this->db->from('organization_product');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');	
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId','left');
		$this->db->join('address','organization_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('organization_product.organizationProductId' => $organizationProductId,'product_image.displayOrder' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function order_product_details($organizationProductId)
	{
		$this->db->select('organization_product.*,product.*,product_image.*');
		$this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');	
		$this->db->where(array('organizationProductId' => $organizationProductId,'product_image.displayOrder' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function order_shipping_vendor_details($shippingOrgId)
	{
		$this->db->select("organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,area.area AS areaName,address.addressId,address.addressLine1,address.country,address.state,address.city,employee.businessPhoneCode");
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where(array('role.code' => 'DELIVERYAGENT','organization.organizationId' => $shippingOrgId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function change_new_order_to_ready($order_id,$where='')
	{
		$this->db->where("orderId = $order_id ".$where);
		$this->db->update('order',array('orderStatusId' => 3,'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
		
	public function change_ready_to_transit($order_id,$where='')
	{
		$this->db->where("orderId = $order_id ".$where);
		$this->db->update('order',array('orderStatusId' => 4,'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function change_accept_declined($orderId,$accept_decline)
	{
		$updateArr = array(
						'orderStatusId'    => $accept_decline,
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
						'last_Modified_By' => $this->session->userdata('userId'),
					 );
		$this->db->where('orderId',$orderId);
		$this->db->update('order',$updateArr);
		return $this->db->affected_rows(); 
	}
	
	public function change_accept_declined_economic_order($orderId,$accept_decline)
	{
		$updateArr = array(
						'orderStatusId'    => $accept_decline,
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
						'last_Modified_By' => $this->session->userdata('userId'),
					 );
		$this->db->where('customOrderId',$orderId);
		$this->db->update('order',$updateArr);
		return $this->db->affected_rows(); 
	}
	
	public function total_new_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where('orders.status = 1 '.$where);
		$this->db->where('order.active',1);
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}

	public function change_transit_to_delivered($order_id,$where='')
	{
		$this->db->where("orderId = $order_id ".$where);
		$this->db->update('order',array('orderStatusId' => 5,'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}	
		
	public function save_tracking_number($orderId,$track_no)
	{
		$this->db->where('orderId',$orderId);
		$this->db->update('order',array('trackingNbr' => $track_no,'last_Modified_By' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function economic_save_tracking_number($orderId,$track_no)
	{
		$this->db->where('customOrderId',$orderId);
		$this->db->update('order',array('trackingNbr' => $track_no,'last_Modified_By' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function save_delivered_date($order_id,$delivered_date)
	{
		$this->db->where('orderId',$order_id);
		$this->db->update('order',array('deliveredDate' => $delivered_date,'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function unique_order_id()
	{
		$order_id = 0;
		$this->db->select('unique_order_id');
		$this->db->from('product_identifiers');
		$result = $this->db->get()->row();
		if(!empty($result))
		{
			$order_id = $result->unique_order_id;
		}
		return $order_id;
	}
	
	public function update_unique_order_id($order_id)
	{
		$this->db->update('product_identifiers',array('unique_order_id' => $order_id));
		return $this->db->affected_rows();
	}
	
	public function add_order($addArr)
	{
		if(!empty($addArr['size']))
		{
		}
		else
		{
			$addArr['size'] = 0;
		}
		
		$insertOpt = array(
						'orderTypeId'           => $addArr['orderTypeId'],										
						'totalAmount'           => $addArr['totalAmount'],
						'quantity'              => $addArr['quantity'],
						'customerId'            => $addArr['customerId'],
						'chargedAmount'			=> $addArr['chargedAmount'],
						'organizationProductId' => $addArr['organizationProductId'],
						'productId' 			=> $addArr['productId'],
						'marketingProductId'	=> $addArr['marketingProductId'],
						'orderStatusId'         => $addArr['orderStatusId'],
						'shippingRateId'        => $addArr['shippingRateId'],
						'customOrderId'         => $addArr['customOrderId'],
						'orderEmail'       	    => $addArr['orderEmail'],
						'shippingOrgId'         => $addArr['shippingOrgId'],
						'colorId'       	    => $addArr['colorId'],
						'size'       		    => $addArr['size'],
						'isPickup'				=> $addArr['isPickup'],
						'pickupId'				=> $addArr['pickupId'],
						'isEconomicDelivery'    => $addArr['isEconomicDelivery'],
						'atATimeProduct'	    => $addArr['atATimeProduct'],
						'retailerPrice'			=> $addArr['retailerPrice'],
						'retailerDiscount'		=> $addArr['retailerDiscount'],
						'inventoryHistoryId'	=> $addArr['inventoryHistoryId'],
						'isMobileDevice'		=> 0,
						'createDt'		        => date('Y-m-d H:i:s'),
						'createBy'			    => $this->session->userdata('userId'),
						'last_Modified_By'      => $this->session->userdata('userId'),
						'lastModifiedDt' 	    => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_payment($orderId,$addArr)
	{
		$insertOpt = array(
						'orderId'		      => $orderId,
						'paymentTypeId'       => 1,
						'productImageId'	  => $addArr['productImageId'],
						'amount'      	      => $addArr['totalAmount'],
						'pickupProccessPrice' => $addArr['pickupProccessPrice'],
						'spacePointePrice'    => $addArr['spacePointePrice'],
						'categoryCommission'  => $addArr['categoryCommission'],
						'cashHandlingPrice'   => $addArr['cashHandlingPrice'],
						'cashAdminPrice'      => $addArr['cashAdminPrice'],
						'cashAdminFee'        => $addArr['cashAdminFee'],
						'genuineShippFee'     => $addArr['genuineShippFee'],
						'paymentStatus'       => $addArr['paymentStatus'],
						'paymentRef'          => $addArr['payment_reference'],
						'retrievalRef'        => $addArr['retrieval_reference'],
						'transactionRef'      => $addArr['transaction_reference'],
						'merchantRef'	      => $addArr['merchant_reference'],
						'transactionDate'     => $addArr['transaction_date'],
						'productWeight'       => $addArr['productWeight'],
						'createDt'		      => date('Y-m-d H:i:s'),
						'lastModifiedBy'      => $this->session->userdata('userId'),
						'lastModifiedDt'      => date('Y-m-d H:i:s'),
					 );	
		$this->db->insert('order_payment',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_track_details($orderId,$orderStatusId)
	{
		$insertOpt = array(
						'orderId'          => $orderId,
						'orderStatusId'    => $orderStatusId,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'createTime'       => time(),
						'lastModifiedTime' => time(),
					);
		$this->db->insert('order_track_details',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_dropship_center($orderId,$addArr)
	{
		$insertOpt = array(
						'orderId'		  => $orderId,
						'fromDropshipId'  => 0,
						'toDropshipId' 	  => $addArr['toDropshipId'],
						'createDt'		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'  => $this->session->userdata('userId'),
						'lastModifiedDt'  => date('Y-m-d H:i:s'),
					 );	
		$this->db->insert('order_dropship_center',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_history($orderId,$orderStatusId)
	{
		$insertOpt = array(
						'orderId'		  => $orderId,
						'orderStatusId'   => $orderStatusId,
						'createDt'		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'  => $this->session->userdata('userId'),						
					 );	
		$this->db->insert('order_history',$insertOpt);
		return $this->db->insert_id();
	}
		
	public function track_order($order_id)
	{
		$this->db->select('*');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId	 = organization_product.organizationProductId	');
		$this->db->join('shipping_rate','order.shippingOrgId = shipping_rate.shippingOrgId');
		$this->db->where(array('order.customerId' => $this->session->userdata('userId'),'order.orderId' => $order_id,'order.active' => 1));
		$this->db->order_by('order.orderStatusId','asc');
		$result = $this->db->get();
		return $result->row();
	}
	
	public function user_order_list($customerId)
	{
		$this->db->select('order_free_shipping.*,order.*,order_payment.*,organization_product.*,order.createDt AS orderDate,product_image.imageName AS mainImage,colors.colorCode,product.code,order_pointe_force_commission.totalCommissionPrice,order_pointe_force_commission.verifiedStatus,finance_pointe_force_clear_payment.paidStatus,product_size.sizes AS size');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId	 = organization_product.organizationProductId	');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->join('order_pointe_force_commission','order.orderId = order_pointe_force_commission.orderId','left');
		$this->db->join('finance_pointe_force_clear_payment','order_pointe_force_commission.orderPointeForceId = finance_pointe_force_clear_payment.orderPointeForceId','left');
		$this->db->where(array('order.customerId' => $customerId,'product_image.displayOrder' => 1,'order.active' => 1));
		$this->db->order_by('order.orderStatusId','ASC');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function track_order_details($orderId)
	{
		$this->db->select('order_payment.*,organization_product.*,order.createDt AS orderDate,order.lastModifiedDt,product_image.imageName AS mainImage,colors.colorCode,product.code,order.*,product_size.sizes AS size');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId	 = organization_product.organizationProductId	');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->where(array('order.orderId' => $orderId,'product_image.displayOrder' => 1));
		$this->db->order_by('order.orderStatusId','asc');
		$result = $this->db->get();
		return $result->row();
	}
	
	public function user_dashboard_order_list()
	{
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where(array('orders.user_id' => $this->session->userdata('userId'),'order.active' => 1));
		$this->db->order_by('orders.last_modified_time','desc');
		$this->db->limit(2);
		$result = $this->db->get();
		return $result->result();
	}
	
	public function purchase_product($productId)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where(array('orders.user_id' => $this->session->userdata('userId'),'orders_info.product_id' => $productId,'order.active' => 1));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}	
	
	public function purchase_product_with_retailer($seller_id)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where(array('orders.user_id' => $this->session->userdata('userId'),'orders_info.retailer_id' => $seller_id));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_order_with_product_rating_review($productId)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('product_rating','orders_info.product_id = product_rating.product_id');
		$this->db->join('product_rating_count','product_rating.product_rating_id = product_rating_count.product_rating_id');
		$this->db->where(array('orders.user_id' => $this->session->userdata('userId'),'product_rating.rating_given_by' => $this->session->userdata('userId')));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function order_with_product_rating_review()
	{
		$this->db->select('product_rating.*,product_rating_count.*,orders_info.product_id AS order_product_id,orders_info.product_name,orders_info.product_image,orders_info.product_price,orders_info.product_price,orders.delivered_date,orders.status,orders.estimate_time');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('product_rating','orders_info.product_id = product_rating.product_id AND product_rating.rating_given_by = '.$this->session->userdata('userId'),'left');
		$this->db->join('product_rating_count','product_rating.product_rating_id = product_rating_count.product_rating_id','left');
		$this->db->where('orders.user_id',$this->session->userdata('userId'));
		$this->db->order_by('orders.last_modified_time','desc');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function order_with_retailer_rating_review()
	{
		$this->db->select('retailer_rating.*,retailer_rating_count.*,orders_info.product_id AS order_product_id,orders_info.product_name,orders_info.product_image,orders_info.product_price,orders_info.product_price,orders.delivered_date,orders.status,orders.estimate_time,orders_info.retailer_name,orders_info.retailer_id AS order_retailer_id');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('retailer_rating','orders_info.retailer_id = retailer_rating.retailer_id AND retailer_rating.rating_given_by = '.$this->session->userdata('userId'),'left');
		$this->db->join('retailer_rating_count','retailer_rating.retailer_id = retailer_rating_count.retailer_id','left');
		$this->db->where('orders.user_id',$this->session->userdata('userId'));
		$this->db->group_by('orders_info.retailer_id');
		$this->db->order_by('orders.last_modified_time','desc');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function total_sale_amount_product()
	{
		$this->db->select('SUM(orders.total_amount) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_sale_amount_retailer_cse()
	{
		$this->db->select('SUM(orders.total_amount) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('users','orders_info.retailer_id = users.user_id');
		$this->db->join('profile','users.user_id = profile.user_id');
		$this->db->join('cse_assing_to_retailer','users.user_id = cse_assing_to_retailer.retailer_id');
		$this->db->where(array('users.user_type' => 'retailer','cse_assing_to_retailer.cse_id' => $this->session->userdata('userId')));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_product_sale_by_retailer($segment_id)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('product','orders_info.product_id = product.product_id');
		$this->db->join('product_image','product.product_id = product_image.product_id');
		$this->db->join('product_attribute','product.product_id = product_attribute.product_id');
		$this->db->join('retailer_product_detail','product.product_id = retailer_product_detail.product_id');
		$this->db->where(array(
						'product.segment_id'   					   => $segment_id,
						'product_image.status' 					   => 1,
						'product.block_status' 					   => 1
					));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_retailer_sale_product($segment_id)
	{
		$this->db->select('COUNT(orders_info.retailer_id) AS total');
		//$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('product','orders_info.product_id = product.product_id');
		$this->db->where(array(
						'product.segment_id'   => $segment_id,
						'product.block_status' => 1
					));
		$this->db->group_by('orders_info.retailer_id');
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_new_order_in_month()
	{
		$res = "SELECT COUNT(*) AS total,From_UnixTime(order_time,'%d-%m-%Y') AS order_date,From_UnixTime(order_time,'%b') AS order_month FROM orders INNER JOIN orders_info ON orders.order_id = orders_info.order_id WHERE orders.status = 1 GROUP BY order_month";
		return $result = $this->db->query($res)->result();
	}
	
	public function total_order_in_month_vendor($month_name)
	{
		$res = "SELECT COUNT(*) AS total,shipping_vendor_id,shipping_vendor_name,From_UnixTime(order_time,'%d-%m-%Y') AS order_date,From_UnixTime(order_time,'%b') AS order_month FROM orders INNER JOIN orders_info ON orders.order_id = orders_info.order_id WHERE From_UnixTime(order_time,'%b') = '".$month_name."'  GROUP BY shipping_vendor_id";
		return $result = $this->db->query($res)->result();
	}
	
	public function total_proceed_orders()
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('orders_info.retailer_id',$this->session->userdata('userId'));	
		}
		$this->db->where(array('orders.accept_decline' => 1,'orders.status != ' => 4));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function proceed_orders_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('orders_info.retailer_id',$this->session->userdata('userId'));	
		}
		$this->db->where(array('orders.accept_decline' => 1,'orders.status != ' => 4));
		$this->db->order_by('orders.last_modified_time','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function total_retailer_delivered_orders()
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where(array('orders.status' => 4,'orders_info.retailer_id' => $this->session->userdata('userId')));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_delivered_orders_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where(array('orders.status' => 4,'orders_info.retailer_id' => $this->session->userdata('userId')));
		$this->db->order_by('orders.last_modified_time','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function order_with_product_details($order_id)
	{
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->join('product','orders_info.product_id = product.product_id');
		$this->db->join('product_attribute','product.product_id = product_attribute.product_id');
		$this->db->join('segment','product.segment_id = segment.segment_id','left');
		$this->db->join('category','product.category_id = category.category_id','left');
		$this->db->join('brand','product_attribute.brand_id = brand.brand_id','left');
		$this->db->where('orders.order_id',$order_id);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function order_details($orderId)
	{
		$this->db->select("order_payment.*,order.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.orderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function economic_order_details($orderId)
	{
		$this->db->select("order_economical_delivery_details.*,order_free_shipping.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,order.*,product.code,product_image.imageName,organization.organizationName,employee.email,employee.businessPhoneCode,employee.businessPhone,dropship_center.dropCenterName,order_economical_delivery_details.finalShippingOrgId AS shippingOrgId,order_economical_delivery_details.finalShippingRateId AS shippingRateId");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_economical_delivery_details','order.customOrderId = order_economical_delivery_details.customOrderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');		
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where(array('order.customOrderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function update_order_info($order_id,$updateArr)
	{
		$updateOpt = array(
						'product_price'      	   => $updateArr['product_price'],
						'retailer_id'        	   => $updateArr['retailer_id'],
						'retailer_name' 	 	   => $updateArr['retailer_name'],
						'retailer_email'     	   => $updateArr['retailer_email'],
						'retailer_phone_no'  	   => $updateArr['retailer_phone_no'],
						'retailer_address'   	   => $updateArr['retailer_address'],
						'sub_total'          	   => $updateArr['sub_total'],
						'last_modified_by'         => $this->session->userdata('userId'),
						'last_modified_time'       => $this->currentTimestamp,
					 );	
		$this->db->where('order_id',$order_id);
		$this->db->update('orders_info',$updateOpt);
		return $this->db->affected_rows(); 
	}
	
	public function update_order($order_id,$updateArr)
	{
		$updateOpt = array(
						'total_amount'		 => $updateArr['total_amount'],
						'accept_decline'	 => 0,
						'last_modified_by'   => $this->session->userdata('userId'),
						'last_modified_time' => $this->currentTimestamp,
					 );	
		$this->db->where('order_id',$order_id);
		$this->db->update('orders',$updateOpt);
		return $this->db->affected_rows(); 
	}
	
	public function success_order_list($atATimeProduct)
	{
		$this->db->select('organization_product.*,order_free_shipping.*,order_payment.*,order.*,colors.colorCode,product.code,product_image.imageName,product_size.sizes AS size');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId	 = organization_product.organizationProductId	');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->where(array(
						'order.customerId' => $this->session->userdata('userId'),
						'order.orderStatusId' => 1,
						'order.atATimeProduct' => $atATimeProduct,
						'product_image.displayOrder' => 1,
						'order.active' => 1
						));
		$result = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $result->result();
	}
	
	public function last_order_id()
	{
		$this->db->order_by('customOrderId','desc');
		$result = $this->db->get('order')->row();
		$customOrderId = 1000000;
		if(!empty($result))
		{
			$customOrderId = $result->customOrderId+1;
		}
		if($customOrderId==1)
		{
			$customOrderId = 1000000;
		}
		return $customOrderId;
	}
	
	public function last_atATimeProduct_id()
	{
		$this->db->order_by('orderId','desc');
		$result = $this->db->get('order')->row();
		$atATimeProduct = 1;
		if(!empty($result))
		{
			$atATimeProduct = $result->atATimeProduct+2;
		}
		return $atATimeProduct;
	}
	
	public function shipping_rate_details($shippingOrgId,$shippingRateId)
	{
		$this->db->where(array('shippingRateId' => $shippingRateId,'shippingOrgId' => $shippingOrgId));
		$result = $this->db->get('shipping_rate');
		return $result->row();
	}
	
	public function track_order_time_details($orderId)
	{
		$this->db->where('orderId',$orderId);
		$this->db->order_by('createTime','ASC');
		$result = $this->db->get('order_track_details');
		return $result->result();
	}
	
	public function total_search_order($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('customer','order.customerId = customer.customerId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('shipping_rate','order.shippingRateId = shipping_rate.shippingRateId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		if($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		}
		$this->db->where('product_image.displayOrder',1);
		if($where)
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function search_order_list($start=0,$limit='',$where='')
	{
		$this->db->select("order.*,order_payment.*,organization_product.productId,organization_product.productCodeOveride,organization_product.currentPrice,organization.organizationName,employee.firstName,employee.lastName,customer.firstName AS cfirstName,customer.lastName AS clastName,product.code,product_image.imageName AS productImageName,shipping_rate.amount AS shippingAmount,colors.colorCode");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('customer','order.customerId = customer.customerId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('shipping_rate','order.shippingRateId = shipping_rate.shippingRateId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		if($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		}
		$this->db->where('product_image.displayOrder',1);
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $result->result();
	}
	
	public function search_order_details($orderId)
	{
		$this->db->select("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->where('order.orderId',$orderId);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function add_order_marketing($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           => $addArr['orderTypeId'],										
						'totalAmount'           => $addArr['totalAmount'],
						'quantity'              => $addArr['quantity'],
						'customerId'            => $addArr['customerId'],
						'marketingProductId'    => $addArr['marketingProductId'],
						'orderStatusId'         => $addArr['orderStatusId'],
						'shippingRateId'        => $addArr['shippingRateId'],
						'customOrderId'         => $addArr['customOrderId'],
						'orderEmail'       	    => $addArr['orderEmail'],
						'shippingOrgId'         => $addArr['shippingOrgId'],
						'colorId'       	    => $addArr['colorId'],
						'size'       		    => $addArr['size'],
						'newsletterId'			=> $addArr['newsletterId'],
						'atATimeProduct'	    => $addArr['atATimeProduct'],
						'createDt'		        => date('Y-m-d H:i:s'),
						'last_Modified_By'      => $this->session->userdata('userId'),
						'lastModifiedDt' 	    => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('marketing_order',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_payment_marketing($orderId,$addArr)
	{
		$insertOpt = array(
						'orderId'		  => $orderId,
						'paymentTypeId'   => 1,
						'amount'      	  => $addArr['totalAmount'],
						'paymentRef'      => $addArr['payment_reference'],
						'retrievalRef'    => $addArr['retrieval_reference'],
						'transactionRef'  => $addArr['transaction_reference'],
						'merchantRef'	  => $addArr['merchant_reference'],
						'transactionDate' => $addArr['transaction_date'],
						'createDt'		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'  => $this->session->userdata('userId'),
						'lastModifiedDt'  => date('Y-m-d H:i:s'),
					 );	
		$this->db->insert('marketing_order_payment',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_marketing_order_track_details($orderId,$orderStatusId)
	{
		$insertOpt = array(
						'orderId'          => $orderId,
						'orderStatusId'    => $orderStatusId,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'createTime'       => time(),
						'lastModifiedTime' => time(),
					);
		$this->db->insert('marketing_order_track_details',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function reduce_product_quantity($organizationProductId,$quantity)
	{
		$sql = "UPDATE `organization_product` SET `currentQty` = `currentQty` - $quantity WHERE `organizationProductId` = '$organizationProductId'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function reduce_product_color_quantity($organizationProductId,$colorId,$quantity)
	{
		$sql = "UPDATE `organization_color_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `organizationProductId` = '$organizationProductId' AND `colorId` = '$colorId' AND `active` = 1";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function reduce_product_size_quantity($organizationProductId,$sizeId,$quantity)
	{
		$sql = "UPDATE `organization_color_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `organizationProductId` = '$organizationProductId' AND `productSizeId` = '$sizeId' AND `active` = 1";
		$this->db->query($sql);
		return $this->db->affected_rows();	
	}
	
	public function increase_product_quantity($organizationProductId,$quantity)
	{
		$sql = "UPDATE `organization_product` SET `currentQty` = `currentQty` + $quantity WHERE `organizationProductId` = '$organizationProductId'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function increase_product_color_size_quantity($organizationProductId,$colorId,$sizeId,$quantity)
	{
		$sql = "UPDATE `organization_color_size_stock` SET `currentStock` = `currentStock` + $quantity WHERE `organizationProductId` = '$organizationProductId' AND `colorId` = '$colorId' AND `productSizeId` = '$sizeId' AND `active` = 1";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function increase_product_color_quantity($organizationProductId,$colorId,$quantity)
	{
		$sql = "UPDATE `organization_color_size_stock` SET `currentStock` = `currentStock` + $quantity WHERE `organizationProductId` = '$organizationProductId' AND `colorId` = '$colorId' AND `active` = 1";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function increase_product_size_quantity($organizationProductId,$sizeId,$quantity)
	{
		$sql = "UPDATE `organization_color_size_stock` SET `currentStock` = `currentStock` + $quantity WHERE `organizationProductId` = '$organizationProductId' AND `productSizeId` = '$sizeId' AND `active` = 1";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function reduce_product_quantity_from_marketing($organizationProductId,$quantity)
	{
		$sql = "UPDATE `marketing_product` SET `currentQty` = `currentQty` - $quantity WHERE `organizationProductId` = '$organizationProductId'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function marketing_product_id($organizationProductId)
	{
		$this->db->where('organizationProductId',$organizationProductId);
		$result = $this->db->get('marketing_product')->row();
		$marketingProductId = 0;
		if($result)
		{
			$marketingProductId = $result->marketingProductId;
		}
		return $marketingProductId;
	}
	
	public function reduce_product_color_quantity_from_marketing($marketingProductId,$colorId,$quantity)
	{
		$sql = "UPDATE `marketing_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `marketingProductId` = '$marketingProductId' AND `colorId` = '$colorId'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function reduce_product_size_quantity_from_marketing($marketingProductId,$sizeId,$quantity)
	{
		$sql = "UPDATE `marketing_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `marketingProductId` = '$marketingProductId' AND `size` = '$sizeId'";
		$this->db->query($sql);
		return $this->db->affected_rows();	
	}
	
	public function cancel_order($orderId)
	{
		$this->db->where(array('orderId' => $orderId));
		$this->db->update('order',array('active' => 0,'last_Modified_By' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();	
	}
	
	public function cancel_economic_order($orderId)
	{
		$this->db->where(array('customOrderId' => $orderId));
		$this->db->update('order',array('active' => 0,'last_Modified_By' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();	
	}
	
	public function marketing_product_details($marketingProductId)
	{
		$this->db->select('*');
		$this->db->from('marketing_product');
		$this->db->where('marketingProductId',$marketingProductId);
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function add_order_free_shipping($orderID,$addArr)
	{
		$insertOpt = array(
						'orderId'        => $orderID,										
						'freeShipCatId'  => $addArr['freeShipCatId'],
						'freeShipPrdId'  => $addArr['freeShipPrdId'],
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_free_shipping',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function check_order_product($productId)
	{		
		$this->db->select('order.*');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
        $this->db->join('product','organization_product.productId = product.productId');
        $this->db->where(array('product.productId' => $productId,'order.active' => 1));
		$this->db->order_by('order.orderId','DESC');				
		$result = $this->db->get()->row();
		return $result;    
	}
	
	public function total_customer_order($customerId,$where='')
	{	
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
        $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->where(array('order.active' => 1,'order.customerId' => $customerId));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function customer_order_list($customerId,$start=0,$limit='',$where='')
	{	
		$this->db->select('order_payment.*,order.*,organization.organizationName,product.code,dropship_center.dropCenterName');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
        $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->where(array('order.active' => 1,'order.customerId' => $customerId));
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function customer_order_details($orderId)
	{	
		$this->db->select("order_free_shipping.*,product_image.imageName,product.code,colors.colorCode,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,order.*");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->where(array('order.orderId' => $orderId,'order.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function total_orders($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		$this->db->join('customer','order.customerId = customer.customerId');
		$this->db->join('order_address','order.orderId = order_address.orderId');
		$this->db->join('address','order_address.addressId = address.addressId','left');
		$this->db->join('state','address.state = state.stateId','left');
        $this->db->join('area','address.area = area.areaId','left');
        $this->db->join('zip','address.city = zip.zipId','left');
		//$this->db->where(array('order.active' => 1,'order.orderStatusId !=' => 6));
		if($this->session->userdata('userType')=='retailer')
		{
			$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
		}
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->group_by('order.orderId');
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		//echo $this->db->last_query(); 
		//echo $total; exit;
		return $total;
	}
	
	public function orders_list($start=0,$limit='',$where='')
	{
		$sql = 'SELECT 	order.orderId,(order.retailerPrice*order.quantity) AS retailerPrice,order.totalAmount,order.chargedAmount,order.quantity,order.orderStatusId,order.customOrderId,order.isPickup,order.createDt,order_payment.paymentStatus,product.code,organization.organizationName,employee.businessPhoneCode,employee.businessPhone,dropship_center.dropCenterName,customer.phone,state.stateName,area.area AS areaName,zip.city AS cityName,customer.firstName,customer.lastName,order.active,order_free_shipping.freeShipCatId,order_free_shipping.freeShipPrdId,order_payment.genuineShippFee,shipping_rate.amount AS shippingRate,order_payment.cashHandlingPrice,order.isEconomicDelivery,order_economical_delivery_details.isCalculateShipp,order_economical_delivery_details.cashHandlingPrice AS economicCashHandFee,order_economical_delivery_details.totalProductWeight,order.isEconomicDelivery,group_concat(DISTINCT product.code SEPARATOR " / ") AS code,order_payment.productWeight
				FROM 
					`order` 
				INNER JOIN
					`order_payment`
				ON
					order.orderId = order_payment.orderId
				INNER JOIN
					`product`
				ON
					order.productId = product.productId
				INNER JOIN
					`organization_product`
				ON
					order.organizationProductId = organization_product.organizationProductId
				INNER JOIN
					`organization`
				ON
					organization_product.organizationId = organization.organizationId
				INNER JOIN
					`employee`
				ON
					organization.organizationId = employee.organizationId
				INNER JOIN
					`dropship_center`
				ON
					organization.dropshipCentre = dropship_center.dropCenterId
				INNER JOIN
					`order_dropship_center`
				ON
					order.orderId = order_dropship_center.orderId
				INNER JOIN
					`customer`
				ON
					order.customerId = customer.customerId
				LEFT JOIN
					`order_free_shipping`
				ON
					order.orderId = order_free_shipping.orderId
				LEFT JOIN
					`shipping_rate`
				ON
					order.shippingRateId = shipping_rate.shippingRateId
				INNER JOIN
					`order_address`
				ON
					order.orderId = order_address.orderId
				LEFT JOIN
					`address`
				ON
					order_address.addressId = address.addressId
				LEFT JOIN
					`state`
				ON
					address.state = state.stateId
				LEFT JOIN
					`area`
				ON
					address.area = area.areaId
				LEFT JOIN
					`zip`
				ON
					address.city = zip.zipId
				LEFT JOIN
					`order_economical_delivery_details`
				ON
					order.customOrderId = order_economical_delivery_details.customOrderId ';
			$whereSql = '';		
			if($this->session->userdata('userType')=='retailer')
			{
				$whereSql ='WHERE organization_product.organizationId = '.$this->session->userdata('organizationId');
			}
			
			if($where)
			{
				if($whereSql)
				{
					$whereSql.=' AND ('.$where.')';
				}
				else
				{
					$whereSql =' WHERE ('.$where.')';
				}
			}
			$sql.= $whereSql.' GROUP BY CASE WHEN order.isEconomicDelivery=1 THEN order.customOrderId ELSE order.orderId END ORDER BY order.createDt DESC ';
			if(!empty($limit))
			{
				$sql.= ' LIMIT '.$start.','.$limit;
			}
		$result = $this->db->query($sql);
		return $result->result();		
	}
	
	public function orders_details($orderId)
	{	
		$this->db->select("order_free_shipping.*,product_image.imageName,product.code,colors.colorCode,order_payment.*,order.*,order_dropship_center.toDropshipId,product_size.sizes AS size");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId','left');
		$this->db->where(array('order.orderId' => $orderId,)); //'order.active' => 1,'order.orderStatusId !=' => 6));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function custom_orders_details($orderId)
	{	
		$this->db->select("order_free_shipping.*,product_image.imageName,product.code,colors.colorCode,order_payment.*,order.*,shipping_rate.amount AS shippingRate,order_economical_delivery_details.isCalculateShipp,order_economical_delivery_details.totalProductWeight,order_economical_delivery_details.cashHandlingPrice AS economicHandling");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('shipping_rate','order.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('order_economical_delivery_details','order.customOrderId = order_economical_delivery_details.customOrderId','left');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId','left');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->where(array('order.customOrderId' => $orderId,));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function change_confirm_to_ready($orderId)
	{
		$updateOpt = array(
					 	'orderStatusId'    => 3,
						'last_Modified_By' => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderId' => $orderId,'active' => 1));
		$this->db->update('order',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_ready_to_shipped_in($orderId)
	{
		$updateOpt = array(
					 	'orderStatusId'    => 4,
						'last_Modified_By' => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderId' => $orderId,'active' => 1));
		$this->db->update('order',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_shipped_to_delivered($orderId)
	{
		$updateOpt = array(
					 	'orderStatusId'    => 5,
						'last_Modified_By' => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderId' => $orderId,'active' => 1));
		$this->db->update('order',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_to_pickup($orderId)
	{
		$updateOpt = array(
					 	'orderStatusId'    => 5,
						'last_Modified_By' => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
						'deliveredDate'    => date('Y-m-d H:i:s')
					);
		$this->db->where(array('orderId' => $orderId,'active' => 1));
		$this->db->update('order',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_economical_order_delivery($addArr)
	{
		$insertOpt = array(
					 	'organizationId'      => $addArr['organizationId'],
						'fromDropshipId'      => $addArr['fromDropshipId'],
						'totalProductWeight'  => $addArr['totalProductWeight'],
						'finalShippingOrgId'  => $addArr['shippingOrgId'],
						'finalShippingRateId' => $addArr['shippingRateId'],
						'active' 		      => 1,
						'customOrderId' 	  => $addArr['customOrderId'],
						'cashHandlingPrice'   => $addArr['cashHandlingPrice'],
						'isCalculateShipp'    => $addArr['isCalculateShipp'],
						'createdBy'     	  => $this->session->userdata('userId'),		
						'createDt'		      => date('Y-m-d H:i:s'),
						'lastModifiedDt'      => date('Y-m-d H:i:s'),
						'lastModifiedBy'      => $this->session->userdata('userId'),					
					 );
		$this->db->insert('order_economical_delivery_details',$insertOpt);
		return $this->db->insert_id();			
	}
	
	public function unactive_economical_repeate_order_delivery($checkArr)
	{
		$updateOpt = array(
						'active' 		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('organizationId' => $checkArr['organizationId'],'active' => 1,'createdBy' => $this->session->userdata('userId'),'customOrderId' => $checkArr['customOrderId']));
		$this->db->update('order_economical_delivery_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function economic_delivery_details($customerId,$customOrderId,$organizationId=0)
	{
		if((!empty($organizationId))&&($organizationId))
		{
			$this->db->where('organizationId',$organizationId);
		}
		
		$this->db->where(array(
							'active'		 => 1,
							'createdBy' 	 => $customerId,
							'customOrderId'  => $customOrderId,
						));
		$result = $this->db->get('order_economical_delivery_details')->row();
		return $result;
	}
	
	public function economic_orders_details($orderId)
	{	
		$this->db->select("order_free_shipping.*,product_image.imageName,product.code,colors.colorCode,order_payment.*,order.*,order_economical_delivery_details.organizationId,order_economical_delivery_details.totalProductWeight,order_economical_delivery_details.finalShippingOrgId,order_economical_delivery_details.finalShippingRateId,order_economical_delivery_details.isCalculateShipp,order_economical_delivery_details.cashHandlingPrice,order_dropship_center.toDropshipId,product_size.sizes AS size");
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('order_economical_delivery_details','order.customOrderId = order_economical_delivery_details.customOrderId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->join('order_free_shipping','order.orderId = order_free_shipping.orderId','left');
		$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId','left');
		$this->db->where(array('order.customOrderId' => $orderId,'order_economical_delivery_details.active' => 1,));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function add_order_pointe_force_commission($orderId,$addArr)
	{
		$insertOpt = array(
						'orderId'         	   => $orderId,										
						'verifiedStatus'  	   => $addArr['pointeForceVerifiedStatus'],
						'customerId'      	   => $addArr['customerId'],
						'commissionPrice' 	   => $addArr['spacepointeCommission2'],
						'totalCommissionPrice' => $addArr['totalCommissionPrice'],						
						'createdBy'		 	   => $this->session->userdata('userId'),
						'createDt'		  	   => date('Y-m-d H:i:s'),
						'lastModifiedBy'  	   => $this->session->userdata('userId'),
						'lastModifiedDt'  	   => date('Y-m-d H:i:s'),	
					 );
		$this->db->insert('order_pointe_force_commission',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function download_excel_orders_list($start=0,$limit='',$where='')
	{
		$sql = 'SELECT 	order.orderId,order.totalAmount,order.chargedAmount,order.quantity,order.orderStatusId,order.customOrderId,order.isPickup,order.createDt,order_payment.paymentStatus,product.code,organization.organizationName,employee.businessPhoneCode,employee.businessPhone,dropship_center.dropCenterName,customer.phone,state.stateName,area.area AS areaName,zip.city AS cityName,customer.firstName,customer.lastName,order.active,order_free_shipping.freeShipCatId,order_free_shipping.freeShipPrdId,order_payment.genuineShippFee,shipping_rate.amount AS shippingRate,order_payment.cashHandlingPrice,order.isEconomicDelivery,order_economical_delivery_details.isCalculateShipp,order_economical_delivery_details.cashHandlingPrice AS economicCashHandFee,order_economical_delivery_details.totalProductWeight,order.isEconomicDelivery,order_payment.productWeight,order_payment.pickupProccessPrice
				FROM 
					`order` 
				INNER JOIN
					`order_payment`
				ON
					order.orderId = order_payment.orderId
				INNER JOIN
					`product`
				ON
					order.productId = product.productId
				INNER JOIN
					`organization_product`
				ON
					order.organizationProductId = organization_product.organizationProductId
				INNER JOIN
					`organization`
				ON
					organization_product.organizationId = organization.organizationId
				INNER JOIN
					`employee`
				ON
					organization.organizationId = employee.organizationId
				INNER JOIN
					`dropship_center`
				ON
					organization.dropshipCentre = dropship_center.dropCenterId
				INNER JOIN
					`order_dropship_center`
				ON
					order.orderId = order_dropship_center.orderId
				INNER JOIN
					`customer`
				ON
					order.customerId = customer.customerId
				LEFT JOIN
					`order_free_shipping`
				ON
					order.orderId = order_free_shipping.orderId
				LEFT JOIN
					`shipping_rate`
				ON
					order.shippingRateId = shipping_rate.shippingRateId
				INNER JOIN
					`order_address`
				ON
					order.orderId = order_address.orderId
				LEFT JOIN
					`address`
				ON
					order_address.addressId = address.addressId
				LEFT JOIN
					`state`
				ON
					address.state = state.stateId
				LEFT JOIN
					`area`
				ON
					address.area = area.areaId
				LEFT JOIN
					`zip`
				ON
					address.city = zip.zipId
				LEFT JOIN
					`order_economical_delivery_details`
				ON
					order.customOrderId = order_economical_delivery_details.customOrderId ';
		$result = $this->db->query($sql);
		return $result->result();		
	}
	
	public function economic_shipping_rate($customOrderId)
	{
		$this->db->select("order_economical_delivery_details.*,shipping_rate.amount,shipping_rate.ETA");
		$this->db->from('order_economical_delivery_details');
		$this->db->join('shipping_rate','order_economical_delivery_details.finalShippingRateId = shipping_rate.shippingRateId');
		$this->db->where(array('order_economical_delivery_details.customOrderId' => $customOrderId,));
		$result = $this->db->get();
		return $result->row();
	
	}
	
	public function reduce_orgnization_product_color_size_quantity($organizationColorSizeId,$quantity)
	{		
		$sql = "UPDATE `organization_color_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `organizationColorSizeId` = '$organizationColorSizeId' ";
		$this->db->query($sql);
		return $this->db->affected_rows();	
	}
	
	public function pointe_force_order_list($customerId)
	{
		$this->db->select('product_image.imageName,product.code,order.productId,order.quantity,order.quantity,order.createDt,order.orderStatusId,order.customOrderId,colors.colorCode,product_size.sizes,order_pointe_force_commission.totalCommissionPrice');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_pointe_force_commission','order.orderId = order_pointe_force_commission.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->where(array(
							'order.customerId' 						   	   => $customerId,
							'order_pointe_force_commission.customerId' 	   => $customerId,
							'order_pointe_force_commission.verifiedStatus' => 1,
							'order_pointe_force_commission.active'		   => 1,
							'order.active' 							   	   => 1,
							'order.orderStatusId != '					   => 6,
						));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function pointe_force_order_list_history($customerId)
	{
		$this->db->select('product_image.imageName,product.code,order.productId,order.quantity,order.quantity,order.createDt,order.orderStatusId,order.customOrderId,colors.colorCode,product_size.sizes,order_pointe_force_commission.totalCommissionPrice');
		$this->db->from('order');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('order_pointe_force_commission','order.orderId = order_pointe_force_commission.orderId');
		$this->db->join('product','order.productId = product.productId');
		$this->db->join('product_image','order_payment.productImageId = product_image.productImageId');
		$this->db->join('colors','order.colorId = colors.colorId','left');
		$this->db->join('product_size','order.size = product_size.productSizeId','left');
		$this->db->where(array(
							'order.customerId' 						   	   => $customerId,
							'order_pointe_force_commission.customerId' 	   => $customerId,
							'order_pointe_force_commission.verifiedStatus' => 1,
							'order_pointe_force_commission.active'		   => 1,
							'order_pointe_force_commission.paidStatus'	   => 1,
							'order.active' 							   	   => 1,
							'order.orderStatusId != '					   => 6,
						));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function add_shipping_vendor_commission($orderId,$addArr)
	{
		$insertOpt = array(
						'orderId'        => $orderId,										
						'shippingOrgId'  => $addArr['shippingOrgId'],
						'shippingRateId' => $addArr['shippingRateId'],
						'shippingAmount' => $addArr['shippingAmount'],
						'paidStatus'	 => 0,
						'active' 		 => 1,
						'createdBy'		 => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_shipping_vendor_commission',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_unactive_shipping_vendor_commission($orderId,$addArr)
	{
		$insertOpt = array(
						'orderId'        => $orderId,										
						'shippingOrgId'  => $addArr['shippingOrgId'],
						'shippingRateId' => $addArr['shippingRateId'],
						'shippingAmount' => $addArr['shippingAmount'],
						'paidStatus'	 => 0,
						'active' 		 => 0,
						'createdBy'		 => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_shipping_vendor_commission',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function order_custom_payment_details($customOrderId)
	{
		$this->db->select('order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.orderDetailId,order_details.organizationProductId,order_details.colorId,order_details.productSizeId,order_details.quantity');
		$this->db->from('order_custom_payment');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->where(array(
						'order_custom_payment.customOrderId' => $customOrderId,
						'order_custom_payment.active' => 1,
						'order_details.active' => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function order_custom_payment_detail($orderCustomPaymentId)
	{
		$this->db->select('order_custom_payment.orderTotalId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_pickup.pickupProcessingAmount,order_pickup.pickupId');
		$this->db->from('order_custom_payment');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId','left');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
						'order_custom_payment.orderCustomPaymentId' => $orderCustomPaymentId,
						'order_custom_payment.active' 		=> 1,
						'order_details.active' 				=> 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function order_organization_custom_payment_details($customOrderId,$organizationProductId)
	{
		$this->db->select('order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.orderDetailId,order_details.quantity,order_details.colorId,order_details.productSizeId,order_details.organizationProductId');
		$this->db->from('order_custom_payment');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->where(array(
							'order_custom_payment.active' 		  => 1,
							'order_details.active' 		  		  => 1,
							'order_custom_payment.customOrderId'  => $customOrderId,
							'order_details.organizationProductId' => $organizationProductId
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function add_order_custom_track($orderDetailId,$orderStatusId)
	{
		$insertOpt = array(
						'orderDetailId'  => $orderDetailId,
						'orderStatusId'  => $orderStatusId,
						'active'		 => 1,
						'createBy'   	 => $this->session->userdata('userId'),
						'createDt'       => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->insert('order_track',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function custom_change_shipped_to_delivered($orderDetailId)
	{
		$updateOpt = array(
					 	'orderStatusId'  => 5,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function custom_change_ready_to_shipped_in($orderDetailId)
	{
		$updateOpt = array(
					 	'orderStatusId'  => 4,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();		
	}
	
	public function custom_change_confirm_to_ready($orderDetailId)
	{
		$updateOpt = array(
					 	'orderStatusId'  => 3,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function custom_change_new_to_confirm($orderDetailId)
	{
		$updateOpt = array(
					 	'orderStatusId'  => 2,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function custom_order_declined($orderDetailId)
	{
		$updateOpt = array(
					 	'orderStatusId'  => 6,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function cancel_single_shippment_order($orderCustomPaymentId)
	{
		$updateOpt = array(
					 	'active'  		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderCustomPaymentId' => $orderCustomPaymentId,'active' => 1));
		$this->db->update('order_custom_payment',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function cancel_order_details($orderDetailId)
	{
		$updateOpt = array(
					 	'active'  		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function declined_order_details($orderDetailId)
	{
		$updateOpt = array(
					 	'orderStatusId'  => 6,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function single_shippment_save_tracking_number($orderCustomPaymentId,$trackingNbr)
	{
		$updateOpt = array(
					 	'trackingNbr'  	 => $trackingNbr,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderCustomPaymentId' => $orderCustomPaymentId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function quick_shippment_save_tracking_number($orderDetailId,$trackingNbr)
	{
		$updateOpt = array(
					 	'trackingNbr'  	 => $trackingNbr,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();
	}	
	
	public function custom_save_delivered_date($orderDetailId,$delivered_date)
	{
		$updateOpt = array(
					 	'deliveredDate'  => $delivered_date,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where(array('orderDetailId' => $orderDetailId,'active' => 1));
		$this->db->update('order_details',$updateOpt);
		return $this->db->affected_rows();		
	}
	
	public function total_custom_order_search($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('dropship_center','order_custom_payment.dropShipCenterId = dropship_center.dropCenterId');		
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('customer','order_total.customerId = customer.customerId');
		$this->db->join('order_address_detail','order_total.orderTotalId = order_address_detail.orderTotalId AND order_address_detail.addressTypeId = 3','left');
		$this->db->join('address','order_address_detail.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->where(array(
							'order_total.active' 		  => 1,
							'order_custom_payment.active' => 1
						));
		$this->db->group_by('order_custom_payment.orderCustomPaymentId');
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function custom_order_search_list($start=0,$limit='',$where='')
	{
		$this->db->select('order_custom_payment.totalCustomAmount,order_custom_payment.createDt,order_custom_payment.customOrderId,order_total.isEconomicDelivery,order_total.paymentStatus,organization.organizationName,employee.businessPhone,order_details.orderStatusId,dropship_center.dropCenterName,GROUP_CONCAT(product.code) AS productName,customer.firstName,customer.lastName,customer.phone,order_total.isPickup,order_details.active,order_custom_payment.orderCustomPaymentId,state.stateName,area.area AS areaName,zip.city AS cityName');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('dropship_center','order_custom_payment.dropShipCenterId = dropship_center.dropCenterId');		
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('customer','order_total.customerId = customer.customerId');
		$this->db->join('order_address_detail','order_total.orderTotalId = order_address_detail.orderTotalId AND order_address_detail.addressTypeId = 3','left');
		$this->db->join('address','order_address_detail.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->where(array(
							'order_total.active' 		  => 1,
							'order_custom_payment.active' => 1
						));
		$this->db->group_by('order_custom_payment.orderCustomPaymentId');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function custom_order_detail_list($orderCustomPaymentId)
	{
		$this->db->select('order_total.orderTotalId,order_total.paymentStatus,order_total.isPickup,order_total.isPointeForce, order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomAmount,order_custom_payment.totalCustomShippingAmount,order_custom_payment.totalCustomCashHandlingAmount,order_custom_payment.totalCustomPickupProccessAmount,order_details.orderDetailId,order_details.totalProductAmount,order_details.productId,order_details.quantity,order_details.orderStatusId,colors.colorCode,product.code,organization.organizationName,product_size.sizes,product_image.imageName,order_pickup.pickupProcessingAmount,order_pickup.pickupId,order_details.orderDetailId,order_details.active,order_details.orderStatusId,order_shipping_vendor.shippingAmount,order_details.trackingNbr,order_custom_payment.dropShipCenterId,order_details.totalRetailAmount,order_details.organizationProductId,order_total.customerId,order_shipping_vendor.shippingOrgId,order_total.isEconomicDelivery');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('order_pickup','order_details.orderDetailId = order_pickup.orderDetailId','left');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId','left');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active' 		  => 1,
							'order_custom_payment.active' => 1,
							'order_custom_payment.orderCustomPaymentId' => $orderCustomPaymentId
						));
		$result = $this->db->get()->result();
		return $result;
	}
}
