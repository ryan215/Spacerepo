<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pointepay_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session','upload'));
		$this->CI->load->helper(array('url','form','cookie'));
		$this->CI->load->model(array('location_m','pointepay_m'));
	}
	public function pointepay_retailer_sign_up($businessPhone)
	{
		
	
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']	 	   = ''; 
		$return['organizationTypeId']  = 1; 
		$return['associationType']	   = 1;
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = '';
		$return['userName']      	   = '';
		$return['email']  		 	   = ''; 
		$return['password']      	   = ''; 
		$return['businessName']  	   = ''; 
		$return['countryCode']   	   = '+234'; 
		$return['businessPhone'] 	   = ''; 		
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['areaId']  		 	   = '';
		$return['cityId']  		 	   = ''; 
		$return['street']  		 	   = ''; 
		$return['confPassword'] 	   = ''; 
		$return['acceptTermCondition'] = ''; 
		$return['dropshipCentre']      = 0; 
		$return['isPointeMart'] 	   = 0;
		$return['isPointePay'] 		   = 2;
		$return['dropshipCentreList']  = $this->CI->retailer_m->dropship_center_list();
		
		
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log','Form submit array is '.print_r($_POST,true));
			if(!empty($_POST['dropshipCentre']))
			{
				$return['dropshipCentre'] = $this->CI->input->post('dropshipCentre');
			}
			
			$return['associationType']     = $this->CI->input->post('associationType');
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['middleName'] 		   = $this->CI->input->post('middleName'); 
			$return['lastName']  	 	   = $this->CI->input->post('lastName');
			$return['email']  		 	   = $this->CI->input->post('email'); 
			$return['businessName']  	   = $this->CI->input->post('businessName'); 
			//$return['countryCode']   	   = trim($this->CI->input->post('countryCode'));
			$return['businessPhone'] 	   = $businessPhone; 		
			$return['stateId']  	 	   = $this->CI->input->post('stateId'); 
			$return['areaId']  		 	   = $this->CI->input->post('areaId'); 
			$return['cityId']  		 	   = $this->CI->input->post('cityId'); 
			$return['street']  		 	   = $this->CI->input->post('street'); 
			$return['OTP']  		 	   = otp5_digit(); 
			if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
			{
				$return['password'] = $return['OTP'];
				$return['userName'] = $return['businessPhone'];
				$message = 'Your Temporary Username is '.$return['userName'].' AND Temporary Password is '.$return['password'];
			}
			else
			{
				$return['userName']      	   = $this->CI->input->post('userName');
				$return['password']      	   = $this->CI->input->post('password');
				$return['confPassword']  	   = $this->CI->input->post('confPassword');
				$return['acceptTermCondition'] = $this->CI->input->post('accept'); 
				$message = 'Your OTP is '.$return['OTP'];
			}
			
			$rules =pointepay_retailer_sign_up();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				
				$return['isPointeMart'] = 1;
				$return['isPointePay']  = 2;
					
				$organizationId = $this->CI->user_m->add_retailer_organization($return);
				$this->CI->custom_log->write_log('custom_log','Organization id is '.$organizationId);
				
				if($organizationId)
				{
					$employeeId = $this->CI->user_m->add_retailer_employee($organizationId,$return);
					$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					
					if($employeeId)
					{
						$addressId = $this->CI->user_m->add_retailer_address($return);
						$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->CI->user_m->add_retailer_organization_address($organizationId,$addressId);
							$roleID = $this->CI->user_m->add_retailer_employee_role($employeeId,$organizationId);
							$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								if($this->CI->session->userdata('userType')=='cse')
								{
									
									$this->CI->user_m->add_retailer_for_cse($organizationId,$this->CI->session->userdata('userId'));
								}
								
								$url = base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId);
								if($return['email'])
								{
									if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
									{
										$mailData = array(
													'email'         => $return['email'],
													'cc'	        => '',
													'slug'          => 'retailer_sign_up_from_backend',
													'businessName'  => $return['businessName'],
													'username'		=> $return['userName'],
													'password'		=> $return['password'],
													//'verifyUrl'     => base_url().'retailer',
													'verifyUrl'     => $this->CI->config->item('retailer_url'),
													'subject'       => 'Retailer Sign up Successfully',
												);										
									}
									else
									{
										$mailData = array(
													'email'         => $return['email'],
													'cc'	        => '',
													'slug'          => 'retailer_sign_up',
													'businessName'  => $return['businessName'],
													'otp'			=> '<b>'.$return['OTP'].'<b>',
													'verifyUrl'     => $url,
													'subject'       => 'Retailer Sign up Successfully',
												);	
									}
									
									if($this->CI->email_m->send_mail($mailData))
									{
										$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_retailer'));
										$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
									}
									else
									{
										$this->CI->session->set_flashdata('error','Retailer create successfully but '.$this->CI->lang->line('error_mail_not_send'));
										$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
									}																				
								}
								
 								$response = $this->CI->twillo_m->send_mobile_message(trim($return['countryCode']).trim($return['businessPhone']),$message);
								$this->CI->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
								if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
								{
									if($return['email'])
									{
										$this->CI->session->set_flashdata('success','An Email & Text message has been sent with the temporary username and password to the registered retailer.');
									}
									else
									{
										$this->CI->session->set_flashdata('success','A text message has been sent with temporary username and password to the registered retailer.');
									}
								}
								else
								{
									if($return['email'])
									{
										$this->CI->session->set_flashdata('success','An Email & Text message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
									}
									else
									{
										$this->CI->session->set_flashdata('success','A text message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
									}
								}								
								$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_reatiler_sign_up'));
							}
							if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
							{
								redirect(base_url().$userType.'/pointepay_management/retailerList');
							}
							else
							{
								redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId));
							}
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_retailer_address'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_retailer_address'));
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_retailer_employee'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_retailer_employee'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_retailer_organization'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_retailer_organization'));
				}
				
				if(($userType=='superadmin')||($userType=='admin')||(($userType=='cse')))
				{
					redirect(base_url().$userType.'/pointepay_management/retailerList');
				}
				else
				{
					redirect(base_url().'retailer/home/sign_up');
				}
			}
