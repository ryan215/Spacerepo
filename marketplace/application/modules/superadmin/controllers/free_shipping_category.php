<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Free_shipping_category extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Free Shipping';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'free_shipping_index',
				'log_MID'    => '' 
		) );
		
		$this->superAdminCustomView('free_shipping_category/free_shipping_category_list',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->category_lib->free_shipping_category_ajax_fun();
		$this->load->view('free_shipping_category/ajaxPagView',$this->data);		
	}
	
	public function add_free_shipping_cat()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_free_shipping_cat',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Add Free Shipping Category';
		$this->data['result'] = $this->category_lib->add_free_shipping_category();
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->superAdminCustomView('free_shipping_category/add_free_shipping_cat',$this->data);
	}
	
	public function free_shipping_category_details($freeShipCatId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'free_shipping_category_details',
				'log_MID'    => '' 
		) );
		
		$freeShipCatId = id_decrypt($freeShipCatId);
		$this->custom_log->write_log('custom_log','free shipping category id is '.$freeShipCatId);
		$this->data['result'] = $this->category_lib->free_shipping_category_details($freeShipCatId);
		$this->superAdminCustomView('free_shipping_category/free_shipping_category_details',$this->data);
	}
	
	public function delete_free_shipping_category($freeShipCatId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_free_shipping_category',
				'log_MID'    => '' 
		) );
		
		$freeShipCatId = id_decrypt($freeShipCatId);
		$this->custom_log->write_log('custom_log','free shipping category id is '.$freeShipCatId);
		
		if($freeShipCatId)
		{
			if($this->segment_cat_m->delete_free_shipping_category($freeShipCatId))
			{
				$this->session->set_flashdata('success','Free shipping category deleted successfully');
				$this->custom_log->write_log('custom_log','Free shipping category deleted successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Free shipping category not delete');
				$this->custom_log->write_log('custom_log','Free shipping category not delete');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Free shipping category not found');
			$this->custom_log->write_log('custom_log','Free shipping category not found');
		}
		redirect(base_url().$this->session->userdata('userType').'/free_shipping_category');
	}
}