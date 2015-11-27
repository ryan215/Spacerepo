<?php if(!defined ('BASEPATH'))
    exit( 'No direct script access allowed' );

    class Api_discount_m extends MY_Model
    {
        public function __construct()
        {
            parent::__construct ();
        }

        public function add_discount($discountArr, $organizationId)
        {
            $insertOpt = array
            (
                'title'          => $discountArr['title'],
                'discount'       => $discountArr['discount'],
                'discountOn'     => $discountArr['discountOn'],
                'organizationId' => $organizationId,
                'discountType'   => 1,
                'active'         => 1,
                'createDt'       => date ('Y-m-d H:i:s'),
                'lastModifiedBy' => $discountArr['employeeId'],
                'lastModifiedDt' => date ('Y-m-d H:i:s'),
            );
            $this->db->insert ('discount', $insertOpt);
            return $this->db->insert_id ();
        }

        public function add_discount_history($discountHistoryArr, $productDiscountId)
        {
            $insertOption = array
            (
                'discountId'     => $productDiscountId,
                'createDt'       => date ('Y-m-d H:i:s'),
                'lastModifiedBy' => $discountHistoryArr['employeeId'],
                'lastModifiedDt' => date ('Y-m-d H:i:s'),
            );
            $this->db->insert ('product_discount_history', $insertOption);
            return $this->db->insert_id ();

        }

        public function add_product_discount($discountId, $productArr, $employeeId)
        {
            $discountIds = $this->get_discount_product_list ($discountId);
            $discountIds = explode (',', $discountIds->discountList);

            foreach ($productArr as $productDetail) {
                if(in_array ($productDetail->organizationProductId, $discountIds)) {

                } else {
                    $insertOpt[] = array(
                        'organizationProductId' => $productDetail->organizationProductId,
                        'discountId'            => $discountId,
                        'active'                => 1,
                        'createDt'              => date ('Y-m-d H:i:s'),
                        'lastModifiedBy'        => $employeeId,
                        'lastModifiedDt'        => date ('Y-m-d H:i:s'),
                    );
                }

            }
            if(isset( $insertOpt )) {
                $this->db->insert_batch ('product_discount', $insertOpt);
            }


            return $this->db->affected_rows ();
        }
        function get_discount_product_list($discountId)
        {
            $this->db->select ('group_concat(distinct(organization_product.organizationProductId)) as discountList');
            $this->db->from ('discount');
            $this->db->join ('product_discount', 'product_discount.discountId=discount.discountId and product_discount.active=1','left');
            $this->db->join ('organization_product', 'organization_product.organizationProductId=product_discount.organizationProductId', 'left');

            $this->db->where (
                array(
                    'discount.active'         => 1,
                    'discount.discountId'     => $discountId
                )
            );
            //$this->db->group_by('organization_product.organizationProductId');
            $query = $this->db->get ();

            return $query->row();

        }

        public function remove_product_discount($discountId, $productArr, $employeeId)
        {
            foreach ($productArr as $productDetail) {
                $insertOpt[] = array(
                    'organizationProductId' => $productDetail->organizationProductId,
                    //   'discountId'            => $discountId,
                    'active'                => 0,
                    'lastModifiedBy'        => $employeeId,
                    'lastModifiedDt'        => date ('Y-m-d H:i:s'),
                );
            }

            $this->db->where ('discountId', $discountId);
            $rs = $this->db->update_batch ('product_discount', $insertOpt, 'organizationProductId');
            return $this->db->affected_rows ();


        }

        public function get_discount_list($organizationId, $start = '', $limit = '', $where = '')
        {
            $this->db->select ('discount.*,count(product_discount.organizationProductId) as total');
            $this->db->from ('discount');
            $this->db->join ('product_discount', 'product_discount.discountId=discount.discountId and product_discount.active=1','left');
            //   $this->db->join ('organization_product', 'organization_product.organizationProductId=product_discount.productId', 'left');

            $this->db->where (
                array(
                    'discount.organizationId' => $organizationId,
                    //'discount.active'         => 1
                )
            );
            $this->db->group_by('discount.discountId');
            $this->db->limit ($limit, $start);

            $query = $this->db->get ();
            return $query->result ();

        }

        public function get_product_discount_list($organizationId, $discountId, $start = '', $limit = '', $where)
        {
            $this->db->select ('organization_product.*,product_discount.*,concat("[",group_concat(concat("{discount:",Discountvalue.discount,",discountId:",productDiscount.discountId,",title:\"",Discountvalue.title,"\" }")),"]") as discount',false);
            $this->db->from ('discount');
			 $this->db->join ('product_discount', 'product_discount.discountId=discount.discountId and product_discount.active=1');
            $this->db->join ('organization_product', 'organization_product.organizationProductId=product_discount.organizationProductId', 'left');
			$this->db->join ('product_discount as productDiscount', 'productDiscount.organizationProductId=organization_product.organizationProductId and productDiscount.active=1');
			 $this->db->join('discount as Discountvalue','productDiscount.discountId=Discountvalue.discountId','left');
         			
			$this->db->group_by('organization_product.organizationProductId');
            $this->db->where (
                array(
                    'discount.organizationId' => $organizationId,
                    'discount.active'         => 1,
                    'discount.discountId'     => $discountId
                )
            );
            if(!empty( $start ) || !empty( $limit )) {

                $this->db->limit ($limit, $start);
            }
            $query = $this->db->get ();
            return $query->result ();

        }

        public function change_status($discountArr)
        {
            $data = array
            (
                'active'         => $discountArr['activeStatus'],
                'lastModifiedBy' => $discountArr['employeeId'],
                'lastModifiedDt' => date ('Y-m-d H:i:s'),
            );
            $this->db->where (array
            (
                'organizationId' => $discountArr['organizationId'],
                'discountId'     => $discountArr['discountId']
            ));
            $this->db->update ('discount', $data);
            return $this->db->affected_rows ();
        }
        public function product_list_for_discount_id($organizationId,$employeeId,$discountId,$start,$limit,$where='')
        {
            $discountIds = $this->get_discount_product_list ($discountId);
            $discountIds = explode (',', $discountIds->discountList);
            // print_r($discountIds);
            $this->db->select('product.*,category.*,parent_category.categoryCode as parentCategoryCode,organization_product.*,concat("[",group_concat(concat("{discount:",discount.discount,",discountId:",discount.discountId,",title:\"",discount.title,"\" }")),"]") as discount',false);
            $this->db->from('organization_product');
            $this->db->join('product','product.productId=organization_product.productId');
            $this->db->join('product_category','product_category.productId=organization_product.productId');
            $this->db->join('organization_category as category','product_category.categoryId=category.categoryId','left');
            $this->db->join('organization_category as parent_category','category.parentCategoryId=parent_category.categoryId','left');
            $this->db->join('product_discount','product_discount.organizationProductId=organization_product.organizationProductId and product_discount.active=1','left');
            $this->db->join('discount','product_discount.discountId=discount.discountId','left');
            $this->db->where('organization_product.organizationId',$organizationId);
            $this->db->group_by('organization_product.organizationProductId');
            $this->db->where_not_in('organization_product.organizationProductId',$discountIds);

            //$this->db->where('discount.discountId !=', $discountId);
            $this->db->limit($limit,$start);
            if(!empty($where))
            {
                $this->db->where($where);
            }
            $query	=	$this->db->get();
            //echo $this->db->last_query();
            return $query->result();
        }

    }