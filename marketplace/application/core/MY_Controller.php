<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $data             = array();
	public $tables           = array();
	public $currentDate      = '';
	public $currentDateTime  = '';
	public $currentTime      = '';
	public $currentTimestamp = '';
 
	// constructor of this controller

	public function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Africa/Algiers');
    	$this->currentDate      = date('Y-m-d');
		$this->currentDateTime  = date('Y-m-d H:i:s');
		$this->currentTime      = date('H:i:s');
		$this->currentTimestamp = time();				
	
		$this->load->model(array('common_model','segment_cat_m','staff_management_m','location_m','product_m','user_m','brand_m','retailer_m','cse_m','order_m','order_pickup_m','shipping_m','twillo_m','location_m','customer_m','market_management_m','cart_m'));
		$this->load->library(array('ajax_pagination','upload','profile_lib','product_lib','order_lib','order_pickup_lib','category_lib','location_lib','carabiner','cart'));
		$this->load->helper(array('product','validation_rule','retailer','image','custom_url'));
		
		$this->tables = $this->common_model->tables;		
		$this->loader = '<img src="'.base_url().'img/ajax_loading.gif">';
		$this->data['userpermission']=$this->session->userdata('userpermission');
		//print_r($userpermission);
		
		$this->_check_and_redirect();
	} 

	public function _check_and_redirect() 
	{
		//echo "<pre>"; print_r($this->session->all_userdata()); exit;
		$userId    = $this->session->userdata('userId');
		$userType  = $this->session->userdata('userType');
		$userEmail = $this->session->userdata('userEmail');
		
		$segment1  = $this->uri->segment(1);
		$segment2  = $this->uri->segment(2);
		$segment3  = $this->uri->segment(3);
		
		if((!empty($userId))&&(!empty($userEmail)))		
		{
			if($segment2=='first_change_password')
			{
			}
			elseif((($userType=='superadmin')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='login')||($segment1!='superadmin')))
			{
				redirect(base_url().'superadmin/dashboard');
			}
			elseif((($userType=='admin')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='login')||($segment1!='admin')))
			{
				redirect(base_url().'admin/dashboard');
			}
			elseif((($userType=='cse')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='login')||($segment1!='cse')))
			{
				redirect(base_url().'cse/dashboard');
			}
			if((($userType=='retailer')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='home')))
			{	
				redirect(base_url().'retailer/product_management');
			}
			elseif((($userType=='shipping_vendor')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='login')||($segment1!='shipping_vendor')))
			{
				redirect(base_url().'shipping_vendor/details');
			}			
			elseif(($userType=='customer')&&(($segment3=='sign_in')||($segment3=='sign_up')||($segment1=='superadmin')||($segment1=='admin')||($segment1=='cse')||($segment1=='retailer')))
			{
				redirect(base_url());
			}
			elseif((($userType=='pointeforce')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='login')||($segment2=='pay_on_delivery')||($segment1!='pointeforce')))
			{
				redirect(base_url().'pointeforce/dashboard');
			}
		}
		elseif(!empty($userId))
		{
			if((($userType=='retailer')&&($segment2!='logout'))&&(($segment1=='')||($segment2=='home')))
			{	
				redirect(base_url().'retailer/product_management');
			}
		}
		else
		{
			if(($segment1=='admin')||($segment1=='superadmin'))
			{
				redirect(base_url().'backend');
			}
			elseif(($segment1=='retailer')&&(($segment2!='home')&&($segment2!='location_management')))
			{
				redirect(base_url().'retailer/home');
			}	
			elseif(($segment1=='frontend')&&(($segment2=='checkout')||($segment2=='dashboard')||($segment2=='order')||($segment3=='seller_rating')||($segment3=='buy_now')))
			{
				$this->session->set_flashdata('error','Please Login First');
				redirect(base_url());
			}	
									
		}
	}
				
	//	Function for superadmin custom view after login
	public function superAdminCustomView($viewName,$viewData = false)
	{
		$this->load->view('superAdminHeader',$viewData);
		$this->load->view('superAdminLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('superAdminFooter');
	}

	//	Function for admin custom view after login
	public function adminCustomView($viewName,$viewData = false)
	{
		$this->load->view('adminHeader',$viewData);
		$this->load->view('adminLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('adminFooter');
	}
	
	//	Function for login , reset password, confirm password change for admin & superadmin
	public function customLoginView($viewName,$viewData = false)
	{
		$this->load->view('loginHeader',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('loginFooter');
	}
	
	//	Function for reatiler user affter login
	public function retailerCustomView($viewName,$viewData = false)
	{
		$this->load->view('retailerHeader',$viewData);
		$this->load->view('retailerLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('retailerFooter');
	}
	
	//	Function for reatiler frontedn for home page and sign up page
	public function retailerFrontCustomView($viewName,$viewData = false)
	{
		$this->load->view('retailerFrontHeader',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('retailerFrontFooter');
	}
		
	//	Function for frontend Home page
	public function frontendCustomView($viewName,$viewData = false)
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'frontendCustomView',
				'log_MID'    => '' 
		) );
		
		$emailIn    = '';
        $passwordIn = '';
		
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			if((!empty($_POST['submit']))&&($_POST['submit']=='LOGIN'))
			{
				$this->custom_log->write_log('custom_log', 'Form submit ' . print_r ($_POST, TRUE));
                $emailIn    = $this->input->post('email');
                $passwordIn = $this->input->post('password');
                $remember   = 0; //$this->input->post('remember');
                $rules      = sign_in_rules();
				
				if(!empty($emailIn))
				{
					$emailIn = html_entity_decode($emailIn);
				}
				
                $this->form_validation->set_rules ($rules);
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
				if($this->form_validation->run())
				{
					$result = $this->customer_m->sign_in($emailIn);
					$this->custom_log->write_log('custom_log','customer details is '.print_r($result,TRUE));
					
					if(!empty($result)&&(count($result)>0))
					{
						$block_status = $result->active;
						if(!$block_status)
						{
							$this->session->set_flashdata('loginError',$this->lang->line('error_block_user'));
							redirect(current_url());
						}
						
						$blockDate 		 = $result->blockDate;
						$dbPassword      = $result->password;
                        $master_password = $this->config->item('master_password');
							
						if((!empty($dbPassword)&&($dbPassword==password_encrypt($passwordIn)))||(!empty($master_password)&&($master_password==$passwordIn)))
						{
						}
						elseif((!empty($blockDate))&&($blockDate==date('Y-m-d')))
						{
							$name 	  = $result->firstName.' '.$result->lastName;
                        	$password = rand(0,999999999);
								
							if($this->customer_m->update_reset_code($emailIn,$password))
							{
								$data = array(
											'email'             => $emailIn,
											'slug'              => 'forgot_password',
											'businessOwnerName' => $name,
											'password'          => $password,
											'cc'                => '',
											'subject'           => 'Reset Password',
										);
								if($this->email_m->send_mail($data)) 
								{
									$this->custom_log->write_log('custom_log','Send Mail : '.$this->email->print_debugger());
								} 
								else 
								{
									$this->custom_log->write_log('custom_log','Not Send Mail : '.$this->email->print_debugger());
								}
							
								$this->custom_log->write_log('custom_log','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
							}
							
							$this->session->set_flashdata('loginError','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
							redirect(current_url());
						}
						
						if($result->verified) 
						{
							if((!empty($dbPassword)&&($dbPassword==password_encrypt($passwordIn)))||(!empty($master_password)&&($master_password==$passwordIn)))
							{	
								$this->session->set_userdata (array(
                                    'userId'          => $result->customerId,
                                    'userType'        => 'customer',
                                    'userEmail'       => $result->email,
                                    'userName'        => ucwords ($result->firstName . ' ' . $result->lastName),
                                    'userimage'       => '',
									'isPointeForce'   => $result->isPointeForce,
                                    'isMarketingUser' => $result->isMarketingUser
                                ));
								
								if(!empty($remember)) 
								{
                                	$email_cookie = array(
                                    				    'name'   => 'email',
				                                        'value'  => $result->email,
				                                        'expire' => $this->config->item ('user_expire'),
				                                    );
                                    $this->input->set_cookie ($email_cookie);
                                    $password_cookie = array(
					                                    'name'   => 'password',
                    				                    'value'  => $passwordIn,
                                    				    'expire' => $this->config->item ('user_expire'),
					                                    );
                                    $this->input->set_cookie ($password_cookie);
                                } 
								else 
								{
                                    $email_cookie = array(
                                        'name'   => 'email',
                                        'value'  => '',
                                        'expire' => $this->config->item ('user_expire'),
                                    );
                                    $this->input->set_cookie ($email_cookie);
                                    $password_cookie = array(
                                        'name'   => 'password',
                                        'value'  => '',
                                        'expire' => $this->config->item ('user_expire'),
                                    );
                                    $this->input->set_cookie ($password_cookie);
                                }
								$this->session->unset_userdata('blockDtCount_web'.trim($emailIn));
								$this->customer_m->block_unblock_user($result->customerId,1);
								
								$uriSeg1 = $this->uri->segment(1);
								if((empty($uriSeg1))||($uriSeg1=='pointeforce'))
								{
									//if($result->isPointeForce)
									{
										redirect(base_url().'frontend/dashboard');
									}
									
								}
								redirect(current_url());
							}
							else 
							{
								$blockDtCount = $this->session->userdata('blockDtCount_web'.trim($emailIn));
								$this->custom_log->write_log('custom_log','block count is '.$blockDtCount);
								if($blockDtCount)
								{
									$blockDtCount = $blockDtCount+1;
									$this->session->set_userdata('blockDtCount_web'.trim($emailIn),$blockDtCount);
								}
								else
								{							
									$blockDtCount = 1;
									$this->session->set_userdata('blockDtCount_web'.trim($emailIn),$blockDtCount);							
								}
							
								if((!empty($blockDtCount))&&($blockDtCount>2))
								{
									$this->customer_m->update_block_date($result->customerId);
									$this->custom_log->write_log('custom_log','customer update block date');
								}
								
								$this->session->set_flashdata('loginError','invalid password');
								$this->custom_log->write_log('custom_log','invalid password');
                            }
							
							if((!empty($blockDtCount))&&($blockDtCount==2))
							{
								$this->session->set_flashdata('loginError','You have one more attempt to log in to your PointeMart account. If unsuccessful, your account would be blocked.<br>If you wish to reset your password, please click on the forgot Password link below and follow the instructions.');
								$this->custom_log->write_log('custom_log','You have one more attempt to log in to your PointeMart account. If unsuccessful, your account would be blocked.<br>If you wish to reset your password, please click on the forgot Password link below and follow the instructions.');
                            }
							elseif((!empty($blockDtCount))&&($blockDtCount>2))
							{
								$name 	  = $result->firstName.' '.$result->lastName;
                        		$password = rand(0,999999999);
								
								if($this->customer_m->update_reset_code($emailIn,$password))
								{
									$data = array(
												'email'             => $emailIn,
												'slug'              => 'forgot_password',
												'businessOwnerName' => $name,
												'password'          => $password,
												'cc'                => '',
												'subject'           => 'Reset Password',
											);
									if($this->email_m->send_mail($data)) 
									{
										$this->custom_log->write_log('custom_log','Send Mail : '.$this->email->print_debugger());
									} 
									else 
									{
										$this->custom_log->write_log('custom_log','not Send Mail : '.$this->email->print_debugger());
									}
							
									$this->session->set_flashdata('loginError','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
									$this->custom_log->write_log('custom_log','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
									//$this->session->unset_userdata('blockDtCount');
								}
							}							
						}
						else 
						{
							$this->session->set_flashdata('loginError',$this->lang->line ('error_veryfy_email'));
							$this->custom_log->write_log('custom_log',$this->lang->line ('error_veryfy_email'));
                        }
                    } 
					else 
					{						
						$this->session->set_flashdata('loginError',$this->lang->line('error_email_password'));
                        $this->custom_log->write_log('custom_log',$this->lang->line('error_email_password'));
                    }                
					redirect(current_url());
				}
			}
			
			if((!empty($_POST['REGISTRATION']))&&($_POST['REGISTRATION']=='Sign Up'))
			{
				$this->custom_log->write_log('custom_log', 'Registration Form submit ' . print_r ($_POST, TRUE));
				
				if($this->input->post('email'))
				{
					$_POST['email'] = html_entity_decode($this->input->post('email'));
				}
				
				$rules = customer_sign_up_rules();
                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<div class="error">','</div>');
                if($this->form_validation->run()) 
				{
					$varifyCode = new_random_password();
                    $_POST['resetPasswordCode'] = $varifyCode;
					$this->custom_log->write_log('custom_log', 'Verify code is '.$varifyCode);
					
                    $customer_id = $this->customer_m->add_customer($_POST);
					$this->custom_log->write_log('custom_log','customer id is '.$customer_id);
					
					if(!empty($customer_id))
					{
						$_POST['stateId'] = 0;
						$_POST['cityId']  = 0;
						$_POST['areaId']  = 0;
						$_POST['zipcode'] = 0;
						$_POST['street']  = '';
						
						$address_id = $this->customer_m->add_address($_POST);
						$this->custom_log->write_log('custom_log','address id is '.$address_id);
						
						if($address_id) 
						{
                            $this->customer_m->add_customer_address ($customer_id, $address_id);
							
                            $email      = $this->input->post ('email');
                            $password   = $this->input->post ('password');
                            $first_name = $this->input->post ('first_name');
                            $last_name  = $this->input->post ('last_name');
                           
                            $mailData = array(
                                			'email'      => $email,
			                                'cc'         => '',
			                                'varify_url' => base_url().'auth/varification/'.id_encrypt($customer_id) . '/' . $varifyCode,
            			                    'slug'       => 'customer_user_sign_up',
                        			        'name'       => $first_name . ' ' . $last_name,
                                			'password'   => $password,
			                                'subject'    => 'Customer user created successfully',
            			                );
                            if($this->email_m->send_mail ($mailData)) 
							{
                            	$this->custom_log->write_log ('custom_log','Send Mail : '.$this->email->print_debugger());
                            }
							else 
							{
                                $this->custom_log->write_log ('custom_log','Not Send Mail : '.$this->email->print_debugger());
                            }
                            $this->session->set_flashdata('success','Customer Sign Up Successfully');
                        }
						else 
						{
                        	$this->session->set_flashdata ('error', 'Customer Address not create');
							$this->custom_log->write_log('custom_log','Customer Address not create');
                        }
                    }
					else 
					{
                    	$this->session->set_flashdata('error','Customer not create');
						$this->custom_log->write_log('custom_log','Customer not create');
                    }
                    redirect(current_url());
				}
			}
			
			if((!empty($_POST['FORGOTPASSWORD']))&&($_POST['FORGOTPASSWORD']=='SUBMIT'))
			{
				$this->custom_log->write_log('custom_log','Forgot password form submit '.print_r($_POST,TRUE));
				$rules = reset_password_rules();
                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<div class="error">','</div>');
                if($this->form_validation->run()) 
				{
					$email = html_entity_decode($this->input->post('email'));
                    $user  = $this->customer_m->user_email($email);
					$this->custom_log->write_log('custom_log','User details is '.print_r($user,true));
					if(!empty($user)) 
					{
						$name = $user->firstName.' '.$user->lastName;
                        $password = rand(0,999999999);
						if($this->customer_m->update_reset_code ($email, $password))
						{
							$data = array(
                                		'email'             => $email,
		                                'slug'              => 'forgot_password',
		                                'businessOwnerName' => $name,
		                                'password'          => $password,
		                                'cc'                => '',
		                                'subject'           => 'Reset Password',
		                            );
							$message   = 'Dear ' . $name . ', temporary password for your account is ' . $password;
							$messageRs = $this->twillo_m->send_mobile_message ('+234'.$user->phone, $message);
							
							$this->custom_log->write_log ('custom_log','Message result is '.print_r($messageRs,true));
							
							if($this->email_m->send_mail($data)) 
							{
                            	$this->session->set_flashdata ('success', $this->lang->line ('success_reset_password'));
                                $this->custom_log->write_log('custom_log','Send Mail : '.$this->email->print_debugger());
                            } 
							else 
							{
                                $this->session->set_flashdata ('error', $this->lang->line ('error_mail_not_send'));
                                $this->custom_log->write_log('custom_log','Not Send Mail : '.$this->email->print_debugger());
                            }
                        }
						else
						{
							$this->session->set_flashdata('error','Reset password not update');
							$this->custom_log->write_log('custom_log','Reset password not update');
                        }
					}
					else 
					{
                    	$this->session->set_flashdata('error','User not available');
						$this->custom_log->write_log('custom_log','User not available');
                    }
					redirect(current_url());
				}
			}
		}
		
		$viewData['emailIn']      = $emailIn;
		$viewData['passwordIn']   = $passwordIn;
		//$viewData['categoryList'] = $this->category_lib->category_level_list();
		$categoryArr              = $this->category_lib->category_level10();
		$viewData['categoryList'] = $categoryArr['categoryLevelList'];
		//echo "<pre>"; print_r($viewData['categoryList']); exit;
		$customerId = $this->session->userdata('userId');
		if((!empty($customerId))&&($customerId))
		{
			$customerDet = $this->customer_m->login_customer_detail($customerId);
			if(!empty($customerDet))
			{
				$block_status = $customerDet->active;
				if(!$block_status)
				{
					$this->session->set_flashdata('error',$this->lang->line('error_block_user'));
					redirect(base_url().'auth/logout');
				}
			}
		}
		//echo "<pre>"; print_r($categoryArr); exit;
		$this->output->set_header("X-Frame-Options: SAMEORIGIN");
		$this->load->view('frontendHeader',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('frontendFooter');
	}
	
	public function password_check_strong($str)
	{
		if(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#",$str))
		{
			return true;
		}
		else
		{
			 $this->form_validation->set_message('password_check_strong','Passwords must include at least one capital, lower case and numeric');
	        return FALSE;
		}
	}
	
	//	Function for cse custom view after login
	public function cseCustomView($viewName,$viewData = false)
	{
		$this->load->view('cseHeader',$viewData);
		$this->load->view('cseLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('cseFooter');
	}
	
	//	Function for shipping custom view for sign in and sign up
	public function shippingFrontCustomView($viewName,$viewData = false)
	{
		$this->load->view('shippingFrontHeader',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('shippingFrontFooter');
	}
	
	//	Function for cse custom view after login
	public function shippingAdminCustomView($viewName,$viewData = false)
	{
		$this->load->view('shippingAdminHeader',$viewData);
		$this->load->view('shippingAdminLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('shippingAdminFooter');
	}
	
	public function shippingVendorCustomView($viewName,$viewData = false)
	{
		$this->load->view('shippingVendorHeader',$viewData);
		$this->load->view('shippingVendorLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('shippingVendorFooter');
	}
	
	public function financeCustomView($viewName,$viewData = false)
	{
		$this->load->view('financeHeader',$viewData);
		$this->load->view('financeLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('financeFooter');
	}
	
	public function pointeForceCustomView($viewName,$viewData = false)
	{
		$this->load->view('pointeForceHeader',$viewData);
		$this->load->view('pointeForceLeftMenu',$viewData);
		$this->load->view($viewName,$viewData);
		$this->load->view('pointeForceFooter');
	}
	public function get_admin_role_list($user_id)
	{
		return $this->db->select('*')->from('emp_role')->join('role','role.roleId=emp_role.roleId')->where('emp_role.employeeId',$user_id)->get()->row();
		
	}
	public function organization_product_view_count($organizationProductId)
	{
		$organization_product_count=$this->product_m->check_organization_product_count($organizationProductId);
		if( !empty($organization_product_count))
		{
		 $this->product_m->update_organization_product_count($organizationProductId);
		}
		else
		{
			$this->product_m->add_organization_product_count($organizationProductId);
		}
		
		
	}
}