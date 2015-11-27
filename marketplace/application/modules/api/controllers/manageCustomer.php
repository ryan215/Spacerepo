<?php defined('BASEPATH') OR exit( 'No direct script access allowed' );
    require APPPATH . '/libraries/REST_Controller.php';
    class ManageCustomer extends REST_Controller
    {
        public function __construct()
        {
            parent::__construct ();
            $this->apiresponse['time'] = time ();
            // load  twilio model for sending message
            $this->load->model ('twillo_m');
            $this->load->model ('customer_m');
            $this->load->model('api_customer_m');
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

        public function addCustomer_post()
        {
            $rules = add_organization_customer_rules ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $return = array();
                $return['imageName'] = '';
                $return['firstName'] = $this->post ('firstName');
                $return['lastName'] = $this->post ('lastName');
                $return['notes'] = $this->post ('notes');
                $return['phoneNo'] = $this->post ('phone');
                $return['email'] = $this->post ('email');
                $return['countryCode'] = '+234';
                $return['countryId'] = 154;
                $return['stateId'] = $this->post ('state');
                $return['cityId'] = $this->post ('city');
                $return['areaId'] = $this->post ('area');
                $return['zipcode'] = '';
                $return['street'] = $this->post ('addressLine1');
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');

                if(isset( $_FILES['file'] ) && $_FILES['file']['size'] > 0) {
                    $extension = pathinfo ($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $newImageName = ( $this->currentTimestamp * 2 ) . '.' . $extension;

                    $config['upload_path'] = './uploads/customer';
                    $config["allowed_types"] = "jpg|jpeg|png|gif";
                    $this->load->library ('upload', $config);
                    $config['file_name'] = $newImageName;
                    $this->upload->initialize ($config);
                    if($this->upload->do_upload ('file')) {
                        $return['imageName'] = $newImageName;
                        //$return['imagePath']=	'uploads/customer';
                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => $this->lang->line ('upload_failed')
                        );

                        $this->response ($this->apiresponse, 'json');
                    }
                }

                $customerId = $this->customer_m->add_organization_customer ($return, $employeeId);
                if($customerId) {
                    $organizationcustomer = $this->customer_m->add_retailer_customer ($organizationId, $customerId);
                    if(!empty( $organizationcustomer )) {
                        $addressId = $this->customer_m->add_address ($return);
                        if(!empty( $addressId )) {
                            $customeraddressId = $this->customer_m->add_customer_address ($customerId, $addressId);

                            if(!empty( $customeraddressId )) {
                                $this->apiresponse['success'] = 1;

                                $this->apiresponse['response'] = array(
                                    'message' => 'successfully registered customer'
                                );

                                $this->response ($this->apiresponse, 200);
                            } else {
                                $this->apiresponse['success'] = 0;

                                $this->apiresponse['response'] = array(
                                    'message' => 'Error in registering customer alot address'
                                );

                                $this->response ($this->apiresponse, 200);

                            }


                        } else {
                            $this->apiresponse['success'] = 0;

                            $this->apiresponse['response'] = array(
                                'message' => 'Error in registering customer address'
                            );

                            $this->response ($this->apiresponse, 200);
                        }
                    }


                }

            } else {

                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }
        }

        public function updateCustomer_post()
        {
            $rules = add_organization_customer_rules ();
            $rules[] = array( 'field' => 'customerId', 'label' => 'customerId', 'rules' => 'trim|required' );
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {

                $return = array();
                $return['imageName'] = '';
                $return['firstName'] = $this->post ('firstName');
                $return['lastName'] = $this->post ('lastName');
                $return['notes'] = $this->post ('notes');
                $return['phoneNo'] = $this->post ('phone');
                $return['email'] = $this->post ('email');
                $return['countryCode'] = '+234';
                $return['countryId'] = 154;
                $return['stateId'] = $this->post ('state');
                $return['cityId'] = $this->post ('city');
                $return['areaId'] = $this->post ('area');
                $return['street'] = $this->post ('addressLine1');
                $return['zipcode'] = '';
                $return['customerId'] = $this->post ('customerId');
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                if(isset( $_FILES['file'] ) && $_FILES['file']['size'] > 0) {
                    $extension = pathinfo ($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $newImageName = ( $this->currentTimestamp * 2 ) . '.' . $extension;

                    $config['upload_path'] = './uploads/customer';
                    $config["allowed_types"] = "jpg|jpeg|png|gif";
                    $this->load->library ('upload', $config);
                    $config['file_name'] = $newImageName;
                    $this->upload->initialize ($config);
                    if($this->upload->do_upload ('file')) {
                        $return['imageName'] = $newImageName;
                        $return['imagePath'] = 'uploads/customer';
                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array('message' => $this->lang->line ('upload_failed') );

                        $this->response ($this->apiresponse, 'json');
                    }
                }
                $customer_detail = $this->customer_m->get_user_detail ($return['customerId']);
                $this->customer_m->update_customer ($return, $return['customerId']);
                $this->customer_m->update_address ($customer_detail->addressId, $return);
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => 'successfully updated customer'
                );

                $this->response ($this->apiresponse, 200);


            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }
        }

        public function customerList_post()
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
                $limit = $this->post ('count');
                $set = $this->post ('set');
                $set = $set - 1;
                $start = $set * $limit;
                $set++;
                $start1 = $set * $limit;
                if(isset($_POST['query']))
                {
                    $query=$this->post('query');
                    $where='concat(customer.firstName," ",customer.lastName) like "%'.$query .'%"';
                }else
                {
                    $where='';
                }
                $customer_list = $this->customer_m->customer_list ($organizationId, $start, $limit,$where);
                $more = $this->customer_m->customer_list ($organizationId, $start1, 1,$where);
                if(!empty( $more )) {
                    $more = TRUE;

                } else {
                    $more = FALSE;
                }

                if(!empty( $customer_list )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'data' => $customer_list,
                        'message' => '',
                        'more' => $more
                    )
                    ;

                    $this->response ($this->apiresponse, 200);
                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'no user found'
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

