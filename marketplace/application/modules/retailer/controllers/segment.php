<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Segment extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Segment';
	}	
		
	//	This is common for all
	public function segment_list($segment_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->segment_list_dropdown($segment_id,$disable);
	}
	
}