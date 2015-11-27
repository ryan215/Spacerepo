<?php
class Rating_review_m extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   	public function add_product_rating($productId,$addArr)
    {		
		$insertOpt = array(
						'productId'		 => $productId,
						'active'     	 => 1,
						'productRating1' => $addArr['rating1'],
						'productRating2' => $addArr['rating2'],
						'productRating3' => $addArr['rating3'],
						'productRating4' => $addArr['rating4'],
						'productRating5' => $addArr['rating5'],
						'orderId'        => $addArr['orderId'],
						'createDt'		 => date('Y-m-d H:i:s'),
						'createdBy' 	 => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('product_rating',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_product_review($productRatingId,$addArr)
    {		
		$insertOpt = array(
						'productRatingId'	=> $productRatingId,
						'productId'		 	=> $addArr['productId'],
						'reviewTitle'   	=> $addArr['reviewTitle'],
						'reviewDescription'	=> $addArr['reviewDescription'],
						'active'     	 	=> 1,
						'createDt'		 	=> date('Y-m-d H:i:s'),
						'createdBy' 		=> $this->session->userdata('userId'),
						'lastModifiedDt' 	=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 	=> $this->session->userdata('userId'),
					 );
		$this->db->insert('product_review',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function total_customer_rating_review($productId)
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_rating');
		$this->db->join('product_review','product_rating.productRatingId = product_review.productRatingId');
        $this->db->where(array(
							'product_rating.productId' => $productId,
							'product_rating.createdBy' => $this->session->userdata('userId'),
							'product_rating.active'	   => 1,
							'product_review.active'	   => 1,
						));
        $result = $this->db->get()->row();
		$total  = 0;
        if(!empty($result)) 
		{
        	$total = $result->total;
        }
        return $total;
    }
	
	public function check_rating_product($productId)
    {
        $this->db->where(array('productId' => $productId,'active' => 1));
		$this->db->order_by('lastModifiedDt','DESC');
        $result = $this->db->get('product_rating_count')->row();
        return $result;
    }

	public function add_product_rating_count($productId,$addArr)
    {
		$totalRating = total_rating($addArr['rating1'],$addArr['rating2'],$addArr['rating3'],$addArr['rating4'],$addArr['rating5']);
		$avgRating = total_avrage_rating($addArr['rating1'],$addArr['rating2'],$addArr['rating3'],$addArr['rating4'],$addArr['rating5']);
		
		$insertOpt = array(
						'productId' 		 => $productId,
						'active' 			 => 1,
						'productRating1' 	 => $addArr['rating1'],
						'productRating2' 	 => $addArr['rating2'],
						'productRating3' 	 => $addArr['rating3'],
						'productRating4' 	 => $addArr['rating4'],
						'productRating5' 	 => $addArr['rating5'],
						'totalProductRating' => $totalRating,
						'avgProductRating'   => $avgRating, 
						'lastModifiedDt' 	 => date('Y-m-d H:i:s'),
						'lastModifiedBy' 	 => $this->session->userdata('userId'),
					 );
		$this->db->insert('product_rating_count',$insertOpt);
		return $this->db->insert_id();
	}
    
	public function update_product_rating_count($productId,$updateArr)
    {
		$totalRating = total_rating($updateArr['rating1'],$updateArr['rating2'],$updateArr['rating3'],$updateArr['rating4'],$updateArr['rating5']);
		$avgRating = total_avrage_rating($updateArr['rating1'],$updateArr['rating2'],$updateArr['rating3'],$updateArr['rating4'],$updateArr['rating5']);
		
		$updateOpt = array(
						'productRating1' 	 => $updateArr['rating1'],
						'productRating2' 	 => $updateArr['rating2'],
						'productRating3' 	 => $updateArr['rating3'],
						'productRating4' 	 => $updateArr['rating4'],
						'productRating5' 	 => $updateArr['rating5'],
						'totalProductRating' => $totalRating,
						'avgProductRating'   => $avgRating, 
						'lastModifiedDt' 	 => date('Y-m-d H:i:s'),
						'lastModifiedBy' 	 => $this->session->userdata('userId'),
					 );
		$this->db->where(array('productId' => $productId,'active' => 1));
		$this->db->update('product_rating_count',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function top10_rating_review_list($productId)
	{		
        $this->db->select('customer.firstName,customer.lastName,product_review.*,product_rating.*,order.orderId AS ordersId');
        $this->db->from('product_rating');
		$this->db->join('product_review','product_rating.productRatingId = product_review.productRatingId');
		$this->db->join('customer','product_rating.createdBy = customer.customerId');
		$this->db->join('product','product_rating.productId = product.productId');
		$this->db->join('organization_product','product.productId = organization_product.productId');
		$this->db->join('order','organization_product.organizationProductId = order.organizationProductId AND order.customerId = product_rating.createdBy AND order.active = 1','left');
        $this->db->where(array(
							'product_rating.productId' => $productId,
							'product_rating.active'	   => 1,
							'product_review.active'	   => 1,
						));
		$this->db->order_by('product_rating.productRatingId','DESC');				
		$this->db->limit(10);
        $result = $this->db->get()->result();
		return $result;    
	}
	
	public function total_products_rating_review($where = '')
    {		
        $this->db->select('COUNT(*) AS total');
        $this->db->from('product_rating');
		$this->db->join('product_review','product_rating.productRatingId = product_review.productRatingId');
        $this->db->where(array(
							'product_rating.active'	=> 1,
							'product_review.active'	=> 1,
						));
        $result = $this->db->get()->row();
		$total  = 0;
        if(!empty($result)) 
		{
        	$total = $result->total;
        }
        return $total;
    }
	
	public function rating_review_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
        $this->db->from('product_rating');
		$this->db->join('product_review','product_rating.productRatingId = product_review.productRatingId');
        $this->db->where(array(
							'product_rating.active'	=> 1,
							'product_review.active'	=> 1,
						));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		
		$this->db->order_by('product_rating.lastModifiedDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
        $result = $this->db->get()->result();
		return $result;
	}
	
	public function product_rating_review_details($productRatingId)
	{		
		$this->db->select('customer.firstName,customer.lastName,customer.email,customer.phone,product_review.*,product_rating.*,product.code,product_image.imageName');
        $this->db->from('product_rating');
		$this->db->join('product_review','product_rating.productRatingId = product_review.productRatingId');
		$this->db->join('customer','product_rating.lastModifiedBy = customer.customerId');
		$this->db->join('product','product_rating.productId = product.productId');
		$this->db->join('product_image','product_rating.productId = product_image.productId');
        $this->db->where(array(
							'product_rating.productRatingId' => $productRatingId,
							'product_rating.active'			 => 1,
							'product_review.active'			 => 1,
							'product_image.displayOrder' 	 => 1,						
						));
		$result = $this->db->get()->row();
		return $result;
	
	}
	
	public function unactive_product_rating($productRatingId)
	{
		$updateOpt = array(
						'active' 	     => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('productRatingId',$productRatingId);
		$this->db->update('product_rating',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function unactive_product_review($productRatingId)
	{
		$updateOpt = array(
						'active' 	     => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('productRatingId',$productRatingId);
		$this->db->update('product_review',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function frontend_rating_review_list($productId,$rating=0)
	{				
        $this->db->select('customer.firstName,customer.lastName,product_review.*,product_rating.*,order.orderId AS ordersId');
        $this->db->from('product_rating');
		$this->db->join('product_review','product_rating.productRatingId = product_review.productRatingId');
		$this->db->join('customer','product_rating.createdBy = customer.customerId');
		$this->db->join('product','product_rating.productId = product.productId');
		$this->db->join('organization_product','product.productId = organization_product.productId');
		$this->db->join('order','organization_product.organizationProductId = order.organizationProductId AND order.customerId = product_rating.createdBy AND order.active = 1','left');
        $this->db->where(array(
							'product_rating.productId' => $productId,
							'product_rating.active'	   => 1,
							'product_review.active'	   => 1,
						));
		if($rating==1)
		{
			$this->db->where('product_rating.productRating1',1);	
		}
		elseif($rating==2)
		{
			$this->db->where('product_rating.productRating2',1);	
		}
		elseif($rating==3)
		{
			$this->db->where('product_rating.productRating3',1);	
		}
		elseif($rating==4)
		{
			$this->db->where('product_rating.productRating4',1);	
		}
		elseif($rating==5)
		{
			$this->db->where('product_rating.productRating5',1);	
		}
		$this->db->group_by('product_rating.productRatingId');
		$this->db->order_by('product_rating.productRatingId','DESC');				
		$result = $this->db->get()->result();
		return $result;    	
	}
}