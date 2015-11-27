<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Shipping extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Shipping';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_index',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Sign In';
		$this->profile_lib->shipping_vendor_sign_in();
		$this->shippingFrontCustomView('auth/sign_in',$this->data);
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
													'passwordStatus'	=>	1,
													'active'			=> 1
												),
									'where' => array('employeeId' => $userId)
							  );
				$this->common_model->customUpdate($updatePass);
				$this->custom_log->write_log('custom_log', 'password updated succssfully');
				
				$this->custom_log->write_log('custom_log', 'change password status updated successfully');
				$this->custom_log->write_log('custom_log', 'user type is '.$user_type);
				redirect(base_url().'shipping/rate_list');
			}
		}
		
		$this->data['title'] = 'New Password';		
		$this->load->view('auth/first_change_password',$this->data);
	}
}