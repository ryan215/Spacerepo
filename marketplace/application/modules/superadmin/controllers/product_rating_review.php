<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Product_rating_review extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->load->model('rating_review_m');
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Product_rating_review',
				'log_MID'    => '' 
		) );				
		
		$this->data['title'] = 'Product Rating Review List';
		$this->superAdminCustomView('product_rating_review/rating_review_list',$this->data);
	}
	 
	public function ajaxFun()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		));
		
		$perPage	       = $this->input->post('sel_no_entry');
		$reviewTitle	   = $this->input->post('reviewTitle');
		$reviewDescription = $this->input->post('reviewDescription');
		$where 		       = '';
		
		if(!empty($reviewTitle))
		{
			$where = 'product_review.reviewTitle Like "'.$reviewTitle.'%"';
		}
		if(!empty($reviewDescription))
		{
			if(!empty($where))
			{
				$where.= ' AND product_review.reviewDescription Like "'.$reviewDescription.'%"';
			}
			else
			{
				$where = 'product_review.reviewDescription Like "'.$reviewDescription.'%"';
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		//echo "<pre>"; print_r($_POST); exit;
		$total = $this->rating_review_m->total_products_rating_review($where);
		$pagConfig = array(
		   				'base_url'    => base_url().$this->session->userdata('userType').'/product_rating_review/ajaxFun/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $perPage,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
				  
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$this->data['links'] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['list']  = $this->rating_review_m->rating_review_list($page,$pagConfig['per_page'],$where);
		//echo "<pre>"; print_r($this->data['list']); exit;
		$this->load->view('product_rating_review/ajaxView',$this->data);
	}
		
	public function rating_review_detail($productRatingId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'rating_review_detail',
				'log_MID'    => '' 
		) );				
		
		$result = array(
					'imageName'   => '',
					'productName' => '',
					'firstName'   => '',
					'lastName'    => '',
					'email'		  => '',
					'reviewTitle' => '',
					'reviewDescription' => '',
					'phone' => '',
					'productRating1' => 0,
					'productRating2' => 0,
					'productRating3' => 0,
					'productRating4' => 0,
					'productRating5' => 0,
					'totalRating'	 => 0
				  );
		$productRatingId     = id_decrypt($productRatingId);
		$this->data['title'] = 'Product Rating Review Details';
		
		$details = $this->rating_review_m->product_rating_review_details($productRatingId);
		if(!empty($details))
		{
			$result['imageName']   = $details->imageName;
			$result['productName'] = $details->code;
			$result['firstName']   = $details->firstName;
			$result['lastName']    = $details->lastName;
			$result['email']       = $details->email;
			$result['reviewTitle'] = $details->reviewTitle;
			$result['reviewDescription'] = $details->reviewDescription;
			$result['phone'] = $details->phone;
			$result['productRating1'] = $details->productRating1;
			$result['productRating2'] = $details->productRating2;
			$result['productRating3'] = $details->productRating3;
			$result['productRating4'] = $details->productRating4;
			$result['productRating5'] = $details->productRating5;
			
			if($result['productRating1'])
			{
				$result['totalRating'] = 1;
			}
			elseif($result['productRating2'])
			{
				$result['totalRating'] = 2;
			}
			elseif($result['productRating3'])
			{
				$result['totalRating'] = 3;
			}
			elseif($result['productRating4'])
			{
				$result['totalRating'] = 4;
			}
			elseif($result['productRating5'])
			{
				$result['totalRating'] = 5;
			}
		}
		
		//echo "<pre>"; print_r($result); exit;
		$this->data['result'] = $result;
		$this->superAdminCustomView('product_rating_review/rating_review_detail',$this->data);
	}
	
	public function delete_rating_review($productRatingId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'delete_rating_review',
				'log_MID'    => '' 
		) );	
		
		$result = array();
		$productRatingId = id_decrypt($productRatingId);
		$this->custom_log->write_log('custom_log','product rating id is '.$productRatingId);
		if($productRatingId)
		{
			$details = $this->rating_review_m->product_rating_review_details($productRatingId);
			if(!empty($details))
			{
				$result['rating1'] = $details->productRating1;
				$result['rating2'] = $details->productRating2;
				$result['rating3'] = $details->productRating3;
				$result['rating4'] = $details->productRating4;
				$result['rating5'] = $details->productRating5;
				
				$productRatingCheck = $this->rating_review_m->check_rating_product($details->productId);
				$this->custom_log->write_log('custom_log','check rating product is '.print_r($productRatingCheck,true));	
				if(!empty($productRatingCheck))
				{
					$result['rating1'] = $productRatingCheck->productRating1-$result['rating1'];
					$result['rating2'] = $productRatingCheck->productRating2-$result['rating2'];
					$result['rating3'] = $productRatingCheck->productRating3-$result['rating3'];
					$result['rating4'] = $productRatingCheck->productRating4-$result['rating4'];
					$result['rating5'] = $productRatingCheck->productRating5-$result['rating5'];
					$this->rating_review_m->update_product_rating_count($details->productId,$result);
					if($this->rating_review_m->unactive_product_rating($productRatingId))
					{
						$this->rating_review_m->unactive_product_review($productRatingId);				
						$this->session->set_flashdata('success','Product Rating OR Review Deleted Successfully');
						$this->custom_log->write_log('custom_log','Product Rating OR Review Deleted Successfully');
					}
					else
					{
						$this->session->set_flashdata('error','Product Rating not delete');
						$this->custom_log->write_log('custom_log','Product Rating not delete');
					}					
				}
				else
				{
					$this->session->set_flashdata('error','Product Rating OR Review count details not found');
					$this->custom_log->write_log('custom_log','Product Rating OR Review count details not found');
				}
			}
			else
			{
				$this->session->set_flashdata('error','Product Rating OR Review details not found');
				$this->custom_log->write_log('custom_log','Product Rating OR Review details not found');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Product rating or review not found');
			$this->custom_log->write_log('custom_log','Product rating or review id not found');
		}
		redirect(base_url().'superadmin/product_rating_review');
	}
}