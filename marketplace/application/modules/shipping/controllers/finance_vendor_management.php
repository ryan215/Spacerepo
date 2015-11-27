<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Finance_vendor_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Wallet';
		$this->load->model(array('finance_vendor_m'));
		$this->load->library('finance_vendor_lib');

	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'finance_vendor_management',
				'log_MID'    => '' 
		));	
		
		$organizationId				  = $this->session->userdata('organizationId');
		$this->data['result']     	  = $this->finance_vendor_lib->vendor_available_balance_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->shippingVendorCustomView('finance_vendor_managements/available_balance_view',$this->data);
	}
	
	public function processing_balance_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ledger_balance_view',
				'log_MID'    => '' 
		));	
		
		$organizationId				  = $this->session->userdata('organizationId');
		$this->data['result']     	  = $this->finance_vendor_lib->vendor_processing_balance_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->shippingVendorCustomView('finance_vendor_managements/processing_balance_view',$this->data);
	}
	
	public function balance_paid_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_paid_view',
				'log_MID'    => '' 
		));	
		
		$organizationId				  = $this->session->userdata('organizationId');
		$this->data['result']     	  = $this->finance_vendor_lib->vendor_paid_balance_view($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->shippingVendorCustomView('finance_vendor_managements/paid_balance_view',$this->data);
	}
}