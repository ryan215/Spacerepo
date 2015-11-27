<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Ready_to_shipped extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Current Order';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'Ready_to_shipped',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->ready_to_shipped_order_index();	
		$this->shippingVendorCustomView('admin/shipping_management/orders_management/ready_to_be_shipped_order_list',$this->data);
	}
	
	public function readyShippedAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'readyShippedAjaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->ready_to_shipped_order_ajax($total);
		$this->load->view('admin/shipping_management/orders_management/ready_shipped_order_ajax',$this->data);
	}
	
	public function ready_to_shipped_order_view($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'ready_to_shipped_order_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'Ready To Be Shipped Orders View';
		
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->order_view($orderID,3);
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
			$result['trackingNbr'] = $this->input->post('track_number');
			$rules = add_tracking_number_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');			
			if($this->form_validation->run())
	    	{
				if($this->order_m->save_tracking_number($orderID,$result['trackingNbr']))
				{
					$this->session->set_flashdata('success',$this->lang->line('success_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_save_track_no'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_save_track_no'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_save_track_no'));
				}
				redirect(base_url().$this->session->userdata('userType').'/ready_to_shipped/ready_to_shipped_order_view/'.id_encrypt($orderID));	
			}
		}
		
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->shippingVendorCustomView('admin/shipping_management/orders_management/ready_to_shipped_order_view',$this->data);
	}
	
	
	
	public function change_status($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_status',
				'log_MID'    => '' 
		) );
		$orderID = id_decrypt($orderID);
		if($this->order_m->change_ready_to_transit($orderID))
		{
			$this->session->set_flashdata('success',$this->lang->line('success_ready_to_shipped_to_transit'));
			$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('success_ready_to_shipped_to_transit'));
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_ready_to_shipped_to_transit'));
			$this->custom_log->write_log('custom_log','Message is '.$this->lang->line('error_ready_to_shipped_to_transit'));
		}
		redirect(base_url().$this->session->userdata('userType').'/shipped_in_transit');				
	}
	
	public function save_track_no()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'save_track_no',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$order_id = id_decrypt($this->input->post('order_id'));
		$track_no = $this->input->post('track_no');
		
		if($order_id)
		{
			if($this->order_m->save_tracking_number($order_id,$track_no))
			{
				$this->session->set_flashdata('success',$this->lang->line('success_save_track_no'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_save_track_no'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_save_track_no'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_save_track_no'));
			}	
		}
	}
	
	public function print_page()
	{
		
		$this->session->set_userdata(array(
				'log_MODULE' => 'print_page',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','Post data is '.print_r($_POST,true));
		
		$orderID = id_decrypt($this->input->post('order_id'));
		$result	 = $this->order_lib->order_view($orderID,3);
		$this->data['result'] = $result;
		echo $this->load->view('admin/shipping_management/orders_management/print_page',$this->data,true);
	}
	
	public function test($ordeID)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'print_page',
				'log_MID'    => '' 
		) );
		
		
		
		$orderID = id_decrypt($ordeID);
		$result	 = $this->order_lib->order_view($orderID,2);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		echo $this->load->view('shipping_management/orders_management/print_page',$this->data,true);
	}
	
	public function auto_genrate()
	{
		echo 'PM'.rand(10000000000000,99999999999999);
	}
}