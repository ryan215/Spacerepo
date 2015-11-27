<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_management_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function total_center_slider()
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('home_page_promotion');
		$this->db->where(array('position' => 'center','active' => 1));
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function center_slider_list($start=0,$limit='',$where='')
	{
		$this->db->where(array('position' => 'center','active' => 1));
		$result = $this->db->get('home_page_promotion');
		return $result->result();
	}
	
	public function total_left_slider()
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('home_page_promotion');
		$this->db->where(array('position' => 'left','active' => 1));
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function total_right_slider()
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('home_page_promotion');
		$this->db->where(array('position' => 'right','active' => 1));
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function left_section_list($start=0,$limit='',$where='')
	{
		$this->db->where(array('position' => 'left','active' => 1));
		$this->db->order_by('lastModifiedDt','DESC');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get('home_page_promotion');
		return $result->result();
	}
	
	public function right_section_list($start=0,$limit='',$where='')
	{
		$this->db->where(array('position' => 'right','active' => 1));
		$this->db->order_by('lastModifiedDt','DESC');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get('home_page_promotion');
		return $result->result();
	}
	
	public function add_slider($slider_image,$slider_link,$position)
	{
		$insertOpt = array(
						'position'       => $position,
						'url'		     => $slider_link,	
						'imageName'      => $slider_image,										
						'createDt'       => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('home_page_promotion',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function update_slider($homePagePromotionId,$slider_image,$slider_link)
	{
		$updateOpt = array(
						'url'		     => $slider_link,	
						'imageName'      => $slider_image,										
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->where('homePagePromotionId',$homePagePromotionId);
		$this->db->update('home_page_promotion',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function center_slider_details($homePagePromotionId)
	{
		$this->db->where(array('position' => 'center','homePagePromotionId' => $homePagePromotionId));
		$result = $this->db->get('home_page_promotion');
		return $result->row();
	}
	
	public function delete_center_slider($homePagePromotionId)
	{
		$this->db->where(array('position' => 'center','homePagePromotionId' => $homePagePromotionId));
		$this->db->update('home_page_promotion',array('active' => 0));
		return $this->db->affected_rows();
	}
	
	public function delete_left_slider($homePagePromotionId)
	{
		$this->db->where(array('position' => 'left','homePagePromotionId' => $homePagePromotionId));
		$this->db->update('home_page_promotion',array('active' => 0));
		return $this->db->affected_rows();
	}
	
	
	
	public function deactivate_left_slider()
	{
		$data=array('active' => 0);
		$this->db->where(array('position' => 'left'));
		$this->db->update('home_page_promotion',$data);
		return $this->db->affected_rows();
	}
	public function deactivate_right_slider()
	{
		$data=array('active' => 0);
		$this->db->where(array('position' => 'right'));
		$this->db->update('home_page_promotion',$data);
		return $this->db->affected_rows();
	}
	
	public function last_modified_slider()
	{
		$getOpt = array(
						'select' => 'slider.*,profile.first_name,profile.last_name',
						'table'  => 'slider',
						'order'  => array('slider.last_modified_date' => 'DESC'),
						'single' => true,
						'join'   => array('profile' => 'slider.last_modified_by = profile.user_id'),
					);
		return $this->common_model->customGet($getOpt);
	}
	
	public function slider_list() 
	{
		$getOpt = array(
	 				'table'	 =>	'slider',
					'select' =>	'*',
					'order'	 => array('last_modified_date' => 'DESC'),
	 			  );
		return $this->common_model->customGet($getOpt);	
	}
	
	
	
	
	
	public function slider_details($sliderID)
	{
		$getOpt = array(
	 				'table'	 =>	'slider',
					'select' =>	'*',
					'order'	 => array('last_modified_date' => 'DESC'),
					'single' => true,
					'where'  => array('slider_id' => $sliderID)
	 			  );
		return $this->common_model->customGet($getOpt);	
	}
	
	public function get_newsletter_details($email)
	{
		$this->db->where(array('email' => $email,'verified' => 1));
		$result = $this->db->get('newsletter');
		return $result->row();
	}
	
	public function get_newsletter_with_customer_details($email)
	{
		$this->db->where(array('email' => $email,'verified' => 1,'isMarketingUser' => 1));
		$result = $this->db->get('customer');
		return $result->row();
	}
}