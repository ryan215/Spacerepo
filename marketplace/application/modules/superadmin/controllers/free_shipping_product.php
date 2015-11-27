<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Free_shipping_product extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Free Shipping Product';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'free_shipping_product_index',
				'log_MID'    => '' 
		) );
		
		$this->superAdminCustomView('free_shipping_product/free_shipping_product_list',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$result       = array();
		$per_page     = $this->input->post('sel_no_entry');
		$where  	  = '';
		$productName  = $this->input->post('productName');
		$categoryName = $this->input->post('categoryName');
		$brandName    = $this->input->post('brandName');
		
		if(!empty($productName))
		{
			$where = 'product.code Like "'.$productName.'%"';
		}
		if(!empty($categoryName))
		{
			if(!empty($where))
			{
				$where = ' AND category.categoryCode Like "'.$categoryName.'%"';
			}
			else
			{
				$where = 'category.categoryCode Like "'.$categoryName.'%"';
			}
		}
		if(!empty($brandName))
		{
			if(!empty($where))
			{
				$where = ' AND brand.brandName Like "'.$brandName.'%"';
			}
			else
			{
				$where = 'brand.brandName Like "'.$brandName.'%"';
			}
		}
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total = $this->product_m->total_free_shipping_product($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/free_shipping_product/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$result['list']  = $this->product_m->free_shipping_product_list($page,$pagConfig['per_page'],$where);
		$result["links"] = $this->ajax_pagination->create_links();
		$result['page']  = $page;	
		$this->data['result'] = $result;
		$this->load->view('free_shipping_product/ajaxPagView',$this->data);		
	}
	
	public function add_free_shipping_product()
	{				
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_free_shipping_product',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Add Free Shipping Product';
		$result = array();
		$result['catList'] = $this->segment_cat_m->category_list();
		
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','After form submit is '.print_r($_POST,true));
			
			$rules = add_free_shipping_product_rules();						
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$lastLevelCatId = 0;
				foreach($_POST as $key=>$value)
				{
					if($key!='productList')
					{
						if(!empty($value))
						{
							$lastLevelCatId  = $value;
							$freeShippCatDet = $this->segment_cat_m->free_shippng_cat_details($value);
							if(!empty($freeShippCatDet))
							{
								$this->custom_log->write_log('custom_log','free shipping category details '.print_r($freeShippCatDet,true));
								$this->session->set_flashdata('error','This '.$freeShippCatDet->categoryCode.' category already added in Free shipping category');
								$this->custom_log->write_log('custom_log','This '.$freeShippCatDet->categoryCode.' category already added in Free shipping category');
								redirect(base_url().$this->session->userdata('userType').'/free_shipping_product');
							}
						}
					}
				}
				$this->custom_log->write_log('custom_log','Last Level Category Id is '.$lastLevelCatId);
				
				$productIdList = $this->input->post('productList');
				$this->custom_log->write_log('custom_log','product id list is '.print_r($productIdList,true));
				
				if(($lastLevelCatId)&&(!empty($productIdList)))
				{
					$flag = FALSE;
					foreach($productIdList as $productId)
					{
						$freeShipPrdDet = $this->product_m->free_shipping_prd_details($productId);
						$this->custom_log->write_log('custom_log','free shipping product details is '.print_r($freeShipPrdDet,true));
						if(empty($freeShipPrdDet))
						{
							$flag = TRUE;
							$freeShipPrdId = $this->product_m->add_free_shipping_product($lastLevelCatId,$productId);
							$this->custom_log->write_log('custom_log','free shipping product id is '.$freeShipPrdId);
						}
					}
					
					if($flag)
					{
						$this->session->set_flashdata('success','Free shipping product added successfully');
						$this->custom_log->write_log('custom_log','Free shipping product added successfully');
					}
					else
					{
						$this->session->set_flashdata('error','Free shipping product already added');
						$this->custom_log->write_log('custom_log','Free shipping product already added');
					}
				}
				else
				{
					$this->session->set_flashdata('error','category level not selected');
					$this->custom_log->write_log('custom_log','category level not selected');
				}				
				redirect(base_url().$this->session->userdata('userType').'/free_shipping_product');
			}
		}
	
		$this->data['result'] = $result;
		$this->superAdminCustomView('free_shipping_product/free_shipping_product_add',$this->data);
	}
	
	public function delete_free_shipping_product($freeShipPrdId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_free_shipping_product',
				'log_MID'    => '' 
		) );
		
		$freeShipPrdId = id_decrypt($freeShipPrdId);
		$this->custom_log->write_log('custom_log','free shipping product id is '.$freeShipPrdId);
		
		if($freeShipPrdId)
		{
			if($this->product_m->delete_free_shipping_product($freeShipPrdId))
			{
				$this->session->set_flashdata('success','Free shipping product deleted successfully');
				$this->custom_log->write_log('custom_log','Free shipping product deleted successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Free shipping product not delete');
				$this->custom_log->write_log('custom_log','Free shipping product not delete');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Free shipping product not found');
			$this->custom_log->write_log('custom_log','Free shipping product not found');
		}
		redirect(base_url().$this->session->userdata('userType').'/free_shipping_product');
	}
	
	public function level_category_list($parentCatID=0,$nextLevel=0)
	{
		$result = array();
		$productName  = $this->input->post('productName');
		$categoryName = $this->input->post('categoryName');
		$brandName    = $this->input->post('brandName');
		
		$where  = 'product_category.categoryId = '.$parentCatID;
		$result['productList']         = '';
		$this->data['nextLevel']       = $nextLevel;
		$this->data['nextToNextLevel'] = $nextLevel+1;
		$this->data['catList']         = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		$result['catList'] = $this->load->view('admin/category_managements/level_category_list',$this->data,true);
		if($parentCatID)
		{
			$whereArr = array();
			$childListRs = $this->segment_cat_m->category_child_list($parentCatID);	
			if(!empty($childListRs))
			{
				$whereArr[$parentCatID] = 'product_category.categoryId = '.$parentCatID;
				$childListArr = explode(',',$childListRs->childList);
				if(!empty($childListArr))
				{
					$i = 0;
					foreach($childListArr as $childId)
					{
						if(!empty($childId))
						{
							$whereArr[$childId] = 'product_category.categoryId = '.$childId;
							if($i>0)
							{
								$childListRs1 = $this->segment_cat_m->category_child_list($childId);
								$childListArr1 = explode(',',$childListRs1->childList);	
								if(!empty($childListArr1))
								{
									foreach($childListArr1 as $childId1)
									{
										if(!empty($childId1))
										{
											$whereArr[$childId1] = 'product_category.categoryId = '.$childId1;
										
											//3										
											$childListRs11 = $this->segment_cat_m->category_child_list($childId1);
											$childListArr11 = explode(',',$childListRs11->childList);	
											if(!empty($childListArr11))
											{
												foreach($childListArr11 as $childId2)
												{
													if(!empty($childId2))
													{
														$whereArr[$childId2] = 'product_category.categoryId = '.$childId2;
													}
												}
											}
							
										//3
										}
									}
								}
							}
							$i++;
						}
					}
				}
				$where = '('.implode(" OR ",$whereArr).')';
			}			
			
			if(!empty($productName))			
			{
				$where.= ' AND (product.code LIKE "'.$productName.'%")';
			}
			if(!empty($categoryName))			
			{
				$where.= ' AND (category.categoryCode LIKE "'.$categoryName.'%")';
			}
			if(!empty($brandName))			
			{
				$where.= ' AND (brand.brandName LIKE "'.$brandName.'%")';
			}
			
			$prodLst = $this->product_m->product_listing_according_categry(0,'',$where);
			$total   = count($prodLst);
			
			$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/free_shipping_product/level_category_list/'.$parentCatID.'/'.$nextLevel,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 6,
		                'num_links'   => 4
          		  );
 
			$this->ajax_pagination->initialize($pagConfig);	
		
			$page  = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
			$this->data['links'] = $this->ajax_pagination->create_links();
			$this->data['page']  = $page;
		
			$this->data['productList'] = $this->product_m->product_listing_according_categry($page,$pagConfig['per_page'],$where);
			$result['productList'] = $this->load->view('free_shipping_product/product_list',$this->data,true);			
		}	
		echo json_encode($result);
	}
	
	public function free_shipping_product_details($productId=0)
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'free_shipping_product_details',
				'log_MID'    => '' 
		) );
		
		$productId = id_decrypt($productId);
		$this->data['title']      = 'Free Shipping Product Details';
		$result 			      = $this->product_lib->admin_product_review($productId);
		$this->data['result']     = $result;
		$this->data['product_id'] = $productId;		
		$this->superAdminCustomView('free_shipping_product/free_shipping_product_details',$this->data);
	}
}