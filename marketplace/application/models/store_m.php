<?php

class Store_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

    }
	public function total_store($parentOrganizationId,$search='',$search_filter='')
	{
		$this->db->select('count(*) as total')->from('organization');
		$this->db->join('employee','employee.organizationId=organization.organizationId');
		$this->db->join('emp_role','emp_role.employeeId=employee.employeeId');
		$this->db->join('role','emp.roleId=emp_role.roleId');
		$this->db->join('org_verification_result','org_verification_result.orgVerificationResultId=organization.orgVerificationResultId');
		$this->db->where('organization.parentOrganizationId',$parentOrganizationId);
		if(!empty($search_filter))
		{
		$this->db->where($search_filter,$search);
		}
		if(!empty($search) && empty($search_filter))
		{
			
		}
		$query_result=$this->db->get()->row();
		return $query_result;
	}
	public function store_list($parentOrganizationId,$search='',$search_filter='')
	{
		$this->db->select('*')->from('organization');
		$this->db->join('employee','employee.organizationId=organization.organizationId');
		$this->db->join('emp_role','emp_role.employeeId=employee.employeeId');
		$this->db->join('role','emp.roleId=emp_role.roleId');
		$this->db->join('org_verification_result','org_verification_result.orgVerificationResultId=organization.orgVerificationResultId');
		$this->db->where('organization.parentOrganizationId',$parentOrganizationId);
		if(!empty($search_filter))
		{
		$this->db->where($search_filter,$search);
		}
		if(!empty($search) && empty($search_filter))
		{
			
		}
		$query_result=$this->db->get()->result();
		return $query_result;
	}
	public function add_store_name($parentOrganizationId,$dataarray)
	{
		$insertOpt = array(
					 	'organizationTypeId' => $addArr['organizationTypeId'],
						'organizationName'   => $addArr['businessName'],
						'parentOrganizationId'=> $parentOrganizationId,
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		if($addArr['associationType']==1)
		{
			$insertOpt['isPointeMart'] = 1;
		}
		if($addArr['associationType']==2)
		{
			$insertOpt['isPointePay'] = 1;
		}	
		
		if($addArr['associationType']==3)
		{
			$insertOpt['isPointeMart'] = 1;
			$insertOpt['isPointePay']  = 1;
		}
	
		$rs=$this->db->insert('organization',$insertOpt);
		if(!empty($rs))
		{
			return $this->db->insert_id();
		}
		
	}

}