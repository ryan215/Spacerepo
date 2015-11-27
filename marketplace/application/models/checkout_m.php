<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add_order_total_cash_on_delivery_same_day_delivery($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => $addArr['totalShippingAmount'],
						'totalCashHandlingAmount'	=> $addArr['totalCashHandlingAmount'],
						'totalSamDayAmount'			=> $addArr['totalSamDayAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery' 		=> 2,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 0,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 0,
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_total_cash_on_delivery_quick_shippment($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => $addArr['totalShippingAmount'],
						'totalCashHandlingAmount'	=> $addArr['totalCashHandlingAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery' 		=> 0,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 0,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 0,
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_total_pay_online_same_day_delivery($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => $addArr['totalShippingAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'totalSamDayAmount'			=> $addArr['totalSamDayAmount'],
						'totalCashHandlingAmount'	=> 0,
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery' 		=> 2,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 0,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 1,
						'paymentRef'     			=> $addArr['payment_reference'],
						'retrievalRef'   			=> $addArr['retrieval_reference'],
						'transactionRef' 			=> $addArr['transaction_reference'],
						'merchantRef'				=> $addArr['merchant_reference'],
						'transactionDate'	    	=> $addArr['transaction_date'],
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_total_pay_online_quick_shippment($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => $addArr['totalShippingAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'totalCashHandlingAmount'	=> 0,
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery' 		=> 0,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 0,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 1,
						'paymentRef'     	=> $addArr['payment_reference'],
						'retrievalRef'   	=> $addArr['retrieval_reference'],
						'transactionRef' 	=> $addArr['transaction_reference'],
						'merchantRef'		=> $addArr['merchant_reference'],
						'transactionDate'	    	=> $addArr['transaction_date'],
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_custom_payment_cash_on_delivery($orderTotalId,$addArr)
	{
		$insertOpt = array(
						'orderTotalId'           		  => $orderTotalId,	
						'customOrderId'            		  => $addArr['customOrderId'],
						'organizationId'                  => $addArr['organizationId'],
						'dropShipCenterId'       		  => $addArr['dropShipCenterId'],
						'totalCustomAmount'				  => $addArr['totalCustomAmount'],
						'totalCustomShippingAmount' 	  => $addArr['totalCustomShippingAmount'],
						'totalCustomCashHandlingAmount'   => $addArr['totalCustomCashHandlingAmount'],
						'totalCustomPointeForceAmount'    => $addArr['totalCustomPointeForceAmount'],
						'totalCustomPickupProccessAmount' => 0,
						'totalRetailerAmount'         	  => $addArr['totalRetailerAmount'],
						'active'       	    			  => 1,
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'createBy'			    		  => $this->session->userdata('userId'),
						'lastModifiedBy'      			  => $this->session->userdata('userId'),
						'lastModifiedDt' 	    		  => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_custom_payment',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_custom_payment_pay_online_delivery($orderTotalId,$addArr)
	{
		$insertOpt = array(
						'orderTotalId'           		  => $orderTotalId,	
						'customOrderId'            		  => $addArr['customOrderId'],
						'organizationId'                  => $addArr['organizationId'],
						'dropShipCenterId'       		  => $addArr['dropShipCenterId'],
						'totalCustomAmount'				  => $addArr['totalCustomAmount'],
						'totalCustomShippingAmount' 	  => $addArr['totalCustomShippingAmount'],
						'totalCustomPointeForceAmount'    => $addArr['totalCustomPointeForceAmount'],
						'totalCustomCashHandlingAmount'   => 0,
						'totalCustomPickupProccessAmount' => 0,
						'totalRetailerAmount'         	  => $addArr['totalRetailerAmount'],
						'totalCustomPointeForceAmount'    => 0,
						'active'       	    			  => 1,
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'createBy'			    		  => $this->session->userdata('userId'),
						'lastModifiedBy'      			  => $this->session->userdata('userId'),
						'lastModifiedDt' 	    		  => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_custom_payment',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_details($orderCustomPaymentId,$addArr)
	{
		if($addArr['productSizeId'])
		{
		}
		else
		{
			$addArr['productSizeId'] = 0;
		}
		
		$insertOpt = array(
						'orderCustomPaymentId'  => $orderCustomPaymentId,	
						'quantity'              => $addArr['quantity'],
						'retailerAmount'        => $addArr['retailerAmount'],
						'productAmount'       	=> $addArr['productAmount'],
						'totalRetailAmount'     => $addArr['totalRetailAmount'],
						'totalProductAmount'    => $addArr['totalProductAmount'],
						'organizationProductId' => $addArr['organizationProductId'],
						'productId' 	  		=> $addArr['productId'],
						'marketingProductId'    => $addArr['marketingProductId'],
						'orderStatusId' 		=> 1,
						'retailerDiscount'      => $addArr['retailerDiscount'],
						'colorId'    			=> $addArr['colorId'],
						'productSizeId'    		=> $addArr['productSizeId'],
						'productImageId'    	=> $addArr['productImageId'],
						'productWeight'    		=> $addArr['productWeight'],
						'inventoryHistoryId'    => $addArr['inventoryHistoryId'],
						'active'       	    	=> 1,
						'createDt'		        => date('Y-m-d H:i:s'),
						'createBy'			    => $this->session->userdata('userId'),
						'lastModifiedBy'      	=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_details',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_vendor($orderDetailId,$addArr)
	{
		$insertOpt = array(
						'orderDetailId'           		  => $orderDetailId,	
						'shippingOrgId'            		  => $addArr['shippingOrgId'],
						'shippingRateId'                  => $addArr['shippingRateId'],
						'shippingAmount'       		 	  => $addArr['shippingAmount'],
						'estimateDayDelivery'			  => $addArr['estimateDayDelivery'],
						'active'       	    			  => 1,
						'createBy'			    		  => $this->session->userdata('userId'),
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'      			  => $this->session->userdata('userId'),
						'lastModifiedDt' 	    		  => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_shipping_vendor',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_vendor_unactive($orderDetailId,$addArr)
	{
		$insertOpt = array(
						'orderDetailId'           		  => $orderDetailId,	
						'shippingOrgId'            		  => $addArr['shippingOrgId'],
						'shippingRateId'                  => $addArr['shippingRateId'],
						'shippingAmount'       		 	  => $addArr['shippingAmount'],
						'estimateDayDelivery'			  => $addArr['estimateDayDelivery'],
						'active'       	    			  => 0,
						'createBy'			    		  => $this->session->userdata('userId'),
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'      			  => $this->session->userdata('userId'),
						'lastModifiedDt' 	    		  => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_shipping_vendor',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_free_shipping($orderDetailId,$addArr)
	{
		$insertOpt = array(
						'orderDetailId'      => $orderDetailId,	
						'freeShipCatId'      => $addArr['freeShipCatId'],
						'freeShipPrdId'      => $addArr['freeShipPrdId'],
						'spacePointePrice'   => $addArr['spacePointePrice'],
						'categoryCommission' => $addArr['categoryCommission'],
						'cashAdminPrice'	 => $addArr['cashAdminPrice'],
						'isCashAdmin'		 => $addArr['isCashAdmin'],
						'isGenuineShipp'	 => $addArr['isGenuineShipp'],
						'active'       	     => 1,
						'createBy'			 => $this->session->userdata('userId'),
						'createDt'		     => date('Y-m-d H:i:s'),
						'lastModifiedBy'     => $this->session->userdata('userId'),
						'lastModifiedDt' 	 => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_free_shipping_details',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_shipping_order_address($orderTotalId,$addressId)
	{
		$insertOpt = array(
					 	'orderTotalId'   => $orderTotalId,
						'addressId'      => $addressId,
						'addressTypeId'  => 3,
						'active' 		 => 1,
						'createBy'	     => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('order_address_detail',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_billing_order_address($orderTotalId,$addressId)
	{
		$insertOpt = array(
					 	'orderTotalId'   => $orderTotalId,
						'addressId'      => $addressId,
						'addressTypeId'  => 4,
						'active' 		 => 1,
						'createBy'	     => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('order_address_detail',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_profile_order_address($orderTotalId,$addressId)
	{
		$insertOpt = array(
					 	'orderTotalId'   => $orderTotalId,
						'addressId'      => $addressId,
						'addressTypeId'  => 1,
						'active' 		 => 1,
						'createBy'	     => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('order_address_detail',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_order_track_details($orderDetailId)
	{
		$insertOpt = array(
						'orderDetailId'  => $orderDetailId,
						'orderStatusId'  => 1,
						'active' 		 => 1,
						'createBy'	     => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('order_track',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_pointe_force($orderDetailId,$addArr)
	{
		$insertOpt = array(
						'orderDetailId'    	   => $orderDetailId,										
						'verifiedStatus'  	   => $addArr['verifiedStatus'],
						'customerId'      	   => $this->session->userdata('userId'),
						'commissionPrice' 	   => $addArr['commissionPrice'],
						'totalCommissionPrice' => $addArr['totalCommissionPrice'],						
						'createBy'		 	   => $this->session->userdata('userId'),
						'createDt'		  	   => date('Y-m-d H:i:s'),
						'lastModifiedBy'  	   => $this->session->userdata('userId'),
						'lastModifiedDt'  	   => date('Y-m-d H:i:s'),	
					 );
		$this->db->insert('order_pointe_force',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_total_cash_on_delivery_single_shippment($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => $addArr['totalShippingAmount'],
						'totalCashHandlingAmount'	=> $addArr['totalCashHandlingAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery' 		=> 1,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 0,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 0,
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_total_pay_online_single_shippment($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => $addArr['totalShippingAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'totalCashHandlingAmount'	=> 0,
						'totalPickupProccessAmount' => 0,
						'isEconomicDelivery' 		=> 1,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 0,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 1,
						'paymentRef'     	=> $addArr['payment_reference'],
						'retrievalRef'   	=> $addArr['retrieval_reference'],
						'transactionRef' 	=> $addArr['transaction_reference'],
						'merchantRef'		=> $addArr['merchant_reference'],
						'transactionDate'	    	=> $addArr['transaction_date'],
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_total_pay_online_pickup($addArr)
	{
		$insertOpt = array(
						'orderTypeId'           	=> $addArr['orderTypeId'],										
						'customerId'            	=> $addArr['customerId'],
						'totalAmount'               => $addArr['totalAmount'],
						'totalShippingAmount'       => 0,
						'totalCashHandlingAmount'	=> 0,
						'totalPickupProccessAmount' => $addArr['totalPickupProccessAmount'],
						'isPointeForce'				=> $addArr['isPointeForce'],
						'isEconomicDelivery' 		=> 0,
						'isMobileDevice'			=> 0,
						'isPickup'         			=> 1,
						'paymentTypeId'        		=> 1,
						'paymentStatus'         	=> 1,
						'paymentRef'     	=> $addArr['payment_reference'],
						'retrievalRef'   	=> $addArr['retrieval_reference'],
						'transactionRef' 	=> $addArr['transaction_reference'],
						'merchantRef'		=> $addArr['merchant_reference'],
						'transactionDate'	    	=> $addArr['transaction_date'],
						'active'       	    		=> 1,
						'createDt'		        	=> date('Y-m-d H:i:s'),
						'createBy'			    	=> $this->session->userdata('userId'),
						'lastModifiedBy'      		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	    	=> date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_total',$insertOpt);
		return $this->db->insert_id();
	}	
	
	public function add_order_custom_payment_pay_online_pickup($orderTotalId,$addArr)
	{
		$insertOpt = array(
						'orderTotalId'           		  => $orderTotalId,	
						'customOrderId'            		  => $addArr['customOrderId'],
						'organizationId'                  => $addArr['organizationId'],
						'dropShipCenterId'       		  => $addArr['dropShipCenterId'],
						'totalCustomAmount'				  => $addArr['totalCustomAmount'],
						'totalCustomShippingAmount' 	  => 0,
						'totalCustomCashHandlingAmount'   => 0,
						'totalCustomPickupProccessAmount' => $addArr['totalCustomPickupProccessAmount'],
						'totalRetailerAmount'         	  => $addArr['totalRetailerAmount'],
						'totalCustomPointeForceAmount'    => $addArr['totalCustomPointeForceAmount'],
						'active'       	    			  => 1,
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'createBy'			    		  => $this->session->userdata('userId'),
						'lastModifiedBy'      			  => $this->session->userdata('userId'),
						'lastModifiedDt' 	    		  => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_custom_payment',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_order_pickup($orderDetailId,$addArr)
	{
		$insertOpt = array(
						'orderDetailId'           		  => $orderDetailId,	
						'pickupId'						  => $addArr['pickupId'],
						'shippingOrgId'            		  => $addArr['shippingOrgId'],
						'shippingRateId'                  => $addArr['shippingRateId'],
						'pickupProcessingAmount'		  => $addArr['pickupProcessingAmount'],
						'estimateDayDelivery'			  => $addArr['estimateDayDelivery'],
						'active'       	    			  => 1,
						'createBy'			    		  => $this->session->userdata('userId'),
						'createDt'		        		  => date('Y-m-d H:i:s'),
						'lastModifiedBy'      			  => $this->session->userdata('userId'),
						'lastModifiedDt' 	    		  => date('Y-m-d H:i:s'),	
					 );	
		$this->db->insert('order_pickup',$insertOpt);
		return $this->db->insert_id();
	}
}