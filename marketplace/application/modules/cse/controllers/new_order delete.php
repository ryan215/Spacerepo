<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class New_order extends MY_Controller {

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
		$this->data['result'] = $this->order_lib->new_order_index();
		$this->cseCustomView('admin/shipping_management/orders_management/new_order_before_accept',$this->data);
	}
	
	public function new_order_ajax($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'new_order_ajax',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->new_order_ajax($total);
		$this->load->view('admin/shipping_management/orders_management/new_order_list_ajax',$this->data);
	}	
	
	public function new_order_view($orderID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'new_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'New Order Details View';
		
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->order_view($orderID,1);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->cseCustomView('admin/shipping_management/orders_management/new_order_view',$this->data);
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
			$this->order_lib->cancel_order($orderID);
		}
	}
}