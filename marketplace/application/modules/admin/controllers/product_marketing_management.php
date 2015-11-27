<?php
if (!defined('BASEPATH')) exit('No Direct Access Allowed');

class Product_marketing_management extends MY_Controller
{
    public function __construct()
    {
    	parent::__construct();
        
        // logger
        $this->session->set_userdata(array(
            'log_FILE' => __FILE__
        ));
        $this->data['title'] = 'Marketing Managment';
        $this->load->model('Sementic_product_m');
        $this->load->model('product_marketing_m');
        $this->load->helper('validation_rule');
    }
    
    public function index()
    {
        $this->adminCustomView('marketing/product_list', $this->data);
    }
	
    public function prodAjaxfun()
    {
        $perPage         = $this->input->post('sel_no_entry');
        $productName     = trim($this->input->post('productName'));
        $productCategory = trim($this->input->post('productCategory'));
        $where           = '';
        
		if(!empty($productName)) 
		{
			$productName  = trim(preg_replace('/^([\'"])(.*)\\1$/','\\2',$productName)); 
			$where = "trim(product.code) LIKE '".mysql_real_escape_string($productName)."%'";
        }
		
        if (!empty($productCategory)) {
            if ($where) {
                $where .= " AND trim(category.categoryCode) LIKE '" . $productCategory . "%'";
            } else {
                $where = "trim(category.categoryCode) LIKE '" . $productCategory . "%'";
            }
        }
        if (!empty($where)) {
            $where = '(' . $where . ')';
            
        }
        $total = $this->product_marketing_m->total_products($where);
        
        $pagConfig = array(
            'base_url' => base_url().$this->session->userdata('userType').'/product_marketing_management/prodAjaxfun',
            'total_rows' => $total,
            'per_page' => $perPage,
            'uri_segment' => 4,
            'num_links' => 4
        );
        
        $this->ajax_pagination->initialize($pagConfig);
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
        $this->data['list']  = $this->product_marketing_m->product_list($page,$pagConfig['per_page'],$where);
      	//echo "<pre>";  print_r($this->data["links"]); exit;
		//echo $this->db->last_query(); exit;
        $this->load->view('marketing/ajax_product_list', $this->data);
        
    }
	
	public function addProductRetailer($productId)
	{
		$this->data['productId'] = id_decrypt($productId);
		$this->adminCustomView('marketing/product_retailer_list',$this->data);
	}
	
	public function ajaxProductRetailer($productId)
	{
		$perPage           = $this->input->post('sel_no_entry');
        $businessName      = $this->input->post('businessName');
		$state             = $this->input->post('state');
		$area              = $this->input->post('area');
		$ownerName         = $this->input->post('ownerName');
        $retailerInventory = $this->input->post('retailerInventory');
		$productId         = id_decrypt($productId);
		$where = 'organization_product.productId = '.$productId;
        
		if(!empty($businessName))
		{
			$where .=' and organization.organizationName like "%'.$businessName.'%"';
		}
		
		if(!empty($state))
		{
			$where .=' and state.stateName like "%'.$state.'%"';
		}
		
		if(!empty($area))
		{
			$where .=' and area.area like "%'.$area.'%"';
		}
		
		if(!empty($ownerName))
		{
			$where .=' and concat(employee.firstName," ",employee.lastName) like "%'. $ownerName .'%"';
		}
		
		$total = $this->product_marketing_m->total_product_retailer($where);
        
        $pagConfig = array(
            			'base_url'    => base_url().$this->session->userdata('userType').'/product_marketing_management/ajaxProductRetailer/'.id_encrypt($productId),
 			           	'total_rows'  => $total,
            			'per_page'    => $perPage,
            			'uri_segment' => 5,
            			'num_links'   => 4
        			);
        
        $this->ajax_pagination->initialize($pagConfig);
        
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
        $result = $this->product_marketing_m->product_retailer_list($page, $pagConfig['per_page'], $where);
		$list   = '';
        if(!empty($result))
		{
			$i = 0;
			foreach($result as $row)
			{
				$productWeight = $row->weight+$row->shippingWeight;
				$priceArr      = $this->product_lib->show_product_price_array($row->organizationProductId);		
				$displayPrice  = $priceArr['displayPrice'];

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
	    $this->data['list'] = $list;
		$this->load->view('marketing/ajax_product_retailer',$this->data);
       
	}
	
    public function addProduct($organizationProductId = 0)
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'addProduct',
				'log_MID'    => '' 
		) );	
		
