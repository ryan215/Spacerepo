<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session','upload'));
		$this->CI->load->helper(array('url','form','cookie'));
		$this->CI->load->model(array('location_m','customer_m'));
	}
	
	public function customer_ajax()
	{
		$result	   = array();
		$where     = '';
		$per_page  = $this->CI->input->post('sel_no_entry');
		$firstName = $this->CI->input->post('firstName');
		$lastName  = $this->CI->input->post('lastName');
		$email	   = $this->CI->input->post('email');
		
		if(!empty($firstName))
		{
			$where = "customer.firstName LIKE '".$firstName."%'";
		}
		
		if(!empty($lastName))
		{
			if(!empty($where))
			{
				$where.= " AND customer.lastName LIKE '".$lastName."%'";
			}
			else
			{
				$where= "customer.lastName LIKE '".$lastName."%'";
			}
		}
		
		if(!empty($email))
		{
			if(!empty($where))
			{
				$where.= " AND customer.email LIKE '".$email."%'";
			}
			else
			{
				$where= "customer.email LIKE '".$email."%'";
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total = $this->CI->customer_m->total_customer_user($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/customer_management/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
		$this->CI->ajax_pagination->initialize($pagConfig);	
		$page  			 = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$result['links'] = $this->CI->ajax_pagination->create_links();
		$result['page']  = $page;
		$result['list']  = $this->CI->customer_m->customer_user_list($page,$pagConfig['per_page'],$where);
		return $result;
	}
	
	public function customer_details($customerId)
	{
		$result = array();
		$result['firstName']    = '';
		$result['lastName']     = '';
		$result['email'] 	    = '';
		$result['phone']        = '';
		$result['verified']     = 0;
		$result['isBlackList']  = 0;
		$result['isBlock']	    = 0;
		$result['stateName']    = '';
		$result['areaName']     = '';
		$result['cityName']     = '';
		$result['addressLine1'] = '';
		$result['addressLine2'] = '';
		$result['blockDate']    = '';		
		$customer_details 		= $this->CI->customer_m->customer_details($customerId);
		
		if(!empty($customer_details))
		{
			$result['firstName']    = $customer_details->firstName;
			$result['lastName']     = $customer_details->lastName;
			$result['email'] 	    = $customer_details->email;
			$result['phone']        = $customer_details->phone;
			$result['verified']     = $customer_details->verified;
			$result['isBlackList']  = $customer_details->isBlackList;
			$result['isBlock']	    = $customer_details->active;
			$result['stateName']    = $customer_details->stateName;
			$result['areaName']     = $customer_details->areaName;
			$result['cityName']     = $customer_details->cityName;
			$result['addressLine1'] = $customer_details->addressLine1;
			$result['addressLine2'] = $customer_details->address_Line2;
			$result['blockDate']	= $customer_details->blockDate;
		}
		return $result;
	}
	
	public function customer_unblock_block($customerId,$status)
	{
		if($this->CI->customer_m->block_unblock_user($customerId,$status))
		{			
			$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_change_status'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_change_status'));
			if($status)
			{
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_unblock_user'));
			}
			else
			{				
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_block_user'));
			}
			/********Add Customer Status History*************/
			$historyId = $this->CI->customer_m->add_block_unblock_history($customerId,$status);
			$this->CI->custom_log->write_log('custom_log','customer block unblock history id is '.$historyId);
			/********Add Customer Status History*************/
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_status'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_change_status'));
		}	
	}
	
	public function customer_in_black_list($customerId,$status)
	{
		if($this->CI->customer_m->update_black_list($customerId,$status))
		{		
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_change_status'));
			if($status)
			{
				$this->CI->session->set_flashdata('success','This customer add in black list');
			}
			else
			{				
				$this->CI->session->set_flashdata('success','This customer remove from black list');
			}
			/********Add Customer black list History*************/
			$historyId = $this->CI->customer_m->add_black_list_history($customerId,$status);
			$this->CI->custom_log->write_log('custom_log','customer black list history id is '.$historyId);
			/********Add Customer black list History*************/
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_status'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_change_status'));
		}	
	}
	
	public function customer_registration()
	{
		$return   			 = array();
		$return['imageName'] = ''; 
		$return['firstName'] = '';
		$return['lastName']  = '';
		$return['notes']    = '';
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
			$return['notes']  	   = $this->CI->input->post('notes');
			$return['phoneNo']     = $this->CI->input->post('phoneNo');
			$return['stateId']     = $this->CI->input->post('stateId'); 
			$return['cityId']  	   = $this->CI->input->post('cityId'); 
			$return['street']  	   = $this->CI->input->post('street'); 
			$return['designation'] = $this->CI->input->post('designation'); 
			$return['role'] 	   = $this->CI->input->post('role'); 
			$rules = retailer_customer_signup();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$return['businessPhone'] = $return['phoneNo'];
				$return['userName'] 	 = $return['countryCode'].$return['businessPhone'];
				$customerId 			 = $this->CI->customer_m->add_organization_customer($return,$this->CI->session->userdata('userId'));
				$this->CI->custom_log->write_log('custom_log','Employee id is '.$customerId);
				
				if($customerId)
				{
					$organizationcustomer=$this->CI->customer_m->add_retailer_customer($organizationId,$customerId);
					if(!empty($organizationcustomer))
					{
						$addressId=$this->CI->customer_m->add_address($return);
						if(!empty($addressId))
						{
							$customeraddressId=$this->CI->customer_m->add_customer_address($customerId,$addressId);
							$this->CI->session->set_flashdata('success','successfully added customer');
							
						}else
						{
							$this->CI->session->set_flashdata('error','not register customer address');
						}
					}
					
				
				}
				else
				{
					$this->CI->session->set_flashdata('error','Retailer employee not create');
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/customer_management');
			}							
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();
		$return['employeeRoleList'] = $this->CI->retailer_m->employee_roles();
		//echo "<pre>"; print_r($return['employeeRoleList']); exit;
		return $return;
	}

	public function news_letter_index()
	{
		$return = array();
		$return['total'] 		   = $this->CI->customer_m->total_news_letter();
		$return['totalVerified']   = $this->CI->customer_m->total_news_letter_verified();
		//$return['totalUnverified'] = $this->CI->customer_m->total_news_letter_unverified();
		return $return;
	}
	
	public function news_letter_ajaxFun($total)
	{
		$return    = array();
		$per_page  = $this->CI->input->post('sel_no_entry');
		$areaName  = $this->CI->input->post('areaName');
		$stateName = $this->CI->input->post('stateName');
		$where     = '';

		if(!empty($areaName))
		{
			$where = "area.area LIKE '".$areaName."%' ";
		}
		if(!empty($stateName))
		{
			$stw = '';
			if(!empty($where))
			{
				$stw = " AND ";
			}			
			$where.= $stw."state.stateName LIKE '".$stateName."%' ";
		}
		//echo $where; exit;
		if(!empty($where))
		{
			$total = $this->CI->customer_m->total_news_letter($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/news_management/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->customer_m->news_letter_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function news_letter_user_details($newsletterId)
	{
		$result = array();
		$result['firstName']   = '';
		$result['lastName']    = '';
		$result['email'] 	   = '';
		$result['phone']       = '';
		$result['stateId'] 	   = '';
		$result['cityId']      = '';
		$result['areaId']      = '';
		$result['gender']	   = '';
		$result['countryId']   = '';
		$result['countryName'] = '';
		$result['stateName']   = '';
		$result['areaName']    = '';
		$result['cityName']    = '';
		$result['phoneCode']   = '';
		
		$users_details = $this->CI->customer_m->news_letter_user_details($newsletterId);
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{			
			$result['firstName']   = $users_details->firstName;
			$result['lastName']    = $users_details->lastName;
			$result['email']       = $users_details->email;
			$result['phone']       = $users_details->phone;
			$result['countryId']   = $users_details->countryId;
			$result['stateId']     = $users_details->stateId;
			$result['areaId'] 	   = $users_details->areaId;
			$result['cityId']      = $users_details->cityId;
			$result['countryName'] = $users_details->countryName;
			$result['stateName']   = $users_details->stateName;
			$result['areaName']    = $users_details->areaName;
			$result['cityName']    = $users_details->cityName;
			$result['phoneCode']   = $users_details->phoneCode;
		}
		$result['subscribeList'] = $this->CI->customer_m->refer_friend_list($newsletterId);
		return $result;
	}
	
	public function pointeforce_ajax()
	{
		$result	   = array();
		$where     = '';
		$per_page  = $this->CI->input->post('sel_no_entry');
		$firstName = $this->CI->input->post('firstName');
		$lastName  = $this->CI->input->post('lastName');
		$email	   = $this->CI->input->post('email');
		
		if(!empty($firstName))
		{
			$where = "customer.firstName LIKE '".$firstName."%'";
		}
		
		if(!empty($lastName))
		{
			if(!empty($where))
			{
				$where.= " AND customer.lastName LIKE '".$lastName."%'";
			}
			else
			{
				$where= "customer.lastName LIKE '".$lastName."%'";
			}
		}
		
		if(!empty($email))
		{
			if(!empty($where))
			{
				$where.= " AND customer.email LIKE '".$email."%'";
			}
			else
			{
				$where= "customer.email LIKE '".$email."%'";
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total = $this->CI->pointe_force_m->total_pointe_force_user($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/customer_management/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
		$this->CI->ajax_pagination->initialize($pagConfig);	
		$page  			 = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$result['links'] = $this->CI->ajax_pagination->create_links();
		$result['page']  = $page;
		$result['list']  = $this->CI->pointe_force_m->pointe_force_user_list($page,$pagConfig['per_page'],$where);
		return $result;
	}	
	
	public function pointeforce_details($customerId)
	{
		$result = array();
		$result['firstName']    = '';
		$result['lastName']     = '';
		$result['email'] 	    = '';
		$result['phone']        = '';
		$result['stateName']    = '';
		$result['areaName']     = '';
		$result['cityName']     = '';
		$result['addressLine1'] = '';
		$result['addressLine2'] = '';
		$result['verifiedCommision'] = 0;	
		$result['isBlock']	    = 0;
		$result['blockDate']    = '';
		$customer_details = $this->CI->pointe_force_m->pointe_force_details($customerId);
		//echo "<pre>"; print_r($customer_details); exit;
		if(!empty($customer_details))
		{
			$result['firstName']    = $customer_details->firstName;
			$result['lastName']     = $customer_details->lastName;
			$result['email'] 	    = $customer_details->email;
			$result['phone']        = $customer_details->phone;
			$result['stateName']    = $customer_details->stateName;
			$result['areaName']     = $customer_details->areaName;
			$result['cityName']     = $customer_details->cityName;
			$result['addressLine1'] = $customer_details->addressLine1;
			$result['addressLine2'] = $customer_details->address_Line2;
			$result['verifiedCommision'] = $customer_details->verifiedStatus;
			$result['isBlock']	    = $customer_details->active;
			$result['blockDate']	= $customer_details->blockDate;			
		}
		return $result;
	}
	
	public function pointeforce_verified_commission($customerId)
	{
		if($this->CI->pointe_force_m->old_verify_status_change($customerId))
		{
			$pointeForceVerifyId = $this->CI->pointe_force_m->add_pointe_force_verification($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force verifed id is '.$pointeForceVerifyId);
			
			if($pointeForceVerifyId)
			{
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_change_status'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_change_status'));
			}
			else
			{
				$this->CI->session->set_flashdata('error','Verification status not create');
				$this->CI->custom_log->write_log('custom_log','Verification status not create');
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_status'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_change_status'));
		}
	}
	
	public function pointeforce_unverified_commission($customerId)
	{
		if($this->CI->pointe_force_m->old_verify_status_change($customerId))
		{
			$pointeForceVerifyId = $this->CI->pointe_force_m->add_pointe_force_unverification($customerId);
			$this->CI->custom_log->write_log('custom_log','pointe force verifed id is '.$pointeForceVerifyId);
			
			if($pointeForceVerifyId)
			{
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_change_status'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_change_status'));
			}
			else
			{
				$this->CI->session->set_flashdata('error','UnVerification status not create');
				$this->CI->custom_log->write_log('custom_log','UnVerification status not create');
			}
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_change_status'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_change_status'));
		}
	}
}