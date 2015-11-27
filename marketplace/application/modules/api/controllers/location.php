<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class Location extends REST_Controller
{
	function __construct()
    {
        parent::__construct();
    
		$this->load->model('Location_m');
		$this->load->helper('api_validation');
        if (is_array($this->response->lang))
        {
            $this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
            $this->lang->load('error', $this->response->lang[0]);
            $this->lang->load('success', $this->response->lang[0]);

        }
        else
        {
            $this->custom_log->write_log('custom_log',print_r($this->response->lang,true));
            $this->lang->load('error', $this->response->lang);
            $this->lang->load('success', $this->response->lang);
            // $this->load->language('application', $this->response->lang);
        }

        $this->apiresponse['time']=time();

    }
	function getCountry_post(){
		$this->apiresponse['success']=1;
		$this->apiresponse['response']['data']=$this->Location_m->all_country_list();
		$this->response($this->apiresponse,'200');
	}
	function getState_post()
	{
		$country_id=$this->post('country_id');
		if(!empty($country_id))
		{
			$this->apiresponse['success']=1;
			$this->apiresponse['response']['message']=$this->lang->line('success_get_state');
			$where='state.countryId ='.$country_id.'';
			$this->apiresponse['response']['data']=$this->Location_m->state_list('','',$where);
		}
		else
		{
			$this->apiresponse['success']=0;
			$this->apiresponse['response']['message']=$this->lang->line('valid_param');
			
		}
		$this->response($this->apiresponse,200);
	}
	function getArea_post()
	{
		
		$rules=area_validation();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$country_id=$this->post('country_id');
			$state_id=$this->post('state_id');
			$this->apiresponse['success']=1;
			$this->apiresponse['response']['message']=$this->lang->line('succ_get_city');
			$where= 'state.stateId ='.$state_id;
			$this->apiresponse['response']['data'] =$this->Location_m->area_list('','',$where);
			
		}
		else
		{
			$this->apiresponse['success']=0;
			$this->apiresponse['response']['message']=validation_errors();
			
		}
		$this->response($this->apiresponse,200);
		
		
	
	}
	function getCity_post()
	{
		$rules=city_validation();
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$country_id=$this->post('country_id');
			$state_id=$this->post('state_id');
			$area_id=$this->post('area_id');
			$this->apiresponse['success']=1;
			$this->apiresponse['response']['message']=$this->lang->line('succ_get_city');
			$where= 'state.stateId ='.$state_id.'  and zip.area ='. $area_id;
			$this->apiresponse['response']['data'] =$this->Location_m->zip_list('','',$where);
			
		}
		else
		{
			$this->apiresponse['success']=0;
			$this->apiresponse['response']['message']=validation_errors();
			
		}
		$this->response($this->apiresponse,200);
		
		
		
	}
}
    