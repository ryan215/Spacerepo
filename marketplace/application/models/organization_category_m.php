<?php if(!defined ('BASEPATH'))
    exit( 'No direct script access allowed' );

    class Organization_category_m extends MY_Model
    {
        public function __construct()
        {
            parent::__construct ();
        }

        public function add_category($organization_id, $categoryCode, $categoryDescription = '', $image = '', $lastModifiedBy = '', $parentCategoryId = '')
        {
            $insertOpt = array(
                'categoryCode'        => $categoryCode,
                'organizationId'      => $organization_id,
                'categoryDescription' => $categoryDescription,
                'imageName'           => $image,
                'imagePath'           => 'uploads/category',
                'active'              => 1,
                'parentCategoryId'    => $parentCategoryId,
                'createDt'            => date ('Y-m-d H:i:s'),
                'lastModifiedDt'      => date ('Y-m-d H:i:s'),
                'lastModifiedBy'      => $lastModifiedBy

            );
            $this->db->insert ('organization_category', $insertOpt);
            return $this->db->insert_id ();
        }

        public function update_category($organization_id, $category_id, $categoryCode, $categoryDescription = '', $image = '', $lastModifiedBy = '', $parentCategoryId = '')
        {
            $insertOpt = array(
                'categoryCode'        => $categoryCode,
                'organizationId'      => $organization_id,
                'categoryDescription' => $categoryDescription,
                'imagePath'           => 'uploads/category',
                'active'              => 1,
                'parentCategoryId'    => $parentCategoryId,
                'createDt'            => date ('Y-m-d H:i:s'),
                'lastModifiedDt'      => date ('Y-m-d H:i:s'),
                'lastModifiedBy'      => $lastModifiedBy

            );
            if(!empty( $image )) {
                $insertOpt['imageName'] = $image;
            }
            $this->db->where ('categoryId', $category_id);
            $this->db->update ('organization_category', $insertOpt);
            return $this->db->affected_rows ();
        }

        public function category_listing($organizationId, $start, $limit,$where='',$parentCategoryId=0)
        {
            $this->db->select ('*');
            $this->db->from ('organization_category');
            $this->db->where ('organizationId', $organizationId);
            $this->db->where ('parentCategoryId',$parentCategoryId );
            $this->db->limit ($limit, $start);
            if(!empty($where))
            {
                $this->db->where($where);
            }
            $query = $this->db->get ();
            if(!empty( $query )) {
                return $query->result ();
            } else {
                return;
            }
        }

        public function total_category_listing($organizationId, $where = '')
        {
            $this->db->select ('count(*) as total');
            $this->db->from ('organization_category');
            $this->db->where ('organizationId', $organizationId);
            $this->db->where ('parentCategoryId', 0);
            $query = $this->db->get ();
            if(!empty( $query )) {
                return $query->row ()->total;
            } else {
                return;
            }
        }

        public function sub_category_listing($organizationId, $start, $limit, $where = '')
        {
            $this->db->select ('organization_category.*,parent.categoryCode as parentCategory');
            $this->db->from ('organization_category');
            $this->db->join ('organization_category as parent', 'parent.categoryId=organization_category.parentCategoryId');
            $this->db->where ('organization_category.organizationId', $organizationId);
            if(!empty( $where )) {
                $this->db->where ($where);
            }
            $this->db->where_not_in ('organization_category.parentCategoryId', 0);

            $this->db->limit ($limit, $start);
            $query = $this->db->get ();
            return $query->result ();
        }

        public function category_detail($categoryId, $organizationId)
        {
            $this->db->select ('*');
            $this->db->from ('organization_category');
            $this->db->where (array(
                'organizationId' => $organizationId,
                'categoryId'     => $categoryId
            ));
            $query = $this->db->get ();
            return $query->row ();

        }
		public function get_master_product_category_list()
		{
			$this->db->select('*');
			$this->db->from('category');
			$this->db->where('active',1);
			$this->db->where('parentCategoryId is NULL');
			$query=$this->db->get();
			return $query->result();
		}
			public function get_brand_list()
		{
			$this->db->select('*');
			$this->db->from('brand');
			$this->db->where('active',1);
			$query=$this->db->get();
			return $query->result();
		}

    }