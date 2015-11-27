<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Confirm_order extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Confirm Order';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirm_order',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Confirm Orders';			
		$this->data['result'] = $this->order_lib->confirmation_order_index();
		$this->retailerCustomView('admin/shipping_management/orders_management/confirm_order_list',$this->data);
	}
	
	public function confirmationOrderAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'confirmationOrderAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->confirmation_order_ajax($total);
		$this->load->view('admin/shipping_management/orders_management/confirmation_order_ajax',$this->data);	
	}
	
	public function confirm_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'new_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title']   = 'Confirmation Orders View';
		$orderID 			   = id_decrypt($orderID);
		$result = $this->order_lib->order_view($orderID,2);
	
		if(empty($result['productName']))
		{
			$result = $this->order_lib->order_view($orderID,3);
			if(empty($result['productName']))
			{
				$result = $this->order_lib->order_view($orderID,4);
			}
		}
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->retailerCustomView('admin/shipping_management/orders_management/confirm_order_view',$this->data);
	}
	
}