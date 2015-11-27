<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Custom extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
	}	
	
	public function get_view($view_name)
	{
		$this->data['title'] = ucwords(str_replace('-',' ',$view_name));
		$this->frontendCustomView('custom/'.$view_name,$this->data);
	}
	public function ajax_captcha()
    {
        $original_string = array_merge(range(0,9),range('a','z'),range('A','Z'));
        $original_string = implode("",$original_string);
        $captcha         = substr(str_shuffle($original_string),0,5);
       // echo $captcha;
        $values = array(
                'word'        => $captcha,
                'word_length' => 5,
                'img_path'    => './uploads/captch/',
                'img_url'     => base_url().'uploads/captch/',
                'font_path'   => base_url().'system/fonts/texb.ttf',
                'img_width'   => '200',
                'img_height'  => 50,
                'expiration'  => 3600
        );
        $data = create_captcha($values);
       echo json_encode($data);
    }
	
	
	
	
	
		
			
}