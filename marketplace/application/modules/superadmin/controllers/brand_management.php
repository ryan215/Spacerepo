<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Brand_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Brand';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'brand_index',
				'log_MID'    => '' 
		) );	
		
		$this->data['result'] = $this->category_lib->brand_index();
		$this->superAdminCustomView('admin/brand_managements/brand_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'brand_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->category_lib->brand_ajaxFun($total);
		$this->load->view('admin/brand_managements/ajaxPagView',$this->data);
	}
	
	public function addEditBrand($brandId=0)
	{
		$brandId = id_decrypt($brandId);
		$this->data['result'] 		   = $this->category_lib->brand_addEdit($brandId);		
		$this->data['brandId'] 		   = $brandId;
		$this->data['imagePath'] 	   = base_url().'uploads/brand/thumb50/';
		$this->data['imageUploadPath'] = base_url().'superadmin/brand_management/upload_image/';
		$this->superAdminCustomView('admin/brand_managements/addEditBrand',$this->data);
	}
	
	public function check_brand_name()
	{
		$brand_name = $this->input->post('brand_name');
		$brand_id   = $this->input->post('brand_id');
		$result     = $this->brand_m->check_brand_name($brand_id,$brand_name);
		if(!empty($result))
		{
			$this->form_validation->set_message('check_brand_name','The %s field already exits');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function upload_image()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_image',
				'log_MID'    => '' 
		) );
		
		$image_name = '';
		if(isset($_FILES['myfile']))
		{
			$result = array();
			$this->custom_log->write_log('custom_log','upload file array is '.print_r($_FILES['myfile'],true));
			$extension    = pathinfo($_FILES['myfile']['name'],PATHINFO_EXTENSION);
			$newImageName = ($this->currentTimestamp*2).'.'.$extension;
			
			$config['upload_path']   = './uploads/brand/'; 
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
				$imagepath	  =	'uploads/brand/'.$newImageName ;
				$newimagepath =	'uploads/brand/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/brand/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}
	
	public function change_status($brandID='',$status=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'change_status',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','brand id is '.$brandID);
		
		$brandID = id_decrypt($brandID);
		
		if($brandID)
		{
			if($this->brand_m->change_status($brandID,$status))
			{
				$this->session->set_flashdata('success',$this->lang->line('success_brand_status_change'));
				$this->custom_log->write_log('custom_log',$this->lang->line('success_brand_status_change'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_not_change'));
				$this->custom_log->write_log('custom_log',$this->lang->line('error_not_change'));
			}		
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_not_change'));
			$this->custom_log->write_log('custom_log',$this->lang->line('error_not_change'));
		}
		redirect(base_url().'superadmin/brand_management');
	}
}