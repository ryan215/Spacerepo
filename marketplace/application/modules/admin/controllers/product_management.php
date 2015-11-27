<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Product_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );

		$this->data['title'] = 'Product Managements';
	}	
	
	public function index($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );				
		
		$this->data['result'] = $this->product_lib->product_list(); 
		$this->data['organizationId'] = id_decrypt($organizationId);
		$this->adminCustomView('product_managements/product_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{	
		$organizationId = $this->input->post('organizationId');
		$this->data['result'] = $this->product_lib->product_ajaxFun($total); 
		$this->data['organizationId'] = $organizationId;
		$this->load->view('retailer/product_managements/ajaxView',$this->data);
	}
		
	public function addEditProduct($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_product',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Add|Edit Product';
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->add_edit_product($product_id);
		$this->data['result'] = $result;
		$this->data['product_id'] = $product_id;
		$this->adminCustomView('product_managements/add_edit_product',$this->data);
	}
	
	public function brand_check()
	{
		$brand_id       = $this->input->post('brand_id');
		$new_brand_name = $this->input->post('new_brand_name');
		if((empty($brand_id))&&(empty($new_brand_name)))
		{
			$this->form_validation->set_message('brand_check','The Brand Name or New Brand Name field required');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function addEditProductImage($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_product_image',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Add|Edit Product Image';
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url().'admin/product_management/addEditProduct');
		}
		
		$product_id  			   = id_decrypt($product_id);
		$productList 			   = $this->product_m->product_image_list($product_id);
		
		$this->data['product_id']  = $product_id;
		$this->data['productList'] = $productList;
		$this->adminCustomView('retailer/product_managements/addEditProductImage',$this->data);
	}
	
	public function addEditProductAttribute($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditProductAttribute',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Add|Edit Product Attribute';
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->add_edit_product_attribute($product_id);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		$this->adminCustomView('retailer/product_managements/addEditProductAttribute',$this->data);
	}
	
	public function productReview($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_review',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product Review';
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->admin_product_review($product_id);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		$this->data['product_id'] = $product_id;
		$this->adminCustomView('product_managements/product_review',$this->data);
	}
	
	public function uploadProductImage($productId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'uploadProductImage',
				'log_MID'    => '' 
		) );
		
		$productId = id_decrypt($productId);
		$this->custom_log->write_log('custom_log','product id is '.$productId);
		$result = $this->product_lib->multiple_upload_product_image($productId);
		echo $result;
	}
	
	public function deleteImage($productImageId='',$product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'deleteImage',
				'log_MID'    => '' 
		) );
		
		if(empty($productImageId))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_image_id_not'));
			redirect(base_url().'admin/product_management/addEditProductImage/'.$product_id);
		}
		
		$productImageId = id_decrypt($productImageId);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		$this->product_lib->delete_image($productImageId);
		redirect(base_url().'admin/product_management/addEditProductImage/'.$product_id);
	}
	
	public function makeMainImage($productImageId='',$product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'make_main_image',
				'log_MID'    => '' 
		) );
		
		if(empty($productImageId))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_image_id_not'));
			redirect(base_url().'admin/product_management');
		}
		
		$productImageId = id_decrypt($productImageId);
		$product_id     = id_decrypt($product_id);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		$this->product_lib->make_main_image($productImageId,$product_id);
		redirect(base_url().'admin/product_management/addEditProductImage/'.id_encrypt($product_id));		
	}
	
	public function unblock_block($product_id,$status)
	{
		$product_id = id_decrypt($product_id);
		
		if(!empty($product_id))
		{
			if($this->product_m->block_unblock($status,$product_id))
			{
				if(!$status)
				{
					$this->session->set_flashdata('success',$this->lang->line('success_block_product'));
				}
				else
				{
					$this->session->set_flashdata('success',$this->lang->line('success_unblock_product'));
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_not_update'));
			}			
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_invalie_id'));
		}
		redirect(base_url().'admin/product_management/view/'.id_encrypt($product_id));
	}
	
	public function view($product_id='',$organizationId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product View';
		$user_id			  = $this->session->userdata('userId');
		$product_id 		  = id_decrypt($product_id);
		$sendBackModel = 0;
		$declinModel   = 0;
		
		//	For product send back and declined
		if($_POST)
		{
			$action = $this->input->post('action');
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));			
			if($action=='send_back')
			{
				$sendBackModel = 1;	
				$rules = admin_send_back_product_request_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$reason = $this->input->post('comment');
					$userRes = $this->user_m->user_name_email($productDetails->last_modified_by);
					if(!empty($userRes))
					{
						$mailData = array(
										'email'    => $userRes->email,
										'cc'	   => '',
										'slug'     => 'product_send_back_by_admin',
										'name'     => $userRes->first_name.' '.$userRes->last_name,
										'reason'   => $reason,
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
							$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));	
						}			
					}
					redirect(base_url().'admin/product_management/review/'.id_encrypt($product_id).'/view/retailer');
				}
			}
			elseif($action=='decline')
			{
				$declinModel = 1;
				$rules = admin_decline_product_request_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$comment = $this->input->post('comment');
					if($this->product_m->product_decline($product_id,$comment))
					{
						$userRes = $this->user_m->user_name_email($productDetails->last_modified_by);
						if(!empty($userRes))
						{
							$mailData = array(
										'email'    => $userRes->email,
										'cc'	   => '',
										'slug'     => 'product_decline_by_admin',
										'name'     => $userRes->first_name.' '.$userRes->last_name,
										'comment'  => $comment,
										'subject'   => 'Product Declined by Admin',
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
						$this->session->set_flashdata('success',$this->lang->line('success_product_declined'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('success_product_declined'));
					}
					else
					{				
						$this->session->set_flashdata('error',$this->lang->line('error_product_declined'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_declined'));
					}
					redirect(base_url().'admin/product_management/review/'.id_encrypt($product_id).'/view/retailer');
				}
			}
		}
		
		$result 			          = $this->product_lib->admin_product_review($product_id);
		$this->data['result']         = $result;
		$this->data['product_id']     = $product_id;
		$this->data['sendBackModel']  = $sendBackModel;
		$this->data['declinModel']    = $declinModel;
		//echo "<pre>"; print_r($result); exit;
		$this->data['organizationId']     = $organizationId;
		$this->adminCustomView('product_managements/product_view',$this->data);
	}
	
	public function review($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_product_review',
				'log_MID'    => '' 
		) );
				
		$this->data['title'] = 'Add Product Review';
		
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url().'admin/product_management/addEditProduct');
		}
		
		$product_id     = id_decrypt($product_id);
		$userId         = $this->session->userdata('userId');
		$productDetails = $this->product_m->product_details($product_id,$userId);
		$modified_by 	= '';
		$modified_time  = '';
		$this->custom_log->write_log('custom_log','Product details is '.print_r($productDetails,true));
		$sendBackModel = 0;
		$declinModel   = 0;
		
		//	For product send back and declined
		if($_POST)
		{
			$action = $this->input->post('action');
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));			
			if($action=='send_back')
			{
				$sendBackModel = 1;	
				$rules = admin_send_back_product_request_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$reason = $this->input->post('comment');
					$userRes = $this->user_m->user_name_email($productDetails->last_modified_by);
					if(!empty($userRes))
					{
						$mailData = array(
										'email'    => $userRes->email,
										'cc'	   => '',
										'slug'     => 'product_send_back_by_admin',
										'name'     => $userRes->first_name.' '.$userRes->last_name,
										'reason'   => $reason,
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
							$this->session->set_flashdata('error',$this->lang->line('error_mail_not_send'));	
						}			
					}
					redirect(base_url().'admin/product_management/review/'.id_encrypt($product_id).'/view/retailer');
				}
			}
			elseif($action=='decline')
			{
				$declinModel = 1;
				$rules = admin_decline_product_request_rules();
				$this->form_validation->set_rules($rules);
				$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				if($this->form_validation->run())
				{
					$comment = $this->input->post('comment');
					if($this->product_m->product_decline($product_id,$comment))
					{
						$userRes = $this->user_m->user_name_email($productDetails->last_modified_by);
						if(!empty($userRes))
						{
							$mailData = array(
										'email'    => $userRes->email,
										'cc'	   => '',
										'slug'     => 'product_decline_by_admin',
										'name'     => $userRes->first_name.' '.$userRes->last_name,
										'comment'  => $comment,
										'subject'   => 'Product Declined by Admin',
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
						$this->session->set_flashdata('success',$this->lang->line('success_product_declined'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('success_product_declined'));
					}
					else
					{				
						$this->session->set_flashdata('error',$this->lang->line('error_product_declined'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_product_declined'));
					}
					redirect(base_url().'admin/product_management/review/'.id_encrypt($product_id).'/view/retailer');
				}
			}
		}
		
		if(!empty($productDetails))
		{
			$modified_by   = $productDetails->modified_by;
			$modified_time = $productDetails->last_modified_time;
		}
		
		$this->data['productDetails'] = $productDetails;
		$this->data['modified_by'] 	  = $modified_by;
		$this->data['modified_time']  = $modified_time;
		$this->data['sendBackModel']  = $sendBackModel;
		$this->data['declinModel']    = $declinModel;
		
		$this->adminCustomView('product_managements/product_review',$this->data);
	}	
	
	public function check_stocks($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stocks',
				'log_MID'    => '' 
		) );	
		$organizationId 			  = id_decrypt($organizationId);
		$this->data['result']     	  = $this->product_lib->check_stocks_index($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->adminCustomView('retailer/product_managements/check_stocks',$this->data);
	}
	
	public function check_stocksAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stocksAjaxFun',
				'log_MID'    => '' 
		) );

		$this->data['result'] = $this->product_lib->check_stocksAjaxFun($total);
		$this->load->view('retailer/product_managements/check_stocksAjaxFun',$this->data);
	}
	
	public function inventory_details($organizationProductId=0,$organizationId=0)
	{
		$organizationProductId = id_decrypt($organizationProductId);
		$organizationId        = id_decrypt($organizationId);
		//$organizationProductId = id_decrypt($organizationProductId);
		$product_detail=$this->data['result'] = $this->product_lib->inventory_details($organizationProductId,$organizationId);
		$resultProductDetail  = $this->product_lib->product_review($product_detail['productId']);
			if(!empty($resultProductDetail['sizes'])){
		$this->data['sizes']	=explode(',',$resultProductDetail['sizes']);	
		}else
		{
			$this->data['sizes']='';
		}
		$this->data['organizationProductId']  = $organizationProductId;
		$this->data['organizationId']  = $organizationId;
		$this->adminCustomView('retailer/product_managements/inventory_details',$this->data);
	}
	
	public function add_inventory($organizationId=0,$productId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_inventory',
				'log_MID'    => '' 
		) );
		
		$organizationId 	          = id_decrypt($organizationId);
		$productId       	          = id_decrypt($productId);
		$this->data['result']         = $this->product_lib->add_product_inventory($organizationId,$productId);
		$this->data['organizationId'] = $organizationId;
		$this->data['productId']      = $productId;
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->adminCustomView('product_managements/add_inventory',$this->data);
	}
	
	public function edit_inventory($organizationProductId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_inventory',
				'log_MID'    => '' 
		) );
		
		$organizationProductId = id_decrypt($organizationProductId);
		$this->custom_log->write_log('custom_log','Organziation product id is '.$organizationProductId);
		
		$this->data['result']  = $this->product_lib->edit_inventory($organizationProductId);
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->data['organizationProductId'] = $organizationProductId;
		$this->adminCustomView('product_managements/edit_inventory',$this->data);
	}
	
	public function product_price_calculate()
	{
		$result = $this->product_lib->product_price_calculate();
		echo json_encode($result);
	}
	
	public function calculate_price()
	{
		$result	   = array('sellPrice' => 0,'spacePoint' => 0,'retailerPrice' => 0,'displayPrice' => 0,'message' => '','status' => 1);
		$sellPrice = $this->input->post('sellPrice');
		if(!empty($sellPrice))
		{
			if(is_numeric($sellPrice))
			{
				$result['status']        = 1;
				$result['displayPrice']  = $sellPrice;
				$result['spacePoint']    = ($sellPrice*$this->config->item('space_point_comission'))/100;
				$result['retailerPrice'] = $sellPrice-$result['spacePoint'];
			}
			else
			{
				$result['status']  = 0;
				$result['message'] = 'Please enter the Numeric value';
			}
		}
		else
		{
			$result['status']  = 0;
			$result['message'] = 'Please enter the Sell Price';
		}
		echo json_encode($result);
	}
	
	public function check_inventory()
	{
		$currentQty = $this->input->post('currentQty');
		$inventory  = $this->input->post('inventory');
		$editinventory  = $this->input->post('editinventory');
		if($editinventory=='sub')
		{
			if($inventory>$currentQty)
			{
				$this->form_validation->set_message('check_inventory','not avaliable in current stock');
				return false;
			}
			else
			{	
				return true;
			}
		}
	}
	
	public function check_product_name()
	{
		$productId   = $this->input->post('productId');
		$productName = $this->input->post('product_name');
		
		$details = $this->product_m->check_product_name($productName,$productId);     
		if(!empty($details))
		{
			$this->form_validation->set_message('check_product_name','The %s field already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function inventory_list($productId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'inventory_list',
				'log_MID'    => '' 
		) );
		
		$this->data['productId'] = id_decrypt($productId);
		$this->adminCustomView('product_managements/inventory_list',$this->data);
	}
	
	public function ajax_inventory_list($productId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajax_inventory_list',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->product_lib->ajax_inventory_list($productId);		
		$this->load->view('product_managements/ajax_inventory_list',$this->data);
       
	}
}