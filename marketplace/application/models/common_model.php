<?php

class Common_model extends MY_Model{	

	public function __construct()
	{
		parent::__construct();		
	}	

	public function clearSessionData() 
	{
		foreach($this->session->userdata as $sess_var)
		{
			unset($sess_var);
		}
	}
	
	public function resize($imgPath=false,$thumbnailPath=false,$height=false,$width=false)
	{		
		$config['image_library']  = 'gd2';
	    $config['source_image']   = $imgPath;
		$config['new_image']      = $thumbnailPath;
	    //$config['create_thumb'] = TRUE;
	    $config['maintain_ratio'] = false;
		$config['master_dim']	  =	'height';
		$config['width']  		  = $width;
		$config['height'] 		  = $height;
		$this->load->library('image_lib');
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();	
	}
	
	public function ratio_resize($imgPath=false,$thumbnailPath=false,$height=false,$width=false)
	{
		$config['image_library']  = 'gd2';
	    $config['source_image']   = $imgPath;
		$config['new_image']      = $thumbnailPath;
	    //$config['create_thumb'] = TRUE;
	    $config['maintain_ratio'] = true;
		
		$config['width']  		  = $width;
		$config['height'] 		  = $height;
		$this->load->library('image_lib');
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();	
	}
	
	public function product_image_resize($imgPath,$thumbnailPath,$width,$height)
	{		
		$config['image_library']  = 'gd2';
	    $config['source_image']   = $imgPath;
		$config['new_image']      = $thumbnailPath;
	   	$config['maintain_ratio'] = TRUE;
		$config['width']  		  = $width;
		$config['height'] 		  = $height;
		$this->load->library('image_lib');
	    $this->image_lib->initialize($config);
	    $this->image_lib->resize();	
	}
	
	public function update_last_modified_by($page_name,$message)
	{}
	
	public function get_last_modified_by($page_name)
	{}
}