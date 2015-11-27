<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Attribute_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Attribute Management';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'attribute_listing',
				'log_MID'    => '' 
		) );	

		$result = $this->product_lib->attributeViewList();
		$this->data['result'] = $result;
		$this->adminCustomView('attribute_managements/attribute_listing',$this->data);
	}
	
	public function attributeListingAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'attributeListingAjaxFun',
				'log_MID'    => '' 
		) );
		
		$result = $this->product_lib->attributeListingAjaxFun($total);
		$this->data['result'] = $result;
		$this->load->view('attribute_managements/attributeListingAjaxFun',$this->data);
	}
	
	public function view_attribute_list($productTypeId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_attribute_list',
				'log_MID'    => '' 
		) );
		
		$productTypeId 				 = id_decrypt($productTypeId);
		$result        				 = $this->product_lib->attributeDetailsView($productTypeId);
		$this->data['result']        = $result;
		$this->data['productTypeId'] = $productTypeId;
		$this->adminCustomView('attribute_managements/view_attribute_list',$this->data);
	}
	
	public function addAttributeList()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditAttributeList',
				'log_MID'    => '' 
		) );
		$result = $this->product_lib->addAttributeList();
		$this->data['result'] = $result;
		$this->adminCustomView('attribute_managements/addAttributeList',$this->data);
	}
	
	public function editAttributeList($productTypeId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'edit_attribute_list',
				'log_MID'    => '' 
		) );
		
		//$productTypeId 		  = id_decrypt($productTypeId);
		$result        		  = $this->product_lib->editAttributeList($productTypeId);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		$this->adminCustomView('attribute_managements/editAttributeList',$this->data);
	}
	
	
}