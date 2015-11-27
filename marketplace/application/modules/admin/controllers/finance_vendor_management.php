<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Finance_vendor_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Finance Vendor Managment';
		$this->load->model(array('finance_pointe_porce_m','finance_vendor_m','pointe_force_m','finance_retailer_m','retailer_m'));
		$this->load->library('finance_vendor_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'finance_vendor_management',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_vendor_lib->available_list();		
		$this->adminCustomView('finance_vendor_managements/balance_available_list',$this->data);
	}
	
	public function balance_available_view($shippingOrgId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_available_view',
				'log_MID'    => '' 
		));	
		
		$shippingOrgId = id_decrypt($shippingOrgId);
		if(!$shippingOrgId)
		{
			redirect(base_url().'admin/finance_vendor_management');
		}
		
		$this->data['result']     = $this->finance_vendor_lib->vendor_user_details($shippingOrgId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->adminCustomView('finance_vendor_managements/balance_available_view',$this->data);
	}
	
	public function initiate_payment($shippingOrgId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'initiate_payment',
				'log_MID'    => '' 
		));	
		
		$shippingOrgId = id_decrypt($shippingOrgId);
		if(!$shippingOrgId)
		{
			redirect(base_url().'admin/finance_vendor_management');
		}
		
		$this->data['result']     = $this->finance_vendor_lib->initiate_payment($shippingOrgId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->adminCustomView('finance_vendor_managements/initiate_payment',$this->data);
	}
	
	public function processing_balance()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'processing_balance',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_vendor_lib->processing_list();
		$this->adminCustomView('finance_vendor_managements/balance_processing_list',$this->data);
	}
	
	public function balance_processing_view($shippingOrgId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_processing_view',
				'log_MID'    => '' 
		));	
		
		$shippingOrgId = id_decrypt($shippingOrgId);
		if(!$shippingOrgId)
		{
			redirect(base_url().'admin/finance_vendor_management/processing_balance');
		}
		
		$this->data['result']     = $this->finance_vendor_lib->balance_processing_view($shippingOrgId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->adminCustomView('finance_vendor_managements/balance_processing_view',$this->data);
	}
	
	public function reference_number($shippingOrgId=0,$financeVendorIniPayId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'reference_number',
				'log_MID'    => '' 
		));	
		
		$shippingOrgId 		   = id_decrypt($shippingOrgId);
		$financeVendorIniPayId = id_decrypt($financeVendorIniPayId);
		
		if((!$shippingOrgId)||(!$financeVendorIniPayId))
		{
			redirect(base_url().'admin/finance_vendor_management/processing_balance');
		}
		
		$this->data['result']     = $this->finance_vendor_lib->reference_number($shippingOrgId,$financeVendorIniPayId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->adminCustomView('finance_vendor_managements/reference_number',$this->data);
	}
	
	public function paid_balance()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'paid_balance',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->finance_vendor_lib->paid_list();
		$this->adminCustomView('finance_vendor_managements/balance_paid_list',$this->data);
	}
	
	public function balance_paid_view($shippingOrgId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'balance_paid_view',
				'log_MID'    => '' 
		));	
		
		$shippingOrgId = id_decrypt($shippingOrgId);
		if(!$shippingOrgId)
		{
			redirect(base_url().'admin/finance_vendor_management/paid_balance');
		}
		
		$this->data['result']     = $this->finance_vendor_lib->balance_paid_view($shippingOrgId);
		$this->data['shippingOrgId'] = $shippingOrgId;
		$this->adminCustomView('finance_vendor_managements/balance_paid_view',$this->data);
	}
}