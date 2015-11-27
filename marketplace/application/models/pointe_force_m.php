<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pointe_force_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function add_pointeforce_as_customer($addArr)
    {
        $insertOpt = array(
						'email' 		 	=> $addArr['email'],
						'firstName' 	 	=> $addArr['firstName'],
						'lastName' 		 	=> $addArr['lastName'],
						'password'		 	=> password_encrypt($addArr['password']),
						'phone' 		 	=> $addArr['phoneNo'],
						'birthDay'		 	=> $addArr['birthDate'],
						'resetPasswordCode' => $addArr['varifyCode'],
						'isPointeForce'  	=> 1,						
						'verified' 		 	=> 0,
						'createDt' 		 	=> date('Y-m-d H:i:s'),
						'createdBy'      	=> $this->session->userdata('userId'),
						'lastModifiedDt' 	=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 	=> $this->session->userdata('userId'),
					);
        $this->db->insert('customer',$insertOpt);
        return $this->db->insert_id();
    }
	
	public function add_address_pointe_force($addArr)
    {
        $insertOpt = array(
						'addressLine1' 	 => $addArr['street'],
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
        $this->db->insert('address',$insertOpt);
        return $this->db->insert_id();
    }
	
	public function add_pointe_force_address($customerId,$addressId)
	{
		$insertOpt = array(
						'customerId' 	 => $customerId,
						'addressId' 	 => $addressId,
						'addressTypeId'  => 1,
						'active' 		 => 1,
						'createDt' 		 => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
        $this->db->insert('customer_address',$insertOpt);
        return $this->db->affected_rows();
    }
	
	public function add_pointe_force_verification($customerId)
	{
        $insertOpt = array(
						'customerId'	 => $customerId,
						'verifiedStatus' => 1,
						'active'		 => 1,
						'createdBy'      => $this->session->userdata('userId'),
						'createDt' 		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
        $this->db->insert('pointe_force_verification',$insertOpt);
        return $this->db->insert_id();    
	}
	
	public function add_pointe_force_unverification($customerId)
	{
        $insertOpt = array(
						'customerId'	 => $customerId,
						'verifiedStatus' => 0,
						'active'		 => 1,
						'createdBy'      => $this->session->userdata('userId'),
						'createDt' 		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
        $this->db->insert('pointe_force_verification',$insertOpt);
        return $this->db->insert_id();    
	}
	
	public function old_verify_status_change($customerId)
	{
		$updateOpt = array(
							'active' 		 => 0,
							'lastModifiedBy' => $this->session->userdata('userId'),
							'lastModifiedDt' => date('Y-m-d H:i:s'),
						);
        $this->db->where(array('customerId' => $customerId,'active' => 1));
        $this->db->update('pointe_force_verification', $updateOpt);
        return $this->db->affected_rows();
	}
	
	public function total_pointe_force_user($where)
	{
		$total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('customer');
		$this->db->where(array('customer.isDelete' => 0,'customer.isPointeForce' => 1));
        if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
        if(!empty($result)) 
		{
        	$total = $result->total;
        }
        return $total;
    }
	
	public function pointe_force_user_list($start=0,$limit='',$where='')
    {
		$this->db->select('customer.*');
        $this->db->from('customer');
		$this->db->where(array('customer.isDelete' => 0,'customer.isPointeForce' => 1));
        if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('customer.firstName','ASC');
		if(!empty($limit))
		{
        	$this->db->limit($limit,$start);
		}
        return $this->db->get()->result();
	}
	
	public function pointe_force_details($customerId)
    {
		$this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName,pointe_force_verification.verifiedStatus');
        $this->db->from('customer');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');		
		$this->db->join('pointe_force_verification','customer.customerId = pointe_force_verification.customerId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
        $this->db->join('area', 'address.area = area.areaId','left');
        $this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array(
							'customer.customerId' 			   => $customerId,
							'customer.isDelete' 			   => 0,
							'customer.isPointeForce'		   => 1,
							'customer_address.addressTypeId'   => 1,
							'customer_address.active' 		   => 1,
							'pointe_force_verification.active' => 1
						));
        $result = $this->db->get()->row();
        return $result;
	}	
	
	public function pointe_force_verification_details($customerId)
	{
		$this->db->select('verifiedStatus');
		$this->db->from('pointe_force_verification');
		$this->db->where(array('customerId' => $customerId,'active' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function pointe_force_balance()
	{
		$this->db->select('SUM(order_pointe_force.totalCommissionPrice) AS balance');
		$this->db->from('order_pointe_force');
		$this->db->join('order_details','order_pointe_force.orderDetailId = order_details.orderDetailId');
		$this->db->where(array(
							'order_pointe_force.customerId'     => $this->session->userdata('userId'),
							'order_pointe_force.verifiedStatus' => 1,
							'order_pointe_force.active'	 	    => 1,
							'order_details.active'				=> 1,
							'order_details.orderStatusId != '	=> 6,
						));
		$result = $this->db->get()->row();
				
		$balance = 0;
		if(!empty($result))
		{
			$balance = $result->balance;
		}
		return $balance;
	}
	
	public function check_unique_customer_user($email)
	{
		$this->db->select('customerId,email');
		$this->db->from('customer');
		$this->db->where(array('isDelete' => 0,'email' => $email));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function customer_pointe_force($email)
    {
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where(array('email' => $email,'isDelete' => 0));
        $result = $this->db->get()->row();
        return $result;

    }
	
	public function customer_as_request_for_pointeforce($customerId)
	{
		$updateOpt = array(
							'isPointeForce'  => 1,
							'lastModifiedBy' => $this->session->userdata('userId'),
							'lastModifiedDt' => date('Y-m-d H:i:s'),
						);
        $this->db->where('customerId',$customerId);
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();	
	}
}