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
	
	public function index($parentCatID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Category',
				'log_MID'    => '' 
		) );	
		
		$parentCatID   = id_decrypt($parentCatID);
		$segERR        = '';
		$catERR        = '';
		$segment_id    = '';
		$category_name = '';		
		$userId        = $this->session->userdata('userId');
		$show_modal    = 0;
		
		if($_POST)
		{
			$show_modal = 1;
			$this->custom_log->write_log('custom_log','FOrm submit '.print_r($_POST,true));
			
			$catID         = $this->input->post('catID');
			$segment_id    = $this->input->post('segment_id');
			$category_name = $this->input->post('category_name');
			$rules 		   = category_rules();
						
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				if($catID)
				{
					if($this->segment_cat_m->update_category($catID,$segment_id,$category_name))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_update_category'));
						$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_update_category'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_update_category'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_update_category'));
					}
					redirect(base_url().'admin/category');				
				}
				else
				{	
					$categoryId = $this->segment_cat_m->add_category($segment_id,$category_name);
					$this->custom_log->write_log('custom_log','categor id is '.$categoryId);
					if($categoryId)
					{
						$this->session->set_flashdata('success',$this->lang->line('success_add_category'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('success_add_category'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_add_category'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_add_category'));
					}
					redirect(base_url().'admin/category');
				}
				
			}
			else
			{	
				$segERR = form_error('segment_id');
				$catERR = form_error('category_name');
			}
		}	
		
		$this->data['total']      = $this->segment_cat_m->total_category($parentCatID);
		$this->data['show_modal'] = $show_modal;
		$this->data['sendData']	  = 'parentCatID='.$parentCatID.'&segERR='.$segERR.'&catERR='.$catERR.'&segment_id='.$segment_id.'&category_name='.$category_name;
		$this->adminCustomView('category/category_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Category_ajaxFun',
				'log_MID'    => '' 
		) );	
		
		$parentCatID = $this->input->post('parentCatID');
		$per_page = $this->input->post('sel_no_entry');		
		$sorting  = $this->input->post('sorting');
		$where  = '';
		$search = $this->input->post('search');
		if(!empty($search))
		{
			$where = "categoryCode LIKE '%".$search."%' ";		
			$total = $this->segment_cat_m->total_category($parentCatID,$where);
		}
		
		
		$pagConfig = array(
		   				'base_url'    => base_url().'admin/category/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$this->data['category_list'] = $this->segment_cat_m->category_list($page,$pagConfig['per_page'],$where,$parentCatID);
		//echo $this->db->last_query();
		$this->data["links"]     = $this->ajax_pagination->create_links();
		$this->data['page']      = $page;
		$this->load->view('category/ajax_search',$this->data);
	}
	
	public function category_form($catID=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'category_form',
				'log_MID'    => '' 
		) );
		
		$segment_id       	  = $this->input->post('segment_id');
		$category_name        = $this->input->post('category_name');
		$this->data['segERR'] = $this->input->post('segERR');
		$this->data['catERR'] = $this->input->post('catERR');
		
		if($catID)
		{
			$where  = ' WHERE category.category_id = '.$catID;
			$catRes = $this->segment_cat_m->category_where(0,1,$where);
			if(!empty($catRes))
			{
				$segment_id    = $catRes[0]->segment_id;
				$category_name = $catRes[0]->category_name;
			}
		}
		
		$this->data['catID']         = $catID;
		$this->data['segment_id']    = $segment_id;
		$this->data['category_name'] = $category_name;
		
		echo $this->load->view('category/category_form',$this->data);
	}
		
	//	This function common for all
	public function category_list($segment_id=0,$category_id=0,$flag=0)
	{
		$disable = TRUE;
		if(!$flag)
		{
			$disable = FALSE;
		}
		echo $this->segment_cat_m->category_list_dropdown($segment_id,$category_id);
	}
	
	public function check_cat_name()
	{
		$checkArr  = array(
						'parentCategoryId' => $this->input->post('segment_id'),
					 	'categoryCode' 	   => $this->input->post('category_name'),						
					 );
		
		$res = $this->segment_cat_m->category_name_check($checkArr);
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
	
	public function delete_category($categoryID='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_category',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','category id is '.$categoryID);
		$categoryID = id_decrypt($categoryID);
		
		if($categoryID)
		{
			if($this->segment_cat_m->delete_category($categoryID))
			{
				$this->session->set_flashdata('success',$this->lang->line('success_category_delete'));
				$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_category_delete'));
			}
			else
			{
				$this->session->set_flashdata('error',$this->lang->line('error_category_delete'));
				$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_category_delete'));
			}		
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_category_id_not'));
			$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_category_id_not'));
		}
		redirect(base_url().'admin/category');
	}
}