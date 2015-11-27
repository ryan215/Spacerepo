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
	
	public function index()
	{
		$modified_by   = '';
		$modified_time = '';
		$user_id 	   = $this->session->userdata('userId');
		$this->data['title'] = 'Profile Detail';
		
		$this->data['users_details'] = $this->user_m->user_details($user_id);
		if(!empty($this->data['users_details']))
		{
			$modified_by   = $this->data['users_details']->modified_by;
			$modified_time = $this->data['users_details']->last_modified_date;
		}
		
		$this->data['modified_by']   = $modified_by;
		$this->data['modified_time'] = $modified_time;
		$this->retailerCustomView('profile/show_profile',$this->data);
	}
	
	public function edit_profile()
	{
		$user_id = $this->session->userdata('userId');
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$show_modal = 1;
			$rules 		= update_retailer_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run())
			{	
				$last_name     = '';
				$business_name = $this->input->post('business_name');
				$first_name    = $business_name;
				$businessArr   = explode(" ",$business_name);
				if(count($businessArr)>1)
				{
					$first_name = $businessArr[0];
					$last_name  = $businessArr[1];
				}
				
				$phone_no          = $this->input->post('phone_no');
				$country_id        = $this->input->post('country_id');
				$state_id          = $this->input->post('state_id');
				$city_id           = $this->input->post('city_id');
				$zone_id           = $this->input->post('zone_id');
				$area_id    	   = $this->input->post('area_id');
				$street     	   = $this->input->post('street');
				$comment    	   = $this->input->post('comment');
				$businessPhoneNo   = $this->input->post('business_ph_no');
				$businessOwnerName = $this->input->post('business_owner_name');
				$bank_name		   = $this->input->post('bankName');
				$account_name	   = $this->input->post('accountName');
				$account_number	   = $this->input->post('accountNo');
				$branch_add		   = $this->input->post('branchAdd');
				$image_name		   = $this->input->post('image_name');
				
				if($this->user_m->update_retailer_profile($user_id,$first_name,$last_name,$phone_no,$country_id,$state_id,$city_id,$zone_id,$area_id,$street,$comment,$businessPhoneNo,$businessOwnerName,$bank_name,$account_name,$account_number,$branch_add,$image_name))
				{
					$this->session->set_flashdata('success',$this->lang->line('success_update_retailer_user'));
					$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_update_retailer_user'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_update_retailer_profile'));
					$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_update_retailer_profile'));
				}
				redirect(base_url().'retailer/profile');				
			}
		}
		
		$this->data['users_details'] = $this->user_m->user_details($user_id);
		$this->data['title']		 = 'Profile Detail';
		$this->retailerCustomView('profile/edit_profile',$this->data);
	}	
	
	public function setting()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'setting',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Email Setting';
		$this->profile_lib->email_setting();
		$this->retailerCustomView('retailer/profile/email_setting',$this->data);
	}
	
	public function change_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_password',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Password Setting';
		$this->profile_lib->change_password();
		$this->retailerCustomView('retailer/profile/change_password',$this->data);
	}
	
	
}