<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Category_commission_management2 extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Pointeforce Commission Management';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Category_commission_management2',
				'log_MID'    => '' 
		) );			
		$this->superAdminCustomView('category_commission_managements/spacepointe_commission_list2',$this->data);
	}
	
	public function ajaxFun()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$result 			  = $this->category_lib->spacepointe_commission2_ajax_list();
		$this->data['result'] = $result;
		$this->load->view('category_commission_managements/spacepointe_commission_ajax_list2',$this->data);
	}
	
	public function edit_commission($catId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_commission',
				'log_MID'    => '' 
		) );
		
		$catId  = id_decrypt($catId);
		$result	= $this->category_lib->edit_spacepointe_commission2($catId);
		
		$this->data['result'] = $result;
		$this->data['catId']  = $catId;
		$this->superAdminCustomView('category_commission_managements/spacepointe_commission_edit2',$this->data);
	}
}