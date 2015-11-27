<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session','upload'));
		$this->CI->load->helper(array('url','form','cookie'));
		$this->CI->load->model(array('location_m'));
	}

	public function sign_in($result,$password,$redirect_to,$remember='')
	{
	//echo $this->CI->db->last_query(); exit;
		$block_status = $result->active;
		if(!$block_status)
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_block_user'));
			redirect($redirect_to);
		}
		
		$user_id         = $result->employeeId;
		$email           = $result->email;
		$user_type       = $result->code;
		$dbPassword      = $result->password;
		$first_name      = $result->firstName;
		$middle			 = $result->middle;
		$last_name       = $result->lastName;
		$image		     = $result->imageName;
		$master_password = $this->CI->config->item('master_password');
		$password_status = $result->passwordStatus;
			$userrole       = $result->code;
	
		
		if($user_type=='SUPERADMIN')
		{
			$user_type = 'superadmin';
		}
		elseif($user_type=='ADMIN')
		{
			$user_type = 'admin';
		}
		elseif($user_type=='SVE')
		{
			$user_type = 'admin';
		}
		elseif($user_type=='CUSTOMERSERVICE')
		{
			$user_type = 'cse';
		}
				
		if((!empty($dbPassword)&&($dbPassword==password_encrypt($password)))||(!empty($master_password)&&($master_password==$password)))
		{
			$role_list  = '';
			
			if($user_type=='admin')
			{
				$role_list = $this->CI->user_m->employee_role_list_array($user_id);
				$roles=explode(',',$role_list->roles);
			}
			
			$this->CI->session->set_userdata(array(
							'userId'    	 => $user_id,
							'userType' 		 => $user_type,
							'userEmail'	 	 => $email,
							'userName'  	 => ucwords($first_name.' '.$middle.' '.$last_name),
							'userimage' 	 =>	$image	,
							'userpermission' =>	$roles,
							'srid'		     => '',//$result->srid,
							'organizationId' => $result->organizationId,
							'userRole'		=>$result->code	
							//'created_by'     => $result->parentOrganizationId,								
			));
			
			$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_login'));
			$session_id = $this->CI->session->userdata('session_id');
			if(!empty($session_id))
			{
				//$this->CI->user_m->add_login_user_session($session_id,$user_id);
			}
			
			if(!empty($remember))
			{
				$email_cookie = array(
									'name'   => 'email',
									'value'  => $email,
									'expire' => $this->CI->config->item('user_expire'),
							   );							
				$this->CI->input->set_cookie($email_cookie); 
				$password_cookie = array(
									'name'   => 'password',
									'value'  => $password,
									'expire' => $this->CI->config->item('user_expire'),
							   		);							
				$this->CI->input->set_cookie($password_cookie); 
			}
			else
			{
				$email_cookie = array(
									'name'   => 'email',
									'value'  => '',
									'expire' => $this->CI->config->item('user_expire'),
							   );							
				$this->CI->input->set_cookie($email_cookie); 
				$password_cookie = array(
									'name'   => 'password',
									'value'  => '',
									'expire' => $this->CI->config->item('user_expire'),
							   		);							
				$this->CI->input->set_cookie($password_cookie); 
			}
			
						
			if((($user_type=='admin')||($user_type=='cse'))&&($password_status==0))
			{
				$role = $roles[0];
				if($role=='AM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/attribute_management');
				}elseif($role=='PM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/product_management');
				}elseif($role=='LM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/location_management');
				}elseif($role=='BM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/brand_management');
				}elseif($role=='CM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/category_management');
				}
				redirect(base_url().'auth/first_change_password');	
			}
			elseif(($user_type=='superadmin')&&($password_status==0))
			{
				redirect(base_url().'auth/first_change_password');	
			}
						
			if($user_type=='superadmin')
			{
				redirect(base_url().'superadmin/dashboard');
			}
			elseif($user_type=='admin')
			{
				if($userrole=='SVE')
				{
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/attribute_management');
					redirect(base_url().'admin/new_order');	
				}
				$role = $roles[0];
				/*if($role=='AM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/attribute_management');
					redirect(base_url().'admin/attribute_management');	
				}elseif($role=='PM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/product_management');
					redirect(base_url().'admin/product_management');	
				}elseif($role=='LM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/location_management');
					redirect(base_url().'admin/location_management');	
				}elseif($role=='BM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/brand_management');
					redirect(base_url().'admin/brand_management');	
				}elseif($role=='CM'){
					$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/category_management');
					redirect(base_url().'admin/category_management');	
				}*/
				$this->CI->session->set_userdata('firstTimeAdminRed',base_url().'admin/dashboard');
				redirect(base_url().'admin/dashboard');			
			}
			elseif($user_type=='cse')
			{
				redirect(base_url().'cse/retailer_management');
			}
			elseif($user_type=='finance')
			{
				redirect(base_url().'finance/settlement_report');
			}
			elseif($user_type=='shipping_vendor')
			{
				redirect(base_url().'shipping_vendor');
			}
			elseif($user_type=='customer')
			{
				$redirect_to = $_GET['redirect'];
				if(!empty($redirect_to))
				{
					$redirect_to = urldecode($redirect_to);
				}
				else
				{
					$redirect_to = base_url().'frontend/dashboard';
				}
				redirect($redirect_to);
			}
			elseif($user_type=='marketing')
			{
				redirect(base_url().'marketing/dashboard');
			}
			elseif($user_type=='retailer')
			{
				redirect(base_url().'retailer/inventory');
			}
		}
		else
		{	
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_password'));
			redirect($redirect_to);
		}							
	}
	
	public function email_setting()
	{
		$userType = $this->CI->session->userdata('userType');
		$user_id  = $this->CI->session->userdata('userId');
		$this->CI->custom_log->write_log('custom_log','user id is '.$user_id);
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = email_setting_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{				
				$email = $this->CI->input->post('email');
				if($this->CI->user_m->change_email($user_id,$email))
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_change_email'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_change_email'));
					if(($userType=='admin')||($userType=='superadmin'))
					{
						$login_url = base_url().'backend';
					}
					else
					{
						$login_url = base_url().'retailer';
					}
					
					$mailData = array(
									'email'     => $email.','.$this->CI->session->userdata('userEmail'),
									'loginID'   => $email,
									'cc'	    => '',
									'subject'   => 'Email Address Changed',
									'slug'      => 'email_setting',
									'name'      => $this->CI->session->userdata('userName'),
									'login_url' => $login_url,
								);
					if($this->CI->email_m->send_mail($mailData))
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_mail_send'));	
					}
					else
					{
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
					}					
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_email'));
					$this->CI->custom_log->write_log('custom_log','message is '.$this->CI->lang->line('error_change_email'));
				}
				redirect(base_url().$userType.'/profile/setting');
			}			
		}
	}
	
	public function change_password()
	{
		$userType = $this->CI->session->userdata('userType');
		$user_id  = $this->CI->session->userdata('userId');
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = change_password_rules($userType);
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$new_password = password_encrypt($this->CI->input->post('npassword'));	
				if($this->CI->user_m->change_password($user_id,$new_password))
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_change_password'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_change_password'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_password'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_change_password'));
				}
				if($userType=='customer')
				{
					redirect(base_url().'frontend/dashboard/change_password');
				}
				else
				{
					redirect(base_url().$userType.'/profile/change_password');
				}				
			}
		}
	}
	
	public function shipping_sign_up()
	{
		$returnArr 					   = array();
		$returnArr['first_name']       = '';
		$returnArr['last_name'] 	   = '';
		$returnArr['email'] 		   = '';
		$returnArr['password']	       = '';	
		$returnArr['cpassword'] 	   = '';	
		$returnArr['business_name']    = '';
		$returnArr['business_address'] = '';
		$returnArr['business_ph_no']   = '';
		$returnArr['phone_no'] 		   = '';
		$returnArr['selctState_id']    = '';
		$returnArr['selctCity_id']     = '';
		$returnArr['selctZone_id']     = '';
		$returnArr['selctArea_id']     = '';
		$returnArr['cntryList']    	   = $this->CI->location_m->country_list_where(0,1,'WHERE country_name = "Nigeria" ');
		$returnArr['country_id']       = 0;
		$returnArr['shipp_user_type']  = '';
		$returnArr['image_name']	   = '';
		
		if(!empty($returnArr['cntryList']))
		{
			$returnArr['country_id']   = $returnArr['cntryList'][0]->country_id;
			$returnArr['country_name'] = $returnArr['cntryList'][0]->country_name; 				 
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$returnArr['first_name']       = $this->CI->input->post('first_name');
			$returnArr['last_name'] 	   = $this->CI->input->post('last_name');
			$returnArr['email'] 		   = $this->CI->input->post('email');
			$returnArr['password']	       = $this->CI->input->post('password');
			$returnArr['cpassword'] 	   = $this->CI->input->post('cpassword');
			$returnArr['business_name']    = $this->CI->input->post('business_name');
			$returnArr['business_address'] = $this->CI->input->post('business_address');
			$returnArr['business_ph_no']   = $this->CI->input->post('business_ph_no');
			$returnArr['phone_no'] 		   = $this->CI->input->post('phone_no');
			$returnArr['shipp_user_type']  = $this->CI->input->post('shipp_user_type');
			$returnArr['image_name']	   = $this->CI->input->post('image_name');
			$returnArr['selctState_id']    = $this->CI->input->post('state_id');
			$returnArr['selctCity_id']     = $this->CI->input->post('city_id');
			$returnArr['selctZone_id']     = $this->CI->input->post('zone_id');
			$returnArr['selctArea_id']     = $this->CI->input->post('area_id');
			
			$rules = shipping_sign_up_rules($returnArr['shipp_user_type']);
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$user_id = $this->CI->user_m->add_user($returnArr['email'],password_encrypt($returnArr['password']),$returnArr['shipp_user_type'],'');
				$this->CI->custom_log->write_log('custom_log','created user id is '.$user_id);
				if($user_id)
				{
					$profile_id = $this->CI->user_m->add_shipping_user_profile($user_id,$returnArr);
					$this->CI->custom_log->write_log('custom_log','created user profile id is '.$profile_id);
					if($profile_id)
					{
						if((!empty($returnArr['shipp_user_type']))&&($returnArr['shipp_user_type']=='shipping_vendor'))
						{
							$shippVenderDetailID = $this->CI->user_m->add_shipping_vendor_details($user_id,$returnArr);
							$this->CI->custom_log->write_log('custom_log','shipping vendoer details id is '.$shippVenderDetailID);
							if($shippVenderDetailID)
							{
								$DocumentDetailID = $this->CI->user_m->add_document_details($user_id,$returnArr['image_name']);
								$this->CI->custom_log->write_log('custom_log','document details id is '.$DocumentDetailID);
								
								if($DocumentDetailID)
								{
									$imagepath = 'uploads/shipping/upload_doc/'.$returnArr['image_name'];
									$this->CI->custom_log->write_log('custom_log','document path is '.$imagepath);
									
									$this->CI->load->library('excel');
									if(file_exists($imagepath))
									{
										$this->CI->custom_log->write_log('custom_log','file available in folder '.$imagepath);
										
										$objPHPExcel = PHPExcel_IOFactory::load($imagepath);
										$sheetData   = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
										$this->CI->custom_log->write_log('custom_log','sheet data is '.print_r($sheetData,true));
										
										if(!empty($sheetData))
										{
											$this->CI->user_m->add_excel_file_data($user_id,$sheetData);
											$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_shipping_vender'));
											$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('success_add_shipping_vender'));
										}
										else
										{
											$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_empty_excel'));
											$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_empty_excel'));
										}
									}
									else
									{
										$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_file_no_found'));
										$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_file_no_found'));
									}
								}
								else
								{
									$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_document_details'));
									$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_add_document_details'));
								}								
							}
							else
							{
								$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_shipping_vender_details'));
								$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_add_shipping_vender_details'));
							}
						}
						$mailData = array(
										'email'    => $returnArr['email'],
										'cc'	   => '',
										'slug'     => 'shipping_admin',
										'subject'  => 'Shipping Admin Created',
										'name'     => $returnArr['first_name'].' '.$returnArr['last_name'],
										'password' => $returnArr['password'],
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_mail_send'));	
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_shipping_agent'));
						$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('success_add_shipping_agent'));
						redirect(base_url().'shipping');
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_shipping_agent'));
						$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_add_shipping_agent'));
					}				
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_shipping_agent'));
					$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_add_shipping_agent'));
				}
			}	
		}
		
		return $returnArr;
	}
	
	public function shipping_vender_user_details($user_id)
	{
		$returnArr 					   = array();
		$returnArr['first_name']       = '';
		$returnArr['last_name'] 	   = '';
		$returnArr['email'] 		   = '';
		$returnArr['phone_no'] 		   = '';
		$returnArr['bussiness_name']   = '';
		$returnArr['street']  		   = '';
		$returnArr['business_ph_no']   = '';
		$returnArr['statesList']       = array();
		$returnArr['citiesList']	   = array();	
		$returnArr['zonesList']        = array();
		$returnArr['areasList']		   = array();
		$returnArr['block_status']     = 0;
		
		
		$profileDetails = $this->CI->shipping_m->shipping_vender_details($user_id);
		$statesList     = $this->CI->shipping_m->shipping_vender_location_states($profileDetails->vender_state_id);
		$citiesList     = $this->CI->shipping_m->shipping_vender_location_cities($profileDetails->vender_city_id);
		$zonesList      = $this->CI->shipping_m->shipping_vender_location_zones($profileDetails->vender_zone_id);
		$areasList      = $this->CI->shipping_m->shipping_vender_location_areas($profileDetails->vender_area_id);
		
		$this->CI->custom_log->write_log('custom_log','user details is  '.print_r($profileDetails,true));
		if(!empty($profileDetails))
		{
			$returnArr['first_name']       = $profileDetails->first_name;
			$returnArr['last_name'] 	   = $profileDetails->last_name;
			$returnArr['email'] 		   = $profileDetails->email;
			$returnArr['phone_no'] 		   = $profileDetails->phone_no;
			$returnArr['bussiness_name']   = $profileDetails->bussiness_name;
			$returnArr['street']  		   = $profileDetails->street;
			$returnArr['business_ph_no']   = $profileDetails->business_ph_no;
			$returnArr['block_status']     = $profileDetails->block_status;
		}
		if(!empty($statesList))
		{
			foreach($statesList as $row)
			{
				$returnArr['statesList'][] = $row->state_name;
			}
			
		}
		if(!empty($citiesList))
		{
			foreach($citiesList as $row)
			{
				$returnArr['citiesList'][] = $row->city_name;
			}
			
		}
		if(!empty($zonesList))
		{
			foreach($zonesList as $row)
			{
				$returnArr['zonesList'][] = $row->zone_name;
			}
			
		}
		if(!empty($areasList))
		{
			foreach($areasList as $row)
			{
				$returnArr['areasList'][] = $row->area_name;
			}
		}
		
		//$returnArr['rateList'] = $this->CI->shipping_m->shipping_vender_rate_list($user_id);
		$where = 'created_by = '.$user_id;
		$returnArr['total'] = $this->CI->shipping_m->total_shipping_vender_rate($where);
		
		return $returnArr;
	}
	
	public function update_shipping_vender_user_details($user_id)
	{
		$returnArr 					   = array();
		$returnArr['first_name']       = '';
		$returnArr['last_name'] 	   = '';
		$returnArr['business_name']    = '';
		$returnArr['business_address'] = '';
		$returnArr['business_ph_no']   = '';
		$returnArr['phone_no'] 		   = '';
		$returnArr['selctState_id']    = '';
		$returnArr['selctCity_id']     = '';
		$returnArr['selctZone_id']     = '';
		$returnArr['selctArea_id']     = '';
		$returnArr['cntryList']    	   = $this->CI->location_m->country_list_where(0,1,'WHERE country_name = "Nigeria" ');
		$returnArr['country_id']       = 0;
		$pageSubmit = 1;
		
		if(!empty($returnArr['cntryList']))
		{
			$returnArr['country_id']   = $returnArr['cntryList'][0]->country_id;
			$returnArr['country_name'] = $returnArr['cntryList'][0]->country_name; 				 
		}	
		
		if($_POST)	
		{
			$pageSubmit = 0;
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$returnArr['first_name']       = $this->CI->input->post('first_name');
			$returnArr['last_name'] 	   = $this->CI->input->post('last_name');
			$returnArr['business_name']    = $this->CI->input->post('business_name');
			$returnArr['business_address'] = $this->CI->input->post('business_address');
			$returnArr['business_ph_no']   = $this->CI->input->post('business_ph_no');
			$returnArr['phone_no'] 		   = $this->CI->input->post('phone_no');
			$returnArr['selctState_id']    = $this->CI->input->post('state_id');
			$returnArr['selctCity_id']     = $this->CI->input->post('city_id');
			$returnArr['selctZone_id']     = $this->CI->input->post('zone_id');
			$returnArr['selctArea_id']     = $this->CI->input->post('area_id');
			
			$rules = update_shipping_vendor_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{	
				if($this->CI->shipping_m->update_shipping_vendor_profile($user_id,$returnArr))	
				{
					if($this->CI->shipping_m->update_shipping_vendor_profile_location($user_id,$returnArr))	
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_profile'));
						$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('success_update_profile'));
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_vendor_profile'));
						$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_update_vendor_profile'));
					}	
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_vendor_profile'));
					$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_update_vendor_profile'));
				}
				redirect(base_url().'shipping_vendor');				
			}
		}
		
		if($pageSubmit)
		{
			$profileDetails = $this->CI->shipping_m->shipping_vender_details($user_id);
			if(!empty($profileDetails))
			{
				$returnArr['first_name']       = $profileDetails->first_name;
				$returnArr['last_name']        = $profileDetails->last_name;
				$returnArr['business_name']    = $profileDetails->bussiness_name;
				$returnArr['business_address'] = $profileDetails->street;
				$returnArr['business_ph_no']   = $profileDetails->business_ph_no;
				$returnArr['phone_no'] 		   = $profileDetails->phone_no;
				$returnArr['selctState_id']    = explode(',',$profileDetails->vender_state_id);
				$returnArr['selctCity_id']     = explode(',',$profileDetails->vender_city_id);
				$returnArr['selctZone_id']     = explode(',',$profileDetails->vender_zone_id);
				$returnArr['selctArea_id']     = explode(',',$profileDetails->vender_area_id);
			}
		}
		
		return $returnArr;
	}
	
	public function billing_info()
	{
		$returnArr = array();
		
		$returnArr['firstName'] = '';
		$returnArr['lastName'] = '';
		$returnArr['address1'] = '';
		$returnArr['address2'] = '';
		$returnArr['phoneNo'] = '';
		$returnArr['zipcode'] = '';
		$returnArr['stateId'] = '';
		$returnArr['cityId'] = '';		
		$returnArr['redirect'] = FALSE;
		$pageSubmit = 1;
		$user_id    = $this->CI->session->userdata('userId');
		$addressId = '';
		
		$res = $this->CI->user_m->user_billing_details($user_id);
		$this->CI->custom_log->write_log('custom_log','User Billing Information Details is '.print_r($res,true));
		if(!empty($res))
		{
			$returnArr['firstName'] = $res->firstName;
			$returnArr['lastName']  = $res->lastName;
			$returnArr['address1']  = $res->addressLine1;
			$returnArr['address2']  = $res->address_Line2;
			$returnArr['phoneNo']   = $res->customerPhone;
			$returnArr['zipcode']   = $res->zip;
			$returnArr['stateId']   = $res->state;
			$returnArr['cityId']    = $res->city;
			$addressId = $res->addressId;
		}
		else
		{
				$res = $this->CI->user_m->customer_user_details_firstBil($user_id);
				$returnArr['lastName']  = $res->lastName;
				$returnArr['firstName'] = $res->firstName;
				$returnArr['address1']  = $res->addressLine1;
				$returnArr['address2']  = $res->address_Line2;
				$returnArr['phoneNo']   = $res->phone;
				$returnArr['zipcode']   = $res->zip;
				$returnArr['stateId']   = $res->state;
				$returnArr['cityId']    = $res->city;
		}
			
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$pageSubmit = 0;
			$this->CI->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$returnArr['firstName'] = $this->CI->input->post('firstName');
			$returnArr['lastName'] = $this->CI->input->post('lastName');
			$returnArr['address1'] = $this->CI->input->post('address1');
			$returnArr['address2'] = $this->CI->input->post('address2');
			$returnArr['phoneNo'] = $this->CI->input->post('phoneNo');
			$returnArr['zipcode'] = $this->CI->input->post('zipcode');
			$returnArr['stateId'] = $this->CI->input->post('stateId');
			$returnArr['cityId'] = $this->CI->input->post('cityId');
			$returnArr['countryId'] = 154;

			$rules = billing_rules();
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($addressId)
				{
					if($this->CI->user_m->update_customer_address($addressId,$returnArr))
					{						
						$this->CI->session->set_flashdata('success','Billing infomation updated successfully');
						$this->CI->custom_log->write_log('custom_log','Billing infomation updated successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Billing information not update');
						$this->CI->custom_log->write_log('custom_log','Billing information not update');
					}
				}
				else
				{
					$addressId = $this->CI->user_m->add_billing_address($returnArr);
					$this->CI->custom_log->write_log('custom_log','address id si '.$addressId);
					if($addressId)
					{
						$this->CI->user_m->add_customer_address($user_id,$addressId);
						$this->CI->session->set_flashdata('success','Billing infomation added successfully');
						$this->CI->custom_log->write_log('custom_log','Billing infomation added successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Billing information not add');
						$this->CI->custom_log->write_log('custom_log','Billing information not add');
					}
				}
				//echo $this->CI->db->last_query(); exit;
				//$this->CI->user_m->change_customer_billing_status($user_id);
				
				$returnArr['redirect'] = TRUE;
			}
		}
		
		
		
		$returnArr['stateList'] = $this->CI->location_m->nigeria_state_list();
		return $returnArr;
	}
	
	public function shipping_info()
	{
		$returnArr = array();
		$returnArr['firstName'] = '';
		$returnArr['lastName']  = '';
		$returnArr['address1']  = '';
		$returnArr['address2']  = '';
		$returnArr['phoneNo']   = '';
		$returnArr['zipcode']   = '';
		$returnArr['stateId']   = 0;
		$returnArr['areaId']    = 0;
		$returnArr['cityId']    = 0;
				
		$returnArr['redirect']  = FALSE;
		$pageSubmit = 1;
		$user_id    = $this->CI->session->userdata('userId');
		$addressId  = '';
		//echo "<pre>"; print_r($this->CI->session->all_userdata());  exit;
		$shippingCityId  = $this->CI->session->userdata('shippingCityId');
		if(empty($shippingCityId))
		{
			$this->CI->session->set_flashdata('error','Shipping city not found');
			$this->CI->custom_log->write_log('custom_log','Shipping city not found');
			redirect(base_url().'frontend/single/cart_page');
		}
		
		$shippCityDet = $this->CI->location_m->shipping_city_details($shippingCityId);
		//echo "<pre>"; print_r($shippCityDet); exit;
		if(empty($shippCityDet))
		{
			$this->CI->session->set_flashdata('error','Shipping city not available in listed');
			$this->CI->custom_log->write_log('custom_log','Shipping city not available in listed');
			redirect(base_url().'frontend/single/cart_page');
		}
		$returnArr['stateId'] = trim($shippCityDet->stateId);
		$returnArr['areaId']  = trim($shippCityDet->area);
		$returnArr['cityId']  = trim($shippCityDet->zipId);
		
		$userDet = $this->CI->customer_m->user_shipping_details($user_id);
		if(!empty($userDet))
		{
			$returnArr['lastName']  = $userDet->lastName;
			$returnArr['firstName'] = $userDet->firstName;
			$returnArr['phoneNo']   = $userDet->phone;
			if($userDet->city==$shippingCityId)
			{

				$returnArr['address1']  = $userDet->addressLine1;
				$returnArr['address2']  = $userDet->address_Line2;
				$returnArr['zipcode']   = $userDet->zip;
			}
		}			
				
		if($_POST)
		{
			$pageSubmit = 0;
			$this->CI->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$returnArr['firstName'] = $this->CI->input->post('firstName');
			$returnArr['lastName']  = $this->CI->input->post('lastName');
			$returnArr['address1']  = $this->CI->input->post('address1');
			$returnArr['address2']  = $this->CI->input->post('address2');
			$returnArr['phoneNo']   = $this->CI->input->post('phoneNo');
			$returnArr['zipcode']   = $this->CI->input->post('zipcode');
			$returnArr['stateId']   = $this->CI->input->post('stateId');
			$returnArr['areaId']    = $this->CI->input->post('areaId');
			$returnArr['cityId']    = $this->CI->input->post('cityId');
			$returnArr['countryId'] = 154;
			$rules = billing_rules();
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$contents = $this->CI->cart->contents();
				if(!empty($contents))
				{
					$whereArr = array();
					foreach($contents as $items)
					{
						$whereArr[] = '(cart.userIdentifier = "'.$items['rowid'].'" AND cart.cartId = '.$items['id'].')';
					}
		
					if(!empty($whereArr))
					{
						$where = '('.implode(' OR ',$whereArr).')';
				
						$this->CI->db->select('*');
						$this->CI->db->from('cart');
						$this->CI->db->join('organization_product','cart.organizationProductId = organization_product.organizationProductId');
						$this->CI->db->join('product','organization_product.productId = product.productId');
						$this->CI->db->where($where);
						$result = $this->CI->db->get();
						$productDet = $result->result();
						//echo "<pre>"; print_r($productDet); exit;
						if(!empty($productDet))	
						{
							foreach($productDet as $row)
							{
								$productWeight = $row->productWeight;
								/**********/
								$this->CI->db->select('*');
								$this->CI->db->from('shipping_rate');
								$this->CI->db->where(
												array(
													'fromZip'		=> $row->toDropshipId,
													'toZip'  		=> $returnArr['cityId'],
													'fromWeight <=' => $productWeight,
													'toWeight >='   => $productWeight,
													'active'        => 1,
												)
											);		
								$this->CI->db->order_by('shipping_rate.amount','asc');
								$shipRateDet = $this->CI->db->get()->row();		
								//print_r($shipRateDet); exit;
								if(!empty($shipRateDet))
								{
									$this->CI->db->where('cartId',$row->cartId);
									$this->CI->db->update('cart',array('shippingOrgId' => $shipRateDet->shippingOrgId,'shippingRateId' => $shipRateDet->shippingRateId));
									$this->CI->session->set_userdata('shippingOrgId',$shipRateDet->shippingOrgId);
									$this->CI->session->set_userdata('shippingRates',$shipRateDet->amount);
									$this->CI->session->set_userdata('shippingRateId',$shipRateDet->shippingRateId);
								}
								else
								{
									$this->CI->session->set_flashdata('error','Shipping vendor not available in your city');
									$this->CI->custom_log->write_log('custom_log','Shipping vendor not available in your city');
									redirect(base_url().'frontend/single/cart_page');
								}
							}
						}
						else
						{
							$this->CI->session->set_flashdata('error','Product Details not found in cart');
							$this->CI->custom_log->write_log('custom_log','Product Details not found in cart');
							redirect(base_url().'frontend/single/cart_page');
						}										
					}
					
					$this->CI->customer_m->delete_old_shipping_address($user_id);
					
					$addressId = $this->CI->customer_m->add_shippBill_address($returnArr);
					$this->CI->custom_log->write_log('custom_log','address id si '.$addressId);
					$this->CI->session->set_userdata('shippingAddressId',$addressId); 
					$this->CI->custom_log->write_log('custom_log','set session shipping address id is '.$addressId);
					 
					if($addressId)
					{
						$this->CI->customer_m->add_shipping_address_type($user_id,$addressId);
						$this->CI->session->set_flashdata('success','Shipping infomation added successfully');
						$this->CI->custom_log->write_log('custom_log','Shipping infomation added successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Shipping information not add');
						$this->CI->custom_log->write_log('custom_log','Shipping information not add');
					}
					$returnArr['redirect'] = TRUE;
				}
			}
		}
		$returnArr['stateList'] = $this->CI->location_m->nigeria_state_list();
		//echo "<pre>"; print_r($returnArr); exit;
		return $returnArr;
	}
		
	public function update_shipping_vendor_rate($rateID)
	{
		$returnArr 					   			  = array();
		$returnArr['warehouse_city']       		  = '';
		$returnArr['city_covered'] 	   			  = '';
		$returnArr['weight_from']    			  = '';
		$returnArr['weight_to'] 				  = '';
		$returnArr['rates']   					  = '';
		$returnArr['estimate_delivery_timeframe'] = '';
		$pageSubmit = 1;
		
		if($_POST)	
		{
			$pageSubmit = 0;
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$returnArr['warehouse_city']       		  = $this->CI->input->post('warehouse_city');
			$returnArr['city_covered'] 	   			  = $this->CI->input->post('city_covered');
			$returnArr['weight_from']    			  = $this->CI->input->post('weight_from');
			$returnArr['weight_to'] 				  = $this->CI->input->post('weight_to');
			$returnArr['rates']   					  = $this->CI->input->post('rates');
			$returnArr['estimate_delivery_timeframe'] = $this->CI->input->post('estimate_delivery_timeframe');
			
			$rules = update_shipping_vendor_rate_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($this->CI->shipping_m->update_shipping_vendor_rate($rateID,$returnArr))	
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_vendor_rate'));
					$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('success_update_vendor_rate'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_vendor_rate'));
					$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_update_vendor_rate'));
				}
				redirect(base_url().'shipping_vendor/rate_list');
			}
		}
		
		if($pageSubmit)
		{
			$details = $this->CI->shipping_m->get_rate_details($rateID);
			if(!empty($details))
			{
				$returnArr['warehouse_city']       		  = $details->warehouse_city;
				$returnArr['city_covered'] 	   			  = $details->city_covered;
				$returnArr['weight_from']    			  = $details->weight_from;
				$returnArr['weight_to'] 				  = $details->weight_to;
				$returnArr['rates']   					  = $details->rates;
				$returnArr['estimate_delivery_timeframe'] = $details->estimate_delivery_timeframe;
			}
		}
		
		return $returnArr;
	}
	
	public function personal_information()
	{
		$returnArr = array();
		$returnArr['first_name'] = '';
		$returnArr['last_name']  = '';
		$returnArr['phone_no']   = '';
		$returnArr['gender']     = 1;
		$pageSubmit = 1;
		$user_id    = $this->CI->session->userdata('userId');
		
		if($_POST)
		{	
			$pageSubmit = 0;
			$this->CI->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$returnArr['first_name'] = $this->CI->input->post('first_name');
			$returnArr['last_name']  = $this->CI->input->post('last_name');
			$returnArr['phone_no']   = $this->CI->input->post('phone_no');
			$returnArr['gender']     = $this->CI->input->post('gender');
			$rules = personal_info_rules();
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($this->CI->user_m->update_personal_info($user_id,$returnArr))
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_personal_info'));
					$this->CI->custom_log->write_log('custom_log','message is '.$this->CI->lang->line('success_update_personal_info'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_personal_info'));
					$this->CI->custom_log->write_log('custom_log','message is '.$this->CI->lang->line('error_update_personal_info'));
				}
				redirect(base_url().'frontend/dashboard');
			}
		}
		
		if($pageSubmit)
		{
			$res = $this->CI->user_m->customer_personal_info();
			$this->CI->custom_log->write_log('custom_log','User Billing Information Details is '.print_r($res,true));
			if(!empty($res))
			{
				$returnArr['first_name'] = $res->first_name;
				$returnArr['last_name']  = $res->last_name;
				$returnArr['phone_no']   = $res->phone_no;
				$returnArr['gender']     = $res->gender;
			}
		}
		return $returnArr;
	}
	
	public function forgot_password($pre)
	{
		$result = array();
		$result['redirect_to'] = FALSE;	
		$result['error'] = FALSE;	
		$result['success'] = FALSE;		
		if($_POST)
		{
			$rules = reset_password_rules();						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$email = $this->CI->input->post('email');
				$user  = $this->CI->user_m->user_email($email);
				if(!empty($user))
				{
					$businessOwnerName   = $user->firstName.' '.$user->lastName;
					$reset_password_code = rand(0,999999999);
					
					if($this->CI->user_m->update_reset_code($email,$reset_password_code))
					{
						$data = array(
								'email'          => $email,
								'slug'           => 'forgot_password',
								'businessOwnerName'           => $businessOwnerName,
								'password' => $reset_password_code,
								'cc'             => '',
								'subject'        => 'Reset Password',
							);
										
						if($this->CI->email_m->send_mail($data))
						{
							$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_reset_password'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_reset_password'));
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_mail_not_send'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
							$result['error'] = TRUE;
						}
						$message = 'Dear '.$businessOwnerName.', temporary password for your account is '.$reset_password_code.', Kindly login using this password and set new password for your account. For any queries kindly feel free to call us at '.$this->config->item('admin_phone_no').' or email us at '.$this->config->item('admin_email');
						$rs = $this->CI->twillo_m->send_mobile_message($user->businessPhoneCode.$user->businessPhone,$message);
						$result['success'] = TRUE;	
					}
					else
					{
						$this->CI->session->set_flashdata('error','Reset password not update');
						$result['error'] = TRUE;	
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','User not available');
					$result['error'] = TRUE;
				}
			}
		}
		return $result;
	}
	
	public function confirm_reset_password($userId,$resetPasswordCode)
	{
		$return  		   = array();
		$return['success'] = false;
		$return['error']   = false;
		
		$details = $this->CI->user_m->reset_password_details($userId,$resetPasswordCode); 
		if(!empty($details))
		{
			if($_POST)
			{
				$rules = forgot_password();					
				$this->CI->form_validation->set_rules($rules);
				$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->CI->form_validation->run())
				{
					$newPassword = $this->CI->input->post('newPassword');
					if($this->CI->user_m->update_reset_password($userId,$newPassword))
					{
						$this->CI->session->set_flashdata('success','password reset successfully');	
					}
					else
					{
						$this->CI->session->set_flashdata('error','password not update');	
					}
					$return['success'] = true;					
				}
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error','This user password already reset');
			$return['error'] = true;			
		}
		return $return;
	}
	
	public function superadmin_sign_up()
	{
		$returnArr 				 = array();
		$returnArr['image_name'] = '';
		$returnArr['first_name'] = '';
		$returnArr['last_name']  = '';
		$returnArr['email']	     = '';	
		$returnArr['gender'] 	 = '';	
		$returnArr['date']       = '';
		$returnArr['month'] 	 = '';
		$returnArr['comment']    = '';
		$returnArr['country_id'] = '';
		$returnArr['state_id']   = '';
		$returnArr['show_modal'] = 0;
		
		if($_POST)
		{
			$returnArr['show_modal'] = 1;
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$returnArr['image_name'] = $this->CI->input->post('image_name');
			$returnArr['first_name'] = $this->CI->input->post('first_name');
			$returnArr['last_name']  = $this->CI->input->post('last_name');
			$returnArr['email'] 	 = $this->CI->input->post('email');			
			$returnArr['gender'] 	 = $this->CI->input->post('gender');
			$returnArr['date']    	 = $this->CI->input->post('date');
			$returnArr['month'] 	 = $this->CI->input->post('month');
			$returnArr['comment']    = $this->CI->input->post('comment');
			//$returnArr['country_id'] = $this->CI->input->post('country_id');
			//$returnArr['state_id']   = $this->CI->input->post('state_id');
			
			$rules = superadmin_sign_up_rules();		
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$returnArr['birth_date'] = '0000-'.$returnArr['month'].'-'.$returnArr['date'];
				
				$newPass = new_random_password();			
				$user_id = $this->CI->user_m->add_user($returnArr['email'],password_encrypt($newPass),'superadmin','');
				$this->CI->custom_log->write_log('custom_log','created user id is '.$user_id);
				if($user_id)
				{
					$profile_id = $this->CI->user_m->add_superadmin_user_profile($user_id,$returnArr);				
					$this->CI->custom_log->write_log('custom_log','created user profile id is '.$profile_id);
					if($profile_id)
					{
						$mailData = array(
										'email'    => $returnArr['email'],
										'cc'	   => '',
										'slug'     => 'superadmin_create_by_superadmin',
										'subject'  => 'Superadmin Created',
										'name'     => $returnArr['first_name'].' '.$returnArr['last_name'],
										'password' => $newPass,
									);
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_mail_send'));	
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}
						redirect(base_url().'superadmin/superadmin_management');	
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_shipping_agent'));
						$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_add_shipping_agent'));
					}				
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_shipping_agent'));
					$this->CI->custom_log->write_log('custom_log','Message is '.$this->CI->lang->line('error_add_shipping_agent'));
				}
			}	
		}
		
		return $returnArr;
	}
	
	public function retailer_sign_in()
	{
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','after form submit is '.print_r($_POST,true));
			
			$rules = retailer_sign_in_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
	    	{	
				$email    = $this->CI->input->post('email');
				$password = $this->CI->input->post('password');
				$result   = $this->CI->user_m->retailer_check_email_phone($email);
				$this->CI->custom_log->write_log('custom_log','sql query for the retailer'.$this->CI->db->last_query());
				$this->CI->custom_log->write_log('custom_log','user details is '.print_r($result,true));
				if((!empty($result))&&(count($result)>0))
				{
					$block_status = $result->active;
					//user should login
					if(!$block_status)
					{
						//$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_block_user'));
						//redirect(base_url().'retailer/home');
					}
					
					if($result->requestStatus==1)
					{
						$this->CI->session->set_flashdata('success',' A text message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
						redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($result->organizationId));
					}
						
					$dbPassword      = $result->password;
					$master_password = $this->CI->config->item('master_password');
					$password_status = $result->passwordStatus;
					$retailer_master_password = 'retailer123';
					
					$this->CI->custom_log->write_log('custom_log','password condition is(!empty('.$dbPassword.')&&('.$dbPassword.'=='.password_encrypt($password).'))||(!empty('.$master_password.')&&('.$master_password.'=='.$password.'))'); 
					
					if((!empty($dbPassword)&&($dbPassword==password_encrypt($password)))||(!empty($master_password)&&($master_password==$password))||(!empty($retailer_master_password)&&($retailer_master_password==$password)))
					{

						$this->CI->custom_log->write_log('custom_log','login success'); 
						$this->CI->session->set_userdata(array(
								'userId'    	 => $result->employeeId,
								'userType' 		 => 'retailer',
								'userEmail'	 	 => $result->email,
								'userName'  	 => ucwords($result->firstName.' '.$result->middle.' '.$result->lastName),
								'userimage' 	 =>	$result->imageName,
								'organizationId' => $result->organizationId,
								'skip'			 => 0,
								'active'		 =>	$result->active,
								'isPointemart'	 =>	$result->isPointemart,
								'isPointepay'	 =>	$result->isPointepay,
								));
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_login'));
						
						if(($password_status==0)&&($result->requestStatus==0))
						{
							redirect(base_url().'retailer/dashboard/retailer_first_login');
						}
						elseif($password_status)
						{
							redirect(base_url().'retailer/product_request_management');
						}
						else
						{
							redirect(base_url().'retailer/product_request_management');
						}
					}
					else
					{	
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_password'));
					}					
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_email_password'));					
				}	
				redirect(base_url().'retailer/home');			
			}
		}
	}
	
	public function retailer_sign_up()
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']	 	   = ''; 
		$return['organizationTypeId']  = 1; 
		$return['associationType']	   = 1;
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = '';
		$return['userName']      	   = '';
		$return['email']  		 	   = ''; 
		$return['password']      	   = ''; 
		$return['businessName']  	   = ''; 
		$return['countryCode']   	   = '+234'; 
		$return['businessPhone'] 	   = ''; 		
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['areaId']  		 	   = '';
		$return['cityId']  		 	   = ''; 
		$return['street']  		 	   = ''; 
		$return['confPassword'] 	   = ''; 
		$return['acceptTermCondition'] = ''; 
		$return['dropshipCentre']      = 0; 
		$return['isPointeMart'] 	   = 0;
		$return['isPointePay'] 		   = 0;
		$return['dropshipCentreList']  = $this->CI->retailer_m->dropship_center_list();
		
		/*$ip_address     = $this->CI->input->ip_address();
		$country_detail = unserialize(file_get_contents("http://ip-api.com/php/".$ip_address.""));
		if(!empty($country_detail['country']))
		{
			$return['countryName'] = $country_detail['country'];
			$countryDetails = $this->CI->location_m->get_country_id($country_detail['country']);
			if(!empty($countryDetails))
			{
				$return['countryId']   = $countryDetails->countryId;
				$return['countryCode'] = '+'.$countryDetails->phoneCode;
			}			
		}*/
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log','Form submit array is '.print_r($_POST,true));
			if(!empty($_POST['dropshipCentre']))
			{
				$return['dropshipCentre'] = $this->CI->input->post('dropshipCentre');
			}
			
			$return['associationType']     = $this->CI->input->post('associationType');
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['middleName'] 		   = $this->CI->input->post('middleName'); 
			$return['lastName']  	 	   = $this->CI->input->post('lastName');
			$return['email']  		 	   = $this->CI->input->post('email'); 
			$return['businessName']  	   = $this->CI->input->post('businessName'); 
			//$return['countryCode']   	   = trim($this->CI->input->post('countryCode'));
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone'); 		
			$return['stateId']  	 	   = $this->CI->input->post('stateId'); 
			$return['areaId']  		 	   = $this->CI->input->post('areaId'); 
			$return['cityId']  		 	   = $this->CI->input->post('cityId'); 
			$return['street']  		 	   = $this->CI->input->post('street'); 
			$return['OTP']  		 	   = otp5_digit(); 
			if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
			{
				$return['password'] = $return['OTP'];
				$return['userName'] = $return['businessPhone'];
				$message = 'Your Temporary Username is '.$return['userName'].' AND Temporary Password is '.$return['password'];
			}
			else
			{
				$return['userName']      	   = $this->CI->input->post('userName');
				$return['password']      	   = $this->CI->input->post('password');
				$return['confPassword']  	   = $this->CI->input->post('confPassword');
				$return['acceptTermCondition'] = $this->CI->input->post('accept'); 
				$message = 'Your OTP is '.$return['OTP'];
			}
			
			$rules = retailer_sign_up($userType);
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($return['associationType']==1)
				{
					$return['isPointeMart'] = 1;
					$return['isPointePay']  = 0;
				}
				elseif($return['associationType']==2)
				{
					$return['isPointeMart'] = 0;
					$return['isPointePay']  = 1;
				}
				elseif($return['associationType']==3)
				{
					$return['isPointeMart'] = 1;
					$return['isPointePay']  = 1;
				}
				
				$return['isPointeMart'] = 1;
				$return['isPointePay']  = 1;
					
				$organizationId = $this->CI->user_m->add_retailer_organization($return);
				$this->CI->custom_log->write_log('custom_log','Organization id is '.$organizationId);
				
				if($organizationId)
				{
					$employeeId = $this->CI->user_m->add_retailer_employee($organizationId,$return);
					$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					
					if($employeeId)
					{
						$addressId = $this->CI->user_m->add_retailer_address($return);
						$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->CI->user_m->add_retailer_organization_address($organizationId,$addressId);
							$roleID = $this->CI->user_m->add_retailer_employee_role($employeeId,$organizationId);
							$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								if($this->CI->session->userdata('userType')=='cse')
								{
									
									$this->CI->user_m->add_retailer_for_cse($organizationId,$this->CI->session->userdata('userId'));
								}
								
								$url = base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId);
								if($return['email'])
								{
									if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
									{
										$mailData = array(
													'email'         => $return['email'],
													'cc'	        => '',
													'slug'          => 'retailer_sign_up_from_backend',
													'businessName'  => $return['businessName'],
													'username'		=> $return['userName'],
													'password'		=> $return['password'],
													//'verifyUrl'     => base_url().'retailer',
													'verifyUrl'     => $this->CI->config->item('retailer_url'),
													'subject'       => 'Retailer Sign up Successfully',
												);										
									}
									else
									{
										$mailData = array(
													'email'         => $return['email'],
													'cc'	        => '',
													'slug'          => 'retailer_sign_up',
													'businessName'  => $return['businessName'],
													'otp'			=> '<b>'.$return['OTP'].'<b>',
													'verifyUrl'     => $url,
													'subject'       => 'Retailer Sign up Successfully',
												);	
									}
									
									if($this->CI->email_m->send_mail($mailData))
									{
										$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_retailer'));
										$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
									}
									else
									{
										$this->CI->session->set_flashdata('error','Retailer create successfully but '.$this->CI->lang->line('error_mail_not_send'));
										$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
									}																				
								}
								
 								$response = $this->CI->twillo_m->send_mobile_message(trim($return['countryCode']).trim($return['businessPhone']),$message);
								$this->CI->custom_log->write_log('custom_log','send mail response is '.print_r($response,true));
								if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
								{
									if($return['email'])
									{
										$this->CI->session->set_flashdata('success','An Email & Text message has been sent with the temporary username and password to the registered retailer.');
									}
									else
									{
										$this->CI->session->set_flashdata('success','A text message has been sent with temporary username and password to the registered retailer.');
									}
								}
								else
								{
									if($return['email'])
									{
										$this->CI->session->set_flashdata('success','An Email & Text message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
									}
									else
									{
										$this->CI->session->set_flashdata('success','A text message has been sent with the verification code. Kindly enter the codes you have received to verify your details.');
									}
								}								
								$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_reatiler_sign_up'));
							}
							if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
							{
								redirect(base_url().$userType.'/retailer_management');
							}
							else
							{
								redirect(base_url().'retailer/home/phone_verification/'.id_encrypt($organizationId));
							}
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_retailer_address'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_retailer_address'));
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_retailer_employee'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_retailer_employee'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_retailer_organization'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_retailer_organization'));
				}
				
				if(($userType=='superadmin')||($userType=='admin')||(($userType=='cse')))
				{
					redirect(base_url().$userType.'/retailer_management');
				}
				else
				{
					redirect(base_url().'retailer/home/sign_up');
				}
			}						
		}
		
		
		//$return['stateList'] = $this->CI->location_m->nigeria_state_list();
		$return['organizationTypeList'] = $this->CI->user_m->organization_type_list();
		//echo "<pre>"; print_r($return); exit;
		return $return;
	}
	
	public function upload_retailer_image()
	{
		$image_name   = '';
		$newImageName = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = (time()*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/retailer/'; 
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
				$imagepath	  =	'uploads/retailer/'.$newImageName ;
				$newimagepath =	'uploads/retailer/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/retailer/thumb50/'.$newImageName;
				$this->CI->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
		}
		return $newImageName;
	}
	
	public function retailer_index()
	{
		$return = array();
		$return['total']    = $this->CI->user_m->total_retailer_user();
		$return['totalReq'] = $this->CI->user_m->total_retailer_user_request();
		//echo $this->CI->db->last_query(); exit;
		return $return;
	}
	
	public function retailer_ajaxFun($total)
	{
		//echo "<pre>"; print_r($_POST); exit;
		$return    	     = array();
		$per_page  	     = $this->CI->input->post('sel_no_entry');
		$businessName    = $this->CI->input->post('businessName');
		$businessPhone   = $this->CI->input->post('businessPhone');
		$countryName     = $this->CI->input->post('countryName');
		$associationType = $this->CI->input->post('associationType');
		$userName        = $this->CI->input->post('userName');
		$businessOwnerName = $this->CI->input->post('businessOwnerName');
		$accountOwner    = $this->CI->input->post('accountOwner');
		$where           = '';
		$accntOwnerWhere = '';
		
		if(!empty($businessName))
		{
			if(!empty($where))
			{
				$where.= " AND organization.organizationName LIKE '".$businessName."%'";
			}
			else
			{
				$where = "organization.organizationName LIKE '".$businessName."%'";
			}
		}
		if(!empty($businessPhone))
		{
			if(!empty($where))
			{
				$where.= " AND employee.businessPhone LIKE '".$businessPhone."%'";
			}
			else
			{
				$where = "employee.businessPhone LIKE '".$businessPhone."%'";
			}			
		}
		//echo $where; exit;
		if(!empty($countryName))
		{
			if(!empty($where))
			{
				$where.= " AND country.name LIKE '".$countryName."%'";
			}
			else
			{
				$where = "country.name LIKE '".$countryName."%'";
			}			
		}
		if(!empty($businessOwnerName))
		{
			if(!empty($where))
			{
				$where.= " AND CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}
			else
			{
				$where= " CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}					
		}

		if(!empty($accountOwner))
		{
			if(!empty($where))
			{
				$where.= " AND (SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) LIKE '".$accountOwner."%'";
			}
			else
			{
				$where = "(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) LIKE '".$accountOwner."%'";
			}							
			
		}
		
		if($where)
		{
			$where = '('.$where.')';
			$total = $this->CI->user_m->total_retailer_user($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/retailer_management/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		if($this->CI->session->userdata('userType')=='cse')
		{
			$return['list']  = $this->CI->cse_m->cse_assing_retailer_list($page,$pagConfig['per_page'],$where);
		}
		else
		{
			$return['list']  = $this->CI->retailer_m->retailer_user_list($page,$pagConfig['per_page'],$where);
		}
		//echo $this->CI->db->last_query(); exit;
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	public function pointepay_retailer_ajaxFun()
	{
		//echo "<pre>"; print_r($_POST); exit;
		$return    	     = array();
		$per_page  	     = $this->CI->input->post('sel_no_entry');
		$businessName    = $this->CI->input->post('businessName');
		$businessPhone   = $this->CI->input->post('businessPhone');
		//$countryName     = $this->CI->input->post('countryName');
		$associationType = $this->CI->input->post('associationType');
		//$userName        = $this->CI->input->post('userName');
		$businessOwnerName = $this->CI->input->post('businessOwnerName');
		//$accountOwner    = $this->CI->input->post('accountOwner');
		$where           = 'organization.isPointePay = 2';
		$accntOwnerWhere = '';
		
		if(!empty($businessName))
		{
			if(!empty($where))
			{
				$where.= " AND organization.organizationName LIKE '".$businessName."%'";
			}
			else
			{
				$where = "organization.organizationName LIKE '".$businessName."%'";
			}
		}
		if(!empty($businessPhone))
		{
			if(!empty($where))
			{
				$where.= " AND employee.businessPhone LIKE '".$businessPhone."%'";
			}
			else
			{
				$where = "employee.businessPhone LIKE '".$businessPhone."%'";
			}			
		}
		//echo $where; exit;
	/*	if(!empty($countryName))
		{
			if(!empty($where))
			{
				$where.= " AND country.name LIKE '".$countryName."%'";
			}
			else
			{
				$where = "country.name LIKE '".$countryName."%'";
			}			
		}
		if(!empty($businessOwnerName))
		{
			if(!empty($where))
			{
				$where.= " AND CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}
			else
			{
				$where= " CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}					
		}

		if(!empty($accountOwner))
		{
			if(!empty($where))
			{
				$where.= " AND (SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) LIKE '".$accountOwner."%'";
			}
			else
			{
				$where = "(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) LIKE '".$accountOwner."%'";
			}							
			
		}
		*/
		if($where)
		{
			$where = '('.$where.')';
			$total = $this->CI->user_m->total_retailer_user($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/pointepay_management/ajaxRetailerList/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		if($this->CI->session->userdata('userType')=='cse')
		{
			$return['list']  = $this->CI->cse_m->cse_assing_retailer_list($page,$pagConfig['per_page'],$where);
		}
		else
		{
			$return['list']  = $this->CI->retailer_m->retailer_user_list($page,$pagConfig['per_page'],$where);
		}
		//echo $this->CI->db->last_query(); exit;
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function retailer_userDetails($organizationId)
	{
		$result = array();
		$result['imageName']     = '';
		$result['businessName']  = '';
		$result['businessPhone'] = '';
		$result['email']         = '';
		$result['street'] 	     = '';
		$result['countryName']   = '';
		$result['stateName']     = '';
		$result['areaName']	     = '';
		$result['cityName']	     = '';
		$result['cseName']	     = '';
		$result['firstName']     = '';
		$result['middleName']    = '';
		$result['lastName']      = '';
		$result['blockUnblock']  = 0;
		$result['organizationType'] = '';
		$result['isPointeMart']     = 0;
		$result['isPointePay']      = 0;
		$result['userName']         = '';
		$result['organizationId']   = 0;
		$result['employeeId']   = 0;
		$result['dropshipCentre'] = '';
		$result['requestStatus']  = '';
		$result['active']         = 0;
		
		$users_details = $this->CI->user_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{			
			$cseDetails = $this->CI->user_m->cse_details_of_retailer($organizationId);
			if(!empty($cseDetails))
			{
				$result['cseName'] = $cseDetails->firstName.' '.$cseDetails->middle.' '.$cseDetails->lastName;
			}
			$result['requestStatus']    = $users_details->requestStatus;
			$result['imageName'] 	    = $users_details->imageName;
			$result['businessName']     = $users_details->organizationName;
			$result['businessPhone']    = $users_details->businessPhone;
			$result['email'] 	        = $users_details->email;
			$result['street']    	    = $users_details->addressLine1;
			$result['countryName'] 	    = $users_details->countryName;
			$result['stateName']   	    = $users_details->stateName;
			$result['areaName']    	    = $users_details->areaName;
			$result['cityName']    	    = $users_details->cityName;
			$result['firstName']        = $users_details->firstName;
			$result['middleName']       = $users_details->middle;
			$result['lastName']         = $users_details->lastName;
			$result['blockUnblock']     = $users_details->active;
			$result['organizationType'] = $users_details->organizationType;
			$result['isPointeMart']     = $users_details->isPointeMart;
			$result['isPointePay']      = $users_details->isPointePay;
			$result['userName']         = $users_details->userName;
			$result['organizationId']   = $users_details->organizationId;
			$result['employeeId']   = $users_details->employeeId;
			$result['dropshipCentre'] = $users_details->dropshipCentre;
			$result['active']           = $users_details->active;
		}
	//	echo "<pre>"; print_r($cseDetails); exit;
		return $result;
	}
	
	public function retailer_edit($organizationId)
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']	 	   = ''; 
		$return['organizationTypeId']  = 1; 
		$return['associationType']	   = 1;
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = '';
		$return['userName']      	   = '';
		$return['email']  		 	   = ''; 
		$return['businessName']  	   = ''; 
		$return['countryCode']   	   = '+234'; 
		$return['businessPhone'] 	   = ''; 		
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['areaId']  		 	   = ''; 
		$return['cityId']  		 	   = ''; 
		$return['street']  		 	   = ''; 
		$return['isPointePay']  	   = 0;
		$return['isPointeMart'] 	   = 1;
		$return['employeeId'] 	   = 0;
		$return['dropshipCentre']	   = 0;
		$employeeId     = '';
		$addressId      = '';
		$users_details  = $this->CI->user_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$return['imageName'] 	 	  = $users_details->imageName;
			$return['businessName']  	  = $users_details->organizationName;
			$return['businessPhone'] 	  = $users_details->businessPhone;
			$return['street']    	 	  = $users_details->addressLine1;
			$return['firstName']     	  = $users_details->firstName;
			$return['middleName']    	  = $users_details->middle;
			$return['lastName']      	  = $users_details->lastName;
			$return['organizationType']   = $users_details->organizationType;
			//$return['countryId']   	      = $users_details->country;
			$return['stateId']     	      = $users_details->state;
			$return['areaId']      		  = $users_details->area;
			$return['cityId']      		  = $users_details->city;
			$return['organizationTypeId'] = $users_details->organizationTypeId;	
			//$return['isPointePay'] 	      = $users_details->isPointePay;
			//$return['isPointeMart'] 	  = $users_details->isPointeMart;
			$return['email']			  = $users_details->email;
			$return['countryCode']		  = $users_details->businessPhoneCode;
			$return['dropshipCentre']	   = $this->CI->input->post('dropshipCentre');
			
			$employeeId = $users_details->employeeId;
			$addressId 		= $users_details->addressId;
			$return['employeeId'] = $employeeId;
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['formSubmit']  		   = 0;
			//$return['associationType']	   = $this->CI->input->post('associationType');
			//$return['organizationTypeId']  = $this->CI->input->post('organizationTypeId');
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['lastName']  	 	   = $this->CI->input->post('lastName'); 
			$return['middleName']  	 	   = $this->CI->input->post('middleName'); 
		//	$return['countryId']  	 	   = $this->CI->input->post('countryId');
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  		 	   = $this->CI->input->post('areaId');
			$return['cityId']  		 	   = $this->CI->input->post('cityId');
			$return['street']  		 	   = $this->CI->input->post('street');
			$return['businessName']  	   = $this->CI->input->post('businessName');
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone');
			$return['imageName']		   = $this->CI->input->post('imageName'); 
			$return['email']			   = $this->CI->input->post('email'); 
			//$return['countryCode']   	   = $this->CI->input->post('countryCode'); 
			$return['isPointePay']  	   = 1;
			$return['isPointeMart']        = 1;
			$return['dropshipCentre']	   = $this->CI->input->post('dropshipCentre');
			/*if($return['associationType']==1)
			{
				$return['isPointePay']  = 0;
				$return['isPointeMart'] = 1;
			}
			elseif($return['associationType']==2)
			{
				$return['isPointeMart'] = 0;
				$return['isPointePay']  = 1;
			}
			elseif($return['associationType']==3)
			{
				$return['isPointePay']  = 1;
				$return['isPointeMart'] = 1;
			}*/
			
			
			$rules = update_retailer_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($this->CI->user_m->update_retailer_organization($organizationId,$return))
				{
					if($this->CI->user_m->update_retailer_employee($employeeId,$return))
					{
						if($addressId)
						{
							if($this->CI->user_m->update_retailer_address($addressId,$return))
							{
								$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_retailer_user'));
							}
							else
							{
								$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_retailer_address'));
							}
						}
						else
						{
							$addressId = $this->CI->user_m->add_retailer_address($return);
							if($addressId)
							{
								$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
								$this->CI->user_m->add_retailer_organization_address($organizationId,$addressId);
							}
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_retailer_employee'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_retailer_organization'));
				}
				
				$uriSeg3 = $this->CI->uri->segment(3);
				if($uriSeg3=='editRetailerRequest')
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/retailer_management/request_user_detail/'.id_encrypt($organizationId));
				}
				else
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/retailer_management/user_detail/'.id_encrypt($organizationId));
				}
			}	
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();	
		$return['organizationTypeList'] = $this->CI->user_m->organization_type_list();
		$return['dropshipCentreList']  = $this->CI->retailer_m->dropship_center_list();
		return $return;
	}
	
	public function cse_index()
	{
		$return = array();
		$return['total'] = $this->CI->cse_m->total_cse_user();
		return $return;
	}
	
	public function cse_ajaxFun($total)
	{
		$return   = array();
		$per_page = $this->CI->input->post('sel_no_entry');
		$cseName  = $this->CI->input->post('cseName');
		$emailId  = $this->CI->input->post('emailId');
		$where    = '';
		
		if(!empty($cseName))
		{
			$where = " CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$cseName."%'";
		}
		if(!empty($emailId))
		{
			if(!empty($where))
			{
				$where.= " AND employee.email LIKE '".$emailId."%'";
			}
			else
			{
				$where = "employee.email LIKE '".$emailId."%'";
			}			
		}
		
		if($where)
		{
			$where = '('.$where.')';
			$total = $this->CI->cse_m->total_cse_user($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/cse_management/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		$return['list']  = $this->CI->cse_m->cse_user_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function cse_userDetails($employeeId)
	{
		$result = array();
		$return['imageName']	  = ''; 
		$return['firstName'] 	  = '';
		$return['middleName'] 	  = ''; 
		$return['lastName']  	  = ''; 
		$return['email']  		  = ''; 
		$return['birthDay']		  = ''; 
		$return['countryName']    = ''; 
		$return['stateName']  	  = '';
		$return['areaName']  	  = '';
		$return['cityName']  	  = ''; 
		$return['blockUnblock']   = 0;
		$return['retailerList']   = 0;
		$return['dropshipCentre'] = '';
		
		$users_details = $this->CI->user_m->cse_user_details($employeeId);
		if(!empty($users_details))
		{
			$return['imageName'] 	  = $users_details->imageName;
			$return['firstName']      = $users_details->firstName;
			$return['middleName']     = $users_details->middle;
			$return['lastName'] 	  = $users_details->lastName;
			$return['email']       	  = $users_details->email;
			$return['birthDay'] 	  = $users_details->birthDay;
			$return['countryName']    = $users_details->countryName;
			$return['stateName']      = $users_details->stateName;
			$return['areaName']       = $users_details->areaName;
			$return['cityName']       = $users_details->cityName;
			$return['blockUnblock']   = $users_details->active;
			$return['retailerList']   = $this->CI->user_m->retailer_assign_to_cse_list($employeeId);
			$return['dropshipCentre'] = $this->CI->cse_m->cse_dropship_center_list($employeeId);
		}
		//echo "<pre>"; print_r($return); exit;
		return $return;
	}
	
	public function cse_sign_up()
	{
		$return 			  = array();
		$return['imageName']  = ''; 
		$return['firstName']  = '';
		$return['middleName'] = ''; 
		$return['lastName']   = ''; 
		$return['email']  	  = ''; 
		$return['date']		  = ''; 
		$return['month'] 	  = ''; 
		$return['countryId']  = 154; 
		$return['stateId']    = ''; 
		$return['areaId']     = ''; 
		$return['cityId']	  = ''; 
		
		if($_POST)
		{	
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['imageName']	  = $this->CI->input->post('imageName'); 
			$return['firstName'] 	  = $this->CI->input->post('firstName');
			$return['lastName']  	  = $this->CI->input->post('lastName'); 
			$return['middleName']  	  = $this->CI->input->post('middleName'); 
			$return['stateId']  	  = $this->CI->input->post('stateId');	
			$return['areaId']   	  = $this->CI->input->post('areaId');	
			$return['cityId']   	  = $this->CI->input->post('cityId');			
			$return['date']  		  = $this->CI->input->post('date');
			$return['month']  		  = $this->CI->input->post('month');
			$return['email']  		  = $this->CI->input->post('email');
			$return['dropshipCentre'] = $this->CI->input->post('dropshipCentre'); 
			
			$rules = cse_sign_up();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$return['birthDay'] = '0000-'.$return['month'].'-'.$return['date'];
				$return['password'] = otp5_digit();
				$employeeId 		= $this->CI->user_m->add_cse_employee(1,$return);
				$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
				
				if($employeeId)
				{
					$addressId = $this->CI->cse_m->add_cse_address($return);
					$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
					$employeeAddressId = $this->CI->cse_m->add_cse_employee_address($employeeId,$addressId);
					
					$roleID = $this->CI->user_m->add_cse_employee_role($employeeId,1);
					$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);
					
					if($roleID)
					{
						if(!empty($return['dropshipCentre']))
						{
							foreach($return['dropshipCentre'] as $dropcenterId)
							{
								$cseDropShipId = $this->CI->cse_m->add_cse_dropship_center($employeeId,$dropcenterId);
								$this->CI->custom_log->write_log('custom_log','cse Dropship center id is '.$cseDropShipId);
							}
						}
					
						$mailData = array(
										'email'    => $return['email'],
										'cc'	   => '',
										'slug'     => 'cse_register',
										'name'     => $return['firstName'].' '.$return['lastName'],
										'password' => $return['password'],
										'subject'  => 'CSE Sign up Successfully',
									);										
						if($this->CI->email_m->send_mail($mailData))
						{
							$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_retailer'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
						}
						else
						{
							$this->CI->session->set_flashdata('error','CSE create successfully but '.$this->CI->lang->line('error_mail_not_send'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
						}																				
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_cse_sign_up'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_cse_sign_up'));
					}
					redirect(base_url().$this->CI->session->userdata('userType').'/cse_management');							
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_cse_employee'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_cse_employee'));
				}
				redirect(base_url().$this->session->userdata('userType').'/cse_management');
			}	
		}

		$return['stateList']    = $this->CI->location_m->nigeria_state_list();
		$return['dropshipList'] = $this->CI->retailer_m->dropship_center_list();
		return $return;
	}
	
	public function cse_edit($employeeId)
	{
		$return = array();
		$return['imageName']	 	   = ''; 
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = ''; 
		$return['date']		     	   = ''; 
		$return['month'] 	   		   = ''; 
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['cityId']	  	 	   = '';
		$return['areaId']			   = ''; 
		$return['forSubmit']  	 	   = 1; 
		
		$addressId     = 0;
		$users_details = $this->CI->cse_m->cse_user_details($employeeId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$return['imageName']  = $users_details->imageName;
			$return['firstName']  = $users_details->firstName;
			$return['middleName'] = $users_details->middle;
			$return['lastName']   = $users_details->lastName;
			$birthDay = $users_details->birthDay;
			$exp = explode("-",$birthDay);
			if(count($exp)>1)
			{
				$return['date']  = $exp[2]; 
				$return['month'] = $exp[1];
			}
			
			$addressDet = $this->CI->cse_m->cse_user_address_details($employeeId);
			//echo "<pre>"; print_r($addressDet); exit;
			if(!empty($addressDet))
			{
				$addressId         = $addressDet->addressId;
				$return['areaId']  = $addressDet->area;
				$return['stateId'] = $addressDet->state;
				$return['cityId']  = $addressDet->city;
			}
		}
		$return['cseDropshipList'] = $this->CI->cse_m->cse_dropship_center_list($employeeId);

		if($_POST)
		{
			$return['forSubmit']  = 0;
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['imageName']  = $this->CI->input->post('imageName'); 
			$return['firstName']  = $this->CI->input->post('firstName');
			$return['lastName']   = $this->CI->input->post('lastName'); 
			$return['middleName'] = $this->CI->input->post('middleName'); 
			$return['cityId']     = $this->CI->input->post('cityId');
			$return['areaId']     = $this->CI->input->post('areaId');	
			$return['stateId']    = $this->CI->input->post('stateId');			
			$return['date']  	  = $this->CI->input->post('date');
			$return['month']  	  = $this->CI->input->post('month');
			$return['dropshipCentre'] = $this->CI->input->post('dropshipCentre');
			//echo "<pre>"; print_r($_POST); exit;
			$rules = update_cse_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$return['birthDay'] = '0000-'.$return['month'].'-'.$return['date'];
				if($this->CI->user_m->update_cse_employee($employeeId,$return))
				{
					$addressId = $this->CI->cse_m->add_cse_address($return);
					$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
					$this->CI->cse_m->deactive_cse_address_old($employeeId);					
					$employeeAddressId = $this->CI->cse_m->add_cse_employee_address($employeeId,$addressId);
					
					$this->CI->cse_m->delete_cse_dropship_center($employeeId);
					if(!empty($return['dropshipCentre']))
					{
						foreach($return['dropshipCentre'] as $dropcenterId)
						{
							$cseDropShipId = $this->CI->cse_m->add_cse_dropship_center($employeeId,$dropcenterId);
							$this->CI->custom_log->write_log('custom_log','cse Dropship center id is '.$cseDropShipId);
						}
					}
					
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_cse'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_cse'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_cse_employee'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_cse_employee'));
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/cse_management/user_detail/'.id_encrypt($employeeId));
			}	
		}
		
		$return['stateList']    = $this->CI->location_m->nigeria_state_list();
		$return['dropshipList'] = $this->CI->retailer_m->dropship_center_list();
		return $return;
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
	
	public function addEditAssignCSE($organizationId)
	{
		$where           = '';
		$cseId           = '';
		$return			 = array();
		$return['cseId'] = '';
		$return['businessOwnerName'] = '';
		$return['email'] 			 = '';
		$return['countryCode']       = '';
		$return['businessPhone']     = '';
		
		$assignList      = $this->CI->user_m->csr_organization_list($organizationId);
		if(!empty($assignList))
		{
			$cseId = $assignList->employeeId;
			if($cseId)
			{
			//	$where = 'employee.employeeId != '.$cseId;
			}
			$return['cseId'] = $cseId;
		}		
		$return['cseList'] = $this->CI->user_m->cse_user_list(0,'',$where);
		
		$details = $this->CI->user_m->getEmployeeRetailer($organizationId);
		if(!empty($details))
		{
			$return['businessOwnerName'] = $details->firstName.' '.$details->middle.' '.$details->lastName;
			$return['email'] = $details->email;
			$return['countryCode'] = $details->businessPhoneCode;
			$return['businessPhone'] = $details->businessPhone;
		}
	
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['cseId'] = $this->CI->input->post('cseId'); 
			$rules = assign_cse_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($cseId)
				{			
					//$this->CI->db->where('organizationId',$organizationId);
					//$this->CI->db->delete('csr_organization');	
					$this->CI->user_m->update_assign_cse_to_retailer($organizationId,$return['cseId']);
					
					$cseDetails = $this->CI->user_m->getEmployeeCSE($return['cseId']);
					if(!empty($cseDetails))
					{
						if(!empty($return['email']))
						{
							$mailData = array(
											'email'    => $return['email'],
											'cc'	   => '',
											'slug'     => 'change_cse_to_retailer',
											'name'     => $return['businessOwnerName'],
											'businessOwnerName'  => $return['businessOwnerName'],
											'cseName'  => $cseDetails->firstName.' '.$cseDetails->middle.' '.$cseDetails->lastName,
											'subject'  => 'CSE changed successfully',
										);										
							if($this->CI->email_m->send_mail($mailData))
							{
								$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_retailer'));
								$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
							}
							else
							{
								$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_mail_not_send'));
								$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
							}	
						}
						
						$message = "Dear ".$return['businessOwnerName'].", CSE allocated to your is now changed." .$return['cseName']." is the name of new CSE allocated to you. For any queries kindly feel free to call us at ".$this->CI->config->item('admin_phone_no')." or email us at ".$this->CI->config->item('admin_email')." and ask help from ".$cseDetails->firstName.' '.$cseDetails->middle.' '.$cseDetails->lastName;
						$rs = $this->CI->twillo_m->send_mobile_message('',trim($return['countryCode']).trim($return['businessPhone']),$message);
					}
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_assign_cse_to_retailer'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_assign_cse_to_retailer'));
				}
				else
				{
					$this->CI->user_m->assign_cse_to_retailer($organizationId,$return['cseId']);
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_assign_cse_to_retailer'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_assign_cse_to_retailer'));
				}
				$uriSeg3 = $this->CI->uri->segment(3);
				if($uriSeg3=='request_assign_cse')
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/retailer_management/request_user_detail/'.id_encrypt($organizationId));
				}
				else
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/retailer_management/user_detail/'.id_encrypt($organizationId));
				}
			}
		}
		//echo "<pre>"; print_r($return); exit;
		return $return;
	}
	
	public function request_request_list()
	{
		$return = array();
		$return['total'] = $this->CI->user_m->total_retailer_user_request();
		return $return;
	}
	
	public function retailer_requestAjaxFun($total)
	{
		$return    	     = array();
		$per_page  	     = $this->CI->input->post('sel_no_entry');
		$businessName    = $this->CI->input->post('businessName');
		$businessPhone     = $this->CI->input->post('businessPhone');
		$businessOwnerName = $this->CI->input->post('businessOwnerName');
		$countryName     = $this->CI->input->post('countryName');
		$associationType = $this->CI->input->post('associationType');
		$userName        = $this->CI->input->post('userName');
		$accountOwner    = $this->CI->input->post('accountOwner');
		$where           = '';
		$accntOwnerWhere = '';
		
		if(!empty($businessName))
		{
			if(!empty($where))
			{
				$where.= " AND organization.organizationName LIKE '".$businessName."%'";
			}
			else
			{
				$where = "organization.organizationName LIKE '".$businessName."%'";
			}
		}
		if(!empty($businessPhone))
		{
			if(!empty($where))
			{
				$where.= " AND CONCAT(employee.businessPhoneCode,'',employee.businessPhone) LIKE '".$businessPhone."%'";
			}
			else
			{
				$where = "CONCAT(employee.businessPhoneCode,'',employee.businessPhone) LIKE '".$businessPhone."%'";
			}			
		}
		if(!empty($countryName))
		{
			if(!empty($where))
			{
				$where.= " AND country.name LIKE '".$countryName."%'";
			}
			else
			{
				$where = "country.name LIKE '".$countryName."%'";
			}			
		}
		if(!empty($businessOwnerName))	
		{
			if(!empty($where))
			{
				$where.= " AND CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}
			else
			{
				$where= " CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}			
		}
		
		if($where)
		{
			$where = '('.$where.')';
			$total = $this->CI->user_m->total_retailer_user($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/retailer_management/requestAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		$return['list']  = $this->CI->user_m->retailer_user_request_list($page,$pagConfig['per_page'],$where,$accntOwnerWhere);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function retailer_RequestUserDetails($organizationId)
	{
		$result = array();
		$result['imageName']          = '';
		$result['businessName']       = '';
		$result['businessPhone']      = '';
		$result['email']              = '';
		$result['street'] 	          = '';
		$result['countryName']        = '';
		$result['stateName']          = '';
		$result['cityName']	          = '';
		$result['cseName']	          = '';
		$result['firstName']          = '';
		$result['middleName']         = '';
		$result['lastName']           = '';
		$result['blockUnblock']       = 0;
		$result['organizationType']   = '';
		$result['isPointeMart']       = 0;
		$result['isPointePay']        = 0;
		$result['userName']           = '';
		$result['organizationId']     = 0;
		$result['businessPhoneCode']  = 0;
		$result['employeeId']         = 0;
		$result['dropshipCentre']     = 0;
		$result['dropshipCentreList'] = $this->CI->retailer_m->dropship_center_list();
		
		$users_details = $this->CI->user_m->retailer_user_details($organizationId);
		//echo "<pre>"; print_r($result['dropshipCentreList']); exit;
		if(!empty($users_details))
		{
			$cseDet = $this->CI->user_m->cse_details_of_retailer($organizationId);
			if($cseDet)
			{
				$result['cseName'] = $cseDet->firstName.' '.$cseDet->middle.' '.$cseDet->lastName;
			}
			
			$result['imageName'] 	    = $users_details->imageName;
			$result['businessName']     = $users_details->organizationName;
			$result['businessPhone']    = $users_details->businessPhone;
			$result['email'] 	        = $users_details->email;
			$result['street']    	    = $users_details->addressLine1;
			$result['countryName'] 	    = $users_details->countryName;
			$result['stateName']   	    = $users_details->stateName;
			$result['cityName']    	    = $users_details->cityName;
			
			$result['firstName']        = $users_details->firstName;
			$result['middleName']       = $users_details->middle;
			$result['lastName']         = $users_details->lastName;
			$result['blockUnblock']     = $users_details->active;
			$result['organizationType'] = $users_details->organizationType;
			$result['isPointeMart']     = $users_details->isPointeMart;
			$result['isPointePay']      = $users_details->isPointePay;
			$result['userName']         = $users_details->userName;
			$result['organizationId']   = $users_details->organizationId;
			$result['businessPhoneCode'] = $users_details->businessPhoneCode;
			$result['dropshipCentre'] = $users_details->dropshipCentre;
			$result['employeeId'] = $users_details->employeeId;
		}
		return $result;
	}
	
	public function retailer_request_history_list()
	{
		$return = array();
		$return['total'] = $this->CI->user_m->total_retailer_user_request_history();
		return $return;
	}
	
	public function retailer_requestHistoryAjaxFun($total)
	{
		$return    	     = array();
		$per_page  	     = $this->CI->input->post('sel_no_entry');
		$businessName    = $this->CI->input->post('businessName');
		$businessPhone   = $this->CI->input->post('businessPhone');
		$countryName     = $this->CI->input->post('countryName');
		$associationType = $this->CI->input->post('associationType');
		$userName        = $this->CI->input->post('userName');
		$accountOwner    = $this->CI->input->post('accountOwner');
		$businessOwnerName    = $this->CI->input->post('businessOwnerName');
		$where           = '';
		$accntOwnerWhere = '';
		
		if(!empty($businessName))
		{
			if(!empty($where))
			{
				$where.= " AND organization.organizationName LIKE '".$businessName."%'";
			}
			else
			{
				$where = "organization.organizationName LIKE '".$businessName."%'";
			}
		}
		if(!empty($businessPhone))
		{
			if(!empty($where))
			{
				$where.= " AND CONCAT(employee.businessPhoneCode,'',employee.businessPhone) LIKE '".$businessPhone."%'";
			}
			else
			{
				$where = "CONCAT(employee.businessPhoneCode,'',employee.businessPhone) LIKE '".$businessPhone."%'";
			}			
		}
		if(!empty($countryName))
		{
			if(!empty($where))
			{
				$where.= " AND country.name LIKE '".$countryName."%'";
			}
			else
			{
				$where = "country.name LIKE '".$countryName."%'";
			}			
		}
		if(!empty($businessOwnerName))	
		{
			if(!empty($where))
			{
				$where.= " AND CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}
			else
			{
				$where= " CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$businessOwnerName."%'";
			}			
		}		
				
		if($where)
		{
			$where = '('.$where.')';
			$total = $this->CI->user_m->total_retailer_user($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/retailer_management/requestHistoryAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		$return['list']  = $this->CI->user_m->retailer_user_request_history_list($page,$pagConfig['per_page'],$where,$accntOwnerWhere);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function shipping_vendor_index()
	{
		$return = array();
		//$return['total'] = $this->CI->user_m->total_shipping_vendor_user();
		$return['total'] = $this->CI->shipping_m->total_shipping_vendor_user();
		//echo $this->CI->db->last_query(); exit;
		return $return;
	}
	
	public function shipping_vendor_ajaxFun($total)
	{
		$return    = array();
		$where     = '';				
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/vendor_management/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		//$return['list']  = $this->CI->user_m->shipping_vendor_user_list($page,$pagConfig['per_page'],$where);
		$return['list']  = $this->CI->shipping_m->shipping_vendor_user_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	public function shipping_vendor_employee_ajaxFun($parentOrganizationId='')
	{
		$return    	     = array();
		$where           = '';
		$per_page  	     = $this->CI->input->post('sel_no_entry');
		/*$businessName    = $this->CI->input->post('businessName');
		$businessPhone   = $this->CI->input->post('businessPhone');
		$countryName     = $this->CI->input->post('countryName');
		$associationType = $this->CI->input->post('associationType');
		$userName        = $this->CI->input->post('userName');
		$accountOwner    = $this->CI->input->post('accountOwner');
		$businessOwnerName    = $this->CI->input->post('businessOwnerName');*/
		
		if(empty($per_page))
		{
			$per_page=10;
		}
		$total=$this->CI->user_m->total_shipping_vendor_employee($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/employee_management/vendor_employee_ajax_fun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		$return['list']  = $this->CI->user_m->shipping_vendor_employee_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		//echo "<pre>"; print_r($return['list']); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function add_shipping_rates($shippingOrgId)
	{
		if($_POST)
		{
			$rules = add_vendor_document_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$document_name = $this->CI->input->post('image_name');
				$imagepath = 'uploads/shipping/upload_doc/'.$document_name;
				$this->CI->custom_log->write_log('custom_log','document path is '.$imagepath);
				$this->CI->load->library('excel');
				if(file_exists($imagepath))
				{
					$this->CI->custom_log->write_log('custom_log','file available in folder '.$imagepath);
					$objPHPExcel = PHPExcel_IOFactory::load($imagepath);
					$sheetData   = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$this->CI->custom_log->write_log('custom_log','sheet data is '.print_r($sheetData,true));
					if(!empty($sheetData))
					{
						//echo "<pre>";	print_r($sheetData); exit;
						$this->CI->user_m->add_excel_file_data($shippingOrgId,$sheetData);
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_shipping_vender_rate_list'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_shipping_vender_rate_list'));
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_empty_excel'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_empty_excel'));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_file_no_found'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_file_no_found'));
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($shippingOrgId));	
			}
		}
	}
	
	public function shipping_vendor_upload_document()
	{				
		$image_name 	 = '';
		$result 		 = array();
		$result['error'] = ''; 
		if(isset($_FILES['myfile']))
		{
			$oldName = pathinfo($_FILES['myfile']['name']);
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->CI->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/shipping/upload_doc/'; 
			$config['allowed_types'] = '*';
			$config['file_name']     = $newImageName;
			$image_name              = $newImageName;
						
			$this->CI->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->CI->upload->initialize($config);
			if(!$this->CI->upload->do_upload('myfile'))
			{
				$result['error'] = $this->CI->upload->display_errors();
				$this->CI->custom_log->write_log('custom_log','file upload error is '.$result['error']);
			}
			$result['newImageName'] = $newImageName;
			return $result;
		}	
	}
	
	public function shipping_vendor_upload_document_backup()
	{				
		$image_name 	 = '';
		$result 		 = array();
		$result['error'] = ''; 
		if(isset($_FILES['myfile']))
		{
			$oldName = pathinfo($_FILES['myfile']['name']);
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->CI->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/shipping/upload_doc/'; 
			$config['allowed_types'] = '*';
			$config['file_name']     = $newImageName;
			$image_name              = $newImageName;
						
			$this->CI->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->CI->upload->initialize($config);
			if(!$this->CI->upload->do_upload('myfile'))
			{
				$result['error'] = $this->CI->upload->display_errors();
				$this->CI->custom_log->write_log('custom_log','file upload error is '.$result['error']);
			}
			else
			{
				$imagepath = 'uploads/shipping/upload_doc/'.$newImageName ;
				$this->CI->load->library('excel');
				if(file_exists($imagepath))
				{
					$flag        = FALSE;
					$objPHPExcel = PHPExcel_IOFactory::load($imagepath);
					$sheetData   = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$newArr      = array_shift($sheetData); 
					if((!empty($newArr))&&(!empty($sheetData)))
					{
						if((empty($newArr['A']))||(strtolower($newArr['A'])!='dropship centre'))
						{
							$flag = TRUE;
						}
						if((empty($newArr['B']))||(strtolower($newArr['B'])!='areas covered'))
						{
							$flag = TRUE;
						}
						if((empty($newArr['C']))||(strtolower($newArr['C'])!='weight from (in kg)'))
						{
							$flag = TRUE;
						}
						if((empty($newArr['D']))||(strtolower($newArr['D'])!='weight to (in kg)'))
						{
							$flag = TRUE;
						}
						if((empty($newArr['E']))||(strtolower($newArr['E'])!='price'))
						{
							$flag = TRUE;
						}
						if((empty($newArr['F']))||(strtolower($newArr['F'])!='estimated delivery timeframe'))
						{
							$flag = TRUE;
						}
						
						if($flag)
						{
							$result['error'] = 'Your excel file format is wrong';
						}
						else
						{
							foreach($sheetData as $key=>$val)
							{
								//if((!is_numeric($val['F']))||(!is_numeric($val['E']))||(!is_numeric($val['D']))||(!is_numeric($val['C'])))
								{
								//	$flag = TRUE;
								//	break;
								}
							}
							
							if($flag)
							{
								$result['error'] = 'Your excel file data is wrong';
							}							
						}						
					}
					else
					{
						$result['error'] = 'Your excel file is empty';
					}
				}
			}
			$result['newImageName'] = $newImageName;
			return $result;
		}	
	}
	
	public function shipping_vendore_sign_up()
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']	 	   = ''; 
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = '';
		$return['email']  		 	   = ''; 
		$return['password']      	   = ''; 
		$return['businessName']  	   = ''; 
		$return['businessPhone'] 	   = ''; 		
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['areaId']  		 	   = ''; 
		$return['cityId']  		 	   = ''; 
		$return['street']  		 	   = ''; 
		$return['countryCode'] 		   = '+234';
		$return['excelFile'] 		   = '';
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			
			$return['excelFile']	 	   = $this->CI->input->post('excelFile'); 
			$return['imageName']	 	   = $this->CI->input->post('imageName'); 
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['middleName'] 		   = $this->CI->input->post('middleName'); 
			$return['lastName']  	 	   = $this->CI->input->post('lastName');
			$return['email']  		 	   = $this->CI->input->post('email'); 
			$return['businessName']  	   = $this->CI->input->post('businessName'); 
			$return['countryCode']   	   = trim($this->CI->input->post('countryCode'));
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone'); 		
			//$return['countryId']     	   = $this->CI->input->post('countryId');
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  		 	   = $this->CI->input->post('areaId');  
			$return['cityId']  		 	   = $this->CI->input->post('cityId'); 
			$return['street']  		 	   = $this->CI->input->post('street'); 
			$return['OTP']  		 	   = otp5_digit(); 
			$return['userName'] 		   = $return['email'];
						
			$rules = shipping_vendor_sign_up();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$organizationId = $this->CI->user_m->add_shipping_vendor_organization($return);
				$this->CI->custom_log->write_log('custom_log','Organization id is '.$organizationId);
				
				if($organizationId)
				{
					$employeeId = $this->CI->user_m->add_shipping_vendor_employee($organizationId,$return);
					$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					
					if($employeeId)
					{
						$addressId = $this->CI->user_m->add_shipping_vendor_address($return);
						$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->CI->user_m->add_shipping_vendor_employee_address($employeeId,$addressId);
							$roleID = $this->CI->user_m->add_shipping_vendor_employee_role($employeeId,$organizationId);
							$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								
								$this->CI->session->set_flashdata('success','Shipping Vendor Created Successfully');
								$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_reatiler_sign_up'));
							}							
							redirect(base_url().$userType.'/vendor_management');							
						}
						else
						{
							$this->CI->session->set_flashdata('error','Shipping Vendor address not create');
							$this->CI->custom_log->write_log('custom_log','Shipping Vendor address not create');
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error','Shipping Vendor not create');
						$this->CI->custom_log->write_log('custom_log','Shipping Vendor not create');
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping Vendore organization not crate');
					$this->CI->custom_log->write_log('custom_log','Shipping Vendore organization not crate');
				}
				
				if(($userType=='admin')||($userType=='superadmin'))
				{
					redirect(base_url().$userType.'/vendor_management');
				}				
			}				
		}
		
		//$return['stateList'] = $this->CI->location_m->nigeria_state_list();
		return $return;
	}
	public function shipping_vendore_employee_sign_up($parentOrganizationId='')
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']	 	   = ''; 
		$return['firstName'] 	 	   = '';
		$return['middleName'] 		   = ''; 
		$return['lastName']  	 	   = '';
		$return['email']  		 	   = ''; 
		$return['password']      	   = ''; 
		$return['businessName']  	   = ''; 
		$return['businessPhone'] 	   = ''; 		
		$return['countryId']     	   = 154; 
		$return['stateId']  	 	   = ''; 
		$return['areaId']  		 	   = ''; 
		$return['cityId']  		 	   = ''; 
		$return['street']  		 	   = ''; 
		$return['countryCode'] 		   = '+234';
		$return['excelFile'] 		   = '';
		$return['dropshipCentre'] 		  = '';
		$return['parentOrganizationId']  =$parentOrganizationId;
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			
			$return['excelFile']	 	   = $this->CI->input->post('excelFile'); 
			$return['imageName']	 	   = $this->CI->input->post('imageName'); 
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['middleName'] 		   = $this->CI->input->post('middleName'); 
			$return['lastName']  	 	   = $this->CI->input->post('lastName');
			$return['email']  		 	   = $this->CI->input->post('email'); 
			$return['businessName']  	   = $this->CI->input->post('businessName'); 
			$return['countryCode']   	   = trim($this->CI->input->post('countryCode'));
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone'); 		
			//$return['countryId']     	   = $this->CI->input->post('countryId');
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  		 	   = $this->CI->input->post('areaId');  
			$return['cityId']  		 	   = $this->CI->input->post('cityId'); 
			$return['street']  		 	   = $this->CI->input->post('street'); 
			$return['dropshipCentre']  	   = $this->CI->input->post('dropshipCentre'); 
			$return['password']  		 	   = otp5_digit(); 
			$return['OTP']  		 	       = otp5_digit(); 
			$return['userName'] 		   = $return['email'];
						
			$rules = shipping_vendor_sign_up();
				$rules[]=	array(
									'field' => 'dropshipCentre[]',
									'label' => 'DropshipCentre',
									'rules' => 'trim|required'
								);
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$organizationId =$this->CI->session->userdata('organizationId');
				$this->CI->custom_log->write_log('custom_log','Organization id is '.$organizationId);
				
				if($organizationId)
				{
					
					
					
					$employeeId = $this->CI->user_m->add_shipping_vendor_employee($organizationId,$return);
					$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					foreach($return['dropshipCentre'] as $dropcenterId)
					{
						 $this->CI->user_m->add_shipping_employee_dropship($employeeId,$dropcenterId);
					}
					if($employeeId)
					{
						$addressId = $this->CI->user_m->add_shipping_vendor_address($return);
						$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->CI->user_m->add_shipping_vendor_employee_address($employeeId,$addressId);
							$roleID = $this->CI->user_m->add_shipping_vendor_employee_employee_role($employeeId,$organizationId);
							$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								$mailData = array(
													'email'         => $return['email'],
													'cc'	        => '',
													'slug'          => 'employee_sign_up_from_backend',
													'businessName'  => $return['businessName'],
													'username'		=> $return['userName'],
													'password'		=> $return['password'],
													'verifyUrl'     => base_url().'admin',
													'subject'       => 'Vendor employee Sign up Successfully',
												);	
														if($this->CI->email_m->send_mail($mailData))
									{
										$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_retailer'));
										$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_retailer'));
									}
									else
									{
										$this->CI->session->set_flashdata('error','Retailer create successfully but '.$this->CI->lang->line('error_mail_not_send'));
										$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_mail_not_send'));
									}	
								$this->CI->session->set_flashdata('success','Shipping employee Created Successfully');
								$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_reatiler_sign_up'));
							}							
							redirect(base_url().$userType.'/employee_management');							
						}
						else
						{
							$this->CI->session->set_flashdata('error','Shipping employee address not create');
							$this->CI->custom_log->write_log('custom_log','Shipping Vendor address not create');
						}
					}
					else
					{
						$this->CI->session->set_flashdata('error','Shipping employee not create');
						$this->CI->custom_log->write_log('custom_log','Shipping Vendor not create');
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping employee organization not crate');
					$this->CI->custom_log->write_log('custom_log','Shipping Vendore organization not crate');
				}
				
				if(($userType=='admin')||($userType=='superadmin'))
				{
					redirect(base_url().$userType.'/employee_management');
				}				
			}				
		}
		
		//$return['stateList'] = $this->CI->location_m->nigeria_state_list();
		$return['dropshipCentreList']  = $this->CI->retailer_m->dropship_center_list();
		return $return;
	}
	
	public function upload_shipping_vendor_image()
	{
		$image_name   = '';
		$newImageName = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = (time()*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/shipping/'; 
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
				$imagepath	  =	'uploads/shipping/'.$newImageName ;
				$newimagepath =	'uploads/shipping/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/shipping/thumb50/'.$newImageName;
				$this->CI->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
		}
		return $newImageName;
	}
	
	public function shipping_vendor_userDetails($organizationId)
	{
		$result = array();
		$result['imageName']     = '';
		$result['businessName']  = '';
		$result['businessPhone'] = '';
		$result['email']         = '';
		$result['street'] 	     = '';
		$result['countryName']   = '';
		$result['stateName']     = '';
		$result['areaName']	     = '';
		$result['cityName']	     = '';
		$result['firstName']     = '';
		$result['middleName']    = '';
		$result['lastName']      = '';
		$result['blockUnblock']  = 0;
		$result['employeeId']    = 0;
		$result['businessPhoneCode'] = '';
		$result['passwordStatus'] = 0;
		$result['requestStatus'] = 0;
		
		$employeeId = 0;
		$users_details = $this->CI->user_m->shipping_vendor_user_details($organizationId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$result['imageName'] 	 = $users_details->imageName;
			$result['businessName']  = $users_details->organizationName;
			$result['businessPhone'] = $users_details->businessPhone;
			$result['email'] 	     = $users_details->email;
			$result['street']    	 = $users_details->addressLine1;
			$result['countryName'] 	 = $users_details->countryName;
			$result['stateName']   	 = $users_details->stateName;
			$result['areaName']    	 = $users_details->areaName;
			$result['cityName']    	 = $users_details->cityName;
			$result['firstName']     = $users_details->firstName;
			$result['middleName']    = $users_details->middle;
			$result['lastName']      = $users_details->lastName;
			$result['blockUnblock']  = $users_details->active;
			$result['employeeId']    = $users_details->employeeId;
			$result['businessPhoneCode'] = $users_details->businessPhoneCode;
			$result['passwordStatus'] = $users_details->passwordStatus;
			$result['requestStatus'] = $users_details->requestStatus;
			$employeeId  = $users_details->employeeId;
		}
		
		/*$result['shippingRateList'] = $this->CI->shipping_m->shipping_vendor_rate_list($organizationId);
		if(empty($result['shippingRateList']))
		{
			if($employeeId)
			{
				$this->CI->user_m->deactivate_user($employeeId);
			}
		}*/
		$result['shippingRateList'] = $this->CI->shipping_m->total_shipping_vendor_rate_list($organizationId);
		if($result['shippingRateList'])
		{
		}
		else
		{
			if($employeeId)
			{
				$this->CI->user_m->deactivate_user($employeeId);
			}
		}
		//echo "<pre>"; print_r($result['shippingRateList']); exit;
		return $result;
	}
	public function shipping_vendor_employeeDetails($organizationId)
	{
		$result = array();
		$result['imageName']     = '';
		$result['businessName']  = '';
		$result['businessPhone'] = '';
		$result['email']         = '';
		$result['street'] 	     = '';
		$result['countryName']   = '';
		$result['stateName']     = '';
		$result['areaName']	     = '';
		$result['cityName']	     = '';
		$result['firstName']     = '';
		$result['middleName']    = '';
		$result['lastName']      = '';
		$result['blockUnblock']  = 0;
		$result['employeeId']    = 0;
		$result['businessPhoneCode'] = '';
		$result['passwordStatus'] = 0;
		$result['requestStatus'] = 0;
		$result['dropshipCentre']='';
		
		$employeeId = 0;
		$users_details = $this->CI->user_m->shipping_vendor_employee_details($organizationId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$result['imageName'] 	 = $users_details->imageName;
			$result['businessName']  = ''; //$users_details->organizationName;
			$result['businessPhone'] = $users_details->businessPhone;
			$result['email'] 	     = $users_details->email;
			$result['street']    	 = $users_details->addressLine1;
			$result['countryName'] 	 = $users_details->countryName;
			$result['stateName']   	 = $users_details->stateName;
			$result['areaName']    	 = $users_details->areaName;
			$result['cityName']    	 = $users_details->cityName;
			$result['firstName']     = $users_details->firstName;
			$result['middleName']    = $users_details->middle;
			$result['lastName']      = $users_details->lastName;
			$result['blockUnblock']  = $users_details->active;
			$result['employeeId']    = $users_details->employeeId;
			$result['businessPhoneCode'] = $users_details->businessPhoneCode;
			$result['passwordStatus'] = $users_details->passwordStatus;
			$result['requestStatus'] = $users_details->requestStatus;
		$result['dropshipCentre'] 	     = $this->CI->user_m->get_shipping_employee_dropship($users_details->employeeId);
		//print_r($return['dropshipCentre']);
			$employeeId  = $users_details->employeeId;
		}
		
		$result['shippingRateList'] = $this->CI->user_m->shipping_vendor_rate_list($organizationId);
		
		//echo "<pre>"; print_r($result['shippingRateList']); exit;
		return $result;
	}
	
	public function shipping_vendor_edit($organizationId)
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']     = '';
		$return['businessName']  = '';
		$return['businessPhone'] = '';
		$return['email']         = '';
		$return['street'] 	     = '';
		$return['countryName']   = '';
		$return['stateName']     = '';
		$return['areaName']     = '';
		$return['cityName']	     = '';
		$return['countryId']   = '154';
		$return['stateId']     = '';
		$return['cityId']	     = '';
		$return['firstName']     = '';
		$return['middleName']    = '';
		$return['lastName']      = '';
		$return['blockUnblock']  = 0;
		$return['employeeId']    = 0;
		$return['businessPhoneCode'] = '+234';
		$return['employeeId'] 	       = 0;
		$return['addressId'] 	       = 0;
		
		$users_details  = $this->CI->user_m->shipping_vendor_user_details($organizationId);
		//echo "<pre>"; print_r($users_details ); exit;
		if(!empty($users_details))
		{
			$return['imageName'] 	 = $users_details->imageName;
			$return['businessName']  = $users_details->organizationName;
			$return['businessPhone'] = $users_details->businessPhone;
			$return['email'] 	     = $users_details->email;
			$return['street']    	 = $users_details->addressLine1;
			$return['countryName'] 	 = $users_details->countryName;
			$return['stateName']   	 = $users_details->stateName;
			$return['areaName']   	 = $users_details->areaName;
			$return['cityName']    	 = $users_details->cityName;
			$return['firstName']     = $users_details->firstName;
			$return['middleName']    = $users_details->middle;
			$return['lastName']      = $users_details->lastName;
			$return['blockUnblock']  = $users_details->active;
			//$return['countryId']     = $users_details->country;
			$return['stateId']       = $users_details->state;
			$return['areaId']       = $users_details->areaId;
			$return['cityId']	     = $users_details->city;
			$return['employeeId']    = $users_details->employeeId;
			//$return['businessPhoneCode'] = $users_details->businessPhoneCode;
			$return['addressId'] 	     = $users_details->addressId;
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['formSubmit']  		   = 0;
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['lastName']  	 	   = $this->CI->input->post('lastName'); 
			$return['middleName']  	 	   = $this->CI->input->post('middleName'); 
			//$return['countryId']  	 	   = $this->CI->input->post('countryId');
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  	 	   = $this->CI->input->post('areaId');
			$return['cityId']  		 	   = $this->CI->input->post('cityId');
			$return['street']  		 	   = $this->CI->input->post('street');
			$return['businessName']  	   = $this->CI->input->post('businessName');
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone');
			$return['imageName']		   = $this->CI->input->post('imageName'); 
			$return['email']			   = $this->CI->input->post('email'); 
			$return['countryCode']   	   = $this->CI->input->post('countryCode'); 
			
			$rules = update_shipping_vendor_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$this->CI->user_m->update_shipping_vendor_organization($organizationId,$return);
				$this->CI->user_m->update_shipping_vendor_employee($return['employeeId'],$return);
				$this->CI->user_m->update_shipping_vendor_address($return['addressId'],$return);
				$this->CI->session->set_flashdata('success','Information updated successfully');
				redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($organizationId));				
			}	
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();	
		return $return;
	}
	
	public function shipping_vendor_employee_edit($organizationId)
	{
		$userType = $this->CI->session->userdata('userType');
		$return   = array();
		$return['imageName']     = '';
		$return['businessName']  = '';
		$return['businessPhone'] = '';
		$return['email']         = '';
		$return['street'] 	     = '';
		$return['countryName']   = '';
		$return['stateName']     = '';
		$return['areaName']     = '';
		$return['cityName']	     = '';
		$return['countryId']   = '154';
		$return['stateId']     = '';
		$return['cityId']	     = '';
		$return['firstName']     = '';
		$return['middleName']    = '';
		$return['lastName']      = '';
		$return['blockUnblock']  = 0;
		$return['employeeId']    = 0;
		$return['businessPhoneCode'] = '+234';
		$return['employeeId'] 	       = 0;
		$return['addressId'] 	       = 0;
		
		$users_details  = $this->CI->user_m->shipping_vendor_employee_details($organizationId);
		//echo "<pre>"; print_r($users_details ); exit;
		if(!empty($users_details))
		{
			$return['imageName'] 	 = $users_details->imageName;
			$return['businessName']  = ''; //$users_details->organizationName;
			$return['businessPhone'] = $users_details->businessPhone;
			$return['email'] 	     = $users_details->email;
			$return['street']    	 = $users_details->addressLine1;
			$return['countryName'] 	 = $users_details->countryName;
			$return['stateName']   	 = $users_details->stateName;
			$return['areaName']   	 = $users_details->areaName;
			$return['cityName']    	 = $users_details->cityName;
			$return['firstName']     = $users_details->firstName;
			$return['middleName']    = $users_details->middle;
			$return['lastName']      = $users_details->lastName;
			$return['blockUnblock']  = $users_details->active;
			//$return['countryId']     = $users_details->country;
			$return['stateId']       = $users_details->state;
			$return['areaId']       = $users_details->areaId;
			$return['cityId']	     = $users_details->city;
			$return['employeeId']    = $users_details->employeeId;
			//$return['businessPhoneCode'] = $users_details->businessPhoneCode;
			$return['addressId'] 	     = $users_details->addressId;	
			$return['dropshipCentre'] 	     = $this->CI->user_m->get_shipping_employee_dropship($users_details->employeeId);
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			$return['formSubmit']  		   = 0;
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['lastName']  	 	   = $this->CI->input->post('lastName'); 
			$return['middleName']  	 	   = $this->CI->input->post('middleName'); 
			//$return['countryId']  	 	   = $this->CI->input->post('countryId');
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  	 	   = $this->CI->input->post('areaId');
			$return['cityId']  		 	   = $this->CI->input->post('cityId');
			$return['street']  		 	   = $this->CI->input->post('street');
			$return['businessName']  	   = $this->CI->input->post('businessName');
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone');
			$return['imageName']		   = $this->CI->input->post('imageName'); 
			$return['email']			   = $this->CI->input->post('email'); 
			$return['countryCode']   	   = $this->CI->input->post('countryCode');
			$return['dropshipCentre']   	   = $this->CI->input->post('dropshipCentre'); 
			
			$rules = update_shipping_vendor_rules();
			$rules[]=	array(
									'field' => 'dropshipCentre[]',
									'label' => 'DropshipCentre',
									'rules' => 'trim|required'
								);
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$this->CI->user_m->update_shipping_vendor_employee_organization($organizationId,$return);
				$this->CI->user_m->delete_shipping_employee_dropship($return['employeeId']);
				foreach($return['dropshipCentre'] as $dropcenterId)
					{
						 $this->CI->user_m->add_shipping_employee_dropship($return['employeeId'],$dropcenterId);
					}
				$this->CI->user_m->update_shipping_vendor_employee($return['employeeId'],$return);
				$this->CI->user_m->update_shipping_vendor_address($return['addressId'],$return);
				$this->CI->session->set_flashdata('success','Information updated successfully');
				redirect(base_url().$this->CI->session->userdata('userType').'/employee_management/user_detail/'.id_encrypt($organizationId));				
			}	
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();	
		$return['dropshipCentreList']  = $this->CI->retailer_m->dropship_center_list();
		return $return;
	}
	
	public function shipping_vendor_sign_in()
	{
		if($_POST)
		{	
			$this->CI->custom_log->write_log('custom_log','Submit form data is '.print_r($_POST,true));
			$rules = sign_in_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
	    	{	
				$email    = $this->CI->input->post('email');
				$password = $this->CI->input->post('password');
				$result   = $this->CI->user_m->shipping_vendor_check_email($email);
				//print_r($result); exit;
				$this->CI->custom_log->write_log('custom_log','sql query for the retailer'.$this->CI->db->last_query());
				$this->CI->custom_log->write_log('custom_log','user details is '.print_r($result,true));
				if((!empty($result))&&(count($result)>0))
				{
					$block_status = $result->active;
					if(!$block_status)
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_block_user'));
						redirect(base_url());
					}
					
					$dbPassword      = $result->password;
					$master_password = $this->CI->config->item('master_password');
					$password_status = $result->passwordStatus;
					
					$this->CI->custom_log->write_log('custom_log','password condition is(!empty('.$dbPassword.')&&('.$dbPassword.'=='.password_encrypt($password).'))||(!empty('.$master_password.')&&('.$master_password.'=='.$password.'))'); 
					
					if((!empty($dbPassword)&&($dbPassword==password_encrypt($password)))||(!empty($master_password)&&($master_password==$password)))
					{ 
						$this->CI->custom_log->write_log('custom_log','login success'); 
						$this->CI->session->set_userdata(array(
								'userId'    	 => $result->employeeId,
								'userType' 		 => 'shipping',
								'userRole'		=>	$result->code,
								'userEmail'	 	 => $result->email,
								'userName'  	 => ucwords($result->firstName.' '.$result->middle.' '.$result->lastName),
								'userimage' 	 =>	$result->imageName,
								'organizationId' => $result->organizationId,
								'parentOrganizationId'=>$result->parentOrganizationId,
								));
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_login'));
						if($password_status)
						{
							if($result->code=="SVE")
							{
								redirect(base_url().'shipping/ready_to_shipped');
								
							}else
							{
								redirect(base_url().'shipping/rate_list');
							}
							
						}
						else
						{
							redirect(base_url().'shipping/first_change_password');
						}					
					}
					else
					{	
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_password'));
					}
				}
			}			
		}
	}
	
	public function shipping_vendor_rate_index($shippingOrgId)
	{
		$return 		 = array();
		$return['shippingRateList'] = $this->CI->user_m->shipping_vendor_rate_list($shippingOrgId);
		return $return;
	}
	
	public function shipping_vendor_edit_rate($shippingRateId)
	{
		$result = array();
		$result['fromZip'] 	     = '';
		$result['fromWeight']    = '';
		$result['toWeight']      = '';
		$result['amount'] 	     = '';
		$result['ETA'] 		     = '';
		$result['toCity']        = '';
		$result['shippingOrgId'] = '';
		$result['formSubmit']	 = 1;
		$shippingRateDet = $this->CI->shipping_m->shipping_vendor_rateDetails($shippingRateId);
		//echo "<pre>"; print_r($shippingRateDet); exit;
		$shippingOrgId = $shippingRateDet->shippingOrgId;
		if($_POST)
		{
			$result['amount'] = $this->CI->input->post('shippRate');
			$rules = shippin_rate_edit_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
	    	{
				if($this->CI->shipping_m->update_shipping_rate($shippingRateId,$result))
				{
					$this->CI->session->set_flashdata('success','Shipping rate updated successfully');
				}
				else
				{
					$this->CI->session->set_flashdata('error','Shipping rate not update');
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId));
			}
		}
		
		if($result['formSubmit'])
		{
			$result['fromZip'] 	     = $shippingRateDet->dropCenterName;
			$result['fromWeight']    = $shippingRateDet->fromWeight;
			$result['toWeight']      = $shippingRateDet->toWeight;
			$result['amount'] 	     = $shippingRateDet->amount;
			$result['ETA'] 		     = $shippingRateDet->ETA;
			$result['toCity'] 	     = $shippingRateDet->city;
			$result['shippingOrgId'] = $shippingRateDet->shippingOrgId;
		}
		return $result;
	}
	
	public function employee_sign_up()
	{
		$return   			 = array();
		$return['imageName'] = ''; 
		$return['firstName'] = '';
		$return['lastName']  = '';
		$return['salary']    = '';
		$return['phoneNo']   = ''; 
		$return['countryCode'] = '+234'; 
		$return['countryId'] = 154; 
		$return['stateId']   = ''; 
		$return['cityId']  	 = ''; 
		$return['street']  	 = ''; 
		$return['designation'] = ''; 
		$return['role']		   = array();
		$organizationId        = $this->CI->session->userdata('organizationId');
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log',print_r($_POST,true));
			
			$return['imageName']   = $this->CI->input->post('imageName'); 
			$return['firstName']   = $this->CI->input->post('firstName');
			$return['lastName']    = $this->CI->input->post('lastName');
			$return['salary']  	   = $this->CI->input->post('salary');
			$return['phoneNo']     = $this->CI->input->post('phoneNo');
			$return['stateId']     = $this->CI->input->post('stateId'); 
			$return['cityId']  	   = $this->CI->input->post('cityId'); 
			$return['street']  	   = $this->CI->input->post('street'); 
			$return['designation'] = $this->CI->input->post('designation'); 
			$return['role'] 	   = $this->CI->input->post('role'); 
			$rules = employee_sign_up();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$return['businessPhone'] = $return['phoneNo'];
				$return['userName'] 	 = $return['countryCode'].$return['businessPhone'];
				$employeeId 			 = $this->CI->retailer_m->add_retailer_employee($organizationId,$return);
				$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
				
				if($employeeId)
				{
					$addressId = $this->CI->retailer_m->add_retailer_employee_address($return);
					$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);	
					if($addressId)
					{
						$this->CI->retailer_m->add_retailer_employee_addressTbl($employeeId,$addressId);
						
						if(!empty($return['role']))
						{
							$this->CI->retailer_m->add_retailer_employee_role($organizationId,$employeeId,19);
							foreach($return['role'] as $roleId)
							{								
								$roleID = $this->CI->retailer_m->add_retailer_employee_role($organizationId,$employeeId,$roleId);
								$role_list .=$roleId.',';
								$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);	
							}
							
							if(!empty($return['designation']))
							{
							$designationId=$this->CI->retailer_m->add_designation_role($organizationId,$return['designation'],$role_list);
								$this->CI->retailer_m->add_employee_designation($employeeId,$designationId);
							}
						}
						
					}
					else
					{
						$this->CI->session->set_flashdata('error','retailer address not create');
						$this->CI->custom_log->write_log('custom_log','retailer address not create');
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Retailer employee not create');
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/employee_management');
			}							
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();
		$return['employeeRoleList'] = $this->CI->retailer_m->employee_roles();
		//echo "<pre>"; print_r($return['employeeRoleList']); exit;
		return $return;
	}
	
	public function my_request_list()
	{
		$return = array();
		echo $return['total'] = $this->CI->cse_m->total_my_retailer_request(); exit;
		return $return;
	}
	
	public function shipping_rates_list($shippingOrgId)
	{
		$return = array();
		$return['total'] = $this->CI->user_m->total_shipping_rates($shippingOrgId);
		return $return;
	}
	
	public function shipping_rates_list_ajax($total)
	{	
		//echo "<pre>"; print_r($_POST); exit;
		$return         = array();
		$shippingOrgId  = id_decrypt($this->CI->input->post('shippingOrgId'));
		$perPage        = $this->CI->input->post('sel_no_entry');
		$dropshipCenter = $this->CI->input->post('dropshipCenter');
		$stateName      = $this->CI->input->post('stateName');
		$areaName       = $this->CI->input->post('areaName');
		$cityName       = $this->CI->input->post('cityName');
		$weightFrom     = $this->CI->input->post('weightFrom');
		$weightTo		= $this->CI->input->post('weightTo');
		$eta     		= $this->CI->input->post('eta');
		$price          = $this->CI->input->post('price');
		$where          = '';
		if($dropshipCenter)
		{
			$where.='dropship_center.dropCenterName LIKE "'.$dropshipCenter.'%"';
		}
		if($stateName)
		{
			if($where)
			{
				$where.=' AND state.stateName LIKE "'.$stateName.'%"';
			}
			else
			{
				$where.='state.stateName LIKE "'.$stateName.'%"';
			}
		}
		if($areaName)
		{
			if($where)
			{
				$where.=' AND area.area LIKE "'.$areaName.'%"';
			}
			else
			{
				$where.='area.area LIKE "'.$areaName.'%"';
			}
		}
		if($cityName)
		{
			if($where)
			{
				$where.=' AND zip.city LIKE "'.$cityName.'%"';
			}
			else
			{
				$where.='zip.city LIKE "'.$cityName.'%"';
			}
		}
		if($weightFrom)
		{
			if($where)
			{
				$where.=' AND shipping_rate.fromWeight LIKE "'.$weightFrom.'%"';
			}
			else
			{
				$where.='shipping_rate.fromWeight LIKE "'.$weightFrom.'%"';
			}
		}
		if($weightTo)
		{
			if($where)
			{
				$where.=' AND shipping_rate.toWeight LIKE "'.$weightTo.'%"';
			}
			else
			{
				$where.='shipping_rate.toWeight LIKE "'.$weightTo.'%"';
			}
		}
		if($eta)
		{
			if($where)
			{
				$where.=' AND shipping_rate.ETA LIKE "'.$eta.'%"';
			}
			else
			{
				$where.='shipping_rate.ETA LIKE "'.$eta.'%"';
			}
		}
		if($price)
		{
			if($where)
			{
				$where.=' AND shipping_rate.amount LIKE "'.$price.'%"';
			}
			else
			{
				$where.='shipping_rate.amount LIKE "'.$price.'%"';
			}
		}
		
		if($where)
		{
			$total = $this->CI->user_m->total_shipping_rates($shippingOrgId,$where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/vendor_management/shippingRatesAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->user_m->shipping_rates_list($shippingOrgId,$page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function add_shipping_rates_from_10_to_30($shippingOrgId)
	{
		$returnArr = array();
		$returnArr['amount'] = '';
		$returnArr['eta']    = ''; 
			
		$list      = array();
		$rateDetails = $this->CI->shipping_m->shipping_rate_details_from_10_to_30($shippingOrgId);
		$this->CI->custom_log->write_log('custom_log','shipping rate details '.print_r($rateDetails,true));
		if($rateDetails)
		{
			$returnArr['amount'] = $rateDetails->amount;
			$returnArr['eta']    = $rateDetails->ETA;
		}
		//echo "<pre>"; print_r($rateDetails); exit;
		if($_POST)
		{
			$returnArr['amount'] = $this->CI->input->post('shippingRate');
			$returnArr['eta']    = $this->CI->input->post('estimateTime'); 
		
			$shippList = $this->CI->shipping_m->shipping_rates_list($shippingOrgId);
			$this->CI->custom_log->write_log('custom_log','shipp list is '.print_r($shippList,true));
			if(!empty($shippList))
			{
				foreach($shippList as $row)
				{
					$list[$row->fromZip][$row->toZip] = $row->toZip;	
				}
				$this->CI->custom_log->write_log('custom_log','list array is '.print_r($list,true));
				
				if(!empty($list))
				{
					$this->CI->custom_log->write_log('custom_log','after form submit '.print_r($_POST,true));
					$rules = add_shipping_rates_from_10_to_30_rules();
			
					$this->CI->form_validation->set_rules($rules);
					$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
					if($this->CI->form_validation->run())
					{
						$this->CI->shipping_m->delete_shipping_rates_from_10_to_30($shippingOrgId);
						if($this->CI->shipping_m->add_shipping_rates_from_10_to_30($shippingOrgId,$list))
						{
							$this->CI->session->set_flashdata('success','Shipping Rates added Successfully');
							$this->CI->custom_log->write_log('custom_log','Shipping Rates added Successfully');
							redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId));
						}
						else
						{
							$this->CI->session->set_flashdata('error','Shipping Rates not add');
							$this->CI->custom_log->write_log('custom_log','Shipping Rates not add');
							redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId));
						}
					}
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error','Shipping Rates not avaliable before');
				$this->CI->custom_log->write_log('custom_log','Shipping Rates not avaliable before');
				redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId));
			}
		}
		return $returnArr;
	}
}