<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session','upload'));
		$this->CI->load->helper(array('url','form','cookie'));
		$this->CI->load->model(array('location_m'));
	}
	
	public function state_list_view()
	{
		$this->CI->session->set_userdata(array(
				'log_MODULE' => 'state_list_view',
				'log_MID'    => '' 
		) );
		$result = array();
		$result['total'] = $this->CI->location_m->total_state();
		return $result;
	}
	
	public function state_ajaxFun($total)
	{
		$return      = array();		
		$where       = '';
		$countryName = $this->CI->input->post('countryName');
		$stateName   = $this->CI->input->post('stateName');
		$per_page    = $this->CI->input->post('sel_no_entry');
	//echo "<pre>";	print_r($_POST); exit;
		if(empty($per_page))
		{
			$per_page = 10;
		}
		
		if(!empty($countryName))
		{
			$where.= "country.name LIKE '".$countryName."%' ";
		}
		if(!empty($stateName))
		{
			if(!empty($where))
			{
				$where.= " AND state.stateName LIKE '".$stateName."%' ";
			}
			else
			{
				$where.= "state.stateName LIKE '".$stateName."%' ";
			}
		}		
			
		if(!empty($where))
		{
			
			$total = $this->CI->location_m->total_state($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/location_management/state_ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		//echo $where; exit;
		$return['list']  = $this->CI->location_m->state_list($page,$pagConfig['per_page'],$where);
		//echo $this->CI->db->last_query(); exit;
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}

	public function area_list_view()
	{
		$return = array();
		$return['total'] = $this->CI->location_m->total_area();
		return $return;	
	}
	
	public function area_ajaxFun($total)
	{
		$return      = array();
		$where  	 = '';
		$countryName = $this->CI->input->post('countryName');
		$stateName   = $this->CI->input->post('stateName');
		$areaName  	 = $this->CI->input->post('areaName');
		$per_page    = $this->CI->input->post('sel_no_entry');
		
		if($countryName)
		{
			$where.= " country.name LIKE '".$countryName."%' ";						
		}
		
		if($stateName)
		{
			if($where)
			{
				$where.= " AND  state.stateName LIKE '".$stateName."%' ";	
			}
			else
			{
				$where.= " state.stateName LIKE '".$stateName."%' ";
			}
		}
		
		if($areaName)
		{
			if($where)
			{
				$where.= " AND area.area LIKE '".$areaName."%' ";	
			}
			else
			{
				$where.= " area.area LIKE '".$areaName."%' ";
			}
		}
		
		if(!empty($where))
		{
			$where = "(".$where.")";
			$total = $this->CI->location_m->total_area($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/location_management/area_ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->location_m->area_list($page,$pagConfig['per_page'],$where);
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function zip_list_view()
	{
		$return = array();
		$return['total'] = $this->CI->location_m->total_zip();
		return $return;	
	}
	
	public function zip_ajaxFun($total)
	{
		$return      = array();
		$where  	 = '';
		$countryName = trim($this->CI->input->post('countryName'));
		$stateName   = trim($this->CI->input->post('stateName'));
		$areaName  	 = trim($this->CI->input->post('areaName'));
		$cityName  	 = trim($this->CI->input->post('cityName'));
		$per_page    = $this->CI->input->post('sel_no_entry');
		
		if($countryName)
		{
			$where.= " country.name LIKE '".$countryName."%' ";						
		}
		
		if($stateName)
		{
			if($where)
			{
				$where.= " AND  state.stateName LIKE '".$stateName."%' ";	
			}
			else
			{
				$where.= " state.stateName LIKE '".$stateName."%' ";
			}
		}
		
		if($areaName)
		{
			if($where)
			{
				$where.= " AND area.area LIKE '".$areaName."%' ";	
			}
			else
			{
				$where.= " area.area LIKE '".$areaName."%' ";
			}
		}
		
		if($cityName)
		{
			if($where)
			{
				$where.= " AND trim(zip.city) LIKE '".$cityName."%' ";	
			}
			else
			{
				$where.= " trim(zip.city) LIKE '".$cityName."%' ";
			}
		}
		
		if(!empty($where))
		{
			$where = "(".$where.")";
			$total = $this->CI->location_m->total_zip($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/location_management/zip_ajaxFun/'.$total,
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(5)) ? $this->CI->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$return['list']  = $this->CI->location_m->zip_list($page,$pagConfig['per_page'],$where);
		$return["links"] = $this->CI->ajax_pagination->create_links();
		$return['page']  = $page;
		return $return;
	}
	
	public function add_edit_zip($zipId)
	{
		$result = array();	
		$result['countryId']  = 0;
		$result['stateId']    = 0;
		$result['areaId']     = '';
		$result['cityName']   = '';
		$result['zipCode']    = '';
		$result['pageSubmit'] = 1;
		
		if($_POST)							
		{
			$result['pageSubmit'] = 0;	
			$result['countryId']  = $this->CI->input->post('countryId');
			$result['stateId']    = $this->CI->input->post('stateId');
			$result['areaId']     = $this->CI->input->post('areaId');
			$result['cityName']   = $this->CI->input->post('cityName');
			
			$this->CI->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = zipcode_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				if($zipId)
				{
					if($this->CI->location_m->update_zip($zipId,$result))
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_update_city'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_city'));
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('success_update_city'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_update_city'));
					}
				}
				else
				{
					$newZipId = $this->CI->location_m->add_zip($result);
					$this->CI->custom_log->write_log('custom_log','Generate new zip id is '.$newZipId);
					if($newZipId)
					{
						$this->CI->session->set_flashdata('success',$this->CI->lang->line('success_add_city'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('success_add_city'));
					}
					else
					{
						$this->CI->session->set_flashdata('error',$this->CI->lang->line('error_add_city'));
						$this->CI->custom_log->write_log('custom_log',$this->CI->lang->line('error_add_city'));
					}		
				}
				redirect(base_url().$this->CI->session->userdata('userType').'/location_management/zip_list_view');
			}
		}
		
		if($result['pageSubmit'])
		{
			$details = $this->CI->location_m->zip_details($zipId);
			//echo "<pre>"; print_r($details); exit;
			if(!empty($details))
			{
				$result['countryId']  = $details->countryId;
				$result['stateId']    = $details->stateId;
				$result['areaId']     = $details->area;
				$result['cityName']   = $details->city;
			}
		}
		
		$result['countryList'] = $this->CI->location_m->country_list();		
		return $result;		
	}
}