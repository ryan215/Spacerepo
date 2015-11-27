<?php
class Api_product_sale_m extends MY_Model{

	public function __construct()
	{
		parent::__construct();		
	}
	public function add_order($insertOpt)
	{

		$this->db->insert_batch('order',$insertOpt);
		return $this->db->affected_rows();
	}
	public function last_order_id() 
	{
		$this->db->order_by('customOrderId','desc');
		$result = $this->db->get('order')->row();
		return $result->customOrderId;
	}

	public function add_order_payment($insertOpt)
	{

		$this->db->insert('order_payment',$insertOpt);
		return $this->db->insert_id();
	}
	public function get_order_detail($orderId)
	{
			$this->db->select ('organization_product.*,order.*,order_payment.paymentTypeId,organization.*');
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order_payment.orderId=order.customOrderId');
			$this->db->join('customer','order.customerId=customer.customerId','left');
			$this->db->join ('organization_product', 'order.organizationProductId=organization_product.organizationProductId');
			$this->db->join('organization','organization.organizationId=organization_product.organizationId');
            $this->db->where('order.customOrderId',$orderId);
			//$this->db->order_by('order.orderId');
            $query = $this->db->get ();
            return $query->result ();
	}
}