<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();		
	}

	public function auto_search()
	{
		$search  = $_GET["term"];
		$result  = $this->CI->segment_cat_m->auto_search($search);
		$jsonArr = array();
		if(!empty($result))
		{
			foreach($result as $row)
			{
				$jsonArr[] = array(
							 	'value'     => $row->categoryCode,
								'label'     => $row->categoryCode,
                    			'prntCatId' => id_encrypt($row->parentCategoryId),
								'catId'     => id_encrypt($row->categoryId),
							 );
			}
		}
		return json_encode($jsonArr);
	}
	
	public function view_list($parentCatId)
	{
		if($parentCatId==56)  // Remove games accsories from list
		{
			$parentCatId = 5000000;
		}
		
		$return      = array();
		$cateBread   = array();
		$catDet      = $this->CI->segment_cat_m->category_parent_list($parentCatId);

		if(!empty($catDet))
		{
			$i = 0;
			foreach($catDet as $catRow)
			{
				$cateBread[$i] = array(
									'catId'    => $catRow->categoryId,
									'parentId' => $catRow->parentCategoryId,
									'catName'  => $catRow->categoryCode
								 );
				$i++;
			}
		}		

		$return['total']       = $this->CI->segment_cat_m->total_category($parentCatId);
		$return['parentCatId'] = $parentCatId;
		$return['cateBread']   = $cateBread;
		return $return;
	}	
	
	public function categoryAjaxFun($total)
	{
		$return      = array();
		$parentCatId = $this->CI->input->post('parentCatId');
		$per_page    = $this->CI->input->post('sel_no_entry');
		$where  	 = '';
		$search      = $this->CI->input->post('search');
		
		if($parentCatId==56)  // Remove games accsories from list
		{
			$parentCatId = 5000000;
		}
		
		if(empty($per_page))
		{
			$per_page = 10;
		}
		
		if(!empty($search))
		{
			$where = "categoryCode LIKE '".$search."%' ";			
			$total = $this->CI->segment_cat_m->total_segment($where);
		}
				
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/category_management/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['segment_list'] = $this->CI->segment_cat_m->category_list($page,$pagConfig['per_page'],$where,$parentCatId);
		$return["links"]        = $this->CI->ajax_pagination->create_links();
		$return['page']         = $page;
		return $return;
	}
	public function marketingcategoryAjaxFun($total)
	{
		$return      = array();
		$parentCatId = $this->CI->input->post('parentCatId');
		$per_page    = $this->CI->input->post('sel_no_entry');
		$where  	 = 'isMarketing = 1';
		$search      = $this->CI->input->post('search');
		
		if($parentCatId==56)  // Remove games accsories from list
		{
			$parentCatId = 5000000;
		}
		
		if(empty($per_page))
		{
			$per_page = 10;
		}
		
		if(!empty($search))
		{
			$where .= "and categoryCode LIKE '".$search."%' ";			
			
		}
		$total = $this->CI->segment_cat_m->total_segment($where);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/category_management/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['segment_list'] = $this->CI->segment_cat_m->marketing_category_list($page,$pagConfig['per_page'],$where,$parentCatId);
		$return["links"]        = $this->CI->ajax_pagination->create_links();
		$return['page']         = $page;
		return $return;
	}
	
	public function addEditCategory($parentCatId,$catId)
	{
		$return 				= array();
		$return['categoryName'] = '';
		$return['pageSubmit']   = 1;
		/*$return['cateBread']    = array();
		$catDet     			= $this->CI->segment_cat_m->category_parent_list($parentCatId);
		if(!empty($catDet))
		{
			$i = 0;
			foreach($catDet as $catRow)
			{
				$return['cateBread'][$i] = array(
												'catId'    => $catRow->categoryId,
												'parentId' => $catRow->parentCategoryId,
												'catName'  => $catRow->categoryCode
											 );
				$i++;
			}
		}*/
		
		if($_POST)
		{
			$return['pageSubmit']   = 0;	
			$return['categoryName'] = $this->CI->input->post('category_name');
			$catID         			= $this->CI->input->post('catID');
			$rules 		   			= category_rules();
						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->CI->form_validation->run())
			{
				$addArr = array(
								'categoryCode'        => $return['categoryName'],
								'categoryDescription' => $return['categoryName'],
								'parentCategoryId'	  => $parentCatId,								
							  );
							  
				if($catID)
				{
					$this->CI->segment_cat_m->update_category($catID,$addArr);
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_segment'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_segment'));
				}
				else
				{
					$inserID = $this->CI->segment_cat_m->add_category($addArr);
					$this->CI->custom_log->write_log('custom_log','inserted segment id is '.$inserID);
					
					if($inserID)
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_segment'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_segment'));
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_segment'));
						$this->CI->custom_log->write_log('custom_log','inserted segment id is '.$this->CI->lang->line('error_add_segment'));
					}					
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/category_management/view_list/'.id_encrypt($parentCatId));
			}
		}
		
		if($return['pageSubmit'])
		{
			$details = $this->CI->segment_cat_m->category_details($catId);
			if(!empty($details))
			{
				$return['categoryName'] = $details->categoryCode;
			}
		}
		return $return;
	}
	
	public function addEditmarketingCategory($parentCatId,$catId)
	{
		$return 				= array();
		$return['categoryName'] = '';
		$return['pageSubmit']   = 1;	
		
		if($_POST)
		{
			$return['pageSubmit']   = 0;	
			$return['categoryName'] = $this->CI->input->post('category_name');
			$catID         			= $this->CI->input->post('catID');
			$rules 		   			= category_rules();
						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->CI->form_validation->run())
			{
				$addArr = array(
								'categoryCode'        => $return['categoryName'],
								'categoryDescription' => $return['categoryName'],
								'parentCategoryId'	  => $parentCatId,	
								'isMarketing'		  => 1	
							  );
							  
				if($catID)
				{
					$this->CI->segment_cat_m->update_category($catID,$addArr);
					$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_segment'));
					$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_segment'));
				}
				else
				{
					$inserID = $this->CI->segment_cat_m->add_category($addArr);
					$this->CI->custom_log->write_log('custom_log','inserted segment id is '.$inserID);
					
					if($inserID)
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_segment'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_segment'));
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_segment'));
						$this->CI->custom_log->write_log('custom_log','inserted segment id is '.$this->CI->lang->line('error_add_segment'));
					}					
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/marketing_category_management/view_list/'.id_encrypt($parentCatId));
			}
		}
		
		if($return['pageSubmit'])
		{
			$details = $this->CI->segment_cat_m->category_details($catId);
			if(!empty($details))
			{
				$return['categoryName'] = $details->categoryCode;
			}
		}
		return $return;
	}
	
	public function brand_index()
	{
		$return = array();
		$return['total'] = $this->CI->brand_m->total_brand();
		return $return;
	}
	
	public function brand_ajaxFun($total)
	{
		$return   = array();
		$per_page = $this->CI->input->post('sel_no_entry');
		$sorting  = $this->CI->input->post('sorting');
		$where    = '';
		$search   = $this->CI->input->post('search');
		if(empty($per_page))
		{
			$per_page = 10;
		}
		
		if(!empty($search))
		{
			if($sorting=='brand_name')
			{
				$where = "brandName LIKE '".$search."%' ";
			}
			else
			{
				$where = "brandName LIKE '".$search."%' ";		
			}	
			$total = $this->CI->brand_m->total_brand($where);			
		}
						
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/brand_management/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['brand_list'] = $this->CI->brand_m->brand_list($page,$pagConfig['per_page'],$where);
		$return["links"]      = $this->CI->ajax_pagination->create_links();
		$return['page']       = $page;
		return $return;
	}
	
	public function brand_addEdit($brandId)
	{
		$result  = array();		
		$result['brand_name'] = '';
		$result['pageSubmit'] = 1;	
		$result['brand_image'] = '';
		$result['brandDescription'] = '';
		
		if($_POST)							
		{
			$result['pageSubmit']  = 0;	
			$result['brand_name']  = $this->CI->input->post('brand_name');
			$result['brand_image'] = $this->CI->input->post('image_name');
			$result['brandDescription'] = $this->CI->input->post('brandDescription');
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = brand_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				
				if($brandId)
				{
					if($this->CI->brand_m->brand_update($brandId,$result))
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_brand'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_brand'));					
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_update_brand'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_update_brand'));
					}
				}
				else
				{
					$brandId = $this->CI->brand_m->add_brand($result);
					$this->CI->custom_log->write_log('custom_log','Generate new brand id is '.$brandId);
					if($brandId)
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_brand'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_brand'));					
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_brand'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_brand'));
					}					
				}	
				redirect(base_url().$this->CI->session->userdata('userType').'/brand_management');							
			}
		}
		
		if($result['pageSubmit'])
		{
			$details =  $this->CI->brand_m->brand_details($brandId);
			if(!empty($details))
			{
				$result['brand_name'] = $details->brandName;
				$result['brand_image'] = $details->imageName;
				$result['brandDescription'] = $details->notes;
			}
		}		
		return $result;				
	}
	
	public function category_level10()
	{	
		$return		  = array();
		$categoryArr  = array();
		$catIDs       = array();
		$categoryList = $this->CI->segment_cat_m->category_level10();		
		if(!empty($categoryList))
		{
			foreach($categoryList as $row)
			{
				$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
				$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
				$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
				$catIDs[$row->level1ID][$row->level1ID]       = $row->level1ID;
				if(!empty($row->level2ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level2ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						$catIDs[$row->level1ID][$row->level2ID] = $row->level2ID;
					}
				}
				if(!empty($row->level3ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level3ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$catIDs[$row->level1ID][$row->level3ID] = $row->level3ID;
					}
				}
				if(!empty($row->level4ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level4ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$catIDs[$row->level1ID][$row->level4ID] = $row->level4ID;
					}
				}
				if(!empty($row->level5ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level5ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelID']       = $row->level5ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelName']     = $row->level5Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelParentID'] = $row->levelParent5ID;
						
					
						$catIDs[$row->level1ID][$row->level5ID] = $row->level5ID;
					}
				}
				if(!empty($row->level6ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level6ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelID']       = $row->level5ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelName']     = $row->level5Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelParentID'] = $row->levelParent5ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelID']       = $row->level6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelName']     = $row->level6Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelParentID'] = $row->levelParent6ID;
						$catIDs[$row->level1ID][$row->level6ID] = $row->level6ID;
					}
				}
				if(!empty($row->level7ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level7ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelID']       = $row->level5ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelName']     = $row->level5Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelParentID'] = $row->levelParent5ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelID']       = $row->level6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelName']     = $row->level6Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelParentID'] = $row->levelParent6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelID']       = $row->level7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelName']     = $row->level7Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelParentID'] = $row->levelParent7ID;
						$catIDs[$row->level1ID][$row->level7ID] = $row->level7ID;
					}
				}
				if(!empty($row->level8ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level8ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelID']       = $row->level5ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelName']     = $row->level5Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelParentID'] = $row->levelParent5ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelID']       = $row->level6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelName']     = $row->level6Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelParentID'] = $row->levelParent6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelID']       = $row->level7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelName']     = $row->level7Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelParentID'] = $row->levelParent7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelID']       = $row->level8ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelName']     = $row->level8Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelParentID'] = $row->levelParent8ID;
						$catIDs[$row->level1ID][$row->level8ID] = $row->level8ID;
					}
				}
				if(!empty($row->level9ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level9ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelID']       = $row->level5ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelName']     = $row->level5Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelParentID'] = $row->levelParent5ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelID']       = $row->level6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelName']     = $row->level6Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelParentID'] = $row->levelParent6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelID']       = $row->level7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelName']     = $row->level7Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelParentID'] = $row->levelParent7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelID']       = $row->level8ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelName']     = $row->level8Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelParentID'] = $row->levelParent8ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['levelID']       = $row->level9ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['levelName']     = $row->level9Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['levelParentID'] = $row->levelParent9ID;
						$catIDs[$row->level1ID][$row->level9ID] = $row->level9ID;
					}
				}
				if(!empty($row->level10ID))
				{
					$producList = $this->CI->product_m->product_acording_level($row->level10ID);	
					if(!empty($producList))
					{
						$categoryArr[$row->level1ID]['levelID']       = $row->level1ID;
						$categoryArr[$row->level1ID]['levelName']     = $row->level1Name;
						$categoryArr[$row->level1ID]['levelParentID'] = $row->levelParent1ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelID']       = $row->level2ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelName']     = $row->level2Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['levelParentID'] = $row->levelParent2ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelID']       = $row->level3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelName']     = $row->level3Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['levelParentID'] = $row->levelParent3ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelID']       = $row->level4ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelName']     = $row->level4Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['levelParentID'] = $row->levelParent4ID;
					
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelID']       = $row->level5ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelName']     = $row->level5Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['levelParentID'] = $row->levelParent5ID;
						
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelID']       = $row->level6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelName']     = $row->level6Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['levelParentID'] = $row->levelParent6ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelID']       = $row->level7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelName']     = $row->level7Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['levelParentID'] = $row->levelParent7ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelID']       = $row->level8ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelName']     = $row->level8Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['levelParentID'] = $row->levelParent8ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['levelID']       = $row->level9ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['levelName']     = $row->level9Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['levelParentID'] = $row->levelParent9ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['nextLevel'][$row->level10ID]['levelID']       = $row->level10ID;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['nextLevel'][$row->level10ID]['levelName']     = $row->level10Name;
						$categoryArr[$row->level1ID]['nextLevel'][$row->level2ID]['nextLevel'][$row->level3ID]['nextLevel'][$row->level4ID]['nextLevel'][$row->level5ID]['nextLevel'][$row->level6ID]['nextLevel'][$row->level7ID]['nextLevel'][$row->level8ID]['nextLevel'][$row->level9ID]['nextLevel'][$row->level10ID]['levelParentID'] = $row->levelParent10ID;
						$catIDs[$row->level1ID][$row->level10ID] = $row->level10ID;
					}
				}
			}
		}
		//echo $this->CI->db->last_query(); exit;
		//echo "<pre>"; print_r($categoryArr); exit;
		$return['categoryLevelList'] = $categoryArr;
		$return['categoryIdList']    = $catIDs;
		return $return;
	}
	
	public function category_level_list()
	{	
		$return		  = array();
		$categoryArr  = array();
		$catIDs       = array();
		$categoryList = $this->CI->segment_cat_m->segment_list();		
		if(!empty($categoryList))
		{
			foreach($categoryList as $row)
			{
				$categoryArr[$row->categoryId]['levelID']       = $row->categoryId;
				$categoryArr[$row->categoryId]['levelName']     = $row->categoryCode;
				$categoryArr[$row->categoryId]['levelParentID'] = $row->parentCategoryId;
				$categoryArr[$row->categoryId]['nextLevel']		= array();
				$allChildList = $this->CI->segment_cat_m->product_category_all_child_list($row->categoryId);
				//echo "<pre>"; print_r($allChildList); exit;
				//$categoryArr[$row->categoryId]['allChildList'] = $allChildList->allChild;
				if(!empty($allChildList))
				{
					$producList = $this->CI->product_m->product_acording_level_in($allChildList->allChild);	
					//$categoryArr[$row->categoryId]['producList'] = $producList;
					if(!empty($producList))
					{
						foreach($producList as $productRow)
						{
							if((!empty($productRow->parentCategoryId))&&($productRow->parentCategoryId))
							{							
$categoryArr[$productRow->parentCategoryId]['nextLevel'][$productRow->categoryId]['levelID']   = $productRow->categoryId;
$categoryArr[$productRow->parentCategoryId]['nextLevel'][$productRow->categoryId]['levelName'] = $productRow->categoryCode;
$categoryArr[$productRow->parentCategoryId]['nextLevel'][$productRow->categoryId]['levelParentID'] = $productRow->parentCategoryId;	
							}
						}
					}
				}
				
				/*if(!empty($categoryArr))
				{
					foreach($categoryArr as $catKey=>$catValArr)
					{
						if(array_key_exists($catKey,$categoryArr[$productRow->parentCategoryId]['nextLevel']))
						{
							if(!empty($categoryArr[$catKey]['nextLevel']))
							{
								$categoryArr[$productRow->parentCategoryId]['nextLevel'][$catKey]['nextLevel'] = $categoryArr[$catKey]['nextLevel'];
							}
						}
					}			
				}*/
			}
			
			
		}
		echo "<pre>"; print_r($categoryArr); exit;
		return $categoryArr;
	}
	
	public function category_level_sort($categoryArr,$categoryId)
	{
		foreach($categoryArr as $catKey=>$catValArr)
		{
			if(array_key_exists($catKey,$categoryArr[$categoryId]['nextLevel']))
			{
				if(!empty($categoryArr[$catKey]['nextLevel']))
				{
					$categoryArr[$categoryId]['nextLevel'][$catKey]['nextLevel'] = $categoryArr[$catKey]['nextLevel'];
					unset($categoryArr[$catKey]);
				}
			}
		}
		return $categoryArr;
	}
	
	public function category_commission_list()
	{
		$return = array();
		$return['total'] = $this->CI->segment_cat_m->total_segment();
		return $return;
	}
	
	public function category_commission_ajax_list($total)
	{
		$return       = array();
		$categoryName = $this->CI->input->post('categoryName');
		$per_page     = $this->CI->input->post('sel_no_entry');
		$where  	  = '';
		//echo "<pre>"; print_r($_POST); exit;
		if(!empty($categoryName))
		{
			$where = "categoryCode LIKE '".$categoryName."%' ";			
			$total = $this->CI->segment_cat_m->total_segment($where);
		}
				
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/category_commission_management/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->segment_cat_m->segment_list($page,$pagConfig['per_page'],$where);
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function edit_category_commission($catId)
	{
		$return 				      = array();
		$return['categoryName']       = '';
		$return['categoryCommission'] = 0;
		$return['pageSubmit']         = 1;	
		
		$details = $this->CI->segment_cat_m->category_details($catId);
		if(!empty($details))
		{
			$return['categoryName'] = $details->categoryCode;
		}
		//echo $catId; exit;
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','after form submit details is '.print_r($_POST,true));
			
			$return['pageSubmit']         = 0;	
			$return['categoryCommission'] = $this->CI->input->post('categoryCommission');
			$rules = edit_category_commission_rules();
						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($catId)
				{
					if($this->CI->segment_cat_m->update_category_commission($catId,$return))
					{
						/*******Add  commission History Start****************/
						$commisionHstryId = $this->CI->segment_cat_m->add_category_commission_history($catId,$return);
						$this->CI->custom_log->write_log('custom_log','commsion history id is '.$commisionHstryId);
						/*******Add commission  History Start****************/
						$this->CI->session->set_flashdata('success','commsion Updated successfully');
						$this->CI->custom_log->write_log('custom_log','commsion Updated successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Commission not update');
						$this->CI->custom_log->write_log('custom_log','Commission not update');
					}
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/category_commission_management');
			}
		}
		
		if($return['pageSubmit'])
		{
			$details = $this->CI->segment_cat_m->category_details($catId);
			if(!empty($details))
			{
				$return['categoryCommission'] = $details->commission;
			}
		}
		return $return;		
	}
	
	public function add_edit_price_management($priceMngtId)
	{
		$return['fromPrice'] = '';
		$return['toPrice']	 = '';
		$return['adminPrice'] = 0;
		$return['pageSubmit'] = 1;
		$return['spacePointeCommission'] = 0;
		$return['genuineShippingFee']    = 0;
		$return['cashFee']			     = 1;	
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','form submit is '.print_r($_POST,true));
			$return['pageSubmit']			 = 0;	
			$return['fromPrice']  			 = $this->CI->input->post('fromPrice');
			$return['toPrice']	  			 = $this->CI->input->post('toPrice');
			$return['spacePointeCommission'] = $this->CI->input->post('spacePointeCommission');
			$return['cashFee']               = $this->CI->input->post('cashFee');
			if(!empty($_POST['above']))
			{
				$return['toPrice'] = 100000000000000;
			}
			
			$rules = add_edit_price_management_rules();
						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				//echo "<pre>"; print_r($return); exit;
				if($return['cashFee']==1)
				{
					$return['adminPrice'] = 1;
				}
				elseif($return['cashFee']==2)
				{
					$return['genuineShippingFee'] = 1;
				}
				if($return['spacePointeCommission'])
				{
					$return['spacePointeCommission'] = 1;
				}
				
				$checkExistFrom = $this->CI->segment_cat_m->check_from_price_exists($priceMngtId,$return['fromPrice']);
				$this->CI->custom_log->write_log('custom_log','check from price is '.print_r($checkExistFrom,true));
				$checkExistTo = $this->CI->segment_cat_m->check_to_price_exists($priceMngtId,$return['toPrice']);
				$this->CI->custom_log->write_log('custom_log','check to price is '.print_r($checkExistTo,true));
				
				$checkExistLieIn = $this->CI->segment_cat_m->check_from_to_price_exists($priceMngtId,$return);
				$this->CI->custom_log->write_log('custom_log','check from to price is '.print_r($checkExistLieIn,true));
				//echo "<pre>"; print_r($checkExistLieIn); exit;
				if((!empty($checkExistFrom))||(!empty($checkExistTo))||(!empty($checkExistLieIn)))
				{
					$this->CI->session->set_flashdata('error','Range already exists');
					$this->CI->custom_log->write_log('custom_log','Range already exists');
					redirect(base_url().$this->CI->session->userdata('userType').'/price_management');
				}
				
				if($priceMngtId)
				{		
					$this->CI->custom_log->write_log('custom_log','updated price management id is '.$priceMngtId);			
					if($this->CI->segment_cat_m->update_price_management($priceMngtId,$return))
					{
						$this->CI->session->set_flashdata('success','Range Updated Successfully');
						$this->CI->custom_log->write_log('custom_log','Range Updated Successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Range not updated');
						$this->CI->custom_log->write_log('custom_log','Range not updated');
					}						
				}
				else
				{
					$priceMngtId = $this->CI->segment_cat_m->add_price_management($return);
					$this->CI->custom_log->write_log('custom_log','price managment id is '.$priceMngtId);
					if($priceMngtId)
					{
						$this->CI->session->set_flashdata('success','Range Added Successfully');
						$this->CI->custom_log->write_log('custom_log','Range Added Successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Range not add');
						$this->CI->custom_log->write_log('custom_log','Range not add');
					}
				}
				
				/***********price management history**************/
				$priceMngtHstryId = $this->CI->segment_cat_m->add_price_management_history($priceMngtId,$return);
				$this->CI->custom_log->write_log('custom_log','Range history management id is '.$priceMngtHstryId);
				/***********price management history**************/
				redirect(base_url().$this->CI->session->userdata('userType').'/price_management');
			}
		}
		
		if($return['pageSubmit'])
		{
			if($priceMngtId)
			{
				$priceMngtDet = $this->CI->segment_cat_m->get_price_details($priceMngtId);
				if(!empty($priceMngtDet))
				{
					$return['fromPrice']  = $priceMngtDet->fromPrice;
					$return['toPrice']	  = $priceMngtDet->toPrice;
					$return['adminPrice'] = $priceMngtDet->adminFee;
					$return['spacePointeCommission'] = $priceMngtDet->spacePointeCommission;
					$return['genuineShippingFee']    = $priceMngtDet->genuineShippingFee;
					if($return['adminPrice'])
					{
						$return['cashFee'] = 1;
					}
					elseif($return['genuineShippingFee'])
					{
						$return['cashFee'] = 2;
					}					
				}
			}
		}
		return $return;
	}
	
	public function price_management_ajax_list()
	{
		$return    = array();
		$where     = '';
		$FromPrice = $this->CI->input->post('FromPrice');
		$toPrice   = $this->CI->input->post('toPrice');
		$per_page  = $this->CI->input->post('sel_no_entry');
		
		if(!empty($FromPrice))
		{
			$where = "fromPrice LIKE '".$FromPrice."%' ";			
			
		}
		if(!empty($toPrice))
		{
			if(!empty($where))
			{
				$where.= " AND toPrice LIKE '".$toPrice."%' ";
			}
			else
			{
				$where = "toPrice LIKE '".$toPrice."%' ";
			}
		}
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		$total = $this->CI->segment_cat_m->total_price_management($where);				
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/price_management/ajaxFun',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->segment_cat_m->price_management_list($page,$pagConfig['per_page'],$where);
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	
	}
	
	public function add_free_shipping_category()
	{
		$return = array();
		$return['catList'] = $this->CI->segment_cat_m->category_list();
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','After form submit is '.print_r($_POST,true));
			
			$rules = add_free_shipping_category_rules();						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$lastLevelCatId = 0;
				foreach($_POST as $key=>$value)
				{
					if(!empty($value))
					{
						$lastLevelCatId = $value;
						$freeShippDet   = $this->CI->segment_cat_m->free_shippng_cat_details($value);
						if(!empty($freeShippDet))
						{
							$this->CI->custom_log->write_log('custom_log','free shipping category details '.print_r($freeShippDet,true));
							$this->CI->session->set_flashdata('error','This '.$freeShippDet->categoryCode.' category already added in Free shipping');
							$this->CI->custom_log->write_log('custom_log','This '.$freeShippDet->categoryCode.' category already added in Free shipping');
							redirect(base_url().$this->CI->session->userdata('userType').'/free_shipping_category/add_free_shipping_cat');
						}
					}
				}
				$this->CI->custom_log->write_log('custom_log','Last Level Category Id is '.$lastLevelCatId);
				
				if($lastLevelCatId)
				{
					$freeShipCatId = $this->CI->segment_cat_m->add_free_shipping_category($lastLevelCatId);
					$this->CI->custom_log->write_log('custom_log','free shipping category id is '.$freeShipCatId);
					
					if($freeShipCatId)
					{
						$this->CI->session->set_flashdata('success','Free shipping category added successfully');
						$this->CI->custom_log->write_log('custom_log','Free shipping category added successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Free shipping category not add');
						$this->CI->custom_log->write_log('custom_log','Free shipping category not add');
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','category level not selected');
					$this->CI->custom_log->write_log('custom_log','category level not selected');
				}				
				redirect(base_url().$this->CI->session->userdata('userType').'/free_shipping_category');
			}
		}
		return $return;
	}
	
	public function free_shipping_category_ajax_fun()
	{
		$return       = array();
		$per_page     = $this->CI->input->post('sel_no_entry');
		$where  	  = '';
		$categoryName = $this->CI->input->post('categoryName');
		
		if(!empty($categoryName))
		{
			$where = 'category.categoryCode Like "'.$categoryName.'%"';
		}
		
		$total = $this->CI->segment_cat_m->total_free_shipping_category($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/free_shipping_category/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->segment_cat_m->free_shipping_category_list($page,$pagConfig['per_page'],$where);
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function free_shipping_category_details($freeShipCatId)
	{
		$return  = array();
		$return['catList'] = '';
		$details = $this->CI->segment_cat_m->free_shipping_category_detail($freeShipCatId);
		if(!empty($details))
		{
			$categoryId = $details->categoryId;
			$parentList = $this->CI->segment_cat_m->category_parent_list($categoryId);
			if(!empty($parentList))
			{
				$i = 1;
				foreach($parentList as $row)
				{
					$return['catList'][$i]['categoryId']       = $row->categoryId;
					$return['catList'][$i]['categoryCode']     = $row->categoryCode;
					$return['catList'][$i]['parentCategoryId'] = $row->parentCategoryId;
					$i++;
				}
			}
		}
		return $return;
	}
	
	public function block_category_status($categoryId,$status)
	{
		$this->CI->custom_log->write_log('custom_log','category id is '.$categoryId.' and status is '.$status);
		$childListRs1 = $this->CI->segment_cat_m->category_child_list($categoryId);	
		$this->CI->custom_log->write_log('custom_log','child category list is '.print_r($childListRs1,true));
		$childListRs = $childListRs1->childList;
		
		if(!empty($childListRs))
		{
			$this->CI->session->set_flashdata('error','There are Sub-Category associated, so can not block this category');
			$this->CI->custom_log->write_log('custom_log','There are Sub-Category associated, so can not block this category');						
		}
		else
		{
			$where       = 'product_category.categoryId = '.$categoryId;
			$productList = $this->CI->product_m->product_listing_according_categry(0,'',$where);
			$this->CI->custom_log->write_log('custom_log','Product list is '.print_r($productList,true));	
			if(!empty($productList))
			{
				$this->CI->session->set_flashdata('error','There are products associated, so can not block this category');
				$this->CI->custom_log->write_log('custom_log','There are products associated, so can not block this category');	
			}
			else
			{
				if($this->CI->segment_cat_m->block_category_status($categoryId))
				{
					$this->CI->session->set_flashdata('success','Category Status changed Successfully');
					$this->CI->custom_log->write_log('custom_log','Category Status changed Successfully');	
				}
				else
				{
					$this->CI->session->set_flashdata('error','Category status not change');
					$this->CI->custom_log->write_log('custom_log','Category status not change');	
				}	
			}
		}
		
		$parentList = $this->CI->segment_cat_m->category_parent_list($categoryId);
		$this->CI->custom_log->write_log('custom_log','Parent category list is '.print_r($parentList,true));
		if(!empty($parentList))
		{
			$paretnId = 0;
			foreach($parentList as $catRow)
			{
				$paretnId = $catRow->parentCategoryId;	
			}
			redirect(base_url().$this->CI->session->userdata('userType').'/category_management/view_list/'.id_encrypt($paretnId));
		}
		else
		{
			redirect(base_url().$this->CI->session->userdata('userType').'/category_management/view_list');
		}
	}
	
	public function unblock_category_status($categoryId,$status)
	{
		$this->CI->custom_log->write_log('custom_log','category id is '.$categoryId.' and status is '.$status);
		if($this->CI->segment_cat_m->unblock_category_status($categoryId))
		{
			$this->CI->session->set_flashdata('success','Category Status changed Successfully');
			$this->CI->custom_log->write_log('custom_log','Category Status changed Successfully');	
		}
		else
		{
			$this->CI->session->set_flashdata('error','Category status not change');
			$this->CI->custom_log->write_log('custom_log','Category status not change');	
		}	
		
		$parentList = $this->CI->segment_cat_m->category_parent_list($categoryId);
		$this->CI->custom_log->write_log('custom_log','Parent category list is '.print_r($parentList,true));
		if(!empty($parentList))
		{
			$paretnId = 0;
			foreach($parentList as $catRow)
			{
				$paretnId = $catRow->parentCategoryId;	
			}
			redirect(base_url().$this->CI->session->userdata('userType').'/category_management/view_list/'.id_encrypt($paretnId));
		}
		else
		{
			redirect(base_url().$this->CI->session->userdata('userType').'/category_management/view_list');
		}
	}
	
	public function spacepointe_commission2_ajax_list()
	{
		$return       = array();
		$categoryName = $this->CI->input->post('categoryName');
		$per_page     = $this->CI->input->post('sel_no_entry');
		$where  	  = '';
		
		if(!empty($categoryName))
		{
			$where = "categoryCode LIKE '".$categoryName."%' ";			
		}
		$total = $this->CI->segment_cat_m->total_segment($where);
				
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/category_commission_management2/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->segment_cat_m->segment_list($page,$pagConfig['per_page'],$where);
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function edit_spacepointe_commission2($catId)
	{
		$return 				      = array();
		$return['categoryName']       = '';
		$return['categoryCommission'] = 0;
		
		$details = $this->CI->segment_cat_m->category_details($catId);
		$this->CI->custom_log->write_log('custom_log','category commission details is '.print_r($details,true));	
		
		if(!empty($details))
		{
			$return['categoryName']       = $details->categoryCode;
			$return['categoryCommission'] = $details->spacepointeCommission2;
		}
		
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','after form submit details is '.print_r($_POST,true));
			
			$return['categoryCommission'] = $this->CI->input->post('categoryCommission');
			$rules = edit_category_commission_rules();
						
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($catId)
				{
					if($this->CI->segment_cat_m->update_spacepointe_commission2($catId,$return))
					{
						/*******Add  commission History Start****************/
						$commisionHstryId = $this->CI->segment_cat_m->add_spacepointe_commission2_history($catId,$return);
						$this->CI->custom_log->write_log('custom_log','commsion history id is '.$commisionHstryId);
						/*******Add commission  History Start****************/
						$this->CI->session->set_flashdata('success','commsion Updated successfully');
						$this->CI->custom_log->write_log('custom_log','commsion Updated successfully');
					}
					else
					{
						$this->CI->session->set_flashdata('error','Commission not update');
						$this->CI->custom_log->write_log('custom_log','Commission not update');
					}
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/category_commission_management2');
			}
		}
		
		return $return;		
	}
} 