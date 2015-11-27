<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Rate_list extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'rate_list';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'rate_list',
				'log_MID'    => '' 
		) );
		$organizationId 	 = $this->session->userdata('organizationId');
		$this->data['title'] = 'Rate List';	
		$this->shippingVendorCustomView('rate_list/rate_list',$this->data);
	}	
	
	public function shippingRatesAjaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shippingRatesAjaxFun',
				'log_MID'    => '' 
		) );
		//echo "ramesh"; exit;
		$shippingOrgId  = $this->session->userdata('organizationId');
		$result         = array();
		$perPage        = 10;
		$where          = '';
		$total          = $this->user_m->total_shipping_rates($shippingOrgId,$where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().'shipping/rate_list/shippingRatesAjaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$result['list']  = $this->user_m->shipping_rates_list($shippingOrgId,$page,$pagConfig['per_page'],$where);
		$result['links'] = $this->ajax_pagination->create_links();
		$result['page']  = $page;
		$this->data['result'] = $result;
		$this->load->view('rate_list/shipping_rates_list_ajax',$this->data);	
	}
	
}