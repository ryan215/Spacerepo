<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Employee_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->model('employee_m');

		$this->data['title'] = 'Employee Managements';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'employee_management_index',
				'log_MID'    => '' 
		) );				

		/*$this->data['result'] 		  = $this->product_lib->spacepointe_product_list(); 
		$this->data['organizationId'] = $this->session->userdata('organizationId');
	echo "<pre>";	print_r($this->data['result']); exit;*/
		$this->retailerCustomView('employee_managements/employee_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$organizationId = $this->session->userdata('organizationId');
		//echo $organizationId;exit;
			$perPage	     = $this->input->post('sel_no_entry');
					$employee_name	     = $this->input->post('employeeName');
					$where='';
					if(!empty($employee_name))
					{
						$where = "CONCAT(employee.firstName,' ',employee.lastName) LIKE '%".$employee_name."%'";
					}
					
			if(empty($perPage))
		{
			$perPage = 10;
		}
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/employee_management/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$this->data['employee_list']=$this->employee_m->ajax_employee_list($page,$pagConfig['per_page'],$organizationId,$where);
		
		$this->data['page']=$page;
		$this->data['links']=$this->ajax_pagination->create_links();
		$this->load->view('employee_managements/ajaxPagView',$this->data);
		
	}
	
	public function addEmployee()
	{	
		$this->data['result'] 		   = $this->profile_lib->employee_sign_up();		
		$this->data['imagePath'] 	   = base_url().'uploads/employee/thumb50/';
		$this->data['imageUploadPath'] = base_url().$this->session->userdata('userType').'/employee_management/upload_image/';
		$this->retailerCustomView('employee_managements/addEmployee',$this->data);
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
			
			$config['upload_path']   = './uploads/employee/'; 
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
				$imagepath	  =	'uploads/employee/'.$newImageName ;
				$newimagepath =	'uploads/employee/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/employee/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}	
	
	public function check_businessPhone()
	{
		$countryCode   = '+234';
		$businessPhone = $this->input->post('businessPhone'); 
		$details       = $this->user_m->check_businessPhone($businessPhone,$countryCode);
		
		if(!empty($details))
		{
			$this->form_validation->set_message('check_businessPhone','The %s field already exits');
			return true;
		}
		else
		{
			return false;
		}
	}
}
