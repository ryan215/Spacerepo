<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Check_stock_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );

		$this->data['title'] = 'Check Stock Managements';
	}	
	
	public function check_stock_list($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stock_list',
				'log_MID'    => '' 
		));
			
		$organizationId = id_decrypt($organizationId);
		$this->custom_log->write_log('custom_log','Organziation id is '.$organizationId);
		
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('check_stock_managements/check_stock_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );

		$this->data['result'] = $this->product_lib->check_stock_list_ajax();
		$this->load->view('retailer/check_stock_managements/check_stock_list_ajax',$this->data);
	}
	
	public function add_check_stock_list($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_check_stock_list',
				'log_MID'    => '' 
		) );				
		
		$this->data['organizationId'] = id_decrypt($organizationId);
		$this->adminCustomView('check_stock_managements/add_check_stock_list',$this->data);
	}
	
	public function add_check_stock_list_ajax()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_check_stock_list_ajax',
				'log_MID'    => '' 
		) );				
		
		$organizationId 			  = $this->input->post('organizationId');
		$this->data['result'] 		  = $this->product_lib->add_check_stock_list_ajax(); 
		$this->data['organizationId'] = $organizationId;
		$this->load->view('retailer/check_stock_managements/add_check_stock_list_ajax',$this->data);
	}
	
	public function product_view($product_id='',$organizationId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  		  = 'Product View';
		$user_id			  		  = $this->session->userdata('userId');
		$product_id 		  		  = id_decrypt($product_id);
		$result 			          = $this->product_lib->admin_product_review($product_id);
		$this->data['result']         = $result;
		$this->data['product_id']     = $product_id;
		$this->data['organizationId'] = id_decrypt($organizationId);
		$this->adminCustomView('check_stock_managements/product_view',$this->data);
	}
	
	public function inventory_details($organizationProductId=0,$organizationId=0)
	{
		$organizationProductId = id_decrypt($organizationProductId);
		$organizationId        = id_decrypt($organizationId);
		$this->data['result']  = $this->product_lib->check_stock_inventory_details($organizationProductId,$organizationId);
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->data['organizationProductId'] = $organizationProductId;
		$this->data['organizationId']        = $organizationId;
		$this->adminCustomView('check_stock_managements/inventory_details',$this->data);
	}
	
	public function add_inventory($organizationId=0,$productId=0)
	{
		$organizationId        		  = id_decrypt($organizationId);
		$productId       	          = id_decrypt($productId);
		$this->data['result']         = $this->product_lib->add_check_stock_inventory($organizationId,$productId);
		$this->data['organizationId'] = $organizationId;
		$this->data['productId']      = $productId;
		$this->adminCustomView('check_stock_managements/add_inventory',$this->data);
	}
}