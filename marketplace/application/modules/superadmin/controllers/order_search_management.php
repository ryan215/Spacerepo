<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Order_search_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		));
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'order_search_management',
				'log_MID'    => '' 
		) );
					
		$this->data['title'] = 'Orders Search Management';
		$this->superAdminCustomView('admin/order_search_managements/order_search_list',$this->data);
	}
	
	public function ajax_order_search_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajax_order_search_list',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->ajax_order_search_list();
		$this->load->view('admin/order_search_managements/ajax_order_search_list',$this->data);
	}	
	
	public function order_search_view($orderCustomPaymentId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'order_search_view',
				'log_MID'    => '' 
		));
		
		$this->data['title']   = 'Order Details View';		
		$orderCustomPaymentId  = id_decrypt($orderCustomPaymentId);
		$result				   = $this->order_lib->order_search_view($orderCustomPaymentId);
		
		$this->data['result']  				= $result;
		$this->data['orderCustomPaymentId'] = $orderCustomPaymentId;
		$this->superAdminCustomView('admin/order_search_managements/order_search_view',$this->data);
	}
}