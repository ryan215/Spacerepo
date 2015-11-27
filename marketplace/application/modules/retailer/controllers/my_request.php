<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class My_request extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'my_request_index',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'My Request';			
		$this->data['total'] = $this->product_m->total_my_request();
		$this->retailerCustomView('my_request/request_list',$this->data);
	}
	
	public function my_request_ajax($total=0)
	{	
		$search		      = $this->input->post('search');	
		$segment_id       = $this->input->post('segment_id');
    	$category_id      = $this->input->post('category_id');
    	$sub_category1_id = $this->input->post('sub_category1_id');
	    $sub_category2_id = $this->input->post('sub_category2_id');
    	$sub_category3_id = $this->input->post('sub_category3_id');
    	$sub_category4_id = $this->input->post('sub_category4_id');
    	$sub_category5_id = $this->input->post('sub_category5_id');
		$sub_category6_id = $this->input->post('sub_category6_id');
		$where = '';
		
		if(!empty($search))
		{
			$where.= " AND 
						(	
							product.product_name LIKE '%".$search."%'
						OR
							product_attribute.product_attribute_key LIKE '%".$search."%'
						)				 	
					 ";
		}
		
		if($segment_id){
			$where.= " AND product.segment_id = $segment_id";
		}		
		if($category_id){
			$where.= " AND product.category_id = $category_id";
		}
		if($sub_category1_id){
			$where.= " AND product.sub_category1_id = $sub_category1_id";
		}
		if($sub_category2_id){
			$where.= " AND product.sub_category2_id = $sub_category2_id";
		}
		if($sub_category3_id){
			$where.= " AND product.sub_category3_id = $sub_category3_id";
		}
		if($sub_category4_id){
			$where.= " AND product.sub_category4_id = $sub_category4_id";
		}
		if($sub_category5_id){
			$where.= " AND product.sub_category5_id = $sub_category5_id";
		}
		if($sub_category6_id){
			$where.= " AND product.sub_category6_id = $sub_category6_id";
		}
		
		if(!empty($where))
		{
			$total = $this->product_m->total_my_request($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'retailer/my_request/my_request_ajax/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data["links"]   = $this->ajax_pagination->create_links();
		$this->data['page']    = $page;
		$this->data['product'] = $this->product_m->my_request_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($this->data['product']); 
		$this->load->view('my_request/my_request_ajax',$this->data);
	}
	
	public function request_history()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'request_history',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'My Request History';			
		$this->data['total'] = $this->product_m->total_my_request_history(); 
		$this->retailerCustomView('my_request/history_list',$this->data);
	}
	
	public function my_history_ajax($total=0)
	{	
		$search		      = $this->input->post('search');	
		$segment_id       = $this->input->post('segment_id');
    	$category_id      = $this->input->post('category_id');
    	$sub_category1_id = $this->input->post('sub_category1_id');
	    $sub_category2_id = $this->input->post('sub_category2_id');
    	$sub_category3_id = $this->input->post('sub_category3_id');
    	$sub_category4_id = $this->input->post('sub_category4_id');
    	$sub_category5_id = $this->input->post('sub_category5_id');
		$sub_category6_id = $this->input->post('sub_category6_id');
		$where = '';
		
		if(!empty($search))
		{
			$where.= " AND 
						(	
							product.product_name LIKE '%".$search."%'
						OR
							product_attribute.product_attribute_key LIKE '%".$search."%'
						)				 	
					 ";
		}
		
		if($segment_id){
			$where.= " AND product.segment_id = $segment_id";
		}		
		if($category_id){
			$where.= " AND product.category_id = $category_id";
		}
		if($sub_category1_id){
			$where.= " AND product.sub_category1_id = $sub_category1_id";
		}
		if($sub_category2_id){
			$where.= " AND product.sub_category2_id = $sub_category2_id";
		}
		if($sub_category3_id){
			$where.= " AND product.sub_category3_id = $sub_category3_id";
		}
		if($sub_category4_id){
			$where.= " AND product.sub_category4_id = $sub_category4_id";
		}
		if($sub_category5_id){
			$where.= " AND product.sub_category5_id = $sub_category5_id";
		}
		if($sub_category6_id){
			$where.= " AND product.sub_category6_id = $sub_category6_id";
		}
		
		if(!empty($where))
		{
			$total = $this->product_m->total_my_request_history($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'retailer/my_request/my_history_ajax/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data["links"]   = $this->ajax_pagination->create_links();
		$this->data['page']    = $page;
		$this->data['product'] = $this->product_m->my_history_list($page,$pagConfig['per_page'],$where);
		$this->load->view('my_request/my_history_ajax',$this->data);
	}
	
	public function view($product_id='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product View';
		$user_id			  = $this->session->userdata('userId');
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->product_review($user_id,$product_id);
		$this->data['result']     = $result;
		$this->data['product_id'] = $product_id;
		$this->retailerCustomView('my_request/my_request_review',$this->data);
	}
	
	public function request_history_view($product_id='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'request_history_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product View';
		$user_id			  = $this->session->userdata('userId');
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->product_review($user_id,$product_id);
		$this->data['result']     = $result;
		$this->data['product_id'] = $product_id;
		$this->retailerCustomView('my_request/my_request_history_review',$this->data);
	}
	
}