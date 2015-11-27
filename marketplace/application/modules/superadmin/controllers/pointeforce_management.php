<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Pointeforce_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct (); 	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Pointe Force Management';	
		$this->load->library('customer_lib');
		$this->load->model('pointe_force_m');
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'pointeforce_management',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Pointe Force Management';
		$this->superAdminCustomView('pointe_force_managements/pointeforce_list',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pointeforce_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->customer_lib->pointeforce_ajax();
		$this->load->view('pointe_force_managements/ajaxPagView',$this->data);
	}
	
	public function user_detail($customerId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	
		
		$customerId = id_decrypt($customerId);			
		$this->custom_log->write_log('custom_log','customer user id is '.$customerId);
		
		$this->data['result']     = $this->customer_lib->pointeforce_details($customerId);
		$this->data['customerId'] = $customerId;
		$this->superAdminCustomView('pointe_force_managements/user_details',$this->data);	
	}
	
	public function verified_commission($customerId)
	{
		$customerId = id_decrypt($customerId);
		if($customerId)
		{
			$this->customer_lib->pointeforce_verified_commission($customerId);
		}
		else
		{
			$this->session->set_flashdata('error','Customer id not found');
		}		
		redirect(base_url().'superadmin/pointeforce_management/user_detail/'.id_encrypt($customerId));		
	}
	
	public function unverified_commission($customerId)
	{
		$customerId = id_decrypt($customerId);
		if($customerId)
		{
			$this->customer_lib->pointeforce_unverified_commission($customerId);
		}
		else
		{
			$this->session->set_flashdata('error','Customer id not found');
		}		
		redirect(base_url().'superadmin/pointeforce_management/user_detail/'.id_encrypt($customerId));		
	}	
	
	public function unblock_block($customerId,$status)
	{
		$customerId = id_decrypt($customerId);
		if($customerId)
		{
			$this->customer_lib->customer_unblock_block($customerId,$status);
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_invalie_id'));
		}		
		redirect(base_url().'superadmin/pointeforce_management/user_detail/'.id_encrypt($customerId));		
	}
}