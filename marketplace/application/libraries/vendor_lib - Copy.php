<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function shipping_vendor_ajaxFun()
	{
		$perPage   = $this->CI->input->post('sel_no_entry');
		$return    = array();
		$where     = '';
		
		$total	   = $this->CI->shipping_m->total_shipping_vendor_user($where);				
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/vendor_management/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		$return['list']  = $this->CI->shipping_m->shipping_vendor_user_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
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
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));
			
			$return['excelFile']	 	   = $this->CI->input->post('excelFile'); 
			$return['imageName']	 	   = $this->CI->input->post('imageName'); 
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['middleName'] 		   = $this->CI->input->post('middleName'); 
			$return['lastName']  	 	   = $this->CI->input->post('lastName');
			$return['email']  		 	   = $this->CI->input->post('email'); 
			$return['businessName']  	   = $this->CI->input->post('businessName'); 
			$return['countryCode']   	   = trim($this->CI->input->post('countryCode'));
			$return['businessPhone'] 	   = $this->CI->input->post('businessPhone'); 		
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
				$organizationId = $this->CI->shipping_m->add_shipping_vendor_organization($return);
				$this->CI->custom_log->write_log('custom_log','Organization id is '.$organizationId);
				
				if($organizationId)
				{
					$employeeId = $this->CI->shipping_m->add_shipping_vendor_employee($organizationId,$return);
					$this->CI->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					
					if($employeeId)
					{
						$addressId = $this->CI->shipping_m->add_shipping_vendor_address($return);
						$this->CI->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->CI->shipping_m->add_shipping_vendor_employee_address($employeeId,$addressId);
							$roleID = $this->CI->shipping_m->add_shipping_vendor_employee_role($employeeId,$organizationId);
							$this->CI->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								
								$this->CI->session->set_flashdata('success','Shipping Vendor Created Successfully');
								$this->CI->custom_log->write_log('custom_log','Shipping Vendor Created Successfully');
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
		$users_details = $this->CI->shipping_m->shipping_vendor_user_details($organizationId);
		
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
		
		$result['shippingRateList'] = $this->CI->shipping_m->total_shipping_vendor_rate_list($organizationId);
		if($result['shippingRateList'])
		{
		}
		else
		{
			if($employeeId)
			{
				$this->CI->shipping_m->deactivate_user($employeeId);
			}
		}
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
		
		$users_details  = $this->CI->shipping_m->shipping_vendor_user_details($organizationId);
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
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));
			$return['formSubmit']  		   = 0;
			$return['firstName'] 	 	   = $this->CI->input->post('firstName');
			$return['lastName']  	 	   = $this->CI->input->post('lastName'); 
			$return['middleName']  	 	   = $this->CI->input->post('middleName'); 
			$return['stateId']  	 	   = $this->CI->input->post('stateId');
			$return['areaId']  	 	   	   = $this->CI->input->post('areaId');
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
				$this->CI->shipping_m->update_shipping_vendor_organization($organizationId,$return);
				$this->CI->shipping_m->update_shipping_vendor_employee($return['employeeId'],$return);
				$this->CI->shipping_m->update_shipping_vendor_address($return['addressId'],$return);
				$this->CI->session->set_flashdata('success','Information updated successfully');
				redirect(base_url().$this->CI->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($organizationId));				
			}	
		}
		
		$return['stateList'] = $this->CI->location_m->nigeria_state_list();	
		return $return;
	}
	
	public function block_unblock($employeeId,$status)
	{
		if($this->CI->shipping_m->block_unblock_user($employeeId,$status))
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
	
	public function add_shipping_rates($shippingOrgId)
	{
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));
			
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
						$this->CI->shipping_m->add_excel_file_data($shippingOrgId,$sheetData);
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
	
	public function shipping_rates_list($shippingOrgId)
	{
		$return = array();
		$return['total'] = $this->CI->shipping_m->total_shipping_rates($shippingOrgId);
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
			$total = $this->CI->shipping_m->total_shipping_rates($shippingOrgId,$where);
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
		
		$return['list']  = $this->CI->shipping_m->shipping_rates_list($shippingOrgId,$page,$pagConfig['per_page'],$where);
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