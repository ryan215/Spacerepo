<?php if(!defined ('BASEPATH'))
    exit( 'No direct script access allowed' );

    class Order_pickup_m extends MY_Model
    {
        public function __construct()
        {
            parent::__construct ();
        }

        public function total_new_order_in_shipping_admin($where = '')
        {	
			$this->db->select ('COUNT(*) AS total');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId', 'left');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
			$this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            if($this->session->userdata ('userType') == 'retailer')
			{
                $this->db->where ('(order.orderStatusId = 1 OR order.orderStatusId = 6)');
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
				$this->db->where(array('order.orderStatusId' => 1,'order.isPickup' => 1));
			}
			else 
			{
				$userRole = $this->session->userdata('userRole');
				if(!empty($userRole)) 
				{
					if($userRole == 'SVE') 
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
					}
				}
                $this->db->where('order.orderStatusId', 1);
                $this->db->where('order.isPickup', 1);
			}

            if($where) {
                $this->db->where ($where);
            }
			$this->db->where('order.active',1);
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            $result = $this->db->get()->row();
			$total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function delivered_order_details_pickup($orderId)
        {
            $this->db->select("order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,pickup.pickupName,order_payment.*,order.*");
            $this->db->from('order');
            $this->db->join('pickup','order.pickupId=pickup.pickupId','left');

         //   $this->db->join('shipping_rate', 'shipping_rate.shippingRateId=order.shippingRateId', 'left');
            $this->db->join('order_payment','order.orderId = order_payment.orderId');
            $this->db->join('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where(array('order.orderStatusId' => 1, 'order.orderId' => $orderId, 'order.isPickup' => 1,'order.active' => 1));
            $result = $this->db->get();
            return $result->row();
        }
		
		 public function delivered_order_details_pickup_for_other($orderId,$statusId)
        {
            $this->db->select("order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,pickup.pickupName,order_payment.*,order.*");
            $this->db->from('order');
            $this->db->join('pickup','order.pickupId=pickup.pickupId','left');

         //   $this->db->join('shipping_rate', 'shipping_rate.shippingRateId=order.shippingRateId', 'left');
            $this->db->join('order_payment','order.orderId = order_payment.orderId');
            $this->db->join('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where(array('order.orderStatusId' => $statusId, 'order.orderId' => $orderId, 'order.isPickup' => 1,'order.active' => 1));
            $result = $this->db->get();
            return $result->row();
        }

        public function new_pickup_order_list_in_shipping_admin($start = 0, $limit = '', $where = '')
        {
            $this->db->select ("organization_product.productId,organization_product.productCodeOveride,organization_product.currentPrice,organization.organizationName,employee.firstName,employee.lastName,product.code,order.*");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId', 'left');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
			$this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            if($this->session->userdata ('userType') == 'retailer')
			{
                $this->db->where ('(order.orderStatusId = 1 OR order.orderStatusId = 6)');
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
				$this->db->where(array('order.orderStatusId' => 1,'order.isPickup' => 1));
			}
			else 
			{
				$userRole = $this->session->userdata('userRole');
				if(!empty($userRole)) 
				{
					if($userRole == 'SVE') 
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
					}
				}
                $this->db->where('order.orderStatusId', 1);
                $this->db->where('order.isPickup', 1);
			}

            if($where) {
                $this->db->where ($where);
            }
			$this->db->where('order.active',1);
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();
        }

        public function new_pickup_order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            //$this->db->join('order_payment','order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderStatusId' => 1, 'order.orderId' => $orderId,'order.active' => 1 ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function total_confirmation_pickup_order($where = '')
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'order.shippingOrgId = organization.organizationId');
            if($this->session->userdata ('userType') == 'retailer') 
			{
                $this->db->where ('(order.orderStatusId = 2 OR order.orderStatusId = 3 OR order.orderStatusId = 4 OR order.orderStatusId = 5)');
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
				$this->db->where(array('order.orderStatusId' => 2,'order.isPickup' => 1));
			}
			else 
			{
				$userRole = $this->session->userdata ('userRole');
	            if(!empty($userRole)) 
				{
					if($userRole == 'SVE') 
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
	                }
	            }
                $this->db->where(array('order.orderStatusId' => 2,'order.isPickup' => 1));
            }
			
            if($where) 
			{
                $this->db->where ($where);
            }
			$this->db->where('order.active',1);
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function add_order_address($orderId, $addressId)
        {
            $insertOpt = array(
                'orderId'        => $orderId,
                'addressId'      => $addressId,
                'addressTypeId'  => 4,
                'active'         => 1,
                'createDt'       => date ('Y-m-d H:i:s'),
                'lastModifiedDt' => date ('Y-m-d H:i:s'),
                'lastModifiedBy' => $this->session->userdata ('userId'),
            );
            $this->db->insert ('order_address', $insertOpt);
            return $this->db->insert_id ();
        }


        public function confirmation_order_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ("organization_product.productId,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,organization_product.currentPrice,product.code,order_payment.*,order.*");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
			$this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            if($this->session->userdata ('userType') == 'retailer')
			{
                $this->db->where ('(order.orderStatusId = 2 OR order.orderStatusId = 3 OR order.orderStatusId = 4)');
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
				$this->db->where(array('order.orderStatusId' => 2,'order.isPickup' => 1));
			}
			else 
			{
				$userRole = $this->session->userdata ('userRole');
				if(!empty($userRole)) 
				{
					if($userRole == 'SVE') 
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
					}
				}
				$this->db->where(array('order.orderStatusId' => 2,'order.isPickup' => 1));
            }
			$this->db->where(array('order.active' => 1));
            if($where) 
			{
                $this->db->where ($where);
            }
			
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();
        }

        public function confirmation_order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderStatusId' => 2, 'order.orderId' => $orderId ));
            $result = $this->db->get ();
            //echo "<pre>";	print_r($result->row()); exit;
            return $result->row ();
        }

        public function ready_shipped_order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderStatusId' => 3, 'order.orderId' => $orderId ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function order_billing_details($customerId)
        {
            $this->db->select ('customer.*,address.*,country.name AS countryName,state.stateName,zip.city AS cityName');
            $this->db->from ('customer');
            $this->db->join ('customer_address', 'customer.customerId = customer_address.customerId');
            $this->db->join ('address', 'customer_address.addressId = address.addressId');
            $this->db->join ('country', 'address.country = country.countryId');
            $this->db->join ('state', 'address.state = state.stateId');
            $this->db->join ('zip', 'address.city = zip.zipId');
            $this->db->where (array( 'customer.customerId' => $customerId, 'customer_address.addressTypeId' => 4 ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function order_shipping_details($customerId)
        {
            $this->db->select ('address.*,country.name AS countryName,state.stateName,zip.city AS cityName');
            $this->db->from ('customer');
            $this->db->join ('customer_address', 'customer.customerId = customer_address.customerId');
            $this->db->join ('address', 'customer_address.addressId = address.addressId');
            $this->db->join ('country', 'address.country = country.countryId');
            $this->db->join ('state', 'address.state = state.stateId');
            $this->db->join ('zip', 'address.city = zip.zipId');
            $this->db->where (array( 'customer.customerId' => $customerId, 'customer_address.addressTypeId' => 3 ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function order_shipping_address_details($customerId, $orderId)
        {
            $this->db->select ('address.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
            $this->db->from ('order');
            $this->db->join ('customer', 'customer.customerId=order.customerId');
            $this->db->join ('order_address', 'order.orderId=order_address.orderId');
            $this->db->join ('address', 'order_address.addressId = address.addressId');
            $this->db->join ('country', 'address.country = country.countryId', 'left');
            $this->db->join ('state', 'address.state = state.stateId', 'left');
            $this->db->join ('area', 'address.area = area.areaId', 'left');
            $this->db->join ('zip', 'address.city = zip.zipId', 'left');
            $this->db->where (array( 'customer.customerId' => $customerId, 'order.orderId' => $orderId, 'order_address.addressTypeId' => 3 ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function order_retailer_details($organizationProductId)
        {
            $this->db->select ('organization.organizationId,organization.organizationName,organization.dropshipCentre,address.*,employee.*,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName,organization_product.productCodeOveride,organization_product.imageName AS productImageName,organization_product.currentPrice,dropship_center.dropCenterName');
            $this->db->from ('organization_product');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->join ('organization_address', 'organization.organizationId = organization_address.organizationId', 'left');
            $this->db->join ('address', 'organization_address.addressId = address.addressId', 'left');
            $this->db->join ('country', 'address.country = country.countryId', 'left');
            $this->db->join ('state', 'address.state = state.stateId', 'left');
            $this->db->join ('area', 'address.area = area.areaId', 'left');
            $this->db->join ('zip', 'address.city = zip.zipId', 'left');
            $this->db->join ('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId', 'left');
            $this->db->where (array( 'organization_product.organizationProductId' => $organizationProductId ));
            $result = $this->db->get ()->row ();
            return $result;
        }

        public function order_retailer_with_product_details($organizationProductId)
        {
            $this->db->select ('organization.organizationId,organization.organizationName,organization.dropshipCentre,address.*,employee.*,country.name AS countryName,state.stateName,zip.city AS cityName,organization_product.productCodeOveride,organization_product.currentPrice,product_image.imageName AS productImageName');
            $this->db->from ('organization_product');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('product_image', 'product.productId = product_image.productId');
            $this->db->join ('organization_address', 'organization.organizationId = organization_address.organizationId', 'left');
            $this->db->join ('address', 'organization_address.addressId = address.addressId', 'left');
            $this->db->join ('country', 'address.country = country.countryId', 'left');
            $this->db->join ('state', 'address.state = state.stateId', 'left');
            $this->db->join ('zip', 'address.city = zip.zipId', 'left');
            $this->db->where (array( 'organization_product.organizationProductId' => $organizationProductId, 'product_image.displayOrder' => 1 ));
            $result = $this->db->get ()->row ();
            return $result;
        }

        public function order_product_details($organizationProductId)
        {
            $this->db->select ('*');
            $this->db->from ('organization_product');
            $this->db->where (array( 'organizationProductId' => $organizationProductId ));
            $result = $this->db->get ()->row ();
            return $result;
        }

        public function order_shipping_vendor_details($shippingOrgId)
        {
            $this->db->select ("organization.organizationId,organization.organizationName,employee.imageName,employee.employeeId,employee.email,employee.businessPhone,employee.firstName,employee.middle,employee.lastName,employee.active,country.name AS countryName,country.phoneCode,state.stateName,zip.city AS cityName,area.area AS areaName,address.addressId,address.addressLine1,address.country,address.state,address.city,employee.businessPhoneCode");
            $this->db->from ('organization');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->join ('employee_address', 'employee.employeeId = employee_address.employeeId');
            $this->db->join ('address', 'employee_address.addressId = address.addressId');
            $this->db->join ('country', 'address.country = country.countryId');
            $this->db->join ('state', 'address.state = state.stateId', 'left');
            $this->db->join ('area', 'address.area = area.areaId', 'left');
            $this->db->join ('zip', 'address.city = zip.zipId', 'left');
            $this->db->join ('emp_role', 'employee.employeeId = emp_role.employeeId');
            $this->db->join ('role', 'role.roleID = emp_role.roleId');
            $this->db->join ('csr_organization', 'employee.employeeId = csr_organization.organizationId', 'left');
            $this->db->where (array( 'role.code' => 'DELIVERYAGENT', 'organization.organizationId' => $shippingOrgId ));
            $result = $this->db->get ()->row ();
            return $result;
        }

        public function change_new_order_to_ready($order_id, $where = '')
        {
            $this->db->where ("orderId = $order_id " . $where);
            $this->db->update ('order', array( 'orderStatusId' => 3, 'lastModifiedDt' => date ('Y-m-d H:i:s') ));
            return $this->db->affected_rows ();
        }

        public function total_ready_to_be_shipped_order($where = '')
        {
            $this->db->select('COUNT(*) AS total');
            $this->db->from('order');
            $this->db->join('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
			$this->db->join('shipping_rate', 'shipping_rate.shippingRateId = order.shippingRateId', 'left');
            if($this->session->userdata('userType') == 'retailer')
			{
            	$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
				$this->db->where(array('order.isPickup' => 1));
			}
			else 
			{
				$userRole = $this->session->userdata ('userRole');
				if(!empty($userRole)) 
				{
					if($userRole == 'SVE') 
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
					}
				}
                $this->db->where('order.isPickup',1);
            }
			
			$this->db->where(array('order.orderStatusId' => 3,'order.active' => 1));
            if($where)
			{
                $this->db->where ($where);
            }
            $result = $this->db->get()->row();
            $total = 0;
            if(!empty( $result )) 
			{
                $total = $result->total;
            }
            //echo $this->db->last_query(); exit;
            return $total;
        }

        public function ready_shipped_order_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ("organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,product.code,order_payment.*,order.*");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
			$this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
			$this->db->join ('shipping_rate', 'shipping_rate.shippingRateId = order.shippingRateId', 'left');
            $this->db->where (array('order.orderStatusId' => 3,'order.active' => 1));
            if($this->session->userdata ('userType') == 'retailer') 
			{
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
				$this->db->where(array('order.isPickup' => 1));
			}
			else 
			{
				$userRole = $this->session->userdata ('userRole');
				if(!empty($userRole)) 
				{
					if($userRole == 'SVE') 
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
					}
				}
                $this->db->where('order.isPickup',1);
            }
            
			if($where) 
			{
                $this->db->where ($where);
            }
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) 
			{
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get()->result();
            return $result;
        
		/*
            $this->db->select ("organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,product.code,order_payment.*,order.*");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('shipping_rate', 'shipping_rate.shippingRateId = order.shippingRateId', 'left');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
			$this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->where ('order.orderStatusId', 3);
            if($this->session->userdata ('userType') == 'retailer') {
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            } else {
                $this->db->where ('order.isPickup', 1);
            }

            $userRole = $this->session->userdata ('userRole');
            if(!empty( $userRole )) {
                if($userRole == 'DELIVERYAGENT') {
                    $this->db->where ('order.shippingOrgId', $this->session->userdata ('organizationId'));
                } elseif($userRole == 'SVE') {
                    $this->db->where ('order.shippingOrgId', $this->session->userdata ('parentOrganizationId'));
                }
            }
			$this->db->where('order.active',1);
            if($where) {
                $this->db->where ($where);
            }
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();

            return $result->result();
        */}

        public function change_to_pickup($order_id, $where = '')
        {
            $this->db->where("orderId = $order_id " . $where);
            $this->db->update('order',array('orderStatusId' => 5,'lastModifiedDt' => date('Y-m-d H:i:s'),'deliveredDate' => date('Y-m-d H:i:s'),'last_Modified_By' => $this->session->userdata('userId') ));
            return $this->db->affected_rows ();
        }

        public function total_shipped_in_transit_order($where = '')
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('order');
            $this->db->join ('shipping_rate', 'shipping_rate.shippingRateId=order.shippingRateId', 'left');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'order.shippingOrgId = organization.organizationId');
            $this->db->where ('order.orderStatusId', 4);
			$userRole = $this->session->userdata ('userRole');
            if($this->session->userdata ('userType') == 'retailer') {
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			}
            if(!empty( $userRole )) {
                if($userRole == 'DELIVERYAGENT') {
                    $this->db->where ('order.shippingOrgId', $this->session->userdata ('organizationId'));
                } elseif($userRole == 'SVE') {
                    $this->db->where ('order.shippingOrgId', $this->session->userdata ('parentOrganizationId'));
                }
            }
            if($where) {
                $this->db->where ($where);
            }
			$this->db->where('order.active',1);
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function shipped_in_transit_order_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ("order.*,order_payment.*,organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName");
            $this->db->from ('order');
            $this->db->join ('shipping_rate', 'shipping_rate.shippingRateId=order.shippingRateId', 'left');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->where ('order.orderStatusId', 4);
			$userRole = $this->session->userdata ('userRole');
            if($this->session->userdata ('userType') == 'retailer') 
			{
            	$this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			}
			if(!empty( $userRole )) 
			{
                if($userRole == 'DELIVERYAGENT') 
				{
                    $this->db->where ('order.shippingOrgId', $this->session->userdata ('organizationId'));
                }
				elseif($userRole == 'SVE') 
				{
                    $this->db->where ('order.shippingOrgId', $this->session->userdata ('parentOrganizationId'));
                }
            }
			
			$this->db->where('order.active',1);
            if($where) {
                $this->db->where ($where);
            }
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();
        }

        public function transit_order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderStatusId' => 4, 'order.orderId' => $orderId ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function total_delivered_order($where = '')
        {			
			$this->db->select('COUNT(*) AS total');
			$this->db->from('order');
			$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
			$this->db->join('order_payment','order.orderId = order_payment.orderId');
			$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
			$this->db->join('product','organization_product.productId = product.productId');
			$this->db->join('product_image','product.productId = product_image.productId');
			$this->db->join('organization','order.shippingOrgId = organization.organizationId');
			
			$this->db->where(array('order.orderStatusId' => 5,'product_image.displayOrder' => 1,'order.active' => 1,'order.isPickup' => 1));
			if($this->session->userdata('userType')=='retailer')
			{
				$this->db->where('organization_product.organizationId',$this->session->userdata('organizationId'));
			}
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			}
			else
			{
				$userRole = $this->session->userdata('userRole');
				if(!empty($userRole))
				{
					if($userRole=='DELIVERYAGENT')
					{
						$this->db->where('order.shippingOrgId',$this->session->userdata('organizationId'));
					}
					elseif($userRole=='SVE')
					{
						$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
					}
				}
			}
			if($where)
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

        public function delivered_order_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ("order.*,order_payment.*,organization_product.productId,organization_product.currentPrice,organization_product.productCodeOveride,organization.organizationName,employee.firstName,employee.lastName,product.code");
            $this->db->from ('order');
            $this->db->join ('shipping_rate', 'shipping_rate.shippingRateId=order.shippingRateId', 'left');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
			$this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
			$this->db->join ('product','organization_product.productId = product.productId');
            $this->db->where (array('order.orderStatusId' => 5,'order.isPickup' => 1));
            if($this->session->userdata ('userType') == 'retailer') 
			{
                $this->db->where ('organization_product.organizationId', $this->session->userdata ('organizationId'));
            }
			elseif($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			}
			else
			{
	            $userRole = $this->session->userdata ('userRole');
    	        if(!empty( $userRole )) 
				{
                	if($userRole == 'DELIVERYAGENT') 
					{
                    	$this->db->where ('order.shippingOrgId', $this->session->userdata ('organizationId'));
                	}
					elseif($userRole == 'SVE') 
					{
	                    $this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
	                }
				}
            }
			$this->db->where('order.active',1);
            if($where) 
			{
                $this->db->where ($where);
            }
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) 
			{
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();

            /*$this->db->select('*');
		$this->db->from('orders');
		$this->db->join('orders_info','orders.order_id = orders_info.order_id');
		$this->db->where("orders.status = 4 AND From_UnixTime(orders.order_time,'%Y') >= ".date("Y")." AND From_UnixTime(orders.order_time,'%m') >= ".date("m")." ".$where);
		$this->db->order_by('orders.last_modified_time','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();*/
        }

        public function delivered_order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('shipping_rate', 'shipping_rate.shippingRateId=order.shippingRateId', 'left');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderStatusId' => 5, 'order.orderId' => $orderId ));
            $result = $this->db->get ();
            return $result->row ();
        }

        public function total_history_order($where='')
        {
			$this->db->select('COUNT(*) AS total');
			$this->db->from('order');
			$this->db->join('order_payment','order.orderId = order_payment.orderId');
			$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
			
			$userRole = $this->session->userdata ('userRole');
			if($this->session->userdata('userType')=='cse')
			{			
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
			}
            if(!empty($userRole)) 
			{
				if($userRole == 'SVE') 
				{
					$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
                }
            }
			
			$this->db->where('(order.orderStatusId = 5 OR order.active = 0)');
			$this->db->where('order.isPickup',1);
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

	public function history_order_list($start = 0, $limit = '', $where = '')
    {
		$this->db->select("order_payment.*,organization_product.productId,organization_product.currentPrice,organization.organizationName,organization_product.productCodeOveride,employee.firstName,employee.lastName,product.*,product_image.*,order.*");
		$this->db->from('order');
		$this->db->join('shipping_rate','shipping_rate.shippingRateId=order.shippingRateId','left');
		$this->db->join('order_payment','order.orderId = order_payment.orderId');
		$this->db->join('organization_product','order.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$userRole = $this->session->userdata ('userRole');
		if($this->session->userdata('userType')=='cse')
		{			
			$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
		}
        elseif(!empty($userRole)) 
		{
			if($userRole == 'SVE') 
			{
				$this->db->join('order_dropship_center','order.orderId = order_dropship_center.orderId');
            }
        }
		$this->db->where(array('product_image.displayOrder' => 1,'order.isPickup' => 1));
		$this->db->where('(order.orderStatusId = 5 OR order.active = 0)');
		if(!empty($where))		
		{
			$this->db->where($where);
		}
		$this->db->order_by('order.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get();
		return $result->result();
	}

        public function change_accept_declined($order_id, $accept_decline)
        {
            $updateArr['orderStatusId'] = $accept_decline;
            $updateArr['lastModifiedDt'] = date ('Y-m-d H:i:s');
            $this->db->where ('orderId', $order_id);
            $this->db->update ('order', $updateArr);
            return $this->db->affected_rows ();
        }

        public function total_new_order($where = '')
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where ('orders.status = 1 ' . $where);
			$this->db->where('order.active',1);
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function change_transit_to_delivered($order_id, $where = '')
        {
            $this->db->where ("orderId = $order_id " . $where);
            $this->db->update ('order', array( 'orderStatusId' => 5, 'lastModifiedDt' => date ('Y-m-d H:i:s') ));
            return $this->db->affected_rows ();
        }


        public function history_order_details($orderId)
        {
			$this->db->select("order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode,pickup.pickupName,order.*");
            $this->db->from('order');
            $this->db->join('order_payment','order.orderId = order_payment.orderId');
			$this->db->join('pickup','order.pickupId=pickup.pickupId','left');			
            $this->db->join('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where(array('order.orderId' => $orderId, 'order.isPickup' => 1));
            $result = $this->db->get();
            return $result->row();
        }

        public function save_tracking_number($order_id, $track_no)
        {
            $this->db->where ('orderId', $order_id);
            $this->db->update ('order', array( 'trackingNbr' => $track_no, 'lastModifiedDt' => date ('Y-m-d H:i:s') ));
            return $this->db->affected_rows ();
        }

        public function save_delivered_date($order_id, $delivered_date)
        {
            $this->db->where ('orderId', $order_id);
            $this->db->update ('order', array( 'deliveredDate' => $delivered_date, 'lastModifiedDt' => date ('Y-m-d H:i:s') ));
            return $this->db->affected_rows ();
        }

        public function unique_order_id()
        {
            $order_id = 0;
            $this->db->select ('unique_order_id');
            $this->db->from ('product_identifiers');
            $result = $this->db->get ()->row ();
            if(!empty( $result )) {
                $order_id = $result->unique_order_id;
            }
            return $order_id;
        }

        public function update_unique_order_id($order_id)
        {
            $this->db->update ('product_identifiers', array( 'unique_order_id' => $order_id ));
            return $this->db->affected_rows ();
        }

        public function add_order($addArr)
        {
            $insertOpt = array(
                'orderTypeId'           => $addArr['orderTypeId'],
                'totalAmount'           => $addArr['totalAmount'],
                'quantity'              => $addArr['quantity'],
                'customerId'            => $addArr['customerId'],
                'chargedAmount'         => $addArr['chargedAmount'],
                'organizationProductId' => $addArr['organizationProductId'],
                'orderStatusId'         => $addArr['orderStatusId'],
                'shippingRateId'        => $addArr['shippingRateId'],
                'customOrderId'         => $addArr['customOrderId'],
                'orderEmail'            => $addArr['orderEmail'],
                'shippingOrgId'         => $addArr['shippingOrgId'],
                'colorId'               => $addArr['colorId'],
                'size'                  => $addArr['size'],
                'atATimeProduct'        => $addArr['atATimeProduct'],
                'createDt'              => date ('Y-m-d H:i:s'),
                'last_Modified_By'      => $this->session->userdata ('userId'),
                'lastModifiedDt'        => date ('Y-m-d H:i:s'),
            );
            $this->db->insert ('order', $insertOpt);
            return $this->db->insert_id ();
        }

        public function add_order_payment($orderId, $addArr)
        {
            $insertOpt = array(
                'orderId'         => $orderId,
                'paymentTypeId'   => 1,
                'amount'          => $addArr['totalAmount'],
                'paymentRef'      => $addArr['payment_reference'],
                'retrievalRef'    => $addArr['retrieval_reference'],
                'transactionRef'  => $addArr['transaction_reference'],
                'merchantRef'     => $addArr['merchant_reference'],
                'transactionDate' => $addArr['transaction_date'],
                'createDt'        => date ('Y-m-d H:i:s'),
                'lastModifiedBy'  => $this->session->userdata ('userId'),
                'lastModifiedDt'  => date ('Y-m-d H:i:s'),
            );
            $this->db->insert ('order_payment', $insertOpt);
            return $this->db->insert_id ();
        }

        public function add_order_track_details($orderId, $orderStatusId)
        {
            $insertOpt = array(
                'orderId'          => $orderId,
                'orderStatusId'    => $orderStatusId,
                'lastModifiedBy'   => $this->session->userdata ('userId'),
                'createTime'       => time (),
                'lastModifiedTime' => time (),
            );
            $this->db->insert ('order_track_details', $insertOpt);
            return $this->db->insert_id ();
        }

        public function settlement_report_details($order_id)
        {
            $this->db->select ('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array( 'orders.status' => 4, 'orders.order_id' => $order_id ));
            $result = $this->db->get ();
            return $result->result ();

        }

        public function send_to_finance_admin($order_id)
        {
            $this->db->where ("order_id", $order_id);
            $this->db->update ('orders', array( 'send_to_finance' => 1 ));
            return $this->db->affected_rows ();
        }

        public function clearness($order_id)
        {
            $this->db->where ("order_id", $order_id);
            $this->db->update ('orders', array( 'clearness' => 1 ));
            return $this->db->affected_rows ();
        }

        public function total_new_order_last7_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 1,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ("-1 week")
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_ready_to_be_shipped_order_last7_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 2,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ("-1 week")
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_shipped_in_transit_order_last7_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 3,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ('-1 week')
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_delivered_order_last7_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 4,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ('-1 week')
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_new_order_last30_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 1,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ("-1 month")
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_ready_to_be_shipped_order_last30_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 2,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ("-1 month")
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_shipped_in_transit_order_last30_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 3,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ("-1 month")
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_delivered_order_last30_days()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array(
                'orders.status' => 4,
                'order_time < ' => strtotime ('today'),
                'order_time >=' => strtotime ("-1 month")
            ));

            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function track_order($order_id)
        {
            $this->db->select ('*');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId	 = organization_product.organizationProductId	');
            $this->db->join ('shipping_rate', 'order.shippingOrgId = shipping_rate.shippingOrgId');
            $this->db->where (array( 'order.customerId' => $this->session->userdata ('userId'), 'order.orderId' => $order_id ));
            $this->db->order_by ('order.orderStatusId', 'asc');
            $result = $this->db->get ();
            return $result->row ();
        }

        public function user_order_list($customerId)
        {
            $this->db->select ('order.*,order_payment.*,organization_product.*,order.createDt AS orderDate,product_image.imageName AS mainImage,colors.colorCode');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId	 = organization_product.organizationProductId	');
            $this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('product_image', 'product.productId = product_image.productId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.customerId' => $customerId, 'product_image.displayOrder' => 1 ));
            $this->db->order_by ('order.orderStatusId', 'asc');
            $result = $this->db->get ();
            return $result->result ();
        }

        public function track_order_details($orderId)
        {
            $this->db->select ('order.*,order_payment.*,organization_product.*,order.createDt AS orderDate,order.lastModifiedDt,product_image.imageName AS mainImage,colors.colorCode');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId	 = organization_product.organizationProductId	');
            $this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('product_image', 'product.productId = product_image.productId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderId' => $orderId, 'product_image.displayOrder' => 1 ));
            $this->db->order_by ('order.orderStatusId', 'asc');
            $result = $this->db->get ();
            return $result->row ();
        }

        public function user_dashboard_order_list()
        {
            $this->db->select ('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where ('orders.user_id', $this->session->userdata ('userId'));
            $this->db->order_by ('orders.last_modified_time', 'desc');
            $this->db->limit (2);
            $result = $this->db->get ();
            return $result->result ();
        }

        public function purchase_product($productId)
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array( 'orders.user_id' => $this->session->userdata ('userId'), 'orders_info.product_id' => $productId ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function purchase_product_with_retailer($seller_id)
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array( 'orders.user_id' => $this->session->userdata ('userId'), 'orders_info.retailer_id' => $seller_id ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_order_with_product_rating_review($productId)
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('product_rating', 'orders_info.product_id = product_rating.product_id');
            $this->db->join ('product_rating_count', 'product_rating.product_rating_id = product_rating_count.product_rating_id');
            $this->db->where (array( 'orders.user_id' => $this->session->userdata ('userId'), 'product_rating.rating_given_by' => $this->session->userdata ('userId') ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function order_with_product_rating_review()
        {
            $this->db->select ('product_rating.*,product_rating_count.*,orders_info.product_id AS order_product_id,orders_info.product_name,orders_info.product_image,orders_info.product_price,orders_info.product_price,orders.delivered_date,orders.status,orders.estimate_time');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('product_rating', 'orders_info.product_id = product_rating.product_id AND product_rating.rating_given_by = ' . $this->session->userdata ('userId'), 'left');
            $this->db->join ('product_rating_count', 'product_rating.product_rating_id = product_rating_count.product_rating_id', 'left');
            $this->db->where ('orders.user_id', $this->session->userdata ('userId'));
            $this->db->order_by ('orders.last_modified_time', 'desc');
            $result = $this->db->get ();
            return $result->result ();
        }

        public function order_with_retailer_rating_review()
        {
            $this->db->select ('retailer_rating.*,retailer_rating_count.*,orders_info.product_id AS order_product_id,orders_info.product_name,orders_info.product_image,orders_info.product_price,orders_info.product_price,orders.delivered_date,orders.status,orders.estimate_time,orders_info.retailer_name,orders_info.retailer_id AS order_retailer_id');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('retailer_rating', 'orders_info.retailer_id = retailer_rating.retailer_id AND retailer_rating.rating_given_by = ' . $this->session->userdata ('userId'), 'left');
            $this->db->join ('retailer_rating_count', 'retailer_rating.retailer_id = retailer_rating_count.retailer_id', 'left');
            $this->db->where ('orders.user_id', $this->session->userdata ('userId'));
            $this->db->group_by ('orders_info.retailer_id');
            $this->db->order_by ('orders.last_modified_time', 'desc');
            $result = $this->db->get ();
            return $result->result ();
        }

        public function total_sale_amount_product()
        {
            $this->db->select ('SUM(orders.total_amount) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_sale_amount_retailer_cse()
        {
            $this->db->select ('SUM(orders.total_amount) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('users', 'orders_info.retailer_id = users.user_id');
            $this->db->join ('profile', 'users.user_id = profile.user_id');
            $this->db->join ('cse_assing_to_retailer', 'users.user_id = cse_assing_to_retailer.retailer_id');
            $this->db->where (array( 'users.user_type' => 'retailer', 'cse_assing_to_retailer.cse_id' => $this->session->userdata ('userId') ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_product_sale_by_retailer($segment_id)
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('product', 'orders_info.product_id = product.product_id');
            $this->db->join ('product_image', 'product.product_id = product_image.product_id');
            $this->db->join ('product_attribute', 'product.product_id = product_attribute.product_id');
            $this->db->join ('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id');
            $this->db->where (array(
                'product.segment_id'   => $segment_id,
                'product_image.status' => 1,
                'product.block_status' => 1
            ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_retailer_sale_product($segment_id)
        {
            $this->db->select ('COUNT(orders_info.retailer_id) AS total');
            //$this->db->select('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('product', 'orders_info.product_id = product.product_id');
            $this->db->where (array(
                'product.segment_id'   => $segment_id,
                'product.block_status' => 1
            ));
            $this->db->group_by ('orders_info.retailer_id');
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function total_new_order_in_month()
        {
            $res = "SELECT COUNT(*) AS total,From_UnixTime(order_time,'%d-%m-%Y') AS order_date,From_UnixTime(order_time,'%b') AS order_month FROM orders INNER JOIN orders_info ON orders.order_id = orders_info.order_id WHERE orders.status = 1 GROUP BY order_month";
            return $result = $this->db->query ($res)->result ();
        }

        public function total_order_in_month_vendor($month_name)
        {
            $res = "SELECT COUNT(*) AS total,shipping_vendor_id,shipping_vendor_name,From_UnixTime(order_time,'%d-%m-%Y') AS order_date,From_UnixTime(order_time,'%b') AS order_month FROM orders INNER JOIN orders_info ON orders.order_id = orders_info.order_id WHERE From_UnixTime(order_time,'%b') = '" . $month_name . "'  GROUP BY shipping_vendor_id";
            return $result = $this->db->query ($res)->result ();
        }

        public function total_orders()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            if($this->session->userdata ('userType') == 'retailer') {
                $this->db->where ('orders_info.retailer_id', $this->session->userdata ('userId'));
            }
            $this->db->where ('orders.accept_decline != ', 0);
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function orders_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            if($this->session->userdata ('userType') == 'retailer') {
                $this->db->where ('orders_info.retailer_id', $this->session->userdata ('userId'));
            }
            $this->db->where ('orders.accept_decline != ', 0);
            $this->db->order_by ('orders.last_modified_time', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();
        }

        public function total_proceed_orders()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            if($this->session->userdata ('userType') == 'retailer') {
                $this->db->where ('orders_info.retailer_id', $this->session->userdata ('userId'));
            }
            $this->db->where (array( 'orders.accept_decline' => 1, 'orders.status != ' => 4 ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function proceed_orders_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            if($this->session->userdata ('userType') == 'retailer') {
                $this->db->where ('orders_info.retailer_id', $this->session->userdata ('userId'));
            }
            $this->db->where (array( 'orders.accept_decline' => 1, 'orders.status != ' => 4 ));
            $this->db->order_by ('orders.last_modified_time', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();
        }

        public function total_retailer_delivered_orders()
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array( 'orders.status' => 4, 'orders_info.retailer_id' => $this->session->userdata ('userId') ));
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function retailer_delivered_orders_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->where (array( 'orders.status' => 4, 'orders_info.retailer_id' => $this->session->userdata ('userId') ));
            $this->db->order_by ('orders.last_modified_time', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            return $result->result ();
        }

        public function order_with_product_details($order_id)
        {
            $this->db->select ('*');
            $this->db->from ('orders');
            $this->db->join ('orders_info', 'orders.order_id = orders_info.order_id');
            $this->db->join ('product', 'orders_info.product_id = product.product_id');
            $this->db->join ('product_attribute', 'product.product_id = product_attribute.product_id');
            $this->db->join ('segment', 'product.segment_id = segment.segment_id', 'left');
            $this->db->join ('category', 'product.category_id = category.category_id', 'left');
            $this->db->join ('brand', 'product_attribute.brand_id = brand.brand_id', 'left');
            $this->db->where ('orders.order_id', $order_id);
            $result = $this->db->get ();
            return $result->row ();
        }

        public function order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.orderId' => $orderId ));
            $result = $this->db->get ();
            return $result->row ();
        }


        public function update_order_info($order_id, $updateArr)
        {
            $updateOpt = array(
                'product_price'      => $updateArr['product_price'],
                'retailer_id'        => $updateArr['retailer_id'],
                'retailer_name'      => $updateArr['retailer_name'],
                'retailer_email'     => $updateArr['retailer_email'],
                'retailer_phone_no'  => $updateArr['retailer_phone_no'],
                'retailer_address'   => $updateArr['retailer_address'],
                'sub_total'          => $updateArr['sub_total'],
                'last_modified_by'   => $this->session->userdata ('userId'),
                'last_modified_time' => $this->currentTimestamp,
            );
            $this->db->where ('order_id', $order_id);
            $this->db->update ('orders_info', $updateOpt);
            return $this->db->affected_rows ();
        }

        public function update_order($order_id, $updateArr)
        {
            $updateOpt = array(
                'total_amount'       => $updateArr['total_amount'],
                'accept_decline'     => 0,
                'last_modified_by'   => $this->session->userdata ('userId'),
                'last_modified_time' => $this->currentTimestamp,
            );
            $this->db->where ('order_id', $order_id);
            $this->db->update ('orders', $updateOpt);
            return $this->db->affected_rows ();
        }

        public function retailer_customer_shipper_details($orderId)
        {


        }

        public function success_order_list($atATimeProduct)
        {
            $this->db->select ('organization_product.*,order_payment.*,order.*,colors.colorCode');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId	 = organization_product.organizationProductId	');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where (array( 'order.customerId' => $this->session->userdata ('userId'), 'order.orderStatusId' => 1, 'order.atATimeProduct' => $atATimeProduct ));
            $result = $this->db->get ();
            //echo $this->db->last_query(); exit;
            return $result->result ();
        }

        public function last_order_id()
        {
            $this->db->order_by ('customOrderId', 'desc');
            $result = $this->db->get ('order')->row ();
            $customOrderId = 1000000;
            if(!empty( $result )) {
                $customOrderId = $result->customOrderId + 1;
            }
            if($customOrderId == 1) {
                $customOrderId = 1000000;
            }
            return $customOrderId;
        }

        public function last_atATimeProduct_id()
        {
            $this->db->order_by ('orderId', 'desc');
            $result = $this->db->get ('order')->row ();
            $atATimeProduct = 1;
            if(!empty( $result )) {
                $atATimeProduct = $result->atATimeProduct + 1;
            }
            return $atATimeProduct;
        }

        public function shipping_rate_details($shippingOrgId, $shippingRateId)
        {
            $this->db->where (array( 'shippingRateId' => $shippingRateId, 'shippingOrgId' => $shippingOrgId ));
            $result = $this->db->get ('shipping_rate');
            return $result->row ();
        }

        public function track_order_time_details($orderId)
        {
            $this->db->where ('orderId', $orderId);
            $this->db->order_by ('createTime', 'ASC');
            $result = $this->db->get ('order_track_details');
            return $result->result ();
        }

        public function total_search_order($where = '')
        {
            $this->db->select ('COUNT(*) AS total');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->join ('customer', 'order.customerId = customer.customerId');
            $this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('product_image', 'product.productId = product_image.productId');
            $this->db->join ('shipping_rate', 'order.shippingRateId = shipping_rate.shippingRateId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where ('product_image.displayOrder', 1);
            if($where) {
                $this->db->where ($where);
            }
            $result = $this->db->get ()->row ();
            $total = 0;
            if(!empty( $result )) {
                $total = $result->total;
            }
            return $total;
        }

        public function search_order_list($start = 0, $limit = '', $where = '')
        {
            $this->db->select ("order.*,order_payment.*,organization_product.productId,organization_product.productCodeOveride,organization_product.currentPrice,organization.organizationName,employee.firstName,employee.lastName,customer.firstName AS cfirstName,customer.lastName AS clastName,product.code,product_image.imageName AS productImageName,shipping_rate.amount AS shippingAmount,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('organization_product', 'order.organizationProductId = organization_product.organizationProductId');
            $this->db->join ('organization', 'organization_product.organizationId = organization.organizationId');
            $this->db->join ('employee', 'organization.organizationId = employee.organizationId');
            $this->db->join ('customer', 'order.customerId = customer.customerId');
            $this->db->join ('product', 'organization_product.productId = product.productId');
            $this->db->join ('product_image', 'product.productId = product_image.productId');
            $this->db->join ('shipping_rate', 'order.shippingRateId = shipping_rate.shippingRateId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where ('product_image.displayOrder', 1);
            if($where) {
                $this->db->where ($where);
            }
            $this->db->order_by ('order.lastModifiedDt', 'DESC');
            if(!empty( $limit )) {
                $this->db->limit ($limit, $start);
            }
            $result = $this->db->get ();
            //echo $this->db->last_query(); exit;
            return $result->result ();
        }

        public function search_order_details($orderId)
        {
            $this->db->select ("order.*,order_payment.*,order.lastModifiedDt AS orderLastModfiedDt,colors.colorCode");
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order.orderId = order_payment.orderId');
            $this->db->join ('colors', 'order.colorId = colors.colorId', 'left');
            $this->db->where ('order.orderId', $orderId);
            $result = $this->db->get ();
            return $result->row ();
        }

        public function add_order_marketing($addArr)
        {
            $insertOpt = array(
                'orderTypeId'        => $addArr['orderTypeId'],
                'totalAmount'        => $addArr['totalAmount'],
                'quantity'           => $addArr['quantity'],
                'customerId'         => $addArr['customerId'],
                'marketingProductId' => $addArr['marketingProductId'],
                'orderStatusId'      => $addArr['orderStatusId'],
                'shippingRateId'     => $addArr['shippingRateId'],
                'customOrderId'      => $addArr['customOrderId'],
                'orderEmail'         => $addArr['orderEmail'],
                'shippingOrgId'      => $addArr['shippingOrgId'],
                'colorId'            => $addArr['colorId'],
                'size'               => $addArr['size'],
                'newsletterId'       => $addArr['newsletterId'],
                'atATimeProduct'     => $addArr['atATimeProduct'],
                'createDt'           => date ('Y-m-d H:i:s'),
                'last_Modified_By'   => $this->session->userdata ('userId'),
                'lastModifiedDt'     => date ('Y-m-d H:i:s'),
            );
            $this->db->insert ('marketing_order', $insertOpt);
            return $this->db->insert_id ();
        }

        public function add_order_payment_marketing($orderId, $addArr)
        {
            $insertOpt = array(
                'orderId'         => $orderId,
                'paymentTypeId'   => 1,
                'amount'          => $addArr['totalAmount'],
                'paymentRef'      => $addArr['payment_reference'],
                'retrievalRef'    => $addArr['retrieval_reference'],
                'transactionRef'  => $addArr['transaction_reference'],
                'merchantRef'     => $addArr['merchant_reference'],
                'transactionDate' => $addArr['transaction_date'],
                'createDt'        => date ('Y-m-d H:i:s'),
                'lastModifiedBy'  => $this->session->userdata ('userId'),
                'lastModifiedDt'  => date ('Y-m-d H:i:s'),
            );
            $this->db->insert ('marketing_order_payment', $insertOpt);
            return $this->db->insert_id ();
        }

        public function add_marketing_order_track_details($orderId, $orderStatusId)
        {
            $insertOpt = array(
                'orderId'          => $orderId,
                'orderStatusId'    => $orderStatusId,
                'lastModifiedBy'   => $this->session->userdata ('userId'),
                'createTime'       => time (),
                'lastModifiedTime' => time (),
            );
            $this->db->insert ('marketing_order_track_details', $insertOpt);
            return $this->db->insert_id ();
        }

        public function reduce_product_quantity($organizationProductId, $quantity)
        {
            $sql = "UPDATE `organization_product` SET `currentQty` = `currentQty` - $quantity WHERE `organizationProductId` = '$organizationProductId'";
            $this->db->query ($sql);
            return $this->db->affected_rows ();
        }

        public function reduce_product_color_quantity($organizationProductId, $colorId, $quantity)
        {
            $sql = "UPDATE `organization_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `organizationProductId` = '$organizationProductId' AND `colorId` = '$colorId'";
            $this->db->query ($sql);
            return $this->db->affected_rows ();
        }

        public function reduce_product_size_quantity($organizationProductId, $sizeId, $quantity)
        {
            $sql = "UPDATE `organization_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `organizationProductId` = '$organizationProductId' AND `size` = '$sizeId'";
            $this->db->query ($sql);
            return $this->db->affected_rows ();
        }

        public function reduce_product_quantity_from_marketing($organizationProductId, $quantity)
        {
            $sql = "UPDATE `marketing_product` SET `currentQty` = `currentQty` - $quantity WHERE `organizationProductId` = '$organizationProductId'";
            $this->db->query ($sql);
            return $this->db->affected_rows ();
        }

        public function marketing_product_id($organizationProductId)
        {
            $this->db->where ('organizationProductId', $organizationProductId);
            $result = $this->db->get ('marketing_product')->row ();
            $marketingProductId = 0;
            if($result) {
                $marketingProductId = $result->marketingProductId;
            }
            return $marketingProductId;
        }

        public function reduce_product_color_quantity_from_marketing($marketingProductId, $colorId, $quantity)
        {
            $sql = "UPDATE `marketing_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `marketingProductId` = '$marketingProductId' AND `colorId` = '$colorId'";
            $this->db->query ($sql);
            return $this->db->affected_rows ();
        }

        public function reduce_product_size_quantity_from_marketing($marketingProductId, $sizeId, $quantity)
        {
            $sql = "UPDATE `marketing_size_stock` SET `currentStock` = `currentStock` - $quantity WHERE `marketingProductId` = '$marketingProductId' AND `size` = '$sizeId'";
            $this->db->query ($sql);
            return $this->db->affected_rows ();
        }

    }