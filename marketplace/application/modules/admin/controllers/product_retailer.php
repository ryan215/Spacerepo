<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Product_retailer extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Product Retailer';
		$this->load->library('product_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_retailer_index',
				'log_MID'    => '' 
		) );
					
		$this->data['total'] = $this->product_m->total_retailer_product();
		$this->adminCustomView('product_managements/product_retailer_list',$this->data);
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
		$where 			  = ' WHERE product.is_admin = 0 
							  AND 	product.status = "Request"
							';
		
		if(!empty($search)){
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
			$total = $this->product_m->total_product_where($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'admin/product_retailer/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data["links"]   = $this->ajax_pagination->create_links();
		$this->data['page']    = $page;
		$this->data['product'] = $this->product_m->product_list($page,$pagConfig['per_page'],$where);
		$this->load->view('product_managements/retailerAjaxView',$this->data);
	}
			
	public function product_history()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_history',
				'log_MID'    => '' 
		) );
					
		$this->data['total'] = $this->product_m->total_retailer_product_history();
		$this->adminCustomView('product_managements/product_retailer_history_list',$this->data);
	}
	
	public function product_history_ajax($total=0)
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
		$where 			  = ' WHERE product.is_admin = 0 
							  AND 	product.status != "Request"
							';
		
		if(!empty($search)){
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
			$total = $this->product_m->total_product_where($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'admin/product_retailer/product_history_ajax/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$this->data["links"]   = $this->ajax_pagination->create_links();
		$this->data['page']    = $page;
		$this->data['product'] = $this->product_m->product_list($page,$pagConfig['per_page'],$where);
		$this->load->view('product_managements/retailerProductHistoryAjaxView',$this->data);
	}
	
	public function view($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Product View';
		$user_id			 = $this->session->userdata('userId');
		$product_id 		 = id_decrypt($product_id);
		$acceptModel         = 0;
		$declinModel         = 0;
		$sendBackModel       = 0;
		if($_POST)
		{	
			$this->custom_log->write_log('custom_log','Form Submit '.print_r($_POST,true));
			$action = $this->input->post('action');
			//	For Accept
			if((!empty($action))&&($action=='accept'))
			{
				$acceptModel = 1;
				$acptRules   = array(	
									array(
										'field' => 'action',
										'label' => 'Action',
										'rules' => 'trim|required'
									),
									array(
										'field' => 'packaging_weight',
										'label' => 'Packaging Weight',
										'rules' => 'trim|required|numeric'
									),
								);
				$this->form_validation->set_rules($acptRules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{	
					$result = $this->product_m->product_data($product_id);
					
					$this->custom_log->write_log('custom_log','product data is '.print_r($result,true));
					
					if(!empty($result))
					{
						$updateArr = array(
										'packing_weight'  => $this->input->post('packaging_weight'),
										'total_weight'    => $result->item_weight+$this->input->post('packaging_weight'),
									 );
						
						if($this->product_m->product_accept_by_admin($product_id,$updateArr))
						{
							$this->custom_log->write_log('custom_log','product accept status changed successfully');
							$userRes = $this->user_m->user_name_email($result->user_id);
							if(!empty($userRes))
							{
								$mailData = array(
												'email'    => $userRes->email,
												'cc'	   => '',
												'slug'     => 'product_accept_by_admin',
												'name'     => $userRes->first_name.' '.$userRes->last_name,
												'subject'   => 'Product Accept By Admin',
											);
								if($this->email_m->send_mail($mailData))
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));					
								}
								else
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));	
								}
							}
							else
							{
								$this->session->set_flashdata('error',$this->lang->line('error_user_details'));
								$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_user_details'));
							}
							$this->session->set_flashdata('success',$this->lang->line('success_product_accept'));
							$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_product_accept'));
						}
						else
						{
							$this->session->set_flashdata('error',$this->lang->line('error_product_accept'));
							$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_accept'));
						}
					}
					else					
					{
						$this->session->set_flashdata('error',$this->lang->line('error_product_not_details'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_not_details'));
					}
					redirect(base_url().'admin/product_retailer');
				}
			}	//	For Delcined
			elseif((!empty($action))&&($action=='decline'))
			{
				$declinModel = 1;
				$dclndRules  = array(	
									array(
										'field' => 'action',
										'label' => 'Action',
										'rules' => 'trim|required'
									),
									array(
										'field' => 'comment',
										'label' => 'Comment',
										'rules' => 'trim'
									),
								);
				$this->form_validation->set_rules($dclndRules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$result = $this->product_m->product_data($product_id);
					$this->custom_log->write_log('custom_log','product data is '.print_r($result,true));
					if(!empty($result))
					{
						$comment = $this->input->post('comment');
						if($this->product_m->product_decline($product_id,$comment))
						{
							$this->custom_log->write_log('custom_log','product decliend status changed successfully');
							$userRes = $this->user_m->user_name_email($result->user_id);
							if(!empty($userRes))
							{
								$mailData = array(
												'email'    => $userRes->email,
												'cc'	   => '',
												'slug'     => 'product_decline_by_admin',
												'name'     => $userRes->first_name.' '.$userRes->last_name,
												'comment'  => $comment,
												'subject'   => 'Product Declined By Admin',
											);
								if($this->email_m->send_mail($mailData))
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));					
								}
								else
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));	
								}
								$this->session->set_flashdata('success',$this->lang->line('success_product_declined'));
								$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('success_product_declined'));
							}
							else
							{
								$this->session->set_flashdata('error',$this->lang->line('error_user_details'));
								$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_user_details'));
							}
						}
						else
						{				
							$this->session->set_flashdata('error',$this->lang->line('error_product_declined'));
							$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_declined'));
						}
					}
					else					
					{
						$this->session->set_flashdata('error',$this->lang->line('error_product_not_details'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_not_details'));
					}
					redirect(base_url().'admin/product_retailer');
				}
			}	//	For Send Back More Information
			elseif((!empty($action))&&($action=='send_back'))
			{
				$sendBackModel = 1;
				$sndBackRules  = array(	
									array(
										'field' => 'action',
										'label' => 'Action',
										'rules' => 'trim|required'
									),
									array(
										'field' => 'comment',
										'label' => 'Comment',
										'rules' => 'trim|required'
									),
								);
				$this->form_validation->set_rules($sndBackRules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$result = $this->product_m->product_data($product_id);
					$this->custom_log->write_log('custom_log','product data is '.print_r($result,true));
					if(!empty($result))
					{
						$comment = $this->input->post('comment');
						$this->custom_log->write_log('custom_log','product decliend status changed successfully');
						$userRes = $this->user_m->user_name_email($result->user_id);
						if(!empty($userRes))
						{
							$updateArr = array(
											'status'  => 'Send_more',
											'comment' => $comment,
										 );
						
							if($this->product_m->product_send_back_by_admin($product_id,$updateArr))
							{
								$mailData = array(
												'email'    => $userRes->email,
												'cc'	   => '',
												'slug'     => 'product_send_back_by_admin',
												'name'     => $userRes->first_name.' '.$userRes->last_name,
												'comment'  => $comment,
												'subject'   => 'Product Send Back By Admin',
											);
								if($this->email_m->send_mail($mailData))
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('success_mail_send'));	
									$this->session->set_flashdata('success',$this->lang->line('success_send_more_info'));
									$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('success_send_more_info'));					
								}
								else
								{
									$this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));	
								}
							}
						}
						else
						{
							$this->session->set_flashdata('error',$this->lang->line('error_user_details'));
							$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_user_details'));
						}
					}
					else					
					{
						$this->session->set_flashdata('error',$this->lang->line('error_product_not_details'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_not_details'));
					}
					redirect(base_url().'admin/product_retailer');
				}
			}			
		}
		
		$result 			         = $this->product_lib->product_review($user_id,$product_id);
		$this->data['result']        = $result;
		$this->data['product_id']    = $product_id;
		$this->data['acceptModel']   = $acceptModel;
		$this->data['declinModel']   = $declinModel;
		$this->data['sendBackModel'] = $sendBackModel;
		$this->adminCustomView('product_managements/product_retailer_view',$this->data);
	}
	
	public function history_view($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Product View';
		$user_id			 = $this->session->userdata('userId');
		$product_id 		 = id_decrypt($product_id);
		$result 			         = $this->product_lib->product_review($user_id,$product_id);
		$this->data['result']        = $result;
		$this->data['product_id']    = $product_id;
		$this->adminCustomView('product_managements/history_view',$this->data);
	}
	
}