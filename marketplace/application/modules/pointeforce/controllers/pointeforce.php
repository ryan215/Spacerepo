<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Pointeforce extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
		$this->load->model(array('auth_m','pointe_force_m'));
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pointeforce_index',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Pointeforce';
		
		$result = array(
					'firstName' => '',
					'lastName'  => '',
					'email'		=> '',
					'stateId'   => '',
					'areaId'    => '',
					'cityId'    => '',
					'phoneNo'   => '',
					'year'      => '',
					'month'		=> '',
					'date'		=> ''
				  );
		if($_POST)
		{	
			$this->custom_log->write_log('custom_log', 'Pointe force Form submit '.print_r($_POST,TRUE));
			//print_r($_POST); exit;
			//if((!empty($_POST['pointeForceSub']))&&($_POST['pointeForceSub']=='POINTEFORCE'))
			if((!empty($_POST['POINTEFORCESIGNUP']))&&($_POST['POINTEFORCESIGNUP']=='POINTEFORCESIGNUP'))
			{
				$result['firstName'] = $this->input->post('firstName');
				$result['lastName']  = $this->input->post('lastName');
				$result['email']     = $this->input->post('email');
				$result['stateId']   = $this->input->post('stateId');
				$result['areaId']    = $this->input->post('areaId');
				$result['cityId']    = $this->input->post('cityId');
				$result['phoneNo']   = $this->input->post('phoneNo');
				$result['date']		 = $this->input->post('date');
				$result['month']	 = $this->input->post('month');
				$result['year']		 = $this->input->post('year');
				$result['street']    = $this->input->post('address1');
				$result['password']  = $this->input->post('password');			
				if($result['email'])	
				{
					$result['email'] = html_entity_decode($result['email']);
				}
				
				$rules = pointe_force_sign_up_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run()) 
				{								
					$result['birthDate'] = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('date');		
					$result['varifyCode'] = new_random_password();					
					$customerId = $this->pointe_force_m->add_pointeforce_as_customer($result);
					$this->custom_log->write_log('custom_log','customer id is '.$customerId);
					
					if($customerId)
					{
						$addressId = $this->pointe_force_m->add_address_pointe_force($result);
						$this->custom_log->write_log('custom_log','pointe force address id is '.$addressId);
						
						if($addressId)
						{
							$this->pointe_force_m->add_pointe_force_address($customerId,$addressId);
							$this->custom_log->write_log('custom_log','customer added to address successfully');
							
							$pointeForceVerifyId = $this->pointe_force_m->add_pointe_force_unverification($customerId);
							$this->custom_log->write_log('custom_log','pointe force verified id is '.$pointeForceVerifyId);
							
							if($pointeForceVerifyId)
							{
								$mailData = array(
												'email'      => $result['email'],
												'cc'         => '',
												'slug'       => 'pointe_force_verify',
												'name'       => $result['firstName'].' '.$result['lastName'],
												'password'   => $result['password'],
												'subject'    => 'Verify your PointeForce Account',
												'varify_url' => $this->config->item('customer_url').'auth/varification/'.id_encrypt($customerId).'/'.$result['varifyCode'],
											);
								if($this->email_m->send_mail($mailData)) 
								{
									$this->custom_log->write_log('custom_log','Send Mail : '.$this->email->print_debugger());
								}
								else 
								{
									$this->custom_log->write_log ('custom_log','Not Send Mail : '.$this->email->print_debugger());
								}
								
								/**********pointeforce***********/
								$pointeForceId = $this->user_m->add_pointe_force($result);
								$this->custom_log->write_log('custom_log','pointe force id is '.$pointeForceId);
								$this->user_m->add_pointe_force_address($pointeForceId,$addressId);
								/**********pointeforce**********/
								$this->session->set_flashdata('success','Thank you for registering with PointeForce. Kindly verify your account by following the instructions sent to your registered email address.');
							}
						}
						else
						{
							$this->session->set_flashdata('error','address not create');
							$this->custom_log->write_log('custom_log','address not create');
						}
						$this->session->set_flashdata('success','Thank you for registering with PointeForce. Kindly verify your account by following the instructions sent to your registered email address.');
					}
					else
					{
						$this->session->set_flashdata('error','Information not add');
						$this->custom_log->write_log('custom_log','Information not add');
					}
					redirect(base_url().'pointeforce');
				}
			}
		}
		$this->data['stateList'] = $this->location_m->nigeria_state_list();
		$this->data['result'] 	 = $result;
		$this->frontendCustomView('pointe_force/add_pointe_force',$this->data);
	}	
	
	public function customer_request()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'customer_request',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Pointeforce';
		
		if($_POST)
		{	
			$this->custom_log->write_log('custom_log', 'Pointe force Form submit '.print_r($_POST,TRUE));
			//echo "<pre>"; print_r($_POST); exit;
			if((!empty($_POST['pointeForceReq']))&&($_POST['pointeForceReq']=='POINTEFORCEREQUEST'))
			{
				$email    = $this->input->post('email');
				$password = $this->input->post('password');			
				if($email)	
				{
					$email = html_entity_decode($email);
				}
				
				$rules = customer_pointe_force_request_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run()) 
				{
					$result = $this->pointe_force_m->customer_pointe_force($email);
					$this->custom_log->write_log('custom_log','customer details is '.print_r($result,TRUE));
					
					if(!empty($result)&&(count($result)>0))
					{
						if(!empty($result->isPointeForce)&&($result->isPointeForce))
						{
							$this->session->set_flashdata('error','You are already a Pointeforce member');
							redirect(current_url());
						}
						
						$block_status = $result->active;
						if(!$block_status)
						{
							$this->session->set_flashdata('error',$this->lang->line('error_block_user'));
							redirect(current_url());
						}
						
						$blockDate 		 = $result->blockDate;
						$dbPassword      = $result->password;
                        $master_password = $this->config->item('master_password');
							
						if($result->verified) 
						{
							if((!empty($dbPassword)&&($dbPassword==password_encrypt($password)))||(!empty($master_password)&&($master_password==$password)))
							{	
								if($this->pointe_force_m->customer_as_request_for_pointeforce($result->customerId))
								{
									$this->pointe_force_m->old_verify_status_change($result->customerId);
									$this->custom_log->write_log('custom_log','unactive old status of customer');
			
									$pointeForceVerifyId = $this->pointe_force_m->add_pointe_force_unverification($result->customerId);
									$this->custom_log->write_log('custom_log','pointe force verified id is '.$pointeForceVerifyId);
									if($pointeForceVerifyId)
									{
										$this->session->set_userdata (array(
													'userId'          => $result->customerId,
													'userType'        => 'customer',
													'userEmail'       => $result->email,
													'userName'        => ucwords ($result->firstName.' '.$result->lastName),
													'userimage'       => '',
													'isPointeForce'   => 1,
													'isMarketingUser' => 0
												));
										
										redirect(base_url().'frontend/dashboard');
									}
									else
									{
										$this->session->set_flashdata('error','Pointe force request not send');
										$this->custom_log->write_log('custom_log','Pointe force request not send');
									}
								}
								else
								{
									$this->session->set_flashdata('error','Please try again');
									$this->custom_log->write_log('custom_log','Please try again');	
								}
							}
							else 
							{
								$this->session->set_flashdata('error','invalid password');
								$this->custom_log->write_log('custom_log','invalid password');
                            }
						}
						else 
						{
							$this->session->set_flashdata('error',$this->lang->line ('error_veryfy_email'));
							$this->custom_log->write_log('custom_log',$this->lang->line ('error_veryfy_email'));
                        }
                    } 
					else 
					{						
						$this->session->set_flashdata('error',$this->lang->line('error_email_password'));
                        $this->custom_log->write_log('custom_log',$this->lang->line('error_email_password'));
                    }                
					redirect(base_url().'pointeforce/customer_request');
				}
			}
		}
		
		$this->frontendCustomView('pointe_force/customer_request',$this->data);
	}	
	
	public function login_customer_request_for_pointe_force()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'login_customer_request_for_pointe_force',
				'log_MID'    => '' 
		) );
		
		$customerId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','customer id is '.$customerId);
		
		if((!empty($customerId))&&($customerId))
		{
			if($this->pointe_force_m->customer_as_request_for_pointeforce($customerId))
			{
				$this->custom_log->write_log('custom_log','customer change as pointeforce');
				
				$this->pointe_force_m->old_verify_status_change($customerId);
				$this->custom_log->write_log('custom_log','unactive old status of customer');
				
				$pointeForceVerifyId = $this->pointe_force_m->add_pointe_force_unverification($customerId);
				$this->custom_log->write_log('custom_log','pointe force verified id is '.$pointeForceVerifyId);
				if($pointeForceVerifyId)
				{
					$this->session->set_userdata('isPointeForce',1);
				}
				else
				{
					$this->session->set_flashdata('error','Pointe force request not send');
					$this->custom_log->write_log('custom_log','Pointe force request not send');
				}
			}
			else
			{
				$this->session->set_flashdata('error','Please try again');
				$this->custom_log->write_log('custom_log','Please try again');	
			}
		}
		else
		{
			$this->session->set_flashdata('error','Please Login first');
            $this->custom_log->write_log('custom_log','Please Login first');
        }
		redirect(base_url().'pointeforce');
	}
	
	public function pay_on_delivery()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pay_on_delivery',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Pay On Delivery';
		
		$this->frontendCustomView('pointe_force/pay_on_delivery',$this->data);
	}	
	
	public function alpha_numeric_space_val()
	{
		$str = $this->input->post('address1');
		if(is_numeric($str))
		{
		 	$this->form_validation->set_message('alpha_numeric_space_val', 'The %s field cannot have only numeric values.');
			return FALSE;
		}
		else
		{
			return TRUE;			
		}
	}	
	
	public function unique_customer_user()
	{
		$email = trim($this->input->post('email'));
		if(!empty($email))
		{
			$details = $this->pointe_force_m->check_unique_customer_user($email);
			if(!empty($details))
			{
				$this->form_validation->set_message('unique_customer_user','Your email is already registered on PointeMart.
Please use another email address to register on PointeForce');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
		 	$this->form_validation->set_message('unique_customer_user', 'The %s field is required.');
			return FALSE;
		}
	}
	
	public function forgot_password()
	{
		$this->frontendCustomView('pointe_force/forgot_password',$this->data);
	}
}