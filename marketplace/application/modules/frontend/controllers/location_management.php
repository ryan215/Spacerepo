<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Location_management extends MY_Controller {

	public function __construct(){
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
		$this->data['title'] = 'Location Managment';
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
		$result['view'] = $this->load->view('admin/location_managements/stateCountryList',$this->data,true);	
		$result['phoneCode'] = '';
		if(!empty($this->data['stateList']))
		{
			$result['phoneCode'] = $this->data['stateList'][0]->phoneCode;
		}
		echo json_encode($result);
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
	
	public function citylistCheckAvailibity()
	{
		$stateId   = 0;
		$cityList  = '';
		$stateId   = trim($this->input->post('stateId'));
		$areaId    = trim($this->input->post('areaId'));
		if(!empty($stateId))
		{
			$where    = 'zip.stateId = '.$stateId.' AND zip.area = '.$areaId;
			$cityList = $this->location_m->zip_list('','',$where);			
		}
		$this->data['cityList'] = $cityList;
		$this->data['cityId']   = '';
		echo $this->load->view('admin/location_managements/citylistCheckAvailibity',$this->data,true);
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
}