<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Pointepay_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->library('pointepay_lib');
		$this->load->model('pointepay_m');

		$this->data['title'] = 'pointepay Managements';
	}
	public function index()
	{
	
	
	}	
	public function retailerList()
	{
	$this->adminCustomView('pointepay_management/retailer_list',$this->data);
	}
	
	public function ajaxRetailerList()
	{
		$retailerName=$this->input->post('retailerName');
		$this->data['result']=$this->profile_lib->pointepay_retailer_ajaxFun();
		$this->load->view('pointepay_management/ajax_retailer_list',$this->data);
		
	}
	public function searchRetailer()
	{
		if(isset($_POST) && !empty($_POST))
		{ //print_r($_POST);
			$rules=array(
						array(
						'field' =>	'phoneno',
						'label'	=>	'Phone Number',
						'rules'	=>	'trim|required|is_natural|max_length[12]'
						)
						);
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run())
			{
				$phoneno=$this->input->post('phoneno');
				redirect(base_url()."admin/pointepay_management/retailerDetailForm?phoneno=".$phoneno);
			}
			else{
				//echo validation_errors();
			}
		}
		$this->adminCustomView('pointepay_management/searchRetailer',$this->data);
	}
	public function retailerDetailForm()
	{
		$phnNumber=$this->input->get_post('phoneno');
		$userDetail=$this->user_m->pointepay_retailer_check_email_phone($phnNumber);
		$result['phoneno']			=	$phnNumber;
		$result['businessPhone']	=	$phnNumber;
		
		if(!empty($phnNumber))
		{
				if(!empty($userDetail))
				{
					
					$result['firstName']		=	$userDetail->firstName;
					$result['lastName']			=	$userDetail->lastName;
					$result['middleName']		=	$userDetail->middle;
					$result['imageName']		=	$userDetail->imageName;
					$result['organizationId']	=	$userDetail->organizationId;
					$result['birth_date']		=	'';
					$result['stateId']			=	$userDetail->state;
					$result['countryId']		=	154;
					$result['areaId']			=	$userDetail->area;
					$result['cityId']			=	$userDetail->city;
					$result['businessName']	=	$userDetail->organizationName;
					$result['email']			=	$userDetail->email;
					$result['street']		=	$userDetail->addressLine1;
					$result['businessPhone']	=	$phnNumber;
					$result['employeeId']		=	$userDetail->employeeId;
					$result['countryCode']		=	'+234';
					$result['addressId']		=	$userDetail->addressId;
					
				
				}
				else
					{
						$result['firstName']		=	'';
						$result['lastName']		=	'';
						$result['middleName']		=	'';
						$result['imageName']		=	'';
						$result['businessName']	=	'';
						$result['email']			=	'';
						$result['organizationId']	=	'';
						$result['birth_date']		=	'';
						$result['stateId']			=	'';
						$result['countryId']		=	154;
						$result['areaId']			=	'';
						$result['cityId']			=	'';
						$result['street']		=	'';
					}
			if(isset($_POST) && !empty($_POST)){
				if(!empty($userDetail))
					{
									
					$result['firstName']		=	$this->input->post('firstName');
					$result['lastName']			=	$this->input->post('lastName');
					$result['middleName']		=	$this->input->post('middleName');
					$result['imageName']		=	$userDetail->imageName;
					//$result['organizationId']	=	$userDetail->organizationId;
					$result['birth_date']		=	'';
					$result['stateId']			=	$this->input->post('stateId');
					$result['countryId']		=	154;
					$result['areaId']			=	$this->input->post('areaId');
					$result['cityId']			=	$this->input->post('cityId');
					$result['businessName']		=	$this->input->post('businessName');
					$result['email']			=	$this->input->post('email');
					$result['street']		=	$this->input->post('street');
					$result['businessPhone']	=	$phnNumber;
					//$result['employeeId']		=	$userDetail->employeeId;
					$result['countryCode']		=	'+234';
						
					$this->data['title'] 		   = 'Add Retailer';
				 $this->pointepay_lib->update_pointepay_retailer($result);
					$this->data['result'] 		   = $result;
				redirect(base_url().'admin/pointepay_management/retailerList');
						
					}
				else
					{
						$this->data['title'] 		   = 'Add Retailer';
					$result= $this->pointepay_lib->pointepay_retailer_sign_up($phnNumber);
						$result['phoneno']			=	$phnNumber;
						$this->data['result'] 		   = $result;		
						$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
						$this->data['imageUploadPath'] = base_url().'admin/retailer_management/upload_retailer_image/';
					}
			
			}
			$this->data['result'] 		   = $result;
			$this->adminCustomView('pointepay_management/retailerDetailForm',$this->data);
		}
		else
		{
			redirect(base_url().'admin/pointepay_management/searchRetailer');	
		}
		
	}
	public function user_detail($organizationId){
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	
		
		$organizationId 		  = id_decrypt($organizationId);
		$this->data['result']     = $this->pointepay_lib->retailer_userDetails($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->data['employeeId'] = $this->data['result']['employeeId'];
		//echo $this->db->last_query(); exit;
		$this->adminCustomView('pointepay_management/user_details',$this->data);
	}
	public function editRetailer($organizationId)
	{
		
		$this->session->set_userdata(array(
				'log_MODULE' => 'editRetailer',
				'log_MID'    => '' 
		) );
		
		$organizationId 				   = id_decrypt($organizationId);
		$this->data['result'] 		   = $this->pointepay_lib->retailer_edit($organizationId);
		$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
		$this->data['imageUploadPath'] = base_url().'admin/retailer_management/upload_retailer_image/';
		$this->data['organizationId']      = $organizationId;
		$this->adminCustomView('pointepay_management/editRetailer',$this->data);	
	}
	
	public function unblock_block($orgnizationId=0,$employeeId,$status)
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
		redirect(base_url().'admin/pointepay_management/user_detail/'.$orgnizationId);
	}
	public function invoiceListing()
	{
		
		$this->adminCustomView('pointepay_management/invoiceListing',$this->data);
		
	}
	public function ajaxInvoiceListing()
	{
		if(isset($_POST) && !empty($_POST))
		{
			$refNo=$this->input->post('refNo');
			$businessName=$this->input->post('businessName');
			$businessOwnerName=$this->input->post('businessOwnerName');
			$businessPhone=$this->input->post('businessPhone');
			$productName=	$this->input->post('productName');
			$price=	$this->input->post('price');
			$perPage=$this->input->post('sel_no_entry');
			$where='';
			if(!empty($refNo))
			{
				$where[]='pointepay_subscription.refrenceNumber like "%'.$refNo.'%"';
			}
			if(!empty($businessName))
			{
				$where[]='organization.organizationName like "%'.$businessName.'%"';
				
			}
			if(!empty($businessOwnerName))
			{
				$where[]='concat("employee.firstName"," ", "employee.lastName") like "%'.$businessOwnerName.'%"';
			}
			if(!empty($businessPhone))
			{
				$where[]='employee.businessPhone like "%'.$businessPhone.'%"';
			}
			if(!empty($price))
			{
				$where[]='pointepay_subscription.totalAmount like "%'.$price.'%"';
			}
			if(!empty($where))
			{
				$where=implode(' and ',$where);
			}
			
			$total=$this->pointepay_m->totalInvoice($where);
			$total= $total->total;
			 $pagConfig = array(
                    'base_url'       => base_url().'admin/pointepay_management/ajaxInvoiceListing',
                    'total_rows'     => $total,
                    'per_page'       => $perPage,
                    'uri_segment'    => 5,
                    'num_links'      => 4,
                    'num_tag_open'   => '<li>',
                    'num_tag_close'  => '</li>',
                    'cur_tag_open'   => '<li class="active"><a >',
                    'cur_tag_close'  => '</a></li>',
                    'next_tag_open'  => '<li>',
                    'next_tag_close' => '</li>',
                    'prev_tag_open'  => '<li>',
                    'prev_tag_close' => '</li>',
                    'next_link'      => '&raquo;',
                    'prev_link'      => '&laquo;'
            );

            $this->ajax_pagination->initialize($pagConfig);

            $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            $this->data['page'] = $page;
            $this->data['links'] = $this->ajax_pagination->create_links();
			
			$this->data['invoiceListing']=$this->pointepay_m->invoiceListing($where,$page,$perPage);
		}
		
		$this->load->view('pointepay_management/ajaxInvoiceListing',$this->data);
		
	}
	public function productsList()
	{
		$this->adminCustomView('pointepay_management/productList',$this->data);
	}
	public function orderList()
	{
		$this->adminCustomView('pointepay_management/orderList',$this->data);
		
	}
	public function ajaxOrderList()
	{
		if(isset($_POST) && !empty($_POST))
		{
			$planType=$this->input->post('planType');
			$firstName=$this->input->post('firstName');
			$lastName=$this->input->post('lastName');
			$phoneNo=$this->input->post('phoneNo');
			$email=$this->input->post('email');
			$where='';
			$perPage=$this->input->post('selnoentry');
			if(!empty($planType))
			{
				$where[]='pointepay_subscription.planType='.$planType;
			}
			if(!empty($firstName))
			{
				$where[]='pointepay_subscription.firstName like "%'.$firstName.'%"';
			}
			if(!empty($lastName))
			{
				$where[]='pointepay_subscription.lastName like "%'.$lastName.'%"';
				
			}
			if(!empty($phoneNo))
			{
				$where[]='pointepay_subscription.phone like "%'.$phoneNo.'%"';
			}
			if(!empty($email))
			{
				$where[]='pointepay_subscription.email like "%'.$email.'%"';
			}
			 if(!empty($where)){
                $where=implode($where,' and ');
            }
			$total=$this->pointepay_m->total_order($where);
			$total=$total->total;
			   $pagConfig = array(
                    'base_url'       => base_url().'admin/pointepay_management/ajaxOrderList',
                    'total_rows'     => $total,
                    'per_page'       => $perPage,
                    'uri_segment'    => 5,
                    'num_links'      => 4,
                    'num_tag_open'   => '<li>',
                    'num_tag_close'  => '</li>',
                    'cur_tag_open'   => '<li class="active"><a >',
                    'cur_tag_close'  => '</a></li>',
                    'next_tag_open'  => '<li>',
                    'next_tag_close' => '</li>',
                    'prev_tag_open'  => '<li>',
                    'prev_tag_close' => '</li>',
                    'next_link'      => '&raquo;',
                    'prev_link'      => '&laquo;'
            );

            $this->ajax_pagination->initialize($pagConfig);

            $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
            $this->data['page'] = $page;
            $this->data['links'] = $this->ajax_pagination->create_links();
			$this->data['orderList']=$this->pointepay_m->order_list($where,$page,$perPage);

			
		}
		$this->load->view('pointepay_management/ajaxOrderList',$this->data);
	}
	 public function orderDetail($pointepaySubscriptionId)
	 {
		 $posubId=id_decrypt($pointepaySubscriptionId);
		 $this->data['orderDetail']=$this->pointepay_m->orderDetail($posubId);
		 $this->data['accessoriesList']=$this->pointepay_m->getAccessorieslisting($posubId);
		 $this->data['productList']=$this->pointepay_m->getProductlisting($posubId);
		 $this->adminCustomView('pointepay_management/orderDetail',$this->data);
		 
	 }
	 public function addReference()
	 {
		 $referenceno=$this->input->post('refNo');
		 $refDetail=$this->pointepay_m->getRefDetail($referenceno);
		 if(!empty($refDetail)){
		 $organizationId=$this->input->post('organizationId');
		 $organizationId=id_decrypt($organizationId);
		$response= $this->pointepay_m->addReference($organizationId,$refDetail->pointepaySubscriptionId);
		if(!empty($response))
		{
			
			echo 'SuccessFully updated the refrence number';
		}
		else
		{
			echo 'Error in updating the refrence number';
		 }
		 }else{
			 echo 'Please send a Valid Reference Number';
		 }
	 }
	 
	
	
}