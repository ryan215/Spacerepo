<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class User_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct (); 	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Users Management';
		$this->load->model('user_m');
		$this->load->library('user_lib');	
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_management_index',
				'log_MID'    => '' 
		) );
		$this->superAdminCustomView('user_managements/users_list',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->user_lib->ajax_list();
		$this->load->view('user_managements/ajaxPagView',$this->data);
	}
	
	public function user_detail($employeeId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	
		
		$this->data['title']      = 'User Detail';
		$employeeId    		  	  = id_decrypt($employeeId);
		$this->data['result'] 	  = $this->user_lib->user_detail($employeeId);
		$this->data['employeeId'] = $employeeId;
		$this->superAdminCustomView('user_managements/user_details',$this->data);		
	}
		
	public function check_employee_email()
	{
		return $this->user_lib->check_employee_email();
	}
	
	public function add_user()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_user',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Add User';
		
		$result = $this->user_lib->user_sign_up();
		
		$this->data['imagePath'] 	   = base_url().'uploads/admin/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/user_management/upload_admin_image/';
		$this->data['result']          = $result;
		$this->superAdminCustomView('user_managements/add_user',$this->data);
	}
	
	
	
	public function upload_admin_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_admin_image',
				'log_MID'    => '' 
		) );
		$result = $this->user_lib->upload_image();
		echo $result;
	}
	
	public function unblock_block($employeeId,$status)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'unblock_block',
				'log_MID'    => '' 
		) );
		
		$employeeId = id_decrypt($employeeId);
		if(!empty($employeeId))
		{
			$return = $this->user_lib->block_unblock($employeeId,$status);
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
		redirect(base_url().'superadmin/user_management/user_detail/'.id_encrypt($employeeId));
	}
	
	public function update_admin_user($employeeId)
	{
		$employeeId  = id_decrypt($employeeId);
		$this->data['imagePath'] 	   = base_url().'uploads/admin/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/user_management/upload_admin_image/';
		$this->data['employeeId']      = $employeeId;
		$this->data['result']          = $this->user_lib->update_admin_user($employeeId);		
		$this->superAdminCustomView('user_managements/update_admin_user',$this->data);
	}
	
	public function update_superadmin_user($employeeId)
	{
		$employeeId  = id_decrypt($employeeId);
		$this->data['imagePath'] 	   = base_url().'uploads/admin/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/user_management/upload_admin_image/';
		$this->data['employeeId']      = $employeeId;
		$this->data['result']          = $this->user_lib->update_superadmin_user($employeeId);		
		$this->superAdminCustomView('user_managements/update_superadmin_user',$this->data);
	}
}
