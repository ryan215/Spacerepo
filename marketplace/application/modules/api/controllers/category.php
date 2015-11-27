<?php defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH.'/libraries/REST_Controller.php';

    class Category extends REST_Controller
    {
        public function __construct()
        {
            parent::__construct ();
            $this->apiresponse['time']=time();
            $this->load->model('organization_category_m');
            $this->load->model('email_m');
            $this->load->model('twillo_m');
            $this->load->helper('api_validation');

            if (is_array($this->response->lang))
            {
                $this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
                $this->lang->load('error', $this->response->lang[0]);
                $this->lang->load('success', $this->response->lang[0]);

            }
            else
            {
                $this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
                $this->lang->load('error', $this->response->lang);
                $this->lang->load('success', $this->response->lang);
                // $this->load->language('application', $this->response->lang);
            }
        }


        public function addCategory_post()
        {
            $rules=	api_add_category();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $organization_id	=	$this->post('organizationId');
                $categoryCode		=	$this->post('categoryCode');
                $categoryDescription=	$this->post('categoryDescription');
                if(isset($_POST['parentCategoryId'])){
                    $parentCategoryId	=	$this->post('parentCategoryId');
                }
                else{
                    $parentCategoryId='';
                }
                $image				=	'';
                if(isset($_FILES['file']) && $_FILES['file']['size']>0)
                {
                    $extension    			= 	pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

                    $newImageName 			= 	(time()*2).'.'.$extension;

                    $config['upload_path'] 	=	'./uploads/category';

                    $config["allowed_types"]= 	"jpg|jpeg|png|gif";

                    $this->load->library('upload', $config);

                    $config['file_name'] 		= $newImageName;

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file'))
                    {
                        $image		=		$config['file_name'];
                    }
                    else
                    {
                        $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'image upload failed'
                        );
                        $this->response($this->apiresponse,200);
                    }
                }
                $lastModifiedBy		=	$this->post('employeeId');
                $rs=$this->organization_category_m->add_category($organization_id,$categoryCode,$categoryDescription,$image,$lastModifiedBy,$parentCategoryId);
                if(!empty($rs))
                {			$this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'successfully added category'
                    );

                    $this->response($this->apiresponse,200);

                }else
                {
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'error in adding category'
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

        public function updateCategory_post()
        {
            $rules=	api_update_category();
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $organization_id	=	$this->post('organizationId');
                $categoryid			=	$this->post('categoryId');
                $categoryCode		=	$this->post('categoryCode');
                $categoryDescription=	$this->post('categoryDescription');
                if(isset($_POST['parentCategoryId'])){
                    $parentCategoryId	=	$this->post('parentCategoryId');
                }
                else{
                    $parentCategoryId='';
                }
                $image				=	'';

                $lastModifiedBy		=	$this->post('employeeId');
                if(isset($_FILES['file']) && $_FILES['file']['size']>0)
                {
                    $extension    			= 	pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

                    $newImageName 			= 	(time()*2).'.'.$extension;

                    $config['upload_path'] 	=	'./uploads/category';

                    $config["allowed_types"]= 	"jpg|jpeg|png|gif";

                    $this->load->library('upload', $config);

                    $config['file_name'] 		= $newImageName;

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file'))
                    {
                        $image		=		$config['file_name'];
                    }
                    else
                    {
                        $this->apiresponse['success']=0;

                        $this->apiresponse['response'] =array(
                            'message' => 'image upload failed'
                        );
                        $this->response($this->apiresponse,200);
                    }
                }
                $rs=$this->organization_category_m->update_category($organization_id,$categoryid,$categoryCode,$categoryDescription,$image,$lastModifiedBy,$parentCategoryId);
                if(!empty($rs))
                {			$this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'successfully updated category'
                    );

                    $this->response($this->apiresponse,200);

                }else
                {
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'error in updating category'
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
        public function categoryListing_post()
        {
            $rules=required_organization_id();
            $rules[]=	array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required'
            );
            $rules[]=	array(
                'field' => 'count',
                'label' => 'count',
                'rules' => 'trim|required'
            );
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $limit=$this->post('count');
                $set=$this->post('set');
                $set--;
                $start=$set*$limit;
                $set++;
                $start1=$set*$limit;
                $organizationId=$this->post('organizationId');
                if(isset($_POST['query']))
                {
                    $query=$this->post('query');
                    $where='organization_category.categoryCode like "%'.$query.'%"';
                }
                else
                {
                    $where='';
                }
                $category_array=$this->organization_category_m->category_listing($organizationId,$start,$limit,$where);

                $more=$this->organization_category_m->category_listing($organizationId,$start1,$limit,$where);
                if(!empty($more))
                {
                    $more=TRUE;

                }else
                {
                    $more=FALSE;
                }
                if(!empty($category_array))
                {
                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'successfully listed category',
                        'data'	 => $category_array,
                        'more'	=>	$more,

                    );

                    $this->response($this->apiresponse,200);
                }
                else{
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'No result Found'
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
        public function subCategoryListing_post()
        {
            $rules=required_organization_id();
            $rules[]=	array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required'
            );

            $rules[]=	array(
                'field' => 'count',
                'label' => 'Count',
                'rules' => 'trim|required'
            );

            $this->form_validation->set_rules($rules);
            if($this->form_validation->run())
            {
                $organizationId=$this->post('organizationId');
                $limit=$this->post('count');
                $set=$this->post('set');
                $set=$set-1;
                $start=$set*$limit;
                $set++;
                $start1=$set*$limit;
                //$organizationId=$this->post('organizationId');
                if(isset($_POST['categoryId']))
                {
                    $categoryId=$this->post('categoryId');
                    $where ='organization_category.parentCategoryId = '.$categoryId;
                    if(isset($_POST['query']))
                    {
                        $query=$this->post('query');
                        $where='and organization_category.categoryCode like "%'.$query.'%"';
                    }

                }
                else
                {
                    $where='';
                    if(isset($_POST['query']))
                    {
                        $query=$this->post('query');
                        $where .='organization_category.categoryCode like "%'.$query.'%"';
                    }

                }
                $category_array=$this->organization_category_m->sub_category_listing($organizationId,$start,$limit,$where);
                $more=$this->organization_category_m->sub_category_listing($organizationId,$start1,$limit,$where);
                if(!empty($more))
                {
                    $more=TRUE;

                }else
                {
                    $more=FALSE;
                }
                //$category_array=$this->organization_category_m->sub_category_listing($organizationId);
                if(!empty($category_array))
                {
                    $this->apiresponse['success']=1;

                    $this->apiresponse['response'] =array(
                        'message' => 'successfully listed category',
                        'data'	 => $category_array	,
                        'more'	=>	$more
                    );

                    $this->response($this->apiresponse,200);
                }
                else{
                    $this->apiresponse['success']=0;

                    $this->apiresponse['response'] =array(
                        'message' => 'No result Found'
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








    }

