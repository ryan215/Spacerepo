<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_retailer_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function available_total_amount()
	{		
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		
		$this->db->select('SUM(order_custom_payment.totalRetailerAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('employee','order_custom_payment.organizationId = employee.organizationId');
		$this->db->join('organization','employee.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   		=> 1,
							'order_custom_payment.active'  	   		=> 1,
							'order_details.active' 		   	   		=> 1,
							'order_details.orderStatusId'  	   		=> 5,
							'employee.active' 		  	   	   		=> 1,
							'employee.isDelete'		  	   	   	    => 0,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
		
	public function add_initiate_payment($organizationId,$addData)
	{
		$insertOpt = array(
						'organizationId'	=> $organizationId,
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
		$this->db->insert('finance_retailer_initiate_payment',$insertOpt);
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
    		$this->db->update('order_custom_payment',$updateOpt);
	    	return $this->db->affected_rows();
		}
		else
		{
			return false;
		}
	}
	
	public function add_initiate_payment_order($insertBatchArr)
	{
		$this->db->insert_batch('finance_retailer_clear_payment',$insertBatchArr);
		return $this->db->insert_id();
	}
	
	public function processing_retailer_list()
    {
		$this->db->select('order_total.orderTotalId,order_total.customerId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalRetailerAmount,order_custom_payment.organizationId,organization.organizationName,employee.firstName,employee.lastName,employee.email,employee.businessPhone,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName,finance_retailer_clear_payment.financeRetailerIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('employee','order_custom_payment.organizationId = employee.organizationId');
		$this->db->join('organization_address','order_custom_payment.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	    			  => 1,
							'order_custom_payment.active'  	    			  => 1,
							'order_details.active' 		   	    			  => 1,
							'order_details.orderStatusId' 		  			  => 5,
							'employee.active' 		  	   	    			  => 1,
							'employee.isDelete'		  	   	    			  => 0,
							'finance_retailer_clear_payment.processingStatus' => 1,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$this->db->order_by('employee.firstName','ASC');
		$this->db->group_by('order_custom_payment.organizationId');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function total_processing_amount($organizationId)
	{	
		$this->db->select('SUM(order_custom_payment.totalRetailerAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->where(array(
							'order_total.active'		   	      			  => 1,
							'order_custom_payment.active'  	      			  => 1,
							'order_details.active' 		   	      			  => 1,
							'order_details.orderStatusId'	      			  => 5,
							'order_track.orderStatusId'	     	  			  => 5,
							'order_custom_payment.organizationId' 			  => $organizationId,
							'finance_retailer_clear_payment.processingStatus' => 1,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function proccessing_order_list($organizationId)
    {
		$this->db->select('order_total.orderTotalId,order_total.isPickup,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_custom_payment.totalRetailerAmount,order_details.totalRetailAmount,order_details.orderDetailId,finance_retailer_clear_payment.financeRetailerIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'	      => 5,
							'order_track.orderStatusId'	     	  => 5,
							'order_custom_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.processingStatus' => 1,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function proccessing_initiate_payment($organizationId,$financeRetailerPayId)
    {
		$this->db->select('finance_retailer_initiate_payment.clearAmount,finance_retailer_clear_payment.orderCustomPaymentId,finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_initiate_payment');
		$this->db->join('finance_retailer_clear_payment','finance_retailer_initiate_payment.financeRetailerPayId = finance_retailer_clear_payment.financeRetailerIniPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.organizationId'    	 => $organizationId,
							'finance_retailer_clear_payment.financeRetailerIniPayId' => $financeRetailerPayId,
							'finance_retailer_clear_payment.processingStatus' 	 => 1,
							'finance_retailer_clear_payment.active'				 => 1
						));
		return $this->db->get()->result();
	}
	
	public function add_reference_number($financeRetailerPayId,$updateData)
	{
		$updateOpt = array(
						'referenceNumber' => $updateData['referenceNumber'],
						'lastModifiedBy'  => $this->session->userdata('userId'),
						'lastModifiedDt'  => date('Y-m-d H:i:s'),
					);
					
        $this->db->where('financeRetailerPayId',$financeRetailerPayId);
        $this->db->update('finance_retailer_initiate_payment',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function clear_payment_status($financeRetailerIniPayId)
	{
		$updateOpt = array(
						'processingStatus' => 2,
						'paidStatus' => 1,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
					);
					
        $this->db->where('financeRetailerIniPayId',$financeRetailerIniPayId);
        $this->db->update('finance_retailer_clear_payment',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function clear_payment_retailer_order_status($where)
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
    		$this->db->update('order_custom_payment',$updateOpt);
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
							'order_pointe_force.processingStatus' => 2,
							'order_pointe_force.paidStatus' 	  => 1,
						));
		$this->db->order_by('customer.firstName','ASC');
		return $this->db->get()->result();
	}
	
	public function paid_order_list($organizationId)
    {		
		$this->db->select('order_total.orderTotalId,order_total.isPickup,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_custom_payment.totalRetailerAmount,order_details.totalRetailAmount,order_details.orderDetailId,finance_retailer_clear_payment.financeRetailerIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'	      => 5,
							'order_track.orderStatusId'	     	  => 5,
							'order_custom_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.processingStatus' => 2,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function retailer_paid_order_list($organizationId)
    {		
		$this->db->select('order_total.orderTotalId,order_total.isPickup,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_custom_payment.totalRetailerAmount,order_details.totalRetailAmount,order_details.orderDetailId,finance_retailer_clear_payment.financeRetailerIniPayId,finance_retailer_initiate_payment.referenceNumber,finance_retailer_initiate_payment.createDt AS initiateAmtDt,finance_retailer_initiate_payment.lastModifiedDt AS clearAmtDt');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      			  => 1,
							'order_custom_payment.active'  	      			  => 1,
							'order_details.active' 		   	      			  => 1,
							'order_details.orderStatusId'	      			  => 5,
							'order_track.orderStatusId'	     	  			  => 5,
							'order_custom_payment.organizationId' 			  => $organizationId,
							'finance_retailer_clear_payment.processingStatus' => 2,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function clear_payment_bank_list($organizationId)
	{
		$this->db->select('financeRetailerPayId,bankName,accountHolderName,accountNumber,referenceNumber,clearAmount,createDt,lastModifiedDt');
		$this->db->from('finance_retailer_initiate_payment');
		$this->db->where(array('organizationId' => $organizationId,'active' => 1));
		$this->db->order_by('financeRetailerPayId','ASC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function proceesing_payment_bank_details($financeRetailerPayId)
	{
		$this->db->select('financeRetailerPayId,bankName,accountHolderName,accountNumber,referenceNumber,clearAmount,createDt,lastModifiedDt');
		$this->db->from('finance_retailer_initiate_payment');
		$this->db->where(array(
							'financeRetailerPayId'	  => $financeRetailerPayId,
							'active' 				  => 1,
							'referenceNumber'		  => ''
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function paid_retailer_list()
    {
		$this->db->select('order_total.orderTotalId,order_total.customerId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalRetailerAmount,order_custom_payment.organizationId,organization.organizationName,employee.firstName,employee.lastName,employee.email,employee.businessPhone,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName,finance_retailer_clear_payment.financeRetailerIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('employee','order_custom_payment.organizationId = employee.organizationId');
		$this->db->join('organization_address','order_custom_payment.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	    			  => 1,
							'order_custom_payment.active'  	    			  => 1,
							'order_details.active' 		   	    			  => 1,
							'order_details.orderStatusId' 		  			  => 5,
							'employee.active' 		  	   	    			  => 1,
							'employee.isDelete'		  	   	    			  => 0,
							'finance_retailer_clear_payment.processingStatus' => 2,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$this->db->order_by('employee.firstName','ASC');
		$this->db->group_by('order_custom_payment.organizationId');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function total_paid_amount($organizationId)
	{	
		$this->db->select('SUM(order_custom_payment.totalRetailerAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->where(array(
							'order_total.active'		   	      			  => 1,
							'order_custom_payment.active'  	      			  => 1,
							'order_details.active' 		   	      			  => 1,
							'order_details.orderStatusId'	      			  => 5,
							'order_track.orderStatusId'	     	  			  => 5,
							'order_custom_payment.organizationId' 			  => $organizationId,
							'finance_retailer_clear_payment.processingStatus' => 2,
							'finance_retailer_clear_payment.active'			  => 1
						));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_available_total_amount($organizationId)
	{		
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_initiate_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		$this->db->select('SUM(order_details.totalRetailAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId AND order_details.orderStatusId = order_track.orderStatusId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'DATE(order_track.createDt) <= '	  => date('Y-m-d',strtotime('-3 days')),
							'order_custom_payment.organizationId' => $organizationId
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_processing_total_amount($organizationId)
	{
		$this->db->select('SUM(order_details.totalRetailAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_custom_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.active' => 1,
							'finance_retailer_clear_payment.processingStatus' => 1
						));
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	
	}
	
	public function retailer_paid_total_amount($organizationId)
	{
		$this->db->select('SUM(order_details.totalRetailAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('finance_retailer_clear_payment','order_details.orderDetailId = finance_retailer_clear_payment.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_custom_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.active' => 1,
							'finance_retailer_clear_payment.processingStatus' => 2
						));
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_ledger_order_list($organizationId)
    {		
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_initiate_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}

		$this->db->select('order_total.orderTotalId,order_total.isPickup,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_custom_payment.totalRetailerAmount,order_details.totalRetailAmount,order_details.orderDetailId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId != '	  => 6,
							'order_custom_payment.organizationId' => $organizationId,
							'DATE(order_track.createDt) >= '	  => date('Y-m-d'),
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$this->db->group_by('order_details.orderDetailId');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function retailer_available_order_list($organizationId)
    {	
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_initiate_payment.organizationId' => $organizationId,
							'finance_retailer_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.isPickup,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_custom_payment.totalRetailerAmount,order_details.totalRetailAmount,order_details.orderDetailId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId AND order_details.orderStatusId = order_track.orderStatusId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'DATE(order_track.createDt) <= '	  => date('Y-m-d',strtotime('-3 days')),
							'order_custom_payment.organizationId' => $organizationId
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function available_retailer_list()
    {
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_clear_payment.active'    		   => 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.customerId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalRetailerAmount,order_custom_payment.organizationId,organization.organizationName,employee.firstName,employee.lastName,employee.email,employee.businessPhone,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('organization','order_custom_payment.organizationId = organization.organizationId');
		$this->db->join('employee','order_custom_payment.organizationId = employee.organizationId');
		$this->db->join('organization_address','order_custom_payment.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	    => 1,
							'order_custom_payment.active'  	    => 1,
							'order_details.active' 		   	    => 1,
							'order_details.orderStatusId != '   => 6,
							'employee.active' 		  	   	    => 1,
							'employee.isDelete'		  	   	    => 0,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$this->db->order_by('employee.firstName','ASC');
		$this->db->group_by('order_custom_payment.organizationId');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function total_available_ledger_amount($organizationId)
	{	
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_clear_payment.active'    		   => 1,
							'finance_retailer_initiate_payment.organizationId' => $organizationId,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		
		$this->db->select('SUM(order_custom_payment.totalRetailerAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId AND order_details.orderStatusId = order_track.orderStatusId');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId != '     => 6,
							'order_custom_payment.organizationId' => $organizationId,
							'DATE(order_track.createDt) >= '	  => date('Y-m-d'),
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_available_amount($organizationId)
	{	
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_clear_payment.active'    		   => 1,
							'finance_retailer_initiate_payment.organizationId' 		   => $organizationId,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		
		$this->db->select('SUM(order_custom_payment.totalRetailerAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'	      => 5,
							'order_track.orderStatusId'	     	  => 5,
							'order_custom_payment.organizationId' => $organizationId,
							'DATE(order_track.createDt) <= '	  => date('Y-m-d',strtotime('-3 days')),
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function available_order_list($organizationId)
    {
		$this->db->select('finance_retailer_clear_payment.orderDetailId');
		$this->db->from('finance_retailer_clear_payment');
		$this->db->join('finance_retailer_initiate_payment','finance_retailer_clear_payment.financeRetailerIniPayId = finance_retailer_initiate_payment.financeRetailerPayId');
		$this->db->where(array(
							'finance_retailer_initiate_payment.active' 		   => 1,
							'finance_retailer_clear_payment.active'    		   => 1,
							'finance_retailer_initiate_payment.organizationId' 		   => $organizationId,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderDetailId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.isPickup,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_custom_payment.totalRetailerAmount,order_details.totalRetailAmount,order_details.orderDetailId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_track','order_details.orderDetailId = order_track.orderDetailId');
		$this->db->join('product','product.productId = order_details.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	      => 1,
							'order_custom_payment.active'  	      => 1,
							'order_details.active' 		   	      => 1,
							'order_details.orderStatusId'	      => 5,
							'order_track.orderStatusId'	     	  => 5,
							'order_custom_payment.organizationId' => $organizationId,
							'DATE(order_track.createDt) <= '	  => date('Y-m-d',strtotime('-3 days')),
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_details.orderDetailId',$array);
		}
		$result = $this->db->get()->result();
		return $result;
	}
}