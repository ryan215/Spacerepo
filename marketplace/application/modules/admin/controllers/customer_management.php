<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Customer_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct (); 	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Customer Management';	
		$this->load->library('customer_lib');
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'customer_management',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Customer Management';
		$this->adminCustomView('superadmin/customer_managements/customer_list',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'customer_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->customer_lib->customer_ajax();
		$this->load->view('superadmin/customer_managements/ajaxPagView',$this->data);
	}
	
	public function user_detail($customerId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	
		
		$customerId = id_decrypt($customerId);			
		$this->custom_log->write_log('custom_log','customer user id is '.$customerId);
		
		$this->data['result']     = $this->customer_lib->customer_details($customerId);
		$this->data['customerId'] = $customerId;
		$this->adminCustomView('superadmin/customer_managements/user_details',$this->data);	
	}
	
	public function unblock_block($customerId,$status)
	{
		$customerId = id_decrypt($customerId);
		if($customerId)
		{
			$this->customer_lib->customer_unblock_block($customerId,$status);
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_invalie_id'));
		}		
		redirect(base_url().$this->session->userdata('userType').'/customer_management/user_detail/'.id_encrypt($customerId));		
	}
	
	public function in_black_list($customerId,$status)
	{
		$customerId = id_decrypt($customerId);
		if($customerId)
		{
			$this->customer_lib->customer_in_black_list($customerId,$status);
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_invalie_id'));
		}		
		redirect(base_url().$this->session->userdata('userType').'/customer_management/user_detail/'.id_encrypt($customerId));		
	}
	
	public function order_list($customerId)
	{
		$customerId = id_decrypt($customerId);
		$this->custom_log->write_log('custom_log','customer user id is '.$customerId);
		$this->data['customerId'] = $customerId;
		$this->adminCustomView('superadmin/customer_managements/order_list',$this->data);
	}
	
	public function orderAjaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'customer_orderAjaxFun',
				'log_MID'    => '' 
		) );
		
		$customerId = $this->input->post('customerId');
		if($customerId)
		{
			$this->data['result'] = $this->order_lib->customer_order_ajax($customerId);
		}
		$this->data['customerId'] = $customerId;
		$this->load->view('superadmin/customer_managements/orderAjaxPagView',$this->data);
	}
	
	public function order_details($customerId='',$orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'order_details',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Orders View';
		$orderID 			 = id_decrypt($orderID);
		$customerId 		 = id_decrypt($customerId);
		$this->custom_log->write_log('custom_log','order id is '.$orderID.' and customer id is '.$customerId);
		
		$result				      = $this->order_lib->customer_order_view($orderID);
		$this->data['result']     = $result;
		$this->data['orderID']    = $orderID;
		$this->data['customerId'] = $customerId;
		$this->adminCustomView('superadmin/customer_managements/order_details',$this->data);
	}
}