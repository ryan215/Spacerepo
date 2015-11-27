<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Finance_pointe_force_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Finance Pointe Force Managment';
		$this->load->model(array('finance_pointe_porce_m','finance_vendor_m','pointe_force_m','finance_retailer_m','retailer_m'));
		$this->load->library('finance_pointe_force_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'finance_pointe_force_management',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_pointe_force_lib->available_list();		
		$this->superAdminCustomView('admin/finance_pointe_force_managements/balance_available_list',$this->data);
	}
	
	public function balance_available_view($customerId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_available_view',
				'log_MID'    => '' 
		));	
		
		$customerId = id_decrypt($customerId);
		if(!$customerId)
		{
			redirect(base_url().'superadmin/finance_pointe_force_management');
		}
		
		$this->data['result']     = $this->finance_pointe_force_lib->balance_available_view($customerId);
		$this->data['customerId'] = $customerId;
		$this->superAdminCustomView('admin/finance_pointe_force_managements/balance_available_view',$this->data);
	}
	
	public function initiate_payment($customerId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'initiate_payment',
				'log_MID'    => '' 
		));	
		
		$customerId = id_decrypt($customerId);
		if(!$customerId)
		{
			redirect(base_url().'superadmin/finance_pointe_force_management');
		}
		
		$this->data['result']     = $this->finance_pointe_force_lib->initiate_payment($customerId);
		$this->data['customerId'] = $customerId;
		$this->superAdminCustomView('admin/finance_pointe_force_managements/initiate_payment',$this->data);
	}
	
	public function processing_balance()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'processing_balance',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_pointe_force_lib->processing_list();
		$this->superAdminCustomView('admin/finance_pointe_force_managements/balance_processing_list',$this->data);
	}
	
	public function balance_processing_view($customerId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_processing_view',
				'log_MID'    => '' 
		));	
		
		$customerId = id_decrypt($customerId);
		if(!$customerId)
		{
			redirect(base_url().'superadmin/finance_pointe_force_management/processing_balance');
		}
		
		$this->data['result']     = $this->finance_pointe_force_lib->balance_processing_view($customerId);
		$this->data['customerId'] = $customerId;
		$this->superAdminCustomView('admin/finance_pointe_force_managements/balance_processing_view',$this->data);
	}
	
	public function reference_number($customerId=0,$financePointefIniPayId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'reference_number',
				'log_MID'    => '' 
		));	
		
		$customerId 		    = id_decrypt($customerId);
		$financePointefIniPayId = id_decrypt($financePointefIniPayId);
		
		if((!$customerId)||(!$financePointefIniPayId))
		{
			redirect(base_url().'superadmin/finance_pointe_force_management/processing_balance');
		}
		
		$this->data['result']     = $this->finance_pointe_force_lib->reference_number($customerId,$financePointefIniPayId);
		$this->data['customerId'] = $customerId;
		$this->superAdminCustomView('admin/finance_pointe_force_managements/reference_number',$this->data);
	}
	
	public function paid_balance()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'paid_balance',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_pointe_force_lib->paid_list();
		$this->superAdminCustomView('admin/finance_pointe_force_managements/balance_paid_list',$this->data);
	}
	
	public function balance_paid_view($customerId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_paid_view',
				'log_MID'    => '' 
		));	
		
		$customerId = id_decrypt($customerId);
		if(!$customerId)
		{
			redirect(base_url().'superadmin/finance_pointe_force_management/paid_balance');
		}
		
		$this->data['result']     = $this->finance_pointe_force_lib->balance_paid_view($customerId);
		$this->data['customerId'] = $customerId;
		$this->superAdminCustomView('admin/finance_pointe_force_managements/balance_paid_view',$this->data);
	}
}