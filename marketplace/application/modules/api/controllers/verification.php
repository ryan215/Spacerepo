<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class Verification extends REST_Controller
{
	public function __construct() 
	{
	  parent::__construct ();
		$this->apiresponse['time']=time();
		$this->load->model('user_m');
		$this->load->model('email_m');
		$this->load->model('twillo_m');
		$this->load->helper('api_validation');
		
	  if (is_array($this->response->lang))
		{
			$this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
			$this->lang->load('error', $this->response->lang[0]);
			$this->lang->load('success', $this->response->lang[0]);

		}
		else
		{
			$this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
			$this->lang->load('error', $this->response->lang);
			$this->lang->load('success', $this->response->lang);
			// $this->load->language('application', $this->response->lang);
		}
	}
	


	function send_verification_post()
	{
		$rules= send_verification();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
		
		$phone_number=$this->post('businessPhone');
		//$country_code=$this->post('phone_code');
		$verification_code=$this->check_verification_code();
		$phone=$phone_number;
		$user_id=$this->post('user_id');
		$this->user_m->assignverificationPref($user_id,$verification_code,$phone_number);
		//$phone='919826427281';
		$message='Your 5 digit verification code is "'.$verification_code.'".';
		$rs=$this->twillo_m->send_mobile_message('',$phone,$message);
		if(!empty($rs))
		{
			$this->apiresponse['success']=1;

           $this->apiresponse['response'] =array(
               'message' => '' ,
			   'data'	=>	array('verificationPref'	=> $verification_code)
           );

           $this->response($this->apiresponse,200);
		}else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => '' ,
			   'data'	=>	array('verificationPref'	=> $verification_code)
           );

           $this->response($this->apiresponse,200);
		}
		}
		else
		{
				$this->apiresponse['success']	=	0;

           $this->apiresponse['response'] 	=array
											(
											'message' => $this->form_validation->error_array()
											 );

           $this->response($this->apiresponse,200);
		}
	}
	function check_verification_code()
	{
		$verification_code=mt_rand(10000,99999);
		$this->custom_log->write_log('custom_log',$verification_code);
		$userdetail=$this->user_m->check_verification_code($verification_code);
		if(!empty($userdetail)){
			$this->check_cerification_code();
			
		}else
		{
			return $verification_code;
		}
		
	}
	public function resendVerificationCode_post()
	{
			$user_id=$this->post('oraganizationId');
		if(!empty($user_id)){
		$verification_code=$this->check_verification_code();
		 
		$organization_detial=$this->user_m->retailer_user_details($user_id);
		$this->user_m->assignverificationPref($user_id,$verification_code);
		$phone=$organization_detial->businessPhoneCode.$organization_detial->businessPhone;
		$message='Your 5 digit verification code is "'.$verification_code.'".';
		$rs=$this->twillo_m->send_mobile_message($phone,$message);
		$this->apiresponse['success']=1;

           $this->apiresponse['response'] =array(
               'message' => '',
			   'data'	=>	array('verificationPref'	=> $verification_code)
           );

           $this->response($this->apiresponse,200);
		}else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => 'Please send Valid Parameter'
           );

           $this->response($this->apiresponse,200);
		}
		
	}
	function verifyUser_post()
	{
		$rules=check_verification();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
		
		$organizationId=$this->post('oraganizationId');
		$passcode=$this->post('verificationPref');
		$userdetail=$this->user_m->requestRetailerDetails($organizationId);
		if($userdetail->verificationPref==$passcode){
			//$this->user_m->activate_user($user_id);
			$employeeId       = $userdetail->employeeId;
			if($this->user_m->update_verified_request_status($employeeId))
					{
								$this->apiresponse['success']=1;

							   $this->apiresponse['response'] =array(
								   'message' => 'successfully activated user'
							   );

							   $this->response($this->apiresponse,200);
					}else
					{
						$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => 'Please use the correct Verification code'
           );

           $this->response($this->apiresponse,200);
					}
		}else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => 'Please use the correct Verification code'
           );

           $this->response($this->apiresponse,200);
		}
		}
		else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => 'Error in sending verification code'
           );

           $this->response($this->apiresponse,200);
			
		}
		
		
	}
	


	

	


}

