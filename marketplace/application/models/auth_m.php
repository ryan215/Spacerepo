<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function sign_in($email,$where='')
	{
		$this->db->select('role.*,emp_role.*,employee.*');
		$this->db->from('employee');
		$this->db->join('emp_role','emp_role.employeeId=employee.employeeId');
		$this->db->join('role','emp_role.roleId=role.roleId');
		$this->db->where('employee.email',$email);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$query=$this->db->get()->row();
		return $query;
	}
	
	public function user_detail($phone_number,$phone_code)
	{
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('businessPhone',$phone_number);
		$this->db->where('businessPhoneCode',$phone_code);
		$query=$this->db->get();
		return $query->row();
		
	}
	public function set_otp($employeeId,$otp)
	{
		$insertOpt=array(
						'resetPasswordCode'=>	$otp,
						'passwordStatus'	=>	2
						);
	$this->db->where('employeeId',$employeeId);
	$this->db->update('employee',$insertOpt);
	return $this->db->affected_rows();
	}
	public function reset_password($employeeId,$password)
	{
		$updateopt=	array(
					'passwordStatus'	=>1,
					'password'			=>md5($password)
						);
			$this->db->where('employeeId',$employeeId);
			$this->db->update('employee',$updateopt);
	
	return $this->db->affected_rows();
		
	}
	
	public function pointe_force_sign_in($email)
	{
		$this->db->select('pointe_force.*');
		$this->db->from('pointe_force');
		$this->db->join('pointe_force_address','pointe_force.pointeForceId = pointe_force_address.pointeForceId');
		$this->db->join('address','pointe_force_address.addressId = address.addressId');
		$this->db->where(array(
							'pointe_force.email'          => $email,
							'pointe_force.isDelete'       => 0,
							'pointe_force_address.active' => 1
						));
		$result = $this->db->get()->row();
		return $result;
	}
}