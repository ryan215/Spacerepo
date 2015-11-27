<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_pointe_force_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function available_list()
	{
		$list = $this->CI->finance_pointe_porce_m->available_pointe_force_list();
		//echo "<pre>"; print_r($list); exit;
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->customerId]['customerId']  	 = $row->customerId;
				$result[$row->customerId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->customerId]['email'] 		 	 = $row->email;
				$result[$row->customerId]['phone'] 		 	 = $row->phone;
				$result[$row->customerId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->customerId]['cityName'] 	 	 = $row->cityName;
				$result[$row->customerId]['areaName'] 	 	 = $row->areaName;
				$result[$row->customerId]['stateName']	 	 = $row->stateName;
				$result[$row->customerId]['countryName']  	 = $row->countryName;
				
				if(!empty($result[$row->customerId]['customOrderId'][$row->customOrderId]))
				{}
				else
				{
					if(!empty($result[$row->customerId]['totalCustomPointeForceAmount']))
					{
						$result[$row->customerId]['totalCustomPointeForceAmount'] = $result[$row->customerId]['totalCustomPointeForceAmount']+$row->totalCustomPointeForceAmount;
					}
					else
					{
						$result[$row->customerId]['totalCustomPointeForceAmount'] = $row->totalCustomPointeForceAmount;
					}
					$result[$row->customerId]['customOrderId'][$row->customOrderId] = $row->customOrderId;
				}
			}
		}
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function balance_available_view($customerId)
	{
		$result 					 = array();
		$result['customerId'] 	 = $customerId;
		$result['phone']   	 = '';
		$result['name']  		     = '';
		$result['email']  		     = '';
		$result['addressLine1'] 	= '';
		$result['cityName'] 		= '';
		$result['areaName'] 		= '';
		$result['stateName']		= '';
		$result['totalAmount']  	= 0;
		$result['orderList']    	= array();
		
		$details = $this->CI->pointe_force_m->pointe_force_details($customerId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
				$result['phone']		   	 = $details->phone;
				$result['name']  		 	 = $details->firstName.' '.$details->lastName;
				$result['email']  		 	 = $details->email;
				$result['addressLine1'] 	 = $details->addressLine1;
				$result['cityName'] 	 	 = $details->cityName;
				$result['areaName'] 	 	 = $details->areaName;
				$result['stateName']	 	 = $details->stateName;
		}
		
		$ordersList = $this->CI->finance_pointe_porce_m->available_order_list($customerId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalCommissionPrice;
				$result['orderList'][$row->customOrderId]['totalPointeForceAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->customOrderId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->customOrderId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['totalCommissionPrice'] = $row->totalCommissionPrice;
			}
			krsort($result['orderList']);
		}
		//echo "<pre>"; print_r($result['orderList']); exit;
		return $result;
	}
	
	public function initiate_payment($customerId)
	{
		$result = array();
		$result['bankName'] 		 = '';
		$result['accountHolderName'] = '';
		$result['accountNumber']	 = '';
		$result['totalAmount']		 = 0;
		$result['orderCustomPaymentIdList'] = array();
		
		$ordersList = $this->CI->finance_pointe_porce_m->available_order_list($customerId);
		$this->CI->custom_log->write_log('custom_log','order list is '.print_r($ordersList,true));
		
		if(!empty($ordersList))
		{
			foreach($ordersList as $row)
			{
				$result['orderCustomPaymentIdList'][$row->orderPointeForceId]['orderCustomPaymentId'] = $row->orderCustomPaymentId;
				$result['orderCustomPaymentIdList'][$row->orderPointeForceId]['orderPointeForceId'] = $row->orderPointeForceId;
				$result['totalAmount'] = $result['totalAmount']+$row->totalCommissionPrice;
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
				$financePointefIniPayId = $this->CI->finance_pointe_porce_m->add_initiate_payment($customerId,$result);
				$this->CI->custom_log->write_log('custom_log','pointer force initiate payment id '.$financePointefIniPayId);
				
				if($financePointefIniPayId)
				{
					if(!empty($result['orderCustomPaymentIdList']))
					{
						$where = array();
						$insertBatch = array();
						foreach($result['orderCustomPaymentIdList'] as $customRow)
						{
							$where[] = '(orderPointeForceId = '.$customRow['orderPointeForceId'].' AND active = 1)';
							
							$insertBatch[] = array(
											 	'financePointefIniPayId' => $financePointefIniPayId,
												'orderPointeForceId' 	 => $customRow['orderPointeForceId'],
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
							//if($this->CI->finance_pointe_porce_m->update_order_initiate_payment($where))
							{
								if(!empty($insertBatch))
								{
									if($this->CI->finance_pointe_porce_m->add_initiate_payment_order($insertBatch))
									{
										$this->CI->session->set_flashdata('success','Information added successfully');
										$this->CI->custom_log->write_log('custom_log','Information added successfully');
										redirect(base_url().$this->CI->session->userdata('userType').'/finance_pointe_force_management/reference_number/'.id_encrypt($customerId).'/'.id_encrypt($financePointefIniPayId));
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
				redirect(base_url().$this->CI->session->userdata('userType').'/finance_pointe_force_management/initiate_payment/'.id_encrypt($customerId));
			}
		}
		return $result;
	}
	
	public function processing_list()
	{
		$list = $this->CI->finance_pointe_porce_m->processing_pointe_force_list();
	//	echo "<pre>"; print_r($list); exit;
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->customerId]['customerId']  	 = $row->customerId;
				$result[$row->customerId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->customerId]['email'] 		 	 = $row->email;
				$result[$row->customerId]['phone'] 		 	 = $row->phone;
				$result[$row->customerId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->customerId]['cityName'] 	 	 = $row->cityName;
				$result[$row->customerId]['areaName'] 	 	 = $row->areaName;
				$result[$row->customerId]['stateName']	 	 = $row->stateName;
				$result[$row->customerId]['countryName']  	 = $row->countryName;
				$result[$row->customerId]['financePointefIniPayId'] = $row->financePointefIniPayId;
				
				if(!empty($result[$row->customerId]['customOrderId'][$row->customOrderId]))
				{}
				else
				{
					if(!empty($result[$row->customerId]['totalCustomPointeForceAmount']))
					{
						$result[$row->customerId]['totalCustomPointeForceAmount'] = $result[$row->customerId]['totalCustomPointeForceAmount']+$row->totalCustomPointeForceAmount;
					}
					else
					{
						$result[$row->customerId]['totalCustomPointeForceAmount'] = $row->totalCustomPointeForceAmount;
					}
					$result[$row->customerId]['customOrderId'][$row->customOrderId] = $row->customOrderId;
				}
			}
		}
		return $result;
	}
	
	public function balance_processing_view($customerId)
	{
		$result 				= array();
		$result['customerId'] 	= $customerId;
		$result['phone']   	 	= '';
		$result['name']  		= '';
		$result['email']  		= '';
		$result['addressLine1'] = '';
		$result['cityName'] 	= '';
		$result['areaName'] 	= '';
		$result['stateName']	= '';
		$result['orderList']    		  = array();
		$result['financePointefIniPayId'] = '';
		$result['totalAmount']  		  = 0;
		$result['orderList']    	  	  = array();
		$result['bankName'] 			  = '';
		$result['accountHolderName'] 	  = '';
		$result['accountNumber']	 	  = '';
		
		$details = $this->CI->pointe_force_m->pointe_force_details($customerId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
				$result['phone']		   	 = $details->phone;
				$result['name']  		 	 = $details->firstName.' '.$details->lastName;
				$result['email']  		 	 = $details->email;
				$result['addressLine1'] 	 = $details->addressLine1;
				$result['cityName'] 	 	 = $details->cityName;
				$result['areaName'] 	 	 = $details->areaName;
				$result['stateName']	 	 = $details->stateName;
		}
		
		$ordersList = $this->CI->finance_pointe_porce_m->proccessing_order_list($customerId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalCommissionPrice;
				$result['orderList'][$row->customOrderId]['totalPointeForceAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->customOrderId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->customOrderId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['totalCommissionPrice'] = $row->totalCommissionPrice;
				$result['financePointefIniPayId'] = $row->financePointefIniPayId;
			}
			krsort($result['orderList']);
		}
		
		if($result['financePointefIniPayId'])
		{
			$proccessingBankDet = $this->CI->finance_pointe_porce_m->proceesing_payment_bank_details($result['financePointefIniPayId']);
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
	
	public function reference_number($customerId,$financePointefIniPayId)
	{
		$result = array();
		$result['referenceNumber'] = '';
		$result['orderCustomPaymentIdList'] = array();
		
		$processList = $this->CI->finance_pointe_porce_m->proccessing_initiate_payment($customerId,$financePointefIniPayId);
		$this->CI->custom_log->write_log('custom_log','process list is '.print_r($processList,true));
		if(empty($processList))
		{
			$this->CI->session->set_flashdata('error','Processing order not found');
			$this->CI->custom_log->write_log('custom_log','Processing order not found');
			redirect(base_url().$this->CI->session->userdata('userType').'/finance_pointe_force_management/processing_balance');
		}
		else
		{
			foreach($processList as $row)
			{
				$result['orderCustomPaymentIdList'][$row->orderPointeForceId]['orderPointeForceId'] = $row->orderPointeForceId;	
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
				if($this->CI->finance_pointe_porce_m->add_reference_number($financePointefIniPayId,$result))
				{
					$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
					$this->CI->session->set_flashdata('success','Reference Number added successfully');
					$this->CI->custom_log->write_log('custom_log','Reference Number added successfully');
					
					if($this->CI->finance_pointe_porce_m->clear_payment_status($financePointefIniPayId))
					{
						$where = array();
						foreach($result['orderCustomPaymentIdList'] as $customRow)
						{
							$where[] = '(orderPointeForceId = '.$customRow['orderPointeForceId'].' AND processingStatus = 1 AND active = 1)';
						}
						
						if(!empty($where))
						{
							/*$where = '('.implode(' OR ',$where).')';
							if($this->CI->finance_pointe_porce_m->clear_payment_pointe_force_order_status($where))
							{*/
								redirect(base_url().$this->CI->session->userdata('userType').'/finance_pointe_force_management/paid_balance');
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
				redirect(base_url().$this->CI->session->userdata('userType').'/finance_pointe_force_management/reference_number/'.id_encrypt($customerId).'/'.id_encrypt($financePointefIniPayId));
			}
		}
		return $result;
	}	
	
	public function paid_list()
	{
		$list = $this->CI->finance_pointe_porce_m->paid_pointe_force_list();
		$result = array();
		if(!empty($list))
		{
			foreach($list as $row)
			{
				$result[$row->customerId]['customerId']  	 = $row->customerId;
				$result[$row->customerId]['name']  		 	 = $row->firstName.' '.$row->lastName;
				$result[$row->customerId]['email'] 		 	 = $row->email;
				$result[$row->customerId]['phone'] 		 	 = $row->phone;
				$result[$row->customerId]['addressLine1'] 	 = $row->addressLine1;
				$result[$row->customerId]['cityName'] 	 	 = $row->cityName;
				$result[$row->customerId]['areaName'] 	 	 = $row->areaName;
				$result[$row->customerId]['stateName']	 	 = $row->stateName;
				$result[$row->customerId]['countryName']  	 = $row->countryName;
				
				if(!empty($result[$row->customerId]['customOrderId'][$row->customOrderId]))
				{}
				else
				{
					if(!empty($result[$row->customerId]['totalCustomPointeForceAmount']))
					{
						$result[$row->customerId]['totalCustomPointeForceAmount'] = $result[$row->customerId]['totalCustomPointeForceAmount']+$row->totalCustomPointeForceAmount;
					}
					else
					{
						$result[$row->customerId]['totalCustomPointeForceAmount'] = $row->totalCustomPointeForceAmount;
					}
					$result[$row->customerId]['customOrderId'][$row->customOrderId] = $row->customOrderId;
				}
			}
		}
		return $result;
	}
	
	public function balance_paid_view($customerId)
	{
		$result 				= array();
		$result['customerId'] 	= $customerId;
		$result['phone']   	 	= '';
		$result['name']  		= '';
		$result['email']  		= '';
		$result['addressLine1'] = '';
		$result['cityName'] 	= '';
		$result['areaName'] 	= '';
		$result['stateName']	= '';
		$result['orderList']    		  = array();
		$result['financePointefIniPayId'] = '';
		$result['totalAmount']  		  = 0;
		$result['orderList']    	  	  = array();
		$result['clearPayDetList']  = array();
		
		$details = $this->CI->pointe_force_m->pointe_force_details($customerId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
				$result['phone']		   	 = $details->phone;
				$result['name']  		 	 = $details->firstName.' '.$details->lastName;
				$result['email']  		 	 = $details->email;
				$result['addressLine1'] 	 = $details->addressLine1;
				$result['cityName'] 	 	 = $details->cityName;
				$result['areaName'] 	 	 = $details->areaName;
				$result['stateName']	 	 = $details->stateName;
		}
		
		$ordersList = $this->CI->finance_pointe_porce_m->paid_order_list($customerId);
		if(!empty($ordersList))
		{
			$sumTotalCommission = 0;
			foreach($ordersList as $row)
			{
				$sumTotalCommission = $sumTotalCommission+$row->totalCommissionPrice;
				$result['orderList'][$row->customOrderId]['totalPointeForceAmount'] = $sumTotalCommission;
				$result['totalAmount'] = $sumTotalCommission;
				
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['productId']     = $row->productId;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['productName']   = $row->code;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['quantity']      = $row->quantity;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['orderStatusId'] = $row->orderStatusId;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['colorCode'] = $row->colorCode;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['size'] = $row->sizes;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['imageName'] = $row->imageName;
				$result['orderList'][$row->customOrderId]['customOrderId'] = $row->customOrderId;
				$result['orderList'][$row->customOrderId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['orderList'][$row->customOrderId]['productList'][$row->productId]['totalCommissionPrice'] = $row->totalCommissionPrice;
			}
			krsort($result['orderList']);
		}
		
		$clearPayDetList = $this->CI->finance_pointe_porce_m->clear_payment_bank_list($customerId);
		if(!empty($clearPayDetList))
		{
			foreach($clearPayDetList as $row)
			{
				$result['clearPayDetList'][$row->financePointefIniPayId]['bankName'] = $row->bankName;
				$result['clearPayDetList'][$row->financePointefIniPayId]['accountHolderName'] = $row->accountHolderName;
				$result['clearPayDetList'][$row->financePointefIniPayId]['accountNumber'] = $row->accountNumber;
				$result['clearPayDetList'][$row->financePointefIniPayId]['referenceNumber'] = $row->referenceNumber;
				$result['clearPayDetList'][$row->financePointefIniPayId]['clearAmount'] = $row->clearAmount;
				$result['clearPayDetList'][$row->financePointefIniPayId]['lastModifiedDt'] = $row->lastModifiedDt;
				$result['clearPayDetList'][$row->financePointefIniPayId]['createDt'] = $row->createDt;
			}
		}
		
		return $result;
	}
}