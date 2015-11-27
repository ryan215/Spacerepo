<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Home extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_home',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Sign In';
		$this->profile_lib->retailer_sign_in();
		$this->retailerFrontCustomView('home/sign_in',$this->data);
	}
	
	public function sign_up()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'sign_up',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Sign Up';
		$result = $this->profile_lib->retailer_sign_up();
		$this->data['result'] = $result;
		
		$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
		$this->data['imageUploadPath'] = base_url().'retailer/home/upload_retailer_image/';
		$this->retailerFrontCustomView('home/sign_up',$this->data);				
	}
	
	public function check_businessPhone()
	{
		$countryCode   = $this->input->post('countryCode');
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
	
	public function upload_retailer_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_retailer_image',
				'log_MID'    => '' 
		) );
		
		$imageName = $this->profile_lib->upload_retailer_image();
		echo $imageName;
	}	
	
	public function check_username()
	{
		$employeeId = $this->session->userdata('userId');
		$userName   = $this->input->post('userName');
		$details    = $this->user_m->check_username_exits($employeeId,$userName);
		if(!empty($details))
		{
			$this->form_validation->set_message('check_username','The %s field already exits');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function check_username_ajax()
	{
		$userName = $this->input->post('userName');
		$details  = $this->user_m->check_username_exits('',$userName);
		if(!empty($details))
		{
			echo '2';
		}
		else
		{
			echo '1';
		}
	}
	
	public function phone_verification($organizationId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_first_login',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Phone Verification';
		$result 			 = array();
		$result['otp']       = '';
		$result['businessPhone'] = '';
		$verificationPref    = '';	
		$employeeId          = 0;		
		$organizationId      = id_decrypt($organizationId);
		$details             = $this->user_m->requestRetailerDetails($organizationId);
	//echo "<pre>";	print_r($details); exit;
		if(!empty($details))
		{
			$verificationPref = $details->verificationPref;
			$employeeId       = $details->employeeId;
			$result['businessPhone'] = trim($details->businessPhoneCode).trim($details->businessPhone);
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_details_no_found'));
			redirect(base_url().'retailer/home');
		}
		
		if($_POST)
		{
			$rules = phone_verification_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$otp   = $this->input->post('otp');
				$imOTP = implode('',$otp);
				if($imOTP==$verificationPref)
				{
					if($this->user_m->update_verified_request_status($employeeId))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_match_otp'));
						
						$this->after_verification_login(id_encrypt($organizationId));
						//redirect(base_url().'retailer/dashboard');
					}
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_match_otp'));
					redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId));
				}
			}
		}
		
		$this->data['result'] = $result;
		$this->data['organizationId'] = $organizationId;
		$this->retailerFrontCustomView('home/phone_verification',$this->data);
	}	
	
	public function editVerificationPhone($organizationId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editVerificationPhone',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Phone Verification';
		$result 			 = array();
		$result['businessPhone'] = '';
		$result['countryCode']   = '';
		$employeeId          = 0;		
		$organizationId      = id_decrypt($organizationId);
		$details             = $this->user_m->requestRetailerDetails($organizationId);
		
		if(!empty($details))
		{
			$employeeId              = $details->employeeId;
			$result['businessPhone'] = trim($details->businessPhone);
			$result['countryCode']   = $details->businessPhoneCode;
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_details_no_found'));
			//redirect(base_url().'retailer/home/index');
		}
		
		if($_POST)
		{
			$result['businessPhone'] = trim($this->input->post('businessPhone'));
			$result['countryCode']   = trim($this->input->post('countryCode'));
			
			$rules = update_phone_verification_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$newOtp = otp5_digit(); 
				if($this->user_m->update_otp($organizationId,$newOtp))
				{					
					if($this->user_m->update_verification_phone($employeeId,$result))
					{
						$message = 'Your New OTP is "'.$newOtp.'".';
	 					$rs      = $this->twillo_m->send_mobile_message($result['countryCode'].$result['businessPhone'],$message);
						$this->session->set_flashdata('success',$this->lang->line('success_update_phone'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_update_phone'));
					}
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_update_otp'));	
				}
				redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId));
			}
		}
		
		$this->data['result'] = $result;
		$this->data['organizationId'] = $organizationId;
		$this->retailerFrontCustomView('home/editVerificationPhone',$this->data);
	}
	
	public function skip($organizationId)
	{
		$organizationId = id_decrypt($organizationId);
		$result   = $this->user_m->retailer_skip_login($organizationId);
		if((!empty($result))&&(count($result)>0))
		{
			//$this->user_m->update_verified_request_status($result->employeeId);
			$password_status = $result->passwordStatus;
			$this->session->set_userdata(array(
								'userId'    	 => $result->employeeId,
								'userType' 		 => 'retailer',
								'userEmail'	 	 => $result->email,
								'userName'  	 => ucwords($result->firstName.' '.$result->middle.' '.$result->lastName),
								'userimage' 	 =>	$result->imageName,
								'organizationId' => $result->organizationId,
								'skip'			 => 1,
				));
			$this->session->set_flashdata('success',$this->lang->line('success_login'));
			redirect(base_url().'retailer/dashboard/verify_user');	
		}
		else
		{
			$this->session->set_flashdata('success','Invalid user');
			redirect(base_url().'retailer/home');
		}
	}
	
	public function test()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_home',
				'log_MID'    => '' 
		) );
		$this->retailerFrontCustomView('home/test',$this->data);
	}
	function after_verification_login($organizationId)
	{
			$organizationId = id_decrypt($organizationId);
		$result   = $this->user_m->retailer_skip_login($organizationId);
		$this->user_m->update_verified_request_status($result->employeeId);
			$password_status = $result->passwordStatus;
			$this->session->set_userdata(array(
								'userId'    	 => $result->employeeId,
								'userType' 		 => 'retailer',
								'userEmail'	 	 => $result->email,
								'userName'  	 => ucwords($result->firstName.' '.$result->middle.' '.$result->lastName),
								'userimage' 	 =>	$result->imageName,
								'organizationId' => $result->organizationId,
								'show_popup'			 => 1,
				));
				$this->session->set_flashdata('show_popup',ucwords($result->firstName.' '.$result->middle.' '.$result->lastName));
				redirect('retailer/product_request_management');
	}
    public function resend_verification_code($organizationId)
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'resend_verification_code',
				'log_MID'    => '' 
		) );
		
        $organizationId    = id_decrypt($organizationId);
        $verification_code = otp5_digit();
		
		$this->custom_log->write_log('custom_log','organization id is '.$organizationId.' and new verification code is '.$verification_code);

        $organization_detial = $this->user_m->retailer_user_details($organizationId);
		$this->custom_log->write_log('custom_log','organization details is '.print_r($organization_detial,true));
		
        $this->user_m->assignverificationPref($organizationId,$verification_code);
		$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
		
        $phone   = $organization_detial->businessPhoneCode.$organization_detial->businessPhone;
        $message = 'Your New OTP is "'.$verification_code.'"';
        $rs      = $this->twillo_m->send_mobile_message($phone,$message);
		$this->custom_log->write_log('custom_log','Send message response is '.print_r($rs,true));
								
		if(!empty($organization_detial))
		{
			if(!empty($organization_detial->email))
			{
				$mailData = array(
								'email'         => $organization_detial->email,
								'cc'	        => '',
								'slug'          => 'resend_verification_code',
								'businessName'  => $organization_detial->organizationName,
								'otp'			=> $verification_code,
								'subject'       => 'Resend Verification Code',
							);	
				if($this->email_m->send_mail($mailData))
				{
					$this->session->set_flashdata('success','A text or Email message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
					$this->custom_log->write_log('custom_log','Mail is send');
				}
				else
				{
					$this->session->set_flashdata('error','Mail not send');
					$this->custom_log->write_log('custom_log','Mail not send');
				}	
			}
			else
			{
				$this->session->set_flashdata('success','A text message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
			}
		}
        redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId));
    }
	
}