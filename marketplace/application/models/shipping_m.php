<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
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
	
	public function check_unique_vendor_user($email)
	{
		$this->db->select('employeeId,email');
		$this->db->from('employee');
		$this->db->where('(email = "'.$email.'" OR userName = "'.$email.'")');
		$this->db->where('isDelete',0);
		$result = $this->db->get()->row();
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
						'createBy'			 => $this->session->userdata('userId'),
						'verificationPref'   => $addArr['OTP'],
					 );
		$this->db->insert('organization',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_shipping_vendor_employee($organizationId,$addArr)
	{
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
						'createBy'			=> $this->session->userdata('userId'),
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
						'country'  			 => 154,
						'createDt'			 => date('Y-m-d H:i:s'),
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'createBy'			 => $this->session->userdata('userId'),
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
						'lastModifiedDt'	 => date('Y-m-d H:i:s'),
						'lastModifiedBy'	 => $this->session->userdata('userId'),
					 );
		$this->db->where('addressId',$addressId);
		$this->db->update('address',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function deactivate_user($employeeId)
	{
		$this->db->where('employeeId',$employeeId);
		$this->db->update('employee',array('active' => 0));
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
	
	public function shipping_vendor_rateDetails($shippingRateId)
	{
		$this->db->select('dropship_center.*,shipping_rate.*,zip.city');
		$this->db->from('shipping_rate');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->where('shippingRateId',$shippingRateId);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function update_shipping_rate($shippingRateId,$updateArr)
	{
		$updateOpt = array(
						'amount' => $updateArr['amount'],
					);
		$this->db->where('shippingRateId',$shippingRateId);
		$this->db->update('shipping_rate',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function shipping_vendor_with_rate_details($shippingRateId)
	{
		$this->db->select('organization.organizationName,shipping_rate.*,zip.city');
		$this->db->from('shipping_rate');
		$this->db->join('organization','shipping_rate.shippingOrgId = organization.organizationId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->where('shippingRateId',$shippingRateId);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function shipping_vendor_details($shippingRateId)
	{
		$this->db->select('organization.organizationName,shipping_rate.*,zip.city,employee.email,employee.businessPhone,employee.businessPhoneCode');
		$this->db->from('shipping_rate');
		$this->db->join('organization','shipping_rate.shippingOrgId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->where('shippingRateId',$shippingRateId);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function check_shipping_bounce($dropshipCenterId,$stateId,$areaId,$cityId)
	{
		$this->db->where(array('dropshipCenterId' => $dropshipCenterId,'stateId' => $stateId,'areaId' => $areaId,'cityId' => $cityId,'active' => 1));
		$result = $this->db->get('shipping_bounce');
		return $result->row();
	}
	
	public function increase_shipping_bounce_hit($shippingBounceId,$totalHit)
	{
		$updateOpt = array(
						'totalHit'         => $totalHit,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'lastModifiedTime' => time(),
					);
		$this->db->where('shippingBounceId',$shippingBounceId);
		$this->db->update('shipping_bounce',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function check_shipping_bounce_weight($shippingBounceId,$totalWeight)
	{
		$this->db->where(array('shippingBounceId' => $shippingBounceId,'totalWeight' => $totalWeight,'active' => 1));
		$result = $this->db->get('shipping_bounce_weight');
		return $result->row();
	}
	
	public function increase_shipping_bounce_weight_hit($shippBncWghtId,$totalHit)
	{
		$updateOpt = array(
						'totalHit' => $totalHit,
					);
		$this->db->where('shippBncWghtId',$shippBncWghtId);
		$this->db->update('shipping_bounce_weight',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_shipping_bounce($addArr)
	{
		$insertOpt = array(
					 	'dropshipCenterId' => $addArr['dropshipCenterId'],
						'stateId'          => $addArr['stateId'],
						'areaId'           => $addArr['areaId'],
						'cityId'           => $addArr['cityId'],
						'totalHit'		   => 1,
						'active'		   => 1,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'lastModifiedTime' => time(),
					 );
		$this->db->insert('shipping_bounce',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function add_shipping_bounce_weight($shippingBounceId,$addArr)
	{
		$insertOpt = array(
					 	'shippingBounceId' => $shippingBounceId,
						'totalWeight'      => $addArr['totalWeight'],
						'totalHit'		   => 1,
						'active'		   => 1,
					 );
		$this->db->insert('shipping_bounce_weight',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function total_shipping_bounce($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('shipping_bounce');
		$this->db->join('dropship_center','shipping_bounce.dropshipCenterId = dropship_center.dropCenterId');
		$this->db->join('state','shipping_bounce.stateId = state.stateId');
		$this->db->join('area','shipping_bounce.areaId = area.areaId');
		$this->db->join('zip','shipping_bounce.cityId = zip.zipId');
		$this->db->where('shipping_bounce.active',1);
		if($where)
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
	
	public function shipping_bounce_list($start=0,$limit='',$where='')
	{
		$this->db->select('shipping_bounce.*,dropship_center.dropCenterName,state.stateName,area.area AS areaName,zip.city AS cityName,group_concat(shipping_bounce_weight.totalWeight) as totalWeight');
		$this->db->from('shipping_bounce');
		$this->db->join('dropship_center','shipping_bounce.dropshipCenterId = dropship_center.dropCenterId');
		$this->db->join('state','shipping_bounce.stateId = state.stateId');
		$this->db->join('area','shipping_bounce.areaId = area.areaId');
		$this->db->join('zip','shipping_bounce.cityId = zip.zipId');
		$this->db->join('shipping_bounce_weight','shipping_bounce.shippingBounceId = shipping_bounce_weight.shippingBounceId');
		$this->db->where('shipping_bounce.active',1);
		if($where)
		{
			$this->db->where($where);
		}
		if($limit)
		{
			$this->db->limit($limit,$start);
		} 
		$this->db->group_by('shipping_bounce_weight.shippingBounceId');
		$this->db->order_by('shipping_bounce.lastModifiedTime','DESC');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function delete_shipping_bounce($shippingBounceId)
	{
		$updateOpt = array(
						'active'		   => 0,
						'lastModifiedBy'   => $this->session->userdata('userId'),
						'lastModifiedTime' => time(),
					 );
		$this->db->where('shippingBounceId',$shippingBounceId);
		$this->db->update('shipping_bounce',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function shipping_rate_with_weight($weight)
	{
		$this->db->select('shipping_rate.*,min(shipping_rate.amount) AS minAmount,max(shipping_rate.amount) AS maxAmoount');
		$this->db->from('shipping_rate');
		$this->db->where(array('fromWeight <=' => $weight,'toWeight >=' => $weight,'active' => 1));
		$this->db->order_by('amount','ASC');
		$result = $this->db->get();
		return $result->row();
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
	
	public function shipping_rate_details_from_10_to_30($shippingOrgId)
	{
		$this->db->where(array('fromWeight > ' => 10,'toWeight <= ' => 50,'shippingOrgId' => $shippingOrgId,'active' => 1));
		$this->db->order_by('shippingRateId','DESC');
		$result = $this->db->get('shipping_rate');
		return $result->row();
	}
	
	public function add_shipping_rates_from_10_to_30($shippingOrgId,$list)
	{
		$insertOpt = array();
		$i = 0;
		if(!empty($list))
		{
			foreach($list as $key=>$val)
			{
				foreach($val as $value)
				{
					$insertOpt[$i] = array(
									 	'shippingOrgId'  => $shippingOrgId,
										'fromZip'		 => $key,
										'toZip'			 => $value,
										'fromWeight'	 => '10.001',
										'toWeight'		 => 50,
										'amount'         => $this->input->post('shippingRate'),
										'ETA'            => $this->input->post('estimateTime'),
										'createDt'		 => date('Y-m-d H:i:s'),
										'lastModifiedDt' => date('Y-m-d H:i:s'),
										'lastModifiedBy' => $this->session->userdata('userId'), 
									 );
					$i++;
				}
			}
		}
		$retun = 0;
		//echo "<pre>"; print_r($insertOpt); exit;
		if(!empty($insertOpt))
		{
			$this->db->insert_batch('shipping_rate',$insertOpt); 
			$retun = $this->db->insert_id();
		}
		return $retun;
	}
	
	public function delete_shipping_rates_from_10_to_30($shippingOrgId)
	{
		$this->db->where(array('fromWeight >' => 10,'toWeight <=' => 50,'shippingOrgId' => $shippingOrgId));
		$this->db->update('shipping_rate',array('active' => 0,'lastModifiedDt' => date('Y-m-d H:i:s'),'lastModifiedBy' => $this->session->userdata('userId')));
		return $this->db->affected_rows();
	}
	
	public function delete_shipping_rate($shippingRateId)
	{
		$this->db->where('shippingRateId',$shippingRateId);
		$this->db->update('shipping_rate',array('active' => 0,'lastModifiedDt' => date('Y-m-d H:i:s'),'lastModifiedBy' => $this->session->userdata('userId')));
		return $this->db->affected_rows();
	}
	
	public function check_email_address($employeeId,$email)
	{
		$this->db->where(array('employeeId !=' => $employeeId,'email' => $email));
		$result = $this->db->get('employee');
		return $result->row();
	}
	
	public function max_rate_from_dropship_to_pickup_state($dropshipId,$pickUpStateId,$productWeight)
	{
		$this->db->select('shipping_rate.*');
		$this->db->from('shipping_rate');
		$this->db->join('organization','shipping_rate.shippingOrgId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array(
							'shipping_rate.fromZip' 	   => $dropshipId,
							'state.stateId' 			   => $pickUpStateId,
							'shipping_rate.fromWeight <= ' => $productWeight,
							'shipping_rate.toWeight >='    => $productWeight,
							'shipping_rate.active'         => 1,
							'employee.active'       	   => 1,
						));
		$this->db->order_by('shipping_rate.amount','DESC');
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function check_avaibility($dropshipId,$stateId,$areaId,$cityId,$totalWeight)
	{
		$this->db->select('shipping_rate.*');
		$this->db->from('shipping_rate');
		$this->db->join('organization','shipping_rate.shippingOrgId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array(
							'shipping_rate.fromZip'        => $dropshipId,
							'shipping_rate.toZip'          => $cityId,
							'state.stateId'                => $stateId,
							'area.areaId'                  => $areaId,
							'shipping_rate.fromWeight <= ' => $totalWeight,
							'shipping_rate.toWeight >='    => $totalWeight,
							'shipping_rate.active'         => 1,
							'employee.active'       	   => 1,
						));
		$this->db->order_by('shipping_rate.amount','ASC');
		$result = $this->db->get()->row();
        return $result;
	}
	
	public function check_avaibility_area($dropshipId,$stateId,$areaId,$totalWeight)
	{
		$this->db->select('shipping_rate.*');
		$this->db->from('shipping_rate');
		$this->db->join('organization','shipping_rate.shippingOrgId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array(
							'shipping_rate.fromZip'        => $dropshipId,
							'state.stateId'                => $stateId,
							'area.areaId'                  => $areaId,
							'shipping_rate.fromWeight <= ' => $totalWeight,
							'shipping_rate.toWeight >='    => $totalWeight,
							'shipping_rate.active'         => 1,
							'employee.active'       	   => 1,
						));
		$this->db->order_by('shipping_rate.amount','ASC');
		$result = $this->db->get()->row();
        return $result;
	}
	
	public function check_avaibility_state($dropshipId,$stateId,$totalWeight)
	{
		$this->db->select('shipping_rate.*');
		$this->db->from('shipping_rate');
		$this->db->join('organization','shipping_rate.shippingOrgId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('dropship_center','shipping_rate.fromZip = dropship_center.dropCenterId');
		$this->db->join('zip','shipping_rate.toZip = zip.zipId');
		$this->db->join('area','zip.area = area.areaId');
		$this->db->join('state','area.stateId = state.stateId');
		$this->db->where(array(
							'shipping_rate.fromZip'        => $dropshipId,
							'state.stateId'                => $stateId,
							'shipping_rate.fromWeight <= ' => $totalWeight,
							'shipping_rate.toWeight >='    => $totalWeight,
							'shipping_rate.active'         => 1,
							'employee.active'       	   => 1,
						));
		$this->db->order_by('shipping_rate.amount','ASC');
		$result = $this->db->get()->row();
        return $result;
	}
	
	public function total_shipping_vendor_user($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'DELIVERYAGENT','employee.isDelete' => 0));
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
		$this->db->select('organization.organizationId,organization.organizationName,employee.employeeId,employee.email,employee.businessPhone,employee.userName,employee.firstName,employee.middle,employee.lastName,employee.businessPhoneCode');
		$this->db->from('organization');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
		$this->db->join('role','role.roleID = emp_role.roleId');
		$this->db->where(array('role.code' => 'DELIVERYAGENT','employee.isDelete' => 0));
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
	
	public function shipping_employee_dropship_center_list($employeeId)
	{
		$this->db->select('*');
		$this->db->from('shipping_employee_dropship');
		$this->db->join('dropship_center','dropship_center.dropCenterId = shipping_employee_dropship.dropCenterId');
		$this->db->where('shipping_employee_dropship.employeeId',$employeeId);
		$query = $this->db->get();
        return $query->result();
	}
	
	public function add_shipping_rate_step_first($shippingOrgId)
	{
		$insertOpt = array(
						'shippingOrgId'	 => $shippingOrgId,
						'active'		 => 1,
						'createBy'		 => $this->session->userdata('userId'),
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					 );
		$this->db->insert('shipping_rate_step_first',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_shipping_rate_step_second($insertOpt)
	{
		$this->db->insert_batch('shipping_rate_step_second',$insertOpt); 
		return $this->db->insert_id();
	}
	
	public function shipping_rate_step_list($shippingOrgId,$shipRateStepFirstId)
	{
		$this->db->select('shipping_rate_step_second.shipRateStepSecondId,shipping_rate_step_second.dropShipId,shipping_rate_step_second.stateId,shipping_rate_step_second.areaId,shipping_rate_step_second.zipId,dropship_center.dropCenterName,state.stateName,area.area AS areaName');
		$this->db->from('shipping_rate_step_second');
		$this->db->join('shipping_rate_step_first','shipping_rate_step_second.shipRateStepFirstId = shipping_rate_step_first.shipRateStepFirstId');
		$this->db->join('dropship_center','shipping_rate_step_second.dropShipId = dropship_center.dropCenterId');
		$this->db->join('state','shipping_rate_step_second.stateId = state.stateId');
		$this->db->join('area','shipping_rate_step_second.areaId = area.areaId');
		$this->db->where(array(
							'shipping_rate_step_first.active'	 			=> 1,
							'shipping_rate_step_second.active'	 			=> 1,
							'shipping_rate_step_first.shippingOrgId'	 	=> $shippingOrgId,
							'shipping_rate_step_second.shipRateStepFirstId'	=> $shipRateStepFirstId,
							'dropship_center.active'						=> 1,
						));
		$result = $this->db->get()->result();
		return $result;
	}
}