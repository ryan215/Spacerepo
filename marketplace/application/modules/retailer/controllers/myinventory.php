<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Myinventory extends MY_Controller {

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
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );
					
		$this->data['total'] = $this->product_m->total_product_with_inventory();
		$this->data['title'] = 'My Inventory';
		$this->retailerCustomView('myinventory/product_list',$this->data);
	}
	
	public function ajaxFun($total=0)
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
		
		if(!empty($search)){
			$where.= "product.product_name LIKE '%".$search."%' ";
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
			$total = $this->product_m->total_product_with_inventory();
		}
				
		$pagConfig = array(
		   				'base_url'    => base_url().'retailer/inventory/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data["links"]   = $this->ajax_pagination->create_links();
		$this->data['page']    = $page;
		$this->data['product'] = $this->product_m->product_with_inventory_list($page,$pagConfig['per_page'],$where);
		$this->load->view('myinventory/ajaxView',$this->data);
	}
	
	public function edit_inventory($product_id=''){
		
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_inventory',
				'log_MID'    => '' 
		) );
				
		$this->data['title'] = 'Edit Inventory';
		
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url());
		}
		
		$product_id = id_decrypt($product_id);
		$this->data['inventory_detail']=$invtryDetails = $this->product_m->inventry_details($product_id);
		$this->data['product_attribute']=$this->product_m->product_attribute($product_id);
		if($_POST)
		{
			
		
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = array(	
					 	
						array(
							'field' => 'inventory',
							'label' => 'Inventory',
							'rules' => 'trim|required|integer'
						),
						
					 );
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run())
			{
				$sale_price 	 = 0;
				$displayed_price = 0;
				
					$add_type=   $this->input->post('editinventory');
				$inventory   	 = $this->input->post('inventory');
				$commission      = 0;
				
				//$invtryDetails = $this->product_m->inventry_details($product_id);
				$this->custom_log->write_log('custom_log','Inventry details '.print_r($invtryDetails,true));
				if(!empty($invtryDetails))
				{
					$inventryID    = $invtryDetails->product_detail_id;
					if($add_type=='add'){
					$totalInventry = $invtryDetails->inventory+$inventory;
					
					}elseif($add_type=='sub'){
					
					$totalInventry = $invtryDetails->inventory-$inventory;
					if($totalInventry<0){
						
						$totalInventry=0;
						}
					}
					$this->product_m->update_retailer_product_detail($inventryID,$sale_price,$displayed_price,$totalInventry,$commission);					
				}
				else
				{
					$inventryID = $this->product_m->add_retailer_product_detail($product_id,$sale_price,$displayed_price,$inventory,$commission);
				}
				$this->custom_log->write_log('custom_log','inventry id is '.$inventryID);
				if($totalInventry>0){
				$historyID = $this->product_m->add_retailer_product_detail_history($product_id,$sale_price,$displayed_price,$inventory,$commission,$inventryID);
				$this->custom_log->write_log('custom_log','history id is '.$historyID);
				
				if($inventryID)
				{
					$this->session->set_flashdata('success',$this->lang->line('success_add_product_detail'));
					$this->custom_log->write_log('custom_log',$this->lang->line('success_add_product_detail'));
				}
				else
				{
					$this->session->set_flashdata('error',$this->lang->line('error_add_product_detail'));
					$this->custom_log->write_log('custom_log',$this->lang->line('error_add_product_detail'));											
				}
				}else{
					
					$this->session->set_flashdata('error','please check the inventory value it should not be negative. ');
					//$this->custom_log->write_log('custom_log',);
					
					}
				redirect(base_url().'retailer/myinventory');
			}
		}
		$this->data['productDetails'] = $this->product_m->product_details($product_id);
	$this->data['product_review']=$this->load->view('retailer/my_request/review',$this->data,true);
		$this->retailerCustomView('myinventory/edit_inventory',$this->data);
	
	
	
	
	}
	
	
	public function view($product_id='',$product_details_id='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product View';
		$user_id			  = $this->session->userdata('userId');
		$product_id 		  = id_decrypt($product_id);
		$product_details_id   = id_decrypt($product_details_id);
		$invtryDetails 		  = $this->product_m->retailer_inventry_details($product_details_id);
		//echo "<pre>"; print_r($invtryDetails); exit;
		if($_POST)
		{		
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = array(	
					 	array(
							'field' => 'inventory',
							'label' => 'Inventory',
							'rules' => 'trim|required|integer'
						),						
					 );
					 
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run())
			{
				$sale_price 	 = 0;
				$displayed_price = 0;
				$add_type		 = $this->input->post('editinventory');
				$inventory   	 = $this->input->post('inventory');
				$commission      = 0;
				$this->custom_log->write_log('custom_log','Inventry details '.print_r($invtryDetails,true));
				
				if(!empty($invtryDetails))
				{
					$inventryID = $invtryDetails->product_detail_id;
					if($add_type=='add')
					{
						$totalInventry = $invtryDetails->inventory+$inventory;
					}
					elseif($add_type=='sub')
					{
						$totalInventry = $invtryDetails->inventory-$inventory;						
					}
					
					if($totalInventry<0)
					{
						$this->session->set_flashdata('error','please check the inventory value it should not be negative');
					}
					else
					{
						if($this->product_m->update_retailer_product_detail($inventryID,$sale_price,$displayed_price,$totalInventry,$commission))
						{
							$historyID = $this->product_m->add_retailer_product_detail_history($product_id,$sale_price,$displayed_price,$inventory,$commission,$inventryID);
							$this->custom_log->write_log('custom_log','history id is '.$historyID);
						
							$this->session->set_flashdata('success',$this->lang->line('success_add_inventory'));
							$this->custom_log->write_log('custom_log',$this->lang->line('success_add_inventory'));
						}
						else
						{
							$this->session->set_flashdata('error',$this->lang->line('error_add_inventory'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_add_inventory'));
						}
					}
				}
				redirect(base_url().'retailer/myinventory/view/'.id_encrypt($product_id).'/'.id_encrypt($product_details_id));
			}
		}
		
		$result 			      = $this->product_lib->product_review($user_id,$product_id);
		$this->data['result']     = $result;
		$this->data['product_id'] = $product_id;
		$this->data['inventory_detail'] = $invtryDetails;
		$this->retailerCustomView('myinventory/edit_inventory_review',$this->data);
	}
	
}