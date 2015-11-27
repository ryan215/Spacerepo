<?php
    class Api_product_m extends MY_Model{

        public function __construct()
        {
            parent::__construct();
        }
        public function add_product($ProdArr)
        {
            $insertopt=	array(
                'code'					=>	$ProdArr['productCodeOveride'],
                'description'	=>  $ProdArr['productDescription'],
                'verificationResultId'	=>	3,
                'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
                'lastModifiedBy' 		=> $ProdArr['employeeId']

            );

            $this->db->insert('product',$insertopt);
            return $this->db->insert_id();


        }
        public function add_organization_product($ProdArr)
        {
            $insertopt=	array(
                'organizationId'		=>	$ProdArr['organizationId'],
                'productId'				=>	$ProdArr['productId'],
                'productCodeOveride'	=>	$ProdArr['productCodeOveride'],
                'productDescription'	=>  $ProdArr['productDescription'],
                'currentPrice'			=>	$ProdArr['currentPrice'],
                'costPrice'				=>	$ProdArr['costPrice'],
                'upc'					=>	$ProdArr['upc'],
                'associationType'		=>	0,
                'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
                'lastModifiedBy' 		=> $ProdArr['employeeId']

            );

            $this->db->insert('organization_product',	$insertopt);
            return $this->db->insert_id();
        }
        public function update_product($ProdArr,$organizationProductId)
        {
            $updateopt=array
            (
                'productCodeOveride'	=>	$ProdArr['productCodeOveride'],
                'productDescription'	=>  $ProdArr['productDescription'],
                'currentPrice'			=>	$ProdArr['currentPrice'],
                'costPrice'				=>	$ProdArr['costPrice'],
                'upc'					=>	$ProdArr['upc'],

                'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
                'lastModifiedBy' 		=> $ProdArr['employeeId']
            );
            $this->db->where('organizationProductId',$organizationProductId);
            $this->db->update('organization_product',$updateopt);
            return $this->db->affected_rows();
        }
        public function organization_product_Category($catArr,$employeeId)
        {
            $insertopt=	array(
                'productId'			=>	$catArr['productId'],
                'categoryId'		=>	$catArr['categoryId'],
                'organizationId'	=>	$catArr['organizationId'],
                'createDt'			=>	date('Y-m-d H:i:s'),
                'lastModifiedDt' => date('Y-m-d H:i:s'),
                'lastModifiedBy' => $employeeId
            );

            $this->db->insert('product_category',$insertopt);
            return $this->db->affected_rows();
        }
        public function master_product_list($organizationId,$start='',$limit='',$where='',$where_not_in='')
        {

            $this->db->select('product.*,brand.brandName,category.categoryCode,product_image.*',false);
            $this->db->from('verification_result');
            $this->db->join('product','verification_result.verificationResultId = product.verificationResultId');
            $this->db->join('product_category','product.productId = product_category.productId');
            $this->db->join('category','product_category.categoryId	 = category.categoryId');
            $this->db->join('category as t1','category.parentCategoryId	 = t1.categoryId');
            $this->db->join('product_image','product.productId = product_image.productId');
            $this->db->join('brand','product.brandId = brand.brandId','left');
            if(!empty($where_not_in))
            {
                $where_not_in=explode(',',$where_not_in);
                $this->db->where_not_in('product.productId',$where_not_in);
                //$this->db->where_not_in('product_category.productId',$where_not_in);
            }
            $this->db->where(array('product_image.displayOrder' => 1,'product_category.active' => 1,'product_category.organizationId'=>1));

            $this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');

            if(!empty($where))
            {
                $this->db->where($where);
            }

            if(!empty($limit))
            {
                $this->db->limit($limit,$start);
            }
            $this->db->order_by('product.code','asc');
            //$this->db->group_by('product.productId');
            $response = $this->db->get();
            return $response->result();
        }
        public function add_product_inventory($organizationProductId,$inventory,$employeeId)
        {
            $this->db->set('currentQty', $inventory, FALSE);
            $this->db->set('lastModifiedBy',$employeeId);
            $this->db->set('lastModifiedDt',date('Y-m-d H:i:s'));
            $this->db->where('organizationProductId',$organizationProductId);
            $res=$this->db->update('organization_product');
            return $this->db->affected_rows();

        }
        public function organization_product_list($organizationId,$start,$limit,$where='')
        {
            $this->db->select('product.*,category.*,parent_category.categoryCode as parentCategoryCode,organization_product.*,concat("[",group_concat(concat("{discount:",discount.discount,",discountId:",discount.discountId,",title:\"",discount.title,"\" }")),"]") as discount',false);
            $this->db->from('organization_product');
            $this->db->join('product','product.productId=organization_product.productId');
            $this->db->join('product_category','product_category.productId=organization_product.productId');
            $this->db->join('organization_category as category','product_category.categoryId=category.categoryId','left');
            $this->db->join('organization_category as parent_category','category.parentCategoryId=parent_category.categoryId','left');
            $this->db->join('product_discount','product_discount.organizationProductId=organization_product.organizationProductId and product_discount.active=1','left');
            $this->db->join('discount','product_discount.discountId=discount.discountId and product_discount.active=1','left');
            $this->db->where('organization_product.organizationId',$organizationId);
            $this->db->group_by('organization_product.organizationProductId');
            $this->db->limit($limit,$start);
            if(!empty($where))
            {
                $this->db->where($where);
            }
            $query	=	$this->db->get();
            if(($query->num_rows())>0)
            {
                return $query->result();
            }
            else
            {
                return;
            }

        }
        public function organization_product_count($organizationId)
        {

            $this->db->select('count(organization_product.organizationProductId) as total');
            $this->db->from('organization_product');
            $this->db->join('product','product.productId=organization_product.productId');
            $this->db->join('product_category','product_category.productId=organization_product.productId');
            $this->db->join('organization_category as category','product_category.categoryId=category.categoryId','left');
            $this->db->join('organization_category as parent_category','category.parentCategoryId=parent_category.categoryId','left');
            $this->db->join('product_discount','product_discount.organizationProductId=organization_product.organizationProductId and product_discount.active=1','left');
            $this->db->join('discount','product_discount.discountId=discount.discountId and product_discount.active=1','left');
            $this->db->where('organization_product.organizationId',$organizationId);

            if(!empty($where))
            {
                $this->db->where($where);
            }
            $query	=	$this->db->get();
            if(($query->num_rows())>0)
            {
                return $query->row();
            }
            else
            {
                return;
            }

        }
        public function get_organization_product_id_list($organizationId)
        {
            $this->db->select('group_concat(distinct(organization_product.productId)) as productIdList');
            $this->db->from('organization_product');
            $this->db->join('product','product.productId=organization_product.productId');
            $this->db->join('product_category','product_category.productId=organization_product.productId');
            $this->db->join('organization_category as category','product_category.categoryId=category.categoryId','left');
            $this->db->join('organization_category as parent_category','category.parentCategoryId=parent_category.categoryId','left');
            $this->db->where('organization_product.organizationId',$organizationId);
            $query=$this->db->get();
            return $query->row();


        }
        public function get_product_details_from_upc($organizationId,$upc)
        {
            $this->db->select('product.*,category.*,parent_category.categoryCode as parentCategoryCode,organization_product.*,concat("[",group_concat(concat("{discount:",discount.discount,",discountId:",discount.discountId,",title:\"",discount.title,"\" }")),"]") as discount',false);
            $this->db->from('organization_product');
            $this->db->join('product','product.productId=organization_product.productId');
            $this->db->join('product_category','product_category.productId=organization_product.productId');
            $this->db->join('organization_category as category','product_category.categoryId=category.categoryId','left');
            $this->db->join('organization_category as parent_category','category.parentCategoryId=parent_category.categoryId','left');
            $this->db->where('organization_product.organizationId',$organizationId);
            $this->db->join('product_discount','product_discount.organizationProductId=organization_product.organizationProductId and product_discount.active=1','left');
            $this->db->join('discount','product_discount.discountId=discount.discountId and product_discount.active=1','left');
            $this->db->where('organization_product.upc',$upc);
            $this->db->group_by('organization_product.organizationProductId');
            $result=$this->db->get()->row();
            return $result;

        }

    }