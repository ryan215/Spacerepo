<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class History_order_pickup extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'History Order';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'History_order',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'History Order';	
		$this->data['result'] = $this->order_pickup_lib->history_order_index();
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/history_order_list',$this->data);
	}
	
	public function historyAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'historyAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_pickup_lib->history_order_ajax($total);
		$this->load->view('admin/shipping_management/pickup_orders_management/history_order_ajax',$this->data);
	}
	
	public function history_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'history_order_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']   = 'History Orders View';
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_pickup_lib->pickup_order_view($orderID,6);
		
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/history_order_view',$this->data);
	}
}