<?php if(!defined ('BASEPATH'))
    exit ( 'No Direct Access Allowed' );

    class Category_Mgmt extends MY_Controller
    {

        public function __construct()
        {

            parent::__construct ();

            // logger
            $this->session->set_userdata (array(
                'log_FILE' => __FILE__
            ));
            $this->load->model ('organization_category_m');
            $this->data['title'] = 'Pointepay Category';
        }

        public function category_listing($parentCategoryId=0)
        {
            $this->session->set_userdata (array(
                'log_MODULE' => 'category_management',
                'log_MID'    => ''
            ));
            $this->data['parentCatId']=id_decrypt($parentCategoryId);

            $this->retailerCustomView ('pointepay/category_mgmt/category_list', $this->data);
        }

        public function ajaxFun($total = 0)
        {
            $return = array();
            $per_page = $this->input->post ('sel_no_entry');
            $where = '';
            $search = $this->input->post ('search');
            $organizationId = $this->session->userdata ('organizationId');
            $parentCategoryId=$this->input->post('parentCatId');
            $parentCategoryId=id_decrypt($parentCategoryId);

            if(empty( $per_page )) {
                $per_page = 10;
            }

            if(!empty( $search )) {
                $where = "categoryCode LIKE '" . $search . "%' ";
                $total = $this->organization_category_m->total_category_listing ($organizationId, $where);
            }

            $pagConfig = array(
                'base_url'    => base_url () . $this->session->userdata ('userType') . '/category_Mgmt/ajaxFun/',
                'total_rows'  => $total,
                'per_page'    => $per_page,
                'uri_segment' => 4,
                'num_links'   => 4
            );

            $this->ajax_pagination->initialize ($pagConfig);

            $page = ( $this->uri->segment (4) ) ? $this->uri->segment (4) : 0;
            $limit = ( $page > 0 ) ? $page * $pagConfig['per_page'] : $pagConfig['per_page'];

            $return['segment_list'] = $this->organization_category_m->category_listing ($organizationId, $page, $pagConfig['per_page'], $where,$parentCategoryId);
            $return["links"] = $this->ajax_pagination->create_links ();
            $return['page'] = $page;
            $this->data['result']=$return;
            $this->load->view ('pointepay/category_mgmt/ajax_page', $this->data);
        }

        //	This function common for all
        public function addEditCategory($parentCategoryId=0,$categoryId=0)
        {
            $organizationId=$this->session->userdata('organizationId');
            $categoryId=id_decrypt($categoryId);
            $parentCategoryId=id_decrypt($parentCategoryId);
            $category_detail=$this->organization_category_m->category_detail($categoryId,$organizationId);
            //print_r($category_detail);
            if(!empty($category_detail)) {
                $categoryCode = $category_detail->categoryCode;
                $categoryDescription=$category_detail->categoryDescription;
                $image=$category_detail->imageName;

            }
            else
            {
                $categoryCode='';
                $categoryDescription='';
                $image='';

            }
            if(isset($_POST) && !empty($_POST))
            {
                $organization_id	=	$this->session->userdata('organizationId');
                $categoryCode		=	$this->input->post('categoryCode');
                $categoryDescription=	$this->input->post('categoryDescription');

                    $parentCategoryId	=	$parentCategoryId;


                $image=$this->input->post('categoryimage');
                $lastModifiedBy=$this->session->userdata('userId');
                if(!empty($category_detail)){
                   $rs= $this->organization_category_m->update_category($organization_id,$categoryId,$categoryCode,$categoryDescription,$image,$lastModifiedBy,$parentCategoryId);
                }else{
                    $rs=$this->organization_category_m->add_category($organization_id,$categoryCode,$categoryDescription,$image,$lastModifiedBy,$parentCategoryId);
                }

             redirect(base_url().'retailer/category_Mgmt/category_listing/'.id_encrypt($parentCategoryId));
            }
            $this->data['categoryCode']=$categoryCode;
            $this->data['categoryDescription']=$categoryDescription;
            $this->data['imageName']=   $image;
            $this->data['parentCatId']=$parentCategoryId;
            $this->data['imagePath']=base_url().'uploads/category/';
            $this->data['imageUploadPath']=base_url().'retailer/category_Mgmt/upload_category_image';
            $this->data['catId']=$categoryId;
            $this->data['parentCatId']=$parentCategoryId;
            $this->data['categoryName']=$categoryCode;
            $this->retailerCustomView('pointepay/category_Mgmt/addEditcategory',$this->data);


        }

        public function upload_category_image()
        {

            $this->session->set_userdata(array(
                'log_MODULE' => 'upload_admin_image',
                'log_MID'    => ''
            ) );

            $image_name = '';
            if(isset($_FILES['myfile']))
            {
                $result = array();
                $this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
                $extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
                $newImageName = ($this->currentTimestamp*2).'.'.$extension;

                $config['upload_path']   = './uploads/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name']     = $newImageName;
                $image_name              = $newImageName;

                $this->custom_log->write_log('custom_log', 'upload file array is '.print_r($config,true));
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('myfile'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    $this->custom_log->write_log('custom_log','file upload error is '.$this->upload->display_errors());
                }
                else
                {
                    $imagepath	  =	'uploads/categroy/'.$newImageName ;
                    $newimagepath =	'uploads/category/thumb50';
                    if(!file_exists($newimagepath))
                    {
                        mkdir($newimagepath, 0777, true);
                        chmod($newimagepath,0777);
                    }
                    $thumb50='uploads/category/thumb50/'.$newImageName;
                    $this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
                }
                $result['newImageName'] = $newImageName;
                echo $newImageName;
            }
        }
    }