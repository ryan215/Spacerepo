<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Category_commission_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Category Commission Management';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Category_commission_management',
				'log_MID'    => '' 
		) );			
		
		$result      		  = $this->category_lib->category_commission_list();
		$this->data['result'] = $result;
		$this->superAdminCustomView('category_commission_managements/category_commission_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$result 			  = $this->category_lib->category_commission_ajax_list($total);
		$this->data['result'] = $result;
		$this->load->view('category_commission_managements/category_commission_ajax_list',$this->data);
	}
	
	public function edit_commission($catId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_commission',
				'log_MID'    => '' 
		) );
		
		$catId  = id_decrypt($catId);
		$result	= $this->category_lib->edit_category_commission($catId);
		//echo "<pre>"; print_r($result); exit;
		$this->data['result'] = $result;
		$this->data['catId']  = $catId;
		$this->superAdminCustomView('category_commission_managements/edit_commission',$this->data);
	}
}