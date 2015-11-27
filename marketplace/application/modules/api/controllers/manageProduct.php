<?php defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/REST_Controller.php';

    class ManageProduct extends REST_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->apiresponse['time'] = time();
            // load  twilio model for sending message
            $this->load->model('twillo_m');
            $this->load->model('api_product_m');
            $this->load->model('employee_m');
            $this->load->helper('api_validation');
            $this->load->helper('api_product');
			$this->load->model('organization_category_m');
            $language = $this->config->item('supported_languages');

            if (is_array($this->response->lang)) {
                $languageToSet = $language[$this->response->lang[0]];
                $this->custom_log->write_log('custom_log', print_r($this->response->lang, true));
                $this->lang->load('error', $languageToSet);
                $this->lang->load('success', $languageToSet);

            } else {
                $languageToSet = $language[$this->response->lang];
                $this->custom_log->write_log('custom_log', print_r($this->response->lang, true));
                $this->lang->load('error', $languageToSet);
                $this->lang->load('success', $languageToSet);

            }
        }
        public function addProduct_post()
        {
            $rules=api_master_prd_inventory();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $retailerId=$this->post('employeeId');
                $this->custom_log->write_log('custom_log','data for the product api '.print_r($_POST,true));
                $upc=$this->post('upc');
                $organizationId=$this->post('organizationId');
                $product_detail_with_upc=$this->api_product_m->get_product_details_from_upc($organizationId,$upc);


                if(empty($product_detail_with_upc)) {
                    $product_id = $this->api_product_m->add_product($_POST);

                    $_POST['productId'] = $product_id;
                    $this->custom_log->write_log('custom_log', 'product id is ' . $product_id);
                    if (!empty($product_id)) {
                        $organization_product_id = $this->api_product_m->add_organization_product($_POST);
                        if (!empty($organization_product_id)) {
                            $categoryId = $this->api_product_m->organization_product_Category($_POST, $retailerId);

                            if (!empty($categoryId)) {
                                $this->apiresponse['success'] = 1;

                                $this->apiresponse['response'] = array(
                                    'message' => 'product Added successfully'
                                );

                                $this->response($this->apiresponse, 200);
                            } else {

                                $this->apiresponse['success'] = 0;

                                $this->apiresponse['response'] = array(
                                    'message' => 'category is not added'
                                );

                                $this->response($this->apiresponse, 200);
                            }

                        } else {
                            $this->apiresponse['success'] = 0;

                            $this->apiresponse['response'] = array(
                                'message' => 'product not added successfully'
                            );

                            $this->response($this->apiresponse, 200);


                        }
                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => 'product not added'
                        );

                        $this->response($this->apiresponse, 200);

                    }

                }else
                {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'Product with this upc already added'
                    );

                    $this->response($this->apiresponse, 200);

                }

            }
            else
            {
                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);
            }
        }


        public function masterProductList_post()
        {
            $rules=master_list_validation();
            $this->form_validation->set_rules($rules);

            if($this->form_validation->run())
            {

                $organizationId =	 $this->post('organizationId');
                $limit			=	 $this->post('count');
                $set			=	 $this->post('set');
                $where     ='product.active = 1 ';
                if(isset($_POST['categoryId']))
                {
                    $categoryId		=	 	$this->post('categoryId');
                    $where			.= ' and category.categoryId='.$categoryId;
                }
                else
                {
                    $categoryId		=		'';
                }
                if(isset($_POST['code']))
                {
                    $productcode		=	 	$this->post('code');
                    $where			.= ' and product.code="'.$productcode.'"';
                }
                else
                {

                }
                if(isset($_POST['brandId']))
                {
                    $brandId		=		$this->post('brandId');
                    $where			.=	' and brand.brandId='.$brandId;

                }
                else
                {

                    $brandId		=		'';
                }
                $limit=$this->post('count');
                $set=$this->post('set');
                $set=$set-1;
                $start=$set*$limit;
                $set++;
                $start1=$set*$limit;
                if(!isset($where) || empty($where))
                {
                    $where='';
                }
                $organizationProductList=$this->api_product_m->get_organization_product_id_list($organizationId);
                //print_r($where_not_in);
                //	exit;
                $where_not_in=$organizationProductList->productIdList;


                $product_list=$this->api_product_m->master_product_list($organizationId,$start,$limit,$where,$where_not_in);
                $more = $this->api_product_m->master_product_list($organizationId,$start1,1,$where,$where_not_in);

                if(!empty($more))
                {
                    $more=TRUE;

                }else
                {
                    $more=FALSE;
                }
                if(!empty($product_list)){
                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => '',
                        'data'	=> $product_list,
                        'more'	=>	$more,
                        'sql'	=>	$this->db->last_query()
                    );

                    $this->response($this->apiresponse,200);
                }
                else
                {
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'no product found',

                    );

                    $this->response($this->apiresponse,200);

                }


            }else
            {
                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

            }
        }
        public function addRetailerPrdMasterList_post()
        {
            $rules = api_master_prd_inventory();
            $rules[]=array
            (
                'field' => 'productId',
                'label' => 'product Id',
                'rules' => 'trim|required'
            );
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $ProductArr['organizationId']		=	$this->post('organizationId');
                $ProductArr['productId']			=	$this->post('productId');
                $ProductArr['categoryId']			=	$this->post('categoryId');
                $ProductArr['productCodeOveride'] 	=	$this->post('productCodeOveride');
                $ProductArr['currentPrice']			=	$this->post('currentPrice');
                $ProductArr['productDescription']	=	$this->post('productDescription');
                $ProductArr['costPrice']			=	$this->post('costPrice');
                $ProductArr['employeeId']			=	$this->post('employeeId');
                $ProductArr['upc']					=	$this->post('upc');
                $product_detail=$this->api_product_m->get_product_details_from_upc($ProductArr['organizationId'],$ProductArr['upc']);
                if(count($product_detail)==0) {
                    $rs = $this->api_product_m->add_organization_product($ProductArr);

                    if (!empty($rs)) {
                        //$ProductArr['productId']=$rs;
                        $categoryId = $this->api_product_m->organization_product_Category($ProductArr, $ProductArr['employeeId']);

                        if (!empty($categoryId)) {
                            $this->apiresponse['success'] = 1;

                            $this->apiresponse['response'] = array(
                                'message' => 'product Added successfully'
                            );

                            $this->response($this->apiresponse, 200);
                        } else {

                            $this->apiresponse['success'] = 0;

                            $this->apiresponse['response'] = array(
                                'message' => 'category is not added'
                            );

                            $this->response($this->apiresponse, 200);
                        }

                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => 'Error in inventory adding'
                        );

                        $this->response($this->apiresponse, 200);
                    }
                }else
                {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'Product with this upc already exits'
                    );

                    $this->response($this->apiresponse, 200);
                }


            }
            else
            {
                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);
            }
        }
        public function updateProduct_post()
        {
            $rules=api_master_prd_inventory();
            $rules[]=array
            (
                'field' => 'organizationProductId',
                'label' => 'Organization product Id',
                'rules' => 'trim|required'
            );
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $organizationProductId=$this->post('organizationProductId');
                $response=$this->api_product_m->update_product($_POST,$organizationProductId);
                if(!empty($response))
                {
                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'succesfully updated product'
                    );

                    $this->response($this->apiresponse,200);
                }
                else
                {
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'Error in updating product'
                    );

                    $this->response($this->apiresponse,200);
                }

            }
            else
            {

                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

            }

        }
        public function addProductInventory_post()
        {
            $rules=api_inventory_rules();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $employeeId = $this->post('employeeId');
                $organizationProductId	=	$this->post('organizationProductId');
                $inventory				=	$this->post('inventory');
                $stock= 'currentQty + '.$inventory ;
                $response=$this->api_product_m->add_product_inventory($organizationProductId,$stock,$employeeId);
                if(!empty($response))
                {

                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'successfully added product inventory'
                    );

                    $this->response($this->apiresponse,200);
                }
                else
                {

                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'error in inventory adding'
                    );

                    $this->response($this->apiresponse,200);
                }
            }
            else
            {

                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);
            }
        }
        public function organizationProductList_post()
        {
            $rules=master_list_validation();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $organizationId=$this->post('organizationId');
                $set= $this->post('set');
                $limit=$this->post('count');
                $start1=$set*$limit;
                if(isset($_POST['isInventory'])){
                    $isInventory=$this->post('isInventory');
                    if(!empty($isInventory))
                    {
                        $where='organization_product.currentQty > 0 '	;
                        if(isset($_POST['query']))
                        {
                            $query=$this->post('query');
                            $where .=' and organization_product.productCodeOveride like "%'.$query.'%"';
                        }

                    }
                    else
                    {
                        $where='';
                    }
                }
                else
                {
                    $where='';
                    if(isset($_POST['query']))
                    {
                        $query=$this->post('query');
                        $where .='organization_product.productCodeOveride like "%'.$query.'%"';
                    }


                }


                $more=$this->api_product_m->organization_product_list($organizationId,$start1,1,$where);
                $set--;
                $start=$set*$limit;
                $myproduct_list=$this->api_product_m->organization_product_list($organizationId,$start,$limit,$where);
                if(!empty($more))
                {
                    $more=TRUE;

                }else
                {
                    $more=FALSE;
                }
                if(!empty($myproduct_list))
                {
                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'Success fully gettign the data',
                        'data'	=>	$myproduct_list,
                        'more'	=>	$more,


                    );

                    $this->response($this->apiresponse,200);
                }
                else
                {
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'No Product is Available',

                    );

                    $this->response($this->apiresponse,200);
                }

            }
            else
            {
                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

            }
        }


        public function reduceProductInventory_post()
        {
            $rules=api_inventory_rules();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $employeeId= $this->post('employeeId');
                $organizationProductId	=	$this->post('organizationProductId');
                $inventory				=	$this->post('inventory');
                $stock= 'currentQty - '.$inventory ;
                $response=$this->api_product_m->add_product_inventory($organizationProductId,$stock,$employeeId);
                if(!empty($response))
                {

                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'successfully added product inventory'
                    );

                    $this->response($this->apiresponse,200);
                }
                else
                {

                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'error in inventory adding'
                    );

                    $this->response($this->apiresponse,200);
                }
            }
            else
            {
                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

            }


        }
        public function getProductDetail_post()
        {
            $rules=api_upc_product_detail();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $organizationId=$this->post('organizationId');
                $upc=$this->post('upc');
                $product_detail=$this->api_product_m->get_product_details_from_upc($organizationId,$upc);

                if(!empty($product_detail))
                {
                    if($product_detail->currentQty > 0  ){
                        $this->apiresponse['success']=1;

                        $this->apiresponse['response'] =array(
                            'message' => 'successfully get product details',
                            'data'		=> $product_detail
                        );

                        $this->response($this->apiresponse,200);
                    }
                    else
                    {
                        $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'no inventory present',
                            'inventory'=> 'inventory is null'
                        );

                        $this->response($this->apiresponse,200);

                    }
                }
                else
                {
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'no product Found'
                    );

                    $this->response($this->apiresponse,200);

                }


            }
            else
            {
                $this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

            }

        }
		public function getMasterProductCategoryList_post()
		{
			 $rules=required_organization_id();
          
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
			$category_listing = $this->organization_category_m->get_master_product_category_list();
			if(!empty($category_listing))
			{
				   $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'successfully get confirm listing',
							'data'    =>	$category_listing
                            
                        );

                        $this->response($this->apiresponse,200);
			}
			else
			{
				
                        $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'no category found',
                            
                        );

                        $this->response($this->apiresponse,200);
				
			}
			}else
			{  
				$this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

				
			}
			
			
		}
		function getMasterBrandList_post()
		{
			
			 $rules=required_organization_id();
          
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
			$brand_listing = $this->organization_category_m->get_brand_list();
			if(!empty($brand_listing))
			{
				   $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'successfully get brand listing',
							'data'    =>	$brand_listing
                            
                        );

                        $this->response($this->apiresponse,200);
			}
			else
			{
				
                        $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'no brand found',
                            
                        );

                        $this->response($this->apiresponse,200);
				
			}
			}else
			{  
				$this->apiresponse['success']=0;

                $this->apiresponse['response'] =array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse,200);

				
			}
			
		}



    }

