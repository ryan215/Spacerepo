<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Product_request_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );

		$this->data['title'] = 'Request Product Managements';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_request_management',
				'log_MID'    => '' 
		) );				
		
		$this->data['result'] = $this->product_lib->request_product_list(); 
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->cseCustomView('product_managements/product_request_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->data['result'] = $this->product_lib->request_product_ajaxFun($total); 
		$this->load->view('product_managements/ajaxView',$this->data);
	}
		
	public function view($productId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product View';
		$user_id			  = $this->session->userdata('userId');
		$productId 		  	  = id_decrypt($productId);
		$result 			  = $this->product_lib->product_request_review($productId);
		$this->data['result'] = $result;
		$this->data['productId']  = $productId;	
		//echo "<pre>"; print_r($result); exit;
		$this->cseCustomView('product_managements/product_view',$this->data);
	}
	
	public function delete_request($productId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$productId = id_decrypt($productId);
		if($productId)
		{
			if($this->product_m->delete_request($productId))
			{
				$this->session->set_flashdata('success','Product Request Deleted successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Product Request not Delete');
			}
		}
		redirect(base_url().$this->session->userdata('userType').'/product_request_management');
	}
}
