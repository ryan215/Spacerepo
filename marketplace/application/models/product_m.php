<?php
class Product_m extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function check_product_name($productName, $productId = '')
    {
        //$this->db->select("replace(code,' ','') AS productName");
        if ($productId) {
            $this->db->where('productId !=', $productId);
        }
        $this->db->where('trim(code)', $productName);
        //$this->db->where("REPLACE(LCASE(code),' ','')",strtolower($productName));		 
        $this->db->where('(verificationResultId = 2 OR verificationResultId = 3 OR verificationResultId = 4 OR verificationResultId = 5)');
        //$this->db->having('LCASE(productName)',str_replace(' ',''strtolower($productName)));
        $result = $this->db->get('product');
        //echo $this->db->last_query(); exit;
        return $result->row();
    }

    public function get_product_color_and_size($organizationProductId)
    {
        $this->db->select('*');
        $this->db->from('organization_size_stock');
        $this->db->join('colors', 'organization_size_stock.colorId = colors.colorId', 'left');
        $this->db->where('organizationProductId', $organizationProductId);
        $result = $this->db->get();
        return $result->result();
    }

    public function get_product_all_color_and_size($ProductId)
    {
        $this->db->select('organization_size_stock.*,colors.*,organization_product.*,organization.*');
        $this->db->from('organization_size_stock');
        $this->db->join('colors', 'organization_size_stock.colorId = colors.colorId', 'left');
        $this->db->join('organization_product', 'organization_product.organizationProductId = organization_size_stock.organizationProductId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->where('organization_product.productId',$ProductId);
        $this->db->order_by('organization_product.currentPrice', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }

    public function total_retailer_product_history()
    {
        $getOpt = array(
            'select' => 'COUNT(*) AS total',
            'table' => 'product',
            'join' => array('product_attribute' => 'product.product_id = product_attribute.product_id'),
            'single' => true,
            'where' => array(
                'product.is_admin' => 0,
                'product.status !=' => 'Request'
            )
        );
        $result = $this->common_model->customGet($getOpt);
        $total = 0;
        if ($result) {
            $total = $result->total;
        }
        return $total;
    }

    public function product_commission()
    {
        $getOpt = array(
            'table' => 'product_identifiers',
            'select' => 'product_commission',
            'single' => true
        );
        $result = $this->common_model->customGet($getOpt);
        $commission = 0;
        if (!empty($result)) {
            $commission = $result->product_commission;
        }
        return $commission;
    }

    public function update_product_attribute_tax($product_id, $tax = 0)
    {
        $updateOpt = array(
            'table' => 'product_attribute',
            'where' => array('product_id' => $product_id),
            'data' => array('tax' => $tax),
        );
        return $this->common_model->customUpdate($updateOpt);
    }


    //	Function for accept by admin or admin add prodcut total
    public function total_accept_or_admin($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product');
        $this->db->join('product_image', 'product.product_id = product_image.product_id');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->where("product_image.status = 1 AND (product.is_admin = 1 OR product.status = 'Accepted') " . $where);
        $result = $this->db->get()->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    //	Function for prodcut list witch product accept by admin or add by admin
    public function accept_or_admin_list($start, $limit = '', $where = '')
    {
        $limitstr = '';
        if (!empty($limit)) {
            $limitstr = " LIMIT $start,$limit ";
        }
        $sql = "SELECT
			   		product.*,
					product_attribute.product_attribute_key,
					(
						SELECT
							product_image.product_image_name
						FROM
							product_image
						WHERE
							product_image.product_id = product.product_id
						AND
							product_image.status = 1	
					)
					AS main_image,
					(
						SELECT 
							CONCAT(profile.first_name,' ',profile.last_name)
						FROM
							profile
						WHERE
							profile.user_id = product.last_modified_by
						LIMIT 1
					)
					AS modified_by	
				FROM
					product
				INNER JOIN
					product_attribute
				ON
					product.product_id = product_attribute.product_id
				WHERE
				(
					product.is_admin = 1
				OR
					product.status = 'Accepted'
			   )				
			   " . $where . "
			   ORDER BY
			   		product.last_modified_time
				DESC
			   " . $limitstr;
        return $this->common_model->customQuery($sql);
    }

    public function total_product_with_inventory()
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product');
        $this->db->join('product_image', 'product.product_id = product_image.product_id');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id');
        $this->db->join('profile', 'retailer_product_detail.last_modified_by = profile.user_id');
        $this->db->where(array('product_image.status' => 1, 'product.block_status' => 1));
        if ($this->session->userdata('userType') == 'retailer') {
            $this->db->where('retailer_product_detail.last_modified_by', $this->session->userdata('userId'));
        }
        $result = $this->db->get()->row();
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function product_with_inventory_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product.*,product_image.product_image_name AS image_name,retailer_product_detail.*,profile.bussiness_name');
        $this->db->from('product');
        $this->db->join('product_image', 'product.product_id = product_image.product_id');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id');
        $this->db->join('profile', 'retailer_product_detail.last_modified_by = profile.user_id');
        $this->db->where(array('product_image.status' => 1, 'product.block_status' => 1));
        if ($this->session->userdata('userType') == 'retailer') {
            $this->db->where('retailer_product_detail.last_modified_by', $this->session->userdata('userId'));
        }
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get()->result();
        return $result;
    }

    public function retailer_inventry_details($product_details_id)
    {
        $this->db->where(array(
            'product_detail_id' => $product_details_id,
            'last_modified_by' => $this->session->userdata('userId'),
        ));
        $result = $this->db->get('retailer_product_detail')->row();
        return $result;
    }

    public function product_with_inventory_details($product_id)
    {
        $this->db->select('product.*,product_image.product_image_name AS image_name,retailer_product_detail.*,profile.bussiness_name AS username');
        $this->db->from('product');
        $this->db->join('product_image', 'product.product_id = product_image.product_id');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id');
        $this->db->join('profile', 'retailer_product_detail.last_modified_by = profile.user_id');
        $this->db->where(array('product_image.status' => 1, 'product.product_id' => $product_id, 'product.block_status' => 1));
        $result = $this->db->get()->row();
        return $result;
    }

    public function product_attributes_list($where = '')
    {
        $sql = " SELECT * FROM product_attribute " . $where . " ORDER BY last_modified_time DESC ";
        $result = $this->common_model->customQuery($sql);
        return $result;
    }

    public function total_product_accept_by_admin()
    {
        $getOpt = array(
            'table' => 'product',
            'select' => 'COUNT(*) AS total',
            'join' => array('product_attribute' => 'product.product_id = product_attribute.product_id'),
            'where' => array(
                'product.status' => 'Accepted',
                'product.is_admin' => 0,
                'product.last_modified_by' => $this->session->userdata('userId'),
            ),
            'single' => true
        );

        $result = $this->common_model->customGet($getOpt);
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function total_prodcut_add_by_admin()
    {
        $getOpt = array(
            'table' => 'product',
            'select' => 'COUNT(*) AS total',
            'join' => array('product_attribute' => 'product.product_id = product_attribute.product_id'),
            'where' => array('product.is_admin' => 1,),
            'single' => true
        );

        $result = $this->common_model->customGet($getOpt);
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function add_attributes($addArr)
    {
        $insertOpt = array(
            'table' => 'attributes_desc',
            'data' => array(
                'segment_id' => $addArr['segment_id'],
                'category_id' => $addArr['category_id'],
                'sub_category1_id' => $addArr['sub_category1_id'],
                'sub_category2_id' => $addArr['sub_category2_id'],
                'sub_category3_id' => $addArr['sub_category3_id'],
                'sub_category4_id' => $addArr['sub_category4_id'],
                'sub_category5_id' => $addArr['sub_category5_id'],
                'sub_category6_id' => $addArr['sub_category6_id'],
                //'attribute_desc'     => json_encode($addArr['attribute_desc']),
                //'required_type'      => json_encode($addArr['required_type']),
                'colors' => json_encode($addArr['colors']),
                //'tooltip'			 => json_encode($addArr['tooltip']),
                //'required_optional'  => json_encode($addArr['required_optional']),										
                'last_modified_by' => $this->session->userdata('userId'),
                'last_modified_time' => $this->currentTimestamp,
            ),
        );
        return $this->common_model->customInsert($insertOpt);
    }

    public function add_attributes_title($attribute_id, $addArr)
    {
        $insertOpt = array(
            'attribute_id' => $attribute_id,
            'attribute_title' => $addArr['attribute_title'],
            'attribute_desc' => json_encode($addArr['attribute_desc']),
            'required_type' => json_encode($addArr['required_type']),
            //'colors'			 => json_encode($addArr['colors']),
            'tooltip' => json_encode($addArr['tooltip']),
            'required_optional' => json_encode($addArr['required_optional']),
        );
        $this->db->insert('attributes_desc_value', $insertOpt);
        return $this->db->insert_id();
    }

    public function total_attributes($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('attributes_desc');
        $this->db->join('segment', 'attributes_desc.segment_id = segment.segment_id', 'left');
        $this->db->join('category', 'attributes_desc.category_id = category.category_id', 'left');
        $this->db->join('sub_category', 'attributes_desc.sub_category1_id = sub_category.sub_category_id', 'left');
        $this->db->join('sub_category2', 'attributes_desc.sub_category2_id = sub_category2.sub_category2_id', 'left');
        $this->db->join('sub_category3', 'attributes_desc.sub_category3_id = sub_category3.sub_category3_id', 'left');
        $this->db->join('sub_category4', 'attributes_desc.sub_category4_id = sub_category4.sub_category4_id', 'left');
        $this->db->join('sub_category5', 'attributes_desc.sub_category5_id = sub_category5.sub_category5_id', 'left');
        $this->db->join('sub_category6', 'attributes_desc.sub_category6_id = sub_category6.sub_category6_id', 'left');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function attributes_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('attributes_desc.*,segment.segment_name,category.category_name,sub_category.sub_category_name,sub_category2.sub_category2_name,sub_category3.sub_category3_name,sub_category4.sub_category4_name,sub_category5.sub_category5_name,sub_category6.sub_category6_name');
        $this->db->from('attributes_desc');
        $this->db->join('segment', 'attributes_desc.segment_id = segment.segment_id', 'left');
        $this->db->join('category', 'attributes_desc.category_id = category.category_id', 'left');
        $this->db->join('sub_category', 'attributes_desc.sub_category1_id = sub_category.sub_category_id', 'left');
        $this->db->join('sub_category2', 'attributes_desc.sub_category2_id = sub_category2.sub_category2_id', 'left');
        $this->db->join('sub_category3', 'attributes_desc.sub_category3_id = sub_category3.sub_category3_id', 'left');
        $this->db->join('sub_category4', 'attributes_desc.sub_category4_id = sub_category4.sub_category4_id', 'left');
        $this->db->join('sub_category5', 'attributes_desc.sub_category5_id = sub_category5.sub_category5_id', 'left');
        $this->db->join('sub_category6', 'attributes_desc.sub_category6_id = sub_category6.sub_category6_id', 'left');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('attributes_desc.last_modified_time', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function attribute_details($attrID)
    {
        $this->db->select('attributes_desc.*,segment.segment_name,category.category_name,sub_category.sub_category_name,sub_category2.sub_category2_name,sub_category3.sub_category3_name,sub_category4.sub_category4_name,sub_category5.sub_category5_name,sub_category6.sub_category6_name,attributes_desc_value.*');
        $this->db->from('attributes_desc');
        $this->db->join('segment', 'attributes_desc.segment_id = segment.segment_id', 'left');
        $this->db->join('category', 'attributes_desc.category_id = category.category_id', 'left');
        $this->db->join('sub_category', 'attributes_desc.sub_category1_id = sub_category.sub_category_id', 'left');
        $this->db->join('sub_category2', 'attributes_desc.sub_category2_id = sub_category2.sub_category2_id', 'left');
        $this->db->join('sub_category3', 'attributes_desc.sub_category3_id = sub_category3.sub_category3_id', 'left');
        $this->db->join('sub_category4', 'attributes_desc.sub_category4_id = sub_category4.sub_category4_id', 'left');
        $this->db->join('sub_category5', 'attributes_desc.sub_category5_id = sub_category5.sub_category5_id', 'left');
        $this->db->join('sub_category6', 'attributes_desc.sub_category6_id = sub_category6.sub_category6_id', 'left');
        $this->db->join('attributes_desc_value', 'attributes_desc.attribute_id = attributes_desc_value.attribute_id', 'left');
        $this->db->where('attributes_desc.attribute_id', $attrID);
        $row = $this->db->get()->result();
        return $row;
    }

    public function update_attributes($attributeID, $updateArr)
    {
        $updateOpt = array(
            'table' => 'attributes_desc',
            'data' => array(
                'segment_id' => $updateArr['segment_id'],
                'category_id' => $updateArr['category_id'],
                'sub_category1_id' => $updateArr['sub_category1_id'],
                'sub_category2_id' => $updateArr['sub_category2_id'],
                'sub_category3_id' => $updateArr['sub_category3_id'],
                'sub_category4_id' => $updateArr['sub_category4_id'],
                'sub_category5_id' => $updateArr['sub_category5_id'],
                'sub_category6_id' => $updateArr['sub_category6_id'],
                //'attribute_desc'     => json_encode($updateArr['attribute_desc']),
                //'required_type'      => json_encode($updateArr['required_type']),
                'colors' => json_encode($updateArr['colors']),
                //'tooltip'			 => json_encode($updateArr['tooltip']),
                //'required_optional'  => json_encode($updateArr['required_optional']),										
                'last_modified_by' => $this->session->userdata('userId'),
                'last_modified_time' => $this->currentTimestamp,
            ),
            'where' => array('attribute_id' => $attributeID)
        );
        return $this->common_model->customUpdate($updateOpt);
    }


    public function attribute_row($data)
    {
        $this->db->select('attributes_desc.*,attributes_desc_value.*');
        $this->db->from('attributes_desc');
        $this->db->join('attributes_desc_value', 'attributes_desc.attribute_id = attributes_desc_value.attribute_id', 'left');
        $this->db->where(array(
            'attributes_desc.segment_id' => $data['segment_id'],
            'attributes_desc.category_id' => $data['category_id'],
            'attributes_desc.sub_category1_id' => $data['sub_category1_id'],
            'attributes_desc.sub_category2_id' => $data['sub_category2_id'],
            'attributes_desc.sub_category3_id' => $data['sub_category3_id'],
            'attributes_desc.sub_category4_id' => $data['sub_category4_id'],
            'attributes_desc.sub_category5_id' => $data['sub_category5_id'],
            'attributes_desc.sub_category6_id' => $data['sub_category6_id'],
        ));
        $result = $this->db->get();
        return $result->result();
    }


    public function update_product_attribute($attrID, $updateArr)
    {
        $updateOpt = array(
            'table' => 'product_attribute',
            'data' => array(
                'product_attribute_key' => $updateArr['attrKey'],
                'product_attribute_value' => json_encode($updateArr['post_form']),
                'brand_id' => $updateArr['brand_id'],
                'tax' => $updateArr['tax'],
                'last_modified_by' => $this->session->userdata('userId'),
                'last_modified_time' => $this->currentTimestamp
            ),
            'where' => array('product_attribute_id' => $attrID),
        );
        return $this->common_model->customUpdate($updateOpt);
    }

    public function product_attribute_row($product_id)
    {
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('product_attribute')->row();
        return $result;
    }

    public function product_with_attribute_details($product_id)
    {
        $this->db->select('product.*,product_attribute.*,segment.segment_name,category.category_name,sub_category.sub_category_name,sub_category2.sub_category2_name,sub_category3.sub_category3_name,sub_category4.sub_category4_name,sub_category5.sub_category5_name,sub_category6.sub_category6_name,brand.brand_name,(SELECT GROUP_CONCAT( CONCAT( product_image.product_image_name,"|",product_image.status ) ) FROM product_image WHERE product_image.product_id = ' . $product_id . ' ) AS product_images', false);
        $this->db->from('product');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('brand', 'product_attribute.brand_id = brand.brand_id', 'left');
        $this->db->join('segment', 'product.segment_id = segment.segment_id', 'left');
        $this->db->join('category', 'product.category_id = category.category_id', 'left');
        $this->db->join('sub_category', 'product.sub_category1_id = sub_category.sub_category_id', 'left');
        $this->db->join('sub_category2', 'product.sub_category2_id = sub_category2.sub_category2_id', 'left');
        $this->db->join('sub_category3', 'product.sub_category3_id = sub_category3.sub_category3_id', 'left');
        $this->db->join('sub_category4', 'product.sub_category4_id = sub_category4.sub_category4_id', 'left');
        $this->db->join('sub_category5', 'product.sub_category5_id = sub_category5.sub_category5_id', 'left');
        $this->db->join('sub_category6', 'product.sub_category6_id = sub_category6.sub_category6_id', 'left');
        $this->db->where(array('product.product_id' => $product_id,));
        $result = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $result->row();
    }

    public function product_accept_by_admin($product_id, $updateArr)
    {
        $updateOpt = array(
            'table' => 'product',
            'where' => array('product_id' => $product_id),
            'data' => array(
                'packing_weight' => $updateArr['packing_weight'],
                'total_weight' => $updateArr['total_weight'],
                'status' => 'Accepted',
                'last_modified_time' => $this->currentTimestamp,
            ),
        );
        return $this->common_model->customUpdate($updateOpt);
    }

    public function product_send_back_by_admin($product_id, $updateArr)
    {
        $this->db->where('product_id', $product_id);
        $this->db->update('product', $updateArr);
        return $this->db->affected_rows();
    }


    public function front_category_product($where)
    {
        $this->db->select('organization_product.*,product.code,product.weight,product.shippingWeight,product_image.imageName,category.categoryId,category.categoryCode');
        $this->db->from('organization_product');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_image', 'organization_product.productId = product_image.productId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->where(array('product_image.displayOrder' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('organization_product.currentPrice', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }


    public function front_product_listing($start = 0, $limit = '', $where = '')
    {
        $this->db->select('organization_product.*,min(organization_product.currentPrice) AS minPrice,(select product_image.imageName from product_image WHERE product_image.productId = organization_product.productId AND product_image.displayOrder = 1 ) AS proudctImageName,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,product.productId');
        $this->db->from('organization_product');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('brand', 'product.brandId = brand.brandId', 'left');
        $this->db->where('(organization.dropshipCentre = 1 OR organization.dropshipCentre = 2 OR organization.dropshipCentre = 3 OR organization.dropshipCentre = 4 OR organization.dropshipCentre = 5 OR organization.dropshipCentre = 6)');
        $this->db->where('employee.active', 1);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('organization_product.currentPrice', 'ASC');
        $this->db->group_by('organization_product.productId');
        $result = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $result->result();
    }

    public function total_front_product_listing($where = '')
    {
        $this->db->select('COUNT(DISTINCT organization_product.productId) AS total');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('brand', 'product.brandId = brand.brandId', 'left');
		$this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->where(array('employee.active' => 1, 'product_image.displayOrder' => 1, 'product.active' => 1));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if(!empty($where)) 
		{
            $this->db->where($where);
        }
        $this->db->order_by('organization_product.currentPrice', 'ASC');
        $result = $this->db->get()->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function front_product_listing_test($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product.code,organization_product.*,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,organization_product.productId,product_image.imageName AS mainImage,organization.organizationName,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
        $this->db->where(array(
							'employee.active' => 1, 
							'product_image.displayOrder' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2,
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('organization_product.currentPrice', 'ASC');
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function auto_search($search)
    {
		$result = $this->db->query('
			SELECT 
				product.productId,product.code,product_category.categoryId,category.categoryCode,product_image.imageName,brand.brandName,brand.brandId
			FROM
				organization_product
			INNER JOIN
				product
			ON
				organization_product.productId = product.productId
			INNER JOIN
				product_category
			ON
				organization_product.productId = product_category.productId
			INNER JOIN
				product_image
			ON
				product.productId = product_image.productId
			INNER JOIN
				category 
			ON
				product_category.categoryId = category.categoryId
			INNER JOIN
				organization
			ON
				organization_product.organizationId = organization.organizationId
			INNER JOIN
				employee
			ON
				organization.organizationId = employee.organizationId
			INNER JOIN
				dropship_center
			ON
				organization.dropshipCentre = dropship_center.dropCenterId
			INNER JOIN
				brand
			ON
				product.brandId = brand.brandId
			WHERE
				(
					employee.active = 1 
				AND 
					product_image.displayOrder = 1 
				AND 
					product.active = 1
				AND
					organization_product.currentQty >2
				AND
					category.active = 1
				AND
					brand.active = 1
				AND
					(
						product.verificationResultId = 2 
					OR 
						product.verificationResultId = 5
					) 
				AND 
					(
						trim(product.code) LIKE "%'.$search.'%" 
					OR 
						trim(category.categoryCode) LIKE "%'.$search.'%"
					OR 
						trim(brand.brandName) LIKE "%'.$search.'%"
					)
				)
				ORDER BY 
					(
						CASE WHEN trim(category.categoryCode) = "'.$search.'" THEN 1 
						     WHEN trim(category.categoryCode) LIKE "'.$search.'%" THEN 2
							 WHEN trim(product.code) = "'.$search.'" THEN 3 
						     WHEN trim(product.code) LIKE "'.$search.'%" THEN 4
							 WHEN trim(brand.brandName) = "'.$search.'" THEN 5 
						     WHEN trim(brand.brandName) LIKE "'.$search.'%" THEN 6 ELSE 7 END
					) ASC
			LIMIT 100
		'); 
        return $result->result();

		/*$this->db->select('product.productId,product.code,product_category.categoryId,category.categoryCode,product_image.imageName');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->where(array(
							'employee.active' => 1, 
							'product_image.displayOrder' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2,
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5) AND (trim(product.code) LIKE "%'.$search.'%" OR trim(category.categoryCode) LIKE "%'.$search.'%")');
		$this->db->order_by('product.code','ASC');
		$this->db->limit(100);
        $result = $this->db->get();
        return $result->result();*/
    }

    public function add_wish_list($productId)
    {
        $insertOpt = array(
            			'productId'  => $productId,
			            'customerId' => $this->session->userdata('userId'),
			            'createDt'   => date('Y-m-d H:i:s'),
				     );
	    $this->db->insert('wish_list', $insertOpt);
        return $this->db->insert_id();
    }

    public function total_wish_list_user($productId, $customerId)
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->where(array('productId' => $productId, 'customerId' => $customerId));
        $result = $this->db->get('wish_list')->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function wishlist_listing()
    {
        $this->db->select('organization_product.*,wish_list.*,product.code');
        $this->db->from('wish_list');
        $this->db->join('product', 'wish_list.productId = product.productId');
		$this->db->join('organization_product', 'wish_list.productId = organization_product.productId');
		$this->db->where('wish_list.customerId', $this->session->userdata('userId'));
		$this->db->group_by('organization_product.productId');
        $result = $this->db->get();
        return $result->result();
    }

    public function remove_from_wishlist($wishlistId)
    {
        $this->db->where(array('wishListId' => $wishlistId, 'customerId' => $this->session->userdata('userId')));
        $this->db->delete('wish_list');
        return $this->db->affected_rows();
    }

    public function attribute_with_title_details($attribute_value_id)
    {
        $this->db->where('attributes_desc_value_id', $attribute_value_id);
        $result = $this->db->get('attributes_desc_value');
        return $result->row();
    }

    public function update_attributes_with_title($attributeID, $updateArr)
    {
        $updateOpt = array(
            'table' => 'attributes_desc_value',
            'data' => array(
                'attribute_title' => $updateArr['attribute_title'],
                'attribute_desc' => json_encode($updateArr['attribute_desc']),
                'required_type' => json_encode($updateArr['required_type']),
                'tooltip' => json_encode($updateArr['tooltip']),
                'required_optional' => json_encode($updateArr['required_optional']),
                'last_modified_by' => $this->session->userdata('userId'),
                'last_modified_time' => $this->currentTimestamp,
            ),
            'where' => array('attributes_desc_value_id' => $attributeID)
        );
        return $this->common_model->customUpdate($updateOpt);
    }

    public function delete_attribute($attributeID)
    {
        $this->db->where('attributes_desc_value_id', $attributeID);
        $this->db->delete('attributes_desc_value');
        return $this->db->affected_rows();
    }

    public function update_color($attributeID, $color)
    {
        $this->db->where('attribute_id', $attributeID);
        $this->db->update('attributes_desc', array('colors' => $color));
        return $this->db->affected_rows();
    }

    public function get_color_list($attributeID)
    {
        $this->db->select('colors');
        $this->db->from('attributes_desc');
        $this->db->where('attribute_id', $attributeID);
        $result = $this->db->get();
        return $result->row();
    }

    public function product_with_inventory_with_retailer_details($product_detail_id)
    {
        $this->db->select('retailer_product_detail.*,profile.bussiness_name');
        $this->db->from('product');
        $this->db->join('product_image', 'product.product_id = product_image.product_id');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id');
        $this->db->join('profile', 'retailer_product_detail.last_modified_by = profile.user_id');
        $this->db->where(array('product_image.status' => 1, 'retailer_product_detail.product_detail_id' => $product_detail_id, 'product.block_status' => 1));
        $result = $this->db->get()->row();
        return $result;
    }

    public function product_with_other_retailer($product_id, $retailer_id)
    {
        $this->db->select('retailer_product_detail.*,users.email,profile.bussiness_name,profile.phone_no,profile.street,country.country_name,states.state_name,city.city_name,zone.zone_name,area.area_name');
        $this->db->from('product');
        $this->db->join('product_image', 'product.product_id = product_image.product_id');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id');
        $this->db->join('users', 'retailer_product_detail.last_modified_by = users.user_id');
        $this->db->join('profile', 'users.user_id = profile.user_id');
        $this->db->join('country', 'profile.country_id = country.country_id', 'left');
        $this->db->join('states', 'profile.state_id = states.state_id', 'left');
        $this->db->join('city', 'profile.city_id = city.city_id', 'left');
        $this->db->join('zone', 'profile.zone = zone.zone_id', 'left');
        $this->db->join('area', 'profile.area = area.area_id', 'left');
        $this->db->where(array(
            'product_image.status' => 1,
            'product.product_id' => $product_id,
            'product.block_status' => 1,
            'retailer_product_detail.last_modified_by !=' => $retailer_id
        ));
        $this->db->order_by('retailer_product_detail.final_price', 'asc');
        $result = $this->db->get()->row();
        return $result;
    }

    public function product_with_attribute_with_retailers_with_rating_details($product_id)
    {
        $this->db->select('product.product_id,product.product_name,product.spid,product.srid,product.segment_id,product.category_id,product.sub_category1_id,product.sub_category2_id,product.sub_category3_id,product.sub_category4_id,product.sub_category5_id,product.sub_category6_id,product.description,product.features,product_attribute.product_attribute_key,product_attribute.product_attribute_value,product_attribute.tax,segment.segment_name,category.category_name,sub_category.sub_category_name,sub_category2.sub_category2_name,sub_category3.sub_category3_name,sub_category4.sub_category4_name,sub_category5.sub_category5_name,sub_category6.sub_category6_name,brand.brand_name,(SELECT GROUP_CONCAT( CONCAT( product_image.product_image_name,"|",product_image.status ) ) FROM product_image WHERE product_image.product_id = ' . $product_id . ' ) AS product_images,retailer_product_detail.sale_price,retailer_product_detail.displayed_price,retailer_product_detail.inventory,retailer_product_detail.product_commission,retailer_product_detail.final_price,retailer_product_detail.used,retailer_product_detail.last_modified_by AS retailer_id,profile.bussiness_name,profile.business_owner_name,product_rating_count.product_rating_5,product_rating_count.product_rating_4,product_rating_count.product_rating_3,product_rating_count.product_rating_2,product_rating_count.product_rating_1,product_rating_count.total_rating,product_rating_count.avg_rating,product_rating.rating_point,product_rating.rating_review,product_rating.comment,product_rating.display_name,product_rating.rating_given_by,product_rating.product_rating_id,(SELECT COUNT(product_rating.product_id) FROM product_rating WHERE product_rating.product_id = ' . $product_id . ' ) AS total_review', false);
        $this->db->from('product');
        $this->db->join('product_attribute', 'product.product_id = product_attribute.product_id');
        $this->db->join('brand', 'product_attribute.brand_id = brand.brand_id', 'left');
        $this->db->join('segment', 'product.segment_id = segment.segment_id', 'left');
        $this->db->join('category', 'product.category_id = category.category_id', 'left');
        $this->db->join('sub_category', 'product.sub_category1_id = sub_category.sub_category_id', 'left');
        $this->db->join('sub_category2', 'product.sub_category2_id = sub_category2.sub_category2_id', 'left');
        $this->db->join('sub_category3', 'product.sub_category3_id = sub_category3.sub_category3_id', 'left');
        $this->db->join('sub_category4', 'product.sub_category4_id = sub_category4.sub_category4_id', 'left');
        $this->db->join('sub_category5', 'product.sub_category5_id = sub_category5.sub_category5_id', 'left');
        $this->db->join('sub_category6', 'product.sub_category6_id = sub_category6.sub_category6_id', 'left');
        $this->db->join('retailer_product_detail', 'product.product_id = retailer_product_detail.product_id', 'left');
        $this->db->join('profile', 'profile.user_id = retailer_product_detail.last_modified_by', 'left');
        $this->db->join('product_rating_count', 'product.product_id = product_rating_count.product_id', 'left');
        $this->db->join('product_rating', 'product_rating_count.product_rating_id = product_rating.product_rating_id', 'left');

        $this->db->where(array('product.product_id' => $product_id, 'retailer_product_detail.product_id' => $product_id));
        $this->db->order_by('retailer_product_detail.final_price', 'ASC');
        $result = $this->db->get();
        //echo $this->db->last_query(); exit;
        return $result->result();
    }

    public function product_data($product_id)
    {
        $this->db->select('product.*,brand.brandId,brand.brandName,t1.categoryId AS subCat6Id,t2.categoryId AS subCat5Id,t3.categoryId AS subCat4Id,t4.categoryId AS subCat3Id,t5.categoryId AS subCat2Id,t6.categoryId AS subCat1Id,t7.categoryId AS catId,t8.categoryId AS segId,product_tax.tax,product_mrp.mrp');
        $this->db->from('product');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('product_tax', 'product.productId = product_tax.productId');
        $this->db->join('product_mrp', 'product.productId = product_mrp.productId', 'left');
        $this->db->join('category AS t1', 'product_category.categoryId = t1.categoryId', 'left');
        $this->db->join('category AS t2', 't1.parentCategoryId = t2.categoryId', 'left');
        $this->db->join('category AS t3', 't2.parentCategoryId = t3.categoryId', 'left');
        $this->db->join('category AS t4', 't3.parentCategoryId = t4.categoryId', 'left');
        $this->db->join('category AS t5', 't4.parentCategoryId = t5.categoryId', 'left');
        $this->db->join('category AS t6', 't5.parentCategoryId = t6.categoryId', 'left');
        $this->db->join('category AS t7', 't6.parentCategoryId = t7.categoryId', 'left');
        $this->db->join('category AS t8', 't7.parentCategoryId = t8.categoryId', 'left');
        $this->db->where('product.productId', $product_id);
        $result = $this->db->get();
        return $result->row();
    }

    public function total_products($where = '')
    {
        $total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1,'category.active' => 1));
        if (!empty($where)) {
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function total_spacepointe_products($where = '')
    {
        $total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('verification_result');
        $this->db->join('product', 'verification_result.verificationResultId = product.verificationResultId');
        $this->db->join('organization_product', 'product.productId = organization_product.productId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->where(array('product_category.active' => 1,));
        /*
		
		$this->db->join('category','product_category.categoryId	 = category.categoryId');
		$this->db->join('brand','product.brandId = brand.brandId');
		
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->group_by('product.productId');*/
        return $result = $this->db->get()->result();
        if (!empty($result)) {
            $total = count($result);
        }
        return $total;
    }

    public function products_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product.*,brand.brandName,product_image.imageName,category.categoryCode,product_type.description AS productType,organization_product.organizationId,organization_product.organizationProductId');
        $this->db->from('verification_result');
        $this->db->join('product', 'verification_result.verificationResultId = product.verificationResultId');
        $this->db->join('product_tax', 'product.productId = product_tax.productId', 'left');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId	 = category.categoryId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('product_attribute', 'product.productId = product_attribute.productId');
        $this->db->join('product_type', 'product.productTypeId = product_type.productTypeId');
        $this->db->join('organization_product', 'product.productId = organization_product.productId', 'left');
        //$this->db->where(array('product_image.displayOrder' => 1,'product.active' => 1,'product_category.active' => 1,'brand.active' => 1,));
        $this->db->where(array('product_image.displayOrder' => 1, 'product.verificationResultId' => 2, 'product_category.active' => 1));
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('product.productId');
        $this->db->order_by('product.code', 'asc');
        $result = $this->db->get();
        return $result->result();
    }

    public function products_list_test($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product.*,brand.brandName,category.categoryCode,(SELECT GROUP_CONCAT( CONCAT( organization_product.organizationId,"|",organization_product.organizationProductId) ) FROM organization_product WHERE organization_product.productId = product.productId) AS orgPrdIDS,product_image.imageName', false);
        $this->db->from('product');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId	 = category.categoryId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		$this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1,'category.active' => 1));
        if(!empty($where))          
		{
            $this->db->where($where);
        }
        $this->db->order_by('product.code', 'asc');
		if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function last_add_product()
    {
        $this->db->order_by('productId', 'desc');
        $result = $this->db->get('product')->row();
        return $result;
    }

    public function product_with_type_name($product_id)
    {
        $this->db->select('product.*,product_type.description as product_type');
        $this->db->from('product');
        $this->db->join('product_type', 'product.productTypeId = product_type.productTypeId');
        $this->db->where('productId', $product_id);
        return $this->db->get()->row();
    }

    public function product_type_with_taxonomy($productType)
    {
        $this->db->select('product_taxonomy.*,product_attribute_type.description AS attributeType,product_attribute_name.productAttributeName');
        $this->db->from('product_taxonomy');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        $this->db->where(array('product_taxonomy.productTypeId' => $productType, 'product_taxonomy.active' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function add_product($addData)
    {
        $insertOpt = array(
						'code' 				   => $addData['product_name'],
						'description' 		   => $addData['description'],
						'weight' 			   => $addData['item_weight'],
						'shippingWeight' 	   => $addData['packaging_weight'],
						'brandId' 			   => $addData['brand_id'],
						'verificationResultId' => $addData['verificationResultId'],
						'productTypeId'	 	   => $addData['product_type'],
						'createBy' 			   => $this->session->userdata('userId'),
						'createDt' 			   => date('Y-m-d H:i:s'),
						'lastModifiedBy' 	   => $this->session->userdata('userId'),
						'lastModifiedDt' 	   => date('Y-m-d H:i:s'),
					);
					
        if(isset($addData['sizes']) && !empty($addData['sizes'])) 
		{
        	$insertOpt['sizes'] = $addData['sizes'];
        }
        $this->db->insert('product', $insertOpt);
        return $this->db->insert_id();
    }

    public function update_product($product_id, $updateData)
    {
        $updateOpt = array(
            'code' => $updateData['product_name'],
            'weight' => $updateData['item_weight'],
            'shippingWeight' => $updateData['packaging_weight'],
			'productTypeId'	 => $updateData['product_type'],
            'brandId' => $updateData['brand_id'],
            'lastModifiedBy' => $this->session->userdata('userId'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
        );
        if (isset($updateData['sizes']) && !empty($updateData['sizes'])) {
            $updateOpt['sizes'] = $updateData['sizes'];
        } else {
            $updateOpt['sizes'] = '';
        }
        $this->db->where('productId', $product_id);
        $this->db->update('product', $updateOpt);
        return $this->db->affected_rows();
    }

    public function add_product_category($productId, $addData)
    {
        $insertOpt = array(
						'productId' 	 => $productId,
						'categoryId' 	 => $addData['lastCatId'],
						'organizationId' => $this->session->userdata('organizationId'),
						'createDt' 		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
        $this->db->insert('product_category', $insertOpt);
        return $this->db->insert_id();
    }

    public function get_product_category_details($addData)
    {
        $this->db->where(array(
            'productId' => $addData['productId'],
            'categoryId' => $addData['lastCatId'],
            'organizationId' => $this->session->userdata('organizationId'),));
        $result = $this->db->get('product_category');
        return $result->row();
    }

    public function add_product_mrp($productId, $addData)
    {
        $insertOpt = array(
            'productId' => $productId,
            'countryId' => $addData['countryId'],
            'mrp' => $addData['mrp'],
            'createDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('product_mrp', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_product_tax($productId, $addData)
    {
        $insertOpt = array(
            'productId' => $productId,
            'tax' => $addData['tax'],
            'organizationId' => $this->session->userdata('organizationId'),
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('product_tax', $insertOpt);
        return $this->db->insert_id();
    }

    public function update_product_tax($productId, $updateData)
    {
        $updateOpt = array(
            'tax' => $updateData['tax'],
            'lastModifiedBy' => $this->session->userdata('userId'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
        );
        $this->db->where('productId', $productId);
        $this->db->update('product_tax', $updateOpt);
        return $this->db->affected_rows();
    }


    public function update_product_category($productId, $updateData)
    {
        $updateOpt = array(
            'categoryId' => $updateData['lastCatId'],
            'lastModifiedBy' => $this->session->userdata('userId'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
        );
        $this->db->where('productId', $productId);
        $this->db->update('product_category', $updateOpt);
        return $this->db->affected_rows();
    }

    public function update_product_mrp($productId, $updateData)
    {
        $updateOpt = array('mrp' => $updateData['mrp'],);
        $this->db->where('productId', $productId);
        $this->db->update('product_mrp', $updateOpt);
        return $this->db->affected_rows();
    }

    public function product_image_list($productId)
    {
        $this->db->where(array('productId' => $productId, 'active' => 1));
        $result = $this->db->get('product_image');
        return $result->result();
    }

    public function single_product_image($productImageId)
    {
        $this->db->where('productImageId', $productImageId);
        $result = $this->db->get('product_image');
        return $result->row();
    }

    public function product_image_not_main($productId)
    {
        $this->db->where('productId', $productId);
        $this->db->update('product_image', array('displayOrder' => 0));
        return $this->db->affected_rows();
    }

    public function product_main_image($productImageId)
    {
        $this->db->where('productImageId', $productImageId);
        $this->db->update('product_image', array('displayOrder' => 1));
        return $this->db->affected_rows();
    }

    public function delete_image($productImageId)
    {
        $this->db->where('productImageId', $productImageId);
        $this->db->update('product_image', array('active' => 0));
        return $this->db->affected_rows();
    }

    public function add_product_image($imageName, $productId)
    {
        $insertOpt = array(
            'productId' => $productId,
            'imageName' => $imageName,
            'imagePath' => base_url() . 'uploads/product/',
            'createDt' => date('Y-m-d H:i:s'),
            'lastModifiedBy' => $this->session->userdata('userId'),
            'lastModifiedDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('product_image', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_product_attribute($addArr)
    {
        return $this->db->insert_batch('product_attribute', $addArr);
    }

    public function product_brand_image_category_details($product_id)
    {
        $this->db->select('product.*,brand.brandName,product_image.imageName,product_image.displayOrder,t1.categoryCode AS subCat6Name,t2.categoryCode AS subCat5Name,t3.categoryCode AS subCat4Name,t4.categoryCode AS subCat3Name,t5.categoryCode AS subCat2Name,t6.categoryCode AS subCat1Name,t7.categoryCode AS catName,t8.categoryCode AS segName');
        $this->db->from('product');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId', 'left');
        $this->db->join('category AS t1', 'product_category.categoryId = t1.categoryId', 'left');
        $this->db->join('category AS t2', 't1.parentCategoryId = t2.categoryId', 'left');
        $this->db->join('category AS t3', 't2.parentCategoryId = t3.categoryId', 'left');
        $this->db->join('category AS t4', 't3.parentCategoryId = t4.categoryId', 'left');
        $this->db->join('category AS t5', 't4.parentCategoryId = t5.categoryId', 'left');
        $this->db->join('category AS t6', 't5.parentCategoryId = t6.categoryId', 'left');
        $this->db->join('category AS t7', 't6.parentCategoryId = t7.categoryId', 'left');
        $this->db->join('category AS t8', 't7.parentCategoryId = t8.categoryId', 'left');
        $this->db->where('product.productId', $product_id);
        $result = $this->db->get();
        return $result->result();
    }

    public function product_brand_image_category_tax_details($product_id)
    {
        $this->db->select('product.*,brand.brandName,brand.active AS brandStatus,product_image.imageName,product_image.displayOrder,t1.categoryCode AS subCat6Name,t2.categoryCode AS subCat5Name,t3.categoryCode AS subCat4Name,t4.categoryCode AS subCat3Name,t5.categoryCode AS subCat2Name,t6.categoryCode AS subCat1Name,t7.categoryCode AS catName,t8.categoryCode AS segName,product_tax.tax,product_mrp.mrp');
        $this->db->from('product');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('product_tax', 'product.productId = product_tax.productId', 'left');
        $this->db->join('product_mrp', 'product.productId = product_mrp.productId', 'left');
        $this->db->join('product_image', 'product.productId = product_image.productId', 'left');
        $this->db->join('category AS t1', 'product_category.categoryId = t1.categoryId', 'left');
        $this->db->join('category AS t2', 't1.parentCategoryId = t2.categoryId', 'left');
        $this->db->join('category AS t3', 't2.parentCategoryId = t3.categoryId', 'left');
        $this->db->join('category AS t4', 't3.parentCategoryId = t4.categoryId', 'left');
        $this->db->join('category AS t5', 't4.parentCategoryId = t5.categoryId', 'left');
        $this->db->join('category AS t6', 't5.parentCategoryId = t6.categoryId', 'left');
        $this->db->join('category AS t7', 't6.parentCategoryId = t7.categoryId', 'left');
        $this->db->join('category AS t8', 't7.parentCategoryId = t8.categoryId', 'left');
        $this->db->where(array('product.productId' => $product_id, 'product_image.displayOrder' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function product_attributes_details($productId)
    {
        $this->db->select('product_attribute.*,product_taxonomy.attributeNameId,product_taxonomy.attributeTypeId,product_taxonomy.productTypeId,product_taxonomy.isRequired,product_taxonomy.keyFeature,product_attribute_type.description AS attributeType,product_attribute_name.productAttributeName,product_type.description AS product_type');
        $this->db->from('product_attribute');
        $this->db->join('product_taxonomy', 'product_attribute.productTaxonomyId = product_taxonomy.productTaxonomyId');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->where(array('product_attribute.productId' => $productId, 'product_attribute.active' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function delete_product_attributes($productId)
    {
        $this->db->where('productId', $productId);
        $this->db->update('product_attribute', array('active' => 0));
        return $this->db->affected_rows();
    }

    public function total_product_type($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $result = $this->db->get('product_type')->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function product_type_list($start = 0, $limit = '', $where = '')
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('createDt', 'desc');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get('product_type');
        return $result->result();
    }

    public function add_product_type($product_type)
    {
        $insertOpt = array(
            'description' => $product_type,
            'createDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('product_type', $insertOpt);
        return $this->db->insert_id();
    }

    public function product_type_name($productTypeId)
    {
        $this->db->where('productTypeId', $productTypeId);
        $result = $this->db->get('product_type');
        return $result->row();
    }

    public function update_product_type($productTypeId, $product_type)
    {
        $this->db->where('productTypeId', $productTypeId);
        $this->db->update('product_type', array('description' => $product_type));
        return $this->db->affected_rows();
    }

    public function delete_product_type($productTypeId)
    {
        $this->db->where('productTypeId', $productTypeId);
        $this->db->delete('product_type');
        return $this->db->affected_rows();
    }

    public function total_attribute_type($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_attribute_type');
        $this->db->join('product_type', 'product_attribute_type.productTypeId = product_type.productTypeId');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function attribute_type_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product_attribute_type.*,product_type.description AS product_type');
        $this->db->from('product_attribute_type');
        $this->db->join('product_type', 'product_attribute_type.productTypeId = product_type.productTypeId');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('product_attribute_type.createDt', 'desc');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function add_attribute_type($addArr)
    {
        $insertOpt = array(
            'productTypeId' => $addArr['productTypeId'],
            'description' => $addArr['attribute_type'],
            'createDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('product_attribute_type', $insertOpt);
        return $this->db->insert_id();
    }

    public function update_attribute_type($attributeTypeId, $updateArr)
    {
        $updateOpt = array(
            'productTypeId' => $updateArr['productTypeId'],
            'description' => $updateArr['attribute_type'],
        );
        $this->db->where('productAttributeTypeId', $attributeTypeId);
        $this->db->update('product_attribute_type', $updateOpt);
        return $this->db->affected_rows();
    }

    public function attribute_type_check($productTypeId, $attribute_type)
    {
        $this->db->where(array(
            'productTypeId' => $productTypeId,
            'description' => $attribute_type,
        ));
        $result = $this->db->get('product_attribute_type');
        return $result->row();
    }

    public function attribute_name_check($attribute_type, $attribute_name)
    {
        $this->db->where(array(
            'productAttributeTypeId' => $attribute_type,
            'productAttributeName' => $attribute_name,
        ));
        $result = $this->db->get('product_attribute_name');
        return $result->row();
    }

    public function attribute_type($productAttributeTypeId)
    {
        $this->db->where('productAttributeTypeId', $productAttributeTypeId);
        $result = $this->db->get('product_attribute_type');
        return $result->row();
    }

    public function delete_attribute_type($productAttributeTypeId)
    {
        $this->db->where('productAttributeTypeId', $productAttributeTypeId);
        $this->db->delete('product_attribute_type');
        return $this->db->affected_rows();
    }

    public function total_attribute_name($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_attribute_name');
        $this->db->join('product_attribute_type', 'product_attribute_name.productAttributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_type', 'product_attribute_type.productTypeId = product_type.productTypeId');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
        $total = 0;
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function attribute_name_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product_attribute_name.*,product_attribute_type.description AS attribute_type,product_type.description AS product_type');
        $this->db->from('product_attribute_name');
        $this->db->join('product_attribute_type', 'product_attribute_name.productAttributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_type', 'product_attribute_type.productTypeId = product_type.productTypeId');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('product_attribute_name.createDt', 'desc');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function add_attribute_name($addArr)
    {
        $insertOpt = array(
            'productAttributeTypeId' => $addArr['productAttributeTypeId'],
            'productAttributeName' => $addArr['productAttributeName'],
            'createDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('product_attribute_name', $insertOpt);
        return $this->db->insert_id();
    }

    public function update_attribute_name($attributeNameId, $updateArr)
    {
        $updateOpt = array(
            'productAttributeTypeId' => $updateArr['attribute_type'],
            'productAttributeName' => $updateArr['attribute_name'],
        );
        $this->db->where('productAttributeNameId', $attributeNameId);
        $this->db->update('product_attribute_name', $updateOpt);
        return $this->db->affected_rows();
    }

    public function attribute_name($attributeNameId)
    {
        $this->db->select('product_attribute_name.*,product_attribute_type.productTypeId');
        $this->db->from('product_attribute_name');
        $this->db->join('product_attribute_type', 'product_attribute_name.productAttributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->where('product_attribute_name.productAttributeNameId', $attributeNameId);
        $result = $this->db->get();
        return $result->row();
    }

    public function delete_attribute_name($productAttributeNameId)
    {
        $this->db->where('productAttributeNameId', $productAttributeNameId);
        $this->db->delete('product_attribute_name');
        return $this->db->affected_rows();
    }

    public function total_product_taxonomy($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_taxonomy');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->group_by('product_taxonomy.productTypeId');
        $result = $this->db->get()->result();
        $total = 0;
        if (!empty($result)) {
            $total = count($result);
        }
        return $total;
    }

    public function product_taxonomy_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product_taxonomy.*,product_type.description AS product_type,product_attribute_type.description AS attribute_type,product_attribute_name.productAttributeName AS attribute_name');
        $this->db->from('product_taxonomy');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('product_taxonomy.lastModifiedDt', 'desc');
        $this->db->group_by('product_taxonomy.productTypeId');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }

    public function add_product_taxonomy($addArr)
    {
        return $this->db->insert_batch('product_taxonomy', $addArr);
    }

    public function update_product_taxonomy($updateArr)
    {
        $this->db->update_batch('product_taxonomy', $updateArr, 'productTaxonomyId');
        return $this->db->affected_rows();
    }

    public function product_taxonomy_details($productTaxonomyId)
    {
        $this->db->select('product_taxonomy.*,product_type.description AS product_type,product_attribute_type.description AS attribute_type,product_attribute_name.productAttributeName AS attribute_name');
        $this->db->from('product_taxonomy');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        $this->db->where(array('product_taxonomy.productTaxonomyId' => $productTaxonomyId));
        $result = $this->db->get();
        return $result->row();
    }

    public function delete_product_taxonomy($productTaxonomyId)
    {
        $this->db->where('productTaxonomyId', $productTaxonomyId);
        $this->db->delete('product_taxonomy');
        return $this->db->affected_rows();
    }

    public function product_taxonomy_listType($productTypeId)
    {
        $this->db->select('product_taxonomy.*,product_type.description AS product_type,product_attribute_type.description AS attribute_type,product_attribute_name.productAttributeName AS attribute_name');
        $this->db->from('product_taxonomy');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        $this->db->where(array('product_taxonomy.productTypeId' => $productTypeId, 'product_taxonomy.active' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function dactivateAttributeType($productTypeId)
    {
        $updateOpt = array('active' => 0);
        $this->db->where('productTypeId', $productTypeId);
        $this->db->update('product_attribute_type', $updateOpt);
        return $this->db->affected_rows();
    }

    public function dactivateAttributeName($updateArr)
    {
        $this->db->update_batch('product_attribute_name', $updateArr, 'productAttributeTypeId');
        return $this->db->affected_rows();
    }

    public function dactivateProductTaxonomy($productTypeId)
    {
        $updateOpt = array('active' => 0);
        $this->db->where('productTypeId', $productTypeId);
        $this->db->update('product_taxonomy', $updateOpt);
        return $this->db->affected_rows();
    }

    public function addVerificationResult($addArr)
    {
        $insertOpt = array(
            'description' => $addArr['description'],
            'createDt' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('verification_result', $insertOpt);
        return $this->db->insert_id();
    }

    public function block_unblock($status, $productId)
    {
        $updateOpt = array('active' => $status);
        $this->db->where('productId', $productId);
        $this->db->update('product', $updateOpt);
        return $this->db->affected_rows();
    }

    public function total_products_in_category()
    {
        $this->db->select('COUNT(*) AS totalProduct,category.categoryId,category.categoryCode');
        $this->db->from('verification_result');
        $this->db->join('product', 'verification_result.verificationResultId = product.verificationResultId');
        $this->db->join('product_tax', 'product.productId = product_tax.productId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId	 = category.categoryId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->where(array('product_image.displayOrder' => 1));
        $this->db->group_by('category.categoryId');
        $result = $this->db->get()->result();
        return $result;
    }

    public function total_check_stocks($where = '')
    {
		$this->db->select('*');
        $this->db->from('organization_product');
        $this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('brand', 'product.brandId = brand.brandId');
        if(!empty($where)) 
		{
            $this->db->where($where);
        }
		$this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1)); //'product.active' => 1));
        $this->db->group_by(array('organization_product.organizationId','organization_product.productId'));
        $result = $this->db->get()->result();
        $total = 0;
        if(!empty($result)) 
		{
            $total = count($result);
        }
        return $total;
    }

    public function check_stocks_list($start = 0, $limit = '', $where = '')
    {   
		$this->db->select('product.productId,product.code,organization_product.organizationProductId,organization_product.organizationId,organization_product.currentPrice,organization_product.currentQty,product_image.imageName,product.weight,product.shippingWeight');
        $this->db->from('organization_product');
        $this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('brand','product.brandId = brand.brandId');
        if(!empty($where)) 
		{
            $this->db->where($where);
        }
		$this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1)); //'product.active' => 1));
        $this->db->group_by(array('organization_product.organizationId','organization_product.productId'));
        if($limit) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get()->result();
        return $result;
    }

    public function size_check_stocks_list($start = 0, $limit = '', $where = '')
    {
        $this->db->select('organization_product.*,group_concat(organization_size_stock.colorId ORDER BY   organization_size_stock.colorId ASC) as colorId, group_concat(organization_size_stock.size ORDER BY   organization_size_stock.colorId ASC) as product_size,group_concat(organization_size_stock.currentstock ORDER BY   organization_size_stock.colorId ASC ) as stock,product.code,product_image.imageName,product.weight,product.shippingWeight');
        $this->db->from('organization_product');
        $this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('organization_size_stock', 'organization_size_stock.organizationProductId=organization_product.organizationProductId', 'left');
		$this->db->join('brand', 'product.brandId = brand.brandId');
        if(!empty($where)) 
		{
            $this->db->where($where);
        }
		$this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1)); //'product.active' => 1));
        $this->db->group_by('organization_product.organizationProductId');
        $this->db->order_by('organization_size_stock.colorId', 'ASC');
        if($limit) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get()->result();
        return $result;
    }
	
	public function product_category_commission($productId)
	{
		$this->db->select('product.*,t1.categoryCode AS subCat6Name,t2.categoryCode AS subCat5Name,t3.categoryCode AS subCat4Name,t4.categoryCode AS subCat3Name,t5.categoryCode AS subCat2Name,t6.categoryCode AS subCat1Name,t7.categoryCode AS catName,t8.categoryCode AS segName,t1.categoryId AS subCat6Id,t2.categoryId AS subCat5Id,t3.categoryId AS subCat4Id,t4.categoryId AS subCat3Id,t5.categoryId AS subCat2Id,t6.categoryId AS subCat1Id,t7.categoryId AS catId,t8.categoryId AS segId,t1.commission AS commission8,t2.commission AS commission7,t3.commission AS commission6,t4.commission AS commission5,t5.commission AS commission4,t6.commission AS commission3,t7.commission AS commission2,t8.commission AS commission1');
        $this->db->from('product');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category AS t1', 'product_category.categoryId = t1.categoryId', 'left');
        $this->db->join('category AS t2', 't1.parentCategoryId = t2.categoryId', 'left');
        $this->db->join('category AS t3', 't2.parentCategoryId = t3.categoryId', 'left');
        $this->db->join('category AS t4', 't3.parentCategoryId = t4.categoryId', 'left');
        $this->db->join('category AS t5', 't4.parentCategoryId = t5.categoryId', 'left');
        $this->db->join('category AS t6', 't5.parentCategoryId = t6.categoryId', 'left');
        $this->db->join('category AS t7', 't6.parentCategoryId = t7.categoryId', 'left');
        $this->db->join('category AS t8', 't7.parentCategoryId = t8.categoryId', 'left');
        $this->db->where(array('product.productId' => $productId));
		$this->db->where('(t1.parentCategoryId IS NOT NULL OR t2.parentCategoryId IS NOT NULL OR t3.parentCategoryId IS NOT NULL OR t4.parentCategoryId IS NOT NULL OR t5.parentCategoryId IS NOT NULL OR t6.parentCategoryId IS NOT NULL OR t7.parentCategoryId IS NOT NULL OR t8.parentCategoryId IS NOT NULL)');
        $result = $this->db->get();
        return $result->row();
	}

    public function product_brand_image_category_tax_details_row($product_id)
    {
        $this->db->select('product.*,brand.brandName,brand.active AS brandStatus,product_image.imageName,product_image.displayOrder,t1.categoryCode AS subCat6Name,t2.categoryCode AS subCat5Name,t3.categoryCode AS subCat4Name,t4.categoryCode AS subCat3Name,t5.categoryCode AS subCat2Name,t6.categoryCode AS subCat1Name,t7.categoryCode AS catName,t8.categoryCode AS segName,t1.categoryId AS subCat6Id,t2.categoryId AS subCat5Id,t3.categoryId AS subCat4Id,t4.categoryId AS subCat3Id,t5.categoryId AS subCat2Id,t6.categoryId AS subCat1Id,t7.categoryId AS catId,t8.categoryId AS segId,product_tax.tax,product_mrp.mrp,product_category.categoryId');
        $this->db->from('product');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('product_tax', 'product.productId = product_tax.productId', 'left');
        $this->db->join('product_mrp', 'product.productId = product_mrp.productId', 'left');
        $this->db->join('product_image', 'product.productId = product_image.productId', 'left');
        $this->db->join('category AS t1', 'product_category.categoryId = t1.categoryId', 'left');
        $this->db->join('category AS t2', 't1.parentCategoryId = t2.categoryId', 'left');
        $this->db->join('category AS t3', 't2.parentCategoryId = t3.categoryId', 'left');
        $this->db->join('category AS t4', 't3.parentCategoryId = t4.categoryId', 'left');
        $this->db->join('category AS t5', 't4.parentCategoryId = t5.categoryId', 'left');
        $this->db->join('category AS t6', 't5.parentCategoryId = t6.categoryId', 'left');
        $this->db->join('category AS t7', 't6.parentCategoryId = t7.categoryId', 'left');
        $this->db->join('category AS t8', 't7.parentCategoryId = t8.categoryId', 'left');
        $this->db->where(array('product.productId' => $product_id, 'product_image.displayOrder' => 1));
        $result = $this->db->get();
        return $result->row();
    }
	
	public function product_brand_image_category_details_row($productId)
    {
        $this->db->select('product.*,brand.brandName,brand.active AS brandStatus,product_image.imageName,product_image.displayOrder,product_category.categoryId');
        $this->db->from('product');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->where(array('product.productId' => $productId, 'product_image.displayOrder' => 1));
        $result = $this->db->get();
        return $result->row();
    }

    public function add_organization_product($organizationId, $productId, $addArr)
    {
        $insertOpt = array(
						'organizationId' => $organizationId,
						'productId'      => $productId,
						'currentQty'     => $addArr['stock'],
						'currentPrice'   => $addArr['retailerPrice'],
						'createDt'       => date('Y-m-d H:i:s'),
						'createBy'       => $this->session->userdata('userId'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
        
		if(isset($addArr['availablesize'])) 
		{
            $insertOpt['availableSize'] = $addArr['availablesize'];
        }
        $this->db->insert('organization_product', $insertOpt);
        return $this->db->insert_id();
    }

    public function add_organization_product_from_master($organizationId, $addArr)
    {
        //	associationType is 2 ie pointpay and this product add by retailer and show on pointepay not show in pointemart
        $insertOpt = array(
            'organizationId' => $organizationId,
            'productId' => $addArr['productId'],
            'productCodeOveride' => $addArr['productName'],
            'productDescription' => $addArr['productDescription'],
            'imageName' => $addArr['imageName'],
            'currentPrice' => $addArr['sellPrice'],
            'costPrice' => $addArr['costPrice'],
            'upc' => $addArr['upc'],
            'associationType' => 2,
        );
        if (isset($addArr['availablesize'])) {
            $insertOpt['availableSize'] = $addArr['availablesize'];
        }
        $this->db->insert('organization_product', $insertOpt);
        return $this->db->insert_id();
    }

    public function inventory_details($organizationProductId)
    {
        $this->db->select('organization_product.*,product.code,product.weight,product.shippingWeight,product_image.imageName,group_concat(organization_size_stock.colorId ORDER BY   organization_size_stock.colorId ASC ) as colorId,group_concat(organization_size_stock.size ORDER BY   organization_size_stock.colorId ASC) as product_size,group_concat(organization_size_stock.currentstock ORDER BY   organization_size_stock.colorId ASC ) as stock,product_category.categoryId');
        $this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_image','organization_product.productId = product_image.productId');
		$this->db->join('product_category','product.productId = product_category.productId','left');
        $this->db->join('organization_size_stock', 'organization_size_stock.organizationProductId=organization_product.organizationProductId', 'left');
        $this->db->where(array('organization_product.organizationProductId' => $organizationProductId, 'product_image.displayOrder' => 1));
        $result = $this->db->get();
        return $result->row();
    }

    public function edit_inventory($organizationProductId, $inventory)
    {
        $this->db->where('organizationProductId', $organizationProductId);
        $this->db->update('organization_product', array('currentQty' => $inventory, 'lastModifiedBy' => $this->session->userdata('userId'), 'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function edit_inventory_first_time($organizationProductId, $inventory)
    {
        $this->db->where('organizationProductId', $organizationProductId);
        $this->db->update('organization_product', array('currentQty' => $inventory, 'createDt' => date('Y-m-d H:i:s'), 'createBy' => $this->session->userdata('userId'), 'lastModifiedBy' => $this->session->userdata('userId'), 'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function organization_with_product($organizationId, $productId)
    {
        $this->db->where(array('organizationId' => $organizationId, 'productId' => $productId));
        $result = $this->db->get('organization_product')->row();
        return $result;
    }
	
	public function organization_with_product_details($organizationId, $productId)
    {
		$this->db->select('product.code,organization_product.*,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,organization_product.productId,product_image.imageName AS mainImage,organization.organizationName');
        $this->db->from('organization_product');
        $this->db->join('product','organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId', 'left');
        $this->db->where(array('employee.active' => 1, 'product_image.displayOrder' => 1, 'product.active' => 1,'organization_product.organizationId' => $organizationId, 'organization_product.productId' => $productId));
        $result = $this->db->get()->row();
        return $result;
    }

    public function organization_product_details($organizationProductId)
    {
        $this->db->select('organization_product.*,product.code,product_category.categoryId,category.categoryCode,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,marketing_product.marketingProductId,dropship_center.dropCenterId,dropship_center.dropCenterName,product_image.productImageId,product_image.imageName,marketing_product.retailerDiscount');
        $this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('product_category','product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');	
		$this->db->join('product_image', 'product.productId = product_image.productId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');		
        $this->db->where(array(
						'organization_product.organizationProductId' => $organizationProductId,
						'product_image.displayOrder' => 1,
						'employee.active' => 1, 
						'product.active' => 1,
						'organization_product.currentQty >' => 2
					));
        $result = $this->db->get()->row();
        return $result;
    }

    public function product_acording_level($categoryId)
    {
        $this->db->select('organization_product.*,brand.brandId,brand.brandName');
        $this->db->from('organization_product');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('product', 'organization_product.productId = product.productId');
		$this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('product_category.categoryId' => $categoryId, 'employee.active' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
        $this->db->order_by('organization_product.currentPrice','ASC');
        $result = $this->db->get();
        return $result->result();
    }
	
	public function product_acording_level_in($catArr=array(0,0))
    {
        $this->db->select('organization_product.organizationProductId,organization_product.currentQty,organization_product.currentPrice,product.productId,product.code,product_category.categoryId,category.categoryCode,category.parentCategoryId');
        $this->db->from('organization_product');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('product', 'organization_product.productId = product.productId');
		$this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array(
							'employee.active' 					=> 1, 
							'product.active' 					=> 1,
							'organization_product.currentQty >' => 2,
							'category.active' 					=> 1,
							'category.isMarketing' 			   	=> 0,
							'brand.active' 						=> 1,
						));
		$this->db->where_in('product_category.categoryId',explode(',',$catArr));
		$this->db->order_by('category.categoryId','ASC');		
        $result = $this->db->get();
        return $result->result();
    }

    public function single_product_with_retailer_detail($product_id)
    {
        $this->db->select('organization_product.*,product.*,brand.brandName,organization.organizationName,wish_list.wishListId,marketing_product.currentPrice AS adminPrice,marketing_product.marketingProductId');
        $this->db->from('organization_product');
        $this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('product','product.productId=organization_product.productId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('brand','brand.brandId=product.brandId');
        $this->db->join('wish_list','product.productId=wish_list.productId', 'left');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('organization_product.productId' => $product_id, 'employee.active' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
        $this->db->order_by('organization_product.currentPrice','asc'); 
        $result = $this->db->get()->row();
        return $result;
    }

    public function single_organization_product_details($organizationProductId)
    {
        $this->db->select('organization_product.*,product.*,brand.brandName,organization.organizationName');
        $this->db->from('organization_product');
        $this->db->join('product', 'product.productId=organization_product.productId');
        $this->db->join('brand', 'brand.brandId=product.brandId');
        $this->db->join('organization', 'organization_product.organizationId=organization.organizationId');
        $this->db->where('organization_product.organizationProductId', $organizationProductId);
        $this->db->where('(organization.dropshipCentre = 1 OR organization.dropshipCentre = 2 OR organization.dropshipCentre = 3 OR organization.dropshipCentre = 4 OR organization.dropshipCentre = 5 OR organization.dropshipCentre = 6)');
        $result = $this->db->get()->row();
        return $result;
    }

    public function product_seller_list($producId)
    {
		$this->db->select('organization_product.*,product.*,brand.brandName,organization.organizationName,marketing_product.currentPrice AS adminPrice,employee.firstName,employee.middle,employee.lastName,organization.dropshipCentre,product.weight,product.shippingWeight');
        $this->db->from('organization_product');
        $this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('product','product.productId=organization_product.productId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('brand','brand.brandId=product.brandId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('organization_product.productId' => $producId, 'employee.active' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
        $this->db->order_by('organization_product.currentPrice', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }

    public function product_seller_list_with_color_and_size($producId,$where='')
    {
        $this->db->select('product.*,brand.brandName,organization.organizationName,marketing_product.currentPrice AS adminPrice,employee.firstName,employee.middle,employee.lastName,organization.dropshipCentre,product.weight,product.shippingWeight,organization_size_stock.size as organization_size,colors.*,organization_product.*,marketing_product.costPrice');
        $this->db->from('organization_product');
        $this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('product','product.productId=organization_product.productId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('brand','brand.brandId=product.brandId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_size_stock','organization_product.organizationProductId = organization_size_stock.organizationProductId','left');
		$this->db->join('colors','organization_size_stock.colorId = colors.colorId','left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('organization_product.productId' => $producId, 'employee.active' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
		if(!empty($where))
		{
			$this->db->where($where);
		}
        $this->db->order_by('organization_product.currentPrice', 'DESC');
        $result = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $result->result();
    }
	
	public function product_seller_list_with_color_size($producId,$colorId,$sizeId)
    {
		$this->db->select('product.*,brand.brandName,organization.organizationName,marketing_product.currentPrice AS adminPrice,employee.firstName,employee.middle,employee.lastName,organization.dropshipCentre,product.weight,product.shippingWeight,organization_size_stock.organizationProductSizeId,organization_size_stock.size,organization_size_stock.colorId,organization_product.*,organization.dropshipCentre');
        $this->db->from('organization_product');
        $this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('product','product.productId=organization_product.productId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('brand','brand.brandId=product.brandId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_size_stock','organization_product.organizationProductId = organization_size_stock.organizationProductId');
		$this->db->join('colors','organization_size_stock.colorId = colors.colorId');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('organization_product.productId' => $producId, 'employee.active' => 1, 'product.active' => 1,'organization_size_stock.colorId' => $colorId, 'organization_size_stock.size' => $sizeId,'organization_product.currentQty >' => 2));
        $this->db->order_by('organization_product.currentPrice', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }

    public function single_product_attributes_details($productId)
    {
        $this->db->select('product_attribute.*,product_taxonomy.attributeNameId,product_taxonomy.attributeTypeId,product_taxonomy.productTypeId,product_taxonomy.isRequired,product_taxonomy.keyFeature,product_attribute_type.description AS attributeType,product_attribute_name.productAttributeName,product_type.description AS product_type');
        $this->db->from('product_attribute');
        $this->db->join('product_taxonomy', 'product_attribute.productTaxonomyId = product_taxonomy.productTaxonomyId');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->where(array('product_attribute.productId' => $productId, 'product_attribute.active' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function admin_product_attributes_details($productId)
    {
        $this->db->select('product_attribute.*,product_taxonomy.attributeNameId,product_taxonomy.attributeTypeId,product_taxonomy.productTypeId,product_taxonomy.isRequired,product_taxonomy.keyFeature,product_attribute_type.description AS attributeType,product_attribute_name.productAttributeName,product_type.description AS product_type');
        $this->db->from('product_attribute');
        $this->db->join('product_taxonomy', 'product_attribute.productTaxonomyId = product_taxonomy.productTaxonomyId', 'left');
        $this->db->join('product_attribute_type', 'product_taxonomy.attributeTypeId = product_attribute_type.productAttributeTypeId', 'left');
        $this->db->join('product_attribute_name', 'product_taxonomy.attributeNameId = product_attribute_name.productAttributeNameId', 'left');
        $this->db->join('product_type', 'product_taxonomy.productTypeId = product_type.productTypeId');
        $this->db->where(array('product_attribute.productId' => $productId, 'product_attribute.active' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function product_table_row($productId)
    {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->where(array('product_image.displayOrder' => 1, 'product.productId' => $productId));
        $result = $this->db->get();
        return $result->row();
    }

    public function accept_request($productId)
    {
        $this->db->where('productId', $productId);
        $this->db->update('product', array('verificationResultId' => 5, 'verifiedBy' => $this->session->userdata('userId'), 'lastModifiedBy' => $this->session->userdata('userId'), 'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function decline_request($productId)
    {
        $this->db->where('productId', $productId);
        $this->db->update('product', array('verificationResultId' => 6, 'verifiedBy' => $this->session->userdata('userId'), 'lastModifiedBy' => $this->session->userdata('userId'), 'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function delete_request($productId)
    {
        $this->db->where('productId', $productId);
        $this->db->update('product', array('verificationResultId' => 7, 'lastModifiedBy' => $this->session->userdata('userId'), 'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function product_request_brand_image_category_tax_details($productId)
    {
        $this->db->select('product.*,brand.brandName,brand.active AS brandStatus,product_image.imageName,product_image.displayOrder,t1.categoryCode AS subCat6Name,t2.categoryCode AS subCat5Name,t3.categoryCode AS subCat4Name,t4.categoryCode AS subCat3Name,t5.categoryCode AS subCat2Name,t6.categoryCode AS subCat1Name,t7.categoryCode AS catName,t8.categoryCode AS segName,t1.categoryId AS subCat6Id,t2.categoryId AS subCat5Id,t3.categoryId AS subCat4Id,t4.categoryId AS subCat3Id,t5.categoryId AS subCat2Id,t6.categoryId AS subCat1Id,t7.categoryId AS catId,t8.categoryId AS segId,employee.firstName,employee.middle,employee.lastName');
        $this->db->from('product');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('employee', 'product.createBy = employee.employeeId');
        $this->db->join('product_image', 'product.productId = product_image.productId', 'left');
        $this->db->join('category AS t1', 'product_category.categoryId = t1.categoryId', 'left');
        $this->db->join('category AS t2', 't1.parentCategoryId = t2.categoryId', 'left');
        $this->db->join('category AS t3', 't2.parentCategoryId = t3.categoryId', 'left');
        $this->db->join('category AS t4', 't3.parentCategoryId = t4.categoryId', 'left');
        $this->db->join('category AS t5', 't4.parentCategoryId = t5.categoryId', 'left');
        $this->db->join('category AS t6', 't5.parentCategoryId = t6.categoryId', 'left');
        $this->db->join('category AS t7', 't6.parentCategoryId = t7.categoryId', 'left');
        $this->db->join('category AS t8', 't7.parentCategoryId = t8.categoryId', 'left');
        $this->db->where(array('product.productId' => $productId, 'product_image.active' => 1));
        $result = $this->db->get();
        return $result->result();
    }

    public function total_products_request($where = '')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('verification_result');
        $this->db->join('product', 'verification_result.verificationResultId = product.verificationResultId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('employee', 'product.createBy = employee.employeeId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->join('product_category', 'product.productId = product_category.productId', 'left');
        $this->db->join('category', 'product_category.categoryId = category.categoryId'); //, 'left');
        $this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1,'category.active' => 1));
        if ($this->session->userdata('userType') == 'cse') 
		{
            $this->db->where('(product.verificationResultId = 4 OR product.verificationResultId = 6)');
            $this->db->where('product.createBy', $this->session->userdata('userId'));
        }
		elseif ($this->session->userdata('userType') == 'retailer') 
		{
            $this->db->where('(product.verificationResultId = 3 OR product.verificationResultId = 10)');
            $this->db->where('product.createBy', $this->session->userdata('userId'));
        }
		else 
		{
            $this->db->where('(product.verificationResultId = 3 OR product.verificationResultId = 4)');
        }

        if (!empty($where)) {
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
        if (!empty($result)) {
            $total = $result->total;
        }
        return $total;
    }

    public function products_request_list_test($start = 0, $limit = '', $where = '')
    {
        $this->db->select('product.*,brand.brandName,product_image.imageName,category.categoryCode,employee.firstName,employee.middle,employee.lastName');
        $this->db->from('verification_result');
        $this->db->join('product', 'verification_result.verificationResultId = product.verificationResultId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('employee', 'product.createBy = employee.employeeId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->join('product_category', 'product.productId = product_category.productId', 'left');
        $this->db->join('category', 'product_category.categoryId = category.categoryId'); //, 'left');
        $this->db->where(array('product_image.displayOrder' => 1,'brand.active' => 1,'category.active' => 1));

        if ($this->session->userdata('userType') == 'cse') 
		{
            $this->db->where('(product.verificationResultId = 4 OR product.verificationResultId = 6)');
            $this->db->where('product.createBy', $this->session->userdata('userId'));
        } 
		elseif ($this->session->userdata('userType') == 'retailer') 
		{
            $this->db->where('(product.verificationResultId = 3 OR product.verificationResultId = 6)');
            $this->db->where('product.createBy', $this->session->userdata('userId'));
        }
		else 
		{
            $this->db->where('(product.verificationResultId = 3 OR product.verificationResultId = 4)');
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('product.code', 'asc');
        $result = $this->db->get();
        return $result->result();
    }

    public function product_decline_request($productId, $reason)
    {
        $this->db->where('productId', $productId);
        $this->db->update('product', array('verificationResultId' => 6, 'requestReason' => $reason, 'lastModifiedBy' => $this->session->userdata('userId'), 'lastModifiedDt' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    public function add_color_stock($organizationProductId, $stock, $color)
    {
        $insertOpt = array();
        foreach($color as $singlecolor) 
		{
        	$insertOpt[] = array(
                				'organizationProductId' => $organizationProductId,
				                'currentStock' 			=> $stock,
				                'colorId' 				=> $singlecolor,
								'createdBy'				=> $this->session->userdata('userId'),
								'createDt'				=> date('Y-m-d H:i:s'),
								'lastModifiedBy'		=> $this->session->userdata('userId'),
								'lastModifiedDt'		=> date('Y-m-d H:i:s'),
				            );
		}
        if(!empty($insertOpt)) 
		{
        	$this->db->insert_batch('organization_size_stock', $insertOpt);
            return $this->db->affected_rows();
        }
    }

    public function add_size_stock($organizationProductId,$stock,$size,$color)
    {
        if(is_array($color)) 
		{
        	foreach($color as $singlecolor) 
			{
            	$insertOpt[] = array(
                					'organizationProductId' => $organizationProductId,
									'currentStock' 			=> $stock,
				                    'size' 					=> $size,
				                    'colorId' 				=> $singlecolor,
									'createdBy'				=> $this->session->userdata('userId'),
									'createDt'				=> date('Y-m-d H:i:s'),
									'lastModifiedBy'		=> $this->session->userdata('userId'),
									'lastModifiedDt'		=> date('Y-m-d H:i:s'),
				                );

            }
            $this->db->insert_batch('organization_size_stock', $insertOpt);
            return $this->db->affected_rows();
        }
		else 
		{
        	$insertOpt = array(
                			'organizationProductId' => $organizationProductId,
							'currentStock' 			=> $stock,
							'size' 					=> $size,
							'colorId' 				=> $color,
							'createdBy'				=> $this->session->userdata('userId'),
							'createDt'				=> date('Y-m-d H:i:s'),
							'lastModifiedBy'		=> $this->session->userdata('userId'),
							'lastModifiedDt'		=> date('Y-m-d H:i:s'),
						);
			$this->db->insert('organization_size_stock', $insertOpt);
            return $this->db->insert_id();
		}

    }
	
	public function add_organization_color_stock($organizationProductId,$stock,$colorId)
	{
		$insertOpt = array(
                		'organizationProductId' => $organizationProductId,
                		'currentStock' 			=> $stock,
						'colorId' 				=> $colorId,
						'active'				=> 1,
						'createdBy'				=> $this->session->userdata('userId'),
						'createDt'				=> date('Y-m-d H:i:s'),
						'lastModifiedBy'		=> $this->session->userdata('userId'),
						'lastModifiedDt'		=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('organization_color_stock', $insertOpt);
        return $this->db->insert_id();
	}
	
    public function update_size_stock($organizationProductId, $stock, $size = '', $color = '')
    {
        $insertOpt = array('currentStock' => $stock,);
        $this->db->set('currentStock', $stock, FALSE);
        $this->db->where('organizationProductId', $organizationProductId);
        if(!empty($size)) 
		{
            $this->db->where('size', $size);
        }
        if(!empty($color)) 
		{
            $this->db->where('colorId', $color);
        }
        $this->db->update('organization_size_stock');
        return $this->db->affected_rows();
    }

    public function delete_product_color($productId)
    {
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('productId',$productId);
		$this->db->update('product_color',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function delete_product_size($productId)
    {
		$updateOpt = array(
						'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('productId',$productId);
		$this->db->update('product_size',$updateOpt);
		return $this->db->affected_rows();
	}

    public function update_product_color($product_id, $coloridArr)
    {
        foreach($coloridArr as $color)
		{
        	$insertOpt[] = array(
            					'productId' 	 => $product_id,
								'colorId'   	 => $color,
								'active'    	 => 1,
								'createDt' 		 => date('Y-m-d H:i:s'),
								'createBy'		 => $this->session->userdata('userId'),
								'lastModifiedDt' => date('Y-m-d H:i:s'),
								'lastModifiedBy' => $this->session->userdata('userId'),
            				);

        }
        $this->db->insert_batch('product_color', $insertOpt);
        return $this->db->affected_rows();
	}
	
	public function update_product_size($productId,$sizeArr)
    {
		$insertOpt = array();
        foreach($sizeArr as $size)
		{
			$size = trim($size);
			if(!empty($size))
			{
	        	$insertOpt[] = array(
    	        					'productId' 	 => $productId,
									'sizes'		   	 => trim($size),
									'active'    	 => 1,
									'createDt' 		 => date('Y-m-d H:i:s'),
									'createBy'		 => $this->session->userdata('userId'),
									'lastModifiedDt' => date('Y-m-d H:i:s'),
									'lastModifiedBy' => $this->session->userdata('userId'),
	            				);
			}
        }
		
		if(!empty($insertOpt))
		{
	        $this->db->insert_batch('product_size', $insertOpt);
    	    return $this->db->affected_rows();
		}
	}

    public function add_color($color)
    {
        $insertOpt = array(
            'colorCode' => $color
        );
        $this->db->insert('colors', $insertOpt);
        return $this->db->insert_id();
    }

    public function get_product_color_list($productId)
    {

        return $this->db->select('*')->from('product_color')->join('colors', 'product_color.colorId=colors.colorId')->where('productId', $productId)->get()->result();
    }

    public function get_marketing_product_detail($product_id)
    {
        return $this->db->select('*')->from('marketing_product')->where('productId',$product_id)->get()->row();
    }
	
	public function get_marketing_product_detail_for_product($product_id)
    {
		$this->db->select('*');
		$this->db->from('marketing_product');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('marketing_product_category','marketing_product_category.marketingProductId=marketing_product.marketingProductId');
		$this->db->join('category','category.categoryId=marketing_product_category.categoryId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->where(array('marketing_product.productId' => $product_id,'product_image.displayOrder' => 1,'product.active' => 1,'marketing_product.active' => 1,'DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= ' => date('Y-m-d'),'DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= ' => date('Y-m-d')));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		$result = $this->db->get()->row();
		//echo "<pre>"; print_r($result); exit;
		return $result;
    }

    public function update_retailer_product_price($organizationProductId, $currentPrice)
    {
		$updateOpt = array(
						'currentPrice'   => $currentPrice,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s')
						);
        $this->db->where('organizationProductId',$organizationProductId);
        $this->db->update('organization_product',$updateOpt);
        return $this->db->affected_rows();
    }

    public function check_organization_product_count($organizationProductId)
    {
        $query = $this->db->select('*')->from('organization_product_view_count')->where('organizationProductId', $organizationProductId)->get();

        return $query->row();

    }

    public function check_organization_product_count_list($start, $limit)
    {
        $this->db->select('*')->from('organization_product_view_count');
        $this->db->join('organization_product', 'organization_product.organizationProductId=organization_product_view_count.organizationProductId');
        $this->db->join('product', 'product.productId=organization_product.productId');
        $this->db->join('product_image', 'product_image.productId=product.productId');
        $this->db->where('product_image.displayOrder', 1);
		$this->db->group_by('organization_product.productId');
        $this->db->order_by('totalViewCount', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();

    }

    public function add_organization_product_count($organizationProductId)
    {
        $insertOpt = array(
            'totalViewCount' => 1,
            'organizationProductId' => $organizationProductId
        );
        $this->db->insert('organization_product_view_count', $insertOpt);
        return $this->db->affected_rows();
    }

    public function update_organization_product_count($organizationProductId)
    {
        $this->db->set('totalViewCount', 'totalViewCount + 1', FALSE);
        $this->db->where('organizationProductId', $organizationProductId);
        $this->db->update('organization_product_view_count');
        return $this->db->affected_rows();
    }

    public function add_inventory_history($addArr)
    {
        $insertOpt = array(
						'organizationProductId'  => $addArr['organizationProductId'],
						'organizationId'         => $addArr['organizationId'],
						'productId'              => $addArr['productId'],
						'quantity'               => $addArr['stock'],
						'retailerQuotePrice'	 => $addArr['retailerQuotePrice'],
						'retailerPrice'          => $addArr['retailerPrice'],
						'spacePointeCommission'  => $addArr['spacePointeCommission1'],
						'spacePointeCommission2' => $addArr['spacePointeCommission2'],
						'adminPrice'             => $addArr['cashAdminPrice'],
						'displayPrice'           => $addArr['displayPrice'],
						'active'                 => 1,
						'createBy'      	     => $this->session->userdata('userId'),
						'createDt' 		         => date('Y-m-d H:i:s'),
						'lastModifiedBy'         => $this->session->userdata('userId'),
						'lastModifiedDt'         => date('Y-m-d H:i:s'),
					);
        $this->db->insert('inventory_history', $insertOpt);
		//echo $this->db->last_query(); exit;
        return $this->db->insert_id();
    }
	
	public function product_images($product_id)
    {
		$this->db->select('*');
        $this->db->from('product_image');
        $this->db->where(array('product_image.productId' => $product_id,'active' => 1));
        $result = $this->db->get()->result();
        return $result;
	}
	
	public function product_seller_list_with_color_or_size($producId)
    {
		$this->db->select('product.*,product_category.categoryId,category.categoryCode,brand.brandName,organization.organizationName,marketing_product.currentPrice AS adminPrice,employee.firstName,employee.middle,employee.lastName,organization.dropshipCentre,product.weight,product.shippingWeight,organization_size_stock.*,colors.*,organization_product.*,marketing_size_stock.colorId AS marketingColorId,marketing_size_stock.size AS marketingSize,marketing_size_stock.currentStock as marketingStock,marketing_product.costPrice,dropship_center.dropCenterName,marketing_product.marketingProductId,marketing_size_stock.marketingProductSizeId');
        $this->db->from('organization_product');
        $this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('product','product.productId=organization_product.productId');
		$this->db->join('product_category','product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');		
        $this->db->join('brand','brand.brandId=product.brandId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_size_stock','organization_product.organizationProductId = organization_size_stock.organizationProductId','left');
        $this->db->join('marketing_size_stock','marketing_product.marketingProductId = marketing_size_stock.marketingProductId and organization_size_stock.size=marketing_size_stock.size and organization_size_stock.colorId=marketing_size_stock.colorId','left');
        $this->db->join('colors','organization_size_stock.colorId = colors.colorId','left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('organization_product.productId' => $producId, 'employee.active' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
		if(!empty($where))
		{
			$this->db->where($where);
		}
        $this->db->order_by(
            'organization_product.currentPrice','desc'
        );
        $result = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $result->result();
    }
	
	public function product_seller_list_with_color_or_size_change($producId)
	{
	
		$this->db->select('product.*,product_category.categoryId,category.categoryCode,brand.brandName,organization.organizationName,marketing_product.currentPrice AS adminPrice,employee.firstName,employee.middle,employee.lastName,organization.dropshipCentre,product.weight,product.shippingWeight,organization_color_size_stock.*,colors.*,organization_product.*,marketing_size_stock.colorId AS marketingColorId,marketing_size_stock.size AS marketingSize,marketing_size_stock.currentStock as marketingStock,marketing_product.costPrice,dropship_center.dropCenterName,marketing_product.marketingProductId,marketing_size_stock.marketingProductSizeId,product_size.sizes');
        $this->db->from('organization_product');
        $this->db->join('organization','organization_product.organizationId=organization.organizationId');
        $this->db->join('employee','organization.organizationId = employee.organizationId');
        $this->db->join('product','product.productId=organization_product.productId');
		$this->db->join('product_category','product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');		
        $this->db->join('brand','brand.brandId=product.brandId');
        $this->db->join('dropship_center','organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('marketing_product','organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_color_size_stock','organization_product.organizationProductId = organization_color_size_stock.organizationProductId','left');
		$this->db->join('product_size','organization_color_size_stock.productSizeId = product_size.productSizeId','left');
        $this->db->join('marketing_size_stock','marketing_product.marketingProductId = marketing_size_stock.marketingProductId and product_size.sizes = marketing_size_stock.size and organization_color_size_stock.colorId=marketing_size_stock.colorId','left');
        $this->db->join('colors','organization_color_size_stock.colorId = colors.colorId','left');
        $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where(array('organization_product.productId' => $producId, 'employee.active' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
		if(!empty($where))
		{
			$this->db->where($where);
		}
        $this->db->order_by(
            'organization_product.currentPrice','desc'
        );
        $result = $this->db->get();
		//echo $this->db->last_query(); exit;
        return $result->result();
    
	}
	public function front_product_listing_test_purpose($start = 0, $limit = '', $where = '')
    {
		$this->db->select('product.code,organization_product.*,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,organization_product.productId,product_image.imageName AS mainImage,organization.organizationName,marketing_product.currentPrice AS adminPrice');
		$this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
	    $this->db->join('product_image', 'product.productId = product_image.productId');
		$this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
		$this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
		$this->db->join('brand', 'product.brandId = brand.brandId', 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->where(array('employee.active' => 1, 'product_image.displayOrder' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		$this->db->order_by('organization_product.currentPrice', 'ASC');
		$result = $this->db->get();
        return $result->result();
		
		if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('organization_product.currentPrice', 'ASC');
        $this->db->limit(12,0);
        
        $result = $this->db->get();
        return $result->result();
    }
	
	public function product_listing_according_categry($start=0,$limit='',$where='',$orderBy=1)
    {
		$this->db->select('product_rating_count.*,product.code,organization_product.*,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,organization_product.productId,product_image.imageName AS mainImage,organization.organizationName,marketing_product.currentPrice AS adminPrice,product.weight,product.shippingWeight,min(organization_product.currentPrice),wish_list.wishListId,wish_list.customerId,product.productTypeId');
        $this->db->from('product');
        $this->db->join('organization_product', 'product.productId = organization_product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_product_view_count','product.productId = organization_product_view_count.organizationProductId','left');
		$this->db->join('product_rating_count','product.productId = product_rating_count.productId AND product_rating_count.active = 1','left');
		$this->db->join('wish_list','product.productId = wish_list.productId','left');

        $this->db->where(array(
							'employee.active' => 1, 
							'product_image.displayOrder' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2,
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where)) 
		{
            $this->db->where($where);
        }
		$this->db->group_by('organization_product.productId');
		if($orderBy==1)
		{
	        $this->db->order_by('organization_product.currentPrice', 'ASC');		
		}
		elseif($orderBy==2)
		{
	        $this->db->order_by('organization_product.currentPrice', 'DESC');		
		}
		elseif($orderBy==3)
		{
	        $this->db->order_by('organization_product_view_count.totalViewCount','DESC');		
		}
				
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }
	
	public function add_free_shipping_product($categoryId,$productId)
	{
		$insertOpt = array(
						'categoryId'	 => $categoryId,
						'productId'		 => $productId,
						'isFreeShipping' => 1,
						'active'     	 => 1,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('product_free_shipping',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function total_free_shipping_product($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('product_free_shipping');
		$this->db->join('product', 'product_free_shipping.productId = product.productId');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
		$this->db->join('product_image', 'product.productId = product_image.productId');        
        $this->db->join('brand', 'product.brandId = brand.brandId', 'left');
		$this->db->where(array('product_free_shipping.active' => 1,'product_image.displayOrder' => 1, 'product.active' => 1));
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
	
	public function free_shipping_product_list($start=0,$limit='',$where='')
	{
		$this->db->select('product_free_shipping.*,category.categoryCode,product.code,brand.brandName,product_image.imageName');
		$this->db->from('product_free_shipping');
		$this->db->join('product','product_free_shipping.productId = product.productId');
        $this->db->join('product_category','product.productId = product_category.productId');
        $this->db->join('category','product_category.categoryId = category.categoryId');
		$this->db->join('product_image','product.productId = product_image.productId');        
        $this->db->join('brand','product.brandId = brand.brandId','left');
		$this->db->where(array('product_free_shipping.active' => 1,'product_image.displayOrder' => 1, 'product.active' => 1));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('product_free_shipping.lastModifiedDt','DESC');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}		
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function delete_free_shipping_product($freeShipPrdId)
	{
		$updateOpt = array(
					 	'active'         => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('freeShipPrdId',$freeShipPrdId);
		$this->db->update('product_free_shipping',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function free_shipping_product_detail($freeShipPrdId)
	{
		$this->db->where(array('freeShipPrdId' => $freeShipPrdId,'active' => 1));
		$result = $this->db->get('product_free_shipping')->row();
		return $result;
	}
	
	public function free_shipping_prd_details($productId)
	{
		$this->db->where(array('productId' => $productId,'active' => 1));
		$result = $this->db->get('product_free_shipping')->row();
		return $result;
	}
		    
	public function product_details($productId)
	{
		$this->db->select('product.code,organization_product.*,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,product_image.imageName');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->where(array(
							'product_image.displayOrder' 		=> 1, 
							'product.active' 					=> 1,
							'organization_product.currentQty >' => 2,
							'category.active' 					=> 1,
							'brand.active' 						=> 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        $this->db->where('product.productId',$productId);
        $result = $this->db->get();
        return $result->row();
	}
	
	public function add_product_history($productId,$addArr)
	{
		$insertOpt = array(
						'productId' 		   => $productId,
						'code' 				   => $addArr['product_name'],
						'verificationResultId' => 1,            
						'weight' 			   => $addArr['item_weight'],
			            'shippingWeight' 	   => $addArr['packaging_weight'],
						'brandId' 			   => $addArr['brand_id'],
						'categoryId' 		   => $addArr['lastCatId'],
						'productTypeId'		   => $addArr['product_type'],
            			'createBy'		 	   => $this->session->userdata('userId'),
			            'createDt' 	   		   => date('Y-m-d H:i:s'),
						'lastModifiedBy' 	   => $this->session->userdata('userId'),
			            'lastModifiedDt' 	   => date('Y-m-d H:i:s'),
       				 );
        if((isset($addArr['sizes']))&&(!empty($addData['sizes'])))
		{
        	$insertOpt['sizes'] = $addArr['sizes'];
        }
        $this->db->insert('product_history',$insertOpt);
        return $this->db->insert_id();
    }
	
	public function last_product_history($productId)
	{
		$this->db->where(array('productId' => $productId,'verificationResultId' => 1));
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get('product_history')->row();
		return $result;
	}
	
	public function update_varification_history($productHistoryId,$verificationResultId)
	{
		$updateOpt = array(
					 	'verificationResultId' => $verificationResultId,
						'lastModifiedDt' 	   => date('Y-m-d H:i:s'),
						'lastModifiedBy' 	   => $this->session->userdata('userId'),
					 );
		$this->db->where('productHistoryId',$productHistoryId);
		$this->db->update('product_history',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function product_category_details($productId)
    {
        $this->db->select('product.code,product.weight,product.shippingWeight,product_category.categoryId');
        $this->db->from('product');
		$this->db->join('product_category','product.productId = product_category.productId');
		$this->db->where(array('product.productId' => $productId));
        $result = $this->db->get();
        return $result->row();
    }
	
	public function product_inventory_history_details($organizationProductId)
	{
		$this->db->select('product.weight,product.shippingWeight,inventory_history.*,organization_product.currentPrice,product_category.categoryId');
        $this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('product_category','product.productId = product_category.productId');
		$this->db->join('inventory_history','organization_product.organizationProductId = inventory_history.organizationProductId','left');
		$this->db->where(array('organization_product.organizationProductId' => $organizationProductId));
		$this->db->order_by('inventory_history.inventoryHistoryId','DESC');
        $result = $this->db->get();
        return $result->row();
	}
	
	public function unactive_old_inventory_history($organizationProductId)
	{
		$updateOpt = array(
						'active' 		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
			            'lastModifiedDt' => date('Y-m-d H:i:s'),
        			);
        $this->db->where('organizationProductId',$organizationProductId);
        $this->db->update('inventory_history',$updateOpt);
        return $this->db->affected_rows();
    }
	
	public function organization_inventory_history($organizationProductId)
	{
		$this->db->select('inventoryHistoryId');
		$this->db->from('inventory_history');
		$this->db->where(array('organizationProductId' => $organizationProductId,'active' => 1));
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get()->row();
		return $result;
    }
	
	public function product_brand_category_details($productId)
    {
        $this->db->select('product.productId,product.code,product.verificationResultId,product.weight,product.shippingWeight,product.sizes,product.productTypeId,product.brandId,product.active,brand.brandName,brand.active AS brandStatus,product_category.categoryId');
        $this->db->from('product');
        $this->db->join('product_category','product.productId = product_category.productId');
		$this->db->join('brand','product.brandId = brand.brandId');
        $this->db->where('product.productId',$productId);
        $result = $this->db->get();
        return $result->row();
    }
	
	public function product_all_size($productId)
    {
        $this->db->select('productSizeId,sizes');
        $this->db->from('product_size');
        $this->db->where(array('productId' => $productId,'active' => 1));
        $result = $this->db->get();
        return $result->result();
	}
	
	public function product_all_color($productId)
    {
        $this->db->select('productColorId,colorId');
        $this->db->from('product_color');
        $this->db->where(array('productId' => $productId,'active' => 1));
        $result = $this->db->get();
        return $result->result();
	}
	
	public function check_size_organization($organizationProductId,$size,$productSizeId)
	{
		$this->db->where('organizationProductId = '.$organizationProductId.' AND active = 1 AND (productSizeId = '.$productSizeId.' OR "'.$size.'")');
		$result = $this->db->get('organization_size_stock')->row();
		return $result;
	}
	
	public function check_color_organization($organizationProductId,$colorId)
	{
		$this->db->select('organizationProductColorId,currentStock');
		$this->db->from('organization_color_stock');
		$this->db->where(array(
							'organizationProductId ' => $organizationProductId,
							'active'				 => 1,
							'colorId'				 => $colorId,
						));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function unactive_old_size($organizationProductId,$productSizeId)
	{
		$updateOpt = array(
					 	'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where(array(
							'organizationProductId' => $organizationProductId,
							'active'				=> 1,
							'productSizeId'			=> $productSizeId
						));
		$this->db->update('organization_size_stock',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function unactive_organization_colors($organizationProductId,$colorId)
	{
		$updateOpt = array(
					 	'active'		 => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where(array(
						'organizationProductId' => $organizationProductId,
						'active'			    => 1,
						'colorId'				=> $colorId
						));
		$this->db->update('organization_color_stock',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_organization_size_stock($organizationProductId,$stock,$productSizeId)
    {
    	$insertOpt = array(
                		'organizationProductId' => $organizationProductId,
						'productSizeId'			=> $productSizeId,
                		'currentStock' 			=> $stock,
						'active' 				=> 1,
						'createdBy'				=> $this->session->userdata('userId'),
						'createDt'				=> date('Y-m-d H:i:s'),
						'lastModifiedBy'		=> $this->session->userdata('userId'),
						'lastModifiedDt'		=> date('Y-m-d H:i:s'),
					);
		$this->db->insert('organization_size_stock', $insertOpt);
        return $this->db->insert_id();
	}
	
	public function add_pseudo_organization_product($productId,$retailerPrice)
	{
		$insertOpt = array(
						'organizationId' => $this->config->item('pseudo_asign_retailer'),
						'productId'      => $productId,
						'currentQty'     => 1000000000,
						'currentPrice'   => $retailerPrice,
						'createDt'       => date('Y-m-d H:i:s'),
						'createBy'       => $this->session->userdata('userId'),
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
        $this->db->insert('organization_product', $insertOpt);
        return $this->db->insert_id();
    }
	
	public function update_pseudo_organization_product($organizationProductId,$retailerPrice)
	{
		$updateOpt = array(
						'currentPrice'   => $retailerPrice,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
		$this->db->where('organizationProductId',$organizationProductId);
        $this->db->update('organization_product', $updateOpt);
		return $this->db->affected_rows();
    }
	
	public function check_pseudo_organization_product_inventory($productId)
	{
		$this->db->select('organizationProductId,currentPrice');
		$this->db->from('organization_product');
		$this->db->where(array('productId' => $productId,'organizationId' => $this->config->item('pseudo_asign_retailer'),'active' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function add_pseudo_product_inventory_history($productId,$organizationProductId,$retailerPrice)
    {
        $insertOpt = array(
						'organizationProductId'  => $organizationProductId,
						'organizationId'         => $this->config->item('pseudo_asign_retailer'),
						'productId'              => $productId,
						'quantity'               => 1000000000,
						'retailerPrice'          => $retailerPrice,
						'active'                 => 1,
						'createBy'      	     => $this->session->userdata('userId'),
						'createDt' 		         => date('Y-m-d H:i:s'),
						'lastModifiedBy'         => $this->session->userdata('userId'),
						'lastModifiedDt'         => date('Y-m-d H:i:s'),
					);
        $this->db->insert('inventory_history', $insertOpt);
        return $this->db->insert_id();
    }
	
	public function add_organization_color_size_stock($organizationProductId,$organizationProductColorId,$organizationProductSizeId,$colorId,$productSizeId,$currentStock)
    {
    	$insertOpt = array(
                		'organizationProductColorId' => $organizationProductColorId,
						'organizationProductSizeId'	 => $organizationProductSizeId,
						'organizationProductId'		 => $organizationProductId,
						'colorId'					 => $colorId,
						'productSizeId'				 => $productSizeId,
						'currentStock'				 => $currentStock,
						'active' 					 => 1,
						'createdBy'					 => $this->session->userdata('userId'),
						'createDt'					 => date('Y-m-d H:i:s'),
						'lastModifiedBy'			 => $this->session->userdata('userId'),
						'lastModifiedDt'			 => date('Y-m-d H:i:s'),
					);
		$this->db->insert('organization_color_size_stock', $insertOpt);
        return $this->db->insert_id();
	}
	
	public function organization_product_colors($organizationProductId)
	{
		$this->db->select('organization_color_stock.organizationProductColorId,organization_color_stock.colorId,organization_color_stock.currentStock,colors.colorCode');
		$this->db->from('organization_color_stock');
		$this->db->join('colors','organization_color_stock.colorId = colors.colorId');
		$this->db->where(array(
							'organization_color_stock.organizationProductId' => $organizationProductId,
							'organization_color_stock.active' => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function organization_product_sizes($organizationProductId)
	{
		$this->db->select('organization_size_stock.organizationProductSizeId,organization_size_stock.productSizeId,organization_size_stock.size,product_size.sizes,organization_size_stock.currentStock');
		$this->db->from('organization_size_stock');
		$this->db->join('product_size','organization_size_stock.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'organization_size_stock.organizationProductId' => $organizationProductId,
							'organization_size_stock.active' => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function check_product_size($productId,$sizeName)
	{
		$this->db->select('productSizeId');
		$this->db->from('product_size');
		$this->db->where(array('productId' => $productId,'active' => 1));
		$this->db->like('sizes',$sizeName);
		$result = $this->db->get()->row();
		return $result;
	}
	
	/***********mobilepointemat**********************/
	public function wishlist_listing_desc()
    {
        $this->db->select('*');
        $this->db->from('wish_list');
        $this->db->join('organization_product', 'wish_list.productId = organization_product.productId');
        $this->db->where('wish_list.customerId', $this->session->userdata('userId'));
        $this->db->order_by('wish_list.createDt', 'desc');
        $result = $this->db->get();
        return $result->row();
	}
	
	public function total_general_products($where = '')
    {
        $total = 0;
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->where('((product.verificationResultId = 2 OR product.verificationResultId = 5) AND (product.productTypeId != 3))');
        $this->db->where(array(
							'product_image.displayOrder' => 1,
							'brand.active' 				 => 1,
							'category.active' 			 => 1,
						 ));
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
	
	public function general_products_list($start=0,$limit='',$where='')
    {
        $this->db->select('product.*,brand.brandName,category.categoryCode,(SELECT GROUP_CONCAT( CONCAT( organization_product.organizationId,"|",organization_product.organizationProductId) ) FROM organization_product WHERE organization_product.productId = product.productId) AS orgPrdIDS,product_image.imageName', false);
        $this->db->from('product');
        $this->db->join('product_category', 'product.productId = product_category.productId');
        $this->db->join('category', 'product_category.categoryId	 = category.categoryId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->where('((product.verificationResultId = 2 OR product.verificationResultId = 5) AND (product.productTypeId != 3))');
		$this->db->where(array(
							'product_image.displayOrder' => 1,
							'brand.active' 				 => 1,
							'category.active' 			 => 1,
						 ));
        if(!empty($where))          
		{
            $this->db->where($where);
        }
        $this->db->order_by('product.code', 'asc');
		if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }
	
	public function last_size_organization_stock($organizationProductId,$productSizeId)
	{
		$this->db->select('organizationProductSizeId,productSizeId,currentStock,colorId');
		$this->db->from('organization_size_stock');
		$this->db->where(array(
							'organizationProductId' => $organizationProductId,
							'active'				=> 1,
							'productSizeId'			=> $productSizeId
						));
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function last_color_organization_stock($organizationProductId,$colorId)
	{
		$this->db->select('organizationProductColorId,currentStock,colorId');
		$this->db->from('organization_color_stock');
		$this->db->where(array(
							'organizationProductId' => $organizationProductId,
							'active'				=> 1,
							'colorId'			    => $colorId
						));
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function organization_product_colors_size($organizationProductId)
	{
		$this->db->select('organization_color_stock.organizationProductColorId,organization_color_stock.colorId,organization_color_size_stock.currentStock,colors.colorCode,organization_color_size_stock.organizationProductSizeId');
		$this->db->from('organization_color_stock');
		$this->db->join('colors','organization_color_stock.colorId = colors.colorId');
		$this->db->join('organization_color_size_stock','organization_color_stock.organizationProductColorId = organization_color_size_stock.organizationProductColorId');
		$this->db->where(array(
							'organization_color_stock.organizationProductId' => $organizationProductId,
							'organization_color_stock.active' 				 => 1,
							'organization_color_size_stock.active' 			 => 1
						));
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function organization_product_sizes_color($organizationProductId)
	{
		$this->db->select('organization_size_stock.organizationProductSizeId,organization_size_stock.productSizeId,organization_size_stock.size,product_size.sizes,organization_color_size_stock.currentStock,organization_color_size_stock.organizationProductColorId');
		$this->db->from('organization_size_stock');
		$this->db->join('organization_color_size_stock','organization_size_stock.organizationProductSizeId = organization_color_size_stock.organizationProductSizeId');
		$this->db->join('product_size','organization_size_stock.productSizeId = product_size.productSizeId','left');
		$this->db->where(array(
							'organization_size_stock.organizationProductId' => $organizationProductId,
							'organization_size_stock.active' 				=> 1,
							'organization_color_size_stock.active' 			=> 1
						));
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function old_organization_color_size_stock($organizationProductId,$colorId=0,$productSizeId=0)
	{
		$this->db->select('currentStock');
		$this->db->from('organization_color_size_stock');
		$this->db->where(array('active' =>  1,'organizationProductId' => $organizationProductId));
		if($colorId)
		{
			$this->db->where('colorId',$colorId);
		}
		if($productSizeId)
		{
			$this->db->where('productSizeId',$productSizeId);
		}
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function unactive_organization_color_size_stock($organizationProductId,$colorId=0,$productSizeId=0)
	{
		$updateOpt = array(
						'active' 		 => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
        $this->db->where(array('active' =>  1,'organizationProductId' => $organizationProductId));
		if($colorId)
		{
			$this->db->where('colorId',$colorId);
		}
		if($productSizeId)
		{
			$this->db->where('productSizeId',$productSizeId);
		}
		
        $this->db->update('organization_color_size_stock',$updateOpt);
        return $this->db->affected_rows();
	}
	
	public function organization_color_size_details($organizationProductId)
	{
		$this->db->select('organization_color_size_stock.organizationColorSizeId,organization_color_size_stock.organizationProductColorId,organization_color_size_stock.organizationProductSizeId,organization_color_size_stock.colorId,organization_color_size_stock.productSizeId,organization_color_size_stock.currentStock,colors.colorCode,product_size.sizes');
		$this->db->from('organization_color_size_stock');
		$this->db->join('colors','organization_color_size_stock.colorId = colors.colorId AND organization_color_size_stock.active = 1','left');
		$this->db->join('product_size','organization_color_size_stock.productSizeId = product_size.productSizeId AND organization_color_size_stock.active = 1','left');
		$this->db->where(array(
							'organization_color_size_stock.organizationProductId' => $organizationProductId,
							'organization_color_size_stock.active' 			 	  => 1
						));
		$this->db->order_by('organization_color_size_stock.organizationColorSizeId','ASC');
		$result = $this->db->get()->result();
		return $result;
	
	}
	
	public function product_listing_according_brand($start=0,$limit='',$where='')
    {
		$this->db->select('product_rating_count.avgProductRating,product.code,product.productTypeId,organization_product.productId,organization_product.organizationProductId,organization_product.currentPrice,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,product_image.imageName,marketing_product.currentPrice AS marketingPrice,product.weight,product.shippingWeight,wish_list.wishListId,wish_list.customerId,product.brandId,organization_product_view_count.totalViewCount');
        $this->db->from('product');
        $this->db->join('organization_product','product.productId = organization_product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_product_view_count','product.productId = organization_product_view_count.organizationProductId','left');
		$this->db->join('product_rating_count','product.productId = product_rating_count.productId AND product_rating_count.active = 1','left');
		$this->db->join('wish_list','product.productId = wish_list.productId','left');

        $this->db->where(array(
							'employee.active' => 1, 
							'product_image.displayOrder' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2,
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where)) 
		{
            $this->db->where($where);
        }
		$this->db->group_by('organization_product.productId');
		
				
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }
	
	public function add_temp_product_listing($addArr)
	{
		return $this->db->insert_batch('product_list_temp', $addArr);
	}
	
	public function total_product_temp_list($where='')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_list_temp');
        $this->db->where(array(
							'sessionId' 							 => $this->session->userdata('session_id'),
							'addFor' 								 => 'Brand',
							'DATE_FORMAT(lastModifiedDt,"%Y-%m-%d")' => date('Y-m-d'),
						));
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
	
	public function product_temp_list($start=0,$limit='',$where='',$orderBy=1)
    {
		$this->db->select('*');
        $this->db->from('product_list_temp');
        $this->db->where(array(
							'sessionId' 							 => $this->session->userdata('session_id'),
							'addFor' 								 => 'Brand',
							'DATE_FORMAT(lastModifiedDt,"%Y-%m-%d")' => date('Y-m-d'),
						));
		
		if(!empty($where))
		{
			$this->db->where($where);
		}	
		if($orderBy==1)
		{
	        $this->db->order_by('displayPrice','ASC');		
		}
		elseif($orderBy==2)
		{
	        $this->db->order_by('displayPrice','DESC');		
		}
		elseif($orderBy==3)
		{
	        $this->db->order_by('totalViewCount','DESC');		
		}	
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
	}
	
	public function product_listing_pre_sales()
    {
		$this->db->select('product_rating_count.avgProductRating,product.code,product.productTypeId,organization_product.productId,organization_product.organizationProductId,organization_product.currentPrice,product_category.categoryId,category.categoryCode,brand.brandId,brand.brandName,product_image.imageName,marketing_product.currentPrice AS marketingPrice,product.weight,product.shippingWeight,wish_list.wishListId,wish_list.customerId,product.brandId,organization_product_view_count.totalViewCount,organization_product.organizationId');
        $this->db->from('product');
        $this->db->join('organization_product','product.productId = organization_product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('category', 'product_category.categoryId = category.categoryId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0', 'left');
		$this->db->join('organization_product_view_count','product.productId = organization_product_view_count.organizationProductId','left');
		$this->db->join('product_rating_count','product.productId = product_rating_count.productId AND product_rating_count.active = 1','left');
		$this->db->join('wish_list','product.productId = wish_list.productId','left');

        $this->db->where(array(
							'employee.active'				 	  => 1, 
							'product_image.displayOrder' 		  => 1, 
							'organization_product.currentQty >'   => 2,
							'category.active' 					  => 1,
							'brand.active' 						  => 1,
							'organization_product.organizationId' => $this->config->item('pseudo_asign_retailer'),
							'product.productTypeId'				  => 3,
							'product.active' 					  => 1,
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where)) 
		{
            $this->db->where($where);
        }
		$this->db->group_by('organization_product.productId');
		
				
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
    }
	
	public function delete_old_brand_product_list($sessionId)
	{
		$this->db->where(array('sessionId' => $sessionId,'addFor' => 'Brand'));
		$this->db->delete('product_list_temp');
		return $this->db->affected_rows();
	}
	
	public function delete_old_pre_sale_product_list($sessionId)
	{
		$this->db->where(array(
							'sessionId' => $sessionId,
							'addFor' 	=> 'Pre_sale',
						 ));
		$this->db->delete('product_list_temp');
		
		/*$this->db->where(array(
							'addFor' 									 => 'Pre_sale',
							'DATE_FORMAT(lastModifiedDt,"%Y-%m-%d") <= ' => date('Y-m-d'),
						 ));
		$this->db->delete('product_list_temp');*/
		return $this->db->affected_rows();
	}
	
	public function total_pre_sales_product_list_temp($where='')
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_list_temp');
        $this->db->where(array(
							'sessionId' 							 => $this->session->userdata('session_id'),
							'addFor' 								 => 'Pre_sale',
							'DATE_FORMAT(lastModifiedDt,"%Y-%m-%d")' => date('Y-m-d'),
							'organizationId'						 => $this->config->item('pseudo_asign_retailer'),
							'productTypeId'				  	 		 => 3,
						));
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
	
	public function pre_sales_product_list_temp($start=0,$limit='',$where='',$orderBy=1)
    {
		$this->db->select('*');
        $this->db->from('product_list_temp');
		$this->db->where(array(
							'sessionId' 							 => $this->session->userdata('session_id'),
							'addFor' 								 => 'Pre_sale',
							'DATE_FORMAT(lastModifiedDt,"%Y-%m-%d")' => date('Y-m-d'),
							'organizationId'						 => $this->config->item('pseudo_asign_retailer'),
							'productTypeId'				  	 		 => 3,
						));
		if(!empty($where))
		{
			$this->db->where($where);
		}	
		if($orderBy==1)
		{
	        $this->db->order_by('displayPrice','ASC');		
		}
		elseif($orderBy==2)
		{
	        $this->db->order_by('displayPrice','DESC');		
		}
		elseif($orderBy==3)
		{
	        $this->db->order_by('totalViewCount','DESC');		
		}	
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
	}
}