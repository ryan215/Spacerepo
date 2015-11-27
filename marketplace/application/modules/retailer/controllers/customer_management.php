<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Customer_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->library('customer_lib');

		$this->data['title'] = 'Product Managements';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );				

		$this->data['result'] 		  = $this->product_lib->spacepointe_product_list(); 
		$this->data['organizationId'] = $this->session->userdata('organizationId');
	//echo "<pre>";	print_r($this->data['result']); exit;
		$this->retailerCustomView('customer/customer_list',$this->data);
	}
	public function ajax_customer_list()
	{
		
	}
	public function add_customer()
	{
		$this->data['result']=$this->customer_lib->customer_registration();
		$this->data['imagePath'] 	   = base_url().'uploads/customer/thumb50/';
		$this->data['imageUploadPath'] = base_url().$this->session->userdata('userType').'/customer_management/upload_image/';
	$this->retailerCustomView('customer/add_customer',$this->data);
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
			
			$config['upload_path']   = './uploads/customer/'; 
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
				$imagepath	  =	'uploads/customer/'.$newImageName ;
				$newimagepath =	'uploads/customer/thumb50';
				if(!file_exists($newimagepath)) 
				{
					mkdir($newimagepath, 0777, true);
					chmod($newimagepath,0777);
				} 
				$thumb50='uploads/customer/thumb50/'.$newImageName;
				$this->common_model->resize($imagepath,$thumb50,$newHt=200,$newWd=200);
			}
			$result['newImageName'] = $newImageName;
			echo $newImageName;
		}	
	}	
	

	
}
