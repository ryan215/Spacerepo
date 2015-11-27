<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_customer_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function check_user_varification_code($userID,$code)
	{
		$this->db->where(array(
			'customerId'     => $userID,
			'resetPasswordCode' => $code,
			'verified'	  => 0,
		));
		$result = $this->db->get('customer');
		return $result->row();
	}

	public function update_varified($userID)
	{
		$updateOpt = array(
			'resetPasswordCode' 	   => '',
			'verified'	  	   => 1,
		);
		$this->db->where('customerId',$userID);
		$this->db->update('customer',$updateOpt);
		return $this->db->affected_rows();
	}

	public function add_address($addArr)
	{
		$insertOpt = array(
			'state' 			 => $addArr['stateId'],
			'country'  			 => 154, //$addArr['countryId'],
			'city'				 => $addArr['cityId'],
            'area'               => $addArr['areaId'],
			'addressLine1'		 => $addArr['street'],
			'zip'				 => $addArr['zipcode'],
			'createDt'			 => date('Y-m-d H:i:s'),
			'lastModifiedDt'	 => date('Y-m-d H:i:s'),
			'lastModifiedBy'	 => $this->session->userdata('userId'),
		);
		$this->db->insert('address',$insertOpt);
		return $this->db->insert_id();
	}

	public function add_customer_address($customer_id,$addressId,$retailerid)
	{
		$insertOpt = array(
			'customerId'	 	 => $customer_id,
			'addressId'  		 => $addressId,
			'addressTypeId'		 => 1,
			'active'			 => 1,
			'createDt'			 => date('Y-m-d H:i:s'),
			'lastModifiedDt'	 => date('Y-m-d H:i:s'),
			'lastModifiedBy'	 => $retailerid,
		);
		$this->db->insert('customer_address',$insertOpt);
		return $this->db->insert_id();
	}

	public function add_customer($addArr)
	{
		$insertOpt = array(
			'email' 			=> $addArr['email'],
			'password' 			=> password_encrypt($addArr['password']),
			'firstName' 		=> $addArr['first_name'],
			'resetPasswordCode'	=> $addArr['resetPasswordCode'],
			'lastName' 			=> $addArr['last_name'],
			'phone'				=>	$addArr['phone'],
			'imageName'			=>	$addArr['imageName'],
			'verified'			=> 0,
			'createDt'			=> date('Y-m-d H:i:s'),
			'lastModifiedDt'	=> date('Y-m-d H:i:s'),
			'lastModifiedBy'	=> $this->session->userdata('userId'),
		);
		$this->db->insert('customer',$insertOpt);
		return $this->db->insert_id();
	}
	public function add_organization_customer($addArr,$user_id)
	{
		$insertOpt = array(
			'firstName' 		=> $addArr['firstName'],
			'lastName' 			=> $addArr['lastName'],
			'phone'				=>	$addArr['businessPhone'],
			'imageName'			=>	$addArr['imageName'],
			'email' 			=> $addArr['email'],
			'verified'			=> 0,
			'createDt'			=> date('Y-m-d H:i:s'),
			'lastModifiedDt'	=> date('Y-m-d H:i:s'),
			'lastModifiedBy'	=> $user_id,
		);
		$this->db->insert('customer',$insertOpt);
		return $this->db->insert_id();
	}


	public function update_address($addressId,$updateArr)
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

	public function update_customer($customerId,$addArr)
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

		$this->db->where('customerId',$customerId);
		$this->db->update('customer',$updateOpt);
		return $this->db->affected_rows();
	}

	public function sign_in($email,$where='')
	{
		$result=$this->db->select('*')->from('customer')->where('customer.email',$email)->get()->row();
		return $result;

	}
	public function get_user_detail($userId)
	{
		$this->db->select('address.*,customer.*');
		$this->db->from('customer');
		$this->db->join('customer_address','customer_address.customerId=customer.customerId');
		$this->db->join('address','address.addressId=customer_address.addressId');
		$this->db->where('customer.customerId',$userId);
		$results=$this->db->get()->row();
		return $results;
	}
	public function change_password($customer_id,$password)
	{
		$data=array(
			'password'	=>	$password
		);
		$this->db->where('customerId',$customer_id);
		$rs=$this->db->update('customer',$data);
		return $rs;
	}
	public function check_old_password($userId,$password)
	{
		$this->db->where( array('customerId' => $userId,'password' => $password));
		$result = $this->db->get('customer');
		return $result->row();
	}

	public function get_customer_user_detail($userId)
	{
		$this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,zip.city AS cityName');
		$this->db->from('customer');
		$this->db->join('customer_address','customer_address.customerId=customer.customerId');
		$this->db->join('address','address.addressId=customer_address.addressId');
		$this->db->join('country','address.country=country.countryId','left');
		$this->db->join('state','address.state=state.stateId','left');
		$this->db->join('zip','address.city=zip.zipId');
		$this->db->where('customer.customerId',$userId);
		$results=$this->db->get()->row();
		return $results;
	}
	public function add_retailer_customer($organization_id,$customer_id)
	{
		$insertOpt	=	array(
			'organization_Id'	=>	$organization_id,
			'customer_Id'		=>	$customer_id,
			'createDt'			 => date('Y-m-d H:i:s'),
			'lastModifiedDt'	 => date('Y-m-d H:i:s'),
			'lastModifiedBy'	 => $this->session->userdata('userId'),
		);
		$this->db->insert('organization_customer',$insertOpt);
		return $this->db->insert_id();

	}
}