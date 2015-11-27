<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class Store extends REST_Controller
{
	public function __construct() 
	{
	  parent::__construct ();
		$this->apiresponse['time']=time();
		$this->load->model('user_m');
		$this->load->model('email_m');
		$this->load->model('organization_m');
	  if (is_array($this->response->lang))
		{
			$this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
			$this->lang->load('error', $this->response->lang[0]);
			$this->lang->load('success', $this->response->lang[0]);

		}
		else
		{
			$this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
			$this->lang->load('error', $this->response->lang);
			$this->lang->load('success', $this->response->lang);
			// $this->load->language('application', $this->response->lang);
		}
	}
	

	public function store_register_post()
	{
		$rules= api_store_registration();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$password=$this->post('password');
			$password= md5($password);
			if(isset($_POST['email']))
			{
			$email=$this->post('email');
			}
			else
			{
			$email='';
			}
			$organization_name=$this->post('organizationName');
			$organizationId=$this->organization_m->register_store($organization_name);
			$businessPhone=str_replace ('+','',$this->post('businessPhone'));
			$dataArray = array
							(
							'firstName'			=>	$this->post('firstName'),
							'lastName'			=>	$this->post('lastName'),
							'businessPhone'		=> $businessPhone,
							'email'				=> $email,
							'password'			=> $password,
							'active'			=> 0,
							'organizationId'	=>	$organizationId,
							'lastModifiedDt' 	=> $this->currentDateTime,
							
							);
		if(isset($_FILES['file']) && $_FILES['file']['size']>0) 
		{
			$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp * 2) . '.' . $extension;

			$config['upload_path'] = './uploads/user';
			$config["allowed_types"] = "jpg|jpeg|png|gif";
			$this->load->library('upload', $config);
			$config['file_name'] = $newImageName;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('file'))
			{
				$dataArray['imageName']=	$newImageName;
				$dataArray['imagePath']=	'uploads/user';
			}else
			{
				$this->apiresponse['success']=0;

				$this->apiresponse['response'] =array(
					'message' => $this->lang->line('upload_failed')
				);

				$this->response($this->apiresponse,'json');
			}
		}
			$insertOptions = array
							(
							'table' => 'employee',
							'data'  => $dataArray
							 );
			$retailerId = $this->common_model->customInsert($insertOptions);
			if(!empty($retailerId))
			{
					$ipAddress=$this->input->ip_address();
					$timeZone=	$this->ip_details($ipAddress);
				$user_address=array
								(
								'table'	=>	'address',
								'data'	=>  array
											(
											'addressLine1'	=> $this->post('addressLine1'),	
											'city'			=> $this->post('city'),
											'state'			=> $this->post('state'),
											'country'		=> $this->post('country'),
											'timeZone'		=> 'asia/kolkata'//$timeZone->timezone
											)	
								
								);
				$addressId=$this->common_model->customInsert($user_address);
				$this->user_m->assign_user_address($retailerId,$addressId,'BA');
				$user_roles=$this->user_m->user_role('RT');
				$this->custom_log->write_log('custom_log',print_r($user_roles,true));
				$this->user_m->role_assign($retailerId,$user_roles->roleId);
				//$this->user_m->role_assign($retailerId,'RT');
			$data = array
						(
						'blog_title' 	=> 'Pointepay registration',
						'user_email' 	=>  $dataArray['email'],
						'name'			=>	$_POST['firstName'],
						'email'			=>	$dataArray['email'],
						'url'			=>	base_url(),
						'base_url'		=>	base_url(),
						'slug'			=>	'signup',
						'subject'		=>	'cogratulation you registered successfully '
						);



			$this->email_m->send_mail($data);
		//	$userName=$this->post('businessPhone');
								
			$retailerData = $this->user_m->user_detail($businessPhone,$password);
			//$this->apiresponse['sql']=$this->db->last_query();
			$this->apiresponse['success']=1;

		   $this->apiresponse['response'] =array
											(
										   'message' => $this->lang->line('success_full_signup'),
										   'data'=>$retailerData
											);

		   $this->response($this->apiresponse,200);
				
			}
			else
			{
				$this->apiresponse['success']=0;

			   $this->apiresponse['response'] =array(
					   'message' => $this->lang->line('error_sign_up'),
					   'data'=>''
				   );

			   $this->response($this->apiresponse,200);
			}	
							
		
		}
		else
		{
			$this->apiresponse['success']	=	0;

           $this->apiresponse['response'] 	=array
											(
											'message' => $this->form_validation->error_array()
											 );

           $this->response($this->apiresponse,200);
		}
	}
	public function login_post()
	{
		$rules=api_login_rules();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
				$email		= $this->post('email');
				$password	=md5($this->post('password'));

				$retailerData = $this->user_m->user_detail($email,$password);
				if(!empty($retailerData)){
					
							$this->apiresponse['success']=1;

							   $this->apiresponse['response'] =array(
								   'message' => $this->lang->line('success_login'),
								   'data'=>$retailerData
							   );

							   $this->response($this->apiresponse,200);
				}else{
							$this->apiresponse['sql']=$this->db->last_query();
							$this->apiresponse['success']=0;

							   $this->apiresponse['response'] =array(
								   'message' => $this->lang->line('error_login'),
								   'data'=>''
							   );

							   $this->response($this->apiresponse,200);
				}
		}else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
		
	}
	public function check_userdetail_post()
	{
		$rules=api_login_rules();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$this->apiresponse['success']=1;

           $this->apiresponse['response'] =array(
               'message' => 'success'
           );

           $this->response($this->apiresponse,200);
		}
		else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
		
	}
	public function check_user_detail_post()
	{
		$rules=check_userdetail();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$this->apiresponse['success']=1;
				$ip_address=$this->input->ip_address();
				
           $this->apiresponse['response'] =array(
               'message' => $this->ip_details($ip_address),
			    'ip_address' => $ip_address
           );

           $this->response($this->apiresponse,200);
		}
		else
		{
			$this->apiresponse['success']=0;

           $this->apiresponse['response'] =array(
               'message' => $this->form_validation->error_array()
           );

           $this->response($this->apiresponse,200);
		}
		
	}
	function ip_details($ip) 
	{
	
	$json = unserialize(file_get_contents("http://ip-api.com/php/".$ip.""));

	return $json;
	}
	function send_verification_post()
	{
		$phone_code=$this->post('phone_code');
		$phone_number=$this->post('phone_number');
		$user_id=$this->post('user_id');
		if(!empty($phone_code) && !empty($phone_number) && !empty($user_id))
		{
			
		}else
		{
			
		}
		
	}

	


}

