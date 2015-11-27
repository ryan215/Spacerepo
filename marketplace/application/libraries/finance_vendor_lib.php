<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_vendor_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function available_list()
	{
		$list = $this->CI->finance_vendor_m->available_vendor_list();
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->shippingOrgId]['shippingOrgId']  	 = $row->shippingOrgId;
				$result[$row->shippingOrgId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->shippingOrgId]['organizationName'] = $row->organizationName;
				$result[$row->shippingOrgId]['email'] 		 	 = $row->email;
				$result[$row->shippingOrgId]['phone'] 		 	 = $row->businessPhone;
				$result[$row->shippingOrgId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->shippingOrgId]['cityName'] 	 	 = $row->cityName;
				$result[$row->shippingOrgId]['areaName'] 	 	 = $row->areaName;
				$result[$row->shippingOrgId]['stateName']	 	 = $row->stateName;
				$result[$row->shippingOrgId]['countryName']  	 = $row->countryName;
				
				if(!empty($result[$row->shippingOrgId]['shippingAmt']))
				{
					$result[$row->shippingOrgId]['shippingAmt'] = $result[$row->shippingOrgId]['shippingAmt']+$row->shippingAmount;
				}
				else
				{
					$result[$row->shippingOrgId]['shippingAmt'] = $row->shippingAmount;
				}
			}
		}
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function vendor_user_details($shippingOrgId)
	{
		$result 					 = array();
		$result['shippingOrgId'] 	 = $shippingOrgId;
		$result['organizationName']  = '';
		$result['businessPhoneCode'] = '+234';
		$result['businessPhone']   	 = '';
		$result['name']  		     = '';
		$result['email']  		     = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['totalAmount']  	= 0;
		$result['orderList']    	= array();
		
		$details = $this->CI->shipping_m->shipping_vendor_user_details($shippingOrgId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
				$result['organizationName']  = $details->organizationName;
				$result['businessPhoneCode'] = $details->businessPhoneCode;
				$result['businessPhone']   	 = $details->businessPhone;
				$result['name']  		 	 = $details->firstName.' '.$details->lastName;
				$result['email']  		 	 = $details->email;
				$result['addressLine1'] 	 = $details->addressLine1;
				$result['cityName'] 	 	 = $details->cityName;
				$result['areaName'] 	 	 = $details->areaName;
				$result['stateName']	 	 = $details->stateName;
		}
		
		$ordersList = $this->CI->finance_vendor_m->available_vendor_user_order_list($shippingOrgId);
		//echo "<pre>"; print_r($ordersList); exit;
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->orderCustomPaymentId]['productList']))
					{
					}
					else
					{
						$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
						$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
					}
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
					$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function initiate_payment($shippingOrgId)
	{
		$result = array();
		$result['bankName'] 		 = '';
		$result['accountHolderName'] = '';
		$result['accountNumber']	 = '';
		$result['totalAmount']		 = 0;
		$result['orderCustomPaymentIdList'] = array();
		$sumTotalCommission = 0;
		$ordersList = $this->CI->finance_vendor_m->available_vendor_user_order_list($shippingOrgId);
		$this->CI->custom_log->write_log('custom_log','order list is '.print_r($ordersList,true));
		
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				$result['orderCustomPaymentIdList'][$row->orderShippingVendorId]['orderCustomPaymentId'] = $row->orderCustomPaymentId;
				$result['orderCustomPaymentIdList'][$row->orderShippingVendorId]['orderShippingVendorId'] = $row->orderShippingVendorId;
				
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->customOrderId]['productList']))
					{
					}
					else
					{
						$sumTotalCommission = $sumTotalCommission+$row->shippingAmount;
						$result['totalAmount'] = $sumTotalCommission;
					}
				}
				else
				{
					$sumTotalCommission = $sumTotalCommission+$row->shippingAmount;
					$result['totalAmount'] = $sumTotalCommission;						
				}
				$result['orderList'][$row->customOrderId]['productList'] = $row->customOrderId;
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','submit form is '.print_r($_POST,true));
			
			$result['bankName'] 		 = $this->CI->input->post('bankName');
			$result['accountHolderName'] = $this->CI->input->post('accountHolderName');
			$result['accountNumber']	 = $this->CI->input->post('accountNumber');
		
			$rules = initiate_payment_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$financeVendorIniPayId = $this->CI->finance_vendor_m->add_initiate_payment($shippingOrgId,$result);
				$this->CI->custom_log->write_log('custom_log','order vendor initiate payment id '.$financeVendorIniPayId);
				
				if($financeVendorIniPayId)
				{
					if(!empty($result['orderCustomPaymentIdList']))
					{
						$where = array();
						$insertBatch = array();
						foreach($result['orderCustomPaymentIdList'] as $customRow)
						{
							$where[] = '(orderShippingVendorId = '.$customRow['orderShippingVendorId'].' AND active = 1)';
							
							$insertBatch[] = array(
											 		'financeVendorIniPayId' => $financeVendorIniPayId,
													'orderShippingVendorId' => $customRow['orderShippingVendorId'],
													'orderCustomPaymentId'  => $customRow['orderCustomPaymentId'],
													'processingStatus'		=> 1,
													'active'				=> 1,
													'createBy'				=> $this->CI->session->userdata('userId'),
													'createDt'				=> date('Y-m-d H:i:s'),
													'lastModifiedBy'  		=> $this->CI->session->userdata('userId'),
													'lastModifiedDt'   		=> date('Y-m-d H:i:s'),
											 );
						}
						
						if(!empty($where))
						{
							$where = '('.implode(' OR ',$where).')';
							//if($this->CI->finance_vendor_m->update_order_shipping_initiate_payment($where))
							{
								if(!empty($insertBatch))
								{
									if($this->CI->finance_vendor_m->add_initiate_payment_order($insertBatch))
									{
										$this->CI->session->set_flashdata('success','Information added successfully');
										$this->CI->custom_log->write_log('custom_log','Information added successfully');
										redirect(base_url().$this->CI->session->userdata('userType').'/finance_vendor_management/reference_number/'.id_encrypt($shippingOrgId).'/'.id_encrypt($financeVendorIniPayId));
									}
									else
									{
										$this->CI->session->set_flashdata('error','Order not add in process');
										$this->CI->custom_log->write_log('custom_log','Order not add in process');
									}
								}
							}
							//else
							{/*
								$this->CI->session->set_flashdata('error','Order not send in process');
								$this->CI->custom_log->write_log('custom_log','Order not send in process');
							*/}
						}
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Initiated payment not add');
					$this->CI->custom_log->write_log('custom_log','Initiated payment not add');
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/finance_vendor_management/initiate_payment/'.id_encrypt($shippingOrgId));
			}
		}
		return $result;
	}
	
	public function processing_list()
	{
		$list = $this->CI->finance_vendor_m->processing_vendor_list();
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->shippingOrgId]['shippingOrgId']  	 = $row->shippingOrgId;
				$result[$row->shippingOrgId]['financeVendorIniPayId']  	 = $row->financeVendorIniPayId;
				$result[$row->shippingOrgId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->shippingOrgId]['organizationName'] = $row->organizationName;
				$result[$row->shippingOrgId]['email'] 		 	 = $row->email;
				$result[$row->shippingOrgId]['phone'] 		 	 = $row->businessPhone;
				$result[$row->shippingOrgId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->shippingOrgId]['cityName'] 	 	 = $row->cityName;
				$result[$row->shippingOrgId]['areaName'] 	 	 = $row->areaName;
				$result[$row->shippingOrgId]['stateName']	 	 = $row->stateName;
				$result[$row->shippingOrgId]['countryName']  	 = $row->countryName;
				
				if(!empty($result[$row->shippingOrgId]['shippingAmt']))
				{
					$result[$row->shippingOrgId]['shippingAmt'] = $result[$row->shippingOrgId]['shippingAmt']+$row->shippingAmount;
				}
				else
				{
					$result[$row->shippingOrgId]['shippingAmt'] = $row->shippingAmount;
				}
			}
		}
		return $result;
	}
	
	public function balance_processing_view($shippingOrgId)
	{
		$result 					 = array();
		$result['shippingOrgId'] 	 = $shippingOrgId;
		$result['financeVendorIniPayId'] 	 = 0;
		$result['organizationName']  = '';
		$result['businessPhoneCode'] = '+234';
		$result['businessPhone']   	 = '';
		$result['name']  		     = '';
		$result['email']  		     = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['totalAmount']  	= 0;
		$result['orderList']    	= array();
		$result['bankName'] 		= '';
		$result['accountHolderName'] = '';
		$result['accountNumber']	 = '';
		
		$details = $this->CI->shipping_m->shipping_vendor_user_details($shippingOrgId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
				$result['organizationName']  = $details->organizationName;
				$result['businessPhoneCode'] = $details->businessPhoneCode;
				$result['businessPhone']   	 = $details->businessPhone;
				$result['name']  		 	 = $details->firstName.' '.$details->lastName;
				$result['email']  		 	 = $details->email;
				$result['addressLine1'] 	 = $details->addressLine1;
				$result['cityName'] 	 	 = $details->cityName;
				$result['areaName'] 	 	 = $details->areaName;
				$result['stateName']	 	 = $details->stateName;
		}
		
		$ordersList = $this->CI->finance_vendor_m->proccessing_vendor_user_order_list($shippingOrgId);
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				$result['financeVendorIniPayId'] = $row->financeVendorIniPayId;
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->orderCustomPaymentId]['productList']))
					{
					}
					else
					{
						$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
						$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
						if((!empty($result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount']))&&($result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount']))
						{
							$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount']+$result['totalAmount'];
						}
						else
						{
							$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
						}
					}
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
					$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
					if((!empty($result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount']))&&($result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount']))
					{
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount']+$result['totalAmount'];
					}
					else
					{
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
					}
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['totalCustomShippingAmount'] = $row->totalCustomShippingAmount;
			}
			krsort($result['orderList']);
		}
		
		if($result['financeVendorIniPayId'])
		{
			$proccessingBankDet = $this->CI->finance_vendor_m->proceesing_payment_bank_details($result['financeVendorIniPayId']);
			if(!empty($proccessingBankDet))
			{
				$result['bankName'] 	  	 = $proccessingBankDet->bankName;
				$result['accountHolderName'] = $proccessingBankDet->accountHolderName;
				$result['accountNumber']	 = $proccessingBankDet->accountNumber;
			}
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function reference_number($shippingOrgId,$financeVendorIniPayId)
	{
		$result = array();
		$result['referenceNumber'] = '';
		$result['orderCustomPaymentIdList'] = array();
		
		$processList = $this->CI->finance_vendor_m->proccessing_initiate_payment($shippingOrgId,$financeVendorIniPayId);
		$this->CI->custom_log->write_log('custom_log','process list is '.print_r($processList,true));
		if(empty($processList))
		{
			$this->CI->session->set_flashdata('error','Processing order not found');
			$this->CI->custom_log->write_log('custom_log','Processing order not found');
			redirect(base_url().$this->CI->session->userdata('userType').'/finance_vendor_management/processing_balance');
		}
		else
		{
			foreach($processList as $row)
			{
				$result['orderCustomPaymentIdList'][$row->orderShippingVendorId]['orderShippingVendorId'] = $row->orderShippingVendorId;	
			}
		}
	//	echo "<pre>"; print_r($result); exit;
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','submit form is '.print_r($_POST,true));
			
			$result['referenceNumber'] = $this->CI->input->post('referenceNumber');
		
			$rules = reference_number_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($this->CI->finance_vendor_m->add_reference_number($financeVendorIniPayId,$result))
				{
					$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
					$this->CI->session->set_flashdata('success','Reference Number added successfully');
					$this->CI->custom_log->write_log('custom_log','Reference Number added successfully');
					
					if($this->CI->finance_vendor_m->clear_payment_status($financeVendorIniPayId))
					{
						$where = array();
						foreach($result['orderCustomPaymentIdList'] as $customRow)
						{
							$where[] = '(orderShippingVendorId = '.$customRow['orderShippingVendorId'].' AND processingStatus = 1 AND active = 1)';
						}
						
						if(!empty($where))
						{
							$where = '('.implode(' OR ',$where).')';
							/*if($this->CI->finance_vendor_m->clear_payment_shipping_order_status($where))
							{*/
								redirect(base_url().$this->CI->session->userdata('userType').'/finance_vendor_management/paid_balance');
							/*}
							else
							{
								$this->CI->session->set_flashdata('error','Payment clear but break in process');
								$this->CI->custom_log->write_log('custom_log','Payment clear but break in process');
							}*/
						}
					}					
					else
					{
						$this->CI->session->set_flashdata('error','Reference number add but payment not clear');
						$this->CI->custom_log->write_log('custom_log','Reference number add but payment not clear');
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Reference number not add');
					$this->CI->custom_log->write_log('custom_log','Reference number not add');
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/finance_vendor_management/reference_number/'.id_encrypt($shippingOrgId).'/'.id_encrypt($financeVendorIniPayId));
			}
		}
		return $result;
	}	
	
	public function paid_list()
	{
		$list = $this->CI->finance_vendor_m->paid_vendor_list();
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->shippingOrgId]['shippingOrgId']  	 = $row->shippingOrgId;
				$result[$row->shippingOrgId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->shippingOrgId]['organizationName'] = $row->organizationName;
				$result[$row->shippingOrgId]['email'] 		 	 = $row->email;
				$result[$row->shippingOrgId]['phone'] 		 	 = $row->businessPhone;
				$result[$row->shippingOrgId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->shippingOrgId]['cityName'] 	 	 = $row->cityName;
				$result[$row->shippingOrgId]['areaName'] 	 	 = $row->areaName;
				$result[$row->shippingOrgId]['stateName']	 	 = $row->stateName;
				$result[$row->shippingOrgId]['countryName']  	 = $row->countryName;
				
				if(!empty($result[$row->shippingOrgId]['shippingAmt']))
				{
					$result[$row->shippingOrgId]['shippingAmt'] = $result[$row->shippingOrgId]['shippingAmt']+$row->shippingAmount;
				}
				else
				{
					$result[$row->shippingOrgId]['shippingAmt'] = $row->shippingAmount;
				}
			}
		}
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function balance_paid_view($shippingOrgId)
	{
		$result 					 = array();
		$result['shippingOrgId'] 	 = $shippingOrgId;
		$result['organizationName']  = '';
		$result['businessPhoneCode'] = '+234';
		$result['businessPhone']   	 = '';
		$result['name']  		     = '';
		$result['email']  		     = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['totalAmount']  	= 0;
		$result['orderList']    	= array();
		$result['clearPayDetList']  = array();
		
		$details = $this->CI->shipping_m->shipping_vendor_user_details($shippingOrgId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
				$result['organizationName']  = $details->organizationName;
				$result['businessPhoneCode'] = $details->businessPhoneCode;
				$result['businessPhone']   	 = $details->businessPhone;
				$result['name']  		 	 = $details->firstName.' '.$details->lastName;
				$result['email']  		 	 = $details->email;
				$result['addressLine1'] 	 = $details->addressLine1;
				$result['cityName'] 	 	 = $details->cityName;
				$result['areaName'] 	 	 = $details->areaName;
				$result['stateName']	 	 = $details->stateName;
		}
		
		$sumTotalCommission = 0;
		$ordersList = $this->CI->finance_vendor_m->paid_vendor_user_order_list($shippingOrgId);
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->orderCustomPaymentId]['productList']))
					{
					}
					else
					{
						$sumTotalCommission = $sumTotalCommission+$row->shippingAmount;
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $sumTotalCommission;
						$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
					}
				}
				else
				{
					$sumTotalCommission = $sumTotalCommission+$row->shippingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $sumTotalCommission;
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
			}
			krsort($result['orderList']);
		}
		
		$clearPayDetList = $this->CI->finance_vendor_m->clear_payment_bank_list($shippingOrgId);
		if(!empty($clearPayDetList))
		{
			$result['totalAmount'] = 0;
			foreach($clearPayDetList as $row)
			{
				$result['clearPayDetList'][$row->financeVendorIniPayId]['bankName'] = $row->bankName;
				$result['clearPayDetList'][$row->financeVendorIniPayId]['accountHolderName'] = $row->accountHolderName;
				$result['clearPayDetList'][$row->financeVendorIniPayId]['accountNumber'] = $row->accountNumber;
				$result['clearPayDetList'][$row->financeVendorIniPayId]['referenceNumber'] = $row->referenceNumber;
				$result['clearPayDetList'][$row->financeVendorIniPayId]['clearAmount'] = $row->clearAmount;
				$result['clearPayDetList'][$row->financeVendorIniPayId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['clearPayDetList'][$row->financeVendorIniPayId]['createDt'] = $row->createDt;
				$result['totalAmount'] = $result['totalAmount']+$row->clearAmount;
			}
		}
		return $result;
	}
	
	public function vendor_available_balance_view($shippingOrgId)
	{
		$result 				 = array();
		$result['shippingOrgId'] = $shippingOrgId;
		$result['orderList']     = array();
		$result['totalAmount']   = 0;
		$ordersList = $this->CI->finance_vendor_m->vendor_available_order_list($shippingOrgId);
		
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->orderCustomPaymentId]['productList']))
					{
					}
					else
					{
						$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
						$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
					}
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
					$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function vendor_processing_balance_view($shippingOrgId)
	{
		$result 				 = array();
		$result['shippingOrgId'] = $shippingOrgId;
		$result['orderList']     = array();
		$result['totalAmount']   = 0;
		$ordersList = $this->CI->finance_vendor_m->vendor_processing_order_list($shippingOrgId);
		
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->orderCustomPaymentId]['productList']))
					{
					}
					else
					{
						$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
						$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
					}
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
					$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function vendor_paid_balance_view($shippingOrgId)
	{
		$result 				 = array();
		$result['shippingOrgId'] = $shippingOrgId;
		$result['orderList']     = array();
		$result['totalAmount']   = 0;
		$ordersList = $this->CI->finance_vendor_m->vendor_paid_order_list($shippingOrgId);
		
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				if($row->isEconomicDelivery)
				{
					if(!empty($result['orderList'][$row->orderCustomPaymentId]['productList']))
					{
					}
					else
					{
						$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
						$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
						$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
					}
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['shippingAmount'] = $row->shippingAmount;
					$result['totalAmount'] = $result['totalAmount']+$row->shippingAmount;
					$result['orderList'][$row->orderCustomPaymentId]['totalShippingAmount'] = $result['totalAmount'];
				}
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['referenceNumber'] = $row->referenceNumber;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['referenceNumber'] = $row->referenceNumber;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['initiateAmtDt'] = $row->initiateAmtDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['clearAmtDt'] = $row->clearAmtDt;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
}