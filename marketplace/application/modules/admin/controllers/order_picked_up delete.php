<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Order_picked_up extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Delivered Order';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'Delivered_order',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Delivered Order';	
		$this->data['result'] = $this->order_pickup_lib->delivered_order_index();
		$this->adminCustomView('shipping_management/pickup_orders_management/delivered_order_list',$this->data);
	}
	
	public function deliveredAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'deliveredAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_pickup_lib->delivered_order_ajax($total);
		$this->load->view('shipping_management/pickup_orders_management/delivered_order_ajax',$this->data);
	}
	
	public function delivered_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'delivered_order_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']   = 'Delivered Orders View';
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_pickup_lib->pickup_order_view($orderID,5);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->adminCustomView('shipping_management/pickup_orders_management/delivered_order_view',$this->data);
	}
}