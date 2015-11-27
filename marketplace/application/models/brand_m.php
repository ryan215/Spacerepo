<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class brand_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function brand_details($brandId)
	{
		$this->db->select('brandId,brandName,notes,active,imagePath,imageName,createDt,lastModifiedDt,lastModifiedBy');
		$this->db->from('brand');
		$this->db->where(array('brandId' => $brandId,'active' => 1));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function add_brand($addArr)
	{
		$insertOpt = array(
						'brandName'      => $addArr['brand_name'],	
						'imageName'		 => $addArr['brand_image'],	
						'notes'		     => $addArr['brandDescription'],	
						'imagePath'		 => base_url().'uploads/brand/',
						'createDt'       => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('brand',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function brand_update($brand_id,$updateArr)
	{
		$updateOpt = array(
						'brandName'      => $updateArr['brand_name'],	
						'imageName'		 => $updateArr['brand_image'],	
						'notes'		     => $updateArr['brandDescription'],
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('brandId',$brand_id);
		$this->db->update('brand',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function change_status($brandID,$status)
	{
		$this->db->where('brandId',$brandID);
		$this->db->update('brand',array('active' => $status));
		return $this->db->affected_rows();
	}
	
	public function check_brand_name($brandID,$brandName)
	{
		$this->db->where(array('brandId !=' => $brandID,'brandName' => $brandName));
		$result = $this->db->get('brand')->row();
		return $result;
	}
	
	
	public function total_brand_seg_cat()
	{
		$sql = "SELECT 
					COUNT(*) AS total 
				FROM 
					brand
				INNER JOIN
					segment
				ON
					brand.segment_id = segment.segment_id 
				INNER JOIN
					category
				ON
					brand.category_id = category.category_id
				";
		$result = $this->common_model->customQuery($sql,"single");
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function brand_seg_cat_list($start=0,$limit='',$where)
	{
		$limitstr = '';
		if(!empty($limit))
		{
			$limitstr = "LIMIT $start,$limit";
		}
		
		$sql = "SELECT 
					*
				FROM 
					brand
				INNER JOIN
					segment
				ON
					brand.segment_id = segment.segment_id 
				INNER JOIN
					category
				ON
					brand.category_id = category.category_id			
				".$where." 
				ORDER BY
					brand.last_modified_time	
				DESC
				".$limitstr;
		return $this->common_model->customQuery($sql);
	}
	
	public function total_brand($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('brand');
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
	
	public function total_brand_where($where='')
	{
		$sql = "SELECT COUNT(*) AS total FROM brand ".$where;
		$res = $this->common_model->customQuery($sql,'single');
		$total = 0;
		if(!empty($res))
		{
			$total = $res->total;
		}
		return $total;
	}
	
	public function brand_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('brand');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$this->db->order_by('brandName','ASC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function product_brand_list()
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('active',1);
		$this->db->order_by('brandName','ASC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function brand_insert($brand_name)
	{
		$insertOpt = array(
						'brandName'      => $brand_name,										
						'createDt'       => date('Y-m-d H:i:s'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					);
		$this->db->insert('brand',$insertOpt);
		return $this->db->insert_id();	
	}
	
	public function last_modified_brand()
	{
		$getOpt = array(
						'select' => 'brand.*,profile.first_name,profile.last_name',
						'table'  => 'brand',
						'order'  => array('brand.last_modified_time' => 'DESC'),
						'single' => true,
						'join'   => array('profile' => 'brand.last_modified_by = profile.user_id'),
					);
		return $this->common_model->customGet($getOpt);
	}
	
	
	
	public function update_brand_cat($brand_id,$segment_id='',$category_id='')
	{
		$updateOpt = array(
						'table' => 'brand',
						'data'  => array(
										'segment_id'         => $segment_id,
										'category_id'        => $category_id,
										'last_modified_by'   => $this->session->userdata('userId'),
										'last_modified_time' => $this->currentTimestamp,
									),
						'where' => array('brand_id' => $brand_id),
					);
		return $this->common_model->customUpdate($updateOpt);
	}
	
	
}