<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Inventory extends MY_Controller {

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
			echo 'Login Successfully'; exit;		
		$this->data['total'] = $this->product_m->total_accept_or_admin();
		$this->data['title'] = 'Inventory';
		$this->retailerCustomView('inventory/product_list',$this->data);
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
			$total = $this->product_m->total_accept_or_admin($where);
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
		$this->data['product'] = $this->product_m->accept_or_admin_list($page,$pagConfig['per_page'],$where);
		$this->load->view('inventory/ajaxView',$this->data);
	}
	
	public function segment_list($segment_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->segment_list_dropdown($segment_id,$disable);
	}
	
	public function category_list($segment_id=0,$category_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->category_list_dropdown($segment_id,$category_id,$disable);
	}
	
	public function sub_category1_list($category_id=0,$sub_category1_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->sub_category1_list_dropdown($category_id,$sub_category1_id,$disable);
	}
	
	public function sub_category2_list($sub_category1_id=0,$sub_category2_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}	
		echo $this->segment_cat_m->sub_category2_list_dropdown($sub_category1_id,$sub_category2_id,$disable);
	}
	
	public function sub_category3_list($sub_category2_id=0,$sub_category3_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->sub_category3_list_dropdown($sub_category2_id,$sub_category3_id,$disable);
	}
	
	public function sub_category4_list($sub_category3_id=0,$sub_category4_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->sub_category4_list_dropdown($sub_category3_id,$sub_category4_id,$disable);
	}
	
	public function sub_category5_list($sub_category4_id=0,$sub_category5_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->sub_category5_list_dropdown($sub_category4_id,$sub_category5_id,$disable);
	}
	
	public function sub_category6_list($sub_category5_id=0,$sub_category6_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->sub_category6_list_dropdown($sub_category5_id,$sub_category6_id,TRUE);
	}
	
	public function review($product_id='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'review',
				'log_MID'    => '' 
		) );
				
		$this->data['title'] = 'Review';
		
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url());
		}
		
		$product_id    = id_decrypt($product_id);
		$modified_by   = '';
		$modified_time = '';
		$this->data['productDetails'] = $this->product_m->product_details($product_id);
		
		if(!empty($this->data['productDetails']))
		{
			$modified_by   = $this->data['productDetails']->modified_by;
			$modified_time = $this->data['productDetails']->last_modified_time;
		}
		
		$this->data['modified_by'] 	 = $modified_by;
		$this->data['modified_time'] = $modified_time;
		
		$this->custom_log->write_log('custom_log','Product details is '.print_r($this->data['productDetails'],true));		
		$this->retailerCustomView('admin/product_managements/product_review',$this->data);
	}
	
	public function addEditProduct($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditProduct',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Add Edit Product';
		$product_name        = '';
		$description         = '';
		$segment_id 	     = '0';
		$category_id 	     = '0';
		$sub_category1_id    = '0';
		$sub_category2_id    = '0';
		$sub_category3_id    = '0';
		$sub_category4_id    = '0';
		$sub_category5_id    = '0';
		$sub_category6_id    = '0';
		$ttlPgehit 			 = '';
		$item_weight         = 0;
		$packaging_weight    = 0;
		$total_weight        = 0;
		$srid				 = '';
		$features            = '';
		$attrKey			 = '';
		$productData 		 = '';
		
		$userId = $this->session->userdata('userId');
		if(!empty($product_id))
		{
			$product_id  = id_decrypt($product_id);
			$productData = $this->product_m->product_data($product_id);
		}
		$this->custom_log->write_log('custom_log','product id is '.$product_id);	
		
		$pageHit = $this->product_m->get_product_identifiers();
		$this->custom_log->write_log('custom_log','product identifiers '.print_r($pageHit,true));		
		if(!empty($pageHit))
		{
			$ttlPgehit = $pageHit->add_prodcut_page_hit+1;
			$this->product_m->update_product_identifiers($ttlPgehit);
			$this->custom_log->write_log('custom_log','product page hit'.$ttlPgehit);				
		}	
			
		if($_POST)
		{	
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = array(	
						array(
							'field' => 'product_name',
							'label' => 'Product Name',
							'rules' => 'trim|required'
						),
						array(
							'field' => 'description',
							'label' => 'Description',
							'rules' => 'trim|required|min_length[40]'
						),
						array(
							'field' => 'spid',
							'label' => 'SPID',
							'rules' => 'trim|required'
						),
						array(
							'field' => 'srid',
							'label' => 'SRID',
							'rules' => 'trim|required'
						),
						array(
							'field' => 'product_attr',
							'label' => 'Attribute Name',
							'rules' => 'trim|required'
						),
						array(
							'field' => 'item_weight',
							'label' => 'Item Weight',
							'rules' => 'trim|required|greater_than[0]'
						),
						array(
							'field' => 'segment_id',
							'label' => 'Segment Name',
							'rules' => 'trim|required'
						),
						array(
							'field' => 'category_id',
							'label' => 'Category Name',
							'rules' => 'trim|required'
						),
					 );
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if(!empty($_POST['sub_category1_id']))
			{
				$sub_category1_id = $this->input->post('sub_category1_id');
			}
			if(!empty($_POST['sub_category2_id']))
			{
				$sub_category2_id = $this->input->post('sub_category2_id');
			}
			if(!empty($_POST['sub_category3_id']))
			{
				$sub_category3_id = $this->input->post('sub_category3_id');
			}
			if(!empty($_POST['sub_category4_id']))
			{
				$sub_category4_id = $this->input->post('sub_category4_id');
			}
			if(!empty($_POST['sub_category5_id']))
			{
				$sub_category5_id = $this->input->post('sub_category5_id');
			}
			if(!empty($_POST['sub_category6_id']))
			{
				$sub_category6_id = $this->input->post('sub_category6_id');
			}
			
			$segment_id       = $this->input->post('segment_id');
			$category_id      = $this->input->post('category_id');
			$product_name     = $this->input->post('product_name');
			$description      = $this->input->post('description');
			$spid		      = $this->input->post('spid');
			$srid		      = $this->input->post('srid');
			$attrKey          = $this->input->post('product_attr');
			$item_weight      = $this->input->post('item_weight');
			$packaging_weight = $this->input->post('weight_shipping');
			$total_weight     = $this->input->post('total_weight');
			$features         = $this->input->post('features');
				
			if($this->form_validation->run())
			{	
				if(!empty($product_id))
				{
					$updateProductOpt = array(
								 	'table' => 'product',
									'data'  => array(
												'product_name'     => $product_name,
												'spid'		       => $spid,
												'srid'			   => $srid,
												'product_attribute_name' => $attrKey,
												'item_weight'      => $item_weight,
												'packing_weight'   => $packaging_weight,
												'total_weight'     => $total_weight,
												'segment_id'       => $segment_id,	
												'category_id'	   => $category_id,
												'sub_category1_id' => $sub_category1_id,
												'sub_category2_id' => $sub_category2_id,
												'sub_category3_id' => $sub_category3_id,
												'sub_category4_id' => $sub_category4_id,
												'sub_category5_id' => $sub_category5_id,
												'sub_category6_id' => $sub_category6_id,
												'description'	   => $description,
												'features'		   => json_encode($features),
												'last_modified_by' => $userId,
												'last_modified_time' => $this->currentTimestamp
												),
									'where' => array(
													'product_id' => $product_id,
													'last_modified_by' => $userId,	
												),
								 );
					$this->custom_log->write_log('custom_log','update product data is '.print_r($updateProductOpt,true));
					if($this->common_model->customUpdate($updateProductOpt))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_update_product'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_update_product'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_update_product'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_update_product'));											
					}
					redirect(base_url().'retailer/inventory/addEditProductImage/'.id_encrypt($product_id));
				}
				else
				{
					$addProductOpt = array(
								 	'table' => 'product',
									'data'  => array(
												'product_name'     => $product_name,
												'spid'		       => $spid,
												'srid'			   => $srid,
												'product_attribute_name' => $attrKey,
												'item_weight'      => $item_weight,
												'packing_weight'   => $packaging_weight,
												'total_weight'     => $total_weight,
												'segment_id'       => $segment_id,	
												'category_id'	   => $category_id,
												'sub_category1_id' => $sub_category1_id,
												'sub_category2_id' => $sub_category2_id,
												'sub_category3_id' => $sub_category3_id,
												'sub_category4_id' => $sub_category4_id,
												'sub_category5_id' => $sub_category5_id,
												'sub_category6_id' => $sub_category6_id,
												'description'	   => $description,
												'features'		   => json_encode($features),
												'last_modified_by' => $userId,
												'user_id'			=> $userId,
												'last_modified_time' => $this->currentTimestamp,
												'is_admin'			 => 0,
												'status' 			 => 'Request',
												),
								 );
				
					$this->custom_log->write_log('custom_log','add product data is '.print_r($addProductOpt,true));
					$product_id = $this->common_model->customInsert($addProductOpt);
					$this->custom_log->write_log('custom_log','product id is '.$product_id);			
					if($product_id)
					{
						$this->session->set_flashdata('success',$this->lang->line('success_add_product'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_add_product'));
						redirect(base_url().'retailer/inventory/addEditProductImage/'.id_encrypt($product_id));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_add_product'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_add_product'));
						redirect(base_url().'retailer/inventory/addEditProduct');	
					}
				}
			}
		}
			
		if(!empty($productData))
		{
			$this->custom_log->write_log('custom_log','product data is '.print_r($productData,true));
			$product_name     = $productData->product_name;
			$description      = $productData->description;
			$segment_id 	  = $productData->segment_id;
			$category_id 	  = $productData->category_id;
			$sub_category1_id = $productData->sub_category1_id;
			$sub_category2_id = $productData->sub_category2_id;
			$sub_category3_id = $productData->sub_category3_id;
			$sub_category4_id = $productData->sub_category4_id;
			$sub_category5_id = $productData->sub_category5_id;
			$sub_category6_id = $productData->sub_category6_id;	
			$item_weight      = $productData->item_weight;
			$packaging_weight = $productData->packing_weight;
			$total_weight     = $productData->total_weight;
			$attrKey          = $productData->product_attribute_name;
			$features         = json_decode($productData->features);
			$srid			  = $productData->srid;
		}
		
		$this->data['spid'] 			= $ttlPgehit;
		$this->data['product_name']     = $product_name;
		$this->data['description']      = $description;
		$this->data['segment_id'] 		= $segment_id;
		$this->data['category_id']      = $category_id;
		$this->data['sub_category1_id'] = $sub_category1_id;
		$this->data['sub_category2_id'] = $sub_category2_id;
		$this->data['sub_category3_id'] = $sub_category3_id;
		$this->data['sub_category4_id'] = $sub_category4_id;
		$this->data['sub_category5_id'] = $sub_category5_id;
		$this->data['sub_category6_id'] = $sub_category6_id;
		$this->data['item_weight']		= $item_weight;	
		$this->data['packaging_weight']	= $packaging_weight;	
		$this->data['total_weight']  	= $total_weight;
		$this->data['features']         = $features;
		$this->data['attrKey']          = $attrKey;
		$this->data['srid'] 			= $srid;
		$this->retailerCustomView('admin/product_managements/add_edit_product',$this->data);
	}
	
	public function addEditProductImage($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditProductImage',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Add Edit Product Image';
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url().'retailer/inventory');
		}
		
		$product_id  = id_decrypt($product_id);
		$productList = $this->product_m->product_image($product_id);
		
		$this->data['product_id']  = $product_id;
		$this->data['productList'] = $productList;
		
		$this->retailerCustomView('inventory/add_edit_product_image',$this->data);
	}
	
	public function upload_product_image($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_product_image',
				'log_MID'    => '' 
		) );
		
		$product_id = id_decrypt($product_id);
		$this->custom_log->write_log('custom_log','product id is '.$product_id);
		
		$userId = $this->session->userdata('userId');
		$this->custom_log->write_log('custom_log','user id is '.$userId);
		
		$this->load->library('upload');
		
		if(isset($_FILES['myfile']))
		{
			$result = '';
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp+new_random_password()).'.'.$extension;
			
			$config['upload_path']   = './uploads/product/'; 
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $newImageName;
						
			$this->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('myfile'))
			{
				$result = $this->upload->display_errors();			
				$this->custom_log->write_log('custom_log','file upload error is '.$this->upload->display_errors());
			}
			else
			{
				$imagepath	  =	'uploads/product/'.$newImageName ;
				$newimagepath =	'uploads/product/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/product/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
				
				$insertOpt = array(
							 	'table' => 'product_image',
								'data'  => array(
												'product_image_name' => $newImageName,
												'product_id'         => $product_id,
												'last_modified_by'   => $userId,
												'last_modified_time' => $this->currentTimestamp
											),
							 );
				$this->custom_log->write_log('custom_log','product image insert befor '.print_r($insertOpt,true));
				$product_image_id = $this->common_model->customInsert($insertOpt);
				$this->custom_log->write_log('custom_log','product image creat id is '.$product_image_id);
				if($product_image_id)
				{
					$this->custom_log->write_log('custom_log',$this->lang->line('success_add_product_image'));
					$result = $this->lang->line('success_add_product_image');
				}
				else
				{
					$this->custom_log->write_log('custom_log',$this->lang->line('error_add_product_image'));
					$result = $this->lang->line('error_add_product_image');
				}				
			}
			echo $result;
		}	
	}
	
	public function delete_image($productImageId='',$product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'remove_image',
				'log_MID'    => '' 
		) );
		
		if(empty($productImageId))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_image_id_not'));
			redirect(base_url().'retailer/inventory/addEditProductImage/'.$product_id);
		}
		
		$productImageId = id_decrypt($productImageId);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		
		$getOpt = array(
						'table' => 'product_image',
						'where' => array('product_image_id' => $productImageId),
						'single' => true
					);
		$prdImageRes = $this->common_model->customGet($getOpt);			
		$this->custom_log->write_log('custom_log','product image details '.print_r($prdImageRes,true));
		
		if(!empty($prdImageRes))
		{
			$prdImageName = $prdImageRes->product_image_name;
			
			$deleteOpt = array(
						 	'table' => 'product_image',
							'where' => array('product_image_id' => $productImageId),
						 );
			if($this->common_model->customDelete($deleteOpt))
			{
				if((!empty($prdImageName))&&(file_exists('uploads/product/thumb50/'.$prdImageName)))
				{
					unlink('uploads/product/thumb50/'.$prdImageName);
					unlink('uploads/product/'.$prdImageName);
				}
				$this->session->set_flashdata('success',$this->lang->line('success_delete_product_image'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_delete_product_image'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_delete_product_image'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_delete_product_image'));
			}
		}
		redirect(base_url().'retailer/inventory/addEditProductImage/'.$product_id);					
	}
	
	public function make_main_image($productImageId='',$product_id)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'make_main_image',
				'log_MID'    => '' 
		) );
		
		if(empty($productImageId))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_image_id_not'));
			redirect(base_url().'retailer/inventory');
		}
		
		$productImageId = id_decrypt($productImageId);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		
		$getOpt = array(
						'table' => 'product_image',
						'where' => array('product_image_id' => $productImageId),
						'single' => true
					);
		$prdImageRes = $this->common_model->customGet($getOpt);			
		$this->custom_log->write_log('custom_log','product image details '.print_r($prdImageRes,true));
		
		if(!empty($prdImageRes))
		{
			$updateOpt1 = array(
						 	'table' => 'product_image',
							'where' => array('product_id' => id_decrypt($product_id)),
							'data'  => array('status' => 0),
						 );
			$this->common_model->customUpdate($updateOpt1);
			
			$updateOpt2 = array(
						 	'table' => 'product_image',
							'where' => array('product_image_id' => $productImageId),
							'data'  => array('status' => 1),
						 );
			if($this->common_model->customUpdate($updateOpt2))
			{
				$this->session->set_flashdata('success',$this->lang->line('success_main_product_image'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_main_product_image'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_main_product_image'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_main_product_image'));
			}
		}
		redirect(base_url().'retailer/inventory/addEditProductImage/'.$product_id);					
	}
	
	public function addEditProductAttribute($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditProductAttribute',
				'log_MID'    => '' 
		) );
		$this->load->helper('form');
		$this->data['title'] = 'Add Edit Product Attributes';
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url().'retailer/inventory');
		}
		
		$product_id  = id_decrypt($product_id);
		$userId      = $this->session->userdata('userId');
		$productAttr = $this->product_m->product_attribute($product_id);
		$this->custom_log->write_log('custom_log','Product attribute list '.print_r($productAttr,true));
		$attrID   	= '';
		$attrKey  	= '';
		$attrVal  	= '';
		$brand_id   = '';
		$segmentID  = 0;
		$categoryID = 0;
		$subCat1ID  = 0;
		$subCat2ID  = 0;
		$subCat3ID  = 0;
		$subCat4ID  = 0;
		$subCat5ID  = 0;
		$subCat6ID  = 0;		
		$attrNm     = $this->product_m->product_data($product_id);		
		
		if(!empty($attrNm))
		{
			$attrKey    = $attrNm->product_attribute_name;
			$segmentID  = $attrNm->segment_id;
			$categoryID = $attrNm->category_id;
			$subCat1ID  = $attrNm->sub_category1_id;
			$subCat2ID  = $attrNm->sub_category2_id;
			$subCat3ID  = $attrNm->sub_category3_id;
			$subCat4ID  = $attrNm->sub_category4_id;
			$subCat5ID  = $attrNm->sub_category5_id;
			$subCat6ID  = $attrNm->sub_category6_id;
		}
				
		if(!empty($productAttr))
		{
			$attrID   = $productAttr->product_attribute_id;
			$attrVal  = $productAttr->product_attribute_value;
			$brand_id = $productAttr->brand_id;
		}
		$brandErr = '';
		if($_POST)
		{
			$product_attr   = $attrKey;
			$brand_id   	= $this->input->post('brand_name');
			$new_brand_name = $this->input->post('new_brand_name');
			
			if((empty($brand_id))&&(empty($new_brand_name)))
			{
				$brandErr = '<div class="error">Please select Brand name OR add new</div>';
			}
			else
			{
				$this->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
				$product_attr = $attrKey;
				if(!empty($product_attr))
				{
					$validation_rules = product_attribute_validation_rule();				
					$this->form_validation->set_rules($validation_rules[$product_attr]);
					$this->form_validation->set_error_delimiters('<div class="error">','</div>');
					if($this->form_validation->run())
					{
						$brand_name = '';
						$brand_id   = $this->input->post('brand_name');	
						$tax        = $this->input->post('tax');		
						
						if(!empty($new_brand_name))
						{
							$brand_id = $this->brand_m->brand_insert($segmentID,$categoryID,$subCat1ID,$subCat2ID,$subCat3ID,$subCat4ID,$subCat5ID,$subCat6ID,$new_brand_name);	
						}
						$this->custom_log->write_log('custom_log','brand id '.$brand_id);
						if(!empty($brand_id))
						{
							$brndRes    = $this->segment_cat_m->brand_name($brand_id); 
							$brand_name = $brndRes->brand_name;
							$this->brand_m->brand_update($segmentID,$categoryID,$subCat1ID,$subCat2ID,$subCat3ID,$subCat4ID,$subCat5ID,$subCat6ID,$brand_id,$brand_name);	
						}
						
								
						if(!empty($brand_id))
						{
							$brndRes    = $this->segment_cat_m->brand_name($brand_id); 
							$brand_name = $brndRes->brand_name;
						}
						
						$valArr   = array();
						foreach($_POST as $key=>$value)
						{
							if(($key=='brand_name')||($key=='new_brand_name'))
							{
								$valArr['brand_name'] = $brand_name;
							}
							else
							{
								$valArr[$key] = $value;						
							}
						}
						
						if(!empty($attrID))
						{
							$updateOpt = array(
										'table' => 'product_attribute',
										'data'  => array(
											'product_attribute_key'   => $product_attr,
											'product_attribute_value' => json_encode($valArr),
											'product_id'			  => $product_id,
											'brand_id'				  => $brand_id,
											'tax'					  => $tax,
											'last_modified_by'        => $userId,
											'last_modified_time'      => $this->currentTimestamp		
											),
										 'where' => array('product_attribute_id' => $attrID),
								 );
							$this->custom_log->write_log('custom_log','update befor data is '.print_r($updateOpt,true));
							if($this->common_model->customUpdate($updateOpt))
							{
								$this->session->set_flashdata('success',$this->lang->line('success_update_product_attribute'));
								$this->custom_log->write_log('custom_log',$this->lang->line('success_update_product_attribute'));
								redirect(base_url().'retailer/inventory/review/'.id_encrypt($product_id));
							}
							else
							{
								$this->session->set_flashdata('error',$this->lang->line('error_update_product_attribute'));
								$this->custom_log->write_log('custom_log',$this->lang->line('error_update_product_attribute'));
								redirect(base_url().'retailer/inventory/addEditProductAttribute/'.id_encrypt($product_id));						
							}
						}						
						else
						{
							$insertOpt = array(
										'table' => 'product_attribute',
										'data'  => array(
											'product_attribute_key'   => $product_attr,
											'product_attribute_value' => json_encode($valArr),
											'product_id'			  => $product_id,
											'brand_id'				  => $brand_id,
											'tax'					  => $tax,
											'last_modified_by'        => $userId,
											'last_modified_time'      => $this->currentTimestamp		
										),
									 );
							$this->custom_log->write_log('custom_log','Inser befor data is '.print_r($insertOpt,true));
							$productArrID = $this->common_model->customInsert($insertOpt);
							$this->custom_log->write_log('custom_log','Product attribute id is '.$productArrID);					
							if($productArrID)
							{
								$this->session->set_flashdata('success',$this->lang->line('success_add_product_attribute'));
								$this->custom_log->write_log('custom_log',$this->lang->line('success_add_product_attribute'));
								redirect(base_url().'retailer/inventory/review/'.id_encrypt($product_id));
							}
							else
							{
								$this->session->set_flashdata('error',$this->lang->line('error_add_product_attribute'));
	
								$this->custom_log->write_log('custom_log',$this->lang->line('error_add_product_attribute'));
								redirect(base_url().'retailer/inventory/addEditProductAttribute/'.id_encrypt($product_id));
							}
						}					
					}	
				}
			}			
		}
		
		$this->data['attrKey']    = $attrKey;
		$this->data['brand_id']   = $brand_id;
		$this->data['brand_list'] = $this->brand_m->category_brand_list($segmentID,$categoryID,$subCat1ID,$subCat2ID,$subCat3ID,$subCat4ID,$subCat5ID,$subCat6ID);
		$this->data['attrVal']    = json_decode($attrVal);
		$this->data['colorArr']   = product_color_list();
		$this->data['brandErr']   = $brandErr;
		$this->retailerCustomView('inventory/'.$attrKey,$this->data); 
	}
	
	public function dimension_check($dimension)
	{
		if(preg_match("/^([0-9^*])+$/i",$dimension))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('dimension_check','The item dimension must be in L*W*H formate ');
			return false;
		}
	}
		
	public function add_inventory($product_id='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_inventory',
				'log_MID'    => '' 
		) );
				
		$this->data['title'] = 'Add Inventory';
		
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url());
		}
		
		$product_id = id_decrypt($product_id);
		$used       = '';
		$this->data['product_attribute']=$this->product_m->product_attribute($product_id);
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$used  = $this->input->post('used');
			$rules = add_inventory_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run())
			{
				$sale_price 	 = $this->input->post('sale_price');
				$displayed_price = $this->input->post('displayed_price');
				$inventory   	 = $this->input->post('inventory');
				$commission      = $this->input->post('commission');
				
				
				$invtryDetails = $this->product_m->inventry_details($product_id);
				$this->custom_log->write_log('custom_log','Inventry details '.print_r($invtryDetails,true));
				if(!empty($invtryDetails))
				{
					$inventryID    = $invtryDetails->product_detail_id;
					$totalInventry = $invtryDetails->inventory+$inventory;
					$this->product_m->update_retailer_product_detail($inventryID,$sale_price,$displayed_price,$totalInventry,$commission,$used);					
				}
				else
				{
					$inventryID = $this->product_m->add_retailer_product_detail($product_id,$sale_price,$displayed_price,$inventory,$commission,$used);
				}
				$this->custom_log->write_log('custom_log','inventry id is '.$inventryID);
				$historyID = $this->product_m->add_retailer_product_detail_history($product_id,$sale_price,$displayed_price,$inventory,$commission,$inventryID,$used);
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
				redirect(base_url().'retailer/inventory');
			}
		}
		$this->data['used'] = $used;
		$this->retailerCustomView('inventory/add_inventory',$this->data);
	}
	
	public function product_commission_count()
	{
		$commission 			= $this->input->post('commission');
		$price      			= $this->input->post('sale_price');
		$spacecommission    	= $this->input->post('spacecommission');
		//$commission  = $this->product_m->product_commission();
		//$displyPrice = product_commission_count($commission,$price);
		$displyPrice= $commission+$price+$spacecommission;
		echo $displyPrice;
	}
}