        $organizationProductId = id_decrypt($organizationProductId);
		$this->custom_log->write_log('custom_log','organization product id is '.$organizationProductId);
		
		$details = $this->product_marketing_m->product_retailer_inventorydetail($organizationProductId);
		$this->custom_log->write_log('custom_log','Details is '.print_r($details,true));
		
		$colorsize = $this->product_m->get_product_color_and_size($organizationProductId);
		$this->custom_log->write_log('custom_log','color size of product is '.print_r($colorsize,true));
		
		if(!empty($details))
		{
			$product_id     = $details->productId;
			$organizationId = $details->organizationId;
    	   
		   	if($_POST)
			{
				//echo "<pre>"; print_r($_POST); exit;
				$this->custom_log->write_log('custom_log','after form submit data is '.print_r($_POST,true));
				
				$rules = add_marketing_product_rules();
				if(isset($_POST['inventory']))
				{
					$rules[]=	array(
									'field' => 'inventory',
									'label' => 'Inventory',
									'rules' => 'trim|required'
								);
				}
			 
			 	if(!empty($colorsize))
			 	{
			 		$flag = TRUE;
				 	foreach($colorsize as $value)
					{
						$boxVal = $this->input->post('inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)));
						if(!empty($boxVal))
						{
							$flag = FALSE;
						}
					}
					if($flag)
					{
						foreach($colorsize as $value)
						{
							$rules[] = array(
											'field' => 'inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)),
											'label' => 'At least one',
											'rules' => 'trim|required'
										);
						}			
					}
					else
					{
						foreach($colorsize as $value)
						{
							$rules[] = array(
											'field' => 'inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)),
											'label' => 'Inventory',
											'rules' => 'trim'
										);
						}
					}
				} 
				
				$this->custom_log->write_log('custom_log','rules array is '.print_r($rules,true));
	
	            $this->form_validation->set_rules($rules);
            	if($this->form_validation->run()) 
				{
					$return['cost']          	   = $this->input->post('cost');
	                $return['sale']          	   = $this->input->post('sale');
					$return['spacepointeDiscount'] = $this->input->post('spacepointediscount');
	                $return['retailerDiscount']    = $this->input->post('retailerdiscount');
					$return['discountPrice']       = $this->input->post('discount');
	                $datefrom               	   = $this->input->post('datefrom');
				
	                $return['datefromvalue'] 	   = $datefrom;
    	            $return['datefrom']      	   = date('Y-m-d h:i:s',strtotime($datefrom));
        	        $dateto                  	   = $this->input->post('dateto');
            	    $return['datetovalue']   	   = $dateto;
                	$return['dateto']        	   = date('Y-m-d h:i:s',strtotime($dateto));
	                $return['productId']     	   = $product_id;
					$return['organizationProductId'] = $organizationProductId;
	               	$return['inventory']			 = '';
					
					if(isset($_POST['inventory']))
					{	
				   		$return['inventory'] = $this->input->post('inventory');
					}
                                
	                if (isset($_POST['level6']) && !empty($_POST['level6'])) 
					{
        	            $category_id = $this->input->post('level6');
            	    } 
					elseif (isset($_POST['level5']) && !empty($_POST['level5'])) 
					{
    	                $category_id = $this->input->post('level5');
        	        }
					elseif (isset($_POST['level4']) && !empty($_POST['level4'])) 
					{
	                    $category_id = $this->input->post('level4');
	                }
					elseif (isset($_POST['level3']) && !empty($_POST['level3'])) 
					{
	                    $category_id = $this->input->post('level3');
	                } 
					elseif (isset($_POST['level2']) && !empty($_POST['level2'])) 
					{
	                    $category_id = $this->input->post('level2');
	                }
					elseif (isset($_POST['level1']) && !empty($_POST['level1'])) 
					{
            	        $category_id = $this->input->post('level1');
                	}
               
					if(!empty($colorsize))
					{
						foreach($colorsize as $value)
						{
							$boxVal = $this->input->post('inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)));
							if(!empty($boxVal))
							{
								$return['inventory']+=$boxVal;
							}
						}
					}
               
               		$marketingProductId = $this->product_marketing_m->add_markeitng_product($return, $organizationId);
					$this->custom_log->write_log('custom_log','marketing product id is '.$marketingProductId);
					
	                if(!empty($marketingProductId)) 
					{
	                    $return['marketingProductId'] = $marketingProductId;
	                    $return['categoryId']         = $category_id;
					
						if(!empty($colorsize))
						{
							foreach($colorsize as $value)
							{
								$boxVal = $this->input->post('inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)));
								if(!empty($boxVal))
								{
									$marketingProductSizeId = $this->product_marketing_m->add_marketing_size_stock($marketingProductId,$boxVal,trim($value->size),$value->colorId);
									$this->custom_log->write_log('custom_log','marketing product color size id is '.$marketingProductSizeId);
								}
							}
						}
						
	                    $rs = $this->product_marketing_m->add_product_category($return,$organizationId);
						$this->session->set_flashdata('success',$this->lang->line('success_add_inventory'));
	                    $this->custom_log->write_log('custom_log','Inventory added successfully');
	              	}
				  	else 
				  	{
						$this->session->set_flashdata('error','Flash prdouct inventory not add');
						$this->custom_log->write_log('custom_log','Flash prdouct inventory not add');
                    }
					redirect(base_url().'admin/product_marketing_management');
            	}
        	}
        	
			$where                         = 'isMarketing ="1"';
	        $this->data['catlist']         = $this->segment_cat_m->marketing_segment_list('', '', $where);
	        $this->data['product_data']    = $this->Sementic_product_m->get_product_detail($product_id);
        	$this->data['inventorydetail'] = $details;
			$this->data['colorsize']       = $colorsize;
			$this->adminCustomView('marketing/add_product', $this->data);
		}
		else
		{
			$this->session->set_flashdata('error','NO inventory available for this product');
			$this->custom_log->write_log('custom_log','NO inventory available for this product');
			redirect(base_url().'admin/product_management');
		}
    }
    
	public function check_at_least_one()
	{
		$inventoryarr = $this->input->post('inventoryarr[][]');
		foreach($inventoryarr as $valArr)
		{
			foreach($valArr as $val)
			{
				if(!empty($val))
				{
					return TRUE;  
				}
			}
		}
		
		$this->form_validation->set_message('check_at_least_one', 'At least one field is required');
	    return FALSE;              
	}
	
    public function check_greater($str, $attr)
    {
        $sale = $this->input->post($attr);
        if ($str <= $sale) {
            //$this->form_validation->set_message('check_greater', 'The %s field must be greate than %s');
			$this->form_validation->set_message('check_greater', 'Effective sales price should be less than  to the Actual price');
            return FALSE;
        } else {
            return true;
        }
    }  
	public function check_lesser($str, $attr)
    {
        $sale = $this->input->post($attr);
        if ($str > $sale) {
            $this->form_validation->set_message('check_lesser', 'The %s field must be greater than %s');
            return FALSE;
        } else {
			   $this->form_validation->set_message('check_lesser', 'The %s field must be greater than %s');
            return TRUE;
        }
    }
    public function check_greater_date($str, $attr)
    {
        $attrdate   = $this->input->post($attr);
        $higherdate = strtotime($str);
        $lowerdate  = strtotime($attrdate);
        if ($lowerdate > $higherdate) {
            $this->form_validation->set_message('check_greater_date', 'The %s date must be greater than %s');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    
    public function inventory_details($marketingProductId)
    {
		$marketingProductId = id_decrypt($marketingProductId);
	    $organizationId     = $this->session->userdata('organizationId');
		//$organizationProductId = id_decrypt($organizationProductId);
		$product_detail=$this->data['result'] = $this->product_lib->marketing_inventory_details($marketingProductId,$organizationId);
		$resultProductDetail  = $this->product_lib->product_review($product_detail['productId']);
			if(!empty($resultProductDetail['sizes'])){
		$this->data['sizes']	=explode(',',$resultProductDetail['sizes']);	
		}else
		{
			$this->data['sizes']='';
		}
		$this->data['marketingProductId']  = $marketingProductId;
		$this->data['organizationId']  = $organizationId;
        $this->adminCustomView('marketing/inventory_details_view', $this->data);
    }
    
    public function unblock_block($marketingProductId, $status)
    {
        $marketingProductId = id_decrypt($marketingProductId);
        
        if (!empty($marketingProductId)) {
            if ($this->product_marketing_m->block_unblock($status, $marketingProductId)) {
                if (!$status) {
                    $this->session->set_flashdata('success', $this->lang->line('success_block_product'));
                } else {
                    $this->session->set_flashdata('success', $this->lang->line('success_unblock_product'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('error_not_update'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('error_invalie_id'));
        }
        redirect(base_url() . 'admin/product_marketing_management/inventory_details/' . id_encrypt($marketingProductId));
    }
	
	public function edit_product($marketingProductId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_product',
				'log_MID'    => '' 
		) );
		
		$inventorydetails   = array();
		$marketingProductId = id_decrypt($marketingProductId);
		$this->custom_log->write_log('custom_log','marketing product id is '.$marketingProductId);
		
		$product_detail	= $this->product_marketing_m->inventory_details_with_category($marketingProductId);
		$this->custom_log->write_log('custom_log','marketing product inventory details is '.print_r($product_detail,true));
		
		$this->data['result'] = $product_detail;
		$product_id 		  = $product_detail->productId;
		$organizationId 	  = $product_detail->organizationId;
		$category_id          = '';
		
		if(!empty($product_detail))
		{
			$category_id 				   = $product_detail->categoryId;
			$return['cost']          	   = floor($product_detail->costPrice);
            $return['sale']          	   = $product_detail->currentPrice; 
			$return['spacepointeDiscount'] = $product_detail->spacepointeDiscount;
            $return['retailerDiscount']    = $product_detail->retailerDiscount;
			$return['discountPrice']       = $product_detail->discountPrice;
            $datefrom                      = $product_detail->effectiveDtFrom;
			
			if(!empty($product_detail->colorId))
			{
				$color_array = explode(',',$product_detail->colorId);
			}
			else
			{
				$color_array = '';
			}
			
			if(!empty($product_detail->product_size))
			{
				$product_size = explode(',',$product_detail->product_size);
			}
			else
			{
				$product_size = '';
			}
			$stock = explode(',',$product_detail->stock);
			if(!empty($color_array))
			{
				foreach($color_array as $key=>$single_color)
				{
					if(!empty($single_color))
					{
						if(!empty($product_size[$key]))
						{
							$inventorydetails[$single_color.$product_size[$key]] = $stock[$key];
						}
						else
						{
							$inventorydetails[$single_color] = $stock[$key];
						}
					}
					else
					{
						$inventorydetails[$product_size[$key]] = $stock[$key];
					}
				}
			}
			elseif(!empty($product_size))
			{
				foreach($product_size as $key => $size_detail)
				{
					//print_r($size_detail);
					$inventorydetails[$size_detail]=$stock[$key];
				}
			}
			else
			{
				$inventorydetails = $product_detail->currentQty;
			}
				
			$this->data['inventory_details'] = $inventorydetails;
			
			$return['datefromvalue']         = $datefrom;
            //$return['datefrom']              = date('Y-m-d h:i:s', strtotime($datefrom));
			$return['datefrom']              = date('Y-m-d', strtotime($datefrom));
            $dateto                          = $product_detail->effectiveDtTo;
            $return['datetovalue']           = $dateto;
            //$return['dateto']                = date('Y-m-d h:i:s', strtotime($dateto));
			$return['dateto']                = date('Y-m-d', strtotime($dateto));
            $return['productId']             = $product_id;
			$organizationProductId  		 = $product_detail->organizationProductId;
			$return['organizationProductId'] = $organizationProductId;
            $return['inventory']             = '';
		}
		
		$this->data['mktng_prd_detail']	= $product_detail;
		$organizationProductId  		= $product_detail->organizationProductId;
		$details = $this->product_marketing_m->product_retailer_inventorydetail($organizationProductId);
		$this->custom_log->write_log('custom_log','retailer product inventory details is '.print_r($details,true));
		
		$this->data['inventorydetail'] = $details;
		$colorsize = $this->product_m->get_product_color_and_size($organizationProductId);
		$this->custom_log->write_log('custom_log','color size details is '.print_r($colorsize,true));
		
		$this->data['colorsize'] = $colorsize;
		
		if(!empty($details))
		{
			$product_id = $details->productId;
			if($_POST)
			{
				//echo "<pre>"; print_r($_POST); exit;
				$this->custom_log->write_log('custom_log','after form submit data is '.print_r($_POST,true));
				
				$return['cost']         		 = $this->input->post('cost');
				$return['sale']         		 = $this->input->post('sale');
				$return['spacepointeDiscount']   = $this->input->post('spacepointediscount');
				$return['retailerDiscount']      = $this->input->post('retailerdiscount');
				$return['discountPrice']         = $this->input->post('discount');
				$datefrom                		 = $this->input->post('datefrom');
								
				$return['datefromvalue'] 		 = $datefrom;
				//$return['datefrom']      		 = date('Y-m-d h:i:s', strtotime($datefrom));
				$return['datefrom']      		 = date('Y-m-d', strtotime($datefrom));
				$dateto                  		 = $this->input->post('dateto');
				$return['datetovalue']   		 = $dateto;
				//$return['dateto']        		 = date('Y-m-d h:i:s', strtotime($dateto));
				$return['dateto']        		 = date('Y-m-d', strtotime($dateto));
				$return['productId']     		 = $product_id;
				$return['organizationProductId'] = $organizationProductId;
				$return['inventory'] = '';
				if(isset($_POST['inventory']))
				{
					$return['inventory'] = $this->input->post('inventory');
				}
															
				if (isset($_POST['level6']) && !empty($_POST['level6'])) 
				{
					$category_id = $this->input->post('level6');
				} 
				elseif (isset($_POST['level5']) && !empty($_POST['level5'])) 
				{
					$category_id = $this->input->post('level5');
				}
				elseif (isset($_POST['level4']) && !empty($_POST['level4'])) 
				{
					$category_id = $this->input->post('level4');
				}
				elseif (isset($_POST['level3']) && !empty($_POST['level3'])) 
				{
					$category_id = $this->input->post('level3');
				} 
				elseif (isset($_POST['level2']) && !empty($_POST['level2'])) 
				{
					$category_id = $this->input->post('level2');
				}
				elseif (isset($_POST['level1']) && !empty($_POST['level1'])) 
				{
					$category_id = $this->input->post('level1');
				}
				
				$rules = add_marketing_product_rules();
				if(isset($_POST['inventory']))
				{
					$rules[]=	array(
									'field' => 'inventory',
									'label' => 'Inventory',
									'rules' => 'trim|required'
								);
				}
				if(!empty($colorsize))
			 	{
			 		$flag = TRUE;
				 	foreach($colorsize as $value)
					{
						$boxVal = $this->input->post('inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)));
						if(!empty($boxVal))
						{
							$flag = FALSE;
						}
					}
					if($flag)
					{
						foreach($colorsize as $value)
						{
							$rules[] = array(
											'field' => 'inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)),
											'label' => 'At least one',
											'rules' => 'trim|required'
										);
						}			
					}
					else
					{
						foreach($colorsize as $value)
						{
							$rules[] = array(
											'field' => 'inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)),
											'label' => 'Inventory',
											'rules' => 'trim'
										);
						}
					}
				} 
				$this->custom_log->write_log('custom_log','rules array is '.print_r($rules,true));
				
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run())
				{
					if(!empty($colorsize))
					{
						foreach($colorsize as $value)
						{
							$boxVal = $this->input->post('inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)));
							if(!empty($boxVal))
							{
								$return['inventory']+=$boxVal;
							}
						}
					}
					
					$this->product_marketing_m->unactive_marketing_product($marketingProductId);
					$this->custom_log->write_log('custom_log','unactive marketing product id is '.$marketingProductId);
					
					$newMarketingProductId = $this->product_marketing_m->add_markeitng_product($return, $organizationId);
					$this->custom_log->write_log('custom_log','New marketing product id is '.$newMarketingProductId);
					
                	if(!empty($newMarketingProductId)) 
					{
                    	$return['marketingProductId'] = $newMarketingProductId;
                    	$return['categoryId']         = $category_id;
						
						if(!empty($colorsize))
						{
							foreach($colorsize as $value)
							{
								$boxVal = $this->input->post('inventoryarr_'.$value->colorId.preg_replace('/[^A-Za-z0-9\-]/','',trim($value->size)));
								if(!empty($boxVal))
								{
									$marketingProductSizeId = $this->product_marketing_m->add_marketing_size_stock($newMarketingProductId,$boxVal,trim($value->size),$value->colorId);
									$this->custom_log->write_log('custom_log','marketing product color size id is '.$marketingProductSizeId);
								}
							}
						}
						$rs = $this->product_marketing_m->add_product_category($return,$organizationId);
                  		$this->session->set_flashdata('success','Inventory Updated Successfully');
	                    $this->custom_log->write_log('custom_log','Inventory Updated Successfully');
	                }
				   	else 
				  	{
						$this->session->set_flashdata('error','Flash prdouct inventory not update');
						$this->custom_log->write_log('custom_log','Flash prdouct inventory not update');
                    }
				   	redirect(base_url().'admin/product_marketing_management');
				}				
			}
			
			$category_details = $this->product_marketing_m->parent_category_listing($category_id);
			$this->custom_log->write_log('custom_log','category details is '.print_r($category_details,true));
			
			$category_array    = get_object_vars($category_details);
			$marketingcategory = array_filter($category_array);
			$category_listing  = array_values($marketingcategory);			
			$category_listing  = array_reverse ($category_listing);
			$return['category_listing'] = $category_listing;
			$this->data['result']       = $return;
			
			$where                      = 'isMarketing ="1"';
			$this->data['catlist']      = $this->segment_cat_m->marketing_segment_list('', '', $where);
			$this->data['product_data'] = $this->Sementic_product_m->get_product_detail($product_id);
			$this->adminCustomView('marketing/edit_product', $this->data);
		}
		else
		{
			$this->session->set_flashdata('error','NO inventory available for this product');
			redirect('admin/product_management');
		}
	 }
	 
	public function history_list()
    {
        $this->adminCustomView('marketing/history_list', $this->data);
    }
    
	public function historyAjaxFun()
	{
        $perPage         = $this->input->post('sel_no_entry');
        $productName     = trim($this->input->post('productName'));
        $productCategory = trim($this->input->post('productCategory'));
        $where           = '';
        
		if(!empty($productName)) 
		{
			$productName  = trim(preg_replace('/^([\'"])(.*)\\1$/','\\2',$productName)); 
			$where = "trim(product.code) LIKE '".mysql_real_escape_string($productName)."%'";
        }
		
        if(!empty($productCategory)) 
		{
        	if($where) 
			{
                $where .= " AND trim(category.categoryCode) LIKE '" . $productCategory . "%'";
            }
			else 
			{
                $where = "trim(category.categoryCode) LIKE '" . $productCategory . "%'";
            }
        }
		
        if(!empty($where)) 
		{
        	$where = '(' . $where . ')';
        }
        $total = $this->product_marketing_m->total_products_history($where);
        
        $pagConfig = array(
            'base_url'    => base_url().$this->session->userdata('userType').'/product_marketing_management/historyAjaxFun',
            'total_rows'  => $total,
            'per_page'    => $perPage,
            'uri_segment' => 4,
            'num_links'   => 4
        );
        
        $this->ajax_pagination->initialize($pagConfig);
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
        $this->data['list']  = $this->product_marketing_m->product_history_list($page,$pagConfig['per_page'],$where);
      	$this->load->view('marketing/ajax_product_history_list', $this->data);
    }
	
	public function history_product_view($marketingProductId)
	{
		$marketingProductId = id_decrypt($marketingProductId);
		$organizationId 	= $this->session->userdata('organizationId');
		$product_detail		= $this->data['result'] = $this->product_marketing_m->inventory_details_with_category($marketingProductId);
		//echo "<pre>"; print_r($product_detail); exit;
		$product_id         = $product_detail->productId;
		$category_id='';
		if(!empty($product_detail))
		{
			$category_id                   = $product_detail->categoryId;
			$return['cost']                = $product_detail->costPrice;
            $return['sale']                = $product_detail->currentPrice; 
			$return['spacepointeDiscount'] = $product_detail->spacepointeDiscount;
            $return['retailerDiscount']    = $product_detail->retailerDiscount;
			$return['discountPrice']       = $product_detail->discountPrice;
            $datefrom                      = $product_detail->effectiveDtFrom;
			
			$color_array  = '';	
			$product_size = '';
			if(!empty($product_detail->colorId))
			{
				$color_array = explode(',',$product_detail->colorId);
			}
			
			if(!empty($product_detail->product_size))
			{
				$product_size = explode(',',$product_detail->product_size);
			}
			
			$stock = explode(',',$product_detail->stock);
			if(!empty($color_array))
			{
				foreach($color_array as $key=>$single_color)
				{
					if(!empty($single_color))
					{
						$inventorydetails[$single_color.$product_size[$key]]=$stock[$key];
					}
					else
					{
						$inventorydetails[$product_size[$key]]=$stock[$key];
					}
				}
			}
			elseif(!empty($product_size))
			{
				foreach($product_size as $key => $size_detail)
				{
					$inventorydetails[$size_detail]=$stock[$key];
				}
			}
			else
			{
				$inventorydetails=$product_detail->currentQty;
			}
			
			$this->data['inventory_details'] = $inventorydetails;
			$return['datefromvalue'] = $datefrom;
            $return['datefrom']      = date('Y-m-d h:i:s', strtotime($datefrom));
            $dateto                  = $product_detail->effectiveDtTo;
            $return['datetovalue']   = $dateto;
            $return['dateto']        = date('Y-m-d h:i:s', strtotime($dateto));
            $return['productId']     = $product_id;
			$organizationProductId  		= 	$product_detail->organizationProductId;
			$return['organizationProductId']     = $organizationProductId;
            $return['inventory']='';
		}
		$this->data['mktng_prd_detail']	= $product_detail;
		$organizationProductId  		= $product_detail->organizationProductId;
		$details = $this->product_marketing_m->product_retailer_inventorydetail($organizationProductId);
		if(empty($details))
		{
			$this->session->set_flashdata('error','NO inventory available for this product');
			redirect(base_url().'admin/product_management');
		}
		$this->data['inventorydetail']	= 	$details;
		$colorsize						= 	$this->product_m->get_product_color_and_size($organizationProductId);
		$this->data['colorsize']		=	$colorsize;
				
				
		$product_id=$details->productId;
		$category_details=$this->product_marketing_m->parent_category_listing($category_id);
		$category_array=	get_object_vars($category_details);
		$marketingcategory=array_filter($category_array);
		$category_listing=array_values($marketingcategory);
			
		$category_listing=array_reverse ($category_listing);
		$return['category_listing']=$category_listing;
		$this->data['result']=$return;
		$where                             = 'isMarketing ="1"';
		$this->data['catlist']             = $this->segment_cat_m->segment_list('', '', $where);
		$this->data['product_data']        = $this->Sementic_product_m->get_product_detail($product_id);
		$resultProductDetail               = $this->product_lib->product_review($product_id);
		$this->adminCustomView('marketing/history_product_view', $this->data);
	}
}