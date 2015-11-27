<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Retailer_product_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );

		$this->data['title'] = 'Product Managements';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );				

		$this->data['result'] 		  = $this->product_lib->spacepointe_product_list(); 
		$this->data['organizationId'] = $this->session->userdata('organizationId');
	//echo "<pre>";	print_r($this->data['result']); exit;
		$this->retailerCustomView('product_managements/retailer_product_list',$this->data);
	}
	
	public function main_product_list()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_list',
				'log_MID'    => '' 
		) );				

		$this->data['result'] = $this->product_lib->product_list(); 
		$this->data['organizationId'] = $this->session->userdata('organizationId');
		$this->retailerCustomView('product_managements/main_product_list',$this->data);
	}
	
	public function mainProductAjaxFun($total=0)
	{	
		$organizationId = $this->input->post('organizationId');
		$this->data['result'] = $this->product_lib->main_product_ajaxFun($total); 
		$this->data['organizationId'] = $organizationId;
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->load->view('product_managements/mainProductAjaxFun',$this->data);
	}
	
	public function addRetailerProduct($productId=0)
	{	
		$productId       	  = id_decrypt($productId);
		$this->data['result'] = $this->product_lib->addRetailerProduct($productId);
		
		$this->data['productId'] = $productId;
		$this->retailerCustomView('product_managements/addRetailerProduct',$this->data);
	}	
	
	public function check_sell_price_with_cost_price()
	{
		$sellPrice = $this->input->post('sellPrice');
		$costPrice = $this->input->post('costPrice');
		if($sellPrice<$costPrice)
		{
			$this->form_validation->set_message('check_sell_price_with_cost_price','The %s field always greate then cost price');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
