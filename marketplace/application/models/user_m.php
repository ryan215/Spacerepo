<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function total_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('employee');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId ');
		$this->db->where('role.code in ("ADMIN" ,"SUPERADMIN")');
		$this->db->where(array(
							'employee.employeeId != ' => 2,
							'emp_role.active'         => 1,
							'employee.isDelete'       => 0,
						));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
		
	public function user_list($start=0,$limit='',$where='')
	{
		$this->db->select('employee.employeeId,employee.firstName,employee.middle,employee.lastName,employee.email,employee.imageName,emp_role.roleId');
		$this->db->from('employee');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId ');
		$this->db->where('role.code in ("ADMIN" ,"SUPERADMIN")');
		$this->db->where(array(
							'employee.employeeId != ' => 2,
							'emp_role.active'         => 1,
							'employee.isDelete'       => 0,
						));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('employee.firstName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function admin_user_details($employeeId)
	{
		$this->db->select('role.*,country.*,state.stateName,area.area,employee.active as blockstatus,address.*,employee.*');
		$this->db->from('employee');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId AND employee_address.active = 1','left');
		$this->db->join('emp_role','employee.employeeId=emp_role.employeeId');
		$this->db->join('role','emp_role.roleId=role.roleId');
		$this->db->join('address','employee_address.addressId = address.addressId AND employee_address.active = 1','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->where('role.code in ("ADMIN" ,"SUPERADMIN")');
		$this->db->where(array(
							'emp_role.active'     => 1,
							'employee.isDelete'   => 0,
							'employee.employeeId' => $employeeId
						));
		$result = $this->db->get()->row(); 
		return $result;
	}
	
	public function check_unique_employee_user($email) 
	{	
		$this->db->select('employeeId,email');
		$this->db->from('employee');
		$this->db->where(array('isDelete' => 0,'email' => $email));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function add_user_employee($addArr)
	{
		$insertOpt = array(
						'organizationId' 	=> 1,
						'email' 			=> $addArr['email'],
						'password' 			=> password_encrypt($addArr['password']),
						'middle'			=> $addArr['middleName'],
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'userName' 			=> $addArr['email'],
					 	'imageName' 		=> $addArr['imageName'],
						'imagePath' 		=> base_url().'uploads/admin/',
						'birthDay'  		=> $addArr['birthDate'],
						'createBy'			=> $this->session->userdata('userId'),
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->insert('employee',$insertOpt);
//		echo $this->db->last_query(); exit;
		return $this->db->insert_id();
	}
	
	public function add_user_address($addArr)
	{
		$insertOpt = array(
					 	'area' 			 => $addArr['areaId'],
						'state' 		 => $addArr['stateId'],
						'country'  		 => '154',
						'createBy'		 => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_user_employee_address($employeeId,$addressId)
	{
		$insertOpt = array(
						'employeeId' 	 => $employeeId,
						'addressId' 	 => $addressId,
						'addressTypeId'  => 1,
						'active'		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('employee_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function unactive_user_employee_address($employeeId)
	{
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where(array(
							'employeeId' 	 => $employeeId,
							'addressTypeId'  => 1,
							'active'		 => 1,
						));
		$this->db->update('employee_address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_user_employee_role($employeeId,$roleId)
	{
		$insertOpt = array(
						'employeeId' 	 => $employeeId,
						'roleId'  		 => $roleId,
						'organizationId' => 1,
						'active'		 => 1,
						'createBy'		 => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					 );
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function unactive_admin_roles($employeeId)
	{
		$updateOpt = array(
					 	'active' 		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where(array('employeeId' => $employeeId,'roleId != ' => 2));
		$this->db->update('emp_role',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function total_admin_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('employee');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId','left');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId ');
		$this->db->where('role.code in ("ADMIN" ,"SUPERADMIN")');
		$this->db->where(array(
							'employee.employeeid != ' => 2,
							//'employee_address.active' => 1,
							'emp_role.active'         => 1,
						));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function admin_user_list($start,$limit='',$where='')
	{
		$this->db->select('address.*,employee_address.*,emp_role.*,role.*,employee.*');
		$this->db->from('employee');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId','left');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId ');
		$this->db->where('role.code in ("ADMIN" ,"SUPERADMIN")');
		$this->db->where(array(
							'employee.employeeid != ' => 2,
							//'employee_address.active' => 1,
							'emp_role.active'         => 1,
						));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('employee.firstName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function add_admin_organization($addArr)
	{
		$insertOpt = array(
					 	'organizationTypeId' => $addArr['organizationTypeId'],
						'organizationName'   => $addArr['email'],
						'imageName'          => $addArr['image_name'],
						'imagePath'          => base_url().'uploads/admin/',
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('organization',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_admin_address($addArr)
	{
		/*if(!isset($addArr['state_id']))
		{
			$addArr['state_id']=0;
		}
		if(!isset($addArr['country_id']))
		{
			$addArr['country_id']=0;
		}*/
		$insertOpt = array(
					 	'state' 			 => $addArr['stateId'],
						'country'  			 => $addArr['country_id'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_admin_organization_address($organizationId,$addressId)
	{
		$insertOpt = array(
					 	'organizationId'	 => $organizationId,
						'addressId'  		 => $addressId,
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('organization_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_admin_employee($organizationId,$addArr)
	{
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'email' 			=> $addArr['email'],
						'password' 			=> password_encrypt($addArr['password']),
						'middle'			=>$addArr['middle_name'],
						'firstName' 		=> $addArr['first_name'],
						'lastName' 			=> $addArr['last_name'],
						'userName' 			=> $addArr['email'],
					 	'imageName' 		=> $addArr['image_name'],
						'imagePath' 		=> base_url().'uploads/admin/',
						'birthDay'  		=> $addArr['birth_date'],
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_admin_employee_address($employeeId,$addressId,$addressTypeId)
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
	
	public function add_cse_employee_address($employeeId,$addressId,$addressTypeId=1)
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
	
	public function add_admin_employee_roles($addArr)
	{
		$this->db->insert_batch('emp_role',$addArr); 
	}
	
	public function update_admin_address($addressId,$updateArr)
	{
		$updateOpt = array(
					 	'state' 			 => $updateArr['stateId'],
						'country'  			 => $updateArr['country_id'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_superadmin_user($employeeId,$addArr)
	{
		$updateOpt = array(
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'middle'			=> $addArr['middleName'],
					 	'imageName' 		=> $addArr['imageName'],
						'imagePath' 		=> base_url().'uploads/admin/',
						'birthDay'  		=> $addArr['birthDate'],
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );	
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_admin_employee($employeeId,$addArr)
	{
		$updateOpt = array(
						'firstName' 		=> $addArr['first_name'],
						'lastName' 			=> $addArr['last_name'],
						'middle'			=>	$addArr['middle_name'],
						'userName' 			=> $addArr['email'],
					 	'imageName' 		=> $addArr['image_name'],
						'imagePath' 		=> base_url().'uploads/admin/',
						'birthDay'  		=> $addArr['birth_date'],
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );	
		if($addArr['email'])	
		{
			$updateOpt['email'] = $addArr['email'];
		}
		
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function sign_in($email,$where='')
	{
		$this->db->select('*');
		$this->db->from('organization'); 
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->where('employee.email',$email);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function employee_role_list($employeeId)
	{
		$this->db->select('*');
		$this->db->from('emp_role');
		$this->db->join('role','emp_role.roleId = role.roleId');
		$this->db->where(array(
							'emp_role.employeeId' => $employeeId,
							'emp_role.active' 	  => 1
							));
		$result = $this->db->get();
		return $result->result();
	}
	public function employee_role_list_array($employeeId)
	{
		$this->db->select('GROUP_CONCAT(role.code) as roles');
		$this->db->from('emp_role');
		$this->db->join('role','emp_role.roleId = role.roleId');
		$this->db->where(array('emp_role.employeeId' => $employeeId,'emp_role.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function employee_role_list_delete($employeeId)
	{
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('emp_role',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function role_list($parent_id='')
	{
		if(!empty($parent_id))
		{
			$this->db->where('ParentroleId',$parent_id);
		}
		$result = $this->db->get('role');
		return $result->result(); 
	}
	
	public function block_unblock_user($employeeId,$status)
	{	
		$status = (bool)$status;
		$updateOpt = array(
						'active' 		 =>  $status,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );		
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function total_retailer_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where(array('role.code' => 'CORPADMIN'));
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
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_retailer_user_request($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','employee.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where('role.code','CORPADMIN');
		$this->db->where('(employee.requestStatus = 1 OR employee.requestStatus = 2)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if($this->session->userdata('userType')=='cse')
		{
			$this->db->where('csr_organization.employeeId',$this->session->userdata('userId'));
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_user_list($start,$limit='',$where='',$having='')
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode",false);
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
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
	
	public function retailer_user_request_list($start,$limit='',$where='',$having='')
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode",false);
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','employee.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where('role.code','CORPADMIN');
		$this->db->where('(employee.requestStatus = 1 OR employee.requestStatus = 2)');
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
		return $result;
	}
	
	public function retailer_user_details($organizationId)
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
		$this->db->where(array('role.code' => 'CORPADMIN','organization.organizationId' => $organizationId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function cse_details_of_retailer($organizationId)
	{
		$this->db->select('*');
		$this->db->from('csr_organization');
		$this->db->join('employee','csr_organization.employeeId = employee.employeeId');
		$this->db->where('csr_organization.organizationId',$organizationId);
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function retailer_check_email_phone($username)
	{
		$this->db->select('organization_type.Description AS organizationType ,organization.organizationId,organization.organizationName,organization.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.businessPhoneCode,employee.lastName,employee.resetPasswordCode,employee.active,employee.password,employee.passwordStatus,country.name AS countryName,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.area,address.state,address.city,role.code,employee.requestStatus,organization.isPointepay,organization.isPointemart');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId','left');
		$this->db->join('address','organization_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CORPADMIN'));
		$this->db->where('(employee.userName = "'.$username.'" OR employee.businessPhone="'.$username.'" or employee.email="'.$username.'"  )');
		$result = $this->db->get()->row();
		return $result;
	}
	public function pointepay_retailer_check_email_phone($username)
	{
		$this->db->select('organization_type.Description AS organizationType ,organization.organizationId,organization.organizationName,organization.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.businessPhoneCode,employee.lastName,employee.resetPasswordCode,employee.active,employee.password,employee.passwordStatus,country.name AS countryName,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.area,address.state,address.city,role.code,employee.requestStatus,organization.isPointepay,organization.isPointemart');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId','left');
		$this->db->join('address','organization_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CORPADMIN'));
		$this->db->where('(employee.requestStatus = 0 OR employee.requestStatus = 3)'); 
		$this->db->where('(employee.userName = "'.$username.'" OR employee.businessPhone="'.$username.'" or employee.email="'.$username.'"  )');
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function add_retailer_organization($addArr,$parentOrganizationId='')
	{
		$insertOpt = array(
					 	'organizationTypeId' => $addArr['organizationTypeId'],
						'organizationName'   => $addArr['businessName'],
						'dropshipCentre'     => $addArr['dropshipCentre'],
						'isPointeMart'		 => $addArr['isPointeMart'],
						'isPointePay' 		 => $addArr['isPointePay'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
						'verificationPref'   => $addArr['OTP'],
					 );
		if(!empty($parentOrganizationId))
		{
			$insertOpt['parentOrganizationId'] = $parentOrganizationId;
		}
		$this->db->insert('organization',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function update_retailer_organization($organizationId,$updateArr)
	{
		$updateOpt = array(
					 	'organizationTypeId' => $updateArr['organizationTypeId'],
						'organizationName'   => $updateArr['businessName'],
						'isPointeMart'       => $updateArr['isPointeMart'],
						'isPointePay'        => $updateArr['isPointePay'],
						'dropshipCentre'        => $updateArr['dropshipCentre'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_retailer_address($addArr)
	{
		$insertOpt = array(
						'addressLine1'		 => $addArr['street'],
						'area' 			 	 => $addArr['areaId'],
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
	
	public function update_retailer_address($addressId,$updateArr)
	{
		$updateOpt = array(
						'addressLine1'		 => $updateArr['street'],
						'city' 			 	 => $updateArr['cityId'],
						'area' 			 	 => $updateArr['areaId'],
						'state' 			 => $updateArr['stateId'],
						'country'  			 => $updateArr['countryId'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_cse_address($addArr)
	{
		$insertOpt = array(
						'state' 			 => $addArr['stateId'],
						'country'  			 => $addArr['countryId'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function update_cse_address($addressId,$addArr)
	{
		$updateOpt = array(
						'state' 			 => $addArr['stateId'],
						'country'  			 => $addArr['countryId'],
						'city'  			 => $addArr['cityId'],
						'area'   			 => $addArr['areaId'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_retailer_organization_address($organizationId,$addressId)
	{
		$insertOpt = array(
					 	'organizationId'	 => $organizationId,
						'addressId'  		 => $addressId,
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('organization_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_employee($organizationId,$addArr)
	{
		$userId = $this->session->userdata('userId');
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'email' 			=> $addArr['email'],
						'password' 			=> password_encrypt($addArr['password']),
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'middle' 			=> $addArr['middleName'],
						'userName' 			=> $addArr['email'],
					 	'imageName' 		=> $addArr['imageName'],
						'imagePath' 		=> base_url().'uploads/retailer/',
						'businessPhoneCode' => $addArr['countryCode'],
						'businessPhone'     => $addArr['businessPhone'],						
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $userId,
					 );
		if(($userId)&&(($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin')))
		{
			$insertOpt['requestStatus'] = 0;
			$insertOpt['active'] = 1;
		}
		elseif($this->session->userdata('userType')=='cse')
		{
			$insertOpt['requestStatus'] = 2;
			$insertOpt['active'] = 0;
		}
		else
		{
			$insertOpt['requestStatus'] = 1;
			$insertOpt['active'] = 0;
		}
		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_employee_pointepay($organizationId,$addArr)
	{
		$userId = $this->session->userdata('userId');
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'email' 			=> $addArr['email'],
						'password' 			=> password_encrypt($addArr['password']),
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'middle' 			=> $addArr['middleName'],
						'userName' 			=> $addArr['userName'],
					 	'imageName' 		=> $addArr['imageName'],
						'imagePath' 		=> base_url().'uploads/retailer/',
						'businessPhoneCode' => $addArr['countryCode'],
						'businessPhone'     => $addArr['businessPhone'],
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $userId,
						'passwordStatus'	=>	$addArr['passwordStatus']
					 );
			 $insertOpt['requestStatus'] = 1;
			

		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}

	public function update_retailer_employee($employeeId,$updateArr)
	{
		$updateOpt = array(
						'firstName' 		=> $updateArr['firstName'],
						'lastName' 			=> $updateArr['lastName'],
						'middle' 			=> $updateArr['middleName'],
					 	'imageName' 		=> $updateArr['imageName'],
						'email' 			=> $updateArr['email'],
						'businessPhoneCode' => $updateArr['countryCode'],
						'businessPhone'		=> $updateArr['businessPhone'],
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_retailer_employee_address($employeeId,$addressId)
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
	
	public function add_retailer_employee_role($employeeId,$organizationId)
	{
		$insertOpt = array(
						'employeeId'     => $employeeId,
						'roleId'	     => 15,
						'organizationId' => $organizationId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_cse_employee_role($employeeId,$organizationId)
	{
		$insertOpt = array(
						'employeeId'     => $employeeId,
						'roleId'	     => 6,
						'organizationId' => $organizationId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_retailer_for_cse($organizationId,$employeeId)
	{
		$insertOpt = array(
						'organizationId' => $organizationId,
						'employeeId'     => $employeeId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('csr_organization',$insertOpt);
		return $this->db->insert_id();
	}
	
	
	//	Function for add user in user table for superadmin,admin,marketing,customer user
	public function add_user($email,$password,$user_type,$insertRole,$status=1,$verifycode='')
	{
		$insertOpt = array(
						'table' => 'users',
						'data'  => array(
									'email'              => $email,
									'password'           => $password,
									'user_type'          => $user_type,
									'permission'         => $insertRole,
									'status'             => $status,
									'verify_code'        => $verifycode,									
									'created_by' 		 => $this->session->userdata('userId'),
									'created_time'		 => $this->currentTimestamp,
									'last_modified_by'	 => $this->session->userdata('userId'),
									'last_modified_date' => $this->currentTimestamp,
									'block_status'       => 1,
									),
					  );
		if($user_type=='shipping_vendor')
		{
			$insertOpt['data']['block_status'] = 0;
		}
		$user_id = $this->common_model->customInsert($insertOpt);
		return $user_id;
	}
	
	//	Function for add user profile in profile table for superadmin,marketing,customer user
	public function add_user_profile($user_id,$first_name,$last_name,$gender='',$birth_date='',$phone_no='',$country_id=0,$state_id=0,$city_id=0,$zone_id=0,$area_id=0,$street='',$image='',$comment='',$business_ph_no='',$business_owner_name='',$srid='',$bank_name='',$account_name='',$account_number='',$branch_add='',$bussiness_name='')
	{
		$insertOpt = array(
						'table' => 'profile',
						'data'  => array(
									'user_id'     		  => $user_id,
									'first_name'  		  => $first_name,
									'last_name'   		  => $last_name,
									'gender'      		  => $gender,
									'birth_date'  		  => $birth_date,
									'phone_no'    		  => $phone_no,
									'country_id'  	 	  => $country_id,
									'state_id'    		  => $state_id,
									'city_id'     		  => $city_id,
									'zone'        	 	  => $zone_id,
									'area'        		  => $area_id,
									'street'      		  => $street,
									'comment'     	      => $comment,
									'image'       		  => $image,
									'business_ph_no'      => $business_ph_no,
									'business_owner_name' => $business_owner_name,
									'srid'				  => $srid,
									'bank_name'			  => $bank_name,
									'account_name'		  => $account_name,
									'account_number'	  => $account_number,
									'branch_address'	  => $branch_add,
									'bussiness_name'	  => $bussiness_name,
 									'last_modified_date'  => $this->currentTimestamp,
									'last_modified_by'	  => $this->session->userdata('userId'),
								),
					);
		$profile_id = $this->common_model->customInsert($insertOpt);
		return $profile_id;
	}
	
	//	Function for sign in for superadmin,admin,marketing,customer user
	
	
	public function add_admin_user_profile($user_id,$first_name,$last_name,$gender,$birth_date,$country_id,$state_id,$image_name,$comment)
	{
		$insertOpt = array(
						'table' => 'profile',
						'data'  => array(
									'user_id'     		  => $user_id,
									'first_name'  		  => $first_name,
									'last_name'   		  => $last_name,
									'gender'      		  => $gender,
									'birth_date'  		  => $birth_date,
									'country_id'  	 	  => $country_id,
									'state_id'    		  => $state_id,
									'comment'     	      => $comment,
									'image'       		  => $image_name,
									'last_modified_date'  => $this->currentTimestamp,
									'last_modified_by'	  => $this->session->userdata('userId'),
								),
					);
		$profile_id = $this->common_model->customInsert($insertOpt);
		return $profile_id;
	}
	
	//	Function for add shipping user profile
	public function add_shipping_user_profile($user_id,$addArr)
	{
		$insertOpt = array(
						'table' => 'profile',
						'data'  => array(
									'user_id'     		  => $user_id,
									'first_name'  		  => $addArr['first_name'],
									'last_name'   		  => $addArr['last_name'],
									'phone_no'    		  => $addArr['phone_no'],
									'country_id'  	 	  => $addArr['country_id'],
									'street'      		  => $addArr['business_address'],
									'business_ph_no'      => $addArr['business_ph_no'],
									'bussiness_name'	  => $addArr['business_name'],
 									'last_modified_date'  => $this->currentTimestamp,
									'last_modified_by'	  => $this->session->userdata('userId'),
								),
					);
		$profile_id = $this->common_model->customInsert($insertOpt);
		return $profile_id;
	}
	
	public function add_shipping_vendor_details($user_id,$addArr)
	{
		$state_id = implode(",",$addArr['selctState_id']);
		$city_id  = implode(",",$addArr['selctCity_id']);
		$zone_id  = implode(",",$addArr['selctZone_id']);
		$area_id  = implode(",",$addArr['selctArea_id']);
		
		$insertOpt = array(
						'state_id'			 => $state_id,
						'city_id'  			 => $city_id,
						'zone_id'  			 => $zone_id,
						'area_id'  			 => $area_id,
						'shipping_vendor_id' => $user_id,
						'last_modified_by'   => $this->session->userdata('userId'),
						'last_modified_time' => $this->currentTimestamp,
					 );	
		$this->db->insert('sa_shipping_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_document_details($user_id,$document_name='')
	{
		$insertOpt = array(
						'document_name'		 => $document_name,
						'created_by' 		 => $user_id,
						'last_modified_by'   => $this->session->userdata('userId'),
						'last_modified_time' => $this->currentTimestamp,
					 );	
		$this->db->insert('document_details',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_excel_file_data($shippingOrgId,$sheetData)
	{
		$insertArr = array(); 
		foreach($sheetData as $key=>$val)
		{	
			if($key>2)
			{
				$this->custom_log->write_log('custom_log','key '.$key.' and value is '.print_r($val,true));
				
				$fromZip = 1;
				$dropShipCenterName = trim($val['A']);
				
				$this->db->select('*');
				$this->db->from('dropship_center');
				$this->db->where('trim(dropCenterName)',$dropShipCenterName);
				$drpCntrDet = $this->db->get()->row();
				$this->custom_log->write_log('custom_log','Dropship details is '.print_r($drpCntrDet,true));
				
				if(!empty($drpCntrDet))
				{
					$fromZip = $drpCntrDet->dropCenterId;
				}
								
				$expStr = explode(',',$val['D']);
				if(!empty($expStr))
				{
					foreach($expStr as $toVal)
					{
						$stateName = trim(strtolower($val['B']));
						$areaName  = trim(strtolower($val['C']));
						$cityName  = trim(strtolower($toVal));
						$this->db->select('*');
						$this->db->from('zip');
						$this->db->join('area','zip.area = area.areaId');
						$this->db->join('state','zip.stateId = state.stateId');
						$this->db->join('country','state.countryId = country.countryId');
						$this->db->where('(zip.countryId = 154 AND trim(lcase(zip.city)) = "'.$cityName.'" AND trim(lcase(area.area)) = "'.$areaName.'" AND trim(lcase(state.stateName)) = "'.$stateName.'")');
						$res = $this->db->get()->row();
						
						$this->custom_log->write_log('custom_log','last query is '.$this->db->last_query());
						$this->custom_log->write_log('custom_log','and result is '.print_r($res,true));
						if(!empty($res))
						{
							$this->db->where(array(
												'shippingOrgId'    => $shippingOrgId,
												'trim(fromZip)'    => trim($fromZip),
												'trim(toZip)' 	   => trim($res->zipId),
												'trim(fromWeight)' => trim($val['E']),
												'trim(toWeight)'   => trim($val['F']),
												'active'		   => 1,
											));
							$alreadyRes = $this->db->get('shipping_rate')->result();
							$this->custom_log->write_log('custom_log','Already result is '.print_r($alreadyRes,true));
							if(!empty($alreadyRes))
							{
								foreach($alreadyRes as $alreadyRow)
								{
									$this->db->where('shippingRateId',$alreadyRow->shippingRateId);
									$this->db->update('shipping_rate',array('active' => 0,'lastModifiedDt' => date('Y-m-d H:i:s'),'lastModifiedBy' => $this->session->userdata('userId')));
									$this->custom_log->write_log('custom_log','deactivated id is '.$alreadyRow->shippingRateId);
								}							
							}
						
							$insertArr = array(
												'shippingOrgId'	 => $shippingOrgId,
												'fromZip' 		 => $fromZip,
												'toZip' 		 => $res->zipId,
												'fromWeight' 	 => $val['E'],
												'toWeight' 		 => $val['F'],
												'amount' 	     => $val['G'],
												'ETA'		 	 => $val['H'],
												'active'		 => 1,
												'createDt'		 => date('Y-m-d H:i:s'),
												'lastModifiedDt' => date('Y-m-d H:i:s'),
												'lastModifiedBy' => $this->session->userdata('userId'),	
											);
							$this->db->insert('shipping_rate',$insertArr);
							$shippingRateIdNew = $this->db->insert_id();
							$this->custom_log->write_log('custom_log','inserted shipping rate id is '.$shippingRateIdNew);	
						}
					}
				}
			}
		}
	}
	
	//	Function for add session in database at login time
	public function add_login_user_session($session_id,$user_id)
	{
		$time  	   = $this->currentTimestamp;
		$userType  = $this->session->userdata('userType');
		$userEmail = $this->session->userdata('userEmail');
		$userName  = $this->session->userdata('userName');
		$query = "INSERT INTO 
						audit_trail 
						(session_id,ip_address,user_agent,last_activity,login_time,user_data,user_id,user_type,user_email,user_name) 
				  SELECT 
						session_id,ip_address,user_agent,last_activity,'".$time."',user_data,$user_id,'".$userType."','".$userEmail."','".$userName."'
				  FROM
						ci_sessions
				  WHERE
						ci_sessions.session_id = '".$session_id."'
				";
		$this->common_model->customQuery($query,false,true);
	}
	
	
	
	public function user_name_email($user_id)	
	{
		$getOpt = array(
					'select' => 'users.email,profile.first_name,profile.last_name',
					'table'  => 'users',					
					'join'   => array('profile' => 'users.user_id = profile.user_id'),
					'where'  => array('users.user_id' => $user_id),
					'single' => true
				  );
		$result = $this->common_model->customGet($getOpt);
		return $result;
	}
	
	public function user_email($email)
	{
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('email',$email);
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function check_email_exists($userId,$email)
	{
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where(array('email' => $email,'employeeId !=' => $userId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function user_update_reset_code($employeeId,$resetPasswordCode)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('password' => password_encrypt($resetPasswordCode)));
		return $this->db->affected_rows();
	}
	
	public function update_reset_code($email,$resetPasswordCode)
	{
		$this->db->where('email',$email);
		//$this->db->update('employee',array('resetPasswordCode' => $resetPasswordCode));
		$this->db->update('employee',array('password' => password_encrypt($resetPasswordCode)));
		return $this->db->affected_rows();
	}
	
	public function check_retailer_email_exists($email)
	{
		$getOpt = array(
					'table'  => 'retailer_request',
					'select' => 'email',
					'where'  => array('email' => $email),
					'single' => true
				  );
		$result = $this->common_model->customGet($getOpt);
		return $result;
	}
	
	
	
	public function total_market_user(){
		
		$getOpt = array(
				  	 'table'  => 'users',
					 'select' => 'COUNT(*) AS total',
					 'join'   => array('profile' => 'users.user_id = profile.user_id'),
					 'where'  => array('users.user_type' => 'marketing'),
					 'single' => true					
				  );
		$result = $this->common_model->customGet($getOpt);
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	
		
		
		}
	
	public function total_market_user_where($where=''){
		
		$sql = "SELECT 
						COUNT(*) AS total
					FROM
						users
					INNER JOIN
						profile
					ON
						users.user_id = profile.user_id					
					WHERE
						users.user_type = 'marketing'						
					".$where;		
		$result = $this->common_model->customQuery($sql,'single');
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	
	}
		
	public function market_user_list($start=0,$limit='',$where=''){
		
		
		$limitstr = '';
		if(!empty($limit))
		{
			$limitstr = " LIMIT $start,$limit";
		}
		
		$sql = "SELECT 
					users.*,
					profile.*,
					CONCAT(profile.first_name,' ',profile.last_name) AS username
				FROM
					users
				INNER JOIN
					profile
				ON
					users.user_id = profile.user_id					
				WHERE
					users.user_type = 'marketing'
				".$where." 
				ORDER BY
					users.user_id
				DESC
				".$limitstr;
				
		return $this->common_model->customQuery($sql);
	
		
		}
	
	public function user_details($user_id)
	{
		$sql = "SELECT 
					users.*,
					profile.*,
					country.country_name,
					states.state_name,
					city.city_name,
					zone.zone_name,
					area.area_name,
					(SELECT
						CONCAT(a.first_name,' ',a.last_name)
					FROM
						profile AS a
					INNER JOIN
						users AS b
					ON
						a.user_id = b.user_id
					WHERE
						a.user_id = profile.last_modified_by
					)
					AS modified_by
				FROM
					users
				INNER JOIN
					profile
				ON
					users.user_id = profile.user_id
				INNER JOIN
					country
				ON
					profile.country_id = country.country_id
				INNER JOIN
					states
				ON
					profile.state_id = states.state_id				
				INNER JOIN
					city
				ON
					profile.city_id = city.city_id
				INNER JOIN
					zone
				ON
					profile.zone = zone.zone_id
				INNER JOIN
					area
				ON
					profile.area = area.area_id					
				WHERE
					users.user_id = $user_id					
				";
		return $this->common_model->customQuery($sql,"single");
	}
	
	
	
	
		
	
	
	
	public function update_retailer_profile($user_id,$first_name,$last_name,$phone_no,$country_id,$state_id,$city_id,$zone_id,$area_id,$street,$comment,$businessPhoneNo,$businessOwnerName,$bank_name='',$account_name='',$account_number='',$branch_add='',$image='')
	{
		$updateOpt = array(
						'table' => 'profile',
						'where' => array('user_id' => $user_id),
						'data'  => array(			
										'first_name'		  => $first_name,
										'last_name'  		  => $last_name,
										'phone_no'   		  => $phone_no,
										'country_id' 		  => $country_id,
										'state_id'   		  => $state_id,
										'city_id'    		  => $city_id,
										'zone' 		 		  => $zone_id,
										'area' 		 		  => $area_id,
										'street'     		  => $street,
										'comment'    		  => $comment, 
										'business_ph_no' 	  => $businessPhoneNo,
										'business_owner_name' => $businessOwnerName,
										'bank_name'			  => $bank_name,
										'account_name'		  => $account_name,
										'account_number'	  => $account_number,
										'branch_address'	  => $branch_add,
										'image'				  => $image,
										'last_modified_date'  => $this->currentTimestamp,
										'last_modified_by'	  => $this->session->userdata('userId'),
									),
					);
		return $this->common_model->customUpdate($updateOpt);
	}
	
	
	
	public function retailer_request_declined($request_id,$comment='')
	{
		$updateOpt = array(
						'table' => 'retailer_request',
						'data'  => array(
										'status'             => 'Declined',
										'comment' 			 => $comment,
										'last_modified_by'   => $this->session->userdata('userId'),
										'last_modified_time' => $this->currentTimestamp
									),
						'where' => array('retailer_request_id' => $request_id),
					 );
		return $this->common_model->customUpdate($updateOpt);
	}
	
	public function retailer_request_accepted($request_id)
	{
		$updateOpt = array(
						'table' => 'retailer_request',
						'data'  => array(
										'status' 			 => 'Accepted',
										'last_modified_by'   => $this->session->userdata('userId'),
										'last_modified_time' => $this->currentTimestamp
									),
						'where' => array('retailer_request_id' => $request_id),
					);
		return $this->common_model->customUpdate($updateOpt);
	}
	
	
	
	public function add_billing_address($addSArr)
	{
		$insertOpt = array(
					 	'firstName'   => $addSArr['firstName'],
						'lastName'  => $addSArr['lastName'],
						'addressLine1' 		 	 => $addSArr['address1'],
						'address_Line2' 		 => $addSArr['address2'],
						'phone' 		 => $addSArr['phoneNo'],
						'zip' 		 => $addSArr['zipcode'],
						'state' 		 => $addSArr['stateId'],
						'city' 	     => $addSArr['cityId'],
						'country'	=> $addSArr['countryId'],
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();					 
	}
	public function update_customer_address($addressId,$addSArr)
	{
		$insertOpt = array(
					 	'firstName'   => $addSArr['firstName'],
						'lastName'  => $addSArr['lastName'],
						'addressLine1' 		 	 => $addSArr['address1'],
						'address_Line2' 		 => $addSArr['address2'],
						'phone' 		 => $addSArr['phoneNo'],
						'zip' 		 => $addSArr['zipcode'],
						'state' 		 => $addSArr['stateId'],
						'city' 	     => $addSArr['cityId'],
						'country'	=> $addSArr['countryId'],
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$insertOpt);
		return $this->db->affected_rows();
	}
	
	public function add_shipping_address($addSArr)
	{
		$insertOpt = array(
					 	'addressLine1'   => $addSArr['shipping_address'],
						'address_Line2'  => $addSArr['shipping_address2'],
						'city' 		 	 => $addSArr['shipping_city_id'],
						'state' 		 => $addSArr['shipping_state_id'],
						'country' 		 => $addSArr['shipping_country_id'],
						'phone' 		 => $addSArr['shipping_phone_no'],
						'company' 		 => $addSArr['shipping_company'],
						'landMark' 	     => $addSArr['additionalInfo'],
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();					 
	}
	
	public function add_customer_address($customerId,$addressId)
	{
		$insertOpt = array(
					 	'customerId'     => $customerId,
						'addressId'      => $addressId,
						'addressTypeId'  => 4,
						'active' 		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('customer_address',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_customer_shipping_address_type($customerId,$addressId)
	{
		$insertOpt = array(
					 	'customerId'     => $customerId,
						'addressId'      => $addressId,
						'addressTypeId'  => 3,
						'active' 		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('customer_address',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function update_customer_shipping_address_type($customerId,$addressId)
	{
		$this->db->where( array(
					 	'customerId'     => $customerId,
						'addressId'      => $addressId,));
		$insertOpt = array(
					 	'active' 		 => 1,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->update('customer_address',$insertOpt);
		return $this->db->affected_rows();
	}
	
	public function user_billing_details($userId)
	{
		$this->db->select('address.*,customer.firstName,customer.lastName,customer.phone AS customerPhone');
		$this->db->from('customer');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','address.addressId = address.addressId');
		$this->db->where(array('customer_address.active' => 1,'customer_address.addressTypeId' => 4,'customer_address.customerId' => $userId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function customer_user_details_firstBil($userId)
	{
		$this->db->select('customer.firstName,customer.lastName,customer.phone,address.addressLine1,address.address_Line2,address.zip,address.state,address.city,country.name AS countryName,state.stateName,zip.city AS cityName');
		$this->db->from('customer');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('zip','address.city = zip.zipId');
		$this->db->where(array('customer_address.active' => 1,'customer_address.addressTypeId' => 1,'customer_address.customerId' => $userId));
		$result = $this->db->get();
		return $result->row();
	}
	
	
	public function change_customer_billing_status($customerId)
	{
		$updateOpt = array(
					 	'active' 		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->where(array('active' => 1,'customerId' => $customerId,'addressTypeId' => 4));
		$this->db->update('customer_address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	
	public function add_shipping_address_type($customerId,$addressId)
	{
		$insertOpt = array(
					 	'customerId'     => $customerId,
						'addressId'      => $addressId,
						'addressTypeId'  => 3,
						'active' 		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('customer_address',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function user_shipping_details($userId)
	{
		$this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
		$this->db->from('address');
		$this->db->join('customer_address','address.addressId = customer_address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId');
		$this->db->where(array('customer_address.active' => 1,'customer_address.addressTypeId' => 3,'customer_address.customerId' => $userId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function change_customer_shipping_status($customerId)
	{
		$updateOpt = array(
					 	'active' 		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->where(array('active' => 1,'customerId' => $customerId,'addressTypeId' => 3));
		$this->db->update('customer_address',$updateOpt);
		return $this->db->affected_rows();
	}

	public function change_password($userId,$password)
	{
		$this->db->where('employeeId',$userId);
		$this->db->update('employee',array('password' => $password));
		return $this->db->affected_rows();
	}
	
	public function check_old_password($userID,$password)
	{
		$this->db->where( array('employeeId' => $userID,'password' => $password));
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function total_number_of_users()
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('users');
		$this->db->join('profile','users.user_id = profile.user_id');
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_cse_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId','left');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where('role.code','CUSTOMERSERVICE');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	
	}	
	
	public function cse_user_list($start=0,$limit='',$where='')
	{
		$this->db->select('organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.firstName,employee.middle,employee.lastName,employee.imageName,country.name AS countryName,state.stateName');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId','left');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where('role.code','CUSTOMERSERVICE');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('employee.firstName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function cse_user_details($employeeId)
	{
		$this->db->select('organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.firstName,employee.middle,employee.lastName,employee.imageName,employee.birthDay,employee.active,country.name AS countryName,state.stateName,address.country,address.state,address.city,address.addressId,address.addressLine1,zip.city AS cityName,area.area AS areaName');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId','left');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CUSTOMERSERVICE','employee.employeeId' => $employeeId));
		$result = $this->db->get()->row();
		return $result;
	}
		
	
	public function admin_user_update($user_id,$insertRole)
	{
		$updateOpt = array(
						'table' => 'users',
						'data'  => array(
										'permission'         => $insertRole,
										'last_modified_date' => $this->currentTimestamp,
										'last_modified_by'   => $this->session->userdata('userId')
									),
						'where' => array('user_id' => $user_id )
					);
		return $this->common_model->customUpdate($updateOpt);
	}
	
	public function admin_update_profile($user_id,$first_name,$last_name,$gender,$birth_date,$comment,$image_name,$country_id=0,$state_id=0)
	{
		$updateOpt = array(
						'table' => 'profile',
						'data'  => array(
										'first_name'  		 => $first_name,
										'last_name'   		 => $last_name,
										'gender'      		 => $gender,
										'birth_date'  		 => $birth_date,
										'comment'     		 => $comment,
										'image'				 => $image_name,
										'state_id'     		 => $state_id,
										'country_id'		 => $country_id,
										'last_modified_date' => $this->currentTimestamp,
										'last_modified_by'	 => $this->session->userdata('userId'),
									),
						'where' => array('user_id' => $user_id)
					);
		return $this->common_model->customUpdate($updateOpt);
	}
	
	
	
	public function total_retailer_created_by_admin()
	{
		$getOpt = array(
						'table'  => 'users',
						'select' => 'COUNT(*) AS total',
						'join'   => array('profile' => 'users.user_id = profile.user_id'),
						'where'  => array(
										'users.user_type'  => 'retailer',
										//'users.created_by' => $this->session->userdata('userId'),
										'users.created_by' => $this->session->userdata('userId'),
									),
						'single' => true
					);
		
		$result = $this->common_model->customGet($getOpt);
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_retailer_from_signup()
	{
		$getOpt = array(
						'table'  => 'users',
						'select' => 'COUNT(*) AS total',
						'join'   => array('profile' => 'users.user_id = profile.user_id'),
						'where'  => array(
										'users.user_type'  => 'retailer',
										'users.created_by' => 0,
									),
						'single' => true
					);
		
		$result = $this->common_model->customGet($getOpt);
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	
	
	public function total_admin_login_data()
	{
		$getOpt = array(
						'table'  => 'audit_trail',
						'select' => 'COUNT(*) AS total',
						'where'  => array('user_type' => 'admin'),
						'single' => true
					);
		$result = $this->common_model->customGet($getOpt);			
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_admin_login_data_where($where='')
	{
		$sql = "SELECT 
					COUNT(*) AS total 
				FROM 
					audit_trail 
				WHERE
					audit_trail.user_type = 'admin'
				".$where;
				
		$result = $this->common_model->customQuery($sql,'single');
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function admin_login_data($start,$limit='',$where='')
	{
		$limitStr = '';
		if(!empty($limit))
		{
			$limitStr = "LIMIT $start,$limit";
		}
		
		$sql = "SELECT * FROM audit_trail WHERE user_type = 'admin' ".$where." ORDER BY login_time DESC ".$limitStr;
		$result = $this->common_model->customQuery($sql);
		return $result;
	}
	
	public function total_retailer_login_data()
	{
		$getOpt = array(
						'table'  => 'audit_trail',
						'select' => 'COUNT(*) AS total',
						'where'  => array('user_type' => 'retailer'),
						'single' => true
					);
		$result = $this->common_model->customGet($getOpt);			
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_retailer_login_data_where($where='')
	{
		$sql = "SELECT 
					COUNT(*) AS total 
				FROM 
					audit_trail 
				WHERE
					audit_trail.user_type = 'retailer'
				".$where;
				
		$result = $this->common_model->customQuery($sql,'single');
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_login_data($start,$limit='',$where='')
	{
		$limitStr = '';
		if(!empty($limit))
		{
			$limitStr = "LIMIT $start,$limit";
		}
		
		$sql = "SELECT * FROM audit_trail WHERE user_type = 'retailer' ".$where." ORDER BY login_time DESC ".$limitStr;
		$result = $this->common_model->customQuery($sql);
		return $result;
	}
	
	public function total_customer_login_data()
	{
		$getOpt = array(
						'table'  => 'audit_trail',
						'select' => 'COUNT(*) AS total',
						'where'  => array('user_type' => 'customer'),
						'single' => true
					);
		$result = $this->common_model->customGet($getOpt);			
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_customer_login_data_where($where='')
	{
		$sql = "SELECT 
					COUNT(*) AS total 
				FROM 
					audit_trail 
				WHERE
					audit_trail.user_type = 'customer'
				".$where;
				
		$result = $this->common_model->customQuery($sql,'single');
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function customer_login_data($start,$limit='',$where='')
	{
		$limitStr = '';
		if(!empty($limit))
		{
			$limitStr = "LIMIT $start,$limit";
		}
		
		$sql = "SELECT * FROM audit_trail WHERE user_type = 'customer' ".$where." ORDER BY login_time DESC ".$limitStr;
		$result = $this->common_model->customQuery($sql);
		return $result;
	}
		
	
	
	public function get_shipping_agent($userID)
	{
		$getOpt = array(
						'table' => 'sa_shipping_address', 
						'where' => array('shipping_agent_id' => $userID ),
						'join' => array('area' => 'area.area_id = sa_shipping_address.area_id'),
					);
		return $this->common_model->customGet($getOpt);
	}
	
	public function total_unblock_users()
	{
		$getOpt = array(
						'table'  => 'users',
						'select' => 'COUNT(*) AS total',
						'join'   => array('profile' => 'users.user_id = profile.user_id'),
						'single' => true,
						'where'  => array('block_status' => 1)
					);
		
		$result = $this->common_model->customGet($getOpt);
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_block_users()
	{
		$getOpt = array(
						'table'  => 'users',
						'select' => 'COUNT(*) AS total',
						'join'   => array('profile' => 'users.user_id = profile.user_id'),
						'single' => true,
						'where'  => array('block_status' => 0)
					);
		
		$result = $this->common_model->customGet($getOpt);
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function change_email($userId,$email)
	{
		$this->db->where('employeeId',$userId);
		$this->db->update('employee',array('email' => $email));
		return $this->db->affected_rows();
	}
	
	public function reset_password_details($userId,$resetPasswordCode)
	{
		$this->db->where(array('employeeId' => $userId,'resetPasswordCode' => $resetPasswordCode));
		$result = $this->db->get('employee')->row();
		return $result;
	}
	
	public function update_reset_password($userId,$newPassword)
	{
		$updateOpt = array(
						'password' => password_encrypt($newPassword),
						'resetPasswordCode' => '',
					);
		$this->db->where('employeeId',$userId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_admin_own_employee($employeeId,$addArr)
	{
		$updateOpt = array(
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'middle'			=>	$addArr['middle'],
					 	'imageName' 		=> $addArr['imageName'],
						'birthDay'  		=> $addArr['birthDay'],
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );		
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_admin_own_address($addressId,$addArr)
	{
		$updateOpt = array(
						'state' 		=> $addArr['stateId'],
						'country' 			=> $addArr['countryId'],
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );		
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function organization_type_list()
	{
		$this->db->order_by('Description','ASC');
		$result = $this->db->get('organization_type');
		return $result->result();
	}
	
	public function add_cse_employee($organizationId,$addArr)
	{		
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'email' 			=> $addArr['email'],
						'password' 			=> password_encrypt($addArr['password']),
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'middle' 			=> $addArr['middleName'],
					 	'imageName' 		=> $addArr['imageName'],
						'userName' 			=> $addArr['email'],
						'active'			=> 1,
						'imagePath' 		=> base_url().'uploads/cse/',
						'birthDay'			=> $addArr['birthDay'],
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function update_cse_employee($employeeId,$updateArr)
	{		
		$updateOpt = array(
						'firstName' 		=> $updateArr['firstName'],
						'lastName' 			=> $updateArr['lastName'],
						'middle' 			=> $updateArr['middleName'],
					 	'imageName' 		=> $updateArr['imageName'],
						'birthDay'			=> $updateArr['birthDay'],
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function check_business_phone_exits($employeeId,$businessPhone)
	{
		$this->db->where(array('employeeId !=' => $employeeId,'businessPhone' => $businessPhone));
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function check_email_exits($employeeId,$email)
	{
		$this->db->where(array('employeeId !=' => $employeeId,'email' => $email));
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function assign_cse_to_retailer($organizationId,$employeeId)
	{
		$insertOpt = array(
						'organizationId' => $organizationId,
						'employeeId' 	 => $employeeId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('csr_organization',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function update_assign_cse_to_retailer($organizationId,$employeeId)
	{
		$updateOpt = array(
						'employeeId' 	 => $employeeId,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('organizationId',$organizationId);
		$this->db->update('csr_organization',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function csr_organization_list($organizationId)
	{
		$this->db->where('organizationId',$organizationId);
		$result = $this->db->get('csr_organization')->row();
		return $result;
	}
	
	public function retailer_assign_to_cse_list($employeeId)
	{
		$this->db->select('csr_organization.*,employee.*,organization.organizationName');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','organization.organizationId = csr_organization.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('role.code' => 'CORPADMIN','csr_organization.employeeId' => $employeeId));
		$this->db->order_by('organization.organizationName','ASC');
		$result = $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function get_retailer_employee($employeeId)
	{
		$this->db->where('employeeId',$employeeId);
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function check_username_exits($employeeId,$userName)
	{
		if(!empty($employeeId))
		{
			$this->db->where('employeeId !=',$employeeId);
		}
		$this->db->where('userName',$userName);
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function check_businessPhone($businessPhone,$countryCode,$employeeId='')
	{
		if(!empty($employeeId))
		{
			$this->db->where('employeeId !=',$employeeId);
		}
		$this->db->where(array('businessPhone' => $businessPhone,'businessPhoneCode' => $countryCode));
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function check_phone($phone,$phoneCode)
	{
		$this->db->where(array('phone' => $phone,'phoneCode' => $phoneCode));
		$result = $this->db->get('newsletter');
		return $result->row();
	}
	
	public function update_retailer_username($employeeId,$updateArr)
	{
		$updateOpt = array(
						'userName' 	     => $updateArr['userName'],
						'password'       => password_encrypt($updateArr['password']),
						'passwordStatus' => 1,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function accept_retailer_request($employeeId)
	{
		$updateOpt = array(
						'requestStatus'  => 3,
						'active'         => 1,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function decline_retailer_request($employeeId)
	{
		$updateOpt = array(
						'requestStatus'  => 4,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function total_retailer_user_request_history($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','employee.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where('role.code','CORPADMIN');
		$this->db->where('(employee.requestStatus = 3 OR employee.requestStatus = 4)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if($this->session->userdata('userType')=='cse')
		{
			$this->db->where('csr_organization.employeeId',$this->session->userdata('userId'));
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function retailer_user_request_history_list($start,$limit='',$where='',$having='')
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode,employee.requestStatus,employee.lastModifiedDt",false);
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','employee.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where('role.code','CORPADMIN');
		$this->db->where('(employee.requestStatus = 3 OR employee.requestStatus = 4)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if($this->session->userdata('userType')=='cse')
		{
			$this->db->where('csr_organization.employeeId',$this->session->userdata('userId'));
		}
		if(!empty($having))
		{
			//$this->db->having($having);
		//	$this->db->having($having,'null',false);
		}
		$this->db->order_by('employee.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function requestRetailerOrg($organizationId)
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.verificationPref,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode,employee.requestStatus",false);
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','employee.employeeId = organization_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where(array('role.code' => 'CORPADMIN','employee.requestStatus' => 1,'organization.organizationId' => $organizationId));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function update_verified_request_status($employeeId)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('requestStatus' => 2));
		return $this->db->affected_rows();
	}
	
	
	public function update_otp($organizationId,$newOtp)
	{
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',array('verificationPref' =>$newOtp));
		return $this->db->affected_rows();
	}
	
	public function update_verification_phone($employeeId,$updateArr)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('businessPhoneCode' =>$updateArr['countryCode'],'businessPhone' => $updateArr['businessPhone']));
		return $this->db->affected_rows();
	}
	public function update_verification_phone_email($employeeId,$updateArr)
	{
		$data=array(
							'businessPhoneCode'	=>$updateArr['countryCode'],
							'businessPhone' 	=> $updateArr['businessPhone']
							);
		if(isset($updateArr['email']))
		{
			$data['email']=$updateArr['email'];
		}
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$data);
		return $this->db->affected_rows();
	}
	
	public function retailerRequestDetails($employeeId)
	{
		$this->db->select("organization_type.Description AS organizationType ,organization.organizationTypeId,organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.city,organization.isPointePay,organization.isPointeMart,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.businessPhoneCode",false);
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where(array('role.code' => 'CORPADMIN','employee.employeeId' => $employeeId,'requestStatus' => 2));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function getEmployeeRetailer($organizationId)
	{
		$this->db->select("organization_type.Description AS organizationType ,organization.organizationTypeId,organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.city,organization.isPointePay,organization.isPointeMart,(SELECT CONCAT(employee.firstName,' ',employee.lastName) FROM employee WHERE employee.employeeId = csr_organization.employeeId) AS cseName,employee.userName,employee.businessPhoneCode",false);
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('organization_address','organization.organizationId = organization_address.organizationId');
		$this->db->join('address','organization_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','organization.organizationId = csr_organization.organizationId','left');
		$this->db->where(array('role.code' => 'CORPADMIN','organization.organizationId' => $organizationId,));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function getEmployeeCSE($cseId)
	{
		$this->db->where('employeeId',$cseId);
		$result = $this->db->get('employee')->row();
		return $result;
	}
	
	public function retailer_skip_login($organizationId)
	{
		$this->db->select('organization_type.Description AS organizationType ,organization.organizationId,organization.organizationName,organization.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,employee.password,employee.passwordStatus,country.name AS countryName,state.stateName,zip.city AS cityName,address.addressLine1,address.country,address.state,address.city,role.code,employee.requestStatus');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId','left');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CORPADMIN','organization.organizationId' => $organizationId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function total_shipping_vendor_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'DELIVERYAGENT'));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_shipping_vendor_employee($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'SVE'));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function shipping_vendor_user_list($start,$limit='',$where='',$having='')
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode");
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'DELIVERYAGENT'));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('organization.organizationName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function shipping_vendor_employee_list($start,$limit='',$where='',$having='')
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode");
		$this->db->from('organization');
		//$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'SVE'));
		if(!empty($where))
		{
			$this->db->where($where);
		}
	//	$this->db->order_by('organization.organizationName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		
		
		return $result;
	}
	
	public function add_shipping_vendor_organization($addArr)
	{
		$insertOpt = array(
					 	'organizationTypeId' => 16,
						'organizationName'   => $addArr['businessName'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
						'verificationPref'   => $addArr['OTP'],
					 );
		$this->db->insert('organization',$insertOpt);
		return $this->db->insert_id();
	}	
	public function add_shipping_vendor_employee_organization($addArr,$parentOrganizationId='null')
	{
		$insertOpt = array(
					 	'organizationTypeId' => 16,
						'organizationName'   => $addArr['businessName'],
						'parentOrganizationId'=>	$parentOrganizationId,
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
						'verificationPref'   => $addArr['OTP'],
					 );
		$this->db->insert('organization',$insertOpt);
		return $this->db->insert_id();
	}
		public function delete_shipping_employee_dropship($organizationId,$dropshipId='')
	{
		$this->db->where('employeeId',$organizationId);
		if(!empty($dropshipId))
		{
			$this->db->where('dropCenterId',$dropshipId);
		}
		$this->db->delete('shipping_employee_dropship');
		return $this->db->affected_rows();
		
	}
	public function get_shipping_employee_dropship($employeeId,$dropshipId='')
	{
		$this->db->select('*');
		$this->db->from('shipping_employee_dropship');
		$this->db->join('dropship_center','dropship_center.dropCenterId = shipping_employee_dropship.dropCenterId');
		$this->db->where('shipping_employee_dropship.employeeId',$employeeId);
		if(!empty($dropshipId))
		{
			$this->db->where('shipping_employee_dropship.dropCenterId',$dropshipId);
		}
       	$query = $this->db->get();
        return $query->result();
	}
	
	public function add_shipping_employee_dropship($employeeId,$dropshipId)
	{
		$insertOpt = array(
					 	'employeeId' => $employeeId,
						'dropCenterId'	 => $dropshipId,
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
						
					 );
		$this->db->insert('shipping_employee_dropship',$insertOpt);
		return $this->db->insert_id();
		
	}
	
	public function add_shipping_vendor_employee($organizationId,$addArr)
	{
		$userId = $this->session->userdata('userId');
		$insertOpt = array(
						'organizationId' 	=> $organizationId,
						'email' 			=> $addArr['email'],
						'password' 			=> password_encrypt($addArr['password']),
						'firstName' 		=> $addArr['firstName'],
						'lastName' 			=> $addArr['lastName'],
						'middle' 			=> $addArr['middleName'],
						'userName' 			=> $addArr['userName'],
					 	'imageName' 		=> $addArr['imageName'],
						'active'			=> 1,
						'requestStatus'		=> 0,
						'imagePath' 		=> base_url().'uploads/shipping/',
						'businessPhoneCode' => $addArr['countryCode'],
						'businessPhone'     => $addArr['businessPhone'],						
						'createDt'			=> date('Y-m-d H:i:s'),
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->insert('employee',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_shipping_vendor_address($addArr)
	{
		$insertOpt = array(
						'phone'				 => $addArr['businessPhone'],
						'addressLine1'		 => $addArr['street'],
						'area'				 => $addArr['areaId'],
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
	
	public function add_shipping_vendor_employee_address($employeeId,$addressId)
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
	
	public function add_shipping_vendor_employee_role($employeeId,$organizationId)
	{
		$insertOpt = array(
						'employeeId'     => $employeeId,
						'roleId'	     => 7,
						'organizationId' => $organizationId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	public function add_shipping_vendor_employee_employee_role($employeeId,$organizationId)
	{
		$insertOpt = array(
						'employeeId'     => $employeeId,
						'roleId'	     => 26,
						'organizationId' => $organizationId,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('emp_role',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function shipping_vendor_user_details($organizationId)
	{
		$this->db->select("organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.passwordStatus,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.city,employee.businessPhoneCode,employee.requestStatus,area.areaId,area.area AS areaName");
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->join('csr_organization','employee.employeeId = csr_organization.organizationId','left');
		$this->db->where(array('role.code' => 'DELIVERYAGENT','organization.organizationId' => $organizationId));
		$result = $this->db->get()->row();
		return $result;
	}
	public function shipping_vendor_employee_details($employeeId)
	{
		
		$this->db->select("employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.passwordStatus,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.city,employee.businessPhoneCode,employee.requestStatus,area.areaId,area.area AS areaName");
		$this->db->from('employee');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		
		$this->db->where(array('role.code' => 'SVE','employee.employeeId' => $employeeId));
		$result = $this->db->get()->row();
		return $result;
	
	/*
		$this->db->select("organization.organizationId,organization.dropshipCentre,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.passwordStatus,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.city,employee.businessPhoneCode,employee.requestStatus,area.areaId,area.area AS areaName");
		$this->db->from('organization');
		$this->db->join('employee','organization.parentorganizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId','left');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		
		$this->db->where(array('role.code' => 'SVE'));
		$result = $this->db->get()->row();
		return $result;
	*/}
	
	public function update_shipping_vendor_organization($organizationId,$updateArr)
	{
		$updateOpt = array(
						'organizationName'   => $updateArr['businessName'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',$updateOpt);
		return $this->db->affected_rows();
	}
	public function update_shipping_vendor_employee_organization($organizationId,$updateArr)
	{
		$updateOpt = array(
						'organizationName'   => $updateArr['businessName'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_shipping_vendor_employee($employeeId,$updateArr)
	{
		$updateOpt = array(
						'firstName' 		=> $updateArr['firstName'],
						'lastName' 			=> $updateArr['lastName'],
						'middle' 			=> $updateArr['middleName'],
					 	'imageName' 		=> $updateArr['imageName'],
						'businessPhoneCode' => $updateArr['countryCode'],
						'businessPhone'		=> $updateArr['businessPhone'],
						'lastModifiedDt'	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'	=> $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function update_shipping_vendor_address($addressId,$updateArr)
	{
		$updateOpt = array(
						'addressLine1'		 => $updateArr['street'],
						'city' 			 	 => $updateArr['cityId'],
						'area' 			 	 => $updateArr['areaId'],
						'state' 			 => $updateArr['stateId'],
						'country'  			 => $updateArr['countryId'],
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function total_shipping_vendor_rate_list($shippingOrgId)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('shipping_rate');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->where(array('shipping_rate.shippingOrgId' => $shippingOrgId,'shipping_rate.active' => 1));
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	
	}
	
	public function shipping_vendor_rate_list($shippingOrgId)
	{
		$this->db->select('shipping_rate.*,zip.city AS cityName,area.area AS areaName,state.stateName,dropship_center.dropCenterId,dropship_center.dropCenterName');
		$this->db->from('shipping_rate');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array('shipping_rate.shippingOrgId' => $shippingOrgId,'shipping_rate.active' => 1));
		$this->db->order_by('shipping_rate.fromWeight','ASC');
		$result = $this->db->get();
		return $result->result();
	}	
	
	public function delete_shipping_rate($shippingRateId)
	{
		$this->db->where('shippingRateId',$shippingRateId);
		$this->db->update('shipping_rate',array('active' => 0));
		return $this->db->affected_rows();
	}
	
	public function update_dropship($organizationId,$dropship)
	{
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',array('dropshipCentre' => $dropship));
		return $this->db->affected_rows();
	}
	
	public function shipping_rate_details($shippingRateId,$shippingOrgId='')
	{
		if($shippingOrgId)
		{
			$this->db->where('shippingOrgId',$shippingOrgId);
		}
		$this->db->where('shippingRateId',$shippingRateId);
		$result = $this->db->get('shipping_rate');		
		return $result->row();
	}
	
	public function shipping_vendor_check_email($email)
	{
		$this->db->select('organization.organizationId,organization.parentOrganizationId,organization.organizationName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,employee.password,employee.passwordStatus,country.name AS countryName,state.stateName,zip.city AS cityName,address.addressLine1,address.country,address.state,address.city,role.code,employee.requestStatus');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where('role.code = ("DELIVERYAGENT" or "SVE")');
		$this->db->where(array('employee.email' => $email));
		$result = $this->db->get()->row();
		
		return $result;
	}
	
	public function deactivate_user($employeeId)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('active' => 0));
		return $this->db->affected_rows();
	}
	
	public function update_password($employeeId,$password)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('password' => password_encrypt($password),'requestStatus' => 3));
		return $this->db->affected_rows();
	}
	
	public function add_news_letter($addArr)
	{
		$insertOpt = array(
					 	'firstName' 	 => $addArr['firstName'],
						'lastName'  	 => $addArr['lastName'],
						'email'     	 => $addArr['email'],
						'phone'     	 => $addArr['phone'],
						'gender'    	 => $addArr['gender'],
						'stateId'   	 => $addArr['stateId'],
						'cityId'    	 => $addArr['cityId'],
						'areaId'    	 => $addArr['areaId'],
						'countryId' 	 => 154,
						'phoneCode'      => $addArr['phoneCode'],
						'verified'		 => 0,
						'verifiedCode'	 => $addArr['verifiedCode'],
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('newsletter',$insertOpt);
		return $this->db->insert_id();
	}

	public function add_pointe_force($addArr)
	{
		$insertOpt = array(
					 	'firstName' 	 => $addArr['firstName'],
						'lastName'  	 => $addArr['lastName'],
						'email'     	 => $addArr['email'],
						'verified'		 => 0,
						'birthDate'		 => $addArr['birthDate'],
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('pointe_force',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_address_pointe_force($addArr)
    {
        $insertOpt = array(
						'firstName' 	 => $addArr['firstName'],
			            'lastName' 		 => $addArr['lastName'],
			            'country' 		 => 154,
						'state' 		 => $addArr['stateId'],
			            'area' 			 => $addArr['areaId'],
			            'city' 			 => $addArr['cityId'],
			            'phone'			 => $addArr['phoneNo'],
			            'createDt' 		 => date('Y-m-d H:i:s'),
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
        $this->db->insert('address', $insertOpt);
        return $this->db->insert_id();
    }
	
	public function add_pointe_force_address($pointeForceId,$addressId)
	{
		$insertOpt = array(
					 	'pointeForceId'  => $pointeForceId,
						'addressId'      => $addressId,
						'active' 		 => 1,
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),					
					 );
		$this->db->insert('pointe_force_address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function requestRetailerDetails($organizationId)
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.verificationPref,employee.employeeId,employee.email,employee.businessPhone,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode,employee.requestStatus");
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CORPADMIN','organization.organizationId' => $organizationId));
		$result = $this->db->get();
		return $result->row();		
	}
	
	public function shipping_vendor_rateDetails($shippingRateId)
	{
		$this->db->select('*');
		$this->db->from('shipping_rate');
		$this->db->where('shippingRateId',$shippingRateId);
		$result = $this->db->get();
		return $result->row();
	}
	/*******************************api phone verification*******************************/
		public function assignverificationPref($userID,$verificationPref,$phone='')
	{
		$role=array(
					
					'verificationPref'	=>	$verificationPref,
					'lastModifiedDt'	=>	date('Y-m-d H:i:s')
					);
			
			if(!empty($phone))
			{
				$this->update_phone($userID,$phone);
			}
		$this->custom_log->write_log('custom_log',$userID.print_r($role,true));
			$this->db->where('organizationId',$userID);
			$rs=$this->db->update('organization',$role);
			
				return $rs;
			
			
	}
	public function update_phone($userID,$phone)
	{
			$role=array(
					
					'businessPhone'	=>	$phone,
					'lastModifiedDt'	=>	date('Y-m-d H:i:s')
					);
			$this->db->where('employeeId',$userID);
			$rs=$this->db->update('employee',$role);
			return $rs;
	}
	public function check_verification_code($verificationPref)
	{
		return $this->db->from('organization')->where('verificationPref',$verificationPref)->get()->row();
	}
	
	public function check_newsletter_email($email)
	{
		$this->db->where('email',$email);
		$result = $this->db->get('newsletter');
		return $result->row();
	}
	
	public function check_newsletter_subscription_email($email)
	{
		$this->db->where('subscription_email',$email);
		$result = $this->db->get('newsletter_subscription');
		return $result->row();
	}
	
		public function total_shipping_rates($shippingOrgId,$where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('shipping_rate');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array('shipping_rate.shippingOrgId' => $shippingOrgId,'shipping_rate.active' => 1));
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->order_by('shipping_rate.fromWeight','ASC');
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function shipping_rates_list($shippingOrgId,$start=0,$limit='',$where='')
	{
		$this->db->select('dropship_center.dropCenterName,shipping_rate.*,zip.city AS cityName,area.area AS areaName,state.stateName');
		$this->db->from('shipping_rate');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array('shipping_rate.shippingOrgId' => $shippingOrgId,'shipping_rate.active' => 1));
		if($where)
		{
			$this->db->where($where);
		}
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		$this->db->order_by('shipping_rate.fromWeight','ASC');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function update_to_pointepay_retailer_organization($organizationId)
	{
		$updateOpt=array(
		'isPointePay'		=> 2,
		'lastModifiedDt'	=> date('Y-m-d H:i:s'),
		'lastModifiedBy'	=> $this->session->userdata('userId'),
		);
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',$updateOpt);
		return $this->db->affected_rows();
	} 
}