<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Marketing extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->model('market_management_m');
	}	
	
	public function slider_list()
	{
		$this->data['title'] = 'Center Slider List';
		$this->data['total'] = $this->market_management_m->total_center_slider(); 
		$this->superAdminCustomView('admin/market/slider_list',$this->data);	
	}
	
	public function centerAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cse_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/marketing/centerAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['list']  = $this->market_management_m->center_slider_list($page,$pagConfig['per_page'],$where);
		$this->load->view('admin/market/centerAjaxFun',$this->data);
	}
	
	public function addEditSliderList($slider_id='')
	{
		$this->data['title'] = 'Add|Edit Slider List';
		$image_name = '';
		$slider_link = '';
		$slider_id   = id_decrypt($slider_id);
		
		if(!empty($slider_id))
		{	
			$details = $this->market_management_m->center_slider_details($slider_id);
			//echo "<pre>"; print_r($details); exit;
			if(!empty($details))
			{
				$image_name = $details->imageName;
				$slider_link = $details->url;
				$slider_id   = $details->homePagePromotionId;
			}
		}
		
		if($_POST)
		{	
			$rules 		  = slider_rules();
			//$slider_id    = $this->input->post('slider_id');
			$image_name   = $this->input->post('slider_image');
			$slider_link  = $this->input->post('slider_link');
		
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				if($slider_id)
				{
					if($this->market_management_m->update_slider($slider_id,$image_name,$slider_link))
					{
						$this->session->set_flashdata('success','successfully update slider ');
					}
					else
					{
						$this->session->set_flashdata('error','not  update slider ');
					}
				}
				else
				{
					$slider_id = $this->market_management_m->add_slider($image_name,$slider_link,'center');
					if($slider_id)
					{
						$this->session->set_flashdata('success','successfully saved slider ');
					}
				}
				redirect(base_url().$this->session->userdata('userType').'/marketing/slider_list');
			}
		}
		
		$this->data['imagePath'] 	   = base_url().'uploads/advertise/';
		$this->data['imageUploadPath'] = base_url().$this->session->userdata('userType').'/marketing/main_sliderupload/';
		$this->data['image_name']	   = $image_name;
		$this->data['slider_link']	   = $slider_link;
		
		$this->superAdminCustomView('admin/market/addEditSliderList',$this->data);	
	}
	
	public function deleteCenterImage($homePagePromotionId='')
	{
		$homePagePromotionId = id_decrypt($homePagePromotionId);
		if($this->market_management_m->delete_center_slider($homePagePromotionId))
		{
			$this->session->set_flashdata('success',$this->lang->line('success_delete_image'));
			$this->custom_log->write_log('custom_log',$this->lang->line('success_delete_image'));
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_delete_image'));
			$this->custom_log->write_log('custom_log',$this->lang->line('error_delete_image'));
		}
		redirect(base_url().$this->session->userdata('userType').'/marketing/slider_list'); 
	}
	
	public function left_section()
	{
		$this->data['title'] = 'Left Slider List';
		$this->data['total'] = $this->market_management_m->total_left_slider(); 
		$this->superAdminCustomView('admin/market/left_section',$this->data);	
	}
	
	public function leftAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cse_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/marketing/leftAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['list']  = $this->market_management_m->left_section_list($page,$pagConfig['per_page'],$where);
		$this->load->view('admin/market/leftAjaxFun',$this->data);
	}
	
	public function addLeftSlider()
	{
		$this->data['title'] = 'Add Left Slider List';
		$result = array();
		$result['left_image1'] = '';
		$result['left_image2'] = '';
		$result['left_link1'] = '';
		$result['left_link2'] = '';
		$formSubmit = 1;
		if($_POST)
		{
			$formSubmit = 0;	
			$rules 		  		   = left_slider_rules();
			$result['left_image1'] = $this->input->post('left_image');
			$result['left_image2'] = $this->input->post('left_image2');
			$result['left_link1']  = $this->input->post('urllink1');
			$result['left_link2']  = $this->input->post('urllink2');

			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$this->market_management_m->deactivate_left_slider();
				$slider_id = $this->market_management_m->add_slider($result['left_image1'],$result['left_link1'],'left');						
				$slider_id = $this->market_management_m->add_slider($result['left_image2'],$result['left_link2'],'left');
				if($slider_id)
				{
					$this->session->set_flashdata('success','successfully added slider ');
				}
				else
				{
					$this->session->set_flashdata('error','slider not add');
				}
				redirect(base_url().$this->session->userdata('userType').'/marketing/left_section');
			}
		}
		
		if($formSubmit)
		{
			$leftRS = $this->market_management_m->left_section_list();
			if(!empty($leftRS))
			{
				$result['left_image1'] = $leftRS[0]->imageName;
				$result['left_image2'] = $leftRS[1]->imageName;
				$result['left_link1'] = $leftRS[0]->url;
				$result['left_link2'] = $leftRS[1]->url;
			}
		}
		
		
		$this->data['result'] = $result;		
		$this->superAdminCustomView('admin/market/addLeftSlider',$this->data);	
	}
	
	public function deleteLeftImage($homePagePromotionId='')
	{
		$homePagePromotionId = id_decrypt($homePagePromotionId);
		if($this->market_management_m->delete_left_slider($homePagePromotionId))
		{
			$this->session->set_flashdata('success',$this->lang->line('success_delete_image'));
			$this->custom_log->write_log('custom_log',$this->lang->line('success_delete_image'));
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_delete_image'));
			$this->custom_log->write_log('custom_log',$this->lang->line('error_delete_image'));
		}
		redirect(base_url().$this->session->userdata('userType').'/marketing/left_section'); 
	}
	
	public function right_section()
	{
		$this->data['title'] = 'Left Slider List';
		$this->data['total'] = $this->market_management_m->total_right_slider(); 
		$this->superAdminCustomView('admin/market/right_section',$this->data);	
	}
		
	public function rightAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cse_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/marketing/rightAjaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['list']  = $this->market_management_m->right_section_list($page,$pagConfig['per_page'],$where);
		$this->load->view('admin/market/rightAjaxFun',$this->data);
	}
	
	public function addRightSlider()
	{
		$this->data['title'] = 'Add Left Slider List';
		$result = array();
		$result['left_image1'] = '';
		$result['left_image2'] = '';
		$result['left_image3'] = '';
		$result['left_link1'] = '';
		$result['left_link2'] = '';
		$result['left_link3'] = '';
		$formSubmit = 1;
		if($_POST)
		{	
			$formSubmit = 0;
			$rules 		  		   = right_slider_rules();
			$result['left_image1'] = $this->input->post('left_image');
			$result['left_image2'] = $this->input->post('left_image2');
			$result['left_image3'] = $this->input->post('left_image3');
			$result['left_link1']  = $this->input->post('urllink1');
			$result['left_link2']  = $this->input->post('urllink2');
			$result['left_link3']  = $this->input->post('urllink3');

			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$this->market_management_m->deactivate_right_slider();
				$slider_id = $this->market_management_m->add_slider($result['left_image1'],$result['left_link1'],'right');					
				$slider_id = $this->market_management_m->add_slider($result['left_image2'],$result['left_link2'],'right');
				$slider_id = $this->market_management_m->add_slider($result['left_image3'],$result['left_link3'],'right');
				if($slider_id)
				{
					$this->session->set_flashdata('success','successfully added slider ');
				}
				else
				{
					$this->session->set_flashdata('error','slider not add');
				}
				redirect(base_url().$this->session->userdata('userType').'/marketing/right_section');
			}
		}
		
		if($formSubmit)
		{
			$rightRS = $this->market_management_m->right_section_list();
			if(!empty($rightRS))
			{
				$result['left_image1'] = $rightRS[0]->imageName;
				$result['left_image2'] = $rightRS[1]->imageName;
				$result['left_image3'] = $rightRS[2]->imageName;
				$result['left_link1'] = $rightRS[0]->url;
				$result['left_link2'] = $rightRS[1]->url;
				$result['left_link3'] = $rightRS[2]->url;
			}
		}
		
		$this->data['result'] = $result;		
		$this->superAdminCustomView('admin/market/addRightSlider',$this->data);	
	}
	
	public function add_slider(){
		if(isset($_POST) && !empty($_POST)){
		$rules=array(
						array(
							'field' => 'image_title',
							'label' => 'Image Title',
							'rules' => 'trim|required'
							),
						array(
							'field' => 'slider_image',
							'label' => 'slider Image',
							'rules' => 'trim|required'
							),
						array(
							'field' => 'slider_link',
							'label' => 'slider link',
							'rules' => 'trim'
							),
						array(
							'field' => 'slider_text',
							'label' => 'slider  text',
							'rules' => 'trim'
							),
							array(
							'field' => 'button_link',
							'label' => 'Button link',
							'rules' => 'trim'
							),
						array(
							'field' => 'button_text',
							'label' => 'Button  text',
							'rules' => 'trim'
							),
						);
		
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
					$slider_image_array=	array(	'table'	=>	'slider',
													'data'	=>	array(
																'slider_title'		 =>	$this->input->post('image_title'),
																'slider_image'		 =>	$this->input->post('slider_image'),
																'slider_link'		 =>	$this->input->post('slider_link'),
																'slider_text'		 =>	$this->input->post('slider_text'),
 																'button_text'		 =>	$this->input->post('button_text'),
																'button_link'		 =>	$this->input->post('button_link'),		
																'last_modified_date' => time()
																
																),
												);
				$this->custom_log->write_log('custom_log',print_r($slider_image_array,true));
				$slider_id=	$this->common_model->customInsert($slider_image_array);
				if(!empty($slider_id)){
							$this->session->set_flashdata('success','successfully saved slider ');
							redirect(base_url().$this->session->userdata('userType').'/marketing/slider_list');
				
				}
			}
		
		}
		$this->data['title']='Add slider';
		$this->adminCustomView('market/add_slider',$this->data);	
	}
	
	
	public function add_edit_form($sliderID)
	{		
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_edit_form',
				'log_MID'    => '' 
		) );
		$result = array();
		$slider_image = '';
		$slider_link  = '';
				
		if($sliderID)
		{
			$res = $this->market_management_m->slider_details($sliderID);
			if(!empty($res))
			{
				$slider_image = $res->slider_image;
				$slider_link  = $res->slider_link;
			}
		}
		$this->data['slider_image'] = $slider_image;
		$this->data['slider_link']  = $slider_link;
		$result = array('slider_image' => $slider_image,'slider_link' => $slider_link);
		echo json_encode($result);
		//$this->data['sliderID']     = $sliderID;
		//echo $this->load->view('market/add_edit_form',$this->data);
	}
	
	public function delete_slider(){
		$slider_id=$_POST['slider_id'];
		
		$delete_slider=array(
								'table'	=>	'slider',
								'where'	=>	array(
												'slider_id'	=>	$slider_id
												)
												);
			$rs=$this->common_model->customDelete($delete_slider);
			if(!empty($rs)){
				
				$this->session->set_flashdata('success','successfully deleted slider Image');
				
				}else{
					
					$this->session->set_flashdata('error','There is some problem in deleting slider');
					
					}
				
		
		
		
		}
	public function upload_image($section=''){
	
	
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload images',
				'log_MID'    => '' 
		) );
		
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/advertise/'; 
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
				$imagepath	  =	'uploads/advertise/'.$newImageName ;
				$newimagepath =	'uploads/advertise/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777); 
				} 
				$thumb50='uploads/advertise/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=50,$newWd=50);
				if(!empty($section)){
					$sectionimage='uploads/advertise/section/'.$newImageName;
					if($section=="left"){
						$this->common_model->resize($imagepath,$sectionimage,$newHt=276,$newWd=300);
						
						}elseif($section=='right'){
								$this->common_model->resize($imagepath,$sectionimage,$newHt=184,$newWd=300);
							}
					
					}
				
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	
	
	}
	public function main_sliderupload(){
		
	
	
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload images',
				'log_MID'    => '' 
		) );
		
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/advertise/'; 
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
				$imagepath	  =	'uploads/advertise/'.$newImageName ;
				$newimagepath =	'uploads/advertise/sliderimage';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777); 
				} 
				$sliderimage='uploads/advertise/sliderimage/'.$newImageName;
				$thumb50	='uploads/advertise/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$sliderimage,$newHt=459,$newWd=998);
				$this->common_model->resize($imagepath,$thumb50,$newHt=50,$newWd=50);
				
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	
	
	
		
		}
}