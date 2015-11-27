<?php

class Retailer_m extends MY_Model{	

	public function __construct()
	{
		parent::__construct();	
		
	}
	
	public function retailer_user_list($start,$limit='',$where='')
	{
		$this->db->select("organization.organizationId,employee.*,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode",false);
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','organization.organizationId = csr_organization.organizationId','left');
		$this->db->where('role.code','CORPADMIN');
		if(($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin'))
		{
			$this->db->where('(employee.requestStatus = 0 OR employee.requestStatus = 3)'); 
		}
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if($this->session->userdata('userType')=='cse')
		{
			$this->db->where('csr_organization.employeeId',$this->session->userdata('userId'));
		}
		
		$this->db->order_by('organization.organizationName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}	
	
	public function pickup_with_address_list_states($stateId)
	{
		$this->db->select('pickup.*,address.*,state.stateName,area.area,zip.city');
		$this->db->from('pickup');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.zip = zip.zipId','left');
		$this->db->where(array('pickup.active' => 1,'pickup_address.active' => 1,'address.state' => $stateId));
		$result = $this->db->get();
		return $result->result();
	}
	
	public function pickup_address_details($pickupId)
	{
		$this->db->select('pickup.*,address.*,state.stateName,area.area,zip.city');
		$this->db->from('pickup');
		$this->db->join('pickup_address','pickup.pickupId = pickup_address.pickupId');
		$this->db->join('address','pickup_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.zip = zip.zipId','left');
		$this->db->where(array('pickup.active' => 1,'pickup_address.active' => 1,'pickup.pickupId' => $pickupId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function employee_roles()
	{
		$this->db->where('parentRoleId',19);
		$result = $this->db->get('role');
		return $result->result();
	}
	
	public function add_retailer_employee($organizationId,$addArr)
	{
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'userName' 			=> $addArr['userName'],
					 	'imageName' 		=> $addArr['imageName'],
						'salary' 			=> $addArr['salary'],
						'active'			=> 0,
						'imagePath' 		=> base_url().'uploads/employee/',
						'businessPhoneCode' => $addArr['countryCode'],
						'businessPhone'     => $addArr['businessPhone'],						
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_employee_address($addArr)
	{
		$insertOpt = array(
						'addressLine1'		 => $addArr['street'],
						'city' 			 	 => $addArr['cityId'],
						'state' 			 => $addArr['stateId'],
						'country'  			 => $addArr['countryId'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_employee_addressTbl($employeeId,$addressId)
	{
		$insertOpt = array(
						'employeeId' 	 => $employeeId,
						'addressId' 	 => $addressId,
						'addressTypeId'  => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('employee_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_employee_role($organizationId,$employeeId,$roleId)
	{
		$insertOpt = array(
						'employeeId'     => $employeeId,
						'roleId'	     => $roleId,
						'organizationId' => $organizationId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_designation_role($organizationId,$code,$role)
	{
		
		$insertOpt	= array(
							'organizationId' => $organizationId,
							'code'			 => $code,
							'roleId'		 => $role,	
							'createDt'		 => date('Y-m-d H:i:s'),
							'lastModifiedDt' => date('Y-m-d H:i:s'),
							'lastModifiedBy' => $this->session->userdata('userId')
							);
	$this->db->insert('designation_role',$insertOpt);
	return $this->db->insert_id();
	}
	public function add_employee_designation($employeeId,$designationId)
	{
		
		$insertOpt	= array(
							'employeeId' 	=> $employeeId,
							'designationId'	=>	$designationId,
							'lastModifiedDt' => date('Y-m-d H:i:s'),
							'lastModifiedBy' => $this->session->userdata('userId')
							);
		$this->db->insert('employee_designation',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function user_phone_no($phoneNo)
	{
		$this->db->select('organization_type.Description AS organizationType ,organization.organizationTypeId,organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhoneCode,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.area,address.city,organization.isPointePay,organization.isPointeMart,employee.userName,employee.businessPhoneCode,organization.dropshipCentre,employee.requestStatus,area.area AS areaName');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId','left');
		$this->db->join('address','organization_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CORPADMIN','employee.businessPhone' => trim($phoneNo)));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function update_password($employeeId,$password)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('password' => password_encrypt($password)));
		return $this->db->affected_rows();
	}
	
	public function dropship_center_list()
	{
		$this->db->where('active',1);
		$result = $this->db->get('dropship_center');
		return $result->result();
	}
	
	public function dropship_details($dropCenterId)
	{
		$this->db->select('address.*,dropship_center.*');
		$this->db->from('dropship_center');
		$this->db->join('dropship_center_address','dropship_center_address.dropCenterId = dropship_center.dropCenterId','left');
		$this->db->join('address','address.addressId = dropship_center_address.addressId','left');
		$this->db->where('dropship_center.dropCenterId',$dropCenterId);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function retailer_user_details($organizationId)
	{
		$this->db->select('organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhoneCode,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.area,address.city,organization.isPointePay,organization.isPointeMart,employee.userName,employee.businessPhoneCode,organization.dropshipCentre,employee.requestStatus,area.area AS areaName,dropship_center.dropCenterName');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId','left');
		$this->db->join('address','organization_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CORPADMIN','organization.organizationId' => $organizationId));
		$result = $this->db->get()->row();
		return $result;
	}
	
}