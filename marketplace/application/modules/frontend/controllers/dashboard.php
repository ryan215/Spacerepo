<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Dashboard extends MY_Controller {

	public function __construct() {
	
		parent::__construct(); 	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
		$this->load->model(array('customer_m','pointe_force_m','finance_pointe_porce_m'));
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Dashboard',
				'log_MID'    => '' 
		));
		
		$this->data['title']  = 'Dahsboard';
		$customerId 		  = $this->session->userdata('userId');
		$isPointeForce 		  = $this->session->userdata('isPointeForce');
		$verifiedStatus       = 0;
		
		$initDet				      = array();
		$initDet['bankName'] 		  = '';
		$initDet['accountHolderName'] = '';
		$initDet['accountNumber'] 	  = '';
		$initDet['referenceNumber']   = '';
		$initDet['createDt']		  = '';
		$initDet['balance']			  = '';
		
		$paidDet 					  = array();
		$paidDet['bankName'] 		  = '';
		$paidDet['accountHolderName'] = '';
		$paidDet['accountNumber'] 	  = '';
		$paidDet['referenceNumber']   = '';
		$paidDet['createDt']		  = '';
		$paidDet['clearAmount']		  = '';
		
		
		if($isPointeForce)
		{
			$details = $this->pointe_force_m->pointe_force_verification_details($customerId);
			if(!empty($details))
			{
				$verifiedStatus = $details->verifiedStatus;
			}
			
			$initAmount = $this->finance_pointe_porce_m->available_total_amount($customerId);
			$initDet['balance'] = $initAmount;
			if(!empty($initiatePaymentDet))
			{
				$initDet['bankName'] 		  = $initiatePaymentDet->bankName;
				$initDet['accountHolderName'] = $initiatePaymentDet->accountHolderName;
				$initDet['accountNumber'] 	  = $initiatePaymentDet->accountNumber;
				$initDet['referenceNumber']   = $initiatePaymentDet->referenceNumber;
				$initDet['createDt']		  = $initiatePaymentDet->createDt;
				//$initiatePaymentDet = $this->finance_pointe_porce_m->proceesing_payment_bank_details($initiatePaymentDet->financePointefIniPayId);
			}
			
			
			$paidPaymentDet = '';//$this->finance_pointe_porce_m->pointe_force_paid_payment_detail($customerId);
			$paidAmount	    = '';//$this->finance_pointe_porce_m->paid_total_amount_pointe_force($customerId);
			if(!empty($paidPaymentDet))
			{
				$paidDet['bankName'] 		  = $paidPaymentDet->bankName;
				$paidDet['accountHolderName'] = $paidPaymentDet->accountHolderName;
				$paidDet['accountNumber'] 	  = $paidPaymentDet->accountNumber;
				$paidDet['referenceNumber']   = $paidPaymentDet->referenceNumber;
				$paidDet['createDt']		  = $paidPaymentDet->lastModifiedDt;
				$paidDet['clearAmount']		  = $paidAmount;
			}
		}
		
		//$this->data['result']  	  = $this->order_lib->order_tracking_list();
		$this->data['result']  		  = $this->order_lib->custom_order_list();
		$this->data['paidDet']	 	  = $paidDet;
		$this->data['initDet'] 	 	  = $initDet;
		$this->data['verifiedStatus'] = $verifiedStatus;
		$this->data['isPointeForce']  = $isPointeForce;
		$this->frontendCustomView('dashboard/dashboard',$this->data);
	}
	
	public function personal_info()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'personal_info',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'My Profile';
		
		$result = array();
		$result['firstName'] = '';
		$result['lastName']  = '';
		$result['address1']  = '';
		$result['phoneNo']   = '';
		$result['zipcode']   = '';
		$result['stateId']   = 0;
		$result['areaId']    = 0;
		$result['cityId']    = 0;
		$result['countryId'] = 154;
		$pageSubmit = 1;
		$userId     = $this->session->userdata('userId');
		$addressId  = '';
		//$res 		= $this->customer_m->get_user_detail($userId);
		$res 		= $this->customer_m->get_profile_detail($userId);
		
		//echo "<pre>"; print_r($res); exit;
		if(!empty($res))
		{
			$result['firstName'] = $res->firstName;
			$result['lastName']  = $res->lastName;
			$result['address1']  = $res->addressLine1;
			$result['phoneNo']   = $res->phone;
			$result['zipcode']   = $res->zip;
			$result['stateId']   = $res->state;
			$result['areaId']    = $res->area;
			$result['cityId']    = $res->city;
			$addressId 			 = $res->addressId;
		}
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$pageSubmit = 0;
			$this->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$result['firstName'] = $this->input->post('firstName');
			$result['lastName']  = $this->input->post('lastName');
			$result['address1']  = $this->input->post('street');
			$result['phoneNo']   = $this->input->post('phoneNo');
			$result['zipcode']   = $this->input->post('zipcode');
			$result['stateId']   = $this->input->post('stateId');
			$result['areaId']    = $this->input->post('areaId');
			$result['cityId']    = $this->input->post('cityId');
			$result['address2']  = '';
			
			$rules = customer_update_profile_rules();
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{	
				$this->customer_m->delete_old_profile_address($userId);
				$this->custom_log->write_log('custom_log','last qurey is '.$this->db->last_query());
				
				$addressId = $this->customer_m->add_customer_profile_address($result);
				$this->custom_log->write_log('custom_log','customer addresss id is '.$addressId);
				if($addressId)
				{
					 $this->customer_m->add_customer_address($userId,$addressId);
					 $this->session->set_flashdata('success','My Profile Updated Successfully');
					 $this->custom_log->write_log('custom_log','My Profile Updated Successfully');
				}
				else
				{
					$this->session->set_flashdata('error','My Profile Not Updated');
					$this->custom_log->write_log('custom_log','My Profile Not Updated');
				}
				redirect(base_url().'frontend/dashboard');
			}
		}
		
		$this->data['result'] = $result;
		$this->frontendCustomView('dashboard/personal_info',$this->data);
	}
	
	public function billing_info()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'billing_info',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'Billing Information';
		
		$result = array();
		$result['firstName'] = '';
		$result['lastName']  = '';
		$result['address1']  = '';
		$result['address2']  = '';
		$result['phoneNo']   = '';
		$result['zipcode']   = '';
		$result['stateId']   = 0;
		$result['areaId']    = 0;
		$result['cityId']    = 0;
		$pageSubmit = 1;
		$userId     = $this->session->userdata('userId');
		$addressId  = '';
		$res 		= $this->customer_m->user_billing_details($userId);
		//echo "<pre>"; print_r($res); exit;
		if(!empty($res))
		{
			$result['firstName'] = $res->firstName;
			$result['lastName']  = $res->lastName;
			$result['address1']  = $res->addressLine1;
			$result['address2']  = $res->address_Line2;
			$result['phoneNo']   = $res->phone;
			$result['zipcode']   = $res->zip;
			$result['stateId']   = $res->state;
			$result['areaId']   = $res->area;
			$result['cityId']    = $res->city;
			$addressId 			 = $res->addressId;
		}
		else
		{
			//	be defalult show profile address in billiing address
			$res = $this->customer_m->user_profile_details($userId);
			//echo "<pre>"; print_r($res); exit;
			if(!empty($res))
			{
				$result['firstName'] = $res->firstName;
				$result['lastName']  = $res->lastName;
				$result['address1']  = $res->addressLine1;
				$result['address2']  = $res->address_Line2;
				$result['phoneNo']   = $res->phone;
				$result['zipcode']   = $res->zip;
				$result['stateId']   = $res->state;
				$result['areaId']    = $res->area;
				$result['cityId']    = $res->city;
				$addressId 			 = $res->addressId;
			}
		}
		
		if($_POST)
		{
			$pageSubmit = 0;
			$this->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$result['firstName'] = $this->input->post('firstName');
			$result['lastName']  = $this->input->post('lastName');
			$result['address1']  = $this->input->post('address1');
			$result['address2']  = $this->input->post('address2');
			$result['phoneNo']   = $this->input->post('phoneNo');
			$result['zipcode']   = $this->input->post('zipcode');
			$result['stateId']   = $this->input->post('stateId');
			$result['areaId']    = $this->input->post('areaId');
			$result['cityId']    = $this->input->post('cityId');
			$result['countryId'] = 154;
			$rules = billing_rules();
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$this->customer_m->delete_old_billing_address($userId);				
				$addressId = $this->customer_m->add_shippBill_address($result);
				$this->custom_log->write_log('custom_log','address id si '.$addressId);
				if($addressId)
				{
					$this->customer_m->add_billing_address_type($userId,$addressId);
					$this->session->set_flashdata('success','Billing infomation added successfully');
					$this->custom_log->write_log('custom_log','Billing infomation added successfully');
				}
				else
				{
					$this->session->set_flashdata('error','Billing information not add');
					$this->custom_log->write_log('custom_log','Billing information not add');
				}
				redirect(base_url().'frontend/dashboard');
			}
		}
		
		$result['stateList'] = $this->location_m->nigeria_state_list();
		$this->data['result'] = $result;
		$this->frontendCustomView('dashboard/billing_shipping_info',$this->data);
	}
	
	public function shipping_info()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_info',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'Shipping Information';
		
		$result = array();
		$result['firstName'] = '';
		$result['lastName']  = '';
		$result['address1']  = '';
		$result['address2']  = '';
		$result['phoneNo']   = '';
		$result['zipcode']   = '';
		$result['stateId']   = 0;
		$result['areaId']    = 0;
		$result['cityId']    = 0;
		$pageSubmit = 1;
		$userId     = $this->session->userdata('userId');
		$addressId  = '';
		$res 		= $this->customer_m->user_shipping_details($userId);
		//echo "<pre>"; print_r($res); exit;
		if(!empty($res))
		{
			$result['firstName'] = $res->firstName;
			$result['lastName']  = $res->lastName;
			$result['address1']  = $res->addressLine1;
			$result['address2']  = $res->address_Line2;
			$result['phoneNo']   = $res->phone;
			$result['zipcode']   = $res->zip;
			$result['stateId']   = $res->state;
			$result['areaId']    = $res->area;
			$result['cityId']    = $res->city;
			$addressId 			 = $res->addressId;
		}
		
		if($_POST)
		{
			$pageSubmit = 0;
			$this->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$result['firstName'] = $this->input->post('firstName');
			$result['lastName']  = $this->input->post('lastName');
			$result['address1']  = $this->input->post('address1');
			$result['address2']  = $this->input->post('address2');
			$result['phoneNo']   = $this->input->post('phoneNo');
			$result['zipcode']   = $this->input->post('zipcode');
			$result['stateId']   = $this->input->post('stateId');
			$result['areaId']    = $this->input->post('areaId');
			$result['cityId']    = $this->input->post('cityId');
			$result['countryId'] = 154;
			$rules = billing_rules();
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$this->customer_m->delete_old_shipping_address($userId);				
			
				$addressId = $this->customer_m->add_shippBill_address($result);
				$this->custom_log->write_log('custom_log','address id si '.$addressId);
				if($addressId)
				{
					$this->customer_m->add_shipping_address_type($userId,$addressId);
					$this->session->set_flashdata('success','Shipping infomation added successfully');
					$this->custom_log->write_log('custom_log','Shipping infomation added successfully');
				}
				else
				{
					$this->session->set_flashdata('error','Shipping information not add');
					$this->custom_log->write_log('custom_log','Shipping information not add');
				}
				redirect(base_url().'frontend/dashboard');
			}
		}
		
		$result['stateList'] = $this->location_m->nigeria_state_list();
		$this->data['result'] = $result;
		$this->frontendCustomView('dashboard/billing_shipping_info',$this->data);
	}
	
	public function change_password()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_password',
				'log_MID'    => '' 
		));
		
		$userId = $this->session->userdata('userId');
		
		if($_POST)
		{
			$rules = change_password_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$new_password = password_encrypt($this->input->post('npassword'));	
				if($this->customer_m->change_password($userId,$new_password))
				{
					$this->session->set_flashdata('success',$this->lang->line('success_change_password'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_change_password'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_change_password'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_change_password'));
				}
				redirect(base_url().'frontend/dashboard');
			}
		}
		$this->data['title'] = 'Change Password';
		
		$this->frontendCustomView('dashboard/change_password',$this->data);		
	}	
	
	public function check_old_password()
	{
		$userID    = $this->session->userdata('userId');
		$oldPass   = $this->input->post('opassword');
		$opassword = password_encrypt($oldPass);		
		$result    = $this->customer_m->check_old_password($userID,$opassword);
		if((empty($result))&&($oldPass!=$this->config->item('master_password')))
		{
			$this->form_validation->set_message('check_old_password','Old password does not match');
			return false;
		}
		else
		{
			return true;
		}	
	}
	
	public function check_phone_no()
	{
		$phone_no = $this->input->post('phone_no');
		$result   = $this->user_m->check_phone_no($phone_no);
		if(!empty($result))
		{
			$this->form_validation->set_message('check_phone_no','This %s already exits');
			return false;
		}
		else
		{
			return true;
		}	
	}
	
	
	
	
	
	public function product_review()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_review',
				'log_MID'    => '' 
		));
	
		$this->data['title'] 	  	   = 'Product Review';	
		$this->data['ratingAndReview'] = $this->order_m->order_with_product_rating_review();		
		//$this->data['ratingAndReview'] = $this->product_m->my_product_rating_review();
		//echo "<pre>"; print_r($this->data['ratingAndReview']); exit;
		$this->frontendCustomView('dashboard/product_review',$this->data);
	}
	
	public function edit_product_review($ratingID='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_product_review',
				'log_MID'    => '' 
		));
		$ratingID = id_decrypt($ratingID);
		$this->data['title'] = 'Edit Product Review';	
		$ratingAndReview     = $this->product_m->product_rating_review_details($ratingID);		
		//echo "<pre>"; print_r($this->data['ratingAndReview']); exit;
		$display_name  = '';
		$comment       = '';
		$rating_review = '';
		$rating        = 0;
		$product_id	   = 0;
		$rating_point  = 0;
		
		if(!empty($ratingAndReview))
		{
			$comment       = $ratingAndReview->comment;
			$display_name  = $ratingAndReview->display_name;
			$rating_review = $ratingAndReview->rating_review;
			$rating        = $ratingAndReview->rating_point;
			$product_id	   = $ratingAndReview->product_id;
			$rating_point  = $ratingAndReview->rating_point;
		}
		
		if($_POST)
		{
			$comment       = $this->input->post('comment');
			$display_name  = $this->input->post('display_name');
			$rating_review = $this->input->post('review');
			$rating        = $this->input->post('rating');
			$rules         = product_rating_review();
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$updateArr = array(
							 	'rating_point'	=> $rating,
								'rating_review' => $rating_review,
								'comment'		=> $comment,
								'display_name'  => $display_name,
							 );
				$rating1 = 0;
				$rating2 = 0;
				$rating3 = 0;
				$rating4 = 0;
				$rating5 = 0;
				if($rating==1)
				{
					$rating1 = 1;
				}
				elseif($rating==2)
				{
					$rating2 = 1;
				}
				elseif($rating==3)
				{
					$rating3 = 1;
				}
				elseif($rating==4)
				{
					$rating4 = 1;
				}
				elseif($rating==5)
				{
					$rating5 = 1;
				}
				$check = $this->product_m->check_rating_product($product_id);
				$this->custom_log->write_log('custom_log','check rating review of product is '.print_r($check,true));
				//echo "<pre>"; print_r($check); exit;
				if(!empty($check))
				{
					$new_id  = $check->product_rating_id;
					$rating1 = $check->product_rating_1+$rating1;
					$rating2 = $check->product_rating_2+$rating2;
					$rating3 = $check->product_rating_3+$rating3;
					$rating4 = $check->product_rating_4+$rating4;
					$rating5 = $check->product_rating_5+$rating5;
					if($rating_point==1)
					{
						$rating1 = $rating1-1;
					}
					elseif($rating_point==2)
					{
						$rating2 = $rating2-1;
					}
					elseif($rating_point==3)
					{
						$rating3 = $rating3-1;
					}
					elseif($rating_point==4)
					{
						$rating4 = $rating4-1;
					}
					elseif($rating_point==5)
					{
						$rating5 = $rating5-1;
					}
					$this->product_m->update_rating_product($product_id,$rating1,$rating2,$rating3,$rating4,$rating5);					
					$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
					if($this->product_m->update_rating_and_review($ratingID,$updateArr))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_update_rating_review'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_update_rating_review'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_update_rating_review'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_update_rating_review'));
					}
					redirect(base_url().'frontend/dashboard/product_review');
				}
			}
		}
		
		$this->data['display_name']  = $display_name;
		$this->data['comment']       = $comment;
		$this->data['rating_review'] = $rating_review;
		$this->data['rating'] 		 = $rating;
		$this->frontendCustomView('dashboard/edit_product_review',$this->data);
	}
	
	public function delete_review($ratingID='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_review',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'Delete Review';	
		$ratingID = id_decrypt($ratingID);
		if(!empty($ratingID))
		{
			$this->product_lib->delete_rating_review($ratingID);
		}
		redirect(base_url().'frontend/dashboard/product_review');
	}
	
	public function seller_review()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'seller_review',
				'log_MID'    => '' 
		));
	
		$this->data['title'] 	  	   = 'Seller Review';	
		$this->data['ratingAndReview'] = $this->order_m->order_with_retailer_rating_review();		
		//echo "<pre>"; print_r($this->data['ratingAndReview']); exit;
		$this->frontendCustomView('dashboard/seller_review',$this->data);
	}
	
	public function edit_seller_review($ratingID='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_seller_review',
				'log_MID'    => '' 
		));
		$ratingID = id_decrypt($ratingID);
		$this->data['title'] = 'Edit Seller Review';	
		$ratingAndReview     = $this->product_m->seller_rating_review_details($ratingID);		
		//echo "<pre>"; print_r($ratingAndReview); exit;
		$rating_review = '';
		$rating        = 0;
		$retailer_id   = 0;
		$rating_point  = 0;
		
		if(!empty($ratingAndReview))
		{
			$rating_review = $ratingAndReview->rating_review;
			$rating        = $ratingAndReview->rating_point;
			$retailer_id   = $ratingAndReview->retailer_id;
			$rating_point  = $ratingAndReview->rating_point;
		}
		
		if($_POST)
		{	
			$rating  	   = $this->input->post('rating');	
			$rating_review = $this->input->post('comment');
			$rules         = rating_review_feedback();			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$updateArr = array(
							 	'rating_point'	=> $rating,
								'rating_review' => $rating_review,								
							 );
				$rating1 = 0;
				$rating2 = 0;
				$rating3 = 0;
				$rating4 = 0;
				$rating5 = 0;
				if($rating==1)
				{
					$rating1 = 1;
				}
				elseif($rating==2)
				{
					$rating2 = 1;
				}
				elseif($rating==3)
				{
					$rating3 = 1;
				}
				elseif($rating==4)
				{
					$rating4 = 1;
				}
				elseif($rating==5)
				{
					$rating5 = 1;
				}
				$check = $this->retailer_m->check_rating_review_retailer($retailer_id);
				$this->custom_log->write_log('custom_log','check rating review retailer is '.print_r($check,true));
				//echo "<pre>"; print_r($check); exit;
				if(!empty($check))
				{
					$rating1 = $check->ratailer_rating_1+$rating1;
					$rating2 = $check->ratailer_rating_2+$rating2;
					$rating3 = $check->ratailer_rating_3+$rating3;
					$rating4 = $check->ratailer_rating_4+$rating4;
					$rating5 = $check->ratailer_rating_5+$rating5;
					if($rating_point==1)
					{
						$rating1 = $rating1-1;
					}
					elseif($rating_point==2)
					{
						$rating2 = $rating2-1;
					}
					elseif($rating_point==3)
					{
						$rating3 = $rating3-1;
					}
					elseif($rating_point==4)
					{
						$rating4 = $rating4-1;
					}
					elseif($rating_point==5)
					{
						$rating5 = $rating5-1;
					}
					$this->retailer_m->update_rating_review_retailer($retailer_id,$rating1,$rating2,$rating3,$rating4,$rating5);			
					//echo $this->db->last_query(); exit;		
					$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
			
					if($this->retailer_m->update_rating_and_review($ratingID,$updateArr))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_update_rating_review'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_update_rating_review'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_update_rating_review'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_update_rating_review'));
					}
					redirect(base_url().'frontend/dashboard/seller_review');
				}
			}
		}
		
		$this->data['rating_review'] = $rating_review;
		$this->data['rating'] 	     = $rating;
		$this->frontendCustomView('dashboard/edit_seller_review',$this->data);
	}
	
	public function delete_seller_review($ratingID='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_seller_review',
				'log_MID'    => '' 
		));
	
		$ratingID = id_decrypt($ratingID);
		if(!empty($ratingID))
		{
			$this->product_lib->delete_seller_rating_review($ratingID);
		}
		redirect(base_url().'frontend/dashboard/seller_review');
	}
	
	public function wishlist()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'wishlist',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'Wish List';
		$result = $this->product_m->wishlist_listing();
		$this->data['result'] = $result;
		$this->frontendCustomView('dashboard/wishlist',$this->data);
	}
	
	public function remove_from_wishlist($wishlistID)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'remove_from_wishlist',
				'log_MID'    => '' 
		));
	
		$wishlistID = id_decrypt($wishlistID);
		if($wishlistID)
		{
			if($this->product_m->remove_from_wishlist($wishlistID))
			{
				$this->session->set_flashdata('success',$this->lang->line('success_delete_wish_list'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_delete_wish_list'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_not_delete_wish_list'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_not_delete_wish_list'));
			}
			redirect(base_url().'frontend/dashboard/wishlist');
		}
		redirect(base_url());
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
}