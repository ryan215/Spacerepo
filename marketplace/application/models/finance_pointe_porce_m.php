<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_pointe_porce_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function available_total_amount()
	{		
		$this->db->select('finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->from('finance_pointe_force_clear_payment');
		$this->db->join('finance_pointe_force_initiate_payment','finance_pointe_force_clear_payment.financePointefIniPayId = finance_pointe_force_initiate_payment.financePointefIniPayId');
		$this->db->where(array(
							'finance_pointe_force_initiate_payment.active' 		   => 1,
							'finance_pointe_force_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderPointeForceId;
			}
		}
		
		$this->db->select('SUM(order_pointe_force.totalCommissionPrice) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('customer','order_total.customerId = customer.customerId');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_total.isPointeForce'	   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId != '     => 6,
							'customer.active' 		  	   	      => 1,
							'customer.isDelete'		  	   	      => 0,
							'order_pointe_force.active' 	      => 1,
							'order_pointe_force.verifiedStatus'   => 1,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_pointe_force.orderPointeForceId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
		
	public function available_pointe_force_list()
    {
		$this->db->select('finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->from('finance_pointe_force_clear_payment');
		$this->db->join('finance_pointe_force_initiate_payment','finance_pointe_force_clear_payment.financePointefIniPayId = finance_pointe_force_initiate_payment.financePointefIniPayId');
		$this->db->where(array(
							'finance_pointe_force_initiate_payment.active' 		   => 1,
							'finance_pointe_force_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderPointeForceId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.customerId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomPointeForceAmount,customer.firstName,customer.lastName,customer.email,customer.phone,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('customer','order_total.customerId = customer.customerId');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	    => 1,
							'order_total.isPointeForce'	   	    => 1,
							'order_custom_payment.active'  	    => 1,
							'order_details.active' 		   	    => 1,
							'order_details.orderStatusId != '   => 6,
							'customer.active' 		  	   	    => 1,
							'customer.isDelete'		  	   	    => 0,
							'order_pointe_force.active' 	    => 1,
							'order_pointe_force.verifiedStatus' => 1,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_pointe_force.orderPointeForceId',$array);
		}		
		$this->db->order_by('customer.firstName','ASC');
		return $this->db->get()->result();
	}
	
	public function available_order_list($customerId)
    {
		$this->db->select('finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->from('finance_pointe_force_clear_payment');
		$this->db->join('finance_pointe_force_initiate_payment','finance_pointe_force_clear_payment.financePointefIniPayId = finance_pointe_force_initiate_payment.financePointefIniPayId');
		$this->db->where(array(
							'finance_pointe_force_initiate_payment.active' 		   => 1,
							'finance_pointe_force_clear_payment.active'    		   => 1,
							'finance_pointe_force_initiate_payment.customerId'    		   => $customerId,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderPointeForceId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_pointe_force.totalCommissionPrice,order_custom_payment.totalCustomPointeForceAmount,order_pointe_force.orderPointeForceId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	    => 1,
							'order_total.isPointeForce'	   	    => 1,
							'order_custom_payment.active'  	    => 1,
							'order_details.active' 		   	    => 1,
							'order_details.orderStatusId != '   => 6,
							'order_pointe_force.active' 	    => 1,
							'order_pointe_force.verifiedStatus' => 1,
							'order_total.customerId' 		    => $customerId,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_pointe_force.orderPointeForceId',$array);
		}
		return $this->db->get()->result();
	}
	
	public function add_initiate_payment($customerId,$addData)
	{
		$insertOpt = array(
						'customerId'		=> $customerId,
						'bankName' 		    => $addData['bankName'],
						'accountHolderName' => $addData['accountHolderName'],
						'accountNumber' 	=> $addData['accountNumber'],
						'clearAmount'		=> $addData['totalAmount'],
						'active'			=> 1,
						'createBy'			=> $this->session->userdata('userId'),
						'createDt' 			=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 	=> $this->session->userdata('userId'),
						'lastModifiedDt' 	=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('finance_pointe_force_initiate_payment',$insertOpt);
        return $this->db->insert_id();
	}
	
	public function update_order_initiate_payment($where)
	{
		if(!empty($where))
		{
			$updateOpt = array(
							'processingStatus' => 1,
							'lastModifiedBy'   => $this->session->userdata('userId'),
							'lastModifiedDt'   => date('Y-m-d H:i:s'),
						);
			$this->db->where($where);
    		$this->db->update('order_pointe_force',$updateOpt);
	    	return $this->db->affected_rows();
		}
		else
		{
			return false;
		}
	}
	
	public function add_initiate_payment_order($insertBatchArr)
	{
		$this->db->insert_batch('finance_pointe_force_clear_payment',$insertBatchArr);
		return $this->db->insert_id();
	}
	
	public function processing_pointe_force_list()
    {
		$this->db->select('order_total.orderTotalId,order_total.customerId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomPointeForceAmount,customer.firstName,customer.lastName,customer.email,customer.phone,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName,finance_pointe_force_clear_payment.financePointefIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('finance_pointe_force_clear_payment','order_pointe_force.orderPointeForceId = finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->join('customer','order_total.customerId = customer.customerId');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	    => 1,
							'order_total.isPointeForce'	   	    => 1,
							'order_custom_payment.active'  	    => 1,
							'order_details.active' 		   	    => 1,
							'order_details.orderStatusId != '   => 6,
							'customer.active' 		  	   	    => 1,
							'customer.isDelete'		  	   	    => 0,
							'order_pointe_force.active' 	    => 1,
							'order_pointe_force.verifiedStatus' => 1,
							'finance_pointe_force_clear_payment.processingStatus' => 1,
							'finance_pointe_force_clear_payment.active'			=> 1
						));
		$this->db->order_by('customer.firstName','ASC');
		return $this->db->get()->result();
	}
	
	public function proccessing_order_list($customerId)
    {
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_pointe_force.totalCommissionPrice,order_custom_payment.totalCustomPointeForceAmount,order_pointe_force.orderPointeForceId,finance_pointe_force_clear_payment.financePointefIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('finance_pointe_force_clear_payment','order_pointe_force.orderPointeForceId = finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	    => 1,
							'order_total.isPointeForce'	   	    => 1,
							'order_custom_payment.active'  	    => 1,
							'order_details.active' 		   	    => 1,
							'order_details.orderStatusId != '   => 6,
							'order_pointe_force.active' 	    => 1,
							'order_pointe_force.verifiedStatus' => 1,
							'order_total.customerId' 		    => $customerId,
							'finance_pointe_force_clear_payment.processingStatus' => 1,
							'finance_pointe_force_clear_payment.active'			=> 1
						));
		return $this->db->get()->result();
	}
	
	public function proccessing_initiate_payment($customerId,$financePointefIniPayId)
    {
		$this->db->select('finance_pointe_force_initiate_payment.clearAmount,finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->from('finance_pointe_force_initiate_payment');
		$this->db->join('finance_pointe_force_clear_payment','finance_pointe_force_initiate_payment.financePointefIniPayId = finance_pointe_force_clear_payment.financePointefIniPayId');
		$this->db->where(array(
							'finance_pointe_force_initiate_payment.customerId'    	 => $customerId,
							'finance_pointe_force_clear_payment.financePointefIniPayId' => $financePointefIniPayId,
							'finance_pointe_force_clear_payment.processingStatus' 	 => 1,
							'finance_pointe_force_clear_payment.active'				 => 1
						));
		return $this->db->get()->result();
	}
	
	public function add_reference_number($financePointefIniPayId,$updateData)
	{
		$updateOpt = array(
						'referenceNumber' => $updateData['referenceNumber'],
						'lastModifiedBy'  => $this->session->userdata('userId'),
						'lastModifiedDt'  => date('Y-m-d H:i:s'),
					);
					
        $this->db->where('financePointefIniPayId',$financePointefIniPayId);
        $this->db->update('finance_pointe_force_initiate_payment',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function clear_payment_status($financePointefIniPayId)
	{
		$updateOpt = array(
						'processingStatus' => 2,
						'paidStatus' => 1,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
					);
					
        $this->db->where('financePointefIniPayId',$financePointefIniPayId);
        $this->db->update('finance_pointe_force_clear_payment',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function clear_payment_pointe_force_order_status($where)
	{
		if(!empty($where))
		{
			$updateOpt = array(
							'paidStatus'	   => 1,
							'processingStatus' => 2,
							'lastModifiedBy'   => $this->session->userdata('userId'),
							'lastModifiedDt'   => date('Y-m-d H:i:s'),
						);
			$this->db->where($where);
    		$this->db->update('order_pointe_force',$updateOpt);
	    	return $this->db->affected_rows();
		}
		else
		{
			return false;
		}
	}
	
	public function paid_pointe_force_list()
    {
		$this->db->select('order_total.orderTotalId,order_total.customerId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomPointeForceAmount,customer.firstName,customer.lastName,customer.email,customer.phone,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('finance_pointe_force_clear_payment','order_pointe_force.orderPointeForceId = order_pointe_force.orderPointeForceId');
		$this->db->join('customer','order_total.customerId = customer.customerId');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_total.isPointeForce'	   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId != '     => 6,
							'customer.active' 		  	   	      => 1,
							'customer.isDelete'		  	   	      => 0,
							'order_pointe_force.active' 	      => 1,
							'order_pointe_force.verifiedStatus'   => 1,
							'finance_pointe_force_clear_payment.processingStatus' => 2,
							'finance_pointe_force_clear_payment.active' 	  => 1,
						));
		$this->db->order_by('customer.firstName','ASC');
		return $this->db->get()->result();
	}
	
	public function paid_order_list($customerId)
    {		
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_pointe_force.totalCommissionPrice,order_custom_payment.totalCustomPointeForceAmount,order_pointe_force.orderPointeForceId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_pointe_force','order_details.orderDetailId = order_pointe_force.orderDetailId');
		$this->db->join('finance_pointe_force_clear_payment','order_pointe_force.orderPointeForceId = finance_pointe_force_clear_payment.orderPointeForceId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	    => 1,
							'order_total.isPointeForce'	   	    => 1,
							'order_custom_payment.active'  	    => 1,
							'order_details.active' 		   	    => 1,
							'order_details.orderStatusId != '   => 6,
							'order_pointe_force.active' 	    => 1,
							'order_pointe_force.verifiedStatus' => 1,
							'order_total.customerId' 		    => $customerId,
							'finance_pointe_force_clear_payment.processingStatus' => 2,
							'finance_pointe_force_clear_payment.active' 	  => 1,
						));
		return $this->db->get()->result();
	}
	
	public function clear_payment_bank_list($customerId)
	{
		$this->db->select('financePointefIniPayId,bankName,accountHolderName,accountNumber,referenceNumber,clearAmount,createDt,lastModifiedDt');
		$this->db->from('finance_pointe_force_initiate_payment');
		$this->db->where(array('customerId' => $customerId,'active' => 1));
		$this->db->order_by('financePointefIniPayId','ASC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function proceesing_payment_bank_details($financePointefIniPayId)
	{
		$this->db->select('financePointefIniPayId,bankName,accountHolderName,accountNumber,referenceNumber,clearAmount,createDt,lastModifiedDt');
		$this->db->from('finance_pointe_force_initiate_payment');
		$this->db->where(array(
							'financePointefIniPayId' => $financePointefIniPayId,
							'active' 				=> 1,
							'referenceNumber'		=> ''
						));
		$result = $this->db->get()->row();
		return $result;
	}
}