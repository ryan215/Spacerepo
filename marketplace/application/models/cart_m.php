<?php

class Cart_m extends MY_Model{	

	public function __construct()
	{
		parent::__construct();		
	}	
	
	public function add_to_cart($addArr)
	{
		$insertOpt = array(
						'organizationProductId' => $addArr['organizationProductId'],
						'marketingProductId'	=> $addArr['marketingProductId'],
						'quantity' 		        => $addArr['quantity'],
						'colorId'               => $addArr['colorId'],
						'size'			        => $addArr['sizeId'],
						'organizationColorSizeId' => $addArr['organizationColorSizeId'],
						'active'				=> 1,
						'productAmt'			=> $addArr['productAmt'],
						'retailerPrice'			=> $addArr['retailerPrice'],
						'spacePointePrice'		=> $addArr['spacePointeCommissionPrice'],
						'cashAdminPrice'		=> $addArr['adminPrice'],
						'categoryCommission'	=> $addArr['categoryCommission'],
						'cashAdminFee'			=> $addArr['cashAdminFee'],
						'genuineShippFee'		=> $addArr['genuineShippFee'],
						'toDropshipId'			=> $addArr['toDropshipId'],
						'pickupProccessPrice'	=> $addArr['pickupProccessPrice'],
						'productWeight'         => $addArr['productWeight'],
						'retailerDiscount'      => $addArr['retailerDiscount'],
						'isMobileDevice'		=> 0,
						'createDt'		        => date('Y-m-d H:i:s'),
						'lastModifiedBy'		=> $this->session->userdata('userId'),
						'lastModifiedDt'		=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_to_buy_now($addArr)
	{
		$insertOpt = array(	
						'organizationProductId'   => $addArr['organizationProductId'],
						'marketingProductId'	  => $addArr['marketingProductId'],
						'quantity' 		          => $addArr['quantity'],
						'colorId'                 => $addArr['colorId'],
						'size'			          => $addArr['sizeId'],
						'organizationColorSizeId' => $addArr['organizationColorSizeId'],
						'active'				  => 1,
						'productAmt'			  => $addArr['productAmt'],
						'retailerPrice'			  => $addArr['retailerPrice'],
						'spacePointePrice'		  => $addArr['spacePointeCommissionPrice'],
						'cashAdminPrice'		  => $addArr['adminPrice'],
						'categoryCommission'	  => $addArr['categoryCommission'],
						'cashAdminFee'			  => $addArr['cashAdminFee'],
						'genuineShippFee'		  => $addArr['genuineShippFee'],
						'toDropshipId'			  => $addArr['toDropshipId'],
						'pickupProccessPrice'	  => $addArr['pickupProccessPrice'],
						'productWeight'         => $addArr['productWeight'],
						'retailerDiscount'      => $addArr['retailerDiscount'],
						'inventoryHistoryId'    => $addArr['inventoryHistoryId'],						
						'purchaseFrom'			=> 2,
						'isMobileDevice'		=> 0,
						'createDt'		        => date('Y-m-d H:i:s'),
						'lastModifiedBy'		=> $this->session->userdata('userId'),
						'lastModifiedDt'		=> date('Y-m-d H:i:s'),						
					);
		$this->db->insert('cart',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_to_cart_for_pickup($addArr)
	{
		$insertOpt = array(
						'organizationProductId' => $addArr['organizationProductId'],
						'marketingProductId'	=> $addArr['marketingProductId'],
						'quantity' 		        => $addArr['quantity'],
						'pickupId'              => $addArr['pickupId'],
						'colorId'               => $addArr['colorId'],
						'size'			        => $addArr['sizeId'],
						'isPickup'			    => 1,
						'active'				=> 1,
						'productAmt'			=> $addArr['productAmt'],
						'retailerPrice'			=> $addArr['retailerPrice'],
						'spacePointePrice'		=> $addArr['spacePointeCommissionPrice'],
						'cashAdminPrice'		=> $addArr['adminPrice'],
						'categoryCommission'	=> $addArr['categoryCommission'],
						'cashAdminFee'			=> $addArr['cashAdminFee'],
						'genuineShippFee'		=> $addArr['genuineShippFee'],
						'toDropshipId'			=> $addArr['toDropshipId'],
						'pickupProccessPrice'	=> $addArr['pickupProccessPrice'],
						'productWeight'         => $addArr['productWeight'],
						'retailerDiscount'      => $addArr['retailerDiscount'],
						'isMobileDevice'		=> 0,
						'createDt'		        => date('Y-m-d H:i:s'),
						'lastModifiedBy'		=> $this->session->userdata('userId'),
						'lastModifiedDt'		=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_to_buy_now_for_pickup($addArr)
	{
		$insertOpt = array(
						'organizationProductId' => $addArr['organizationProductId'],
						'quantity' 		        => $addArr['quantity'],
						'pickupId'              => $addArr['pickupId'],
						'colorId'               => $addArr['colorId'],
						'size'			        => $addArr['sizeId'],
						'isPickup'			    => 1,
						'isMobileDevice'		=> 0,
						'createDt'		        => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_rowId_to_cart($cartId,$rowId)
	{
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',array('userIdentifier' => $rowId,'lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function cart_details($organizationProductId)
	{
		$this->db->where(array('organizationProductId' => $organizationProductId,'active' => 1));
		$result = $this->db->get('cart')->row();
		return $result;
	}
	
	public function cart_row_list($where='')
	{
		$this->db->where($where);
		$this->db->where('active',1);
		$result = $this->db->get('cart');
		return $result->row();
	}
	
	public function update_to_cart($cartId,$quantity=0)
	{
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',array('quantity' => $quantity));
		return $this->db->affected_rows();
	}
	
	public function cart_list($where)
	{
		$this->db->select('cart_delivery_details.*,address.state as dropshipStateId ,cart.*,organization_product.*,organization.organizationName,product.code,product_image.imageName,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,shipping_rate.amount AS shippingRate,employee.email,employee.businessPhone,employee.businessPhoneCode,shipping_rate.ETA,cart_commission.spacePointePrice2,product.productTypeId,product_size.sizes AS size,colors.colorCode');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('cart_commission','cart.cartId = cart_commission.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('dropship_center_address','dropship_center_address.dropCenterId=dropship_center.dropCenterId and dropship_center.active=1','left');
		$this->db->join('address','address.addressId=dropship_center_address.addressId','left');		
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->join('shipping_rate','cart_delivery_details.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('colors','cart.colorId = colors.colorId','left');
		$this->db->join('product_size','cart.size = product_size.productSizeId','left');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where($where);
		$this->db->where(array(
								'product_image.displayOrder' => 1,
								'cart.active' => 1,
								'employee.active' => 1, 
								'product.active' => 1,
								'organization_product.currentQty >' => 2
							));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function cart_list_for_pickup($where)
	{
		$this->db->select('cart_delivery_details.*,cart.*,organization_product.*,organization.organizationName,product.code,product_image.imageName,pickup.pickupName,address.*,state.stateName,zip.city AS cityName,area.area AS areaName,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,cart_commission.spacePointePrice2');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('cart_commission','cart.cartId = cart_commission.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->join('pickup','cart.pickupId = pickup.pickupId');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');
		$this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area=area.areaId', 'left');
        $this->db->join('zip', 'zip.zipId=address.city', 'left');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where($where);
		$this->db->where(array(
							'cart.isPickup' => 1,
							'product_image.displayOrder' => 1,
							'cart.active' => 1,
							'employee.active' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2
						));
		$this->db->order_by('cart.cartId','DESC');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function cart_page_detail_list($where)
	{
		$this->db->select('cart_delivery_details.*,cart.*,organization_product.*,organization.organizationName,colors.colorCode,product_image.imageName,product.code,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,product_size.sizes AS size');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('colors','cart.colorId = colors.colorId','left');
		$this->db->join('product_size','cart.size = product_size.productSizeId','left');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where(array(
							'product_image.displayOrder' => 1,
							'cart.active' => 1,
							'employee.active' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2
						));
		$this->db->where($where);
		$result = $this->db->get();
		return $result->result();
	}
	
	public function cart_page_detail_list_for_pickup($where)
	{
		$this->db->select('address.*,cart_delivery_details.*,cart.*,organization_product.*,organization.organizationName,shipping_rate.amount AS shippingRate,colors.colorCode,pickup.pickupName,product_image.imageName,product.code,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,product_size.sizes AS size');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');		
		$this->db->join('pickup','cart.pickupId = pickup.pickupId');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');		
		$this->db->join('shipping_rate','cart_delivery_details.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('colors','cart.colorId = colors.colorId','left');
		$this->db->join('product_size','cart.size = product_size.productSizeId','left');		
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where($where);
		$this->db->where(array(
								'cart.isPickup' => 1,
								'product_image.displayOrder' => 1,
								'cart.active' => 1,
								'employee.active' => 1, 
								'product.active' => 1,
								'organization_product.currentQty >' => 2
							));
		$this->db->order_by('cart.cartId','DESC');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function cart_page_details_row($cartId)
	{
		$this->db->select('cart_delivery_details.*,cart.*,organization_product.*,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where(array(
							'cart.cartId' => $cartId,
							'cart.active' => 1,
							'employee.active' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2
						));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function cart_page_details_row_for_pickup($cartId)
	{
		$this->db->select('cart.*,organization_product.*,shipping_rate.amount AS shippingRate,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,cart_delivery_details.freeShipCatId,cart_delivery_details.freeShipPrdId');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('pickup','cart.pickupId = pickup.pickupId');
		$this->db->join('shipping_rate','cart.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where(array('cart.cartId' => $cartId,'cart.isPickup' => 1,'cart.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	
	
	public function cart_details_row($cartId)
	{
		$this->db->select('*');
		$this->db->from('cart');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
		
	public function product_weight_with_cart_list($cityId)
	{
		$this->session->unset_userdata('shippingOrgId');
		$this->session->unset_userdata('shippingRates');
		$this->session->unset_userdata('shippingRateId');
		
		$contents = $this->cart->contents();		
		$flag = 1;
		$productWeight = 0;
		if(!empty($contents))
		{
			$whereArr = array();
			foreach($contents as $items)
			{
				$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
			}
			if(!empty($whereArr))
			{
				$where = '('.implode(' OR ',$whereArr).')';
				
				$this->db->select('*');
				$this->db->from('cart');
				$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
				$this->db->join('product','organization_product.productId = product.productId');
				$this->db->where($where);
				$this->db->where('cart.active',1);
				$result = $this->db->get();
				$productDet = $result->result();
				
				if(!empty($productDet))	
				{
					foreach($productDet as $row)
					{
						$productWeight = $row->weight+$row->shippingWeight;
						/**********/
						$this->db->select('*');
						$this->db->from('shipping_rate');
						$this->db->where(
										array(
											'toZip' 	    => $cityId,
											'fromWeight <=' => $productWeight,
											'toWeight >='   => $productWeight,
											'active'        => 1,
										)
									);		
						$this->db->order_by('shipping_rate.amount','asc');
						$shipRateDet = $this->db->get()->row();		
						//print_r($shipRateDet); exit;
						if(!empty($shipRateDet))
						{
							$this->session->set_userdata('shippingOrgId',$shipRateDet->shippingOrgId);
							$this->session->set_userdata('shippingRates',$shipRateDet->amount);
							$this->session->set_userdata('shippingRateId',$shipRateDet->shippingRateId);
						}
						else
						{
							$flag = 0;
							return $flag;
						}
						
						/*********/
					}
				}
				else
				{
					$flag = 0;
					return $flag;
				}										
			}
		}			
		return $flag;
	}
	
	public function pickup_details($pickupId)
	{
		$this->db->select('pickup.*,address.*,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('pickup');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');
		$this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area=area.areaId', 'left');
        $this->db->join('zip', 'zip.zipId=address.city', 'left');
		$this->db->where(array('pickup.pickupId' => $pickupId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function dropshipAdress($addressLine1)
	{
		$this->db->select('*');
		$this->db->from('dropship_center');
		$this->db->join('dropship_center_address','dropship_center.dropCenterId = dropship_center_address.dropCenterId');
		$this->db->join('address','dropship_center_address.addressId = address.addressId');
		$this->db->where(array('address.addressLine1' => $addressLine1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function buy_now_cart_page_detail($cartId)
	{
		$this->db->select('cart_delivery_details.*,address.state as dropshipStateId ,cart.*,organization_product.*,organization.organizationName,colors.colorCode,product_image.imageName,product.code,shipping_rate.ETA,shipping_rate.amount AS shippingRate,cart_commission.spacePointePrice2,product_size.sizes AS size');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('cart_commission','cart.cartId = cart_commission.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('dropship_center_address','dropship_center_address.dropCenterId=dropship_center.dropCenterId and dropship_center.active=1','left');
		$this->db->join('address','address.addressId=dropship_center_address.addressId','left');
		
		$this->db->join('shipping_rate','cart_delivery_details.shippingRateId = shipping_rate.shippingRateId','left');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('colors','cart.colorId = colors.colorId','left');
		$this->db->join('product_size','cart.size = product_size.productSizeId','left');
		$this->db->where(array(
							'product_image.displayOrder' 		=> 1,
							'cart.cartId' 						=> $cartId,
							'cart.active' 						=> 1,
							'cart.purchaseFrom' 				=> 2,
							'employee.active' 					=> 1, 
							'product.active' 				    => 1,
							'organization_product.currentQty >' => 2
						));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function buy_now_delivery_detail($cartId)
	{
		$this->db->select('cart_delivery_details.*,cart.*,organization_product.*,organization.organizationName,colors.colorCode,product_image.imageName,product.code,product.productTypeId,shipping_rate.ETA,shipping_rate.amount AS shippingRate,cart_commission.spacePointePrice2');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('cart_commission','cart.cartId = cart_commission.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('shipping_rate','cart_delivery_details.shippingRateId = shipping_rate.shippingRateId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('colors','cart.colorId = colors.colorId','left');
		$this->db->where(array(
						'product_image.displayOrder' => 1,
						'cart.cartId' => $cartId,
						'cart.active' => 1,
						'cart.purchaseFrom' => 2,
						'employee.active' => 1, 
						'product.active' => 1,
						'organization_product.currentQty >' => 2
					));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function buy_now_cart_page_detail_pickup($cartId)
	{
		$this->db->select('address.*,cart_delivery_details.*,cart.*,organization_product.*,organization.organizationName,colors.colorCode,pickup.pickupName,product_image.imageName,product.code,marketing_product.currentPrice AS adminPrice,state.stateName,zip.city AS cityName,area.area AS areaName,cart_commission.spacePointePrice2,product.productTypeId,product_size.sizes AS size');
		$this->db->from('cart');
		$this->db->join('cart_delivery_details','cart.cartId = cart_delivery_details.cartId');
		$this->db->join('cart_commission','cart.cartId = cart_commission.cartId');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('pickup','cart.pickupId = pickup.pickupId');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');
		$this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area=area.areaId', 'left');
        $this->db->join('zip', 'zip.zipId=address.city', 'left');		
		$this->db->join('colors','cart.colorId = colors.colorId','left');
		$this->db->join('product_size','cart.size = product_size.productSizeId','left');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0','left');
		$this->db->where(array(
							'cart.isPickup' => 1,
							'product_image.displayOrder' => 1,
							'cart.active' => 1,
							'cart.cartId' => $cartId,
							'cart.purchaseFrom' => 2,
							'employee.active' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2
						));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function remove_from_cart($cartId)
	{
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',array('active' => 0,'lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function remove_to_cart($where)
	{
		$this->db->where($where);
		$this->db->where('active',1);
		$this->db->update('cart',array('active' => 0,'lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
		
	public function pickupDetails($pickupId)
	{
		$this->db->select('address.*,pickup.pickupName');
		$this->db->from('pickup');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');		
		$this->db->where('pickup.pickupId',$pickupId);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function dropshipDetails($dropshipCenterId)
	{
		$this->db->select('*');
		$this->db->from('dropship_center');
		$this->db->join('dropship_center_address','dropship_center.dropCenterId = dropship_center_address.dropCenterId');
		$this->db->join('address','dropship_center_address.addressId = address.addressId');
		$this->db->where(array('dropship_center.dropCenterId' => $dropshipCenterId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function update_pickup_processing_price($cartId,$pickupProccessPrice)
	{
		$this->db->where('cartId',$cartId);
		$this->db->update('cart',array('pickupProccessPrice' => $pickupProccessPrice,'lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function update_cart_userId($cartId)
	{
		$this->db->where('cartId',$cartId);
		$this->db->update('cart',array('lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function get_user_cart($userId)
	{		
		$this->db->select('cart.*,product.code,product_image.imageName');
		$this->db->from('cart');
		$this->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');		
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->where(array(
						'product_image.displayOrder' 		=> 1,
						'cart.active' 						=> 1,
						'cart.lastModifiedBy' 		 		=> $userId,
						'employee.active' 			 		=> 1, 
						'product.active' 			 		=> 1,
						'organization_product.currentQty >' => 2,
						//"From_UnixTime(cart.createDt,'%Y-%m-%d') >= " => date("Y-m-d",strtotime('-1 days')),
						//"From_UnixTime(cart.createDt,'%Y-%m-%d') <= " => date("Y-m-d"),
						'cart.purchaseFrom' 		 		=> 2,
					));
		$this->db->order_by('cart.lastModifiedDt','DESC');
		//$this->db->limit(1);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function add_buy_now_to_cart($cartId,$rowId,$updateArr)
	{
		$updateOpt = array(
						'userIdentifier' => $rowId,
						'purchaseFrom'   => 1,
						'purchaseFrom'   => 1,
						'pickupId'		 => $updateArr['pickupId'],
						'isPickup'		 => $this->session->userdata('isPickUp'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					);
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_buy_now_to_cart_shipping_rate($cartId,$rowId,$updateArr)
	{
		$updateOpt = array(
						'userIdentifier' => $rowId,
						'purchaseFrom'   => 1,
						'shippingRateId' => $this->session->userdata('shippingRateId'),
						'shippingOrgId'	 => $this->session->userdata('shippingOrgId'),
						'pickupId'		 => $updateArr['pickupId'],
						'isPickup'		 => $this->session->userdata('isPickUp'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					);
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_from_buy_now_to_cart($where,$updateArr)
	{
		if(!empty($where))
		{
			$updateOpt = array(
							'purchaseFrom'   => 1,
							'shippingRateId' => $updateArr['shippingRateId'],
							'shippingOrgId'	 => $updateArr['shippingOrgId'],
							'pickupId'		 => $updateArr['pickupId'],
							'isPickup'		 => $this->session->userdata('isPickUp'),
							'lastModifiedBy' => $this->session->userdata('userId'),
							'lastModifiedDt' => date('Y-m-d H:i:s')
						 );
			$this->db->where($where);
			$this->db->update('cart',$updateOpt);
			return $this->db->affected_rows();
		}
	}
	
	public function change_from_buy_now_session($cartId,$rowId)
	{
		$updateOpt = array(
						'userIdentifier' => $rowId,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_buy_now_to_cart($cartId)
	{
		$updateOpt = array(
						'purchaseFrom'   => 1,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_to_delivery($cartId,$addArr)
	{
		$insertOpt = array(
						'cartId'         => $cartId,
						'organizationId' => $addArr['organizationId'],
						'productImageId' => $addArr['productImageId'],
						'productWeight'  => $addArr['productWeight'],
						'shippingOrgId'  => $addArr['shippingOrgId'],
						'shippingRateId' => $addArr['shippingRateId'],						
						'productId'      => $addArr['productId'],
						'freeShipCatId'  => $addArr['freeShipCatId'],
						'freeShipPrdId'  => $addArr['freeShipPrdId'],						
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_delivery_details',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function update_shipping_address_buy_now_delivery($cartId,$shippingOrgId,$shippingRateId)
	{
		$updateOpt = array(
						'shippingOrgId'  => $shippingOrgId,
						'shippingRateId' => $shippingRateId,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where('cartId',$cartId);
		$this->db->update('cart_delivery_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_buy_now_delivery($cartId)
	{
		$updateOpt = array(
						'pickupId'		 => 0,
						'isPickup'		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_pickup_address($cartId,$pickupId)
	{		
		$updateOpt = array(
						'pickupId'		 => $pickupId,
						'isPickup'		 => 1,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where(array('cartId' => $cartId,'active' => 1));
		$this->db->update('cart',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function unactive_old_retailer_standard_delivery($updateArr)
	{
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where(array('createdBy' => $this->session->userdata('userId'),'active' => 1,'organizationId' => $updateArr['retailerId']));
		$this->db->update('cart_economical_delivery_details',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_standard_delivery($addArr)
	{
		$insertOpt = array(
						'organizationId' 	  => $addArr['retailerId'],
						'fromDropshipId'	  => $addArr['toDropshipId'],	
						'totalProductWeight'  => $addArr['totalProductWeight'],
						'finalShippingOrgId'  => $addArr['finalShippingOrgId'],
						'finalShippingRateId' => $addArr['finalShippingRateId'],
						'isCalculateShipp'    => $addArr['isCalculateShipp'],
						'active'			  => 1,
						'createdBy'			  => $this->session->userdata('userId'),
						'createDt'			  => date('Y-m-d H:i:s'),
						'lastModifiedBy'	  => $this->session->userdata('userId'),
						'lastModifiedDt'	  => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_economical_delivery_details',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function standard_delivery_details($organizationId,$customerId)
	{
		$this->db->select('shipping_rate.ETA,shipping_rate.amount AS shippingRate,cart_economical_delivery_details.*,organization.organizationName,employee.email,employee.businessPhone');
		$this->db->from('cart_economical_delivery_details');
		$this->db->join('organization','cart_economical_delivery_details.finalShippingOrgId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('shipping_rate','cart_economical_delivery_details.finalShippingRateId = shipping_rate.shippingRateId AND cart_economical_delivery_details.finalShippingOrgId = shipping_rate.shippingOrgId');
		$this->db->where(array(
							'cart_economical_delivery_details.organizationId' => $organizationId,
							'cart_economical_delivery_details.createdBy'      => $customerId,
							'cart_economical_delivery_details.active'         => 1,
							'shipping_rate.active'					          => 1,
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function remove_economical_delivery_from_cart()
	{		
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
					 );
		$this->db->where(array('createdBy' => $this->session->userdata('userId'),'active' => 1));
		$this->db->update('cart_economical_delivery_details',$updateOpt);
		return $this->db->affected_rows();	
	}
	
	public function add_commission_price($cartId,$addArr)
	{
		$insertOpt = array(
						'cartId'         	  => $cartId,	
						'retailerQuotedPrice' => $addArr['retailerQuotedPrice'],
						'retailerPrice'		  => $addArr['retailerPrice'],
						'spacePointePrice' 	  => $addArr['spacePointeCommissionPrice'],
						'spacePointePrice2'   => $addArr['spacePointeCommissionPrice2'],
						'cashAdminPrice'	  => $addArr['adminPrice'],
						'categoryCommission'  => $addArr['categoryCommission'],
						'categoryCommission2' => $addArr['categoryCommission2'],
						'cashAdminFee'		  => $addArr['cashAdminFee'],
						'genuineShippFee'	  => $addArr['genuineShippFee'],
						'lastModifiedBy'	  => $this->session->userdata('userId'),
						'lastModifiedDt'	  => date('Y-m-d H:i:s'),						
					);
		$this->db->insert('cart_commission',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_total_cart_same_day_buy_now($addArr)
	{
		$insertOpt = array(
						'productTypeId' 			=> $addArr['productTypeId'],
						'totalAmount'				=> $addArr['totalAmount'],
						'totalShippingAmount' 		=> $addArr['totalShippingAmount'],
						'totalCashHandlingAmount'	=> 0,
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery'        => 2,
						'isMobileDevice'			=> 0,
						'isPickup' 					=> 0,
						'isPointeForce'				=> $addArr['isPointeForce'],
						'active'					=> 1,
						'createBy'					=> $this->session->userdata('userId'),
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'			=> $this->session->userdata('userId'),
						'lastModifiedDt'			=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_total',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_cart_custom_same_day_buy_now($cartTotalId,$addArr)
	{
		$insertOpt = array(
						'cartTotalId' 					  => $cartTotalId,
						'organizationId'				  => $addArr['organizationId'],
						'dropShipCenterId' 				  => $addArr['dropShipCenterId'],
						'totalCustomAmount' 			  => $addArr['totalCustomAmount'],
						'totalCustomShippingAmount' 	  => $addArr['totalCustomShippingAmount'],
						'totalCustomCashHandlingAmount'   => 0,
						'totalCustomPickupProccessAmount' => 0,
						'totalRetailerAmount' 			  => $addArr['totalRetailerAmount'],
						'totalCustomPointeForceAmount' 	  => $addArr['totalCustomPointeForceAmount'],
						'active'						  => 1,
						'createBy'					 	  => $this->session->userdata('userId'),
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'				  => $this->session->userdata('userId'),
						'lastModifiedDt'				  => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_custom',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_cart_details_same_day_buy_now($cartCustomId,$addArr)
	{
		$insertOpt = array(
						'cartCustomId' 			=> $cartCustomId,
						'quantity'				=> $addArr['quantity'],
						'retailerAmount' 		=> $addArr['retailerAmount'],
						'productAmount' 		=> $addArr['productAmount'],
						'totalRetailAmount' 	=> $addArr['totalRetailAmount'],
						'totalProductAmount'    => $addArr['totalProductAmount'],
						'organizationProductId' => $addArr['organizationProductId'],
						'productId' 			=> $addArr['productId'],
						'marketingProductId' 	=> $addArr['marketingProductId'],
						'retailerDiscount' 	    => $addArr['retailerDiscount'],
						'colorId' 	  			=> $addArr['colorId'],
						'productSizeId' 	    => $addArr['productSizeId'],
						'productImageId' 	  	=> $addArr['productImageId'],
						'productWeight' 	  	=> $addArr['productWeight'],
						'inventoryHistoryId' 	=> $addArr['inventoryHistoryId'],
						'active'				=> 1,
						'createBy'				=> $this->session->userdata('userId'),
						'createDt'		        => date('Y-m-d H:i:s'),
						'lastModifiedBy'		=> $this->session->userdata('userId'),
						'lastModifiedDt'		=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_details',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_cart_vendor_same_day_buy_now($cartDetailId,$addArr)
	{
		$insertOpt = array(
						'cartDetailId' 		  => $cartDetailId,
						'shippingOrgId'		  => $addArr['shippingOrgId'],
						'shippingRateId' 	  => $addArr['shippingRateId'],
						'shippingAmount' 	  => $addArr['shippingAmount'],
						'estimateDayDelivery' => 0,
						'active'			  => 1,
						'createBy'			  => $this->session->userdata('userId'),
						'createDt'		      => date('Y-m-d H:i:s'),
						'lastModifiedBy'	  => $this->session->userdata('userId'),
						'lastModifiedDt'	  => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_shipping_vendor',$insertOpt);
		return $this->db->insert_id();		
	}
	
	public function add_cart_free_shipp_same_day_buy_now($cartDetailId,$addArr)
	{
		$insertOpt = array(
						'cartDetailId' 		 => $cartDetailId,
						'freeShipCatId'		 => $addArr['freeShipCatId'],
						'freeShipPrdId' 	 => $addArr['freeShipPrdId'],
						'spacePointePrice' 	 => $addArr['spacePointePrice'],
						'categoryCommission' => $addArr['categoryCommission'],
						'cashAdminPrice'     => $addArr['cashAdminPrice'],
						'isCashAdmin' 		 => $addArr['isCashAdmin'],
						'isGenuineShipp' 	 => $addArr['isGenuineShipp'],
						'active'			 => 1,
						'createBy'			 => $this->session->userdata('userId'),
						'createDt'		     => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_free_shipping_details',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_cart_pointe_force_same_day_buy_now($cartDetailId,$addArr)
	{
		$insertOpt = array(
						'cartDetailId' 		   => $cartDetailId,
						'verifiedStatus'	   => $addArr['verifiedStatus'],
						'customerId' 		   => $this->session->userdata('userId'),
						'commissionPrice' 	   => $addArr['commissionPrice'],
						'totalCommissionPrice' => $addArr['totalCommissionPrice'],
						'active'			   => 1,
						'createBy'			   => $this->session->userdata('userId'),
						'createDt'		       => date('Y-m-d H:i:s'),
						'lastModifiedBy'	   => $this->session->userdata('userId'),
						'lastModifiedDt'	   => date('Y-m-d H:i:s'),
					);
		$this->db->insert('cart_pointe_force',$insertOpt);
		return $this->db->insert_id();		
	}
}