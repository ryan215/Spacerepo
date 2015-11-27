<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Shipping_bounce extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Shipping Bounce';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_bounce',
				'log_MID'    => '' 
		) );	
		
		$this->data['result'] = $this->order_lib->shipping_bounce_list();
		$this->adminCustomView('shipping_bounce/shipping_bounce_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_bounce_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->order_lib->shipping_bounce_list_ajaxFun($total);
		$this->load->view('shipping_bounce/ajaxPagView',$this->data);
	}
	
	public function delete_shipping_bounce($shippingBounceId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_shipping_bounce',
				'log_MID'    => '' 
		) );
		
		$shippingBounceId = id_decrypt($shippingBounceId);
		$this->custom_log->write_log('custom_log','shipping bounce id is '.$shippingBounceId);
		
		if($shippingBounceId)
		{
			if($this->shipping_m->delete_shipping_bounce($shippingBounceId))
			{
				$this->session->set_flashdata('success','shipping bounce deleted successfully');
				$this->custom_log->write_log('custom_log','shipping bounce deleted successfully');	
			}
			else
			{
				$this->session->set_flashdata('success','shipping bounce not delete');
				$this->custom_log->write_log('custom_log','shipping bounce not delete');
			}
		}
		redirect(base_url().'admin/shipping_bounce');
	}
}