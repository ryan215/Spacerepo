<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Vendor_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Vendor Managment';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'vendore_management_index',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->profile_lib->shipping_vendor_index();
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->cseCustomView('admin/shipping_management/vendors_management/vendore_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->shipping_vendor_ajaxFun($total);
		//echo "<pre>"; print_r($this->data['result']);
		$this->load->view('admin/shipping_management/vendors_management/ajaxPagView',$this->data);
	}
	
	public function addVendore()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addVendore',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] 		   = 'Add Shipping Vendor';
		$result 					   = $this->profile_lib->shipping_vendore_sign_up();
		$this->data['result'] 		   = $result;		
		$this->data['imagePath'] 	   = base_url().'uploads/shipping/thumb50/';
		$this->data['imageUploadPath'] = base_url().'cse/vendor_management/upload_image/';
		$this->cseCustomView('admin/shipping_management/vendors_management/addVendore',$this->data);	
	}
	
	public function user_detail($organizationId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	

		$organizationId 		      = id_decrypt($organizationId);
		$this->data['result']         = $this->profile_lib->shipping_vendor_userDetails($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->cseCustomView('admin/shipping_management/vendors_management/user_details',$this->data);
	}
	
	public function editVendor($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editVendor',
				'log_MID'    => '' 
		) );
		
		$organizationId 			   = id_decrypt($organizationId);
		$this->data['result'] 		   = $this->profile_lib->shipping_vendor_edit($organizationId);
		$this->data['imagePath'] 	   = base_url().'uploads/shipping/thumb50/';
		$this->data['imageUploadPath'] = base_url().'cse/vendor_management/upload_image/';
		$this->data['organizationId']  = $organizationId;
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->cseCustomView('admin/shipping_management/vendors_management/editVendor',$this->data);		
	}
	
	public function check_email_address()
	{
		$employeeId = $this->input->post('employeeId');
		$email      = $this->input->post('email');
		$details    = $this->shipping_m->check_email_address($employeeId,$email);
		if(!empty($details))
		{
			$this->form_validation->set_message('email','The %s field already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
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
	
	public function unblock_block($organizationId,$employeeId,$status)
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
					$shippingOrgId  = id_decrypt($organizationId);
		$users_details  = $this->user_m->shipping_vendor_user_details($shippingOrgId);		
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$passwordStatus = $users_details->passwordStatus;
		}
		if(!empty($shippingOrgId))
		{
			if($passwordStatus==0)
			{
				$newPass    = otp5_digit();
				$employeeId = $users_details->employeeId;
				if($employeeId)
				{							
					$this->user_m->update_password($employeeId,$newPass);
					$mailData = array(
								'email'        => $users_details->email,
								'cc'	       => '',
								'slug'         => 'vendor_sign_up',
								'name'         => $users_details->organizationName,
								'password'	   => $newPass,
								'subject'      => 'Shipping Vendor Sign up Successfully',
							);										
					if($this->email_m->send_mail($mailData))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
					}
					$message = 'Hi '.$users_details->organizationName.'<br>Thank you for signing up. Once we verify your submitted details you will be able to sell on pointemart. OTP to verify your details is '.$newPass.'. You will hear back from us shortly. To check the status of your request you can call us at '.$this->config->item('admin_phone_no').' or email us at '.$this->config->item('admin_email');
 					$rs = $this->twillo_m->send_mobile_message($users_details->businessPhoneCode.$users_details->businessPhone,$message);
				}
			}
		}
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
		redirect(base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.$organizationId);
	}
	
	public function upload_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_retailer_image',
				'log_MID'    => '' 
		) );
		
		$imageName = $this->profile_lib->upload_shipping_vendor_image();
		echo $imageName;
	}
	
	public function check_businessPhone()
	{
		$employeeId    = $this->input->post('employeeId');
		$countryCode   = $this->input->post('countryCode');
		$businessPhone = $this->input->post('businessPhone'); 
		$details       = $this->user_m->check_businessPhone($businessPhone,$countryCode,$employeeId);
		
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
	
	public function file_download()
	{
        $this->load->helper('download');
        $data = file_get_contents('uploads/test.xlsx');
        $name = 'test.xlsx';
        force_download($name,$data);
	}
	
	public function upload_document_excel()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_upload_document',
				'log_MID'    => '' 
		) );
		$result = $this->profile_lib->shipping_vendor_upload_document();
		echo json_encode($result);	
	}
	
	public function delete_rate($shippingOrgId=0,$shippingRateId=0)
	{	
		$shippingRateId = id_decrypt($shippingRateId);
		if($this->user_m->delete_shipping_rate($shippingRateId))
		{
			$this->session->set_flashdata('success','Shipping Rates deleted Successfully');
		}
		else		
		{
			$this->session->set_flashdata('error','Rate not delete');
		}
		redirect(base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.$shippingOrgId);
	}
	
	public function addShippingRates($shippingOrgId=0)
	{
		$shippingOrgId  = id_decrypt($shippingOrgId);
		
		if(!empty($shippingOrgId))
		{
			$this->profile_lib->add_shipping_rates($shippingOrgId);
			$this->data['shippingOrgId'] = $shippingOrgId;
			$this->cseCustomView('admin/shipping_management/vendors_management/addShippingRates',$this->data);	
		}
	}
	
	public function check_excel_file_valid()
	{
		$document_name = $this->input->post('image_name');
		$imagepath = 'uploads/shipping/upload_doc/'.$document_name;
		$this->custom_log->write_log('custom_log','document path is '.$imagepath);
		$this->load->library('excel');
		if(file_exists($imagepath))
		{
			$objPHPExcel = PHPExcel_IOFactory::load($imagepath);
			$sheetData   = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$newArr      = array_shift($sheetData); 
			$this->custom_log->write_log('custom_log','new array is '.print_r($newArr,true));	
			if((!empty($newArr))&&(!empty($sheetData)))
			{
				//echo "<pre>";	print_r($sheetData); exit;
				if(!empty($sheetData[1]))
				{
					//echo "<pre>";	print_r($sheetData[1]); exit;
					$flag = false; 
					foreach($sheetData as $key=>$val)
					{
						//echo $key; echo "<pre>"; print_r($val); 
						if($key>0)
						{	//echo $val['A']; 
							$priceField = trim($val['G']);
							$this->custom_log->write_log('custom_log','price valiue is '.$priceField);
							if(empty($priceField))	
							{
								$this->form_validation->set_message('check_excel_file_valid','Price is empty field');	
								$this->custom_log->write_log('custom_log','Price is empty field');	
								return FALSE;
							}
							
							$extDay = trim($val['H']);
							if(empty($extDay))	
							{
								$this->form_validation->set_message('check_excel_file_valid','Estimated Delivery Timeframe (In Days) is empty field');	
								$this->custom_log->write_log('custom_log','Estimated Delivery Timeframe (In Days) is empty field');	
								return FALSE;
							}
							
							$this->custom_log->write_log('custom_log','Weight From '.$val['F'].' <= Weight To '.$val['E']);
							if($val['F']<=$val['E'])	
							{
								$this->form_validation->set_message('check_excel_file_valid','Please recheck with the entry of "Weight From" and "Weight To".<br> "Weight From" will always be smaller than "Weight To"');	
								$this->custom_log->write_log('custom_log','Please recheck with the entry of "Weight From" and "Weight To".<br> "Weight From" will always be smaller than "Weight To"');	
								return FALSE;
							}
							
							$dropShipCenterName = trim($val['A']);
							if(empty($dropShipCenterName))	
							{
								$this->form_validation->set_message('check_excel_file_valid','Dropship Center Name field is empty');	
								$this->custom_log->write_log('custom_log','Dropship Center Name field is empty');	
								return FALSE;
							}
							
							$this->db->select('*');
							$this->db->from('dropship_center');
							$this->db->where('trim(dropCenterName)',$dropShipCenterName);
							$drpCntrDet = $this->db->get()->row();
									
							if(empty($drpCntrDet))
							{
								$this->form_validation->set_message('check_excel_file_valid','Dropship center name '.$val['A'].' is wrong, Please Write IKOTA1,IKEJA1,OJUELEGBA1,OREGUN,ADESUWA1 and NEW BENIN1');		
								return FALSE;
							}
									
							$expStr = explode(',',$val['D']);
							
							if(!empty($expStr))
							{
								foreach($expStr as $toVal)
								{
									$stateName = trim(strtolower($val['B']));
									$areaName  = trim(strtolower($val['C']));
									$cityName  = trim(strtolower($toVal));
									
									if((!empty($stateName))&&($areaName)&&($cityName))
									{
										$this->db->select('*');
										$this->db->from('zip');
										$this->db->join('area','zip.area = area.areaId');
										$this->db->join('state','zip.stateId = state.stateId');
										$this->db->join('country','state.countryId = country.countryId');
										$this->db->where('(zip.countryId = 154 AND trim(lcase(zip.city)) = "'.$cityName.'" AND trim(lcase(area.area)) = "'.$areaName.'" AND trim(lcase(state.stateName)) = "'.$stateName.'")');
										$res = $this->db->get()->row();
										
										$this->custom_log->write_log('custom_log','callback function last query is '.$this->db->last_query());
										$this->custom_log->write_log('custom_log','callback function and result is '.print_r($res,true));
										if(!empty($res))
										{
										}
										else
										{
											$this->form_validation->set_message('check_excel_file_valid','This City '.$toVal.' is not available in our list');			
											return FALSE;
										}
									}
								}
							}
						}
					}					
				}
				else
				{
					$this->form_validation->set_message('check_excel_file_valid','Your Excel File is Empty');	
					$this->custom_log->write_log('custom_log','Your Excel File is Empty');			
					return FALSE;			
				}			
			}
			else
			{
				$this->form_validation->set_message('check_excel_file_valid','Your Excel File is Empty');			
				return FALSE;
			}
		}
		else
		{
			$this->form_validation->set_message('check_excel_file_valid','Excel File Not Found');
			$this->custom_log->write_log('custom_log','Excel File Not Found');			
			return FALSE;
		}			
	}
	
	public function activate_user($shippingOrgId=0)
	{
		$passwordStatus = 0;
		$shippingOrgId  = id_decrypt($shippingOrgId);
		$users_details  = $this->user_m->shipping_vendor_user_details($shippingOrgId);		
		//echo "<pre>"; print_r($users_details); exit;
		if(!empty($users_details))
		{
			$passwordStatus = $users_details->passwordStatus;
		}
		if(!empty($shippingOrgId))
		{
			if($passwordStatus==0)
			{
				$newPass    = otp5_digit();
				$employeeId = $users_details->employeeId;
				if($employeeId)
				{							
					$this->user_m->update_password($employeeId,$newPass);
					$mailData = array(
								'email'        => $users_details->email,
								'cc'	       => 'llekena-okoro@spacepointe.com',
								'slug'         => 'vendor_sign_up',
								'name'         => $users_details->organizationName,
								'password'	   => $newPass,
								'subject'      => 'Shipping Vendor Sign up Successfully',
							);										
					if($this->email_m->send_mail($mailData))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_mail_send'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
					}
					$message = 'Hi '.$users_details->organizationName.'<br>Thank you for signing up. Once we verify your submitted details you will be able to sell on pointemart. OTP to verify your details is '.$newPass.'. You will hear back from us shortly. To check the status of your request you can call us at '.$this->config->item('admin_phone_no').' or email us at '.$this->config->item('admin_email');
 					$rs = $this->twillo_m->send_mobile_message($users_details->businessPhoneCode.$users_details->businessPhone,$message);
				}
			}
		}
		redirect(base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($shippingOrgId));		
	}
	
	public function edit_rate($shippingRateId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_rate',
				'log_MID'    => '' 
		) );
		
		$shippingRateId 			   = id_decrypt($shippingRateId);
		$this->data['result'] 		   = $this->profile_lib->shipping_vendor_edit_rate($shippingRateId);
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->cseCustomView('admin/shipping_management/vendors_management/editRate',$this->data);		
	}
	
	public function shipping_rate_list($shippingOrgId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_rate_list',
				'log_MID'    => '' 
		) );
		
		$shippingOrgId 		  = id_decrypt($shippingOrgId);		
		$this->data['title']  = 'Shipping Rate List';
		$this->data['result'] = $this->profile_lib->shipping_rates_list($shippingOrgId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->cseCustomView('admin/shipping_management/vendors_management/shipping_rates_list',$this->data);
	}
	
	public function shippingRatesAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shippingRatesAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->shipping_rates_list_ajax($total);
		$this->load->view('admin/shipping_management/vendors_management/shipping_rates_list_ajax',$this->data);	
	}
	
	public function addShippingRatesFrom10To30($shippingOrgId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addShippingRatesFrom10To30',
				'log_MID'    => '' 
		) );
		
		$shippingOrgId 		 = id_decrypt($shippingOrgId);		
		$this->data['title'] = 'Shipping Rate List';
		$this->data['result'] = $this->profile_lib->add_shipping_rates_from_10_to_30($shippingOrgId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->cseCustomView('admin/shipping_management/vendors_management/addShippingRatesFrom10To30',$this->data);
	}
}