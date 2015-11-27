<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_retailer_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function available_list()
	{
		$list = $this->CI->finance_retailer_m->available_retailer_list();
		//echo "<pre>"; print_r($list); exit;
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->organizationId]['organizationId']   = $row->organizationId;
				$result[$row->organizationId]['organizationName'] = $row->organizationName;
				$result[$row->organizationId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->organizationId]['email'] 		 	 = $row->email;
				$result[$row->organizationId]['phone'] 		 	 = $row->businessPhone;
				$result[$row->organizationId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->organizationId]['cityName'] 	 	 = $row->cityName;
				$result[$row->organizationId]['areaName'] 	 	 = $row->areaName;
				$result[$row->organizationId]['stateName']	 	 = $row->stateName;
				$result[$row->organizationId]['countryName']  	 = $row->countryName;
				
				$result[$row->organizationId]['totalLedgerRetailerAmount']    = $this->CI->finance_retailer_m->total_available_ledger_amount($row->organizationId);
				$result[$row->organizationId]['totalAvailableRetailerAmount'] = $this->CI->finance_retailer_m->total_available_amount($row->organizationId);
			}
		}
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function balance_available_view($organizationId)
	{
		$result 					= array();
		$result['organizationId'] 	= $organizationId;
		$result['phone']   	 		= '';
		$result['organizationName'] = '';
		$result['firstName']  		= '';
		$result['lastName']  		= '';
		$result['email']  		    = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['dropCenterName']	= '';
		$result['middle']			= '';
		$result['userName']			= '';
		$result['orderList']    	= array();
		
		$details = $this->CI->retailer_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
			$result['phone']		   	= $details->businessPhone;
			$result['organizationName'] = $details->organizationName;
			$result['firstName']  		= $details->firstName;
			$result['lastName']  		= $details->lastName;
			$result['middle']  		 	= $details->middle;
			$result['email']  		 	= $details->email;
			$result['addressLine1'] 	= $details->addressLine1;
			$result['cityName'] 	 	= $details->cityName;
			$result['areaName'] 	 	= $details->areaName;
			$result['stateName']	 	= $details->stateName;
			$result['dropCenterName']	= $details->dropCenterName;
			$result['userName']	 	 	= $details->userName;
		}
		
		$result['totalLedgerRetailerAmount']    = $this->CI->finance_retailer_m->total_available_ledger_amount($organizationId);
		$result['totalAvailableRetailerAmount'] = $this->CI->finance_retailer_m->total_available_amount($organizationId);
				
		$ordersList = $this->CI->finance_retailer_m->available_order_list($organizationId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function balance_available_ledger_view($organizationId)
	{
		$result 					= array();
		$result['organizationId'] 	= $organizationId;
		$result['phone']   	 		= '';
		$result['organizationName'] = '';
		$result['firstName']  		= '';
		$result['lastName']  		= '';
		$result['email']  		    = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['dropCenterName']	= '';
		$result['middle']			= '';
		$result['userName']			= '';
		$result['orderList']    	= array();
		
		$details = $this->CI->retailer_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
			$result['phone']		   	= $details->businessPhone;
			$result['organizationName'] = $details->organizationName;
			$result['firstName']  		= $details->firstName;
			$result['lastName']  		= $details->lastName;
			$result['middle']  		 	= $details->middle;
			$result['email']  		 	= $details->email;
			$result['addressLine1'] 	= $details->addressLine1;
			$result['cityName'] 	 	= $details->cityName;
			$result['areaName'] 	 	= $details->areaName;
			$result['stateName']	 	= $details->stateName;
			$result['dropCenterName']	= $details->dropCenterName;
			$result['userName']	 	 	= $details->userName;
		}
		
		$result['totalLedgerRetailerAmount']    = $this->CI->finance_retailer_m->total_available_ledger_amount($organizationId);
		$result['totalAvailableRetailerAmount'] = $this->CI->finance_retailer_m->total_available_amount($organizationId);
				
		//$ordersList = $this->CI->finance_retailer_m->available_ledger_order_list($organizationId);
		$ordersList = $this->CI->finance_retailer_m->retailer_ledger_order_list($organizationId);
		
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				
				if((!empty($result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount']))&&($result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount']))
				{
					$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount']+$row->totalRetailAmount;
				}
				else
				{
					$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $row->totalRetailAmount;
				}
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
				
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function initiate_payment($organizationId)
	{
		$result = array();
		$result['bankName'] 		 = '';
		$result['accountHolderName'] = '';
		$result['accountNumber']	 = '';
		$result['totalAmount']		 = 0;
		$result['orderCustomPaymentIdList'] = array();
		
		$ordersList = $this->CI->finance_retailer_m->available_order_list($organizationId);
		$this->CI->custom_log->write_log('custom_log','order list is '.print_r($ordersList,true));
		
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				$result['orderCustomPaymentIdList'][$row->orderDetailId]['orderCustomPaymentId'] = $row->orderCustomPaymentId;
				$result['orderCustomPaymentIdList'][$row->orderDetailId]['orderDetailId'] = $row->orderDetailId;
				$result['totalAmount'] = $result['totalAmount']+$row->totalRetailAmount;
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log','submit form is '.print_r($_POST,true));
			
			$result['bankName'] 		 = $this->CI->input->post('bankName');
			$result['accountHolderName'] = $this->CI->input->post('accountHolderName');
			$result['accountNumber']	 = $this->CI->input->post('accountNumber');
		
			$rules = initiate_payment_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$financeRetailerPayId = $this->CI->finance_retailer_m->add_initiate_payment($organizationId,$result);
				$this->CI->custom_log->write_log('custom_log','Retailer initiate payment id '.$financeRetailerPayId);
				
				if($financeRetailerPayId)
				{
					if(!empty($result['orderCustomPaymentIdList']))
					{
						$where = array();
						$insertBatch = array();
						foreach($result['orderCustomPaymentIdList'] as $customRow)
						{
							$where[] = '(orderCustomPaymentId = '.$customRow['orderCustomPaymentId'].' AND active = 1)';
							
							$insertBatch[] = array(
											 	'financeRetailerIniPayId' => $financeRetailerPayId,
												'orderDetailId' 		 => $customRow['orderDetailId'],
												'orderCustomPaymentId'   => $customRow['orderCustomPaymentId'],
												'processingStatus'		 => 1,
												'active'				 => 1,
												'createBy'				 => $this->CI->session->userdata('userId'),
												'createDt'				 => date('Y-m-d H:i:s'),
												'lastModifiedBy'  		 => $this->CI->session->userdata('userId'),
												'lastModifiedDt'   		 => date('Y-m-d H:i:s'),
											 );
						}
						
						if(!empty($where))
						{
							$where = '('.implode(' OR ',$where).')';
							//if($this->CI->finance_retailer_m->update_order_initiate_payment($where))
							{
								if(!empty($insertBatch))
								{
									if($this->CI->finance_retailer_m->add_initiate_payment_order($insertBatch))
									{
										$this->CI->session->set_flashdata('success','Information added successfully');
										$this->CI->custom_log->write_log('custom_log','Information added successfully');
										redirect(base_url().$this->CI->session->userdata('userType').'/finance_retailer_management/reference_number/'.id_encrypt($organizationId).'/'.id_encrypt($financeRetailerPayId));
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
				redirect(base_url().$this->CI->session->userdata('userType').'/finance_retailer_management/initiate_payment/'.id_encrypt($organizationId));
			}
		}
		return $result;
	}
	
	public function processing_list()
	{
		$list = $this->CI->finance_retailer_m->processing_retailer_list();
	//	echo "<pre>"; print_r($list); exit;
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->organizationId]['organizationId']   = $row->organizationId;
				$result[$row->organizationId]['organizationName'] = $row->organizationName;
				$result[$row->organizationId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->organizationId]['email'] 		 	 = $row->email;
				$result[$row->organizationId]['phone'] 		 	 = $row->businessPhone;
				$result[$row->organizationId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->organizationId]['cityName'] 	 	 = $row->cityName;
				$result[$row->organizationId]['areaName'] 	 	 = $row->areaName;
				$result[$row->organizationId]['stateName']	 	 = $row->stateName;
				$result[$row->organizationId]['countryName']  	 = $row->countryName;
				
				$result[$row->organizationId]['totalRetailerAmount'] = $this->CI->finance_retailer_m->total_processing_amount($row->organizationId);
				$result[$row->organizationId]['financeRetailerIniPayId'] = $row->financeRetailerIniPayId;				
			}
		}
		return $result;
	}
	
	public function balance_processing_view($organizationId)
	{
		$result 					= array();
		$result['organizationId'] 	= $organizationId;
		$result['phone']   	 		= '';
		$result['organizationName'] = '';
		$result['firstName']  		= '';
		$result['lastName']  		= '';
		$result['email']  		    = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['dropCenterName']	= '';
		$result['middle']			= '';
		$result['userName']			= '';
		$result['orderList']    	= array();
		$result['financeRetailerIniPayId'] = 0;
		
		$details = $this->CI->retailer_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
			$result['phone']		   	= $details->businessPhone;
			$result['organizationName'] = $details->organizationName;
			$result['firstName']  		= $details->firstName;
			$result['lastName']  		= $details->lastName;
			$result['middle']  		 	= $details->middle;
			$result['email']  		 	= $details->email;
			$result['addressLine1'] 	= $details->addressLine1;
			$result['cityName'] 	 	= $details->cityName;
			$result['areaName'] 	 	= $details->areaName;
			$result['stateName']	 	= $details->stateName;
			$result['dropCenterName']	= $details->dropCenterName;
			$result['userName']	 	 	= $details->userName;
		}
		
		$result['totalRetailerAmount'] = $this->CI->finance_retailer_m->total_processing_amount($organizationId);
		
		$ordersList = $this->CI->finance_retailer_m->proccessing_order_list($organizationId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$result['financeRetailerIniPayId'] = $row->financeRetailerIniPayId;
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
				
			}
			krsort($result['orderList']);
		}
		
		if($result['financeRetailerIniPayId'])
		{
			$proccessingBankDet = $this->CI->finance_retailer_m->proceesing_payment_bank_details($result['financeRetailerIniPayId']);
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
	
	public function reference_number($organizationId,$financeRetailerPayId)
	{
		$result = array();
		$result['referenceNumber'] = '';
		$result['orderCustomPaymentIdList'] = array();
		
		$processList = $this->CI->finance_retailer_m->proccessing_initiate_payment($organizationId,$financeRetailerPayId);
		$this->CI->custom_log->write_log('custom_log','process list is '.print_r($processList,true));
		//echo "<pre>"; print_r($processList); exit;
		if(empty($processList))
		{
			$this->CI->session->set_flashdata('error','Processing order not found');
			$this->CI->custom_log->write_log('custom_log','Processing order not found');
			redirect(base_url().$this->CI->session->userdata('userType').'/finance_retailer_management/processing_balance');
		}
		else
		{
			foreach($processList as $row)
			{
				$result['orderCustomPaymentIdList'][$row->orderCustomPaymentId]['orderCustomPaymentId'] = $row->orderCustomPaymentId;	
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
				if($this->CI->finance_retailer_m->add_reference_number($financeRetailerPayId,$result))
				{
					$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
					$this->CI->session->set_flashdata('success','Reference Number added successfully');
					$this->CI->custom_log->write_log('custom_log','Reference Number added successfully');
					
					if($this->CI->finance_retailer_m->clear_payment_status($financeRetailerPayId))
					{
						$where = array();
						foreach($result['orderCustomPaymentIdList'] as $customRow)
						{
							$where[] = '(orderCustomPaymentId = '.$customRow['orderCustomPaymentId'].' AND processingStatus = 1 AND active = 1)';
						}
						
						if(!empty($where))
						{
							/*$where = '('.implode(' OR ',$where).')';
							if($this->CI->finance_retailer_m->clear_payment_retailer_order_status($where))
							{*/
								redirect(base_url().$this->CI->session->userdata('userType').'/finance_retailer_management/paid_balance');
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
				redirect(base_url().$this->CI->session->userdata('userType').'/finance_retailer_management/reference_number/'.id_encrypt($organizationId).'/'.id_encrypt($financeRetailerPayId));
			}
		}
		return $result;
	}	
	
	public function paid_list()
	{
		$list = $this->CI->finance_retailer_m->paid_retailer_list();
		//echo "<pre>"; print_r($list); exit;
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->organizationId]['organizationId']   = $row->organizationId;
				$result[$row->organizationId]['organizationName'] = $row->organizationName;
				$result[$row->organizationId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->organizationId]['email'] 		 	 = $row->email;
				$result[$row->organizationId]['phone'] 		 	 = $row->businessPhone;
				$result[$row->organizationId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->organizationId]['cityName'] 	 	 = $row->cityName;
				$result[$row->organizationId]['areaName'] 	 	 = $row->areaName;
				$result[$row->organizationId]['stateName']	 	 = $row->stateName;
				$result[$row->organizationId]['countryName']  	 = $row->countryName;
				
				$result[$row->organizationId]['totalRetailerAmount'] = $this->CI->finance_retailer_m->total_paid_amount($row->organizationId);
				$result[$row->organizationId]['financeRetailerIniPayId'] = $row->financeRetailerIniPayId;				
			}
		}
		return $result;
	}
	
	public function balance_paid_view($organizationId)
	{
		$result 					= array();
		$result['organizationId'] 	= $organizationId;
		$result['phone']   	 		= '';
		$result['organizationName'] = '';
		$result['firstName']  		= '';
		$result['lastName']  		= '';
		$result['email']  		    = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['dropCenterName']	= '';
		$result['middle']			= '';
		$result['userName']			= '';
		$result['orderList']    	= array();
		$result['financeRetailerIniPayId'] = 0;
		$result['orderList']    	  	  = array();
		$result['clearPayDetList']  = array();
		
		$result['totalRetailerAmount'] = $this->CI->finance_retailer_m->total_paid_amount($organizationId);
		
		$details = $this->CI->retailer_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
			$result['phone']		   	= $details->businessPhone;
			$result['organizationName'] = $details->organizationName;
			$result['firstName']  		= $details->firstName;
			$result['lastName']  		= $details->lastName;
			$result['middle']  		 	= $details->middle;
			$result['email']  		 	= $details->email;
			$result['addressLine1'] 	= $details->addressLine1;
			$result['cityName'] 	 	= $details->cityName;
			$result['areaName'] 	 	= $details->areaName;
			$result['stateName']	 	= $details->stateName;
			$result['dropCenterName']	= $details->dropCenterName;
			$result['userName']	 	 	= $details->userName;
		}
		
		$ordersList = $this->CI->finance_retailer_m->paid_order_list($organizationId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$result['financeRetailerIniPayId'] = $row->financeRetailerIniPayId;
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
				
			}
			krsort($result['orderList']);
		}
		
		$clearPayDetList = $this->CI->finance_retailer_m->clear_payment_bank_list($organizationId);
		if(!empty($clearPayDetList))
		{
			foreach($clearPayDetList as $row)
			{
				$result['clearPayDetList'][$row->financeRetailerPayId]['bankName'] = $row->bankName;
				$result['clearPayDetList'][$row->financeRetailerPayId]['accountHolderName'] = $row->accountHolderName;
				$result['clearPayDetList'][$row->financeRetailerPayId]['accountNumber'] = $row->accountNumber;
				$result['clearPayDetList'][$row->financeRetailerPayId]['referenceNumber'] = $row->referenceNumber;
				$result['clearPayDetList'][$row->financeRetailerPayId]['clearAmount'] = $row->clearAmount;
				$result['clearPayDetList'][$row->financeRetailerPayId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['clearPayDetList'][$row->financeRetailerPayId]['createDt'] = $row->createDt;
			}
		}
		
		return $result;
	}
	
	public function retailer_balance_paid_view($organizationId)
	{
		$result 				  = array();
		$result['organizationId'] = $organizationId;
		$result['orderList']      = array();
		
		$ordersList = $this->CI->finance_retailer_m->retailer_paid_order_list($organizationId);
		//echo "<pre>"; print_r($ordersList); exit;
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['referenceNumber']     = $row->referenceNumber;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['clearAmtDt']     = $row->clearAmtDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['initiateAmtDt']     = $row->initiateAmtDt;
			}
			krsort($result['orderList']);
		}
		
		return $result;
	}
	
	public function retailer_ledger_balance_view($organizationId)
	{
		$result 				  = array();
		$result['organizationId'] = $organizationId;
		$result['orderList']      = array();
		
		$ordersList = $this->CI->finance_retailer_m->retailer_ledger_order_list($organizationId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId'] = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName'] = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity'] = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
				/*$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['referenceNumber'] = $row->referenceNumber;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['clearAmtDt']     = $row->clearAmtDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['initiateAmtDt']     = $row->initiateAmtDt;*/
			}
			krsort($result['orderList']);
		}
		return $result;
	
	}
	
	public function retailer_available_balance_view($organizationId)
	{
		$result 				  = array();
		$result['organizationId'] = $organizationId;
		$result['orderList']      = array();
		
		$ordersList = $this->CI->finance_retailer_m->retailer_available_order_list($organizationId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['totalRetailerAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productId'] = $row->productId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['productName'] = $row->code;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['quantity'] = $row->quantity;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->orderCustomPaymentId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->orderCustomPaymentId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['totalRetailAmount'] = $row->totalRetailAmount;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['orderStatusId']     = $row->orderStatusId;
				$result['orderList'][$row->orderCustomPaymentId]['productList'][$row->productId]['isPickup']     = $row->isPickup;
			}
			krsort($result['orderList']);
		}
		return $result;
	
	}
}