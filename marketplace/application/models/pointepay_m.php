<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pointepay_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
	public function total_order($where='')
	{
		$this->db->select('count(*) as total');
		$this->db->from('pointepay_subscription');
		$this->db->where('status',1);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		return $this->db->get()->row();
	}
	public function order_list($where='')
	{
		$this->db->select('*');
		$this->db->from('pointepay_subscription');
		$this->db->where('status',1);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		return $this->db->get()->result();
	}
	public function orderDetail($poSuId)
	{
		$this->db->select('*');
		$this->db->from('pointepay_subscription');
		$this->db->where(
						array(
								'status'	=>	1,
								'pointepaySubscriptionId'	=>	$poSuId
								)
						);
		return $this->db->get()->row();
		
	}
	public function getAccessorieslisting($poSuId)
	{
		$this->db->select('subscription_accessories.*,pointepay_subscription.*');
		$this->db->from('pointepay_subscription');
		$this->db->join('subscription_accessories','pointepay_subscription.pointepaySubscriptionId=subscription_accessories.pointepaySubscriptionId');
		//$this->db->join('subscription_products','pointepay_subscription.pointepaySubscriptionId=subscription_accessories.pointepaySubscriptionId');
		$this->db->where(
						array(
								'pointepay_subscription.status'	=>	1,
								'pointepay_subscription.pointepaySubscriptionId'	=>	$poSuId
								)
						);
		return $this->db->get()->result();
	}
	public function getProductlisting($poSuId)
	{
		$this->db->select('subscription_products.*,pointepay_subscription.*');
		$this->db->from('pointepay_subscription');
		//$this->db->join('subscription_accessories','pointepay_subscription.pointepaySubscriptionId=subscription_accessories.pointepaySubscriptionId');
		$this->db->join('subscription_products','pointepay_subscription.pointepaySubscriptionId=subscription_products.pointepaySubscriptionId');
		$this->db->where(
						array(
								'pointepay_subscription.status'	=>	1,
								'pointepay_subscription.pointepaySubscriptionId'	=>	$poSuId
								)
						);
		return $this->db->get()->result();
	}
	public function addReference($organizationId,$poSuId)
	{
		$data=array(
					'pointepaySubscriptionId'	=>	$poSuId,
					//'createDt'                  => date('Y-m-d H:i:s'),
					'lastModifiedBy'            =>  $this->session->userdata('userId'),
					'lastModifiedDt'            => date('Y-m-d H:i:s'),
							);
		$this->db->where('organizationId',$organizationId);
		$this->db->update('organization',$data);
		return $this->db->affected_rows();
	}
	public function getRefDetail($refNo)
	{
		$this->db->select('*');
		$this->db->from('pointepay_subscription');
		$this->db->where(
							array(
							'refrenceNumber'	=> $refNo,
							'status'			=>	1
							)
							);
		return $this->db->get()->row();
	}
	public function totalInvoice()
	{
		$this->db->select('count(*) as total');
		$this->db->from('organization');
		$this->db->join('pointepay_subscription','pointepay_subscription.pointepaySubscriptionId=organization.pointepaySubscriptionId');
		return $this->db->get()->row();
	}
	public function invoiceListing($where,$start,$limit)
	{
		$this->db->select('organization.*,pointepay_subscription.*,employee.*');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId=employee.organizationId');
		$this->db->join('pointepay_subscription','pointepay_subscription.pointepaySubscriptionId=organization.pointepaySubscriptionId');
		return $this->db->get()->result();
		
	}
	public function retailer_user_details($organizationId)
	{
		$this->db->select('organization_type.Description AS organizationType ,organization.pointepaySubscriptionId,organization.organizationTypeId,organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhoneCode,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,address.addressId,address.addressLine1,address.country,address.state,address.area,address.city,organization.isPointePay,organization.isPointeMart,employee.userName,employee.businessPhoneCode,organization.dropshipCentre,employee.requestStatus,area.area AS areaName');
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
}