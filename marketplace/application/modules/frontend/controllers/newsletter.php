<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Newsletter extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );	
		$this->load->model('news_sub_email_m');	
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Newsletter',
				'log_MID'    => '' 
		));
		
		$this->data['title']     = 'New Letter';
		$this->data['phoneCode'] = '+234';
		$this->data['countryId'] = '154';
		$this->data['stateId']   = 0;
		$this->data['areaId']    = 0;
		$this->data['cityId']    = 0;
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			$this->custom_log->write_log('custom_log','post form is '.print_r($_POST,true));
			$this->data['phoneCode'] = $this->input->post('phoneCode');
			$this->data['stateId']   = $this->input->post('stateId');
			$this->data['areaId']    = $this->input->post('areaId');
			$this->data['cityId']    = $this->input->post('cityId');
			$rules = newsletter_sign_up_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{	
				$_POST['verifiedCode'] = otp5_digit();
				$newsLetterId = $this->user_m->add_news_letter($_POST);
				$this->custom_log->write_log('custom_log','create news letter id is '.$newsLetterId);
				if($newsLetterId)
				{
					$mailData = array(
									'email'    => $_POST['email'],
									'cc'	   => '',
									'slug'     => 'newsletter_sign_up',
									'name'     => $_POST['firstName'].' '.$_POST['lastName'],
									//'url'      => base_url().'frontend/newsletter/subscription/'.id_encrypt($newsLetterId),
									'url'      => base_url().'frontend/newsletter/verified_news/'.id_encrypt($newsLetterId).'/'.$_POST['verifiedCode'],
									'subject'  => 'Confirm your Newsletter Subscription and WIN GREAT PRIZES!',
								);	
					$this->custom_log->write_log('custom_log','send mail data array is '.print_r($mailData,true));
														
					if($this->email_m->send_mail($mailData))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
					}
					else
					{
						$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
					}	
					$this->session->set_flashdata('success','Information added successfully');
				}
				else
				{
					$this->session->set_flashdata('error','News Letter not create');
				}
				redirect(base_url().'frontend/newsletter');
			}
		}
		
		
		$this->data['countryList'] = $this->location_m->country_list();
		$this->load->view('newsletter/newsletter',$this->data);
	}
	
	public function check_phone()
	{
		$phoneCode = $this->input->post('phoneCode');
		$phone	   = $this->input->post('phone'); 
		$details   = $this->user_m->check_phone($phone,$phoneCode);
		
		if(!empty($details))
		{
			$this->form_validation->set_message('check_phone','The %s field already exits');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function subscription($newsLetterId=0)
	{
		$this->data['title'] = 'Subscription';
		$newsLetterId = id_decrypt($newsLetterId);
		$newsDetails  = $this->customer_m->news_letter_user_details($newsLetterId);
		//echo "<pre>"; print_r($newsDetails); exit;
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			$rules = subscription_news_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$arrArr	= array();
				$arrArr['newsLetterName'] = '';
				if(!empty($newsDetails))
				{
					$arrArr['newsLetterName'] = $newsDetails->firstName.' '.$newsDetails->lastName;
				}
				
				$arrArr['newsLetterId'] = $newsLetterId;
				$arrArr['email'] 		= $_POST['email1'];
				$arrArr['name'] 		= $_POST['name1'];
				$arrArr['verifiedCode'] = otp5_digit();
				
				if((!empty($arrArr['email']))&&(!empty($arrArr['name'])))
				{
					$newSubId = $this->customer_m->add_newsletter_subscription($arrArr);
					if($newSubId)
					{
						$mailData = array(
										'email'    => $arrArr['email'],
										'cc'	   => '',
										'slug'     => 'subscription_news',
										'name'     => $arrArr['name'],
										'url'	   => base_url().'frontend/newsletter/refer_verified/'.id_encrypt($newSubId).'/'.$arrArr['verifiedCode'],
										'subject'  => 'Thank you for your submission, GET READY TO WIN MORE PRIZES!',
										'newsLetterName' => $arrArr['newsLetterName'],
									);										
						if($this->email_m->send_mail($mailData))
						{
							$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
						}
						else
						{
							$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
					}
				}
					
				$arrArr['email'] 		= $_POST['email2'];
				$arrArr['name']  		= $_POST['name2'];
				$arrArr['verifiedCode'] = otp5_digit();
				
				if((!empty($arrArr['email']))&&(!empty($arrArr['name'])))
				{
					$newSubId = $this->customer_m->add_newsletter_subscription($arrArr);
					if($newSubId)
					{
						$mailData = array(
										'email'    => $arrArr['email'],
										'cc'	   => '',
										'slug'     => 'subscription_news',
										'name'     => $arrArr['name'],
										'url'	   => base_url().'frontend/newsletter/refer_verified/'.id_encrypt($newSubId).'/'.$arrArr['verifiedCode'],
										'subject'  => 'Thank you for your submission, GET READY TO WIN MORE PRIZES!',
										'newsLetterName' => $arrArr['newsLetterName'],
									);										
						if($this->email_m->send_mail($mailData))
						{
							$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
						}
						else
						{
							$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
					}
				}
				
				$arrArr['email'] 		= $_POST['email3'];
				$arrArr['name']  		= $_POST['name3'];
				$arrArr['verifiedCode'] = otp5_digit();
				
				if((!empty($arrArr['email']))&&(!empty($arrArr['name'])))
				{
					$newSubId = $this->customer_m->add_newsletter_subscription($arrArr);
					if($newSubId)
					{
						$mailData = array(
										'email'    => $arrArr['email'],
										'cc'	   => '',
										'slug'     => 'subscription_news',
										'name'     => $arrArr['name'],
										'url'	   => base_url().'frontend/newsletter/refer_verified/'.id_encrypt($newSubId).'/'.$arrArr['verifiedCode'],
										'subject'  => 'Thank you for your submission, GET READY TO WIN MORE PRIZES!',
										'newsLetterName' => $arrArr['newsLetterName'],
									);										
						if($this->email_m->send_mail($mailData))
						{
							$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
						}
						else
						{
							$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
					}
				}
				
				$arrArr['email'] 		= $_POST['email4'];
				$arrArr['name']  		= $_POST['name4'];
				$arrArr['verifiedCode'] = otp5_digit();
				
				if((!empty($arrArr['email']))&&(!empty($arrArr['name'])))
				{
					$newSubId = $this->customer_m->add_newsletter_subscription($arrArr);
					if($newSubId)
					{
						$mailData = array(
										'email'    => $arrArr['email'],
										'cc'	   => '',
										'slug'     => 'subscription_news',
										'name'     => $arrArr['name'],
										'url'	   => base_url().'frontend/newsletter/refer_verified/'.id_encrypt($newSubId).'/'.$arrArr['verifiedCode'],
										'subject'  => 'Thank you for your submission, GET READY TO WIN MORE PRIZES!',
										'newsLetterName' => $arrArr['newsLetterName'],
									);										
						if($this->email_m->send_mail($mailData))
						{
							$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
						}
						else
						{
							$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
					}
				}
				
				$arrArr['email'] 		= $_POST['email5'];
				$arrArr['name']  		= $_POST['name5'];
				$arrArr['verifiedCode'] = otp5_digit();
				
				if((!empty($arrArr['email']))&&(!empty($arrArr['name'])))
				{
					$newSubId = $this->customer_m->add_newsletter_subscription($arrArr);
					if($newSubId)
					{
						$mailData = array(
										'email'    => $arrArr['email'],
										'cc'	   => '',
										'slug'     => 'subscription_news',
										'name'     => $arrArr['name'],
										'url'	   => base_url().'frontend/newsletter/refer_verified/'.id_encrypt($newSubId).'/'.$arrArr['verifiedCode'],
										'subject'  => 'Thank you for your submission, GET READY TO WIN MORE PRIZES!',
										'newsLetterName' => $arrArr['newsLetterName'],
									);										
						if($this->email_m->send_mail($mailData))
						{
							$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
						}
						else
						{
							$this->session->set_flashdata('error','Retailer create successfully but '.$this->lang->line('error_mail_not_send'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
						}
					}
				}
				
				$this->session->set_flashdata('success','Mail Send Successfully');
				redirect(base_url().'frontend/newsletter/subscription');
			}
		
		}
		$this->load->view('newsletter/subscription',$this->data);	
	}
	
	public function check_name1()
	{
		$name1 = trim($this->input->post('name1'));
		if(!empty($name1))
		{
			return TRUE;
		}
		else
		{
			
			$this->form_validation->set_message('check_name1','Please enter name');
			return FALSE;
		}
	
	}
	
	public function check_email1()
	{
		$email1 = trim($this->input->post('email1'));
		if(!empty($email1))
		{
			$result = $this->user_m->check_newsletter_email($email1);
			if(!empty($result))
			{
				$this->form_validation->set_message('check_email1','We already have this email Id in our mailing list, Kindly enter a different email id');
				return FALSE;
			}
			else
			{
				$result = $this->user_m->check_newsletter_subscription_email($email1);
				if(!empty($result))
				{
					$this->form_validation->set_message('check_email1','We already have this email Id in our mailing list, Kindly enter a different email id');
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		}
	}
	
	public function check_email2()
	{
		$email1 = trim($this->input->post('email2'));
		if(!empty($email1))
		{
			$result = $this->user_m->check_newsletter_email($email1);
			if(!empty($result))
			{
				$this->form_validation->set_message('check_email2','We already have this email Id in our mailing list, Kindly enter a different email id');
				return FALSE;
			}
			else
			{
				$result = $this->user_m->check_newsletter_subscription_email($email1);
				if(!empty($result))
				{
					$this->form_validation->set_message('check_email2','We already have this email Id in our mailing list, Kindly enter a different email id');
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		}
	}
	
	public function check_email3()
	{
		$email1 = trim($this->input->post('email3'));
		if(!empty($email1))
		{
			$result = $this->user_m->check_newsletter_email($email1);
			if(!empty($result))
			{
				$this->form_validation->set_message('check_email3','We already have this email Id in our mailing list, Kindly enter a different email id');
				return FALSE;
			}
			else
			{
				$result = $this->user_m->check_newsletter_subscription_email($email1);
				if(!empty($result))
				{
					$this->form_validation->set_message('check_email3','We already have this email Id in our mailing list, Kindly enter a different email id');
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		}
	}
	
	public function check_email4()
	{
		$email1 = trim($this->input->post('email4'));
		if(!empty($email1))
		{
			$result = $this->user_m->check_newsletter_email($email1);
			if(!empty($result))
			{
				$this->form_validation->set_message('check_email4','We already have this email Id in our mailing list, Kindly enter a different email id');
				return FALSE;
			}
			else
			{
				$result = $this->user_m->check_newsletter_subscription_email($email1);
				if(!empty($result))
				{
					$this->form_validation->set_message('check_email4','We already have this email Id in our mailing list, Kindly enter a different email id');
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		}
	}
	
	public function check_email5()
	{
		$email1 = trim($this->input->post('email5'));
		if(!empty($email1))
		{
			$result = $this->user_m->check_newsletter_email($email1);
			if(!empty($result))
			{
				$this->form_validation->set_message('check_email5','We already have this email Id in our mailing list, Kindly enter a different email id');
				return FALSE;
			}
			else
			{
				$result = $this->user_m->check_newsletter_subscription_email($email1);
				if(!empty($result))
				{
					$this->form_validation->set_message('check_email5','We already have this email Id in our mailing list, Kindly enter a different email id');
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		}
	}
	
	public function refer_verified($newSubId='',$verifiedCode='')
	{
		$newSubId = id_decrypt($newSubId);
		if((!empty($newSubId))&&(!empty($verifiedCode)))
		{
			$check = $this->customer_m->refer_verified_details($newSubId,$verifiedCode);
			if(!empty($check))
			{
				if($this->customer_m->verified_refer($newSubId))
				{
					//$this->session->set_flashdata('success','User verified Successfully');
				}
				else
				{
					//$this->session->set_flashdata('error','User not verified');
				}
			}
			else
			{
				//$this->session->set_flashdata('error','User details not found');
			}
		}
		else
		{
			//$this->session->set_flashdata('error','Invalid data');
		}
		redirect(base_url().'frontend/newsletter/index/1');
	}
	
	public function verified_news($newsletterId='',$verifiedCode='')
	{
		$newsletterId = id_decrypt($newsletterId);
		$checkRes     = $this->customer_m->check_verified_newsletter($newsletterId,$verifiedCode);
		if(!empty($checkRes))
		{
			if($this->customer_m->update_verified_newsletter($newsletterId))
			{
				//$this->session->set_flashdata('success','Verified Successfully');
			}
			else
			{
				//$this->session->set_flashdata('error','User not verified');
			}
			redirect(base_url().'frontend/newsletter/subscription/'.id_encrypt($newsletterId));
		}
		else
		{
			$this->session->set_flashdata('error','User Already Verified');
		}
		redirect(base_url().'frontend/newsletter');
	}
	
	public function test()
	{
		$this->load->view('newsletter/test',$this->data);
	}
	    public function add_newsletter_mail()
    {
        $this->load->model('news_sub_m');
        $email=$this->input->post('email');
        $rules=array(
                array(

                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|is_unique[newsletter_subscription.subscription_email]'
                ),
        );
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('is_unique','Email Already Exist In Mailing List');
        $this->form_validation->set_error_delimiters(' <h3 style="padding-top:30px; padding-bottom:10px;color:#FE5621; font-size:27px;">', '</h3>');
        if($this->form_validation->run())
        {
          $res=  $this->news_sub_m->add_new_subscription($email);

             echo '<h2 style="font-size:32px; padding-top:30px; padding-bottom:10px;color:#FE5621;">Thank you!</h2>
                        <h3 style="font-size:27px;">For Subscription</h3>';

        }
        else
        {
            echo form_error('email');
        }
    }
	
	public function unsubscribe_email($newSubId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'unsubscribe_email',
				'log_MID'    => '' 
		));	
		
		$newSubId = id_decrypt($newSubId);
		$this->custom_log->write_log('custom_log','new subscrition id is '.$newSubId);
		
		if((!empty($newSubId))&&($newSubId))
		{
			//$getDetails = $this->news_sub_email_m->news_letter_subscription_email($newSubId);
			//$this->custom_log->write_log('custom_log','News letter details is '.print_r($getDetails,true));
		}
		else
		{
			$this->session->set_flashdata('error','News letter id not found');
			$this->custom_log->write_log('custom_log','News letter id not found');
		}
		redirect(base_url());	
	}
}