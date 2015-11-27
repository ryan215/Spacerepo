<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class Auth extends REST_Controller
{
	public function __construct() 
	{
	  parent::__construct ();
		$this->apiresponse['time']=time();
		// load  twilio model for sending message
		$this->load->model('twillo_m');
		$this->load->model('user_m');
			$this->load->model('auth_m');
		$this->load->helper('api_validation');
		$language= $this->config->item('supported_languages');
		
	  if (is_array($this->response->lang))
		{
			$languageToSet=$language[$this->response->lang[0]];
			$this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
			$this->lang->load('error', $languageToSet);
			$this->lang->load('success', $languageToSet);

		}
		else
		{
			$languageToSet=$language[$this->response->lang];
			$this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
			$this->lang->load('error',$languageToSet);
			$this->lang->load('success', $languageToSet);
		
		}
	}
	
	public function checkUserDetail_post()
	{
		$rules=check_userdetail();
		$this->form_validation->set_rules($rules);
		$this->custom_log->write_log('custom_log','check_user_detail_post'.print_r($_POST,true));
		if($this->form_validation->run())
		{
			$this->apiresponse['success']=1;
				
           $this->apiresponse['response'] =array(
               'message' =>'' ,
			    
           );

           $this->response($this->apiresponse,200);
		}
		else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
		
	}
	public function checkUserName_post()
	{
		$rules=check_username();
		$this->form_validation->set_rules($rules);
		$this->custom_log->write_log('custom_log','check_user_name_post'.print_r($_POST,true));
		if($this->form_validation->run())
		{
			$this->apiresponse['success']=1;
				
           $this->apiresponse['response'] =array(
               'message' =>'' ,
			    
           );

           $this->response($this->apiresponse,200);
		}
		else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
		
	}
	public function signUp_post()
		{
			$rules=api_signup_rules();
			$this->form_validation->set_rules($rules);
			$this->custom_log->write_log('custom_log','signup'.print_r($_POST,true));
				if($this->form_validation->run())
				{
					$return['imageName']	 	   =  ''; 
					$return['organizationTypeId']  =  1; 
					$return['associationType']	   =  1;
					$return['firstName'] 	 	   =  $this->post('firstName');
					$return['middleName'] 		   =  $this->post('middleName'); 
					$return['lastName']  	 	   =  $this->post('lastName');
					$return['userName']      	   =  $this->post('userName');
					$return['email']  		 	   =  $this->post('email'); 
					$return['password']      	   =  $this->post('password'); 
					$return['businessName']  	   =  $this->post('organizationName'); 
					$return['countryCode']   	   =  $this->post('businessPhoneCode');
					$return['businessPhone'] 	   =  $this->post('businessPhone'); 		
					$return['countryId']     	   = 154; 
					$return['stateId']  	 	   =  $this->post('state'); 
					$return['areaId']				= $this->post('area');
					$return['cityId']  		 	   =  $this->post('city');
					$return['street']  		 	   =  $this->post('addressLine1'); 
					$return['dropshipCentre']      = 0;
					$return['passwordStatus']      = 1; 
					$return['isPointeMart'] 	   =$this->post('isPointeMart');
					$return['isPointePay'] 		   = $this->post('isPointeMart');  
					$return['OTP']  		 	   = otp5_digit();
					
					$organizationId=$this->user_m->add_retailer_organization($return);
					
					if($organizationId)
				{
					$employeeId = $this->user_m->add_retailer_employee_pointepay($organizationId,$return);
					$this->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					
					if($employeeId)
					{
						$addressId = $this->user_m->add_retailer_address($return);
						$this->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->user_m->add_retailer_organization_address($organizationId,$addressId);
							$roleID = $this->user_m->add_retailer_employee_role($employeeId,$organizationId);
							$this->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								$url = base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId);
								if($return['email'])
								{
									$mailData = array(
													'email'    => $return['email'],
													'cc'	   => '',
													'slug'     => 'retailer_sign_up',
													'businessName'     => $return['businessName'],
													'otp'			=> '<b>'.$return['OTP'].'<b>',
													'verifyUrl'      => $url,
													'subject'  => 'Retailer Sign up Successfully',
												);										
									if($this->email_m->send_mail($mailData))
									{
										$this->session->set_flashdata('success',$this->lang->line('success_add_retailer'));
										$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
									}
									else
									{
										$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
										$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
									}																				
								}
								//$message = 'Your OTP is "'.$return['OTP'].'"
								$message = 'Hi '.$return['businessName'].',OTP to verify your detail is '.$return['OTP'].'';
 								$response = $this->twillo_m->send_mobile_message(trim($return['countryCode']).trim($return['businessPhone']),$message);
								$this->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
								
								
								$this->custom_log->write_log('custom_log',$this->lang->line('success_reatiler_sign_up'));
							}
							$userdetailresult=$this->user_m->retailer_check_email_phone($return['userName'] );
							$this->apiresponse['success']=1;
						
				   $this->apiresponse['response'] =array(
					   'message' =>'successfully registerd retailer' ,
					   'data'	=>	$userdetailresult
						
				   );

				   $this->response($this->apiresponse,200);
						}
						else
						{
							$this->apiresponse['success']=0;
						
				   $this->apiresponse['response'] =array(
					   'message' =>$this->lang->line('error_add_retailer_employee') ,
						
				   );

				   $this->response($this->apiresponse,200);
						}
					}
					else
					{
						$this->apiresponse['success']=0;
						
				   $this->apiresponse['response'] =array(
					   'message' =>$this->lang->line('error_add_retailer_employee') ,
						
				   );

				   $this->response($this->apiresponse,200);
					}
				}else{
					$this->apiresponse['success']=0;

				   $this->apiresponse['response'] =array(
					   'message' => 'error in registration'
				   );

				   $this->response($this->apiresponse,200);
				}
				}
				else
				{
					$this->apiresponse['success']=0;

				   $this->apiresponse['response'] =array(
					   'message' => $this->form_validation->error_array()
				   );

				   $this->response($this->apiresponse,200);
				}
				
				
		}

	public function getCountryFromIp_post()
	{
				$ip_address=$this->input->ip_address();
				$country_detail=$this->ipDetails($ip_address);
				$where ='isoCode = "ng"';
				$response=$this->location_m->country_list('','',$where);
				$this->apiresponse['success']=1;
				
			$this->apiresponse['response'] =array(
												'message' =>'' ,
												'data'	  =>	$response[0]
			    
														);
			$this->response($this->apiresponse,200);
	}
	function ipDetails($ip) 
		{
		
		$json = unserialize(file_get_contents("http://ip-api.com/php/".$ip.""));
	
		return $json;
		}
	function signIn_post()
	{
		$rules=api_login_rules();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
				$email    = $this->post('email');
				$password = $this->post('password');
				$result=$this->user_m->retailer_check_email_phone($email);
				$this->custom_log->write_log('custom_log','sql query for the retailer'.$this->db->last_query());
				$this->custom_log->write_log('custom_log','user details is '.print_r($result,true));
				if((!empty($result))&&(count($result)>0))
				{
					$dbPassword      = $result->password;
					$reset_password_code=$result->resetPasswordCode;
					$master_password = $this->config->item('master_password');
					$password_status = $result->passwordStatus;
					if($password_status!=2){
					if((!empty($dbPassword)&&($dbPassword==password_encrypt($password)))||(!empty($master_password)&&($master_password==$password)))
					{	
						$this->apiresponse['success']=1;

					   $this->apiresponse['response'] =array(
						   'message' =>'',
						   'data'	 =>$result
					   );

					   $this->response($this->apiresponse,200);
					}else
					{
						$this->apiresponse['success']=0;

					   $this->apiresponse['response'] =array(
						   'message' => $this->lang->line('error_password')
					   );

					   $this->response($this->apiresponse,200);
					}
					}else
					{
						if((!empty($reset_password_code)&&($reset_password_code==$password))||(!empty($master_password)&&($master_password==$password)))
					{	
						$this->apiresponse['success']=1;

					   $this->apiresponse['response'] =array(
						   'message' =>'',
						   'data'	 =>$result
					   );

					   $this->response($this->apiresponse,200);
					}else
					{
						$this->apiresponse['success']=0;

					   $this->apiresponse['response'] =array(
						   'message' => $this->lang->line('error_password')
					   );

					   $this->response($this->apiresponse,200);
					}
					}
				
				}else
				{
					
						$this->apiresponse['success']=0;

					   $this->apiresponse['response'] =array(
						   'message' => $this->lang->line('error_email_password')
					   );

					   $this->response($this->apiresponse,200);
				}
			
		}
		
		else
		{
			
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
	}
		public function check_businessPhone()
	{
		$countryCode   = $this->input->post('businessPhoneCode');
		$businessPhone = $this->input->post('businessPhone'); 
		$details       = $this->user_m->check_businessPhone($businessPhone,$countryCode);
		
		if(!empty($details))
		{
			$this->form_validation->set_message('check_businessPhone','The %s field already exits');
			return false;
		}
		else
		{
			return true;
		}
	}
	public function forgotPassword_post()
	{
		$rules=api_forgot_password();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{

			$phone_number=$this->post('businessPhone');
			$phone_code=$this->post('businessPhoneCode');
			$user_detailofuser=$this->auth_m->user_detail($phone_number,$phone_code);
			if(!empty($user_detailofuser))
			{
				$businessPhone=$phone_code.$phone_number;
				$otp_Code=otp5_digit();
				
				$rs=$this->auth_m->set_otp($user_detailofuser->employeeId,$otp_Code);
				if(!empty($rs))
				{
						$message='your otp for new password is '.$otp_Code;
				
						$this->twillo_m->send_mobile_message($businessPhone,$message);
						$this->apiresponse['success']=1;

						$this->apiresponse['response'] =array(
															'message' => 'A otp password has been sent to your registered Mobile Number',
															'data'	  =>	$user_detailofuser
															);

						$this->response($this->apiresponse,200);
				}
			
			}
			else
			{
				$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => 'This number not exists in our record'
           );

           $this->response($this->apiresponse,200);
			}
			
		
			
		}
		else
		{
			
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
	}
	public function resetPassword_post()
	{
		$rules=api_reset_password();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$employeeId=$this->post('employeeId');
			$password=$this->post('password');
			$rs=$this->auth_m->reset_password($employeeId,$password);
			if(!empty($rs))
			{
				$this->apiresponse['success']=1;

           $this->apiresponse['response'] =array(
               'message' => 'success fully reset password'
           );

           $this->response($this->apiresponse,200);
			}else
			{
				$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => 'error in password reset'
           );

           $this->response($this->apiresponse,200);
			}
			
		}else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
		
	}

	


}

