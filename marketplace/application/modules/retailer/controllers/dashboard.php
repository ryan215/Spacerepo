<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Dashboard extends MY_Controller {

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
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'Dashboard';
		if($this->session->userdata('skip')!=0)
			{
				redirect('retailer/dashboard/verify_user');
			}
			
		$this->retailerCustomView('dashboard/dashboard',$this->data);
	}
	public function verify_user()
	{
			$this->session->set_userdata(array(
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );
		$organizationId 	  = $this->session->userdata('organizationId');
			$employeeId          = 0;		
		//$organizationId      = id_decrypt($organizationId);
		$details             = $this->user_m->requestRetailerDetails($organizationId);
		//print_r($details);
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
			$result['countryCode']   = '+91';
			$result['email']		 = trim($this->input->post('email'));
			
			$rules = update_phone_verification_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$newOtp = otp5_digit(); 
				if($this->user_m->update_otp($organizationId,$newOtp))
				{					
					if($this->user_m->update_verification_phone_email($employeeId,$result))
					{
						$message = 'Your New OTP is "'.$newOtp.'".';
	 					$rs      = $this->twillo_m->send_mobile_message($result['countryCode'].$result['businessPhone'],$message);		
						$this->session->set_flashdata('success',$this->lang->line('success_update_phone'));
						//print_r($return);
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
				redirect(base_url().'retailer/dashboard/phone_verification/'.id_encrypt($organizationId));
			}else
			{
				$error_array=$this->form_validation->error_array();
				//print_r($error_array);
			}
		}
		
		$this->data['result'] = $result;
		
		
		$this->data['title'] = 'Dashboard';
		$this->retailerCustomView('dashboard/verify_user',$this->data);
	}
	public function phone_verification()
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
		$organizationId 	  = $this->session->userdata('organizationId');
		$details             = $this->user_m->requestRetailerDetails($organizationId);
	//echo "<pre>";	print_r($details); exit;
		if(!empty($details))
		{
			$verificationPref = $details->verificationPref;
			$employeeId       = $details->employeeId;
			$result['businessPhone'] = trim($details->businessPhoneCode).trim($details->businessPhone);
			//print_r($details);
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_details_no_found'));
			redirect(base_url().'retailer/home');
		}
		
		if($_POST)
		{
			//print_r($_POST);
			$rules = phone_verification_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				//print_r($_POST);
				$otp   = $this->input->post('otp');
				$imOTP = implode('',$otp);
				//print_r($imOTP);
				if($imOTP==$verificationPref)
				{
					if($this->user_m->update_verified_request_status($employeeId))
					{
						$this->session->set_flashdata('success','successfully verified');
						$this->session->set_userdata('skip',0);
						redirect(base_url().'retailer/product_request_management');
					}else
					{
						//print_r('error_confirm');
					}
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_match_otp'));
					redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId));
				}
			}
			else{
				$error_array=$this->form_validation->error_array();
				//print_r($error_array);
			}
		}
		
		$this->data['title'] = 'Dashboard';
		$this->retailerCustomView('dashboard/verification',$this->data);
	}
	
	public function retailer_first_login()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_first_login',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Change user name or password';
		$result = array();
		$result['userName']     = '';
		$result['password']     = '';
		$result['confPassword'] = '';
		$employeeId  		= $this->session->userdata('userId');
		$employeeDet 		= $this->user_m->get_retailer_employee($employeeId);
		
		if(!empty($employeeDet))
		{
			$result['userName'] = $employeeDet->userName;
		}
		
		if($_POST)
		{
			$result['userName']     = $this->input->post('userName');
			$result['password']     = $this->input->post('password');
			$result['confPassword'] = $this->input->post('confPassword');
		
			$rules = retailer_first_login_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
	    	{
				if($this->user_m->update_retailer_username($employeeId,$result))
				{
					$this->session->set_flashdata('success',$this->lang->line('success_update_retailer_username'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_update_retailer_username'));
				}
				redirect(base_url().'retailer/product_request_management');
			}
		}
		
		$this->data['result'] = $result;
				
		$this->retailerFrontCustomView('home/retailer_first_login',$this->data);
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
	public function pointepay_html($viewName)
	{
		$this->retailerCustomView('pointepayhtml/'.$viewName,$this->data);
	}
}