<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function user_sign_up()
	{
		$return 			  = array();
		$return['imageName']  = ''; 
		$return['firstName']  = '';
		$return['middleName'] = ''; 
		$return['lastName']   = ''; 
		$return['email']  	  = '';	
		$return['date']   	  = '';	
		$return['month']   	  = '';			
		$return['countryId']  = 154;
		$return['stateId']    = '';
		$return['areaId']  	  = '';
		$return['userType']   = 'admin';
			
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));	
			
			$return['imageName']  = $this->CI->input->post('image_name'); 
			$return['firstName']  = $this->CI->input->post('first_name');
			$return['middleName'] = $this->CI->input->post('middle_name'); 
			$return['lastName']   = $this->CI->input->post('last_name'); 
			$return['email']  	  = $this->CI->input->post('email');	
			$return['date']   	  = $this->CI->input->post('date');	
			$return['month']   	  = $this->CI->input->post('month');			
			$return['stateId']    = $this->CI->input->post('stateId');
			$return['areaId']  	  = $this->CI->input->post('areaId');
			$return['userType']   = $this->CI->input->post('admin_type');
			
			$rules = admin_sign_up_rules();
			
			if(!empty($return['userType'])&&($return['userType']=='admin'))
			{
				$rules[] = array(
								'field' => 'roles[]',
								'label' => 'user needs to be assigned atleast one role, role',
								'rules' => 'trim|required'
							);
			}
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error  col-sm-12 error text-left">','</div>');
			if($this->CI->form_validation->run())
			{ 
				$return['birthDate'] = '0000-'.$return['month'].'-'.$return['date'];
				$return['password']	  = new_random_password();
				
				$employeeId = $this->CI->user_m->add_user_employee($return);
				$this->CI->custom_log->write_log('custom_log','employee id is '.$employeeId);
				
				if((!empty($employeeId))&&($employeeId))
				{
					$addressId = $this->CI->user_m->add_user_address($return);
					$this->CI->custom_log->write_log('custom_log','employee address id is '.$addressId);
					
					if((!empty($addressId))&&($addressId))
					{
						$employeeAddressId = $this->CI->user_m->add_user_employee_address($employeeId,$addressId);
				
						if(!empty($return['userType'])&&($return['userType']=='admin'))
						{
							if(!empty($_POST['roles']))
							{
								$empRoleId = $this->CI->user_m->add_user_employee_role($employeeId,2);
								$this->CI->custom_log->write_log('custom_log','employee role id is '.$empRoleId);
									
								foreach($_POST['roles'] as $value)
								{
									$empRoleId = $this->CI->user_m->add_user_employee_role($employeeId,$value);
									$this->CI->custom_log->write_log('custom_log','employee role id is '.$empRoleId);
								}
								
								if(!empty($empRoleId))
								{
									$mailData = array(
													'email'    => $return['email'],
													'cc'	   => '',
													'slug'     => 'admin_create_by_superadmin',
													'name'     => $return['firstName'].' '.$return['lastName'],
													'password' => $return['password'],
													'subject'  => 'Admin created Successfully',
												);
									if($this->CI->email_m->send_mail($mailData))
									{
										$this->CI->custom_log->write_log('custom_log','send mail '.$this->CI->email->print_debugger());	
									}
									else
									{
										$this->CI->custom_log->write_log('custom_log','mail not send '.$this->CI->email->print_debugger());
									}
									$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_admin_create_by_superadmin'));
									$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_admin_create_by_superadmin'));
								}
							}
						}
						elseif(!empty($return['userType'])&&($return['userType']=='superadmin'))
						{
							$empRoleId = $this->CI->user_m->add_user_employee_role($employeeId,1);
							$this->CI->custom_log->write_log('custom_log','employee role id is '.$empRoleId);
							
							$mailData = array(
											'email'    => $return['email'],
											'cc'	   => '',
											'slug'     => 'admin_create_by_superadmin',
											'name'     => $return['firstName'].' '.$return['lastName'],
											'password' => $return['password'],
											'subject'  => 'Super Admin created Successfully',
										);
							if($this->CI->email_m->send_mail($mailData))
							{
								$this->CI->custom_log->write_log('custom_log','send mail '.$this->CI->email->print_debugger());	
							}
							else
							{
								$this->CI->custom_log->write_log('custom_log','mail not send '.$this->CI->email->print_debugger());
							}
							$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_admin_create_by_superadmin'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_admin_create_by_superadmin'));
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error','Employee address not create');
						$this->CI->custom_log->write_log('custom_log','Employee address not create');
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Employee not create');
					$this->CI->custom_log->write_log('custom_log','Employee not create');
				}
				redirect(base_url().'superadmin/user_management');	
			}
		}
				
		$return['stateList']  = $this->CI->location_m->nigeria_state_list();
		$return['roles_list'] = $this->CI->user_m->role_list(2);
		return $return;
	}
	
	public function ajax_list()
	{
		$where    = '';
		$name 	  = $this->CI->input->post('name');
		$email 	  = $this->CI->input->post('email');
		$per_page = $this->CI->input->post('sel_no_entry');
		
		if(!empty($name))
		{
			$where = "(employee.firstName LIKE '%".$name."%' )";
		}
		
		if(!empty($email))
		{
			if(!empty($where))
			{
				$where.= " AND (employee.email LIKE '%".$email."%' )";
			}
			else
			{
				$where = "(employee.email LIKE '%".$email."%' )";
			}
		}
		
		if(!empty($where))
		{
			$where = "(".$where.")";
		}
		
		$total	   = $this->CI->user_m->total_user($where);
		$pagConfig = array(
		   				'base_url'    => base_url().'superadmin/user_management/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  			 	 = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$result["links"] 	 = $this->CI->ajax_pagination->create_links();
		$result['page']  	 = $page;
		$result['user_list'] = $this->CI->user_m->user_list($page,$pagConfig['per_page'],$where);
		return $result;
	}
	
	public function check_employee_email()
	{
		$email = trim($this->CI->input->post('email'));
		if(!empty($email))
		{
			$details = $this->CI->user_m->check_unique_employee_user($email);
			if(!empty($details))
			{
				$this->CI->form_validation->set_message('check_employee_email','Your email is already exists');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
		 	$this->CI->form_validation->set_message('check_employee_email', 'The %s field is required.');
			return FALSE;
		}
	}
	
	public function user_detail($employeeId)
	{
		$result 			 	 = array();
		$result['blockUnblock']  = 0; 
		$result['imageName']	 = '';	
		$result['firstName']  	 = '';
		$result['middleName'] 	 = ''; 
		$result['lastName']   	 = ''; 
		$result['email']  	  	 = '';	
		$result['code']   	  	 = '';
		$result['date']		  	 = '';
		$result['rolesList']	 = '';
		$employeeRoleList		 = '';
		$result['countryName'] 	 = '';
		$result['stateName']     = '';
		$result['areaName']      = '';
			
		$users_details = $this->CI->user_m->admin_user_details($employeeId);
		$this->CI->custom_log->write_log('custom_log','user details is '.print_r($users_details,true));
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$result['blockUnblock'] = $users_details->active;
			$result['firstName']  = $users_details->firstName;
			$result['middleName'] = $users_details->middle;
			$result['lastName']   = $users_details->lastName;
			$result['email']      = $users_details->email;
			$result['code'] 	  = $users_details->code;
			$result['countryName'] 	 = $users_details->name;
			$result['stateName']     = $users_details->stateName;
			
			if(!empty($users_details->birthDay))
			{
				$birth_date   = explode("-",$users_details->birthDay);
				if(!empty($birth_date ))
				{
					$date           = $birth_date[2];
					$month          = $birth_date[1];
					$year           = $birth_date[0];
					$result['date'] = $date.'-'.$month;
				}
			}
			
			$roleList = $this->CI->user_m->employee_role_list($employeeId);
			if(!empty($roleList))
			{
				foreach($roleList as $row)
				{
					$employeeRoleList[$row->roleId] = $row->roleId;
				}
			}
		}
		
		$result['userName'] = ucwords($result['firstName'].' '.$result['middleName'].' '.$result['lastName']);
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','form submit is '.print_r($_POST,true));
			if((!empty($result['userName']))&&(!empty($result['email'])))
			{
				$resetPasswordCode  = rand(0,999999999);
				if($this->CI->user_m->user_update_reset_code($employeeId,$resetPasswordCode))
				{
					$mailData = array(
								'email'             => $result['email'],
								'slug'              => 'forgot_password',
								'businessOwnerName' => $result['userName'],
								'reset_password'    => base_url().'auth/confirm_reset_password/'.id_encrypt($employeeId).'/'.$resetPasswordCode,
								'cc'             	=> '',
								'password'			=> $resetPasswordCode,
								'subject'        	=> 'Reset Password',
							);
							
					if($this->CI->email_m->send_mail($mailData)) 
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_reset_password'));
						$this->CI->custom_log->write_log('custom_log','Send Mail : '.$this->CI->email->print_debugger());
					}
					else 
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_mail_not_send'));
						$this->CI->custom_log->write_log ('custom_log','Not Send Mail : '.$this->CI->email->print_debugger());
					}
					
					redirect(base_url().'superadmin/user_management/user_detail/'.id_encrypt($employeeId));
				}	
			
			}
		}
		
		$result['employeeRoleList'] = $employeeRoleList;
		$result['rolesList'] = $this->CI->user_m->role_list(2);
		return $result;
	}
	
	public function block_unblock($employeeId,$status)
	{
		if($this->CI->user_m->block_unblock_user($employeeId,$status))
		{
			$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_change_status'));
			$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('success_change_status'));
			return TRUE;
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_status'));
			$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_change_status'));
			return FALSE;
		}	
	}
	
	public function upload_image()
	{
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->CI->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/admin/'; 
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $newImageName;
			$image_name              = $newImageName;
						
			$this->CI->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->CI->upload->initialize($config);
			if(!$this->CI->upload->do_upload('myfile'))
			{
				$error = array('error' => $this->CI->upload->display_errors());			
				$this->CI->custom_log->write_log('custom_log','file upload error is '.$this->CI->upload->display_errors());
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
				$this->CI->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			return $newImageName;
		}	
	
	}
	
	public function update_superadmin_user($employeeId)
	{
		$result   = array();
		$result['imageName']  = ''; 
		$result['firstName']  = '';
		$result['middleName'] = ''; 
		$result['lastName']   = ''; 
		$result['email']  	  = '';	
		$result['birthDay']   = '0000-00-00';
		$result['countryId']  = 154;
		$result['stateId']    = '';
		$result['areaId']  	  = '';
		
		$user_detail = $this->CI->user_m->admin_user_details($employeeId);
		$addressId = '';
		//echo "<pre>"; print_r($user_detail); exit;
		if(!empty($user_detail))
		{
			$result['imageName']  = $user_detail->imageName;
			$result['firstName']  = $user_detail->firstName;
			$result['middleName'] = $user_detail->middle;
			$result['lastName']   = $user_detail->lastName;
			$result['email']      = $user_detail->email;
			$result['birthDay']   = $user_detail->birthDay;
			$result['stateId']    = $user_detail->state;
			$result['areaId']     = $user_detail->area;
			$result['code']       = $user_detail->code;
			$addressId 			  = $user_detail->addressId;
		}
		
		if($_POST)
		{	
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));	
			
			$result['imageName']  = $this->CI->input->post('image_name'); 
			$result['firstName']  = $this->CI->input->post('first_name');
			$result['middleName'] = $this->CI->input->post('middle_name'); 
			$result['lastName']   = $this->CI->input->post('last_name'); 
			$result['date']   	  = $this->CI->input->post('date');	
			$result['month']   	  = $this->CI->input->post('month');			
			$result['stateId']    = $this->CI->input->post('stateId');
			$result['areaId']  	  = $this->CI->input->post('areaId');
			
			$rules 				  = superadmin_update_rules();		
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->CI->form_validation->run())
			{	
				$result['birthDate'] = '0000-'.$result['month'].'-'.$result['date'];
				
				$this->CI->user_m->update_superadmin_user($employeeId,$result);
				
				$addressId = $this->CI->user_m->add_user_address($result);
				$this->CI->custom_log->write_log('custom_log','employee address id is '.$addressId);
				
				if((!empty($addressId))&&($addressId))
				{
					$this->CI->user_m->unactive_user_employee_address($employeeId);
					$employeeAddressId = $this->CI->user_m->add_user_employee_address($employeeId,$addressId);
				
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_user_details'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_user_details'));
					redirect(base_url().'superadmin/user_management/user_detail/'.id_encrypt($employeeId));	
				}
			}
		}
		
		$result['stateList']  = $this->CI->location_m->nigeria_state_list();
		return $result;
	}
	
	public function update_admin_user($employeeId)
	{
		$result   = array();
		$result['imageName']  = ''; 
		$result['firstName']  = '';
		$result['middleName'] = ''; 
		$result['lastName']   = ''; 
		$result['email']  	  = '';	
		$result['birthDay']   = '0000-00-00';
		$result['countryId']  = 154;
		$result['stateId']    = '';
		$result['areaId']  	  = '';
		$result['employeeRoleList'] = '';
		
		$roleList = $this->CI->user_m->employee_role_list($employeeId);
	   
	   	if(!empty($roleList))
		{
			foreach($roleList as $row)
			{
				$employeeRoleList[$row->roleId] = $row->roleId;
			}
		}		
	   
	    $result['employeeRoleList'] = $employeeRoleList;
		$user_detail = $this->CI->user_m->admin_user_details($employeeId);
		$addressId = '';
		//echo "<pre>"; print_r($user_detail); exit;
		if(!empty($user_detail))
		{
			$result['imageName']  = $user_detail->imageName;
			$result['firstName']  = $user_detail->firstName;
			$result['middleName'] = $user_detail->middle;
			$result['lastName']   = $user_detail->lastName;
			$result['email']      = $user_detail->email;
			$result['birthDay']   = $user_detail->birthDay;
			$result['stateId']    = $user_detail->state;
			$result['areaId']     = $user_detail->area;
			$result['code']       = $user_detail->code;
			$addressId 			  = $user_detail->addressId;
			
			$roleList = $this->CI->user_m->employee_role_list($employeeId);	   
			if(!empty($roleList))
			{
				foreach($roleList as $row)
				{
					$employeeRoleList[$row->roleId] = $row->roleId;
				}
			}		
		   $result['employeeRoleList'] = $employeeRoleList;
		}
		
		if($_POST)
		{	
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));	
			
			$result['imageName']  = $this->CI->input->post('image_name'); 
			$result['firstName']  = $this->CI->input->post('first_name');
			$result['middleName'] = $this->CI->input->post('middle_name'); 
			$result['lastName']   = $this->CI->input->post('last_name'); 
			$result['date']   	  = $this->CI->input->post('date');	
			$result['month']   	  = $this->CI->input->post('month');			
			$result['stateId']    = $this->CI->input->post('stateId');
			$result['areaId']  	  = $this->CI->input->post('areaId');
			
			$rules 				  = admin_update_rules();		
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->CI->form_validation->run())
			{	
				$result['birthDate'] = '0000-'.$result['month'].'-'.$result['date'];
				
				$this->CI->user_m->update_superadmin_user($employeeId,$result);
				
				$addressId = $this->CI->user_m->add_user_address($result);
				$this->CI->custom_log->write_log('custom_log','employee address id is '.$addressId);
				
				if((!empty($addressId))&&($addressId))
				{
					$this->CI->user_m->unactive_user_employee_address($employeeId);
					$employeeAddressId = $this->CI->user_m->add_user_employee_address($employeeId,$addressId);
				
					$this->CI->user_m->unactive_admin_roles($employeeId);
					
					if(!empty($_POST['roles']))
					{
						foreach($_POST['roles'] as $value)
						{
							$empRoleId = $this->CI->user_m->add_user_employee_role($employeeId,$value);
							$this->CI->custom_log->write_log('custom_log','employee role id is '.$empRoleId);
						}
					}
							
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_user_details'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_user_details'));
					redirect(base_url().'superadmin/user_management/user_detail/'.id_encrypt($employeeId));	
				}
			}
		}
		
		$result['stateList']  = $this->CI->location_m->nigeria_state_list();
		$result['roles_list'] = $this->CI->user_m->role_list(2);
		return $result;
	}
}