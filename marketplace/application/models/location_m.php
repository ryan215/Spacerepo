<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function total_country($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('country');
		$this->db->where('active',1);
		if(!empty($where))
		{
			$this->db->where($where);
		}		
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function country_list($start=0,$limit='',$where='')
	{
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$this->db->where('active',1);
		 $this->db->order_by("name","asc");
   
		$result = $this->db->get('country');
		return $result->result();
	}
	public function all_country_list($start=0,$limit='',$where='')
	{
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		
		 $this->db->order_by("name","asc");
   
		$result = $this->db->get('country');
		return $result->result();
	}
	
	public function country_details($countryId)
	{
		$this->db->where('countryId',$countryId);
		$result = $this->db->get('country');
		return $result->row();
	}
	
	public function add_country($addArr)
	{
		$insertOpt = array('name' => $addArr['countryName'],);
		$this->db->insert('country',$insertOpt);
		return $this->db->insert_id();	
	}	
	
	public function update_country($countryId,$updateArr)
	{
		$this->db->where('countryId',$countryId);
		$this->db->update('country',array('name' => $updateArr['countryName']));
		return $this->db->affected_rows();	
	}
	
	public function total_zone($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('zone');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function zone_list($start=0,$limit='',$where='')
	{
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get('zone');
		return $result->result();
	}
	
	public function add_zone($addArr)
	{
		$insertOpt = array('zoneId' => $addArr['zoneName'],);
		$this->db->insert('zone',$insertOpt);
		return $this->db->insert_id();	
	}	
	
	public function total_state($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('state');
		$this->db->join('country','state.countryId = country.countryId');
		//$this->db->join('zone','state.zoneId = zone.zoneId');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function state_list($start=0,$limit='',$where='')
	{
		$this->db->select('state.*,country.name AS countryName,country.phoneCode');
		$this->db->from('state');
		$this->db->join('country','state.countryId = country.countryId');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		 $this->db->order_by("state.stateName","asc");
		$result = $this->db->get();
		return $result->result();
	}
	
	public function add_state($addArr)
	{
		$insertOpt = array(
						'countryId' => $addArr['countryId'],
						'stateName' => $addArr['stateName'],
						//'zoneId'    => $addArr['zoneId'],
						'createDt'  => date('Y-m-d H:i:s'),
					 );
		$this->db->insert('state',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function update_state($stateId,$updateArr)
	{
		$updateOpt = array(
						'countryId' => $updateArr['countryId'],
						'stateName' => $updateArr['stateName'],
						//'zoneId'    => $updateArr['zoneId'],
					 );
		$this->db->where('stateId',$stateId);
		$this->db->update('state',$updateOpt);
		return $this->db->affected_rows();	
	}
	
	public function state_details($stateId)	
	{
		$this->db->select('state.*,country.name AS countryName');
		$this->db->from('state');
		$this->db->join('country','state.countryId = country.countryId');
		//$this->db->join('zone','state.zoneId = zone.zoneId');
		$this->db->where('state.stateId',$stateId);
		$result = $this->db->get();
		return $result->row();	
	}
	
	public function total_area($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('area');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->join('country','state.countryId = state.countryId');
		$this->db->where('country.countryId',154);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function area_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('area');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->join('country','state.countryId = state.countryId');
		$this->db->where('country.countryId',154);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}
	
	public function add_area($addArr)
	{
		$insertOpt = array(
						'area'     => $addArr['areaName'],
						'stateId'  => $addArr['stateId'],
						'createDt' => date('Y-m-d H:i:s'),
					 );
		$this->db->insert('area',$insertOpt);
		return $this->db->insert_id();	
	}
		
	public function total_zip($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('zip');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','zip.stateId = state.stateId');
		$this->db->join('country','state.countryId = country.countryId');
		$this->db->where('country.countryId',154);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		
		$total  = 0; 
		if(!empty($result))
		{
			$total = $result->total;
		}
		//echo $this->db->last_query(); exit; 
		return $total;
	}
	
	public function zip_details($zipId)
	{
		$this->db->where('zipId',$zipId);
		$result = $this->db->get('zip');
		return $result->row();
	}
	
	public function zip_list($start=0,$limit='',$where='')
	{
		$this->db->select('country.countryId,country.name,state.stateId,state.stateName,zip.zipId,zip.zipCode,zip.city,zip.area,zip.shippingCovered,zip.createDt,area.area');
		$this->db->from('zip');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->join('country','state.countryId = country.countryId');
		$this->db->where('country.countryId',154);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $result->result();
	}
	
	public function add_zip($addArr)
	{
		$insertOpt = array(
						'zipCode'   => otp5_digit(), //$addArr['zipCode'],
						'countryId' => $addArr['countryId'],
						'city'      => $addArr['cityName'],
						'stateId'   => $addArr['stateId'],
						'area'      => $addArr['areaId'],
						'createDt'  => date('Y-m-d H:i:s'),
					 );
		$this->db->insert('zip',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function update_zip($zipId,$updateArr)
	{
		$updateOpt = array(
						//'zipCode'   => $updateArr['zipCode'],
						'countryId' => $updateArr['countryId'],
						'city'      => $updateArr['cityName'],
						'stateId'   => $updateArr['stateId'],
						'area'      => $updateArr['areaId'],
					 );
		$this->db->where('zipId',$zipId);		 
		$this->db->update('zip',$updateOpt);
		return $this->db->affected_rows();	
	}
	public function state_list_dropdown($country_id='',$state_id='')
	{
		if(!empty($country_id))
		{
			$where=array('country.countryId'=>$country_id);
		}
		
		$state_list=$this->state_list('','',$where);
		$statelisting ='<select class="form-control selectpicker" name="state_id" data-live-search="true">';
		foreach($state_list as $state_detail)
		{
			if(!empty($state_id) && $state_id==$state_detail->stateId)
			{
				$selected='selected="selected"';
			}else
			{
				$selected='';
			}
			$statelisting.='<option value="'.$state_detail->stateId.'" '.$selected.'>'.ucfirst($state_detail->stateName).'</option>';
		}
		$statelisting .='</select> ';
		return $statelisting;
	}
	
	public function product_country_list()
	{
		$this->db->where('name','nigeria');
		$this->db->order_by("name","asc");   
		$result = $this->db->get('country');
		return $result->result();
	}
	
	public function get_country_id($countryName)
	{
		$this->db->where('name',$countryName);
		$this->db->order_by("name","asc");   
		$result = $this->db->get('country');
		return $result->row();
	}
	
	public function nigeria_state_list()
	{
		$this->db->select('state.*,country.name AS countryName,country.phoneCode');
		$this->db->from('state');
		$this->db->join('country','state.countryId = country.countryId');
		$this->db->where('state.countryId','154');
		$this->db->order_by("state.stateName","asc");
		$result = $this->db->get();
		return $result->result();
	}
	
	public function shipping_city_details($shippingCityId)
	{
		$this->db->select('*');
		$this->db->from('zip');
		$this->db->where(array('countryId' => 154,'zipId' => $shippingCityId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function state_id($stateName)
	{
		$stateId = 0;
		$this->db->select('stateId');
		$this->db->from('state');
		$this->db->where('stateName',$stateName);
		$this->db->order_by("stateName","asc");
		$result = $this->db->get()->row();
		if(!empty($result))
		{
			$stateId = $result->stateId;
		}
		return $stateId;
	}
	
	public function get_city($countryId,$stateId)
	{
		$this->db->where(array('countryId' => $countryId,'stateId' => $stateId));
		$result = $this->db->get('zip');
		return $result->result();
	}
	
	public function pickup_state_list()
	{
		$this->db->select('state.*');
		$this->db->from('state');
		$this->db->join('address','state.stateId = address.state');
		$this->db->join('pickup_address','address.addressId = pickup_address.addressId');
		$this->db->join('pickup','pickup_address.pickupId = pickup.pickupId');
		$this->db->group_by('state.stateId');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function state_area_city_list($whereStr)
	{
		$this->db->select('stateId,area,zipId,city');
		$this->db->from('zip');
		$this->db->where($whereStr);
		$result = $this->db->get()->result();
		return $result;
	}
}