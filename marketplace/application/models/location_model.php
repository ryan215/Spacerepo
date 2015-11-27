<?php 
class Location_model extends CI_Model{	

	public function __construct()
	{
		parent::__construct();		
		$this->location = $this->load->database('location',true);
	}
	
	public function get_country($order='',$country_id='')
	{
		$this->location->select(' *,CONCAT(UCASE(LEFT(name, 1)), 
                             SUBSTRING(name, 2)) as name',FALSE);
		$this->location->from('country');
		if(!empty($country_id))
		{
			$this->location->where("countryId",$country_id);
		}

		if(!empty($order))
		{
			$this->location->order_by("countryId",'asc');
		}
		else
		{
			$this->location->order_by("name", "asc"); 
		}
		$response = $this->location->get();
		return $response->result();
	}
	public function get_country_detail($code)
	{
		$this->location->select(' *,CONCAT(UCASE(LEFT(name, 1)), 
                             SUBSTRING(name, 2)) as name',FALSE);
		$this->location->from('country');
		if(!empty($code))
		{
			$this->location->where("code",$code);
		}
		$response = $this->location->get();
		return $response->row();
	}
		
	public function get_states($countryID){
		
		$this->location->select(' *,CONCAT(UCASE(LEFT(name, 1)), 
                             SUBSTRING(name, 2)) as name',FALSE);
		$this->location->from('region');
	
		$this->location->where('countryId',$countryID);
		
		$this->location->order_by("name", "asc"); 
		$response=$this->location->get();
		return $response->result();
		}
	public function get_city($countryID,$stateID,$city_id=''){
		
		$this->location->select(' *,CONCAT(UCASE(LEFT(name, 1)), 
                             SUBSTRING(name, 2)) as name',FALSE);
		$this->location->from('cities');
		$this->location->where(array(
									'countryId'=>$countryID,
									'regionId'=> $stateID
										)
										);
		$this->location->order_by("name", "asc"); 
		$response=$this->location->get();
		return $response->result();
		}
	
	public function get_currency($currency_id=''){
		$this->location->select('*');
		$this->location->from('currency');
		if(!empty($currency_id)){
			$this->location->where('id',$currency_id);
		}
		$response=$this->location->get();
		return $response->result();
		}
	public function get_location_detail($countryID,$stateID='',$city_id='',$single=''){
		
			
			
			$this->location->from('country');
			$select ='CONCAT(UCASE(LEFT({pre}country.name, 1)), 
                             SUBSTRING({pre}country.name, 2)) as country';
			if(!empty($countryID)){
				//$select .='country.name as country';
				$this->location->where('country.countryId',$countryID);
			}
			if(!empty($stateID)){
				$select .=',CONCAT(UCASE(LEFT({pre}region.name, 1)), 
                             SUBSTRING({pre}region.name, 2))  as state';
				$this->location->join('region' ,'region.countryId=country.countryId');
				$this->location->where('region.regionId',$stateID);
			}
			if(!empty($city_id)){
				$select .=',CONCAT(UCASE(LEFT({pre}cities.name, 1)), 
                             SUBSTRING({pre}cities.name, 2))  as city';
				$this->location->join('cities' ,'region.regionId=cities.regionId');
				$this->location->where('cities.cityId',$city_id);
			}
			$this->location->select($select,false);
		$response=$this->location->get();
		//echo $this->location->last_query();
			if($single=='single'){
				return $response->row();
			}else{
				return $response->result();
			}
		}
}