<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Auth extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->helper('cookie');
		$this->load->model('auth_m');
	}	
	
	public function index()
	{
		redirect(base_url()."auth/login");
	}
	
	public function login()
	{		
		$email    = '';
		$password = '';	
		if(($this->input->cookie('email',TRUE))&&($this->input->cookie('password',TRUE)))
		{
			$email    = $this->input->cookie('email',TRUE);
			$password = $this->input->cookie('password',TRUE);	
		}

		if($_POST)
		{
			$email    	 = $this->input->post('email');
			$password 	 = $this->input->post('password');
			$remember    = $this->input->post('remember');
			$rules       = sign_in_rules();
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->form_validation->run())
	    	{	
				$where  = "(role.code in('SUPERADMIN','ADMIN','CUSTOMERSERVICE','SVE'))";
				$result = $this->auth_m->sign_in($email,$where);
				$this->custom_log->write_log('custom_log','user details is '.print_r($result,true));
				//echo "<pre>";	 print_r($result); exit;
				if(!empty($result) && (count($result)>0))
				{
					$this->profile_lib->sign_in($result,$password,base_url().'auth/login',$remember);
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_email_password'));
					redirect(base_url().'auth/login');
				}
			}
		}
		
		$this->data['email']    = $email;
		$this->data['password'] = $password;
		$this->data['title']    = 'Login';
		$this->customLoginView('login',$this->data);
	}
	
	public function logout()
	{
		$redirect_to = base_url();
		$userType    = $this->session->userdata('userType');
		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
		if(($userType=='admin')||($userType=='superadmin')||($userType=='cse')||($userType=='finance'))
		{
			$redirect_to = base_url().'admin';
		}
		elseif($userType=='retailer')
		{
			$redirect_to = base_url().'retailer';
		}
		elseif($userType=='shipping_vendor')
		{
			$redirect_to = base_url().'shipping';
		}
		elseif($userType=='customer')
		{
			$redirect_to = base_url();
		}
		
		$session_id = $this->session->userdata('session_id');
		$this->custom_log->write_log('custom_log', 'created user id is '.$session_id);
		
		
		$this->session->sess_destroy();
		redirect(base_url());
	}
	
	public function reset_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'forgot_password',
				'log_MID'    => '' 
		));
		
		$this->data['title'] = 'Forgot Password';
		$result = $this->profile_lib->forgot_password(base_url().'auth/');
		if($result['error'])
		{
			redirect(base_url().'auth/reset_password');	
		}
		elseif($result['success'])
		{
			redirect(base_url().'auth/login');
		}
		$this->customLoginView('reset_password',$this->data);
	}
	
	public function first_change_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'first_change_password',
				'log_MID'    => '' 
		) );
		
		if($_POST)
		{
			$validation = array(
							array(
								'field' => 'newPassword',
								'label' => 'New Password',
								'rules' => 'trim|required|min_length[6]|max_length[20]'
							),
							array(
								'field' => 'confirmPassword',
								'label' => 'Confirm New Password',
								'rules' => 'trim|required|matches[newPassword]'
							)
						);
		
			$this->form_validation->set_rules($validation);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
	    	{
				$this->custom_log->write_log('custom_log', 'form submit data is '.print_r($_POST,true));
				$userId    = $this->session->userdata('userId');
				$user_type = $this->session->userdata('userType');
				
				$updatePass = array(
									'table' => 'employee',
									'data'  => array(
													'password' 			=> password_encrypt($this->input->post('newPassword')),
													'passwordStatus'	=>	1
												),
									'where' => array('employeeId' => $userId)
							  );
				$this->common_model->customUpdate($updatePass);
				$this->custom_log->write_log('custom_log', 'password updated succssfully');
				
				$this->custom_log->write_log('custom_log', 'change password status updated successfully');
				$this->custom_log->write_log('custom_log', 'user type is '.$user_type);
				
				
				if($user_type=='superadmin')
				{
					redirect(base_url().'superadmin/dashboard');
				}
				elseif($user_type=='admin')
				{
					redirect(base_url().'admin/dashboard');
				}
				elseif($user_type=='cse')
				{
					redirect(base_url().'cse/dashboard');
				}
				elseif($user_type=='retailer')
				{
					redirect(base_url().'retailer/inventory');
				}
				elseif($user_type=='customer')
				{
					if(isset($_GET['redirect']))
					{
					redirect($_GET['redirect']);
					}else
					{
					redirect(base_url());	
					}
				}
			}
		}
		
		$this->data['title'] = 'New Password';		
		$this->customLoginView('first_change_password',$this->data);
	}
	
	public function varification($userID='',$varifiedCode='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'varification',
				'log_MID'    => '' 
		) );
		$this->load->model('customer_m');
		$this->custom_log->write_log('custom_log','encrypted user id '.$userID.' and Varification code is '.$varifiedCode);
		if((!empty($userID))&&(!empty($varifiedCode)))
		{
			$userID = id_decrypt($userID);
			$result = $this->customer_m->check_user_varification_code($userID,$varifiedCode);
			//echo "<pre>"; print_r($result); exit;
			if(!empty($result))
			{
				if($this->customer_m->update_varified($userID))
				{
					$this->session->set_flashdata('success','Thank you for verifying your account. You can now log into your account with the details provided in your registered email address.');	
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_not_varified'));	
				}
			}	
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_not_user'));	
			}		
		}
		redirect(base_url());
	}	
	
	public function backend_reset_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'backend_reset_password',
				'log_MID'    => '' 
		));
		
		$this->data['title'] = 'Forgot Password';
		$result = $this->profile_lib->forgot_password('backend');
		if($result['error'])
		{
			redirect(base_url().'auth/backend_reset_password');	
		}
		elseif($result['success'])
		{
			redirect(base_url().'auth/login');
		}
		$this->customLoginView('backend_reset_password',$this->data);
	}
	
	public function backend_confirm_reset_password($userId='',$resetPasswordCode='')
	{
		$this->data['title'] = 'Confirm Reset Password';
		$userId  			 = id_decrypt($userId);
		$result  			 = $this->profile_lib->confirm_reset_password($userId,$resetPasswordCode);
		
		if(($result['success'])||($result['error']))
		{
			redirect(base_url().'auth/login');
		}
		
		$this->data['reset_password_code'] = $resetPasswordCode;
		$this->customLoginView('confirm_reset_password',$this->data);
	}
	
	public function retailer_reset_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_reset_password',
				'log_MID'    => '' 
		));
		
		$this->data['title'] = 'Forgot Password';
		$businessPhoneCode = '+234';
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			$rules = retailer_reset_password_rules();						
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$email = trim($this->input->post('businessPhone'));
				$businessPhoneCode = trim($this->input->post('countryCode'));
				$user  = $this->retailer_m->user_phone_no($email);
				//echo "<pre>";	print_r($user); exit;
				if(!empty($user))
				{
					$businessOwnerName = $user->firstName.' '.$user->lastName;
					$password          = otp5_digit();
					
					if($this->retailer_m->update_password($user->employeeId,$password))
					{
						$message = 'Your user name '.$user->userName.' and password is '.$password;
						//echo $message; exit;
						$rs = $this->twillo_m->send_mobile_message($businessPhoneCode.$email,$message);
						
						$this->custom_log->write_log('custom_log', 'response is '.print_r($rs,true));
						$this->session->set_flashdata('success','Temporary password send your mobile no.');	
					}
					else
					{
						$this->session->set_flashdata('error','Reset password not update');
					}
				}
				else
				{
					$this->session->set_flashdata('error','User not available');
				}
				redirect(base_url().'retailer');
			}
		}
		
		$this->data['businessPhoneCode'] = $businessPhoneCode;
		$this->retailerFrontCustomView('retailer_reset_password',$this->data);
	}
	
	public function retailer_reset_password_backup()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_reset_password',
				'log_MID'    => '' 
		));
		
		$this->data['title'] = 'Forgot Password';
		$result = $this->profile_lib->forgot_password('retailer');
		if($result['error'])
		{
			redirect(base_url().'auth/retailer_reset_password');	
		}
		elseif($result['success'])
		{
			redirect(base_url().'retailer/home');
		}
		$this->retailerFrontCustomView('retailer_reset_password',$this->data);
	}
	
	public function retailer_confirm_reset_password($userId='',$resetPasswordCode='')
	{
		$this->data['title'] = 'Confirm Reset Password';
		$userId  			 = id_decrypt($userId);
		$result  			 = $this->profile_lib->confirm_reset_password($userId,$resetPasswordCode);
		if(($result['success'])||($result['error']))
		{
			redirect(base_url().'retailer/home');
		}
		
		$this->data['reset_password_code'] = $resetPasswordCode;
		$this->retailerFrontCustomView('retailer_confirm_reset_password',$this->data);
	}
}