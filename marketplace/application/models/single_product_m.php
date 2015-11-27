<?php

class Single_product_m extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function single_product_detail($product_id)
    {
        $this->db->select('*');
        $this->db->from('organization_product');
        $this->db->join('product', 'product.productId=organization_product.productId');
        $this->db->join('brand', 'brand.brandId=product.brandId');
        $this->db->where('organization_product.productId', $product_id);
        $response = $this->db->get()->result();
        return $response;

    }
    public function product_images($product_id)
    {
        $this->db->select('*');
        $this->db->from('product_image');
        $this->db->where(array('product_image.productId' => $product_id,'active' => 1));
        $response   =  $this->db->get()->result();
        return $response;
    }
}