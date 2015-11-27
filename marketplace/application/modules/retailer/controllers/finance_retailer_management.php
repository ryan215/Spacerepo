<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Finance_retailer_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Wallet';
		$this->load->model(array('finance_retailer_m','retailer_m'));
		$this->load->library('finance_retailer_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'finance_retailer_management',
				'log_MID'    => '' 
		));	
		
		$organizationId = $this->session->userdata('organizationId');
		if(!$organizationId)
		{
			redirect(base_url().'retailer/finance_retailer_management');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->retailer_available_balance_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->retailerCustomView('finance_retailer_managements/available_balance_view',$this->data);
	}
	
	public function ledger_balance_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ledger_balance_view',
				'log_MID'    => '' 
		));	
		
		$organizationId = $this->session->userdata('organizationId');
		if(!$organizationId)
		{
			redirect(base_url().'retailer/finance_retailer_management');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->retailer_ledger_balance_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->retailerCustomView('finance_retailer_managements/ledger_balance_view',$this->data);
	}
	
	public function balance_paid_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_paid_view',
				'log_MID'    => '' 
		));	
		
		$organizationId = $this->session->userdata('organizationId');
		if(!$organizationId)
		{
			redirect(base_url().'retailer/finance_retailer_management');
		}
		
		$this->data['result']     = $this->finance_retailer_lib->retailer_balance_paid_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->retailerCustomView('finance_retailer_managements/paid_balance_view',$this->data);
	}
}