<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Employee_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Shipping';
	}	
	
	public function index()
	{	
	$this->shippingVendorCustomView('employee/vendor_employee_list',$this->data);
	}
	public function vendor_employee_ajax_fun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_ajaxFun',
				'log_MID'    => '' 
		) );
		$organizationId=$this->session->userdata('organizationId');
		
		$this->data['result'] = $this->profile_lib->shipping_vendor_employee_ajaxFun($organizationId);
		//echo "<pre>"; print_r($this->data['result']);
		$this->load->view('employee/vendor_employee_ajaxfun',$this->data);
	}
	public function addVendorEmployee()
	{
			$this->data['title'] 		   = 'Add Shipping Vendor';
		$organizationId=$this->session->userdata('organizationId');
		$result 					   = $this->profile_lib->shipping_vendore_employee_sign_up($organizationId);
		$this->data['result'] 		   = $result;		
		$this->data['imagePath'] 	   = base_url().'uploads/shipping/thumb50/';
		$this->data['imageUploadPath'] = base_url().'admin/vendor_management/upload_image/';
		$this->shippingVendorCustomView('employee/add_vendor_employee',$this->data);
	}
	public function user_detail($organizationId)
	{
		
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	

		$organizationId 		      = id_decrypt($organizationId);
		$this->data['result']         = $this->profile_lib->shipping_vendor_employeeDetails($organizationId);
		//print_r($this->data['result']);
		$this->data['organizationId'] = $organizationId;
		$this->shippingVendorCustomView('employee/user_details',$this->data);
	}
	public function editVendor($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'editVendor',
				'log_MID'    => '' 
		) );
		
		$organizationId 			   = id_decrypt($organizationId);
		$this->data['result'] 		   = $this->profile_lib->shipping_vendor_employee_edit($organizationId);
		$this->data['imagePath'] 	   = base_url().'uploads/shipping/thumb50/';
		$this->data['imageUploadPath'] = base_url().'admin/vendor_management/upload_image/';
		$this->data['organizationId']  = $organizationId;
		//echo "<pre>"; print_r($this->data['result']); exit;
		$this->shippingVendorCustomView('employee/editVendoremployee',$this->data);		
	}
	
}