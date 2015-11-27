<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Retailer_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Retailer Managment';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_index',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->profile_lib->retailer_index();
		$this->superAdminCustomView('admin/retailer_managements/retailer_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->retailer_ajaxFun($total);
		$this->load->view('admin/retailer_managements/ajaxPagView',$this->data);
	}
	
	public function addRetailer()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addRetailer',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] 		   = 'Add Retailer';
		$result 					   = $this->profile_lib->retailer_sign_up();
		$this->data['result'] 		   = $result;		
		$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/retailer_management/upload_retailer_image/';
		$this->superAdminCustomView('admin/retailer_managements/addRetailer',$this->data);	
	}
	
	public function editRetailer($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editRetailer',
				'log_MID'    => '' 
		) );
		
		$organizationId 				   = id_decrypt($organizationId);
		$this->data['result'] 		   = $this->profile_lib->retailer_edit($organizationId);
		$this->data['organizationId']      = $organizationId;
		$this->data['employeeId']      = $this->data['result']['employeeId'];
		$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/retailer_management/upload_retailer_image/';
		$this->superAdminCustomView('admin/retailer_managements/editRetailer',$this->data);		
	}
	
	public function businessPhone()
	{
		$employeeId    = $this->input->post('employeeId');
		$businessPhone = $this->input->post('businessPhone');
		$details       = $this->user_m->check_business_phone_exits($employeeId,$businessPhone);
		if(!empty($details))
		{
			$this->form_validation->set_message('businessPhone', 'The %s field already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function email_exits()
	{
		$employeeId = $this->input->post('employeeId');
		$email      = $this->input->post('email');
		if(!empty($email))
		{
			$details    = $this->user_m->check_email_exits($employeeId,$email);
			if(!empty($details))
			{
				$this->form_validation->set_message('email_exits','The %s field already exits');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return TRUE;	
		}
	}
	
	public function user_detail($organizationId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	

		$organizationId 		  = id_decrypt($organizationId);
		$this->data['result']     = $this->profile_lib->retailer_userDetails($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->data['employeeId'] = $this->data['result']['employeeId'];
		$this->superAdminCustomView('admin/retailer_managements/user_details',$this->data);
	}
	
	public function unblock_block($employeeId,$status)
	{
		$employeeId = id_decrypt($employeeId);
		if(!empty($employeeId))
		{
			$return = $this->profile_lib->block_unblock($employeeId,$status);
			if($return)
			{
				if(!$status)
				{
					$this->session->set_flashdata('success',$this->lang->line('success_block_user'));
				}
				else
				{
					$this->session->set_flashdata('success',$this->lang->line('success_unblock_user'));
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_not_update'));
			}			
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_invalie_id'));
		}		
		redirect(base_url().$this->session->userdata('userType').'/retailer_management');
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
	
	public function assign_cse($retailerId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'assign_cse',
				'log_MID'    => '' 
		) );	

		$retailerId 			  = id_decrypt($retailerId);
		$this->data['result']     = $this->profile_lib->addEditAssignCSE($retailerId);		
		$this->data['retailerId'] = $retailerId;
		$this->adminCustomView('retailer_managements/assign_cse',$this->data);
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
			$details = $this->user_m->check_username_exits('',$businessPhone);
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
	}
	public function check_stocks($organizationId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stocks',
				'log_MID'    => '' 
		) );	
		$organizationId = id_decrypt($organizationId);
		$this->data['result']     = $this->product_lib->check_stocks_index($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('retailer_managements/check_stocks',$this->data);
	}
	
	public function check_stocksAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stocksAjaxFun',
				'log_MID'    => '' 
		) );

		$this->data['result'] = $this->product_lib->check_stocksAjaxFun($total);
		$this->load->view('retailer_managements/check_stocksAjaxFun',$this->data);
	}
	
	public function request_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'request_list',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->profile_lib->request_request_list();
		$this->superAdminCustomView('admin/retailer_managements/request_list',$this->data);
	}
	
	public function requestAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'requestAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->retailer_requestAjaxFun($total);
		$this->load->view('admin/retailer_managements/requestAjaxFun',$this->data);
	}
	
	public function request_user_detail($employeeId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'request_user_detail',
				'log_MID'    => '' 
		) );	

		$employeeId 		  = id_decrypt($employeeId);
		$result = $this->profile_lib->retailer_RequestUserDetails($employeeId);
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->data['reason'] = '';
		if($_POST)
		{
			$rules = retailer_declined_rules();
			$this->data['reason'] = $this->input->post('comment');
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				if($this->user_m->decline_retailer_request($employeeId))
				{
					if(!empty($result['email']))
					{
						$mailData = array(
										'email'    => $result['email'],
										'cc'	   => '',
										'slug'     => 'retailer_decline',
										'name'     => $result['businessName'],
										'reason'   => $this->data['reason'],
										'subject'  => 'Retailer Declined',
									);										
						if($this->email_m->send_mail($mailData))
						{
							$this->session->set_flashdata('success',$this->lang->line('success_add_retailer'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
						}
						else
						{
							$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}	
					}
					$message = 'You request to sell on pointemart is declined and the reason for this is '.$this->data['reason'].' , For any queries kindly feel free to call us at '.$this->config->item('admin_phone_no').' or email us at '.$this->config->item('admin_email');
					$rs = $this->twillo_m->send_mobile_message('',trim($result['businessPhoneCode']).trim($result['businessPhone']),$message);
					$this->session->set_flashdata('success',$this->lang->line('success_decline_request'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_decline_request'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_decline_request'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_decline_request'));
				}
				redirect(base_url().$this->session->userdata('userType').'/retailer_management/request_list');	
			}
		}
		$this->data['result'] = $result;
		$this->data['employeeId'] = $employeeId;
		$this->data['organizationId'] = $employeeId;		
		$this->superAdminCustomView('admin/retailer_managements/request_user_detail',$this->data);
	}
	
	public function accept_request($employeeId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'accept_request',
				'log_MID'    => '' 
		) );	

		$employeeId = id_decrypt($employeeId);
		if(!empty($employeeId))
		{
			$details = $this->user_m->retailerRequestDetails($employeeId);
			if(!empty($details))
			{
				if($this->user_m->accept_retailer_request($employeeId))
				{
					$cseName = $details->cseName;
					$emailId = $details->email;
					$countryCOde = trim($details->businessPhoneCode);
					$businessPh  = trim($details->businessPhone);
					if(!empty($cseName))
					{
						$message = 'Your account has been approved to sell on pointemart. All you need to do is  choose products you want to sell from our product catalogue, Set the price and inventory. '.$cseName.' has been assigned to handle your account so for any queries kindly feel free to call us at '.$this->config->item('admin_phone_no').' or email us at '.$this->config->item('admin_email').' and ask help from '.$cseName;
						if(!empty($emailId))
						{
							$mailData = array(
											'email'    => $emailId,
											'cc'	   => '',
											'slug'     => 'retailer_accept_with_cse',
											'name'     => $details->organizationName,
											'message'  => $message,
											'subject'  => 'Retailer Sign up Successfully',
										);										
							if($this->email_m->send_mail($mailData))
							{
								$this->session->set_flashdata('success',$this->lang->line('success_add_retailer'));
								$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
							}
							else
							{
								$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));
								$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
							}	
						}
						
						$rs = $this->twillo_m->send_mobile_message('',$countryCOde.$businessPh,$message);
					}
					else
					{
						if(!empty($emailId))
						{
							$mailData = array(
											'email'    => $emailId,
											'cc'	   => '',
											'slug'     => 'retailer_accept_without_cse',
											'name'     => $details->organizationName,
											//'password' => $return['password'],
											'subject'  => 'Account approved to sell on Pointemart',
										);										
							if($this->email_m->send_mail($mailData))
							{
								$this->session->set_flashdata('success',$this->lang->line('success_add_retailer'));
								$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
							}
							else
							{
								$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));
								$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
							}	
						}
							$message = 'Your account has been approved to sell on pointemart. All you need to do is  choose products you want to sell from our product catalogue, Set the price and inventory. For any queries kindly feel free to call us at '.$this->config->item('admin_phone_no').' or email us at '.$this->config->item('admin_email');
 							$rs      = $this->twillo_m->send_mobile_message('',$countryCOde.$businessPh,$message);
					}
					
					$this->session->set_flashdata('success',$this->lang->line('success_accept_request'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_accept_request'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_accept_request'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_accept_request'));
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_details_no_found'));
				redirect(base_url().$this->session->userdata('userType').'/retailer_management/request_user_detail/'.id_encrypt($employeeId));
			}
		}
		redirect(base_url().$this->session->userdata('userType').'/retailer_management/request_list');		
	}
	
	public function editRetailerRequest($employeeId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editRetailerRequest',
				'log_MID'    => '' 
		) );
		
		$employeeId 				   = id_decrypt($employeeId);
		$this->data['result'] 		   = $this->profile_lib->retailer_edit($employeeId);
		$this->data['employeeId']      = $employeeId;
		$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/retailer_management/upload_retailer_image/';
		$this->data['organizationId'] = $employeeId;
		$this->superAdminCustomView('admin/retailer_managements/editRetailer',$this->data);		
	}
	
	public function request_assign_cse($retailerId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'assign_cse',
				'log_MID'    => '' 
		) );	

		$retailerId 			  = id_decrypt($retailerId);
		$this->data['result']     = $this->profile_lib->addEditAssignCSE($retailerId);		
		$this->data['retailerId'] = $retailerId;
		$this->adminCustomView('retailer_managements/assign_cse',$this->data);
	}
	
	public function request_history_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'request_list',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->profile_lib->retailer_request_history_list();
		$this->superAdminCustomView('admin/retailer_managements/request_history_list',$this->data);
	}
	
	public function requestHistoryAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'requestAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->retailer_requestHistoryAjaxFun($total);
		$this->load->view('admin/retailer_managements/requestHistoryAjaxFun',$this->data);
	}
	
	public function request_history_user_detail($employeeId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'request_history_user_detail',
				'log_MID'    => '' 
		) );	

		$employeeId 		  = id_decrypt($employeeId);
		$this->data['result'] = $this->profile_lib->retailer_RequestUserDetails($employeeId);
		$this->data['employeeId'] = $employeeId;
		$this->superAdminCustomView('admin/retailer_managements/request_history_user_detail',$this->data);
	}
}