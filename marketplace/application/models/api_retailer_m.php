<?php

class Api_retailer_m extends MY_Model{	

	public function __construct()
	{
		parent::__construct();	
		
	}	
	
	public function employee_roles()
	{
		$this->db->where('parentRoleId',19);
		$result = $this->db->get('role');
		return $result->result();
	}
	
	public function add_retailer_employee($organizationId,$addArr,$employeeId)
	{
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'userName' 			=> $addArr['userName'],
					 	'imageName' 		=> $addArr['imageName'],
						'salary' 			=> $addArr['salary'],
						'email'				=>	$addArr['email'],
						'active'			=> 0,
						'imageName'			=>	$addArr['imageName'],
						'imagePath' 		=> base_url().'uploads/employee/',
						'businessPhoneCode' => $addArr['countryCode'],
						'businessPhone'     => $addArr['businessPhone'],						
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $employeeId,
					 );
		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}
	public function update_retailer_employee($organizationId,$addArr,$employeeId,$organizationEmployeeId)
	{
		$insertOpt = array(
			'organizationId' 	=> $organizationId,
			'firstName' 		=> $addArr['firstName'],
			'lastName' 			=> $addArr['lastName'],
			'userName' 			=> $addArr['userName'],
			'imageName' 		=> $addArr['imageName'],
			'salary' 			=> $addArr['salary'],
			'email'				=>	$addArr['email'],
			'active'			=> 0,
			'imageName'			=>	$addArr['imageName'],
			'imagePath' 		=> base_url().'uploads/employee/',
			'businessPhoneCode' => $addArr['countryCode'],
			'businessPhone'     => $addArr['businessPhone'],
			'createDt'			=> date('Y-m-d H:i:s'),
			'lastModifiedDt'	=> date('Y-m-d H:i:s'),
			'lastModifiedBy'	=> $employeeId,
		);
		$this->db->where('employeeId',$organizationEmployeeId);
		$this->db->update('employee',$insertOpt);
		return $this->db->affected_rows();
	}

	public function add_retailer_employee_address($addArr,$employeeId)
	{
		$insertOpt = array(
						'addressLine1'		 => $addArr['street'],
						'area'				=>	$addArr['areaId'],
						'city' 			 	 => $addArr['cityId'],
						'state' 			 => $addArr['stateId'],
						'country'  			 => $addArr['countryId'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $employeeId,
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}
	public function update_retailer_employee_address($addArr,$employeeId,$addressId)
	{
		$insertOpt = array(
			'addressLine1'		 => $addArr['street'],
			'city' 			 	 => $addArr['cityId'],
			'state' 			 => $addArr['stateId'],
			'country'  			 => $addArr['countryId'],
			'createDt'			 => date('Y-m-d H:i:s'),
			'lastModifiedDt'	 => date('Y-m-d H:i:s'),
			'lastModifiedBy'	 => $employeeId,
		);
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$insertOpt);
		return $this->db->affected_rows();
	}
	
	public function add_retailer_employee_addressTbl($employeeId,$addressId,$retailerId)
	{
		$insertOpt = array(
						'employeeId' 	 => $employeeId,
						'addressId' 	 => $addressId,
						'addressTypeId'  => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $retailerId,
					 );
		$this->db->insert('employee_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_employee_role($organizationId,$employeeId,$roleId,$retailer_id='')
	{
		$insertOpt = array(
						'employeeId'     => $employeeId,
						'roleId'	     => $roleId,
						'organizationId' => $organizationId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $retailer_id,
					);
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_designation_role($organizationId,$code,$role,$employeeId)
	{
		
		$insertOpt	= array(
							'organizationId' => $organizationId,
							'code'			 => $code,
							'roleId'		 => $role,	
							'createDt'		 => date('Y-m-d H:i:s'),
							'lastModifiedDt' => date('Y-m-d H:i:s'),
							'lastModifiedBy' => $employeeId
							);
	$this->db->insert('designation_role',$insertOpt);
	return $this->db->insert_id();
	}
	public function add_employee_designation($employeeId,$designationId,$retailer_id)
	{
		
		$insertOpt	= array(
							'employeeId' 	=> $employeeId,
							'designationId'	=>	$designationId,
							'lastModifiedDt' => date('Y-m-d H:i:s'),
							'lastModifiedBy' => $retailer_id
							);
		$this->db->insert('employee_designation',$insertOpt);
		return $this->db->insert_id();
	}
	public function get_designation_id($designnation,$organizationId)
	{
		$this->db->select('*');
		$this->db->from('designation_role');
		$this->db->where('code',$designnation);
		$this->db->where('organizationId',$organizationId);
		$query=$this->db->get();
		return $query->row();
	}
	public function get_rolesdesignation($roles,$organizationId)
	{
		$roleid=implode($roles,',');
		$this->db->select('*');
		$this->db->from('designation_role');
		$this->db->where('roleId',$roleid);
		$this->db->where('organizationId',$organizationId);
		$query=$this->db->get();
		return $query->row();
	}
}