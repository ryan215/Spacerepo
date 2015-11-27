<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Shipped_in_transit extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Shipped In Transit';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'Shipped_in_transit',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Shipped In Transit';	
		$this->data['result'] = $this->order_lib->shipped_in_transit_order_index();
		$this->shippingVendorCustomView('admin/shipping_management/orders_management/shipped_in_transit_order_list',$this->data);
	}
	
	public function transitAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'transitAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->shipped_in_transit_order_ajax($total);
		$this->load->view('admin/shipping_management/orders_management/shipped_in_transit_order_ajax',$this->data);
	}
	
	public function shipped_in_transit_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipped_in_transit_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title']   = 'Shipped/In Transit Orders View';
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->order_view($orderID,4);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->shippingVendorCustomView('admin/shipping_management/orders_management/shipped_in_transit_order_view',$this->data);
	}
	
	public function change_status($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_status',
				'log_MID'    => '' 
		) );
		$this->load->model('customer_m');
		$orderID = id_decrypt($orderID);
		
		if($this->order_m->change_transit_to_delivered($orderID))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_transit_to_delivered'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_transit_to_delivered'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_transit_to_delivered'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_transit_to_delivered'));
					}	
				redirect(base_url().$this->session->userdata('userType').'/delivered_order');	
	}
	public function change_status_bulk()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_status_bulk',
				'log_MID'    => '' 
		) );
		
	}
	
	public function save_delivered_date()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'save_delivered_date',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$order_id       = id_decrypt($this->input->post('order_id'));
		$delivered_date = $this->input->post('delivered_date');
		
		if($order_id)
		{
			if($this->order_m->save_delivered_date($order_id,$delivered_date))
			{
				$this->session->set_flashdata('success',$this->lang->line('success_save_delivered_date'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_save_delivered_date'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_save_delivered_date'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_save_delivered_date'));
			}	
		}
	}
	
}