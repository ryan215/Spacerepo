<?php defined ('BASEPATH') OR exit( 'No direct script access allowed' );
    require APPPATH . '/libraries/REST_Controller.php';

    class ManageDiscount extends REST_Controller
    {
        public function __construct()
        {
            parent::__construct ();
            $this->apiresponse['time'] = time ();
            // load  twilio model for sending message
            $this->load->model ('twillo_m');
            $this->load->model ('api_discount_m');
            $this->load->helper ('api_validation');
            $language = $this->config->item ('supported_languages');

            if(is_array ($this->response->lang)) {
                $languageToSet = $language[$this->response->lang[0]];
                $this->custom_log->write_log ('custom_log', print_r ($this->response->lang, TRUE));
                $this->lang->load ('error', $languageToSet);
                $this->lang->load ('success', $languageToSet);

            } else {
                $languageToSet = $language[$this->response->lang];
                $this->custom_log->write_log ('custom_log', print_r ($this->response->lang, TRUE));
                $this->lang->load ('error', $languageToSet);
                $this->lang->load ('success', $languageToSet);

            }
        }

        public function addDiscount_post()
        {
            /**
             * @param organizationId
             * @param employeeId   lastModifiedBy  User employeeId
             * @Param discount  discount value in percentage
             * @param discountOn   value 1 for products
             * @param discountType 1 for percentage 2 for static
             *
             * */
            $rules = api_add_discount_post ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {


                $organizationId = $this->post ('organizationId');
                $return['employeeId'] = $this->post ('employeeId');
                $return['title'] = $this->post ('title');
                $return['discountOn'] = $this->post ('discountOn');

                $return['discount'] = $this->post ('discount');
                $productDiscountId = $this->api_discount_m->add_discount ($return, $organizationId);
                $this->api_discount_m->add_discount_history ($return, $productDiscountId);
                if(!empty( $productDiscountId )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message'    => 'Successfully Added Discount',
                        'discountId' => $productDiscountId
                    );

                    $this->response ($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'Error In Adding Discount'
                    );

                    $this->response ($this->apiresponse, 200);
                }

            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }

        }

        public function addProductDiscount_post()
        {

            /*
             * @param products     json array of products
             * @param employeeId  lastModifiedBy user Id
             * @param organizationId retailer organizationId
             *
             * */

            $rules = add_product_discount ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                $products = $this->post ('products');
                $products = json_decode ($products);
                $discountId = $this->post ('discountId');


                $rs = $this->api_discount_m->add_product_discount ($discountId, $products, $employeeId);
                if(!empty( $rs )) {
                    $this->apiresponse['success'] = 1;
                    $this->apiresponse['response'] = array(
                        'message' => 'successfully added the discount on product'
                    );

                    $this->response ($this->apiresponse, 200);
                } else {

                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in adding the discount'
                    );

                    $this->response ($this->apiresponse, 200);
                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }
        }

        public function removeProductsDiscount_post()
        {
            $rules = add_product_discount ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                $discountId = $this->post ('discountId');
                $products = $this->post ('products');
                $products = json_decode ($products);
                $rs = $this->api_discount_m->remove_product_discount ($discountId, $products, $employeeId);
                if(!empty( $rs )) {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully removed  products'
                    );

                    $this->response ($this->apiresponse, 200);
                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in removing product'
                    );

                    $this->response ($this->apiresponse, 200);
                }

            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }
        }

        public function discountListing_post()
        {
            $rules = required_organization_id ();
            $rules[] = array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required'
            );

            $rules[] = array(
                'field' => 'count',
                'label' => 'Count',
                'rules' => 'trim|required'
            );
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $set = $this->post ('set');
                $limit = $this->post ('count');
                $set = $set - 1;
                $start = $set * $limit;
                $set++;
                $start1 = $set * $limit;
                $where = '';
                $discountListing = $this->api_discount_m->get_discount_list ($organizationId, $start, $limit, $where);
                $more = $this->api_discount_m->get_discount_list ($organizationId, $start1, 1, $where);
                if(!empty( $more )) {
                    $more = TRUE;

                } else {
                    $more = FALSE;
                }

                if(!empty( $discountListing )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully get discount Listing',
                        'data'    => $discountListing,
                        'more'    => $more,
                    );

                    $this->response ($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'No Record Found',

                    );

                    $this->response ($this->apiresponse, 200);

                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);

            }
        }

        public function discountIdProductListing_post()
        {
            $rules = required_organization_id ();
            $rules[] = array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required'
            );
            $rules[] = array(
                'field' => 'discountId',
                'label' => 'discountId',
                'rules' => 'trim|required'
            );

            $rules[] = array(
                'field' => 'count',
                'label' => 'Count',
                'rules' => 'trim|required'
            );
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $set = $this->post ('set');
                $limit = $this->post ('count');
                $discountId = $this->post ('discountId');
                $set = $set - 1;
                $start = $set * $limit;
                $set++;
                $start1 = $set * $limit;
                $where = '';
                $discountListing = $this->api_discount_m->get_product_discount_list ($organizationId, $discountId, $start, $limit, $where);
                $more = $this->api_discount_m->get_product_discount_list ($organizationId, $discountId, $start1, 1, $where);
                if(!empty( $more )) {
                    $more = TRUE;

                } else {
                    $more = FALSE;
                }

                if(!empty( $discountListing )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully get discount product  Listing',
                        'data'    => $discountListing,
                        'more'    => $more,
                    );

                    $this->response ($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'No Record Found',

                    );

                    $this->response ($this->apiresponse, 200);

                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);

            }
        }

        public function activateDeactivateDiscount_post()
        {
            $rules = api_activate_deactivate_discount ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $return['organizationId'] = $this->post ('organizationId');
                $return['discountId'] = $this->post ('discountId');
                $return['employeeId'] = $this->post ('employeeId');
                $return['activeStatus'] = $this->post ('activeStatus');
                $response = $this->api_discount_m->change_status ($return);
                $this->api_discount_m->add_discount_history ($return, $return['discountId']);
                if(!empty( $response )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully change the status'
                    );

                    $this->response ($this->apiresponse, 200);
                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'Error in changin the discount status '
                    );

                    $this->response ($this->apiresponse, 200);
                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);

            }
        }

        public function productListForDiscountId_post()
        {
            $rules = api_product_list_for_discount();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                $discountId = $this->post ('discountId');
                $set = $this->post ('set');
                $limit = $this->post ('count');
                $set = $set - 1;
                $start = $set * $limit;
                $set++;
                $start1 = $set * $limit;
                $product_list = $this->api_discount_m->product_list_for_discount_id ($organizationId, $employeeId, $discountId, $start, $limit);
                //	print_r($product_list);
                $more = $this->api_discount_m->product_list_for_discount_id ($organizationId, $employeeId, $discountId, $start1, 1);
                if(!empty( $more )) {
                    $more = TRUE;

                } else {
                    $more = FALSE;
                }
                if(!empty( $product_list )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'Successfully get the Product List',
                        'data'    => $product_list,
                        'more'    => $more
                    );

                    $this->response ($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'No Product Found in the list'
                    );

                    $this->response ($this->apiresponse, 200);

                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }
        }

    }

