<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class News_management extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'News Managment';
		$this->load->library('customer_lib');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_index',
				'log_MID'    => '' 
		));	
		
		$this->data['result'] = $this->customer_lib->news_letter_index();
		$this->superAdminCustomView('admin/news_managements/news_letter_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_management_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->customer_lib->news_letter_ajaxFun($total);
		$this->load->view('admin/news_managements/ajaxPagView',$this->data);
	}
		
	public function user_detail($newsletterId)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'user_detail',
				'log_MID'    => '' 
		) );	

		$newsletterId 		  	   = id_decrypt($newsletterId);
		$this->data['result']      = $this->customer_lib->news_letter_user_details($newsletterId);
		$this->data['newsletterId'] = $newsletterId;
		$this->superAdminCustomView('admin/news_managements/user_details',$this->data);
	}
}