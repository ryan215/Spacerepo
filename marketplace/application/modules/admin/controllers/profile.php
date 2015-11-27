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
	
	$user_id = $this->session->userdata('userId');
		
		$this->data['users_details'] =  $this->user_m->admin_user_details($user_id);
		//echo "<pre>"; print_r($this->data['users_details']); exit;
		$this->data['title']='Profile Detail';
		$this->adminCustomView('profile/show_profile',$this->data);
	}
	
	public function edit_profile()
	{
		$this->data['title'] = 'Profile Detail';
		$user_id = $this->session->userdata('userId');
		$result = array();
		$result['firstName'] = '';
		$result['lastName']  = '';
		$result['middle']    = '';
		$result['imageName'] = '';
		$result['birthDay']  = '';
		$result['countryId'] = '';
		$result['stateId']   = '';
		$addressId = 0;
		
		$userDetails = $this->user_m->admin_user_details($user_id);
		if(!empty($userDetails))
		{
			$result['firstName'] = $userDetails->firstName;
			$result['lastName']  = $userDetails->lastName;
			$result['middle']    = $userDetails->middle;
			$result['imageName'] = $userDetails->imageName;
			$result['birthDay']  = $userDetails->birthDay;
			$result['countryId'] = $userDetails->countryId;
			$result['stateId']   = $userDetails->stateId;
			$addressId = $userDetails->addressId;
		}
		
		if($_POST)
		{
			$result['firstName']  = $this->input->post('firstName');
			$result['lastName']   = $this->input->post('lastName');
			$result['middle']     = $this->input->post('middle');
			$result['imageName']  = $this->input->post('imageName');
			$result['birthDay']   = '0000-'.$this->input->post('month').'-'.$this->input->post('date');
			$result['countryId']  = $this->input->post('countryId');
			$result['stateId']    = $this->input->post('stateId');
		
			
			$rules = update_admin_own_profile();
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run())
			{	
				if($this->user_m->update_admin_own_employee($user_id,$result))
				{
			 		$this->user_m->update_admin_own_address($addressId,$result);
					$this->session->set_flashdata('success',$this->lang->line('success_update_profile'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_update_profile'));	
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_update_profile'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_update_profile'));	
				}
				redirect(base_url().'admin/profile');
			}
			
		}
		
		$result['countryList'] 		   = $this->location_m->country_list();
		$this->data['imagePath'] 	   = base_url().'uploads/admin/thumb50/';
		$this->data['imageUploadPath'] = base_url().'admin/profile/upload_admin_image/';
		$this->data['result'] 		   = $result;
		$this->adminCustomView('profile/edit_profile',$this->data);
	}

	
	
	
	public function setting()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'setting',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Email Setting';
		$this->profile_lib->email_setting();
		$this->adminCustomView('retailer/profile/email_setting',$this->data);
	}
	
	public function change_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_password',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Password Setting';
		$this->profile_lib->change_password();
		$this->adminCustomView('retailer/profile/change_password',$this->data);
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
		
	public function upload_admin_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_admin_image',
				'log_MID'    => '' 
		) );
		
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/admin/'; 
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $newImageName;
			$image_name              = $newImageName;
						
			$this->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('myfile'))
			{
				$error = array('error' => $this->upload->display_errors());			
				$this->custom_log->write_log('custom_log','file upload error is '.$this->upload->display_errors());
			}
			else
			{
				$imagepath	  =	'uploads/admin/'.$newImageName ;
				$newimagepath =	'uploads/admin/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/admin/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}
	
	public function upload_cse_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_cse_image',
				'log_MID'    => '' 
		) );
		
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/cse/'; 
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $newImageName;
			$image_name              = $newImageName;
						
			$this->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('myfile'))
			{
				$error = array('error' => $this->upload->display_errors());			
				$this->custom_log->write_log('custom_log','file upload error is '.$this->upload->display_errors());
			}
			else
			{
				$imagepath	  =	'uploads/cse/'.$newImageName ;
				$newimagepath =	'uploads/cse/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/cse/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}
	
	
}