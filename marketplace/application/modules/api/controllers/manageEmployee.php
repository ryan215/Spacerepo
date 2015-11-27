<?php defined('BASEPATH') OR exit( 'No direct script access allowed' );
    require APPPATH . '/libraries/REST_Controller.php';

    class ManageEmployee extends REST_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->apiresponse['time'] = time();
            // load  twilio model for sending message
            $this->load->model('twillo_m');
            $this->load->model('api_retailer_m');
            $this->load->model('employee_m');
            $this->load->helper('api_validation');
            $language = $this->config->item('supported_languages');

            if (is_array($this->response->lang)) {
                $languageToSet = $language[$this->response->lang[0]];
                $this->custom_log->write_log('custom_log', print_r($this->response->lang, TRUE));
                $this->lang->load('error', $languageToSet);
                $this->lang->load('success', $languageToSet);

            } else {
                $languageToSet = $language[$this->response->lang];
                $this->custom_log->write_log('custom_log', print_r($this->response->lang, TRUE));
                $this->lang->load('error', $languageToSet);
                $this->lang->load('success', $languageToSet);

            }
        }

        public function addEmployee_post()
        {
            $rules = api_add_employeerules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {
                $return = array();
                $return['imageName'] = '';
                $return['firstName'] = $this->post('firstName');
                $return['lastName'] = $this->post('lastName');
                $return['salary'] = $this->post('salary');
                $return['businessPhone'] = $this->post('businessPhone');
                $return['countryCode'] = '+234';
                $return['countryId'] = 154;
                $return['imageName'] = '';
                $return['email'] = $this->post('email');
                $return['stateId'] = $this->post('state');
                $return['cityId'] = $this->post('city');
                $return['areaId'] = $this->post('area');
                $return['street'] = $this->post('addressLine1');
                $return['designation'] = $this->post('designation');
                $return['role'] = json_decode($this->post('role'));
                $retailer_id = $this->post('employeeId');
                $organizationId = $this->post('organizationId');
                $return['userName'] = $this->post('userName');
                if (isset( $_FILES['file'] ) && $_FILES['file']['size'] > 0) {
                    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $newImageName = ( $this->currentTimestamp * 2 ) . '.' . $extension;

                    $config['upload_path'] = './uploads/employee';
                    $config["allowed_types"] = "jpg|jpeg|png|gif";
                    $this->load->library('upload', $config);
                    $config['file_name'] = $newImageName;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $return['imageName'] = $newImageName;
                        // $return['imagePath']=	'uploads/customer';
                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => $this->lang->line('upload_failed')
                        );

                        $this->response($this->apiresponse, 'json');
                    }
                }
                $employeeId = $this->api_retailer_m->add_retailer_employee($organizationId, $return, $retailer_id);
                $this->custom_log->write_log('custom_log', 'Employee id is ' . $employeeId);
                $this->custom_log->write_log('custom_log', 'add employee query ' . $this->db->last_query());
                if (!empty( $employeeId )) {
                    $addressId = $this->api_retailer_m->add_retailer_employee_address($return, $retailer_id);
                    $this->custom_log->write_log('custom_log', 'address id is ' . $addressId);
                    if ($addressId) {
                        $this->api_retailer_m->add_retailer_employee_addressTbl($employeeId, $addressId, $retailer_id);

                        if (!empty( $return['role'] )) {
                            $this->api_retailer_m->add_retailer_employee_role($organizationId, $employeeId, 19, $retailer_id);
                            $role_list = "";
                            foreach ($return['role'] as $roleId) {
                                $roleID = $this->api_retailer_m->add_retailer_employee_role($organizationId, $employeeId, $roleId, $retailer_id);
                                
                                $this->custom_log->write_log('custom_log', 'Role id is ' . $roleID);
                            }

                            if (!empty( $return['designation'] )) {
								$role_list=implode($return['role'],',');
                              $designationId=$this->api_retailer_m->get_designation_id($return['designation'], $organizationId);
							  if(empty($designationId)){
                                $designationId = $this->api_retailer_m->add_designation_role($organizationId, $return['designation'], $role_list, $retailer_id);
							  }
                                $this->retailer_m->add_employee_designation($employeeId, $designationId, $retailer_id);
                                $this->apiresponse['success'] = 1;

                                $this->apiresponse['response'] = array(
                                    'message' => 'success fully registered Employee'
                                );

                                $this->response($this->apiresponse, 200);

                            } else {
                                $this->apiresponse['success'] = 1;
                                $this->apiresponse['response'] = array(
                                    'message' => 'success fully registered Employee'
                                );

                                $this->response($this->apiresponse, 200);
                            }
                        } else {
                            $this->apiresponse['success'] = 0;

                            $this->apiresponse['response'] = array(
                                'message' => 'Role is not available'
                            );

                            $this->response($this->apiresponse, 200);

                        }

                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => 'error in address registration'
                        );

                        $this->response($this->apiresponse, 200);
                    }

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in employee registration'
                    );

                    $this->response($this->apiresponse, 200);
                }

            } else {

                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse, 200);
            }
        }

        public function retailerEmployeeRole_post()
        {
            $this->apiresponse['success'] = 1;

            $this->apiresponse['response'] = array(
                'message' => '',
                'data'    => $this->api_retailer_m->employee_roles()
            );

            $this->response($this->apiresponse, 200);
        }

        public function employeeList_post()
        {
            $rules = required_organization_id();
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
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {
                $organizationId = $this->post('organizationId');
                $limit = $this->post('count');
                $set = $this->post('set');
                $set = $set - 1;
                $start = $set * $limit;
                $set++;
                $start1 = $set * $limit;
                $employeelist = $this->employee_m->ajax_employee_list($start, $limit, $organizationId);
                $more = $this->employee_m->ajax_employee_list($start1, 1, $organizationId);
                //echo $this->db->last_query();
                if (!empty( $more )) {
                    $more = TRUE;

                } else {
                    $more = FALSE;
                }
                if (!empty( $employeelist )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => '',
                        'data'    => $employeelist,
                        'more'    => $more
                    );

                    $this->response($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => '',
                        'data'    => 'no employee found'
                    );

                    $this->response($this->apiresponse, 200);

                }

            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => '',
                    'data'    => 'please send valida parameter'
                );

                $this->response($this->apiresponse, 200);


            }
        }

        public function blockUnblockEmployee_post()
        {
            $rules = api_block_unblock_employee();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {
                $staffEmployeeId = $this->post('staffEmployeeId');
                $employeeId = $this->post('employeeId');
                $organizationId = $this->post('organizationId');
                $blockStatus = $this->post('blockStatus');
                $response = $this->employee_m->block_unblock_employee($staffEmployeeId, $blockStatus, $employeeId);
                if (!empty( $response )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'succesfully updated employee status'
                    );

                    $this->response($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in updating '
                    );

                    $this->response($this->apiresponse, 200);

                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array()
                );

                $this->response($this->apiresponse, 200);
            }


        }

        public function getRolesDesignation_post()
        {
            $organizationId = $this->post('organizationId');
            $roles = json_decode($this->post('roles'));
            if (!empty( $roles ) && !empty( $organizationId )) {
                $designation = $this->api_retailer_m->get_rolesdesignation($roles, $organizationId);
                if (!empty( $designation )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => '',
                        'data'    => $designation
                    );

                    $this->response($this->apiresponse, 200);

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'no designation found',
                        'data'    => ''
                    );

                    $this->response($this->apiresponse, 200);
                }

            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => 'please send valida parameter',
                    'data'    => ''
                );

                $this->response($this->apiresponse, 200);
            }

        }

        public function updateEmployee_post()
        {
            $rules = api_add_employeerules();
            $rules[] = array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required'
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {
                $return = array();
                $return['imageName'] = '';
                $return['firstName'] = $this->post('firstName');
                $return['lastName'] = $this->post('lastName');
                $return['salary'] = $this->post('salary');
                $return['businessPhone'] = $this->post('businessPhone');
                $return['countryCode'] = '+234';
                $return['countryId'] = 154;
                $return['imageName'] = '';
                $return['employeeId'] = $this->post('staffEmployeeId');
                $return['email'] = $this->post('email');
                $return['stateId'] = $this->post('state');
                $return['cityId'] = $this->post('city');
                $return['areaId'] = $this->post('area');
                $return['street'] = $this->post('addressLine1');
                $return['designation'] = $this->post('designation');
                $return['role'] = json_decode($this->post('role'));
                $retailer_id = $this->post('employeeId');
                $organizationId = $this->post('organizationId');
                $return['userName'] = $this->post('userName');
                if (isset( $_FILES['file'] ) && $_FILES['file']['size'] > 0) {
                    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $newImageName = ( $this->currentTimestamp * 2 ) . '.' . $extension;

                    $config['upload_path'] = './uploads/employee';
                    $config["allowed_types"] = "jpg|jpeg|png|gif";
                    $this->load->library('upload', $config);
                    $config['file_name'] = $newImageName;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $return['imageName'] = $newImageName;
                        // $return['imagePath']=	'uploads/customer';
                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => $this->lang->line('upload_failed')
                        );

                        $this->response($this->apiresponse, 'json');
                    }
                }
                $employeeId = $this->api_retailer_m->update_retailer_employee($organizationId, $return, $retailer_id);
                $this->custom_log->write_log('custom_log', 'Employee id is ' . $employeeId);
                $this->custom_log->write_log('custom_log', 'add employee query ' . $this->db->last_query());
                if (!empty( $employeeId )) {
                    $addressId = $this->api_retailer_m->add_retailer_employee_address($return, $retailer_id);
                    $this->custom_log->write_log('custom_log', 'address id is ' . $addressId);
                    if ($addressId) {
                        $this->api_retailer_m->add_retailer_employee_addressTbl($employeeId, $addressId, $retailer_id);

                        if (!empty( $return['role'] )) {
                            $this->api_retailer_m->add_retailer_employee_role($organizationId, $employeeId, 19, $retailer_id);
                            $role_list = "";
                            foreach ($return['role'] as $roleId) {
                                $roleID = $this->api_retailer_m->add_retailer_employee_role($organizationId, $employeeId, $roleId, $retailer_id);
                                $role_list .= $roleId . ',';
                                $this->custom_log->write_log('custom_log', 'Role id is ' . $roleID);
                            }

                            if (!empty( $return['designation'] )) {
                                $this->api_retailer_m->get_designation_id($return['designation'], $organizationId);
                                $designationId = $this->api_retailer_m->add_designation_role($organizationId, $return['designation'], $role_list, $retailer_id);
                                $this->retailer_m->add_employee_designation($employeeId, $designationId, $retailer_id);
                                $this->apiresponse['success'] = 1;

                                $this->apiresponse['response'] = array(
                                    'message' => 'success fully registered Employee'
                                );

                                $this->response($this->apiresponse, 200);

                            } else {
                                $this->apiresponse['success'] = 1;
                                $this->apiresponse['response'] = array(
                                    'message' => 'success fully registered Employee'
                                );

                                $this->response($this->apiresponse, 200);
                            }
                        } else {
                            $this->apiresponse['success'] = 0;

                            $this->apiresponse['response'] = array(
                                'message' => 'Role is not available'
                            );

                            $this->response($this->apiresponse, 200);

                        }

                    } else {
                        $this->apiresponse['success'] = 0;

                        $this->apiresponse['response'] = array(
                            'message' => 'error in address registration'
                        );

                        $this->response($this->apiresponse, 200);
                    }

                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in employee registration'
                    );

                    $this->response($this->apiresponse, 200);
                }
            }
        }
    }

