<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Shipping_matrix extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Shipping Matrix';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_matrix',
				'log_MID'    => '' 
		) );	
		
		$this->adminCustomView('shipping_matrix/shipping_matrix1',$this->data);
	}
	
	public function index1()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_matrix',
				'log_MID'    => '' 
		) );	
		
		$this->adminCustomView('shipping_matrix/shipping_matrix2',$this->data);
	}
	public function index2()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'shipping_matrix',
				'log_MID'    => '' 
		) );	
		
		$this->adminCustomView('shipping_matrix/shipping_matrix3',$this->data);
	}
}