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
		$this->adminCustomView('cse/product_managements/product_request_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->data['result'] = $this->product_lib->request_product_ajaxFun($total); 
		//echo $this->db->last_query(); exit;
		$this->load->view('cse/product_managements/ajaxView',$this->data);
	}
		
	public function view($productId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  	  = 'Product View';
		$user_id			  	  = $this->session->userdata('userId');
		$productId 		  	  	  = id_decrypt($productId);
		$result 			  	  = $this->product_lib->product_request_review($productId);	
		//$result 			  	  = $this->product_lib->admin_product_review($productId);
		$this->data['result']     = $result;
		$this->data['productId']  = $productId;	
		if($_POST)	
		{
			//echo "<pre>"; print_r($_POST); exit;
			$rules = product_declined_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$reason = $this->input->post('decline');
				if($this->product_m->product_decline_request($productId,$reason))
				{
					$this->session->set_flashdata('success','Product Request Declined successfully');
				}
				else
				{
					$this->session->set_flashdata('error','Product Request not decline');
				}
				redirect(base_url().$this->session->userdata('userType').'/product_request_management');
			}
		}
		$this->adminCustomView('cse/product_managements/product_view',$this->data);
	}
	
	public function accept_request($productId=0)
	{
		$productId = id_decrypt($productId);
		if($productId)
		{
			if($this->product_m->accept_request($productId))
			{
				$this->session->set_flashdata('success','Product Request accepted successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Product Request not accepte');
			}
		}
		redirect(base_url().$this->session->userdata('userType').'/product_management');
	}
	
	public function decline_request($productId=0)
	{
		$productId = id_decrypt($productId);
		if($productId)
		{
			if($this->product_m->decline_request($productId))
			{
				$this->session->set_flashdata('success','Product Request Declined successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Product Request not decline');
			}
		}
		redirect(base_url().$this->session->userdata('userType').'/product_management');
	}

}
