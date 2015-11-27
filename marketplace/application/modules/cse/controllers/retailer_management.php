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
		
		$this->cseCustomView('admin/retailer_managements/retailer_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->retailer_ajaxFun($total);
		//echo "<pre>"; print_r($this->data['result']); exit;
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
		$this->data['imageUploadPath'] = base_url().'cse/retailer_management/upload_retailer_image/';
		$this->cseCustomView('admin/retailer_managements/addRetailer',$this->data);	
	}
	
	public function user_detail($organizationId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	

		$organizationId 		      = id_decrypt($organizationId);
		$this->data['result']         = $this->profile_lib->retailer_userDetails($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->cseCustomView('admin/retailer_managements/user_details',$this->data);
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
		redirect(base_url().'cse/retailer_management/user_detail/'.$organizationId);
	}
	
	public function editRetailer($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editRetailer',
				'log_MID'    => '' 
		) );
		
		$organizationId 			   = id_decrypt($organizationId);
		$this->data['result'] 		   = $this->profile_lib->retailer_edit($organizationId);
		$this->data['organizationId']      = $organizationId;
		$this->data['imagePath'] 	   = base_url().'uploads/retailer/thumb50/';
		$this->data['imageUploadPath'] = base_url().'cse/retailer_management/upload_retailer_image/';
		$this->cseCustomView('admin/retailer_managements/editRetailer',$this->data);		
	}
	
	public function check_businessPhone()
	{
		$countryCode   = $this->input->post('countryCode');
		$businessPhone = $this->input->post('businessPhone'); 
		$employeeId    = ''; //$this->input->post('employeeId'); 
		$details       = $this->user_m->check_businessPhone($businessPhone,$countryCode,$employeeId);
		
		if(!empty($details))
		{
			$this->form_validation->set_message('check_businessPhone','The %s field already exits');
			return false;
		}
		else
		{
			$details = $this->user_m->check_username_exits($employeeId,$businessPhone);
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
	
	public function upload_retailer_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_retailer_image',
				'log_MID'    => '' 
		) );
		
		$imageName = $this->profile_lib->upload_retailer_image();
		echo $imageName;
	}
	
	public function email_exits()
	{
		$email		= $this->input->post('email'); 
		$employeeId = $this->input->post('employeeId'); 
		$details    = $this->user_m->check_email_exists($employeeId,$email);
		if(!empty($email))
		{
			if(!empty($details))
			{
				$this->form_validation->set_message('email_exits','The %s field already exits');
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	
	public function my_request_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_index',
				'log_MID'    => '' 
		));	
		
		echo $this->data['result'] = $this->profile_lib->my_request_list(); exit;
		$this->cseCustomView('retailer_managements/my_request_list',$this->data);
	}
	
	public function my_request_ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->retailer_ajaxFun($total);
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->load->view('admin/retailer_managements/ajaxPagView',$this->data);
	}
}