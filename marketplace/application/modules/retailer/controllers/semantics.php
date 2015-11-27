<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Semantics extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Product Management';
		$this->load->library('semantic');
		$this->load->model('Sementic_product_m');
		$this->load->model('segment_cat_m');
		$this->load->model('color_m');
	}	
	
	public function index()
	{
		$user_detail=$this->session->userdata('product_result');
		$this->retailerCustomView('admin/semantics/product_listing',$this->data);
	
	}
	public function ajax_product_list()
	{
		$search=$this->input->post('search');
		$product_detial=$this->data['product_detial']=	$this->semantic->get_products($search);
		$time=time();
		$this->load->library('custom_product');
		$this->custom_product->write_log('custom_log',$product_detial,$time);
		$this->data['time']=$time;
		$this->data['product_detial']=json_decode($product_detial);
		$this->load->view('admin/semantics/ajax_product_listing',$this->data);
		
	}
	
	public function add_product($time,$key)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_product',
				'log_MID'    => '' 
		) );
		
		$detail=file_get_contents(APPPATH.'product_log/product_log'.$time.'.json');
		$detail=json_decode($detail);
		$this->data['product_detail']=$detail->results[$key];
		$this->custom_log->write_log('custom_log','Product details is '.print_r($this->data['product_detail'],true));
		
		if(isset($detail->results[$key]->brand) && !empty($detail->results[$key]->brand))
		{
			$brand_detail=$this->brand_m->check_brand_name('',$detail->results[$key]->brand);
			$this->custom_log->write_log('custom_log','brand details is '.print_r($brand_detail,true));
	 
		if(!empty($brand_detail))
		{
			
			$brand_id=$brand_detail->brandId;
		}else
		{
			$data=array(	'brand_name'      	=> $detail->results[$key]->brand,	
							'brand_image'		 => '',	
							'brandDescription'		     => '',	
							);
		$brand_id=$this->brand_m->add_brand($data);
		
		}
		
		}
		else
		{
			$brand_id='';
		}
		$this->custom_log->write_log('custom_log','brand id is '.$brand_id);
			
		$product_info=array(		'name'					=>	$detail->results[$key]->name,
									'description'			=>	'',
									'brandId'				=>	$brand_id,
									
					);
		$product_id=$this->Sementic_product_m->add_product($product_info);
		$this->custom_log->write_log('custom_log','last_query is '.$this->db->last_query());
		
		if(!empty($product_id))
		{	
			if(isset($detail->results[$key]->images) && !empty($detail->results[$key]->images))
			{
				$image_order = 1;
				foreach($detail->results[$key]->images as $image)
				{
					list($width,$height) = getimagesize($image);
					$this->custom_log->write_log('custom_log','Uploaded image widht is '.$width.' and height is '.$height);
					if(((!empty($width))&&($width>=500))&&((!empty($height))&&($height>=500)))
					{
						$newimage_name = getRandomUserName();
						$extension     = pathinfo($image,PATHINFO_EXTENSION);
						$newImageName  = ($this->currentTimestamp.$newimage_name).'.'.$extension;
						$imagepath	   = 'uploads/product/'.$newImageName ;
						$imagedata     = file_get_contents($image);
						file_put_contents($imagepath,$imagedata);
						$this->Sementic_product_m->add_product_image($product_id,$newImageName,'uploads/product',$image_order);
						$image_order++;
						
						$thumb50 = 'uploads/product/thumb50/'.$newImageName;
						$this->common_model->product_image_resize($imagepath,$thumb50,850,700);
						
						//	Home - 100*121
						$thumb100 = 'uploads/product/thumb100_150/'.$newImageName;
						$this->common_model->product_image_resize($imagepath,$thumb100,100,121);
						$this->custom_log->write_log('custom_log','Resize image size is 100*121');
						
						//	Product List - 154*185
						$thumb200 = 'uploads/product/thumb150_200/'.$newImageName;
						$this->common_model->product_image_resize($imagepath,$thumb200,154,185);
						$this->custom_log->write_log('custom_log','Resize image size is 154*185');
						
						//	Product Full View - 288*350
						$thumb300 = 'uploads/product/thumb500_500/'.$newImageName;
						$this->common_model->product_image_resize($imagepath,$thumb300,500,500);
						$this->custom_log->write_log('custom_log','Resize image size is 500*500');	
					}
				}
			}
			
			$product_attr_type='product_detail'.$product_id;
			$productAttributeTypeId=$this->Sementic_product_m->add_product_attr_type($product_attr_type);
			foreach($detail->results[$key]->features as $key1=> $value)
			{
				$attribute_name=array(
										'productAttributeName'		=>	$key1,
										'productAttributeTypeId'	=>	$productAttributeTypeId,
										'createDt'					=>	date('Y-m-d h:i:s'),
										'active'					=>	1
										);
			$product_taxonomy_id=	$this->Sementic_product_m->add_product_attr_name($attribute_name);
				$this->Sementic_product_m->add_attribute_value($product_id,$product_taxonomy_id,$value);
				
				
			}
		
			$this->custom_log->write_log('custom_log',print_r($detail->results[$key]->images,true));
			
			/*******Add Product History********************/
			$returnArr = array(
							'product_name' 	   => $product_info['name'],
							'item_weight'  	   => '',
							'packaging_weight' => '',
							'brand_id'         => $product_info['brandId'],
							'lastCatId'        => '',
							'sizes'			   => '',
							'product_type'     => 2,
						);
			$productHistoryId = $this->product_m->add_product_history($product_id,$returnArr);
			$this->custom_log->write_log('custom_log','product history id is '.$productHistoryId);
			/*******Add Product History********************/

			redirect('retailer/semantics/product_listing/'.id_encrypt($product_id));
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
			redirect(base_url().'retailer/product_management/addEditProduct');
		}
		
		$product_id  			   = id_decrypt($product_id);
		$productList 			   = $this->product_m->product_image_list($product_id);
		
		$this->data['product_id']  = $product_id;
		$this->data['productList'] = $productList;
		$this->retailerCustomView('retailer/product_managements/addEditSemanticProductImage',$this->data);
	}
	
	public function product_listing($product_id)
	{
		
		$product_id=id_decrypt($product_id);
		$this->data['brand_list']=$this->brand_m->brand_list();
		if(isset($_POST) && !empty($_POST))
		{ 
			$rules=array(  
					array(
                     'field'   => 'name', 
                     'label'   => 'Product Name', 
                     'rules'   => 'trim|required|callback_check_product_name'
                  ),
				  );
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
		$this->Sementic_product_m->update_product($product_id,$_POST);
		if(!empty($_POST['feature']))
		{
			foreach($_POST['feature'] as $key =>$value)
			{
				$data[]=  array(
								  'orgProductAttributeId' => $key ,
								  'attributeValue'		  =>$value	
							   );
			}
			$this->db->update_batch('product_attribute',$data,'orgProductAttributeId');
		}	
		
		redirect('retailer/semantics/product_detail/'.id_encrypt($product_id));
		}
		}
		
		$this->data['product_data']=$this->Sementic_product_m->get_product_detail($product_id);
		$this->data['product_detail']=$this->product_m->product_attributes_details($product_id);
		//print_r($product_detail);
		$this->retailerCustomView('admin/semantics/test1',$this->data);
	}
	public function product_detail($product_id)
	{$product_id=id_decrypt($product_id);
		if(isset($_POST) && !empty($_POST))
		{
			$rules = array(
              
				  array(
                     'field'   => 'weight', 
                     'label'   => 'weight', 
                     'rules'   => 'trim|numeric|required'
                  ),
				  array(
                     'field'   => 'pakaging_material', 
                     'label'   => 'pakaging Material', 
                     'rules'   => 'trim|numeric|required'
                  ),
				   array(
                     'field'   => 'selectsize', 
                     'label'   => 'size permission', 
                     'rules'   => 'trim|numeric|required'
                  ),
				   array(
                     'field'   => 'selectcolor', 
                     'label'   => 'color', 
                     'rules'   => 'trim|numeric|required'
                  ),
				   array(
                     'field'   => 'level1', 
                     'label'   => 'level1', 
                     'rules'   => 'trim|required'
                  ),
               
            );
			$selectsize=$this->input->post('selectsize');
			$selectcolor=$this->input->post('selectcolor');
			if($selectsize==2){
			$rules[]=	 array(
                     'field'   => 'size', 
                     'label'   => 'size', 
                     'rules'   => 'trim|required'
                  );
			}
				if($selectcolor==2){
			$rules[]=	 array(
                     'field'   => 'color[]', 
                     'label'   => 'color', 
                     'rules'   => 'trim|required'
                  );
			}
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run())
			{
				$mrp=$this->input->post('mrp');
				$tax=$this->input->post('tax');
				if(isset($_POST['level6']) && !empty($_POST['level6']))
				{
					$category_id=$this->input->post('level6');
				}elseif(isset($_POST['level5']) && !empty($_POST['level5']))
				{
					$category_id=$this->input->post('level5');
				}elseif(isset($_POST['level4']) && !empty($_POST['level4']))
				{
					$category_id=$this->input->post('level4');
				}elseif(isset($_POST['level3'])  && !empty($_POST['level3']))
				{
					$category_id=$this->input->post('level3');
				}elseif(isset($_POST['level2']) && !empty($_POST['level2']))
				{
					$category_id=$this->input->post('level2');
				}elseif(isset($_POST['level1']) && !empty($_POST['level1']))
				{
					$category_id=$this->input->post('level1');
				}
				$product_data=$this->Sementic_product_m->get_product_detail($product_id);
				
			
				//$this->Sementic_product_m->add_tax($product_id,$tax);
				$size=$this->input->post('size');
				if(isset($_POST['color'])){
				$color=$this->input->post('color');
				
				if(!empty($color)){
					$this->product_m->delete_product_color($product_id);
				$this->product_m->update_product_color($product_id,$color);
				
				}
				}
				$this->Sementic_product_m->update_product_weight($product_id,$_POST,$size);
				$this->Sementic_product_m->product_category($product_id,$category_id);
				
				$productHistoryDet = $this->Sementic_product_m->last_semantics_product_history($product_id);
				$this->custom_log->write_log('custom_log','product history details is '.print_r($productHistoryDet,true));
				if(!empty($productHistoryDet))
				{
					$lastProductHistoryId = $productHistoryDet->productHistoryId;
					if($lastProductHistoryId)
					{
						$updateArr = array(
										'weight' 		 => $this->input->post('weight'),
										'shippingWeight' => $this->input->post('pakaging_material'),
										'categoryId'     => $category_id,
									 );
						$this->Sementic_product_m->update_semantic_product_history($lastProductHistoryId,$updateArr);
					}
				}
				
				redirect('retailer/semantics/addEditProductImage/'.id_encrypt($product_id));
				
			}
		}
			$this->data['colors']=$this->color_m->get_colors();
			$this->data['product_data']=$this->Sementic_product_m->get_product_detail($product_id);
		$this->data['catlist']=$this->segment_cat_m->segment_list();
				
		
		$this->retailerCustomView('admin/semantics/test2',$this->data);
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
			redirect(base_url().'retailer/product_management/addEditProductImage/'.$product_id);
		}
		
		$productImageId = id_decrypt($productImageId);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		$this->product_lib->delete_image($productImageId);
		redirect(base_url().'retailer/semantics/addEditProductImage/'.$product_id);
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
			redirect(base_url().'retailer/product_management');
		}
		
		$productImageId = id_decrypt($productImageId);
		$product_id     = id_decrypt($product_id);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		$this->product_lib->make_main_image($productImageId,$product_id);
		redirect(base_url().'retailer/semantics/addEditProductImage/'.id_encrypt($product_id));		
	}
	public function product_review($product_id)
	{
		$product_id=id_decrypt($product_id);
		if(isset($_POST) && !empty($_POST))
		{
			$this->Sementic_product_m->activate_product($product_id);
			$this->session->set_flashdata('success','successfully added product in the productlist');
			
			$productHistoryDet = $this->Sementic_product_m->last_semantics_product_history($product_id);
			$this->custom_log->write_log('custom_log','product history details is '.print_r($productHistoryDet,true));
			if(!empty($productHistoryDet))
			{
				$lastProductHistoryId = $productHistoryDet->productHistoryId;
				$this->Sementic_product_m->activate_semantic_product_history($lastProductHistoryId);
			}
			
			redirect('retailer/product_request_management');
		}
		$this->data['productcolorlist']=$this->product_m->get_product_color_list($product_id);
		$this->data['product_data']=$this->Sementic_product_m->get_product_detail($product_id);
		$this->data['product_detail']=$this->product_m->product_attributes_details($product_id);
		$this->retailerCustomView('admin/semantics/test3',$this->data);
	}
	public function test_m()
	{
		$random_password=getRandomUserName();
		echo $random_password;
	}
	public function update_attribute()
	{
		$key=array_keys($_POST);
		$data=array(
						'productAttributeName'	=>	$_POST[$key[0]]
						);
		$attribute_id=id_decrypt($key[0]);
		$this->db->where('productAttributeNameId',$attribute_id);
		$rs=$this->db->update('product_attribute_name',$data);
		echo json_encode($_POST);
	}
	function check_product_name($str)
	{

	$product_detail=$this->Sementic_product_m->get_product_detail_by_name($str);
	if (!empty($product_detail))
		{
			$this->form_validation->set_message('check_product_name', 'The %s already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
		public function add_Color()
	{
		$color=$_POST['color_value'];
		$color_id=$this->product_m->add_color($color);
			echo '  <div class="block-element">
																			<label>
																			 <input type="checkbox" name="color[]" value="'.$color_id.'">
																			 <small style="background-color:'.$color.'"></small>
																			  
																			</label> 
																		   </div> ';
	}
}