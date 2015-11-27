<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_vendor_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function available_total_amount()
	{	
		$this->db->select('finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->from('finance_vendor_clear_payment');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->where(array(
							'finance_vendor_initiate_payment.active' 		=> 1,
							'finance_vendor_clear_payment.active'    		=> 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderShippingVendorId;
			}
		}
			
		$this->db->select('SUM(order_shipping_vendor.shippingAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('employee','order_shipping_vendor.shippingOrgId = employee.organizationId');
		$this->db->join('organization','employee.organizationId = organization.organizationId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   => 1,
							'order_total.isPickup'		   	   => 0,
							'order_custom_payment.active'  	   => 1,
							'order_details.active' 		   	   => 1,
							'order_details.orderStatusId'  	   => 5,
							'employee.active' 		  	   	   => 1,
							'employee.isDelete'		  	   	   => 0,
							'order_shipping_vendor.active' 	   => 1,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_shipping_vendor.orderShippingVendorId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function available_vendor_user_order_list($shippingOrgId)
    {
		$this->db->select('finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->from('finance_vendor_clear_payment');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->where(array(
							'finance_vendor_initiate_payment.active' 		=> 1,
							'finance_vendor_clear_payment.active'    		=> 1,
							'finance_vendor_initiate_payment.shippingOrgId' 		=> $shippingOrgId,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderShippingVendorId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_shipping_vendor.orderShippingVendorId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   		 => 1,
							'order_total.isPickup'		   	   		 => 0,
							'order_custom_payment.active'  	   		 => 1,
							'order_details.active' 		   	   		 => 1,
							'order_details.orderStatusId'  	   		 => 5,
							'order_shipping_vendor.shippingOrgId'    => $shippingOrgId
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_shipping_vendor.orderShippingVendorId',$array);
		}
		
		return $this->db->get()->result();
	
		
		
	}
	
	public function add_initiate_payment($shippingOrgId,$addData)
	{
		$insertOpt = array(
						'shippingOrgId'		=> $shippingOrgId,
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
		$this->db->insert('finance_vendor_initiate_payment',$insertOpt);
        return $this->db->insert_id();
	}
	
	public function update_order_shipping_initiate_payment($where)
	{
		if(!empty($where))
		{
			$updateOpt = array(
							'processingStatus' => 1,
							'lastModifiedBy'   => $this->session->userdata('userId'),
							'lastModifiedDt'   => date('Y-m-d H:i:s'),
						);
			$this->db->where($where);
    		$this->db->update('order_shipping_vendor',$updateOpt);
	    	return $this->db->affected_rows();
		}
		else
		{
			return false;
		}
	}
	
	public function add_initiate_payment_order($insertBatchArr)
	{
		$this->db->insert_batch('finance_vendor_clear_payment',$insertBatchArr);
		return $this->db->insert_id();
	}
	
	public function processing_vendor_list()
    {
		$this->db->select('order_total.orderTotalId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,employee.firstName,employee.lastName,employee.email,employee.businessPhone,organization.organizationName,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName,finance_vendor_clear_payment.financeVendorIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('employee','order_shipping_vendor.shippingOrgId = employee.organizationId');
		$this->db->join('organization','employee.organizationId = organization.organizationId');
		$this->db->join('organization_address','employee.employeeId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	   => 1,
							'order_total.isPickup'		   	   => 0,
							'order_custom_payment.active'  	   => 1,
							'order_details.active' 		   	   => 1,
							'order_details.orderStatusId'  	   => 5,
							'employee.active' 		  	   	   => 1,
							'employee.isDelete'		  	   	   => 0,
							'order_shipping_vendor.active' 	   => 1,
							'finance_vendor_clear_payment.processingStatus' => 1,
							'finance_vendor_clear_payment.active'			=> 1
						));
		$this->db->order_by('organization.organizationName','ASC');
		return $this->db->get()->result();
	}
	
	public function proccessing_vendor_user_order_list($shippingOrgId)
    {
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_shipping_vendor.orderShippingVendorId,finance_vendor_clear_payment.financeVendorIniPayId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   		 => 1,
							'order_total.isPickup'		   	   		 => 0,
							'order_custom_payment.active'  	   		 => 1,
							'order_details.active' 		   	   		 => 1,
							'order_details.orderStatusId'  	   		 => 5,
							'order_shipping_vendor.paidStatus' 		 => 0,
							'order_shipping_vendor.shippingOrgId'    => $shippingOrgId,
							'order_shipping_vendor.processingStatus' => 1,
							'finance_vendor_clear_payment.processingStatus' => 1,
							'finance_vendor_clear_payment.active'			=> 1
						));
		return $this->db->get()->result();
	}
	
	public function proccessing_initiate_payment($shippingOrgId,$financeVendorIniPayId)
    {
		$this->db->select('finance_vendor_initiate_payment.clearAmount,finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->from('finance_vendor_initiate_payment');
		$this->db->join('finance_vendor_clear_payment','finance_vendor_initiate_payment.financeVendorIniPayId = finance_vendor_clear_payment.financeVendorIniPayId');
		$this->db->where(array(
							'finance_vendor_initiate_payment.shippingOrgId'    	 => $shippingOrgId,
							'finance_vendor_clear_payment.financeVendorIniPayId' => $financeVendorIniPayId,
							'finance_vendor_clear_payment.processingStatus' 	 => 1,
							'finance_vendor_clear_payment.active'				 => 1
						));
		return $this->db->get()->result();
	}
	
	public function add_reference_number($financeVendorIniPayId,$updateData)
	{
		$updateOpt = array(
						'referenceNumber' => $updateData['referenceNumber'],
						'lastModifiedBy'  => $this->session->userdata('userId'),
						'lastModifiedDt'  => date('Y-m-d H:i:s'),
					);
					
        $this->db->where('financeVendorIniPayId',$financeVendorIniPayId);
        $this->db->update('finance_vendor_initiate_payment',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function clear_payment_status($financeVendorIniPayId)
	{
		$updateOpt = array(
						'processingStatus' => 2,
						'paidStatus' => 1,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'lastModifiedDt'   => date('Y-m-d H:i:s'),
					);
					
        $this->db->where('financeVendorIniPayId',$financeVendorIniPayId);
        $this->db->update('finance_vendor_clear_payment',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function clear_payment_shipping_order_status($where)
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
    		$this->db->update('order_shipping_vendor',$updateOpt);
	    	return $this->db->affected_rows();
		}
		else
		{
			return false;
		}
	}
	
	public function paid_vendor_list()
    {
		$this->db->select('order_total.orderTotalId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,employee.firstName,employee.lastName,employee.email,employee.businessPhone,organization.organizationName,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->join('employee','order_shipping_vendor.shippingOrgId = employee.organizationId');
		$this->db->join('organization','employee.organizationId = organization.organizationId');
		$this->db->join('organization_address','employee.employeeId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	   => 1,
							'order_total.isPickup'		   	   => 0,
							'order_custom_payment.active'  	   => 1,
							'order_details.active' 		   	   => 1,
							'order_details.orderStatusId'  	   => 5,
							'employee.active' 		  	   	   => 1,
							'employee.isDelete'		  	   	   => 0,
							'order_shipping_vendor.active' 	   => 1,
							'finance_vendor_clear_payment.processingStatus' => 2,
							'finance_vendor_clear_payment.active' => 1,
						));
		$this->db->order_by('organization.organizationName','ASC');
		return $this->db->get()->result();
	}
	
	public function paid_vendor_user_order_list($shippingOrgId)
    {
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_shipping_vendor.orderShippingVendorId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   		 => 1,
							'order_total.isPickup'		   	   		 => 0,
							'order_custom_payment.active'  	   		 => 1,
							'order_details.active' 		   	   		 => 1,
							'order_details.orderStatusId'  	   		 => 5,
							'order_shipping_vendor.shippingOrgId'    => $shippingOrgId,
						));
		return $this->db->get()->result();
	}
	
	public function clear_payment_bank_list($shippingOrgId)
	{
		$this->db->select('financeVendorIniPayId,bankName,accountHolderName,accountNumber,referenceNumber,clearAmount,createDt,lastModifiedDt');
		$this->db->from('finance_vendor_initiate_payment');
		$this->db->where(array('shippingOrgId' => $shippingOrgId,'active' => 1));
		$this->db->order_by('financeVendorIniPayId','ASC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function proceesing_payment_bank_details($financeVendorIniPayId)
	{
		$this->db->select('financeVendorIniPayId,bankName,accountHolderName,accountNumber,referenceNumber,clearAmount,createDt,lastModifiedDt');
		$this->db->from('finance_vendor_initiate_payment');
		$this->db->where(array(
							'financeVendorIniPayId' => $financeVendorIniPayId,
							'active' 				=> 1,
							'referenceNumber'		=> ''
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function vendor_available_order_list($shippingOrgId)
    {
		$this->db->select('finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->from('finance_vendor_clear_payment');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->where(array(
							'finance_vendor_initiate_payment.active' 		=> 1,
							'finance_vendor_initiate_payment.shippingOrgId' => $shippingOrgId,
							'finance_vendor_clear_payment.active'    		=> 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderShippingVendorId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_shipping_vendor.orderShippingVendorId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   	  => 1,
							'order_total.isPickup'		   	   	  => 0,
							'order_custom_payment.active'  	   	  => 1,
							'order_details.active' 		   	   	  => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_shipping_vendor.shippingOrgId' => $shippingOrgId
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_shipping_vendor.orderShippingVendorId',$array);
		}
		return $this->db->get()->result();
	}
	
	public function vendor_processing_order_list($shippingOrgId)
    {
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_shipping_vendor.orderShippingVendorId');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   	  => 1,
							'order_total.isPickup'		   	   	  => 0,
							'order_custom_payment.active'  	   	  => 1,
							'order_details.active' 		   	   	  => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_shipping_vendor.shippingOrgId' => $shippingOrgId,
							'finance_vendor_clear_payment.active' => 1,
							'finance_vendor_clear_payment.processingStatus' => 1,
						));
		return $this->db->get()->result();
	}
	
	public function vendor_paid_order_list($shippingOrgId)
    {
		$this->db->select('order_total.orderTotalId,order_total.isEconomicDelivery,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,order_details.productId,product.code,order_details.quantity,order_details.orderStatusId,product_size.sizes,colors.colorCode,product_image.imageName,order_details.lastModifiedDt,order_shipping_vendor.orderShippingVendorId,finance_vendor_initiate_payment.referenceNumber,finance_vendor_initiate_payment.createDt AS initiateAmtDt,finance_vendor_initiate_payment.lastModifiedDt AS clearAmtDt');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   	  => 1,
							'order_total.isPickup'		   	   	  => 0,
							'order_custom_payment.active'  	   	  => 1,
							'order_details.active' 		   	   	  => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_shipping_vendor.shippingOrgId' => $shippingOrgId,
							'finance_vendor_clear_payment.active' => 1,
							'finance_vendor_clear_payment.processingStatus' => 2,
						));
		return $this->db->get()->result();
	}
	
	public function vendor_available_total_amount($shippingOrgId)
    {
		$this->db->select('finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->from('finance_vendor_clear_payment');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->where(array(
							'finance_vendor_initiate_payment.active' 		=> 1,
							'finance_vendor_initiate_payment.shippingOrgId' => $shippingOrgId,
							'finance_vendor_clear_payment.active'    		=> 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderShippingVendorId;
			}
		}
		
		$this->db->select('SUM(order_shipping_vendor.shippingAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   	  => 1,
							'order_total.isPickup'		   	   	  => 0,
							'order_custom_payment.active'  	   	  => 1,
							'order_details.active' 		   	   	  => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_shipping_vendor.shippingOrgId' => $shippingOrgId,
							'order_shipping_vendor.active'		  => 1
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_shipping_vendor.orderShippingVendorId',$array);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function vendor_processing_total_amount($shippingOrgId)
    {		
		$this->db->select('SUM(order_shipping_vendor.shippingAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   	  => 1,
							'order_total.isPickup'		   	   	  => 0,
							'order_custom_payment.active'  	   	  => 1,
							'order_details.active' 		   	   	  => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_shipping_vendor.shippingOrgId' => $shippingOrgId,
							'order_shipping_vendor.active'		  => 1,
							'finance_vendor_clear_payment.active' => 1,
							'finance_vendor_clear_payment.processingStatus' => 1,
						));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function vendor_paid_total_amount($shippingOrgId)
    {				
		$this->db->select('SUM(order_shipping_vendor.shippingAmount) AS total');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('finance_vendor_clear_payment','order_shipping_vendor.orderShippingVendorId = finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->join('product','order_details.productId = product.productId');
		$this->db->join('product_image','order_details.productImageId = product_image.productImageId');
		$this->db->join('colors','order_details.colorId = colors.colorId','left');
		$this->db->join('product_size','order_details.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'order_total.active'		   	   	  => 1,
							'order_total.isPickup'		   	   	  => 0,
							'order_custom_payment.active'  	   	  => 1,
							'order_details.active' 		   	   	  => 1,
							'order_details.orderStatusId'  	   	  => 5,
							'order_shipping_vendor.shippingOrgId' => $shippingOrgId,
							'finance_vendor_initiate_payment.shippingOrgId' => $shippingOrgId,
							'finance_vendor_clear_payment.active' => 1,
							'finance_vendor_clear_payment.processingStatus' => 2,
						));
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function available_vendor_list()
    {
		$this->db->select('finance_vendor_clear_payment.orderShippingVendorId');
		$this->db->from('finance_vendor_clear_payment');
		$this->db->join('finance_vendor_initiate_payment','finance_vendor_clear_payment.financeVendorIniPayId = finance_vendor_initiate_payment.financeVendorIniPayId');
		$this->db->where(array(
							'finance_vendor_initiate_payment.active' 		=> 1,
							'finance_vendor_clear_payment.active'    		=> 1,
						));
		$list = $this->db->get()->result();
		$array = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$array[] = $row->orderShippingVendorId;
			}
		}
		
		$this->db->select('order_total.orderTotalId,order_custom_payment.orderCustomPaymentId,order_custom_payment.customOrderId,order_custom_payment.totalCustomShippingAmount,order_shipping_vendor.shippingOrgId,order_shipping_vendor.shippingRateId,order_shipping_vendor.shippingAmount,employee.firstName,employee.lastName,employee.email,employee.businessPhone,organization.organizationName,address.addressLine1,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
		$this->db->from('order_total');
		$this->db->join('order_custom_payment','order_total.orderTotalId = order_custom_payment.orderTotalId');
		$this->db->join('order_details','order_custom_payment.orderCustomPaymentId = order_details.orderCustomPaymentId');
		$this->db->join('order_shipping_vendor','order_details.orderDetailId = order_shipping_vendor.orderDetailId');
		$this->db->join('employee','order_shipping_vendor.shippingOrgId = employee.organizationId');
		$this->db->join('organization','employee.organizationId = organization.organizationId');
		$this->db->join('organization_address','employee.employeeId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
	    $this->db->join('area', 'address.area = area.areaId','left');
    	$this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'order_total.active'		   	   => 1,
							'order_total.isPickup'		   	   => 0,
							'order_custom_payment.active'  	   => 1,
							'order_details.active' 		   	   => 1,
							'order_details.orderStatusId'  	   => 5,
							'employee.active' 		  	   	   => 1,
							'employee.isDelete'		  	   	   => 0,
							'order_shipping_vendor.active' 	   => 1,
						));
		if(!empty($array))
		{
			$this->db->where_not_in('order_shipping_vendor.orderShippingVendorId',$array);
		}
		
		$this->db->order_by('organization.organizationName','ASC');
		return $this->db->get()->result();
	}
}