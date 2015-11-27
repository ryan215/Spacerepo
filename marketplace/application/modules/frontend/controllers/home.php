<?php if(!defined ('BASEPATH'))   exit ( 'No Direct Access Allowed' );

    class Home extends MY_Controller
    {

        public function __construct()
        {

            parent::__construct ();
            // logger
            $this->session->set_userdata (array(
                'log_FILE' => ''
            ));
            $this->load->model ('location_m');
            $this->load->model ('customer_m');
        }
		
		public function offer()
		{
			$this->data['title']='offers';
			$this->frontendCustomView('home/offer',$this->data);
		}
		
        public function index($newsId=0)
        {
			$this->session->set_userdata (array(
                'log_MODULE' => "hOME",
                'log_MID'    => ''
            ));			
			
			$newsId = id_decrypt($newsId);
			$this->load->model('news_sub_m');
            $this->data['title'] = "Nigeria's Online Mall";			
			if((!empty($_POST['new_sub_btn']))&&(($_POST['new_sub_btn']=='male') or ($_POST['new_sub_btn']=='female')))
			{
				$this->custom_log->write_log('custom_log','New subscription form submit '.print_r($_POST,TRUE));
				$news_email = $this->input->post('news_email');
				$new_sub_btn = $this->input->post('new_sub_btn');
				
				$rules 		= array(
								array(				
										'field' => 'news_email',
										'label' => 'Email',
										'rules' => 'trim|required|valid_email|callback_check_email'
								),
								array(				
										'field' => 'new_sub_btn',
										'label' => 'new_sub_btn',
										'rules' => 'trim|required'
								)
				);
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_message('is_unique','Thank you for signing up. Your email already exists in our database.');
				$this->form_validation->set_error_delimiters('<h3 style="padding-top:30px; padding-bottom:10px;color:#FE5621; font-size:27px;">', '</h3>');
				if($this->form_validation->run())
				{
					if($new_sub_btn=="male")
					{
						$gender=1;
						
					}elseif($new_sub_btn=="female")
					{
						$gender=2;
					}
					$newsId = $this->news_sub_m->add_new_subscription_popup2($news_email,$gender);
					$this->custom_log->write_log('custom_log','New subscription Id is '.$newsId);
					if($newsId)
					{
						$this->session->set_flashdata('successNews','Thank you for Subscribing!');
						$this->session->set_flashdata('success','Thank you for Subscribing!');
						$this->data['successNews']="Thank you for Subscribing!";
						$this->custom_log->write_log('custom_log','Thank you for Subscribing!');
						redirect(base_url());
					}
					else
					{
						$this->session->set_flashdata('error','New subscription not add');
						$this->custom_log->write_log('custom_log','New subscription not add');
					}
					redirect(base_url());
				}				
			}
			
			if((!empty($_POST['referFriendBtn']))&&($_POST['referFriendBtn']=='Submit'))
			{
				$this->custom_log->write_log('custom_log','New subscription for refer friends form submit '.print_r($_POST,TRUE));
				$rules = array(
								array(				
										'field' => 'refer_email1',
										'label' => 'Email 1',
										'rules' => 'trim|required|valid_email|is_unique[newsletter_refer_friend.email]'
								),
								array(				
										'field' => 'refer_email2',
										'label' => 'Email 2',
										'rules' => 'valid_email|is_unique[newsletter_refer_friend.email]'
								),
								array(				
										'field' => 'refer_email3',
										'label' => 'Email 3',
										'rules' => 'valid_email|is_unique[newsletter_refer_friend.email]'
								),
								array(				
										'field' => 'refer_email4',
										'label' => 'Email 4',
										'rules' => 'valid_email|is_unique[newsletter_refer_friend.email]'
								),
								array(				
										'field' => 'refer_email5',
										'label' => 'Email 5',
										'rules' => 'valid_email|is_unique[newsletter_refer_friend.email]'
								),
							  );
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_message('required','Kindly refer atleast one of your friends.');
				$this->form_validation->set_message('is_unique','Thank you for signing up. Your email already exists in our database.');
				$this->form_validation->set_error_delimiters('<h3 style="padding-top:30px; padding-bottom:10px;color:#FE5621; font-size:27px;">','</h3>');
				if($this->form_validation->run())
				{	
					$newSubId     = $newsId;
					$refer_email1 = $this->input->post('refer_email1');
					$refer_email2 = $this->input->post('refer_email2');
					$refer_email3 = $this->input->post('refer_email3');
					$refer_email4 = $this->input->post('refer_email4');
					$refer_email5 = $this->input->post('refer_email5');
					if(!empty($refer_email1))
					{
						$referFriendId1 = $this->news_sub_m->add_newsletter_subscription_refer_friend($newSubId,$refer_email1);
						$this->custom_log->write_log('custom_log','refer friend Id is '.$referFriendId1);
					}
					if(!empty($refer_email2))
					{
						$referFriendId2 = $this->news_sub_m->add_newsletter_subscription_refer_friend($newSubId,$refer_email2);
						$this->custom_log->write_log('custom_log','refer friend Id is '.$referFriendId2);
					}
					if(!empty($refer_email3))
					{
						$referFriendId3 = $this->news_sub_m->add_newsletter_subscription_refer_friend($newSubId,$refer_email3);
						$this->custom_log->write_log('custom_log','refer friend Id is '.$referFriendId3);
					}
					if(!empty($refer_email4))
					{
						$referFriendId4 = $this->news_sub_m->add_newsletter_subscription_refer_friend($newSubId,$refer_email4);
						$this->custom_log->write_log('custom_log','refer friend Id is '.$referFriendId4);
					}
					if(!empty($refer_email5))
					{
						$referFriendId5 = $this->news_sub_m->add_newsletter_subscription_refer_friend($newSubId,$refer_email5);
						$this->custom_log->write_log('custom_log','refer friend Id is '.$referFriendId5);
					}
					$this->session->set_flashdata('successNewsRefer','Thank you for signing up! You are now in the drawing to Win! Win! Win!');
					$this->custom_log->write_log('custom_log','Thank you for signing up! You are now in the drawing to Win! Win! Win!');
					redirect(current_url());
				}				
			
			}
			
			$this->data['newsId'] = $newsId;
			$this->frontendCustomView('home/home', $this->data);
		}

        public function forgot_password()
        {
            $this->session->set_userdata (array(
                'log_MODULE' => 'forgot_password',
                'log_MID'    => ''
            ));

            $this->data['title'] = 'Forgot Password';
            if($_POST) {
                $rules = reset_password_rules ();
                $this->form_validation->set_rules ($rules);
                $this->form_validation->set_error_delimiters ('<div class="error">', '</div>');
                if($this->form_validation->run ()) {
                    $email = $this->input->post ('email');
                    $user = $this->customer_m->user_email ($email);
                    if(!empty( $user )) {
                        $name = $user->firstName . ' ' . $user->lastName;
                        $password = rand (0, 999999999);

                        if($this->customer_m->update_reset_code ($email, $password)) {
                            $data = array(
                                'email'             => $email,
                                'slug'              => 'forgot_password',
                                'businessOwnerName' => $name,
                                'password'          => $password,
                                'cc'                => '',
                                'subject'           => 'Reset Password',
                            );


                            $message = 'Dear ' . $name . ', temporary password for your account is ' . $password;
                            if(( $user->phone == '8109243045' ) || ( $user->phone == '9981808521' )) {
                                $rs = $this->twillo_m->send_mobile_message ('+91' . $user->phone, $message);
                            } else {
                                $rs = $this->twillo_m->send_mobile_message ('+234' . $user->phone, $message);
                            }

                            if($this->email_m->send_mail ($data)) {
                                $this->session->set_flashdata ('success', $this->lang->line ('success_reset_password'));
                                $this->custom_log->write_log ('custom_log', $this->lang->line ('success_reset_password'));
                            } else {
                                $this->session->set_flashdata ('error', $this->lang->line ('error_mail_not_send'));
                                $this->custom_log->write_log ('custom_log', $this->lang->line ('error_mail_not_send'));
                                redirect (base_url () . 'frontend/home/forgot_password');
                            }
                            redirect (base_url () . 'frontend/home/sign_in');
                        } else {
                            $this->session->set_flashdata ('error', 'Reset password not update');
                            redirect (base_url () . 'frontend/home/forgot_password');
                        }
                    } else {
                        $this->session->set_flashdata ('error', 'User not available');
                        redirect (base_url () . 'frontend/home/forgot_password');
                    }
                }
            }
            $this->frontendCustomView ('home/forgot_password', $this->data);
        }

        public function confirm_reset_password($reset_password_code = '')
        {
            $this->session->set_userdata (array(
                'log_MODULE' => 'confirm_reset_password',
                'log_MID'    => ''
            ));

            if($_POST) {
                $validation = array(
                    array(
                        'field' => 'confirm_code',
                        'label' => 'Confirmation Code',
                        'rules' => 'trim|required'
                    ),
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

                $this->form_validation->set_rules ($validation);
                $this->form_validation->set_error_delimiters ('<div class="error">', '</div>');
                if($this->form_validation->run ()) {
                    $newPassword = $this->input->post ('newPassword');

                    $updateOpt = array(
                        'table' => 'users',
                        'data'  => array( 'password' => password_encrypt ($newPassword) ),
                        'where' => array( 'reset_password_code' => $reset_password_code ),
                    );
                    if($this->common_model->customUpdate ($updateOpt)) {
                        $this->session->set_flashdata ('success', 'password reset successfully');
                    } else {
                        $this->session->set_flashdata ('error', 'password not update');
                    }
                    redirect (base_url () . 'frontend/home/sign_in');
                }
            }
            $this->data['title'] = 'Confirm Reset Password';
            $this->data['reset_password_code'] = $reset_password_code;

            $this->frontendCustomView ('home/confirm_reset_password', $this->data);
        }

        public function stateCountryPhoneCodeList()
        {
            $countryId = $this->input->post ('countryId');
            $stateId = $this->input->post ('stateId');
            if(empty( $countryId )) {
                $countryId = 0;
            }
            $where = 'state.countryId = ' . $countryId;
            $this->data['stateList'] = $this->location_m->state_list ('', '', $where);
            $this->data['stateId'] = $stateId;
            $result['view'] = $this->load->view ('admin/location_managements/stateCountryList', $this->data, TRUE);
            $result['phoneCode'] = '';
            if(!empty( $this->data['stateList'] )) {
                $result['phoneCode'] = $this->data['stateList'][0]->phoneCode;
            }
            echo json_encode ($result);
        }

        public function cityStateList()
        {
            $stateId = $this->input->post ('stateId');
            $cityId = $this->input->post ('cityId');
            if(empty( $stateId )) {
                $stateId = 0;
            }
            $where = 'zip.stateId = ' . $stateId;
            $this->data['cityList'] = $this->location_m->zip_list ('', '', $where);
            $this->data['cityId'] = $cityId;
            echo $this->load->view ('admin/location_managements/cityStateList', $this->data, TRUE);
        }

        public function insert_dropship()
        {
            $this->data['countryId'] = 154;
            $this->data['stateId'] = 0;
            $this->data['areaId'] = 0;
            $this->data['cityId'] = 0;
            if(isset( $_POST ) && !empty( $_POST )) {
             //   print_r ($_POST);
                $rules=array(

                    array(

                        'field' => 'dropCenterName',
                        'label' => 'dropshipcenter',
                        'rules' => 'trim|required|is_unque[pickup.pickupName]'
                    )
                    ,
                    );
                $this->form_validation->set_rules($rules);


                if($this->form_validation->run()) {
                    $addSArr = array(
                        'firstName'       => '',
                        'lastName'        => '',
                        'zipcode'         => '',
                        'secondary_phone' => $this->input->post ('secondaryPhone'),
                        'address1'        => $this->input->post ('street'),
                        'address2'        => '',
                        'phoneNo'         => $this->input->post ('phone'),
                        'stateId'         => $this->input->post ('stateId'),
                        'areaId'          => $this->input->post ('areaId'),
                        'cityId'          => $this->input->post ('cityId'),
                        'countryId'       => 154,
                    );
                    $addrShippId = $this->customer_m->adddropshipaddress ($addSArr);
                    $insertOpt = array
                    (
                        'pickupName' => $this->input->post ('dropCenterName'),
                        'businessDays'   => $this->input->post ('businessDays'),
                        'businessHours'  => $this->input->post ('businessHours'),
                        'createDt'       => date ('Y-m-d H:i:s'),
                        'lastModifiedBy' => 1,
                        'lastModifiedDt' => date ('Y-m-d H:i:s'),
                    );
                    $dropship_id = $this->db->insert ('pickup', $insertOpt);
                    $dropship_id = $this->db->insert_id ();
                    $dropshi_address = array
                    (
                        'pickupId'   => $dropship_id,
                        'addressId'      => $addrShippId,
                        'createDt'       => date ('Y-m-d H:i:s'),
                        'lastModifiedBy' => 1,
                        'lastModifiedDt' => date ('Y-m-d H:i:s')

                    );
                    $response = $this->db->insert ('pickup_address', $dropshi_address);
                    if(!empty( $response )) {
                        echo 'successfully added dropship center';
                    }
                }else
                {
                    $error_array= $this->form_validation->error_array();
                    print_r($error_array);
                }
            }
            $this->frontendCustomView ('home/insertdropship', $this->data);
        }
		
		public function alpha_numeric_space()
	{
		$str = $this->input->post('street');
		if(is_numeric($str))
		{
		 	$this->form_validation->set_message('alpha_numeric_space', 'The %s field cannot have only numeric values.');
			return FALSE;
		}
		else
		{
			return TRUE;			
		}
	}	
	
	public function signIn()
	{
    	if($_POST)
        {	//echo "<pre>"; print_r($_POST); exit;
			$this->custom_log->write_log('custom_log', 'Form submit ' . print_r ($_POST, TRUE));
			$emailIn    = $this->input->post('email');
            $passwordIn = $this->input->post('password');
            $remember   = 0; //$this->input->post('remember');
			$redirectTo = $this->input->post('redirectTo');
            $rules      = sign_in_rules();
				
			if(!empty($emailIn))
			{
				$emailIn = html_entity_decode($emailIn);
			}
			
			$this->form_validation->set_rules ($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run())
			{
				$emailIn = trim($emailIn);
				$result = $this->customer_m->sign_in($emailIn);
				$this->custom_log->write_log('custom_log','customer details is '.print_r($result,TRUE));
					
				if(!empty($result)&&(count($result)>0))
				{
					$dbPassword      = $result->password;
                    $master_password = $this->config->item('master_password');
					$block_status    = $result->active;
					if(!$block_status)
					{
						$this->session->set_flashdata('error',$this->lang->line('error_block_user'));
						redirect(current_url());
					}
					
					$blockDate = $result->blockDate;
					
					$this->custom_log->write_log('custom_log','check condition is (!empty('.$dbPassword.')&&('.$dbPassword.'=='.password_encrypt($passwordIn).'))||(!empty('.$master_password.')&&('.$master_password.'=='.$passwordIn.'))');
					
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
								$this->custom_log->write_log ('custom_log',$this->lang->line('success_reset_password'));	
							} 
							else 
							{
								$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
							}
						}
						
						$this->custom_log->write_log('custom_log','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
						$this->session->set_flashdata('error','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
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
								$this->session->unset_userdata('blockDtCount_mobile'.$emailIn);
								$this->customer_m->block_unblock_user($result->customerId,1);
								$this->session->set_flashdata('success','Login successfully as '.ucwords ($result->firstName . ' ' . $result->lastName).'');
								
								if(!empty($redirectTo))
								{
									$redirectTo = urldecode($redirectTo);
								}
								else
								{
									$redirectTo = base_url();
								}
								$this->custom_log->write_log('custom_log','Redirect to '.$redirectTo);
								redirect($redirectTo);	
						}
                        else
                        {
							$blockDtCount = $this->session->userdata('blockDtCount_mobile'.$emailIn);
							$this->custom_log->write_log('custom_log','block count is '.$blockDtCount);
							if($blockDtCount)
							{
								$blockDtCount = $blockDtCount+1;
								$this->session->set_userdata('blockDtCount_mobile'.$emailIn,$blockDtCount);
							}
							else
							{							
								$blockDtCount = 1;
								$this->session->set_userdata('blockDtCount_mobile'.$emailIn,$blockDtCount);							
							}
							
							if((!empty($blockDtCount))&&($blockDtCount>2))
							{
								$this->customer_m->update_block_date($result->customerId);
								$this->custom_log->write_log('custom_log','customer update block date');
							}
							
                        	$this->session->set_flashdata('error','invalid password');
                        	$this->custom_log->write_log('custom_log','invalid password');
                        }

						if((!empty($blockDtCount))&&($blockDtCount==2))
						{
								$this->session->set_flashdata('error','You have one more attempt to log in to your PointeMart account. If unsuccessful, your account would be blocked.<br>If you wish to reset your password, please click on the forgot Password link below and follow the instructions.');
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
									$this->custom_log->write_log ('custom_log',$this->lang->line('success_reset_password'));	
								} 
								else 
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
								}
								
								$this->session->set_flashdata('error','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
								$this->custom_log->write_log('custom_log','We noticed you have been trying to log into your account with no success. Your account has been blocked. Kindly note that instructions on how to change your password has been forwarded to your registered email address.');
							}
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
            	redirect(current_url());
        	}
        }
        $this->data['title']='Sign In';
    	$this->frontendCustomView('home/signin',$this->data);
	}
	
	function signUp()
        {
            if($_POST)
            {
                if((!empty($_POST)))
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
                                        'varify_url' => base_url () . 'auth/varification/' . id_encrypt ($customer_id) . '/' . $varifyCode,
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
            }
            $this->data['title']="Registration";
            $this->frontendCustomView('home/signUp',$this->data);

        }
		public function check_email()
				{
					$email=$this->input->post('news_email');
					$details= $this->news_sub_m->join_vip_email($email);
						if(!empty($details))
						{
							$this->form_validation->set_message('check_email','Thank you for signing up. Your email already exists in our database');
							return false;
						}
						else
						{
							return true;
						}
				}
				

    
}