<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Marketing_category_management extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'category_management';
	}	
	
	public function index()
	{
		redirect(base_url().'admin/category_management/view_list');
	}
	
	public function sementics_category_list($parentCatId=0,$level=1)
	{		
	
		echo $this->segment_cat_m->semantics_category_list_dropdown($parentCatId,'',$level);
	}
	
	public function view_list($parentCatId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'category_management',
				'log_MID'    => '' 
		) );			
		
		$parentCatId 		  = id_decrypt($parentCatId);
		$result      		  = $this->category_lib->view_list($parentCatId);
		$this->data['result'] = $result;
		$this->adminCustomView('category_managements/category_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$result 			  = $this->category_lib->marketingcategoryAjaxFun($total);
		$this->data['result'] = $result;
		$this->load->view('category_managements/ajax_page',$this->data);
	}
	
	public function addEditCategory($parentCatId=0,$catId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditCategory',
				'log_MID'    => '' 
		) );
		
		$parentCatId   = id_decrypt($parentCatId);
		$catId         = id_decrypt($catId);
		$result		   = $this->category_lib->addEditmarketingCategory($parentCatId,$catId);
		
		$this->data['result']      = $result;
		$this->data['parentCatId'] = $parentCatId;
		$this->data['catId']	   = $catId;
		$this->adminCustomView('category_managements/addEditCategory',$this->data);
	}
	
	public function check_cat_name()
	{
		$checkArr  = array(
						'parentCategoryId' => $this->input->post('parentCatId'),
					 	'categoryCode' 	   => $this->input->post('category_name'),						
					 );
		
		$res = $this->segment_cat_m->marketing_category_name_check($checkArr);
		if(!empty($res))
		{
			$this->form_validation->set_message('check_cat_name','The %s field already exits');
			return false;
		}
		else
		{
			return true;
		}	
	}
	
	public function category_list($parentCatId=0,$category_id=0,$level=1)
	{		
		echo $this->segment_cat_m->category_list_dropdown($parentCatId,$category_id,$level);
	}
	
	public function auto_search()
	{
		$return = $this->category_lib->auto_search();
		echo $return;		
	}
	
	public function level2_list($parentCatID=0,$level2ID=0)
	{
		$this->data['level2ID'] = $level2ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level2_list',$this->data,true);
	}
	
	public function level3_list($parentCatID=0,$level3ID=0)
	{
		$this->data['level3ID'] = $level3ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level3_list',$this->data,true);
	}
	
	public function level4_list($parentCatID=0,$level4ID=0)
	{
		$this->data['level4ID'] = $level4ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level4_list',$this->data,true);
	}
	
	public function level5_list($parentCatID=0,$level5ID=0)
	{
		$this->data['level5ID'] = $level5ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level5_list',$this->data,true);
	}
	
	public function level6_list($parentCatID=0,$level6ID=0)
	{
		$this->data['level6ID'] = $level6ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level6_list',$this->data,true);
	}
	
	public function level7_list($parentCatID=0,$level7ID=0)
	{
		$this->data['level7ID'] = $level7ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level7_list',$this->data,true);
	}
	
	public function level8_list($parentCatID=0,$level8ID=0)
	{
		$this->data['level8ID'] = $level8ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level8_list',$this->data,true);
	}
	
	public function level9_list($parentCatID=0,$level9ID=0)
	{
		$this->data['level9ID'] = $level9ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level9_list',$this->data,true);
	}
	
	public function level10_list($parentCatID=0,$level10ID=0)
	{
		$this->data['level10ID'] = $level10ID;
		$this->data['catList']  = $this->segment_cat_m->category_list(0,'','',$parentCatID);	
		echo $this->load->view('category_managements/level10_list',$this->data,true);
	}
}