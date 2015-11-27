<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session','upload'));
		$this->CI->load->helper(array('url','form'));
		$this->CI->load->model('product_m');
		$this->CI->load->model('product_marketing_m');
		$this->CI->load->model('color_m');
	}
	
	public function product_list()
	{
		$returnArr = array();
		$returnArr['total'] = $this->CI->product_m->total_products();
		$returnArr['totalReq'] = $this->CI->product_m->total_products_request();
		$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
		
		return $returnArr;
	}
	
	public function product_ajaxFun($total)
	{
		$perPage	     = $this->CI->input->post('sel_no_entry');
		$productName     = trim($this->CI->input->post('productName'));			
		$productCategory = trim($this->CI->input->post('productCategory'));
		$brandName       = trim($this->CI->input->post('brandName'));
		$organizationId  = $this->CI->input->post('organizationId');
		$product_type    = $this->CI->input->post('product_type');
		$where 		     = '';
		
		//echo "<pre>"; print_r($_POST); exit;
		if(!empty($productName))
		{
			$productName  = trim(preg_replace('/^([\'"])(.*)\\1$/','\\2',$productName)); 
			$where = "trim(product.code) LIKE '".mysql_real_escape_string($productName)."%'";
		}
		if(!empty($productCategory))
		{
			if($where)
			{
				$where.= " AND trim(category.categoryCode) LIKE '".$productCategory."%'";
			}
			else
			{
				$where = "trim(category.categoryCode) LIKE '".$productCategory."%'";
			}
		}
		
		if((!empty($product_type))&&($product_type))
		{
			$productTypeStr = '';
			if($product_type==1)
			{
				$productTypeStr = '(product.productTypeId = 0 OR product.productTypeId = 1 OR product.productTypeId = 2)';
			}
			else
			{
				$productTypeStr = '(product.productTypeId = 3)';
			}
			
			if($where)
			{
				$where.= " AND ".$productTypeStr;
			}
			else
			{
				$where = $productTypeStr;
			}
		}
		if(!empty($brandName))
		{
			if($where)
			{
				$where.= " AND trim(brand.brandName) LIKE '".$brandName."%'";
			}
			else
			{
				$where = "trim(brand.brandName) LIKE '".$brandName."%'";
			}
		}
		$userType=$this->CI->session->userdata('userType');
		if($userType=="retailer")
		{
		if(empty($where))
		{
			$where='product.productTypeId != 3';
		}
		else
		{
			$where .=" AND product.productTypeId != 3";
		}
		}
		if(!empty($where))
		{
			$where = '('.$where.')';
			$total = $this->CI->product_m->total_products($where);
		}
		
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/product_management/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		
		$returnArr["links"]   = $this->CI->ajax_pagination->create_links();
		$returnArr['page']    = $page;
		$returnArr['list']    = $this->CI->product_m->products_list_test($page,$pagConfig['per_page'],$where);	
		$returnArr['organizationId'] = $organizationId;	
		return $returnArr;
	}
	
	public function main_product_ajaxFun($total)
	{
		$perPage	     = $this->CI->input->post('sel_no_entry');
		$productName     = $this->CI->input->post('productName');			
		$productCategory = $this->CI->input->post('productCategory');
		$brandName       = $this->CI->input->post('brandName');
		$organizationId  = $this->CI->input->post('organizationId');
		$where 		     = '';
		
		if(empty($perPage))
		{
			$perPage = 10;
		}
	
		if(!empty($productName))
		{
			$where = "product.code LIKE '".$productName."%'";
		}
		if(!empty($productCategory))
		{
			if($where)
			{
				$where.= " AND category.categoryCode LIKE '".$productCategory."%'";
			}
			else
			{
				$where = "category.categoryCode LIKE '".$productCategory."%'";
			}
		}
		if(!empty($brandName))
		{
			if($where)
			{
				$where.= " AND brand.brandName LIKE '".$brandName."%'";
			}
			else
			{
				$where = "brand.brandName LIKE '".$brandName."%'";
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
			$total = $this->CI->product_m->total_products($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/retailer_product_management/mainProductAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		
		$returnArr["links"]   = $this->CI->ajax_pagination->create_links();

		$returnArr['page']    = $page;
		$returnArr['list']    = $this->CI->product_m->products_list_test($page,$pagConfig['per_page'],$where);	
		$returnArr['organizationId'] = $organizationId;	
		return $returnArr;
	}

	public function add_edit_product($product_id)
	{
		$userType = $this->CI->session->userdata('userType');
		$this->CI->custom_log->write_log('custom_log','product id is '.$product_id);
		
		$returnArr 					   = array();
		$returnArr['item_weight']	   = '';	
		$returnArr['packaging_weight'] = '';	
		$returnArr['total_weight']     = '';
		$returnArr['level1ID'] 	  	   = 0;
		$returnArr['level2ID'] 	  	   = 0;
		$returnArr['level3ID'] 	   	   = 0;
		$returnArr['level4ID'] 	   	   = 0;
		$returnArr['level5ID'] 	   	   = 0;
		$returnArr['level6ID'] 	       = 0;
		$returnArr['level7ID'] 	       = 0;
		$returnArr['level8ID'] 	       = 0;
		$returnArr['level9ID'] 	       = 0;
		$returnArr['level10ID'] 	   = 0;
		$returnArr['description']      = '';
		$returnArr['brand_id']         = '';
		$returnArr['product_name']     = '';
		$returnArr['product_type']		='';
		$returnArr['product_id']       = $product_id;
		$returnArr['pageSubmit']       = 1;
		$returnArr['sizes']       	   = '';
		$returnArr['color']       	   = '';
		$returnArr['productcolorlist'] = $this->CI->product_m->get_product_color_list($product_id);
		
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			$returnArr['pageSubmit'] = 0;
			$this->CI->product_m->delete_product_color($product_id);
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			
			$rules = add_edit_product_rules();
			
			$returnArr['level1ID'] = $level1ID = $this->CI->input->post('level1ID');
			if(!empty($_POST['level2ID']))
			{
				$returnArr['level2ID'] = $this->CI->input->post('level2ID');
				$level1ID = $returnArr['level2ID'];
			}
			if(!empty($_POST['level3ID']))
			{
				$returnArr['level3ID'] = $this->CI->input->post('level3ID');
				$level1ID = $returnArr['level3ID'];
			}
			if(!empty($_POST['level4ID']))
			{
				$returnArr['level4ID'] = $this->CI->input->post('level4ID');
				$level1ID = $returnArr['level4ID'];
			}
			if(!empty($_POST['level5ID']))
			{
				$returnArr['level5ID'] = $this->CI->input->post('level5ID');
				$level1ID = $returnArr['level5ID'];
			}
			if(!empty($_POST['level6ID']))
			{
				$returnArr['level6ID'] = $this->CI->input->post('level6ID');
				$level1ID = $returnArr['level6ID'];
			}
			if(!empty($_POST['level7ID']))
			{
				$returnArr['level7ID'] = $this->CI->input->post('level7ID');
				$level1ID = $returnArr['level7ID'];
			}
			if(!empty($_POST['level8ID']))
			{
				$returnArr['level8ID'] = $this->CI->input->post('level8ID');
				$level1ID = $returnArr['level8ID'];
			}
			if(!empty($_POST['level9ID']))
			{
				$returnArr['level9ID'] = $this->CI->input->post('level9ID');
				$level1ID = $returnArr['level9ID'];
			}
			if(!empty($_POST['level10ID']))
			{
				$returnArr['level10ID'] = $this->CI->input->post('level10ID');
				$level1ID = $returnArr['level10ID'];
			}
			
			$returnArr['item_weight']	   = $this->CI->input->post('item_weight');	
			$returnArr['packaging_weight'] = $this->CI->input->post('weight_shipping');	
			$returnArr['total_weight']     = $this->CI->input->post('total_weight');
			$returnArr['product_name']     = $this->CI->input->post('product_name');
			$returnArr['description']      = '';
			$returnArr['brand_id']         = $this->CI->input->post('brand_id');
			$returnArr['lastCatId']        = $level1ID;
			$returnArr['sizes']	=	'';
			if(isset($_POST['product_type']))
			{
				$returnArr['product_type']=$this->CI->input->post('product_type');
			}
			
			if(isset($_POST['size']))
			{
				$returnArr['sizes'] = $this->CI->input->post('size');
			}
			
			if($_POST['selectsize']==1)
			{
				$returnArr['sizes']	= '';
					
			}
			else
			{
				$rules[] = array(
		                     'field'   => 'size', 
		                     'label'   => 'size', 
		                     'rules'   => 'trim|required'
		                  );
			}
			
			if($_POST['selectcolor']==2)
			{
				$rules[] = array(
                 	     	 'field'   => 'color[]', 
		                     'label'   => 'color', 
		                     'rules'   => 'trim|required'
                  			);
		if(isset($_POST['color']))
			{
				$returnArr['color'] = $this->CI->input->post('color');
			}
			}
			
			
	//	echo "<pre>"; print_r($rules); exit;
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if(!empty($product_id))
				{
					$this->CI->product_m->delete_product_color($product_id);
					$this->CI->product_m->delete_product_size($product_id);
					
					if($this->CI->product_m->update_product($product_id,$returnArr))
					{
						if(!empty($returnArr['color']))
						{
							$color = $returnArr['color'];
							if(!empty($color))
							{
								$this->CI->product_m->update_product_color($product_id,$color);
							
							}
						}
						$this->CI->product_m->update_product_category($product_id,$returnArr);
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_product'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_product'));
						
						/*******Add product size***********************/
						if(!empty($returnArr['sizes']))
						{
							$sizes = explode(',',$returnArr['sizes']);
							if(!empty($sizes))
							{
								$this->CI->product_m->update_product_size($product_id,$sizes);
							}
						}
						/*******Add product size***********************/
						
						/*******Add Product History********************/
						$productHistoryId = $this->CI->product_m->add_product_history($product_id,$returnArr);
						$this->CI->custom_log->write_log('custom_log','product history id is '.$productHistoryId);
						/*******Add Product History********************/
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_product'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_product'));											
					}
					redirect(base_url().$userType.'/product_management/addEditProductImage/'.id_encrypt($product_id));
				}
				else
				{
					$returnArr['verificationResultId'] = 1;
					
					if($returnArr['verificationResultId'])	
					{				
						$new_product_id = $this->CI->product_m->add_product($returnArr);
						
						$this->CI->custom_log->write_log('custom_log','New product id is '.$new_product_id);
						if($new_product_id)
						{
							if(isset($returnArr['color']))
							{
								$color = $returnArr['color'];
								if(!empty($color))
								{
									$this->CI->product_m->delete_product_color($new_product_id);
									$this->CI->product_m->update_product_color($new_product_id,$color);
								}
								else
								{
									$this->CI->product_m->delete_product_color($new_product_id);
								}
							}
							$this->CI->product_m->add_product_category($new_product_id,$returnArr);	
							$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_product'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_product'));
							
							/*******Add product size***********************/
							if(!empty($returnArr['sizes']))
							{
								$sizes = explode(',',$returnArr['sizes']);
								if(!empty($sizes))
								{
									$this->CI->product_m->delete_product_size($new_product_id);
									$this->CI->product_m->update_product_size($new_product_id,$sizes);
								}
								else
								{
									$this->CI->product_m->delete_product_size($new_product_id);
								}
							}
							/*******Add product size***********************/
							
							/*******Add Product History********************/
							$productHistoryId = $this->CI->product_m->add_product_history($new_product_id,$returnArr);
							$this->CI->custom_log->write_log('custom_log','product history id is '.$productHistoryId);
							/*******Add Product History********************/
						
							redirect(base_url().$userType.'/product_management/addEditProductImage/'.id_encrypt($new_product_id));
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_product'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product'));
							redirect(base_url().$userType.'/product_management/addEditProduct/'.id_encrypt($new_product_id));
						}
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_addVerificationResult'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_addVerificationResult'));
						redirect(base_url().'admin/product_management/addEditProduct');
					}
				}			
			}
		}
		
		if($returnArr['pageSubmit'])
		{
			$row = $this->CI->product_m->product_brand_image_category_tax_details_row($product_id);
			//echo "<pre>"; print_r($row); exit;
			$this->CI->custom_log->write_log('custom_log','product row details is '.print_r($row,true));
			if(!empty($row))
			{
				
					$returnArr['item_weight']	   = $row->weight;	
					$returnArr['packaging_weight'] = $row->shippingWeight;	
					$returnArr['total_weight']     = $returnArr['item_weight']+$returnArr['packaging_weight'];
					$returnArr['product_name']     = $row->code;
					$returnArr['description']      = $row->description;
					$returnArr['brand_id'] 		   = $row->brandId;
					$returnArr['product_sizes']				=		$row->sizes;
					$returnArr['product_type']		= $row->productTypeId;
					

					if(!empty($row->segId))
					{
						$returnArr['level1ID'] 	= $row->segId;
						$returnArr['level2ID'] 	= $row->catId;
						$returnArr['level3ID'] 	= $row->subCat1Id;
						$returnArr['level4ID'] 	= $row->subCat2Id;
						$returnArr['level5ID'] 	= $row->subCat3Id;
						$returnArr['level6ID'] 	= $row->subCat4Id;
						$returnArr['level7ID'] 	= $row->subCat5Id;
						$returnArr['level8ID'] 	= $row->subCat6Id;
					}
					elseif(!empty($row->catId))
					{
						$returnArr['level1ID'] 	= $row->catId;
						$returnArr['level2ID'] 	= $row->subCat1Id;
						$returnArr['level3ID'] 	= $row->subCat2Id;
						$returnArr['level4ID'] 	= $row->subCat3Id;
						$returnArr['level5ID'] 	= $row->subCat4Id;
						$returnArr['level6ID'] 	= $row->subCat5Id;
						$returnArr['level7ID'] 	= $row->subCat6Id;
						$returnArr['level8ID'] 	= $row->segId;
					}	
					elseif(!empty($row->subCat1Id))
					{
						$returnArr['level1ID'] 	= $row->subCat1Id;
						$returnArr['level2ID'] 	= $row->subCat2Id;
						$returnArr['level3ID'] 	= $row->subCat3Id;
						$returnArr['level4ID'] 	= $row->subCat4Id;
						$returnArr['level5ID'] 	= $row->subCat5Id;
						$returnArr['level6ID'] 	= $row->subCat6Id;
						$returnArr['level7ID'] 	= $row->segId;
						$returnArr['level8ID'] 	= $row->catId;
					}	
					elseif(!empty($row->subCat2Id))
					{
						$returnArr['level1ID'] 	= $row->subCat2Id;
						$returnArr['level2ID'] 	= $row->subCat3Id;
						$returnArr['level3ID'] 	= $row->subCat4Id;
						$returnArr['level4ID'] 	= $row->subCat5Id;
						$returnArr['level5ID'] 	= $row->subCat6Id;
						$returnArr['level6ID'] 	= $row->segId;
						$returnArr['level7ID'] 	= $row->catId;
						$returnArr['level8ID'] 	= $row->subCat1Id;
					}	
					elseif(!empty($row->subCat3Id))
					{
						$returnArr['level1ID'] 	= $row->subCat3Id;
						$returnArr['level2ID'] 	= $row->subCat4Id;
						$returnArr['level3ID'] 	= $row->subCat5Id;
						$returnArr['level4ID'] 	= $row->subCat6Id;
						$returnArr['level5ID'] 	= $row->segId;
						$returnArr['level6ID'] 	= $row->catId;
						$returnArr['level7ID'] 	= $row->subCat1Id;
						$returnArr['level8ID'] 	= $row->subCat2Id;
					}	
					elseif(!empty($row->subCat4Id))
					{
						$returnArr['level1ID'] 	= $row->subCat4Id;
						$returnArr['level2ID'] 	= $row->subCat5Id;
						$returnArr['level3ID'] 	= $row->subCat6Id;
						$returnArr['level4ID'] 	= $row->segId;
						$returnArr['level5ID'] 	= $row->catId;
						$returnArr['level6ID'] 	= $row->subCat1Id;
						$returnArr['level7ID'] 	= $row->subCat2Id;
						$returnArr['level8ID'] 	= $row->subCat3Id;
					}
					elseif(!empty($row->subCat5Id))
					{
						$returnArr['level1ID'] 	= $row->subCat5Id;
						$returnArr['level2ID'] 	= $row->subCat6Id;
						$returnArr['level3ID'] 	= $row->segId;
						$returnArr['level4ID'] 	= $row->catId;
						$returnArr['level5ID'] 	= $row->subCat1Id;
						$returnArr['level6ID'] 	= $row->subCat2Id;
						$returnArr['level7ID'] 	= $row->subCat3Id;
						$returnArr['level8ID'] 	= $row->subCat4Id;
					}
					elseif(!empty($row->subCat6Id))
					{
						$returnArr['level1ID'] 	= $row->subCat6Id;
						$returnArr['level2ID'] 	= $row->segId;
						$returnArr['level3ID'] 	= $row->catId;
						$returnArr['level4ID'] 	= $row->subCat1Id;
						$returnArr['level5ID'] 	= $row->subCat2Id;
						$returnArr['level6ID'] 	= $row->subCat3Id;
						$returnArr['level7ID'] 	= $row->subCat4Id;
						$returnArr['level8ID'] 	= $row->subCat5Id;
					}					
			}
		}
		$returnArr['colorlist']=$this->CI->color_m->get_colors();
		$returnArr['brand_list'] = $this->CI->brand_m->product_brand_list();
		$returnArr['catList'] = $this->CI->segment_cat_m->category_list();
	//echo "<pre>";	print_r($returnArr); exit;
		return $returnArr;
	}
	
	public function add_edit_product_attribute($product_id)
	{
		$userType = $this->CI->session->userdata('userType');
		$this->CI->custom_log->write_log('custom_log','product id is '.$product_id);
		
		$returnArr 					  = array();
		$returnArr['product_id']      = $product_id;
		$returnArr['pageSubmit']      = 1;
		$returnArr['attribute_name']  = '';
		$returnArr['attribute_value'] = '';
		$returnArr['post_form']		  = '';
		$returnArr['pageSubmit']      = 1;	
		
		if($_POST)
		{
			//echo "<pre>";	 print_r($_POST); exit;
			$returnArr['pageSubmit'] = 0;
			$returnArr['post_form']	 = $_POST;
			$this->CI->custom_log->write_log('custom_log','After Form Submit '.print_r($_POST,true));
			$rules = array(
						array(
								'field' => 'attribute_name[]',
								'label' => 'Attribute Name',
								'rules' => 'trim'
						)	,
						array(
								'field' => 'attribute_value[]',
								'label' => 'Attribute Value',
								'rules' => 'trim'
						)	
							);
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$this->CI->product_m->delete_product_attributes($product_id);
				
				$i = 0;
				$addArr = array();
				foreach($_POST['attribute_name'] as $key=>$value1)
				{	
					if((!empty($_POST['attribute_name'][$key]))&&(!empty($_POST['attribute_value'][$key])))
					{
						$addArr[$i]['productId']         = $product_id;
						$addArr[$i]['productTaxonomyId'] = 1;
						$addArr[$i]['attributeName']     = $_POST['attribute_name'][$key];
						$addArr[$i]['attributeValue']    = $_POST['attribute_value'][$key];
						$addArr[$i]['createDt']    		 = date('Y-m-d H:i:s');
						$addArr[$i]['lastModifiedDt']    = $this->CI->session->userdata('userId');
						$addArr[$i]['lastModifiedBy']    = date('Y-m-d H:i:s');
						$i++;			
					}
				}
				if(!empty($addArr))
				{
					$this->CI->product_m->add_product_attribute($addArr);
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_product_attribute'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_product_attribute'));
					redirect(base_url().$userType.'/product_management/productReview/'.id_encrypt($product_id));
				}
			}
			
			if(!empty($_POST['attribute_name']))
			{
				$i = 1000;
				foreach($_POST['attribute_name'] as $key=>$val)
				{
					if(!empty($_POST['attribute_value'][$key]))
					{
						$returnArr['attribute_name'][$i]  = $_POST['attribute_name'][$key];
						$returnArr['attribute_value'][$i] = $_POST['attribute_value'][$key];
						$i++;
					}
				}
			}
		}
		
		$attributeDetails = '';;
		if($returnArr['pageSubmit'])
		{
			$attributeDetails = $this->CI->product_m->admin_product_attributes_details($product_id);
			//echo "<pre>"; print_r($attributeDetails); exit;
			if(!empty($attributeDetails))
			{
				$i=1000;
				foreach($attributeDetails as $row)
				{
					if($row->attributeName!='')
					{
						$returnArr['attribute_name'][$i]  = $row->attributeName;
					}
					else
					{
						$returnArr['attribute_name'][$i]  = $row->productAttributeName;
					}
					$returnArr['attribute_value'][$i] = $row->attributeValue;
					$i++;
				}
			}
			else
			{
				$attributeDetails = $this->CI->product_m->admin_product_attributes_details($product_id);
				if(!empty($attributeDetails))
				{
					$i=100;
					foreach($attributeDetails as $row)
					{
						$returnArr['attribute_name'][$i]  = $row->attributeName;
						$returnArr['attribute_value'][$i] = $row->attributeValue;
						$i++;
					}
				}
			}
			
		}		
		//$returnArr['attributeDetails'] = $attributeDetails;
		//echo "<pre>"; print_r($returnArr); exit;
		return $returnArr;
	}
	
	public function product_review($product_id='')
	{
		$userType = $this->CI->session->userdata('userType');
		$this->CI->custom_log->write_log('custom_log','product id is '.$product_id);
		
		$returnArr 					     = array();
		$returnArr['product_name']	     = '';
		$returnArr['productDescription'] = '';
		$returnArr['upc']            	 = '';
		$returnArr['product_tax']		 = '';
		$returnArr['segment_name'] 	     = '';
		$returnArr['category_name']      = '';
		$returnArr['sub_category1_name'] = '';
		$returnArr['sub_category2_name'] = '';
		$returnArr['sub_category3_name'] = '';
		$returnArr['sub_category4_name'] = '';
		$returnArr['sub_category5_name'] = '';
		$returnArr['sub_category6_name'] = '';
		$returnArr['brandName']          = '';
		$returnArr['sizes']          = '';
		$returnArr['spid']		         = '';
		$returnArr['item_weight']		 = '';
		$returnArr['packing_weight']	 = '';
		$returnArr['total_weight']	     = '';
		$returnArr['productTypeId']	     = '';
		$returnArr['product_Type']	     = '';
		$returnArr['product_images']	 = array();
		$returnArr['product_attributes'] = array();
		$returnArr['keyFeatures']		 = array();
		$returnArr['mrp']         	     = '';
		$returnArr['active']             = '';
		$returnArr['brandStatus']		 = 0;
		$returnArr['sizes']			='';
		
		//$productAttrDetails = $this->CI->product_m->product_brand_image_category_details($product_id);
		$productAttrDetails = $this->CI->product_m->product_brand_image_category_tax_details($product_id);
		//echo "<pre>"; print_r($productAttrDetails); exit;
		$this->CI->custom_log->write_log('custom_log','product row details is '.print_r($productAttrDetails,true));
		if(!empty($productAttrDetails))
		{
			$i = 0;
			foreach($productAttrDetails as $row)
			{
				$returnArr['mrp']				 = $row->mrp;
				$returnArr['product_name']	     = $row->code;
				$returnArr['brandStatus']	     = $row->brandStatus;
				$returnArr['active']    	     = $row->active;
				$returnArr['product_tax']	     = $row->tax;
				$returnArr['productDescription'] = $row->description;
				$returnArr['upc'] 				 = $row->upc;	
				$returnArr['sizes'] 				 = $row->sizes;					
				$returnArr['brandName']			 = $row->brandName;
				$returnArr['spid']			 	 = $row->productId;
				$returnArr['item_weight']		 = $row->weight;
				$returnArr['sizes']					=$row->sizes;
				$returnArr['packing_weight']	 = $row->shippingWeight;
				$returnArr['total_weight']	     = $returnArr['item_weight']+$returnArr['packing_weight'];
				$returnArr['productTypeId']		 = $row->productTypeId;
				$returnArr['product_images'][$i]['imageName']    = $row->imageName;
				$returnArr['product_images'][$i]['displayOrder'] = $row->displayOrder;
				$i++;
				
				if(!empty($row->segName))
				{
					$returnArr['segment_name'] 	     = $row->segName;
					$returnArr['category_name']      = $row->catName;
					$returnArr['sub_category1_name'] = $row->subCat1Name;
					$returnArr['sub_category2_name'] = $row->subCat2Name;
					$returnArr['sub_category3_name'] = $row->subCat3Name;
					$returnArr['sub_category4_name'] = $row->subCat4Name;
					$returnArr['sub_category5_name'] = $row->subCat5Name;
					$returnArr['sub_category6_name'] = $row->subCat6Name;
				}
				elseif(!empty($row->catName))
				{
					$returnArr['segment_name'] 	     = $row->catName;
					$returnArr['category_name']      = $row->subCat1Name;
					$returnArr['sub_category1_name'] = $row->subCat2Name;
					$returnArr['sub_category2_name'] = $row->subCat3Name;
					$returnArr['sub_category3_name'] = $row->subCat4Name;
					$returnArr['sub_category4_name'] = $row->subCat5Name;
					$returnArr['sub_category5_name'] = $row->subCat6Name;
					$returnArr['sub_category6_name'] = $row->segName;					
				}	
				elseif(!empty($row->subCat1Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat1Name;
					$returnArr['category_name']      = $row->subCat2Name;
					$returnArr['sub_category1_name'] = $row->subCat3Name;
					$returnArr['sub_category2_name'] = $row->subCat4Name;
					$returnArr['sub_category3_name'] = $row->subCat5Name;
					$returnArr['sub_category4_name'] = $row->subCat6Name;
					$returnArr['sub_category5_name'] = $row->segName;
					$returnArr['sub_category6_name'] = $row->catName;	
				}	
				elseif(!empty($row->subCat2Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat2Name;
					$returnArr['category_name']      = $row->subCat3Name;
					$returnArr['sub_category1_name'] = $row->subCat4Name;
					$returnArr['sub_category2_name'] = $row->subCat5Name;
					$returnArr['sub_category3_name'] = $row->subCat6Name;
					$returnArr['sub_category4_name'] = $row->segName;
					$returnArr['sub_category5_name'] = $row->catName;
					$returnArr['sub_category6_name'] = $row->subCat1Name;	
				}	
				elseif(!empty($row->subCat3Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat3Name;
					$returnArr['category_name']      = $row->subCat4Name;
					$returnArr['sub_category1_name'] = $row->subCat5Name;
					$returnArr['sub_category2_name'] = $row->subCat6Name;
					$returnArr['sub_category3_name'] = $row->segName;
					$returnArr['sub_category4_name'] = $row->catName;
					$returnArr['sub_category5_name'] = $row->subCat1Name;
					$returnArr['sub_category6_name'] = $row->subCat2Name;	
				}	
				elseif(!empty($row->subCat4Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat4Name;
					$returnArr['category_name']      = $row->subCat5Name;
					$returnArr['sub_category1_name'] = $row->subCat6Name;
					$returnArr['sub_category2_name'] = $row->segName;
					$returnArr['sub_category3_name'] = $row->catName;
					$returnArr['sub_category4_name'] = $row->subCat1Name;
					$returnArr['sub_category5_name'] = $row->subCat2Name;
					$returnArr['sub_category6_name'] = $row->subCat3Name;	
				}
				elseif(!empty($row->subCat5Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat5Name;
					$returnArr['category_name']      = $row->subCat6Name;
					$returnArr['sub_category1_name'] = $row->segName;
					$returnArr['sub_category2_name'] = $row->catName;
					$returnArr['sub_category3_name'] = $row->subCat1Name;
					$returnArr['sub_category4_name'] = $row->subCat2Name;
					$returnArr['sub_category5_name'] = $row->subCat3Name;
					$returnArr['sub_category6_name'] = $row->subCat4Name;	
				}
				elseif(!empty($row->subCat6Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat6Name;
					$returnArr['category_name']      = $row->segName;
					$returnArr['sub_category1_name'] = $row->catName;
					$returnArr['sub_category2_name'] = $row->subCat1Name;
					$returnArr['sub_category3_name'] = $row->subCat2Name;
					$returnArr['sub_category4_name'] = $row->subCat3Name;
					$returnArr['sub_category5_name'] = $row->subCat4Name;
					$returnArr['sub_category6_name'] = $row->subCat5Name;	
				}					
			}
		}
		
		$returnArr['spid'] = 1000000000+$returnArr['spid'];
		if(!empty($returnArr['productTypeId']))
		{
			$attrDetails = $this->CI->product_m->product_attributes_details($product_id);	
			if(!empty($attrDetails))
			{
				foreach($attrDetails as $row)
				{
					$returnArr['product_Type'] = $row->product_type;
					if($row->keyFeature)
					{
						$returnArr['keyFeatures'][$row->attributeTypeId]['attributeType'] = $row->attributeType;
						$returnArr['keyFeatures'][$row->attributeTypeId]['attrbuteNMList'][$row->attributeNameId]['attributeName'] = $row->productAttributeName;
						$returnArr['keyFeatures'][$row->attributeTypeId]['attrbuteNMList'][$row->attributeNameId]['attributeValue'] = $row->attributeValue;
					}
					$returnArr['product_attributes'][$row->attributeTypeId]['attributeType'] = $row->attributeType;
						$returnArr['product_attributes'][$row->attributeTypeId]['attrbuteNMList'][$row->attributeNameId]['attributeName'] = $row->productAttributeName;
						$returnArr['product_attributes'][$row->attributeTypeId]['attrbuteNMList'][$row->attributeNameId]['attributeValue'] = $row->attributeValue;															
					
				}
			}
		}		
		//echo "<pre>"; print_r($attrDetails); exit;
		//$this->CI->custom_log->write_log('custom_log','attribute row is  '.print_r($attribut_row,true));
		return $returnArr;
	}
	
	public function admin_product_review($product_id='')
	{
		$userType = $this->CI->session->userdata('userType');
		$this->CI->custom_log->write_log('custom_log','product id is '.$product_id);
		
		
		$returnArr 					     = array();
		$returnArr['product_name']	     = '';
		$returnArr['productDescription'] = '';
		$returnArr['upc']            	 = '';
		$returnArr['product_tax']		 = '';
		$returnArr['segment_name'] 	     = '';
		$returnArr['category_name']      = '';
		$returnArr['sub_category1_name'] = '';
		$returnArr['sub_category2_name'] = '';
		$returnArr['sub_category3_name'] = '';
		$returnArr['sub_category4_name'] = '';
		$returnArr['sub_category5_name'] = '';
		$returnArr['sub_category6_name'] = '';
		$returnArr['brandName']          = '';
		$returnArr['spid']		         = '';
		$returnArr['item_weight']		 = '';
		$returnArr['packing_weight']	 = '';
		$returnArr['total_weight']	     = '';
		$returnArr['productTypeId']	     = '';
		$returnArr['product_Type']	     = '';
		$returnArr['product_images']	 = array();
		$returnArr['product_attributes'] = array();
		$returnArr['keyFeatures']		 = array();
		$returnArr['mrp']         	     = '';
		$returnArr['active']             = '';
		$returnArr['brandStatus']		 = 0;
		$returnArr['sizes']				 = '';
		$returnArr['productPrice']		 = '';
		//$productAttrDetails = $this->CI->product_m->product_brand_image_category_details($product_id);
		$productAttrDetails = $this->CI->product_m->product_brand_category_details($product_id);
		//echo "<pre>"; print_r($productAttrDetails); exit;
		$uriSeg5 = $this->CI->uri->segment(5);
		
		/***************add product of psudo in retailer inventory*************/
		if((!empty($productAttrDetails->productTypeId))&&($productAttrDetails->productTypeId==3))
		{
			if(($this->CI->session->userdata('userType')=='superadmin')||($this->CI->session->userdata('userType')=='admin')||($this->CI->session->userdata('userType')=='cse'))
			{
				$checkAlreadyInventroy = $this->CI->product_m->check_pseudo_organization_product_inventory($product_id);
				$this->CI->custom_log->write_log('custom_log','CHECk pseudo product inventory is '.print_r($checkAlreadyInventroy,true));
						
				if(!empty($checkAlreadyInventroy))
				{
					$returnArr['productPrice'] = $checkAlreadyInventroy->currentPrice;
				}
				
				if($_POST)	
				{
					$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
					$returnArr['productPrice'] = $this->CI->input->post('product_price');
					$rules = add_pseudo_product_rules();
					$this->CI->form_validation->set_rules($rules);
					$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
					if($this->CI->form_validation->run())
					{
						if(!empty($checkAlreadyInventroy))
						{
							$organizationProductId = $checkAlreadyInventroy->organizationProductId;
							$this->CI->product_m->update_pseudo_organization_product($organizationProductId,$returnArr['productPrice']);
							$this->CI->custom_log->write_log('custom_log','update organization product id is '.$organizationProductId);
						}
						else
						{
							$organizationProductId = $this->CI->product_m->add_pseudo_organization_product($product_id,$returnArr['productPrice']);
							$this->CI->custom_log->write_log('custom_log','organization product id is '.$organizationProductId);
						}
						
						/*********Inventory History Start******************/
						$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
						$inventoryHistoryId = $this->CI->product_m->add_pseudo_product_inventory_history($product_id,$organizationProductId,$returnArr['productPrice']);
						$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
						/*********Inventory History End  ******************/
				
						if($organizationProductId)
						{
							$organizationColorIdArray = array();
							$organizationSizeIdArray  = array();
							$productColors = $this->CI->product_m->product_all_color($product_id);	
							$this->CI->custom_log->write_log('custom_log','product colors '.print_r($productColors,true));
							
							$productSizes = $this->CI->product_m->product_all_size($product_id);	
							$this->CI->custom_log->write_log('custom_log','product size '.print_r($productSizes,true));
							
							if(!empty($productSizes))
							{
								foreach($productSizes as $sizeRow)
								{
									$organizationProductStockId = $this->CI->product_m->add_organization_size_stock($organizationProductId,1000000000,$sizeRow->productSizeId);
									$this->CI->custom_log->write_log('custom_log','organization product size stock id is '.$organizationProductStockId);
									$organizationSizeIdArray[$organizationProductStockId]['id'] = $organizationProductStockId;
									$organizationSizeIdArray[$organizationProductStockId]['productSizeId'] = $sizeRow->productSizeId;
								}
							}
														
							if(!empty($productColors))
							{
								foreach($productColors as $colorRow)
								{
									$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,1000000000,$colorRow->colorId);
									$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
									$organizationColorIdArray[$organizationColorId]['id'] = $organizationColorId;
									$organizationColorIdArray[$organizationColorId]['colorId'] = $colorRow->colorId;
								
								}
							}
							
							/*********organziation product color size combination history***************************/
							if((!empty($organizationColorIdArray))&&(!empty($organizationSizeIdArray)))
							{
								foreach($organizationColorIdArray as $colorId=>$colorVal)
								{
									foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
									{
										$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,$sizeId,$colorVal['colorId'],$sizeVal['productSizeId'],1000000000);
										$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
									}
								}
							}
							elseif(!empty($organizationColorIdArray))
							{
								foreach($organizationColorIdArray as $colorId=>$colorVal)
								{
									$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,0,$colorVal['colorId'],0,1000000000);
									$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
								}
							}
							elseif(!empty($organizationSizeIdArray))
							{
								foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
								{
									$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,0,$sizeId,0,$sizeVal['productSizeId'],1000000000);
									$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
								}
							}
							/*********organziation product color size combination history***************************/
							$uriSeg5 = 'save';
						}
						else
						{
							$this->CI->session->set_flashdata('error','inventory not create');
							$this->CI->custom_log->write_log('custom_log','inventory not create');
							redirect(base_url().$this->CI->session->userdata('userType').'/product_management');
						}
					}
				}
			}
		}
		/***************add product of psudo in retailer inventory*************/
				
		if($uriSeg5=='save')
		{
			if(($this->CI->session->userdata('userType')=='superadmin')||($this->CI->session->userdata('userType')=='admin'))
			{
				$verificationResultId = 2;
				if(!empty($productAttrDetails))
				{
					$veriResId = $productAttrDetails->verificationResultId;
					if(($veriResId==3)||($veriResId==4))
					{
						$verificationResultId = 5;
					}
				}
				
			}					
			elseif($this->CI->session->userdata('userType')=='retailer')
			{
				$verificationResultId = 3;
			}
			elseif($this->CI->session->userdata('userType')=='cse')
			{
				$verificationResultId = 4;
			}
			
			$this->CI->db->where('productId',$product_id);
			$this->CI->db->update('product',array('verificationResultId' => $verificationResultId,'lastModifiedBy' => $this->CI->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
			
			$productHistoryDet = $this->CI->product_m->last_product_history($product_id);
			$this->CI->custom_log->write_log('custom_log','product history details is '.print_r($productHistoryDet,true));
			
			if(!empty($productHistoryDet))
			{
				$lastProductHistoryId = $productHistoryDet->productHistoryId;
				if($lastProductHistoryId)
				{
					$this->CI->product_m->update_varification_history($lastProductHistoryId,$verificationResultId);
				}
			}
			
			$this->CI->session->set_flashdata('success','Product added successfully');
			$this->CI->custom_log->write_log('custom_log','Product added successfully');
			
			if($this->CI->session->userdata('userType')=='retailer')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/product_request_management');
			}
			else
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/product_management');	
			}
		}
		
		$this->CI->custom_log->write_log('custom_log','product row details is '.print_r($productAttrDetails,true));
		if(!empty($productAttrDetails))
		{	
			$returnArr['product_name']	     = $productAttrDetails->code;
			$returnArr['brandStatus']	     = $productAttrDetails->brandStatus;
			$returnArr['active']    	     = $productAttrDetails->active;
			$returnArr['brandName']			 = $productAttrDetails->brandName;
			$returnArr['spid']			 	 = $productAttrDetails->productId;
			$returnArr['item_weight']		 = $productAttrDetails->weight;
			$returnArr['packing_weight']	 = $productAttrDetails->shippingWeight;
			$returnArr['total_weight']	     = $returnArr['item_weight']+$returnArr['packing_weight'];
			$returnArr['productTypeId']		 = $productAttrDetails->productTypeId;
			
			$parentCatDet = $this->CI->segment_cat_m->category_parent_list($productAttrDetails->categoryId);
			if(!empty($parentCatDet))
			{
				$i = 1;
				foreach($parentCatDet as $row)
				{
					if($i==1)
					{
						$returnArr['segment_name'] = $row->categoryCode;
					}
					elseif($i==2)
					{
						$returnArr['category_name'] = $row->categoryCode;
					}
					elseif($i==3)
					{
						$returnArr['sub_category1_name'] = $row->categoryCode;
					}
					elseif($i==4)
					{
						$returnArr['sub_category2_name'] = $row->categoryCode;
					}
					elseif($i==5)
					{
						$returnArr['sub_category3_name'] = $row->categoryCode;
					}
					elseif($i==6)
					{
						$returnArr['sub_category4_name'] = $row->categoryCode;
					}
					elseif($i==7)
					{
						$returnArr['sub_category5_name'] = $row->categoryCode;
					}
					elseif($i==8)
					{
						$returnArr['sub_category6_name'] = $row->categoryCode;
					}
					$i++;
				}
			}
		}
		
		$returnArr['product_images'] = array();
		$productImages = $this->CI->product_m->product_images($product_id);
		if(!empty($productImages))
		{
			$i = 0;
			foreach($productImages as $row)
			{	
				$returnArr['product_images'][$i]['imageName']    = $row->imageName;
				$returnArr['product_images'][$i]['displayOrder'] = $row->displayOrder;	
				$i++;
			}
		}
		
		//$returnArr['marketing_product']=$this->CI->product_m->get_marketing_product_detail($product_id);
		$returnArr['marketing_product']=$this->CI->product_m->get_marketing_product_detail_for_product($product_id);
		$returnArr['spid'] = 1000000000+$returnArr['spid'];
		$attrDetails = '';
		$attrDetails = $this->CI->product_m->admin_product_attributes_details($product_id);	
		//echo "<pre>"; print_r($returnArr['marketing_product']); exit;
		//echo "<pre>"; print_r($returnArr['attrDetails']); exit;
		if(!empty($attrDetails))
		{
			$i = 0;
			foreach($attrDetails as $row)
			{
				if(!empty($row->attributeName))
				{
					$returnArr['attributeName'][$i] = $row->attributeName;
				}
				else
				{
					$returnArr['attributeName'][$i] = $row->productAttributeName;
				}
				$returnArr['attributeValue'][$i] = $row->attributeValue;
				$i++;
			}
		}
		$returnArr['productcolorlist'] = $this->CI->product_m->get_product_color_list($product_id);
		$returnArr['sizes']			   = $this->CI->product_m->product_all_size($product_id);
			
		$returnArr['attrDetails'] = $attrDetails;
		return $returnArr;
	}
	
	public function upload_product_image($product_id)
	{
		$result = '';
		if(isset($_FILES['myfile']))
		{	
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->CI->currentTimestamp+new_random_password()).'.'.$extension;
			
			$config['upload_path']   = './uploads/product/'; 
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $newImageName;
			
			$this->CI->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
			$this->CI->upload->initialize($config);
			if(!$this->CI->upload->do_upload('myfile'))
			{
				$result = $this->CI->upload->display_errors();			
				$this->CI->custom_log->write_log('custom_log','file upload error is '.$this->CI->upload->display_errors());
			}
			else
			{
				$imagepath = 'uploads/product/'.$newImageName ;
				$thumb50   = 'uploads/product/thumb50/'.$newImageName;
				$this->CI->common_model->resize($imagepath,$thumb50,$newHt=850,$newWd=700);
				
				$product_image_id = $this->CI->product_m->add_product_image($newImageName,$product_id);
				$this->CI->custom_log->write_log('custom_log','product image creat id is '.$product_image_id);
				if($product_image_id)
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_product_image'));
					$result = $this->CI->lang->line('success_add_product_image');
				}
				else
				{
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product_image'));
					$result = $this->CI->lang->line('error_add_product_image');
				}				
			}				
		}
		return $result;
	}
	
	public function multiple_upload_product_image($product_id)
	{
		$result = array('success' => 0,'message' => '');
		if(isset($_FILES['myfile']))
		{	
			//echo "<pre>"; print_r($_FILES); exit;
			$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->CI->currentTimestamp+new_random_password()).'.'.$extension;
			
			$config['upload_path']   = './uploads/product/'; 
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $newImageName;
			
			list($width, $height) = getimagesize($_FILES['myfile']['tmp_name']);
			$this->CI->custom_log->write_log('custom_log','Uploaded image widht is '.$width.' and height is '.$height);
						
			if(((!empty($width))&&($width>=500))&&((!empty($height))&&($height>=500)))
			{
				$this->CI->custom_log->write_log('custom_log','upload file array is '.print_r($config,true));
				$this->CI->upload->initialize($config);
				if(!$this->CI->upload->do_upload('myfile'))
				{
					$result['message'] = $this->CI->upload->display_errors();			
					$this->CI->custom_log->write_log('custom_log','file upload error is '.$this->CI->upload->display_errors());
					$this->CI->session->set_flashdata('error',$this->CI->upload->display_errors());
				}
				else
				{
					$imagepath = 'uploads/product/'.$newImageName ;
					$thumb50   = 'uploads/product/thumb50/'.$newImageName;
					$this->CI->common_model->product_image_resize($imagepath,$thumb50,850,700);
					
					//	Home - 100*121
					$thumb100 = 'uploads/product/thumb100_150/'.$newImageName;
					$this->CI->common_model->product_image_resize($imagepath,$thumb100,100,121);
					$this->CI->custom_log->write_log('custom_log','Resize image size is 100*121');
					
					//	Product List - 154*185
					$thumb200 = 'uploads/product/thumb150_200/'.$newImageName;
					$this->CI->common_model->product_image_resize($imagepath,$thumb200,154,185);
					$this->CI->custom_log->write_log('custom_log','Resize image size is 154*185');
					
					//	Product Full View - 288*350
					$thumb300 = 'uploads/product/thumb500_500/'.$newImageName;
					$this->CI->common_model->product_image_resize($imagepath,$thumb300,500,500);
					$this->CI->custom_log->write_log('custom_log','Resize image size is 500*500');					
					
					$product_image_id = $this->CI->product_m->add_product_image($newImageName,$product_id);
					$this->CI->custom_log->write_log('custom_log','product image creat id is '.$product_image_id);
					if($product_image_id)
					{
						$result['success'] = 1;
						$result['message'] = 'Image add successfully';
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_product_image'));
					}
					else
					{
						$result['message'] = 'Image not add';
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product_image'));
						$this->CI->session->set_flashdata('error','Image not add');
					}				
				}
			}
			else
			{
				$result['message'] = 'Please Upload image Height & width is more then or equal to = 500X500';
				$this->CI->session->set_flashdata('error','Please Upload image Height & width is more then or equal to = 500X500');
			}			
		}
		$this->CI->custom_log->write_log('custom_log','Result is '.print_r($result,true));
		
		return $result;
	}
	
	public function delete_image($productImageId)
	{
		$prdImageRes = $this->CI->product_m->single_product_image($productImageId);			
		$this->CI->custom_log->write_log('custom_log','product image details '.print_r($prdImageRes,true));
		if(!empty($prdImageRes))
		{
			$prdImageName = $prdImageRes->imageName;
			if($this->CI->product_m->delete_image($productImageId))
			{
				if((!empty($prdImageName))&&(file_exists('uploads/product/thumb50/'.$prdImageName)))
				{
					//unlink('uploads/product/thumb50/'.$prdImageName);
					//unlink('uploads/product/'.$prdImageName);
				}
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_delete_product_image'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_delete_product_image'));
			}
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_delete_product_image'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_delete_product_image'));
			}
		}
	}
	
	public function make_main_image($productImageId,$product_id)
	{
		$prdImageRes = $this->CI->product_m->single_product_image($productImageId);
		$this->CI->custom_log->write_log('custom_log','product image details '.print_r($prdImageRes,true));
		
		if(!empty($prdImageRes))
		{
			$this->CI->product_m->product_image_not_main($product_id);
			if($this->CI->product_m->product_main_image($productImageId))
			{
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_main_product_image'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_main_product_image'));
			}
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_main_product_image'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_main_product_image'));
			}
		}
	}
	
	public function add_inventory($organizationId,$productId)
	{
		$userType = $this->CI->session->userdata('userType');
		
		$returnArr 					     = array();
		$returnArr['stock'] 	         = '';
		$returnArr['sellPrice'] 	     = '';
		$returnArr['spacePointComisson'] = '';
		$returnArr['retailerPrice']		 = '';
		$returnArr['displayPrice']		 = '';
		$returnArr['organizationId']     = $organizationId;
		$returnArr['productId'] 	     = $productId;
		$returnArr['productName'] 		 = '';
		$returnArr['productDescription'] = '';
		$returnArr['imageName'] 		 = '';
		$returnArr['availableSize']		 = '';
		$returnArr['product_size']    = '';
		$returnArr['productcolorlist']		=	$this->CI->product_m->get_product_color_list($productId);
		
		$productDetails = $this->CI->product_m->product_brand_image_category_tax_details_row($productId);
		if(!empty($productDetails))
		{
			$returnArr['productName'] 		 = $productDetails->code;
			$returnArr['productDescription'] = $productDetails->description;
			$returnArr['imageName'] 		 = $productDetails->imageName;
			$returnArr['product_size']    = $productDetails->sizes;
		}
		
		$inventoryDet = $this->CI->product_m->organization_with_product($organizationId,$productId);
		if(!empty($inventoryDet))
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_inventory_already'));
			if($this->CI->session->userdata('userType')=='retailer')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/product_management');
			}
			if($this->CI->session->userdata('userType')=='cse')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId));	
			}
		}
		
		if($_POST)
		{
			$rules = add_inventory_rules();
		$returnArr['productcolorlist']=	array_filter($returnArr['productcolorlist']);
			if(!empty($returnArr['productcolorlist']))
			{
				$rules[]=array(
										'field' => 'availablecolor[]',
										'label' => 'color',
										'rules' => 'trim|required'
									);
			}
			if(isset($returnArr['product_size']) && (!empty($returnArr['product_size']))){
			$sizesarray=str_replace(',','',$returnArr['product_size']);
			}else
			{
			$sizesarray='';	
			}
				if(isset($sizesarray) && !empty($sizesarray))
			{
				$rules[]=array(
										'field' => 'availablesize[]',
										'label' => 'size',
										'rules' => 'trim|required'
									);
			}
			$returnArr['stock']     		 = $this->CI->input->post('stock');
			$returnArr['sellPrice'] 		 = $this->CI->input->post('sellPrice');
			$returnArr['spacePointComisson'] = $this->CI->input->post('spacePointComisson');
			$returnArr['retailerPrice']      = $this->CI->input->post('retailerPrice');
			$returnArr['displayPrice'] 		 = $this->CI->input->post('displayPrice');
			$returnArr['stockvalue']         = $returnArr['stock'];
			$available_color                 = '';
			
			if(isset($_POST['availablesize']))
			{
				$sizeArray = $this->CI->input->post('availablesize');
				$available_size=array_values($sizeArray);
				$stockmultiplier=count($available_size);
				
				$returnArr['stock']=$returnArr['stock']*$stockmultiplier;
				$returnArr['availablesize']=implode(',',$available_size);
			}
			if(isset($_POST['availablecolor']))
			{
				$colorArray = $this->CI->input->post('availablecolor');
				$available_color=array_values($colorArray);
				$colormultiplier=count($available_color);
			//	$returnArr['stockvalue']=	$returnArr['stock'];
				$returnArr['stock']=$returnArr['stock']*$colormultiplier;
				//$returnArr['availablecolor']=implode(',',$available_size);
			} //echo "<pre>"; print_r($colorArray); exit;
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$organizationProductId = $this->CI->product_m->add_organization_product($organizationId,$productId,$returnArr);
				/*********Inventory History Start******************/
				$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
				$returnArr['organizationProductId'] = $organizationProductId;
				$returnArr['organizationId']        = $organizationId;
				$returnArr['productId']             = $productId;
				$returnArr['quantity']              = $returnArr['stock'];
				$returnArr['unitPrice']             = $returnArr['sellPrice'];
				$returnArr['act']		            = 1;
				$inventoryHistoryId = $this->CI->product_m->add_inventory_history($returnArr);
				$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
				/*********Inventory History End  ******************/
				
				$this->CI->custom_log->write_log('custom_log','new organizationProductId is '.$organizationProductId);
				if($organizationProductId)
				{
					if(!empty($sizeArray))
					{
						foreach($sizeArray as $size)
						{
							$organizationStockId=$this->CI->product_m->add_size_stock($organizationProductId,$returnArr['stockvalue'],$size,$available_color );
						}
					}
					elseif(!empty($colorArray))
					{
						$organizationStockId = $this->CI->product_m->add_color_stock($organizationProductId,$returnArr['stockvalue'],$colorArray);						
					}
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_inventory'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_inventory'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_inventory'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_inventory'));	
				}	
				
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId));					
			}
			else{
				//print_r($this->CI->form_validation->error_array());
			}
		}
		return $returnArr;
	}
	
	public function add_product_inventory($organizationId,$productId)
	{
		$userType = $this->CI->session->userdata('userType');
		
		$returnArr 					         = array();
		$returnArr['stock'] 	             = '';
		$returnArr['retailerQuotePrice']     = '';
		$returnArr['retailerPrice']          = '';
		$returnArr['spacePointeCommission1'] = '';
		$returnArr['spacePointeCommission2'] = '';
		$returnArr['cashAdminPrice']		 = '';		
		$returnArr['displayPrice']		     = '';
		$returnArr['organizationId']         = $organizationId;
		$returnArr['productId'] 	         = $productId;
		$returnArr['availableSize']		     = '';
		$returnArr['product_size']           = '';
		$returnArr['catCommission1']         = 0;
		$returnArr['catCommission2']         = 0;
		$returnArr['productWeight']          = 0;
		$returnArr['productcolorlist'] 		 = $this->CI->product_m->get_product_color_list($productId);
		
		$productDetails = $this->CI->product_m->product_brand_image_category_details_row($productId);
		//echo "<pre>"; print_r($productDetails); exit;
		if(!empty($productDetails))
		{
			$returnArr['productName'] 		 = $productDetails->code;
			$returnArr['productDescription'] = $productDetails->description;
			$returnArr['imageName'] 		 = $productDetails->imageName;
			$returnArr['product_size']       = $productDetails->sizes;
			$returnArr['productWeight']      = $productDetails->weight+$productDetails->shippingWeight;
		
			$commissionDetails = $this->CI->segment_cat_m->parent_category_with_commission($productDetails->categoryId);
			//echo "<pre>"; print_r($commissionDetails); exit;
			$this->CI->custom_log->write_log('custom_log','commission details is '.print_r($commissionDetails,true));
			
			if(!empty($commissionDetails))
			{
				$returnArr['catCommission1'] = $commissionDetails->commission;
				$returnArr['catCommission2'] = $commissionDetails->spacepointeCommission2;
				
				$shippRateDet = $this->CI->shipping_m->shipping_rate_with_weight($returnArr['productWeight']);
				$this->CI->custom_log->write_log('custom_log','shipping rate details is '.print_r($shippRateDet,true));
				//echo "<pre>"; print_r($shippRateDet); exit;	
				if(!empty($shippRateDet))
				{
					if((!empty($returnArr['productWeight']))&&($returnArr['productWeight']>10))
					{
						$returnArr['cashAdminPrice'] = (($shippRateDet->minAmount*$returnArr['productWeight'])+($shippRateDet->maxAmoount*$returnArr['productWeight']))/2;	
					}
					else
					{
						$returnArr['cashAdminPrice'] = ($shippRateDet->minAmount+$shippRateDet->maxAmoount)/2;
					}
				}
			}
		}
		
		$inventoryDet = $this->CI->product_m->organization_with_product_details($organizationId,$productId);
		$this->CI->custom_log->write_log('custom_log','inventory details is '.print_r($inventoryDet,true));
		//echo "<pre>"; print_r($inventoryDet); exit;
		if(!empty($inventoryDet))
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_inventory_already'));
			if($this->CI->session->userdata('userType')=='retailer')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/product_management');
			}
			if($this->CI->session->userdata('userType')=='cse')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId));	
			}
		}
		
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log','submit form is '.print_r($_POST,true));
			$rules = add_product_inventory_rules();
			$returnArr['productcolorlist'] = array_filter($returnArr['productcolorlist']);
			
			if(!empty($returnArr['productcolorlist']))
			{
				$rules[] = array(
								'field' => 'availablecolor[]',
								'label' => 'color',
								'rules' => 'trim|required'
							);
			}
			
			$sizesarray = '';
			if(isset($returnArr['product_size']) && (!empty($returnArr['product_size'])))
			{
				$sizesarray = str_replace(',','',$returnArr['product_size']);
			}
			
			if(isset($sizesarray) && !empty($sizesarray))
			{
				$rules[] = array(
								'field' => 'availablesize[]',
								'label' => 'size',
								'rules' => 'trim|required'
							);
			}
			
			$returnArr['stock']                  = $this->CI->input->post('stock');
			$returnArr['retailerQuotePrice']     = $this->CI->input->post('retailerQuotePrice');
			$returnArr['retailerPrice']          = $this->CI->input->post('retailerPrice');
			$returnArr['spacePointeCommission1'] = $this->CI->input->post('spacePointeCommission1');
			$returnArr['spacePointeCommission2'] = $this->CI->input->post('spacePointeCommission2');
			$returnArr['cashAdminPrice']		 = $this->CI->input->post('cashAdminPrice');		
			$returnArr['displayPrice']		     = $this->CI->input->post('displayPrice');
			$returnArr['stockvalue']             = $returnArr['stock'];
			$available_color                     = '';
			
			if(isset($_POST['availablesize']))
			{
				$sizeArray       = $this->CI->input->post('availablesize');
				$available_size  = array_values($sizeArray);
				$stockmultiplier = count($available_size);
				
				$returnArr['stock']         = $returnArr['stock']*$stockmultiplier;
				$returnArr['availablesize'] = implode(',',$available_size);
			}
			
			if(isset($_POST['availablecolor']))
			{
				$colorArray         = $this->CI->input->post('availablecolor');
				$available_color    = array_values($colorArray);
				$colormultiplier    = count($available_color);
				$returnArr['stock'] = $returnArr['stock']*$colormultiplier;
			}
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$organizationProductId = $this->CI->product_m->add_organization_product($organizationId,$productId,$returnArr);
				$this->CI->custom_log->write_log('custom_log','organization product id is '.$organizationProductId);
				
				/*********Inventory History Start******************/
				$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
				$returnArr['organizationProductId'] = $organizationProductId;
				$returnArr['organizationId']        = $organizationId;
				$returnArr['productId']             = $productId;
				$inventoryHistoryId = $this->CI->product_m->add_inventory_history($returnArr);
				$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
				/*********Inventory History End  ******************/
				
				if($organizationProductId)
				{
					$organizationColorIdArray = array();
					$organizationSizeIdArray  = array();
							
					if(!empty($sizeArray))
					{
						foreach($sizeArray as $size)
						{
							$organizationStockId = $this->CI->product_m->add_size_stock($organizationProductId,$returnArr['stockvalue'],$size,$available_color);
							
							/***add organization product size stock history**/
							$productSizeDet = $this->CI->product_m->check_product_size($productId,$size);
							$this->CI->custom_log->write_log('custom_log','produc size details is '.print_r($productSizeDet,true));
							if(!empty($productSizeDet))
							{
								$organizationProductStockId = $this->CI->product_m->add_organization_size_stock($organizationProductId,$returnArr['stockvalue'],$productSizeDet->productSizeId);
								$this->CI->custom_log->write_log('custom_log','organization product size stock id is '.$organizationProductStockId);
								$organizationSizeIdArray[$organizationProductStockId] = $organizationProductStockId;
							}
							/***add organization product size stock history**/
						}
					}
					elseif(!empty($colorArray))
					{
						$organizationStockId = $this->CI->product_m->add_color_stock($organizationProductId,$returnArr['stockvalue'],$colorArray);						
					}
					
					
					if(!empty($colorArray))
					{
						/***add organization product color stock history**/
						if((!empty($available_color))&&(is_array($available_color)))
						{
        					foreach($available_color as $singlecolor) 
							{
								$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$returnArr['stockvalue'],$singlecolor);
								$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
								$organizationColorIdArray[$organizationColorId] = $organizationColorId;
							}
				        }
						elseif(!empty($available_color)) 
						{
							$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$returnArr['stockvalue'],$available_color);
							$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
							$organizationColorIdArray[$organizationColorId] = $organizationColorId;
						}

						/***add organization product color stock history**/
					}
					
					/*********organziation product color size combination history***************************/
					if((!empty($organizationColorIdArray))&&(!empty($organizationSizeIdArray)))
					{
						foreach($organizationColorIdArray as $colorId)
						{
							foreach($organizationSizeIdArray as $sizeId)
							{
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,$sizeId);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
					}
					elseif(!empty($organizationColorIdArray))
					{
						foreach($organizationColorIdArray as $colorId)
						{
							$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,0);
							$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
						}
					}
					elseif(!empty($organizationSizeIdArray))
					{
						foreach($organizationSizeIdArray as $sizeId)
						{
							$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,0,$sizeId);
							$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
						}
					}
					/*********organziation product color size combination history***************************/
					
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_inventory'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_inventory'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_inventory'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_inventory'));	
				}	
				
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId));					
			}			
		} 
		
		//echo "<pre>"; print_r($returnArr); exit;
		return $returnArr;
	}
	
	public function product_price_calculate()
	{
		$result	= array(
					'retailerQuotedPrice'    => 0,
					'retailerPrice'          => 0,
					'spacePointeCommission1' => 0,
					'spacePointeCommission2' => 0,
					'cashAdminPrice'         => 0,
					'displayPrice'           => 0,
					'message'                => '',
					'status'                 => 1
				  );
				  
		$retailerQuotedPrice = $this->CI->input->post('retailerQuotedPrice');
		$catCommission1      = $this->CI->input->post('catCommission1');
		$catCommission2      = $this->CI->input->post('catCommission2');
		$cashAdminPrice      = $this->CI->input->post('cashAdminPrice');
		$productWeight       = $this->CI->input->post('productWeight');
		
		if(!empty($retailerQuotedPrice))
		{
			if(is_numeric($retailerQuotedPrice))
			{
				$result['status'] = 1;
				$priceRangeDet    = $this->CI->segment_cat_m->get_price_range($retailerQuotedPrice);	
				$this->CI->custom_log->write_log('custom_log','price range details is '.print_r($priceRangeDet,true));
				if(!empty($priceRangeDet))
				{
					if($priceRangeDet->spacePointeCommission)
					{
						$result['spacePointeCommission1'] = ($retailerQuotedPrice*$catCommission1)/100;
						$result['spacePointeCommission2'] = ($retailerQuotedPrice*$catCommission2)/100;
					}
					if($priceRangeDet->adminFee)
					{
						$result['cashAdminPrice'] = $cashAdminPrice;
					}
				}
				$result['retailerPrice'] = $retailerQuotedPrice-$result['spacePointeCommission2'];
				$result['displayPrice']  = $result['retailerPrice']+$result['spacePointeCommission1']+$result['spacePointeCommission2']+$result['cashAdminPrice'];
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
			$result['message'] = 'Please enter the Retailer Quoted Price';
		}
		return $result;
	}
	
	public function edit_inventory($organizationProductId)
	{
		$userType = $this->CI->session->userdata('userType');
		$returnArr 					        = array();
		$returnArr['retailerQuotePrice']     = '';
		$returnArr['retailerPrice']          = '';
		$returnArr['spacePointeCommission1'] = '';
		$returnArr['spacePointeCommission2'] = '';
		$returnArr['cashAdminPrice']		 = '';		
		$returnArr['displayPrice']		     = '';
		$returnArr['catCommission1']         = 0;
		$returnArr['catCommission2']         = 0;
		$returnArr['productWeight']          = 0;
		
		$productId = 0;
		$details   = $this->CI->product_m->inventory_details($organizationProductId);
		
		if(!empty($details))
		{
			$returnArr['retailerPrice'] = $details->currentPrice;
			$returnArr['productWeight'] = $details->weight+$details->shippingWeight;
			$productId = $details->productId;
			
			$productPriceDet = $this->CI->product_lib->show_product_price_array($organizationProductId);
			$this->CI->custom_log->write_log('custom_log','commission details is '.print_r($productPriceDet,true));
			$returnArr['retailerQuotePrice'] = $productPriceDet['retailerQuotedPrice'];
			$returnArr['retailerPrice']		 = $productPriceDet['retailerPrice'];
			$returnArr['displayPrice']		 = $productPriceDet['displayPrice'];
			$returnArr['catCommission1'] 	 = $productPriceDet['categoryCommission'];
			$returnArr['catCommission2']	 = $productPriceDet['categoryCommission2'];
			$returnArr['cashAdminPrice'] 	 = $productPriceDet['adminPrice'];				
			//echo "<pre>"; print_r($returnArr); exit;
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','form submit data is '.print_r($_POST,true));
			$returnArr['retailerQuotePrice']     = $this->CI->input->post('retailerQuotePrice');
			$returnArr['retailerPrice']          = $this->CI->input->post('retailerPrice');
			$returnArr['spacePointeCommission1'] = $this->CI->input->post('spacePointeCommission1');
			$returnArr['spacePointeCommission2'] = $this->CI->input->post('spacePointeCommission2');
			$returnArr['cashAdminPrice']		 = $this->CI->input->post('cashAdminPrice');		
			$returnArr['displayPrice']		     = $this->CI->input->post('displayPrice');
			
			$rules = edit_product_inventory_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{		//echo "<pre>"; print_r($returnArr); exit;
				/********Check Marketing product inventory*************/
				$marketingDet = $this->CI->product_marketing_m->marketing_inventory_details($organizationProductId);
				$this->CI->custom_log->write_log('custom_log','Marketing product details is '.print_r($marketingDet,true));
				if(!empty($marketingDet))
				{
					$newSalePrice = $returnArr['displayPrice']-$marketingDet->discountPrice;
					$this->CI->custom_log->write_log('custom_log','New Sale Price is '.$newSalePrice.' of this marketing product id is '.$marketingDet->marketingProductId);
										
					if($newSalePrice>0)
					{
						$this->CI->product_marketing_m->update_marketing_sale_inventory($marketingDet->marketingProductId,$newSalePrice);
					}
					else
					{
						$this->CI->session->set_flashdata('error','Effective sale price cannot be less than discount, kindly speak to your Account Manager');
						$this->CI->custom_log->write_log('custom_log','Effective sale price cannot be less than discount, kindly speak to your Account Manager');
					
						redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/inventory_details/'.id_encrypt($organizationProductId));
					}
				}
				//echo "<pre>"; print_r($marketingDet); exit;
				/********Check Marketing product inventory*************/
			
				if($this->CI->product_m->update_retailer_product_price($organizationProductId,$returnArr['retailerPrice']))
				{
					//echo "<pre>"; print_r($returnArr); exit;
					//echo $this->CI->db->last_query(); exit;
					/*********Inventory History Start******************/
					$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
					$returnArr['organizationProductId'] = $organizationProductId;
					$returnArr['organizationId']        = $details->organizationId;
					$returnArr['productId']             = $details->productId;
					$returnArr['stock']                 = $details->currentQty;
					$returnArr['act']		            = 0;
					$inventoryHistoryId = $this->CI->product_m->add_inventory_history($returnArr);
					$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
					/*********Inventory History End  ******************/
					
					$this->CI->session->set_flashdata('success','Sell Price updated successfully');
					$this->CI->custom_log->write_log('custom_log','Sell Price updated successfully');
				}
				else
				{
					$this->CI->session->set_flashdata('error','Sell Price not updated');
					$this->CI->custom_log->write_log('custom_log','Sell Price not updated');
				}
				
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/inventory_details/'.id_encrypt($organizationProductId));					
			}
			else
			{
				//echo validation_errors(); exit;
			}
		}
		return $returnArr;
	}
	
	public function delete_rating_review($rating_id)
	{

		$ratingDetails = $this->CI->product_m->product_rating_review_details($rating_id);
		if(!empty($ratingDetails))
		{
			$product_id   = $ratingDetails->product_id;
			$rating_point = $ratingDetails->rating_point;
			$rating1 	  = $ratingDetails->product_rating_1;
			$rating2 	  = $ratingDetails->product_rating_2;
			$rating3 	  = $ratingDetails->product_rating_3;
			$rating4	  = $ratingDetails->product_rating_4;
			$rating5	  = $ratingDetails->product_rating_5;
			if($rating_point==1)
			{
				$rating1 = $rating1-1;
			}
			elseif($rating_point==2)
			{
				$rating2 = $rating2-1;
			}
			elseif($rating_point==3)
			{
				$rating3 = $rating3-1;
			}
			elseif($rating_point==4)
			{
				$rating4 = $rating4-1;
			}
			elseif($rating_point==5)
			{
				$rating5 = $rating5-1;
			}
			$this->CI->product_m->update_rating_product($product_id,$rating1,$rating2,$rating3,$rating4,$rating5);					
			$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
			
			if($this->CI->product_m->delete_rating_review($rating_id))
			{	
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_delete_rating'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_delete_rating'));
			}
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_delete_rating'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_delete_rating'));	
			}		
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_rating_review_details'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_rating_review_details'));	
		}
	}
	
	public function delete_seller_rating_review($rating_id)
	{
		$ratingDetails = $this->CI->product_m->seller_rating_review_details($rating_id);
		if(!empty($ratingDetails))
		{
			$retailer_id  = $ratingDetails->retailer_id;
			$rating_point = $ratingDetails->rating_point;
			$rating1 	  = $ratingDetails->ratailer_rating_1;
			$rating2 	  = $ratingDetails->ratailer_rating_2;
			$rating3 	  = $ratingDetails->ratailer_rating_3;
			$rating4	  = $ratingDetails->ratailer_rating_4;
			$rating5	  = $ratingDetails->ratailer_rating_5;
			if($rating_point==1)
			{
				$rating1 = $rating1-1;
			}
			elseif($rating_point==2)
			{
				$rating2 = $rating2-1;
			}
			elseif($rating_point==3)
			{
				$rating3 = $rating3-1;
			}
			elseif($rating_point==4)
			{
				$rating4 = $rating4-1;
			}
			elseif($rating_point==5)
			{
				$rating5 = $rating5-1;
			}
			$this->CI->retailer_m->update_rating_review_retailer($retailer_id,$rating1,$rating2,$rating3,$rating4,$rating5);					
			$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
			
			if($this->CI->retailer_m->delete_rating_review($rating_id))
			{	
				$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_delete_rating'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_delete_rating'));
			}
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_delete_rating'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_delete_rating'));	
			}		
		}
		else
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_rating_review_details'));
			$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_rating_review_details'));	
		}
	}
	
	public function attributeViewList()
	{
		$return = array();
		$return['total'] = $this->CI->product_m->total_product_type();
		return $return;
	}
	
	public function attributeListingAjaxFun($total)
	{
		$per_page = $this->CI->input->post('sel_no_entry');
		$search   = $this->CI->input->post('search');
		$where    = '';
		if(!empty($search))
		{
			$where = "product_type.description LIKE '".$search."%' ";
			$total =  $this->CI->product_m->total_product_type($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/attribute_management/attributeListingAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->product_m->product_type_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function addAttributeList()
	{
		$return = array();
		$return['product_type'] = '';
		
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$return['product_type']   = $this->CI->input->post('product_type');
			$return['attribute_type'] = $this->CI->input->post('attribute_type');
			$return['attribute_name'] = $this->CI->input->post('attribute_name');
			$return['is_required']    = $this->CI->input->post('is_required');
			$return['is_display']     = $this->CI->input->post('is_display');
			$return['key_features']   = $this->CI->input->post('key_features');
			
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = add_edit_product_attribute_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$productTypeID = $this->CI->product_m->add_product_type($return['product_type']);
				if($productTypeID)
				{
					$taxonomyArr = array();
					$attrNmArr   = array();
					$attrArr     = array();
					$attrArr['productTypeId'] = $productTypeID;
					foreach($return['attribute_type'] as $key=>$value)
					{
						if(!empty($value))
						{
							$attrArr['attribute_type'] = $value;
							$attrTypeID = $this->CI->product_m->add_attribute_type($attrArr);
						
							if(!empty($return['attribute_name'][$key]))
							{
								
								foreach($return['attribute_name'][$key] as $key1=>$value1)
								{
									if(!empty($value1))
									{
										$attrNmArr = array(
															'productAttributeName'   => $value1,
															'productAttributeTypeId' => $attrTypeID,
														);
										$attrNameID = $this->CI->product_m->add_attribute_name($attrNmArr);
										
										$isRequired  = 0;
										$isDisplayed = 0;
										$keyFeatures = 0;
										if(!empty($return['is_required'][$key][$key1]))
										{
											$isRequired = 1;
										}
										if(!empty($return['is_display'][$key][$key1]))
										{
											//$isRequired = 1;
											$isDisplayed = 1;
										}
										if(!empty($return['key_features'][$key][$key1]))
										{
											$isRequired  = 1;
											$isDisplayed = 1;
											$keyFeatures = 1;
										}
						
										$taxonomyArr[] = array(
														'attributeNameId' => $attrNameID,
														'attributeTypeId' => $attrTypeID,
														'productTypeId'   => $productTypeID,
														'isRequired'	  => $isRequired,
														'isDisplayed'	  => $isDisplayed,
														'keyFeature'	  => $keyFeatures,
														'createDt'		  => date('Y-m-d H:i:s'),
														'lastModifiedDt'  => date('Y-m-d H:i:s'),
														'lastModifiedBy'  => $this->CI->session->userdata('userId')
													 );	
									}																			
								}
							}
						}
					}
					
					if(!empty($taxonomyArr))
					{
						if($this->CI->product_m->add_product_taxonomy($taxonomyArr))
						{
							$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_product_taxonomy'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_product_taxonomy'));	
						}
						else
						{
							$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_product_taxonomy'));
							$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product_taxonomy'));
						}
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_product_type'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product_type'));
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/attribute_management');				
			}
		}	
		return $return;	
	}
	
	public function editAttributeList($productTypeId)
	{
		$result 				= array();
		$productType 			= '';
		$attrList   			= '';
		$attrTypeIdArr          = array();
		$productTypeId 		    = id_decrypt($productTypeId);
		
		$productTyeDetails = $this->CI->product_m->product_type_name($productTypeId);
		if(!empty($productTyeDetails))
		{
			$productType = $productTyeDetails->description;			
		}
		
		$productTaxonomyList 	= $this->CI->product_m->product_taxonomy_listType($productTypeId);
		if(!empty($productTaxonomyList))
		{
			foreach($productTaxonomyList as $row)
			{
				$attrList[$row->attributeTypeId]['attribute_type'] = $row->attribute_type;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['productTaxonomyId'] = $row->productTaxonomyId;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['attribute_id'] = $row->attributeNameId;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['attribute_name'] = $row->attribute_name;	
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['isRequired'] = $row->isRequired;	
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['isDisplayed'] = $row->isDisplayed;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['keyFeatures'] = $row->keyFeature;
				$attrTypeIdArr[] = $row->attributeTypeId;	
			}
		}
		
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			if(!empty($attrTypeIdArr))
			{
				if($this->CI->product_m->dactivateAttributeType($productTypeId))
				{
					$updateAR = array();
					foreach($attrTypeIdArr as $value)
					{
						$updateAR[] = array(
									  	 'productAttributeTypeId' => $value,
										 'active' => 0
									  );
					}
					
					if($this->CI->product_m->dactivateAttributeName($updateAR))
					{
						$this->CI->product_m->dactivateProductTaxonomy($productTypeId);
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_deactivate_attribute_name'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_deactivate_attribute_name'));
						redirect(base_url().$this->CI->session->userdata('userType').'/attribute_management/editAttributeList/'.id_encrypt($productTypeId));
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_deactivate_attribute'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_deactivate_attribute'));
					redirect(base_url().$this->CI->session->userdata('userType').'/attribute_management/editAttributeList/'.id_encrypt($productTypeId));
				}
			}
			$result['product_type']   = $this->CI->input->post('product_type');
			$result['attribute_type'] = $this->CI->input->post('attribute_type');
			$result['attribute_name'] = $this->CI->input->post('attribute_name');
			$result['is_required']    = $this->CI->input->post('is_required');
			$result['is_display']     = $this->CI->input->post('is_display');
			$result['key_features']   = $this->CI->input->post('key_features');
			if($productTypeId)
			{
				$taxonomyArr = array();
				$attrNmArr   = array();
				$attrArr     = array();
				$attrArr['productTypeId'] = $productTypeId;
				foreach($result['attribute_type'] as $key=>$value)
				{
					if(!empty($value))
					{
						$attrArr['attribute_type'] = $value;
						$attrTypeID = $this->CI->product_m->add_attribute_type($attrArr);
						
						if(!empty($result['attribute_name'][$key]))
						{
							
							foreach($result['attribute_name'][$key] as $key1=>$value1)
							{
								if(!empty($value1))
								{
								$attrNmArr = array(
													'productAttributeName'   => $value1,
													'productAttributeTypeId' => $attrTypeID,
												);
								$attrNameID = $this->CI->product_m->add_attribute_name($attrNmArr);
								
								$isRequired  = 0;
								$isDisplayed = 0;
								$keyFeatures = 0;
								if(!empty($result['is_required'][$key][$key1]))
								{
									$isRequired = 1;
								}
								if(!empty($result['is_display'][$key][$key1]))
								{
									//$isRequired = 1;
									$isDisplayed = 1;
								}
								if(!empty($result['key_features'][$key][$key1]))
								{
									$isRequired  = 1;
									$isDisplayed = 1;
									$keyFeatures = 1;
								}
					
								$taxonomyArr[] = array(
													'attributeNameId' => $attrNameID,
													'attributeTypeId' => $attrTypeID,
													'productTypeId'   => $productTypeId,
													'isRequired'	  => $isRequired,
													'isDisplayed'	  => $isDisplayed,
													'keyFeature'	  => $keyFeatures,
													'createDt'		  => date('Y-m-d H:i:s'),
													'lastModifiedDt'  => date('Y-m-d H:i:s'),
													'lastModifiedBy'  => $this->CI->session->userdata('userId')
												 );		
								}																		
							}
						}
					}
				}
				//echo "<pre>"; print_r($taxonomyArr); exit;
				if(!empty($taxonomyArr))
				{
					if($this->CI->product_m->add_product_taxonomy($taxonomyArr))
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_product_taxonomy'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_product_taxonomy'));	
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_product_taxonomy'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product_taxonomy'));
					}
				}
			}
			else
			{
				$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_product_type'));
				$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_product_type'));
			}
			redirect(base_url().$this->CI->session->userdata('userType').'/attribute_management');					
		}
		
		$return = array();
		$return['productType'] = $productType;
		$return['attrList']    = $attrList;
		return $return;
	}
	
	public function attributeDetailsView($productTypeId)
	{
		$return      = array();
		$formSubmit  = 1;
		$attrList    = array();
		$productType = '';
		
		if($_POST)
		{
			$formSubmit    = 0;
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$productType = $this->CI->input->post('product_type');
			$rules = add_edit_product_attribute_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($this->CI->product_m->update_product_type($productTypeId,$productType))
				{
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_product_type'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_product_type'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_product_type'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_product_type'));
				}
				redirect(base_url().$this->session->userdata('userType').'/attribute_management');			
			}
		}
		
		$productTyeDetails = $this->CI->product_m->product_type_name($productTypeId);
		if(!empty($productTyeDetails))
		{
			if($formSubmit)
			{
				$productType = $productTyeDetails->description;
			}
		}
		
		$productTaxonomyList = $this->CI->product_m->product_taxonomy_listType($productTypeId);
		if(!empty($productTaxonomyList))
		{
			foreach($productTaxonomyList as $row)
			{				
				$attrList[$row->attributeTypeId]['attribute_type'] = $row->attribute_type;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['productTaxonomyId'] = $row->productTaxonomyId;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['attribute_id'] = $row->attributeNameId;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['attribute_name'] = $row->attribute_name;	
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['isRequired'] = $row->isRequired;	
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['isDisplayed'] = $row->isDisplayed;
				$attrList[$row->attributeTypeId]['attribute_name'][$row->attributeNameId]['keyFeatures'] = $row->keyFeature;	
			}
		}

		$return['productType'] = $productType;
		$return['attrList']    = $attrList;
		return $return;
	}
	
	public function check_stocks_index($organizationId)
	{
		$return = array();
		$return['total'] = $this->CI->product_m->total_check_stocks('organizationId = '.$organizationId);
		return $return;
	}
	
	public function check_stocksAjaxFun($total)
	{
		$return         = array();
		$perPage        = $this->CI->input->post('sel_no_entry');
		$productName    = trim($this->CI->input->post('productName'));
		$organizationId = $_POST['organizationId'];
		$where          = 'organizationId = '.$organizationId;
		//echo "<pre>";print_r($_POST); exit;
		if(!empty($productName))
		{
			$where.= ' AND trim(product.code) like "'.$productName.'%"';
		}	
		$pagConfig  = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/product_management/check_stocksAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$product_color_list = $this->CI->color_m->get_colors();
		
		foreach($product_color_list as $color_list)
		{
			$return['color_list'][$color_list->colorId] = $color_list->colorCode;
		}
		
		$stockLists = $this->CI->product_m->size_check_stocks_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($stockLists); exit;
		foreach($stockLists as $rowVal)
		{
			$productWeight = $rowVal->weight+$rowVal->shippingWeight;
			$priceArr      = $this->CI->product_lib->show_product_price_array($rowVal->organizationProductId);
			$displayPrice  = $priceArr['displayPrice'];
			
			$return['list'][$rowVal->organizationProductId]['organizationProductId'] = $rowVal->organizationProductId;
			$return['list'][$rowVal->organizationProductId]['organizationId']        = $rowVal->organizationId;
			$return['list'][$rowVal->organizationProductId]['imageName']             = $rowVal->imageName;
			$return['list'][$rowVal->organizationProductId]['code']                  = $rowVal->code;
			$return['list'][$rowVal->organizationProductId]['retailerPrice']         = $rowVal->currentPrice;
			$return['list'][$rowVal->organizationProductId]['displayPrice']          = $displayPrice;
			$return['list'][$rowVal->organizationProductId]['currentQty']            = $rowVal->currentQty;
			$return['list'][$rowVal->organizationProductId]['product_size']          = $rowVal->product_size;
			$return['list'][$rowVal->organizationProductId]['colorId']               = $rowVal->colorId;
			$return['list'][$rowVal->organizationProductId]['stock']                 = $rowVal->stock;
		}
		//$return['list']  = $this->CI->product_m->size_check_stocks_list($page,$pagConfig['per_page'],$where);
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		$return['organizationId'] = $organizationId;
		return $return;
	}
	
	public function inventory_details($organizationProductId,$organizationId)
	{
		$return = array();
		$return['stock']                  = 0;
		$return['retailerQuotePrice']	  = '';
		$return['retailerPrice']          = '';
		$return['spacePointeCommission1'] = '';
		$return['spacePointeCommission2'] = '';
		$return['adminPrice']		      = 0;
		$return['handlingPrice']		  = '';		
		$return['displayPrice']		      = '';
		$return['catCommission']          = 0;
		$return['productName']            = '';
		$return['currentQty']             = '';
		$return['editinventory']          = 'add';
		$return['inventory']              = '';
		$return['imageName']              = '';
		$return['productId']              = '';
		$return['product_size']           = '';
		$productWeight      = 0;
		$product_color_list = $this->CI->color_m->get_colors();;
		foreach($product_color_list as $color_list)
		{
			$return['color_list'][$color_list->colorId] = $color_list->colorCode;
		}
		
		$details = $this->CI->product_m->inventory_details($organizationProductId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
			$return['productName']      = $details->code;
			$return['currentQty']       = $details->currentQty;
			$return['imageName']        = $details->imageName;
			$return['productId']        = $details->productId;
			$return['product_size']     = $details->product_size;
			$return['stock']            = $details->stock;
			$return['colorId'] 	        = $details->colorId;
			$return['availablecolor']   = '';
			$return['productcolorlist']	= $this->CI->product_m->get_product_color_list($return['productId']);
			
			$productWeight   = $details->weight+$details->shippingWeight;
			$priceDetailsArr = $this->CI->product_lib->show_product_price_array($organizationProductId);
			//echo "<pre>"; print_r($priceDetailsArr); exit;
			$return['retailerQuotePrice']     = $priceDetailsArr['retailerQuotedPrice'];
			$return['retailerPrice']          = $priceDetailsArr['retailerPrice'];
			$return['spacePointeCommission1'] = $priceDetailsArr['spacePointeCommissionPrice'];
			$return['spacePointeCommission2'] = $priceDetailsArr['spacePointeCommissionPrice2'];
			$return['catCommission']		  = $priceDetailsArr['categoryCommission'];
			$return['adminPrice']    		  = $priceDetailsArr['adminPrice']; 
			$return['handlingPrice'] 		  = 0;
			$return['displayPrice'] 		  = $priceDetailsArr['displayPrice'];
			
		}
		
		$return['cashAdminPrice'] = $return['adminPrice'];
		if($_POST)
		{
			$return['editinventory']   = $this->CI->input->post('editinventory');
			$return['inventory']       = $this->CI->input->post('inventory');
			$return['singleinventory'] = $return['inventory'];
			if(isset($_POST['selectsize']))
			{
				$return['selectsize'] = $this->CI->input->post('selectsize');
				
				$multiplier = count($return['selectsize']);
				$return['inventory'] = $multiplier*$return['inventory'];
			}
			else
			{
				$return['inventory']=$return['inventory'];
			}
			
			if(isset($_POST['availablecolor']))
			{
				$return['availablecolor'] = $this->CI->input->post('availablecolor');
				$colormultiplier          =	count($return['availablecolor']);
				$return['inventory']      = $colormultiplier*$return['inventory'];
			}
			else
			{
				$return['inventory'] = $return['inventory'];
			}
			$sizearray=str_replace(',','',$return['product_size']);
			$stock=	explode(',',$return['stock']);
				$colorId=	explode(',',$return['colorId']);
			if(isset($sizearray) &&!empty($sizearray))
			{
				$product_size_qty=	explode(',',$return['product_size']);
				
				if(!empty($product_size_qty)){
						foreach($product_size_qty as $key	=>	$product_size)
						{
							$product_stock_arr[$product_size][$colorId[$key]]=$stock[$key];
						}
						//print_r($product_stock_arr);
				}
			}elseif(!empty($colorId))
				{
						foreach($colorId as $key	=>	$singlecolor)
						{
							$product_stock_arr[$singlecolor]=$stock[$key];
						}
						
						

					
				}
			$rules = edit_inventory_rules();
			if(!empty($return['productcolorlist']))
			{
				$rules[]=array(
										'field' => 'availablecolor[]',
										'label' => 'color',
										'rules' => 'trim|required'
									);
			}
			if(isset($return['product_size']) && (!empty($return['product_size']))){
			$sizesarray=str_replace(',','',$return['product_size']);
			}else
			{
			$sizesarray='';	
			}
				if(isset($sizesarray) && !empty($sizesarray))
			{
				$rules[]=array(
										'field' => 'selectsize[]',
										'label' => 'size',
										'rules' => 'trim|required'
									);
			}
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($return['editinventory']=='add')
				{
					
					$totalInventory = $return['currentQty']+$return['inventory'];
					if(!empty($details))
					{
						$updateTtl = $this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
					}
					else
					{
						$updateTtl = $this->CI->product_m->edit_inventory_first_time($organizationProductId,$totalInventory);
					}
					
					if($updateTtl)
					{
						/*********Inventory History Start******************/
						$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
						$return['organizationProductId'] = $organizationProductId;
						$return['organizationId']        = $details->organizationId;
						$return['act']		             = 0;
						$return['stock']                 = $totalInventory; 
						$inventoryHistoryId = $this->CI->product_m->add_inventory_history($return);
						$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
						$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
						/*********Inventory History End  ******************/
				
						if(isset($return['selectsize']) && !empty($return['selectsize']))
						{
							foreach($return['selectsize'] as $single_size)
							{
								if(isset($product_stock_arr[$single_size]) && !empty($product_stock_arr[$single_size]))
								{
									$total_qty	= 'currentStock + '.$return['singleinventory'] ;
									if(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$single_size][$color]) && !empty($product_stock_arr[$single_size][$color]))  {
												$rs = $this->CI->product_m->update_size_stock($organizationProductId,$total_qty,$single_size,$color);
											}
											else
											{
												$total_qty	=	$return['singleinventory'];
												$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,$single_size,$color);
												
											}
										}										
									}
									else
									{
										$this->CI->product_m->update_size_stock($organizationProductId,$total_qty,$single_size);
									}
								}
								else
								{
									$total_qty	=	$return['singleinventory'];
									$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,$single_size,$return['availablecolor']);
								}
								
								/***add organization product size stock history**/
								$productSizeDet = $this->CI->product_m->check_product_size($details->productId,$single_size);
								$this->CI->custom_log->write_log('custom_log','produc size details is '.print_r($productSizeDet,true));
								if(!empty($productSizeDet))
								{
									$this->CI->product_m->unactive_old_size($organizationProductId,$productSizeDet->productSizeId);
									$organizationProductStockId = $this->CI->product_m->add_organization_size_stock($organizationProductId,$total_qty,$productSizeDet->productSizeId);
									$this->CI->custom_log->write_log('custom_log','organization product size stock id is '.$organizationProductStockId);
									$organizationSizeIdArray[$organizationProductStockId] = $organizationProductStockId;
								}
								/***add organization product size stock history**/
							}
						}
						elseif(!empty($return['availablecolor']))
						{
							foreach($return['availablecolor'] as $color)
							{
								if(isset($product_stock_arr[$color]))
								{
									$total_qty = 'currentStock + '.$return['singleinventory'] ;
									$rs        = $this->CI->product_m->update_size_stock($organizationProductId,$total_qty,'',$color);
								}
								else
								{
									$total_qty	=	$return['singleinventory'];
									$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,'',$color);	
								}
							}
						}
						
						/********add organization color stock history**************/
						if(!empty($return['availablecolor']))
						{
							foreach($return['availablecolor'] as $color)
							{
								$this->CI->product_m->unactive_organization_colors($organizationProductId,$color);
								$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$total_qty,$color);
								$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
								$organizationColorIdArray[$organizationColorId] = $organizationColorId;
							}
						}
						/********add organization color stock history**************/
						
						/*********organziation product color size combination history***************************/
						if((!empty($organizationColorIdArray))&&(!empty($organizationSizeIdArray)))
						{
							foreach($organizationColorIdArray as $colorId)
							{
								foreach($organizationSizeIdArray as $sizeId)
								{
									$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,$sizeId);
									$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
								}
							}
						}
						elseif(!empty($organizationColorIdArray))
						{
							foreach($organizationColorIdArray as $colorId)
							{
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,0);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
						elseif(!empty($organizationSizeIdArray))
						{
							foreach($organizationSizeIdArray as $sizeId)
							{
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,0,$sizeId);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
						/*********organziation product color size combination history***************************/
						
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_inventory'));	
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_inventory'));
					}
				}
				elseif($return['editinventory']=='sub')
				{
					$totalInventory = $return['currentQty']-$return['inventory'];
					if(!empty($details))
					{
						$updateTtl = $this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
					}
					else
					{
						$updateTtl = $this->CI->product_m->edit_inventory_first_time($organizationProductId,$totalInventory);
					}
					
					if($updateTtl)
					{
						/*********Inventory History Start******************/
						$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
						$return['organizationProductId'] = $organizationProductId;
						$return['organizationId']        = $details->organizationId;
						$return['act']		             = 0;
						$return['stock']                 = $totalInventory; 
						$inventoryHistoryId = $this->CI->product_m->add_inventory_history($return);
						$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
						/*********Inventory History End  ******************/
						
					if(isset($return['selectsize']) && !empty($return['selectsize'])){
							
							foreach($return['selectsize'] as $single_size){
							
						if(isset($product_stock_arr[$single_size]) && !empty($product_stock_arr[$single_size]))
								{
									$total_qty	=	'currentStock - '.$return['singleinventory'] ;
									if(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$single_size][$color]) && !empty($product_stock_arr[$single_size][$color])) {
												if($product_stock_arr[$single_size][$color]>=$return['singleinventory']){
										$rs=	$this->CI->product_m->update_size_stock($organizationProductId,$total_qty,$single_size,$color);
												}else
												{
													$this->CI->session->set_flashdata('error','Inventory Not available');
													$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
													
												}
											}else
											{
												$total_qty	=	$return['singleinventory'];
												$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
												$this->CI->session->set_flashdata('error','Inventory Not available');
												//$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,$single_size,$return['availablecolor']);
												
											}
										}
										
									}
									else
									{
										if($product_stock_arr[$single_size][0] >= $return['singleinventory']){
										$this->CI->product_m->update_size_stock($organizationProductId,$total_qty,$single_size);
										}else
										{
											$this->CI->session->set_flashdata('error','Inventory Not available');
										}
									}
								}else
								{
									$total_qty	=	$return['singleinventory'];
									//$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,$single_size,$return['availablecolor']);
									$this->CI->session->set_flashdata('error','Inventory Not available');
								}
							
								
								
							}
						}elseif(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$color]) && !empty($product_stock_arr[$color])){
												$total_qty	=	'currentStock - '.$return['singleinventory'] ;
												if($product_stock_arr[$color]>=$return['singleinventory']){
											$rs=	$this->CI->product_m->update_size_stock($organizationProductId,$total_qty,'',$color);
												}else
												{
													$this->CI->session->set_flashdata('error','Inventory Not available');
													$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
													
												}
											}else
											{
											$total_qty	=	$return['singleinventory'];
										$this->CI->session->set_flashdata('error','Inventory Not available');
										$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
											
										//	$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,'',$return['availablecolor']);	
											}
										}
									}
								$error=	$this->CI->session->flashdata('error');
							if(!empty($error)){
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_inventory'));	
							}
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_inventory'));
					}
				}
				
				if(($this->CI->session->userdata('userType')=='cse')||($this->CI->session->userdata('userType')=='superadmin'))
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/product_management/inventory_details/'.id_encrypt($organizationProductId).'/'.id_encrypt($organizationId));
				}
				else
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/product_management/inventory_details/'.id_encrypt($organizationProductId));
				}
			}	else
			{
				$error=$this->CI->form_validation->error_array();
				//print_r($error);
			}		
		}
		
		return $return;
	}
	
	public function marketing_inventory_details($marketingProductId,$organizationId)
	{
		$return = array();
		$return['productName']   = '';
		$return['productMrp']    = '';
		$return['currentQty']    = '';
		$return['currentPrice']  = '';
		$return['editinventory'] = 'add';
		$return['inventory']     = '';
		$return['imageName']     = '';
		$return['productId']     = '';
		$return['product_size']     = '';
		$return['displayPrice'] = '';
		$product_color_list		=	$this->CI->color_m->get_colors();;
		foreach($product_color_list as $color_list)
		{
			$return['color_list'][$color_list->colorId]=$color_list->colorCode;
		}
		
		

		$details = $this->CI->product_marketing_m->inventory_details($marketingProductId);
		if(!empty($details))
		{
			$productWeight = $details->weight+$details->shippingWeight;
			$priceArr  = $this->CI->product_lib->show_product_price_array($details->organizationProductId);						
			$displayPrice = $priceArr['displayPrice'];

			$return['productName']  = $details->code;
			$return['currentQty']   = $details->currentQty;
			$return['currentPrice'] = $details->currentPrice;
			//$return['currentPrice'] = $details->orgCurrentPrice;
			$return['costprice']    = $details->costPrice;;
			$return['imageName']    = $details->imageName;
			$return['productId']    = $details->productId;
			$return['product_size'] = $details->product_size;
			$return['stock']        = $details->stock;
			$return['colorId'] 	      = $details->colorId;
			$return['availablecolor'] = '';
			$return['displayPrice']     = $displayPrice;
			$return['productcolorlist'] = $this->CI->product_m->get_product_color_list($return['productId']);
		}
		
		if($_POST)
		{
			$return['editinventory'] = $this->CI->input->post('editinventory');
			$return['inventory']     = $this->CI->input->post('inventory');
			$return['singleinventory']=$return['inventory'];
			if(isset($_POST['selectsize']))
			{
				$return['selectsize']     = $this->CI->input->post('selectsize');
				
				$multiplier =	count($return['selectsize']);
				$return['inventory']= $multiplier*$return['inventory'];
			}
			else
			{
				$return['inventory']=$return['inventory'];
			}
				if(isset($_POST['availablecolor']))
			{
				$return['availablecolor']     = $this->CI->input->post('availablecolor');
				//$return['singleinventory']=$return['inventory'];
				$colormultiplier =	count($return['availablecolor']);
				$return['inventory']= $colormultiplier*$return['inventory'];
			}
			else
			{
				$return['inventory']=$return['inventory'];
			}
			$sizearray=str_replace(',','',$return['product_size']);
			$stock=	explode(',',$return['stock']);
				$colorId=	explode(',',$return['colorId']);
			if(isset($sizearray) &&!empty($sizearray))
			{
				$product_size_qty=	explode(',',$return['product_size']);
				
				if(!empty($product_size_qty)){
						foreach($product_size_qty as $key	=>	$product_size)
						{
							$product_stock_arr[$product_size][$colorId[$key]]=$stock[$key];
						}
						//print_r($product_stock_arr);
				}
			}elseif(!empty($colorId))
				{
						foreach($colorId as $key	=>	$singlecolor)
						{
							$product_stock_arr[$singlecolor]=$stock[$key];
						}
						
						

					
				}
			$rules = edit_inventory_rules();
			if(!empty($return['productcolorlist']))
			{
				$rules[]=array(
										'field' => 'availablecolor[]',
										'label' => 'color',
										'rules' => 'trim|required'
									);
			}
			if(isset($return['product_size']) && (!empty($return['product_size']))){
			$sizesarray=str_replace(',','',$return['product_size']);
			}else
			{
			$sizesarray='';	
			}
				if(isset($sizesarray) && !empty($sizesarray))
			{
				$rules[]=array(
										'field' => 'selectsize[]',
										'label' => 'size',
										'rules' => 'trim|required'
									);
			}
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($return['editinventory']=='add')
				{
					
					$totalInventory = $return['currentQty']+$return['inventory'];
					if($this->CI->product_marketing_m->update_inventory($marketingProductId,$totalInventory))
					{
						
							if(isset($return['selectsize']) && !empty($return['selectsize'])){
							
							foreach($return['selectsize'] as $single_size){
							
						if(isset($product_stock_arr[$single_size]) && !empty($product_stock_arr[$single_size]))
								{
									$total_qty	=	'currentStock + '.$return['singleinventory'] ;
									if(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$single_size][$color]) && !empty($product_stock_arr[$single_size][$color])) {
										$rs=	$this->CI->product_marketing_m->update_size_stock($marketingProductId,$total_qty,$single_size,$color);
											}else
											{
												$total_qty	=	$return['singleinventory'];
												$this->CI->product_marketing_m->add_marketing_size_stock($marketingProductId,$total_qty,$single_size,$color);
												
											}
										}
										
									}
									else
									{
										$this->CI->product_marketing_m->update_size_stock($marketingProductId,$total_qty,$single_size);
									}
								}else
								{
									$total_qty	=	$return['singleinventory'];
									$this->CI->product_marketing_m->add_marketing_size_stock($marketingProductId,$total_qty,$single_size,$return['availablecolor']);
								}
							
								
								
							}
						}elseif(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$color])){
												$total_qty	=	'currentStock + '.$return['singleinventory'] ;
											$rs=	$this->CI->product_marketing_m->update_size_stock($marketingProductId,$total_qty,'',$color);
											}else
											{
											$total_qty	=	$return['singleinventory'];
											$this->CI->product_marketing_m->add_marketing_size_stock($marketingProductId,$total_qty,'',$color);	
											}
										}
									}
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_inventory'));	
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_inventory'));
					}
				}
				elseif($return['editinventory']=='sub')
				{
					$totalInventory = $return['currentQty']-$return['inventory'];
					if($this->CI->product_marketing_m->update_inventory($marketingProductId,$totalInventory))
					{
					if(isset($return['selectsize']) && !empty($return['selectsize'])){
							
							foreach($return['selectsize'] as $single_size){
							
						if(isset($product_stock_arr[$single_size]) && !empty($product_stock_arr[$single_size]))
								{
									$total_qty	=	'currentStock - '.$return['singleinventory'] ;
									if(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$single_size][$color]) && !empty($product_stock_arr[$single_size][$color])) {
												if($product_stock_arr[$single_size][$color]>=$return['singleinventory']){
										$rs=	$this->CI->product_marketing_m->update_size_stock($marketingProductId,$total_qty,$single_size,$color);
												}else
												{
													$this->CI->session->set_flashdata('error','Inventory Not available');
													$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_marketing_m->update_inventory($marketingProductId,$totalInventory);
													
												}
											}else
											{
												$total_qty	=	$return['singleinventory'];
												$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_marketing_m->update_inventory($organizationProductId,$totalInventory);
												$this->CI->session->set_flashdata('error','Inventory Not available');
												//$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,$single_size,$return['availablecolor']);
												
											}
										}
										
									}
									else
									{
										if($product_stock_arr[$single_size][0] >= $return['singleinventory']){
										$this->CI->product_marketing_m->update_size_stock($organizationProductId,$total_qty,$single_size);
										}else
										{
											$this->CI->session->set_flashdata('error','Inventory Not available');
										}
									}
								}else
								{
									$total_qty	=	$return['singleinventory'];
									//$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,$single_size,$return['availablecolor']);
									$this->CI->session->set_flashdata('error','Inventory Not available');
								}
							
								
								
							}
						}elseif(!empty($return['availablecolor']))
									{
										foreach($return['availablecolor'] as $color)
										{
											if(isset($product_stock_arr[$color]) && !empty($product_stock_arr[$color])){
												$total_qty	=	'currentStock - '.$return['singleinventory'] ;
												if($product_stock_arr[$color]>=$return['singleinventory']){
											$rs=	$this->CI->product_marketing_m->update_size_stock($marketingProductId,$total_qty,'',$color);
												}else
												{
													$this->CI->session->set_flashdata('error','Inventory Not available');
													$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_marketing_m->update_inventory($marketingProductId,$totalInventory);
													
												}
											}else
											{
											$total_qty	=	$return['singleinventory'];
										$this->CI->session->set_flashdata('error','Inventory Not available');
										$totalInventory = $return['currentQty']+$return['singleinventory'];
												$this->CI->product_marketing_m->update_inventory($marketingProductId,$totalInventory);
											
										//	$this->CI->product_m->add_size_stock($organizationProductId,$total_qty,'',$return['availablecolor']);	
											}
										}
									}
								$error=	$this->CI->session->flashdata('error');
							if(!empty($error)){
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_inventory'));	
							}
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_inventory'));
					}
				}
				
				if(($this->CI->session->userdata('userType')=='cse')||($this->CI->session->userdata('userType')=='superadmin'))
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/product_marketing_management/inventory_details/'.id_encrypt($marketingProductId).'/'.id_encrypt($organizationId));
				}
				else
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/product_marketing_management/inventory_details/'.id_encrypt($marketingProductId));
				}
			}	else
			{
				$error=$this->CI->form_validation->error_array();
				//print_r($error);
			}		
		}
		return $return;
	}
		
	public function addRetailerProduct($productId)
	{
		$result = array();
		$result['categoryList'] = $this->CI->segment_cat_m->organization_category_list();
		$result['upc'] 			= '';
		$result['costPrice'] 	= '';
		$result['sellPrice'] 	= '';
		$result['productId']    = 0;
		$result['categoryId']   = 0;
		$result['upc']			= '';
		$result['costPrice']	= '';
		$result['sellPrice']	= '';
		$result['productId']    = $productId;

		if($_POST)
		{
			$rules = add_retailer_product_from_master_list_rules();
			$result['categoryId'] = $this->CI->input->post('categoryId');
			$result['upc'] 		  = $this->CI->input->post('upc');
			$result['costPrice']  = $this->CI->input->post('costPrice');
			$result['sellPrice']  = $this->CI->input->post('sellPrice');
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$productDet = $this->CI->product_m->product_table_row($result['productId']);
				if(!empty($productDet))
				{
					$result['productName'] 		  = $productDet->code;
					$result['productDescription'] = $productDet->description;
					$result['imageName']          = $productDet->imageName;
					$organizationId		   		  = $this->CI->session->userdata('organizationId');
					$result['lastCatId'] 		  = $result['categoryId'];
					$getDetails = $this->CI->product_m->get_product_category_details($result);
					if(!empty($getDetails))
					{
						$this->CI->session->set_flashdata('error','You already add this product with category and retailer');
						$this->CI->custom_log->write_log('custom_log','You already add this product with category and retailer');
					}
					else
					{
						$organizationProductId = $this->CI->product_m->add_organization_product_from_master($organizationId,$result);					
						if($organizationProductId)
						{
							$this->CI->product_m->add_product_category($result['productId'],$result);
							$this->CI->session->set_flashdata('success','Product add successfully in your list from master list');
							$this->CI->custom_log->write_log('custom_log','Product add successfully in your list from master list');
							redirect(base_url().$this->CI->session->userdata('userType').'/retailer_product_management');
						}
						else
						{
							$this->CI->session->set_flashdata('error','Product not add in master list');
							$this->CI->custom_log->write_log('custom_log','Product not add in master list');
						}
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Product Details not found');
					$this->CI->custom_log->write_log('custom_log','Product Details not found');
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/retailer_product_management/addRetailerProduct');
			}
		}
		return $result;
	}
	
	public function spacepointe_product_list()
	{
		$returnArr = array();
		$returnArr['total'] = $this->CI->product_m->total_spacepointe_products();
		return $returnArr;
	}
	
	public function request_product_list()
	{
		$returnArr = array();
		$returnArr['total'] = $this->CI->product_m->total_products_request();
		return $returnArr;
	}
	
	public function request_product_ajaxFun($total)
	{
		$perPage	     = $this->CI->input->post('sel_no_entry');
		$productName     = $this->CI->input->post('productName');			
		$productCategory = $this->CI->input->post('productCategory');
		$brandName       = $this->CI->input->post('brandName');
		$organizationId  = $this->CI->input->post('organizationId');
		$requestBy       = $this->CI->input->post('requestBy');
		$where 		     = '';
		
		if(!empty($productName))
		{
			$where = "product.code LIKE '".$productName."%'";
		}
		if(!empty($productCategory))
		{
			if($where)
			{
				$where.= " AND category.categoryCode LIKE '".$productCategory."%'";
			}
			else
			{
				$where = "category.categoryCode LIKE '".$productCategory."%'";
			}
		}
		
		if(!empty($requestBy))
		{
			if($where)
			{
				$where.= " AND CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$requestBy."%'";
			}
			else
			{
				$where = "CONCAT(employee.firstName,' ',employee.lastName) LIKE '".$requestBy."%'";
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
			$total = $this->CI->product_m->total_products_request($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/product_request_management/ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
				  
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
		
		$returnArr['links'] = $this->CI->ajax_pagination->create_links();
		$returnArr['page']  = $page;
		$returnArr['list']  = $this->CI->product_m->products_request_list_test($page,$pagConfig['per_page'],$where);
		$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());	
		return $returnArr;
	}
	
	public function product_request_review($product_id='')
	{
		$userType = $this->CI->session->userdata('userType');
		$this->CI->custom_log->write_log('custom_log','product id is '.$product_id);
		
		$returnArr 					     = array();
		$returnArr['product_name']	     = '';
		$returnArr['productDescription'] = '';
		$returnArr['segment_name'] 	     = '';
		$returnArr['category_name']      = '';
		$returnArr['sub_category1_name'] = '';
		$returnArr['sub_category2_name'] = '';
		$returnArr['sub_category3_name'] = '';
		$returnArr['sub_category4_name'] = '';
		$returnArr['sub_category5_name'] = '';
		$returnArr['sub_category6_name'] = '';
		$returnArr['brandName']          = '';
		$returnArr['spid']		         = '';
		$returnArr['item_weight']		 = '';
		$returnArr['packing_weight']	 = '';
		$returnArr['total_weight']	     = '';
		$returnArr['product_images']	 = array();
		$returnArr['product_attributes'] = array();
		$returnArr['keyFeatures']		 = array();
		$returnArr['active']             = '';
		$returnArr['brandStatus']		 = 0;
		$returnArr['requestBy']		     = '';
		$returnArr['requestReason']	     = '';
		$returnArr['verificationResultId'] = '';
		$returnArr['sizes']					='';
				
		$productAttrDetails = $this->CI->product_m->product_request_brand_image_category_tax_details($product_id);
		//echo "<pre>"; print_r($productAttrDetails); exit;
		$this->CI->custom_log->write_log('custom_log','product row details is '.print_r($productAttrDetails,true));
		if(!empty($productAttrDetails))
		{
			$i = 0;
			foreach($productAttrDetails as $row)
			{
				$returnArr['requestBy']		     = ucwords($row->firstName.' '.$row->middle.' '.$row->lastName);
				$returnArr['product_name']	     = $row->code;
				$returnArr['brandStatus']	     = $row->brandStatus;
				
				$returnArr['requestReason']	       = $row->requestReason;
				$returnArr['verificationResultId'] = $row->verificationResultId;
				$returnArr['sizes']					=$row->sizes;
				$returnArr['active']    	     = $row->active;
				$returnArr['productDescription'] = $row->description;
				$returnArr['brandName']			 = $row->brandName;
				$returnArr['spid']			 	 = $row->productId;
				$returnArr['item_weight']		 = $row->weight;
				$returnArr['packing_weight']	 = $row->shippingWeight;
				$returnArr['total_weight']	     = $returnArr['item_weight']+$returnArr['packing_weight'];
				$returnArr['productTypeId']		 = $row->productTypeId;
				$returnArr['product_images'][$i]['imageName']    = $row->imageName;
				$returnArr['product_images'][$i]['displayOrder'] = $row->displayOrder;
				$i++;
				
				if(!empty($row->segName))
				{
					$returnArr['segment_name'] 	     = $row->segName;
					$returnArr['category_name']      = $row->catName;
					$returnArr['sub_category1_name'] = $row->subCat1Name;
					$returnArr['sub_category2_name'] = $row->subCat2Name;
					$returnArr['sub_category3_name'] = $row->subCat3Name;
					$returnArr['sub_category4_name'] = $row->subCat4Name;
					$returnArr['sub_category5_name'] = $row->subCat5Name;
					$returnArr['sub_category6_name'] = $row->subCat6Name;
				}
				elseif(!empty($row->catName))
				{
					$returnArr['segment_name'] 	     = $row->catName;
					$returnArr['category_name']      = $row->subCat1Name;
					$returnArr['sub_category1_name'] = $row->subCat2Name;
					$returnArr['sub_category2_name'] = $row->subCat3Name;
					$returnArr['sub_category3_name'] = $row->subCat4Name;
					$returnArr['sub_category4_name'] = $row->subCat5Name;
					$returnArr['sub_category5_name'] = $row->subCat6Name;
					$returnArr['sub_category6_name'] = $row->segName;					
				}	
				elseif(!empty($row->subCat1Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat1Name;
					$returnArr['category_name']      = $row->subCat2Name;
					$returnArr['sub_category1_name'] = $row->subCat3Name;
					$returnArr['sub_category2_name'] = $row->subCat4Name;
					$returnArr['sub_category3_name'] = $row->subCat5Name;
					$returnArr['sub_category4_name'] = $row->subCat6Name;
					$returnArr['sub_category5_name'] = $row->segName;
					$returnArr['sub_category6_name'] = $row->catName;	
				}	
				elseif(!empty($row->subCat2Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat2Name;
					$returnArr['category_name']      = $row->subCat3Name;
					$returnArr['sub_category1_name'] = $row->subCat4Name;
					$returnArr['sub_category2_name'] = $row->subCat5Name;
					$returnArr['sub_category3_name'] = $row->subCat6Name;
					$returnArr['sub_category4_name'] = $row->segName;
					$returnArr['sub_category5_name'] = $row->catName;
					$returnArr['sub_category6_name'] = $row->subCat1Name;	
				}	
				elseif(!empty($row->subCat3Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat3Name;
					$returnArr['category_name']      = $row->subCat4Name;
					$returnArr['sub_category1_name'] = $row->subCat5Name;
					$returnArr['sub_category2_name'] = $row->subCat6Name;
					$returnArr['sub_category3_name'] = $row->segName;
					$returnArr['sub_category4_name'] = $row->catName;
					$returnArr['sub_category5_name'] = $row->subCat1Name;
					$returnArr['sub_category6_name'] = $row->subCat2Name;	
				}	
				elseif(!empty($row->subCat4Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat4Name;
					$returnArr['category_name']      = $row->subCat5Name;
					$returnArr['sub_category1_name'] = $row->subCat6Name;
					$returnArr['sub_category2_name'] = $row->segName;
					$returnArr['sub_category3_name'] = $row->catName;
					$returnArr['sub_category4_name'] = $row->subCat1Name;
					$returnArr['sub_category5_name'] = $row->subCat2Name;
					$returnArr['sub_category6_name'] = $row->subCat3Name;	
				}
				elseif(!empty($row->subCat5Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat5Name;
					$returnArr['category_name']      = $row->subCat6Name;
					$returnArr['sub_category1_name'] = $row->segName;
					$returnArr['sub_category2_name'] = $row->catName;
					$returnArr['sub_category3_name'] = $row->subCat1Name;
					$returnArr['sub_category4_name'] = $row->subCat2Name;
					$returnArr['sub_category5_name'] = $row->subCat3Name;
					$returnArr['sub_category6_name'] = $row->subCat4Name;	
				}
				elseif(!empty($row->subCat6Name))
				{
					$returnArr['segment_name'] 	     = $row->subCat6Name;
					$returnArr['category_name']      = $row->segName;
					$returnArr['sub_category1_name'] = $row->catName;
					$returnArr['sub_category2_name'] = $row->subCat1Name;
					$returnArr['sub_category3_name'] = $row->subCat2Name;
					$returnArr['sub_category4_name'] = $row->subCat3Name;
					$returnArr['sub_category5_name'] = $row->subCat4Name;
					$returnArr['sub_category6_name'] = $row->subCat5Name;	
				}					
			}
		}
		$returnArr['productcolorlist']=$this->CI->product_m->get_product_color_list($product_id);
		$returnArr['spid'] = 1000000000+$returnArr['spid'];
		$attrDetails = $this->CI->product_m->admin_product_attributes_details($product_id);	
		//echo "<pre>"; print_r($returnArr['attrDetails']); exit;
		if(!empty($attrDetails))
		{
			$i = 0;
			foreach($attrDetails as $row)
			{
				if(!empty($row->attributeName))
				{
					$returnArr['attributeName'][$i] = $row->attributeName;
				}
				else
				{
					$returnArr['attributeName'][$i] = $row->productAttributeName;
				}
				$returnArr['attributeValue'][$i] = $row->attributeValue;
				$i++;
			}
		}
		return $returnArr;
	}
	
	public function ajax_inventory_list($productId)
	{
		$return			   = array();
		$perPage           = $this->CI->input->post('sel_no_entry');
        $businessName      = trim($this->CI->input->post('businessName'));
		$ownerName         = trim($this->CI->input->post('ownerName'));
		$state             = trim($this->CI->input->post('state'));
		$area              = trim($this->CI->input->post('area'));
        $phone 			   = trim($this->CI->input->post('phone'));
		$salePrice 		   = trim($this->CI->input->post('salePrice'));
		$inventory         = trim($this->CI->input->post('inventory'));
		$productId         = id_decrypt($productId);
		$where = 'organization_product.productId = '.$productId;
       
		if(!empty($businessName))
		{
			$where.= ' AND trim(organization.organizationName) like "'.$businessName.'%"';
		}		
		if(!empty($state))
		{
			$where.=' and trim(state.stateName) like "'.$state.'%"';
		}		
		if(!empty($area))
		{
			$where.=' and trim(area.area) like "'.$area.'%"';
		}		
		if(!empty($ownerName))
		{
			$where .=' and trim(concat(employee.firstName," ",employee.lastName)) like "'.$ownerName.'%"';
		}
		if(!empty($phone))
		{
			$where .=' and trim(employee.businessPhone) like "'.$phone.'%"';
		}
		if(!empty($salePrice))
		{
			//$where .=' and trim(employee.phone) like "'.$salePrice.'%"';
		}
		if(!empty($inventory))
		{
			$where.=' and trim(organization_product.currentQty) like "'.$inventory.'%"';
		}
		
		$total = $this->CI->product_marketing_m->total_product_retailer($where);
        
        $pagConfig = array(
            			'base_url'    => base_url().$this->CI->session->userdata('userType').'/product_management/ajax_inventory_list/'.id_encrypt($productId),
 			           	'total_rows'  => $total,
            			'per_page'    => $perPage,
            			'uri_segment' => 5,
            			'num_links'   => 4
        			);
        
        $this->CI->ajax_pagination->initialize($pagConfig);
        
        $page = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
        
        $return["links"] = $this->CI->ajax_pagination->create_links();
        $return['page']  = $page;
        $result = $this->CI->product_marketing_m->product_retailer_list($page, $pagConfig['per_page'], $where);
		$list   = '';
        if(!empty($result))
		{
			$i = 0;
			foreach($result as $row)
			{
				$productWeight = $row->weight+$row->shippingWeight;
				$priceArr  = $this->CI->product_lib->show_product_price_array($row->organizationProductId);
				$displayPrice = $priceArr['displayPrice'];

				$list[$i]['organizationProductId'] = $row->organizationProductId;
				$list[$i]['organizationName'] = $row->organizationName;
				$list[$i]['firstLastName']    = $row->firstName.' '.$row->lastName;
				$list[$i]['businessPhone']    = $row->businessPhoneCode.$row->businessPhone;
				$list[$i]['stateName']        = $row->stateName;
				$list[$i]['areaName']         = $row->area;
				$list[$i]['currentPrice']     = $displayPrice;
				$list[$i]['currentQty']       = $row->currentQty;
				$i++;
			}
		}
	    $return['list'] = $list;
		return $return;
	}
	
	public function show_product_price_array($organizationProductId)
	{
		$adminPrice 		    = 0;
		$adminFee			    = 0;
		$genuineShippFee		= 0;
		$catCommission1	 		= 0;
		$catCommission2			= 0;
		$spacePointeCommission1 = 0;
		$spacePointeCommission2 = 0;
		$retailerPrice			= 0;
		$retailerQuotePrice     = 0;
		$displayPrice			= 0;
		$organizationProductDet = $this->CI->product_m->product_inventory_history_details($organizationProductId);
		$this->CI->custom_log->write_log('custom_log','organization product details is '.print_r($organizationProductDet,true));
		if(!empty($organizationProductDet))
		{
			$productWeight = $organizationProductDet->weight+$organizationProductDet->shippingWeight;
			if((!empty($organizationProductDet->retailerQuotePrice))&&($organizationProductDet->retailerQuotePrice))
			{
				$retailerQuotePrice = $organizationProductDet->retailerQuotePrice;
			}
			else
			{
				$retailerQuotePrice = $organizationProductDet->currentPrice;
			}
			$priceRangeDet = $this->CI->segment_cat_m->get_price_range($retailerQuotePrice);	
			$this->CI->custom_log->write_log('custom_log','price range details is '.print_r($priceRangeDet,true));
			
			if(!empty($priceRangeDet))
			{
				$spacePointeCommission = $priceRangeDet->spacePointeCommission;
				$adminFee			   = $priceRangeDet->adminFee;
				$genuineShippFee       = $priceRangeDet->genuineShippingFee;
				if($spacePointeCommission)
				{
					$commissionDetails = $this->CI->segment_cat_m->parent_category_with_commission($organizationProductDet->categoryId);
					$this->CI->custom_log->write_log('custom_log','COMMission details is '.print_r($commissionDetails,true));
					if(!empty($commissionDetails))
					{
						$catCommission1 = $commissionDetails->commission;
						$catCommission2 = $commissionDetails->spacepointeCommission2;
					}
					$spacePointeCommission1 = ($retailerQuotePrice*$catCommission1)/100;
					$spacePointeCommission2 = ($retailerQuotePrice*$catCommission2)/100;
				}
				
				if($adminFee)
				{
					$shippRateDet = $this->CI->shipping_m->shipping_rate_with_weight($productWeight);
					$this->CI->custom_log->write_log('custom_log','Shipping Rates details is '.print_r($shippRateDet,true));
					if(!empty($shippRateDet)) 
					{
						if((!empty($productWeight))&&($productWeight>10))
						{
							$adminPrice = (($shippRateDet->minAmount*$productWeight)+($shippRateDet->maxAmoount*$productWeight))/2;
						}
						else
						{
							$adminPrice = ($shippRateDet->minAmount+$shippRateDet->maxAmoount)/2;
						}
					}				
				}
				
				//if((!empty($organizationProductDet->retailerQuotePrice))&&($organizationProductDet->retailerQuotePrice))
				{
					$retailerPrice = $retailerQuotePrice-$spacePointeCommission2;
					$displayPrice  = $retailerPrice+$spacePointeCommission1+$spacePointeCommission2+$adminPrice;
				}
				/*else
				{
					$retailerPrice = $organizationProductDet->currentPrice;
					$displayPrice  = $retailerPrice+$spacePointeCommission1+$adminPrice;
				}*/
			}
			else
			{
				$displayPrice = $retailerQuotePrice;
			}
		}
		
		$returnArr	= array(
						'retailerQuotedPrice'         => $retailerQuotePrice,
						'retailerPrice'               => $retailerPrice,
						'spacePointeCommissionPrice'  => $spacePointeCommission1,
						'spacePointeCommissionPrice2' => $spacePointeCommission2,
						'adminPrice'                  => $adminPrice,
						'displayPrice'                => $displayPrice,
						'genuineShippFee'			  => $genuineShippFee,
						'categoryCommission'          => $catCommission1,
						'categoryCommission2'         => $catCommission2,
						'cashAdminFee'				  => $adminFee,
					 );
		return $returnArr;		
	}
	
	public function check_stock_list_ajax()
	{
		$return         = array();
		$perPage        = $this->CI->input->post('sel_no_entry');
		$productName    = trim($this->CI->input->post('productName'));
		$organizationId = $this->CI->input->post('organizationId');
		$where          = 'organizationId = '.$organizationId;
		
		if(!empty($productName))
		{
			$where.= ' AND trim(product.code) like "'.$productName.'%"';
		}	
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total 	   = $this->CI->product_m->total_check_stocks($where);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/check_stock_management/ajaxFun',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$stockLists = $this->CI->product_m->check_stocks_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($stockLists); exit;
		
		foreach($stockLists as $rowVal)
		{
			$productWeight = $rowVal->weight+$rowVal->shippingWeight;
			$priceArr      = $this->CI->product_lib->show_product_price_array($rowVal->organizationProductId);
			$displayPrice  = $priceArr['displayPrice'];
			
			$return['list'][$rowVal->organizationProductId]['organizationProductId'] = $rowVal->organizationProductId;
			$return['list'][$rowVal->organizationProductId]['organizationId']        = $rowVal->organizationId;
			$return['list'][$rowVal->organizationProductId]['imageName']             = $rowVal->imageName;
			$return['list'][$rowVal->organizationProductId]['code']                  = $rowVal->code;
			$return['list'][$rowVal->organizationProductId]['retailerPrice']         = $rowVal->currentPrice;
			$return['list'][$rowVal->organizationProductId]['displayPrice']          = $displayPrice;
			$return['list'][$rowVal->organizationProductId]['currentQty']            = $rowVal->currentQty;
		}
		
		$return['links'] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		$return['organizationId'] = $organizationId;
		return $return;
	}
	
	public function check_stock_inventory_details($organizationProductId,$organizationId)
	{
		$return = array();
		$return['stock']                  = 0;
		$return['retailerQuotePrice']	  = '';
		$return['retailerPrice']          = '';
		$return['spacePointeCommission1'] = '';
		$return['spacePointeCommission2'] = '';
		$return['adminPrice']		      = 0;
		$return['handlingPrice']		  = '';		
		$return['displayPrice']		      = '';
		$return['catCommission']          = 0;
		$return['productName']            = '';
		$return['currentQty']             = '';
		$return['editinventory']          = 'add';
		$return['inventory']              = '';
		$return['imageName']              = '';
		$return['productId']              = '';
		$return['product_size']           = '';
		$productWeight      = 0;
		
		$details = $this->CI->product_m->inventory_details($organizationProductId);
		//echo "<pre>"; print_r($details); exit;
		if(!empty($details))
		{
			$return['productcolorlist']	= $this->CI->product_m->get_product_color_list($details->productId);
			$return['product_size'] 	= $this->CI->product_m->product_all_size($details->productId);
			$return['productName']      = $details->code;
			$return['currentQty']       = $details->currentQty;
			$return['imageName']        = $details->imageName;
			$return['productId']        = $details->productId;
			$return['stock']            = $details->stock;
			$return['colorId'] 	        = $details->colorId;
			$return['availablecolor']   = '';
			
			
			$productWeight   = $details->weight+$details->shippingWeight;
			$priceDetailsArr = $this->CI->product_lib->show_product_price_array($organizationProductId);
			//echo "<pre>"; print_r($priceDetailsArr); exit;
			$return['retailerQuotePrice']     = $priceDetailsArr['retailerQuotedPrice'];
			$return['retailerPrice']          = $priceDetailsArr['retailerPrice'];
			$return['spacePointeCommission1'] = $priceDetailsArr['spacePointeCommissionPrice'];
			$return['spacePointeCommission2'] = $priceDetailsArr['spacePointeCommissionPrice2'];
			$return['catCommission']		  = $priceDetailsArr['categoryCommission'];
			$return['adminPrice']    		  = $priceDetailsArr['adminPrice']; 
			$return['handlingPrice'] 		  = 0;
			$return['displayPrice'] 		  = $priceDetailsArr['displayPrice'];
			
		}
		
		$return['cashAdminPrice'] = $return['adminPrice'];
		if($_POST)
		{
			$return['editinventory']   = $this->CI->input->post('editinventory');
			$return['inventory']       = $this->CI->input->post('inventory');
			$return['singleinventory'] = $return['inventory'];
			if(isset($_POST['selectsize']))
			{
				$return['selectsize'] = $this->CI->input->post('selectsize');
				
				$multiplier = count($return['selectsize']);
				$return['inventory'] = $multiplier*$return['inventory'];
			}
			else
			{
				$return['inventory']=$return['inventory'];
			}
			
			if(isset($_POST['availablecolor']))
			{
				$return['availablecolor'] = $this->CI->input->post('availablecolor');
				$colormultiplier          =	count($return['availablecolor']);
				$return['inventory']      = $colormultiplier*$return['inventory'];
			}
			else
			{
				$return['inventory'] = $return['inventory'];
			}
			
			$rules = edit_inventory_rules();
			if(!empty($return['productcolorlist']))
			{
				$rules[] = array(
								'field' => 'availablecolor[]',
								'label' => 'color',
								'rules' => 'trim|required'
							);
			}
			
			if(!empty($return['product_size']))
			{
				$rules[] = array(
								'field' => 'selectsize[]',
								'label' => 'size',
								'rules' => 'trim|required'
							);
			}
			
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{	//echo "<pre>"; print_r($_POST); exit;
				if($return['editinventory']=='add')
				{					
					$totalInventory = $return['currentQty']+$return['inventory'];
					if($totalInventory<0)
					{
						$totalInventory = 0;
					}
					
					if(!empty($details))
					{
						$updateTtl = $this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
					}
					else
					{
						$updateTtl = $this->CI->product_m->edit_inventory_first_time($organizationProductId,$totalInventory);
					}
					
					if($updateTtl)
					{
						/*********Inventory History Start******************/
						$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
						$return['organizationProductId'] = $organizationProductId;
						$return['organizationId']        = $details->organizationId;
						$return['stock']                 = $totalInventory; 
						$inventoryHistoryId = $this->CI->product_m->add_inventory_history($return);
						$this->CI->custom_log->write_log('custom_log','last query is '.$this->CI->db->last_query());
						$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
						/*********Inventory History End  ******************/
				
						if(!empty($return['selectsize']))
						{
							foreach($return['selectsize'] as $single_size)
							{
								$total_qty = $return['singleinventory'];
								
								$lastSizeInveDet = $this->CI->product_m->last_size_organization_stock($organizationProductId,$single_size);
								//echo "<pre>"; print_r($lastSizeInveDet); exit;
								$this->CI->custom_log->write_log('custom_log','organization product size stock details is '.print_r($lastSizeInveDet,true));
								if(!empty($lastSizeInveDet))
								{
									$total_qty = $total_qty+$lastSizeInveDet->currentStock;
								}
								
								$this->CI->product_m->unactive_old_size($organizationProductId,$single_size);
								$organizationProductStockId = $this->CI->product_m->add_organization_size_stock($organizationProductId,$total_qty,$single_size);
								$this->CI->custom_log->write_log('custom_log','organization product size stock id is '.$organizationProductStockId);
								$organizationSizeIdArray[$organizationProductStockId]['id'] = $organizationProductStockId;
								$organizationSizeIdArray[$organizationProductStockId]['productSizeId'] = $single_size;
								$organizationSizeIdArray[$organizationProductStockId]['currentStock']  = $total_qty;
							
							}
						}
						
						if(!empty($return['availablecolor']))
						{
							foreach($return['availablecolor'] as $color)
							{
								$total_qty = $return['singleinventory'];
								$lastColrInveDet = $this->CI->product_m->last_color_organization_stock($organizationProductId,$color);
								$this->CI->custom_log->write_log('custom_log','organization product color stock details is '.print_r($lastColrInveDet,true));
								if(!empty($lastColrInveDet))
								{
									$total_qty = $total_qty+$lastColrInveDet->currentStock;
								}
								$this->CI->product_m->unactive_organization_colors($organizationProductId,$color);
								$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$total_qty,$color);
								$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
								$organizationColorIdArray[$organizationColorId]['id']           = $organizationColorId;
								$organizationColorIdArray[$organizationColorId]['colorId']      = $color;
								$organizationColorIdArray[$organizationColorId]['currentStock'] = $total_qty;
							}
						}
						
						/*********organziation product color size combination history***************************/
						if((!empty($organizationColorIdArray))&&(!empty($organizationSizeIdArray)))
						{
							foreach($organizationColorIdArray as $colorId=>$colorVal)
							{
								foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
								{
									$stockIs = $return['singleinventory'];
									$oldClrSizeDet = $this->CI->product_m->old_organization_color_size_stock($organizationProductId,$colorVal['colorId'],$sizeVal['productSizeId']);
									$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
									$this->CI->product_m->unactive_organization_color_size_stock($organizationProductId,$colorVal['colorId'],$sizeVal['productSizeId']);
									$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
									if(!empty($oldClrSizeDet))
									{
										$stockIs = $stockIs+$oldClrSizeDet->currentStock;
									}
									$this->CI->custom_log->write_log('custom_log','size stock is '.$stockIs);
									
									$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,$sizeId,$colorVal['colorId'],$sizeVal['productSizeId'],$stockIs);
									$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
								}
							}
						}
						elseif(!empty($organizationColorIdArray))
						{
							foreach($organizationColorIdArray as $colorId=>$colorVal)
							{
								$stockIs = $return['singleinventory'];
								$oldClrSizeDet = $this->CI->product_m->old_organization_color_size_stock($organizationProductId,$colorVal['colorId'],0);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								$this->CI->product_m->unactive_organization_color_size_stock($organizationProductId,$colorVal['colorId'],0);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								if(!empty($oldClrSizeDet))
								{
									$stockIs = $stockIs+$oldClrSizeDet->currentStock;
								}
								$this->CI->custom_log->write_log('custom_log','size stock is '.$stockIs);
									
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,0,$colorVal['colorId'],0,$stockIs);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
						elseif(!empty($organizationSizeIdArray))
						{
							foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
							{
								$stockIs = $return['singleinventory'];
								$oldClrSizeDet = $this->CI->product_m->old_organization_color_size_stock($organizationProductId,0,$sizeVal['productSizeId']);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								$this->CI->product_m->unactive_organization_color_size_stock($organizationProductId,0,$sizeVal['productSizeId']);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								if(!empty($oldClrSizeDet))
								{
									$stockIs = $stockIs+$oldClrSizeDet->currentStock;
								}
								$this->CI->custom_log->write_log('custom_log','size stock is '.$stockIs);
								
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,0,$sizeId,0,$sizeVal['productSizeId'],$stockIs);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
						/*********organziation product color size combination history***************************/
						
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_inventory'));	
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_inventory'));
					}
				}
				elseif($return['editinventory']=='sub')
				{
					$totalInventory = $return['currentQty']-$return['inventory'];
					if($totalInventory<0)
					{
						$totalInventory = 0;
					}
					
					if(!empty($details))
					{
						$updateTtl = $this->CI->product_m->edit_inventory($organizationProductId,$totalInventory);
					}
					else
					{
						$updateTtl = $this->CI->product_m->edit_inventory_first_time($organizationProductId,$totalInventory);
					}
					
					if($updateTtl)
					{
						/*********Inventory History Start******************/
						$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
						$return['organizationProductId'] = $organizationProductId;
						$return['organizationId']        = $details->organizationId;
						$return['stock']                 = $totalInventory; 
						$inventoryHistoryId = $this->CI->product_m->add_inventory_history($return);
						$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
						/*********Inventory History End  ******************/
						
						if(!empty($return['selectsize']))
						{
							foreach($return['selectsize'] as $single_size)
							{
								$total_qty = $return['singleinventory'];
								
								$lastSizeInveDet = $this->CI->product_m->last_size_organization_stock($organizationProductId,$single_size);
								//echo "<pre>"; print_r($lastSizeInveDet); exit;
								$this->CI->custom_log->write_log('custom_log','organization product size stock details is '.print_r($lastSizeInveDet,true));
								if(!empty($lastSizeInveDet))
								{
									$total_qty = $lastSizeInveDet->currentStock-$total_qty;
									if($total_qty<0)
									{
										$total_qty = 0;
									}
								}
								
								$this->CI->product_m->unactive_old_size($organizationProductId,$single_size);
								$organizationProductStockId = $this->CI->product_m->add_organization_size_stock($organizationProductId,$total_qty,$single_size);
								$this->CI->custom_log->write_log('custom_log','organization product size stock id is '.$organizationProductStockId);
								$organizationSizeIdArray[$organizationProductStockId]['id'] = $organizationProductStockId;
								$organizationSizeIdArray[$organizationProductStockId]['productSizeId'] = $single_size;
								$organizationSizeIdArray[$organizationProductStockId]['currentStock'] = $total_qty;
							
							}
						}
						
						if(!empty($return['availablecolor']))
						{
							foreach($return['availablecolor'] as $color)
							{
								$total_qty = $return['singleinventory'];
								$lastColrInveDet = $this->CI->product_m->last_color_organization_stock($organizationProductId,$color);
								$this->CI->custom_log->write_log('custom_log','organization product color stock details is '.print_r($lastColrInveDet,true));
								if(!empty($lastColrInveDet))
								{
									$total_qty = $lastColrInveDet->currentStock-$total_qty;
									if($total_qty<0)
									{
										$total_qty = 0;
									}
								}
								$this->CI->product_m->unactive_organization_colors($organizationProductId,$color);
								$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$total_qty,$color);
								$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
								$organizationColorIdArray[$organizationColorId]['id'] = $organizationColorId;
								$organizationColorIdArray[$organizationColorId]['colorId'] = $color;
								$organizationColorIdArray[$organizationColorId]['currentStock'] = $total_qty;
							}
						}
						
						/*********organziation product color size combination history***************************/
						if((!empty($organizationColorIdArray))&&(!empty($organizationSizeIdArray)))
						{
							foreach($organizationColorIdArray as $colorId=>$colorVal)
							{
								foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
								{
									$stockIs = $return['singleinventory'];
									$oldClrSizeDet = $this->CI->product_m->old_organization_color_size_stock($organizationProductId,$colorVal['colorId'],$sizeVal['productSizeId']);
									$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
									$this->CI->product_m->unactive_organization_color_size_stock($organizationProductId,$colorVal['colorId'],$sizeVal['productSizeId']);
									$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
									if(!empty($oldClrSizeDet))
									{
										$stockIs = $oldClrSizeDet->currentStock-$stockIs;
										if($stockIs<0)
										{
											$stockIs = 0;
										}
									}
									$this->CI->custom_log->write_log('custom_log','size stock is '.$stockIs);
									
									$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,$sizeId,$colorVal['colorId'],$sizeVal['productSizeId'],$stockIs);
									$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
								}
							}
						}
						elseif(!empty($organizationColorIdArray))
						{
							foreach($organizationColorIdArray as $colorId=>$colorVal)
							{
								$stockIs = $return['singleinventory'];
								$oldClrSizeDet = $this->CI->product_m->old_organization_color_size_stock($organizationProductId,$colorVal['colorId'],0);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								$this->CI->product_m->unactive_organization_color_size_stock($organizationProductId,$colorVal['colorId'],0);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								if(!empty($oldClrSizeDet))
								{
									$stockIs = $oldClrSizeDet->currentStock-$stockIs;
									if($stockIs<0)
									{
										$stockIs = 0;
									}
								}
								$this->CI->custom_log->write_log('custom_log','size stock is '.$stockIs);
									
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,0,$colorVal['colorId'],0,$stockIs);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
						elseif(!empty($organizationSizeIdArray))
						{
							foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
							{
								$stockIs = $return['singleinventory'];
								$oldClrSizeDet = $this->CI->product_m->old_organization_color_size_stock($organizationProductId,0,$sizeVal['productSizeId']);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								$this->CI->product_m->unactive_organization_color_size_stock($organizationProductId,0,$sizeVal['productSizeId']);
								$this->CI->custom_log->write_log('custom_log','color size details is '.print_r($oldClrSizeDet,true));
								if(!empty($oldClrSizeDet))
								{
									$stockIs = $oldClrSizeDet->currentStock-$stockIs;
									if($stockIs<0)
									{
										$stockIs = 0;
									}
								}
								$this->CI->custom_log->write_log('custom_log','size stock is '.$stockIs);
									
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,0,$sizeId,0,$sizeVal['productSizeId'],$stockIs);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
						/*********organziation product color size combination history***************************/
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_inventory'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_inventory'));
					}
				}
				
				if(($this->CI->session->userdata('userType')=='cse')||($this->CI->session->userdata('userType')=='superadmin'))
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/inventory_details/'.id_encrypt($organizationProductId).'/'.id_encrypt($organizationId));
				}
				else
				{
					redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/inventory_details/'.id_encrypt($organizationProductId));
				}
			}
		}
		
		//$organizationColors 	 = $this->CI->product_m->organization_product_colors($organizationProductId);
		$organizationColorsSizes = $this->CI->product_m->organization_color_size_details($organizationProductId);
		$organizationColorsSizeArray = array();
		$organizationSizesArray		 = array();
		if(!empty($organizationColorsSizes))
		{
			foreach($organizationColorsSizes as $row)
			{
				if(!empty($row->colorId))
				{
					$organizationColorsSizeArray[$row->colorId]['organizationProductColorId'] = $row->organizationProductColorId;
					$organizationColorsSizeArray[$row->colorId]['colorCode'] 	 = $row->colorCode;
					$organizationColorsSizeArray[$row->colorId]['currentStock'] = $row->currentStock;
					
					if(!empty($row->productSizeId))
					{
						if(!empty($row->sizes))
						{
							$organizationColorsSizeArray[$row->colorId]['sizes'][$row->sizes]['currentStock'] = $row->currentStock;
						}
					}
				}
			}
		}
		
		if((empty($organizationColorsSizeArray))&&(count($organizationColorsSizeArray)<1))
		{
			if(!empty($organizationColorsSizes))
			{
				foreach($organizationColorsSizes as $row)
				{
					if(!empty($row->productSizeId))
					{
						if(!empty($row->sizes))
						{
							$organizationSizesArray[$row->sizes]['currentStock'] = $row->currentStock;
						}
					}
				}
			}
		}
		
		//echo "<pre>"; print_r($organizationColorsSizeArray); exit;
		/*
		if((!empty($organizationColors))&&(!empty($organizationColors)))
		{
			foreach($organizationColors as $colorRow)
			{
				$organizationColorsArray[$colorRow->colorId]['organizationProductColorId'] = $colorRow->organizationProductColorId;
				$organizationColorsArray[$colorRow->colorId]['colorCode'] 	 = $colorRow->colorCode;
				$organizationColorsArray[$colorRow->colorId]['currentStock'] = $colorRow->currentStock;
				
				foreach($organizationSizes as $sizeRow)
				{
					if($colorRow->organizationProductSizeId==$sizeRow->organizationProductSizeId)
					{
						if(!empty($sizeRow->size))
						{
							$organizationColorsArray[$colorRow->colorId]['sizes'][$sizeRow->size]['currentStock'] = $sizeRow->currentStock;
						}
						elseif(!empty($sizeRow->sizes))
						{
							$expArr = explode(',',$sizeRow->sizes);
							foreach($expArr as $expRow)
							{
								if(!empty($expRow))
								{
									$organizationColorsArray[$colorRow->colorId]['sizes'][$expRow]['currentStock'] = $sizeRow->currentStock;
								}
							}
							
						}	
					}
				}
			}
		}
		elseif(!empty($organizationColors))
		{
			foreach($organizationColors as $colorRow)
			{
				$organizationColorsArray[$colorRow->colorId]['organizationProductColorId'] = $colorRow->organizationProductColorId;
				$organizationColorsArray[$colorRow->colorId]['colorCode'] 	 = $colorRow->colorCode;
				$organizationColorsArray[$colorRow->colorId]['currentStock'] = $colorRow->currentStock; 
			}
		}
		elseif(!empty($organizationSizes))
		{
			foreach($organizationSizes as $sizeRow)
			{
				if(!empty($sizeRow->size))
				{
					$organizationSizesArray[$sizeRow->size]['currentStock'] = $sizeRow->currentStock;
					$organizationSizesArray[$sizeRow->size]['organizationProductSizeId'] = $sizeRow->organizationProductSizeId;
				}
				elseif(!empty($sizeRow->sizes))
				{
					$expArr = explode(',',$sizeRow->sizes);
					foreach($expArr as $expRow)
					{
						if(!empty($expRow))
						{
							$organizationSizesArray[$expRow]['currentStock'] = $sizeRow->currentStock;
							$organizationSizesArray[$expRow]['organizationProductSizeId'] = $sizeRow->organizationProductSizeId;
						}
					}
					
				}	
			}
		}
		*/
		$return['organizationColorsSizeArray'] = $organizationColorsSizeArray;
		$return['organizationSizesArray']      = $organizationSizesArray;
		//echo "<pre>"; print_r($return); exit;
		return $return;
	}
	
	public function add_check_stock_list_ajax()
	{
		$perPage	     = $this->CI->input->post('sel_no_entry');
		$productName     = trim($this->CI->input->post('productName'));			
		$productCategory = trim($this->CI->input->post('productCategory'));
		$brandName       = trim($this->CI->input->post('brandName'));
		$organizationId  = $this->CI->input->post('organizationId');
		$where 		     = '';
		
		//echo "<pre>"; print_r($_POST); exit;
		if(!empty($productName))
		{
			$productName  = trim(preg_replace('/^([\'"])(.*)\\1$/','\\2',$productName)); 
			$where = "trim(product.code) LIKE '".mysql_real_escape_string($productName)."%'";
		}
		if(!empty($productCategory))
		{
			if($where)
			{
				$where.= " AND trim(category.categoryCode) LIKE '".$productCategory."%'";
			}
			else
			{
				$where = "trim(category.categoryCode) LIKE '".$productCategory."%'";
			}
		}
		
		if(!empty($brandName))
		{
			if($where)
			{
				$where.= " AND trim(brand.brandName) LIKE '".$brandName."%'";
			}
			else
			{
				$where = "trim(brand.brandName) LIKE '".$brandName."%'";
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total = $this->CI->product_m->total_general_products($where);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/check_stock_management/add_check_stock_list_ajax',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
				  
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		
		$returnArr["links"]   = $this->CI->ajax_pagination->create_links();
		$returnArr['page']    = $page;
		$returnArr['list']    = $this->CI->product_m->general_products_list($page,$pagConfig['per_page'],$where);	
		$returnArr['organizationId'] = $organizationId;	
		return $returnArr;
	}
	
	public function add_check_stock_inventory($organizationId,$productId)
	{
		$userType = $this->CI->session->userdata('userType');
		
		$returnArr 					         = array();
		$returnArr['stock'] 	             = '';
		$returnArr['retailerQuotePrice']     = '';
		$returnArr['retailerPrice']          = '';
		$returnArr['spacePointeCommission1'] = '';
		$returnArr['spacePointeCommission2'] = '';
		$returnArr['cashAdminPrice']		 = '';		
		$returnArr['displayPrice']		     = '';
		$returnArr['organizationId']         = $organizationId;
		$returnArr['productId'] 	         = $productId;
		$returnArr['availableSize']		     = '';
		$returnArr['product_size']           = '';
		$returnArr['catCommission1']         = 0;
		$returnArr['catCommission2']         = 0;
		$returnArr['productWeight']          = 0;
		$returnArr['productcolorlist'] 		 = $this->CI->product_m->get_product_color_list($productId);
		
		$productDetails = $this->CI->product_m->product_brand_image_category_details_row($productId);
		//echo "<pre>"; print_r($productDetails); exit;
		if(!empty($productDetails))
		{
			$returnArr['product_size'] 		 = $this->CI->product_m->product_all_size($productId);
			$returnArr['productName'] 		 = $productDetails->code;
			$returnArr['productDescription'] = $productDetails->description;
			$returnArr['imageName'] 		 = $productDetails->imageName;
			$returnArr['productWeight']      = $productDetails->weight+$productDetails->shippingWeight;
		
			$commissionDetails = $this->CI->segment_cat_m->parent_category_with_commission($productDetails->categoryId);
			//echo "<pre>"; print_r($commissionDetails); exit;
			$this->CI->custom_log->write_log('custom_log','commission details is '.print_r($commissionDetails,true));
			
			if(!empty($commissionDetails))
			{
				$returnArr['catCommission1'] = $commissionDetails->commission;
				$returnArr['catCommission2'] = $commissionDetails->spacepointeCommission2;
				
				$shippRateDet = $this->CI->shipping_m->shipping_rate_with_weight($returnArr['productWeight']);
				$this->CI->custom_log->write_log('custom_log','shipping rate details is '.print_r($shippRateDet,true));
				//echo "<pre>"; print_r($shippRateDet); exit;	
				if(!empty($shippRateDet))
				{
					if((!empty($returnArr['productWeight']))&&($returnArr['productWeight']>10))
					{
						$returnArr['cashAdminPrice'] = (($shippRateDet->minAmount*$returnArr['productWeight'])+($shippRateDet->maxAmoount*$returnArr['productWeight']))/2;	
					}
					else
					{
						$returnArr['cashAdminPrice'] = ($shippRateDet->minAmount+$shippRateDet->maxAmoount)/2;
					}
				}
			}
		}
		
		$inventoryDet = $this->CI->product_m->organization_with_product_details($organizationId,$productId);
		$this->CI->custom_log->write_log('custom_log','inventory details is '.print_r($inventoryDet,true));
		//echo "<pre>"; print_r($inventoryDet); exit;
		if(!empty($inventoryDet))
		{
			$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_inventory_already'));
			if($this->CI->session->userdata('userType')=='retailer')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/product_management');
			}
			if($this->CI->session->userdata('userType')=='cse')
			{
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId));	
			}
		}
		
		if($_POST)
		{	//echo "<pre>"; print_r($_POST); exit;
			$this->CI->custom_log->write_log('custom_log','submit form is '.print_r($_POST,true));
			$rules = add_product_inventory_rules();
			$returnArr['productcolorlist'] = array_filter($returnArr['productcolorlist']);
			
			if(!empty($returnArr['productcolorlist']))
			{
				$rules[] = array(
								'field' => 'availablecolor[]',
								'label' => 'color',
								'rules' => 'trim|required'
							);
			}
			
			
			if(!empty($returnArr['product_size']))
			{
				$rules[] = array(
								'field' => 'availablesize[]',
								'label' => 'size',
								'rules' => 'trim|required'
							);
			}
			
			$returnArr['stock']                  = $this->CI->input->post('stock');
			$returnArr['retailerQuotePrice']     = $this->CI->input->post('retailerQuotePrice');
			$returnArr['retailerPrice']          = $this->CI->input->post('retailerPrice');
			$returnArr['spacePointeCommission1'] = $this->CI->input->post('spacePointeCommission1');
			$returnArr['spacePointeCommission2'] = $this->CI->input->post('spacePointeCommission2');
			$returnArr['cashAdminPrice']		 = $this->CI->input->post('cashAdminPrice');		
			$returnArr['displayPrice']		     = $this->CI->input->post('displayPrice');
			$returnArr['stockvalue']             = $returnArr['stock'];
			$available_color                     = '';
			
			if(isset($_POST['availablesize']))
			{
				$sizeArray       = $this->CI->input->post('availablesize');
				$available_size  = array_values($sizeArray);
				$stockmultiplier = count($available_size);
				
				$returnArr['stock']         = $returnArr['stock']*$stockmultiplier;
				$returnArr['availablesize'] = implode(',',$available_size);
			}
			
			if(isset($_POST['availablecolor']))
			{
				$colorArray         = $this->CI->input->post('availablecolor');
				$available_color    = array_values($colorArray);
				$colormultiplier    = count($available_color);
				$returnArr['stock'] = $returnArr['stock']*$colormultiplier;
			}
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$organizationProductId = $this->CI->product_m->add_organization_product($organizationId,$productId,$returnArr);
				$this->CI->custom_log->write_log('custom_log','organization product id is '.$organizationProductId);
				
				/*********Inventory History Start******************/
				$this->CI->product_m->unactive_old_inventory_history($organizationProductId);
				$returnArr['organizationProductId'] = $organizationProductId;
				$returnArr['organizationId']        = $organizationId;
				$returnArr['productId']             = $productId;
				$inventoryHistoryId = $this->CI->product_m->add_inventory_history($returnArr);
				$this->CI->custom_log->write_log('custom_log','Inventory history id is '.$inventoryHistoryId);
				/*********Inventory History End  ******************/
				
				if($organizationProductId)
				{
					$organizationColorIdArray = array();
					$organizationSizeIdArray  = array();
							
					if(!empty($sizeArray))
					{
						foreach($sizeArray as $size)
						{
							$organizationProductStockId = $this->CI->product_m->add_organization_size_stock($organizationProductId,$returnArr['stockvalue'],$size);
							$this->CI->custom_log->write_log('custom_log','organization product size stock id is '.$organizationProductStockId);
							$organizationSizeIdArray[$organizationProductStockId]['id'] = $organizationProductStockId;
							$organizationSizeIdArray[$organizationProductStockId]['productSizeId'] = $size;
						}
					}
					if(!empty($colorArray))
					{
						if((!empty($available_color))&&(is_array($available_color)))
						{
        					foreach($available_color as $singlecolor) 
							{
								$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$returnArr['stockvalue'],$singlecolor);
								$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
								$organizationColorIdArray[$organizationColorId]['id'] = $organizationColorId;
								$organizationColorIdArray[$organizationColorId]['colorId'] = $singlecolor;
							}
				        }
						elseif(!empty($available_color)) 
						{
							$organizationColorId = $this->CI->product_m->add_organization_color_stock($organizationProductId,$returnArr['stockvalue'],$available_color);
							$this->CI->custom_log->write_log('custom_log','organization color stock id is '.$organizationColorId);
							$organizationColorIdArray[$organizationColorId]['id'] = $organizationColorId;
							$organizationColorIdArray[$organizationColorId]['colorId'] = $available_color;
						}
					}
					//echo "<pre>"; print_r($organizationSizeIdArray); exit;
					/*********organziation product color size combination history***************************/
					if((!empty($organizationColorIdArray))&&(!empty($organizationSizeIdArray)))
					{
						foreach($organizationColorIdArray as $colorId=>$colorVal)
						{
							foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
							{
								$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,$sizeId,$colorVal['colorId'],$sizeVal['productSizeId'],$returnArr['stockvalue']);
								$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
							}
						}
					}
					elseif(!empty($organizationColorIdArray))
					{
						foreach($organizationColorIdArray as $colorId=>$colorVal)
						{
							$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,$colorId,0,$colorVal['colorId'],0,$returnArr['stockvalue']);
							$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
						}
					}
					elseif(!empty($organizationSizeIdArray))
					{
						foreach($organizationSizeIdArray as $sizeId=>$sizeVal)
						{
							$organizationColorSizeId = $this->CI->product_m->add_organization_color_size_stock($organizationProductId,0,$sizeId,0,$sizeVal['productSizeId'],$returnArr['stockvalue']);
							$this->CI->custom_log->write_log('custom_log','organization color size stock id is '.$organizationColorSizeId);
						}
					}
					/*********organziation product color size combination history***************************/
					
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_inventory'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_inventory'));
				}
				else
				{
					$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_inventory'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_inventory'));	
				}	
				
				redirect(base_url().$this->CI->session->userdata('userType').'/check_stock_management/check_stock_list/'.id_encrypt($organizationId));					
			}			
		} 
		
		//echo "<pre>"; print_r($returnArr); exit;
		return $returnArr;
	}

}