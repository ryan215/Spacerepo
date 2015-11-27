<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Orders_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		));
		$this->load->model('customer_m');
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'order_management',
				'log_MID'    => '' 
		) );
					
		$this->data['title'] = 'Orders Management';
		$this->superAdminCustomView('admin/orders_managements/orders_list',$this->data);
	}
	
	public function orders_ajax_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'orders_ajax_list',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->orders_ajax_list();
		$this->load->view('admin/orders_managements/orders_ajax_list',$this->data);
	}	
	
	public function single_shippment_order_view($orderCustomPaymentId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'single_shippment_order_view',
				'log_MID'    => '' 
		));
		
		$this->data['title']   = 'Order Details View';		
		$orderCustomPaymentId  = id_decrypt($orderCustomPaymentId);
		$result				   = $this->order_lib->single_shippment_order_view($orderCustomPaymentId);
		
		$this->data['result']  				= $result;
		$this->data['orderCustomPaymentId'] = $orderCustomPaymentId;
		$this->superAdminCustomView('admin/orders_managements/single_shippment_order_view',$this->data);
	}
	
	public function single_shippment_cancel_order($orderCustomPaymentId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'single_shippment_cancel_order',
				'log_MID'    => '' 
		));		
		
		$orderCustomPaymentId  = id_decrypt($orderCustomPaymentId);		
		$this->custom_log->write_log('custom_log','Order Id is '.$orderCustomPaymentId);
		if($orderCustomPaymentId)
		{
			$this->order_lib->single_shippment_cancel_order($orderCustomPaymentId);
		}
	}
	
	//	order change from confirm to ready order 2 => 3
	public function single_shippment_change_confirm_to_ready_order($orderCustomPaymentId=0)
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'single_shippment_change_confirm_to_ready_order',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Order id is '.$orderCustomPaymentId);
		$orderCustomPaymentId = id_decrypt($orderCustomPaymentId);
		if($orderCustomPaymentId)
		{
			$this->order_lib->single_shippment_change_confirm_to_ready_order($orderCustomPaymentId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');		
	}
	
	//	order change from ready to shipped order 3 => 4
	public function single_shippment_change_ready_to_shipped_order($orderCustomPaymentId=0)
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'single_shippment_change_ready_to_shipped_order',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Order id is '.$orderCustomPaymentId);
		$orderCustomPaymentId = id_decrypt($orderCustomPaymentId);
		if($orderCustomPaymentId)
		{
			$this->order_lib->single_shippment_change_ready_to_shipped_order($orderCustomPaymentId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');		
	}
	
	//	order change from shipped to delivered order 4 => 5
	public function single_shippment_change_shipped_to_delivered_order($orderCustomPaymentId=0)
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'single_shippment_change_shipped_to_delivered_order',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Order id is '.$orderCustomPaymentId);
		$orderCustomPaymentId = id_decrypt($orderCustomPaymentId);
		if($orderCustomPaymentId)
		{
			$this->order_lib->single_shippment_change_shipped_to_delivered_order($orderCustomPaymentId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');		
	}
	
	public function quick_shippment_order_view($orderDetailId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_order_view',
				'log_MID'    => '' 
		));
		
		$this->data['title']   = 'Order Details View';		
		$orderDetailId  = id_decrypt($orderDetailId);
		$result				   = $this->order_lib->quick_shippment_order_view($orderDetailId);
		
		$this->data['result']  				= $result;
		$this->data['orderDetailId'] = $orderDetailId;
		$this->superAdminCustomView('admin/orders_managements/quick_shippment_order_view',$this->data);
	}
	
	public function quick_shippment_cancel_order($orderDetailId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_cancel_order',
				'log_MID'    => '' 
		));		
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order details Id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->quick_shippment_cancel_order($orderDetailId);
		}
	}
	
	//	order change from confirm to ready order 2 => 3
	public function quick_shippment_change_confirm_to_ready_order($orderDetailId='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_change_confirm_to_ready_order',
				'log_MID'    => '' 
		) );
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->quick_shippment_change_confirm_to_ready_order($orderDetailId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');		
	}
	
	//	order change from ready to shipped order 3 => 4
	public function quick_shippment_change_ready_to_shipped_order($orderDetailId='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_change_ready_to_shipped_order',
				'log_MID'    => '' 
		) );
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->quick_shippment_change_ready_to_shipped_order($orderDetailId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');
	}
	
	//	order change from shipped to delivered 4 => 5
	public function quick_shippment_change_shipped_to_delivered_order($orderDetailId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_change_shipped_to_delivered_order',
				'log_MID'    => '' 
		) );
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->quick_shippment_change_shipped_to_delivered_order($orderDetailId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');
	}
	
	public function quick_shippment_print_invoice()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_print_invoice',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderDetailId = id_decrypt($this->input->post('orderDetailId'));
		$result	 = $this->order_lib->quick_shippment_print_invoice($orderDetailId);
		$this->data['result'] = $result;
		echo $this->load->view('admin/orders_managements/quick_shippment_print_invoice',$this->data,true);
	}
	
	public function quick_shippment_print_label()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'quick_shippment_print_label',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderDetailId = id_decrypt($this->input->post('orderDetailId'));
		$result	 = $this->order_lib->quick_shippment_print_invoice($orderDetailId);
		$this->data['result'] = $result;
		echo $this->load->view('admin/orders_managements/quick_shippment_print_label',$this->data,true);
	}
	
	public function pickup_order_view($orderDetailId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pickup_order_view',
				'log_MID'    => '' 
		));
		
		$this->data['title']   = 'Order Details View';		
		$orderDetailId  	   = id_decrypt($orderDetailId);
		$result				   = $this->order_lib->pickup_order_view($orderDetailId);
		
		$this->data['result']  		 = $result;
		$this->data['orderDetailId'] = $orderDetailId;
		$this->superAdminCustomView('admin/orders_managements/pickup_order_view',$this->data);
	}
	
	public function pickup_cancel_order($orderDetailId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pickup_cancel_order',
				'log_MID'    => '' 
		));		
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order details Id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->pickup_cancel_order($orderDetailId);
		}
	}
	
	// pick	order change from confirm to ready pickup 2 => 3
	public function change_confirm_pickup_order_to_ready_pickup_order($orderDetailId='')
	{			
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_confirm_pickup_order_to_ready_pickup_order',
				'log_MID'    => '' 
		) );
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->pickup_change_confirm_to_ready_order($orderDetailId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');		
	}
	
	// pick	order change from ready pickup to order pickuped 3 => 5
	public function change_ready_pickup_to_order_pickup($orderDetailId='')
	{		
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_ready_pickup_to_order_pickup',
				'log_MID'    => '' 
		) );
		
		$orderDetailId = id_decrypt($orderDetailId);
		$this->custom_log->write_log('custom_log','Order id is '.$orderDetailId);
		if($orderDetailId)
		{
			$this->order_lib->pickup_change_ready_pickup_to_pickup_customer($orderDetailId);
		}	
		redirect(base_url().$this->session->userdata('userType').'/orders_management');		
	}
	
	//	print page for pickup
	public function pickup_print_lable()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pickup_print_lable',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderDetailId = id_decrypt($this->input->post('orderDetailId'));
		$result	 = $this->order_lib->pickup_print_lable($orderDetailId);
		$this->data['result'] = $result;
		echo $this->load->view('admin/orders_managements/pickup_print_lable',$this->data,true);
	}
	
	//	print invoice for pickup
	public function pickup_print_invoice()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'pickup_print_invoice',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderDetailId = id_decrypt($this->input->post('orderDetailId'));
		$result	 = $this->order_lib->pickup_print_invoice($orderDetailId);
		$this->data['result'] = $result;
		echo $this->load->view('admin/orders_managements/pickup_print_invoice',$this->data,true);
	}
	
	//	auto genrate traking number
	public function auto_genrate()
	{
		echo 'PM'.rand(10000000000000,99999999999999);
	}
	
}