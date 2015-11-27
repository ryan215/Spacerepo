<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_m extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_user_varification_code($userID, $code)
    {
        $this->db->where(array(
            'customerId' => $userID,
            'resetPasswordCode' => $code,
            'verified' => 0,
        ));
        $result = $this->db->get('customer');
        return $result->row();
    }

    public function update_varified($userID)
    {
        $updateOpt = array(
            'resetPasswordCode' => '',
            'verified' => 1,
        );
        $this->db->where('customerId', $userID);
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();
    }

    public function add_address($addArr)
    {
        $insertOpt = array(
			'firstName' 	 => $addArr['first_name'],
            'lastName' 		 => $addArr['last_name'],
            'state' 		 => $addArr['stateId'],
            'country' 		 => 154,
            'city' 			 => $addArr['cityId'],
            'area' 			 => $addArr['areaId'],
            'addressLine1'   => $addArr['street'],
            'zip' 			 => $addArr['zipcode'],
            'createDt' 		 => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('address', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_customer_address($customer_id, $addressId)
    {
        $insertOpt = array(
            'customerId' => $customer_id,
            'addressId' => $addressId,
            'addressTypeId' => 1,
            'active' => 1,
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('customer_address', $insertOpt);
        return $this->db->affected_rows();
    }

    public function add_customer($addArr)
    {
        $insertOpt = array(
            'email' => $addArr['email'],
            'password' => password_encrypt($addArr['password']),
            'firstName' => $addArr['first_name'],
            'resetPasswordCode' => $addArr['resetPasswordCode'],
            'lastName' => $addArr['last_name'],
            'phone' => $addArr['phone'],
            'verified' => 0,
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        if ((!empty($addArr['isMarketingUser'])) && ($addArr['isMarketingUser'])) {
            $insertOpt['isMarketingUser'] = 1;
            $insertOpt['verified'] = 1;
        }
        $this->db->insert('customer', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_organization_customer($addArr, $user_id)
    {
        $insertOpt = array(
            'firstName' => $addArr['firstName'],
            'email' => $addArr['email'],
            'imageName' => $addArr['imageName'],
            'lastName' => $addArr['lastName'],
            'phone' => $addArr['phoneNo'],
            'verified' => 0,
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $user_id,
        );
        $this->db->insert('customer', $insertOpt);
        return $this->db->insert_id();
    }


    public function update_address($addressId, $updateArr)
    {
        $updateOpt = array(
            'state' => $updateArr['stateId'],
            'country' => $updateArr['country_id'],
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->where('addressId', $addressId);
        $this->db->update('address', $updateOpt);
        return $this->db->affected_rows();
    }
	
	public function update_customer_detail($customerId,$updArr)
	{
	 $updateOpt = array(
            'firstName' => $updArr['firstName'],
            'lastName' => $updArr['lastName'],
            'phone' => $updArr['phoneNo'],
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        if ($updArr['email']) {
            $updateOpt['email'] = $updArr['email'];
        }

        $this->db->where('customerId', $customerId);
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();
	
	
	
	}
	
    public function update_customer($customer, $addArr)
    {
        $updateOpt = array(
            'firstName' => $addArr['first_name'],
            'lastName' => $addArr['last_name'],
            'middle' => $addArr['middle_name'],
            'userName' => $addArr['email'],
            'imageName' => $addArr['image_name'],
            'imagePath' => base_url() . 'uploads/admin/',
            'birthDay' => $addArr['birth_date'],
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        if ($addArr['email']) {
            $updateOpt['email'] = $addArr['email'];
        }

        $this->db->where('customerId', $employeeId);
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();
    }

    public function update_organization_customer($customer, $addArr)
    {
        $updateOpt = array(
            'firstName' => $addArr['first_name'],
            'lastName' => $addArr['last_name'],
            'middle' => $addArr['middle_name'],
            'phone' => $addArr['phoneNo'],
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        if ($addArr['email']) {
            $updateOpt['email'] = $addArr['email'];
        }

        $this->db->where('customerId', $employeeId);
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();
    }

    public function sign_in($email,$where = '')
    {
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where(array('email' => $email,'isDelete' => 0));
        $result = $this->db->get()->row();
        return $result;

    }

    public function get_user_detail($userId)
    {
        $this->db->select('address.*,customer.*');
        $this->db->from('customer');
        $this->db->join('customer_address', 'customer_address.customerId=customer.customerId');
        $this->db->join('address', 'address.addressId=customer_address.addressId');
        $this->db->where(array('customer.customerId' => $userId, 'customer_address.active' => 1, 'customer_address.addressTypeId' => 1,));
        $results = $this->db->get()->row();
        return $results;
    }

    public function change_password($customerId, $password)
    {
        $this->db->where('customerId', $customerId);
        $this->db->update('customer', array('password' => $password,'lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function check_old_password($userId, $password)
    {
        $this->db->where(array('customerId' => $userId, 'password' => $password));
        $result = $this->db->get('customer');
        return $result->row();
    }

    public function get_customer_user_detail($userId)
    {
        $this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,zip.city AS cityName');
        $this->db->from('customer');
        $this->db->join('customer_address', 'customer_address.customerId=customer.customerId');
        $this->db->join('address', 'address.addressId=customer_address.addressId');
        $this->db->join('country', 'address.country=country.countryId', 'left');
        $this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('zip', 'address.city=zip.zipId','left');
        $this->db->where('customer.customerId', $userId);
        $results = $this->db->get()->row();
        return $results;
    }

    public function add_retailer_customer($organization_id, $customer_id)
    {
        $insertOpt = array(
            'organization_Id' => $organization_id,
            'customer_Id' => $customer_id,
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('organization_customer', $insertOpt);
        return $this->db->insert_id();

    }

    public function customer_list($organization_Id, $start = '', $limit = '',$where='')
    {
        $this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
        $this->db->from('customer');
        $this->db->join('organization_customer', 'organization_customer.customer_id=customer.customerId');
        $this->db->join('customer_address', 'customer_address.customerId=customer.customerId', 'left');
        $this->db->join('address', 'address.addressId=customer_address.addressId', 'left');
        $this->db->join('country', 'address.country=country.countryId', 'left');
        $this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area=area.areaId', 'left');
        $this->db->join('zip', 'zip.zipId=address.city', 'left');
        $this->db->where('organization_customer.organization_id', $organization_Id);
        if (!empty($start) || !empty($limit)) {
            $this->db->limit($limit, $start);

        }
        if(!empty($where))
        {
            $this->db->where($where);
        }
        return $this->db->get()->result();
    }

    public function user_email($email)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('email', $email);
        $result = $this->db->get()->row();
        return $result;
    }

    public function update_reset_code($email, $password)
    {
        $this->db->where('email', $email);
        //$this->db->update('employee',array('resetPasswordCode' => $resetPasswordCode));
        $this->db->update('customer', array('password' => password_encrypt($password)));
        return $this->db->affected_rows();
    }
	
	public function user_profile_details($userId)
    {
        $this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
        $this->db->from('address');
        $this->db->join('customer_address','address.addressId = customer_address.addressId');
		$this->db->join('customer', 'customer_address.customerId = customer.customerId');
        $this->db->join('country', 'address.country = country.countryId', 'left');
        $this->db->join('state', 'address.state = state.stateId', 'left');
        $this->db->join('area', 'address.area = area.areaId', 'left');
        $this->db->join('zip', 'address.city = zip.zipId', 'left');
        $this->db->where(array('customer_address.active' => 1, 'customer_address.addressTypeId' => 1, 'customer_address.customerId' => $userId));
        $result = $this->db->get();
        return $result->row();
    }

    public function user_billing_details($userId)
    {
        $this->db->select('address.*');
        $this->db->from('address');
        $this->db->join('customer_address', 'address.addressId = customer_address.addressId');
        $this->db->join('country', 'address.country = country.countryId', 'left');
        $this->db->join('state', 'address.state = state.stateId', 'left');
        $this->db->join('area', 'address.area = area.areaId', 'left');
        $this->db->join('zip', 'address.city = zip.zipId', 'left');
        $this->db->where(array('customer_address.active' => 1, 'customer_address.addressTypeId' => 4, 'customer_address.customerId' => $userId));
        $result = $this->db->get();
        return $result->row();
    }

    public function user_shipping_details($userId)
    {
        $this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
        $this->db->from('address');
        $this->db->join('customer_address', 'address.addressId = customer_address.addressId');
        $this->db->join('country', 'address.country = country.countryId','left');
        $this->db->join('state', 'address.state = state.stateId','left');
        $this->db->join('area', 'address.area = area.areaId','left');
        $this->db->join('zip', 'address.city = zip.zipId','left');
        $this->db->where(array('customer_address.active' => 1, 'customer_address.addressTypeId' => 3, 'customer_address.customerId' => $userId));
        $result = $this->db->get();
        return $result->row();
    }
	
	public function all_shipping_details($userId)
    {
        $this->db->select('address.*,customer_address.active,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
        $this->db->from('address');
        $this->db->join('customer_address', 'address.addressId = customer_address.addressId');
        $this->db->join('country', 'address.country = country.countryId','left');
        $this->db->join('state', 'address.state = state.stateId','left');
        $this->db->join('area', 'address.area = area.areaId','left');
        $this->db->join('zip', 'address.city = zip.zipId','left');
        $this->db->where(array('customer_address.addressTypeId' => 3, 'customer_address.customerId' => $userId));
		$this->db->group_by(array('address.addressLine1','address.city','address.area','address.state')); 
		$this->db->order_by('address.addressId','DESC');
        $result = $this->db->get();
        return $result->result();
    }

    public function add_shippBill_address($addSArr)
    {
        $insertOpt = array(
            'firstName' => $addSArr['firstName'],
            'lastName' => $addSArr['lastName'],
            'addressLine1' => $addSArr['address1'],
            'address_Line2' => $addSArr['address2'],
            'phone' => $addSArr['phoneNo'],
            'zip' => $addSArr['zipcode'],
            'state' => $addSArr['stateId'],
            'area' => $addSArr['areaId'],
            'city' => $addSArr['cityId'],
            'country' => $addSArr['countryId'],
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('address', $insertOpt);
        return $this->db->insert_id();
    }

    public function adddropshipaddress($addSArr)
    {
        $insertOpt = array(
            'firstName' => $addSArr['firstName'],
            'lastName' => $addSArr['lastName'],
            'addressLine1' => $addSArr['address1'],
            'address_Line2' => $addSArr['address2'],
            'phone' => $addSArr['phoneNo'],
            'zip' => $addSArr['zipcode'],
            'state' => $addSArr['stateId'],
            'area' => $addSArr['areaId'],
            'city' => $addSArr['cityId'],
            'country' => $addSArr['countryId'],
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        if(isset($addSArr['secondary_phone']))
        {
            $insertOpt['secondary_phone']=$addSArr['secondary_phone'];
        }
        $this->db->insert('address', $insertOpt);
        return $this->db->insert_id();
    }
    public function update_customer_address($addressId, $addSArr)
    {
        $updateOpt = array(
            'firstName' => $addSArr['firstName'],
            'lastName' => $addSArr['lastName'],
            'addressLine1' => $addSArr['address1'],
            'address_Line2' => $addSArr['address2'],
            'phone' => $addSArr['phoneNo'],
            'zip' => $addSArr['zipcode'],
            'state' => $addSArr['stateId'],
            'area' => $addSArr['areaId'],
            'city' => $addSArr['cityId'],
            'country' => $addSArr['countryId'],
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->where('addressId', $addressId);
        $this->db->update('address', $updateOpt);
        return $this->db->affected_rows();
    }

    public function add_billing_address_type($customerId, $addressId)
    {
        $insertOpt = array(
            'customerId' => $customerId,
            'addressId' => $addressId,
            'addressTypeId' => 4,
            'active' => 1,
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('customer_address', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_shipping_address_type($customerId, $addressId)
    {
        $insertOpt = array(
						'customerId'     => $customerId,
						'addressId'      => $addressId,
						'addressTypeId'  => 3,
						'active'         => 1,
						'createDt'       => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
        $this->db->insert('customer_address', $insertOpt);
        return $this->db->insert_id();
    }

    public function update_personal_address_type($customerId, $addressId)
    {
        $this->db->where(array(
            'customerId' => $customerId,
            'addressId' => $addressId,
            'addressTypeId' => 1));
        $insertOpt = array(
            'active' => 1,
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->update('customer_address', $insertOpt);
        return $this->db->affected_rows();
    }

    public function update_billing_address_type($customerId, $addressId)
    {
        $this->db->where(array(
            'customerId' => $customerId,
            'addressId' => $addressId,
            'addressTypeId' => 4));
        $insertOpt = array(
            'active' => 1,
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->update('customer_address', $insertOpt);
        return $this->db->affected_rows();
    }

    public function update_shipping_address_type($customerId, $addressId)
    {
        $this->db->where(array(
            'customerId' => $customerId,
            'addressId' => $addressId,
            'addressTypeId' => 3));
        $insertOpt = array(
            'active' => 1,
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->update('customer_address', $insertOpt);
        return $this->db->affected_rows();
    }

    public function delete_old_billing_address($customerId)
    {
        $this->db->where(array('customerId' => $customerId, 'addressTypeId' => 4));
        $updateOpt = array(
            'active' => 0,
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $customerId,
        );
        $this->db->update('customer_address', $updateOpt);
        return $this->db->affected_rows();
    }

    public function delete_old_shipping_address($customerId)
    {
        $this->db->where(array('customerId' => $customerId, 'addressTypeId' => 3));
        $updateOpt = array(
            			'active'         => 0,
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
        $this->db->update('customer_address', $updateOpt);
        return $this->db->affected_rows();		
    }
	
	public function activate_shipping_address($customerId,$addressId)
    {
        $this->db->where(array('customerId' => $customerId,'addressId' => $addressId, 'addressTypeId' => 3));
        $updateOpt = array(
            			'active'         => 1,
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
        $this->db->update('customer_address', $updateOpt);
        return $this->db->affected_rows();		
    }

    public function update_customer_name($customerId,$addSArr)
    {
        $this->db->where('customerId', $customerId);
        $updateOpt = array(
            'firstName' => $addSArr['firstName'],
            'lastName' => $addSArr['lastName'],
            'phone' => $addSArr['phoneNo'],
        );
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();
    }

    public function add_newsletter_subscription($addArr)
    {
        $insertOpt = array(
            'newsLetterId' => $addArr['newsLetterId'],
            'subscription_email' => $addArr['email'],
            'name' => $addArr['name'],
            'verified' => 0,
            'verifiedCode' => $addArr['verifiedCode'],
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('newsletter_subscription', $insertOpt);
        return $this->db->insert_id();
    }

    public function refer_verified_details($newSubId, $verifiedCode)
    {
        $this->db->where(array('newSubId' => $newSubId, 'verifiedCode' => $verifiedCode));
        $result = $this->db->get('newsletter_subscription');
        return $result->row();
    }

    public function verified_refer($newSubId)
    {
        $this->db->where('newSubId', $newSubId);
        $this->db->update('newsletter_subscription', array('verified' => 1, 'verifiedCode' => ''));
        return $this->db->affected_rows();
    }

    public function total_news_letter($where = '')
    {
        $total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('newsletter');
        $this->db->join('zip', 'newsletter.cityId = zip.zipId');
        $this->db->join('area', 'newsletter.areaId = area.areaId');
        $this->db->join('state', 'newsletter.stateId = state.stateId');
        if ($where) {
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
        //echo $this->db->last_query(); exit;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function news_letter_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('newsletter.*,state.stateName,area.area AS areaName,zip.city AS cityName');
        $this->db->from('newsletter');
        $this->db->join('zip', 'newsletter.cityId = zip.zipId');
        $this->db->join('area', 'newsletter.areaId = area.areaId');
        $this->db->join('state', 'newsletter.stateId = state.stateId');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('newsletter.firstName', 'ASC');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function news_letter_user_details($newsletterId)
    {
        $this->db->select('newsletter.*,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
        $this->db->from('newsletter');
        $this->db->join('country', 'newsletter.countryId = country.countryId');
        $this->db->join('state', 'newsletter.stateId = state.stateId');
        $this->db->join('area', 'newsletter.areaId = area.areaId');
        $this->db->join('zip', 'newsletter.cityId = zip.zipId');
        $this->db->where('newsletter.newsletterId', $newsletterId);
        $result = $this->db->get()->row();
        return $result;
    }

    public function refer_friend_list($newsletterId)
    {
        $this->db->where('newsLetterId', $newsletterId);
        $result = $this->db->get('newsletter_subscription');
        return $result->result();
    }

    public function total_news_letter_verified()
    {
        $total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('newsletter');
        $this->db->where('verified', 1);
        $result = $this->db->get()->row();
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function total_news_letter_unverified()
    {
        $total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('newsletter');
        $this->db->where('verified', 0);
        $result = $this->db->get()->row();
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function check_verified_newsletter($newsletterId, $verifiedCode)
    {
        $this->db->where(array('newsletterId' => $newsletterId, 'verifiedCode' => $verifiedCode, 'verified' => 0));
        $result = $this->db->get('newsletter');
        return $result->row();
    }

    public function update_verified_newsletter($newsletterId)
    {
        $this->db->where('newsletterId', $newsletterId);
        $this->db->update('newsletter', array('verified' => 1, 'verifiedCode' => ''));
        return $this->db->affected_rows();
    }

    public function news_letter_user_email_details($email)
    {
        $this->db->select('newsletter.*,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
        $this->db->from('newsletter');
        $this->db->join('country', 'newsletter.countryId = country.countryId');
        $this->db->join('state', 'newsletter.stateId = state.stateId');
        $this->db->join('area', 'newsletter.areaId = area.areaId');
        $this->db->join('zip', 'newsletter.cityId = zip.zipId');
        $this->db->where(array('newsletter.email' => $email, 'newsletter.verified' => 1));
        $result = $this->db->get()->row();
        return $result;
    }

    public function get_customer_with_shipping_detail($customerId)
    {
        $this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
        $this->db->from('customer');
        $this->db->join('customer_address', 'customer_address.customerId=customer.customerId');
        $this->db->join('address', 'address.addressId=customer_address.addressId');
        $this->db->join('country', 'address.country=country.countryId', 'left');
        $this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area = area.areaId', 'left');
        $this->db->join('zip', 'address.city=zip.zipId');
        $this->db->where(array('customer_address.active' => 1, 'customer_address.addressTypeId' => 3, 'customer_address.customerId' => $customerId, 'customer.customerId' => $customerId,));
        $results = $this->db->get()->row();
        return $results;
    }
	
	public function get_customer_detail_for_pickup($customerId)
    {
        $this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
        $this->db->from('customer');
        $this->db->join('customer_address', 'customer_address.customerId=customer.customerId');
        $this->db->join('address', 'address.addressId=customer_address.addressId');
        $this->db->join('country', 'address.country=country.countryId', 'left');
        $this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area = area.areaId', 'left');
        $this->db->join('zip', 'address.city=zip.zipId');
        $this->db->where(array('customer_address.active' => 1,'customer_address.addressTypeId' => 1, 'customer_address.customerId' => $customerId, 'customer.customerId' => $customerId,));
        $results = $this->db->get()->row();
        return $results;
    }

    public function marketing_shipping_details($userId)
    {
        $this->db->select('newsletter.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
        $this->db->from('newsletter');
        $this->db->join('country', 'newsletter.countryId = country.countryId', 'left');
        $this->db->join('state', 'newsletter.stateId = state.stateId', 'left');
        $this->db->join('area', 'newsletter.areaId = area.areaId', 'left');
        $this->db->join('zip', 'newsletter.cityId = zip.zipId', 'left');
        $this->db->where(array('newsletter.newsletterId' => $userId));
        $result = $this->db->get();
        return $result->row();
    }

    public function add_marketing_customer($addArr)
    {
        $insertOpt = array(
            'email' => $addArr['email'],
            'password' => $addArr['password'],
            'firstName' => $addArr['firstName'],
            'lastName' => $addArr['lastName'],
            'phone' => $addArr['phone'],
            'verified' => 1,
            'isMarketingUser' => 1,
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('customer', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_marketing_address($addArr)
    {
        $insertOpt = array(
            'state' => $addArr['stateId'],
            'country' => 154,
            'city' => $addArr['cityId'],
            'area' => $addArr['areaId'],
            'addressLine1' => $addArr['addressLine1'],
            'address_Line2' => $addArr['addressLine2'],
            'zip' => $addArr['zip'],
            'phone' => $addArr['phone'],
            'firstName' => $addArr['firstName'],
            'lastName' => $addArr['lastName'],
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
        );
        $this->db->insert('address', $insertOpt);
        return $this->db->insert_id();
    }
	
	public function address_details($addressId)
	{
        $this->db->select('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
        $this->db->from('address');
        $this->db->join('customer_address', 'address.addressId = customer_address.addressId');
        $this->db->join('country', 'address.country = country.countryId','left');
        $this->db->join('state', 'address.state = state.stateId','left');
        $this->db->join('area', 'address.area = area.areaId','left');
        $this->db->join('zip', 'address.city = zip.zipId','left');
        $this->db->where('address.addressId',$addressId);
        $result = $this->db->get();
        return $result->row();
	}
	
	public function delete_old_profile_address($customerId)
	{
		$this->db->where(array('customerId' => $customerId,'addressTypeId' => 1));
        $updateOpt = array(
            			'active'         => 0,
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
        $this->db->update('customer_address',$updateOpt);
        return $this->db->affected_rows();	
	}
	
	public function add_customer_profile_address($addArr)
    {
        $insertOpt = array(
						'firstName'      => $addArr['firstName'],
						'lastName'       => $addArr['lastName'],
						'addressLine1'   => $addArr['address1'],
						'address_Line2'  => $addArr['address2'],
						'phone'          => $addArr['phoneNo'],
						'zip'            => $addArr['zipcode'],
						'state'          => $addArr['stateId'],
						'area'           => $addArr['areaId'],
						'city'           => $addArr['cityId'],
						'country'        => 154,
						'createDt'       => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
        			);
        $this->db->insert('address', $insertOpt);
        return $this->db->insert_id();
	}
	
	public function get_profile_detail($userId)
    {
        $this->db->select('address.*');
        $this->db->from('customer');
        $this->db->join('customer_address','customer_address.customerId=customer.customerId');
        $this->db->join('address','address.addressId=customer_address.addressId');
        $this->db->where(array('customer.customerId' => $userId, 'customer_address.active' => 1, 'customer_address.addressTypeId' => 1,));
        $results = $this->db->get()->row();
        return $results;
    }
	
	public function total_customer_user($where)
	{
		$total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('customer');
		$this->db->where(array('customer.isDelete' => 0,'customer.isPointeForce' => 0));
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
	
	public function customer_user_list($start=0,$limit='',$where='')
    {
		$this->db->select('customer.*');
        $this->db->from('customer');
		$this->db->where(array('customer.isDelete' => 0,'customer.isPointeForce' => 0));
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
	
	public function customer_details($customerId)
    {
		$this->db->select('address.*,customer.*,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName');
        $this->db->from('customer');
		$this->db->join('customer_address','customer.customerId = customer_address.customerId');
		$this->db->join('address','customer_address.addressId = address.addressId');
		$this->db->join('country','address.country = country.countryId');
		$this->db->join('state', 'address.state = state.stateId','left');
        $this->db->join('area', 'address.area = area.areaId','left');
        $this->db->join('zip', 'address.city = zip.zipId','left');
		$this->db->where(array('customer.customerId' => $customerId,'customer.isDelete' => 0,'customer_address.addressTypeId' => 1,'customer_address.active' => 1));
        $result = $this->db->get()->row();
        return $result;
	}
	
	public function block_unblock_user($customerId,$status)
	{
		$updateOpt = array(
						'blockDate'		 => '0000-00-00',
			            'active' 		 => $status,
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
		$this->db->where(array('customer.customerId' => $customerId,'customer.isDelete' => 0));
        $this->db->update('customer',$updateOpt);
        return $this->db->affected_rows();	
	}
	
	public function add_block_unblock_history($customerId,$status)
	{
		 $insertOpt = array(
						'customerId' 	 => $customerId,
						'active'		 => $status,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
        $this->db->insert('customer_block_unblock_history',$insertOpt);
        return $this->db->insert_id();
	}
	
	public function update_black_list($customerId,$status)
	{
		$updateOpt = array(
			            'isBlackList' 	 => $status,
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
		$this->db->where(array('customer.customerId' => $customerId,'customer.isDelete' => 0));
        $this->db->update('customer',$updateOpt);
        return $this->db->affected_rows();	
	}
	
	public function add_black_list_history($customerId,$status)
	{
		 $insertOpt = array(
						'customerId' 	 => $customerId,
						'isBlackList'	 => $status,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
			        );
        $this->db->insert('customer_black_list_history',$insertOpt);
        return $this->db->insert_id();
	}
	
	public function black_list_customer_detail($customerId)
	{
		$this->db->where(array('customerId' => $customerId,'isDelete' => 0));
		$result = $this->db->get('customer')->row();
		return $result;
	}
	
	public function login_customer_detail($customerId)
	{
		$this->db->where(array('customerId' => $customerId,'isDelete' => 0));
		$result = $this->db->get('customer')->row();
		return $result;
	}
	
	public function update_block_date($userID)
    {
        $updateOpt = array(
		            	'blockDate'      => date('Y-m-d'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
			            'lastModifiedBy' => $this->session->userdata('userId'),
					);
        $this->db->where('customerId', $userID);
        $this->db->update('customer', $updateOpt);
        return $this->db->affected_rows();
    }
	
	public function customer_with_address_details($customerId,$addressId)
    {		
    	$this->db->select('address.addressLine1,address.firstName AS addressFirstName,address.lastName AS addressLastName,address.phone AS addressPhoneNo,country.name AS countryName,state.stateName,area.area AS areaName,zip.city AS cityName,customer.*');
        $this->db->from('customer');
        $this->db->join('customer_address', 'customer_address.customerId=customer.customerId');
        $this->db->join('address', 'address.addressId=customer_address.addressId');
        $this->db->join('country', 'address.country=country.countryId', 'left');
        $this->db->join('state', 'address.state=state.stateId', 'left');
        $this->db->join('area', 'address.area = area.areaId', 'left');
        $this->db->join('zip', 'address.city=zip.zipId');
		$this->db->where(array(
							'customer_address.customerId' => $customerId, 
							'customer.customerId'         => $customerId,
							'address.addressId'           => $addressId
						));
        $results = $this->db->get()->row();
        return $results;
    }

}