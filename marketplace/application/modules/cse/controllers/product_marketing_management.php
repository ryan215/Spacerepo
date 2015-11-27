<?php
if (!defined('BASEPATH'))
    exit('No Direct Access Allowed');

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
        $this->cseCustomView('admin/marketing/product_list', $this->data);
    }
    function prodAjaxfun()
    {
        $perPage         = $this->input->post('sel_no_entry');
        $productName     = $this->input->post('productName');
        $productCategory = $this->input->post('productCategory');
        $where           = '';
        
        if (empty($perPage)) {
            $perPage = 10;
        }
        
        if (!empty($productName)) {
            $where = "product.code LIKE '" . $productName . "%'";
        }
        if (!empty($productCategory)) {
            if ($where) {
                $where .= " AND category.categoryCode LIKE '" . $productCategory . "%'";
            } else {
                $where = "category.categoryCode LIKE '" . $productCategory . "%'";
            }
        }
        if (!empty($where)) {
            $where = '(' . $where . ')';
            
        }
        $total = $this->product_marketing_m->total_products($where);
        
        $pagConfig = array(
            'base_url' => base_url() . $this->session->userdata('userType').'/product_marketing_management/prodAjaxfun',
            'total_rows' => $total,
            'per_page' => $perPage,
            'uri_segment' => 4,
            'num_links' => 4
        );
        
        $this->ajax_pagination->initialize($pagConfig);
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
        $this->data['list']  = $this->product_marketing_m->product_list($page, $pagConfig['per_page'], $where);
        $this->load->view('admin/marketing/ajax_product_list', $this->data);
        
    }
	
	public function addProductRetailer($productId)
	{
		$this->data['productId']=id_decrypt($productId);
		$this->cseCustomView('admin/marketing/product_retailer_list',$this->data);
	}
	public function ajaxProductRetailer($productId)
	{
		
        $perPage         = $this->input->post('sel_no_entry');
        $businessName     = $this->input->post('businessName');
		$state     = $this->input->post('state');
		$area     = $this->input->post('area');
		$ownerName     = $this->input->post('ownerName');
        $retailerInventory = $this->input->post('retailerInventory');
		   $productId=id_decrypt($productId);
		$where='organization_product.productId = '.$productId;
        
        if (empty($perPage)) {
            $perPage = 10;
        }
		if(!empty($businessName))
		{
			$where.=' and organization.organizationName like "%'.$businessName.'%"';
			
		}
		if(!empty($state))
		{
			$where.=' and state.stateName like "%'.$state.'%"';
			
		}
		if(!empty($area))
		{
			$where.=' and area.area like "%'.$area.'%"';
			
		}
		if(!empty($ownerName))
		{
			$where.=' and concat(employee.firstName," ",employee.lastName) like "%'. $ownerName .'%"';
			
		}
		
		
     
		
       
        $total = $this->product_marketing_m->total_product_retailer($where);
        
        $pagConfig = array(
            'base_url' => base_url() . $this->session->userdata('userType') . '/product_marketing_management/ajaxProductRetailer/'.id_encrypt($productId),
            'total_rows' => $total,
            'per_page' => $perPage,
            'uri_segment' => 5,
            'num_links' => 4
        );
        
        $this->ajax_pagination->initialize($pagConfig);
        
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
        $result  = $this->product_marketing_m->product_retailer_list($page, $pagConfig['per_page'], $where);
       // print_r($this->data['list']);
	   $list = array();
		if(!empty($result))
		{
			$i = 0;
			foreach($result as $row)
			{
				$list[$i]['organizationName'] 	   = $row->organizationName;
				$list[$i]['firstLastName'] 	  	   = $row->firstName.' '.$row->lastName;
				$list[$i]['businessPhone']	  	   = $row->businessPhoneCode.$row->businessPhone;
				$list[$i]['stateName'] 			   = $row->stateName;
				$list[$i]['areaName'] 			   = $row->area;
				$list[$i]['currentPrice']		   = $row->currentPrice;
				$list[$i]['currentQty'] 		   = $row->currentQty;
				$list[$i]['organizationProductId'] = $row->organizationProductId;
				$i++;
			}
		}
		$this->data['list']  = $list;
		$this->load->view('admin/marketing/ajax_product_retailer',$this->data);
       
	}
    public function addProduct($organizationProductId = 0)
    {
        $organizationProductId     = id_decrypt($organizationProductId);
		$details=$this->product_marketing_m->product_retailer_inventorydetail($organizationProductId);
		$this->data['inventorydetail']= $details;
		$colorsize=$this->product_m->get_product_color_and_size($organizationProductId);
		$this->data['colorsize']=$colorsize;
		if(!empty($details)){
		$product_id=$details->productId;
        $organizationId = $this->session->userdata('organizationId');
        //echo $organizationId;
        if (isset($_POST) && !empty($_POST)) {
			
        //echo "<pre>"; print_r($_POST); exit;
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
					$boxVal = $this->input->post('inventoryarr_'.$value->colorId.trim($value->size));
					if(!empty($boxVal))
					{
						$flag = FALSE;
					}
				}
				if($flag)
				{
					foreach($colorsize as $value)
					{
						$rules[]=	array(
							'field' => 'inventoryarr_'.$value->colorId.trim($value->size),
							'label' => 'At least one',
							'rules' => 'trim|required'
						);
					}			
				}
				else
				{
					foreach($colorsize as $value)
					{
						$rules[]=	array(
							'field' => 'inventoryarr_'.$value->colorId.trim($value->size),
							'label' => 'Inventory',
							'rules' => 'trim'
						);
					}
				}
			 } //echo "<pre>"; print_r($rules); exit;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run()) 
			{
				//echo "<pre>"; print_r($_POST); exit;
            	$return['cost']          = $this->input->post('cost');
                $return['sale']          = $this->input->post('sale');
				$return['spacepointeDiscount']          = $this->input->post('spacepointediscount');
                $return['retailerDiscount']          = $this->input->post('retailerdiscount');
				$return['discountPrice']          = $this->input->post('discount');
                $datefrom                = $this->input->post('datefrom');
				
                $return['datefromvalue'] = $datefrom;
                $return['datefrom']      = date('Y-m-d h:i:s', strtotime($datefrom));
                $dateto                  = $this->input->post('dateto');
                $return['datetovalue']   = $dateto;
                $return['dateto']        = date('Y-m-d h:i:s', strtotime($dateto));
                $return['productId']     = $product_id;
				$return['organizationProductId']     = $organizationProductId;
               	
				$return['inventory']='';
				if(isset($_POST['inventory']))
				{
				   $return['inventory']     = $this->input->post('inventory');
				}
				else
			   	{
				  $return['inventoryarr'] = $this->input->post('inventoryarr');
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
               /* if(isset($return['inventoryarr']) && !empty($return['inventoryarr']))
				{
					foreach($return['inventoryarr'] as $key=>$inventorydetail)
					{
						$return['inventory'] +=$inventorydetail;
					}
				}*/
				if(!empty($colorsize))
				{
					foreach($colorsize as $value)
					{
						$boxVal = $this->input->post('inventoryarr_'.$value->colorId.trim($value->size));
						if(!empty($boxVal))
						{
							$return['inventory']+=$boxVal;
						}
					}
				}
               
                
                $marketingProductId = $this->product_marketing_m->add_markeitng_product($return, $organizationId);
                if (!empty($marketingProductId)) 
				{
                    $return['marketingProductId'] = $marketingProductId;
                    $return['categoryId']         = $category_id;
					/*if(isset($return['inventoryarr']) && !empty($return['inventoryarr']))
					{
						foreach($return['inventoryarr'] as $key=>$inventorydetail)
						{
							$this->product_marketing_m->add_marketing_size_stock($marketingProductId,$inventorydetail,$colorsize[$key]->size,$colorsize[$key]->colorId);
						}
					}*/
					if(!empty($colorsize))
					{
						foreach($colorsize as $value)
						{
							$boxVal = $this->input->post('inventoryarr_'.$value->colorId.trim($value->size));
							if(!empty($boxVal))
							{
								$this->product_marketing_m->add_marketing_size_stock($marketingProductId,$boxVal,trim($value->size),$value->colorId);
							}
						}
					}
	                    $rs = $this->product_marketing_m->add_product_category($return, $organizationId);
                    	$this->session->set_flashdata('success', $this->lang->line('success_add_inventory'));
	                    $this->custom_log->write_log('custom_log', $this->lang->line('success_add_inventory'));
	                    //$this->session->set_flashdata('success','successfully Added marketing Product');
	                    redirect('cse/product_marketing_management');
	              }
				  else 
				  {
                  	$this->session->set_flashdata('error', 'error in adding product');
                    redirect('cse/product_marketing_management');
                	}
            	}
        	}
        $where                             = 'isMarketing ="1"';
        $this->data['catlist']             = $this->segment_cat_m->marketing_segment_list('', '', $where);
        $this->data['product_data']        = $this->Sementic_product_m->get_product_detail($product_id);
        $resultProductDetail               = $this->product_lib->product_review($product_id);
        //print_r($resultProductDetail);
      //  $this->data['resultProductDetail'] = $resultProductDetail;
        
        //print_r($this->data['product_data']);
        $this->cseCustomView('admin/marketing/add_product', $this->data);
		}else{
			$this->session->set_flashdata('error','NO inventory available for this product');
			redirect('cse/product_management');
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
        if ($str < $sale) {
            //$this->form_validation->set_message('check_greater', 'The %s field must be greate than %s');
			$this->form_validation->set_message('check_greater', 'Effective sales price should be less than or equal to the Actual price');
            return FALSE;
        } else {
            return TRUE;
        }
    }  
	public function check_lesser($str, $attr)
    {
        $sale = $this->input->post($attr);
        if ($str > $sale) {
            $this->form_validation->set_message('check_greater', 'The %s field must be greate than %s');
            return FALSE;
        } else {
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
	      $organizationId = $this->session->userdata('organizationId');
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
        $this->cseCustomView('marketing/inventory_details_view', $this->data);
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
    
}