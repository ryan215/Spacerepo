<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Finance_retailer_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Finance Retailer Managment';
		$this->load->model(array('finance_pointe_porce_m','finance_vendor_m','pointe_force_m','finance_retailer_m','retailer_m'));
		$this->load->library('finance_retailer_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'finance_retailer_management',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_retailer_lib->available_list();		
		$this->adminCustomView('finance_retailer_managements/balance_available_list',$this->data);
	}
	
	public function balance_available_view($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_available_view',
				'log_MID'    => '' 
		));	
		
		$organizationId = id_decrypt($organizationId);
		if(!$organizationId)
		{
			redirect(base_url().'admin/finance_retailer_management');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->balance_available_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('finance_retailer_managements/balance_available_view',$this->data);
	}
	
	public function balance_available_ledger_view($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_available_ledger_view',
				'log_MID'    => '' 
		));	
		
		$organizationId = id_decrypt($organizationId);
		if(!$organizationId)
		{
			redirect(base_url().'superadmin/finance_retailer_management');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->balance_available_ledger_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('finance_retailer_managements/balance_available_ledger_view',$this->data);
	}
	
	public function initiate_payment($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'initiate_payment',
				'log_MID'    => '' 
		));	
		
		$organizationId = id_decrypt($organizationId);
		if(!$organizationId)
		{
			redirect(base_url().'admin/finance_retailer_management');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->initiate_payment($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('finance_retailer_managements/initiate_payment',$this->data);
	}
	
	public function processing_balance()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'processing_balance',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_retailer_lib->processing_list();
		$this->adminCustomView('finance_retailer_managements/balance_processing_list',$this->data);
	}
	
	public function balance_processing_view($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_processing_view',
				'log_MID'    => '' 
		));	
		
		$organizationId = id_decrypt($organizationId);
		if(!$organizationId)
		{
			redirect(base_url().'admin/finance_retailer_management/processing_balance');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->balance_processing_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('finance_retailer_managements/balance_processing_view',$this->data);
	}
	
	public function reference_number($organizationId=0,$financeRetailerIniPayId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'reference_number',
				'log_MID'    => '' 
		));	
		
		$organizationId 		    = id_decrypt($organizationId);
		$financeRetailerIniPayId = id_decrypt($financeRetailerIniPayId);
		
		if((!$organizationId)||(!$financeRetailerIniPayId))
		{
			redirect(base_url().'admin/finance_retailer_management/processing_balance');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->reference_number($organizationId,$financeRetailerIniPayId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('finance_retailer_managements/reference_number',$this->data);
	}
	
	public function paid_balance()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'paid_balance',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_retailer_lib->paid_list();
		$this->adminCustomView('finance_retailer_managements/balance_paid_list',$this->data);
	}
	
	public function balance_paid_view($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_paid_view',
				'log_MID'    => '' 
		));	
		
		$organizationId = id_decrypt($organizationId);
		if(!$organizationId)
		{
			redirect(base_url().'admin/finance_retailer_management/paid_balance');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->balance_paid_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('finance_retailer_managements/balance_paid_view',$this->data);
	}
}