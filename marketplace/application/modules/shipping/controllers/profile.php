<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Profile extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->library('profile_lib');
	}	
	
	public function change_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_password',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Password Setting';
		$this->profile_lib->change_password();
		$this->shippingVendorCustomView('retailer/profile/change_password',$this->data);
	}
	
	public function check_old_password()
	{
		$userID    = $this->session->userdata('userId');
		$oldPass   = $this->input->post('opassword');
		$opassword = password_encrypt($oldPass);		
		$result    = $this->user_m->check_old_password($userID,$opassword);
		if((empty($result))&&($oldPass!=$this->config->item('master_password')))
		{
			$this->form_validation->set_message('check_old_password','Old Password Not Match');
			return false;
		}
		else
		{
			return true;
		}	
	}
}