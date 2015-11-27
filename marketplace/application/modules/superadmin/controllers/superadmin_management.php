<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Superadmin_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct (); 	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Superadmin Management';	
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'superadmin_management',
				'log_MID'    => '' 
		) );
		
		$this->data['title']   		   = 'Superadmin Management';
		$this->data['imagePath'] 	   = base_url().'uploads/superadmin/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/superadmin_management/upload_image/';
		$dataArr               		   = $this->profile_lib->superadmin_sign_up();		
		$this->data['total']      	   = $this->user_m->total_superadmin_user();
		$this->data['dataArr'] 	       = $dataArr; 		
		$this->superAdminCustomView('superadmin_managements/superadmin_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'staff_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$where  	= '';
		$search 	= $this->input->post('search');
		$sorting	= $this->input->post('sorting');
		$per_page	= $this->input->post('sel_no_entry');
		
		if(!empty($search))
		{
			if(empty($sorting))
			{
				$where = "(
								CONCAT(profile.first_name,' ',profile.last_name) LIKE '%".$search."%' 							
							OR
								users.email LIKE '%".$search."%'
							)";
			}
			elseif($sorting=='name')
			{
				$where ="(CONCAT(profile.first_name,' ',profile.last_name) LIKE '%".$search."%')";
			}
			elseif($sorting=='email')
			{
				$where ="users.email LIKE '%".$search."%'";
			}
			$total = $this->user_m->total_superadmin_user($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'superadmin/superadmin_management/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		
		$this->data['user_list'] = $this->user_m->superadmin_user_list($page,$pagConfig['per_page'],$where);
		$this->load->view('superadmin_managements/ajaxPagView',$this->data);
	}
	
	public function unblock_block($user_id,$status)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'unblock_block',
				'log_MID'    => '' 
		) );
		
		$user_id   = id_decrypt($user_id);
		$page_name = $this->lang->line('staff_management');
		if(!empty($user_id))
		{
			if($this->user_m->block_unblock_user($status,$user_id))
			{
				if(!$status)
				{
					$this->session->set_flashdata('success',$this->lang->line('success_block_user'));
				}
				else
				{
					$this->session->set_flashdata('success',$this->lang->line('success_unblock_user'));
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_not_update'));
			}			
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_invalie_id'));
		}
		redirect(base_url().'superadmin/superadmin_management/user_detail/'.id_encrypt($user_id));
	}
		
	public function user_detail($user_id)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	
		
		$user_id    = id_decrypt($user_id);
		$show_modal = 0;
		$dataArr     = array();
		$dataArr['image_name'] 	 = '';
		$dataArr['first_name'] 	 = '';
		$dataArr['last_name']  	 = '';
		$dataArr['email'] 	  	 = '';			
		$dataArr['gender'] 	  	 = '';
		$dataArr['date']    	 = '';
		$dataArr['month'] 	  	 = '';
		$dataArr['comment']    	 = '';
		$dataArr['country_id'] 	 = 0;
		$dataArr['state_id']   	 = 0;
		$dataArr['country_name'] = '';
		$dataArr['state_name']   = '';
			
		$users_details = $this->user_m->superadmin_user_details($user_id);
		$this->custom_log->write_log('custom_log','user details is '.print_r($users_details,true));
		
		if(!empty($users_details))
		{
			$birth_date   			 = explode("-",$users_details->birth_date);
			$dataArr['image_name'] 	 = $users_details->image;
			$dataArr['first_name'] 	 = $users_details->first_name;
			$dataArr['last_name'] 	 = $users_details->last_name;
			$dataArr['gender']     	 = $users_details->gender;
			$dataArr['date']       	 = $birth_date[2];
			$dataArr['month']      	 = $birth_date[1];
			$dataArr['comment']   	 = $users_details->comment;
			$dataArr['block_status'] = $users_details->block_status;
			$dataArr['email']        = $users_details->email;
			$dataArr['country_id']   = $users_details->country_id;
			$dataArr['state_id']     = $users_details->state_id;
			$dataArr['country_name'] = $users_details->country_name;
			$dataArr['state_name']   = $users_details->state_name;
		}
		
		if($_POST)
		{
			$show_modal = 1;
			$this->custom_log->write_log('custom_log', 'Form submit '.print_r($_POST,true));
			
			$dataArr['image_name'] 	 = $this->input->post('image_name');
			$dataArr['first_name'] 	 = $this->input->post('first_name');
			$dataArr['last_name'] 	 = $this->input->post('last_name');
			$dataArr['gender']     	 = $this->input->post('gender');
			$dataArr['date']       	 = $this->input->post('date');
			$dataArr['month']      	 = $this->input->post('month');
			$dataArr['comment']   	 = $this->input->post('comment');
			//$dataArr['country_id']   = $this->input->post('country_id');
			//$dataArr['state_id']     = $this->input->post('state_id');
			$rules = superadmin_update_rules();			
			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run())
			{	
				$dataArr['birth_date'] = '0000-'.$dataArr['month'].'-'.$dataArr['date'];
				$this->user_m->superadmin_update_profile($user_id,$dataArr);
				
				$this->session->set_flashdata('success',$this->lang->line('success_update_user_details'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_update_user_details'));
				redirect(base_url().'superadmin/superadmin_management/user_detail/'.id_encrypt($user_id));
			}
		}
		
		$this->data['title']           = 'User Detail';	
		$this->data['show_modal'] 	   = $show_modal;
		$this->data['user_id']         = $user_id;
		$this->data['imagePath'] 	   = base_url().'uploads/superadmin/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/superadmin_management/upload_image/';
		$this->data['dataArr'] 		   = $dataArr;
		$this->superAdminCustomView('superadmin_managements/user_details',$this->data);	
	}
		
	public function upload_image()
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
			
			$config['upload_path']   = './uploads/superadmin/'; 
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
				$imagepath	  =	'uploads/superadmin/'.$newImageName ;
				$newimagepath =	'uploads/superadmin/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/superadmin/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}
}