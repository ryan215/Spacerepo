<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cse_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function cse_assing_retailer_list($start,$limit='',$where='')
	{
		$this->db->select("organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.businessPhone,country.name AS countryName,state.stateName,zip.city AS cityName,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode,employee.requestStatus");
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
		$this->db->join('csr_organization','organization.organizationId = csr_organization.organizationId');
		$this->db->where(array('role.code' => 'CORPADMIN'));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->where('csr_organization.employeeId',$this->session->userdata('userId'));
		$this->db->order_by('organization.organizationName','ASC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		//echo "<pre>"; print_r($result); exit;
		return $result;
	}
	
	public function total_my_retailer_request($where='')
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
		$this->db->where('(employee.requestStatus = 1 OR employee.requestStatus = 2 OR employee.requestStatus = 3 OR employee.requestStatus = 4)');
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
	
	
	
	
	
	public function add_cse_address($addArr)
	{
		$insertOpt = array(
						'area'  			 => $addArr['areaId'],
						'city'  			 => $addArr['cityId'],
						'state' 			 => $addArr['stateId'],
						'country'  			 => $addArr['countryId'],
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_cse_employee_address($employeeId,$addressId)
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
	
	public function deactive_cse_address_old($employeeId)
	{
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where(array('employeeId' => $employeeId,'addressTypeId' => 1));
		$this->db->update('employee_address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function cse_user_details($employeeId)
	{
		$this->db->select('organization.organizationId,organization.organizationName,organization.isPointePay,organization.isPointeMart,employee.employeeId,employee.email,employee.firstName,employee.middle,employee.lastName,employee.imageName,employee.birthDay');
		$this->db->from('organization');
		$this->db->join('organization_type','organization_type.organizationTypeId = organization.organizationTypeId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'CUSTOMERSERVICE','employee.employeeId' => $employeeId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function cse_user_address_details($employeeId)
	{
		$this->db->select('country.name AS countryName,state.stateName,address.country,address.state,address.area,address.city,address.addressId,address.addressLine1,address.country,address.state,address.city');
		$this->db->from('address');
		$this->db->join('employee_address','address.addressId = employee_address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->join('zip','address.city = zip.zipId','left');
		$this->db->where(array('employee_address.employeeId' => $employeeId,'employee_address.active' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function total_products_action_by_admin_according_day($where='')
	{
		$this->db->select('COUNT(product.code) AS total,employee.employeeId,employee.firstName,employee.middle,employee.lastName');
		$this->db->from('product');
		$this->db->join('employee','product.lastModifiedBy = employee.employeeId or product.verifiedBy = employee.employeeId');
		
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->where(array('emp_role.roleId' => 2));
		$this->db->where('(product.verificationResultId = 5 OR product.verificationResultId = 6)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->group_by('employee.employeeId');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function cse_states_list()
	{
		$this->db->select('state.stateId,state.stateName,employee.employeeId,employee.firstName,employee.middle,employee.lastName');
		$this->db->from('employee');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->where(array('emp_role.roleId' => 6,'employee_address.active' => 1));
		$this->db->group_by('employee.employeeId');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function products_request_states_list()
	{
		$lastSunday = date('Y-m-d',strtotime('last Sunday'));
		$next7days  = date('Y-m-d',strtotime('last Sunday +7 days'));
		$this->db->select('state.stateName,address.state,employee.employeeId,employee.firstName,employee.middle,employee.lastName');
		$this->db->from('product');
		$this->db->join('employee','product.createBy = employee.employeeId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->where(array('emp_role.roleId' => 6,'employee_address.active' => 1,"DATE_FORMAT(product.createDt,'%Y-%m-%d') >=" => $lastSunday,"DATE_FORMAT(product.createDt,'%Y-%m-%d') <" => $next7days));
		$this->db->where('(product.verificationResultId = 4 OR product.verificationResultId = 5 OR product.verificationResultId = 6)');
		$this->db->group_by('employee.employeeId');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function total_products_request_by_according_day($where='')
	{
		$this->db->select('COUNT(product.productId) AS total,employee.employeeId,employee.firstName,employee.middle,employee.lastName,state.stateName,address.state');
		$this->db->from('product');
		$this->db->join('employee','product.createBy = employee.employeeId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->where(array('emp_role.roleId' => 6,'employee_address.active' => 1));
		$this->db->where('(product.verificationResultId = 4 OR product.verificationResultId = 5 OR product.verificationResultId = 6)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->group_by('employee.employeeId');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function total_products_with_category_by_according_day($employeeId,$where='')
	{
		$this->db->select("count(product.productId) as total,category.categoryCode,category.categoryId as category_id,t1.categoryId as parentCategoryId,t2.categoryId as ParentCategoryId2 ,t3.categoryId as parentCategoryId3,employee.firstName,employee.middle,employee.lastName");
	  	$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('product','product.createBy=employee.employeeId');
  		$this->db->join('product_category','product_category.productId=product.productId and product_category.organizationId=organization.organizationId');
  		$this->db->join('category','product_category.categoryId=category.categoryId');
  		$this->db->join('category as t1','category.ParentCategoryId=t1.categoryId','left');
  		$this->db->join('category as t2','t1.ParentCategoryId=t2.categoryId','left');
		$this->db->join('category as t3','t2.ParentCategoryId=t3.categoryId','left');
		$this->db->join('category as t4','t3.ParentCategoryId=t4.categoryId','left');
		
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('employee.employeeId' => $employeeId,'emp_role.roleId' => 6));
		$this->db->where('(product.verificationResultId = 4 OR product.verificationResultId = 5 OR product.verificationResultId = 6)');
			if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->group_by("category.categoryId");
  		$result = $this->db->get();
		
		return $result->result();
	}
	
	public function product_by_cse($employeeId,$where='')
	{
		$this->db->select('COUNT(product.productId) AS total,product.verificationResultId,employee.employeeId,employee.firstName,employee.middle,employee.lastName');
		$this->db->from('product');
		$this->db->join('employee','product.createBy = employee.employeeId');
		$this->db->where('employee.employeeId',$employeeId);
		$this->db->where('(product.verificationResultId = 4 OR product.verificationResultId = 5 OR product.verificationResultId = 6)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		
		$this->db->group_by('product.verificationResultId');
		
		//$this->db->group_by('product.lastModifiedDt');
		$result = $this->db->get();
		
		return $result->result();
	}
	
	public function total_new_created_inventory($employeeId,$where='')
	{
		$this->db->select('COUNT(inventory_history.productId) AS total');
		$this->db->from('inventory_history');
		$this->db->join('employee','inventory_history.lastModifiedBy = employee.employeeId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->where(array('emp_role.roleId' => 6,'employee_address.active' => 1,'inventory_history.lastModifiedBy' => $employeeId,'inventory_history.act' => 1));
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
	
	public function total_updated_inventory($employeeId,$where='')
	{
		$this->db->select('COUNT(distinct(inventory_history.productId)) AS total');
		$this->db->from('inventory_history');
		$this->db->join('employee','inventory_history.lastModifiedBy = employee.employeeId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->where(array('emp_role.roleId' => 6,'employee_address.active' => 1,'inventory_history.lastModifiedBy' => $employeeId,'inventory_history.act' => 0));
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
	
	public function cse_details($employeeId)
	{
		$this->db->select('organization.organizationId,organization.organizationName,employee.employeeId,employee.email,employee.firstName,employee.middle,employee.lastName');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('employee_address','employee.employeeId = employee_address.employeeId');
		$this->db->join('address','employee_address.addressId = address.addressId');
		$this->db->join('state','address.state = state.stateId');
		$this->db->where(array('emp_role.roleId' => 6,'employee_address.active' => 1,'employee.employeeId' => $employeeId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function total_cse_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
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
		$this->db->select('organization.organizationId,organization.organizationName,employee.employeeId,employee.email,employee.firstName,employee.middle,employee.lastName,employee.imageName');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
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
	
	public function add_cse_dropship_center($employeeId,$dropshipId)
	{
		$insertOpt = array(
					 	'employeeId' 	 => $employeeId,
						'dropCenterId'	 => $dropshipId,
						'active'		 => 1,
						'createBy'		 => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),						
						'lastModifiedDt' => date('Y-m-d H:i:s'),						
					);
		$this->db->insert('cse_dropship',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function delete_cse_dropship_center($employeeId)
	{
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('employeeId',$employeeId);
		$this->db->update('cse_dropship',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function cse_dropship_center_list($employeeId)
	{
		$this->db->select('*');
		$this->db->from('cse_dropship');
		$this->db->join('dropship_center','cse_dropship.dropCenterId = dropship_center.dropCenterId');
		$this->db->where(array('cse_dropship.employeeId' => $employeeId,'cse_dropship.active' => 1));
		$result = $this->db->get()->result();
        return $result;
	}	
}