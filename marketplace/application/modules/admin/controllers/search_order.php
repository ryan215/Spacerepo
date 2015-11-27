<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Search_order extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'search_order',
				'log_MID'    => '' 
		) );
					
		$this->data['title']  = 'Search Order';
		$this->data['result'] = $this->order_lib->search_order_index();
		$this->adminCustomView('admin/shipping_management/orders_management/search_order_list',$this->data);
	}
	
	public function search_order_ajax($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'new_order_ajax',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->search_order_ajax($total);
		$this->load->view('admin/shipping_management/orders_management/search_order_ajax',$this->data);
	}	
	
	public function search_order_view($orderID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'search_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'Search Orders View';
		
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->search_order_view($orderID);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->adminCustomView('admin/shipping_management/orders_management/search_order_view',$this->data);
	}
}