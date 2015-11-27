<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Location_management extends MY_Controller {

	public function __construct(){
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Location Managment';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'location_country_index',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'Country';
		
		$this->data['total'] = $this->location_m->total_country();
		$this->superAdminCustomView('admin/location_managements/country_list_view',$this->data);
	}
	
	public function country_ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'country_ajaxFun',
				'log_MID'    => '' 
		) );
				
		$where  = '';
		$search = $this->input->post('search');
		$per_page = $this->input->post('sel_no_entry');
		if(empty($per_page))
		{
			$per_page = 10;
		}
		
		if(!empty($search))
		{
			$where.= "name LIKE '".$search."%' ";
			$total = $this->location_m->total_country($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'location_management/country_ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$this->data['list']  = $this->location_m->country_list($page,$pagConfig['per_page'],$where);
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->load->view('admin/location_managements/country_ajaxPagView',$this->data);
	}
	
	public function addEditCountry($countryId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditCountry',
				'log_MID'    => '' 
		) );
		
		$countryId = id_decrypt($countryId);
		$result    = array();		
		$result['countryName'] = '';
		$result['pageSubmit']  = 1;	
						
		if($_POST)							
		{
			$result['pageSubmit']  = 0;	
			$result['countryName'] = $this->input->post('countryName');
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = country_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				if($countryId)
				{
					if($this->location_m->update_country($countryId,$result))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_update_country'));
						$this->custom_log->write_log('custom_log','message is '.$this->lang->line('success_update_country'));					
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_update_country'));
						$this->custom_log->write_log('custom_log','message is '.$this->lang->line('error_update_country'));
					}
				}
				else
				{
					$countryId = $this->location_m->add_country($result);
					$this->custom_log->write_log('custom_log','Generate new country id is '.$countryId);
					if($countryId)
					{
						$this->session->set_flashdata('success',$this->lang->line('success_add_country'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('success_add_country'));					
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_add_country'));
						$this->custom_log->write_log('custom_log', 'message is '.$this->lang->line('error_add_country'));
					}
				}
				redirect(base_url().'superadmin/location_management');				
			}
		}
		
		if($result['pageSubmit'])
		{
			$details = $this->location_m->country_details($countryId);
			if(!empty($details))
			{
				$result['countryName'] = $details->name;
			}
		}
		
		$this->data['countryId'] = $countryId;
		$this->data['result']    = $result;
		$this->superAdminCustomView('admin/location_managements/addEditCountry',$this->data,true);
	}
	
	public function state_list_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'state_list_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'State';
		
		$this->data['result'] = $this->location_lib->state_list_view();
		$this->superAdminCustomView('admin/location_managements/state_list_view',$this->data);
	}
	
	public function state_ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'state_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->location_lib->state_ajaxFun($total);
		$this->load->view('admin/location_managements/state_ajaxPagView',$this->data);
	}
	
	public function addEditstate($stateId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditstate',
				'log_MID'    => '' 
		) );
		
		$stateId = id_decrypt($stateId);
		$result = array();		
		$result['stateName']  = '';
		$result['countryId']  = 0;
		$result['zoneId']     = 0;
		$result['pageSubmit'] = 1;	
						
		if($_POST)							
		{
			$result['pageSubmit'] = 0;	
			$result['countryId']  = $this->input->post('countryId');
			$result['zoneId']     = $this->input->post('zoneId');
			$result['stateName']  = $this->input->post('stateName');
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = state_rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				if($stateId)
				{
					if($this->location_m->update_state($stateId,$result))
					{
						$this->session->set_flashdata('success',$this->lang->line('success_update_state'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_update_state'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('success_update_state'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_update_state'));
					}
				}
				else
				{
					$newStateId = $this->location_m->add_state($result);
					$this->custom_log->write_log('custom_log','Generate new state id is '.$newStateId);
					if($newStateId)
					{
						$this->session->set_flashdata('success',$this->lang->line('success_add_state'));
						$this->custom_log->write_log('custom_log',$this->lang->line('success_add_state'));
					}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_add_state'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_add_state'));
					}														
				}
				redirect(base_url().'superadmin/location_management/state_list_view');
			}
		}
		
		if($result['pageSubmit'])
		{
			$details = $this->location_m->state_details($stateId);
			//echo "<pre>"; print_r($details); exit;
			if(!empty($details))
			{
				$result['stateName']  = $details->stateName;
				$result['countryId']  = $details->countryId;
				$result['zoneId']     = $details->zoneId;
			}
		}
		
		$result['countryList'] = $this->location_m->country_list();
		$result['zoneList']    = $this->location_m->zone_list();
		$this->data['stateId'] = $stateId;
		$this->data['result']  = $result;
		$this->superAdminCustomView('admin/location_managements/addEditstate',$this->data,true);
	}
		
	public function area_list_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'area_list_view',
				'log_MID'    => '' 
		) );
		$this->data['title'] = 'Area';	
		$this->data['result'] = $this->location_lib->area_list_view();
		$this->superAdminCustomView('admin/location_managements/area_list_view',$this->data);
	}
	
	public function area_ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'area_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->location_lib->area_ajaxFun($total);
		$this->load->view('admin/location_managements/area_ajaxPagView',$this->data);		
	}
	
	public function zip_list_view()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'zip_list_view',
				'log_MID'    => '' 
		) );
		$this->data['title']  = 'City';
		$this->data['result'] = $this->location_lib->zip_list_view();
		$this->superAdminCustomView('admin/location_managements/zip_list_view',$this->data);
	}
	
	public function zip_ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'zip_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->location_lib->zip_ajaxFun($total);
		$this->load->view('admin/location_managements/zip_ajaxPagView',$this->data);		
	}
	
	public function addEditZip($zipId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditZip',
				'log_MID'    => '' 
		) );
		
		$zipId  = id_decrypt($zipId);
		$this->data['zipId']  = $zipId;
		$this->data['result'] = $this->location_lib->add_edit_zip($zipId);
		$this->superAdminCustomView('admin/location_managements/addEditZip',$this->data);
	}
	
	public function stateCountryPhoneCodeList()
	{
		$countryId = $this->input->post('countryId');
		$stateId   = $this->input->post('stateId');
		if(empty($countryId))
		{
			$countryId = 0;
		}
		$where = 'state.countryId = '.$countryId;
		$this->data['stateList'] = $this->location_m->state_list('','',$where);
		$this->data['stateId'] = $stateId;
		$result['view'] 	= $this->load->view('admin/location_managements/stateCountryList',$this->data,true);	
		$result['phoneCode'] = '';
		if(!empty($this->data['stateList']))
		{
			$result['phoneCode'] = $this->data['stateList'][0]->phoneCode;
		}
		echo json_encode($result);
	}
	
	public function stateCountryList()
	{
		$countryId = $this->input->post('countryId');
		$stateId   = $this->input->post('stateId');
		if(empty($countryId))
		{
			$countryId = 0;
		}
		$where = 'state.countryId = '.$countryId;
		$this->data['stateList'] = $this->location_m->state_list('','',$where);
		$this->data['stateId'] = $stateId;
		echo $this->load->view('admin/location_managements/stateCountryList',$this->data,true);		
	}
	
	public function areaStateList()
	{
		$stateId = $this->input->post('stateId');
		$areaId = $this->input->post('areaId');
		if(empty($stateId))
		{
			$stateId = 0;
		}
		$where = 'area.stateId = '.$stateId;
		$this->data['areaList'] = $this->location_m->area_list('','',$where);
		$this->data['areaId'] = $areaId;
		echo $this->load->view('admin/location_managements/areaStateList',$this->data,true);		
	}
	
	public function cityAreaList()
	{ 
		$areaId = $this->input->post('areaId');
		$cityId = $this->input->post('cityId');
		if(empty($areaId))
		{
			$areaId = 0;
		}
		$where = 'zip.area = '.$areaId;
		$this->data['cityList'] = $this->location_m->zip_list('','',$where);
		$this->data['cityId']   = $cityId;
		echo $this->load->view('admin/location_managements/cityAreaList',$this->data,true);		
	}
	
	public function cityStateList()
	{
		$stateId = $this->input->post('stateId');
		$cityId = $this->input->post('cityId');
		if(empty($stateId))
		{
			$stateId = 0;
		}
		$where = 'zip.stateId = '.$stateId;
		$this->data['cityList'] = $this->location_m->zip_list('','',$where);
		$this->data['cityId']   = $cityId;
		echo $this->load->view('admin/location_managements/cityStateList',$this->data,true);		
	}
}