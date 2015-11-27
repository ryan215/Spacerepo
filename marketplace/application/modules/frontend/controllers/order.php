<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Order extends MY_Controller {

	public function __construct() {
	
		parent::__construct(); 	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
		
		$this->load->library('order_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Order',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'Order List';
		
		$this->data['result']  = $this->order_lib->custom_order_list();
		$this->frontendCustomView('orders/order_list',$this->data);
	}
	
	public function past_order()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Order',
				'log_MID'    => '' 
		));
	
		$this->data['title'] = 'Past Order List';
		$this->frontendCustomView('orders/past_order_list',$this->data);
	}
	
	public function order_complete_success($orderTotalId=0)
	{
		$this->data['title']  = 'Order complete success';
		$orderTotalId	 	  = id_decrypt($orderTotalId);
		$this->data['result'] = $this->order_lib->order_complete_success($orderTotalId);
		$this->frontendCustomView('orders/order_complete_success',$this->data);
	}
	
	public function track_order($orderCustomPaymentId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Track Order',
				'log_MID'    => '' 
		));
		
		$orderCustomPaymentId = id_decrypt($orderCustomPaymentId);
		$this->data['title']  = 'Track Order';
		$this->data['result'] = $this->order_lib->track_orders_detail($orderCustomPaymentId);
		$this->frontendCustomView('orders/track_order',$this->data);
	}
}