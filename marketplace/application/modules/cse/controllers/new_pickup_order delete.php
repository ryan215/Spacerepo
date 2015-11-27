<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class New_pickup_order extends MY_Controller {

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
				'log_MODULE' => 'new_order',
				'log_MID'    => '' 
		) );
					
		$this->data['title'] = 'New Order';
		$this->data['result'] = $this->order_pickup_lib->new_order_index();
	//echo "<pre>";	print_r($this->data['total']); exit;
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/new_order_before_accept',$this->data);
	}
	
	public function new_order_ajax($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'new_order_ajax',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_pickup_lib->new_order_ajax($total);
		
		$this->load->view('admin/shipping_management/pickup_orders_management/new_order_list_ajax',$this->data);
	}	
	
	public function new_order_view($orderID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'new_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'New Orders View';
		
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_pickup_lib->pickup_order_view($orderID,7);
		$this->data['result']  =  $result;
		///print_r($this->data['result']);
		$this->data['orderID'] = $orderID;
		$this->cseCustomView('admin/shipping_management/pickup_orders_management/new_order_view',$this->data);
	}
	
	public function change_false($orderID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_false',
				'log_MID'    => '' 
		) );		
		$orderID = id_decrypt($orderID);
		$this->custom_log->write_log('custom_log','Order Id is '.$orderID);
		
		if($orderID)
		{
			$this->order_pickup_lib->cancel_order($orderID);
		}
	}
}