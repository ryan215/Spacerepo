<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Cse_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Customer Support Executive';	
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cse_management_index',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->profile_lib->cse_index();
		//echo $this->db->last_query(); exit;
		$this->adminCustomView('cse_managements/cse_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cse_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->profile_lib->cse_ajaxFun($total);
		
		$this->load->view('cse_managements/ajaxPagView',$this->data);
	}
	
	public function addCse()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addCse',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] 		   = $this->profile_lib->cse_sign_up();		
		$this->data['imagePath'] 	   = base_url().'uploads/cse/thumb50/';
		$this->data['imageUploadPath'] = base_url().'admin/cse_management/upload_cse_image/';
		$this->adminCustomView('cse_managements/addCse',$this->data);
	}
	
	public function editCse($employeeId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editCse',
				'log_MID'    => '' 
		));	
		
		$employeeId = id_decrypt($employeeId);
		$this->custom_log->write_log('custom_log','employee id is '.$employeeId);
		
		$this->data['result'] 		   = $this->profile_lib->cse_edit($employeeId);		
		$this->data['imagePath'] 	   = base_url().'uploads/cse/thumb50/';
		$this->data['imageUploadPath'] = base_url().'admin/cse_management/upload_cse_image/';
	//echo "<pre>";	print_r($this->data['result']); exit;
		$this->adminCustomView('cse_managements/editCse',$this->data);
	}
	
	public function user_detail($employeeId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	
		
		$employeeId 			  = id_decrypt($employeeId);
		$this->data['result']     = $this->profile_lib->cse_userDetails($employeeId);
		$this->data['employeeId'] = $employeeId;
		$this->adminCustomView('cse_managements/user_details',$this->data);	
	}
	
	public function unblock_block($employeeId,$status)
	{
		$employeeId = id_decrypt($employeeId);
		if(!empty($employeeId))
		{
			$return = $this->profile_lib->block_unblock($employeeId,$status);
			if($return)
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
		redirect(base_url().'admin/cse_management/user_detail/'.id_encrypt($employeeId));
	}
		
	public function upload_cse_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_cse_image',
				'log_MID'    => '' 
		) );
		
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/cse/'; 
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
				$imagepath	  =	'uploads/cse/'.$newImageName ;
				$newimagepath =	'uploads/cse/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/cse/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}
}