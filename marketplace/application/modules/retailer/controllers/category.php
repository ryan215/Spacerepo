<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Category extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Category';
	}	
	
	//	This function common for all
	public function category_list($segment_id=0,$category_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->category_list_dropdown($segment_id,$category_id,$disable);
	}
}