else{
	// echo validation_errors(); 
}			
		}
		
		
		//$return['stateList'] = $this->CI->location_m->nigeria_state_list();
		$return['organizationTypeList'] = $this->CI->user_m->organization_type_list();
		//echo "<pre>"; print_r($return); exit;
		return $return;
	}
	public function update_pointepay_retailer($userDetailArr)
	{
		if(!empty($userDetailArr['addressId'])){
		$this->CI->user_m->update_retailer_address($userDetailArr['addressId'],$userDetailArr);	
		}
		
		$this->CI->user_m->update_retailer_employee($userDetailArr['employeeId'],$userDetailArr);
		$this->CI->user_m->update_to_pointepay_retailer_organization($userDetailArr['organizationId']);
		
	}
	public function retailer_edit($organizationId)
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']	 	   = ''; 
		$return['organizationTypeId']  = 1; 
		$return['associationType']	   = 1;
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = '';
		$return['userName']      	   = '';
		$return['email']  		 	   = ''; 
		$return['businessName']  	   = ''; 
		$return['countryCode']   	   = '+234'; 
		$return['businessPhone'] 	   = ''; 		
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['areaId']  		 	   = ''; 
		$return['cityId']  		 	   = ''; 
		$return['street']  		 	   = ''; 
		$return['isPointePay']  	   = 2;
		$return['isPointeMart'] 	   = 1;
		$return['employeeId'] 	   = 0;
		$return['dropshipCentre']	   = 0;
		$employeeId     = '';
		$addressId      = '';
		$users_details  = $this->CI->user_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$return['imageName'] 	 	  = $users_details->imageName;
			$return['businessName']  	  = $users_details->organizationName;
			$return['businessPhone'] 	  = $users_details->businessPhone;
			$return['street']    	 	  = $users_details->addressLine1;
			$return['firstName']     	  = $users_details->firstName;
			$return['middleName']    	  = $users_details->middle;
			$return['lastName']      	  = $users_details->lastName;
			$return['organizationType']   = $users_details->organizationType;
			//$return['countryId']   	      = $users_details->country;
			$return['stateId']     	      = $users_details->state;
			$return['areaId']      		  = $users_details->area;
			$return['cityId']      		  = $users_details->city;
			$return['organizationTypeId'] = $users_details->organizationTypeId;	
			//$return['isPointePay'] 	      = $users_details->isPointePay;
			//$return['isPointeMart'] 	  = $users_details->isPointeMart;
			$return['email']			  = $users_details->email;
			$return['countryCode']		  = $users_details->businessPhoneCode;
			$return['dropshipCentre']	   = $this->CI->input->post('dropshipCentre');
			
			$employeeId = $users_details->employeeId;
			$addressId 		= $users_details->addressId;
			$return['employeeId'] = $employeeId;
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['formSubmit']  		   = 0;
			//$return['associationType']	   = $this->CI->input->post('associationType');
			//$return['organizationTypeId']  = $this->CI->input->post('organizationTypeId');
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['lastName']  	 	   = $this->CI->input->post('lastName'); 
			$return['middleName']  	 	   = $this->CI->input->post('middleName'); 
		//	$return['countryId']  	 	   = $this->CI->input->post('countryId');
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  		 	   = $this->CI->input->post('areaId');
			$return['cityId']  		 	   = $this->CI->input->post('cityId');
			$return['street']  		 	   = $this->CI->input->post('street');
			$return['businessName']  	   = $this->CI->input->post('businessName');
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone');
			$return['imageName']		   = $this->CI->input->post('imageName'); 
			$return['email']			   = $this->CI->input->post('email'); 
			//$return['countryCode']   	   = $this->CI->input->post('countryCode'); 
			$return['isPointePay']  	   = 2;
			$return['isPointeMart']        = 1;
			$return['dropshipCentre']	   = $this->CI->input->post('dropshipCentre');
			/*if($return['associationType']==1)
			{
				$return['isPointePay']  = 0;
				$return['isPointeMart'] = 1;
			}
			elseif($return['associationType']==2)
			{
				$return['isPointeMart'] = 0;
				$return['isPointePay']  = 1;
			}
			elseif($return['associationType']==3)
			{
				$return['isPointePay']  = 1;
				$return['isPointeMart'] = 1;
			}*/
			
			
			$rules = pointepay_update_retailer_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($this->CI->user_m->update_retailer_organization($organizationId,$return))
				{
					if($this->CI->user_m->update_retailer_employee($employeeId,$return))
					{
						if($addressId)
						{
							if($this->CI->user_m->update_retailer_address($addressId,$return))
							{
								$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_retailer_user'));
							}
							else
							{
								$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_retailer_address'));
							}
						}
						else
						{
							$addressId = $this->CI->user_m->add_retailer_address($return);
							if($addressId)
							{
								$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
								$this->CI->user_m->add_retailer_organization_address($organizationId,$addressId);
							}
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_retailer_employee'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_retailer_organization'));
				}
				
				
					redirect(base_url().$this->CI->session->userdata('userType').'/pointepay_management/user_detail/'.id_encrypt($organizationId));
				
			}	
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();	
		$return['organizationTypeList'] = $this->CI->user_m->organization_type_list();
		//$return['dropshipCentreList']  = $this->CI->retailer_m->dropship_center_list();
		return $return;
	}
	public function retailer_userDetails($organizationId)
	{
		$result = array();
		$result['imageName']     = '';
		$result['businessName']  = '';
		$result['businessPhone'] = '';
		$result['email']         = '';
		$result['street'] 	     = '';
		$result['countryName']   = '';
		$result['stateName']     = '';
		$result['areaName']	     = '';
		$result['cityName']	     = '';
		$result['cseName']	     = '';
		$result['firstName']     = '';
		$result['middleName']    = '';
		$result['lastName']      = '';
		$result['blockUnblock']  = 0;
		$result['organizationType'] = '';
		$result['pointepaySubscriptionId'] = '';
		$result['isPointeMart']     = 0;
		$result['isPointePay']      = 0;
		$result['userName']         = '';
		$result['organizationId']   = 0;
		$result['employeeId']   = 0;
		$result['dropshipCentre'] = '';
		$result['requestStatus']  = '';
		$result['active']         = 0;
		
		$users_details = $this->CI->pointepay_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{			
			$cseDetails = $this->CI->user_m->cse_details_of_retailer($organizationId);
			if(!empty($cseDetails))
			{
				$result['cseName'] = $cseDetails->firstName.' '.$cseDetails->middle.' '.$cseDetails->lastName;
			}
			$result['requestStatus']    = $users_details->requestStatus;
			$result['imageName'] 	    = $users_details->imageName;
			$result['businessName']     = $users_details->organizationName;
			$result['businessPhone']    = $users_details->businessPhone;
			$result['email'] 	        = $users_details->email;
			$result['street']    	    = $users_details->addressLine1;
			$result['countryName'] 	    = $users_details->countryName;
			$result['stateName']   	    = $users_details->stateName;
			$result['areaName']    	    = $users_details->areaName;
			$result['cityName']    	    = $users_details->cityName;
			$result['firstName']        = $users_details->firstName;
			$result['middleName']       = $users_details->middle;
			$result['lastName']         = $users_details->lastName;
			$result['blockUnblock']     = $users_details->active;
			$result['organizationType'] = $users_details->organizationType;
			$result['isPointeMart']     = $users_details->isPointeMart;
			$result['isPointePay']      = $users_details->isPointePay;
			$result['userName']         = $users_details->userName;
			$result['organizationId']   = $users_details->organizationId;
			$result['employeeId']   = $users_details->employeeId;
			$result['pointepaySubscriptionId'] =$users_details->pointepaySubscriptionId; 
			$result['dropshipCentre'] = $users_details->dropshipCentre;
			$result['active']           = $users_details->active;
		}
	//	echo "<pre>"; print_r($cseDetails); exit;
		return $result;
	}
	
}