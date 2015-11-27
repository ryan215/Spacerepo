<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Product_rating_review extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => ''
		) );
		$this->load->model('rating_review_m');
	}	
	
	public function write_review($productId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'write_review',
				'log_MID'    => '' 
		) );
		
		$productId           = id_decrypt($productId); 
		$userId				 = $this->session->userdata('userId');
		$this->data['title'] = 'Product Rating Review';		
		$this->custom_log->write_log('custom_log','product id is '.$productId.' and user id is '.$userId);
		$result = array(
				  		'reviewTitle'       => '',
						'reviewDescription' => '',
						'rating'			=> '',
						'productId'			=> $productId,
						'rating1'			=> 0,
						'rating2'			=> 0,
						'rating3'           => 0,
						'rating4'			=> 0,
						'rating5'			=> 0,
						'orderId'			=> 0,
						'productName'		=> '',
						'imageName'			=> '',
				  );
				  
		if(!$userId)
		{
			$this->session->set_flashdata('error',$this->lang->line('error_user_login'));
			$this->custom_log->write_log('custom_log',$this->lang->line('error_user_login'));
			redirect(base_url().'frontend/single/product_detail/'.id_encrypt($productId));
		}
		
		if(!$productId)
		{
			$this->session->set_flashdata('error','Product not select for rating or review');
			$this->custom_log->write_log('custom_log','Product not select for rating or review');
			redirect(base_url());
		}
		else
		{
			$productDetails = $this->product_m->product_details($productId);
			$this->custom_log->write_log('custom_log','Product details is '.print_r($productDetails,true));
			if(!empty($productDetails))
			{
				$result['productName'] = $productDetails->code;
				$result['imageName']   = $productDetails->imageName;
			}			
		}
		
		$checkTtl = $this->rating_review_m->total_customer_rating_review($productId);
		if($checkTtl)
		{
			$this->session->set_flashdata('error','You already added rating and review this product');
			$this->custom_log->write_log('custom_log','You already added rating and review this product');
			redirect(base_url().'frontend/single/product_detail/'.id_encrypt($productId));
		}
		
		if($_POST)
		{
			$this->custom_log->write_log('custom_log','Form submit data is '.print_r($_POST,true));
			$result['reviewTitle']       = $this->input->post('reviewTitle'); 
			$result['reviewDescription'] = $this->input->post('reviewDescription'); 
			$result['rating']            = $this->input->post('rating'); 
			$rules = product_rating_review();			
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run())
			{
				$rating = $result['rating'];
				if($rating==1)
				{
					$result['rating1'] = 1;
				}
				elseif($rating==2)
				{
					$result['rating2'] = 1;
				}
				elseif($rating==3)
				{
					$result['rating3'] = 1;
				}
				elseif($rating==4)
				{
					$result['rating4'] = 1;
				}
				elseif($rating==5)
				{
					$result['rating5'] = 1;
				}
				
				$orderDetails = $this->order_m->check_order_product($productId);
				$this->custom_log->write_log('custom_log','order details is '.print_r($orderDetails,true));
				if(!empty($orderDetails))
				{
					$result['orderId'] = $orderDetails->orderId;
				}
				
				$productRatingId = $this->rating_review_m->add_product_rating($productId,$result);
				$this->custom_log->write_log('custom_log','Product Rating id is '.$productRatingId);
				
				if($productRatingId)
				{
					$productReviewId = $this->rating_review_m->add_product_review($productRatingId,$result);
					$this->custom_log->write_log('custom_log','Product Review id is '.$productReviewId);
					if($productReviewId)
					{
						$productRatingCheck = $this->rating_review_m->check_rating_product($productId);
						$this->custom_log->write_log('custom_log','check rating product is '.print_r($productRatingCheck,true));
						if(!empty($productRatingCheck))
						{
							$result['rating1'] = $productRatingCheck->productRating1+$result['rating1'];
							$result['rating2'] = $productRatingCheck->productRating2+$result['rating2'];
							$result['rating3'] = $productRatingCheck->productRating3+$result['rating3'];
							$result['rating4'] = $productRatingCheck->productRating4+$result['rating4'];
							$result['rating5'] = $productRatingCheck->productRating5+$result['rating5'];
							$this->rating_review_m->update_product_rating_count($productId,$result);
							$this->custom_log->write_log('custom_log','Last updated query is '.$this->db->last_query());
						}
						else
						{
							$productRatCntId = $this->rating_review_m->add_product_rating_count($productId,$result);
							$this->custom_log->write_log('custom_log','product rating count id is '.$productRatCntId);
						}
										
						$this->session->set_flashdata('success','Product Rating and Review added Successfully');
						$this->custom_log->write_log('custom_log','Product Rating and Review added Successfully');
					}
					else
					{
						$this->session->set_flashdata('error','Product review not add');
						$this->custom_log->write_log('custom_log','Product review not add');
					}
				}
				else
				{
					$this->session->set_flashdata('error','Product rating not add');
					$this->custom_log->write_log('custom_log','Product rating not add');
				}
				redirect(base_url().'frontend/single/product_detail/'.id_encrypt($productId));
			}			
		}		
				
		$this->data['productId'] = $productId;
		$this->data['result']    = $result;		
		$this->frontendCustomView('product_rating_review/write_review',$this->data);
	}
	
	public function rating_review_list($productId=0,$rating=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'rating_review_list',
				'log_MID'    => '' 
		) );
		
		$productId = id_decrypt($productId); 
		$result	   = array(
					 	'productName' 	 => '',
						'avgRating'   	 => 0,
						'totalRating' 	 => 0,
						'productRating1' => 0,
						'productRating2' => 0,
						'productRating3' => 0,
						'productRating4' => 0,
						'productRating5' => 0,
					 );

		$this->data['title'] = 'Product Rating Review List';		
		$this->custom_log->write_log('custom_log','product id is '.$productId);
		
		if(!$productId)
		{
			$this->session->set_flashdata('error','Product not select for rating or review');
			redirect(base_url());
		}
		else
		{
			$productDetails = $this->product_m->product_details($productId);
			if(!empty($productDetails))
			{
				$result['productName'] = $productDetails->code;
			}			
		}
		
		$ratingReviewCount = $this->rating_review_m->check_rating_product($productId);
		if(!empty($ratingReviewCount))
		{
			$result['avgRating']   	  = $ratingReviewCount->avgProductRating;
			$result['totalRating'] 	  = $ratingReviewCount->totalProductRating;
			$result['productRating1'] = $ratingReviewCount->productRating1;
			$result['productRating2'] = $ratingReviewCount->productRating2;
			$result['productRating3'] = $ratingReviewCount->productRating3;
			$result['productRating4'] = $ratingReviewCount->productRating4;
			$result['productRating5'] = $ratingReviewCount->productRating5;
		}
		
		$ratingReviewList  = $this->rating_review_m->frontend_rating_review_list($productId,$rating);
		
		//echo "<pre>"; print_r($ratingReviewList); exit;
		$this->data['productId'] 	    = $productId;
		$this->data['ratingReviewList'] = $ratingReviewList;
		$this->data['result'] 			= $result;
		$this->frontendCustomView('product_rating_review/rating_review_list',$this->data);
	}
}